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
    #loader1 {  
        position: fixed;  
        left: 0px;  
        top: 0px;  
        width: 100%;  
        height: 100%;  
        z-index: 9999;  
        background: url("/img/avatars/3dgifmaker.gif") 50% 50% no-repeat black;  
    }
</style>
<div id="loader1" class="rotate" width="100" height="100"></div>
<div class="page-content">
    <div class="container-fluid">
        <div class="row px-2">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="float-right">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{url('job-order-table')}}">Manage Job Order</a></li>
                            <li class="breadcrumb-item active">Job Order</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Job Order</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9 mx-auto mb-4">
                <div class="card mb-5">
                    <div class="card-body">
                        <div class="row p-3">
                            <div class="col-md-3 align-self-center">
                                <img src="img/photos/preview.png" alt="logo-small" class="logo-sm mr-2" height="100">
                            </div>
                            <div class="col-md-6 align-self-center text-center">
                                <h3>Final Sample Specification Sheet</h3>
                            </div>
                        </div>
                        <div class="row p-5">
                            <div class="col-md-4 py-4" style="display: inline-flex;">
                                <span class="">
                                    <h6 class="mb-0 mr-3"><b>Last :</b></h6>
                                    <h6 class="mb-0 mr-3"><b>Color :</b></h6>
                                    <h6 class="mb-0 mr-3"><b>Season :</b></h6>
                                    <h6 class="mb-0 mr-3"><b>Article Code :</b></h6>
                                </span>
                                <span class="">
                                    <h6 class="mb-0">{{$data1->last}}</h6>
                                    <h6 class="mb-0">{{$data1->color}}</h6>
                                    <h6 class="mb-0">{{$data1->season}}</h6>
                                    <h6 class="mb-0">{{$data1->article}}</h6>
                                </span>
                            </div>
                            <div class="col-md-5 py-4" style="display: inline-flex;">
                                <span class="">
                                    <h6 class="mb-0 mr-3"><b>Date :</b></h6>
                                    <h6 class="mb-0 mr-3"><b>Sample No :</b></h6>
                                    <h6 class="mb-0 mr-3"><b>Prodcut No :</b></h6>
                                    <h6 class="mb-0 mr-3"><b>Sequence No :</b></h6>
                                </span>
                                <span class="">
                                    <h6 class="mb-0">{{$data1->date}}</h6>
                                    <h6 class="mb-0">{{$data1->sample}}</h6>
                                    <h6 class="mb-0">{{$data1->product}}</h6>
                                    <h6 class="mb-0">{{$data1->sequence}}</h6>
                                </span>
                            </div>
                            <div class="col-sm-3 col-md-2 py-4 text-center">
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
                                                <th class="text-center text-white">Type</th>
                                                <th class="text-center text-white">Use</th>
                                                <th class="text-center text-white">Tools</th>
                                                <th class="text-center text-white text-center">Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="2" style="border-top: none;" class="px-0">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">Upper Materials</label>
                                                    </div>
                                                </td>                                
                                            </tr>
                                            @if(!$upperData)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="8" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($upperData as $value)
                                            <tr>
                                                <td class="text-center borderTop">{{$i++}}</td>
                                                <td class="text-center borderTop">{{$value->item_code}}</td>
                                                <td class="text-center borderTop" style="text-transform: capitalize;">{{$value->description}}</td>
                                                <td class="text-center borderTop">{{$value->uom}}</td>
                                                <td class="text-center borderTop">{{$value->type}}</td>
                                                <td class="text-center borderTop">{{$value->tools}}</td>
                                                <td class="text-center borderTop">{{$value->usages}}</td>
                                                <td class="text-center borderTop">{{$value->quantity}}</td>
                                            </tr>
                                            @endforeach
                                            @endif
                                            <tr>
                                                <td colspan="2" style="border-top: none;" class="px-0">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">Linning Materials</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(!$linningData)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="8" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($linningData as $value)
                                            <tr>
                                                <td class="text-center borderTop">{{$i++}}</td>
                                                <td class="text-center borderTop">{{$value->item_code}}</td>
                                                <td class="text-center borderTop" style="text-transform: capitalize;">{{$value->description}}</td>
                                                <td class="text-center borderTop">{{$value->uom}}</td>
                                                <td class="text-center borderTop">{{$value->type}}</td>
                                                <td class="text-center borderTop">{{$value->tools}}</td>
                                                <td class="text-center borderTop">{{$value->usages}}</td>
                                                <td class="text-center borderTop">{{$value->quantity}}</td>
                                            </tr>
                                            @endforeach
                                            @endif
                                            <tr>
                                                <td colspan="2" style="border-top: none;" class="px-0">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">Stiching Materials</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(!$stichingData)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="8" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($stichingData as $value)
                                            <tr>
                                                <td class="text-center borderTop">{{$i++}}</td>
                                                <td class="text-center borderTop">{{$value->item_code}}</td>
                                                <td class="text-center borderTop" style="text-transform: capitalize;">{{$value->description}}</td>
                                                <td class="text-center borderTop">{{$value->uom}}</td>
                                                <td class="text-center borderTop">{{$value->type}}</td>
                                                <td class="text-center borderTop">{{$value->tools}}</td>
                                                <td class="text-center borderTop">{{$value->usages}}</td>
                                                <td class="text-center borderTop">{{$value->quantity}}</td>
                                            </tr>
                                            @endforeach
                                            @endif
                                            <tr>
                                                <td colspan="2" style="border-top: none;" class="px-0">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">Outsole Materials</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(!$outsoleData)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="8" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($outsoleData as $value)
                                            <tr>
                                                <td class="text-center borderTop">{{$i++}}</td>
                                                <td class="text-center borderTop">{{$value->item_code}}</td>
                                                <td class="text-center borderTop" style="text-transform: capitalize;">{{$value->description}}</td>
                                                <td class="text-center borderTop">{{$value->uom}}</td>
                                                <td class="text-center borderTop">{{$value->type}}</td>
                                                <td class="text-center borderTop">{{$value->tools}}</td>
                                                <td class="text-center borderTop">{{$value->usages}}</td>
                                                <td class="text-center borderTop">{{$value->quantity}}</td>
                                            </tr>
                                            @endforeach
                                            @endif
                                            <tr>
                                                <td colspan="2" style="border-top: none;" class="px-0">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">Insole Materials</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(!$insoleData)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="8" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($insoleData as $value)
                                            <tr>
                                                <td class="text-center borderTop">{{$i++}}</td>
                                                <td class="text-center borderTop">{{$value->item_code}}</td>
                                                <td class="text-center borderTop" style="text-transform: capitalize;">{{$value->description}}</td>
                                                <td class="text-center borderTop">{{$value->uom}}</td>
                                                <td class="text-center borderTop">{{$value->type}}</td>
                                                <td class="text-center borderTop">{{$value->tools}}</td>
                                                <td class="text-center borderTop">{{$value->usages}}</td>
                                                <td class="text-center borderTop">{{$value->quantity}}</td>
                                            </tr>
                                            @endforeach
                                            @endif
                                            <tr>
                                                <td colspan="2" style="border-top: none;" class="px-0">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">Socks Materials</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(!$socksData)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="8" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($socksData as $value)
                                            <tr>
                                                <td class="text-center borderTop">{{$i++}}</td>
                                                <td class="text-center borderTop">{{$value->item_code}}</td>
                                                <td class="text-center borderTop" style="text-transform: capitalize;">{{$value->description}}</td>
                                                <td class="text-center borderTop">{{$value->uom}}</td>
                                                <td class="text-center borderTop">{{$value->type}}</td>
                                                <td class="text-center borderTop">{{$value->tools}}</td>
                                                <td class="text-center borderTop">{{$value->usages}}</td>
                                                <td class="text-center borderTop">{{$value->quantity}}</td>
                                            </tr>
                                            @endforeach
                                            @endif
                                            <tr>
                                                <td colspan="2" style="border-top: none;" class="px-0">
                                                    <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-1 text-center w-100" role="alert">
                                                        <label class="mb-0 text-white" style="font-weight: 600;">General Materials</label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @if(!$generalData)
                                            <tr class="no-data text-center" style="border-top: none;">
                                                <td colspan="8" style="border-top: none;">No Data</td>
                                            </tr>
                                            @else
                                            @foreach($generalData as $value)
                                            <tr>
                                                <td class="text-center borderTop">{{$i++}}</td>
                                                <td class="text-center borderTop">{{$value->item_code}}</td>
                                                <td class="text-center borderTop" style="text-transform: capitalize;">{{$value->description}}</td>
                                                <td class="text-center borderTop">{{$value->uom}}</td>
                                                <td class="text-center borderTop">{{$value->type}}</td>
                                                <td class="text-center borderTop">{{$value->tools}}</td>
                                                <td class="text-center borderTop">{{$value->usages}}</td>
                                                <td class="text-center borderTop">{{$value->quantity}}</td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center py-5">
                            <div class="col-sm-3 text-center">
                                <label><b>Prepared By</b></label>
                                <div class="checkbox checkbox-primary">
                                    <input id="prepared" name="prepared" type="checkbox">
                                    <label for="prepared">{{auth()->user()->firstname}} {{auth()->user()->lastname}}</label>
                                </div>
                            </div>
                            <div class="col-sm-3 text-center">
                                <label><b>Checked By</b></label>
                                <div class="checkbox checkbox-primary">
                                    <input id="checked" name="checked" type="checkbox">
                                    <label for="checked">{{auth()->user()->firstname}} {{auth()->user()->lastname}}</label>
                                </div>
                            </div>
                            <div class="col-sm-3 text-center">
                                <label><b>Quality Control</b></label>
                                <div class="checkbox checkbox-primary">
                                    <input id="qc" name="qc" type="checkbox">
                                    <label for="qc">{{auth()->user()->firstname}} {{auth()->user()->lastname}}</label>
                                </div>
                            </div>
                            <div class="col-sm-3 text-center">
                                <label><b>Approved By</b></label>
                                <div class="checkbox checkbox-primary">
                                    <input id="approved" name="approved" type="checkbox">
                                    <label for="approved">{{auth()->user()->firstname}} {{auth()->user()->lastname}}</label>
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
                showConfirmButton: false,
                timer: 2000
            });
            break;
    }
    @endif
</script>
@endsection