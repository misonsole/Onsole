<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Transfer implements FromCollection, WithHeadings
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
            'Trans Date',
            'Trans No',
            'From',
            'To',
            'Item Code',
            'Item Description',
            'Reference',
            'Remarks',
            'Det Remarks',
            'Unit',
            'Quantity',
            'Rate',
            'Amount',
        ];
    }
}
