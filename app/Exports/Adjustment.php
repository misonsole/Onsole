<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Adjustment implements FromCollection, WithHeadings
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
            'Adj No',
            'Adj Date',
            'Remarks',
            'SR NO',
            'Item Code',
            'Item Description',
            'Unit',
            'Quantity',
            'Rate',
            'Amount',
            'Contra A/C Code',
        ];
    }
}
