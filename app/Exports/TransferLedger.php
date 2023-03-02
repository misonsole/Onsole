<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransferLedger implements FromCollection, WithHeadings
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
            'In',
            'Out',
            'Rate',
            'Amount',
        ];
    }
}
