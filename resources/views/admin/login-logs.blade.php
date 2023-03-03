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
    <div class="container-fluid px-5">
        <div class="row px-2">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="float-right">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Login Logs</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Login Logs</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card mb-5">
                    <div class="card-body table-responsive p-5">
                        <div class="">
                            <table id="datatable2" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="bg-dark">
                                    <tr>
                                        <th hidden>No</th>
                                        <th class="text-white">No</th>
                                        <th class="text-white">Name</th>
                                        <th class="text-white">IP Address</th>
                                        <th class="text-white">Date & Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $user) 
                                    <tr class="table_row">
                                        <td hidden>1</td>
                                        <td>{{$i++}}</td>
                                        <td class="text-left" style="width: 20%;">
                                        <?php $userdata = DB::table("users")->where("id", $user->user_id)->get(); ?>
                                        @if(isset($userdata[0]->image) && !empty($userdata[0]->image)) 
                                        <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                            <img id="image321" style="transition: transform .5s;" src="{{ asset('uploads/appsetting/' . $userdata[0]->image) }}" alt="profile-user" class="rounded-circle mr-2" /> 
                                            {{$userdata[0]->emp_name}}</td>
                                        </a>
                                        @else
                                        <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                            <img id="image321" style="transition: transform .5s;" src="img/avatars/avatar-2.jpg" alt="profile-user" class="rounded-circle mr-2" /> 
                                            {{$userdata[0]->emp_name}}
                                        </a>
                                        @endif    
                                        </td>         
                                        <td>{{$user->address}}</td>
                                        <td>
                                            <?php $delimiter = ' '; $words = explode($delimiter, $user->created_at); $newDate = date("h:i A", strtotime($words[1]));  $newDate1 = date("d-M-Y", strtotime($words[0])); ?>
                                            <i class="mdi mdi-calendar-text-outline"></i> {{$newDate1}} <br><i class="mdi mdi-timer"></i> {{$newDate}}
                                        </td>                                      
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
<script src="assets/js/customjquery.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script>
$(document).ready(function(){ 
	$("#loader1").fadeOut(1200);
});
$(document).ready(function(){
    var table = $('#datatable2').DataTable({
        pageLength : 25,
    })
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