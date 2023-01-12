<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Purchase implements FromCollection, WithHeadings
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
            'Financial Year',
            'Period',
            'Item Code',
            'Item Description',
            'Purchase Date',
            'Amount',
            'Primary Qty',
            'Pro Expense',
            'STAX Amount',
            'Total Amount',
            'Rate',
        ];
    }
}
