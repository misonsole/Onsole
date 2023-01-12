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
    #loader1 {  
        position: fixed;  
        left: 0px;  
        top: 0px;  
        width: 100%;  
        height: 100%;  
        z-index: 9999;  
        background: url("/img/avatars/3dgifmaker.gif") 50% 50% no-repeat black;  
    }
    .yourclass::-webkit-input-placeholder{
        color: #6c757d;
    }
    .select2-container--default .select2-selection--single{
        height: 35px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered{
        padding-top: 1%;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow{
        height: 26px;
        position: absolute;
        top: 3px;
        right: 1px;
        width: 20px;
    }
</style>
<div id="loader1" class="rotate" width="100" height="100"></div>
<div class="container-fluid px-5">
    <div class="row px-2">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Create User</li>
                    </ol>
                </div>
                <h4 class="page-title">Master Settings</h4>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-lg-2 mb-5">
        </div>
        <div class="col-lg-4 mb-5">
            <div class="card h-100">
                <div class="card-body p-5">
                    <div class="text-center mt-1">
                        <h3 class="py-3">Change User Password</h3>
                    </div>
                    <form action="{{url('change-password-admin')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-2">
                            <div class="col-sm-12 mb-1 mb-sm-0">
                                <label><b style="color: #6c757d">First Name</b></label>
                                <select id="name" name="name" class="select2 form-control mb-3 custom-select" style="border: 1px solid #bfbfbf;" required>
                                    <option selected disabled>Select User</option>                                            
                                    @foreach($data as $name)
                                        <option value="{{ $name->id }}">{{ $name->firstname }} {{ $name->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row py-2">
                            <div class="col-sm-12">
                                <label><b style="color: #6c757d">Password</b></label>
                                <input type="password" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="password" name="password" placeholder="Password" pattern="[a-zA-Z0-9\s]{3,20}" title="Must contain at least one number, one uppercase letter and 8 or more characters" required>
                                <button type="button" id="btnToggle" class="toggle"><i id="eyeIcon" class="fa fa-eye"></i></button>
                                <small id="emailHelp" class="form-text text-muted px-2">At least one number one uppercase letter, 8 or more characters.</small>
                                <span id="StrengthDisp" class="badge displayBadge text-light py-2 mt-2">Your password isn’t strong enough, try making it longer</span>                              
                            </div>
                        </div>
                        <div class="form-group row py-2">
                            <div class="col-sm-12">
                                <label><b style="color: #6c757d">Confirm Password</b></label>
                                <input type="password" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="confirm-password" name="confirm-password" placeholder="Confirm Password" required>
                                <button type="button" id="btnToggleConfirm" class="toggle"><i id="eyeIconConfirm" class="fa fa-eye"></i></button>    
                                <span id="StrengthDisp1" class="badge displayBadges text-light py-2 mt-2 w-100"></span>
                            </div>
                        </div>
                        <div class="form-group row py-2">
                            <div class="col-sm-12">
                            <small id="emailHelp" class="form-text text-muted px-2">&nbsp;</small>
                                <button type="submit" style="border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white">Change Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-5">
            <div class="card h-100">
                <div class="card-body p-5">
                    <div class="text-center mt-1">
                        <h3 class="py-3">Change User Status</h3>
                    </div>
                    <form action="{{url('change-status-admin')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-2">
                            <div class="col-sm-12">
                                <label><b style="color: #6c757d">Select User</b></label>
                                <select id="id" name="id" class="select2 form-control mb-3 custom-select" style="border: 1px solid #bfbfbf;" required>
                                    <option selected disabled>Select User</option>  
                                    @foreach($data as $name)
                                        <option value="{{ $name->id }}">{{ $name->firstname }} {{ $name->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row py-1">
                            <div class="col-sm-12">
                                <label><b style="color: #6c757d">Select Status</b></label>
                                <select id="status" name="status" class="select2 form-control mb-3 custom-select" style="border: 1px solid #bfbfbf;" required>
                                    <option selected disabled>Select Status</option>   
                                    <option value="1">Active</option>
                                    <option value="2">Deactive</option>
                                    <option value="3">Terminate</option>
                                    <option value="4">Delete</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row py-2">
                            <div class="col-sm-12">
                                <button type="submit" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white">Change Status</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-2 mb-5">
        </div>
    </div>
</div>
<script src="assets/js/customjquery.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script>     
    $(document).ready(function(){ 
        $("#loader1").fadeOut(1200);
    });
    let timeout;
    let password = document.getElementById('password')
    let strengthBadge = document.getElementById('StrengthDisp')
    let strengthBadge1 = document.getElementById('StrengthDisp1')

    let mediumPassword = new RegExp('(?=.*[A-Z])(?=.*[0-9])(?=.{8,})') 
    let strongPassword = new RegExp('(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})') 
    
    function StrengthChecker(PasswordParameter){
        if(strongPassword.test(PasswordParameter)){
            strengthBadge.style.backgroundColor = '#52a752'
            strengthBadge.textContent = 'Strong'
        }
        else if(mediumPassword.test(PasswordParameter)){
            strengthBadge.style.backgroundColor = '#52a752'
            strengthBadge.textContent = 'Strong'
        }
        else{
            strengthBadge.style.backgroundColor = '#cd3f3f'
            strengthBadge.textContent = 'Your password isn’t strong enough, try making it longer'
        }
    }

    password.addEventListener("input", () => {
        strengthBadge.style.display= 'block'
        clearTimeout(timeout);
        timeout = setTimeout(() => StrengthChecker(password.value), 500);

        if(password.value.length !== 0){
            strengthBadge.style.display != 'block'
        } 
        else{
            strengthBadge.style.display = 'none'
        }
    });

	$('#confirm-password').on('keyup', function() {
  	if($('#password').val() == $('#confirm-password').val()){
		strengthBadge1.style.backgroundColor = '#52a752'
        strengthBadge1.textContent = 'Password Matched'
  	} 
	else{
		strengthBadge1.style.backgroundColor = '#cd3f3f'
        strengthBadge1.textContent = 'Password No Matching'
	}
});
</script>
<script>
    icon = document.getElementById('eyeIcon');
    toggle = document.getElementById('btnToggle');
    passwordInput = document.getElementById('password');
    ConfirmInput = document.getElementById('confirm-password');
    Confirmtoggle = document.getElementById('btnToggleConfirm');
    Confirmicon = document.getElementById('eyeIconConfirm');

    function togglePassword(){
        if(passwordInput.type === 'password'){
            passwordInput.type = 'text';
            icon.classList.add("fa-eye-slash");
        }
        else{
            passwordInput.type = 'password';
            icon.classList.remove("fa-eye-slash");
        }
    }

    function toggleConfirmPassword(){
        if(ConfirmInput.type === 'password'){
            ConfirmInput.type = 'text';
            Confirmicon.classList.add("fa-eye-slash");
        }
        else{
            ConfirmInput.type = 'password';
            Confirmicon.classList.remove("fa-eye-slash");
        }
    }
    toggle.addEventListener('click', togglePassword, false);
    Confirmtoggle.addEventListener('click', toggleConfirmPassword, false);
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