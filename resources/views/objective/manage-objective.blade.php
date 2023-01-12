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
    .br-theme-bars-movie .br-widget a.br-selected {
        background-color: #1761fd;
    }
    .br-theme-bars-movie .br-widget a.br-active {
        background-color: #1761fd;
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
                    <h4 class="page-title">Manage Users<a href="{{url('all-objective')}}"> <button type="button" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-3 py-1 text-white mx-3">View All Objectives</button></a></h4>                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body table-responsive p-5">
                        <div class="">
                            <table id="datatable2" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Member</th>
                                        <th>Lead</th>
                                        <th>Department</th>
                                        <th>Status</th>
                                        @if($id != 95)
                                            <th class="text-center">Create Objective</th>
                                        @endif
                                        <th class="text-center">Objectives</th>
                                        <th class="text-center">Action</th>
                                        <th class="text-center">Operations</th>
                                        <th class="text-center">Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $user)
                                    <tr>
                                        <td>{{$i++}}</td>  
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->lead_name}}</td>
                                        <td>
                                            <?php $explode = explode(" ",$user->department); ?>
                                            @foreach($explode as $data1)
                                                {{$data1}}<br>
                                            @endforeach
                                        </td>
                                        <td>
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
                                                <span id="btnapp" data-id="{{$user->reason}}" class="badge cursor-pointer fa-eyeshow" style="cursor: pointer; font-size: small; font-weight: 500;">
                                                    <i class="align-middle mb-1 mt-1 mx-1 cursor-pointer text-dark" data-feather="eye"></i>
                                                </span>
                                            @elseif($user->status == 4)
                                                <span class="badge badge-md badge-boxed badge-soft-secondary p-2 w-50">Finalised</span>
                                                <span id="btnapp" data-id="{{$user->reason}}" class="badge cursor-pointer fa-eyeshow" style="cursor: pointer; font-size: small; font-weight: 500;">
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
                                                        <div class="modal-footer text-center" style="background-color: transparent">
                                                            <button type="button" class="btn btn-secondary fa-eyeee" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        @if($id != 95)
                                            @if($user->status == 2)
                                                <td class="text-center"></td>
                                            @elseif($user->status == 3)
                                                <td class="text-center">
                                                    <form action="objective-create">
                                                        <input type="text" value="{{$user->emp_code}}" id="id" name="id" hidden>
                                                        <input type="text" value="{{$user->name}}" id="name" name="name" hidden>
                                                        <button type="submit" class="btn btn-sm btn-outline-dark" style="border: 1px solid #192636;">Create</button> 
                                                    </form>
                                                </td>                           
                                            @else
                                            @if($user->status == 4)
                                                <td></td>
                                            @else
                                                <td class="text-center">
                                                    <form action="objective-create">
                                                        <input type="text" value="{{$user->emp_code}}" id="id" name="id" hidden>
                                                        <input type="text" value="{{$user->name}}" id="name" name="name" hidden>
                                                        <button type="submit" class="btn btn-sm btn-outline-dark" style="border: 1px solid #192636;">Create</button>
                                                    </form>
                                                </td>
                                            @endif
                                            @endif
                                        @endif
                                        <td class="text-center" hidden>
                                            <form action="show-objChange">
                                                <input type="text" value="{{$user->emp_code}}" id="id" name="id" hidden>
                                                    <button type="submit" class="btn btn-outline-dark" style="border: 1px solid #192636;">View</button>
                                                    <button hidden style="background: none; border: none;" type="submit">
                                                        <span class="badge badge-dark p-3" style="background: #192636; font-size: small; font-weight: 500;">Show Objectives</span>
                                                    </button> 
                                            </form>
                                        </td>
                                        <td class="text-center">
                                            <!-- <form id="myForm"> -->
                                                <!-- <input type="text" value="{{$user->emp_code}}" id="id" name="id" hidden> -->
                                                <a href="show-obj?id={{$user->emp_code}}"><button type="submit" id="view" class="btn btn-outline-dark btn-sm" style="border: 1px solid #192636;">View</button></a>
                                            <!-- </form> -->
                                        </td> 
                                        @if($id == 95)
                                            <td style="width: 17%;" class="text-center">
                                        @if($user->status == 1)    
                                        <td class="text-center"></td>
                                            @elseif($user->status == 2)
                                                <button class="btn btn-sm btn-outline-success fa-eyee1" id="btn_approved1" data-id="{{$user->name}}">Approve</button>
                                                <span hidden class="badge badge-dark p-3 fa-eyee1 cursor-pointer" id="btn_approved1" data-id="{{$user->name}}" style="background: #202020; font-size: small; font-weight: 500;">Approve</span>
                                                <button class="btn btn-sm btn-outline fa-eyeehrRej" id="btn_rejected" data-id="{{$user->name}}" style="border: 1px solid #192636;">Revision</button>
                                                <span hidden class="badge badge-dark p-3 fa-eyeehrRej cursor-pointer" id="btn_rejected" data-id="{{$user->name}}" style="background: #202020; font-size: small; font-weight: 500;">Revision</span>                                
                                            @elseif($user->status == 3)
                                                <span class="badge badge-dark p-3 cursor-pointer" style="background: #202020; font-size: small; font-weight: 500;">Approve</span>
                                            @elseif($user->status == 4)
                                                <td class="text-center"></td>
                                            @else
                                                <span class="badge badge-dark p-3 cursor-pointer" style="background: #202020; font-size: small; font-weight: 500;">Else</span>                            
                                            @endif                    
                                        </td>
                                        @else
                                        <td style="width: 30px;" class="text-center">
                                            <input type="text" value="{{$user->name}}" id="id" name="id" hidden>
                                            @if($user->status == 1)   
                                                <?php $data = DB::table('objectives')->where('emp_code', $user->emp_code)->get(); $count = count($data)?>    
                                                @if($count > 0)
                                                <button type="submit" class="btn btn-sm btn-outline-success fa-eyee" id="btn_approved" data-id="{{$user->name}}">Approve</button>
                                                @endif
                                                <span hidden class="badge badge-dark p-3 fa-eyee cursor-pointer" id="btn_approved" data-id="{{$user->name}}" style="background: #192636; font-size: small; font-weight: 500;">Approve</span>
                                            @elseif($user->status == 2)    
                                            @elseif($user->status == 3)
                                                <button type="submit" class="btn btn-sm btn-outline-success fa-eyeea cursor-pointer" id="btn_approveda" data-id="{{$user->name}}">Approve</button>
                                                <span hidden class="badge badge-dark p-3 fa-eyeea cursor-pointer" id="btn_approveda" data-id="{{$user->name}}" style="background: #192636; font-size: small; font-weight: 500;">Approve</span>
                                            @elseif($user->status == 4)
                                            @else                                                                            
                                            @endif                    
                                        </td>
                                        @endif
                                        <td class="text-center">
                                        @if($user->status == 4 || $user->status == 2)
                                        @else
                                            @if(isset($storeData['Objective-Delete']) && !empty($storeData['Objective-Delete'])) 
                                                @if($storeData['Objective-Delete'] == 1)    
                                                    <span data-id={{$user['id']}} style="cursor: pointer" class="badge badge-danger p-0 rounded-circle DelUser"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="trash"></i></span>                        
                                                @endif
                                            @endif
                                        @endif    
                                        <span hidden id="show" data-id={{$user['id']}} data-toggle="modal" style="cursor: pointer" class="badge badge-info p-0 rounded-circle mx-1" style="background: #202020;" data-target="#exampleModalCenter" class="badge badge-info p-0 rounded-circle"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="edit"></i></span>                        
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
                                        <div class="modal fade" id="exampleModalCenter5" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="background-color: transparent">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Delete Objective User?</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        Select "Delete" below if you are ready to delete Objective User?
                                                    </div>
                                                    <div class="modal-footer" style="background-color: transparent">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button id="del" type="button" class="btn btn-danger DelId" data-dismiss="modal">Delete</button>
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
            </div>
        </div>
    </div>
</div>
<div class="modal fade modelMarginDetail" id="exampleModalCenter" style="margin-top: 5%;" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header py-1" style="padding-left: 40%;">
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
            <div class="modal-footer text-center">
                <button  style="margin-right: 1%;" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button  style="margin-right: 40%;" type="submit" class="btn btn-secondary" data-dismiss="modal">Update</button>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/sweetalert.min.js"></script>
<script src="assets/js/customjquery.min.js"></script>
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
    }
@endif
</script>
<script>
    $("#view").click(function(){
        var id = $(this).attr("data-id");
        $("#myForm").attr("action", "show-obj");
        document.getElementById("myForm").submit();
    });
</script>
<script>
    $(".fa-eyeshow").click(function(){
        console.log("CLICK");
        var id = $(this).attr("data-id");
        $('#pp').html(id);
        $('#exampleModalCenter9').modal('show');
    });
    $(".DelUser").click(function(){
        var id = $(this).attr("data-id");
        $('.DelId').attr("data-id",id);
        $('#exampleModalCenter5').modal('show');
    });
    $(".fa-eyeee").click(function(){
        $('#exampleModalCenter9').modal('hide');
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
                            title: 'Objective Approved!',
                            timer: 2500
                        });
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!',
                            timer: 2500
                        });
                    }
                    else if(data == 2){
                        Swal.fire({
                            icon: 'info',
                            title: 'Weightage Should be equal to 100%',
                            timer: 3000
                        });
                    }
                    else if(data == 3){
                        Swal.fire({
                            icon: 'warning',
                            title: 'Objectives Not Found!',
                            timer: 3000
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
                        // $("#btn_approved").attr("disabled", true);
                        // $("#btn_approved").html("Approved");
                        // $("#btn_approved").css("background-color", "green");
                        // $("#btn_approved").css("border-color", "green");
                        // $("#btn_approved").css("cursor", "not-allowed");
                        // $("#btn_approved").addClass("cursor-not-allowed");
                        Swal.fire({
                            icon: 'success',
                            title: 'Objective Approved!',
                            timer: 2500
                        });
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!',
                            timer: 2500
                        });
                    }
                    else if(data == 2){
                        Swal.fire({
                            icon: 'info',
                            title: 'Weightage Should be equal to 100%',
                            timer: 3000
                        });
                    }
                    else if(data == 3){
                        Swal.fire({
                            icon: 'warning',
                            title: 'Objectives Not Found!',
                            timer: 3000
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
                        // $("#btn_approved1").attr("disabled", true);
                        // $("#btn_approved1").html("Finalised");
                        // $("#btn_approved1").css("background-color", "green");
                        // $("#btn_approved1").css("cursor", "not-allowed");
                        // $("#btn_approved1").addClass("cursor-not-allowed");
                        Swal.fire({
                            icon: 'success',
                            title: 'Objective Finalised!',
                            timer: 2500
                        });
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!',
                            timer: 2500
                        });
                    }
                }
            });
        }
</script>
<script>
    $(".fa-eyeehrRej").click(function(){
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
                    //     $("#btn_approved").attr("disabled", true);
                    //     $("#btn_approved").html("Revison");
                    //     $("#btn_approved").css("background-color", "green");
                    //     $("#btn_approved").css("cursor", "not-allowed");
                    //     $("#btn_approved").addClass("cursor-not-allowed");
                        Swal.fire({
                            icon: 'success',
                            title: 'Objective Revised!',
                            timer: 2500
                        });
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!',
                            timer: 2500
                        });
                    }
                }
            });
        }
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
                            timer: 2500
                        });
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something Went Wrong!',
                            timer: 2500
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
@endsection
