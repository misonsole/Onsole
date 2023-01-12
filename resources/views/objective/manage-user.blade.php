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
    <div class="container-fluid">
        <div class="row px-1">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="float-right">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Manage Users</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Manage Users</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body table-responsive">
                        <div class="">
                            <table id="datatable2" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Designation</th>
                                        <th>Department</th>
                                        <th>Role</th>
                                        <th>Objective</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        @foreach($data as $user) 
                                        <tr class="text-left">
                                            <td>{{$i++}}</td>
                                            <td> 
                                            @if(isset($user->image) && !empty($user->image)) 
                                            <img src="{{ asset('uploads/appsetting/' . $user->image) }}" class="avatar img-fluid rounded me-1 rounded-circle" alt="Charles Hall" />  
                                            @else
                                            <img src="img/avatars/avator.png" class="avatar img-fluid rounded me-1 rounded-circle" alt="Charles Hall" />  
                                            @endif
                                            {{$user->firstname}} {{$user->lastname}}</td>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->designation}}</td>
                                            <td>{{$user->department}}</td>
                                            <td> <span class="badge badge-dark p-2" style="background: #202020; font-size: small; font-weight: 500;">{{$user->userrole}}</span></td>
                                            <td>
                                            <form action="user-obj">
                                                <input type="text" value="{{$user->id}}" id="id" name="id" hidden>
                                                <button style="background: none; border: none;" type="submit">
                                                    <span class="badge badge-dark p-3" style="background: #202020; font-size: small; font-weight: 500;">Show Objectives</span>
                                                </button> 
                                            </form>
                                            </td>
                                            <td>
                                                <form action="user-edit">
                                                    <input type="text" value="{{$user->id}}" name="id" hidden> 
                                                    @if(isset($storeData['User-Edit']) && !empty($storeData['User-Edit'])) 
                                                        @if($storeData['User-Edit'] == 1)
                                                            <button style="background: none; border: none;" type="submit"><span class="badge badge-dark p-2 rounded-circle" type="submit" style="background: #202020;"> <i class="align-middle mb-1 mt-1 mx-1" data-feather="edit"></i></span></button>                                
                                                        @endif
                                                    @endif
                                                    @if(isset($storeData['User-Delete']) && !empty($storeData['User-Delete'])) 
                                                        @if($storeData['User-Delete'] == 1)                                            
                                                            <span id="del" data-id={{$user['id']}} class="badge badge-danger p-2 rounded-circle cursor-pointer"><i class="align-middle mb-1 mt-1 mx-1" data-feather="trash"></i></span>                                                        
                                                        @endif     
                                                    @endif
                                                </form>
                                            </td>   
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>           
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modelMarginDetail" id="exampleModalCenter" style="margin-top: 5%;" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header py-1" style="padding-left: 40%;">
            <h4 class="modal-title mt-4" id="exampleModalLongTitle">User Detail</h4>
        </div> <hr class="mx-5">
        <div class="modal-body py-3 px-5" id="modal-body-accept">
            <div class="row mt-2">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-sm-3 mb-3 mb-sm-0">
                             <label for=""> <b>First Name:</b> </label>
                        </div>
                        <div class="col-sm-9">
                            <p id="firstName"></p>
                         </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <label for=""> <b>User Name:</b> </label>
                            </div>
                            <div class="col-sm-9">
                                <p id="userName"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <label for=""> <b>Email:</b> </label>
                            </div>
                            <div class="col-sm-9">
                                <p id="email"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <label for=""> <b>Department:</b> </label>
                            </div>
                            <div class="col-sm-9">
                                <p id="department"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <label for=""> <b>Designation:</b> </label>
                            </div>
                            <div class="col-sm-9">
                                <p id="designation">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <label for=""> <b>Roles:</b> </label>
                            </div>
                            <div class="col-sm-9">
                                <p id="userrole">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="mx-5">
            <div class="modal-footer text-center">
                <button style="margin-right: 45%;" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
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
    $("#del").click(function(){
        var id= $(this).attr("data-id");
        deleteuser(id);
        console.log("Del");
    });

    function deleteuser(id){
        $.ajax({
                type: 'GET',
                url: 'delete/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        console.log("Deleted");
                        console.log(data);
                        Swal.fire({
                            icon: 'success',
                            title: 'User Delete Successfully!',
                        });
                        location.reload();
                    }
                    else if(data == 400){
                        console.log("Button data 400");
                        console.log(data);
                        Swal.fire(
                            'Something went wrong!',
                            'error'
                        );  
                    }
                }
            });
        }
</script>
<script>
    $(".fa-eyee").click(function(){
        var id= $(this).attr("data-id");
        $.ajax({
            type: 'GET',
            url: 'editMembers/'+id,
            dataType: "json",
            beforeSend: function(){
                $("#modal-body-accept").hide();
            },
            success: function(data){
                if(data){
                   console.log(data);
                    $('#firstName').html(data.FirstName+" "+data.LastName);
                    $('#userName').html(data.UserName);
                    $('#email').html(data.Email);
                    $('#department').html(data.Department);
                    $('#designation').html(data.Designation);
                    $('#userrole').html(data.UserRole);
                    $("#image").attr('scr', '{{ asset("uploads/appsetting/".'') }}');
                    $(".userNamee").attr('name',"Zoraiz");
                   console.log("asset('uploads/appsetting/'.data.image)");
                }
            },
            complete:function(data){
                $("#modal-body-accept").show();
            }
        });
   });
</script>
@endsection