<?php

namespace App\Imports;

use App\Imports\ImportExcelProduct;

class MultisheetProductsImport extends ImportExcelProduct implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Contacts' => new ImportExcelProduct()
        ];
    }
}