<?php

namespace App\Exports;

use App\Models\User;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class UserExport implements FromCollection, ShouldAutoSize, WithMapping, WithHeadings, WithColumnFormatting
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::all();
    }

    public function map($user): array
    {
        return [$user->id, $user->name, $user->email, $user->role, Date::dateTimeToExcel($user->created_at)];
    }

    public function headings(): array
    {
        return ['id', 'Ime', 'Email', 'Uloga', 'Registrovan'];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_NUMBER,
            'E' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }
}
