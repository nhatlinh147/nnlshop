<?php

namespace App\Exports;

use App\Model\Product;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Exportable;

class ExportExcelProduct implements FromView, ShouldQueue
{
    use Exportable;

    public function view(): View
    {
        return view('exportimport.product-excel', [
            'products' => Product::all()
        ]);
    }
    public function prepareRows($rows)
    {
        return $rows->transform(function ($Product) {
            $Product->name .= ' (prepared)';

            return $Product;
        });
    }
}