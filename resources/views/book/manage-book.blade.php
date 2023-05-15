@extends( (Auth::user()->id == "2") ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<style>

select[id="typefrom"]>option:nth-child(2), select[id="typefrom"]>option:nth-child(3), select[id="typefrom"]>option:nth-child(4), select[id="typefrom"]>option:nth-child(5), select[id="typefrom"]>option:nth-child(6), select[id="typefrom"]>option:nth-child(7) {
        font-weight:bold;
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
    #loader1{  
        position: fixed;  
        left: 0px;  
        top: 0px;  
        width: 100%;  
        height: 100%;  
        z-index: 9999;  
        background: url("/img/avatars/3dgifmaker.gif") 50% 50% no-repeat black;  
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove{
        color: #463f3f;
        cursor: pointer;
        display: inline-block;
        font-weight: bold;
        margin-right: 2px;
        margin-bottom: 2px;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__rendered li{
        list-style: none;
        color: black;
    }
</style>
<div id="loader1" class="rotate" width="100" height="100"></div>
<div class="page-content">
    <div class="container-fluid px-5">
        <div class="row px-2">
            <div class="col-sm-12 px-1">
                <div class="page-title-box">
                    <div class="float-right">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Manage Book</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Manage Book</h4><br>
                    <span class="btn py-1 btn-lg btn-block text-white w-25" id="save" style="border: none; font-size: 17px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); cursor: pointer;">Update Books</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card mb-5">
                    <div class="card-body table-responsive p-5">
                        <div class="">
                            <table id="datatable2" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Role</th>
                                        <th>Books</th>
                                        <th>Date & Time</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($book as $user) 
                                        <tr class="table_row">
                                            <td>{{$i++}}</td>
                                            <td>{{$user->Role['name']}}</td>
                                            <td>
                                            <?php 
                                                $data = DB::table("books")->where("id", $user->id)->pluck('book_name');
                                                if($data){
                                                    foreach($data as $val){
                                                        $value = str_replace('[', '', $val);
                                                        $value = str_replace(']', '', $value);
                                                        $str_arr = explode (",", $value);
                                                    }     
                                                }
                                            ?>
                                            <?php $count = count($str_arr); ?>
                                            @if(!$str_arr)
                                            @else
                                                @foreach($str_arr as $data)
                                                    <?php $dataVal = DB::table("allbooks")->where("key_id", $data)->get(); ?>
                                                    @if(count($dataVal) != 0)
                                                        {{$dataVal[0]->book}} 
                                                        @if($count > 1)
                                                            <span style="font-weight: 700;">|</span> 
                                                        @endif
                                                        <?php $count--; ?>
                                                    @endif
                                                @endforeach
                                            @endif
                                            </td>
                                            <td>
                                                @if(isset($user->created_at) && !empty($user->created_at)) 
                                                    @if($user->created_at!=NULL)
                                                    <?php $delimiter = ' '; $words = explode($delimiter, $user->created_at); $today1 = date("h:i A", strtotime($words[1])); ?>
                                                    <i class="mdi mdi-calendar-text-outline"></i> {{$words[0]}} <br><i class="mdi mdi-timer"></i> {{$today1}}
                                                    @else
                                                    <?php $delimiter = ' '; $words = explode($delimiter, $user->created_at);  $today1 = date("h:i A", strtotime($words[1]));?>
                                                    <i class="mdi mdi-calendar-text-outline"></i> {{$words[0]}} <br><i class="mdi mdi-timer"></i> {{$today1}}
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                <a href="book-edit?id={{$user['id']}}" target="_blank"><span id="view" data-id={{$user['id']}} style="cursor: pointer;" class="badge badge-primary p-0 rounded-circle cursor-pointer viewweye1 ml-1"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="edit"></i></span></a>
                                                <span data-id={{$user['id']}} style="cursor: pointer;" class="badge badge-danger p-0 mx-1 rounded-circle cursor-pointer delete"><i class="align-middle mb-1 mt-1 mx-1 w-50" data-feather="trash"></i></span>                                                        
                                            </td>
                                            <div class="modal fade" id="exampleModalCenter5" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header" style="background: transparent;">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Delete Book?</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            Select "Delete" below if you are ready to delete Book?
                                                        </div>
                                                        <div class="modal-footer" style="background: transparent;">
                                                            <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                                            <button id="delete-book" type="button" class="btn btn-danger">Delete</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
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
<script src="assets/js/customjquery.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script>
    $(document).ready(function(){ 
        $("#loader1").fadeOut(1200);
    });
</script>
<script>
    $("#save").click(function(){
        $.ajax({
            type: 'GET',
            url: 'updateorcreate',
            dataType: "json",
            success: function(data){
                Swal.fire({
                    icon: 'info',
                    title: data.message,
                    showConfirmButton: false,
                    timer: 2000
                });
            }
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
        });
        break;
    }
@endif
</script>
<script>
    $(".delete").click(function(){
        var id = $(this).attr("data-id");
        $("#delete-book").attr("data-id", id);
        $('#exampleModalCenter5').modal('show');
    });
    $("#delete-book").click(function(){
        var id = $(this).attr("data-id");
        deletebook(id);
    });
    function deletebook(id){
        $.ajax({
                type: 'GET',
                url: 'deleteBook/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Book Deleted',
                        });
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!',
                        });
                    }
                }
            });
        }
</script>
@endsection