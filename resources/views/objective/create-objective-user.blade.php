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
</style>
<div id="loader1" class="rotate" width="100" height="100"></div>
<div class="container-fluid px-5">
    <div class="row px-1">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Create Objective User</li>
                    </ol>
                </div>
                <h4 class="page-title">Create Objective User</h4>
            </div>
        </div>
    </div>
    <div class="row">
		<div class="col-md-12 col-xl-12" style="margin: 0 auto;">
			<div class="card">
				<div class="card-body h-100">
					<div class="text-center mt-5">
						<h2 style="color: #6c757d">Create Objective User</h2>
					</div>
					<form action="{{url('create-obj-user')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="p-5">
							<div class="form-group row py-2">
                                <div class="col-sm-3 mb-1 mb-sm-0">
                                <label for=""><b style="color: #6c757d">Name</b></label>
                                    <select id="name" name="name" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        <option selected disabled>Select name</option>   
                                        @foreach($empname as $names)
                                            <option style="text-transform: capitalize" value="{{ $names[0]['name'] }}">{{ $names[0]['name'] }} - {{ $names[0]['code'] }}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" id="emp_code" name="emp_code" hidden>
                                    @if($errors->has('name'))
                                        <span class="badge displayBadges py-2 mt-2 text-light" style="background: #cd3f3f; display: block;">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <div class="col-sm-3">
                                <label for=""><b style="color: #6c757d">Department</b></label>
                                    <input readonly type="text" class="form-control py-2" style="border: 1px solid #bfbfbf;" value="{{$department}}" id="department" name="department" placeholder="Designation" required>
                                </div>
                                <div class="col-sm-3">
                                <label for=""><b style="color: #6c757d">Lead Name</b></label>
                                    <input readonly type="text" class="form-control py-2" style="border: 1px solid #bfbfbf;" value="{{$name}}" id="leadname" name="leadname" required>
                                </div>
                                <div class="col-sm-3">
                                <label for=""><b style="color: #6c757d">&nbsp;</b></label>
								    <button type="submit" class="btn w-100 py-1 text-white" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); border: none; font-size: 17px;">Create User</button>
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
            title: "{{ session('message') }}",
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
            icon: 'Error',
            title: "{{ session('message') }}",
            showConfirmButton: false,
			timer: 2000
        });
        break;
    }
  @endif
</script>
<script>
    Employeename = document.getElementById('name');
	Employeename.addEventListener("input", () => {
    var employee = Employeename.value;
    EmployeeDetail(employee);
    function EmployeeDetail(employee){
        $.ajax({
                type: 'GET',
                url: 'employee_detail1/'+employee,
                dataType: "json",
                success: function(data){
                    if(data){
                        console.log(data);
                        $("#emp_code").val(data);
                    }
                }
            });
    }
});    
</script>
@endsection