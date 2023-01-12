<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JobOrder implements FromCollection, WithHeadings
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
            'Job ID',
            'Date',
            'Customer',
            'Category Type',
            'Work Order',
            'Sale Order',
            'Purchase Order',
            'Current Status',
            'Department',
            'Onsole Article',
            'Cust Article',
            'Season',
            'Color',
            'Size' ,
            'Last No',
            'Status',
            'Quantity',
            'Item Code',
            'Item Description',
            'Location',
            'Tool',
            'Die No',
            'Um',
            'Qty',
        ];
    }
}
