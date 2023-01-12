<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ItemPurchase implements FromCollection, WithHeadings
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
            'Item Code',
            'Item Desc',
            'UOM',
            'PO No',
            'GRN No',
            'PO Qty',
            'Received',
            'Rejected',
            'Accepted',
            'Pending',
            'Amount',
            'Unit Price',
            'STAX Amount',
            'Amt Inclu STAX',
        ];
    }
}
