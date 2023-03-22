<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Exception;
use App\Models\User;
use App\Models\Newrole;
use App\Models\RoleName;
use App\Models\UserDetail;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{   
    public function roleCreate()
    {
        try{
            return view('role.role-create');
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function roleManage(Request $request)
    {
        try{
            $userRoles = RoleName::orderBy('name','ASC')->get();
            return view('role.manage-role')->with(['data' => $userRoles]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function roleManagew(Request $request)
    {
        try{
            $userRoles = RoleName::orderBy('id','DESC')->get();
            return view('role.manage-rolee')->with(['data' => $userRoles]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function ajax(Request $request, $id)
    {
        try{
            $role = DB::table("newroles")->where("name", $id)->where("role","Role")->orWhere("role","Rolee")->get();
            $objective = DB::table("newroles")->where("name", $id)->where("role","Objective")->orWhere("role","Objectivee")->get();
            $user = DB::table("newroles")->where("name", $id)->where("role","User")->orWhere("role","Userr")->get();
            $joborder = DB::table("newroles")->where("name", $id)->where("role","JobOrder")->get();
            $others = DB::table("newroles")->where("name", $id)->where("role","Others")->get();
            $reports = DB::table("newroles")->where("name", $id)->where("role","Report")->get();
            $users = User::where('id', '!=', auth()->id())->orderBy('id','DESC')->get();
            $array = array([
                'id' => $id, 'user' => $user, 'role' => $role, 'objective' => $objective, 'joborder' => $joborder, 'others' => $others, 'reports' => $reports,
            ]);
            return response()->json($array); 
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function roleManageAjax(Request $request)
    {
        try{
            $Userdata = [];
            $Roledata = [];
            $Objectivedata = [];
            $JobOrderdata = [];
            $Otherdata = [];
            $Reportdata = [];
            $name = $request->name;
            $Role = array("Role-List" => 0, "Role-Create" => 0, "Role-Edit" => 0, "Role-Delete" => 0);
            $Objective = array("Objective-List" => 0, "Objective-Create" => 0, "Objective-Edit" => 0, "Objective-Delete" => 0, "Objective-Status" => 0, "Objective-Revision" => 0, "Director-Objective" => 0);
            $User = array("User-List" => 0, "User-Create" => 0, "User-Edit" => 0, "User-Delete" => 0);
            $JobOrder = array("Job-Order List" => 0, "Job-Order Create" => 0, "Job-Order Delete" => 0, "Job-Order Edit" => 0, 
                            "Job-Order Transfer" => 0, "Pricing-Sheet List" => 0, "Pricing-Sheet Create" => 0, "Pricing-Sheet Delete" => 0, 
                            "Pricing-Sheet Edit" => 0, "Pricing-Sheet Transfer" => 0, "Pricing-Sheet Costing" => 0, "Pricing-Sheet Sales" => 0, 
                            "Pricing-Sheet Production" => 0, "PDL Master Data" => 0, "Formula-Sheet List" => 0, "Formula-Sheet Create" => 0, "Formula-Sheet Delete" => 0, "Formula-Sheet Edit" => 0,
                            "Specification-Sheet List" => 0, "Specification-Sheet Create" => 0, "Specification-Sheet Delete" => 0, "Specification-Sheet Edit" => 0,
                            "Specification-Sheet Costing" => 0, "Specification-Sheet Sales" => 0, "Specification-Sheet PPC" => 0, "Specification-Sheet Transfer" => 0);
            $Others = array("Complaint" => 0, "Attendance" => 0, "Quality-Control" => 0, "Production-Planning-Control" => 0, "Super-Admin" => 0);
            $Reports = array("RMA Report" => 0, "Sales Issue" => 0, "Item Adjustment" => 0, "Help Desk Report" => 0, "Job Order Report" => 0, "Job Order Journey" => 0, "Sales Order Report" => 0, 
                            "Transfer Issue Report" => 0, "Item Purchase Report" => 0, "Purchase Rate History" => 0, "M Transfer Against JO" => 0, "Material Consumption" => 0, 
                            "Purchase Order Report" => 0, "Consumption Expection" => 0, "Purchase Invoice Report" => 0, "Work Order Item Costing" => 0, "Consumption Comparison" => 0, "Transfer Ledger Report" => 0,
                            "Transfer Ledger Rate" => 0, "Transfer Issue Rate" => 0, "Material Consumption Rate" => 0, "M Transfer Against All JO" => 0);

            if($request->Reports != NULL){
                for($i=0; $i<count($request->Reports); $i++){ 
                    if($request['Reports'][$i] == "RMA Report") $Reports['RMA Report'] = 1;
                    if($request['Reports'][$i] == "Sales Issue") $Reports['Sales Issue'] = 1;
                    if($request['Reports'][$i] == "Item Adjustment") $Reports['Item Adjustment'] = 1;
                    if($request['Reports'][$i] == "Help Desk Report") $Reports['Help Desk Report'] = 1;
                    if($request['Reports'][$i] == "Job Order Report") $Reports['Job Order Report'] = 1;
                    if($request['Reports'][$i] == "Job Order Journey") $Reports['Job Order Journey'] = 1;
                    if($request['Reports'][$i] == "Sales Order Report") $Reports['Sales Order Report'] = 1;
                    if($request['Reports'][$i] == "Transfer Issue Report") $Reports['Transfer Issue Report'] = 1;
                    if($request['Reports'][$i] == "Item Purchase Report") $Reports['Item Purchase Report'] = 1;
                    if($request['Reports'][$i] == "Purchase Rate History") $Reports['Purchase Rate History'] = 1;
                    if($request['Reports'][$i] == "M Transfer Against JO") $Reports['M Transfer Against JO'] = 1;
                    if($request['Reports'][$i] == "Material Consumption") $Reports['Material Consumption'] = 1;
                    if($request['Reports'][$i] == "Purchase Order Report") $Reports['Purchase Order Report'] = 1;
                    if($request['Reports'][$i] == "Consumption Expection") $Reports['Consumption Expection'] = 1;
                    if($request['Reports'][$i] == "Purchase Invoice Report") $Reports['Purchase Invoice Report'] = 1;
                    if($request['Reports'][$i] == "Work Order Item Costing") $Reports['Work Order Item Costing'] = 1;
                    if($request['Reports'][$i] == "Consumption Comparison") $Reports['Consumption Comparison'] = 1;
                    if($request['Reports'][$i] == "Transfer Ledger Report") $Reports['Transfer Ledger Report'] = 1;
                    if($request['Reports'][$i] == "Transfer Ledger Rate") $Reports['Transfer Ledger Rate'] = 1;
                    if($request['Reports'][$i] == "Transfer Issue Rate") $Reports['Transfer Issue Rate'] = 1;
                    if($request['Reports'][$i] == "Material Consumption Rate") $Reports['Material Consumption Rate'] = 1;
                    if($request['Reports'][$i] == "M Transfer Against All JO") $Reports['M Transfer Against All JO'] = 1;
                }
            }
            else{
                $Reportss = array("RMA Report", "Sales Issue", "Item Adjustment", "Help Desk Report", "Job Order Report", "Job Order Journey", "Sales Order Report", 
                                "Transfer Issue Report", "Item Purchase Report", "Purchase Rate History", "M Transfer Against JO", "Material Consumption", 
                                "Purchase Order Report", "Consumption Expection", "Purchase Invoice Report", "Work Order Item Costing", "Consumption Comparison", "Transfer Ledger Report",
                                "Transfer Ledger Rate", "Transfer Issue Rate", "Material Consumption Rate", "M Transfer Against All JO");
            }
    
            if($request->Others != NULL){
                for($i=0; $i<count($request->Others); $i++){ 
                    if($request['Others'][$i] == "Complaint") $Others['Complaint'] = 1;
                    if($request['Others'][$i] == "Attendance") $Others['Attendance'] = 1;
                    if($request['Others'][$i] == "Quality-Control") $Others['Quality-Control'] = 1;
                    if($request['Others'][$i] == "Production-Planning-Control") $Others['Production-Planning-Control'] = 1;
                    if($request['Others'][$i] == "Super-Admin") $Others['Super-Admin'] = 1;
                }
            }
            else{
                $Otherss = array("Complaint", "Attendance", "Quality-Control", "Production-Planning-Control", "Super-Admin");
            }
    
            if($request->Role != NULL){
                for($i=0; $i<count($request->Role); $i++){ 
                    if($request['Role'][$i] == "Role-List") $Role['Role-List'] = 1;
                    if($request['Role'][$i] == "Role-Create") $Role['Role-Create'] = 1;
                    if($request['Role'][$i] == "Role-Edit") $Role['Role-Edit'] = 1;
                    if($request['Role'][$i] == "Role-Delete") $Role['Role-Delete'] = 1;
                }
            }
            else{
                $Rolee = array("Role-List", "Role-Create", "Role-Edit", "Role-Delete");
            }
    
            if($request->Objective != NULL){
                for($i=0; $i<count($request->Objective); $i++){ 
                    if($request['Objective'][$i] == "Objective-List") $Objective['Objective-List'] = 1;
                    if($request['Objective'][$i] == "Objective-Create") $Objective['Objective-Create'] = 1;
                    if($request['Objective'][$i] == "Objective-Edit") $Objective['Objective-Edit'] = 1;
                    if($request['Objective'][$i] == "Objective-Delete") $Objective['Objective-Delete'] = 1;
                    if($request['Objective'][$i] == "Objective-Status") $Objective['Objective-Status'] = 1;
                    if($request['Objective'][$i] == "Objective-Revision") $Objective['Objective-Revision'] = 1;
                    if($request['Objective'][$i] == "Director-Objective") $Objective['Director-Objective'] = 1;
                }
            }
            else{
                $Objectivee = array("Objective-List", "Objective-Create", "Objective-Edit", "Objective-Delete", "Objective-Status", "Objective-Revision","Director-Objective");
    
            }
    
            if($request->User != NULL){
                for($i=0; $i<count($request->User); $i++){ 
                    if($request['User'][$i] == "User-List") $User['User-List'] = 1;
                    if($request['User'][$i] == "User-Create") $User['User-Create'] = 1;
                    if($request['User'][$i] == "User-Edit") $User['User-Edit'] = 1;
                    if($request['User'][$i] == "User-Delete") $User['User-Delete'] = 1;
                }
            }
            else{
                $Userr = array("User-List", "User-Create", "User-Edit", "User-Delete");
    
            }
    
            if($request->JobOrder != NULL){
                for($i=0; $i<count($request->JobOrder); $i++){ 
                    if($request['JobOrder'][$i] == "Job-Order List") $JobOrder['Job-Order List'] = 1;
                    if($request['JobOrder'][$i] == "Job-Order Create") $JobOrder['Job-Order Create'] = 1;
                    if($request['JobOrder'][$i] == "Job-Order Delete") $JobOrder['Job-Order Delete'] = 1;
                    if($request['JobOrder'][$i] == "Job-Order Edit") $JobOrder['Job-Order Edit'] = 1;
                    if($request['JobOrder'][$i] == "Job-Order Transfer") $JobOrder['Job-Order Transfer'] = 1;
                    if($request['JobOrder'][$i] == "Pricing-Sheet List") $JobOrder['Pricing-Sheet List'] = 1;
                    if($request['JobOrder'][$i] == "Pricing-Sheet Create") $JobOrder['Pricing-Sheet Create'] = 1;
                    if($request['JobOrder'][$i] == "Pricing-Sheet Delete") $JobOrder['Pricing-Sheet Delete'] = 1;
                    if($request['JobOrder'][$i] == "Pricing-Sheet Edit") $JobOrder['Pricing-Sheet Edit'] = 1;
                    if($request['JobOrder'][$i] == "Pricing-Sheet Transfer") $JobOrder['Pricing-Sheet Transfer'] = 1;
                    if($request['JobOrder'][$i] == "Pricing-Sheet Costing") $JobOrder['Pricing-Sheet Costing'] = 1;
                    if($request['JobOrder'][$i] == "Pricing-Sheet Sales") $JobOrder['Pricing-Sheet Sales'] = 1;
                    if($request['JobOrder'][$i] == "Pricing-Sheet Production") $JobOrder['Pricing-Sheet Production'] = 1;
                    if($request['JobOrder'][$i] == "PDL Master Data") $JobOrder['PDL Master Data'] = 1;                    
                    if($request['JobOrder'][$i] == "Formula-Sheet List") $JobOrder['Formula-Sheet List'] = 1;
                    if($request['JobOrder'][$i] == "Formula-Sheet Create") $JobOrder['Formula-Sheet Create'] = 1;
                    if($request['JobOrder'][$i] == "Formula-Sheet Delete") $JobOrder['Formula-Sheet Delete'] = 1;
                    if($request['JobOrder'][$i] == "Formula-Sheet Edit") $JobOrder['Formula-Sheet Edit'] = 1;
                    if($request['JobOrder'][$i] == "Specification-Sheet List") $JobOrder['Specification-Sheet List'] = 1;
                    if($request['JobOrder'][$i] == "Specification-Sheet Create") $JobOrder['Specification-Sheet Create'] = 1;
                    if($request['JobOrder'][$i] == "Specification-Sheet Delete") $JobOrder['Specification-Sheet Delete'] = 1;
                    if($request['JobOrder'][$i] == "Specification-Sheet Edit") $JobOrder['Specification-Sheet Edit'] = 1;
                    if($request['JobOrder'][$i] == "Specification-Sheet Costing") $JobOrder['Specification-Sheet Costing'] = 1;
                    if($request['JobOrder'][$i] == "Specification-Sheet Sales") $JobOrder['Specification-Sheet Sales'] = 1;
                    if($request['JobOrder'][$i] == "Specification-Sheet PPC") $JobOrder['Specification-Sheet PPC'] = 1;
                    if($request['JobOrder'][$i] == "Specification-Sheet Transfer") $JobOrder['Specification-Sheet Transfer'] = 1;
                }
            }
            else{
                $JobOrder = array("Job-Order List", "Job-Order Create", "Job-Order Delete", "Job-Order Edit", "Job-Order Transfer", "Pricing-Sheet List", 
                                    "Pricing-Sheet Create", "Pricing-Sheet Delete", "Pricing-Sheet Edit", "Pricing-Sheet Transfer", "Pricing-Sheet Costing", 
                                    "Pricing-Sheet Sales", "Pricing-Sheet Production",  "PDL Master Data", "Formula-Sheet List",  "Formula-Sheet Create", 
                                    "Formula-Sheet Delete", "Formula-Sheet Edit",  "Specification-Sheet List",  "Specification-Sheet Create", "Specification-Sheet Delete", 
                                    "Specification-Sheet Edit", "Specification-Sheet Costing", "Specification-Sheet Sales", "Specification-Sheet PPC", "Specification-Sheet Transfer");
            }

            if($request->Reports != NULL){
                foreach($Reports as $data => $key){
                    $Reportdata[] = [
                        'name' => $name,
                        'role_name' => $data,
                        'role' => "Report",
                        'value' => $key,
                    ];
                }
            }
            else{
                for($i=0; $i<22; $i++){
                    $Reportdata[] = [
                        'name' => $name,
                        'role_name' => $Reportss[$i],
                        'role' => "Report",
                        'value' => 0,
                    ];
                }            
            }
    
            if($request->JobOrder != NULL){
                foreach($JobOrder as $data => $key){
                    $Joborderdata[] = [
                        'name' => $name,
                        'role_name' => $data,
                        'role' => "JobOrder",
                        'value' => $key,
                    ];
                }
            }
            else{
                for($i=0; $i<26; $i++){
                    $Joborderdata[] = [
                        'name' => $name,
                        'role_name' => $JobOrder[$i],
                        'role' => "JobOrder",
                        'value' => 0,
                    ];
                }            
            }
    
            if($request->Others != NULL){
                foreach($Others as $data => $key){
                    $Otherdata[] = [
                        'name' => $name,
                        'role_name' => $data,
                        'role' => "Others",
                        'value' => $key,
                    ];
                }
            }
            else{
                for($i=0; $i<5; $i++){
                    $Otherdata[] = [
                        'name' => $name,
                        'role_name' => $Otherss[$i],
                        'role' => "Others",
                        'value' => 0,
                    ];
                }            
            }
    
            if($request->Role != NULL){
                foreach($Role as $data => $key){
                    $Roledata[] = [
                        'name' => $name,
                        'role_name' => $data,
                        'role' => "Role",
                        'value' => $key,
                    ];
                }
            }
            else{
                for($i=0; $i<4; $i++){
                    $Roledata[] = [
                        'name' => $name,
                        'role_name' => $Rolee[$i],
                        'role' => "Role",
                        'value' => 0,
                    ];
                }            
            }
    
            if($request->Objective != NULL){
                foreach($Objective as $data => $key){
                    $Objectivedata[] = [
                        'name' => $name,
                        'role_name' => $data,
                        'role' => "Objective",
                        'value' => $key,
                    ];
                }
            }
            else{
                for($i=0; $i<7; $i++){
                    $Objectivedata[] = [
                        'name' => $name,
                        'role_name' => $Objectivee[$i],
                        'role' => "Objective",
                        'value' => 0,
                    ];
                }            
            }
    
            if($request->User != NULL){
                foreach($User as $data => $key){
                    $Userdata[] = [
                        'name' => $name,
                        'role_name' => $data,
                        'role' => "User",
                        'value' => $key,
                    ];
                }
            }
            else{
                for($i=0; $i<4; $i++){
                    $Userdata[] = [
                        'name' => $name,
                        'role_name' => $Userr[$i],
                        'role' => "User",
                        'value' => 0,
                    ];
                }            
            }
    
            Newrole::where('name', $name)->delete();
            Newrole::insert($Userdata);
            Newrole::insert($Joborderdata);
            Newrole::insert($Roledata);
            Newrole::insert($Objectivedata);
            Newrole::insert($Otherdata);
            Newrole::insert($Reportdata);
            $notification = array(
                'message' => 'Role Updated',
                'alert-type' => 'success'
            );
            return redirect()->route('role-manage-new')->with($notification);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function createRole(Request $request)
    {
        try{
            $Userdata = [];
            $RoleName = [];
            $Roledata = [];
            $Objectivedata = [];
            $Joborderdata = [];
            $Otherdata = [];
            $name = $request->name;
            $id = Auth::user()->id;
            $Role = array("Role-List" => 0, "Role-Create" => 0, "Role-Edit" => 0, "Role-Delete" => 0);
            $Objective = array("Objective-List" => 0, "Objective-Create" => 0, "Objective-Edit" => 0, "Objective-Delete" => 0, "Objective-Status" => 0, "Objective-Revision" => 0, );
            $User = array("User-List" => 0, "User-Create" => 0, "User-Edit" => 0, "User-Delete" => 0);
            $JobOrder = array("Job-Order List" => 0, "Job-Order Create" => 0, "Job-Order Delete" => 0, "Job-Order Edit" => 0, 
                            "Job-Order Transfer" => 0, "Pricing-Sheet List" => 0, "Pricing-Sheet Create" => 0, "Pricing-Sheet Delete" => 0, 
                            "Pricing-Sheet Edit" => 0, "Pricing-Sheet Transfer" => 0, "Pricing-Sheet Costing" => 0, "Pricing-Sheet Sales" => 0, 
                            "Pricing-Sheet Production" => 0, "PDL Master Data" => 0, "Formula-Sheet List" => 0, "Formula-Sheet Create" => 0, "Formula-Sheet Delete" => 0, "Formula-Sheet Edit" => 0,
                            "Specification-Sheet List" => 0, "Specification-Sheet Create" => 0, "Specification-Sheet Delete" => 0, "Specification-Sheet Edit" => 0,
                            "Specification-Sheet Costing" => 0, "Specification-Sheet Sales" => 0, "Specification-Sheet PPC" => 0, "Specification-Sheet Transfer" => 0);
            $Others = array("Complaint" => 0, "Attendance" => 0, "Quality-Control" => 0, "Production-Planning-Control" => 0, "Super-Admin" => 0);
            $Reports = array("RMA Report" => 0, "Sales Issue" => 0, "Item Adjustment" => 0, "Help Desk Report" => 0, "Job Order Report" => 0, "Job Order Journey" => 0, "Sales Order Report" => 0, 
                            "Transfer Issue Report" => 0, "Item Purchase Report" => 0, "Purchase Rate History" => 0, "M Transfer Against JO" => 0, "Material Consumption" => 0, 
                            "Purchase Order Report" => 0, "Consumption Expection" => 0, "Purchase Invoice Report" => 0, "Work Order Item Costing" => 0, "Consumption Comparison" => 0, "Transfer Ledger Report" => 0,
                            "Transfer Ledger Rate" => 0, "Transfer Issue Rate" => 0, "Material Consumption Rate" => 0, "M Transfer Against All JO" => 0);

            if($request->Reports != NULL){
                for($i=0; $i<count($request->Reports); $i++){ 
                    if($request['Reports'][$i] == "RMA Report") $Reports['RMA Report'] = 1;
                    if($request['Reports'][$i] == "Sales Issue") $Reports['Sales Issue'] = 1;
                    if($request['Reports'][$i] == "Item Adjustment") $Reports['Item Adjustment'] = 1;
                    if($request['Reports'][$i] == "Help Desk Report") $Reports['Help Desk Report'] = 1;
                    if($request['Reports'][$i] == "Job Order Report") $Reports['Job Order Report'] = 1;
                    if($request['Reports'][$i] == "Job Order Journey") $Reports['Job Order Journey'] = 1;
                    if($request['Reports'][$i] == "Sales Order Report") $Reports['Sales Order Report'] = 1;
                    if($request['Reports'][$i] == "Transfer Issue Report") $Reports['Transfer Issue Report'] = 1;
                    if($request['Reports'][$i] == "Item Purchase Report") $Reports['Item Purchase Report'] = 1;
                    if($request['Reports'][$i] == "Purchase Rate History") $Reports['Purchase Rate History'] = 1;
                    if($request['Reports'][$i] == "M Transfer Against JO") $Reports['M Transfer Against JO'] = 1;
                    if($request['Reports'][$i] == "Material Consumption") $Reports['Material Consumption'] = 1;
                    if($request['Reports'][$i] == "Purchase Order Report") $Reports['Purchase Order Report'] = 1;
                    if($request['Reports'][$i] == "Consumption Expection") $Reports['Consumption Expection'] = 1;
                    if($request['Reports'][$i] == "Purchase Invoice Report") $Reports['Purchase Invoice Report'] = 1;
                    if($request['Reports'][$i] == "Work Order Item Costing") $Reports['Work Order Item Costing'] = 1;
                    if($request['Reports'][$i] == "Consumption Comparison") $Reports['Consumption Comparison'] = 1;
                    if($request['Reports'][$i] == "Transfer Ledger Report") $Reports['Transfer Ledger Report'] = 1;
                    if($request['Reports'][$i] == "Transfer Ledger Rate") $Reports['Transfer Ledger Rate'] = 1;
                    if($request['Reports'][$i] == "Transfer Issue Rate") $Reports['Transfer Issue Rate'] = 1;
                    if($request['Reports'][$i] == "Material Consumption Rate") $Reports['Material Consumption Rate'] = 1;
                    if($request['Reports'][$i] == "M Transfer Against All JO") $Reports['M Transfer Against All JO'] = 1;
                }
            }
            else{
                $Reportss = array("RMA Report", "Sales Issue", "Item Adjustment", "Help Desk Report", "Job Order Report", "Job Order Journey", "Sales Order Report", 
                                "Transfer Issue Report", "Item Purchase Report", "Purchase Rate History", "M Transfer Against JO", "Material Consumption", 
                                "Purchase Order Report", "Consumption Expection", "Purchase Invoice Report", "Work Order Item Costing", "Consumption Comparison", "Transfer Ledger Report",
                                "Transfer Ledger Rate", "Transfer Issue Rate", "Material Consumption Rate", "M Transfer Against All JO");
            }
    
            if($request->Others != NULL){
                for($i=0; $i<count($request->Others); $i++){ 
                    if($request['Others'][$i] == "Complaint") $Others['Complaint'] = 1;
                    if($request['Others'][$i] == "Attendance") $Others['Attendance'] = 1;
                    if($request['Others'][$i] == "Quality-Control") $Others['Quality-Control'] = 1;
                    if($request['Others'][$i] == "Production-Planning-Control") $Others['Production-Planning-Control'] = 1;
                    if($request['Others'][$i] == "Super-Admin") $Others['Super-Admin'] = 1;
                }
            }
            else{
                $Otherss = array("Complaint", "Attendance", "Quality-Control", "Production-Planning-Control", "Super-Admin");
            }
    
            if($request->Role != NULL){
                for($i=0; $i<count($request->Role); $i++){ 
                    if($request['Role'][$i] == "Role-List") $Role['Role-List'] = 1;
                    if($request['Role'][$i] == "Role-Create") $Role['Role-Create'] = 1;
                    if($request['Role'][$i] == "Role-Edit") $Role['Role-Edit'] = 1;
                    if($request['Role'][$i] == "Role-Delete") $Role['Role-Delete'] = 1;
                }
            }
            else{
                $Rolee = array("Role-List", "Role-Create", "Role-Edit", "Role-Delete");
            }
    
            if($request->Objective != NULL){
                for($i=0; $i<count($request->Objective); $i++){ 
                    if($request['Objective'][$i] == "Objective-List") $Objective['Objective-List'] = 1;
                    if($request['Objective'][$i] == "Objective-Create") $Objective['Objective-Create'] = 1;
                    if($request['Objective'][$i] == "Objective-Edit") $Objective['Objective-Edit'] = 1;
                    if($request['Objective'][$i] == "Objective-Delete") $Objective['Objective-Delete'] = 1;
                    if($request['Objective'][$i] == "Objective-Status") $Objective['Objective-Status'] = 1;
                    if($request['Objective'][$i] == "Objective-Revision") $Objective['Objective-Revision'] = 1;
                    if($request['Objective'][$i] == "Director-Objective") $Objective['Director-Objective'] = 1;
                }
            }
            else{
                $Objectivee = array("Objective-List", "Objective-Create", "Objective-Edit", "Objective-Delete", "Objective-Status", "Objective-Revision", "Director-Objective");
    
            }
    
            if($request->User != NULL){
                for($i=0; $i<count($request->User); $i++){ 
                    if($request['User'][$i] == "User-List") $User['User-List'] = 1;
                    if($request['User'][$i] == "User-Create") $User['User-Create'] = 1;
                    if($request['User'][$i] == "User-Edit") $User['User-Edit'] = 1;
                    if($request['User'][$i] == "User-Delete") $User['User-Delete'] = 1;
                }
            }
            else{
                $Userr = array("User-List", "User-Create", "User-Edit", "User-Delete");
            }
    
            if($request->JobOrder != NULL){
                for($i=0; $i<count($request->JobOrder); $i++){ 
                    if($request['JobOrder'][$i] == "Job-Order List") $JobOrder['Job-Order List'] = 1;
                    if($request['JobOrder'][$i] == "Job-Order Create") $JobOrder['Job-Order Create'] = 1;
                    if($request['JobOrder'][$i] == "Job-Order Delete") $JobOrder['Job-Order Delete'] = 1;
                    if($request['JobOrder'][$i] == "Job-Order Edit") $JobOrder['Job-Order Edit'] = 1;
                    if($request['JobOrder'][$i] == "Job-Order Transfer") $JobOrder['Job-Order Transfer'] = 1;
                    if($request['JobOrder'][$i] == "Pricing-Sheet List") $JobOrder['Pricing-Sheet List'] = 1;
                    if($request['JobOrder'][$i] == "Pricing-Sheet Create") $JobOrder['Pricing-Sheet Create'] = 1;
                    if($request['JobOrder'][$i] == "Pricing-Sheet Delete") $JobOrder['Pricing-Sheet Delete'] = 1;
                    if($request['JobOrder'][$i] == "Pricing-Sheet Edit") $JobOrder['Pricing-Sheet Edit'] = 1;
                    if($request['JobOrder'][$i] == "Pricing-Sheet Transfer") $JobOrder['Pricing-Sheet Transfer'] = 1;
                    if($request['JobOrder'][$i] == "Pricing-Sheet Costing") $JobOrder['Pricing-Sheet Costing'] = 1;
                    if($request['JobOrder'][$i] == "Pricing-Sheet Sales") $JobOrder['Pricing-Sheet Sales'] = 1;
                    if($request['JobOrder'][$i] == "Pricing-Sheet Production") $JobOrder['Pricing-Sheet Production'] = 1;
                    if($request['JobOrder'][$i] == "PDL Master Data") $JobOrder['PDL Master Data'] = 1;                    
                    if($request['JobOrder'][$i] == "Formula-Sheet List") $JobOrder['Formula-Sheet List'] = 1;
                    if($request['JobOrder'][$i] == "Formula-Sheet Create") $JobOrder['Formula-Sheet Create'] = 1;
                    if($request['JobOrder'][$i] == "Formula-Sheet Delete") $JobOrder['Formula-Sheet Delete'] = 1;
                    if($request['JobOrder'][$i] == "Formula-Sheet Edit") $JobOrder['Formula-Sheet Edit'] = 1;
                    if($request['JobOrder'][$i] == "Specification-Sheet List") $JobOrder['Specification-Sheet List'] = 1;
                    if($request['JobOrder'][$i] == "Specification-Sheet Create") $JobOrder['Specification-Sheet Create'] = 1;
                    if($request['JobOrder'][$i] == "Specification-Sheet Delete") $JobOrder['Specification-Sheet Delete'] = 1;
                    if($request['JobOrder'][$i] == "Specification-Sheet Edit") $JobOrder['Specification-Sheet Edit'] = 1;
                    if($request['JobOrder'][$i] == "Specification-Sheet Costing") $JobOrder['Specification-Sheet Costing'] = 1;
                    if($request['JobOrder'][$i] == "Specification-Sheet Sales") $JobOrder['Specification-Sheet Sales'] = 1;
                    if($request['JobOrder'][$i] == "Specification-Sheet PPC") $JobOrder['Specification-Sheet PPC'] = 1;
                    if($request['JobOrder'][$i] == "Specification-Sheet Transfer") $JobOrder['Specification-Sheet Transfer'] = 1;
                }
            }
            else{
                $JobOrder = array("Job-Order List", "Job-Order Create", "Job-Order Delete", "Job-Order Edit", "Job-Order Transfer", "Pricing-Sheet List", 
                                    "Pricing-Sheet Create", "Pricing-Sheet Delete", "Pricing-Sheet Edit", "Pricing-Sheet Transfer", "Pricing-Sheet Costing", 
                                    "Pricing-Sheet Sales", "Pricing-Sheet Production",  "PDL Master Data", "Formula-Sheet List",  "Formula-Sheet Create", 
                                    "Formula-Sheet Delete", "Formula-Sheet Edit",  "Specification-Sheet List",  "Specification-Sheet Create", "Specification-Sheet Delete", 
                                    "Specification-Sheet Edit", "Specification-Sheet Costing", "Specification-Sheet Sales", "Specification-Sheet PPC", "Specification-Sheet Transfer");
            }

            if($request->Reports != NULL){
                foreach($Reports as $data => $key){
                    $Reportdata[] = [
                        'name' => $name,
                        'role_name' => $data,
                        'role' => "Report",
                        'value' => $key,
                    ];
                }
            }
            else{
                for($i=0; $i<22; $i++){
                    $Reportdata[] = [
                        'name' => $name,
                        'role_name' => $Reportss[$i],
                        'role' => "Report",
                        'value' => 0,
                    ];
                }            
            }
    
            if($request->JobOrder != NULL){
                foreach($JobOrder as $data => $key){
                    $Joborderdata[] = [
                        'name' => $name,
                        'role_name' => $data,
                        'role' => "JobOrder",
                        'value' => $key,
                    ];
                }
            }
            else{
                for($i=0; $i<26; $i++){
                    $Joborderdata[] = [
                        'name' => $name,
                        'role_name' => $JobOrder[$i],
                        'role' => "JobOrder",
                        'value' => 0,
                    ];
                }            
            }
    
            if($request->Others != NULL){
                foreach($Others as $data => $key){
                    $Otherdata[] = [
                        'name' => $name,
                        'role_name' => $data,
                        'role' => "Others",
                        'value' => $key,
                    ];
                }
            }
            else{
                for($i=0; $i<5; $i++){
                    $Otherdata[] = [
                        'name' => $name,
                        'role_name' => $Otherss[$i],
                        'role' => "Others",
                        'value' => 0,
                    ];
                }            
            }
    
            if($request->Role != NULL){
                foreach($Role as $data => $key){
                    $Roledata[] = [
                        'name' => $name,
                        'role_name' => $data,
                        'role' => "Role",
                        'value' => $key,
                    ];
                }
            }
            else{
                for($i=0; $i<4; $i++){
                    $Roledata[] = [
                        'name' => $name,
                        'role_name' => $Rolee[$i],
                        'role' => "Role",
                        'value' => 0,
                    ];
                }            
            }
    
            if($request->Objective != NULL){
                foreach($Objective as $data => $key){
                    $Objectivedata[] = [
                        'name' => $name,
                        'role_name' => $data,
                        'role' => "Objective",
                        'value' => $key,
                    ];
                }
            }
            else{
                for($i=0; $i<7; $i++){
                    $Objectivedata[] = [
                        'name' => $name,
                        'role_name' => $Objectivee[$i],
                        'role' => "Objective",
                        'value' => 0,
                    ];
                }            
            }
    
            if($request->User != NULL){
                foreach($User as $data => $key){
                    $Userdata[] = [
                        'name' => $name,
                        'role_name' => $data,
                        'role' => "User",
                        'value' => $key,
                    ];
                }
            }
            else{
                for($i=0; $i<4; $i++){
                    $Userdata[] = [
                        'name' => $name,
                        'role_name' => $Userr[$i],
                        'role' => "User",
                        'value' => 0,
                    ];
                }            
            }
    
            $RoleName[] = [
                'name' => $name,
            ];
    
            Newrole::where('name', $name)->delete();
            Newrole::insert($Userdata);
            Newrole::insert($Roledata);
            Newrole::insert($Objectivedata);
            Newrole::insert($Joborderdata);
            Newrole::insert($Otherdata);
            Newrole::insert($Reportdata);
            RoleName::insert($RoleName);
            $notification = array(
                'message' => 'Roles Create Successfully!',
                'alert-type' => 'success'
            );
            return redirect()->route('role-manage-new')->with($notification);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function role($id)
    {
        try{
            $update = RoleName::where('name', $id)->pluck('name');
            if(isset($update[0]) == $id){
                $value = 1;
                return response()->json($value);
            }
            else{
                $value = 2;
                return response()->json($value);
            }
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }
}