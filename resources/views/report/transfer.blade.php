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
    #loader2 
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
<div id="loader2" class="rotate" width="100" height="100"></div>
<div class="container-fluid px-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Transfer Issue Report</li>
                    </ol>
                </div>
                <h4 class="page-title">Transfer Issue Report</h4>
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
                            <h3>Transfer Issue Report</h3>
                        </div>
                    </div>
                    @if($Permission == 1)
                    <div class="row mx-5 text-center py-4" style="border-radius: 5px;">
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Book</b></h6>                            
                            @if(!empty($sessionData['storebook']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['storebook']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Date From</b></h6>                            
                            @if(!empty($sessionData['Storestart']))
                            <p class="mb-2" style="font-family: 'Poppins';"> {{$sessionData['Storestart']}} - {{$sessionData['Storeend']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>From Locator</b></h6>                            
                            @if(!empty($sessionData['storefrom_locator']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['storefrom_locator']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>To Locator</b></h6>                            
                            @if(!empty($sessionData['storeto_locator']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['storeto_locator']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Transaction No</b></h6>                            
                            @if(!empty($sessionData['storetransfer']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['storetransfer']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div>  
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Reference No</b></h6>                            
                            @if(!empty($sessionData['storereference']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['storereference']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div>  
                        @if($from_locatorVal)
                        <input type="text" id="lNo" value="{{$from_locatorVal}}" hidden>
                        @endif
                        @if($to_locatorVal)
                        <input type="text" id="tNo" value="{{$to_locatorVal}}" hidden>
                        @endif
                        @if($book)
                        <input type="text" id="bNo" value="{{$book}}" hidden> 
                        @endif
                    </div>
                    @endif
                    <div class="row p-3">
                        <div class="w-100">
                            <table id="datatable-buttons" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th hidden class="text-white">1</th>
                                        <th class="text-white" data-orderable="false">Trans Date</th>
                                        <th class="text-white" data-orderable="false">Trans No</th>
                                        <th class="text-white" data-orderable="false">From</th>
                                        <th class="text-white" data-orderable="false">To</th>
                                        <th class="text-white" data-orderable="false">Item Code</th>
                                        <th class="text-white" data-orderable="false">Item Description</th>
                                        <th class="text-white" data-orderable="false">Reference</th>
                                        <th class="text-white" data-orderable="false">Remarks</th>
                                        <th class="text-white" data-orderable="false">Det Remarks</th>
                                        <th class="text-white" data-orderable="false">Unit</th>
                                        <th class="text-white" data-orderable="false">Quantity</th>
                                        <th class="text-white" data-orderable="false">Rate</th>
                                        <th class="text-white" data-orderable="false">Amount</th>
                                    </tr>
                                </thead>
                                @if($Permission == 1)
                                    <tbody>
                                        @foreach($data as $row)
                                            <tr class="table_row">
                                                <td hidden>1</td>
                                                <td>{{$row["TRANS_DATE"]}}</td>
                                                <td>{{$row["TRANS_NO"]}}</td>
                                                <td>{{$row["FLOC"]}}</td>
                                                <td>{{$row["TLOC"]}}</td>
                                                <td>{{$row["ITEM_CODE"]}}</td>
                                                <td>{{$row["ITEM_DESC"]}}</td>
                                                <td>{{$row["REF_NO"]}}</td>
                                                <td>{{$row["REMARKS"]}}</td>
                                                <td>{{$row["DETREMARKS"]}}</td>
                                                <td>{{$row["UOM_SHORT_DESC"]}}</td>
                                                <td>{{$row["PIRMARY_QTY"]}}</td>
                                                <td>{{round($row["AMOUNT"]/$row["PIRMARY_QTY"],2)}}</td>
                                                <td>{{number_format($row["AMOUNT"],2)}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-dark">  
                                        <tr>
                                            <th hidden></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false">Grand Total</th>
                                            <th class="text-white" data-orderable="false">{{$sum_qty,2}}</th>
                                            <th class="text-white" data-orderable="false">{{$sum_rate,2}}</th>
                                            <th class="text-white" data-orderable="false">{{$sum_amount,2}}</th>
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
        <h5 class="modal-title" id="exampleModalLongTitle">Transfer Issue Report</h5>
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
                            <select id="books" name="books" style="border: 1px solid #bfbfbf;" class="select2 form-control mb-3 custom-select required">
                            <option selected value="">Select Book</option>
                                @foreach($books as $value)
                                    @if(!empty($sessionData['storebook']))
                                        <option <?php if($value == $sessionData['storebook']) echo 'selected="selected"'; ?> value="{{$value}}">{{$value}}</option>
                                    @else
                                        <option value="{{$value}}">{{$value}}</option>
                                    @endif  
                                @endforeach   
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label><b style="color: #6c757d">Transfer No</b></label>
                            <span style="display: flex;">
                                <input readonly type="text" <?php if(isset($transferVal)) echo "value='{$transferVal}'"; ?> class="form-control py-2 yourclass we" style="border: 1px solid #bfbfbf; text-transform: capitalize;" id="transfer" name="transfer" placeholder="Select Transfer No">
                                <span>
                                    <a data-toggle="modal" data-target="#exampleModalCenter212" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group row py-1">
                        <div class="col-sm-6">
                            <label><b style="color: #6c757d">Select Date</b></label>
                            <div class="input-group" style="border: 1px solid #bfbfbf;">                                            
                                <input type="text" class="form-control" name="daterange" <?php if(isset($strtdte3a)) echo "value='{{$strtdte2a}} - {{$strtdte3a}}'"; ?>>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="dripicons-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-1 mb-sm-0">
                            <label><b style="color: #6c757d">Reference No</b></label>
                            <input type="text" <?php if(isset($referenceVal)) echo "value='{$referenceVal}'"; ?> class="form-control py-2 formfield w0 yourclass" style="border: 1px solid #bfbfbf;" id="reference" name="reference" placeholder="Enter Reference No">
                        </div>
                    </div>
                    <div class="form-group row py-2">
                        <div class="col-sm-6 mb-1 mb-sm-0">
                            <label><b style="color: #6c757d">From Locator</b></label>
							<select id="from_locator" name="from_locator" style="border: 1px solid #bfbfbf; text-transform: capitalize;" class="select2 form-control mb-3 custom-select">
                            <option selected value="">Select Locator</option>
                                @foreach($locator as $value)
                                    @if(!empty($sessionData['storefrom_locator']))
                                        <option <?php if($value == $sessionData['storefrom_locator']) echo 'selected="selected"'; ?> value="{{$value}}">{{$value}}</option>
                                    @else
                                        <option value="{{$value}}">{{$value}}</option>
                                    @endif  
                                @endforeach  
                            </select>
                        </div>
                        <div class="col-sm-6 mb-1 mb-sm-0">
                            <label><b style="color: #6c757d">To Locator</b></label>
							<select id="to_locator" name="to_locator" style="border: 1px solid #bfbfbf; text-transform: capitalize;" class="select2 form-control mb-3 custom-select">
                            <option selected value="">Select Locator</option>
                                @foreach($locator as $value)
                                    @if(!empty($sessionData['storeto_locator']))
                                        <option <?php if($value == $sessionData['storeto_locator']) echo 'selected="selected"'; ?> value="{{$value}}">{{$value}}</option>
                                    @else
                                        <option value="{{$value}}">{{$value}}</option>
                                    @endif  
                                @endforeach  
                            </select>
                        </div>
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
@include('model/transfer2')
<script src="assets/js/customjquery.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
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
    $("#myForm").attr("action", "transfer-report");
    document.getElementById("myForm").submit();
});
$("#download").click(function(){
    $("#myForm").attr("action", "transfer-report-download");
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
$("#loader2").hide();
$("#reportModel").on('click',function(){
    $("#exampleModalCenter").modal('show');
});
</script>
@endsection