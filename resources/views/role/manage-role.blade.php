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
</style>
<div id="loader1" class="rotate" width="100" height="100"></div>
<div class="container-fluid px-5">
    <div class="row px-1">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a  href="{{url('home')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Manage Role</li>
                    </ol>
                </div>
                <h4 class="page-title">Manage Role</h4>
            </div>
        </div>
    </div>
    <div class="row mt-3">
		<div class="col-md-12 col-xl-12" style="margin: 0 auto;">
			<div class="card">
				<div class="card-body h-100">
					<div class="text-center mt-5">
						<h2 style="color: #6c757d">Manage Role</h2>
					</div>
                    <form action="{{url('roles-manage-ajax')}}" id="NewRole" method="post" enctype="multipart/form-data">
                        @csrf
                            <div class="px-5 mt-5">
						        <div class="form-group row py-2">
                                    <div class="col-sm-3 mb-1 mb-sm-0">
                                        <label for=""><b style="color: #6c757d"> Role Name</b></label>
                                            @if(isset($id))
                                                <input type="text" name="id" value="{{$id}}" id="id" hidden>
                                            @endif
                                            <select id="name" name="name" class="form-control select.custom-select" required>
                                            @foreach($data as $name)
                                                <option value="{{ $name->name }}">{{ $name->name }}</option>
                                            @endforeach
                                            </select>
                                            <button id="btnSupdate" type="submit" class="btn w-100 py-1 mb-0 text-white mt-4" style="background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); border: none; font-size: 15px; display: none;">Update Role</button>
                                    </div>
                                    <input hidden type="text" name="username" id="username">
                                    <div class="col-sm-9">
                                        <label for=""> <b style="color: #6c757d"> Permissions</b></label>
                                        <label for="" id="id" hidden></label>
                                        <input class="form-check-input name d-none" type="checkbox" value="objective-delete" id="delete" name="objective-delete" >
                                        <label for="" id="idd"></label>
                                        <div id="accordion">
                                            <div id="Hides">
                                                <div class="card">
                                                    <div class="card-header collapsed py-2 text-white text-center" style="border: none; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); cursor: pointer; border-radius: 4px;" id="headingOne12">
                                                        Permissions
                                                    </div>
                                                </div>
                                            </div>    
                                            <div id="roles" style="display: none;">
                                                <div class="card">
                                                    <div class="card-header collapsed py-2 text-white text-center" style="border: none; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); cursor: pointer; border-radius: 4px;" id="headingOne1" data-toggle="collapse" data-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne">
                                                        Roles
                                                    </div>
                                                    <div id="collapseOne1" class="collapse" aria-labelledby="headingOne1" data-parent="#accordion" style="border: 0.5px solid #96a3b3;">
                                                        <div class="card-body">
                                                            <label class="form-check form-check-inline" id="role1" style="display: none;">
                                                                <input class="form-check-input name Singlecheck1 checkbox-info" id="rolelist1" type="checkbox" name="Role[]">
                                                                <span id="rolelist" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="role2" style="display: none;">
                                                                <input class="form-check-input name Singlecheck1 checkbox-info" id="rolecreate1" type="checkbox" name="Role[]">
                                                                <span id="rolecreate" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="role3" style="display: none;">
                                                                <input class="form-check-input name Singlecheck1 checkbox-info" id="roleedit1" type="checkbox" name="Role[]">
                                                                <span id="roleedit" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="role4" style="display: none;">  
                                                                <input class="form-check-input name Singlecheck1 checkbox-dark" id="roledelete1" type="checkbox" name="Role[]">
                                                                <span id="roledelete" class="form-check-label"></span>
                                                            </label>                            
                                                            <label class="form-check form-check-inline" style="float: right;">
                                                                <input class="form-check-input checkbox-info" id="allCheck1" type="checkbox">
                                                                <span class="form-check-label">Mark All</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                            
                                            <div id="Objectives" style="display: none;">
                                                <div class="card">
                                                    <div class="card-header collapsed py-2 text-white text-center" style="border: none; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); cursor: pointer; border-radius: 4px;" id="headingOne12" data-toggle="collapse" data-target="#collapseOne12" aria-expanded="true" aria-controls="collapseOne">
                                                        Objectives
                                                    </div>
                                                    <div id="collapseOne12" class="collapse" aria-labelledby="headingOne12" data-parent="#accordion" style="border: 0.5px solid #96a3b3;">
                                                        <div class="card-body">
                                                            <label class="form-check form-check-inline" id="obj1">
                                                                <input class="form-check-input name Singlecheck2" id="objlist1" type="checkbox" name="Objective[]">
                                                                <span id="objlist" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="obj2">
                                                                <input class="form-check-input name Singlecheck2" id="objcreate1" type="checkbox" name="Objective[]">
                                                                <span id="objcreate" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="obj3" style="display: none;">
                                                                <input class="form-check-input name Singlecheck2" id="objedit1" type="checkbox" name="Objective[]">
                                                                <span id="objedit" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="obj4" style="display: none;">
                                                                <input class="form-check-input name Singlecheck2" id="objdelete1" type="checkbox" name="Objective[]">
                                                                <span id="objdelete" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="obj5" style="display: none;">
                                                                <input class="form-check-input name Singlecheck2" id="objstatus1" type="checkbox" name="Objective[]">
                                                                <span id="objstatus" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="obj6" style="display: none;">
                                                                <input class="form-check-input name Singlecheck2" id="objrevision1" type="checkbox" name="Objective[]">
                                                                <span id="objrevision" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="obj7" style="display: none;">
                                                                <input class="form-check-input name Singlecheck2" id="objdirector1" type="checkbox" name="Objective[]">
                                                                <span id="objdirector" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" style="float: right;">
                                                                <input class="form-check-input" id="allCheck2" type="checkbox">
                                                                <span class="form-check-label">Mark All</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="Users" style="display: none;">
                                                <div class="card">
                                                    <div class="card-header collapsed py-2 text-white text-center" style="border: none; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); cursor: pointer; border-radius: 4px;" id="headingOne122" data-toggle="collapse" data-target="#collapseOne122" aria-expanded="true" aria-controls="collapseOne">
                                                        Users
                                                    </div>
                                                    <div id="collapseOne122" class="collapse" aria-labelledby="headingOne122" data-parent="#accordion" style="border: 0.5px solid #96a3b3;">
                                                        <div class="card-body">
                                                            <label class="form-check form-check-inline" id="user1" style="display: none;">
                                                                <input class="form-check-input name Singlecheck22" id="userlist1" type="checkbox" name="User[]">
                                                                <span id="userlist" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="user2" style="display: none;">
                                                                <input class="form-check-input name Singlecheck22" id="usercreate1" type="checkbox" name="User[]">
                                                                <span id="usercreate" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="user3" style="display: none;">
                                                                <input class="form-check-input name Singlecheck22" id="useredit1" type="checkbox" name="User[]">
                                                                <span id="useredit" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="user4" style="display: none;">
                                                                <input class="form-check-input name Singlecheck22" id="userdelete1" type="checkbox" name="User[]">
                                                                <span id="userdelete" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" style="float: right;">
                                                                <input class="form-check-input" id="allCheck22" type="checkbox">
                                                                <span class="form-check-label">Mark All</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="joborder" style="display: none;">
                                                <div class="card">
                                                    <div class="card-header collapsed py-2 text-white text-center" style="border: none; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); cursor: pointer; border-radius: 4px;" id="headingOne1221" data-toggle="collapse" data-target="#collapseOne1221" aria-expanded="true" aria-controls="collapseOne">
                                                        Product Life Cycle
                                                    </div>
                                                    <div id="collapseOne1221" class="collapse" aria-labelledby="headingOne122" data-parent="#accordion" style="border: 0.5px solid #96a3b3;">
                                                        <div class="card-body">
                                                            <label class="form-check form-check-inline" id="plc1" style="display: none;">
                                                                <input class="form-check-input name Singlecheck221" id="joblist1" type="checkbox" name="JobOrder[]">
                                                                <span id="joblist" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="plc2" style="display: none;">
                                                                <input class="form-check-input name Singlecheck221" id="jobcreate1" type="checkbox" name="JobOrder[]">
                                                                <span id="jobcreate" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="plc3" style="display: none;">
                                                                <input class="form-check-input name Singlecheck221" id="jobedit1" type="checkbox" name="JobOrder[]">
                                                                <span id="jobedit" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="plc4" style="display: none;">
                                                                <input class="form-check-input name Singlecheck221" id="jobdelete1" type="checkbox" name="JobOrder[]">
                                                                <span id="jobdelete" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="plc5" style="display: none;">
                                                                <input class="form-check-input name Singlecheck221" id="jobtransfer1" type="checkbox" name="JobOrder[]">
                                                                <span id="jobtransfer" class="form-check-label"></span>
                                                            </label>
                                                            <br>
                                                            <label class="form-check form-check-inline" id="plc6" style="display: none;">
                                                                <input class="form-check-input name Singlecheck221" id="pricinglist1" type="checkbox" name="JobOrder[]">
                                                                <span id="pricinglist" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="plc7" style="display: none;">
                                                                <input class="form-check-input name Singlecheck221" id="pricingcreate1" type="checkbox" name="JobOrder[]">
                                                                <span id="pricingcreate" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="plc8" style="display: none;">
                                                                <input class="form-check-input name Singlecheck221" id="pricingedit1" type="checkbox" name="JobOrder[]">
                                                                <span id="pricingedit" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="plc9" style="display: none;">  
                                                                <input class="form-check-input name Singlecheck221" id="pricingdelete1" type="checkbox" name="JobOrder[]">
                                                                <span id="pricingdelete" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="plc10" style="display: none;">
                                                                <input class="form-check-input name Singlecheck221" id="pricingtransfer1" type="checkbox" name="JobOrder[]">
                                                                <span id="pricingtransfer" class="form-check-label"></span>
                                                            </label>
                                                            <br>
                                                            <label class="form-check form-check-inline" id="plc11" style="display: none;">
                                                                <input class="form-check-input name Singlecheck221" id="pricingcosting1" type="checkbox" name="JobOrder[]">
                                                                <span id="pricingcosting" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="plc12" style="display: none;">
                                                                <input class="form-check-input name Singlecheck221" id="pricingsales1" type="checkbox" name="JobOrder[]">
                                                                <span id="pricingsales" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="plc13" style="display: none;">
                                                                <input class="form-check-input name Singlecheck221" id="pricingproduction1" type="checkbox" name="JobOrder[]">
                                                                <span id="pricingproduction" class="form-check-label"></span>
                                                            </label>                                                            
                                                            <br>
                                                            <label class="form-check form-check-inline" id="plc14" style="display: none;">
                                                                <input class="form-check-input name Singlecheck221" id="pdlmasterdata1" type="checkbox" name="JobOrder[]">
                                                                <span id="pdlmasterdata" class="form-check-label"></span>
                                                            </label>
                                                            <br>
                                                            <label class="form-check form-check-inline" id="plc15" style="display: none;">
                                                                <input class="form-check-input name Singlecheck221" id="formulalist1" type="checkbox" name="JobOrder[]">
                                                                <span id="formulalist" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="plc16" style="display: none;">
                                                                <input class="form-check-input name Singlecheck221" id="formulacreate1" type="checkbox" name="JobOrder[]">
                                                                <span id="formulacreate" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="plc17" style="display: none;">
                                                                <input class="form-check-input name Singlecheck221" id="formulaedit1" type="checkbox" name="JobOrder[]">
                                                                <span id="formulaedit" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="plc18" style="display: none;">
                                                                <input class="form-check-input name Singlecheck221" id="formuladelete1" type="checkbox" name="JobOrder[]">
                                                                <span id="formuladelete" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" style="float: right;">
                                                                <input class="form-check-input" id="allCheck221" type="checkbox">
                                                                <span class="form-check-label">Mark All</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="others" style="display: none;">
                                                <div class="card">
                                                    <div class="card-header collapsed py-2 text-white text-center" style="border: none; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); cursor: pointer; border-radius: 4px;" id="headingOne12211a" data-toggle="collapse" data-target="#headingOne12211" aria-expanded="true" aria-controls="collapseOne">
                                                        Others
                                                    </div>
                                                    <div id="headingOne12211" class="collapse" aria-labelledby="headingOne12211a" data-parent="#accordion" style="border: 0.5px solid #96a3b3;">
                                                        <div class="card-body">
                                                            <label class="form-check form-check-inline" id="other1" style="display: none;">
                                                                <input class="form-check-input name Singlecheck221a" id="attendance1" type="checkbox" name="Others[]">
                                                                <span id="attendance" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="other2" style="display: none;">
                                                                <input class="form-check-input name Singlecheck221a" id="complaint1" type="checkbox" name="Others[]">
                                                                <span id="complaint" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="other3" style="display: none;">
                                                                <input class="form-check-input name Singlecheck221a" id="qc1" type="checkbox" name="Others[]">
                                                                <span id="qc" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="other4" style="display: none;"> 
                                                                <input class="form-check-input name Singlecheck221a" id="ppc1" type="checkbox" name="Others[]">
                                                                <span id="ppc" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="other5" style="display: none;">
                                                                <input class="form-check-input name Singlecheck221a" id="superadmin1" type="checkbox" name="Others[]">
                                                                <span id="superadmin" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" style="float: right;">
                                                                <input class="form-check-input" id="allCheck221a" type="checkbox">
                                                                <span class="form-check-label">Mark All</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="reports" style="display: none;">
                                                <div class="card">
                                                    <div class="card-header collapsed py-2 text-white text-center" style="border: none; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); cursor: pointer; border-radius: 4px;" id="headingOne12211azz" data-toggle="collapse" data-target="#headingOne12211ss" aria-expanded="true" aria-controls="collapseOne">
                                                        Reports
                                                    </div>
                                                    <div id="headingOne12211ss" class="collapse" aria-labelledby="headingOne12211azz" data-parent="#accordion" style="border: 0.5px solid #96a3b3;">
                                                        <div class="card-body">
                                                            <label class="form-check form-check-inline" id="report1" style="display: none;">
                                                                <input class="form-check-input name reportCheck" id="rma1" type="checkbox" name="Reports[]">
                                                                <span id="rma" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="report2" style="display: none;">
                                                                <input class="form-check-input name reportCheck" id="salesissue1" type="checkbox" name="Reports[]">
                                                                <span id="salesissue" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="report3" style="display: none;">
                                                                <input class="form-check-input name reportCheck" id="itemadjustment1" type="checkbox" name="Reports[]">
                                                                <span id="itemadjustment" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="report4" style="display: none;">
                                                                <input class="form-check-input name reportCheck" id="hepldesk1r" type="checkbox" name="Reports[]">
                                                                <span id="hepldeskr" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="report5" style="display: none;">
                                                                <input class="form-check-input name reportCheck" id="joborderr1" type="checkbox" name="Reports[]">
                                                                <span id="joborderr" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="report6" style="display: none;">
                                                                <input class="form-check-input name reportCheck" id="joborderj1" type="checkbox" name="Reports[]">
                                                                <span id="joborderj" class="form-check-label"></span>
                                                            </label>
                                                            <br>
                                                            <label class="form-check form-check-inline" id="report7" style="display: none;">
                                                                <input class="form-check-input name reportCheck" id="salesorder1" type="checkbox" name="Reports[]">
                                                                <span id="salesorder" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="report8" style="display: none;">
                                                                <input class="form-check-input name reportCheck" id="transferissue1" type="checkbox" name="Reports[]">
                                                                <span id="transferissue" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="report9" style="display: none;">
                                                                <input class="form-check-input name reportCheck" id="itempurchase1" type="checkbox" name="Reports[]">
                                                                <span id="itempurchase" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="report10" style="display: none;">
                                                                <input class="form-check-input name reportCheck" id="purchaserate1" type="checkbox" name="Reports[]">
                                                                <span id="purchaserate" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="report11" style="display: none;">
                                                                <input class="form-check-input name reportCheck" id="mtransfer1" type="checkbox" name="Reports[]">
                                                                <span id="mtransfer" class="form-check-label"></span>
                                                            </label>
                                                            <br>
                                                            <label class="form-check form-check-inline" id="report12" style="display: none;">
                                                                <input class="form-check-input name reportCheck" id="materialc1" type="checkbox" name="Reports[]">
                                                                <span id="materialc" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="report13" style="display: none;">
                                                                <input class="form-check-input name reportCheck" id="purchaseorder1" type="checkbox" name="Reports[]">
                                                                <span id="purchaseorder" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="report14" style="display: none;">
                                                                <input class="form-check-input name reportCheck" id="consumptione1" type="checkbox" name="Reports[]">
                                                                <span id="consumptione" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="report15" style="display: none;">
                                                                <input class="form-check-input name reportCheck" id="purchaseinovie1" type="checkbox" name="Reports[]">
                                                                <span id="purchaseinovie" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" id="report16" style="display: none;">
                                                                <input class="form-check-input name reportCheck" id="workorderitem1" type="checkbox" name="Reports[]">
                                                                <span id="workorderitem" class="form-check-label"></span>
                                                            </label>
                                                            <br>
                                                            <label class="form-check form-check-inline" id="report17" style="display: none;">
                                                                <input class="form-check-input name reportCheck" id="consumptionc1" type="checkbox" name="Reports[]">
                                                                <span id="consumptionc" class="form-check-label"></span>
                                                            </label>
                                                            <label class="form-check form-check-inline" style="float: right;">
                                                                <input class="form-check-input" id="allReport" type="checkbox">
                                                                <span class="form-check-label">Mark All</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
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
    });                                                                         
    $('#name').on('change', function(){
        var name = $(this).val();
        $("#username").val(name);
        myFunction1(name);
    }); 
                
    function myFunction1(name){
        $.ajax({
        type: 'GET',
        url: 'ajax/' + name,
        dataType: "json",
        success: function (data){
            if(data){
                console.log(data);

                //Report
                if(data[0].reports.length === 0){
                    $("#rma").html("RMA Report");
                    $("#rma1").attr('value', "RMA Report");
                    $("#salesissue").html("Sales Issue");
                    $("#salesissue1").attr('value', "Sales Issue");
                    $("#itemadjustment").html("Item Adjustment");
                    $("#itemadjustment1").attr('value', "Item Adjustment");
                    $("#hepldeskr").html("Help Desk Report");
                    $("#hepldeskr1").attr('value', "Help Desk Report");
                    $("#joborderr").html("Job Order Report");
                    $("#joborderr1").attr('value', "Job Order Report");
                    $("#joborderj").html("Job Order Journey");
                    $("#joborderj1").attr('value', "Job Order Journey");

                    $("#salesorder").html("Sales Order Report");
                    $("#salesorder1").attr('value', "Sales Order Report");
                    $("#transferissue").html("Transfer Issue Report");
                    $("#transferissue1").attr('value', "Transfer Issue Report");
                    $("#itempurchase").html("Item Purchase Report");
                    $("#itempurchase1").attr('value', "Item Purchase Report");
                    $("#purchaserate").html("Purchase Rate History");
                    $("#purchaserate1").attr('value', "Purchase Rate History");
                    $("#mtransfer").html("M Transfer Against JO");
                    $("#mtransfer1").attr('value', "M Transfer Against JO");

                    $("#materialc").html("Material Consumption");
                    $("#materialc1").attr('value', "Material Consumption");
                    $("#purchaseorder").html("Purchase Order Report");
                    $("#purchaseorder1").attr('value', "Purchase Order Report");
                    $("#consumptione").html("Consumption Expection");
                    $("#consumptione1").attr('value', "Consumption Expection");
                    $("#purchaseinovie").html("Purchase Invoice Report");
                    $("#purchaseinovie1").attr('value', "Purchase Invoice Report");
                    $("#workorderitem").html("Work Order Item Costing");
                    $("#workorderitem1").attr('value', "Work Order Item Costing");

                    $("#consumptionc").html("Consumption Comparison");
                    $("#consumptionc1").attr('value', "Consumption Comparison");
                    $("#reports").show();
                }
                else{
                    if(data[0].reports[0]){
                        $("#report1").show();
                        $("#rma").html(data[0].reports[0].role_name);
                        $("#rma1").attr('value', data[0].reports[0].role_name);
                        if(data[0].reports[0].value == 1){
                            $("#rma1").attr('checked', true);
                        }
                        else{
                            $("#rma1").attr('checked', false);
                        } 
                    }
                    else{
                        $("#report1").show();
                        $("#rma").html("RMA Report");
                        $("#rma1").attr('value', "RMA Report");
                        $("#rma1").attr('checked', false);
                    }
                    if(data[0].reports[1]){
                        $("#report2").show();
                        $("#salesissue").html(data[0].reports[1].role_name);
                        $("#salesissue1").attr('value', data[0].reports[1].role_name);
                        if(data[0].reports[1].value == 1){
                            $("#salesissue1").attr('checked', true);
                        }
                        else{
                            $("#salesissue1").attr('checked', false);
                        } 
                    }
                    else{
                        $("#report2").show();
                        $("#salesissue1").html("Sales Issue");
                        $("#salesissue1").attr('value', "Sales Issue");
                        $("#salesissue1").attr('checked', false);
                    }
                    if(data[0].reports[2]){
                        $("#report3").show();
                        $("#itemadjustment").html(data[0].reports[2].role_name);
                        $("#itemadjustment1").attr('value', data[0].reports[2].role_name);
                        if(data[0].reports[2].value == 1){
                            $("#itemadjustment1").attr('checked', true);
                        }
                        else{
                            $("#itemadjustment1").attr('checked', false);
                        } 
                    }
                    else{
                        $("#report3").show();
                        $("#itemadjustment").html("Item Adjustment");
                        $("#itemadjustment1").attr('value', "Item Adjustment");
                        $("#itemadjustment1").attr('checked', false);
                    }
                    if(data[0].reports[3]){
                        $("#report4").show();
                        $("#hepldeskr").html(data[0].reports[3].role_name);
                        $("#hepldeskr1").attr('value', data[0].reports[3].role_name);
                        if(data[0].reports[3].value == 1){
                            $("#hepldeskr1").attr('checked', true);
                        }
                        else{
                            $("#hepldeskr1").attr('checked', false);
                        } 
                    }
                    else{
                        $("#report4").show();
                        $("#hepldeskr").html("Help Desk Report");
                        $("#hepldeskr1").attr('value', "Help Desk Report");
                        $("#hepldeskr1").attr('checked', false);
                    }
                    if(data[0].reports[4]){
                        $("#report5").show();
                        $("#joborderr").html(data[0].reports[4].role_name);
                        $("#joborderr1").attr('value', data[0].reports[4].role_name);
                        if(data[0].reports[4].value == 1){
                            $("#joborderr1").attr('checked', true);
                        }
                        else{
                            $("#joborderr1").attr('checked', false);
                        } 
                    }
                    else{
                        $("#report5").show();
                        $("#joborderr").html("Job Order Report");
                        $("#joborderr1").attr('value', "Job Order Report");
                        $("#joborderr1").attr('checked', false);
                    }
                    if(data[0].reports[5]){
                        $("#report6").show();
                        $("#joborderj").html(data[0].reports[5].role_name);
                        $("#joborderj1").attr('value', data[0].reports[5].role_name);
                        if(data[0].reports[5].value == 1){
                            $("#joborderj1").attr('checked', true);
                        }
                        else{
                            $("#joborderj1").attr('checked', false);
                        } 
                    }
                    else{
                        $("#report6").show();
                        $("#joborderj").html("Job Order Journey");
                        $("#joborderj1").attr('value', "Job Order Journey");
                        $("#joborderj1").attr('checked', false);
                    }
                    if(data[0].reports[6]){
                        $("#report7").show();
                        $("#salesorder").html(data[0].reports[6].role_name);
                        $("#salesorder1").attr('value', data[0].reports[6].role_name);
                        if(data[0].reports[6].value == 1){
                            $("#salesorder1").attr('checked', true);
                        }
                        else{
                            $("#salesorder1").attr('checked', false);
                        } 
                    }
                    else{
                        $("#report7").show();
                        $("#salesorder").html("Material Consumption");
                        $("#salesorder1").attr('value', "Material Consumption");
                        $("#salesorder1").attr('checked', false);
                    }
                    if(data[0].reports[7]){
                        $("#report8").show();
                        $("#transferissue").html(data[0].reports[7].role_name);
                        $("#transferissue1").attr('value', data[0].reports[7].role_name);
                        if(data[0].reports[7].value == 1){
                            $("#transferissue1").attr('checked', true);
                        }
                        else{
                            $("#transferissue1").attr('checked', false);
                        } 
                    }
                    else{
                        $("#report8").show();
                        $("#transferissue").html("Transfer Issue Report");
                        $("#transferissue1").attr('value', "Transfer Issue Report");
                        $("#transferissue1").attr('checked', false);
                    }
                    if(data[0].reports[8]){
                        $("#report9").show();
                        $("#itempurchase").html(data[0].reports[8].role_name);
                        $("#itempurchase1").attr('value', data[0].reports[8].role_name);
                        if(data[0].reports[8].value == 1){
                            $("#itempurchase1").attr('checked', true);
                        }
                        else{
                            $("#itempurchase1").attr('checked', false);
                        } 
                    }
                    else{
                        $("#report9").show();
                        $("#itempurchase").html("Item Purchase Report");
                        $("#itempurchase1").attr('value', "Item Purchase Report");
                        $("#itempurchase1").attr('checked', false);
                    }
                    if(data[0].reports[9]){
                        $("#report10").show();
                        $("#purchaserate").html(data[0].reports[9].role_name);
                        $("#purchaserate").attr('value', data[0].reports[9].role_name);
                        if(data[0].reports[9].value == 1){
                            $("#purchaserate1").attr('checked', true);
                        }
                        else{
                            $("#purchaserate1").attr('checked', false);
                        } 
                    }
                    else{
                        $("#report10").show();
                        $("#purchaserate").html("Purchase Rate History");
                        $("#purchaserate1").attr('value', "Purchase Rate History");
                        $("#purchaserate1").attr('checked', false);
                    }
                    if(data[0].reports[10]){
                        $("#report11").show();
                        $("#mtransfer").html(data[0].reports[10].role_name);
                        $("#mtransfer1").attr('value', data[0].reports[10].role_name);
                        if(data[0].reports[10].value == 1){
                            $("#mtransfer1").attr('checked', true);
                        }
                        else{
                            $("#mtransfer1").attr('checked', false);
                        } 
                    }
                    else{
                        $("#report11").show();
                        $("#mtransfer1").html("M Transfer Against JO");
                        $("#mtransfer1").attr('value', "M Transfer Against JO");
                        $("#mtransfer1").attr('checked', false);
                    }
                    if(data[0].reports[11]){
                        $("#report12").show();
                        $("#materialc").html(data[0].reports[11].role_name);
                        $("#materialc1").attr('value', data[0].reports[11].role_name);
                        if(data[0].reports[11].value == 1){
                            $("#materialc1").attr('checked', true);
                        }
                        else{
                            $("#materialc1").attr('checked', false);
                        } 
                    }
                    else{
                        $("#report12").show();
                        $("#materialc").html("Material Consumption");
                        $("#materialc1").attr('value', "Material Consumption");
                        $("#materialc1").attr('checked', false);
                    }
                    if(data[0].reports[12]){
                        $("#report13").show();
                        $("#purchaseorder").html(data[0].reports[12].role_name);
                        $("#purchaseorder1").attr('value', data[0].reports[12].role_name);
                        if(data[0].reports[12].value == 1){
                            $("#purchaseorder1").attr('checked', true);
                        }
                        else{
                            $("#purchaseorder1").attr('checked', false);
                        } 
                    }
                    else{
                        $("#report13").show();
                        $("#purchaseorder").html("Purchase Order Report");
                        $("#purchaseorder1").attr('value', "Purchase Order Report");
                        $("#purchaseorder1").attr('checked', false);
                    }
                    if(data[0].reports[13]){
                        $("#report14").show();
                        $("#consumptione").html(data[0].reports[13].role_name);
                        $("#consumptione1").attr('value', data[0].reports[13].role_name);
                        if(data[0].reports[13].value == 1){
                            $("#consumptione1").attr('checked', true);
                        }
                        else{
                            $("#consumptione1").attr('checked', false);
                        } 
                    }
                    else{
                        $("#report14").show();
                        $("#consumptione").html("Consumption Expection");
                        $("#consumptione1").attr('value', "Consumption Expection");
                        $("#consumptione1").attr('checked', false);
                    }
                    if(data[0].reports[14]){
                        $("#report15").show();
                        $("#purchaseinovie").html(data[0].reports[14].role_name);
                        $("#purchaseinovie1").attr('value', data[0].reports[14].role_name);
                        if(data[0].reports[14].value == 1){
                            $("#purchaseinovie1").attr('checked', true);
                        }
                        else{
                            $("#purchaseinovie1").attr('checked', false);
                        } 
                    }
                    else{
                        $("#report15").show();
                        $("#purchaseinovie").html("Purchase Invoice Report");
                        $("#purchaseinovie1").attr('value', "Purchase Invoice Report");
                        $("#purchaseinovie1").attr('checked', false);
                    }
                    if(data[0].reports[15]){
                        $("#report16").show();
                        $("#workorderitem").html(data[0].reports[15].role_name);
                        $("#workorderitem1").attr('value', data[0].reports[15].role_name);
                        if(data[0].reports[15].value == 1){
                            $("#workorderitem1").attr('checked', true);
                        }
                        else{
                            $("#workorderitem1").attr('checked', false);
                        } 
                    }
                    else{
                        $("#report16").show();
                        $("#workorderitem").html("Work Order Item Costing");
                        $("#workorderitem1").attr('value', "Work Order Item Costing");
                        $("#workorderitem1").attr('checked', false);
                    }
                    if(data[0].reports[16]){
                        $("#report17").show();
                        $("#consumptionc").html(data[0].reports[16].role_name);
                        $("#consumptionc1").attr('value', data[0].reports[16].role_name);
                        if(data[0].reports[16].value == 1){
                            $("#consumptionc1").attr('checked', true);
                        }
                        else{
                            $("#consumptionc1").attr('checked', false);
                        } 
                    }
                    else{
                        $("#report17").show();
                        $("#consumptionc").html("Consumption Comparison");
                        $("#consumptionc1").attr('value', "Consumption Comparison");
                        $("#consumptionc1").attr('checked', false);
                    }
                    $("#reports").show();
                }

                //Objective
                if(data[0].objective.length === 0){
                    $("#objlist").html("Objective-List");
                    $("#objlist1").attr('value', "Objective-List");
                    $("#objcreate").html("Objective-Create");
                    $("#objcreate1").attr('value', "Objective-Create");
                    $("#objedit").html("Objective-Edit");
                    $("#objedit1").attr('value', "Objective-Edit");
                    $("#objdelete").html("Objective-Delete");
                    $("#objdelete1").attr('value', "Objective-Delete");
                    $("#objstatus").html("Objective-Status");
                    $("#objstatus1").attr('value', "Objective-Status");
                    $("#objrevision").html("Objective-Revision");
                    $("#objrevision1").attr('value', "Objective-Revision");
                    $("#objdirector").html("Director-Objective");
                    $("#objdirector1").attr('value', "Director-Objective");
                    $("#Objectives").show();
                }
                else{
                    if(data[0].objective[0]){
                        $("#obj1").show();
                        $("#objlist").html(data[0].objective[0].role_name);
                        $("#objlist1").attr('value', data[0].objective[0].role_name);
                        if(data[0].objective[0].value == 1){
                            $("#objlist1").attr('checked', true);
                        }
                        else{
                            $("#objlist1").attr('checked', false);
                        } 
                    }
                    else{
                        $("#obj1").show();
                        $("#jobcreate").html("Objective-List");
                        $("#jobcreate1").attr('value', "Objective-List");
                        $("#jobcreate1").attr('checked', false);
                    }
                    if(data[0].objective[1]){
                        $("#obj2").show();
                        $("#objcreate").html(data[0].objective[1].role_name);
                        $("#objcreate1").attr('value', data[0].objective[1].role_name);
                        if(data[0].objective[1].value == 1){
                            $("#objcreate1").attr('checked', true);
                        }
                        else{
                            $("#objcreate1").attr('checked', false);
                        } 
                    }
                    else{
                        $("#obj2").show();
                        $("#objcreate").html("Objective-Create");
                        $("#objcreate1").attr('value', "Objective-Create");
                        $("#objcreate1").attr('checked', false);
                    }

                    if(data[0].objective[2]){
                        $("#obj3").show();
                        $("#objedit").html(data[0].objective[2].role_name);
                        $("#objedit1").attr('value', data[0].objective[2].role_name);
                        if(data[0].objective[2].value == 1){
                            $("#objedit1").attr('checked', true);
                        } 
                        else{
                            $("#objedit1").attr('checked', false);
                        }
                    }
                    else{
                        $("#obj3").show();
                        $("#objedit").html("Objective-Edit");
                        $("#objedit1").attr('value', "Objective-Edit");
                        $("#objedit1").attr('checked', false);
                    }
                    if(data[0].objective[3]){
                        $("#obj4").show();
                        $("#objdelete").html(data[0].objective[3].role_name);
                        $("#objdelete1").attr('value', data[0].objective[3].role_name);
                        if(data[0].objective[3].value == 1){
                            $("#objdelete1").attr('checked', true);
                        } 
                        else{
                            $("#objdelete1").attr('checked', false);
                        }
                    }
                    else{
                        $("#obj4").show();
                        $("#objdelete").html("Objective-Delete");
                        $("#objdelete1").attr('value', "Objective-Delete");
                        $("#objdelete1").attr('checked', false);
                    }
                    if(data[0].objective[4]){
                        $("#obj5").show();
                        $("#objstatus").html(data[0].objective[4].role_name);
                        $("#objstatus1").attr('value', data[0].objective[4].role_name);
                        if(data[0].objective[4].value == 1){
                            $("#objstatus1").attr('checked', true);
                        } 
                        else{
                            $("#objstatus1").attr('checked', false);
                        }
                    }
                    else{
                        $("#obj5").show();
                        $("#objstatus").html("Objective-Status");
                        $("#objstatus1").attr('value', "Objective-Status");
                        $("#objstatus1").attr('checked', false);
                    }
                    if(data[0].objective[5]){
                        $("#obj6").show();
                        $("#objrevision").html(data[0].objective[5].role_name);
                        $("#objrevision1").attr('value', data[0].objective[5].role_name);
                        if(data[0].objective[5].value == 1){
                            $("#objrevision1").attr('checked', true);
                        } 
                        else{
                            $("#objrevision1").attr('checked', false);
                        }
                    }
                    else{
                        $("#obj6").show();
                        $("#objrevision").html("Objective-Revision");
                        $("#objrevision1").attr('value', "Objective-Revision");
                        $("#objrevision1").attr('checked', false);
                    }
                    if(data[0].objective[6]){
                        $("#obj7").show();
                        $("#objdirector").html(data[0].objective[6].role_name);
                        $("#objdirector1").attr('value', data[0].objective[6].role_name);
                        if(data[0].objective[6].value == 1){
                            $("#objdirector1").attr('checked', true);
                        } 
                        else{
                            $("#objdirector1").attr('checked', false);
                        }
                    }
                    else{
                        $("#obj7").show();
                        $("#objdirector").html("Director-Objective");
                        $("#objdirector1").attr('value', "Director-Objective");
                        $("#objdirector1").attr('checked', false);
                    }
                    $("#Objectives").show();
                }

                //Role
                if(data[0].role.length === 0){
                    $("#rolelist").html("Role-List");
                    $("#rolelist1").attr('value', "Role-List");         
                    $("#rolecreate").html("Role-Create");
                    $("#rolecreate1").attr('value', "Role-Create");
                    $("#roleedit").html("Role-Edit");
                    $("#roleedit1").attr('value', "Role-Edit");
                    $("#roledelete").html("Role-Delete");
                    $("#roledelete1").attr('value', "Role-Delete");
                    $("#roles").show();
                }
                else{
                    if(data[0].role[0]){
                        $("#role1").show();
                        $("#rolelist").html(data[0].role[0].role_name);
                        $("#rolelist1").attr('value', data[0].role[0].role_name);
                        if(data[0].role[0].value == 1){
                            $("#rolelist1").attr('checked', true);
                        } 
                        else{
                            $("#rolelist1").attr('checked', false);
                        }
                    }
                    else{
                        $("#role1").show();
                        $("#rolelist").html("Role-List");
                        $("#rolelist1").attr('value', "Role-List");
                        $("#rolelist1").attr('checked', false);
                    }
                    if(data[0].role[1]){
                        $("#role2").show();
                        $("#rolecreate").html(data[0].role[1].role_name);
                        $("#rolecreate1").attr('value', data[0].role[1].role_name);
                        if(data[0].role[1].value == 1){
                            $("#rolecreate1").attr('checked', true);
                        } 
                        else{
                            $("#rolecreate1").attr('checked', false);
                        }
                    }
                    else{
                        $("#role2").show();
                        $("#rolecreate").html("Role-Create");
                        $("#rolecreate1").attr('value', "Role-Create");
                        $("#rolecreate1").attr('checked', false);
                    }
                    if(data[0].role[2]){
                        $("#role3").show();
                        $("#roleedit").html(data[0].role[2].role_name);
                        $("#roleedit1").attr('value', data[0].role[2].role_name);
                        if(data[0].role[2].value == 1){
                            $("#roleedit1").attr('checked', true);
                        } 
                        else{
                            $("#roleedit1").attr('checked', false);
                        }
                    }
                    else{
                        $("#role3").show();
                        $("#roleedit").html("Role-Edit");
                        $("#roleedit1").attr('value', "Role-Edit");
                        $("#roleedit1").attr('checked', false);
                    }
                    if(data[0].role[3]){
                        $("#role4").show();
                        $("#roledelete").html(data[0].role[3].role_name);
                        $("#roledelete1").attr('value', data[0].role[3].role_name);
                        if(data[0].role[3].value == 1){
                            $("#roledelete1").attr('checked', true);
                        }
                        else{
                            $("#roledelete1").attr('checked', false);
                        }
                    }
                    else{
                        $("#role4").show();
                        $("#roledelete").html("Role-Delete");
                        $("#roledelete1").attr('value', "Role-Delete");
                        $("#roledelete1").attr('checked', false);
                    }
                    $("#roles").show();
                }

                //User
                if(data[0].user.length === 0){
                    $("#userlist").html("User-List");
                    $("#userlist1").attr('value', "User-List");
                    $("#usercreate").html("User-Create");
                    $("#usercreate1").attr('value', "User-Create");
                    $("#useredit").html("User-Edit");
                    $("#useredit1").attr('value', "User-Edit");
                    $("#userdelete").html("User-Delete");
                    $("#userdelete1").attr('value', "User-Delete");
                    $("#Users").show();
                }
                else{
                    if(data[0].user[0]){
                        $("#user1").show();
                        $("#userlist").html(data[0].user[0].role_name);
                        $("#userlist1").attr('value', data[0].user[0].role_name);
                        if(data[0].user[0].value == 1){
                            $("#userlist1").attr('checked', true);
                        } 
                        else{
                            $("#userlist1").attr('checked', false);
                        }
                    }
                    else{
                        $("#user1").show();
                        $("#userlist").html("User-List");
                        $("#userlist1").attr('value', "User-List");
                        $("#userlist1").attr('checked', false);
                    }
                    if(data[0].user[1]){
                        $("#user2").show();
                        $("#usercreate").html(data[0].user[1].role_name);
                        $("#usercreate1").attr('value', data[0].user[1].role_name);
                        if(data[0].user[1].value == 1){
                            $("#usercreate1").attr('checked', true);
                        } 
                        else{
                            $("#usercreate1").attr('checked', false);
                        }
                    }
                    else{
                        $("#user2").show();
                        $("#usercreate").html("User-Create");
                        $("#usercreate1").attr('value', "User-Create");
                        $("#usercreate1").attr('checked', false);
                    }
                    if(data[0].user[2]){
                        $("#user3").show();
                        $("#useredit").html(data[0].user[2].role_name);
                        $("#useredit1").attr('value', data[0].user[2].role_name);
                        if(data[0].user[2].value == 1){
                            $("#useredit1").attr('checked', true);
                        } 
                        else{
                            $("#useredit1").attr('checked', false);
                        }
                    }
                    else{
                        $("#user3").show();
                        $("#usercreate").html("User-Edit");
                        $("#usercreate1").attr('value', "User-Edit");
                        $("#usercreate1").attr('checked', false);
                    }
                    if(data[0].user[3]){
                        $("#user4").show();
                        $("#userdelete").html(data[0].user[3].role_name);
                        $("#userdelete1").attr('value', data[0].user[3].role_name);
                        if(data[0].user[3].value == 1){
                            $("#userdelete1").attr('checked', true);
                        }
                        else{
                            $("#userdelete1").attr('checked', false);
                        }
                    }
                    else{
                        $("#user4").show();
                        $("#userdelete").html("User-Delete");
                        $("#userdelete1").attr('value', "User-Delete");
                        $("#userdelete1").attr('checked', false);
                    }
                    $("#Users").show();
                }

                //JobOrder
                if(data[0].joborder.length === 0){
                    $("#joblist").html("Job-Order List");
                    $("#joblist1").attr('value', "Job-Order List");
                    $("#jobcreate").html("Job-Order Create");
                    $("#jobcreate1").attr('value', "Job-Order Create");
                    $("#jobedit").html("Job-Order Edit");
                    $("#jobedit1").attr('value', "Job-Order Edit");
                    $("#jobdelete").html("Job-Order Delete");
                    $("#jobdelete1").attr('value', "Job-Order Delete");
                    $("#jobtransfer").html("Job-Order Transfer");
                    $("#jobtransfer1").attr('value', "Job-Order Transfer");
                    $("#pricinglist").html("Pricing-Sheet List");
                    $("#pricinglist1").attr('value', "Pricing-Sheet List");
                    $("#pricingcreate").html("Pricing-Sheet Create");
                    $("#pricingcreate1").attr('value', "Pricing-Sheet Create");
                    $("#pricingedit").html("Pricing-Sheet Edit");
                    $("#pricingedit1").attr('value', "Pricing-Sheet Edit");
                    $("#pricingdelete").html("Pricing-Sheet Delete");
                    $("#pricingdelete1").attr('value', "Pricing-Sheet Delete");
                    $("#pricingtransfer").html("Pricing-Sheet Transfer");
                    $("#pricingtransfer1").attr('value', "Pricing-Sheet Transfer");
                    $("#pricingcosting").html("Pricing-Sheet Costing");
                    $("#pricingcosting1").attr('value', "Pricing-Sheet Costing");
                    $("#pricingsales").html("Pricing-Sheet Sales");
                    $("#pricingsales1").attr('value', "Pricing-Sheet Sales");
                    $("#pricingproduction").html("Pricing-Sheet Production");
                    $("#pricingproduction1").attr('value', "Pricing-Sheet Production");
                    $("#pdlmasterdata").html("PDL Master Data");
                    $("#pdlmasterdata1").attr('value', "PDL Master Data");
                    $("#formulalist").html("Formula-Sheet List");
                    $("#formulalist1").attr('value', "Formula-Sheet List");
                    $("#formulacreate").html("Formula-Sheet Create");
                    $("#formulacreate1").attr('value', "Formula-Sheet Create");
                    $("#formulaedit").html("Formula-Sheet Edit");
                    $("#formulaedit1").attr('value', "Formula-Sheet Edit");
                    $("#formuladelete").html("Formula-Sheet Delete");
                    $("#formuladelete1").attr('value', "Formula-Sheet Delete");
                    $("#joborder").show();
                }
                else{
                    if(data[0].joborder[0]){
                        $("#plc1").show();
                        $("#joblist").html(data[0].joborder[0].role_name);
                        $("#joblist1").attr('value', data[0].joborder[0].role_name);
                        if(data[0].joborder[0].value == 1){
                            $("#joblist1").attr('checked', true);
                        } 
                        else{
                            $("#joblist1").attr('checked', false);
                        }
                    }
                    else{
                        $("#plc1").show();
                        $("#joblist").html("Job-Order List");
                        $("#joblist1").attr('value', "Job-Order List");
                        $("#joblist1").attr('checked', false);
                    }

                    if(data[0].joborder[1]){
                        $("#plc2").show();
                        $("#jobcreate").html(data[0].joborder[1].role_name);
                        $("#jobcreate1").attr('value', data[0].joborder[1].role_name);
                        if(data[0].joborder[1].value == 1){
                            $("#jobcreate1").attr('checked', true);
                        } 
                        else{
                            $("#jobcreate1").attr('checked', false);
                        }
                    }
                    else{
                        $("#plc2").show();
                        $("#jobcreate").html("Job-Order Create");
                        $("#jobcreate1").attr('value', "Job-Order Create");
                        $("#jobcreate1").attr('checked', false);
                    }
                    if(data[0].joborder[2]){
                        $("#plc3").show();
                        $("#jobedit").html(data[0].joborder[2].role_name);
                        $("#jobedit1").attr('value', data[0].joborder[2].role_name);
                        if(data[0].joborder[2].value == 1){
                            $("#jobedit1").attr('checked', true);
                        } 
                        else{
                            $("#jobedit1").attr('checked', false);
                        }
                    }
                    else{
                        $("#plc3").show();
                        $("#jobedit").html("Job-Order Edit");
                        $("#jobedit1").attr('value', "Job-Order Edit");
                        $("#jobedit1").attr('checked', false);
                    }
                    if(data[0].joborder[3]){
                        $("#plc4").show();
                        $("#jobdelete").html(data[0].joborder[3].role_name);
                        $("#jobdelete1").attr('value', data[0].joborder[3].role_name);
                        if(data[0].joborder[3].value == 1){
                            $("#jobdelete1").attr('checked', true);
                        }
                        else{
                            $("#jobdelete1").attr('checked', false);
                        }
                    }
                    else{
                        $("#plc4").show();
                        $("#jobdelete").html("Job-Order Delete");
                        $("#jobdelete1").attr('value', "Job-Order Delete");
                        $("#jobdelete1").attr('checked', false);
                    }
                    if(data[0].joborder[4]){
                        $("#plc5").show();
                        $("#jobtransfer").html(data[0].joborder[4].role_name);
                        $("#jobtransfer1").attr('value', data[0].joborder[4].role_name);
                        if(data[0].joborder[4].value == 1){
                            $("#jobtransfer1").attr('checked', true);
                        }
                        else{
                            $("#jobtransfer1").attr('checked', false);
                        }
                    }
                    else{
                        $("#plc5").show();
                        $("#jobtransfer").html("Job-Order Transfer");
                        $("#jobtransfer1").attr('value', "Job-Order Transfer");
                        $("#jobtransfer1").attr('checked', false);
                    }
                    if(data[0].joborder[5]){
                        $("#plc6").show();
                        $("#pricinglist").html(data[0].joborder[5].role_name);
                        $("#pricinglist1").attr('value', data[0].joborder[5].role_name);
                        if(data[0].joborder[5].value == 1){
                            $("#pricinglist1").attr('checked', true);
                        }
                        else{
                            $("#pricinglist1").attr('checked', false);
                        }
                    }
                    else{
                        $("#plc6").show();
                        $("#pricinglist").html("Pricing-Sheet List");
                        $("#pricinglist1").attr('value', "Pricing-Sheet List");
                        $("#pricinglist1").attr('checked', false);
                    }
                    if(data[0].joborder[6]){
                        $("#plc7").show();
                        $("#pricingcreate").html(data[0].joborder[6].role_name);
                        $("#pricingcreate1").attr('value', data[0].joborder[6].role_name);
                        if(data[0].joborder[6].value == 1){
                            $("#pricingcreate1").attr('checked', true);
                        }
                        else{
                            $("#pricingcreate1").attr('checked', false);
                        }
                    }
                    else
                    {
                        $("#plc7").show();
                        $("#pricinglist").html("Pricing-Sheet Create");
                        $("#pricinglist1").attr('value', "Pricing-Sheet Create");
                        $("#pricinglist1").attr('checked', false);
                    }
                    if(data[0].joborder[7]){
                        $("#plc8").show();
                        $("#pricingdelete").html(data[0].joborder[7].role_name);
                        $("#pricingdelete1").attr('value', data[0].joborder[7].role_name);
                        if(data[0].joborder[7].value == 1){
                            $("#pricingdelete1").attr('checked', true);
                        }
                        else{
                            $("#pricingdelete1").attr('checked', false);
                        }
                    }
                    else{
                        $("#plc8").show();
                        $("#pricingdelete").html("Pricing-Sheet Delete");
                        $("#pricingdelete1").attr('value', "Pricing-Sheet Delete");
                        $("#pricingdelete1").attr('checked', false);
                    }
                    if(data[0].joborder[8]){
                        $("#plc9").show();
                        $("#pricingedit").html(data[0].joborder[8].role_name);
                        $("#pricingedit1").attr('value', data[0].joborder[8].role_name);
                        if(data[0].joborder[8].value == 1){
                            $("#pricingedit1").attr('checked', true);
                        }
                        else{
                            $("#pricingedit1").attr('checked', false);
                        }
                    }
                    else{
                        $("#plc9").show();
                        $("#pricingedit").html("Pricing-Sheet Edit");
                        $("#pricingedit1").attr('value', "Pricing-Sheet Edit");
                        $("#pricingedit1").attr('checked', false);
                    }
                    if(data[0].joborder[9]){
                        $("#plc10").show();
                        $("#pricingtransfer").html(data[0].joborder[9].role_name);
                        $("#pricingtransfer1").attr('value', data[0].joborder[9].role_name);
                        if(data[0].joborder[9].value == 1){
                            $("#pricingtransfer1").attr('checked', true);
                        }
                        else{
                            $("#pricingtransfer1").attr('checked', false);
                        }
                    }
                    else{
                        $("#plc10").show();
                        $("#pricingtransfer").html("Pricing-Sheet Costing");
                        $("#pricingtransfer1").attr('value', "Pricing-Sheet Costing");
                        $("#pricingtransfer1").attr('checked', false);
                    }
                    if(data[0].joborder[10]){
                        $("#plc11").show();
                        $("#pricingcosting").html(data[0].joborder[10].role_name);
                        $("#pricingcosting1").attr('value', data[0].joborder[10].role_name);
                        if(data[0].joborder[10].value == 1){
                            $("#pricingcosting1").attr('checked', true);
                        }
                        else{
                            $("#pricingcosting1").attr('checked', false);
                        }
                    }
                    else{
                        $("#plc11").show();
                        $("#pricingcosting").html("Pricing-Sheet Costing");
                        $("#pricingcosting1").attr('value', "Pricing-Sheet Costing");
                        $("#pricingcosting1").attr('checked', false);
                    }
                    if(data[0].joborder[11]){
                        $("#plc12").show();
                        $("#pricingsales").html(data[0].joborder[11].role_name);
                        $("#pricingsales1").attr('value', data[0].joborder[11].role_name);
                        if(data[0].joborder[11].value == 1){
                            $("#pricingsales1").attr('checked', true);
                        }
                        else{
                            $("#pricingsales1").attr('checked', false);
                        }
                    }else{
                        $("#plc12").show();
                        $("#pricingsales").html("Pricing-Sheet Sales");
                        $("#pricingsales1").attr('value', "Pricing-Sheet Sales");
                        $("#pricingsales1").attr('checked', false);
                    }
                    if(data[0].joborder[12]){
                        $("#plc13").show();
                        $("#pricingproduction").html(data[0].joborder[12].role_name);
                        $("#pricingproduction1").attr('value', data[0].joborder[12].role_name);
                        if(data[0].joborder[12].value == 1){
                            $("#pricingproduction1").attr('checked', true);
                        }
                        else{
                            $("#pricingproduction1").attr('checked', false);
                        }
                    }
                    else{
                        $("#plc13").show();
                        $("#pricingproduction").html("Pricing-Sheet Production");
                        $("#pricingproduction1").attr('value', "Pricing-Sheet Production");
                        $("#pricingproduction1").attr('checked', false);
                    }
                    if(data[0].joborder[13]){
                        $("#plc14").show();
                        $("#pdlmasterdata").html(data[0].joborder[13].role_name);
                        $("#pdlmasterdata1").attr('value', data[0].joborder[13].role_name);
                        if(data[0].joborder[13].value == 1){
                            $("#pdlmasterdata1").attr('checked', true);
                        }
                        else{
                            $("#pdlmasterdata1").attr('checked', false);
                        }
                    }
                    else{
                        $("#plc14").show();
                        $("#pdlmasterdata").html("PDL Master Data");
                        $("#pdlmasterdata1").attr('value', "PDL Master Data");
                        $("#pdlmasterdata1").attr('checked', false);
                    }
                    if(data[0].joborder[14]){
                        $("#plc15").show();
                        $("#formulalist").html(data[0].joborder[14].role_name);
                        $("#formulalist1").attr('value', data[0].joborder[14].role_name);
                        if(data[0].joborder[14].value == 1){
                            $("#formulalist1").attr('checked', true);
                        }
                        else{
                            $("#formulalist1").attr('checked', false);
                        }
                    }
                    else{
                        $("#plc15").show();
                        $("#formulalist").html("Formula-Sheet List");
                        $("#formulalist1").attr('value', "Formula-Sheet List");
                        $("#formulalist1").attr('checked', false);
                    }
                    if(data[0].joborder[15]){
                        $("#plc16").show();
                        $("#formulacreate").html(data[0].joborder[15].role_name);
                        $("#formulacreate1").attr('value', data[0].joborder[15].role_name);
                        if(data[0].joborder[15].value == 1){
                            $("#formulacreate1").attr('checked', true);
                        }
                        else{
                            $("#formulacreate1").attr('checked', false);
                        }
                    }
                    else
                    {
                        $("#plc16").show();
                        $("#formulacreate").html("Formula-Sheet Create");
                        $("#formulacreate1").attr('value', "Formula-Sheet Create");
                        $("#formulacreate1").attr('checked', false);
                    }
                    if(data[0].joborder[16]){
                        $("#plc17").show();
                        $("#formuladelete").html(data[0].joborder[16].role_name);
                        $("#formuladelete1").attr('value', data[0].joborder[16].role_name);
                        if(data[0].joborder[16].value == 1){
                            $("#formuladelete1").attr('checked', true);
                        }
                        else{
                            $("#formuladelete1").attr('checked', false);
                        }
                    }
                    else{
                        $("#plc17").show();
                        $("#formuladelete").html("Formula-Sheet Delete");
                        $("#formuladelete1").attr('value', "Formula-Sheet Delete");
                        $("#formuladelete1").attr('checked', false);
                    }

                    if(data[0].joborder[17]){
                        $("#plc18").show();
                        $("#formulaedit").html(data[0].joborder[17].role_name);
                        $("#formulaedit1").attr('value', data[0].joborder[17].role_name);
                        if(data[0].joborder[17].value == 1){
                            $("#formulaedit1").attr('checked', true);
                        }
                        else{
                            $("#formulaedit1").attr('checked', false);
                        }
                    }
                    else{
                        $("#plc18").show();
                        $("#formulaedit").html("Formula-Sheet Edit");
                        $("#formulaedit1").attr('value', "Formula-Sheet Edit");
                        $("#formulaedit1").attr('checked', false);
                    }
                    $("#joborder").show();
                }

                //Others
                if(data[0].others.length === 0){
                    console.log("Other If");
                    console.log(data[0].others.length);
                    $("#complaint").html("Complaint");
                    $("#complaint1").attr('value', "Complaint"); 
                    $("#attendance").html("Attendance");
                    $("#attendance1").attr('value', "Attendance");
                    $("#qc").html("Quality-Control");
                    $("#qc1").attr('value', "Quality-Control");
                    $("#ppc").html("Production-Planning-Control");
                    $("#ppc1").attr('value', "Production-Planning-Control");
                    $("#superadmin").html("Super-Admin");
                    $("#superadmin1").attr('value', "Super-Admin");
                    $("#others").show();
                }
                else{
                    console.log("Other Else");
                    console.log(data[0].others.length);
                    if(data[0].others[0]){
                        $("#other1").show();
                        $("#complaint").html(data[0].others[0].role_name);
                        $("#complaint1").attr('value', data[0].others[0].role_name);
                        if(data[0].others[0].value == 1){
                            $("#complaint1").attr('checked', true);
                        } 
                        else{
                            $("#complaint1").attr('checked', false);
                        }
                    }
                    else{
                        $("#other1").show();
                        $("#attendance").html("Attendance");
                        $("#attendance1").attr('value', "Attendance");
                        $("#attendance1").attr('checked', false);
                    }
                    if(data[0].others[1]){
                        $("#other2").show();
                        $("#attendance").html(data[0].others[1].role_name);
                        $("#attendance1").attr('value', data[0].others[1].role_name);
                        if(data[0].others[1].value == 1){
                            $("#attendance1").attr('checked', true);
                        } 
                        else{
                            $("#attendance1").attr('checked', false);
                        }
                    }
                    else{
                        $("#other2").show();
                        $("#attendance").html("Complaint");
                        $("#attendance1").attr('value', "Complaint");
                        $("#attendance1").attr('checked', false);
                    }
                    if(data[0].others[2]){
                        $("#other3").show();
                        $("#qc").html(data[0].others[2].role_name);
                        $("#qc1").attr('value', data[0].others[2].role_name);
                        if(data[0].others[2].value == 1){
                            $("#qc1").attr('checked', true);
                        } 
                        else{
                            $("#qc1").attr('checked', false);
                        }
                    }
                    else{
                        $("#other3").show();
                        $("#qc").html("Quality-Control");
                        $("#qc1").attr('value', "Quality-Control");
                        $("#qc1").attr('checked', false);
                    }
                    if(data[0].others[3]){
                        $("#other4").show();
                        $("#ppc").html(data[0].others[3].role_name);
                        $("#ppc1").attr('value', data[0].others[3].role_name);
                        if(data[0].others[3].value == 1){
                            $("#ppc1").attr('checked', true);
                        } 
                        else{
                            $("#ppc1").attr('checked', false);
                        }
                    }
                    else{
                        $("#other4").show();
                        $("#ppc").html("Production-Planning-Control");
                        $("#ppc1").attr('value', "Production-Planning-Control");
                        $("#ppc1").attr('checked', false);
                    }
                    if(data[0].others[4]){
                        $("#other5").show();
                        $("#superadmin").html(data[0].others[4].role_name);
                        $("#superadmin1").attr('value', data[0].others[4].role_name);
                        if(data[0].others[4].value == 1){
                            $("#superadmin1").attr('checked', true);
                        } 
                        else{
                            $("#superadmin1").attr('checked', false);
                        }
                    }
                    else{
                        $("#other5").show();
                        $("#superadmin").html("Super-Admin");
                        $("#superadmin1").attr('value', "Super-Admin");
                        $("#superadmin1").attr('checked', false);
                    }
                    $("#others").show();
                }
                $("#btnSupdate").show();
                $("#Hides").hide();
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
     $("#allCheck1").change(function() {
        if (this.checked) {
            $(".Singlecheck1").each(function() {
                this.checked=true;
            });
        } else {
            $(".Singlecheck1").each(function() {
                this.checked=false;
            });
        }
    });
    $("#allCheck2").change(function() {
        if (this.checked) {
            $(".Singlecheck2").each(function() {
                this.checked=true;
            });
        } else {
            $(".Singlecheck2").each(function() {
                this.checked=false;
            });
        }
    });
    $("#allCheck22").change(function() {
        if (this.checked) {
            $(".Singlecheck22").each(function() {
                this.checked=true;
            });
        } else {
            $(".Singlecheck22").each(function() {
                this.checked=false;
            });
        }
    });
    $("#allCheck221").change(function() {
        if (this.checked) {
            $(".Singlecheck221").each(function() {
                this.checked=true;
            });
        } else {
            $(".Singlecheck221").each(function() {
                this.checked=false;
            });
        }
    });
    $("#allCheck2211").change(function() {
        if (this.checked) {
            $(".Singlecheck2211").each(function() {
                this.checked=true;
            });
        } else {
            $(".Singlecheck2211").each(function() {
                this.checked=false;
            });
        }
    });
    $("#allReport").change(function() {
        if (this.checked) {
            $(".reportCheck").each(function() {
                this.checked=true;
            });
        } else {
            $(".reportCheck").each(function() {
                this.checked=false;
            });
        }
    });
</script>
@endsection