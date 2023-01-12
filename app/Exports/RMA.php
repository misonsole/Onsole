<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RMA implements FromCollection, WithHeadings
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
            'RMA No',
            'RMA Date',
            'Customer',
            'Item Code',
            'Item Desc',
            'Book',
            'Invoice',
            'Date',
            'RMA Qty',
            'INV Qty',
            'RMA Amount',
            'INV Amount',
        ];
    }
}
