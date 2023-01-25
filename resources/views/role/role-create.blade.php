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
    .yourclass::-webkit-input-placeholder{
        color: #6c757d;
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
                        <li class="breadcrumb-item active">Create Role</li>
                    </ol>
                </div>
                <h4 class="page-title">Create Role</h4>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
            <div class="card-body h-100">
					<div class="text-center mt-5">
						<h2 style="color: #6c757d">Create Role</h2>
					</div>
                    <form action="{{url('roles-create')}}" method="post" enctype="multipart/form-data">
                    @csrf
					    <div class="p-5">
						    <div class="form-group row py-2">
                                <div class="col-sm-3 mb-1 mb-sm-0">
                                    <label for=""><b style="color: #6c757d"> Role</b></label>
                                    <input type="text" style="border: 1px solid #bfbfbf;" class="form-control yourclass" id="name" name="name" required placeholder="Role Name">
                                    <span id="StrengthDisp4" style="font-size: 13px !important;" class="badge displayBadgess text-light py-2 mt-2"></span>
								    <button type="submit" class="btn w-100 py-1 text-white mt-4" style="border: none; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); border: none; font-size: 15px;">Create Role</button>
                                </div>
                                <div class="col-sm-9">
                                    <label for=""> <b style="color: #6c757d"> Permissions</b></label><br>                                                     
                                    <div id="accordion">
                                        <div class="card">
                                            <div class="card-header collapsed py-2 text-white text-center" style="border: none; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); cursor: pointer; border-radius: 4px;" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Role
                                            </div>
                                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="border: 0.5px solid #96a3b3;">
                                                <div class="card-body">
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck1" type="checkbox" value="Role-List" name="Role[]">
                                                        <span class="form-check-label">Role-List</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck1" type="checkbox" value="Role-Create" name="Role[]">
                                                        <span class="form-check-label">Role-Create</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck1" type="checkbox" value="Role-Edit" name="Role[]">
                                                        <span class="form-check-label">Role-Edit</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck1" type="checkbox" value="Role-Delete" name="Role[]">
                                                        <span class="form-check-label">Role-Delete</span>
                                                    </label>
                                                    <label class="form-check form-check-inline" style="float: right;">
                                                        <input class="form-check-input" id="allCheck1" type="checkbox">
                                                        <span class="form-check-label">Mark All</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="accordion">
                                        <div class="card">
                                            <div class="card-header collapsed py-2 text-white text-center" style="border: none; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); cursor: pointer; border-radius: 4px;" id="headingOne1" data-toggle="collapse" data-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne">
                                                Objectives
                                            </div>
                                            <div id="collapseOne1" class="collapse" aria-labelledby="headingOne1" data-parent="#accordion" style="border: 0.5px solid #96a3b3;">
                                                <div class="card-body">
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck2" type="checkbox" value="Objective-List" name="Objective[]">
                                                        <span class="form-check-label">Objective-List</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck2" type="checkbox" value="Objective-Create" name="Objective[]">
                                                        <span class="form-check-label">Objective-Create</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck2" type="checkbox" value="Objective-Edit" name="Objective[]">
                                                        <span class="form-check-label">Objective-Edit</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck2" type="checkbox" value="Objective-Delete" name="Objective[]">
                                                        <span class="form-check-label">Objective-Delete</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck2" type="checkbox" value="Objective-Status" name="Objective[]">
                                                        <span class="form-check-label">Objective-Status</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck2" type="checkbox" value="Objective-Revision" name="Objective[]">
                                                        <span class="form-check-label">Objective-Revision</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck2" type="checkbox" value="Director-Objective" name="Objective[]">
                                                        <span class="form-check-label">Director-Objective</span>
                                                    </label>
                                                    <label class="form-check form-check-inline" style="float: right;">
                                                        <input class="form-check-input" id="allCheck2" type="checkbox">
                                                        <span class="form-check-label">Mark All</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="accordion">
                                        <div class="card">
                                            <div class="card-header collapsed py-2 text-white text-center" style="border: none; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); cursor: pointer; border-radius: 4px;" id="headingOne11" data-toggle="collapse" data-target="#collapseOne12" aria-expanded="true" aria-controls="collapseOne">
                                                Users
                                            </div>
                                            <div id="collapseOne12" class="collapse" aria-labelledby="headingOne11" data-parent="#accordion" style="border: 0.5px solid #96a3b3;">
                                                <div class="card-body">
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck22" type="checkbox" value="User-List" name="User[]">
                                                        <span class="form-check-label">User-List</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck22" type="checkbox" value="User-Create" name="User[]">
                                                        <span class="form-check-label">User-Create</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck22" type="checkbox" value="User-Edit" name="User[]">
                                                        <span class="form-check-label">User-Edit</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck22" type="checkbox" value="User-Delete" name="User[]">
                                                        <span class="form-check-label">User-Delete</span>
                                                    </label>
                                                    <label class="form-check form-check-inline" style="float: right;">
                                                        <input class="form-check-input" id="allCheck3" type="checkbox">
                                                        <span class="form-check-label">Mark All</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="accordion">
                                        <div class="card">
                                            <div class="card-header collapsed py-2 text-white text-center" style="border: none; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); cursor: pointer; border-radius: 4px;" id="headingOne11" data-toggle="collapse" data-target="#collapseOne123" aria-expanded="true" aria-controls="collapseOne">
                                                Product Life Cycle
                                            </div>
                                            <div id="collapseOne123" class="collapse" aria-labelledby="headingOne11" data-parent="#accordion" style="border: 0.5px solid #96a3b3;">
                                                <div class="card-body">
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck222" type="checkbox" value="Job-Order List" name="JobOrder[]">
                                                        <span class="form-check-label">Job-Order List</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck222" type="checkbox" value="Job-Order Create" name="JobOrder[]">
                                                        <span class="form-check-label">Job-Order Create</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck222" type="checkbox" value="Job-Order Delete" name="JobOrder[]">
                                                        <span class="form-check-label">Job-Order Delete</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck222" type="checkbox" value="Job-Order Edit" name="JobOrder[]">
                                                        <span class="form-check-label">Job-Order Edit</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck222" type="checkbox" value="Job-Order Transfer" name="JobOrder[]">
                                                        <span class="form-check-label">Job-Order Transfer</span>
                                                    </label>
                                                    <br>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck222" type="checkbox" value="Pricing-Sheet List" name="JobOrder[]">
                                                        <span class="form-check-label">Pricing-Sheet List</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck222" type="checkbox" value="Pricing-Sheet Create" name="JobOrder[]">
                                                        <span class="form-check-label">Pricing-Sheet Create</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck222" type="checkbox" value="Pricing-Sheet Delete" name="JobOrder[]">
                                                        <span class="form-check-label">Pricing-Sheet Delete</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck222" type="checkbox" value="Pricing-Sheet Edit" name="JobOrder[]">
                                                        <span class="form-check-label">Pricing-Sheet Edit</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck222" type="checkbox" value="Pricing-Sheet Transfer" name="JobOrder[]">
                                                        <span class="form-check-label">Pricing-Sheet Transfer</span>
                                                    </label>
                                                    <br>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck222" type="checkbox" value="Pricing-Sheet Costing" name="JobOrder[]">
                                                        <span class="form-check-label">Pricing-Sheet Costing</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck222" type="checkbox" value="Pricing-Sheet Sales" name="JobOrder[]">
                                                        <span class="form-check-label">Pricing-Sheet Sales</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck222" type="checkbox" value="Pricing-Sheet Production" name="JobOrder[]">
                                                        <span class="form-check-label">Pricing-Sheet Production</span>
                                                    </label>
                                                    <br>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck222" type="checkbox" value="PDL Master Data" name="JobOrder[]">
                                                        <span class="form-check-label">PDL Master Data</span>
                                                    </label>
                                                    <br>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck222" type="checkbox" value="Formula-Sheet List" name="JobOrder[]">
                                                        <span class="form-check-label">Formula-Sheet List</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck222" type="checkbox" value="Formula-Sheet Create" name="JobOrder[]">
                                                        <span class="form-check-label">Formula-Sheet Create</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck222" type="checkbox" value="Formula-Sheet Delete" name="JobOrder[]">
                                                        <span class="form-check-label">Formula-Sheet Delete</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck222" type="checkbox" value="Formula-Sheet Edit" name="JobOrder[]">
                                                        <span class="form-check-label">Formula-Sheet Edit</span>
                                                    </label>
                                                    <label class="form-check form-check-inline" style="float: right;">
                                                        <input class="form-check-input" id="allCheck4" type="checkbox">
                                                        <span class="form-check-label">Mark All</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="accordion">
                                        <div class="card">
                                            <div class="card-header collapsed py-2 text-white text-center" style="border: none; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); cursor: pointer; border-radius: 4px;" id="headingOne11" data-toggle="collapse" data-target="#collapseOne1233" aria-expanded="true" aria-controls="collapseOne">
                                                Others
                                            </div>
                                            <div id="collapseOne1233" class="collapse" aria-labelledby="headingOne11" data-parent="#accordion" style="border: 0.5px solid #96a3b3;">
                                                <div class="card-body">
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck222z" type="checkbox" value="Attendance" name="Others[]">
                                                        <span class="form-check-label">Attendance</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck222z" type="checkbox" value="Complaint" name="Others[]">
                                                        <span class="form-check-label">Complaint</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck222z" type="checkbox" value="Quality-Control" name="Others[]">
                                                        <span class="form-check-label">Quality-Control</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck222z" type="checkbox" value="Production-Planning-Control" name="Others[]">
                                                        <span class="form-check-label">Production-Planning-Control</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name Singlecheck222z" type="checkbox" value="Super-Admin" name="Others[]">
                                                        <span class="form-check-label">Super-Admin</span>
                                                    </label>
                                                    <label class="form-check form-check-inline" style="float: right;">
                                                        <input class="form-check-input" id="allCheck5" type="checkbox">
                                                        <span class="form-check-label">Mark All</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="accordion">
                                        <div class="card">
                                            <div class="card-header collapsed py-2 text-white text-center" style="border: none; background: linear-gradient(14deg, #1761fd 0%, rgba(23, 97, 253, 0.6)); cursor: pointer; border-radius: 4px;" id="headingOne11" data-toggle="collapse" data-target="#collapseOne1233zz" aria-expanded="true" aria-controls="collapseOne">
                                                Reports
                                            </div>
                                            <div id="collapseOne1233zz" class="collapse" aria-labelledby="headingOne11" data-parent="#accordion" style="border: 0.5px solid #96a3b3;">
                                                <div class="card-body">
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name reportCheck" type="checkbox" value="RMA Report" name="Reports[]">
                                                        <span class="form-check-label">RMA Report</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name reportCheck" type="checkbox" value="Sales Issue" name="Reports[]">
                                                        <span class="form-check-label">Sales Issue</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name reportCheck" type="checkbox" value="Item Adjustment" name="Reports[]">
                                                        <span class="form-check-label">Item Adjustment</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name reportCheck" type="checkbox" value="Help Desk Report" name="Reports[]">
                                                        <span class="form-check-label">Help Desk Report</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name reportCheck" type="checkbox" value="Job Order Report" name="Reports[]">
                                                        <span class="form-check-label">Job Order Report</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name reportCheck" type="checkbox" value="Job Order Journey" name="Reports[]">
                                                        <span class="form-check-label">Job Order Journey</span>
                                                    </label>
                                                    <br>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name reportCheck" type="checkbox" value="Sales Order Report" name="Reports[]">
                                                        <span class="form-check-label">Sales Order Report</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name reportCheck" type="checkbox" value="Transfer Issue Report" name="Reports[]">
                                                        <span class="form-check-label">Transfer Issue Report</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name reportCheck" type="checkbox" value="Item Purchase Report" name="Reports[]">
                                                        <span class="form-check-label">Item Purchase Report</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name reportCheck" type="checkbox" value="Purchase Rate History" name="Reports[]">
                                                        <span class="form-check-label">Purchase Rate History</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name reportCheck" type="checkbox" value="M Transfer Against JO" name="Reports[]">
                                                        <span class="form-check-label">M Transfer Against JO</span>
                                                    </label>
                                                    <br>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name reportCheck" type="checkbox" value="Material Consumption" name="Reports[]">
                                                        <span class="form-check-label">Material Consumption</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name reportCheck" type="checkbox" value="Purchase Order Report" name="Reports[]">
                                                        <span class="form-check-label">Purchase Order Report</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name reportCheck" type="checkbox" value="Consumption Expection" name="Reports[]">
                                                        <span class="form-check-label">Consumption Expection</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name reportCheck" type="checkbox" value="Purchase Invoice Report" name="Reports[]">
                                                        <span class="form-check-label">Purchase Invoice Report</span>
                                                    </label>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name reportCheck" type="checkbox" value="Work Order Item Costing" name="Reports[]">
                                                        <span class="form-check-label">Work Order Item Costing</span>
                                                    </label>
                                                    <br>
                                                    <label class="form-check form-check-inline">
                                                        <input class="form-check-input name reportCheck" type="checkbox" value="Consumption Comparison" name="Reports[]">
                                                        <span class="form-check-label">Consumption Comparison</span>
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
				    </form>
			    </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/customjquery.min.js"></script>
<script src="assets/js/sweetalert.min.js"></script>
<script>
    let name = document.getElementById('name')
    let strengthBadge4 = document.getElementById('StrengthDisp4')
    name.addEventListener("input", () => {
        Email(name.value);
        function Email(name){
            $.ajax({
                    type: 'GET',
                    url: 'role/'+name,
                    dataType: "json",
                    success: function(data){
                        if(data){
                            if(data == 1){
                                strengthBadge4.style.display = 'block'
                                strengthBadge4.style.backgroundColor = '#cd3f3f'
                                strengthBadge4.textContent = 'Role Name Already taken'
                            }
                            else if(data == 2){
                                strengthBadge4.style.display = 'block'
                                strengthBadge4.style.backgroundColor = '#52a752'
                                strengthBadge4.textContent = 'Role Name Available'
                            }
                        }
                    }
                });
        }
    });
    $(document).ready(function(){ 
        $("#loader1").fadeOut(1200);
    });
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
    $("#allCheck3").change(function() {
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
    $("#allCheck4").change(function() {
        if (this.checked) {
            $(".Singlecheck222").each(function() {
                this.checked=true;
            });
        } else {
            $(".Singlecheck222").each(function() {
                this.checked=false;
            });
        }
    });
    $("#allCheck5").change(function() {
        if (this.checked) {
            $(".Singlecheck222z").each(function() {
                this.checked=true;
            });
        } else {
            $(".Singlecheck222z").each(function() {
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
@endsection