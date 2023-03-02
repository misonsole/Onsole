<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSheetOrderMt extends Model
{
    use HasFactory;

    protected $fillable = ['Job_Id', 'Unique_Id', 'Cust_Name', 'Cust_Art_No', 'Onsole_Art_No', 'So_No', 'Po_No', 'cat_type', 'Department', 'Delivery_Date', 'User_Date', 'Date_Created', 'Status', 'Reserved_Status', 'locator', 'sizerange', 'image', 'Transfer_No_Mt', 'Transfer_Date_Mt', 'Transfer_Id', 'Season', 'Remarksppc', 'Work_Order', 'transfer_time', 'Outsource'];

    public $timestamps = true;
}
