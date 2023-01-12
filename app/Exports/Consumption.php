<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Consumption implements FromCollection, WithHeadings
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
            'Issue No',
            'Issue Date',
            'Item Code',
            'Item Desc',
            'Qty',
            'Amount',
            'Contra A/C Code',
            'Contra A/C Desc',
        ];
    }
}
