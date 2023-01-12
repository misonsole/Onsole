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
                        <li class="breadcrumb-item active">Set of Books 2</li>
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
                        <h3 class="py-3">Set of Books 3</h3>
                    </div>
                    <form action="#">
                        <div class="form-group row py-2">
                            <div class="col-sm-3 mb-1 mb-sm-0">
                                <label><b style="color: #6c757d">Users</b></label>
                                <select id="name" name="name" class="form-control select.custom-select" style="border: 1px solid #bfbfbf;" required>
                                    @foreach($data as $name)
                                        <option id="{{ $name->lastname }}" value="{{ $name->id }}">{{ $name->firstname }} {{ $name->lastname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row py-2">
                            <div class="col-sm-3">
                                <label><b style="color: #6c757d">Book Type</b></label>
                                <select data-id="1" id="bookname7" name="bookname[]" style="text-transform: capitalize; border: 1px solid #bfbfbf;" class="form-control select.custom-select" required>
                                    <option selected disabled>Select Book</option>                                            
                                    @foreach($SelectedBook as $bookname)
                                        <option value="{{ $bookname['id'] }} {{ $bookname['book'] }}">{{ $bookname['book'] }}</option>
                                    @endforeach
                                </select>                            
                            </div>
                            <div class="col-sm-9" style="display: none;" id="16">
                                <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label16" style="color: #6c757d"></b></label> Books</b></label>
                                <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect16" name="book[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                </select> 
                            </div>
                            <div class="col-sm-9" style="display: none;" id="7">
                                <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label7" style="color: #6c757d"></b></label> Books</b></label>
                                <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect7" name="book[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                </select> 
                            </div>
                            <div class="col-sm-9" style="display: none;" id="3">
                                <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label3" style="color: #6c757d"></b></label> Books</b></label>
                                <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect3" name="book[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                </select> 
                            </div>
                            <div class="col-sm-9" style="display: none;" id="9">
                                <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label9" style="color: #6c757d"></b></label> Books</b></label>
                                <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect9" name="book[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                </select> 
                            </div>
                            <div class="col-sm-9" style="display: none;" id="15">
                                <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label15" style="color: #6c757d"></b></label> Books</b></label>
                                <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect15" name="book[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                </select> 
                            </div>
                            <div class="col-sm-9" style="display: none;" id="6">
                                <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label6" style="color: #6c757d"></b></label> Books</b></label>
                                <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect6" name="book[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                </select> 
                            </div>
                            <div class="col-sm-9" style="display: none;" id="5">
                                <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label5" style="color: #6c757d"></b></label> Books</b></label>
                                <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect5" name="book[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                </select> 
                            </div>
                            <div class="col-sm-9" style="display: none;" id="310">
                                <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label310" style="color: #6c757d"></b></label> Books</b></label>
                                <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect310" name="book[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                </select> 
                            </div>
                            <div class="col-sm-9" style="display: none;" id="312">
                                <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label312" style="color: #6c757d"></b></label> Books</b></label>
                                <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect312" name="book[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                </select> 
                            </div>
                            <div class="col-sm-9" style="display: none;" id="4">
                                <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label4" style="color: #6c757d"></b></label> Books</b></label>
                                <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect4" name="book[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                </select> 
                            </div>
                            <div class="col-sm-9" style="display: none;" id="11">
                                <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label11" style="color: #6c757d"></b></label> Books</b></label>
                                <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect11" name="book[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                </select> 
                            </div>
                            <div class="col-sm-9" style="display: none;" id="23">
                                <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label23" style="color: #6c757d"></b></label> Books</b></label>
                                <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect23" name="book[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                </select> 
                            </div>
                            <div class="col-sm-9" style="display: none;" id="57">
                                <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label57" style="color: #6c757d"></b></label> Books</b></label>
                                <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect57" name="book[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                </select> 
                            </div>
                            <div class="col-sm-9" style="display: none;" id="58">
                                <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label58" style="color: #6c757d"></b></label> Books</b></label>
                                <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect58" name="book[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                </select> 
                            </div>
                            <div class="col-sm-9" style="display: none;" id="17">
                                <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label17" style="color: #6c757d"></b></label> Books</b></label>
                                <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect17" name="book[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                </select> 
                            </div>
                            <div class="col-sm-9" style="display: none;" id="12">
                                <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label12" style="color: #6c757d"></b></label> Books</b></label>
                                <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect12" name="book[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                </select> 
                            </div>
                            <div class="col-sm-9" style="display: none;" id="19">
                                <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label19" style="color: #6c757d"></b></label> Books</b></label>
                                <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect19" name="book[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                </select> 
                            </div>
                            <div class="col-sm-9" style="display: none;" id="18">
                                <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label18" style="color: #6c757d"></b></label> Books</b></label>
                                <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect18" name="book[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                </select> 
                            </div>
                            <div class="col-sm-9" style="display: none;" id="21">
                                <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label21" style="color: #6c757d"></b></label> Books</b></label>
                                <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect21" name="book[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                </select> 
                            </div>
                            <div class="col-sm-9" style="display: none;" id="22">
                                <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label22" style="color: #6c757d"></b></label> Books</b></label>
                                <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect22" name="book[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                </select> 
                            </div>
                            <div class="col-sm-9" style="display: none;" id="311">
                                <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label311" style="color: #6c757d"></b></label> Books</b></label>
                                <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect311" name="book[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                </select> 
                            </div>
                            <div class="col-sm-9" style="display: none;" id="45">
                                <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label45" style="color: #6c757d"></b></label> Books</b></label>
                                <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect45" name="book[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                </select> 
                            </div>
                            <div class="col-sm-1" hidden>
                                <label><b style="color: #6c757d">&nbsp;</b></label>
                                <button type="button" id="addobj" style="border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white"><i class="ti-plus"></i></button>
                            </div>
                        </div>
                        <div class="form-group row py-3 mt-5" style="margin-bottom: 0px;">
                            <div class="col-sm-12">
                                <button type="submit" style="border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white">Submit</button>                                
                                <div id="objtable">
                                </div>
                                <div class="checkbox checkbox-success form-check-inline">
                                    <input type="checkbox" id="inlineCheckbox2" value="option1" checked="">
                                    <label id="label" for="inlineCheckbox2"> Inline Two </label>
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
    Employeename = document.getElementById('bookname7');
	Employeename.addEventListener("input", () => {
    var Employee = Employeename.value;
    const myArray = Employee.split(" ");
    var id = myArray[0];
    if(myArray[2]){
        var book = myArray[1]+" "+myArray[2];
    }
    if(myArray[3]){
        var book = myArray[1]+" "+myArray[2]+" "+myArray[3];
    }
    if(myArray[4]){
        var book = myArray[1]+" "+myArray[2]+" "+myArray[3]+" "+myArray[4];
    }
    console.log(id);
    console.log(book);    
    let personName = sessionStorage.getItem("lastname");
    $('#'+personName).css("display", "none");
    EmployeeDetail(id);
    function EmployeeDetail(id){
        $.ajax({
                type: 'GET',
                url: 'books/'+id,
                dataType: "json",
                success: function(data){
                    if(data){
                        $('#'+id).css("display", "block");
                        $('#label'+id).html(book);
                        sessionStorage.setItem("lastname", id);
                        $("#btn_approved").css("display", "none");
                        $('#mySelect'+id).find('option').remove();
                        for(i = 0; i < data.length; i++){ 
                            $('#objtable').append('<input id="name" name="memberName[]" value="Yes" class="form-control" required>');
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
@endsection