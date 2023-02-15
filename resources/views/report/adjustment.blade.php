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
    .buttons-html5
    {
        border-top-left-radius: 5px !important;
        border-bottom-left-radius: 5px !important;
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
</style>
<div id="loader1" class="rotate" width="100" height="100"></div>
<div class="container-fluid px-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Item Adjustment Report</li>
                    </ol>
                </div>
                <h4 class="page-title">Item Adjustment Report</h4>
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
                            <h3>Item Adjustment Report</h3>
                        </div>
                    </div>
                    @if($Permission == 1)
                    <div class="row mx-5 text-center py-4" style="border-radius: 5px;">
                        <div class="col-md-1" style="border-top: 1px solid; border-bottom: 1px solid;">
                        </div>  
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Book</b></h6>                            
                            @if(!empty($sessionData['book']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['book']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>From Date</b></h6>                            
                            @if(!empty($sessionData['start']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['start']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>To Date</b></h6>                            
                            @if(!empty($sessionData['end']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['end']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Status</b></h6>                            
                            @if(!empty($sessionData['status']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['status']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Adjustment No</b></h6>                            
                            @if(!empty($sessionData['adjustno']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['adjustno']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div>  
                        <div class="col-md-1" style="border-top: 1px solid; border-bottom: 1px solid;">
                        </div>  
                    </div>
                    @endif
                    <div class="row p-3">
                        <div class="w-100">
                            <table id="datatable-buttons" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th class="text-white">Adj No</th>
                                        <th class="text-white" data-orderable="false">Adj Date</th>
                                        <th class="text-white" data-orderable="false">Remarks</th>
                                        <th class="text-white" data-orderable="false">SR NO</th>
                                        <th class="text-white" data-orderable="false">Item Code</th>
                                        <th class="text-white" data-orderable="false">Item Description</th>
                                        <th class="text-white" data-orderable="false">Unit</th>
                                        <th class="text-white" data-orderable="false">Quantity</th>
                                        <th class="text-white" data-orderable="false">Rate</th>
                                        <th class="text-white" data-orderable="false">Amount</th>
                                        <th class="text-white" data-orderable="false">Contra A/C Code</th>
                                    </tr>
                                </thead>
                                @if($Permission == 1)
                                    <tbody>
                                        @foreach($data as $row)
                                            <tr class="table_row">
                                                <td>{{$row['data']["ADJUSTMENT_NO"]}}</td>
                                                <td>{{$row['data']["ADJUSTMENT_DATE"]}}</td>
                                                <td>{{$row['data']["REMARKS"]}}</td>
                                                <td>{{$row['data']["SR_NO"]}}</td>
                                                <td>{{$row['data']["ITEM_CODE"]}}</td>
                                                <td>{{$row['data']["ITEM_DESC"]}}</td>
                                                <td>{{$row['data']["UOM_DESC"]}}</td>
                                                <td>{{$row['data']["PRIMARY_QTY"]}}</td>
                                                <td>{{round($row['rate'],2)}}</td>
                                                <td>{{number_format($row['data']["LINE_AMOUNT"],2)}}</td>
                                                <td>{{$row['data']["CODE_VALUE"]}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-dark">  
                                        <tr>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false">Grand Total</th>
                                            <th class="text-white" data-orderable="false">{{number_format($sum_qty,2)}}</th>
                                            <th class="text-white" data-orderable="false">{{number_format($sum_rate,2)}}</th>
                                            <th class="text-white" data-orderable="false">{{number_format($sum_amount,2)}}</th>
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
<div class="modal fade bd-example-modal-lg" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="margin-top: 15%;">
            <div class="modal-header" style="background: transparent !important;">
            <h5 class="modal-title" id="exampleModalLongTitle">Item Adjustment Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body px-5 py-1">
                    <form method="post" enctype="multipart/form-data" id="myForm">
                        @csrf
                        <div class="form-group row py-2">
                            <div class="col-sm-6 mb-1 mb-sm-0">
                                <label><b style="color: #6c757d">Select Book</b></label>
                                <select id="book" name="book" style="border: 1px solid #bfbfbf;" class="select2 form-control mb-3 custom-select" required>
                                    <option value="none" selected>None</option>
                                    @foreach($books as $value)
                                        @if(!empty($sessionData['book']))
                                            <option <?php if($value == $sessionData['book']) echo 'selected="selected"'; ?> value="{{ $value }}">{{ $value }}</option>
                                        @else
                                            <option value="{{ $value }}">{{ $value }}</option>
                                        @endif                    
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label><b style="color: #6c757d">Status</b></label>
                                <select id="status" name="status" style="border: 1px solid #bfbfbf;" class="form-control select.custom-select">
                                        @if(!empty($sessionData['status']))
                                            <option <?php if("Both" == $sessionData['status']) echo 'selected="selected"'; ?> value="Both">Both</option>
                                            <option <?php if("Posted" == $sessionData['status']) echo 'selected="selected"'; ?> value="Posted">Posted</option>
                                            <option <?php if("UnPosted" == $sessionData['status']) echo 'selected="selected"'; ?> value="UnPosted">Un-Posted</option>
                                        @else
                                            <option value="Both">Both</option>   
                                            <option value="Posted">Posted</option>                    
                                            <option value="UnPosted">Un-Posted</option>   
                                        @endif                   
                                </select>
                            </div>
                        </div>
                        <div class="form-group row py-2">
                            <div class="col-sm-6">
                                <label><b style="color: #6c757d">Select Date</b></label>
                                <div class="input-group" style="border: 1px solid #bfbfbf;">   
                                    <input type="text" class="form-control" <?php if(isset($sessionData['strtdte3a'])) echo "value='{{$sessionData['strtdte2a']}} - {{$sessionData['strtdte3a']}}'"; ?> name="daterange">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="dripicons-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-1 mb-sm-0">
                                <label><b style="color: #6c757d">Adjustment No</b></label>
                                <select id="adjustno" name="adjustno" style="border: 1px solid #bfbfbf;" class="select2 form-control mb-3 custom-select">
                                    <option value="" selected>None</option>
                                    @foreach($adjustment as $value)                   
                                        @if(!empty($sessionData['adjustno']))
                                            <option <?php if($value == $sessionData['adjustno']) echo 'selected="selected"'; ?> value="{{ $value }}">{{ $value }}</option>
                                        @else
                                            <option value="{{ $value }}">{{ $value }}</option>
                                        @endif   
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row py-1">
                        </div>
                        <div class="form-group row mt-2">
                            <div class="col-sm-6">
                                <button type="submit" id="submit" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); border: none;" class="btn px-5 py-1 btn-md btn-block text-white">Show</button>
                            </div>
                            <div class="col-sm-6">
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
    $("#myForm").attr("action", "adjustment-report");
    document.getElementById("myForm").submit();
});
$("#download").click(function(){
    $("#myForm").attr("action", "adjustment-report-download");
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
@endsection