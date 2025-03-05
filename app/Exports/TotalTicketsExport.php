<?php

namespace App\Exports;

use App\Models\Screening;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class TotalTicketsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Screening::with('ticket')
        ->select(DB::raw('HOUR(start_time) as hour'), DB::raw('COUNT(tickets.id) as total_tickets'))
        ->join('tickets', 'screenings.id', '=', 'tickets.screening_id')
        ->groupBy(DB::raw('HOUR(start_time)'))
        ->orderBy('total_tickets', 'desc')
        ->get();
    }

    public function headings(): array
    {
        return [
            'Hora da sessão',
            'Total de bilhetes vendidos'
        ];
    }
}