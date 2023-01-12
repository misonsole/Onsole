@extends('layouts.admin-layout')
@section('content')
<style>
    .file-upload .file-upload-select{
        display: block;
        color: black;
        cursor: pointer;
        text-align: left;
        background: #bdc2c7;
        overflow: hidden;
        position: relative;
        border-radius: 6px;
    }
    .file-upload .file-upload-select .file-select-button{
        background: #bdc2c7;
        padding: 10px;
        display: inline-block;
    }
    .file-upload .file-upload-select .file-select-name{
        display: inline-block;
        padding: 10px;
    }
    .file-upload .file-upload-select:hover .file-select-button{
        background: #324759;
        color: #ffffff;
        transition: all 0.2s ease-in-out;
        -moz-transition: all 0.2s ease-in-out;
        -webkit-transition: all 0.2s ease-in-out;
        -o-transition: all 0.2s ease-in-out;
    }
    .file-upload .file-upload-select input[type="file"]{
        display: none;
    }
    .displayBadge{
        display: none; 
        text-align :center;
    }
    .displayBadges{
        text-align :center;
    }
    .toggle{
        background: none;
        border: none;
        color: grey;
        font-weight: 400;
        position: absolute;
        right: 1.30em;
        top: 2.85em;
        z-index: 9;
    }
    .fa{
        font-size: 1.1rem;
    }
    .lightpick{
        box-shadow: none;
    }
    .lightpick.lightpick--inlined{
        z-index: auto;
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
</style>
<link href="plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">
<link href="plugins/lightpick/lightpick.css" rel="stylesheet" />
<div id="loader1" class="rotate" width="100" height="100"></div>
<div class="container-fluid px-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Welcome, {{Auth::user()->emp_name}}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2">
            <div class="card card-eco">
                <div class="card-body">  
                    <div class="row">
                        <div class="col-8">
                            <h4 class="title-text mt-0">Active Users</h4>
                            <h3 class="font-weight-semibold mb-1">{{$active}}</h3>
                            <p class="mb-0 text-transparent">&nbsp;</p>
                        </div>
                        <div class="col-4 text-center align-self-center">
                            <i class="dripicons-user card-eco-icon text-success align-self-center" style="font-size: 30px;"></i>  
                        </div>                                                                  
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="card card-eco">
                <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <h4 class="title-text mt-0">Deactive Users</h4>
                            <h3 class="font-weight-semibold mb-1">{{$deactive}}</h3>
                            <p class="mb-0 text-transparent">&nbsp;</p>
                        </div>
                        <div class="col-4 text-center align-self-center">
                            <i class="dripicons-wrong card-eco-icon text-warning align-self-center" style="font-size: 30px;"></i>  
                        </div>                                                                      
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="card card-eco">
                <div class="card-body">  
                    <div class="row">
                        <div class="col-8">
                            <h4 class="title-text mt-0">Terminate Users</h4>
                            <h3 class="font-weight-semibold mb-1">{{$terminate}}</h3>
                            <p class="mb-0 text-transparent">&nbsp;</p>
                        </div>
                        <div class="col-4 text-center align-self-center">
                            <i class="dripicons-trash card-eco-icon text-danger align-self-center" style="font-size: 30px;"></i>  
                        </div>                                                                  
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="card card-eco">
                <div class="card-body">  
                    <div class="row">
                        <div class="col-8">
                            <h4 class="title-text mt-0">Objective Users</h4>
                            <h3 class="font-weight-semibold mb-1">{{$objUser}}</h3>
                            <p class="mb-0 text-transparent">&nbsp;</p>
                        </div>
                        <div class="col-4 text-center align-self-center">
                            <i class="dripicons-to-do card-eco-icon text-dark align-self-center" style="font-size: 30px;"></i>  
                        </div>                                                                          
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="card card-eco">
                <div class="card-body">  
                    <div class="row">
                        <div class="col-8">
                            <h4 class="title-text mt-0">Total Users</h4>
                            <h3 class="font-weight-semibold mb-1">{{$total}}</h3>
                            <p class="mb-0 text-transparent">&nbsp;</p>
                        </div>
                        <div class="col-4 text-center align-self-center">
                            <i class="dripicons-user-group card-eco-icon text-secondary align-self-center" style="font-size: 30px;"></i>  
                        </div>                                                                          
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="card card-eco">
                <div class="card-body">  
                    <div class="row">
                        <div class="col-9">
                            <h4 class="title-text mt-0">Total Departments</h4>
                            <h3 class="font-weight-semibold mb-1">{{$department}}</h3>
                            <p class="mb-0 text-transparent">&nbsp;</p>
                        </div>
                        <div class="col-3 text-center align-self-center">
                            <i class="dripicons-store card-eco-icon text-primary align-self-center" style="font-size: 30px;"></i>  
                        </div>                                                                          
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-lg-6 mb-5">
            <div class="card h-100">
                <div class="card-body table-responsive">
                    <div class="">
                        <table id="datatable2" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Department Name</th>
                                    <th>Employee</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($totalUser as $data)
                                <tr>
                                    <th scope="row">{{$count++}}</th>
                                    <td>{{$data['name']}}</td>
                                    <td>{{$data['count']}}</td>
                                </tr>
                                @endforeach                        
                            </tbody>
                        </table>
                    </div>           
                </div>
            </div>                    
        </div>   
        <div class="col-lg-3">
            <div class="card h-100" style="max-height: 90%;">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-0">Departments</h4>  
                    <div id="ana_device" class="apex-charts py-5"></div>
                </div>                                                                                                
            </div>
        </div>           
        <div class="col-lg-3">
            <div class="card h-100" style="max-height: 90%;">
                <div class="card-body py-5">
                    <div class="dash-datepick">
                        <input type="hidden" id="light_datepick"/>
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
    $(document).ready( function () {
  var table = $('#datatable2').DataTable( {
    pageLength : 5,
  } )
} );
$(document).ready(function(){ 
	$("#loader1").fadeOut(500);
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
@endsection