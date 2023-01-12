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
                            <li class="breadcrumb-item active" style="font-family: 'Poppins', sans-serif;">Manage Pricing</li>
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
                                        <!-- <th>Season</th> -->
                                        <!-- <th>Sequence</th> -->
                                        <!-- <th>Category</th> -->
                                        <th data-orderable="false">Design No.</th>
                                        <th data-orderable="false">Progress</th>
                                        <th data-orderable="false">Status</th>
                                        <th data-orderable="false">Remarks</th>
                                        <!-- <th>Purpose</th> -->
                                        <th data-orderable="false">Date & Time</th>
                                        <th data-orderable="false">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $user) 
                                        <tr class="table_row">
                                            <td>{{$i++}}</td>
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
                                            <div class="modal fade" id="exampleModalCenter99" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header" style="background-color: transparent">
                                                            <h5>Are you sure to Create Job Order?</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group row text-center">
                                                                <div class="col-sm-12 mb-1 mb-sm-0">
                                                                    <label for=""><h4 style="color: #6c757d">Design No </h4></label>
                                                                    <br>
                                                                    <label for=""><h4 id="duplicate99" style="color: #6c757d; font-weight: 400; margin: 0;"></h4></label>
                                                                    <input hidden readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="modelline99" name="modelline99" placeholder="Remarks">
                                                                    <input hidden readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="modelline999" name="modelline999" placeholder="Remarks">                                                            
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer text-center" style="background-color: transparent">
                                                            <button type="button" style="box-shadow: none;" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                            <button type="submit" style="box-shadow: none; border: none;" class="btn btn-success mx-1 py-2 px-3 allowduplicate">Duplicate <i class="fas fa-sign-out-alt"></i> </button>
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
                                            <td class="text-center">
                                                <form id="myForm">
                                                    <input type="text" value="{{$user->id}}" name="id" hidden> 
                                                    @if(isset($storeData['Job-Order Create']) && !empty($storeData['Job-Order Create']))
                                                        @if(isset($storeData['Job-Order Create']) == 1)                                                        
                                                            <button data-toggle="tooltip" data-placement="top" title="&nbsp;Create Job Order&nbsp;" data-id={{$user['design_no']}} id={{$user['id']}} class="px-0 duplicate" style="background: none; border: none;" type="button"><span class="badge btn-sm badge-success p-0 rounded-circle" type="submit" style="background: #202020;"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="edit"></i></span></button>                 
                                                        @endif
                                                    @endif
                                                    <a data-toggle="tooltip" data-placement="top" title="&nbsp;View&nbsp;" href="pricing-sheet-view?id={{$user['id']}}" target="_blank"><span id="view" data-id={{$user['id']}} style="cursor: pointer; background: #4c82f5;" class="badge badge-info p-0 rounded-circle cursor-pointer viewweye1 ml-1"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="eye"></i></span></a>
                                                    <a data-toggle="tooltip" data-placement="top" title="&nbsp;Print&nbsp;" href="pricing-sheet-print?id={{$user['id']}}" target="_blank"><button data-id={{$user['id']}} class="btn-sm px-1" style="background: none; border: none;" type="button"><span class="badge btn-sm badge-dark p-0 rounded-circle" style="background: #019faf;"><i class="align-middle mb-1 mt-1 mx-1 w-50 text-white" data-feather="file-text"></i></span></button></a>              
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
    $(".viewweye11").click(function(){
        var id = $(this).attr("data-id");
        console.log(id);
        $('#modelline1').html(id);
        $('#exampleModalCenter91').modal('show');
    });
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