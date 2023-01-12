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
    .table_row:hover{
        background-color: #f1f5fa;
        cursor: pointer;
    }
    #image321:hover{
        transform: scale(1.5);
        transition: transform .5s;
        cursor: pointer;
    }
</style>
<?php
	$id = Auth::user()->id;
	$Image = DB::table("users")->where("id", $id)->pluck('image');
    $UserImage = $Image[0];
    $count = 1;
?>
<div id="loader1" class="rotate" width="100" height="100"></div>
<div class="container-fluid px-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">User Attandance</li>
                    </ol>
                </div>
                <h4 class="page-title">User Attandance</h4>
            </div>
        </div>
    </div>
    <div class="row">
        @if(isset($dep))
            <div class="col-sm-3 mb-1 mb-sm-0">
                <form action="{{url('get-user-attendance')}}" id="myForm" method="post" enctype="multipart/form-data">
                    @csrf
                <label hidden><b style="color: #6c757d">Selected User</b></label>
                <span style="display: flex;">
                    <input style="border: 1px solid #bfbfbf;" min="2018-01" max="{{$currentMonth}}" value="{{$currentMonth}}" name="month" class="form-control mr-2" type="month" id="example-month-input">                     
                        <span>
                            <a id="submit" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn ml-0 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-send"></i></a>                                        
                        </span>
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
        <div class="col-lg-7 col-sm-7 mb-5">
            <div class="card">
                <div class="card-body table-responsive mt-4 px-5">
                    <div class="">
                        <table id="datatable2" class="table dt-responsive nowrap text-center" 
                            style="border-collapse: collapse; border-spacing: 0; width: 100%; border-top: 10px solid transparent;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th data-orderable="false">Name</th>
                                    <!-- <th data-orderable="false">Employee Code</th> -->
                                    <th>Date</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($name as $data)
                                <tr class="table_row">
                                    <td style="width: 5%;">{{$count++}}</td>
                                    <td>
                                        @if(isset($UserImage) && !empty($UserImage)) 
                                            <img id="image321" style="transition: transform .5s;" src="{{asset('uploads/appsetting/'.$UserImage)}}" alt="user" class="rounded-circle thumb-sm mr-1 ml-3"> 
                                        @else
                                            <img id="image321" style="transition: transform .5s;" src="img/avatars/avatar-2.jpg" alt="user" class="rounded-circle thumb-sm mr-1 ml-3"> 
                                        @endif
                                        <b style="font-weight: 500;">{{$data[0]['name']}}</b>
                                    </td>
                                    <!-- <td>{{$data[0]['code']}}</td> -->
                                    <td>{{$data[0]['date']}} <br><span style="font-weight: 700;">{{$data[0]['day']}}</span></td>
                                    <td class="text-center">
                                        @if($data[0]['status'] == "Present")
                                        <span class="badge badge-md badge-boxed badge-soft-success p-2 w-50">{{$data[0]['status']}}</span>
                                        @elseif($data[0]['status'] == "Rest Day")
                                        <span class="badge badge-md badge-boxed badge-soft-secondary p-2 w-50">{{$data[0]['status']}}</span>
                                        @elseif($data[0]['status'] == "G.H")
                                        <span class="badge badge-md badge-boxed badge-soft-warning p-2 w-50">{{$data[0]['status']}}</span>
                                        @elseif($data[0]['status'] == "Half Day")
                                        <span class="badge badge-md badge-boxed badge-soft-dark p-2 w-50">{{$data[0]['status']}}</span>
                                        @elseif($data[0]['status'] == "Absent")
                                        <span class="badge badge-md badge-boxed badge-soft-danger p-2 w-50">{{$data[0]['status']}}</span>
                                        @else
                                        <span class="badge badge-md badge-boxed badge-soft-danger p-2 w-75">{{$data[0]['status']}}</span>
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
        <div class="col-lg-5">
            <div class="card" style="height: 40%;">
                <div class="card-body">                                    
                    <div class="row">
                        <div class="col-lg-8">
                        @if(isset($empName))
                            <h4 class="header-title mt-0 mb-3">{{$empMonth}}</h4> 
                        @else
                            <h4 class="header-title mt-0 mb-3">Attandance</h4>
                        @endif
                        <div id="barchart" class="apex-charts"></div>
                    </div>
                    <div class="col-lg-4">   
                        <h4 class="header-title mt-0 mb-3">&nbsp;</h4>                                         
                        <div class="traffic-card">                                                
                            <h3 class="text-dark font-weight-semibold">&nbsp;</h3>
                            <h5>&nbsp;</h5>
                        </div>              
                        <ul class="list-unstyled url-list mb-0">
                            <li style="margin-top: -10px;">
                                <i class="mdi mdi-circle-medium text-white"></i>
                                    <span>&nbsp;</span>                                                                                                      
                                </li>
                            <li>
                                <i class="mdi mdi-circle-medium text-danger"></i>
                                <span>Absent</span>                                                                                                      
                            </li>
                            <li>
                                <i class="mdi mdi-circle-medium text-success"></i> 
                                <span>Present</span>                                              
                            </li>
                            <li>
                                <i class="mdi mdi-circle-medium text-secondary"></i>
                                <span>Rest Day</span>                                                 
                            </li>     
                            <li>
                                <i class="mdi mdi-circle-medium text-warning"></i> 
                                <span>Public Holiday</span>                                              
                            </li>                                           
                        </ul>
                        </div>
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
<script src="plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-us-aea-en.js"></script>
<script src="assets/pages/jquery.analytics_dashboard.init.js"></script>
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
    $("#submit").click(function(){
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