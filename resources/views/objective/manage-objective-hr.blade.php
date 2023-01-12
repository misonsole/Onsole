@extends( (Auth::user()->id == "2") ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
{{-- Start MultiSelect --}}
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- End MultiSelect --}}

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
    .noBorder
    {
        border-right: none !important;
        border-left: none !important;
    }
    .page-item.active .page-link 
    {
        z-index: 3;
        color: #fff;
        background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;
        border-color: transparent;
    }
    /* .btn:hover, .btn:active, .btn:visited 
    {
        background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;
        border: 1px solid transparent !important;
        color: white;
    } */
    .btn-outline:hover, .btn-outline:active, .btn-outline:visited 
    {
        background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;
        border: 1px solid transparent !important;
        color: white;
    }
    #loader1 
    {  
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
    <div class="container-fluid px-4">
        <div class="row px-1">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="float-right">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Manage Users</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Manage Users HR<a href="{{url('all-objective')}}"> <button type="button" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-3 py-1 text-white mx-3">View All Objectives</button></a></h4>                    
                </div>
            </div>
        </div>
        <div class="row">
            @if(isset($dep))
                <div class="col-3">
                    <form action="{{url('obj-department-1')}}" id="myForm" method="post" enctype="multipart/form-data">
                        @csrf
                        <label for="exampleInputEmail1"><strong>Select Department</strong></label>
                        <select id="deppp" name="dep" class="form-control">
                            <option selected disabled>Select Department</option>   
                            @foreach($dep as $name)
                                <option <?php if($name->name == $department) echo 'selected="selected"'; ?> value="{{ $name->name }}">{{ $name->name }}</option>
                            @endforeach
                        </select><br>
                    </form>
                </div>
            @endif
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body table-responsive p-5">
                        <div class="">
                            <table id="datatable2" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th data-orderable="false" class="text-white"></th>
                                        <th>No</th>
                                        <th>Member</th>
                                        <!-- <th>Lead</th> -->
                                        <th>Department</th>
                                        <th>Status</th>
                                        <th class="text-center">Objectives</th>
                                        <th class="text-center">Action</th>
                                        <th class="text-center">Rate</th>
                                        <th class="text-center" hidden>Rating</th>
                                        <th class="text-center">Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $user)
                                    <tr>
                                        <td><input type="checkbox" class="sub_chk" data-id="{{$user->name}}"></td>
                                        <td>{{$i++}}</td>  
                                        <td style="width: 10%;">{{$user->name}}</td>
                                        <!-- <td>{{$user->lead_name}}</td> -->
                                        <td>
                                            <?php $explode = explode(" ",$user->department); ?>
                                            @foreach($explode as $data1)
                                                {{$data1}}<br>
                                            @endforeach
                                        </td> 
                                        <td class="text-center">
                                            @if($user->status == 1)    
                                                <span class="badge badge-md badge-boxed badge-soft-warning p-2 w-50">Pending</span>
                                                <span class="badge cursor-pointer" style="cursor: pointer; font-size: small; font-weight: 500;">
                                                    <i class="align-middle mb-1 mt-1 mx-1 cursor-pointer text-white" style="size:1px;" data-feather="eye"></i>
                                                </span>
                                            @elseif($user->status == 2)
                                                <span class="badge badge-md badge-boxed badge-soft-success p-2 w-50">In-Review HR</span>
                                                <span class="badge cursor-pointer" style="cursor: pointer; font-size: small; font-weight: 500;">
                                                    <i class="align-middle mb-1 mt-1 mx-1 cursor-pointer text-white" style="size:1px;" data-feather="eye"></i>
                                                </span>
                                            @elseif($user->status == 3)
                                                <span class="badge badge-md badge-boxed badge-soft-danger p-2 w-50">Revision</span>
                                                <span id="btnapp" data-id="{{$user->reason}}" class="badge fa-eyeshow" style="font-size: small; font-weight: 500; cursor: pointer">
                                                    <i class="align-middle mb-1 mt-1 mx-1 text-dark" data-feather="eye"></i>
                                                </span>                                                      
                                            @elseif($user->status == 4)
                                                <span class="badge badge-md badge-boxed badge-soft-secondary p-2 w-50">Finalised</span>
                                                <span id="btnapp" data-id="{{$user->reason}}" class="badge fa-eyeshow" style="font-size: small; font-weight: 500; cursor: pointer">
                                                    <i class="align-middle mb-1 mt-1 mx-1 cursor-pointer text-dark" data-feather="eye"></i>
                                                </span> 
                                            @endif
                                            <div class="modal fade" id="exampleModalCenter9" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="form-group row py-2 text-center">
                                                                <div class="col-sm-12 mb-1 mb-sm-0">
                                                                    <label for=""><h4 style="color: #6c757d">Remarks</h4></label>
                                                                    <hr>
                                                                    <p id="pp"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div style="background: none;" class="modal-footer">
                                                            <button type="button" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn fa-eyeee text-white" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <form action="show-obj">
                                                <input type="text" value="{{$user->emp_code}}" id="id" name="id" hidden>
                                                    <button type="submit" class="btn btn-outline-dark btn-sm">View</button>
                                                    <button style="background: none; border: none;" type="submit" hidden>
                                                        <span class="badge badge-dark p-3" style="background: #192636; font-size: small; font-weight: 500;">Show Objectives</span>
                                                    </button> 
                                            </form>
                                        </td>
                                        @if(isset($hr))
                                        <td style="width: 12%;" class="text-center">
                                        @if($user->status == 1)    
                                        -
                                        @elseif($user->status == 2)
                                            <button class="btn btn-outline-success my-1 btn-sm fa-eyeehrRej11" data-id="{{$user->name}}" style="box-shadow: none;">Finalise</button>
                                            <button class="btn btn-outline-danger my-1 btn-sm fa-eyeehrRej" data-id="{{$user->name}}" style="box-shadow: none;">Revision</button>
                                            @elseif($user->status == 3)
                                                <span class="badge badge-dark p-3 cursor-pointer" style="background: #202020; font-size: small; font-weight: 500;"></span>
                                            @elseif($user->status == 4)
                                                @if(isset($storeData['Objective-Revision']) && !empty($storeData['Objective-Revision'])) 
                                                    @if(isset($storeData['Objective-Revision']) == 1)
                                                        <button class="btn btn-outline-danger my-1 btn-sm fa-eyeehrRej" data-id="{{$user->name}}" style="box-shadow: none;">Revision</button>
                                                    @endif
                                                @endif
                                                @else
                                                <span class="badge badge-dark p-3 cursor-pointer" style="background: #202020; font-size: small; font-weight: 500;">Else</span>                            
                                            @endif                    
                                        </td>
                                        @else
                                        <td style="width: 30px;" class="text-center">
                                            <input type="text" value="{{$user->name}}" id="id" name="id" hidden>
                                                <button style="background: none; border: none;" type="submit">
                                                    @if($user->status == 1)    
                                                        <span class="badge badge-dark p-3 fa-eyee cursor-pointer" id="btn_approved" data-id="{{$user->name}}" style="background: #192636; font-size: small; font-weight: 500;">Approve</span>
                                                    @elseif($user->status == 2)
                                                    -
                                                    @elseif($user->status == 3)
                                                        <span class="badge badge-dark p-3 fa-eyeea cursor-pointer" id="btn_approveda" data-id="{{$user->name}}" style="background: #192636; font-size: small; font-weight: 500;">Update</span>
                                                    @elseif($user->status == 4)
                                                    -
                                                    @else
                                                    -                         
                                                    @endif                    
                                                </button> 
                                        </td>
                                        @endif
                                        <td class="text-center">
                                            @if($user->status == 4)
                                            <div class="radio radio-success form-check-inline">
                                                <input class="RateRadio" data-id="{{$user->id}}" val="{{$user->name}}" type="radio" id="inlineRadio1" value="option1" name="radioInline{{$k++}}" {{ $user->rating == 1 ? "checked" : "" }}>
                                                <label for="inlineRadio1"> Enable </label>
                                            </div>
                                            <div class="radio radio-danger form-check-inline">
                                                <input class="RateRadio" data-id="{{$user->id}}" val="{{$user->name}}" type="radio" id="inlineRadio2" value="option2" name="radioInline{{$j++}}" {{ $user->rating == 2 ? "checked" : "" }}>
                                                <label for="inlineRadio2"> Disable  </label>
                                            </div>
                                            @endif
                                        </td>
                                        <td class="text-center" style="width: 150px;" hidden>
                                        @if($user->rating == 1) 
                                            @if($user->rate == 'Outstanding')                                                                                                                                                                                         
                                            <span class="badge badge-md badge-soft-success p-2 w-75">{{$user->rate}}</span>
                                            @elseif($user->rate == 'Need Improvement')   
                                            <span class="badge badge-md badge-soft-danger p-2 w-75">{{$user->rate}}</span>
                                            @elseif($user->rate == 'Meets Expectation')   
                                            <span class="badge badge-md badge-soft-warning p-2 w-75">{{$user->rate}}</span>
                                            @elseif(!$user->rate)   
                                            <span class="badge badge-md badge-soft-white p-2 w-75 text-white">.</span>
                                            @else
                                            <span class="badge badge-md badge-soft-primary p-2 w-75">{{$user->rate}}</span>
                                            @endif
                                        @endif 
                                        </td>
                                        <td class="text-center">
                                            @if(!$user->score)                                            
                                            @else
                                            @if($user->rate == 'Outstanding')
                                            <div class="avatar-box thumb-sm align-self-center">
                                                <span class="avatar-title bg-soft-success rounded-circle">{{$user->score}}</span>
                                            </div>
                                            @elseif($user->rate == 'Need Improvement')
                                            <div class="avatar-box thumb-sm align-self-center">
                                                <span class="avatar-title bg-soft-danger rounded-circle">{{$user->score}}</span>
                                            </div>
                                            @elseif($user->rate == 'Meets Expectation')
                                            <div class="avatar-box thumb-sm align-self-center">
                                                <span class="avatar-title bg-soft-warning rounded-circle">{{$user->score}}</span>
                                            </div>
                                            @else
                                            <div class="avatar-box thumb-sm align-self-center">
                                                <span class="avatar-title bg-soft-primary rounded-circle">{{$user->score}}</span>
                                            </div>
                                            @endif
                                            @endif
                                        </td>
                                        <div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="background-color: transparent">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Revision Objective?</h5>
                                                    </div>
                                                    <div class="modal-body" id="exampleModalCenter1a">
                                                        <form action="{{url('revision')}}" method="get" enctype="multipart/form-data">
                                                        <div class="form-group row py-0">
                                                            <div class="col-sm-12 mb-1 mb-sm-0">
                                                                <label for=""> <b style="color: #6c757d">Remarks</b> </label>
                                                                <input type="text" id="id" name="id" hidden>
                                                                <input type="text" class="form-control py-2" id="reason" name="reason" placeholder="Remarks">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-sm-4 mb-1 mb-sm-0">
                                                            </div>
                                                            <div class="col-sm-4 mb-1 mb-sm-0">
                                                                <button type="submit" class="btn w-100 py-1 text-white" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); border: none; font-size: 15px;">Submit</button>
                                                            </div>
                                                            <div class="col-sm-4 mb-1 mb-sm-0">
                                                            </div>
                                                        </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer" style="background-color: transparent">
                                                        <button type="button" class="btn btn-dark fa-eyeee" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="background-color: transparent">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Approve Objective</h5>
                                                    </div>
                                                    <div class="modal-body" id="exampleModalCenter1b">
                                                        <form action="{{url('approve')}}" method="get" enctype="multipart/form-data">
                                                        <div class="form-group row py-0">
                                                            <div class="col-sm-12 mb-1 mb-sm-0">
                                                                <label for=""> <b style="color: #6c757d">Remarks</b> </label>
                                                                <input type="text" id="idd" name="idd" hidden>
                                                                <input type="text" class="form-control py-2" id="reason" name="reason" placeholder="Remarks">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-sm-4 mb-1 mb-sm-0">
                                                            </div>
                                                            <div class="col-sm-4 mb-1 mb-sm-0">
                                                                <button type="submit" class="btn w-100 py-1 text-white" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); border: none; font-size: 15px;">Submit</button>
                                                            </div>
                                                            <div class="col-sm-4 mb-1 mb-sm-0">
                                                            </div>
                                                        </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer" style="background-color: transparent">
                                                        <button type="button" class="btn btn-dark fa-eyeee" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>           
                    </div>
                </div>
                <button style="margin-bottom: 10px" class="btn btn-primary delete_all" data-url="{{ url('myproductsDeleteAll') }}">Finalise All Selected</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modelMarginDetail" id="exampleModalCenter" style="margin-top: 5%;" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header py-1" style="padding-left: 40%; background-color: transparent;">
                <h4 class="modal-title mt-4" id="exampleModalLongTitle">Objective Detail</h4>
            </div> 
            <div class="modal-body py-3 px-5" id="modal-body-accept">
            <form action="#">
                <div class="row mt-2">
                    <div class="col-md-6 text-center" style="margin: 0 auto;">
                        <div class="row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <label for=""><b>Member Name:</b></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <input class="form-control" name="name" type="text" id="memberName">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            </div>
            <div class="modal-footer text-center" style="background-color: transparent;">
                <button  style="margin-right: 1%;" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button  style="margin-right: 40%;" type="submit" class="btn btn-secondary" data-dismiss="modal">Update</button>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/sweetalert.min.js"></script>
<script src="assets/js/customjquery.min.js"></script>
{{-- Start MultiSelect --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-confirmation/1.0.5/bootstrap-confirmation.min.js"></script> 
{{-- End MultiSelect --}}
<script>
$(document).ready(function(){ 
	$("#loader1").fadeOut(1200);
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
            showConfirmButton: false,
			timer: 2000
        });
        break;
        case 'yes':
            Swal.fire({
            icon: 'success',
            title: "{{ session('message') }}",
            showConfirmButton: false,
			timer: 2000
        });
        break;
        case 'no':
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
<script>
    var z = 1;
    $(".fa-eyeshow").click(function(){
        var id = $(this).attr("data-id");
        console.log(id);
        $('#pp').html(id);
        $('#exampleModalCenter9').modal('show');
    });
    $(".fa-eyeee").click(function(){
        $('#exampleModalCenter9').modal('hide');
    });
    $(".RateRadio").click(function(){
        console.log("Radio");
        var DataId = $(this).attr("data-id");
        var Id = $(this).attr("id");
        var Val = $(this).attr("val");
        console.log(Val);
        $.ajax({
                type: 'GET',
                url: 'rating/'+Id+'/'+DataId+'/'+Val,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Enabled',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        // location.reload();
                    }
                    else if(data == 2){
                        Swal.fire({
                            icon: 'success',
                            title: 'Disabled',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        // location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something Went Wrong!',
                        });
                    }
                }
            });
    });
</script>
<script>
    $(".fa-eyeea").click(function(){
        var id= $(this).attr("data-id");
        changeStatus11(id);
    });
    function changeStatus11(id){
        $.ajax({
                type: 'GET',
                url: 'changeStatus/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        // $("#btn_approveda").attr("disabled", true);
                        // $("#btn_approveda").html("Approved");
                        // $("#btn_approveda").css("background-color", "green");
                        // $("#btn_approveda").css("border-color", "green");
                        // $("#btn_approveda").css("cursor", "not-allowed");
                        // $("#btn_approveda").addClass("cursor-not-allowed");
                        Swal.fire({
                            icon: 'success',
                            title: 'Status Updated!',
                        });
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!',
                        });
                    }
                }
            });
        }

    $(".fa-eyee").click(function(){
        var id= $(this).attr("data-id");
        changeStatus1(id);
    });
    function changeStatus1(id){
        $.ajax({
                type: 'GET',
                url: 'changeStatus/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        console.log(data);
                        // $("#btn_approved").attr("disabled", true);
                        // $("#btn_approved").html("Approved");
                        // $("#btn_approved").css("background-color", "green");
                        // $("#btn_approved").css("border-color", "green");
                        // $("#btn_approved").css("cursor", "not-allowed");
                        // $("#btn_approved").addClass("cursor-not-allowed");
                        Swal.fire({
                            icon: 'success',
                            title: 'Status Approved!',
                        });
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!',
                        });
                    }
                }
            });
        }
</script>
<script>
    $(".fa-eyee1").click(function(){
        var id= $(this).attr("data-id");
        changeStatus2(id);
    });
    function changeStatus2(id){
        $.ajax({
                type: 'GET',
                url: 'changeStatusHr/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        console.log(data);
                        // $("#btn_approved1").attr("disabled", true);
                        // $("#btn_approved1").html("Finalised");
                        // $("#btn_approved1").css("background-color", "green");
                        // $("#btn_approved1").css("cursor", "not-allowed");
                        // $("#btn_approved1").addClass("cursor-not-allowed");
                        Swal.fire({
                            icon: 'success',
                            title: 'Objective Finalised!',
                        });
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!',
                        });
                    }
                }
            });
        }
</script>
<script>
    $(".fa-eyeehrRejaa").click(function(){
        var id= $(this).attr("data-id");
        changeStatus3(id);
    });
    function changeStatus3(id){
        $.ajax({
                type: 'GET',
                url: 'changeStatusHrRej/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        console.log("Revison");
                        console.log(data);
                        // $("#btn_approved").attr("disabled", true);
                        // $("#btn_approved").html("Revison");
                        // $("#btn_approved").css("background-color", "green");
                        // $("#btn_approved").css("cursor", "not-allowed");
                        // $("#btn_approved").addClass("cursor-not-allowed");
                        Swal.fire({
                            icon: 'success',
                            title: 'Objective Revised!',
                        });
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!',
                        });
                    }
                }
            });
        }
</script>
<script>
    $(".fa-eyeehrRejssxx").click(function(){
        var id= $(this).attr("data-id");
        $.ajax({
            type: 'GET',
            url: 'revision/'+id,
            dataType: "json",
            beforeSend: function(){
                $("#exampleModalCenter1a").hide();
            },
            success: function(data){
                if(data){
                    $('#id').val(data.name);
                }
            },
            complete:function(data){
                $("exampleModalCenter1a").show();
            }
        });
   });
</script>
<script>
    $(".fa-eyeehrRej").click(function(){
        var id = $(this).attr("data-id");
        console.log(id);
        $('#id').val(id);
        $('#exampleModalCenter1').modal('show');
    });
    $(".fa-eyeee").click(function(){
        $('#exampleModalCenter1').modal('hide');
    });
</script>
<script>
    $(".fa-eyeehrRej11").click(function(){
        var id = $(this).attr("data-id");
        console.log(id);
        $('#idd').val(id);
        $('#exampleModalCenter2').modal('show');
    });
    $(".fa-eyeee").click(function(){
        $('#exampleModalCenter2').modal('hide');
    });
</script>
<script>
    $("#del").click(function(){
        var id= $(this).attr("data-id");
        console.log("Del");
        deleteobj(id);
    });
    function deleteobj(id){
        $.ajax({
                type: 'GET',
                url: 'deleteobjuser/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Objective User Delete!',
                        });
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something Went Wrong!',
                        });
                    }
                }
            });
        }
</script>
<script>
    $("#show").click(function(){
        var id= $(this).attr("data-id");
        $.ajax({
            type: 'GET',
            url: 'showobjuser/'+id,
            dataType: "json",
            beforeSend: function(){
                $("#modal-body-accept").hide();
            },
            success: function(data){
                if(data){
                    $('#memberName').val(data.name);
                }
            },
            complete:function(data){
                $("#modal-body-accept").show();
            }
        });
   });
</script>
<script type="text/javascript">
    $(document).ready(function (){
        $('#master').on('click', function(e) {
        if($(this).is(':checked',true)){
            $(".sub_chk").prop('checked', true);  
        } 
        else{  
            $(".sub_chk").prop('checked',false);  
        }  
        });
        $('.delete_all').on('click', function(e){
            var allVals = [];  
            $(".sub_chk:checked").each(function(){  
                allVals.push($(this).attr('data-id'));
            });  

            if(allVals.length <=0){  
                alert("Please select row.");  
            }  
            else{  
                var check = confirm("Are you sure you want to Finalise all row?");  
                if(check == true){  
                    var join_selected_values = allVals.join(","); 

                    $.ajax({
                        url: $(this).data('url'),
                        type: 'GET',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'ids='+join_selected_values,
                        success: function (data){
                            if(data['success']){
                                location.reload();
                                alert(data['success']);
                            } 
                            else if(data['error']){
                                alert(data['error']);
                            } 
                            else{
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });

                    $.each(allVals, function( index, value ) {
                        $('table tr').filter("[data-row-id='" + value + "']").remove();
                    });
                }  
            }  
        });


        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            onConfirm: function (event, element){
                element.trigger('confirm');
            }
        });

        $(document).on('confirm', function (e){
            var ele = e.target;
            e.preventDefault();

            $.ajax({
                url: ele.href,
                type: 'GET',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data){
                    if(data['success']){
                        $("#" + data['tr']).slideUp("slow");
                        alert(data['success']);
                    } 
                    else if(data['error']){
                        alert(data['error']);
                    } 
                    else{
                        alert('Whoops Something went wrong!!');
                    }
                },
                error: function (data) {
                    alert(data.responseText);
                }
            });
            return false;
        });
    });
</script>
<script>
    $('#deppp').on('change', function() {
    document.getElementById("myForm").submit();
});
</script>
@endsection