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
                            <li class="breadcrumb-item"><a href="{{url('pricing-sheet-table')}}">Manage Pricing Sheet</a></li>
                            <li class="breadcrumb-item active" style="font-family: 'Poppins', sans-serif;">Pricing Sheet</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Pricing Sheet</h4>
                </div>
            </div>
        </div>
        <div class="row" id="section1">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-body p-5">
                        <div class="row p-3">
                            <div class="col-md-3 align-self-center">
                                <img src="img/photos/preview.png" alt="logo-small" class="logo-sm mr-2" height="100">
                            </div>
                            <div class="col-md-6 align-self-center text-center">
                                <h3>Pricing Sheet</h3>
                                <h4>Material</h4>
                            </div>
                        </div>
                        <div class="row p-5">
                            <div class="col-md-7 py-4" style="display: inline-flex;">
                                <span class="">
                                    @if($data1->type)
                                    <h6 class="mb-0 mr-3"><b>Type&nbsp;:</b></h6>
                                    @endif
                                    @if($data1->sono)
                                    <h6 class="mb-0 mr-3"><b>SO No&nbsp;:</b></h6>
                                    @endif
                                    @if($data1->profit_price)
                                    <h6 class="mb-0 mr-3"><b>Profit Ratio&nbsp;:</b></h6>
                                    @endif
                                    @if($data1->price)
                                    <h6 class="mb-0 mr-3"><b>Sale Price&nbsp;:</b></h6>
                                    @endif
                                    @if($data1->profit)
                                    <h6 class="mb-0 mr-3"><b>Actual Cost&nbsp;:</b></h6>
                                    @endif
                                    <h6 class="mb-0 mr-3"><b>Desgin No&nbsp;:</b></h6>
                                    <h6 class="mb-0 mr-3"><b>Description&nbsp;:</b></h6>
                                    @if($data1->overhead_id)
                                    <h6 class="mb-0 mr-3"><b>Overhead No&nbsp;:</b></h6>
                                    @endif

                                    @if(count($manual) == 0)
                                    &nbsp;
                                    @else
                                    <h6 class="mb-0 mr-3"><b>Pricing Manual :</b></h6>
                                    @endif
                                </span>
                                <span class="">
                                    <h6 class="mb-0"> 
                                        @if($data1->type)
                                            {{$data1->type}}
                                        @endif
                                    </h6>
                                    <h6 class="mb-0"> 
                                        @if($data1->sono)
                                            {{$data1->sono}}
                                        @endif
                                    </h6>
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
                                    <h6 class="mb-0">{{$data1->design_no}}</h6>
                                    <h6 class="mb-0">{{$data1->description}}</h6> 
                                    <h6 class="mb-0"> 
                                        @if($data1->overhead_id)
                                            Overhead-{{$data1->overhead_id}}
                                        @endif
                                    </h6> 
                                  
                                    @if(count($manual) == 0)
                                    &nbsp;
                                    @else
                                        <hr style="margin-bottom: -10px; border: 0; border-top: 1px solid white;">
                                        <span style="cursor: pointer;" class="badge badge-boxed badge-dark py-1 px-2" data-toggle="modal" data-target="#exampleModalCenter">View</span>
                                    @endif
                                </span>
                            </div>
                            <div class="col-md-3 py-4" style="display: inline-flex;">
                                <span class="">
                                    <h6 class="mb-0 mr-3"><b>Date&nbsp;:</b></h6>
                                    <h6 class="mb-0 mr-3"><b>Status&nbsp;:</b></h6>
                                    <h6 class="mb-0 mr-3"><b>Season&nbsp;:</b></h6>
                                    <h6 class="mb-0 mr-3"><b>Purpose&nbsp;:</b></h6>
                                    <h6 class="mb-0 mr-3"><b>Product&nbsp;:</b></h6>
                                    <h6 class="mb-0 mr-3"><b>Designer&nbsp;:</b></h6>
                                    <h6 class="mb-0 mr-3"><b>Category&nbsp;:</b></h6>
                                    <h6 class="mb-0 mr-3"><b>Sub Category&nbsp;:</b></h6>
                                </span>
                                <span class="">
                                    <h6 class="mb-0">{{$data1->date}}</h6>
                                    <h6 class="mb-0">{{$data1->status}}</h6>
                                    <h6 class="mb-0">{{$data1->season}}</h6>
                                    <h6 class="mb-0">{{$data1->purpose}}</h6>
                                    <h6 class="mb-0">{{$data1->product}}</h6>
                                    <h6 class="mb-0">{{$data1->designer}}</h6>
                                    <h6 class="mb-0">{{$data1->Category->description}}</h6>
                                    <h6 class="mb-0">{{$data1->subcategory}}</h6>
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
                                            @foreach($cuttingData as $value)
                                            <tr>
                                                <td class="text-center borderTop">{{$i++}}</td>
                                                <td class="text-center borderTop">{{$value['value']->item_code}}</td>
                                                <td class="text-center borderTop" style="text-transform: capitalize;">{{$value['value']->description}}</td>
                                                <td class="text-center borderTop">{{$value['value']->uom}}</td>
                                                <td class="text-center borderTop">{{$value['result']}}</td>
                                                <td class="text-center borderTop">{{$value['value']->subdivision}}</td>
                                                <td class="text-center borderTop">{{$value['value']->output}}</td>
                                                <td class="text-center borderTop">{{substr($value['value']->fac_qty, 0,6)}}</td>
                                                <!-- <td class="text-center borderTop">{{$value['value']->total_qty}}</td> -->
                                                <td class="text-center borderTop">{{$value['value']->process}}</td>
                                                <td class="text-center borderTop">{{substr($value['value']->total, 0,6)}}</td>
                                                <td class="text-center borderTop">{{$value['value']->rate}}</td>
                                                <td class="text-center borderTop">{{$value['value']->value}}</td>
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
                                                    <th class="text-center py-1" style="color: #586c85">{{substr($DataCutting['Total'], 0,6)}}</th>
                                                    <th class="text-center py-1" style="color: #434f5e">{{$DataCutting['Rate']}}</th>
                                                    <th class="text-center py-1" style="color: #434f5e">{{substr($DataCutting['Value'], 0,6)}}</th>
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
                                                <td class="text-center borderTop">{{$value['value']->item_code}}</td>
                                                <td class="text-center borderTop" style="text-transform: capitalize;">{{$value['value']->description}}</td>
                                                <td class="text-center borderTop">{{$value['value']->uom}}</td>
                                                <td class="text-center borderTop">{{$value['result']}}</td>
                                                <td class="text-center borderTop">{{$value['value']->subdivision}}</td>
                                                <td class="text-center borderTop">{{$value['value']->output}}</td>
                                                <td class="text-center borderTop">{{substr($value['value']->fac_qty, 0,6)}}</td>
                                                <!-- <td class="text-center borderTop">{{$value['value']->total_qty}}</td> -->
                                                <td class="text-center borderTop">{{$value['value']->process}}</td>
                                                <td class="text-center borderTop">{{substr($value['value']->total, 0,6)}}</td>
                                                <td class="text-center borderTop">{{$value['value']->rate}}</td>
                                                <td class="text-center borderTop">{{$value['value']->value}}</td>
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
                                                    <th class="text-center py-1" style="color: #434f5e">{{substr($DataInsole['Value'], 0,6)}}</th>
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
                                                <td class="text-center borderTop">{{$value['value']->item_code}}</td>
                                                <td class="text-center borderTop" style="text-transform: capitalize;">{{$value['value']->description}}</td>
                                                <td class="text-center borderTop">{{$value['value']->uom}}</td>
                                                <td class="text-center borderTop">{{$value['result']}}</td>
                                                <td class="text-center borderTop">{{$value['value']->subdivision}}</td>
                                                <td class="text-center borderTop">{{$value['value']->output}}</td>
                                                <td class="text-center borderTop">{{substr($value['value']->fac_qty, 0,6)}}</td>
                                                <!-- <td class="text-center borderTop">{{$value['value']->total_qty}}</td> -->
                                                <td class="text-center borderTop">{{$value['value']->process}}</td>
                                                <td class="text-center borderTop">{{substr($value['value']->total, 0,6)}}</td>
                                                <td class="text-center borderTop">{{$value['value']->rate}}</td>
                                                <td class="text-center borderTop">{{$value['value']->value}}</td>
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
                                                    <th class="text-center py-1" style="color: #434f5e">{{substr($DataLamination['Value'], 0,6)}}</th>
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
                                                <td class="text-center borderTop">{{$value['value']->item_code}}</td>
                                                <td class="text-center borderTop" style="text-transform: capitalize;">{{$value['value']->description}}</td>
                                                <td class="text-center borderTop">{{$value['value']->uom}}</td>
                                                <td class="text-center borderTop">{{$value['result']}}</td>
                                                <td class="text-center borderTop">{{$value['value']->subdivision}}</td>
                                                <td class="text-center borderTop">{{$value['value']->output}}</td>
                                                <td class="text-center borderTop">{{substr($value['value']->fac_qty, 0,6)}}</td>
                                                <!-- <td class="text-center borderTop">{{$value['value']->total_qty}}</td> -->
                                                <td class="text-center borderTop">{{$value['value']->process}}</td>
                                                <td class="text-center borderTop">{{substr($value['value']->total, 0,6)}}</td>
                                                <td class="text-center borderTop">{{$value['value']->rate}}</td>
                                                <td class="text-center borderTop">{{$value['value']->value}}</td>
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
                                                    <th class="text-center py-1" style="color: #434f5e">{{substr($DataClosing['Value'], 0,6)}}</th>
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
                                                <td class="text-center borderTop">{{$value['value']->item_code}}</td>
                                                <td class="text-center borderTop" style="text-transform: capitalize;">{{$value['value']->description}}</td>
                                                <td class="text-center borderTop">{{$value['value']->uom}}</td>
                                                <td class="text-center borderTop">{{$value['result']}}</td>
                                                <td class="text-center borderTop">{{$value['value']->subdivision}}</td>
                                                <td class="text-center borderTop">{{$value['value']->output}}</td>
                                                <td class="text-center borderTop">{{substr($value['value']->fac_qty, 0,6)}}</td>
                                                <!-- <td class="text-center borderTop">{{$value['value']->total_qty}}</td> -->
                                                <td class="text-center borderTop">{{$value['value']->process}}</td>
                                                <td class="text-center borderTop">{{substr($value['value']->total, 0,6)}}</td>
                                                <td class="text-center borderTop">{{$value['value']->rate}}</td>
                                                <td class="text-center borderTop">{{$value['value']->value}}</td>
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
                                                    <th class="text-center py-1" style="color: #434f5e">{{substr($DataLasting['Value'], 0,6)}}</th>
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
                                                <td class="text-center borderTop">{{$value['value']->item_code}}</td>
                                                <td class="text-center borderTop" style="text-transform: capitalize;">{{$value['value']->description}}</td>
                                                <td class="text-center borderTop">{{$value['value']->uom}}</td>
                                                <td class="text-center borderTop">{{$value['result']}}</td>
                                                <td class="text-center borderTop">{{$value['value']->subdivision}}</td>
                                                <td class="text-center borderTop">{{$value['value']->output}}</td>
                                                <td class="text-center borderTop">{{substr($value['value']->fac_qty, 0,6)}}</td>
                                                <!-- <td class="text-center borderTop">{{$value['value']->total_qty}}</td> -->
                                                <td class="text-center borderTop">{{$value['value']->process}}</td>
                                                <td class="text-center borderTop">{{substr($value['value']->total, 0,6)}}</td>
                                                <td class="text-center borderTop">{{$value['value']->rate}}</td>
                                                <td class="text-center borderTop">{{$value['value']->value}}</td>
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
                                                    <th class="text-center py-1" style="color: #434f5e">{{substr($DataPacking['Value'], 0,6)}}</th>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row" hidden>
                            <div class="col-md-4 col-md-4 py-4 text-center">
                                <label for=""> <b> Approved By</b></label>
                                <br>
                                <p style="font-family: 'Poppins'; color: #9196a9; font-weight: 500;" class="mb-1">{{Auth::user()->emp_name}}</p>
                                <p style="font-family: 'Poppins'; color: #9196a9; font-weight: 500;">{{Auth::user()->designation}}</p> 
                                <img style=" -webkit-transform:rotate(-20deg);
                                            -moz-transform: rotate(-20deg);
                                            -ms-transform: rotate(-20deg);
                                            -o-transform: rotate(-20deg);
                                            transform: rotate(-20deg);" src="{{ asset('uploads/appsetting/xyz.jpg') }}" alt="profile-user" height="100" class="rounded mt-2">
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
                    <div class="card-body p-5">
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
                                                <th class="text-center text-white">Values Set</th>
                                                <th class="text-center text-white">Description</th>
                                                <th class="text-center text-white">Remarks</th>
                                                <th class="text-center text-white">Rate/Pair</th>
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
                                                <td colspan="1" style="border-top: none;" class="px-0 py-1">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
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
                                                <td colspan="1" style="border-top: none;" class="px-0 py-1">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
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
                                                <td colspan="1" style="border-top: none;" class="px-0 py-1">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
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
                                                <td colspan="1" style="border-top: none;" class="px-0 py-1">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
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
                                                <td colspan="1" style="border-top: none;" class="px-0 py-1">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100 mt-3 mb-1" role="alert">
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
                    <div class="card-body p-5">
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
    </div>
</div>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: transparent;">
                <h5 class="modal-title" id="exampleModalLongTitle">Pricing Manual</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @foreach($manual as $manualdata)
                    <h6 class="mb-0">-  {{$manualdata}}</h6>
                @endforeach
            </div>
            <div class="modal-footer" style="background: transparent;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
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