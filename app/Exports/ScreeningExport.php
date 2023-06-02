<?php

namespace App\Exports;

use App\Models\Screening;
use App\Models\Ticket;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class ScreeningExport implements FromQuery, ShouldAutoSize, WithMapping, WithHeadings, WithColumnFormatting
{
    use Exportable;
    private $screening;

    public function __construct(Screening $screening)
    {
        $this->screening = $screening;
    }

    public function query()
    {
        return Ticket::query()
            ->with('screening.movie', 'screening.hall', 'user')
            ->where('screening_id', $this->screening->id);
    }

    public function map($ticket): array
    {
        return [
            $ticket->id,
            $ticket->screening->movie->title,
            $ticket->screening->hall->name,
            Date::dateTimeToExcel($ticket->screening->time),
            $ticket->price,
            $ticket->user->name,
            $ticket->user->email,
            Date::dateTimeToExcel($ticket->created_at),
        ];
    }

    public function headings(): array
    {
        return ['id', 'Film', 'Sala', 'Vreme', 'Cena', 'Korisnik', 'Email', 'Kupljeno'];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_DATE_DATETIME,
            'E' => '0 [$RSD]',
            'H' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }
}
