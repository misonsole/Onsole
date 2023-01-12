<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PurchaseOrder implements FromCollection, WithHeadings
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
            'Po. No',
            'Po Date',
            'Supplier Category',
            'Supplier',
            'Purchaser',
            'Payment Term',
            'Po Status',
            'Po Type',
            'Item Code',
            'Item Desc',
            'Qty',
            'Rate',
            'Amount',
            'Sales Tax %',
            'Sales Tax Amount',
            'Total Amount',
            'Category Code',
            'Category Description',
        ];
    }
}
