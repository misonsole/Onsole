@extends( (Auth::user()->id == "2") ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<style>
    .dropify-wrapper 
    {
        height: 130px;
        margin-bottom: 2%;
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
</style>
<div id="loader1" class="rotate" width="100" height="100"></div>
<div class="container-fluid px-5">
    <div class="row px-2">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('specification-sheet-table')}}">Manage Specification Sheet</a></li>
                        <li class="breadcrumb-item active" style="font-family: 'Poppins', sans-serif;">Edit Specification Sheet</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Specification Sheet</h4>
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-lg-12 mb-5">
            <div class="card">
                <div class="card-body p-5">
                    <form action="{{url('specification-sheet-update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-0 mb-0">
                            <div class="col-sm-12 col-md-12">
                                <span id="StrengthDisp3" style="font-size: 15px !important;" class="badge displayBadgess text-light py-3 mt-2"></span> 
                            </div>
                        </div>
                        <div class="form-group row py-2 mb-5">
                            <div class="col-sm-8 col-md-8 py-0">
                                <div class="form-group row py-0">
                                    <div class="col-sm-3 col-md-3 py-1">
                                        <input type="text" name="id" value="{{$id}}" hidden>
                                        <label><b style="color: #6c757d">Season</b></label>
                                        <select id="season" name="season" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                            <option selected disabled>Select Season</option> 
                                            @foreach($season as $names)
                                                <option <?php if($names == $userseason) echo 'selected="selected"'; ?> value="{{ $names }}">{{ $names }}</option>
                                            @endforeach  
                                        </select>
                                    </div>
                                    <div class="col-sm-3 col-md-3 py-1">
                                        <label><b style="color: #6c757d">Category</b></label>
                                        <select id="category" name="category" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                            <option selected disabled>Select Category</option> 
                                            @foreach($category as $names)
                                                <option <?php if($names['description'] == $usercategory) echo 'selected="selected"'; ?> value="{{ $names['description'] }}">{{ $names['description'] }}</option>
                                            @endforeach  
                                        </select>
                                    </div>
                                    <div class="col-sm-3 col-md-3 py-1">
                                        <label><b style="color: #6c757d">Shape</b></label>
                                        <select id="shape" name="shape" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                            <option selected disabled>Select Shape</option> 
                                            @foreach($shape as $names)
                                                <option <?php if($names['description'] == $usershape) echo 'selected="selected"'; ?> value="{{ $names['description'] }}">{{ $names['description'] }}</option>
                                            @endforeach  
                                        </select>
                                    </div>
                                    <div class="col-sm-3 col-md-3 py-1">
                                        <label><b style="color: #6c757d">Sole</b></label>
                                        <select id="sole" name="sole" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                            <option selected disabled>Select Sole</option> 
                                            @foreach($sole as $names)
                                                <option <?php if($names['description'] == $usersole) echo 'selected="selected"'; ?> value="{{ $names['description'] }}">{{ $names['description'] }}</option>
                                            @endforeach  
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row py-0">
                                    <div class="col-sm-3 col-md-3 py-1">
                                        <label><b style="color: #6c757d">Project</b></label>
                                        <select id="project" name="project" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                            <option selected disabled>Select Project</option> 
                                            @foreach($project as $names)
                                                <option <?php if($names['description'] == $userproject) echo 'selected="selected"'; ?>  style="text-transform: capitalize" value="{{$names['description'] }}">{{$names['description']}}</option>
                                            @endforeach  
                                        </select>
                                    </div>
                                    <div class="col-sm-3 col-md-3 py-1">
                                        <label><b style="color: #6c757d">Range</b></label>
                                        <select id="range" name="range" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                            <option selected disabled>Select Range</option> 
                                            @foreach($range as $names)
                                                <option <?php if($names['description'] == $userrange) echo 'selected="selected"'; ?> style="text-transform: capitalize" value="{{$names['description'] }}">{{$names['description']}}</option>
                                            @endforeach  
                                        </select>
                                    </div>
                                    <div class="col-sm-6 col-md-6 py-1">
                                        <label><b style="color: #6c757d">Design No</b></label>
                                        <span style="display: flex;">
                                            <input value="{{$userdesign}}" type="text" class="form-control py-2 yourclass readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="design" name="design" placeholder="Design No" required>
                                            <span>
                                                <a id="selectsequence" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-autorenew"></i></a>                                        
                                            </span>
                                        </span>
                                    <span id="StrengthDisp2" style="font-size: 13px !important;" class="badge displayBadgess text-light py-2 mt-2"></span>                                                          
                                    </div>
                                </div>
                                <div class="form-group row py-0">
                                    <div class="col-sm-3 col-md-3 py-1">
                                        <label><b style="color: #6c757d">Purpose</b></label>
                                        <input value="{{$userpurpose}}" id="purpose" name="purpose" type="text" class="form-control yourclass" style="border: 1px solid #bfbfbf;" placeholder="Purpose" required>
                                    </div>
                                    <div class="col-sm-3 col-md-3 py-1">
                                        <label><b style="color: #6c757d">Product</b></label>
                                        <input value="{{$userproduct}}" id="product" name="product" type="text" class="form-control yourclass" style="border: 1px solid #bfbfbf;" placeholder="Product Name">
                                    </div>
                                    <div class="col-sm-6 col-md-6 py-1">
                                        <label><b style="color: #6c757d">Design Description</b></label>
                                        <input value="{{$userdescription}}" type="text" class="form-control py-2 yourclass readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="description" name="description" placeholder="Design Description" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4 py-1">
                                <div class="form-group row py-0">
                                    <div class="col-md-6 py-0">
                                    <label><b style="color: #6c757d">Last</b></label>
                                        <select id="last" name="last" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                            <option selected disabled>Select Last</option> 
                                            @foreach($last as $names)
                                                <option <?php if($names['last_no'] == $userlast) echo 'selected="selected"'; ?> style="text-transform: capitalize" value="{{$names['last_no'] }}">{{$names['last_no']}}</option>
                                            @endforeach  
                                        </select>
                                        <div class="row py-3">
                                            <div class="col-sm-12 py-1">
                                                <label class="mt-2"><b style="color: #6c757d">Pricing Sheet No</b></label>
                                                <select id="pricing" name="pricing" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                                    <option selected disabled>Select Pricing Sheet No</option> 
                                                    @foreach($designNo as $names)
                                                        <option <?php if($names == $userpricing) echo 'selected="selected"'; ?> style="text-transform: capitalize" value="{{$names}}">{{$names}}</option>
                                                    @endforeach  
                                                </select>           
                                            </div>
                                        </div>
                                        <div class="row py-2">
                                            <div class="col-sm-12">
                                                <label><b style="color: #6c757d">Sequence</b></label>
                                                <input value="{{$sequence}}" id="sequence" name="sequence" type="text" class="form-control yourclass readonly" style="border: 1px solid #bfbfbf;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 py-1">
                                        <label><b style="color: #6c757d">Attachment</b></label><br>
                                        @if(isset($image) && !empty($image)) 
                                        <input type="file" name="image" id="input-file-now-custom-1" class="dropify" data-default-file="{{ asset('uploads/appsetting/' . $image) }}"/>
                                        @else
                                        <input type="file" name="image" id="input-file-now-custom-1" class="dropify" data-default-file="img/photos/23.jpg" required/>
                                        @endif
                                        <br>
                                        <label><b style="color: #6c757d">Date</b></label>
                                        <input value="{{$date}}" type="text" class="form-control yourclass" style="border: 1px solid #bfbfbf;" placeholder="Select Date" id="mdate" name="date">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row text-center bg-dark py-1 mx-1" style="border-radius: 4px;">
                            <div class="col-sm-2 py-1">
                                <label class="mb-0"><b style="color: white; font-weight: 500;">Material Code</b></label>
                            </div>
                            <div class="col-sm-3 py-1">
                                <label class="mb-0"><b style="color: white; font-weight: 500;">Description</b></label>
                            </div>
                            <div class="col-sm-1 py-1">
                                <label class="mb-0"><b style="color: white; font-weight: 500;">Unit</b></label>
                            </div>
                            <div class="col-sm-2 py-1">
                                <label class="mb-0"><b style="color: white; font-weight: 500;">Component</b></label>
                            </div>
                            <div class="col-sm-2 py-1">
                                <label class="mb-0"><b style="color: white; font-weight: 500;">Output</b></label>
                            </div>
                            <div class="col-sm-1 py-1" hidden>
                                <label class="mb-0"><b style="color: white; font-weight: 500;">Consumption Factor</b></label>
                            </div>
                            <div class="col-sm-1 py-1" hidden>
                                <label class="mb-0"><b style="color: white; font-weight: 500;">Consumption Quantity</b></label>
                            </div>
                            <div class="col-sm-1 py-1">
                                <label class="mb-0"><b style="color: white; font-weight: 500;">Process Loss %</b></label>
                            </div>
                            <div class="col-sm-1 py-1" hidden>
                                <label class="mb-0"><b style="color: white; font-weight: 500;">Total Consumption</b></label>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-sm-2 text-center">
                                <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                    <label class="mb-0 text-white" style="font-weight: 600;">Cutting</label>
                                </div>  
                            </div>
                            <div class="col-sm-9 text-center">
                            </div>
                            <div class="col-sm-1 text-center">
                                <button id="cutting" type="button" class="btn btn-outline-primary btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                            </div>
                        </div>
                        <div id="cuttingrow">
                            @if(!$cuttingData)
                            <div class="form-group row mb-2">
                                <div class="col-sm-2 py-1" style="display: inline-flex;">
                                    <span>
                                        <input id="cut_item_code1" type="text" name="cut_item_code[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 yourclass" placeholder="Code" required>                                        
                                    </span>
                                    <span>
                                        <a data-toggle="modal" onclick="myFunction1('1', 'cutting')" data-id="1" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                    </span>
                                </div>
                                <div class="col-sm-3 py-1">
                                    <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="u_description1" name="u_description[]" placeholder="Description" required>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="u_uom1" name="u_uom[]" placeholder="Unit">
                                </div> 
                                <div class="col-sm-2 py-1">
                                    <select id="cut_component" name="cut_component[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                    <option selected value="null">None</option> 
                                        @foreach($location as $names)
                                            <option style="text-transform: capitalize" value="{{$names['location_no'] }}">{{$names['location_no']}}</option>
                                        @endforeach  
                                    </select>
                                </div>
                                <div class="col-sm-2 py-1">
                                    <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_output" name="cut_output[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_fac" name="cut_fac[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" step=".0001" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_qty" name="cut_qty[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input min="0" type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_process" name="cut_process[]" placeholder="%">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_total_con" name="cut_total_con[]" placeholder="Total">
                                </div>
                                <div class="col-sm-1 py-1 text-center">
                                    <button id="cutting" type="button" class="btn btn-outline-primary btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                                </div>
                            </div>
                            @else
                            @foreach($cuttingData as $data)
                            <div id="insolerow1{{$a1++}}" class="form-group row mb-2">
                                <div class="col-sm-2 py-1" style="display: inline-flex;">
                                    <span>
                                        <input id="cut_item_code1" value="{{$data->item_code}}" type="text" style="border: 1px solid #bfbfbf;" name="cut_item_code[]" class="form-control py-2" placeholder="Code" required>                                        
                                    </span>
                                    <span>
                                        <a data-toggle="modal" onclick="myFunction1('1', 'cutting')" data-id="1" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                    </span>
                                </div>
                                <div class="col-sm-3 py-1">
                                    <input type="text" value="{{$data->description}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_description1" name="cut_description[]" placeholder="Description" required>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input type="text" value="{{$data->uom}}" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_uom1" name="cut_uom[]" placeholder="Unit">
                                </div>                               
                                <div class="col-sm-2 py-1">
                                    <select id="cut_component" name="cut_component[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                    <option selected value="null">None</option> 
                                        @foreach($location as $names)
                                            <option <?php if ($data->component == $names['location_no']) echo "selected"; ?> style="text-transform: capitalize" value="{{$names['location_no'] }}">{{$names['location_no']}}</option>
                                        @endforeach  
                                    </select>
                                </div>
                                <div class="col-sm-2 py-1">
                                    <input value="{{$data->output}}" type="text" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_output" name="cut_output[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" step=".01" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_fac" name="cut_fac[]" placeholder="Factor">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" value="{{$data->total_qty}}" type="number" step=".0001" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_qty" name="cut_qty[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input min="0" value="{{$data->process}}" type="number" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_process" name="cut_process[]" placeholder="%">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" value="{{$data->total}}" type="number" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_total_con" name="cut_total_con[]" placeholder="Total">
                                </div>
                                <div class="col-sm-1 py-1 text-center">
                                    <button id="{{$a2++}}" type="button" class="removeRow1 btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            <div name="cutting">
                            </div>
                        </div>
                        <div class="form-group row mb-0 mt-5">
                            <div class="col-sm-2 text-center">
                                <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                    <label class="mb-0 text-white" style="font-weight: 600;">INSOLE</label>
                                </div>  
                            </div>
                            <div class="col-sm-9 text-center">
                            </div>
                            <div class="col-sm-1 text-center">
                                <button id="insole" type="button" class="btn btn-outline-primary btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                            </div>
                        </div>
                        <div id="insolerow">
                            @if(!$InsoleData)
                            <div class="form-group row mb-2">
                                <div class="col-sm-2 py-1" style="display: inline-flex;">
                                    <span>
                                        <input id="i_item_code1" type="text" name="i_item_code[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 yourclass" placeholder="Code">                                        
                                    </span>
                                    <span>
                                        <a data-toggle="modal" onclick="myFunction1('1', 'insole')" data-id="1" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn_l ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                    </span>
                                </div>
                                <div class="col-sm-3 py-1">
                                    <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_description1" name="i_description[]" placeholder="Description">
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_uom1" name="i_uom[]" placeholder="Unit">
                                </div> 
                                <div class="col-sm-2 py-1">
                                    <select id="i_component" name="i_component[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select">
                                    <option selected value="null">None</option> 
                                        @foreach($location as $names)
                                            <option style="text-transform: capitalize" value="{{$names['location_no'] }}">{{$names['location_no']}}</option>
                                        @endforeach    
                                    </select>
                                </div>                      
                                <div class="col-sm-2 py-1">
                                    <input type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_output" name="i_output[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_fac" name="i_fac[]" placeholder="Factor">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" step=".0001" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_qty" name="i_qty[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input min="0" type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_process" name="i_process[]" placeholder="%">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_total_con" name="i_total_con[]" placeholder="Total">
                                </div>
                                <div class="col-sm-1 py-1 text-center">
                                    <button type="button" class="btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>
                                </div>
                            </div>
                            @else
                            @foreach($InsoleData as $data)
                            <div id="insolerow2{{$b1++}}" class="form-group row mb-2">
                                <div class="col-sm-2 py-1" style="display: inline-flex;">
                                    <span>
                                        <input id="i_item_code1" value="{{$data->item_code}}" type="text" style="border: 1px solid #bfbfbf;" name="i_item_code[]" class="form-control py-2" placeholder="Code">                                        
                                    </span>
                                    <span>
                                        <a data-toggle="modal" onclick="myFunction1('1', 'insole')" data-id="1" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn_l ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                    </span>
                                </div>
                                <div class="col-sm-3 py-1">
                                    <input type="text" value="{{$data->description}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_description1" name="i_description[]" placeholder="Description">
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input type="text" value="{{$data->uom}}" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_uom1" name="i_uom[]" placeholder="Unit">
                                </div> 
                                <div class="col-sm-2 py-1">
                                    <select id="i_component" name="i_component[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select">
                                    <option selected value="null">None</option> 
                                        @foreach($location as $names)
                                            <option <?php if ($data->component == $names['location_no']) echo "selected"; ?> style="text-transform: capitalize" value="{{$names['location_no'] }}">{{$names['location_no']}}</option>
                                        @endforeach  
                                    </select>
                                </div>
                                <div class="col-sm-2 py-1">
                                    <input type="text" value="{{$data->output}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_output" name="i_output[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" step=".01" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_fac" name="i_fac[]" placeholder="Factor">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" value="{{$data->total_qty}}" step=".0001" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_qty" name="i_qty[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input min="0" type="number" value="{{$data->process}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_process" name="i_process[]" placeholder="%">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" value="{{$data->total}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_total_con" name="i_total_con[]" placeholder="Total">
                                </div>
                                <div class="col-sm-1 py-1 text-center">
                                    <button id="{{$b2++}}" type="button" class="removeRow2 btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            <div name="insole">
                            </div>
                        </div>
                        <div class="form-group row mb-0 mt-5">
                            <div class="col-sm-2 text-center">
                                <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                    <label class="mb-0 text-white" style="font-weight: 600;">Lamination</label>
                                </div>  
                            </div>
                            <div class="col-sm-9 text-center">
                            </div>
                            <div class="col-sm-1 text-center">
                                <button id="lamination" type="button" class="btn btn-outline-primary btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                            </div>
                        </div>
                        <div id="laminationrow">
                            @if(!$LaminationData)
                            <div class="form-group row mb-2">
                                <div class="col-sm-2 py-1" style="display: inline-flex;">
                                    <span>
                                        <input id="lam_item_code1" type="text" name="lam_item_code[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 yourclass" placeholder="Code">                                        
                                    </span>
                                    <span>
                                        <a data-toggle="modal" onclick="myFunction1('1', 'lamination')" data-id="1" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn_l ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                    </span>
                                </div>
                                <div class="col-sm-3 py-1">
                                    <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_description1" name="lam_description[]" placeholder="Description">
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_uom1" name="lam_uom[]" placeholder="Unit">
                                </div> 
                                <div class="col-sm-2 py-1">
                                    <select id="lam_component" name="lam_component[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select">
                                    <option selected value="null">None</option> 
                                        @foreach($location as $names)
                                            <option style="text-transform: capitalize" value="{{$names['location_no'] }}">{{$names['location_no']}}</option>
                                        @endforeach   
                                    </select>
                                </div>                      
                                <div class="col-sm-2 py-1">
                                    <input type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_output" name="lam_output[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_fac" name="lam_fac[]" placeholder="Factor">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" step=".0001" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_qty" name="lam_qty[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input min="0" type="number" class="form-control py-2 yourclass yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_process" name="lam_process[]" placeholder="%">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" class="form-control py-2 yourclass yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_total_con" name="lam_total_con[]" placeholder="Total">
                                </div>
                                <div class="col-sm-1 py-1 text-center">
                                    <button type="button" class="btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>
                                </div>
                            </div>
                            @else
                            @foreach($LaminationData as $data)
                            <div id="insolerow3{{$c1++}}" class="form-group row mb-2">
                                <div class="col-sm-2 py-1" style="display: inline-flex;">
                                    <span>
                                        <input id="lam_item_code1" value="{{$data->item_code}}" style="border: 1px solid #bfbfbf;" type="text" name="lam_item_code[]" class="form-control py-2" placeholder="Code">                                        
                                    </span>
                                    <span>
                                        <a data-toggle="modal" onclick="myFunction1('1', 'lamination')" data-id="1" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn_l ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                    </span>
                                </div>
                                <div class="col-sm-3 py-1">
                                    <input type="text" value="{{$data->description}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_description1" name="lam_description[]" placeholder="Description">
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input type="text" value="{{$data->uom}}" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_uom1" name="lam_uom[]" placeholder="Unit">
                                </div> 
                                <div class="col-sm-2 py-1">
                                    <select id="lam_component" name="lam_component[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select">
                                    <option selected value="null">None</option> 
                                        @foreach($location as $names)
                                            <option <?php if ($data->component == $names['location_no']) echo "selected"; ?> style="text-transform: capitalize" value="{{$names['location_no'] }}">{{$names['location_no']}}</option>
                                        @endforeach 
                                    </select>
                                </div>
                                <div class="col-sm-2 py-1">
                                    <input type="text" value="{{$data->output}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_output" name="lam_output[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" step=".01" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_fac" name="lam_fac[]" placeholder="Factor">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" value="{{$data->total_qty}}" step=".0001" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_qty" name="lam_qty[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input min="0" type="number" value="{{$data->process}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_process" name="lam_process[]" placeholder="%">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" value="{{$data->total}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_total_con" name="lam_total_con[]" placeholder="Total">
                                </div>
                                <div class="col-sm-1 py-1 text-center">
                                    <button id="{{$c2++}}" type="button" class="removeRow3 btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            <div name="lamination">
                            </div>
                        </div>
                        <div class="form-group row mb-0 mt-5">
                            <div class="col-sm-2 text-center">
                                <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                    <label class="mb-0 text-white" style="font-weight: 600;">Closing</label>
                                </div>  
                            </div>
                            <div class="col-sm-9 text-center">
                            </div>
                            <div class="col-sm-1 text-center">
                                <button id="closing" type="button" class="btn btn-outline-primary btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                            </div>
                        </div>
                        <div id="closingrow">
                            @if(!$ClosingData)
                            <div class="form-group row mb-2">
                                <div class="col-sm-2 py-1" style="display: inline-flex;">
                                    <span>
                                        <input id="clo_item_code1" type="text" name="clo_item_code[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 yourclass" placeholder="Code">                                        
                                    </span>
                                    <span>
                                        <a data-toggle="modal" onclick="myFunction1('1', 'closing')" data-id="1" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn_l ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                    </span>
                                </div>
                                <div class="col-sm-3 py-1">
                                    <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_description1" name="clo_description[]" placeholder="Description">
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_uom1" name="clo_uom[]" placeholder="Unit">
                                </div> 
                                <div class="col-sm-2 py-1">
                                    <select id="clo_component" name="clo_component[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select">
                                    <option selected value="null">None</option> 
                                        @foreach($location as $names)
                                            <option style="text-transform: capitalize" value="{{$names['location_no'] }}">{{$names['location_no']}}</option>
                                        @endforeach     
                                    </select>
                                </div>                      
                                <div class="col-sm-2 py-1">
                                    <input type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_output" name="clo_output[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_fac" name="clo_fac[]" placeholder="Factor">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" step=".0001" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_qty" name="clo_qty[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input min="0" type="number" class="form-control py-2 yourclass yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_process" name="clo_process[]" placeholder="%">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" class="form-control py-2 yourclass yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_total_con" name="clo_total_con[]" placeholder="Total">
                                </div>
                                <div class="col-sm-1 py-1 text-center">
                                    <button type="button" class="btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>
                                </div>
                            </div>
                            @else
                            @foreach($ClosingData as $data)
                            <div id="insolerow4{{$d1++}}" class="form-group row mb-2">
                                <div class="col-sm-2 py-1" style="display: inline-flex;">
                                    <span>
                                        <input id="clo_item_code1" value="{{$data->item_code}}" style="border: 1px solid #bfbfbf;" type="text" name="clo_item_code[]" class="form-control py-2" placeholder="Code">                                        
                                    </span>
                                    <span>
                                        <a data-toggle="modal" onclick="myFunction1('1', 'closing')" data-id="1" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn_l ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                    </span>
                                </div>
                                <div class="col-sm-3 py-1">
                                    <input type="text" value="{{$data->description}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_description1" name="clo_description[]" placeholder="Description">
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input type="text" value="{{$data->uom}}" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_uom1" name="clo_uom[]" placeholder="Unit">
                                </div> 
                                <div class="col-sm-2 py-1">
                                    <select id="clo_component" name="clo_component[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select">
                                    <option selected value="null">None</option> 
                                        @foreach($location as $names)
                                            <option <?php if ($data->component == $names['location_no']) echo "selected"; ?> style="text-transform: capitalize" value="{{$names['location_no'] }}">{{$names['location_no']}}</option>
                                        @endforeach  
                                    </select>
                                </div>
                                <div class="col-sm-2 py-1">
                                    <input type="text" value="{{$data->output}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_output" name="clo_output[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" step=".01" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_fac" name="clo_fac[]" placeholder="Factor">
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input min="0" type="number" value="{{$data->total_qty}}" step=".0001" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_qty" name="clo_qty[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" value="{{$data->process}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_process" name="clo_process[]" placeholder="%">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" value="{{$data->total}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_total_con" name="clo_total_con[]" placeholder="Total">
                                </div>
                                <div class="col-sm-1 py-1 text-center">
                                    <button id="{{$d2++}}" type="button" class="removeRow4 btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            <div name="insole">
                            </div>
                        </div>
                        <div class="form-group row mb-0 mt-5">
                            <div class="col-sm-2 text-center">
                                <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                    <label class="mb-0 text-white" style="font-weight: 600;">Lasting</label>
                                </div>  
                            </div>
                            <div class="col-sm-9 text-center">
                            </div>
                            <div class="col-sm-1 text-center">
                                <button id="lasting" type="button" class="btn btn-outline-primary btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                            </div>
                        </div>
                        <div id="lastingrow">
                            @if(!$LastingData)
                            <div class="form-group row mb-2">
                                <div class="col-sm-2 py-1" style="display: inline-flex;">
                                    <span>
                                        <input id="last_item_code1" type="text" style="border: 1px solid #bfbfbf;" name="last_item_code[]" class="form-control py-2 yourclass" placeholder="Code">                                        
                                    </span>
                                    <span>
                                        <a data-toggle="modal" onclick="myFunction1('1', 'lasting')" data-id="1" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn_l ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                    </span>
                                </div>
                                <div class="col-sm-3 py-1">
                                    <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_description1" name="last_description[]" placeholder="Description">
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_uom1" name="last_uom[]" placeholder="Unit">
                                </div> 
                                <div class="col-sm-2 py-1">
                                    <select id="last_component" name="last_component[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select">
                                    <option selected value="null">None</option> 
                                        @foreach($location as $names)
                                            <option style="text-transform: capitalize" value="{{$names['location_no'] }}">{{$names['location_no']}}</option>
                                        @endforeach    
                                    </select>
                                </div>                      
                                <div class="col-sm-2 py-1">
                                    <input type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_output" name="last_output[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_fac" name="last_fac[]" placeholder="Factor">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" step=".0001" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_qty" name="last_qty[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input min="0" type="number" class="form-control py-2 yourclass yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_process" name="last_process[]" placeholder="%">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" class="form-control py-2 yourclass yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_total_con" name="last_total_con[]" placeholder="Total">
                                </div>
                                <div class="col-sm-1 py-1 text-center">
                                    <button type="button" class="btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>
                                </div>
                            </div>
                            @else
                            @foreach($LastingData as $data)
                            <div id="insolerow5{{$e1++}}" class="form-group row mb-2">
                                <div class="col-sm-2 py-1" style="display: inline-flex;">
                                    <span>
                                        <input id="last_item_code1" value="{{$data->item_code}}" style="border: 1px solid #bfbfbf;" type="text" name="last_item_code[]" class="form-control py-2" placeholder="Code">                                        
                                    </span>
                                    <span>
                                        <a data-toggle="modal" onclick="myFunction1('1', 'lasting')" data-id="1" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn_l ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                    </span>
                                </div>
                                <div class="col-sm-3 py-1">
                                    <input type="text" value="{{$data->description}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_description1" name="last_description[]" placeholder="Description">
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input type="text" value="{{$data->uom}}" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_uom1" name="last_uom[]" placeholder="Unit">
                                </div> 
                                <div class="col-sm-2 py-1">
                                    <select id="last_component" name="last_component[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select">
                                    <option selected value="null">None</option> 
                                        @foreach($location as $names)
                                            <option <?php if ($data->component == $names['location_no']) echo "selected"; ?> style="text-transform: capitalize" value="{{$names['location_no'] }}">{{$names['location_no']}}</option>
                                        @endforeach 
                                    </select>
                                </div>
                                <div class="col-sm-2 py-1">
                                    <input type="text" value="{{$data->output}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_output" name="last_output[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" step=".01" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_fac" name="last_fac[]" placeholder="Factor">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" value="{{$data->total_qty}}" step=".0001" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_qty" name="last_qty[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input min="0" type="number" value="{{$data->process}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_process" name="last_process[]" placeholder="%">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" value="{{$data->total}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_total_con" name="last_total_con[]" placeholder="Total">
                                </div>
                                <div class="col-sm-1 py-1 text-center">
                                    <button id="{{$e2++}}" type="button" class="removeRow5 btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            <div name="lasting">
                            </div>
                        </div>
                        <div class="form-group row mb-0 mt-5">
                            <div class="col-sm-2 text-center">
                                <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                    <label class="mb-0 text-white" style="font-weight: 600;">Packing</label>
                                </div>  
                            </div>
                            <div class="col-sm-9 text-center">
                            </div>
                            <div class="col-sm-1 text-center">
                                <button id="packing" type="button" class="btn btn-outline-primary btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                            </div>
                        </div>
                        <div id="packingrow">
                            @if(!$PackingData)
                            <div class="form-group row mb-2">
                                <div class="col-sm-2 py-1" style="display: inline-flex;">
                                    <span>
                                        <input id="p_item_code1" type="text" name="p_item_code[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 yourclass" placeholder="Code">                                        
                                    </span>
                                    <span>
                                        <a data-toggle="modal" onclick="myFunction1('1', 'packing')" data-id="1" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn_l ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                    </span>
                                </div>
                                <div class="col-sm-3 py-1">
                                    <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_description1" name="p_description[]" placeholder="Description">
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_uom1" name="p_uom[]" placeholder="Unit">
                                </div> 
                                <div class="col-sm-2 py-1">
                                    <select id="p_component" name="p_component[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select">
                                    <option selected value="null">None</option> 
                                        @foreach($location as $names)
                                            <option style="text-transform: capitalize" value="{{$names['location_no'] }}">{{$names['location_no']}}</option>
                                        @endforeach    
                                    </select>
                                </div>                      
                                <div class="col-sm-2 py-1">
                                    <input type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_output" name="p_output[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_fac" name="p_fac[]" placeholder="Factor">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" step=".0001" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_qty" name="p_qty[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input min="0" type="number" class="form-control py-2 yourclass yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_process" name="p_process[]" placeholder="%">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" class="form-control py-2 yourclass yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_total_con" name="p_total_con[]" placeholder="Total">
                                </div>
                                <div class="col-sm-1 py-1 text-center">
                                    <button type="button" class="btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>
                                </div>
                            </div>
                            @else
                            @foreach($PackingData as $data)
                            <div id="insolerow6{{$f1++}}" class="form-group row mb-2">
                                <div class="col-sm-2 py-1" style="display: inline-flex;">
                                    <span>
                                        <input id="p_item_code1" value="{{$data->item_code}}" style="border: 1px solid #bfbfbf;" type="text" name="p_item_code[]" class="form-control py-2" placeholder="Code">                                        
                                    </span>
                                    <span>
                                        <a data-toggle="modal" onclick="myFunction1('1', 'packing')" data-id="1" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn_l ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                    </span>
                                </div>
                                <div class="col-sm-3 py-1">
                                    <input type="text" value="{{$data->description}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_description1" name="p_description[]" placeholder="Description">
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input type="text" value="{{$data->uom}}" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_uom1" name="p_uom[]" placeholder="Unit">
                                </div> 
                                <div class="col-sm-2 py-1">
                                    <select id="p_component" name="p_component[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select">
                                    <option selected value="null">None</option> 
                                        @foreach($location as $names)
                                            <option <?php if ($data->component == $names['location_no']) echo "selected"; ?> style="text-transform: capitalize" value="{{$names['location_no'] }}">{{$names['location_no']}}</option>
                                        @endforeach 
                                    </select>
                                </div>          
                                <div class="col-sm-2 py-1">
                                    <input type="text" value="{{$data->output}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_output" name="p_output[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" step=".01" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_fac" name="p_fac[]" placeholder="Factor">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" value="{{$data->total_qty}}" step=".0001" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_qty" name="p_qty[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input min="0" type="number" value="{{$data->process}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_process" name="p_process[]" placeholder="%">
                                </div>
                                <div class="col-sm-1 py-1" hidden>
                                    <input min="0" type="number" value="{{$data->total}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_total_con" name="p_total_con[]" placeholder="Total">
                                </div>
                                <div class="col-sm-1 py-1 text-center">
                                    <button id="{{$f2++}}" type="button" class="removeRow6 btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            <div name="packing">
                            </div>
                        </div>
                        <br><br>
                        <div class="form-group row mt-5">
                            <div class="col-sm-3 mb-1 mb-sm-0">
                            </div>
                            <div class="col-sm-6">
                                <button type="submit" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white">Update</button>
                            </div>
                            <div class="col-sm-3">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="exampleModalLongTitle">Item Codes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input hidden type="text" id="counter">
                <input hidden type="text" id="name21">
                <table id="datatable2" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                     <thead>
                        <tr>
                            <th>No</th>
                            <th>Item Code</th>
                            <th>Item Description</th>
                            <th>Unit</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($itemcode as $num)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$num['ITEM_CODE']}}</td>
                            <td>{{$num['ITEM_DESC']}}</td>
                            <td>{{$num['UOM_DESC']}}</td>
                            <td><button class="btn btnSelect py-0 text-white" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;">Select</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="exampleModalCenter21" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="exampleModalLongTitle">Articles Code</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input hidden type="text" id="counter">
                <input hidden type="text" id="name21">
                <table id="datatable22" class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                     <thead>
                        <tr>
                            <th>No</th>
                            <th>Articles Code</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($articlecode as $value)
                        <tr>
                            <td>{{$j++}}</td>
                            <td>{{$value}}</td>
                            <td><button class="btn btnSelectArticle py-0 text-white" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;">Select</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/customjquery.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script>
$(document).ready(function(){ 
	$("#loader1").fadeOut(1200);
});
</script>
<script>
    $(document).on('click', '.removeRow1', function(){
        var id = $(this).attr("id"); 
        $('#insolerow1'+id+'').remove();
    });
    $(document).on('click', '.removeRow2', function(){
        var id = $(this).attr("id"); 
        $('#insolerow2'+id+'').remove();
    });
    $(document).on('click', '.removeRow3', function(){
        var id = $(this).attr("id"); 
        $('#insolerow3'+id+'').remove();
    });
    $(document).on('click', '.removeRow4', function(){
        var id = $(this).attr("id"); 
        $('#insolerow4'+id+'').remove();
    });
    $(document).on('click', '.removeRow5', function(){
        var id = $(this).attr("id"); 
        $('#insolerow5'+id+'').remove();
    });
    $(document).on('click', '.removeRow6', function(){
        var id = $(this).attr("id"); 
        $('#insolerow6'+id+'').remove();
    });
    $(document).on('click', '.removeRow7', function(){
        var id = $(this).attr("id"); 
        $('#insolerow7'+id+'').remove();
    });
</script>
<script>
$(document).ready(function(){
    $(".readonly").prop('readonly',true);
	$(".btnSelect").on('click',function(){
        var count = $("#counter").val();
        var name = $("#name21").val();
		var currentRow = $(this).closest("tr");
		var col2 = currentRow.find("td:eq(1)").html();
        $("#exampleModalCenter").modal('hide');
        if(name == "cutting"){
            $("#cut_item_code"+count).val(col2);
            code = document.getElementById('cut_item_code'+count).value;
        }
        else if(name == "insole"){
            $("#i_item_code"+count).val(col2);
            code = document.getElementById('i_item_code'+count).value;
        }
        else if(name == "lamination"){
            $("#lam_item_code"+count).val(col2);
            code = document.getElementById('lam_item_code'+count).value;
        }
        else if(name == "closing"){
            $("#clo_item_code"+count).val(col2);
            code = document.getElementById('clo_item_code'+count).value;
        }
        else if(name == "lasting"){
            $("#last_item_code"+count).val(col2);
            code = document.getElementById('last_item_code'+count).value;
        }
        else if(name == "packing"){
            $("#p_item_code"+count).val(col2);
            code = document.getElementById('p_item_code'+count).value;
        }
        console.log("Ajax");
        console.log(code);
        $.ajax({
            type: 'GET',
            url: 'itemcode/'+code,
            dataType: "json",
            success: function(data){
                if(name == "cutting"){
                    $("#cut_description"+count).val(data.desc);
                    $("#cut_uom"+count).val(data.uom);
                }
                else if(name == "insole"){
                    $("#i_description"+count).val(data.desc);
                    $("#i_uom"+count).val(data.uom);
                }
                else if(name == "lamination"){
                    $("#lam_description"+count).val(data.desc);
                    $("#lam_uom"+count).val(data.uom);
                }                
                else if(name == "closing"){
                    $("#clo_description"+count).val(data.desc);
                    $("#clo_uom"+count).val(data.uom);
                }                
                else if(name == "lasting"){
                    $("#last_description"+count).val(data.desc);
                    $("#last_uom"+count).val(data.uom);
                }                
                else if(name == "packing"){
                    $("#p_description"+count).val(data.desc);
                    $("#p_uom"+count).val(data.uom);
                }
            }
        });
	});
    $(".btnSelectArticle").on('click',function(){
        var currentRow = $(this).closest("tr");
		var col2 = currentRow.find("td:eq(1)").html();
        $("#article").val(col2);
        $("#exampleModalCenter21").modal('hide');
    });
});
</script>
<script src="assets/js/costingsheet.js"></script>
<script>
    $(".ModelBtn").click(function(){
        var id = $(this).attr("data-id");
        $("#counter").val(id);
    });
</script>
<script>
    function myFunction1(value,name12){
        console.log("Function");
        if(value == 1){
            $("#counter").val(value);
            $("#name21").val(name12);
        }
        else{
            $("#counter").val(value);
            $("#name21").val(name12.id);
        }
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
function autocomplete(inp, arr){
    var currentFocus;
    inp.addEventListener("input", function(e){
        var a, b, i, val = this.value;
        closeAllLists();
        if(!val){
            return false;
        }
        currentFocus = -1;
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        this.parentNode.appendChild(a);
        for(i=0; i<arr.length; i++){
            if(arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()){
                b = document.createElement("DIV");
                b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                b.innerHTML += arr[i].substr(val.length);
                b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                b.addEventListener("click", function(e) {
                    inp.value = this.getElementsByTagName("input")[0].value;
                    closeAllLists();
                });
            a.appendChild(b);
            }
        }
    });
    inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if(x) x = x.getElementsByTagName("div");
        if(e.keyCode == 40){
            currentFocus++;
            addActive(x);
        }
        else if(e.keyCode == 38){ 
            currentFocus--;
            addActive(x);
        }  
        else if(e.keyCode == 13){
            e.preventDefault();
            if(currentFocus > -1){
                if(x) x[currentFocus].click();
            }
        }
    });
    function addActive(x) {
        if(!x) return false;
        removeActive(x);
        if(currentFocus >= x.length) currentFocus = 0;
        if(currentFocus < 0) currentFocus = (x.length - 1);
        x[currentFocus].classList.add("autocomplete-active");
    }
    function removeActive(x){
        for(var i=0; i<x.length; i++){
            x[i].classList.remove("autocomplete-active");
        }
    }
    function closeAllLists(elmnt) {
        var x = document.getElementsByClassName("autocomplete-items");
        for(var i=0; i<x.length; i++){
            if(elmnt != x[i] && elmnt != inp){
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
}
</script>
<script>
    let username = document.getElementById('article')
    username.addEventListener("input", () => {
    Username(username.value);
    function Username(usernameVal){
        $.ajax({
                type: 'GET',
                url: 'ArticleCode/'+usernameVal,
                dataType: "json",
                success: function(data){
                    if(data){
                        autocomplete(document.getElementById("article"), data);
                    }
                }
            });
        }
    });
</script>
<script>
    $('#design').on('change', function(){
        var design = $(this).val();
        $("#description").val(design);
    });
    let strengthBadge2 = document.getElementById('StrengthDisp2')
    let strengthBadge3 = document.getElementById('StrengthDisp3')
    $("#selectsequence").on('click',function(){
        var first, seclast, istlast, range, rangefirst, project, projectfirst, category, categoryfirst, solefirst, shapefirst, seasonspace = 0;
        var season = $('#season').val();
        var range = $('#range').val();
        var category = $('#category').val();
        var sole = $('#sole').val();
        var shape = $('#shape').val();
        var project = $('#project').val();
        var sequence = $('#sequence').val();
        if(season!=null){
            first = season.charAt(0);
            seasonspace = season.split(' ').join('')
            seclast = season.charAt(season.length - 2);
            istlast = season.charAt(season.length - 1);
        }
        if(range!=null){
            rangefirst = range.charAt(0);
            rangefirst = rangefirst.toUpperCase();
        }
        if(category!=null){
            categoryfirst = category. slice(0, 3);
            categoryfirst = categoryfirst.toUpperCase();
        }
        if(shape!=null){
            shapefirst = shape. slice(0, 2);
            shapefirst = shapefirst.toUpperCase();
        }
        if(sole!=null){
            solefirst = sole. slice(0, 2);
            solefirst = solefirst.toUpperCase();
        }
        if(project!=null){
            projectfirst = project. slice(0, 3);
            projectfirst = projectfirst.toUpperCase();
        }
        if(season == null && range == null && category == null && shape == null && sole == null && project == null){
            strengthBadge3.style.display = 'block'
            strengthBadge3.style.backgroundColor = '#cd3f3f'
            strengthBadge3.textContent = 'Please Select Season, Range, Category, Shape, Sole, Project for Generate Design No'
            var timer;
            clearTimeout(timer);
            var self = $('#season');
            var range = $('#range');
            var category = $('#category');
            var sole = $('#sole');
            var shape = $('#shape');
            var project = $('#project');
            
            self.css('border-color', 'red');
            range.css('border-color', 'red');
            category.css('border-color', 'red');
            sole.css('border-color', 'red');
            shape.css('border-color', 'red');
            project.css('border-color', 'red');

            timer = setTimeout(function(){
                self.css('border-color', '#bfbfbf');
                range.css('border-color', '#bfbfbf');
                category.css('border-color', '#bfbfbf');
                sole.css('border-color', '#bfbfbf');
                shape.css('border-color', '#bfbfbf');
                project.css('border-color', '#bfbfbf');
            }, 4000);
        }
        else if(season == null){
            var timer;
            clearTimeout(timer);
            var self = $('#season');
            self.css('border-color', 'red');
            timer = setTimeout(function(){
                self.css('border-color', '#bfbfbf');
            }, 3000);
            strengthBadge2.style.display = 'block'
            strengthBadge2.style.backgroundColor = '#cd3f3f'
            strengthBadge2.textContent = 'Please Select Season'
        }
        else if(category == null){
            var timer;
            clearTimeout(timer);
            var self = $('#category');
            self.css('border-color', 'red');
            timer = setTimeout(function(){
                self.css('border-color', '#bfbfbf');
            }, 3000);
            strengthBadge2.style.display = 'block'
            strengthBadge2.style.backgroundColor = '#cd3f3f'
            strengthBadge2.textContent = 'Please Select Category'
        }
        else if(shape == null){
            var timer;
            clearTimeout(timer);
            var self = $('#shape');
            self.css('border-color', 'red');
            timer = setTimeout(function(){
                self.css('border-color', '#bfbfbf');
            }, 3000);
            strengthBadge2.style.display = 'block'
            strengthBadge2.style.backgroundColor = '#cd3f3f'
            strengthBadge2.textContent = 'Please Select Shape'
        }
        else if(sole == null){
            var timer;
            clearTimeout(timer);
            var self = $('#sole');
            self.css('border-color', 'red');
            timer = setTimeout(function(){
                self.css('border-color', '#bfbfbf');
            }, 3000);
            strengthBadge2.style.display = 'block'
            strengthBadge2.style.backgroundColor = '#cd3f3f'
            strengthBadge2.textContent = 'Please Select Category Sole'
        }
        else if(project == null){
            var timer;
            clearTimeout(timer);
            var self = $('#project');
            self.css('border-color', 'red');
            timer = setTimeout(function(){
                self.css('border-color', '#bfbfbf');
            }, 3000);
            strengthBadge2.style.display = 'block'
            strengthBadge2.style.backgroundColor = '#cd3f3f'
            strengthBadge2.textContent = 'Please Select Project'
        }
        else if(range == null){
            var timer;
            clearTimeout(timer);
            var self = $('#range');
            self.css('border-color', 'red');
            timer = setTimeout(function(){
                self.css('border-color', '#bfbfbf');
            }, 3000);
            strengthBadge2.style.display = 'block'
            strengthBadge2.style.backgroundColor = '#cd3f3f'
            strengthBadge2.textContent = 'Please Select Range'
        }
        else if(season && range && category && shape && sole && project){
            strengthBadge2.style.display = 'none'
            $("#design").val(first+seclast+istlast+"-"+rangefirst+"-"+projectfirst+"-"+categoryfirst+"-"+solefirst+"-"+shapefirst+"-"+sequence);
            $("#description").val(seasonspace+"-"+range+"-"+project+"-"+category+"-"+sole+"-"+shape+"-"+sequence);
        }
        $('#StrengthDisp2').delay(3000).fadeOut(600);
        $('#StrengthDisp3').delay(4000).fadeOut(600); 
    });
</script>
@endsection