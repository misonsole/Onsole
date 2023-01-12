<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Helpdesk implements FromCollection, WithHeadings
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
            'Complaint No',
            'Employee',
            'Department',
            'Category',
            'Sub Category',
            'Status',
            'Date & Time',
            'Operator',
            'Closing Date'
        ];
    }
}
