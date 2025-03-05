<?php

namespace App\Exports;

use App\Models\Screening;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class ScreeningsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Screening::with(['movie', 'ticket.purchase'])
            ->whereHas('ticket.purchase')
            ->join('movies', 'screenings.movie_id', '=', 'movies.id')
            ->join('theaters', 'screenings.theater_id', '=', 'theaters.id')
            ->orderBy('screenings.date')
            ->orderBy('screenings.start_time')
            ->select('movies.title as movie_title', 'screenings.date', 'screenings.start_time', 'theaters.name as theater_name')
            ->get();
    }
    

    public function headings(): array
    {
        return [
            'Filme',
            'Dia da Sessão',
            'Hora da Sessão',
            'Teatro',
            'Bilhetes Vendidos'
        ];
    }

    public function map($screening): array
    {
        return [
            $screening->movie_title,
            $screening->date,
            $screening->start_time,
            $screening->theater_name,
            $screening->tickets_sold_count
        ];
    }
}
