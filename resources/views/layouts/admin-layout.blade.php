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
</style>
<?php
	$id = Auth::user()->id;
	$UserDetail = DB::table("users")->where("id", $id)->pluck('userrole');
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
    // print_r($storeData);
    $notification = DB::table("notification_details")->orderBy('id','DESC')->where('assign_users', Auth::user()->id)->where('read_at', NULL)->get();
    $count = count($notification);
?>
<body>
<div class="topbar">
    <div class="topbar-left">
        <a href="{{url('home')}}">
            <span>
                <img src="img/photos/preview.png" style="margin-top: -12px;" width="35%" alt="logo-large" class="logo-lg">
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
                            <span style="display: inline-flex;" class="w-100">
                                <a href="{{$val->url}}?id={{$val->complaint}}&userid={{$val->userid}}" class="dropdown-item py-3">
                                <small class="float-right pl-2">2 min ago</small>
                                    <div class="media">
                                        @if($val->event == 'Complaint Solved')
                                            <img style="margin-left: -6px;" src="img/avatars/tick.png" alt="user" class="rounded-circle thumb-sm">
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
                                            <h6 style="font-family: system-ui; text-transform: capitalize;" class="my-0 font-weight-normal text-dark">{{$val->event}}</h6>
                                            @if($val->event == 'Complaint Solved')
                                            <small style="font-family: system-ui;" class=" mb-0">By <span style="font-weight: 600; font-family: system-ui; letter-spacing: 0.3px;"> {{$val->name}}</span></small>
                                            @else
                                            <small style="font-family: system-ui;" class=" mb-0">From <span style="font-weight: 600; font-family: system-ui; letter-spacing: 0.3px;"> {{$val->name}}</span></small>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                                <span data-toggle="tooltip" data-placement="top" title="&nbsp; Mark as Read &nbsp;" onclick="myFunction('{{ $val->id }}');" class="py-3" style="font-size: x-large; cursor: pointer;"><i class="mdi mdi-progress-check"></i></span>
                            </span>
                        @endforeach
                    </div>
                    <a href="javascript:void(0);" class="dropdown-item text-center text-primary">View all <i class="fi-arrow-right"></i></a>
                </div>
            </li>
            <li class="dropdown">
                <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    @if(isset($image) && !empty($image)) 
                    <img src="{{ asset('uploads/appsetting/' . $image) }}" alt="profile-user" class="rounded-circle" /> 
                    @else
                    <img src="img/avatars/avatar-2.jpg" alt="profile-user" class="rounded-circle" /> 
                    @endif                    
                    <span class="ml-1 nav-user-name hidden-sm">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }} <i class="mdi mdi-chevron-down"></i></span>
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
                    <a class="dropdown-item" href="{{route('user-profile')}}"><i class="ti-user text-muted mr-2"></i> Profile</a>
                    <a class="dropdown-item" href="{{url('user-password')}}"><i class="ti-wallet text-muted mr-2"></i> Change Password</a>
                    <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal" href="#"><i class="ti-power-off text-muted mr-2"></i> {{ __('Logout') }}</a>
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
                <a class="{{ Request::path() == 'home' ? 'active' : '' }}" href="{{url('home')}}"><i class="ti-bar-chart"></i><span>Dashboard</span><span class="menu-arrow"></span></a>
            </li>
            <li class="{{ Request::path() == 'get-attendance' ? 'mm-active active' : '' }}">
                <a href="javascript: void(0);" class="{{ Request::path() == 'get-attendance' ? 'active' : '' }}"><i class="ti-agenda"></i><span>Attendance</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li class="{{ Request::path() == 'get-attendance' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'get-attendance' ? 'nav-link active' : 'nav-link' }}" href="{{url('UserAttendance')}}"><i class="ti-control-record"></i>View Attendance</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript: void(0);"><i class="ti-settings"></i><span>Master Settings</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li class="nav-item"><a class="nav-link"  href="{{url('master-data')}}"><i class="ti-control-record"></i>Master Data</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('user-manage')}}"><i class="ti-control-record"></i>Manage User</a></li>                          
                    <li class="nav-item"><a class="nav-link" href="{{url('users-create')}}"><i class="ti-control-record"></i>Create User</a></li>
                    <li hidden class="nav-item"><a class="nav-link" href="{{url('manage-books')}}"><i class="ti-control-record"></i>Set of Books</a></li>
                    <li hidden class="nav-item"><a class="nav-link" href="{{url('manage-books-2')}}"><i class="ti-control-record"></i>Set of Books 2</a></li>
                    <li hidden class="nav-item"><a class="nav-link" href="{{url('manage-books-3')}}"><i class="ti-control-record"></i>Set of Books 3</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript: void(0);"><i class="ti-target"></i><span>Roles</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li class="nav-item"><a class="nav-link" href="{{url('role-create')}}"><i class="ti-control-record"></i>Create Role</a></li>  
                    <li class="nav-item"><a class="nav-link" href="{{url('role-manage-new')}}"><i class="ti-control-record"></i>Manage Role</a></li>
                </ul>
            </li>
            <li class="{{ Request::path() == 'comparison-report' ? 'mm-active active' : Request::path() == 'item-purchase-report' ? 'mm-active active' : Request::path() == 'joborder-report' ? 'mm-active active' : Request::path() == 'purchase-invoice-report' ? 'mm-active active' : Request::path() == 'consumption-comparison' ? 'mm-active active' : Request::path() == 'consumption-report' ? 'mm-active active' : Request::path() == 'rma-report' ? 'mm-active active' : Request::path() == 'transferagainst-report' ? 'mm-active active' : Request::path() == 'joborder-journey' ? 'mm-active active' : Request::path() == 'purchase-order-report' ? 'mm-active active' : Request::path() == 'sales-order-report' ? 'mm-active active' : Request::path() == 'sales-report' ? 'mm-active active' : Request::path() == 'purchase-report' ? 'mm-active active' : Request::path() == 'transfer-report' ? 'mm-active active' : Request::path() == 'helpdesk-report' ? 'mm-active active' : Request::path() == 'adjustment-report' ? 'mm-active active' : Request::path() == 'material-report' ? 'mm-active active' : Request::path() == 'workorder-report' ? 'mm-active active' : '' }}">
                <a href="javascript: void(0);" class="{{ Request::path() == 'comparison-report' ? 'active' : Request::path() == 'item-purchase-report' ? 'active' : Request::path() == 'joborder-report' ? 'active' : Request::path() == 'purchase-invoice-report' ? 'active' : Request::path() == 'consumption-comparison' ? 'active' : Request::path() == 'consumption-report' ? 'active' : Request::path() == 'rma-report' ? 'active' : Request::path() == 'transferagainst-report' ? 'active' : Request::path() == 'joborder-journey' ? 'active' : Request::path() == 'purchase-order-report' ? 'active' : Request::path() == 'sales-order-report' ? 'active' : Request::path() == 'sales-report' ? 'active' : Request::path() == 'purchase-report' ? 'active' : Request::path() == 'adjustment-report' ? 'active' : Request::path() == 'transfer-report' ? 'active' : Request::path() == 'helpdesk-report' ? 'active' : Request::path() == 'workorder-report' ? 'active' : '' }}"><i class="ti-layers-alt"></i><span>Reports</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level p-0" aria-expanded="false">
                    <li class="{{ Request::path() == 'rma-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'rma-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('rma')}}"><i class="ti-control-record" style="width: 18px;"></i>RMA Report</a></li>
                    <li class="{{ Request::path() == 'sales-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'sales-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('sales')}}"><i class="ti-control-record" style="width: 18px;"></i>Sales Report</a></li>
                    <li class="{{ Request::path() == 'adjustment-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'adjustment-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('adjustment')}}"><i class="ti-control-record" style="width: 18px;"></i>Item Adjustment</a></li>
                    <li class="{{ Request::path() == 'helpdesk-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'helpdesk-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('helpdesk')}}"><i class="ti-control-record" style="width: 18px;"></i>Help Desk Report</a></li>
                    <li class="{{ Request::path() == 'joborder-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'joborder-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('joborder')}}"><i class="ti-control-record" style="width: 18px;"></i>Job Order Report</a></li>
                    <li class="{{ Request::path() == 'joborder-journey' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'joborder-journey' ? 'nav-link active' : 'nav-link' }}" href="{{url('joborderjourney')}}"><i class="ti-control-record" style="width: 18px;"></i>Job Order Journey</a></li>
                    <li class="{{ Request::path() == 'sales-order-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'sales-order-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('sales-order')}}"><i class="ti-control-record" style="width: 18px;"></i>Sales Order Report</a></li>
                    <li class="{{ Request::path() == 'transferagainst-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'transferagainst-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('transferagainst')}}"><i class="ti-control-record" style="width: 18px;"></i>Transfer Against JO</a></li>
                    <li class="{{ Request::path() == 'transfer-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'transfer-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('transfer')}}"><i class="ti-control-record" style="width: 18px;"></i>Transfer Issue Report</a></li>
                    <li class="{{ Request::path() == 'item-purchase-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'item-purchase-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('item-purchase')}}"><i class="ti-control-record" style="width: 18px;"></i>Item Purchase Report</a></li>
                    <li class="{{ Request::path() == 'purchase-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'purchase-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('purchase')}}"><i class="ti-control-record" style="width: 18px;"></i>Purchase Rate History</a></li>              
                    <li class="{{ Request::path() == 'material-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'material-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('material')}}"><i class="ti-control-record" style="width: 18px;"></i>Material Consumption</a></li>
                    <li class="{{ Request::path() == 'purchase-order-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'purchase-order-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('purchase-order')}}"><i class="ti-control-record" style="width: 18px;"></i>Purchase Order Report</a></li>
                    <li class="{{ Request::path() == 'consumption-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'consumption-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('consumption')}}"><i class="ti-control-record" style="width: 18px;"></i>Consumption Exception</a></li>
                    <li class="{{ Request::path() == 'purchase-invoice-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'purchase-invoice-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('purchase-invoice')}}"><i class="ti-control-record" style="width: 18px;"></i>Purchase Invoice Report</a></li>
                    <li class="{{ Request::path() == 'workorder-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'workorder-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('workorder')}}"><i class="ti-control-record" style="width: 18px;"></i>Work Order Item Costing</a></li>
                    <li class="{{ Request::path() == 'comparison-report' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'comparison-report' ? 'nav-link active' : 'nav-link' }}" href="{{url('comparison')}}"><i class="ti-control-record" style="width: 18px;"></i>Consumption Comparison</a></li>
                </ul>
            </li>
            <li class="{{ Request::path() == 'obj-department' ? 'mm-active active' : Request::path() == 'show-obj' ? 'mm-active active' : '' }}">
                <a href="javascript: void(0);" class="{{ Request::path() == 'obj-department' ? 'active' : Request::path() == 'show-obj' ? 'active'  : '' }}"><i class="ti-bookmark"></i><span>Objectives</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li class="{{ Request::path() == 'show-obj' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'show-obj' ? 'nav-link active' : 'nav-link' }}" href="{{url('objective-manage-new')}}"><i class="ti-control-record"></i>Manage Objectives</a></li>
                    <li hidden class="nav-item"><a class="nav-link" href="{{url('create-user-obj')}}"><i class="ti-control-record"></i>Create User</a></li>  
                    <li class="{{ Request::path() == 'obj-department' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'obj-department' ? 'nav-link active' : 'nav-link' }}" href="{{url('all-objective')}}"><i class="ti-control-record"></i>All Objectives</a></li>
                </ul>
            </li>
            <li hidden>
                <a href="javascript: void(0);"><i class="ti-files"></i><span>Set of Books</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li class="nav-item"><a class="nav-link" href="{{url('manage-books')}}"><i class="ti-control-record"></i>Assign a book</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('role-manage-neww')}}"><i class="ti-control-record"></i>Assign a book</a></li>
                </ul>
            </li>
            <li class="{{ Request::path() == 'job-order-table' ? 'mm-active active' : Request::path() == 'pricing-sheet-edit' ? 'mm-active active' : Request::path() == 'job-order-view' ? 'mm-active active' : Request::path() == 'job-order-edit' ? 'mm-active active' :  Request::path() == 'pricing-sheet-view' ? 'mm-active active' : '' }}">
                <a href="javascript: void(0);" class="{{ Request::path() == 'job-order-table' ? 'active' : Request::path() == 'job-order-view' ? 'active' : Request::path() == 'job-order-edit' ? 'active' : Request::path() == 'pricing-sheet-edit' ? 'active' : Request::path() == 'pricing-sheet-view' ? 'active' : '' }}"><i class="ti-files"></i><span>PDL</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level p-0" aria-expanded="false">
                    <li class="nav-item"><a class="nav-link"  href="{{url('master-data-plc')}}"><i class="ti-control-record"></i>Master Data</a></li>
                    <li hidden>
                        <a href="javascript: void(0);"><i class="ti-control-record"></i>Job Order <span class="menu-arrow left-has-menu"><i class="mdi mdi-chevron-right"></i></span></a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li hidden class="nav-item"><a class="nav-link" href="{{url('pricing-sheet')}}"><i class="ti-control-record"></i>Create</a></li>
                            <li class="{{ Request::path() == 'job-order-edit' ? 'nav-item active' : Request::path() == 'job-order-view' ? 'nav-item active' : 'nav-item' }}"><a class="{{  Request::path() == 'job-order-edit' ? 'nav-link active' : Request::path() == 'job-order-view' ? 'nav-link active' : 'nav-link' }}" href="{{url('job-order-table')}}"><i class="ti-control-record"></i>Dashboard</a></li>
                        </ul>
                    </li>  
                    <li>
                        <a href="javascript: void(0);"><i class="ti-control-record"></i>Pricing Sheet <span class="menu-arrow left-has-menu"><i class="mdi mdi-chevron-right"></i></span></a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li class="nav-item"><a class="nav-link" href="{{url('pricing-sheet')}}"><i class="ti-control-record"></i>Create</a></li>
                            <li class="{{ Request::path() == 'pricing-sheet-edit' ? 'nav-item active' : Request::path() == 'pricing-sheet-view' ? 'nav-item active' : 'nav-item' }}"><a class="{{  Request::path() == 'pricing-sheet-edit' ? 'nav-link active' : Request::path() == 'pricing-sheet-view' ? 'nav-link active' : 'nav-link' }}" href="{{url('pricing-sheet-table')}}"><i class="ti-control-record"></i>Dashboard</a></li>
                        </ul>
                    </li>
                    <li class="{{ Request::path() == 'formula-sheet-edit' ? 'mm-active active' : Request::path() == 'formula-sheet-view' ? 'mm-active active' : '' }}">
                        <a href="javascript: void(0);" class="{{ Request::path() == 'formula-sheet-edit' ? 'active' : Request::path() == 'formula-sheet-view' ? 'active' : ''}}"><i class="ti-control-record"></i>OH Formula Sheet <span class="menu-arrow left-has-menu"><i class="mdi mdi-chevron-right"></i></span></a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li class="{{ Request::path() == 'formula-sheet' ? 'nav-item active' : Request::path() == 'formula-sheet' ? 'nav-item active' : Request::path() == 'formula-sheet' ? 'nav-item active' : 'nav-item' }}"><a class="{{  Request::path() == 'formula-sheet' ? 'nav-link active' : Request::path() == 'formula-sheet' ? 'nav-link active' : 'nav-link' }}" href="{{url('formula-sheet')}}"><i class="ti-control-record"></i>Create</a></li>
                            <li class="{{ Request::path() == 'formula-sheet-view' ? 'nav-item active' : Request::path() == 'formula-sheet-edit' ? 'nav-item active' : Request::path() == 'formula-sheet-view' ? 'nav-item active' : 'nav-item' }}"><a class="{{  Request::path() == 'formula-sheet-edit' ? 'nav-link active' : Request::path() == 'formula-sheet-view' ? 'nav-link active' : 'nav-link' }}" href="{{url('formula-sheet-table')}}"><i class="ti-control-record"></i>Dashboard</a></li>
                        </ul>
                    </li>
                    <li hidden class="{{ Request::path() == 'specification-sheet-view' ? 'mm-active active' : '' }}">
                        <a href="javascript: void(0);" class="{{ Request::path() == 'specification-sheet-view' ? 'active' : ''}}"><i class="ti-control-record"></i>Specification Sheet <span class="menu-arrow left-has-menu"><i class="mdi mdi-chevron-right"></i></span></a>
                        <ul class="nav-second-level" aria-expanded="false">
                            <li class="nav-item"><a class="nav-link" href="{{url('specification-sheet')}}"><i class="ti-control-record"></i>Create</a></li> 
                            <li class="{{ Request::path() == 'specification-sheet-view' ? 'nav-item active' : Request::path() == 'specification-sheet-edit' ? 'nav-item active' : Request::path() == 'specification-sheet-view' ? 'nav-item active' : 'nav-item' }}"><a class="{{  Request::path() == 'specification-sheet-edit' ? 'nav-link active' : Request::path() == 'specification-sheet-view' ? 'nav-link active' : 'nav-link' }}" href="{{url('specification-sheet-table')}}"><i class="ti-control-record"></i>Dashboard</a></li>
                        </ul>
                    </li>  
                </ul>
            </li>
            <li class="{{ Request::path() == 'get-books' ? 'mm-active active' : '' }}">
                <a href="javascript: void(0);" class="{{ Request::path() == 'get-books' ? 'active' : '' }}"><i class="ti-book"></i><span>Books</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                <li class="nav-item"><a class="nav-link" href="{{url('manage-book')}}"><i class="ti-control-record"></i>Assign Book</a></li>
                    <li class="{{ Request::path() == 'get-books' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'get-books' ? 'nav-link active' : 'nav-link' }}" href="{{url('manageuserbook')}}"><i class="ti-control-record"></i>Manage Book</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript: void(0);"><i class="ti-user"></i><span>Profile</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li class="nav-item"><a class="nav-link" href="{{route('user-profile')}}"><i class="ti-control-record"></i>Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('user-password')}}"><i class="ti-control-record"></i>Change Password</a></li>
                </ul>
            </li>
            <li class="{{ Request::path() == 'complaints-view' ? 'mm-active active' : '' }}">
                <a href="javascript: void(0);" class="{{ Request::path() == 'complaints-view' ? 'active' : '' }}"><i class="ti-desktop"></i><span>Help Desk</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level p-0" aria-expanded="false">
                    <li class="{{ Request::path() == 'complaints-view' ? 'nav-item active' : 'nav-item' }}"><a class="{{ Request::path() == 'complaints-view' ? 'nav-link active' : 'nav-link' }}" href="{{url('manage-complaints')}}"><i class="ti-control-record"></i>Manage Complaints</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('master-settings')}}"><i class="ti-control-record"></i>Master Settings</a></li>          
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
                    &copy; Developed by <b>Business Technology</b> 
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
<script src="assets/pages/jquery.helpdesk-dashboard.init.js"></script>
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
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<script src="plugins/select2/select2.min.js"></script>
<script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="plugins/timepicker/bootstrap-material-datetimepicker.js"></script>
<script src="plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
<script src="plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js"></script>
<script src="assets/pages/jquery.forms-advanced.js"></script>
<!-- For Complaint -->
<script src="../assets/pages/jquery.projects_overview.init.js"></script>
<script>
function myFunction(id)
{
    $.ajax({
            type: 'GET',
            url: 'read_at/'+id,
            dataType: "json",
            success: function(data){
                if(data == 1){
                    Swal.fire({
                        icon: 'success',
                        showConfirmButton: false,
                    });
                    location.reload();
                }
                else if(data == 400){
                    Swal.fire({
                        icon: 'error',
                        title: 'Something went wrong!',
                        showConfirmButton: false,
                    });
                }
            }
        });
}
</script>