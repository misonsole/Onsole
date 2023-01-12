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
    $tmp = null;
    $tmp1 = null;
    $tmp2 = null;
    $tmp3 = null;
    $tmp4 = null;
    $tmp5 = null;
    $tmp6 = null;
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
    .btn:hover, .btn:active, .btn:visited 
    {
        background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;
        border: 1px solid transparent !important;
        color: white;
    }
    .buttons-copy, .buttons-pdf
    {
        display: none;
    }
    .buttons-excel, .buttons-collection
    {
        background: #1761fd;
        border: none;
        box-shadow: none;
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
        <div class="row px-1">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="float-right">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{url('objective-manage-new')}}">Manage Objectives</a></li>
                            <li class="breadcrumb-item active">All Objectives</li>
                        </ol>
                    </div>
                    <h4 class="page-title">All Objectives</h4>                     
                </div>
            </div>
        </div>
        <div class="row">
            @if(isset($dep))
                <div class="col-3">
                    <form action="{{url('obj-department')}}" id="myForm" method="post" enctype="multipart/form-data">
                        @csrf
                        <label for="exampleInputEmail1"><strong>Select Department</strong></label>
                        <select id="deppp" name="dep" class="form-control">
                            <option selected disabled>Select Department</option>   
                            @foreach($dep as $name)
                                <option <?php if($name->name == $department) echo 'selected="selected"'; ?> value="{{ $name->name }}">{{ $name->name }}</option>
                            @endforeach
                        </select><br>
                    </form>
                </div>
            @endif
            <div class="col-lg-12 col-sm-12 mb-4">
                <div class="card">
                    <div class="card-body table-responsive p-5">
                        <div class="">
                            <table id="datatable-buttons" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th >No</th>
                                        <th>Employee</th>
                                        <th>Code</th>
                                        <th data-orderable="true" class="px-2">Department</th>
                                        <th data-orderable="false" class="px-2">S. No</th>
                                        <th data-orderable="false" class="px-2">Title</th>
                                        <th data-orderable="false" class="px-2">Description</th>
                                        <th data-orderable="false" class="px-5">Status</th>
                                        <th data-orderable="false" class="px-2">Weightage</th>
                                        <th data-orderable="false" class="px-2">Feedback</th>
                                        <th data-orderable="false" class="px-2">Score</th>
                                        <th data-orderable="false" class="px-2">Total Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $user)
                                    <tr>
                                        <td>{{$j++}}</td>  
                                        <td>
                                            @if($tmp == $user->memberName)
                                                {{$user->memberName}}
                                                <?php $tem1 = null;?>
                                            @else
                                                {{$user->memberName}}
                                                <?php $tmp = $user->memberName; $tmp1 = null; $tmp2 = null;  $tmp3 = null; $i = 1;?>
                                            @endif 
                                        </td>
                                        <td>
                                            @if($tmp3 == $user->emp_code)
                                                {{$user->emp_code}}
                                            @else
                                                {{$user->emp_code}}
                                                <?php $tmp3 = $user->emp_code ?>
                                            @endif 
                                        </td>
                                        <td>
                                            @if($tmp2 == $user->department)
                                                <?php $explode = explode(" ",$user->department); ?>
                                                @foreach($explode as $data1)
                                                    {{$data1}}<br>
                                                @endforeach 
                                            @else
                                                <?php $explode = explode(" ",$user->department); ?>
                                                @foreach($explode as $data1)
                                                    {{$data1}}<br>
                                                @endforeach                                              
                                            @endif 
                                        </td>
                                        <td>{{$i++}}</td>  
                                        <td>
                                            <?php
                                                $test = $user->objTitle;
                                                $explode = explode(" ",$test);
                                                $String = '';
                                                $newString = '';
                                                $maxCharacterCount = 10;
                                                foreach($explode as $key => $value){
                                                    $strlen=strlen($String);
                                                    if($strlen<=$maxCharacterCount){
                                                            $String.=' '.$value;
                                                        }else{
                                                            $newString.=$String.' '.$value.'<br>';
                                                            $String='';
                                                        }
                                                    }
                                                $finalString= $newString.$String;
                                                echo $finalString;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                $test = $user->objDescription;
                                                $explode = explode(" ",$test);
                                                $String = '';
                                                $newString = '';
                                                $maxCharacterCount = 20;
                                                foreach($explode as $key => $value){
                                                    $strlen=strlen($String);
                                                    if($strlen<=$maxCharacterCount){
                                                            $String.=' '.$value;
                                                        }else{
                                                            $newString.=$String.' '.$value.'<br>';
                                                            $String='';
                                                        }
                                                    }
                                                $finalString= $newString.$String;
                                                echo $finalString;
                                            ?>
                                        </td>
                                        <td>
                                            @if($user->objStatus == 1)    
                                                <span class="badge badge-md badge-boxed badge-soft-warning p-2 w-75">Pending</span>
                                            @elseif($user->objStatus == 2)
                                                @if($departmentuser == 'Human Resources')
                                                <span class="badge badge-md badge-boxed badge-soft-success p-2 w-75">Review</span>
                                                @else
                                                <span class="badge badge-md badge-boxed badge-soft-success p-2 w-75">In-Review HR</span>
                                                @endif
                                            @elseif($user->objStatus == 3)
                                                <span class="badge badge-md badge-boxed badge-soft-danger p-2 w-75">Revision</span>
                                            @elseif($user->objStatus == 4)
                                                <span class="badge badge-md badge-boxed badge-soft-secondary p-2 w-75">Finalised</span>
                                            @endif
                                        </td>
                                        <td>{{$user->objWeightage}}<span style="margin-left: 3%;">%</span></td>
                                        @if(isset($user->review))
                                        <td>
                                        <?php
                                            $test = $user->review;
                                            $explode=explode(" ",$test);
                                            $String='';
                                            $newString='';
                                            $maxCharacterCount=8;
                                            foreach ($explode as $key => $value) {
                                                $strlen=strlen($String);
                                                if($strlen<=$maxCharacterCount){
                                                        $String.=' '.$value;
                                                    }else{
                                                        $newString.=$String.' '.$value.'<br>';
                                                        $String='';
                                                    }
                                                }
                                                $finalString= $newString.$String;
                                                echo $finalString;
                                            ?>
                                        </td>
                                        @else
                                        <td>
                                        </td>
                                        @endif
                                        <td>
                                        @if(!$user->score)
                                            -
                                        @else
                                            {{$user->score}}<span style="margin-left: 3%;">%</span>    
                                        @endif                                          
                                        </td>
                                        <td>
                                            @if(!$user->totalscore)
                                                -
                                            @else
                                                @if($tmp6 == $user->totalscore.''.$user->emp_code)
                                                    -
                                                @else
                                                    {{$user->totalscore}}<span style="margin-left: 3%;">%</span>
                                                    <?php $tmp6 = $user->totalscore.''.$user->emp_code; ?>
                                                @endif 
                                            @endif 
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
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
<script>
    $('#deppp').on('change', function() {
    document.getElementById("myForm").submit();
});
</script>
@endsection
