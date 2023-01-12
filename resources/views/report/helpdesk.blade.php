@extends( (Auth::user()->id == "2") ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<!-- <link href="plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">
<link href="plugins/lightpick/lightpick.css" rel="stylesheet" /> -->
<style>
    .yourclass::-webkit-input-placeholder{
        color: #6c757d;
    }
    table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>td:first-child:before, table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>th:first-child:before {
        top: 12px;
        left: 4px;
        height: 14px;
        width: 14px;
        display: block;
        position: absolute;
        color: white;
        border: 2px solid white;
        border-radius: 14px;
        box-shadow: 0 0 3px #444;
        box-sizing: content-box;
        text-align: center;
        text-indent: 0 !important;
        font-family: 'Courier New', Courier, monospace;
        line-height: 15px;
        content: '+';
        background-color: #0275d8;
    }
    .buttons-copy, .buttons-pdf
    {
        display: none;
    }
    .buttons-excel, .buttons-collection
    {
        background: #1761fd;
        border: none;
        box-shadow: none;
    }
    .buttons-html5
    {
        border-top-left-radius: 5px !important;
        border-bottom-left-radius: 5px !important;
    }
    #loader1
    {  
        position: fixed;  
        left: 0px;  
        top: 0px;  
        width: 100%;  
        height: 100%;  
        z-index: 9999;  
        background: url("/img/avatars/3dgifmaker.gif") 50% 50% no-repeat black;  
    }
    #loader2 
    {  
        position: fixed;  
        left: 0px;  
        top: 0px;  
        width: 100%;  
        height: 100%;  
        z-index: 9999;  
        background: url("/img/avatars/3dgifmaker.gif") 50% 50% no-repeat black;  
    }
</style>
<div id="loader1" class="rotate" width="100" height="100"></div>
<div id="loader2" class="rotate" width="100" height="100"></div>
<div class="container-fluid px-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Help Desk Report</li>
                    </ol>
                </div>
                <h4 class="page-title">Help Desk Report</h4>
                <br>
                <button style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); border: none;" type="button" class="btn text-white" id="reportModel">View Report</button>
            </div>
        </div>
    </div>
    <div class="row mb-5 mt-4">
        <div class="col-lg-12 col-sm-12 mb-5">
            <div class="card">
                <div class="card-body table-responsive">
                <div class="row px-5">
                        <div class="col-md-3 align-self-center">
                        </div>
                        <div class="col-md-6 align-self-center text-center">
                            <h3>Help Desk Report</h3>
                        </div>
                    </div>
                    @if($permission == 1)
                    <div class="row mx-5 text-center py-4" style="border-radius: 5px;">
                        <div class="col-md-1" style="border-top: 1px solid; border-bottom: 1px solid;">
                        </div>  
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Department</b></h6>                            
                            @if(!empty($sessionData['department']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['department']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>User</b></h6>                            
                            @if(!empty($sessionData['user']))
                                @if($sessionData['user'] != 'none')
                                <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['user']}}</p>
                                @else
                                <p class="mb-2">-</p>
                                @endif
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Status</b></h6>                            
                            @if(!empty($sessionData['status']))
                                @if($sessionData['status'] == 'closed')
                                    <p class="mb-2" style="font-family: 'Poppins';">Complete</p>
                                @elseif($sessionData['status'] == 'final')
                                    <p class="mb-2" style="font-family: 'Poppins';">Closed</p>
                                @elseif($sessionData['status'] == 'NULL')
                                    <p class="mb-2" style="font-family: 'Poppins';">No Action</p>
                                @elseif($sessionData['status'] == 'in process')
                                    <p class="mb-2" style="font-family: 'Poppins';">In Process</p>
                                @endif
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>From Date</b></h6>                            
                            @if(!empty($sessionData['start']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['start']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>To Date</b></h6>                            
                            @if(!empty($sessionData['end']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['end']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div>  
                        <div class="col-md-1" style="border-top: 1px solid; border-bottom: 1px solid;">
                        </div>  
                        @if(!empty($from_locatorVal))
                        <input type="text" id="lNo" value="{{$from_locatorVal}}">
                        @endif
                        @if(!empty($to_locatorVal))
                        <input type="text" id="tNo" value="{{$to_locatorVal}}">
                        @endif
                        @if(!empty($book))
                        <input type="text" id="bNo" value="{{$book}}"> 
                        @endif
                    </div>
                    @endif
                    <div class="row p-3">
                        <div class="w-100">
                            <table id="datatable-buttons" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th class="text-white" data-orderable="false">Complaint No</th>
                                        <th class="text-white" data-orderable="false">Employee</th>
                                        <th class="text-white" data-orderable="false">Department</th>
                                        <th class="text-white" data-orderable="false">Category</th>
                                        <th class="text-white" data-orderable="false">Sub Category</th>
                                        <th class="text-white" data-orderable="false">Status</th>
                                        <th class="text-white" data-orderable="false">Date & Time</th>
                                        <th class="text-white" data-orderable="false">Operator</th>
                                        <th class="text-white" data-orderable="false">Closing Date</th>
                                    </tr>
                                </thead>
                                @if($permission == 1)
                                    <tbody>
                                        @foreach($supportData as $value)
                                        <tr>
                                            <td>{{$value['data']['id']}}</td>
                                            <td style="width: 10%;">{{$value['name']}}</td>
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
                                            <td style="width: 10%;">{{$value['data']['category']}}</td>
                                            <td style="width: 10%;">{{$value['data']['subcategory']}}</td>
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
                                            @if($value['data']['updated_at'] == NULL)
                                            <td>
                                            <?php $delimiter = ' '; $words = explode($delimiter, $value['data']['created_at']); ?>
                                            <i class="mdi mdi-calendar-text-outline"></i> {{$words[0]}} <br><i class="mdi mdi-timer"></i> {{$words[1]}}
                                            </td>
                                            @else
                                            <td><i class="mdi mdi-calendar-text-outline"></i> {{$value['data']['date']}} <br> <i class="mdi mdi-timer"></i> {{$value['data']['time']}}</td>
                                            @endif                                            
                                            <td>{{$value['data']['approve_by']}}</td>
                                            <td>
                                                @if(isset($value['data']['update_time']) && !empty($value['data']['update_time'])) 
                                                    @if($value['data']['updated_at']!=NULL)
                                                    <?php $delimiter = ' '; $words = explode($delimiter, $value['data']['update_time']); ?>
                                                    <i class="mdi mdi-calendar-text-outline"></i> {{$words[0]}} <br><i class="mdi mdi-timer"></i> {{$words[1]}}
                                                    @else
                                                    <?php $delimiter = ' '; $words = explode($delimiter, $value['data']['update_time']); ?>
                                                    <i class="mdi mdi-calendar-text-outline"></i> {{$words[0]}} <br><i class="mdi mdi-timer"></i> {{$words[1]}}
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                @endif
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" style="margin-top: 15%;">
        <div class="modal-header" style="background: transparent !important;">
        <h5 class="modal-title" id="exampleModalLongTitle">Help Desk Report</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="card-body px-5 py-1">
                <form method="post" enctype="multipart/form-data" id="myForm">
                    @csrf
                    <div class="form-group row py-2">
                        <div class="col-sm-6 mb-1 mb-sm-0">
                            <label><b style="color: #6c757d">Select Department</b></label>
                            <select id="department" name="department" style="border: 1px solid #bfbfbf;" class="form-control select.custom-select">
                                <option value="All">All Department</option>
                                @foreach($departments as $value)
                                    @if(!empty($sessionData['department']))
                                        <option <?php if($value->name == $sessionData['department']) echo 'selected="selected"'; ?> value="{{ $value->name }}">{{ $value->name }}</option>
                                    @else
                                        <option value="{{ $value->name }}">{{ $value->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6" id="userDiv1">
                            <label><b style="color: #6c757d">Select User</b></label>
                            <select id="user" name="user" style="border: 1px solid #bfbfbf;" class="form-control select.custom-select">
                                <option value="none" selected>None</option>
                                @foreach($user as $value)
                                    @if(!empty($sessionData['user']))
                                        <option <?php if($value->emp_name == $sessionData['user']) echo 'selected="selected"'; ?> value="{{ $value->id }}">{{ $value->emp_name }}</option>
                                    @else
                                        <option value="{{ $value->id }}">{{ $value->emp_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6" id="userDiv2">
                            <label><b style="color: #6c757d">Select User</b></label>
                            <select id="selectUser" name="user" style="border: 1px solid #bfbfbf;" class="form-control select.custom-select">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row py-1">
                        <div class="col-sm-6">
                            <label><b style="color: #6c757d">Select Status</b></label>
                            <select id="status" name="status" style="border: 1px solid #bfbfbf;" class="form-control select.custom-select">
                                <option value="">None</option>
                                @if(!empty($sessionData['status']))
                                    <option value="NULL">No Action</option>
                                    <option <?php if($sessionData['status'] == "in process") echo 'selected="selected"'; ?>  value="in process">In Progress</option>
                                    <option <?php if($sessionData['status'] == "final") echo 'selected="selected"'; ?>  value="final">Closed</option>
                                    <option <?php if($sessionData['status'] == "closed") echo 'selected="selected"'; ?>  value="closed">Complete</option>
                                @else
                                    <option value="NULL">No Action</option>
                                    <option value="in process">In Progress</option>
                                    <option value="final">Closed</option>
                                    <option value="closed">Complete</option>
                                @endif
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label><b style="color: #6c757d">Select Date</b></label>
                            <div class="input-group" style="border: 1px solid #bfbfbf;">                                            
                                <input type="text" class="form-control" name="daterange">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="dripicons-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row py-1">
                    </div>
                    <div class="form-group row mt-2">
                        <div class="col-sm-6">
                            <button type="submit" id="submit" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); border: none;" class="btn px-5 py-1 btn-md btn-block text-white">Show</button>
                        </div>
                        <div class="col-sm-6">
                            <button type="submit" id="download" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); border: none;" class="btn px-5 py-1 btn-md btn-block text-white">Download</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer" style="background: transparent !important;">
            <button type="button" style="background: #1e2438; border: none;" class="btn text-white" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>
<script src="assets/js/customjquery.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<!-- <script src="plugins/moment/moment.js"></script>
<script src="plugins/apexcharts/apexcharts.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="plugins/chartjs/chart.min.js"></script>
<script src="plugins/chartjs/roundedBar.min.js"></script>
<script src="plugins/lightpick/lightpick.js"></script>
<script src="assets/pages/jquery.sales_dashboard.init.js"></script> -->
<script>
$(document).ready(function(){ 
    $("#userDiv1").show();
    $("#userDiv2").hide();
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
    });
    break;
}
@endif
$("#submit").click(function(){
    $("#myForm").attr("action", "helpdesk-report");
    document.getElementById("myForm").submit();
});
$("#download").click(function(){
    $("#myForm").attr("action", "helpdesk-report-download");
    document.getElementById("myForm").submit();
});
$("#loader2").hide();
$("#reportModel").on('click',function(){
    $("#exampleModalCenter").modal('show');
});
</script>
<!-- <script src="plugins/moment/moment.js"></script>
<script src="plugins/apexcharts/apexcharts.min.js"></script>
<script src="plugins/apexcharts/irregular-data-series.js"></script>
<script src="plugins/apexcharts/ohlc.js"></script>
<script src="assets/pages/jquery.apexcharts.init.js"></script> -->
<script>
    $('#department').on('change', function(){
        var category = $(this).val();
        if(category == 'All'){
            $("#userDiv1").show();
            $("#userDiv2").hide();
        }
        else{
            $("#userDiv1").hide();
            $("#userDiv2").show();
        }
            $.ajax({
                type: 'GET',
                url: 'department/'+category,
                dataType: "json",
                success: function(data){
                    if(data){
                        console.log(data);
                        $('#selectUser').find('option').remove();
                        var option2 = "<option value='All'>All</option>"
                        document.getElementById('selectUser').innerHTML += option2;
                        for(var d = 0; d<data.length; d++){
                            var option = "<option value='" + data[d].id + "'>" + data[d].name + "</option>"
                            document.getElementById('selectUser').innerHTML += option;
                        } 
                    }
                }
            });
    });
</script>
@endsection