<?php

namespace App\Exports;

use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class PaymentTypesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Purchase::select('payment_type', DB::raw('COUNT(*) as count'))
            ->groupBy('payment_type')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Tipo de Pagamento',
            'Total'
        ];
    }
}

