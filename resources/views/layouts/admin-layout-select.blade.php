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
            <li class="dropdown notification-list" hidden>
                <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="ti-bell noti-icon"></i>
                    <span class="badge badge-danger badge-pill noti-icon-badge">2</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-lg pt-0">
                    <h6 class="dropdown-item-text font-15 m-0 py-3 bg-primary text-white d-flex justify-content-between align-items-center">Notifications<span class="badge badge-light badge-pill">2</span></h6> 
                    <div class="slimscroll notification-list">
                        <a href="#" class="dropdown-item py-3">
                            <small class="float-right text-muted pl-2">2 min ago</small>
                            <div class="media">
                                <div class="avatar-md bg-primary">
                                    <i class="la la-cart-arrow-down text-white"></i>
                                </div>
                                <div class="media-body align-self-center ml-2 text-truncate">
                                    <h6 class="my-0 font-weight-normal text-dark">Your order is placed</h6>
                                    <small class="text-muted mb-0">Dummy text of the printing and industry.</small>
                                </div>
                            </div>
                         </a>
                        <a href="#" class="dropdown-item py-3">
                            <small class="float-right text-muted pl-2">10 min ago</small>
                            <div class="media">
                                <div class="avatar-md bg-success">
                                     <i class="la la-group text-white"></i>
                                </div>
                                <div class="media-body align-self-center ml-2 text-truncate">
                                    <h6 class="my-0 font-weight-normal text-dark">Meeting with designers</h6>
                                    <small class="text-muted mb-0">It is a long established fact that a reader.</small>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item py-3">
                            <small class="float-right text-muted pl-2">40 min ago</small>
                            <div class="media">
                                <div class="avatar-md bg-pink">
                                    <i class="la la-list-alt text-white"></i>
                                </div>
                                <div class="media-body align-self-center ml-2 text-truncate">
                                    <h6 class="my-0 font-weight-normal text-dark">UX 3 Task complete.</h6>
                                    <small class="text-muted mb-0">Dummy text of the printing.</small>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item py-3">
                            <small class="float-right text-muted pl-2">1 hr ago</small>
                            <div class="media">
                                <div class="avatar-md bg-warning">
                                    <i class="la la-truck text-white"></i>
                                </div>
                                <div class="media-body align-self-center ml-2 text-truncate">
                                    <h6 class="my-0 font-weight-normal text-dark">Your order is placed</h6>
                                    <small class="text-muted mb-0">It is a long established fact that a reader.</small>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="dropdown-item py-3">
                            <small class="float-right text-muted pl-2">2 hrs ago</small>
                            <div class="media">
                                <div class="avatar-md bg-info">
                                    <i class="la la-check-circle text-white"></i>
                                </div>
                                <div class="media-body align-self-center ml-2 text-truncate">
                                    <h6 class="my-0 font-weight-normal text-dark">Payment Successfull</h6>
                                    <small class="text-muted mb-0">Dummy text of the printing.</small>
                                </div>
                            </div>
                        </a>
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
            <li>
                <a href="{{url('home')}}"><i class="ti-bar-chart"></i><span>Dashboard</span><span class="menu-arrow"></span></a>
            </li>
            <li>
                <a href="javascript: void(0);"><i class="ti-settings"></i><span>Master Settings</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li class="nav-item"><a class="nav-link" href="{{url('master-data')}}"><i class="ti-control-record"></i>Master Date</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('user-manage')}}"><i class="ti-control-record"></i>Manage User</a></li>                          
                    <li class="nav-item"><a class="nav-link" href="{{url('users-create')}}"><i class="ti-control-record"></i>Create User</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('manage-books')}}"><i class="ti-control-record"></i>Set of Books</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript: void(0);"><i class="ti-target"></i><span>Roles</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li class="nav-item"><a class="nav-link" href="{{url('role-manage-new')}}"><i class="ti-control-record"></i>Manage Roles</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('role-create')}}"><i class="ti-control-record"></i>Create Role</a></li>  
                </ul>
            </li>
            <li>
                <a href="javascript: void(0);"><i class="ti-bookmark"></i><span>Objectives</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li class="nav-item"><a class="nav-link" href="{{url('objective-manage-new')}}"><i class="ti-control-record"></i>Manage Objectives</a></li>
                    <li hidden class="nav-item"><a class="nav-link" href="{{url('create-user-obj')}}"><i class="ti-control-record"></i>Create User</a></li>  
                    <li class="nav-item"><a class="nav-link" href="{{url('all-objective')}}"><i class="ti-control-record"></i>All Objectives</a></li>
                </ul>
            </li>
            <li hidden>
                <a href="javascript: void(0);"><i class="ti-files"></i><span>Set of Books</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li class="nav-item"><a class="nav-link" href="{{url('manage-books')}}"><i class="ti-control-record"></i>Assign a book</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('role-manage-neww')}}"><i class="ti-control-record"></i>Assign a book</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript: void(0);"><i class="ti-files"></i><span>Job Order</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                <ul class="nav-second-level" aria-expanded="false">
                    <li class="nav-item"><a class="nav-link" href="{{url('job-order')}}"><i class="ti-control-record"></i>Create</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{url('job-order-table')}}"><i class="ti-control-record"></i>Manage Job Order</a></li>
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