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
    .borderTop{
        border-top: 1px solid black !important;
    }
</style>
<div class="page-wrapper">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-7 mx-auto mb-4">
                    <div class="card mb-5">
                        <div class="card-body">
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
                                                        <h3>Final Sample Specification Sheet</h3>
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
                                                    <td colspan="3" style="border-top: none; inline-flex;">
                                                        <td colspan="1" class="px-0" style="border-top: none;">
                                                            <h6 class="mb-0"><b>Last :</b></h6>
                                                            <h6 class="mb-0"><b>Color :</b></h6>
                                                            <h6 class="mb-0"><b>Season :</b></h6>
                                                            <h6 class="mb-0"><b>Article Code :</b></h6>
                                                        </td>
                                                        <td colspan="1" class="px-0" style="border-top: none;">
                                                            <h6 class="mb-0">{{$data1->last}}</h6>
                                                            <h6 class="mb-0">{{$data1->color}}</h6>
                                                            <h6 class="mb-0">{{$data1->season}}</h6>
                                                            <h6 class="mb-0">{{$data1->article}}</h6>
                                                        </td>
                                                    </td>
                                                    <td colspan="3" style="border-top: none; inline-flex;">
                                                    </td>
                                                    <td colspan="3" style="border-top: none; inline-flex;">
                                                        <td colspan="1" class="pr-1" style="border-top: none;">
                                                            <h6 class="mb-0"><b>Date:</b></h6>
                                                            <h6 class="mb-0"><b>Sample No :</b></h6>
                                                            <h6 class="mb-0"><b>Prodcut No :</b></h6>
                                                            <h6 class="mb-0"><b>Sequence No :</b></h6>
                                                        </td>
                                                        <td colspan="1" class="px-0" style="border-top: none;">
                                                            <h6 class="mb-0">{{$data1->date}}</h6>
                                                            <h6 class="mb-0">{{$data1->sample}}</h6>
                                                            <h6 class="mb-0">{{$data1->product}}</h6>
                                                            <h6 class="mb-0">{{$data1->sequence}}</h6>
                                                        </td>
                                                    </td>
                                                    <td colspan="4" class="text-center" style="border-top: none;">
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
                            <div class="row p-3">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead class="rounded">
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div class="alert alert-secondary border-0 text-center bg-dark w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: small;">Material&nbsp;Code</label>
                                                        </div>
                                                    </td>
                                                    <td colspan="1" style="border-top: none;">
                                                        <div class="alert alert-secondary border-0 text-center bg-dark w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: small;">Description</label>
                                                        </div>
                                                    </td>
                                                    <td colspan="1" style="border-top: none;">
                                                        <div class="alert alert-secondary border-0 text-center bg-dark w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: small;">Unit</label>
                                                        </div>
                                                    </td>
                                                    <td colspan="1" style="border-top: none;">
                                                        <div class="alert alert-secondary border-0 text-center bg-dark w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: small;">Type</label>
                                                        </div>
                                                    </td>
                                                    <td colspan="1" style="border-top: none;">
                                                        <div class="alert alert-secondary border-0 text-center bg-dark w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: small;">Use</label>
                                                        </div>
                                                    </td>
                                                    <td colspan="1" style="border-top: none;">
                                                        <div class="alert alert-secondary border-0 text-center bg-dark w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: small;">Tools</label>
                                                        </div>
                                                    </td>
                                                    <td colspan="1" style="border-top: none;">
                                                        <div class="alert alert-secondary border-0 text-center bg-dark w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: small;">Quantity</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-2 text-center w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600;">Upper&nbsp;Materials</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if(!$upperData)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="8" style="border-top: none;">No Data</td>
                                                </tr>
                                                @else
                                                @foreach($upperData as $value)
                                                <tr>
                                                    <td style="font-size: small;" class="borderTop">{{$value->item_code}}</td>
                                                    <td class="borderTop" style="text-transform: capitalize; font-size: small;">{{$value->description}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->uom}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->type}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->tools}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->usages}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->quantity}}</td>
                                                </tr>
                                                @endforeach
                                                @endif
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-2 text-center w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600;">Linning&nbsp;Materials</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if(!$linningData)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="8" style="border-top: none;">No Data</td>
                                                </tr>
                                                @else
                                                @foreach($linningData as $value)
                                                <tr>
                                                    <td style="font-size: small;" class="borderTop">{{$value->item_code}}</td>
                                                    <td class="borderTop" style="text-transform: capitalize; font-size: small;">{{$value->description}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->uom}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->type}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->tools}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->usages}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->quantity}}</td>
                                                </tr>
                                                @endforeach
                                                @endif
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-2 text-center w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600;">Stiching&nbsp;Materials</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if(!$stichingData)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="8" style="border-top: none;">No Data</td>
                                                </tr>
                                                @else
                                                @foreach($stichingData as $value)
                                                <tr>
                                                    <td style="font-size: small;" class="borderTop">{{$value->item_code}}</td>
                                                    <td class="borderTop" style="text-transform: capitalize; font-size: small;">{{$value->description}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->uom}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->type}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->tools}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->usages}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->quantity}}</td>
                                                </tr>
                                                @endforeach
                                                @endif
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-2 text-center w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600;">Outsole&nbsp;Materials</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if(!$outsoleData)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="8" style="border-top: none;">No Data</td>
                                                </tr>
                                                @else
                                                @foreach($outsoleData as $value)
                                                <tr>
                                                    <td style="font-size: small;" class="borderTop">{{$value->item_code}}</td>
                                                    <td class="borderTop" style="text-transform: capitalize; font-size: small;">{{$value->description}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->uom}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->type}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->tools}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->usages}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->quantity}}</td>
                                                </tr>
                                                @endforeach
                                                @endif
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-2 text-center w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600;">Insole&nbsp;Materials</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if(!$insoleData)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="8" style="border-top: none;">No Data</td>
                                                </tr>
                                                @else
                                                @foreach($insoleData as $value)
                                                <tr>
                                                    <td style="font-size: small;" class="borderTop">{{$value->item_code}}</td>
                                                    <td class="borderTop" style="text-transform: capitalize; font-size: small;">{{$value->description}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->uom}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->type}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->tools}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->usages}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->quantity}}</td>
                                                </tr>
                                                @endforeach
                                                @endif
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-2 text-center w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600;">Socks&nbsp;Materials</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if(!$socksData)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="8" style="border-top: none;">No Data</td>
                                                </tr>
                                                @else
                                                @foreach($socksData as $value)
                                                <tr>
                                                    <td style="font-size: small;" class="borderTop">{{$value->item_code}}</td>
                                                    <td class="borderTop" style="text-transform: capitalize; font-size: small;">{{$value->description}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->uom}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->type}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->tools}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->usages}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->quantity}}</td>
                                                </tr>
                                                @endforeach
                                                @endif
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-2 text-center w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600;">General&nbsp;Materials</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if(!$generalData)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="8" style="border-top: none;">No Data</td>
                                                </tr>
                                                @else
                                                @foreach($generalData as $value)
                                                <tr>
                                                    <td style="font-size: small;" class="borderTop">{{$value->item_code}}</td>
                                                    <td class="borderTop" style="text-transform: capitalize; font-size: small;">{{$value->description}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->uom}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->type}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->tools}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->usages}}</td>
                                                    <td style="font-size: small;" class="text-center borderTop">{{$value->quantity}}</td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center py-5">
                                <div class="col-sm-3 text-center">
                                    <label><b>Prepared By</b></label>
                                    <div class="checkbox checkbox-primary">
                                        <input id="prepared" name="prepared" type="checkbox">
                                        <label for="prepared">{{auth()->user()->firstname}} {{auth()->user()->lastname}}</label>
                                    </div>
                                </div>
                                <div class="col-sm-3 text-center">
                                    <label><b>Checked By</b></label>
                                    <div class="checkbox checkbox-primary">
                                        <input id="checked" name="checked" type="checkbox">
                                        <label for="checked">{{auth()->user()->firstname}} {{auth()->user()->lastname}}</label>
                                    </div>
                                </div>
                                <div class="col-sm-3 text-center">
                                    <label><b>Quality Control</b></label>
                                    <div class="checkbox checkbox-primary">
                                        <input id="qc" name="qc" type="checkbox">
                                        <label for="qc">{{auth()->user()->firstname}} {{auth()->user()->lastname}}</label>
                                    </div>
                                </div>
                                <div class="col-sm-3 text-center">
                                    <label><b>Approved By</b></label>
                                    <div class="checkbox checkbox-primary">
                                        <input id="approved" name="approved" type="checkbox">
                                        <label for="approved">{{auth()->user()->firstname}} {{auth()->user()->lastname}}</label>
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