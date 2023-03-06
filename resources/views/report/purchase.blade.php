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
                        <li class="breadcrumb-item active">Purchase Rate History</li>
                    </ol>
                </div>
                <h4 class="page-title">Purchase Rate History</h4>
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
                            <h3>Purchase Rate History</h3>
                        </div>
                    </div>
                    @if($Permission == 1)
                    <div class="row mx-5 text-center py-4" style="border-radius: 5px;">
                        <div class="col-md-3" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Financial Year</b></h6>                            
                            @if(!empty($sessionData['finyr']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{ucfirst($sessionData['finyr'])}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-3" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>RM Code</b></h6>                            
                            @if(!empty($sessionData['rmcode']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['rmcode']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-3" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Item Type</b></h6>                            
                            @if(!empty($sessionData['fromclass']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['fromclass']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-3" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Period</b></h6>                            
                            @if(!empty($sessionData['period']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{ucfirst($sessionData['period'])}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                    </div>
                    @endif
                    <div class="row p-3">
                        <div class="w-100">
                            <table id="datatable2" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th class="text-white" data-orderable="false">SR. No</th>
                                        <th class="text-white" data-orderable="false">Financial <br> Year</th>
                                        <th class="text-white" data-orderable="false">Period</th>
                                        <th class="text-white" data-orderable="false">Item Code</th>
                                        <th class="text-white" data-orderable="false">Item <br> Description</th>
                                        <th class="text-white" data-orderable="false">Purchase <br> Date</th>
                                        <th class="text-white" data-orderable="false">Amount</th>
                                        <th class="text-white" data-orderable="false">Primary <br> Qty</th>
                                        <th class="text-white" data-orderable="false">Pro <br> Expense</th>
                                        <th class="text-white" data-orderable="false">STAX <br> Amount</th>
                                        <th class="text-white" data-orderable="false">Total <br> Amount</th>
                                        <th class="text-white" data-orderable="false">Rate</th>
                                    </tr>
                                </thead>
                                @if($Permission == 1)
                                    <tbody>
                                        @foreach($data as $row)
                                            <tr class="table_row">
                                                <td>{{$i++}}</td>
                                                <td>{{$row["FIN_YEAR"]}}</td>                  
                                                <td>{{$row["PERIOD"]}}</td>                  
                                                <td>{{$row["ITEM_CODE"]}}</td>                  
                                                <td>
                                                <?php
                                                    $test = $row["ITEM_DESC"];
                                                    $explode = explode(" ",$test);
                                                    $String = '';
                                                    $newString = '';
                                                    $maxCharacterCount = 4;
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
                                                <td>{{$row["PURCH_INVOICE_DATE"]}}</td>                  
                                                <td>{{$row["AMOUNT"]}}</td>                  
                                                <td>{{$row["PRIMARY_QTY"]}}</td>                  
                                                <td>{{$row["PRO_EXP_AMOUNT"]}}</td>                  
                                                <td>{{$row["STAX_AMOUNT"]}}</td>                  
                                                <td>{{$row["TOTAL_AMOUNT"]}}</td>                  
                                                <td>{{round($row["RATE"], 2)}}</td>                  
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-dark text-white my-2">
                                        <tr>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false">Total</th>
                                            <th class="text-white" data-orderable="false">{{number_format($t_am,2)}}</th>
                                            <th class="text-white" data-orderable="false">{{number_format($p_qty,2)}}</th>
                                            <th class="text-white" data-orderable="false">{{number_format($stax_amount,2)}}</th>
                                            <th class="text-white" data-orderable="false">{{number_format($pro_qty,2)}}</th>
                                            <th class="text-white" data-orderable="false">{{number_format($total_amount,2)}}</th>
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
            <h5 class="modal-title" id="exampleModalLongTitle">Purchase Rate History</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body px-5 py-1">
                    <form method="post" enctype="multipart/form-data" id="myForm">
                        @csrf
                        <div class="form-group row mb-0">
                            <div class="col-sm-12 mt-3">
                                <label><b style="color: #6c757d">Financial Year</b></label>
                                <select id="finyr" name="finyr" style="border: 1px solid #bfbfbf; text-transform: capitalize;" class="form-control select.custom-select">
                                    <option selected value="all">All</option>   
                                    @foreach($financial as $value)
                                        @if(!empty($sessionData['finyr']))
                                            <option <?php if($value == $sessionData['finyr']) echo 'selected="selected"'; ?> value="{{$value}}">{{$value}}</option>
                                        @else
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endif  
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 mt-3">
                            <label><b style="color: #6c757d">RM Code</b></label>
                                <input id="rmcode" <?php if(isset($sessionData['rmcode'])) echo "value='{$sessionData['rmcode']}'"; ?>  name="rmcode" type="text" class="typeahead form-control yourclass" style="border: 1px solid #bfbfbf;" placeholder="RM Code">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 mt-3">
                                <label><b style="color: #6c757d">Item Type</b></label>
                                <select id="typefrom" name="typefrom" style="border: 1px solid #bfbfbf; text-transform: capitalize;" class="select2 form-control mb-3 custom-select">
                                    <option selected value="">Item Type</option> 
                                    @foreach($itemtype1 as $value)
                                        @if(!empty($sessionData['fromclass']))
                                            <option <?php if($value == $sessionData['fromclass']) echo 'selected="selected"'; ?> value="{{$value}}">All {{$value}}</option>
                                        @else
                                            <option value="{{$value}}">All {{$value}}</option>
                                        @endif  
                                    @endforeach
                                    <?php
                                        foreach($itemtype2 as $data){
                                            echo "<option value=".$data['value'].">".$data['value']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-12 mt-3">
                                <label><b style="color: #6c757d">Period</b></label>
                                <select id="period" name="period" style="border: 1px solid #bfbfbf; text-transform: capitalize;" class="select2 form-control mb-3 custom-select">
                                    <option selected value="">Select Period</option>   
                                    @foreach($period as $value)
                                        @if(!empty($sessionData['period']))
                                            <option <?php if($value == $sessionData['period']) echo 'selected="selected"'; ?> value="{{$value}}">{{$value}}</option>
                                        @else
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endif  
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
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
    $("#myForm").attr("action", "purchase-report");
    document.getElementById("myForm").submit();
});
$("#download").click(function(){
    $("#myForm").attr("action", "purchase-report-download");
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
var path2 = "{{route('rmcode')}}";
$("#rmcode").autocomplete({
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
            $('#rmcode').val(ui.item.label);
            console.log(ui.item); 
            return false;
        }
});
</script>
@endsection