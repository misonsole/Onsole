@extends( (Auth::user()->id == "2") ? 'layouts.admin-layout-select' : 'layouts.user-layout')
@section('content')
        <!-- Plugins css -->
        <link href="plugins/daterangepicker/daterangepicker.css" rel="stylesheet" />
        <link href="plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet" type="text/css" />
        <link href="plugins/timepicker/bootstrap-material-datetimepicker.css" rel="stylesheet">
        <link href="plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />

        <!-- App css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/jquery-ui.min.css" rel="stylesheet">
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/metisMenu.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
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
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        /* margin-top: 7px; */
        /* background-color: #9ba7ca; */
        /* border: 1px solid #e8ebf3; */
        color: white;
        font-weight: 500;
        background: #9ba7ca;
        padding-bottom: 2px;
        padding-top: 2px;
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
<div class="container-fluid px-5">
    <div class="row px-2">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Set of Books</li>
                    </ol>
                </div>
                <h4 class="page-title">Set of Books</h4>
            </div>
        </div>
    </div>
    <div class="row mt-2 mb-5">
        <div class="col-lg-12 mb-5">
            <div class="card">
                <div class="card-body p-5">
                    <div class="text-center mb-1">
                        <h3 class="py-3">Set of Books</h3>
                    </div>
                    <form action="{{url('store-books')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-2">
                            <div class="col-sm-3 mb-1 mb-sm-0">
                                <label><b style="color: #6c757d">Users</b></label>
                                <select id="name" name="name" class="form-control select.custom-select" required>
                                    @foreach($data as $name)
                                        <option value="{{ $name->id }}">{{ $name->firstname }} {{ $name->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div id="objtable">
                            <div class="form-group row py-2">
                                <div class="col-sm-3">
                                    <label><b style="color: #6c757d">Book Type</b></label>
                                    <select data-id="1" id="bookname7" name="bookname[]" style="text-transform: capitalize;" class="form-control select.custom-select" required>
                                        <option selected disabled>Select Book</option>                                            
                                        @foreach($book as $bookname)
                                            <option value="{{ $bookname[0]['id'] }}">{{ $bookname[0]['book'] }}</option>
                                        @endforeach
                                    </select>                            
                                </div>
                                <div class="col-sm-8">
                                    <label hidden><b style="color: #6c757d">Book Name</b></label>
                                    <select hidden id="mySelecdt" name="book3[]" class="form-control select.custom-select" required>
                                    </select>
                                    <label><b style="color: #6c757d">Book Name</b></label>
                                    <select class="select2 mb-3 select2-multiple form-controll text-dark px-2" id="mySelect" name="book[]" style="width: 100%" multiple="multiple" data-placeholder="   Choose Books">
                                    </select> 
                                </div>
                                <div class="col-sm-1" hidden>
                                    <label><b style="color: #6c757d">&nbsp;</b></label>
                                    <button type="button" id="addobj" style="border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white"><i class="ti-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div name="row_count">
                        </div>
                        <div class="form-group row py-3 mt-5" style="margin-bottom: 0px;">
                            <div class="col-sm-12">
                                <button type="submit" style="border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white">Submit</button>
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
    $(document).ready(function(){
    var i = 1;
        $('#addobj').click(function(){
            i++;
            $('#objtable').append('<div id="row'+i+'" name="row_count" class="form-group row py-2">'+
                                        '<div class="col-sm-5">'+
                                            '<select id="book'+i+'" name="bookname[]" onchange="book123('+i+')" class="form-control select.custom-select">'+
                                                '<option selected disabled>Select Book</option>'+                                            
                                                    '@foreach($book as $bookname)'+
                                                '<option value="{{ $bookname[0]['id'] }}">{{ $bookname[0]['book'] }}</option>'+
                                                    '@endforeach'+
                                            '</select>'+                              
                                        '</div>'+
                                        '<div class="col-sm-5">'+
                                            '<select id="mySelect2'+i+'" name="book[]" class="form-control select.custom-select" required>'+
                                            '</select>'+
                                        '</div>'+
                                        '<div class="col-sm-2">'+
                                            '<button id="'+i+'" type="button" style="border: none; font-size: 17px; background: red" class="btn px-5 py-1 btn-lg btn-block text-white obj_remove"><i class="ti-minus"></i></button>'+
                                        '</div>'+
                                    '</div>');
        });
        $(document).on('click', '.obj_remove', function(){
            var id = $(this).attr("id"); 
            $('#row'+id+'').remove();
        });
    });
</script>
<script>
    Employeename = document.getElementById('bookname7');
	Employeename.addEventListener("input", () => {
    var Employee = Employeename.value;
    EmployeeDetail(Employee);
    function EmployeeDetail(Employee){
        $.ajax({
                type: 'GET',
                url: 'books/'+Employee,
                dataType: "json",
                success: function(data){
                    if(data){
                        console.log("Count");
                        console.log(data.length);
                        $('#mySelect').find('option').remove();
                        for(i = 0; i < data.length; i++){ 
                                $('#mySelect').append($('<option>',{
                                    value: i,
                                    text : data[i][0].book 
                            }));
                        }
                    }
                }
            });
        }
    });    
</script>
<script>
    function book123(value){
        var store = $("#book"+value).val();
        EmployeeDetail(store);
        function EmployeeDetail(store){
        $.ajax({
                type: 'GET',
                url: 'books/'+store,
                dataType: "json",
                success: function(data){
                    if(data){
                        $('#mySelect2'+value).find('option').remove();
                        for(i = 0; i < data.length; i++){ 
                                $('#mySelect2'+value).append($('<option>',{
                                    value: i,
                                    text : data[i][0].book 
                            }));
                        }
                    }
                }
            });
        }
    } 
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
<script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/jquery-ui.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/metismenu.min.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/feather.min.js"></script>
        <script src="assets/js/jquery.slimscroll.min.js"></script> 
        
        <!-- Plugins js -->
        <script src="plugins/moment/moment.js"></script>
        <script src="plugins/daterangepicker/daterangepicker.js"></script>
        <script src="plugins/select2/select2.min.js"></script>
        <script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
        <script src="plugins/timepicker/bootstrap-material-datetimepicker.js"></script>
        <script src="plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
        <script src="plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js"></script>

        <script src="assets/pages/jquery.forms-advanced.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>
@endsection