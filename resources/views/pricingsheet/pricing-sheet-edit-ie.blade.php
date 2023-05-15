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
    <div class="row px-2">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('pricing-sheet-table')}}">Manage Pricing Sheet</a></li>
                        <li class="breadcrumb-item active" style="font-family: 'Poppins', sans-serif;">Create Pricing Sheet</li>
                    </ol>
                </div>
                <h4 class="page-title">Create Pricing Sheet (Engineering)</h4>
            </div>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-lg-12 mb-5">
            <div class="card">
                <div class="card-body px-4 py-5">
                    <ul class="nav nav-pills nav-justified" role="tablist">
                        <li class="nav-item waves-effect waves-light" style="border-radius: 16px; background: transparent;">
                            <a class="nav-link" data-toggle="tab" href="#home-1" role="tab">Materials</a>
                        </li>
                        <li class="nav-item waves-effect waves-light" style="border-radius: 16px; background: transparent;"> 
                          
                                <a class="nav-link active" data-toggle="tab" href="#profile-1" role="tab">Resources</a>
                        </li>
                        <li class="nav-item waves-effect waves-light" style="border-radius: 16px; background: transparent;">
                          
                                <a class="nav-link" data-toggle="tab" href="#settings-1" role="tab">Overheads</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane p-3" id="home-1" role="tabpanel">
                            <form action="{{url('pricing-sheet-update-material')}}" method="post" enctype="multipart/form-data">
                            @csrf
                                <div class="form-group row py-2 mb-5 mt-5">
                                    <div class="col-sm-9 col-md-9 py-0">
                                        <div class="form-group row py-0 mb-0">
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <input type="text" name="id" value="{{$id}}" hidden>
                                                <label><b style="color: #6c757d">Season</b></label>      
                                                <p style="font-family: 'Poppins', sans-serif;">{{$userseason}}</p>                                      
                                            </div>
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <label><b style="color: #6c757d">Category</b></label>
                                                <p style="font-family: 'Poppins', sans-serif;">{{$usercategory}}</p>                                      
                                            </div>
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <label><b style="color: #6c757d">Shape</b></label>
                                                <p style="font-family: 'Poppins', sans-serif;">{{$usershape}}</p>                                      
                                            </div>
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <label><b style="color: #6c757d">Sole</b></label>
                                                <p style="font-family: 'Poppins', sans-serif;">{{$usersole}}</p>                                      
                                            </div>
                                        </div>
                                        <div class="form-group row py-0 mb-0">
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <label><b style="color: #6c757d">Project</b></label>
                                                <p style="font-family: 'Poppins', sans-serif;">{{$userproject}}</p>                                      
                                            </div>
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <label><b style="color: #6c757d">Range</b></label>
                                                <p style="font-family: 'Poppins', sans-serif;">{{$userrange}}</p>                                      
                                            </div>
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <label><b style="color: #6c757d">Design No</b></label>
                                                <p style="font-family: 'Poppins', sans-serif; text-transform: capitalize;">{{$userdesign}}</p>                                      
                                            </div>
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <label><b style="color: #6c757d">Sequence</b></label>
                                                <p style="font-family: 'Poppins', sans-serif;">{{$sequence}}</p>                                      
                                            </div>
                                        </div>
                                        <div class="form-group row py-0 mb-0">
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <label><b style="color: #6c757d">Purpose</b></label>
                                                <p style="font-family: 'Poppins', sans-serif;">{{$userpurpose}}</p>                                      
                                            </div>
                                            <div class="col-sm-3 col-md-3 py-1">
                                                <label><b style="color: #6c757d">Product</b></label>
                                                <p style="font-family: 'Poppins', sans-serif;">{{$userproduct}}</p>                                      
                                            </div>
                                            <div class="col-sm-6 col-md-6 py-1">
                                                <label><b style="color: #6c757d">Design Description</b></label>
                                                <p style="font-family: 'Poppins', sans-serif; text-transform: capitalize;">{{$userdescription}}</p>                                      
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-3 py-1">
                                        <label><b style="color: #6c757d">Date</b></label>
                                        <p style="font-family: 'Poppins', sans-serif;">{{$date}}</p>                                          
                                        <label class="mt-2"><b style="color: #6c757d">Attachment</b></label>    
                                        <br>                               
                                        @if(isset($image) && !empty($image)) 
                                        <img src="{{ asset('uploads/appsetting/' . $image) }}" alt="profile-user" height="100" class="rounded mt-2">
                                        @else
                                        <img src="{{asset('img/photos/10.jpg')}}" alt="profile-user" height="100" class="rounded mt-2">
                                        @endif                                 
                                    </div>
                                </div>
                                <div class="form-group row text-center bg-dark py-1 mx-1" style="border-radius: 4px;">
                                    <div class="col-sm-1 py-1">
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
                                    <div class="col-sm-1 py-1">
                                        <label class="mb-0"><b style="color: white; font-weight: 500;">Sub Division</b></label>
                                    </div>
                                    <div class="col-sm-1 py-1">
                                        <label class="mb-0"><b style="color: white; font-weight: 500;">Output</b></label>
                                    </div>
                                    <div class="col-sm-1 py-1">
                                        <label class="mb-0"><b style="color: white; font-weight: 500;">Consumption Factor</b></label>
                                    </div>
                                    <div class="col-sm-1 py-1" hidden>
                                        <label class="mb-0"><b style="color: white; font-weight: 500;">Consumption Quantity</b></label>
                                    </div>
                                    <div class="col-sm-1 py-1">
                                        <label class="mb-0"><b style="color: white; font-weight: 500;">Process <br> Code</b></label>
                                    </div>
                                    <div class="col-sm-1 py-1">
                                        <label class="mb-0"><b style="color: white; font-weight: 500;">Process <br> Loss %</b></label>
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
                                    <div id="insolerow1{{$a1++}}" class="form-group row mb-0 text-center">
                                        <div class="col-sm-1 py-1">
                                            <p class="py-1" style="font-family: 'Poppins', sans-serif;">{{$data['value']->item_code}}</p> 
                                            <input hidden id="cut_item_code1" value="{{$data['value']->item_code}}" type="text" name="cut_item_code[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code" required>                                        
                                        </div>
                                        <div class="col-sm-2 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif; text-transform: capitalize;">{{$data['value']->description}}</p> 
                                            <input hidden type="text" value="{{$data['value']->description}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_description1" name="cut_description[]" placeholder="Description" required>
                                            <input hidden type="text" value="{{$data['value']->id}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_id" name="cut_id[{{$data['value']->id}}]" placeholder="Description" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->uom}}</p> 
                                            <input hidden type="text" value="{{$data['value']->uom}}" class="form-control py-2 yourclass readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_uom1" name="cut_uom[]" placeholder="Unit">
                                        </div>                               
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['result']}}</p> 
                                            <input hidden id="cut_component" value="{{$data['result']}}" type="text" name="cut_component[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->subdivision}}</p> 
                                            <input hidden id="cut_component" value="{{$data['value']->subdivision}}" type="text" name="cut_component[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->output}}</p> 
                                            <input hidden value="{{$data['value']->output}}" type="text" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_output" name="cut_output[]" placeholder="Quantity">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->fac_qty}}</p> 
                                            <input hidden value="{{$data['value']->fac_qty}}" type="number" step=".01" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_fac" name="cut_fac[]" placeholder="Factor">
                                        </div>
                                        <div class="col-sm-1 py-1" hidden>
                                            <input type="number" step=".01" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_qty" name="cut_qty[]" placeholder="Quantity">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->cut_code}}</p> 
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->process}}</p> 
                                            <input hidden value="{{$data['value']->process}}" type="number" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_process" name="cut_process[]" placeholder="%">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->total}}</p> 
                                            <input hidden value="{{$data['value']->total}}" type="number" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_total_con" name="cut_total_con[]" placeholder="Total">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input step="0.1" min="0" value="{{$data['value']->rate}}" type="number" class="form-control py-1 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_rate" name="cut_rate[]" placeholder="Rate" required>
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
                                    <div id="insolerow2{{$b1++}}" class="form-group row mb-0 text-center">
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->item_code}}</p> 
                                            <input hidden id="i_item_code1" value="{{$data['value']->item_code}}" type="text" name="i_item_code[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code">                                        
                                        </div>
                                        <div class="col-sm-2 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif; text-transform: capitalize;">{{$data['value']->description}}</p> 
                                            <input hidden type="text" value="{{$data['value']->description}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_description1" name="i_description[]" placeholder="Description">
                                            <input hidden type="text" value="{{$data['value']->id}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_id" name="i_id[{{$data['value']->id}}]" placeholder="Description" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->uom}}</p> 
                                            <input hidden type="text" value="{{$data['value']->uom}}" class="form-control py-2 yourclass readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_uom1" name="i_uom[]" placeholder="Unit">
                                        </div> 
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['result']}}</p> 
                                            <input hidden id="i_component" value="{{$data['result']}}" type="text" name="i_component[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->subdivision}}</p> 
                                            <input hidden id="cut_component" value="{{$data['value']->subdivision}}" type="text" name="cut_component[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->output}}</p> 
                                            <input hidden type="text" value="{{$data['value']->output}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_output" name="i_output[]" placeholder="Quantity">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->fac_qty}}</p> 
                                            <input hidden type="number" value="{{$data['value']->fac_qty}}" step=".01" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_fac" name="i_fac[]" placeholder="Factor">
                                        </div>
                                        <div class="col-sm-1 py-1" hidden>
                                            <input type="number" step=".01" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_qty" name="i_qty[]" placeholder="Quantity">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->cut_code}}</p> 
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->process}}</p> 
                                            <input hidden type="number" value="{{$data['value']->process}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_process" name="i_process[]" placeholder="%">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->total}}</p> 
                                            <input hidden type="number" value="{{$data['value']->total}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_total_con" name="i_total_con[]" placeholder="Total">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input step="0.1" min="0" value="{{$data['value']->rate}}" type="number" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_rate" name="i_rate[]" placeholder="Rate" required>
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
                                    <div id="insolerow3{{$c1++}}" class="form-group row mb-0 text-center">
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->item_code}}</p> 
                                            <input hidden id="lam_item_code1" value="{{$data['value']->item_code}}" type="text" name="lam_item_code[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code">                                        
                                        </div>
                                        <div class="col-sm-2 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif; text-transform: capitalize;">{{$data['value']->description}}</p> 
                                            <input hidden type="text" value="{{$data['value']->description}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_description1" name="lam_description[]" placeholder="Description">
                                            <input hidden type="text" value="{{$data['value']->id}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_id" name="lam_id[{{$data['value']->id}}]" placeholder="Description" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->uom}}</p> 
                                            <input hidden type="text" value="{{$data['value']->uom}}" class="form-control py-2 yourclass readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_uom1" name="lam_uom[]" placeholder="Unit">
                                        </div> 
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['result']}}</p> 
                                            <input hidden id="lam_component" value="{{$data['result']}}" type="text" name="lam_component[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->subdivision}}</p> 
                                            <input hidden id="cut_component" value="{{$data['value']->subdivision}}" type="text" name="cut_component[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->output}}</p> 
                                            <input hidden type="text" value="{{$data['value']->output}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_output" name="lam_output[]" placeholder="Quantity">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->fac_qty}}</p> 
                                            <input hidden type="number" value="{{$data['value']->fac_qty}}" step=".01" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_fac" name="lam_fac[]" placeholder="Factor">
                                        </div>
                                        <div class="col-sm-1 py-1" hidden>
                                            <input type="number" step=".01" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_qty" name="lam_qty[]" placeholder="Quantity">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->cut_code}}</p> 
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->process}}</p> 
                                            <input hidden type="number" value="{{$data['value']->process}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_process" name="lam_process[]" placeholder="%">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->total}}</p> 
                                            <input hidden type="number" value="{{$data['value']->total}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_total_con" name="lam_total_con[]" placeholder="Total">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input step="0.1" min="0" type="number" value="{{$data['value']->rate}}" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_rate" name="lam_rate[]" placeholder="Rate" required>
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
                                    <div id="insolerow4{{$d1++}}" class="form-group row mb-0 text-center">
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->item_code}}</p> 
                                            <input hidden id="clo_item_code1" value="{{$data['value']->item_code}}" type="text" name="clo_item_code[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code">                                        
                                        </div>
                                        <div class="col-sm-2 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif; text-transform: capitalize;">{{$data['value']->description}}</p>
                                            <input hidden type="text" value="{{$data['value']->description}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_description1" name="clo_description[]" placeholder="Description">
                                            <input hidden type="text" value="{{$data['value']->id}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_id" name="clo_id[{{$data['value']->id}}]" placeholder="Description" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->uom}}</p> 
                                            <input hidden type="text" value="{{$data['value']->uom}}" class="form-control py-2 yourclass readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_uom1" name="clo_uom[]" placeholder="Unit">
                                        </div> 
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['result']}}</p> 
                                            <input hidden id="clo_component" value="{{$data['result']}}" type="text" name="clo_component[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->subdivision}}</p> 
                                            <input hidden id="cut_component" value="{{$data['value']->subdivision}}" type="text" name="cut_component[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->output}}</p> 
                                            <input hidden type="text" value="{{$data['value']->output}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_output" name="clo_output[]" placeholder="Quantity">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->fac_qty}}</p> 
                                            <input hidden type="number" value="{{$data['value']->fac_qty}}" step=".01" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_fac" name="clo_fac[]" placeholder="Factor">
                                        </div>
                                        <div class="col-sm-1 py-1" hidden>
                                            <input type="number" step=".01" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_qty" name="clo_qty[]" placeholder="Quantity">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->cut_code}}</p> 
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->process}}</p> 
                                            <input hidden type="number" value="{{$data['value']->process}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_process" name="clo_process[]" placeholder="%">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->total}}</p> 
                                            <input hidden type="number" value="{{$data['value']->total}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_total_con" name="clo_total_con[]" placeholder="Total">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input step="0.1" min="0" type="number" value="{{$data['value']->rate}}" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_rate" name="clo_rate[]" placeholder="Rate" required>
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
                                    <div id="insolerow5{{$e1++}}" class="form-group row mb-0 text-center">
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->item_code}}</p> 
                                            <input hidden id="last_item_code1" value="{{$data['value']->item_code}}" type="text" name="last_item_code[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code">                                        
                                        </div>
                                        <div class="col-sm-2 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif; text-transform: capitalize;">{{$data['value']->description}}</p>
                                            <input hidden type="text" value="{{$data['value']->description}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_description1" name="last_description[]" placeholder="Description">
                                            <input hidden type="text" value="{{$data['value']->id}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_id" name="last_id[{{$data['value']->id}}]" placeholder="Description" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->uom}}</p> 
                                            <input hidden type="text" value="{{$data['value']->uom}}" class="form-control py-2 yourclass readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_uom1" name="last_uom[]" placeholder="Unit">
                                        </div>                  
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['result']}}</p> 
                                            <input hidden id="last_component" value="{{$data['result']}}" type="text" name="last_component[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->subdivision}}</p> 
                                            <input hidden id="cut_component" value="{{$data['value']->subdivision}}" type="text" name="cut_component[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->output}}</p> 
                                            <input hidden type="text" value="{{$data['value']->output}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_output" name="last_output[]" placeholder="Quantity">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->fac_qty}}</p> 
                                            <input hidden type="number" value="{{$data['value']->fac_qty}}" step=".01" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_fac" name="last_fac[]" placeholder="Factor">
                                        </div>
                                        <div class="col-sm-1 py-1" hidden>
                                            <input hidden type="number" step=".01" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_qty" name="last_qty[]" placeholder="Quantity">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->cut_code}}</p> 
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->process}}</p> 
                                            <input hidden type="number" value="{{$data['value']->process}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_process" name="last_process[]" placeholder="%">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->total}}</p> 
                                            <input hidden type="number" value="{{$data['value']->total}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_total_con" name="last_total_con[]" placeholder="Total">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input step="0.1" min="0" type="number" value="{{$data['value']->rate}}" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_rate" name="last_rate[]" placeholder="Rate" required>
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
                                    <div id="insolerow6{{$f1++}}" class="form-group row mb-0 text-center">
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->item_code}}</p> 
                                            <input hidden id="p_item_code1" value="{{$data['value']->item_code}}" type="text" name="p_item_code[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code">                                    
                                        </div>
                                        <div class="col-sm-2 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif; text-transform: capitalize;">{{$data['value']->description}}</p>
                                            <input hidden type="text" value="{{$data['value']->description}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_description1" name="p_description[]" placeholder="Description">
                                            <input hidden type="text" value="{{$data['value']->id}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_id" name="p_id[{{$data['value']->id}}]" placeholder="Description" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->uom}}</p> 
                                            <input hidden type="text" value="{{$data['value']->uom}}" class="form-control py-2 yourclass readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_uom1" name="p_uom[]" placeholder="Unit">
                                        </div> 
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['result']}}</p> 
                                            <input hidden id="p_component" value="{{$data['result']}}" type="text" name="p_component[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->subdivision}}</p> 
                                            <input hidden id="cut_component" value="{{$data['value']->subdivision}}" type="text" name="cut_component[]" style="border: 1px solid #bfbfbf;" class="form-control py-2 readonly" placeholder="Code" required>
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->output}}</p> 
                                            <input hidden type="text" value="{{$data['value']->output}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_output" name="p_output[]" placeholder="Quantity">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->fac_qty}}</p> 
                                            <input hidden type="number" value="{{$data['value']->fac_qty}}" step=".01" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_fac" name="p_fac[]" placeholder="Factor">
                                        </div>
                                        <div class="col-sm-1 py-1" hidden>
                                            <input type="number" step=".01" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_qty" name="p_qty[]" placeholder="Quantity">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->cut_code}}</p> 
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->process}}</p> 
                                            <input hidden type="number" value="{{$data['value']->process}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_process" name="p_process[]" placeholder="%">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <p class="py-2" style="font-family: 'Poppins', sans-serif;">{{$data['value']->total}}</p> 
                                            <input hidden type="number" value="{{$data['value']->total}}" class="form-control py-2 readonly" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_total_con" name="p_total_con[]" placeholder="Total">
                                        </div>
                                        <div class="col-sm-1 py-1">
                                            <input step="0.1" min="0" type="number" value="{{$data['value']->rate}}" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_rate" name="p_rate[]" placeholder="Rate" required>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane p-3 active" id="profile-1" role="tabpanel">
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
                            <form action="{{url('pricing-sheet-update-resource')}}" method="post" enctype="multipart/form-data">
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
                                            <input type="number" step="0.1" min="0" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="cut_rate_r" name="cut_rate_r[]" placeholder="Rate">
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
                                            <input type="number" step="0.1" min="0" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="i_rate_r" name="i_rate_r[]" placeholder="Rate">
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
                                            <input type="number" step="0.1" min="0" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="lam_rate_r" name="lam_rate_r[]" placeholder="Rate">
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
                                            <input type="number" step="0.1" min="0" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="clo_rate_r" name="clo_rate_r[]" placeholder="Rate">
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
                                            <input type="number" step="0.1" min="0" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="last_rate_r" name="last_rate_r[]" placeholder="Rate">
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
                                            <input type="number" step="0.1" min="0" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf; text-transform: capitalize" id="p_rate_r" name="p_rate_r[]" placeholder="Rate">
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
                        <div class="tab-pane p-3" id="settings-1" role="tabpanel">
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
<script>
$(document).ready(function(){ 
	$("#loader1").fadeOut(1200);
    $("#Check").on('click',function(){
        var count1 = $("#cut_pcpd_cutting").val();
        var count2 = $("#cut_pcpd_sti").val();
        var count3 = $("#cut_pcpd_last").val();
        var count4 = $("#cut_pcpd_clo").val();
        var count5 = $("#cut_pcpd_lam").val();
        var count6 = $("#cut_pcpd_p").val();
        if(count1 == '' && count2 == '' && count3 == '' && count4 == '' && count5 == '' && count6 == ''){
            Swal.fire({
                icon: 'warning',
                text: "Add Atleast one Material",
            });
        }
        else{
            $("#myForm").attr("method", "post");
            $("#myForm").attr("enctype", "multipart/form-data");
            $("#myForm").attr("action", "formula-sheet-create");
            document.getElementById("myForm").submit();
        }
    }); 
});
</script>
<script>
    let strengthBadge3 = document.getElementById('StrengthDisp3');
    $(".calculate").keyup(function(){
        var id = $(this).attr("data-id");
        var cut_pcpd = $('#cut_pcpd_'+id).val();
        var cut_noe = $('#cut_noe_'+id).val();
        var cut_aspd = $('#cut_aspd_'+id).val();
        var cut_nowd = $('#cut_nowd_'+id).val();
        if(cut_noe.length == 0 && cut_aspd.length == 0 && cut_nowd.length == 0 && cut_pcpd.length == 0){
            strengthBadge3.style.display = 'block'
            strengthBadge3.style.backgroundColor = '#cd3f3f'
            strengthBadge3.textContent = 'Please Add Production Capacity Per Day, No. of Employee, Avg Salary Per Employee, No. of Working Days for Calculate Per Day Salary'
            var timer;
            clearTimeout(timer);
            var cut_noe1 = $('#cut_noe_'+id);
            var cut_aspd1 = $('#cut_aspd_'+id);
            var cut_nowd1 = $('#cut_nowd_'+id);
            var cut_pcpd1 = $('#cut_pcpd_'+id);

            cut_noe1.css('border-color', 'red');
            cut_aspd1.css('border-color', 'red');
            cut_nowd1.css('border-color', 'red');
            cut_pcpd1.css('border-color', 'red');

            timer = setTimeout(function(){
                cut_noe1.css('border-color', '#bfbfbf');
                cut_aspd1.css('border-color', '#bfbfbf');
                cut_nowd1.css('border-color', '#bfbfbf');
                cut_pcpd1.css('border-color', '#bfbfbf');
            }, 4000);
        }
        else if(cut_pcpd.length == 0){
            var timer;
            clearTimeout(timer);
            var self = $('#cut_pcpd_'+id);
            self.css('border-color', 'red');
            timer = setTimeout(function(){
                self.css('border-color', '#bfbfbf');
            }, 3000);
        }
        else if(cut_noe.length == 0){
            var timer;
            clearTimeout(timer);
            var self = $('#cut_noe_'+id);
            self.css('border-color', 'red');
            timer = setTimeout(function(){
                self.css('border-color', '#bfbfbf');
            }, 3000);
        }
        else if(cut_aspd.length == 0){
            var timer;
            clearTimeout(timer);
            var self = $('#cut_aspd_'+id);
            self.css('border-color', 'red');
            timer = setTimeout(function(){
                self.css('border-color', '#bfbfbf');
            }, 3000);
        }
        else if(cut_nowd.length == 0){
            var timer;
            clearTimeout(timer);
            var self = $('#cut_nowd_'+id);
            self.css('border-color', 'red');
            timer = setTimeout(function(){
                self.css('border-color', '#bfbfbf');
            }, 3000);
        }
        else if(cut_nowd && cut_aspd && cut_noe && cut_pcpd){
            var cut_noe = $('#cut_noe_'+id).val();
            var cut_aspd = $('#cut_aspd_'+id).val();
            var cut_nowd = $('#cut_nowd_'+id).val();
            var cut_pcpd = $('#cut_pcpd_'+id).val();
            var result = 0; 
            result = cut_aspd / cut_nowd;
            result1 = result * cut_noe;
            var number = Math.trunc(result1);
            var final = number.toLocaleString();
            $("#cut_pds_"+id).val(final);
            var final1 = number / cut_pcpd;
            var final1 = parseFloat(final1).toFixed(2);
            // var final1nUm = Math.trunc(final1);
            $("#cut_dlo_"+id).val(final1);
        }
        $('#StrengthDisp3').delay(4000).fadeOut(600); 
    });
    $(".calculate1").keyup(function(){
        var id = $(this).attr("data-id");
        var ilo = $('#cut_ilo_'+id).val();
        if(ilo.length == 0){
            var timer;
            clearTimeout(timer);
            var ilo = $('#cut_ilo_'+id);
            ilo.css('border-color', 'red');
            timer = setTimeout(function(){
                ilo.css('border-color', '#bfbfbf');
            }, 3000);
        }
        else if(ilo){
            var ilo = $('#cut_ilo_'+id).val();
            var dlo = $('#cut_dlo_'+id).val();
            if(dlo.length>0){
                var final2 = dlo * ilo / 100;
                var final2 = parseFloat(final2).toFixed(2);
                $("#cut_cilo_"+id).val(final2);
            }
            else{
                var self = $('#cut_dlo_'+id);
                self.css('border-color', 'red');
                timer = setTimeout(function(){
                    self.css('border-color', '#bfbfbf');
                }, 3000);
            }
        }
        $('#StrengthDisp3').delay(4000).fadeOut(600); 
    });
    $(".calculate2").keyup(function(){
        var id = $(this).attr("data-id");
        var foh = $('#cut_foh_'+id).val();
        if(foh.length == 0){
            var timer;
            clearTimeout(timer);
            var foh = $('#cut_foh_'+id);
            foh.css('border-color', 'red');
            timer = setTimeout(function(){
                foh.css('border-color', '#bfbfbf');
            }, 3000);
        }
        else if(foh){
            var foh = $('#cut_foh_'+id).val();
            var dlo = $('#cut_dlo_'+id).val();
            if(dlo.length>0){
                var final3 = 0;
                var final4 = 0;
                var final2 = dlo * foh / 100;
                var final2 = parseFloat(final2).toFixed(2);
                $("#cut_ilOh_b_"+id).val(final2); 
                
                var cut_dlo = $('#cut_dlo_'+id).val();
                var cut_cilo = $('#cut_cilo_'+id).val();
                var cut_ilOh_b = $('#cut_ilOh_b_'+id).val();
                var final3 = parseFloat(cut_cilo)+parseFloat(cut_dlo)+parseFloat(cut_ilOh_b);
                $("#cut_t_oh_"+id).val(parseFloat(final3).toFixed(2));
            }
            else{
                var self = $('#cut_cilo_'+id);
                self.css('border-color', 'red');
                timer = setTimeout(function(){
                    self.css('border-color', '#bfbfbf');
                }, 3000);
            }
        }
        $('#StrengthDisp3').delay(4000).fadeOut(600); 
    // });
    // $("#cut_foh").keyup(function(){
        var id = $(this).attr("data-id");
        var ilo = $('#cut_t_oh_'+id).val();
        var temp = 2500; 
        if(ilo.length == 0){
            var timer;
            clearTimeout(timer);
            var ilo = $('#cut_t_oh_'+id);
            ilo.css('border-color', 'red');
            timer = setTimeout(function(){
                ilo.css('border-color', '#bfbfbf');
            }, 3000);
        }
        else if(ilo.length>0){
            $("#cut_cap_"+id).val(temp);

            var cut_cap = $("#cut_cap_"+id).val();
            var cut_pds = $("#cut_pds_"+id).val();
            var cut_pds1 = cut_pds.replace(/,/g, '');
            var cal = cut_pds1 / cut_cap;
            var cal = parseFloat(cal).toFixed(2);
            $("#cut_dlo_a_"+id).val(cal);

            var cut_dlo_a = $("#cut_dlo_a_"+id).val();
            var cut_ilo = $("#cut_ilo_"+id).val();         
            var final2 = cut_dlo_a * cut_ilo / 100;
            var final2 = parseFloat(final2).toFixed(2);
            $("#cut_ilo_a_"+id).val(final2);

            var cut_dlo_a = $("#cut_dlo_a_"+id).val();
            var cut_foh = $("#cut_foh_"+id).val();          
            var final22 = cut_dlo_a * cut_foh / 100;
            var final22 = parseFloat(final22).toFixed(2);
            $("#cut_dlo_b_"+id).val(final22);

            var cut_dlo_a = $("#cut_dlo_a_"+id).val();
            var cut_ilo_a = $("#cut_ilo_a_"+id).val();
            var cut_dlo_b = $("#cut_dlo_b_"+id).val();
            var final222 = parseFloat(cut_dlo_a)+parseFloat(cut_ilo_a)+parseFloat(cut_dlo_b);
            var final222 = parseFloat(final222).toFixed(2);
            $("#cut_toh_"+id).val(final222);

            var cut_t_oh = $("#cut_t_oh_"+id).val();
            var cut_toh = $("#cut_toh_"+id).val();
            var final2222 = parseFloat(cut_toh) - parseFloat(cut_t_oh);
            var final2222 = parseFloat(final2222).toFixed(2);
            $("#cut_uaOh_"+id).val(final2222);
        }
        $('#StrengthDisp3').delay(4000).fadeOut(600); 
    });
</script>
@endsection