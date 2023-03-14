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
    select[id="typefrom"]>option:nth-child(2), select[id="typefrom"]>option:nth-child(3), select[id="typefrom"]>option:nth-child(4), select[id="typefrom"]>option:nth-child(5), select[id="typefrom"]>option:nth-child(6), select[id="typefrom"]>option:nth-child(7) {
        font-weight:bold;
    }
    .select2-container--default .select2-selection--single{
        height: 38px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered{
        padding-top: 3px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow{
        height: 26px;
        position: absolute;
        top: 5px;
        right: 1px;
        width: 20px;
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
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Category</b></h6>                            
                            @if(!empty($sessionData['category']))
                                @if($sessionData['category'] != 'none')
                                <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['category']}}</p>
                                @else
                                <p class="mb-2">-</p>
                                @endif
                            @else
                            <p class="mb-2">-</p>
                            @endif
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
                            <h6 class="mb-1"><b>Employee</b></h6>                            
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
                            <h6 class="mb-1"><b>Date</b></h6>                            
                            @if(!empty($sessionData['thedate']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['thedate']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Operator</b></h6>                            
                            @if(!empty($sessionData['operator']))
                                @if($sessionData['operator'] != 'none')
                                <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['operator']}}</p>
                                @else
                                <p class="mb-2">-</p>
                                @endif
                            @else
                            <p class="mb-2">-</p>
                            @endif
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
                                        <th class="text-white" data-orderable="false">No</th>
                                        <th class="text-white" data-orderable="false">Employee</th>
                                        <th class="text-white" data-orderable="false">Department</th>
                                        <th class="text-white" data-orderable="false">Category</th>
                                        <th class="text-white" data-orderable="false">Sub Category</th>
                                        <th class="text-white" data-orderable="false">Status</th>
                                        <th class="text-white" data-orderable="false">Date & Time</th>
                                        <th class="text-white" data-orderable="false">Operator</th>
                                        <th class="text-white" data-orderable="false">Closing Date</th>
                                        <th class="text-white" data-orderable="false">Response Time</th>
                                    </tr>
                                </thead>
                                @if($permission == 1)
                                    <tbody>
                                        @foreach($supportData as $value)
                                        <tr>
                                            <td>{{$value['data']['id']}}</td>
                                            <td>{{$value['name']}}</td>
                                            <td style="text-transform: capitalize;">{{$value['department']}}</td>
                                            <td>{{$value['data']['category']}}</td>
                                            <td>{{$value['data']['subcategory']}}</td>
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
                                                    <?php $delimiter = ' '; $words = explode($delimiter, $value['data']['update_time']); $today1 = date("h:i A", strtotime($words[1])); ?>
                                                    <i class="mdi mdi-calendar-text-outline"></i> {{$words[0]}} <br><i class="mdi mdi-timer"></i> {{$today1}}
                                                    @else
                                                    <?php $delimiter = ' '; $words = explode($delimiter, $value['data']['update_time']);  $today1 = date("h:i A", strtotime($words[1]));?>
                                                    <i class="mdi mdi-calendar-text-outline"></i> {{$words[0]}} <br><i class="mdi mdi-timer"></i> {{$today1}}
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if(isset($value['data']['update_time']) && !empty($value['data']['update_time'])) 
                                                    @if($value['data']['updated_at']!=NULL)
                                                        @if($value['data']['update_time']!=$value['data']['created_at'])
                                                        <?php 
                                                            $start_datetime = new DateTime($value['data']['created_at']); 
                                                            $diff = $start_datetime->diff(new DateTime($value['data']['update_time'])); 
                                                            if($diff->d != 0){
                                                                $dataArray = $diff->d." Day ".$diff->d." Hours ".$diff->i." Min"; 
                                                            }
                                                            elseif($diff->h != 0){
                                                                $dataArray = $diff->h." Hours ".$diff->i." Min"; 
                                                            }
                                                            elseif($diff->i != 0){
                                                                $dataArray = $diff->i." Min"; 
                                                            }
                                                            else{
                                                                $dataArray = $diff->s." Sec"; 
                                                            }
                                                        ?>
                                                        {{$dataArray}}
                                                        @else
                                                        -
                                                        @endif
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
                            <label><b style="color: #6c757d">Department</b></label>
                            <select id="department" name="department" style="border: 1px solid #bfbfbf;" class="select2 form-control mb-3 custom-select">
                                <option value="All">Select Department</option>
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
                            <label><b style="color: #6c757d">User</b></label>
                            <select id="user" name="user" style="border: 1px solid #bfbfbf;" class="select2 form-control mb-3 custom-select">
                                <option value="none" selected>Select User</option>
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
                            <label><b style="color: #6c757d">User</b></label>
                            <select id="selectUser" name="user" style="border: 1px solid #aaa;" class="form-control select.custom-select">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row py-1">
                        <div class="col-sm-6">
                            <label><b style="color: #6c757d">Status</b></label>
                            <select id="status" name="status" style="border: 1px solid #aaa;" class="form-control select.custom-select">
                                <option value="">Select Status</option>
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
                                <input type="text" class="form-control" <?php if(isset($sessionData['strtdte3a'])) echo "value='{{$sessionData['strtdte2a']}} - {{$sessionData['strtdte3a']}}'"; ?> name="daterange">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="dripicons-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row py-2">
                        <div class="col-sm-6 mb-1 mb-sm-0">
                            <label><b style="color: #6c757d">Select Category</b></label>
                            <select id="category" name="category" style="border: 1px solid #bfbfbf;" class="select2 form-control mb-3 custom-select">
                                <option value="none">Select Category</option>
                                @foreach($category as $value)
                                    @if(!empty($sessionData['category']))
                                        <option <?php if($value->category == $sessionData['category']) echo 'selected="selected"'; ?> value="{{ $value->category }}">{{ $value->category }}</option>
                                    @else
                                        <option value="{{ $value->category }}">{{ $value->category }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label><b style="color: #6c757d">Select Operator</b></label>
                            <select id="operator" name="operator" style="border: 1px solid #bfbfbf;" class="select2 form-control mb-3 custom-select">
                                <option value="none" selected>Select Operator</option>
                                @foreach($operator as $value)
                                    @if(!empty($sessionData['operator']))
                                        <option <?php if($value->approve_by == $sessionData['operator']) echo 'selected="selected"'; ?> value="{{ $value->approve_by }}">{{ $value->approve_by }}</option>
                                    @else
                                        <option value="{{ $value->approve_by }}">{{ $value->approve_by }}</option>
                                    @endif
                                @endforeach
                            </select>
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
<script src="assets/js/cdn1.min.js"></script>
<script src="assets/js/cdn2.min.js"></script>
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
<!-- <script>
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
</script> -->
@endsection