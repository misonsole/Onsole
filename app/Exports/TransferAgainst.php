<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransferAgainst implements FromCollection, WithHeadings
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
            'Department',
            'Season',
            'Item Code',
            'Item Desc',
            'Trans Qty' ,
            'Trans Rate' ,
            'Trans Amount',
            'JO Qty',
            'JO Rate',
            'JO Amount',
            'Diff Qty',
            'Diff Amount',
        ];
    }
}
