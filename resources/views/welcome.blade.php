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
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/jquery-ui.min.css" rel="stylesheet">
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/metisMenu.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
</head>
<style>
    .content{
        background-image: url("img/photos/BG.jpeg");
        background-size: cover;
    }
    .toggle{
        background: none;
        border: none;
        color: grey;
        font-weight: 400;
        position: absolute;
        right: 0.60em;
        top: 0.85em;
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
</style>
<div id="loader1" class="rotate" width="100" height="100"></div>
<body class="account-body accountbg content" style="line-height: none;">
    <div class="container">
        <div class="row vh-100">
            <div class="col-12 align-self-center">
                <div class="auth-page">
                    <div class="card auth-card shadow-lg bg-dark">
                        <div class="card-body">
                            <div class="px-3">
                                <div class="auth-logo-box">
                                    <a href="../dashboard/analytics-index.html" class="logo logo-admin"><img src="img/photos/preview.png" height="70" alt="logo" class="auth-logo"></a>
                                </div><br><br>
                                <div class="text-center auth-logo-text bg-dark">
                                    <h4 style="font-family: system-ui;" class="mt-0 mb-3 mt-5 text-white">Let's Get Started ONSOLE</h4>
                                </div> 
                                <form action="{{ route('Signupp') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                    <div class="form-group">
                                        <label for="username text-light">Username</label>
                                        <div class="input-group mb-3">                                                                                                                                                       
                                            <input type="text" id="name" name="name" class="form-control" placeholder="Enter username">
                                        </div>                                    
                                    </div>
                                    <div class="form-group">
                                        <label for="userpassword">Password</label>                                            
                                        <div class="input-group mb-3">                                                
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
                                            <button type="button" id="btnToggle" class="toggle"><i id="eyeIcon" class="fa fa-eye"></i></button>
                                        </div>                               
                                    </div> 
                                    <div class="form-group row mt-4">
                                        <div class="col-sm-6" hidden>
                                            <div class="custom-control custom-switch switch-success">
                                                <input type="checkbox" name="remember" value="1" class="custom-control-input" id="customSwitchSuccess">
                                                <label class="custom-control-label text-muted" for="customSwitchSuccess">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 text-right">
                                            <a href="{{ route('password.request') }}" class="text-muted font-13">Forgot password?</a>                                    
                                        </div>
                                    </div> 
                                    <br>
                                    <div class="form-group mb-5 row">
                                        <div class="col-12 mt-2">
                                            <button type="submit" class="btn btn-primary btn-round btn-block text-white" style="background: #202020; border: 1px solid #202020; box-shadow: none; cursor: pointer;">Login<i class="fas fa-sign-in-alt ml-1"></i></button>
                                        </div> 
                                    </div>                          
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>           
        </div>
    </div>
</body>
</html>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery-ui.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/metismenu.min.js"></script>
<script src="assets/js/waves.js"></script>
<script src="assets/js/feather.min.js"></script>
<script src="assets/js/jquery.slimscroll.min.js"></script>        
<script src="assets/js/app.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script src="assets/js/customjquery.min.js"></script>
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
        });
        break;
    }
  @endif
</script>
<script>
    icon = document.getElementById('eyeIcon');
    toggle = document.getElementById('btnToggle');
    passwordInput = document.getElementById('password');

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
    toggle.addEventListener('click', togglePassword, false);
</script>
<script>
    $(document).ready(function(){ 
	    $("#loader1").fadeOut(1200);
    });
</script>