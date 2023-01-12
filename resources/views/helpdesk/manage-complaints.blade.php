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
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Manage Complaints</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Manage Complaints</h4>
                    <br>
                    <a href="{{url('manage-all-complaints')}}" target="_blank"><button style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); border: none;" class="btn px-3 btn-md text-white">View All Complaints</button></a>
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="apexchart-wrapper">
                            <div id="budgets_chart" class="apex-charts"></div>
                        </div>
                    </div>                                                                                             
                </div>
            </div>
        </div>
        <div class="row" hidden>                        
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">  
                        <h4 class="header-title mt-0">Complaints Status</h4>                                                                    
                        <div class="">
                            <div id="ana_dash_1" class="apex-charts"></div>
                        </div>  
                    </div>                           
                </div>
            </div>
        </div>
        <div class="row">                        
            <div class="col-lg-12 mb-5">
                <div class="card">
                    <div class="card-body">
                        @if($diff != 'empty')
                        <p class="badge badge-soft-dark font-11 mx-1 p-3 mb-1 float-md-none">
                            Last Complaint {{$diff}} Ago 
                            <span style="font-size: medium;"> &#128344; </span>
                        </p>
                        @endif
                        <div class="card-body table-responsive p-5">
                            <div class="">
                                <table id="datatable2" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="px-1" data-orderable="false" style="color: aliceblue;"></th>
                                            <th hidden>#</th>
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
                                                <div class="spinner-grow text-danger" role="status"></div>
                                                @else
                                                <div class="spinner-grow text-white" role="status"></div>
                                                @endif
                                            </td>
                                            <td hidden>{{$i++}}</td>
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
                                            <td> 
                                                @if($value['data']['updated_at'] != NULL)
                                                <a href="complaints-view?id={{$value['data']['complaint']}}&userid={{$value['data']['userid']}}">
                                                    <span class="badge cursor-pointer" style="cursor: pointer; font-size: small; font-weight: 500;">
                                                        <i class="align-middle mb-1 mt-1 mx-1 cursor-pointer" style="size:1px;" data-feather="eye"></i>
                                                    </span>
                                                </a>
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
setInterval(myTimer, 90000);
function myTimer() 
{
    location.reload();
}
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
                url: 'delete/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'User Delete Successfully!',
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
<script>
    $(document).ready(function(){ 
        $.ajax({
            type: 'GET',
            url: 'count',
            dataType: "json",
            success: function(data){
                if(data){
                    console.log("Complain Data");
                    console.log(data);
                    var Complete = new Array();
                    var InProcess = new Array();
                    var NoAction = new Array();
                    var Closed = new Array();
                    var Month = new Array();
                    for(i=0;i<data.length;i++){
                        Complete[i] = data[i].Complete,
                        InProcess[i] = data[i].InProcess,
                        NoAction[i] = data[i].NoAction,
                        Closed[i] = data[i].Closed,
                        Month[i] = data[i].Month
                    }
                    var options = {
                        chart: {
                            height: 340,
                            type: 'bar',
                            toolbar: {
                                show: false
                            }
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                endingShape: 'rounded',
                                columnWidth: '30%',
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            show: true,
                            width: 3,
                            colors: ['transparent'],
                        },
                        colors: ["#f14b4b", "#1eca7b", "#ffb822", "#0dc8de"],
                        series: [{
                            name: 'No Action',
                            data: NoAction
                        }, {
                            name: 'Complete',
                            data: Complete
                        },{
                            name: 'In Process',
                            data: InProcess
                        },{
                            name: 'Closed',
                            data: Closed
                        },],
                        xaxis: {
                        categories: Month,
                        axisBorder: {
                            show: true,
                            color: '#f7f8f9',
                        },  
                        axisTicks: {
                            show: true,
                            color: '#bec7e0',
                        },    
                        },
                        yaxis: {
                            labels:{
                            formatter: (val) => {
                                return val 
                            }
                            },
                            title: {
                                text: 'Complaints',
                            }
                        },
                        legend: {    
                            offsetY: -10
                        },
                        
                        fill: {
                            opacity: 1

                        },
                        grid: {
                            row: {
                                colors: ['transparent', 'transparent'],
                                opacity: 0.2
                            },
                            borderColor: '#f1f3fa'
                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return val 
                                }
                            }
                        }
                    }
                    var chart = new ApexCharts(document.querySelector("#budgets_chart"), options);
                    chart.render();        
                }
            }
        });
    }) 
</script>
@endsection