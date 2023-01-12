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
    #image321:hover{
        transform: scale(1.5);
        transition: transform .5s;
        cursor: pointer;
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
                            <li class="breadcrumb-item active">Manage Job Orders QC</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Manage Job Orders QC</h4>
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
                                        <th>#</th>
                                        <th>Attachment</th>
                                        <!-- <th>Season</th> -->
                                        <th>Sequence</th>
                                        <th>Status</th>
                                        <th>Last No</th>
                                        <th>Color</th>
                                        <th>Article Code</th>
                                        <th>Sample No</th>
                                        <th>Project No</th>
                                        <th>Date & Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $user) 
                                        <tr>
                                            <td>{{$i++}}</td>
                                            @if($user->image == 0)
                                            <td class="text-center" style="width: 10px;"><img id="image321" style="transition: transform .5s;" src="{{asset('img/photos/10.jpg')}}" alt="" height="50" class="d-block mt-1 rounded"></td>
                                            @else
                                            <td class="text-center" style="width: 10px;"><img id="image321" style="transition: transform .5s;" src="{{asset('uploads/appsetting/' . $user->image)}}" alt="" height="50" class="d-block mt-1 rounded"></td>
                                            @endif
                                            <!-- <td>{{$user->season}}</td> -->
                                            <td>{{$user->sequence}}</td>
                                            <td><span class="badge badge-md badge-boxed badge-soft-primary mr-2 p-2 mt-1">New</span></td>
                                            <td>{{$user->last}}</td>
                                            <td>{{$user->color}}</td>
                                            <td>{{$user->article}}</td>
                                            <td>{{$user->sample}}</td>
                                            <td>{{$user->product}}</td>
                                            <td>
                                                <?php $delimiter = ' '; $words = explode($delimiter, $user->created_at); $newDate = date("h:i A", strtotime($words[1]));  ?>
                                                <i class="mdi mdi-calendar-text-outline"></i> {{$words[0]}} <br><i class="mdi mdi-timer"></i> {{$newDate}}
                                            </td>
                                            <td class="text-center">
                                                <form id="myForm">
                                                    <input type="text" value="{{$user->id}}" name="id" hidden> 
                                                    <a href="job-order-edit?id={{$user['id']}}"><button data-id={{$user['id']}} class="btn-sm" style="background: none; border: none; margin-right: -3px;" type="button"><span class="badge btn-sm badge-dark p-0 rounded-circle" type="submit" style="background: #202020;"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="edit"></i></span></button></a>                 
                                                    @if(isset($storeData['Job-Order Delete']) && !empty($storeData['Job-Order Delete'])) 
                                                        @if(isset($storeData['Job-Order Delete']) == 1)
                                                            <span data-id={{$user['id']}} style="cursor: pointer;" class="badge badge-danger p-0 rounded-circle cursor-pointer viewweye mr-1"><i class="align-middle mb-1 mt-1 mx-0 w-50" data-feather="trash"></i></span>
                                                        @endif
                                                    @endif
                                                    <a href="job-order-view?id={{$user['id']}}"><span id="view" data-id={{$user['id']}} style="cursor: pointer; background: #4c82f5; margin-right: 1px;" class="badge badge-info p-0 rounded-circle cursor-pointer viewweye1"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="eye"></i></span></a>
                                                    <a href="job-order-print?id={{$user['id']}}" target="_blank"><button data-id={{$user['id']}} class="btn-sm" style="background: none; border: none; margin-left: -4px;" type="button"><span class="badge btn-sm badge-dark p-0 rounded-circle" style="background: #019faf;"><i class="align-middle mb-1 mt-1 mx-1 w-50 text-white" data-feather="file-text"></i></span></button></a>                                          
                                                </form>
                                            </td>   
                                            <div class="modal fade" id="exampleModalCenter5" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header" style="background: transparent;">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Delete Job Order?</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            Select "Delete" below if you are ready to delete Job Order?
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
    $("#edit").click(function(){
        var id = $(this).attr("data-id");
        $("#myForm").attr("action", "job-order-edit");
        document.getElementById("myForm").submit();
    });
    $("#printFile").click(function(){
        var id = $(this).attr("data-id");
        $("#myForm").attr("action", "job-order-print");
        document.getElementById("myForm").submit();
    });
    $("#view").click(function(){
        var id = $(this).attr("data-id");
        $("#myForm").attr("action", "job-order-view");
        document.getElementById("myForm").submit();
    });
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
                url: 'deletejoborder/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Job Order Delete Successfully!',
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