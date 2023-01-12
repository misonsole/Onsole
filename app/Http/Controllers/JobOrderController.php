<?php

namespace App\Http\Controllers;
use DB;
use PDF;
use Auth;
use Session;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Newrole;
use App\Models\PlcSole;
use App\Models\PlcRange;
use App\Models\PlcShape;
use App\Models\PlcManual;
use App\Models\PlcPurpose;
use App\Models\PlcPricing;
use App\Models\PlcProject;
use App\Models\PlcLocation;
use App\Models\PlcJobOrder;
use App\Models\PlcCategory;
use App\Models\PlcSizeRange;
use Illuminate\Http\Request;
use App\Models\PlcLastNumber;
use App\Models\notifications;
use App\Models\PlcPricingDetail;
use App\Models\PlcPricingProcess;
use App\Models\PlcPricingResource;
use App\Models\PlcPricingOverhead;
use App\Models\notification_details;

class JobOrderController extends Controller
{
    public function jobOrder(Request $request)
    {
        $store = 001;
        $season = array();
        $season5 = array();
        $color = array();
        $item_code = array();
        $article_code = array();
        $location = array();
        $last = array();
        $location = array();
        $location = array();
        $company = array();
        $wizerp  = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
        $connPRL = oci_connect("onsole","s",$wizerp);
        $sql = "SELECT SEASON_DEF_DESC FROM ONSOLE_SEASON_DEFINITION";
        $result = oci_parse($connPRL, $sql);
        oci_execute($result);
        while($row = oci_fetch_array($result,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $season[] = $row['SEASON_DEF_DESC'];
        }
        $sql1 = "SELECT COMPANY_NAME FROM CUSTOMER_MT";
        $result1 = oci_parse($connPRL, $sql1);
        oci_execute($result1);
        while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $company[] = $row1['COMPANY_NAME'];
        }
        $sql2 = "SELECT SEGMENT_VALUE_DESC FROM WIZ_SEGMENT04 WHERE STRUCTURE_ID = 26 ORDER BY SEGMENT_VALUE_DESC ASC";
        $result2 = oci_parse($connPRL, $sql2);
        oci_execute($result2);
        while($row2 = oci_fetch_array($result2,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $color[] = ucfirst(strtolower($row2['SEGMENT_VALUE_DESC']));
        }
        $sizerange = PlcSizeRange::orderBy('id','DESC')->get();
        return view('joborder.job-order')->with([
            'season'=> $season,
            'location'=> $location, 
            'company'=> $company, 
            'sizerange'=> $sizerange, 
            'last'=> $last,     
            'color'=> $color, 
            'itemcode'=> $item_code, 
            'i'=> 1, 
            'articlecode'=> $article_code,
            'z'=> count($article_code), 
            'j'=> 1, 
        ]);
        date_default_timezone_set('Asia/Karachi');
        $date = date('l d F Y - h:i');
        $date1 = date('My');
        $Support = JobOrder::orderBy('id','DESC')->limit(1)->get();
        if($Support[0]->sq_no == NULL){
            $sq_no = $store + 0;
        }
        else{
            $sq_no = $store + $Support[0]->sq_no;
        }
        $DB_Server = "localhost";
        $DB_User = "root";
        $DB_Pass = "";
        $DB_Name = "onsoleportal";

        // $link = mysqli_connect($DB_Server, $DB_User, $DB_Pass, $DB_Name);
        // if(!$link){
        //     die("Connection failed: " . mysqli_connect_error());
        // }

        // $sql3 = "SELECT distinct Location FROM job_sheet_order_det";
        // $result3 = $link->query($sql3);
        // if($result3->num_rows>0){
        //     while($row3 = $result3->fetch_assoc())
        //     {
        //         $location[] = $row3['Location'];
        //     }
        // }


        $sql1 = "SELECT SEGMENT_VALUE_DESC FROM WIZ_SEGMENT04 WHERE STRUCTURE_ID = 26";
        $result1 = oci_parse($connPRL, $sql1);
        oci_execute($result1);
        while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $color[] = strtolower($row1['SEGMENT_VALUE_DESC']);
        }
        $sql2 = "SELECT IM.ITEM_CODE, IM.ITEM_DESC, U.UOM_DESC
        FROM ITEMS_MT IM, WIZ_UOM_MT U, ITEMS_CATEGORY IC
               WHERE IM.PRIMARY_UOM = U.UOM_ID
                     AND IC.ITEM_ID = IM.ITEM_ID AND IC.STRUCTURE_ID = 27";
        $result2 = oci_parse($connPRL, $sql2);
        oci_execute($result2);
        while($row2 = oci_fetch_array($result2,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $item_code[] = $row2;
        }
        $sql3 = "SELECT SEGMENT_VALUE_DESC FROM WIZ_SEGMENT03 WHERE STRUCTURE_ID = 26";
        $result3 = oci_parse($connPRL, $sql3);
        oci_execute($result3);
        while($row3 = oci_fetch_array($result3,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $article_code[] = $row3['SEGMENT_VALUE_DESC'];
        }
        $last = LastNumber::orderBy('id','DESC')->get();
        $location = Location::orderBy('id','DESC')->get();
        return view('joborder.job-order')->with([
            'season'=> $season,
            'location'=> $location, 
            'last'=> $last,     
            'color'=> $color, 
            'itemcode'=> $item_code, 
            'i'=> 1, 
            'articlecode'=> $article_code,
            'z'=> count($article_code), 
            'j'=> 1, 
            'date'=> $date, 
            'date1'=> $date1,
            'sq_no'=> $sq_no
        ]);
    }

    public function Create(Request $request)
    {
        $assign_users = User::orderBy('id','ASC')->where('department', 'Product Development')->pluck('id');
        date_default_timezone_set('Asia/Karachi');
        $date = date('l d F Y - h:i');
        $date1 = date("d-F-Y");
        $filename = "0";
        if($request->image){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); 
            $filename = time() . '.' . $extension;
            $file->move('uploads/appsetting/', $filename);
        }

        $upper = 1; $linning = 2; $stiching = 3; $insole = 4; $outsole = 5; $socks  = 6; $general = 7;
        $job = new JobOrder();
        $job->season = $request->season;
        $job->last = $request->last;
        $job->color = ucwords($request->color);
        $job->sample = $request->sample;
        $job->article = $request->article;
        $job->sq_no = $request->sq_no;
        $job->product = $request->product;
        $job->sequence = $request->sequence; 
        $job->date = isset($request->date) ? $request->date : $date;
        $job->image = $filename;
        $result = $job->save();
        $job_id = $job->id;
        if($request->u_item_code[0] != null){
            $count = count($request->u_item_code);
            for($i=0; $i<$count; $i++){
                $dataArray = array([
                    'job_order_id' => $job_id,
                    'material' => "upper",
                    'item_code' => $request->u_item_code[$i] ? $request->u_item_code[$i] : '-',
                    'description' => $request->u_description[$i] ? ucwords($request->u_description[$i]) : '-',
                    'uom' => isset($request->u_uom[$i]) ? $request->u_uom[$i] : '-',
                    'type' => isset($request->u_type[$i]) ? $request->u_type[$i] : '-',
                    'tools' => isset($request->u_tool[$i]) ? $request->u_tool[$i] : '-',
                    'usages' => isset($request->u_use[$i]) ? $request->u_use[$i] : '-',
                    'quantity' => isset($request->u_quantity[$i]) ? $request->u_quantity[$i] : '-',
                ]);
                $store = JobOrderDetail::insert($dataArray[0]);
            }
        }
        if($request->l_item_code[0] != null){
            $count1 = count($request->l_item_code);
            for($i=0; $i<$count1; $i++){
                $dataArray = array([
                    'job_order_id' => $job_id,
                    'material' => "linning",
                    'item_code' => $request->l_item_code[$i] ? $request->l_item_code[$i] : '-',
                    'description' => $request->l_description[$i] ? ucwords($request->l_description[$i]) : '-',
                    'uom' => isset($request->l_uom[$i]) ? $request->l_uom[$i] : '-',
                    'type' => isset($request->l_type[$i]) ? $request->l_type[$i] : '-',
                    'tools' => isset($request->l_tool[$i]) ? $request->l_tool[$i] : '-',
                    'usages' => isset($request->l_use[$i]) ? $request->l_use[$i] : '-',
                    'quantity' => isset($request->l_quantity[$i]) ? $request->l_quantity[$i] : '-',
                ]);
                $store = JobOrderDetail::insert($dataArray[0]);
            }
        }
        if($request->st_item_code[0] != null){
            $count5 = count($request->st_item_code);
            for($i=0; $i<$count5; $i++){
                $dataArray = array([
                    'job_order_id' => $job_id,
                    'material' => "stiching",
                    'item_code' => $request->st_item_code[$i] ? $request->st_item_code[$i] : '-',
                    'description' => $request->st_description[$i] ? ucwords($request->st_description[$i]) : '-',
                    'uom' => isset($request->st_uom[$i]) ? $request->st_uom[$i] : '-',
                    'type' => isset($request->st_type[$i]) ? $request->st_type[$i] : '-',
                    'tools' => isset($request->st_tool[$i]) ? $request->st_tool[$i] : '-',
                    'usages' => isset($request->st_use[$i]) ? $request->st_use[$i] : '-',
                    'quantity' => isset($request->st_quantity[$i]) ? $request->st_quantity[$i] : '-',
                ]);
                $store = JobOrderDetail::insert($dataArray[0]);
            }
        }
        if($request->i_item_code[0] != null){
            $count3 = count($request->i_item_code);
            for($i=0; $i<$count3; $i++){
                $dataArray = array([
                    'job_order_id' => $job_id,
                    'material' => "insole",
                    'item_code' => $request->i_item_code[$i] ? $request->i_item_code[$i] : '-',
                    'description' => $request->i_description[$i] ? ucwords($request->i_description[$i]) : '-',
                    'uom' => isset($request->i_uom[$i]) ? $request->i_uom[$i] : '-',
                    'type' => isset($request->i_type[$i]) ? $request->i_type[$i] : '-',
                    'tools' => isset($request->i_tool[$i]) ? $request->i_tool[$i] : '-',
                    'usages' => isset($request->i_use[$i]) ? $request->i_use[$i] : '-',
                    'quantity' => isset($request->i_quantity[$i]) ? $request->i_quantity[$i] : '-',
                ]);
                $store = JobOrderDetail::insert($dataArray[0]);
            }
        }
        if($request->o_item_code[0] != null){
            $count4 = count($request->o_item_code);
            for($i=0; $i<$count4; $i++){
                $dataArray = array([
                    'job_order_id' => $job_id,
                    'material' => "outsole",
                    'item_code' => $request->o_item_code[$i] ? $request->o_item_code[$i] : '-',
                    'description' => $request->o_description[$i] ? ucwords($request->o_description[$i]) : '-',
                    'uom' => isset($request->o_uom[$i]) ? $request->o_uom[$i] : '-',
                    'type' => isset($request->o_type[$i]) ? $request->o_type[$i] : '-',
                    'tools' => isset($request->o_tool[$i]) ? $request->o_tool[$i] : '-',
                    'usages' => isset($request->o_use[$i]) ? $request->o_use[$i] : '-',
                    'quantity' => isset($request->o_quantity[$i]) ? $request->o_quantity[$i] : '-',
                ]);
                $store = JobOrderDetail::insert($dataArray[0]);
            }
        }
        if($request->s_item_code[0] != null){
            $count2 = count($request->s_item_code);
            for($i=0; $i<$count2; $i++){
                $dataArray = array([
                    'job_order_id' => $job_id,
                    'material' => "socks",
                    'item_code' => $request->s_item_code[$i] ? $request->s_item_code[$i] : '-',
                    'description' => $request->s_description[$i] ? ucwords($request->s_description[$i]) : '-',
                    'uom' => isset($request->s_uom[$i]) ? $request->s_uom[$i] : '-',
                    'type' => isset($request->s_type[$i]) ? $request->s_type[$i] : '-',
                    'tools' => isset($request->s_tool[$i]) ? $request->s_tool[$i] : '-',
                    'usages' => isset($request->s_use[$i]) ? $request->s_use[$i] : '-',
                    'quantity' => isset($request->s_quantity[$i]) ? $request->s_quantity[$i] : '-',
                ]);
                $store = JobOrderDetail::insert($dataArray[0]);
            }
        }
        if($request->g_item_code[0] != null){
            $count6 = count($request->g_item_code);
            for($i=0; $i<$count6; $i++){
                $dataArray = array([
                    'job_order_id' => $job_id,
                    'material' => "general",
                    'item_code' => $request->g_item_code[$i] ? $request->g_item_code[$i] : '-',
                    'description' => $request->g_description[$i] ? ucwords($request->g_description[$i]) : '-',
                    'uom' => isset($request->g_uom[$i]) ? $request->g_uom[$i] : '-',
                    'type' => isset($request->g_type[$i]) ? $request->g_type[$i] : '-',
                    'tools' => isset($request->g_tool[$i]) ? $request->g_tool[$i] : '-',
                    'usages' => isset($request->g_use[$i]) ? $request->g_use[$i] : '-',
                    'quantity' => isset($request->g_quantity[$i]) ? $request->g_quantity[$i] : '-',
                ]);
                $store = JobOrderDetail::insert($dataArray[0]);
            }
        }
        $input = array([
            'data' => $date1,
            'event_at' => 'Job Order',
            'complaint_id' => $job_id
        ]);
        $joborder = notifications::create($input[0]);
        $notification_id = $joborder['id'];
        $id = Auth::user()->id;
        $name = Auth::user()->emp_name;
        $image = Auth::user()->image;
        foreach($assign_users as $dataa){
            $input3 = array([
                'notification_id' => $notification_id,
                'assign_users' => $dataa,
                'event' => 'Job Order',
                'url' => 'job-order-view',
                'complaint' => $job_id,
                'complaint_id' => $job_id,
                'userid' => $id,
                'name' => $name,
                'image' => $image,
            ]);
            $user = notification_details::create($input3[0]);
        }

        notification_details::where('notification_id', $notification_id)->where('assign_users', Auth::user()->id)->delete();

        $notification = array(
            'message' => 'Job Order Created Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('job-order-table')->with($notification);
    }

    public function Users()
    {
        $user = user::orderBy('id','DESC')->pluck('name');
        $item_code = array();
        $article_code = array();
        $wizerp  = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
        $connPRL = oci_connect("onsole","s",$wizerp);
        $sql2 = "SELECT ITEM_CODE FROM ITEMS_MT";
        $result2 = oci_parse($connPRL, $sql2);
        oci_execute($result2);
        while($row2 = oci_fetch_array($result2,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $item_code[] = $row2['ITEM_CODE'];
        }
        
        $sql3 = "SELECT SEGMENT_VALUE_DESC FROM WIZ_SEGMENT03 WHERE STRUCTURE_ID = 26";
        $result3 = oci_parse($connPRL, $sql3);
        oci_execute($result3);
        while($row3 = oci_fetch_array($result3,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $article_code[] = $row3['SEGMENT_VALUE_DESC'];
        }
        return response()->json($article_code);
    }

    public function ArticleCode($id)
    {
        $article_code = array();
        $wizerp  = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
        $connPRL = oci_connect("onsole","s",$wizerp);
        $sql3 = "SELECT SEGMENT_VALUE_DESC FROM WIZ_SEGMENT03 WHERE SEGMENT_VALUE_DESC LIKE '%$id%' AND STRUCTURE_ID = 26 OFFSET 0 ROWS FETCH NEXT 5 ROWS ONLY";
        $result3 = oci_parse($connPRL, $sql3);
        oci_execute($result3);
        while($row3 = oci_fetch_array($result3,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $article_code[] = $row3['SEGMENT_VALUE_DESC'];
        }
        return response()->json($article_code);
    }

    public function Detail($id)
    {
        $detail = array();
        $wizerp  = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
        $connPRL = oci_connect("onsole","s",$wizerp);
        $sql = "SELECT ITEM_DESC FROM ITEMS_MT WHERE ITEM_CODE = '$id'";
        $result = oci_parse($connPRL, $sql);
        oci_execute($result);
        while($row = oci_fetch_array($result,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $detail[] = $row['ITEM_DESC'];
        }
        return response()->json($detail[0]);
    }

    public function ItemCode($id)
    {
        $detail = array();
        $wizerp  = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
        $connPRL = oci_connect("onsole","s",$wizerp);
        $sql = "SELECT ITEM_DESC, UOM_DESC FROM ITEMS_MT IM, WIZ_UOM_MT U WHERE IM.PRIMARY_UOM = U.UOM_ID AND ITEM_CODE = '$id'";
        $result = oci_parse($connPRL, $sql);
        oci_execute($result);
        while($row = oci_fetch_array($result,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $detail = array([
                'desc' => strtolower($row['ITEM_DESC']),
                'uom' => $row['UOM_DESC']
            ]);
        }
        return response()->json($detail[0]);
    }

    public function Display(Request $request)
    {
        $id = $_GET['id'];
        $upperData = []; $linningData = []; $stichingData = []; $insoleData = []; $outsoleData = []; $socksData = []; $generalData = [];
        $data1 = DB::table('job_orders')->where('id', $id)->get();
        $DateTime = $data1[0]->created_at;
        $DateTime = explode(' ', $DateTime);
        $data2 = DB::table('job_order_details')->where('job_order_id', $id)->get();
        foreach($data2 as $value){
            if($value->material == "upper"){
                    $upperData[] = $value;
            }
            elseif($value->material == "linning"){
                $linningData[] = $value;
            }
            elseif($value->material == "stiching"){
                $stichingData[] = $value;
            }
            elseif($value->material == "insole"){
                $insoleData[] = $value;
            }
            elseif($value->material == "outsole"){
                $outsoleData[] = $value;
            }
            elseif($value->material == "socks"){
                $socksData[] = $value;
            }
            elseif($value->material == "general"){
                $generalData[] = $value;
            }
        }
        $data = [
            'data1'=> $data1[0],
            'i'=> 1,
            'upperData'=> $upperData,
            'j'=> 1,
            'linningData'=> $linningData,
            'k'=> 1,
            'stichingData'=> $stichingData,
            'l'=> 1,
            'outsoleData'=> $outsoleData,
            'm'=> 1,
            'insoleData'=> $insoleData,
            'n'=> 1,
            'socksData'=> $socksData,
            'n'=> 1,
            'generalData'=> $generalData,
            'n'=> 1,
            'date' => $DateTime[0]
        ];
        // $pdf = PDF::loadView('joborder.job-order-display', $data);
    
        // return $pdf->download('itsolutionstuff.pdf');

        return view('joborder.job-order-display')->with([
            'data1'=> $data1[0],
            'i'=> 1,
            'upperData'=> $upperData,
            'j'=> 1,
            'linningData'=> $linningData,
            'k'=> 1,
            'stichingData'=> $stichingData,
            'l'=> 1,
            'outsoleData'=> $outsoleData,
            'm'=> 1,
            'insoleData'=> $insoleData,
            'n'=> 1,
            'socksData'=> $socksData,
            'n'=> 1,
            'generalData'=> $generalData,
            'n'=> 1,
            'date' => $DateTime[0]
        ]);
    }

    public function Display1(Request $request)
    {
        $id = $_GET['id'];
        $upperData = []; $linningData = []; $stichingData = []; $insoleData = []; $outsoleData = []; $socksData = []; $generalData = [];
        $data1 = DB::table('job_orders')->where('id', $id)->get();
        $DateTime = $data1[0]->created_at;
        $DateTime = explode(' ', $DateTime);
        $data2 = DB::table('job_order_details')->where('job_order_id', $id)->get();
        foreach($data2 as $value){
            if($value->material == "upper"){
                    $upperData[] = $value;
            }
            elseif($value->material == "linning"){
                $linningData[] = $value;
            }
            elseif($value->material == "stiching"){
                $stichingData[] = $value;
            }
            elseif($value->material == "insole"){
                $insoleData[] = $value;
            }
            elseif($value->material == "outsole"){
                $outsoleData[] = $value;
            }
            elseif($value->material == "socks"){
                $socksData[] = $value;
            }
            elseif($value->material == "general"){
                $generalData[] = $value;
            }
        }
        $data = [
            'data1'=> $data1[0],
            'i'=> 1,
            'upperData'=> $upperData,
            'j'=> 1,
            'linningData'=> $linningData,
            'k'=> 1,
            'stichingData'=> $stichingData,
            'l'=> 1,
            'outsoleData'=> $outsoleData,
            'm'=> 1,
            'insoleData'=> $insoleData,
            'n'=> 1,
            'socksData'=> $socksData,
            'n'=> 1,
            'generalData'=> $generalData,
            'n'=> 1,
            'date' => $DateTime[0]
        ];
        // $pdf = PDF::loadView('joborder.job-order-display', $data);
    
        // return $pdf->download('itsolutionstuff.pdf');

        return view('joborder.job-order-pdf')->with([
            'data1'=> $data1[0],
            'i'=> 1,
            'upperData'=> $upperData,
            'j'=> 1,
            'linningData'=> $linningData,
            'k'=> 1,
            'stichingData'=> $stichingData,
            'l'=> 1,
            'outsoleData'=> $outsoleData,
            'm'=> 1,
            'insoleData'=> $insoleData,
            'n'=> 1,
            'socksData'=> $socksData,
            'n'=> 1,
            'generalData'=> $generalData,
            'n'=> 1,
            'date' => $DateTime[0]
        ]);
    }

    public function Update(Request $request)
    {
        date_default_timezone_set('Asia/Karachi');
        $date = date('l d F Y - h:i');
        $sessionImg = Session::get('image');
        $upper = 1; $linning = 2; $stiching = 3; $insole = 4; $outsole = 5; $socks  = 6; $general = 7;
        $filename = "0";
        if($request->image){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); 
            $filename = time() . '.' . $extension;
            $file->move('uploads/appsetting/', $filename);
        }
        $id = $request->id;
        $season = $request->season;
        $last = $request->last;
        $color = ucwords($request->color);
        $sample = $request->sample;
        $article = $request->article;
        $product = $request->product;
        $sequence = $request->sequence;
        $date = isset($request->date) ? $request->date : $date;
        $data = array([
            'season' => $season,
            'last' => $last,
            'color' => $color,
            'sample' => $sample,
            'article' => $article,
            'product' => $product,
            'image' => $filename,
            'sequence' => $sequence,
            'date' => $date,
        ]);
        $update = DB::table('job_orders')->where('id', $id)->update($data[0]);
        if($update){
            $updatee = JobOrderDetail::where('job_order_id', $id)->pluck('id');
            if(isset($updatee[0]) == $id){
                JobOrderDetail::where('job_order_id', $id)->delete();
            }
                if($request->u_item_code[0] != null){
                    $count = count($request->u_item_code);
                    for($i=0; $i<$count; $i++){
                        $dataArray = array([
                            'job_order_id' => $id,
                            'material' => "upper",
                            'item_code' => $request->u_item_code[$i] ? $request->u_item_code[$i] : NULL,
                            'description' => $request->u_description[$i] ? ucwords($request->u_description[$i]) : NULL,
                            'uom' => isset($request->u_uom[$i]) ? $request->u_uom[$i] : NULL,
                            'type' => isset($request->u_type[$i]) ? $request->u_type[$i] : NULL,
                            'tools' => isset($request->u_tool[$i]) ? $request->u_tool[$i] : NULL,
                            'usages' => isset($request->u_use[$i]) ? $request->u_use[$i] : NULL,
                            'quantity' => isset($request->u_quantity[$i]) ? $request->u_quantity[$i] : NULL,
                        ]);
                        $store = JobOrderDetail::insert($dataArray[0]);
                    }
                }
                if($request->l_item_code[0] != null){
                    $count1 = count($request->l_item_code);
                    for($i=0; $i<$count1; $i++){
                        $dataArray = array([
                            'job_order_id' => $id,
                            'material' => "linning",
                            'item_code' => $request->l_item_code[$i] ? $request->l_item_code[$i] : NULL,
                            'description' => $request->l_description[$i] ? ucwords($request->l_description[$i]) : NULL,
                            'uom' => isset($request->l_uom[$i]) ? $request->l_uom[$i] : NULL,
                            'type' => isset($request->l_type[$i]) ? $request->l_type[$i] : NULL,
                            'tools' => isset($request->l_tool[$i]) ? $request->l_tool[$i] : NULL,
                            'usages' => isset($request->l_use[$i])? $request->l_use[$i] : NULL,
                            'quantity' => isset($request->l_quantity[$i]) ? $request->l_quantity[$i] : NULL,
                        ]);
                        $store = JobOrderDetail::insert($dataArray[0]);
                    }
                }
                if($request->st_item_code[0] != null){
                    $count5 = count($request->st_item_code);
                    for($i=0; $i<$count5; $i++){
                        $dataArray = array([
                            'job_order_id' => $id,
                            'material' => "stiching",
                            'item_code' => $request->st_item_code[$i] ? $request->st_item_code[$i] : NULL,
                            'description' => $request->st_description[$i] ? ucwords($request->st_description[$i]) : NULL,
                            'uom' => isset($request->st_uom[$i]) ? $request->st_uom[$i] : NULL,
                            'type' => isset($request->st_type[$i]) ? $request->st_type[$i] : NULL,
                            'tools' => isset($request->st_tool[$i]) ? $request->st_tool[$i] : NULL,
                            'usages' => isset($request->st_use[$i]) ? $request->st_use[$i] : NULL,
                            'quantity' => isset($request->st_quantity[$i]) ? $request->st_quantity[$i] : NULL,
                        ]);
                        $store = JobOrderDetail::insert($dataArray[0]);
                    }
                }
                if($request->i_item_code[0] != null){
                    $count3 = count($request->i_item_code);
                    for($i=0; $i<$count3; $i++){
                        $dataArray = array([
                            'job_order_id' => $id,
                            'material' => "insole",
                            'item_code' => $request->i_item_code[$i] ? $request->i_item_code[$i] : NULL,
                            'description' => $request->i_description[$i] ? ucwords($request->i_description[$i]) : NULL,
                            'uom' => isset($request->i_uom[$i]) ? $request->i_uom[$i] : NULL,
                            'type' => isset($request->i_type[$i]) ? $request->i_type[$i] : NULL,
                            'tools' => isset($request->i_tool[$i]) ? $request->i_tool[$i] : NULL,
                            'usages' => isset($request->i_use[$i]) ? $request->i_use[$i] : NULL,
                            'quantity' => isset($request->i_quantity[$i]) ? $request->i_quantity[$i] : NULL,
                        ]);
                        $store = JobOrderDetail::insert($dataArray[0]);
                    }
                }
                if($request->o_item_code[0] != null){
                    $count4 = count($request->o_item_code);
                    for($i=0; $i<$count4; $i++){
                        $dataArray = array([
                            'job_order_id' => $id,
                            'material' => "outsole",
                            'item_code' => $request->o_item_code[$i] ? $request->o_item_code[$i] : NULL,
                            'description' => $request->o_description[$i] ? ucwords($request->o_description[$i]) : NULL,
                            'uom' => isset($request->o_uom[$i]) ? $request->o_uom[$i] : NULL,
                            'type' => isset($request->o_type[$i]) ? $request->o_type[$i] : NULL,
                            'tools' => isset($request->o_tool[$i]) ? $request->o_tool[$i] : NULL,
                            'usages' => isset($request->o_use[$i]) ? $request->o_use[$i] : NULL,
                            'quantity' => isset($request->o_quantity[$i]) ? $request->o_quantity[$i] : NULL,
                        ]);
                        $store = JobOrderDetail::insert($dataArray[0]);
                    }
                }
                if($request->s_item_code[0] != null){
                    $count2 = count($request->s_item_code);
                    for($i=0; $i<$count2; $i++){
                        $dataArray = array([
                            'job_order_id' => $id,
                            'material' => "socks",
                            'item_code' => $request->s_item_code[$i] ? $request->s_item_code[$i] : NULL,
                            'description' => $request->s_description[$i] ? ucwords($request->s_description[$i]) : NULL,
                            'uom' => isset($request->s_uom[$i]) ? $request->s_uom[$i] : NULL,
                            'type' => isset($request->s_type[$i]) ? $request->s_type[$i] : NULL,
                            'tools' => isset($request->s_tool[$i]) ? $request->s_tool[$i] : NULL,
                            'usages' => isset($request->s_use[$i]) ? $request->s_use[$i] : NULL,
                            'quantity' => isset($request->s_quantity[$i]) ? $request->s_quantity[$i] : NULL,
                        ]);
                        $store = JobOrderDetail::insert($dataArray[0]);
                    }
                }
                if($request->g_item_code[0] != null){
                    $count6 = count($request->g_item_code);
                    for($i=0; $i<$count6; $i++){
                        $dataArray = array([
                            'job_order_id' => $id,
                            'material' => "general",
                            'item_code' => $request->g_item_code[$i] ? $request->g_item_code[$i] : NULL,
                            'description' => $request->g_description[$i] ? ucwords($request->g_description[$i]) : NULL,
                            'uom' => isset($request->g_uom[$i]) ? $request->g_uom[$i] : NULL,
                            'type' => isset($request->g_type[$i]) ? $request->g_type[$i] : NULL,
                            'tools' => isset($request->g_tool[$i]) ? $request->g_tool[$i] : NULL,
                            'usages' => isset($request->g_use[$i]) ? $request->g_use[$i] : NULL,
                            'quantity' => isset($request->g_quantity[$i]) ? $request->g_quantity[$i] : NULL,
                        ]);
                        $store = JobOrderDetail::insert($dataArray[0]);
                    }
                }
                $notification = array(
                    'message' => 'Job Order Updated Successfully',
                    'alert-type' => 'success'
                );
                return redirect()->route('job-order-table')->with($notification);
        }
        else{
            dd("Not Update");
        }
    }

    public function Edit(Request $request)
    {
        $id = $_GET['id'];
        $upperData = []; $linningData = []; $stichingData = []; $insoleData = []; $outsoleData = []; $socksData = []; $generalData = [];
        $data1 = DB::table('job_orders')->where('id', $id)->get();
        $data2 = DB::table('job_order_details')->where('job_order_id', $id)->get();
        $userseason = $data1[0]->season;
        $userlast = 21;
        $usersample = $data1[0]->sample;
        $userarticle = $data1[0]->article;
        $userproduct = $data1[0]->product;
        $userimage = $data1[0]->image;
        Session::put('image', $userimage);
        $sequence = $data1[0]->sequence;
        $article = $data1[0]->article;
        $date = $data1[0]->date;
        $usercolor = strtolower($data1[0]->color);

        $wizerp  = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
        $connPRL = oci_connect("onsole","s",$wizerp);
        $sql = "SELECT SEASON_DEF_DESC FROM ONSOLE_SEASON_DEFINITION";
        $result = oci_parse($connPRL, $sql);
        oci_execute($result);
        while($row = oci_fetch_array($result,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $season[] = $row['SEASON_DEF_DESC'];
        }
        $sql1 = "SELECT SEGMENT_VALUE_DESC FROM WIZ_SEGMENT04 WHERE STRUCTURE_ID = 26";
        $result1 = oci_parse($connPRL, $sql1);
        oci_execute($result1);
        while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $color[] = strtolower($row1['SEGMENT_VALUE_DESC']);
        }
        $sql2 = "SELECT IM.ITEM_CODE, IM.ITEM_DESC, U.UOM_DESC
        FROM ITEMS_MT IM, WIZ_UOM_MT U, ITEMS_CATEGORY IC
               WHERE IM.PRIMARY_UOM = U.UOM_ID
                     AND IC.ITEM_ID = IM.ITEM_ID AND IC.STRUCTURE_ID = 27";
        $result2 = oci_parse($connPRL, $sql2);
        oci_execute($result2);
        while($row2 = oci_fetch_array($result2,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $item_code[] = $row2;
        }
        $sql3 = "SELECT SEGMENT_VALUE_DESC FROM WIZ_SEGMENT03 WHERE STRUCTURE_ID = 26";
        $result3 = oci_parse($connPRL, $sql3);
        oci_execute($result3);
        while($row3 = oci_fetch_array($result3,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $article_code[] = $row3['SEGMENT_VALUE_DESC'];
        }
        $last = LastNumber::orderBy('id','DESC')->pluck('last_no');
        $location = Location::orderBy('id','DESC')->get();
        $resultlast = str_replace('"', '', $last);
        foreach($data2 as $value){
            if($value->material == "upper"){
                    $upperData[] = $value;
            }
            elseif($value->material == "linning"){
                $linningData[] = $value;
            }
            elseif($value->material == "stiching"){
                $stichingData[] = $value;
            }
            elseif($value->material == "insole"){
                $insoleData[] = $value;
            }
            elseif($value->material == "outsole"){
                $outsoleData[] = $value;
            }
            elseif($value->material == "socks"){
                $socksData[] = $value;
            }
            elseif($value->material == "general"){
                $generalData[] = $value;
            }
        }
        return view('joborder.job-order-edit')->with([
            'data1'=> $data1[0],
            'id'=> $id,
            'i'=> 1,
            'upperData'=> $upperData,
            'location'=> $location,
            'j'=> 1,
            'linningData'=> $linningData,
            'k'=> 1,
            'stichingData'=> $stichingData,
            'l'=> 1,
            'outsoleData'=> $outsoleData,
            'm'=> 1,
            'insoleData'=> $insoleData,
            'n'=> 1,
            'socksData'=> $socksData,
            'n'=> 1,
            'generalData'=> $generalData,
            'n'=> 1,
            'a1'=> 1,
            'a2'=> 1,
            'b1'=> 1,
            'b2'=> 1,
            'c1'=> 1,
            'c2'=> 1,
            'd1'=> 1,
            'd2'=> 1,
            'e1'=> 1,
            'e2'=> 1,
            'f1'=> 1,
            'f2'=> 1,
            'season'=> $season,
            'last'=> $last, 
            'color'=> $color,
            'itemcode'=> $item_code,
            'articlecode'=> $article_code,
            'userseason'=> $userseason,
            'userlast'=> $userlast,
            'usersample'=> $usersample,
            'userarticle'=> $userarticle,
            'userproduct'=> $userproduct,
            'usercolor'=> $usercolor,
            'sequence'=>$sequence,
            'date'=>$date,
            'image'=>$userimage,
            'article'=>$article
        ]);
    }

    public function All(Request $request)
    {
        try{
            $id = Auth::user()->id;
            $UserDetail = DB::table("users")->where("id", $id)->pluck('userrole');
            $UserDetail1 = DB::table("newroles")->where("name", $UserDetail)->get();
            $obj = json_decode (json_encode ($UserDetail1), FALSE);
            $storeData = [];
            foreach($obj as $dataa){
                $storeData[$dataa->role_name] = $dataa->value; 
            }
            if(isset($storeData['Job-Order Create']) && !empty($storeData['Job-Order Create'])){
                if(isset($storeData['Job-Order Create']) == 1){
                    $data = DB::table('plc_joborders')->get();
                }
                return view('joborder.job-order-table')->with(['data'=> $data, 'i'=> 1]);
            }
            else{
                $data = DB::table('plc_joborders')->get();
                return view('joborder.job-order-table')->with(['data'=> $data, 'i'=> 1]);
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

    public function AllQC(Request $request)
    {
        $data = JobOrder::orderBy('id','DESC')->get();
        return view('joborder.job-order-qc')->with(['data'=> $data, 'i'=> 1]);
    }

    public function Delete($id)
    {
        $delete = JobOrder::where('id', $id)->delete();
        $delete1 = JobOrderDetail::where('job_order_id', $id)->delete();
        if($delete){
            return response()->json($delete);
        }
        else{
            $error = 400;
            return response()->json($error);
        }
    }

    public function Duplicate($desgin,$id)
    {
        date_default_timezone_set('Asia/Karachi');
        $data = PlcPricing::find($id);
        $data->replicate()->setTable('plc_joborders')->save();
        $detailData = PlcPricingDetail::orderBy('id','ASC')->where('costing_id', $id)->get();
        foreach($detailData as $dData){
            $dData->replicate()->setTable('plc_joborder_details')->save();
        }
        dd("Yes");

        $date1 = date("d-F-Y");
        $msg = 0; $department = 0;
        if($status == "QC"){
            $msg = "Transferred to QC";
            $assign_users = User::orderBy('id','ASC')->where('department', 'Quality Control')->orWhere('department',"Product Development")->pluck('id');
        }
        if($status == "Rejected"){
            $msg = "Reject";
            $assign_users = User::orderBy('id','ASC')->where('department', 'Quality Control')->orWhere('department',"Product Development")->pluck('id');
        }
        if($status == "Approved"){
            $assign_users = User::orderBy('id','ASC')->where('department', 'Quality Control')->orWhere('department',"Product Development")->pluck('id');
            $msg = "Approved";
        }
        if($status == "PPC"){
            $msg = "Transferred to PPC";
        }        
        $assign_users = User::orderBy('id','ASC')->where('department', 'Product Development')->pluck('id');
        $input = array([
            'data' => $date1,
            'event_at' => 'Job Order',
            'complaint_id' => $id
        ]);
        $joborder = notifications::create($input[0]);
        $notification_id = $joborder['id'];
        $userid = Auth::user()->id;
        $name = Auth::user()->emp_name;
        $image = Auth::user()->image;
        foreach($assign_users as $dataa){
            $input3 = array([
                'notification_id' => $notification_id,
                'assign_users' => $dataa,
                'event' => 'Job Order '.$msg,
                'url' => 'job-order-view',
                'complaint' => $id,
                'complaint_id' => $id,
                'userid' => $userid,
                'name' => $name,
                'image' => $image,
            ]);
            $user = notification_details::create($input3[0]);
        }

        notification_details::where('notification_id', $notification_id)->where('assign_users', Auth::user()->id)->delete();
        
        $update = DB::table('job_orders')->where('id', $id)->update(['status' => $status]);
        if($update){
            $notification = array(
                'msg' => $msg,
                'value' => '1'
            );
            return response()->json($notification);
        }
        else{
            $error = 400;
            return response()->json($error);
        }
    }
}