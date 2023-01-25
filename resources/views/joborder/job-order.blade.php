@extends( (Auth::user()->id == "2") ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<style>
    .dropify-wrapper{
        height: 130px;
    }
    .autocomplete{
        position: relative;
        display: inline-block;
    }
    #myInput{
        width: 100%;
        border: 1px solid #bfbfbf;
    }
    .autocomplete-items{
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        top: 100%;
        left: 5;
        right: 5;
        width: 92%;
        border-radius: 5px;
        overflow-y: scroll;
        height: 330%;
    }
    .autocomplete-items div{
        padding: 10px;
        cursor: pointer;
        background-color: #fff; 
        border-bottom: 1px solid #d4d4d4; 
    }
    .autocomplete-items div:hover{
        background-color: #e9e9e9; 
    }
    .autocomplete-active{
        background-color: DodgerBlue !important; 
        color: #ffffff; 
    }
    .dtp > .dtp-content{
        background: #fff;
        max-width: 300px;
        box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 10px 0 rgb(0 0 0 / 12%);
        max-height: 100%;
        position: relative;
        left: 50%;
    }
    .dtp .p10 > a{
        color: #fdfdfd;
        text-decoration: none;
    }
    .yourclass::-webkit-input-placeholder{
        color: #6c757d;
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
</style>
<!-- <div id="loader1" class="rotate" width="100" height="100"></div> -->
<div class="container-fluid px-5">
    <div class="row px-1">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Job Order</li>
                    </ol>
                </div>
                <h4 class="page-title">Job Order</h4>
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-lg-12 mb-5">
            <div class="card">
                <div class="card-body p-5">
                    <form action="{{url('job-order-create')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-2 mb-5">
                            <div class="col-sm-9 col-md-9 py-0">
                                <div class="form-group row py-0">
                                    <div class="col-sm-3 col-md-3 py-1">
                                        <label><b style="color: #6c757d;">Season</b></label>
                                        <input type="text" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" value="{{$joborderseason}}" id="season" name="season" readonly>
                                    </div>
                                    <div class="col-sm-5 py-1">
                                        <label><b style="color: #6c757d">Company</b></label>
                                        <select id="company" name="company" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="select2 form-control mb-3 custom-select" required>
                                            <option selected disabled>Select Company</option> 
                                            @foreach($company as $names)
                                                <option style="text-transform: capitalize" value="{{$names}}">{{$names}}</option>
                                            @endforeach  
                                        </select>
                                    </div>
                                    <div class="col-sm-2 col-md-2 py-1"><label><b style="color: #6c757d">Sales Order No</b></label>
                                        <select id="sono" name="sono" style="border: 1px solid #bfbfbf; text-transform: capitalize;" class="select2 form-control mb-3 custom-select" required>
                                            <option selected disabled>Sales Order No</option> 
                                            @foreach($color as $val)
                                                <option style="text-transform: capitalize;" value="{{$val}}">{{$val}}</option>
                                            @endforeach  
                                        </select>
                                    </div>
                                    <div class="col-sm-2 col-md-2 py-1">
                                        <label><b style="color: #6c757d">Article No</b></label>
                                        <select id="article" name="article" style="border: 1px solid #bfbfbf; text-transform: capitalize;" class="select2 form-control mb-3 custom-select" required>
                                            <option selected disabled>Article No</option> 
                                            @foreach($color as $val)
                                                <option style="text-transform: capitalize;" value="{{$val}}">{{$val}}</option>
                                            @endforeach  
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row py-0">
                                    <div class="col-sm-3 col-md-3 py-1">
                                        <label><b style="color: #6c757d">Department</b></label>
                                        <select id="department" name="department" style="border: 1px solid #bfbfbf; text-transform: capitalize;" class="select2 form-control mb-3 custom-select" required>
                                            <option selected disabled>Select Department</option> 
                                            <option value="Cutting">Cutting</option>
                                            <option value="Closing">Closing</option>
                                            <option value="Lasting">Lasting</option>
                                            <option value="Insole">Insole</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3 col-md-3 py-1">
                                        <label><b style="color: #6c757d">Purchase Order No</b></label>
                                        <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="product" name="product" placeholder="Purchase Order No" readonly>
                                    </div>
                                    <div class="col-sm-2 col-md-2 py-1"><label><b style="color: #6c757d">Customer Article No</b></label>
                                        <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="product" name="product" placeholder="Customer Article No" readonly>
                                    </div>
                                    <div class="col-sm-2 col-md-2 py-1"><label><b style="color: #6c757d">Category Type</b></label>
                                        <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="product" name="product" placeholder="Category Type" readonly>
                                    </div>
                                    <div class="col-sm-2 col-md-2 py-1"><label><b style="color: #6c757d">Size Range</b></label>
                                        <select id="sizeRange" name="sizeRange" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control custom-select" required>
                                            <option selected disabled>Select Size Range</option> 
                                            @foreach($sizerange as $val)
                                                <option style="text-transform: capitalize;" value="{{$val['description']}}">{{$val['description']}}</option>
                                            @endforeach  
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row py-0">
                                    <div class="col-sm-3 col-md-3 py-1">
                                        <label><b style="color: #6c757d">Remarks</b></label>
                                        <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="sample" name="sample" placeholder="Remarks" required>
                                    </div>
                                    <div class="col-sm-3 col-md-3 py-1"><label><b style="color: #6c757d">Method</b></label>
                                        <select id="last" name="last" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="select2 form-control mb-3 custom-select" required>
                                                <option style="text-transform: capitalize" value="0" selected>In-House</option>
                                                <option style="text-transform: capitalize" value="1">Outsource</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2 col-md-2 py-1">
                                        <label><b style="color: #6c757d">Delivery Date</b></label>
                                        <input hidden id="date1" type="text">
                                        <input hidden id="date2" type="text">
                                        <input type="text" class="form-control yourclass" style="border: 1px solid #bfbfbf;" placeholder="Select Date" id="mdate" name="date">
                                    </div>      
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 py-2">
                                <label><b style="color: #6c757d">Attachment</b></label><br>
                                <input type="file" name="image" id="input-file-now-custom-1" class="dropify" data-default-file="img/photos/23.jpg" required/>
                            </div>
                        </div>
                        <div id="JobOrderDiv">
                            <div id="JobOrderDiv66" class="form-group row py-2 px-2 mb-5 bg-dark" style="border-radius: 4px;">
                                <div class="col-sm-12 col-md-12 py-0 mt-3">
                                    <div class="form-group row mb-0">
                                        <div class="col-sm-2 text-center">
                                            <div class="alert alert-light border-0 py-2 mb-0" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                                <label class="mb-0 text-white" style="font-weight: 500;">Size Breakup</label>
                                            </div>  
                                        </div>
                                        <div class="col-sm-9 text-center">
                                        </div>
                                        <div class="col-sm-1 text-center">
                                            <button style="box-shadow: none; margin-top: -3px;" type="button" id="addJobOrder" class="btn btn-success btn-round px-4 w-100"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                                        </div>
                                    </div>
                                    <div class="form-group row py-0">
                                        <table class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead class="bg-dark text-white">
                                                <tr id="ccolorDivtr1">
                                                    <th class="text-white" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">Status</b></label></th>
                                                    <th class="text-white" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">Color</b></label></th>
                                                    <th class="text-white" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">Last No.</b></label></th>
                                                    <th class="text-white tdDiv" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">36</b></label></th>
                                                    <th class="text-white tdDiv" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">37</b></label></th>
                                                    <th class="text-white tdDiv" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">38</b></label></th>
                                                    <th class="text-white tdDiv" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">39</b></label></th>
                                                    <th class="text-white tdDiv" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">40</b></label></th>
                                                    <th class="text-white tdDiv" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">41</b></label></th>
                                                    <th class="text-white tdDiv" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">Total</b></label></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id="ccolorDivtr">
                                                    <td style="border-top: none; width: 12%;">
                                                        <select id="season" name="season" style="border: 1px solid #bfbfbf; text-transform: capitalize; width: -webkit-fill-available;" class="form-control custom-select" required>
                                                            <option selected disabled>Status</option> 
                                                            <option value="On Hold" style="color: red;">On Hold</option>
                                                            <option value="Good To Go" selected="selected">Good To Go</option>                                                    
                                                        </select>
                                                    </td>
                                                    <td style="border-top: none; width: 12%;">
                                                        <select id="season" name="season" style="border: 1px solid #bfbfbf; text-transform: capitalize; width: -webkit-fill-available;" class="form-control custom-select" required>
                                                            <option selected disabled>Select color</option> 
                                                            @foreach($color as $names)
                                                                <option style="text-transform: capitalize" value="{{$names}}">{{$names}}</option>
                                                            @endforeach  
                                                        </select>
                                                    </td>
                                                    <td style="border-top: none; width: 12%;">
                                                        <select id="season" name="season" style="border: 1px solid #bfbfbf; text-transform: capitalize; width: -webkit-fill-available;" class="form-control custom-select" required>
                                                            <option selected disabled>Select Last No</option> 
                                                            @foreach($last as $names)
                                                                <option style="text-transform: capitalize" value="{{$names['last_no']}}">{{$names['last_no']}}</option>
                                                            @endforeach  
                                                        </select>
                                                    </td>
                                                    <td class="tdDiv" style="border-top: none;">
                                                        <input type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence6">
                                                    </td>
                                                    <td class="tdDiv" style="border-top: none;">
                                                        <input type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence6">
                                                    </td>
                                                    <td class="tdDiv" style="border-top: none;">
                                                        <input type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence6">
                                                    </td>
                                                    <td class="tdDiv" style="border-top: none;">
                                                        <input type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence6">
                                                    </td>
                                                    <td class="tdDiv" style="border-top: none;">
                                                        <input type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence6">
                                                    </td>
                                                    <td class="tdDiv" style="border-top: none;">
                                                        <input type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence6">
                                                    </td>
                                                    <td class="tdDiv" style="border-top: none;">
                                                        <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence6" readonly>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-sm-2 text-center">
                                            <div class="alert alert-light border-0 py-2 mb-0" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                                <label class="mb-0 text-white" style="font-weight: 500;">Select Color</label>
                                            </div>  
                                        </div>
                                        <div class="col-sm-9 text-center">
                                        </div>
                                        <div class="col-sm-1 text-center">
                                        </div>
                                    </div>
                                    <div class="form-group row py-0">
                                        <table class="table dt-responsive nowrap text-center mb-0" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead class="bg-dark text-white">
                                                <tr>
                                                    <th class="text-white" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">RM Code</b></label></th>
                                                    <th class="text-white" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">Location</b></label></th>
                                                    <th class="text-white" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">Tool</b></label></th>
                                                    <th class="text-white" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">Die No</b></label></th>
                                                    <th class="text-white" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">Quantity</b></label></th>
                                                    <th class="text-white" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">Remarks</b></label></th>
                                                    <th class="text-white" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: transparent;">Total</b></label></th>
                                                </tr>
                                            </thead>
                                            <tbody id="colorDiv">                                           
                                                <tr>
                                                    <td style="border-top: none;">
                                                        <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="rmcode" placeholder="Select RM Code" name="rmcode[]">
                                                    </td>
                                                    <td style="border-top: none;">
                                                        <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="location" placeholder="Location" name="location[]">
                                                    </td>
                                                    <td style="border-top: none; width: 12%;">
                                                        <select id="tool" name="tool[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                                            <option selected disabled>Select Tool</option> 
                                                            <option value="DYE">Dye</option>
                                                            <option value="LASER">Laser</option>
                                                        </select>
                                                    </td>
                                                    <td style="border-top: none;">
                                                        <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" placeholder="Die No" id="dieno" name="dieno[]">
                                                    </td>
                                                    <td style="border-top: none;">
                                                        <input type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" placeholder="Quantity" id="qty" name="qty[]">
                                                    </td>
                                                    <td style="border-top: none;">
                                                        <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" placeholder="Remarks" id="remarks" name="remarks[]">
                                                    </td>
                                                    <td style="border-top: none; width: 8%;">
                                                        <button hidden style="box-shadow: none; margin-top: -3px;" type="button" class="btn btn-dark btn-round px-4 w-100" id="addColor43"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                                                        <button style="box-shadow: none; margin-top: -3px;" type="button" class="btn btn-success btn-round px-4 w-100" id="addColor"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mt-5">
                            <div class="col-sm-3 mb-1 mb-sm-0">
                            </div>
                            <div class="col-sm-6">
                                <button type="submit" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white">Submit</button>
                            </div>
                            <div class="col-sm-3" id="Hye">
                            <table><tbody></tbody></table>
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
<script src="assets/js/jobordernew.js"></script>
@include('model/upper')
@include('model/jorder')
<script>
$(document).ready(function(){ 
	$("#loader1").fadeOut(1200);
    window.sessionStorage.setItem("items", JSON.stringify(0));
    console.log(sessionStorage.getItem("items"));
    var i = 1;
    $('#addColor43').click(function(){
        $("#JobOrderDiv66").clone().attr('id','h2').appendTo('#JobOrderDiv');    
    });
    $('#addColor').click(function(){
        i++;
        $('#colorDiv').append(
                            '<tr id="row'+i+'">'+
                                '<td style="border-top: none;">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="rmcode'+i+'" placeholder="Select RM Code" name="rmcode[]">'+
                                '</td>'+
                                ' <td style="border-top: none;">'+
                                    '  <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="location'+i+'" placeholder="Location" name="location[]">'+
                                '</td>'+
                                '<td style="border-top: none; width: 12%;">'+
                                    '<select id="tool" name="tool[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>'+
                                        '<option selected disabled>Select Tool</option> '+
                                        '<option value="DYE">DYE</option>'+
                                        '<option value="LASER">LASER</option>'+
                                    '</select>'+
                                '</td>'+
                                '<td style="border-top: none;">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" placeholder="Die No" id="dieno'+i+'" name="dieno[]">'+
                                '</td>'+
                                '<td style="border-top: none;">'+
                                    '<input type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" placeholder="Quantity" id="qty'+i+'" name="qty[]">'+
                                '</td>'+
                                '<td style="border-top: none;">'+
                                    '<input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" placeholder="Remarks" id="remarks'+i+'" name="remarks[]">'+
                                '</td>'+
                                '<td style="border-top: none; width: 8%;">'+
                                    '<button style="box-shadow: none; margin-top: -3px;" type="button" class="btn btn-danger btn-round px-4 w-100 remove" id="'+i+'"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                '</td>'+
                            '</tr>');
    });
    $(document).on('click', '.remove', function(){
        var id = $(this).attr("id"); 
        $('#row'+id).remove();
    });
});
$(document).ready(function(){
	$(".btnSelect").on('click',function(){
        var count = $("#counter").val();
        var name = $("#name21").val();
		var currentRow = $(this).closest("tr");
		var col2 = currentRow.find("td:eq(1)").html();
        $("#exampleModalCenter").modal('hide');
        if(name == "upper"){
            $("#u_item_code"+count).val(col2);
            code = document.getElementById('u_item_code'+count).value;
        }
        else if(name == "linning"){
            $("#l_item_code"+count).val(col2);
            code = document.getElementById('l_item_code'+count).value;
        }
        else if(name == "stiching"){
            $("#st_item_code"+count).val(col2);
            code = document.getElementById('st_item_code'+count).value;
        }
        else if(name == "insole"){
            $("#i_item_code"+count).val(col2);
            code = document.getElementById('i_item_code'+count).value;
        }
        else if(name == "outsole"){
            $("#o_item_code"+count).val(col2);
            code = document.getElementById('o_item_code'+count).value;
        }
        else if(name == "socks"){
            $("#s_item_code"+count).val(col2);
            code = document.getElementById('s_item_code'+count).value;
        }
        else if(name == "genral"){
            $("#g_item_code"+count).val(col2);
            code = document.getElementById('g_item_code'+count).value;
        }
        $.ajax({
            type: 'GET',
            url: 'itemcode/'+code,
            dataType: "json",
            success: function(data){
                console.log(data);
                if(name == "upper"){
                    $("#u_description"+count).val(data.desc);
                    $("#u_uom"+count).val(data.uom);
                }
                else if(name == "linning"){
                    $("#l_description"+count).val(data.desc);
                    $("#l_uom"+count).val(data.uom);
                }
                else if(name == "stiching"){
                    $("#st_description"+count).val(data.desc);
                    $("#st_uom"+count).val(data.uom);
                }
                else if(name == "insole"){
                    $("#i_description"+count).val(data.desc);
                    $("#i_uom"+count).val(data.uom);
                }
                else if(name == "outsole"){
                    $("#o_description"+count).val(data.desc);
                    $("#o_uom"+count).val(data.uom);
                }
                else if(name == "socks"){
                    $("#s_description"+count).val(data.desc);
                    $("#s_uom"+count).val(data.uom);
                }
                else if(name == "genral"){
                    $("#g_description"+count).val(data.desc);
                    $("#g_uom"+count).val(data.uom);
                }
            }
        });
	});
    $(".btnSelectuser1").on('click',function(){
        var currentRow = $(this).closest("tr");
		var col2 = currentRow.find("td:eq(1)").html();
        $("#article").val(col2);
        $("#exampleModalCenter2121").modal('hide');
    });
});
</script>
<script>
    $(".ModelBtn").click(function(){
        var id = $(this).attr("data-id");
        $("#counter").val(id);
    });
</script>
<script>
    function myFunction1(value,name12){
        console.log("Function");
        if(value == 1){
            $("#counter").val(value);
            $("#name21").val(name12);
        }
        else{
            $("#counter").val(value);
            $("#name21").val(name12.id);
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
<script>
    $('#season').on('change', function(){
        var addNo = '0';
        var season = $(this).val();
        const first = season.charAt(0);
        const seclast = season.charAt(season.length - 2);
        const istlast = season.charAt(season.length - 1);
        var date1 = $("#date1").val();
        var date2 = $("#date2").val();
        if(date2.length == 1){
            addNo = '00';
        }
        if(date2.length == 2){
            addNo = '0';
        }
        if(date2.length == 3){
            addNo = '';
        }
        $("#sequence").val(first+"-"+seclast+istlast+"/"+date1+"/"+addNo+date2);
        $("#sq_no").val(addNo+date2);
    });
    $('#article').on('change', function(){
        var article = $(this).val();
    });
    let strengthBadge2 = document.getElementById('StrengthDisp2')
    $("#selectsequence").on('click',function(){
                    var article1 = 0;
                    article1 = $('#article').val();
                    var season = $('#season').val();
                    if(season == null && article1 == 0){
                        strengthBadge2.style.display = 'block'
                        strengthBadge2.style.backgroundColor = '#cd3f3f'
                        strengthBadge2.textContent = 'Please Select Season & Article Code'
                    }
                    else if(season == null){
                        strengthBadge2.style.display = 'block'
                        strengthBadge2.style.backgroundColor = '#cd3f3f'
                        strengthBadge2.textContent = 'Please Select Season'
                    }
                    else if(article1 == 0){
                        strengthBadge2.style.display = 'block'
                        strengthBadge2.style.backgroundColor = '#cd3f3f'
                        strengthBadge2.textContent = 'Please Select Article Code'
                    }
                    else if(season && article1){
                        strengthBadge2.style.display = 'none'
                        // $("#sequence").val(season+"-"+article1);
                    }
                });
</script>
<script>
    $('#sizeRange').on('change', function(){
        $('.tdDiv').remove();
        $('.tdDiv1').remove();
        var sizeRange = $(this).val();
        const myArray = sizeRange.split("-");
        const Sizelength = Math.abs(myArray[1] - myArray[0]);
        var all = [];
        for(i = 0; i <= Sizelength; i++){
            let element = Number(myArray[0])+i;
            all.push(element);
            $('#ccolorDivtr1').append('<th class="text-white tdDiv" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">'+element+'</b></label></th>');
            $('#ccolorDivtr').append('<td class="tdDiv" style="border-top: none;">'+
                                        '<input type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence7">'+
                                    '</td>');
        }
        $('#ccolorDivtr1').append('<th class="text-white tdDiv" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">Total</b></label></th>');
        $('#ccolorDivtr').append('<td class="tdDiv" style="border-top: none;">'+
                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence2">'+
                                '</td>');
        const total = Number(sessionStorage.getItem("items"))+1;
        const length = sessionStorage.getItem("items");
        if(sessionStorage.getItem("items") != 0){
            for(ii = length; ii <= total; ii++){
                for(i = 0; i <= Sizelength; i++){
                    let element = Number(myArray[0])+i;
                    all.push(element);
                    $('#colorDivtr1'+ii+'').append('<th class="text-white tdDiv1" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">'+element+'</b></label></th>');
                    $('#colorDivtr'+ii+'').append('<td class="tdDiv1" style="border-top: none;">'+
                                                    '<input type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence1">'+
                                                '</td>');
                }
                $('#colorDivtr1'+ii+'').append('<th class="text-white tdDiv1" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">Total</b></label></th>');
                $('#colorDivtr'+ii+'').append('<td class="tdDiv1" style="border-top: none;">'+
                                                '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence5">'+
                                            '</td>');
            }
        }
    });
    $('#company').on('change', function(){
        var company = $(this).val();
        $.ajax({
            type: 'GET',
            url: 'companydata/'+company,
            dataType: "json",
            success: function(data){
                if(data){
                    console.log("Data");
                    console.log(data);
                    for(j=1; j<=data.color.length; j++){
                        var $dataToBeAppended = `<option>`+data.color[j]+`</option>`;
                        $("#seasonyes"+i).append($dataToBeAppended);
                    }
                    for(j=1; j<=data.last.length; j++){
                        var $dataToBeAppended1 = `<option>`+data.last[j]+`</option>`;
                        $("#seasonyes1"+i).append($dataToBeAppended1);
                    }
                }
            }
        });
    });
</script>
@endsection