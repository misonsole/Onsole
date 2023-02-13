@extends( (Auth::user()->id == "2") ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<link href="plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">
<link href="plugins/lightpick/lightpick.css" rel="stylesheet" />
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
    .autocomplete{
        position: relative;
        display: inline-block;
    }
    #myInput{
        width: 100%;
        border: 1px solid #bfbfbf;
    }
    .autocomplete-items{
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        top: 100%;
        left: 5;
        right: 5;
        width: 92%;
        border-radius: 5px;
        overflow-y: scroll;
        height: 330%;
    }
    .autocomplete-items div{
        padding: 10px;
        cursor: pointer;
        background-color: #fff; 
        border-bottom: 1px solid #d4d4d4; 
    }
    .autocomplete-items div:hover{
        background-color: #e9e9e9; 
    }
    .autocomplete-active{
        background-color: DodgerBlue !important; 
        color: #ffffff; 
    }
    .dtp > .dtp-content{
        background: #fff;
        max-width: 300px;
        box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 10px 0 rgb(0 0 0 / 12%);
        max-height: 100%;
        position: relative;
        left: 50%;
    }
    .dtp .p10 > a{
        color: #fdfdfd;
        text-decoration: none;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow{
        height: 26px;
        position: absolute;
        top: 4px;
        right: 1px;
        width: 20px;
    }
    .select2-container .select2-selection--single{
        box-sizing: border-box;
        cursor: pointer;
        display: block;
        height: auto;
        padding-top: 1%;
        padding-bottom: 1%;
        user-select: none;
        -webkit-user-select: none;
    }
</style>
<div id="loader1" class="rotate" width="100" height="100"></div>
<div id="loader2" class="rotate" width="100" style="display: none;" height="100"></div>
<div class="container-fluid px-5">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" style="font-family: 'Poppins', sans-serif;">Material Consumption Report</li>
                    </ol>
                </div>
                <h4 class="page-title">Material Consumption Report</h4>
                <br>
                <button style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); border: none;" type="button" class="btn text-white" data-toggle="modal" data-target="#exampleModalCenter">View Report</button>
            </div>
        </div>
    </div>
    <div class="row mb-5 mt-4">
        <div class="col-lg-12 col-sm-12 mb-5">
            <div class="card">
                <div class="card-body table-responsive">
                    <div class="row px-5">
                        <div class="col-md-3 align-self-center">
                            <img src="img/photos/preview.png" alt="logo-small" class="logo-sm mr-2" height="100">
                        </div>
                        <div class="col-md-6 align-self-center text-center">
                            <h3>Material Consumption Report</h3>
                        </div>
                    </div>
                    @if($Permission == 1)
                    <div class="row mx-5 text-center py-1" style="border-radius: 5px;">
                        <div class="col-md-3" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Book</b></h6>                            
                            @if(!empty($book))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$book}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-3" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Date Range</b></h6>                            
                            @if(!empty($sessionData['Storestart1']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['Storestart1']}} - {{$sessionData['Storeend2']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-3" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Locator</b></h6>                            
                            @if(!empty($sessionData['requestlocator']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['requestlocator']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-3" style="border-top: 1px solid; border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Department</b></h6>                            
                            @if(!empty($sessionData['requestdepartment']))
                                @if($sessionData['requestdepartment'] == 'NULL')
                                <p class="mb-2" style="font-family: 'Poppins';">-</p>
                                @else
                                <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['requestdepartment']}}</p>
                                @endif
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                    </div>
                    <div class="row mx-5 text-center pb-4" style="border-radius: 5px;">
                        <div class="col-md-2" style="border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>SO No</b></h6>                            
                            @if(!empty($sessionData['requestsono']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['requestsono']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-2" style="border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>RM Code</b></h6>                            
                            @if(!empty($sessionData['requestrmcode']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['requestsono']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-2" style="border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Article Code</b></h6>                            
                            @if(!empty($sessionData['requestartcode']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['requestartcode']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-2" style="border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Store Issue Note</b></h6>                            
                            @if(!empty($sessionData['requestsinno']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['requestsinno']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div> 
                        <div class="col-md-2" style="border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Category</b></h6>                            
                            @if(!empty($sessionData['requestcat']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['requestcat']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div>  
                        <div class="col-md-2" style="border-bottom: 1px solid;">
                            <h6 class="mb-1"><b>Sub Category</b></h6>                            
                            @if(!empty($sessionData['requestsubcat']))
                            <p class="mb-2" style="font-family: 'Poppins';">{{$sessionData['requestsubcat']}}</p>
                            @else
                            <p class="mb-2">-</p>
                            @endif
                        </div>  
                    </div>
                    @endif
                    <div class="row p-3" style="width: 100%;">
                        <div class="w-100">
                            <table id="datatable-buttons" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="bg-dark text-white">
                                    <th class="text-white" data-orderable="false" hidden>.</th>
                                    <th class="text-white" data-orderable="false">Issue <br> Date</th>
                                    <th class="text-white" data-orderable="false">So <br> No</th>
                                    <th class="text-white" data-orderable="false">Season</th>
                                    <th class="text-white" data-orderable="false">Issue <br> No</th>
                                    <th class="text-white" data-orderable="false">Reason</th>
                                    <th class="text-white" data-orderable="false">Dep</th>
                                    <th class="text-white" data-orderable="false">Prod <br> Qty</th>
                                    <th class="text-white" data-orderable="false">Locator</th>
                                    <th class="text-white" data-orderable="false">Article</th>
                                    <th class="text-white" data-orderable="false">Item <br> Code</th>
                                    <th class="text-white" data-orderable="false">Item Code <br> Description</th>
                                    <th class="text-white" data-orderable="false">Unit</th>
                                    <th class="text-white" data-orderable="false">Qty</th>
                                    <th class="text-white" data-orderable="false">Rate</th>
                                    <th class="text-white" data-orderable="false">Amount</th>
                                    <th class="text-white" data-orderable="false">Category <br> Code</th>
                                    <th class="text-white" data-orderable="false">Category <br> Description</th>
                                    <th class="text-white" data-orderable="false">Contra <br> A/C Code</th>
                                    <th class="text-white" data-orderable="false">Contra <br> A/C DESC</th>
                                </thead>
                                @if($Permission == 1)
                                    <tbody>
                                        @foreach($data as $row)
                                        <tr class="table_row">
                                            <td hidden>1</td>
                                            <td>
                                                <?php $explode = explode("-",$row['data']["ISSUE_DATE"]); ?>
                                                @foreach($explode as $data1)
                                                    {{$data1}}<br>
                                                @endforeach
                                            </td>   
                                            <td>{{$row['data']["SALES_ORDER_NO"]}}</td>
                                            <td>
                                                <?php $explode = explode(" ",$row['data']["SEASON_DEF_DESC"]); ?>
                                                @foreach($explode as $data1)
                                                    {{$data1}}<br>
                                                @endforeach
                                            </td> 
                                            <td>{{$row['data']["ISSUE_NO"]}}</td>
                                            <td>
                                                <?php $explode = explode(" ",$row['data']["TRANS_REASON_DESC"]); ?>
                                                @foreach($explode as $data1)
                                                    {{$data1}}<br>
                                                @endforeach
                                            </td>  
                                            <td>{{$row['data']["DESCRIPTION"]}}</td>
                                            <td>{{$row['data']["PRODUCTION_QTY"]}}</td>
                                            <td>{{$row['data']["WS1_CODE"]}}-{{$row['data']["WS2_CODE"]}}</td>
                                            <td>
                                                <?php $explode = explode(" ",$row['data']["SEGMENT_VALUE_DESC"]); ?>
                                                @foreach($explode as $data1)
                                                    {{$data1}}<br>
                                                @endforeach
                                            </td>
                                            <?php $pieces = explode("-", $row['data']["ITEM_CODE"]); ?> 
                                                @if(count($pieces) == 2)
                                                    <td>{{$pieces[0]}}-<br>{{$pieces[1]}}</td>
                                                @else
                                                <td>{{$row["ITEM_CODE"]}}</td>
                                                @endif
                                            <td>
                                                <?php
                                                    $test = $row['data']["ITEM_DESC"];
                                                    $explode = explode(" ",$test);
                                                    $String = '';
                                                    $newString = '';
                                                    $maxCharacterCount = 5;
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
                                            <td>{{$row['data']["UOM_SHORT_DESC"]}}</td>
                                            <td>{{$row['data']["PRIMARY_QTY"]}}</td>
                                            <td>{{round($rate,2)}}</td>
                                            <td>{{number_format($row['data']["ISSUE_AMOUNT"],2)}}</td>
                                            <td>
                                                <?php $explode = explode("-",$row['data']["CAT_CODE"]); ?>
                                                @foreach($explode as $data1)
                                                    {{$data1}}<br>
                                                @endforeach
                                            </td>
                                            <td>
                                                <?php $explode = explode("-",$row['data']["CAT_DESC"]); ?>
                                                @foreach($explode as $data1)
                                                    {{$data1}}<br>
                                                @endforeach
                                            </td>
                                            <?php
                                                $wizerp  = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
                                                $conn = oci_connect("onsole","s",$wizerp);
                                                $newcodevalue = explode("-", $row['data']["CODE_VALUE"]);
                                                $sql1 = "SELECT DISTINCT IGCC.FROM_CODE, IGCC.PURCH_ACC_CODE FROM INV_GL_CONFIG_CATEGORY IGCC WHERE IGCC.CAT_STRUC_ID IN (27,88,91) AND IGCC.SUB_INV_ID NOT IN (8, 10)";
                                                $result1= oci_parse($conn, strtoupper($sql1));
                                                oci_execute($result1);
                                                while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                                                    $fromcode = explode("-", $row1["FROM_CODE"]);
                                                    if($newcodevalue[0] === $fromcode[0]){
                                                        $newpurchid = $row1["PURCH_ACC_CODE"];
                                                        $sql2 = "SELECT DISTINCT CCV.CODE_VALUE, CCV.ACCOUNTING_DESC FROM CODE_COMBINATION_VALUES CCV WHERE CCV.CODE_COMBINATION_ID = '$newpurchid'";
                                                        $result2 = oci_parse($conn, strtoupper($sql2));
                                                        oci_execute($result2);
                                                        $row2 = oci_fetch_array($result2,  OCI_ASSOC+OCI_RETURN_NULLS) ?>
                                                            <td>
                                                                <?php $explode = explode("-",$row2["CODE_VALUE"]); ?>
                                                                @foreach($explode as $data1)
                                                                    {{$data1}}<br>
                                                                @endforeach
                                                                - {{$newcodevalue[0]}}
                                                            </td>
                                                            <td>
                                                                <?php $explode = explode(" ",$row2["ACCOUNTING_DESC"]); ?>
                                                                @foreach($explode as $data1)
                                                                    {{$data1}}<br>
                                                                @endforeach
                                                                - {{$fromcode[0]}}
                                                            </td>
                                                        <?php break; 
                                                    }
                                                }
                                            ?>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-dark my-2">
                                        <tr>
                                            <th class="text-white" hidden>.</th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
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
                                            <th class="text-white" data-orderable="false">{{number_format($sum_qty,2)}}</th>
                                            <th class="text-white" data-orderable="false">{{number_format($sum_rate,2)}}</th>
                                            <th class="text-white" data-orderable="false">{{number_format($sum_amount,2)}}</th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                            <th class="text-white" data-orderable="false"></th>
                                        </tr>
                                    </tfoot>
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
@if($Permission != 3)
<div class="modal fade bd-example-modal-xl" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" style="margin-top: 5%;">
            <div class="modal-header" style="background: transparent !important;">
            <h5 class="modal-title" id="exampleModalLongTitle">Material Consumption Report</h5>
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
                                <select id="books" name="books" style="border: 1px solid #bfbfbf;" class="form-control select.custom-select" required>
                                    <option selected value="">Select Book</option>   
                                    @foreach($books as $value)
                                        @if(!empty($sessionData['requestbook']))
                                            <option <?php if($value == $sessionData['requestbook']) echo 'selected="selected"'; ?> value="{{$value}}">{{$value}}</option>
                                        @else
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endif  
                                    @endforeach 
                                </select>
                            </div>
                            <div class="col-sm-6" hidden>
                                <label><b style="color: #6c757d">Select Department</b></label>
                                <span style="display: flex;">
                                    <input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize;" id="transfer" name="transfer" department="Select Transfer No">
                                    <span>
                                        <a data-toggle="modal" data-target="#exampleModalCenter212" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                    </span>
                                </span>
                            </div>
                            <div class="col-sm-6">
                                <label><b style="color: #6c757d">Select Department</b></label>
                                <select id="department" name="department" style="border: 1px solid #bfbfbf;" class="form-control select.custom-select">
                                    <option selected value="NULL">Select Department</option>   
                                    @foreach($department as $value)
                                        @if(!empty($sessionData['requestdepartment']))
                                            <option <?php if($value == $sessionData['requestdepartment']) echo 'selected="selected"'; ?> value="{{$value}}">{{$value}}</option>
                                        @else
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endif  
                                    @endforeach 
                                </select>
                            </div>
                        </div>
                        <div class="form-group row py-1">
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
                                <label><b style="color: #6c757d">Locator</b></label>
                                <select id="locator" name="locator" style="border: 1px solid #bfbfbf; text-transform: capitalize;" class="form-control select.custom-select">
                                    <option selected value="">Select Locator</option>   
                                    @foreach($locator as $value)
                                        @if(!empty($sessionData['requestlocator']))
                                            <option <?php if($value == $sessionData['requestlocator']) echo 'selected="selected"'; ?> value="{{$value}}">{{$value}}</option>
                                        @else
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endif  
                                    @endforeach 
                                </select>
                            </div>
                        </div>
                        <div class="form-group row py-2">
                            <div class="col-sm-6 mb-1 mb-sm-0">
                                <label><b style="color: #6c757d">SO No</b></label>
                                <input id="sono" name="sono" type="text" class="typeahead form-control yourclass" <?php if(isset($sessionData['requestsono'])) echo "value='{$sessionData['requestsono']}'"; ?> style="border: 1px solid #bfbfbf;" placeholder="SO Code">
                            </div>
                            <div class="col-sm-6 mb-1 mb-sm-0">
                                <label><b style="color: #6c757d">RM Code</b></label>
                                <input id="rmcode" name="rmcode" type="text" class="typeahead form-control yourclass" <?php if(isset($sessionData['requestrmcode'])) echo "value='{$sessionData['requestrmcode']}'"; ?> style="border: 1px solid #bfbfbf;" placeholder="RM Code">
                            </div>
                        </div>
                        <div class="form-group row py-2">
                            <div class="col-sm-6 mb-1 mb-sm-0">
                                <label><b style="color: #6c757d">Article Code</b></label>
                                <input id="artcode" name="artcode" type="text" class="typeahead form-control yourclass" <?php if(isset($sessionData['requestartcode'])) echo "value='{$sessionData['requestartcode']}'"; ?> style="border: 1px solid #bfbfbf;" placeholder="Article No">
                            </div>
                            <div class="col-sm-6 mb-1 mb-sm-0">
                                <label><b style="color: #6c757d">Store Issue Note</b></label>
                                <input id="sinno" name="sinno" type="text" class="typeahead form-control yourclass" <?php if(isset($sessionData['requestsinno'])) echo "value='{$sessionData['requestsinno']}'"; ?> style="border: 1px solid #bfbfbf;" placeholder="Store Issue No">
                            </div>
                        </div>
                        <div class="form-group row py-2">
                            <div class="col-sm-6 mb-1 mb-sm-0">
                                <label><b style="color: #6c757d">Category</b></label>
                                <select id="cat" name="cat" style="border: 1px solid #bfbfbf; text-transform: capitalize;" class="form-control select.custom-select">
                                    <option selected value="">Select Category</option>   
                                    @foreach($category as $value)
                                        @if(!empty($sessionData['requestcat']))
                                            <option <?php if($value == $sessionData['requestcat']) echo 'selected="selected"'; ?> value="{{$value}}">{{$value}}</option>
                                        @else
                                            <option value="{{$value}}">{{$value}}</option>
                                        @endif  
                                    @endforeach 
                                </select>
                            </div>
                            <div class="col-sm-6 mb-1 mb-sm-0">
                                <label><b style="color: #6c757d">Sub Category</b></label>
                                <select id="subcat" name="subcat" style="border: 1px solid #bfbfbf; text-transform: capitalize;" class="form-control select.custom-select">
                                    <option selected value="">Select Sub Category</option> 
                                    @foreach($subCategory as $value)
                                        @if(!empty($sessionData['requestsubcat']))
                                            <option <?php if($value == $sessionData['requestsubcat']) echo 'selected="selected"'; ?> value="{{$value}}">{{$value}}</option>
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
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif
<script src="assets/js/customjquery.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script src="plugins/moment/moment.js"></script>
<script src="plugins/apexcharts/apexcharts.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="plugins/chartjs/chart.min.js"></script>
<script src="plugins/chartjs/roundedBar.min.js"></script>
<script src="plugins/lightpick/lightpick.js"></script>
<script src="assets/pages/jquery.sales_dashboard.init.js"></script>
<script src="assets/js/cdn1.min.js"></script>
<script src="assets/js/cdn2.min.js"></script>
<script>
    $(document).ready(function(){ 
        $("#loader1").fadeOut(1200);
        $("body").addClass("enlarge-menu");
        $("#loader2").css('display','none !important');
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
</script>
<script>
$('#deppp').on('change', function(){
    document.getElementById("myForm").submit();
});
$("#submit").click(function(){
    $("#myForm").attr("action", "material-report");
    document.getElementById("myForm").submit();
});
$("#download").click(function(){
    $("#myForm").attr("action", "material-report-download");
    document.getElementById("myForm").submit();
});
</script>
<script>
$(document).ready(function(){
    $(".btnSelectuser").on('click',function(){
        var currentRow = $(this).closest("tr");
        var col1 = currentRow.find("td:eq(1)").html();
        $("#exampleModalCenter212").modal('hide');
        $("#transfer").val(col1);
        $("body").addClass("enlarge-menu");
    });
});
</script>
<script src="plugins/moment/moment.js"></script>
<script src="plugins/apexcharts/apexcharts.min.js"></script>
<script src="plugins/apexcharts/irregular-data-series.js"></script>
<script src="plugins/apexcharts/ohlc.js"></script>
<script src="assets/pages/jquery.apexcharts.init.js"></script>
<script>
    var path1 = "{{route('sono')}}";
    var path2 = "{{route('rmcode')}}";
    var path3 = "{{route('artcode')}}";  
    var path4 = "{{route('sinno')}}";
    $("#sono").autocomplete({
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
            $('#sono').val(ui.item.label);
            console.log(ui.item); 
            return false;
        }
    });
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
    $("#artcode").autocomplete({
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
            $('#artcode').val(ui.item.label);
            console.log(ui.item); 
            return false;
        }
    });
    $("#sinno").autocomplete({
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
            $('#sinno').val(ui.item.label);
            console.log(ui.item); 
            return false;
        }
    });
</script>
@endsection