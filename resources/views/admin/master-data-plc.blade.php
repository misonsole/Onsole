@extends( (Auth::user()->id == "2") ? 'layouts.admin-layout' : 'layouts.user-layout')
@section('content')
<?php
	$id = Auth::user()->id;
	$UserDetail = DB::table("users")->where("id", $id)->pluck('userrole');
	$UserDetail1 = DB::table("newroles")->where("name", $UserDetail)->get();
	$obj = json_decode (json_encode ($UserDetail1), FALSE);
    $storeData = [];
    foreach($obj as $dataa){
        $storeData[$dataa->role_name] = $dataa->value; 
    }
    // print_r($storeData);
?>
<style>
    .displayBadge{
        display: none; 
        text-align :center;
    }
    .displayBadges{
        text-align :center;
    }
    .toggle{
        background: none;
        border: none;
        color: grey;
        font-weight: 400;
        position: absolute;
        right: 1.30em;
        top: 2.85em;
        z-index: 9;
    }
    .fa{
        font-size: 1.1rem;
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
    .yourclass::-webkit-input-placeholder{
        color: #6c757d;
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
                        <li class="breadcrumb-item active">Master Data</li>
                    </ol>
                </div>
                <h4 class="page-title">Master Data</h4>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-lg-4 mb-5">
            <div class="card h-100">
                <div class="card-body p-5">
                    <div class="text-center mt-1">
                        <h3 class="py-3">Create Last</h3>
                    </div>
                    <form action="{{url('add-last')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-2">
                            <div class="col-sm-9">
                                <label><b style="color: #6c757d">Last Number</b></label>
                                <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="last" name="last" placeholder="Enter Last Number" required>
                            </div>
                            <div class="col-sm-3 py-4">
                                <button type="submit" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn py-2 btn-lg btn-block text-white">Add</button>
                            </div>
                        </div>
                    </form>
                    <div class="form-group row py-2 px-2">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped mb-0">
                                <thead class="thead-dark">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Last Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($last as $num)
                                    <tr class="text-center">
                                        <td>{{$a++}}</td>
                                        <td>{{$num['last_no']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row py-2">
                        <div class="col-sm-12">
                            <button data-toggle="modal" data-target="#exampleModalCenter" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white">View All</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-5">
            <div class="card h-100">
                <div class="card-body p-5">
                    <div class="text-center mt-1">
                        <h3 class="py-3">Create Shape</h3>
                    </div>
                    <form action="{{url('add-shape')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-2">
                            <div class="col-sm-9">
                                <label><b style="color: #6c757d">Shape</b></label>
                                <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="shape" name="shape" placeholder="Enter Shape" required>
                            </div>
                            <div class="col-sm-3 py-4">
                                <button type="submit" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn py-2 btn-lg btn-block text-white">Add</button>
                            </div>
                        </div>
                    </form>
                    <div class="form-group row py-2 px-2">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped mb-0">
                                <thead class="thead-dark">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Shape</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($shape as $num)
                                    <tr class="text-center">
                                        <td>{{$i++}}</td>
                                        <td>{{$num['description']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row py-2">
                        <div class="col-sm-12">
                            <button data-toggle="modal" data-target="#exampleModalCentershape" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white">View All</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-5">
            <div class="card h-100">
                <div class="card-body p-5">
                    <div class="text-center mt-1">
                        <h3 class="py-3">Create Sole</h3>
                    </div>
                    <form action="{{url('add-sole')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-2">
                            <div class="col-sm-9">
                                <label><b style="color: #6c757d">Sole</b></label>
                                <input type="text" class="form-control py-2 yourclass" style="border: 1px solid #bfbfbf;" id="sole" name="sole" placeholder="Enter Sole" required>
                            </div>
                            <div class="col-sm-3 py-4">
                                <button type="submit" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn py-2 btn-lg btn-block text-white">Add</button>
                            </div>
                        </div>
                    </form>
                    <div class="form-group row py-2 px-2">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped mb-0">
                                <thead class="thead-dark">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Sole</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sole as $num)
                                    <tr class="text-center">
                                        <td>{{$aaa++}}</td>
                                        <td>{{$num['description']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row py-2">
                        <div class="col-sm-12">
                            <button data-toggle="modal" data-target="#exampleModalCentersole" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white">View All</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2 mb-2">
        <div class="col-lg-4 mb-5">
            <div class="card h-100">
                <div class="card-body p-5">
                    <div class="text-center mt-1">
                        <h3 class="py-3">Create Location</h3>
                    </div>
                    <form action="{{url('add-location')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-2">
                            <div class="col-sm-9">
                                <label><b style="color: #6c757d">Location</b></label>
                                <input type="text" class="form-control py-0 yourclass" style="border: 1px solid #bfbfbf;" id="location" name="location" placeholder="Enter Location" required>
                            </div>
                            <div class="col-sm-3 py-4">
                                <button type="submit" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn py-2 btn-lg btn-block text-white">Add</button>
                            </div>
                        </div>
                    </form>
                    <div class="form-group row py-2 px-2">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped mb-0">
                                <thead class="thead-dark">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Location</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($location as $num)
                                    <tr class="text-center">
                                        <td>{{$z++}}</td>
                                        <td>{{$num['location_no']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row py-2">
                        <div class="col-sm-12">
                            <button data-toggle="modal" data-target="#exampleModalCenter1" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white">View All</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-5">
            <div class="card h-100">
                <div class="card-body p-5">
                    <div class="text-center mt-1">
                        <h3 class="py-3">Create Project</h3>
                    </div>
                    <form action="{{url('add-project')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-2">
                            <div class="col-sm-9">
                                <label><b style="color: #6c757d">Project</b></label>
                                <input type="text" class="form-control py-0 yourclass" style="border: 1px solid #bfbfbf;" id="project" name="project" placeholder="Enter Project" required>
                            </div>
                            <div class="col-sm-3 py-4">
                                <button type="submit" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn py-2 btn-lg btn-block text-white">Add</button>
                            </div>
                        </div>
                    </form>
                    <div class="form-group row py-2 px-2">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped mb-0">
                                <thead class="thead-dark">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Project</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($project as $num)
                                    <tr class="text-center">
                                        <td>{{$ccc++}}</td>
                                        <td>{{$num['description']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row py-2">
                        <div class="col-sm-12">
                            <button data-toggle="modal" data-target="#exampleModalCenterproject" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white">View All</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-5">
            <div class="card h-100">
                <div class="card-body p-5">
                    <div class="text-center mt-1">
                        <h3 class="py-3">Create Purpose</h3>
                    </div>
                    <form action="{{url('add-purpose')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-2">
                            <div class="col-sm-9">
                                <label><b style="color: #6c757d">Purpose</b></label>
                                <input type="text" class="form-control py-0 yourclass" style="border: 1px solid #bfbfbf;" id="purpose" name="purpose" placeholder="Enter Purpose" required>
                            </div>
                            <div class="col-sm-3 py-4">
                                <button type="submit" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn py-2 btn-lg btn-block text-white">Add</button>
                            </div>
                        </div>
                    </form>
                    <div class="form-group row py-2 px-2">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped mb-0">
                                <thead class="thead-dark">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Purpose</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purpose as $num)
                                    <tr class="text-center">
                                        <td>{{$g++}}</td>
                                        <td>{{$num['description']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row py-2">
                        <div class="col-sm-12">
                            <button data-toggle="modal" data-target="#exampleModalCenterpurpose" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white">View All</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2 mb-2">
        <div class="col-lg-4 mb-5">
            <div class="card h-100">
                <div class="card-body p-5">
                    <div class="text-center mt-1">
                        <h3 class="py-3">Create Range</h3>
                    </div>
                    <form action="{{url('add-range')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-2">
                            <div class="col-sm-9">
                                <label><b style="color: #6c757d">Range</b></label>
                                <input type="text" class="form-control py-0 yourclass" style="border: 1px solid #bfbfbf;" id="range" name="range" placeholder="Enter Range" required>
                            </div>
                            <div class="col-sm-3 py-4">
                                <button type="submit" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn py-2 btn-lg btn-block text-white">Add</button>
                            </div>
                        </div>
                    </form>
                    <div class="form-group row py-2 px-2">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped mb-0">
                                <thead class="thead-dark">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Range</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($range as $num)
                                    <tr class="text-center">
                                        <td>{{$f++}}</td>
                                        <td>{{$num['description']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row py-2">
                        <div class="col-sm-12">
                            <button data-toggle="modal" data-target="#exampleModalCenterRange" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white">View All</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-5">
            <div class="card h-100">
                <div class="card-body p-5">
                    <div class="text-center mt-1">
                        <h3 class="py-3">Create Category</h3>
                    </div>
                    <form action="{{url('add-category-plc')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-2">
                            <div class="col-sm-9">
                                <label><b style="color: #6c757d">Category</b></label>
                                <input type="text" class="form-control py-0 yourclass" style="border: 1px solid #bfbfbf;" id="category" name="category" placeholder="Enter Category" required>
                            </div>
                            <div class="col-sm-3 py-4">
                                <button type="submit" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn py-2 btn-lg btn-block text-white">Add</button>
                            </div>
                        </div>
                    </form>
                    <div class="form-group row py-2 px-2">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped mb-0">
                                <thead class="thead-dark">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Category</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categoryPlc as $num)
                                    <tr class="text-center">
                                        <td>{{$d++}}</td>
                                        <td>{{$num['description']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row py-2">
                        <div class="col-sm-12">
                            <button data-toggle="modal" data-target="#exampleModalCenterCat" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white">View All</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-5">
            <div class="card h-100">
                <div class="card-body p-5">
                    <div class="text-center mt-1">
                        <h3 class="py-3">Create Sub Category</h3>
                    </div>
                    <form action="{{url('add-sub-categoryy')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-2">
                            <div class="col-sm-12">
                                <label><b style="color: #6c757d">Category</b></label>
                                <select style="border: 1px solid #bfbfbf;" id="category" name="category" class="form-control select.custom-select" required>
                                    <option selected disabled>Select Category</option>                                            
                                    @foreach($categoryPlc as $name)
                                        <option value="{{ $name->id }}">{{ $name->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row py-2">
                            <div class="col-sm-9">
                                <label><b style="color: #6c757d">Sub Category</b></label>
                                <input type="text" class="form-control py-0 yourclass" style="border: 1px solid #bfbfbf;" id="subcategory" name="subcategory" placeholder="Enter Sub Category" required>
                            </div>
                            <div class="col-sm-3 py-4">
                                <button type="submit" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn py-2 btn-lg btn-block text-white">Add</button>
                            </div>
                        </div>
                    </form>
                    <div class="form-group row py-2 px-2">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped mb-0">
                                <thead class="thead-dark">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subcategory as $num)
                                    <tr class="text-center">
                                        <td>{{$k++}}</td>
                                        <td>{{$num['result']}}</td>
                                        <td>{{$num['data']['description']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row py-2">
                        <div class="col-sm-12">
                            <button data-toggle="modal" data-target="#exampleModalCenterSubCategory" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white">View All</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2 mb-5">
        <div class="col-lg-4 mb-5">
            <div class="card h-100">
                <div class="card-body p-5">
                    <div class="text-center mt-1">
                        <h3 class="py-3">Create Size Range</h3>
                    </div>
                    <form action="{{url('add-sizerange-plc')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-2">
                            <div class="col-sm-9">
                                <label><b style="color: #6c757d">Size Range</b></label>
                                <input type="text" class="form-control py-0 yourclass" style="border: 1px solid #bfbfbf;" id="sizerange" name="sizerange" placeholder="Enter Size Range" required>
                            </div>
                            <div class="col-sm-3 py-4">
                                <button type="submit" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn py-2 btn-lg btn-block text-white">Add</button>
                            </div>
                        </div>
                    </form>
                    <div class="form-group row py-2 px-2">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped mb-0">
                                <thead class="thead-dark">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Size Range</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sizerange as $num)
                                    <tr class="text-center">
                                        <td>{{$h++}}</td>
                                        <td>{{$num['description']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row py-2">
                        <div class="col-sm-12">
                            <button data-toggle="modal" data-target="#exampleModalCenterSizeRange" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white">View All</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-5">
            <div class="card h-100">
                <div class="card-body p-5">
                    <div class="text-center mt-1">
                        <h3 class="py-3">Create Division</h3>
                    </div>
                    <form action="{{url('add-division')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-2">
                            <div class="col-sm-9">
                                <label><b style="color: #6c757d">Division</b></label>
                                <input type="text" class="form-control py-0 yourclass" style="border: 1px solid #bfbfbf;" id="division" name="division" placeholder="Enter Division" required>
                            </div>
                            <div class="col-sm-3 py-4">
                                <button type="submit" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn py-2 btn-lg btn-block text-white">Add</button>
                            </div>
                        </div>
                    </form>
                    <div class="form-group row py-2 px-2">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped mb-0">
                                <thead class="thead-dark">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Division</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($divisionPlc as $num)
                                    <tr class="text-center">
                                        <td>{{$j++}}</td>
                                        <td>{{$num['description']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row py-2">
                        <div class="col-sm-12">
                            <button data-toggle="modal" data-target="#exampleModalCenterDivision" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white">View All</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-5">
            <div class="card h-100">
                <div class="card-body p-5">
                    <div class="text-center mt-1">
                        <h3 class="py-3">Create Sub Division</h3>
                    </div>
                    <form action="{{url('add-sub-division')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-2">
                            <div class="col-sm-12">
                                <label><b style="color: #6c757d">Divison</b></label>
                                <select style="border: 1px solid #bfbfbf;" id="division" name="division" class="form-control select.custom-select" required>
                                    <option selected disabled>Select Divison</option>                                            
                                    @foreach($divisionPlc as $name)
                                        <option value="{{ $name->id }}">{{ $name->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row py-2">
                            <div class="col-sm-9">
                                <label><b style="color: #6c757d">Sub Division</b></label>
                                <input type="text" class="form-control py-0 yourclass" style="border: 1px solid #bfbfbf;" id="subdivision" name="subdivision" placeholder="Enter Sub Division" required>
                            </div>
                            <div class="col-sm-3 py-4">
                                <button type="submit" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn py-2 btn-lg btn-block text-white">Add</button>
                            </div>
                        </div>
                    </form>
                    <div class="form-group row py-2 px-2">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped mb-0">
                                <thead class="thead-dark">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Division</th>
                                        <th>Sub Division</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subdivision as $num)
                                    <tr class="text-center">
                                        <td>{{$k++}}</td>
                                        <td>{{$num['result']}}</td>
                                        <td>{{$num['data']['description']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row py-2">
                        <div class="col-sm-12">
                            <button data-toggle="modal" data-target="#exampleModalCenterSubDivision" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white">View All</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2 mb-5">
        <div class="col-lg-4 mb-5">
            <div class="card h-100">
                <div class="card-body p-5">
                    <div class="text-center mt-1">
                        <h3 class="py-3">Create Type</h3>
                    </div>
                    <form action="{{url('add-type')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-2">
                            <div class="col-sm-9">
                                <label><b style="color: #6c757d">Type</b></label>
                                <input type="text" class="form-control py-0 yourclass" style="border: 1px solid #bfbfbf;" id="type" name="type" placeholder="Enter Type" required>
                            </div>
                            <div class="col-sm-3 py-4">
                                <button type="submit" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn py-2 btn-lg btn-block text-white">Add</button>
                            </div>
                        </div>
                    </form>
                    <div class="form-group row py-2 px-2">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped mb-0">
                                <thead class="thead-dark">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($type as $num)
                                    <tr class="text-center">
                                        <td>{{$m++}}</td>
                                        <td>{{$num['description']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row py-2">
                        <div class="col-sm-12">
                            <button data-toggle="modal" data-target="#exampleModalCenterSizeRange" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white">View All</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-5">
            <div class="card h-100">
                <div class="card-body p-5">
                    <div class="text-center mt-1">
                        <h3 class="py-3">Create Designer</h3>
                    </div>
                    <form action="{{url('add-designer')}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group row py-2">
                            <div class="col-sm-9">
                                <label><b style="color: #6c757d">Type</b></label>
                                <input type="text" class="form-control py-0 yourclass" style="border: 1px solid #bfbfbf;" id="designer" name="designer" placeholder="Enter Designer" required>
                            </div>
                            <div class="col-sm-3 py-4">
                                <button type="submit" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn py-2 btn-lg btn-block text-white">Add</button>
                            </div>
                        </div>
                    </form>
                    <div class="form-group row py-2 px-2">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped mb-0">
                                <thead class="thead-dark">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Designer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($designer as $num)
                                    <tr class="text-center">
                                        <td>{{$n++}}</td>
                                        <td>{{$num['description']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row py-2">
                        <div class="col-sm-12">
                            <button data-toggle="modal" data-target="#exampleModalCenterDesginer" style="margin-top: 5px; border: none; font-size: 15px; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6));" class="btn px-5 py-1 btn-lg btn-block text-white">View All</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
</div>
<div class="modal fade bd-example-modal-lg" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="exampleModalLongTitle">Last Numbers</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="datatable2" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                     <thead>
                        <tr>
                            <th>No</th>
                            <th>Last Number</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allLast as $num)
                        <tr>
                            <td class="py-0">{{$j++}}</td>
                            <td class="py-0"><input readonly class="form-control form-control-sm w-25 py-0 text-center" id="last{{$num['id']}}" style="border: none; background: transparent; margin-left: auto; margin-right: auto;" type="text" value="{{$num['last_no']}}"></td>
                            <td class="py-0">                                                       
                                <a data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Edit&nbsp;&nbsp;" data-id="{{$num['id']}}" class="mr-1 lastEdit" style="cursor: pointer;"><i class="fas fa-edit text-info font-13"></i></a>
                                <a hidden data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Delete&nbsp;&nbsp;" data-id="{{$num['id']}}" class="mr-1 lastDel" style="cursor: pointer;"><i class="fas fa-trash-alt text-danger font-13"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" style="box-shadow: none;" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="exampleModalCentershape" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="exampleModalLongTitle">Shape</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="row_callback" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Shape</th>
                            <th class="text-center">Action</th>
                            <th hidden></th>
                            <th hidden></th>
                            <th hidden></th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i=0; $i<$shapecount; $i++)
                        <tr>
                            <td class="text-center py-0">{{$aa++}}</td>
                            <td class="py-0"><input readonly class="form-control form-control-sm w-50 py-0 text-center" id="shape{{$Allshape[$i]['id']}}" style="border: none; background: transparent; margin-left: auto; margin-right: auto;" type="text" value="{{$Allshape[$i]['description']}}"></td>
                            <td hidden>Edinburgh</td>
                            <td hidden></td>
                            <td hidden></td>
                            <td class="py-0">                                                       
                                <a data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Edit&nbsp;&nbsp;" data-id="{{$Allshape[$i]['id']}}" class="mr-1 shapeEdit" style="cursor: pointer;"><i class="fas fa-edit text-info font-13"></i></a>
                                <a hidden data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Delete&nbsp;&nbsp;" data-id="{{$Allshape[$i]['id']}}" class="mr-1 shapeDel" style="cursor: pointer;"><i class="fas fa-trash-alt text-danger font-13"></i></a>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" style="box-shadow: none;" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="exampleModalCentersole" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="exampleModalLongTitle">Sole</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="row_callback" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Sole</th>
                            <th class="text-center">Action</th>
                            <th hidden></th>
                            <th hidden></th>
                            <th hidden></th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i=0; $i<$solecount; $i++)
                        <tr>
                            <td class="text-center py-0">{{$bb++}}</td>
                            <td class="py-0"><input readonly class="form-control form-control-sm w-50 py-0 text-center" id="sole{{$Allsole[$i]['id']}}" style="border: none; background: transparent; margin-left: auto; margin-right: auto;" type="text" value="{{$Allsole[$i]['description']}}"></td>
                            <td hidden>Edinburgh</td>
                            <td hidden></td>
                            <td hidden></td>
                            <td class="py-0">                                                       
                                <a data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Edit&nbsp;&nbsp;" data-id="{{$Allsole[$i]['id']}}" class="mr-1 soleEdit" style="cursor: pointer;"><i class="fas fa-edit text-info font-13"></i></a>
                                <a hidden data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Delete&nbsp;&nbsp;" data-id="{{$Allsole[$i]['id']}}" class="mr-1 soleDel" style="cursor: pointer;"><i class="fas fa-trash-alt text-danger font-13"></i></a>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" style="box-shadow: none;" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="exampleModalCenterproject" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="exampleModalLongTitle">Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="row_callback" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Project</th>
                            <th class="text-center">Action</th>
                            <th hidden></th>
                            <th hidden></th>
                            <th hidden></th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i=0; $i<$projectcount; $i++)
                        <tr>
                            <td class="text-center py-0">{{$cc++}}</td>
                            <td class="py-0"><input readonly class="form-control form-control-sm w-50 py-0 text-center" id="project{{$Allproject[$i]['id']}}" style="border: none; background: transparent; margin-left: auto; margin-right: auto;" type="text" value="{{$Allproject[$i]['description']}}"></td>
                            <td hidden>Edinburgh</td>
                            <td hidden></td>
                            <td hidden></td>
                            <td class="py-0">                                                       
                                <a data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Edit&nbsp;&nbsp;" data-id="{{$Allproject[$i]['id']}}" class="mr-1 projectEdit" style="cursor: pointer;"><i class="fas fa-edit text-info font-13"></i></a>
                                <a hidden data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Delete&nbsp;&nbsp;" data-id="{{$Allproject[$i]['id']}}" class="mr-1 projectDel" style="cursor: pointer;"><i class="fas fa-trash-alt text-danger font-13"></i></a>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" style="box-shadow: none;" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="exampleModalCenterpurpose" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="exampleModalLongTitle">Purpose</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="row_callback" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Purpose</th>
                            <th class="text-center">Action</th>
                            <th hidden></th>
                            <th hidden></th>
                            <th hidden></th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i=0; $i<$purposecount; $i++)
                        <tr>
                            <td class="text-center py-0">{{$ff++}}</td>
                            <td class="py-0"><input readonly class="form-control form-control-sm w-50 py-0 text-center" id="purpose{{$Allpurpose[$i]['id']}}" style="border: none; background: transparent; margin-left: auto; margin-right: auto;" type="text" value="{{$Allpurpose[$i]['description']}}"></td>
                            <td hidden>Edinburgh</td>
                            <td hidden></td>
                            <td hidden></td>
                            <td class="py-0">                                                       
                                <a data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Edit&nbsp;&nbsp;" data-id="{{$Allpurpose[$i]['id']}}" class="mr-1 purposeEdit" style="cursor: pointer;"><i class="fas fa-edit text-info font-13"></i></a>
                                <a hidden data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Delete&nbsp;&nbsp;" data-id="{{$Allpurpose[$i]['id']}}" class="mr-1 purposeDel" style="cursor: pointer;"><i class="fas fa-trash-alt text-danger font-13"></i></a>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" style="box-shadow: none;" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="exampleModalLongTitle">Locations</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="row_callback" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Locations</th>
                            <th class="text-center">Action</th>
                            <th hidden></th>
                            <th hidden></th>
                            <th hidden></th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i=0; $i<$locationcount; $i++)
                        <tr>
                            <td class="text-center py-0">{{$e++}}</td>
                            <td class="py-0"><input readonly class="form-control form-control-sm w-50 py-0 text-center" id="loc{{$Alllocation[$i]['id']}}" style="border: none; background: transparent; margin-left: auto; margin-right: auto;" type="text" value="{{$Alllocation[$i]['location_no']}}"></td>
                            <td hidden>Edinburgh</td>
                            <td hidden></td>
                            <td hidden></td>
                            <td class="py-0">                                                       
                                <a data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Edit&nbsp;&nbsp;" data-id="{{$Alllocation[$i]['id']}}" class="mr-1 locEdit" style="cursor: pointer;"><i class="fas fa-edit text-info font-13"></i></a>
                                <a hidden data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Delete&nbsp;&nbsp;" data-id="{{$Alllocation[$i]['id']}}" class="mr-1 locDel" style="cursor: pointer;"><i class="fas fa-trash-alt text-danger font-13"></i></a>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" style="box-shadow: none;" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="exampleModalCenterRange" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="exampleModalLongTitle">Range</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="row_callback" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Range</th>
                            <th class="text-center">Action</th>
                            <th hidden></th>
                            <th hidden></th>
                            <th hidden></th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i=0; $i<$rangecount; $i++)
                        <tr>
                            <td class="text-center py-0">{{$dd++}}</td>
                            <td class="py-0"><input readonly class="form-control form-control-sm w-50 py-0 text-center" id="range{{$Allrange[$i]['id']}}" style="border: none; background: transparent; margin-left: auto; margin-right: auto;" type="text" value="{{$Allrange[$i]['description']}}"></td>
                            <td hidden>Edinburgh</td>
                            <td hidden></td>
                            <td hidden></td>
                            <td class="py-0">                                                       
                                <a data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Edit&nbsp;&nbsp;" data-id="{{$Allrange[$i]['id']}}" class="mr-1 rangeEdit" style="cursor: pointer;"><i class="fas fa-edit text-info font-13"></i></a>
                                <a hidden data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Delete&nbsp;&nbsp;" data-id="{{$Allrange[$i]['id']}}" class="mr-1 rangeDel" style="cursor: pointer;"><i class="fas fa-trash-alt text-danger font-13"></i></a>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" style="box-shadow: none;" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="exampleModalCenterDivision" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="exampleModalLongTitle">Division</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="row_callback" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Division</th>
                            <th class="text-center">Action</th>
                            <th hidden></th>
                            <th hidden></th>
                            <th hidden></th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i=0; $i<$divisionPlccount; $i++)
                        <tr>
                            <td class="text-center py-0">{{$jj++}}</td>
                            <td class="py-0"><input readonly class="form-control form-control-sm w-50 py-0 text-center" id="division{{$AlldivisionPlc[$i]['id']}}" style="border: none; background: transparent; margin-left: auto; margin-right: auto;" type="text" value="{{$AlldivisionPlc[$i]['description']}}"></td>
                            <td hidden>Edinburgh</td>
                            <td hidden></td>
                            <td hidden></td>
                            <td class="py-0">                                                       
                                <a data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Edit&nbsp;&nbsp;" data-id="{{$AlldivisionPlc[$i]['id']}}" class="mr-1 divisionEdit" style="cursor: pointer;"><i class="fas fa-edit text-info font-13"></i></a>
                                <a hidden data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Delete&nbsp;&nbsp;" data-id="{{$AlldivisionPlc[$i]['id']}}" class="mr-1 divisionDel" style="cursor: pointer;"><i class="fas fa-trash-alt text-danger font-13"></i></a>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" style="box-shadow: none;" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="exampleModalCenterSubDivision" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="exampleModalLongTitle">Sub Division</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="row_callback" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Division</th>
                            <th class="text-center">Sub Division</th>
                            <th class="text-center">Action</th>
                            <th hidden></th>
                            <th hidden></th>
                            <th hidden></th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i=0; $i<$subdivisioncount; $i++)
                        <tr>
                            <td class="text-center py-0">{{$kk++}}</td>
                            <td class="py-0"><input readonly class="form-control form-control-sm py-0 text-center" style="border: none; background: transparent; margin-left: auto; margin-right: auto;" type="text" value="{{$Allsubdivision[$i]['result']}}"></td>
                            <td class="py-0"><input readonly class="form-control form-control-sm py-0 text-center" id="subdivision{{$Allsubdivision[$i]['data']['id']}}" style="border: none; background: transparent; margin-left: auto; margin-right: auto;" type="text" value="{{$Allsubdivision[$i]['data']['description']}}"></td>
                            <td hidden>Edinburgh</td>
                            <td hidden></td>
                            <td hidden></td>
                            <td class="py-0">                                                       
                                <a data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Edit&nbsp;&nbsp;" data-id="{{$Allsubdivision[$i]['data']['id']}}" class="mr-1 subdivisionEdit" style="cursor: pointer;"><i class="fas fa-edit text-info font-13"></i></a>
                                <a hidden data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Delete&nbsp;&nbsp;" data-id="{{$Allsubdivision[$i]['data']['id']}}" class="mr-1 subdivisionDel" style="cursor: pointer;"><i class="fas fa-trash-alt text-danger font-13"></i></a>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" style="box-shadow: none;" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="exampleModalCenterSubCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="exampleModalLongTitle">Sub Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="row_callback" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Sub Category</th>
                            <th class="text-center">Action</th>
                            <th hidden></th>
                            <th hidden></th>
                            <th hidden></th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i=0; $i<$subcategorycount; $i++)
                        <tr>
                            <td class="text-center py-0">{{$ll++}}</td>
                            <td class="py-0"><input readonly class="form-control form-control-sm py-0 text-center" style="border: none; background: transparent; margin-left: auto; margin-right: auto;" type="text" value="{{$Allsubcategory[$i]['result']}}"></td>
                            <td class="py-0"><input readonly class="form-control form-control-sm py-0 text-center" id="subcategory{{$Allsubcategory[$i]['data']['id']}}" style="border: none; background: transparent; margin-left: auto; margin-right: auto;" type="text" value="{{$Allsubcategory[$i]['data']['description']}}"></td>
                            <td hidden>Edinburgh</td>
                            <td hidden></td>
                            <td hidden></td>
                            <td class="py-0">                                                       
                                <a data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Edit&nbsp;&nbsp;" data-id="{{$Allsubcategory[$i]['data']['id']}}" class="mr-1 subcategoryEdit" style="cursor: pointer;"><i class="fas fa-edit text-info font-13"></i></a>
                                <a hidden data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Delete&nbsp;&nbsp;" data-id="{{$Allsubcategory[$i]['data']['id']}}" class="mr-1 subcategoryDel" style="cursor: pointer;"><i class="fas fa-trash-alt text-danger font-13"></i></a>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" style="box-shadow: none;" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="exampleModalCenterSizeRange" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="exampleModalLongTitle">Size Range</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="row_callback" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Size Range</th>
                            <th class="text-center">Action</th>
                            <th hidden></th>
                            <th hidden></th>
                            <th hidden></th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i=0; $i<$sizerangecount; $i++)
                        <tr>
                            <td class="text-center py-0">{{$hh++}}</td>
                            <td class="py-0"><input readonly class="form-control form-control-sm w-50 py-0 text-center" id="range{{$Allsizerange[$i]['id']}}" style="border: none; background: transparent; margin-left: auto; margin-right: auto;" type="text" value="{{$Allsizerange[$i]['description']}}"></td>
                            <td hidden>Edinburgh</td>
                            <td hidden></td>
                            <td hidden></td>
                            <td class="py-0">                                                       
                                <a data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Edit&nbsp;&nbsp;" data-id="{{$Allsizerange[$i]['id']}}" class="mr-1 sizerangeEdit" style="cursor: pointer;"><i class="fas fa-edit text-info font-13"></i></a>
                                <a hidden data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Delete&nbsp;&nbsp;" data-id="{{$Allsizerange[$i]['id']}}" class="mr-1 sizerangeDel" style="cursor: pointer;"><i class="fas fa-trash-alt text-danger font-13"></i></a>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" style="box-shadow: none;" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="exampleModalCenterDesginer" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="exampleModalLongTitle">Designer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="row_callback" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Designer</th>
                            <th class="text-center">Action</th>
                            <th hidden></th>
                            <th hidden></th>
                            <th hidden></th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i=0; $i<$designercount; $i++)
                        <tr>
                            <td class="text-center py-0">{{$nn++}}</td>
                            <td class="py-0"><input readonly class="form-control form-control-sm w-50 py-0 text-center" id="range{{$Alldesigner[$i]['id']}}" style="border: none; background: transparent; margin-left: auto; margin-right: auto;" type="text" value="{{$Alldesigner[$i]['description']}}"></td>
                            <td hidden>Edinburgh</td>
                            <td hidden></td>
                            <td hidden></td>
                            <td class="py-0">                                                       
                                <a data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Edit&nbsp;&nbsp;" data-id="{{$Alldesigner[$i]['id']}}" class="mr-1 desginerEdit" style="cursor: pointer;"><i class="fas fa-edit text-info font-13"></i></a>
                                <a hidden data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Delete&nbsp;&nbsp;" data-id="{{$Alldesigner[$i]['id']}}" class="mr-1 desginerDel" style="cursor: pointer;"><i class="fas fa-trash-alt text-danger font-13"></i></a>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" style="box-shadow: none;" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="exampleModalCenterCat" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header" style="background: none;">
                <h5 class="modal-title" id="exampleModalLongTitle">Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="row_callback" class="table dt-responsive nowrap text-center" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Action</th>
                            <th hidden></th>
                            <th hidden></th>
                            <th hidden></th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i=0; $i<$categoryPlccount; $i++)
                        <tr>
                            <td class="text-center py-0">{{$ee++}}</td>
                            <td class="py-0"><input readonly class="form-control form-control-sm w-50 py-0 text-center" id="cat{{$AllcategoryPlc[$i]['id']}}" style="border: none; background: transparent; margin-left: auto; margin-right: auto;" type="text" value="{{$AllcategoryPlc[$i]['description']}}"></td>
                            <td hidden>Edinburgh</td>
                            <td hidden></td>
                            <td hidden></td>
                            <td class="py-0">                                                       
                                <a data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Edit&nbsp;&nbsp;" data-id="{{$AllcategoryPlc[$i]['id']}}" class="mr-1 catEdit" style="cursor: pointer;"><i class="fas fa-edit text-info font-13"></i></a>
                                <a hidden data-toggle="tooltip" data-placement="top" title="&nbsp;&nbsp;Delete&nbsp;&nbsp;" data-id="{{$AllcategoryPlc[$i]['id']}}" class="mr-1 cateDel" style="cursor: pointer;"><i class="fas fa-trash-alt text-danger font-13"></i></a>
                            </td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
            <div class="modal-footer" style="background: none;">
                <button type="button" style="box-shadow: none;" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalCenter9" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{url('last')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group row py-2 text-center">
                    <div class="col-sm-12 mb-1 mb-sm-0">
                        <label for=""><h4 style="color: #6c757d">Edit Last</h4></label>
                        <input id="lastId" name="lastId" class="form-control py-0" type="text" hidden>
                        <input id="lastNum" name="lastNum" class="form-control py-0 text-center" type="text">
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center" style="background-color: transparent">
                <button type="submit" style="box-shadow: none;" class="btn btn-success">Update</button>
                <button type="button" style="box-shadow: none;" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalCenter9loc" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{url('location')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group row py-2 text-center">
                    <div class="col-sm-12 mb-1 mb-sm-0">
                        <label for=""><h4 style="color: #6c757d">Edit Location</h4></label>
                        <input id="locId" name="locId" class="form-control py-0" type="text" hidden>
                        <input id="locNum" name="locNum" class="form-control py-0 text-center" type="text">
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center" style="background-color: transparent">
                <button type="submit" style="box-shadow: none;" class="btn btn-success">Update</button>
                <button type="button" style="box-shadow: none;" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalCenter9shape" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{url('shape')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group row py-2 text-center">
                    <div class="col-sm-12 mb-1 mb-sm-0">
                        <label for=""><h4 style="color: #6c757d">Edit Shape</h4></label>
                        <input id="shapeId" name="shapeId" class="form-control py-0" type="text" hidden>
                        <input id="shapeNum" name="shapeNum" class="form-control py-0 text-center" type="text">
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center" style="background-color: transparent">
                <button type="submit" style="box-shadow: none;" class="btn btn-success">Update</button>
                <button type="button" style="box-shadow: none;" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalCenter9sole" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{url('sole')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group row py-2 text-center">
                    <div class="col-sm-12 mb-1 mb-sm-0">
                        <label for=""><h4 style="color: #6c757d">Edit Sole</h4></label>
                        <input id="soleId" name="soleId" class="form-control py-0" type="text" hidden>
                        <input id="soleNum" name="soleNum" class="form-control py-0 text-center" type="text">
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center" style="background-color: transparent">
                <button type="submit" style="box-shadow: none;" class="btn btn-success">Update</button>
                <button type="button" style="box-shadow: none;" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalCenter9project" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{url('project')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group row py-2 text-center">
                    <div class="col-sm-12 mb-1 mb-sm-0">
                        <label for=""><h4 style="color: #6c757d">Edit Project</h4></label>
                        <input id="projectId" name="projectId" class="form-control py-0" type="text" hidden>
                        <input id="projectNum" name="projectNum" class="form-control py-0 text-center" type="text">
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center" style="background-color: transparent">
                <button type="submit" style="box-shadow: none;" class="btn btn-success">Update</button>
                <button type="button" style="box-shadow: none;" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalCenter9purpose" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{url('purpose')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group row py-2 text-center">
                    <div class="col-sm-12 mb-1 mb-sm-0">
                        <label for=""><h4 style="color: #6c757d">Edit Purpose</h4></label>
                        <input id="purposeId" name="purposeId" class="form-control py-0" type="text" hidden>
                        <input id="purposeNum" name="purposeNum" class="form-control py-0 text-center" type="text">
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center" style="background-color: transparent">
                <button type="submit" style="box-shadow: none;" class="btn btn-success">Update</button>
                <button type="button" style="box-shadow: none;" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalCenter9Range" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{url('range')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group row py-2 text-center">
                    <div class="col-sm-12 mb-1 mb-sm-0">
                        <label for=""><h4 style="color: #6c757d">Edit Range</h4></label>
                        <input id="rangeId" name="rangeId" class="form-control py-0" type="text" hidden>
                        <input id="rangeNum" name="rangeNum" class="form-control py-0 text-center" type="text">
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center" style="background-color: transparent">
                <button type="submit" style="box-shadow: none;" class="btn btn-success">Update</button>
                <button type="button" style="box-shadow: none;" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalCenter9SizeRange" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{url('sizerange')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group row py-2 text-center">
                    <div class="col-sm-12 mb-1 mb-sm-0">
                        <label for=""><h4 style="color: #6c757d">Edit Size Range</h4></label>
                        <input id="sizerangeId" name="sizerangeId" class="form-control py-0" type="text" hidden>
                        <input id="sizerangeNum" name="sizerangeNum" class="form-control py-0 text-center" type="text">
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center" style="background-color: transparent">
                <button type="submit" style="box-shadow: none;" class="btn btn-success">Update</button>
                <button type="button" style="box-shadow: none;" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalCenter9Designer" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{url('designer')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group row py-2 text-center">
                    <div class="col-sm-12 mb-1 mb-sm-0">
                        <label for=""><h4 style="color: #6c757d">Edit Designer</h4></label>
                        <input id="designerId" name="designerId" class="form-control py-0" type="text" hidden>
                        <input id="designerNum" name="designerNum" class="form-control py-0 text-center" type="text">
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center" style="background-color: transparent">
                <button type="submit" style="box-shadow: none;" class="btn btn-success">Update</button>
                <button type="button" style="box-shadow: none;" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalCenter9Cat" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{url('cat')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group row py-2 text-center">
                    <div class="col-sm-12 mb-1 mb-sm-0">
                        <label for=""><h4 style="color: #6c757d">Edit Category</h4></label>
                        <input id="catId" name="catId" class="form-control py-0" type="text" hidden>
                        <input id="catNum" name="catNum" class="form-control py-0 text-center" type="text">
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center" style="background-color: transparent">
                <button type="submit" style="box-shadow: none;" class="btn btn-success">Update</button>
                <button type="button" style="box-shadow: none;" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalCenter9Division" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{url('division')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group row py-2 text-center">
                    <div class="col-sm-12 mb-1 mb-sm-0">
                        <label for=""><h4 style="color: #6c757d">Edit Division</h4></label>
                        <input id="divisionId" name="divisionId" class="form-control py-0" type="text" hidden>
                        <input id="divisionNum" name="divisionNum" class="form-control py-0 text-center" type="text">
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center" style="background-color: transparent">
                <button type="submit" style="box-shadow: none;" class="btn btn-success">Update</button>
                <button type="button" style="box-shadow: none;" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalCenter9SubDivision" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{url('subdivision')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group row py-2 text-center">
                    <div class="col-sm-12 mb-1 mb-sm-0">
                        <label for=""><h4 style="color: #6c757d">Edit Sub Division</h4></label>
                        <input id="subdivisionId" name="subdivisionId" class="form-control py-0" type="text" hidden>
                        <input id="subdivisionNum" name="subdivisionNum" class="form-control py-0 text-center" type="text">
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center" style="background-color: transparent">
                <button type="submit" style="box-shadow: none;" class="btn btn-success">Update</button>
                <button type="button" style="box-shadow: none;" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalCenter9SubCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{url('subcategory')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group row py-2 text-center">
                    <div class="col-sm-12 mb-1 mb-sm-0">
                        <label for=""><h4 style="color: #6c757d">Edit Sub Category</h4></label>
                        <input id="subcategoryId" name="subcategoryId" class="form-control py-0" type="text" hidden>
                        <input id="subcategoryNum" name="subcategoryNum" class="form-control py-0 text-center" type="text">
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center" style="background-color: transparent">
                <button type="submit" style="box-shadow: none;" class="btn btn-success">Update</button>
                <button type="button" style="box-shadow: none;" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script src="assets/js/customjquery.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script>
    //Last
    $(".lastEdit").click(function(){
        var id = $(this).attr("data-id");
        var last = $('#last'+id).val();
        $('#lastId').val(id);
        $('#lastNum').val(last);
        $('#exampleModalCenter9').modal('show');
        $('#exampleModalCenter').modal('hide');
    });
    $(".lastDel").click(function(){
        var id = $(this).attr("data-id");
        $.ajax({
                type: 'GET',
                url: 'lastdel/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                        });
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!',
                        });
                    }
                }
            })
    });

    //Division
    $(".divisionEdit").click(function(){
        var id = $(this).attr("data-id");
        var last = $('#division'+id).val();
        $('#divisionId').val(id);
        $('#divisionNum').val(last);
        $('#exampleModalCenter9Division').modal('show');
        $('#exampleModalCenterDivision').modal('hide');
    });
    $(".divisionDel").click(function(){
        var id = $(this).attr("data-id");
        $.ajax({
                type: 'GET',
                url: 'divisiondel/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                        });
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!',
                        });
                    }
                }
            })
    });

    //SubDivision
    $(".subdivisionEdit").click(function(){
        var id = $(this).attr("data-id");
        var last = $('#subdivision'+id).val();
        $('#subdivisionId').val(id);
        $('#subdivisionNum').val(last);
        $('#exampleModalCenter9SubDivision').modal('show');
        $('#exampleModalCenterSubDivision').modal('hide');
    });
    $(".subdivisionDel").click(function(){
        var id = $(this).attr("data-id");
        $.ajax({
                type: 'GET',
                url: 'subdivisiondel/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                        });
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!',
                        });
                    }
                }
            })
    });

    //SubCategory
    $(".subcategoryEdit").click(function(){
        var id = $(this).attr("data-id");
        var last = $('#subcategory'+id).val();
        console.log("Id, last");
        console.log(id, last);
        console.log("Id, last");
        $('#subcategoryId').val(id);
        $('#subcategoryNum').val(last);
        $('#exampleModalCenter9SubCategory').modal('show');
        $('#exampleModalCenterSubCategory').modal('hide');
    });
    $(".subcategoryDel").click(function(){
        var id = $(this).attr("data-id");
        $.ajax({
                type: 'GET',
                url: 'subcategorydel/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                        });
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!',
                        });
                    }
                }
            })
    });

    //Shape
    $(".shapeEdit").click(function(){
        var id = $(this).attr("data-id");
        var last = $('#shape'+id).val();
        $('#shapeId').val(id);
        $('#shapeNum').val(last);
        $('#exampleModalCenter9shape').modal('show');
        $('#exampleModalCentershape').modal('hide');
    });
    $(".shapeDel").click(function(){
        var id = $(this).attr("data-id");
        $.ajax({
                type: 'GET',
                url: 'shapedel/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                        });
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!',
                        });
                    }
                }
            })
    });

    //Range
    $(".rangeEdit").click(function(){
        var id = $(this).attr("data-id");
        var last = $('#range'+id).val();
        $('#rangeId').val(id);
        $('#rangeNum').val(last);
        $('#exampleModalCenter9Range').modal('show');
        $('#exampleModalCenterRange').modal('hide');
    });
    $(".rangeDel").click(function(){
        var id = $(this).attr("data-id");
        $.ajax({
                type: 'GET',
                url: 'rangedel/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                        });
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!',
                        });
                    }
                }
            })
    });

    //SizeRange
    $(".sizerangeEdit").click(function(){
        var id = $(this).attr("data-id");
        var last = $('#range'+id).val();
        $('#sizerangeId').val(id);
        $('#sizerangeNum').val(last);
        $('#exampleModalCenter9SizeRange').modal('show');
        $('#exampleModalCenterSizeRange').modal('hide');
    });
    $(".sizerangeDel").click(function(){
        var id = $(this).attr("data-id");
        $.ajax({
                type: 'GET',
                url: 'sizerangedel/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                        });
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!',
                        });
                    }
                }
            })
    });

    //Designer
    $(".desginerEdit").click(function(){
        var id = $(this).attr("data-id");
        var last = $('#designer'+id).val();
        $('#designerId').val(id);
        $('#designerNum').val(last);
        $('#exampleModalCenter9Designer').modal('show');
        $('#exampleModalCenterDesginer').modal('hide');
    });
    $(".desginerDel").click(function(){
        var id = $(this).attr("data-id");
        $.ajax({
                type: 'GET',
                url: 'desginerdel/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                        });
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!',
                        });
                    }
                }
            })
    });

    //Project
    $(".projectEdit").click(function(){
        var id = $(this).attr("data-id");
        var last = $('#project'+id).val();
        $('#projectId').val(id);
        $('#projectNum').val(last);
        $('#exampleModalCenter9project').modal('show');
        $('#exampleModalCenterproject').modal('hide');
    });
    $(".projectDel").click(function(){
        var id = $(this).attr("data-id");
        $.ajax({
                type: 'GET',
                url: 'purposedel/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                        });
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!',
                        });
                    }
                }
            })
    });

    //Purpose
    $(".purposeEdit").click(function(){
        var id = $(this).attr("data-id");
        var last = $('#purpose'+id).val();
        $('#purposeId').val(id);
        $('#purposeNum').val(last);
        $('#exampleModalCenter9purpose').modal('show');
        $('#exampleModalCenterpurpose').modal('hide');
    });
    $(".projectDel").click(function(){
        var id = $(this).attr("data-id");
        $.ajax({
                type: 'GET',
                url: 'projectdel/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                        });
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!',
                        });
                    }
                }
            })
    });

    //Sole
    $(".soleEdit").click(function(){
        var id = $(this).attr("data-id");
        var last = $('#sole'+id).val();
        $('#soleId').val(id);
        $('#soleNum').val(last);
        $('#exampleModalCenter9sole').modal('show');
        $('#exampleModalCentersole').modal('hide');
    });
    $(".soleDel").click(function(){
        var id = $(this).attr("data-id");
        $.ajax({
                type: 'GET',
                url: 'shapedel/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                        });
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!',
                        });
                    }
                }
            })
    });

    //Loc
    $(".locEdit").click(function(){
        var id = $(this).attr("data-id");
        var last = $('#loc'+id).val();
        $('#locId').val(id);
        $('#locNum').val(last);
        $('#exampleModalCenter9loc').modal('show');
        $('#exampleModalCenter1').modal('hide');
    });
    $(".locDel").click(function(){
        var id = $(this).attr("data-id");
        $.ajax({
                type: 'GET',
                url: 'locdel/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                        });
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!',
                        });
                    }
                }
            })
    });

    //Cat
    $(".catEdit").click(function(){
        var id = $(this).attr("data-id");
        var last = $('#cat'+id).val();
        $('#catId').val(id);
        $('#catNum').val(last);
        $('#exampleModalCenter9Cat').modal('show');
        $('#exampleModalCenterCat').modal('hide');
    });
    $(".catDel").click(function(){
        var id = $(this).attr("data-id");
        $.ajax({
                type: 'GET',
                url: 'catdel/'+id,
                dataType: "json",
                success: function(data){
                    if(data == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                        });
                        location.reload();
                    }
                    else if(data == 400){
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong!',
                        });
                    }
                }
            })
    });
</script>
<script>     
    $(document).ready(function(){ 
        $("#loader1").fadeOut(1200);
    });
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
        });
        break;
    }
@endif
</script>
@endsection