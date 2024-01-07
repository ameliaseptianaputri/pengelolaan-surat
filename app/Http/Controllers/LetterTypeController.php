<?php

namespace App\Http\Controllers;

use App\Models\LetterType;
use PDF;
use Excel;
use App\Models\User;
use App\Models\Letter;
use App\Exports\KlasifikasiExport;
// use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class LetterTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $let = LetterType::paginate(10);
    
        if ($request->has('data')) {
            $data = $request->data;
            $let = LetterType::where('letter_code', 'like', "%$data%")
                ->orWhere('name_type', 'like', "%$data%")
                ->paginate(10);
        }
    
        return view('klasifikasi.index', compact('let'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('klasifikasi.create');
        return view('klasifikasi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'letter_code' => 'required|unique:letter_types',
            'name_type' => 'required',
        ]);

        $LetterType = LetterType::count();

        LetterType::create([
            'letter_code' => $request->letter_code . '-' . $LetterType,
            'name_type' => $request->name_type
        ]);

        $letterTypes = LetterType::count();
        
        return redirect()->route('klasifikasi.home')->with('success', 'Data Klasifikasi Surat berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $guru = User::all()->where('role', 'guru');
        $detail = LetterType::all();
        return view('klasifikasi.show', compact('detail', 'guru'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $letters = LetterType::find($id);
        return view('klasifikasi.edit', compact('letters'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $letters = LetterType::find($id);

        $request->validate([
            'letter_code' => 'required',
            'name_type' => 'required',
        ]);

        if($request->password){
            $letters->update([
                'letter_code' => $request->letter_code,
                'name_type' => $request->name_type,
            ]);
        }else{
            $letters->update([
                'letter_code' => $request->letter_code,
                'name_type' => $request->name_type,
            ]);
        }
        return redirect()->route('klasifikasi.home')->with('success', 'Berhasil mengubah data Data Klasifikasi!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LetterType::where('id', $id)->delete();
        return redirect()->route('klasifikasi.home')->with('error', 'Berhasil menghapus Data Klasifikasi!');
    }

    public function downloadPDF($id) 
    { 
        $letterType = LetterType::find($id); 

            if (!$letterType) {
            return response()->json(['error' => 'Surat tidak ditemukan'], 404);
        }
    
        view()->share('let', $letterType); 
    
        $pdf = PDF::loadView('.klasifikasi.downloadpdf'); 
    
        return $pdf->download($letterType->name_type . '.pdf'); 
    }
    public function exportExcel()
    {
        $file_name = 'Data_Klasifikasi' . ".xlsx";
        return Excel::download(new KlasifikasiExport, $file_name);
    }

}