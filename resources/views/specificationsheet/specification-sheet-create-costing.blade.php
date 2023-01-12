@extends( (Auth::user()->id == "2") ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<style>
    .dropify-wrapper 
    {
        height: 130px;
        margin-bottom: 2%;
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
                        <li class="breadcrumb-item active" style="font-family: 'Poppins', sans-serif;">Create Specification Sheet</li>
                    </ol>
                </div>
                <h4 class="page-title">Create Specification Sheet</h4>
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-lg-12 mb-5">
            <div class="card">
                <div class="card-body p-5">
                    <ul class="nav nav-pills nav-justified" role="tablist">
                        @if($userprogress === '75' && $userprogress != '80')
                        <li class="nav-item waves-effect waves-light" style="border-radius: 16px; background: transparent;">
                            @if($userprogress != '75')
                                <a class="nav-link" data-toggle="tab" href="#home-1" role="tab">Materials</a>
                            @else
                                <a class="nav-link active" data-toggle="tab" href="#home-1" role="tab">Materials</a>
                            @endif
                        </li>
                        @endif
                        @if($userprogress === '80' || $userprogress != '85')
                        <li class="nav-item waves-effect waves-light" style="border-radius: 16px; background: transparent;"> 
                            @if($userprogress != '80')
                                <a class="nav-link" data-toggle="tab" href="#profile-1" role="tab">Resources</a>
                            @else
                                <a class="nav-link active" data-toggle="tab" href="#profile-1" role="tab">Resources</a>
                            @endif
                        </li>
                        @endif
                        @if($userprogress === '85' || $userprogress != '90')
                        <li class="nav-item waves-effect waves-light" style="border-radius: 16px; background: transparent;">
                            @if($userprogress != '85')
                                <a class="nav-link" data-toggle="tab" href="#settings-1" role="tab">Overheads</a>
                            @else
                                <a class="nav-link active" data-toggle="tab" href="#settings-1" role="tab">Overheads</a>
                            @endif
                        </li>
                        @endif
                    </ul>
                    <div class="tab-content">
                        @if($userprogress === '75' && $userprogress != '80')
                        <div class="tab-pane p-3 active" id="home-1" role="tabpanel">
                        @else
                        <div class="tab-pane p-3" id="home-1" role="tabpanel">
                        @endif
                            <form action="{{url('specification-sheet-update-material')}}" method="post" enctype="multipart/form-data">
                            @csrf
                                <div class="form-group row py-2 mb-5 mt-5">
                                    <div class="col-sm-9 col-md-9 py-0">
                                        <div class="form-group row py-0">
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <input type="text" name="id" value="{{$id}}" hidden>
                                                <label><b style="color: #6c757d">Season</b></label>                                            
                                                <input value="{{$userseason}}" id="season" name="season" type="text" class="form-control yourclass readonly" style="border: 1px solid #bfbfbf;">
                                            </div>
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <label><b style="color: #6c757d">Category</b></label>
                                                <input value="{{$usercategory}}" id="category" name="category" type="text" class="form-control yourclass readonly" style="border: 1px solid #bfbfbf;">
                                            </div>
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <label><b style="color: #6c757d">Shape</b></label>
                                                <input value="{{$usershape}}" id="shape" name="shape" type="text" class="form-control yourclass readonly" style="border: 1px solid #bfbfbf;">
                                            </div>
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <label><b style="color: #6c757d">Sole</b></label>
                                                <input value="{{$usersole}}" id="sole" name="sole" type="text" class="form-control yourclass readonly" style="border: 1px solid #bfbfbf;">
                                            </div>
                                        </div>
                                        <div class="form-group row py-0">
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <label><b style="color: #6c757d">Project</b></label>
                                                <input value="{{$userproject}}" id="project" name="project" type="text" class="form-control yourclass readonly" style="border: 1px solid #bfbfbf;">
                                            </div>
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <label><b style="color: #6c757d">Range</b></label>
                                                <input value="{{$userrange}}" id="range" name="range" type="text" class="form-control yourclass readonly" style="border: 1px solid #bfbfbf;">
                                            </div>
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <label><b style="color: #6c757d">Design No</b></label>
                                                <input value="{{$userdesign}}" type="text" class="form-control py-2 yourclass readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="design" name="design" placeholder="Design No" required>
                                            </div>
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <label><b style="color: #6c757d">Sequence</b></label>
                                                <input value="{{$sequence}}" id="sequence" name="sequence" type="text" class="form-control yourclass readonly" style="border: 1px solid #bfbfbf;">
                                            </div>
                                        </div>
                                        <div class="form-group row py-0">
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <label><b style="color: #6c757d">Purpose</b></label>
                                                <input value="{{$userpurpose}}" id="purpose" name="purpose" type="text" class="form-control yourclass readonly" style="border: 1px solid #bfbfbf;">
                                            </div>
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <label><b style="color: #6c757d">Product</b></label>
                                                <input value="{{$userproduct}}" id="product" name="product" type="text" class="form-control yourclass readonly" style="border: 1px solid #bfbfbf;" placeholder="Product Name">
                                            </div>
                                            <div class="col-sm-6 col-md-6 py-1">
                                                <label><b style="color: #6c757d">Design Description</b></label>
                                                <input value="{{$userdescription}}" type="text" class="form-control py-2 yourclass readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="description" name="description" placeholder="Design Description" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 py-1">
                                        <label><b style="color: #6c757d">Attachment</b></label><br>
                                        @if(isset($image) && !empty($image)) 
                                        <input type="file" name="image" id="input-file-now-custom-1" class="dropify" data-default-file="{{ asset('uploads/appsetting/' . $image) }}"/>
                                        @else
                                        <input type="file" name="image" id="input-file-now-custom-1" class="dropify" data-default-file="img/photos/23.jpg" required/>
                                        @endif  
                                        <br>
                                        <label class="mt-1"><b style="color: #6c757d">Date</b></label>
                                        <input value="{{$date}}" type="text" class="form-control yourclass readonly" style="border: 1px solid #bfbfbf;" placeholder="Select Date" name="date">
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
                                    <div class="col-sm-1 py-1">
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
                                    <div class="col-sm-1 py-1">
                                        <label class="mb-0"><b style="color: white; font-weight: 500;">Total Consumption</b></label>
                                    </div>
                                    <div class="col-sm-1 py-1">
                                        <label class="mb-0"><b style="color: white; font-weight: 500;">Rate/Pair</b></label>
                                    </div>
                                </div>
                                @if(!$cuttingData)
                                @else
                                <div class="form-group row mb-0">
                                    <div class="col-sm-1 text-center">
                                        <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                            <label class="mb-0 text-white" style="font-weight: 600;">Cutting</label>
                                        </div>  
                                    </div>
                                    <div class="col-sm-10 text-center">
                                    </div>
                                    <div class="col-sm-1 text-center">
                                    </div>
                                </div>
                                @endif
                                <div id="cuttingrow">
                                    @if(!$cuttingData)
                                    @else
                                    @foreach($cuttingData as $data)
                                    <div id="insolerow1{{$a1++}}" class="form-group row mb-2">
                                        <div class="col-sm-2 py-1" style="display: inline-flex;">
                                            <input id="cut_item_code1" value="{{$data->item_code}}" type="text" name="cut_item_code[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code" required>                                        
                                        </div>
                                        <div class="col-sm-3 py-1">
                                            <input type="text" value="{{$data->description}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_description1" name="cut_description[]" placeholder="Description" required>
                                            <input hidden type="text" value="{{$data->id}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_id" name="cut_id[{{$data->id}}]" placeholder="Description" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input type="text" value="{{$data->uom}}" class="form-control py-2 yourclass readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_uom1" name="cut_uom[]" placeholder="Unit">
                                        </div>                               
                                        <div class="col-sm-2 py-1">
                                            <input id="cut_component" value="{{$data->component}}" type="text" name="cut_component[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input value="{{$data->output}}" type="text" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_output" name="cut_output[]" placeholder="Quantity">
                                        </div>
                                        <div class="col-sm-1 py-1" hidden>
                                            <input min="0" value="{{$data->fac_qty}}" type="number" step=".01" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_fac" name="cut_fac[]" placeholder="Factor">
                                        </div>
                                        <div class="col-sm-1 py-1" hidden>
                                            <input min="0" value="{{$data->total_qty}}" type="number" step=".01" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_qty" name="cut_qty[]" placeholder="Quantity">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input min="0" value="{{$data->process}}" type="number" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_process" name="cut_process[]" placeholder="%">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input min="0" value="{{$data->total}}" type="number" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_total_con" name="cut_total_con[]" placeholder="Total">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input min="0" value="{{$data->rate}}" type="number" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_rate" name="cut_rate[]" placeholder="Rate" required>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                                @if(!$InsoleData)
                                @else
                                <div class="form-group row mb-0 mt-5">
                                    <div class="col-sm-1 text-center">
                                        <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                            <label class="mb-0 text-white" style="font-weight: 600;">INSOLE</label>
                                        </div>  
                                    </div>
                                    <div class="col-sm-10 text-center">
                                    </div>
                                    <div class="col-sm-1 text-center">
                                    </div>
                                </div>
                                @endif
                                <div id="insolerow">
                                    @if(!$InsoleData)
                                    @else
                                    @foreach($InsoleData as $data)
                                    <div id="insolerow2{{$b1++}}" class="form-group row mb-2">
                                        <div class="col-sm-2 py-1" style="display: inline-flex;">
                                            <input id="i_item_code1" value="{{$data->item_code}}" type="text" name="i_item_code[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code">                                        
                                        </div>
                                        <div class="col-sm-3 py-1">
                                            <input type="text" value="{{$data->description}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_description1" name="i_description[]" placeholder="Description">
                                            <input hidden type="text" value="{{$data->id}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_id" name="i_id[{{$data->id}}]" placeholder="Description" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input type="text" value="{{$data->uom}}" class="form-control py-2 yourclass readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_uom1" name="i_uom[]" placeholder="Unit">
                                        </div> 
                                        <div class="col-sm-2 py-1">
                                            <input id="i_component" value="{{$data->component}}" type="text" name="i_component[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input type="text" value="{{$data->output}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_output" name="i_output[]" placeholder="Quantity">
                                        </div>
                                        <div class="col-sm-1 py-1" hidden>
                                            <input min="0" type="number" value="{{$data->fac_qty}}" step=".01" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_fac" name="i_fac[]" placeholder="Factor">
                                        </div>
                                        <div class="col-sm-1 py-1" hidden>
                                            <input min="0" type="number" value="{{$data->total_qty}}" step=".01" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_qty" name="i_qty[]" placeholder="Quantity">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input min="0" type="number" value="{{$data->process}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_process" name="i_process[]" placeholder="%">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input min="0" type="number" value="{{$data->total}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_total_con" name="i_total_con[]" placeholder="Total">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input min="0" value="{{$data->rate}}" type="number" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_rate" name="i_rate[]" placeholder="Rate" required>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                                @if(!$LaminationData)
                                @else
                                <div class="form-group row mb-0 mt-5">
                                    <div class="col-sm-1 text-center">
                                        <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                            <label class="mb-0 text-white" style="font-weight: 600;">Lamination</label>
                                        </div>  
                                    </div>
                                    <div class="col-sm-10 text-center">
                                    </div>
                                    <div class="col-sm-1 text-center">
                                    </div>
                                </div>
                                @endif
                                <div id="laminationrow">
                                    @if(!$LaminationData)
                                    @else
                                    @foreach($LaminationData as $data)
                                    <div id="insolerow3{{$c1++}}" class="form-group row mb-2">
                                        <div class="col-sm-2 py-1" style="display: inline-flex;">
                                            <input id="lam_item_code1" value="{{$data->item_code}}" type="text" name="lam_item_code[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code">                                        
                                        </div>
                                        <div class="col-sm-3 py-1">
                                            <input type="text" value="{{$data->description}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_description1" name="lam_description[]" placeholder="Description">
                                            <input hidden type="text" value="{{$data->id}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_id" name="lam_id[{{$data->id}}]" placeholder="Description" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input type="text" value="{{$data->uom}}" class="form-control py-2 yourclass readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_uom1" name="lam_uom[]" placeholder="Unit">
                                        </div> 
                                        <div class="col-sm-2 py-1">
                                            <input id="lam_component" value="{{$data->component}}" type="text" name="lam_component[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input type="text" value="{{$data->output}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_output" name="lam_output[]" placeholder="Quantity">
                                        </div>
                                        <div class="col-sm-1 py-1" hidden>
                                            <input min="0" type="number" value="{{$data->fac_qty}}" step=".01" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_fac" name="lam_fac[]" placeholder="Factor">
                                        </div>
                                        <div class="col-sm-1 py-1" hidden>
                                            <input min="0" type="number" value="{{$data->total_qty}}" step=".01" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_qty" name="lam_qty[]" placeholder="Quantity">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input min="0" type="number" value="{{$data->process}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_process" name="lam_process[]" placeholder="%">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input min="0" type="number" value="{{$data->total}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_total_con" name="lam_total_con[]" placeholder="Total">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input min="0" type="number" value="{{$data->rate}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_rate" name="lam_rate[]" placeholder="Rate" required>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                                @if(!$ClosingData)
                                @else
                                <div class="form-group row mb-0 mt-5">
                                    <div class="col-sm-1 text-center">
                                        <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                            <label class="mb-0 text-white" style="font-weight: 600;">Closing</label>
                                        </div>  
                                    </div>
                                    <div class="col-sm-10 text-center">
                                    </div>
                                    <div class="col-sm-1 text-center">
                                    </div>
                                </div>
                                @endif
                                <div id="closingrow">
                                    @if(!$ClosingData)
                                    @else
                                    @foreach($ClosingData as $data)
                                    <div id="insolerow4{{$d1++}}" class="form-group row mb-2">
                                        <div class="col-sm-2 py-1" style="display: inline-flex;">
                                            <input id="clo_item_code1" value="{{$data->item_code}}" type="text" name="clo_item_code[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code">                                        
                                        </div>
                                        <div class="col-sm-3 py-1">
                                            <input type="text" value="{{$data->description}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_description1" name="clo_description[]" placeholder="Description">
                                            <input hidden type="text" value="{{$data->id}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_id" name="clo_id[{{$data->id}}]" placeholder="Description" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input type="text" value="{{$data->uom}}" class="form-control py-2 yourclass readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_uom1" name="clo_uom[]" placeholder="Unit">
                                        </div> 
                                        <div class="col-sm-2 py-1">
                                            <input id="clo_component" value="{{$data->component}}" type="text" name="clo_component[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input type="text" value="{{$data->output}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_output" name="clo_output[]" placeholder="Quantity">
                                        </div>
                                        <div class="col-sm-1 py-1" hidden>
                                            <input min="0" type="number" value="{{$data->fac_qty}}" step=".01" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_fac" name="clo_fac[]" placeholder="Factor">
                                        </div>
                                        <div class="col-sm-1 py-1" hidden>
                                            <input min="0" type="number" value="{{$data->total_qty}}" step=".01" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_qty" name="clo_qty[]" placeholder="Quantity">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input min="0" type="number" value="{{$data->process}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_process" name="clo_process[]" placeholder="%">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input min="0" type="number" value="{{$data->total}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_total_con" name="clo_total_con[]" placeholder="Total">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input min="0" type="number" value="{{$data->rate}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_rate" name="clo_rate[]" placeholder="Rate" required>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                                @if(!$LastingData)
                                @else
                                <div class="form-group row mb-0 mt-5">
                                    <div class="col-sm-1 text-center">
                                        <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                            <label class="mb-0 text-white" style="font-weight: 600;">Lasting</label>
                                        </div>  
                                    </div>
                                    <div class="col-sm-10 text-center">
                                    </div>
                                    <div class="col-sm-1 text-center">
                                    </div>
                                </div>
                                @endif
                                <div id="lastingrow">
                                    @if(!$LastingData)
                                    @else
                                    @foreach($LastingData as $data)
                                    <div id="insolerow5{{$e1++}}" class="form-group row mb-2">
                                        <div class="col-sm-2 py-1" style="display: inline-flex;">
                                            <input id="last_item_code1" value="{{$data->item_code}}" type="text" name="last_item_code[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code">                                        
                                        </div>
                                        <div class="col-sm-3 py-1">
                                            <input type="text" value="{{$data->description}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_description1" name="last_description[]" placeholder="Enter Description">
                                            <input hidden type="text" value="{{$data->id}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_id" name="last_id[{{$data->id}}]" placeholder=Description" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input type="text" value="{{$data->uom}}" class="form-control py-2 yourclass readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_uom1" name="last_uom[]" placeholder="Unit">
                                        </div>                  
                                        <div class="col-sm-2 py-1">
                                            <input id="last_component" value="{{$data->component}}" type="text" name="last_component[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input type="text" value="{{$data->output}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_output" name="last_output[]" placeholder="Quantity">
                                        </div>
                                        <div class="col-sm-1 py-1" hidden>
                                            <input min="0" type="number" value="{{$data->fac_qty}}" step=".01" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_fac" name="last_fac[]" placeholder="Factor">
                                        </div>
                                        <div class="col-sm-1 py-1" hidden>
                                            <input min="0" type="number" value="{{$data->total_qty}}" step=".01" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_qty" name="last_qty[]" placeholder="Quantity">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input min="0" type="number" value="{{$data->process}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_process" name="last_process[]" placeholder="%">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input min="0" type="number" value="{{$data->total}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_total_con" name="last_total_con[]" placeholder="Total">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input min="0" type="number" value="{{$data->rate}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_rate" name="last_rate[]" placeholder="Rate" required>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                                @if(!$PackingData)
                                @else
                                <div class="form-group row mb-0 mt-5">
                                    <div class="col-sm-1 text-center">
                                        <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                            <label class="mb-0 text-white" style="font-weight: 600;">Packing</label>
                                        </div>  
                                    </div>
                                    <div class="col-sm-10 text-center">
                                    </div>
                                    <div class="col-sm-1 text-center">
                                    </div>
                                </div>
                                @endif
                                <div id="packingrow">
                                    @if(!$PackingData)
                                    @else
                                    @foreach($PackingData as $data)
                                    <div id="insolerow6{{$f1++}}" class="form-group row mb-2">
                                        <div class="col-sm-2 py-1" style="display: inline-flex;">
                                            <input id="p_item_code1" value="{{$data->item_code}}" type="text" name="p_item_code[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code">                                    
                                        </div>
                                        <div class="col-sm-3 py-1">
                                            <input type="text" value="{{$data->description}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_description1" name="p_description[]" placeholder="Description">
                                            <input hidden type="text" value="{{$data->id}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_id" name="p_id[{{$data->id}}]" placeholder="Description" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input type="text" value="{{$data->uom}}" class="form-control py-2 yourclass readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_uom1" name="p_uom[]" placeholder="Unit">
                                        </div> 
                                        <div class="col-sm-2 py-1">
                                            <input id="p_component" value="{{$data->component}}" type="text" name="p_component[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input type="text" value="{{$data->output}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_output" name="p_output[]" placeholder="Quantity">
                                        </div>
                                        <div class="col-sm-1 py-1" hidden>
                                            <input min="0" type="number" value="{{$data->fac_qty}}" step=".01" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_fac" name="p_fac[]" placeholder="Factor">
                                        </div>
                                        <div class="col-sm-1 py-1" hidden>
                                            <input min="0" type="number" value="{{$data->total_qty}}" step=".01" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_qty" name="p_qty[]" placeholder="Quantity">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input min="0" type="number" value="{{$data->process}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_process" name="p_process[]" placeholder="%">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input min="0" type="number" value="{{$data->total}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_total_con" name="p_total_con[]" placeholder="Total">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input min="0" type="number" value="{{$data->rate}}" class="form-control py-2" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_rate" name="p_rate[]" placeholder="Rate" required>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                                <br><br>
                                <div class="form-group row mt-5">
                                    <div class="col-sm-3 mb-1 mb-sm-0">
                                    </div>
                                    <div class="col-sm-6">
                                        <button type="submit" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); font-size: larger;" class="btn px-5 py-1 btn-lg btn-block text-white">Create Material</button>
                                    </div>
                                    <div class="col-sm-3">
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if($userprogress === '80' && $userprogress != '85')
                        <div class="tab-pane p-3 active" id="profile-1" role="tabpanel">
                        @else
                        <div class="tab-pane p-3" id="profile-1" role="tabpanel">
                        @endif
                            <div class="form-group row text-center bg-dark py-1 mx-1 mt-5" style="border-radius: 4px;">
                                <div class="col-sm-2 py-1">
                                    <label class="mb-0"><b style="color: white; font-weight: 500;">Values Set{{$userprogress}}</b></label>
                                </div>
                                <div class="col-sm-5 py-1">
                                    <label class="mb-0"><b style="color: white; font-weight: 500;">Description</b></label>
                                </div>
                                <div class="col-sm-2 py-1">
                                    <label class="mb-0"><b style="color: white; font-weight: 500;">Remarks</b></label>
                                </div>
                                <div class="col-sm-2 py-1">
                                    <label class="mb-0"><b style="color: white; font-weight: 500;">Rate/Pair</b></label>
                                </div>
                                <div class="col-sm-1 py-1">
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-sm-2 text-center">
                                    <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                        <label class="mb-0 text-white" style="font-weight: 500;">Cutting</label>
                                    </div>  
                                </div>
                            </div>
                            <form action="{{url('specification-sheet-update-resource')}}" method="post" enctype="multipart/form-data">
                            @csrf
                                <div id="cuttingrow1">
                                    <div class="form-group row mb-2">
                                        <div class="col-sm-2 py-1">
                                            <input type="text" name="id" value="{{$id}}" hidden>
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_value_r" name="cut_value_r[]" placeholder="Item Code">
                                        </div>
                                        <div class="col-sm-5 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_description_r" name="cut_description_r[]" placeholder="Description">
                                        </div> 
                                        <div class="col-sm-2 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_remarks_r" name="cut_remarks_r[]" placeholder="Remarks">
                                        </div>
                                        <div class="col-sm-2 py-1">
                                            <input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_rate_r" name="cut_rate_r[]" placeholder="Rate">
                                        </div>
                                        <div class="col-sm-1 py-1 text-center">
                                            <button id="cutting1" type="button" class="btn btn-outline-primary btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                                        </div>
                                    </div>
                                    <div name="cutting1">
                                    </div>
                                </div>
                                <div class="form-group row mb-0 mt-5">
                                    <div class="col-sm-2 text-center">
                                        <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                            <label class="mb-0 text-white" style="font-weight: 500;">INSOLE</label>
                                        </div>  
                                    </div>
                                </div>
                                <div id="insolerow1">
                                    <div class="form-group row mb-2">
                                        <div class="col-sm-2 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_value_r" name="i_value_r[]" placeholder="Item Code">
                                        </div>
                                        <div class="col-sm-5 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_description_r" name="i_description_r[]" placeholder="Description">
                                        </div> 
                                        <div class="col-sm-2 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_remarks_r" name="i_remarks_r[]" placeholder="Remarks">
                                        </div>
                                        <div class="col-sm-2 py-1">
                                            <input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_rate_r" name="i_rate_r[]" placeholder="Rate">
                                        </div>
                                        <div class="col-sm-1 py-1 text-center">
                                            <button id="insole1" type="button" class="btn btn-outline-primary btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                                        </div>
                                    </div>
                                    <div name="insole1">
                                    </div>
                                </div>
                                <div class="form-group row mb-0 mt-5">
                                    <div class="col-sm-2 text-center">
                                        <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                            <label class="mb-0 text-white" style="font-weight: 500;">Lamination</label>
                                        </div>  
                                    </div>
                                </div>
                                <div id="laminationrow1">
                                    <div class="form-group row mb-2">
                                        <div class="col-sm-2 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_value_r" name="lam_value_r[]" placeholder="Item Code">
                                        </div>
                                        <div class="col-sm-5 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_description_r" name="lam_description_r[]" placeholder="Description">
                                        </div> 
                                        <div class="col-sm-2 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_remarks_r" name="lam_remarks_r[]" placeholder="Remarks">
                                        </div>
                                        <div class="col-sm-2 py-1">
                                            <input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_rate_r" name="lam_rate_r[]" placeholder="Rate">
                                        </div>
                                        <div class="col-sm-1 py-1 text-center">
                                            <button id="lamination1" type="button" class="btn btn-outline-primary btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                                        </div>
                                    </div>
                                    <div name="lamination1">
                                    </div>
                                </div>
                                <div class="form-group row mb-0 mt-5">
                                    <div class="col-sm-2 text-center">
                                        <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                            <label class="mb-0 text-white" style="font-weight: 500;">Closing</label>
                                        </div>  
                                    </div>
                                </div>
                                <div id="closingrow1">
                                    <div class="form-group row mb-2">
                                        <div class="col-sm-2 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_value_r" name="clo_value_r[]" placeholder="Item Code">
                                        </div>
                                        <div class="col-sm-5 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_description_r" name="clo_description_r[]" placeholder="Description">
                                        </div> 
                                        <div class="col-sm-2 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_remarks_r" name="clo_remarks_r[]" placeholder="Remarks">
                                        </div>
                                        <div class="col-sm-2 py-1">
                                            <input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_rate_r" name="clo_rate_r[]" placeholder="Rate">
                                        </div>
                                        <div class="col-sm-1 py-1 text-center">
                                            <button id="closing1" type="button" class="btn btn-outline-primary btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                                        </div>
                                    </div>
                                    <div name="closing1">
                                    </div>
                                </div>
                                <div class="form-group row mb-0 mt-5">
                                    <div class="col-sm-2 text-center">
                                        <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                            <label class="mb-0 text-white" style="font-weight: 500;">Lasting</label>
                                        </div>  
                                    </div>
                                </div>
                                <div id="lastingrow1">
                                    <div class="form-group row mb-2">
                                        <div class="col-sm-2 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_value_r" name="last_value_r[]" placeholder="Item Code">
                                        </div>
                                        <div class="col-sm-5 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_description_r" name="last_description_r[]" placeholder="Description">
                                        </div> 
                                        <div class="col-sm-2 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_remarks_r" name="last_remarks_r[]" placeholder="Remarks">
                                        </div>
                                        <div class="col-sm-2 py-1">
                                            <input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_rate_r" name="last_rate_r[]" placeholder="Rate">
                                        </div>
                                        <div class="col-sm-1 py-1 text-center">
                                            <button id="lasting1" type="button" class="btn btn-outline-primary btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                                        </div>
                                    </div>
                                    <div name="lasting1">
                                    </div>
                                </div>
                                <div class="form-group row mb-0 mt-5">
                                    <div class="col-sm-2 text-center">
                                        <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                            <label class="mb-0 text-white" style="font-weight: 500;">Packing</label>
                                        </div>  
                                    </div>
                                </div>
                                <div id="packingrow1">
                                    <div class="form-group row mb-2">
                                        <div class="col-sm-2 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_value_r" name="p_value_r[]" placeholder="Item Code">
                                        </div>
                                        <div class="col-sm-5 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_description_r" name="p_description_r[]" placeholder="Description">
                                        </div> 
                                        <div class="col-sm-2 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_remarks_r" name="p_remarks_r[]" placeholder="Remarks">
                                        </div>
                                        <div class="col-sm-2 py-1">
                                            <input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_rate_r" name="p_rate_r[]" placeholder="Rate">
                                        </div>
                                        <div class="col-sm-1 py-1 text-center">
                                            <button id="packing1" type="button" class="btn btn-outline-primary btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                                        </div>
                                    </div>
                                    <div name="packing1">
                                    </div>
                                </div>
                                <br><br>
                                <div class="form-group row mt-5">
                                    <div class="col-sm-3 mb-1 mb-sm-0">
                                    </div>
                                    <div class="col-sm-6">
                                        <button type="submit" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); font-size: larger;" class="btn px-5 py-1 btn-lg btn-block text-white">Create Resources</button>
                                    </div>
                                    <div class="col-sm-3">
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if($userprogress === '85' || $userprogress != '90')
                            @if($userprogress != '85')
                                <div class="tab-pane p-3" id="settings-1" role="tabpanel">
                            @else
                                <div class="tab-pane p-3 active" id="settings-1" role="tabpanel">
                            @endif
                        @endif
                            <div class="form-group row text-center bg-dark py-1 mx-1 mt-5" style="border-radius: 4px;">
                                <div class="col-sm-2 py-1">
                                    <label class="mb-0"><b style="color: white; font-weight: 500;">Values Set</b></label>
                                </div>
                                <div class="col-sm-5 py-1">
                                    <label class="mb-0"><b style="color: white; font-weight: 500;">Description</b></label>
                                </div>
                                <div class="col-sm-2 py-1">
                                    <label class="mb-0"><b style="color: white; font-weight: 500;">Remarks</b></label>
                                </div>
                                <div class="col-sm-2 py-1">
                                    <label class="mb-0"><b style="color: white; font-weight: 500;">Rate/Pair</b></label>
                                </div>
                                <div class="col-sm-1 py-1">
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-sm-2 text-center">
                                    <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                        <label class="mb-0 text-white" style="font-weight: 500;">Cutting</label>
                                    </div>  
                                </div>
                            </div>
                            <form action="{{url('specification-sheet-update-overhead')}}" method="post" enctype="multipart/form-data">
                            @csrf
                                <div id="cuttingrow2">
                                    <div class="form-group row mb-2">
                                        <div class="col-sm-2 py-1">
                                            <input type="text" name="id" value="{{$id}}" hidden>
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_value_o" name="cut_value_o[]" placeholder="Item Code">
                                        </div>
                                        <div class="col-sm-5 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_description_o" name="cut_description_o[]" placeholder="Description">
                                        </div> 
                                        <div class="col-sm-2 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_remarks_o" name="cut_remarks_o[]" placeholder="Remarks">
                                        </div>
                                        <div class="col-sm-2 py-1">
                                            <input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_rate_o" name="cut_rate_o[]" placeholder="Rate">
                                        </div>
                                        <div class="col-sm-1 py-1 text-center">
                                            <button id="cutting2" type="button" class="btn btn-outline-primary btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                                        </div>
                                    </div>
                                    <div name="cutting2">
                                    </div>
                                </div>
                                <div class="form-group row mb-0 mt-5">
                                    <div class="col-sm-2 text-center">
                                        <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                            <label class="mb-0 text-white" style="font-weight: 500;">INSOLE</label>
                                        </div>  
                                    </div>
                                </div>
                                <div id="insolerow2">
                                    <div class="form-group row mb-2">
                                        <div class="col-sm-2 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_value_o" name="i_value_o[]" placeholder="Item Code">
                                        </div>
                                        <div class="col-sm-5 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_description_o" name="i_description_o[]" placeholder="Description">
                                        </div> 
                                        <div class="col-sm-2 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_remarks_o" name="i_remarks_o[]" placeholder="Remarks">
                                        </div>
                                        <div class="col-sm-2 py-1">
                                            <input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize_o" id="i_rate_o" name="i_rate_m[]" placeholder="Rate">
                                        </div>
                                        <div class="col-sm-1 py-1 text-center">
                                            <button id="insole2" type="button" class="btn btn-outline-primary btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                                        </div>
                                    </div>
                                    <div name="insole2">
                                    </div>
                                </div>
                                <div class="form-group row mb-0 mt-5">
                                    <div class="col-sm-2 text-center">
                                        <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                            <label class="mb-0 text-white" style="font-weight: 500;">Lamination</label>
                                        </div>  
                                    </div>
                                </div>
                                <div id="laminationrow2">
                                    <div class="form-group row mb-2">
                                        <div class="col-sm-2 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_value_o" name="lam_value_o[]" placeholder="Item Code">
                                        </div>
                                        <div class="col-sm-5 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_description_o" name="lam_description_o[]" placeholder="Description">
                                        </div> 
                                        <div class="col-sm-2 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_remarks_o" name="lam_remarks_o[]" placeholder="Remarks">
                                        </div>
                                        <div class="col-sm-2 py-1">
                                            <input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_rate_o" name="lam_rate_o[]" placeholder="Rate">
                                        </div>
                                        <div class="col-sm-1 py-1 text-center">
                                            <button id="lamination2" type="button" class="btn btn-outline-primary btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                                        </div>
                                    </div>
                                    <div name="lamination2">
                                    </div>
                                </div>
                                <div class="form-group row mb-0 mt-5">
                                    <div class="col-sm-2 text-center">
                                        <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                            <label class="mb-0 text-white" style="font-weight: 500;">Closing</label>
                                        </div>  
                                    </div>
                                </div>
                                <div id="closingrow2">
                                    <div class="form-group row mb-2">
                                        <div class="col-sm-2 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_value_o" name="clo_value_o[]" placeholder="Item Code">
                                        </div>
                                        <div class="col-sm-5 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_description_o" name="clo_description_o[]" placeholder="Description">
                                        </div> 
                                        <div class="col-sm-2 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_remarks_o" name="clo_remarks_o[]" placeholder="Remarks">
                                        </div>
                                        <div class="col-sm-2 py-1">
                                            <input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_rate_o" name="clo_rate_o[]" placeholder="Rate">
                                        </div>
                                        <div class="col-sm-1 py-1 text-center">
                                            <button id="closing2" type="button" class="btn btn-outline-primary btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                                        </div>
                                    </div>
                                    <div name="closing2">
                                    </div>
                                </div>
                                <div class="form-group row mb-0 mt-5">
                                    <div class="col-sm-2 text-center">
                                        <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                            <label class="mb-0 text-white" style="font-weight: 500;">Lasting</label>
                                        </div>  
                                    </div>
                                </div>
                                <div id="lastingrow2">
                                    <div class="form-group row mb-2">
                                        <div class="col-sm-2 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_value_o" name="last_value_o[]" placeholder="Item Code">
                                        </div>
                                        <div class="col-sm-5 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_description_0" name="last_description_o[]" placeholder="Description">
                                        </div> 
                                        <div class="col-sm-2 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_remarks_0" name="last_remarks_o[]" placeholder="Remarks">
                                        </div>
                                        <div class="col-sm-2 py-1">
                                            <input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_rate_o" name="last_rate_o[]" placeholder="Rate">
                                        </div>
                                        <div class="col-sm-1 py-1 text-center">
                                            <button id="lasting2" type="button" class="btn btn-outline-primary btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                                        </div>
                                    </div>
                                    <div name="lasting2">
                                    </div>
                                </div>
                                <div class="form-group row mb-0 mt-5">
                                    <div class="col-sm-2 text-center">
                                        <div class="alert alert-secondary border-0 py-1" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)) !important;" role="alert">
                                            <label class="mb-0 text-white" style="font-weight: 500;">Packing</label>
                                        </div>  
                                    </div>
                                </div>
                                <div id="packingrow2">
                                    <div class="form-group row mb-2">
                                        <div class="col-sm-2 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_value_o" name="p_value_o[]" placeholder="Item Code">
                                        </div>
                                        <div class="col-sm-5 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_description_o" name="p_description_o[]" placeholder="Description">
                                        </div> 
                                        <div class="col-sm-2 py-1">
                                            <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_remarks_o" name="p_remarks_o[]" placeholder="Remarks">
                                        </div>
                                        <div class="col-sm-2 py-1">
                                            <input min="0" type="number" step=".01" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_rate_o" name="p_rate_o[]" placeholder="Rate">
                                        </div>
                                        <div class="col-sm-1 py-1 text-center">
                                            <button id="packing2" type="button" class="btn btn-outline-primary btn-round px-4" aria-haspopup="true" aria-expanded="false"><i style="font-size: 15px;" class="mdi mdi-plus"></i></button>
                                        </div>
                                    </div>
                                    <div name="packing2">
                                    </div>
                                </div>
                                <br><br>
                                <div class="form-group row mt-5">
                                    <div class="col-sm-3 mb-1 mb-sm-0">
                                    </div>
                                    <div class="col-sm-6">
                                        <button type="submit" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); font-size: larger;" class="btn px-5 py-1 btn-lg btn-block text-white">Create Overheads</button>
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
    </div>
</div>
<script src="assets/js/customjquery.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script>
$(".readonly").prop('readonly',true);
$(document).ready(function(){ 
	$("#loader1").fadeOut(1200);
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
			timer: 3000
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
<script src="assets/js/costingsheet-resources.js"></script>
<script src="assets/js/costingsheet-overheads.js"></script>
@endsection