<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Material implements FromCollection, WithHeadings
{
    protected $data;
  
    public function __construct($data)
    {
        $this->data = $data;
    }
  
    public function collection()
    {
        return collect($this->data);
    }
  
    public function headings() :array
    {
        return [
            'Issue Date',
            'So No',
            'Season',
            'Issue No',
            'Reason',
            'Department',
            'Remarks',
            'Prod Qty',
            'Locator',
            'Article',
            'Item Code',
            'Item Code Description',
            'Unit',
            'Quantity',
            'Rate',
            'Amount',
            'Quantity',
            'Category Code',
            'Category Description',
            'Contra A/C Code',
            'Contra A/C DESC',
        ];
    }
}
