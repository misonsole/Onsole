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
                        <li class="breadcrumb-item active">Material Transfer Against Job Order</li>
                    </ol>
                </div>
                <h4 class="page-title">Material Transfer Against Job Order</h4>
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
                            <h3>Material Transfer Against Job Order</h3>
                        </div>
                    </div>
                    @if($Permission == 1)
                    <div class="row mx-5 text-center py-4" style="border-radius: 5px;">
                        <div class="col-md-3" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Date Range</b></h6>                            
                            @if(!empty($sessionData['Storestart1']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['Storestart1']}} - {{$sessionData['Storeend2']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div>
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Article Code</b></h6>                            
                            @if(!empty($sessionData['articleno']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['articleno']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-3" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Sales Order</b></h6>                            
                            @if(!empty($sessionData['salesorder']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['salesorder']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-4" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Job Order</b></h6>                            
                            @if(!empty($sessionData['joborder']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['joborder']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                    </div>
                    <div class="row mx-5 text-center py-4" style="border-radius: 5px;">
                        <div class="col-md-3" style="border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Raw Material Code</b></h6>                            
                            @if(!empty($sessionData['rawmaterial']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['rawmaterial']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-2" style="border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Season</b></h6>                            
                            @if(!empty($sessionData['season']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['season']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-2" style="border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Category</b></h6>                            
                            @if(!empty($sessionData['rmcat']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['rmcat']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div>  
                        <div class="col-md-2" style="border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Department</b></h6>                            
                            @if(!empty($sessionData['department']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['department']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-3" style="border-bottom: 1px solid;">
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
                                        <th class="text-white" data-orderable="false">Job <br> Order</th>
                                        <th class="text-white" data-orderable="false">Customer</th>
                                        <th class="text-white" data-orderable="false">Sale <br> Order</th>
                                        <th class="text-white" data-orderable="false">Article</th>
                                        <th class="text-white" data-orderable="false">Department</th>
                                        <th class="text-white" data-orderable="false">Season</th>
                                        <th class="text-white" data-orderable="false">Item Code</th>
                                        <th class="text-white" data-orderable="false">Item Desc</th>
                                        <th class="text-white" data-orderable="false">Trans <br> Qty</th>
                                        <th class="text-white" data-orderable="false">Trans <br> Rate</th>
                                        <th class="text-white" data-orderable="false">Trans <br> Amount</th>
                                        <th class="text-white" data-orderable="false">JO <br> Qty</th>
                                        <th class="text-white" data-orderable="false">JO <br> Rate</th>
                                        <th class="text-white" data-orderable="false">JO <br> Amount</th>
                                        <th class="text-white" data-orderable="false">Diff <br> Qty</th>
                                        <th class="text-white" data-orderable="false">Diff <br> Amount</th>
                                    </tr>
                                </thead>
                                @if($Permission == 1)
                                    <tbody style="color: #787878;">
                                        <?php
                                            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
                                            $conn = oci_connect("onsole","s",$wizerp);
                                            $strtdte = $enddte = $strtdte2 = $enddte2 = $sono = $rmcat = $rmcodet = $department = $month_name = $month_name2 = $article = $article0 = $department0 = $sono0 = "";
                                            $item_code = array();
                                            $actqty = $diffqty = $actrate = $diffamt = $actamt = $estamt = $rem_check = $key = $keycode = $rateof = $amounte = $tno = $tno2 = 0;
                                            $strtdte = $enddte = $book = $status = $strtdte2 = $enddte2 = $rate = $rate2 = $month_name = $month_name2 = $item_code_now = $tdt = $joborder = $tdt2 = $tno_check = "";
                                            $strtdte3 = $enddte3 = $adjustno = $pino = $pidate = $tempcode = "";
                                            $sum_rate = $sum_qty = $sum_amount = $poqty = $i = $sumamount = $sumtax = $sumamtinctax = $sumpoqty = $pndgcounter = $tcheck = 0;
                                            $re_amount = 0; $re_rate = 0; $re_qty = 0;
                                            $purchinv = array();
                                            $pidate2 = array(); $arrayhe = array(); $sumof = array(0,0,0,0,0,0,0,0,0);  $rmcoarr = array(); $tnoBreak = array(); $tnoDate = array();
                                            $poqtytotal = $poreceivedtotal = $porejectedtotal = $poacceptedtotal = $popendingtotal = $poamounttotal = $postaxtotal = $pototal = 0;
                                            $sumpoqtytotal = $sumporcvtotal = $sumporejtotal = $sumpoacctotal = $sumpopentotal = $sumpoamttotal = $sumpostaxtotal = $sumpototal = $pendingme = 0;
                                            $strtdte2 = $sessionData['Storestart1'];
                                            $enddte2 = $sessionData['Storeend2'];
                                        ?> 
                                        @foreach($data as $row)
                                        <?php
                                            // $item_code = array();
                                            $jobid = $row->Job_Id;  $SO_NO = $row->So_No; $article = $row->Onsole_Art_No; $tno = $row->Transfer_Id; $tdt = $row->Transfer_Date_Mt;
                                            if($tempcode != $row->Job_Id){
                                                if($rem_check == 1){
                                                    $tnoBreak = explode(',', $tno2);
                                                    $tno_check = implode("','", $tnoBreak); ?>
                                                    <?php                                     
                                                    $sql5 = "SELECT IMT.ITEM_CODE, IMT.ITEM_DESC, SUM(TID.PIRMARY_QTY) AS QUANTITY, SUM(TID.AMOUNT) AS AMOUNT
                                                                FROM TRANS_ISSUE_MT TIM
                                                                JOIN TRANS_ISSUE_DETAIL TID ON TID.ISS_TRANS_ID = TIM.ISS_TRANS_ID
                                                                JOIN ITEMS_MT IMT ON IMT.ITEM_ID = TID.ITEM_ID
                                                                WHERE TIM.ISS_TRANS_ID IN ('$tno_check') AND TIM.INV_BOOK_ID = 77 AND TIM.TRANS_DATE BETWEEN '$strtdte2' AND '$enddte2'
                                                                GROUP BY IMT.ITEM_CODE, IMT.ITEM_DESC";
                                                    $result5= oci_parse($conn,$sql5);
                                                    oci_execute($result5);
                                                    while($row5=oci_fetch_array($result5,  OCI_ASSOC+OCI_RETURN_NULLS)){
                                                        if(count($tnoBreak) == 0){
                                                            break;
                                                        }
                                                        if($row5["QUANTITY"] == 0){
                                                            $rateof = 0;
                                                        }else{
                                                            $rateof = $row5["AMOUNT"]/$row5["QUANTITY"];
                                                        }
                                                        $printok = 1;
                                                        // echo "P 1";
                                                        // print_r($item_code);
                                                        for($keycode = 0; $keycode < count($item_code); $keycode++){
                                                            if($row5["ITEM_CODE"] == $item_code[$keycode]) { $printok = 0; }
                                                        }
                                                        if($printok == 1) { ?>
                                                        <tr style="text-align: center;">
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td><?php echo $tno; ?></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td style="color: maroon;"><strong><?php echo $row5["ITEM_CODE"]; ?></strong></td>
                                                            <td style="color: maroon;">
                                                                <?php $explode = explode(" ",$row5["ITEM_DESC"]); ?>
                                                                @foreach($explode as $data1)
                                                                   <b>{{$data1}}</b><br>
                                                                @endforeach
                                                            </td> 
                                                            <td><?php echo number_format($row5["QUANTITY"],2); ?></td>
                                                            <td><?php echo number_format($rateof,2); ?></td>
                                                            <td><?php echo number_format($row5["AMOUNT"],2); ?></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td style="color: red;"><?php echo number_format($row5["QUANTITY"],2); ?></td>
                                                            <td><?php echo number_format($row5["AMOUNT"],2); ?></td>      
                                                        </tr>
                                                        <?php }
                                                        } unset($item_code);
                                                } ?>
                                                        <tr style="text-align: center; background-color:rgba(0, 0, 0, 0.14); font-size: 14px;">
                                                            <td><strong><?php echo $row->Job_Id." <br> ".$row->RTTIME; ?></strong></td>
                                                            <td><strong><?php echo $row->Cust_Name; ?></strong></td>
                                                            <td><strong><?php echo $row->So_No; ?></strong></td>
                                                            <td><strong><?php echo $row->Transfer_No_Mt; ?></strong></td>
                                                            <td><strong><?php echo $row->Department; ?></strong></td>
                                                            <td>{{$row->Season}}</td>
                                                            <td style="color: darkblue;"><strong><?php echo $row->Rm_Code;  $item_code[0] = $row->Rm_Code; ?></strong></td>
                                                            <td style="color: darkblue;">{{$row->Job_Desc}}</td> 
                                                                <?php   $item_code_now = $row->Rm_Code;
                                                                        $tnoBreak = explode(',', $tno);  
                                                                        $tno_check = implode("','", $tnoBreak);
                                                                        $sql3 = "SELECT SUM(TID.PIRMARY_QTY) AS QUANTITY, SUM(TID.AMOUNT) AS AMOUNT
                                                                                FROM TRANS_ISSUE_MT TIM
                                                                                JOIN TRANS_ISSUE_DETAIL TID ON TID.ISS_TRANS_ID = TIM.ISS_TRANS_ID
                                                                                JOIN ITEMS_MT IMT ON IMT.ITEM_ID = TID.ITEM_ID AND IMT.ITEM_CODE LIKE NVL('$item_code_now','%')
                                                                                WHERE TIM.ISS_TRANS_ID IN ('$tno_check') AND TIM.TRANS_DATE BETWEEN '$strtdte2' AND '$enddte2'";
                                                                        $result3 = oci_parse($conn,$sql3);
                                                                        oci_execute($result3);
                                                                        while($row3=oci_fetch_array($result3,  OCI_ASSOC+OCI_RETURN_NULLS)) { 
                                                                            if($row3["QUANTITY"] != 0){
                                                                                $rate2 = $row3["AMOUNT"]/$row3["QUANTITY"];
                                                                            }else{
                                                                                $rate2 = 0; $amounte = 0;
                                                                            } ?>
                                                            <td style="background-color:rgba(255, 0, 0, 0.33);"><?php echo $row3["QUANTITY"]; $actqty = $row3["QUANTITY"]; ?></td>
                                                            <td style="background-color:rgba(255, 0, 0, 0.33);"><?php echo number_format($rate2,2);  $actrate = $rate2; ?></td>
                                                            <td style="background-color:rgba(255, 0, 0, 0.33);"><?php echo number_format($row3["AMOUNT"],2);  $actamt = $row3["AMOUNT"]; ?></td>
                                                            <?php } ?>
                                                            <td style="background-color:rgba(0, 255, 0, 0.34);"><?php echo number_format($row->Quantity,2); ?></td>
                                                            <td style="background-color:rgba(0, 255, 0, 0.34);"><?php echo number_format($actrate,2); ?></td>
                                                            <td style="background-color:rgba(0, 255, 0, 0.34);"><?php echo number_format(($actrate*$row->Quantity),2);  $estamt = $actrate*$row->Quantity; ?></td>
                                                            <?php $diffqty = $row->Quantity-$actqty;  $diffamt = $estamt-$actamt;
                                                            if($diffqty == 0) { ?>
                                                                <td style="color: green; background-color:rgba(0, 0, 255, 0.30);"><?php echo number_format($diffqty,2); ?></td> <?php
                                                            }else { ?>
                                                                <td style="color: red; background-color:rgba(0, 0, 255, 0.30);"><?php echo number_format($diffqty,2); ?></td>
                                                            <?php } ?>
                                                            <td><?php echo number_format($diffamt,2); ?></td>
                                                        </tr>
                                                    <?php $tempcode = $row->Job_Id; $rem_check = 1; $key = 1; } else {  ?>
                                                        <tr style="text-align: center;">
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td style="color: darkblue;"><strong><?php echo $row->Rm_Code; ?></strong></td>
                                                            <td style="color: darkblue;">{{$row->Job_Desc}}</td> 
                                                                <?php                                                                  
                                                                        $item_code[$key] = $row->Rm_Code; $key++; $item_code_now = $row->Rm_Code;
                                                                        // echo "P 3";
                                                                        // print_r($item_code);  
                                                                        $tnoBreak = explode(',', $tno);
                                                                        $tno_check = implode("','", $tnoBreak);
                                                                        $sql3 = "SELECT SUM(TID.PIRMARY_QTY) AS QUANTITY, SUM(TID.AMOUNT) AS AMOUNT
                                                                                FROM TRANS_ISSUE_MT TIM
                                                                                JOIN TRANS_ISSUE_DETAIL TID ON TID.ISS_TRANS_ID = TIM.ISS_TRANS_ID
                                                                                JOIN ITEMS_MT IMT ON IMT.ITEM_ID = TID.ITEM_ID AND IMT.ITEM_CODE LIKE NVL('$item_code_now','%')
                                                                                WHERE TIM.ISS_TRANS_ID IN ('$tno_check') AND TIM.TRANS_DATE BETWEEN '$strtdte2' AND '$enddte2'";
                                                                        $result3 = oci_parse($conn,$sql3);
                                                                        oci_execute($result3);
                                                                        while($row3 = oci_fetch_array($result3,  OCI_ASSOC+OCI_RETURN_NULLS)) {
                                                                            if($tno == NULL){
                                                                                $re_amount = 0; $re_rate = 0; $re_qty = 0;
                                                                            }else{
                                                                                if($row3["QUANTITY"] != 0){
                                                                                    $re_qty = $row3["QUANTITY"];
                                                                                    $re_amount = $row3["AMOUNT"];
                                                                                    $re_rate = $row3["AMOUNT"]/$row3["QUANTITY"];
                                                                                }else{
                                                                                    $re_rate = $re_qty = $re_amount = 0; $amounte = 0;
                                                                                }
                                                                            } ?>
                                                            <td style="background-color:rgba(255, 0, 0, 0.33);"><?php echo number_format($re_qty,2);  $actqty = $row3["QUANTITY"]; ?></td>
                                                            <td style="background-color:rgba(255, 0, 0, 0.33);"><?php echo number_format($re_rate,2);  $actrate = $re_rate; ?></td>
                                                            <td style="background-color:rgba(255, 0, 0, 0.33);"><?php echo number_format($re_amount,2);  $actamt = $row3["AMOUNT"]; ?></td>
                                                            <?php  } ?>
                                                            <td style="background-color:rgba(0, 255, 0, 0.34);"><?php echo number_format($row->Quantity,2); ?></td>
                                                            <td style="background-color:rgba(0, 255, 0, 0.34);"><?php echo number_format($actrate,2); ?></td>
                                                            <td style="background-color:rgba(0, 255, 0, 0.34);"><?php echo number_format(($actrate*$row->Quantity),2);  $estamt = $actrate*$row->Quantity; ?></td>
                                                            <?php $diffqty = $row->Quantity-$actqty;  $diffamt = $estamt-$actamt;
                                                            if($diffqty < 00.5 && $diffqty >-0.5) { ?>
                                                                <td style="color: green; background-color:rgba(0, 0, 255, 0.30);"><?php echo number_format($diffqty,2); ?></td> <?php
                                                            } else { ?>
                                                                <td style="color: red; background-color:rgba(0, 0, 255, 0.30);"><?php echo number_format($diffqty,2); ?></td>
                                                            <?php } ?>
                                                            <td><?php echo number_format($diffamt,2); ?></td>
                                                        </tr>
                                                    <?php   }  $article0 = $row->Onsole_Art_No; $department0 = $row->Department;  $sono0 = $row->So_No; $tno2 = $tno; $tdt2 = $tdt; ?>
                                                    @endforeach
                                                    <?php

                                                    $tnoBreak = explode(',', $tno);
                                                    $tno_check = implode("','", $tnoBreak);
                                                    $sql5 = "SELECT IMT.ITEM_CODE, IMT.ITEM_DESC, SUM(TID.PIRMARY_QTY) AS QUANTITY, SUM(TID.AMOUNT) AS AMOUNT
                                                                FROM TRANS_ISSUE_MT TIM
                                                                JOIN TRANS_ISSUE_DETAIL TID ON TID.ISS_TRANS_ID = TIM.ISS_TRANS_ID
                                                                JOIN ITEMS_MT IMT ON IMT.ITEM_ID = TID.ITEM_ID
                                                                WHERE TIM.ISS_TRANS_ID IN ('$tno_check') AND TIM.TRANS_DATE BETWEEN '$strtdte2' AND '$enddte2'
                                                                GROUP BY IMT.ITEM_CODE, IMT.ITEM_DESC";
                                                    $result5 = oci_parse($conn,$sql5);
                                                    oci_execute($result5);
                                                    // echo "P 2";
                                                    // print_r($item_code);
                                                    while($row5 = oci_fetch_array($result5,  OCI_ASSOC+OCI_RETURN_NULLS)){
                                                        if($tnoBreak[0] == NULL){
                                                            break;
                                                        }
                                                        if($row5["QUANTITY"] == 0){
                                                            $rateof = 0;
                                                        }else{
                                                            $rateof = $row5["AMOUNT"]/$row5["QUANTITY"];
                                                        }
                                                        $printok = 1;
                                                        for($keycode = 0; $keycode < count($item_code); $keycode++) {
                                                            if($row5["ITEM_CODE"] == $item_code[$keycode]) { $printok = 0; }
                                                        }
                                                        if($printok == 1) { ?>
                                                        <tr style="text-align: center;">
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td style="color: maroon;"><strong><?php echo $row5["ITEM_CODE"]; ?></strong></td>
                                                            <td style="color: maroon;">{{$row5["ITEM_DESC"]}}</td>
                                                            <td><?php echo number_format($row5["QUANTITY"],2); ?></td>
                                                            <td><?php echo number_format($rateof,2); ?></td>
                                                            <td><?php echo number_format($row5["AMOUNT"],2); ?></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td style="color: red;"><?php echo number_format($row5["QUANTITY"],2); ?></td>
                                                            <td><?php echo number_format($row5["AMOUNT"],2); ?></td>  
                                                        </tr>
                                                        <?php
                                                        }
                                                    } 
                                                    unset($item_code); ?>
                                    </tbody>
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
            <h5 class="modal-title" id="exampleModalLongTitle">Material Transfer Against Job Order</h5>
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
                            <div class="col-sm-6">
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
                            <div class="col-sm-6">
                                <label><b style="color: #6c757d">Job Order</b></label>
                                <input id="joborder" name="joborder" <?php if(isset($sessionData['joborder'])) echo "value='{$sessionData['joborder']}'"; ?> type="text" class="typeahead form-control yourclass" style="border: 1px solid #bfbfbf;" placeholder="Job Order">
                            </div>
                        </div>    
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label><b style="color: #6c757d">Category</b></label>
                                <select id="rmcat" name="rmcat" style="border: 1px solid #bfbfbf;" class="select2 form-control mb-3 custom-select">
                                <option selected value="">Select Category</option>
                                    @foreach($category as $value)
                                        @if(!empty($sessionData['rmcat']))
                                            <option <?php if($value == $sessionData['rmcat']) echo 'selected="selected"'; ?> value="{{$value}}">{{$value}}</option>
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
    $("#myForm").attr("action", "transferagainst-report");
    document.getElementById("myForm").submit();
});
$("#download").click(function(){
    $("#myForm").attr("action", "transferagainst-report-download");
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
    var path2 = "{{route('jobordernums')}}";
    var path3 = "{{route('itemcode')}}";  
    var path4 = "{{route('artcode')}}";      
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
    $("#joborder").autocomplete({
        source: function(request, response){
            $.ajax({
                url: path2,
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
            $('#joborder').val(ui.item.label);
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