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
                        <li class="breadcrumb-item active">Job Order Journey Report</li>
                    </ol>
                </div>
                <h4 class="page-title">Job Order Journey</h4>
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
                            <h3>Job Order Journey</h3>
                        </div>
                    </div>
                    @if($Permission == 1)
                    <div class="row mx-5 text-center py-4" style="border-radius: 5px;">
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Date Range</b></h6>                            
                            @if(!empty($sessionData['Storestart1']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['Storestart1']}} - {{$sessionData['Storeend2']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Status From</b></h6>                            
                            @if(!empty($sessionData['statusf']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['statusf']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Status To</b></h6>                            
                            @if(!empty($sessionData['statust']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['statust']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Department</b></h6>                            
                            @if(!empty($sessionData['department']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{ucfirst($sessionData['department'])}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Job Order</b></h6>                            
                            @if(!empty($sessionData['joborder']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{ucfirst($sessionData['joborder'])}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div>
                        <div class="col-md-2" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Date</b></h6>                            
                            @if(!empty($sessionData['thedate']))
                                @if($sessionData['thedate'] == 'tdate')
                                <p class="mb-2" style="font-family: 'Poppins';">Transfer Date</p>
                                @elseif($sessionData['thedate'] == 'jodate')                                
                                <p class="mb-2" style="font-family: 'Poppins';">Job Order Date</p>
                                @endif
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
                                        <th class="text-white" hidden>Job</th>
                                        <th class="text-white" data-orderable="false">Job Order</th>
                                        <th class="text-white" data-orderable="false">Department</th>
                                        <th class="text-white" data-orderable="false">Date Created</th>
                                        <th class="text-white" data-orderable="false">Transfer From</th>
                                        <th class="text-white" data-orderable="false">Transfer To</th>
                                        <th class="text-white" data-orderable="false">Transfer Date</th>
                                        <th class="text-white" data-orderable="false">Transfer Time</th>
                                    </tr>
                                </thead>
                                @if($Permission == 1)
                                    <tbody>
                                        @foreach($data as $row)
                                            <tr class="table_row">                
                                                <td hidden>1</td>
                                                <td>{{$row->Job_Id}}</td>                  
                                                <td>{{$row->Department}}</td>   
                                                <td>{{$row->User_Date}}</td>                  
                                                <td>{{$row->fromd}}</td> 
                                                <td>{{$row->transfer_to}}</td>                    
                                                <td>
                                                    @if($row->timed != NULL)
                                                        <?php $delimiter = ' '; $words = explode($delimiter, $row->timed); $newDate1 = date("d-M-Y", strtotime($words[0]));?>
                                                        <i class="mdi mdi-calendar-text-outline text-dark"></i> {{$newDate1}} 
                                                    @endif
                                                </td>        
                                                <td>
                                                    @if($row->timed != NULL)
                                                        <?php $delimiter = ' '; $words = explode($delimiter, $row->timed); $newDate = date("h:i A", strtotime($words[1]));?>
                                                        <i class="mdi mdi-timer text-dark"></i> {{$newDate}}
                                                    @endif
                                                </td>             
                                            </tr>
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
<div class="modal fade bd-example-modal-lg" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="margin-top: 15%;">
            <div class="modal-header" style="background: transparent !important;">
            <h5 class="modal-title" id="exampleModalLongTitle">Job Order Journey</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body px-5 py-1">
                    <form method="post" enctype="multipart/form-data" id="myForm">
                        @csrf
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label><b style="color: #6c757d">Select Date</b></label>
                                <div class="input-group" style="border: 1px solid #bfbfbf;">   
                                    <input type="text" class="form-control" <?php if(isset($sessionData['strtdte3a'])) echo "value='{{$sessionData['strtdte2a']}} - {{$sessionData['strtdte3a']}}'"; ?> name="daterange">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="dripicons-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                            <label><b style="color: #6c757d">Status From</b></label>
                                <select id="statusf" name="statusf" style="border: 1px solid #bfbfbf;" class="form-control select.custom-select">
                                    <option value="" selected>Select Status</option>
                                    @if(!empty($sessionData['statusf']))
                                        <option <?php if("PPC" == $sessionData['statusf']) echo 'selected="selected"'; ?> value="PPC">PPC</option>
                                        <option <?php if("CUTTING" == $sessionData['statusf']) echo 'selected="selected"'; ?> value="CUTTING">Cutting</option> 
                                        <option <?php if("CLOSING" == $sessionData['statusf']) echo 'selected="selected"'; ?> value="CLOSING">Closing</option>
                                        <option <?php if("LASTING" == $sessionData['statusf']) echo 'selected="selected"'; ?> value="LASTING">Lasting</option>    
                                        <option <?php if("STORE" == $sessionData['statusf']) echo 'selected="selected"'; ?> value="STORE">Store</option> 
                                        <option <?php if("FINALISED" == $sessionData['statusf']) echo 'selected="selected"'; ?> value="FINALISED">Finalised</option>
                                        <option <?php if("COMPLETE" == $sessionData['statusf']) echo 'selected="selected"'; ?> value="COMPLETE">Complete</option>        
                                    @else
                                        <option value="PPC">PPC</option>
                                        <option value="CUTTING">Cutting</option> 
                                        <option value="CLOSING">Closing</option>
                                        <option value="LASTING">Lasting</option>    
                                        <option value="STORE">Store</option> 
                                        <option value="FINALISED">Finalised</option>
                                        <option value="COMPLETE">Complete</option> 
                                    @endif         
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                            <label><b style="color: #6c757d">Status To</b></label>
                                <select id="statust" name="statust" style="border: 1px solid #bfbfbf;" class="form-control select.custom-select">
                                    <option value="" selected>Select Status</option>
                                    @if(!empty($sessionData['statust']))
                                        <option <?php if("PPC" == $sessionData['statust']) echo 'selected="selected"'; ?> value="PPC">PPC</option>
                                        <option <?php if("CUTTING" == $sessionData['statust']) echo 'selected="selected"'; ?> value="CUTTING">Cutting</option> 
                                        <option <?php if("CLOSING" == $sessionData['statust']) echo 'selected="selected"'; ?> value="CLOSING">Closing</option>
                                        <option <?php if("LASTING" == $sessionData['statust']) echo 'selected="selected"'; ?> value="LASTING">Lasting</option>    
                                        <option <?php if("STORE" == $sessionData['statust']) echo 'selected="selected"'; ?> value="STORE">Store</option> 
                                        <option <?php if("FINALISED" == $sessionData['statust']) echo 'selected="selected"'; ?> value="FINALISED">Finalised</option>
                                        <option <?php if("COMPLETE" == $sessionData['statust']) echo 'selected="selected"'; ?> value="COMPLETE">Complete</option>
                                    @else
                                        <option value="PPC">PPC</option>
                                        <option value="CUTTING">Cutting</option> 
                                        <option value="CLOSING">Closing</option>
                                        <option value="LASTING">Lasting</option>    
                                        <option value="STORE">Store</option> 
                                        <option value="FINALISED">Finalised</option>
                                        <option value="COMPLETE">Complete</option> 
                                    @endif             
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label><b style="color: #6c757d">Department</b></label>
                                <select id="department" name="department" style="border: 1px solid #bfbfbf;" class="form-control select.custom-select">
                                    <option value="" selected>Select Department</option>                                
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
                                <label><b style="color: #6c757d">Job Order</b></label>
                                <input id="joborder" <?php if(isset($sessionData['joborder'])) echo "value='{$sessionData['joborder']}'"; ?>  name="joborder" type="text" class="typeahead form-control yourclass" style="border: 1px solid #bfbfbf;" placeholder="Job Order">
                            </div>
                            <div class="col-sm-6">
                            <label><b style="color: #6c757d">Date</b></label>
                                <select id="thedate" name="thedate" style="border: 1px solid #bfbfbf;" class="form-control select.custom-select" required>
                                @if(!empty($sessionData['thedate']))
                                    <option <?php if($sessionData['thedate'] == "tdate") echo 'selected="selected"'; ?> value="tdate">Transfer Date</option>
                                    <option <?php if($sessionData['thedate'] == "jodate") echo 'selected="selected"'; ?> value="jodate">Job Order Date</option>
                                @else
                                    <option value="tdate">Transfer Date</option>
                                    <option value="jodate">Job Order Date</option>
                                @endif
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
<!-- <script src="plugins/moment/moment.js"></script>
<script src="plugins/apexcharts/apexcharts.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="plugins/chartjs/chart.min.js"></script>
<script src="plugins/chartjs/roundedBar.min.js"></script>
<script src="plugins/lightpick/lightpick.js"></script>
<script src="assets/pages/jquery.sales_dashboard.init.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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
    $("#myForm").attr("action", "joborder-journey");
    document.getElementById("myForm").submit();
});
$("#download").click(function(){
    $("#myForm").attr("action", "joborder-journey-download");
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
    var path1 = "{{route('jobordernum')}}";
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
</script>
<!-- <script src="plugins/moment/moment.js"></script>
<script src="plugins/apexcharts/apexcharts.min.js"></script>
<script src="plugins/apexcharts/irregular-data-series.js"></script>
<script src="plugins/apexcharts/ohlc.js"></script>
<script src="assets/pages/jquery.apexcharts.init.js"></script> -->
@endsection