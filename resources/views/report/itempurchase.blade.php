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
<div id="loader1" class="rotate" width="100" height="100"></div>
<div class="container-fluid px-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Item Purchasing Movement Report</li>
                    </ol>
                </div>
                <h4 class="page-title">Item Purchasing Movement Report</h4>
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
                            <h3>Item Purchasing Movement Report</h3>
                        </div>
                    </div>
                    @if($Permission == 1)
                    <div class="row mx-5 text-center py-4" style="border-radius: 5px;">
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Date Range</b></h6>                            
                            @if(!empty($sessionData['Storestart1']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['Storestart1']}} - {{$sessionData['Storeend2']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Book</b></h6>                            
                            @if(!empty($sessionData['book']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['book']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Item Code From</b></h6>                            
                            @if(!empty($sessionData['rmcodef']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['rmcodef']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-1" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Date</b></h6>                            
                            @if(!empty($sessionData['thedate']))
                                @if($sessionData['thedate'] == 'po')
                                    <p class="mb-2" style="font-family: 'Poppins';">PO Date</p>
                                @elseif($sessionData['thedate'] == 'grn')
                                    <p class="mb-2" style="font-family: 'Poppins';">GRN Date</p>
                                @endif
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-1" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Status</b></h6>                            
                            @if(!empty($sessionData['ostatus']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{ucfirst($sessionData['ostatus'])}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Purchase Order</b></h6>                            
                            @if(!empty($sessionData['purchaseorder']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{ucfirst($sessionData['purchaseorder'])}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div>
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Supplier</b></h6>                            
                            @if(!empty($sessionData['supplier']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{ucfirst($sessionData['supplier'])}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                    </div>
                    @endif
                    <div class="row p-3">
                        <div class="w-100">
                            <table id="datatable2" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th hidden>.</th>
                                        <th class="text-white" data-orderable="false">Item <br> Code</th>
                                        <th class="text-white" data-orderable="false">Item <br> Desc</th>
                                        <th class="text-white" data-orderable="false">UOM</th>
                                        <th hidden class="text-white" data-orderable="false">Supplier</th>
                                        <th class="text-white" data-orderable="false">PO <br>No</th>
                                        <th class="text-white" data-orderable="false">GRN <br> No </th>
                                        <th class="text-white" data-orderable="false">PO <br> Qty</th>
                                        <th class="text-white" data-orderable="false">Received</th>
                                        <th class="text-white" data-orderable="false">Rejected </th>
                                        <th class="text-white" data-orderable="false">Accepted </th>
                                        <th class="text-white" data-orderable="false">Pending </th>
                                        <th class="text-white" data-orderable="false">Amount </th>
                                        <th class="text-white" data-orderable="false">Unit Price</th>
                                        <th class="text-white" data-orderable="false">STAX <br> Amount </th>
                                        <th class="text-white" data-orderable="false">Amt Inclu <br> STAX</th>
                                    </tr>
                                </thead>
                                @if($Permission == 1)
                                    <tbody>
                                        <?php $tempcode = ""; ?>
                                        <?php $sumof = array(0,0,0,0,0,0,0,0,0);  ?>
                                        <?php 
                                            $poqtytotal = $poreceivedtotal = $porejectedtotal = $poacceptedtotal = $popendingtotal = $poamounttotal = $postaxtotal = $pototal = 0;
                                            $sum_rate = $sum_qty = $sum_amount = $poqty = $i = $sumamount = $sumtax = $sumamtinctax = $sumpoqty = $pndgcounter = $tcheck = 0;
                                            $sumpoqtytotal = $sumporcvtotal = $sumporejtotal = $sumpoacctotal = $sumpopentotal = $sumpoamttotal = $sumpostaxtotal = $sumpototal = $pendingme = 0; 
                                            $tempcode = "";
                                        ?>
                                        @foreach($data as $row)
                                        <?php if ($tcheck == 0) { ?>
                                        <?php
                                            $sumof[0] = $sumof[0] + $row["PO_QTY"];
                                            $sumof[1] = $sumof[1] + $row["RECEIVED_QTY"];
                                            $sumof[2] = $sumof[2] + $row["REJECTED_QTY"];
                                            $sumof[3] = $sumof[3] + $row["ACCEPTED_QTY"];
                                            $sumof[5] = $sumof[5] + $row["AMOUNT"];
                                            $sumof[6] = $sumof[6] + $row["STAX_AMOUNT"];
                                            $sumof[7] = $sumof[7] + $row["STAX_INCLU_AMOUNT"];
                                        ?>
                                        <?php if($tempcode == $row["ITEM_CODE"]) { ?>
                                        <?php if($temppo != $row["PO_NO"]) { ?>
                                            <tr style="background-color:rgba(0, 0, 0, 0.05);">
                                                <td hidden>1</td> 
                                                <td class="font-weight-bold" data-orderable="false"></td>
                                                <td class="font-weight-bold" data-orderable="false"></td>
                                                <td class="font-weight-bold" data-orderable="false"></td>
                                                <td hidden class="font-weight-bold" data-orderable="false"></td>
                                                <td class="font-weight-bold" data-orderable="false"></td>
                                                <td class="font-weight-bold" data-orderable="false"><b>Total</b></td>
                                                <td class="font-weight-bold" data-orderable="false"><b>{{number_format($poqtytotal,2)}}</b></td>
                                                <td class="font-weight-bold" data-orderable="false"><b>{{number_format($poreceivedtotal,2)}}</b></td>
                                                <td class="font-weight-bold" data-orderable="false"><b>{{number_format($porejectedtotal,2)}}</b></td>
                                                <td class="font-weight-bold" data-orderable="false"><b>{{number_format($poacceptedtotal,2)}}</b></td>
                                                <td class="font-weight-bold" data-orderable="false"><b>{{number_format($pendingme,2)}}</b></td>
                                                <td class="font-weight-bold" data-orderable="false"><b>{{number_format($poamounttotal,2)}}</b></td>
                                                <td class="font-weight-bold" data-orderable="false"></td>
                                                <td class="font-weight-bold" data-orderable="false"><b>{{number_format($postaxtotal,2)}}</b></td>
                                                <td class="font-weight-bold" data-orderable="false"><b>{{number_format($pototal,2)}}</b></td>
                                            </tr>
                                        <?php $poqtytotal = $poreceivedtotal = $porejectedtotal = $poacceptedtotal = $pendingme = $postaxtotal = $pototal = $poamounttotal = 0; } ?>
                                            <tr style="background-color:rgba(0, 0, 0, 0.05);">
                                                <td hidden>1</td> 
                                                <td></td>
                                                <td></td>
                                                <td hidden></td>
                                                <td></td>
                                                <td><strong><?php if ($temppo != $row["PO_NO"]){ echo $row["PO_NO"]." <br> ".$row["PO_DATE"];  $poqtytotal = $row["PO_QTY"]; $sumpoqtytotal = $sumpoqtytotal + $poqtytotal; } ?></strong></td>
                                                <td><?php echo $row["GRN_NO"]." <br> ".$row["GRN_DATE"]; ?></td>
                                                <td><?php if ($temppo != $row["PO_NO"]){ echo $row["PO_QTY"]; $pendingme = $row["PO_QTY"]; } ?></td>
                                                <td><?php echo $row["RECEIVED_QTY"]; $poreceivedtotal = $poreceivedtotal + $row["RECEIVED_QTY"]; ?></td>
                                                <td><?php echo $row["REJECTED_QTY"]; $porejectedtotal = $porejectedtotal + $row["REJECTED_QTY"]; ?></td>
                                                <td><?php echo $row["ACCEPTED_QTY"]; $poacceptedtotal = $poacceptedtotal + $row["ACCEPTED_QTY"]; ?></td>
                                                <td><?php $pendingme = $pendingme - $row["ACCEPTED_QTY"]; echo $pendingme; ?></td>
                                                <td><?php echo number_format($row["AMOUNT"],2); $poamounttotal = $poamounttotal + $row["AMOUNT"]; ?></td>
                                                <td><?php echo number_format($row["UNIT_PRICE"],2); ?></td>
                                                <td><?php echo number_format($row["STAX_AMOUNT"],2);  $postaxtotal = $postaxtotal + $row["STAX_INCLU_AMOUNT"];  ?></td>
                                                <td><?php echo number_format($row["STAX_INCLU_AMOUNT"],2);  $pototal = $pototal + $row["STAX_INCLU_AMOUNT"];  ?></td>
                                            </tr>
                                        <?php } else { 
                                            if($tempcode != "") { ?>
                                            <tr style="background-color: white;"><td hidden>1</td><td></td><td></td><td></td><td hidden></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                                        <?php } ?>
                                            <tr style="background-color:rgba(0, 0, 0, 0.05);">
                                                <td hidden>1</td>  
                                                <td><strong><?php echo $row["ITEM_CODE"]; ?></strong></td>
                                                <td>
                                                    <?php $explode = explode(" ",$row["ITEM_DESC"]); ?>
                                                    @foreach($explode as $data1)
                                                    <b>{{$data1}}</b><br>
                                                    @endforeach
                                                </td>   
                                                <td><strong><?php echo $row["UOM_DESC"];  ?></strong></td>
                                                <td hidden></td> 
                                                <td><strong><?php echo $row["PO_NO"]." <br> ".$row["PO_DATE"];  ?></strong></td>
                                                <td><?php echo $row["GRN_NO"]." <br> ".$row["GRN_DATE"]; ?></td>
                                                <td><?php echo $row["PO_QTY"];  $poqtytotal = $row["PO_QTY"]; $sumpoqtytotal = $sumpoqtytotal + $poqtytotal; ?></td>
                                                <td><?php echo $row["RECEIVED_QTY"]; $poreceivedtotal = $poreceivedtotal + $row["RECEIVED_QTY"]; ?></td>
                                                <td><?php echo $row["REJECTED_QTY"]; $porejectedtotal = $porejectedtotal + $row["REJECTED_QTY"]; ?></td>
                                                <td><?php echo $row["ACCEPTED_QTY"]; $poacceptedtotal = $poacceptedtotal + $row["ACCEPTED_QTY"]; ?></td>
                                                <td><?php $pendingme = $row["PO_QTY"]; $pendingme = $pendingme - $row["ACCEPTED_QTY"]; echo $pendingme; ?></td>
                                                <td><?php echo number_format($row["AMOUNT"],2);  $poamounttotal = $poamounttotal + $row["AMOUNT"]; ?></td>
                                                <td><?php echo number_format($row["UNIT_PRICE"],2); $sumtax = $row["STAX_AMOUNT"]; ?></td>
                                                <td><?php echo number_format($row["STAX_AMOUNT"],2); $postaxtotal = $postaxtotal + $row["STAX_INCLU_AMOUNT"]; ?></td>
                                                <td><?php echo number_format($row["STAX_INCLU_AMOUNT"],2);  $pototal = $pototal + $row["STAX_INCLU_AMOUNT"]; ?></td>
                                            </tr>
                                        <?php $poqty = $row["PO_QTY"]; } $tempcode = $row["ITEM_CODE"]; $temppo = $row["PO_NO"]; $pndgcounter++; ?>  
                                        <?php } else { ?>
                                        <?php
                                            $sumof[0] = $sumof[0] + $row["PO_QTY"];
                                            $sumof[1] = $sumof[1] + $row["RECEIVED_QTY"];
                                            $sumof[2] = $sumof[2] + $row["REJECTED_QTY"];
                                            $sumof[3] = $sumof[3] + $row["ACCEPTED_QTY"];
                                            $sumof[5] = $sumof[5] + $row["AMOUNT"];
                                            $sumof[6] = $sumof[6] + $row["STAX_AMOUNT"];
                                            $sumof[7] = $sumof[7] + $row["STAX_INCLU_AMOUNT"];
                                        ?>
                                        <?php if($tempcode == $row["ITEM_CODE"]) { ?>
                                            <tr style="background-color:rgba(0, 0, 0, 0.05);">
                                                <td hidden>1</td> 
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td hidden></td>
                                                <td><strong><?php if ($temppo != $row["PO_NO"]){ echo $row["PO_NO"]." || ".$row["PO_DATE"];  $poqtytotal = $row["PO_QTY"]; $sumpoqtytotal = $sumpoqtytotal + $poqtytotal; } ?></strong></td>
                                                <td><?php echo $row["GRN_NO"]." <br> ".$row["GRN_DATE"]; ?></td>
                                                <td><?php if ($temppo != $row["PO_NO"]){ echo $row["PO_QTY"]; } ?></td>
                                                <td><?php echo $row["RECEIVED_QTY"]; $poreceivedtotal = $poreceivedtotal + $row["RECEIVED_QTY"]; ?></td>
                                                <td><?php echo $row["REJECTED_QTY"]; $porejectedtotal = $porejectedtotal + $row["REJECTED_QTY"]; ?></td>
                                                <td><?php echo $row["ACCEPTED_QTY"]; $poacceptedtotal = $poacceptedtotal + $row["ACCEPTED_QTY"]; ?></td>
                                                <td><?php $pendingme = $pendingme - $row["ACCEPTED_QTY"]; echo $pendingme; ?></td>
                                                <td><?php echo number_format($row["AMOUNT"],2); $poamounttotal = $poamounttotal + $row["AMOUNT"]; ?></td>
                                                <td><?php echo number_format($row["UNIT_PRICE"],2); ?></td>
                                                <td><?php echo number_format($row["STAX_AMOUNT"],2);  $postaxtotal = $postaxtotal + $row["STAX_INCLU_AMOUNT"];  ?></td>
                                                <td><?php echo number_format($row["STAX_INCLU_AMOUNT"],2);  $pototal = $pototal + $row["STAX_INCLU_AMOUNT"];  ?></td>
                                            </tr>
                                        <?php } else {
                                        if($tempcode != "") { ?>
                                            <tr style="background-color:rgba(0, 0, 0, 0.05); font-size: 20px;" hidden>
                                                <td hidden>1</td> 
                                                <td class="font-weight-bold" data-orderable="false"></td>
                                                <td class="font-weight-bold" data-orderable="false"></td>
                                                <td class="font-weight-bold" data-orderable="false"></td>
                                                <td hidden class="font-weight-bold" data-orderable="false"></td>
                                                <td class="font-weight-bold" data-orderable="false"></td>
                                                <td class="font-weight-bold" data-orderable="false"> <b> Total8</b></td>
                                                <td class="font-weight-bold" data-orderable="false"><b>{{number_format($poqtytotal,2)}}</b></td>
                                                <td class="font-weight-bold" data-orderable="false"><b>{{number_format($poreceivedtotal,2)}}</b></td>
                                                <td class="font-weight-bold" data-orderable="false"><b>{{number_format($porejectedtotal,2)}}</b></td>
                                                <td class="font-weight-bold" data-orderable="false"><b>{{number_format($poacceptedtotal,2)}}</b></td>
                                                <td class="font-weight-bold" data-orderable="false"><b>{{number_format($pendingme,2)}}</b></td>
                                                <td class="font-weight-bold" data-orderable="false"><b>{{number_format($poamounttotal,2)}}</b></td>
                                                <td class="font-weight-bold" data-orderable="false"></td>
                                                <td class="font-weight-bold" data-orderable="false"><b>{{number_format($postaxtotal,2)}}</b></td>
                                                <td class="font-weight-bold" data-orderable="false"><b>{{number_format($pototal,2)}}</b></td>
                                            </tr>
                                            <tr style="background-color: white;"><td hidden>1</td><td></td><td></td><td hidden></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                                        <?php } $poqtytotal = $poreceivedtotal = $porejectedtotal = $poacceptedtotal = $pendingme = $postaxtotal = $pototal = $poamounttotal = 0; ?>
                                            <tr style="background-color:rgba(0, 0, 0, 0.05);">
                                                <td hidden>1</td> 
                                                <td><strong><?php echo $row["ITEM_CODE"]; ?></strong></td>
                                                <td>
                                                    <?php $explode = explode(" ",$row["ITEM_DESC"]); ?>
                                                    @foreach($explode as $data1)
                                                        <b>{{$data1}}</b><br>
                                                    @endforeach
                                                </td>
                                                <td><strong><?php echo $row["UOM_DESC"]; ?></strong></td>
                                                <td hidden></td> 
                                                <td><strong><?php echo $row["PO_NO"]." <br> ".$row["PO_DATE"];  ?></strong></td>
                                                <td><?php echo $row["GRN_NO"]." <br> ".$row["GRN_DATE"]; ?></td>
                                                <td><?php echo $row["PO_QTY"];  $poqtytotal = $row["PO_QTY"]; $sumpoqtytotal = $sumpoqtytotal + $poqtytotal; ?></td>
                                                <td><?php echo $row["RECEIVED_QTY"]; $poreceivedtotal = $poreceivedtotal + $row["RECEIVED_QTY"]; ?></td>
                                                <td><?php echo $row["REJECTED_QTY"]; $porejectedtotal = $porejectedtotal + $row["REJECTED_QTY"]; ?></td>
                                                <td><?php echo $row["ACCEPTED_QTY"]; $poacceptedtotal = $poacceptedtotal + $row["ACCEPTED_QTY"]; ?></td>
                                                <td><?php $pendingme = $row["PO_QTY"] - $row["ACCEPTED_QTY"]; echo $pendingme; ?></td>
                                                <td><?php echo number_format($row["AMOUNT"],2);  $poamounttotal = $poamounttotal + $row["AMOUNT"]; ?></td>
                                                <td><?php echo number_format($row["UNIT_PRICE"],2); $sumtax = $row["STAX_AMOUNT"]; ?></td>
                                                <td><?php echo number_format($row["STAX_AMOUNT"],2); $postaxtotal = $postaxtotal + $row["STAX_INCLU_AMOUNT"]; ?></td>
                                                <td><?php echo number_format($row["STAX_INCLU_AMOUNT"],2);  $pototal = $pototal + $row["STAX_INCLU_AMOUNT"]; ?></td>
                                            </tr>
                                        <?php $poqty = $row["PO_QTY"]; } $tempcode = $row["ITEM_CODE"]; $temppo = $row["PO_NO"];  $pndgcounter++; ?>
                                            <tr style="background-color:rgba(0, 0, 0, 0.05); font-size: 15px;">
                                                <td hidden>1</td> 
                                                <td class="font-weight-bold" data-orderable="false"></td>
                                                <td class="font-weight-bold" data-orderable="false"></td>
                                                <td class="font-weight-bold" data-orderable="false"></td>
                                                <td hidden class="font-weight-bold" data-orderable="false"></td>
                                                <td class="font-weight-bold" data-orderable="false">Item</td>
                                                <td class="font-weight-bold" data-orderable="false">Summary</td>
                                                <td class="font-weight-bold" data-orderable="false"><b>{{number_format($poqtytotal,2)}}</b></td>
                                                <td class="font-weight-bold" data-orderable="false"><b>{{number_format($poreceivedtotal,2)}}</b></td>
                                                <td class="font-weight-bold" data-orderable="false"><b>{{number_format($porejectedtotal,2)}}</b></td>
                                                <td class="font-weight-bold" data-orderable="false"><b>{{number_format($poacceptedtotal,2)}}</b></td>
                                                <td class="font-weight-bold" data-orderable="false"><b>{{number_format($pendingme,2)}}</b></td>
                                                <td class="font-weight-bold" data-orderable="false"><b>{{number_format($poamounttotal,2)}}</b></td>
                                                <td class="font-weight-bold" data-orderable="false"></td>
                                                <td class="font-weight-bold" data-orderable="false"><b>{{number_format($postaxtotal,2)}}</b></td>
                                                <td class="font-weight-bold" data-orderable="false"><b>{{number_format($pototal,2)}}</b></td>
                                            </tr>
                                        <?php } ?>
                                        @endforeach
                                    </tbody>
                                    <thead class="bg-dark text-white my-2">
                                        <tr>
                                            <th class="text-white" hidden>.</th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false">Sum of Sums</th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false" hidden></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false">{{number_format($sumpoqtytotal,2)}}</th>
                                            <th class="text-white" data-orderable="false">{{number_format($sumof[1],2)}}</th>
                                            <th class="text-white" data-orderable="false">{{number_format($sumof[2],2)}}</th>
                                            <th class="text-white" data-orderable="false">{{number_format($sumof[3],2)}}</th>
                                            <th class="text-white" data-orderable="false">{{number_format($sumof[4],2)}}</th>
                                            <th class="text-white" data-orderable="false">{{number_format($sumof[5],2)}}</th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false">{{number_format($sumof[6],2)}}</th>
                                            <th class="text-white" data-orderable="false">{{number_format($sumof[7],2)}}</th>
                                        </tr>
                                    </thead>
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
<div class="modal fade bd-example-modal-xl" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" style="margin-top: 10%;">
            <div class="modal-header" style="background: transparent !important;">
            <h5 class="modal-title" id="exampleModalLongTitle">Item Purchasing Movement Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body px-5 py-1">
                    <form method="post" enctype="multipart/form-data" id="myForm">
                        @csrf
                        <div class="form-group row">                            
                            <div class="col-sm-4">
                                <label><b style="color: #6c757d">Book</b></label>
                                <select id="book" name="book" style="border: 1px solid #bfbfbf;" class="select2 form-control mb-3 custom-select">                                    
                                <option selected value="">Select Book</option>
                                @foreach($book as $value)
                                        @if(!empty($sessionData['book']))
                                            <option <?php if($value == $sessionData['book']) echo 'selected="selected"'; ?> value="{{$value}}">{{$value}}</option>
                                        @else
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endif  
                                    @endforeach                  
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label><b style="color: #6c757d">Select Date</b></label>
                                <div class="input-group" style="border: 1px solid #bfbfbf;">   
                                    <input type="text" class="form-control" <?php if(isset($sessionData['strtdte3a'])) echo "value='{{$sessionData['strtdte2a']}} - {{$sessionData['strtdte3a']}}'"; ?> name="daterange">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="dripicons-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label><b style="color: #6c757d">Date</b></label>
                                <select id="thedate" name="thedate" style="border: 1px solid #bfbfbf;" class="form-control select.custom-select" required>     
                                    @if(!empty($sessionData['thedate']))                               
                                        <option <?php if($sessionData['thedate'] == "po") echo 'selected="selected"'; ?> value="po">PO Date</option>
                                        <option <?php if($sessionData['thedate'] == "grn") echo 'selected="selected"'; ?>value="grn">GRN Date</option>         
                                    @else
                                        <option value="po">PO Date</option>
                                        <option value="grn">GRN Date</option>   
                                    @endif                          
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">                           
                            <div class="col-sm-6">
                                <label><b style="color: #6c757d">Item Code From</b></label>
                                <input type="text" class="form-control yourclass" style="border: 1px solid #bfbfbf;" <?php if(isset($sessionData['rmcodef'])) echo "value='{$sessionData['rmcodef']}'"; ?> name="rmcodef" id="rmcodef" placeholder="Item Code From">
                            </div>
                            <div class="col-sm-6">
                                <label><b style="color: #6c757d">Status</b></label>
                                <select id="status" name="status" style="border: 1px solid #bfbfbf;" class="form-control select.custom-select" required>                                    
                                    <option selected value="Both">Both</option>
                                    @if(!empty($sessionData['ostatus'])) 
                                        <option <?php if($sessionData['ostatus'] == "Open") echo 'selected="selected"'; ?> value="Open">Open</option>                                   
                                        <option <?php if($sessionData['ostatus'] == "Closed") echo 'selected="selected"'; ?> value="Closed">Closed</option>      
                                    @else
                                        <option value="Open">Open</option>                                   
                                        <option value="Closed">Closed</option> 
                                    @endif                               
                                </select>
                            </div>
                            <div class="col-sm-2" hidden>
                                <label><b style="color: #6c757d">Item Code To</b></label>
                                <input type="text" class="form-control yourclass" style="border: 1px solid #bfbfbf;" <?php if(isset($sessionData['rmcodet'])) echo "value='{$sessionData['rmcodet']}'"; ?> name="rmcodet" id="rmcodet" placeholder="Item Code To" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label><b style="color: #6c757d">Purchase Order</b></label>
                                <input type="text" class="form-control yourclass" style="border: 1px solid #bfbfbf;" <?php if(isset($sessionData['purchaseorder'])) echo "value='{$sessionData['purchaseorder']}'"; ?> name="purchaseorder" id="purchaseorder" placeholder="Purchase Order">
                            </div>
                            <div class="col-sm-6">
                                <label><b style="color: #6c757d">Supplier</b></label>
                                <input type="text" class="form-control yourclass" style="border: 1px solid #bfbfbf;" <?php if(isset($sessionData['supplier'])) echo "value='{$sessionData['supplier']}'"; ?> name="supplier" id="supplier" placeholder="Supplier">
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
<!-- <script src="plugins/moment/moment.js"></script>
<script src="plugins/apexcharts/apexcharts.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="plugins/chartjs/chart.min.js"></script>
<script src="plugins/chartjs/roundedBar.min.js"></script>
<script src="plugins/lightpick/lightpick.js"></script>
<script src="assets/pages/jquery.sales_dashboard.init.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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
    $("#myForm").attr("action", "item-purchase-report");
    document.getElementById("myForm").submit();
});
$("#download").click(function(){
    $("#myForm").attr("action", "item-purchase-download");
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
    var path1 = "{{route('pono')}}";
    var path2 = "{{route('supplier')}}";
    var path3 = "{{route('itemcode2')}}";  
    $("#purchaseorder").autocomplete({
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
            $('#purchaseorder').val(ui.item.label);
            console.log(ui.item); 
            return false;
        }
    });
    $("#supplier").autocomplete({
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
                $('#supplier').val(ui.item.label);
                console.log(ui.item); 
                return false;
            }
    });
    $("#rmcodef").autocomplete({
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
            $('#rmcodef').val(ui.item.label);
            console.log(ui.item); 
            return false;
        }
    });
</script>
<!-- <script src="plugins/moment/moment.js"></script>
<script src="plugins/apexcharts/apexcharts.min.js"></script>
<script src="plugins/apexcharts/irregular-data-series.js"></script>
<script src="plugins/apexcharts/ohlc.js"></script>
<script src="assets/pages/jquery.apexcharts.init.js"></script> -->
@endsection