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
                    <div class="card-body p-5">
                        <div class="row p-3">
                            <div class="col-md-3 align-self-center">
                                <img src="img/photos/preview.png" alt="logo-small" class="logo-sm mr-2" height="100">
                            </div>
                            <div class="col-md-6 align-self-center text-center">
                                <h3>Specification Sheet</h3>
                                <h5>Material</h5>
                            </div>
                        </div>
                        <div class="row p-5">
                            <div class="col-md-6 py-4" style="display: inline-flex;">
                                <span class="">
                                    @if($data1->price)
                                        <h6 class="mb-0 mr-3"><b>Sale Price (S) :</b></h6>
                                    @endif
                                    @if($data1->profit)
                                        <h6 class="mb-0 mr-3"><b>Actual Cost (S) :</b></h6>
                                    @endif
                                        <h6 class="mb-0 mr-3"><b>Desgin No :</b></h6>
                                        <h6 class="mb-0 mr-3"><b>Description :</b></h6>        
                                    @if($data1->price)                            
                                        <h6 class="mb-0 mr-3"><b>Price Variance :</b></h6>
                                    @endif
                                </span>
                                <span class="">
                                    <h6 class="mb-0">
                                        @if($data1->price)
                                            {{$data1->price}} PKR
                                        @endif
                                    </h6>
                                    <h6 class="mb-0">
                                        @if($data1->profit)
                                            {{$data1->profit}} PKR
                                        @endif
                                    </h6> 
                                    <h6 class="mb-0">{{$data1->design_no}}</h6>
                                    <h6 class="mb-0">{{$data1->description}}</h6>
                                    @if($data1->price)
                                    <div class="table-responsive-sm w-75" style="margin-top: 6px;">
                                        <table class="table table-sm mb-0 text-center">
                                            <thead class="bg-dark">
                                                <tr>
                                                    <th class="text-white" style="font-family: 'Poppins'; font-size: small;">Pricing</th>
                                                    <th class="text-white" style="font-family: 'Poppins'; font-size: small;">Specification</th>
                                                    <th class="text-white" style="font-family: 'Poppins'; font-size: small;">Variance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><span class="badge text-dark">{{$data1->price}} PKR</span></td>
                                                    <td><span class="badge text-dark">{{$data1->profit}} PKR</span></td>
                                                    <?php $total = $data1->price - $data1->profit ?>
                                                    @if($total > 0)
                                                    <td><span class="badge badge-soft-success text-dark">{{$total}}</span></td>
                                                    @elseif($total < 0)
                                                    <td><span class="badge badge-soft-danger text-dark">{{$total}}</span></td>
                                                    @else
                                                    <td><span class="badge badge-soft-dark text-dark">{{$total}}</span></td>
                                                    @endif
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif
                                </span>
                            </div>
                            <div class="col-md-3 py-4" style="display: inline-flex;">
                                <span class="">
                                    <h6 class="mb-0 mr-3"><b>Date :</b></h6>
                                    <h6 class="mb-0 mr-3"><b>Status :</b></h6>
                                    <!-- <h6 class="mb-0 mr-3"><b>Season :</b></h6> -->
                                    <!-- <h6 class="mb-0 mr-3"><b>Category :</b></h6> -->
                                    <!-- <h6 class="mb-0 mr-3"><b>Sequence :</b></h6> -->
                                    <h6 class="mb-0 mr-3"><b>Sale Price (P) :</b></h6>
                                    <h6 class="mb-0 mr-3"><b>Actual Cost (P) :</b></h6>
                                    <h6 class="mb-0 mr-3"><b>Pricing Sheet :</b></h6>
                                    <h6 class="mb-0 mr-3"><b>Purpose :</b></h6>
                                    <h6 class="mb-0 mr-3"><b>Product :</b></h6>
                                </span>
                                <span class="">
                                    <h6 class="mb-0">{{$data1->date}}</h6>
                                    <h6 class="mb-0">
                                        @if($data1->status == 'Final')
                                        <span class="badge badge-soft-success text-dark">Finalized</span>
                                        @elseif($data1->status == 'Approved')
                                        <span class="badge badge-soft-success text-dark">{{$data1->status}}</span>
                                        @else
                                        <span class="badge badge-soft-dark text-dark">{{$data1->status}}</span>
                                        @endif
                                    </h6>
                                    <!-- <h6 class="mb-0">{{$data1->season}}</h6> -->
                                    <!-- <h6 class="mb-0">{{$data1->category}}</h6> -->
                                    <!-- <h6 class="mb-0">{{$data1->sequence}}</h6> -->
                                    <h6 class="mb-0">
                                        @if($GetPricingPrice)
                                            {{$GetPricingPrice}} PKR
                                        @else
                                            &nbsp;
                                        @endif
                                    </h6>
                                    <h6 class="mb-0">
                                        @if($GetPricingProfit)
                                            {{$GetPricingProfit}} PKR
                                        @else
                                            &nbsp;
                                        @endif
                                    </h6>
                                    <h6 class="mb-0">{{$data1->pricing}}</h6>
                                    <h6 class="mb-0">{{$data1->purpose}}</h6>
                                    <h6 class="mb-0">{{$data1->product}}</h6>
                                </span>
                            </div>
                            <div class="col-md-3 col-md-2 py-4 text-center">
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
                                                <th class="text-center text-white">Component</th>
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
                                                <td class="text-center borderTop">{{$value->component}}</td>
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
                                                <td class="text-center borderTop">{{$value->component}}</td>
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
                                                <td class="text-center borderTop">{{$value->component}}</td>
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
                                                <td class="text-center borderTop">{{$value->component}}</td>
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
                                                <td class="text-center borderTop">{{$value->component}}</td>
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
                                                <td class="text-center borderTop">{{$value->component}}</td>
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
                    <div class="card-body p-5">
                        <div class="row p-3">
                            <div class="col-md-3 align-self-center">
                                <img src="img/photos/preview.png" alt="logo-small" class="logo-sm mr-2" height="100">
                            </div>
                            <div class="col-md-6 align-self-center text-center">
                                <h5>Resources</h5>
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
                    <div class="card-body p-5">
                        <div class="row p-3">
                            <div class="col-md-3 align-self-center">
                                <img src="img/photos/preview.png" alt="logo-small" class="logo-sm mr-2" height="100">
                            </div>
                            <div class="col-md-6 align-self-center text-center">
                                <h5>Overheads</h5>
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
                                            @if(!$cuttingData_o)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="12" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($cuttingData_o as $value)
                                            <tr>
                                                <td class="text-center borderTop">{{$k++}}</td>
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
                                                    <th class="text-center py-1" style="color: #434f5e">{{$DataCutting_o['Pair']}}</th>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td colspan="1" style="border-top: none;" class="px-0">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">INSOLE</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(!$InsoleData_o)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="12" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($InsoleData_o as $value)
                                            <tr>
                                                <td class="text-center borderTop">{{$k++}}</td>
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
                                                    <th class="text-center py-1" style="color: #434f5e">{{$DataInsole_o['Pair']}}</th>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td colspan="1" style="border-top: none;" class="px-0">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">Lamination</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(!$LaminationData_o)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="12" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($LaminationData_o as $value)
                                            <tr>
                                                <td class="text-center borderTop">{{$k++}}</td>
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
                                                    <th class="text-center py-1" style="color: #434f5e">{{$DataLamination_o['Pair']}}</th>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td colspan="1" style="border-top: none;" class="px-0">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">Closing</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(!$ClosingData_o)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="12" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($ClosingData_o as $value)
                                            <tr>
                                                <td class="text-center borderTop">{{$k++}}</td>
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
                                                    <th class="text-center py-1" style="color: #434f5e">{{$DataClosing_o['Pair']}}</th>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td colspan="1" style="border-top: none;" class="px-0">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">Lasting</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(!$LastingData_o)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="12" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($LastingData_o as $value)
                                            <tr>
                                                <td class="text-center borderTop">{{$k++}}</td>
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
                                                    <th class="text-center py-1" style="color: #434f5e">{{$DataLasting_o['Pair']}}</th>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td colspan="1" style="border-top: none;" class="px-0">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">Packing</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(!$PackingData_o)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="12" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($PackingData_o as $value)
                                            <tr>
                                                <td class="text-center borderTop">{{$k++}}</td>
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
                                                    <th class="text-center py-1" style="color: #434f5e">{{$DataPacking_o['Pair']}}</th>
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
    </div>
</div>
<script src="assets/js/customjquery.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script>
    $(document).ready(function(){ 
	    $("#loader1").fadeOut(1200);
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