@extends('layouts.user-layout')
@section('content')
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
    <div class="row mt-5">
        <div class="col-sm-12">
            <div class="card" style="background: transparent; box-shadow: none;">
                <div class="card-body pl-1 py-2" style="box-shadow: none;">
                    <div class="media">                                  
                        <div class="media-body align-self-center">
                            <h4 class="mt-0 mb-0">Welcome, {{Auth::user()->emp_name}}</h4>
                            <p style="font-family: 'Poppins'; color: #9196a9; font-weight: 500;" class="mb-0 font-14 pr-5">{{Auth::user()->designation}}</p>
                        </div>
                    </div>
                    <div class="welcome-img mr-3" hidden>
                        <div class="row">
                            <div class="col-4">
                                <img src="../assets/images/widgets/weather.png" alt="" height="50" class="mt-n0 mr-3 d-none d-lg-block">
                            </div>
                            <div class="col-8">
                                <h3 class="mb-0">26°C</h3>
                                <h6 class="title-text">Lahore, Pakistan</h6>    
                            </div>
                        </div>
                    </div>                                      
                </div> 
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
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
                            @if(isset($complain['null']))
                            <h3 class="text-dark" id="noAction">{{$complain['null']}}</h3>
                            @else
                            <h3 class="text-dark" id="noAction">0</h3>
                            @endif
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
                            @if(isset($complain['process']))
                            <h3 class="text-dark" id="Process">{{$complain['process']}}</h3>
                            @else
                            <h3 class="text-dark" id="noAction">0</h3>
                            @endif
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
                            @if(isset($complain['final']))
                            <h3 class="text-dark" id="Process">{{$complain['final']}}</h3>
                            @else
                            <h3 class="text-dark" id="noAction">0</h3>
                            @endif
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
                            @if(isset($complain['complete']))
                            <h3 class="text-dark" id="Process">{{$complain['complete']}}</h3>
                            @else
                            <h3 class="text-dark" id="noAction">0</h3>
                            @endif
                            <h6 class="font-14 text-dark">Complete</h6>                                                                                                                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-2" hidden>
                    <div class="card dash-data-card text-center" style="max-height: 86%;">
                        <div class="card-body"> 
                            <div class="icon-info mb-3">
                                <i class="mdi mdi-file-document-box-multiple bg-soft-dark"></i>
                            </div>
                            @if(isset($complain['total']))
                            <h3 class="text-dark" id="Process">{{$complain['total']}}</h3>
                            @else
                            <h3 class="text-dark" id="noAction">0</h3>
                            @endif
                            <h6 class="font-14 text-dark">Total</h6>                                                                                                                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-2" hidden>
                    <div class="card dash-data-card text-center" style="max-height: 86%;">
                        <div class="card-body">   
                            <div class="text-center">
                                <img src="../assets/images/widgets/weather.png" alt="" height="70" >
                                <h2>26°C</h2>
                                <h4 class="title-text">Lahore, Pakistan</h4>
                            </div>
                        </div>                     
                    </div>                     
                </div> 
                <div class="col-lg-4">
                    <div class="card" style="max-height: 86%;">
                        <div class="card-body dash-info-carousel">
                        <h4 class="mt-0 header-title mb-4">Objectives</h4>
                            <div id="carousel_2" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <?php $z = 1; ?>
                                    <div class="carousel-item active">
                                        <div class="media">
                                            <div class="media-body align-self-center">        
                                                @if(isset($data2[0]['objTitle']))                                                  
                                                <h4 class="mt-0 mb-1 title-text text-dark">
                                                    <?php
                                                        $pieces = explode(" ", $data2[0]['objTitle']);
                                                        if(count($pieces) >= 5){
                                                            echo $pieces[0]; echo " "; echo $pieces[1]; echo " "; echo $pieces[2]; echo " "; echo $pieces[3]; echo " "; echo $pieces[4]; echo " ";
                                                        }
                                                        else{
                                                            echo $data2[0]['objTitle'];
                                                        }
                                                    ?>
                                                </h4>
                                                @else
                                                <h4 class="mt-0 mb-1 title-text text-dark">&nbsp;</h4>
                                                @endif
                                                @if(isset($data2[0]['objDescription']))
                                                <p style="font-family: 'Poppins';" class="text-muted mb-0 font-14 pr-5">
                                                    <?php
                                                        $pieces = explode(" ", $data2[0]['objDescription']);
                                                        if(count($pieces) > 6){
                                                            echo $pieces[0]; echo " "; echo $pieces[1]; echo " "; echo $pieces[2]; echo " "; echo $pieces[3]; echo " "; echo $pieces[4];
                                                        }
                                                        else{
                                                            echo $data2[0]['objDescription'];
                                                        }
                                                    ?>
                                                </p>
                                                @else
                                                <div class="text-center">
                                                    <p style="font-family: 'Poppins';" class="text-muted mb-0 font-14">No Objectives Found</p>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @foreach($store as $value1)
                                    <div class="carousel-item">
                                        <div class="media">
                                            <div class="media-body align-self-center">                                                          
                                                @if(isset($value1['title']))                                                  
                                                <h4 class="mt-0 mb-1 title-text text-dark">
                                                    <?php
                                                        $pieces = explode(" ", $value1['title']);
                                                        if(count($pieces) >= 5){
                                                            echo $pieces[0]; echo " "; echo $pieces[1]; echo " "; echo $pieces[2]; echo " "; echo $pieces[3]; echo " "; echo $pieces[4]; echo " ";
                                                        }
                                                        else{
                                                            echo $value1['title'];
                                                        }
                                                    ?>
                                                </h4>
                                                @else
                                                <h4 class="mt-0 mb-1 title-text text-dark">&nbsp;</h4>
                                                @endif
                                                <p style="font-family: 'Poppins';" class="text-muted mb-0 font-14 pr-5">
                                                    <?php
                                                        $pieces = explode(" ", $value1['description']);
                                                        if(count($pieces) > 6){
                                                            echo $pieces[0]; echo " "; echo $pieces[1]; echo " "; echo $pieces[2]; echo " "; echo $pieces[3]; echo " "; echo $pieces[4];
                                                        }
                                                        else{
                                                            echo $value1['description'];
                                                        }
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @if(isset($data2[0]['objTitle'])) 
                                <a class="carousel-control-prev" href="#carousel_2" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carousel_2" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                                @endif
                            </div>
                            <div class="row my-3">
                                <div class="col-sm-6">
                                    <p class="mb-0 text-muted font-13">
                                        @if(isset($data2[0]['objStatus']) == 1)
                                        <span class="badge badge-md badge-boxed badge-warning p-2">Pending</span>
                                        @elseif(isset($data2[0]['objStatus']) == 2)
                                        <span class="badge badge-md badge-boxed badge-success p-2">In-Review HR</span>
                                        @elseif(isset($data2[0]['objStatus']) == 3)
                                        <span class="badge badge-md badge-boxed badge-danger p-2">Revision</span>
                                        @elseif(isset($data2[0]['objStatus']) == 4)
                                        <span class="badge badge-md badge-boxed badge-secondary p-2">Finalised</span>
                                        @else
                                        &nbsp;
                                        @endif
                                        <span class="badge badge-md badge-boxed badge-dark p-2">{{isset($data2[0]['totalscore'])}}</span>
                                    </p>                            
                                </div>
                                <div class="col-sm-6">                                    
                                    <a href="{{url('show-objective')}}"><span class="badge badge-md badge-boxed badge-dark p-2 pull-right">View All</span></a>
                                </div>
                            </div>
                        </div>
                    </div>                     
                </div>                     
            </div>                                                                         
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-lg-8 col-sm-8 mb-5">
            <div class="card">
                <div class="card-body table-responsive mt-4 px-5">
                    <div class=""> 
                        <table id="datatable2" class="table dt-responsive nowrap text-center py-1"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%; border-top: 5px solid transparent;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th data-orderable="false">Name</th>
                                    <th data-orderable="false">Employee Code</th>
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
                                    <b style="font-weight: 400; font-family: 'Poppins';">{{$data[0]['name']}}</b>
                                    </td>
                                    <td>{{$data[0]['code']}}</td>
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
        <div class="col-lg-4">
            <div class="card" style="height: 40%;">
                <div class="card-body">
                    <div class="dash-datepick">
                        <input type="hidden" id="light_datepick" />
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-1 mb-5">Attendance Status</h4>
                    <div class="my-4">
                        <div id="apex_pie1" class="apex-charts"></div>
                    </div>                                        
                </div>
            </div>
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
<script>
    $(document).ready(function(){ 
        $("#loader1").fadeOut(500);
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
<script src="plugins/moment/moment.js"></script>
<script src="plugins/apexcharts/apexcharts.min.js"></script>
<script src="plugins/apexcharts/irregular-data-series.js"></script>
<script src="plugins/apexcharts/ohlc.js"></script>
<script src="assets/pages/jquery.apexcharts.init.js"></script>
@endsection