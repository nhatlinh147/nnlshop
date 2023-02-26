<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class FailureExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    use Exportable;

    protected $failures;

    public function __construct(Collection $failures)
    {
        $this->failures = $failures->map(function ($failure) {
            return array_merge(
                ['error' => implode(',', $failure->errors())],
                $failure->values()
            );
        });
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return array_keys($this->failures->first());
    }

    public function collection()
    {
        return $this->failures;
    }
}
