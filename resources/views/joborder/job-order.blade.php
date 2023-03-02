@extends( (Auth::user()->id == "2") ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<style>
    .dropify-wrapper{
        height: 130px;
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
    .yourclass::-webkit-input-placeholder{
        color: #6c757d;
    }
    .displayBadgess{
        text-align :center;
    }
    #loader1 {  
        position: fixed;  
        left: 0px;  
        top: 0px;  
        width: 100%;  
        height: 100%;  
        z-index: 9999;  
        background: url("/img/avatars/3dgifmaker.gif") 50% 50% no-repeat black;  
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
    <div class="row px-1">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Job Order</li>
                    </ol>
                </div>
                <h4 class="page-title">Job Order</h4>
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-lg-12 mb-5">
            <div class="card">
                <div class="card-body p-5">
                    <form action="{{url('job-order-create')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-2 mb-5">
                            <div class="col-sm-10 col-md-10 py-0">
                                <div class="form-group row py-0">
                                    <div class="col-sm-3 col-md-3 py-1">
                                        <label><b style="color: #6c757d;">Season</b></label>
                                        <p class="py-2 px-3" style="border: 1px solid #b5b0b0; text-transform: capitalize; border-radius: 5px; font-family: system-ui;">{{$data['data']['season']}}</p>
                                        <input hidden type="text" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" value="{{$data['data']['season']}}" id="season" name="season">
                                        <input hidden type="text" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="Sizelength" name="Sizelength">
                                        <input hidden type="text" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" value="{{$data['data']['design_no']}}" id="design_no" name="design_no">
                                    </div>
                                    <div class="col-sm-5 py-1">
                                        <label><b style="color: #6c757d">Company</b></label>
                                        <p class="py-2 px-3" style="border: 1px solid #b5b0b0; text-transform: capitalize; border-radius: 5px; font-family: system-ui;">{{$JobOrderData['COMPANY_NAME']}}</p>
                                        <input hidden type="text" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" value="{{$JobOrderData['COMPANY_NAME']}}" id="company" name="company">
                                    </div>
                                    <div class="col-sm-2 col-md-2 py-1"><label><b style="color: #6c757d">Sales Order No</b></label>
                                        <p class="py-2 px-3" style="border: 1px solid #b5b0b0; text-transform: capitalize; border-radius: 5px; font-family: system-ui;">2606</p>
                                        <input hidden type="text" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" value="2606" id="sono" name="sono" readonly>
                                    </div>
                                    <div class="col-sm-2 col-md-2 py-1">
                                        <label><b style="color: #6c757d">Article No</b></label>
                                        <select id="article" name="article" style="border: 1px solid #bfbfbf; text-transform: capitalize;" class="form-control custom-select" required>
                                            <option selected disabled>Article No</option> 
                                            @foreach($article as $val)
                                                <option style="text-transform: capitalize;" value="{{$val}}">{{$val}}</option>
                                            @endforeach  
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row py-0">
                                    <div class="col-sm-3 col-md-3 py-1">
                                        <label><b style="color: #6c757d">Department</b></label>
                                        <select id="department" name="department" style="border: 1px solid #bfbfbf; text-transform: capitalize;" class="select2 form-control mb-3 custom-select" required>
                                            <option selected disabled>Select Department</option> 
                                            <option value="Cutting">Cutting</option>
                                            <option value="Closing">Closing</option>
                                            <option value="Lasting">Lasting</option>
                                            <option value="Insole">Insole</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3 col-md-3 py-1">
                                        <label><b style="color: #6c757d">Purchase Order No</b></label>
                                        <p class="py-2 px-3" style="border: 1px solid #b5b0b0; text-transform: capitalize; border-radius: 5px; font-family: system-ui;">{{$JobOrderData['CUST_PO_NO']}}</p>
                                        <input hidden type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" value="{{$JobOrderData['CUST_PO_NO']}}" id="purchase" name="purchase" readonly>
                                    </div>
                                    <div class="col-sm-2 col-md-2 py-1">
                                        <label><b style="color: #6c757d">Customer Article No</b></label>
                                        <p class="py-2 px-3" style="border: 1px solid #b5b0b0; text-transform: capitalize; border-radius: 5px; font-family: system-ui;" id="cusArticle"></p>
                                        <input hidden type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="customer" name="customer" readonly>
                                    </div>
                                    <div class="col-sm-2 col-md-2 py-1">
                                        <label><b style="color: #6c757d">Category Type</b></label>
                                        <p class="py-2 px-3" style="border: 1px solid #b5b0b0; text-transform: capitalize; border-radius: 5px; font-family: system-ui;">{{$JobOrderData['SO_TYPE_DESC']}}</p>
                                        <input hidden type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" value="{{$JobOrderData['SO_TYPE_DESC']}}" id="category" name="category" readonly>
                                    </div>
                                    <div class="col-sm-2 col-md-2 py-1">
                                        <label><b style="color: #6c757d">Delivery Date</b></label>
                                        <p class="py-2 px-3" style="border: 1px solid #b5b0b0; text-transform: capitalize; border-radius: 5px; font-family: system-ui;">{{$JobOrderData['CUST_PO_DATE']}}</p>
                                        <input hidden type="text" class="form-control yourclass" style="border: 1px solid #a5a5a5;" placeholder="Select Date" id="date" name="date" value="{{$JobOrderData['CUST_PO_DATE']}}">
                                    </div>
                                </div>
                                <div class="form-group row py-0">
                                    <div class="col-sm-3 col-md-3 py-1">
                                        <label><b style="color: #6c757d">Method</b></label>
                                        <select id="method" name="method" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="select2 form-control mb-3 custom-select">
                                            <option style="text-transform: capitalize" value="0" selected>In-House</option>
                                            <option style="text-transform: capitalize" value="1">Outsource</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3 col-md-3 py-1">
                                        <label><b style="color: #6c757d">Size Range</b></label>
                                        <select id="sizeRange" name="sizeRange" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control custom-select" required>
                                            <option selected disabled>Select Size Range</option> 
                                            @foreach($sizerange as $val)
                                                <option style="text-transform: capitalize;" value="{{$val['description']}}">{{$val['description']}}</option>
                                            @endforeach  
                                        </select>                
                                    </div>      
                                    <div class="col-sm-6 col-md-6 py-1">
                                        <label><b style="color: #6c757d">Remarks</b></label>
                                        <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #a5a5a5; text-transform: capitalize" id="remarks" name="remarks" placeholder="Remarks">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2 col-md-2 py-0 text-center">
                                <label><b style="color: #6c757d">Attachment</b></label><br>
                                @if(isset($data['data']['image']) && !empty($data['data']['image'])) 
                                <img src="{{ asset('uploads/appsetting/' . $data['data']['image']) }}" alt="profile-user" height="100" class="rounded mt-2">
                                <input hidden type="text" value="{{$data['data']['image']}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="image" name="image">
                                @else
                                <img src="{{asset('img/photos/10.jpg')}}" alt="profile-user" height="100" class="rounded mt-2">
                                <input hidden type="text" value="10.jpg" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="image" name="image">
                                @endif 
                            </div>
                        </div>
                        <div id="JobOrderDiv">
                            @for($i=0; $i<$count; $i++)                            
                            <div class="form-group row py-1 px-2 bg-dark" style="border-radius: 4px; margin-bottom: 1px;">
                                <div class="col-sm-12 col-md-12 py-0">
                                    <div class="form-group row mb-0">
                                        <div class="col-sm-12 text-center">
                                            <h4 style="color: #ffffff;">{{$allColor[$i]}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="JobOrderDiv66" class="form-group row py-2 px-2 mb-5 bg-dark" style="border-radius: 4px;">
                                <div class="col-sm-12 col-md-12 py-0 mt-3">
                                    <div class="form-group row mb-0">
                                        <div class="col-sm-2 text-center">
                                            <div class="alert alert-light border-0 py-2 mb-0" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                                <label class="mb-0 text-white" style="font-weight: 500;">Size Breakup</label>
                                            </div>  
                                        </div>
                                        <div class="col-sm-9 text-center">
                                        </div>
                                        <div class="col-sm-1 text-center" hidden>
                                            <button style="box-shadow: none; margin-top: -3px;" type="button" id="addJobOrder" class="btn btn-success btn-round px-4 w-100"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                                        </div>
                                    </div>
                                    <div class="form-group row py-0">
                                        <table class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead class="bg-dark text-white">
                                                <tr class="ccolorDivtr1">
                                                    <th class="text-white" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">Status</b></label></th>
                                                    <th class="text-white" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">Color</b></label></th>
                                                    <th class="text-white" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">Last No.</b></label></th>
                                                    <th hidden class="text-white tdDiv" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">36</b></label></th>
                                                    <th hidden class="text-white tdDiv" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">37</b></label></th>
                                                    <th hidden class="text-white tdDiv" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">38</b></label></th>
                                                    <th hidden class="text-white tdDiv" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">39</b></label></th>
                                                    <th hidden class="text-white tdDiv" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">40</b></label></th>
                                                    <th hidden class="text-white tdDiv" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">41</b></label></th>
                                                    <th hidden class="text-white tdDiv" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">Total</b></label></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="ccolorDivtr">
                                                    <td style="border-top: none; width: 12%;">
                                                        <select id="status" name="status[]" style="border: 1px solid #bfbfbf; text-transform: capitalize; width: -webkit-fill-available;" class="select2 form-control mb-3 custom-select" required>
                                                            <option value="Good To Go" selected="selected">Good To Go</option>       
                                                            <option value="On Hold" style="color: red;">On Hold</option>
                                                        </select>
                                                    </td>
                                                    <td style="border-top: none; width: 12%;">
                                                        <select id="color" name="color[]" style="border: 1px solid #bfbfbf; text-transform: capitalize; width: -webkit-fill-available;" class="select2 form-control mb-3 custom-select" required>
                                                            <option selected>Select color</option> 
                                                            @foreach($color as $names)
                                                                <option style="text-transform: capitalize" value="{{$names}}">{{$names}}</option>
                                                            @endforeach  
                                                        </select>
                                                    </td>
                                                    <td style="border-top: none; width: 12%;">
                                                        <select id="last_no" name="last_no[]" style="border: 1px solid #bfbfbf; text-transform: capitalize; width: -webkit-fill-available;" class="select2 form-control mb-3 custom-select" required>
                                                            <option selected>Select Last No</option> 
                                                            @foreach($last as $names)
                                                                <option style="text-transform: capitalize" value="{{$names['last_no']}}">{{$names['last_no']}}</option>
                                                            @endforeach  
                                                        </select>
                                                    </td>
                                                    <td class="tdDiv" style="border-top: none;" hidden>
                                                        <input type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence6">
                                                    </td>
                                                    <td class="tdDiv" style="border-top: none;" hidden>
                                                        <input type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence6">
                                                    </td>
                                                    <td class="tdDiv" style="border-top: none;" hidden>
                                                        <input type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence6">
                                                    </td>
                                                    <td class="tdDiv" style="border-top: none;" hidden>
                                                        <input type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence6">
                                                    </td>
                                                    <td class="tdDiv" style="border-top: none;" hidden>
                                                        <input type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence6">
                                                    </td>
                                                    <td class="tdDiv" style="border-top: none;" hidden>
                                                        <input type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence6">
                                                    </td>
                                                    <td class="tdDiv" style="border-top: none;" hidden>
                                                        <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence6" readonly>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="form-group row mb-0" hidden>
                                        <div class="col-sm-2 text-center">
                                            <div class="alert alert-light border-0 py-2 mb-0" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                                <label class="mb-0 text-white" style="font-weight: 500;">Select Color</label>
                                            </div>  
                                        </div>
                                        <div class="col-sm-9 text-center">
                                        </div>
                                        <div class="col-sm-1 text-center">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-group row text-center bg-dark mb-1" style="border-radius: 4px;">
                                            <div class="col-sm-2 py-1">
                                                <label class="mb-0"><b style="color: white; font-weight: 500;">Material Code</b></label>
                                            </div>
                                            <div class="col-sm-2 py-1">
                                                <label class="mb-0"><b style="color: white; font-weight: 500;">Description</b></label>
                                            </div>
                                            <div class="col-sm-1 py-1">
                                                <label class="mb-0"><b style="color: white; font-weight: 500;">Unit</b></label>
                                            </div>
                                            <div class="col-sm-1 py-1">
                                                <label class="mb-0"><b style="color: white; font-weight: 500;">Division</b></label>
                                            </div>
                                            <div class="col-sm-2 py-1">
                                                <label class="mb-0"><b style="color: white; font-weight: 500;">Sub Division</b></label>
                                            </div>
                                            <div class="col-sm-1 py-1">
                                                <label class="mb-0"><b style="color: white; font-weight: 500;">Output</b></label>
                                            </div>
                                            <div class="col-sm-1 py-1">
                                                <label class="mb-0"><b style="color: white; font-weight: 500;">Process <br> Code</b></label>
                                            </div>                            
                                            <div class="col-sm-1 py-1">
                                                <label class="mb-0"><b style="color: white; font-weight: 500;">Process <br> Loss %</b></label>
                                            </div>
                                            <div class="col-sm-1 py-1 text-center">
                                                <button style="box-shadow: none; margin-top: -3px;" type="button" class="btn btn-outline-success btn-round px-4 w-100 addColor" name="{{$allColor[$i]}}" data-id={{$i}} id="addColor"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                                            </div>                                      
                                        </div>
                                    </div>
                                    <div id="colorDiv{{$i}}">
                                        @foreach($materailData as $data) 
                                            <?php $allColorData = ucfirst($data->color); ?> 
                                            @if($allColorData == $allColor[$i])  
                                                <div class="form-group row mb-2" id="Div{{$data->id}}">
                                                    <div class="col-sm-2 py-1">                                                      
                                                        <input readonly id="cut_item_code1" value="{{$data->item_code}}" style="border: 1px solid #bfbfbf;" name="cut_item_code[]" class="form-control py-2" placeholder="Code" required>
                                                        <input hidden readonly id="cut_color1" value="{{$allColor[$i]}}" style="border: 1px solid #bfbfbf;" name="cut_color[]" class="form-control py-2">                                                        
                                                    </div>
                                                    <div class="col-sm-2 py-1">
                                                        <input readonly value="{{$data->description}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_description1" name="cut_description[]" placeholder="Description" required>
                                                    </div>
                                                    <div class="col-sm-1 py-1">
                                                        <input readonly value="{{$data->uom}}" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_uom1" name="cut_uom[]" placeholder="Unit">
                                                    </div>                               
                                                    <div class="col-sm-1 py-1">
                                                        <input readonly value="{{$data->division}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_division" name="cut_division[]" placeholder="Quantity">                                                      
                                                    </div>
                                                    <div class="col-sm-2 py-1">
                                                        <input readonly value="{{$data->subdivision}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_subdivision" name="cut_subdivision[]" placeholder="Quantity">                                                    
                                                    </div>
                                                    <div class="col-sm-1 py-1">
                                                        <input readonly value="{{$data->output}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_output" name="cut_output[]" placeholder="Quantity">
                                                    </div>
                                                    <div class="col-sm-1 py-1">
                                                        <input readonly value="{{$data->cut_code}}" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_cut_code" name="cut_cut_code[]" placeholder="Code">
                                                    </div>
                                                    <div class="col-sm-1 py-1">
                                                        <input readonly value="{{$data->process}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_process" name="cut_process[]" placeholder="%">
                                                    </div>
                                                    <div class="col-sm-1 py-1 text-center">
                                                        <button id="" data-id="{{$data->id}}" type="button" style="-webkit-box-shadow: none; box-shadow: none;" class="removeRow121 btn btn-outline-danger btn-round px-4 w-100" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endfor
                        </div>
                        <div class="form-group row mt-5">
                            <div class="col-sm-3 mb-1 mb-sm-0">
                            </div>
                            <div class="col-sm-6">
                                <button type="submit" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white">Submit</button>
                            </div>
                            <div class="col-sm-3" id="Hye">
                            <table><tbody></tbody></table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/customjquery.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script>
$(document).ready(function(){ 
	$("#loader1").fadeOut(1200);
    $("body").addClass("enlarge-menu");
    $('#cusArticle').html('-');    
    $('#customer').val('0');
    window.sessionStorage.setItem("items", JSON.stringify(0));
    var i = 1;
    $('#addColor43').click(function(){
        $("#JobOrderDiv66").clone().attr('id','h2').appendTo('#JobOrderDiv');    
    });
    $('.addColor').click(function(){
        var dataId = $(this).attr("data-id"); 
        var name = $(this).attr("name"); 
        i++;
        $('#colorDiv'+dataId).append(
                                    '<div class="form-group row mb-2" id="Div9{{$data->id}}">'+
                                        '<div class="col-sm-2 py-1" style="display: inline-flex;">'+                                                     
                                            '<input readonly id="cut_item_code1" style="border: 1px solid #bfbfbf;" name="cut_item_code[]" class="form-control py-2" placeholder="Code" required>'+ 
                                            '<input hidden readonly id="cut_item_code1" style="border: 1px solid #bfbfbf;" name="cut_item_code[]" value="'+name+'" class="form-control py-2" placeholder="Code" required>'+                                                                                           
                                        '</div>'+
                                        '<div class="col-sm-2 py-1">'+
                                            '<input readonly class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_description1" name="cut_description[]" placeholder="Description" required>'+
                                        '</div>'+
                                        '<div class="col-sm-1 py-1">'+
                                            '<input readonly class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_uom1" name="cut_uom[]" placeholder="Unit">'+
                                        '</div> '+                         
                                        '<div class="col-sm-1 py-1">'+
                                            '<select id="cut_division" name="cut_division[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select divisionsValue'+i+'" onchange="getval('+i+',this.value);" data-id="cutting1">'+                                    
                                            '</select>'+                                                   
                                        '</div>'+
                                        '<div class="col-sm-2 py-1" id="division1div'+i+'">'+
                                            '<select id="cut_subdivision" name="cut_subdivision[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select division1'+i+'" required>'+                                    
                                            '</select>'+
                                        '</div>'+
                                        '<div class="col-sm-1 py-1">'+
                                            '<input readonly class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_output" name="cut_output[]" placeholder="Quantity">'+
                                        '</div>'+
                                        '<div class="col-sm-1 py-1">'+
                                            '<input readonly class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_cut_code" name="cut_cut_code[]" placeholder="Code">'+
                                        '</div>'+
                                        '<div class="col-sm-1 py-1">'+
                                            '<input readonly class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_process" name="cut_process[]" placeholder="%">'+
                                        '</div>'+
                                        '<div class="col-sm-1 py-1 text-center">'+
                                            '<button id="" data-id="{{$data->id}}" type="button" style="-webkit-box-shadow: none; box-shadow: none;" class="removeRow18 btn btn-outline-danger btn-round px-4 w-100" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>'+
                                        '</div>'+
                                    '</div>');

        $.ajax({
            type: 'GET',
            url: 'GetDivision',
            dataType: "json",
            success: function(data){
                if(data){
                    for(z=0; z<data.length; z++){
                        var $dataToBeAppended1 = `<option value=`+data[z].id+`>`+data[z].description+`</option>`;
                        $(".divisionsValue"+i).append($dataToBeAppended1);
                    }
                }
            }
        });
    });
    $(document).on('click', '.removeRow18', function(){
        var id = $(this).attr("data-id"); 
        $('#Div9'+id).remove();
    });
    $(document).on('click', '.removeRow121', function(){
        var id = $(this).attr("data-id"); 
        $('#Div'+id).remove();
    });
});
</script>
<script>
    function getval(id,value){    
        $.ajax({
            type: 'GET',
            url: 'getSubDivision/'+value,
            dataType: "json",
            success: function(data){
                if(data){
                    $("#division1div"+id).find('select').find('option').remove();
                    for(i=0; i<data.length; i++){
                        var $dataToBeAppended = `<option>`+data[i].description+`</option>`;
                        $(".division1"+id).append($dataToBeAppended);
                    }
                }
            }
        });
    }
</script>
<script>
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
            showConfirmButton: false,
			timer: 2000
        });
        break;
    }
@endif
</script>
<script>
    $('#sizeRange').on('change', function(){
        $('.tdDiv').remove();
        $('.tdDiv1').remove();
        var sizeRange = $(this).val();
        const myArray = sizeRange.split("-");
        const Sizelength = Math.abs(myArray[1] - myArray[0]);
        console.log("Sizelength");
        console.log(Sizelength);
        console.log("Sizelength");
        $('#Sizelength').val(Sizelength+1);
        var all = [];
        for(i = 0; i <= Sizelength; i++){
            let element = Number(myArray[0])+i;
            all.push(element);
            $('.ccolorDivtr1').append('<th class="text-white tdDiv" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">'+element+'</b></label></th>');
            $('.ccolorDivtr').append('<td class="tdDiv" style="border-top: none;">'+
                                        '<input type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence7[]">'+
                                    '</td>');
        }
        $('.ccolorDivtr1').append('<th class="text-white tdDiv" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">Total</b></label></th>');
        $('.ccolorDivtr').append('<td class="tdDiv" style="border-top: none;">'+
                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence2[]">'+
                                '</td>');
        const total = Number(sessionStorage.getItem("items"))+1;
        const length = sessionStorage.getItem("items");
        if(sessionStorage.getItem("items") != 0){
            for(ii = length; ii <= total; ii++){
                for(i = 0; i <= Sizelength; i++){
                    let element = Number(myArray[0])+i;
                    all.push(element);
                    $('.colorDivtr1'+ii+'').append('<th class="text-white tdDiv1" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">'+element+'</b></label></th>');
                    $('.colorDivtr'+ii+'').append('<td class="tdDiv1" style="border-top: none;">'+
                                                    '<input type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence1">'+
                                                '</td>');
                }
                $('#.colorDivtr1'+ii+'').append('<th class="text-white tdDiv1" data-orderable="false" style="border: none; padding-bottom: 0px;"><label><b style="color: #ffffff;">Total</b></label></th>');
                $('#.colorDivtr'+ii+'').append('<td class="tdDiv1" style="border-top: none;">'+
                                                    '<input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sequence" name="sequence5">'+
                                                '</td>');
            }
        }
    });
    $('#article').on('change', function(){
        var article = $(this).val();
        var company = $("#company").val();
        var sono = '2602'
        $.ajax({
            type: 'GET',
            url: 'articleData/'+article+'/'+company+'/'+sono,
            dataType: "json",
            success: function(data){
                console.log("Data");
                console.log(data);
                if(data.data != null){
                    if(data.value == 1){
                        $('#cusArticle').html(data.data);
                        $('#customer').val(data.data);
                    }
                }
                else{
                    console.log("Else");
                    $('#cusArticle').html('-');
                    $('#customer').val('0');
                }
            }
        });
    });
</script>
@endsection