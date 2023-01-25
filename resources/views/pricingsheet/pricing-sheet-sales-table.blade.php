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
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <!-- <th>Attachment</th> -->
                                        <!-- <th>Season</th> -->
                                        <!-- <th>Sequence</th> -->
                                        <!-- <th>Category</th> -->
                                        <th data-orderable="false">Design No.</th>
                                        <th data-orderable="false">Progress</th>
                                        <th data-orderable="false">Status</th>
                                        <th data-orderable="false">Remarks</th>
                                        <th style="text-align: start;" data-orderable="false">Sales Order No.</th>
                                        <th data-orderable="false">Transfer</th>
                                        <!-- <th>Purpose</th> -->
                                        <th data-orderable="false">Date & Time</th>
                                        <th data-orderable="false">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $user) 
                                        <tr class="table_row">
                                            <td>{{$i++}}</td>
                                            @if($user->image == 0)
                                            <!-- <td class="text-center" style="width: 10px;"><img id="image321" style="transition: transform .5s;" src="{{asset('img/photos/10.jpg')}}" alt="" height="50" class="d-block mt-1 rounded"></td> -->
                                            @else
                                            <!-- <td class="text-center" style="width: 10px;"><img id="image321" style="transition: transform .5s;" src="{{asset('uploads/appsetting/' . $user->image)}}" alt="" height="50" class="d-block mt-1 rounded"></td> -->
                                            @endif
                                            <!-- <td>{{$user->season}}</td> -->
                                            <!-- <td>{{$user->sequence}}</td> -->
                                            <!-- <td>{{$user->category}}</td> -->
                                            <td>{{$user->design_no}}</td>
                                            <td>
                                                <div class="progress" style="box-shadow: none;">
                                                    @if($user->progress == '40')
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
                                                @elseif($user->status == "Reject")
                                                <span class="badge badge-md badge-boxed badge-soft-danger p-2 w-75">Rejected</span>
                                                @elseif($user->status == "Sales")
                                                <span class="badge badge-md badge-boxed badge-soft-success p-2 w-75">Approved</span>
                                                @elseif($user->status == "Final")
                                                <span class="badge badge-md badge-boxed badge-soft-success p-2 w-75">Finalized</span>
                                                @else
                                                <span class="badge badge-md badge-boxed badge-soft-dark p-2 w-75">$user->status</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($user->remarks === NULL) 
                                                    &nbsp;
                                                @else
                                                    <span data-id={{$user['remarks']}} style="cursor: pointer;" class="p-0 cursor-pointer viewweye11 ml-1"><i class="align-middle mb-1 mt-1 mx-1 w-50" style="font-size: small;" data-feather="eye"></i></span>
                                                @endif
                                            </td>
                                            <td style="width: 10%;" class="text-center">
                                                <span class="py-1" style="display: inline-flex;">
                                                    <span class="w-100">
                                                        <input id="sonoNum{{$user['id']}}" name="sonoNum" type="text" value="{{$user['sono']}}" class="form-control yourclass text-center" style="border: 1px solid #bfbfbf;" readonly>
                                                    </span>
                                                    @if($user->status == 'Rejected') 
                                                        <span>
                                                            <a class="btn ModelBtn ml-2 py-0 px-2 rounded-circle"> <i style="font-size: small; color: transparent;" class="mdi mdi-finance"></i></a>
                                                        </span> 
                                                    @elseif($user->status == 'Final') 
                                                        <span>
                                                            <a class="btn ModelBtn ml-2 py-0 px-2 rounded-circle"> <i style="font-size: small; color: transparent;" class="mdi mdi-finance"></i></a>
                                                        </span> 
                                                    @elseif($user->status == 'Costing') 
                                                        <span>
                                                            <a class="btn ModelBtn ml-2 py-0 px-2 rounded-circle"> <i style="font-size: small; color: transparent;" class="mdi mdi-finance"></i></a>
                                                        </span> 
                                                    @else
                                                        <span>
                                                            <a data-id={{$user['id']}} style="font-size: small; cursor: pointer; border: none; box-shadow:none;" class="btn ModelBtn ml-2 py-0 px-2 rounded-circle calculate"> <i style="font-size: large;" class="mdi mdi-finance"></i></a>
                                                        </span> 
                                                    @endif                                                                         
                                                </span>
                                            </td>
                                            @if(isset($storeData['Pricing-Sheet Sales']) && !empty($storeData['Pricing-Sheet Sales'])) 
                                                @if(isset($storeData['Pricing-Sheet Sales']) == 1)
                                                    <td style="width: 10%;">
                                                        @if($user->status == 'Rejected') 
                                                        &nbsp;
                                                        @elseif($user->status == 'Final') 
                                                        &nbsp;
                                                        @elseif($user->status == 'Costing') 
                                                        &nbsp;
                                                        @else
                                                        <select id="status" data-id="{{$user->id}}" name="status" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control status custom-select text-center">
                                                            @if($user->status == 'Sales')                                                    
                                                                <option <?php if ($user->status == "Sales") echo "selected"; ?> value="Sales">Approved</option>
                                                                <option <?php if ($user->status == "Final") echo "selected"; ?> value="Final">Finalised</option>
                                                                <option <?php if ($user->status == "Costing") echo "selected"; ?> value="Costing">Update</option>
                                                                <option <?php if ($user->status == "Rejected") echo "selected"; ?> value="Rejected">Reject</option>
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
                                            <!-- <td>{{$user->purpose}}</td> -->
                                            <td>
                                                <?php $delimiter = ' '; $words = explode($delimiter, $user->created_at); $newDate = date("h:i A", strtotime($words[1]));  ?>
                                                <i class="mdi mdi-calendar-text-outline text-dark"></i> {{$words[0]}} <br><i class="mdi mdi-timer text-dark"></i> {{$newDate}}
                                            </td>
                                            <td class="text-center" style="width: 10%;">
                                                <form id="myForm">
                                                    <input type="text" value="{{$user->id}}" name="id" hidden> 
                                                    @if(isset($storeData['Pricing-Sheet Sales']) && !empty($storeData['Pricing-Sheet Sales']))
                                                        @if(isset($storeData['Pricing-Sheet Sales']) == 1)                                                        
                                                            <!-- <a href="pricing-sheet-edit-sales?id={{$user['id']}}" target="_blank"><button data-id={{$user['id']}}  style="background: none; border: none; margin-right: -2px;" type="button"><span class="badge btn-sm badge-success p-0 rounded-circle" type="submit" style="background: #1eca7b;"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="plus"></i></span></button></a> -->
                                                            <!-- <a href="pricing-sheet-update-sales?id={{$user['id']}}" target="_blank"><button data-id={{$user['id']}} class="px-0" style="background: none; border: none;" type="button"><span class="badge btn-sm badge-success p-0 rounded-circle" type="submit" style="background: #202020;"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="edit"></i></span></button></a>                  -->
                                                        @endif
                                                    @endif
                                                    <a href="pricing-sheet-view?id={{$user['id']}}" target="_blank"><span id="view" data-id={{$user['id']}} style="cursor: pointer; background: #4c82f5;" class="badge badge-info p-0 rounded-circle cursor-pointer viewweye1 ml-1"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="eye"></i></span></a>
                                                    <a href="pricing-sheet-print?id={{$user['id']}}" target="_blank"><button data-id={{$user['id']}} class="btn-sm px-1" style="background: none; border: none;" type="button"><span class="badge btn-sm badge-dark p-0 rounded-circle" style="background: #019faf;"><i class="align-middle mb-1 mt-1 mx-1 w-50 text-white" data-feather="file-text"></i></span></button></a>              
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
                                            <div class="modal fade" id="exampleModalCenter102" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header" style="background-color: transparent">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Sales Order No.</h5>
                                                        </div>
                                                        <form id="Chatform" class="adminForm">
                                                        @csrf
                                                            <div class="modal-body">
                                                                <div class="form-group"> 
                                                                    <div class="input-group">
                                                                        <input hidden type="text" class="form-control yourclass" name="calculateId" id="calculateId">                                                                     
                                                                        <input type="text" placeholder="Sales Order No" class="form-control class1 yourclass" id="sono" name="sono" required>
                                                                    </div>                                                    
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer text-center" style="background-color: transparent">
                                                                <button type="button" style="box-shadow: none;" class="btn btn-dark" data-dismiss="modal">Close</button>
                                                                <button type="submit" style="box-shadow: none; border: none;" class="btn btn-success mx-1 py-2 px-3">Submit</button>
                                                            </div>
                                                        </form>
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
<div class="modal fade bd-example-modal-lg" id="exampleModalCenter10" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="exampleModalLongTitle">Sales Order No.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="row_callback" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <input hidden type="text" class="form-control yourclass" name="calculateId1" id="calculateId1"> 
                            <th class="text-center">Sr No.</th>
                            <th class="text-center">Sales Order No</th>
                            <th class="text-center">Action</th>
                            <th hidden></th>
                            <th hidden></th>
                            <th hidden></th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i=1; $i<$lenght; $i++)
                        <tr>
                            <td class="text-center">{{$i}}</td>
                            <td class="text-center">{{$sono[$i]}}</td>
                            <td hidden>Edinburgh</td>
                            <td hidden></td>
                            <td hidden></td>
                            <td class="text-center"><button class="btn btnSelectuser py-0 text-white w-50" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;">Select</button></td>
                        </tr>
                        @endfor
                    </tbody>
                </table> 
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/customjquery.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script>
$(document).ready(function(){ 
	$("#loader1").fadeOut(1200);
    $(".btnSelectuser").on('click',function(){
		var currentRow = $(this).closest("tr");
        var id = $("#calculateId1").val();
		var value = currentRow.find("td:eq(1)").html();
        var store = $("#sonoNum"+id).val(value);
        $.ajax({
                type: 'GET',
                url: 'storesono/'+value+'/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Sales Order Stored',
                            showConfirmButton: false,
			                timer: 2000
                        });
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!',
                        });
                    }
                }
            });
        $("#exampleModalCenter10").modal('hide');
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
        console.log("status Changed");
        var status = $(this).val();
        var id = $(this).attr("data-id");
        if(status == 'Costing'){
            var line = 'Are you sure Transfer Back to Costing?';
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
        $("#remarks").val(line1);
        $(".joborderstatus").attr("id", id);
        $(".joborderstatus").attr("data-id", status);
        $('#exampleModalCenter9').modal('show');
    }); 
    // $("#edit").click(function(){
    //     var id = $(this).attr("data-id");
    //     $("#myForm").attr("action", "job-order-edit");
    //     document.getElementById("myForm").submit();
    // });
    // $("#printFile").click(function(){
    //     var id = $(this).attr("data-id");
    //     $("#myForm").attr("action", "job-order-print");
    //     document.getElementById("myForm").submit();
    // });
    // $("#view").click(function(){
    //     var id = $(this).attr("data-id");
    //     $("#myForm").attr("action", "job-order-view");
    //     document.getElementById("myForm").submit();
    // });
    $(".viewweye").click(function(){
        var id = $(this).attr("data-id");
        $("#delete-user").attr("data-id", id);
        $('#exampleModalCenter5').modal('show');
    });
    $("#delete-user").click(function(){
        var id = $(this).attr("data-id");
        deleteuser(id);
    });
    $(".calculate").click(function(){
        var id = $(this).attr("data-id");
        $("#calculateId1").val(id);
        $('#exampleModalCenter10').modal('show');
    });
    $(".viewweye11").click(function(){
        var id = $(this).attr("data-id");
        console.log(id);
        $('#modelline1').html(id);
        $('#exampleModalCenter91').modal('show');
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
</script>
@endsection