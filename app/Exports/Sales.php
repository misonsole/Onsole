<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Sales implements FromCollection, WithHeadings
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
            'SR. No',
            'Agent',
            'Season',
            'Region',
            'Customer Category',
            'Customer',
            'NTN No',
            'Invoice NO',
            'Invoice Date',
            'SO No',
            'DC No',
            'Cust PO No',
            'Book',
            'Item Code',
            'Item Description',
            'Qty',
            'Rate',
            'Tax%',
            'Amount',
            'Tax',
            'Total Amount',
        ];
    }
}
