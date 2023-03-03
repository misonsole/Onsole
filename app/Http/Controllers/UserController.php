<?php
    
namespace App\Http\Controllers;

use DB;
use Hash;
use Auth;    
use Exception;
use App\Models\User;
use App\Models\LoginLog;
use App\Models\RoleName;
use App\Models\UserDetail;
use App\Models\Objectives;
use App\Models\Department;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends Controller
{
    public function boot()
    {
        Paginator::useBootstrap();
    }

    public function username($id)
    {
        try{
            $update = DB::table('users')->where('name', $id)->pluck('name');
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

    public function employee_detail1($name)
    {
        try{
            $name = str_replace(']"',']',str_replace('"[',"[",$name));
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $connPRL = oci_connect("onsole_prl","s",$wizerp);
    
            $sql1 = "SELECT EMP_CODE FROM PAY_EMPLOYEE_MT WHERE EMP_FULL_NAME = '$name'";
            $userdata = oci_parse($connPRL, $sql1);
            oci_execute($userdata);
            $empId = oci_fetch_array($userdata,  OCI_ASSOC+OCI_RETURN_NULLS);
            $EmplyeeCode = $empId['EMP_CODE'];
            return response()->json($EmplyeeCode);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function employee_detail($name)
    {
        try{
            $name = str_replace(']"',']',str_replace('"[',"[",$name));
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $connPRL = oci_connect("onsole_prl","s",$wizerp);
    
            $sql1 = "SELECT PEM.PAY_EMP_ID FROM PAY_EMPLOYEE_MT PEM WHERE EMP_CODE = '$name'";
            $userdata = oci_parse($connPRL, strtoupper($sql1));
            oci_execute($userdata);
            $empId = oci_fetch_array($userdata,  OCI_ASSOC+OCI_RETURN_NULLS);
            $EmplyeeCode = $empId['PAY_EMP_ID'];
    
            $sql11 = "SELECT PDM.DEPARTMENT_DESC, PDMT.PAY_DESIG_DESC
                      FROM PAY_EMP_TRANSFER_MT PETM 
                      JOIN PAY_DEPARTMENT_MT PDM ON PDM.PAY_DEPARTMENT_ID = PETM.NEW_PAY_DEPTT_ID
                      JOIN PAY_DESIG_MT PDMT ON PDMT.PAY_DESIG_ID = PETM.NEW_PAY_DESIG_ID
                      AND PAY_EMP_ID = '$EmplyeeCode' ORDER BY PETM.TRANSFER_DATE DESC";
            $userdata1 = oci_parse($connPRL, strtoupper($sql11));
            oci_execute($userdata1);
            $user = oci_fetch_array($userdata1,  OCI_ASSOC+OCI_RETURN_NULLS);
    
            if($user == false){
                $sql11 = "SELECT PDM.DEPARTMENT_DESC, PDMT.PAY_DESIG_DESC
                          FROM PAY_EMP_HIRING_INFO_MT PEHIM 
                          JOIN PAY_DEPARTMENT_MT PDM ON PDM.PAY_DEPARTMENT_ID = PEHIM.PAY_DEPARTMENT_ID
                          JOIN PAY_DESIG_MT PDMT ON PDMT.PAY_DESIG_ID = PEHIM.PAY_DESIG_ID
                          AND PAY_EMP_ID = '$EmplyeeCode'";
                $userdata1 = oci_parse($connPRL, strtoupper($sql11));
                oci_execute($userdata1);
                $user = oci_fetch_array($userdata1,  OCI_ASSOC+OCI_RETURN_NULLS);
                $final = $user;
            }
            else{
                $final = $user;
            }
            
            $sql1 = "SELECT * FROM pay_employee_mt WHERE EMP_CODE = '$name'";
            $result = oci_parse($connPRL, strtoupper($sql1));
            oci_execute($result);
            $store = array();
            while($resultuser = oci_fetch_array($result,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $store[] = $resultuser;
            }
            $data = array();
            $data[] = array([
                    "firstname" => strtolower($store[0]['EMP_FIRST_NAME']),
                    "name" => strtolower($store[0]['EMP_FULL_NAME']),
                    "lastname" => strtolower($store[0]['EMP_MIDDLE_NAME']." ".$store[0]['EMP_LAST_NAME']),
                    "empcode" => $store[0]['EMP_CODE'],
                    "department" => strtolower($final['DEPARTMENT_DESC']),
                    "designation" => strtolower($final['PAY_DESIG_DESC']),
                ]);
            return response()->json($data[0]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function Signupp(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required',
                'password' => 'required'
            ]);
    
            $credentials = $request->except(['_token']);
            $user = User::where('name',$request->name)->first();
            if($user){
                if($user->status == 1){
                    if(auth()->attempt($credentials)){                  
                        $data = array(
                            'user_id' => Auth::user()->id,
                            'address' => $request->ip(),
                        );
                        LoginLog::insert($data);
                        return redirect()->route('home');
                }
                else{
                    $notification = array(
                        'message' => 'Invalid Credentials!',
                        'alert-type' => 'error'
                    );
                    return redirect()->back()->with($notification);
                }
                }
                else{
                    if($user->status == 2){
                            $notification = array(
                                'message' => 'Your Account has been Deactive',
                                'alert-type' => 'warning'
                            );
                        }
                    elseif($user->status == 3){
                            $notification = array(
                                'message' => 'Your account has been Terminated',
                                'alert-type' => 'warning'
                            );
                        }
                    elseif($user->status == 4){
                            $notification = array(
                                'message' => 'Your account has been Deleted',
                                'alert-type' => 'warning'
                            );
                        }
                    return redirect()->back()->with($notification);
                }
            }
            else{
                $notification = array(
                    'message' => 'Username not Found',
                    'alert-type' => 'error'
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

    public function userManage(Request $request)
    {
        try{
            $data = [];
            $id = Auth::user()->id;
            $user = User::find($id);
            $department = $user->department;
            if($department == "Human Resources"){
                $data = User::orderBy('id','DESC')->where('id', '!=', auth()->id())->get();
                return view('admin.manage-user',compact('data'))->with('i', 1);
            }
            elseif($id == 2){
                $data = User::orderBy('emp_name','ASC')->where('id', '!=', auth()->id())->get();
                return view('admin.manage-user',compact('data'))->with('i', 1);
            }
            elseif($id != 2){
                $data = User::orderBy('emp_name','ASC')->where('id', '!=', auth()->id())->where('department', $department)->get();
                return view('admin.manage-user',compact('data'))->with('i', 1);
            }
            else{
                dd("Else");
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

    public function create(Request $request)
    {
        try{
            $name = array();
            $wizerp  = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $connPRL = oci_connect("onsole_prl","s",$wizerp);
            $sql1 = "SELECT DISTINCT EMP_FULL_NAME, EMP_CODE FROM pay_employee_mt ORDER BY EMP_FULL_NAME ASC";
            $result1 = oci_parse($connPRL, strtoupper($sql1));
            oci_execute($result1);
            while($row1=oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $name[] = array([
                        "name" => strtolower($row1['EMP_FULL_NAME']),
                        "code" => $row1['EMP_CODE'],
                    ]);
            }
            $data = RoleName::orderBy('id','DESC')->where('name', '!=', "Admin")->get();
            $department = Department::orderBy('id','DESC')->get();
            return view('user.user-create',compact('data','department','name'))->with('i',1);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function userEdit(Request $request)
    {
        try{
            $id = $request->id;
            $user = User::find($id);
            $userrole = User::where('id', $id)->pluck('userrole');
            $userdepartment = User::where('id', $id)->pluck('department');
            $userdesignation = User::where('id', $id)->pluck('designation');
            $roles = RoleName::orderBy('id','DESC')->get();
            $department = Department::orderBy('id','DESC')->get();
            $userrole = $userrole[0];
            $userdepartment = $userdepartment[0];
            $userdesignation = $userdesignation[0];
            $users = User::where('id', $id)->get();
            return view('user.user-edit',compact('users','userrole','userdepartment','department','userdesignation','roles'));
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function store(Request $request)
    {
        try{
            $input = $request->all();
            $filename = "0";
            $id = Auth::user()->name;
            $firstname = Auth::user()->firstname;
            $lastname = Auth::user()->lastname;
            if($request->image){
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension(); 
                $filename = time() . '.' . $extension;
                $file->move('uploads/appsetting/', $filename);
            }
            $this->validate($request, [
                'email' => 'required|email|unique:users',
            ]);
            $namefirst = ucwords($input['firstname']);
            $namelast = ucwords($input['lastname']);
            $department = ucwords($input['department']);
            $nameemp = ucwords($input['name']);
            $designation = ucwords($input['designation']);
            $input1 = array([
                'name' => $input['username'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
                'firstname' => $namefirst,
                'lastname' => $namelast,
                'lead_id' => $firstname." ".$lastname,
                'phone' => $input['phone'],
                'designation' => $designation,
                'department' => $department,
                'userrole' => $input['userrole'],
                'emp_code' => $input['emp_name'],
                'emp_name' => $nameemp,
                'image' => $filename,
            ]);
            $user = User::create($input1[0]);
            //Must watch this logic
            $data = User::orderBy('id','DESC')->get();
            $notification = array(
                'message' => 'User Create Successfully!',
                'alert-type' => 'success'
            );
            return redirect()->route('user-manage')->with($notification); 
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function changeImage(Request $request)
    {
        try{
            $filename = "";
            $id = Auth::user()->id;
    
            if($request->image){
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension(); 
                $filename = time() . '.' . $extension;
                $file->move('uploads/appsetting/', $filename);
            }
    
            $input1 = array([
                'image' => $filename,
            ]);
    
            $Add = User::where('id', $id)->update($input1[0]);
            if($Add){
                $notification = array(
                    'message' => 'Profile Changed!',
                    'alert-type' => 'success'
                );
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed. Please try again!',
                    'alert-type' => 'danger'
                );
            }
            return redirect()->route('user-profile')->with($notification); 
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function userManagee(Request $request)
    {
        try{
            $data = [];
            $id = Auth::user()->id;
            if($id == 2){
                $data = User::orderBy('id','DESC')->where('id', '!=', auth()->id())->get();
                return view('user.manage-user')->with(['i' => 1,"success" => 'User created successfully', 'data' => $data]);
            }
            else{
                $userDetail = UserDetail::where('leadId', $id)->pluck('User');
                foreach($userDetail as $dataa => $key){
                    $data[] = User::orderBy('id','DESC')->where('id', $key)->get();
                }
                $data = $data[0];
                return view('user.manage-user',compact('data'));
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

    public function userView(Request $request)
    {
        try{
            $id = $request->id;
            $UserDetail = UserDetail::where('User', $id)->get();
            $Objectives = Objectives::where('memberId', $id)->get();
            $data = array([
                "name" => $UserDetail['FirstName']+" "+$UserDetail['FirstName'],
                "username" => $UserDetail['UserName'],
                "leadname" => "Ansaar",
                "email" => $UserDetail['Email'],
                "designation" => $UserDetail['Designation'],
                "department" => $UserDetail['Department'],
                "role" => $UserDetail['UserRole'],
            ]);
            return view('user.user-view',compact('data'));
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function Edituser(Request $request)
    {
        try{
            $id = $request->id;
            // $this->validate($request, [
            //     'name' => 'required',
            //     'email' => 'required|email|unique:users,email,'.$id,
            // ]);
            $detail = array([
                'name' => $request->username,
                'email' => $request->email,            
                'phone' => $request->phone,
                'userrole' => $request->userrole,
            ]);
            $Det = User::where('id', $id)->update($detail[0]);
            $notification = array(
                'message' => 'User Updated Successfully!',
                'alert-type' => 'success'
            );
            return redirect()->route('user-manage')->with($notification);
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
            $users = User::where('id', $id)->update(['status' => 4]);
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

    public function storeProfile(Request $request)
    {
        try{
            $filename = "0";
            if($request->image){
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension(); 
                $filename = time() . '.' . $extension;
                $file->move('uploads/appsetting/', $filename);
            }
            $rules = [
                'email' => ['required'],
                'PhoneNo' => ['required'],
            ];
            $validator = Validator::make($request->all(), $rules);
            $data = $request->input();
                $id = Auth::user()->id;
                $roles = "Attendance";
                if($request->image){
                    $userDetail = array([
                        'email' => $request->email,
                        'phone' => $request->PhoneNo,
                        'name' => $request->name,
                        'emp_name' => $request->emp_name,
                        'image' => $filename,
                    ]);
                }
                else
                {
                    $userDetail = array([
                        'email' => $request->email,
                        'phone' => $request->PhoneNo,
                        'name' => $request->name,
                        'emp_name' => $request->emp_name,
                    ]);
                }
                $userDetail = User::where('id', $id)->update($userDetail[0]);
                if($userDetail){
                    $notification = array(
                        'message' => 'Profile Updated Successfully!',
                        'alert-type' => 'success'
                    );
                return redirect()->route('user-profile')->with($notification);
                }
                else{
                    $notification = array(
                        'message' => 'Operation Failed. Please try again!',
                        'alert-type' => 'danger'
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
}