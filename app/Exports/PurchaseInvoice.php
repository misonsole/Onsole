<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PurchaseInvoice implements FromCollection, WithHeadings
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
            'Book',
            'P Inv No',
            'P Inv Date',
            'Supplier Category',
            'Supplier',
            'Payment Term',
            'GRN No',
            'GRN Date',
            'SR. No',
            'Item Code',
            'Item Desc',
            'Qty',
            'Rate',
            'Exl Tax Amount',
            'Sales Tax %',
            'Sales Tax Amount',
            'Inc Tax Amount',
            'Exp Prorate',
            'Exp PR',
            'Category Code',
            'Category Description',
        ];
    }
}
