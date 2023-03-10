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
                        <li class="breadcrumb-item active">Job Order Report</li>
                    </ol>
                </div>
                <h4 class="page-title">Job Order Report</h4>
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
                            <h3>Job Order Report</h3>
                        </div>
                    </div>
                    @if($Permission == 1)
                    <div class="row mx-5 text-center py-4" style="border-radius: 5px;">
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Job Order</b></h6>                            
                            @if(!empty($sessionData['joborder']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{ucfirst($sessionData['joborder'])}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-1" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Department</b></h6>                            
                            @if(!empty($sessionData['department']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['department']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-1" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Season</b></h6>                            
                            @if(!empty($sessionData['season']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['season']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-1" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Article</b></h6>                            
                            @if(!empty($sessionData['articleno']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{ucfirst($sessionData['articleno'])}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-1" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Start Date</b></h6>                            
                            @if(!empty($sessionData['Storestart1']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['Storestart1']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div>
                        <div class="col-md-1" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>End Date</b></h6>                            
                            @if(!empty($sessionData['Storeend2']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['Storeend2']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div>
                        <div class="col-md-1" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Purchase Order</b></h6>                            
                            @if(!empty($sessionData['purchaseorder']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{ucfirst($sessionData['purchaseorder'])}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-1" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Sales Order</b></h6>                            
                            @if(!empty($sessionData['salesorder']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{ucfirst($sessionData['salesorder'])}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div>
                        <div class="col-md-1" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Status</b></h6>                            
                            @if(!empty($sessionData['status']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{ucfirst($sessionData['status'])}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div>
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Customer</b></h6>                            
                            @if(!empty($sessionData['customer']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{ucfirst($sessionData['customer'])}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div>  
                    </div>
                    @endif
                    <div class="row p-3">
                        <div class="w-100">
                            <table id="datatable-buttons" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th class="text-white" data-orderable="false">Job <br> ID</th>
                                        <th class="text-white" data-orderable="false">Date</th>
                                        <th class="text-white" data-orderable="false">Customer</th>
                                        <th class="text-white" data-orderable="false">Category <br> Type</th>
                                        @if($Permission == 1)
                                        <?php if($sessionData['department'] == "Insole") { ?>
                                        <th class="text-white" data-orderable="false">Work <br> Order</th>
                                        <?php } else { ?>
                                        <?php } ?>           
                                        @endif                             
                                        <th class="text-white" data-orderable="false">Sale <br> Order</th>
                                        <th class="text-white" data-orderable="false">Purchase <br> Order</th> 
                                        <th class="text-white" data-orderable="false">Current <br> Status</th>
                                        <th class="text-white" data-orderable="false">Dep</th>
                                        <th class="text-white" data-orderable="false">Onsole <br> Article</th>
                                        <th class="text-white" data-orderable="false">Cust <br> Article</th>
                                        <th class="text-white" data-orderable="false">Location</th>
                                        <th class="text-white" data-orderable="false">Season</th>
                                        <th class="text-white" data-orderable="false">Item Code</th>
                                        <th class="text-white" data-orderable="false">Item Description</th>
                                        <th class="text-white" data-orderable="false">Color</th>
                                        <th class="text-white" data-orderable="false">Size</th>
                                        <th class="text-white" data-orderable="false">Last No</th>
                                        <th class="text-white" data-orderable="false">Status</th>
                                        <th class="text-white" data-orderable="false">Qty</th>
                                        <th class="text-white" data-orderable="false">Tool</th>
                                        <th class="text-white" data-orderable="false">Die No</th>
                                        <th class="text-white" data-orderable="false">Uom</th>
                                        <th class="text-white" data-orderable="false">Qty</th>
                                    </tr>
                                </thead>
                                @if($Permission == 1)
                                    <tbody>
                                        <?php $colorchange = ""; ?>
                                        @foreach($data as $row)
                                            <tr class="table_row" style="<?php if($colorchange != $row->Color || $jochange != $row->Job_Id) { ?> background: #d1d1d1; color: black; <?php } ?>">
                                                <td>{{$row->Job_Id}}</td>
                                                <td>{{$row->Date_Created}}</td>
                                                <td>{{$row->Cust_Name}}</td> 
                                                <td>{{$row->cat_type}}</td>                                                                                                                                           
                                                @if($Permission == 1)                  
                                                <?php if($sessionData['department'] == "Insole") { ?>
                                                <td>{{$row->Work_Order}}</td>
                                                <?php } else { ?>
                                                <?php } ?>
                                                @endif
                                                <td>{{$row->So_No}}</td>    
                                                <td>{{$row->Po_No}}</td>                  
                                                <td>{{$row->Status}}</td>
                                                <td>{{$row->Department}}</td>
                                                <td>{{$row->Onsole_Art_No}}</td>
                                                <td style="white-space: unset">{{$row->Cust_Art_No}}</td>  
                                                <td>{{$row->Location}}</td>                    
                                                <td>{{$row->Season}}</td>
                                                <td>{{$row->Rm_Code}}</td> 
                                                <td>{{$row->Job_Desc}}</td>
                                                <td>{{$row->Color}}</td> 
                                                <td>{{$row->sizerange}}</td>   
                                                <td>{{$row->Last_No}}</td>   
                                                <td>{{$row->status}}</td>          
                                                <?php if($colorchange != $row->Color || $jochange != $row->Job_Id) { ?>
                                                <td>{{$row->total}}</td>                  
                                                <?php } else { ?>
                                                <td></td>
                                                <?php } ?>
                                                <td>{{$row->Tool}}</td>                  
                                                <td>{{$row->Dye_No}}</td>  
                                                <td>{{$row->Um}}</td>                  
                                                <td>{{$row->Qty}}</td>                                    
                                            </tr>
                                            <?php $colorchange = $row->Color; $jochange = $row->Job_Id; ?>
                                        @endforeach
                                    </tbody>
                                @else
                                    <tbody>
                                    </tbody>
                                @endif
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
<div class="modal fade bd-example-modal-xl" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" style="margin-top: 5%;">
            <div class="modal-header" style="background: transparent !important;">
            <h5 class="modal-title" id="exampleModalLongTitle">Job Order Report</h5>
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
                        <div class="form-group row">                            
                            <div class="col-sm-6">
                                <label><b style="color: #6c757d">Customer</b></label>
                                <select id="customer" name="customer" style="border: 1px solid #bfbfbf;" class="select2 form-control mb-3 custom-select">
                                <option selected value="">Select Customer</option>
                                    @foreach($customer as $value)
                                        @if(!empty($sessionData['customer']))
                                            <option <?php if($value == $sessionData['customer']) echo 'selected="selected"'; ?> value="{{$value}}">{{$value}}</option>
                                        @else
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endif  
                                    @endforeach                  
                                </select>
                            </div>
                            <div class="col-sm-6">
                            <label><b style="color: #6c757d">Department</b></label>
                                <select id="department" name="department" style="border: 1px solid #bfbfbf;" class="form-control select.custom-select">
                                    <option value="">Select Department</option>
                                    @if(!empty($sessionData['department']))
                                        <option <?php if("Cutting" == $sessionData['department']) echo 'selected="selected"'; ?> value="Cutting">Cutting</option> 
                                        <option <?php if("Closing" == $sessionData['department']) echo 'selected="selected"'; ?> value="Closing">Closing</option>
                                        <option <?php if("Lasting" == $sessionData['department']) echo 'selected="selected"'; ?> value="Lasting">Lasting</option>    
                                        <option <?php if("Insole" == $sessionData['department']) echo 'selected="selected"'; ?> value="Insole">Insole</option> 
                                    @else
                                        <option value="Cutting">Cutting</option> 
                                        <option value="Closing">Closing</option>
                                        <option value="Lasting">Lasting</option>    
                                        <option value="Insole">Insole</option> 
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label><b style="color: #6c757d">Season</b></label>
                                <select id="season" name="season" style="border: 1px solid #bfbfbf;" class="form-control select.custom-select">
                                <option selected value="">Select Season</option>
                                @foreach($season as $value)
                                        @if(!empty($sessionData['season']))
                                            <option <?php if($value == $sessionData['season']) echo 'selected="selected"'; ?> value="{{$value}}">{{$value}}</option>
                                        @else
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endif  
                                    @endforeach                  
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label><b style="color: #6c757d">Article</b></label>
                                <input id="articleno" name="articleno" <?php if(isset($sessionData['articleno'])) echo "value='{$sessionData['articleno']}'"; ?> type="text" class="typeahead form-control yourclass" style="border: 1px solid #bfbfbf;" placeholder="Article No">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label><b style="color: #6c757d">Sales Order</b></label>
                                <input id="salesorder" name="salesorder" <?php if(isset($sessionData['salesorder'])) echo "value='{$sessionData['salesorder']}'"; ?> type="text" class="typeahead form-control yourclass" style="border: 1px solid #bfbfbf;" placeholder="Sales Order">                               
                            </div>
                            <div class="col-sm-6">
                                <label><b style="color: #6c757d">Purchase Order</b></label>
                                <input id="purchaseorder" name="purchaseorder" <?php if(isset($sessionData['purchaseorder'])) echo "value='{$sessionData['purchaseorder']}'"; ?> type="text" class="typeahead form-control yourclass" style="border: 1px solid #bfbfbf;" placeholder="Purchase Order">                               
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label><b style="color: #6c757d">Job Order</b></label>
                                <input id="joborder" name="joborder" <?php if(isset($sessionData['joborder'])) echo "value='{$sessionData['joborder']}'"; ?> type="text" class="typeahead form-control yourclass" style="border: 1px solid #bfbfbf;" placeholder="Job Order">                               
                            </div>
                            <div class="col-sm-6">
                                <label><b style="color: #6c757d">Status</b></label>
                                <select id="status" name="status" style="border: 1px solid #bfbfbf;" class="form-control select.custom-select">
                                <option selected value="">Select Status</option>
                                    @foreach($status as $value)
                                        @if(!empty($sessionData['status']))
                                            <option <?php if($value == $sessionData['status']) echo 'selected="selected"'; ?> value="{{$value}}">{{$value}}</option>
                                        @else
                                            <option value="{{$value}}">{{$value}}</option>
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
    $("#myForm").attr("action", "joborder-report");
    document.getElementById("myForm").submit();
});
$("#download").click(function(){
    $("#myForm").attr("action", "joborder-report-download");
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