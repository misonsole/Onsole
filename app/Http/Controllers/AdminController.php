<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Hash;
use DateTime;
use Exception;
use App\Models\User;
use App\Models\PlcSole;
use App\Models\LoginLog;
use App\Models\Division;
use App\Models\SubDivision;
use App\Models\PlcShape;
use App\Models\PlcRange;
use App\Models\RoleName;
use App\Models\PlcProject;
use App\Models\PlcPurpose;
use App\Models\PlcLocation;
use App\Models\UserDetail;
use App\Models\Objectives;
use App\Models\Department;
use App\Models\PlcCategory;
use App\Models\PlcSizeRange;
use Illuminate\Http\Request;
use App\Models\PlcLastNumber;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

class AdminController extends Controller
{
    public function masterData(Request $request)
    {
        try{
            $user = User::orderBy('emp_name','ASC')->get();
            $dep = Department::orderBy('name','ASC')->get();
            return view('admin.master-data')->with([
                'data' => $user, 'dep' => $dep, 'i' => 1, 'z' => 1, 'j' => 1, 
            ]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function loginLogs(Request $request)
    {
        try{
            $present = array();
            $data = LoginLog::orderBy('id','DESC')->get();
            return view('admin.login-logs')->with([
                'data' => $data,  'i' => 1
            ]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function masterDataPlc(Request $request)
    {
        try{
            $subdivisionA = array();
            $AllsubdivisionA = array();
            $last = PlcLastNumber::orderBy('id','DESC')->limit(5)->get();
            $Alllast = PlcLastNumber::orderBy('id','DESC')->get();
            $location = PlcLocation::orderBy('id','DESC')->limit(5)->get();
            $Alllocation = PlcLocation::orderBy('id','DESC')->get();
            $range = PlcRange::orderBy('id','DESC')->limit(5)->get();
            $Allrange = PlcRange::orderBy('id','DESC')->get();
            $sole = PlcSole::orderBy('id','DESC')->limit(5)->get();
            $Allsole = PlcSole::orderBy('id','DESC')->get();
            $shape = PlcShape::orderBy('id','DESC')->limit(5)->get();
            $Allshape = PlcShape::orderBy('id','DESC')->get();
            $purpose = PlcPurpose::orderBy('id','DESC')->limit(5)->get();
            $Allpurpose = PlcPurpose::orderBy('id','DESC')->get();
            $project = PlcProject::orderBy('id','DESC')->limit(5)->get();
            $Allproject = PlcProject::orderBy('id','DESC')->get();
            $categoryPlc = PlcCategory::orderBy('id','DESC')->limit(5)->get();
            $AllcategoryPlc = PlcCategory::orderBy('id','DESC')->get();
            $sizerange = PlcSizeRange::orderBy('id','DESC')->limit(5)->get();
            $Allsizerange = PlcSizeRange::orderBy('id','DESC')->get();
            $divisionPlc = Division::orderBy('id','DESC')->limit(5)->get();
            $AlldivisionPlc = Division::orderBy('id','DESC')->get();
            $subdivision = SubDivision::orderBy('id','DESC')->limit(5)->get();
            $Allsubdivision = SubDivision::orderBy('id','DESC')->get();
            foreach($subdivision as $data){
                $result = Division::orderBy('id','DESC')->where('id',$data->division_id)->get();
                $subdivisionA[] = array(
                    'data' => $data,
                    'result' => $result[0]['description'],
                );
            }
            foreach($Allsubdivision as $data){
                $result = Division::orderBy('id','DESC')->where('id',$data->division_id)->get();
                $AllsubdivisionA[] = array(
                    'data' => $data,
                    'result' => $result[0]['description'],
                );
            }

            return view('admin.master-data-plc')->with([
                'i' => 1, 'z' => 1, 'j' => 1, 
                'a' => 1, 'aa' => 1, 'aaa' => 1, 
                'b' => 1, 'bb' => 1, 'bbb' => 1,
                'c' => 1, 'cc' => 1, 'ccc' => 1, 
                'd' => 1, 'dd' => 1, 'ddd' => 1, 
                'e' => 1, 'ee' => 1, 'eee' => 1, 
                'f' => 1, 'ff' => 1, 'fff' => 1, 
                'g' => 1, 'gg' => 1, 'ggg' => 1, 
                'h' => 1, 'hh' => 1, 'hhh' => 1, 
                'i' => 1, 'ii' => 1, 'iii' => 1, 
                'j' => 1, 'jj' => 1, 'jjj' => 1, 
                'k' => 1, 'kk' => 1, 'kkk' => 1, 
                'last'=> $last,'allLast'=> $Alllast, 
                'location' => $location,'Alllocation' => $Alllocation, 
                'range' => $range,'Allrange' => $Allrange, 
                'sole' => $sole,'Allsole' => $Allsole, 
                'shape' => $shape,'Allshape' => $Allshape, 
                'purpose'=> $purpose,'Allpurpose' => $Allpurpose, 
                'categoryPlc' => $categoryPlc,'AllcategoryPlc' => $AllcategoryPlc, 
                'sizerange' => $sizerange,'Allsizerange' => $Allsizerange, 
                'project' => $project,'Allproject' => $Allproject, 
                'divisionPlc' => $divisionPlc,'AlldivisionPlc' => $AlldivisionPlc,
                'subdivision' => $subdivisionA,'Allsubdivision' => $AllsubdivisionA,
                'lastcount' => count($Alllast),
                'locationcount' => count($Alllocation),
                'rangecount' => count($Allrange),
                'sizerangecount' => count($Allsizerange),
                'solecount' => count($Allsole),
                'shapecount' => count($Allshape),
                'purposecount' => count($Allpurpose),
                'projectcount' => count($Allproject),
                'categoryPlccount' => count($AllcategoryPlc),
                'divisionPlccount' => count($AlldivisionPlc),
                'subdivisioncount' => count($Allsubdivision),
            ]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function addDepartment(Request $request)
    {
        try{
            $input1 = array([
                'name' => $request['department'],
                'value' => $request['department']
            ]);
    
            $user = Department::create($input1[0]);
            $notification = array(
                'message' => 'Department Add Successfully!',
                'alert-type' => 'success'
            );
            return redirect()->route('master-data')->with($notification); 
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function changePasswordAdmin(Request $request) 
    {
        try{
            $id = $request->name;
            $userData = array([
                'password' => Hash::make($request->password)            
            ]);
    
            $save = User::where('id', $id)->update($userData[0]);
            if($save){
                $notification = array(
                    'message' => 'Password Successfully Changed!',
                    'alert-type' => 'success'
                );
                return back()->with($notification);
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed. Please try again!',
                    'alert-type' => 'danger'
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

    public function changePassword(Request $request) 
    {
        try{
            if(!(Hash::check($request->get('CurrentPassword'), Auth::user()->password))){
                return redirect()->back()->with("error","Your current password does not matches with the password.");
            }
    
            if(strcmp($request->get('CurrentPassword'), $request->get('Password')) == 0){
                return redirect()->back()->with("error1","New Password cannot be same as your current password.");
            }
            $user = Auth::user();
            $user->password = Hash::make($request->get('Password'));
            $user->save();
            if($user->save()){
                $notification = array(
                    'message' => 'Password Successfully changed!',
                    'alert-type' => 'success'
                );
                return redirect()->back()->with($notification);
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed. Please try again!',
                    'alert-type' => 'danger'
                );
                return redirect()->back()->with($notification);
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

    public function changeStatusAdmin(Request $request)
    {
        try{
            $id = $request->id;
            $userData = array([
                'status' => $request->status          
            ]);
    
            $save = User::where('id', $id)->update($userData[0]);
            if($save){
                $notification = array(
                    'message' => 'Status Successfully Changed!',
                    'alert-type' => 'success'
                );
                return redirect()->back()->with($notification);
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed. Please try again!',
                    'alert-type' => 'danger'
                );
                return redirect()->back()->with($notification);
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

    public function userProfile(Request $request)
    {
        try{
            $User = Auth::user()->id;
            $users = User::where('id', $User)->first();
            $dep = Department::orderBy('id','DESC')->get();
            return view('user.user-profile')->with(['data'=> $users, 'department'=> $dep, 'i' => 1]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function addLast(Request $request)
    {
        try{
            $data = array([
                'last_no' => $request->last,
            ]);
            $Add = PlcLastNumber::insert($data);
            if($Add){
                $notification = array(
                    'message' => 'Last Number Added!',
                    'alert-type' => 'success'
                );
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed. Please try again!',
                    'alert-type' => 'danger'
                );
            }
            return redirect()->route('master-data-plc')->with($notification); 
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function addDivision(Request $request)
    {
        try{
            $data = array([
                'description' => $request->division,
            ]);
            $Add = new Division();
            $Add->description = $request->division;
            $result = $Add->save();
            if($result){
                $notification = array(
                    'message' => 'Division Added',
                    'alert-type' => 'success'
                );
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed. Please try again!',
                    'alert-type' => 'danger'
                );
            }
            return redirect()->route('master-data-plc')->with($notification); 
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function addSubDivision(Request $request)
    {
        try{
            $Add = new SubDivision();
            $Add->division_id = $request->division;
            $Add->description = $request->subdivision; 
            $result = $Add->save();
            if($result){
                $notification = array(
                    'message' => 'Sub Division Added',
                    'alert-type' => 'success'
                );
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed. Please try again!',
                    'alert-type' => 'danger'
                );
            }
            return redirect()->route('master-data-plc')->with($notification); 
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function addShape(Request $request)
    {
        try{
            $data = array([
                'description' => $request->shape,
            ]);
            $Add = PlcShape::insert($data);
            if($Add){
                $notification = array(
                    'message' => 'Shape Added',
                    'alert-type' => 'success'
                );
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed. Please try again!',
                    'alert-type' => 'danger'
                );
            }
            return redirect()->route('master-data-plc')->with($notification);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        } 
    }

    public function addSole(Request $request)
    {
        try{
            $data = array([
                'description' => $request->sole,
            ]);
            $Add = PlcSole::insert($data);
            if($Add){
                $notification = array(
                    'message' => 'Sole Added',
                    'alert-type' => 'success'
                );
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed. Please try again!',
                    'alert-type' => 'danger'
                );
            }
            return redirect()->route('master-data-plc')->with($notification); 
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        } 
    }

    public function addRange(Request $request)
    {
        try{
            $data = array([
                'description' => $request->range,
            ]);
            $Add = PlcRange::insert($data);
            if($Add){
                $notification = array(
                    'message' => 'Range Added',
                    'alert-type' => 'success'
                );
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed. Please try again!',
                    'alert-type' => 'danger'
                );
            }
            return redirect()->route('master-data-plc')->with($notification); 
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        } 
    }

    public function addSizeRange(Request $request)
    {
        try{
            $data = array([
                'description' => $request->sizerange,
            ]);
            $Add = PlcSizeRange::insert($data);
            if($Add){
                $notification = array(
                    'message' => 'Size Range Added',
                    'alert-type' => 'success'
                );
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed. Please try again!',
                    'alert-type' => 'danger'
                );
            }
            return redirect()->route('master-data-plc')->with($notification); 
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        } 
    }

    public function addProject(Request $request)
    {
        try{
            $data = array([
                'description' => $request->project,
            ]);
            $Add = PlcProject::insert($data);
            if($Add){
                $notification = array(
                    'message' => 'Project Added',
                    'alert-type' => 'success'
                );
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed. Please try again!',
                    'alert-type' => 'danger'
                );
            }
            return redirect()->route('master-data-plc')->with($notification); 
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        } 
    }

    public function addPurpose(Request $request)
    {
        try{
            $data = array([
                'description' => $request->purpose,
            ]);
            $Add = PlcPurpose::insert($data);
            if($Add){
                $notification = array(
                    'message' => 'Purpose Added',
                    'alert-type' => 'success'
                );
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed. Please try again!',
                    'alert-type' => 'danger'
                );
            }
            return redirect()->route('master-data-plc')->with($notification); 
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function addCategory(Request $request)
    {
        try{
            $data = array([
                'description' => $request->category,
            ]);
            $Add = PlcCategory::insert($data);
            if($Add){
                $notification = array(
                    'message' => 'Category Added',
                    'alert-type' => 'success'
                );
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed. Please try again!',
                    'alert-type' => 'danger'
                );
            }
            return redirect()->route('master-data-plc')->with($notification); 
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function addLocation(Request $request)
    {
        try{
            $data = array([
                'location_no' => $request->location,
            ]);
            $Add = PlcLocation::insert($data);
            if($Add){
                $notification = array(
                    'message' => 'Location Added!',
                    'alert-type' => 'success'
                );
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed. Please try again!',
                    'alert-type' => 'danger'
                );
            }
            return redirect()->route('master-data-plc')->with($notification); 
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function Attendance(Request $request)
    {
        try{
            $id = Auth::user()->id;
            $user = User::find($id);
            $emp_code = $user->emp_code;
            $emp_name = $user->emp_name;
            $name = array();
            $present = array();
            $restday = array();
            $gernalholiday = array();
            $halfday = array();
            $absent = array();
            $casualleave = array();
            $sickleave = array();
            $casualleave1 = array();
            $complain = array();
            $value = array();
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $connPRL = oci_connect("onsole_prl","s",$wizerp);
            $sql1 = "SELECT PEM.EMP_CODE, PEM.EMP_FULL_NAME, ARD.ATT_DATE, WASM.ATT_STATUS_DESC
                    FROM WIZ_ATT_STATUS_MT WASM
                    JOIN ATT_REGISTER_DET ARD ON ARD.WIZ_ATT_STATUS_ID = WASM.WIZ_ATT_STATUS_ID
                    JOIN ATT_REGISTER_MT ARM ON ARM.ATT_REGISTER_ID = ARD.ATT_REGISTER_ID
                    JOIN PERIOD_DETAILS PD ON PD.PERIOD_ID = ARM.PERIOD_ID AND PD.PERIOD_ID = 310
                    JOIN PAY_EMPLOYEE_MT PEM ON PEM.PAY_EMP_ID = ARM.EMPLOYEE_ID AND PEM.EMP_CODE = '$emp_code'
                    ORDER BY ARD.ATT_DATE DESC";
            $result1 = oci_parse($connPRL, strtoupper($sql1));
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $name[] = array([
                        "code" => $row1['EMP_CODE'],
                        "status" => $row1['ATT_STATUS_DESC'],
                        "name" => $row1['EMP_FULL_NAME'],
                        "date" => $row1['ATT_DATE'],
                        "day" => date('l', strtotime($row1['ATT_DATE']))
                    ]);
            }
            $Username = array();
            $wizerp  = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $connPRL = oci_connect("onsole_prl","s",$wizerp);
            $sql1a = "SELECT DISTINCT EMP_FULL_NAME, EMP_CODE FROM pay_employee_mt ORDER BY EMP_FULL_NAME ASC";
            $result1a = oci_parse($connPRL, strtoupper($sql1a));
            oci_execute($result1a);
            while($rowa1=oci_fetch_array($result1a,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $Username[] = array([
                        "name" => strtolower($rowa1['EMP_FULL_NAME']),
                        "code" => $rowa1['EMP_CODE'],
                    ]);
            }
            foreach($name as $attandence){
                if($attandence[0]['status'] == "Present"){
                    $present[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "Rest Day"){
                    $restday[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "G.H"){
                    $gernalholiday[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "Half Day"){
                    $halfday[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "Absent"){
                    $absent[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "Causal Leave"){
                    $casualleave[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "1/2 Casual Leave"){
                    $casualleave1[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "1/2 Sick Leave"){
                    $sickleave[] = $attandence[0]['status'];
                }
            }
            $persentCount = count($present);
            $restdayCount = count($restday);
            $gernalholidayCount = count($gernalholiday);
            $halfdayCount = count($halfday);
            $absentCount = count($absent);
            $casualleaveCount = count($casualleave);
            $casualleave1Count = count($casualleave1);
            $sickleaveCount = count($sickleave);
            $value = array([
                "persentCount" => $persentCount,
                "restdayCount" => $restdayCount,
                "gernalholidayCount" => $gernalholidayCount,
                "halfdayCount" => $halfdayCount,
                "absentCount" => $absentCount,
                "casualleaveCount" => $casualleaveCount,
                "casualleave1Count" => $casualleave1Count,
                "sickleaveCount" => $sickleaveCount,
            ]);
            $userdepartment = User::where('id', $id)->pluck('emp_code');
            $data = User::orderBy('id','DESC')->where('id', '!=', 2)->get();
            $count = count($Username);
            return view('admin.attandance')->with([
                "NameEmp"=> $emp_name, 
                "CodeEmp"=> $emp_code, 
                "Username"=> $Username, 
                "name"=> $name, 
                "complain"=> isset($complain[0]), 
                "dep"=> 0, 
                "value" => $value[0],
                "data" => $data, 
                "userdepartment"=> $userdepartment[0], 
                "i"=> 1, 
                "j"=> $count
            ]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function UserAttendance(Request $request)
    {
        try{
            $id = Auth::user()->id;
            $user = User::find($id);
            $emp_code = $user->emp_code;
            $emp_name = $user->emp_name;
            $name = array();
            $present = array();
            $restday = array();
            $gernalholiday = array();
            $halfday = array();
            $absent = array();
            $casualleave = array();
            $sickleave = array();
            $casualleave1 = array();
            $complain = array();
            $value = array();
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $connPRL = oci_connect("onsole_prl","s",$wizerp);
            $sql1 = "SELECT PEM.EMP_CODE, PEM.EMP_FULL_NAME, ARD.ATT_DATE, WASM.ATT_STATUS_DESC
                    FROM WIZ_ATT_STATUS_MT WASM
                    JOIN ATT_REGISTER_DET ARD ON ARD.WIZ_ATT_STATUS_ID = WASM.WIZ_ATT_STATUS_ID
                    JOIN ATT_REGISTER_MT ARM ON ARM.ATT_REGISTER_ID = ARD.ATT_REGISTER_ID
                    JOIN PERIOD_DETAILS PD ON PD.PERIOD_ID = ARM.PERIOD_ID AND PD.PERIOD_ID = 310
                    JOIN PAY_EMPLOYEE_MT PEM ON PEM.PAY_EMP_ID = ARM.EMPLOYEE_ID AND PEM.EMP_CODE = '$emp_code'
                    ORDER BY ARD.ATT_DATE DESC";
            $result1 = oci_parse($connPRL, strtoupper($sql1));
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $name[] = array([
                        "code" => $row1['EMP_CODE'],
                        "status" => $row1['ATT_STATUS_DESC'],
                        "name" => $row1['EMP_FULL_NAME'],
                        "date" => $row1['ATT_DATE'],
                        "day" => date('l', strtotime($row1['ATT_DATE']))
                    ]);
            }
    
            $Username = array();
            $wizerp  = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $connPRL = oci_connect("onsole_prl","s",$wizerp);
            $sql1a = "SELECT DISTINCT EMP_FULL_NAME, EMP_CODE FROM pay_employee_mt ORDER BY EMP_FULL_NAME ASC";
            $result1a = oci_parse($connPRL, strtoupper($sql1a));
            oci_execute($result1a);
            while($rowa1=oci_fetch_array($result1a,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $Username[] = array([
                        "name" => strtolower($rowa1['EMP_FULL_NAME']),
                        "code" => $rowa1['EMP_CODE'],
                    ]);
            }
    
            foreach($name as $attandence){
                if($attandence[0]['status'] == "Present"){
                    $present[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "Rest Day"){
                    $restday[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "G.H"){
                    $gernalholiday[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "Half Day"){
                    $halfday[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "Absent"){
                    $absent[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "Causal Leave"){
                    $casualleave[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "1/2 Casual Leave"){
                    $casualleave1[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "1/2 Sick Leave"){
                    $sickleave[] = $attandence[0]['status'];
                }
            }
            $persentCount = count($present);
            $restdayCount = count($restday);
            $gernalholidayCount = count($gernalholiday);
            $halfdayCount = count($halfday);
            $absentCount = count($absent);
            $casualleaveCount = count($casualleave);
            $casualleave1Count = count($casualleave1);
            $sickleaveCount = count($sickleave);
    
            $value = array([
                "persentCount" => $persentCount,
                "restdayCount" => $restdayCount,
                "gernalholidayCount" => $gernalholidayCount,
                "halfdayCount" => $halfdayCount,
                "absentCount" => $absentCount,
                "casualleaveCount" => $casualleaveCount,
                "casualleave1Count" => $casualleave1Count,
                "sickleaveCount" => $sickleaveCount,
            ]);
    
            $userdepartment = User::where('id', $id)->pluck('emp_code');
            $data = User::orderBy('id','DESC')->where('id', '!=', 2)->get();
            $count = count($Username);
            return view('admin.userattandance')->with([
                "NameEmp"=> $emp_name, 
                "CodeEmp"=> $emp_code, 
                "Username"=> $Username, 
                "name"=> $name, 
                "complain"=> isset($complain[0]), 
                "dep"=> 0, 
                "value" => $value[0],
                "data" => $data, 
                "userdepartment"=> $userdepartment[0], 
                "i"=> 1, 
                "j"=> $count
            ]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function DepAttendance(Request $request)
    {
        dd("Here");
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
            
            //Hiring            
            $sql11 = "SELECT PAY_EMP_ID
            FROM PAY_EMP_HIRING_INFO_MT PEHIM 
            JOIN PAY_DEPARTMENT_MT PDM ON PEHIM.PAY_DEPARTMENT_ID = '$depId'";
            $result11zz = oci_parse($connPRL, strtoupper($sql11));
            oci_execute($result11zz);
            while($result111z = oci_fetch_array($result11zz,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $store12[] = $result111z['PAY_EMP_ID'];
            }
            $Emp_Name = array_unique($store12);

            $sql111 = "SELECT PAY_EMP_ID
            FROM PAY_EMP_TRANSFER_MT PETM 
            JOIN PAY_DEPARTMENT_MT PDM ON PETM.NEW_PAY_DEPTT_ID = '$depId'";
            $result11zzz = oci_parse($connPRL, strtoupper($sql111));
            oci_execute($result11zzz);
            while($fresult111z = oci_fetch_array($result11zzz,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $store122[] = $fresult111z['PAY_EMP_ID'];
            }
            $Emp_Name2 = array_unique($store122);

            $resultasasa = array_diff($Emp_Name, $Emp_Name2);
            $storeeee = array_unique(array_merge($Emp_Name,$Emp_Name2));
            foreach($storeeee as $data){
                $sql111 = "SELECT * FROM PAY_EMP_RESIGN_MT WHERE PAY_EMP_ID = '$data'";
                $result1111 = oci_parse($connPRL, $sql111);
                oci_execute($result1111);
                while($result1112a = oci_fetch_array($result1111,  OCI_ASSOC+OCI_RETURN_NULLS)){
                    $EmpData3[] = array([
                        "name" => $result1112a['PAY_EMP_ID'],
                    ]);
                }
            }
            foreach($EmpData3[0] as $data){
                $array = array('apple', 'orange', 'strawberry', 'blueberry', 'kiwi');
                if (($key = array_search($data['name'], $storeeee)) !== false) {
                    unset($storeeee[$key]);
                }
            }

            foreach($storeeee as $data){
                $sql111 = "SELECT * FROM PAY_EMPLOYEE_MT WHERE PAY_EMP_ID = '$data'";
                $result1111 = oci_parse($connPRL, $sql111);
                oci_execute($result1111);
                while($result1112a = oci_fetch_array($result1111,  OCI_ASSOC+OCI_RETURN_NULLS)){
                    $EmpData1[] = array(
                        "name" => $result1112a['EMP_FULL_NAME'],
                        "code" => $result1112a['EMP_CODE'],
                    );
                }
            }
            return view('admin.depattandance1')->with(['department'=> $department, 'name' => $name, 'empname' => $EmpData1, 'code' => $emp_codeNum]);
        }
    }

    public function GetAttendance(Request $request)
    {
        try{
            $month = $request->month;
            $delimiter = '-';
            $words = explode($delimiter, $month);
            $dateObj   = DateTime::createFromFormat('!m', $words[1]);
            $monthName = $dateObj->format('F');
            $empMonth = $monthName.' '.$words[0];
            if($month == "2022-01"){
                $period_id = 301; 
            }
            elseif($month == "2022-02"){
                $period_id = 302; 
            }
            elseif($month == "2022-03"){
                $period_id = 303; 
            }
            elseif($month == "2022-04"){
                $period_id = 304; 
            }
            elseif($month == "2022-05"){
                $period_id = 305; 
            }
            elseif($month == "2022-06"){
                $period_id = 306; 
            }
            elseif($month == "2022-07"){
                $period_id = 307; 
            }
            elseif($month == "2022-08"){
                $period_id = 308; 
            }
            elseif($month == "2022-09"){
                $period_id = 309; 
            }
            elseif($month == "2022-10"){
                $period_id = 310; 
            }
            elseif($month == "2022-11"){
                $period_id = 311; 
            }
            elseif($month == "2022-12"){
                $period_id = 312; 
            }
            elseif($month == "2021-01"){
                $period_id = 289; 
            }
            elseif($month == "2021-02"){
                $period_id = 290; 
            }
            elseif($month == "2021-03"){
                $period_id = 291; 
            }
            elseif($month == "2021-04"){
                $period_id = 292; 
            }
            elseif($month == "2021-05"){
                $period_id = 293; 
            }
            elseif($month == "2021-06"){
                $period_id = 294; 
            }
            elseif($month == "2021-07"){
                $period_id = 295; 
            }
            elseif($month == "2021-08"){
                $period_id = 296; 
            }
            elseif($month == "2021-09"){
                $period_id = 297; 
            }
            elseif($month == "2021-10"){
                $period_id = 298; 
            }
            elseif($month == "2021-11"){
                $period_id = 299; 
            }
            elseif($month == "2021-12"){
                $period_id = 300; 
            }
            elseif($month == "2020-01"){
                $period_id = 277; 
            }
            elseif($month == "2020-02"){
                $period_id = 278; 
            }
            elseif($month == "2020-03"){
                $period_id = 279; 
            }
            elseif($month == "2020-04"){
                $period_id = 280; 
            }
            elseif($month == "2020-05"){
                $period_id = 281; 
            }
            elseif($month == "2020-06"){
                $period_id = 282; 
            }
            elseif($month == "2020-07"){
                $period_id = 283; 
            }
            elseif($month == "2020-08"){
                $period_id = 284; 
            }
            elseif($month == "2020-09"){
                $period_id = 285; 
            }
            elseif($month == "2020-10"){
                $period_id = 286; 
            }
            elseif($month == "2020-11"){
                $period_id = 287; 
            }
            elseif($month == "2020-12"){
                $period_id = 288; 
            }
            else{
                $period_id = 309; 
            }
            $id = Auth::user()->id;
            $user = User::find($id);
            $emp_code = $request->emp_name1;
            $name11 = strtolower($request->name11);
            $name = array();
            $present = array();
            $restday = array();
            $gernalholiday = array();
            $halfday = array();
            $absent = array();
            $casualleave = array();
            $sickleave = array();
            $casualleave1 = array();
            $complain = array();
            $value = array();
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $connPRL = oci_connect("onsole_prl","s",$wizerp);
            $sql1 = "SELECT PEM.EMP_CODE, PEM.EMP_FULL_NAME, ARD.ATT_DATE, WASM.ATT_STATUS_DESC
                    FROM WIZ_ATT_STATUS_MT WASM
                    JOIN ATT_REGISTER_DET ARD ON ARD.WIZ_ATT_STATUS_ID = WASM.WIZ_ATT_STATUS_ID
                    JOIN ATT_REGISTER_MT ARM ON ARM.ATT_REGISTER_ID = ARD.ATT_REGISTER_ID
                    JOIN PERIOD_DETAILS PD ON PD.PERIOD_ID = ARM.PERIOD_ID AND PD.PERIOD_ID = '$period_id'
                    JOIN PAY_EMPLOYEE_MT PEM ON PEM.PAY_EMP_ID = ARM.EMPLOYEE_ID AND PEM.EMP_CODE = '$emp_code'
                    ORDER BY ARD.ATT_DATE DESC";
            $result1 = oci_parse($connPRL, strtoupper($sql1));
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $name[] = array([
                        "code" => $row1['EMP_CODE'],
                        "status" => $row1['ATT_STATUS_DESC'],
                        "name" => $row1['EMP_FULL_NAME'],
                        "date" => $row1['ATT_DATE'],
                        "day" => date('l', strtotime($row1['ATT_DATE']))
                    ]);
            }
            $Username = array();
            $wizerp  = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $connPRL = oci_connect("onsole_prl","s",$wizerp);
            $sql1a = "SELECT DISTINCT EMP_FULL_NAME, EMP_CODE FROM pay_employee_mt ORDER BY EMP_FULL_NAME ASC";
            $result1a = oci_parse($connPRL, strtoupper($sql1a));
            oci_execute($result1a);
            while($rowa1=oci_fetch_array($result1a,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $Username[] = array([
                        "name" => strtolower($rowa1['EMP_FULL_NAME']),
                        "code" => $rowa1['EMP_CODE'],
                    ]);
            }
            foreach($name as $attandence){
                if($attandence[0]['status'] == "Present"){
                    $present[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "Rest Day"){
                    $restday[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "G.H"){
                    $gernalholiday[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "Half Day"){
                    $halfday[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "Absent"){
                    $absent[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "Causal Leave"){
                    $casualleave[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "1/2 Casual Leave"){
                    $casualleave1[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "1/2 Sick Leave"){
                    $sickleave[] = $attandence[0]['status'];
                }
            }
            $persentCount = count($present);
            $restdayCount = count($restday);
            $gernalholidayCount = count($gernalholiday);
            $halfdayCount = count($halfday);
            $absentCount = count($absent);
            $casualleaveCount = count($casualleave);
            $casualleave1Count = count($casualleave1);
            $sickleaveCount = count($sickleave);
            $value = array([
                "persentCount" => $persentCount,
                "restdayCount" => $restdayCount,
                "gernalholidayCount" => $gernalholidayCount,
                "halfdayCount" => $halfdayCount,
                "absentCount" => $absentCount,
                "casualleaveCount" => $casualleaveCount,
                "casualleave1Count" => $casualleave1Count,
                "sickleaveCount" => $sickleaveCount,
            ]);
            $userdepartment = User::where('id', $id)->pluck('emp_code');
            $data = User::orderBy('id','DESC')->where('id', '!=', 2)->get();
            $count = count($Username);
            return view('admin.attandance')->with([
                "empMonth"=> $empMonth, 
                "empName"=> $name11, 
                "empCode"=> $emp_code, 
                "Username"=> $Username, 
                "name"=> $name, 
                "complain"=> isset($complain[0]), 
                "dep"=> 0, 
                "value" => $value[0],
                "data" => $data, 
                "userdepartment"=> $emp_code, 
                "i"=> 1, 
                "j"=> $count
            ]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function GetUserAttendance(Request $request)
    {
        try{
            $month = $request->month;
            $delimiter = '-';
            $words = explode($delimiter, $month);
            $dateObj   = DateTime::createFromFormat('!m', $words[1]);
            $monthName = $dateObj->format('F');
            $empMonth = $monthName.' '.$words[0];
            if($month == "2022-01"){
                $period_id = 301; 
            }
            elseif($month == "2022-02"){
                $period_id = 302; 
            }
            elseif($month == "2022-03"){
                $period_id = 303; 
            }
            elseif($month == "2022-04"){
                $period_id = 304; 
            }
            elseif($month == "2022-05"){
                $period_id = 305; 
            }
            elseif($month == "2022-06"){
                $period_id = 306; 
            }
            elseif($month == "2022-07"){
                $period_id = 307; 
            }
            elseif($month == "2022-08"){
                $period_id = 308; 
            }
            elseif($month == "2022-09"){
                $period_id = 309; 
            }
            elseif($month == "2022-10"){
                $period_id = 310; 
            }
            elseif($month == "2022-11"){
                $period_id = 311; 
            }
            elseif($month == "2022-12"){
                $period_id = 312; 
            }
            elseif($month == "2021-01"){
                $period_id = 289; 
            }
            elseif($month == "2021-02"){
                $period_id = 290; 
            }
            elseif($month == "2021-03"){
                $period_id = 291; 
            }
            elseif($month == "2021-04"){
                $period_id = 292; 
            }
            elseif($month == "2021-05"){
                $period_id = 293; 
            }
            elseif($month == "2021-06"){
                $period_id = 294; 
            }
            elseif($month == "2021-07"){
                $period_id = 295; 
            }
            elseif($month == "2021-08"){
                $period_id = 296; 
            }
            elseif($month == "2021-09"){
                $period_id = 297; 
            }
            elseif($month == "2021-10"){
                $period_id = 298; 
            }
            elseif($month == "2021-11"){
                $period_id = 299; 
            }
            elseif($month == "2021-12"){
                $period_id = 300; 
            }
            elseif($month == "2020-01"){
                $period_id = 277; 
            }
            elseif($month == "2020-02"){
                $period_id = 278; 
            }
            elseif($month == "2020-03"){
                $period_id = 279; 
            }
            elseif($month == "2020-04"){
                $period_id = 280; 
            }
            elseif($month == "2020-05"){
                $period_id = 281; 
            }
            elseif($month == "2020-06"){
                $period_id = 282; 
            }
            elseif($month == "2020-07"){
                $period_id = 283; 
            }
            elseif($month == "2020-08"){
                $period_id = 284; 
            }
            elseif($month == "2020-09"){
                $period_id = 285; 
            }
            elseif($month == "2020-10"){
                $period_id = 286; 
            }
            elseif($month == "2020-11"){
                $period_id = 287; 
            }
            elseif($month == "2020-12"){
                $period_id = 288; 
            }
            else{
                $period_id = 309; 
            }
            $id = Auth::user()->id;
            $user = User::find($id);
            $emp_code = Auth::user()->emp_code;
            $emp_name = Auth::user()->emp_name;
            $name11 = strtolower($request->name11);
            $name = array();
            $present = array();
            $restday = array();
            $gernalholiday = array();
            $halfday = array();
            $absent = array();
            $casualleave = array();
            $sickleave = array();
            $casualleave1 = array();
            $complain = array();
            $value = array();
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $connPRL = oci_connect("onsole_prl","s",$wizerp);
            $sql1 = "SELECT PEM.EMP_CODE, PEM.EMP_FULL_NAME, ARD.ATT_DATE, WASM.ATT_STATUS_DESC
                    FROM WIZ_ATT_STATUS_MT WASM
                    JOIN ATT_REGISTER_DET ARD ON ARD.WIZ_ATT_STATUS_ID = WASM.WIZ_ATT_STATUS_ID
                    JOIN ATT_REGISTER_MT ARM ON ARM.ATT_REGISTER_ID = ARD.ATT_REGISTER_ID
                    JOIN PERIOD_DETAILS PD ON PD.PERIOD_ID = ARM.PERIOD_ID AND PD.PERIOD_ID = '$period_id'
                    JOIN PAY_EMPLOYEE_MT PEM ON PEM.PAY_EMP_ID = ARM.EMPLOYEE_ID AND PEM.EMP_CODE = '$emp_code'
                    ORDER BY ARD.ATT_DATE DESC";
            $result1 = oci_parse($connPRL, strtoupper($sql1));
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $name[] = array([
                        "code" => $row1['EMP_CODE'],
                        "status" => $row1['ATT_STATUS_DESC'],
                        "name" => $row1['EMP_FULL_NAME'],
                        "date" => $row1['ATT_DATE'],
                        "day" => date('l', strtotime($row1['ATT_DATE']))
                    ]);
            }
            $Username = array();
            $wizerp  = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $connPRL = oci_connect("onsole_prl","s",$wizerp);
            $sql1a = "SELECT DISTINCT EMP_FULL_NAME, EMP_CODE FROM pay_employee_mt ORDER BY EMP_FULL_NAME ASC";
            $result1a = oci_parse($connPRL, strtoupper($sql1a));
            oci_execute($result1a);
            while($rowa1=oci_fetch_array($result1a,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $Username[] = array([
                        "name" => strtolower($rowa1['EMP_FULL_NAME']),
                        "code" => $rowa1['EMP_CODE'],
                    ]);
            }
            foreach($name as $attandence){
                if($attandence[0]['status'] == "Present"){
                    $present[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "Rest Day"){
                    $restday[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "G.H"){
                    $gernalholiday[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "Half Day"){
                    $halfday[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "Absent"){
                    $absent[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "Causal Leave"){
                    $casualleave[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "1/2 Casual Leave"){
                    $casualleave1[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "1/2 Sick Leave"){
                    $sickleave[] = $attandence[0]['status'];
                }
            }
            $persentCount = count($present);
            $restdayCount = count($restday);
            $gernalholidayCount = count($gernalholiday);
            $halfdayCount = count($halfday);
            $absentCount = count($absent);
            $casualleaveCount = count($casualleave);
            $casualleave1Count = count($casualleave1);
            $sickleaveCount = count($sickleave);
            $value = array([
                "persentCount" => $persentCount,
                "restdayCount" => $restdayCount,
                "gernalholidayCount" => $gernalholidayCount,
                "halfdayCount" => $halfdayCount,
                "absentCount" => $absentCount,
                "casualleaveCount" => $casualleaveCount,
                "casualleave1Count" => $casualleave1Count,
                "sickleaveCount" => $sickleaveCount,
            ]);
            $userdepartment = User::where('id', $id)->pluck('emp_code');
            $data = User::orderBy('id','DESC')->where('id', '!=', 2)->get();
            $count = count($Username);
            return view('admin.userattandance')->with([
                "empMonth"=> $empMonth, 
                "empName"=> $name11, 
                "empCode"=> $emp_code,
                "Username"=> $Username, 
                "name"=> $name, 
                "complain"=> isset($complain[0]), 
                "dep"=> 0, 
                "value" => $value[0],
                "data" => $data, 
                "userdepartment"=> $emp_code, 
                "i"=> 1, 
                "j"=> $count
            ]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function GetDepAttendance(Request $request)
    {
        try{
            $month = $request->month;
            $delimiter = '-';
            $words = explode($delimiter, $month);
            $dateObj   = DateTime::createFromFormat('!m', $words[1]);
            $monthName = $dateObj->format('F');
            $empMonth = $monthName.' '.$words[0];
            if($month == "2022-01"){
                $period_id = 301; 
            }
            elseif($month == "2022-02"){
                $period_id = 302; 
            }
            elseif($month == "2022-03"){
                $period_id = 303; 
            }
            elseif($month == "2022-04"){
                $period_id = 304; 
            }
            elseif($month == "2022-05"){
                $period_id = 305; 
            }
            elseif($month == "2022-06"){
                $period_id = 306; 
            }
            elseif($month == "2022-07"){
                $period_id = 307; 
            }
            elseif($month == "2022-08"){
                $period_id = 308; 
            }
            elseif($month == "2022-09"){
                $period_id = 309; 
            }
            elseif($month == "2022-10"){
                $period_id = 310; 
            }
            elseif($month == "2022-11"){
                $period_id = 311; 
            }
            elseif($month == "2022-12"){
                $period_id = 312; 
            }
            elseif($month == "2021-01"){
                $period_id = 289; 
            }
            elseif($month == "2021-02"){
                $period_id = 290; 
            }
            elseif($month == "2021-03"){
                $period_id = 291; 
            }
            elseif($month == "2021-04"){
                $period_id = 292; 
            }
            elseif($month == "2021-05"){
                $period_id = 293; 
            }
            elseif($month == "2021-06"){
                $period_id = 294; 
            }
            elseif($month == "2021-07"){
                $period_id = 295; 
            }
            elseif($month == "2021-08"){
                $period_id = 296; 
            }
            elseif($month == "2021-09"){
                $period_id = 297; 
            }
            elseif($month == "2021-10"){
                $period_id = 298; 
            }
            elseif($month == "2021-11"){
                $period_id = 299; 
            }
            elseif($month == "2021-12"){
                $period_id = 300; 
            }
            elseif($month == "2020-01"){
                $period_id = 277; 
            }
            elseif($month == "2020-02"){
                $period_id = 278; 
            }
            elseif($month == "2020-03"){
                $period_id = 279; 
            }
            elseif($month == "2020-04"){
                $period_id = 280; 
            }
            elseif($month == "2020-05"){
                $period_id = 281; 
            }
            elseif($month == "2020-06"){
                $period_id = 282; 
            }
            elseif($month == "2020-07"){
                $period_id = 283; 
            }
            elseif($month == "2020-08"){
                $period_id = 284; 
            }
            elseif($month == "2020-09"){
                $period_id = 285; 
            }
            elseif($month == "2020-10"){
                $period_id = 286; 
            }
            elseif($month == "2020-11"){
                $period_id = 287; 
            }
            elseif($month == "2020-12"){
                $period_id = 288; 
            }
            else{
                $period_id = 309; 
            }
            $id = Auth::user()->id;
            $user = User::find($id);
            $emp_code = $request->name;
            $emp_name = Auth::user()->emp_name;
            $name11 = strtolower($request->name11);
            $name = array();
            $present = array();
            $restday = array();
            $gernalholiday = array();
            $halfday = array();
            $absent = array();
            $casualleave = array();
            $sickleave = array();
            $casualleave1 = array();
            $complain = array();
            $value = array();
            $department = $user->department;
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $connPRL = oci_connect("onsole_prl","s",$wizerp);
            $sql51 = "SELECT PEM.EMP_CODE, PEM.EMP_FULL_NAME, ARD.ATT_DATE, WASM.ATT_STATUS_DESC
                    FROM WIZ_ATT_STATUS_MT WASM
                    JOIN ATT_REGISTER_DET ARD ON ARD.WIZ_ATT_STATUS_ID = WASM.WIZ_ATT_STATUS_ID
                    JOIN ATT_REGISTER_MT ARM ON ARM.ATT_REGISTER_ID = ARD.ATT_REGISTER_ID
                    JOIN PERIOD_DETAILS PD ON PD.PERIOD_ID = ARM.PERIOD_ID AND PD.PERIOD_ID = '$period_id'
                    JOIN PAY_EMPLOYEE_MT PEM ON PEM.PAY_EMP_ID = ARM.EMPLOYEE_ID AND PEM.EMP_CODE = '$emp_code'
                    ORDER BY ARD.ATT_DATE DESC";
            $result1 = oci_parse($connPRL, strtoupper($sql51));
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $name[] = array([
                        "code" => $row1['EMP_CODE'],
                        "status" => $row1['ATT_STATUS_DESC'],
                        "name" => $row1['EMP_FULL_NAME'],
                        "date" => $row1['ATT_DATE'],
                        "day" => date('l', strtotime($row1['ATT_DATE']))
                    ]);
            }
            
            $sql1 = "SELECT * FROM PAY_DEPARTMENT_MT WHERE DEPARTMENT_DESC = '$department'";
            $dep = "SELECT PAY_DEPARTMENT_ID FROM PAY_DEPARTMENT_MT WHERE DEPARTMENT_DESC = '$department'";
            $result1c = oci_parse($connPRL, $dep);
            oci_execute($result1c);
            $resulct = oci_fetch_array($result1c,  OCI_ASSOC+OCI_RETURN_NULLS);
            $depId = $resulct['PAY_DEPARTMENT_ID'];
            
            //Hiring            
            $sql11 = "SELECT PAY_EMP_ID
            FROM PAY_EMP_HIRING_INFO_MT PEHIM 
            JOIN PAY_DEPARTMENT_MT PDM ON PEHIM.PAY_DEPARTMENT_ID = '$depId'";
            $result11zz = oci_parse($connPRL, strtoupper($sql11));
            oci_execute($result11zz);
            while($result111z = oci_fetch_array($result11zz,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $store12[] = $result111z['PAY_EMP_ID'];
            }
            $Emp_Name = array_unique($store12);
    
            $sql111 = "SELECT PAY_EMP_ID
            FROM PAY_EMP_TRANSFER_MT PETM 
            JOIN PAY_DEPARTMENT_MT PDM ON PETM.NEW_PAY_DEPTT_ID = '$depId'";
            $result11zzz = oci_parse($connPRL, strtoupper($sql111));
            oci_execute($result11zzz);
            while($fresult111z = oci_fetch_array($result11zzz,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $store122[] = $fresult111z['PAY_EMP_ID'];
            }
            $Emp_Name2 = array_unique($store122);
    
            $resultasasa = array_diff($Emp_Name, $Emp_Name2);
            $storeeee = array_unique(array_merge($Emp_Name,$Emp_Name2));
            foreach($storeeee as $data){
                $sql111 = "SELECT * FROM PAY_EMP_RESIGN_MT WHERE PAY_EMP_ID = '$data'";
                $result1111 = oci_parse($connPRL, $sql111);
                oci_execute($result1111);
                while($result1112a = oci_fetch_array($result1111,  OCI_ASSOC+OCI_RETURN_NULLS)){
                    $EmpData3[] = array([
                        "name" => $result1112a['PAY_EMP_ID'],
                    ]);
                }
            }
            foreach($EmpData3[0] as $data){
                $array = array('apple', 'orange', 'strawberry', 'blueberry', 'kiwi');
                if (($key = array_search($data['name'], $storeeee)) !== false) {
                    unset($storeeee[$key]);
                }
            }
    
            foreach($storeeee as $data){
                $sql111 = "SELECT * FROM PAY_EMPLOYEE_MT WHERE PAY_EMP_ID = '$data'";
                $result1111 = oci_parse($connPRL, $sql111);
                oci_execute($result1111);
                while($result1112a = oci_fetch_array($result1111,  OCI_ASSOC+OCI_RETURN_NULLS)){
                    $EmpData1[] = array(
                        "name" => $result1112a['EMP_FULL_NAME'],
                        "code" => $result1112a['EMP_CODE'],
                    );
                }
            }
    
            foreach($name as $attandence){
                if($attandence[0]['status'] == "Present"){
                    $present[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "Rest Day"){
                    $restday[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "G.H"){
                    $gernalholiday[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "Half Day"){
                    $halfday[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "Absent"){
                    $absent[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "Causal Leave"){
                    $casualleave[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "1/2 Casual Leave"){
                    $casualleave1[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "1/2 Sick Leave"){
                    $sickleave[] = $attandence[0]['status'];
                }
            }
            $persentCount = count($present);
            $restdayCount = count($restday);
            $gernalholidayCount = count($gernalholiday);
            $halfdayCount = count($halfday);
            $absentCount = count($absent);
            $casualleaveCount = count($casualleave);
            $casualleave1Count = count($casualleave1);
            $sickleaveCount = count($sickleave);
    
            $value = array([
                "persentCount" => $persentCount,
                "restdayCount" => $restdayCount,
                "gernalholidayCount" => $gernalholidayCount,
                "halfdayCount" => $halfdayCount,
                "absentCount" => $absentCount,
                "casualleaveCount" => $casualleaveCount,
                "casualleave1Count" => $casualleave1Count,
                "sickleaveCount" => $sickleaveCount,
            ]);
    
            $userdepartment = User::where('id', $id)->pluck('emp_code');
            $data = User::orderBy('id','DESC')->where('id', '!=', 2)->get();
            $count = count($EmpData1);
            return view('admin.depattandance1')->with([
                "empMonth"=> $empMonth, 
                // "empName"=> $name11, 
                "empCode"=> $emp_code,
                "empname"=> $EmpData1, 
                "name"=> $name, 
                "complain"=> isset($complain[0]), 
                "dep"=> 0, 
                "value" => $value[0],
                "data" => $data, 
                "userdepartment"=> $emp_code, 
                "i"=> 1, 
                "j"=> $count
            ]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function weather(Request $request)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://weatherbit-v1-mashape.p.rapidapi.com/current?lon=74.358749&lat=31.520370",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: weatherbit-v1-mashape.p.rapidapi.com",
                "X-RapidAPI-Key: 733a311c91mshcbeb2b1d00ea5edp14e71ajsn172a96ce53e2"
            ],
        ]);
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        echo '<pre>';
        print_r($response);
    }

    public function Department(Request $request)
    {
        try{
            $id = Auth::user()->id;
            $user = User::find($id);
            $emp_code = $user->emp_code;
            $emp_name = $user->emp_name;
            $name = array();
            $present = array();
            $restday = array();
            $gernalholiday = array();
            $halfday = array();
            $absent = array();
            $casualleave = array();
            $sickleave = array();
            $casualleave1 = array();
            $complain = array();
            $value = array();
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $connPRL = oci_connect("onsole_prl","s",$wizerp);
            $sql1 = "SELECT PEM.EMP_CODE, PEM.EMP_FULL_NAME, ARD.ATT_DATE, WASM.ATT_STATUS_DESC
                    FROM WIZ_ATT_STATUS_MT WASM
                    JOIN ATT_REGISTER_DET ARD ON ARD.WIZ_ATT_STATUS_ID = WASM.WIZ_ATT_STATUS_ID
                    JOIN ATT_REGISTER_MT ARM ON ARM.ATT_REGISTER_ID = ARD.ATT_REGISTER_ID
                    JOIN PERIOD_DETAILS PD ON PD.PERIOD_ID = ARM.PERIOD_ID AND PD.PERIOD_ID = 310
                    JOIN PAY_EMPLOYEE_MT PEM ON PEM.PAY_EMP_ID = ARM.EMPLOYEE_ID AND PEM.EMP_CODE = '$emp_code'
                    ORDER BY ARD.ATT_DATE DESC";
            $result1 = oci_parse($connPRL, strtoupper($sql1));
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $name[] = array([
                        "code" => $row1['EMP_CODE'],
                        "status" => $row1['ATT_STATUS_DESC'],
                        "name" => $row1['EMP_FULL_NAME'],
                        "date" => $row1['ATT_DATE'],
                        "day" => date('l', strtotime($row1['ATT_DATE']))
                    ]);
            }
            $Username = array();
            $wizerp  = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $connPRL = oci_connect("onsole_prl","s",$wizerp);
            $sql1a = "SELECT DISTINCT EMP_FULL_NAME, EMP_CODE FROM pay_employee_mt ORDER BY EMP_FULL_NAME ASC";
            $result1a = oci_parse($connPRL, strtoupper($sql1a));
            oci_execute($result1a);
            while($rowa1=oci_fetch_array($result1a,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $Username[] = array([
                        "name" => strtolower($rowa1['EMP_FULL_NAME']),
                        "code" => $rowa1['EMP_CODE'],
                    ]);
            }
            foreach($name as $attandence){
                if($attandence[0]['status'] == "Present"){
                    $present[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "Rest Day"){
                    $restday[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "G.H"){
                    $gernalholiday[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "Half Day"){
                    $halfday[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "Absent"){
                    $absent[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "Causal Leave"){
                    $casualleave[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "1/2 Casual Leave"){
                    $casualleave1[] = $attandence[0]['status'];
                }
                elseif($attandence[0]['status'] == "1/2 Sick Leave"){
                    $sickleave[] = $attandence[0]['status'];
                }
            }
            $persentCount = count($present);
            $restdayCount = count($restday);
            $gernalholidayCount = count($gernalholiday);
            $halfdayCount = count($halfday);
            $absentCount = count($absent);
            $casualleaveCount = count($casualleave);
            $casualleave1Count = count($casualleave1);
            $sickleaveCount = count($sickleave);
            $value = array([
                "persentCount" => $persentCount,
                "restdayCount" => $restdayCount,
                "gernalholidayCount" => $gernalholidayCount,
                "halfdayCount" => $halfdayCount,
                "absentCount" => $absentCount,
                "casualleaveCount" => $casualleaveCount,
                "casualleave1Count" => $casualleave1Count,
                "sickleaveCount" => $sickleaveCount,
            ]);
            $userdepartment = User::where('id', $id)->pluck('emp_code');
            $department = Department::orderBy('id','DESC')->get();
            $data = User::orderBy('id','DESC')->where('id', '!=', 2)->get();
            $count = count($Username);
            return view('admin.depattandance')->with([
                "NameEmp"=> $emp_name, 
                "department"=> $department, 
                "CodeEmp"=> $emp_code, 
                "Username"=> $Username, 
                "name"=> $name, 
                "complain"=> isset($complain[0]), 
                "dep"=> 0, 
                "value" => $value[0],
                "data" => $data, 
                "userdepartment"=> $userdepartment[0], 
                "i"=> 1, 
                "j"=> $count
            ]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function Last(Request $request) 
    {
        try{
            $id = $request->lastId;
            $last = $request->lastNum;
            $update = DB::table('plc_last_numbers')->where('id', $id)->update(['last_no' => $last]);
            if($update){
                $notification = array(
                    'message' => 'Updated',
                    'alert-type' => 'success'
                );
                return back()->with($notification); 
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed',
                    'alert-type' => 'error'
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

    public function Location(Request $request) 
    {
        try{
            $id = $request->locId;
            $last = $request->locNum;
            $update = DB::table('plc_locations')->where('id', $id)->update(['location_no' => $last]);
            if($update){
                $notification = array(
                    'message' => 'Updated',
                    'alert-type' => 'success'
                );
                return back()->with($notification); 
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed',
                    'alert-type' => 'error'
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

    public function Purpose(Request $request) 
    {
        try{
            $id = $request->purposeId;
            $last = $request->purposeNum;
            $update = DB::table('plc_purposes')->where('id', $id)->update(['description' => $last]);
            if($update){
                $notification = array(
                    'message' => 'Updated',
                    'alert-type' => 'success'
                );
                return back()->with($notification); 
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed',
                    'alert-type' => 'error'
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

    public function Project(Request $request) 
    {
        try{
            $id = $request->projectId;
            $last = $request->projectNum;
            $update = DB::table('plc_projects')->where('id', $id)->update(['description' => $last]);
            if($update){
                $notification = array(
                    'message' => 'Updated',
                    'alert-type' => 'success'
                );
                return back()->with($notification); 
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed',
                    'alert-type' => 'error'
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

    public function Range(Request $request) 
    {
        try{
            $id = $request->rangeId;
            $last = $request->rangeNum;
            $update = DB::table('plc_ranges')->where('id', $id)->update(['description' => $last]);
            if($update){
                $notification = array(
                    'message' => 'Updated',
                    'alert-type' => 'success'
                );
                return back()->with($notification); 
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed',
                    'alert-type' => 'error'
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

    public function sizeRange(Request $request) 
    {
        try{
            $id = $request->sizerangeId;
            $last = $request->sizerangeNum;
            $update = DB::table('plc_size_ranges')->where('id', $id)->update(['description' => $last]);
            if($update){
                $notification = array(
                    'message' => 'Updated',
                    'alert-type' => 'success'
                );
                return back()->with($notification); 
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed',
                    'alert-type' => 'error'
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

    public function Sole(Request $request) 
    {
        try{
            $id = $request->soleId;
            $last = $request->soleNum;
            $update = DB::table('plc_soles')->where('id', $id)->update(['description' => $last]);
            if($update){
                $notification = array(
                    'message' => 'Updated',
                    'alert-type' => 'success'
                );
                return back()->with($notification); 
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed',
                    'alert-type' => 'error'
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

    public function Shape(Request $request) 
    {
        try{
            $id = $request->shapeId;
            $last = $request->shapeNum;
            $update = DB::table('plc_shapes')->where('id', $id)->update(['description' => $last]);
            if($update){
                $notification = array(
                    'message' => 'Updated',
                    'alert-type' => 'success'
                );
                return back()->with($notification); 
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed',
                    'alert-type' => 'error'
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

    public function Category(Request $request) 
    {
        try{
            $id = $request->catId;
            $last = $request->catNum;
            $update = DB::table('plc_categories')->where('id', $id)->update(['description' => $last]);
            if($update){
                $notification = array(
                    'message' => 'Updated',
                    'alert-type' => 'success'
                );
                return back()->with($notification); 
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed',
                    'alert-type' => 'error'
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

    public function Division(Request $request) 
    {
        try{
            $id = $request->divisionId;
            $last = $request->divisionNum;
            $update = DB::table('divisions')->where('id', $id)->update(['description' => $last]);
            if($update){
                $notification = array(
                    'message' => 'Updated',
                    'alert-type' => 'success'
                );
                return back()->with($notification); 
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed',
                    'alert-type' => 'error'
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

    public function SubDivision(Request $request) 
    {
        try{
            $id = $request->subdivisionId;
            $last = $request->subdivisionNum;
            $update = DB::table('sub_divisions')->where('id', $id)->update(['description' => $last]);
            if($update){
                $notification = array(
                    'message' => 'Updated',
                    'alert-type' => 'success'
                );
                return back()->with($notification); 
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed',
                    'alert-type' => 'error'
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

    public function lastDel($id) 
    {
        try{
            $update = PlcLastNumber::where('id', $id)->delete();
            if($update){
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

    public function locDel($id) 
    {
        try{
            $update = PlcLocation::where('id', $id)->delete();
            if($update){
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

    public function shapeDel($id) 
    {
        try{
            $update = PlcShape::where('id', $id)->delete();
            if($update){
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

    public function soleDel($id) 
    {
        try{
            $update = PlcSole::where('id', $id)->delete();
            if($update){
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

    public function catDel($id) 
    {
        try{
            $update = PlcCategory::where('id', $id)->delete();
            if($update){
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

    public function rangeDel($id) 
    {
        try{
            $update = PlcRange::where('id', $id)->delete();
            if($update){
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

    public function sizerangeDel($id) 
    {
        try{
            $update = PlcSizeRange::where('id', $id)->delete();
            if($update){
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

    public function divisionDel($id) 
    {
        try{
            $update = Division::where('id', $id)->delete();
            if($update){
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

    public function subdivisionDel($id) 
    {
        try{
            $update = SubDivision::where('id', $id)->delete();
            if($update){
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

    public function purposeDel($id) 
    {
        try{
            $update = PlcPurpose::where('id', $id)->delete();
            if($update){
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

    public function projectDel($id) 
    {
        try{
            $update = PlcProject::where('id', $id)->delete();
            if($update){
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

    public function updateJoborder(Request $request)
    {
        $wizerp  = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
        $connPRL = oci_connect("onsole","s",$wizerp);
        $getResult = DB::table('job_sheet_order_det')->orderBy('id','ASC')->get()->unique('Rm_Code')->pluck('Rm_Code');
        $getResult2 = DB::table('imports')->orderBy('id','ASC')->get();
        dd($getResult2);
        foreach($getResult2 as $getResult2a){
            $data = DB::table('job_sheet_order_det')->where('Rm_Code', $getResult2a->rmcode)->update(['Item_Id' => $getResult2a->item_id, 'Job_Desc' => $getResult2a->Job_desc]);
        }
        dd("Done");
        dd(count($getResult)/2,count($getResult));
        $Store1 = array();
        $Store2 = array();
        for($i=0; $i<count($getResult); $i++){
            $Store1[$i] = $getResult[$i];
        }
        for($j=0; $j<count($getResult); $j++){
            $sql = "SELECT * FROM ITEMS_MT WHERE ITEM_CODE = '$Store1[$j]'";
            $result = oci_parse($connPRL, strtoupper($sql));
            oci_execute($result);
            while($row = oci_fetch_array($result,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $data = DB::table('imports')->insert(['rmcode' => $Store1[$j], 'item_id' => $row['ITEM_ID'], 'Job_desc' => $row['ITEM_LARGE_DESC']]);

            }
        }
    }
}
