@extends( (Auth::user()->id == "2") ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<?php
	$id = Auth::user()->id;
	$UserDetail = DB::table("users")->where("id", $id)->pluck('userrole');
	$UserDetail1 = DB::table("newroles")->where("name", $UserDetail)->get();
	$obj = json_decode (json_encode ($UserDetail1), FALSE);
    $storeData = [];
    foreach($obj as $dataa){
        $storeData[$dataa->role_name] = $dataa->value; 
    }
    // print_r($storeData);
?>
<style>
    .borderTop{
        border-top: 1px solid #919191 !important;
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
    html{
        scroll-behavior: smooth;
    }
    #myBtn{
        display: none;
        position: fixed;
        bottom: 72px;
        right: 9px;
        z-index: 99;
        font-size: 16px;
        border: none;
        outline: none;
        background: #1c2d41;
        color: white;
        cursor: pointer;
        padding: 8px;
        border-radius: 4px;
    }
    #myBtn1{
        display: block !important;
        position: fixed;
        top: 5%;
        right: 45%;
        left: 45%;
        z-index: 99;
        font-size: 16px;
        border: none;
        outline: none;
        color: white;
        cursor: pointer;
        padding: 8px;
        border-radius: 4px;
        width: 100%;
    }
    #myBtn2{
        position: fixed;
        bottom: 50%;
        right: -135px;
        z-index: 99;
        font-size: 16px;
        border: none;
        outline: none;
        font-family: inherit;
        color: white;
        cursor: pointer;
        padding: 8px;
        border-radius: 4px;
        -moz-transform:rotate(-90deg);
        -ms-transform:rotate(-90deg);
        -o-transform:rotate(-90deg);
        -webkit-transform:rotate(-90deg);
    }
    #myBtn:hover{
        background-color: #555;
    }
</style>
<div id="loader1" class="rotate" width="100" height="100"></div>
<div class="page-content">
    <div class="container-fluid px-5">
        <div class="row px-2">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="float-right">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{url('specification-sheet-table')}}">Manage Specification Sheet</a></li>
                            <li class="breadcrumb-item active" style="font-family: 'Poppins', sans-serif;">Specification Sheet</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Specification Sheet</h4>
                </div>
            </div>
        </div>
        <div class="row" id="section1">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row p-3">
                            <div class="col-md-3 align-self-center">
                                <img src="img/photos/preview.png" alt="logo-small" class="logo-sm mr-2" height="100">
                            </div>
                            <div class="col-md-6 align-self-center text-center">
                                <h3>Specification Sheet</h3>
                                <h4>Material</h4>
                            </div>
                        </div>
                        <div class="row p-5">
                            <div class="col-md-5 py-4" style="display: inline-flex;">
                                <span class="">
                                    @if($data1->profit_price)
                                        <h6 class="mb-0 mr-3"><b>Profit Ratio :</b></h6>
                                    @endif
                                    @if($data1->price)
                                        <h6 class="mb-0 mr-3"><b>Sale Price :</b></h6>
                                    @endif
                                    @if($data1->profit)
                                        <h6 class="mb-0 mr-3"><b>Actual Cost :</b></h6>
                                    @endif       
                                    @if($data1->price)                            
                                        <h6 class="mb-0 mr-3"><b>Price Variance :</b></h6>
                                    @endif
                                </span>
                                <span class="">
                                    <h6 class="mb-0">
                                        @if($data1->profit_price)
                                            {{$data1->profit_price}} %
                                        @endif
                                    </h6>
                                    <h6 class="mb-0">
                                        @if($data1->price)
                                            {{substr($data1->price, 0,5)}} PKR 
                                        @endif
                                    </h6>
                                    <h6 class="mb-0">
                                        @if($data1->profit)
                                            {{substr($data1->profit, 0,5)}} PKR 
                                        @endif
                                    </h6> 
                                    @if($data1->price)
                                    <div class="table-responsive-sm w-75" style="margin-top: 6px;">
                                        <table class="table table-sm mb-0 text-center">
                                            <thead class="bg-dark">
                                                <tr>
                                                    <th class="text-white px-3" style="font-family: 'Poppins'; font-size: small;">Pricing</th>
                                                    <th class="text-white px-3" style="font-family: 'Poppins'; font-size: small;">Specification</th>
                                                    <th class="text-white px-3" style="font-family: 'Poppins'; font-size: small;">Variance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><span class="badge text-dark">{{substr($data1->price, 0,5)}} PKR</span></td>
                                                    <td><span class="badge text-dark">{{substr($data1->profit, 0,5)}} PKR</span></td>
                                                    <?php $total = $data1->price - $data1->profit ?>
                                                    @if($total > 0)
                                                    <td><span class="badge badge-soft-success text-dark">{{substr($total, 0,6)}}</span></td>
                                                    @elseif($total < 0)
                                                    <td><span class="badge badge-soft-danger text-dark">{{substr($total, 0,6)}}</span></td>
                                                    @else
                                                    <td><span class="badge badge-soft-dark text-dark">{{substr($total, 0,6)}}</span></td>
                                                    @endif
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                </span>
                            </div>
                            <div class="col-md-5 py-4" style="display: inline-flex;">
                                <span class="">
                                    <h6 class="mb-0 mr-3"><b>Status :</b></h6>
                                    <h6 class="mb-0 mr-3"><b>Date :</b></h6>
                                    <h6 class="mb-0 mr-3"><b>Season :</b></h6>
                                    <h6 class="mb-0 mr-3"><b>Desgin No :</b></h6>
                                    <h6 class="mb-0 mr-3"><b>Description :</b></h6> 
                                </span>
                                <span class="">
                                    <h6 class="mb-0">{{$data1->status}}</h6>
                                    <h6 class="mb-0">{{$data1->date}}</h6>
                                    <h6 class="mb-0">{{$data1->season}}</h6>
                                    <h6 class="mb-0">{{$data1->design_no}}</h6>
                                    <h6 class="mb-0">{{$data1->description}}</h6>
                                </span>
                            </div>
                            <div class="col-md-2 col-md-2 py-4 text-center">
                                @if(isset($data1->image) && !empty($data1->image)) 
                                <img src="{{ asset('uploads/appsetting/' . $data1->image) }}" alt="profile-user" height="100" class="rounded mt-2">
                                @else
                                <img src="{{asset('img/photos/10.jpg')}}" alt="profile-user" height="100" class="rounded mt-2">
                                @endif 
                            </div>
                        </div>
                        <div class="row p-3">
                            <div class="col-lg-12">
                                @foreach($colorCounts as $colordata)
                                <div id="accordion">
                                    <div class="card">
                                        <div class="card-header collapsed py-2 text-white text-center" style="border: none; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); cursor: pointer; border-radius: 4px;" id="headingOne11{{$colorCountsNo1++}}" data-toggle="collapse" data-target="#collapseOne1233{{$colorCountsNo2++}}" aria-expanded="true" aria-controls="collapseOne">
                                            <span style="text-transform: capitalize;">{{$colordata['color']}}</span> 
                                        </div>
                                        <div id="collapseOne1233{{$colorCountsNo3++}}" class="collapse" aria-labelledby="headingOne11{{$colorCountsNo4++}}" data-parent="#accordion">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table mb-0">
                                                        <thead class="bg-dark rounded">
                                                            <tr>
                                                                <th class="text-center text-white">#</th>
                                                                <th class="text-center text-white">Material Code</th>
                                                                <th class="text-center text-white">Description</th>
                                                                <th class="text-center text-white">Unit</th>
                                                                <th class="text-center text-white">Division</th>
                                                                <th class="text-center text-white">Sub Division</th>
                                                                <th class="text-center text-white">Output</th>
                                                                <th class="text-center text-white">Consumption <br> Factor</th>
                                                                <!-- <th class="text-center text-white">Consumption <br> Quantity</th> -->
                                                                <th class="text-center text-white">Process <br> Loss %</th>
                                                                <th class="text-center text-white">Total <br> Consumption</th>
                                                                <th class="text-center text-white">Rate/Pair</th>
                                                                <th class="text-center text-white">Total <br> Value</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td colspan="2" style="border-top: none;" class="px-0 py-1">
                                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
                                                                        <label class="mb-0 text-white" style="font-weight: 600;">Cutting</label>
                                                                    </div>
                                                                </td>                                
                                                            </tr>
                                                            @if(!$cuttingData)
                                                            <tr class="no-data text-center" style="border-top: none;">
                                                                <td colspan="12" style="border-top: none;">No Data</td>
                                                            </tr>
                                                            @else
                                                            <?php $CutTotalValue = 0; $CutTotalRate = 0; $CutTotalQty = 0; $CutTotalFac = 0; $CutTotal = 0; ?>
                                                            @foreach($cuttingData as $value)
                                                                @if($value->color == $colordata['color'])
                                                                    <tr>
                                                                        <td class="text-center borderTop">{{$i++}}</td>
                                                                        <td class="text-center borderTop">{{$value->item_code}}</td>
                                                                        <td class="text-center borderTop" style="text-transform: capitalize;">{{$value->description}}</td>
                                                                        <td class="text-center borderTop">{{$value->uom}}</td>
                                                                        <td class="text-center borderTop">{{$value->division}}</td>
                                                                        <td class="text-center borderTop">{{$value->subdivision}}</td>
                                                                        <td class="text-center borderTop">{{$value->output}}</td>
                                                                        <td class="text-center borderTop">{{substr($value->fac_qty, 0,6)}}</td>
                                                                        <!-- <td class="text-center borderTop">{{$value->total_qty}}</td> -->
                                                                        <td class="text-center borderTop">{{$value->process}}</td>
                                                                        <td class="text-center borderTop">{{$value->total}}</td>
                                                                        <td class="text-center borderTop">{{$value->rate}}</td>
                                                                        <td class="text-center borderTop">{{$value->value}}</td>
                                                                    </tr>
                                                                    <?php 
                                                                        $CutTotalValue = $CutTotalValue + $value->value; 
                                                                        $CutTotalRate = $CutTotalRate + $value->rate; 
                                                                        $CutTotalQty = $CutTotalQty + $value->total_qty;
                                                                        $CutTotalFac = $CutTotalFac + $value->fac_qty;
                                                                        $CutTotal = $CutTotal + $value->total; 
                                                                    ?>
                                                                @endif
                                                            @endforeach
                                                                <tr style="background: #cdd3db;" class="rounded">
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #434f5e">Total</th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85">{{substr($CutTotalFac, 0,6)}}</th>
                                                                    <!-- <th class="text-center py-1" style="color: #434f5e">{{$DataCutting['TotalQty']}}</th> -->
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #434f5e">{{substr($CutTotal, 0,6)}}</th>
                                                                    <th class="text-center py-1" style="color: #434f5e">{{$CutTotalRate}}</th>
                                                                    <th class="text-center py-1" style="color: #434f5e">{{$CutTotalValue}}</th>
                                                                </tr>
                                                            @endif
                                                            <tr>
                                                                <td colspan="2" style="border-top: none;" class="px-0 py-1">
                                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
                                                                        <label class="mb-0 text-white" style="font-weight: 600;">INSOLE</label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            @if(!$InsoleData)
                                                            <tr class="no-data text-center" style="border-top: none;">
                                                                <td colspan="12" style="border-top: none;">No Data</td>
                                                            </tr>
                                                            @else
                                                            <?php $ITotalValue = 0; $ITotalRate = 0; $ITotalQty = 0; $ITotalFac = 0; $ITotal = 0; ?>
                                                            @foreach($InsoleData as $value)
                                                                @if($value->color == $colordata['color'])
                                                                    <tr>
                                                                        <td class="text-center borderTop">{{$i++}}</td>
                                                                        <td class="text-center borderTop">{{$value->item_code}}</td>
                                                                        <td class="text-center borderTop" style="text-transform: capitalize;">{{$value->description}}</td>
                                                                        <td class="text-center borderTop">{{$value->uom}}</td>
                                                                        <td class="text-center borderTop">{{$value->division}}</td>
                                                                        <td class="text-center borderTop">{{$value->subdivision}}</td>
                                                                        <td class="text-center borderTop">{{$value->output}}</td>
                                                                        <td class="text-center borderTop">{{substr($value->fac_qty, 0,6)}}</td>
                                                                        <!-- <td class="text-center borderTop">{{$value->total_qty}}</td> -->
                                                                        <td class="text-center borderTop">{{$value->process}}</td>
                                                                        <td class="text-center borderTop">{{$value->total}}</td>
                                                                        <td class="text-center borderTop">{{$value->rate}}</td>
                                                                        <td class="text-center borderTop">{{$value->value}}</td>
                                                                    </tr>
                                                                    <?php 
                                                                        $ITotalValue = $ITotalValue + $value->value; 
                                                                        $ITotalRate = $ITotalRate + $value->rate; 
                                                                        $ITotalQty = $ITotalQty + $value->total_qty;
                                                                        $ITotalFac = $ITotalFac + $value->fac_qty;
                                                                        $ITotal = $ITotal + $value->total; 
                                                                    ?>
                                                                @endif
                                                            @endforeach
                                                                <tr style="background: #cdd3db;" class="rounded">
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #434f5e">Total</th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85">{{substr($ITotalFac, 0,6)}}</th>
                                                                    <!-- <th class="text-center py-1" style="color: #434f5e">{{$DataInsole['TotalQty']}}</th> -->
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #434f5e">{{substr($ITotal, 0,6)}}</th>
                                                                    <th class="text-center py-1" style="color: #434f5e">{{$ITotalRate}}</th>
                                                                    <th class="text-center py-1" style="color: #434f5e">{{$ITotalValue}}</th>
                                                                </tr>
                                                            @endif
                                                            <tr>
                                                                <td colspan="2" style="border-top: none;" class="px-0 py-1">
                                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
                                                                        <label class="mb-0 text-white" style="font-weight: 600;">Lamination</label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            @if(!$LaminationData)
                                                            <tr class="no-data text-center" style="border-top: none;">
                                                                <td colspan="12" style="border-top: none;">No Data</td>
                                                            </tr>
                                                            @else
                                                            <?php $LamTotalValue = 0; $LamTotalRate = 0; $LamTotalQty = 0; $LamTotalFac = 0; $LamTotal = 0; ?>
                                                            @foreach($LaminationData as $value)
                                                                <tr>
                                                                    <td class="text-center borderTop">{{$i++}}</td>
                                                                    <td class="text-center borderTop">{{$value->item_code}}</td>
                                                                    <td class="text-center borderTop" style="text-transform: capitalize;">{{$value->description}}</td>
                                                                    <td class="text-center borderTop">{{$value->uom}}</td>
                                                                    <td class="text-center borderTop">{{$value->division}}</td>
                                                                    <td class="text-center borderTop">{{$value->subdivision}}</td>                                            
                                                                    <td class="text-center borderTop">{{$value->output}}</td>
                                                                    <td class="text-center borderTop">{{substr($value->fac_qty, 0,6)}}</td>
                                                                    <!-- <td class="text-center borderTop">{{$value->total_qty}}</td> -->
                                                                    <td class="text-center borderTop">{{$value->process}}</td>
                                                                    <td class="text-center borderTop">{{$value->total}}</td>
                                                                    <td class="text-center borderTop">{{$value->rate}}</td>
                                                                    <td class="text-center borderTop">{{$value->value}}</td>
                                                                </tr>
                                                                <?php 
                                                                    $LamTotalValue = $LamTotalValue + $value->value; 
                                                                    $LamTotalRate = $LamTotalRate + $value->rate; 
                                                                    $LamTotalQty = $LamTotalQty + $value->total_qty;
                                                                    $LamTotalFac = $LamTotalFac + $value->fac_qty;
                                                                    $LamTotal = $LamTotal + $value->total; 
                                                                ?>
                                                            @endforeach
                                                                <tr style="background: #cdd3db;" class="rounded">
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #434f5e">Total</th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85">{{substr($LamTotalFac, 0,6)}}</th>
                                                                    <!-- <th class="text-center py-1" style="color: #434f5e">{{$DataLamination['TotalQty']}}</th> -->
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #434f5e">{{substr($LamTotal, 0,6)}}</th>
                                                                    <th class="text-center py-1" style="color: #434f5e">{{$LamTotalRate}}</th>
                                                                    <th class="text-center py-1" style="color: #434f5e">{{$LamTotalValue}}</th>
                                                                </tr>
                                                            @endif
                                                            <tr>
                                                                <td colspan="2" style="border-top: none;" class="px-0 py-1">
                                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
                                                                        <label class="mb-0 text-white" style="font-weight: 600;">Closing</label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            @if(!$ClosingData)
                                                            <tr class="no-data text-center" style="border-top: none;">
                                                                <td colspan="12" style="border-top: none;">No Data</td>
                                                            </tr>
                                                            @else
                                                            <?php $CloTotalValue = 0; $CloTotalRate = 0; $CloTotalQty = 0; $CloTotalFac = 0; $CloTotal = 0; ?>
                                                            @foreach($ClosingData as $value)
                                                                <tr>
                                                                    <td class="text-center borderTop">{{$i++}}</td>
                                                                    <td class="text-center borderTop">{{$value->item_code}}</td>
                                                                    <td class="text-center borderTop" style="text-transform: capitalize;">{{$value->description}}</td>
                                                                    <td class="text-center borderTop">{{$value->uom}}</td>
                                                                    <td class="text-center borderTop">{{$value->division}}</td>
                                                                    <td class="text-center borderTop">{{$value->subdivision}}</td>
                                                                    <td class="text-center borderTop">{{$value->output}}</td>
                                                                    <td class="text-center borderTop">{{substr($value->fac_qty, 0,6)}}</td>
                                                                    <!-- <td class="text-center borderTop">{{$value->total_qty}}</td> -->
                                                                    <td class="text-center borderTop">{{$value->process}}</td>
                                                                    <td class="text-center borderTop">{{$value->total}}</td>
                                                                    <td class="text-center borderTop">{{$value->rate}}</td>
                                                                    <td class="text-center borderTop">{{$value->value}}</td>
                                                                </tr>
                                                                <?php 
                                                                    $CloTotalValue = $CloTotalValue + $value->value; 
                                                                    $CloTotalRate = $CloTotalRate + $value->rate; 
                                                                    $CloTotalQty = $CloTotalQty + $value->total_qty;
                                                                    $CloTotalFac = $CloTotalFac + $value->fac_qty;
                                                                    $CloTotal = $CloTotal + $value->total; 
                                                                ?>
                                                            @endforeach
                                                                <tr style="background: #cdd3db;" class="rounded">
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #434f5e">Total</th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85">{{substr($CloTotalFac, 0,6)}}</th>
                                                                    <!-- <th class="text-center py-1" style="color: #434f5e">{{$DataClosing['TotalQty']}}</th> -->
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #434f5e">{{substr($CloTotal, 0,6)}}</th>
                                                                    <th class="text-center py-1" style="color: #434f5e">{{$CloTotalRate}}</th>
                                                                    <th class="text-center py-1" style="color: #434f5e">{{$CloTotalValue}}</th>
                                                                </tr>
                                                            @endif
                                                            <tr>
                                                                <td colspan="2" style="border-top: none;" class="px-0 py-1">
                                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
                                                                        <label class="mb-0 text-white" style="font-weight: 600;">Lasting</label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            @if(!$LastingData)
                                                            <tr class="no-data text-center" style="border-top: none;">
                                                                <td colspan="12" style="border-top: none;">No Data</td>
                                                            </tr>
                                                            @else
                                                            <?php $LastTotalValue = 0; $LastTotalRate = 0; $LastTotalQty = 0; $LastTotalFac = 0; $LastTotal = 0; ?>
                                                            @foreach($LastingData as $value)
                                                                <tr>
                                                                    <td class="text-center borderTop">{{$i++}}</td>
                                                                    <td class="text-center borderTop">{{$value->item_code}}</td>
                                                                    <td class="text-center borderTop" style="text-transform: capitalize;">{{$value->description}}</td>
                                                                    <td class="text-center borderTop">{{$value->uom}}</td>
                                                                    <td class="text-center borderTop">{{$value->division}}</td>
                                                                    <td class="text-center borderTop">{{$value->subdivision}}</td>
                                                                    <td class="text-center borderTop">{{$value->output}}</td>
                                                                    <td class="text-center borderTop">{{substr($value->fac_qty, 0,6)}}</td>
                                                                    <!-- <td class="text-center borderTop">{{$value->total_qty}}</td> -->
                                                                    <td class="text-center borderTop">{{$value->process}}</td>
                                                                    <td class="text-center borderTop">{{$value->total}}</td>
                                                                    <td class="text-center borderTop">{{$value->rate}}</td>
                                                                    <td class="text-center borderTop">{{$value->value}}</td>
                                                                </tr>
                                                                <?php 
                                                                    $LastTotalValue = $LastTotalValue + $value->value; 
                                                                    $LastTotalRate = $LastTotalRate + $value->rate; 
                                                                    $LastTotalQty = $LastTotalQty + $value->total_qty;
                                                                    $LastTotalFac = $LastTotalFac + $value->fac_qty;
                                                                    $LastTotal = $LastTotal + $value->total; 
                                                                ?>
                                                            @endforeach
                                                                <tr style="background: #cdd3db;" class="rounded">
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #434f5e">Total</th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85">{{substr($LastTotalFac, 0,6)}}</th>
                                                                    <!-- <th class="text-center py-1" style="color: #434f5e">{{$DataLasting['TotalQty']}}</th> -->
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #434f5e">{{substr($LastTotal, 0,6)}}</th>
                                                                    <th class="text-center py-1" style="color: #434f5e">{{$LastTotalRate}}</th>
                                                                    <th class="text-center py-1" style="color: #434f5e">{{$LastTotalValue}}</th>
                                                                </tr>
                                                            @endif
                                                            <tr>
                                                                <td colspan="2" style="border-top: none;" class="px-0 py-1">
                                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
                                                                        <label class="mb-0 text-white" style="font-weight: 600;">Packing</label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            @if(!$PackingData)
                                                            <tr class="no-data text-center" style="border-top: none;">
                                                                <td colspan="12" style="border-top: none;">No Data</td>
                                                            </tr>
                                                            @else
                                                            <?php $PTotalValue = 0; $PTotalRate = 0; $PTotalQty = 0; $PTotalFac = 0; $PTotal = 0; ?>
                                                            @foreach($PackingData as $value)
                                                                <tr>
                                                                    <td class="text-center borderTop">{{$i++}}</td>
                                                                    <td class="text-center borderTop">{{$value->item_code}}</td>
                                                                    <td class="text-center borderTop" style="text-transform: capitalize;">{{$value->description}}</td>
                                                                    <td class="text-center borderTop">{{$value->uom}}</td>
                                                                    <td class="text-center borderTop">{{$value->division}}</td>
                                                                    <td class="text-center borderTop">{{$value->subdivision}}</td>
                                                                    <td class="text-center borderTop">{{$value->output}}</td>
                                                                    <td class="text-center borderTop">{{substr($value->fac_qty, 0,6)}}</td>
                                                                    <!-- <td class="text-center borderTop">{{$value->total_qty}}</td> -->
                                                                    <td class="text-center borderTop">{{$value->process}}</td>
                                                                    <td class="text-center borderTop">{{$value->total}}</td>
                                                                    <td class="text-center borderTop">{{$value->rate}}</td>
                                                                    <td class="text-center borderTop">{{$value->value}}</td>
                                                                </tr>
                                                                <?php 
                                                                    $PTotalValue = $PTotalValue + $value->value; 
                                                                    $PTotalRate = $PTotalRate + $value->rate; 
                                                                    $PTotalQty = $PTotalQty + $value->total_qty;
                                                                    $PTotalFac = $PTotalFac + $value->fac_qty;
                                                                    $PTotal = $PTotal + $value->total; 
                                                                ?>
                                                            @endforeach
                                                                <tr style="background: #cdd3db;" class="rounded">
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #434f5e">Total</th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #586c85">{{substr($PTotalFac, 0,6)}}</th>
                                                                    <!-- <th class="text-center py-1" style="color: #434f5e">{{$DataPacking['TotalQty']}}</th> -->
                                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                                    <th class="text-center py-1" style="color: #434f5e">{{substr($PTotal, 0,6)}}</th>
                                                                    <th class="text-center py-1" style="color: #434f5e">{{$PTotalRate}}</th>
                                                                    <th class="text-center py-1" style="color: #434f5e">{{$PTotalValue}}</th>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="row p-3" hidden>
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead class="bg-dark rounded">
                                            <tr>
                                                <th class="text-center text-white">#</th>
                                                <th class="text-center text-white">Material Code</th>
                                                <th class="text-center text-white">Description</th>
                                                <th class="text-center text-white">Unit</th>
                                                <th class="text-center text-white">Division</th>
                                                <th class="text-center text-white">Sub Division</th>
                                                <th class="text-center text-white">Output</th>
                                                <th class="text-center text-white">Consumption <br> Factor</th>
                                                <!-- <th class="text-center text-white">Consumption <br> Quantity</th> -->
                                                <th class="text-center text-white">Process <br> Loss %</th>
                                                <th class="text-center text-white">Total <br> Consumption</th>
                                                <th class="text-center text-white">Rate/Pair</th>
                                                <th class="text-center text-white">Total Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="2" style="border-top: none;" class="px-0 py-1">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">Cutting</label>
                                                    </div>
                                                </td>                                
                                            </tr>
                                            @if(!$cuttingData)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="12" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($cuttingData as $value)
                                                <tr>
                                                    <td class="text-center borderTop">{{$i++}}</td>
                                                    <td class="text-center borderTop">{{$value->item_code}}</td>
                                                    <td class="text-center borderTop" style="text-transform: capitalize;">{{$value->description}}</td>
                                                    <td class="text-center borderTop">{{$value->uom}}</td>
                                                    <td class="text-center borderTop">{{$value->division}}</td>
                                                    <td class="text-center borderTop">{{$value->subdivision}}</td>
                                                    <td class="text-center borderTop">{{$value->output}}</td>
                                                    <td class="text-center borderTop">{{substr($value->fac_qty, 0,6)}}</td>
                                                    <!-- <td class="text-center borderTop">{{$value->total_qty}}</td> -->
                                                    <td class="text-center borderTop">{{$value->process}}</td>
                                                    <td class="text-center borderTop">{{$value->total}}</td>
                                                    <td class="text-center borderTop">{{$value->rate}}</td>
                                                    <td class="text-center borderTop">{{$value->value}}</td>
                                                </tr>
                                            @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #434f5e">Total</th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85">{{substr($DataCutting['Fac'], 0,6)}}</th>
                                                    <!-- <th class="text-center py-1" style="color: #434f5e">{{$DataCutting['TotalQty']}}</th> -->
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #434f5e">{{substr($DataCutting['Total'], 0,6)}}</th>
                                                    <th class="text-center py-1" style="color: #434f5e">{{$DataCutting['Rate']}}</th>
                                                    <th class="text-center py-1" style="color: #434f5e">{{$DataCutting['Value']}}</th>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td colspan="2" style="border-top: none;" class="px-0 py-1">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">INSOLE</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(!$InsoleData)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="12" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($InsoleData as $value)
                                                <tr>
                                                    <td class="text-center borderTop">{{$i++}}</td>
                                                    <td class="text-center borderTop">{{$value->item_code}}</td>
                                                    <td class="text-center borderTop" style="text-transform: capitalize;">{{$value->description}}</td>
                                                    <td class="text-center borderTop">{{$value->uom}}</td>
                                                    <td class="text-center borderTop">{{$value->division}}</td>
                                                    <td class="text-center borderTop">{{$value->subdivision}}</td>
                                                    <td class="text-center borderTop">{{$value->output}}</td>
                                                    <td class="text-center borderTop">{{substr($value->fac_qty, 0,6)}}</td>
                                                    <!-- <td class="text-center borderTop">{{$value->total_qty}}</td> -->
                                                    <td class="text-center borderTop">{{$value->process}}</td>
                                                    <td class="text-center borderTop">{{$value->total}}</td>
                                                    <td class="text-center borderTop">{{$value->rate}}</td>
                                                    <td class="text-center borderTop">{{$value->value}}</td>
                                                </tr>
                                            @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #434f5e">Total</th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85">{{substr($DataInsole['Fac'], 0,6)}}</th>
                                                    <!-- <th class="text-center py-1" style="color: #434f5e">{{$DataInsole['TotalQty']}}</th> -->
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #434f5e">{{substr($DataInsole['Total'], 0,6)}}</th>
                                                    <th class="text-center py-1" style="color: #434f5e">{{$DataInsole['Rate']}}</th>
                                                    <th class="text-center py-1" style="color: #434f5e">{{$DataInsole['Value']}}</th>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td colspan="2" style="border-top: none;" class="px-0 py-1">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">Lamination</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(!$LaminationData)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="12" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($LaminationData as $value)
                                                <tr>
                                                    <td class="text-center borderTop">{{$i++}}</td>
                                                    <td class="text-center borderTop">{{$value->item_code}}</td>
                                                    <td class="text-center borderTop" style="text-transform: capitalize;">{{$value->description}}</td>
                                                    <td class="text-center borderTop">{{$value->uom}}</td>
                                                    <td class="text-center borderTop">{{$value->division}}</td>
                                                    <td class="text-center borderTop">{{$value->subdivision}}</td>                                            
                                                    <td class="text-center borderTop">{{$value->output}}</td>
                                                    <td class="text-center borderTop">{{substr($value->fac_qty, 0,6)}}</td>
                                                    <!-- <td class="text-center borderTop">{{$value->total_qty}}</td> -->
                                                    <td class="text-center borderTop">{{$value->process}}</td>
                                                    <td class="text-center borderTop">{{$value->total}}</td>
                                                    <td class="text-center borderTop">{{$value->rate}}</td>
                                                    <td class="text-center borderTop">{{$value->value}}</td>
                                                </tr>
                                            @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #434f5e">Total</th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85">{{substr($DataLamination['Fac'], 0,6)}}</th>
                                                    <!-- <th class="text-center py-1" style="color: #434f5e">{{$DataLamination['TotalQty']}}</th> -->
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #434f5e">{{substr($DataLamination['Total'], 0,6)}}</th>
                                                    <th class="text-center py-1" style="color: #434f5e">{{$DataLamination['Rate']}}</th>
                                                    <th class="text-center py-1" style="color: #434f5e">{{$DataLamination['Value']}}</th>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td colspan="2" style="border-top: none;" class="px-0 py-1">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">Closing</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(!$ClosingData)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="12" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($ClosingData as $value)
                                                <tr>
                                                    <td class="text-center borderTop">{{$i++}}</td>
                                                    <td class="text-center borderTop">{{$value->item_code}}</td>
                                                    <td class="text-center borderTop" style="text-transform: capitalize;">{{$value->description}}</td>
                                                    <td class="text-center borderTop">{{$value->uom}}</td>
                                                    <td class="text-center borderTop">{{$value->division}}</td>
                                                    <td class="text-center borderTop">{{$value->subdivision}}</td>
                                                    <td class="text-center borderTop">{{$value->output}}</td>
                                                    <td class="text-center borderTop">{{substr($value->fac_qty, 0,6)}}</td>
                                                    <!-- <td class="text-center borderTop">{{$value->total_qty}}</td> -->
                                                    <td class="text-center borderTop">{{$value->process}}</td>
                                                    <td class="text-center borderTop">{{$value->total}}</td>
                                                    <td class="text-center borderTop">{{$value->rate}}</td>
                                                    <td class="text-center borderTop">{{$value->value}}</td>
                                                </tr>
                                            @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #434f5e">Total</th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85">{{substr($DataClosing['Fac'], 0,6)}}</th>
                                                    <!-- <th class="text-center py-1" style="color: #434f5e">{{$DataClosing['TotalQty']}}</th> -->
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #434f5e">{{substr($DataClosing['Total'], 0,6)}}</th>
                                                    <th class="text-center py-1" style="color: #434f5e">{{$DataClosing['Rate']}}</th>
                                                    <th class="text-center py-1" style="color: #434f5e">{{$DataClosing['Value']}}</th>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td colspan="2" style="border-top: none;" class="px-0 py-1">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">Lasting</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(!$LastingData)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="12" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($LastingData as $value)
                                                <tr>
                                                    <td class="text-center borderTop">{{$i++}}</td>
                                                    <td class="text-center borderTop">{{$value->item_code}}</td>
                                                    <td class="text-center borderTop" style="text-transform: capitalize;">{{$value->description}}</td>
                                                    <td class="text-center borderTop">{{$value->uom}}</td>
                                                    <td class="text-center borderTop">{{$value->division}}</td>
                                                    <td class="text-center borderTop">{{$value->subdivision}}</td>
                                                    <td class="text-center borderTop">{{$value->output}}</td>
                                                    <td class="text-center borderTop">{{substr($value->fac_qty, 0,6)}}</td>
                                                    <!-- <td class="text-center borderTop">{{$value->total_qty}}</td> -->
                                                    <td class="text-center borderTop">{{$value->process}}</td>
                                                    <td class="text-center borderTop">{{$value->total}}</td>
                                                    <td class="text-center borderTop">{{$value->rate}}</td>
                                                    <td class="text-center borderTop">{{$value->value}}</td>
                                                </tr>
                                            @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #434f5e">Total</th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85">{{substr($DataLasting['Fac'], 0,6)}}</th>
                                                    <!-- <th class="text-center py-1" style="color: #434f5e">{{$DataLasting['TotalQty']}}</th> -->
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #434f5e">{{substr($DataLasting['Total'], 0,6)}}</th>
                                                    <th class="text-center py-1" style="color: #434f5e">{{$DataLasting['Rate']}}</th>
                                                    <th class="text-center py-1" style="color: #434f5e">{{$DataLasting['Value']}}</th>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td colspan="2" style="border-top: none;" class="px-0 py-1">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">Packing</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(!$PackingData)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="12" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($PackingData as $value)
                                                <tr>
                                                    <td class="text-center borderTop">{{$i++}}</td>
                                                    <td class="text-center borderTop">{{$value->item_code}}</td>
                                                    <td class="text-center borderTop" style="text-transform: capitalize;">{{$value->description}}</td>
                                                    <td class="text-center borderTop">{{$value->uom}}</td>
                                                    <td class="text-center borderTop">{{$value->division}}</td>
                                                    <td class="text-center borderTop">{{$value->subdivision}}</td>
                                                    <td class="text-center borderTop">{{$value->output}}</td>
                                                    <td class="text-center borderTop">{{substr($value->fac_qty, 0,6)}}</td>
                                                    <!-- <td class="text-center borderTop">{{$value->total_qty}}</td> -->
                                                    <td class="text-center borderTop">{{$value->process}}</td>
                                                    <td class="text-center borderTop">{{$value->total}}</td>
                                                    <td class="text-center borderTop">{{$value->rate}}</td>
                                                    <td class="text-center borderTop">{{$value->value}}</td>
                                                </tr>
                                            @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #434f5e">Total</th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85">{{substr($DataPacking['Fac'], 0,6)}}</th>
                                                    <!-- <th class="text-center py-1" style="color: #434f5e">{{$DataPacking['TotalQty']}}</th> -->
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #434f5e">{{substr($DataPacking['Total'], 0,6)}}</th>
                                                    <th class="text-center py-1" style="color: #434f5e">{{$DataPacking['Rate']}}</th>
                                                    <th class="text-center py-1" style="color: #434f5e">{{$DataPacking['Value']}}</th>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="section2">
            <div class="col-lg-12 mx-auto mb-4">
                <br><br><br><br><br>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 mx-auto mb-4">
                <div class="card mb-5">
                    <div class="card-body p-3">
                        <div class="row p-3">
                            <div class="col-md-3 align-self-center">
                                <img src="img/photos/preview.png" alt="logo-small" class="logo-sm mr-2" height="100">
                            </div>
                            <div class="col-md-6 align-self-center text-center">
                                <h4>Resources</h4>
                            </div>
                        </div>
                        <div class="row p-3">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead class="bg-dark rounded">
                                            <tr>
                                                <th class="text-center text-white">#</th>
                                                <th class="text-center text-white">Value Set</th>
                                                <th class="text-center text-white">Description</th>
                                                <th class="text-center text-white">Remarks</th>
                                                <th class="text-center text-white">Rate/Pair</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="1" style="border-top: none;" class="px-0">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">Cutting</label>
                                                    </div>
                                                </td>                                
                                            </tr>
                                            @if(!$cuttingData_r)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="12" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($cuttingData_r as $value)
                                            <tr>
                                                <td class="text-center borderTop">{{$j++}}</td>
                                                <td class="text-center borderTop">{{$value->value_set}}</td>
                                                <td class="text-center borderTop" style="text-transform: capitalize;">{{$value->description}}</td>
                                                <td class="text-center borderTop">{{$value->remarks}}</td>
                                                <td class="text-center borderTop">{{$value->pair}}</td>
                                            </tr>
                                            @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="text-center py-1" style="color: #586c85">Total</th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #434f5e">{{$DataCutting_r['Pair']}}</th>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td colspan="1" style="border-top: none;" class="px-0">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">INSOLE</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(!$InsoleData_r)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="12" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($InsoleData_r as $value)
                                            <tr>
                                                <td class="text-center borderTop">{{$j++}}</td>
                                                <td class="text-center borderTop">{{$value->value_set}}</td>
                                                <td class="text-center borderTop" style="text-transform: capitalize;">{{$value->description}}</td>
                                                <td class="text-center borderTop">{{$value->remarks}}</td>
                                                <td class="text-center borderTop">{{$value->pair}}</td>
                                            </tr>
                                            @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="text-center py-1" style="color: #586c85">Total</th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #434f5e">{{$DataInsole_r['Pair']}}</th>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td colspan="1" style="border-top: none;" class="px-0">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">Lamination</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(!$LaminationData_r)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="12" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($LaminationData_r as $value)
                                            <tr>
                                                <td class="text-center borderTop">{{$j++}}</td>
                                                <td class="text-center borderTop">{{$value->value_set}}</td>
                                                <td class="text-center borderTop" style="text-transform: capitalize;">{{$value->description}}</td>
                                                <td class="text-center borderTop">{{$value->remarks}}</td>
                                                <td class="text-center borderTop">{{$value->pair}}</td>
                                            </tr>
                                            @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="text-center py-1" style="color: #586c85">Total</th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #434f5e">{{$DataLamination_r['Pair']}}</th>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td colspan="1" style="border-top: none;" class="px-0">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">Closing</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(!$ClosingData_r)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="12" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($ClosingData_r as $value)
                                            <tr>
                                                <td class="text-center borderTop">{{$j++}}</td>
                                                <td class="text-center borderTop">{{$value->value_set}}</td>
                                                <td class="text-center borderTop" style="text-transform: capitalize;">{{$value->description}}</td>
                                                <td class="text-center borderTop">{{$value->remarks}}</td>
                                                <td class="text-center borderTop">{{$value->pair}}</td>
                                            </tr>
                                            @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="text-center py-1" style="color: #586c85">Total</th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #434f5e">{{$DataClosing_r['Pair']}}</th>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td colspan="1" style="border-top: none;" class="px-0">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">Lasting</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(!$LastingData_r)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="12" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($LastingData_r as $value)
                                            <tr>
                                                <td class="text-center borderTop">{{$j++}}</td>
                                                <td class="text-center borderTop">{{$value->value_set}}</td>
                                                <td class="text-center borderTop" style="text-transform: capitalize;">{{$value->description}}</td>
                                                <td class="text-center borderTop">{{$value->remarks}}</td>
                                                <td class="text-center borderTop">{{$value->pair}}</td>
                                            </tr>
                                            @endforeach
                                                 <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="text-center py-1" style="color: #586c85">Total</th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #434f5e">{{$DataLasting_r['Pair']}}</th>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td colspan="1" style="border-top: none;" class="px-0">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">Packing</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(!$PackingData_r)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="12" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($PackingData_r as $value)
                                            <tr>
                                                <td class="text-center borderTop">{{$j++}}</td>
                                                <td class="text-center borderTop">{{$value->value_set}}</td>
                                                <td class="text-center borderTop" style="text-transform: capitalize;">{{$value->description}}</td>
                                                <td class="text-center borderTop">{{$value->remarks}}</td>
                                                <td class="text-center borderTop">{{$value->pair}}</td>
                                            </tr>
                                            @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="text-center py-1" style="color: #586c85">Total</th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #586c85"></th>
                                                    <th class="text-center py-1" style="color: #434f5e">{{$DataPacking_r['Pair']}}</th>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
                        <!-- <button id="myBtn2" title="Go to top">Overheads</button>
                        <button id="myBtn3" title="Go to top">Resources</button>
                        <button id="myBtn4" title="Go to top">Material</button> -->
                        <ul id="myBtn2">
                            <li class="mt-3 mr-5">
                                <a href="#section3" style="font-family: 'Poppins';"><button style="transition: all 0.15s ease-in-out; box-shadow: none;" data-scroll type="button" class="btn btn-dark">Overheads</button></a> 
                                <a href="#section2" style="font-family: 'Poppins';"><button style="transition: all 0.15s ease-in-out; box-shadow: none;" data-scroll type="button" class="btn btn-dark">Resources</button></a> 
                                <a onclick="topFunction()" style="font-family: 'Poppins';" data-scroll> <button style="transition: all 0.15s ease-in-out; box-shadow: none;" type="button" class="btn btn-dark">Material</button></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="section3">
            <div class="col-lg-12 mx-auto mb-4">
                <br><br><br><br><br>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 mx-auto mb-4">
                <div class="card mb-5">
                    <div class="card-body p-3">
                        <div class="row p-3">
                            <div class="col-md-3 align-self-center">
                                <img src="img/photos/preview.png" alt="logo-small" class="logo-sm mr-2" height="100">
                            </div>
                            <div class="col-md-6 align-self-center text-center">
                                <h4>Overheads</h4>
                            </div>
                        </div>
                        <div class="row p-3">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead class="bg-dark rounded">
                                            <tr>
                                                <th class="text-center text-white">Dept. <br> Daily Salary</th>
                                                <th class="text-center text-white">Direct <br> Labor OH</th>
                                                <th class="text-center text-white">Indirect <br> Lab OH</th>
                                                <th class="text-center text-white">Indirect <br> Lab OH</th>
                                                <th class="text-center text-white">Total <br> OH</th>
                                                <th class="text-center text-white">Capacity</th>
                                                <th class="text-center text-white">Direct <br> Lab OH</th>
                                                <th class="text-center text-white">In-Direct <br> Lab OH</th>
                                                <th class="text-center text-white">Direct <br> Lab OH</th>
                                                <th class="text-center text-white">Total <br> OH</th>
                                                <th class="text-center text-white">Un-Absorbed <br> OH</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="1" style="border-top: none;" class="px-0 py-1">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">Cutting</label>
                                                    </div>
                                                </td>                                
                                            </tr>
                                            @if(!$cuttingDataF)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="12" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($cuttingDataF as $data)
                                            <tr>
                                                <td class="text-center borderTop">{{$data->pds}}</td>
                                                <td class="text-center borderTop">{{$data->dloh1}}</td>
                                                <td class="text-center borderTop">{{$data->idloh1}}</td>
                                                <td class="text-center borderTop">{{$data->idloh2}}</td>
                                                <td class="text-center borderTop">{{$data->t_oh1}}</td>
                                                <td class="text-center borderTop">{{$data->capacity}}</td>
                                                <td class="text-center borderTop">{{$data->dloh2}}</td>
                                                <td class="text-center borderTop">{{$data->idloh3}}</td>
                                                <td class="text-center borderTop">{{$data->dloh3}}</td>
                                                <td class="text-center borderTop">{{$data->t_oh2}}</td>
                                                <td class="text-center borderTop">{{$data->un_a_oh}}</td>
                                            </tr>
                                            @endforeach
                                            @endif
                                            <tr>
                                                <td colspan="1" style="border-top: none;" class="px-0 py-1">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">INSOLE</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(!$StitchingDataF)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="12" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($StitchingDataF as $data)
                                            <tr>
                                                <td class="text-center borderTop">{{$data->pds}}</td>
                                                <td class="text-center borderTop">{{$data->dloh1}}</td>
                                                <td class="text-center borderTop">{{$data->idloh1}}</td>
                                                <td class="text-center borderTop">{{$data->idloh2}}</td>
                                                <td class="text-center borderTop">{{$data->t_oh1}}</td>
                                                <td class="text-center borderTop">{{$data->capacity}}</td>
                                                <td class="text-center borderTop">{{$data->dloh2}}</td>
                                                <td class="text-center borderTop">{{$data->idloh3}}</td>
                                                <td class="text-center borderTop">{{$data->dloh3}}</td>
                                                <td class="text-center borderTop">{{$data->t_oh2}}</td>
                                                <td class="text-center borderTop">{{$data->un_a_oh}}</td>
                                            </tr>
                                            @endforeach
                                            @endif
                                            <tr>
                                                <td colspan="1" style="border-top: none;" class="px-0 py-1">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">Lamination</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(!$LastingDataF)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="12" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($LastingDataF as $data)
                                            <tr>
                                                <td class="text-center borderTop">{{$data->pds}}</td>
                                                <td class="text-center borderTop">{{$data->dloh1}}</td>
                                                <td class="text-center borderTop">{{$data->idloh1}}</td>
                                                <td class="text-center borderTop">{{$data->idloh2}}</td>
                                                <td class="text-center borderTop">{{$data->t_oh1}}</td>
                                                <td class="text-center borderTop">{{$data->capacity}}</td>
                                                <td class="text-center borderTop">{{$data->dloh2}}</td>
                                                <td class="text-center borderTop">{{$data->idloh3}}</td>
                                                <td class="text-center borderTop">{{$data->dloh3}}</td>
                                                <td class="text-center borderTop">{{$data->t_oh2}}</td>
                                                <td class="text-center borderTop">{{$data->un_a_oh}}</td>
                                            </tr>
                                            @endforeach
                                            @endif
                                            <tr>
                                                <td colspan="1" style="border-top: none;" class="px-0 py-1">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">Closing</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(!$ClosingDataF)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="12" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($ClosingDataF as $data)
                                            <tr>
                                                <td class="text-center borderTop">{{$data->pds}}</td>
                                                <td class="text-center borderTop">{{$data->dloh1}}</td>
                                                <td class="text-center borderTop">{{$data->idloh1}}</td>
                                                <td class="text-center borderTop">{{$data->idloh2}}</td>
                                                <td class="text-center borderTop">{{$data->t_oh1}}</td>
                                                <td class="text-center borderTop">{{$data->capacity}}</td>
                                                <td class="text-center borderTop">{{$data->dloh2}}</td>
                                                <td class="text-center borderTop">{{$data->idloh3}}</td>
                                                <td class="text-center borderTop">{{$data->dloh3}}</td>
                                                <td class="text-center borderTop">{{$data->t_oh2}}</td>
                                                <td class="text-center borderTop">{{$data->un_a_oh}}</td>
                                            </tr>
                                            @endforeach
                                            @endif
                                            <tr>
                                                <td colspan="1" style="border-top: none;" class="px-0 py-1">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">Lasting</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(!$LastingDataF)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="12" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($LastingDataF as $data)
                                            <tr>
                                                <td class="text-center borderTop">{{$data->pds}}</td>
                                                <td class="text-center borderTop">{{$data->dloh1}}</td>
                                                <td class="text-center borderTop">{{$data->idloh1}}</td>
                                                <td class="text-center borderTop">{{$data->idloh2}}</td>
                                                <td class="text-center borderTop">{{$data->t_oh1}}</td>
                                                <td class="text-center borderTop">{{$data->capacity}}</td>
                                                <td class="text-center borderTop">{{$data->dloh2}}</td>
                                                <td class="text-center borderTop">{{$data->idloh3}}</td>
                                                <td class="text-center borderTop">{{$data->dloh3}}</td>
                                                <td class="text-center borderTop">{{$data->t_oh2}}</td>
                                                <td class="text-center borderTop">{{$data->un_a_oh}}</td>
                                            </tr>
                                            @endforeach
                                            @endif
                                            <tr>
                                                <td colspan="1" style="border-top: none;" class="px-0 py-1">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">Packing</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(!$PackingDataF)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="12" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($PackingDataF as $data)
                                            <tr>
                                                <td class="text-center borderTop">{{$data->pds}}</td>
                                                <td class="text-center borderTop">{{$data->dloh1}}</td>
                                                <td class="text-center borderTop">{{$data->idloh1}}</td>
                                                <td class="text-center borderTop">{{$data->idloh2}}</td>
                                                <td class="text-center borderTop">{{$data->t_oh1}}</td>
                                                <td class="text-center borderTop">{{$data->capacity}}</td>
                                                <td class="text-center borderTop">{{$data->dloh2}}</td>
                                                <td class="text-center borderTop">{{$data->idloh3}}</td>
                                                <td class="text-center borderTop">{{$data->dloh3}}</td>
                                                <td class="text-center borderTop">{{$data->t_oh2}}</td>
                                                <td class="text-center borderTop">{{$data->un_a_oh}}</td>
                                            </tr>
                                            @endforeach
                                            @endif
                                            <tr style="background: #cdd3db;" class="rounded">
                                                <th class="text-center py-1" style="color: #24282c; border-top: 2px solid transparent;">Total</th>
                                                <th class="text-center py-1" style="color: #24282c; border-top: 2px solid transparent;">{{number_format((float)$AllData['dloh1_total'], 2, '.', '')}}</th>
                                                <th class="text-center py-1" style="color: #24282c; border-top: 2px solid transparent;">{{number_format((float)$AllData['idloh1_total'], 2, '.', '')}}</th>
                                                <th class="text-center py-1" style="color: #24282c; border-top: 2px solid transparent;">{{number_format((float)$AllData['idloh2_total'], 2, '.', '')}}</th>
                                                <th class="text-center py-1" style="color: #24282c; border-top: 2px solid transparent;">{{number_format((float)$AllData['t_oh1_total'], 2, '.', '')}}</th>
                                                <th class="text-center py-1" style="color: #586c85; border-top: 2px solid transparent;"></th>
                                                <th class="text-center py-1" style="color: #24282c; border-top: 2px solid transparent;">{{number_format((float)$AllData['dloh2_total'], 2, '.', '')}}</th>
                                                <th class="text-center py-1" style="color: #24282c; border-top: 2px solid transparent;">{{number_format((float)$AllData['idloh3_total'], 2, '.', '')}}</th>
                                                <th class="text-center py-1" style="color: #24282c; border-top: 2px solid transparent;">{{number_format((float)$AllData['dloh3_total'], 2, '.', '')}}</th>
                                                <th class="text-center py-1" style="color: #24282c; border-top: 2px solid transparent;">{{number_format((float)$AllData['t_oh2_total'], 2, '.', '')}}</th>
                                                <th class="text-center py-1" style="color: #24282c; border-top: 2px solid transparent;">{{number_format((float)$AllData['un_a_oh_total'], 2, '.', '')}}</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row p-3 mt-5">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead class="bg-dark rounded">
                                            <tr>
                                                <th class="text-center text-white" style="border: 1px solid #1c2d41;">RMC</th>
                                                <th class="text-center text-white" style="border: 1px solid #1c2d41;">Total OH</th>
                                                <th class="text-center text-white" style="border: 1px solid #1c2d41;">Un-Absorbed OH</th>
                                                <th class="text-center text-white" style="border: 1px solid #1c2d41;">Total Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="color: #5e5e5e; border: 1px solid #919191;" class="text-center"><b>100</b></td>
                                                <td style="color: #5e5e5e; border: 1px solid #919191;" class="text-center"><b>{{number_format((float)$AllData['t_oh1_total'], 2, '.', '')}}</b></td>
                                                <td style="color: #5e5e5e; border: 1px solid #919191;" class="text-center"><b>{{number_format((float)$AllData['un_a_oh_total'], 2, '.', '')}}</b></td>
                                                <?php $result = 100 + $AllData['t_oh1_total'] + $AllData['un_a_oh_total']?> 
                                                <td style="color: #5e5e5e; border: 1px solid #919191;" class="text-center"><b>{{number_format((float)$result, 2, '.', '')}}</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/customjquery.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script>
    $(document).ready(function(){ 
	    $("#loader1").fadeOut(1200);
        $("body").addClass("enlarge-menu");
    });
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch (type) {
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
</script>
<script>
let mybutton = document.getElementById("myBtn");
window.onscroll = function() {scrollFunction()};
function scrollFunction(){
    if(document.body.scrollTop > 20 || document.documentElement.scrollTop > 20){
        mybutton.style.display = "block";
    } 
    else{
        mybutton.style.display = "none";
    }
}
function topFunction(){
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}
</script>
@endsection