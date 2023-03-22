<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>ONSOLE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="img/photos/modified.png">
    <link href="plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/jquery-ui.min.css" rel="stylesheet">
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/metisMenu.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/dropify/css/dropify.min.css" rel="stylesheet">
    <link href="plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" /> 
    <link rel="stylesheet" href="plugins/rating/themes/rating.css">
    <link href="plugins/daterangepicker/daterangepicker.css" rel="stylesheet" />
    <link href="plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet" type="text/css" />
    <link href="plugins/timepicker/bootstrap-material-datetimepicker.css" rel="stylesheet"> 
    <link href="plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
</head>
<style>
    a:hover {
        text-decoration: none;
    }
    li:hover {
        text-decoration: none;
    }
    .footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        background-color: white;
        color: black;
        text-align: center;
    }
    textarea {
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
    }
    html,
    body {
        margin: 0;
        font-family: Nunito, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    }
    ::-webkit-scrollbar {
        width: 12px;
        height: 12px;
        border-radius: 10px;
    }
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb {
        background: rgb(197, 197, 197);
        border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: rgb(155, 155, 155);
        border-radius: 10px;
    }
    body.dark-topbar .navbar-custom {
        background: #292e40;
    }
    #notification:hover {
        background-color: transparent;
    }
</style>
<?php
	$id = Auth::user()->id;
	$UserDetail = DB::table("users")->where("id", $id)->pluck('userrole');
    $departmentuser = DB::table("users")->where("id", $id)->pluck('department');
    $departmentuser = $departmentuser[0];
	$image = DB::table("users")->where("id", $id)->pluck('image');
	$UserDetail1 = DB::table("newroles")->where("name", $UserDetail)->get();
	$obj = json_decode (json_encode ($UserDetail1), FALSE);
    $storeData = [];
    foreach($obj as $dataa){
        $storeData[$dataa->role_name] = $dataa->value; 
    }
    $image = str_replace('"', '', $image);
    $image = str_replace('[', '', $image);
    $image = str_replace(']', '', $image);
    // echo '<pre>';
    // print_r($storeData);
    // exit();
    $notification = DB::table("notification_details")->orderBy('id','DESC')->where('assign_users', Auth::user()->id)->limit(10)->get();
    $unread = DB::table("notification_details")->orderBy('id','DESC')->where('assign_users', Auth::user()->id)->where('read_at', NULL)->get();
    $count = count($unread);
?>
<body>
<div class="topbar">
    <div class="topbar-left">
        <a href="{{url('home')}}">
            <span>
                <img src="img/photos/preview.png" width="35%" style="margin-top: -12px;" alt="logo-large" class="logo-lg">
            </span>
        </a>
    </div>
    <nav class="navbar-custom px-5">    
        <ul class="list-unstyled topbar-nav float-right mb-0"> 
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="ti-bell noti-icon"></i>
                    <span class="badge badge-danger badge-pill noti-icon-badge">{{$count}}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-lg pt-0">
                    <h6 style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="dropdown-item-text font-15 m-0 py-3 text-white d-flex justify-content-between align-items-center">Notifications<span class="badge badge-light badge-pill">{{$count}}</span></h6> 
                    <div style="overflow-y: scroll; max-height: 270px;" class="notification-list">
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
                                @if($val->event == 'Specification Sheet QC' || $val->event == 'Specification Sheet Update' || $val->event == 'Specification Sheet' || $val->event == 'Specification Sheet Approved' || $val->event == 'Specification Sheet Rejected' || $val->event == 'Specification Sheet Transferred' || $val->event == 'Specification Sheet Production' || $val->event == 'Specification Sheet Finalized')
                                    <a href="{{$val->url}}?id={{$val->complaint}}" onclick="myFunction('{{ $val->id }}');" class="dropdown-item py-3" id="notification">
                                @elseif($val->event == 'Pricing Sheet QC' || $val->event == 'Pricing Sheet Update' || $val->event == 'Pricing Sheet' || $val->event == 'Pricing Sheet Approved' || $val->event == 'Pricing Sheet Rejected' || $val->event == 'Pricing Sheet Transferred' || $val->event == 'Pricing Sheet Production' || $val->event == 'Pricing Sheet Finalized')
                                    <a href="{{$val->url}}?id={{$val->complaint}}" onclick="myFunction('{{ $val->id }}');" class="dropdown-item py-3" id="notification">  
                                @else
                                    <a href="{{$val->url}}?id={{$val->complaint}}&userid={{$val->userid}}" onclick="myFunction('{{ $val->id }}');" class="dropdown-item py-3" id="notification">  
                                @endif                                  
                                    <?php
                                        date_default_timezone_set("Asia/karachi");
                                        $time = date("h:i A");
                                        $datetime2 = new DateTime($time);
                                        $month = $val->created_at;
                                        $delimiter = ' ';
                                        $words = explode($delimiter, $month);
                                        $datetime3 = new DateTime($val->created_at);
                                        $interval = $datetime2->diff($datetime3);
                                        $diff = $interval->format('%d day %h hr %i min');
                                        if($diff[0] == 0){
                                            $diff = $interval->format('%h hr %i min');
                                        }
                                        elseif($diff[0] == 1){
                                            $diff = $interval->format('%d day');
                                        }
                                        else{
                                            $diff = $interval->format('%d days');
                                        }
                                    ?>
                                    <small class="float-right pl-2" style="font-size: 75%;">{{$diff}} ago</small>
                                    <div class="media">
                                        @if($val->event == 'Complaint Closed')
                                            <img style="margin-left: -6px;" src="img/avatars/yesbg3.png" alt="user" class="thumb-sm">
                                        @elseif($val->event == 'Specification Sheet QC')
                                            <img style="margin-left: -6px;" src="img/avatars/yesbg3.png" alt="user" class="thumb-sm">
                                        @elseif($val->event == 'Specification Sheet Update')
                                            <img style="margin-left: -6px;" src="img/avatars/yesbg3.png" alt="user" class="thumb-sm">
                                        @elseif($val->event == 'Specification Sheet Transferred')
                                            <img style="margin-left: -6px;" src="img/avatars/yesbg3.png" alt="user" class="thumb-sm">
                                        @elseif($val->event == 'Specification Sheet Rejected')
                                            <img style="margin-left: -6px;" src="img/avatars/crossbg3.png" alt="user" class="thumb-sm">
                                        @elseif($val->event == 'Specification Sheet Production')
                                            <img style="margin-left: -6px;" src="img/avatars/yesbg3.png" alt="user" class="thumb-sm">
                                        @elseif($val->event == 'Specification Sheet Finalized')
                                            <img style="margin-left: -6px;" src="img/avatars/yesbg3.png" alt="user" class="thumb-sm">
                                        @elseif($val->event == 'Pricing Sheet QC')
                                            <img style="margin-left: -6px;" src="img/avatars/yesbg3.png" alt="user" class="thumb-sm">
                                        @elseif($val->event == 'Pricing Sheet Update')
                                            <img style="margin-left: -6px;" src="img/avatars/yesbg3.png" alt="user" class="thumb-sm">
                                        @elseif($val->event == 'Pricing Sheet Transferred')
                                            <img style="margin-left: -6px;" src="img/avatars/yesbg3.png" alt="user" class="thumb-sm">
                                        @elseif($val->event == 'Pricing Sheet Rejected')
                                            <img style="margin-left: -6px;" src="img/avatars/crossbg3.png" alt="user" class="thumb-sm">
                                        @elseif($val->event == 'Pricing Sheet Production')
                                            <img style="margin-left: -6px;" src="img/avatars/crossbg3.png" alt="user" class="thumb-sm">
                                        @elseif($val->event == 'Complaint Rejected')
                                            <img style="margin-left: -6px;" src="img/avatars/crossbg3.png" alt="user" class="thumb-sm">
                                        @elseif($val->event == 'Complaint Completed')
                                            <img style="margin-left: -6px;" src="img/avatars/yesbg3.png" alt="user" class="thumb-sm">
                                        @elseif($val->event == 'Complaint In Process')
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
                                                <h6 style="font-family: system-ui; text-transform: capitalize;" class="my-0 font-weight-normal text-dark">{{$val->event}}</h6>
                                                @else
                                                <h6 style="font-family: system-ui; text-transform: capitalize;" class="my-0 font-weight-normal text-dark">{{$val->event}}<small class="float-left"><i style="font-size: xx-small;" class="mdi mdi-circle-slice-8 mr-1 text-danger"></i></small> </h6>
                                                @endif
                                            @if($val->event == 'Complaint Closed')
                                            <small style="font-family: system-ui;" class=" mb-0">By <span style="font-weight: 600; font-family: system-ui; letter-spacing: 0.3px;"> {{$val->name}}</span></small>
                                            @elseif($val->event == 'Complaint In Process')
                                            <small style="font-family: system-ui;" class=" mb-0">By <span style="font-weight: 600; font-family: system-ui; letter-spacing: 0.3px;"> {{$val->name}}</span></small>
                                            @elseif($val->event == 'Complaint Completed')
                                            <small style="font-family: system-ui;" class=" mb-0">By <span style="font-weight: 600; font-family: system-ui; letter-spacing: 0.3px;"> {{$val->name}}</span></small>
                                            @elseif($val->event == 'Complaint Rejected')
                                            <small style="font-family: system-ui;" class=" mb-0">By <span style="font-weight: 600; font-family: system-ui; letter-spacing: 0.3px;"> {{$val->name}}</span></small>
                                            @else
                                            <small style="font-family: system-ui;" class=" mb-0">From <span style="font-weight: 600; font-family: system-ui; letter-spacing: 0.3px;"> {{$val->name}}</span></small>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                                <span hidden data-toggle="tooltip" data-placement="top" title="&nbsp; Mark as Read &nbsp;" onclick="myFunction('{{ $val->id }}');" class="py-3" style="font-size: x-large; cursor: pointer;"><i class="mdi mdi-progress-check"></i></span>
                            </span>                       
                        @endforeach
                    </div>
                    <span class="d-flex">
                        <a href="all-activity?id={{$id}}" class="dropdown-item text-center text-primary">View all <i class="fi-arrow-right"></i></a>
                        <a onclick="myFunction111();" style="cursor: pointer;" class="dropdown-item text-center text-primary">Mark all read <i class="fi-arrow-right"></i></a>
                    </span>
                </div>
            </li>
            <li class="dropdown">
                <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    @if(isset($image) && !empty($image)) 
                    <img src="{{ asset('uploads/appsetting/' . $image) }}" alt="profile-user" class="rounded-circle" /> 
                    @else
                    <img src="img/avatars/avatar-2.jpg" alt="profile-user" class="rounded-circle" /> 
                    @endif                    
                    <span class="ml-1 nav-user-name hidden-sm">{{ Auth::user()->emp_name }} <i class="mdi mdi-chevron-down"></i></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    @guest
                        @if(Route::has('login'))
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        @endif
                        @if(Route::has('register'))
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif
					@else
                    @endguest
                    <a class="dropdown-item" href="{{route('user-profile')}}"><i class="fas fa-user-cog text-muted mr-2"></i> Profile</a>
                    <a class="dropdown-item" href="{{url('user-password')}}"><i class="fas fa-unlock-alt text-muted mr-2"></i> Change Password</a>
                    <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal" href="#"><i class="fas fa-sign-out-alt text-muted mr-2"></i> {{ __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
            <ul class="list-unstyled topbar-nav mb-0">                        
                <li>
                    <button class="nav-link button-menu-mobile waves-effect waves-light">
                        <i class="ti-menu nav-icon"></i>
                    </button>
                </li>
            </ul>
        </nav>
    </div>
    <div class="left-sidenav">
         <ul class="metismenu left-sidenav-menu">
            <li class="{{ Request::path() == 'home' ? 'mm-active active' : '' }}">
                <a class="{{ Request::path() == 'home' ? 'active' : '' }}" href="{{url('home')}}"><i class="fas fa-chart-bar"></i><span>Dashboard</span><span class="menu-arrow"></span></a>
            </li>
            <li class="{{ Request::path() == 'get-attendance' ? 'mm-active active' : Request::path() == 'get-user-attendance' ? 'mm-active active' : '' }}">
                <a href="javascript: void(0);" class="{{ Request::path() == 'get-attendance' ? 'active' : Request::path() == 'get-user-attendance' ? 'active' : '' }}"><i class="far fa-copy"></i><span>Attendance</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    @if(isset($storeData['Attendance']) && !empty($storeData['Attendance'] || $departmentuser == 'Human Resources'))
                        @if(isset($storeData['Attendance']) == 1 || $departmentuser == 'Human Resources')
                        <li class="{{ Request::path() == 'get-attendance' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'get-attendance' ? 'nav-link active' : 'nav-link' }}" href="{{url('UserAttendance')}}"><i class="ti-control-record"></i>View Attendance</a></li>
                        @endif
                    @else
                    <li class="{{ Request::path() == 'get-user-attendance' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'get-user-attendance' ? 'nav-link active' : 'nav-link' }}" href="{{url('user-attendance')}}"><i class="ti-control-record"></i>Attendance</a></li>
                    <li hidden class="{{ Request::path() == 'get-user-attendance' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'get-user-attendance' ? 'nav-link active' : 'nav-link' }}" href="{{url('dep-attendance')}}"><i class="ti-control-record"></i>Department</a></li>  
                    @endif
                </ul>
            </li>
            @if(isset($storeData['User-List']) && !empty($storeData['User-List'])) 
                @if(isset($storeData['User-List']) == 1)
                <li>
                    <a href="javascript: void(0);"><i class="ti-settings"></i><span>Users</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li class="nav-item"><a class="nav-link" href="{{url('user-manage')}}"><i class="ti-control-record"></i>Manage User</a></li> 
                        @if(isset($storeData['User-Create']) && !empty($storeData['User-Create'])) 
                            @if(isset($storeData['User-Create']) == 1)                            
                                <li class="nav-item"><a class="nav-link" href="{{url('users-create')}}"><i class="ti-control-record"></i>Create User</a></li>
                            @endif
                        @endif                              
                    </ul>
                </li>
                @endif
            @endif         
            @if(isset($storeData['Objective-List']) && !empty($storeData['Objective-List'])) 
                @if(isset($storeData['Objective-List']) == 1)
                <li class="{{ Request::path() == 'obj-department' ? 'mm-active active' : Request::path() == 'obj-department-1' ? 'mm-active active' : Request::path() == 'show-obj' ? 'mm-active active' : Request::path() == 'objective-create' ? 'mm-active active' : '' }}">
                    <a href="javascript: void(0);" class="{{ Request::path() == 'obj-department' ? 'active' : Request::path() == 'obj-department-1' ? 'active' : Request::path() == 'show-obj' ? 'active' : Request::path() == 'objective-create' ? 'active' : '' }}"><i class="far fa-object-ungroup"></i><span>Objectives</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li class="{{ Request::path() == 'obj-department-1' ? 'nav-item active' : Request::path() == 'objective-create' ? 'nav-item active' : Request::path() == 'show-obj' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'obj-department-1' ? 'nav-link active' : Request::path() == 'objective-create' ? 'nav-link active' : Request::path() == 'show-obj' ? 'nav-link active' : 'nav-link' }}" href="{{url('objective-manage-new')}}"><i class="ti-control-record"></i>Manage Users</a></li>
                        @if(isset($storeData['Objective-Create']) && !empty($storeData['Objective-Create'])) 
                            @if(isset($storeData['Objective-Create']) == 1)
                                <li class="nav-item"><a class="nav-link" href="{{url('create-user-obj')}}"><i class="ti-control-record"></i>Create User</a></li>  
                            @endif
                        @endif
                        <li class="{{ Request::path() == 'obj-department' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'obj-department' ? 'nav-link active' : 'nav-link' }}" href="{{url('all-objective')}}"><i class="ti-control-record"></i>All Objectives</a></li>
                    </ul>
                </li>                      
                @endif
            @else
                <li class="{{ Request::path() == 'obj-department' ? 'mm-active active' : Request::path() == 'obj-department-1' ? 'mm-active active' : Request::path() == 'show-obj' ? 'mm-active active' : Request::path() == 'objective-create' ? 'mm-active active' : '' }}">
                    <a href="javascript: void(0);" class="{{ Request::path() == 'obj-department' ? 'active' : Request::path() == 'obj-department-1' ? 'active' : Request::path() == 'show-obj' ? 'active' : Request::path() == 'objective-create' ? 'active' : '' }}"><i class="far fa-object-ungroup"></i><span>Objectives</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li class="{{ Request::path() == 'obj-department-1' ? 'nav-item active' : Request::path() == 'objective-create' ? 'nav-item active' : Request::path() == 'show-obj' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'obj-department-1' ? 'nav-link active' : Request::path() == 'objective-create' ? 'nav-link active' : Request::path() == 'show-obj' ? 'nav-link active' : 'nav-link' }}" href="{{url('show-objective')}}"><i class="ti-control-record"></i>Show Objectives</a></li>
                    </ul>
                </li>
            @endif
            @if(isset($storeData['Material Consumption Rate']) && !empty($storeData['Material Consumption Rate']) || isset($storeData['Transfer Issue Rate']) && !empty($storeData['Transfer Issue Rate']) || isset($storeData['Transfer Ledger Rate']) && !empty($storeData['Transfer Ledger Rate']) || isset($storeData['RMA Report']) && !empty($storeData['RMA Report']) || isset($storeData['Sales Issue']) && !empty($storeData['Sales Issue']) || isset($storeData['Item Adjustment']) && !empty($storeData['Item Adjustment']) || isset($storeData['Help Desk Report']) && !empty($storeData['Help Desk Report']) || isset($storeData['Job Order Report']) && !empty($storeData['Job Order Report']) || isset($storeData['Job Order Journey']) && !empty($storeData['Job Order Journey']) || isset($storeData['Sales Order Report']) && !empty($storeData['Sales Order Report']) || isset($storeData['Transfer Issue Report']) && !empty($storeData['Transfer Issue Report']) || isset($storeData['Item Purchase Report']) && !empty($storeData['Item Purchase Report']) || isset($storeData['Purchase Rate History']) && !empty($storeData['Purchase Rate History']) || isset($storeData['M Transfer Against JO']) && !empty($storeData['M Transfer Against JO']) || isset($storeData['Material Consumption']) && !empty($storeData['Material Consumption']) || isset($storeData['Purchase Order Report']) && !empty($storeData['Purchase Order Report']) || isset($storeData['Consumption Expection']) && !empty($storeData['Consumption Expection']) || isset($storeData['Purchase Invoice Report']) && !empty($storeData['Purchase Invoice Report']) || isset($storeData['Work Order Item Costing']) && !empty($storeData['Work Order Item Costing']) || isset($storeData['Consumption Comparison']) && !empty($storeData['Consumption Comparison'])) 
                @if(isset($storeData['Material Consumption Rate']) == 1 || isset($storeData['Transfer Issue Rate']) == 1 || isset($storeData['Transfer Ledger Rate']) == 1 || isset($storeData['RMA Report']) == 1 || isset($storeData['Sales Issue']) == 1 || isset($storeData['Item Adjustment']) == 1 || isset($storeData['Help Desk Report']) == 1 || isset($storeData['Job Order Report']) == 1 || isset($storeData['Job Order Journey']) == 1 || isset($storeData['Sales Order Report']) == 1 || isset($storeData['Transfer Issue Report']) == 1 || isset($storeData['Item Purchase Report']) == 1 || isset($storeData['Purchase Rate History']) == 1 || isset($storeData['M Transfer Against JO']) == 1 || isset($storeData['Material Consumption']) == 1 || isset($storeData['Purchase Order Report']) == 1|| isset($storeData['Consumption Expection']) == 1|| isset($storeData['Purchase Invoice Report']) == 1|| isset($storeData['Work Order Item Costing']) == 1|| isset($storeData['Consumption Comparison']) == 1)
                <li class="{{ Request::path() == 'transferagainstall-report' ? 'active' : Request::path() == 'transfer-ledger-report' ? 'active' : Request::path() == 'comparison-report' ? 'mm-active active' : Request::path() == 'item-purchase-report' ? 'mm-active active' : Request::path() == 'joborder-report' ? 'mm-active active' : Request::path() == 'purchase-invoice-report' ? 'mm-active active' : Request::path() == 'consumption-comparison' ? 'mm-active active' : Request::path() == 'consumption-report' ? 'mm-active active' : Request::path() == 'rma-report' ? 'mm-active active' : Request::path() == 'transferagainst-report' ? 'mm-active active' : Request::path() == 'joborder-journey' ? 'mm-active active' : Request::path() == 'purchase-order-report' ? 'mm-active active' : Request::path() == 'sales-order-report' ? 'mm-active active' : Request::path() == 'sales-report' ? 'mm-active active' : Request::path() == 'purchase-report' ? 'mm-active active' : Request::path() == 'transfer-report' ? 'mm-active active' : Request::path() == 'helpdesk-report' ? 'mm-active active' : Request::path() == 'adjustment-report' ? 'mm-active active' : Request::path() == 'material-report' ? 'mm-active active' : Request::path() == 'workorder-report' ? 'mm-active active' : '' }}">
                    <a href="javascript: void(0);" class="{{ Request::path() == 'transferagainstall-report' ? 'active' : Request::path() == 'transfer-ledger-report' ? 'active' : Request::path() == 'comparison-report' ? 'active' : Request::path() == 'item-purchase-report' ? 'active' : Request::path() == 'joborder-report' ? 'active' : Request::path() == 'purchase-invoice-report' ? 'active' : Request::path() == 'consumption-comparison' ? 'active' : Request::path() == 'consumption-report' ? 'active' : Request::path() == 'rma-report' ? 'active' : Request::path() == 'transferagainst-report' ? 'active' : Request::path() == 'joborder-journey' ? 'active' : Request::path() == 'purchase-order-report' ? 'active' : Request::path() == 'sales-order-report' ? 'active' : Request::path() == 'sales-report' ? 'active' : Request::path() == 'purchase-report' ? 'active' : Request::path() == 'adjustment-report' ? 'active' : Request::path() == 'transfer-report' ? 'active' : Request::path() == 'helpdesk-report' ? 'active' : Request::path() == 'workorder-report' ? 'active' : '' }}"><i class="ti-layers-alt"></i><span>Reports</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="nav-second-level p-0" aria-expanded="false">
                        @if(isset($storeData['RMA Report']) && !empty($storeData['RMA Report'])) 
                            @if(isset($storeData['RMA Report']) == 1)
                                <li class="{{ Request::path() == 'rma-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'rma-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('rma')}}"><i class="ti-control-record" style="width: 18px;"></i>RMA Report</a></li>
                            @endif
                        @endif
                        @if(isset($storeData['Sales Issue']) && !empty($storeData['Sales Issue'])) 
                            @if(isset($storeData['Sales Issue']) == 1)
                                <li class="{{ Request::path() == 'sales-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'sales-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('sales')}}"><i class="ti-control-record" style="width: 18px;"></i>Sales Issue</a></li>
                            @endif
                        @endif
                        @if(isset($storeData['Transfer Ledger Report']) && !empty($storeData['Transfer Ledger Report']) || isset($storeData['Transfer Ledger Rate']) && !empty($storeData['Transfer Ledger Rate'])) 
                            @if(isset($storeData['Transfer Ledger Report']) == 1 || isset($storeData['Transfer Ledger Rate']) == 1)
                                <li class="{{ Request::path() == 'transfer-ledger-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'transfer-ledger-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('transfer-ledger')}}"><i class="ti-control-record" style="width: 18px;"></i>Transfer Ledger</a></li>
                            @endif
                        @endif
                        @if(isset($storeData['Item Adjustment']) && !empty($storeData['Item Adjustment'])) 
                            @if(isset($storeData['Item Adjustment']) == 1)
                                <li class="{{ Request::path() == 'sales-report' ? 'nav-item active' : 'adjustment-item' }}"><a class="{{ Request::path() == 'adjustment-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('adjustment')}}"><i class="ti-control-record" style="width: 18px;"></i>Item Adjustment</a></li>
                            @endif
                        @endif
                        @if(isset($storeData['Help Desk Report']) && !empty($storeData['Help Desk Report'])) 
                            @if(isset($storeData['Help Desk Report']) == 1)
                                <li class="{{ Request::path() == 'helpdesk-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'helpdesk-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('helpdesk')}}"><i class="ti-control-record" style="width: 18px;"></i>Help Desk Report</a></li>
                            @endif
                        @endif
                        @if(isset($storeData['Job Order Report']) && !empty($storeData['Job Order Report'])) 
                            @if(isset($storeData['Job Order Report']) == 1)
                                <li class="{{ Request::path() == 'joborder-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'joborder-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('joborder')}}"><i class="ti-control-record" style="width: 18px;"></i>Job Order Report</a></li>
                            @endif
                        @endif
                        @if(isset($storeData['Job Order Journey']) && !empty($storeData['Job Order Journey'])) 
                            @if(isset($storeData['Job Order Journey']) == 1)
                                <li class="{{ Request::path() == 'joborder-journey' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'joborder-journey' ? 'nav-link active' : 'nav-link' }}" href="{{url('joborderjourney')}}"><i class="ti-control-record" style="width: 18px;"></i>Job Order Journey</a></li>                
                            @endif
                        @endif
                        @if(isset($storeData['Sales Order Report']) && !empty($storeData['Sales Order Report'])) 
                            @if(isset($storeData['Sales Order Report']) == 1)
                                <li class="{{ Request::path() == 'sales-order-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'sales-order-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('sales-order')}}"><i class="ti-control-record" style="width: 18px;"></i>Sales Order Report</a></li>
                            @endif
                        @endif
                        @if(isset($storeData['M Transfer Against JO']) && !empty($storeData['M Transfer Against JO'])) 
                            @if(isset($storeData['M Transfer Against JO']) == 1)
                                <li class="{{ Request::path() == 'transferagainst-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'transferagainst-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('transferagainst')}}"><i class="ti-control-record" style="width: 18px;"></i>Transfer Against JO</a></li>
                            @endif
                        @endif
                        @if(isset($storeData['Transfer Issue Report']) && !empty($storeData['Transfer Issue Report']) || isset($storeData['Transfer Issue Rate']) && !empty($storeData['Transfer Issue Rate'])) 
                            @if(isset($storeData['Transfer Issue Report']) == 1 || isset($storeData['Transfer Issue Rate']) == 1)
                                <li class="{{ Request::path() == 'transfer-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'transfer-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('transfer')}}"><i class="ti-control-record" style="width: 18px;"></i>Transfer Issue Report</a></li>
                            @endif
                        @endif
                        @if(isset($storeData['Item Purchase Report']) && !empty($storeData['Item Purchase Report'])) 
                            @if(isset($storeData['Item Purchase Report']) == 1)
                                <li class="{{ Request::path() == 'item-purchase-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'item-purchase-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('item-purchase')}}"><i class="ti-control-record" style="width: 18px;"></i>Item Purchase Report</a></li>
                            @endif
                        @endif
                        @if(isset($storeData['Purchase Rate History']) && !empty($storeData['Purchase Rate History'])) 
                            @if(isset($storeData['Purchase Rate History']) == 1)
                                <li class="{{ Request::path() == 'purchase-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'purchase-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('purchase')}}"><i class="ti-control-record" style="width: 18px;"></i>Purchase Rate History</a></li>
                            @endif
                        @endif
                        @if(isset($storeData['Material Consumption']) && !empty($storeData['Material Consumption']) || isset($storeData['Material Consumption Rate']) && !empty($storeData['Material Consumption Rate'])) 
                            @if(isset($storeData['Material Consumption']) == 1 || isset($storeData['Material Consumption Rate']) == 1)
                                <li class="{{ Request::path() == 'material-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'material-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('material')}}"><i class="ti-control-record" style="width: 18px;"></i>Material Consumption</a></li>
                            @endif
                        @endif
                        @if(isset($storeData['M Transfer Against All JO']) && !empty($storeData['M Transfer Against All JO'])) 
                            @if(isset($storeData['M Transfer Against All JO']) == 1)
                                <li class="{{ Request::path() == 'transferagainstall-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'transferagainstall-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('transferagainstall')}}"><i class="ti-control-record" style="width: 18px;"></i>Transfer Against All JO</a></li>
                            @endif
                        @endif
                        @if(isset($storeData['Purchase Order Report']) && !empty($storeData['Purchase Order Report'])) 
                            @if(isset($storeData['Purchase Order Report']) == 1)
                                <li class="{{ Request::path() == 'purchase-order-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'purchase-order-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('purchase-order')}}"><i class="ti-control-record" style="width: 18px;"></i>Purchase Order Report</a></li>
                            @endif
                        @endif
                        @if(isset($storeData['Consumption Expection']) && !empty($storeData['Consumption Expection'])) 
                            @if(isset($storeData['Consumption Expection']) == 1)
                                <li class="{{ Request::path() == 'consumption-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'consumption-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('consumption')}}"><i class="ti-control-record" style="width: 18px;"></i>Consumption Expection</a></li>                
                            @endif
                        @endif
                        @if(isset($storeData['Purchase Invoice Report']) && !empty($storeData['Purchase Invoice Report'])) 
                            @if(isset($storeData['Purchase Invoice Report']) == 1)
                                <li class="{{ Request::path() == 'purchase-invoice-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'purchase-invoice-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('purchase-invoice')}}"><i class="ti-control-record" style="width: 18px;"></i>Purchase Invoice Report</a></li>
                            @endif
                        @endif
                        @if(isset($storeData['Work Order Item Costing']) && !empty($storeData['Work Order Item Costing'])) 
                            @if(isset($storeData['Work Order Item Costing']) == 1)
                                <li class="{{ Request::path() == 'workorder-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'workorder-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('workorder')}}"><i class="ti-control-record" style="width: 18px;"></i>Work Order Item Costing</a></li>
                            @endif
                        @endif
                        @if(isset($storeData['Consumption Comparison']) && !empty($storeData['Consumption Comparison'])) 
                            @if(isset($storeData['Consumption Comparison']) == 1)
                                <li class="{{ Request::path() == 'comparison-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'comparison-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('comparison')}}"><i class="ti-control-record" style="width: 18px;"></i>Consumption Comparison</a></li>
                            @endif
                        @endif
                    </ul>
                </li>
                @endif
            @endif
            @if(isset($storeData['Pricing-Sheet Production']) && !empty($storeData['Pricing-Sheet Production']) || isset($storeData['Job-Order Create']) && !empty($storeData['Job-Order Create']) || isset($storeData['Job-Order List']) && !empty($storeData['Job-Order List']) || isset($storeData['Quality-Control']) && !empty($storeData['Quality-Control']) || isset($storeData['Production-Planning-Control']) && !empty($storeData['Production-Planning-Control']) || isset($storeData['Pricing-Sheet List']) && !empty($storeData['Pricing-Sheet List']) || isset($storeData['Pricing-Sheet Costing']) && !empty($storeData['Pricing-Sheet Costing']) || isset($storeData['Pricing-Sheet Sales']) && !empty($storeData['Pricing-Sheet Sales'])) 
                @if(isset($storeData['Pricing-Sheet Production']) == 1 || isset($storeData['Job-Order Create']) == 1 || isset($storeData['Job-Order List']) == 1 || isset($storeData['Quality-Control']) == 1 || isset($storeData['Production-Planning-Control']) == 1 || isset($storeData['Pricing-Sheet List']) == 1 || isset($storeData['Pricing-Sheet Costing']) == 1 || isset($storeData['Pricing-Sheet Sales']) == 1)
                <li class="{{ Request::path() == 'pricing-sheet-update-costing' ? 'mm-active active' : Request::path() == 'specification-sheet-view' ? 'mm-active active' : Request::path() == 'specification-sheet-edit' ? 'mm-active active' : Request::path() == 'pricing-sheet-edit' ? 'mm-active active' : Request::path() == 'obj-department' ? 'mm-active active' : '' }}">
                    <a href="javascript: void(0);" class="{{ Request::path() == 'pricing-sheet-update-costing' ? 'active' :  Request::path() == 'specification-sheet-view' ? 'active' : Request::path() == 'specification-sheet-edit' ? 'active' : Request::path() == 'pricing-sheet-edit' ? 'active' : Request::path() == 'obj-department' ? 'active' : '' }}"><i class="fas fa-project-diagram"></i><span>PDL</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="nav-second-level p-0" aria-expanded="false">
                        @if(isset($storeData['PDL Master Data']) && !empty($storeData['PDL Master Data'])) 
                            @if(isset($storeData['PDL Master Data']) == 1)
                                <li class="nav-item"><a class="nav-link"  href="{{url('master-data-plc')}}"><i class="ti-control-record"></i>Master Data</a></li>
                            @endif
                        @endif
                        @if(isset($storeData['Job-Order Create']) && !empty($storeData['Job-Order Create']) || isset($storeData['Job-Order List']) && !empty($storeData['Job-Order List'])) 
                            @if(isset($storeData['Job-Order Create']) == 1 || isset($storeData['Job-Order List']) == 1)
                            <li class="{{ Request::path() == 'create-job-order' ? 'mm-active active' : '' }}">
                                <a href="javascript: void(0);" class="{{ Request::path() == 'create-job-order' ? 'active' : ''}}"><i class="ti-control-record"></i>Job Order <span class="menu-arrow left-has-menu"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    @if(isset($storeData['Job-Order Create']) && !empty($storeData['Job-Order Create'])) 
                                        @if(isset($storeData['Job-Order Create']) == 1)
                                            <li hidden class="nav-item"><a class="nav-link" href="{{url('job-order')}}"><i class="ti-control-record"></i>Create</a></li> 
                                        @endif
                                    @endif
                                    <li class="{{ Request::path() == 'create-job-order' ? 'nav-item active' : Request::path() == 'job-order-edit' ? 'nav-item active' : Request::path() == 'job-order-view' ? 'nav-item active' : 'nav-item' }}"><a class="{{  Request::path() == 'create-job-order' ? 'nav-link active' : Request::path() == 'job-order-edit' ? 'nav-link active' : Request::path() == 'job-order-view' ? 'nav-link active' : 'nav-link' }}" href="{{url('job-order-table')}}"><i class="ti-control-record"></i>Dashboard</a></li>
                                </ul>
                            </li>
                            @endif
                        @endif
                        @if(isset($storeData['Pricing-Sheet Sales']) && !empty($storeData['Pricing-Sheet Sales']) || isset($storeData['Pricing-Sheet List']) && !empty($storeData['Pricing-Sheet List']) || isset($storeData['Pricing-Sheet Costing']) && !empty($storeData['Pricing-Sheet Costing'])) 
                            @if(isset($storeData['Pricing-Sheet Sales']) == 1 || isset($storeData['Pricing-Sheet List']) == 1 || isset($storeData['Pricing-Sheet Costing']) == 1)
                            <li class="{{ Request::path() == 'pricing-sheet-update-costing' ? 'mm-active active' : '' }}">
                                <a href="javascript: void(0);" class="{{ Request::path() == 'pricing-sheet-update-costing' ? 'active' : ''}}"><i class="ti-control-record"></i>Pricing Sheet <span class="menu-arrow left-has-menu"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    @if(isset($storeData['Pricing-Sheet Create']) && !empty($storeData['Pricing-Sheet Create'])) 
                                        @if(isset($storeData['Pricing-Sheet Create']) == 1)
                                            <li class="nav-item"><a class="nav-link" href="{{url('pricing-sheet')}}"><i class="ti-control-record"></i>Create</a></li> 
                                        @endif
                                    @endif
                                    <li class="{{ Request::path() == 'pricing-sheet-update-costing' ? 'nav-item active' : Request::path() == 'pricing-sheet-edit' ? 'nav-item active' : Request::path() == 'pricing-sheet-view' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'pricing-sheet-update-costing' ? 'nav-link active' : Request::path() == 'pricing-sheet-edit' ? 'nav-link active' : Request::path() == 'pricing-sheet-view' ? 'nav-link active' : 'nav-link' }}" href="{{url('pricing-sheet-table')}}"><i class="ti-control-record"></i>Dashboard</a></li>
                                </ul>
                            </li>
                            @endif
                        @endif
                        @if(isset($storeData['Pricing-Sheet Costing']) && !empty($storeData['Pricing-Sheet Costing']) || isset($storeData['Job-Order Create']) && !empty($storeData['Job-Order Create'])) 
                            @if(isset($storeData['Pricing-Sheet Costing']) == 1 || isset($storeData['Job-Order Create']) == 1)
                            <li hidden class="{{ Request::path() == 'pricing-sheet-view' ? 'mm-active active' : '' }}">
                                <a href="javascript: void(0);" class="{{ Request::path() == 'pricing-sheet-view' ? 'active' : ''}}"><i class="ti-control-record"></i>Pricing Sheet <span class="menu-arrow left-has-menu"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    @if(isset($storeData['Pricing-Sheet Create']) && !empty($storeData['Pricing-Sheet Create'])) 
                                        @if(isset($storeData['Pricing-Sheet Create']) == 1)
                                            <li class="nav-item"><a class="nav-link" href="{{url('pricing-sheet')}}"><i class="ti-control-record"></i>Create</a></li> 
                                        @endif
                                    @endif
                                    <li class="{{ Request::path() == 'pricing-sheet-view' ? 'nav-item active' : Request::path() == 'pricing-sheet-edit' ? 'nav-item active' : Request::path() == 'pricing-sheet-view' ? 'nav-item active' : 'nav-item' }}"><a class="{{  Request::path() == 'pricing-sheet-edit' ? 'nav-link active' : Request::path() == 'pricing-sheet-view' ? 'nav-link active' : 'nav-link' }}" href="{{url('pricing-sheet-table')}}"><i class="ti-control-record"></i>Dashboard</a></li>
                                </ul>
                            </li> 
                            @endif
                        @endif
                        @if(isset($storeData['Formula-Sheet Create']) && !empty($storeData['Formula-Sheet Create']) || isset($storeData['Formula-Sheet List']) && !empty($storeData['Formula-Sheet List'])) 
                            @if(isset($storeData['Formula-Sheet Create']) == 1 || isset($storeData['Formula-Sheet List']) == 1)
                            <li class="{{ Request::path() == 'formula-sheet-edit' ? 'mm-active active' : Request::path() == 'formula-sheet-view' ? 'mm-active active' : '' }}">
                                <a href="javascript: void(0);" class="{{ Request::path() == 'formula-sheet-edit' ? 'active' : Request::path() == 'formula-sheet-view' ? 'active' : ''}}"><i class="ti-control-record"></i>OH Formula Sheet <span class="menu-arrow left-has-menu"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    @if(isset($storeData['Formula-Sheet Create']) && !empty($storeData['Formula-Sheet Create'])) 
                                        @if(isset($storeData['Formula-Sheet Create']) == 1)
                                            <li class="{{ Request::path() == 'formula-sheet' ? 'nav-item active' : Request::path() == 'formula-sheet' ? 'nav-item active' : Request::path() == 'formula-sheet' ? 'nav-item active' : 'nav-item' }}"><a class="{{  Request::path() == 'formula-sheet' ? 'nav-link active' : Request::path() == 'formula-sheet' ? 'nav-link active' : 'nav-link' }}" href="{{url('formula-sheet')}}"><i class="ti-control-record"></i>Create</a></li>
                                        @endif
                                    @endif
                                    <li class="{{ Request::path() == 'formula-sheet-view' ? 'nav-item active' : Request::path() == 'formula-sheet-edit' ? 'nav-item active' : Request::path() == 'formula-sheet-view' ? 'nav-item active' : 'nav-item' }}"><a class="{{  Request::path() == 'formula-sheet-edit' ? 'nav-link active' : Request::path() == 'formula-sheet-view' ? 'nav-link active' : 'nav-link' }}" href="{{url('formula-sheet-table')}}"><i class="ti-control-record"></i>Dashboard</a></li>
                                </ul>
                            </li> 
                            @endif
                        @endif
                        @if(isset($storeData['Specification-Sheet List']) && !empty($storeData['Specification-Sheet List']) || isset($storeData['Specification-Sheet Costing']) && !empty($storeData['Specification-Sheet Costing'])) 
                            @if(isset($storeData['Specification-Sheet List']) == 1 || isset($storeData['Specification-Sheet Costing']) == 1)
                            <li class="{{ Request::path() == 'specification-sheet-view' ? 'mm-active active' : Request::path() == 'specification-sheet-create-costing' ? 'mm-active active' : '' }}">
                                <a href="javascript: void(0);" class="{{ Request::path() == 'specification-sheet-view' ? 'active' : ''}}"><i class="ti-control-record"></i>Specification Sheet <span class="menu-arrow left-has-menu"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    @if(isset($storeData['Pricing-Sheet Create']) && !empty($storeData['Pricing-Sheet Create'])) 
                                        @if(isset($storeData['Pricing-Sheet Create']) == 1)
                                            <li hidden class="nav-item"><a class="nav-link" href="{{url('specification-sheet')}}"><i class="ti-control-record"></i>Create</a></li> 
                                        @endif
                                    @endif
                                    <li class="{{ Request::path() == 'specification-sheet-view' ? 'nav-item active' : Request::path() == 'specification-sheet-edit' ? 'nav-item active' : Request::path() == 'specification-sheet-create-costing' ? 'nav-item active' : Request::path() == 'specification-sheet-view' ? 'nav-item active' : 'nav-item' }}"><a class="{{  Request::path() == 'specification-sheet-edit' ? 'nav-link active' : Request::path() == 'specification-sheet-view' ? 'nav-link active' : Request::path() == 'specification-sheet-create-costing' ? 'nav-link active' : 'nav-link' }}" href="{{url('specification-sheet-table')}}"><i class="ti-control-record"></i>Dashboard</a></li>
                                </ul>
                            </li>  
                            @endif
                        @endif
                    </ul>
                </li>                      
                @endif
            @endif
            <li>
                <a href="javascript: void(0);"><i class="fas fa-user-cog"></i><span>Profile</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li class="nav-item"><a class="nav-link" href="{{route('user-profile')}}"><i class="ti-control-record"></i>Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('user-password')}}"><i class="ti-control-record"></i>Change Password</a></li>
                </ul>
            </li>
            <li class="{{ Request::path() == 'complaints-view-user' ? 'mm-active active' : Request::path() == 'complaints-edit-user' ? 'mm-active active' : Request::path() == 'complaints-view' ? 'mm-active active' : '' }}">
                <a href="javascript: void(0);" class="{{ Request::path() == 'complaints-view-user' ? 'active' : Request::path() == 'complaints-edit-user' ? 'active' : Request::path() == 'complaints-view' ? 'active' : '' }}"><i class="fas fa-desktop"></i><span>Help Desk</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level p-0" aria-expanded="false">
                    @if(isset($storeData['Complaint']) && !empty($storeData['Complaint'])) 
                        @if(isset($storeData['Complaint']) == 1)
                            <li class="{{ Request::path() == 'complaints-view' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'complaints-view' ? 'nav-link active' : 'nav-link' }}" href="{{url('manage-complaints')}}"><i class="ti-control-record"></i>Manage Complaints</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{url('master-settings')}}"><i class="ti-control-record"></i>Master Settings</a></li>   
                        @endif
                    @else
                    <li class="{{ Request::path() == 'complaints-view-user' ? 'nav-item active' : Request::path() == 'complaints-edit-user' ? 'nav-item active' : Request::path() == 'complaints-view' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'complaints-view-user' ? 'nav-link active' : Request::path() == 'complaints-view' ? 'nav-link active' :  Request::path() == 'complaints-edit-user' ? 'nav-link active' : 'nav-link' }}" href="{{url('manage-complaints-user')}}"><i class="ti-control-record"></i>Manage Complaints</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('new-support-case')}}"><i class="ti-control-record"></i>Submit Complaint</a></li>   
                    @endif                           
                </ul>
            </li>      
        </ul>
    </div>
    <div class="page-wrapper">
        @yield('content')
        <footer class="footer text-center text-sm-left" style="border-top: none;">
            <div class="row">
                <div class="col-6">
                    <span class="float-right">
                    &copy; Powered by <b>Business Technology Team</b> 
                    </span>
                </div>
                <div class="col-6">
                    <span class="d-none d-sm-inline-block float-left" style="color: black;">Copyright © <span style="font-weight: 600;"> ONSOLE PVT Limited.</span> All rights reserved.</span>
                </div>
            </div>  
        </footer>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: transparent">
                    <h5>Logout?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Select "Logout" below if you are ready to end your current session.
                </div>
                <div class="modal-footer" style="background-color: transparent">
                    <button type="button" style="box-shadow: none;" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <a href="{{ route('logout') }}" 
                         onclick="event.preventDefault(); document.getElementById('logout-form').submit();" data-toggle="modal" data-target="#logoutModal">
                         <button type="button" style="box-shadow: none; background: #202020; border: none;" class="btn btn-danger mx-1 py-2 px-3">Logout</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/metismenu.min.js"></script>
<script src="assets/js/waves.js"></script>
<script src="assets/js/feather.min.js"></script>
<script src="assets/js/jquery.slimscroll.min.js"></script>
<script src="assets/js/jquery-ui.min.js"></script>
<script src="plugins/apexcharts/apexcharts.min.js"></script>
<script src="plugins/moment/moment.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-us-aea-en.js"></script>
<script src="assets/pages/jquery.analytics_dashboard.init.js"></script>
<script src="plugins/dropify/js/dropify.min.js"></script>
<script src="assets/pages/jquery.form-upload.init.js"></script>
<script src="assets/js/app.js"></script>

<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap4.min.js"></script>

<script src="plugins/datatables/dataTables.responsive.min.js"></script>
<script src="plugins/datatables/responsive.bootstrap4.min.js"></script>
<script src="assets/pages/jquery.datatable.init.js"></script>

<script src="plugins/datatables/dataTables.buttons.min.js"></script>
<script src="plugins/datatables/buttons.bootstrap4.min.js"></script>
<script src="plugins/datatables/jszip.min.js"></script>
<script src="plugins/datatables/pdfmake.min.js"></script>
<script src="plugins/datatables/vfs_fonts.js"></script>
<script src="plugins/datatables/buttons.html5.min.js"></script>
<script src="plugins/datatables/buttons.print.min.js"></script>
<script src="plugins/datatables/buttons.colVis.min.js"></script>

<script src="plugins/moment/moment.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<script src="plugins/select2/select2.min.js"></script>
<script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="plugins/timepicker/bootstrap-material-datetimepicker.js"></script>
<script src="assets/pages/jquery.forms-advanced.js"></script>
<script src="plugins/rating/jquery.barrating.min.js"></script>
<script src="assets/pages/jquery.rating.init.js"></script> 
<script src="plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js"></script>
<script src="plugins/tinymce/tinymce.min.js"></script>
<script src="assets/pages/jquery.form-editor.init.js"></script> 
<script src="assets/pages/jquery.projects_overview.init.js"></script>
<script>
function myFunction(id)
{
    $.ajax({
            type: 'GET',
            url: 'read_at/'+id,
            dataType: "json",
            success: function(data){
                // if(data == 1){
                //     Swal.fire({
                //         icon: 'success',
                //         title: 'Done',
                //         showConfirmButton: false,
                //     });
                //     location.reload();
                // }
                // else if(data == 400){
                //     Swal.fire({
                //         icon: 'error',
                //         title: 'Something went wrong!',
                //         showConfirmButton: false,
                //     });
                //     location.reload();
                // }
            }
        });
}
function myFunction111()
{
    $.ajax({
            type: 'GET',
            url: 'mark_all',
            dataType: "json",
            success: function(data){                
                if(data == 1){
                    Swal.fire({
                        icon: 'success',
                        title: 'Done',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    location.reload();
                }
                else if(data == 400){
                    Swal.fire({
                        icon: 'error',
                        title: 'Something went wrong!',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    location.reload();
                }
            }
        });
}
</script>     