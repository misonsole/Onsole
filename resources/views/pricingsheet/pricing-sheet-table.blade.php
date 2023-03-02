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
                            <li class="breadcrumb-item active" style="font-family: 'Poppins', sans-serif;">Manage Pricing Sheet</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Manage Pricing Sheet</h4>
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
                                        <th class="text-white">#</th>
                                        <th class="text-white" data-orderable="false">Design No.</th>
                                        <th class="text-white" data-orderable="false">Progress</th>
                                        <th class="text-white" data-orderable="false">Status</th>
                                        <th class="text-white" data-orderable="false">Remarks</th>
                                        <th class="text-white" data-orderable="false">Transfer</th>
                                        <!-- <th>Purpose</th> -->
                                        <th class="text-white" data-orderable="false">Date & Time</th>
                                        <th class="text-white" data-orderable="false">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $user)
                                        @if($user->status == "Final")
                                        <tr class="table_row" style="background: #d9d9d9; color: #282828;">
                                        @else
                                        <tr class="table_row">
                                        @endif 
                                            <td>{{$i++}}
                                                <input type="text" value="{{$authName}}" hidden class="Authname">
                                            </td>    
                                            <td>{{$user->design_no}}</td>
                                            <td>
                                                <div class="progress" style="box-shadow: none;">
                                                    @if($user->progress == '20')
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">{{$user->progress}}%</div>
                                                    @elseif($user->progress == '40')
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">{{$user->progress}}%</div>
                                                    @elseif($user->progress == '50')
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">{{$user->progress}}%</div>
                                                    @elseif($user->progress == '60')
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-dark" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">{{$user->progress}}%</div>
                                                    @elseif($user->progress == '80')
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-secondary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">{{$user->progress}}%</div>
                                                    @elseif($user->progress == '100')
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">{{$user->progress}}%</div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-center" style="width: 10%;">
                                                @if($user->status == "Costing")
                                                <span class="badge badge-md badge-boxed badge-soft-secondary p-2 w-75">Costing</span>
                                                @elseif($user->status == "Update")
                                                <span class="badge badge-md badge-boxed badge-soft-danger p-2 w-75">Update</span>
                                                @elseif($user->status == "PD")
                                                <span class="badge badge-md badge-boxed badge-soft-dark p-2 w-75">PD</span>
                                                @elseif($user->status == "Pending")
                                                <span class="badge badge-md badge-boxed badge-soft-warning p-2 w-75">Pending</span>
                                                @elseif($user->status == "Rejected")
                                                <span class="badge badge-md badge-boxed badge-soft-danger p-2 w-75">Rejected</span>
                                                @elseif($user->status == "Sales")
                                                <span class="badge badge-md badge-boxed badge-soft-success p-2 w-75">Approved</span>
                                                @elseif($user->status == "Final")
                                                <span class="badge badge-md badge-boxed badge-success p-2 w-75">Finalized</span>
                                                @else
                                                <span class="badge badge-md badge-boxed badge-soft-dark p-2 w-75">{{$user->status}}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($user->remarks === NULL) 
                                                    &nbsp;
                                                @else
                                                    <span data-id={{$user['id']}} style="cursor: pointer;" class="p-0 cursor-pointer viewweye11 ml-1"><i class="align-middle mb-1 mt-1 mx-1 w-50" style="font-size: small;" data-feather="eye"></i></span>
                                                @endif
                                            </td>
                                            @if(isset($storeData['Super-Admin']) && !empty($storeData['Super-Admin'])) 
                                                @if(isset($storeData['Super-Admin']) == 1)
                                                    <td style="width: 10%;">
                                                        <select id="status" data-id="{{$user->id}}" name="status" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control status custom-select text-center">
                                                            <option selected disabled>Change Status</option>
                                                            <option <?php if ($user->status == "Pending") echo "selected"; ?> value="Pending">Pending</option>
                                                            <option <?php if ($user->status == "Costing") echo "selected"; ?> value="Costing">Costing</option>
                                                            <option <?php if ($user->status == "Sales") echo "selected"; ?> value="Sales">Sales</option>
                                                            <option <?php if ($user->status == "PD") echo "selected"; ?> value="PD">PD</option>
                                                        </select>
                                                    </td>
                                                @endif
                                            @else
                                                @if(isset($storeData['Pricing-Sheet Transfer']) && !empty($storeData['Pricing-Sheet Transfer'])) 
                                                    @if(isset($storeData['Pricing-Sheet Transfer']) == 1)
                                                        <td style="width: 10%;">
                                                        @if($user->status == 'Rejected')
                                                        &nbsp;
                                                        @elseif($user->status == 'Sales')
                                                        &nbsp;
                                                        @elseif($user->status == 'Final')
                                                        &nbsp;
                                                        @elseif($user->status == 'Costing')
                                                        &nbsp;
                                                        @else  
                                                            <select id="status" data-id="{{$user->id}}" name="status" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control status custom-select text-center">
                                                                @if($user->status == 'Pending')                                 
                                                                    <option <?php if ($user->status == "Pending") echo "selected"; ?> value="Pending">Pending</option>
                                                                    <option <?php if ($user->status == "Costing") echo "selected"; ?> value="Costing">Costing</option>
                                                                @elseif($user->status == 'Costing')                                                                                                        
                                                                    <option selected disabled value="Costing">Costing</option>
                                                                @elseif($user->status == 'Rejected')                                                                                                        
                                                                    <option selected disabled value="Rejected">Rejected</option>
                                                                @elseif($user->status == 'PD')                                                                                                        
                                                                    <option <?php if ($user->status == "Update") echo "selected"; ?> value="0">Update</option>
                                                                    <option <?php if ($user->status == "Costing") echo "selected"; ?> value="Costing">Costing</option>
                                                                @elseif($user->status == 'Update')                                                                                                        
                                                                    <option <?php if ($user->status == "Update") echo "selected"; ?> value="0">Update</option>
                                                                    <option <?php if ($user->status == "Costing") echo "selected"; ?> value="Costing">Costing</option>
                                                                @elseif($user->status == 'Sales')                                                                                                        
                                                                    <option selected disabled>approved</option>
                                                                @endif
                                                            </select>
                                                        @endif
                                                        </td>
                                                    @endif
                                                @else
                                                <td style="width: 10%;">&nbsp;</td>
                                                @endif
                                            @endif
                                            <div class="modal fade bd-example-modal-lg" id="exampleModalCenter91" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                            <div class="modal fade" id="exampleModalCenter9" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="form-group row py-2 text-center">
                                                                <div class="col-sm-12 mb-1 mb-sm-0">
                                                                    <label for=""><h4 id="modelline" style="color: #6c757d"></h4></label>
                                                                    <input type="text" class="form-control py-2 yourclass remarks" style="border: 1px solid #bfbfbf; text-transform: capitalize" name="remarks" placeholder="Remarks">
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
                                            <div class="modal fade" id="exampleModalCenter10" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header" style="background-color: transparent">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Percentage</h5>
                                                        </div>
                                                        <form id="Chatform" class="adminForm">
                                                        @csrf
                                                            <div class="modal-body">
                                                                <div class="form-group"> 
                                                                    <div class="input-group">
                                                                        <input hidden type="text" class="form-control yourclass calculateId" name="calculateId">                                                                     
                                                                        <input type="number" placeholder="Percentage" class="form-control class1 yourclass" name="calculateValue" required>
                                                                        <span class="input-group-append">
                                                                            <button style="box-shadow: none; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); border: none;" class="btn btn-dark" data-dismiss="modal">%</button>
                                                                        </span>
                                                                    </div>                                                    
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer text-center" style="background-color: transparent">
                                                                <button type="button" style="box-shadow: none;" class="btn btn-dark" data-dismiss="modal">Close</button>
                                                                <button type="submit" style="box-shadow: none; border: none;" class="btn btn-success mx-1 py-2 px-3">Calculate </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <td>{{$user->purpose}}</td> -->
                                            <td>
                                                <?php $delimiter = ' '; $words = explode($delimiter, $user->created_at); $newDate = date("h:i A", strtotime($words[1]));  ?>
                                                <i class="mdi mdi-calendar-text-outline text-dark"></i> {{$words[0]}} <br><i class="mdi mdi-timer text-dark"></i> {{$newDate}}
                                            </td>
                                            <td class="text-center">
                                                <form>
                                                    <input type="text" value="{{$user->id}}" name="id" hidden> 
                                                    @if(isset($storeData['Pricing-Sheet Edit']) && !empty($storeData['Pricing-Sheet Edit'])) 
                                                        @if(isset($storeData['Pricing-Sheet Edit']) == 1)
                                                            @if($user->status === 'Pending' || $user->status === 'PD' || $user->status === 'Update')                                                            
                                                                <a data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Edit&nbsp;&nbsp;" href="pricing-sheet-edit?id={{$user['id']}}" target="_blank"><button data-id={{$user['id']}} class="btn-sm px-0" style="background: none; border: none;" type="button"><span class="badge btn-sm badge-dark p-0 rounded-circle" type="submit" style="background: #202020;"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="edit"></i></span></button></a>                 
                                                            @endif
                                                        @endif
                                                    @endif
                                                    @if(isset($storeData['Pricing-Sheet Delete']) && !empty($storeData['Pricing-Sheet Delete'])) 
                                                        @if(isset($storeData['Pricing-Sheet Delete']) == 1)
                                                            @if($user->status === 'PD')
                                                                <span data-id={{$user['id']}} style="cursor: pointer;" class="badge badge-danger p-0 rounded-circle cursor-pointer viewweye ml-1"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="trash"></i></span>
                                                            @endif
                                                        @endif
                                                    @endif
                                                    @if(isset($storeData['Specification-Sheet Create']) && !empty($storeData['Specification-Sheet Create'])) 
                                                        @if(isset($storeData['Specification-Sheet Create']) == 1)
                                                            @if($user->status === 'Final')
                                                                <a data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Create Specification Sheet&nbsp;&nbsp;" href="pricing-sheet-duplicate?id={{$user['id']}}" target="_blank"><span id="view" data-id={{$user['id']}} style="cursor: pointer; background: #07439d;" class="badge badge-info p-0 rounded-circle cursor-pointer viewweye1 ml-1"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="edit"></i></span></a>
                                                            @endif
                                                        @endif
                                                    @endif
                                                    <a data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;View&nbsp;&nbsp;" href="pricing-sheet-view?id={{$user['id']}}" target="_blank"><span id="view" data-id={{$user['id']}} style="cursor: pointer; background: #4c82f5;" class="badge badge-info p-0 rounded-circle cursor-pointer viewweye1 ml-1"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="eye"></i></span></a>
                                                    <a data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Print&nbsp;&nbsp;" href="pricing-sheet-print?id={{$user['id']}}" target="_blank"><button data-id={{$user['id']}} class="btn-sm px-1" style="background: none; border: none;" type="button"><span class="badge btn-sm badge-dark p-0 rounded-circle" style="background: #019faf;"><i class="align-middle mb-1 mt-1 mx-1 w-50 text-white" data-feather="file-text"></i></span></button></a>
                                                </form>
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
                                            <div class="modal fade" id="exampleModalCewnter51" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
    $('.status').on('change', function(){
        console.log("status Changed");
        var status = $(this).val();
        var id = $(this).attr("data-id");
        if(status == 'Costing'){
            var line = 'Are you sure Transfer to Costing?';
            var line1 = 'Transfer';
        }
        if(status == 'Final'){
            var line = 'Are you sure to Finalized?';
            var line1 = 'Finalized';
        }
        else if(status == 'Approved'){
            var line = 'Are you sure to Approved?';
            var line1 = 'Approved';
        }
        else if(status == 'Sales'){
            var line = 'Are you sure Transfer to Sales Department?';
            var line1 = 'Transfer';
        }
        else if(status == 'Update'){
            var line = 'Are you sure Transfer to PD Department?';
            var line1 = 'Update';
        }
        else if(status == 'Rejected'){
            var line = 'Are you sure to Rejected?';
            var line1 = 'Rejected';
        }
        $('#modelline').html(line);
        $(".remarks").val(line1);
        $(".joborderstatus").attr("id", id);
        $(".joborderstatus").attr("data-id", status);
        $('#exampleModalCenter9').modal('show');
    }); 
    // $("#edit").click(function(){
    //     var id = $(this).attr("data-id");
    //     $("#myForm").attr("action", "pricing-sheet-edit");
    //     document.getElementById("myForm").submit();
    // });
    // $("#printFile").click(function(){
    //     var id = $(this).attr("data-id");
    //     $("#myForm").attr("action", "pricing-sheet-print");
    //     document.getElementById("myForm").submit();
    // });
    // $("#view").click(function(){
    //     var id = $(this).attr("data-id");
    //     $("#myForm").attr("action", "pricing-sheet-view");
    //     document.getElementById("myForm").submit();
    // });
    $(".viewweye").click(function(){
        var id = $(this).attr("data-id");
        $("#delete-user").attr("data-id", id);
        $('#exampleModalCenter51').modal('show');
        // $('#exampleModalCenter5').modal('show');
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
            $('#exampleModalCenter5').modal('show');
        }
    });
    $("#delete-user").click(function(){
        var id = $(this).attr("data-id");
        deleteuser(id);
    });
    $("#calculate").click(function(){
        var id = $(this).attr("data-id");
        $(".calculateId").val(id);
        $('#exampleModalCenter10').modal('show');
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
    $(".joborderstatus").click(function(){
        var status = $(this).attr("data-id");
        var id = $(this).attr("id");
        var remarks = null;
        var remarks = $(".remarks").val();
        joborderstatus(id,status,remarks);
        $('#exampleModalCenter9').modal('hide');
    });
    function joborderstatus(id,status,remarks){
        $.ajax({
            type: 'GET',
            url: 'pricingsheetstatus/'+id+'/'+status+'/'+remarks,
            dataType: "json",
            success: function(data){
                if(data.value == 1){
                    Swal.fire({
                        icon: 'success',
                        title: data.msg,
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
                        const myArray = ["-", "-", "-"];
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
</script>
<script>
    $(function(){
        $('.adminForm').on('submit', function (e){
            e.preventDefault();
            $('#exampleModalCenter10').modal('hide');
            $.ajax({
                type: 'post',
                url: 'calculate/',
                data: $('#Chatform').serialize(),
                success: function()
                {
                    Swal.fire({
                        icon: 'success',
                        title: "Calculated",
                        showConfirmButton: false,
                        timer: 4000
                    });
                    location.reload();
                }
            });
        });
      });
</script>
<script>
    var i = 1;
    $('#colorbtn6').click(function(){
        i++;
        $('#colorrow').append(
                            '<div id="colorrow'+i+'" name="color'+i+'" class="form-group row mb-3 px-3">'+
                                '<div class="col-sm-10 mb-1 mb-sm-0 px-0">'+
                                    '<label><b style="color: #6c757d">Color</b></label>'+
                                    '<select id="colorselect'+i+'" name="colorselectNew[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select colorValue'+i+'">'+     
                                        '<option selected disabled>Select Color</option>'+
                                        '<option value=Zoraiz>Zoraiz</option>'+
                                    '</select>'+
                                '</div>'+
                                '<div class="col-sm-2 mb-1 mb-sm-0">'+
                                    '<label><b style="color: white;">.</b></label>'+
                                    '<button id="'+i+'" style="margin-top: -2px;" type="button" class="btn btn-outline-danger cutting_remove w-100" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</div>'+
                            '</div>');

        $.ajax({
            type: 'GET',
            url: 'GetColor',
            dataType: "json",
            success: function(data){
                if(data){
                    for(z=0; z<data.length; z++){
                        var $dataToBeAppended1 = `<option value=`+data[z]+`>`+data[z]+`</option>`;
                        $(".colorValue"+i).append($dataToBeAppended1);
                    }
                }
            }
        });
    });

    $(document).on('click', '.cutting_remove', function(){
        var id = $(this).attr("id"); 
        $('#colorrow'+id+'').remove();
    });
</script>
@endsection