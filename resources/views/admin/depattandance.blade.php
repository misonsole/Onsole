@extends( (Auth::user()->id == "2") ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<?php $currentMonth =date("Y-m"); ?>
<link href="plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">
<link href="plugins/lightpick/lightpick.css" rel="stylesheet" />
<style>
    .file-upload .file-upload-select {
        display: block;
        color: black;
        cursor: pointer;
        text-align: left;
        background: #bdc2c7;
        overflow: hidden;
        position: relative;
        border-radius: 6px;
    }

    .file-upload .file-upload-select .file-select-button {
        background: #bdc2c7;
        padding: 10px;
        display: inline-block;
    }

    .file-upload .file-upload-select .file-select-name {
        display: inline-block;
        padding: 10px;
    }

    .file-upload .file-upload-select:hover .file-select-button {
        background: #324759;
        color: #ffffff;
        transition: all 0.2s ease-in-out;
        -moz-transition: all 0.2s ease-in-out;
        -webkit-transition: all 0.2s ease-in-out;
        -o-transition: all 0.2s ease-in-out;
    }

    .file-upload .file-upload-select input[type="file"] {
        display: none;
    }

    .displayBadge {
        display: none;
        text-align: center;
    }

    .displayBadges {
        text-align: center;
    }

    .toggle {
        background: none;
        border: none;
        color: grey;
        font-weight: 400;
        position: absolute;
        right: 1.30em;
        top: 2.85em;
        z-index: 9;
    }

    .fa {
        font-size: 1.1rem;
    }

    .lightpick {
        box-shadow: none;
    }

    .lightpick.lightpick--inlined {
        z-index: auto;
    }

    .noBorder {
        border-right: none !important;
        border-left: none !important;
    }

    .page-item.active .page-link {
        z-index: 3;
        color: #fff;
        background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;
        border-color: transparent;
    }

    .btn-outline:hover, .btn-outline:active, .btn-outline:visited {
        background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;
        border: 1px solid #1761fd !important;
        color: white;
    }
    #loader1 {  
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
<div class="container-fluid px-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Department Attandance</li>
                    </ol>
                </div>
                <h4 class="page-title">Department Attandance</h4>
            </div>
        </div>
    </div>
    <div class="row">
        @if(isset($dep))
            <div class="col-sm-4 mb-1 mb-sm-0">
                <form action="{{url('dep-attendance')}}" id="myForm" method="post" enctype="multipart/form-data">
                    @csrf
                <label hidden><b style="color: #6c757d">Selected User</b></label>
                <span style="display: flex;">
                    <input hidden readonly type="text" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize;" id="name11" name="name11" placeholder="Select User">
                    <input style="border: 1px solid #bfbfbf;" min="2018-01" max="{{$currentMonth}}" value="{{$currentMonth}}" name="month" class="form-control mr-2" type="month" id="example-month-input">
                    <select id="department" name="department" style="border: 1px solid #bfbfbf;" class="form-control select.custom-select" required>
                        <option selected disabled>Select Department</option>   
                        @foreach($department as $value)
                        <option value="{{ $value->name }}">{{ $value->name }}</option>
                        @endforeach
                    </select>
                </span>
                </form>
            </div>
        @endif
    </div>
    <div class="row" hidden>
        <div class="col-lg-3">
            <div class="card card-eco">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8 py-2">
                            @if(isset($value['persentCount']))
                            <input hidden id="present" type="text" value="{{$value['persentCount']}}">
                            @else
                            <input hidden id="present" type="text" value="0">                        
                            @endif

                            @if(isset($value['restdayCount']))
                            <input hidden id="restday" type="text" value="{{$value['restdayCount']}}">
                            @else
                            <input hidden id="restday" type="text" value="0">                        
                            @endif

                            @if(isset($value['gernalholidayCount']))
                            <input hidden id="gh" type="text" value="{{$value['gernalholidayCount']}}">
                            @else
                            <input hidden id="gh" type="text" value="0">                        
                            @endif

                            @if(isset($value['halfdayCount']))
                            <input hidden id="halfday" type="text" value="{{$value['halfdayCount']}}">
                            @else
                            <input hidden id="halfday" type="text" value="0">                        
                            @endif

                            @if(isset($value['absentCount']))
                            <input hidden id="absent" type="text" value="{{$value['absentCount']}}">
                            @else
                            <input hidden id="absent" type="text" value="0">                        
                            @endif

                            @if(isset($value['casualleaveCount']))
                            <input hidden id="casualleaveCount" type="text" value="{{$value['casualleaveCount']}}"> 
                            @else
                            <input hidden id="casualleaveCount" type="text" value="0">                        
                            @endif

                            @if(isset($value['casualleave1Count']))
                            <input hidden id="casualleave1Count" type="text" value="{{$value['casualleave1Count']}}">
                            @else
                            <input hidden id="casualleave1Count" type="text" value="0">                        
                            @endif

                            @if(isset($value['sickleaveCount']))
                            <input hidden id="sickleaveCount" type="text" value="{{$value['sickleaveCount']}}">
                            @else
                            <input hidden id="sickleaveCount" type="text" value="0">                        
                            @endif
                        </div>
                        <div class="col-4 text-center align-self-center">
                            <i class="dripicons-hourglass card-eco-icon text-warning align-self-center"></i>
                        </div>
                    </div>
                    <div class="bg-pattern"></div>
                </div>
            </div>
        </div>
    </div>
    <br>
    @if(isset($NameEmp))
        <h4 style="text-transform: capitalize;">{{$NameEmp}}<span></span></h4>
    @else
        @if(isset($empName))
            <h4 style="text-transform: capitalize;">{{$empName}}<span></span></h4>
            <h4 style="text-transform: capitalize;">{{$empMonth}}<span></span></h4>
        @else
            <h4 style="text-transform: capitalize;"><span> Attandance</span></h4>
        @endif
    @endif
    <div class="row mb-5 mt-4">
        <div class="col-lg-9 col-sm-9 mb-5">
            <div class="card">
                <div class="card-body table-responsive">
                    <div class="">
                        <table id="datatable2" class="table dt-responsive nowrap" 
                            style="border-collapse: collapse; border-spacing: 0; width: 100%; border-top: 10px solid transparent;">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Employee Code</th>
                                    <th>Date</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($name as $data)
                                <tr>
                                    <td>{{$data[0]['name']}}</td>
                                    <td>{{$data[0]['code']}}</td>
                                    <td>{{$data[0]['date']}} <br><span style="font-weight: 700;">{{$data[0]['day']}}</span></td>
                                    <td class="text-center">
                                        @if($data[0]['status'] == "Present")
                                        <button type="button" style="box-shadow: none;" class="btn btn-soft-success btn-sm w-50">{{$data[0]['status']}}</button>
                                        @elseif($data[0]['status'] == "Rest Day")
                                        <button type="button" style="box-shadow: none;" class="btn btn-soft-secondary btn-sm w-50">{{$data[0]['status']}}</button>
                                        @elseif($data[0]['status'] == "G.H")
                                        <button type="button" style="box-shadow: none;" class="btn btn-soft-warning btn-sm w-50">Public Holiday</button>
                                        @elseif($data[0]['status'] == "Half Day")
                                        <button type="button" style="box-shadow: none;" class="btn btn-soft-dark btn-sm w-50">{{$data[0]['status']}}</button>
                                        @else
                                        <button type="button" style="box-shadow: none;" class="btn btn-soft-danger btn-sm w-50">{{$data[0]['status']}}</button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="dash-datepick">
                        <input type="hidden" id="light_datepick" />
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-5">Attendance Status</h4>
                    <div class="my-4">
                        <div id="apex_pie1" class="apex-charts"></div>
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
@include('model/userattandance')
<script src="assets/js/customjquery.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script src="plugins/moment/moment.js"></script>
<script src="plugins/apexcharts/apexcharts.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="plugins/chartjs/chart.min.js"></script>
<script src="plugins/chartjs/roundedBar.min.js"></script>
<script src="plugins/lightpick/lightpick.js"></script>
<script src="assets/pages/jquery.sales_dashboard.init.js"></script>
<script>
    $(document).ready(function(){ 
        $("#loader1").fadeOut(1200);
    });
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch (type) {
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
    $('#deppp').on('change', function() {
    document.getElementById("myForm").submit();
});
</script>
<script>
$(document).ready(function(){
    $(".btnSelectuser").on('click',function(){
        var currentRow = $(this).closest("tr");
        var col2 = currentRow.find("td:eq(2)").html();
        var col3 = currentRow.find("td:eq(3)").html();
        var col1 = currentRow.find("td:eq(1)").html();
        var name11 = currentRow.find("td:eq(0)").html();
        toggle = document.getElementById('example-month-input');
        var name12 = toggle.value;
        console.log(name12);
        console.log(col3);
        $("#exampleModalCenter212").modal('hide');
        console.log(toggle.value);
        $("#emp_name2").val(name12);
        $("#emp_name").val(col2);
        $("#emp_name1").val(col1);
        $("#emp_code").val(col1);
        $("#name11").val(name11);
        document.getElementById("myForm").submit();
        var employee = $("#emp_name").val();
        EmployeeDetail(employee);
        function EmployeeDetail(employee){
            $.ajax({
                    type: 'GET',
                    url: 'employee_detail/'+employee,
                    dataType: "json",
                    success: function(data){
                        if(data){
                            console.log(data);
                            $("#firstname").val(data[0].firstname+" "+data[0].lastname);
                            $("#name").val(data[0].name);
                            $("#lastname").val(data[0].lastname);
                            $("#emp_code").val(data[0].empcode);
                            $("#department").val(data[0].department);
                            $("#designation").val(data[0].designation);
                        }
                    }
                });
            }
    });
});
</script>
<script src="plugins/moment/moment.js"></script>
<script src="plugins/apexcharts/apexcharts.min.js"></script>
<script src="plugins/apexcharts/irregular-data-series.js"></script>
<script src="plugins/apexcharts/ohlc.js"></script>
<script src="assets/pages/jquery.apexcharts.init.js"></script>
@endsection