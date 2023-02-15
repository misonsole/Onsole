@extends('layouts.user-layout')
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
    .apexcharts-legend.position-bottom.left, .apexcharts-legend.position-top.left, .apexcharts-legend.position-right, .apexcharts-legend.position-left {
        align-items: flex-start;
        justify-content: flex-start;
    }
    .apexcharts-legend.position-bottom.center, .apexcharts-legend.position-top.center {
        justify-content: center;
        display: none;
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
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="float-right">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Complaint</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Complaint</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">  
                <div class="row">
                    <div class="col-lg-2">
                        <div class="card dash-data-card text-center" style="max-height: 86%;">
                            <div class="card-body"> 
                                <div class="icon-info mb-3">
                                    <i class="fas fa-ticket-alt bg-soft-danger"></i>
                                </div>
                                <h3 class="text-dark" id="noAction">{{$noAction}}</h3>
                                <h6 class="font-14 text-dark">No Action</h6>                                                                                                                            
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card dash-data-card text-center" style="max-height: 86%;">
                            <div class="card-body"> 
                                <div class="icon-info mb-3">
                                    <i class="dripicons-hourglass card-eco-icon text-warning align-self-center bg-soft-warning"></i>
                                </div>
                                <h3 class="text-dark" id="Process">{{$Process}}</h3>
                                <h6 class="font-14 text-dark">In Process</h6>                                                                                                                            
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card dash-data-card text-center" style="max-height: 86%;">
                            <div class="card-body"> 
                                <div class="icon-info mb-3">
                                    <i class="dripicons-checkmark card-eco-icon text-secondary align-self-center bg-soft-secondary"></i>
                                </div>
                                <h3 class="text-dark" id="final">{{$final}}</h3>
                                <h6 class="font-14 text-dark">Closed</h6>                                                                                                                            
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card dash-data-card text-center" style="max-height: 86%;">
                            <div class="card-body"> 
                                <div class="icon-info mb-3">
                                    <i class="mdi mdi-checkbox-multiple-marked-circle-outline bg-soft-success"></i>
                                </div>
                                <h3 class="text-dark" id="complete">{{$complete}}</h3>
                                <h6 class="font-14 text-dark">Complete</h6>                                                                                                                            
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card dash-data-card text-center" style="max-height: 86%;">
                            <div class="card-body"> 
                                <div class="icon-info mb-3">
                                    <i class="mdi mdi-file-document-box-multiple bg-soft-dark"></i>
                                </div>
                                <h3 class="text-dark" id="total">{{$total}}</h3>
                                <h6 class="font-14 text-dark">Total</h6>                                                                                                                            
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card dash-data-card text-center" style="max-height: 86%;">
                            <div class="card-body">   
                                <div class="row py-2">
                                    <div class="apexchart-wrapper">
                                        <div id="ana_device" class="apex-charts mt-2"></div>
                                    </div>
                                </div>      
                            </div>                     
                        </div>                     
                    </div>                     
                </div>                                                                         
            </div>
        </div>
        <div class="row">                        
            <div class="col-lg-12 mb-5">
                <div class="card">
                    <div class="card-body">
                        <div class="card-body table-responsive p-5">
                            <div class="">
                                <table id="datatable2" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="px-1" data-orderable="false" style="color: aliceblue;"></th>
                                            <th>Complaint No</th>
                                            <th>Employee</th>
                                            <th>Department</th>
                                            <th>Status</th>
                                            <th>File</th>
                                            <th>Date & Time</th>
                                            <th>Operator</th>
                                            <th>Closing Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($support as $value) 
                                        <tr>
                                            <td>
                                                @if($value['data']['status'] == NULL)
                                                <div hidden class="spinner-grow text-danger" role="status"></div>
                                                @else
                                                <div hidden class="spinner-grow text-white" role="status"></div>
                                                @endif
                                            </td>
                                            @if($value['data']['updated_at'] == NULL)
                                            <td>{{$value['data']['id']}}</td>
                                            @else
                                            <td>{{$value['data']['id']}}</td>
                                            @endif
                                            <td>{{$value['data']['username']}}</td>
                                            <td style="text-transform: capitalize;">
                                            <?php
                                                $pieces = explode(" ", $value['department']);
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
                                                @if($value['data']['status'] == NULL)    
                                                <span class="badge badge-md badge-boxed badge-soft-danger p-2 w-100">No Action</span>
                                                @elseif($value['data']['status'] == 'in process')
                                                <span class="badge badge-md badge-boxed badge-soft-warning p-2 w-100">In Process</span>
                                                @elseif($value['data']['status'] == 'final')
                                                <span class="badge badge-md badge-boxed badge-soft-secondary p-2 w-100">Closed</span>
                                                @elseif($value['data']['status'] == 'closed')
                                                <span class="badge badge-md badge-boxed badge-soft-success p-2 w-100">Complete</span>
                                                @endif
                                            </td>
                                            <td>
                                            @if(isset($value['data']['doc']) && !empty($value['data']['doc'])) 
                                            <span style="cursor: pointer; font-size: x-large; font-weight: 500; color: #303e67;">
                                                <i class="mdi mdi-attachment" style="size:1px;"></i> 
                                            </span>
                                            @endif
                                            </td>
                                            @if($value['data']['updated_at'] == NULL)
                                            <td>
                                                <?php $delimiter = ' '; $words = explode($delimiter, $value['data']['created_at']); ?>
                                                <i class="mdi mdi-calendar-text-outline"></i> {{$words[0]}} <br><i class="mdi mdi-timer"></i> {{$words[1]}}
                                            </td>
                                            @else
                                            <td>    
                                                <i class="mdi mdi-calendar-text-outline"></i> {{$value['data']['date']}} <br> <i class="mdi mdi-timer"></i> {{$value['data']['time']}}
                                            </td>
                                            @endif 
                                            <td>{{$value['data']['approve_by']}}</td>
                                            <td>
                                                @if(isset($value['data']['update_time']) && !empty($value['data']['update_time'])) 
                                                    <?php $delimiter = ' '; $words = explode($delimiter, $value['data']['update_time']); ?>
                                                    <i class="mdi mdi-calendar-text-outline"></i> {{$words[0]}} <br><i class="mdi mdi-timer"></i> {{$words[1]}}
                                                @endif                                                
                                            </td>
                                            <td> 
                                                <a href="complaints-view-user?id={{$value['data']['id']}}&userid={{$value['data']['userid']}}" target="_blank">
                                                    <span class="badge btn-sm badge-secondary p-0 rounded-circle mx-1" style="cursor: pointer"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="eye"></i></span>  
                                                </a>
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
</div>
<script src="assets/js/customjquery.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script>
$(document).ready(function(){ 
	$("#loader1").fadeOut(1200);
    $("body").addClass("enlarge-menu");
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
                url: 'deleteComplain/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Complaint Deleted',
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