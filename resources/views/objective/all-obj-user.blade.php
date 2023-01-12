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
    .noBorder
    {
        border-right: none !important;
        border-left: none !important;
    }
    .page-item.active .page-link 
    {
        z-index: 3;
        color: #fff;
        background-color: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;
        border-color: transparent;
    }
    .btn-outline:hover, .btn-outline:active, .btn-outline:visited 
    {
        background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;
        border: 1px solid transparent !important;
        color: white;
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
<div class="page-content">
    <div class="container-fluid px-4">
        <div class="row px-2">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="float-right">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Objectives</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Objectives</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body table-responsive p-5">
                        <div class="">
                            <table id="datatable2" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Member</th>
                                        <th>Department</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Weightage</th>
                                        <th class="text-center">Feedback</th>
                                        <th class="text-center">Rating</th>
                                        <th class="text-center">Score</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Operations</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $user)
                                    <tr>
                                        <td>{{$i++}}</td>  
                                        <td>{{$user->memberName}}</td>
                                        <td>
                                        <?php
                                                $pieces = explode(" ", $user->department);
                                                echo $pieces[0];
                                                echo '<br>';
                                                if(count($pieces) == 2){
                                                    echo $pieces[1];
                                                    echo '<br>';
                                                }
                                                if(count($pieces) == 3){
                                                    echo $pieces[2];
                                                    echo '<br>';
                                                }
                                            ?> 
                                        </td>
                                        <td>{{$user->objTitle}}</td>
                                        <td>{{substr($user->objDescription, 0, 20)}}.....
                                        </td>
                                        <td>{{$user->objWeightage}}<span style="margin-left: 3%;">%</span></td>
                                        @if(isset($user->review))
                                        <td class="text-center">
                                            <button type="button" id="btnapp" data-id="{{$user->review}}" class="btn btn-outline fa-eyeshow" style="border: 1px solid #192636;">View</button>
                                        </td>
                                        @else
                                        @if(isset($hrr))  
                                        <td class="text-center">
                                            <button class="btn btn-outline fa-eyee1" data-id="{{$user->id}}" style="border: 1px solid #192636;">Enter Feedback?</button>
                                        </td>
                                        @else
                                        <td>
                                        </td>
                                        @endif
                                        @endif
                                        <div class="modal fade" id="exampleModalCenter9" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="form-group row py-2 text-center">
                                                            <div class="col-sm-12 mb-1 mb-sm-0">
                                                                <label for=""><h4 style="color: #6c757d">Feedback</h4></label>
                                                                <hr>
                                                                <p id="pp"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer text-center" style="background-color: none;">
                                                        <button type="button" class="btn btn-dark fa-eyeee" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <td class="text-center">
                                        @if($user->rating == 1) 
                                            @if($user->rate == 'Outstanding')                                                                                                                                                                                         
                                                <span class="badge badge-md badge-soft-success p-2 w-75">{{$user->rate}}</span>
                                            @elseif($user->rate == 'Need Improvement')   
                                                <span class="badge badge-md badge-soft-danger p-2 w-75">{{$user->rate}}</span>
                                            @elseif($user->rate == 'Meets Expectation')   
                                                <span class="badge badge-md badge-soft-warning p-2 w-75">{{$user->rate}}</span>
                                            @elseif(!$user->rate)   
                                                <span class="badge badge-md badge-soft-white p-2 w-75 text-white">.</span>
                                            @else
                                                <span class="badge badge-md badge-soft-primary p-2 w-75">{{$user->rate}}</span>
                                            @endif
                                        @endif 
                                        </td>
                                        <td class="text-center">
                                        @if(!$user->score)                                            
                                        @else
                                            @if($user->rate == 'Outstanding')
                                            <div class="avatar-box thumb-sm align-self-center">
                                                <span class="avatar-title bg-soft-success rounded-circle" style="font-weight: 500;">{{$user->score}}</span>
                                            </div>
                                            @elseif($user->rate == 'Need Improvement')
                                            <div class="avatar-box thumb-sm align-self-center">
                                                <span class="avatar-title bg-soft-danger rounded-circle" style="font-weight: 500;">{{$user->score}}</span>
                                            </div>
                                            @elseif($user->rate == 'Meets Expectation')
                                            <div class="avatar-box thumb-sm align-self-center">
                                                <span class="avatar-title bg-soft-warning rounded-circle" style="font-weight: 500;">{{$user->score}}</span>
                                            </div>
                                            @else
                                            <div class="avatar-box thumb-sm align-self-center">
                                                <span class="avatar-title bg-soft-primary rounded-circle" style="font-weight: 500;">{{$user->score}}</span>
                                            </div>
                                            @endif
                                        @endif
                                        </td>
                                        <td class="text-center">
                                            @if($user->objStatus == 1)    
                                                <span class="badge badge-warning p-2">Pending</span>
                                            @elseif($user->objStatus == 2)
                                                <span class="badge badge-success p-2">In-Review HR</span>
                                            @elseif($user->objStatus == 3)
                                                <span class="badge badge-danger p-2">Revision</span>
                                                <i data-toggle="modal" data-target="#exampleModalCenter9" style="cursor: pointer" class="align-middle mb-1 mt-1 mx-1 cursor-pointer" data-feather="eye"></i>                                                        
                                            @elseif($user->objStatus == 4)
                                                <span class="badge badge-secondary p-2">Finalised</span>
                                            @endif
                                        </td>
                                        <td class="text-center" style="display: flex;">
                                            <form action="obj-edit">
                                                <input type="text" value="{{$user->id}}" name="id" hidden>
                                                @if($id != "2")
                                                    @if($status == "4")                                
                                                    @else 
                                                        @if(isset($storeData['Objective-Edit']) && !empty($storeData['Objective-Edit'])) 
                                                            @if($storeData['Objective-Edit'] == 1)
                                                                @if($user->objStatus == 1 || $user->objStatus == 3)
                                                                    <span data-id={{$user['id']}} data-toggle="modal" class="badge btn-sm badge-dark p-0 rounded-circle mx-1 showww1" style="cursor: pointer" data-target="#exampleModalCenteredit"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="edit"></i></span>                        
                                                                @endif
                                                            @endif
                                                        @endif    
                                                        @if(isset($storeData['Objective-Delete']) && !empty($storeData['Objective-Delete'])) 
                                                            @if($storeData['Objective-Delete'] == 1)
                                                                <span data-id={{$user['id']}} style="cursor: pointer" class="badge btn-sm badge-danger p-0 rounded-circle cursor-pointer DelUser"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="trash"></i></span>                        
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif    
                                                <span data-id={{$user['id']}} data-toggle="modal" class="badge btn-sm badge-secondary p-0 rounded-circle mx-1 showww" style="cursor: pointer" data-target="#exampleModalCenter"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="eye"></i></span>                        
                                            </form>                        
                                        </td>
                                        @if(isset($hrr))                                        
                                        @if(isset($user->review))
                                        @else
                                        @if($user->objStatus == 2)
                                        <div class="modal fade" id="exampleModalCenter222" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="background-color: transparent;">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Feedback</h5>
                                                    </div>
                                                    <div class="modal-body" id="exampleModalCenter1b">
                                                        <form action="{{url('feedback')}}" method="get" enctype="multipart/form-data">
                                                        <div class="form-group row py-1">
                                                            <div class="col-sm-12 mb-1 mb-sm-0">
                                                                <input hidden type="text" id="userId" name="userId">
                                                                <input type="text" class="form-control py-2" id="feedback" name="feedback" placeholder="Enter Feedback" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-sm-8 mb-1 mb-sm-0">
                                                            </div>
                                                            <div class="col-sm-4 mb-1 mb-sm-0">
                                                                <button type="submit" class="btn btn-primary w-100 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); border: none; font-size: 15px;">Submit</button>
                                                            </div>
                                                        </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer" style="background-color: transparent;">
                                                        <button type="button" class="btn btn-dark fa-eyeee" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @endif
                                        @endif
                                        <div class="modal fade" id="exampleModalCenter5" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header" style="background-color: transparent">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Delete Objective User?</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        Select "Delete" below if you are ready to delete Objective User?
                                                    </div>
                                                    <div class="modal-footer" style="background-color: transparent">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button id="del" type="button" class="btn btn-danger DelId" data-dismiss="modal">Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th class="text-center"></th>
                                        <th class="text-center">Total Score</th>
                                        <th class="text-center">
                                            <span class="badge badge-dark p-2 w-100">{{$score}}<span style="margin-left: 3%;">%</span></span>
                                        </th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>           
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-sm" id="exampleModalCenter67" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: transparent">
            <h5 class="modal-title" id="exampleModalLongTitle">Rate</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body py-5">
                <form action="{{url('rate')}}" id="myForm1" method="post" class="w-100" enctype="multipart/form-data">
                    @csrf
                    <input hidden type="text" id="userValue" name="rate">
                    <input hidden type="text" id="DataId" name="dataId">
                    <select id="example-movie" class="rating" name="rating" autocomplete="off">
                        <option value="Need Improvement">Need Improvement</option>
                        <option value="Meets Expectation">Meets Expectation</option>
                        <option value="Exceeds Expectation">Exceeds Expectation</option>
                        <option value="Outstanding">Outstanding</option>
                    </select>
                </form>
            </div>
            <div class="modal-footer" style="background-color: transparent">                
                <button type="button" id="rate" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); border: none; margin-right: auto; margin-left: auto;" class="btn px-3 py-0 text-white w-25"><i style="font-size: x-large;" class="mdi mdi-checkbox-marked-circle-outline"></i></button>                  
            </div>
        </div>
    </div>
</div>
<div class="modal fade modelMarginDetail" id="exampleModalCenter" style="margin-top: 5%;" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color: none !important;">
            <div class="modal-header py-1" style="padding-left: 40%; background-color: transparent;">
                <h4 class="modal-title mt-4" id="exampleModalLongTitle">Objective Detail</h4>
            </div>
            <div class="modal-body py-3 px-5" id="modal-body-accept">
                <div class="row mt-2">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                        <label for=""><b>Member Name:</b></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <p id="memberName"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                        <label for=""><b>Lead Name:</b></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <p id="leadId"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                        <label for=""><b>Department:</b></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <p id="dep"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                        <label for=""><b>Status:</b></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <p id="objStatus"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                        <label for=""><b>Weightage:</b></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <p id="objWeightage"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                        <label for=""><b>Title:</b></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <p id="objTitle"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                        <label for=""><b>Score:</b></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="avatar-box thumb-sm align-self-center">
                                            <span id="score" class="avatar-title bg-soft-dark rounded-circle"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                        <label for=""><b>Rating:</b></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <span id="rating" class="badge badge-md badge-soft-dark p-2 w-50"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-sm-2 mb-3 mb-sm-0">
                                <label for=""><b>Description:</b></label>
                            </div>
                            <div class="col-sm-12">
                                <p id="objDescription"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center" style="background-color: transparent;">
                <button style="margin-right: 45%;" type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modelMarginDetail" id="exampleModalCenteredit" style="margin-top: 5%;" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background-color: none !important;">
            <div class="modal-header py-1" style="padding-left: 40%; background-color: transparent;">
                <h4 class="modal-title mt-4" id="exampleModalLongTitle">Objective Edit</h4>
            </div>
            <div class="modal-body py-3 px-5" id="modal-body-accept">
                <div class="row mt-2">
                    <form action="{{url('update-objective')}}" method="post" class="w-100" enctype="multipart/form-data">
                    @csrf
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-sm-4 mb-3 mb-sm-0">
                                            <label for=""><b>Member Name:</b></label>
                                            <input type="text" class="form-control py-1" style="border: 1px solid #bfbfbf;" id="idid" name="id" hidden>
                                            <input readonly type="text" class="form-control py-1" style="border: 1px solid #bfbfbf;" id="memberName1" name="memberName">
                                        </div>
                                        <div class="col-sm-4 mb-3 mb-sm-0">
                                            <label for=""><b>Weightage:</b></label>
                                            <input type="text" class="form-control py-1" style="border: 1px solid #bfbfbf;" id="objWeightage1" name="objWeightage">
                                        </div>
                                        <div class="col-sm-4 mb-3 mb-sm-0">
                                            <label for=""><b>Title:</b></label>
                                            <input type="text" class="form-control py-1" style="border: 1px solid #bfbfbf;" id="objTitle1" name="objTitle">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <label for=""><b>Description:</b></label>
                                            <textarea class="form-control" id="objDescription1" name="objDescription" class="w-100"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer text-center" style="background-color: transparent;">
                            <button type="button" class="py-1 btn btn-dark" data-dismiss="modal">Close</button>
                            <button type="submit" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 text-white">Update Objective</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/sweetalert.min.js"></script>
<script src="assets/js/customjquery.min.js"></script>
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
    $(".ratebtn").click(function(){
        var dataId = $(this).attr("data-id");
        var Val = $(this).attr("val");
        var id = $(this).attr("id");
        $("#userValue").val(Val);
        $("#DataId").val(dataId);
    });
    $("#rate").click(function(){
        document.getElementById("myForm1").submit();
    });
</script>
<script src="assets/js/customjquery.min.js"></script>
<script>
    $(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#dataTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    });
</script>
<script>
    $(".DelUser").click(function(){
        var id = $(this).attr("data-id");
        $('.DelId').attr("data-id",id);
        $('#exampleModalCenter5').modal('show');
    });
</script>
<script>
    $(".fa-eyee").click(function(){
        var id= "1";
        changeStatus1(id);
    });

    function changeStatus1(id){
        $.ajax({
                type: 'GET',
                url: 'changeStatus/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Objectives Approved!',
                        });   
                        $("#btn_approved").attr("disabled", true);
                        $("#btn_approved").html("Approved");
                        $("#btn_approved").css("background-color", "green");
                        $("#btn_approved").css("border-color", "green");
                        $("#btn_approved").css("cursor", "not-allowed");
                        $("#btn_approved").addClass("cursor-not-allowed");
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something Went Wrong!',
                        });
                    }
                }
            });
        }
</script>

<script>
    $(".fa-eyeehr").click(function(){
        var id = "1";
        changeStatus2(id);
    });

    function changeStatus2(id){
        $.ajax({
                type: 'GET',
                url: 'changeStatusHr/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Objectives Approved!',
                        });  
                        $("#btn_approved").attr("disabled", true);
                        $("#btn_approved").html("Finalised");
                        $("#btn_approved").css("background-color", "green");
                        $("#btn_approved").css("padding-right", "5px");
                        $("#btn_approved").css("cursor", "not-allowed");
                        $("#btn_approved").addClass("cursor-not-allowed");
                        $("#btn_rejected").hide();
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something Went Wrong!',
                        });
                    }
                }
            });
        }
</script>
<script>
    $(".fa-eyeshow").click(function(){
        console.log("CLICK");
        var id = $(this).attr("data-id");
        $('#pp').html(id);
        $('#exampleModalCenter9').modal('show');
    });
    $(".fa-eyeee").click(function(){
        $('#exampleModalCenter9').modal('hide');
    });
</script>
<script>
    $(".fa-eyeehrRej").click(function(){
        var id= $(this).attr("data-id");
        changeStatus3(id);
    });

    function changeStatus3(id){
        $.ajax({
                type: 'GET',
                url: 'changeStatusHrRej/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        $("#btn_approved").attr("disabled", true);
                        $("#btn_approved").html("Rejected");
                        $("#btn_approved").css("background-color", "green");
                        $("#btn_approved").css("cursor", "not-allowed");
                        $("#btn_approved").addClass("cursor-not-allowed");
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something Went Wrong!',
                        });
                    }
                }
            });
        }
</script>
<script>
    $("#del").click(function(){
        var id= $(this).attr("data-id");
        console.log("Here");
        deleteobj(id);
    });

    function deleteobj(id){
        $.ajax({
                type: 'GET',
                url: 'deleteobj/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Objective Delete Successfully!',
                        });
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something Went Wrong!',
                        });
                    }
                }
            });
        }
</script>
<script>
    $(".showww").click(function(){
        var id= $(this).attr("data-id");
        console.log("id");
        console.log(id);
        $.ajax({
            type: 'GET',
            url: 'showobj/'+id,
            dataType: "json",
            beforeSend: function(){
                $("#modal-body-accept").hide();
            },
            success: function(data){
                if(data){
                    console.log(data);
                    $('#memberName').html(data.memberName);
                    $('#objStatus').html(data.objStatus);
                    $('#objWeightage').html(data.objWeightage);
                    $('#objTitle').html(data.objTitle);
                    $('#objDescription').html(data.objDescription); 
                    $('#comment').html(data.comment);
                    $('#leadId').html(data.leadId);
                    $('#dep').html(data.department);
                    $('#rating').html(data.rate);
                    $('#score').html(data.score);
                }
            },
            complete:function(data){
                $("#modal-body-accept").show();
            }
        });
   });
</script>
<script>
    $(".showww1").click(function(){
        var id= $(this).attr("data-id");
        console.log("id");
        console.log(id);
        $.ajax({
            type: 'GET',
            url: 'showobj/'+id,
            dataType: "json",
            beforeSend: function(){
                $("#modal-body-accept").hide();
            },
            success: function(data){
                if(data){
                    console.log(data);
                    $('#idid').val(data.id);
                    $('#memberName1').val(data.memberName);
                    $('#objWeightage1').val(data.objWeightage);
                    $('#objTitle1').val(data.objTitle);
                    $('#objDescription1').val(data.objDescription); 
                }
            },
            complete:function(data){
                $("#modal-body-accept").show();
            }
        });
   });
</script>
<script>
    $(".fa-eyee1").click(function(){
        var id= $(this).attr("data-id");
        $("#userId").val(id);
        $('#exampleModalCenter222').modal('show');
    });
    $(".fa-eyeee").click(function(){
        $('#exampleModalCenter9').modal('hide');
    });
</script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
@endsection