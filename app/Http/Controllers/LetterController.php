<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\LetterType;
use App\Models\Letter;
use App\Models\User;
use App\Models\Result;
// use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LetterExport;
use Illuminate\Http\Request;
use PDF;
use Excel;

class LetterController extends Controller
{

    public function export() {
        return Excel::download(new LetterExport, 'Data Surat.xlsx');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $query = Letter::with('user');
        // $letter = $query->simplePaginate(10);
        $letter = Letter::with('letterType', 'user')->get();
        
        // $data = LetterType::all();
        // dd($letter);
        
        return view('surat.index', compact('letter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // $letter = Letter::all();
        // return view('data.datasurat.create');

        $guru = User::all()->where('role', 'guru');
        $data = LetterType::all();

        return view('surat.create', compact('data','guru'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    

    $arrayDistinct = array_count_values($request->recipients);
    $arrayAssoc = [];

    foreach ($arrayDistinct as $id => $count) {
        $user = User::find($id);

        // Periksa apakah pengguna ditemukan sebelum mengakses properti 'name'
        if ($user) {
            $arrayItem = [
                "id" => $id,
                "name" => $user->name,
            ];

            array_push($arrayAssoc, $arrayItem);
        }
    }

    $request['recipients'] = $arrayAssoc;

    // dd($request->all(), $arrayAssoc);

    $process = Letter::create([
        'letter_perihal' => $request->letter_perihal,
        'letter_type_id' => $request->letter_type_id ,
        // . '/000' . $id . '/SMK Wikrama/XII/' . date('Y')
        'content' => $request->content,
        'recipients' => $request->recipients,
        'attachment' => $request->attachment,
        'notulis' => $request->notulis
    ]);
    
    if ($process) {
        // Assuming you want to find the latest created letter
        $letter = Letter::where('letter_type_id', $request->letter_type_id)
                        ->orderBy('created_at', 'DESC')
                        ->first();
    
        return redirect()->route('surat.home')->with('success', 'Surat berhasil dibuat');
    }
    }

    /**
     * Display the specified resource.
     */
    public function show(Letter $letter, $id)
    {
        $guru = User::all()->where('role', 'guru');
        $letter = Letter::find($id);
        return view('surat.print', compact('letter', 'guru'));
    }

    public function detail($id)
    {
        $result = Result::where('letter_id', $id)->first();

        $user = User::Where('role', 'guru')->get();

        $letter = Letter::find($id);
        return view('surat.show', compact('letter', 'user', 'result'));
    }

    public function downloadPDF($id) 
    { 
        $letter = Letter::find($id); 
        if (!$letter) {
            return response()->json(['error' => 'Surat tidak ditemukan'], 404);
        }
        view()->share('letter', $letter); 
        $pdf = PDF::loadView('surat.downloadpdf', compact('letter')); 
        return $pdf->download('letter.pdf'); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Letter $letters, $id)
    {

        $letter= LetterType::all();

        $surat = Letter::findOrFail($id);

        $user = User::where('role', 'guru')->get(['id', 'name']);

        
        return view('surat.edit', compact('letter', 'user', 'surat'));

    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Letter $letters, $id)
    {
        //
        $recipients = $request->recipients ?? [];

        $arrayDistinct = array_count_values($recipients);
        $arrayAssoc = [];
    
        foreach ($arrayDistinct as $userId => $count) {
            $user = User::find($userId);
    
            // Periksa apakah pengguna ditemukan sebelum mengakses properti 'name'
            if ($user) {
                $arrayItem = [
                    "id" => $userId,
                    "name" => $user->name,
                ];
    
                array_push($arrayAssoc, $arrayItem);
            }
        }
    
        $request['recipients'] = $arrayAssoc;
    
        // Update data surat dengan data baru
        $letters->where('id', $id)->update([
            'letter_perihal' => $request->letter_perihal,
            'letter_type_id' => $request->letter_type_id,
            'content' => $request->content,
            'recipients' => $request->recipients,
            'attachment' => $request->attachment,
            'notulis' => $request->notulis
        ]);
    
        return redirect()->route('surat.home')->with('success', 'Berhasil Mengubah Data');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        Letter::where('id', $id)->delete();
        return redirect()->back()->with('deleted', 'Berhasil menghapus data!');
    }
}