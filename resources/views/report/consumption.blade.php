@extends( (Auth::user()->id == "2") ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<!-- <link href="plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">
<link href="plugins/lightpick/lightpick.css" rel="stylesheet" /> -->
<style>
    .yourclass::-webkit-input-placeholder{
        color: #6c757d;
    }
    table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>td:first-child:before, table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>th:first-child:before {
        top: 12px;
        left: 4px;
        height: 14px;
        width: 14px;
        display: block;
        position: absolute;
        color: white;
        border: 2px solid white;
        border-radius: 14px;
        box-shadow: 0 0 3px #444;
        box-sizing: content-box;
        text-align: center;
        text-indent: 0 !important;
        font-family: 'Courier New', Courier, monospace;
        line-height: 15px;
        content: '+';
        background-color: #0275d8;
    }
    .buttons-copy, .buttons-pdf{
        display: none;
    }
    .buttons-excel, .buttons-collection{
        background: #1761fd;
        border: none;
        box-shadow: none;
    }
    .buttons-html5{
        border-top-left-radius: 5px !important;
        border-bottom-left-radius: 5px !important;
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
    .yourclass::-webkit-input-placeholder{
        color: #6c757d;
    }
    select[id="typefrom"]>option:nth-child(2), select[id="typefrom"]>option:nth-child(3), select[id="typefrom"]>option:nth-child(4), select[id="typefrom"]>option:nth-child(5), select[id="typefrom"]>option:nth-child(6), select[id="typefrom"]>option:nth-child(7) {
        font-weight:bold;
    }
</style>
<div id="loader1" class="rotate" width="100" height="100"></div>
<div class="container-fluid px-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Consumption Exception Report</li>
                    </ol>
                </div>
                <h4 class="page-title">Consumption Exception Report</h4>
                <br>
                <button style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); border: none;" type="button" class="btn text-white" id="reportModel">View Report</button>
            </div>
        </div>
    </div>
    <div class="row mb-5 mt-4">
        <div class="col-lg-12 col-sm-12 mb-5">
            <div class="card">
                <div class="card-body table-responsive">
                <div class="row px-5">
                        <div class="col-md-3 align-self-center">
                        </div>
                        <div class="col-md-6 align-self-center text-center">
                            <h3>Consumption Exception Report</h3>
                        </div>
                    </div>
                    @if($Permission == 1)
                    <div class="row mx-5 text-center py-4" style="border-radius: 5px;">
                        <div class="col-md-4" style="border-top: 1px solid; border-bottom: 1px solid;">
                        </div>
                        <div class="col-md-4" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Date Range</b></h6>                            
                            @if(!empty($sessionData['Storestart1']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['Storestart1']}} - {{$sessionData['Storeend2']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-4" style="border-top: 1px solid; border-bottom: 1px solid;">
                        </div>
                    </div>
                    @endif
                    <div class="row p-3">
                        <div class="w-100">
                            <table id="datatable-buttons" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th class="text-white" data-orderable="false">Book</th>
                                        <th class="text-white" data-orderable="false">Issue <br> No</th>
                                        <th class="text-white" data-orderable="false">Issue <br> Date </th>
                                        <th class="text-white" data-orderable="false">Item <br> Code</th>
                                        <th class="text-white" data-orderable="false">Item <br> Desc</th>
                                        <th class="text-white" data-orderable="false">Qty</th>
                                        <th class="text-white" data-orderable="false">Amount</th>
                                        <th class="text-white" data-orderable="false">Contra A/C Code</th>
                                        <th class="text-white" data-orderable="false">Contra A/C Desc</th>
                                    </tr>
                                </thead>
                                @if($Permission == 1)
                                    <tbody>
                                        @foreach($data as $row)
                                            <tr class="table_row">
                                                <td>
                                                    <?php $explode = explode(" ",$row['data']["INV_BOOK_DESC"]); ?>
                                                    @foreach($explode as $data1)
                                                        {{$data1}}<br>
                                                    @endforeach
                                                </td>              
                                                <td>{{$row['data']["ISSUE_NO"]}}</td>        
                                                <td>{{$row['data']["ISSUE_DATE"]}}</td>  
                                                <td>{{$row['data']["ITEM_CODE"]}}</td>                                 
                                                <td>
                                                    <?php $explode = explode(" ",$row['data']["ITEM_DESC"]); ?>
                                                    @foreach($explode as $data1)
                                                        {{$data1}}<br>
                                                    @endforeach
                                                </td>                                  
                                                <td>{{$row['data']["PRIMARY_QTY"]}}</td>                  
                                                <td>{{$row['data']["ISSUE_AMOUNT"]}}</td>    
                                                <td>
                                                    <?php $explode = explode(" ",$row['data']["CODE_VALUE"]); ?>
                                                    @foreach($explode as $data1)
                                                        {{$data1}}<br>
                                                    @endforeach
                                                </td>  
                                                <td>
                                                    <?php $explode = explode(" ",$row['data']["CODE_DESC"]); ?>
                                                    @foreach($explode as $data1)
                                                        {{$data1}}<br>
                                                    @endforeach
                                                </td>                
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-dark text-white my-2">
                                        <tr>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false">Grand Total</th>
                                            <th class="text-white" data-orderable="false">{{number_format($sum_qty,2)}}</th>
                                            <th class="text-white" data-orderable="false">{{number_format($sum_amount,2)}}</th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                        </tr>
                                    </tfoot>
                                @endif
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-md" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content" style="margin-top: 20%;">
            <div class="modal-header" style="background: transparent !important;">
            <h5 class="modal-title" id="exampleModalLongTitle">Consumption Exception Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body px-5 py-1">
                    <form method="post" enctype="multipart/form-data" id="myForm">
                        @csrf
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <label><b style="color: #6c757d">Select Date</b></label>
                                <div class="input-group" style="border: 1px solid #bfbfbf;">   
                                    <input type="text" class="form-control" <?php if(isset($sessionData['strtdte3a'])) echo "value='{{$sessionData['strtdte2a']}} - {{$sessionData['strtdte3a']}}'"; ?> name="daterange">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="dripicons-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>                          
                        <div class="form-group row py-1">
                        </div>
                        <div class="form-group row mt-2">
                            <div class="col-sm-12">
                                <button type="submit" id="submit" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); border: none;" class="btn px-5 py-1 btn-md btn-block text-white">Show</button>
                            </div>
                            <div class="col-sm-12 mt-3">
                                <button type="submit" id="download" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); border: none;" class="btn px-5 py-1 btn-md btn-block text-white">Download</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer" style="background: transparent !important;">
                <button type="button" style="background: #1e2438; border: none;" class="btn text-white" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/customjquery.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script src="assets/js/cdn1.min.js"></script>
<script src="assets/js/cdn2.min.js"></script>
<script>
$(document).ready(function(){ 
    $("#loader1").fadeOut(1200);
    $("body").addClass("enlarge-menu");
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
    });
    break;
}
@endif
$('#deppp').on('change', function(){
    document.getElementById("myForm").submit();
});
$("#submit").click(function(){
    $("#myForm").attr("action", "consumption-report");
    document.getElementById("myForm").submit();
});
$("#download").click(function(){
    $("#myForm").attr("action", "consumption-report-download");
    document.getElementById("myForm").submit();
});

$(document).ready(function(){
    $(".btnSelectuser").on('click',function(){
        var currentRow = $(this).closest("tr");
        var col1 = currentRow.find("td:eq(1)").html();
        $("#exampleModalCenter212").modal('hide');
        $("#transfer").val(col1);
    });
});

$("#reportModel").on('click',function(){
    $("#exampleModalCenter").modal('show');
});
</script>
<script>
    var path1 = "{{route('joborderno')}}";
    var path2 = "{{route('purchaseorderno')}}";
    var path3 = "{{route('salesorderno')}}";  
    var path4 = "{{route('articleno')}}";  
    $("#joborder").autocomplete({
        source: function(request, response){
            $.ajax({
                url: path1,
                type: 'GET',
                dataType: "json",
                data: {
                    search: request.term
                },
                success: function(data){
                    response(data);
                }
            });
        },
        select: function(event, ui){
            $('#joborder').val(ui.item.label);
            console.log(ui.item); 
            return false;
        }
    });
    $("#purchaseorder").autocomplete({
            source: function(request, response){
                $.ajax({
                    url: path2,
                    type: 'GET',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function(data){
                        response(data);
                    }
                });
            },
            select: function(event, ui){
                $('#purchaseorder').val(ui.item.label);
                console.log(ui.item); 
                return false;
            }
    });
    $("#salesorder").autocomplete({
        source: function(request, response){
            $.ajax({
                url: path3,
                type: 'GET',
                dataType: "json",
                data: {
                    search: request.term
                },
                success: function(data){
                    response(data);
                }
            });
        },
        select: function(event, ui){
            $('#salesorder').val(ui.item.label);
            console.log(ui.item); 
            return false;
        }
    });
    $("#articleno").autocomplete({
        source: function(request, response){
            $.ajax({
                url: path4,
                type: 'GET',
                dataType: "json",
                data: {
                    search: request.term
                },
                success: function(data){
                    response(data);
                }
            });
        },
        select: function(event, ui){
            $('#articleno').val(ui.item.label);
            console.log(ui.item); 
            return false;
        }
    });
</script>
@endsection