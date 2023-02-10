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
use App\Models\PlcManual;
use App\Models\PlcPurpose;
use App\Models\Division;
use App\Models\PlcFormula;
use App\Models\PlcPricing;
use App\Models\PlcProject;
use App\Models\SubDivision;
use App\Models\PlcLocation;
use App\Models\PlcCategory;
use Illuminate\Http\Request;
use App\Models\PlcLastNumber;
use App\Models\notifications;
use App\Models\PlcSpecification;
use App\Models\PlcPricingDetail;
use App\Models\PlcPricingProcess;
use App\Models\PlcPricingResource;
use App\Models\PlcPricingOverhead;
use App\Models\notification_details;

class PricingController extends Controller
{
    public function Costing(Request $request)
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
            $date = date('d F Y');
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
            $division = Division::orderBy('id','DESC')->get();
            $Support = PlcPricing::orderBy('id','DESC')->limit(1)->get();
            if(count($Support) == 0){
                $result = $store + 0;
            }
            else{
                $result = $store + $Support[0]->sequence;
            }
            return view('pricingsheet.pricing-sheet')->with([
                'i'=> 1, 'j'=> 1, 'last'=> $last, 'date'=> $date, 'sole'=> $sole, 'range'=> $range,'range'=> $range, 'shape'=> $shape, 'season'=> $season,
                'project'=> $project, 'purpose'=> $purpose, 'sequence'=> $result, 'location'=> $location, 'category'=> $category, 'itemcode'=> $item_code, 
                'articlecode'=> $article_code, 'division'=> $division, 
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
            $date = date('d F Y');
            $filename = "0";
            if($request->image){
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension(); 
                $filename = time() . '.' . $extension;
                $file->move('uploads/appsetting/', $filename);
            }
            $upper = 1; $linning = 2; $stiching = 3; $insole = 4; $outsole = 5; $socks  = 6; $general = 7;
            $costing = new PlcPricing();
            $costing->season = $request->season;
            $costing->status = "Pending";
            $costing->progress = "20";
            $costing->purpose = $request->purpose;
            $costing->sequence = $request->sequence; 
            $costing->category = $request->category;
            $costing->last = $request->last;
            $costing->shape = $request->shape;
            $costing->sole = $request->sole; 
            $costing->range_no = $request->range; 
            $costing->design_no = $request->design; 
            $costing->description = $request->description;
            $costing->project = $request->project; 
            $costing->product = $request->product; 
            $costing->date = isset($request->date) ? $request->date : $date;
            $costing->image = $filename;
            $result = $costing->save();
            $costing_id = $costing->id;
            if($request->manualtext[0] != null){
                $manualcount = count($request->manualtext);
                for($i=0; $i<$manualcount; $i++){
                    $dataArray = array(
                        'costing_id' => $costing_id,
                        'manual' => $request->manualtext[$i] ? $request->manualtext[$i] : '-',
                    );
                    $store = PlcManual::insert($dataArray);
                }
            }
            if($request->cut_item_code[0] != null){
                $count = count($request->cut_item_code);
                for($i=0; $i<$count; $i++){
                    $dataArray = array(
                        'costing_id' => $costing_id,
                        'material' => "cutting",
                        'item_code' => $request->cut_item_code[$i] ? $request->cut_item_code[$i] : '-',
                        'description' => $request->cut_description[$i] ? ucwords($request->cut_description[$i]) : '-',
                        'uom' => isset($request->cut_uom[$i]) ? $request->cut_uom[$i] : '-',
                        'division' => isset($request->cut_division[$i]) ? $request->cut_division[$i] : '-',
                        'subdivision' => isset($request->cut_subdivision[$i]) ? $request->cut_subdivision[$i] : '-',
                        'output' => isset($request->cut_output[$i]) ? $request->cut_output[$i] : '0',
                        'cut_code' => isset($request->cut_cut_code[$i]) ? $request->cut_cut_code[$i] : '0',
                        'fac_qty' => isset($request->cut_output[$i]) ? round(1/$request->cut_output[$i],4) : '0',
                        'total_qty' => isset($request->cut_qty[$i]) ? $request->cut_qty[$i] : '0',
                        'process' => isset($request->cut_process[$i]) ? $request->cut_process[$i] : '0',
                        'total' => isset($request->cut_output[$i]) ? round((round(1/$request->cut_output[$i],4))*($request->cut_process[$i]/100)+round(1/$request->cut_output[$i],4),4) : '0',
                    );
                    $store = PlcPricingDetail::insert($dataArray);
                }
            }
            if($request->i_item_code[0] != null){
                $count1 = count($request->i_item_code);
                for($i=0; $i<$count1; $i++){
                    $dataArray = array(
                        'costing_id' => $costing_id,
                        'material' => "insole",
                        'item_code' => $request->i_item_code[$i] ? $request->i_item_code[$i] : '-',
                        'description' => $request->i_description[$i] ? ucwords($request->i_description[$i]) : '-',
                        'uom' => isset($request->i_uom[$i]) ? $request->i_uom[$i] : '-',
                        'division' => isset($request->i_division[$i]) ? $request->i_division[$i] : '-',
                        'subdivision' => isset($request->i_subdivision[$i]) ? $request->i_subdivision[$i] : '-',
                        'output' => isset($request->i_output[$i]) ? $request->i_output[$i] : '0',
                        'cut_code' => isset($request->i_cut_code[$i]) ? $request->i_cut_code[$i] : '0',
                        'fac_qty' => isset($request->i_output[$i]) ? round(1/$request->i_output[$i],4) : '0',
                        'total_qty' => isset($request->i_qty[$i]) ? $request->i_qty[$i] : '0',
                        'process' => isset($request->i_process[$i]) ? $request->i_process[$i] : '0',
                        'total' => isset($request->i_output[$i]) ? round((round(1/$request->i_output[$i],4))*($request->i_process[$i]/100)+round(1/$request->i_output[$i],4),4) : '0',
                    );
                    $store = PlcPricingDetail::insert($dataArray);
                }
            }
            if($request->lam_item_code[0] != null){
                $count1 = count($request->lam_item_code);
                for($i=0; $i<$count1; $i++){
                    $dataArray = array(
                        'costing_id' => $costing_id,
                        'material' => "lamination",
                        'item_code' => $request->lam_item_code[$i] ? $request->lam_item_code[$i] : '-',
                        'description' => $request->lam_description[$i] ? ucwords($request->lam_description[$i]) : '-',
                        'uom' => isset($request->lam_uom[$i]) ? $request->lam_uom[$i] : '-',
                        'division' => isset($request->lam_division[$i]) ? $request->lam_division[$i] : '-',
                        'subdivision' => isset($request->lam_subdivision[$i]) ? $request->lam_subdivision[$i] : '-',
                        'output' => isset($request->lam_output[$i]) ? $request->lam_output[$i] : '0',
                        'cut_code' => isset($request->lam_cut_code[$i]) ? $request->lam_cut_code[$i] : '0',
                        'fac_qty' => isset($request->lam_output[$i]) ? round(1/$request->lam_output[$i],4) : '0',
                        'total_qty' => isset($request->lam_qty[$i]) ? $request->lam_qty[$i] : '0',
                        'process' => isset($request->lam_process[$i]) ? $request->lam_process[$i] : '0',
                        'total' => isset($request->lam_output[$i]) ? round((round(1/$request->lam_output[$i],4))*($request->lam_process[$i]/100)+round(1/$request->lam_output[$i],4),4) : '0',

                    );
                    $store = PlcPricingDetail::insert($dataArray);
                }
            }
            if($request->clo_item_code[0] != null){
                $count1 = count($request->clo_item_code);
                for($i=0; $i<$count1; $i++){
                    $dataArray = array(
                        'costing_id' => $costing_id,
                        'material' => "closing",
                        'item_code' => $request->clo_item_code[$i] ? $request->clo_item_code[$i] : '-',
                        'description' => $request->clo_description[$i] ? ucwords($request->clo_description[$i]) : '-',
                        'uom' => isset($request->clo_uom[$i]) ? $request->clo_uom[$i] : '-',
                        'division' => isset($request->clo_division[$i]) ? $request->clo_division[$i] : '-',
                        'subdivision' => isset($request->clo_subdivision[$i]) ? $request->clo_subdivision[$i] : '-',
                        'output' => isset($request->clo_output[$i]) ? $request->clo_output[$i] : '0',
                        'cut_code' => isset($request->clo_cut_code[$i]) ? $request->clo_cut_code[$i] : '0',                        
                        'fac_qty' => isset($request->clo_output[$i]) ? round(1/$request->clo_output[$i],4) : '0',
                        'total_qty' => isset($request->clo_qty[$i]) ? $request->clo_qty[$i] : '0',
                        'process' => isset($request->clo_process[$i]) ? $request->clo_process[$i] : '0',
                        'total' => isset($request->clo_output[$i]) ? round((round(1/$request->clo_output[$i],4))*($request->clo_process[$i]/100)+round(1/$request->clo_output[$i],4),4) : '0',
                    );
                    $store = PlcPricingDetail::insert($dataArray);
                }
            }
            if($request->last_item_code[0] != null){
                $count1 = count($request->last_item_code);
                for($i=0; $i<$count1; $i++){
                    $dataArray = array(
                        'costing_id' => $costing_id,
                        'material' => "lasting",
                        'item_code' => $request->last_item_code[$i] ? $request->last_item_code[$i] : '-',
                        'description' => $request->last_description[$i] ? ucwords($request->last_description[$i]) : '-',
                        'uom' => isset($request->last_uom[$i]) ? $request->last_uom[$i] : '-',
                        'division' => isset($request->last_division[$i]) ? $request->last_division[$i] : '-',
                        'subdivision' => isset($request->last_subdivision[$i]) ? $request->last_subdivision[$i] : '-',
                        'output' => isset($request->last_output[$i]) ? $request->last_output[$i] : '0',
                        'cut_code' => isset($request->last_cut_code[$i]) ? $request->last_cut_code[$i] : '0',                        
                        'fac_qty' => isset($request->last_output[$i]) ? round(1/$request->last_output[$i],4) : '0',
                        'total_qty' => isset($request->last_qty[$i]) ? $request->last_qty[$i] : '0',
                        'process' => isset($request->last_process[$i]) ? $request->last_process[$i] : '0',
                        'total' => isset($request->last_output[$i]) ? round((round(1/$request->last_output[$i],4))*($request->last_process[$i]/100)+round(1/$request->last_output[$i],4),4) : '0',
                    );
                    $store = PlcPricingDetail::insert($dataArray);
                }
            }
            if($request->p_item_code[0] != null){
                $count1 = count($request->p_item_code);
                for($i=0; $i<$count1; $i++){
                    $dataArray = array(
                        'costing_id' => $costing_id,
                        'material' => "packing",
                        'item_code' => $request->p_item_code[$i] ? $request->p_item_code[$i] : '-',
                        'description' => $request->p_description[$i] ? ucwords($request->p_description[$i]) : '-',
                        'uom' => isset($request->p_uom[$i]) ? $request->p_uom[$i] : '-',
                        'division' => isset($request->p_division[$i]) ? $request->p_division[$i] : '-',
                        'subdivision' => isset($request->p_subdivision[$i]) ? $request->p_subdivision[$i] : '-',
                        'output' => isset($request->p_output[$i]) ? $request->p_output[$i] : '0',
                        'cut_code' => isset($request->p_cut_code[$i]) ? $request->p_cut_code[$i] : '0',                        
                        'fac_qty' => isset($request->p_output[$i]) ? round(1/$request->p_output[$i],4) : '0',
                        'total_qty' => isset($request->p_qty[$i]) ? $request->p_qty[$i] : '0',
                        'process' => isset($request->p_process[$i]) ? $request->p_process[$i] : '0',
                        'total' => isset($request->p_output[$i]) ? round((round(1/$request->p_output[$i],4))*($request->p_process[$i]/100)+round(1/$request->p_output[$i],4),4) : '0',
                    );
                    $store = PlcPricingDetail::insert($dataArray);
                }
            }
            $notification = array(
                'message' => 'Pricing Sheet Created',
                'alert-type' => 'success'
            );
            return redirect()->route('pricing-sheet-table')->with($notification);
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

            //Overhead
            $cuttingDataF = []; $StitchingDataF = []; $LaminationDataF = []; $ClosingDataF = []; $LastingDataF = []; $PackingDataF = [];
            $data12 = DB::table('plc_pricings')->where('id', $id)->get();
            $overhead_id = $data12[0]->overhead_id;
            $DateTime = $data12[0]->created_at;
            $DateTime = explode(' ', $DateTime);
            $data1 = DB::table('plc_pricing_overheads')->where('costing_id', $id)->get();
            $data2 = DB::table('plc_pricing_resources')->where('costing_id', $id)->get();
            $data3 = DB::table('plc_pricing_details')->where('costing_id', $id)->get();
            $data4 = DB::table('plc_manuals')->where('costing_id', $id)->pluck('manual');
            $formulaData = PlcFormula::orderBy('id','DESC')->where('p_id', $id)->get();
            foreach($formulaData as $value){
                if($value->dep == "Cutting"){
                    $cuttingDataF[] = $value;
                }
                elseif($value->dep == "Stitching"){
                    $StitchingDataF[] = $value;
                }
                elseif($value->dep == "Lamination"){
                    $LaminationDataF[] = $value;
                }
                elseif($value->dep == "Closing"){
                    $ClosingDataF[] = $value;
                }
                elseif($value->dep == "Lasting"){
                    $LastingDataF[] = $value;
                }
                elseif($value->dep == "Packing"){
                    $PackingDataF[] = $value;
                }
            }

            //Calculation
            $dloh1_total = 0; $idloh1_total = 0; $idloh2_total = 0; $t_oh1_total = 0; $dloh2_total = 0; $idloh3_total = 0; $dloh3_total = 0; $t_oh2_total = 0; $un_a_oh_total = 0;
            if(!$cuttingDataF){
                $dloh1_cut = 0; $idloh1_cut = 0; $idloh2_cut = 0; $t_oh1_cut = 0; $dloh2_cut = 0; $idloh3_cut = 0; $dloh3_cut = 0; $t_oh2_cut = 0; $un_a_oh_cut = 0;
            }
            else{
                foreach($cuttingDataF as $value){
                    $dloh1_cut = $value['dloh1'];
                    $idloh1_cut = $value['idloh1'];
                    $idloh2_cut = $value['idloh2'];
                    $t_oh1_cut = $value['t_oh1'];
                    $dloh2_cut = $value['dloh2'];
                    $idloh3_cut = $value['idloh3'];
                    $dloh3_cut = $value['dloh3'];
                    $t_oh2_cut = $value['t_oh2'];
                    $un_a_oh_cut = $value['un_a_oh'];
                }
            }
            if(!$StitchingDataF){
                $dloh1_sti = 0; $idloh1_sti = 0; $idloh2_sti = 0; $t_oh1_sti = 0; $dloh2_sti = 0; $idloh3_sti = 0; $dloh3_sti = 0; $t_oh2_sti = 0; $un_a_oh_sti = 0;
            }
            else{
                foreach($StitchingDataF as $value){
                    $dloh1_sti = $value['dloh1'];
                    $idloh1_sti = $value['idloh1'];
                    $idloh2_sti = $value['idloh2'];
                    $t_oh1_sti = $value['t_oh1'];
                    $dloh2_sti = $value['dloh2'];
                    $idloh3_sti = $value['idloh3'];
                    $dloh3_sti = $value['dloh3'];
                    $t_oh2_sti = $value['t_oh2'];
                    $un_a_oh_sti = $value['un_a_oh'];
                }
            }
            if(!$LaminationDataF){
                $dloh1_lam = 0; $idloh1_lam = 0; $idloh2_lam = 0; $t_oh1_lam = 0; $dloh2_lam = 0; $idloh3_lam = 0; $dloh3_lam = 0; $t_oh2_lam = 0; $un_a_oh_lam = 0;
            }
            else{
                foreach($LaminationDataF as $value){
                    $dloh1_lam = $value['dloh1'];
                    $idloh1_lam = $value['idloh1'];
                    $idloh2_lam = $value['idloh2'];
                    $t_oh1_lam = $value['t_oh1'];
                    $dloh2_lam = $value['dloh2'];
                    $idloh3_lam = $value['idloh3'];
                    $dloh3_lam = $value['dloh3'];
                    $t_oh2_lam = $value['t_oh2'];
                    $un_a_oh_lam = $value['un_a_oh'];
                }
            }
            if(!$ClosingDataF){
                $dloh1_clo = 0; $idloh1_clo = 0; $idloh2_clo = 0; $t_oh1_clo = 0; $dloh2_clo = 0; $idloh3_clo = 0; $dloh3_clo = 0; $t_oh2_clo = 0; $un_a_oh_clo = 0;
            }
            else{
                foreach($ClosingDataF as $value){
                    $dloh1_clo = $value['dloh1'];
                    $idloh1_clo = $value['idloh1'];
                    $idloh2_clo = $value['idloh2'];
                    $t_oh1_clo = $value['t_oh1'];
                    $dloh2_clo = $value['dloh2'];
                    $idloh3_clo = $value['idloh3'];
                    $dloh3_clo = $value['dloh3'];
                    $t_oh2_clo = $value['t_oh2'];
                    $un_a_oh_clo = $value['un_a_oh'];
                }
            }
            if(!$LastingDataF){
                $dloh1_last = 0; $idloh1_last = 0; $idloh2_last = 0; $t_oh1_last = 0; $dloh2_last = 0; $idloh3_last = 0; $dloh3_last = 0; $t_oh2_last = 0; $un_a_oh_last = 0;
            }
            else{
                foreach($LastingDataF as $value){
                    $dloh1_last = $value['dloh1'];
                    $idloh1_last = $value['idloh1'];
                    $idloh2_last = $value['idloh2'];
                    $t_oh1_last = $value['t_oh1'];
                    $dloh2_last = $value['dloh2'];
                    $idloh3_last = $value['idloh3'];
                    $dloh3_last = $value['dloh3'];
                    $t_oh2_last = $value['t_oh2'];
                    $un_a_oh_last = $value['un_a_oh'];
                }
            }
            if(!$PackingDataF){
                $dloh1_p = 0; $idloh1_p = 0; $idloh2_p = 0; $t_oh1_p = 0; $dloh2_p = 0; $idloh3_p = 0; $dloh3_p = 0; $t_oh2_p = 0; $un_a_oh_p = 0;
            }
            else{
                foreach($PackingDataF as $value){
                    $dloh1_p = $value['dloh1'];
                    $idloh1_p = $value['idloh1'];
                    $idloh2_p = $value['idloh2'];
                    $t_oh1_p = $value['t_oh1'];
                    $dloh2_p = $value['dloh2'];
                    $idloh3_p = $value['idloh3'];
                    $dloh3_p = $value['dloh3'];
                    $t_oh2_p = $value['t_oh2'];
                    $un_a_oh_p = $value['un_a_oh'];
                }
            }

            $dloh1_total = $dloh1_cut + $dloh1_sti + $dloh1_lam + $dloh1_clo + $dloh1_last + $dloh1_p;
            $idloh1_total = $idloh1_cut + $idloh1_sti + $idloh1_lam + $idloh1_clo + $idloh1_last + $idloh1_p;
            $idloh2_total = $idloh2_cut + $idloh2_sti + $idloh2_lam + $idloh2_clo + $idloh2_last + $idloh2_p;
            $t_oh1_total = $t_oh1_cut + $t_oh1_sti + $t_oh1_lam + $t_oh1_clo + $t_oh1_last + $t_oh1_p;
            $dloh2_total = $dloh2_cut + $dloh2_sti + $dloh2_lam + $dloh2_clo + $dloh2_last + $dloh2_p;
            $idloh3_total = $idloh3_cut + $idloh3_sti + $idloh3_lam + $idloh3_clo + $idloh3_last + $idloh3_p;
            $dloh3_total = $dloh3_cut + $dloh3_sti + $dloh3_lam + $dloh3_clo + $dloh3_last + $dloh3_p;
            $t_oh2_total = $t_oh2_cut + $t_oh2_sti + $t_oh2_lam + $t_oh2_clo + $t_oh2_last + $t_oh2_p;
            $un_a_oh_total = $un_a_oh_cut + $un_a_oh_sti + $un_a_oh_lam + $un_a_oh_clo + $un_a_oh_last + $un_a_oh_p;

            $AllData = [ 
                'dloh1_total' => $dloh1_total,
                'idloh1_total' => $idloh1_total,
                'idloh2_total' => $idloh2_total,
                't_oh1_total' => $t_oh1_total,
                'dloh2_total' => $dloh2_total,
                'idloh3_total' => $idloh3_total,
                'dloh3_total' => $dloh3_total,
                't_oh2_total' => $t_oh2_total,
                'un_a_oh_total' => $un_a_oh_total,
            ];

            foreach($data3 as $value){
                if($value->material == "cutting"){
                    $result1 = Division::orderBy('id','DESC')->where('id',$value->division)->get();
                    $cuttingData[] = array(
                        'value' => $value,
                        'result' => $result1[0]['description'],
                    );
                }
                elseif($value->material == "insole"){
                    $result2 = Division::orderBy('id','DESC')->where('id',$value->division)->get();
                    $InsoleData[] = array(
                        'value' => $value,
                        'result' => $result2[0]['description'],
                    );
                }
                elseif($value->material == "lamination"){
                    $result = Division::orderBy('id','DESC')->where('id',$value->division)->get();
                    $LaminationData[] = array(
                        'value' => $value,
                        'result' => $result[0]['description'],
                    );
                }
                elseif($value->material == "closing"){
                    $result = Division::orderBy('id','DESC')->where('id',$value->division)->get();
                    $ClosingData[] = array(
                        'value' => $value,
                        'result' => $result[0]['description'],
                    );
                }
                elseif($value->material == "lasting"){
                    $result = Division::orderBy('id','DESC')->where('id',$value->division)->get();
                    $LastingData[] = array(
                        'value' => $value,
                        'result' => $result[0]['description'],
                    );
                }
                elseif($value->material == "packing"){
                    $result = Division::orderBy('id','DESC')->where('id',$value->division)->get();
                    $PackingData[] = array(
                        'value' => $value,
                        'result' => $result[0]['description'],
                    );
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
                    $CutTotalValue = $CutTotalValue + $value['value']->value;
                    $CutTotalRate = $CutTotalRate + $value['value']->rate;
                    $CutTotalQty = $CutTotalQty + $value['value']->total_qty;
                    $CutTotalFac = $CutTotalFac + $value['value']->fac_qty;
                    $CutTotal = $CutTotal + $value['value']->total;
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
                    $ITotalValue = $ITotalValue + $value['value']->value;
                    $ITotalRate = $ITotalRate + $value['value']->rate;
                    $ITotalQty = $ITotalQty + $value['value']->total_qty;
                    $ITotalFac = $ITotalFac + $value['value']->fac_qty;
                    $ITotal = $ITotal + $value['value']->total;
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
                    $LamTotalValue = $LamTotalValue + $value['value']->value;
                    $LamTotalRate = $LamTotalRate + $value['value']->rate;
                    $LamTotalQty = $LamTotalQty + $value['value']->total_qty;
                    $LamTotalFac = $LamTotalFac + $value['value']->fac_qty;
                    $LamTotal = $LamTotal + $value['value']->total;
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
                    $CloTotalValue = $CloTotalValue + $value['value']->value;
                    $CloTotalRate = $CloTotalRate + $value['value']->rate;
                    $CloTotalQty = $CloTotalQty + $value['value']->total_qty;
                    $CloTotalFac = $CloTotalFac + $value['value']->fac_qty;
                    $CloTotal = $CloTotal + $value['value']->total;
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
                    $LastTotalValue = $LastTotalValue + $value['value']->value;
                    $LastTotalRate = $LastTotalRate + $value['value']->rate;
                    $LastTotalQty = $LastTotalQty + $value['value']->total_qty;
                    $LastTotalFac = $LastTotalFac + $value['value']->fac_qty;
                    $LastTotal = $LastTotal + $value['value']->total;
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
                    $PTotalValue = $PTotalValue + $value['value']->value;
                    $PTotalRate = $PTotalRate + $value['value']->rate;
                    $PTotalQty = $PTotalQty + $value['value']->total_qty;
                    $PTotalFac = $PTotalFac + $value['value']->fac_qty;
                    $PTotal =  $PTotal + $value['value']->total;
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
                'data1'=> $data12[0], 'i'=> 1,'j'=> 1,'k'=> 1,'l'=> 1,'m'=> 1,'n'=> 1,'date' => $DateTime[0],
                'cuttingData' => $cuttingData, 'InsoleData' => $InsoleData, 'LaminationData' => $LaminationData, 'ClosingData' => $ClosingData, 
                'LastingData' => $LastingData,'PackingData' => $PackingData,
                'cuttingData_o' => $cuttingData_o,'InsoleData_o' => $InsoleData_o,'LaminationData_o' => $LaminationData_o,'ClosingData_o' => $ClosingData_o,
                'LastingData_o' => $LastingData_o, 'PackingData_o'=> $PackingData_o,
                'cuttingData_r' => $cuttingData_r, 'InsoleData_r' => $InsoleData_r, 'LaminationData_r' => $LaminationData_r, 'ClosingData_r' => $ClosingData_r,
                'LastingData_r' => $LastingData_r, 'PackingData_r' => $PackingData_r,
            ];    
    
            return view('pricingsheet.pricing-sheet-display')->with([            
                'data1' => $data12[0], 'i' => 1,'j' => 1,'k' => 1,'l' => 1,'m' => 1,'n' => 1, 'date' => $DateTime[0], 'manual' => $data4,
                'cuttingData' => $cuttingData, 'InsoleData' => $InsoleData, 'LaminationData' => $LaminationData, 'ClosingData' => $ClosingData, 
                'LastingData'=> $LastingData, 'PackingData' => $PackingData,
                'cuttingDataF' => $cuttingDataF, 'StitchingDataF' => $StitchingDataF, 'LaminationDataF' => $LaminationDataF, 'ClosingDataF' => $ClosingDataF, 
                'LastingDataF' => $LastingDataF, 'PackingDataF' => $PackingDataF,
                'cuttingData_o' => $cuttingData_o, 'InsoleData_o' => $InsoleData_o, 'LaminationData_o' => $LaminationData_o, 'ClosingData_o' => $ClosingData_o, 
                'LastingData_o' => $LastingData_o, 'PackingData_o' => $PackingData_o,
                'cuttingData_r' => $cuttingData_r, 'InsoleData_r' => $InsoleData_r, 'LaminationData_r' => $LaminationData_r, 'ClosingData_r' => $ClosingData_r,
                'LastingData_r' => $LastingData_r, 'PackingData_r' => $PackingData_r,
                'DataCutting' => $DataCutting, 'DataInsole' => $DataInsole, 'DataLamination' => $DataLamination, 'DataClosing' => $DataClosing, 'DataLasting' => $DataLasting, 'DataPacking' => $DataPacking, 
                'DataCutting_o' => $DataCutting_o, 'DataInsole_o' => $DataInsole_o, 'DataLamination_o' => $DataLamination_o, 'DataClosing_o' => $DataClosing_o, 'DataLasting_o' => $DataLasting_o, 'DataPacking_o' => $DataPacking_o,
                'DataCutting_r' => $DataCutting_r, 'DataInsole_r' => $DataInsole_r, 'DataLamination_r' => $DataLamination_r, 'DataClosing_r' => $DataClosing_r, 'DataLasting_r' => $DataLasting_r, 'DataPacking_r' => $DataPacking_r, 
                'AllData' => $AllData
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

            $M1 = 0; $M2 = 0; $M3 = 0; $M4 = 0; $M5 = 0; $M6 = 0;
            $O1 = 0; $O2 = 0; $O3 = 0; $O4 = 0; $O5 = 0; $O6 = 0;
            $R1 = 0; $R2 = 0; $R3 = 0; $R4 = 0; $R5 = 0; $R6 = 0;

            $data1 = DB::table('plc_pricings')->where('id', $id)->get();
            $DateTime = $data1[0]->created_at;
            $DateTime = explode(' ', $DateTime);
            $data2 = DB::table('plc_pricing_details')->where('costing_id', $id)->get();
            $data3 = DB::table('plc_pricing_overheads')->where('costing_id', $id)->get();
            $data4 = DB::table('plc_pricing_resources')->where('costing_id', $id)->get();
            $data5 = DB::table('plc_manuals')->where('costing_id', $id)->pluck('manual');
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
                $M1 = $DataCutting['Value'];
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
                $M2 = $DataInsole['Value'];
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
                $M3 = $DataLamination['Value'];
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
                $M4 = $DataClosing['Value'];
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
                $M5 = $DataLasting['Value'];
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
                $M6 = $DataPacking['Value'];
            }

            $sum = 0;
            $MaterialCost = $sum + $M1 + $M2 + $M3 + $M4 + $M5 + $M6;

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
                $O1 = $DataCutting_o['Pair'];
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
                $O2 = $DataInsole_o['Pair'];
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
                $O3 = $DataLamination_o['Pair'];
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
                $O4 = $DataClosing_o['Pair'];
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
                $O5 = $DataLasting_o['Pair'];                
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
                $O6 = $DataPacking_o['Pair'];                
            }

            $sum1 = 0;
            
            //Calculation
            $cuttingDataO = []; $StitchingDataO = []; $LaminationDataO = []; $ClosingDataO = []; $LastingDataO = []; $PackingDataO = [];
            $OverheadId = $data1[0]->overhead_id;
            $dataOverhead = PlcFormula::orderBy('id','ASC')->where('oh_id', $OverheadId)->get();
            foreach($dataOverhead as $value){
                if($value->dep == "Cutting"){
                    $cuttingDataO[] = $value;
                }
                elseif($value->dep == "Stitching"){
                    $StitchingDataO[] = $value;
                }
                elseif($value->dep == "Lamination"){
                    $LaminationDataO[] = $value;
                }
                elseif($value->dep == "Closing"){
                    $ClosingDataO[] = $value;
                }
                elseif($value->dep == "Lasting"){
                    $LastingDataO[] = $value;
                }
                elseif($value->dep == "Packing"){
                    $PackingDataO[] = $value;
                }
            }
            $t_oh1_total = 0; $un_a_oh_total = 0;
            if(!$cuttingDataO){
                $t_oh1_cut = 0; $un_a_oh_cut = 0;
            }
            else{
                foreach($cuttingDataO as $value){
                    $t_oh1_cut = $value['t_oh1'];
                    $un_a_oh_cut = $value['un_a_oh'];
                }
            }
            if(!$StitchingDataO){
               $t_oh1_sti = 0; $un_a_oh_sti = 0;
            }
            else{
                foreach($StitchingDataO as $value){
                    $t_oh1_sti = $value['t_oh1'];
                    $un_a_oh_sti = $value['un_a_oh'];
                }
            }
            if(!$LaminationDataO){
                $t_oh1_lam = 0; $un_a_oh_lam = 0;
            }
            else{
                foreach($LaminationDataO as $value){
                    $t_oh1_lam = $value['t_oh1'];
                    $un_a_oh_lam = $value['un_a_oh'];
                }
            }
            if(!$ClosingDataO){
                $t_oh1_clo = 0; $un_a_oh_clo = 0;
            }
            else{
                foreach($ClosingDataO as $value){
                    $t_oh1_clo = $value['t_oh1'];
                    $un_a_oh_clo = $value['un_a_oh'];
                }
            }
            if(!$LastingDataO){
                $t_oh1_last = 0; $un_a_oh_last = 0;
            }
            else{
                foreach($LastingDataO as $value){
                    $t_oh1_last = $value['t_oh1'];
                    $un_a_oh_last = $value['un_a_oh'];
                }
            }
            if(!$PackingDataO){
                $t_oh1_p = 0; $un_a_oh_p = 0;
            }
            else{
                foreach($PackingDataO as $value){
                    $t_oh1_p = $value['t_oh1'];
                    $un_a_oh_p = $value['un_a_oh'];
                }
            }

            $t_oh1_total = $t_oh1_cut + $t_oh1_sti + $t_oh1_lam + $t_oh1_clo + $t_oh1_last + $t_oh1_p;
            $un_a_oh_total = $un_a_oh_cut + $un_a_oh_sti + $un_a_oh_lam + $un_a_oh_clo + $un_a_oh_last + $un_a_oh_p;

            $AllData = [ 
                't_oh1_total' => $t_oh1_total,
                'un_a_oh_total' => $un_a_oh_total,
            ];
            
            $OverheadCost = $sum1 + $O1 + $O2 + $O3 + $O4 + $O5 + $O6;
            $totalOverhead = [];
            if(count($dataOverhead)<0){
            }
            else{
                $totalOverhead = 100 + $AllData['t_oh1_total'] + $AllData['un_a_oh_total'];
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
                $R1 = $DataCutting_r['Pair'];  
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
                $R2 = $DataInsole_r['Pair'];  
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
                $R3 = $DataLamination_r['Pair'];  
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
                $R4 = $DataClosing_r['Pair'];  
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
                $R5 = $DataLasting_r['Pair'];  
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
                $R6 = $DataPacking_r['Pair'];  
            }

            $sum2 = 0;
            $ResourcesCost = $sum2 + $R1 + $R2 + $R3 + $R4 + $R5 + $R6;
            $TotalCost = $ResourcesCost + $totalOverhead + $MaterialCost;
            $TotalCost1 = $M1 + $M2 + $M3 + $M4 + $M5 + $M6;

            $data = [
                'i'=> 1, 'j'=> 1, 'k'=> 1, 'l'=> 1, 'm'=> 1,'n'=> 1,
                'data1'=> $data1[0], 'date' => $DateTime[0],
                'CuttingData'=> $CuttingData, 'LaminationData'=> $LaminationData, 'InsoleData'=> $InsoleData, 'ClosingData'=> $ClosingData, 'LastingData'=> $LastingData, 
                'PackingData'=> $PackingData,
            ];    
    
            return view('pricingsheet.pricing-sheet-pdf')->with([
                'j'=> 1, 'i'=> 1, 'k'=> 1, 'l'=> 1, 'm'=> 1,'n'=> 1, 'manual' => $data5,
                'data1'=> $data1[0], 'date' => $DateTime[0], 'MaterialCost' => $MaterialCost, 'OverheadCost' => $OverheadCost, 'ResourcesCost' => $ResourcesCost, 'TotalCost' => $TotalCost, 'TotalCost1' => $TotalCost1,
                'CuttingData'=> $CuttingData, 'LaminationData'=> $LaminationData, 'InsoleData'=> $InsoleData, 'ClosingData'=> $ClosingData, 'LastingData'=> $LastingData, 'PackingData'=> $PackingData,
                'CuttingData_r'=> $CuttingData_r, 'LaminationData_r'=> $LaminationData_r, 'InsoleData_r'=> $InsoleData_r, 'ClosingData_r'=> $ClosingData_r, 'LastingData_r'=> $LastingData_r, 'PackingData_r'=> $PackingData_r,
                'CuttingData_o'=> $CuttingData_o, 'LaminationData_o'=> $LaminationData_o, 'InsoleData_o'=> $InsoleData_o, 'ClosingData_o'=> $ClosingData_o, 'LastingData_o'=> $LastingData_o, 'PackingData_o'=> $PackingData_o,
                'DataCutting' => $DataCutting, 'DataInsole' => $DataInsole, 'DataLamination' => $DataLamination, 'DataClosing' => $DataClosing, 'DataLasting' => $DataLasting, 'DataPacking' => $DataPacking,
                'DataCutting_o' => $DataCutting_o, 'DataInsole_o' => $DataInsole_o, 'DataLamination_o' => $DataLamination_o, 'DataClosing_o' => $DataClosing_o, 'DataLasting_o' => $DataLasting_o, 'DataPacking_o' => $DataPacking_o,
                'DataCutting_r' => $DataCutting_r, 'DataInsole_r' => $DataInsole_r, 'DataLamination_r' => $DataLamination_r, 'DataClosing_r' => $DataClosing_r, 'DataLasting_r' => $DataLasting_r, 'DataPacking_r' => $DataPacking_r, 
                'totalOverhead' => $totalOverhead
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
            $date = date('d F Y');
            $sessionImg = Session::get('image');
            $upper = 1; $linning = 2; $stiching = 3; $insole = 4; $outsole = 5; $socks  = 6; $general = 7;
            $costingImage = DB::table('plc_pricings')->where('id', $id)->pluck('image');
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
            $last = $request->last;
            $project = $request->project; 
            $product = $request->product; 
            $date = isset($request->date) ? $request->date : $date;
            $costingImage = DB::table('plc_pricings')->where('id', $id)->pluck('image');
            $data = array(
                'season' => $season, 'purpose' => $purpose, 'image' => $filename, 'category' => $category, 'date' => $date, 'shape' => $shape,
                'sole' => $sole, 'range_no' => $range_no, 'design_no' => $design_no, 'description' => $description, 'project' => $project, 'product' => $product, 'last' => $last,
            );
            $update = PlcPricing::where('id', $id)->update($data);
            if($update){
                $updatee = PlcPricingDetail::where('costing_id', $id)->pluck('id');
                if(isset($updatee[0]) == $id){
                    PlcPricingDetail::where('costing_id', $id)->delete();
                    PlcManual::where('costing_id', $id)->delete();
                }
                if($request->manualtext[0] != null){
                    $manualcount = count($request->manualtext);
                    for($i=0; $i<$manualcount; $i++){
                        $dataArray = array(
                            'costing_id' => $id,
                            'manual' => $request->manualtext[$i] ? $request->manualtext[$i] : '-',
                        );
                        $store = PlcManual::insert($dataArray);
                    }
                }
                if($request->cut_item_code[0] != null){
                    $count = count($request->cut_item_code);
                    for($i=0; $i<$count; $i++){
                        $dataArray = array(
                            'costing_id' => $id,
                            'material' => "cutting",
                            'item_code' => $request->cut_item_code[$i] ? $request->cut_item_code[$i] : '-',
                            'description' => $request->cut_description[$i] ? ucwords($request->cut_description[$i]) : '-',
                            'uom' => isset($request->cut_uom[$i]) ? $request->cut_uom[$i] : '-',
                            'division' => isset($request->cut_division[$i]) ? $request->cut_division[$i] : '-',
                            'subdivision' => isset($request->cut_subdivision[$i]) ? $request->cut_subdivision[$i] : '-',
                            'output' => isset($request->cut_output[$i]) ? $request->cut_output[$i] : '0',
                            'cut_code' => isset($request->cut_cut_code[$i]) ? $request->cut_cut_code[$i] : '0',
                            'fac_qty' => isset($request->cut_output[$i]) ? round(1/$request->cut_output[$i],4) : '0',
                            'total_qty' => isset($request->cut_qty[$i]) ? $request->cut_qty[$i] : '0',
                            'process' => isset($request->cut_process[$i]) ? $request->cut_process[$i] : '0',
                            'total' => isset($request->cut_output[$i]) ? round((round(1/$request->cut_output[$i],4))*($request->cut_process[$i]/100)+round(1/$request->cut_output[$i],4),4) : '0',
                        );
                        $store = PlcPricingDetail::insert($dataArray);
                    }
                }
                if($request->i_item_code[0] != null){
                    $count1 = count($request->i_item_code);
                    for($i=0; $i<$count1; $i++){
                        $dataArray = array(
                            'costing_id' => $id,
                            'material' => "insole",
                            'item_code' => $request->i_item_code[$i] ? $request->i_item_code[$i] : '-',
                            'description' => $request->i_description[$i] ? ucwords($request->i_description[$i]) : '-',
                            'uom' => isset($request->i_uom[$i]) ? $request->i_uom[$i] : '-',
                            'division' => isset($request->i_division[$i]) ? $request->i_division[$i] : '-',
                            'subdivision' => isset($request->i_subdivision[$i]) ? $request->i_subdivision[$i] : '-',
                            'output' => isset($request->i_output[$i]) ? $request->i_output[$i] : '0',
                            'cut_code' => isset($request->i_cut_code[$i]) ? $request->i_cut_code[$i] : '0',
                            'fac_qty' => isset($request->i_output[$i]) ? round(1/$request->i_output[$i],4) : '0',
                            'total_qty' => isset($request->i_qty[$i]) ? $request->i_qty[$i] : '0',
                            'process' => isset($request->i_process[$i]) ? $request->i_process[$i] : '0',
                            'total' => isset($request->i_output[$i]) ? round((round(1/$request->i_output[$i],4))*($request->i_process[$i]/100)+round(1/$request->i_output[$i],4),4) : '0',
                        );
                        $store = PlcPricingDetail::insert($dataArray);
                    }
                }
                if($request->lam_item_code[0] != null){
                    $count1 = count($request->lam_item_code);
                    for($i=0; $i<$count1; $i++){
                        $dataArray = array(
                            'costing_id' => $id,
                            'material' => "lamination",
                            'item_code' => $request->lam_item_code[$i] ? $request->lam_item_code[$i] : '-',
                            'description' => $request->lam_description[$i] ? ucwords($request->lam_description[$i]) : '-',
                            'uom' => isset($request->lam_uom[$i]) ? $request->lam_uom[$i] : '-',
                            'division' => isset($request->lam_division[$i]) ? $request->lam_division[$i] : '-',
                            'subdivision' => isset($request->lam_subdivision[$i]) ? $request->lam_subdivision[$i] : '-',
                            'output' => isset($request->lam_output[$i]) ? $request->lam_output[$i] : '0',
                            'cut_code' => isset($request->lam_cut_code[$i]) ? $request->lam_cut_code[$i] : '0',
                            'fac_qty' => isset($request->lam_output[$i]) ? round(1/$request->lam_output[$i],4) : '0',
                            'total_qty' => isset($request->lam_qty[$i]) ? $request->lam_qty[$i] : '0',
                            'process' => isset($request->lam_process[$i]) ? $request->lam_process[$i] : '0',
                            'total' => isset($request->lam_output[$i]) ? round((round(1/$request->lam_output[$i],4))*($request->lam_process[$i]/100)+round(1/$request->lam_output[$i],4),4) : '0',
                        );
                        $store = PlcPricingDetail::insert($dataArray);
                    }
                }
                if($request->clo_item_code[0] != null){
                    $count1 = count($request->clo_item_code);
                    for($i=0; $i<$count1; $i++){
                        $dataArray = array(
                            'costing_id' => $id,
                            'material' => "closing",
                            'item_code' => $request->clo_item_code[$i] ? $request->clo_item_code[$i] : '-',
                            'description' => $request->clo_description[$i] ? ucwords($request->clo_description[$i]) : '-',
                            'uom' => isset($request->clo_uom[$i]) ? $request->clo_uom[$i] : '-',
                            'division' => isset($request->clo_division[$i]) ? $request->clo_division[$i] : '-',
                            'subdivision' => isset($request->clo_subdivision[$i]) ? $request->clo_subdivision[$i] : '-',
                            'output' => isset($request->clo_output[$i]) ? $request->clo_output[$i] : '0',
                            'cut_code' => isset($request->clo_cut_code[$i]) ? $request->clo_cut_code[$i] : '0',
                            'fac_qty' => isset($request->clo_output[$i]) ? round(1/$request->clo_output[$i],4) : '0',
                            'total_qty' => isset($request->clo_qty[$i]) ? $request->clo_qty[$i] : '0',
                            'process' => isset($request->clo_process[$i]) ? $request->clo_process[$i] : '0',
                            'total' => isset($request->clo_output[$i]) ? round((round(1/$request->clo_output[$i],4))*($request->clo_process[$i]/100)+round(1/$request->clo_output[$i],4),4) : '0',
                        );
                        $store = PlcPricingDetail::insert($dataArray);
                    }
                }
                if($request->last_item_code[0] != null){
                    $count1 = count($request->last_item_code);
                    for($i=0; $i<$count1; $i++){
                        $dataArray = array(
                            'costing_id' => $id,
                            'material' => "lasting",
                            'item_code' => $request->last_item_code[$i] ? $request->last_item_code[$i] : '-',
                            'description' => $request->last_description[$i] ? ucwords($request->last_description[$i]) : '-',
                            'uom' => isset($request->last_uom[$i]) ? $request->last_uom[$i] : '-',
                            'division' => isset($request->last_division[$i]) ? $request->last_division[$i] : '-',
                            'subdivision' => isset($request->last_subdivision[$i]) ? $request->last_subdivision[$i] : '-',
                            'output' => isset($request->last_output[$i]) ? $request->last_output[$i] : '0',
                            'cut_code' => isset($request->last_cut_code[$i]) ? $request->last_cut_code[$i] : '0',
                            'fac_qty' => isset($request->last_output[$i]) ? round(1/$request->last_output[$i],4) : '0',
                            'total_qty' => isset($request->last_qty[$i]) ? $request->last_qty[$i] : '0',
                            'process' => isset($request->last_process[$i]) ? $request->last_process[$i] : '0',
                            'total' => isset($request->last_output[$i]) ? round((round(1/$request->last_output[$i],4))*($request->last_process[$i]/100)+round(1/$request->last_output[$i],4),4) : '0',
                        );
                        $store = PlcPricingDetail::insert($dataArray);
                    }
                }
                if($request->p_item_code[0] != null){
                    $count1 = count($request->p_item_code);
                    for($i=0; $i<$count1; $i++){
                        $dataArray = array(
                            'costing_id' => $id,
                            'material' => "packing",
                            'item_code' => $request->p_item_code[$i] ? $request->p_item_code[$i] : '-',
                            'description' => $request->p_description[$i] ? ucwords($request->p_description[$i]) : '-',
                            'uom' => isset($request->p_uom[$i]) ? $request->p_uom[$i] : '-',
                            'division' => isset($request->p_division[$i]) ? $request->p_division[$i] : '-',
                            'subdivision' => isset($request->p_subdivision[$i]) ? $request->p_subdivision[$i] : '-',
                            'output' => isset($request->p_output[$i]) ? $request->p_output[$i] : '0',
                            'cut_code' => isset($request->p_cut_code[$i]) ? $request->p_cut_code[$i] : '0',
                            'fac_qty' => isset($request->p_output[$i]) ? round(1/$request->p_output[$i],4) : '0',
                            'total_qty' => isset($request->p_qty[$i]) ? $request->p_qty[$i] : '0',
                            'process' => isset($request->p_process[$i]) ? $request->p_process[$i] : '0',
                            'total' => isset($request->p_output[$i]) ? round((round(1/$request->p_output[$i],4))*($request->p_process[$i]/100)+round(1/$request->p_output[$i],4),4) : '0',
                        );
                        $store = PlcPricingDetail::insert($dataArray);
                    }
                }
                $notification = array(
                    'message' => 'Pricing Sheet Updated',
                    'alert-type' => 'success'
                );
                return redirect()->route('pricing-sheet-table')->with($notification);
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
            DB::table('plc_pricings')->where('id', $id)->update(['progress' => 50]);
            if(isset($request->cut_item_code[0]) != null){
                $start = 0;
                foreach($request->cut_id as $dataId){
                    $dataArray = array(
                        'rate' => isset($request->cut_rate[$start]) ? $request->cut_rate[$start] : '0',
                        'value' => $request->cut_rate[$start] * $request->cut_total_con[$start],
                    );
                    $start++;
                    $updatedata = DB::table('plc_pricing_details')->where('id', $dataId)->update($dataArray);
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
                    $updatedata = DB::table('plc_pricing_details')->where('id', $dataId)->update($dataArray);
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
                    $updatedata = DB::table('plc_pricing_details')->where('id', $dataId)->update($dataArray);
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
                    $updatedata = DB::table('plc_pricing_details')->where('id', $dataId)->update($dataArray);
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
                    $updatedata = DB::table('plc_pricing_details')->where('id', $dataId)->update($dataArray);
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
                    $updatedata = DB::table('plc_pricing_details')->where('id', $dataId)->update($dataArray);
                }
            }
            $notification = array(
                'message' => 'Pricing Sheet Updated',
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
                    $updatedata = DB::table('plc_pricing_details')->where('id', $dataId)->update($dataArray);
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
                    $updatedata = DB::table('plc_pricing_details')->where('id', $dataId)->update($dataArray);
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
                    $updatedata = DB::table('plc_pricing_details')->where('id', $dataId)->update($dataArray);
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
                    $updatedata = DB::table('plc_pricing_details')->where('id', $dataId)->update($dataArray);
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
                    $updatedata = DB::table('plc_pricing_details')->where('id', $dataId)->update($dataArray);
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
                    $updatedata = DB::table('plc_pricing_details')->where('id', $dataId)->update($dataArray);
                }
            }
            $notification = array(
                'message' => 'Pricing Sheet Updated',
                'alert-type' => 'success'
            );
            return redirect()->route('pricing-sheet-table')->with($notification);
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
            $fetch = DB::table('plc_pricings')->where('id', $id)->get();
            if($fetch[0]->progress != 80 && $fetch[0]->progress != 100){
                DB::table('plc_pricings')->where('id', $id)->update(['progress' => 60]);
            }
            PlcPricingResource::where('costing_id', $id)->delete();
            if($request->cut_value_r[0] != null){
                $count = count($request->cut_value_r);
                for($i=0; $i<$count; $i++){
                    $dataArray = array(
                        'costing_id' => $id,
                        'material' => "cutting",
                        'value_set' => $request->cut_value_r[$i] ? $request->cut_value_r[$i] : '-',
                        'description' => $request->cut_description_r[$i] ? ucwords($request->cut_description_r[$i]) : '-',
                        'remarks' => isset($request->cut_remarks_r[$i]) ? $request->cut_remarks_r[$i] : '-',
                        'pair' => isset($request->cut_rate_r[$i]) ? $request->cut_rate_r[$i] : '0',
                    );
                    $store = PlcPricingResource::insert($dataArray);
                }
            }
            if($request->i_value_r[0] != null){
                $count = count($request->i_value_r);
                for($i=0; $i<$count; $i++){
                    $dataArray = array(
                        'costing_id' => $id,
                        'material' => "insole",
                        'value_set' => $request->i_value_r[$i] ? $request->i_value_r[$i] : '-',
                        'description' => $request->i_description_r[$i] ? ucwords($request->i_description_r[$i]) : '-',
                        'remarks' => isset($request->i_remarks_r[$i]) ? $request->i_remarks_r[$i] : '-',
                        'pair' => isset($request->i_rate_r[$i]) ? $request->i_rate_r[$i] : '0',
                    );
                    $store = PlcPricingResource::insert($dataArray);
                }
            }
            if($request->lam_value_r[0] != null){
                $count = count($request->lam_value_r);
                for($i=0; $i<$count; $i++){
                    $dataArray = array(
                        'costing_id' => $id,
                        'material' => "lamination",
                        'value_set' => $request->lam_value_r[$i] ? $request->lam_value_r[$i] : '-',
                        'description' => $request->lam_description_r[$i] ? ucwords($request->lam_description_r[$i]) : '-',
                        'remarks' => isset($request->lam_remarks_r[$i]) ? $request->lam_remarks_r[$i] : '-',
                        'pair' => isset($request->lam_rate_r[$i]) ? $request->lam_rate_r[$i] : '0',
                    );
                    $store = PlcPricingResource::insert($dataArray);
                }
            }
            if($request->clo_value_r[0] != null){
                $count = count($request->clo_value_r);
                for($i=0; $i<$count; $i++){
                    $dataArray = array(
                        'costing_id' => $id,
                        'material' => "closing",
                        'value_set' => $request->clo_value_r[$i] ? $request->clo_value_r[$i] : '-',
                        'description' => $request->clo_description_r[$i] ? ucwords($request->clo_description_r[$i]) : '-',
                        'remarks' => isset($request->clo_remarks_r[$i]) ? $request->clo_remarks_r[$i] : '-',
                        'pair' => isset($request->clo_rate_r[$i]) ? $request->clo_rate_r[$i] : '0',
                    );
                    $store = PlcPricingResource::insert($dataArray);
                }
            }
            if($request->last_value_r[0] != null){
                $count = count($request->last_value_r);
                for($i=0; $i<$count; $i++){
                    $dataArray = array(
                        'costing_id' => $id,
                        'material' => "lasting",
                        'value_set' => $request->last_value_r[$i] ? $request->last_value_r[$i] : '-',
                        'description' => $request->last_description_r[$i] ? ucwords($request->last_description_r[$i]) : '-',
                        'remarks' => isset($request->last_remarks_r[$i]) ? $request->last_remarks_r[$i] : '-',
                        'pair' => isset($request->last_rate_r[$i]) ? $request->last_rate_r[$i] : '0',
                    );
                    $store = PlcPricingResource::insert($dataArray);
                }
            }
            if($request->p_value_r[0] != null){
                $count = count($request->p_value_r);
                for($i=0; $i<$count; $i++){
                    $dataArray = array(
                        'costing_id' => $id,
                        'material' => "packing",
                        'value_set' => $request->p_value_r[$i] ? $request->p_value_r[$i] : '-',
                        'description' => $request->p_description_r[$i] ? ucwords($request->p_description_r[$i]) : '-',
                        'remarks' => isset($request->p_remarks_r[$i]) ? $request->p_remarks_r[$i] : '-',
                        'pair' => isset($request->p_rate_r[$i]) ? $request->p_rate_r[$i] : '0',
                    );
                    $store = PlcPricingResource::insert($dataArray);
                }
            }
            $notification = array(
                'message' => 'Pricing Sheet Resources Updated',
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
            $overhead = $request->overhead;
            $fetch = DB::table('plc_pricings')->where('id', $id)->get();
            if($fetch[0]->progress != 80 && $fetch[0]->progress != 100){
                DB::table('plc_pricings')->where('id', $id)->update(['progress' => 80]);
            }
            $update = DB::table('plc_pricings')->where('id', $id)->update(['overhead_id' => $overhead]);
            if($update){
                $notification = array(
                    'message' => 'Pricing Sheet Overhead Updated',
                    'alert-type' => 'success'
                );
            }
            else{
                $notification = array(
                    'message' => 'Something went wrong!',
                    'alert-type' => 'no'
                );
            }
            return redirect()->route('pricing-sheet-table')->with($notification);
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
            $F_cuttingData = []; $F_StitchingData = []; $F_LaminationData = []; $F_ClosingData = []; $F_LastingData = []; $F_PackingData = [];
            $cuttingData_o = []; $InsoleData_o = []; $LaminationData_o = []; $ClosingData_o = []; $LastingData_o = []; $PackingData_o = [];
            $cuttingData_r = []; $InsoleData_r = []; $LaminationData_r = []; $ClosingData_r = []; $LastingData_r = []; $PackingData_r = [];
            $formulaData = PlcFormula::orderBy('id','DESC')->get()->unique('oh_id');
            $data = DB::table('plc_pricings')->where('id', $id)->get();

            $cuttingData = []; $StitchingData = []; $LaminationData = []; $ClosingData = []; $LastingData = []; $PackingData = [];
            $data = PlcFormula::orderBy('id','ASC')->where('oh_id', $id)->get();
            foreach($data as $value){
                if($value->dep == "Cutting"){
                    $F_cuttingData[] = $value;
                }
                elseif($value->dep == "Stitching"){
                    $F_StitchingData[] = $value;
                }
                elseif($value->dep == "Lamination"){
                    $F_LaminationData[] = $value;
                }
                elseif($value->dep == "Closing"){
                    $F_ClosingData[] = $value;
                }
                elseif($value->dep == "Lasting"){
                    $F_LastingData[] = $value;
                }
                elseif($value->dep == "Packing"){
                    $F_PackingData[] = $value;
                }
            }

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
            $overhead_id = $data[0]->overhead_id;
            $data1 = DB::table('plc_pricing_overheads')->where('costing_id', $id)->get();
            $data2 = DB::table('plc_pricing_resources')->where('costing_id', $id)->get();
            $data3 = DB::table('plc_pricing_details')->where('costing_id', $id)->get();
            foreach($data3 as $value){
                if($value->material == "cutting"){
                    $result1 = Division::orderBy('id','DESC')->where('id',$value->division)->get();
                    $cuttingData[] = array(
                        'value' => $value,
                        'result' => $result1[0]['description'],
                    );
                }
                elseif($value->material == "insole"){
                    $result1 = Division::orderBy('id','DESC')->where('id',$value->division)->get();
                    $InsoleData[] = array(
                        'value' => $value,
                        'result' => $result1[0]['description'],
                    );
                }
                elseif($value->material == "lamination"){
                    $result1 = Division::orderBy('id','DESC')->where('id',$value->division)->get();
                    $LaminationData[] = array(
                        'value' => $value,
                        'result' => $result1[0]['description'],
                    );
                }
                elseif($value->material == "closing"){
                    $result1 = Division::orderBy('id','DESC')->where('id',$value->division)->get();
                    $ClosingData[] = array(
                        'value' => $value,
                        'result' => $result1[0]['description'],
                    );
                }
                elseif($value->material == "lasting"){
                    $result1 = Division::orderBy('id','DESC')->where('id',$value->division)->get();
                    $LastingData[] = array(
                        'value' => $value,
                        'result' => $result1[0]['description'],
                    );
                }
                elseif($value->material == "packing"){
                    $result1 = Division::orderBy('id','DESC')->where('id',$value->division)->get();
                    $PackingData[] = array(
                        'value' => $value,
                        'result' => $result1[0]['description'],
                    );
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
            return view('pricingsheet.pricing-sheet-update-costing')->with([
                'id'=> $id,
                'data'=> $data[0],
                'i'=> 1,'j'=> 1,'k'=> 1,'l'=> 1,'m'=> 1,'n'=> 1,
                'a1'=> 1, 'a2'=> 1, 'a11'=> 1, 'a22'=> 1, 'a111'=> 1, 'a222'=> 1, 'b1'=> 1, 'b2'=> 1, 'b11'=> 1, 'b22'=> 1, 'b111'=> 1, 'b222'=> 1,
                'c1'=> 1, 'c2'=> 1, 'c11'=> 1, 'c22'=> 1, 'c111'=> 1, 'c222'=> 1, 'd1'=> 1, 'd2'=> 1, 'd11'=> 1, 'd22'=> 1, 'd111'=> 1, 'd222'=> 1,
                'e1'=> 1,'e2'=> 1,'e11'=> 1,'e22'=> 1,'e111'=> 1,'e222'=> 1, 'f1'=> 1,'f2'=> 1,'f11'=> 1,'f22'=> 1,'f111'=> 1,'f222'=> 1,
                'cuttingData'=> $cuttingData, 'InsoleData'=> $InsoleData, 'LaminationData'=> $LaminationData, 'ClosingData'=> $ClosingData, 'LastingData'=> $LastingData, 'PackingData'=> $PackingData,
                'F_cuttingData'=> $F_cuttingData, 'F_StitchingData'=> $F_StitchingData, 'F_LaminationData'=> $F_LaminationData, 'F_ClosingData'=> $F_ClosingData, 'F_LastingData'=> $F_LastingData, 'F_PackingData'=> $F_PackingData,
                'cuttingData_o'=> $cuttingData_o, 'InsoleData_o'=> $InsoleData_o, 'LaminationData_o'=> $LaminationData_o, 'ClosingData_o'=> $ClosingData_o, 'LastingData_o'=> $LastingData_o, 'PackingData_o'=> $PackingData_o,
                'cuttingData_r'=> $cuttingData_r, 'InsoleData_r'=> $InsoleData_r, 'LaminationData_r'=> $LaminationData_r, 'ClosingData_r'=> $ClosingData_r, 'LastingData_r'=> $LastingData_r, 'PackingData_r'=> $PackingData_r,
                'userseason'=> $userseason, 'userpurpose'=> $userpurpose, 'image'=> $userimage, 'category'=> $category, 'usershape'=> $usershape, 'usersole'=> $usersole,
                'userproject'=> $userproject, 'userproduct'=> $userproduct, 'userrange'=> $userrange, 'userdesign'=> $userdesign, 'userdescription'=> $userdescription,
                'usercategory'=> $usercategory, 'sequence'=> $sequence, 'date'=> $date, 'progress'=> $progress, 'formulaData'=> $formulaData, 'overhead_id' => $overhead_id
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
            $season = array();
            $item_code = array();
            $article_code = array();
            $id = $_GET['id'];
            $check = 0;
            $cuttingData = []; $InsoleData = []; $LaminationData = []; $ClosingData = []; $LastingData = []; $PackingData = [];
            $data1 = DB::table('plc_pricings')->where('id', $id)->get();
            $data2 = DB::table('plc_pricing_details')->where('costing_id', $id)->get();
            $data4 = DB::table('plc_manuals')->where('costing_id', $id)->pluck('manual');
            if(isset($data4[0])){
                $check = 1;
            }else{
                $check = 0;
            }
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
            $location = PlcLocation::orderBy('location_no','ASC')->get();
            $project = PlcProject::orderBy('id','DESC')->get();
            $purpose = PlcPurpose::orderBy('id','DESC')->get();
            $range = PlcRange::orderBy('id','DESC')->get();
            $shape = PlcShape::orderBy('id','DESC')->get();
            $sole = PlcSole::orderBy('id','DESC')->get();
            $last = PlcLastNumber::orderBy('id','DESC')->get();
            $division = Division::orderBy('id','DESC')->get();
            return view('pricingsheet.pricing-sheet-edit')->with([
                'id'=> $id,
                'data1'=> $data1[0], "manual" => $data4,
                'i'=> 1,'j'=> 1,'k'=> 1,'l'=> 1,'m'=> 1,'n'=> 1,
                'cuttingData'=> $cuttingData, 'InsoleData'=> $InsoleData, 'LaminationData'=> $LaminationData, 'ClosingData'=> $ClosingData, 'LastingData'=> $LastingData, 'PackingData'=> $PackingData,
                'a1'=> 1, 'a2'=> 1, 'b1'=> 1, 'b2'=> 1, 'c1'=> 1, 'c2'=> 1, 'd1'=> 1, 'd2'=> 1, 'e1'=> 1, 'e2'=> 1, 'f1'=> 1,'f2'=> 1, 'g1'=> 1, 'g2'=> 1,
                'season'=> $season, 'itemcode'=> $item_code, 'userseason'=> $userseason, 'userpurpose'=> $userpurpose, 'sequence'=> $sequence, 'date'=> $date, 'image'=> $userimage,
                'articlecode'=> $article_code, 'category'=> $category, 'usershape'=> $usershape, 'usersole'=> $usersole, 'userproject'=> $userproject,
                'userproduct'=> $userproduct, 'userrange'=> $userrange, 'userdesign'=> $userdesign, 'userdescription'=> $userdescription, 'usercategory'=> $usercategory,
                'shape'=> $shape, 'sole'=> $sole, 'project'=> $project, 'range'=> $range, 'purpose'=> $purpose, 'last'=> $last, 'userlast'=> $userlast, 'check'=> $check, 'location'=> $location,
                'division'=> $division
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

    public function EditCosting(Request $request)
    {
        try{
            $id = $_GET['id'];
            $season = []; $item_code = []; $article_code = [];
            $cuttingData = []; $InsoleData = []; $LaminationData = []; $ClosingData = []; $LastingData = []; $PackingData = [];
            $data1 = DB::table('plc_pricings')->where('id', $id)->get();
            $data2 = DB::table('plc_pricing_details')->where('costing_id', $id)->get();
            $formulaData = PlcFormula::orderBy('id','DESC')->get()->unique('oh_id');
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
                    $result1 = Division::orderBy('id','DESC')->where('id',$value->division)->get();
                    $cuttingData[] = array(
                        'value' => $value,
                        'result' => $result1[0]['description'],
                    );
                }
                elseif($value->material == "insole"){
                    $result1 = Division::orderBy('id','DESC')->where('id',$value->division)->get();
                    $InsoleData[] = array(
                        'value' => $value,
                        'result' => $result1[0]['description'],
                    );
                }
                elseif($value->material == "lamination"){
                    $result1 = Division::orderBy('id','DESC')->where('id',$value->division)->get();
                    $LaminationData[] = array(
                        'value' => $value,
                        'result' => $result1[0]['description'],
                    );
                }
                elseif($value->material == "closing"){
                    $result1 = Division::orderBy('id','DESC')->where('id',$value->division)->get();
                    $ClosingData[] = array(
                        'value' => $value,
                        'result' => $result1[0]['description'],
                    );
                }
                elseif($value->material == "lasting"){
                    $result1 = Division::orderBy('id','DESC')->where('id',$value->division)->get();
                    $LastingData[] = array(
                        'value' => $value,
                        'result' => $result1[0]['description'],
                    );
                }
                elseif($value->material == "packing"){
                    $result1 = Division::orderBy('id','DESC')->where('id',$value->division)->get();
                    $PackingData[] = array(
                        'value' => $value,
                        'result' => $result1[0]['description'],
                    );
                }
            }
            $category = PlcCategory::orderBy('id','DESC')->get();
            $project = PlcProject::orderBy('id','DESC')->get();
            $purpose = PlcPurpose::orderBy('id','DESC')->get();
            $range = PlcRange::orderBy('id','DESC')->get();
            $shape = PlcShape::orderBy('id','DESC')->get();
            $sole = PlcSole::orderBy('id','DESC')->get();
            return view('pricingsheet.pricing-sheet-edit-costing')->with([
                'id'=> $id,                           
                'data1'=> $data1[0],
                'i'=> 1,'j'=> 1,'k'=> 1,'l'=> 1,'m'=> 1,'n'=> 1,
                'cuttingData'=> $cuttingData, 'InsoleData'=> $InsoleData, 'LaminationData'=> $LaminationData, 'ClosingData'=> $ClosingData, 'LastingData'=> $LastingData, 'PackingData'=> $PackingData,
                'a1'=> 1,'a2'=> 1, 'b1'=> 1,'b2'=> 1, 'c1'=> 1,'c2'=> 1, 'd1'=> 1,'d2'=> 1, 'e1'=> 1,'e2'=> 1, 'f1'=> 1,'f2'=> 1,
                'season'=> $season, 'itemcode'=> $item_code, 'userseason'=> $userseason, 'userpurpose'=> $userpurpose, 'sequence'=> $sequence, 'date'=> $date,
                'image'=> $userimage, 'articlecode'=> $article_code, 'category'=> $category, 'usershape'=> $usershape, 'usersole'=> $usersole, 'userproject'=> $userproject,
                'userproduct'=> $userproduct, 'userrange'=> $userrange, 'userdesign'=> $userdesign, 'userdescription'=> $userdescription, 'usercategory'=> $usercategory,
                'userprogress'=> $userprogress, 'shape'=> $shape, 'sole'=> $sole, 'project'=> $project, 'range'=> $range, 'purpose'=> $purpose, 'formulaData'=> $formulaData
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
            $wizerp  = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $connPRL = oci_connect("onsole","s",$wizerp);
            $sono = array();
            $color = array();
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
                    $data = PlcPricing::orderBy('id','DESC')->where('status', '!=', "Pending")->where('status', '!=', "PD")->get();
                }
                return view('pricingsheet.pricing-sheet-costing-table')->with(['data'=> $data, 'i'=> 1]);
            }
            elseif($id == 2){
                $data = PlcPricing::orderBy('id','DESC')->get();
                return view('pricingsheet.pricing-sheet-admin-table')->with(['data'=> $data, 'i'=> 1]); 
            }
            elseif(isset($storeData['Pricing-Sheet Sales']) && !empty($storeData['Pricing-Sheet Sales'])){
                if(isset($storeData['Pricing-Sheet Sales']) == 1){
                    $data = PlcPricing::orderBy('id','DESC')->where('status', "Sales")->Orwhere('status', "Final")->get();
                }
                $sql = "SELECT SALES_ORDER_ID FROM SALES_ORDER_MT WHERE INV_BOOK_ID = 74 ORDER BY SALES_ORDER_ID ASC";
                $result = oci_parse($connPRL, $sql);
                oci_execute($result);
                while($row = oci_fetch_array($result,  OCI_ASSOC+OCI_RETURN_NULLS)){
                    $sono[] = $row['SALES_ORDER_ID'];
                }
                $lenght = count($sono);
                return view('pricingsheet.pricing-sheet-sales-table')->with(['data'=> $data, 'i'=> 1, 'sono'=> $sono, 'lenght'=> $lenght]);
            }
            elseif(isset($storeData['Job-Order Create']) && !empty($storeData['Job-Order Create'])){
                if(isset($storeData['Job-Order Create']) == 1){
                    $data = PlcPricing::orderBy('id','DESC')->where('status', "Final")->where('progress', 100)->get();
                }
                return view('pricingsheet.pricing-sheet-ppc-table')->with(['data'=> $data, 'i'=> 1]);
            }
            elseif(isset($storeData['Pricing-Sheet List']) && !empty($storeData['Pricing-Sheet List'])){
                if(isset($storeData['Pricing-Sheet List']) == 1){
                    $sql1 = "SELECT SEGMENT_VALUE_DESC FROM WIZ_SEGMENT04 WHERE STRUCTURE_ID = 26";
                    $result1 = oci_parse($connPRL, $sql1);
                    oci_execute($result1);
                    while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                        $color[] = strtolower($row1['SEGMENT_VALUE_DESC']);
                    }
                    $data = PlcPricing::orderBy('id','DESC')->get();
                }
                return view('pricingsheet.pricing-sheet-table')->with(['color'=> $color, 'data'=> $data, 'i'=> 1]);
            } 
            else{
                $data = PlcPricing::orderBy('id','DESC')->get();
                return view('pricingsheet.pricing-sheet-table')->with(['data'=> $data, 'i'=> 1]);
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
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function Calculate($id,$value)
    {
        try{
            $id = $id;
            $calculateValue = $value;
            $total1 = 0; $total2 = 0; $total3 = 0;
            $data1 = PlcPricingDetail::where('costing_id', $id)->pluck('value');
            $data2 = PlcPricingResource::where('costing_id', $id)->pluck('pair');
            $formulaData = DB::table('plc_formulas')->where('p_id', $id)->get();
            foreach($formulaData as $value){
                if($value->dep == "Cutting"){
                    $cuttingDataF[] = $value;
                }
                elseif($value->dep == "Stitching"){
                    $StitchingDataF[] = $value;
                }
                elseif($value->dep == "Lamination"){
                    $LaminationDataF[] = $value;
                }
                elseif($value->dep == "Closing"){
                    $ClosingDataF[] = $value;
                }
                elseif($value->dep == "Lasting"){
                    $LastingDataF[] = $value;
                }
                elseif($value->dep == "Packing"){
                    $PackingDataF[] = $value;
                }
            }

            $t_oh1_total = 0; $un_a_oh_total = 0;
            if(!$cuttingDataF){
                $t_oh1_cut = 0; $un_a_oh_cut = 0;
            }
            else{
                foreach($cuttingDataF as $value){      
                    $t_oh1_cut = $value->t_oh1;
                    $un_a_oh_cut = $value->un_a_oh;
                }
            }
            if(!$StitchingDataF){
                $t_oh1_sti = 0; $un_a_oh_sti = 0;
            }
            else{
                foreach($StitchingDataF as $value){
                    $t_oh1_sti = $value->t_oh1;
                    $un_a_oh_sti = $value->un_a_oh;
                }
            }
            if(!$LaminationDataF){
                $t_oh1_lam = 0; $un_a_oh_lam = 0;
            }
            else{
                foreach($LaminationDataF as $value){
                    $t_oh1_lam = $value->t_oh1;
                    $un_a_oh_lam = $value->un_a_oh;
                }
            }
            if(!$ClosingDataF){
              $t_oh1_clo = 0; $un_a_oh_clo = 0;
            }
            else{
                foreach($ClosingDataF as $value){
                    $t_oh1_clo = $value->t_oh1;
                    $un_a_oh_clo = $value->un_a_oh;
                }
            }
            if(!$LastingDataF){
                $t_oh1_last = 0; $un_a_oh_last = 0;
            }
            else{
                foreach($LastingDataF as $value){
                    $t_oh1_last = $value->t_oh1;
                    $un_a_oh_last = $value->un_a_oh;
                }
            }
            if(!$PackingDataF){
             $t_oh1_p = 0; $un_a_oh_p = 0;
            }
            else{
                foreach($PackingDataF as $value){
                    $t_oh1_p = $value->t_oh1;
                    $un_a_oh_p = $value->un_a_oh;
                }
            }

            $t_oh1_total = $t_oh1_cut + $t_oh1_sti + $t_oh1_lam + $t_oh1_clo + $t_oh1_last + $t_oh1_p;
            $un_a_oh_total = $un_a_oh_cut + $un_a_oh_sti + $un_a_oh_lam + $un_a_oh_clo + $un_a_oh_last + $un_a_oh_p;

            $AllData = [ 
                't_oh1_total' => $t_oh1_total,
                'un_a_oh_total' => $un_a_oh_total,
            ];
            
            $result1 = 100 + $AllData['t_oh1_total'] + $AllData['un_a_oh_total'];
            foreach($data1 as $value1){
                $total1 = $total1 + $value1;
            }
            foreach($data2 as $value2){
                $total2 = $total2 + $value2;
            }
            $total3 = $result1;
            $result = $total1 + $total2 + $total3;
            $profit = ($result / 100) * $calculateValue;
            $actualPrice = $result;
            $total = $actualPrice + $profit;
            $input1 = array(
                'profit' => $actualPrice,
                'price' => $total,
                'profit_price' => $calculateValue,
            );
            $updateData = PlcPricing::where('id', $id)->update($input1);
            if($updateData){
                return response()->json($updateData);
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

    public function StoreSono($value,$id)
    {
        try{
            $update = PlcPricing::where('id', $id)->update(['sono' => $value]);
            if($update){
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

    public function GetSubDivision($value)
    {
        try{
            $result = SubDivision::where('division_id', $value)->get();
            if($result){
                return response()->json($result);
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

    public function GetDivision()
    {
        try{
            $result = Division::get();
            if($result){
                return response()->json($result);
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

    public function Remarks($id)
    {
        try{
            $result = DB::table("plc_pricing_process")->where("ps_id", $id)->orderBy('id','ASC')->get();
            $count = count($result);
            if($count > 0){
                $data = array(
                    'data' => $result,
                    'count' => $count,
                    'status' => 1,
                );
                return response()->json($data);
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
            date_default_timezone_set("Asia/karachi");
            $Currenttime = date("h:i A");
            $Currentdate = date("d-m-Y");
            $Userdata = [];
            $idddd = Auth::user()->id;
            $name = Auth::user()->emp_name;
            $UserDetail = DB::table("users")->where("id", $idddd)->pluck('userrole');
            $UserDetail1 = DB::table("newroles")->where("name", $UserDetail)->get();
            $obj = json_decode (json_encode ($UserDetail1), FALSE);
            $storeData = [];
            foreach($obj as $dataa){
                $storeData[$dataa->role_name] = $dataa->value; 
            }

            date_default_timezone_set('Asia/Karachi');
            $date1 = date("d-F-Y");
            $getremarks = DB::table('plc_pricings')->where('id', $id)->pluck('progress');
            $msg = 0; $department = 0;
            if($status == "Costing"){
                $msg = "Transferred to Costing";
                $msg1 = "Transferred";
                if(isset($storeData['Pricing-Sheet Sales']) && !empty($storeData['Pricing-Sheet Sales'])){
                    if(isset($storeData['Pricing-Sheet Sales']) == 1){
                        $ChangeStatus = array(
                            'status' => $status,
                            'remarks' => $remarks,
                        );
                        $Userdata[] = [
                            'user_id' => $name,
                            'remarks' => $remarks,
                            'ps_id' => $id,
                            'status' => $status,
                            'date' => $Currentdate." ".$Currenttime,
                        ];
                    }
                }
                elseif($getremarks[0] == 100){
                    $ChangeStatus = array(
                        'status' => $status,
                        'remarks' => $remarks,
                    );
                    $Userdata[] = [
                        'user_id' => $name,
                        'remarks' => $remarks,
                        'ps_id' => $id,
                        'status' => $status,
                        'date' => $Currentdate." ".$Currenttime,
                    ];
                }
                else{
                    $ChangeStatus = array(
                        'status' => $status,
                        'remarks' => $remarks,
                        'progress' => 40,
                    );
                    $Userdata[] = [
                        'user_id' => $name,
                        'remarks' => $remarks,
                        'ps_id' => $id,
                        'status' => $status,
                        'date' => $Currentdate." ".$Currenttime,
                    ];
                }
                $Insert = DB::table('plc_pricing_process')->insert($Userdata[0]);
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
                $progress = 0;
                $ChangeStatus = array(
                    'status' => $status,
                    'remarks' => $remarks
                );
                $Userdata[] = [
                    'user_id' => $name,
                    'remarks' => $remarks,
                    'ps_id' => $id,
                    'status' => $status,
                    'date' => $Currentdate." ".$Currenttime,
                ];
                $Insert = DB::table('plc_pricing_process')->insert($Userdata[0]);
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
            if($status == "Update"){
                $msg = "Update";
                $msg1 = "Update";
                $ChangeStatus = array(
                    'status' => $status,
                    'remarks' => $remarks
                );
                $Userdata[] = [
                    'user_id' => $name,
                    'remarks' => $remarks,
                    'ps_id' => $id,
                    'status' => $status,
                    'date' => $Currentdate." ".$Currenttime,
                ];
                $Insert = DB::table('plc_pricing_process')->insert($Userdata[0]);
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
                $msg = "Update";
                $msg1 = "Update";
                if(isset($storeData['Pricing-Sheet Costing']) && !empty($storeData['Pricing-Sheet Costing'])){
                    if(isset($storeData['Pricing-Sheet Costing']) == 1){
                        $ChangeStatus = array(
                            'status' => $status,
                            'remarks' => $remarks,
                        );
                    }
                }
                else{
                    $ChangeStatus = array(
                        'status' => $status,
                        'remarks' => $remarks,
                        'progress' => 20,
                    );
                }
                $Userdata[] = [
                    'user_id' => $name,
                    'remarks' => $remarks,
                    'ps_id' => $id,
                    'status' => $status,
                    'date' => $Currentdate." ".$Currenttime,
                ];
                $Insert = DB::table('plc_pricing_process')->insert($Userdata[0]);
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
                $ChangeStatus = array(
                    'status' => $status,
                    'remarks' => $remarks
                );
                $Userdata[] = [
                    'user_id' => $name,
                    'remarks' => $remarks,
                    'ps_id' => $id,
                    'status' => $status,
                    'date' => $Currentdate." ".$Currenttime,
                ];
                $Insert = DB::table('plc_pricing_process')->insert($Userdata[0]);
                $assign_users = Newrole::orderBy('id','ASC')->where('role_name', 'Pricing-Sheet List')
                                                            ->Orwhere('role_name', 'Pricing-Sheet Costing')
                                                            ->Orwhere('role_name', 'Pricing-Sheet Sales')
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
            if($status == "Final"){
                $msg = "Finalized";
                $msg1 = "Finalized";
                $ChangeStatus = array(
                    'status' => $status,
                    'remarks' => $remarks
                );
                $Userdata[] = [
                    'user_id' => $name,
                    'remarks' => $remarks,
                    'ps_id' => $id,
                    'status' => $status,
                    'date' => $Currentdate." ".$Currenttime,
                ];
                $Insert = DB::table('plc_pricing_process')->insert($Userdata[0]);
                $assign_users = Newrole::orderBy('id','ASC')->where('role_name', 'Pricing-Sheet Sales')
                                                            ->Orwhere('role_name', 'Pricing-Sheet Costing')
                                                            ->Orwhere('role_name', 'Pricing-Sheet List')
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
            if($status == "PPC"){
                $msg = "Transferred to PPC";
            }        
            $input = array([
                'data' => $date1,
                'event_at' => 'Pricing Sheet',
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
                    'event' => 'Pricing Sheet '.$msg1,
                    'url' => 'pricing-sheet-view',
                    'complaint' => $id,
                    'complaint_id' => $id,
                    'userid' => $userid,
                    'name' => $name,
                    'image' => $image,
                ]);
                $user = notification_details::create($input3[0]);
            }
    
            notification_details::where('notification_id', $notification_id)->where('assign_users', Auth::user()->id)->delete();
            $update = DB::table('plc_pricings')->where('id', $id)->update($ChangeStatus);
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
