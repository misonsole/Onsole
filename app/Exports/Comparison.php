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
            'Job Order Qty',
            'Planned Qty',
            'Planned Rate',
            'Planned Amount',
            'Actual Qty',
            'Actual Rate',
            'Actual Amount',
            'Production Qty',
            'Consumption Per Pair',
            'Est Qty',
            'Diff P vs A',
            'Diff A vs E',
            'Diff Amount',
        ];
    }
}
