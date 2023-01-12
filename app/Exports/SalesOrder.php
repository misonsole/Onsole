<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesOrder implements FromCollection, WithHeadings
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
            'Sr. No',
            'Profuct Category',
            'So Date',
            'Customer Category',
            'Customer',
            'Sales Person',
            'Season',
            'Payment Term',
            'Customer PO' ,
            'Delivery Date',
            'Status' ,
            'Article',
            'Item Code',
            'Item Desc',
            'Qty',
            'Rate',
            'Amount',
            'Sales Tax %' ,
            'Sales Tax Amount',
            'Total Amount',
            'Category Code',
            'Category Description',
        ];
    }
}
