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
    #loader1 {  
        position: fixed;  
        left: 0px;  
        top: 0px;  
        width: 100%;  
        height: 100%;  
        z-index: 9999;  
        background: url("/img/avatars/3dgifmaker.gif") 50% 50% no-repeat black;  
    }
    .table_row:hover{
        background-color: #f1f5fa;
        cursor: pointer;
    }
    #image321:hover{
        transform: scale(1.5);
        transition: transform .5s;
        cursor: pointer;
    }
</style>
<div id="loader1" class="rotate" width="100" height="100"></div>
<div class="page-content">
    <div class="container-fluid px-4">
        <div class="row px-2">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="float-right">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Manage Users</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Manage Users</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card mb-5">
                    <div class="card-body table-responsive p-5">
                        <div class="">
                            <table id="datatable2" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th class="text-left pl-4"> <span class="pl-5"></span> Name</th>
                                        <th>Code</th>
                                        <th>Username</th>
                                        <th>Designation</th>
                                        <th>Department</th>
                                        <th>Status</th>
                                        <th>User Role</th>
                                        <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $user) 
                                        <tr class="table_row">
                                            <td>{{$i++}}</td>
                                            <td class="text-left" style="width: 20%;">
                                            @if(isset($user->image) && !empty($user->image)) 
                                            <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                                <img id="image321" style="transition: transform .5s;" src="{{ asset('uploads/appsetting/' . $user->image) }}" alt="profile-user" class="rounded-circle mr-2" /> 
                                                {{$user->firstname}} {{$user->lastname}}</td>
                                            </a>
                                            @else
                                            <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                                <img id="image321" style="transition: transform .5s;" src="img/avatars/avatar-2.jpg" alt="profile-user" class="rounded-circle mr-2" /> 
                                                {{$user->emp_name}}
                                            </a>
                                            @endif    
                                            </td>
                                            <td>{{$user->emp_code}}</td>
                                            <td>{{$user->name}}</td>
                                            <td>
                                            <?php
                                                $pieces = explode(" ", $user->designation);
                                                if(count($pieces) == 1){
                                                    echo $pieces[0];
                                                    echo '<br>';
                                                }
                                                if(count($pieces) == 2){
                                                    echo $pieces[0]." ".$pieces[1];
                                                }
                                                if(count($pieces) == 3){
                                                    echo $pieces[0]." ".$pieces[1];
                                                    echo '<br>';
                                                    echo $pieces[2];
                                                }
                                                if(count($pieces) == 4){
                                                    echo $pieces[0]." ".$pieces[1];
                                                    echo '<br>';
                                                    echo $pieces[2]." ".$pieces[3];
                                                }
                                                if(count($pieces) == 5){
                                                    echo $pieces[0]." ".$pieces[1];
                                                    echo '<br>';
                                                    echo $pieces[2]." ".$pieces[3];
                                                    echo '<br>';
                                                    echo $pieces[4];
                                                }
                                                if(count($pieces) == 6){
                                                    echo $pieces[0]." ".$pieces[1];
                                                    echo '<br>';
                                                    echo $pieces[2]." ".$pieces[3];
                                                    echo '<br>';
                                                    echo $pieces[4]." ".$pieces[5];
                                                }
                                                ?>
                                            </td>
                                            <td>
                                            <?php
                                                $pieces1 = explode(" ", $user->department);
                                                if(count($pieces1) == 1){
                                                    echo $pieces1[0];
                                                    echo '<br>';
                                                }
                                                if(count($pieces1) == 2){
                                                    echo $pieces1[0]." ".$pieces1[1];
                                                }
                                                if(count($pieces1) == 3){
                                                    echo $pieces1[0]." ".$pieces1[1];
                                                    echo '<br>';
                                                    echo $pieces1[2];
                                                }
                                                ?>
                                            </td>
                                            <td>
                                            @if($user->status == 1)    
                                                <span class="badge badge-md badge-boxed badge-success mr-2 p-2 mt-1">Active</span>
                                            @elseif($user->status == 2)
                                                <span class="badge badge-md badge-boxed badge-danger mr-2 p-2 mt-1">Deactive</span>
                                            @elseif($user->status == 3)
                                                <span class="badge badge-md badge-boxed badge-danger mr-2 p-2 mt-1">Terminated</span>
                                            @elseif($user->status == 4)
                                                <span class="badge badge-md badge-boxed badge-danger mr-2 p-2 mt-1">Deleted</span>
                                            @endif
                                            </td>
                                            <td>{{$user->userrole}}</td>
                                            <td class="text-center">
                                                <form action="user-edit">
                                                    <input type="text" value="{{$user->id}}" name="id" hidden> 
                                                    <button class="btn-sm" style="background: none; border: none;" type="submit"><span class="badge btn-sm badge-dark p-0 rounded-circle" type="submit" style="background: #202020;"> <i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="edit"></i></span></button>                 
                                                    @if(isset($storeData['User-Delete']) && !empty($storeData['User-Delete'])) 
                                                        @if($storeData['User-Delete'] == 1)                                                         
                                                        <span data-id={{$user['id']}} style="cursor: pointer;" class="badge badge-danger p-0 rounded-circle cursor-pointer viewweye"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="trash"></i></span>                                                        
                                                        @endif
                                                    @endif
                                                </form>
                                            </td>
                                            <div class="modal fade" id="exampleModalCenter5" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header" style="background: transparent;">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Delete User?</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            Select "Delete" below if you are ready to delete User?
                                                        </div>
                                                        <div class="modal-footer" style="background: transparent;">
                                                            <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                                            <button id="delete-user" type="button" class="btn btn-danger">Delete</button>
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
    }
  @endif
</script>
<script>
    $(".viewweye").click(function(){
        var id = $(this).attr("data-id");
        $("#delete-user").attr("data-id", id);
        $('#exampleModalCenter5').modal('show');
    });
    $("#delete-user").click(function(){
        var id = $(this).attr("data-id");
        deleteuser(id);
    });
    function deleteuser(id){
        $.ajax({
                type: 'GET',
                url: 'delete/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'User Delete Successfully!',
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
@endsection