<?php
    
namespace App\Http\Controllers;

use DB;
use Auth;
use Session;
use Exception;
use App\Models\User;
use App\Models\ObjUser;
use App\Models\UserDetail;
use App\Models\Objectives; 
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\ObjectiveUser; 
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
    
class ObjectiveController extends Controller
{
    public function createObjUser(Request $request)
    {
        try{
            $store1 = array();
            $store2 = array();
            $store12 = array();
            $store = array();
            $EmpData = array();
            $EmpData1 = array();
            $EmpData3 = array();
            $EmpData14 = array();
            $id = Auth::user()->id;
            $user = User::find($id);
            $department = $user->department;
            $name = $user->firstname." ".$user->lastname;
            $emp_codeNum = $user->emp_code;
            $wizerp  = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $connPRL = oci_connect("onsole_prl","s",$wizerp);
            if($id != 2){
                $sql1 = "SELECT * FROM PAY_DEPARTMENT_MT WHERE DEPARTMENT_DESC = '$department'";
                $dep = "SELECT PAY_DEPARTMENT_ID FROM PAY_DEPARTMENT_MT WHERE DEPARTMENT_DESC = '$department'";
                $result1c = oci_parse($connPRL, $dep);
                oci_execute($result1c);
                $resulct = oci_fetch_array($result1c,  OCI_ASSOC+OCI_RETURN_NULLS);
                $depId = $resulct['PAY_DEPARTMENT_ID'];

                $Query = "SELECT DISTINCT EMP.EMP_FULL_NAME, DM.DEPARTMENT_DESC, EMP.PAY_EMP_ID
                FROM PAY_EMPLOYEE_MT EMP
                JOIN PAY_EMP_HIRING_INFO_MT HIR ON HIR.PAY_EMP_ID = EMP.PAY_EMP_ID
                JOIN PAY_EMP_TRANSFER_MT BB ON EMP.PAY_EMP_ID = BB.PAY_EMP_ID
                JOIN PAY_DEPARTMENT_MT DM ON DM.PAY_DEPARTMENT_ID = BB.NEW_PAY_DEPTT_ID AND DM.PAY_DEPARTMENT_ID = '$depId'
                
                UNION
                
                SELECT DISTINCT EMP.EMP_FULL_NAME, DM.DEPARTMENT_DESC, EMP.PAY_EMP_ID
                FROM PAY_EMPLOYEE_MT EMP
                JOIN PAY_EMP_HIRING_INFO_MT HIR ON HIR.PAY_EMP_ID = EMP.PAY_EMP_ID
                JOIN PAY_DEPARTMENT_MT DM ON DM.PAY_DEPARTMENT_ID = HIR.PAY_DEPARTMENT_ID AND DM.PAY_DEPARTMENT_ID = '$depId'";

                $QueryResult = oci_parse($connPRL, strtoupper($Query));
                oci_execute($QueryResult);
                while($Result = oci_fetch_array($QueryResult,  OCI_ASSOC+OCI_RETURN_NULLS)){
                    $Transfer[] = $Result['PAY_EMP_ID'];
                }
                $Final = array();
                foreach($Transfer as $TransData){
                    $Q1 = "SELECT NEW_PAY_DEPTT_ID, PAY_EMP_ID FROM PAY_EMP_TRANSFER_MT PETM WHERE PAY_EMP_ID = '$TransData'  ORDER BY PETM.TRANSFER_DATE DESC";
                    $R1 = oci_parse($connPRL, $Q1);
                    oci_execute($R1);
                    $Result22 = oci_fetch_array($R1,  OCI_ASSOC+OCI_RETURN_NULLS);
                    if(isset($Result22['NEW_PAY_DEPTT_ID'])){
                    $AA = $Result22['NEW_PAY_DEPTT_ID'];
                        if($AA == $depId){
                            $Final[] = $Result22['PAY_EMP_ID'];
                        }
                        else{
                            $Final1[] = "Result";
                        }
                    }
                    else{
                        $Final[] = $TransData;
                    }
                }
                foreach($Final as $data){
                    $sql111 = "SELECT * FROM PAY_EMP_RESIGN_MT WHERE PAY_EMP_ID = '$data'";
                    $result1111 = oci_parse($connPRL, $sql111);
                    oci_execute($result1111);
                    while($result1112a = oci_fetch_array($result1111,  OCI_ASSOC+OCI_RETURN_NULLS)){
                        $EmpData3[] = array(
                            "name" => $result1112a['PAY_EMP_ID'],
                        );
                    }
                }
                foreach($EmpData3 as $data){
                    if(($key = array_search($data['name'], $Final)) !== false){
                        unset($Final[$key]);
                    }
                }
                foreach($Final as $data){
                    $sql111 = "SELECT * FROM PAY_EMPLOYEE_MT WHERE PAY_EMP_ID = '$data'";
                    $result1111 = oci_parse($connPRL, $sql111);
                    oci_execute($result1111);
                    while($result1112a = oci_fetch_array($result1111,  OCI_ASSOC+OCI_RETURN_NULLS)){
                        $EmpData1[] = array([
                            "name" => $result1112a['EMP_FULL_NAME'],
                            "code" => $result1112a['EMP_CODE'],
                        ]);
                    }
                }
                return view('objective.create-objective-user')->with(['department'=> $department, 'name' => $name, 'empname' => $EmpData1, 'code' => $emp_codeNum]);
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

    public function createUserObj(Request $request)
    {
        try{
            $user = array([
                'name' => $request['name'],
                'department' => $request['department'],
                'lead_name' => $request['leadname'],
                'emp_code' => $request['emp_code'],
            ]);
    
            $update = DB::table('obj_users')->where('emp_code', $request->emp_code)->pluck('emp_code');
            if(isset($update[0]) == $request->emp_code){
                $notification = array(
                    'message' => 'User Already Exists',
                    'alert-type' => 'info'
                );
                return back()->with($notification);
            }
    
            ObjUser::insert($user);
            $notification = array(
                'message' => 'Objective User Created',
                'alert-type' => 'success'
            );
            return redirect()->route('objective-manage-new')->with($notification);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function showAllObj(Request $request)
    {
        try{
            $total = 0;
            $id = Auth::user()->id;
            $user = User::find($id);
            $department = $user->department;
            $name = $request->id;
            $status = ObjUser::orderBy('id','DESC')->where('emp_code', $name)->pluck('status');
            $score = ObjUser::orderBy('id','DESC')->where('emp_code', $name)->pluck('score');
            $score = $score[0];
            $weightage = Objectives::orderBy('id','DESC')->where('emp_code', $name)->pluck('objWeightage');
            foreach($weightage as $result){
                $total = $total + $result;
            }
            $status = $status[0];
            $data = Objectives::orderBy('id','DESC')->where('emp_code', $name)->get();
            $id = Objectives::orderBy('id','DESC')->where('memberName', $name)->pluck('id');
            if($department == "Human Resources"){
                return view('objective.all-obj',compact('data','status','score','total'))->with(['i'=> 1, 'hrr' => 1]);
            }
            else{
                return view('objective.all-obj',compact('data','status','score','total'))->with(['i'=> 1]);
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

    public function showObjective(Request $request)
    {
        try{
            $score = 0;
            $status = 0;
            $emp_code = Auth::user()->emp_code;
            $id = Auth::user()->id;
            $user = User::find($id);
            $department = $user->department;
            $status = ObjUser::orderBy('id','DESC')->where('emp_code', $emp_code)->pluck('status');
            $score = ObjUser::orderBy('id','DESC')->where('emp_code', $emp_code)->pluck('score');
            if(isset($score)){
                $score = 0;
            }else{
                $score = $score[0];
            }
            if(isset($status)){
                $status = 0;
            }else{
                $status = $status[0];
            }
            $data = Objectives::orderBy('id','DESC')->where('emp_code', $emp_code)->get();
            $id = Objectives::orderBy('id','DESC')->where('memberName', $emp_code)->pluck('id');
            return view('objective.all-obj-user',compact('data','status','score'))->with(['i'=> 1]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function objDepartment(Request $request)
    {
        try{
            $id = Auth::user()->id;
            $department = $request->dep;
            $result = Objectives::orderBy('id','DESC')->where('department', $department)->where('objStatus', '!=', 1)->get();
            $data1 = DB::table('objectives')
                ->where('objStatus', '!=', 1)
                ->join('obj_users', 'obj_users.name', '=', 'objectives.MemberName')
                ->select('objectives.*', 'obj_users.score','obj_users.rate')
                ->get();
            foreach($data1 as $value){
                if($value->department != $department){
                    unset($value); 
                }
                else{
                    $data[] = $value;
            
                }
            }
            $dep = Department::orderBy('name','ASC')->get();
            $departmentuser = DB::table("users")->where("id", $id)->pluck('department');
            $departmentuser = $departmentuser[0];
            return view('objective.all-objective',compact('data','dep','department','departmentuser'))->with(['i'=> 1,'j'=> 1]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function allObjective(Request $request)
    {
        try{
            $data = [];
            $id = Auth::user()->id;
            $user = User::find($id);
            $department = $user->department;
            $userrole = $user->userrole;
            $dep1 = "Human Resources";
            $dep2 = "Accounts & Finance";
            $dep3 = "Business Technology";
            $dep4 = "SALES & MARKETING";
            $dep5 = "Production";
            $dep6 = "Costing";
            $dep7 = "Cutting";
            $dep8 = "Production Planning Control";
            $dep9 = "Ware House";
            $dep10 = "Main Store";
            $dep11 = "Product Development";
            $dep12 = "Lasting";
            $dep13 = "Assembly Store";
            $dep14 = "Engineering";
            $dep15 = "Main Store";
            $dep15 = "Tpr Department";
            $dep16 = "Purchase";
            $dep17 = "QUALITY CONTROL";
            $dep18 = "Stitching";
            $dep19 = "Supply Chain";
            $dep20 = "Taxation";
            $departmentuser = DB::table("users")->where("id", $id)->pluck('department');
            $departmentuser = $departmentuser[0];
            if($userrole == "Human Resource"){
                $dep = Department::orderBy('name','ASC')->get();
                $result = Objectives::orderBy('department','DESC')->where('objStatus', '!=', 1)->get();
                $data = DB::table('objectives')->where('objStatus', '!=', 1)->join('obj_users', 'obj_users.name', '=', 'objectives.MemberName')->select('objectives.*', 'obj_users.score','obj_users.rate')->get();
                return view('objective.all-objective',compact('data','dep','department','departmentuser'))->with(['i'=> 1,'j'=> 1]);
            }
            elseif($department == "Admin"){
                $data = Objectives::orderBy('department','DESC')->get();
                return view('objective.all-objective',compact('data','departmentuser'))->with(['i'=> 1,'j'=> 1]);
            }
            elseif($userrole == "Director Objective"){
                if($department == "Accounts & Finance"){
                    $data = Objectives::orderBy('department','DESC')->where('department', $dep1)->Orwhere('department', $dep2)->Orwhere('department', $dep3)->Orwhere('department', $dep20)->get();
                    return view('objective.all-objective',compact('data','departmentuser'))->with(['i'=> 1,'j'=> 1]);
                }
                elseif($department == "Production"){
                    $data = Objectives::orderBy('department','DESC')->where('department', $dep5)->Orwhere('department', $dep6)->Orwhere('department', $dep7)->Orwhere('department', $dep8)      
                                                                                                ->Orwhere('department', $dep9)->Orwhere('department', $dep10)->Orwhere('department', $dep11)
                                                                                                ->Orwhere('department', $dep12)->Orwhere('department', $dep13)->Orwhere('department', $dep14)
                                                                                                ->Orwhere('department', $dep15)->Orwhere('department', $dep16)->Orwhere('department', $dep17)
                                                                                                ->Orwhere('department', $dep18)->Orwhere('department', $dep19)->get();
                    return view('objective.all-objective',compact('data','departmentuser'))->with(['i'=> 1,'j'=> 1]);
                }
                elseif($department == "SALES & MARKETING"){
                    $data = Objectives::orderBy('department','DESC')->where('department', $dep4)->get();
                    return view('objective.all-objective',compact('data','departmentuser'))->with(['i'=> 1,'j'=> 1]);
                }
            }
            else{
                // $data = Objectives::orderBy('id','DESC')->where('department', $department)->where('objStatus', '!=', 1)->get();
                $data1 = DB::table('objectives')->where('objStatus', '!=', 1)->join('obj_users', 'obj_users.name', '=', 'objectives.MemberName')->select('objectives.*', 'obj_users.score','obj_users.rate')->get();
                foreach($data1 as $value){
                    if($value->department != $department){
                        unset($value); 
                    }
                    else{
                        $data[] = $value;
                
                    }
                }
                return view('objective.all-objective',compact('data','departmentuser'))->with(['i'=> 1,'j'=> 1]);
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

    public function objDepartment1(Request $request)
    {
        try{
            $id = Auth::user()->id;
            $department = $request->dep;
            $data = ObjUser::orderBy('id','DESC')->where('status', '!=', 1)->where('department', $department)->get()->unique('name');
            $dep = Department::orderBy('name','ASC')->get();
            $departmentuser = DB::table("users")->where("id", $id)->pluck('department');
            $departmentuser = $departmentuser[0];
            return view('objective.manage-objective-hr',compact('data','dep','department'))->with(['i'=> 1,'hr'=> 1, 'j'=> 1, 'k'=> 1]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function objectiveManageNew(Request $request)
    {
        try{
            $totalUser = [];
            $id = Auth::user()->id;
            $user = User::find($id);
            $department = $user->department;
            $designation = $user->designation;
            $userrole = $user->userrole;
            $dep1 = "Human Resources";
            $dep2 = "Accounts & Finance";
            $dep3 = "Business Technology";
            $dep4 = "SALES & MARKETING";
            $dep5 = "Production";
            $dep6 = "Costing";
            $dep7 = "Cutting";
            $dep8 = "Production Planning Control";
            $dep9 = "Ware House";
            $dep10 = "Main Store";
            $dep11 = "Product Development";
            $dep12 = "Lasting";
            $dep13 = "Assembly Store";
            $dep14 = "Engineering";
            $dep15 = "Main Store";
            $dep15 = "Tpr Department";
            $dep16 = "Purchase";
            $dep17 = "QUALITY CONTROL";
            $dep18 = "Stitching";
            $dep19 = "Supply Chain";
            $dep20 = "Taxation";

            // $designation = DB::table("users")->where("id", $id)->pluck('designation');
            if($userrole == "Human Resource"){
                $dep = Department::orderBy('name','ASC')->get();
                $data = ObjUser::orderBy('name','ASC')->where('status', '!=', 1)->get()->unique('name');
                return view('objective.manage-objective-hr',compact('data','dep','department'))->with(['i'=> 1,'hr'=> 1, 'j'=> 1, 'k'=> 1]);
            }
            elseif($designation == "Super Admin"){
                $data = ObjUser::orderBy('name','ASC')->get()->unique('name');
                return view('objective.manage-objective-admin',compact('data'))->with(['i'=> 1, 'j'=> 1, 'k'=> 1]);
            }
            elseif($userrole == "Director Objective"){
                if($department == "Accounts & Finance"){
                    $data = ObjUser::orderBy('department','ASC')->where('department', $dep1)->Orwhere('department', $dep2)->Orwhere('department', $dep3)->Orwhere('department', $dep20)->get()->unique('name');
                }
                elseif($department == "Production"){
                    $data = ObjUser::orderBy('department','ASC')->where('department', $dep5)->Orwhere('department', $dep6)->Orwhere('department', $dep7)->Orwhere('department', $dep8)      
                                                                                            ->Orwhere('department', $dep9)->Orwhere('department', $dep10)->Orwhere('department', $dep11)
                                                                                            ->Orwhere('department', $dep12)->Orwhere('department', $dep13)->Orwhere('department', $dep14)
                                                                                            ->Orwhere('department', $dep15)->Orwhere('department', $dep16)->Orwhere('department', $dep17)
                                                                                            ->Orwhere('department', $dep18)->Orwhere('department', $dep19)->get()->unique('name');
                }
                elseif($department == "SALES & MARKETING"){
                    $data = ObjUser::orderBy('department','ASC')->where('department', $dep4)->get()->unique('name');
                }
                return view('objective.manage-objective-director',compact('data'))->with(['i'=> 1, 'j'=> 1, 'k'=> 1]);
            }
            else{
                $data = ObjUser::orderBy('name','ASC')->where('department', $department)->get()->unique('name');
                return view('objective.manage-objective',compact('data'))->with(['i'=> 1, 'j'=> 1, 'k'=> 1]);
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

    public function storeObjective(Request $request)
    {
        try{
            $user = [];
            $store = [];
            $id = Auth::user()->id;
            $UserDetail = User::where('id', $id)->get();
            $leadname = $UserDetail[0]['firstname'].' '.$UserDetail[0]['lastname'];
            $count = count($request->Memberid);
            for($i=0; $i<$count; $i++){
               $store[] = $request->objWeightage[$i];
               $final = array_sum($store);
            }
            // if($final > 100){
            //     $notification = array(
            //         'message' => 'Objectives Weightage Above than 100%',
            //         'alert-type' => 'warning'
            //     );
            //     return back()->with($notification);
            // }
            for($i=0; $i<$count; $i++){
                $Memberid = $request->Memberid;
                $Objectives = new Objectives();
                $Objectives->memberName = $request->memberName2[$i];
                $Objectives->emp_code = $request->memberName[$i];
                $Objectives->memberId = 0;
                $Objectives->objTitle = $request->objTitle[$i];
                $Objectives->objDescription = $request->objDescription[$i];
                $Objectives->department = $request->memberDepartment[$i];
                $Objectives->objWeightage = $request->objWeightage[$i];
                $Objectives->comment = $request->comment[$i];
                $Objectives->objStatus = 1;
                $Objectives->leadId = $leadname;
                $Objectives->save();
            }
    
                $RoleName[] = [
                    'name' => $request->memberName[0],
                ];
    
                $ObjectiveUser = ObjectiveUser::insert($RoleName);
                // $Objective = Objectives::insert($user);
                if($ObjectiveUser){
                    $notification = array(
                        'message' => 'Objective Create Successfully!',
                        'alert-type' => 'success'
                    );
                return redirect()->route('objective-manage-new')->with($notification); 
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

    public function EditObj(Request $request)
    {
        try{
            $id = $request->id;
            $users = Objectives::find($id);
            return view('objective.edit-objective',compact('users'));
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function updateObjective(Request $request)
    {
        try{
            $id = $request->id;
            $rules = [
                'memberName' => ['required'],
                'objTitle' => ['required'],
                'objDescription' => ['required'],
                'objWeightage' => ['required'],
            ];
    
            $validator = Validator::make($request->all(), $rules);          
            $userDetail = array([
                'memberName' => $request->memberName,
                'objTitle' => $request->objTitle,
                'objDescription' => $request->objDescription,            
                'objWeightage' => $request->objWeightage,
            ]);
    
            $Objectives = Objectives::where('id', $id)->update($userDetail[0]);
            if($Objectives){
                $notification = array(
                    'message' => 'Objective Updated Successfully!',
                    'alert-type' => 'success'
                );
                return back()->with('success' , $notification);
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed. Please try again!',
                    'alert-type' => 'error'
                );
                return back()->with('error' , $notification);
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

    public function feedback(Request $request)
    {
        try{
            $update = DB::table('objectives')->where('id', $request->userId)->update(['review' => $request->feedback]);
            $notification = array(
                'message' => 'Feedback Submit',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function status($id) 
    {
        try{
            $store = null;
            $status = DB::table('objectives')->where('memberName', $id)->pluck('objWeightage');
            if(count($status)>0){
                foreach($status as $val){
                    $data[] = array(
                        'val' => $val
                    );
                }
                for($i=0; $i<count($status); $i++){
                    $store += $data[$i]['val'];
                }
                if($store != 100){
                    $update = 2;
                    return response()->json($update);
                }
            }
            else{
                $update = 3;
                return response()->json($update);
            }
    
            $update = DB::table('objectives')->where('memberName', $id)->update(['objStatus' => 2]);
            $update1 = DB::table('obj_users')->where('name', $id)->update(['status' => 2]);
            if($update1){
                $update = 1;
                return response()->json($update);
            }
            else{
                $error = 400;
                return response()->json($error);
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

    public function statusAdmin($id,$status,$name) 
    {
        try{
            $update = DB::table('objectives')->where('memberName', $name)->update(['objStatus' => $status]);
            $update1 = DB::table('obj_users')->where('id', $id)->update(['status' => $status]);
            if($update1){
                $update = 1;
                return response()->json($update);
            }
            else{
                $error = 400;
                return response()->json($error);
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

    public function statusHr($id) 
    {
        try{
            $update = DB::table('objectives')->where('memberName', $id)->update(['objStatus' => 4]);
            $update1 = DB::table('obj_users')->where('name', $id)->update(['status' => 4]);
            if($update1){
                $update = 1;
                return response()->json($update);
            }
            else{
                $error = 400;
                return response()->json($error);
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

    public function statusHr2(Request $request) 
    {
        try{
            $id = $request->idd;
            $reason = $request->reason;
            $update = DB::table('objectives')->where('memberName', $id)->update(['objStatus' => 4]);
            $update1 = DB::table('obj_users')->where('name', $id)->update(['status' => 4]);
            $update2 = DB::table('obj_users')->where('name', $id)->update(['reason' => $reason]);
            $update3 = DB::table('obj_users')->where('name', $id)->update(['rating' => 2]);
            if($update1){
                $notification = array(
                    'message' => 'Objective Approved!',
                    'alert-type' => 'yes'
                );
                return back()->with($notification);
            }
            else{
                $notification = array(
                    'message' => 'Something went wrong!',
                    'alert-type' => 'no'
                );
                return back()->with($notification);
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

    public function statusHrRej($id) 
    {
        try{
            $update = DB::table('objectives')->where('memberName', $id)->update(['objStatus' => 3]);
            $update1 = DB::table('obj_users')->where('name', $id)->update(['status' => 3]);
            if($update1){
                $update = 1;
                return response()->json($update);
            }
            else{
                $error = 400;
                return response()->json($error);
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

    public function statusHrRej2(Request $request) 
    {
        try{
            $id = $request->id;
            $reason = $request->reason;
            $update = DB::table('objectives')->where('memberName', $id)->update(['objStatus' => 3]);
            $update1 = DB::table('obj_users')->where('name', $id)->update(['status' => 3]);
            $update2 = DB::table('obj_users')->where('name', $id)->update(['reason' => $reason]);
            if($update1){
                $notification = array(
                    'message' => 'Objective Revised!',
                    'alert-type' => 'yes'
                );
                return back()->with($notification);
            }
            else{
                $notification = array(
                    'message' => 'Something went wrong!',
                    'alert-type' => 'no'
                );
                return back()->with($notification);
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

    public function objectiveManage(Request $request)
    {
        try{
            $id = Auth::user()->id;
            $user = User::find($id);
            $department = $user->department;
            if($id == 2){
                $data = Objectives::orderBy('id','DESC')->get();
            }
            else{
                $data = Objectives::orderBy('id','DESC')->where('department', $department)->get();
            }
            return view('objective.manage-objective',compact('data'))->with('i', 1);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function delete(Request $request, $id)
    {
        try{
            $users = Objectives::where('id', $id)->delete();
            if($users){
                return response()->json($users);
            }
            else{
                $error = 400;
                return response()->json($error);
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

    public function deleteObj(Request $request, $id)
    {
        try{
            $name = ObjUser::where('id', $id)->pluck('name');
            $update = DB::table('objectives')->where('memberName', $name[0])->delete();
            $users = ObjUser::where('id', $id)->delete();
            if($users){
                return response()->json($users);
            }
            else{
                $error = 400;
                return response()->json($error);
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

    public function showId($id)
    {
        try{
            $members = Objectives::where('id', $id)->get();
            return response()->json($members[0]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function showIdUser($id)
    {
        try{
            $members = ObjUser::where('id', $id)->get();
            return response()->json($members[0]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }
    
    public function create(Request $request)
    {
        try{
            $name = $request->id;
            $nameemp = $request->name;
            $id = Auth::user()->id;
            $department = User::where('id', $id)->pluck('department');
            $user = User::where('id', $id)->get();
            $leadname = $user[0]->firstname." ".$user[0]->lastname;
            return view('objective.objective-create')->with(["department"=> $department[0], "name" => $name, "leadname" => $leadname, "empName" => $nameemp]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function updateUserObj(Request $request)
    {
        try{
            $name = $request->name;
            $update = DB::table('objectives')->where('id', $id)->update(['objStatus' => $name]);
            $update1 = DB::table('obj_users')->where('name', $id)->update(['status' => $name]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function Rate(Request $request)
    {
        try{
            $id = $request->rate;
            $rating = $request->rating;
            $DataId = $request->dataId;
            $rate = DB::table('obj_users')->where('name', $id)->pluck('rate');
            if($rate == null){
                if($rate[0] == $rating){
                    $notification = array(
                        'message' => 'Updated',
                        'alert-type' => 'success'
                    );
                }
            }
            else{
                $update1 = DB::table('obj_users')->where('name', $id)->update(['rate' => $rating]);
                $update2 = DB::table('objectives')->where('id', $DataId)->update(['rate' => $rating]);
                if($update1){
                    $notification = array(
                        'message' => 'Updated',
                        'alert-type' => 'success'
                    );
                }
                else{
                    // Will Change Conditon
                    $notification = array(
                        'message' => 'Updated',
                        'alert-type' => 'success'
                    );
                }
            }
            $rate1 = DB::table('obj_users')->where('name', $id)->pluck('rate');
            if($rate1[0] == 'Need Improvement'){
                $update = DB::table('obj_users')->where('name', $id)->update(['score' => 0.25]);
                $update3 = DB::table('objectives')->where('id', $DataId)->update(['score' => 0.25]);
            }
            else if($rate1[0] == 'Meets Expectation'){
                $update = DB::table('obj_users')->where('name', $id)->update(['score' => 0.50]);
                $update3 = DB::table('objectives')->where('id', $DataId)->update(['score' => 0.50]);
            }
            else if($rate1[0] == 'Exceeds Expectation'){
                $update = DB::table('obj_users')->where('name', $id)->update(['score' => 0.75]);
                $update3 = DB::table('objectives')->where('id', $DataId)->update(['score' => 0.75]);
            }
            else if($rate1[0] == 'Outstanding'){
                $update = DB::table('obj_users')->where('name', $id)->update(['score' => 1]);
                $update3 = DB::table('objectives')->where('id', $DataId)->update(['score' => 1]);
            }
            $score = DB::table('objectives')->where('memberName', $id)->pluck('score');
            $total = count($score);
            $store = 0;
            foreach($score as $data){
                $store = $data + $store; 
            }
            $cal = $store/$total;
            $cal1 = $cal*100;
            $cal1 = (int)$cal1;
            $update = DB::table('obj_users')->where('name', $id)->update(['score' => $cal1]);
            $updatescore = DB::table('objectives')->where('memberName', $id)->update(['totalscore' => $cal1]);
            return back()->with($notification); 
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function Rating($id,$DataId,$Val)
    {
        try{
            if($id == 'inlineRadio1'){
                $update = DB::table('obj_users')->where('id', $DataId)->update(['rating' => 1]);
                $update2 = DB::table('objectives')->where('memberName', $Val)->update(['rating' => 1]);
            }
            elseif($id == 'inlineRadio2'){
                $update = DB::table('obj_users')->where('id', $DataId)->update(['rating' => 2]);
                $update2 = DB::table('objectives')->where('memberName', $Val)->update(['rating' => 2]);
            }
            if($update){
                $data = DB::table('obj_users')->where('id', $DataId)->pluck('rating');
                if($data[0] == 1){
                    $store = 1;
                    return response()->json($store);
                }
                elseif($data[0] == 2){
                    $store = 2;
                    return response()->json($store);
                }
    
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

    public function deleteAll(Request $request)
    {
        try{
            $ids = $request->ids;
            $pieces = explode(",", $ids);
            foreach($pieces as $data)
            {
                $update = DB::table('objectives')->where('memberName' ,$data)->update(['objStatus' => 4]);
                $update1 = DB::table('obj_users')->where('name' ,$data)->update(['status' => 4]);
                $update2 = DB::table('obj_users')->where('name' ,$data)->update(['rating' => 2]);
            }
            return response()->json(['success'=>"Status Updated"]);
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