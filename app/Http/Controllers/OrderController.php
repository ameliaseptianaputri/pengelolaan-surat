<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Excel;
use App\Exports\OrdersExport;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //mengambil seluruh data pada tabel orders dengan pagination per halaman 10 data serta mengambil hasil data relasi function bernama user pada model Order
        // $orders = Order::with('user')->simplePaginate(10);
        // return view("order.kasir.index", compact("orders"));

        $query = Order::with('user');

        if ($request->has('tanggal_filter')) {
            $tanggalFilter = $request->tanggal_filter;
            $query->whereDate('created_at', $tanggalFilter);
        }

        $orders = $query->simplePaginate(10);

        if(Auth::user()->role=='admin'){
            return view("order.admin.index", compact('orders'));
        }else{
            return view("order.kasir.index", compact("orders"));
        }

       
        
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $medicines = Medicine::all();
        return view("order.kasir.create", compact('medicines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_customer' => 'required',
            'medicines' => 'required',
        ]);
        //mencari jumlah item yang sama padaarray, strukturnya:
        //["item"=>jumlah]
        $arrayDistinct = array_count_values($request->medicines);
        //menyiapkan array kosong untuk menampung format array baru
        $arrayAssocMedicines = [];
        //looping hasil penghitungan item distinct (duplikat)
        //key akan berupa value dari input medicines (id), item array berupa jumlah penghitungan item duplikat
        foreach ($arrayDistinct as $id => $count){
            //mencari data obat berdasarkan id (obat yang dipilih)
            $medicine = Medicine::where('id', $id)->first();
            //ambil bagian coloum price dari hasil pencarian lalu kalikan dengan jumlah item duplikat sehingga akan menghasilkan total harga dari pembelian obat tersebut
            $subPrice = $medicine['price'] * $count;
            //struktur value coloum medicines menjadi multidimensi dengan dimensi ke2 berbentuk array assoc dengan key "id", "name_medicine", "qty, "price"
            $arrayItem = [
                "id" => $id,
                "nama_medicine" => $medicine['name'],
                "qty" => $count,
                "price" => $medicine['price'],
                "sub_price" => $subPrice,
            ];
            //masukan struktur array tersebut ke array kosong yang disediakan sebelumnya
            array_push($arrayAssocMedicines, $arrayItem);
        }
        //total harga pembelian dari obat-obat yang dipilih
        $totalPrice = 0;
        //looping format array medicines baru
        foreach ($arrayAssocMedicines as $item){
            //total harga pembelian ditambahkan dari keseluruhan sub_price data medicines
            $totalPrice += (int)$item['sub_price'];
        }
        //harga beli ditambah 10%ppn
        $priceWithPPN = $totalPrice + ($totalPrice * 0.01);
        //tambah data ke database
        $proses = Order::create([
            //data user_id diambil dari id akun kasiryang sedang login
            'user_id' => Auth::user()->id,
            'medicines' => $arrayAssocMedicines,
            'name_customer' => $request->name_customer,
            'total_price' => $priceWithPPN,
        ]);

        if ($proses) {
            //jika proses tambah data berhasil, ambil data order yang dibuat oleh kasir yang sedang login(where), dengan tanggal paling terbaru (orderBy), ambil hanya satu data(first)
            $order = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->first();
            //kirim data order yang diambil tadi, bagian coloumn id sebagai parameter path dari route print
            return redirect()->route('kasir.order.print', $order['id']);
        }else{
            //jika tidak berhasil, maka diarahkan kembali ke halaman form dengan pesan pemberitahuan
            return redirect()->back()->with('failed', 'Gagal membuat data pembelian. Silahkan coba kembali dengan data yang sesuai!');
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::find($id);
        return view('order.kasir.print', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function downloadPDF($id)
    {
        //ambil data yang diperlukan dan pastikan data berformat array
        $order = Order::find($id)->toArray();
        //mengirim inisial variable dari data a=yang akan digunakan pada layout pdf
        view()->share('order', $order);
        //panggil blade yang akan di download
        $pdf = PDF::loadView('order.kasir.download-pdf', $order);
        //kembalikan atau hasilkan bentuk pdf dengannama file tertentu
        return $pdf->download('receipt.pdf');
    }

    public function data()
    {
        //with : mengambil hasil relasi dari PK dan FK nya. valuenya == nama func relasi hasMany/belongsTo yang ada di modelnya
        $orders = Order::with('user')->simplePaginate(10);
        return view("order.admin.index", compact('orders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function exportExcel()
    {
        $file_name = 'data_pembelian'.'.xlsx';

        return Excel::download(new OrdersExport, $file_name);
    }
}