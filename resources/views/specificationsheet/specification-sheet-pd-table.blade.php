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
    #loader1 {  
        position: fixed;  
        left: 0px;  
        top: 0px;  
        width: 100%;  
        height: 100%;  
        z-index: 9999;  
        background: url("/img/avatars/3dgifmaker.gif") 50% 50% no-repeat black;  
    }
    #loader2 {  
        position: fixed;  
        left: 0px;  
        top: 0px;  
        width: 100%;  
        height: 100%;  
        z-index: 9999;  
        background: url("/img/avatars/3dgifmaker.gif") 50% 50% no-repeat black;  
        display: none;
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
<div id="loader2" class="rotate" width="100" height="100"></div>
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
                                        <th class="text-white" data-orderable="false">Transfer</th>
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
                                                @elseif($user['data']->status == "Pending")
                                                    <span class="badge badge-md badge-boxed badge-soft-secondary p-2 w-100">Pending</span>
                                                @elseif($user['data']->status == "Update")
                                                    <span class="badge badge-md badge-boxed badge-soft-danger p-2 w-100">Update</span>
                                                @elseif($user['data']->status == "PD")
                                                    <span class="badge badge-md badge-boxed badge-soft-dark p-2 w-100">PD</span>
                                                @elseif($user['data']->status == "QC")
                                                    <span class="badge badge-md badge-boxed badge-soft-dark p-2 w-100">Quality Control</span>
                                                @elseif($user['data']->status == "Reject")
                                                    <span class="badge badge-md badge-boxed badge-soft-danger p-2 w-100">Rejected</span>
                                                @elseif($user['data']->status == "Sales")
                                                    <span class="badge badge-md badge-boxed badge-soft-success p-2 w-100">Approved</span>
                                                @elseif($user['data']->status == "Final")
                                                    <span class="badge badge-md badge-boxed badge-soft-success p-2 w-100">Finalized</span>
                                                @else
                                                    <span class="badge badge-md badge-boxed badge-soft-dark p-2 w-100">{{$user['data']->status}}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($user['data']->remarks === NULL) 
                                                    &nbsp;
                                                @else
                                                    <span data-id={{$user['data']['id']}} style="cursor: pointer;" class="p-0 cursor-pointer viewweye11 ml-1"><i class="align-middle mb-1 mt-1 mx-1 w-50" style="font-size: small;" data-feather="eye"></i></span>
                                                @endif
                                            </td>
                                            @if(isset($storeData['Specification-Sheet Create']) && !empty($storeData['Specification-Sheet Create'])) 
                                                @if(isset($storeData['Specification-Sheet Create']) == 1)
                                                    <td style="width: 13%;">                                                       
                                                        @if($user['data']->status == 'Rejected') 
                                                        &nbsp;
                                                        @elseif($user['data']->status == 'Update') 
                                                        &nbsp;
                                                        @elseif($user['data']->status == 'Costing') 
                                                        &nbsp;
                                                        @elseif($user['data']->status == 'Sales') 
                                                        &nbsp;
                                                        @elseif($user['data']->status == 'Final') 
                                                        &nbsp;
                                                        @elseif($user['data']->status == 'PPC') 
                                                        &nbsp;
                                                        @else
                                                        <select id="status" data-id="{{$user['data']->id}}" name="status" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control status custom-select text-center">
                                                            @if($user['data']->status == 'Pending')                                                    
                                                                <option value="PD" selected>PD</option>
                                                                <option <?php if ($user['data']->status == "PPC") echo "selected"; ?> value="PPC">PPC</option>
                                                            @endif
                                                        </select>
                                                        @endif
                                                    </td>
                                                @endif
                                            @else
                                            <td style="width: 10%;">&nbsp;</td>
                                            @endif
                                            <div class="modal fade" id="exampleModalCenter9" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="form-group row py-2 text-center">
                                                                <div class="col-sm-12 mb-1 mb-sm-0">
                                                                    <label for=""><h4 id="modelline" style="color: #6c757d"></h4></label>
                                                                    <input type="text" class="form-control py-2 yourclass " style="border: 1px solid #bfbfbf; text-transform: capitalize" id="remarks" name="remarks" placeholder="Remarks">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer text-center" style="background-color: transparent">
                                                            <button type="button" style="box-shadow: none;" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                            <button type="submit" style="box-shadow: none; border: none;" class="btn btn-success mx-1 py-2 px-3 joborderstatus">Allow <i class="fas fa-sign-out-alt"></i> </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="exampleModalCenter91" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header justify-content-center" style="background-color: transparent">
                                                            <h4 class="modal-title" id="exampleModalLongTitle">Transfer Status</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group row mb-1 text-center">
                                                                <div class="col-sm-3 mb-1 mb-sm-0">
                                                                    <h5 style="font-family: system-ui; letter-spacing: 0.4px;">Name</h5>
                                                                </div>
                                                                <div class="col-sm-2 mb-1 mb-sm-0">
                                                                    <h5 style="font-family: system-ui; letter-spacing: 0.4px;">Status</h5>
                                                                </div>
                                                                <div class="col-sm-5 mb-1 mb-sm-0">
                                                                    <h5 style="font-family: system-ui; letter-spacing: 0.4px;">Remarks</h5>
                                                                </div>
                                                                <div class="col-sm-2 mb-1 mb-sm-0">                                                                    
                                                                    <h5 style="font-family: system-ui; letter-spacing: 0.4px;">Date & Time</h5>
                                                                </div>
                                                            </div>
                                                                <span id="msg2">                        
                                                                </span>
                                                        </div>
                                                        <div class="modal-footer text-center" style="background-color: transparent">
                                                            <button type="button" style="box-shadow: none;" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="exampleModalCenter918" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header justify-content-center" style="background-color: transparent">
                                                            <h4 class="modal-title" id="exampleModalLongTitle">Transfer Status</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group row mb-1 text-center">
                                                                <div class="col-sm-12 mb-1 mb-sm-0">
                                                                    <h4 style="font-family: system-ui; letter-spacing: 0.4px; color: #303e67;">Kindly Update Item Codes with System's Item Codes</h4>
                                                                </div>
                                                            </div>
                                                            <span id="msg22">                        
                                                            </span>
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
                                                        @if(isset($storeData['Specification-Sheet Edit']) && !empty($storeData['Specification-Sheet Edit'])) 
                                                            @if(isset($storeData['Specification-Sheet Edit']) == 1)
                                                                @if($user['data']->status === 'Pending')                                                            
                                                                    <a href="specification-sheet-edit?id={{$user['data']['id']}}"><button data-id={{$user['data']['id']}} class="btn-sm px-0" style="background: none; border: none;" type="button"><span class="badge btn-sm badge-dark p-0 rounded-circle" type="submit" style="background: #202020;"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="edit"></i></span></button></a>                 
                                                                @endif
                                                            @endif
                                                        @endif
                                                    <a data-toggle="tooltip" data-placement="top" title="&nbsp;View&nbsp;" href="specification-sheet-view?id={{$user['data']['id']}}" target="_blank"><span id="view" data-id={{$user['data']['id']}} style="cursor: pointer; background: #4c82f5;" class="badge badge-info p-0 rounded-circle cursor-pointer viewweye1 ml-1"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="eye"></i></span></a>
                                                    <a hidden data-toggle="tooltip" data-placement="top" title="&nbsp;Print&nbsp;" href="specification-sheet-print?id={{$user['data']['id']}}" target="_blank"><button data-id={{$user['data']['id']}} class="btn-sm px-1" style="background: none; border: none;" type="button"><span class="badge btn-sm badge-dark p-0 rounded-circle" style="background: #019faf;"><i class="align-middle mb-1 mt-1 mx-1 w-50 text-white" data-feather="file-text"></i></span></button></a>              
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
    $("form").submit(function (event) {
        var formData = {
            name: $("#colorselect1").val(),
            name5: $("#colorselect5").val(),
        };
        console.log("formData");
        console.log(formData);
        console.log("formData");
        $.ajax({
            type: "POST",
            url: "duplicatePSS",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id
            }
        });
        event.preventDefault();        
    });
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
    $('.status').on('change', function(){
        var status = $(this).val();
        var id = $(this).attr("data-id");
        if(status == 'PPC'){
            var line = 'Are you sure Transfer to PPC?';
            var line1 = 'Transfer';
            $('#modelline').html(line);
            $("#remarks").val(line1);
            $(".joborderstatus").attr("id", id);
            $(".joborderstatus").attr("data-id", status);
            $('#exampleModalCenter9').modal('show');
        }
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
    $(".viewweye11").click(function(){
        var id = $(this).attr("data-id");
        $.ajax({
            type: 'GET',
            url: 'remarks/'+id,
            dataType: "json",
            success: function(data){
                if(data.status == 1){
                    $('#msg2').find('div').remove();
                    let dataArray = new Array("-", "-", "-");
                    let statusArray = new Array("-");
                    for(let i = 0; data.count > i;  i++){
                        if(data.data[i].date != null){
                            dataArray = data.data[i].date.split(" ");
                            statusArray = data.data[i].status;
                        }
                        $("#msg2").append('<div class="form-group row mb-1 text-center">'+
                                            '<div class="col-sm-3 mb-1 mb-sm-0">'+
                                                '<h5 style="font-family: system-ui; letter-spacing: 0.4px; font-weight: 400;">'+data.data[i].user_id+'</h5>'+
                                            '</div>'+
                                            '<div class="col-sm-2 mb-1 mb-sm-0">'+
                                                '<h5 style="font-family: system-ui; letter-spacing: 0.4px; font-weight: 400;">'+statusArray+'</h5>'+
                                            '</div>'+
                                            '<div class="col-sm-5 mb-1 mb-sm-0">'+
                                                '<h5 style="font-family: system-ui; letter-spacing: 0.4px; font-weight: 400;">'+data.data[i].remarks+'</h5>'+
                                            '</div>'+
                                            '<div class="col-sm-2 mb-1 mb-sm-0">'+
                                                '<i class="mdi mdi-calendar-text-outline"></i> '+dataArray[0]+'<br><i class="mdi mdi-timer"></i> '+dataArray[1]+' '+dataArray[2]+
                                            '</div>'+
                                        '</div>');
                    }
                    $('#exampleModalCenter91').modal('show');
                }
                else if(data == 400){
                    Swal.fire({
                        icon: 'error',
                        title: 'Something went wrong!',
                    });
                }
            }
        });
        // $('#modelline1').html(id);
    });
    function deleteuser(id){
        $.ajax({
                type: 'GET',
                url: 'deletespecificationsheet/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Specification Sheet Delete Successfully!',
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
    $(".joborderstatus").click(function(){
        var status = $(this).attr("data-id");
        var id = $(this).attr("id");
        var remarks = null;
        var remarks = $("#remarks").val();
        joborderstatus(id,status,remarks);
        $('#exampleModalCenter9').modal('hide');
    });
    function joborderstatus(id,status,remarks){
        $.ajax({
                type: 'GET',
                url: 'specificationsheetstatus/'+id+'/'+status+'/'+remarks,
                dataType: "json",
                beforeSend: function() {
                    $("#loader1").show();
                },
                success: function(data){
                    console.log("data");
                    console.log(data);
                    console.log("data");
                    if(data.value == 1){
                        Swal.fire({
                            icon: 'success',
                            title: data.msg,
                            showConfirmButton: false,
                            timer: 4000
                        });
                        location.reload();
                    }
                    else if(data.value == 2){
                        $('#msg22').find('div').remove();
                        for(let i = 0; data.array.length > i;  i++){
                            $("#msg22").append('<div class="form-group row mb-1 text-center">'+
                                                    '<div class="col-sm-12 mb-1 mb-sm-0">'+
                                                        '<h5 style="font-family: system-ui; letter-spacing: 0.4px; font-weight: 400;">'+data.array[i]+'</h5>'+
                                                    '</div>'+
                                                '</div>');
                        }
                        $('#exampleModalCenter918').modal('show');
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!',
                        });
                    }
                },
                complete: function(data) {
                    $("#loader1").hide();
                }
            });
        }
</script>
<script>
    $(".duplicate").click(function(){
        var dataid = $(this).attr("data-id");
        var id = $(this).attr("id");
        $('#modelline99').val(dataid);
        $('#duplicate99').html(dataid);
        $('#modelline999').val(id);
        $('#exampleModalCenter99').modal('show');
    });
    $(".allowduplicate").click(function(){
        var desgin = $("#modelline99").val();
        var id = $("#modelline999").val();
        allowduplicate(desgin,id);
        $('#exampleModalCenter99').modal('hide');
    });
    function allowduplicate(desgin,id){
        $.ajax({
                type: 'GET',
                url: 'pricingsheetduplicate/'+desgin+'/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Specification Sheet Created',
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