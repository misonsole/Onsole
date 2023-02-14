@extends( (Auth::user()->id == "2") ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<!-- <link href="plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">
<link href="plugins/lightpick/lightpick.css" rel="stylesheet" /> -->
<style>
    .yourclass::-webkit-input-placeholder{
        color: #6c757d;
    }
    table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>td:first-child:before, table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>th:first-child:before {
        top: 12px;
        left: 4px;
        height: 14px;
        width: 14px;
        display: block;
        position: absolute;
        color: white;
        border: 2px solid white;
        border-radius: 14px;
        box-shadow: 0 0 3px #444;
        box-sizing: content-box;
        text-align: center;
        text-indent: 0 !important;
        font-family: 'Courier New', Courier, monospace;
        line-height: 15px;
        content: '+';
        background-color: #0275d8;
    }
    .buttons-copy, .buttons-pdf{
        display: none;
    }
    .buttons-excel, .buttons-collection{
        background: #1761fd;
        border: none;
        box-shadow: none;
    }
    .buttons-html5{
        border-top-left-radius: 5px !important;
        border-bottom-left-radius: 5px !important;
    }
    #loader1{  
        position: fixed;  
        left: 0px;  
        top: 0px;  
        width: 100%;  
        height: 100%;  
        z-index: 9999;  
        background: url("/img/avatars/3dgifmaker.gif") 50% 50% no-repeat black;  
    }
    .yourclass::-webkit-input-placeholder{
        color: #6c757d;
    }
    select[id="typefrom"]>option:nth-child(2), select[id="typefrom"]>option:nth-child(3), select[id="typefrom"]>option:nth-child(4), select[id="typefrom"]>option:nth-child(5), select[id="typefrom"]>option:nth-child(6), select[id="typefrom"]>option:nth-child(7) {
        font-weight:bold;
    }
    .select2-container--default .select2-selection--single{
        height: 38px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered{
        padding-top: 3px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow{
        height: 26px;
        position: absolute;
        top: 5px;
        right: 1px;
        width: 20px;
    }
</style>
<!-- <div id="loader1" class="rotate" width="100" height="100"></div> -->
<div class="container-fluid px-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Consumption Comparison</li>
                    </ol>
                </div>
                <h4 class="page-title">Consumption Comparison</h4>
                <br>
                <button style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); border: none;" type="button" class="btn text-white" id="reportModel">View Report</button>
            </div>
        </div>
    </div>
    <div class="row mb-5 mt-4">
        <div class="col-lg-12 col-sm-12 mb-5">
            <div class="card">
                <div class="card-body table-responsive">
                <div class="row px-5">
                        <div class="col-md-3 align-self-center">
                        </div>
                        <div class="col-md-6 align-self-center text-center">
                            <h3>Material Consumption Standard Vs Actual Comparison</h3>
                        </div>
                    </div>
                    @if($Permission == 1)
                    <div class="row mx-5 text-center py-4" style="border-radius: 5px;">
                        <div class="col-md-1" style="border-top: 1px solid; border-bottom: 1px solid;">
                        </div>
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Date Range</b></h6>                            
                            @if(!empty($sessionData['Storestart1']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['Storestart1']}} - {{$sessionData['Storeend2']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div>
                        <div class="col-md-1" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Article Code</b></h6>                            
                            @if(!empty($sessionData['articleno']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['articleno']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-1" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Sales Order</b></h6>                            
                            @if(!empty($sessionData['salesorder']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['salesorder']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-1" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Season</b></h6>                            
                            @if(!empty($sessionData['season']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['season']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Raw Material Code</b></h6>                            
                            @if(!empty($sessionData['rawmaterial']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['rawmaterial']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-1" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Category</b></h6>                            
                            @if(!empty($sessionData['rmcat']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['rmcat']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div>  
                        <div class="col-md-1" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Department</b></h6>                            
                            @if(!empty($sessionData['department']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['department']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Customer</b></h6>                            
                            @if(!empty($sessionData['customer']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['customer']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                    </div>
                    @endif
                    <div class="row p-3">
                        <div class="w-100">
                            <table id="datatable-buttons" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th class="text-white" data-orderable="false" hidden>.</th>
                                        <th class="text-white" data-orderable="false">Job Order</th>
                                        <th class="text-white" data-orderable="false">Customer</th>
                                        <th class="text-white" data-orderable="false">Sale <br> Order</th>
                                        <th class="text-white" data-orderable="false">Article</th>
                                        <th class="text-white" data-orderable="false">Delivery <br> Date</th>
                                        <th class="text-white" data-orderable="false">Department</th>
                                        <th class="text-white" data-orderable="false">Season</th>
                                        <th class="text-white" data-orderable="false">Item <br> Code</th>
                                        <th class="text-white" data-orderable="false">Item <br> Desc</th>
                                        <th class="text-white" data-orderable="false">Act <br> Qty</th>
                                        <th class="text-white" data-orderable="false">Act <br> Rate</th>
                                        <th class="text-white" data-orderable="false">Act <br> Amount</th>
                                        <th class="text-white" data-orderable="false">Prod Qty</th>
                                        <th class="text-white" data-orderable="false">Cons <br> AS Per <br> QTY</th>
                                        <th class="text-white" data-orderable="false">JO Qty</th>
                                        <th class="text-white" data-orderable="false">Cons Per Pair</th>
                                        <th class="text-white" data-orderable="false">Est <br> Qty</th>
                                        <th class="text-white" data-orderable="false">Est <br> Rate</th>
                                        <th class="text-white" data-orderable="false">Est <br> Amount</th>
                                        <th class="text-white" data-orderable="false">Diff <br> Qty</th>
                                        <th class="text-white" data-orderable="false">Diff <br> Qty</th>
                                        <th class="text-white" data-orderable="false">Diff <br> Amount</th>
                                    </tr>
                                </thead>
                                @if($Permission == 1)
                                    <tbody style="color: #787878;">
                                        <?php
                                            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
                                            $conn = oci_connect("onsole","s",$wizerp);
                                            $actqty = $diffqty = $actrate = $diffamt = $actamt = $estamt = $rem_check = $key = $keycode = $rateof = 0;                                        
                                            $book = $status = $rate = $rate2 = $month_name = $month_name2 =  $article0 = $department0 = $sono0 = "";
                                            $adjustno = $pino = $pidate = $tempcode = "";
                                            $sum_rate = $sum_qty = $sum_amount = $poqty = $i = $sumamount = $sumtax = $sumamtinctax = $sumpoqty = $pndgcounter = $tcheck = 0;
                                            $item_code = array(); $purchinv = array(); $pidate2 = array(); $arrayhe = array(); $sumof = array(0,0,0,0,0,0,0,0,0);  $rmcoarr = array();
                                            $poqtytotal = $poreceivedtotal = $porejectedtotal = $poacceptedtotal = $popendingtotal = $poamounttotal = $postaxtotal = $pototal = 0;
                                            $sumpoqtytotal = $sumporcvtotal = $sumporejtotal = $sumpoacctotal = $sumpopentotal = $sumpoamttotal = $sumpostaxtotal = $sumpototal = $pendingme = 0;
                                            ?>

                                        @foreach($data as $row)
                                        <?php $jobid = $row->Job_Id;  $SO_NO = $row->So_No; $article = $row->Onsole_Art_No; $departmentERP = $row->Department;  $item_code_now = $row->Rm_Code; ?>                         
                                            <tr class="table_row"> 
                                                <td hidden>1</td>
                                                <td>{{$row->Job_Id}} <br> {{$row->RTTIME}}</td>
                                                <td>{{$row->Cust_Name}}</td>
                                                <td>{{$row->So_No}}</td>
                                                <td>{{$row->Onsole_Art_No}}</td>
                                                <td>{{$row->Delivery_Date}}</td>
                                                <td>{{$row->Department}}</td>
                                                <td>{{$row->Season}}</td>
                                                <td style="color: darkblue;">{{$row->Rm_Code}}</td>
                                                <td>
                                                    <?php $explode = explode(" ",$row->Job_Desc); ?>
                                                    @foreach($explode as $data1)
                                                        {{$data1}}<br>
                                                    @endforeach
                                                </td> 
                                                <?php
                                                $sql5 = "SELECT T.PROD_QTY, SUM(ID.PRIMARY_QTY) AS QUANTITY, SUM(ID.ISSUE_AMOUNT) AS AMOUNT, (SUM(ID.ISSUE_AMOUNT)/SUM(ID.PRIMARY_QTY)) AS RATE
                                                            FROM ISSUE_MT IM
                                                            JOIN ISSUE_DETAIL ID ON ID.ISSUE_ID = IM.ISSUE_ID
                                                            JOIN DEPARTMENT_MT DM ON DM.DEPARTMENT_ID = IM.DEPARTMENT_ID AND DM.DESCRIPTION LIKE NVL('$departmentERP','%')
                                                            JOIN SALES_ORDER_MT SOM ON SOM.SALES_ORDER_ID = IM.SALES_ORDER_ID AND SOM.SALES_ORDER_NO LIKE NVL('$SO_NO','%')
                                                            JOIN ITEMS_MT ITEM ON ITEM.ITEM_ID = ID.ITEM_ID AND ITEM.ITEM_CODE LIKE NVL('$item_code_now','%')
                                                            JOIN WIZ_SEGMENT03 ARTCODE ON ARTCODE.SEGMENT_ID = ID.SEGMENT_ID AND ARTCODE.SEGMENT_VALUE_DESC LIKE NVL('$article','%')
                                                            JOIN (  SELECT IMM.SALES_ORDER_ID, SUM(IMM.PRODUCTION_QTY) AS PROD_QTY
                                                                    FROM ISSUE_MT IMM
                                                                    JOIN ISSUE_DETAIL IDD ON IDD.ISSUE_ID = IMM.ISSUE_ID
                                                                    JOIN DEPARTMENT_MT DMM ON DMM.DEPARTMENT_ID = IMM.DEPARTMENT_ID AND DMM.DESCRIPTION LIKE NVL('$departmentERP','%')
                                                                    JOIN SALES_ORDER_MT SOMM ON SOMM.SALES_ORDER_ID = IMM.SALES_ORDER_ID AND SOMM.SALES_ORDER_NO LIKE NVL('$SO_NO','%')
                                                                    JOIN ITEMS_MT ITEMM ON ITEMM.ITEM_ID = IDD.ITEM_ID AND ITEMM.ITEM_CODE LIKE NVL('$item_code_now','%')
                                                                    JOIN WIZ_SEGMENT03 ARTCODEE ON ARTCODEE.SEGMENT_ID = IDD.SEGMENT_ID AND ARTCODEE.SEGMENT_VALUE_DESC LIKE NVL('$article0','%')
                                                                            
                                                                    WHERE IMM.ISSUE_DATE BETWEEN '$strtdte22' AND '$enddte22'
                                                                    GROUP BY IMM.SALES_ORDER_ID
                                                                    
                                                                ) T ON T.SALES_ORDER_ID = SOM.SALES_ORDER_ID
                                                            WHERE IM.ISSUE_DATE BETWEEN '$strtdte22' AND '$enddte22'
                                                            GROUP BY T.PROD_QTY";

                                                $result5 = oci_parse($conn,$sql5);
                                                oci_execute($result5);
                                                $row5 = oci_fetch_array($result5,  OCI_ASSOC+OCI_RETURN_NULLS);
                                                if($row5 == NULL){  $diffqty2 = 0; ?>
                                                    <td style="background-color:rgba(255, 0, 0, 0.2);">0<?php $actqty = 0; ?></td>
                                                    <td style="background-color:rgba(255, 0, 0, 0.2);">0<?php $actrate = 0; ?></td>
                                                    <td style="background-color:rgba(255, 0, 0, 0.2);">0<?php $actamt = 0; ?></td>
                                                    <td style="background-color:rgba(255, 0, 0, 0.2);">0</td>
                                                    <td style="background-color:rgba(255, 0, 0, 0.2);">N/A</td>
                                                <?php } else { ?>
                                                    <td style="background-color:rgba(255, 0, 0, 0.2);">{{$row5["QUANTITY"]}} <?php  $actqty = $row5["QUANTITY"]; ?></td>             
                                                    <td style="background-color:rgba(255, 0, 0, 0.2);">{{ number_format($row5["RATE"],2)}} <?php $actrate = $row5["RATE"]; ?></td>
                                                    <td style="background-color:rgba(255, 0, 0, 0.2);">{{ number_format($row5["AMOUNT"],2)}} <?php $actamt = $row5["AMOUNT"]; ?></td>
                                                    <td style="background-color:rgba(255, 0, 0, 0.2);">{{ number_format($row5["PROD_QTY"],2)}} </td>
                                                    <td style="background-color:rgba(255, 0, 0, 0.2);">{{ number_format($row5["PROD_QTY"]*($row->Quantity/$row->totals),2)}} </td>        
                                                <?php }  ?>

                                                <td style="background-color:rgba(0, 255, 0, 0.2);">{{ number_format($row->totals,2)}} </td>
                                                <td style="background-color:rgba(0, 255, 0, 0.2);">{{ number_format($row->Quantity/$row->totals,2)}} </td>
                                                <td style="background-color:rgba(0, 255, 0, 0.2);">{{ number_format($row->Quantity,2)}} </td>
                                                <td style="background-color:rgba(0, 255, 0, 0.2);">{{ number_format($actrate,2)}} </td>
                                                <td style="background-color:rgba(0, 255, 0, 0.2);">{{ number_format($actrate*$row->Quantity,2) }} <?php $estamt = $actrate*$row->Quantity; ?> </td>
                                            <?php $diffqty = $row->Quantity-$actqty;  $diffamt = $estamt-$actamt; $totaling = (int)$row->totals;                                          
                                            if($row5 == NULL){
                                                $diffqty2 = 0; ?>
                                                <td style="color: green; background-color:rgba(0, 0, 255, 0.2);">{{number_format($diffqty2,2); }}</td>
                                            <?php } else {
                                                $diffqty2 = $row5["QUANTITY"] - ($row5["PROD_QTY"]*($row->Quantity/$totaling)); ?>
                                                <td style="color: green; background-color:rgba(0, 0, 255, 0.2);">{{ $diffqty2 }}</td>
                                            <?php } ?>                    
                                            <?php if($diffqty == 0){ ?>
                                                <td style="color: green; background-color:rgba(0, 0, 255, 0.2);">{{number_format($diffqty,2) }}</td> <?php
                                            } else { ?>
                                                <td style="color: red; background-color:rgba(0, 0, 255,0.2);">{{number_format($diffqty,2) }}</td>
                                            <?php } ?>
                                                <td>{{number_format($diffamt,2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-dark">  
                                        <tr>
                                            <th hidden></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                        </tr>
                                    </tfoot>
                                @endif
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="margin-top: 5%;">
            <div class="modal-header" style="background: transparent !important;">
            <h5 class="modal-title" id="exampleModalLongTitle">Consumption Comparison Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body px-5 py-1">
                    <form method="post" enctype="multipart/form-data" id="myForm">
                        @csrf
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label><b style="color: #6c757d">Select Date</b></label>
                                <div class="input-group" style="border: 1px solid #bfbfbf;">   
                                    <input type="text" class="form-control" <?php if(isset($sessionData['strtdte3a'])) echo "value='{{$sessionData['strtdte2a']}} - {{$sessionData['strtdte3a']}}'"; ?> name="daterange">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="dripicons-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label><b style="color: #6c757d">Article Code</b></label>
                                <input id="articleno" name="articleno" <?php if(isset($sessionData['articleno'])) echo "value='{$sessionData['articleno']}'"; ?> type="text" class="typeahead form-control yourclass" style="border: 1px solid #bfbfbf;" placeholder="Article Code">
                            </div>
                        </div>    
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label><b style="color: #6c757d">Sales Order</b></label>
                                <input id="salesorder" name="salesorder" <?php if(isset($sessionData['salesorder'])) echo "value='{$sessionData['salesorder']}'"; ?> type="text" class="typeahead form-control yourclass" style="border: 1px solid #bfbfbf;" placeholder="Sales Order">
                            </div>
                            <div class="col-sm-6">
                                <label><b style="color: #6c757d">Season</b></label>
                                <select id="season" name="season" style="border: 1px solid #bfbfbf;" class="form-control select.custom-select">
                                <option selected value="">Select Season</option>
                                    @foreach($season as $value)
                                        @if(!empty($sessionData['season']))
                                            <option <?php if($value == $sessionData['season']) echo 'selected="selected"'; ?> value="{{$value}}">{{$value}}</option>
                                        @else
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endif  
                                    @endforeach                  
                                </select>
                            </div>
                        </div>    
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label><b style="color: #6c757d">Raw Material Code</b></label>
                                <input id="rawmaterial" name="rawmaterial" <?php if(isset($sessionData['rawmaterial'])) echo "value='{$sessionData['rawmaterial']}'"; ?> type="text" class="typeahead form-control yourclass" style="border: 1px solid #bfbfbf;" placeholder="Raw Material Code">
                            </div>
                        </div>    
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label><b style="color: #6c757d">Customer</b></label>
                                <select id="customer" name="customer" style="border: 1px solid #bfbfbf;" class="select2 form-control mb-3 custom-select">
                                    <option selected value="">Select Customer</option>
                                    @foreach($customer as $value)
                                        @if(!empty($sessionData['customer']))
                                            <option <?php if($value == $sessionData['customer']) echo 'selected="selected"'; ?> value="{{$value}}">{{$value}}</option>
                                        @else
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endif  
                                    @endforeach                  
                                </select>
                            </div>
                        </div>    
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label><b style="color: #6c757d">Category</b></label>
                                <select id="rmcat" name="rmcat" style="border: 1px solid #bfbfbf;" class="select2 form-control mb-3 custom-select">
                                <option selected value="">Select Category</option>
                                    @foreach($category as $value)
                                        @if(!empty($sessionData['category']))
                                            <option <?php if($value == $sessionData['category']) echo 'selected="selected"'; ?> value="{{$value}}">{{$value}}</option>
                                        @else
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endif  
                                    @endforeach                  
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label><b style="color: #6c757d">Department</b></label>
                                <select id="department" name="department" style="border: 1px solid #bfbfbf;" class="form-control select.custom-select">
                                    <option value="">Select Department</option>
                                    @if(!empty($sessionData['department']))
                                        <option <?php if("Cutting" == $sessionData['department']) echo 'selected="selected"'; ?>  value="Cutting">Cutting</option>
                                        <option <?php if("Closing" == $sessionData['department']) echo 'selected="selected"'; ?>  value="Closing">Closing</option> 
                                        <option <?php if("Lasting" == $sessionData['department']) echo 'selected="selected"'; ?>  value="Lasting">Lasting</option>
                                        <option <?php if("Insole" == $sessionData['department']) echo 'selected="selected"'; ?>  value="Insole">Insole</option>   
                                    @else
                                        <option value="Cutting">Cutting</option>
                                        <option value="Closing">Closing</option> 
                                        <option value="Lasting">Lasting</option>
                                        <option value="Insole">Insole</option>  
                                    @endif             
                                </select>
                            </div>
                        </div>                          
                        <div class="form-group row py-1">
                        </div>
                        <div class="form-group row mt-2">
                            <div class="col-sm-6">
                                <button type="submit" id="submit" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); border: none;" class="btn px-5 py-1 btn-md btn-block text-white">Show</button>
                            </div>
                            <div class="col-sm-6">
                                <button type="submit" id="download" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); border: none;" class="btn px-5 py-1 btn-md btn-block text-white">Download</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer" style="background: transparent !important;">
                <button type="button" style="background: #1e2438; border: none;" class="btn text-white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/customjquery.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script src="assets/js/cdn1.min.js"></script>
<script src="assets/js/cdn2.min.js"></script>
<script>
$(document).ready(function(){ 
    $("#loader1").fadeOut(1200);
    $("body").addClass("enlarge-menu");
});
@if(Session::has('message'))
var type = "{{ Session::get('alert-type', 'info') }}";
switch(type){
    case 'info':
        Swal.fire({
        icon: 'info',
        title: "Error!",
        text: "{{ session('message') }}",
    });
    break;
    case 'warning':
        Swal.fire({
        icon: 'warning',
        text: "{{ session('message') }}",
    });
    break;
    case 'success':
        Swal.fire({
        icon: 'success',
        title: "{{ session('message') }}",
        showConfirmButton: false,
        timer: 2000
    });
    break;
    case 'error':
        Swal.fire({
        icon: 'error',
        title: "{{ session('message') }}",
    });
    break;
}
@endif
$('#deppp').on('change', function(){
    document.getElementById("myForm").submit();
});
$("#submit").click(function(){
    $("#myForm").attr("action", "comparison-report");
    document.getElementById("myForm").submit();
});
$("#download").click(function(){
    $("#myForm").attr("action", "comparison-report-download");
    document.getElementById("myForm").submit();
});

$(document).ready(function(){
    $(".btnSelectuser").on('click',function(){
        var currentRow = $(this).closest("tr");
        var col1 = currentRow.find("td:eq(1)").html();
        $("#exampleModalCenter212").modal('hide');
        $("#transfer").val(col1);
    });
});

$("#reportModel").on('click',function(){
    $("#exampleModalCenter").modal('show');
});
</script>
<script>
    var path1 = "{{route('salesorderno')}}";
    var path3 = "{{route('itemcode')}}";  
    var path4 = "{{route('articleno')}}";  
    $("#salesorder").autocomplete({
        source: function(request, response){
            $.ajax({
                url: path1,
                type: 'GET',
                dataType: "json",
                data: {
                    search: request.term
                },
                success: function(data){
                    response(data);
                }
            });
        },
        select: function(event, ui){
            $('#salesorder').val(ui.item.label);
            console.log(ui.item); 
            return false;
        }
    });
    $("#rawmaterial").autocomplete({
        source: function(request, response){
            $.ajax({
                url: path3,
                type: 'GET',
                dataType: "json",
                data: {
                    search: request.term
                },
                success: function(data){
                    response(data);
                }
            });
        },
        select: function(event, ui){
            $('#rawmaterial').val(ui.item.label);
            console.log(ui.item); 
            return false;
        }
    });
    $("#articleno").autocomplete({
        source: function(request, response){
            $.ajax({
                url: path4,
                type: 'GET',
                dataType: "json",
                data: {
                    search: request.term
                },
                success: function(data){
                    response(data);
                }
            });
        },
        select: function(event, ui){
            $('#articleno').val(ui.item.label);
            console.log(ui.item); 
            return false;
        }
    });
</script>
@endsection