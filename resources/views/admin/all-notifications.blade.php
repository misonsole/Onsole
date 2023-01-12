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
    .yourclass::-webkit-input-placeholder{
        color: #6c757d;
    }
    #loader1{  
        position: fixed;  
        left: 0px;  
        top: 0px;  
        width: 100%;  
        height: 100%;  
        z-index: 9999;  
        background: url("/img/avatars/3dgifmaker.gif") 50% 50% no-repeat black;  
    }
    .table_row:hover{
        /* background-color: #435177; */
        background-color: #f1f5fa;
        cursor: pointer;
    }
    #image321:hover{
        transform: scale(1.5);
        transition: transform .5s;
        cursor: pointer;
    }
</style>
<link href="../../plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">
<div id="loader1" class="rotate" width="100" height="100"></div>
<div class="container-fluid px-5">
    <div class="row px-2">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Latest Activities</li>
                    </ol>
                </div>
                <h4 class="page-title">Latest Activities</h4>
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-lg-8 col-md-12 col-sm-12 mb-5" style="margin: 0 auto;">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive p-5">
                        <table id="datatable2" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="thead-dark">
                                <tr>
                                    <th data-orderable="false" class="sorting_disabled">#</th>
                                    <th data-orderable="false" class="sorting_disabled">Notification</th>
                                    <th data-orderable="false" class="sorting_disabled">Date</th>
                                    <th data-orderable="false" class="sorting_disabled">Time</th>
                                    <th data-orderable="false" class="sorting_disabled">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notification as $val)
                                <?php
                                    date_default_timezone_set("Asia/karachi");
                                    $time = date("h:i A");
                                    $datetime2 = new DateTime($time);
                                    $month = $val->created_at;
                                    $delimiter = ' ';
                                    $words = explode($delimiter, $month);
                                    $datetime3 = new DateTime($val->created_at);
                                    $interval = $datetime2->diff($datetime3);
                                    $diff = $interval->format('%h hr %i min');
                                ?>
                                <a href="{{$val->url}}?id={{$val->complaint}}&userid={{$val->userid}}" target="_blank">
                                <tr onclick="window.open('{{$val->url}}?id={{$val->complaint}}&userid={{$val->userid}}', '_blank')" class="table_row">
                                    <th onclick="window.open('your_html', '_blank')">{{$i++}}</th>
                                    <td class="text-left" style="width: 35%;">
                                    @if($val->event == 'Complaint Solved')
                                            <img id="image321" style="transition: transform .5s;" src="img/avatars/tick.png" alt="user" class="rounded-circle thumb-sm mr-1 ml-3">
                                        @elseif($val->event == 'In Process')
                                            <img id="image321" style="transition: transform .5s;" src="img/avatars/images (1).png" alt="user" class="rounded-circle thumb-sm mr-1 ml-3">
                                        @elseif($val->event == 'New Message')
                                            @if(isset($val->image) && !empty($val->image)) 
                                                <img id="image321" style="transition: transform .5s;" src="{{asset('uploads/appsetting/'.$val->image)}}" alt="user" class="rounded-circle thumb-sm mr-1 ml-3">    
                                            @else
                                                <img id="image321" style="transition: transform .5s;" src="img/avatars/avatar-2.jpg" alt="user" class="rounded-circle thumb-sm mr-1 ml-3">
                                            @endif
                                        @else
                                            @if(isset($val->image) && !empty($val->image)) 
                                                <img id="image321" style="transition: transform .5s;" src="{{asset('uploads/appsetting/'.$val->image)}}" alt="user" class="rounded-circle thumb-sm mr-1 ml-3">    
                                            @else
                                                <img id="image321" style="transition: transform .5s;" src="img/avatars/avatar-2.jpg" alt="user" class="rounded-circle thumb-sm mr-1 ml-3">
                                            @endif
                                        @endif
                                        @if($val->event == 'Complaint Solved')
                                            @if($val->read_at != NULL)
                                                <b style="font-weight: 600;">{{$val->event}}</b> By {{$val->name}}
                                            @else
                                                <b style="font-weight: 600;">{{$val->event}}</b> By {{$val->name}}<i style="font-size: xx-small;" class="mdi mdi-circle-slice-8 mr-1 text-danger"></i>
                                             @endif
                                        @elseif($val->event == 'In Process')
                                            @if($val->read_at != NULL)
                                                <b style="font-weight: 600;">{{$val->event}}</b> By {{$val->name}}
                                            @else
                                                <b style="font-weight: 600;">{{$val->event}}</b> By {{$val->name}}<i style="font-size: xx-small;" class="mdi mdi-circle-slice-8 mr-1 text-danger"></i>
                                            @endif
                                        @else
                                            @if($val->read_at != NULL)
                                                <b style="font-weight: 600;">{{$val->event}}</b> By {{$val->name}}
                                            @else
                                                <b style="font-weight: 600;">{{$val->event}}</b> By {{$val->name}} <span style="color:red; font-size: large;">*</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <i class="mdi mdi-calendar-text-outline" style="font-size: large;"></i> {{$words[0]}}
                                    </td>
                                    <td>
                                        <i class="mdi mdi-timer" style="font-size: large;"></i> {{$words[1]}}
                                    </td>
                                    <td><a href="{{$val->url}}?id={{$val->complaint}}&userid={{$val->userid}}" target="_blank"><i class="align-middle mb-1 mt-1 mx-1" data-feather="eye"></i></a></td>
                                </tr>
                                </a>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> 
    </div>
    <div class="row" hidden>
        <div class="col-lg-4" >
            <div class="card" style="font-family: unset;">
                <div class="card-body p-3" style="overflow-y: scroll; max-height: 700px;"> 
                        @foreach($notification as $val)
                            @if($val->event == 'Complaint Solved')
                              
                                @if($val->read_at != NULL)
                                <span style="display: inline-flex; background: #d9e3eb7d;" class="w-100">
                                @else
                                <span style="display: inline-flex; background: white;" class="w-100">
                                @endif
                            @else
                               
                                @if($val->read_at != NULL)
                                <span style="display: inline-flex; background: #d9e3eb7d;" class="w-100">
                                @else
                                <span style="display: inline-flex; background: white;" class="w-100">
                                @endif
                            @endif
                                <a href="#" class="dropdown-item py-3" id="notification">                                    
                                    <?php
                                        date_default_timezone_set("Asia/karachi");
                                        $time = date("h:i A");
                                        $datetime2 = new DateTime($time);
                                        $month = $val->created_at;
                                        $delimiter = ' ';
                                        $words = explode($delimiter, $month);
                                        $datetime3 = new DateTime($val->created_at);
                                        $interval = $datetime2->diff($datetime3);
                                        $diff = $interval->format('%h hr %i min');
                                    ?>
                                    <div class="media">
                                        @if($val->event == 'Complaint Solved')
                                            <img style="margin-left: -6px;" src="img/avatars/tick.png" alt="user" class="rounded-circle thumb-sm">
                                        @elseif($val->event == 'In Process')
                                            <img style="margin-left: -6px;" src="img/avatars/images (1).png" alt="user" class="rounded-circle thumb-sm">
                                        @elseif($val->event == 'New Message')
                                            @if(isset($val->image) && !empty($val->image)) 
                                                <img style="margin-left: -6px;" src="{{asset('uploads/appsetting/'.$val->image)}}" alt="user" class="rounded-circle thumb-sm">    
                                            @else
                                                <img style="margin-left: -6px;" src="img/avatars/avatar-2.jpg" alt="user" class="rounded-circle thumb-sm">
                                            @endif
                                        @else
                                            @if(isset($val->image) && !empty($val->image)) 
                                                <img style="margin-left: -6px;" src="{{asset('uploads/appsetting/'.$val->image)}}" alt="user" class="rounded-circle thumb-sm">    
                                            @else
                                                <img style="margin-left: -6px;" src="img/avatars/avatar-2.jpg" alt="user" class="rounded-circle thumb-sm">
                                            @endif
                                        @endif
                                        <div class="media-body align-self-center ml-2 text-truncate">
                                                @if($val->read_at != NULL)
                                                <h6 style="font-family: unset; text-transform: capitalize;" class="my-0 font-weight-normal text-dark">{{$val->event}}</h6>
                                                @else
                                                <h6 style="font-family: unset; text-transform: capitalize;" class="my-0 font-weight-normal text-dark">{{$val->event}}<small class="float-left"><i style="font-size: xx-small;" class="mdi mdi-circle-slice-8 mr-1 text-danger"></i></small> </h6>
                                                @endif
                                            @if($val->event == 'Complaint Solved')
                                            <small style="font-family: unset;" class=" mb-0">By <span style="font-weight: 600; font-family: unset; letter-spacing: 0.3px;"> {{$val->name}}</span></small>
                                            @elseif($val->event == 'In Process')
                                            <small style="font-family: unset;" class=" mb-0">By <span style="font-weight: 600; font-family: unset; letter-spacing: 0.3px;"> {{$val->name}}</span></small>
                                            @else
                                            <small style="font-family: unset;" class=" mb-0">From <span style="font-weight: 600; font-family: unset; letter-spacing: 0.3px;"> {{$val->name}}</span></small>
                                            @endif
                                        </div>
                                            <span>
                                            <small style="font-size: small;" class="float pl-2"><i class="mdi mdi-calendar-text-outline"></i> {{$words[0]}}</small>
                                            <br>                                
                                            <small style="font-size: small;" class="float pl-2"><i class="mdi mdi-timer"></i> {{$words[1]}}</small>
                                            </span>
                                    </div>
                                </a>
                                <span hidden data-toggle="tooltip" data-placement="top" title="&nbsp; Mark as Read &nbsp;" onclick="myFunction('{{ $val->id }}');" class="py-3" style="font-size: x-large; cursor: pointer;"><i class="mdi mdi-progress-check"></i></span>
                            </span>                       
                        @endforeach
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
</script>
<script>
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
@endsection