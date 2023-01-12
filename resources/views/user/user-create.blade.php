@extends( (Auth::user()->id == "2") ? 'layouts.admin-layout' : 'layouts.user-layout')
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
    .displayBadgess{
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
    .select2-container--default .select2-selection--single {
        background-color: #fff;
        border: 1px solid #aaa;
        border-radius: 4px;
        height: 36px;
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
    .yourclass::-webkit-input-placeholder{
        color: #6c757d;
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
                <h4 class="page-title">Create User</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-5">
                    <form action="{{url('user-create')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-2">
                            <div class="col-sm-4 mb-1 mb-sm-0">
                                <label><b style="color: #6c757d">Employee Name</b></label>
                                <span style="display: flex;">
                                <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize;" id="emp_name1" name="emp_name1" placeholder="Select User" readonly>
                                <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize;" id="emp_name" name="emp_name" placeholder="Select User" hidden>
                                    <span>
                                        <a data-toggle="modal" data-target="#exampleModalCenter212" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                    </span>
                                </span>
                            </div>
                            <div class="col-sm-4">
                                <label><b style="color: #6c757d">First Name</b></label>
                                <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize;" id="firstname" name="firstname" placeholder="First Name" required readonly>
                            </div>
                            <div class="col-sm-4">
                                <label><b style="color: #6c757d">Last Name</b></label>
                                <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize;" id="lastname" name="lastname" placeholder="Last Name" required readonly>
                                <input hidden type="text" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize;" id="emp_code" name="emp_code">
                                <input hidden type="text" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize;" id="name" name="name">
                            </div>
                        </div>
                        <div class="form-group row py-2">
                            <div class="col-sm-4 mb-1 mb-sm-0">
                                <label><b style="color: #6c757d">User Name</b></label>
                                <input type="text" class="form-control py-2 formfield w0 yourclass" style="border: 1px solid #bfbfbf;" id="username" name="username" placeholder="User Name" required pattern="[a-zA-Z0-9\.?s]{3,20}">
                                <span id="StrengthDisp2" style="font-size: 13px !important;" class="badge displayBadgess text-light py-2 mt-2"></span>                                                          
                            </div>
                            <div class="col-sm-4 mb-1 mb-sm-0">
                                <label><b style="color: #6c757d">Email</b></label>
							    <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="email" name="email" placeholder="Email Address" required>
                                @if($errors->has('email'))
                                        <span class="badge displayBadges py-2 mt-2 text-light" style="background: #cd3f3f; display: block; font-size: 13px !important;">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="col-sm-4 mb-1 mb-sm-0">
                                <label><b style="color: #6c757d">Phone No</b></label>
							    <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="phone" name="phone" placeholder="Phone No" required>
                            </div>
                        </div>
                        <div class="form-group row py-2">
                            <div class="col-sm-4 mb-1 mb-sm-0">
                                <label><b style="color: #6c757d">User Role</b></label>
                                <select id="userrole" name="userrole" style="border: 1px solid #bfbfbf;" class="form-control select.custom-select" required>
                                    <option selected disabled>Select Role</option>   
                                    @foreach($data as $value)
                                        <option value="{{ $value->name }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label><b style="color: #6c757d">Password</b></label>
                                <input type="password" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="password" name="password" placeholder="Password" pattern="[a-zA-Z0-9\s]{3,20}" title="Must contain at least one number, one uppercase letter and 8 or more characters" required>
                                <button type="button" id="btnToggle" class="toggle"><i id="eyeIcon" class="fa fa-eye"></i></button>
                                <small id="emailHelp" class="form-text text-muted px-2">Must Contain at least one number one uppercase letter, 8 or more characters.</small>
                                <span id="StrengthDisp" style="font-size: 13px !important;" class="badge displayBadge text-light py-2 mt-2">Your password isn’t strong enough, try making it longer</span>                              
                            </div>
                            <div class="col-sm-4">
                                <label><b style="color: #6c757d">Confirm Password</b></label>
                                <input type="password" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="confirm-password" name="confirm-password" placeholder="Confirm Password" required>
                                <button type="button" id="btnToggleConfirm" class="toggle"><i id="eyeIconConfirm" class="fa fa-eye"></i></button>    
                                <small id="emailHelp" class="form-text text-muted px-2">&nbsp;</small>
                                <span id="StrengthDisp1" style="font-size: 13px !important;" class="badge displayBadges text-light py-2 mt-2 w-100"></span>
                            </div>
                        </div>
                        <div class="form-group row py-2">
                            <div class="col-sm-4 mb-1 mb-sm-0">
                                <label><b style="color: #6c757d">Designation</b></label>
                                <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize;" id="designation" name="designation" placeholder="Designation" required readonly>
                            </div>
                            <div class="col-sm-4">
                                <label><b style="color: #6c757d">Department</b></label>
                                <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize;" id="department" name="department" placeholder="Department" required readonly>
                            </div>
                            <div class="col-sm-4">
                                <label><b style="color: #6c757d">Profile Photo</b></label>
                                <div class="file-upload">
                                    <div class="file-upload-select">
                                        <div class="file-select-button" >Choose File</div>
                                        <div class="file-select-name">No file chosen...</div> 
                                        <input style="border: 1px solid #bfbfbf;" type="file" name="image" id="file-upload-input">
                                    </div>
                                </div>    
                            </div>
                        </div>
                        <div class="form-group row mt-5">
                            <div class="col-sm-4 mb-1 mb-sm-0">
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white">Create</button>
                            </div>
                            <div class="col-sm-4">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('model/user')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
<script src="assets/js/customjquery.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script>
    $(document).ready(function(){ 
        $("#loader1").fadeOut(1200);
    });
    let fileInput = document.getElementById("file-upload-input");
    let fileSelect = document.getElementsByClassName("file-upload-select")[0];
    fileSelect.onclick = function(){
	    fileInput.click();
    }
    fileInput.onchange = function(){
	    let filename = fileInput.files[0].name;
	    let selectName = document.getElementsByClassName("file-select-name")[0];
	    selectName.innerText = filename;
    }
</script>
<script>
    $('#username').on('keypress', function(e){
        if(e.which == 32){
            return false;
        }
    });
</script>
<script>     
    let timeout;
    let password = document.getElementById('password')
    let confirmpassword = document.getElementById('confirm-password')
    let username = document.getElementById('username')
    let strengthBadge = document.getElementById('StrengthDisp')
    let strengthBadge1 = document.getElementById('StrengthDisp1')
    let strengthBadge2 = document.getElementById('StrengthDisp2')

    let mediumPassword = new RegExp('(?=.*[A-Z])(?=.*[0-9])(?=.{8,})') //one uppercase, at least one digit, at least 8 characters long
    let strongPassword = new RegExp('(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})') //at least one uppercase, at least one uppercase, at least one digit, at least 8 characters long
    
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

    username.addEventListener("input", () => {
        Username(username.value);
        function Username(usernameVal){
            $.ajax({
                    type: 'GET',
                    url: 'username/'+usernameVal,
                    dataType: "json",
                    success: function(data){
                        if(data){
                            if(data == 1){
                                strengthBadge2.style.display = 'block'
                                strengthBadge2.style.backgroundColor = '#cd3f3f'
                                strengthBadge2.textContent = 'Username Already taken'
                            }
                            else if(data == 2){
                                strengthBadge2.style.display = 'block'
                                strengthBadge2.style.backgroundColor = '#52a752'
                                strengthBadge2.textContent = 'Username Available'
                            }
                        }
                    }
                });
        }
    });

	confirmpassword.addEventListener("input", () => {
  	if(password.value == confirmpassword.value){
		strengthBadge1.style.backgroundColor = '#52a752'
        strengthBadge.style.display != 'block'
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
$(document).ready(function(){
    $(".btnSelectuser").on('click',function(){
        var currentRow = $(this).closest("tr");
        var col2 = currentRow.find("td:eq(2)").html();
        var col1 = currentRow.find("td:eq(1)").html();
        $("#exampleModalCenter212").modal('hide');
        $("#emp_name").val(col2);
        $("#emp_name1").val(col1);
        var employee = $("#emp_name").val();
        EmployeeDetail(employee);
        function EmployeeDetail(employee){
            $.ajax({
                    type: 'GET',
                    url: 'employee_detail/'+employee,
                    dataType: "json",
                    success: function(data){
                        if(data){
                            console.log(data);
                            $("#firstname").val(data[0].firstname);
                            $("#name").val(data[0].name);
                            $("#lastname").val(data[0].lastname);
                            $("#emp_code").val(data[0].empcode);
                            $("#department").val(data[0].department);
                            $("#designation").val(data[0].designation);
                        }
                    }
                });
            }
    });
});
</script>
@endsection