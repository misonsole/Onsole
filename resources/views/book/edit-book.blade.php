@extends( (Auth::user()->id == "2") ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<style>
    select[id="typefrom"]>option:nth-child(2), select[id="typefrom"]>option:nth-child(3), select[id="typefrom"]>option:nth-child(4), select[id="typefrom"]>option:nth-child(5), select[id="typefrom"]>option:nth-child(6), select[id="typefrom"]>option:nth-child(7) {
        font-weight:bold;
    }
    .select2-container--default .select2-selection--single{
        height: 38px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered{
        padding-top: 3px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow{
        height: 26px;
        position: absolute;
        top: 5px;
        right: 1px;
        width: 20px;
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
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove{
        color: #463f3f;
        cursor: pointer;
        display: inline-block;
        font-weight: bold;
        margin-right: 2px;
        margin-bottom: 2px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__rendered li{
        list-style: none;
        color: black;
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
                        <li class="breadcrumb-item active">Edit Book</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Book</h4>
            </div>
        </div>
    </div>
    <div class="row mt-2 mb-5">
        <div class="col-lg-6 mb-5" style="margin: 0 auto;">
            <div class="card">
                <div class="card-body p-5">
                    <div class="text-center mb-1">
                        <h3 class="py-3">Edit Book</h3>
                    </div>
                    <form id="myForm">
                    @csrf
                        <div class="form-group row py-2">
                            <div class="col-sm-12 mb-1 mb-sm-0">
                                <label><b style="color: #6c757d">Role</b></label>
                                <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" value="{{$Userbook}}" readonly>                                
                            </div>
                        </div>
                        <div class="form-group row py-2">
                            <div class="col-sm-12 mb-1 mb-sm-0">
                                <label><b style="color: #6c757d">Book Name</b></label>
                                <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect9" name="books[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder=" Choose Books" required>
                                    @foreach($book as $value)    
                                        @foreach($str_arr as $val)                            
                                            <option <?php if($val == $value['id']) echo 'selected="selected"'; ?> value="{{$value['id']}}">{{$value['book']}}</option>
                                        @endforeach
                                    @endforeach
                                </select>  
                            </div>
                        </div>
                        <div class="form-group row py-3 mt-5" style="margin-bottom: 0px;">
                            <div class="col-sm-12">
                                <span class="btn px-5 py-1 btn-lg btn-block text-white" id="save" style="border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); cursor: pointer;">Update</span>
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
    $("#save").click(function(){
        var val = $('#role').val();
        $.ajax({
                type: 'GET',
                url: 'check/'+val,
                dataType: "json",
                success: function(data){
                    console.log(data);
                    if(data == 2){
                        $("#myForm").attr("action", "update-book");
                        $("#myForm").attr("method", "post");
                        document.getElementById("myForm").submit();
                    }
                    else if(data == 1){
                        Swal.fire({
                            icon: 'info',
                            title: 'Books Already Assigned to this Role',
                        });
                    }
                }
            });
    });
    $('#role').on('change', function(){
        var val = $(this).val();
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
        });
        break;
    }
@endif
</script>
@endsection