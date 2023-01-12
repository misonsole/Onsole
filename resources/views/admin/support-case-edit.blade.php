@extends( 'layouts.user-layout')
@section('content')
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
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
    .yourclass::-webkit-input-placeholder{
        color: #6c757d;
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
                        <li class="breadcrumb-item"><a href="{{url('manage-complaints')}}">Manage Complaints</a></li>
                        <li class="breadcrumb-item active">Edit Complaint</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Complaint</h4>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-lg-9 col-md-12 col-sm-12" style="margin: 0 auto;">
            <div class="card p-3">
                <div class="card-body">            
                    <form action="{{url('support-case-edit')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row py-2">
                            <div class="col-sm-4 mb-1 mb-sm-0">
                                <label><b style="color: #6c757d">Category</b></label>
                                <input hidden type="text" name="id" value="{{$data['id']}}">
                                <select style="border: 1px solid #bfbfbf;" id="category" name="category" class="form-control select.custom-select" required>
                                    @foreach($category as $name)
                                        <option <?php if($name->category == $usercategory) echo 'selected="selected"'; ?> value="{{ $name->category }}">{{ $name->category }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label><b style="color: #6c757d">Sub Category</b></label>
                                <select style="border: 1px solid #bfbfbf;" id="subcategory" name="subcategory" class="form-control select.custom-select" required>
                                        <option value="{{ $usersubcategory }}">{{ $usersubcategory }}</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label><b style="color: #6c757d">Support Case Type</b></label>
                                <select style="border: 1px solid #bfbfbf;" id="type" name="type" class="form-control select.custom-select" required>
                                        <option <?php if($userstype == "Support Case") echo 'selected="selected"'; ?> selected value="Support Case">Support Case</option>
                                        <option <?php if($userstype == "General Query") echo 'selected="selected"'; ?> value="General Query">General Query</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row py-2">
                            <div class="col-sm-12 mb-1 mb-sm-0">
                                <label><b style="color: #6c757d">Support Case Details</b></label>
                                <textarea style="border: 1px solid #bfbfbf;" class="form-control yourclass" rows="5" id="message" name="message" required>{{$data['message']}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row mt-5">
                            <div class="col-sm-4 mb-1 mb-sm-0">
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white">Update</button>
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
<script src="assets/js/customjquery.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script>
$(document).ready(function(){ 
	$("#loader1").fadeOut(1200);
});
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
    $('#category').on('change', function(){
        var category = $(this).val();
            $.ajax({
                type: 'GET',
                url: 'category/'+category,
                dataType: "json",
                success: function(data){
                    if(data){
                        $('#subcategory').find('option').remove();
                        for(var d=0;d<data.length;d++){
                        var option = "<option value='" + data[d] + "'>" + data[d] + "</option>"
                            document.getElementById('subcategory').innerHTML += option;
                        } 
                    }
                }
            });
    });
</script>
@endsection