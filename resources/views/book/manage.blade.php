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
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        color: white;
        font-weight: 500;
        background: #9ba7ca;
        padding-bottom: 2px;
        padding-top: 2px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: white;
        cursor: pointer;
        display: inline-block;
        font-weight: bold;
        margin-right: 2px;
    }
    .select2-container .select2-search--inline .select2-search__field {
        padding-top: 3px;
        margin-bottom: 3px;
    }
    .displayBadgess{
        text-align :center;
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
                        <li class="breadcrumb-item active">Manage User Books</li>
                    </ol>
                </div>
                <h4 class="page-title">Manage User Books</h4>
            </div>
        </div>
    </div>
    <div class="row mt-2 mb-5">
        <div class="col-lg-6 mb-5" style="margin: 0 auto;">
            <div class="card">
                <div class="card-body p-5">
                    <div class="text-center mb-1">
                        <h3 class="py-3">Manage User Books</h3>
                    </div>
                    <div class="form-group row py-2">
                        <div class="col-sm-12 mb-1 mb-sm-0">
                            <form action="{{url('get-books')}}" method="post" id="chargesForm" enctype="multipart/form-data">
                            @csrf
                                <input hidden type="text" name="iddd" id="Iduser">
                            </form>
                            <label><b style="color: #6c757d">Users</b></label>
                            <select id="name" name="name" class="form-control select.custom-select" style="border: 1px solid #bfbfbf;" required>
                                <option selected disabled>Select User</option>  
                                @foreach($data as $name)
                                    @if(isset($check))
                                        @if($check == "Yes")
                                            <option <?php if($name['firstname'] == $currentuser) echo 'selected="selected"'; ?> id="{{ $name['lastname'] }}" value="{{ $name['id'] }} {{ $name['firstname'] }} {{ $name['lastname'] }}">{{ $name['firstname'] }} {{ $name['lastname'] }}</option>
                                        @endif
                                    @else
                                        <option id="{{ $name['lastname'] }}" value="{{ $name['id'] }} {{ $name['firstname'] }} {{ $name['lastname'] }}">{{ $name['firstname'] }} {{ $name['lastname'] }}</option>    
                                    @endif
                                @endforeach
                            </select>
                            <span id="StrengthDisp2" style="font-size: 13px !important;" class="badge displayBadgess text-light py-2 mt-2"></span>  
                        </div>
                    </div>
                    @if(isset($check))
                    @if($check == "Yes")
                    <div class="form-group row py-2">
                        <div class="col-sm-12">
                            <label><b style="color: #6c757d">Book Type</b></label>
                            <select data-id="1" id="bookname7" name="bookname[]" style="text-transform: capitalize; border: 1px solid #bfbfbf;" class="form-control select.custom-select" required>
                                <option selected disabled>Select Book</option>                                            
                                @foreach($SelectedBook as $bookname)
                                    <option value="{{ $bookname['id'] }} {{ $bookname['book'] }}">{{ $bookname['book'] }}</option>
                                @endforeach
                            </select>                            
                        </div>
                    </div>
                    @endif
                    @endif
                    <div hidden class="form-group row py-3 mt-5" style="margin-bottom: 0px;">
                        <div class="col-sm-12">
                            <button type="submit" style="border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white">Submit</button>                                
                        </div>
                    </div>                        
                </div>
            </div>
        </div>
    </div>
</div>
@include('bookmodel/updatemodel')
<script src="assets/js/customjquery.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script>
    $(document).ready(function(){ 
        $("#loader1").fadeOut(1200);
    });
     $('#name').on('change', function(){
        var name = $(this).val();
        const myArray = name.split(" ");
        var id = myArray[0];
        $("#Iduser").val(id);
        document.getElementById("chargesForm").submit();
    });
</script>
<script>
    let strengthBadge2 = document.getElementById('StrengthDisp2')
    $('#name').on('change', function(){
        strengthBadge2.style.display = 'none';
        var name = $(this).val();
        const myArray = name.split(" ");
        var id = myArray[0];
        var username =  myArray[1]+" "+myArray[2];
        sessionStorage.setItem("id", id);
        sessionStorage.setItem("username", username);
    });

    Employeename = document.getElementById('bookname7');
	Employeename.addEventListener("input", () => {
        var Employee = Employeename.value;
        var nameEmployee = $("#name").val();
        // if(nameEmployee == null){
        //     strengthBadge2.style.display = 'block'
        //     strengthBadge2.style.backgroundColor = '#cd3f3f'
        //     strengthBadge2.textContent = 'Please Select User'
        //     return false;
        // }
        const myArray = Employee.split(" ");
        var id = myArray[0];
        if(myArray[1]){
            var book = myArray[1];
        }
        if(myArray[2]){
            var book = myArray[1]+" "+myArray[2];
        }
        if(myArray[3]){
            var book = myArray[1]+" "+myArray[2]+" "+myArray[3];
        }
        if(myArray[4]){
            var book = myArray[1]+" "+myArray[2]+" "+myArray[3]+" "+myArray[4];
        }
        console.log("Id");
        console.log(id);
        if(id == 9){
            $('#9').modal('show');
            let personName = sessionStorage.getItem("id");
            let username = sessionStorage.getItem("username"); 
            $('#modellabel'+id).html(book+" Book");
            $('#nameUser'+id).html(username);
            $('#username'+id).val(personName);
            $('#bookname'+id).val(id);   
        }
        else if(id == 16){
            $('#16').modal('show');
            let personName = sessionStorage.getItem("id");
            let username = sessionStorage.getItem("username"); 
            $('#modellabel'+id).html(book+" Book");
            $('#nameUser'+id).html(username);
            $('#username'+id).val(personName);
            $('#bookname'+id).val(id);   
        }
        else if(id == 7){
            $('#7').modal('show');
            let personName = sessionStorage.getItem("id");
            let username = sessionStorage.getItem("username"); 
            $('#modellabel'+id).html(book+" Book");
            $('#nameUser'+id).html(username);
            $('#username'+id).val(personName);
            $('#bookname'+id).val(id);   
        }
        else if(id == 3){
            $('#3').modal('show');
            let personName = sessionStorage.getItem("id");
            let username = sessionStorage.getItem("username"); 
            $('#modellabel'+id).html(book+" Book");
            $('#nameUser'+id).html(username);
            $('#username'+id).val(personName);
            $('#bookname'+id).val(id);   
        }
        else if(id == 15){
            $('#15').modal('show');
            let personName = sessionStorage.getItem("id");
            let username = sessionStorage.getItem("username"); 
            $('#modellabel'+id).html(book+" Book");
            $('#nameUser'+id).html(username);
            $('#username'+id).val(personName);
            $('#bookname'+id).val(id);   
        }
        else if(id == 6){
            $('#6').modal('show');
            let personName = sessionStorage.getItem("id");
            let username = sessionStorage.getItem("username"); 
            $('#modellabel'+id).html(book+" Book");
            $('#nameUser'+id).html(username);
            $('#username'+id).val(personName);
            $('#bookname'+id).val(id);   
        }
        else if(id == 5){
            $('#5').modal('show');
            let personName = sessionStorage.getItem("id");
            let username = sessionStorage.getItem("username"); 
            $('#modellabel'+id).html(book+" Book");
            $('#nameUser'+id).html(username);
            $('#username'+id).val(personName);
            $('#bookname'+id).val(id);   
        }
        else if(id == 310){
            $('#310').modal('show');
            let personName = sessionStorage.getItem("id");
            let username = sessionStorage.getItem("username"); 
            $('#modellabel'+id).html(book+" Book");
            $('#nameUser'+id).html(username);
            $('#username'+id).val(personName);
            $('#bookname'+id).val(id);   
        }
        else if(id == 312){
            $('#312').modal('show');
            let personName = sessionStorage.getItem("id");
            let username = sessionStorage.getItem("username"); 
            $('#modellabel'+id).html(book+" Book");
            $('#nameUser'+id).html(username);
            $('#username'+id).val(personName);
            $('#bookname'+id).val(id);   
        }
        else if(id == 4){
            $('#4').modal('show');
            let personName = sessionStorage.getItem("id");
            let username = sessionStorage.getItem("username"); 
            $('#modellabel'+id).html(book+" Book");
            $('#nameUser'+id).html(username);
            $('#username'+id).val(personName);
            $('#bookname'+id).val(id);   
        }
        else if(id == 11){
            $('#11').modal('show');
            let personName = sessionStorage.getItem("id");
            let username = sessionStorage.getItem("username"); 
            $('#modellabel'+id).html(book+" Book");
            $('#nameUser'+id).html(username);
            $('#username'+id).val(personName);
            $('#bookname'+id).val(id);   
        }
        else if(id == 23){
            $('#23').modal('show');
            let personName = sessionStorage.getItem("id");
            let username = sessionStorage.getItem("username"); 
            $('#modellabel'+id).html(book+" Book");
            $('#nameUser'+id).html(username);
            $('#username'+id).val(personName);
            $('#bookname'+id).val(id);   
        }
        else if(id == 57){
            $('#57').modal('show');
            let personName = sessionStorage.getItem("id");
            let username = sessionStorage.getItem("username"); 
            $('#modellabel'+id).html(book+" Book");
            $('#nameUser'+id).html(username);
            $('#username'+id).val(personName);
            $('#bookname'+id).val(id);   
        }
        else if(id == 58){
            $('#58').modal('show');
            let personName = sessionStorage.getItem("id");
            let username = sessionStorage.getItem("username"); 
            $('#modellabel'+id).html(book+" Book");
            $('#nameUser'+id).html(username);
            $('#username'+id).val(personName);
            $('#bookname'+id).val(id);   
        }
        else if(id == 17){
            $('#17').modal('show');
            let personName = sessionStorage.getItem("id");
            let username = sessionStorage.getItem("username"); 
            $('#modellabel'+id).html(book+" Book");
            $('#nameUser'+id).html(username);
            $('#username'+id).val(personName);
            $('#bookname'+id).val(id);   
        }
        else if(id == 12){
            $('#12').modal('show');
            let personName = sessionStorage.getItem("id");
            let username = sessionStorage.getItem("username"); 
            $('#modellabel'+id).html(book+" Book");
            $('#nameUser'+id).html(username);
            $('#username'+id).val(personName);
            $('#bookname'+id).val(id);   
        }
        else if(id == 19){
            $('#19').modal('show');
            let personName = sessionStorage.getItem("id");
            let username = sessionStorage.getItem("username"); 
            $('#modellabel'+id).html(book+" Book");
            $('#nameUser'+id).html(username);
            $('#username'+id).val(personName);
            $('#bookname'+id).val(id);   
        }
        else if(id == 18){
            console.log(id);
            console.log(book);
            $('#18').modal('show');
            let personName = sessionStorage.getItem("id");
            let username = sessionStorage.getItem("username"); 
            $('#modellabel'+id).html(book+" Book");
            $('#nameUser'+id).html(username);
            $('#username'+id).val(personName);
            $('#bookname'+id).val(id);   
        }
        else if(id == 21){
            $('#21').modal('show');
            let personName = sessionStorage.getItem("id");
            let username = sessionStorage.getItem("username"); 
            $('#modellabel'+id).html(book+" Book");
            $('#nameUser'+id).html(username);
            $('#username'+id).val(personName);
            $('#bookname'+id).val(id);   
        }
        else if(id == 22){
            $('#22').modal('show');
            let personName = sessionStorage.getItem("id");
            let username = sessionStorage.getItem("username"); 
            $('#modellabel'+id).html(book+" Book");
            $('#nameUser'+id).html(username);
            $('#username'+id).val(personName);
            $('#bookname'+id).val(id);   
        }
        else if(id == 311){
            $('#311').modal('show');
            let personName = sessionStorage.getItem("id");
            let username = sessionStorage.getItem("username"); 
            $('#modellabel'+id).html(book+" Book");
            $('#nameUser'+id).html(username);
            $('#username'+id).val(personName);
            $('#bookname'+id).val(id);   
        } 
        else if(id == 45){
            $('#45').modal('show');
            let personName = sessionStorage.getItem("id");
            let username = sessionStorage.getItem("username"); 
            $('#modellabel'+id).html(book+" Book");
            $('#nameUser'+id).html(username);
            $('#username'+id).val(personName);
            $('#bookname'+id).val(id);   
        } 
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
            showConfirmButton: false,
			timer: 2000
        });
        break;
    }
@endif
</script>
@endsection