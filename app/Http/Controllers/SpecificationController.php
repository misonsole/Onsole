<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use Auth;
use Session;
use Exception;
use App\Models\User;
use App\Models\Newrole;
use App\Models\PlcSole;
use App\Models\PlcRange;
use App\Models\PlcShape;
use App\Models\PlcPurpose;
use App\Models\PlcProject;
use App\Models\PlcLocation;
use App\Models\PlcCategory;
use App\Models\PlcPricing;
use Illuminate\Http\Request;
use App\Models\notifications; 
use App\Models\PlcLastNumber;
use App\Models\PlcSpecification;
use App\Models\notification_details;
use App\Models\PlcSpecificationDetail;
use App\Models\PlcSpecificationResource;
use App\Models\PlcSpecificationOverhead;

class SpecificationController extends Controller
{
    public function Specification(Request $request)
    {
        try{
            $store = 1;
            $season = array();
            $season5 = array();
            $color = array();
            $item_code = array();
            $article_code = array();
            $location = array();
            date_default_timezone_set('Asia/Karachi');
            $date = date('l d F Y - h:i');
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
            $last = PlcLastNumber::orderBy('id','DESC')->get();
            $location = PlcLocation::orderBy('location_no','ASC')->get();
            $category = PlcCategory::orderBy('id','DESC')->get();
            $project = PlcProject::orderBy('id','DESC')->get();
            $purpose = PlcPurpose::orderBy('id','DESC')->get();
            $range = PlcRange::orderBy('id','DESC')->get();
            $shape = PlcShape::orderBy('id','DESC')->get();
            $sole = PlcSole::orderBy('id','DESC')->get();
            $last = PlcLastNumber::orderBy('id','DESC')->get();
            $designNo = PlcPricing::orderBy('id','DESC')->where('status','Final')->pluck('design_no');
            $Support = PlcSpecification::orderBy('id','DESC')->limit(1)->get();
            if(count($Support) == 0){
                $result = $store + 0;
            }
            else{
                $result = $store + $Support[0]->sequence;
            }
            return view('specificationsheet.specification-sheet')->with([
                'i'=> 1, 'j'=> 1, 'last'=> $last, 'date'=> $date, 'sole'=> $sole, 'range'=> $range,'range'=> $range, 'shape'=> $shape, 'season'=> $season,
                'project'=> $project, 'purpose'=> $purpose, 'sequence'=> $result, 'location'=> $location, 'category'=> $category, 'itemcode'=> $item_code, 
                'articlecode'=> $article_code, 'designNo'=> $designNo, 'last'=> $last,
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

    public function Create(Request $request)
    {
        try{
            date_default_timezone_set('Asia/Karachi');
            $date = date('l d F Y - h:i');
            $filename = "0";
            if($request->image){
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension(); 
                $filename = time() . '.' . $extension;
                $file->move('uploads/appsetting/', $filename);
            }
            $upper = 1; $linning = 2; $stiching = 3; $insole = 4; $outsole = 5; $socks  = 6; $general = 7;
            $specification = new PlcSpecification();
            $specification->season = $request->season;
            $specification->status = "PD";
            $specification->progress = "25";
            $specification->purpose = $request->purpose;
            $specification->sequence = $request->sequence; 
            $specification->category = $request->category;
            $specification->last = $request->last;
            $specification->shape = $request->shape;
            $specification->sole = $request->sole; 
            $specification->range_no = $request->range; 
            $specification->design_no = $request->design; 
            $specification->description = $request->description;
            $specification->pricing = $request->pricing;
            $specification->project = $request->project; 
            $specification->product = $request->product; 
            $specification->date = isset($request->date) ? $request->date : $date;
            $specification->image = $filename;
            $result = $specification->save();
            $specification_id = $specification->id;
            if($request->cut_item_code[0] != null){
                $count = count($request->cut_item_code);
                for($i=0; $i<$count; $i++){
                    $dataArray = array(
                        'specification_id' => $specification_id,
                        'material' => "cutting",
                        'item_code' => $request->cut_item_code[$i] ? $request->cut_item_code[$i] : '-',
                        'description' => $request->cut_description[$i] ? ucwords($request->cut_description[$i]) : '-',
                        'uom' => isset($request->cut_uom[$i]) ? $request->cut_uom[$i] : '-',
                        'component' => isset($request->cut_component[$i]) ? $request->cut_component[$i] : '-',
                        'output' => isset($request->cut_output[$i]) ? $request->cut_output[$i] : '0',
                        'fac_qty' => isset($request->cut_output[$i]) ? round(1/$request->cut_output[$i],4) : '0',
                        'total_qty' => isset($request->cut_qty[$i]) ? $request->cut_qty[$i] : '0',
                        'process' => isset($request->cut_process[$i]) ? $request->cut_process[$i] : '0',
                        'total' => isset($request->cut_output[$i]) ? round((round(1/$request->cut_output[$i],4))*($request->cut_process[$i]/100)+round(1/$request->cut_output[$i],4),4) : '0',
                    );
                    $store = PlcSpecificationDetail::insert($dataArray);
                }
            }
            if($request->i_item_code[0] != null){
                $count1 = count($request->i_item_code);
                for($i=0; $i<$count1; $i++){
                    $dataArray = array(
                        'specification_id' => $specification_id,
                        'material' => "insole",
                        'item_code' => $request->i_item_code[$i] ? $request->i_item_code[$i] : '-',
                        'description' => $request->i_description[$i] ? ucwords($request->i_description[$i]) : '-',
                        'uom' => isset($request->i_uom[$i]) ? $request->i_uom[$i] : '-',
                        'component' => isset($request->i_component[$i]) ? $request->i_component[$i] : '-',
                        'output' => isset($request->i_output[$i]) ? $request->i_output[$i] : '0',
                        'fac_qty' => isset($request->i_output[$i]) ? round(1/$request->i_output[$i],4) : '0',
                        'total_qty' => isset($request->i_qty[$i]) ? $request->i_qty[$i] : '0',
                        'process' => isset($request->i_process[$i]) ? $request->i_process[$i] : '0',
                        'total' => isset($request->i_output[$i]) ? round((round(1/$request->i_output[$i],4))*($request->i_process[$i]/100)+round(1/$request->i_output[$i],4),4) : '0',
                    );
                    $store = PlcSpecificationDetail::insert($dataArray);
                }
            }
            if($request->lam_item_code[0] != null){
                $count1 = count($request->lam_item_code);
                for($i=0; $i<$count1; $i++){
                    $dataArray = array(
                        'specification_id' => $specification_id,
                        'material' => "lamination",
                        'item_code' => $request->lam_item_code[$i] ? $request->lam_item_code[$i] : '-',
                        'description' => $request->lam_description[$i] ? ucwords($request->lam_description[$i]) : '-',
                        'uom' => isset($request->lam_uom[$i]) ? $request->lam_uom[$i] : '-',
                        'component' => isset($request->lam_component[$i]) ? $request->lam_component[$i] : '-',
                        'output' => isset($request->lam_output[$i]) ? $request->lam_output[$i] : '0',
                        'fac_qty' => isset($request->lam_output[$i]) ? round(1/$request->lam_output[$i],4) : '0',
                        'total_qty' => isset($request->lam_qty[$i]) ? $request->lam_qty[$i] : '0',
                        'process' => isset($request->lam_process[$i]) ? $request->lam_process[$i] : '0',
                        'total' => isset($request->lam_output[$i]) ? round((round(1/$request->lam_output[$i],4))*($request->lam_process[$i]/100)+round(1/$request->lam_output[$i],4),4) : '0',
                    );
                    $store = PlcSpecificationDetail::insert($dataArray);
                }
            }
            if($request->clo_item_code[0] != null){
                $count1 = count($request->clo_item_code);
                for($i=0; $i<$count1; $i++){
                    $dataArray = array(
                        'specification_id' => $specification_id,
                        'material' => "closing",
                        'item_code' => $request->clo_item_code[$i] ? $request->clo_item_code[$i] : '-',
                        'description' => $request->clo_description[$i] ? ucwords($request->clo_description[$i]) : '-',
                        'uom' => isset($request->clo_uom[$i]) ? $request->clo_uom[$i] : '-',
                        'component' => isset($request->clo_component[$i]) ? $request->clo_component[$i] : '-',
                        'output' => isset($request->clo_output[$i]) ? $request->clo_output[$i] : '0',
                        'fac_qty' => isset($request->clo_output[$i]) ? round(1/$request->clo_output[$i],4) : '0',
                        'total_qty' => isset($request->clo_qty[$i]) ? $request->clo_qty[$i] : '0',
                        'process' => isset($request->clo_process[$i]) ? $request->clo_process[$i] : '0',
                        'total' => isset($request->clo_output[$i]) ? round((round(1/$request->clo_output[$i],4))*($request->clo_process[$i]/100)+round(1/$request->clo_output[$i],4),4) : '0',
                    );
                    $store = PlcSpecificationDetail::insert($dataArray);
                }
            }
            if($request->last_item_code[0] != null){
                $count1 = count($request->last_item_code);
                for($i=0; $i<$count1; $i++){
                    $dataArray = array(
                        'specification_id' => $specification_id,
                        'material' => "lasting",
                        'item_code' => $request->last_item_code[$i] ? $request->last_item_code[$i] : '-',
                        'description' => $request->last_description[$i] ? ucwords($request->last_description[$i]) : '-',
                        'uom' => isset($request->last_uom[$i]) ? $request->last_uom[$i] : '-',
                        'component' => isset($request->last_component[$i]) ? $request->last_component[$i] : '-',
                        'output' => isset($request->last_output[$i]) ? $request->last_output[$i] : '0',
                        'fac_qty' => isset($request->last_output[$i]) ? round(1/$request->last_output[$i],4) : '0',
                        'total_qty' => isset($request->last_qty[$i]) ? $request->last_qty[$i] : '0',
                        'process' => isset($request->last_process[$i]) ? $request->last_process[$i] : '0',
                        'total' => isset($request->last_output[$i]) ? round((round(1/$request->last_output[$i],4))*($request->last_process[$i]/100)+round(1/$request->last_output[$i],4),4) : '0',
                    );
                    $store = PlcSpecificationDetail::insert($dataArray);
                }
            }
            if($request->p_item_code[0] != null){
                $count1 = count($request->p_item_code);
                for($i=0; $i<$count1; $i++){
                    $dataArray = array(
                        'specification_id' => $specification_id,
                        'material' => "packing",
                        'item_code' => $request->p_item_code[$i] ? $request->p_item_code[$i] : '-',
                        'description' => $request->p_description[$i] ? ucwords($request->p_description[$i]) : '-',
                        'uom' => isset($request->p_uom[$i]) ? $request->p_uom[$i] : '-',
                        'component' => isset($request->p_component[$i]) ? $request->p_component[$i] : '-',
                        'output' => isset($request->p_output[$i]) ? $request->p_output[$i] : '0',
                        'fac_qty' => isset($request->p_output[$i]) ? round(1/$request->p_output[$i],4) : '0',
                        'total_qty' => isset($request->p_qty[$i]) ? $request->p_qty[$i] : '0',
                        'process' => isset($request->p_process[$i]) ? $request->p_process[$i] : '0',
                        'total' => isset($request->p_output[$i]) ? round((round(1/$request->p_output[$i],4))*($request->p_process[$i]/100)+round(1/$request->p_output[$i],4),4) : '0',
                    );
                    $store = PlcSpecificationDetail::insert($dataArray);
                }
            }
            $notification = array(
                'message' => 'Specification Sheet Created',
                'alert-type' => 'success'
            );
            return redirect()->route('specification-sheet-table')->with($notification);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function Users()
    {
        try{
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
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function ArticleCode($id)
    {
        try{
            $article_code = array();
            $wizerp  = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $connPRL = oci_connect("onsole","s",$wizerp);
            $sql3 = "SELECT SEGMENT_VALUE_DESC FROM WIZ_SEGMENT03 WHERE SEGMENT_VALUE_DESC LIKE '%$id%' AND STRUCTURE_ID = 26";
            $result3 = oci_parse($connPRL, $sql3);
            oci_execute($result3);
            while($row3 = oci_fetch_array($result3,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $article_code[] = $row3['SEGMENT_VALUE_DESC'];
            }
            return response()->json($article_code);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function Detail($id)
    {
        try{
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
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function ItemCode($id)
    {
        try{
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
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function View(Request $request)
    {
        try{
            $id = $_GET['id'];
            //Material
            $cuttingData = []; $InsoleData = []; $LaminationData = []; $ClosingData = []; $LastingData = []; $PackingData = [];
            $CutTotalValue = 0; $CutTotalRate = 0; $CutTotal = 0; $CutTotalFac = 0; $CutTotalQty = 0; $DataCutting = 0;
            $ITotalValue = 0; $ITotalRate = 0; $ITotal = 0; $ITotalFac = 0; $ITotalQty = 0; $DataInsole = 0;
            $LamTotalValue = 0; $LamTotalRate = 0; $LamTotal = 0; $LamTotalFac = 0; $LamTotalQty = 0; $DataLamination = 0;
            $CloTotalValue = 0; $CloTotalRate = 0; $CloTotal = 0; $CloTotalFac = 0; $CloTotalQty = 0; $DataClosing = 0;
            $LastTotalValue = 0; $LastTotalRate = 0; $LastTotal = 0; $LastTotalFac = 0; $LastTotalQty = 0; $DataLasting = 0;
            $PTotalValue = 0; $PTotalRate = 0; $PTotal = 0; $PTotalFac = 0; $PTotalQty = 0; $DataPacking = 0;
            //Overheads
            $cuttingData_o = []; $InsoleData_o = []; $LaminationData_o = []; $ClosingData_o = []; $LastingData_o = []; $PackingData_o = [];
            $CutTotalValue_o = 0; $CutTotalRate_o = 0; $CutTotal_o = 0; $CutTotalFac_o = 0; $CutTotalQty_o = 0; $DataCutting_o = 0;
            $ITotalValue_o = 0; $ITotalRate_o = 0; $ITotal_o = 0; $ITotalFac_o = 0; $ITotalQty_o = 0; $DataInsole_o = 0;
            $LamTotalValue_o = 0; $LamTotalRate_o = 0; $LamTotal_o = 0; $LamTotalFac_o = 0; $LamTotalQty_o = 0; $DataLamination_o = 0;
            $CloTotalValue_o = 0; $CloTotalRate_o = 0; $CloTotal_o = 0; $CloTotalFac_o = 0; $CloTotalQty_o = 0; $DataClosing_o = 0;
            $LastTotalValue_o = 0; $LastTotalRate_o = 0; $LastTotal_o = 0; $LastTotalFa_o = 0; $LastTotalQty_o = 0; $DataLasting_o = 0;
            $PTotalValue_o = 0; $PTotalRate_o = 0; $PTotal_o = 0; $PTotalFac_o = 0; $PTotalQty_o = 0; $DataPacking_o = 0;
            //Resources
            $cuttingData_r = []; $InsoleData_r = []; $LaminationData_r = []; $ClosingData_r = []; $LastingData_r = []; $PackingData_r = [];
            $CutTotalValue_r = 0; $CutTotalRate_r = 0; $CutTotal_r = 0; $CutTotalFac_r = 0; $CutTotalQty_r = 0; $DataCutting_r = 0;
            $ITotalValue_r = 0; $ITotalRate_r = 0; $ITotal_r = 0; $ITotalFac_r = 0; $ITotalQty_r = 0; $DataInsole_r = 0;
            $LamTotalValue_r = 0; $LamTotalRate_r = 0; $LamTotal_r = 0; $LamTotalFac_r = 0; $LamTotalQty_r = 0; $DataLamination_r = 0;
            $CloTotalValue_r = 0; $CloTotalRate_r = 0; $CloTotal_r = 0; $CloTotalFac_r = 0; $CloTotalQty_r = 0; $DataClosing_r = 0;
            $LastTotalValue_r = 0; $LastTotalRate_r = 0; $LastTotal_r = 0; $LastTotalFac_r = 0; $LastTotalQty_r = 0; $DataLasting_r = 0;
            $PTotalValue_r = 0; $PTotalRate_r = 0; $PTotal_r = 0; $PTotalFac_r = 0; $PTotalQty_r = 0; $DataPacking_r = 0;

            $GetPricingProfit = 0; $GetPricingPrice = 0;

            $data12 = DB::table('plc_specifications')->where('id', $id)->get();
            $DateTime = $data12[0]->created_at;
            $PricingNo = $data12[0]->pricing;
            $GetPricingData = DB::table('plc_pricings')->where('design_no', $PricingNo)->get();
            if($GetPricingData[0]->profit != null){
                $GetPricingProfit = $GetPricingData[0]->profit;
            }
            else{
                $GetPricingProfit = 0;
            }
            if($GetPricingData[0]->price != null){
                $GetPricingPrice = $GetPricingData[0]->price;
            }
            else{
                $GetPricingPrice = 0;
            }
            $DateTime = explode(' ', $DateTime);
            $data1 = DB::table('plc_specification_overheads')->where('specification_id', $id)->get();
            $data2 = DB::table('plc_specification_resources')->where('specification_id', $id)->get();
            $data3 = DB::table('plc_specification_details')->where('specification_id', $id)->get();
            foreach($data3 as $value){
                if($value->material == "cutting"){
                    $cuttingData[] = $value;
                }
                elseif($value->material == "insole"){
                    $InsoleData[] = $value;
                }
                elseif($value->material == "lamination"){
                    $LaminationData[] = $value;
                }
                elseif($value->material == "closing"){
                    $ClosingData[] = $value;
                }
                elseif($value->material == "lasting"){
                    $LastingData[] = $value;
                }
                elseif($value->material == "packing"){
                    $PackingData[] = $value;
                }
            }
            foreach($data1 as $value){
                if($value->material == "cutting"){
                    $cuttingData_o[] = $value;
                }
                elseif($value->material == "insole"){
                    $InsoleData_o[] = $value;
                }
                elseif($value->material == "lamination"){
                    $LaminationData_o[] = $value;
                }
                elseif($value->material == "closing"){
                    $ClosingData_o[] = $value;
                }
                elseif($value->material == "lasting"){
                    $LastingData_o[] = $value;
                }
                elseif($value->material == "packing"){
                    $PackingData_o[] = $value;
                }
            }
            foreach($data2 as $value){
                if($value->material == "cutting"){
                    $cuttingData_r[] = $value;
                }
                elseif($value->material == "insole"){
                    $InsoleData_r[] = $value;
                }
                elseif($value->material == "lamination"){
                    $LaminationData_r[] = $value;
                }
                elseif($value->material == "closing"){
                    $ClosingData_r[] = $value;
                }
                elseif($value->material == "lasting"){
                    $LastingData_r[] = $value;
                }
                elseif($value->material == "packing"){
                    $PackingData_r[] = $value;
                }
            }
            //Material
            if(!$cuttingData){
            }
            else{
                foreach($cuttingData as $value){
                    $CutTotalValue = $CutTotalValue + $value->value;
                    $CutTotalRate = $CutTotalRate + $value->rate;
                    $CutTotalQty = $CutTotalQty + $value->total_qty;
                    $CutTotalFac = $CutTotalFac + $value->fac_qty;
                    $CutTotal = $CutTotal + $value->total;
                }
                $DataCutting = [ 
                    'Value'=> $CutTotalValue,
                    'Rate'=> $CutTotalRate,
                    'TotalQty'=> $CutTotalQty,
                    'Fac'=> $CutTotalFac,
                    'Total'=> $CutTotal,
                ];
            }
            if(!$InsoleData){
            }
            else{
                foreach($InsoleData as $value){
                    $ITotalValue = $ITotalValue + $value->value;
                    $ITotalRate = $ITotalRate + $value->rate;
                    $ITotalQty = $ITotalQty + $value->total_qty;
                    $ITotalFac = $ITotalFac + $value->fac_qty;
                    $ITotal = $ITotal + $value->total;
                }
                $DataInsole = [ 
                    'Value'=> $ITotalValue,
                    'Rate'=> $ITotalRate,
                    'TotalQty'=> $ITotalQty,
                    'Fac'=> $ITotalFac,
                    'Total'=> $ITotal,
                ];
            }
            if(!$LaminationData){
            }
            else{
                foreach($LaminationData as $value){
                    $LamTotalValue = $LamTotalValue + $value->value;
                    $LamTotalRate = $LamTotalRate + $value->rate;
                    $LamTotalQty = $LamTotalQty + $value->total_qty;
                    $LamTotalFac = $LamTotalFac + $value->fac_qty;
                    $LamTotal = $LamTotal + $value->total;
                }
                $DataLamination = [ 
                    'Value'=> $LamTotalValue,
                    'Rate'=> $LamTotalRate,
                    'TotalQty'=> $LamTotalQty,
                    'Fac'=> $LamTotalFac,
                    'Total'=> $LamTotal,
                ];
            }
            if(!$ClosingData){
            }
            else{
                foreach($ClosingData as $value){
                    $CloTotalValue = $CloTotalValue + $value->value;
                    $CloTotalRate = $CloTotalRate + $value->rate;
                    $CloTotalQty = $CloTotalQty + $value->total_qty;
                    $CloTotalFac = $CloTotalFac + $value->fac_qty;
                    $CloTotal = $CloTotal + $value->total;
                }
                $DataClosing = [ 
                    'Value'=> $CloTotalValue,
                    'Rate'=> $CloTotalRate,
                    'TotalQty'=> $CloTotalQty,
                    'Fac'=> $CloTotalFac,
                    'Total'=> $CloTotal,
                ];
            }
            if(!$LastingData){
            }
            else{
                foreach($LastingData as $value){
                    $LastTotalValue = $LastTotalValue + $value->value;
                    $LastTotalRate = $LastTotalRate + $value->rate;
                    $LastTotalQty = $LastTotalQty + $value->total_qty;
                    $LastTotalFac = $LastTotalFac + $value->fac_qty;
                    $LastTotal = $LastTotal + $value->total;
                }
                $DataLasting = [ 
                    'Value'=> $LastTotalValue,
                    'Rate'=> $LastTotalRate,
                    'TotalQty'=> $LastTotalQty,
                    'Fac'=> $LastTotalFac,
                    'Total'=> $LastTotal,
                ];
            }
            if(!$PackingData){
            }
            else{
                foreach($PackingData as $value){
                    $PTotalValue = $PTotalValue + $value->value;
                    $PTotalRate = $PTotalRate + $value->rate;
                    $PTotalQty = $PTotalQty + $value->total_qty;
                    $PTotalFac = $PTotalFac + $value->fac_qty;
                    $PTotal =  $PTotal + $value->total;
                }
                $DataPacking = [ 
                    'Value'=> $PTotalValue,
                    'Rate'=> $PTotalRate,
                    'TotalQty'=> $PTotalQty,
                    'Fac'=> $PTotalFac,
                    'Total'=> $PTotal,
                ];
            }
            //Overheads
            if(!$cuttingData_o){
            }
            else{
                foreach($cuttingData_o as $value){
                    $CutTotalRate_o = $CutTotalRate_o + $value->pair;
                }
                $DataCutting_o = [ 
                    'Pair'=> $CutTotalRate_o,
                ];
            }
            if(!$InsoleData_o){
            }
            else{
                foreach($InsoleData_o as $value){
                    $ITotalRate_o = $ITotalRate_o + $value->pair;
                }
                $DataInsole_o = [ 
                    'Pair'=> $ITotalRate_o,
                ];
            }
            if(!$LaminationData_o){
            }
            else{
                foreach($LaminationData_o as $value){
                    $LamTotalRate_o = $LamTotalRate_o + $value->pair;
                }
                $DataLamination_o = [ 
                    'Pair'=> $LamTotalRate_o,
                ];
            }
            if(!$ClosingData_o){
            }
            else{
                foreach($ClosingData_o as $value){
                    $CloTotalRate_o = $CloTotalRate_o + $value->pair;
                }
                $DataClosing_o = [ 
                    'Pair'=> $CloTotalRate_o,
                ];
            }
            if(!$LastingData_o){
            }
            else{
                foreach($LastingData_o as $value){
                    $LastTotalRate_o = $LastTotalRate_o + $value->pair;
                }
                $DataLasting_o = [ 
                    'Pair'=> $LastTotalRate_o,
                ];
            }
            if(!$PackingData_o){
            }
            else{
                foreach($PackingData_o as $value){
                    $PTotalRate_o = $PTotalRate_o + $value->pair;
                }
                $DataPacking_o = [ 
                    'Pair'=> $PTotalRate_o,
                ];
            }
            //Resources
            if(!$cuttingData_r){
            }
            else{
                foreach($cuttingData_r as $value){
                    $CutTotalRate_r = $CutTotalRate_r + $value->pair;
                }
                $DataCutting_r = [ 
                    'Pair'=> $CutTotalRate_r,
                ];
            }
            if(!$InsoleData_r){
            }
            else{
                foreach($InsoleData_r as $value){
                    $ITotalRate_r = $ITotalRate_r + $value->pair;
                }
                $DataInsole_r = [ 
                    'Pair'=> $ITotalRate_r,
                ];
            }
            if(!$LaminationData_r){
            }
            else{
                foreach($LaminationData_r as $value){
                    $LamTotalRate_r = $LamTotalRate_r + $value->pair;
                }
                $DataLamination_r = [ 
                    'Pair'=> $LamTotalRate_r,
                ];
            }
            if(!$ClosingData_r){
            }
            else{
                foreach($ClosingData_r as $value){
                    $CloTotalRate_r = $CloTotalRate_r + $value->pair;
                }
                $DataClosing_r = [ 
                    'Pair'=> $CloTotalRate_r,
                ];
            }
            if(!$LastingData_r){
            }
            else{
                foreach($LastingData_r as $value){
                    $LastTotalRate_r = $LastTotalRate_r + $value->pair;
                }
                $DataLasting_r = [ 
                    'Pair'=> $LastTotalRate_r,
                ];
            }
            if(!$PackingData_r){
            }
            else{
                foreach($PackingData_r as $value){
                    $PTotalRate_r = $PTotalRate_r + $value->pair;
                }
                $DataPacking_r = [ 
                    'Pair'=> $PTotalRate_r,
                ];
            }
            $data = [
                'data1' => $data12[0], 'i' => 1,'j' => 1,'k' => 1,'l' => 1,'m' => 1,'n' => 1, 'date' => $DateTime[0],
                'cuttingData' => $cuttingData, 'InsoleData' => $InsoleData, 'LaminationData' => $LaminationData, 'ClosingData' => $ClosingData, 
                'LastingData' => $LastingData, 'PackingData' => $PackingData,
                'cuttingData_o' => $cuttingData_o, 'InsoleData_o' => $InsoleData_o, 'LaminationData_o' => $LaminationData_o, 'ClosingData_o' => $ClosingData_o,
                'LastingData_o' => $LastingData_o, 'PackingData_o' => $PackingData_o,
                'cuttingData_r' => $cuttingData_r, 'InsoleData_r' => $InsoleData_r, 'LaminationData_r' => $LaminationData_r, 'ClosingData_r' => $ClosingData_r,
                'LastingData_r' => $LastingData_r, 'PackingData_r' => $PackingData_r
            ];    
    
            return view('specificationsheet.specification-sheet-display')->with([            
                'data1' => $data12[0], 'i' => 1,'j' => 1,'k' => 1,'l' => 1,'m' => 1,'n' => 1,  'date' => $DateTime[0], 'GetPricingProfit' => $GetPricingProfit, 'GetPricingPrice' => $GetPricingPrice,
                'cuttingData' => $cuttingData, 'InsoleData' => $InsoleData, 'LaminationData' => $LaminationData, 'ClosingData' => $ClosingData, 
                'LastingData' => $LastingData, 'PackingData' => $PackingData,
                'cuttingData_o' => $cuttingData_o, 'InsoleData_o' => $InsoleData_o, 'LaminationData_o' => $LaminationData_o, 'ClosingData_o' => $ClosingData_o,
                'LastingData_o' => $LastingData_o, 'PackingData_o' => $PackingData_o,
                'cuttingData_r' => $cuttingData_r, 'InsoleData_r' => $InsoleData_r, 'LaminationData_r' => $LaminationData_r, 'ClosingData_r' => $ClosingData_r,
                'LastingData_r' => $LastingData_r, 'PackingData_r' => $PackingData_r,                           
                'DataCutting' => $DataCutting, 'DataInsole' => $DataInsole, 'DataLamination' => $DataLamination, 'DataClosing' => $DataClosing, 'DataLasting' => $DataLasting, 'DataPacking' => $DataPacking,
                'DataCutting_o' => $DataCutting_o, 'DataInsole_o' => $DataInsole_o, 'DataLamination_o' => $DataLamination_o, 'DataClosing_o' => $DataClosing_o, 'DataLasting_o' => $DataLasting_o, 'DataPacking_o' => $DataPacking_o,
                'DataCutting_r' => $DataCutting_r, 'DataInsole_r' => $DataInsole_r, 'DataLamination_r' => $DataLamination_r, 'DataClosing_r' => $DataClosing_r, 'DataLasting_r' => $DataLasting_r, 'DataPacking_r' => $DataPacking_r, 
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

    public function Print(Request $request)
    {
        try{
            $id = $_GET['id'];
            //Material
            $CuttingData = []; $LaminationData = []; $InsoleData = []; $ClosingData = []; $LastingData = []; $PackingData = [];
            $CutTotalValue = 0; $CutTotalRate = 0; $CutTotal = 0; $CutTotalFac = 0; $CutTotalQty = 0; $DataCutting = 0;
            $ITotalValue = 0; $ITotalRate = 0; $ITotal = 0; $ITotalFac = 0; $ITotalQty = 0; $DataInsole = 0;
            $LamTotalValue = 0; $LamTotalRate = 0; $LamTotal = 0; $LamTotalFac = 0; $LamTotalQty = 0; $DataLamination = 0;
            $CloTotalValue = 0; $CloTotalRate = 0; $CloTotal = 0; $CloTotalFac = 0; $CloTotalQty = 0; $DataClosing = 0;
            $LastTotalValue = 0; $LastTotalRate = 0; $LastTotal = 0; $LastTotalFac = 0; $LastTotalQty = 0; $DataLasting = 0;
            $PTotalValue = 0; $PTotalRate = 0; $PTotal = 0; $PTotalFac = 0; $PTotalQty = 0; $DataPacking = 0;
            //Overheads
            $CuttingData_o = []; $InsoleData_o = []; $LaminationData_o = []; $ClosingData_o = []; $LastingData_o = []; $PackingData_o = [];
            $CutTotalValue_o = 0; $CutTotalRate_o = 0; $CutTotal_o = 0; $CutTotalFac_o = 0; $CutTotalQty_o = 0; $DataCutting_o = 0;
            $ITotalValue_o = 0; $ITotalRate_o = 0; $ITotal_o = 0; $ITotalFac_o = 0; $ITotalQty_o = 0; $DataInsole_o = 0;
            $LamTotalValue_o = 0; $LamTotalRate_o = 0; $LamTotal_o = 0; $LamTotalFac_o = 0; $LamTotalQty_o = 0; $DataLamination_o = 0;
            $CloTotalValue_o = 0; $CloTotalRate_o = 0; $CloTotal_o = 0; $CloTotalFac_o = 0; $CloTotalQty_o = 0; $DataClosing_o = 0;
            $LastTotalValue_o = 0; $LastTotalRate_o = 0; $LastTotal_o = 0; $LastTotalFa_o = 0; $LastTotalQty_o = 0; $DataLasting_o = 0;
            $PTotalValue_o = 0; $PTotalRate_o = 0; $PTotal_o = 0; $PTotalFac_o = 0; $PTotalQty_o = 0; $DataPacking_o = 0;
            //Resources
            $CuttingData_r = []; $InsoleData_r = []; $LaminationData_r = []; $ClosingData_r = []; $LastingData_r = []; $PackingData_r = [];
            $CutTotalValue_r = 0; $CutTotalRate_r = 0; $CutTotal_r = 0; $CutTotalFac_r = 0; $CutTotalQty_r = 0; $DataCutting_r = 0;
            $ITotalValue_r = 0; $ITotalRate_r = 0; $ITotal_r = 0; $ITotalFac_r = 0; $ITotalQty_r = 0; $DataInsole_r = 0;
            $LamTotalValue_r = 0; $LamTotalRate_r = 0; $LamTotal_r = 0; $LamTotalFac_r = 0; $LamTotalQty_r = 0; $DataLamination_r = 0;
            $CloTotalValue_r = 0; $CloTotalRate_r = 0; $CloTotal_r = 0; $CloTotalFac_r = 0; $CloTotalQty_r = 0; $DataClosing_r = 0;
            $LastTotalValue_r = 0; $LastTotalRate_r = 0; $LastTotal_r = 0; $LastTotalFac_r = 0; $LastTotalQty_r = 0; $DataLasting_r = 0;
            $PTotalValue_r = 0; $PTotalRate_r = 0; $PTotal_r = 0; $PTotalFac_r = 0; $PTotalQty_r = 0; $DataPacking_r = 0;

            $GetPricingProfit = 0; $GetPricingPrice = 0;

            $data12 = DB::table('plc_specifications')->where('id', $id)->get();
            $DateTime = $data12[0]->created_at;
            $PricingNo = $data12[0]->pricing;
            $GetPricingData = DB::table('plc_pricings')->where('design_no', $PricingNo)->get();
            if($GetPricingData[0]->profit != null){
                $GetPricingProfit = $GetPricingData[0]->profit;
            }
            else{
                $GetPricingProfit = 0;
            }
            if($GetPricingData[0]->price != null){
                $GetPricingPrice = $GetPricingData[0]->price;
            }
            else{
                $GetPricingPrice = 0;
            }

            $data1 = DB::table('plc_specifications')->where('id', $id)->get();
            $DateTime = $data1[0]->created_at;
            $DateTime = explode(' ', $DateTime);
            $data2 = DB::table('plc_specification_details')->where('specification_id', $id)->get();
            $data3 = DB::table('plc_specification_overheads')->where('specification_id', $id)->get();
            $data4 = DB::table('plc_specification_resources')->where('specification_id', $id)->get();
            foreach($data2 as $value){
                if($value->material == "cutting"){
                    $CuttingData[] = $value;
                }
                elseif($value->material == "lamination"){
                    $LaminationData[] = $value;
                }
                elseif($value->material == "insole"){
                    $InsoleData[] = $value;
                }
                elseif($value->material == "closing"){
                    $ClosingData[] = $value;
                }
                elseif($value->material == "lasting"){
                    $LastingData[] = $value;
                }
                elseif($value->material == "packing"){
                    $PackingData[] = $value;
                }
            }
            foreach($data3 as $value){
                if($value->material == "cutting"){
                    $CuttingData_o[] = $value;
                }
                elseif($value->material == "lamination"){
                    $LaminationData_o[] = $value;
                }
                elseif($value->material == "insole"){
                    $InsoleData_o[] = $value;
                }
                elseif($value->material == "closing"){
                    $ClosingData_o[] = $value;
                }
                elseif($value->material == "lasting"){
                    $LastingData_o[] = $value;
                }
                elseif($value->material == "packing"){
                    $PackingData_o[] = $value;
                }
            }
            foreach($data4 as $value){
                if($value->material == "cutting"){
                    $CuttingData_r[] = $value;
                }
                elseif($value->material == "lamination"){
                    $LaminationData_r[] = $value;
                }
                elseif($value->material == "insole"){
                    $InsoleData_r[] = $value;
                }
                elseif($value->material == "closing"){
                    $ClosingData_r[] = $value;
                }
                elseif($value->material == "lasting"){
                    $LastingData_r[] = $value;
                }
                elseif($value->material == "packing"){
                    $PackingData_r[] = $value;
                }
            }
            //Material
            if(!$CuttingData){
            }
            else{
                foreach($CuttingData as $value){
                    $CutTotalValue = $CutTotalValue + $value->value;
                    $CutTotalRate = $CutTotalRate + $value->rate;
                    $CutTotalQty = $CutTotalQty + $value->total_qty;
                    $CutTotalFac = $CutTotalFac + $value->fac_qty;
                    $CutTotal = $CutTotal + $value->total;
                }
                $DataCutting = [ 
                    'Value'=> $CutTotalValue,
                    'Rate'=> $CutTotalRate,
                    'TotalQty'=> $CutTotalQty,
                    'Fac'=> $CutTotalFac,
                    'Total'=> $CutTotal,
                ];
            }
            if(!$InsoleData){
            }
            else{
                foreach($InsoleData as $value){
                    $ITotalValue = $ITotalValue + $value->value;
                    $ITotalRate = $ITotalRate + $value->rate;
                    $ITotalQty = $ITotalQty + $value->total_qty;
                    $ITotalFac = $ITotalFac + $value->fac_qty;
                    $ITotal = $ITotal + $value->total;
                }
                $DataInsole = [ 
                    'Value'=> $ITotalValue,
                    'Rate'=> $ITotalRate,
                    'TotalQty'=> $ITotalQty,
                    'Fac'=> $ITotalFac,
                    'Total'=> $ITotal,
                ];
            }
            if(!$LaminationData){
            }
            else{
                foreach($LaminationData as $value){
                    $LamTotalValue = $LamTotalValue + $value->value;
                    $LamTotalRate = $LamTotalRate + $value->rate;
                    $LamTotalQty = $LamTotalQty + $value->total_qty;
                    $LamTotalFac = $LamTotalFac + $value->fac_qty;
                    $LamTotal = $LamTotal + $value->total;
                }
                $DataLamination = [ 
                    'Value'=> $LamTotalValue,
                    'Rate'=> $LamTotalRate,
                    'TotalQty'=> $LamTotalQty,
                    'Fac'=> $LamTotalFac,
                    'Total'=> $LamTotal,
                ];
            }
            if(!$ClosingData){
            }
            else{
                foreach($ClosingData as $value){
                    $CloTotalValue = $CloTotalValue + $value->value;
                    $CloTotalRate = $CloTotalRate + $value->rate;
                    $CloTotalQty = $CloTotalQty + $value->total_qty;
                    $CloTotalFac = $CloTotalFac + $value->fac_qty;
                    $CloTotal = $CloTotal + $value->total;
                }
                $DataClosing = [ 
                    'Value'=> $CloTotalValue,
                    'Rate'=> $CloTotalRate,
                    'TotalQty'=> $CloTotalQty,
                    'Fac'=> $CloTotalFac,
                    'Total'=> $CloTotal,
                ];
            }
            if(!$LastingData){
            }
            else{
                foreach($LastingData as $value){
                    $LastTotalValue = $LastTotalValue + $value->value;
                    $LastTotalRate = $LastTotalRate + $value->rate;
                    $LastTotalQty = $LastTotalQty + $value->total_qty;
                    $LastTotalFac = $LastTotalFac + $value->fac_qty;
                    $LastTotal = $LastTotal + $value->total;
                }
                $DataLasting = [ 
                    'Value'=> $LastTotalValue,
                    'Rate'=> $LastTotalRate,
                    'TotalQty'=> $LastTotalQty,
                    'Fac'=> $LastTotalFac,
                    'Total'=> $LastTotal,
                ];
            }
            if(!$PackingData){
            }
            else{
                foreach($PackingData as $value){
                    $PTotalValue = $PTotalValue + $value->value;
                    $PTotalRate = $PTotalRate + $value->rate;
                    $PTotalQty = $PTotalQty + $value->total_qty;
                    $PTotalFac = $PTotalFac + $value->fac_qty;
                    $PTotal =  $PTotal + $value->total;
                }
                $DataPacking = [ 
                    'Value'=> $PTotalValue,
                    'Rate'=> $PTotalRate,
                    'TotalQty'=> $PTotalQty,
                    'Fac'=> $PTotalFac,
                    'Total'=> $PTotal,
                ];
            }
            //Overheads
            if(!$CuttingData_o){
            }
            else{
                foreach($CuttingData_o as $value){
                    $CutTotalRate_o = $CutTotalRate_o + $value->pair;
                }
                $DataCutting_o = [ 
                    'Pair'=> $CutTotalRate_o,
                ];
            }
            if(!$InsoleData_o){
            }
            else{
                foreach($InsoleData_o as $value){
                    $ITotalRate_o = $ITotalRate_o + $value->pair;
                }
                $DataInsole_o = [ 
                    'Pair'=> $ITotalRate_o,
                ];
            }
            if(!$LaminationData_o){
            }
            else{
                foreach($LaminationData_o as $value){
                    $LamTotalRate_o = $LamTotalRate_o + $value->pair;
                }
                $DataLamination_o = [ 
                    'Pair'=> $LamTotalRate_o,
                ];
            }
            if(!$ClosingData_o){
            }
            else{
                foreach($ClosingData_o as $value){
                    $CloTotalRate_o = $CloTotalRate_o + $value->pair;
                }
                $DataClosing_o = [ 
                    'Pair'=> $CloTotalRate_o,
                ];
            }
            if(!$LastingData_o){
            }
            else{
                foreach($LastingData_o as $value){
                    $LastTotalRate_o = $LastTotalRate_o + $value->pair;
                }
                $DataLasting_o = [ 
                    'Pair'=> $LastTotalRate_o,
                ];
            }
            if(!$PackingData_o){
            }
            else{
                foreach($PackingData_o as $value){
                    $PTotalRate_o = $PTotalRate_o + $value->pair;
                }
                $DataPacking_o = [ 
                    'Pair'=> $PTotalRate_o,
                ];
            }
            //Resources
            if(!$CuttingData_r){
            }
            else{
                foreach($CuttingData_r as $value){
                    $CutTotalRate_r = $CutTotalRate_r + $value->pair;
                }
                $DataCutting_r = [ 
                    'Pair'=> $CutTotalRate_r,
                ];
            }
            if(!$InsoleData_r){
            }
            else{
                foreach($InsoleData_r as $value){
                    $ITotalRate_r = $ITotalRate_r + $value->pair;
                }
                $DataInsole_r = [ 
                    'Pair'=> $ITotalRate_r,
                ];
            }
            if(!$LaminationData_r){
            }
            else{
                foreach($LaminationData_r as $value){
                    $LamTotalRate_r = $LamTotalRate_r + $value->pair;
                }
                $DataLamination_r = [ 
                    'Pair'=> $LamTotalRate_r,
                ];
            }
            if(!$ClosingData_r){
            }
            else{
                foreach($ClosingData_r as $value){
                    $CloTotalRate_r = $CloTotalRate_r + $value->pair;
                }
                $DataClosing_r = [ 
                    'Pair'=> $CloTotalRate_r,
                ];
            }
            if(!$LastingData_r){
            }
            else{
                foreach($LastingData_r as $value){
                    $LastTotalRate_r = $LastTotalRate_r + $value->pair;
                }
                $DataLasting_r = [ 
                    'Pair'=> $LastTotalRate_r,
                ];
            }
            if(!$PackingData_r){
            }
            else{
                foreach($PackingData_r as $value){
                    $PTotalRate_r = $PTotalRate_r + $value->pair;
                }
                $DataPacking_r = [ 
                    'Pair'=> $PTotalRate_r,
                ];
            }
            $data = [
                'i'=> 1, 'j'=> 1, 'k'=> 1, 'l'=> 1, 'm'=> 1,'n'=> 1,
                'data1'=> $data1[0], 'date' => $DateTime[0], 
                'CuttingData'=> $CuttingData, 'LaminationData'=> $LaminationData, 'InsoleData'=> $InsoleData, 'ClosingData'=> $ClosingData, 'LastingData'=> $LastingData, 
                'PackingData'=> $PackingData,
            ];   
                
            return view('specificationsheet.specification-sheet-pdf')->with([
                'j'=> 1, 'i'=> 1, 'k'=> 1, 'l'=> 1, 'm'=> 1,'n'=> 1,
                'data1'=> $data1[0], 'date' => $DateTime[0], 'GetPricingProfit' => $GetPricingProfit, 'GetPricingPrice' => $GetPricingPrice,
                'CuttingData'=> $CuttingData, 'LaminationData'=> $LaminationData, 'InsoleData'=> $InsoleData, 'ClosingData'=> $ClosingData, 'LastingData'=> $LastingData, 'PackingData'=> $PackingData,
                'CuttingData_r'=> $CuttingData_r, 'LaminationData_r'=> $LaminationData_r, 'InsoleData_r'=> $InsoleData_r, 'ClosingData_r'=> $ClosingData_r, 'LastingData_r'=> $LastingData_r, 'PackingData_r'=> $PackingData_r,
                'CuttingData_o'=> $CuttingData_o, 'LaminationData_o'=> $LaminationData_o, 'InsoleData_o'=> $InsoleData_o, 'ClosingData_o'=> $ClosingData_o, 'LastingData_o'=> $LastingData_o, 'PackingData_o'=> $PackingData_o,
                'DataCutting' => $DataCutting, 'DataInsole' => $DataInsole, 'DataLamination' => $DataLamination, 'DataClosing' => $DataClosing, 'DataLasting' => $DataLasting, 'DataPacking' => $DataPacking,
                'DataCutting_o' => $DataCutting_o, 'DataInsole_o' => $DataInsole_o, 'DataLamination_o' => $DataLamination_o, 'DataClosing_o' => $DataClosing_o, 'DataLasting_o' => $DataLasting_o, 'DataPacking_o' => $DataPacking_o,
                'DataCutting_r' => $DataCutting_r, 'DataInsole_r' => $DataInsole_r, 'DataLamination_r' => $DataLamination_r, 'DataClosing_r' => $DataClosing_r, 'DataLasting_r' => $DataLasting_r, 'DataPacking_r' => $DataPacking_r, 
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

    public function Update(Request $request)
    {
        try{
            $id = $request->id;
            date_default_timezone_set('Asia/Karachi');
            $date = date('l d F Y - h:i');
            $sessionImg = Session::get('image');
            $upper = 1; $linning = 2; $stiching = 3; $insole = 4; $outsole = 5; $socks  = 6; $general = 7;
            $costingImage = DB::table('plc_specifications')->where('id', $id)->pluck('image');
            $filename = "0";
            if($request->image){
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension(); 
                $filename = time() . '.' . $extension;
                $file->move('uploads/appsetting/', $filename);
            }
            else{
                $filename = $costingImage[0];
            }
            $id = $request->id;
            $season = $request->season;
            $purpose = $request->purpose;
            $sequence = $request->sequence;
            $category = $request->category;
            $shape = $request->shape;
            $sole = $request->sole; 
            $range_no = $request->range; 
            $design_no = $request->design; 
            $description = $request->description;
            $project = $request->project; 
            $product = $request->product; 
            $pricing = $request->pricing; 
            $last = $request->last; 
            $date = isset($request->date) ? $request->date : $date;
            $costingImage = DB::table('plc_specifications')->where('id', $id)->pluck('image');
            $data = array(
                'season' => $season, 'purpose' => $purpose, 'image' => $filename, 'category' => $category, 'date' => $date, 'shape' => $shape, 'sole' => $sole,
                'range_no' => $range_no, 'design_no' => $design_no, 'description' => $description, 'project' => $project, 'product' => $product, 'pricing' => $pricing, 'last' => $last,
            );
            $update = DB::table('plc_specifications')->where('id', $id)->update($data);
            if($update){
                $updatee = PlcSpecificationDetail::where('specification_id', $id)->pluck('id');
                if(isset($updatee[0]) == $id){
                    PlcSpecificationDetail::where('specification_id', $id)->delete();
                }
                if($request->cut_item_code[0] != null){
                    $count = count($request->cut_item_code);
                    for($i=0; $i<$count; $i++){
                        $dataArray = array(
                            'specification_id' => $id,
                            'material' => "cutting",
                            'item_code' => $request->cut_item_code[$i] ? $request->cut_item_code[$i] : '-',
                            'description' => $request->cut_description[$i] ? ucwords($request->cut_description[$i]) : '-',
                            'uom' => isset($request->cut_uom[$i]) ? $request->cut_uom[$i] : '-',
                            'component' => isset($request->cut_component[$i]) ? $request->cut_component[$i] : '-',
                            'output' => isset($request->cut_output[$i]) ? $request->cut_output[$i] : '-',
                            'fac_qty' => isset($request->cut_output[$i]) ? round(1/$request->cut_output[$i],4) : '-',
                            'total_qty' => isset($request->cut_qty[$i]) ? $request->cut_qty[$i] : '-',
                            'process' => isset($request->cut_process[$i]) ? $request->cut_process[$i] : '-',
                            'total' => isset($request->cut_output[$i]) ? round((round(1/$request->cut_output[$i],4))*($request->cut_process[$i]/100)+round(1/$request->cut_output[$i],4),4) : '0',
                        );
                        $store = PlcSpecificationDetail::insert($dataArray);
                    }
                }
                if($request->i_item_code[0] != null){
                    $count1 = count($request->i_item_code);
                    for($i=0; $i<$count1; $i++){
                        $dataArray = array(
                            'specification_id' => $id,
                            'material' => "insole",
                            'item_code' => $request->i_item_code[$i] ? $request->i_item_code[$i] : '-',
                            'description' => $request->i_description[$i] ? ucwords($request->i_description[$i]) : '-',
                            'uom' => isset($request->i_uom[$i]) ? $request->i_uom[$i] : '-',
                            'component' => isset($request->i_component[$i]) ? $request->i_component[$i] : '-',
                            'output' => isset($request->i_output[$i]) ? $request->i_output[$i] : '-',
                            'fac_qty' => isset($request->i_output[$i]) ? round(1/$request->i_output[$i],4) : '-',
                            'total_qty' => isset($request->i_qty[$i]) ? $request->i_qty[$i] : '-',
                            'process' => isset($request->i_process[$i]) ? $request->i_process[$i] : '-',
                            'total' => isset($request->i_output[$i]) ? round((round(1/$request->i_output[$i],4))*($request->i_process[$i]/100)+round(1/$request->i_output[$i],4),4) : '0',
                        );
                        $store = PlcSpecificationDetail::insert($dataArray);
                    }
                }
                if($request->lam_item_code[0] != null){
                    $count1 = count($request->lam_item_code);
                    for($i=0; $i<$count1; $i++){
                        $dataArray = array(
                            'specification_id' => $id,
                            'material' => "lamination",
                            'item_code' => $request->lam_item_code[$i] ? $request->lam_item_code[$i] : '-',
                            'description' => $request->lam_description[$i] ? ucwords($request->lam_description[$i]) : '-',
                            'uom' => isset($request->lam_uom[$i]) ? $request->lam_uom[$i] : '-',
                            'component' => isset($request->lam_component[$i]) ? $request->lam_component[$i] : '-',
                            'output' => isset($request->lam_output[$i]) ? $request->lam_output[$i] : '-',
                            'fac_qty' => isset($request->lam_output[$i]) ? round(1/$request->lam_output[$i],4) : '-',
                            'total_qty' => isset($request->lam_qty[$i]) ? $request->lam_qty[$i] : '-',
                            'process' => isset($request->lam_process[$i]) ? $request->lam_process[$i] : '-',
                            'total' => isset($request->lam_output[$i]) ? round((round(1/$request->lam_output[$i],4))*($request->lam_process[$i]/100)+round(1/$request->lam_output[$i],4),4) : '0',
                        );
                        $store = PlcSpecificationDetail::insert($dataArray);
                    }
                }
                if($request->clo_item_code[0] != null){
                    $count1 = count($request->clo_item_code);
                    for($i=0; $i<$count1; $i++){
                        $dataArray = array(
                            'specification_id' => $id,
                            'material' => "closing",
                            'item_code' => $request->clo_item_code[$i] ? $request->clo_item_code[$i] : '-',
                            'description' => $request->clo_description[$i] ? ucwords($request->clo_description[$i]) : '-',
                            'uom' => isset($request->clo_uom[$i]) ? $request->clo_uom[$i] : '-',
                            'component' => isset($request->clo_component[$i]) ? $request->clo_component[$i] : '-',
                            'output' => isset($request->clo_output[$i]) ? $request->clo_output[$i] : '-',
                            'fac_qty' => isset($request->clo_output[$i]) ? round(1/$request->clo_output[$i],4) : '-',
                            'total_qty' => isset($request->clo_qty[$i]) ? $request->clo_qty[$i] : '-',
                            'process' => isset($request->clo_process[$i]) ? $request->clo_process[$i] : '-',
                            'total' => isset($request->clo_output[$i]) ? round((round(1/$request->clo_output[$i],4))*($request->clo_process[$i]/100)+round(1/$request->clo_output[$i],4),4) : '0',
                        );
                        $store = PlcSpecificationDetail::insert($dataArray);
                    }
                }
                if($request->last_item_code[0] != null){
                    $count1 = count($request->last_item_code);
                    for($i=0; $i<$count1; $i++){
                        $dataArray = array(
                            'specification_id' => $id,
                            'material' => "lasting",
                            'item_code' => $request->last_item_code[$i] ? $request->last_item_code[$i] : '-',
                            'description' => $request->last_description[$i] ? ucwords($request->last_description[$i]) : '-',
                            'uom' => isset($request->last_uom[$i]) ? $request->last_uom[$i] : '-',
                            'component' => isset($request->last_component[$i]) ? $request->last_component[$i] : '-',
                            'output' => isset($request->last_output[$i]) ? $request->last_output[$i] : '-',
                            'fac_qty' => isset($request->last_output[$i]) ? round(1/$request->last_output[$i],4) : '-',
                            'total_qty' => isset($request->last_qty[$i]) ? $request->last_qty[$i] : '-',
                            'process' => isset($request->last_process[$i]) ? $request->last_process[$i] : '-',
                            'total' => isset($request->last_output[$i]) ? round((round(1/$request->last_output[$i],4))*($request->last_process[$i]/100)+round(1/$request->last_output[$i],4),4) : '0',
                        );
                        $store = PlcSpecificationDetail::insert($dataArray);
                    }
                }
                if($request->p_item_code[0] != null){
                    $count1 = count($request->p_item_code);
                    for($i=0; $i<$count1; $i++){
                        $dataArray = array(
                            'specification_id' => $id,
                            'material' => "packing",
                            'item_code' => $request->p_item_code[$i] ? $request->p_item_code[$i] : '-',
                            'description' => $request->p_description[$i] ? ucwords($request->p_description[$i]) : '-',
                            'uom' => isset($request->p_uom[$i]) ? $request->p_uom[$i] : '-',
                            'component' => isset($request->p_component[$i]) ? $request->p_component[$i] : '-',
                            'output' => isset($request->p_output[$i]) ? $request->p_output[$i] : '-',
                            'fac_qty' => isset($request->p_output[$i]) ? round(1/$request->p_output[$i],4) : '-',
                            'total_qty' => isset($request->p_qty[$i]) ? $request->p_qty[$i] : '-',
                            'process' => isset($request->p_process[$i]) ? $request->p_process[$i] : '-',
                            'total' => isset($request->p_output[$i]) ? round((round(1/$request->p_output[$i],4))*($request->p_process[$i]/100)+round(1/$request->p_output[$i],4),4) : '0',
                        );
                        $store = PlcSpecificationDetail::insert($dataArray);
                    }
                }
                $notification = array(
                    'message' => 'Specification Sheet Updated',
                    'alert-type' => 'success'
                );
                return redirect()->route('specification-sheet-table')->with($notification);
            }
            else{
                $notification = array(
                    'message' => 'Something went wrong',
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

    public function UpdateMaterial(Request $request)
    {
        try{
            $id = $request->id;
            DB::table('plc_specifications')->where('id', $id)->update(['progress' => 80]);
            if(isset($request->cut_item_code[0]) != null){
                $start = 0;
                foreach($request->cut_id as $dataId){
                    $dataArray = array(
                        'rate' => isset($request->cut_rate[$start]) ? $request->cut_rate[$start] : '0',
                        'value' => $request->cut_rate[$start] * $request->cut_total_con[$start],
                    );
                    $start++;
                    $updatedata = DB::table('plc_specification_details')->where('id', $dataId)->update($dataArray);
                }
            }
            if(isset($request->i_item_code[0]) != null){
                $start = 0;
                foreach($request->i_id as $dataId){
                    $dataArray = array(
                        'rate' => isset($request->i_rate[$start]) ? $request->i_rate[$start] : '0',
                        'value' => $request->i_rate[$start] * $request->i_total_con[$start],
                    );
                    $start++;
                    $updatedata = DB::table('plc_specification_details')->where('id', $dataId)->update($dataArray);
                }
            }
            if(isset($request->lam_item_code[0]) != null){
                $start = 0;
                foreach($request->lam_id as $dataId){
                    $dataArray = array(
                        'rate' => isset($request->lam_rate[$start]) ? $request->lam_rate[$start] : '0',
                        'value' => $request->lam_rate[$start] * $request->lam_total_con[$start],
                    );
                    $start++;
                    $updatedata = DB::table('plc_specification_details')->where('id', $dataId)->update($dataArray);
                }
            }
            if(isset($request->clo_item_code[0]) != null){
                $start = 0;
                foreach($request->clo_id as $dataId){
                    $dataArray = array(
                        'rate' => isset($request->clo_rate[$start]) ? $request->clo_rate[$start] : '0',
                        'value' => $request->clo_rate[$start] * $request->clo_total_con[$start],
                    );
                    $start++;
                    $updatedata = DB::table('plc_specification_details')->where('id', $dataId)->update($dataArray);
                }
            }
            if(isset($request->last_item_code[0]) != null){
                $start = 0;
                foreach($request->last_id as $dataId){
                    $dataArray = array(
                        'rate' => isset($request->last_rate[$start]) ? $request->last_rate[$start] : '0',
                        'value' => $request->last_rate[$start] * $request->last_total_con[$start],
                    );
                    $start++;
                    $updatedata = DB::table('plc_specification_details')->where('id', $dataId)->update($dataArray);
                }
            }
            if(isset($request->p_item_code[0]) != null){
                $start = 0;
                foreach($request->p_id as $dataId){
                    $dataArray = array(
                        'rate' => isset($request->p_rate[$start]) ? $request->p_rate[$start] : '0',
                        'value' => $request->p_rate[$start] * $request->p_total_con[$start],
                    );
                    $start++;
                    $updatedata = DB::table('plc_specification_details')->where('id', $dataId)->update($dataArray);
                }
            }
            $notification = array(
                'message' => 'Specification Sheet Updated',
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

    public function UpdateEditMaterial(Request $request)
    {
        try{
            $id = $request->id;
            if(isset($request->cut_item_code[0]) != null){
                $start = 0;
                foreach($request->cut_id as $dataId){
                    $dataArray = array(
                        'rate' => isset($request->cut_rate[$start]) ? $request->cut_rate[$start] : '0',
                        'value' => $request->cut_rate[$start] * $request->cut_total_con[$start],
                    );
                    $start++;
                    $updatedata = DB::table('plc_specification_details')->where('id', $dataId)->update($dataArray);
                }
            }
            if(isset($request->i_item_code[0]) != null){
                $start = 0;
                foreach($request->i_id as $dataId){
                    $dataArray = array(
                        'rate' => isset($request->i_rate[$start]) ? $request->i_rate[$start] : '0',
                        'value' => $request->i_rate[$start] * $request->i_total_con[$start],
                    );
                    $start++;
                    $updatedata = DB::table('plc_specification_details')->where('id', $dataId)->update($dataArray);
                }
            }
            if(isset($request->lam_item_code[0]) != null){
                $start = 0;
                foreach($request->lam_id as $dataId){
                    $dataArray = array(
                        'rate' => isset($request->lam_rate[$start]) ? $request->lam_rate[$start] : '0',
                        'value' => $request->lam_rate[$start] * $request->lam_total_con[$start],
                    );
                    $start++;
                    $updatedata = DB::table('plc_specification_details')->where('id', $dataId)->update($dataArray);
                }
            }
            if(isset($request->clo_item_code[0]) != null){
                $start = 0;
                foreach($request->clo_id as $dataId){
                    $dataArray = array(
                        'rate' => isset($request->clo_rate[$start]) ? $request->clo_rate[$start] : '0',
                        'value' => $request->clo_rate[$start] * $request->clo_total_con[$start],
                    );
                    $start++;
                    $updatedata = DB::table('plc_specification_details')->where('id', $dataId)->update($dataArray);
                }
            }
            if(isset($request->last_item_code[0]) != null){
                $start = 0;
                foreach($request->last_id as $dataId){
                    $dataArray = array(
                        'rate' => isset($request->last_rate[$start]) ? $request->last_rate[$start] : '0',
                        'value' => $request->last_rate[$start] * $request->last_total_con[$start],
                    );
                    $start++;
                    $updatedata = DB::table('plc_specification_details')->where('id', $dataId)->update($dataArray);
                }
            }
            if(isset($request->p_item_code[0]) != null){
                $start = 0;
                foreach($request->p_id as $dataId){
                    $dataArray = array(
                        'rate' => isset($request->p_rate[$start]) ? $request->p_rate[$start] : '0',
                        'value' => $request->p_rate[$start] * $request->p_total_con[$start],
                    );
                    $start++;
                    $updatedata = DB::table('plc_specification_details')->where('id', $dataId)->update($dataArray);
                }
            }
            $notification = array(
                'message' => 'Specification Sheet Updated',
                'alert-type' => 'success'
            );
            return redirect()->route('specification-sheet-table')->with($notification);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function UpdateResource(Request $request)
    {
        try{
            $id = $request->id;
            $fetch = DB::table('plc_specifications')->where('id', $id)->get();
            if($fetch[0]->progress != 90){
                DB::table('plc_specifications')->where('id', $id)->update(['progress' => 85]);
            }
            PlcSpecificationResource::where('specification_id', $id)->delete();
            if($request->cut_value_r[0] != null){
                $count = count($request->cut_value_r);
                for($i=0; $i<$count; $i++){
                    $dataArray = array(
                        'specification_id' => $id,
                        'material' => "cutting",
                        'value_set' => $request->cut_value_r[$i] ? $request->cut_value_r[$i] : '-',
                        'description' => $request->cut_description_r[$i] ? ucwords($request->cut_description_r[$i]) : '-',
                        'remarks' => isset($request->cut_remarks_r[$i]) ? $request->cut_remarks_r[$i] : '-',
                        'pair' => isset($request->cut_rate_r[$i]) ? $request->cut_rate_r[$i] : '0',
                    );
                    $store = PlcSpecificationResource::insert($dataArray);
                }
            }
            if($request->i_value_r[0] != null){
                $count = count($request->i_value_r);
                for($i=0; $i<$count; $i++){
                    $dataArray = array(
                        'specification_id' => $id,
                        'material' => "insole",
                        'value_set' => $request->i_value_r[$i] ? $request->i_value_r[$i] : '-',
                        'description' => $request->i_description_r[$i] ? ucwords($request->i_description_r[$i]) : '-',
                        'remarks' => isset($request->i_remarks_r[$i]) ? $request->i_remarks_r[$i] : '-',
                        'pair' => isset($request->i_rate_r[$i]) ? $request->i_rate_r[$i] : '0',
                    );
                    $store = PlcSpecificationResource::insert($dataArray);
                }
            }
            if($request->lam_value_r[0] != null){
                $count = count($request->lam_value_r);
                for($i=0; $i<$count; $i++){
                    $dataArray = array(
                        'specification_id' => $id,
                        'material' => "lamination",
                        'value_set' => $request->lam_value_r[$i] ? $request->lam_value_r[$i] : '-',
                        'description' => $request->lam_description_r[$i] ? ucwords($request->lam_description_r[$i]) : '-',
                        'remarks' => isset($request->lam_remarks_r[$i]) ? $request->lam_remarks_r[$i] : '-',
                        'pair' => isset($request->lam_rate_r[$i]) ? $request->lam_rate_r[$i] : '0',
                    );
                    $store = PlcSpecificationResource::insert($dataArray);
                }
            }
            if($request->clo_value_r[0] != null){
                $count = count($request->clo_value_r);
                for($i=0; $i<$count; $i++){
                    $dataArray = array(
                        'specification_id' => $id,
                        'material' => "closing",
                        'value_set' => $request->clo_value_r[$i] ? $request->clo_value_r[$i] : '-',
                        'description' => $request->clo_description_r[$i] ? ucwords($request->clo_description_r[$i]) : '-',
                        'remarks' => isset($request->clo_remarks_r[$i]) ? $request->clo_remarks_r[$i] : '-',
                        'pair' => isset($request->clo_rate_r[$i]) ? $request->clo_rate_r[$i] : '0',
                    );
                    $store = PlcSpecificationResource::insert($dataArray);
                }
            }
            if($request->last_value_r[0] != null){
                $count = count($request->last_value_r);
                for($i=0; $i<$count; $i++){
                    $dataArray = array(
                        'specification_id' => $id,
                        'material' => "lasting",
                        'value_set' => $request->last_value_r[$i] ? $request->last_value_r[$i] : '-',
                        'description' => $request->last_description_r[$i] ? ucwords($request->last_description_r[$i]) : '-',
                        'remarks' => isset($request->last_remarks_r[$i]) ? $request->last_remarks_r[$i] : '-',
                        'pair' => isset($request->last_rate_r[$i]) ? $request->last_rate_r[$i] : '0',
                    );
                    $store = PlcSpecificationResource::insert($dataArray);
                }
            }
            if($request->p_value_r[0] != null){
                $count = count($request->p_value_r);
                for($i=0; $i<$count; $i++){
                    $dataArray = array(
                        'specification_id' => $id,
                        'material' => "packing",
                        'value_set' => $request->p_value_r[$i] ? $request->p_value_r[$i] : '-',
                        'description' => $request->p_description_r[$i] ? ucwords($request->p_description_r[$i]) : '-',
                        'remarks' => isset($request->p_remarks_r[$i]) ? $request->p_remarks_r[$i] : '-',
                        'pair' => isset($request->p_rate_r[$i]) ? $request->p_rate_r[$i] : '0',
                    );
                    $store = PlcSpecificationResource::insert($dataArray);
                }
            }
            $notification = array(
                'message' => 'Specificatio Sheet Resources Updated',
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

    public function UpdateOverhead(Request $request)
    {
        try{
            $id = $request->id;
            PlcSpecificationOverhead::where('specification_id', $id)->delete();
            DB::table('plc_specifications')->where('id', $id)->update(['progress' => 90]);
            if($request->cut_value_o[0] != null){
                $count = count($request->cut_value_o);
                for($i=0; $i<$count; $i++){
                    $dataArray = array(
                        'specification_id' => $id,
                        'material' => "cutting",
                        'value_set' => $request->cut_value_o[$i] ? $request->cut_value_o[$i] : '-',
                        'description' => $request->cut_description_o[$i] ? ucwords($request->cut_description_o[$i]) : '-',
                        'remarks' => isset($request->cut_remarks_o[$i]) ? $request->cut_remarks_o[$i] : '-',
                        'pair' => isset($request->cut_rate_o[$i]) ? $request->cut_rate_o[$i] : '0',
                    );
                    $store = PlcSpecificationOverhead::insert($dataArray);
                }
            }
            if($request->i_value_o[0] != null){
                $count = count($request->i_value_o);
                for($i=0; $i<$count; $i++){
                    $dataArray = array(
                        'specification_id' => $id,
                        'material' => "insole",
                        'value_set' => $request->i_value_o[$i] ? $request->i_value_o[$i] : '-',
                        'description' => $request->i_description_o[$i] ? ucwords($request->i_description_o[$i]) : '-',
                        'remarks' => isset($request->i_remarks_o[$i]) ? $request->i_remarks_o[$i] : '-',
                        'pair' => isset($request->i_rate_o[$i]) ? $request->i_rate_o[$i] : '0',
                    );
                    $store = PlcSpecificationOverhead::insert($dataArray);
                }
            }
            if($request->lam_value_o[0] != null){
                $count = count($request->lam_value_o);
                for($i=0; $i<$count; $i++){
                    $dataArray = array(
                        'specification_id' => $id,
                        'material' => "lamination",
                        'value_set' => $request->lam_value_o[$i] ? $request->lam_value_o[$i] : '-',
                        'description' => $request->lam_description_o[$i] ? ucwords($request->lam_description_o[$i]) : '-',
                        'remarks' => isset($request->lam_remarks_o[$i]) ? $request->lam_remarks_o[$i] : '-',
                        'pair' => isset($request->lam_rate_o[$i]) ? $request->lam_rate_o[$i] : '0',
                    );
                    $store = PlcSpecificationOverhead::insert($dataArray);
                }
            }
            if($request->clo_value_o[0] != null){
                $count = count($request->clo_value_o);
                for($i=0; $i<$count; $i++){
                    $dataArray = array(
                        'specification_id' => $id,
                        'material' => "closing",
                        'value_set' => $request->clo_value_o[$i] ? $request->clo_value_o[$i] : '-',
                        'description' => $request->clo_description_o[$i] ? ucwords($request->clo_description_o[$i]) : '-',
                        'remarks' => isset($request->clo_remarks_o[$i]) ? $request->clo_remarks_o[$i] : '-',
                        'pair' => isset($request->clo_rate_o[$i]) ? $request->clo_rate_o[$i] : '0',
                    );
                    $store = PlcSpecificationOverhead::insert($dataArray);
                }
            }
            if($request->last_value_o[0] != null){
                $count = count($request->last_value_o);
                for($i=0; $i<$count; $i++){
                    $dataArray = array(
                        'specification_id' => $id,
                        'material' => "lasting",
                        'value_set' => $request->last_value_o[$i] ? $request->last_value_o[$i] : '-',
                        'description' => $request->last_description_o[$i] ? ucwords($request->last_description_o[$i]) : '-',
                        'remarks' => isset($request->last_remarks_o[$i]) ? $request->last_remarks_o[$i] : '-',
                        'pair' => isset($request->last_rate_o[$i]) ? $request->last_rate_o[$i] : '0',
                    );
                    $store = PlcSpecificationOverhead::insert($dataArray);
                }
            }
            if($request->p_value_o[0] != null){
                $count = count($request->p_value_o);
                for($i=0; $i<$count; $i++){
                    $dataArray = array(
                        'specification_id' => $id,
                        'material' => "packing",
                        'value_set' => $request->p_value_o[$i] ? $request->p_value_o[$i] : '-',
                        'description' => $request->p_description_o[$i] ? ucwords($request->p_description_o[$i]) : '-',
                        'remarks' => isset($request->p_remarks_o[$i]) ? $request->p_remarks_o[$i] : '-',
                        'pair' => isset($request->p_rate_o[$i]) ? $request->p_rate_o[$i] : '0',
                    );
                    $store = PlcSpecificationOverhead::insert($dataArray);
                }
            }
            $notification = array(
                'message' => 'Specification Sheet Overhead',
                'alert-type' => 'success'
            );
            return redirect()->route('specification-sheet-table')->with($notification);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function UpdateCosting(Request $request)
    {
        try{
            $id = $_GET['id'];
            $cuttingData = []; $InsoleData = []; $LaminationData = []; $ClosingData = []; $LastingData = []; $PackingData = [];
            $cuttingData_o = []; $InsoleData_o = []; $LaminationData_o = []; $ClosingData_o = []; $LastingData_o = []; $PackingData_o = [];
            $cuttingData_r = []; $InsoleData_r = []; $LaminationData_r = []; $ClosingData_r = []; $LastingData_r = []; $PackingData_r = [];
            $data = DB::table('plc_specifications')->where('id', $id)->get();
            $userseason = $data[0]->season;
            $userpurpose = $data[0]->purpose;
            $userimage = $data[0]->image;
            Session::put('image', $userimage);
            $sequence = $data[0]->sequence;
            $date = $data[0]->date;
            $category = $data[0]->category;
            $usershape = $data[0]->shape;
            $usersole = $data[0]->sole;
            $userproject = $data[0]->project;
            $userproduct = $data[0]->product;
            $userrange = $data[0]->range_no;
            $userdesign = $data[0]->design_no;
            $userdescription = $data[0]->description;
            $usercategory = $data[0]->category;
            $progress = $data[0]->progress;
            $data1 = DB::table('plc_specification_overheads')->where('specification_id', $id)->get();
            $data2 = DB::table('plc_specification_resources')->where('specification_id', $id)->get();
            $data3 = DB::table('plc_specification_details')->where('specification_id', $id)->get();
            foreach($data3 as $value){
                if($value->material == "cutting"){
                    $cuttingData[] = $value;
                }
                elseif($value->material == "insole"){
                    $InsoleData[] = $value;
                }
                elseif($value->material == "lamination"){
                    $LaminationData[] = $value;
                }
                elseif($value->material == "closing"){
                    $ClosingData[] = $value;
                }
                elseif($value->material == "lasting"){
                    $LastingData[] = $value;
                }
                elseif($value->material == "packing"){
                    $PackingData[] = $value;
                }
            }
            foreach($data1 as $value){
                if($value->material == "cutting"){
                    $cuttingData_o[] = $value;
                }
                elseif($value->material == "insole"){
                    $InsoleData_o[] = $value;
                }
                elseif($value->material == "lamination"){
                    $LaminationData_o[] = $value;
                }
                elseif($value->material == "closing"){
                    $ClosingData_o[] = $value;
                }
                elseif($value->material == "lasting"){
                    $LastingData_o[] = $value;
                }
                elseif($value->material == "packing"){
                    $PackingData_o[] = $value;
                }
            }
            foreach($data2 as $value){
                if($value->material == "cutting"){
                    $cuttingData_r[] = $value;
                }
                elseif($value->material == "insole"){
                    $InsoleData_r[] = $value;
                }
                elseif($value->material == "lamination"){
                    $LaminationData_r[] = $value;
                }
                elseif($value->material == "closing"){
                    $ClosingData_r[] = $value;
                }
                elseif($value->material == "lasting"){
                    $LastingData_r[] = $value;
                }
                elseif($value->material == "packing"){
                    $PackingData_r[] = $value;
                }
            }
            return view('specificationsheet.specification-sheet-update-costing')->with([
                'id'=> $id,
                'data'=> $data[0],
                'i'=> 1,'j'=> 1,'k'=> 1,'l'=> 1,'m'=> 1,'n'=> 1,
                'a1'=> 1, 'a2'=> 1, 'a11'=> 1, 'a22'=> 1, 'a111'=> 1, 'a222'=> 1, 'b1'=> 1, 'b2'=> 1, 'b11'=> 1, 'b22'=> 1, 'b111'=> 1, 'b222'=> 1,
                'c1'=> 1, 'c2'=> 1, 'c11'=> 1, 'c22'=> 1, 'c111'=> 1, 'c222'=> 1, 'd1'=> 1, 'd2'=> 1, 'd11'=> 1, 'd22'=> 1, 'd111'=> 1, 'd222'=> 1,
                'e1'=> 1,'e2'=> 1,'e11'=> 1,'e22'=> 1,'e111'=> 1,'e222'=> 1, 'f1'=> 1,'f2'=> 1,'f11'=> 1,'f22'=> 1,'f111'=> 1,'f222'=> 1,
                'cuttingData'=> $cuttingData, 'InsoleData'=> $InsoleData, 'LaminationData'=> $LaminationData, 'ClosingData'=> $ClosingData, 'LastingData'=> $LastingData, 'PackingData'=> $PackingData,
                'cuttingData_o'=> $cuttingData_o, 'InsoleData_o'=> $InsoleData_o, 'LaminationData_o'=> $LaminationData_o, 'ClosingData_o'=> $ClosingData_o, 'LastingData_o'=> $LastingData_o, 'PackingData_o'=> $PackingData_o,
                'cuttingData_r'=> $cuttingData_r, 'InsoleData_r'=> $InsoleData_r, 'LaminationData_r'=> $LaminationData_r, 'ClosingData_r'=> $ClosingData_r, 'LastingData_r'=> $LastingData_r, 'PackingData_r'=> $PackingData_r,
                'userseason'=> $userseason, 'userpurpose'=> $userpurpose, 'image'=> $userimage, 'category'=> $category, 'usershape'=> $usershape, 'usersole'=> $usersole,
                'userproject'=>$userproject, 'userproduct'=>$userproduct, 'userrange'=>$userrange, 'userdesign'=>$userdesign, 'userdescription'=>$userdescription,
                'usercategory'=>$usercategory, 'sequence'=>$sequence, 'date'=>$date, 'progress'=>$progress
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

    public function Edit(Request $request)
    {
        try{
            $id = $_GET['id'];
            $cuttingData = []; $InsoleData = []; $LaminationData = []; $ClosingData = []; $LastingData = []; $PackingData = [];
            $data1 = DB::table('plc_specifications')->where('id', $id)->get();
            $data2 = DB::table('plc_specification_details')->where('specification_id', $id)->get();
            $userseason = $data1[0]->season;
            $userpurpose = $data1[0]->purpose;
            $userimage = $data1[0]->image;
            Session::put('image', $userimage);
            $sequence = $data1[0]->sequence;
            $date = $data1[0]->date;
            $category = $data1[0]->category;
            $usershape = $data1[0]->shape;
            $usersole = $data1[0]->sole;
            $userproject = $data1[0]->project;
            $userproduct = $data1[0]->product;
            $userrange = $data1[0]->range_no;
            $userdesign = $data1[0]->design_no;
            $userdescription = $data1[0]->description;
            $usercategory = $data1[0]->category;
            $userpricing = $data1[0]->pricing;
            $userlast = $data1[0]->last;
    
            $wizerp  = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $connPRL = oci_connect("onsole","s",$wizerp);
            $sql = "SELECT SEASON_DEF_DESC FROM ONSOLE_SEASON_DEFINITION";
            $result = oci_parse($connPRL, $sql);
            oci_execute($result);
            while($row = oci_fetch_array($result,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $season[] = $row['SEASON_DEF_DESC'];
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
            foreach($data2 as $value){
                if($value->material == "cutting"){
                    $cuttingData[] = $value;
                }
                elseif($value->material == "insole"){
                    $InsoleData[] = $value;
                }
                elseif($value->material == "lamination"){
                    $LaminationData[] = $value;
                }
                elseif($value->material == "closing"){
                    $ClosingData[] = $value;
                }
                elseif($value->material == "lasting"){
                    $LastingData[] = $value;
                }
                elseif($value->material == "packing"){
                    $PackingData[] = $value;
                }
            }
            $category = PlcCategory::orderBy('id','DESC')->get();
            $project = PlcProject::orderBy('id','DESC')->get();
            $purpose = PlcPurpose::orderBy('id','DESC')->get();
            $range = PlcRange::orderBy('id','DESC')->get();
            $shape = PlcShape::orderBy('id','DESC')->get();
            $sole = PlcSole::orderBy('id','DESC')->get();
            $last = PlcLastNumber::orderBy('id','DESC')->get();
            $location = PlcLocation::orderBy('id','DESC')->get();
            $designNo = PlcPricing::orderBy('id','DESC')->where('status','Final')->pluck('design_no');
            return view('specificationsheet.specification-sheet-edit')->with([
                'id'=> $id,
                'data1'=> $data1[0],
                'i'=> 1,'j'=> 1,'k'=> 1,'l'=> 1,'m'=> 1,'n'=> 1,
                'cuttingData'=> $cuttingData, 'InsoleData'=> $InsoleData, 'LaminationData'=> $LaminationData, 'ClosingData'=> $ClosingData, 'LastingData'=> $LastingData, 'PackingData'=> $PackingData,
                'a1'=> 1, 'a2'=> 1, 'b1'=> 1, 'b2'=> 1, 'c1'=> 1, 'c2'=> 1, 'd1'=> 1, 'd2'=> 1, 'e1'=> 1, 'e2'=> 1, 'f1'=> 1,'f2'=> 1,
                'season'=> $season, 'itemcode'=> $item_code, 'userseason'=> $userseason, 'userpurpose'=> $userpurpose, 'sequence'=> $sequence, 'date'=> $date, 'image'=> $userimage, 'last' => $last,
                'articlecode'=> $article_code, 'category'=> $category, 'usershape'=> $usershape, 'usersole'=> $usersole, 'userproject'=> $userproject,
                'userproduct'=> $userproduct, 'userrange'=> $userrange, 'userdesign'=> $userdesign, 'userdescription'=> $userdescription, 'usercategory'=> $usercategory, 'userlast'=> $userlast,
                'shape'=> $shape, 'sole'=> $sole, 'project'=> $project, 'range'=> $range, 'purpose'=> $purpose, 'userpricing'=> $userpricing, 'designNo'=> $designNo, 'location'=> $location,
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

    public function CreateCosting(Request $request)
    {
        try{
            $id = $_GET['id'];
            $season = []; $item_code = []; $article_code = [];
            $cuttingData = []; $InsoleData = []; $LaminationData = []; $ClosingData = []; $LastingData = []; $PackingData = [];
            $data1 = DB::table('plc_specifications')->where('id', $id)->get();
            $data2 = DB::table('plc_specification_details')->where('specification_id', $id)->get();
            $userseason = $data1[0]->season;
            $userpurpose = $data1[0]->purpose;
            $userimage = $data1[0]->image;
            Session::put('image', $userimage);
            $sequence = $data1[0]->sequence;
            $date = $data1[0]->date;
            $category = $data1[0]->category;
            $usershape = $data1[0]->shape;
            $usersole = $data1[0]->sole;
            $userproject = $data1[0]->project;
            $userproduct = $data1[0]->product;
            $userrange = $data1[0]->range_no;
            $userdesign = $data1[0]->design_no;
            $userdescription = $data1[0]->description;
            $usercategory = $data1[0]->category;
            $userprogress = $data1[0]->progress;        
            foreach($data2 as $value){
                if($value->material == "cutting"){
                    $cuttingData[] = $value;
                }
                elseif($value->material == "insole"){
                    $InsoleData[] = $value;
                }
                elseif($value->material == "lamination"){
                    $LaminationData[] = $value;
                }
                elseif($value->material == "closing"){
                    $ClosingData[] = $value;
                }
                elseif($value->material == "lasting"){
                    $LastingData[] = $value;
                }
                elseif($value->material == "packing"){
                    $PackingData[] = $value;
                }
            }
            $category = PlcCategory::orderBy('id','DESC')->get();
            $project = PlcProject::orderBy('id','DESC')->get();
            $purpose = PlcPurpose::orderBy('id','DESC')->get();
            $range = PlcRange::orderBy('id','DESC')->get();
            $shape = PlcShape::orderBy('id','DESC')->get();
            $sole = PlcSole::orderBy('id','DESC')->get();
            return view('specificationsheet.specification-sheet-create-costing')->with([
                'id'=> $id,                           
                'data1'=> $data1[0],
                'i'=> 1,'j'=> 1,'k'=> 1,'l'=> 1,'m'=> 1,'n'=> 1,
                'cuttingData'=> $cuttingData, 'InsoleData'=> $InsoleData, 'LaminationData'=> $LaminationData, 'ClosingData'=> $ClosingData, 'LastingData'=> $LastingData, 'PackingData'=> $PackingData,
                'a1'=> 1,'a2'=> 1, 'b1'=> 1,'b2'=> 1, 'c1'=> 1,'c2'=> 1, 'd1'=> 1,'d2'=> 1, 'e1'=> 1,'e2'=> 1, 'f1'=> 1,'f2'=> 1,
                'season'=> $season, 'itemcode'=> $item_code, 'userseason'=> $userseason, 'userpurpose'=> $userpurpose, 'sequence'=> $sequence, 'date'=> $date,
                'image'=> $userimage, 'articlecode'=> $article_code, 'category'=> $category, 'usershape'=> $usershape, 'usersole'=> $usersole, 'userproject'=> $userproject,
                'userproduct'=> $userproduct, 'userrange'=> $userrange, 'userdesign'=> $userdesign, 'userdescription'=> $userdescription, 'usercategory'=> $usercategory,
                'userprogress'=> $userprogress, 'shape'=> $shape, 'sole'=> $sole, 'project'=> $project, 'range'=> $range, 'purpose'=> $purpose,
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
            if(isset($storeData['Pricing-Sheet Costing']) && !empty($storeData['Pricing-Sheet Costing'])){
                if(isset($storeData['Pricing-Sheet Costing']) == 1){
                    $data = PlcSpecification::orderBy('id','DESC')->where('status', "Costing")->Orwhere('status', "Sales")->Orwhere('status', "Final")->get();
                }
                return view('specificationsheet.specification-sheet-costing-table')->with(['data'=> $data, 'i'=> 1]);
            }
            elseif(isset($storeData['Pricing-Sheet Sales']) && !empty($storeData['Pricing-Sheet Sales'])){
                if(isset($storeData['Pricing-Sheet Sales']) == 1){
                    $data = PlcSpecification::orderBy('id','DESC')->where('status', "Sales")->Orwhere('status', "Final")->get();
                }
                return view('specificationsheet.specification-sheet-sales-table')->with(['data'=> $data, 'i'=> 1]);
            }
            elseif(isset($storeData['Quality-Control']) && !empty($storeData['Quality-Control'])){
                if(isset($storeData['Quality-Control']) == 1){
                    $data = PlcSpecification::orderBy('id','DESC')->where('status', "QC")->Orwhere('status', "Production")->Orwhere('status', "Update")->Orwhere('status', "Final")->get();
                }
                return view('specificationsheet.specification-sheet-qc-table')->with(['data'=> $data, 'i'=> 1]);
            }
            elseif(isset($storeData['Production-Planning-Control']) && !empty($storeData['Production-Planning-Control'])){
                if(isset($storeData['Production-Planning-Control']) == 1){
                    $data = PlcSpecification::orderBy('id','DESC')->where('status', "PPC")->Orwhere('status', "Costing")->Orwhere('status', "Final")->get();
                }
                return view('specificationsheet.specification-sheet-ppc-table')->with(['data'=> $data, 'i'=> 1]);
            }
            elseif(isset($storeData['Pricing-Sheet Production']) && !empty($storeData['Pricing-Sheet Production'])){
                if(isset($storeData['Pricing-Sheet Production']) == 1){
                    $data = PlcSpecification::orderBy('id','DESC')->where('status', "Production")->Orwhere('status', "Costing")->Orwhere('status', "Final")->get();
                }
                return view('specificationsheet.specification-sheet-ppc-table')->with(['data'=> $data, 'i'=> 1]);
            }
            elseif(isset($storeData['Pricing-Sheet List']) && !empty($storeData['Pricing-Sheet List'])){
                if(isset($storeData['Pricing-Sheet List']) == 1){
                    $data = PlcSpecification::orderBy('id','DESC')->get();
                }
                return view('specificationsheet.specification-sheet-table')->with(['data'=> $data, 'i'=> 1]);
            } 
            else{
                $data = PlcSpecification::orderBy('id','DESC')->get();
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

    public function Delete($id)
    {
        try{
            $delete = PlcSpecification::where('id', $id)->delete();
            $delete1 = PlcSpecificationDetail::where('specification_id', $id)->delete();
            $delete1 = PlcSpecificationResource::where('specification_id', $id)->delete();
            $delete1 = PlcSpecificationOverhead::where('specification_id', $id)->delete();
            if($delete){
                return response()->json($delete);
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

    public function Calculate(Request $request)
    {
        try{
            $id = $request->calculateId;
            $calculateValue = $request->calculateValue;
            $total1 = 0; $total2 = 0; $total3 = 0;
            $data1 = PlcSpecificationDetail::where('specification_id', $id)->pluck('rate');
            $data2 = PlcSpecificationResource::where('specification_id', $id)->pluck('pair');
            $data3 = PlcSpecificationOverhead::where('specification_id', $id)->pluck('pair');
            foreach($data1 as $value1){
                $total1 = $total1 + $value1;
            }
            foreach($data2 as $value2){
                $total2 = $total2 + $value2;
            }
            foreach($data3 as $value3){
                $total3 = $total3 + $value3;
            }
            $result = $total1 + $total2 + $total3;
            $profit = ($result / 100) * $calculateValue;
            $actualPrice = $result;
            $total = $actualPrice + $profit;
            $updateProfit = DB::table('plc_specifications')->where('id', $id)->update(['profit' => $actualPrice]);
            $updatePrice = DB::table('plc_specifications')->where('id', $id)->update(['price' => $total]);
            DB::table('plc_specifications')->where('id', $id)->update(['progress' => 100]);
            if($updatePrice && $updateProfit){
                return response()->json($updatePrice);
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

    public function Status($id,$status,$remarks)
    {
        try{
            date_default_timezone_set('Asia/Karachi');
            $date1 = date("d-F-Y");
            $msg = 0; $department = 0;
            if($status == "Costing"){
                $msg = "Transferred to Costing";
                $msg1 = "Transferred";
                $progress = 75;
                $assign_users = Newrole::orderBy('id','ASC')->where('role_name', 'Pricing-Sheet Costing')->where('value', 1)->get()->unique('name');
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
            }
            if($status == "Rejected"){
                $msg = "Rejected";
                $msg1 = "Rejected";
                $assign_users = Newrole::orderBy('id','ASC')->where('role_name', 'Pricing-Sheet List')->where('value', 1)->get()->unique('name');
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
            }
            if($status == "QC"){
                $msg = "QC";
                $msg1 = "QC";
                $progress = 25;
                $assign_users = Newrole::orderBy('id','ASC')->where('role_name', 'Quality-Control')->where('value', 1)->get()->unique('name');
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
            }
            if($status == "Production"){
                $msg = "Production";
                $msg1 = "Production";
                $progress = 50;
                $assign_users = Newrole::orderBy('id','ASC')->where('role_name', 'Pricing-Sheet Production')->where('value', 1)->get()->unique('name');
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
            }
            if($status == "Update"){
                $msg = "Update";
                $msg1 = "Update";
                $assign_users = Newrole::orderBy('id','ASC')->where('role_name', 'Pricing-Sheet List')->where('value', 1)->get()->unique('name');
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
            }
            if($status == "PD"){
                $msg = "PD";
                $msg1 = "PD";
                $progress = 25;
                $assign_users = Newrole::orderBy('id','ASC')->where('role_name', 'Pricing-Sheet List')->where('value', 1)->get()->unique('name');
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
            }
            if($status == "Sales"){
                $msg = "Approved";
                $msg1 = "Approved";
                $progress = 100;
                $assign_users = Newrole::orderBy('id','ASC')->where('role_name', 'Pricing-Sheet Sales')->where('value', 1)->get()->unique('name');
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
            } 
            if($status == "Final"){
                $msg = "Finalized";
                $msg1 = "Finalized";
                $progress = 100;
                $assign_users = Newrole::orderBy('id','ASC')->where('role_name', 'Pricing-Sheet Sales')
                                                            ->Orwhere('role_name', 'Pricing-Sheet List')
                                                            ->Orwhere('role_name', 'Pricing-Sheet Production')
                                                            ->Orwhere('role_name', 'Pricing-Sheet Costing')
                                                            ->Orwhere('role_name', 'Quality-Control')
                                                            ->where('value', 1)->get()->unique('name');
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
            }    
            $input = array([
                'data' => $date1,
                'event_at' => 'Specification Sheet',
                'complaint_id' => $id
            ]);
            $joborder = notifications::create($input[0]);
            $notification_id = $joborder['id'];
            $userid = Auth::user()->id;
            $name = Auth::user()->emp_name;
            $image = Auth::user()->image;
            foreach($result as $dataa){
                $input3 = array([
                    'notification_id' => $notification_id,
                    'assign_users' => $dataa,
                    'event' => 'Specification Sheet '.$msg1,
                    'url' => 'specification-sheet-view',
                    'complaint' => $id,
                    'complaint_id' => $id,
                    'userid' => $userid,
                    'name' => $name,
                    'image' => $image,
                ]);
                $user = notification_details::create($input3[0]);
            }
    
            notification_details::where('notification_id', $notification_id)->where('assign_users', Auth::user()->id)->delete();
            $update = DB::table('plc_specifications')->where('id', $id)->update(['status' => $status, 'progress' => $progress, 'remarks' => $remarks]);
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
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }
}
