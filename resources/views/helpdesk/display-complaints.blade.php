@extends( (Auth::user()->id == "2") ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<link href="plugins/filter/magnific-popup.css" rel="stylesheet" type="text/css" />
<?php
    $id = Auth::user()->id;
    $IdUser = $id;
    $UserDetail = DB::table("users")->where("id", $id)->pluck('userrole');
    $image = DB::table("users")->where("id", $id)->pluck('image');
    $image = $image[0];
    $UserDetail1 = DB::table("newroles")->where("name", $UserDetail)->get();
    $obj = json_decode (json_encode ($UserDetail1), FALSE);
    $storeData = [];
    foreach($obj as $dataa){
        $storeData[$dataa->role_name] = $dataa->value; 
    }
    // print_r($storeData);
    $tem1 = null;
?>
<style>
    .btn-outline:active, .btn-outline:visited{
        background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;
        border: 1px solid #1761fd !important;
        color: white;
    }
    .media .media-body.reverse .chat-msg p{
        background-color: #6d81f5;
        color: white;
        display: inline-block;
        margin-bottom: 0;
        border-radius: 20px;
    }
    .media .media-body .chat-msg p{
        background-color: #f8fafd;
        color: #303e67;
        display: inline-block;
        margin-bottom: 0;
        border-radius: 20px;
    }
    #chatcard{
        padding: 20px;
        background-image: url("img/photos/pattern.png");
        background-repeat: repeat;
        background-attachment: fixed;
        height: 570px;
        background-color: #edf0f5;
        overflow: auto;
    }
    .chat-footer{
        border-top: 1px solid #f1f5fa;
        background-color: #fff;
        padding: 20px;
        left: 0;
        bottom: 0;
    }
    .chat-footer .chat-admin{
        position: absolute;
        top: -40px;
        /* border: 2px solid #303e67; */
        border-radius: 50%;
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
    .mfp-container {
        cursor: auto
    }
</style>
<div id="loader1" class="rotate" width="100" height="100"></div>
<div class="page-content">
    <div class="container-fluid px-5">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="float-right">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{url('manage-complaints')}}">Manage Complaints</a></li>
                            <li class="breadcrumb-item active">Manage Complaint</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Manage Complaint</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">  
                <div class="card mt-2">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card-body p-5">
                            <div class="row">
                                    <div class="col-9">
                                        <div class="media mb-4">
                                        @if(isset($user['image']) && !empty($user['image'])) 
                                        <img class="d-flex mr-3 rounded-circle thumb-md" src="{{ asset('uploads/appsetting/' . $user['image']) }}" alt="Generic placeholder image">
                                        @else
                                        <img class="d-flex mr-3 rounded-circle thumb-md" src="img/avatars/avatar-2.jpg" alt="Generic placeholder image">
                                        @endif 
                                        <div class="media-body align-self-center">
                                            <h5 class="m-0">{{$user['emp_name']}}</h5>
                                            <p style="letter-spacing: 0.4px;" class="text-muted">{{$user['email']}}</p>
                                            <input type="text" id="loginid" name="loginid" value="{{Auth::user()->id}}" hidden>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="media mb-4" style="float: right;">
                                            @if($data['status'] == 'final')
                                            <div class="media-body align-self-center">
                                                <?php
                                                    date_default_timezone_set("Asia/karachi");
                                                    $time = date("h:i A");
                                                    $hour = date("G");
                                                    $min = date("i");
                                                    $month = $data->created_at;
                                                    $delimiter = ' ';
                                                    $words = explode($delimiter, $month);
                                                    $datetime4 = new DateTime($data->update_time);
                                                    $delimiter = ' ';
                                                    $words = explode($delimiter, $data->update_time);
                                                    $final = $words[1];                      
                                                    $Complaindate = date('Y-m-d G:i:s');
                                                    $date1 = strtotime($Complaindate);
                                                    $static = strtotime('2022-10-22 15:44:43');
                                                    $datetime = new DateTime('tomorrow');
                                                    $today = $datetime->format('Y-m-d');
                                                    $expire = $today." ".$final;
                                                    $date2 = strtotime($expire);
                                                    $diff = abs($date2 - $date1);
                                                    $years = floor($diff / (365*60*60*24));
                                                    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                                    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24) / (60*60*24));
                                                    $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));
                                                    $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60) / 60);
                                                    $seconds = floor(($diff - $years * 365*60*60*24  - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));
                                                    $result = $date2 - $date1;
                                                    if($result < 0){
                                                        $update = DB::table('supports')->where('id', $data->id)->update(['status' => 'closed']);
                                                    }
                                                ?>
                                                @if($result > 0)
                                                    <h6 class="m-0" style="font-family: system-ui;">Complaint Complete After</h6>
                                                    <h6 class="float-right pl-1"> {{(int)$minutes}} <span style="font-weight: 100;">Minutes </span></h6>
                                                    <h6 class="float-right pl-1">&#128344; {{(int)$hours}}<span style="font-weight: 100;"> Hour </span>  </h6> 
                                                @endif
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <h6 class="mt-0">Complaint No: {{$data['complaint']}}</h6>
                                        <h4 class="mt-1"> <span style="font-weight: 500;">Category:</span> {{$data['category']}}</h4>
                                        <h5 class="mt-0"> <span style="font-weight: 500;">Sub Category:</span> {{$data['subcategory']}}</h5>
                                    </div>
                                    <div class="col text-right">
                                        @if($data['status'] == NULL)    
                                        <span class="badge badge-md badge-boxed badge-danger p-2 my-2" style="font-size: small !important;">No Action</span>
                                        @elseif($data['status'] == 'in process')
                                        <span class="badge badge-md badge-boxed badge-warning p-2 my-2" style="font-size: small !important;">In Process</span>
                                        @elseif($data['status'] == 'final')
                                        <?php
                                            $datetime4 = new DateTime($data->update_time);
                                            $delimiter = ' ';
                                            $today1 = $datetime4->format('d-m-y');
                                            $today2 = $datetime4->format('G:i A');
                                        ?>
                                        <span style="display: inline-flex;">
                                            <span class="badge badge-md badge-boxed badge-secondary p-2 my-2" style="font-size: small !important;">Closed</span><small style="display: grid;"><span style="margin-bottom: -12px; margin-top: 4px;">&nbsp{{$today2}} </span><span style="margin-top: 2px;">&nbsp{{$today1}}</span></small> 
                                        </span>
                                        @elseif($data['status'] == 'closed')
                                        <?php
                                            $datetime4 = new DateTime($data->update_time);
                                            $delimiter = ' ';
                                            $today1 = $datetime4->format('d-m-y');
                                            $today2 = $datetime4->format('G:i A');
                                        ?>
                                        <span style="display: inline-flex;">
                                            <span class="badge badge-md badge-boxed badge-success p-2 my-2" style="font-size: small !important;">Complete</span><small style="display: grid;"><span style="margin-bottom: -12px; margin-top: 4px;">&nbsp{{$today2}} </span><span style="margin-top: 2px;">&nbsp{{$today1}}</span></small> 
                                        </span>                                        
                                        @endif
                                        @if($data['updated_at'] != NULL)
                                        <h5 class="mt-1"><i class="mdi mdi-calendar-text-outline"></i> {{$data['date']}}</h5>
                                        <h5 class="mt-0"> <i class="mdi mdi-timer"></i> {{$data['time']}}</h5>   
                                        @else
                                        <?php $delimiter = ' '; $final = explode($delimiter, $data['created_at']); ?> 
                                        <h5 class="mt-1"><i class="mdi mdi-calendar-text-outline"></i> {{$final[0]}}</h5>
                                        <h5 class="mt-0"> <i class="mdi mdi-timer"></i> {{$final[1]}}</h5>
                                        @endif  
                                    </div>
                                </div>
                                <br>                                                                      
                                <p style="font-family: system-ui;">{{$data['message']}}</p>                       
                                <hr style="border-top: 1px solid #e6e8eb;"/>
                                @if(isset($data['doc']) && !empty($data['doc']))
                                <div class="row">
                                    <div class="col-lg-2 col-md-4">
                                        <div class="file-box-content">
                                            <div class="file-box" style="border: 1px solid #e6e8eb;">
                                                <div class="row" style="margin-top: -10px">
                                                    <div class="col-12">
                                                        <a href="{{ asset('uploads/appsetting/' . $data['doc']) }}" style="float: right;" download class="download-icon-link">
                                                            <i style="float: left; font-size: 20px;" class="mdi mdi-cloud-download-outline"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <i class="far fa-file-alt text-dark"></i>
                                                    <h6>Attachment</h6>
                                                    <div class="row" style="margin-top: -10px">
                                                        <div class="col-12">
                                                            <small class="text-muted px-0">{{$data['doc']}}</small>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="row container-grid nf-col-3  projects-wrapper">
                                                                <div class="col-lg-12 col-md-6 p-0 nf-item branding design coffee spacing">
                                                                    <div class="item-box">
                                                                        <a class="cbox-gallary1 mfp-image" href="{{ asset('uploads/appsetting/' . $data['doc']) }}" title="Attachment">
                                                                            <img style="border-radius: 20px;" class="item-container p-3" src="{{ asset('uploads/appsetting/' . $data['doc']) }}" alt="File" />
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <span hidden href="#custom-modal" data-toggle="modal" data-animation="bounce" data-target=".compose-modal" class="badge badge-md badge-boxed badge-dark w-50 p-2 my-2" style="font-size: small !important;"><i style="font-size: 20px;" class="mdi mdi-eye"></i></span>
                                                        </div>
                                                    </div>
                                                </div>                                                        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <br>
                                @if($data['status'] != 'closed')
                                <a href="#custom-modal" style="border:none; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn waves-effect text-white" data-toggle="modal" data-animation="bounce" data-target=".compose-modal"><i class="mdi mdi-reply"></i> Reply</a>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-4">
                            @if($data['status'] != 'closed')
                            <div class="card-body p-4 chatcard1" style="display: none;" id="chatcard">
                            @else
                            <div class="card-body p-4 chatcard1" id="chatcard" style="height: 100% !important; display: none;">
                            @endif
                                <div class="text-center">
                                    <h5 id="date"></h5>                              
                                </div>
                                <span id="msg1">                                
                                </span>
                                <span id="msg2">                        
                                </span>
                            </div>
                            @if($data['status'] != 'closed')
                            <div class="card-body p-4 chatcard2" id="chatcard">
                            @else
                            <div class="card-body p-4 chatcard2" id="chatcard" style="height: 100% !important;">
                            @endif
                                @foreach($SupportDetail as $value)
                                <div class="text-center">
                                <?php $month = $value['data']['update_time']; $delimiter = ' '; $words = explode($delimiter, $month); ?>
                                    @if($tem1 == $words[0])
                                    @else
                                        <h5>{{$words[0]}}</h5>
                                        <?php $tem1 = $words[0]; ?>
                                    @endif
                                </div>
                                @if($value['data']['sender'] == Auth::user()->id)  
                                    <div class="media my-2">                                                        
                                        <div class="media-body reverse px-1">
                                            <div class="chat-msg mt-1" style="float: right;">
                                            <?php $month = $value['data']['update_time']; $delimiter = ' '; $words = explode($delimiter, $month); ?>
                                                <small class="text-muted">{{$words[1]}}</small>
                                                <p class="py-1 px-3">{{$value['data']['message']}}</p>
                                            </div>                                                           
                                        </div>
                                        <div class="media-img">
                                        @if(isset($value['image']) && !empty($value['image'])) 
                                        <a class="mr-2" href="#" data-toggle="tooltip" data-placement="top" title="&nbsp;{{$value['name']}}&nbsp;">
                                            <img src="{{ asset('uploads/appsetting/' . $value['image']) }}" alt="user" class="rounded-circle thumb-sm">
                                        </a>

                                        @else
                                        <a class="mr-2" href="#" data-toggle="tooltip" data-placement="top" title="&nbsp;{{$value['name']}}&nbsp;">
                                            <img src="img/avatars/avatar-2.jpg" alt="admin" class="rounded-circle thumb-sm">
                                        </a>

                                        @endif 
                                        </div>
                                    </div>
                                @endif
                                @if($value['data']['sender'] != Auth::user()->id)    
                                <div class="media my-2">
                                    <div class="media-img">
                                        @if(isset($value['image']) && !empty($value['image']))
                                        <a class="mr-2" href="#" data-toggle="tooltip" data-placement="top" title="&nbsp;{{$value['name']}}&nbsp;">
                                            <img src="{{ asset('uploads/appsetting/' . $value['image']) }}" alt="user" class="rounded-circle thumb-sm">
                                        </a>

                                        @else
                                        <a class="mr-2" href="#" data-toggle="tooltip" data-placement="top" title="&nbsp;{{$value['name']}}&nbsp;">
                                            <img src="img/avatars/avatar-2.jpg" alt="user 1" class="rounded-circle thumb-sm">
                                        </a>
                                        @endif
                                    </div>
                                    <div class="media-body px-1">                                                            
                                        <div class="chat-msg mt-1">
                                        <?php $month = $value['data']['update_time']; $delimiter = ' '; $words = explode($delimiter, $month); ?>
                                            <p class="py-1 px-3">{{$value['data']['message']}}</p>
                                            <small class="text-muted">{{$words[1]}}</small>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                            @if($data['status'] != 'closed')
                            <div class="chat-footer" id="chatfooter">
                                <form id="Chatform" class="adminForm">
                                    @csrf
                                    <div class="row">       
                                        <div class="col-12">
                                        @if(isset($image) && !empty($image)) 
                                            <span class="chat-admin"><img src="{{ asset('uploads/appsetting/' . $image) }}" alt="user" class="rounded-circle thumb-sm"></span>
                                            @else
                                            <span class="chat-admin"><img src="img/avatars/avatar-2.jpg" alt="user" class="rounded-circle thumb-sm"></span>
                                            @endif
                                            <input hidden type="text" name="complaint_id" value="{{$data['complaint']}}">
                                            <input hidden type="text" name="id" value="{{$data['id']}}">
                                            <input hidden type="text" name="user_id" value="{{$data['userid']}}">
                                            <div class="form-group"> 
                                                <div class="input-group">
                                                    <input type="text" class="form-control yourclass" name="message" placeholder="Type something here..." required>
                                                    <span class="input-group-append">
                                                        <button type="submit" style="box-shadow: none;" class="btn btn-dark" data-dismiss="modal"><i class="mdi mdi-send"></i></button>
                                                    </span>
                                                </div>                                                    
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>                                                                          
            </div>
        </div>
    </div>                     
</div>
<div class="modal fade compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: transparent;">
                <h5 class="modal-title mt-0" id="exampleModalLabel">Response to Complainant</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="card mb-0 p-3">
                    <form action="{{url('support')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col">
                                    <label><b style="color: #6c757d">Complainant</b></label>
                                    <input readonly style="border: 1px solid #d1cccc;" value="{{$user['emp_name']}}" type="text" class="form-control">
                                    <input hidden style="border: 1px solid #d1cccc;" value="{{$user['id']}}" type="text" class="form-control" id="id" name="id">
                                    <input hidden style="border: 1px solid #d1cccc;" value="{{$data['complaint']}}" type="text" class="form-control" id="complaint" name="complaint">
                                    <input hidden type="text" name="complaint_id" value="{{$data['id']}}">
                                    <input hidden style="border: 1px solid #d1cccc;" value="{{$user['emp_name']}}" type="text" class="form-control" id="name" name="name">
                                </div>
                                <div class="col">
                                    <label><b style="color: #6c757d">Status</b></label>
                                    <select style="border: 1px solid #bfbfbf;" id="status" name="status" class="form-control select.custom-select" required>
                                        <option value = 'NULL' <?php if ($data['status'] == NULL) echo "selected"; ?>>No Action</option>
                                        <option value = "in process" <?php if ($data['status'] == "in process") echo "selected"; ?>>In Process</option>
                                        <option value = "final" <?php if ($data['status'] == "final") echo "selected"; ?>>Close</option>                                        
                                </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <textarea style="border: 1px solid #d1cccc;" class="form-control yourclass" rows="5" id="message" name="message" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <div class="pull-right">
                                <button style="border: none; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn waves-effect waves-light text-white"><span>Send</span><i class="far fa-paper-plane ml-2"></i></button>
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
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<script>
    $(document).ready(function(){ 
        $("#loader1").fadeOut(1200);
    });
    document.onkeydown = function (){
        if(window.event.keyCode == '13'){
            submitForm();
        }
    }
    setInterval(function()
    {
        console.log("Hyeee");
    }, 1000);
</script>
<script>
    $(function(){
        $('.adminForm').on('submit', function (e){
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: 'chats1/',
                data: $('#Chatform').serialize(),
                success: function()
                {
                    $(".chatcard1").show();
                    $(".chatcard2").hide();
                    var complaint = $("#complaint").val();
                    document.getElementById("Chatform").reset();
                    var userid = $("#userid").val();
                    var loginid = $("#loginid").val();
                    var tem1 = null;
                        $.ajax({     
                            type: 'GET',
                            url: 'chat1/'+complaint+'/'+userid,
                            dataType: "json",
                            success: function(data){
                                $('#msg2').find('div').remove();
                                $('#msg1').find('div').remove();
                                for(let i = 0; data.present.length > i;  i++){
                                    if(data.present[i].data.sender == loginid){
                                        const myArray1 = data.present[i].data.update_time.split(" ");
                                        if(tem1 == myArray1[0]){                                                                                                                                                                                                                              
                                        }
                                        else{
                                            $("#date").html(myArray1[0]);
                                            tem1 = myArray1[0];
                                        }
                                        const myArray = data.present[i].data.update_time.split(" ");
                                        $("#msg2").append('<div class="media my-2"> '+                                                       
                                                                '<div class="media-body reverse px-1">'+
                                                                    '<div class="chat-msg mt-1" style="float: right;">'+                                                
                                                                    '<small class="text-muted px-1">'+myArray[1]+'</small>'+
                                                                        '<p class="py-1 px-3">'+data.present[i].data.message+'</p>'+
                                                                    '</div> '+                                                           
                                                                '</div>'+
                                                                '<div class="media-img">'+         
                                                                    '<a class="mr-2" href="#" data-toggle="tooltip" data-placement="top" title="&nbsp;'+data.present[i].name+'&nbsp;">'+                                                                              
                                                                        '<img src="uploads/appsetting/'+data.present[i].image+'" alt="user 2" class="rounded-circle thumb-sm">'+  
                                                                    '<a/>'+                                  
                                                                '</div>'+
                                                            '</div>');
                                    }
                                    else if(data.present[i].data.sender != loginid){
                                        const myArray = data.present[i].data.update_time.split(" ");
                                        $("#msg1").append('<div class="media my-2">'+
                                                                '<div class="media-img">'+
                                                                    '<a class="mr-2" href="#" data-toggle="tooltip" data-placement="top" title="&nbsp;'+data.present[i].name+'&nbsp;">'+
                                                                        '<img src="uploads/appsetting/'+data.present[i].image+'" alt="user 2" class="rounded-circle thumb-sm">'+  
                                                                    '<a/>'+                                  
                                                                '</div>'+
                                                                '<div class="media-body px-1">'+                                                  
                                                                    '<div class="chat-msg mt-1">'+
                                                                        '<p class="py-1 px-3">'+data.present[i].data.message+'</p>'+
                                                                        '<small class="text-muted px-1">'+myArray[1]+'</small>'+
                                                                    '</div>'+
                                                                '</div>'+
                                                            '</div>');
                                    }
                                }
                            }
                        });
                }
            });
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
<script src="plugins/filter/isotope.pkgd.min.js"></script>
<script src="plugins/filter/masonry.pkgd.min.js"></script>
<script src="plugins/filter/jquery.magnific-popup.min.js"></script>
<script src="assets/pages/jquery.gallery.init.js"></script>
@endsection