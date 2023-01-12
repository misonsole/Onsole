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
                        <h3 class="py-3">Set of Books 2</h3>
                    </div>
                    <form action="{{url('store-books')}}" method="post" enctype="multipart/form-data">
                    @csrf
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
                        <div id="objtable">
                            <div class="form-group row py-2">
                                <div class="col-sm-3">
                                    <label><b style="color: #6c757d">Book Type</b></label>
                                    <select id="bookname7" name="bookname[]" style="text-transform: capitalize; border: 1px solid #bfbfbf;" class="form-control select.custom-select" required>
                                        <option selected disabled>Select Book</option>                                            
                                        @foreach($SelectedBook as $bookname)
                                            <option value="{{ $bookname['id'] }} {{ $bookname['book'] }}">{{ $bookname['book'] }}</option>
                                        @endforeach
                                    </select>                            
                                </div>
                                <div class="col-sm-8" style="display: none;" id="16">
                                    <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label16" style="color: #6c757d"></b></label> Books</b></label>
                                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect16" name="PurchaseReturns[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                    </select> 
                                </div>
                                <div class="col-sm-8" style="display: none;" id="7">
                                    <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label7" style="color: #6c757d"></b></label> Books</b></label>
                                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect7" name="PurchaseInvoice[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                    </select> 
                                </div>
                                <div class="col-sm-8" style="display: none;" id="3">
                                    <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label3" style="color: #6c757d"></b></label> Books</b></label>
                                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect3" name="PurchaseOrder[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                    </select> 
                                </div>
                                <div class="col-sm-8" style="display: none;" id="9">
                                    <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label9" style="color: #6c757d"></b></label> Books</b></label>
                                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect9" name="SalesOrder[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                    </select> 
                                </div>
                                <div class="col-sm-8" style="display: none;" id="15">
                                    <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label15" style="color: #6c757d"></b></label> Books</b></label>
                                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect15" name="SalesReturns[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                    </select> 
                                </div>
                                <div class="col-sm-8" style="display: none;" id="6">
                                    <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label6" style="color: #6c757d"></b></label> Books</b></label>
                                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect6" name="SalesInvoice[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                    </select> 
                                </div>
                                <div class="col-sm-8" style="display: none;" id="5">
                                    <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label5" style="color: #6c757d"></b></label> Books</b></label>
                                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect5" name="StoreIssueNote[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                    </select> 
                                </div>
                                <div class="col-sm-8" style="display: none;" id="310">
                                    <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label310" style="color: #6c757d"></b></label> Books</b></label>
                                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect310" name="StoreIssueNoteOnsole[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                    </select> 
                                </div>
                                <div class="col-sm-8" style="display: none;" id="312">
                                    <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label312" style="color: #6c757d"></b></label> Books</b></label>
                                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect312" name="StoreIssueNoteOutSource[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                    </select> 
                                </div>
                                <div class="col-sm-8" style="display: none;" id="4">
                                    <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label4" style="color: #6c757d"></b></label> Books</b></label>
                                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect4" name="GoodsReceiptNote[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                    </select> 
                                </div>
                                <div class="col-sm-8" style="display: none;" id="11">
                                    <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label11" style="color: #6c757d"></b></label> Books</b></label>
                                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect11" name="IssueReturns[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                    </select> 
                                </div>
                                <div class="col-sm-8" style="display: none;" id="23">
                                    <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label23" style="color: #6c757d"></b></label> Books</b></label>
                                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect23" name="ItemAdjustments[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                    </select> 
                                </div>
                                <div class="col-sm-8" style="display: none;" id="57">
                                    <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label57" style="color: #6c757d"></b></label> Books</b></label>
                                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect57" name="OtherPayment[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                    </select> 
                                </div>
                                <div class="col-sm-8" style="display: none;" id="58">
                                    <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label58" style="color: #6c757d"></b></label> Books</b></label>
                                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect58" name="OtherReceipt[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                    </select> 
                                </div>
                                <div class="col-sm-8" style="display: none;" id="17">
                                    <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label17" style="color: #6c757d"></b></label> Books</b></label>
                                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect17" name="Payments[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                    </select> 
                                </div>
                                <div class="col-sm-8" style="display: none;" id="12">
                                    <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label12" style="color: #6c757d"></b></label> Books</b></label>
                                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect12" name="RMAOutwards[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                    </select> 
                                </div>
                                <div class="col-sm-8" style="display: none;" id="19">
                                    <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label19" style="color: #6c757d"></b></label> Books</b></label>
                                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect19" name="RMAInwards[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                    </select> 
                                </div>
                                <div class="col-sm-8" style="display: none;" id="18">
                                    <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label18" style="color: #6c757d"></b></label> Books</b></label>
                                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect18" name="Receipts[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                    </select> 
                                </div>
                                <div class="col-sm-8" style="display: none;" id="21">
                                    <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label21" style="color: #6c757d"></b></label> Books</b></label>
                                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect21" name="TransferIssues[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                    </select> 
                                </div>
                                <div class="col-sm-8" style="display: none;" id="22">
                                    <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label22" style="color: #6c757d"></b></label> Books</b></label>
                                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect22" name="TransferReceipts[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                    </select> 
                                </div>
                                <div class="col-sm-8" style="display: none;" id="311">
                                    <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label311" style="color: #6c757d"></b></label> Books</b></label>
                                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect311" name="OutSourceJobCard[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                    </select> 
                                </div>
                                <div class="col-sm-8" style="display: none;" id="45">
                                    <label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label45" style="color: #6c757d"></b></label> Books</b></label>
                                    <select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect45" name="WorkInProcess[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">
                                    </select> 
                                </div>
                                <div class="col-sm-1" style="display: none;" id="plusbtn">
                                    <label><b style="color: #6c757d">&nbsp;</b></label><br>
                                    <button id="addobj" type="button" class="btn btn-outline-primary btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
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
    $('#bookname7').on('change', function(){
    var season = $(this).val();
    var Employee = season;
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
                        $('#plusbtn').css("display", "block");
                        $('#label'+id).html(book);
                        sessionStorage.setItem("lastname", id);
                        $("#btn_approved").css("display", "none");
                        $('#mySelect'+id).find('option').remove();
                        for(i = 0; i < data.length; i++){ 
                                $('#mySelect'+id).append($('<option>',{
                                    value: data[i][0].book,
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
    var i = 1;
        $('#addobj').click(function(){
            i++;
            $('#objtable').append('<div id="row'+i+'" name="row_count">'+
                                    '<div class="form-group row py-2">'+
                                        '<div class="col-sm-3">'+
                                            '<label><b style="color: #6c757d">Book Type</b></label>'+
                                            '<select data-id="1" onchange="myFunction()" id="bookname2" name="bookname1[]" style="text-transform: capitalize; border: 1px solid #bfbfbf;" class="form-control select.custom-select" required>'+
                                                '<option selected disabled>Select Book</option>'+                                            
                                                '@foreach($SelectedBook as $bookname)'+
                                                    '<option value="{{ $bookname['id'] }} {{ $bookname['book'] }}">{{ $bookname['book'] }}</option>'+
                                                '@endforeach'+
                                            '</select>'+                            
                                        '</div>'+
                                        '<div class="col-sm-8" style="display: none;" id="16'+i+'">'+
                                            '<label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label16'+i+'" style="color: #6c757d"></b></label> Books</b></label>'+
                                            '<select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect16'+i+'" name="PurchaseReturns[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">'+
                                            '</select>'+ 
                                        '</div>'+
                                        '<div class="col-sm-8" style="display: none;" id="7'+i+'">'+
                                            '<label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label7'+i+'" style="color: #6c757d"></b></label> Books</b></label>'+
                                            '<select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect7'+i+'" name="PurchaseInvoice[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">'+
                                            '</select>'+ 
                                        '</div>'+
                                        '<div class="col-sm-8" style="display: none;" id="3'+i+'">'+
                                            '<label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label3'+i+'" style="color: #6c757d"></b></label> Books</b></label>'+
                                            '<select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect3'+i+'" name="PurchaseOrder[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">'+
                                            '</select>'+ 
                                        '</div>'+
                                        '<div class="col-sm-8" style="display: none;" id="9'+i+'">'+
                                            '<label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label9'+i+'" style="color: #6c757d"></b></label> Books</b></label>'+
                                            '<select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2" id="mySelect9'+i+'" name="SalesOrder[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">'+
                                            '</select>'+ 
                                        '</div>'+
                                        '<div class="col-sm-8" style="display: none;" id="15'+i+'">'+
                                            '<label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label15'+i+'" style="color: #6c757d"></b></label> Books</b></label>'+
                                            '<select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect15'+i+'" name="SalesReturns[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">'+
                                            '</select>'+ 
                                        '</div>'+
                                        '<div class="col-sm-8" style="display: none;" id="6'+i+'">'+
                                            '<label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label6'+i+'" style="color: #6c757d"></b></label> Books</b></label>'+
                                            '<select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect6'+i+'" name="SalesInvoice[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">'+
                                            '</select>'+ 
                                        '</div>'+
                                        '<div class="col-sm-8" style="display: none;" id="5'+i+'">'+
                                            '<label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label5'+i+'" style="color: #6c757d"></b></label> Books</b></label>'+
                                            '<select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect5'+i+'" name="StoreIssueNote[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">'+
                                            '</select>'+ 
                                        '</div>'+
                                        '<div class="col-sm-8" style="display: none;" id="310'+i+'">'+
                                            '<label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label310'+i+'" style="color: #6c757d"></b></label> Books</b></label>'+
                                            '<select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect310'+i+'" name="StoreIssueNoteOnsole[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">'+
                                            '</select>'+ 
                                        '</div>'+
                                        '<div class="col-sm-8" style="display: none;" id="312'+i+'">'+
                                            '<label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label312'+i+'" style="color: #6c757d"></b></label> Books</b></label>'+
                                            '<select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect312'+i+'" name="StoreIssueNoteOutSource[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">'+
                                            '</select>'+ 
                                        '</div>'+
                                        '<div class="col-sm-8" style="display: none;" id="4'+i+'">'+
                                            '<label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label4'+i+'" style="color: #6c757d"></b></label> Books</b></label>'+
                                            '<select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect4'+i+'" name="GoodsReceiptNote[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">'+
                                            '</select>'+ 
                                        '</div>'+
                                        '<div class="col-sm-8" style="display: none;" id="11'+i+'">'+
                                            '<label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label11'+i+'" style="color: #6c757d"></b></label> Books</b></label>'+
                                            '<select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect11'+i+'" name="IssueReturns[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">'+
                                            '</select>'+ 
                                        '</div>'+
                                        '<div class="col-sm-8" style="display: none;" id="23'+i+'">'+
                                            '<label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label23'+i+'" style="color: #6c757d"></b></label> Books</b></label>'+
                                            '<select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect23'+i+'" name="ItemAdjustments[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">'+
                                            '</select>'+ 
                                        '</div>'+
                                        '<div class="col-sm-8" style="display: none;" id="57'+i+'">'+
                                            '<label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label57'+i+'" style="color: #6c757d"></b></label> Books</b></label>'+
                                            '<select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect57'+i+'" name="OtherPayment[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">'+
                                            '</select>'+ 
                                        '</div>'+
                                        '<div class="col-sm-8" style="display: none;" id="58'+i+'">'+
                                            '<label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label58'+i+'" style="color: #6c757d"></b></label> Books</b></label>'+
                                            '<select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect58'+i+'" name="OtherReceipt[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">'+
                                            '</select>'+ 
                                        '</div>'+
                                        '<div class="col-sm-8" style="display: none;" id="17'+i+'">'+
                                            '<label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label17'+i+'" style="color: #6c757d"></b></label> Books</b></label>'+
                                            '<select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect17'+i+'" name="Payments[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">'+
                                            '</select>'+ 
                                        '</div>'+
                                        '<div class="col-sm-8" style="display: none;" id="12'+i+'">'+
                                            '<label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label12'+i+'" style="color: #6c757d"></b></label> Books</b></label>'+
                                            '<select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect12'+i+'" name="RMAOutwards[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">'+
                                            '</select>'+ 
                                        '</div>'+
                                        '<div class="col-sm-8" style="display: none;" id="19'+i+'">'+
                                            '<label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label19'+i+'" style="color: #6c757d"></b></label> Books</b></label>'+
                                            '<select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect19'+i+'" name="RMAInwards[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">'+
                                            '</select>'+ 
                                        '</div>'+
                                        '<div class="col-sm-8" style="display: none;" id="18'+i+'">'+
                                            '<label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label18'+i+'" style="color: #6c757d"></b></label> Books</b></label>'+
                                            '<select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect18'+i+'" name="Receipts[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">'+
                                            '</select>'+ 
                                        '</div>'+
                                        '<div class="col-sm-8" style="display: none;" id="21'+i+'">'+
                                            '<label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label21'+i+'" style="color: #6c757d"></b></label> Books</b></label>'+
                                            '<select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect21'+i+'" name="TransferIssues[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">'+
                                            '</select>'+ 
                                        '</div>'+
                                        '<div class="col-sm-8" style="display: none;" id="22'+i+'">'+
                                            '<label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label22'+i+'" style="color: #6c757d"></b></label> Books</b></label>'+
                                            '<select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect22'+i+'" name="TransferReceipts[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">'+
                                            '</select>'+ 
                                        '</div>'+
                                        '<div class="col-sm-8" style="display: none;" id="311'+i+'">'+
                                            '<label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label311'+i+'" style="color: #6c757d"></b></label> Books</b></label>'+
                                            '<select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect311'+i+'" name="OutSourceJobCard[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">'+
                                            '</select>'+
                                        '</div>'+
                                        '<div class="col-sm-8" style="display: none;" id="45'+i+'">'+
                                            '<label style="margin-bottom: 0.1rem;"><b style="color: #6c757d"> <label for=""><b id="label45'+i+'" style="color: #6c757d"></b></label> Books</b></label>'+
                                            '<select class="select2 mb-3 select2-multiple form-control text-dark px-2 py-2 bg-dark" id="mySelect45'+i+'" name="WorkInProcess[]" style="border: 1px solid #bfbfbf; width: 100%; padding-top: 20px;" multiple="multiple" data-placeholder="   Choose Books">'+
                                            '</select>'+
                                        '</div>'+
                                        '<div class="col-sm-1" style="display: none;" id="minusbtn">'+
                                            '<label><b style="color: #6c757d">&nbsp;</b></label><br>'+
                                            '<button type="button" class="remove_m btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                        '</div>'+
                                    '</div>'+
                                    '</div>');
    });
    $(document).on('click', '.remove_m', function(){
        var id = $(this).attr("id"); 
        $('#row'+id+'').remove();
    });
});
</script>
<script>
function myFunction() {
    var i = 1;
    i++;
    var season = $("#bookname2").val();
    var Employee = season;
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
    console.log("Final Id");
    console.log(id); 
    console.log("Final i");
    console.log(i);    
    let personName = sessionStorage.getItem("lastnamee");
    $('#'+personName).css("display", "none");
    EmployeeDetail(id);
    function EmployeeDetail(id){
        $.ajax({
                type: 'GET',
                url: 'books/'+id,
                dataType: "json",
                success: function(data){
                    if(data){
                        console.log("Ajax");
                        console.log(data);  
                        $('#'+id+i).css("display", "block");
                        $('#minusbtn').css("display", "block");
                        $('#label'+id+i).html(book);
                        sessionStorage.setItem("lastnamee", id+i);
                        $("#btn_approved").css("display", "none");
                        $('#mySelect'+id+i).find('option').remove();
                        for(j = 0; j < data.length; j++){ 
                                $('#mySelect'+id+i).append($('<option>',{
                                    value: data[j][0].book,
                                    text : data[j][0].book 
                            }));
                        }
                    }
                }
            });
        }
}
</script>
<!-- <script>
    var i = 2;
    Employeename = document.getElementById('bookname'+i);
    console.log("Employeename");
    console.log(Employeename);
    $('#bookname2').on('change', function(){
    console.log("season 2");
    var season = $(this).val();
    console.log("season");
    console.log(season);
    var Employee = season;
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
                        $('#plusbtn').css("display", "block");
                        $('#label'+id).html(book);
                        sessionStorage.setItem("lastname", id);
                        $("#btn_approved").css("display", "none");
                        $('#mySelect'+id).find('option').remove();
                        for(i = 0; i < data.length; i++){ 
                                $('#mySelect'+id).append($('<option>',{
                                    value: data[i][0].book,
                                    text : data[i][0].book 
                            }));
                        }
                    }
                }
            });
        }
    });    
</script> -->
@endsection