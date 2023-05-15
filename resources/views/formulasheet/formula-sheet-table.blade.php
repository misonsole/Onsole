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
    .table_row:hover{
        background-color: #f1f5fa;
        cursor: pointer;
    }
    .yourclass::-webkit-input-placeholder{
        color: #6c757d;
    }
</style>
<div id="loader1" class="rotate" width="100" height="100"></div>
<div class="page-content">
    <div class="container-fluid px-5">
        <div class="row px-1">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="float-right">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active" style="font-family: 'Poppins', sans-serif;">Manage Formula Sheet</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Manage Formula Sheet</h4>
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
                                        <th>Sr No.</th>            
                                        <th>Sequence</th>
                                        <th>Created By</th>                               
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $user) 
                                        <tr class="table_row">
                                            <td>{{$i++}}</td>                    
                                            <td>{{$user->sequence}}</td>
                                            <td>{{$user->owner}}</td>
                                            <td>
                                                <?php $delimiter = ' '; $words = explode($delimiter, $user->created_at); $newDate = date("d-F-Y", strtotime($words[0])); ?>
                                                <i class="mdi mdi-calendar-text-outline text-dark"></i> {{$newDate}} 
                                            </td>
                                            <td>
                                                <?php $delimiter = ' '; $words = explode($delimiter, $user->created_at); $newDate = date("h:i A", strtotime($words[1])); ?>
                                                <i class="mdi mdi-timer text-dark"></i> {{$newDate}}
                                            </td>
                                            <td>
                                            @if($user->status == 'Active')    
                                                <span data-id="{{$user->id}}" class="badge badge-md badge-boxed badge-success py-2 px-3 ChangeStatus" name="Deactive">Active</span>
                                            @elseif($user->status == 'Deactive')
                                                <span data-id="{{$user->id}}" class="badge badge-md badge-boxed badge-danger py-2 px-2 ChangeStatus" name="Active">Deactive</span>
                                            @endif
                                            </td>
                                            <td class="text-center">
                                                <form>
                                                    <input type="text" value="{{$user->id}}" name="id" hidden> 
                                                    @if(isset($storeData['Formula-Sheet Delete']) && !empty($storeData['Formula-Sheet Delete'])) 
                                                        @if(isset($storeData['Formula-Sheet Delete']) == 1)
                                                            <span data-id={{$user['id']}} style="cursor: pointer;" class="badge badge-danger p-0 rounded-circle cursor-pointer viewweye mr-1"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="trash"></i></span>
                                                        @endif
                                                    @endif
                                                    @if(isset($storeData['Formula-Sheet Edit']) && !empty($storeData['Formula-Sheet Edit'])) 
                                                        @if(isset($storeData['Formula-Sheet Edit']) == 1)
                                                            <a href="formula-sheet-edit?id={{$user['id']}}" target="_blank"><button data-id={{$user['id']}} class="btn-sm px-0" style="background: none; border: none;" type="button"><span class="badge btn-sm badge-dark p-0 rounded-circle" type="submit" style="background: #202020;"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="edit"></i></span></button></a>                 
                                                        @endif
                                                    @endif
                                                    <a href="formula-sheet-view?id={{$user['id']}}" target="_blank"><span id="view" data-id={{$user['id']}} style="cursor: pointer; background: #4c82f5;" class="badge badge-info p-0 rounded-circle cursor-pointer viewweye1 ml-1"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="eye"></i></span></a>
                                                </form>
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
<div class="modal fade" id="exampleModalCenter5" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: transparent;">
                <h5 class="modal-title" id="exampleModalLongTitle">Delete Formula Sheet</h5>
            </div>
            <div class="modal-body">
                Select "Delete" below if you are ready to Delete Formula Sheet?
            </div>
            <div class="modal-footer" style="background: transparent;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                <button id="delete-user" type="button" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalCenter9" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: transparent">
                <h5>Change Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row mb-0 text-center">
                    <div class="col-sm-12 mb-1 mb-sm-0">
                        <label class="mb-0" for=""><h3 style="color: #6c757d">Overhead No</h3></label>
                        <br>
                        <label for=""><h4 id="modelline" style="color: #6c757d"></h4></label>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center" style="background-color: transparent">
                <button type="button" style="box-shadow: none;" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" style="box-shadow: none; border: none;" class="btn btn-success mx-1 py-2 px-3 joborderstatus">Active <i class="fas fa-sign-out-alt"></i> </button>
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
        $('#exampleModalCenter5').modal('hide');
        deleteuser(id);
    });
    function deleteuser(id){
        $.ajax({
            type: 'GET',
            url: 'deleteformula/'+id,
            dataType: "json",
            success: function(data){
                if(data == 6){
                    Swal.fire({
                        icon: 'success',
                        title: 'Formula Sheet Deleted',
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
    $('.ChangeStatus').click(function(){
        var status = $(this).attr("name");
        var id = $(this).attr("data-id");
        console.log("status id");
        console.log(status,id);
        $('#modelline').html("OH-"+id);
        $(".joborderstatus").html(status);
        $(".joborderstatus").attr("id", id);
        $(".joborderstatus").attr("data-id", status);
        $('#exampleModalCenter9').modal('show');
    }); 
</script>
<script>
    $(".joborderstatus").click(function(){
        var status = $(this).attr("data-id");
        var id = $(this).attr("id");
        formulestatus(id,status);
        $('#exampleModalCenter9').modal('hide');
    });
    function formulestatus(id,status){
        $.ajax({
                type: 'GET',
                url: 'formulasheetstatus/'+id+'/'+status,
                dataType: "json",
                success: function(data){
                    if(data.value == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Status Updated',
                            showConfirmButton: false,
                            timer: 4000
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