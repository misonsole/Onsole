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
    .displayBadge
    {
        display: none; 
        text-align :center;
    }
	.displayBadges
    {
        text-align :center;
    }
    .toggle 
    {
        background: none;
        border: none;
        color: grey;
        font-weight: 400;
        position: absolute;
        right: 1.30em;
        top: 0.85em;
        z-index: 9;
    }
    .fa
    {
        font-size: 1.1rem;
    }
    .table td
    {
        border: none;
    }
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
    <div class="row px-1">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('objective-manage-new')}}">Manage Users</a></li>
                        <li class="breadcrumb-item active">Create Objective</li>
                    </ol>
                </div>
                <h4 class="page-title">Create Objective</h4>
            </div>
        </div>
    </div>
    <div class="row">
		<div class="col-md-12 col-xl-12 mb-5" style="margin: 0 auto;">
			<div class="card mb-5 p-3">
				<div class="card-body h-100 px-5">
					<div class="text-center mt-5">
						<h2 style="color: #6c757d">Create Objective</h2>
					</div>
                    <form action="{{url('store-form-objective')}}" method="post" enctype="multipart/form-data" class="w-100">
                    @csrf
                    <div>
                        <div class="form-group row mb-3 mt-5">
                            <div class="col-md-2">
                                <label for="exampleInputEmail1"><strong>Name</strong></label>
                                <input readonly id="name" name="memberName[]" class="form-control" value="{{$name}}" required hidden>
                                <input readonly id="empName" name="memberName2[]" class="form-control" value="{{$empName}}" required>
                                <input hidden type="text" placeholder="Name" id="Memberid" value="2" class="form-control" name="Memberid[]">
                            </div>
                            <div class="col-md-2">
                                <label for="exampleInputEmail1"><strong>Department</strong></label>
                                <input readonly type="text" id="dep" value="{{$department}}" class="form-control" name="memberDepartment[]" required>  
                            </div>
                            <div class="col-md-2" hidden>
                                <label for="exampleInputEmail1"><strong>Lead Nane</strong></label>
                                <input readonly type="text" id="dep" value="{{$leadname}}" class="form-control" name="leadname[]" required>   
                            </div>
                            <div class="col-md-5">
                                <label for="exampleInputEmail1"><strong>Objective Title</strong></label>
                                <input required type="text" id="objTitle" placeholder="Title" class="form-control" name="objTitle[]">
                            </div>
                            <div class="col-md-2">
                                <label for="exampleInputEmail1"><strong>Weightage</strong></label>                                
                                <div class="form-group"> 
                                    <div class="input-group">
                                        <input type="number" placeholder="Weightage" class="form-control class1 sum_item yourclass" id="objWeightage1" name="objWeightage[]" required min="0">
                                        <span class="input-group-append">
                                            <button style="box-shadow: none; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); border: none;" class="btn btn-dark" data-dismiss="modal">%</button>
                                        </span>
                                    </div>                                                    
                                </div>
                            </div>
                            <div class="col-md-2" hidden>
                                <label for="exampleInputEmail1"><strong>Comment</strong></label>
                                <textarea class="form-control" placeholder="Add Comments" name="comment[]" rows="1"></textarea>
                            </div>
                            <div class="col-md-1">
                                <label><strong style="color: transparent;">space</strong></label>
                                <button id="addobj1" type="button" class="btn btn-outline-dark btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                            </div>
                        </div>
                        <div class="form-group row mb-3 mt-5">
                            <div class="col-md-11">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><strong>Description</strong></label>
                                    <textarea required class="form-control" placeholder="Description" name="objDescription[]" rows="1"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="objtable1">
                        <div name="row_count1" class="form-group row">
                        </div>
                    </div>
				</div>
                        <div>
                        <div class="form-group row mt-5">
                            <div class="col-sm-4 mb-1 mb-sm-0">
                            </div>
                            <div class="col-sm-4">
                                <a data-toggle="modal" class="text-white" data-target="#exampleModal11" href="">
                                    <div id="cal" style="float: center; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert border-0 py-2 mt-2 mx-3 text-center" role="alert">Submit</div> 
                                </a>
                            </div>
                            <div class="col-sm-4">
                            </div>
                        </div>
                        </div>
                        <div class="modal fade" id="exampleModal11" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" style="background: none;">
                                        <h5>Objective Weightage</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row px-5">
                                            <div class="col-8">
                                                <h3>Objective Weightage: </h3>   
                                            </div>
                                            <div class="col-4">
                                                <div id="SS" style="display: none;" class="alert alert-success border-0 py-2 mt-2 text-center" role="alert">
                                                    <label class="mb-0"><b id="demo1" class="text-white"></b></label>
                                                </div>
                                                <div id="DN" style="display: none;" class="alert alert-danger border-0 py-2 mt-2 text-center" role="alert">
                                                    <label class="mb-0"><b id="demo2" class="text-white"></b></label>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer" style="background: none;">
                                        <button type="button" style="background: red;" class="btn mt-1 text-white" data-dismiss="modal">Close</button>
                                        <button id="ObjAdd" style="float: right; background: #101924;" type="submit" class="btn mt-1 px-5 text-white">Add Objective</button></td>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                 
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
            var name = document.getElementById("name").value;
            var dep  = document.getElementById("dep").value;
            $('#objtable').append('<tr id="row'+i+'" name="row_count">'+
                                    '<th style="border: none;"></th>'+
                                    '<td class="w-25">'+
                                        '<div class="form-group">'+
                                        '<input readonly id="name" name="memberName[]" value="{{$name}}" class="form-control" required hidden>'+          
                                        '<input hidden type="text" placeholder="Name" id="Memberid" value="2" class="form-control" name="Memberid[]">'+
                                        '<input readonly id="empName" name="memberName2[]" class="form-control" value="{{$empName}}" required>'+
                                        '</div>'+
                                    '</td>'+
                                    '<td hidden>'+
                                        '<div class="form-group">'+
                                            '<div class="form-group">'+
                                            '<input readonly type="text" id="dep" value="{{$department}}" class="form-control" name="memberDepartment[]" required>'+           
                                            '</div>'+
                                        '</div>'+
                                    '</td>'+
                                    '<td>'+
                                        '<div class="form-group" hidden>'+
                                            '<div class="form-group">'+
                                            '<input readonly type="text" id="lead" value="{{$leadname}}" class="form-control" name="leadname[]" required>'+           
                                            '</div>'+
                                        '</div>'+
                                    '</td>'+
                                    '<td class="w-25">'+
                                        '<div class="form-group">'+
                                            '<input type="text" id="objTitle" placeholder="Title" class="form-control class1" name="objTitle[]">'+
                                        '</div>'+
                                    '</td>'+
                                    '<td style="width: 10%;">'+
                                        '<div class="form-group">'+
                                            '<input type="number" placeholder="Weightage" class="form-control sum_item" id="objWeightage1" name="objWeightage[]" required min="0">'+
                                        '</div>'+
                                    '</td>'+
                                    '<td class="w-25">'+
                                        '<div class="form-group">'+
                                            '<textarea class="form-control" placeholder="Description" name="objDescription[]" rows="1" required></textarea>'+
                                        '</div>'+
                                    '</td>'+
                                    '<td>'+
                                    '<div class="form-group" hidden>'+
                                            '<textarea class="form-control" placeholder="Enter Comments" name="comment[]" rows="1"></textarea>'+
                                        '</div>'+
                                    '</td>'+
                                    '<td hidden>'+
                                        '<div class="form-group py-4">'+
                                            '<button type="button" id="addrow" class="btn btn-success btn-sm mt-1"><small>Add Member</small></button>'+
                                        '</div>'+
                                    '</td>'+
                                    '<td>'+
                                        '<div class="form-group py-2">'+
                                            '<button id="'+i+'" type="button" class="btn btn-danger mt-1 obj_remove"><span style="font-size: 18px;" class="px-1">-</span></button>'+
                                        '</div>'+
                                    '</td>'+
                                    '<td>'+
                                    '</td>'+
                                    '</tr>');
});
$(document).on('click', '.remove_m', function(){
    var id = $(this).attr("id"); 
    $('#row'+id+'').remove();
});

$('#cal').click(function(){
    var SS = document.getElementById("SS");
    var DN = document.getElementById("DN"); 
    var ObjAdd = document.getElementById("ObjAdd");
    var sum = 0;
    var store = new Array();
    var summ=0;
    $('.sum_item').each(function(){
    var item_val=parseFloat($(this).val());
    if(isNaN(item_val)){
    item_val=0;
    }
    summ+=item_val;
    $('#total').val(summ.toFixed(2));
    });
    console.log(summ);

    if(summ > 100){
        console.log("Greater");
        DN.style.display = "block";
        SS.style.display = "none";
        ObjAdd.style.display = "block";
        let text = summ.toString();
        document.getElementById("demo2").innerHTML = text+" %"
    }
    else{
        console.log("Less");
        SS.style.display = "block";
        DN.style.display = "none";
        ObjAdd.style.display = "block";
        let text = summ.toString();
        document.getElementById("demo1").innerHTML = text+" %";
    }
});

$(document).on('click', '.obj_remove', function(){
    var id = $(this).attr("id"); 
    $('#row'+id+'').remove();
});
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
    $(document).ready(function () {
        var i = 1;
        $('#addobj1').click(function () {
            console.log("Here");
            i++;
            $('#objtable1').append( '<div name="row_count1" id="row1' + i + '">'+
                        '<div  class="form-group row">' +
                        '<div class="col-md-2">'+
                            '<label for="exampleInputEmail1"><strong>Name</strong></label>'+
                            '<input readonly id="name" name="memberName[]" class="form-control" value="{{$name}}" required hidden>'+
                            '<input readonly id="empName" name="memberName2[]" class="form-control" value="{{$empName}}" required>'+
                            '<input hidden type="text" placeholder="Name" id="Memberid" value="2" class="form-control" name="Memberid[]">'+
                        '</div>'+
                        '<div class="col-md-2">'+
                            '<label for="exampleInputEmail1"><strong>Department</strong></label>'+
                            '<input readonly type="text" id="dep" value="{{$department}}" class="form-control" name="memberDepartment[]" required>  '+
                        '</div>'+
                        '<div class="col-md-2" hidden>'+
                            '<label for="exampleInputEmail1"><strong>Lead Nane</strong></label>'+
                            '<input readonly type="text" id="dep" value="{{$leadname}}" class="form-control" name="leadname[]" required>   '+
                        '</div>'+
                        '<div class="col-md-5">'+
                            '<label for="exampleInputEmail1"><strong>Title</strong></label>'+
                            '<input required type="text" id="objTitle" placeholder="Title" class="form-control" name="objTitle[]">'+
                        '</div>'+
                        '<div class="col-md-2">'+
                            '<label for="exampleInputEmail1"><strong>Weightage</strong></label>'+
                                '<div class="form-group">'+ 
                                    '<div class="input-group">'+
                                        '<input type="number" placeholder="Weightage" class="form-control class1 sum_item" id="objWeightage1" name="objWeightage[]" required>'+
                                        '<span class="input-group-append">'+
                                            '<button style="box-shadow: none; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); border: none;" class="btn btn-dark" data-dismiss="modal">%</button>'+
                                        '</span>'+
                                    '</div>'+                                                    
                                '</div>'+
                        '</div>'+
                        '<div class="col-md-2" hidden>'+
                                '<label for="exampleInputEmail1"><strong>Comment</strong></label>'+
                                '<textarea class="form-control" placeholder="Add Comments" name="comment[]" rows="1"></textarea>'+
                        '</div>'+
                        '<div class="col-md-1">'+
                            '<label><strong style="color: transparent;">space</strong></label>'+
                            '<button id="'+ i +'" type="button" class="obj_remove1 btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                        '</div>'+

                                    '</div>' +

                                    '<div class="form-group row mb-3 mt-5">'+
                        '<div class="col-md-11">'+
                            '<div class="form-group">'+
                                '<label for="exampleInputEmail1"><strong>Description</strong></label>'+
                                '<textarea required class="form-control" placeholder="Description" name="objDescription[]" rows="1"></textarea>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    
                                    '</div>' +
                                    '<br>');
        });
        $(document).on('click', '.obj_remove', function () {
            var id = $(this).attr("id");
            $('#row' + id + '').remove();
        });
        $(document).on('click', '.obj_remove1', function () {
            var id = $(this).attr("id");
            $('#row1' + id + '').remove();
        });
    });
</script>
<script>
    $(document).on('click', '.removeRow1', function(){
        var id = $(this).attr("id"); 
        console.log(id);
        $('#insolerow1'+id+'').remove();
    });
</script>
@endsection