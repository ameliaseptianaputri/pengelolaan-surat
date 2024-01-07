<?php

namespace App\Exports;

use App\Models\Letter;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LetterExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Letter::with('letterType', 'user')->get();
    }

    public function headings(): array
    {
        return [
            "Nomor Surat", "Perihal", "Tanggal Keluar", "Penerima Surat", "Notulis"
        ];
    }

    public function map($item): array
    {
        
        return [
            $item->letterType->letter_code,
            $item->letter_perihal,
            $item->created_at,
            $item->recipients,
            $item->user->name,
        ];
    }
}