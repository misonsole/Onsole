<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WorkorderDetail implements FromCollection,  WithHeadings
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
            'WO No',
            'WO Date',
            'Code',
            'Desc',
            'GRN',
            'GRN DATE',
            'Item Code',
            'Item Desc',
            'WO Qty',
            'WO Rate',
            'SIN No',
            'SIN DATE',
            'Store Qty',
            'Store Amt',
            'Store Rate',
            'GRN Qty',
            'PI Qty',
            'PI Amt',
            'PI EXP TC Amount',
            'PI T-Amt',
            'PI Rate',
        ];
    }
}
