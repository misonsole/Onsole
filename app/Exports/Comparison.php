<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Comparison implements FromCollection, WithHeadings
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
            'Job Order',
            'Customer',
            'Sale Order',
            'Article',
            'Delivery Date',
            'Department',
            'Season',
            'Item Code',
            'Item Desc',
            'Act Qty',
            'Act Rate',
            'Act Amount',
            'Prod Qty',
            'Cons AS Per QTY',
            'JO Qty',
            'Cons Per Pair',
            'Est Qty',
            'Est Rate',
            'Est Amount',
            'Diff Qty',
            'Diff Qtyy',
            'Diff Amount',
        ];
    }
}
