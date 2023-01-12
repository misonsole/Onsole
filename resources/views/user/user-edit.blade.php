@extends( (Auth::user()->id == "2") ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
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
    <div class="row px-2">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('user-manage')}}">Manage User</a></li>
                        <li class="breadcrumb-item active">Edit User</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit User</h4>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{url('edit-user')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        @foreach($users as $data)
                        <div class="form-group row py-2">
                            <div class="col-sm-3 mb-1 mb-sm-0">
                                <label><b style="color: #6c757d">User Name</b></label>
                                <input hidden id="id" name="id" value="{{$data['id']}}" type="text">
                                <input type="text" value="{{$data['name']}}" style="border: 1px solid #bfbfbf;" class="form-control py-2" id="username" name="username" placeholder="User Name" required>
                            </div>
                            <div class="col-sm-3">
                                <label><b style="color: #6c757d">Email</b></label>
                                <input type="text" value="{{$data['email']}}" style="border: 1px solid #bfbfbf;" class="form-control py-2" id="email" name="email" placeholder="Email Address" required>
                            </div>
                            <div class="col-sm-3 mb-1 mb-sm-0">
                                <label><b style="color: #6c757d">Phone No</b></label>
							    <input type="text" value="{{$data['phone']}}" style="border: 1px solid #bfbfbf;" class="form-control py-2" id="phone" name="phone" placeholder="Phone No" required>
                            </div>
                            <div class="col-sm-3">
                                <label><b style="color: #6c757d">User Role</b></label>
                                <select id="userrole" name="userrole" style="border: 1px solid #bfbfbf;" class="form-control select.custom-select" required>
                                    @foreach($roles as $name)
                                        <option <?php if($name->name == $userrole) echo 'selected="selected"'; ?> value="{{ $name->name }}">{{ $name->name }}</option>
                                    @endforeach
                                </select>  
                            </div>
                        </div>
                        @endforeach
                        <div class="form-group row py-2">
                            <div class="col-sm-3 mb-1 mb-sm-0">
                            </div>
                            <div class="col-sm-3">
                            </div>
                            <div class="col-sm-3">
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white">Update</button>
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