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
                            <li class="breadcrumb-item active" style="font-family: 'Poppins', sans-serif;">Manage Specification Sheet</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Manage Specification Sheet</h4>
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
                                        <th class="text-white">Sr. No</th>
                                        <th class="text-white" data-orderable="false">Design No.</th>
                                        <th class="text-white" data-orderable="false">Status</th>
                                        <th class="text-white" data-orderable="false">Remarks</th>
                                        <th class="text-white" data-orderable="false">Date & Time</th>
                                        <th class="text-white" data-orderable="false">Action</th>
                                        <th class="text-white" data-orderable="false">Colors</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $user) 
                                        <tr class="table_row">
                                            <td>{{$i++}}</td>
                                            <td>{{$user['data']->design_no}}</td>
                                            <td class="text-center" style="width: 10%;">
                                                @if($user['data']->status == "Costing")
                                                <span class="badge badge-md badge-boxed badge-soft-secondary p-2 w-100">Costing</span>
                                                @elseif($user['data']->status == "Update")
                                                <span class="badge badge-md badge-boxed badge-soft-danger p-2 w-100">Update</span>
                                                @elseif($user['data']->status == "PD")
                                                <span class="badge badge-md badge-boxed badge-soft-dark p-2 w-100">PD</span>
                                                @elseif($user['data']->status == "Production")
                                                <span class="badge badge-md badge-boxed badge-soft-warning py-2 px-3 w-100">Production</span>
                                                @elseif($user['data']->status == "Reject")
                                                <span class="badge badge-md badge-boxed badge-soft-danger p-2 w-100">Rejected</span>
                                                @elseif($user['data']->status == "QC")
                                                <span class="badge badge-md badge-boxed badge-soft-dark p-2 w-100">Quality Control</span>
                                                @elseif($user['data']->status == "Sales")
                                                <span class="badge badge-md badge-boxed badge-soft-success p-2 w-100">Approved</span>
                                                @elseif($user['data']->status == "PPC")
                                                <span class="badge badge-md badge-boxed badge-soft-dark p-2 w-100">PPC</span>
                                                @else
                                                <span class="badge badge-md badge-boxed badge-soft-dark p-2 w-100">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($user['data']->remarks === NULL) 
                                                    &nbsp;
                                                @else
                                                    <span data-id={{$user['data']['remarks']}} style="cursor: pointer;" class="p-0 cursor-pointer viewweye11 ml-1"><i class="align-middle mb-1 mt-1 mx-1 w-50" style="font-size: small;" data-feather="eye"></i></span>
                                                @endif
                                            </td>
                                            <div class="modal fade" id="exampleModalCenter9" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header" style="background: transparent;">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Create Job Order</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group row py-2 text-center">
                                                                <div class="col-sm-12 mb-1 mb-sm-0">
                                                                    <label for=""><h4 id="design_no" style="color: #6c757d"></h4></label>
                                                                    <input hidden type="text" class="form-control py-2 yourclass " style="border: 1px solid #bfbfbf; text-transform: capitalize" id="id_no" name="id_no">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer text-center" style="background-color: transparent">
                                                            <button type="button" style="box-shadow: none;" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                            <button type="submit" style="box-shadow: none; border: none;" class="btn btn-success mx-1 py-2 px-3 allowduplicate">Allow <i class="fas fa-sign-out-alt"></i> </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="exampleModalCenter91" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="form-group row py-2 text-center">
                                                                <div class="col-sm-12 mb-1 mb-sm-0">
                                                                    <label for=""><h4 id="modelline1" style="color: #6c757d"></h4></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer text-center" style="background-color: transparent">
                                                            <button type="button" style="box-shadow: none;" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <td>
                                                <?php $delimiter = ' '; $words = explode($delimiter, $user['data']->created_at); $newDate = date("h:i A", strtotime($words[1]));  ?>
                                                <i class="mdi mdi-calendar-text-outline text-dark"></i> {{$words[0]}} <br><i class="mdi mdi-timer text-dark"></i> {{$newDate}}
                                            </td>
                                            <td class="text-center">
                                                <form id="myForm">
                                                    <input type="text" value="{{$user['data']->id}}" name="id" hidden> 
                                                    @if(isset($storeData['Job-Order Create']) && !empty($storeData['Job-Order Create'])) 
                                                        @if(isset($storeData['Job-Order Create']) == 1)
                                                            @if($user['data']->status === 'PPC')
                                                                <a hidden data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Create Job Order&nbsp;&nbsp;" class="CreateJobOrder" id="{{$user['data']['id']}}" data-id="{{$user['data']['design_no']}}"><span style="cursor: pointer; background: #07439d;" class="badge badge-info p-0 rounded-circle cursor-pointer viewweye1 ml-1"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="edit"></i></span></a>
                                                                <a data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Create Job Order&nbsp;&nbsp;" href="create-job-order?id={{$user['data']['id']}}" target="_blank"><span style="cursor: pointer; background: #07439d;" class="badge badge-info p-0 rounded-circle cursor-pointer viewweye1 ml-1"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="edit"></i></span></a>
                                                            @endif
                                                        @endif
                                                    @endif
                                                    <a data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;View&nbsp;&nbsp;" href="specification-sheet-view?id={{$user['data']['id']}}" target="_blank"><span id="view" data-id={{$user['data']['id']}} style="cursor: pointer; background: #4c82f5;" class="badge badge-info p-0 rounded-circle cursor-pointer viewweye1 ml-1"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="eye"></i></span></a>
                                                    <a data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Print&nbsp;&nbsp;" href="specification-sheet-print?id={{$user['data']['id']}}" target="_blank"><button data-id={{$user['data']['id']}} class="btn-sm px-1" style="background: none; border: none;" type="button"><span class="badge btn-sm badge-dark p-0 rounded-circle" style="background: #019faf;"><i class="align-middle mb-1 mt-1 mx-1 w-50 text-white" data-feather="file-text"></i></span></button></a>              
                                                </form>
                                            </td>
                                            <td>
                                                <div class="avatar-box thumb-xs align-self-center" style="margin-top: 5px;">
                                                    <span style="background: #202020;" class="avatar-title rounded-circle">{{$user['color']}}</span>
                                                </div>
                                                @if(isset($storeData['Specification-Sheet Edit']) && !empty($storeData['Specification-Sheet Edit'])) 
                                                    @if(isset($storeData['Specification-Sheet Edit']) == 1)
                                                        @if($user['data']->status == "Pending")
                                                            <a href="specification-sheet-color-edit?id={{$user['data']['id']}}" target="_blank"><button data-id={{$user['data']['id']}} class="btn-sm px-0" style="background: none; border: none;" type="button"><span class="badge btn-sm badge-dark p-0 rounded-circle" type="submit" style="background: #202020;"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="edit"></i></span></button></a>                 
                                                        @endif    
                                                    @endif
                                                @endif
                                            </td>  
                                            <div class="modal fade" id="exampleModalCenter5" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header" style="background: transparent;">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Delete Pricing Sheet</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            Select "Delete" below if you are ready to delete Pricing Sheet?
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
        });
        break;
    }
  @endif
</script>
<script>
    $(".CreateJobOrder").click(function(){
        var dataid = $(this).attr("data-id");
        var id = $(this).attr("id");
        $('#id_no').val(id);
        $('#design_no').html(dataid);
        $('#exampleModalCenter9').modal('show');
    });
    $(".allowduplicate").click(function(){
        var id = $("#id_no").val();
        allowduplicate(id);
        $('#exampleModalCenter9').modal('hide');
    });
    function allowduplicate(id){
        $.ajax({
                type: 'GET',
                url: 'createJobOrder/'+id,
                dataType: "json",
                success: function(data){
                    if(data.value == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Job Order Created',
                            showConfirmButton: false,
                            timer: 4000
                        });
                        window.location.href = 'job-order-table';
                    }
                    else{
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