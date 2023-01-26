<link rel="shortcut icon" href="img/photos/modified.png">
<link href="plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">
<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/jquery-ui.min.css" rel="stylesheet">
<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/metisMenu.min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
<link href="plugins/dropify/css/dropify.min.css" rel="stylesheet">
<link href="plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" /> 
<link href="plugins/daterangepicker/daterangepicker.css" rel="stylesheet" />
<link href="plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />
<link href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet" type="text/css" />
<link href="plugins/timepicker/bootstrap-material-datetimepicker.css" rel="stylesheet">
<link href="plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
<style>
    a:hover {
        text-decoration: none;
    }
    li:hover {
        text-decoration: none;
    }
    .footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        background-color: white;
        color: black;
        text-align: center;
    }
    textarea {
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
    }
    html,
    body {
        margin: 0;
        font-family: Nunito, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    }
    ::-webkit-scrollbar {
        width: 12px;
        height: 12px;
        border-radius: 10px;
    }
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb {
        background: rgb(197, 197, 197);
        border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: rgb(155, 155, 155);
        border-radius: 10px;
    }
    @media print {
    body {-webkit-print-color-adjust: exact;}
    }
    td{
        color: black;
    }
</style>
<div class="page-wrapper">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 mx-auto mb-4">
                    <div class="card mb-5">
                        <div class="card-body p-5">
                            <div class="row px-3" style="margin-top: -15px;">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead class="rounded">
                                                <tr>
                                                    <td colspan="3" style="border-top: none;">
                                                        <img src="img/photos/preview.png" alt="logo-small" class="logo-sm mr-2" height="100">
                                                    </td>
                                                    <td colspan="5" class="text-center" style="border-top: none;">
                                                        <h3>Pricing Sheet</h3>
                                                    </td>
                                                    <td colspan="1" class="text-center" style="border-top: none;"> 
                                                    </td>
                                                    <td colspan="1" class="text-center" style="border-top: none;"> 
                                                    </td>
                                                    <td colspan="1" class="text-center" style="border-top: none;"> 
                                                    </td>
                                                    <td colspan="1" class="text-center" style="border-top: none;"> 
                                                    </td>
                                                    <td colspan="1" class="text-center" style="border-top: none;"> 
                                                    </td>
                                                    <td colspan="1" class="text-center" style="border-top: none;"> 
                                                    </td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <hr class="mx-5" style="border-top: 1px solid #a1a1a1;">
                            <div class="row p-3">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead class="rounded">
                                                <tr>
                                                    <td colspan="4" style="border-top: none; inline-flex;">
                                                        <td colspan="1" class="px-0" style="border-top: none;">
                                                            <h6 class="mb-0" style="font-size: small;"><b>Sale Price :</b></h6>
                                                            <h6 class="mb-0" style="font-size: small;"><b>Actual Cost  :</b></h6>
                                                            <h6 class="mb-0" style="font-size: small;"><b>Desgin No :</b></h6>
                                                            <h6 class="mb-0" style="font-size: small;"><b>Description :</b></h6>
                                                            <h6 class="mb-0" style="font-size: small;"><b>Sales Order No :</b></h6>
                                                            @if(!empty($manual))
                                                            &nbsp;
                                                            @else
                                                            <h6 class="mb-0" style="font-size: small;"><b>Manaul :</b></h6>
                                                            @endif
                                                        </td>
                                                        <td colspan="1" class="px-0" style="border-top: none;">
                                                            <h6 style="font-size: small;" class="mb-0">
                                                                @if($data1->profit)
                                                                    {{substr($data1->profit, 0,6)}} PKR
                                                                @else
                                                                    &nbsp;
                                                                @endif
                                                            </h6>
                                                            <h6 style="font-size: small;" class="mb-0">
                                                                @if($data1->price)
                                                                    {{substr($data1->price, 0,6)}} PKR
                                                                @else
                                                                    &nbsp;
                                                                @endif
                                                            </h6>
                                                            <h6 style="font-size: small;" class="mb-0">{{$data1->design_no}}</h6>
                                                            <h6 style="font-size: small;" class="mb-0">{{$data1->description}}</h6>
                                                            <h6 style="font-size: small;" class="mb-0">
                                                                @if($data1->sono)
                                                                    {{$data1->sono}}
                                                                @else
                                                                    &nbsp;
                                                                @endif
                                                            </h6>                                                            
                                                            @if(!empty($manual))
                                                            &nbsp;
                                                            @else
                                                            @foreach($manual as $manualdata)
                                                                <h6 style="font-size: small;" class="mb-0">{{$manualdata}}</h6>
                                                            @endforeach
                                                            @endif
                                                        </td>
                                                    </td>
                                                    <td colspan="2" style="border-top: none; inline-flex;">
                                                        <td colspan="1" class="px-0" style="border-top: none;">
                                                            <h6 class="mb-0" style="font-size: small;"><b>Date :</b></h6>
                                                            <h6 class="mb-0" style="font-size: small;"><b>Status :</b></h6>
                                                            <h6 class="mb-0" style="font-size: small;"><b>Season :</b></h6>
                                                            <h6 class="mb-0" style="font-size: small;"><b>Category :</b></h6>
                                                            <h6 class="mb-0" style="font-size: small;"><b>Overhead No :</b></h6>
                                                            @if(!empty($manual))
                                                            &nbsp;
                                                            @else
                                                            <h6 class="mb-0" style="font-size: small;"><b>Sequence :</b></h6>
                                                            @endif
                                                        </td>
                                                        <td colspan="1" class="px-0" style="border-top: none;">
                                                            <h6 class="mb-0" style="font-size: small;">{{$data1->date}}</h6>
                                                            <h6 class="mb-0" style="font-size: small;">{{$data1->season}}</h6>
                                                            <h6 class="mb-0" style="font-size: small;">{{$data1->status}}</h6>
                                                            <h6 class="mb-0" style="font-size: small;">{{$data1->category}}</h6>
                                                            <h6 style="font-size: small;" class="mb-0">
                                                                @if($data1->overhead_id)
                                                                    Overhead-{{$data1->overhead_id}}
                                                                @else
                                                                    &nbsp;
                                                                @endif
                                                            </h6>
                                                            @if(!empty($manual))
                                                            &nbsp;
                                                            @else
                                                            <h6 class="mb-0" style="font-size: small;">{{$data1->sequence}}</h6>
                                                            @endif
                                                        </td>
                                                    </td>
                                                    <td colspan="6" class="text-center" style="border-top: none;">
                                                        @if(isset($data1->image) && !empty($data1->image)) 
                                                        <img src="{{ asset('uploads/appsetting/' . $data1->image) }}" alt="profile-user" height="100" class="rounded">
                                                        @else
                                                        <img src="{{asset('img/photos/10.jpg')}}" alt="profile-user" height="100" class="rounded">
                                                        @endif 
                                                    </td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <hr class="mx-5" style="border-top: 1px solid #a1a1a1;">
                            <div class="row p-3">
                                <div class="col-lg-5" style="margin: 0 auto;">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <tbody>
                                                @if(!$MaterialCost)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="11" style="border-top: none; font-size: small;">No Data</td>
                                                </tr>
                                                @else
                                                <tr class="rounded">
                                                    <th class="py-2 px-5" style="color: black; border-top: none;">Material Cost :</th>
                                                    <th class="py-2 px-5" style="color: black; border-top: none;">{{substr($MaterialCost, 0,6)}} PKR</th>
                                                </tr>
                                                @endif
                                                @if(!$ResourcesCost)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="11" style="border-top: none; font-size: small;">No Data</td>
                                                </tr>
                                                @else
                                                <tr class="rounded">
                                                    <th class="py-2 px-5" style="color: black; border-top: none;">Resources Cost :</th>
                                                    <th class="py-2 px-5" style="color: black;  border-top: none;">{{substr($ResourcesCost, 0,6)}} PKR</th>
                                                </tr>
                                                @endif
                                                @if(!$totalOverhead)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="11" style="border-top: none; font-size: small;">No Data</td>
                                                </tr>
                                                @else
                                                <tr class="rounded">
                                                    <th class="py-2 px-5" style="color: black; border-top: none;">Overhead Cost :</th>
                                                    <th class="py-2 px-5" style="color: black; border-top: none;">{{substr($totalOverhead, 0,6)}} PKR</th>
                                                </tr>
                                                @endif
                                                @if(!$TotalCost)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="11" style="border-top: none; font-size: small;">No Data</td>
                                                </tr>
                                                @else
                                                <tr class="rounded" style="border: 2px solid black;">
                                                    <th class="py-2 px-5" style="color: black;  border-top: none;"> <b> Total Cost :</b></th>
                                                    <th class="py-2 px-5" style="color: black;  border-top: none;">{{substr($TotalCost, 0,6)}} PKR</th>
                                                </tr>
                                                <tr class="rounded">
                                                    <th class="p-0" style="color: black; border-top: none;">
                                                        <hr class="" style="border-top: 1px solid white;">
                                                    </th>
                                                    <th class="p-0" style="color: black; border-top: none;">
                                                        <hr class="" style="border-top: 1px solid white;">
                                                    </th>
                                                </tr>
                                                @endif
                                                @if(!$CuttingData)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="11" style="border-top: none; font-size: small;">No Data</td>
                                                </tr>
                                                @else
                                                <tr class="rounded">
                                                    <th class="py-2 px-5" style="color: black; border-top: none;">Total Cutting :</th>
                                                    <th class="py-2 px-5" style="color: black; border-top: none;">{{substr($DataCutting['Value'], 0,6)}} PKR</th>
                                                </tr>
                                                @endif
                                                @if(!$InsoleData)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="11" style="border-top: none; font-size: small;">No Data</td>
                                                </tr>
                                                @else
                                                <tr class="rounded">
                                                    <th class="py-2 px-5" style="color: black; border-top: none;">Total INSOLE :</th>
                                                    <th class="py-2 px-5" style="color: black; border-top: none;">{{substr($DataInsole['Value'], 0,6)}} PKR</th>
                                                </tr>
                                                @endif
                                                @if(!$LaminationData)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="11" style="border-top: none; font-size: small;">No Data</td>
                                                </tr>
                                                @else
                                                <tr class="rounded">
                                                    <th class="py-2 px-5" style="color: black; border-top: none;">Total Lamination :</th>
                                                    <th class="py-2 px-5" style="color: black; border-top: none;">{{substr($DataLamination['Value'], 0,6)}} PKR</th>
                                                </tr>
                                                @endif
                                                @if(!$ClosingData)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="11" style="border-top: none; font-size: small;">No Data</td>
                                                </tr>
                                                @else
                                                <tr class="rounded">
                                                    <th class="py-2 px-5" style="color: black; border-top: none;">Total Closing :</th>
                                                    <th class="py-2 px-5" style="color: black; border-top: none;">{{substr($DataClosing['Value'], 0,6)}} PKR</th>
                                                </tr>
                                                @endif
                                                @if(!$LastingData)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="11" style="border-top: none; font-size: small;">No Data</td>
                                                </tr>
                                                @else
                                                <tr class="rounded">
                                                    <th class="py-2 px-5" style="color: black; border-top: none;">Total Lasting :</th>
                                                    <th class="py-2 px-5" style="color: black; border-top: none;">{{substr($DataLasting['Value'], 0,6)}} PKR</th>
                                                </tr>
                                                @endif
                                                @if(!$PackingData)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="11" style="border-top: none; font-size: small;">No Data</td>
                                                </tr>
                                                @else
                                                <tr class="rounded">
                                                    <th class="py-2 px-5" style="color: black; border-top: none;">Total Packing :</th>
                                                    <th class="py-2 px-5" style="color: black; border-top: none;">{{substr($DataPacking['Value'], 0,6)}} PKR</th>
                                                </tr>
                                                <tr class="rounded" style="border: 2px solid black;">
                                                    <th class="py-2 px-5" style="color: black; border-top: none;"> <b> Sub Total :</b></th>
                                                    <th class="py-2 px-5" style="color: black; border-top: none;">{{substr($TotalCost1, 0,6)}} PKR</th>
                                                </tr>
                                                @endif
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
</div>
<script src="assets/js/customjquery.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/metismenu.min.js"></script>
<script src="assets/js/waves.js"></script>
<script src="assets/js/feather.min.js"></script>
<script src="assets/js/jquery.slimscroll.min.js"></script>
<script src="assets/js/jquery-ui.min.js"></script>
<script src="plugins/apexcharts/apexcharts.min.js"></script>
<script src="plugins/moment/moment.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-us-aea-en.js"></script>
<script src="assets/pages/jquery.analytics_dashboard.init.js"></script>
<script src="plugins/dropify/js/dropify.min.js"></script>
<script src="assets/pages/jquery.form-upload.init.js"></script>
<script src="assets/js/app.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables/dataTables.responsive.min.js"></script>
<script src="plugins/datatables/responsive.bootstrap4.min.js"></script>
<script src="assets/pages/jquery.datatable.init.js"></script>
<script src="plugins/datatables/dataTables.buttons.min.js"></script>
<script src="plugins/datatables/buttons.bootstrap4.min.js"></script>
<script src="plugins/datatables/jszip.min.js"></script>
<script src="plugins/datatables/pdfmake.min.js"></script>
<script src="plugins/datatables/vfs_fonts.js"></script>
<script src="plugins/datatables/buttons.html5.min.js"></script>
<script src="plugins/datatables/buttons.print.min.js"></script>
<script src="plugins/datatables/buttons.colVis.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<script src="plugins/select2/select2.min.js"></script>
<script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="plugins/timepicker/bootstrap-material-datetimepicker.js"></script>
<script src="plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
<script src="plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js"></script>
<script src="assets/pages/jquery.forms-advanced.js"></script>