<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Hash;
use DateTime;
use Exception;
use App\Models\User;
use App\Models\Support;
use App\Models\Newrole;
use App\Models\Category;
use App\Models\RoleName;
use App\Models\LastNumber;
use App\Models\UserDetail;
use App\Models\Objectives;
use App\Models\Department;
use App\Models\SubCategory; 
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\SupportDetail;
use App\Models\notifications;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\notification_details;
use Illuminate\Support\Facades\Validator;

class ComplaintController extends Controller
{
    public function Category($id)
    {
        try{
            $Support = SubCategory::orderBy('id','ASC')->where('category', $id)->get();
            foreach($Support as $data){
                $value[] = $data['category_desc'];
            }
            return response()->json($value);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function Edit(Request $request)
    {
        try{
            $id = $request->id;
            $Support = Support::orderBy('id','ASC')->where('id', $id)->get();
            $usercategory = $Support[0]['category'];
            $usersubcategory = $Support[0]['subcategory'];
            $userstype = $Support[0]['type'];
            $dep = Department::orderBy('id','DESC')->get();
            $Category = Category::orderBy('id','DESC')->limit(5)->get();
            $SubCategory = SubCategory::orderBy('id','DESC')->get();
            return view('admin.support-case-edit')->with([
                'usercategory'=> $usercategory, 'usersubcategory'=> $usersubcategory, 'userstype'=> $userstype, 
                'data'=> $Support[0], 'dep'=> $dep, 'category'=> $Category, 'SubCategory'=> $SubCategory
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

    public function masterData1(Request $request)
    {
        try{
            $user = user::orderBy('id','DESC')->get();
            $dep = Department::orderBy('id','DESC')->get();
            $Category = Category::orderBy('id','DESC')->limit(5)->get();
            $allCategory = Category::orderBy('id','ASC')->get();
            $SubCategory = SubCategory::orderBy('id','DESC')->get();
            return view('admin.master-settings')->with([
                'i' => 1, 'j' => 1, 'z' => 1, 'dep'=> $dep, 'data'=> $user, 'count' => count($allCategory), 'category'=>
                $Category, 'allCategory'=> $allCategory, 'SubCategory'=> $SubCategory 
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

    public function addCategory(Request $request)
    {
        try{
            $input1 = array([
                'category' => $request['category'],
                'category_desc' => $request['category_desc']
            ]);
    
            $user = Category::create($input1[0]);
            $notification = array(
                'message' => 'Category Add Created!',
                'alert-type' => 'success'
            );
            return redirect()->route('master-settings')->with($notification); 
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function addSubCategory(Request $request)
    {
        try{
            $input1 = array([
                'category' => $request['category'],
                'category_desc' => $request['category_desc']
            ]);
    
            $user = SubCategory::create($input1[0]);
            $notification = array(
                'message' => 'Sub Category Created!',
                'alert-type' => 'success'
            );
            return redirect()->route('master-settings')->with($notification); 
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function supportCase(Request $request)
    {
        try{
            $store = 1;
            $dep = Department::orderBy('id','DESC')->get();
            $Category = Category::orderBy('id','DESC')->limit(5)->get();
            $SubCategory = SubCategory::orderBy('id','DESC')->get();
            $Support = Support::orderBy('id','DESC')->limit(1)->get();
            if(count($Support) == 0){
                $result = $store + 0;
            }
            else{
                $result = $store + $Support[0]->id;
            }
            return view('admin.support-case')->with(['dep'=> $dep, 'category'=> $Category, 'SubCategory'=> $SubCategory, 'complaint_No'=> $result]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function Store(Request $request)
    {
        try{
            $result = array();
            date_default_timezone_set("Asia/karachi");
            $time = date("h:i A");
            $month1 = date("M");
            $date = date("d-F-Y");
            $month = $request->month;
            $delimiter = '-';
            $words = explode($delimiter, $month);
            $id = Auth::user()->id;
            $name = Auth::user()->emp_name;
            $image = Auth::user()->image;
            $filename = "0";
            $input = $request->all();
            if($request->doc){
                $file = $request->file('doc');
                $extension = $file->getClientOriginalExtension(); 
                $filename = time() . '.' . $extension;
                $file->move('uploads/appsetting/', $filename);
            }
            $complaint = Support::orderBy('id','DESC')->get();
            $input1 = array([
                'userid' => $id,
                'username' => $name,
                'month' => $month1,
                'complaint' => $input['complaint_id'],
                'category' => $input['category'],
                'subcategory' => $input['subcategory'],
                'type' => $input['type'],
                'dep' => $input['dep'],
                'nature' => $input['nature'],
                'message' => $input['message'],
                'doc' => $filename,
                'date' => $date,
                'time' => $time,
            ]);
            $store1 = Support::create($input1[0]);
            $input2 = array([
                'data' => $date,
                'event_at' => 'New Complaint',
                'complaint_id' => $store1['id']
            ]);
            $user = notifications::create($input2[0]);
            $Noti_id = $user['id'];
            $assign_users = Newrole::orderBy('id','ASC')->where('role_name', 'Complaint')->where('value', 1)->get()->unique('name');
            foreach($assign_users as $data){
                $store[] = $data['name'];
            }
            foreach($store as $data){
                $get_users[] = User::orderBy('id','ASC')->where('userrole', $data)->pluck('id');
                $get_users[] = $get_users[0];
            } 
            foreach($get_users as $value){
                if(count($value) != 0){
                    foreach($value as $val){
                        $result[] = $val;
                    }
                }
            }
            $result = array_unique($result);
            foreach($result as $dataa){
                $input3 = array([
                    'notification_id' => $Noti_id,
                    'assign_users' => $dataa,
                    'event' => 'New Complaint',
                    'url' => 'complaints-view',
                    'complaint' => $input['complaint_id'],
                    'complaint_id' => $store1['id'],
                    'userid' => $id,
                    'name' => $name,
                    'image' => $image,
                ]);
                $user = notification_details::create($input3[0]);
            }
            if($store1 && $user && $user){
                $notification = array(
                    'message' => 'Complaint Submitted',
                    'alert-type' => 'success'
                );
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed. Please try again!',
                    'alert-type' => 'danger'
                );
            }
            return redirect()->route('manage-complaints-user')->with($notification); 
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function Update(Request $request)
    {
        try{
            $input = $request->all();
            $input1 = array([
                'category' => $input['category'],
                'subcategory' => $input['subcategory'],
                'type' => $input['type'],
                'message' => $input['message'],
            ]);
    
            $store1 = DB::table('supports')->where('id', $input['id'])->update($input1[0]);
            if($store1){
                $notification = array(
                    'message' => 'Complaint Updated',
                    'alert-type' => 'success'
                );
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed. Please try again!',
                    'alert-type' => 'danger'
                );
            }
            return redirect()->route('manage-complaints-user')->with($notification); 
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function Support(Request $request)
    {
        try{
            $chat = 0;
            $event = "New Message";
            date_default_timezone_set("Asia/karachi");
            $time = date("G:i:s");
            $date = date("d-m-Y");
            $complaintNo = $request->complaint;
            $id = Auth::user()->id;
            $name = Auth::user()->emp_name;
            $image = Auth::user()->image;
            $input = $request->all();
            $complaint = Support::orderBy('id','DESC')->get();
            $input1 = array([
                'approve_by' => $name,
                'status' => $request->status,
                'update_time' => $date." ".$time,
            ]);
    
            if($request->status == 'final'){
                $event = "Complaint Closed";
            }
            if($request->status == 'in process'){
                $event = "Complaint In Process";
            }
            $input2 = array([
                'support_id' => $request->complaint,
                'message' => $request->message,
                'sender' => Auth::user()->id,
                'receiver' => $request->id,
                'update_time' => $date." ".$time,
                'complaint_id' => $request->complaint_id
            ]);
    
            $input2aa = array([
                'data' => $date,
                'event_at' => $event,
                'complaint_id' => $request->complaint_id
            ]);
            $notifications = notifications::create($input2aa[0]);
            $Noti_id = $notifications['id'];
            $assign_users = Newrole::orderBy('id','ASC')->where('role_name', 'Complaint')->where('value', 1)->get()->unique('name');
            foreach($assign_users as $data){
                $store[] = $data['name'];
            }
            foreach($store as $data){
                $get_users[] = User::orderBy('id','ASC')->where('userrole', $data)->pluck('id');
                $get_users[] = $get_users[0];
            } 
            foreach($get_users as $value){
                if(count($value) != 0){
                    foreach($value as $val){
                        $result[] = $val;
                    }
                }
            }    
            $result = array_unique($result);
            foreach($result as $dataa){
                $input3 = array([
                    'notification_id' => $Noti_id,
                    'assign_users' => $dataa,
                    'event' => $event,
                    'url' => 'complaints-view',
                    'complaint' => $input['complaint_id'],
                    'complaint_id' => $request->complaint_id,
                    'userid' => $request->id,
                    'name' => $name,
                    'image' => $image,
                ]);
                $user = notification_details::create($input3[0]);
            }
            notification_details::where('notification_id', $Noti_id)->where('assign_users', Auth::user()->id)->delete();
            // Don't Remeber Login
            $store3 = array([
                'notification_id' => $Noti_id,
                'assign_users' => $request->id,
                'event' => $event,
                'url' => 'complaints-view-user',
                'complaint' => $input['complaint_id'],
                'complaint_id' => $request->complaint_id,
                'userid' => $request->id,
                'name' => $name,
                'image' => $image,
            ]);
            $user4 = notification_details::create($store3[0]);
    
            $create = SupportDetail::create($input2[0]);
            $SupportDetail = SupportDetail::orderBy('id','ASC')->where('support_id', $complaintNo)->get();
            if(count($SupportDetail) > 0){
                $chat = 1;
            }
            $user = Support::where('complaint', $complaintNo)->update($input1[0]);
            $users = User::orderBy('id','DESC')->where('id', $request->id)->get();
            $data = Support::orderBy('id','DESC')->where('complaint', $complaintNo)->get();
            return back();
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function countComplain(Request $request)
    {
        try{
            date_default_timezone_set("Asia/karachi");
            $time = date("M");
            $Months = Support::orderBy('id','ASC')->where('month', $time)->get()->unique('date')->pluck('date');    
            foreach($Months as $data){
                $NoAction = Support::orderBy('id','DESC')->where('date', $data)->where('status', NULL)->get();
                $InProcess = Support::orderBy('id','DESC')->where('date', $data)->where('status', 'in process')->get();
                $Complete = Support::orderBy('id','DESC')->where('date', $data)->where('status', 'closed')->get();
                $Closed = Support::orderBy('id','DESC')->where('date', $data)->where('status', 'final')->get();
                $var = $data;
                $newDate = date("d-M", strtotime($var));
                $show = (int)$newDate;
                $result[] = [
                    'NoAction' => count($NoAction),
                    'InProcess' => count($InProcess),
                    'Complete' => count($Complete),
                    'Closed' => count($Closed),
                    'Month' => $newDate,
                ];
            }
            return response()->json($result);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function countComplainHome(Request $request)
    {
        try{
            $department = User::orderBy('department','ASC')->get()->unique('department')->pluck('department');
            foreach($department as $dataDep){
                $dataUser = User::orderBy('id','DESC')->where('department', $dataDep)->get();
                $totalUser[] = array(
                    "count" => count($dataUser),
                    "name" => $dataDep,
                );
            }
            return response()->json($totalUser);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function manageComplaints(Request $request)
    {   
        try{
            $diff = 'empty';
            $lastupdate = Support::orderBy('id','DESC')->limit(1)->get();
            date_default_timezone_set("Asia/karachi");
            $time = date("h:i A");
            $datetime2 = new DateTime($time);
            if(count($lastupdate) > 0){
                $month = $lastupdate[0]['created_at'];
                $delimiter = ' ';
                $words = explode($delimiter, $month);
                $datetime3 = new DateTime($lastupdate[0]['created_at']);
                $interval = $datetime2->diff($datetime3);
                $diff = $interval->format('%d Day, %h Hour, %i min');
            }
            $present = array();
            $support = Support::latest()->take(25)->get();
            foreach($support as $data){
                $department = User::orderBy('id','DESC')->limit(1)->where('id', $data['userid'])->get();
                if(isset($department[0])){
                    $present[] = [
                        'department' => $department[0]->department,
                        'name' => $department[0]->emp_name,
                        'data' => $data
                    ]; 
                }
            }
            $noAction = Support::orderBy('id','DESC')->where('status', NULL)->get();
            $Process = Support::orderBy('id','DESC')->where('status', 'in process')->get();
            $complete = Support::orderBy('id','DESC')->where('status', 'closed')->get();
            $final = Support::orderBy('id','DESC')->where('status', 'final')->get();
            $total = Support::orderBy('id','DESC')->get();
            return view('helpdesk.manage-complaints')->with([
                    'support'=> $present,  
                    'noAction'=> count($noAction),   
                    'Process'=> count($Process), 
                    'complete'=> count($complete),
                    'final'=> count($final), 
                    'total'=> count($total),
                    'diff'=> $diff,
                    'i'=> 1
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

    public function manageAllComplaints(Request $request)
    {   
        try{
            $diff = 'empty';
            $lastupdate = Support::orderBy('id','DESC')->limit(1)->get();
            date_default_timezone_set("Asia/karachi");
            $time = date("h:i A");
            $datetime2 = new DateTime($time);
            if(count($lastupdate) > 0){
                $month = $lastupdate[0]['created_at'];
                $delimiter = ' ';
                $words = explode($delimiter, $month);
                $datetime3 = new DateTime($lastupdate[0]['created_at']);
                $interval = $datetime2->diff($datetime3);
                $diff = $interval->format('%d Day, %h Hour, %i min');
            }
            $present = array();
            $support = Support::orderBy('id','DESC')->get();
            foreach($support as $data){
                $department = User::orderBy('id','DESC')->limit(1)->where('id', $data['userid'])->get();
                if(isset($department[0])){
                    $present[] = [
                        'department' => $department[0]->department,
                        'name' => $department[0]->emp_name,
                        'data' => $data
                    ]; 
                }
            }
            $noAction = Support::orderBy('id','DESC')->where('status', NULL)->get();
            $Process = Support::orderBy('id','DESC')->where('status', 'in process')->get();
            $complete = Support::orderBy('id','DESC')->where('status', 'closed')->get();
            $final = Support::orderBy('id','DESC')->where('status', 'final')->get();
            $total = Support::orderBy('id','DESC')->get();
            return view('helpdesk.manage-all-complaints')->with([
                    'support'=> $present,  
                    'noAction'=> count($noAction),   
                    'Process'=> count($Process), 
                    'complete'=> count($complete),
                    'final'=> count($final), 
                    'total'=> count($total),
                    'diff'=> $diff,
                    'i'=> 1
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

    public function manageUsersComplaint(Request $request)
    {
        try{
            $id = Auth::user()->id;
            $present = array();
            $support = Support::orderBy('id','DESC')->where('userid', $id)->get();
            foreach($support as $data){
                $department = User::orderBy('id','DESC')->where('id', $data['userid'])->pluck('department');
                $present[] = [
                    'department' => $department[0],
                    'data' => $data
                ]; 
            }
            $noAction = Support::orderBy('id','DESC')->where('userid', $id)->where('status', NULL)->get();
            $Process = Support::orderBy('id','DESC')->where('userid', $id)->where('status', 'in process')->get();
            $complete = Support::orderBy('id','DESC')->where('userid', $id)->where('status', 'closed')->get();
            $final = Support::orderBy('id','DESC')->where('userid', $id)->where('status', 'final')->get();
            $total = Support::orderBy('id','DESC')->where('userid', $id)->get();
            return view('helpdesk.manage-complaints-user')->with([
                'support'=> $present,
                'noAction'=> count($noAction),   
                'Process'=> count($Process), 
                'complete'=> count($complete), 
                'final'=> count($final), 
                'total'=> count($total)
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

    public function Display(Request $request)
    {
        try{
            $file = 0;
            $id = $request->id;
            $chat = 0;
            $present = array();
            $complaintId = $id;
            $userid = $request->userid;
            $user = User::orderBy('id','DESC')->where('id', $userid)->get();
            $SupportDetail = SupportDetail::orderBy('id','ASC')->where('support_id', $complaintId)->get();
            foreach($SupportDetail as $data){
                $detail = User::orderBy('id','DESC')->limit(1)->where('id', $data['sender'])->get();
                if(isset($detail[0])){
                    $present[] = [
                        'image' => $detail[0]->image,
                        'name'  => $detail[0]->emp_name,
                        'data'  => $data
                    ]; 
                }
            }
            if(count($SupportDetail) > 0){
                $chat = 1;
            }
            $data = Support::orderBy('id','DESC')->where('complaint', $complaintId)->get();
            if(count($data) == 1){
                $img = $data[0]['doc'];
                $ext = pathinfo($img, PATHINFO_EXTENSION);
                $imageMimeTypes = array('png','jpg','jpeg');        
                if(in_array($ext, $imageMimeTypes)) {
                    $file = 'image';
                }
            }
            return view('helpdesk.display-complaints')->with(['data'=> $data[0], 'user'=> $user[0], 'file'=> $file, 'chat'=> $chat, 'SupportDetail'=> $present]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function DisplayUser(Request $request)
    {
        try{
            $file = 0; $sender = 0; $chat = 0;
            $present = array();
            $complaintId = $request->id;
            $userid = $request->userid;
            $user = User::orderBy('id','DESC')->where('id', $userid)->get();
            $SupportDetail = SupportDetail::orderBy('id','ASC')->where('support_id', $complaintId)->get();
            foreach($SupportDetail as $data){
                $detail = User::orderBy('id','DESC')->limit(1)->where('id', $data['sender'])->get();
                if(isset($detail[0])){
                    $present[] = [
                        'image' => $detail[0]->image,
                        'name'  => $detail[0]->emp_name,
                        'data'  => $data
                    ]; 
                }
            }
            if(count($SupportDetail) > 0){
                $chat = 1;
            }
            $data = Support::orderBy('id','DESC')->where('id', $complaintId)->get();
            if(count($data) == 1){
                $img = $data[0]['doc'];
                $ext = pathinfo($img, PATHINFO_EXTENSION);
                $imageMimeTypes = array('png','jpg','jpeg');        
                if(in_array($ext, $imageMimeTypes)) {
                    $file = 'image';
                }
            }
            return view('helpdesk.display-complaints-user')->with([
                'data'=> $data[0], 'user'=> $user[0], 'file'=> $file, 'chat'=> $chat, 
                'SupportDetail'=> $present, 'userid'=> $userid, 'C_id'=> $complaintId
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

    public function chat(Request $request,$complaint,$userid)
    {
        try{
            $chat = 0;
            $present = array();
            $user = User::orderBy('id','DESC')->where('id', $userid)->get();
            $SupportDetail = SupportDetail::orderBy('id','ASC')->where('support_id', $complaint)->get();
            foreach($SupportDetail as $data){
                $detail = User::orderBy('id','DESC')->limit(1)->where('id', $data['sender'])->get();
                if(isset($detail[0])){
                    $present[] = [
                        'image' => $detail[0]->image,
                        'name'  => $detail[0]->emp_name,
                        'data'  => $data
                    ]; 
                }
            }
            if(count($SupportDetail) > 0){
                $chat = 1;
            }
            return response()->json(['data'=> $data,'chat'=> $chat,'present'=> $present]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function chat1(Request $request,$complaint,$userid)
    {
        try{
            $chat = 0;
            $present = array();
            $user = User::orderBy('id','DESC')->where('id', $userid)->get();
            $SupportDetail = SupportDetail::orderBy('id','ASC')->where('support_id', $complaint)->get();
            foreach($SupportDetail as $data){
                $detail = User::orderBy('id','DESC')->limit(1)->where('id', $data['sender'])->get();
                if(isset($detail[0])){
                    $present[] = [
                        'image' => $detail[0]->image,
                        'name'  => $detail[0]->emp_name,
                        'data'  => $data
                    ]; 
                }
            }
            if(count($SupportDetail) > 0){
                $chat = 1;
            }
            return response()->json(['data'=> $data,'chat'=> $chat,'present'=> $present]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function Chats1(Request $request)
    {
        try{
            date_default_timezone_set("Asia/karachi");
            $time = date("h:i A");
            $date = date("d-m-Y");
            $id = $request->user_id;
            $name = Auth::user()->emp_name;
            $image = Auth::user()->image;
            $chat = 0;
            $support_id = $request->complaint_id;
            $userid = $request->user_id;
            
            $status = Support::orderBy('id','DESC')->where('id', $request['complaint_id'])->pluck('status');
            $event = "New Message";
            if($request->status == 'closed'){
                $event = "Complaint Solved";
            }
            if($request->status == 'in process'){
                $event = "Complaint In Process";
            }
            $input2 = array([
                'support_id' => $support_id,
                'message' => $request->message,
                'sender' => Auth::user()->id,
                'receiver' => $id,
                'user_name' => $name,
                'image' => $image,
                'update_time' => $date." ".$time,
                'complaint_id' => $request->id
            ]);
            $create = SupportDetail::create($input2[0]);
            $input2aa = array([
                'data' => $date,
                'event_at' => 'New Message',
                'complaint_id' => $request->id
            ]);
            $notifications = notifications::create($input2aa[0]);
            $Noti_id = $notifications['id'];
            $assign_users = Newrole::orderBy('id','ASC')->where('role_name', 'Complaint')->where('value', 1)->get()->unique('name');
            foreach($assign_users as $data){
                $store[] = $data['name'];
            }
            foreach($store as $data){
                $get_users[] = User::orderBy('id','ASC')->where('userrole', $data)->pluck('id');
                $get_users[] = $get_users[0];
            } 
            foreach($get_users as $value){
                if(count($value) != 0){
                    foreach($value as $val){
                        $result[] = $val;
                        }
                    }
                }       
            $result = array_unique($result);
            foreach($result as $dataa){
                $input3 = array([
                    'notification_id' => $Noti_id,
                    'assign_users' => $dataa,
                    'event' => $event,
                    'url' => 'complaints-view',
                    'complaint' => $request['complaint_id'],
                    'complaint_id' => $request->complaint_id,
                    'userid' => $id,
                    'name' => $name,
                    'image' => $image,
                ]);
                $user = notification_details::create($input3[0]);
            }
            notification_details::where('notification_id', $Noti_id)->where('assign_users', Auth::user()->id)->delete();
            $input3aa = array([
                'notification_id' => $notifications['id'],
                'assign_users' => $userid,
                'event' => 'New Message',
                'url' => 'complaints-view-user',
                'complaint' => $request->complaint_id,
                'complaint_id' => $request->id,
                'userid' => $id,
                'name' => $name,
                'image' => $image,
            ]);   
            $notification_details = notification_details::create($input3aa[0]);
            $user = User::orderBy('id','DESC')->where('id', $id)->get();
            $SupportDetail = SupportDetail::orderBy('id','ASC')->where('support_id', $support_id)->get();
            if(count($SupportDetail) > 0){
                $chat = 1;
            }
            $data = Support::orderBy('id','DESC')->where('complaint', $support_id)->get();
            $variable = 1;
            return response()->json($variable); 
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }  
    }

    public function Chats(Request $request)
    {
        try{
            date_default_timezone_set("Asia/karachi");
            $time = date("h:i A");
            $date = date("d-m-Y");
            $id = $request->user_id;
            $chat = 0;
            $support_id = $request->complaint_id;
            $userid = $request->user_id;
            $name = Auth::user()->emp_name;
            $image = Auth::user()->image;
            $status = Support::orderBy('id','DESC')->where('id', $request['complaint_id'])->pluck('status');
            $event = "New Message";
            if($request->status == 'closed'){
                $event = "Complaint Solved";
            }
            if($request->status == 'in process'){
                $event = "Complaint In Process";
            }
            $input2 = array([
                'support_id' => $support_id,
                'message' => $request->message,
                'sender' => Auth::user()->id,
                'receiver' => $id,
                'update_time' => $date." ".$time,
                'complaint_id' => $request->id
            ]);
            $create = SupportDetail::create($input2[0]);
            $input2aa = array([
                'data' => $date,
                'event_at' => 'New Message',
                'complaint_id' => $request->id
            ]);
            $notifications = notifications::create($input2aa[0]);
            $Noti_id = $notifications['id'];
            $assign_users = Newrole::orderBy('id','ASC')->where('role_name', 'Complaint')->where('value', 1)->get()->unique('name');
            foreach($assign_users as $data){
                $store[] = $data['name'];
            }
            foreach($store as $data){
                $get_users[] = User::orderBy('id','ASC')->where('userrole', $data)->pluck('id');
                $get_users[] = $get_users[0];
            } 
            foreach($get_users as $value){
                if(count($value) != 0){
                    foreach($value as $val){
                        $result[] = $val;
                    }
                }
            }       
            $result = array_unique($result);
            foreach($result as $dataa){
                $input3 = array([
                    'notification_id' => $Noti_id,
                    'assign_users' => $dataa,
                    'event' => $event,
                    'url' => 'complaints-view',
                    'complaint' => $request->complaint_id,
                    'complaint_id' => $request->id,
                    'userid' => Auth::user()->id,
                    'name' => $name,
                    'image' => $image,
                ]);
                $user = notification_details::create($input3[0]);
            }
            notification_details::where('notification_id', $Noti_id)->where('assign_users', Auth::user()->id)->delete();
            $user = User::orderBy('id','DESC')->where('id', $id)->get();
            $SupportDetail = SupportDetail::orderBy('id','ASC')->where('support_id', $support_id)->get();
            if(count($SupportDetail) > 0){
                $chat = 1;
            }
            $data = Support::orderBy('id','DESC')->where('userid', $userid)->get();
            $variable = 1;
            return response()->json($variable); 
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function Submit(Request $request)
    {
        try{
            date_default_timezone_set("Asia/karachi");
            $time = date("h:i A");
            $date = date("d-m-Y");
            $id = $request->user_id;
            $name = Auth::user()->emp_name;
            $image = Auth::user()->image;
            $chat = 0;
            $support_id = $request->complaint_id;
            $userid = $request->user_id;
            $status = Support::orderBy('id','DESC')->where('id', $request['complaint_id'])->pluck('status');
            $event = "New Message";
            if($request->status == 'closed'){
                $event = "Complaint Solved";
            }
            if($request->status == 'in process'){
                $event = "Complaint In Process";
            }
            $input2 = array([
                'support_id' => $support_id,
                'message' => $request->message,
                'sender' => Auth::user()->id,
                'receiver' => $id,
                'user_name' => $name,
                'image' => $image,
                'update_time' => $date." ".$time,
                'complaint_id' => $request->id
            ]);
            $create = SupportDetail::create($input2[0]);
            $input2aa = array([
                'data' => $date,
                'event_at' => 'New Message',
                'complaint_id' => $request->id
            ]);
            $notifications = notifications::create($input2aa[0]);
            $Noti_id = $notifications['id'];
            $assign_users = Newrole::orderBy('id','ASC')->where('role_name', 'Complaint')->where('value', 1)->get()->unique('name');
            foreach($assign_users as $data){
                $store[] = $data['name'];
            }
            foreach($store as $data){
                $get_users[] = User::orderBy('id','ASC')->where('userrole', $data)->pluck('id');
                $get_users[] = $get_users[0];
            } 
            foreach($get_users as $value){
                if(count($value) != 0){
                    foreach($value as $val){
                        $result[] = $val;
                    }
                }
            }       
            $result = array_unique($result);
            foreach($result as $dataa){
                $input3 = array([
                    'notification_id' => $Noti_id,
                    'assign_users' => $dataa,
                    'event' => $event,
                    'url' => 'complaints-view',
                    'complaint' => $request['complaint_id'],
                    'complaint_id' => $request->complaint_id,
                    'userid' => $id,
                    'name' => $name,
                    'image' => $image,
                ]);
                $user = notification_details::create($input3[0]);
            }
            notification_details::where('notification_id', $Noti_id)->where('assign_users', Auth::user()->id)->delete();
            $input3aa = array([
                'notification_id' => $notifications['id'],
                'assign_users' => $userid,
                'event' => 'New Message',
                'url' => 'complaints-view-user',
                'complaint' => $request->complaint_id,
                'complaint_id' => $request->id,
                'userid' => $id,
                'name' => $name,
                'image' => $image,
            ]);   
            $notification_details = notification_details::create($input3aa[0]);
            $user = User::orderBy('id','DESC')->where('id', $id)->get();
            $SupportDetail = SupportDetail::orderBy('id','ASC')->where('support_id', $support_id)->get();
            if(count($SupportDetail) > 0){
                $chat = 1;
            }
            $data = Support::orderBy('id','DESC')->where('complaint', $support_id)->get();
            return back();
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }

    }

    public function SubmitUser(Request $request)
    {
        try{
            date_default_timezone_set("Asia/karachi");
            $time = date("h:i A");
            $date = date("d-m-Y");
            $id = $request->user_id;
            $chat = 0;
            $support_id = $request->complaint_id;
            $userid = $request->user_id;
            $name = Auth::user()->emp_name;
            $image = Auth::user()->image;
            $status = Support::orderBy('id','DESC')->where('id', $request['complaint_id'])->pluck('status');
            $event = "New Message";
            if($request->status == 'closed'){
                $event = "Complaint Solved";
            }
            if($request->status == 'in process'){
                $event = "Complaint In Process";
            }
            $input2 = array([
                'support_id' => $support_id,
                'message' => $request->message,
                'sender' => Auth::user()->id,
                'receiver' => $id,
                'update_time' => $date." ".$time,
                'complaint_id' => $request->id
            ]);
            $create = SupportDetail::create($input2[0]);
            $input2aa = array([
                'data' => $date,
                'event_at' => 'New Message',
                'complaint_id' => $request->id
            ]);
            $notifications = notifications::create($input2aa[0]);
            $Noti_id = $notifications['id'];
            $assign_users = Newrole::orderBy('id','ASC')->where('role_name', 'Complaint')->where('value', 1)->get()->unique('name');
            foreach($assign_users as $data){
                $store[] = $data['name'];
            }
            foreach($store as $data){
                $get_users[] = User::orderBy('id','ASC')->where('userrole', $data)->pluck('id');
                $get_users[] = $get_users[0];
            } 
            foreach($get_users as $value){
                if(count($value) != 0){
                    foreach($value as $val){
                        $result[] = $val;
                    }
                }
            }       
            $result = array_unique($result);
            foreach($result as $dataa){
                $input3 = array([
                    'notification_id' => $Noti_id,
                    'assign_users' => $dataa,
                    'event' => $event,
                    'url' => 'complaints-view',
                    'complaint' => $request->complaint_id,
                    'complaint_id' => $request->id,
                    'userid' => Auth::user()->id,
                    'name' => $name,
                    'image' => $image,
                ]);
                $user = notification_details::create($input3[0]);
            }
            notification_details::where('notification_id', $Noti_id)->where('assign_users', Auth::user()->id)->delete();
            $user = User::orderBy('id','DESC')->where('id', $id)->get();
            $SupportDetail = SupportDetail::orderBy('id','ASC')->where('support_id', $support_id)->get();
            if(count($SupportDetail) > 0){
                $chat = 1;
            }
            $data = Support::orderBy('id','DESC')->where('userid', $userid)->get();
            return back();
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function Read($id)
    {
        try{
            date_default_timezone_set("Asia/karachi");
            $time = date("h:i A");
            $date = date("d-F-Y");
            $result = $time." ".$date;
            $data = DB::table('notification_details')->where('id', $id)->update(['read_at' => $result]);
            if($data){
                $update = 1;
                return response()->json($update);
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

    public function allActivity(Request $request)
    {
        try{
            $notification = DB::table("notification_details")->orderBy('id','DESC')->where('assign_users', Auth::user()->id)->get();
            return view('admin.all-notifications')->with(['notification'=> $notification, 'i'=> 1]);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function MarkAll()
    {
        try{
            date_default_timezone_set("Asia/karachi");
            $time = date("h:i A");
            $date = date("d-F-Y");
            $result = $time." ".$date;
            $data = DB::table('notification_details')->where('assign_users', Auth::user()->id)->update(['read_at' => $result]);
            if($data){
                $update = 1;
                return response()->json($update);
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

    public function delete(Request $request, $id)
    {
        try{
            $users = Support::where('id', $id)->delete();
            $users1 = SupportDetail::where('complaint_id', $id)->delete();
            $users2 = notification_details::where('complaint_id', $id)->delete();
            $users3 = notifications::where('complaint_id', $id)->delete();
            if($users && $users2 && $users3){
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

    public function Complete(Request $request, $id)
    {
        try{
            date_default_timezone_set("Asia/karachi");
            $date = date("d-m-Y");
            $input2aa = array([
                'data' => $date,
                'event_at' => 'Complaint Completed',
                'complaint_id' => $id
            ]);
            $notifications = notifications::create($input2aa[0]);
            $Noti_id = $notifications['id'];
            $name = Auth::user()->emp_name;
            $image = Auth::user()->image;
            $update = DB::table('supports')->where('id', $id)->update(['status' => 'closed']);
            if($update){
                $event = "Complaint Completed";
                $assign_users = Newrole::orderBy('id','ASC')->where('role_name', 'Complaint')->where('value', 1)->get()->unique('name');
                foreach($assign_users as $data){
                    $store[] = $data['name'];
                }
                foreach($store as $data){
                    $get_users[] = User::orderBy('id','ASC')->where('userrole', $data)->pluck('id');
                    $get_users[] = $get_users[0];
                } 
                foreach($get_users as $value){
                    if(count($value) != 0){
                        foreach($value as $val){
                            $result[] = $val;
                        }
                    }
                }       
                $result = array_unique($result);
                foreach($result as $dataa){
                    $input3 = array([
                        'notification_id' => $Noti_id,
                        'assign_users' => $dataa,
                        'event' => $event,
                        'url' => 'complaints-view',
                        'complaint' => $id,
                        'complaint_id' => $id,
                        'userid' => Auth::user()->id,
                        'name' => $name,
                        'image' => $image,
                    ]);
                    $user = notification_details::create($input3[0]);
                }    
                notification_details::where('notification_id', $Noti_id)->where('assign_users', Auth::user()->id)->delete();
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

    public function Reject(Request $request, $id)
    {
        try{
            date_default_timezone_set("Asia/karachi");
            $date = date("d-m-Y");
            $input2aa = array([
                'data' => $date,
                'event_at' => 'Complaint Rejected',
                'complaint_id' => $id
            ]);
            $notifications = notifications::create($input2aa[0]);
            $Noti_id = $notifications['id'];
            $name = Auth::user()->emp_name;
            $image = Auth::user()->image;
            $update = DB::table('supports')->where('id', $id)->update(['status' => NULL]);
            if($update){
                $event = "Complaint Rejected";
                $assign_users = Newrole::orderBy('id','ASC')->where('role_name', 'Complaint')->where('value', 1)->get()->unique('name');
                foreach($assign_users as $data){
                    $store[] = $data['name'];
                }
                foreach($store as $data){
                    $get_users[] = User::orderBy('id','ASC')->where('userrole', $data)->pluck('id');
                    $get_users[] = $get_users[0];
                } 
                foreach($get_users as $value){
                    if(count($value) != 0){
                        foreach($value as $val){
                            $result[] = $val;
                        }
                    }
                }       
                $result = array_unique($result);
                foreach($result as $dataa){
                    $input3 = array([
                        'notification_id' => $Noti_id,
                        'assign_users' => $dataa,
                        'event' => $event,
                        'url' => 'complaints-view',
                        'complaint' => $id,
                        'complaint_id' => $id,
                        'userid' => Auth::user()->id,
                        'name' => $name,
                        'image' => $image,
                    ]);
                    $user = notification_details::create($input3[0]);
                }    
                notification_details::where('notification_id', $Noti_id)->where('assign_users', Auth::user()->id)->delete();
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
}
