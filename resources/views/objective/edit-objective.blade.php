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
    .displayBadge
    {
        display: none; 
        text-align :center;
    }
	.displayBadges
    {
        text-align :center;
    }
    .toggle 
    {
        background: none;
        border: none;
        color: grey;
        font-weight: 400;
        position: absolute;
        right: 1.30em;
        top: 0.85em;
        z-index: 9;
    }
    .fa
    {
        font-size: 1.1rem;
    }
    .btn-outline:hover, .btn-outline:active, .btn-outline:visited 
    {
        background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;
        border: 1px solid transparent !important;
        color: white;
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
<div id="loader1" class="rotate" width="100" height="100"></div>
<div class="container-fluid px-5">
    <div class="row px-1">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('user-manage')}}">Manage User</a></li>
                        <li class="breadcrumb-item active">Edit objective</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit objective</h4>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                <form action="{{url('update-objective')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="p-5">
							<div class="form-group row py-2">
                                <div class="col-sm-6 mb-1 mb-sm-0">
                                    <label for=""> <b style="color: #6c757d">Member Name</b> </label>
                                    <input type="text" value="{{$users->id}}" name="id" hidden>
							        <input readonly type="text" value="{{$users->memberName}}" class="form-control py-2" id="memberName" name="memberName" placeholder="First Name" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for=""> <b style="color: #6c757d">Title</b> </label>
                                    <input type="text" value="{{$users->objTitle}}" class="form-control py-2" id="objTitle" name="objTitle" placeholder="Last Name" required>
                                </div>
                            </div>
						    <div class="form-group row py-2">
                                <div class="col-sm-6 mb-1 mb-sm-0">
                                    <label for=""> <b style="color: #6c757d">Description</b> </label>
                                    <textarea required class="form-control py-2" id="objDescription" name="objDescription" rows="1">{{$users->objDescription}}</textarea>
                                </div>
                                <div class="col-sm-6">
                                <label for=""> <b style="color: #6c757d">Weightage</b> </label>
                                    <input type="text" value="{{$users->objWeightage}}" class="form-control py-2" id="objWeightage" name="objWeightage" placeholder="Email Address" required min="0">
                                </div>
                            </div>
                            <div class="form-group row py-2" hidden>
                                <div class="col-sm-6 mb-1 mb-sm-0">
                                    <label for=""> <b style="color: #6c757d">Status</b> </label>
							        <input type="text" value="{{$users->objStatus}}" class="form-control py-2" id="objStatus" name="objStatus" placeholder="Phone No">
                                </div>
                                <div class="col-sm-6" hidden>
                                    <label for=""> <b style="color: #6c757d">Comments</b> </label>
                                    <textarea value="{{$users->comment}}" class="form-control py-2" id="comment" name="comment" rows="1"></textarea>
                                </div>
                            </div>
                            <div class="form-group row py-3">
                                <div class="col-sm-12 mb-1 mb-sm-0">
                                <button type="submit" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white">Update Objective</button>
                                </div>
                            </div>
                        </div>
				    </form>
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