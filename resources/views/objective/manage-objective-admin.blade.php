@extends( (Auth::user()->id == "2") ? 'layouts.admin-layout' : 'layouts.user-layout')

@section('content')
<?php
	$id = Auth::user()->id;
	$authName = Auth::user()->name;
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
    <div class="container-fluid">
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
                                        <th>Member Name</th>
                                        <th>Lead Name</th>
                                        <th>Department</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        <th>Rate</th>
                                        <th>Score</th>
                                        <th class="text-center">Objectives</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $user)
                                    <tr>
                                        <td>{{$i++}}
                                            <input type="text" value="{{$authName}}" hidden class="Authname">
                                        </td>  
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->lead_name}}</td>
                                        <td>
                                            <?php
                                                $pieces = explode(" ", $user->department);
                                                echo $pieces[0];
                                                echo '<br>';
                                                if(count($pieces) == 2){
                                                    echo $pieces[1];
                                                    echo '<br>';
                                                }
                                                if(count($pieces) == 3){
                                                    echo $pieces[2];
                                                    echo '<br>';
                                                }
                                            ?> 
                                        </td>
                                        <td>
                                            @if($user->status == 1)    
                                                <span class="badge badge-md badge-boxed badge-soft-warning p-2 w-75">Pending</span>
                                            @elseif($user->status == 2)
                                                <span class="badge badge-md badge-boxed badge-soft-success p-2 w-75">In-Review HR</span>
                                            @elseif($user->status == 3)
                                                <span class="badge badge-md badge-boxed badge-soft-danger p-2 w-75">Revision</span>
                                                <span id="btnapp" data-id="{{$user->reason}}" class="badge cursor-pointer fa-eyeshow" style="font-size: small; font-weight: 500;">
                                                    <i class="align-middle mb-1 mt-1 mx-1 cursor-pointer text-dark" data-feather="eye"></i>
                                                </span>                                                      
                                            @elseif($user->status == 4)
                                                <span class="badge badge-md badge-boxed badge-soft-secondary p-2 w-75">Finalised</span>
                                                <span id="btnapp" data-id="{{$user->reason}}" class="badge cursor-pointer fa-eyeshow" style="font-size: small; font-weight: 500;">
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
                                                        <div class="modal-footer" style="background-color: transparent;">
                                                            <button type="button" class="btn btn-dark fa-eyeee" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade hide-modal" id="exampleModalCenter51" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"  aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title mt-0" id="exampleModalLabel">Enter Password</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="p-3">
                                                                <form class="form-horizontal" action="index.html">
                                        
                                                                    <div class="text-center mb-4">
                                                                        <div class="avatar-box thumb-xl align-self-center mr-2">
                                                                            <span class="avatar-title bg-light rounded-circle text-danger"><i class="fas fa-lock"></i></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="input-group">
                                                                        <input type="password" class="form-control yourclass lock" placeholder="Password" aria-label="Password" aria-describedby="HideCard" name="lock">
                                                                        <div class="input-group-append">
                                                                            <button class="btn btn-gradient-primary HideCard" type="button"><i class="mdi mdi-key"></i></button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-outline-warning my-1 btn-sm ChangeStatus" id="1" data-id="{{$user->id}}" name="{{$user->name}}" style="box-shadow: none;">Pending</button>
                                            <button class="btn btn-outline-success my-1 btn-sm ChangeStatus" id="2" data-id="{{$user->id}}" name="{{$user->name}}" style="box-shadow: none;">Approve</button>
                                            <br>
                                            <button class="btn btn-outline-secondary my-1 btn-sm ChangeStatus" id="4" data-id="{{$user->id}}" name="{{$user->name}}" style="box-shadow: none;">Finalise&nbsp;</button>
                                            <button class="btn btn-outline-danger my-1 btn-sm ChangeStatus" id="3" data-id="{{$user->id}}" name="{{$user->name}}" style="box-shadow: none;">Revision</button>
                                        </td>
                                        <td class="text-center">
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
                                        <td class="text-center">
                                            <form action="show-obj">
                                                <input type="text" value="{{$user->emp_code}}" id="id" name="id" hidden>
                                                    <button type="submit" class="btn btn-outline btn-sm" style="border: 1px solid #192636;">View</button>
                                                    <button hidden style="background: none; border: none;" type="submit">
                                                        <span class="badge badge-dark p-3" style="background: #192636; font-size: small; font-weight: 500;">Show Objectives</span>
                                                    </button> 
                                            </form>
                                        </td>
                                        @if($id == 95)
                                        @else
                                        @endif
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
<script src="assets/js/customjquery.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
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
    $(".fa-eyeshow").click(function(){
        console.log("CLICK");
        var id = $(this).attr("data-id");
        $('#pp').html(id);
        $('#exampleModalCenter9').modal('show');
    });
    $(".fa-eyeee").click(function(){
        $('#exampleModalCenter9').modal('hide');
    });
</script>
<script src="assets/js/customjquery.min.js"></script>
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
                        $("#btn_approveda").attr("disabled", true);
                        $("#btn_approveda").html("Approved");
                        $("#btn_approveda").css("background-color", "green");
                        $("#btn_approveda").css("border-color", "green");
                        $("#btn_approveda").css("cursor", "not-allowed");
                        $("#btn_approveda").addClass("cursor-not-allowed");
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
                        $("#btn_approved").attr("disabled", true);
                        $("#btn_approved").html("Approved");
                        $("#btn_approved").css("background-color", "green");
                        $("#btn_approved").css("border-color", "green");
                        $("#btn_approved").css("cursor", "not-allowed");
                        $("#btn_approved").addClass("cursor-not-allowed");
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

    $(".ChangeStatus").click(function(){
        var id = $(this).attr("data-id");
        var status = $(this).attr("id");
        var name = $(this).attr("name");
        sessionStorage.setItem("id_store", id);
        sessionStorage.setItem("id_status", status);
        sessionStorage.setItem("id_name", name);
        $('#exampleModalCenter51').modal('show');
    });
    $(".HideCard").click(function(){
        var value = $(".lock").val();
        var Authname = $(".Authname").val();
        $('#exampleModalCenter51').modal('hide');
        $('.lock').val('');
        if(value != Authname){
            Swal.fire({
                icon: 'error',
                title: 'Wrong Password!',
            });
        }
        else{
            var id = sessionStorage.getItem("id_store");
            var status = sessionStorage.getItem("id_status");
            var name = sessionStorage.getItem("id_name");
            ChangeStatus21(id,status,name);
        }
    });
    function ChangeStatus21(id,status,name){
        $.ajax({
                type: 'GET',
                url: 'changeStatus21/'+id+'/'+status+'/'+name,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Status Changed',
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
                        $("#btn_approved1").attr("disabled", true);
                        $("#btn_approved1").html("Finalised");
                        $("#btn_approved1").css("background-color", "green");
                        $("#btn_approved1").css("cursor", "not-allowed");
                        $("#btn_approved1").addClass("cursor-not-allowed");
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
                        $("#btn_approved").attr("disabled", true);
                        $("#btn_approved").html("Revison");
                        $("#btn_approved").css("background-color", "green");
                        $("#btn_approved").css("cursor", "not-allowed");
                        $("#btn_approved").addClass("cursor-not-allowed");
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
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
@endsection
