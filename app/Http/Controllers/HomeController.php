<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use Auth;    
use Exception;
use App\Models\Support;
use App\Models\User;
use App\Models\ObjUser;
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

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try{
            $id = Auth::user()->id;
            $user = User::find($id);
            $emp_code = $user->emp_code;
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
                    JOIN PERIOD_DETAILS PD ON PD.PERIOD_ID = ARM.PERIOD_ID AND PD.PERIOD_ID = 316
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
    
            $DB_Server = "localhost";
            $DB_User = "root";
            $DB_Pass = "";
            $DB_Name = "onsoleportal";
    
            if($emp_code == 10588 || $emp_code == 11322){
                $noAction = Support::orderBy('id','DESC')->where('status', NULL)->get();
                $Process = Support::orderBy('id','DESC')->where('status', 'in process')->get();
                $complete = Support::orderBy('id','DESC')->where('status', 'closed')->get();
                $final = Support::orderBy('id','DESC')->where('status', 'final')->get();
                $total = Support::orderBy('id','DESC')->get();
            }
            else{
                $noAction = Support::orderBy('id','DESC')->where('userid', $id)->where('status', NULL)->get();
                $Process = Support::orderBy('id','DESC')->where('userid', $id)->where('status', 'in process')->get();
                $complete = Support::orderBy('id','DESC')->where('userid', $id)->where('status', 'closed')->get();
                $final = Support::orderBy('id','DESC')->where('userid', $id)->where('status', 'final')->get();
                $total = Support::orderBy('id','DESC')->where('userid', $id)->get();
            }
            $complain = array([
                "null" => count($noAction),
                "process" => count($Process),
                "complete" => count($complete),
                "final" => count($final),
                "total" => count($total),
            ]);
    
            $score = 0;
            $store = array();
            $status1 = 0;
            $emp_code = Auth::user()->emp_code;
            $status1 = ObjUser::orderBy('id','DESC')->where('emp_code', $emp_code)->pluck('status');
            $score = ObjUser::orderBy('id','DESC')->where('emp_code', $emp_code)->pluck('score');
            if(isset($score)){
                $score = 0;
            }else{
                $score = $score[0];
            }
            if(isset($status1)){
                $status1 = 0;
            }else{
                $status1 = $status1[0];
            }
            $data1 = Objectives::orderBy('id','DESC')->where('emp_code', $emp_code)->get();
            $data2 = Objectives::orderBy('id','ASC')->where('emp_code', $emp_code)->get();
            for($i=0;  $i<count($data1)-1; $i++){
                $store[] = array(
                    "title" => $data1[$i]['objTitle'],
                    "description" => $data1[$i]['objDescription'],
                    "rate" => isset($data1[$i]['rate']) ? $data1[$i]['rate'] : "-",
                );
            }
            if(Auth::user()->id == 2){
                $department = User::orderBy('department','ASC')->get()->unique('department')->pluck('department');
                foreach($department as $dataDep){
                    $dataUser = User::orderBy('id','DESC')->where('department', $dataDep)->get();
                    $totalUser[] = array(
                        "count" => count($dataUser),
                        "name" => $dataDep,
                    );
                }
                $total = User::orderBy('id','DESC')->get();
                $objUser = ObjUser::orderBy('id','DESC')->get();
                $terminate = User::orderBy('id','DESC')->where('status', 2)->get();
                $deactive = User::orderBy('id','DESC')->where('status', 3)->get();
                $active = User::orderBy('id','DESC')->where('status', 1)->get();
                return view('admin-dashboard')->with(["name" => $name, "total" => count($total), "totalUser" => $totalUser, "count" => 1, "objUser" => count($objUser), "department" => count($department), "terminate" => count($terminate), "deactive" => count($deactive),"active" => count($active)]);
            }
            return view('user-dashboard')->with(["name"=> $name, "complain"=> $complain[0], "value" => $value[0], "data2" => $data2, "store" => $store, "status1"=> $status1, "score"=> $score, "i"=> 1]);
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
