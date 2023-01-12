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
    .borderTop1{
        border-top: 1px solid gray !important;
    }
    .borderBottom{
        border-Bottom: 1px solid gray !important;
    }
</style>
<div class="page-wrapper">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 mx-auto mb-4">
                    <div class="card mb-5">
                        <div class="card-body p-0">
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
                                                        <h3>Specification Sheet</h3>
                                                        <h5>Material</h5>
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
                            <div class="row p-3" style="margin-top: -35px;">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead class="rounded">
                                                <tr>
                                                    <td colspan="4" style="border-top: none; inline-flex;">
                                                        <td colspan="1" class="px-0" style="border-top: none;">
                                                            <h6 class="mb-0" style="font-size: x-small; font-family: system-ui;"><b>Sale Price :</b></h6>
                                                            <h6 class="mb-0" style="font-size: x-small; font-family: system-ui;"><b>Actual Cost  :</b></h6>
                                                            <h6 class="mb-0" style="font-size: x-small; font-family: system-ui;"><b>Desgin No :</b></h6>
                                                            <h6 class="mb-0" style="font-size: x-small; font-family: system-ui;"><b>Description :</b></h6>
                                                            <h6 class="mb-0" style="font-size: x-small; font-family: system-ui;"><b>Price Variance :</b></h6>
                                                        </td>
                                                        <td colspan="1" class="px-0" style="border-top: none;">
                                                            <h6 class="mb-0" style="font-size: x-small; margin-top: 47px;">
                                                                @if($data1->price)
                                                                    {{$data1->price}} PKR
                                                                @else
                                                                    &nbsp;
                                                                @endif
                                                            </h6>
                                                            <h6 class="mb-0" style="font-size: x-small;">
                                                                @if($data1->profit)
                                                                    {{$data1->profit}} PKR
                                                                @else
                                                                    &nbsp;
                                                                @endif
                                                            </h6>
                                                            <h6 class="mb-0" style="font-size: x-small;">{{$data1->design_no}}</h6>
                                                            <h6 class="mb-0" style="font-size: x-small;">{{$data1->description}}</h6>
                                                            <div class="table-responsive-sm w-75" style="margin-top: 6px;">
                                                                <table class="table table-sm mb-0 text-center">
                                                                    <thead class="bg-dark">
                                                                        <tr>
                                                                            <th class="text-white px-0" style="font-family: 'Poppins'; font-size: x-small;">
                                                                                <div class="alert alert-secondary border-0 text-center bg-dark w-100 mb-0 py-0" role="alert" style="border-radius: 0;">
                                                                                    <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Pricing</label>
                                                                                </div>
                                                                            </th>
                                                                            <th class="text-white px-0" style="font-family: 'Poppins'; font-size: x-small;">
                                                                                <div class="alert alert-secondary border-0 text-center bg-dark w-100 mb-0 py-0" role="alert" style="border-radius: 0;">
                                                                                    <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Specification</label>
                                                                                </div>
                                                                            </th>
                                                                            <th class="text-white px-0" style="font-family: 'Poppins'; font-size: x-small;">
                                                                                <div class="alert alert-secondary border-0 text-center bg-dark w-100 mb-0 py-0" role="alert" style="border-radius: 0;">
                                                                                    <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Variance</label>
                                                                                </div>
                                                                            </th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td><span class="badge" style="border: 1px solid white; font-size: x-small !important;">{{$data1->price}} PKR</span></td>
                                                                            <td><span class="badge" style="border: 1px solid white; font-size: x-small !important;">{{$data1->profit}} PKR</span></td>
                                                                            <?php $total = $data1->price - $data1->profit ?>
                                                                            @if($total > 0)
                                                                            <td class="mt-1"><span class="badge badge-soft-success" style="border: 1px solid white;">{{$total}}</span></td>
                                                                            @elseif($total < 0)
                                                                            <td class="mt-1"><span class="badge badge-soft-danger" style="border: 1px solid white;">{{$total}}</span></td>
                                                                            @else
                                                                            <td class="mt-1"><span class="badge badge-soft-dark" style="border: 1px solid white;">{{$total}}</span></td>
                                                                            @endif
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </td>
                                                    </td>
                                                    <td colspan="2" style="border-top: none; inline-flex;">
                                                        <td colspan="1" class="px-0" style="border-top: none;">
                                                            <h6 class="mb-0" style="font-size: x-small; font-family: system-ui;"><b>Date :</b></h6>
                                                            <h6 class="mb-0" style="font-size: x-small; font-family: system-ui;"><b>Status :</b></h6>
                                                            <h6 class="mb-0" style="font-size: x-small; font-family: system-ui;"><b>Sale Price (P) :</b></h6>
                                                            <h6 class="mb-0" style="font-size: x-small; font-family: system-ui;"><b>Actual Cost (P) :</b></h6>
                                                            <h6 class="mb-0" style="font-size: x-small; font-family: system-ui;"><b>Pricing Sheet :</b></h6>
                                                        </td>
                                                        <td colspan="1" class="px-0" style="border-top: none;">
                                                            <h6 class="mb-0" style="font-size: x-small;">{{$data1->date}}</h6>
                                                            <h6 class="mb-0" style="font-size: x-small;">{{$data1->status}}</h6>
                                                            <h6 class="mb-0" style="font-size: x-small;">
                                                                @if($GetPricingPrice)
                                                                    {{$GetPricingPrice}} PKR
                                                                @else
                                                                    &nbsp;
                                                                @endif
                                                            </h6>
                                                            <h6 class="mb-0" style="font-size: x-small;">
                                                                @if($GetPricingProfit)
                                                                    {{$GetPricingProfit}} PKR
                                                                @else
                                                                    &nbsp;
                                                                @endif
                                                            </h6>
                                                            <h6 class="mb-0" style="font-size: x-small;">
                                                            @if($data1->pricing)
                                                                {{$data1->pricing}}
                                                            @else
                                                                &nbsp;
                                                            @endif
                                                            </h6>
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
                            <div class="row p-3">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead class="rounded">
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div class="alert alert-secondary border-0 text-center bg-dark w-100" role="alert" style="border-radius: 0;">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Code</label>
                                                        </div>
                                                    </td>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div class="alert alert-secondary border-0 text-center bg-dark w-100" role="alert" style="border-radius: 0;">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Description</label>
                                                        </div>
                                                    </td>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div class="alert alert-secondary border-0 text-center bg-dark w-100" role="alert" style="border-radius: 0;">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Unit</label>
                                                        </div>
                                                    </td>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div class="alert alert-secondary border-0 text-center bg-dark w-100" role="alert" style="border-radius: 0;">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Component</label>
                                                        </div>
                                                    </td>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div class="alert alert-secondary border-0 text-center bg-dark w-100" role="alert" style="border-radius: 0;">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Output</label>
                                                        </div>
                                                    </td>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div class="alert alert-secondary border-0 text-center bg-dark w-100" role="alert" style="border-radius: 0;">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Factor</label>
                                                        </div>
                                                    </td>
                                                    <td colspan="1" style="border-top: none;" class="px-0" hidden>
                                                        <div class="alert alert-secondary border-0 text-center bg-dark w-100" role="alert" style="border-radius: 0;">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Quantity</label>
                                                        </div>
                                                    </td>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div class="alert alert-secondary border-0 text-center bg-dark w-100" role="alert" style="border-radius: 0;">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Process&nbsp;Loss%</label>
                                                        </div>
                                                    </td>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div class="alert alert-secondary border-0 text-center bg-dark w-100" role="alert" style="border-radius: 0;">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Consumption</label>
                                                        </div>
                                                    </td>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div class="alert alert-secondary border-0 text-center bg-dark w-100" role="alert" style="border-radius: 0;">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Rate/Pair</label>
                                                        </div>
                                                    </td>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div class="alert alert-secondary border-0 text-center bg-dark w-100" role="alert" style="border-radius: 0;">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Value</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0 py-1">
                                                        <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-2 text-center w-100 mt-3 mb-1" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Cutting</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if(!$CuttingData)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="8" style="border-top: none; font-size: small;">No Data</td>
                                                </tr>
                                                @else
                                                @foreach($CuttingData as $value)
                                                <tr>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->item_code}}</td>
                                                    <td class="borderTop" style="text-transform: capitalize; font-size: x-small;">{{$value->description}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->uom}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->component}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->output}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{substr($value->fac_qty, 0,6)}}</td>
                                                    <!-- <td style="font-size: x-small;" class="borderTop text-center">{{$value->total_qty}}</td> -->
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->process}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->total}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->rate}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->value}}</td>
                                                </tr>
                                                @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">Total</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black;"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black;"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black;"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black;"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{substr($DataCutting['Fac'], 0,6)}}</th>
                                                    <!-- <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataCutting['TotalQty']}}</th> -->
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black;"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataCutting['Total']}}</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataCutting['Rate']}}</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataCutting['Value']}}</th>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-2 text-center w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">INSOLE</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if(!$InsoleData)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="8" style="border-top: none; font-size: small;">No Data</td>
                                                </tr>
                                                @else
                                                @foreach($InsoleData as $value)
                                                <tr>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->item_code}}</td>
                                                    <td class="borderTop" style="text-transform: capitalize; font-size: x-small;">{{$value->description}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->uom}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->component}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->output}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{substr($value->fac_qty, 0,6)}}</td>
                                                    <!-- <td style="font-size: x-small;" class="borderTop text-center">{{$value->total_qty}}</td> -->
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->process}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->total}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->rate}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->value}}</td>
                                                </tr>
                                                @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">Total</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{substr($DataInsole['Fac'], 0,6)}}</th>
                                                    <!-- <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataInsole['TotalQty']}}</th> -->
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataInsole['Total']}}</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataInsole['Rate']}}</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataInsole['Value']}}</th>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-2 text-center w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Lamination</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if(!$LaminationData)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="8" style="border-top: none; font-size: small;">No Data</td>
                                                </tr>
                                                @else
                                                @foreach($LaminationData as $value)
                                                <tr>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->item_code}}</td>
                                                    <td class="borderTop" style="text-transform: capitalize; font-size: x-small;">{{$value->description}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->uom}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->component}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->output}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{substr($value->fac_qty, 0,6)}}</td>
                                                    <!-- <td style="font-size: x-small;" class="borderTop text-center">{{$value->total_qty}}</td> -->
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->process}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->total}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->rate}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->value}}</td>
                                                </tr>
                                                @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">Total</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{substr($DataLamination['Fac'], 0,6)}}</th>
                                                    <!-- <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataLamination['TotalQty']}}</th> -->
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataLamination['Total']}}</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataLamination['Rate']}}</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataLamination['Value']}}</th>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-2 text-center w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Closing</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if(!$ClosingData)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="8" style="border-top: none; font-size: small;">No Data</td>
                                                </tr>
                                                @else
                                                @foreach($ClosingData as $value)
                                                <tr>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->item_code}}</td>
                                                    <td class="borderTop" style="text-transform: capitalize; font-size: x-small;">{{$value->description}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->uom}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->component}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->output}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{substr($value->fac_qty, 0,6)}}</td>
                                                    <!-- <td style="font-size: x-small;" class="borderTop text-center">{{$value->total_qty}}</td> -->
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->process}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->total}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->rate}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->value}}</td>
                                                </tr>
                                                @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">Total</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{substr($DataClosing['Fac'], 0,6)}}</th>
                                                    <!-- <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataClosing['TotalQty']}}</th> -->
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataClosing['Total']}}</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataClosing['Rate']}}</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataClosing['Value']}}</th>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-2 text-center w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Lasting</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if(!$LastingData)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="8" style="border-top: none; font-size: small;">No Data</td>
                                                </tr>
                                                @else
                                                @foreach($LastingData as $value)
                                                <tr>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->item_code}}</td>
                                                    <td class="borderTop" style="text-transform: capitalize; font-size: x-small;">{{$value->description}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->uom}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->component}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->output}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{substr($value->fac_qty, 0,6)}}</td>
                                                    <!-- <td style="font-size: x-small;" class="borderTop text-center">{{$value->total_qty}}</td> -->
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->process}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->total}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->rate}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->value}}</td>
                                                </tr>
                                                @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">Total</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom -center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{substr($DataLasting['Fac'], 0,6)}}</th>
                                                    <!-- <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataLasting['TotalQty']}}</th> -->
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataLasting['Total']}}</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataLasting['Rate']}}</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataLasting['Value']}}</th>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-2 text-center w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">packing</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if(!$PackingData)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="8" style="border-top: none; font-size: small;">No Data</td>
                                                </tr>
                                                @else
                                                @foreach($PackingData as $value)
                                                <tr>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->item_code}}</td>
                                                    <td class="borderTop" style="text-transform: capitalize; font-size: x-small;">{{$value->description}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->uom}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->component}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->output}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{substr($value->fac_qty, 0,6)}}</td>
                                                    <!-- <td style="font-size: x-small;" class="borderTop text-center">{{$value->total_qty}}</td> -->
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->process}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->total}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->rate}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->value}}</td>
                                                </tr>
                                                @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">Total</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{substr($DataPacking['Fac'], 0,6)}}</th>
                                                    <!-- <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataPacking['TotalQty']}}</th> -->
                                                    <th class="borderTop1 borderBottom -center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataPacking['Total']}}</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataPacking['Rate']}}</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataPacking['Value']}}</th>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row px-3" style="margin-top: 6%;">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead class="rounded">
                                                <tr>
                                                    <td colspan="3" style="border-top: none;">
                                                    </td>
                                                    <td colspan="3" style="border-top: none;">
                                                    </td>
                                                    <td colspan="3" style="border-top: none;">
                                                    </td>
                                                    <td colspan="3" style="border-top: none;">
                                                    </td>
                                                    <td colspan="3" style="border-top: none;">
                                                    </td>
                                                    <td colspan="1" style="border-top: none;">
                                                    </td>
                                                    <td colspan="1" class="text-center" style="border-top: none;">
                                                        <h4>Resources</h4>
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
                            <div class="row p-3">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead class="rounded">
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div class="alert alert-secondary border-0 text-center bg-dark w-100" role="alert" style="border-radius: 0;">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Value Set</label>
                                                        </div>
                                                    </td>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div class="alert alert-secondary border-0 text-center bg-dark w-100" role="alert" style="border-radius: 0;">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Description</label>
                                                        </div>
                                                    </td>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div class="alert alert-secondary border-0 text-center bg-dark w-100" role="alert" style="border-radius: 0;">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Remarks</label>
                                                        </div>
                                                    </td>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div class="alert alert-secondary border-0 text-center bg-dark w-100" role="alert" style="border-radius: 0;">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Rate/Pair</label>
                                                        </div>
                                                    </td>       
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0 py-1">
                                                        <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-2 text-center w-100 mt-3 mb-1" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Cutting</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if(!$CuttingData_r)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="8" style="border-top: none; font-size: small;">No Data</td>
                                                </tr>
                                                @else
                                                @foreach($CuttingData_r as $value)
                                                <tr>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->value_set}}</td>
                                                    <td class="borderTop pl-5" style="text-transform: capitalize; font-size: x-small;">{{$value->description}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->remarks}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->pair}}</td>
                                                </tr>
                                                @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">Total</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataCutting_r['Pair']}}</th>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-2 text-center w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">INSOLE</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if(!$InsoleData_r)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="8" style="border-top: none; font-size: small;">No Data</td>
                                                </tr>
                                                @else
                                                @foreach($InsoleData_r as $value)
                                                <tr>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->value_set}}</td>
                                                    <td class="borderTop pl-5" style="text-transform: capitalize; font-size: x-small;">{{$value->description}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->remarks}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->pair}}</td>
                                                </tr>
                                                @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">Total</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataInsole_r['Pair']}}</th>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-2 text-center w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Lamination</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if(!$LaminationData_r)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="8" style="border-top: none; font-size: small;">No Data</td>
                                                </tr>
                                                @else
                                                @foreach($LaminationData_r as $value)
                                                <tr>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->value_set}}</td>
                                                    <td class="borderTop pl-5" style="text-transform: capitalize; font-size: x-small;">{{$value->description}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->remarks}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->pair}}</td>
                                                </tr>
                                                @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">Total</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataLamination_r['Pair']}}</th>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-2 text-center w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Closing</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if(!$ClosingData_r)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="8" style="border-top: none; font-size: small;">No Data</td>
                                                </tr>
                                                @else
                                                @foreach($ClosingData_r as $value)
                                                <tr>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->value_set}}</td>
                                                    <td class="borderTop pl-5" style="text-transform: capitalize; font-size: x-small;">{{$value->description}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->remarks}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->pair}}</td>
                                                </tr>
                                                @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">Total</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataClosing_r['Pair']}}</th>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-2 text-center w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Lasting</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if(!$LastingData_r)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="8" style="border-top: none; font-size: small;">No Data</td>
                                                </tr>
                                                @else
                                                @foreach($LastingData_r as $value)
                                                <tr>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->value_set}}</td>
                                                    <td class="borderTop pl-5" style="text-transform: capitalize; font-size: x-small;">{{$value->description}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->remarks}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->pair}}</td>
                                                </tr>
                                                @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">Total</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataLasting_r['Pair']}}</th>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-2 text-center w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">packing</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if(!$PackingData_r)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="8" style="border-top: none; font-size: small;">No Data</td>
                                                </tr>
                                                @else
                                                @foreach($PackingData_r as $value)
                                                <tr>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->value_set}}</td>
                                                    <td class="borderTop pl-5" style="text-transform: capitalize; font-size: x-small;">{{$value->description}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->remarks}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->pair}}</td>
                                                </tr>
                                                @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">Total</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataPacking_r['Pair']}}</th>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row px-3" style="margin-top: 6%;">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead class="rounded">
                                                <tr>
                                                    <td colspan="3" style="border-top: none;">
                                                    </td>
                                                    <td colspan="3" style="border-top: none;">
                                                    </td>
                                                    <td colspan="3" style="border-top: none;">
                                                    </td>
                                                    <td colspan="3" style="border-top: none;">
                                                    </td>
                                                    <td colspan="3" style="border-top: none;">
                                                    </td>
                                                    <td colspan="1" style="border-top: none;">
                                                    </td>
                                                    <td colspan="1" class="text-center" style="border-top: none;">
                                                        <h4>Overheads</h4>
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
                            <div class="row p-3">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead class="rounded">
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div class="alert alert-secondary border-0 text-center bg-dark w-100" role="alert" style="border-radius: 0;">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Value Set</label>
                                                        </div>
                                                    </td>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div class="alert alert-secondary border-0 text-center bg-dark w-100" role="alert" style="border-radius: 0;">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Description</label>
                                                        </div>
                                                    </td>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div class="alert alert-secondary border-0 text-center bg-dark w-100" role="alert" style="border-radius: 0;">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Remarks</label>
                                                        </div>
                                                    </td>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div class="alert alert-secondary border-0 text-center bg-dark w-100" role="alert" style="border-radius: 0;">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Rate/Pair</label>
                                                        </div>
                                                    </td>       
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0 py-1">
                                                        <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-2 text-center w-100 mt-3 mb-1" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Cutting</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if(!$CuttingData_o)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="8" style="border-top: none; font-size: small;">No Data</td>
                                                </tr>
                                                @else
                                                @foreach($CuttingData_o as $value)
                                                <tr>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->value_set}}</td>
                                                    <td class="borderTop pl-5" style="text-transform: capitalize; font-size: x-small;">{{$value->description}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->remarks}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->pair}}</td>
                                                </tr>
                                                @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">Total</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataCutting_o['Pair']}}</th>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-2 text-center w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">INSOLE</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if(!$InsoleData_o)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="8" style="border-top: none; font-size: small;">No Data</td>
                                                </tr>
                                                @else
                                                @foreach($InsoleData_o as $value)
                                                <tr>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->value_set}}</td>
                                                    <td class="borderTop pl-5" style="text-transform: capitalize; font-size: x-small;">{{$value->description}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->remarks}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->pair}}</td>
                                                </tr>
                                                @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">Total</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataInsole_o['Pair']}}</th>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-2 text-center w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Lamination</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if(!$LaminationData_o)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="8" style="border-top: none; font-size: small;">No Data</td>
                                                </tr>
                                                @else
                                                @foreach($LaminationData_o as $value)
                                                <tr>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->value_set}}</td>
                                                    <td class="borderTop pl-5" style="text-transform: capitalize; font-size: x-small;">{{$value->description}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->remarks}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->pair}}</td>
                                                </tr>
                                                @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">Total</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataLamination_o['Pair']}}</th>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-2 text-center w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Closing</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if(!$ClosingData_o)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="8" style="border-top: none; font-size: small;">No Data</td>
                                                </tr>
                                                @else
                                                @foreach($ClosingData_o as $value)
                                                <tr>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->value_set}}</td>
                                                    <td class="borderTop pl-5" style="text-transform: capitalize; font-size: x-small;">{{$value->description}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->remarks}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->pair}}</td>
                                                </tr>
                                                @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">Total</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataClosing_o['Pair']}}</th>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-2 text-center w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">Lasting</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if(!$LastingData_o)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="8" style="border-top: none; font-size: small;">No Data</td>
                                                </tr>
                                                @else
                                                @foreach($LastingData_o as $value)
                                                <tr>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->value_set}}</td>
                                                    <td class="borderTop pl-5" style="text-transform: capitalize; font-size: x-small;">{{$value->description}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->remarks}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->pair}}</td>
                                                </tr>
                                                @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">Total</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataLasting_o['Pair']}}</th>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td colspan="1" style="border-top: none;" class="px-0">
                                                        <div style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="alert alert-secondary border-0 py-2 text-center w-100" role="alert">
                                                            <label class="mb-0 text-white" style="font-weight: 600; font-size: x-small;">packing</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @if(!$PackingData_o)
                                                <tr class="no-data text-center" style="border-top: none;">
                                                    <td colspan="8" style="border-top: none; font-size: small;">No Data</td>
                                                </tr>
                                                @else
                                                @foreach($PackingData_o as $value)
                                                <tr>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->value_set}}</td>
                                                    <td class="borderTop pl-5" style="text-transform: capitalize; font-size: x-small;">{{$value->description}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->remarks}}</td>
                                                    <td style="font-size: x-small;" class="borderTop text-center">{{$value->pair}}</td>
                                                </tr>
                                                @endforeach
                                                <tr style="background: #cdd3db;" class="rounded">
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">Total</th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black"></th>
                                                    <th class="borderTop1 borderBottom text-center py-1" style="color: black; font-size: x-small;">{{$DataPacking_r['Pair']}}</th>
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