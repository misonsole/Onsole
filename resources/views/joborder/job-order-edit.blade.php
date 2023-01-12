@extends( (Auth::user()->id == "2") ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<style>
    .dropify-wrapper 
    {
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
</style>
<div id="loader1" class="rotate" width="100" height="100"></div>
<div class="container-fluid px-5">
    <div class="row px-2">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('job-order-table')}}">Manage Job Order</a></li>
                        <li class="breadcrumb-item active">Edit Specification Sheet</li>
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
                    <form action="{{url('job-order-update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-2 mb-5">
                            <div class="col-sm-9 col-md-9 py-0">
                                <div class="form-group row py-0">
                                    <div class="col-sm-3 col-md-3 py-1">
                                        <label><b style="color: #6c757d">Season</b></label>
                                        <select id="season" name="season" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                            <option selected disabled>Select Season</option> 
                                            @foreach($season as $names)
                                                <option <?php if($names == $userseason) echo 'selected="selected"'; ?> value="{{ $names }}">{{ $names }}</option>
                                            @endforeach  
                                        </select>
                                    </div>
                                    <div class="col-sm-3 col-md-3 py-1" >
                                        <label><b style="color: #6c757d">Article Code</b></label>
                                        <input value="{{$article}}" id="article" type="text" name="article" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" placeholder="Search Item Code" required>
                                    </div>
                                    <div class="col-sm-2 col-md-2 py-1"> 
                                        <label><b style="color: #6c757d">Color</b></label>
                                        <select id="color" name="color" style="border: 1px solid #bfbfbf; text-transform: capitalize;" class="form-control select.custom-select" required>
                                            <option selected disabled>Select Color</option> 
                                            @foreach($color as $val)
                                                <option <?php if($val == $usercolor) echo 'selected="selected"'; ?> value="{{$val}}">{{$val}}</option>
                                            @endforeach  
                                        </select>
                                    </div>
                                    <div class="col-sm-4 col-md-4 py-1">
                                        <label><b style="color: #6c757d">Sequence No</b></label>
                                        <input value="{{$sequence}}" readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="sequence" name="sequence" placeholder="Enter Sequence No" required>
                                    </div>
                                </div>
                                <div class="form-group row py-0">
                                    <div class="col-sm-3 col-md-3 py-1">
                                        <label><b style="color: #6c757d">Sample No</b></label>
                                        <input type="text" name="id" value="{{$id}}" hidden>
                                        <input type="text" value="{{$usersample}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="sample" name="sample" placeholder="Enter Sample No" required>
                                    </div>
                                    <div class="col-sm-3 col-md-3 py-1">
                                        <label><b style="color: #6c757d">Prodcut No</b></label>
                                        <input type="text" value="{{$userproduct}}" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="product" name="product" placeholder="Enter Product No" required>
                                    </div>
                                    <div class="col-sm-2 col-md-2 py-1">
                                        <label><b style="color: #6c757d">Last</b></label>
                                        <select id="last" name="last" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                            <option selected disabled>Select Last Number</option> 
                                            @foreach($last as $num)
                                                <option <?php if($num == $userlast) echo 'selected="selected"'; ?> value="{{$num}}">{{$num}}</option>
                                            @endforeach  
                                        </select>
                                    </div>
                                    <div class="col-sm-4 col-md-4 py-1">
                                        <label><b style="color: #6c757d">Date & Time</b></label>
                                        <input type="text" value="{{$date}}" class="form-control yourclass" style="border: 1px solid #bfbfbf;" placeholder="Select Date & Time" id="mdate" name="date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 py-2">
                                <label><b style="color: #6c757d">Attachment</b></label><br>
                                @if(isset($image) && !empty($image)) 
                                <input type="file" name="image" id="input-file-now-custom-1" class="dropify" data-default-file="{{ asset('uploads/appsetting/' . $image) }}" required/>
                                @else
                                <input type="file" name="image" id="input-file-now-custom-1" class="dropify" data-default-file="img/photos/23.jpg" required/>
                                @endif  
                            </div>
                        </div>
                        <div class="form-group row text-center bg-dark py-1 mx-1" style="border-radius: 4px;">
                            <div class="col-sm-2 py-1 mt-1">
                            <label><b style="color: white">Material Code</b></label>
                            </div>
                            <div class="col-sm-3 py-1 mt-1">
                            <label><b style="color: white">Description</b></label>
                            </div>
                            <div class="col-sm-1 py-1 mt-1">
                            <label><b style="color: white">Type</b></label>
                            </div>
                            <div class="col-sm-1 py-1 mt-1">
                            <label><b style="color: white">Unit</b></label>
                            </div>
                            <div class="col-sm-1 py-1 mt-1">
                            <label><b style="color: white">Use</b></label>
                            </div>
                            <div class="col-sm-1 py-1 mt-1">
                            <label><b style="color: white">Tools</b></label>
                            </div>
                            <div class="col-sm-1 py-1 mt-1">
                            <label><b style="color: white">Code</b></label>
                            </div>
                            <div class="col-sm-1 py-1 mt-1">
                            <label><b style="color: white">Quantity</b></label>
                            </div>
                            <div class="col-sm-1 py-1 mt-1">
                            <label><b style="color: white">Action</b></label>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-sm-2 text-center">
                                <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                    <label class="mb-0 text-white" style="font-weight: 600;">Upper Materials</label>
                                </div>  
                            </div>
                            <div class="col-sm-9 text-center">
                            </div>
                            <div class="col-sm-1 text-center">
                                <button id="upper" type="button" class="btn btn-outline-primary btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                            </div>
                        </div>
                        <div id="upperrow">
                            @if(!$upperData)
                            <div class="form-group row mb-2">
                                <div class="col-sm-2 py-1" style="display: inline-flex;">
                                    <span>
                                        <input readonly id="u_item_code1" type="text" name="u_item_code[]" class="form-control py-2" placeholder="Code" required>                                        
                                    </span>
                                    <span>
                                        <a data-toggle="modal" onclick="myFunction1('1', 'upper')" data-id="1" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                    </span>
                                </div>
                                <div class="col-sm-3 py-1">
                                    <input readonly type="text" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="u_description1" name="u_description[]" placeholder="Enter Description" required>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="u_uom1" name="u_uom[]" placeholder="Unit">
                                </div> 
                                <div class="col-sm-1 py-1">
                                    <select id="u_type" name="u_type[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        <option value="Local">Local</option>                                        
                                        <option value="Imported">Imported</option>  
                                    </select>
                                </div>
                                <div class="col-sm-2 py-1">
                                    <select id="u_use" name="u_use[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        <option selected value="null">None</option>  
                                        @foreach($location as $value)
                                        <option value="{{ $value->location_no }}">{{ $value->location_no }}</option>
                                        @endforeach  
                                    </select>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <select id="u_tool" name="u_tool[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        <option value="null">None</option>    
                                        <option value="Laser">Laser</option>  
                                        <option value="Dye">Dye</option> 
                                    </select>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input type="number" step=".01" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="u_quantity" name="u_quantity[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1 text-center">
                                    <button id="upper" type="button" class="btn btn-outline-primary btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                                </div>
                            </div>
                            @else
                            @foreach($upperData as $data)
                            <div id="insolerow1{{$m++}}" class="form-group row mb-2">
                                <div class="col-sm-2 py-1" style="display: inline-flex;">
                                    <span>
                                        <input readonly id="u_item_code1" value="{{$data->item_code}}" type="text" name="u_item_code[]" class="form-control py-2" placeholder="Code" required>                                        
                                    </span>
                                    <span>
                                        <a data-toggle="modal" onclick="myFunction1('1', 'upper')" data-id="1" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                    </span>
                                </div>
                                <div class="col-sm-3 py-1">
                                    <input readonly type="text" value="{{$data->description}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="u_description1" name="u_description[]" placeholder="Enter Description" required>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input readonly type="text" value="{{$data->description}}" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="u_uom1" name="u_uom[]" placeholder="Unit">
                                </div> 
                                <div class="col-sm-1 py-1">
                                    <select id="u_type" name="u_type[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                    @if($data->type == 'Imported')
                                        <option selected value="Imported">Imported</option>
                                        <option value="Local">Local</option>   
                                    @else  
                                        <option selected value="Local">Local</option> 
                                        <option value="Imported">Imported</option>
                                    @endif
                                    </select>
                                </div>
                                <div class="col-sm-2 py-1">
                                    <select id="u_use" name="u_use[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        <option selected value="null">None</option>  
                                        @foreach($location as $value)
                                        <option <?php if ($data->usages == $value->location_no) echo "selected"; ?> value="{{ $value->location_no }}">{{ $value->location_no }}</option>
                                        @endforeach     
                                    </select>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <select id="u_tool" name="u_tool[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                    @if($data->type == 'Laser')
                                        <option selected value="Laser">Laser</option>  
                                        <option value="Dye">Dye</option>  
                                    @elseif($data->type == 'Dye')                              
                                        <option selected value="Dye">Dye</option>  
                                        <option value="Laser">Laser</option>  
                                    @else                           
                                        <option value="null">None</option>  
                                        <option value="Dye">Dye</option>  
                                        <option value="Laser">Laser</option>  
                                    @endif
                                    </select>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input type="number" step=".01" value="{{$data->quantity}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="u_quantity" name="u_quantity[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1 text-center">
                                    <button id="{{$n++}}" type="button" class="removeRow1 btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            <div name="upper">
                            </div>
                        </div>
                        <div class="form-group row mb-0 mt-5">
                            <div class="col-sm-2 text-center">
                                <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                    <label class="mb-0 text-white" style="font-weight: 600;">Linning Materials</label>
                                </div>  
                            </div>
                            <div class="col-sm-9 text-center">
                            </div>
                            <div class="col-sm-1 text-center">
                                <button id="linning" type="button" class="btn btn-outline-primary btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                            </div>
                        </div>
                        <div id="linningrow">
                            @if(!$linningData)
                            <div class="form-group row mb-2">
                                <div class="col-sm-2 py-1" style="display: inline-flex;">
                                    <span>
                                        <input readonly id="l_item_code1" type="text" name="l_item_code[]" class="form-control py-2" placeholder="Code">                                        
                                    </span>
                                    <span>
                                        <a data-toggle="modal" onclick="myFunction1('1', 'linning')" data-id="1" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn_l ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                    </span>
                                </div>
                                <div class="col-sm-3 py-1">
                                    <input readonly type="text" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="l_description1" name="l_description[]" placeholder="Job Order Sheet Customer Article">
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="l_uom1" name="l_uom[]" placeholder="Unit">
                                </div> 
                                <div class="col-sm-1 py-1">
                                    <select id="l_type" name="l_type[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select">
                                        <option value="Local">Local</option>                                        
                                        <option value="Imported">Imported</option>  
                                    </select>
                                </div>
                                <div class="col-sm-2 py-1">
                                    <select id="l_use" name="l_use[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select">
                                        <option selected value="null">None</option>                                           
                                        @foreach($location as $value)
                                        <option value="{{ $value->location_no }}">{{ $value->location_no }}</option>
                                        @endforeach  
                                    </select>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <select id="l_tool" name="l_tool[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select">
                                        <option value="null">None</option>     
                                        <option value="Laser">Laser</option>  
                                        <option value="Dye">Dye</option> 
                                    </select>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input type="number" step=".01" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="l_quantity" name="l_quantity[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1 text-center">
                                    <button style="cursor: not-allowed;" type="button" class="btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>
                                </div>
                            </div>
                            @else
                            @foreach($linningData as $data)
                            <div id="insolerow2{{$a1++}}" class="form-group row mb-2">
                                <div class="col-sm-2 py-1" style="display: inline-flex;">
                                    <span>
                                        <input readonly id="l_item_code1" value="{{$data->item_code}}" type="text" name="l_item_code[]" class="form-control py-2" placeholder="Code">                                        
                                    </span>
                                    <span>
                                        <a data-toggle="modal" onclick="myFunction1('1', 'linning')" data-id="1" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn_l ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                    </span>
                                </div>
                                <div class="col-sm-3 py-1">
                                    <input readonly type="text" value="{{$data->description}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="l_description1" name="l_description[]" placeholder="Job Order Sheet Customer Article">
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input readonly type="text" value="{{$data->uom}}" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="l_uom1" name="l_uom[]" placeholder="Unit">
                                </div> 
                                <div class="col-sm-1 py-1">
                                    <select id="l_type" name="l_type[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select">
                                        @if($data->type == 'Imported')
                                            <option selected value="Imported">Imported</option>
                                            <option value="Local">Local</option>   
                                        @else  
                                            <option selected value="Local">Local</option> 
                                            <option value="Imported">Imported</option>
                                        @endif 
                                    </select>
                                </div>
                                <div class="col-sm-2 py-1">
                                    <select id="l_use" name="l_use[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select">
                                        <option selected value="null">None</option>                                           
                                        @foreach($location as $value)
                                        <option <?php if ($data->usages == $value->location_no) echo "selected"; ?> value="{{ $value->location_no }}">{{ $value->location_no }}</option>
                                        @endforeach   
                                    </select>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <select id="l_tool" name="l_tool[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select">
                                        @if($data->type == 'Laser')
                                            <option selected value="Laser">Laser</option>  
                                            <option value="Dye">Dye</option>  
                                        @elseif($data->type == 'Dye')                              
                                            <option selected value="Dye">Dye</option>  
                                            <option value="Laser">Laser</option>  
                                        @else                           
                                            <option value="null">None</option>  
                                            <option value="Dye">Dye</option>  
                                            <option value="Laser">Laser</option>  
                                        @endif 
                                    </select>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input type="number" step=".01" value="{{$data->quantity}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="l_quantity" name="l_quantity[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1 text-center">
                                    <button id="{{$a2++}}" type="button" class="removeRow2 btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            <div name="linning">
                            </div>
                        </div>
                        <div class="form-group row mb-0 mt-5">
                            <div class="col-sm-2 text-center">
                                <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                    <label class="mb-0 text-white" style="font-weight: 600;">Stiching Materials</label>
                                </div>  
                            </div>
                            <div class="col-sm-9 text-center">
                            </div>
                            <div class="col-sm-1 text-center">
                                <button id="stiching" type="button" class="btn btn-outline-primary btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                            </div>
                        </div>
                        <div id="stichingrow">
                            @if(!$stichingData)
                            <div class="form-group row mb-2">
                                <div class="col-sm-2 py-1" style="display: inline-flex;">
                                    <span>
                                        <input readonly id="st_item_code1" type="text" name="st_item_code[]" class="form-control py-2" placeholder="Code" required>                                        
                                    </span>
                                    <span>
                                        <a data-toggle="modal" onclick="myFunction1('1', 'stiching')" data-id="1" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn_l ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                    </span>
                                </div>
                                <div class="col-sm-3 py-1">
                                    <input readonly type="text" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="st_description1" name="st_description[]" placeholder="Enter Description" required>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="st_uom1" name="st_uom[]" placeholder="Unit">
                                </div> 
                                <div class="col-sm-1 py-1">
                                    <select id="st_type" name="st_type[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        <option value="Local">Local</option>                                        
                                        <option value="Imported">Imported</option>    
                                    </select>
                                </div>
                                <div class="col-sm-2 py-1">
                                    <select id="st_use" name="st_use[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        <option selected value="null">None</option>                                           
                                        @foreach($location as $value)
                                        <option value="{{ $value->location_no }}">{{ $value->location_no }}</option>
                                        @endforeach 
                                    </select>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <select id="st_tool" name="st_tool[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        <option value="null">None</option>    
                                        <option value="Laser">Laser</option>  
                                        <option value="Dye">Dye</option> 
                                    </select>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input type="number" step=".01" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="st_quantity" name="st_quantity[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1 text-center">
                                    <button style="cursor: not-allowed;" type="button" class="btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>
                                </div>
                            </div>
                            @else
                            @foreach($stichingData as $data)
                            <div id="insolerow3{{$b1++}}" class="form-group row mb-2">
                                <div class="col-sm-2 py-1" style="display: inline-flex;">
                                    <span>
                                        <input readonly id="st_item_code1" value="{{$data->item_code}}" type="text" name="st_item_code[]" class="form-control py-2" placeholder="Code" required>                                        
                                    </span>
                                    <span>
                                        <a data-toggle="modal" onclick="myFunction1('1', 'stiching')" data-id="1" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn_l ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                    </span>
                                </div>
                                <div class="col-sm-3 py-1">
                                    <input readonly type="text"  value="{{$data->description}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="st_description1" name="st_description[]" placeholder="Enter Description" required>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input readonly type="text" value="{{$data->uom}}" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="st_uom1" name="st_uom[]" placeholder="Unit">
                                </div> 
                                <div class="col-sm-1 py-1">
                                    <select id="st_type" name="st_type[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        @if($data->type == 'Imported')
                                            <option selected value="Imported">Imported</option>
                                            <option value="Local">Local</option>   
                                        @else  
                                            <option selected value="Local">Local</option> 
                                            <option value="Imported">Imported</option>
                                        @endif 
                                    </select>
                                </div>
                                <div class="col-sm-2 py-1">
                                    <select id="st_use" name="st_use[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        <option selected value="null">None</option>                                            
                                        @foreach($location as $value)
                                        <option <?php if ($data->usages == $value->location_no) echo "selected"; ?> value="{{ $value->location_no }}">{{ $value->location_no }}</option>
                                        @endforeach  
                                    </select>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <select id="st_tool" name="st_tool[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required
                                        @if($data->type == 'Laser')
                                            <option selected value="Laser">Laser</option>  
                                            <option value="Dye">Dye</option>  
                                        @else                              
                                            <option selected value="Dye">Dye</option>  
                                            <option value="Laser">Laser</option>  
                                        @endif 
                                    </select>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input type="number" step=".01" value="{{$data->quantity}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="st_quantity" name="st_quantity[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1 text-center">
                                    <button id="{{$b2++}}" type="button" class="removeRow3 btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            <div name="stiching">
                            </div>
                        </div>
                        <div class="form-group row mb-0 mt-5">
                            <div class="col-sm-2 text-center">
                                <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                    <label class="mb-0 text-white" style="font-weight: 600;">Insole Materials</label>
                                </div>  
                            </div>
                            <div class="col-sm-9 text-center">
                            </div>
                            <div class="col-sm-1 text-center">
                                <button id="insole" type="button" class="btn btn-outline-primary btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                            </div>
                        </div>
                        <div id="insolerow">
                            @if(!$insoleData)
                            <div class="form-group row mb-2">
                                <div class="col-sm-2 py-1" style="display: inline-flex;">
                                    <span>
                                        <input readonly id="i_item_code1" type="text" name="i_item_code[]" class="form-control py-2" placeholder="Code" required>                                        
                                    </span>
                                    <span>
                                        <a data-toggle="modal" onclick="myFunction1('1', 'insole')" data-id="1" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn_l ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                    </span>
                                </div>
                                <div class="col-sm-3 py-1">
                                    <input readonly type="text" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_description1" name="i_description[]" placeholder="Enter Description" required>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_uom1" name="i_uom[]" placeholder="Unit">
                                </div> 
                                <div class="col-sm-1 py-1">
                                    <select id="i_type" name="i_type[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        <option value="Local">Local</option>                                        
                                        <option value="Imported">Imported</option>     
                                    </select>
                                </div>
                                <div class="col-sm-2 py-1">
                                    <select id="i_use" name="i_use[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        <option selected value="null">None</option>                                            
                                        @foreach($location as $value)
                                        <option value="{{ $value->location_no }}">{{ $value->location_no }}</option>
                                        @endforeach 
                                    </select>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <select id="i_tool" name="i_tool[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        <option value="null">None</option>     
                                        <option value="Laser">Laser</option>  
                                        <option value="Dye">Dye</option> 
                                    </select>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input type="number" step=".01" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_quantity" name="i_quantity[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1 text-center">
                                    <button style="cursor: not-allowed;" type="button" class="btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>
                                </div>
                            </div>
                            @else
                            @foreach($insoleData as $data)
                            <div id="insolerow4{{$c1++}}" class="form-group row mb-2">
                                <div class="col-sm-2 py-1" style="display: inline-flex;">
                                    <span>
                                        <input readonly id="i_item_code1" value="{{$data->item_code}}"  type="text" name="i_item_code[]" class="form-control py-2" placeholder="Code" required>                                        
                                    </span>
                                    <span>
                                        <a data-toggle="modal" onclick="myFunction1('1', 'insole')" data-id="1" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn_l ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                    </span>
                                </div>
                                <div class="col-sm-3 py-1">
                                    <input readonly type="text" value="{{$data->description}}"  class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_description1" name="i_description[]" placeholder="Enter Description" required>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input readonly type="text" value="{{$data->uom}}" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_uom1" name="i_uom[]" placeholder="Unit">
                                </div> 
                                <div class="col-sm-1 py-1">
                                    <select id="i_type" name="i_type[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        @if($data->type == 'Imported')
                                            <option selected value="Imported">Imported</option>
                                            <option value="Local">Local</option>   
                                        @else  
                                            <option selected value="Local">Local</option> 
                                            <option value="Imported">Imported</option>
                                        @endif    
                                    </select>
                                </div>
                                <div class="col-sm-2 py-1">
                                    <select id="i_use" name="i_use[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        <option selected value="null">None</option>                                           
                                        @foreach($location as $value)
                                        <option <?php if ($data->usages == $value->location_no) echo "selected"; ?> value="{{ $value->location_no }}">{{ $value->location_no }}</option>
                                        @endforeach   
                                    </select>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <select id="i_tool" name="i_tool[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        @if($data->type == 'Laser')
                                            <option selected value="Laser">Laser</option>  
                                            <option value="Dye">Dye</option>  
                                        @elseif($data->type == 'Dye')                              
                                            <option selected value="Dye">Dye</option>  
                                            <option value="Laser">Laser</option>  
                                        @else                           
                                            <option value="null">None</option>  
                                            <option value="Dye">Dye</option>  
                                            <option value="Laser">Laser</option>  
                                        @endif  
                                    </select>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input type="number" step=".01" value="{{$data->quantity}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_quantity" name="i_quantity[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1 text-center">
                                    <button id="{{$c2++}}" type="button" class="removeRow4 btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>
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
                                    <label class="mb-0 text-white" style="font-weight: 600;">Outsole Materials</label>
                                </div>  
                            </div>
                            <div class="col-sm-9 text-center">
                            </div>
                            <div class="col-sm-1 text-center">
                                <button id="outsole" type="button" class="btn btn-outline-primary btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                            </div>
                        </div>
                        <div id="outsolerow">
                            @if(!$outsoleData)
                            <div class="form-group row mb-2">
                                <div class="col-sm-2 py-1" style="display: inline-flex;">
                                    <span>
                                        <input readonly id="o_item_code1" type="text" name="o_item_code[]" class="form-control py-2" placeholder="Code" required>                                        
                                    </span>
                                    <span>
                                        <a data-toggle="modal" onclick="myFunction1('1', 'outsole')" data-id="1" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn_l ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                    </span>
                                </div>
                                <div class="col-sm-3 py-1">
                                    <input readonly type="text" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="o_description1" name="o_description[]" placeholder="Enter Description" required>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="o_uom1" name="o_uom[]" placeholder="Unit">
                                </div> 
                                <div class="col-sm-1 py-1">
                                    <select id="o_type" name="o_type[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        <option value="Local">Local</option>                                        
                                        <option value="Imported">Imported</option>     
                                    </select>
                                </div>
                                <div class="col-sm-2 py-1">
                                    <select id="o_use" name="o_use[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        <option selected value="null">None</option>                                           
                                        @foreach($location as $value)
                                        <option value="{{ $value->location_no }}">{{ $value->location_no }}</option>
                                        @endforeach 
                                    </select>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <select id="o_tool" name="o_tool[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        <option value="null">None</option>    
                                        <option value="Laser">Laser</option>  
                                        <option value="Dye">Dye</option>    
                                    </select>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input type="number" step=".01" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="o_quantity" name="o_quantity[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1 text-center">
                                    <button style="cursor: not-allowed;" type="button" class="btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>
                                </div>
                            </div>
                            @else
                            @foreach($outsoleData as $data)
                            <div id="insolerow5{{$d1++}}" class="form-group row mb-2">
                                <div class="col-sm-2 py-1" style="display: inline-flex;">
                                    <span>
                                        <input readonly id="o_item_code1" type="text" value="{{$data->item_code}}" name="o_item_code[]" class="form-control py-2" placeholder="Code" required>                                        
                                    </span>
                                    <span>
                                        <a data-toggle="modal" onclick="myFunction1('1', 'outsole')" data-id="1" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn_l ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                    </span>
                                </div>
                                <div class="col-sm-3 py-1">
                                    <input readonly type="text" value="{{$data->description}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="o_description1" name="o_description[]" placeholder="Enter Description" required>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input readonly type="text" value="{{$data->uom}}" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="o_uom1" name="o_uom[]" placeholder="Unit">
                                </div> 
                                <div class="col-sm-1 py-1">
                                    <select id="o_type" name="o_type[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        @if($data->type == 'Imported')
                                            <option selected value="Imported">Imported</option>
                                            <option value="Local">Local</option>   
                                        @else  
                                            <option selected value="Local">Local</option> 
                                            <option value="Imported">Imported</option>
                                        @endif   
                                    </select>
                                </div>
                                <div class="col-sm-2 py-1">
                                    <select id="o_use" name="o_use[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        <option selected value="null">None</option>                                            
                                        @foreach($location as $value)
                                        <option <?php if ($data->usages == $value->location_no) echo "selected"; ?> value="{{ $value->location_no }}">{{ $value->location_no }}</option>
                                        @endforeach 
                                    </select>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <select id="o_tool" name="o_tool[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        @if($data->type == 'Laser')
                                            <option selected value="Laser">Laser</option>  
                                            <option value="Dye">Dye</option>  
                                        @elseif($data->type == 'Dye')                              
                                            <option selected value="Dye">Dye</option>  
                                            <option value="Laser">Laser</option>  
                                        @else                           
                                            <option value="null">None</option>  
                                            <option value="Dye">Dye</option>  
                                            <option value="Laser">Laser</option>  
                                        @endif  
                                    </select>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input type="number" step=".01" value="{{$data->quantity}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="o_quantity" name="o_quantity[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1 text-center">
                                    <button id="{{$d2++}}" type="button" class="removeRow5 btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            <div name="outsole">
                            </div>
                        </div>
                        <div class="form-group row mb-0 mt-5">
                            <div class="col-sm-2 text-center">
                                <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                    <label class="mb-0 text-white" style="font-weight: 600;">Socks Stamp</label>
                                </div>  
                            </div>
                            <div class="col-sm-9 text-center">
                            </div>
                            <div class="col-sm-1 text-center">
                                <button id="socks" type="button" class="btn btn-outline-primary btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                            </div>
                        </div>                        
                        <div id="socksrow">
                            @if(!$socksData)
                            <div class="form-group row mb-2">
                                <div class="col-sm-2 py-1" style="display: inline-flex;">
                                    <span>
                                        <input readonly id="s_item_code1" type="text" name="s_item_code[]" class="form-control py-2" placeholder="Code" required>                                        
                                    </span>
                                    <span>
                                        <a data-toggle="modal" onclick="myFunction1('1', 'socks')" data-id="1" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn_l ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                    </span>
                                </div>
                                <div class="col-sm-3 py-1">
                                    <input readonly type="text" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="s_description1" name="s_description[]" placeholder="Enter Description" required>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="s_uom1" name="s_uom[]" placeholder="Unit">
                                </div> 
                                <div class="col-sm-1 py-1">
                                    <select id="s_type" name="s_type[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        <option value="Local">Local</option>                                        
                                        <option value="Imported">Imported</option>     
                                    </select>
                                </div>
                                <div class="col-sm-2 py-1">
                                    <select id="s_use" name="s_use[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        <option selected value="null">None</option>                                           
                                        @foreach($location as $value)
                                        <option value="{{ $value->location_no }}">{{ $value->location_no }}</option>
                                        @endforeach 
                                    </select>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <select id="s_tool" name="s_tool[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        <option value="null">None</option>     
                                        <option value="Laser">Laser</option>  
                                        <option value="Dye">Dye</option> 
                                    </select>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input type="number" step=".01" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="s_quantity" name="s_quantity[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1 text-center">
                                    <button style="cursor: not-allowed;" type="button" class="btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>
                                </div>
                            </div>
                            @else
                            @foreach($socksData as $data)
                            <div id="insolerow6{{$e1++}}" class="form-group row mb-2">
                                <div class="col-sm-2 py-1" style="display: inline-flex;">
                                    <span>
                                        <input readonly id="s_item_code1" value="{{$data->item_code}}" type="text" name="s_item_code[]" class="form-control py-2" placeholder="Code" required>                                        
                                    </span>
                                    <span>
                                        <a data-toggle="modal" onclick="myFunction1('1', 'socks')" data-id="1" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn_l ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                    </span>
                                </div>
                                <div class="col-sm-3 py-1">
                                    <input readonly type="text" value="{{$data->description}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="s_description1" name="s_description[]" placeholder="Enter Description" required>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input readonly type="text" value="{{$data->uom}}" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="s_uom1" name="s_uom[]" placeholder="Unit">
                                </div> 
                                <div class="col-sm-1 py-1">
                                    <select id="s_type" name="s_type[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        @if($data->type == 'Imported')
                                            <option selected value="Imported">Imported</option>
                                            <option value="Local">Local</option>   
                                        @else  
                                            <option selected value="Local">Local</option> 
                                            <option value="Imported">Imported</option>
                                        @endif   
                                    </select>
                                </div>
                                <div class="col-sm-2 py-1">
                                    <select id="s_use" name="s_use[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        <option selected value="null">None</option>                                          
                                        @foreach($location as $value)
                                        <option <?php if ($data->usages == $value->location_no) echo "selected"; ?> value="{{ $value->location_no }}">{{ $value->location_no }}</option>
                                        @endforeach  
                                    </select>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <select id="s_tool" name="s_tool[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        @if($data->type == 'Laser')
                                            <option selected value="Laser">Laser</option>  
                                            <option value="Dye">Dye</option>  
                                        @elseif($data->type == 'Dye')                              
                                            <option selected value="Dye">Dye</option>  
                                            <option value="Laser">Laser</option>  
                                        @else                           
                                            <option value="null">None</option>  
                                            <option value="Dye">Dye</option>  
                                            <option value="Laser">Laser</option>  
                                        @endif  
                                    </select>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input type="number" step=".01" value="{{$data->quantity}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="s_quantity" name="s_quantity[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1 text-center">
                                    <button id="{{$e2++}}" type="button" class="removeRow6 btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            <div name="socks">
                            </div>
                        </div>
                        <div class="form-group row mb-0 mt-5">
                            <div class="col-sm-2 text-center">
                                <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                    <label class="mb-0 text-white" style="font-weight: 600;">General items</label>
                                </div>  
                            </div>
                            <div class="col-sm-9 text-center">
                            </div>
                            <div class="col-sm-1 text-center">
                                <button id="genral" type="button" class="btn btn-outline-primary btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                            </div>
                        </div>                        
                        <div id="genralrow">
                            @if(!$generalData)
                            <div class="form-group row mb-2">
                                <div class="col-sm-2 py-1" style="display: inline-flex;">
                                    <span>
                                        <input readonly id="g_item_code1" type="text" name="g_item_code[]" class="form-control py-2" placeholder="Code" required>                                        
                                    </span>
                                    <span>
                                        <a data-toggle="modal" onclick="myFunction1('1', 'genral')" data-id="1" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn_l ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                    </span>
                                </div>
                                <div class="col-sm-3 py-1">
                                    <input readonly type="text" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="g_description1" name="g_description[]" placeholder="Enter Description" required>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="g_uom1" name="g_uom[]" placeholder="Unit">
                                </div> 
                                <div class="col-sm-1 py-1">
                                    <select id="g_type" name="g_type[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        <option value="Local">Local</option>                                        
                                        <option value="Imported">Imported</option>     
                                    </select>
                                </div>
                                <div class="col-sm-2 py-1">
                                    <select id="g_use" name="g_use[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        <option selected value="null">None</option>                                           
                                        @foreach($location as $value)
                                        <option value="{{ $value->location_no }}">{{ $value->location_no }}</option>
                                        @endforeach 
                                    </select>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <select id="g_tool" name="g_tool[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        <option value="null">None</option>     
                                        <option value="Laser">Laser</option>  
                                        <option value="Dye">Dye</option>   
                                    </select>
                                </div>
                                <div class="col-sm-1 py-1">
                                    <input type="number" step=".01" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="g_quantity" name="g_quantity[]" placeholder="Quantity">
                                </div>
                                <div class="col-sm-1 py-1 text-center">
                                    <button style="cursor: not-allowed;" type="button" class="btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>
                                </div>
                            </div>
                            @else
                            @foreach($generalData as $data)
                            <div id="genralrow">
                                <div id="insolerow7{{$f1++}}" class="form-group row mb-2">
                                    <div class="col-sm-2 py-1" style="display: inline-flex;">
                                        <span>
                                            <input readonly id="g_item_code1" value="{{$data->item_code}}" type="text" name="g_item_code[]" class="form-control py-2" placeholder="Code" required>                                        
                                        </span>
                                        <span>
                                            <a data-toggle="modal" onclick="myFunction1('1', 'genral')" data-id="1" data-target="#exampleModalCenter" style="font-size: small; cursor: pointer; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important; border: none;" class="btn text-white ModelBtn_l ml-2 py-0 px-2"><i style="font-size: 20px;" class="mdi mdi-progress-upload"></i></a>                                        
                                        </span>
                                    </div>
                                    <div class="col-sm-3 py-1">
                                        <input readonly type="text" value="{{$data->description}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="g_description1" name="g_description[]" placeholder="Enter Description">
                                    </div>
                                    <div class="col-sm-1 py-1">
                                        <input value="{{$data->uom}}" readonly type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="g_uom1" name="g_uom[]" placeholder="Unit">
                                    </div> 
                                    <div class="col-sm-1 py-1">
                                        <select id="g_type" name="g_type[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                            @if($data->type == 'Imported')
                                                <option selected value="Imported">Imported</option>
                                                <option value="Local">Local</option>   
                                            @else  
                                                <option selected value="Local">Local</option> 
                                                <option value="Imported">Imported</option>
                                            @endif  
                                        </select>
                                    </div>
                                    <div class="col-sm-2 py-1">
                                        <select id="g_use" name="g_use[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                            <option selected value="null">None</option>                                           
                                            @foreach($location as $value)
                                            <option <?php if ($data->usages == $value->location_no) echo "selected"; ?> value="{{ $value->location_no }}">{{ $value->location_no }}</option>
                                            @endforeach  
                                        </select>
                                    </div>
                                    <div class="col-sm-1 py-1">
                                        <select id="g_tool" name="g_tool[]" style="border: 1px solid #bfbfbf; text-transform: capitalize" class="form-control select.custom-select" required>
                                        @if($data->type == 'Laser')
                                            <option selected value="Laser">Laser</option>  
                                            <option value="Dye">Dye</option>  
                                        @elseif($data->type == 'Dye')                              
                                            <option selected value="Dye">Dye</option>  
                                            <option value="Laser">Laser</option>  
                                        @else                           
                                            <option value="null">None</option>  
                                            <option value="Dye">Dye</option>  
                                            <option value="Laser">Laser</option>  
                                        @endif  
                                        </select>
                                    </div>
                                    <div class="col-sm-1 py-1">
                                        <input type="number" step=".01" value="{{$data->quantity}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="g_quantity" name="g_quantity[]" placeholder="Quantity">
                                    </div>
                                    <div class="col-sm-1 py-1 text-center">
                                        <button id="{{$f2++}}" type="button" class="removeRow7 btn btn-outline-danger btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-minus"></i></button>
                                    </div>
                                </div>
                                <div name="genral">
                                </div>
                            </div>
                            @endforeach
                            @endif
                            <div name="genral">
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
	$(".btnSelect").on('click',function(){
        var count = $("#counter").val();
        var name = $("#name21").val();
		var currentRow = $(this).closest("tr");
		var col2 = currentRow.find("td:eq(1)").html();
        $("#exampleModalCenter").modal('hide');
        if(name == "upper"){
            $("#u_item_code"+count).val(col2);
            code = document.getElementById('u_item_code'+count).value;
        }
        else if(name == "linning"){
            $("#l_item_code"+count).val(col2);
            code = document.getElementById('l_item_code'+count).value;
        }
        else if(name == "stiching"){
            $("#st_item_code"+count).val(col2);
            code = document.getElementById('st_item_code'+count).value;
        }
        else if(name == "insole"){
            $("#i_item_code"+count).val(col2);
            code = document.getElementById('i_item_code'+count).value;
        }
        else if(name == "outsole"){
            $("#o_item_code"+count).val(col2);
            code = document.getElementById('o_item_code'+count).value;
        }
        else if(name == "socks"){
            $("#s_item_code"+count).val(col2);
            code = document.getElementById('s_item_code'+count).value;
        }
        else if(name == "genral"){
            $("#g_item_code"+count).val(col2);
            code = document.getElementById('g_item_code'+count).value;
        }
        $.ajax({
            type: 'GET',
            url: 'itemcode/'+code,
            dataType: "json",
            success: function(data){
                console.log(data);
                if(name == "upper"){
                    $("#u_description"+count).val(data.desc);
                    $("#u_uom"+count).val(data.uom);
                }
                else if(name == "linning"){
                    $("#l_description"+count).val(data.desc);
                    $("#l_uom"+count).val(data.uom);
                }
                else if(name == "stiching"){
                    $("#st_description"+count).val(data.desc);
                    $("#st_uom"+count).val(data.uom);
                }
                else if(name == "insole"){
                    $("#i_description"+count).val(data.desc);
                    $("#i_uom"+count).val(data.uom);
                }
                else if(name == "outsole"){
                    $("#o_description"+count).val(data.desc);
                    $("#o_uom"+count).val(data.uom);
                }
                else if(name == "socks"){
                    $("#s_description"+count).val(data.desc);
                    $("#s_uom"+count).val(data.uom);
                }
                else if(name == "genral"){
                    $("#g_description"+count).val(data.desc);
                    $("#g_uom"+count).val(data.uom);
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
<script src="assets/js/joborder.js"></script>
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
    $('#season').on('change', function(){
        var season = $(this).val();
        const first = season.charAt(0);
        const seclast = season.charAt(season.length - 2);
        const istlast = season.charAt(season.length - 1);
        var date1 = $("#sequence").val();
        var n = date1.slice(5);
        $("#sequence").val(first+"-"+seclast+istlast+"/"+n);
    });
    $('#article').on('change', function(){
        var article = $(this).val();
    });
    let strengthBadge2 = document.getElementById('StrengthDisp2')
    $("#selectsequence").on('click',function(){
                    var article1 = 0;
                    article1 = $('#article').val();
                    var season = $('#season').val();
                    if(season == null && article1 == 0){
                        strengthBadge2.style.display = 'block'
                        strengthBadge2.style.backgroundColor = '#cd3f3f'
                        strengthBadge2.textContent = 'Please Select Season & Article Code'
                    }
                    else if(season == null){
                        strengthBadge2.style.display = 'block'
                        strengthBadge2.style.backgroundColor = '#cd3f3f'
                        strengthBadge2.textContent = 'Please Select Season'
                    }
                    else if(article1 == 0){
                        strengthBadge2.style.display = 'block'
                        strengthBadge2.style.backgroundColor = '#cd3f3f'
                        strengthBadge2.textContent = 'Please Select Article Code'
                    }
                    else if(season && article1){
                        strengthBadge2.style.display = 'none'
                        // $("#sequence").val(season+"-"+article1);
                    }
                });
</script>
@endsection