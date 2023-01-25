<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use Auth;
use Session;
use Exception;
use App\Models\PlcFormula;
use Illuminate\Http\Request;

class FormulaController extends Controller
{
    public function Formula(Request $request)
    {
        try{
            return view('formulasheet.formula-sheet');
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
        date_default_timezone_set('Asia/Karachi');
        try{
            $store = 1;
            $Support = PlcFormula::orderBy('id','DESC')->limit(1)->get();
            if(count($Support) == 0){
                $result = $store + 0;
            }
            else{
                $result = $store + $Support[0]->oh_id;
            }
            if($request->cut_dep_cutting != null){
                $cutting = new PlcFormula();
                $cutting->oh_id =  $result;
                $cutting->dep =  $request->cut_dep_cutting ? $request->cut_dep_cutting : '0';
                $cutting->pcpd = $request->cut_pcpd_cutting ? $request->cut_pcpd_cutting : '0';
                $cutting->noe = $request->cut_noe_cutting ? $request->cut_noe_cutting : '0';
                $cutting->aspd = $request->cut_aspd_cutting ? $request->cut_aspd_cutting : '0';
                $cutting->nowd = $request->cut_nowd_cutting ? $request->cut_nowd_cutting : '0';
                $cutting->pds = $request->cut_pds_cutting ? $request->cut_pds_cutting : '0';
                $cutting->dloh1 = $request->cut_dlo_cutting ? $request->cut_dlo_cutting : '0';
                $cutting->ilo = $request->cut_cilo_cutting ? $request->cut_ilo_cutting : '0';
                $cutting->idloh1 = $request->cut_dlo_cutting ? $request->cut_dlo_cutting : '0';
                $cutting->foh = $request->cut_foh_cutting ? $request->cut_foh_cutting : '0';
                $cutting->idloh2 = $request->cut_ilOh_b_cutting ? $request->cut_ilOh_b_cutting : '0';
                $cutting->t_oh1 = $request->cut_t_oh_cutting ? $request->cut_t_oh_cutting : '0';
                $cutting->capacity = $request->cut_cap_cutting ? $request->cut_cap_cutting : '0';
                $cutting->dloh2 = $request->cut_dlo_a_cutting ? $request->cut_dlo_a_cutting : '0';
                $cutting->idloh3 = $request->cut_ilo_a_cutting ? $request->cut_ilo_a_cutting : '0';
                $cutting->dloh3 = $request->cut_toh_cutting ? $request->cut_toh_cutting : '0';
                $cutting->t_oh2 = $request->cut_toh_cutting ? $request->cut_toh_cutting : '0';
                $cutting->un_a_oh = $request->cut_uaOh_cutting ? $request->cut_uaOh_cutting : '0';
                $cutting->onwer =  Auth::user()->emp_name;
                $store = $cutting->save();
            }
            if($request->cut_dep_sti != null){
                $cutting = new PlcFormula();
                $cutting->oh_id =  $result;
                $cutting->dep =  $request->cut_dep_sti ? $request->cut_dep_sti : '0';
                $cutting->pcpd = $request->cut_pcpd_sti ? $request->cut_pcpd_sti : '0';
                $cutting->noe = $request->cut_noe_sti ? $request->cut_noe_sti : '0';
                $cutting->aspd = $request->cut_aspd_sti ? $request->cut_aspd_sti : '0';
                $cutting->nowd = $request->cut_nowd_sti ? $request->cut_nowd_sti : '0';
                $cutting->pds = $request->cut_pds_sti ? $request->cut_pds_sti : '0';
                $cutting->dloh1 = $request->cut_ilo_sti ? $request->cut_ilo_sti : '0';
                $cutting->ilo = $request->cut_ilo_sti ? $request->cut_ilo_sti : '0';
                $cutting->idloh1 = $request->cut_dlo_sti ? $request->cut_dlo_sti : '0';
                $cutting->foh = $request->cut_foh_sti ? $request->cut_foh_sti : '0';
                $cutting->idloh2 = $request->cut_ilOh_b_sti ? $request->cut_ilOh_b_sti : '0';
                $cutting->t_oh1 = $request->cut_t_oh_sti ? $request->cut_t_oh_sti : '0';
                $cutting->capacity = $request->cut_cap_sti ? $request->cut_cap_sti : '0';
                $cutting->dloh2 = $request->cut_dlo_a_sti ? $request->cut_dlo_a_sti : '0';
                $cutting->idloh3 = $request->cut_ilo_a_sti ? $request->cut_ilo_a_sti : '0';
                $cutting->dloh3 = $request->cut_toh_sti ? $request->cut_toh_sti : '0';
                $cutting->t_oh2 = $request->cut_toh_sti ? $request->cut_toh_sti : '0';
                $cutting->un_a_oh = $request->cut_uaOh_sti ? $request->cut_uaOh_sti : '0';
                $cutting->onwer =  Auth::user()->emp_name;
                $store = $cutting->save();
            }
            if($request->cut_dep_last != null){
                $cutting = new PlcFormula();
                $cutting->oh_id =  $result;
                $cutting->dep =  $request->cut_dep_last ? $request->cut_dep_last : '0';
                $cutting->pcpd = $request->cut_pcpd_last ? $request->cut_pcpd_last : '0';
                $cutting->noe = $request->cut_noe_last ? $request->cut_noe_last : '0';
                $cutting->aspd = $request->cut_aspd_last ? $request->cut_aspd_last : '0';
                $cutting->nowd = $request->cut_nowd_last ? $request->cut_nowd_last : '0';
                $cutting->pds = $request->cut_pds_last ? $request->cut_pds_last : '0';
                $cutting->dloh1 = $request->cut_ilo_last ? $request->cut_ilo_last : '0';
                $cutting->ilo = $request->cut_ilo_last ? $request->cut_ilo_last : '0';
                $cutting->idloh1 = $request->cut_dlo_last ? $request->cut_dlo_last : '0';
                $cutting->foh = $request->cut_foh_last ? $request->cut_foh_last : '0';
                $cutting->idloh2 = $request->cut_ilOh_b_last ? $request->cut_ilOh_b_last : '0';
                $cutting->t_oh1 = $request->cut_t_oh_last ? $request->cut_t_oh_last : '0';
                $cutting->capacity = $request->cut_cap_last ? $request->cut_cap_last : '0';
                $cutting->dloh2 = $request->cut_dlo_a_last ? $request->cut_dlo_a_last : '0';
                $cutting->idloh3 = $request->cut_ilo_a_last ? $request->cut_ilo_a_last : '0';
                $cutting->dloh3 = $request->cut_toh_last ? $request->cut_toh_last : '0';
                $cutting->t_oh2 = $request->cut_toh_last ? $request->cut_toh_last : '0';
                $cutting->un_a_oh = $request->cut_uaOh_last ? $request->cut_uaOh_last : '0';
                $cutting->onwer =  Auth::user()->emp_name;
                $store = $cutting->save();
            }
            if($request->cut_dep_clo != null){
                $cutting = new PlcFormula();
                $cutting->oh_id =  $result;
                $cutting->dep =  $request->cut_dep_clo ? $request->cut_dep_clo : '0';
                $cutting->pcpd = $request->cut_pcpd_clo ? $request->cut_pcpd_clo : '0';
                $cutting->noe = $request->cut_noe_clo ? $request->cut_noe_clo : '0';
                $cutting->aspd = $request->cut_aspd_clo ? $request->cut_aspd_clo : '0';
                $cutting->nowd = $request->cut_nowd_clo ? $request->cut_nowd_clo : '0';
                $cutting->pds = $request->cut_pds_clo ? $request->cut_pds_clo : '0';
                $cutting->dloh1 = $request->cut_ilo_clo ? $request->cut_ilo_clo : '0';
                $cutting->ilo = $request->cut_ilo_clo ? $request->cut_ilo_clo : '0';
                $cutting->idloh1 = $request->cut_dlo_clo ? $request->cut_dlo_clo : '0';
                $cutting->foh = $request->cut_foh_clo ? $request->cut_foh_clo : '0';
                $cutting->idloh2 = $request->cut_ilOh_b_clo ? $request->cut_ilOh_b_clo : '0';
                $cutting->t_oh1 = $request->cut_t_oh_clo ? $request->cut_t_oh_clo : '0';
                $cutting->capacity = $request->cut_cap_clo ? $request->cut_cap_clo : '0';
                $cutting->dloh2 = $request->cut_dlo_a_clo ? $request->cut_dlo_a_clo : '0';
                $cutting->idloh3 = $request->cut_ilo_a_clo ? $request->cut_ilo_a_clo : '0';
                $cutting->dloh3 = $request->cut_toh_clo ? $request->cut_toh_clo : '0';
                $cutting->t_oh2 = $request->cut_toh_clo ? $request->cut_toh_clo : '0';
                $cutting->un_a_oh = $request->cut_uaOh_clo ? $request->cut_uaOh_clo : '0';
                $cutting->onwer =  Auth::user()->emp_name;
                $store = $cutting->save();
            }
            if($request->cut_dep_lam != null){
                $cutting = new PlcFormula();
                $cutting->oh_id =  $result;
                $cutting->dep =  $request->cut_dep_lam ? $request->cut_dep_lam : '0';
                $cutting->pcpd = $request->cut_pcpd_lam ? $request->cut_pcpd_lam : '0';
                $cutting->noe = $request->cut_noe_lam ? $request->cut_noe_lam : '0';
                $cutting->aspd = $request->cut_aspd_lam ? $request->cut_aspd_lam : '0';
                $cutting->nowd = $request->cut_nowd_lam ? $request->cut_nowd_lam : '0';
                $cutting->pds = $request->cut_pds_lam ? $request->cut_pds_lam : '0';
                $cutting->dloh1 = $request->cut_ilo_lam ? $request->cut_ilo_lam : '0';
                $cutting->ilo = $request->cut_cilo_lam ? $request->cut_cilo_lam : '0';
                $cutting->idloh1 = $request->cut_dlo_lam ? $request->cut_dlo_lam : '0';
                $cutting->foh = $request->cut_foh_lam ? $request->cut_foh_lam : '0';
                $cutting->idloh2 = $request->cut_ilOh_b_lam ? $request->cut_ilOh_b_lam : '0';
                $cutting->t_oh1 = $request->cut_t_oh_lam ? $request->cut_t_oh_lam : '0';
                $cutting->capacity = $request->cut_cap_lam ? $request->cut_cap_lam : '0';
                $cutting->dloh2 = $request->cut_dlo_a_lam ? $request->cut_dlo_a_lam : '0';
                $cutting->idloh3 = $request->cut_ilo_a_lam ? $request->cut_ilo_a_lam : '0';
                $cutting->dloh3 = $request->cut_toh_lam ? $request->cut_toh_lam : '0';
                $cutting->t_oh2 = $request->cut_toh_lam ? $request->cut_toh_lam : '0';
                $cutting->un_a_oh = $request->cut_uaOh_lam ? $request->cut_uaOh_lam : '0';
                $cutting->onwer =  Auth::user()->emp_name;
                $store = $cutting->save();
            }
            if($request->cut_dep_p != null){
                $cutting = new PlcFormula();
                $cutting->oh_id =  $result;
                $cutting->dep =  $request->cut_dep_p ? $request->cut_dep_p : '0';
                $cutting->pcpd = $request->cut_pcpd_p ? $request->cut_pcpd_p : '0';
                $cutting->noe = $request->cut_noe_p ? $request->cut_noe_p : '0';
                $cutting->aspd = $request->cut_aspd_p ? $request->cut_aspd_p : '0';
                $cutting->nowd = $request->cut_nowd_p ? $request->cut_nowd_p : '0';
                $cutting->pds = $request->cut_pds_p ? $request->cut_pds_p : '0';
                $cutting->dloh1 = $request->cut_ilo_p ? $request->cut_ilo_p : '0';
                $cutting->ilo = $request->cut_ilo_p ? $request->cut_ilo_p : '0';
                $cutting->idloh1 = $request->cut_dlo_p ? $request->cut_dlo_p : '0';
                $cutting->foh = $request->cut_foh_p ? $request->cut_foh_p : '0';
                $cutting->idloh2 = $request->cut_ilOh_b_p ? $request->cut_ilOh_b_p : '0';
                $cutting->t_oh1 = $request->cut_t_oh_p ? $request->cut_t_oh_p : '0';
                $cutting->capacity = $request->cut_cap_p ? $request->cut_cap_p : '0';
                $cutting->dloh2 = $request->cut_dlo_a_p ? $request->cut_dlo_a_p : '0';
                $cutting->idloh3 = $request->cut_ilo_a_p ? $request->cut_ilo_a_p : '0';
                $cutting->dloh3 = $request->cut_toh_p ? $request->cut_toh_p : '0';
                $cutting->t_oh2 = $request->cut_toh_p ? $request->cut_toh_p : '0';
                $cutting->un_a_oh = $request->cut_uaOh_p ? $request->cut_uaOh_p : '0';
                $cutting->onwer =  Auth::user()->emp_name;
                $store = $cutting->save();
            }
            $notification = array(
                'message' => 'Formula Sheet Created',
                'alert-type' => 'success'
            );
            return redirect()->route('formula-sheet-table')->with($notification);
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
        date_default_timezone_set('Asia/Karachi');
        $id = $request->id;
        try{
            if($request->cut_dep_cutting != null){
                $dataArray = array(
                    'dep' =>  $request->cut_dep_cutting ? $request->cut_dep_cutting : '0',
                    'pcpd' => $request->cut_pcpd_cutting ? $request->cut_pcpd_cutting : '0',
                    'noe' => $request->cut_noe_cutting ? $request->cut_noe_cutting : '0',
                    'aspd' => $request->cut_aspd_cutting ? $request->cut_aspd_cutting : '0',
                    'nowd' => $request->cut_nowd_cutting ? $request->cut_nowd_cutting : '0',
                    'pds' => $request->cut_pds_cutting ? $request->cut_pds_cutting : '0',
                    'dloh1' => $request->cut_dlo_cutting ? $request->cut_dlo_cutting : '0',
                    'ilo' => $request->cut_cilo_cutting ? $request->cut_ilo_cutting : '0',
                    'idloh1' => $request->cut_dlo_cutting ? $request->cut_dlo_cutting : '0',
                    'foh' => $request->cut_foh_cutting ? $request->cut_foh_cutting : '0',
                    'idloh2' => $request->cut_ilOh_b_cutting ? $request->cut_ilOh_b_cutting : '0',
                    't_oh1' => $request->cut_t_oh_cutting ? $request->cut_t_oh_cutting : '0',
                    'capacity' => $request->cut_cap_cutting ? $request->cut_cap_cutting : '0',
                    'dloh2' => $request->cut_dlo_a_cutting ? $request->cut_dlo_a_cutting : '0',
                    'idloh3' => $request->cut_ilo_a_cutting ? $request->cut_ilo_a_cutting : '0',
                    'dloh3' => $request->cut_toh_cutting ? $request->cut_toh_cutting : '0',
                    't_oh2' => $request->cut_toh_cutting ? $request->cut_toh_cutting : '0',
                    'un_a_oh' => $request->cut_uaOh_cutting ? $request->cut_uaOh_cutting : '0',
                );
                $update = PlcFormula::where('oh_id', $id)->where('dep', 'Cutting')->update($dataArray);
            }
            if($request->cut_dep_sti != null){
                $dataArray = array(
                    'dep' =>  $request->cut_dep_sti ? $request->cut_dep_sti : '0',
                    'pcpd' => $request->cut_pcpd_sti ? $request->cut_pcpd_sti : '0',
                    'noe' => $request->cut_noe_sti ? $request->cut_noe_sti : '0',
                    'aspd' => $request->cut_aspd_sti ? $request->cut_aspd_sti : '0',
                    'nowd' => $request->cut_nowd_sti ? $request->cut_nowd_sti : '0',
                    'pds' => $request->cut_pds_sti ? $request->cut_pds_sti : '0',
                    'dloh1' => $request->cut_ilo_sti ? $request->cut_ilo_sti : '0',
                    'ilo' => $request->cut_ilo_sti ? $request->cut_ilo_sti : '0',
                    'idloh1' => $request->cut_dlo_sti ? $request->cut_dlo_sti : '0',
                    'foh' => $request->cut_foh_sti ? $request->cut_foh_sti : '0',
                    'idloh2' => $request->cut_ilOh_b_sti ? $request->cut_ilOh_b_sti : '0',
                    't_oh1' => $request->cut_t_oh_sti ? $request->cut_t_oh_sti : '0',
                    'capacity' => $request->cut_cap_sti ? $request->cut_cap_sti : '0',
                    'dloh2' => $request->cut_dlo_a_sti ? $request->cut_dlo_a_sti : '0',
                    'idloh3' => $request->cut_ilo_a_sti ? $request->cut_ilo_a_sti : '0',
                    'dloh3' => $request->cut_toh_sti ? $request->cut_toh_sti : '0',
                    't_oh2' => $request->cut_toh_sti ? $request->cut_toh_sti : '0',
                    'un_a_oh' => $request->cut_uaOh_sti ? $request->cut_uaOh_sti : '0',
                );
                $update = PlcFormula::where('oh_id', $id)->where('dep', 'Stitching')->update($dataArray);
            }
            if($request->cut_dep_last != null){
                $dataArray = array(
                    'dep' =>  $request->cut_dep_last ? $request->cut_dep_last : '0',
                    'pcpd' => $request->cut_pcpd_last ? $request->cut_pcpd_last : '0',
                    'noe' => $request->cut_noe_last ? $request->cut_noe_last : '0',
                    'aspd' => $request->cut_aspd_last ? $request->cut_aspd_last : '0',
                    'nowd' => $request->cut_nowd_last ? $request->cut_nowd_last : '0',
                    'pds' => $request->cut_pds_last ? $request->cut_pds_last : '0',
                    'dloh1' => $request->cut_ilo_last ? $request->cut_ilo_last : '0',
                    'ilo' => $request->cut_ilo_last ? $request->cut_ilo_last : '0',
                    'idloh1' => $request->cut_dlo_last ? $request->cut_dlo_last : '0',
                    'foh' => $request->cut_foh_last ? $request->cut_foh_last : '0',
                    'idloh2' => $request->cut_ilOh_b_last ? $request->cut_ilOh_b_last : '0',
                    't_oh1' => $request->cut_t_oh_last ? $request->cut_t_oh_last : '0',
                    'capacity' => $request->cut_cap_last ? $request->cut_cap_last : '0',
                    'dloh2' => $request->cut_dlo_a_last ? $request->cut_dlo_a_last : '0',
                    'idloh3' => $request->cut_ilo_a_last ? $request->cut_ilo_a_last : '0',
                    'dloh3' => $request->cut_toh_last ? $request->cut_toh_last : '0',
                    't_oh2' => $request->cut_toh_last ? $request->cut_toh_last : '0',
                    'un_a_oh' => $request->cut_uaOh_last ? $request->cut_uaOh_last : '0',
                );
                $update = PlcFormula::where('oh_id', $id)->where('dep', 'Lasting')->update($dataArray);
            }
            if($request->cut_dep_clo != null){
                $dataArray = array(
                    'dep' =>  $request->cut_dep_clo ? $request->cut_dep_clo : '0',
                    'pcpd' => $request->cut_pcpd_clo ? $request->cut_pcpd_clo : '0',
                    'noe' => $request->cut_noe_clo ? $request->cut_noe_clo : '0',
                    'aspd' => $request->cut_aspd_clo ? $request->cut_aspd_clo : '0',
                    'nowd' => $request->cut_nowd_clo ? $request->cut_nowd_clo : '0',
                    'pds' => $request->cut_pds_clo ? $request->cut_pds_clo : '0',
                    'dloh1' => $request->cut_ilo_clo ? $request->cut_ilo_clo : '0',
                    'ilo' => $request->cut_ilo_clo ? $request->cut_ilo_clo : '0',
                    'idloh1' => $request->cut_dlo_clo ? $request->cut_dlo_clo : '0',
                    'foh' => $request->cut_foh_clo ? $request->cut_foh_clo : '0',
                    'idloh2' => $request->cut_ilOh_b_clo ? $request->cut_ilOh_b_clo : '0',
                    't_oh1' => $request->cut_t_oh_clo ? $request->cut_t_oh_clo : '0',
                    'capacity' => $request->cut_cap_clo ? $request->cut_cap_clo : '0',
                    'dloh2' => $request->cut_dlo_a_clo ? $request->cut_dlo_a_clo : '0',
                    'idloh3' => $request->cut_ilo_a_clo ? $request->cut_ilo_a_clo : '0',
                    'dloh3' => $request->cut_toh_clo ? $request->cut_toh_clo : '0',
                    't_oh2' => $request->cut_toh_clo ? $request->cut_toh_clo : '0',
                    'un_a_oh' => $request->cut_uaOh_clo ? $request->cut_uaOh_clo : '0',
                );
                $update = PlcFormula::where('oh_id', $id)->where('dep', 'Closing')->update($dataArray);
            }
            if($request->cut_dep_lam != null){
                $dataArray = array(
                    'dep' => $request->cut_dep_lam ? $request->cut_dep_lam : '0',
                    'pcpd' => $request->cut_pcpd_lam ? $request->cut_pcpd_lam : '0',
                    'noe' => $request->cut_noe_lam ? $request->cut_noe_lam : '0',
                    'aspd' => $request->cut_aspd_lam ? $request->cut_aspd_lam : '0',
                    'nowd' => $request->cut_nowd_lam ? $request->cut_nowd_lam : '0',
                    'pds' => $request->cut_pds_lam ? $request->cut_pds_lam : '0',
                    'dloh1' => $request->cut_ilo_lam ? $request->cut_ilo_lam : '0',
                    'ilo' => $request->cut_cilo_lam ? $request->cut_cilo_lam : '0',
                    'idloh1' => $request->cut_dlo_lam ? $request->cut_dlo_lam : '0',
                    'foh' => $request->cut_foh_lam ? $request->cut_foh_lam : '0',
                    'idloh2' => $request->cut_ilOh_b_lam ? $request->cut_ilOh_b_lam : '0',
                    't_oh1' => $request->cut_t_oh_lam ? $request->cut_t_oh_lam : '0',
                    'capacity' => $request->cut_cap_lam ? $request->cut_cap_lam : '0',
                    'dloh2' => $request->cut_dlo_a_lam ? $request->cut_dlo_a_lam : '0',
                    'idloh3' => $request->cut_ilo_a_lam ? $request->cut_ilo_a_lam : '0',
                    'dloh3' => $request->cut_toh_lam ? $request->cut_toh_lam : '0',
                    't_oh2' => $request->cut_toh_lam ? $request->cut_toh_lam : '0',
                    'un_a_oh' => $request->cut_uaOh_lam ? $request->cut_uaOh_lam : '0',
                );
                $update = PlcFormula::where('oh_id', $id)->where('dep', 'Lamination')->update($dataArray);
            }
            if($request->cut_dep_p != null){
                $dataArray = array(
                    'dep' =>  $request->cut_dep_p ? $request->cut_dep_p : '0',
                    'pcpd' => $request->cut_pcpd_p ? $request->cut_pcpd_p : '0',
                    'noe' => $request->cut_noe_p ? $request->cut_noe_p : '0',
                    'aspd' => $request->cut_aspd_p ? $request->cut_aspd_p : '0',
                    'nowd' => $request->cut_nowd_p ? $request->cut_nowd_p : '0',
                    'pds' => $request->cut_pds_p ? $request->cut_pds_p : '0',
                    'dloh1' => $request->cut_ilo_p ? $request->cut_ilo_p : '0',
                    'ilo' => $request->cut_ilo_p ? $request->cut_ilo_p : '0',
                    'idloh1' => $request->cut_dlo_p ? $request->cut_dlo_p : '0',
                    'foh' => $request->cut_foh_p ? $request->cut_foh_p : '0',
                    'idloh2' => $request->cut_ilOh_b_p ? $request->cut_ilOh_b_p : '0',
                    't_oh1' => $request->cut_t_oh_p ? $request->cut_t_oh_p : '0',
                    'capacity' => $request->cut_cap_p ? $request->cut_cap_p : '0',
                    'dloh2' => $request->cut_dlo_a_p ? $request->cut_dlo_a_p : '0',
                    'idloh3' => $request->cut_ilo_a_p ? $request->cut_ilo_a_p : '0',
                    'dloh3' => $request->cut_toh_p ? $request->cut_toh_p : '0',
                    't_oh2' => $request->cut_toh_p ? $request->cut_toh_p : '0',
                    'un_a_oh' => $request->cut_uaOh_p ? $request->cut_uaOh_p : '0',
                );
                $update = PlcFormula::where('oh_id', $id)->where('dep', 'Packing')->update($dataArray);
            }
            $notification = array(
                'message' => 'Formula Sheet Updated',
                'alert-type' => 'success'
            );
            return redirect()->route('formula-sheet-table')->with($notification);
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
            $designation = Auth::user()->designation;
            if(isset($storeData['Formula-Sheet List']) && !empty($storeData['Formula-Sheet List'])){
                if(isset($storeData['Formula-Sheet List']) == 1){
                    $data = PlcFormula::orderBy('id','DESC')->get()->unique('oh_id');
                }
                return view('formulasheet.formula-sheet-table')->with(['data'=> $data, 'i'=> 1]);
            }
            elseif($designation == "Super Admin"){
                $data = PlcFormula::orderBy('id','DESC')->get()->unique('oh_id');
                return view('formulasheet.formula-sheet-admin-table')->with(['data'=> $data, 'i'=> 1]);
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

    public function Edit(Request $request)
    {
        try{
            $id = $_GET['id'];
            $cuttingData = []; $StitchingData = []; $LaminationData = []; $ClosingData = []; $LastingData = []; $PackingData = [];
            $data = PlcFormula::orderBy('id','ASC')->where('oh_id', $id)->get();
            foreach($data as $value){
                if($value->dep == "Cutting"){
                    $cuttingData[] = $value;
                }
                elseif($value->dep == "Stitching"){
                    $StitchingData[] = $value;
                }
                elseif($value->dep == "Lamination"){
                    $LaminationData[] = $value;
                }
                elseif($value->dep == "Closing"){
                    $ClosingData[] = $value;
                }
                elseif($value->dep == "Lasting"){
                    $LastingData[] = $value;
                }
                elseif($value->dep == "Packing"){
                    $PackingData[] = $value;
                }
            }
            return view('formulasheet.formula-sheet-edit')->with([
                'cuttingData'=> $cuttingData, 'StitchingData'=> $StitchingData, 'LaminationData'=> $LaminationData, 'ClosingData'=> $ClosingData, 'LastingData'=> $LastingData, 'PackingData'=> $PackingData, 'id'=> $id
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

    public function View(Request $request)
    {
        try{
            $id = $_GET['id'];
            $cuttingData = []; $StitchingData = []; $LaminationData = []; $ClosingData = []; $LastingData = []; $PackingData = [];
            $data = PlcFormula::orderBy('id','ASC')->where('oh_id', $id)->get();
            foreach($data as $value){
                if($value->dep == "Cutting"){
                    $cuttingData[] = $value;
                }
                elseif($value->dep == "Stitching"){
                    $StitchingData[] = $value;
                }
                elseif($value->dep == "Lamination"){
                    $LaminationData[] = $value;
                }
                elseif($value->dep == "Closing"){
                    $ClosingData[] = $value;
                }
                elseif($value->dep == "Lasting"){
                    $LastingData[] = $value;
                }
                elseif($value->dep == "Packing"){
                    $PackingData[] = $value;
                }
            }
            return view('formulasheet.formula-sheet-view')->with([
                'cuttingData'=> $cuttingData, 'StitchingData'=> $StitchingData, 'LaminationData'=> $LaminationData, 'ClosingData'=> $ClosingData, 'LastingData'=> $LastingData, 'PackingData'=> $PackingData, 'id'=> $id
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

    public function Delete($id)
    {
        try{
            $delete = PlcFormula::where('oh_id', $id)->delete();
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

    public function Status($id,$status)
    {
        try{
            $Deactive = DB::table('plc_formulas')->where('oh_id', '!=', $id)->update(['status' => 'Deactive']);
            $Active = DB::table('plc_formulas')->where('oh_id', $id)->update(['status' => $status]);
            if($Active){
                $notification = array(
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
