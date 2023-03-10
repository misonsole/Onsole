<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use Auth;
use Exception;
use App\Exports\Transfer;
use App\Exports\Helpdesk;
use App\Exports\Material;
use App\Exports\Adjustment;
use App\Exports\WorkorderDetail;
use App\Exports\WorkorderSummary;
use App\Exports\Purchase;
use App\Exports\Sales;
use App\Exports\SalesOrder;
use App\Exports\JobOrder;
use App\Exports\JobOrderJourney;
use App\Exports\PurchaseOrder;
use App\Exports\ItemPurchase;
use App\Exports\TransferAgainst;
use App\Exports\RMA;
use App\Exports\Consumption;
use App\Exports\Comparison;
use App\Exports\PurchaseInvoice;
use App\Exports\TransferLedger;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Models\Support;
use App\Models\Category;
use App\Models\RoleName;
use App\Models\LastNumber;
use App\Models\UserDetail;
use App\Models\Objectives;
use App\Models\Department;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function TransferData()
    {
        $books = array(); $locator = array();
        $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
        $conn = oci_connect("onsole","s",$wizerp);
        $sql1 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_BOOK_DESC LIKE '%Internal Transfer%' OR INV_BOOK_DESC LIKE '%Transfer Issue%'";
        $result1 = oci_parse($conn, $sql1);
        oci_execute($result1);
        while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $books[] = $row1["INV_BOOK_DESC"];
        }    
        $sql3 = "SELECT CODE_VALUE, CODE_DESC FROM CODE_COMBINATION_VALUES WHERE STRUCTURE_ID = 30";
        $result3 = oci_parse($conn, $sql3);
        oci_execute($result3);
        while($row3 =oci_fetch_array($result3,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $locator[] = $row3["CODE_VALUE"]." - ".strtolower($row3["CODE_DESC"]);
        }
        $data = array(
            "books" => $books, 
            "locator" => $locator
        );
        return response()->json($data);
    }

    public function Transfer(Request $request)
    {
        try{
            $booksArray = array();
            $locatorArray = array();
            $transferArray = array();
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql2 = "SELECT DISTINCT TRANS_DATE, TRANS_NO FROM TRANS_ISSUE_MT ORDER BY TRANS_DATE";
            $result2 = oci_parse($conn, strtoupper($sql2));
            oci_execute($result2);
            while($row2 = oci_fetch_array($result2,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $transfer[] = $row2["TRANS_NO"]." - ".$row2["TRANS_DATE"];
            }
            $sql1 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_BOOK_DESC LIKE '%Internal Transfer%' OR INV_BOOK_DESC LIKE '%Transfer Issue%'";
            $result1 = oci_parse($conn, $sql1);
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $books[] = $row1["INV_BOOK_DESC"];
            }    
            $sql3 = "SELECT CODE_VALUE, CODE_DESC FROM CODE_COMBINATION_VALUES WHERE STRUCTURE_ID = 30";
            $result3 = oci_parse($conn, $sql3);
            oci_execute($result3);
            while($row3 =oci_fetch_array($result3,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $locator[] = $row3["CODE_VALUE"]." - ".strtolower($row3["CODE_DESC"]);
            }
            $counttransfer = count($transfer);
            return view('report.transfer')->with([
                "i" => 1, 
                "dep" => 0, 
                "Permission" => 0, 
                "transfer" => $transfer,
                "books" => $books,
                "locator" => $locator,
                "z" => $counttransfer, 
                "j" => $counttransfer,
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

    public function TransferLedger(Request $request)
    {
        try{
            $booksArray = array();
            $locatorArray = array();
            $transferArray = array();
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql2 = "SELECT DISTINCT TRANS_DATE, TRANS_NO FROM TRANS_ISSUE_MT ORDER BY TRANS_DATE";
            $result2 = oci_parse($conn, strtoupper($sql2));
            oci_execute($result2);
            while($row2 = oci_fetch_array($result2,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $transfer[] = $row2["TRANS_NO"]." - ".$row2["TRANS_DATE"];
            }
            $sql1 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_BOOK_DESC LIKE '%Internal Transfer%' OR INV_BOOK_DESC LIKE '%Transfer Issue%'";
            $result1 = oci_parse($conn, $sql1);
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $books[] = $row1["INV_BOOK_DESC"];
            }    
            $sql3 = "SELECT CODE_VALUE, CODE_DESC FROM CODE_COMBINATION_VALUES WHERE STRUCTURE_ID = 30";
            $result3 = oci_parse($conn, $sql3);
            oci_execute($result3);
            while($row3 =oci_fetch_array($result3,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $locator[] = $row3["CODE_VALUE"]." - ".strtolower($row3["CODE_DESC"]);
            }
            $counttransfer = count($transfer);
            return view('report.transferledger')->with([
                "i" => 1, 
                "dep" => 0, 
                "Permission" => 0, 
                "transfer" => $transfer,
                "books" => $books,
                "locator" => $locator,
                "z" => $counttransfer, 
                "j" => $counttransfer,
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

    public function TransferLedgerDownload(Request $request)
    {   
        try{
            date_default_timezone_set("Asia/karachi");
            $date = date("d-m-Y");
            $lineData = array();
            $books = $request->books;
            $transfer = $request->transfer;
            $daterange = $request->daterange;
            $reference = $request->reference;
            $from_locator = $request->from_locator;
            $to_locator = $request->to_locator;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("d-m-Y", strtotime(substr($daterange, 0,10)));
            $enddte = date("d-m-Y", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);
            if(!empty($books)){
                $book = $books;
            }else{
                $book = $books;
            }
            if(!empty($transfer)){
                $transno = $transfer;
            }else{
                $transno = "";
            }
            if(!empty($from_locator)){
                $fromloc = $from_locator;
            }else{
                $fromloc = "";
            }
            if(!empty($to_locator)){
                $toloc = $to_locator;
            }else{
                $toloc = "";
            }
            if(!empty($strtdte2)){
                $strtdte = $strtdte2;
            }else{
                $strtdte = "";
            }
            if(!empty($enddte2)){
                $enddte = $enddte2;
            }else{
                $enddte = "";
            }
            if(!empty($reference)){
                $refno = $reference;
            }else{
                $refno = "";
            }

            $fromloc1 = explode(" ", $fromloc);
            $toloc1 = explode(" ", $toloc);
            $transno1 = explode(" ", $transfer);    

            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql1 = "SELECT TIM.TRANS_NO, TIM.TRANS_DATE, IBM.INV_BOOK_DESC, IM.ITEM_CODE, IM.ITEM_DESC, TIM.REF_NO,CCV.CODE_VALUE, TID.REMARKS, COALESCE(TID.SECONDARY_QTY, 0) AS VAL, TID.PIRMARY_QTY, TID.AMOUNT, WUM.UOM_SHORT_DESC,TIM.REMARKS AS DETREMARKS, CCV.CODE_VALUE AS FLOC, CCV1.CODE_VALUE AS TLOC
                        FROM TRANS_ISSUE_MT TIM 
                        JOIN TRANS_ISSUE_DETAIL TID ON TIM.ISS_TRANS_ID = TID.ISS_TRANS_ID AND TIM.TRANS_NO LIKE NVL('$transno1[0]','%') AND TIM.REF_NO LIKE NVL('$refno','%') 
                        AND TIM.TRANS_DATE BETWEEN '$strtdte2' AND '$enddte2'
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = TIM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('','%')
                        JOIN ITEMS_MT IM ON IM.ITEM_ID = TID.ITEM_ID
                        JOIN WIZ_UOM_MT WUM ON WUM.UOM_ID = TID.UOM_ID                    
                        JOIN CODE_COMBINATION_VALUES CCV ON TID.FROM_CODE_COMB_ID = CCV.CODE_COMBINATION_ID  
                        JOIN CODE_COMBINATION_VALUES CCV1 ON TID.TO_CODE_COMB_ID = CCV1.CODE_COMBINATION_ID AND CCV1.CODE_VALUE = '$fromloc1[0]'                

                    UNION
            
                    SELECT TIM.TRANS_NO, TIM.TRANS_DATE, IBM.INV_BOOK_DESC, IM.ITEM_CODE, IM.ITEM_DESC, TIM.REF_NO,CCV.CODE_VALUE, TID.REMARKS, COALESCE(TID.SECONDARY_QTY, 1) AS VAL, TID.PIRMARY_QTY, TID.AMOUNT, WUM.UOM_SHORT_DESC,TIM.REMARKS AS DETREMARKS, CCV.CODE_VALUE AS FLOC, CCV1.CODE_VALUE AS TLOC
                        FROM TRANS_ISSUE_MT TIM 
                        JOIN TRANS_ISSUE_DETAIL TID ON TIM.ISS_TRANS_ID = TID.ISS_TRANS_ID AND TIM.TRANS_NO LIKE NVL('$transno1[0]','%') AND TIM.REF_NO LIKE NVL('$refno','%') 
                        AND TIM.TRANS_DATE BETWEEN '$strtdte2' AND '$enddte2'
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = TIM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('','%')
                        JOIN ITEMS_MT IM ON IM.ITEM_ID = TID.ITEM_ID
                        JOIN WIZ_UOM_MT WUM ON WUM.UOM_ID = TID.UOM_ID                    
                        JOIN CODE_COMBINATION_VALUES CCV ON TID.FROM_CODE_COMB_ID = CCV.CODE_COMBINATION_ID AND CCV.CODE_VALUE = '$fromloc1[0]'   
                        JOIN CODE_COMBINATION_VALUES CCV1 ON TID.TO_CODE_COMB_ID = CCV1.CODE_COMBINATION_ID            
                        ORDER BY ITEM_CODE";

            $result11 = oci_parse($conn,$sql1);
            oci_execute($result11);                                                                            
            while($row = oci_fetch_array($result11,  OCI_ASSOC+OCI_RETURN_NULLS)){
                if($row["VAL"] == 0){
                    $store = $row["PIRMARY_QTY"];
                    $store1 = "";
                }
                elseif($row["VAL"] == 1){
                    $store = "";
                    $store1 = $row["PIRMARY_QTY"];
                }
                $lineData[] = array(
                    'Trans Date' => $row['TRANS_DATE'],
                    'Trans No' => $row['TRANS_NO'],
                    'From' => $row['FLOC'],
                    'To' => $row['TLOC'],
                    'Item Code' => $row['ITEM_CODE'],
                    'Item Description' => $row['ITEM_DESC'],
                    'Reference' => $row['REF_NO'],
                    'Remarks' => $row['REMARKS'],
                    'Det Remarks' => $row['DETREMARKS'],
                    'Unit' => $row['UOM_SHORT_DESC'],
                    'In' => $store,
                    'Out' => $store1,
                    'Rate' => round($row["AMOUNT"]/$row["PIRMARY_QTY"],2),
                    'Amount' => number_format($row["AMOUNT"],2),
                );
            }              
            return Excel::download(new TransferLedger($lineData), 'Transfer Ledger Report '.$date.'.xlsx');
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function TransferLedgerDisplay(Request $request)
    {       
        try{
            $rate2 = 0;
            $data = array();
            $transfersArray = array();
            $booksArray = array();
            $locatorArray = array();
            $sum_rate = $sum_qty = $sum_amount = 0;
            $books = $request->books;
            $transfer = $request->transfer;
            $daterange = $request->daterange;
            $reference = $request->reference;
            $from_locator = $request->from_locator;
            $to_locator = $request->to_locator;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("d-m-Y", strtotime(substr($daterange, 0,10)));
            $enddte = date("d-m-Y", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);
            if(!empty($books)){
                $book = $books;
            }else{
                $book = $books;
            }
            if(!empty($transfer)){
                $transno = $transfer;
            }else{
                $transno = "";
            }
            if(!empty($from_locator)){
                $fromloc = $from_locator;
            }else{
                $fromloc = "";
            }
            if(!empty($to_locator)){
                $toloc = $to_locator;
            }else{
                $toloc = "";
            }
            if(!empty($strtdte2)){
                $strtdte = $strtdte2;
            }else{
                $strtdte = "";
            }
            if(!empty($enddte2)){
                $enddte = $enddte2;
            }else{
                $enddte = "";
            }
            if(!empty($reference)){
                $refno = $reference;
            }else{
                $refno = "";
            }

            $fromloc1 = explode(" ", $fromloc);
            $toloc1 = explode(" ", $toloc);
            $transno1 = explode(" ", $transfer);    
            
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql2 = "SELECT DISTINCT TRANS_DATE, TRANS_NO FROM TRANS_ISSUE_MT ORDER BY TRANS_DATE";
            $result2 = oci_parse($conn, strtoupper($sql2));
            oci_execute($result2);
            while($row2 = oci_fetch_array($result2,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $transfersArray[] = $row2["TRANS_NO"]." - ".$row2["TRANS_DATE"];
            }
            $sql1 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_BOOK_DESC LIKE '%Internal Transfer%' OR INV_BOOK_DESC LIKE '%Transfer Issue%'";
            $result1 = oci_parse($conn, $sql1);
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $booksArray[] = $row1["INV_BOOK_DESC"];
            }    
            $sql3 = "SELECT CODE_VALUE, CODE_DESC FROM CODE_COMBINATION_VALUES WHERE STRUCTURE_ID = 30";
            $result3 = oci_parse($conn, $sql3);
            oci_execute($result3);
            while($row3 =oci_fetch_array($result3,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $locatorArray[] = $row3["CODE_VALUE"]." - ".strtolower($row3["CODE_DESC"]);
            }

            $sql14 = "SELECT TIM.TRANS_NO, TIM.TRANS_DATE, IBM.INV_BOOK_DESC, IM.ITEM_CODE, IM.ITEM_DESC, TIM.REF_NO,CCV.CODE_VALUE, TID.REMARKS, COALESCE(TID.SECONDARY_QTY, 0) AS VAL, TID.PIRMARY_QTY, TID.AMOUNT, WUM.UOM_SHORT_DESC,TIM.REMARKS AS DETREMARKS, CCV.CODE_VALUE AS FLOC, CCV1.CODE_VALUE AS TLOC
                        FROM TRANS_ISSUE_MT TIM 
                        JOIN TRANS_ISSUE_DETAIL TID ON TIM.ISS_TRANS_ID = TID.ISS_TRANS_ID AND TIM.TRANS_NO LIKE NVL('$transno1[0]','%') AND TIM.REF_NO LIKE NVL('$refno','%') 
                        AND TIM.TRANS_DATE BETWEEN '$strtdte2' AND '$enddte2'
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = TIM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('','%')
                        JOIN ITEMS_MT IM ON IM.ITEM_ID = TID.ITEM_ID
                        JOIN WIZ_UOM_MT WUM ON WUM.UOM_ID = TID.UOM_ID                    
                        JOIN CODE_COMBINATION_VALUES CCV ON TID.FROM_CODE_COMB_ID = CCV.CODE_COMBINATION_ID  
                        JOIN CODE_COMBINATION_VALUES CCV1 ON TID.TO_CODE_COMB_ID = CCV1.CODE_COMBINATION_ID AND CCV1.CODE_VALUE LIKE NVL('$fromloc1[0]','%')               

                    UNION
            
                    SELECT TIM.TRANS_NO, TIM.TRANS_DATE, IBM.INV_BOOK_DESC, IM.ITEM_CODE, IM.ITEM_DESC, TIM.REF_NO,CCV.CODE_VALUE, TID.REMARKS, COALESCE(TID.SECONDARY_QTY, 1) AS VAL, TID.PIRMARY_QTY, TID.AMOUNT, WUM.UOM_SHORT_DESC,TIM.REMARKS AS DETREMARKS, CCV.CODE_VALUE AS FLOC, CCV1.CODE_VALUE AS TLOC
                        FROM TRANS_ISSUE_MT TIM 
                        JOIN TRANS_ISSUE_DETAIL TID ON TIM.ISS_TRANS_ID = TID.ISS_TRANS_ID AND TIM.TRANS_NO LIKE NVL('$transno1[0]','%') AND TIM.REF_NO LIKE NVL('$refno','%') 
                        AND TIM.TRANS_DATE BETWEEN '$strtdte2' AND '$enddte2'
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = TIM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('','%')
                        JOIN ITEMS_MT IM ON IM.ITEM_ID = TID.ITEM_ID
                        JOIN WIZ_UOM_MT WUM ON WUM.UOM_ID = TID.UOM_ID                    
                        JOIN CODE_COMBINATION_VALUES CCV ON TID.FROM_CODE_COMB_ID = CCV.CODE_COMBINATION_ID AND CCV.CODE_VALUE LIKE NVL('$fromloc1[0]','%')  
                        JOIN CODE_COMBINATION_VALUES CCV1 ON TID.TO_CODE_COMB_ID = CCV1.CODE_COMBINATION_ID            
                        ORDER BY ITEM_CODE";

            $result11 = oci_parse($conn,$sql14);
            oci_execute($result11);
            while($row = oci_fetch_array($result11,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $rate = $row["AMOUNT"]/$row["PIRMARY_QTY"];
                $rate2 = round($rate,2);
                $sum_qty = $sum_qty + $row["PIRMARY_QTY"];
                $sum_amount = $sum_amount + $row["AMOUNT"];
                $sum_rate = $sum_rate + $rate2;
                $data[] = $row;
            }

            $strtdte2 = date("m/d/Y", strtotime(substr($daterange, 0,10)));
            $strtdte3 = date("m/d/Y", strtotime(substr($daterange, 10)));
            $strtdte2a = date("m/d/Y", strtotime(substr($daterange, 0,10)));
            $strtdte3a = date("m/d/Y", strtotime(substr($daterange, 10)));
            $daterangeVal = wordwrap($daterange , 10 , ' ' , true );
            $counttransfer = count($transfersArray);
            $Storedaterange = $request->daterange;

            $sessionData = [
                'storebook' => $books,
                'storetransfer' => $transno,
                'storedaterange' => $daterange,
                'storereference' => $reference,
                'storefrom_locator' => $from_locator,
                'storeto_locator' => $to_locator,
                'strtdte2a' => $strtdte2a,
                'strtdte3a' => $strtdte3a,
                'Storestart' => date("d/m/Y", strtotime(substr($Storedaterange, 0,10))),
                'Storeend' => date("d/m/Y", strtotime(substr($Storedaterange, -10))),
            ];

            return view('report.transferledger')->with([
                "i" => 1, "dep" => 0, "data" => $data, "book" => $books, "rate2" => $rate2, "Permission" => 1, "refno" => $refno, "z" => $counttransfer, "j" => $counttransfer,
                "transno" => $transno, "enddte2" => $enddte2, "strtdte2" => $strtdte2, "strtdte3" => $strtdte3, "strtdte2" => $strtdte2, "to_locator" => $to_locator, "transfer" => $transfersArray,
                "from_locator" => $from_locator, "sum_qty" => number_format($sum_qty,2), "sum_rate" => number_format($sum_rate,2), "sum_amount" => number_format($sum_amount,2), "transferVal" => $transfer,
                "daterangeVal" => $daterangeVal, "referenceVal" => $reference, "from_locatorVal" => $from_locator, "to_locatorVal" => $to_locator, "booksVal" => $books, "strtdte2a" => $strtdte2a, "strtdte3a" => $strtdte3a,
                "sessionData" => $sessionData, "locator" => $locatorArray, "books" => $booksArray, "z1" => 441, "z2" => 36
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

    public function TransferReportDownload(Request $request)
    {   
        try{
            date_default_timezone_set("Asia/karachi");
            $date = date("d-m-Y");
            $lineData = array();
            $books = $request->books;
            $transfer = $request->transfer;
            $daterange = $request->daterange;
            $reference = $request->reference;
            $from_locator = $request->from_locator;
            $to_locator = $request->to_locator;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("d-m-Y", strtotime(substr($daterange, 0,10)));
            $enddte = date("d-m-Y", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);
            if(!empty($books)){
                $book = $books;
            }else{
                $book = $books;
            }
            if(!empty($transfer)){
                $transno = $transfer;
            }else{
                $transno = "";
            }
            if(!empty($from_locator)){
                $fromloc = $from_locator;
            }else{
                $fromloc = "";
            }
            if(!empty($to_locator)){
                $toloc = $to_locator;
            }else{
                $toloc = "";
            }
            if(!empty($strtdte2)){
                $strtdte = $strtdte2;
            }else{
                $strtdte = "";
            }
            if(!empty($enddte2)){
                $enddte = $enddte2;
            }else{
                $enddte = "";
            }
            if(!empty($reference)){
                $refno = $reference;
            }else{
                $refno = "";
            }

            $fromloc1 = explode(" ", $fromloc);
            $toloc1 = explode(" ", $toloc);
            $transno1 = explode(" ", $transfer);    

            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql1 = "SELECT TIM.TRANS_NO, TIM.TRANS_DATE, IBM.INV_BOOK_DESC, IM.ITEM_CODE, IM.ITEM_DESC, TIM.REF_NO,CCV.CODE_VALUE,CCV1.CODE_VALUE, TID.REMARKS,TID.PIRMARY_QTY, TID.AMOUNT, WUM.UOM_SHORT_DESC,TIM.REMARKS AS DETREMARKS, CCV.CODE_VALUE AS FLOC, CCV1.CODE_VALUE AS TLOC
                    FROM TRANS_ISSUE_MT TIM 
                    JOIN TRANS_ISSUE_DETAIL TID ON TIM.ISS_TRANS_ID = TID.ISS_TRANS_ID AND TIM.TRANS_NO LIKE NVL('$transno1[0]','%') AND TIM.REF_NO LIKE NVL('$refno','%') 
                    AND TIM.TRANS_DATE BETWEEN '$strtdte2' AND '$enddte2'
                    JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = TIM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('$book','%')
                    JOIN ITEMS_MT IM ON IM.ITEM_ID = TID.ITEM_ID
                    JOIN WIZ_UOM_MT WUM ON WUM.UOM_ID = TID.UOM_ID
                    JOIN CODE_COMBINATION_VALUES CCV ON TID.FROM_CODE_COMB_ID = CCV.CODE_COMBINATION_ID AND CCV.CODE_VALUE LIKE NVL('$fromloc1[0]','%')
                    JOIN CODE_COMBINATION_VALUES CCV1 ON TID.TO_CODE_COMB_ID = CCV1.CODE_COMBINATION_ID AND CCV1.CODE_VALUE LIKE NVL('$toloc1[0]','%')              
                    ORDER BY TIM.Trans_Date";
            $result11 = oci_parse($conn,$sql1);
            oci_execute($result11);
            while($row = oci_fetch_array($result11,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $lineData[] = array(
                    'Trans Date' => $row['TRANS_DATE'],
                    'Trans No' => $row['TRANS_NO'],
                    'From' => $row['FLOC'],
                    'To' => $row['TLOC'],
                    'Item Code' => $row['ITEM_CODE'],
                    'Item Description' => $row['ITEM_DESC'],
                    'Reference' => $row['REF_NO'],
                    'Remarks' => $row['REMARKS'],
                    'Det Remarks' => $row['DETREMARKS'],
                    'Unit' => $row['UOM_SHORT_DESC'],
                    'Quantity' => $row['PIRMARY_QTY'],
                    'Rate' => round($row["AMOUNT"]/$row["PIRMARY_QTY"],2),
                    'Amount' => number_format($row["AMOUNT"],2),
                );
            }              
            return Excel::download(new Transfer($lineData), 'Transfer Issue Report '.$date.'.xlsx');
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function TransferReportDisplay(Request $request)
    {        
        try{
            $rate2 = 0;
            $data = array();
            $transfersArray = array();
            $booksArray = array();
            $locatorArray = array();
            $sum_rate = $sum_qty = $sum_amount = 0;
            $books = $request->books;
            $transfer = $request->transfer;
            $daterange = $request->daterange;
            $reference = $request->reference;
            $from_locator = $request->from_locator;
            $to_locator = $request->to_locator;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("d-m-Y", strtotime(substr($daterange, 0,10)));
            $enddte = date("d-m-Y", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);
            if(!empty($books)){
                $book = $books;
            }else{
                $book = $books;
            }
            if(!empty($transfer)){
                $transno = $transfer;
            }else{
                $transno = "";
            }
            if(!empty($from_locator)){
                $fromloc = $from_locator;
            }else{
                $fromloc = "";
            }
            if(!empty($to_locator)){
                $toloc = $to_locator;
            }else{
                $toloc = "";
            }
            if(!empty($strtdte2)){
                $strtdte = $strtdte2;
            }else{
                $strtdte = "";
            }
            if(!empty($enddte2)){
                $enddte = $enddte2;
            }else{
                $enddte = "";
            }
            if(!empty($reference)){
                $refno = $reference;
            }else{
                $refno = "";
            }

            $fromloc1 = explode(" ", $fromloc);
            $toloc1 = explode(" ", $toloc);
            $transno1 = explode(" ", $transfer);    
            
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql2 = "SELECT DISTINCT TRANS_DATE, TRANS_NO FROM TRANS_ISSUE_MT ORDER BY TRANS_DATE";
            $result2 = oci_parse($conn, strtoupper($sql2));
            oci_execute($result2);
            while($row2 = oci_fetch_array($result2,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $transfersArray[] = $row2["TRANS_NO"]." - ".$row2["TRANS_DATE"];
            }
            $sql1 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_BOOK_DESC LIKE '%Internal Transfer%' OR INV_BOOK_DESC LIKE '%Transfer Issue%'";
            $result1 = oci_parse($conn, $sql1);
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $booksArray[] = $row1["INV_BOOK_DESC"];
            }    
            $sql3 = "SELECT CODE_VALUE, CODE_DESC FROM CODE_COMBINATION_VALUES WHERE STRUCTURE_ID = 30";
            $result3 = oci_parse($conn, $sql3);
            oci_execute($result3);
            while($row3 =oci_fetch_array($result3,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $locatorArray[] = $row3["CODE_VALUE"]." - ".strtolower($row3["CODE_DESC"]);
            }
            $sql14 = "SELECT TIM.TRANS_NO, TIM.TRANS_DATE, IBM.INV_BOOK_DESC, IM.ITEM_CODE, IM.ITEM_DESC, TIM.REF_NO,CCV.CODE_VALUE,CCV1.CODE_VALUE, TID.REMARKS,TID.PIRMARY_QTY, TID.AMOUNT, WUM.UOM_SHORT_DESC,TIM.REMARKS AS DETREMARKS, CCV.CODE_VALUE AS FLOC, CCV1.CODE_VALUE AS TLOC
                    FROM TRANS_ISSUE_MT TIM 
                    JOIN TRANS_ISSUE_DETAIL TID ON TIM.ISS_TRANS_ID = TID.ISS_TRANS_ID AND TIM.TRANS_NO LIKE NVL('$transno1[0]','%') AND TIM.REF_NO LIKE NVL('$refno','%') 
                    AND TIM.TRANS_DATE BETWEEN '$strtdte2' AND '$enddte2'
                    JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = TIM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('$book','%')
                    JOIN ITEMS_MT IM ON IM.ITEM_ID = TID.ITEM_ID
                    JOIN WIZ_UOM_MT WUM ON WUM.UOM_ID = TID.UOM_ID
                    JOIN CODE_COMBINATION_VALUES CCV ON TID.FROM_CODE_COMB_ID = CCV.CODE_COMBINATION_ID AND CCV.CODE_VALUE LIKE NVL('$fromloc1[0]','%')
                    JOIN CODE_COMBINATION_VALUES CCV1 ON TID.TO_CODE_COMB_ID = CCV1.CODE_COMBINATION_ID AND CCV1.CODE_VALUE LIKE NVL('$toloc1[0]','%')              
                    ORDER BY TIM.Trans_Date";
            $result11 = oci_parse($conn,$sql14);
            oci_execute($result11);
            while($row = oci_fetch_array($result11,  OCI_ASSOC+OCI_RETURN_NULLS)) {
                $rate = $row["AMOUNT"]/$row["PIRMARY_QTY"];
                $rate2 = round($rate,2);
                $sum_qty = $sum_qty + $row["PIRMARY_QTY"];
                $sum_amount = $sum_amount + $row["AMOUNT"];
                $sum_rate = $sum_rate + $rate2;
                $data[] = $row;
            }
            $strtdte2 = date("m/d/Y", strtotime(substr($daterange, 0,10)));
            $strtdte3 = date("m/d/Y", strtotime(substr($daterange, 10)));
            $strtdte2a = date("m/d/Y", strtotime(substr($daterange, 0,10)));
            $strtdte3a = date("m/d/Y", strtotime(substr($daterange, 10)));
            $daterangeVal = wordwrap($daterange , 10 , ' ' , true );
            $counttransfer = count($transfersArray);
            $Storedaterange = $request->daterange;

            $sessionData = [
                'storebook' => $books,
                'storetransfer' => $transno,
                'storedaterange' => $daterange,
                'storereference' => $reference,
                'storefrom_locator' => $from_locator,
                'storeto_locator' => $to_locator,
                'strtdte2a' => $strtdte2a,
                'strtdte3a' => $strtdte3a,
                'Storestart' => date("d/m/Y", strtotime(substr($Storedaterange, 0,10))),
                'Storeend' => date("d/m/Y", strtotime(substr($Storedaterange, -10))),
            ];

            return view('report.transfer')->with([
                "i" => 1, "dep" => 0, "data" => $data, "book" => $books, "rate2" => $rate2, "Permission" => 1, "refno" => $refno, "z" => $counttransfer, "j" => $counttransfer,
                "transno" => $transno, "enddte2" => $enddte2, "strtdte2" => $strtdte2, "strtdte3" => $strtdte3, "strtdte2" => $strtdte2, "to_locator" => $to_locator, "transfer" => $transfersArray,
                "from_locator" => $from_locator, "sum_qty" => number_format($sum_qty,2), "sum_rate" => number_format($sum_rate,2), "sum_amount" => number_format($sum_amount,2), "transferVal" => $transfer,
                "daterangeVal" => $daterangeVal, "referenceVal" => $reference, "from_locatorVal" => $from_locator, "to_locatorVal" => $to_locator, "booksVal" => $books, "strtdte2a" => $strtdte2a, "strtdte3a" => $strtdte3a,
                "sessionData" => $sessionData, "locator" => $locatorArray, "books" => $booksArray,
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

    public function Helpdesk(Request $request)
    {
        try{
            $departments = Department::orderBy('name','ASC')->get();
            $user = User::orderBy('name','ASC')->get();
            $category = Category::orderBy('category','ASC')->get();
            $operator = Support::orderBy('approve_by','ASC')->where('approve_by', '!=', NULL)->get()->unique('approve_by');
            $permission = 0;
            return view('report.helpdesk',compact('departments','user','permission','category','operator'));
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function HelpdeskReportDownload(Request $request)
    {   
        try{
            date_default_timezone_set("Asia/karachi");
            $date = date("d-m-Y");
            $permission = 1;
            $present = array();
            $support = array();
            $sessionData = array();
            $supportData = array();
            $Storedepartment = $request->department;
            $Storeuser = $request->user;
            $Storestatus = $request->status;
            $Storedaterange = $request->daterange;
            $Storecategory = $request->category;
            $Storeoperator = $request->operator;
            $start = date("Y-m-d", strtotime(substr($Storedaterange, 0,10)));
            $end = date("Y-m-d", strtotime(substr($Storedaterange, -10)));
            $user = User::orderBy('name','ASC')->get();
            $departments = Department::orderBy('name','ASC')->get();
            $category = Category::orderBy('category','ASC')->get();
            $thedate = $request->daterange;
            $operator = Support::orderBy('approve_by','ASC')->where('approve_by', '!=', NULL)->get()->unique('approve_by');
            $data = User::orderBy('id','DESC')->where('department', $request->department)->pluck('id');         
            if($request->department == 'none' || $request->department == 'All' && $request->status == null && $request->user != 'none'){
                $usernName = User::orderBy('name','ASC')->where('id', $request->user)->pluck('emp_name');
                $Storeuser = $usernName[0];
                $Storedepartment = "-";
                if($request->category != 'none' && $request->operator != 'none'){
                    $support = Support::orderBy('id','DESC')->where('approve_by', $request->operator)->where('category', $request->category)->whereBetween('created_at', [$start, $end])->where('userid', $request->user)->get();
                }
                elseif($request->category == 'none' && $request->operator == 'none'){
                    $support = Support::orderBy('id','DESC')->whereBetween('created_at', [$start, $end])->where('userid', $request->user)->get();
                }
                elseif($request->category == 'none' && $request->operator != 'none'){
                    $support = Support::orderBy('id','DESC')->where('approve_by', $request->operator)->whereBetween('created_at', [$start, $end])->where('userid', $request->user)->get();
                }
                elseif($request->category != 'none' && $request->operator == 'none'){
                    $support = Support::orderBy('id','DESC')->where('category', $request->category)->whereBetween('created_at', [$start, $end])->where('userid', $request->user)->get();
                }
            }   
            elseif($request->department == 'none' || $request->department == 'All' && $request->status == null && $request->user == 'none' && $request->category != 'none'){
                $support = Support::orderBy('id','DESC')->where('category', $request->category)->whereBetween('created_at', [$start, $end])->get();
            }
            elseif($request->department == 'none' || $request->department == 'All' && $request->status == null && $request->user == 'none' && $request->operator != 'none'){
                $support = Support::orderBy('id','DESC')->where('approve_by', $request->operator)->whereBetween('created_at', [$start, $end])->get();
            } 
            elseif($request->department == 'none' || $request->department == 'All' && $request->status == null && $request->user == 'none' && $request->category == 'none' && $request->operator == 'none'){
                $support = Support::orderBy('id','DESC')->whereBetween('created_at', [$start, $end])->get();
            }   
            elseif($request->department == 'All' && $request->status != null && $request->user != 'none'){
                if($request->category != 'none' && $request->operator != 'none'){
                    $support = Support::orderBy('id','DESC')->where('approve_by', $request->operator)->where('category', $request->category)->where('userid', $request->user)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                }
                elseif($request->category == 'none' && $request->operator == 'none'){
                    $support = Support::orderBy('id','DESC')->where('userid', $request->user)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();;
                }
                elseif($request->category == 'none' && $request->operator != 'none'){
                    $support = Support::orderBy('id','DESC')->where('approve_by', $request->operator)->where('userid', $request->user)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                }
                elseif($request->category != 'none' && $request->operator == 'none'){
                    $support = Support::orderBy('id','DESC')->where('category', $request->category)->where('userid', $request->user)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                }
            }
            elseif($request->department == null || $request->department == 'All' && $request->user == 'none' && $request->status != null){
                $Storeuser = "-";
                if($request->category != 'none' && $request->operator != 'none'){
                    $support = Support::orderBy('id','DESC')->where('approve_by', $request->operator)->where('category', $request->category)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                }
                elseif($request->category == 'none' && $request->operator == 'none'){
                    $support = Support::orderBy('id','DESC')->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                }
                elseif($request->category == 'none' && $request->operator != 'none'){
                    $support = Support::orderBy('id','DESC')->where('approve_by', $request->operator)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                }
                elseif($request->category != 'none' && $request->operator == 'none'){
                    $support = Support::orderBy('id','DESC')->where('category', $request->category)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                }
            }
            elseif($request->department != 'All' && $request->status != null){
                $Storedepartment = $request->department;
                $Storeuser = "-";
                foreach($data as $key){
                    if($request->category != 'none' && $request->operator != 'none'){
                        $support1 = Support::orderBy('id','DESC')->where('approve_by', $request->operator)->where('category', $request->category)->where('userid', $request->user)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                    }
                    elseif($request->category == 'none' && $request->operator == 'none'){
                        $support1 = Support::orderBy('id','DESC')->where('userid', $request->user)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                    }
                    elseif($request->category == 'none' && $request->operator != 'none'){
                        $support1 = Support::orderBy('id','DESC')->where('approve_by', $request->operator)->where('userid', $request->user)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                    }
                    elseif($request->category != 'none' && $request->operator == 'none'){
                        $support1 = Support::orderBy('id','DESC')->where('category', $request->category)->where('userid', $request->user)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                    }
                    if(count($support1)>0){
                        $present[] = $support1;        
                    }
                }
                for($z=0; $z<count($present); $z++){
                    foreach($present[$z] as $data){
                        $support[] = $data; 
                    }
                }
            }
            elseif($request->department != 'All' && $request->user != null && $request->user != 'none'){
                if($request->category != 'none'){
                    $support = Support::orderBy('id','DESC')->where('category', $request->category)->where('userid', $request->user)->whereBetween('created_at', [$start, $end])->get();
                }
                elseif($request->category == 'none'){
                    $support = Support::orderBy('id','DESC')->where('userid', $request->user)->whereBetween('created_at', [$start, $end])->get();
                }
            }
            elseif($request->department != 'All' && $request->user != null && $request->user != 'none' && $request->category == 'none'){
                $support = Support::orderBy('id','DESC')->where('userid', $request->user)->whereBetween('created_at', [$start, $end])->get();
            }
            elseif($request->department != 'All' && $request->user == 'All'){
                $Storeuser = "-";
                foreach($data as $key){
                    $support1 = Support::orderBy('id','DESC')->where('userid', $key)->whereBetween('created_at', [$start, $end])->get();
                    if(count($support1)>0){
                        $present[] = $support1;        
                    }
                }
                for($z=0; $z<count($present); $z++){
                    foreach($present[$z] as $data){
                        $support[] = $data; 
                    }
                }
            }
            elseif($request->department != 'All'){
                foreach($data as $key){
                    if($request->status != null){
                        if($request->category != 'none' && $request->operator != 'none'){
                            $result = Support::orderBy('id','DESC')->where('approve_by', $request->operator)->where('category', $request->category)->where('category', $request->category)->where('userid', $key)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                        }
                        elseif($request->category == 'none' && $request->operator == 'none'){
                            $result = Support::orderBy('id','DESC')->where('userid', $key)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                        }
                        elseif($request->category == 'none' && $request->operator != 'none'){
                            $result = Support::orderBy('id','DESC')->where('approve_by', $request->operator)->where('category', $request->category)->where('userid', $key)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                        }
                        elseif($request->category != 'none' && $request->operator == 'none'){
                            $result = Support::orderBy('id','DESC')->where('category', $request->category)->where('userid', $key)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                        }
                    }   
                    else{
                        if($request->category != 'none' && $request->operator != 'none'){
                            $result = Support::orderBy('id','DESC')->where('approve_by', $request->operator)->where('category', $request->category)->where('category', $request->category)->where('userid', $key)->whereBetween('created_at', [$start, $end])->get();
                        }
                        elseif($request->category == 'none' && $request->operator == 'none'){
                            $result = Support::orderBy('id','DESC')->where('userid', $key)->whereBetween('created_at', [$start, $end])->get();
                        }
                        elseif($request->category == 'none' && $request->operator != 'none'){
                            $result = Support::orderBy('id','DESC')->where('approve_by', $request->operator)->where('userid', $key)->whereBetween('created_at', [$start, $end])->get();
                        }
                        elseif($request->category != 'none' && $request->operator == 'none'){
                            $result = Support::orderBy('id','DESC')->where('category', $request->category)->where('userid', $key)->whereBetween('created_at', [$start, $end])->get();
                        }
                    }            
                    if(count($result)>0){
                        $present[] = $result;        
                    }
                }
                for($z=0; $z<count($present); $z++){
                    foreach($present[$z] as $data){
                        $support[] = $data; 
                    }
                }
            }
            else{
                $support = Support::orderBy('id','DESC')->get();
            }
            if(!empty($support)){
                foreach($support as $data){
                    $department = User::orderBy('id','DESC')->limit(1)->where('id', $data['userid'])->get();
                    if(isset($department[0])){
                        $supportData[] = [
                            'department' => $department[0]->department,
                            'name' => $department[0]->emp_name,
                            'data' => $data
                        ]; 
                    }
                }
            }

            foreach($supportData as $data){
                $created_at = $data['data']['created_at']->format('d-M-Y g:i A'); 
                if($data['data']['updated_at'] == NULL){
                    if(!empty($data['data']['update_time'])){
                        $updated_at = $data['data']['update_time'];
                    }else{
                        $updated_at = "-";
                    }
                }
                else{
                    if(!empty($data['data']['updated_at'])){
                        $updated_at = $data['data']['updated_at']->format('d-M-Y g:i A');
                    }else{
                        $updated_at = "-";
                    }
                }

                $lineData[] = array(
                    'Complaint No' => $data['data']['id'],
                    'Employee' => $data['name'],
                    'Department' => $data['department'],
                    'Category' => $data['data']['category'],
                    'Sub Category' => $data['data']['subcategory'],
                    'Status' => $data['data']['status'],
                    'Date & Time' => $created_at,
                    'Operator' => $data['data']['approve_by'],
                    'Closing Date' => $updated_at,
                );
            }
            return Excel::download(new Helpdesk($lineData), 'Help Desk Report '.$date.'.xlsx');
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function HelpdeskReportDisplay(Request $request)
    {        
        try{
            $permission = 1;
            $present = array();
            $support = array();
            $sessionData = array();
            $supportData = array();
            $Storedepartment = $request->department;
            $Storeuser = $request->user;
            $Storestatus = $request->status;
            $Storedaterange = $request->daterange;
            $Storecategory = $request->category;
            $Storeoperator = $request->operator;
            $start = date("Y-m-d", strtotime(substr($Storedaterange, 0,10)));
            $end = date("Y-m-d", strtotime(substr($Storedaterange, -10)));
            $user = User::orderBy('name','ASC')->get();
            $departments = Department::orderBy('name','ASC')->get();
            $category = Category::orderBy('category','ASC')->get();
            $thedate = $request->daterange;
            $operator = Support::orderBy('approve_by','ASC')->where('approve_by', '!=', NULL)->get()->unique('approve_by');
            $data = User::orderBy('id','DESC')->where('department', $request->department)->pluck('id');         
            if($request->department == 'none' || $request->department == 'All' && $request->status == null && $request->user != 'none'){
                $usernName = User::orderBy('name','ASC')->where('id', $request->user)->pluck('emp_name');
                $Storeuser = $usernName[0];
                $Storedepartment = "-";
                if($request->category != 'none' && $request->operator != 'none'){
                    $support = Support::orderBy('id','DESC')->where('approve_by', $request->operator)->where('category', $request->category)->whereBetween('created_at', [$start, $end])->where('userid', $request->user)->get();
                }
                elseif($request->category == 'none' && $request->operator == 'none'){
                    $support = Support::orderBy('id','DESC')->whereBetween('created_at', [$start, $end])->where('userid', $request->user)->get();
                }
                elseif($request->category == 'none' && $request->operator != 'none'){
                    $support = Support::orderBy('id','DESC')->where('approve_by', $request->operator)->whereBetween('created_at', [$start, $end])->where('userid', $request->user)->get();
                }
                elseif($request->category != 'none' && $request->operator == 'none'){
                    $support = Support::orderBy('id','DESC')->where('category', $request->category)->whereBetween('created_at', [$start, $end])->where('userid', $request->user)->get();
                }
            }   
            elseif($request->department == 'none' || $request->department == 'All' && $request->status == null && $request->user == 'none' && $request->category != 'none'){
                $support = Support::orderBy('id','DESC')->where('category', $request->category)->whereBetween('created_at', [$start, $end])->get();
            }
            elseif($request->department == 'none' || $request->department == 'All' && $request->status == null && $request->user == 'none' && $request->operator != 'none'){
                $support = Support::orderBy('id','DESC')->where('approve_by', $request->operator)->whereBetween('created_at', [$start, $end])->get();
            } 
            elseif($request->department == 'none' || $request->department == 'All' && $request->status == null && $request->user == 'none' && $request->category == 'none' && $request->operator == 'none'){
                $support = Support::orderBy('id','DESC')->whereBetween('created_at', [$start, $end])->get();
            }   
            elseif($request->department == 'All' && $request->status != null && $request->user != 'none'){
                if($request->category != 'none' && $request->operator != 'none'){
                    $support = Support::orderBy('id','DESC')->where('approve_by', $request->operator)->where('category', $request->category)->where('userid', $request->user)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                }
                elseif($request->category == 'none' && $request->operator == 'none'){
                    $support = Support::orderBy('id','DESC')->where('userid', $request->user)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();;
                }
                elseif($request->category == 'none' && $request->operator != 'none'){
                    $support = Support::orderBy('id','DESC')->where('approve_by', $request->operator)->where('userid', $request->user)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                }
                elseif($request->category != 'none' && $request->operator == 'none'){
                    $support = Support::orderBy('id','DESC')->where('category', $request->category)->where('userid', $request->user)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                }
            }
            elseif($request->department == null || $request->department == 'All' && $request->user == 'none' && $request->status != null){
                $Storeuser = "-";
                if($request->category != 'none' && $request->operator != 'none'){
                    $support = Support::orderBy('id','DESC')->where('approve_by', $request->operator)->where('category', $request->category)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                }
                elseif($request->category == 'none' && $request->operator == 'none'){
                    $support = Support::orderBy('id','DESC')->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                }
                elseif($request->category == 'none' && $request->operator != 'none'){
                    $support = Support::orderBy('id','DESC')->where('approve_by', $request->operator)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                }
                elseif($request->category != 'none' && $request->operator == 'none'){
                    $support = Support::orderBy('id','DESC')->where('category', $request->category)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                }
            }
            elseif($request->department != 'All' && $request->status != null){
                $Storedepartment = $request->department;
                $Storeuser = "-";
                foreach($data as $key){
                    if($request->category != 'none' && $request->operator != 'none'){
                        $support1 = Support::orderBy('id','DESC')->where('approve_by', $request->operator)->where('category', $request->category)->where('userid', $request->user)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                    }
                    elseif($request->category == 'none' && $request->operator == 'none'){
                        $support1 = Support::orderBy('id','DESC')->where('userid', $request->user)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                    }
                    elseif($request->category == 'none' && $request->operator != 'none'){
                        $support1 = Support::orderBy('id','DESC')->where('approve_by', $request->operator)->where('userid', $request->user)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                    }
                    elseif($request->category != 'none' && $request->operator == 'none'){
                        $support1 = Support::orderBy('id','DESC')->where('category', $request->category)->where('userid', $request->user)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                    }
                    if(count($support1)>0){
                        $present[] = $support1;        
                    }
                }
                for($z=0; $z<count($present); $z++){
                    foreach($present[$z] as $data){
                        $support[] = $data; 
                    }
                }
            }
            elseif($request->department != 'All' && $request->user != null && $request->user != 'none'){
                if($request->category != 'none'){
                    $support = Support::orderBy('id','DESC')->where('category', $request->category)->where('userid', $request->user)->whereBetween('created_at', [$start, $end])->get();
                }
                elseif($request->category == 'none'){
                    $support = Support::orderBy('id','DESC')->where('userid', $request->user)->whereBetween('created_at', [$start, $end])->get();
                }
            }
            elseif($request->department != 'All' && $request->user != null && $request->user != 'none' && $request->category == 'none'){
                $support = Support::orderBy('id','DESC')->where('userid', $request->user)->whereBetween('created_at', [$start, $end])->get();
            }
            elseif($request->department != 'All' && $request->user == 'All'){
                $Storeuser = "-";
                foreach($data as $key){
                    $support1 = Support::orderBy('id','DESC')->where('userid', $key)->whereBetween('created_at', [$start, $end])->get();
                    if(count($support1)>0){
                        $present[] = $support1;        
                    }
                }
                for($z=0; $z<count($present); $z++){
                    foreach($present[$z] as $data){
                        $support[] = $data; 
                    }
                }
            }
            elseif($request->department != 'All'){
                foreach($data as $key){
                    if($request->status != null){
                        if($request->category != 'none' && $request->operator != 'none'){
                            $result = Support::orderBy('id','DESC')->where('approve_by', $request->operator)->where('category', $request->category)->where('category', $request->category)->where('userid', $key)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                        }
                        elseif($request->category == 'none' && $request->operator == 'none'){
                            $result = Support::orderBy('id','DESC')->where('userid', $key)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                        }
                        elseif($request->category == 'none' && $request->operator != 'none'){
                            $result = Support::orderBy('id','DESC')->where('approve_by', $request->operator)->where('category', $request->category)->where('userid', $key)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                        }
                        elseif($request->category != 'none' && $request->operator == 'none'){
                            $result = Support::orderBy('id','DESC')->where('category', $request->category)->where('userid', $key)->where('status', $request->status)->whereBetween('created_at', [$start, $end])->get();
                        }
                    }   
                    else{
                        if($request->category != 'none' && $request->operator != 'none'){
                            $result = Support::orderBy('id','DESC')->where('approve_by', $request->operator)->where('category', $request->category)->where('category', $request->category)->where('userid', $key)->whereBetween('created_at', [$start, $end])->get();
                        }
                        elseif($request->category == 'none' && $request->operator == 'none'){
                            $result = Support::orderBy('id','DESC')->where('userid', $key)->whereBetween('created_at', [$start, $end])->get();
                        }
                        elseif($request->category == 'none' && $request->operator != 'none'){
                            $result = Support::orderBy('id','DESC')->where('approve_by', $request->operator)->where('userid', $key)->whereBetween('created_at', [$start, $end])->get();
                        }
                        elseif($request->category != 'none' && $request->operator == 'none'){
                            $result = Support::orderBy('id','DESC')->where('category', $request->category)->where('userid', $key)->whereBetween('created_at', [$start, $end])->get();
                        }
                    }            
                    if(count($result)>0){
                        $present[] = $result;        
                    }
                }
                for($z=0; $z<count($present); $z++){
                    foreach($present[$z] as $data){
                        $support[] = $data; 
                    }
                }
            }
            else{
                $support = Support::orderBy('id','DESC')->get();
            }
            if(!empty($support)){
                foreach($support as $data){
                    $department = User::orderBy('id','DESC')->limit(1)->where('id', $data['userid'])->get();
                    if(isset($department[0])){
                        $supportData[] = [
                            'department' => $department[0]->department,
                            'name' => $department[0]->emp_name,
                            'data' => $data
                        ]; 
                    }
                }
            }
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte2a = date("m/d/Y", strtotime(substr($daterange, 0,10)));
            $strtdte3a = date("m/d/Y", strtotime(substr($daterange, 10)));
            if($request->user != 'none'){
                $usernName = User::orderBy('name','ASC')->where('id', $request->user)->pluck('emp_name');
                $Storeuser = $usernName[0];
            }
            $sessionData = [
                'department' => $Storedepartment,
                'user' => $Storeuser,
                'status' => $Storestatus,
                'start' => $start,
                'end' => $end,
                'thedate' => $thedate,
                'category' => $Storecategory,
                'operator' => $Storeoperator,
                'strtdte2a' => $strtdte2a,
                'strtdte3a' => $strtdte3a,
                'Storestart' => date("d/m/Y", strtotime(substr($Storedaterange, 0,10))),
                'Storeend' => date("d/m/Y", strtotime(substr($Storedaterange, -10))),
            ];
            return view('report.helpdesk',compact('departments','user','permission','supportData','sessionData','operator','category'));
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function Adjustment(Request $request)
    {
        try{
            $books = array(); $adjustment = array();
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql1 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_BOOK_DESC LIKE '%Item Adjustment%' OR INV_BOOK_DESC = 'Item_adjustment-SS'";
            $result1 = oci_parse($conn, $sql1);
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $books[] = $row1["INV_BOOK_DESC"];
            }    
            $sql2 = "SELECT DISTINCT ADJUSTMENT_NO FROM ITEM_ADJUSTMENT_MT ORDER BY ADJUSTMENT_NO";
            $result2 = oci_parse($conn, $sql2);
            oci_execute($result2);
            while($row2 = oci_fetch_array($result2,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $adjustment[] = $row2["ADJUSTMENT_NO"];
            }
            return view('report.adjustment')->with([
                "Permission" => 0, 
                "books" => $books,
                "adjustment" => $adjustment,
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

    public function AdjustmentReportDownload(Request $request)
    {   
        try{
            date_default_timezone_set("Asia/karachi");
            $date = date("d-m-Y");
            $rate2 = 0;
            $data = array();
            $books = array(); $adjustment = array();
            $sum_rate = $sum_qty = $sum_amount = 0;
            $status = $request->status;
            $adjustno = $request->adjustno;
            $daterange = $request->daterange;
            $book = $request->book;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("d-m-Y", strtotime(substr($daterange, 0,10)));
            $enddte = date("d-m-Y", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);

            if($status == "Posted"){
                $status = "IS NOT NULL";
            }else if($status == "UnPosted"){
                $status = "IS NULL";
            }else{
                $status = "BOTH";
            }
            if(!empty($adjustno)){
                $adjustno = $adjustno;
            }else{
                $adjustno = "";
            }
            if(!empty($book)){
                $book = $book;
            }else{
                $book = "";
            }
            if(!empty($strtdte2)){
                $strtdte = $strtdte2;
            }else{
                $strtdte = "";
            }
            if(!empty($enddte2)){
                $enddte = $enddte2;
            }else{
                $enddte = "";
            }
            
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql1 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_BOOK_DESC LIKE '%Item Adjustment%' OR INV_BOOK_DESC = 'Item_adjustment-SS'";
            $result1 = oci_parse($conn, $sql1);
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $books[] = $row1["INV_BOOK_DESC"];
            }    
            $sql2 = "SELECT DISTINCT ADJUSTMENT_NO FROM ITEM_ADJUSTMENT_MT ORDER BY ADJUSTMENT_NO";
            $result2 = oci_parse($conn, $sql2);
            oci_execute($result2);
            while($row2 = oci_fetch_array($result2,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $adjustment[] = $row2["ADJUSTMENT_NO"];
            }
            if($status == "BOTH"){
                $sql = "SELECT IBM.INV_BOOK_DESC, IAM.JOURNAL_ID, IAM.ADJUSTMENT_NO, IAM.ADJUSTMENT_DATE, IAM.REMARKS, IAD.SR_NO, IM.ITEM_CODE,IM.ITEM_DESC,
                        WUM.UOM_DESC, IAD.PRIMARY_QTY, IAD.LINE_AMOUNT, CBV.CODE_VALUE                
                        FROM ITEM_ADJUSTMENT_MT IAM                        
                        JOIN ITEM_ADJUSTMENT_DET IAD ON IAM.ITEM_ADJUSTMENT_ID = IAD.ITEM_ADJUSTMENT_ID AND IAM.ADJUSTMENT_NO LIKE NVL('$adjustno','%')
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = IAM.INV_BOOK_ID AND IBM.INV_BOOK_DESC = '$book'
                        JOIN ITEMS_MT IM ON IM.ITEM_ID = IAD.ITEM_ID AND IAM.ADJUSTMENT_DATE BETWEEN '$strtdte' AND '$enddte'
                        JOIN WIZ_UOM_MT WUM ON WUM.UOM_ID = IM.PRIMARY_UOM
                        LEFT JOIN CODE_COMBINATION_VALUES CBV ON CBV.CODE_COMBINATION_ID = IAD.CONTRA_ACC_CODE_COMB_ID                        
                        ORDER BY IAM.ADJUSTMENT_DATE";
            } 
            elseif($status == "IS NOT NULL"){
                $sql = "SELECT IBM.INV_BOOK_DESC, IAM.JOURNAL_ID, IAM.ADJUSTMENT_NO, IAM.ADJUSTMENT_DATE, IAM.REMARKS, IAD.SR_NO, IM.ITEM_CODE,IM.ITEM_DESC,
                        WUM.UOM_DESC, IAD.PRIMARY_QTY, IAD.LINE_AMOUNT, CBV.CODE_VALUE                
                        FROM ITEM_ADJUSTMENT_MT IAM                        
                        JOIN ITEM_ADJUSTMENT_DET IAD ON IAM.ITEM_ADJUSTMENT_ID = IAD.ITEM_ADJUSTMENT_ID AND IAM.JOURNAL_ID IS NOT NULL AND IAM.ADJUSTMENT_NO LIKE NVL('$adjustno','%')
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = IAM.INV_BOOK_ID AND IBM.INV_BOOK_DESC = '$book'
                        JOIN ITEMS_MT IM ON IM.ITEM_ID = IAD.ITEM_ID AND IAM.ADJUSTMENT_DATE BETWEEN '$strtdte' AND '$enddte'
                        JOIN WIZ_UOM_MT WUM ON WUM.UOM_ID = IM.PRIMARY_UOM
                        LEFT JOIN CODE_COMBINATION_VALUES CBV ON CBV.CODE_COMBINATION_ID = IAD.CONTRA_ACC_CODE_COMB_ID                        
                        ORDER BY IAM.ADJUSTMENT_DATE";
            }
            else{
                $sql = "SELECT IBM.INV_BOOK_DESC, IAM.JOURNAL_ID, IAM.ADJUSTMENT_NO, IAM.ADJUSTMENT_DATE, IAM.REMARKS, IAD.SR_NO, IM.ITEM_CODE,IM.ITEM_DESC,
                        WUM.UOM_DESC, IAD.PRIMARY_QTY, IAD.LINE_AMOUNT, CBV.CODE_VALUE                
                        FROM ITEM_ADJUSTMENT_MT IAM                        
                        JOIN ITEM_ADJUSTMENT_DET IAD ON IAM.ITEM_ADJUSTMENT_ID = IAD.ITEM_ADJUSTMENT_ID AND IAM.JOURNAL_ID IS NULL AND IAM.ADJUSTMENT_NO LIKE NVL('$adjustno','%')
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = IAM.INV_BOOK_ID AND IBM.INV_BOOK_DESC = '$book'
                        JOIN ITEMS_MT IM ON IM.ITEM_ID = IAD.ITEM_ID AND IAM.ADJUSTMENT_DATE BETWEEN '$strtdte2' AND '$enddte2'
                        JOIN WIZ_UOM_MT WUM ON WUM.UOM_ID = IM.PRIMARY_UOM
                        LEFT JOIN CODE_COMBINATION_VALUES CBV ON CBV.CODE_COMBINATION_ID = IAD.CONTRA_ACC_CODE_COMB_ID                        
                        ORDER BY IAM.ADJUSTMENT_DATE";
            }
            $result11 = oci_parse($conn,$sql);
            oci_execute($result11);
            while($row = oci_fetch_array($result11,  OCI_ASSOC+OCI_RETURN_NULLS)){
                if($row["PRIMARY_QTY"] == 0){
                    $sum_qty = $sum_qty + $row["PRIMARY_QTY"];
                    $sum_amount = $sum_amount + $row["LINE_AMOUNT"];
                } 
                else{
                    $rate = $row["LINE_AMOUNT"]/$row["PRIMARY_QTY"];
                    $sum_qty = $sum_qty + $row["PRIMARY_QTY"];
                    $sum_amount = $sum_amount + $row["LINE_AMOUNT"];
                    $sum_rate = $sum_rate + $rate;
                    $line_amount = number_format($row["LINE_AMOUNT"],2);
                }
                $lineData[] = array(
                    'Adj No' => $row['ADJUSTMENT_NO'],
                    'Adj Date' => $row['ADJUSTMENT_DATE'],
                    'Remarks' => $row['REMARKS'],
                    'SR NO' => $row['SR_NO'],
                    'Item Code' => $row['ITEM_CODE'],
                    'Item Description' => $row['ITEM_DESC'],
                    'Unit' => $row['UOM_DESC'],
                    'Quantity' => $row['PRIMARY_QTY'],
                    'Rate' => round($rate,2),
                    'Amount' => $line_amount,
                    'Contra A/C Code' => $row['CODE_VALUE'],
                );
            }
            return Excel::download(new Adjustment($lineData), 'Item Adjustment Report '.$date.'.xlsx');
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function AdjustmentReportDisplay(Request $request)
    {        
        try{
            $rate2 = 0;
            $data = array();
            $books = array(); $adjustment = array();
            $sum_rate = $sum_qty = $sum_amount = $rate = $line_amount = 0;
            $status = $request->status;
            $adjustno = $request->adjustno;
            $daterange = $request->daterange;
            $book = $request->book;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("d-m-Y", strtotime(substr($daterange, 0,10)));
            $enddte = date("d-m-Y", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $start = date("d-M-Y", strtotime(substr($daterange, 0,10)));
            $end = date("d-M-Y", strtotime(substr($daterange, -10)));
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);

            if($status == "Posted"){
                $status = "IS NOT NULL";
            }else if($status == "UnPosted"){
                $status = "IS NULL";
            }else{
                $status = "BOTH";
            }
            if(!empty($adjustno)){
                $adjustno = $adjustno;
            }else{
                $adjustno = "";
            }
            if(!empty($book)){
                $book = $book;
            }else{
                $book = "";
            }
            if(!empty($strtdte2)){
                $strtdte = $strtdte2;
            }else{
                $strtdte = "";
            }
            if(!empty($enddte2)){
                $enddte = $enddte2;
            }else{
                $enddte = "";
            }
            
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql1 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_BOOK_DESC LIKE '%Item Adjustment%' OR INV_BOOK_DESC = 'Item_adjustment-SS'";
            $result1 = oci_parse($conn, $sql1);
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $books[] = $row1["INV_BOOK_DESC"];
            }    
            $sql2 = "SELECT DISTINCT ADJUSTMENT_NO FROM ITEM_ADJUSTMENT_MT ORDER BY ADJUSTMENT_NO";
            $result2 = oci_parse($conn, $sql2);
            oci_execute($result2);
            while($row2 = oci_fetch_array($result2,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $adjustment[] = $row2["ADJUSTMENT_NO"];
            }
            if($status == "BOTH"){
                $sql = "SELECT IBM.INV_BOOK_DESC, IAM.JOURNAL_ID, IAM.ADJUSTMENT_NO, IAM.ADJUSTMENT_DATE, IAM.REMARKS, IAD.SR_NO, IM.ITEM_CODE,IM.ITEM_DESC,
                        WUM.UOM_DESC, IAD.PRIMARY_QTY, IAD.LINE_AMOUNT, CBV.CODE_VALUE                
                        FROM ITEM_ADJUSTMENT_MT IAM                        
                        JOIN ITEM_ADJUSTMENT_DET IAD ON IAM.ITEM_ADJUSTMENT_ID = IAD.ITEM_ADJUSTMENT_ID AND IAM.ADJUSTMENT_NO LIKE NVL('$adjustno','%')
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = IAM.INV_BOOK_ID AND IBM.INV_BOOK_DESC = '$book'
                        JOIN ITEMS_MT IM ON IM.ITEM_ID = IAD.ITEM_ID AND IAM.ADJUSTMENT_DATE BETWEEN '$strtdte' AND '$enddte'
                        JOIN WIZ_UOM_MT WUM ON WUM.UOM_ID = IM.PRIMARY_UOM
                        LEFT JOIN CODE_COMBINATION_VALUES CBV ON CBV.CODE_COMBINATION_ID = IAD.CONTRA_ACC_CODE_COMB_ID                        
                        ORDER BY IAM.ADJUSTMENT_DATE";
            } 
            elseif($status == "IS NOT NULL"){
                $sql = "SELECT IBM.INV_BOOK_DESC, IAM.JOURNAL_ID, IAM.ADJUSTMENT_NO, IAM.ADJUSTMENT_DATE, IAM.REMARKS, IAD.SR_NO, IM.ITEM_CODE,IM.ITEM_DESC,
                        WUM.UOM_DESC, IAD.PRIMARY_QTY, IAD.LINE_AMOUNT, CBV.CODE_VALUE                
                        FROM ITEM_ADJUSTMENT_MT IAM                        
                        JOIN ITEM_ADJUSTMENT_DET IAD ON IAM.ITEM_ADJUSTMENT_ID = IAD.ITEM_ADJUSTMENT_ID AND IAM.JOURNAL_ID IS NOT NULL AND IAM.ADJUSTMENT_NO LIKE NVL('$adjustno','%')
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = IAM.INV_BOOK_ID AND IBM.INV_BOOK_DESC = '$book'
                        JOIN ITEMS_MT IM ON IM.ITEM_ID = IAD.ITEM_ID AND IAM.ADJUSTMENT_DATE BETWEEN '$strtdte' AND '$enddte'
                        JOIN WIZ_UOM_MT WUM ON WUM.UOM_ID = IM.PRIMARY_UOM
                        LEFT JOIN CODE_COMBINATION_VALUES CBV ON CBV.CODE_COMBINATION_ID = IAD.CONTRA_ACC_CODE_COMB_ID                        
                        ORDER BY IAM.ADJUSTMENT_DATE";
            }
            else{
                $sql = "SELECT IBM.INV_BOOK_DESC, IAM.JOURNAL_ID, IAM.ADJUSTMENT_NO, IAM.ADJUSTMENT_DATE, IAM.REMARKS, IAD.SR_NO, IM.ITEM_CODE,IM.ITEM_DESC,
                        WUM.UOM_DESC, IAD.PRIMARY_QTY, IAD.LINE_AMOUNT, CBV.CODE_VALUE                
                        FROM ITEM_ADJUSTMENT_MT IAM                        
                        JOIN ITEM_ADJUSTMENT_DET IAD ON IAM.ITEM_ADJUSTMENT_ID = IAD.ITEM_ADJUSTMENT_ID AND IAM.JOURNAL_ID IS NULL AND IAM.ADJUSTMENT_NO LIKE NVL('$adjustno','%')
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = IAM.INV_BOOK_ID AND IBM.INV_BOOK_DESC = '$book'
                        JOIN ITEMS_MT IM ON IM.ITEM_ID = IAD.ITEM_ID AND IAM.ADJUSTMENT_DATE BETWEEN '$strtdte2' AND '$enddte2'
                        JOIN WIZ_UOM_MT WUM ON WUM.UOM_ID = IM.PRIMARY_UOM
                        LEFT JOIN CODE_COMBINATION_VALUES CBV ON CBV.CODE_COMBINATION_ID = IAD.CONTRA_ACC_CODE_COMB_ID                        
                        ORDER BY IAM.ADJUSTMENT_DATE";
            }
            $result11 = oci_parse($conn,$sql);
            oci_execute($result11);
            while($row = oci_fetch_array($result11,  OCI_ASSOC+OCI_RETURN_NULLS)){
                if($row["PRIMARY_QTY"] == 0){
                    $sum_qty = $sum_qty + $row["PRIMARY_QTY"];
                    $sum_amount = $sum_amount + $row["LINE_AMOUNT"];
                } 
                else{
                    $rate = $row["LINE_AMOUNT"]/$row["PRIMARY_QTY"];
                    $sum_qty = $sum_qty + $row["PRIMARY_QTY"];
                    $sum_amount = $sum_amount + $row["LINE_AMOUNT"];
                    $sum_rate = $sum_rate + $rate;
                    $line_amount = number_format($row["LINE_AMOUNT"],2);
                }
                $data[] = array(
                    'data' => $row,
                    'rate' => $rate,
                    'sum_qty' => $sum_qty, 
                    'sum_amount' => $sum_amount, 
                    'sum_rate' => $sum_rate, 
                    'line_amount' => $line_amount                
                );
            }

            $strtdte2 = date("m/d/Y", strtotime(substr($daterange, 0,10)));
            $strtdte3 = date("m/d/Y", strtotime(substr($daterange, 10)));
            $strtdte2a = date("m/d/Y", strtotime(substr($daterange, 0,10)));
            $strtdte3a = date("m/d/Y", strtotime(substr($daterange, 10)));
            $daterangeVal = wordwrap($daterange , 10 , ' ' , true );

            $sessionData = [
                'end' => $end,
                'book' => $book,
                'start' => $start,
                'adjustno' => $adjustno,
                'strtdte2a' => $strtdte2a,
                'strtdte3a' => $strtdte3a,
                'status' => $request->status,
            ];

            return view('report.adjustment')->with([
                "data" => $data, "Permission" => 1, "rate" => round($rate,2), "line_amount" => $line_amount, "books" => $books, 
                "adjustment" => $adjustment, "sum_qty" => $sum_qty, "sum_rate" => $sum_rate, "sum_amount" => $sum_amount, "sessionData" => $sessionData
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

    public function Workorder(Request $request)
    {
        try{
            $books = array(); $adjustment = array();
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql1 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_BOOK_DESC LIKE '%Item Adjustment%' OR INV_BOOK_DESC = 'Item_adjustment-SS'";
            $result1 = oci_parse($conn, $sql1);
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $books[] = $row1["INV_BOOK_DESC"];
            }    
            $sql2 = "SELECT DISTINCT ADJUSTMENT_NO FROM ITEM_ADJUSTMENT_MT ORDER BY ADJUSTMENT_NO";
            $result2 = oci_parse($conn, $sql2);
            oci_execute($result2);
            while($row2 = oci_fetch_array($result2,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $adjustment[] = $row2["ADJUSTMENT_NO"];
            }
            return view('report.workordersummary')->with([
                "Permission" => 0, 
                "books" => $books,
                "adjustment" => $adjustment,
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

    public function WorkorderReportDownload(Request $request)
    {   
        try{
            date_default_timezone_set("Asia/karachi");
            $date = date("d-m-Y");
            $rate2 = 0;
            $data = array();
            $books = array(); $adjustment = array();
            $sum_rate = $sum_qty = $sum_amount = 0;
            $workorder = $request->workorder;
            $itemtype = $request->itemtype;
            $thedate = $request->thedate;
            $report = $request->report;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("d-m-Y", strtotime(substr($daterange, 0,10)));
            $enddte = date("d-m-Y", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $start = date("d-M-Y", strtotime(substr($daterange, 0,10)));
            $end = date("d-M-Y", strtotime(substr($daterange, -10)));
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);

            if(!empty($strtdte2)){
                $strtdte2 = $strtdte2;
            }else{
                $strtdte2 = "";
            }
            if(!empty($enddte2)){
                $enddte2 = $enddte2;
            }else{
                $enddte2 = "";
            }
            if(!empty($workorder)){
               $workorder = $workorder;
            }else{
                $workorder = "";
            }
            if(!empty($itemtype)){
                if($itemtype == "insole"){
                    $var1 = 8;  
                    $var2 = 9;
                } 
                else{
                    $var1 = 14;  
                    $var2 = 15;
                }
            }
            if(!empty($workorder)){
                $workorder = explode(" || ", $workorder);            
                $worder = $workorder[0];
            }else{
                $worder = "";
            }  
            
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql1 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_BOOK_DESC LIKE '%Item Adjustment%' OR INV_BOOK_DESC = 'Item_adjustment-SS'";
            $result1 = oci_parse($conn, $sql1);
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $books[] = $row1["INV_BOOK_DESC"];
            }    
            $sql2 = "SELECT DISTINCT ADJUSTMENT_NO FROM ITEM_ADJUSTMENT_MT ORDER BY ADJUSTMENT_NO";
            $result2 = oci_parse($conn, $sql2);
            oci_execute($result2);
            while($row2 = oci_fetch_array($result2,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $adjustment[] = $row2["ADJUSTMENT_NO"];
            }
            if($report == "smry"){
                if($thedate == "pi"){
                    $sql = "SELECT OSJCM.DOC_NO AS WO_NO, OSJCM.DOC_DATE AS WO_DATE, GM.GRN_NO, GM.GRN_DATE, IM.ITEM_CODE AS ITEM_CODE, IM.ITEM_DESC AS ITEM_DESC, OSJCD.QUANTITY as WO_QTY,
                            OSJCD.CONVERSION_RATE AS WO_RATE,
                            SUM(ISD.PRIMARY_QTY) AS STORE_QTY, SUM(ISD.ISSUE_AMOUNT) AS STORE_AMOUNT,
                            GD.PRIMARY_QTY AS GRN_QTY,
                            PID.PRIMARY_QTY AS PI_QTY, PID.TC_AMOUNT AS PI_AMOUNT, PID.PRO_EXP_TC_AMOUNT AS PI_EXP_TC_AMOUNT,
                            (PID.TC_AMOUNT+PID.PRO_EXP_TC_AMOUNT) AS PI_TOTAL_AMOUNT, ISM.ISSUE_NO, ISM.ISSUE_DATE                        
                            FROM OUT_SOURCE_JOB_CARD_MT OSJCM
                            JOIN OUT_SOURCE_JOB_CARD_DET OSJCD ON OSJCD.JOB_CARD_ID = OSJCM.JOB_CARD_ID
                            JOIN ITEMS_MT IM ON IM.ITEM_ID = OSJCD.ITEM_ID
                            JOIN WIZ_ITEM_TYPE_MT WITM ON WITM.ITEM_TYPE_ID = IM.ITEM_TYPE_ID AND WITM.ITEM_TYPE_ID IN ('$var1','$var2')                        
                            LEFT JOIN GRN_DETAIL GD ON GD.JOB_CARD_DET_ID = OSJCD.JOB_CARD_DET_ID
                            LEFT JOIN GRN_MT GM ON GM.GRN_ID = GD.GRN_ID                        
                            JOIN ISSUE_MT ISM ON ISM.JOB_CARD_ID = OSJCM.JOB_CARD_ID
                            JOIN ISSUE_DETAIL ISD ON ISD.ISSUE_ID = ISM.ISSUE_ID AND ISD.JOB_CARD_DET_ID = OSJCD.JOB_CARD_DET_ID AND ISM.ISSUE_DATE BETWEEN '$strtdte2' AND '$enddte2'                        
                            LEFT JOIN PURCHASE_INVOICE_MT PIM ON PIM.JOB_CARD_ID = OSJCM.JOB_CARD_ID
                            LEFT JOIN PURCHASE_INVOICE_DETAIL PID ON PID.PURCH_INVOICE_ID = PIM.PURCH_INVOICE_ID AND PID.ITEM_ID = GD.ITEM_ID
                            WHERE OSJCM.DOC_NO LIKE NVL('$worder', '%')                
                            GROUP BY OSJCM.DOC_NO, OSJCM.DOC_DATE, IM.ITEM_CODE, IM.ITEM_DESC, OSJCD.QUANTITY , OSJCD.CONVERSION_RATE, GD.PRIMARY_QTY,
                            PID.PRIMARY_QTY, PID.TC_AMOUNT, PID.PRO_EXP_TC_AMOUNT, GM.GRN_NO, GM.GRN_DATE, ISM.ISSUE_NO, ISM.ISSUE_DATE
                            ORDER BY GM.GRN_NO";
                } 
                else{
                    $sql = "SELECT OSJCM.DOC_NO AS WO_NO, OSJCM.DOC_DATE AS WO_DATE, GM.GRN_NO, GM.GRN_DATE, IM.ITEM_CODE AS ITEM_CODE, IM.ITEM_DESC AS ITEM_DESC, OSJCD.QUANTITY as WO_QTY,
                            OSJCD.CONVERSION_RATE AS WO_RATE,
                            SUM(ISD.PRIMARY_QTY) AS STORE_QTY, SUM(ISD.ISSUE_AMOUNT) AS STORE_AMOUNT,
                            GD.PRIMARY_QTY AS GRN_QTY,
                            PID.PRIMARY_QTY AS PI_QTY, PID.TC_AMOUNT AS PI_AMOUNT, PID.PRO_EXP_TC_AMOUNT AS PI_EXP_TC_AMOUNT,
                            (PID.TC_AMOUNT+PID.PRO_EXP_TC_AMOUNT) AS PI_TOTAL_AMOUNT, ISM.ISSUE_NO, ISM.ISSUE_DATE
                            FROM OUT_SOURCE_JOB_CARD_MT OSJCM
                            JOIN OUT_SOURCE_JOB_CARD_DET OSJCD ON OSJCD.JOB_CARD_ID = OSJCM.JOB_CARD_ID
                            JOIN ITEMS_MT IM ON IM.ITEM_ID = OSJCD.ITEM_ID
                            JOIN WIZ_ITEM_TYPE_MT WITM ON WITM.ITEM_TYPE_ID = IM.ITEM_TYPE_ID AND WITM.ITEM_TYPE_ID IN ('$var1','$var2')
                            JOIN GRN_DETAIL GD ON GD.JOB_CARD_DET_ID = OSJCD.JOB_CARD_DET_ID
                            JOIN GRN_MT GM ON GM.GRN_ID = GD.GRN_ID AND GM.GRN_DATE BETWEEN '$strtdte2' AND '$enddte2'
                            LEFT JOIN ISSUE_MT ISM ON ISM.JOB_CARD_ID = OSJCM.JOB_CARD_ID AND ISM.ISSUE_DATE BETWEEN '$strtdte2' AND '$enddte2'
                            LEFT JOIN ISSUE_DETAIL ISD ON ISD.ISSUE_ID = ISM.ISSUE_ID AND ISD.JOB_CARD_DET_ID = OSJCD.JOB_CARD_DET_ID
                            LEFT JOIN PURCHASE_INVOICE_MT PIM ON PIM.JOB_CARD_ID = OSJCM.JOB_CARD_ID
                            LEFT JOIN PURCHASE_INVOICE_DETAIL PID ON PID.PURCH_INVOICE_ID = PIM.PURCH_INVOICE_ID AND PID.ITEM_ID = GD.ITEM_ID
                            WHERE OSJCM.DOC_NO LIKE NVL('$worder', '%')
                            GROUP BY OSJCM.DOC_NO, OSJCM.DOC_DATE, IM.ITEM_CODE, IM.ITEM_DESC, OSJCD.QUANTITY , OSJCD.CONVERSION_RATE, GD.PRIMARY_QTY  ,
                            PID.PRIMARY_QTY, PID.TC_AMOUNT, PID.PRO_EXP_TC_AMOUNT, GM.GRN_NO, GM.GRN_DATE, ISM.ISSUE_NO, ISM.ISSUE_DATE
                            ORDER BY GM.GRN_NO";
                }

            }
            if($report == "detail"){
                if($thedate == "pi"){
                    $sql = "SELECT OSJCM.DOC_NO AS WO_NO, OSJCM.DOC_DATE AS WO_DATE, GM.GRN_NO, GM.GRN_DATE, IM.ITEM_CODE AS ITEM_CODE, IM.ITEM_DESC AS ITEM_DESC, OSJCD.QUANTITY as WO_QTY, OSJCD.CONVERSION_RATE AS WO_RATE,
                            IMI.ITEM_CODE AS CODE, IMI.ITEM_DESC AS DESCRIPTION, ISD.PRIMARY_QTY AS STORE_QTY, ISD.ISSUE_AMOUNT AS STORE_AMOUNT,
                            GD.PRIMARY_QTY AS GRN_QTY, PID.PRIMARY_QTY AS PI_QTY, PID.TC_AMOUNT AS PI_AMOUNT, PID.PRO_EXP_TC_AMOUNT AS PI_EXP_TC_AMOUNT,
                            (PID.TC_AMOUNT+PID.PRO_EXP_TC_AMOUNT) AS PI_TOTAL_AMOUNT, (PID.TC_AMOUNT+PID.PRO_EXP_TC_AMOUNT)/PID.PRIMARY_QTY AS PI_RATE, ISM.ISSUE_NO, ISM.ISSUE_DATE
                            FROM OUT_SOURCE_JOB_CARD_MT OSJCM
                            JOIN OUT_SOURCE_JOB_CARD_DET OSJCD ON OSJCD.JOB_CARD_ID = OSJCM.JOB_CARD_ID
                            JOIN ITEMS_MT IM ON IM.ITEM_ID = OSJCD.ITEM_ID
                            JOIN WIZ_ITEM_TYPE_MT WITM ON WITM.ITEM_TYPE_ID = IM.ITEM_TYPE_ID AND WITM.ITEM_TYPE_ID IN ('$var1','$var2')
                            LEFT JOIN GRN_DETAIL GD ON GD.JOB_CARD_DET_ID = OSJCD.JOB_CARD_DET_ID
                            LEFT JOIN GRN_MT GM ON GM.GRN_ID = GD.GRN_ID
                            JOIN ISSUE_MT ISM ON ISM.JOB_CARD_ID = OSJCM.JOB_CARD_ID
                            JOIN ISSUE_DETAIL ISD ON ISD.ISSUE_ID = ISM.ISSUE_ID AND ISD.JOB_CARD_DET_ID = OSJCD.JOB_CARD_DET_ID AND ISM.ISSUE_DATE BETWEEN '$strtdte2' AND '$enddte2'
                            JOIN ITEMS_MT IMI ON IMI.ITEM_ID = ISD.ITEM_ID
                            LEFT JOIN PURCHASE_INVOICE_MT PIM ON PIM.JOB_CARD_ID = OSJCM.JOB_CARD_ID
                            LEFT JOIN PURCHASE_INVOICE_DETAIL PID ON PID.PURCH_INVOICE_ID = PIM.PURCH_INVOICE_ID AND PID.ITEM_ID = GD.ITEM_ID
                            WHERE OSJCM.DOC_NO LIKE NVL('$worder', '%')
                            ORDER BY GM.GRN_NO,IMI.ITEM_CODE";
                } 
                else{
                    $sql = "SELECT OSJCM.DOC_NO AS WO_NO, OSJCM.DOC_DATE AS WO_DATE, GM.GRN_NO, GM.GRN_DATE, IM.ITEM_CODE AS ITEM_CODE, IM.ITEM_DESC AS ITEM_DESC, OSJCD.QUANTITY as WO_QTY, OSJCD.CONVERSION_RATE AS WO_RATE,
                            IMI.ITEM_CODE AS CODE, IMI.ITEM_DESC AS DESCRIPTION, ISD.PRIMARY_QTY AS STORE_QTY, ISD.ISSUE_AMOUNT AS STORE_AMOUNT,
                            GD.PRIMARY_QTY AS GRN_QTY, PID.PRIMARY_QTY AS PI_QTY, PID.TC_AMOUNT AS PI_AMOUNT, PID.PRO_EXP_TC_AMOUNT AS PI_EXP_TC_AMOUNT,
                            (PID.TC_AMOUNT+PID.PRO_EXP_TC_AMOUNT) AS PI_TOTAL_AMOUNT, (PID.TC_AMOUNT+PID.PRO_EXP_TC_AMOUNT)/PID.PRIMARY_QTY AS PI_RATE, ISM.ISSUE_NO, ISM.ISSUE_DATE
                            FROM OUT_SOURCE_JOB_CARD_MT OSJCM
                            JOIN OUT_SOURCE_JOB_CARD_DET OSJCD ON OSJCD.JOB_CARD_ID = OSJCM.JOB_CARD_ID
                            JOIN ITEMS_MT IM ON IM.ITEM_ID = OSJCD.ITEM_ID
                            JOIN WIZ_ITEM_TYPE_MT WITM ON WITM.ITEM_TYPE_ID = IM.ITEM_TYPE_ID AND WITM.ITEM_TYPE_ID IN ('$var1','$var2')
                            JOIN GRN_DETAIL GD ON GD.JOB_CARD_DET_ID = OSJCD.JOB_CARD_DET_ID
                            JOIN GRN_MT GM ON GM.GRN_ID = GD.GRN_ID AND GM.GRN_DATE BETWEEN '$strtdte2' AND '$enddte2'
                            JOIN ITEMS_MT IMG ON IMG.ITEM_ID = GD.ITEM_ID
                            LEFT JOIN ISSUE_MT ISM ON ISM.JOB_CARD_ID = OSJCM.JOB_CARD_ID AND ISM.ISSUE_DATE BETWEEN '$strtdte2' AND '$enddte2'
                            LEFT JOIN ISSUE_DETAIL ISD ON ISD.ISSUE_ID = ISM.ISSUE_ID AND ISD.JOB_CARD_DET_ID = OSJCD.JOB_CARD_DET_ID
                            LEFT JOIN ITEMS_MT IMI ON IMI.ITEM_ID = ISD.ITEM_ID
                            LEFT JOIN PURCHASE_INVOICE_MT PIM ON PIM.JOB_CARD_ID = OSJCM.JOB_CARD_ID
                            LEFT JOIN PURCHASE_INVOICE_DETAIL PID ON PID.PURCH_INVOICE_ID = PIM.PURCH_INVOICE_ID AND PID.ITEM_ID = GD.ITEM_ID
                            LEFT JOIN ITEMS_MT IMPI ON IMPI.ITEM_ID = PID.ITEM_ID
                            WHERE OSJCM.DOC_NO LIKE NVL('$worder', '%')
                            ORDER BY GM.GRN_NO,IMI.ITEM_CODE";
                }
            }
            $result11 = oci_parse($conn,$sql);
            oci_execute($result11);
            while($row = oci_fetch_array($result11,  OCI_ASSOC+OCI_RETURN_NULLS)){
                if($row["PI_QTY"] != 0){
                    $pi_rate = ($row["PI_AMOUNT"]+$row["PI_EXP_TC_AMOUNT"])/$row["PI_QTY"];
                } 
                else{
                    $pi_rate = 0;
                }
                if($row["STORE_QTY"] != 0){
                    $store_rate = $row["STORE_AMOUNT"]/$row["STORE_QTY"];
                } 
                else{
                    $store_rate = 0;
                }
                $data[] = array(
                    'data' => $row,
                    'pi_rate' => $pi_rate,
                    'store_rate' => $store_rate,
                );
                if($report == "smry"){
                    $lineData[] = array(
                        'WO No' => $row['WO_NO'],
                        'Wo Date' => $row['WO_DATE'],
                        'Item Code' => $row['ITEM_CODE'],
                        'Item Desc' => $row['ITEM_DESC'],
                        'GRN' => $row['GRN_NO'],
                        'GRN DATE' => $row['GRN_DATE'],
                        'WO Qty' => $row['WO_QTY'],
                        'WO Rate' => $row['WO_RATE'],
                        'SIN No' => $row['ISSUE_NO'],
                        'SIN DATE' => $row['ISSUE_DATE'],
                        'Store Qty' => $row['STORE_QTY'],
                        'Store Amt' => $row['STORE_AMOUNT'],
                        'GRN Qty' => round($store_rate,2),
                        'PI Qty' => $row['GRN_QTY'],
                        'PI Amt' => $row['PI_QTY'],
                        'Store Rate' => $row['PI_AMOUNT'],
                        'PI EXP TC Amount' => $row['PI_EXP_TC_AMOUNT'],
                        'PI T-Amt' => $row['PI_TOTAL_AMOUNT'],
                        'PI Rate' => round($pi_rate,2),
                    );
                }
                if($report == "detail"){
                    $lineData[] = array(
                        'WO No' => $row['WO_NO'],
                        'Wo Date' => $row['WO_DATE'],
                        'Code' => $row['ITEM_CODE'],
                        'Desc' => $row['ITEM_DESC'],
                        'GRN' => $row['GRN_NO'],
                        'GRN DATE' => $row['GRN_DATE'],
                        'Item Code' => $row['CODE'],
                        'Item Desc' => $row['DESCRIPTION'],
                        'WO Qty' => $row['WO_QTY'],
                        'WO Rate' => $row['WO_RATE'],
                        'SIN No' => $row['ISSUE_NO'],
                        'SIN DATE' => $row['ISSUE_DATE'],
                        'Store Qty' => $row['STORE_QTY'],
                        'Store Amt' => $row['STORE_AMOUNT'],
                        'GRN Qty' => round($store_rate,2),
                        'PI Qty' => $row['GRN_QTY'],
                        'PI Amt' => $row['PI_QTY'],
                        'Store Rate' => $row['PI_AMOUNT'],
                        'PI EXP TC Amount' => $row['PI_EXP_TC_AMOUNT'],
                        'PI T-Amt' => $row['PI_TOTAL_AMOUNT'],
                        'PI Rate' => round($pi_rate,2),
                    );
                }
            }
            if($report == "smry"){
                return Excel::download(new WorkorderSummary($lineData), 'Work Order '.$date.'.xlsx');
            }
            if($report == "detail"){
                return Excel::download(new WorkorderDetail($lineData), 'Work Order '.$date.'.xlsx');
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

    public function WorkorderReportDisplay(Request $request)
    {        
        try{
            $rate2 = 0;
            $data = array();
            $books = array(); $adjustment = array();
            $sum_rate = $sum_qty = $sum_amount = 0;
            $workorder = $request->workorder;
            $itemtype = $request->itemtype;
            $thedate = $request->thedate;
            $report = $request->report;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("d-m-Y", strtotime(substr($daterange, 0,10)));
            $enddte = date("d-m-Y", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $start = date("d-M-Y", strtotime(substr($daterange, 0,10)));
            $end = date("d-M-Y", strtotime(substr($daterange, -10)));
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);

            if(!empty($strtdte2)){
                $strtdte2 = $strtdte2;
            }else{
                $strtdte2 = "";
            }
            if(!empty($enddte2)){
                $enddte2 = $enddte2;
            }else{
                $enddte2 = "";
            }
            if(!empty($workorder)){
               $workorder = $workorder;
            }else{
                $workorder = "";
            }
            if(!empty($itemtype)){
                if($itemtype == "insole"){
                    $var1 = 8;  
                    $var2 = 9;
                } 
                else{
                    $var1 = 14;  
                    $var2 = 15;
                }
            }
            if(!empty($workorder)){
                $workorder = explode(" || ", $workorder);            
                $worder = $workorder[0];
            }else{
                $worder = "";
            }            
            
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql1 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_BOOK_DESC LIKE '%Item Adjustment%' OR INV_BOOK_DESC = 'Item_adjustment-SS'";
            $result1 = oci_parse($conn, $sql1);
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $books[] = $row1["INV_BOOK_DESC"];
            }    
            $sql2 = "SELECT DISTINCT ADJUSTMENT_NO FROM ITEM_ADJUSTMENT_MT ORDER BY ADJUSTMENT_NO";
            $result2 = oci_parse($conn, $sql2);
            oci_execute($result2);
            while($row2 = oci_fetch_array($result2,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $adjustment[] = $row2["ADJUSTMENT_NO"];
            }
            if($report == "smry"){
                if($thedate == "pi"){
                    $sql = "SELECT OSJCM.DOC_NO AS WO_NO, OSJCM.DOC_DATE AS WO_DATE, GM.GRN_NO, GM.GRN_DATE, IM.ITEM_CODE AS ITEM_CODE, IM.ITEM_DESC AS ITEM_DESC, OSJCD.QUANTITY as WO_QTY,
                            OSJCD.CONVERSION_RATE AS WO_RATE,
                            SUM(ISD.PRIMARY_QTY) AS STORE_QTY, SUM(ISD.ISSUE_AMOUNT) AS STORE_AMOUNT,
                            GD.PRIMARY_QTY AS GRN_QTY,
                            PID.PRIMARY_QTY AS PI_QTY, PID.TC_AMOUNT AS PI_AMOUNT, PID.PRO_EXP_TC_AMOUNT AS PI_EXP_TC_AMOUNT,
                            (PID.TC_AMOUNT+PID.PRO_EXP_TC_AMOUNT) AS PI_TOTAL_AMOUNT, ISM.ISSUE_NO, ISM.ISSUE_DATE                        
                            FROM OUT_SOURCE_JOB_CARD_MT OSJCM
                            JOIN OUT_SOURCE_JOB_CARD_DET OSJCD ON OSJCD.JOB_CARD_ID = OSJCM.JOB_CARD_ID
                            JOIN ITEMS_MT IM ON IM.ITEM_ID = OSJCD.ITEM_ID
                            JOIN WIZ_ITEM_TYPE_MT WITM ON WITM.ITEM_TYPE_ID = IM.ITEM_TYPE_ID AND WITM.ITEM_TYPE_ID IN ('$var1','$var2')                        
                            LEFT JOIN GRN_DETAIL GD ON GD.JOB_CARD_DET_ID = OSJCD.JOB_CARD_DET_ID
                            LEFT JOIN GRN_MT GM ON GM.GRN_ID = GD.GRN_ID                        
                            JOIN ISSUE_MT ISM ON ISM.JOB_CARD_ID = OSJCM.JOB_CARD_ID
                            JOIN ISSUE_DETAIL ISD ON ISD.ISSUE_ID = ISM.ISSUE_ID AND ISD.JOB_CARD_DET_ID = OSJCD.JOB_CARD_DET_ID AND ISM.ISSUE_DATE BETWEEN '$strtdte2' AND '$enddte2'                        
                            LEFT JOIN PURCHASE_INVOICE_MT PIM ON PIM.JOB_CARD_ID = OSJCM.JOB_CARD_ID
                            LEFT JOIN PURCHASE_INVOICE_DETAIL PID ON PID.PURCH_INVOICE_ID = PIM.PURCH_INVOICE_ID AND PID.ITEM_ID = GD.ITEM_ID
                            WHERE OSJCM.DOC_NO LIKE NVL('$worder', '%')                
                            GROUP BY OSJCM.DOC_NO, OSJCM.DOC_DATE, IM.ITEM_CODE, IM.ITEM_DESC, OSJCD.QUANTITY , OSJCD.CONVERSION_RATE, GD.PRIMARY_QTY,
                            PID.PRIMARY_QTY, PID.TC_AMOUNT, PID.PRO_EXP_TC_AMOUNT, GM.GRN_NO, GM.GRN_DATE, ISM.ISSUE_NO, ISM.ISSUE_DATE
                            ORDER BY GM.GRN_NO";
                } 
                else{
                    $sql = "SELECT OSJCM.DOC_NO AS WO_NO, OSJCM.DOC_DATE AS WO_DATE, GM.GRN_NO, GM.GRN_DATE, IM.ITEM_CODE AS ITEM_CODE, IM.ITEM_DESC AS ITEM_DESC, OSJCD.QUANTITY as WO_QTY,
                            OSJCD.CONVERSION_RATE AS WO_RATE,
                            SUM(ISD.PRIMARY_QTY) AS STORE_QTY, SUM(ISD.ISSUE_AMOUNT) AS STORE_AMOUNT,
                            GD.PRIMARY_QTY AS GRN_QTY,
                            PID.PRIMARY_QTY AS PI_QTY, PID.TC_AMOUNT AS PI_AMOUNT, PID.PRO_EXP_TC_AMOUNT AS PI_EXP_TC_AMOUNT,
                            (PID.TC_AMOUNT+PID.PRO_EXP_TC_AMOUNT) AS PI_TOTAL_AMOUNT, ISM.ISSUE_NO, ISM.ISSUE_DATE
                            FROM OUT_SOURCE_JOB_CARD_MT OSJCM
                            JOIN OUT_SOURCE_JOB_CARD_DET OSJCD ON OSJCD.JOB_CARD_ID = OSJCM.JOB_CARD_ID
                            JOIN ITEMS_MT IM ON IM.ITEM_ID = OSJCD.ITEM_ID
                            JOIN WIZ_ITEM_TYPE_MT WITM ON WITM.ITEM_TYPE_ID = IM.ITEM_TYPE_ID AND WITM.ITEM_TYPE_ID IN ('$var1','$var2')
                            JOIN GRN_DETAIL GD ON GD.JOB_CARD_DET_ID = OSJCD.JOB_CARD_DET_ID
                            JOIN GRN_MT GM ON GM.GRN_ID = GD.GRN_ID AND GM.GRN_DATE BETWEEN '$strtdte2' AND '$enddte2'
                            LEFT JOIN ISSUE_MT ISM ON ISM.JOB_CARD_ID = OSJCM.JOB_CARD_ID AND ISM.ISSUE_DATE BETWEEN '$strtdte2' AND '$enddte2'
                            LEFT JOIN ISSUE_DETAIL ISD ON ISD.ISSUE_ID = ISM.ISSUE_ID AND ISD.JOB_CARD_DET_ID = OSJCD.JOB_CARD_DET_ID
                            LEFT JOIN PURCHASE_INVOICE_MT PIM ON PIM.JOB_CARD_ID = OSJCM.JOB_CARD_ID
                            LEFT JOIN PURCHASE_INVOICE_DETAIL PID ON PID.PURCH_INVOICE_ID = PIM.PURCH_INVOICE_ID AND PID.ITEM_ID = GD.ITEM_ID
                            WHERE OSJCM.DOC_NO LIKE NVL('$worder', '%')
                            GROUP BY OSJCM.DOC_NO, OSJCM.DOC_DATE, IM.ITEM_CODE, IM.ITEM_DESC, OSJCD.QUANTITY , OSJCD.CONVERSION_RATE, GD.PRIMARY_QTY  ,
                            PID.PRIMARY_QTY, PID.TC_AMOUNT, PID.PRO_EXP_TC_AMOUNT, GM.GRN_NO, GM.GRN_DATE, ISM.ISSUE_NO, ISM.ISSUE_DATE
                            ORDER BY GM.GRN_NO";
                }

            }
            if($report == "detail"){
                if($thedate == "pi"){
                    $sql = "SELECT OSJCM.DOC_NO AS WO_NO, OSJCM.DOC_DATE AS WO_DATE, GM.GRN_NO, GM.GRN_DATE, IM.ITEM_CODE AS ITEM_CODE, IM.ITEM_DESC AS ITEM_DESC, OSJCD.QUANTITY as WO_QTY, OSJCD.CONVERSION_RATE AS WO_RATE,
                            IMI.ITEM_CODE AS CODE, IMI.ITEM_DESC AS DESCRIPTION, ISD.PRIMARY_QTY AS STORE_QTY, ISD.ISSUE_AMOUNT AS STORE_AMOUNT,
                            GD.PRIMARY_QTY AS GRN_QTY, PID.PRIMARY_QTY AS PI_QTY, PID.TC_AMOUNT AS PI_AMOUNT, PID.PRO_EXP_TC_AMOUNT AS PI_EXP_TC_AMOUNT,
                            (PID.TC_AMOUNT+PID.PRO_EXP_TC_AMOUNT) AS PI_TOTAL_AMOUNT, (PID.TC_AMOUNT+PID.PRO_EXP_TC_AMOUNT)/PID.PRIMARY_QTY AS PI_RATE, ISM.ISSUE_NO, ISM.ISSUE_DATE
                            FROM OUT_SOURCE_JOB_CARD_MT OSJCM
                            JOIN OUT_SOURCE_JOB_CARD_DET OSJCD ON OSJCD.JOB_CARD_ID = OSJCM.JOB_CARD_ID
                            JOIN ITEMS_MT IM ON IM.ITEM_ID = OSJCD.ITEM_ID
                            JOIN WIZ_ITEM_TYPE_MT WITM ON WITM.ITEM_TYPE_ID = IM.ITEM_TYPE_ID AND WITM.ITEM_TYPE_ID IN ('$var1','$var2')
                            LEFT JOIN GRN_DETAIL GD ON GD.JOB_CARD_DET_ID = OSJCD.JOB_CARD_DET_ID
                            LEFT JOIN GRN_MT GM ON GM.GRN_ID = GD.GRN_ID
                            JOIN ISSUE_MT ISM ON ISM.JOB_CARD_ID = OSJCM.JOB_CARD_ID
                            JOIN ISSUE_DETAIL ISD ON ISD.ISSUE_ID = ISM.ISSUE_ID AND ISD.JOB_CARD_DET_ID = OSJCD.JOB_CARD_DET_ID AND ISM.ISSUE_DATE BETWEEN '$strtdte2' AND '$enddte2'
                            JOIN ITEMS_MT IMI ON IMI.ITEM_ID = ISD.ITEM_ID
                            LEFT JOIN PURCHASE_INVOICE_MT PIM ON PIM.JOB_CARD_ID = OSJCM.JOB_CARD_ID
                            LEFT JOIN PURCHASE_INVOICE_DETAIL PID ON PID.PURCH_INVOICE_ID = PIM.PURCH_INVOICE_ID AND PID.ITEM_ID = GD.ITEM_ID
                            WHERE OSJCM.DOC_NO LIKE NVL('$worder', '%')
                            ORDER BY GM.GRN_NO,IMI.ITEM_CODE";
                } 
                else{
                    $sql = "SELECT OSJCM.DOC_NO AS WO_NO, OSJCM.DOC_DATE AS WO_DATE, GM.GRN_NO, GM.GRN_DATE, IM.ITEM_CODE AS ITEM_CODE, IM.ITEM_DESC AS ITEM_DESC, OSJCD.QUANTITY as WO_QTY, OSJCD.CONVERSION_RATE AS WO_RATE,
                            IMI.ITEM_CODE AS CODE, IMI.ITEM_DESC AS DESCRIPTION, ISD.PRIMARY_QTY AS STORE_QTY, ISD.ISSUE_AMOUNT AS STORE_AMOUNT,
                            GD.PRIMARY_QTY AS GRN_QTY, PID.PRIMARY_QTY AS PI_QTY, PID.TC_AMOUNT AS PI_AMOUNT, PID.PRO_EXP_TC_AMOUNT AS PI_EXP_TC_AMOUNT,
                            (PID.TC_AMOUNT+PID.PRO_EXP_TC_AMOUNT) AS PI_TOTAL_AMOUNT, (PID.TC_AMOUNT+PID.PRO_EXP_TC_AMOUNT)/PID.PRIMARY_QTY AS PI_RATE, ISM.ISSUE_NO, ISM.ISSUE_DATE
                            FROM OUT_SOURCE_JOB_CARD_MT OSJCM
                            JOIN OUT_SOURCE_JOB_CARD_DET OSJCD ON OSJCD.JOB_CARD_ID = OSJCM.JOB_CARD_ID
                            JOIN ITEMS_MT IM ON IM.ITEM_ID = OSJCD.ITEM_ID
                            JOIN WIZ_ITEM_TYPE_MT WITM ON WITM.ITEM_TYPE_ID = IM.ITEM_TYPE_ID AND WITM.ITEM_TYPE_ID IN ('$var1','$var2')
                            JOIN GRN_DETAIL GD ON GD.JOB_CARD_DET_ID = OSJCD.JOB_CARD_DET_ID
                            JOIN GRN_MT GM ON GM.GRN_ID = GD.GRN_ID AND GM.GRN_DATE BETWEEN '$strtdte2' AND '$enddte2'
                            JOIN ITEMS_MT IMG ON IMG.ITEM_ID = GD.ITEM_ID
                            LEFT JOIN ISSUE_MT ISM ON ISM.JOB_CARD_ID = OSJCM.JOB_CARD_ID AND ISM.ISSUE_DATE BETWEEN '$strtdte2' AND '$enddte2'
                            LEFT JOIN ISSUE_DETAIL ISD ON ISD.ISSUE_ID = ISM.ISSUE_ID AND ISD.JOB_CARD_DET_ID = OSJCD.JOB_CARD_DET_ID
                            LEFT JOIN ITEMS_MT IMI ON IMI.ITEM_ID = ISD.ITEM_ID
                            LEFT JOIN PURCHASE_INVOICE_MT PIM ON PIM.JOB_CARD_ID = OSJCM.JOB_CARD_ID
                            LEFT JOIN PURCHASE_INVOICE_DETAIL PID ON PID.PURCH_INVOICE_ID = PIM.PURCH_INVOICE_ID AND PID.ITEM_ID = GD.ITEM_ID
                            LEFT JOIN ITEMS_MT IMPI ON IMPI.ITEM_ID = PID.ITEM_ID
                            WHERE OSJCM.DOC_NO LIKE NVL('$worder', '%')
                            ORDER BY GM.GRN_NO,IMI.ITEM_CODE";
                }
            }
            $result11 = oci_parse($conn,$sql);
            oci_execute($result11);
            $qrn_qty = 0;
            while($row = oci_fetch_array($result11,  OCI_ASSOC+OCI_RETURN_NULLS)){
                if($row["PI_QTY"] != 0){
                    $pi_rate = ($row["PI_AMOUNT"]+$row["PI_EXP_TC_AMOUNT"])/$row["PI_QTY"];
                } 
                else{
                    $pi_rate = 0;
                }
                if($row["STORE_QTY"] != 0){
                    $store_rate = $row["STORE_AMOUNT"]/$row["STORE_QTY"];
                } 
                else{
                    $store_rate = 0;
                }
                $qrn_qty = $qrn_qty + $row['GRN_QTY'];
                $data[] = array(
                    'data' => $row,
                    'pi_rate' => $pi_rate,
                    'store_rate' => $store_rate,
                    'qrn_qty' => $qrn_qty
                );
            }

            $strtdte2 = date("m/d/Y", strtotime(substr($daterange, 0,10)));
            $strtdte3 = date("m/d/Y", strtotime(substr($daterange, 10)));
            $strtdte2a = date("m/d/Y", strtotime(substr($daterange, 0,10)));
            $strtdte3a = date("m/d/Y", strtotime(substr($daterange, 10)));
            $daterangeVal = wordwrap($daterange , 10 , ' ' , true );

            $sessionData = [
                'end' => $end,
                'start' => $start,
                'thedate' => $request->thedate,
                'report' => $request->report,
                'itemtype' => $request->itemtype,
                'workorder' => $request->workorder,
                'strtdte2a' => $strtdte2a,
                'strtdte3a' => $strtdte3a,
            ];
            if($report == "smry"){
                return view('report.workordersummary')->with([
                    "data" => $data, "Permission" => 1, "sessionData" => $sessionData, 'qrn_qty' => $qrn_qty
                ]);
            }
            if($report == "detail"){
                return view('report.workorderdetail')->with([
                    "data" => $data, "Permission" => 1, "sessionData" => $sessionData, 'qrn_qty' => $qrn_qty
                ]);
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

    public function Purchase(Request $request)
    {
        try{
            $financial = array(); $itemtype1 = array(); $itemtype2 = array(); $period = array();
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql1 = "select a.fin_yr_desc from financial_year_mt a order by a.fin_year_id";
            $result1 = oci_parse($conn, $sql1);
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $financial[] = $row1["FIN_YR_DESC"];
            }    
            $sql2 = "SELECT ICM.SHORT_DESC FROM INV_CATEGORY_SET_MT ICM WHERE ICM.INV_CAT_SET_ID != 5 ORDER BY ICM.SHORT_DESC";
            $result2 = oci_parse($conn, $sql2);
            oci_execute($result2);
            while($row2 = oci_fetch_array($result2,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $itemtype1[] = $row2["SHORT_DESC"];
            }
            $sql3 = "SELECT ITM.ITEM_TYPE_DESC, ITM.ITEM_CODE_PREFIX
            FROM WIZ_ITEM_TYPE_MT ITM
            JOIN INV_CATEGORY_SET_MT ICM ON ITM.DEF_CAT_SET_ID = ICM.INV_CAT_SET_ID AND ICM.INV_CAT_SET_ID !=5 ORDER BY ITM.ITEM_TYPE_DESC";
            $result3 = oci_parse($conn, $sql3);
            oci_execute($result3);
            while($row3 = oci_fetch_array($result3,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $itemtype2[] = array(
                    'value' => $row3['ITEM_TYPE_DESC'],
                    'code' => $row3['ITEM_CODE_PREFIX']
                );
            }
            $sql4 = "SELECT PD.PERIOD_DESC FROM PERIOD_DETAILS PD";
            $result4 = oci_parse($conn, $sql4);
            oci_execute($result4);
            while($row4 = oci_fetch_array($result4,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $period[] = $row4["PERIOD_DESC"];
            }
            return view('report.purchase')->with([
                "Permission" => 0, 
                "period" => $period, 
                "financial" => $financial,
                "itemtype1" => $itemtype1,
                "itemtype2" => $itemtype2,
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

    public function PurchaseReportDownload(Request $request)
    {   
        try{
            date_default_timezone_set("Asia/karachi");
            $date = date("d-m-Y");
            $rate2 = 0;
            $data = array();
            $books = array(); $adjustment = array();
            $financial = array(); $itemtype1 = array(); $itemtype2 = array(); $dataPeriod = array();
            $sum_rate = $sum_qty = $sum_amount = 0;
            $finyr = $request->finyr;
            $rmcode = $request->rmcode;
            $period = $request->period;
            $fromclass = $request->typefrom;
            if(!empty($finyear)){
                $finyear = $finyear;
            }
            else{
                $finyear = "";
            }
            if(!empty($rmcode)){
                $rmcoarr = explode(" || ", $rmcode);
                $rmcodeq = $rmcoarr[0];
            }
            else{
                $rmcodeq = "UPRIM-00199";
            }
            if($finyr != "all"){
                $finyr = $finyr;
            } 
            else{
                $finyr = "";
            }
            
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql11 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_BOOK_DESC LIKE '%Item Adjustment%' OR INV_BOOK_DESC = 'Item_adjustment-SS'";
            $result11 = oci_parse($conn, $sql11);
            oci_execute($result11);
            while($row11 = oci_fetch_array($result11,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $books[] = $row11["INV_BOOK_DESC"];
            }    
            $sql22 = "SELECT DISTINCT ADJUSTMENT_NO FROM ITEM_ADJUSTMENT_MT ORDER BY ADJUSTMENT_NO";
            $result22 = oci_parse($conn, $sql22);
            oci_execute($result22);
            while($row22 = oci_fetch_array($result22,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $adjustment[] = $row22["ADJUSTMENT_NO"];
            }
            if($fromclass == "Capital Assets" || $fromclass == "IT Equipments" || $fromclass == "Oil & Lubricant" || $fromclass == "RAW Material" || $fromclass == "Services Codes" || $fromclass == "Store Spare"){
                $sql = "SELECT IM.ITEM_CODE, IM.ITEM_DESC, PIM.PURCH_INVOICE_DATE, PID.AMOUNT, PID.PRIMARY_QTY, PID.STAX_AMOUNT, PID.PRO_EXP_AMOUNT,
                        (PID.AMOUNT + PID.PRO_EXP_AMOUNT) AS TOTAL_AMOUNT, ((PID.AMOUNT + PID.PRO_EXP_AMOUNT) / PID.PRIMARY_QTY) AS RATE,
                        PD.PERIOD_DESC AS PERIOD, FYM.FIN_YR_DESC AS FIN_YEAR              
                        FROM PURCHASE_INVOICE_MT PIM            
                        JOIN PURCHASE_INVOICE_DETAIL PID ON PID.PURCH_INVOICE_ID = PIM.PURCH_INVOICE_ID
                        JOIN ITEMS_MT IM ON IM.ITEM_ID = PID.ITEM_ID
                        JOIN PERIOD_DETAILS PD ON PD.PERIOD_DESC LIKE NVL('$period', '%') AND PIM.PURCH_INVOICE_DATE BETWEEN PD.FROM_DATE AND PD.TO_DATE
                        JOIN FINANCIAL_YEAR_MT FYM ON FYM.FIN_YEAR_ID = PD.FIN_YEAR_ID AND FYM.FIN_YR_DESC LIKE NVL('$finyr','%')
                        JOIN WIZ_ITEM_TYPE_MT ITM ON ITM.ITEM_TYPE_ID = IM.ITEM_TYPE_ID
                        JOIN INV_CATEGORY_SET_MT ICM ON ICM.INV_CAT_SET_ID = ITM.DEF_CAT_SET_ID AND ICM.SHORT_DESC LIKE NVL('%$fromclass%','%')            
                        ORDER BY IM.ITEM_CODE, PIM.PURCH_INVOICE_DATE";
            } 
            elseif(!empty($fromclass)){
                $sql = "SELECT IM.ITEM_CODE, IM.ITEM_DESC, PIM.PURCH_INVOICE_DATE, PID.AMOUNT, PID.PRIMARY_QTY, PID.STAX_AMOUNT, PID.PRO_EXP_AMOUNT,
                        (PID.AMOUNT + PID.PRO_EXP_AMOUNT) AS TOTAL_AMOUNT, ((PID.AMOUNT + PID.PRO_EXP_AMOUNT) / PID.PRIMARY_QTY) AS RATE,
                        PD.PERIOD_DESC AS PERIOD, FYM.FIN_YR_DESC AS FIN_YEAR              
                        FROM PURCHASE_INVOICE_MT PIM              
                        JOIN PURCHASE_INVOICE_DETAIL PID ON PID.PURCH_INVOICE_ID = PIM.PURCH_INVOICE_ID
                        JOIN ITEMS_MT IM ON IM.ITEM_ID = PID.ITEM_ID AND IM.ITEM_CODE LIKE NVL('$fromclass%','%')
                        JOIN PERIOD_DETAILS PD ON PD.PERIOD_DESC LIKE NVL('$period', '%') AND PIM.PURCH_INVOICE_DATE BETWEEN PD.FROM_DATE AND PD.TO_DATE
                        JOIN FINANCIAL_YEAR_MT FYM ON FYM.FIN_YEAR_ID = PD.FIN_YEAR_ID AND FYM.FIN_YR_DESC LIKE NVL('$finyr','%')            
                        ORDER BY IM.ITEM_CODE, PIM.PURCH_INVOICE_DATE";
            } 
            else{
                $sql = "SELECT IM.ITEM_CODE, IM.ITEM_DESC, PIM.PURCH_INVOICE_DATE, PID.AMOUNT, PID.PRIMARY_QTY, PID.STAX_AMOUNT, PID.PRO_EXP_AMOUNT,
                        (PID.AMOUNT + PID.PRO_EXP_AMOUNT) AS TOTAL_AMOUNT, ((PID.AMOUNT + PID.PRO_EXP_AMOUNT) / PID.PRIMARY_QTY) AS RATE,
                        PD.PERIOD_DESC AS PERIOD, FYM.FIN_YR_DESC AS FIN_YEAR
                        FROM PURCHASE_INVOICE_MT PIM
                        JOIN PURCHASE_INVOICE_DETAIL PID ON PID.PURCH_INVOICE_ID = PIM.PURCH_INVOICE_ID
                        JOIN ITEMS_MT IM ON IM.ITEM_ID = PID.ITEM_ID AND IM.ITEM_CODE LIKE NVL('$rmcodeq','%')
                        JOIN PERIOD_DETAILS PD ON PD.PERIOD_DESC LIKE NVL('$period', '%') AND PIM.PURCH_INVOICE_DATE BETWEEN PD.FROM_DATE AND PD.TO_DATE
                        JOIN FINANCIAL_YEAR_MT FYM ON FYM.FIN_YEAR_ID = PD.FIN_YEAR_ID AND FYM.FIN_YR_DESC LIKE NVL('$finyr','%')            
                        ORDER BY IM.ITEM_CODE, PIM.PURCH_INVOICE_DATE";
            }
            $result11 = oci_parse($conn,$sql);
            oci_execute($result11);
            while($row = oci_fetch_array($result11,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $lineData[] = array(
                    'Financial Year' => $row["FIN_YEAR"],
                    'Period' => $row["PERIOD"],
                    'Item Code' => $row["ITEM_CODE"],
                    'Item Description' => $row["ITEM_DESC"],
                    'Purchase Date' => $row["PURCH_INVOICE_DATE"],
                    'Amount '=> $row["AMOUNT"],
                    'Primary Qty' => $row["PRIMARY_QTY"],
                    'Pro Expense' => $row["PRO_EXP_AMOUNT"],
                    'STAX Amount' => $row["STAX_AMOUNT"],
                    'Total Amount' => $row["TOTAL_AMOUNT"],
                    'Rate' => round($row["RATE"], 2)
                );
            }
            return Excel::download(new Purchase($lineData), 'Purchase Rate History Report '.$date.'.xlsx');
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function PurchaseReportDisplay(Request $request)
    {        
        try{
            $rate2 = 0;
            $data = array();
            $books = array(); $adjustment = array();
            $financial = array(); $itemtype1 = array(); $itemtype2 = array(); $dataPeriod = array();
            $sum_rate = $sum_qty = $sum_amount = 0;
            $finyr = $request->finyr;
            $rmcode = $request->rmcode;
            $period = $request->period;
            $fromclass = $request->typefrom;
            if(!empty($finyear)){
                $finyear = $finyear;
            }
            else{
                $finyear = "";
            }
            if(!empty($rmcode)){
                $rmcoarr = explode(" || ", $rmcode);
                $rmcodeq = $rmcoarr[0];
            }
            else{
                $rmcodeq = "UPRIM-00199";
            }
            if($finyr != "all"){
                $finyr = $finyr;
            } 
            else{
                $finyr = "";
            }
            
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql11 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_BOOK_DESC LIKE '%Item Adjustment%' OR INV_BOOK_DESC = 'Item_adjustment-SS'";
            $result11 = oci_parse($conn, $sql11);
            oci_execute($result11);
            while($row11 = oci_fetch_array($result11,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $books[] = $row11["INV_BOOK_DESC"];
            }    
            $sql22 = "SELECT DISTINCT ADJUSTMENT_NO FROM ITEM_ADJUSTMENT_MT ORDER BY ADJUSTMENT_NO";
            $result22 = oci_parse($conn, $sql22);
            oci_execute($result22);
            while($row22 = oci_fetch_array($result22,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $adjustment[] = $row22["ADJUSTMENT_NO"];
            }
            $sql1 = "select a.fin_yr_desc from financial_year_mt a order by a.fin_year_id";
            $result1 = oci_parse($conn, $sql1);
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $financial[] = $row1["FIN_YR_DESC"];
            }    
            $sql2 = "SELECT ICM.SHORT_DESC FROM INV_CATEGORY_SET_MT ICM WHERE ICM.INV_CAT_SET_ID != 5 ORDER BY ICM.SHORT_DESC";
            $result2 = oci_parse($conn, $sql2);
            oci_execute($result2);
            while($row2 = oci_fetch_array($result2,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $itemtype1[] = $row2["SHORT_DESC"];
            }
            $sql3 = "SELECT ITM.ITEM_TYPE_DESC, ITM.ITEM_CODE_PREFIX
            FROM WIZ_ITEM_TYPE_MT ITM
            JOIN INV_CATEGORY_SET_MT ICM ON ITM.DEF_CAT_SET_ID = ICM.INV_CAT_SET_ID AND ICM.INV_CAT_SET_ID !=5 ORDER BY ITM.ITEM_TYPE_DESC";
            $result3 = oci_parse($conn, $sql3);
            oci_execute($result3);
            while($row3 = oci_fetch_array($result3,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $itemtype2[] = array(
                    'value' => $row3['ITEM_TYPE_DESC'],
                    'code' => $row3['ITEM_CODE_PREFIX']
                );
            }
            $sql4 = "SELECT PD.PERIOD_DESC FROM PERIOD_DETAILS PD";
            $result4 = oci_parse($conn, $sql4);
            oci_execute($result4);
            while($row4 = oci_fetch_array($result4,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $dataPeriod[] = $row4["PERIOD_DESC"];
            }
            if($fromclass == "Capital Assets" || $fromclass == "IT Equipments" || $fromclass == "Oil & Lubricant" || $fromclass == "RAW Material" || $fromclass == "Services Codes" || $fromclass == "Store Spare"){
                $sql = "SELECT IM.ITEM_CODE, IM.ITEM_DESC, PIM.PURCH_INVOICE_DATE, PID.AMOUNT, PID.PRIMARY_QTY, PID.STAX_AMOUNT, PID.PRO_EXP_AMOUNT,
                        (PID.AMOUNT + PID.PRO_EXP_AMOUNT) AS TOTAL_AMOUNT, ((PID.AMOUNT + PID.PRO_EXP_AMOUNT) / PID.PRIMARY_QTY) AS RATE,
                        PD.PERIOD_DESC AS PERIOD, FYM.FIN_YR_DESC AS FIN_YEAR              
                        FROM PURCHASE_INVOICE_MT PIM            
                        JOIN PURCHASE_INVOICE_DETAIL PID ON PID.PURCH_INVOICE_ID = PIM.PURCH_INVOICE_ID
                        JOIN ITEMS_MT IM ON IM.ITEM_ID = PID.ITEM_ID
                        JOIN PERIOD_DETAILS PD ON PD.PERIOD_DESC LIKE NVL('$period', '%') AND PIM.PURCH_INVOICE_DATE BETWEEN PD.FROM_DATE AND PD.TO_DATE
                        JOIN FINANCIAL_YEAR_MT FYM ON FYM.FIN_YEAR_ID = PD.FIN_YEAR_ID AND FYM.FIN_YR_DESC LIKE NVL('$finyr','%')
                        JOIN WIZ_ITEM_TYPE_MT ITM ON ITM.ITEM_TYPE_ID = IM.ITEM_TYPE_ID
                        JOIN INV_CATEGORY_SET_MT ICM ON ICM.INV_CAT_SET_ID = ITM.DEF_CAT_SET_ID AND ICM.SHORT_DESC LIKE NVL('%$fromclass%','%')            
                        ORDER BY IM.ITEM_CODE, PIM.PURCH_INVOICE_DATE";
            } 
            elseif(!empty($fromclass)){
                $sql = "SELECT IM.ITEM_CODE, IM.ITEM_DESC, PIM.PURCH_INVOICE_DATE, PID.AMOUNT, PID.PRIMARY_QTY, PID.STAX_AMOUNT, PID.PRO_EXP_AMOUNT,
                        (PID.AMOUNT + PID.PRO_EXP_AMOUNT) AS TOTAL_AMOUNT, ((PID.AMOUNT + PID.PRO_EXP_AMOUNT) / PID.PRIMARY_QTY) AS RATE,
                        PD.PERIOD_DESC AS PERIOD, FYM.FIN_YR_DESC AS FIN_YEAR              
                        FROM PURCHASE_INVOICE_MT PIM              
                        JOIN PURCHASE_INVOICE_DETAIL PID ON PID.PURCH_INVOICE_ID = PIM.PURCH_INVOICE_ID
                        JOIN ITEMS_MT IM ON IM.ITEM_ID = PID.ITEM_ID AND IM.ITEM_CODE LIKE NVL('$fromclass%','%')
                        JOIN PERIOD_DETAILS PD ON PD.PERIOD_DESC LIKE NVL('$period', '%') AND PIM.PURCH_INVOICE_DATE BETWEEN PD.FROM_DATE AND PD.TO_DATE
                        JOIN FINANCIAL_YEAR_MT FYM ON FYM.FIN_YEAR_ID = PD.FIN_YEAR_ID AND FYM.FIN_YR_DESC LIKE NVL('$finyr','%')            
                        ORDER BY IM.ITEM_CODE, PIM.PURCH_INVOICE_DATE";
            } 
            else{
                $sql = "SELECT IM.ITEM_CODE, IM.ITEM_DESC, PIM.PURCH_INVOICE_DATE, PID.AMOUNT, PID.PRIMARY_QTY, PID.STAX_AMOUNT, PID.PRO_EXP_AMOUNT,
                        (PID.AMOUNT + PID.PRO_EXP_AMOUNT) AS TOTAL_AMOUNT, ((PID.AMOUNT + PID.PRO_EXP_AMOUNT) / PID.PRIMARY_QTY) AS RATE,
                        PD.PERIOD_DESC AS PERIOD, FYM.FIN_YR_DESC AS FIN_YEAR
                        FROM PURCHASE_INVOICE_MT PIM
                        JOIN PURCHASE_INVOICE_DETAIL PID ON PID.PURCH_INVOICE_ID = PIM.PURCH_INVOICE_ID
                        JOIN ITEMS_MT IM ON IM.ITEM_ID = PID.ITEM_ID AND IM.ITEM_CODE LIKE NVL('$rmcodeq','%')
                        JOIN PERIOD_DETAILS PD ON PD.PERIOD_DESC LIKE NVL('$period', '%') AND PIM.PURCH_INVOICE_DATE BETWEEN PD.FROM_DATE AND PD.TO_DATE
                        JOIN FINANCIAL_YEAR_MT FYM ON FYM.FIN_YEAR_ID = PD.FIN_YEAR_ID AND FYM.FIN_YR_DESC LIKE NVL('$finyr','%')            
                        ORDER BY IM.ITEM_CODE, PIM.PURCH_INVOICE_DATE";
            }
            $result11 = oci_parse($conn,$sql);
            oci_execute($result11);
            $t_am = $p_qty = $stax_amount = $pro_qty = $total_amount = 0;
            while($row = oci_fetch_array($result11,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $data[] = $row;
                $t_am = $t_am + $row["AMOUNT"];
                $p_qty = $p_qty + $row["PRIMARY_QTY"];
                $stax_amount = $stax_amount + $row["STAX_AMOUNT"];
                $pro_qty = $pro_qty + $row["PRO_EXP_AMOUNT"];
                $total_amount = $total_amount + $row["TOTAL_AMOUNT"];
            }

            $sessionData = [
                'finyr' => $request->finyr,
                'rmcode' => $request->rmcode,
                'period' => $request->period,
                'fromclass' => $fromclass,
            ];

            return view('report.purchase')->with([
                "data" => $data, "Permission" => 1, "sessionData" => $sessionData, "period" => $dataPeriod, 
                "financial" => $financial, "itemtype1" => $itemtype1, "itemtype2" => $itemtype2, "i" => 1,
                "t_am" => $t_am, "p_qty" => $p_qty, "stax_amount" => $stax_amount, "pro_qty" => $pro_qty, "total_amount" => $total_amount 
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

    public function Sales(Request $request)
    {
        try{
            $book = array(); $season = array(); $agent = array();
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql1 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_BOOK_DESC LIKE 'Sales Invoice%' OR  INV_BOOK_DESC LIKE 'Sales Return%' OR  INV_BOOK_DESC LIKE 'Sales Tax%' ";
            $result1 = oci_parse($conn, $sql1);
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $book[] = $row1["INV_BOOK_DESC"];
            }    
            $sql2 = "SELECT SEASON_DEF_DESC FROM ONSOLE_SEASON_DEFINITION";
            $result2 = oci_parse($conn, $sql2);
            oci_execute($result2);
            while($row2 = oci_fetch_array($result2,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $season[] = $row2["SEASON_DEF_DESC"];
            }
            $sql3 = "SELECT SALES_PERSON_DESC FROM SALES_PERSON_MT ORDER BY SALES_PERSON_DESC";
            $result3 = oci_parse($conn, $sql3);
            oci_execute($result3);
            while($row3 = oci_fetch_array($result3,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $agent[] =  $row3['SALES_PERSON_DESC'];
            }
            return view('report.sales')->with([
                "Permission" => 0, 
                "agent" => $agent, 
                "book" => $book,
                "season" => $season,
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

    public function SalesReportDownload(Request $request)
    {   
        try{
            date_default_timezone_set("Asia/karachi");
            $date = date("d-m-Y");
            $rate2 = 0;
            $data = array();
            $books = array(); $adjustment = array();
            $financial = array(); $itemtype1 = array(); $itemtype2 = array(); $dataPeriod = array();
            $sum_qty = $sum_amount = $sum_t_amount = $total_amount = $rate = 0;
            $book = $request->book;
            $season = $request->season;
            $customer = $request->customer;
            $agent = $request->agent;
            $Storedaterange = $request->daterange;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("d-m-Y", strtotime(substr($daterange, 0,10)));
            $enddte = date("d-m-Y", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $start = date("d-M-Y", strtotime(substr($daterange, 0,10)));
            $end = date("d-M-Y", strtotime(substr($daterange, -10)));
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);

            if(!empty($strtdte2)){
                $strtdte2 = $strtdte2;
            }else{
                $strtdte2 = "";
            }
            if(!empty($enddte2)){
                $enddte2 = $enddte2;
            }else{
                $enddte2 = "";
            }            
            if(!empty($book)){
                $book = $book;
            }
            if(!empty($season)){
                $season = $season;
            }
            if(!empty($agent)){
                $agent = $agent;
            }
            if(!empty($customer)){
                $customer = $customer;
            }
            else{
                $customer = "";
            }

            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            if(!empty($season)){
                if(!empty($agent)){
                    $sql = "SELECT ID.INV_SRNO AS SRNO, IM.DOCUMENT_NO AS INVC_NO, IM.INVOICE_DATE AS INVC_DATE, DM.DC_NO, SOM.SALES_ORDER_NO AS SONO, SOM.CUST_PO_NO, IBM.INV_BOOK_DESC AS BOOK,
                            CITY.CITY_DESC AS REGION, ITM.ITEM_CODE, ITM.ITEM_DESC, ITM.OLD_ART_NO, ID.PRIMARY_QTY, ID.AMOUNT, IM.CUST_PO_NO, CM.COMPANY_NAME AS CUSTOMER, CM.NTN_NO, OSD.SEASON_DEF_DESC AS SEASON,
                            ID.PRO_EXP_AMOUNT,ID.STAX_AMOUNT, ID.MATCH_WITH_ID, SPM.SALES_PERSON_DESC AS AGENT, CCM.CATAGORY_DESC AS CUST_CAT,  SGM.SHORT_DESC AS TAX_PRCNTGE,
                            ID.Stax_Amount
                            FROM INVOICE_MT IM
                            JOIN INVOICE_DETAIL ID ON ID.INVOICE_ID = IM.INVOICE_ID AND IM.INVOICE_DATE BETWEEN '$strtdte2' AND '$enddte2'
                            JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = IM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('$book','%')
                            JOIN ITEMS_MT ITM ON ITM.ITEM_ID = ID.ITEM_ID
                            LEFT JOIN STAX_GROUP_MT SGM ON SGM.STAX_GROUP_ID = ID.STAX_GROUP_ID
                            JOIN CUSTOMER_MT CM ON CM.CUSTOMER_ID = IM.CUSTOMER_ID AND CM.COMPANY_NAME LIKE NVL('$customer','%')
                            JOIN CUST_CATAGORY_MT CCM ON CCM.CATAGORY_ID = CM.CATAGORY_ID
                            JOIN SALES_PERSON_MT SPM ON SPM.SALES_PERSON_ID = IM.SALES_PERSON_ID AND SPM.SALES_PERSON_DESC LIKE NVL('$agent','%')
                            LEFT JOIN WIZ_CITY_MT CITY ON CITY.CITY_ID = SPM.SP_CITY
                            LEFT JOIN DC_DETAIL DD ON DD.DC_DET_ID = ID.MATCH_WITH_ID
                            LEFT JOIN DC_MT DM ON DM.DC_ID = DD.DC_ID
                            LEFT JOIN SALES_ORDER_DET SOD ON SOD.SALES_ORDER_DET_ID = DD.MATCH_WITH_ID
                            LEFT JOIN SALES_ORDER_MT SOM ON SOM.SALES_ORDER_ID = SOD.SALES_ORDER_ID
                            JOIN ONSOLE_SEASON_DEFINITION OSD ON OSD.SEASON_DEF_ID = SOM.SEASON_DEF_ID AND OSD.SEASON_DEF_DESC LIKE NVL('$season','%')
                            ORDER BY SRNO";
                } 
                else{
                    $sql = "SELECT ID.INV_SRNO AS SRNO, IM.DOCUMENT_NO AS INVC_NO, IM.INVOICE_DATE AS INVC_DATE, DM.DC_NO, SOM.SALES_ORDER_NO AS SONO, SOM.CUST_PO_NO, IBM.INV_BOOK_DESC AS BOOK,
                            CITY.CITY_DESC AS REGION, ITM.ITEM_CODE, ITM.ITEM_DESC, ITM.OLD_ART_NO, ID.PRIMARY_QTY, ID.AMOUNT, IM.CUST_PO_NO, CM.COMPANY_NAME AS CUSTOMER, CM.NTN_NO, OSD.SEASON_DEF_DESC AS SEASON,
                            ID.PRO_EXP_AMOUNT,ID.STAX_AMOUNT, ID.MATCH_WITH_ID, SPM.SALES_PERSON_DESC AS AGENT, CCM.CATAGORY_DESC AS CUST_CAT,  SGM.SHORT_DESC AS TAX_PRCNTGE,
                            ID.Stax_Amount
                            FROM INVOICE_MT IM
                            JOIN INVOICE_DETAIL ID ON ID.INVOICE_ID = IM.INVOICE_ID AND IM.INVOICE_DATE BETWEEN '$strtdte2' AND '$enddte2'
                            JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = IM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('$book','%')
                            JOIN ITEMS_MT ITM ON ITM.ITEM_ID = ID.ITEM_ID
                            LEFT JOIN STAX_GROUP_MT SGM ON SGM.STAX_GROUP_ID = ID.STAX_GROUP_ID
                            JOIN CUSTOMER_MT CM ON CM.CUSTOMER_ID = IM.CUSTOMER_ID AND CM.COMPANY_NAME LIKE NVL('$customer','%')
                            JOIN CUST_CATAGORY_MT CCM ON CCM.CATAGORY_ID = CM.CATAGORY_ID
                            LEFT JOIN SALES_PERSON_MT SPM ON SPM.SALES_PERSON_ID = IM.SALES_PERSON_ID AND SPM.SALES_PERSON_DESC LIKE NVL('$agent','%')
                            LEFT JOIN WIZ_CITY_MT CITY ON CITY.CITY_ID = SPM.SP_CITY
                            LEFT JOIN DC_DETAIL DD ON DD.DC_DET_ID = ID.MATCH_WITH_ID
                            LEFT JOIN DC_MT DM ON DM.DC_ID = DD.DC_ID
                            LEFT JOIN SALES_ORDER_DET SOD ON SOD.SALES_ORDER_DET_ID = DD.MATCH_WITH_ID
                            LEFT JOIN SALES_ORDER_MT SOM ON SOM.SALES_ORDER_ID = SOD.SALES_ORDER_ID
                            JOIN ONSOLE_SEASON_DEFINITION OSD ON OSD.SEASON_DEF_ID = SOM.SEASON_DEF_ID AND OSD.SEASON_DEF_DESC LIKE NVL('$season','%')
                            ORDER BY SRNO";
                }
            } 
            else{
                if(!empty($agent)){
                    $sql = "SELECT ID.INV_SRNO AS SRNO, IM.DOCUMENT_NO AS INVC_NO, IM.INVOICE_DATE AS INVC_DATE, DM.DC_NO, SOM.SALES_ORDER_NO AS SONO, SOM.CUST_PO_NO, IBM.INV_BOOK_DESC AS BOOK,
                            CITY.CITY_DESC AS REGION, ITM.ITEM_CODE, ITM.ITEM_DESC, ITM.OLD_ART_NO, ID.PRIMARY_QTY, ID.AMOUNT, IM.CUST_PO_NO, CM.COMPANY_NAME AS CUSTOMER, CM.NTN_NO, OSD.SEASON_DEF_DESC AS SEASON,
                            ID.PRO_EXP_AMOUNT,ID.STAX_AMOUNT, ID.MATCH_WITH_ID, SPM.SALES_PERSON_DESC AS AGENT, CCM.CATAGORY_DESC AS CUST_CAT,  SGM.SHORT_DESC AS TAX_PRCNTGE,
                            ID.Stax_Amount
                            FROM INVOICE_MT IM
                            JOIN INVOICE_DETAIL ID ON ID.INVOICE_ID = IM.INVOICE_ID AND IM.INVOICE_DATE BETWEEN '$strtdte2' AND '$enddte2'
                            JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = IM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('$book','%')
                            JOIN ITEMS_MT ITM ON ITM.ITEM_ID = ID.ITEM_ID
                            LEFT JOIN STAX_GROUP_MT SGM ON SGM.STAX_GROUP_ID = ID.STAX_GROUP_ID
                            JOIN CUSTOMER_MT CM ON CM.CUSTOMER_ID = IM.CUSTOMER_ID AND CM.COMPANY_NAME LIKE NVL('$customer','%')
                            JOIN CUST_CATAGORY_MT CCM ON CCM.CATAGORY_ID = CM.CATAGORY_ID
                            JOIN SALES_PERSON_MT SPM ON SPM.SALES_PERSON_ID = IM.SALES_PERSON_ID AND SPM.SALES_PERSON_DESC LIKE NVL('$agent','%')
                            LEFT JOIN WIZ_CITY_MT CITY ON CITY.CITY_ID = SPM.SP_CITY
                            LEFT JOIN DC_DETAIL DD ON DD.DC_DET_ID = ID.MATCH_WITH_ID
                            LEFT JOIN DC_MT DM ON DM.DC_ID = DD.DC_ID
                            LEFT JOIN SALES_ORDER_DET SOD ON SOD.SALES_ORDER_DET_ID = DD.MATCH_WITH_ID
                            LEFT JOIN SALES_ORDER_MT SOM ON SOM.SALES_ORDER_ID = SOD.SALES_ORDER_ID
                            LEFT JOIN ONSOLE_SEASON_DEFINITION OSD ON OSD.SEASON_DEF_ID = SOM.SEASON_DEF_ID AND OSD.SEASON_DEF_DESC LIKE NVL('$season','%')
                            ORDER BY SRNO";
                } 
                else{
                    $sql = "SELECT ID.INV_SRNO AS SRNO, IM.DOCUMENT_NO AS INVC_NO, IM.INVOICE_DATE AS INVC_DATE, DM.DC_NO, SOM.SALES_ORDER_NO AS SONO, SOM.CUST_PO_NO, IBM.INV_BOOK_DESC AS BOOK,
                            CITY.CITY_DESC AS REGION, ITM.ITEM_CODE, ITM.ITEM_DESC, ITM.OLD_ART_NO, ID.PRIMARY_QTY, ID.AMOUNT, IM.CUST_PO_NO, CM.COMPANY_NAME AS CUSTOMER, CM.NTN_NO, OSD.SEASON_DEF_DESC AS SEASON,
                            ID.PRO_EXP_AMOUNT,ID.STAX_AMOUNT, ID.MATCH_WITH_ID, SPM.SALES_PERSON_DESC AS AGENT, CCM.CATAGORY_DESC AS CUST_CAT,  SGM.SHORT_DESC AS TAX_PRCNTGE,
                            ID.Stax_Amount
                            FROM INVOICE_MT IM
                            JOIN INVOICE_DETAIL ID ON ID.INVOICE_ID = IM.INVOICE_ID AND IM.INVOICE_DATE BETWEEN '$strtdte2' AND '$enddte2'
                            JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = IM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('$book','%')
                            JOIN ITEMS_MT ITM ON ITM.ITEM_ID = ID.ITEM_ID
                            LEFT JOIN STAX_GROUP_MT SGM ON SGM.STAX_GROUP_ID = ID.STAX_GROUP_ID
                            JOIN CUSTOMER_MT CM ON CM.CUSTOMER_ID = IM.CUSTOMER_ID AND CM.COMPANY_NAME LIKE NVL('$customer','%')
                            JOIN CUST_CATAGORY_MT CCM ON CCM.CATAGORY_ID = CM.CATAGORY_ID
                            LEFT JOIN SALES_PERSON_MT SPM ON SPM.SALES_PERSON_ID = IM.SALES_PERSON_ID AND SPM.SALES_PERSON_DESC LIKE NVL('$agent','%')
                            LEFT JOIN WIZ_CITY_MT CITY ON CITY.CITY_ID = SPM.SP_CITY
                            LEFT JOIN DC_DETAIL DD ON DD.DC_DET_ID = ID.MATCH_WITH_ID
                            LEFT JOIN DC_MT DM ON DM.DC_ID = DD.DC_ID
                            LEFT JOIN SALES_ORDER_DET SOD ON SOD.SALES_ORDER_DET_ID = DD.MATCH_WITH_ID
                            LEFT JOIN SALES_ORDER_MT SOM ON SOM.SALES_ORDER_ID = SOD.SALES_ORDER_ID
                            LEFT JOIN ONSOLE_SEASON_DEFINITION OSD ON OSD.SEASON_DEF_ID = SOM.SEASON_DEF_ID AND OSD.SEASON_DEF_DESC LIKE NVL('$season','%')
                            ORDER BY SRNO";
                }
            }
            $result11 = oci_parse($conn,$sql);
            oci_execute($result11);
            while($row = oci_fetch_array($result11,  OCI_ASSOC+OCI_RETURN_NULLS)){
                if(!empty($row["STAX_AMOUNT"])){
                    $total_amount = $row["STAX_AMOUNT"] + $row["AMOUNT"];
                } 
                else{
                    $total_amount = $row["AMOUNT"];
                }
                $sum_qty = $sum_qty + $row["PRIMARY_QTY"];
                $sum_amount = $sum_amount + $row["AMOUNT"];
                $sum_t_amount = $sum_t_amount + $total_amount;
                if($row["PRIMARY_QTY"] != 0){
                    $rate = $total_amount / $row["PRIMARY_QTY"];
                } 
                else{
                    $rate = 0;
                }
                $lineData[] = array(
                    'Sr. No' => $row["SRNO"],
                    'Agent' => $row["AGENT"],
                    'Season' => $row["SEASON"],
                    'Region' => $row["REGION"],
                    'Customer Category' => $row["CUST_CAT"],
                    'Customer' => $row["CUSTOMER"],
                    'NTN No' => $row["NTN_NO"],
                    'Invoice NO' => $row["INVC_NO"],
                    'Invoice Date' => $row["INVC_DATE"],
                    'SO No' => $row["SONO"],
                    'DC No' => $row["DC_NO"],
                    'Cust PO No' => $row["CUST_PO_NO"],
                    'Book' => $row["BOOK"],
                    'Item Code' => $row["ITEM_CODE"],
                    'Item Description' => $row["ITEM_DESC"],
                    'Qty' => number_format($row["PRIMARY_QTY"],2),
                    'Rate' => number_format($rate,2),
                    'Tax%' => $row["TAX_PRCNTGE"],
                    'Amount' => number_format($row["AMOUNT"],2),
                    'Tax' => $row["STAX_AMOUNT"],
                    'Total Amount' => number_format($total_amount,2),
                );
            }
            return Excel::download(new Sales($lineData), 'Sales Report '.$date.'.xlsx');
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function SalesReportDisplay(Request $request)
    {        
        try{
            $rate2 = 0;
            $data = array();
            $bookData = array(); $seasonData = array(); $agentData = array();
            $books = array(); $adjustment = array();
            $financial = array(); $itemtype1 = array(); $itemtype2 = array(); $dataPeriod = array();
            $sum_qty = $sum_amount = $sum_t_amount = $total_amount = $rate = 0;
            $book = $request->book;
            $season = $request->season;
            $customer = $request->customer;
            $agent = $request->agent;
            $Storedaterange = $request->daterange;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("d-m-Y", strtotime(substr($daterange, 0,10)));
            $enddte = date("d-m-Y", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $start = date("d-M-Y", strtotime(substr($daterange, 0,10)));
            $end = date("d-M-Y", strtotime(substr($daterange, -10)));
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);

            if(!empty($strtdte2)){
                $strtdte2 = $strtdte2;
            }else{
                $strtdte2 = "";
            }
            if(!empty($enddte2)){
                $enddte2 = $enddte2;
            }else{
                $enddte2 = "";
            }            
            if(!empty($book)){
                $book = $book;
            }
            if(!empty($season)){
                $season = $season;
            }
            if(!empty($agent)){
                $agent = $agent;
            }
            if(!empty($customer)){
                $customer = $customer;
            }
            else{
                $customer = "";
            }

            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql1 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_BOOK_DESC LIKE 'Sales Invoice%' OR  INV_BOOK_DESC LIKE 'Sales Return%' OR  INV_BOOK_DESC LIKE 'Sales Tax%' ";
            $result1 = oci_parse($conn, $sql1);
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $bookData[] = $row1["INV_BOOK_DESC"];
            }    
            $sql2 = "SELECT SEASON_DEF_DESC FROM ONSOLE_SEASON_DEFINITION";
            $result2 = oci_parse($conn, $sql2);
            oci_execute($result2);
            while($row2 = oci_fetch_array($result2,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $seasonData[] = $row2["SEASON_DEF_DESC"];
            }
            $sql3 = "SELECT SALES_PERSON_DESC FROM SALES_PERSON_MT ORDER BY SALES_PERSON_DESC";
            $result3 = oci_parse($conn, $sql3);
            oci_execute($result3);
            while($row3 = oci_fetch_array($result3,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $agentData[] =  $row3['SALES_PERSON_DESC'];
            }
            if(!empty($season)){
                if(!empty($agent)){
                    $sql = "SELECT ID.INV_SRNO AS SRNO, IM.DOCUMENT_NO AS INVC_NO, IM.INVOICE_DATE AS INVC_DATE, DM.DC_NO, SOM.SALES_ORDER_NO AS SONO, SOM.CUST_PO_NO, IBM.INV_BOOK_DESC AS BOOK,
                            CITY.CITY_DESC AS REGION, ITM.ITEM_CODE, ITM.ITEM_DESC, ITM.OLD_ART_NO, ID.PRIMARY_QTY, ID.AMOUNT, IM.CUST_PO_NO, CM.COMPANY_NAME AS CUSTOMER, CM.NTN_NO, OSD.SEASON_DEF_DESC AS SEASON,
                            ID.PRO_EXP_AMOUNT,ID.STAX_AMOUNT, ID.MATCH_WITH_ID, SPM.SALES_PERSON_DESC AS AGENT, CCM.CATAGORY_DESC AS CUST_CAT,  SGM.SHORT_DESC AS TAX_PRCNTGE,
                            ID.Stax_Amount
                            FROM INVOICE_MT IM
                            JOIN INVOICE_DETAIL ID ON ID.INVOICE_ID = IM.INVOICE_ID AND IM.INVOICE_DATE BETWEEN '$strtdte2' AND '$enddte2'
                            JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = IM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('$book','%')
                            JOIN ITEMS_MT ITM ON ITM.ITEM_ID = ID.ITEM_ID
                            LEFT JOIN STAX_GROUP_MT SGM ON SGM.STAX_GROUP_ID = ID.STAX_GROUP_ID
                            JOIN CUSTOMER_MT CM ON CM.CUSTOMER_ID = IM.CUSTOMER_ID AND CM.COMPANY_NAME LIKE NVL('$customer','%')
                            JOIN CUST_CATAGORY_MT CCM ON CCM.CATAGORY_ID = CM.CATAGORY_ID
                            JOIN SALES_PERSON_MT SPM ON SPM.SALES_PERSON_ID = IM.SALES_PERSON_ID AND SPM.SALES_PERSON_DESC LIKE NVL('$agent','%')
                            LEFT JOIN WIZ_CITY_MT CITY ON CITY.CITY_ID = SPM.SP_CITY
                            LEFT JOIN DC_DETAIL DD ON DD.DC_DET_ID = ID.MATCH_WITH_ID
                            LEFT JOIN DC_MT DM ON DM.DC_ID = DD.DC_ID
                            LEFT JOIN SALES_ORDER_DET SOD ON SOD.SALES_ORDER_DET_ID = DD.MATCH_WITH_ID
                            LEFT JOIN SALES_ORDER_MT SOM ON SOM.SALES_ORDER_ID = SOD.SALES_ORDER_ID
                            JOIN ONSOLE_SEASON_DEFINITION OSD ON OSD.SEASON_DEF_ID = SOM.SEASON_DEF_ID AND OSD.SEASON_DEF_DESC LIKE NVL('$season','%')
                            ORDER BY SRNO";
                } 
                else{
                    $sql = "SELECT ID.INV_SRNO AS SRNO, IM.DOCUMENT_NO AS INVC_NO, IM.INVOICE_DATE AS INVC_DATE, DM.DC_NO, SOM.SALES_ORDER_NO AS SONO, SOM.CUST_PO_NO, IBM.INV_BOOK_DESC AS BOOK,
                            CITY.CITY_DESC AS REGION, ITM.ITEM_CODE, ITM.ITEM_DESC, ITM.OLD_ART_NO, ID.PRIMARY_QTY, ID.AMOUNT, IM.CUST_PO_NO, CM.COMPANY_NAME AS CUSTOMER, CM.NTN_NO, OSD.SEASON_DEF_DESC AS SEASON,
                            ID.PRO_EXP_AMOUNT,ID.STAX_AMOUNT, ID.MATCH_WITH_ID, SPM.SALES_PERSON_DESC AS AGENT, CCM.CATAGORY_DESC AS CUST_CAT,  SGM.SHORT_DESC AS TAX_PRCNTGE,
                            ID.Stax_Amount
                            FROM INVOICE_MT IM
                            JOIN INVOICE_DETAIL ID ON ID.INVOICE_ID = IM.INVOICE_ID AND IM.INVOICE_DATE BETWEEN '$strtdte2' AND '$enddte2'
                            JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = IM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('$book','%')
                            JOIN ITEMS_MT ITM ON ITM.ITEM_ID = ID.ITEM_ID
                            LEFT JOIN STAX_GROUP_MT SGM ON SGM.STAX_GROUP_ID = ID.STAX_GROUP_ID
                            JOIN CUSTOMER_MT CM ON CM.CUSTOMER_ID = IM.CUSTOMER_ID AND CM.COMPANY_NAME LIKE NVL('$customer','%')
                            JOIN CUST_CATAGORY_MT CCM ON CCM.CATAGORY_ID = CM.CATAGORY_ID
                            LEFT JOIN SALES_PERSON_MT SPM ON SPM.SALES_PERSON_ID = IM.SALES_PERSON_ID AND SPM.SALES_PERSON_DESC LIKE NVL('$agent','%')
                            LEFT JOIN WIZ_CITY_MT CITY ON CITY.CITY_ID = SPM.SP_CITY
                            LEFT JOIN DC_DETAIL DD ON DD.DC_DET_ID = ID.MATCH_WITH_ID
                            LEFT JOIN DC_MT DM ON DM.DC_ID = DD.DC_ID
                            LEFT JOIN SALES_ORDER_DET SOD ON SOD.SALES_ORDER_DET_ID = DD.MATCH_WITH_ID
                            LEFT JOIN SALES_ORDER_MT SOM ON SOM.SALES_ORDER_ID = SOD.SALES_ORDER_ID
                            JOIN ONSOLE_SEASON_DEFINITION OSD ON OSD.SEASON_DEF_ID = SOM.SEASON_DEF_ID AND OSD.SEASON_DEF_DESC LIKE NVL('$season','%')
                            ORDER BY SRNO";
                }
            } 
            else{
                if(!empty($agent)){
                    $sql = "SELECT ID.INV_SRNO AS SRNO, IM.DOCUMENT_NO AS INVC_NO, IM.INVOICE_DATE AS INVC_DATE, DM.DC_NO, SOM.SALES_ORDER_NO AS SONO, SOM.CUST_PO_NO, IBM.INV_BOOK_DESC AS BOOK,
                            CITY.CITY_DESC AS REGION, ITM.ITEM_CODE, ITM.ITEM_DESC, ITM.OLD_ART_NO, ID.PRIMARY_QTY, ID.AMOUNT, IM.CUST_PO_NO, CM.COMPANY_NAME AS CUSTOMER, CM.NTN_NO, OSD.SEASON_DEF_DESC AS SEASON,
                            ID.PRO_EXP_AMOUNT,ID.STAX_AMOUNT, ID.MATCH_WITH_ID, SPM.SALES_PERSON_DESC AS AGENT, CCM.CATAGORY_DESC AS CUST_CAT,  SGM.SHORT_DESC AS TAX_PRCNTGE,
                            ID.Stax_Amount
                            FROM INVOICE_MT IM
                            JOIN INVOICE_DETAIL ID ON ID.INVOICE_ID = IM.INVOICE_ID AND IM.INVOICE_DATE BETWEEN '$strtdte2' AND '$enddte2'
                            JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = IM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('$book','%')
                            JOIN ITEMS_MT ITM ON ITM.ITEM_ID = ID.ITEM_ID
                            LEFT JOIN STAX_GROUP_MT SGM ON SGM.STAX_GROUP_ID = ID.STAX_GROUP_ID
                            JOIN CUSTOMER_MT CM ON CM.CUSTOMER_ID = IM.CUSTOMER_ID AND CM.COMPANY_NAME LIKE NVL('$customer','%')
                            JOIN CUST_CATAGORY_MT CCM ON CCM.CATAGORY_ID = CM.CATAGORY_ID
                            JOIN SALES_PERSON_MT SPM ON SPM.SALES_PERSON_ID = IM.SALES_PERSON_ID AND SPM.SALES_PERSON_DESC LIKE NVL('$agent','%')
                            LEFT JOIN WIZ_CITY_MT CITY ON CITY.CITY_ID = SPM.SP_CITY
                            LEFT JOIN DC_DETAIL DD ON DD.DC_DET_ID = ID.MATCH_WITH_ID
                            LEFT JOIN DC_MT DM ON DM.DC_ID = DD.DC_ID
                            LEFT JOIN SALES_ORDER_DET SOD ON SOD.SALES_ORDER_DET_ID = DD.MATCH_WITH_ID
                            LEFT JOIN SALES_ORDER_MT SOM ON SOM.SALES_ORDER_ID = SOD.SALES_ORDER_ID
                            LEFT JOIN ONSOLE_SEASON_DEFINITION OSD ON OSD.SEASON_DEF_ID = SOM.SEASON_DEF_ID AND OSD.SEASON_DEF_DESC LIKE NVL('$season','%')
                            ORDER BY SRNO";
                } 
                else{
                    $sql = "SELECT ID.INV_SRNO AS SRNO, IM.DOCUMENT_NO AS INVC_NO, IM.INVOICE_DATE AS INVC_DATE, DM.DC_NO, SOM.SALES_ORDER_NO AS SONO, SOM.CUST_PO_NO, IBM.INV_BOOK_DESC AS BOOK,
                            CITY.CITY_DESC AS REGION, ITM.ITEM_CODE, ITM.ITEM_DESC, ITM.OLD_ART_NO, ID.PRIMARY_QTY, ID.AMOUNT, IM.CUST_PO_NO, CM.COMPANY_NAME AS CUSTOMER, CM.NTN_NO, OSD.SEASON_DEF_DESC AS SEASON,
                            ID.PRO_EXP_AMOUNT,ID.STAX_AMOUNT, ID.MATCH_WITH_ID, SPM.SALES_PERSON_DESC AS AGENT, CCM.CATAGORY_DESC AS CUST_CAT,  SGM.SHORT_DESC AS TAX_PRCNTGE,
                            ID.Stax_Amount
                            FROM INVOICE_MT IM
                            JOIN INVOICE_DETAIL ID ON ID.INVOICE_ID = IM.INVOICE_ID AND IM.INVOICE_DATE BETWEEN '$strtdte2' AND '$enddte2'
                            JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = IM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('$book','%')
                            JOIN ITEMS_MT ITM ON ITM.ITEM_ID = ID.ITEM_ID
                            LEFT JOIN STAX_GROUP_MT SGM ON SGM.STAX_GROUP_ID = ID.STAX_GROUP_ID
                            JOIN CUSTOMER_MT CM ON CM.CUSTOMER_ID = IM.CUSTOMER_ID AND CM.COMPANY_NAME LIKE NVL('$customer','%')
                            JOIN CUST_CATAGORY_MT CCM ON CCM.CATAGORY_ID = CM.CATAGORY_ID
                            LEFT JOIN SALES_PERSON_MT SPM ON SPM.SALES_PERSON_ID = IM.SALES_PERSON_ID AND SPM.SALES_PERSON_DESC LIKE NVL('$agent','%')
                            LEFT JOIN WIZ_CITY_MT CITY ON CITY.CITY_ID = SPM.SP_CITY
                            LEFT JOIN DC_DETAIL DD ON DD.DC_DET_ID = ID.MATCH_WITH_ID
                            LEFT JOIN DC_MT DM ON DM.DC_ID = DD.DC_ID
                            LEFT JOIN SALES_ORDER_DET SOD ON SOD.SALES_ORDER_DET_ID = DD.MATCH_WITH_ID
                            LEFT JOIN SALES_ORDER_MT SOM ON SOM.SALES_ORDER_ID = SOD.SALES_ORDER_ID
                            LEFT JOIN ONSOLE_SEASON_DEFINITION OSD ON OSD.SEASON_DEF_ID = SOM.SEASON_DEF_ID AND OSD.SEASON_DEF_DESC LIKE NVL('$season','%')
                            ORDER BY SRNO";
                }
            }
            $result11 = oci_parse($conn,$sql);
            oci_execute($result11);
            while($row = oci_fetch_array($result11,  OCI_ASSOC+OCI_RETURN_NULLS)){
                if(!empty($row["STAX_AMOUNT"])){
                    $total_amount = $row["STAX_AMOUNT"] + $row["AMOUNT"];
                } 
                else{
                    $total_amount = $row["AMOUNT"];
                }
                $sum_qty = $sum_qty + $row["PRIMARY_QTY"];
                $sum_amount = $sum_amount + $row["AMOUNT"];
                $sum_t_amount = $sum_t_amount + $total_amount;
                if($row["PRIMARY_QTY"] != 0){
                    $rate = $total_amount / $row["PRIMARY_QTY"];
                } 
                else{
                    $rate = 0;
                }
                $data[] = array(
                    'data' => $row,
                    'total_amount' => $total_amount,
                    'sum_qty' => $sum_qty,
                    'sum_amount' => $sum_amount,
                    'sum_t_amount' => $sum_t_amount,
                    'rate' => $rate,
                );
            }

            $strtdte2a = date("m/d/Y", strtotime(substr($daterange, 0,10)));
            $strtdte3a = date("m/d/Y", strtotime(substr($daterange, 10)));

            $sessionData = [
                'book' => $request->book,
                'agent' => $request->agent,
                'season' => $request->season,
                'customer' => $request->customer,
                'strtdte2a' => $strtdte2a,
                'strtdte3a' => $strtdte3a,
                'Storestart' => date("d/m/Y", strtotime(substr($Storedaterange, 0,10))),
                'Storeend' => date("d/m/Y", strtotime(substr($Storedaterange, -10))),
                'Storestart1' => date("d-M-Y", strtotime(substr($Storedaterange, 0,10))),
                'Storeend2' => date("d-M-Y", strtotime(substr($Storedaterange, -10))),
            ];

            return view('report.sales')->with([
                "data" => $data, "Permission" => 1, "sessionData" => $sessionData, "period" => $dataPeriod, "financial" => $financial, 
                "itemtype1" => $itemtype1, "itemtype2" => $itemtype2, "i" => 1, "agent" => $agentData, "book" => $bookData, "season" => $seasonData,
                'sum_qty' => $sum_qty, 'sum_amount' => $sum_amount, 'sum_t_amount' => $sum_t_amount,
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

    public function SalesOrder(Request $request)
    {
        try{
            $book = array(); $season = array(); $agent = array(); $category = array(); $subCategory = array();
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql1 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_BOOK_DESC LIKE 'Sales Order%'";
            $result1 = oci_parse($conn, $sql1);
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $book[] = $row1["INV_BOOK_DESC"];
            }    
            $sql2 = "SELECT SEASON_DEF_DESC FROM ONSOLE_SEASON_DEFINITION";
            $result2 = oci_parse($conn, $sql2);
            oci_execute($result2);
            while($row2 = oci_fetch_array($result2,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $season[] = $row2["SEASON_DEF_DESC"];
            }
            $sql3 = "SELECT SALES_PERSON_DESC FROM SALES_PERSON_MT ORDER BY SALES_PERSON_DESC";
            $result3 = oci_parse($conn, $sql3);
            oci_execute($result3);
            while($row3 = oci_fetch_array($result3,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $agent[] =  $row3['SALES_PERSON_DESC'];
            }
            $sql4 = "SELECT W1.SEGMENT_VALUE_DESC FROM WIZ_SEGMENT01 W1 WHERE W1.STRUCTURE_ID = 26";
            $result4 = oci_parse($conn, $sql4);
            oci_execute($result4);
            while($row4 =oci_fetch_array($result4,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $category[] = $row4["SEGMENT_VALUE_DESC"];
            }
            $sql5 = "SELECT W2.SEGMENT_VALUE_DESC FROM WIZ_SEGMENT02 W2 WHERE W2.STRUCTURE_ID = 26";
            $result5 = oci_parse($conn, $sql5);
            oci_execute($result5);
            while($row5 =oci_fetch_array($result5,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $subCategory[] = $row5["SEGMENT_VALUE_DESC"];
            }
            return view('report.salesorder')->with([
                "Permission" => 0, 
                "agent" => $agent, 
                "book" => $book,
                "season" => $season,
                "category" => $category,
                "subCategory" => $subCategory,
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

    public function SalesOrderReportDownload(Request $request)
    {   
        try{
            date_default_timezone_set("Asia/karachi");
            $date = date("d-m-Y");
            $rate2 = 0;
            $data = array();
            $sum_qty = $sum_amount = $sum_t_amount = $total_amount = $rate = 0;
            $book = $request->book;
            $season = $request->season;
            $customer = $request->customer;
            $agent = $request->agent;
            $category = $request->category;
            $subCategory = $request->subCategory;
            $Storedaterange = $request->daterange;
            $sono = $request->sono;
            $articlecode = $request->articlecode;            
            $itemcode =  $request->itemcode;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("d-m-Y", strtotime(substr($daterange, 0,10)));
            $enddte = date("d-m-Y", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $start = date("d-M-Y", strtotime(substr($daterange, 0,10)));
            $end = date("d-M-Y", strtotime(substr($daterange, -10)));
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);

            if(!empty($strtdte2)){
                $strtdte2 = $strtdte2;
            }else{
                $strtdte2 = "";
            }
            if(!empty($enddte2)){
                $enddte2 = $enddte2;
            }else{
                $enddte2 = "";
            }            
            if(!empty($book)){
                $book = $book;
            }
            else{
                $book = "";
            }  
            if(!empty($season)){
                $season = $season;
            }
            else{
                $season = "";
            }  
            if(!empty($itemcode)){
                $itemcode = $itemcode;
            }
            else{
                $itemcode = "";
            }  
            if(!empty($agent)){
                $agent = $agent;
            }
            else{
                $agent = "";
            }  
            if(!empty($subCategory)){
                $subCategory = $subCategory;
            }
            else{
                $subCategory = "";
            }  
            if(!empty($category)){
                $category = $category;
            }
            else{
                $category = "";
            }  
            if(!empty($customer)){
                $customer = $customer;
            }
            else{
                $customer = "";
            }
            if(!empty($sono)){
                $sonoarr = explode(" || ", $sono);
                $sono = $sonoarr[0];
            }
            if(!empty($articlecode)){
                $articlecode = $articlecode;
            }
            else{
                $articlecode = "";
            }
            if(!empty($itemcode)){
                $rmcoarr = explode(" || ", $itemcode);
                $rmcode = $rmcoarr[0];
            }
            else{
                $rmcode = "";
            }
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            if(!empty($suno)) {
                $sql = "SELECT SOM.SALES_ORDER_NO, SOM.ORDER_DATE, IBM.INV_BOOK_DESC, STM.SO_TYPE_DESC, CCM.CATAGORY_DESC, CM.COMPANY_NAME, OCB.BRAND_DESC, SPM.SALES_PERSON_DESC, PTM.PAYMENT_TERM_DESC, SOSM.SO_STATUS_DESC,
                        OSD.SEASON_DEF_DESC,  IM.ITEM_CODE, IM.ITEM_DESC, SOT.PRIMARY_QTY, SOT.TC_AMOUNT, SGM.STAX_GROUP_DESC, SOT.STAX_AMOUNT, SOM.CUST_PO_NO, W3.SEGMENT_VALUE_DESC AS ART_CODE, TO_DATE(SOM.CUST_PO_DATE, 'dd-Mon-yy') AS DEL_DATE,
                        (W1.SEGMENT_VALUE || '-' || W2.SEGMENT_VALUE || '-' || W3.SEGMENT_VALUE || '-' || W4.SEGMENT_VALUE || '-' || W5.SEGMENT_VALUE || '-' || W6.SEGMENT_VALUE || '-' || W7.SEGMENT_VALUE) AS CAT_CODE,
                        (W1.SEGMENT_VALUE_DESC || '-' || W2.SEGMENT_VALUE_DESC || '-' || W3.SEGMENT_VALUE_DESC || '-' || W4.SEGMENT_VALUE_DESC || '-' || W5.SEGMENT_VALUE_DESC || '-' || W6.SEGMENT_VALUE_DESC || '-' || W7.SEGMENT_VALUE_DESC) AS CAT_DESC                        
                        FROM SALES_ORDER_MT SOM                        
                        JOIN SALES_ORDER_DET SOT ON SOT.SALES_ORDER_ID = SOM.SALES_ORDER_ID
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = SOM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('$book','%')
                        JOIN WIZ_SO_STATUS_MT SOSM ON SOSM.SO_STATUS_ID = SOM.SO_STATUS_ID
                        JOIN SO_TYPE_MT STM ON STM.SO_TYPE_ID = SOM.SO_TYPE_ID
                        JOIN CUSTOMER_MT CM ON CM.CUSTOMER_ID = SOM.CUSTOMER_ID AND CM.COMPANY_NAME LIKE NVL('$customer','%')
                        JOIN SALES_PERSON_MT SPM ON SPM.SALES_PERSON_ID = SOM.SELLER_ID AND SPM.SALES_PERSON_DESC LIKE NVL('$agent','%')
                        JOIN PAYMENT_TERMS_MT PTM ON PTM.PAYMENT_TERM_ID = SOM.PAYMENT_TERM_ID
                        JOIN ONSOLE_SEASON_DEFINITION OSD ON OSD.SEASON_DEF_ID = SOM.SEASON_DEF_ID AND OSD.SEASON_DEF_DESC LIKE NVL('$season','%')
                        JOIN ITEMS_MT IM ON IM.ITEM_ID = SOT.ITEM_ID AND IM.ITEM_CODE LIKE NVL('$rmcode','%')
                        LEFT JOIN STAX_GROUP_MT SGM ON SGM.STAX_GROUP_ID = SOT.STAX_GROUP_ID
                        JOIN CUST_CATAGORY_MT CCM ON CCM.CATAGORY_ID = CM.CATAGORY_ID
                        LEFT JOIN ONSOLE_CUSTOMER_BRAND OCB ON OCB.CUST_BRAND_ID = SOM.CUST_BRAND_ID
                        JOIN ITEMS_CATEGORY IC ON IC.ITEM_ID = IM.ITEM_ID
                        JOIN CODE_COMBINATIONS CC ON CC.CODE_COMBINATION_ID = IC.CODE_COMBINATION_ID
                        JOIN WIZ_SEGMENT01 W1 ON W1.SEGMENT_ID = CC.SEGMENT_ID01 AND W1.STRUCTURE_ID = CC.STRUCTURE_ID AND W1.SEGMENT_VALUE_DESC LIKE NVL('$category','%')
                        JOIN WIZ_SEGMENT02 W2 ON W2.SEGMENT_ID = CC.SEGMENT_ID02 AND W2.STRUCTURE_ID = CC.STRUCTURE_ID AND W2.SEGMENT_VALUE_DESC LIKE NVL('$subCategory','%')
                        JOIN WIZ_SEGMENT03 W3 ON W3.SEGMENT_ID = CC.SEGMENT_ID03 AND W3.STRUCTURE_ID = CC.STRUCTURE_ID AND W3.SEGMENT_VALUE_DESC LIKE NVL('$articlecode','%')
                        JOIN WIZ_SEGMENT04 W4 ON W4.SEGMENT_ID = CC.SEGMENT_ID04 AND W4.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT05 W5 ON W5.SEGMENT_ID = CC.SEGMENT_ID05 AND W5.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT06 W6 ON W6.SEGMENT_ID = CC.SEGMENT_ID06 AND W6.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT07 W7 ON W7.SEGMENT_ID = CC.SEGMENT_ID07 AND W7.STRUCTURE_ID = CC.STRUCTURE_ID                        
                        WHERE SOM.SALES_ORDER_NO = '$sonoarr[0]' AND TO_CHAR(SOM.ORDER_DATE, 'dd-MON-yy') = '$sonoarr[1]'                        
                        ORDER BY CM.COMPANY_NAME, SOM.SALES_ORDER_NO, SOM.ORDER_DATE DESC";
            } 
            else{
                $sql = "SELECT SOM.SALES_ORDER_NO, SOM.ORDER_DATE, IBM.INV_BOOK_DESC, STM.SO_TYPE_DESC, CCM.CATAGORY_DESC, CM.COMPANY_NAME, OCB.BRAND_DESC, SPM.SALES_PERSON_DESC, PTM.PAYMENT_TERM_DESC,
                        OSD.SEASON_DEF_DESC,  IM.ITEM_CODE, IM.ITEM_DESC, SOT.PRIMARY_QTY, SOT.TC_AMOUNT, SGM.STAX_GROUP_DESC, SOT.STAX_AMOUNT, SOM.CUST_PO_NO, W3.SEGMENT_VALUE_DESC AS ART_CODE, TO_DATE(SOM.CUST_PO_DATE, 'dd-Mon-yy') AS DEL_DATE, SOSM.SO_STATUS_DESC,
                        (W1.SEGMENT_VALUE || '-' || W2.SEGMENT_VALUE || '-' || W3.SEGMENT_VALUE || '-' || W4.SEGMENT_VALUE || '-' || W5.SEGMENT_VALUE || '-' || W6.SEGMENT_VALUE || '-' || W7.SEGMENT_VALUE) AS CAT_CODE,
                        (W1.SEGMENT_VALUE_DESC || '-' || W2.SEGMENT_VALUE_DESC || '-' || W3.SEGMENT_VALUE_DESC || '-' || W4.SEGMENT_VALUE_DESC || '-' || W5.SEGMENT_VALUE_DESC || '-' || W6.SEGMENT_VALUE_DESC || '-' || W7.SEGMENT_VALUE_DESC) AS CAT_DESC                        
                        FROM SALES_ORDER_MT SOM                        
                        JOIN SALES_ORDER_DET SOT ON SOT.SALES_ORDER_ID = SOM.SALES_ORDER_ID
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = SOM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('$book','%')
                        JOIN WIZ_SO_STATUS_MT SOSM ON SOSM.SO_STATUS_ID = SOM.SO_STATUS_ID
                        JOIN SO_TYPE_MT STM ON STM.SO_TYPE_ID = SOM.SO_TYPE_ID
                        JOIN CUSTOMER_MT CM ON CM.CUSTOMER_ID = SOM.CUSTOMER_ID AND CM.COMPANY_NAME LIKE NVL('$customer','%')
                        JOIN SALES_PERSON_MT SPM ON SPM.SALES_PERSON_ID = SOM.SELLER_ID AND SPM.SALES_PERSON_DESC LIKE NVL('$agent','%')
                        JOIN PAYMENT_TERMS_MT PTM ON PTM.PAYMENT_TERM_ID = SOM.PAYMENT_TERM_ID
                        JOIN ONSOLE_SEASON_DEFINITION OSD ON OSD.SEASON_DEF_ID = SOM.SEASON_DEF_ID AND OSD.SEASON_DEF_DESC LIKE NVL('$season','%')
                        JOIN ITEMS_MT IM ON IM.ITEM_ID = SOT.ITEM_ID AND IM.ITEM_CODE LIKE NVL('$rmcode','%')
                        LEFT JOIN STAX_GROUP_MT SGM ON SGM.STAX_GROUP_ID = SOT.STAX_GROUP_ID
                        JOIN CUST_CATAGORY_MT CCM ON CCM.CATAGORY_ID = CM.CATAGORY_ID
                        LEFT JOIN ONSOLE_CUSTOMER_BRAND OCB ON OCB.CUST_BRAND_ID = SOM.CUST_BRAND_ID
                        JOIN ITEMS_CATEGORY IC ON IC.ITEM_ID = IM.ITEM_ID
                        JOIN CODE_COMBINATIONS CC ON CC.CODE_COMBINATION_ID = IC.CODE_COMBINATION_ID
                        JOIN WIZ_SEGMENT01 W1 ON W1.SEGMENT_ID = CC.SEGMENT_ID01 AND W1.STRUCTURE_ID = CC.STRUCTURE_ID AND W1.SEGMENT_VALUE_DESC LIKE NVL('$category','%')
                        JOIN WIZ_SEGMENT02 W2 ON W2.SEGMENT_ID = CC.SEGMENT_ID02 AND W2.STRUCTURE_ID = CC.STRUCTURE_ID AND W2.SEGMENT_VALUE_DESC LIKE NVL('$subCategory','%')
                        JOIN WIZ_SEGMENT03 W3 ON W3.SEGMENT_ID = CC.SEGMENT_ID03 AND W3.STRUCTURE_ID = CC.STRUCTURE_ID AND W3.SEGMENT_VALUE_DESC LIKE NVL('$articlecode','%')
                        JOIN WIZ_SEGMENT04 W4 ON W4.SEGMENT_ID = CC.SEGMENT_ID04 AND W4.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT05 W5 ON W5.SEGMENT_ID = CC.SEGMENT_ID05 AND W5.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT06 W6 ON W6.SEGMENT_ID = CC.SEGMENT_ID06 AND W6.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT07 W7 ON W7.SEGMENT_ID = CC.SEGMENT_ID07 AND W7.STRUCTURE_ID = CC.STRUCTURE_ID                        
                        WHERE SOM.ORDER_DATE BETWEEN '$strtdte2' AND '$enddte2'                        
                        ORDER BY CM.COMPANY_NAME, SOM.SALES_ORDER_NO, SOM.ORDER_DATE DESC";
            }
            $result11 = oci_parse($conn,$sql);
            oci_execute($result11);
            while($row = oci_fetch_array($result11,  OCI_ASSOC+OCI_RETURN_NULLS)){
                if(!empty($row["STAX_AMOUNT"])){
                    $total_amount = $row["STAX_AMOUNT"] + $row["TC_AMOUNT"];
                } 
                else{
                    $total_amount = $row["TC_AMOUNT"];
                }
                $sum_qty = $sum_qty + $row["PRIMARY_QTY"];
                $sum_amount = $sum_amount + $row["TC_AMOUNT"];
                $sum_t_amount = $sum_t_amount + $total_amount;
                if($row["PRIMARY_QTY"] != 0){
                    $rate = $total_amount / $row["PRIMARY_QTY"];
                } 
                else{
                    $rate = 0;
                }
                $lineData[] = array(
                    'Sr. No' => $row["SALES_ORDER_NO"],
                    'Profuct Category' => $row["SO_TYPE_DESC"],
                    'So Date' => $row["ORDER_DATE"],
                    'Customer Category' => $row["CATAGORY_DESC"],
                    'Customer' => $row["COMPANY_NAME"],
                    'Sales Person' => $row["SALES_PERSON_DESC"],
                    'Season' => $row["SEASON_DEF_DESC"],
                    'Payment Term' => $row["PAYMENT_TERM_DESC"],
                    'Customer PO' => $row["CUST_PO_NO"],
                    'Delivery Date' => $row["DEL_DATE"],
                    'Status' => $row["SO_STATUS_DESC"],
                    'Article' => $row["ART_CODE"],
                    'Item Code' => $row["ITEM_CODE"],
                    'Item Desc' => $row["ITEM_DESC"],
                    'Qty' => number_format($row["PRIMARY_QTY"],2),
                    'Rate' => number_format($rate,2),
                    'Amount' => number_format($row["TC_AMOUNT"],2),
                    'Sales Tax %' => $row["STAX_GROUP_DESC"],
                    'Sales Tax Amount' =>  number_format($row["STAX_AMOUNT"],2),
                    'Total Amount' => number_format($total_amount,2),
                    'Category Code' => $row["CAT_CODE"],
                    'Category Description' => $row["CAT_DESC"],
                );
            }
            return Excel::download(new SalesOrder($lineData), 'Sales Order Report '.$date.'.xlsx');
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function SalesOrderReportDisplay(Request $request)
    {        
        try{
            $rate2 = 0;
            $data = array();
            $bookData = array(); $seasonData = array(); $agentData = array(); $categoryData = array(); $subCategoryData = array();
            $sum_qty = $sum_amount = $sum_t_amount = $total_amount = $rate = 0;
            $book = $request->book;
            $season = $request->season;
            $customer = $request->customer;
            $agent = $request->agent;
            $category = $request->category;
            $subCategory = $request->subCategory;
            $Storedaterange = $request->daterange;
            $sono = $request->sono;
            $articlecode = $request->articlecode;            
            $itemcode =  $request->itemcode;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("d-m-Y", strtotime(substr($daterange, 0,10)));
            $enddte = date("d-m-Y", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $start = date("d-M-Y", strtotime(substr($daterange, 0,10)));
            $end = date("d-M-Y", strtotime(substr($daterange, -10)));
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);

            if(!empty($strtdte2)){
                $strtdte2 = $strtdte2;
            }else{
                $strtdte2 = "";
            }
            if(!empty($enddte2)){
                $enddte2 = $enddte2;
            }else{
                $enddte2 = "";
            }            
            if(!empty($book)){
                $book = $book;
            }
            else{
                $book = "";
            }  
            if(!empty($season)){
                $season = $season;
            }
            else{
                $season = "";
            }  
            if(!empty($itemcode)){
                $itemcode = $itemcode;
            }
            else{
                $itemcode = "";
            }  
            if(!empty($agent)){
                $agent = $agent;
            }
            else{
                $agent = "";
            }  
            if(!empty($subCategory)){
                $subCategory = $subCategory;
            }
            else{
                $subCategory = "";
            }  
            if(!empty($category)){
                $category = $category;
            }
            else{
                $category = "";
            }  
            if(!empty($customer)){
                $customer = $customer;
            }
            else{
                $customer = "";
            }
            if(!empty($sono)){
                $sonoarr = explode(" || ", $sono);
                $sono = $sonoarr[0];
            }
            if(!empty($articlecode)){
                $articlecode = $articlecode;
            }
            else{
                $articlecode = "";
            }
            if(!empty($itemcode)){
                $rmcoarr = explode(" || ", $itemcode);
                $rmcode = $rmcoarr[0];
            }
            else{
                $rmcode = "";
            }

            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql1 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_BOOK_DESC LIKE 'Sales Order%'";
            $result1 = oci_parse($conn, $sql1);
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $bookData[] = $row1["INV_BOOK_DESC"];
            }    
            $sql2 = "SELECT SEASON_DEF_DESC FROM ONSOLE_SEASON_DEFINITION";
            $result2 = oci_parse($conn, $sql2);
            oci_execute($result2);
            while($row2 = oci_fetch_array($result2,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $seasonData[] = $row2["SEASON_DEF_DESC"];
            }
            $sql3 = "SELECT SALES_PERSON_DESC FROM SALES_PERSON_MT ORDER BY SALES_PERSON_DESC";
            $result3 = oci_parse($conn, $sql3);
            oci_execute($result3);
            while($row3 = oci_fetch_array($result3,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $agentData[] =  $row3['SALES_PERSON_DESC'];
            }
            $sql4 = "SELECT W1.SEGMENT_VALUE_DESC FROM WIZ_SEGMENT01 W1 WHERE W1.STRUCTURE_ID = 26";
            $result4 = oci_parse($conn, $sql4);
            oci_execute($result4);
            while($row4 = oci_fetch_array($result4,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $categoryData[] = $row4["SEGMENT_VALUE_DESC"];
            }
            $sql5 = "SELECT W2.SEGMENT_VALUE_DESC FROM WIZ_SEGMENT02 W2 WHERE W2.STRUCTURE_ID = 26";
            $result5 = oci_parse($conn, $sql5);
            oci_execute($result5);
            while($row5 = oci_fetch_array($result5,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $subCategoryData[] = $row5["SEGMENT_VALUE_DESC"];
            }
            if(!empty($suno)) {
                $sql = "SELECT SOM.SALES_ORDER_NO, SOM.ORDER_DATE, IBM.INV_BOOK_DESC, STM.SO_TYPE_DESC, CCM.CATAGORY_DESC, CM.COMPANY_NAME, OCB.BRAND_DESC, SPM.SALES_PERSON_DESC, PTM.PAYMENT_TERM_DESC, SOSM.SO_STATUS_DESC,
                        OSD.SEASON_DEF_DESC,  IM.ITEM_CODE, IM.ITEM_DESC, SOT.PRIMARY_QTY, SOT.TC_AMOUNT, SGM.STAX_GROUP_DESC, SOT.STAX_AMOUNT, SOM.CUST_PO_NO, W3.SEGMENT_VALUE_DESC AS ART_CODE, TO_DATE(SOM.CUST_PO_DATE, 'dd-Mon-yy') AS DEL_DATE,
                        (W1.SEGMENT_VALUE || '-' || W2.SEGMENT_VALUE || '-' || W3.SEGMENT_VALUE || '-' || W4.SEGMENT_VALUE || '-' || W5.SEGMENT_VALUE || '-' || W6.SEGMENT_VALUE || '-' || W7.SEGMENT_VALUE) AS CAT_CODE,
                        (W1.SEGMENT_VALUE_DESC || '-' || W2.SEGMENT_VALUE_DESC || '-' || W3.SEGMENT_VALUE_DESC || '-' || W4.SEGMENT_VALUE_DESC || '-' || W5.SEGMENT_VALUE_DESC || '-' || W6.SEGMENT_VALUE_DESC || '-' || W7.SEGMENT_VALUE_DESC) AS CAT_DESC                        
                        FROM SALES_ORDER_MT SOM                        
                        JOIN SALES_ORDER_DET SOT ON SOT.SALES_ORDER_ID = SOM.SALES_ORDER_ID
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = SOM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('$book','%')
                        JOIN WIZ_SO_STATUS_MT SOSM ON SOSM.SO_STATUS_ID = SOM.SO_STATUS_ID
                        JOIN SO_TYPE_MT STM ON STM.SO_TYPE_ID = SOM.SO_TYPE_ID
                        JOIN CUSTOMER_MT CM ON CM.CUSTOMER_ID = SOM.CUSTOMER_ID AND CM.COMPANY_NAME LIKE NVL('$customer','%')
                        JOIN SALES_PERSON_MT SPM ON SPM.SALES_PERSON_ID = SOM.SELLER_ID AND SPM.SALES_PERSON_DESC LIKE NVL('$agent','%')
                        JOIN PAYMENT_TERMS_MT PTM ON PTM.PAYMENT_TERM_ID = SOM.PAYMENT_TERM_ID
                        JOIN ONSOLE_SEASON_DEFINITION OSD ON OSD.SEASON_DEF_ID = SOM.SEASON_DEF_ID AND OSD.SEASON_DEF_DESC LIKE NVL('$season','%')
                        JOIN ITEMS_MT IM ON IM.ITEM_ID = SOT.ITEM_ID AND IM.ITEM_CODE LIKE NVL('$rmcode','%')
                        LEFT JOIN STAX_GROUP_MT SGM ON SGM.STAX_GROUP_ID = SOT.STAX_GROUP_ID
                        JOIN CUST_CATAGORY_MT CCM ON CCM.CATAGORY_ID = CM.CATAGORY_ID
                        LEFT JOIN ONSOLE_CUSTOMER_BRAND OCB ON OCB.CUST_BRAND_ID = SOM.CUST_BRAND_ID
                        JOIN ITEMS_CATEGORY IC ON IC.ITEM_ID = IM.ITEM_ID
                        JOIN CODE_COMBINATIONS CC ON CC.CODE_COMBINATION_ID = IC.CODE_COMBINATION_ID
                        JOIN WIZ_SEGMENT01 W1 ON W1.SEGMENT_ID = CC.SEGMENT_ID01 AND W1.STRUCTURE_ID = CC.STRUCTURE_ID AND W1.SEGMENT_VALUE_DESC LIKE NVL('$category','%')
                        JOIN WIZ_SEGMENT02 W2 ON W2.SEGMENT_ID = CC.SEGMENT_ID02 AND W2.STRUCTURE_ID = CC.STRUCTURE_ID AND W2.SEGMENT_VALUE_DESC LIKE NVL('$subCategory','%')
                        JOIN WIZ_SEGMENT03 W3 ON W3.SEGMENT_ID = CC.SEGMENT_ID03 AND W3.STRUCTURE_ID = CC.STRUCTURE_ID AND W3.SEGMENT_VALUE_DESC LIKE NVL('$articlecode','%')
                        JOIN WIZ_SEGMENT04 W4 ON W4.SEGMENT_ID = CC.SEGMENT_ID04 AND W4.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT05 W5 ON W5.SEGMENT_ID = CC.SEGMENT_ID05 AND W5.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT06 W6 ON W6.SEGMENT_ID = CC.SEGMENT_ID06 AND W6.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT07 W7 ON W7.SEGMENT_ID = CC.SEGMENT_ID07 AND W7.STRUCTURE_ID = CC.STRUCTURE_ID                        
                        WHERE SOM.SALES_ORDER_NO = '$sonoarr[0]' AND TO_CHAR(SOM.ORDER_DATE, 'dd-MON-yy') = '$sonoarr[1]'                        
                        ORDER BY CM.COMPANY_NAME, SOM.SALES_ORDER_NO, SOM.ORDER_DATE DESC";
            } 
            else{
                $sql = "SELECT SOM.SALES_ORDER_NO, SOM.ORDER_DATE, IBM.INV_BOOK_DESC, STM.SO_TYPE_DESC, CCM.CATAGORY_DESC, CM.COMPANY_NAME, OCB.BRAND_DESC, SPM.SALES_PERSON_DESC, PTM.PAYMENT_TERM_DESC,
                        OSD.SEASON_DEF_DESC,  IM.ITEM_CODE, IM.ITEM_DESC, SOT.PRIMARY_QTY, SOT.TC_AMOUNT, SGM.STAX_GROUP_DESC, SOT.STAX_AMOUNT, SOM.CUST_PO_NO, W3.SEGMENT_VALUE_DESC AS ART_CODE, TO_DATE(SOM.CUST_PO_DATE, 'dd-Mon-yy') AS DEL_DATE, SOSM.SO_STATUS_DESC,
                        (W1.SEGMENT_VALUE || '-' || W2.SEGMENT_VALUE || '-' || W3.SEGMENT_VALUE || '-' || W4.SEGMENT_VALUE || '-' || W5.SEGMENT_VALUE || '-' || W6.SEGMENT_VALUE || '-' || W7.SEGMENT_VALUE) AS CAT_CODE,
                        (W1.SEGMENT_VALUE_DESC || '-' || W2.SEGMENT_VALUE_DESC || '-' || W3.SEGMENT_VALUE_DESC || '-' || W4.SEGMENT_VALUE_DESC || '-' || W5.SEGMENT_VALUE_DESC || '-' || W6.SEGMENT_VALUE_DESC || '-' || W7.SEGMENT_VALUE_DESC) AS CAT_DESC                        
                        FROM SALES_ORDER_MT SOM                        
                        JOIN SALES_ORDER_DET SOT ON SOT.SALES_ORDER_ID = SOM.SALES_ORDER_ID
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = SOM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('$book','%')
                        JOIN WIZ_SO_STATUS_MT SOSM ON SOSM.SO_STATUS_ID = SOM.SO_STATUS_ID
                        JOIN SO_TYPE_MT STM ON STM.SO_TYPE_ID = SOM.SO_TYPE_ID
                        JOIN CUSTOMER_MT CM ON CM.CUSTOMER_ID = SOM.CUSTOMER_ID AND CM.COMPANY_NAME LIKE NVL('$customer','%')
                        JOIN SALES_PERSON_MT SPM ON SPM.SALES_PERSON_ID = SOM.SELLER_ID AND SPM.SALES_PERSON_DESC LIKE NVL('$agent','%')
                        JOIN PAYMENT_TERMS_MT PTM ON PTM.PAYMENT_TERM_ID = SOM.PAYMENT_TERM_ID
                        JOIN ONSOLE_SEASON_DEFINITION OSD ON OSD.SEASON_DEF_ID = SOM.SEASON_DEF_ID AND OSD.SEASON_DEF_DESC LIKE NVL('$season','%')
                        JOIN ITEMS_MT IM ON IM.ITEM_ID = SOT.ITEM_ID AND IM.ITEM_CODE LIKE NVL('$rmcode','%')
                        LEFT JOIN STAX_GROUP_MT SGM ON SGM.STAX_GROUP_ID = SOT.STAX_GROUP_ID
                        JOIN CUST_CATAGORY_MT CCM ON CCM.CATAGORY_ID = CM.CATAGORY_ID
                        LEFT JOIN ONSOLE_CUSTOMER_BRAND OCB ON OCB.CUST_BRAND_ID = SOM.CUST_BRAND_ID
                        JOIN ITEMS_CATEGORY IC ON IC.ITEM_ID = IM.ITEM_ID
                        JOIN CODE_COMBINATIONS CC ON CC.CODE_COMBINATION_ID = IC.CODE_COMBINATION_ID
                        JOIN WIZ_SEGMENT01 W1 ON W1.SEGMENT_ID = CC.SEGMENT_ID01 AND W1.STRUCTURE_ID = CC.STRUCTURE_ID AND W1.SEGMENT_VALUE_DESC LIKE NVL('$category','%')
                        JOIN WIZ_SEGMENT02 W2 ON W2.SEGMENT_ID = CC.SEGMENT_ID02 AND W2.STRUCTURE_ID = CC.STRUCTURE_ID AND W2.SEGMENT_VALUE_DESC LIKE NVL('$subCategory','%')
                        JOIN WIZ_SEGMENT03 W3 ON W3.SEGMENT_ID = CC.SEGMENT_ID03 AND W3.STRUCTURE_ID = CC.STRUCTURE_ID AND W3.SEGMENT_VALUE_DESC LIKE NVL('$articlecode','%')
                        JOIN WIZ_SEGMENT04 W4 ON W4.SEGMENT_ID = CC.SEGMENT_ID04 AND W4.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT05 W5 ON W5.SEGMENT_ID = CC.SEGMENT_ID05 AND W5.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT06 W6 ON W6.SEGMENT_ID = CC.SEGMENT_ID06 AND W6.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT07 W7 ON W7.SEGMENT_ID = CC.SEGMENT_ID07 AND W7.STRUCTURE_ID = CC.STRUCTURE_ID                        
                        WHERE SOM.ORDER_DATE BETWEEN '$strtdte2' AND '$enddte2'                        
                        ORDER BY CM.COMPANY_NAME, SOM.SALES_ORDER_NO, SOM.ORDER_DATE DESC";
            }
            $result11 = oci_parse($conn,$sql);
            oci_execute($result11);
            while($row = oci_fetch_array($result11,  OCI_ASSOC+OCI_RETURN_NULLS)){
                if(!empty($row["STAX_AMOUNT"])){
                    $total_amount = $row["STAX_AMOUNT"] + $row["TC_AMOUNT"];
                } 
                else{
                    $total_amount = $row["TC_AMOUNT"];
                }
                $sum_qty = $sum_qty + $row["PRIMARY_QTY"];
                $sum_amount = $sum_amount + $row["TC_AMOUNT"];
                $sum_t_amount = $sum_t_amount + $total_amount;
                if($row["PRIMARY_QTY"] != 0){
                    $rate = $total_amount / $row["PRIMARY_QTY"];
                } 
                else{
                    $rate = 0;
                }
                $data[] = array(
                    'data' => $row,
                    'total_amount' => $total_amount,
                    'sum_qty' => $sum_qty,
                    'sum_amount' => $sum_amount,
                    'sum_t_amount' => $sum_t_amount,
                    'rate' => $rate,
                );
            }

            $strtdte2a = date("m/d/Y", strtotime(substr($daterange, 0,10)));
            $strtdte3a = date("m/d/Y", strtotime(substr($daterange, 10)));

            $sessionData = [
                'book' => $request->book,
                'agent' => $request->agent,
                'season' => $request->season,
                'customer' => $request->customer,
                'subCategory' => $request->subCategory,
                'category' => $request->category,
                'sono' => $request->sono,
                'itemcode' => $rmcode,
                'articlecode' => $request->articlecode,
                'strtdte2a' => $strtdte2a,
                'strtdte3a' => $strtdte3a,
                'Storestart' => date("d/m/Y", strtotime(substr($Storedaterange, 0,10))),
                'Storeend' => date("d/m/Y", strtotime(substr($Storedaterange, -10))),
                'Storestart1' => date("d-M-Y", strtotime(substr($Storedaterange, 0,10))),
                'Storeend2' => date("d-M-Y", strtotime(substr($Storedaterange, -10))),
            ];

            return view('report.salesorder')->with([
                "data" => $data, "Permission" => 1, "sessionData" => $sessionData, "i" => 1,
                "agent" => $agentData, 
                "book" => $bookData,
                "season" => $seasonData,
                "category" => $categoryData,
                "subCategory" => $subCategoryData,
                'sum_qty' => $sum_qty,
                'sum_amount' => $sum_amount,
                'sum_t_amount' => $sum_t_amount,
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

    public function PurchaseOrder(Request $request)
    {
        try{
            $book = array(); $category = array(); $subCategory = array();
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql1 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_BOOK_DESC LIKE 'Purchase Order%'";
            $result1 = oci_parse($conn, $sql1);
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $book[] = $row1["INV_BOOK_DESC"];
            }    
            $sql4 = "SELECT W1.SEGMENT_VALUE_DESC FROM WIZ_SEGMENT01 W1";
            $result4 = oci_parse($conn, $sql4);
            oci_execute($result4);
            while($row4 =oci_fetch_array($result4,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $category[] = $row4["SEGMENT_VALUE_DESC"];
            }
            $sql5 = "SELECT W2.SEGMENT_VALUE_DESC FROM WIZ_SEGMENT02 W2";
            $result5 = oci_parse($conn, $sql5);
            oci_execute($result5);
            while($row5 =oci_fetch_array($result5,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $subCategory[] = $row5["SEGMENT_VALUE_DESC"];
            }
            return view('report.purchaseorder')->with([
                "Permission" => 0, 
                "book" => $book, 
                "category" => $category,
                "subCategory" => $subCategory,
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

    public function PurchaseOrderReportDownload(Request $request)
    {   
        try{
            date_default_timezone_set("Asia/karachi");
            $date = date("d-m-Y");
            $rate2 = 0;
            $data = array();
            $bookData = array(); $categoryData = array(); $subCategoryData = array();
            $sum_qty = $sum_amount = $sum_t_amount = $total_amount = $rate = 0;
            $book = $request->book;
            $pono = $request->pono;
            $itemcode = $request->itemcode;
            $suppplier = $request->suppplier;
            $category = $request->category;
            $subCategory = $request->subCategory;
            $Storedaterange = $request->daterange;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("d-m-Y", strtotime(substr($daterange, 0,10)));
            $enddte = date("d-m-Y", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $start = date("d-M-Y", strtotime(substr($daterange, 0,10)));
            $end = date("d-M-Y", strtotime(substr($daterange, -10)));
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);

            if(!empty($strtdte2)){
                $strtdte2 = $strtdte2;
            }else{
                $strtdte2 = "";
            }
            if(!empty($enddte2)){
                $enddte2 = $enddte2;
            }else{
                $enddte2 = "";
            }            
            if(!empty($book)){
                $book = $book;
            }
            else{
                $book = "";
            }  
            if(!empty($pono)){
                $pono = $pono;
            }
            else{
                $pono = "";
            }  
            if(!empty($itemcode)){
                $itemcode = $itemcode;
            }
            else{
                $itemcode = "";
            }    
            if(!empty($subCategory)){
                $subCategory = $subCategory;
            }
            else{
                $subCategory = "";
            }  
            if(!empty($category)){
                $category = $category;
            }
            else{
                $category = "";
            }  
            if(!empty($suppplier)){
                $suppplier = $suppplier;
            }
            else{
                $suppplier = "";
            }
            if(!empty($pono)){
                $ponoarr = explode(" || ", $request->pono);
                $pono = $ponoarr[0]; $podate = $ponoarr[1];
              }
              if(!empty($itemcode)){
                $rmcoarr = explode(" || ", $request->itemcode);
                $itemcode = $rmcoarr[0];
              }

            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql1 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_BOOK_DESC LIKE 'Purchase Order%'";
            $result1 = oci_parse($conn, $sql1);
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $bookData[] = $row1["INV_BOOK_DESC"];
            }    
            $sql4 = "SELECT W1.SEGMENT_VALUE_DESC FROM WIZ_SEGMENT01 W1";
            $result4 = oci_parse($conn, $sql4);
            oci_execute($result4);
            while($row4 =oci_fetch_array($result4,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $categoryData[] = $row4["SEGMENT_VALUE_DESC"];
            }
            $sql5 = "SELECT W2.SEGMENT_VALUE_DESC FROM WIZ_SEGMENT02 W2";
            $result5 = oci_parse($conn, $sql5);
            oci_execute($result5);
            while($row5 =oci_fetch_array($result5,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $subCategoryData[] = $row5["SEGMENT_VALUE_DESC"];
            }
            if (!empty($pono)) {
                $sql = "SELECT POM.ORDER_NO, POM.ORDER_DATE, IBM.INV_BOOK_DESC, PTM.PO_TYPE_DESC, POSM.PO_STATUS_DESC, SCM.CATEGORY_DESC AS SUPPCAT, SM.COMPANY_NAME, EM.FIRST_NAME, EM.LAST_NAME, PTM.PAYMENT_TERM_DESC, IM.ITEM_CODE, IM.ITEM_DESC, POD.PRIMARY_QTY, POD.TC_AMOUNT, SGM.STAX_GROUP_DESC, POD.STAX_TC_AMOUNT, W3.SEGMENT_VALUE_DESC AS ART_CODE,
                        (W1.SEGMENT_VALUE || '-' || W2.SEGMENT_VALUE || '-' || W3.SEGMENT_VALUE || '-' || W4.SEGMENT_VALUE || '-' || W5.SEGMENT_VALUE || '-' || W6.SEGMENT_VALUE || '-' || W7.SEGMENT_VALUE) AS CAT_CODE,
                        (W1.SEGMENT_VALUE_DESC || '-' || W2.SEGMENT_VALUE_DESC || '-' || W3.SEGMENT_VALUE_DESC || '-' || W4.SEGMENT_VALUE_DESC || '-' || W5.SEGMENT_VALUE_DESC || '-' || W6.SEGMENT_VALUE_DESC || '-' || W7.SEGMENT_VALUE_DESC) AS CAT_DESC          
                        FROM PURCHASE_ORDER_MT POM
                        JOIN PURCHASE_ORDER_DET POD ON POD.ORDER_ID = POM.ORDER_ID
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = POM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('$book','%')
                        JOIN WIZ_PO_STATUS_MT POSM ON POSM.PO_STATUS_ID = POM.PO_STATUS_ID
                        JOIN PO_TYPE_MT PTM ON PTM.PO_TYPE_ID = POM.PO_TYPE_ID
                        JOIN SUPPLIER_MT SM ON SM.SUPPLIER_ID = POM.SUPPLIER_ID
                        JOIN PURCH_OFFICERS_MT PURCH ON PURCH.EMPLOYEE_ID = POM.BUYER_ID
                        JOIN EMPLOYEE_MT EM ON EM.EMPLOYEE_ID = PURCH.EMPLOYEE_ID
                        JOIN PAYMENT_TERMS_MT PTM ON PTM.PAYMENT_TERM_ID = POM.PAYMENT_TERM_ID
                        JOIN ITEMS_MT IM ON IM.ITEM_ID = POD.ITEM_ID AND IM.ITEM_CODE LIKE NVL('$itemcode','%')
                        LEFT JOIN STAX_GROUP_MT SGM ON SGM.STAX_GROUP_ID = POD.STAX_GROUP_ID
                        JOIN SUPP_CATAGORY_MT SCM ON SCM.SUPP_CATAG_ID = SM.SUPP_CATAG_ID
                        JOIN ITEMS_CATEGORY IC ON IC.ITEM_ID = IM.ITEM_ID
                        JOIN CODE_COMBINATIONS CC ON CC.CODE_COMBINATION_ID = IC.CODE_COMBINATION_ID
                        JOIN WIZ_SEGMENT01 W1 ON W1.SEGMENT_ID = CC.SEGMENT_ID01 AND W1.STRUCTURE_ID = CC.STRUCTURE_ID AND W1.SEGMENT_VALUE_DESC LIKE NVL('$category','%')
                        JOIN WIZ_SEGMENT02 W2 ON W2.SEGMENT_ID = CC.SEGMENT_ID02 AND W2.STRUCTURE_ID = CC.STRUCTURE_ID AND W2.SEGMENT_VALUE_DESC LIKE NVL('$subCategory','%')
                        JOIN WIZ_SEGMENT03 W3 ON W3.SEGMENT_ID = CC.SEGMENT_ID03 AND W3.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT04 W4 ON W4.SEGMENT_ID = CC.SEGMENT_ID04 AND W4.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT05 W5 ON W5.SEGMENT_ID = CC.SEGMENT_ID05 AND W5.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT06 W6 ON W6.SEGMENT_ID = CC.SEGMENT_ID06 AND W6.STRUCTURE_ID = CC.STRUCTURE_ID
                        LEFT JOIN WIZ_SEGMENT07 W7 ON W7.SEGMENT_ID = CC.SEGMENT_ID07 AND W7.STRUCTURE_ID = CC.STRUCTURE_ID
                        WHERE POM.ORDER_NO = '$pono' AND TO_CHAR(POM.ORDER_DATE, 'dd-MON-yy') = '$podate'
                        ORDER BY SM.COMPANY_NAME, POM.ORDER_NO, POM.ORDER_DATE DESC";
            } 
            else{
                $sql = "SELECT POM.ORDER_NO, POM.ORDER_DATE, IBM.INV_BOOK_DESC, PTM.PO_TYPE_DESC, POSM.PO_STATUS_DESC, SCM.CATEGORY_DESC AS SUPPCAT, SM.COMPANY_NAME, EM.FIRST_NAME, EM.LAST_NAME, PTM.PAYMENT_TERM_DESC,IM.ITEM_CODE, IM.ITEM_DESC, POD.PRIMARY_QTY, POD.TC_AMOUNT, SGM.STAX_GROUP_DESC, POD.STAX_TC_AMOUNT, W3.SEGMENT_VALUE_DESC AS ART_CODE,
                        (W1.SEGMENT_VALUE || '-' || W2.SEGMENT_VALUE || '-' || W3.SEGMENT_VALUE || '-' || W4.SEGMENT_VALUE || '-' || W5.SEGMENT_VALUE || '-' || W6.SEGMENT_VALUE || '-' || W7.SEGMENT_VALUE) AS CAT_CODE,
                        (W1.SEGMENT_VALUE_DESC || '-' || W2.SEGMENT_VALUE_DESC || '-' || W3.SEGMENT_VALUE_DESC || '-' || W4.SEGMENT_VALUE_DESC || '-' || W5.SEGMENT_VALUE_DESC || '-' || W6.SEGMENT_VALUE_DESC || '-' || W7.SEGMENT_VALUE_DESC) AS CAT_DESC                            
                        FROM PURCHASE_ORDER_MT POM                        
                        JOIN PURCHASE_ORDER_DET POD ON POD.ORDER_ID = POM.ORDER_ID
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = POM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('$book','%')
                        JOIN WIZ_PO_STATUS_MT POSM ON POSM.PO_STATUS_ID = POM.PO_STATUS_ID
                        JOIN PO_TYPE_MT PTM ON PTM.PO_TYPE_ID = POM.PO_TYPE_ID
                        JOIN SUPPLIER_MT SM ON SM.SUPPLIER_ID = POM.SUPPLIER_ID
                        JOIN PURCH_OFFICERS_MT PURCH ON PURCH.EMPLOYEE_ID = POM.BUYER_ID
                        JOIN EMPLOYEE_MT EM ON EM.EMPLOYEE_ID = PURCH.EMPLOYEE_ID
                        JOIN PAYMENT_TERMS_MT PTM ON PTM.PAYMENT_TERM_ID = POM.PAYMENT_TERM_ID
                        JOIN ITEMS_MT IM ON IM.ITEM_ID = POD.ITEM_ID AND IM.ITEM_CODE LIKE NVL('$itemcode','%')
                        LEFT JOIN STAX_GROUP_MT SGM ON SGM.STAX_GROUP_ID = POD.STAX_GROUP_ID
                        JOIN SUPP_CATAGORY_MT SCM ON SCM.SUPP_CATAG_ID = SM.SUPP_CATAG_ID
                        JOIN ITEMS_CATEGORY IC ON IC.ITEM_ID = IM.ITEM_ID
                        JOIN CODE_COMBINATIONS CC ON CC.CODE_COMBINATION_ID = IC.CODE_COMBINATION_ID
                        JOIN WIZ_SEGMENT01 W1 ON W1.SEGMENT_ID = CC.SEGMENT_ID01 AND W1.STRUCTURE_ID = CC.STRUCTURE_ID AND W1.SEGMENT_VALUE_DESC LIKE NVL('$category','%')
                        JOIN WIZ_SEGMENT02 W2 ON W2.SEGMENT_ID = CC.SEGMENT_ID02 AND W2.STRUCTURE_ID = CC.STRUCTURE_ID AND W2.SEGMENT_VALUE_DESC LIKE NVL('$subCategory','%')
                        JOIN WIZ_SEGMENT03 W3 ON W3.SEGMENT_ID = CC.SEGMENT_ID03 AND W3.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT04 W4 ON W4.SEGMENT_ID = CC.SEGMENT_ID04 AND W4.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT05 W5 ON W5.SEGMENT_ID = CC.SEGMENT_ID05 AND W5.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT06 W6 ON W6.SEGMENT_ID = CC.SEGMENT_ID06 AND W6.STRUCTURE_ID = CC.STRUCTURE_ID
                        LEFT JOIN WIZ_SEGMENT07 W7 ON W7.SEGMENT_ID = CC.SEGMENT_ID07 AND W7.STRUCTURE_ID = CC.STRUCTURE_ID                        
                        WHERE POM.ORDER_DATE BETWEEN '$strtdte2' AND '$enddte2'                        
                        ORDER BY SM.COMPANY_NAME, POM.ORDER_NO, POM.ORDER_DATE DESC";
            }
            $result11 = oci_parse($conn,$sql);
            oci_execute($result11);
            while($row = oci_fetch_array($result11,  OCI_ASSOC+OCI_RETURN_NULLS)){
                if(!empty($row["STAX_TC_AMOUNT"])){
                    $total_amount = $row["STAX_TC_AMOUNT"] + $row["TC_AMOUNT"];
                } 
                else{
                    $total_amount = $row["TC_AMOUNT"];
                }
                $sum_qty = $sum_qty + $row["PRIMARY_QTY"];
                $sum_amount = $sum_amount + $row["TC_AMOUNT"];
                $sum_t_amount = $sum_t_amount + $total_amount;
                if($row["PRIMARY_QTY"] != 0){
                    $rate = $total_amount / $row["PRIMARY_QTY"];
                } 
                else{
                    $rate = 0;
                }
                $lineData[] = array(
                    'Po. No' => $row["ORDER_NO"],
                    'Po Date' => $row["ORDER_DATE"],
                    'Supplier Category' => $row["SUPPCAT"],
                    'Supplier' => $row["COMPANY_NAME"],
                    'Purchaser' => $row["FIRST_NAME"]." ".$row["LAST_NAME"],
                    'Payment Term' => $row["PAYMENT_TERM_DESC"],
                    'Po Status' => $row["PO_STATUS_DESC"],
                    'Po Type' => $row["PO_TYPE_DESC"],
                    'Item Code' => $row["ITEM_CODE"],
                    'Item Desc' => $row["ITEM_DESC"],
                    'Qty' => number_format($row["PRIMARY_QTY"],2),
                    'Rate' => number_format($rate,2),
                    'Amount' => number_format($row["TC_AMOUNT"],2),
                    'Sales Tax %' => $row["STAX_GROUP_DESC"],
                    'Sales Tax Amount' =>  number_format($row["STAX_TC_AMOUNT"],2),
                    'Total Amount' => number_format($total_amount,2),
                    'Category Code' => $row["CAT_CODE"],
                    'Category Description' => $row["CAT_DESC"],
                );
            }
            return Excel::download(new PurchaseOrder($lineData), 'Purchase Order Report '.$date.'.xlsx');
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function PurchaseOrderReportDisplay(Request $request)
    {        
        try{
            $rate2 = 0;
            $data = array();
            $bookData = array(); $categoryData = array(); $subCategoryData = array();
            $sum_qty = $sum_amount = $sum_t_amount = $total_amount = $rate = 0;
            $book = $request->book;
            $pono = $request->pono;
            $itemcode = $request->itemcode;
            $suppplier = $request->suppplier;
            $category = $request->category;
            $subCategory = $request->subCategory;
            $Storedaterange = $request->daterange;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("d-m-Y", strtotime(substr($daterange, 0,10)));
            $enddte = date("d-m-Y", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $start = date("d-M-Y", strtotime(substr($daterange, 0,10)));
            $end = date("d-M-Y", strtotime(substr($daterange, -10)));
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);

            if(!empty($strtdte2)){
                $strtdte2 = $strtdte2;
            }else{
                $strtdte2 = "";
            }
            if(!empty($enddte2)){
                $enddte2 = $enddte2;
            }else{
                $enddte2 = "";
            }            
            if(!empty($book)){
                $book = $book;
            }
            else{
                $book = "";
            }  
            if(!empty($pono)){
                $pono = $pono;
            }
            else{
                $pono = "";
            }  
            if(!empty($itemcode)){
                $itemcode = $itemcode;
            }
            else{
                $itemcode = "";
            }    
            if(!empty($subCategory)){
                $subCategory = $subCategory;
            }
            else{
                $subCategory = "";
            }  
            if(!empty($category)){
                $category = $category;
            }
            else{
                $category = "";
            }  
            if(!empty($suppplier)){
                $suppplier = $suppplier;
            }
            else{
                $suppplier = "";
            }
            if(!empty($pono)){
                $ponoarr = explode(" || ", $request->pono);
                $pono = $ponoarr[0]; $podate = $ponoarr[1];
            }
            if(!empty($itemcode)){
                $rmcoarr = explode(" || ", $request->itemcode);
                $itemcode = $rmcoarr[0];
            }

            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql1 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_BOOK_DESC LIKE 'Purchase Order%'";
            $result1 = oci_parse($conn, $sql1);
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $bookData[] = $row1["INV_BOOK_DESC"];
            }    
            $sql4 = "SELECT W1.SEGMENT_VALUE_DESC FROM WIZ_SEGMENT01 W1";
            $result4 = oci_parse($conn, $sql4);
            oci_execute($result4);
            while($row4 =oci_fetch_array($result4,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $categoryData[] = $row4["SEGMENT_VALUE_DESC"];
            }
            $sql5 = "SELECT W2.SEGMENT_VALUE_DESC FROM WIZ_SEGMENT02 W2";
            $result5 = oci_parse($conn, $sql5);
            oci_execute($result5);
            while($row5 =oci_fetch_array($result5,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $subCategoryData[] = $row5["SEGMENT_VALUE_DESC"];
            }
            if (!empty($pono)) {
                $sql = "SELECT POM.ORDER_NO, POM.ORDER_DATE, IBM.INV_BOOK_DESC, PTM.PO_TYPE_DESC, POSM.PO_STATUS_DESC, SCM.CATEGORY_DESC AS SUPPCAT, SM.COMPANY_NAME, EM.FIRST_NAME, EM.LAST_NAME, PTM.PAYMENT_TERM_DESC, IM.ITEM_CODE, IM.ITEM_DESC, POD.PRIMARY_QTY, POD.TC_AMOUNT, SGM.STAX_GROUP_DESC, POD.STAX_TC_AMOUNT, W3.SEGMENT_VALUE_DESC AS ART_CODE,
                        (W1.SEGMENT_VALUE || '-' || W2.SEGMENT_VALUE || '-' || W3.SEGMENT_VALUE || '-' || W4.SEGMENT_VALUE || '-' || W5.SEGMENT_VALUE || '-' || W6.SEGMENT_VALUE || '-' || W7.SEGMENT_VALUE) AS CAT_CODE,
                        (W1.SEGMENT_VALUE_DESC || '-' || W2.SEGMENT_VALUE_DESC || '-' || W3.SEGMENT_VALUE_DESC || '-' || W4.SEGMENT_VALUE_DESC || '-' || W5.SEGMENT_VALUE_DESC || '-' || W6.SEGMENT_VALUE_DESC || '-' || W7.SEGMENT_VALUE_DESC) AS CAT_DESC          
                        FROM PURCHASE_ORDER_MT POM
                        JOIN PURCHASE_ORDER_DET POD ON POD.ORDER_ID = POM.ORDER_ID
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = POM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('$book','%')
                        JOIN WIZ_PO_STATUS_MT POSM ON POSM.PO_STATUS_ID = POM.PO_STATUS_ID
                        JOIN PO_TYPE_MT PTM ON PTM.PO_TYPE_ID = POM.PO_TYPE_ID
                        JOIN SUPPLIER_MT SM ON SM.SUPPLIER_ID = POM.SUPPLIER_ID
                        JOIN PURCH_OFFICERS_MT PURCH ON PURCH.EMPLOYEE_ID = POM.BUYER_ID
                        JOIN EMPLOYEE_MT EM ON EM.EMPLOYEE_ID = PURCH.EMPLOYEE_ID
                        JOIN PAYMENT_TERMS_MT PTM ON PTM.PAYMENT_TERM_ID = POM.PAYMENT_TERM_ID
                        JOIN ITEMS_MT IM ON IM.ITEM_ID = POD.ITEM_ID AND IM.ITEM_CODE LIKE NVL('$itemcode','%')
                        LEFT JOIN STAX_GROUP_MT SGM ON SGM.STAX_GROUP_ID = POD.STAX_GROUP_ID
                        JOIN SUPP_CATAGORY_MT SCM ON SCM.SUPP_CATAG_ID = SM.SUPP_CATAG_ID
                        JOIN ITEMS_CATEGORY IC ON IC.ITEM_ID = IM.ITEM_ID
                        JOIN CODE_COMBINATIONS CC ON CC.CODE_COMBINATION_ID = IC.CODE_COMBINATION_ID
                        JOIN WIZ_SEGMENT01 W1 ON W1.SEGMENT_ID = CC.SEGMENT_ID01 AND W1.STRUCTURE_ID = CC.STRUCTURE_ID AND W1.SEGMENT_VALUE_DESC LIKE NVL('$category','%')
                        JOIN WIZ_SEGMENT02 W2 ON W2.SEGMENT_ID = CC.SEGMENT_ID02 AND W2.STRUCTURE_ID = CC.STRUCTURE_ID AND W2.SEGMENT_VALUE_DESC LIKE NVL('$subCategory','%')
                        JOIN WIZ_SEGMENT03 W3 ON W3.SEGMENT_ID = CC.SEGMENT_ID03 AND W3.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT04 W4 ON W4.SEGMENT_ID = CC.SEGMENT_ID04 AND W4.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT05 W5 ON W5.SEGMENT_ID = CC.SEGMENT_ID05 AND W5.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT06 W6 ON W6.SEGMENT_ID = CC.SEGMENT_ID06 AND W6.STRUCTURE_ID = CC.STRUCTURE_ID
                        LEFT JOIN WIZ_SEGMENT07 W7 ON W7.SEGMENT_ID = CC.SEGMENT_ID07 AND W7.STRUCTURE_ID = CC.STRUCTURE_ID
                        WHERE POM.ORDER_NO = '$pono' AND TO_CHAR(POM.ORDER_DATE, 'dd-MON-yy') = '$podate'
                        ORDER BY SM.COMPANY_NAME, POM.ORDER_NO, POM.ORDER_DATE DESC";
            } 
            else{
                $sql = "SELECT POM.ORDER_NO, POM.ORDER_DATE, IBM.INV_BOOK_DESC, PTM.PO_TYPE_DESC, POSM.PO_STATUS_DESC, SCM.CATEGORY_DESC AS SUPPCAT, SM.COMPANY_NAME, EM.FIRST_NAME, EM.LAST_NAME, PTM.PAYMENT_TERM_DESC,IM.ITEM_CODE, IM.ITEM_DESC, POD.PRIMARY_QTY, POD.TC_AMOUNT, SGM.STAX_GROUP_DESC, POD.STAX_TC_AMOUNT, W3.SEGMENT_VALUE_DESC AS ART_CODE,
                        (W1.SEGMENT_VALUE || '-' || W2.SEGMENT_VALUE || '-' || W3.SEGMENT_VALUE || '-' || W4.SEGMENT_VALUE || '-' || W5.SEGMENT_VALUE || '-' || W6.SEGMENT_VALUE || '-' || W7.SEGMENT_VALUE) AS CAT_CODE,
                        (W1.SEGMENT_VALUE_DESC || '-' || W2.SEGMENT_VALUE_DESC || '-' || W3.SEGMENT_VALUE_DESC || '-' || W4.SEGMENT_VALUE_DESC || '-' || W5.SEGMENT_VALUE_DESC || '-' || W6.SEGMENT_VALUE_DESC || '-' || W7.SEGMENT_VALUE_DESC) AS CAT_DESC                            
                        FROM PURCHASE_ORDER_MT POM                        
                        JOIN PURCHASE_ORDER_DET POD ON POD.ORDER_ID = POM.ORDER_ID
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = POM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('$book','%')
                        JOIN WIZ_PO_STATUS_MT POSM ON POSM.PO_STATUS_ID = POM.PO_STATUS_ID
                        JOIN PO_TYPE_MT PTM ON PTM.PO_TYPE_ID = POM.PO_TYPE_ID
                        JOIN SUPPLIER_MT SM ON SM.SUPPLIER_ID = POM.SUPPLIER_ID
                        JOIN PURCH_OFFICERS_MT PURCH ON PURCH.EMPLOYEE_ID = POM.BUYER_ID
                        JOIN EMPLOYEE_MT EM ON EM.EMPLOYEE_ID = PURCH.EMPLOYEE_ID
                        JOIN PAYMENT_TERMS_MT PTM ON PTM.PAYMENT_TERM_ID = POM.PAYMENT_TERM_ID
                        JOIN ITEMS_MT IM ON IM.ITEM_ID = POD.ITEM_ID AND IM.ITEM_CODE LIKE NVL('$itemcode','%')
                        LEFT JOIN STAX_GROUP_MT SGM ON SGM.STAX_GROUP_ID = POD.STAX_GROUP_ID
                        JOIN SUPP_CATAGORY_MT SCM ON SCM.SUPP_CATAG_ID = SM.SUPP_CATAG_ID
                        JOIN ITEMS_CATEGORY IC ON IC.ITEM_ID = IM.ITEM_ID
                        JOIN CODE_COMBINATIONS CC ON CC.CODE_COMBINATION_ID = IC.CODE_COMBINATION_ID
                        JOIN WIZ_SEGMENT01 W1 ON W1.SEGMENT_ID = CC.SEGMENT_ID01 AND W1.STRUCTURE_ID = CC.STRUCTURE_ID AND W1.SEGMENT_VALUE_DESC LIKE NVL('$category','%')
                        JOIN WIZ_SEGMENT02 W2 ON W2.SEGMENT_ID = CC.SEGMENT_ID02 AND W2.STRUCTURE_ID = CC.STRUCTURE_ID AND W2.SEGMENT_VALUE_DESC LIKE NVL('$subCategory','%')
                        JOIN WIZ_SEGMENT03 W3 ON W3.SEGMENT_ID = CC.SEGMENT_ID03 AND W3.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT04 W4 ON W4.SEGMENT_ID = CC.SEGMENT_ID04 AND W4.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT05 W5 ON W5.SEGMENT_ID = CC.SEGMENT_ID05 AND W5.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT06 W6 ON W6.SEGMENT_ID = CC.SEGMENT_ID06 AND W6.STRUCTURE_ID = CC.STRUCTURE_ID
                        LEFT JOIN WIZ_SEGMENT07 W7 ON W7.SEGMENT_ID = CC.SEGMENT_ID07 AND W7.STRUCTURE_ID = CC.STRUCTURE_ID                        
                        WHERE POM.ORDER_DATE BETWEEN '$strtdte2' AND '$enddte2'                        
                        ORDER BY SM.COMPANY_NAME, POM.ORDER_NO, POM.ORDER_DATE DESC";
            }
            $result11 = oci_parse($conn,$sql);
            oci_execute($result11);
            while($row = oci_fetch_array($result11,  OCI_ASSOC+OCI_RETURN_NULLS)){
                if(!empty($row["STAX_TC_AMOUNT"])){
                    $total_amount = $row["STAX_TC_AMOUNT"] + $row["TC_AMOUNT"];
                } 
                else{
                    $total_amount = $row["TC_AMOUNT"];
                }
                $sum_qty = $sum_qty + $row["PRIMARY_QTY"];
                $sum_amount = $sum_amount + $row["TC_AMOUNT"];
                $sum_t_amount = $sum_t_amount + $total_amount;
                if($row["PRIMARY_QTY"] != 0){
                    $rate = $total_amount / $row["PRIMARY_QTY"];
                } 
                else{
                    $rate = 0;
                }
                $data[] = array(
                    'data' => $row,
                    'total_amount' => $total_amount,
                    'sum_qty' => $sum_qty,
                    'sum_amount' => $sum_amount,
                    'sum_t_amount' => $sum_t_amount,
                    'rate' => $rate,
                );
            }

            $strtdte2a = date("m/d/Y", strtotime(substr($daterange, 0,10)));
            $strtdte3a = date("m/d/Y", strtotime(substr($daterange, 10)));

            $sessionData = [
                'book' => $request->book,
                'supplier' => $request->supplier,
                'subCategory' => $request->subCategory,
                'category' => $request->category,
                'pono' => $request->pono,
                'itemcode' => $request->itemcode,
                'strtdte2a' => $strtdte2a,
                'strtdte3a' => $strtdte3a,
                'Storestart' => date("d/m/Y", strtotime(substr($Storedaterange, 0,10))),
                'Storeend' => date("d/m/Y", strtotime(substr($Storedaterange, -10))),
                'Storestart1' => date("d-M-Y", strtotime(substr($Storedaterange, 0,10))),
                'Storeend2' => date("d-M-Y", strtotime(substr($Storedaterange, -10))),
            ];

            return view('report.purchaseorder')->with([
                "data" => $data, "Permission" => 1, "sessionData" => $sessionData, "i" => 1,
                "book" => $bookData,
                "category" => $categoryData,
                "subCategory" => $subCategoryData,
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

    public function JobOrder(Request $request)
    {
        try{
            $customer = array(); $status = array(); $season = array();
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $result1 = DB::table('job_sheet_order_mt')->orderBy('Cust_Name', 'asc')->get()->unique('Cust_Name');
            foreach($result1 as $data){
                $customer[] = $data->Cust_Name;
            }
            $result2 = DB::table('job_sheet_order_mt')->where('Status','!=','HIDE')->get('Status')->unique('Status');
            foreach($result2 as $data){
                $status[] = $data->Status;
            }
            $result3 = DB::table('job_sheet_order_mt')->get('Season')->unique('Season');
            foreach($result3 as $data){
                $season[] = $data->Season;
            }
            return view('report.joborder')->with([
                "Permission" => 0, 
                "customer" => $customer, 
                "status" => $status,
                "season" => $season,
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

    public function JobOrderReportDownload(Request $request)
    {   
        try{
            date_default_timezone_set("Asia/karachi");
            $date = date("d-m-Y");
            $rate2 = 0;
            $Arraydata = array();
            $bookData = array(); $categoryData = array(); $subCategoryData = array();
            $sum_qty = $sum_amount = $sum_t_amount = $total_amount = $rate = 0;
            $book = $request->book;
            $pono = $request->salesorder;
            $customer = $request->customer;
            $articleno = $request->articleno;
            $salesorder = $request->salesorder;
            $joborder = $request->joborder;
            $season = $request->season;
            $department = $request->department;
            $subCategory = $request->subCategory;
            $Storedaterange = $request->daterange;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("Y-m-d", strtotime(substr($daterange, 0,10)));
            $enddte = date("Y-m-d", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $start = date("d-M-Y", strtotime(substr($daterange, 0,10)));
            $end = date("d-M-Y", strtotime(substr($daterange, -10)));
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);

            if(!empty($strtdte2)){
                $strtdte2 = $strtdte2;
            }else{
                $strtdte2 = "";
            }
            if(!empty($enddte2)){
                $enddte2 = $enddte2;
            }else{
                $enddte2 = "";
            }            
            if(!empty($book)){
                $book = $book;
            }
            else{
                $book = "";
            } 
            if(!empty($pono)){
                $pono = $pono;
            }
            else{
                $pono = "";
            }  
            if(!empty($articleno)){
                $articleno = $articleno;
            }
            else{
                $articleno = "";
            } 
            if(!empty($salesorder)){
                $salesorder = $salesorder;
            }
            else{
                $salesorder = "";
            } 
            if(!empty($season)){
                $season = $season;
            }
            else{
                $season = "";
            } 
            if(!empty($joborder)){
                $joborder = $joborder;
            }
            else{
                $joborder = "";
            }  
            if(!empty($itemcode)){
                $itemcode = $itemcode;
            }
            else{
                $itemcode = "";
            }    
            if(!empty($subCategory)){
                $subCategory = $subCategory;
            }
            else{
                $subCategory = "";
            }   
            if(!empty($department)){
                $department = $department;
            }
            else{
                $department = "";
            }
            $statuso = "";
        
            $Arraydata = DB::table('job_sheet_order_mt')->join('job_sheet_order_sbmt', 'job_sheet_order_sbmt.Job_Id', '=', 'job_sheet_order_mt.Job_Id')
                                                            ->where('job_sheet_order_mt.Cust_Name', 'like', '%'.$customer.'%')
                                                            ->where('job_sheet_order_mt.Onsole_Art_No', 'like', '%'.$articleno.'%')
                                                            ->where('job_sheet_order_mt.So_No', 'like', '%'.$salesorder.'%')
                                                            ->where('job_sheet_order_mt.Department', 'like', '%'.$department.'%')

                                                        ->join('job_sheet_order_det', 'job_sheet_order_det.Color_Id', '=', 'job_sheet_order_sbmt.Id')
                                                            ->where('job_sheet_order_mt.Po_No', 'like', '%'.$pono.'%')
                                                            ->where('job_sheet_order_mt.Season', 'like', '%'.$season.'%')
                                                            ->where('job_sheet_order_mt.Unique_Id', 'like', '%'.$joborder.'%')
                                                            ->where('job_sheet_order_mt.Status', 'like', '%'.$statuso.'%')
                                                            ->whereBetween('job_sheet_order_mt.Date_Created', [$strtdte, $enddte])

                                                        ->select('job_sheet_order_mt.cat_type','job_sheet_order_mt.Job_Id','job_sheet_order_mt.Date_Created','job_sheet_order_mt.Cust_Name',
                                                            'job_sheet_order_mt.So_No','job_sheet_order_mt.Po_No','job_sheet_order_mt.Status','job_sheet_order_mt.Department','job_sheet_order_mt.Onsole_Art_No',
                                                            'job_sheet_order_mt.Cust_Art_No','job_sheet_order_mt.Season','job_sheet_order_mt.sizerange','job_sheet_order_mt.Work_Order', 
                                                            'job_sheet_order_sbmt.Color','job_sheet_order_sbmt.Last_No','job_sheet_order_sbmt.status','job_sheet_order_sbmt.total',
                                                            'job_sheet_order_det.Rm_Code','job_sheet_order_det.Job_Desc','job_sheet_order_det.Location','job_sheet_order_det.Tool',
                                                            'job_sheet_order_det.Dye_No','job_sheet_order_det.Um','job_sheet_order_det.Qty','job_sheet_order_det.Remarks')
                                                        ->where('job_sheet_order_mt.Status','!=','HIDE')->orderBy('job_sheet_order_mt.Job_Id','DESC')->get();

            foreach($Arraydata as $row){
                $lineData[] = array(
                    'Job ID' => $row->Job_Id,
                    'Date' => $row->Date_Created,
                    'Customer' => $row->Cust_Name,
                    'Category Type' =>$row->cat_type,
                    'Work Order' => $row->Work_Order,
                    'Sale Order' => $row->So_No,
                    'Purchase Order' => $row->Po_No,
                    'Current Status' => $row->Status,
                    'Department' => $row->Department,
                    'Onsole Article' => $row->Onsole_Art_No,
                    'Cust Article' => $row->Cust_Art_No,
                    'Season' => $row->Season,
                    'Color' => $row->Color,
                    'Size' => $row->sizerange,
                    'Last No' => $row->Last_No,
                    'Status' => $row->status,
                    'Quantity' => $row->total,
                    'Item Code' => $row->Rm_Code,
                    'Item Description' => $row->Job_Desc,
                    'Location' => $row->Location, 
                    'Tool' => $row->Tool,
                    'Die No' => $row->Dye_No,
                    'Um' => $row->Um,
                    'Qty' => $row->Qty,
                );
            }
            return Excel::download(new JobOrder($lineData), 'Job Order Report '.$date.'.xlsx');
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function JobOrderReportDisplay(Request $request)
    {        
        try{
            $rate2 = 0;
            $Arraydata = array();
            $bookData = array(); $categoryData = array(); $subCategoryData = array();
            $sum_qty = $sum_amount = $sum_t_amount = $total_amount = $rate = 0;
            $book = $request->book;
            $pono = $request->purchaseorder;
            $customer = $request->customer;
            $articleno = $request->articleno;
            $salesorder = $request->salesorder;
            $joborder = $request->joborder;
            $season = $request->season;
            $status = $request->status;
            $department = $request->department;
            $subCategory = $request->subCategory;
            $Storedaterange = $request->daterange;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("Y-m-d", strtotime(substr($daterange, 0,10)));
            $enddte = date("Y-m-d", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $start = date("d-M-Y", strtotime(substr($daterange, 0,10)));
            $end = date("d-M-Y", strtotime(substr($daterange, -10)));
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);

            if(!empty($strtdte2)){
                $strtdte2 = $strtdte2;
            }else{
                $strtdte2 = "";
            }
            if(!empty($enddte2)){
                $enddte2 = $enddte2;
            }else{
                $enddte2 = "";
            }            
            if(!empty($book)){
                $book = $book;
            }
            else{
                $book = "";
            } 
            if(!empty($pono)){
                $pono = $pono;
            }
            else{
                $pono = "";
            }  
            if(!empty($articleno)){
                $articleno = $articleno;
            }
            else{
                $articleno = "";
            } 
            if(!empty($salesorder)){
                $salesorder = $salesorder;
            }
            else{
                $salesorder = "";
            } 
            if(!empty($season)){
                $season = $season;
            }
            else{
                $season = "";
            } 
            if(!empty($joborder)){
                $joborder = $joborder;
            }
            else{
                $joborder = "";
            }  
            if(!empty($itemcode)){
                $itemcode = $itemcode;
            }
            else{
                $itemcode = "";
            }    
            if(!empty($subCategory)){
                $subCategory = $subCategory;
            }
            else{
                $subCategory = "";
            }   
            if(!empty($department)){
                $department = $department;
            }
            else{
                $department = "";
            }
            if(!empty($status)){
                $statuso = $status;
            }
            else{
                $statuso = "";
            }

            // dd($customer,$articleno,$salesorder,$department,$pono,$season,$joborder,$statuso,$strtdte,$enddte);
        
            $Arraydata = DB::table('job_sheet_order_mt')->join('job_sheet_order_sbmt', 'job_sheet_order_sbmt.Job_Id', '=', 'job_sheet_order_mt.Job_Id')
                                                            ->where('job_sheet_order_mt.Cust_Name', 'like', $customer.'%')
                                                            ->where('job_sheet_order_mt.Onsole_Art_No', 'like', $articleno.'%')
                                                            ->where('job_sheet_order_mt.So_No', 'like', $salesorder.'%')
                                                            ->where('job_sheet_order_mt.Department', 'like', $department.'%')

                                                        ->join('job_sheet_order_det', 'job_sheet_order_det.Color_Id', '=', 'job_sheet_order_sbmt.Id')
                                                            ->where('job_sheet_order_mt.Po_No', 'like', $pono.'%')
                                                            ->where('job_sheet_order_mt.Season', 'like', $season.'%')
                                                            ->where('job_sheet_order_mt.Unique_Id', 'like', $joborder.'%')
                                                            ->where('job_sheet_order_mt.Status', 'like', $statuso.'%')
                                                            ->whereBetween('job_sheet_order_mt.Date_Created', [$strtdte, $enddte])
                                                            ->where('job_sheet_order_mt.Status','!=','HIDE')

                                                        ->select('job_sheet_order_mt.cat_type','job_sheet_order_mt.Job_Id','job_sheet_order_mt.Date_Created','job_sheet_order_mt.Cust_Name',
                                                            'job_sheet_order_mt.So_No','job_sheet_order_mt.Po_No','job_sheet_order_mt.Status','job_sheet_order_mt.Department','job_sheet_order_mt.Onsole_Art_No',
                                                            'job_sheet_order_mt.Cust_Art_No','job_sheet_order_mt.Season','job_sheet_order_mt.sizerange','job_sheet_order_mt.Work_Order', 
                                                            'job_sheet_order_sbmt.Color','job_sheet_order_sbmt.Last_No','job_sheet_order_sbmt.status','job_sheet_order_sbmt.total',
                                                            'job_sheet_order_det.Rm_Code','job_sheet_order_det.Job_Desc','job_sheet_order_det.Location','job_sheet_order_det.Tool',
                                                            'job_sheet_order_det.Dye_No','job_sheet_order_det.Um','job_sheet_order_det.Qty','job_sheet_order_det.Remarks')
                                                        ->orderBy('job_sheet_order_mt.Job_Id','DESC')->get();

            $customer = array(); $status = array(); $season = array();
            $result1 = DB::table('job_sheet_order_mt')->orderBy('Cust_Name', 'asc')->get()->unique('Cust_Name');
            foreach($result1 as $data){
                $customer[] = $data->Cust_Name;
            }
            $result2 = DB::table('job_sheet_order_mt')->where('Status','!=','HIDE')->get('Status')->unique('Status');
            foreach($result2 as $data){
                $status[] = $data->Status;
            }
            $result3 = DB::table('job_sheet_order_mt')->get('Season')->unique('Season');
            foreach($result3 as $data){
                $season[] = $data->Season;
            }

            $strtdte2a = date("m/d/Y", strtotime(substr($daterange, 0,10)));
            $strtdte3a = date("m/d/Y", strtotime(substr($daterange, 10)));

            $sessionData = [
                'strtdte2a' => $strtdte2a,
                'strtdte3a' => $strtdte3a,
                'department' => $request->department,
                'season' => $request->season,
                'articleno' => $request->articleno,
                'joborder' => $request->joborder,
                'purchaseorder' => $request->purchaseorder,
                'salesorder' => $request->salesorder,
                'status' => $request->status,
                'customer' => $request->customer,
                'Storestart' => date("d/m/Y", strtotime(substr($Storedaterange, 0,10))),
                'Storeend' => date("d/m/Y", strtotime(substr($Storedaterange, -10))),
                'Storestart1' => date("d-M-Y", strtotime(substr($Storedaterange, 0,10))),
                'Storeend2' => date("d-M-Y", strtotime(substr($Storedaterange, -10))),
            ];

            return view('report.joborder')->with([
                "data" => $Arraydata, "Permission" => 1, "sessionData" => $sessionData, "i" => 1,
                "customer" => $customer,
                "status" => $status,
                "season" => $season,
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

    public function RMA(Request $request)
    {
        try{
            $book = array(); $season = array(); $agent = array(); $category = array(); $subCategory = array();
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql1 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_BOOK_DESC LIKE '%RMA Inward%'";
            $result1 = oci_parse($conn, $sql1);
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $book[] = $row1["INV_BOOK_DESC"];
            }
            return view('report.rmareport')->with([
                "Permission" => 0, 
                "book" => $book, 
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

    public function RMADownload(Request $request)
    {   
        try{
            date_default_timezone_set("Asia/karachi");
            $date = date("d-m-Y");
            $data = array();
            $book = $request->book;
            $Storedaterange = $request->daterange;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("d-m-Y", strtotime(substr($daterange, 0,10)));
            $enddte = date("d-m-Y", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $start = date("d-M-Y", strtotime(substr($daterange, 0,10)));
            $end = date("d-M-Y", strtotime(substr($daterange, -10)));
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);

            if(!empty($strtdte2)){
                $strtdte2 = $strtdte2;
            }else{
                $strtdte2 = "";
            }
            if(!empty($enddte2)){
                $enddte2 = $enddte2;
            }else{
                $enddte2 = "";
            }            
            if(!empty($book)){
                $book = $book;
            }
            else{
                $book = "";
            }     

            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql = "SELECT RMAM.RMA_NO, RMAM.RMA_DATE, CM.COMPANY_NAME, ITEM.ITEM_CODE, ITEM.ITEM_DESC, IBM.INV_BOOK_DESC, RMAM.INV_BOOK_ID, IM.DOCUMENT_NO AS INVOICE_NO, IM.INVOICE_DATE, RMAD.PRI_ACCEPTED_QTY RMA_QTY, ID.PRIMARY_QTY, RMAD.SALES_RETURN_AMOUNT AS RMA_AMOUNT, ID.TC_AMOUNT AS INVOICE_AMOUNT
            FROM RMA_INWARD_MT RMAM JOIN RMA_INWARD_DET RMAD ON RMAD.RMA_INWARD_ID = RMAM.RMA_INWARD_ID LEFT JOIN INVOICE_DETAIL ID ON ID.MATCH_WITH_ID = RMAD.RMA_INWARD_DET_ID
            LEFT JOIN INVOICE_MT IM ON IM.INVOICE_ID = ID.INVOICE_ID JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = RMAM.INV_BOOK_ID AND INV_BOOK_DESC = '$book'
            JOIN ITEMS_MT ITEM ON ITEM.ITEM_ID = RMAD.ITEM_ID JOIN CUSTOMER_MT CM ON CM.CUSTOMER_ID = RMAM.CUSTOMER_ID WHERE RMAM.RMA_DATE  BETWEEN '$strtdte2' AND '$enddte2'";
            $result11 = oci_parse($conn,$sql);
            oci_execute($result11);
            while($row = oci_fetch_array($result11,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $lineData[] = array(
                    'RMA No' => $row['RMA_NO'],
                    'RMA Date' => $row['RMA_DATE'],
                    'Customer' => $row['COMPANY_NAME'],
                    'Item Code' => $row['ITEM_CODE'],
                    'Item Desc' => $row['ITEM_DESC'],
                    'Book' => $row['INV_BOOK_DESC'],
                    'Invoice' => $row['INVOICE_NO'],
                    'Date' => $row['INVOICE_DATE'],
                    'RMA Qty' => $row['RMA_QTY'],
                    'INV Qty' => $row['PRIMARY_QTY'],
                    'RMA Amount' => $row['RMA_AMOUNT'],
                    'INV Amount' => $row['INVOICE_AMOUNT'],
                );
            }

            return Excel::download(new RMA($lineData), 'RMA Report '.$date.'.xlsx');
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function RMADisplay(Request $request)
    {        
        try{
            $rate2 = 0;
            $data = array();
            $bookData = array();
            $sum_qty = $sum_amount = $sum_t_amount = $total_amount = $rate = 0;
            $book = $request->book;
            $Storedaterange = $request->daterange;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("d-m-Y", strtotime(substr($daterange, 0,10)));
            $enddte = date("d-m-Y", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $start = date("d-M-Y", strtotime(substr($daterange, 0,10)));
            $end = date("d-M-Y", strtotime(substr($daterange, -10)));
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);

            if(!empty($strtdte2)){
                $strtdte2 = $strtdte2;
            }else{
                $strtdte2 = "";
            }
            if(!empty($enddte2)){
                $enddte2 = $enddte2;
            }else{
                $enddte2 = "";
            }            
            if(!empty($book)){
                $book = $book;
            }
            else{
                $book = "";
            }     

            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql1 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_BOOK_DESC LIKE '%RMA Inward%'";
            $result1 = oci_parse($conn, $sql1);
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $bookData[] = $row1["INV_BOOK_DESC"];
            }
            $sql = "SELECT RMAM.RMA_NO, RMAM.RMA_DATE, CM.COMPANY_NAME, ITEM.ITEM_CODE, ITEM.ITEM_DESC, IBM.INV_BOOK_DESC, RMAM.INV_BOOK_ID, IM.DOCUMENT_NO AS INVOICE_NO, IM.INVOICE_DATE, RMAD.PRI_ACCEPTED_QTY RMA_QTY, ID.PRIMARY_QTY, RMAD.SALES_RETURN_AMOUNT AS RMA_AMOUNT, ID.TC_AMOUNT AS INVOICE_AMOUNT
            FROM RMA_INWARD_MT RMAM JOIN RMA_INWARD_DET RMAD ON RMAD.RMA_INWARD_ID = RMAM.RMA_INWARD_ID LEFT JOIN INVOICE_DETAIL ID ON ID.MATCH_WITH_ID = RMAD.RMA_INWARD_DET_ID
            LEFT JOIN INVOICE_MT IM ON IM.INVOICE_ID = ID.INVOICE_ID JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = RMAM.INV_BOOK_ID AND INV_BOOK_DESC = '$book'
            JOIN ITEMS_MT ITEM ON ITEM.ITEM_ID = RMAD.ITEM_ID JOIN CUSTOMER_MT CM ON CM.CUSTOMER_ID = RMAM.CUSTOMER_ID WHERE RMAM.RMA_DATE  BETWEEN '$strtdte2' AND '$enddte2'";
            $result11 = oci_parse($conn,$sql);
            oci_execute($result11);
            while($row = oci_fetch_array($result11,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $data[] = array(
                    'data' => $row,
                );
            }

            $strtdte2a = date("m/d/Y", strtotime(substr($daterange, 0,10)));
            $strtdte3a = date("m/d/Y", strtotime(substr($daterange, 10)));
            $sessionData = [
                'book' => $request->book,
                'status' => $request->status,
                'strtdte2a' => $strtdte2a,
                'strtdte3a' => $strtdte3a,
                'Storestart' => date("d/m/Y", strtotime(substr($Storedaterange, 0,10))),
                'Storeend' => date("d/m/Y", strtotime(substr($Storedaterange, -10))),
                'Storestart1' => date("d-M-Y", strtotime(substr($Storedaterange, 0,10))),
                'Storeend2' => date("d-M-Y", strtotime(substr($Storedaterange, -10))),
            ];

            return view('report.rmareport')->with([
                "data" => $data, "Permission" => 1, "sessionData" => $sessionData, "i" => 1,
                "book" => $bookData,
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

    public function consumption(Request $request)
    {
        try{
            return view('report.consumption')->with([
                "Permission" => 0, 
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

    public function consumptionDownload(Request $request)
    {   
        try{
            date_default_timezone_set("Asia/karachi");
            $date = date("d-m-Y");
            $data = array();
            $sum_qty = $sum_amount = 0;
            $Storedaterange = $request->daterange;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("d-m-Y", strtotime(substr($daterange, 0,10)));
            $enddte = date("d-m-Y", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $start = date("d-M-Y", strtotime(substr($daterange, 0,10)));
            $end = date("d-M-Y", strtotime(substr($daterange, -10)));
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);

            if(!empty($strtdte2)){
                $strtdte2 = $strtdte2;
            }else{
                $strtdte2 = "";
            }
            if(!empty($enddte2)){
                $enddte2 = $enddte2;
            }else{
                $enddte2 = "";
            }                

            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql = "SELECT BB.ISSUE_NO, BB.ISSUE_DATE, IM.ITEM_CODE, IM.ITEM_DESC, AA.PRIMARY_QTY, AA.ISSUE_AMOUNT, CCV.CODE_VALUE, CCV.CODE_DESC, IBM.INV_BOOK_DESC
            FROM ISSUE_DETAIL AA
            JOIN ISSUE_MT BB ON BB.ISSUE_ID = AA.ISSUE_ID AND BB.ISSUE_DATE BETWEEN '$strtdte2' AND '$enddte2'
            JOIN ITEMS_MT IM ON IM.ITEM_ID = AA.ITEM_ID
            JOIN CODE_COMBINATION_VALUES CCV ON CCV.CODE_COMBINATION_ID = AA.CONSUMPTION_CODE_COMB_ID
            JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = BB.INV_BOOK_ID
            WHERE AA.CONSUMPTION_CODE_COMB_ID IS NOT NULL
            ORDER BY AA.CONSUMPTION_CODE_COMB_ID";
            $result11 = oci_parse($conn,$sql);
            oci_execute($result11);
            while($row = oci_fetch_array($result11,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $lineData[] = array(
                    'Book' => $row["INV_BOOK_DESC"],
                    'Issue No' => $row["ISSUE_NO"],
                    'Issue Date' => $row["ISSUE_DATE"],
                    'Item Code' => $row["ITEM_CODE"],
                    'Item Desc' => $row["ITEM_DESC"],
                    'Qty' => $row["PRIMARY_QTY"],
                    'Amount' => $row["ISSUE_AMOUNT"],
                    'Contra A/C Code' => $row["CODE_VALUE"],
                    'Contra A/C Desc' => $row["CODE_DESC"],
                );
            }
            return Excel::download(new Consumption($lineData), 'Consumption Report '.$date.'.xlsx');
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function ConsumptionDisplay(Request $request)
    {        
        try{
            $data = array();
            $sum_qty = $sum_amount = 0;
            $Storedaterange = $request->daterange;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("d-m-Y", strtotime(substr($daterange, 0,10)));
            $enddte = date("d-m-Y", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $start = date("d-M-Y", strtotime(substr($daterange, 0,10)));
            $end = date("d-M-Y", strtotime(substr($daterange, -10)));
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);

            if(!empty($strtdte2)){
                $strtdte2 = $strtdte2;
            }else{
                $strtdte2 = "";
            }
            if(!empty($enddte2)){
                $enddte2 = $enddte2;
            }else{
                $enddte2 = "";
            }                

            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql = "SELECT BB.ISSUE_NO, BB.ISSUE_DATE, IM.ITEM_CODE, IM.ITEM_DESC, AA.PRIMARY_QTY, AA.ISSUE_AMOUNT, CCV.CODE_VALUE, CCV.CODE_DESC, IBM.INV_BOOK_DESC
            FROM ISSUE_DETAIL AA
            JOIN ISSUE_MT BB ON BB.ISSUE_ID = AA.ISSUE_ID AND BB.ISSUE_DATE BETWEEN '$strtdte2' AND '$enddte2'
            JOIN ITEMS_MT IM ON IM.ITEM_ID = AA.ITEM_ID
            JOIN CODE_COMBINATION_VALUES CCV ON CCV.CODE_COMBINATION_ID = AA.CONSUMPTION_CODE_COMB_ID
            JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = BB.INV_BOOK_ID
            WHERE AA.CONSUMPTION_CODE_COMB_ID IS NOT NULL
            ORDER BY AA.CONSUMPTION_CODE_COMB_ID";
            $result11 = oci_parse($conn,$sql);
            oci_execute($result11);
            while($row = oci_fetch_array($result11,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $sum_qty = $sum_qty + $row["PRIMARY_QTY"];
                $sum_amount = $sum_amount + $row["ISSUE_AMOUNT"];
                $data[] = array(
                    'data' => $row,
                    'sum_qty' => $sum_qty,
                    'sum_amount' => $sum_amount,
                );
            }

            $strtdte2a = date("m/d/Y", strtotime(substr($daterange, 0,10)));
            $strtdte3a = date("m/d/Y", strtotime(substr($daterange, 10)));
            $sessionData = [
                'strtdte2a' => $strtdte2a,
                'strtdte3a' => $strtdte3a,
                'Storestart' => date("d/m/Y", strtotime(substr($Storedaterange, 0,10))),
                'Storeend' => date("d/m/Y", strtotime(substr($Storedaterange, -10))),
                'Storestart1' => date("d-M-Y", strtotime(substr($Storedaterange, 0,10))),
                'Storeend2' => date("d-M-Y", strtotime(substr($Storedaterange, -10))),
            ];

            return view('report.consumption')->with([
                "data" => $data, "Permission" => 1, "sessionData" => $sessionData, "i" => 1,
                'sum_qty' => $sum_qty, 'sum_amount' => $sum_amount,
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

    public function JobOrderJourney(Request $request)
    {
        try{
            return view('report.joborderjourney')->with([
                "Permission" => 0, 
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

    public function JobOrderJourneyDownload(Request $request)
    {   
        try{
            date_default_timezone_set("Asia/karachi");
            $date = date("d-m-Y");
            $Arraydata = array();
            $statusfrom = $request->statusf;
            $statusto = $request->statust;
            $department = $request->department;
            $joborder = $request->joborder;
            $thedate = $request->thedate;
            $Storedaterange = $request->daterange;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("Y-m-d", strtotime(substr($daterange, 0,10)));
            $enddte = date("Y-m-d", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $start = date("d-M-Y", strtotime(substr($daterange, 0,10)));
            $end = date("d-M-Y", strtotime(substr($daterange, -10)));
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);

            if(!empty($strtdte2)){
                $strtdte2 = $strtdte2;
            }else{
                $strtdte2 = "";
            }
            if(!empty($enddte2)){
                $enddte2 = $enddte2;
            }else{
                $enddte2 = "";
            }            
            if(!empty($statusfrom)){
                $statusfrom = $statusfrom;
            }
            else{
                $statusfrom = "";
            } 
            if(!empty($statusto)){
                $statusto = $statusto;
            }
            else{
                $statusto = "";
            }  
            if(!empty($department)){
                $department = $department;
            }
            else{
                $department = "";
            } 
            if(!empty($thedate)){
                $thedate = $thedate;
            }
            else{
                $thedate = "";
            } 
            if(!empty($joborder)){
                $joborder = explode(' || ', $joborder);
                $joborder = $joborder[0];
            }
            else{
                $joborder = "";
            }     
            $statuso = "";
        
            if($thedate == 'jodate'){
                $Arraydata = DB::table('job_sheet_order_logs')->join('job_sheet_order_mt', 'job_sheet_order_mt.Job_Id', '=', 'job_sheet_order_logs.Job_Id')
                                                                ->where('job_sheet_order_mt.Job_Id', 'like',$joborder.'%')
                                                                ->where('job_sheet_order_mt.Department', 'like', '%'.$department.'%')
                                                                ->whereBetween('job_sheet_order_mt.date_created', [$strtdte, $enddte])

                                                                ->select('job_sheet_order_mt.Job_Id','job_sheet_order_mt.Department','job_sheet_order_mt.User_Date','job_sheet_order_logs.fromd','job_sheet_order_logs.transfer_to','job_sheet_order_logs.timed')
                                                                ->where('job_sheet_order_logs.fromd','like','%'.$statusfrom.'%')->where('job_sheet_order_logs.transfer_to','like','%'.$statusto.'%')->orderBy('job_sheet_order_logs.timed', 'asc')->get();
            }
            else{
                $Arraydata = DB::table('job_sheet_order_logs')->join('job_sheet_order_mt', 'job_sheet_order_mt.Job_Id', '=', 'job_sheet_order_logs.Job_Id')
                                                                ->where('job_sheet_order_mt.Job_Id','like',$joborder.'%')
                                                                ->where('job_sheet_order_mt.Department', 'like', $department.'%')

                                                                ->select('job_sheet_order_mt.Job_Id','job_sheet_order_mt.Department','job_sheet_order_mt.User_Date','job_sheet_order_logs.fromd','job_sheet_order_logs.transfer_to','job_sheet_order_logs.timed')
                                                                ->where('job_sheet_order_logs.fromd','like',$statusfrom.'%')->where('job_sheet_order_logs.transfer_to','like',$statusto.'%')->whereBetween('job_sheet_order_logs.timed', [$strtdte, $enddte])->orderBy('job_sheet_order_logs.timed', 'asc')->get();
            }

            foreach($Arraydata as $row){
                $lineData[] = array(
                    'Job Order' => $row->Job_Id,
                    'Department' => $row->Department,
                    'Date Created' => $row->User_Date,
                    'Transform From' =>$row->fromd,
                    'Transform To' => $row->transfer_to,
                    'Transfer Date & Tome' => $row->timed,
                );
            }
            return Excel::download(new JobOrderJourney($lineData), 'Job Order Journey Report '.$date.'.xlsx');
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function JobOrderJourneyDisplay(Request $request)
    {        
        try{
            $Arraydata = array();
            $statusfrom = $request->statusf;
            $statusto = $request->statust;
            $department = $request->department;
            $joborder = $request->joborder;
            $thedate = $request->thedate;
            $Storedaterange = $request->daterange;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("Y-m-d", strtotime(substr($daterange, 0,10)));
            $enddte = date("Y-m-d", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $start = date("d-M-Y", strtotime(substr($daterange, 0,10)));
            $end = date("d-M-Y", strtotime(substr($daterange, -10)));
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);

            if(!empty($strtdte2)){
                $strtdte2 = $strtdte2;
            }else{
                $strtdte2 = "";
            }
            if(!empty($enddte2)){
                $enddte2 = $enddte2;
            }else{
                $enddte2 = "";
            }            
            if(!empty($statusfrom)){
                $statusfrom = $statusfrom;
            }
            else{
                $statusfrom = "";
            } 
            if(!empty($statusto)){
                $statusto = $statusto;
            }
            else{
                $statusto = "";
            }  
            if(!empty($department)){
                $department = $department;
            }
            else{
                $department = "";
            } 
            if(!empty($thedate)){
                $thedate = $thedate;
            }
            else{
                $thedate = "";
            } 
            if(!empty($joborder)){
                $joborder = explode(' || ', $joborder);
                $joborder = $joborder[0];
            }
            else{
                $joborder = "";
            }     
            $statuso = "";
        
            if($thedate == 'jodate'){
                $Arraydata = DB::table('job_sheet_order_logs')->join('job_sheet_order_mt', 'job_sheet_order_mt.Job_Id', '=', 'job_sheet_order_logs.Job_Id')
                                                                ->where('job_sheet_order_mt.Job_Id', 'like',$joborder.'%')
                                                                ->where('job_sheet_order_mt.Department', 'like', '%'.$department.'%')
                                                                ->whereBetween('job_sheet_order_mt.date_created', [$strtdte, $enddte])

                                                                ->select('job_sheet_order_mt.Job_Id','job_sheet_order_mt.Department','job_sheet_order_mt.User_Date','job_sheet_order_logs.fromd','job_sheet_order_logs.transfer_to','job_sheet_order_logs.timed')
                                                                ->where('job_sheet_order_logs.fromd','like','%'.$statusfrom.'%')->where('job_sheet_order_logs.transfer_to','like','%'.$statusto.'%')->orderBy('job_sheet_order_logs.timed', 'asc')->get();
            }
            else{
                $Arraydata = DB::table('job_sheet_order_logs')->join('job_sheet_order_mt', 'job_sheet_order_mt.Job_Id', '=', 'job_sheet_order_logs.Job_Id')
                                                                ->where('job_sheet_order_mt.Job_Id','like',$joborder.'%')
                                                                ->where('job_sheet_order_mt.Department', 'like', $department.'%')

                                                                ->select('job_sheet_order_mt.Job_Id','job_sheet_order_mt.Department','job_sheet_order_mt.User_Date','job_sheet_order_logs.fromd','job_sheet_order_logs.transfer_to','job_sheet_order_logs.timed')
                                                                ->where('job_sheet_order_logs.fromd','like',$statusfrom.'%')->where('job_sheet_order_logs.transfer_to','like',$statusto.'%')->whereBetween('job_sheet_order_logs.timed', [$strtdte, $enddte])->orderBy('job_sheet_order_logs.timed', 'asc')->get();
            }

            $strtdte2a = date("m/d/Y", strtotime(substr($daterange, 0,10)));
            $strtdte3a = date("m/d/Y", strtotime(substr($daterange, 10)));

            $sessionData = [
                'strtdte2a' => $strtdte2a,
                'strtdte3a' => $strtdte3a,
                'department' => $request->department,
                'thedate' => $request->thedate,
                'joborder' => $request->joborder,
                'statusf' => $request->statusf,
                'statust' => $request->statust,
                'Storestart' => date("d/m/Y", strtotime(substr($Storedaterange, 0,10))),
                'Storeend' => date("d/m/Y", strtotime(substr($Storedaterange, -10))),
                'Storestart1' => date("d-M-Y", strtotime(substr($Storedaterange, 0,10))),
                'Storeend2' => date("d-M-Y", strtotime(substr($Storedaterange, -10))),
            ];

            return view('report.joborderjourney')->with([
                "data" => $Arraydata, "Permission" => 1, "sessionData" => $sessionData, "i" => 1,
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

    public function TransferAgainstJO(Request $request)
    {
        try{
            $customer = array(); $category = array(); $season = array();
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $result1 = DB::table('job_sheet_order_mt')->orderBy('Cust_Name', 'asc')->get()->unique('Cust_Name');
            foreach($result1 as $data){
                $customer[] = $data->Cust_Name;
            }
            $sql4 = "SELECT W1.SEGMENT_VALUE_DESC FROM WIZ_SEGMENT01 W1 ORDER BY W1.SEGMENT_VALUE_DESC";
            $result4 = oci_parse($conn, $sql4);
            oci_execute($result4);
            while($row4 = oci_fetch_array($result4,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $category[] = $row4["SEGMENT_VALUE_DESC"];
            }
            $result3 = DB::table('job_sheet_order_mt')->get('Season')->unique('Season');
            foreach($result3 as $data){
                $season[] = $data->Season;
            }
            return view('report.transferagainstjo')->with([
                "Permission" => 0, 
                "customer" => $customer, 
                "category" => $category, 
                "season" => $season, 
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

    public function TransferAgainstJODownload(Request $request)
    {   
        try{
            date_default_timezone_set("Asia/karachi");
            $date = date("d-m-Y");
            $Arraydata = array();
            $dataStore =  array();
            $articleno = $request->articleno;
            $sono = $request->salesorder;
            $daterange = $request->daterange;
            $Storedaterange = $request->daterange;
            $season = $request->season;
            $rawmaterial = $request->rawmaterial;
            $customer = $request->customer;
            $department = $request->department;
            $joborder = $request->joborder;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("d-m-Y", strtotime(substr($daterange, 0,10)));
            $enddte = date("d-m-Y", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);

            if(!empty($joborder)){
                $joborder = explode(" || ",$joborder);
                $joborder = $joborder[0];
            }else{
                $joborder = "";
            }
            if(!empty($customer)){
                $customer = $customer;
            }else{
                $customer = "";
            }
            if(!empty($department)){
                $department = $department;
            }else{
                $department = "";
            }
            if(!empty($thedate)){
                $thedate = $thedate;
            }else{
                $thedate = "";
            }
            if(!empty($rawmaterial)){
                $rmcoarrf = explode(" || ",mysqli_real_escape_string($link,$rawmaterial));
                $rmcodet = $rmcoarrf[0];
            }else{
                $rmcodet = "";
            }
            if(!empty($article)){
                $article = $article;
            }else{
                $article = "";
            }
            if(!empty($sono)){
                $sono = $sono;
            }else{
                $sono = "";
            }
            if(!empty($season)){
                $season = $season;
            }else{
                $season = "";
            }
            if(empty($customer) && empty($department) && empty($season) && empty($sono) && empty($article) && empty($rmcodet)){
                $datecheck = "2025-01-01";
            }else{
                $datecheck = "";
            }
            if(!empty($strtdte2)){
                $strtdte = $strtdte2;
                $strtdte22 = $strtdte2;
            }else{
                $strtdte22 = "";
                $strtdte = "";
            }
            if(!empty($enddte2)){
                $enddte = $enddte2;
                $enddte22 = $enddte2;
            }else{
                $enddte22 = "";
                $enddte = "";
            }

            $Arraydata = DB::select(DB::raw("SELECT jsom.Job_Id, jsom.Cust_Name, jsom.Onsole_Art_No, jsom.So_No, jsom.Season, jsom.Department, jsod.Rm_Code, jsod.Job_Desc, SUM(jsod.Qty) As Quantity, jsom.Delivery_Date, DATE_FORMAT(JSOM.Date_Created, '%d-%b-%Y') as RTTIME, JSOM.Transfer_No_Mt, JSOM.Transfer_Date_Mt, JSOM.Transfer_Id
                                                FROM job_sheet_order_mt jsom
                                                JOIN job_sheet_order_det jsod on jsod.Job_Id = jsom.Job_Id and jsom.Department != 'Insole'
                                                WHERE jsom.Unique_Id like '".$joborder."%' AND jsom.Department LIKE '".$department."%' and jsom.Cust_Name LIKE '".$customer."%' and jsom.Season LIKE '".$season."%' and jsom.So_No LIKE '".$sono."%' and jsom.Onsole_Art_No LIKE '".$article."%' and jsod.Rm_Code LIKE '".$rmcodet."%' and jsom.Date_Created like '".$datecheck."%' and jsom.Status IN ('STORE', 'FINALISED', 'COMPLETE')
                                                group by jsom.Job_Id, jsom.Cust_Name, jsom.Onsole_Art_No, jsom.So_No, jsom.Season, jsom.Department, jsod.Rm_Code, jsod.Job_Desc, JSOM.Transfer_No_Mt, JSOM.Transfer_Date_Mt, JSOM.Transfer_Id, jsom.Delivery_Date, RTTIME
                                                order by jsom.Job_Id, jsod.Rm_Code"));

            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $strtdte = $enddte = $customer = $season = $strtdte2 = $enddte2 = $sono = $rmcat = $rmcodet = $department = $month_name = $month_name2 = $article = $article0 = $department0 = $sono0 = "";
            $item_code = array();
            $actqty = $diffqty = $actrate = $diffamt = $actamt = $estamt = $rem_check = $key = $keycode = $rateof = $amounte = $tno = $tno2 = 0;
            $strtdte = $enddte = $book = $status = $strtdte2 = $enddte2 = $rate = $rate2 = $month_name = $month_name2 = $item_code_now = $tdt = $joborder = $tdt2 = $temporada = $tno_check = "";
            $strtdte3 = $enddte3 = $adjustno = $pino = $pidate = $tempcode = "";
            $sum_rate = $sum_qty = $sum_amount = $poqty = $i = $sumamount = $sumtax = $sumamtinctax = $sumpoqty = $pndgcounter = $tcheck = 0;
            $purchinv = array();
            $pidate2 = array(); $arrayhe = array(); $sumof = array(0,0,0,0,0,0,0,0,0);  $rmcoarr = array(); $tnoBreak = array(); $tnoDate = array();
            $poqtytotal = $poreceivedtotal = $porejectedtotal = $poacceptedtotal = $popendingtotal = $poamounttotal = $postaxtotal = $pototal = 0;
            $sumpoqtytotal = $sumporcvtotal = $sumporejtotal = $sumpoacctotal = $sumpopentotal = $sumpoamttotal = $sumpostaxtotal = $sumpototal = $pendingme = $quantitye = 0;
            $re_amount = 0; $re_rate = 0; $re_qty = 0;

            foreach($Arraydata as $row){
                $jobid = $row->Job_Id;  $SO_NO = $row->So_No; $article = $row->Onsole_Art_No; $tno = $row->Transfer_Id; $tdt = $row->Transfer_Date_Mt;
                if($tempcode != $row->Job_Id){
                    if($rem_check == 1){
                        $tnoBreak = explode(',', $tno2);
                         $sql5 = "SELECT IMT.ITEM_CODE, IMT.ITEM_DESC, SUM(TID.PIRMARY_QTY) AS QUANTITY, SUM(TID.AMOUNT) AS AMOUNT
                                    FROM TRANS_ISSUE_MT TIM
                                    JOIN TRANS_ISSUE_DETAIL TID ON TID.ISS_TRANS_ID = TIM.ISS_TRANS_ID
                                    JOIN ITEMS_MT IMT ON IMT.ITEM_ID = TID.ITEM_ID
                                    WHERE TIM.ISS_TRANS_ID IN ('$tno_check') AND TIM.INV_BOOK_ID = 77 AND TIM.TRANS_DATE BETWEEN '$strtdte2' AND '$enddte2'
                                    GROUP BY IMT.ITEM_CODE, IMT.ITEM_DESC";
                        $result5 = oci_parse($conn,$sql5);
                        oci_execute($result5);
                        while($row5 = oci_fetch_array($result5,  OCI_ASSOC+OCI_RETURN_NULLS)){
                            if(count($tnoBreak) == 0){
                                break;
                            }
                            if($row5["QUANTITY"] == 0){
                                $rateof = 0;
                            } 
                            else{
                                $rateof = $row5["AMOUNT"]/$row5["QUANTITY"];
                            }
                            $printok = 1;
                            for($keycode = 0; $keycode < count($item_code); $keycode++){
                                if($row5["ITEM_CODE"] == $item_code[$keycode]){ 
                                    $printok = 0; 
                                }
                            }
                            if($printok == 1){
                                $lineData[] = array(
                                    'Job Order' =>  $temporada,
                                    'Customer' => $temporada,
                                    'Sale Order' => $temporada,
                                    'Article' => $temporada,
                                    'Department' => $temporada,
                                    'Season' => $temporada,
                                    'Item Code' => $row5["ITEM_CODE"],
                                    'Item Desc' => $row5["ITEM_DESC"],
                                    'Trans Qty' => number_format($row5["QUANTITY"],2),
                                    'Trans Rate' => number_format($rateof,2),
                                    'Trans Amount' => number_format($row5["AMOUNT"],2),
                                    'JO Qty' => $temporada,
                                    'JO Rate' => $temporada,
                                    'JO Amount' => $temporada,
                                    'Diff Qty' => number_format($row5["QUANTITY"],2), 
                                    'Diff Amount' => number_format($row5["AMOUNT"],2)
                                );
                            }
                        } 
                    unset($item_code);
                    }
                    $item_code[0] = $row->Rm_Code;
                    $item_code_now = $row->Rm_Code;
                    $tnoBreak = explode(',', $tno);
                    $tno_check = implode("','", $tnoBreak);
                    $sql2 = "SELECT SUM(TID.PIRMARY_QTY) AS QUANTITY, SUM(TID.AMOUNT) AS AMOUNT
                                FROM TRANS_ISSUE_MT TIM
                                JOIN TRANS_ISSUE_DETAIL TID ON TID.ISS_TRANS_ID = TIM.ISS_TRANS_ID
                                JOIN ITEMS_MT IMT ON IMT.ITEM_ID = TID.ITEM_ID AND IMT.ITEM_CODE LIKE NVL('$item_code_now','%')
                                WHERE TIM.ISS_TRANS_ID IN ('$tno_check') AND TIM.TRANS_DATE BETWEEN '$strtdte22' AND '$enddte22'";
                    $result2 = oci_parse($conn,$sql2);
                    oci_execute($result2);
                    while($row2 = oci_fetch_array($result2,  OCI_ASSOC+OCI_RETURN_NULLS)){
                        if($row2["QUANTITY"] != 0){
                            $rate2 = $row2["AMOUNT"]/$row2["QUANTITY"];
                            $amounte = $row2["AMOUNT"];
                            $quantitye = $row2["QUANTITY"];
                        } 
                        else{
                            $rate2 = 0; $amounte = 0; $quantitye = $row2["QUANTITY"];
                        }
                        $actqty = $row2["QUANTITY"];
                        $actrate = $rate2;
                        $actamt = $row2["AMOUNT"];
                    }
                    $estamt = $actrate*$row->Quantity;
                    $diffqty = $row->Quantity-$actqty;  $diffamt = $estamt-$actamt;
                    $lineData[] = array(
                        'Job Order' =>  $row->Job_Id." || ".$row->RTTIME,
                        'Customer' => $row->Cust_Name,
                        'Sale Order' => $row->So_No,
                        'Article' => $row->Onsole_Art_No,
                        'Department' => $row->Department,
                        'Season' => $row->Season,
                        'Item Code' => $row->Rm_Code,
                        'Item Desc' => $row->Job_Desc,
                        'Trans Qty' => number_format($quantitye,2),
                        'Trans Rate' => number_format($rate2,2),
                        'Trans Amount' => number_format($amounte,2),
                        'JO Qty' => number_format($row->Quantity,2),
                        'JO Rate' =>  number_format($actrate,2),
                        'JO Amount' =>  number_format($actrate*$row->Quantity,2),
                        'Diff Qty' => number_format($diffqty,2), 
                        'Diff Amount' => number_format($diffamt,2)
                    );
                    $tempcode = $row->Job_Id; $rem_check = 1; $key = 1; 
                }
                else{  
                    $item_code[$key] = $row->Rm_Code; $key++; $item_code_now = $row->Rm_Code;
                    $tnoBreak = explode(',', $tno);
                    $tno_check = implode("','", $tnoBreak);
                    $sql3 = "SELECT SUM(TID.PIRMARY_QTY) AS QUANTITY, SUM(TID.AMOUNT) AS AMOUNT
                             FROM TRANS_ISSUE_MT TIM
                             JOIN TRANS_ISSUE_DETAIL TID ON TID.ISS_TRANS_ID = TIM.ISS_TRANS_ID
                             JOIN ITEMS_MT IMT ON IMT.ITEM_ID = TID.ITEM_ID AND IMT.ITEM_CODE LIKE NVL('$item_code_now','%')
                             WHERE TIM.ISS_TRANS_ID IN ('$tno_check') AND TIM.INV_BOOK_ID = 77 AND TIM.TRANS_DATE BETWEEN '$strtdte22' AND '$enddte22'";
                    $result3= oci_parse($conn,$sql3);
                    oci_execute($result3);
                    while($row3 = oci_fetch_array($result3,  OCI_ASSOC+OCI_RETURN_NULLS)){
                        if($tno == NULL){
                            $re_amount = 0; $re_rate = 0; $re_qty = 0;
                        } 
                        else{
                            if($row3["QUANTITY"] != 0){
                                $re_qty = $row3["QUANTITY"];
                                $re_amount = $row3["AMOUNT"];
                                $re_rate = $row3["AMOUNT"]/$row3["QUANTITY"];
                            } 
                            else{
                                $re_amount = 0; $re_rate = 0; $re_qty = 0;
                            }
                        }
                        $actqty = $row3["QUANTITY"];  $actrate = $re_rate;  $actamt = $row3["AMOUNT"];
                    }
                    $estamt = $actrate*$row->Quantity;
                    $diffqty = $row->Quantity-$actqty;  $diffamt = $estamt-$actamt;
                    $lineData[] = array(
                        'Job Order' =>  $temporada,
                        'Customer' => $temporada,
                        'Sale Order' => $temporada,
                        'Article' => $temporada,
                        'Department' => $temporada,
                        'Season' => $temporada,
                        'Item Code' => $row->Rm_Code,
                        'Item Desc' => $row->Job_Desc,
                        'Trans Qty' => number_format($re_qty,2),
                        'Trans Rate' => number_format($re_rate,2),
                        'Trans Amount' => number_format($re_amount,2),
                        'JO Qty' => number_format($row->Quantity,2),
                        'JO Rate' => number_format($actrate,2), 
                        'JO Amount' => number_format($actrate*$row->Quantity,2), 
                        'Diff Qty' => number_format($diffqty,2), 
                        'Diff Amount' => number_format($diffamt,2)
                    );         
                }
            }

            $tnoBreak = explode(',', $tno);
            $tno_check = implode("','", $tnoBreak);
            $sql5 = "SELECT IMT.ITEM_CODE, IMT.ITEM_DESC, SUM(TID.PIRMARY_QTY) AS QUANTITY, SUM(TID.AMOUNT) AS AMOUNT
                 FROM TRANS_ISSUE_MT TIM
                 JOIN TRANS_ISSUE_DETAIL TID ON TID.ISS_TRANS_ID = TIM.ISS_TRANS_ID
                 JOIN ITEMS_MT IMT ON IMT.ITEM_ID = TID.ITEM_ID
                 WHERE TIM.ISS_TRANS_ID IN ('$tno_check') AND TIM.INV_BOOK_ID = 77 AND TIM.TRANS_DATE BETWEEN '$strtdte22' AND '$enddte22'
                 GROUP BY IMT.ITEM_CODE, IMT.ITEM_DESC";
                            
            $result5 = oci_parse($conn,$sql5);
            oci_execute($result5);
            while($row5 = oci_fetch_array($result5,  OCI_ASSOC+OCI_RETURN_NULLS)){
            if(count($tnoBreak) == 0){
                break;
            }
            if($row5["QUANTITY"] == 0){
                $rateof = 0;
            } 
            else{
                $rateof = $row5["AMOUNT"]/$row5["QUANTITY"];
            }
            $printok = 1;
            for($keycode = 0; $keycode < count($item_code); $keycode++) {
                if($row5["ITEM_CODE"] == $item_code[$keycode]){ 
                    $printok = 0; 
                }
            }
            if($printok == 1){
                $lineData[] = array(
                    'Job Order' => $temporada,
                    'Customer' => $temporada,
                    'Sale Order' => $temporada,
                    'Article' => $temporada,
                    'Department' => $temporada,
                    'Season' => $temporada,
                    'Item Code' => $row5->ITEM_CODE,
                    'Item Desc' => $row5->ITEM_DESC,
                    'Trans Qty' => number_format($row5->QUANTITY,2),
                    'Trans Rate' => number_format($rateof,2),
                    'Trans Amount' => number_format($row5->AMOUNT,2),
                    'JO Qty' => $temporada,
                    'JO Rate' => $temporada,
                    'JO Amount' => $temporada,
                    'Diff Qty' => number_format($row5->QUANTITY,2), 
                    'Diff Amount' => number_format($row5->AMOUNT,2)
                );
            }
        } 
            unset($item_code);
            return Excel::download(new TransferAgainst($lineData), 'Transfer Against Job Order '.$date.'.xlsx');
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function TransferAgainstJODisplay(Request $request)
    {        
        try{
            $Arraydata = array();
            $dataStore =  array();
            $articleno = $request->articleno;
            $sono = $request->salesorder;
            $daterange = $request->daterange;
            $Storedaterange = $request->daterange;
            $season = $request->season;
            $rawmaterial = $request->rawmaterial;
            $customer = $request->customer;
            $department = $request->department;
            $joborder = $request->joborder;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("d-m-Y", strtotime(substr($daterange, 0,10)));
            $enddte = date("d-m-Y", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);

            if(!empty($joborder)){
                $joborder = explode(" || ",$joborder);
                $joborder = $joborder[0];
            }else{
                $joborder = "";
            }
            if(!empty($customer)){
                $customer = $customer;
            }else{
                $customer = "";
            }
            if(!empty($department)){
                $department = $department;
            }else{
                $department = "";
            }
            if(!empty($thedate)){
                $thedate = $thedate;
            }else{
                $thedate = "";
            }
            if(!empty($rawmaterial)){
                $rmcoarrf = explode(" || ",mysqli_real_escape_string($link,$rawmaterial));
                $rmcodet = $rmcoarrf[0];
            }else{
                $rmcodet = "";
            }
            if(!empty($article)){
                $article = $article;
            }else{
                $article = "";
            }
            if(!empty($sono)){
                $sono = $sono;
            }else{
                $sono = "";
            }
            if(!empty($season)){
                $season = $season;
            }else{
                $season = "";
            }
            if(empty($customer) && empty($department) && empty($season) && empty($sono) && empty($article) && empty($rmcodet)){
                $datecheck = "2025-01-01";
            }else{
                $datecheck = "";
            }
            if(!empty($strtdte2)){
                $strtdte = $strtdte2;
                $strtdte22 = $strtdte2;
            }else{
                $strtdte22 = "";
                $strtdte = "";
            }
            if(!empty($enddte2)){
                $enddte = $enddte2;
                $enddte22 = $enddte2;
            }else{
                $enddte22 = "";
                $enddte = "";
            }

            $Arraydata = DB::select(DB::raw("SELECT jsom.Job_Id, jsom.Cust_Name, jsom.Onsole_Art_No, jsom.So_No, jsom.Season, jsom.Department, jsod.Rm_Code, jsod.Job_Desc, SUM(jsod.Qty) As Quantity, jsom.Delivery_Date, DATE_FORMAT(JSOM.Date_Created, '%d-%b-%Y') as RTTIME, JSOM.Transfer_No_Mt, JSOM.Transfer_Date_Mt, JSOM.Transfer_Id
                                                FROM job_sheet_order_mt jsom
                                                JOIN job_sheet_order_det jsod on jsod.Job_Id = jsom.Job_Id and jsom.Department != 'Insole'
                                                WHERE jsom.Unique_Id like '".$joborder."%' AND jsom.Department LIKE '".$department."%' and jsom.Cust_Name LIKE '".$customer."%' and jsom.Season LIKE '".$season."%' and jsom.So_No LIKE '".$sono."%' and jsom.Onsole_Art_No LIKE '".$article."%' and jsod.Rm_Code LIKE '".$rmcodet."%' and jsom.Date_Created like '".$datecheck."%' and jsom.Status IN ('STORE', 'FINALISED', 'COMPLETE')
                                                group by jsom.Job_Id, jsom.Cust_Name, jsom.Onsole_Art_No, jsom.So_No, jsom.Season, jsom.Department, jsod.Rm_Code, jsod.Job_Desc, JSOM.Transfer_No_Mt, JSOM.Transfer_Date_Mt, JSOM.Transfer_Id, jsom.Delivery_Date, RTTIME
                                                order by jsom.Job_Id, jsod.Rm_Code"));

            $strtdte2 = date("m/d/Y", strtotime(substr($daterange, 0,10)));
            $strtdte3 = date("m/d/Y", strtotime(substr($daterange, 10)));
            $strtdte2a = date("m/d/Y", strtotime(substr($daterange, 0,10)));
            $strtdte3a = date("m/d/Y", strtotime(substr($daterange, 10)));

            $daterangeVal = wordwrap($daterange , 10 , ' ' , true );
            $customerData = array(); $categoryData = array(); $seasonData = array();
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $result1 = DB::table('job_sheet_order_mt')->orderBy('Cust_Name', 'asc')->get()->unique('Cust_Name');
            foreach($result1 as $data){
                $customerData[] = $data->Cust_Name;
            }
            $sql4 = "SELECT W1.SEGMENT_VALUE_DESC FROM WIZ_SEGMENT01 W1 ORDER BY W1.SEGMENT_VALUE_DESC";
            $result4 = oci_parse($conn, $sql4);
            oci_execute($result4);
            while($row4 = oci_fetch_array($result4,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $categoryData[] = $row4["SEGMENT_VALUE_DESC"];
            }
            $result3 = DB::table('job_sheet_order_mt')->get('Season')->unique('Season');
            foreach($result3 as $data){
                $seasonData[] = $data->Season;
            }

            $sessionData = [
                'articleno' => $request->articleno,
                'salesorder' => $request->salesorder,
                'season' => $request->season,
                'rawmaterial' => $request->rawmaterial,
                'customer' => $request->customer,
                'department' => $request->department,
                'joborder' => $request->joborder,
                'strtdte2a' => $strtdte2a,
                'strtdte3a' => $strtdte3a,
                'Storestart' => date("d/m/Y", strtotime(substr($Storedaterange, 0,10))),
                'Storeend' => date("d/m/Y", strtotime(substr($Storedaterange, -10))),
                'Storestart1' => date("d-M-Y", strtotime(substr($Storedaterange, 0,10))),
                'Storeend2' => date("d-M-Y", strtotime(substr($Storedaterange, -10))),
            ];

            return view('report.transferagainstjo')->with([
                "data" => $Arraydata, "Permission" => 1, "sessionData" => $sessionData, "i" => 1,
                "customer" => $customerData, "category" => $categoryData, "season" => $seasonData, 
                'articleno' => $request->articleno,
                'salesorder' => $request->salesorder,
                'rawmaterial' => $request->rawmaterial,
                'department' => $request->department,
                'strtdte2a' => $strtdte2a,
                'strtdte3a' => $strtdte3a,
                'sono' => $sono,
                'enddte' => $enddte,
                'strtdte' => $enddte,
                'strtdte22' => $strtdte22,
                'enddte22' => $enddte22
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

    public function MaterialData()
    {
        $books = array(); $locator = array();
        $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
        $conn = oci_connect("onsole","s",$wizerp);
        $sql1 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_BOOK_DESC LIKE '%Internal Transfer%' OR INV_BOOK_DESC LIKE '%Transfer Issue%'";
        $result1 = oci_parse($conn, $sql1);
        oci_execute($result1);
        while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $books[] = $row1["INV_BOOK_DESC"];
        }    
        $sql3 = "SELECT CODE_VALUE, CODE_DESC FROM CODE_COMBINATION_VALUES WHERE STRUCTURE_ID = 30";
        $result3 = oci_parse($conn, $sql3);
        oci_execute($result3);
        while($row3 =oci_fetch_array($result3,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $locator[] = $row3["CODE_VALUE"]." - ".strtolower($row3["CODE_DESC"]);
        }
        $data = array(
            "books" => $books, 
            "locator" => $locator
        );
        return response()->json($data);
    }

    public function Material(Request $request)
    {
        try{
            $books = array();
            $locator = array();
            $department = array();
            $category = array();
            $subCategory = array();
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql2 = "SELECT DISTINCT BB.DESCRIPTION FROM ISSUE_MT AA, DEPARTMENT_MT BB WHERE AA.DEPARTMENT_ID = BB.DEPARTMENT_ID ORDER BY BB.DESCRIPTION";
            $result2 = oci_parse($conn, strtoupper($sql2));
            oci_execute($result2);
            while($row2 = oci_fetch_array($result2,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $department[] = $row2["DESCRIPTION"];
            }
            $sql1 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_BOOK_DESC LIKE 'Store Issue%' OR INV_BOOK_DESC LIKE 'Store Return%'";
            $result1 = oci_parse($conn, $sql1);
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $books[] = $row1["INV_BOOK_DESC"];
            }    
            $sql3 = "SELECT CODE_VALUE, CODE_DESC FROM CODE_COMBINATION_VALUES WHERE STRUCTURE_ID = 30";
            $result3 = oci_parse($conn, $sql3);
            oci_execute($result3);
            while($row3 =oci_fetch_array($result3,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $locator[] = $row3["CODE_VALUE"]." - ".strtolower($row3["CODE_DESC"]);
            }
            $sql4 = "SELECT W1.SEGMENT_VALUE_DESC FROM WIZ_SEGMENT01 W1 ORDER BY W1.SEGMENT_VALUE_DESC";
            $result4 = oci_parse($conn, $sql4);
            oci_execute($result4);
            while($row4 =oci_fetch_array($result4,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $category[] = $row4["SEGMENT_VALUE_DESC"];
            }
            $sql5 = "SELECT W2.SEGMENT_VALUE_DESC FROM WIZ_SEGMENT02 W2 ORDER BY W2.SEGMENT_VALUE_DESC";
            $result5 = oci_parse($conn, $sql5);
            oci_execute($result5);
            while($row5 =oci_fetch_array($result5,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $subCategory[] = $row5["SEGMENT_VALUE_DESC"];
            }
            return view('report.material')->with([
                "i" => 1,
                "dep" => 0, 
                "books" => $books, 
                "Permission" => 0, 
                "locator" => $locator,
                "category" => $category,
                "department" => $department,
                "subCategory" => $subCategory,
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

    public function MaterialReportDownload(Request $request)
    {
        try{
            date_default_timezone_set("Asia/karachi");
            $date = date("d-m-Y");
            $rate2 = 0;
            $data = array();
            $bookss = array();
            $locator = array();
            $transfers = array();
            $sum_rate = $sum_qty = $sum_amount = 0;
            $books = $request->books;
            $department = $request->department;
            $daterange = $request->daterange;
            $artcode = $request->artcode;
            $sono = $request->sono;
            $sinno = $request->sinno;
            $rmcode = $request->rmcode;
            $locator = $request->locator;
            $cat = $request->cat;
            $subcat = $request->subcat;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("d-m-Y", strtotime(substr($daterange, 0,10)));
            $enddte = date("d-m-Y", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);
            if(!empty($locator)){
                $wsarr = explode("-", $locator);
                $ws1 = $wsarr[0]; $ws2 = $wsarr[1];
                $ws2 = trim($ws2," ");
            }
            else{
                $locator = "";
                $ws1 = "";
                $ws2 = "";
            }
            if(!empty($books)){
                $book = $books;
            }else{
                $book = "";
            }
            if(!empty($department)){
                $department = $department;
            }else{
                $department = "";
            }
            if(!empty($sono)){
                $sono = explode(" || ", $sono);
                $sono = $sono[0];
            }else{
                $sono = "";
            }
            if(!empty($sinno)){
                $sinnoarr = explode(" || ", $sinno);
                $sinno = $sinnoarr[0];  
                $strtdte2 = $sinnoarr[1]; 
                $enddte2 = $sinnoarr[1];
            }else{
                $sinno = "";
            }
            if(!empty($rmcode)){
                $rmcode = explode(" || ", $rmcode);
                $rmcode = $rmcode[0];
            }else{
                $rmcode = "";
            }
            if(!empty($strtdte2)){
                $strtdte = $strtdte2;
            }else{
                $strtdte = "";
            }
            if(!empty($enddte2)){
                $enddte = $enddte2;
            }else{
                $enddte = "";
            }
            if(!empty($artcode)){
                $artcode = $artcode;
            }else{
                $artcode = "";
            }
            if(!empty($subcat)){
                $subcat = $subcat;
            }else{
                $subcat = "";
            }
            if(!empty($cat)){
                $cat = $cat;
            }else{
                $cat = "";
            }
            $wizerp  = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            if($department == "NULL"){
                if($book == "Store Issue Note _ Production"){
                    if(empty($artcode)){
                    $sql1 = "SELECT IM.ISSUE_DATE,IM.INV_BOOK_ID,IBM.INV_BOOK_DESC,SOM.SALES_ORDER_NO,IM.ISSUE_NO,TRM.TRANS_REASON_DESC, IM.REMARKS,
                        DM.DESCRIPTION,ISD.PRIMARY_QTY,ISD.ISSUE_AMOUNT,UPR.UOM_SHORT_DESC , ARTCODE.SEGMENT_VALUE_DESC,
                        ITM.ITEM_CODE, ITM.ITEM_DESC , CBV.CODE_VALUE, CBV.ACCOUNTING_DESC, OSD.SEASON_DEF_DESC, IM.PRODUCTION_QTY,
                        WS1.SEGMENT_VALUE AS WS1_CODE, WS2.SEGMENT_VALUE AS WS2_CODE, WS1.SEGMENT_VALUE_DESC AS WS1_DESC, WS2.SEGMENT_VALUE_DESC AS WS2_DESC, CCV3.CODE_VALUE AS COST_CENTER,
                        (W1.SEGMENT_VALUE || '-' || W2.SEGMENT_VALUE || '-' || W3.SEGMENT_VALUE || '-' || W4.SEGMENT_VALUE || '-' || W5.SEGMENT_VALUE || '-' || W6.SEGMENT_VALUE || '-' || W7.SEGMENT_VALUE) AS CAT_CODE,
                        (W1.SEGMENT_VALUE_DESC || '-' || W2.SEGMENT_VALUE_DESC || '-' || W3.SEGMENT_VALUE_DESC || '-' || W4.SEGMENT_VALUE_DESC || '-' || W5.SEGMENT_VALUE_DESC || '-' || W6.SEGMENT_VALUE_DESC || '-' || W7.SEGMENT_VALUE_DESC) AS CAT_DESC
              
                        FROM ISSUE_MT IM
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = IM.INV_BOOK_ID AND INV_BOOK_DESC = '$book'
                        AND IM.ISSUE_DATE BETWEEN '$strtdte2' AND '$enddte2' AND IM.ISSUE_NO LIKE NVL('$sinno','%')
              
                        JOIN SALES_ORDER_MT SOM ON SOM.SALES_ORDER_ID = IM.SALES_ORDER_ID AND SOM.SALES_ORDER_NO LIKE NVL('$sono','%')
                        JOIN TRANSACTION_REASON_MT TRM ON TRM.TRANS_REASON_ID = IM.TRANS_REASON_ID
                        LEFT JOIN DEPARTMENT_MT DM ON DM.DEPARTMENT_ID = IM.DEPARTMENT_ID AND DM.DESCRIPTION LIKE NVL('','%')
                        JOIN ISSUE_DETAIL ISD ON ISD.ISSUE_ID = IM.ISSUE_ID
                        JOIN WIZ_UOM_MT UPR ON ISD.UOM_ID = UPR.UOM_ID
                        JOIN ITEMS_MT ITM ON ITM.ITEM_ID = ISD.ITEM_ID AND ITM.ITEM_CODE LIKE NVL('$rmcode','%')
                        JOIN ITEMS_CATEGORY ITC ON ITC.ITEM_ID = ISD.ITEM_ID
                        JOIN CODE_COMBINATIONS CC ON CC.CODE_COMBINATION_ID = ISD.LOC_CODE_COMB_ID
                        JOIN WIZ_SEGMENT01 WS1 ON WS1.SEGMENT_ID = CC.SEGMENT_ID01 AND WS1.STRUCTURE_ID = 30 AND WS1.SEGMENT_VALUE LIKE NVL('$ws1','%')
                        JOIN WIZ_SEGMENT02 WS2 ON WS2.SEGMENT_ID = CC.SEGMENT_ID02 AND WS2.STRUCTURE_ID = 30 AND WS2.SEGMENT_VALUE LIKE NVL('$ws2','%')
                        JOIN CODE_COMBINATION_VALUES CBV ON CBV.CODE_COMBINATION_ID = ITC.CODE_COMBINATION_ID
                        LEFT JOIN WIZ_SEGMENT03 ARTCODE ON ARTCODE.SEGMENT_ID = ISD.SEGMENT_ID AND ARTCODE.STRUCTURE_ID = ISD.STRUCTURE_ID
                        LEFT JOIN ONSOLE_SEASON_DEFINITION OSD ON OSD.SEASON_DEF_ID = SOM.SEASON_DEF_ID
                        JOIN CODE_COMBINATIONS CC2 ON CC2.CODE_COMBINATION_ID = ITC.CODE_COMBINATION_ID
                        JOIN WIZ_SEGMENT01 W1 ON W1.SEGMENT_ID = CC2.SEGMENT_ID01 AND W1.STRUCTURE_ID = CC2.STRUCTURE_ID AND W1.SEGMENT_VALUE_DESC LIKE NVL('$cat','%')
                        JOIN WIZ_SEGMENT02 W2 ON W2.SEGMENT_ID = CC2.SEGMENT_ID02 AND W2.STRUCTURE_ID = CC2.STRUCTURE_ID AND W2.SEGMENT_VALUE_DESC LIKE NVL('$subcat','%')
                        JOIN WIZ_SEGMENT03 W3 ON W3.SEGMENT_ID = CC2.SEGMENT_ID03 AND W3.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT04 W4 ON W4.SEGMENT_ID = CC2.SEGMENT_ID04 AND W4.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT05 W5 ON W5.SEGMENT_ID = CC2.SEGMENT_ID05 AND W5.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT06 W6 ON W6.SEGMENT_ID = CC2.SEGMENT_ID06 AND W6.STRUCTURE_ID = CC2.STRUCTURE_ID
                        LEFT JOIN WIZ_SEGMENT07 W7 ON W7.SEGMENT_ID = CC2.SEGMENT_ID07 AND W7.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN CODE_COMBINATION_VALUES CCV3 ON CCV3.CODE_COMBINATION_ID = ISD.CC_CODE_COMB_ID
                
                        ORDER BY IM.ISSUE_DATE";
              
                    } 
                    else{
                    $sql1 = "SELECT IM.ISSUE_DATE,IM.INV_BOOK_ID,IBM.INV_BOOK_DESC,SOM.SALES_ORDER_NO,IM.ISSUE_NO,TRM.TRANS_REASON_DESC, IM.REMARKS,
                        DM.DESCRIPTION,ISD.PRIMARY_QTY,ISD.ISSUE_AMOUNT,UPR.UOM_SHORT_DESC , ARTCODE.SEGMENT_VALUE_DESC,
                        ITM.ITEM_CODE, ITM.ITEM_DESC , CBV.CODE_VALUE, CBV.ACCOUNTING_DESC, OSD.SEASON_DEF_DESC, IM.PRODUCTION_QTY,
                        WS1.SEGMENT_VALUE AS WS1_CODE, WS2.SEGMENT_VALUE AS WS2_CODE, WS1.SEGMENT_VALUE_DESC AS WS1_DESC, WS2.SEGMENT_VALUE_DESC AS WS2_DESC, CCV3.CODE_VALUE AS COST_CENTER,
                        (W1.SEGMENT_VALUE || '-' || W2.SEGMENT_VALUE || '-' || W3.SEGMENT_VALUE || '-' || W4.SEGMENT_VALUE || '-' || W5.SEGMENT_VALUE || '-' || W6.SEGMENT_VALUE || '-' || W7.SEGMENT_VALUE) AS CAT_CODE,
                        (W1.SEGMENT_VALUE_DESC || '-' || W2.SEGMENT_VALUE_DESC || '-' || W3.SEGMENT_VALUE_DESC || '-' || W4.SEGMENT_VALUE_DESC || '-' || W5.SEGMENT_VALUE_DESC || '-' || W6.SEGMENT_VALUE_DESC || '-' || W7.SEGMENT_VALUE_DESC) AS CAT_DESC
              
                        FROM ISSUE_MT IM
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = IM.INV_BOOK_ID AND INV_BOOK_DESC = '$book'
                        AND IM.ISSUE_DATE BETWEEN '$strtdte2' AND '$enddte2' AND IM.ISSUE_NO LIKE NVL('$sinno','%')
              
                        JOIN SALES_ORDER_MT SOM ON SOM.SALES_ORDER_ID = IM.SALES_ORDER_ID AND SOM.SALES_ORDER_NO LIKE NVL('$sono','%')
                        JOIN TRANSACTION_REASON_MT TRM ON TRM.TRANS_REASON_ID = IM.TRANS_REASON_ID
                        LEFT JOIN DEPARTMENT_MT DM ON DM.DEPARTMENT_ID = IM.DEPARTMENT_ID AND DM.DESCRIPTION LIKE NVL('','%')
                        JOIN ISSUE_DETAIL ISD ON ISD.ISSUE_ID = IM.ISSUE_ID
                        JOIN WIZ_UOM_MT UPR ON ISD.UOM_ID = UPR.UOM_ID
                        JOIN ITEMS_MT ITM ON ITM.ITEM_ID = ISD.ITEM_ID AND ITM.ITEM_CODE LIKE NVL('$rmcode','%')
                        JOIN ITEMS_CATEGORY ITC ON ITC.ITEM_ID = ISD.ITEM_ID
                        JOIN CODE_COMBINATIONS CC ON CC.CODE_COMBINATION_ID = ISD.LOC_CODE_COMB_ID
                        JOIN WIZ_SEGMENT01 WS1 ON WS1.SEGMENT_ID = CC.SEGMENT_ID01 AND WS1.STRUCTURE_ID = 30 AND WS1.SEGMENT_VALUE LIKE NVL('$ws1','%')
                        JOIN WIZ_SEGMENT02 WS2 ON WS2.SEGMENT_ID = CC.SEGMENT_ID02 AND WS2.STRUCTURE_ID = 30 AND WS2.SEGMENT_VALUE LIKE NVL('$ws2','%')
                        JOIN CODE_COMBINATION_VALUES CBV ON CBV.CODE_COMBINATION_ID = ITC.CODE_COMBINATION_ID
                        JOIN WIZ_SEGMENT03 ARTCODE ON ARTCODE.SEGMENT_ID = ISD.SEGMENT_ID AND ARTCODE.STRUCTURE_ID = ISD.STRUCTURE_ID AND ARTCODE.SEGMENT_VALUE_DESC LIKE NVL('$artcode','%')
                        LEFT JOIN ONSOLE_SEASON_DEFINITION OSD ON OSD.SEASON_DEF_ID = SOM.SEASON_DEF_ID
                        JOIN CODE_COMBINATIONS CC2 ON CC2.CODE_COMBINATION_ID = ITC.CODE_COMBINATION_ID
                        JOIN WIZ_SEGMENT01 W1 ON W1.SEGMENT_ID = CC2.SEGMENT_ID01 AND W1.STRUCTURE_ID = CC2.STRUCTURE_ID AND W1.SEGMENT_VALUE_DESC LIKE NVL('$cat','%')
                        JOIN WIZ_SEGMENT02 W2 ON W2.SEGMENT_ID = CC2.SEGMENT_ID02 AND W2.STRUCTURE_ID = CC2.STRUCTURE_ID AND W2.SEGMENT_VALUE_DESC LIKE NVL('$subcat','%')
                        JOIN WIZ_SEGMENT03 W3 ON W3.SEGMENT_ID = CC2.SEGMENT_ID03 AND W3.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT04 W4 ON W4.SEGMENT_ID = CC2.SEGMENT_ID04 AND W4.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT05 W5 ON W5.SEGMENT_ID = CC2.SEGMENT_ID05 AND W5.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT06 W6 ON W6.SEGMENT_ID = CC2.SEGMENT_ID06 AND W6.STRUCTURE_ID = CC2.STRUCTURE_ID
                        LEFT JOIN WIZ_SEGMENT07 W7 ON W7.SEGMENT_ID = CC2.SEGMENT_ID07 AND W7.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN CODE_COMBINATION_VALUES CCV3 ON CCV3.CODE_COMBINATION_ID = ISD.CC_CODE_COMB_ID
                
                        ORDER BY IM.ISSUE_DATE";
                    }
                }
                else{
                    $sql1 = "SELECT IM.ISSUE_DATE,IM.INV_BOOK_ID,IBM.INV_BOOK_DESC,SOM.SALES_ORDER_NO,IM.ISSUE_NO,TRM.TRANS_REASON_DESC, IM.REMARKS,
                        DM.DESCRIPTION,ISD.PRIMARY_QTY,ISD.ISSUE_AMOUNT,UPR.UOM_SHORT_DESC , ARTCODE.SEGMENT_VALUE_DESC,
                        ITM.ITEM_CODE, ITM.ITEM_DESC , CBV.CODE_VALUE, CBV.ACCOUNTING_DESC, OSD.SEASON_DEF_DESC, IM.PRODUCTION_QTY,
                        WS1.SEGMENT_VALUE AS WS1_CODE, WS2.SEGMENT_VALUE AS WS2_CODE, WS1.SEGMENT_VALUE_DESC AS WS1_DESC, WS2.SEGMENT_VALUE_DESC AS WS2_DESC, CCV3.CODE_VALUE AS COST_CENTER,
                        (W1.SEGMENT_VALUE || '-' || W2.SEGMENT_VALUE || '-' || W3.SEGMENT_VALUE || '-' || W4.SEGMENT_VALUE || '-' || W5.SEGMENT_VALUE || '-' || W6.SEGMENT_VALUE || '-' || W7.SEGMENT_VALUE) AS CAT_CODE,
                        (W1.SEGMENT_VALUE_DESC || '-' || W2.SEGMENT_VALUE_DESC || '-' || W3.SEGMENT_VALUE_DESC || '-' || W4.SEGMENT_VALUE_DESC || '-' || W5.SEGMENT_VALUE_DESC || '-' || W6.SEGMENT_VALUE_DESC || '-' || W7.SEGMENT_VALUE_DESC) AS CAT_DESC
                      
                        FROM ISSUE_MT IM
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = IM.INV_BOOK_ID AND INV_BOOK_DESC = '$book'
                        AND IM.ISSUE_DATE BETWEEN '$strtdte2' AND '$enddte2' AND IM.ISSUE_NO LIKE NVL('$sinno','%')
                
                        LEFT JOIN SALES_ORDER_MT SOM ON SOM.SALES_ORDER_ID = IM.SALES_ORDER_ID
                        JOIN TRANSACTION_REASON_MT TRM ON TRM.TRANS_REASON_ID = IM.TRANS_REASON_ID
                        LEFT JOIN DEPARTMENT_MT DM ON DM.DEPARTMENT_ID = IM.DEPARTMENT_ID
                        JOIN ISSUE_DETAIL ISD ON ISD.ISSUE_ID = IM.ISSUE_ID
                        JOIN WIZ_UOM_MT UPR ON ISD.UOM_ID = UPR.UOM_ID
                        JOIN ITEMS_MT ITM ON ITM.ITEM_ID = ISD.ITEM_ID AND ITM.ITEM_CODE LIKE NVL('$rmcode','%')
                        JOIN ITEMS_CATEGORY ITC ON ITC.ITEM_ID = ISD.ITEM_ID
                        JOIN CODE_COMBINATIONS CC ON CC.CODE_COMBINATION_ID = ISD.LOC_CODE_COMB_ID
                        JOIN WIZ_SEGMENT01 WS1 ON WS1.SEGMENT_ID = CC.SEGMENT_ID01 AND WS1.STRUCTURE_ID = 30 AND WS1.SEGMENT_VALUE LIKE NVL('$ws1','%')
                        JOIN WIZ_SEGMENT02 WS2 ON WS2.SEGMENT_ID = CC.SEGMENT_ID02 AND WS2.STRUCTURE_ID = 30 AND WS2.SEGMENT_VALUE LIKE NVL('$ws2','%')
                        JOIN CODE_COMBINATION_VALUES CBV ON CBV.CODE_COMBINATION_ID = ITC.CODE_COMBINATION_ID
                        LEFT JOIN WIZ_SEGMENT03 ARTCODE ON ARTCODE.SEGMENT_ID = ISD.SEGMENT_ID AND ARTCODE.STRUCTURE_ID = ISD.STRUCTURE_ID
                        LEFT JOIN ONSOLE_SEASON_DEFINITION OSD ON OSD.SEASON_DEF_ID = SOM.SEASON_DEF_ID
                        JOIN CODE_COMBINATIONS CC2 ON CC2.CODE_COMBINATION_ID = ITC.CODE_COMBINATION_ID
                        JOIN WIZ_SEGMENT01 W1 ON W1.SEGMENT_ID = CC2.SEGMENT_ID01 AND W1.STRUCTURE_ID = CC2.STRUCTURE_ID AND W1.SEGMENT_VALUE_DESC LIKE NVL('$cat','%')
                        JOIN WIZ_SEGMENT02 W2 ON W2.SEGMENT_ID = CC2.SEGMENT_ID02 AND W2.STRUCTURE_ID = CC2.STRUCTURE_ID AND W2.SEGMENT_VALUE_DESC LIKE NVL('$subcat','%')
                        JOIN WIZ_SEGMENT03 W3 ON W3.SEGMENT_ID = CC2.SEGMENT_ID03 AND W3.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT04 W4 ON W4.SEGMENT_ID = CC2.SEGMENT_ID04 AND W4.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT05 W5 ON W5.SEGMENT_ID = CC2.SEGMENT_ID05 AND W5.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT06 W6 ON W6.SEGMENT_ID = CC2.SEGMENT_ID06 AND W6.STRUCTURE_ID = CC2.STRUCTURE_ID
                        LEFT JOIN WIZ_SEGMENT07 W7 ON W7.SEGMENT_ID = CC2.SEGMENT_ID07 AND W7.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN CODE_COMBINATION_VALUES CCV3 ON CCV3.CODE_COMBINATION_ID = ISD.CC_CODE_COMB_ID
                
                        ORDER BY IM.ISSUE_DATE";
                } 
            } 
            else{
                if($book == "Store Issue Note _ Production"){
                    if(empty($artcode)){
                    $sql1 = "SELECT IM.ISSUE_DATE,IM.INV_BOOK_ID,IBM.INV_BOOK_DESC,SOM.SALES_ORDER_NO,IM.ISSUE_NO,TRM.TRANS_REASON_DESC, IM.REMARKS,
                        DM.DESCRIPTION,ISD.PRIMARY_QTY,ISD.ISSUE_AMOUNT,UPR.UOM_SHORT_DESC , ARTCODE.SEGMENT_VALUE_DESC,
                        ITM.ITEM_CODE, ITM.ITEM_DESC , CBV.CODE_VALUE, CBV.ACCOUNTING_DESC, OSD.SEASON_DEF_DESC, IM.PRODUCTION_QTY,
                        WS1.SEGMENT_VALUE AS WS1_CODE, WS2.SEGMENT_VALUE AS WS2_CODE, WS1.SEGMENT_VALUE_DESC AS WS1_DESC, WS2.SEGMENT_VALUE_DESC AS WS2_DESC, CCV3.CODE_VALUE AS COST_CENTER,
                        (W1.SEGMENT_VALUE || '-' || W2.SEGMENT_VALUE || '-' || W3.SEGMENT_VALUE || '-' || W4.SEGMENT_VALUE || '-' || W5.SEGMENT_VALUE || '-' || W6.SEGMENT_VALUE || '-' || W7.SEGMENT_VALUE) AS CAT_CODE,
                        (W1.SEGMENT_VALUE_DESC || '-' || W2.SEGMENT_VALUE_DESC || '-' || W3.SEGMENT_VALUE_DESC || '-' || W4.SEGMENT_VALUE_DESC || '-' || W5.SEGMENT_VALUE_DESC || '-' || W6.SEGMENT_VALUE_DESC || '-' || W7.SEGMENT_VALUE_DESC) AS CAT_DESC
                      
                        FROM ISSUE_MT IM
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = IM.INV_BOOK_ID AND INV_BOOK_DESC = '$book'
                        AND IM.ISSUE_DATE BETWEEN '$strtdte2' AND '$enddte2' AND IM.ISSUE_NO LIKE NVL('$sinno','%')
                
                        JOIN SALES_ORDER_MT SOM ON SOM.SALES_ORDER_ID = IM.SALES_ORDER_ID AND SOM.SALES_ORDER_NO LIKE NVL('$sono','%')
                        JOIN TRANSACTION_REASON_MT TRM ON TRM.TRANS_REASON_ID = IM.TRANS_REASON_ID
                        JOIN DEPARTMENT_MT DM ON DM.DEPARTMENT_ID = IM.DEPARTMENT_ID AND DM.DESCRIPTION LIKE NVL('$department','%')
                        JOIN ISSUE_DETAIL ISD ON ISD.ISSUE_ID = IM.ISSUE_ID
                        JOIN WIZ_UOM_MT UPR ON ISD.UOM_ID = UPR.UOM_ID
                        JOIN ITEMS_MT ITM ON ITM.ITEM_ID = ISD.ITEM_ID AND ITM.ITEM_CODE LIKE NVL('$rmcode','%')
                        JOIN ITEMS_CATEGORY ITC ON ITC.ITEM_ID = ISD.ITEM_ID
                        JOIN CODE_COMBINATIONS CC ON CC.CODE_COMBINATION_ID = ISD.LOC_CODE_COMB_ID
                        JOIN WIZ_SEGMENT01 WS1 ON WS1.SEGMENT_ID = CC.SEGMENT_ID01 AND WS1.STRUCTURE_ID = 30 AND WS1.SEGMENT_VALUE LIKE NVL('$ws1','%')
                        JOIN WIZ_SEGMENT02 WS2 ON WS2.SEGMENT_ID = CC.SEGMENT_ID02 AND WS2.STRUCTURE_ID = 30 AND WS2.SEGMENT_VALUE LIKE NVL('$ws2','%')
                        JOIN CODE_COMBINATION_VALUES CBV ON CBV.CODE_COMBINATION_ID = ITC.CODE_COMBINATION_ID
                        LEFT JOIN WIZ_SEGMENT03 ARTCODE ON ARTCODE.SEGMENT_ID = ISD.SEGMENT_ID AND ARTCODE.STRUCTURE_ID = ISD.STRUCTURE_ID
                        LEFT JOIN ONSOLE_SEASON_DEFINITION OSD ON OSD.SEASON_DEF_ID = SOM.SEASON_DEF_ID
                        JOIN CODE_COMBINATIONS CC2 ON CC2.CODE_COMBINATION_ID = ITC.CODE_COMBINATION_ID
                        JOIN WIZ_SEGMENT01 W1 ON W1.SEGMENT_ID = CC2.SEGMENT_ID01 AND W1.STRUCTURE_ID = CC2.STRUCTURE_ID AND W1.SEGMENT_VALUE_DESC LIKE NVL('$cat','%')
                        JOIN WIZ_SEGMENT02 W2 ON W2.SEGMENT_ID = CC2.SEGMENT_ID02 AND W2.STRUCTURE_ID = CC2.STRUCTURE_ID AND W2.SEGMENT_VALUE_DESC LIKE NVL('$subcat','%')
                        JOIN WIZ_SEGMENT03 W3 ON W3.SEGMENT_ID = CC2.SEGMENT_ID03 AND W3.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT04 W4 ON W4.SEGMENT_ID = CC2.SEGMENT_ID04 AND W4.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT05 W5 ON W5.SEGMENT_ID = CC2.SEGMENT_ID05 AND W5.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT06 W6 ON W6.SEGMENT_ID = CC2.SEGMENT_ID06 AND W6.STRUCTURE_ID = CC2.STRUCTURE_ID
                        LEFT JOIN WIZ_SEGMENT07 W7 ON W7.SEGMENT_ID = CC2.SEGMENT_ID07 AND W7.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN CODE_COMBINATION_VALUES CCV3 ON CCV3.CODE_COMBINATION_ID = ISD.CC_CODE_COMB_ID
                
                        ORDER BY IM.ISSUE_DATE";              
                    } 
                    else{
                        // dd("5");
                        $sql1 = "SELECT IM.ISSUE_DATE,IM.INV_BOOK_ID,IBM.INV_BOOK_DESC,SOM.SALES_ORDER_NO,IM.ISSUE_NO,TRM.TRANS_REASON_DESC, IM.REMARKS,
                            DM.DESCRIPTION,ISD.PRIMARY_QTY,ISD.ISSUE_AMOUNT,UPR.UOM_SHORT_DESC , ARTCODE.SEGMENT_VALUE_DESC,
                            ITM.ITEM_CODE, ITM.ITEM_DESC , CBV.CODE_VALUE, CBV.ACCOUNTING_DESC, OSD.SEASON_DEF_DESC, IM.PRODUCTION_QTY,
                            WS1.SEGMENT_VALUE AS WS1_CODE, WS2.SEGMENT_VALUE AS WS2_CODE, WS1.SEGMENT_VALUE_DESC AS WS1_DESC, WS2.SEGMENT_VALUE_DESC AS WS2_DESC, CCV3.CODE_VALUE AS COST_CENTER,
                            (W1.SEGMENT_VALUE || '-' || W2.SEGMENT_VALUE || '-' || W3.SEGMENT_VALUE || '-' || W4.SEGMENT_VALUE || '-' || W5.SEGMENT_VALUE || '-' || W6.SEGMENT_VALUE || '-' || W7.SEGMENT_VALUE) AS CAT_CODE,
                            (W1.SEGMENT_VALUE_DESC || '-' || W2.SEGMENT_VALUE_DESC || '-' || W3.SEGMENT_VALUE_DESC || '-' || W4.SEGMENT_VALUE_DESC || '-' || W5.SEGMENT_VALUE_DESC || '-' || W6.SEGMENT_VALUE_DESC || '-' || W7.SEGMENT_VALUE_DESC) AS CAT_DESC
                      
                            FROM ISSUE_MT IM
                            JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = IM.INV_BOOK_ID AND INV_BOOK_DESC = '$book'
                            AND IM.ISSUE_DATE BETWEEN '$strtdte2' AND '$enddte2' AND IM.ISSUE_NO LIKE NVL('$sinno','%')
                    
                            JOIN SALES_ORDER_MT SOM ON SOM.SALES_ORDER_ID = IM.SALES_ORDER_ID AND SOM.SALES_ORDER_NO LIKE NVL('$sono','%')
                            JOIN TRANSACTION_REASON_MT TRM ON TRM.TRANS_REASON_ID = IM.TRANS_REASON_ID
                            JOIN DEPARTMENT_MT DM ON DM.DEPARTMENT_ID = IM.DEPARTMENT_ID AND DM.DESCRIPTION LIKE NVL('$department','%')
                            JOIN ISSUE_DETAIL ISD ON ISD.ISSUE_ID = IM.ISSUE_ID
                            JOIN WIZ_UOM_MT UPR ON ISD.UOM_ID = UPR.UOM_ID
                            JOIN ITEMS_MT ITM ON ITM.ITEM_ID = ISD.ITEM_ID AND ITM.ITEM_CODE LIKE NVL('$rmcode','%')
                            JOIN ITEMS_CATEGORY ITC ON ITC.ITEM_ID = ISD.ITEM_ID
                            JOIN CODE_COMBINATIONS CC ON CC.CODE_COMBINATION_ID = ISD.LOC_CODE_COMB_ID
                            JOIN WIZ_SEGMENT01 WS1 ON WS1.SEGMENT_ID = CC.SEGMENT_ID01 AND WS1.STRUCTURE_ID = 30 AND WS1.SEGMENT_VALUE LIKE NVL('$ws1','%')
                            JOIN WIZ_SEGMENT02 WS2 ON WS2.SEGMENT_ID = CC.SEGMENT_ID02 AND WS2.STRUCTURE_ID = 30 AND WS2.SEGMENT_VALUE LIKE NVL('$ws2','%')
                            JOIN CODE_COMBINATION_VALUES CBV ON CBV.CODE_COMBINATION_ID = ITC.CODE_COMBINATION_ID
                            JOIN WIZ_SEGMENT03 ARTCODE ON ARTCODE.SEGMENT_ID = ISD.SEGMENT_ID AND ARTCODE.STRUCTURE_ID = ISD.STRUCTURE_ID AND ARTCODE.SEGMENT_VALUE_DESC LIKE NVL('$artcode','%')
                            LEFT JOIN ONSOLE_SEASON_DEFINITION OSD ON OSD.SEASON_DEF_ID = SOM.SEASON_DEF_ID
                            JOIN CODE_COMBINATIONS CC2 ON CC2.CODE_COMBINATION_ID = ITC.CODE_COMBINATION_ID
                            JOIN WIZ_SEGMENT01 W1 ON W1.SEGMENT_ID = CC2.SEGMENT_ID01 AND W1.STRUCTURE_ID = CC2.STRUCTURE_ID AND W1.SEGMENT_VALUE_DESC LIKE NVL('$cat','%')
                            JOIN WIZ_SEGMENT02 W2 ON W2.SEGMENT_ID = CC2.SEGMENT_ID02 AND W2.STRUCTURE_ID = CC2.STRUCTURE_ID AND W2.SEGMENT_VALUE_DESC LIKE NVL('$subcat','%')
                            JOIN WIZ_SEGMENT03 W3 ON W3.SEGMENT_ID = CC2.SEGMENT_ID03 AND W3.STRUCTURE_ID = CC2.STRUCTURE_ID
                            JOIN WIZ_SEGMENT04 W4 ON W4.SEGMENT_ID = CC2.SEGMENT_ID04 AND W4.STRUCTURE_ID = CC2.STRUCTURE_ID
                            JOIN WIZ_SEGMENT05 W5 ON W5.SEGMENT_ID = CC2.SEGMENT_ID05 AND W5.STRUCTURE_ID = CC2.STRUCTURE_ID
                            JOIN WIZ_SEGMENT06 W6 ON W6.SEGMENT_ID = CC2.SEGMENT_ID06 AND W6.STRUCTURE_ID = CC2.STRUCTURE_ID
                            LEFT JOIN WIZ_SEGMENT07 W7 ON W7.SEGMENT_ID = CC2.SEGMENT_ID07 AND W7.STRUCTURE_ID = CC2.STRUCTURE_ID
                            JOIN CODE_COMBINATION_VALUES CCV3 ON CCV3.CODE_COMBINATION_ID = ISD.CC_CODE_COMB_ID
                    
                            ORDER BY IM.ISSUE_DATE";
                    }
                } 
                else{
                    $sql1 = "SELECT IM.ISSUE_DATE,IM.INV_BOOK_ID,IBM.INV_BOOK_DESC,SOM.SALES_ORDER_NO,IM.ISSUE_NO,TRM.TRANS_REASON_DESC, IM.REMARKS,
                        DM.DESCRIPTION,ISD.PRIMARY_QTY,ISD.ISSUE_AMOUNT,UPR.UOM_SHORT_DESC , ARTCODE.SEGMENT_VALUE_DESC,
                        ITM.ITEM_CODE, ITM.ITEM_DESC , CBV.CODE_VALUE, CBV.ACCOUNTING_DESC, OSD.SEASON_DEF_DESC, IM.PRODUCTION_QTY,
                        WS1.SEGMENT_VALUE AS WS1_CODE, WS2.SEGMENT_VALUE AS WS2_CODE, WS1.SEGMENT_VALUE_DESC AS WS1_DESC, WS2.SEGMENT_VALUE_DESC AS WS2_DESC, CCV3.CODE_VALUE AS COST_CENTER,
                        (W1.SEGMENT_VALUE || '-' || W2.SEGMENT_VALUE || '-' || W3.SEGMENT_VALUE || '-' || W4.SEGMENT_VALUE || '-' || W5.SEGMENT_VALUE || '-' || W6.SEGMENT_VALUE || '-' || W7.SEGMENT_VALUE) AS CAT_CODE,
                        (W1.SEGMENT_VALUE_DESC || '-' || W2.SEGMENT_VALUE_DESC || '-' || W3.SEGMENT_VALUE_DESC || '-' || W4.SEGMENT_VALUE_DESC || '-' || W5.SEGMENT_VALUE_DESC || '-' || W6.SEGMENT_VALUE_DESC || '-' || W7.SEGMENT_VALUE_DESC) AS CAT_DESC
                      
                        FROM ISSUE_MT IM
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = IM.INV_BOOK_ID AND INV_BOOK_DESC = '$book'
                        AND IM.ISSUE_DATE BETWEEN '$strtdte2' AND '$enddte2' AND IM.ISSUE_NO LIKE NVL('$sinno','%')
                
                        LEFT JOIN SALES_ORDER_MT SOM ON SOM.SALES_ORDER_ID = IM.SALES_ORDER_ID
                        JOIN TRANSACTION_REASON_MT TRM ON TRM.TRANS_REASON_ID = IM.TRANS_REASON_ID
                        JOIN DEPARTMENT_MT DM ON DM.DEPARTMENT_ID = IM.DEPARTMENT_ID
                        JOIN ISSUE_DETAIL ISD ON ISD.ISSUE_ID = IM.ISSUE_ID
                        JOIN WIZ_UOM_MT UPR ON ISD.UOM_ID = UPR.UOM_ID
                        JOIN ITEMS_MT ITM ON ITM.ITEM_ID = ISD.ITEM_ID AND ITM.ITEM_CODE LIKE NVL('$rmcode','%')
                        JOIN ITEMS_CATEGORY ITC ON ITC.ITEM_ID = ISD.ITEM_ID
                        JOIN CODE_COMBINATIONS CC ON CC.CODE_COMBINATION_ID = ISD.LOC_CODE_COMB_ID
                        JOIN WIZ_SEGMENT01 WS1 ON WS1.SEGMENT_ID = CC.SEGMENT_ID01 AND WS1.STRUCTURE_ID = 30 AND WS1.SEGMENT_VALUE LIKE NVL('$ws1','%')
                        JOIN WIZ_SEGMENT02 WS2 ON WS2.SEGMENT_ID = CC.SEGMENT_ID02 AND WS2.STRUCTURE_ID = 30 AND WS2.SEGMENT_VALUE LIKE NVL('$ws2','%')
                        JOIN CODE_COMBINATION_VALUES CBV ON CBV.CODE_COMBINATION_ID = ITC.CODE_COMBINATION_ID
                        LEFT JOIN WIZ_SEGMENT03 ARTCODE ON ARTCODE.SEGMENT_ID = ISD.SEGMENT_ID AND ARTCODE.STRUCTURE_ID = ISD.STRUCTURE_ID
                        LEFT JOIN ONSOLE_SEASON_DEFINITION OSD ON OSD.SEASON_DEF_ID = SOM.SEASON_DEF_ID
                        JOIN CODE_COMBINATIONS CC2 ON CC2.CODE_COMBINATION_ID = ITC.CODE_COMBINATION_ID
                        JOIN WIZ_SEGMENT01 W1 ON W1.SEGMENT_ID = CC2.SEGMENT_ID01 AND W1.STRUCTURE_ID = CC2.STRUCTURE_ID AND W1.SEGMENT_VALUE_DESC LIKE NVL('$cat','%')
                        JOIN WIZ_SEGMENT02 W2 ON W2.SEGMENT_ID = CC2.SEGMENT_ID02 AND W2.STRUCTURE_ID = CC2.STRUCTURE_ID AND W2.SEGMENT_VALUE_DESC LIKE NVL('$subcat','%')
                        JOIN WIZ_SEGMENT03 W3 ON W3.SEGMENT_ID = CC2.SEGMENT_ID03 AND W3.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT04 W4 ON W4.SEGMENT_ID = CC2.SEGMENT_ID04 AND W4.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT05 W5 ON W5.SEGMENT_ID = CC2.SEGMENT_ID05 AND W5.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT06 W6 ON W6.SEGMENT_ID = CC2.SEGMENT_ID06 AND W6.STRUCTURE_ID = CC2.STRUCTURE_ID
                        LEFT JOIN WIZ_SEGMENT07 W7 ON W7.SEGMENT_ID = CC2.SEGMENT_ID07 AND W7.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN CODE_COMBINATION_VALUES CCV3 ON CCV3.CODE_COMBINATION_ID = ISD.CC_CODE_COMB_ID
                
                        ORDER BY IM.ISSUE_DATE";
                }
            }
            $result11 = oci_parse($conn,$sql1);
            oci_execute($result11);
            while($row = oci_fetch_array($result11,  OCI_ASSOC+OCI_RETURN_NULLS)){
                if($row["PRIMARY_QTY"] == 0) {
                    $sum_qty = $sum_qty + $row["PRIMARY_QTY"];
                    $sum_amount = $sum_amount + $row["ISSUE_AMOUNT"];
                } 
                else{
                    $rate = $row["ISSUE_AMOUNT"]/$row["PRIMARY_QTY"];
                    $rate2 = round($rate,2);
                    $sum_qty = $sum_qty + $row["PRIMARY_QTY"];
                    $sum_amount = $sum_amount + $row["ISSUE_AMOUNT"];
                    $sum_rate = $sum_rate + $rate;
                }
                $data[] = $row;
            }
            foreach($data as $value){
                $newcodevalue = explode("-", $value["CODE_VALUE"]);     
                $cost_center = explode("-", $value["COST_CENTER"]);
                $only = $newcodevalue[0]."-%";
                $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
                $conn = oci_connect("onsole","s",$wizerp);
                $sql1 = "SELECT DISTINCT CCV.CODE_VALUE, CCV.ACCOUNTING_DESC FROM INV_GL_CONFIG_CATEGORY IGCC
                            JOIN CODE_COMBINATION_VALUES CCV ON CCV.CODE_COMBINATION_ID = IGCC.PURCH_ACC_CODE --OR CCV.CODE_COMBINATION_ID = IGCC.COGS_ACC_CODE
                            WHERE IGCC.CAT_STRUC_ID IN (27,88,91) AND IGCC.SUB_INV_ID NOT IN (8, 10) AND IGCC.FROM_CODE LIKE NVL('$only','%')";
                $result1 = oci_parse($conn, strtoupper($sql1));
                oci_execute($result1);
                while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)) {
                    $loopData[] = $row1;                    
                }
                $loopData = $loopData[0];

                $sql2 = "SELECT * FROM INV_GL_CONFIG_CC CC WHERE CC.From_Cat_Code LIKE NVL('$only','%') AND CC.CC_STRUCTURE_ID = 29";
                $result2 = oci_parse($conn, strtoupper($sql2));
                oci_execute($result2);
                while($row2 = oci_fetch_array($result2,  OCI_ASSOC+OCI_RETURN_NULLS)) {
                    $string = strtr($row2["TO_CODE"], ['Z' => '9']);
                    $from_cc = explode("-", $row2["FROM_CODE"]);        
                    $to_cc = explode("-", $string);
                    for($j=0; $j < count($cost_center); $j++){ 
                        if($cost_center[$j] >= $from_cc[$j] && $cost_center[$j] <= $to_cc[$j]){
                            $true = 1;
                        }
                        else{
                            $true = 0;
                            break;
                        }
                    }
                    if($true == 1){
                        $final_code_comb = $row2["CONSUMPTION_ACC_CODE"];
                        $sql3 = "SELECT AA.CODE_VALUE, AA.ACCOUNTING_DESC FROM CODE_COMBINATION_VALUES AA WHERE AA.CODE_COMBINATION_ID = $final_code_comb";
                        $result3 = oci_parse($conn, strtoupper($sql3));
                        oci_execute($result3);
                        while($row3 = oci_fetch_array($result3,  OCI_ASSOC+OCI_RETURN_NULLS)){ 
                           $loopData1[] = $row3;                         
                        }
                        break; 
                    }                  
                }
                $loopData1 = $loopData1[0];

                $lineData[] = array(
                    'Issue Date' => $value['ISSUE_DATE'],
                    'So No' => $value['SALES_ORDER_NO'],
                    'Season' => $value['SEASON_DEF_DESC'],
                    'Issue No' => $value['ISSUE_NO'],
                    'Reason' => $value['TRANS_REASON_DESC'],
                    'Department' => $value['DESCRIPTION'],
                    'Remarks' => $value['REMARKS'],
                    'Prod Qty' => $value['PRODUCTION_QTY'],
                    'Locator' => $value['WS1_CODE']." - ".$value['WS2_CODE'],
                    'Article' => $value['SEGMENT_VALUE_DESC'],
                    'Item Code' => $value['ITEM_CODE'],
                    'Item Code Description' => $value['ITEM_DESC'],
                    'Unit' =>  $value['UOM_SHORT_DESC'],
                    'Quantity' => $value['PRIMARY_QTY'],
                    'Rate' => round($rate,2),
                    'Amount' => number_format($value["ISSUE_AMOUNT"],2),
                    'Category Code' => $value["CAT_CODE"],
                    'Category Description' => $value['CAT_DESC'],
                    'Contra A/C Code' => $loopData["CODE_VALUE"],
                    'Contra A/C DESC' => $loopData["ACCOUNTING_DESC"],
                    'Consumption A/C Code' => $loopData1["CODE_VALUE"],
                    'Consumption A/C DESC' => $loopData1["ACCOUNTING_DESC"],
                );
            }
            return Excel::download(new Material($lineData), 'Material Consumption Report '.$date.'.xlsx');
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function MaterialReportDisplay(Request $request)
    {       
        try{
            $rate2 = 0;
            $data = array();
            $bookss = array();
            $locator = array();
            $transfers = array();
            $sum_rate = $sum_qty = $sum_amount = 0;
            $books = $request->books;
            $department = $request->department;
            $daterange = $request->daterange;
            $artcode = $request->artcode;
            $sono = $request->sono;
            $sinno = $request->sinno;
            $rmcode = $request->rmcode;
            $locator = $request->locator;
            $cat = $request->cat;
            $subcat = $request->subcat;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("d-m-Y", strtotime(substr($daterange, 0,10)));
            $enddte = date("d-m-Y", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);
            if(!empty($locator)){
                $wsarr = explode("-", $locator);
                $ws1 = $wsarr[0]; $ws2 = $wsarr[1];
                $ws2 = trim($ws2," ");
            }
            else{
                $locator = "";
                $ws1 = "";
                $ws2 = "";
            }
            if(!empty($books)){
                $book = $books;
            }else{
                $book = "";
            }
            if(!empty($department)){
                $department = $department;
            }else{
                $department = "";
            }
            if(!empty($sono)){
                $sono = explode(" || ", $sono);
                $sono = $sono[0];
            }else{
                $sono = "";
            }
            if(!empty($sinno)){
                $sinnoarr = explode(" || ", $sinno);
                $sinno = $sinnoarr[0];  
                $strtdte2 = $sinnoarr[1]; 
                $enddte2 = $sinnoarr[1];
            }else{
                $sinno = "";
            }
            if(!empty($rmcode)){
                $rmcode = explode(" || ", $rmcode);
                $rmcode = $rmcode[0];
            }else{
                $rmcode = "";
            }
            if(!empty($strtdte2)){
                $strtdte = $strtdte2;
            }else{
                $strtdte = "";
            }
            if(!empty($enddte2)){
                $enddte = $enddte2;
            }else{
                $enddte = "";
            }
            if(!empty($artcode)){
                $artcode = $artcode;
            }else{
                $artcode = "";
            }
            if(!empty($subcat)){
                $subcat = $subcat;
            }else{
                $subcat = "";
            }
            if(!empty($cat)){
                $cat = $cat;
            }else{
                $cat = "";
            }
            $wizerp  = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            if($department == "NULL"){
                if($book == "Store Issue Note _ Production"){
                    if(empty($artcode)){
                    $sql1 = "SELECT IM.ISSUE_DATE,IM.INV_BOOK_ID,IBM.INV_BOOK_DESC,SOM.SALES_ORDER_NO,IM.ISSUE_NO,TRM.TRANS_REASON_DESC, IM.REMARKS,
                        DM.DESCRIPTION,ISD.PRIMARY_QTY,ISD.ISSUE_AMOUNT,UPR.UOM_SHORT_DESC , ARTCODE.SEGMENT_VALUE_DESC,
                        ITM.ITEM_CODE, ITM.ITEM_DESC , CBV.CODE_VALUE, CBV.ACCOUNTING_DESC, OSD.SEASON_DEF_DESC, IM.PRODUCTION_QTY,
                        WS1.SEGMENT_VALUE AS WS1_CODE, WS2.SEGMENT_VALUE AS WS2_CODE, WS1.SEGMENT_VALUE_DESC AS WS1_DESC, WS2.SEGMENT_VALUE_DESC AS WS2_DESC, CCV3.CODE_VALUE AS COST_CENTER,
                        (W1.SEGMENT_VALUE || '-' || W2.SEGMENT_VALUE || '-' || W3.SEGMENT_VALUE || '-' || W4.SEGMENT_VALUE || '-' || W5.SEGMENT_VALUE || '-' || W6.SEGMENT_VALUE || '-' || W7.SEGMENT_VALUE) AS CAT_CODE,
                        (W1.SEGMENT_VALUE_DESC || '-' || W2.SEGMENT_VALUE_DESC || '-' || W3.SEGMENT_VALUE_DESC || '-' || W4.SEGMENT_VALUE_DESC || '-' || W5.SEGMENT_VALUE_DESC || '-' || W6.SEGMENT_VALUE_DESC || '-' || W7.SEGMENT_VALUE_DESC) AS CAT_DESC
              
                        FROM ISSUE_MT IM
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = IM.INV_BOOK_ID AND INV_BOOK_DESC = '$book'
                        AND IM.ISSUE_DATE BETWEEN '$strtdte2' AND '$enddte2' AND IM.ISSUE_NO LIKE NVL('$sinno','%')
              
                        JOIN SALES_ORDER_MT SOM ON SOM.SALES_ORDER_ID = IM.SALES_ORDER_ID AND SOM.SALES_ORDER_NO LIKE NVL('$sono','%')
                        JOIN TRANSACTION_REASON_MT TRM ON TRM.TRANS_REASON_ID = IM.TRANS_REASON_ID
                        LEFT JOIN DEPARTMENT_MT DM ON DM.DEPARTMENT_ID = IM.DEPARTMENT_ID AND DM.DESCRIPTION LIKE NVL('','%')
                        JOIN ISSUE_DETAIL ISD ON ISD.ISSUE_ID = IM.ISSUE_ID
                        JOIN WIZ_UOM_MT UPR ON ISD.UOM_ID = UPR.UOM_ID
                        JOIN ITEMS_MT ITM ON ITM.ITEM_ID = ISD.ITEM_ID AND ITM.ITEM_CODE LIKE NVL('$rmcode','%')
                        JOIN ITEMS_CATEGORY ITC ON ITC.ITEM_ID = ISD.ITEM_ID
                        JOIN CODE_COMBINATIONS CC ON CC.CODE_COMBINATION_ID = ISD.LOC_CODE_COMB_ID
                        JOIN WIZ_SEGMENT01 WS1 ON WS1.SEGMENT_ID = CC.SEGMENT_ID01 AND WS1.STRUCTURE_ID = 30 AND WS1.SEGMENT_VALUE LIKE NVL('$ws1','%')
                        JOIN WIZ_SEGMENT02 WS2 ON WS2.SEGMENT_ID = CC.SEGMENT_ID02 AND WS2.STRUCTURE_ID = 30 AND WS2.SEGMENT_VALUE LIKE NVL('$ws2','%')
                        JOIN CODE_COMBINATION_VALUES CBV ON CBV.CODE_COMBINATION_ID = ITC.CODE_COMBINATION_ID
                        LEFT JOIN WIZ_SEGMENT03 ARTCODE ON ARTCODE.SEGMENT_ID = ISD.SEGMENT_ID AND ARTCODE.STRUCTURE_ID = ISD.STRUCTURE_ID
                        LEFT JOIN ONSOLE_SEASON_DEFINITION OSD ON OSD.SEASON_DEF_ID = SOM.SEASON_DEF_ID
                        JOIN CODE_COMBINATIONS CC2 ON CC2.CODE_COMBINATION_ID = ITC.CODE_COMBINATION_ID
                        JOIN WIZ_SEGMENT01 W1 ON W1.SEGMENT_ID = CC2.SEGMENT_ID01 AND W1.STRUCTURE_ID = CC2.STRUCTURE_ID AND W1.SEGMENT_VALUE_DESC LIKE NVL('$cat','%')
                        JOIN WIZ_SEGMENT02 W2 ON W2.SEGMENT_ID = CC2.SEGMENT_ID02 AND W2.STRUCTURE_ID = CC2.STRUCTURE_ID AND W2.SEGMENT_VALUE_DESC LIKE NVL('$subcat','%')
                        JOIN WIZ_SEGMENT03 W3 ON W3.SEGMENT_ID = CC2.SEGMENT_ID03 AND W3.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT04 W4 ON W4.SEGMENT_ID = CC2.SEGMENT_ID04 AND W4.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT05 W5 ON W5.SEGMENT_ID = CC2.SEGMENT_ID05 AND W5.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT06 W6 ON W6.SEGMENT_ID = CC2.SEGMENT_ID06 AND W6.STRUCTURE_ID = CC2.STRUCTURE_ID
                        LEFT JOIN WIZ_SEGMENT07 W7 ON W7.SEGMENT_ID = CC2.SEGMENT_ID07 AND W7.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN CODE_COMBINATION_VALUES CCV3 ON CCV3.CODE_COMBINATION_ID = ISD.CC_CODE_COMB_ID
                
                        ORDER BY IM.ISSUE_DATE";
              
                    } 
                    else{
                    $sql1 = "SELECT IM.ISSUE_DATE,IM.INV_BOOK_ID,IBM.INV_BOOK_DESC,SOM.SALES_ORDER_NO,IM.ISSUE_NO,TRM.TRANS_REASON_DESC, IM.REMARKS,
                        DM.DESCRIPTION,ISD.PRIMARY_QTY,ISD.ISSUE_AMOUNT,UPR.UOM_SHORT_DESC , ARTCODE.SEGMENT_VALUE_DESC,
                        ITM.ITEM_CODE, ITM.ITEM_DESC , CBV.CODE_VALUE, CBV.ACCOUNTING_DESC, OSD.SEASON_DEF_DESC, IM.PRODUCTION_QTY,
                        WS1.SEGMENT_VALUE AS WS1_CODE, WS2.SEGMENT_VALUE AS WS2_CODE, WS1.SEGMENT_VALUE_DESC AS WS1_DESC, WS2.SEGMENT_VALUE_DESC AS WS2_DESC, CCV3.CODE_VALUE AS COST_CENTER,
                        (W1.SEGMENT_VALUE || '-' || W2.SEGMENT_VALUE || '-' || W3.SEGMENT_VALUE || '-' || W4.SEGMENT_VALUE || '-' || W5.SEGMENT_VALUE || '-' || W6.SEGMENT_VALUE || '-' || W7.SEGMENT_VALUE) AS CAT_CODE,
                        (W1.SEGMENT_VALUE_DESC || '-' || W2.SEGMENT_VALUE_DESC || '-' || W3.SEGMENT_VALUE_DESC || '-' || W4.SEGMENT_VALUE_DESC || '-' || W5.SEGMENT_VALUE_DESC || '-' || W6.SEGMENT_VALUE_DESC || '-' || W7.SEGMENT_VALUE_DESC) AS CAT_DESC
              
                        FROM ISSUE_MT IM
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = IM.INV_BOOK_ID AND INV_BOOK_DESC = '$book'
                        AND IM.ISSUE_DATE BETWEEN '$strtdte2' AND '$enddte2' AND IM.ISSUE_NO LIKE NVL('$sinno','%')
              
                        JOIN SALES_ORDER_MT SOM ON SOM.SALES_ORDER_ID = IM.SALES_ORDER_ID AND SOM.SALES_ORDER_NO LIKE NVL('$sono','%')
                        JOIN TRANSACTION_REASON_MT TRM ON TRM.TRANS_REASON_ID = IM.TRANS_REASON_ID
                        LEFT JOIN DEPARTMENT_MT DM ON DM.DEPARTMENT_ID = IM.DEPARTMENT_ID AND DM.DESCRIPTION LIKE NVL('','%')
                        JOIN ISSUE_DETAIL ISD ON ISD.ISSUE_ID = IM.ISSUE_ID
                        JOIN WIZ_UOM_MT UPR ON ISD.UOM_ID = UPR.UOM_ID
                        JOIN ITEMS_MT ITM ON ITM.ITEM_ID = ISD.ITEM_ID AND ITM.ITEM_CODE LIKE NVL('$rmcode','%')
                        JOIN ITEMS_CATEGORY ITC ON ITC.ITEM_ID = ISD.ITEM_ID
                        JOIN CODE_COMBINATIONS CC ON CC.CODE_COMBINATION_ID = ISD.LOC_CODE_COMB_ID
                        JOIN WIZ_SEGMENT01 WS1 ON WS1.SEGMENT_ID = CC.SEGMENT_ID01 AND WS1.STRUCTURE_ID = 30 AND WS1.SEGMENT_VALUE LIKE NVL('$ws1','%')
                        JOIN WIZ_SEGMENT02 WS2 ON WS2.SEGMENT_ID = CC.SEGMENT_ID02 AND WS2.STRUCTURE_ID = 30 AND WS2.SEGMENT_VALUE LIKE NVL('$ws2','%')
                        JOIN CODE_COMBINATION_VALUES CBV ON CBV.CODE_COMBINATION_ID = ITC.CODE_COMBINATION_ID
                        JOIN WIZ_SEGMENT03 ARTCODE ON ARTCODE.SEGMENT_ID = ISD.SEGMENT_ID AND ARTCODE.STRUCTURE_ID = ISD.STRUCTURE_ID AND ARTCODE.SEGMENT_VALUE_DESC LIKE NVL('$artcode','%')
                        LEFT JOIN ONSOLE_SEASON_DEFINITION OSD ON OSD.SEASON_DEF_ID = SOM.SEASON_DEF_ID
                        JOIN CODE_COMBINATIONS CC2 ON CC2.CODE_COMBINATION_ID = ITC.CODE_COMBINATION_ID
                        JOIN WIZ_SEGMENT01 W1 ON W1.SEGMENT_ID = CC2.SEGMENT_ID01 AND W1.STRUCTURE_ID = CC2.STRUCTURE_ID AND W1.SEGMENT_VALUE_DESC LIKE NVL('$cat','%')
                        JOIN WIZ_SEGMENT02 W2 ON W2.SEGMENT_ID = CC2.SEGMENT_ID02 AND W2.STRUCTURE_ID = CC2.STRUCTURE_ID AND W2.SEGMENT_VALUE_DESC LIKE NVL('$subcat','%')
                        JOIN WIZ_SEGMENT03 W3 ON W3.SEGMENT_ID = CC2.SEGMENT_ID03 AND W3.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT04 W4 ON W4.SEGMENT_ID = CC2.SEGMENT_ID04 AND W4.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT05 W5 ON W5.SEGMENT_ID = CC2.SEGMENT_ID05 AND W5.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT06 W6 ON W6.SEGMENT_ID = CC2.SEGMENT_ID06 AND W6.STRUCTURE_ID = CC2.STRUCTURE_ID
                        LEFT JOIN WIZ_SEGMENT07 W7 ON W7.SEGMENT_ID = CC2.SEGMENT_ID07 AND W7.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN CODE_COMBINATION_VALUES CCV3 ON CCV3.CODE_COMBINATION_ID = ISD.CC_CODE_COMB_ID
                
                        ORDER BY IM.ISSUE_DATE";
                    }
                }
                else{
                    $sql1 = "SELECT IM.ISSUE_DATE,IM.INV_BOOK_ID,IBM.INV_BOOK_DESC,SOM.SALES_ORDER_NO,IM.ISSUE_NO,TRM.TRANS_REASON_DESC, IM.REMARKS,
                        DM.DESCRIPTION,ISD.PRIMARY_QTY,ISD.ISSUE_AMOUNT,UPR.UOM_SHORT_DESC , ARTCODE.SEGMENT_VALUE_DESC,
                        ITM.ITEM_CODE, ITM.ITEM_DESC , CBV.CODE_VALUE, CBV.ACCOUNTING_DESC, OSD.SEASON_DEF_DESC, IM.PRODUCTION_QTY,
                        WS1.SEGMENT_VALUE AS WS1_CODE, WS2.SEGMENT_VALUE AS WS2_CODE, WS1.SEGMENT_VALUE_DESC AS WS1_DESC, WS2.SEGMENT_VALUE_DESC AS WS2_DESC, CCV3.CODE_VALUE AS COST_CENTER,
                        (W1.SEGMENT_VALUE || '-' || W2.SEGMENT_VALUE || '-' || W3.SEGMENT_VALUE || '-' || W4.SEGMENT_VALUE || '-' || W5.SEGMENT_VALUE || '-' || W6.SEGMENT_VALUE || '-' || W7.SEGMENT_VALUE) AS CAT_CODE,
                        (W1.SEGMENT_VALUE_DESC || '-' || W2.SEGMENT_VALUE_DESC || '-' || W3.SEGMENT_VALUE_DESC || '-' || W4.SEGMENT_VALUE_DESC || '-' || W5.SEGMENT_VALUE_DESC || '-' || W6.SEGMENT_VALUE_DESC || '-' || W7.SEGMENT_VALUE_DESC) AS CAT_DESC
                      
                        FROM ISSUE_MT IM
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = IM.INV_BOOK_ID AND INV_BOOK_DESC = '$book'
                        AND IM.ISSUE_DATE BETWEEN '$strtdte2' AND '$enddte2' AND IM.ISSUE_NO LIKE NVL('$sinno','%')
                
                        LEFT JOIN SALES_ORDER_MT SOM ON SOM.SALES_ORDER_ID = IM.SALES_ORDER_ID
                        JOIN TRANSACTION_REASON_MT TRM ON TRM.TRANS_REASON_ID = IM.TRANS_REASON_ID
                        LEFT JOIN DEPARTMENT_MT DM ON DM.DEPARTMENT_ID = IM.DEPARTMENT_ID
                        JOIN ISSUE_DETAIL ISD ON ISD.ISSUE_ID = IM.ISSUE_ID
                        JOIN WIZ_UOM_MT UPR ON ISD.UOM_ID = UPR.UOM_ID
                        JOIN ITEMS_MT ITM ON ITM.ITEM_ID = ISD.ITEM_ID AND ITM.ITEM_CODE LIKE NVL('$rmcode','%')
                        JOIN ITEMS_CATEGORY ITC ON ITC.ITEM_ID = ISD.ITEM_ID
                        JOIN CODE_COMBINATIONS CC ON CC.CODE_COMBINATION_ID = ISD.LOC_CODE_COMB_ID
                        JOIN WIZ_SEGMENT01 WS1 ON WS1.SEGMENT_ID = CC.SEGMENT_ID01 AND WS1.STRUCTURE_ID = 30 AND WS1.SEGMENT_VALUE LIKE NVL('$ws1','%')
                        JOIN WIZ_SEGMENT02 WS2 ON WS2.SEGMENT_ID = CC.SEGMENT_ID02 AND WS2.STRUCTURE_ID = 30 AND WS2.SEGMENT_VALUE LIKE NVL('$ws2','%')
                        JOIN CODE_COMBINATION_VALUES CBV ON CBV.CODE_COMBINATION_ID = ITC.CODE_COMBINATION_ID
                        LEFT JOIN WIZ_SEGMENT03 ARTCODE ON ARTCODE.SEGMENT_ID = ISD.SEGMENT_ID AND ARTCODE.STRUCTURE_ID = ISD.STRUCTURE_ID
                        LEFT JOIN ONSOLE_SEASON_DEFINITION OSD ON OSD.SEASON_DEF_ID = SOM.SEASON_DEF_ID
                        JOIN CODE_COMBINATIONS CC2 ON CC2.CODE_COMBINATION_ID = ITC.CODE_COMBINATION_ID
                        JOIN WIZ_SEGMENT01 W1 ON W1.SEGMENT_ID = CC2.SEGMENT_ID01 AND W1.STRUCTURE_ID = CC2.STRUCTURE_ID AND W1.SEGMENT_VALUE_DESC LIKE NVL('$cat','%')
                        JOIN WIZ_SEGMENT02 W2 ON W2.SEGMENT_ID = CC2.SEGMENT_ID02 AND W2.STRUCTURE_ID = CC2.STRUCTURE_ID AND W2.SEGMENT_VALUE_DESC LIKE NVL('$subcat','%')
                        JOIN WIZ_SEGMENT03 W3 ON W3.SEGMENT_ID = CC2.SEGMENT_ID03 AND W3.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT04 W4 ON W4.SEGMENT_ID = CC2.SEGMENT_ID04 AND W4.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT05 W5 ON W5.SEGMENT_ID = CC2.SEGMENT_ID05 AND W5.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT06 W6 ON W6.SEGMENT_ID = CC2.SEGMENT_ID06 AND W6.STRUCTURE_ID = CC2.STRUCTURE_ID
                        LEFT JOIN WIZ_SEGMENT07 W7 ON W7.SEGMENT_ID = CC2.SEGMENT_ID07 AND W7.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN CODE_COMBINATION_VALUES CCV3 ON CCV3.CODE_COMBINATION_ID = ISD.CC_CODE_COMB_ID
                
                        ORDER BY IM.ISSUE_DATE";
                } 
            } 
            else{
                if($book == "Store Issue Note _ Production"){
                    if(empty($artcode)){
                    $sql1 = "SELECT IM.ISSUE_DATE,IM.INV_BOOK_ID,IBM.INV_BOOK_DESC,SOM.SALES_ORDER_NO,IM.ISSUE_NO,TRM.TRANS_REASON_DESC, IM.REMARKS,
                        DM.DESCRIPTION,ISD.PRIMARY_QTY,ISD.ISSUE_AMOUNT,UPR.UOM_SHORT_DESC , ARTCODE.SEGMENT_VALUE_DESC,
                        ITM.ITEM_CODE, ITM.ITEM_DESC , CBV.CODE_VALUE, CBV.ACCOUNTING_DESC, OSD.SEASON_DEF_DESC, IM.PRODUCTION_QTY,
                        WS1.SEGMENT_VALUE AS WS1_CODE, WS2.SEGMENT_VALUE AS WS2_CODE, WS1.SEGMENT_VALUE_DESC AS WS1_DESC, WS2.SEGMENT_VALUE_DESC AS WS2_DESC, CCV3.CODE_VALUE AS COST_CENTER,
                        (W1.SEGMENT_VALUE || '-' || W2.SEGMENT_VALUE || '-' || W3.SEGMENT_VALUE || '-' || W4.SEGMENT_VALUE || '-' || W5.SEGMENT_VALUE || '-' || W6.SEGMENT_VALUE || '-' || W7.SEGMENT_VALUE) AS CAT_CODE,
                        (W1.SEGMENT_VALUE_DESC || '-' || W2.SEGMENT_VALUE_DESC || '-' || W3.SEGMENT_VALUE_DESC || '-' || W4.SEGMENT_VALUE_DESC || '-' || W5.SEGMENT_VALUE_DESC || '-' || W6.SEGMENT_VALUE_DESC || '-' || W7.SEGMENT_VALUE_DESC) AS CAT_DESC
                      
                        FROM ISSUE_MT IM
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = IM.INV_BOOK_ID AND INV_BOOK_DESC = '$book'
                        AND IM.ISSUE_DATE BETWEEN '$strtdte2' AND '$enddte2' AND IM.ISSUE_NO LIKE NVL('$sinno','%')
                
                        JOIN SALES_ORDER_MT SOM ON SOM.SALES_ORDER_ID = IM.SALES_ORDER_ID AND SOM.SALES_ORDER_NO LIKE NVL('$sono','%')
                        JOIN TRANSACTION_REASON_MT TRM ON TRM.TRANS_REASON_ID = IM.TRANS_REASON_ID
                        JOIN DEPARTMENT_MT DM ON DM.DEPARTMENT_ID = IM.DEPARTMENT_ID AND DM.DESCRIPTION LIKE NVL('$department','%')
                        JOIN ISSUE_DETAIL ISD ON ISD.ISSUE_ID = IM.ISSUE_ID
                        JOIN WIZ_UOM_MT UPR ON ISD.UOM_ID = UPR.UOM_ID
                        JOIN ITEMS_MT ITM ON ITM.ITEM_ID = ISD.ITEM_ID AND ITM.ITEM_CODE LIKE NVL('$rmcode','%')
                        JOIN ITEMS_CATEGORY ITC ON ITC.ITEM_ID = ISD.ITEM_ID
                        JOIN CODE_COMBINATIONS CC ON CC.CODE_COMBINATION_ID = ISD.LOC_CODE_COMB_ID
                        JOIN WIZ_SEGMENT01 WS1 ON WS1.SEGMENT_ID = CC.SEGMENT_ID01 AND WS1.STRUCTURE_ID = 30 AND WS1.SEGMENT_VALUE LIKE NVL('$ws1','%')
                        JOIN WIZ_SEGMENT02 WS2 ON WS2.SEGMENT_ID = CC.SEGMENT_ID02 AND WS2.STRUCTURE_ID = 30 AND WS2.SEGMENT_VALUE LIKE NVL('$ws2','%')
                        JOIN CODE_COMBINATION_VALUES CBV ON CBV.CODE_COMBINATION_ID = ITC.CODE_COMBINATION_ID
                        LEFT JOIN WIZ_SEGMENT03 ARTCODE ON ARTCODE.SEGMENT_ID = ISD.SEGMENT_ID AND ARTCODE.STRUCTURE_ID = ISD.STRUCTURE_ID
                        LEFT JOIN ONSOLE_SEASON_DEFINITION OSD ON OSD.SEASON_DEF_ID = SOM.SEASON_DEF_ID
                        JOIN CODE_COMBINATIONS CC2 ON CC2.CODE_COMBINATION_ID = ITC.CODE_COMBINATION_ID
                        JOIN WIZ_SEGMENT01 W1 ON W1.SEGMENT_ID = CC2.SEGMENT_ID01 AND W1.STRUCTURE_ID = CC2.STRUCTURE_ID AND W1.SEGMENT_VALUE_DESC LIKE NVL('$cat','%')
                        JOIN WIZ_SEGMENT02 W2 ON W2.SEGMENT_ID = CC2.SEGMENT_ID02 AND W2.STRUCTURE_ID = CC2.STRUCTURE_ID AND W2.SEGMENT_VALUE_DESC LIKE NVL('$subcat','%')
                        JOIN WIZ_SEGMENT03 W3 ON W3.SEGMENT_ID = CC2.SEGMENT_ID03 AND W3.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT04 W4 ON W4.SEGMENT_ID = CC2.SEGMENT_ID04 AND W4.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT05 W5 ON W5.SEGMENT_ID = CC2.SEGMENT_ID05 AND W5.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT06 W6 ON W6.SEGMENT_ID = CC2.SEGMENT_ID06 AND W6.STRUCTURE_ID = CC2.STRUCTURE_ID
                        LEFT JOIN WIZ_SEGMENT07 W7 ON W7.SEGMENT_ID = CC2.SEGMENT_ID07 AND W7.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN CODE_COMBINATION_VALUES CCV3 ON CCV3.CODE_COMBINATION_ID = ISD.CC_CODE_COMB_ID
                
                        ORDER BY IM.ISSUE_DATE";              
                    } 
                    else{
                        // dd("5");
                        $sql1 = "SELECT IM.ISSUE_DATE,IM.INV_BOOK_ID,IBM.INV_BOOK_DESC,SOM.SALES_ORDER_NO,IM.ISSUE_NO,TRM.TRANS_REASON_DESC, IM.REMARKS,
                            DM.DESCRIPTION,ISD.PRIMARY_QTY,ISD.ISSUE_AMOUNT,UPR.UOM_SHORT_DESC , ARTCODE.SEGMENT_VALUE_DESC,
                            ITM.ITEM_CODE, ITM.ITEM_DESC , CBV.CODE_VALUE, CBV.ACCOUNTING_DESC, OSD.SEASON_DEF_DESC, IM.PRODUCTION_QTY,
                            WS1.SEGMENT_VALUE AS WS1_CODE, WS2.SEGMENT_VALUE AS WS2_CODE, WS1.SEGMENT_VALUE_DESC AS WS1_DESC, WS2.SEGMENT_VALUE_DESC AS WS2_DESC, CCV3.CODE_VALUE AS COST_CENTER,
                            (W1.SEGMENT_VALUE || '-' || W2.SEGMENT_VALUE || '-' || W3.SEGMENT_VALUE || '-' || W4.SEGMENT_VALUE || '-' || W5.SEGMENT_VALUE || '-' || W6.SEGMENT_VALUE || '-' || W7.SEGMENT_VALUE) AS CAT_CODE,
                            (W1.SEGMENT_VALUE_DESC || '-' || W2.SEGMENT_VALUE_DESC || '-' || W3.SEGMENT_VALUE_DESC || '-' || W4.SEGMENT_VALUE_DESC || '-' || W5.SEGMENT_VALUE_DESC || '-' || W6.SEGMENT_VALUE_DESC || '-' || W7.SEGMENT_VALUE_DESC) AS CAT_DESC
                      
                            FROM ISSUE_MT IM
                            JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = IM.INV_BOOK_ID AND INV_BOOK_DESC = '$book'
                            AND IM.ISSUE_DATE BETWEEN '$strtdte2' AND '$enddte2' AND IM.ISSUE_NO LIKE NVL('$sinno','%')
                    
                            JOIN SALES_ORDER_MT SOM ON SOM.SALES_ORDER_ID = IM.SALES_ORDER_ID AND SOM.SALES_ORDER_NO LIKE NVL('$sono','%')
                            JOIN TRANSACTION_REASON_MT TRM ON TRM.TRANS_REASON_ID = IM.TRANS_REASON_ID
                            JOIN DEPARTMENT_MT DM ON DM.DEPARTMENT_ID = IM.DEPARTMENT_ID AND DM.DESCRIPTION LIKE NVL('$department','%')
                            JOIN ISSUE_DETAIL ISD ON ISD.ISSUE_ID = IM.ISSUE_ID
                            JOIN WIZ_UOM_MT UPR ON ISD.UOM_ID = UPR.UOM_ID
                            JOIN ITEMS_MT ITM ON ITM.ITEM_ID = ISD.ITEM_ID AND ITM.ITEM_CODE LIKE NVL('$rmcode','%')
                            JOIN ITEMS_CATEGORY ITC ON ITC.ITEM_ID = ISD.ITEM_ID
                            JOIN CODE_COMBINATIONS CC ON CC.CODE_COMBINATION_ID = ISD.LOC_CODE_COMB_ID
                            JOIN WIZ_SEGMENT01 WS1 ON WS1.SEGMENT_ID = CC.SEGMENT_ID01 AND WS1.STRUCTURE_ID = 30 AND WS1.SEGMENT_VALUE LIKE NVL('$ws1','%')
                            JOIN WIZ_SEGMENT02 WS2 ON WS2.SEGMENT_ID = CC.SEGMENT_ID02 AND WS2.STRUCTURE_ID = 30 AND WS2.SEGMENT_VALUE LIKE NVL('$ws2','%')
                            JOIN CODE_COMBINATION_VALUES CBV ON CBV.CODE_COMBINATION_ID = ITC.CODE_COMBINATION_ID
                            JOIN WIZ_SEGMENT03 ARTCODE ON ARTCODE.SEGMENT_ID = ISD.SEGMENT_ID AND ARTCODE.STRUCTURE_ID = ISD.STRUCTURE_ID AND ARTCODE.SEGMENT_VALUE_DESC LIKE NVL('$artcode','%')
                            LEFT JOIN ONSOLE_SEASON_DEFINITION OSD ON OSD.SEASON_DEF_ID = SOM.SEASON_DEF_ID
                            JOIN CODE_COMBINATIONS CC2 ON CC2.CODE_COMBINATION_ID = ITC.CODE_COMBINATION_ID
                            JOIN WIZ_SEGMENT01 W1 ON W1.SEGMENT_ID = CC2.SEGMENT_ID01 AND W1.STRUCTURE_ID = CC2.STRUCTURE_ID AND W1.SEGMENT_VALUE_DESC LIKE NVL('$cat','%')
                            JOIN WIZ_SEGMENT02 W2 ON W2.SEGMENT_ID = CC2.SEGMENT_ID02 AND W2.STRUCTURE_ID = CC2.STRUCTURE_ID AND W2.SEGMENT_VALUE_DESC LIKE NVL('$subcat','%')
                            JOIN WIZ_SEGMENT03 W3 ON W3.SEGMENT_ID = CC2.SEGMENT_ID03 AND W3.STRUCTURE_ID = CC2.STRUCTURE_ID
                            JOIN WIZ_SEGMENT04 W4 ON W4.SEGMENT_ID = CC2.SEGMENT_ID04 AND W4.STRUCTURE_ID = CC2.STRUCTURE_ID
                            JOIN WIZ_SEGMENT05 W5 ON W5.SEGMENT_ID = CC2.SEGMENT_ID05 AND W5.STRUCTURE_ID = CC2.STRUCTURE_ID
                            JOIN WIZ_SEGMENT06 W6 ON W6.SEGMENT_ID = CC2.SEGMENT_ID06 AND W6.STRUCTURE_ID = CC2.STRUCTURE_ID
                            LEFT JOIN WIZ_SEGMENT07 W7 ON W7.SEGMENT_ID = CC2.SEGMENT_ID07 AND W7.STRUCTURE_ID = CC2.STRUCTURE_ID
                            JOIN CODE_COMBINATION_VALUES CCV3 ON CCV3.CODE_COMBINATION_ID = ISD.CC_CODE_COMB_ID
                    
                            ORDER BY IM.ISSUE_DATE";
                    }
                } 
                else{
                    $sql1 = "SELECT IM.ISSUE_DATE,IM.INV_BOOK_ID,IBM.INV_BOOK_DESC,SOM.SALES_ORDER_NO,IM.ISSUE_NO,TRM.TRANS_REASON_DESC, IM.REMARKS,
                        DM.DESCRIPTION,ISD.PRIMARY_QTY,ISD.ISSUE_AMOUNT,UPR.UOM_SHORT_DESC , ARTCODE.SEGMENT_VALUE_DESC,
                        ITM.ITEM_CODE, ITM.ITEM_DESC , CBV.CODE_VALUE, CBV.ACCOUNTING_DESC, OSD.SEASON_DEF_DESC, IM.PRODUCTION_QTY,
                        WS1.SEGMENT_VALUE AS WS1_CODE, WS2.SEGMENT_VALUE AS WS2_CODE, WS1.SEGMENT_VALUE_DESC AS WS1_DESC, WS2.SEGMENT_VALUE_DESC AS WS2_DESC, CCV3.CODE_VALUE AS COST_CENTER,
                        (W1.SEGMENT_VALUE || '-' || W2.SEGMENT_VALUE || '-' || W3.SEGMENT_VALUE || '-' || W4.SEGMENT_VALUE || '-' || W5.SEGMENT_VALUE || '-' || W6.SEGMENT_VALUE || '-' || W7.SEGMENT_VALUE) AS CAT_CODE,
                        (W1.SEGMENT_VALUE_DESC || '-' || W2.SEGMENT_VALUE_DESC || '-' || W3.SEGMENT_VALUE_DESC || '-' || W4.SEGMENT_VALUE_DESC || '-' || W5.SEGMENT_VALUE_DESC || '-' || W6.SEGMENT_VALUE_DESC || '-' || W7.SEGMENT_VALUE_DESC) AS CAT_DESC
                      
                        FROM ISSUE_MT IM
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = IM.INV_BOOK_ID AND INV_BOOK_DESC = '$book'
                        AND IM.ISSUE_DATE BETWEEN '$strtdte2' AND '$enddte2' AND IM.ISSUE_NO LIKE NVL('$sinno','%')
                
                        LEFT JOIN SALES_ORDER_MT SOM ON SOM.SALES_ORDER_ID = IM.SALES_ORDER_ID
                        JOIN TRANSACTION_REASON_MT TRM ON TRM.TRANS_REASON_ID = IM.TRANS_REASON_ID
                        JOIN DEPARTMENT_MT DM ON DM.DEPARTMENT_ID = IM.DEPARTMENT_ID
                        JOIN ISSUE_DETAIL ISD ON ISD.ISSUE_ID = IM.ISSUE_ID
                        JOIN WIZ_UOM_MT UPR ON ISD.UOM_ID = UPR.UOM_ID
                        JOIN ITEMS_MT ITM ON ITM.ITEM_ID = ISD.ITEM_ID AND ITM.ITEM_CODE LIKE NVL('$rmcode','%')
                        JOIN ITEMS_CATEGORY ITC ON ITC.ITEM_ID = ISD.ITEM_ID
                        JOIN CODE_COMBINATIONS CC ON CC.CODE_COMBINATION_ID = ISD.LOC_CODE_COMB_ID
                        JOIN WIZ_SEGMENT01 WS1 ON WS1.SEGMENT_ID = CC.SEGMENT_ID01 AND WS1.STRUCTURE_ID = 30 AND WS1.SEGMENT_VALUE LIKE NVL('$ws1','%')
                        JOIN WIZ_SEGMENT02 WS2 ON WS2.SEGMENT_ID = CC.SEGMENT_ID02 AND WS2.STRUCTURE_ID = 30 AND WS2.SEGMENT_VALUE LIKE NVL('$ws2','%')
                        JOIN CODE_COMBINATION_VALUES CBV ON CBV.CODE_COMBINATION_ID = ITC.CODE_COMBINATION_ID
                        LEFT JOIN WIZ_SEGMENT03 ARTCODE ON ARTCODE.SEGMENT_ID = ISD.SEGMENT_ID AND ARTCODE.STRUCTURE_ID = ISD.STRUCTURE_ID
                        LEFT JOIN ONSOLE_SEASON_DEFINITION OSD ON OSD.SEASON_DEF_ID = SOM.SEASON_DEF_ID
                        JOIN CODE_COMBINATIONS CC2 ON CC2.CODE_COMBINATION_ID = ITC.CODE_COMBINATION_ID
                        JOIN WIZ_SEGMENT01 W1 ON W1.SEGMENT_ID = CC2.SEGMENT_ID01 AND W1.STRUCTURE_ID = CC2.STRUCTURE_ID AND W1.SEGMENT_VALUE_DESC LIKE NVL('$cat','%')
                        JOIN WIZ_SEGMENT02 W2 ON W2.SEGMENT_ID = CC2.SEGMENT_ID02 AND W2.STRUCTURE_ID = CC2.STRUCTURE_ID AND W2.SEGMENT_VALUE_DESC LIKE NVL('$subcat','%')
                        JOIN WIZ_SEGMENT03 W3 ON W3.SEGMENT_ID = CC2.SEGMENT_ID03 AND W3.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT04 W4 ON W4.SEGMENT_ID = CC2.SEGMENT_ID04 AND W4.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT05 W5 ON W5.SEGMENT_ID = CC2.SEGMENT_ID05 AND W5.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN WIZ_SEGMENT06 W6 ON W6.SEGMENT_ID = CC2.SEGMENT_ID06 AND W6.STRUCTURE_ID = CC2.STRUCTURE_ID
                        LEFT JOIN WIZ_SEGMENT07 W7 ON W7.SEGMENT_ID = CC2.SEGMENT_ID07 AND W7.STRUCTURE_ID = CC2.STRUCTURE_ID
                        JOIN CODE_COMBINATION_VALUES CCV3 ON CCV3.CODE_COMBINATION_ID = ISD.CC_CODE_COMB_ID
                
                        ORDER BY IM.ISSUE_DATE";
                }
            }
            $sum_qty = 0; $sum_amount = 0; $sum_rate = 0; $rate = 0;
            $result11 = oci_parse($conn,$sql1);
            oci_execute($result11);
            while($row = oci_fetch_array($result11,  OCI_ASSOC+OCI_RETURN_NULLS)){
                if($row["PRIMARY_QTY"] == 0) {
                    $sum_qty = $sum_qty + $row["PRIMARY_QTY"];
                    $sum_amount = $sum_amount + $row["ISSUE_AMOUNT"];
                } 
                else{
                    $rate = $row["ISSUE_AMOUNT"]/$row["PRIMARY_QTY"];
                    $rate2 = round($rate,2);
                    $sum_qty = $sum_qty + $row["PRIMARY_QTY"];
                    $sum_amount = $sum_amount + $row["ISSUE_AMOUNT"];
                    $sum_rate = $sum_rate + $rate;
                }
                $data[] = array(
                    'data' => $row,
                    'sum_qty' => $sum_qty,
                    'sum_amount' => $sum_amount,
                    'sum_rate' => $sum_rate,
                    'rate' => $row["ISSUE_AMOUNT"]/$row["PRIMARY_QTY"]
                );
            }
            $strtdte2 = date("m/d/Y", strtotime(substr($daterange, 0,10)));
            $strtdte3 = date("m/d/Y", strtotime(substr($daterange, 10)));
            $strtdte2a = date("m/d/Y", strtotime(substr($daterange, 0,10)));
            $strtdte3a = date("m/d/Y", strtotime(substr($daterange, 10)));

            $books1 = array();
            $locator1 = array();
            $department1 = array();
            $category1 = array();
            $subCategory1 = array();

            $daterangeVal = wordwrap($daterange , 10 , ' ' , true );
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql2 = "SELECT DISTINCT BB.DESCRIPTION FROM ISSUE_MT AA, DEPARTMENT_MT BB WHERE AA.DEPARTMENT_ID = BB.DEPARTMENT_ID ORDER BY BB.DESCRIPTION";
            $result2 = oci_parse($conn, strtoupper($sql2));
            oci_execute($result2);
            while($row2 = oci_fetch_array($result2,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $department1[] = $row2["DESCRIPTION"];
            }
            $sql1 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_BOOK_DESC LIKE 'Store Issue%' OR INV_BOOK_DESC LIKE 'Store Return%'";
            $result1 = oci_parse($conn, $sql1);
            oci_execute($result1);
            while($row1 = oci_fetch_array($result1,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $books1[] = $row1["INV_BOOK_DESC"];
            }    
            $sql3 = "SELECT CODE_VALUE, CODE_DESC FROM CODE_COMBINATION_VALUES WHERE STRUCTURE_ID = 30";
            $result3 = oci_parse($conn, $sql3);
            oci_execute($result3);
            while($row3 =oci_fetch_array($result3,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $locator1[] = $row3["CODE_VALUE"]." - ".strtolower($row3["CODE_DESC"]);
            }
            $sql4 = "SELECT W1.SEGMENT_VALUE_DESC FROM WIZ_SEGMENT01 W1 ORDER BY W1.SEGMENT_VALUE_DESC";
            $result4 = oci_parse($conn, $sql4);
            oci_execute($result4);
            while($row4 =oci_fetch_array($result4,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $category1[] = $row4["SEGMENT_VALUE_DESC"];
            }
            $sql5 = "SELECT W2.SEGMENT_VALUE_DESC FROM WIZ_SEGMENT02 W2 ORDER BY W2.SEGMENT_VALUE_DESC";
            $result5 = oci_parse($conn, $sql5);
            oci_execute($result5);
            while($row5 =oci_fetch_array($result5,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $subCategory1[] = $row5["SEGMENT_VALUE_DESC"];
            }

            $sessionData = [
                "requestdepartment" => $request->department,
                "requestbook" => $request->books,
                "requestdaterange" => $request->daterange,
                "requestartcode" => $request->artcode,
                "requestsono" => $request->sono,
                "requestsinno" => $request->sinno,
                "requestrmcode" => $request->rmcode,
                "requestlocator" => $request->locator,
                "requestcat" => $request->cat,
                "requestsubcat" => $request->subcat,

                'Storestart' => date("d/m/Y", strtotime(substr($daterange, 0,10))),
                'Storeend' => date("d/m/Y", strtotime(substr($daterange, -10))),
                'Storestart1' => date("d-M-Y", strtotime(substr($daterange, 0,10))),
                'Storeend2' => date("d-M-Y", strtotime(substr($daterange, -10))),
                'strtdte2a' => date("m/d/Y", strtotime(substr($daterange, 0,10))),
                'strtdte3a' => date("m/d/Y", strtotime(substr($daterange, 10))),
            ];

            return view('report.material')->with([
                "i" => 1, "dep" => 0, "data" => $data, "book" => $books, "subcat" => $subcat, "cat" => $cat, "rate2" => $rate2, "rate" => $rate, "Permission" => 1, "sono" => $sono,
                "locator" => $locator, "enddte2" => $enddte2, "transfer" => $transfers, "strtdte2" => $strtdte2, "strtdte3" => $strtdte3, "strtdte2" => $strtdte2,
                "sum_qty" => number_format($sum_qty,2), "sum_rate" => number_format($sum_rate,2), "sum_amount" => number_format($sum_amount,2), "artcode" => $artcode,
                "daterangeVal" => $daterangeVal, "strtdte" => $strtdte, "locator" => $locator, "booksVal" => $books, "strtdte2a" => $strtdte2a, "strtdte3a" => $strtdte3a,
                "sessionData" => $sessionData,                     
                'sum_qty' => $sum_qty, 'sum_amount' => $sum_amount, 'sum_rate' => $sum_rate,

                "Allbooks" => $books1, 
                "Alllocator" => $locator1,
                "Allcategory" => $category1,
                "Alldepartment" => $department1,
                "AllsubCategory" => $subCategory1,

                "books" => $books1, 
                "locator" => $locator1,
                "category" => $category1,
                "department" => $department1,
                "subCategory" => $subCategory1,

                "requestdepartment" => $request->department,
                "requestbook" => $request->books,
                "requestdaterange" => $request->daterange,
                "requestartcode" => $request->artcode,
                "requestsono" => $request->sono,
                "requestsinno" => $request->sinno,
                "requestrmcode" => $request->rmcode,
                "requestlocator" => $request->locator,
                "requestcat" => $request->cat,
                "requestsubcat" => $request->subcat,
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

    public function Comparison(Request $request)
    {
        try{
            $customer = array(); $category = array(); $season = array();
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $result1 = DB::table('job_sheet_order_mt')->orderBy('Cust_Name', 'asc')->get()->unique('Cust_Name');
            foreach($result1 as $data){
                $customer[] = $data->Cust_Name;
            }
            $sql4 = "SELECT ITEM_TYPE_DESC FROM WIZ_ITEM_TYPE_MT";
            $result4 = oci_parse($conn, $sql4);
            oci_execute($result4);
            while($row4 = oci_fetch_array($result4,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $category[] = $row4["ITEM_TYPE_DESC"];
            }
            $result3 = DB::table('job_sheet_order_mt')->get('Season')->unique('Season');
            foreach($result3 as $data){
                $season[] = $data->Season;
            }
            return view('report.comparison')->with([
                "Permission" => 0,
                "customer" => $customer, 
                "season" => $season, 
                "category" => $category, 
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

    public function ComparisonDownload(Request $request)
    {
        try{
            date_default_timezone_set("Asia/karachi");
            $date = date("d-m-Y");
            $Arraydata = array();
            $dataStore =  array();
            $articleno = $request->articleno;
            $sono = $request->salesorder;
            $daterange = $request->daterange;
            $Storedaterange = $request->daterange;
            $season = $request->season;
            $rawmaterial = $request->rawmaterial;
            $customer = $request->customer;
            $department = $request->department;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("d-m-Y", strtotime(substr($daterange, 0,10)));
            $enddte = date("d-m-Y", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);

            if(!empty($customer)){
                $customer = $customer;
            }else{
                $customer = "";
            }
            if(!empty($department)){
                $department = $department;
            }else{
                $department = "";
            }
            if(!empty($thedate)){
                $thedate = $thedate;
            }else{
                $thedate = "";
            }
            if(!empty($rmcodet)){
                $rmcoarrf = explode(" || ",mysqli_real_escape_string($link,$rmcodet));
                $rmcodet = $rmcoarrf[0];
            }else{
                $rmcodet = "";
            }
            if(!empty($article)){
                $article = $article;
            }else{
                $article = "";
            }
            if(!empty($sono)){
                $sono = $sono;
            }else{
                $sono = "";
            }
            if(!empty($season)){
                $season = $season;
            }else{
                $season = "";
            }
            if(empty($customer) && empty($department) && empty($season) && empty($sono) && empty($article) && empty($rmcodet)){
                $datecheck = "2025-01-01";
            }else{
                $datecheck = "";
            }
            if(!empty($strtdte2)){
                $strtdte = $strtdte2;
                $strtdte22 = $strtdte2;
            }else{
                $strtdte22 = "";
                $strtdte = "";
            }
            if(!empty($enddte2)){
                $enddte = $enddte2;
                $enddte22 = $enddte2;
            }else{
                $enddte22 = "";
                $enddte = "";
            }

            $Arraydata = DB::select(DB::raw("SELECT t.totals, jsom.Job_Id, jsom.Cust_Name, jsom.Onsole_Art_No, jsom.So_No, jsom.Season, jsom.Department, jsod.Rm_Code, jsod.Job_Desc, SUM(jsod.Qty) As Quantity, jsom.Delivery_Date, DATE_FORMAT(JSOM.Date_Created, '%d-%b-%Y') as RTTIME
                                                FROM job_sheet_order_mt jsom                                       
                                                join job_sheet_order_det jsod on jsod.Job_Id = jsom.Job_Id
                                                join (select sbmt.Job_Id, SUM(sbmt.total) as totals from job_sheet_order_sbmt sbmt GROUP BY sbmt.Job_Id) t
                                                on t.Job_Id = jsom.Job_Id                                        
                                                WHERE jsom.Department LIKE '".$department."%' and jsom.Cust_Name LIKE '".$customer."%' and jsom.Season LIKE '".$season."%' and jsom.So_No LIKE '".$sono."%' and jsom.Onsole_Art_No LIKE '".$article."%' and jsod.Rm_Code LIKE '".$rmcodet."%' and jsom.Date_Created like '".$datecheck."%'                                        
                                                group by jsom.Job_Id, jsom.Cust_Name, jsom.Onsole_Art_No, jsom.So_No, jsom.Season, jsom.Department, jsod.Rm_Code, jsod.Job_Desc, jsom.Date_Created, jsom.Delivery_Date, t.totals
                                                order by jsom.Job_Id, jsod.Rm_Code"));

            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $actqty = $diffqty = $actrate = $diffamt = $actamt = $estamt = $rem_check = $key = $keycode = $rateof = 0;                                        
            $book = $status = $rate = $rate2 = $month_name = $month_name2 =  $article0 = $department0 = $sono0 = "";
            $adjustno = $pino = $pidate = $tempcode = "";
            $sum_rate = $sum_qty = $sum_amount = $poqty = $i = $sumamount = $sumtax = $sumamtinctax = $sumpoqty = $pndgcounter = $tcheck = 0;
            $item_code = array(); $purchinv = array(); $pidate2 = array(); $arrayhe = array(); $sumof = array(0,0,0,0,0,0,0,0,0);  $rmcoarr = array();
            $poqtytotal = $poreceivedtotal = $porejectedtotal = $poacceptedtotal = $popendingtotal = $poamounttotal = $postaxtotal = $pototal = 0;
            $sumpoqtytotal = $sumporcvtotal = $sumporejtotal = $sumpoacctotal = $sumpopentotal = $sumpoamttotal = $sumpostaxtotal = $sumpototal = $pendingme = 0;
            
            foreach($Arraydata as $row){
                $jobid = $row->Job_Id;  $SO_NO = $row->So_No; $article = $row->Onsole_Art_No; $departmentERP = $row->Department;  $item_code_now = $row->Rm_Code; $totaling = (int)$row->totals;
                $sql3 = "SELECT SUM(ID.PRIMARY_QTY) AS QUANTITY, SUM(ID.ISSUE_AMOUNT) AS AMOUNT
                            FROM ISSUE_MT IM
                            JOIN ISSUE_DETAIL ID ON ID.ISSUE_ID = IM.ISSUE_ID
                            JOIN DEPARTMENT_MT DM ON DM.DEPARTMENT_ID = IM.DEPARTMENT_ID AND DM.DESCRIPTION LIKE NVL('$departmentERP','%')
                            JOIN SALES_ORDER_MT SOM ON SOM.SALES_ORDER_ID = IM.SALES_ORDER_ID AND SOM.SALES_ORDER_NO LIKE NVL('$SO_NO','%')
                            JOIN ITEMS_MT ITEM ON ITEM.ITEM_ID = ID.ITEM_ID AND ITEM.ITEM_CODE LIKE NVL('$item_code_now','%')
                            JOIN WIZ_SEGMENT03 ARTCODE ON ARTCODE.SEGMENT_ID = ID.SEGMENT_ID AND ARTCODE.SEGMENT_VALUE_DESC LIKE NVL('$article','%')
                            WHERE IM.ISSUE_DATE BETWEEN '$strtdte2' AND '$enddte2'";

                $prodqty = 0; $conspqty = 0;
                $result3 = oci_parse($conn,$sql3);
                oci_execute($result3);
                $row3 = oci_fetch_array($result3,  OCI_ASSOC+OCI_RETURN_NULLS);

                $sql4 = "SELECT SUM(IMM.PRODUCTION_QTY) AS PROD_QTY
                            FROM ISSUE_MT IMM
                            JOIN ISSUE_DETAIL IDD ON IDD.ISSUE_ID = IMM.ISSUE_ID
                            JOIN DEPARTMENT_MT DMM ON DMM.DEPARTMENT_ID = IMM.DEPARTMENT_ID AND DMM.DESCRIPTION LIKE NVL('$departmentERP','%')
                            JOIN SALES_ORDER_MT SOMM ON SOMM.SALES_ORDER_ID = IMM.SALES_ORDER_ID AND SOMM.SALES_ORDER_NO LIKE NVL('$SO_NO','%')
                            JOIN ITEMS_MT ITEMM ON ITEMM.ITEM_ID = IDD.ITEM_ID AND ITEMM.ITEM_CODE LIKE NVL('$item_code_now','%')
                            JOIN WIZ_SEGMENT03 ARTCODEE ON ARTCODEE.SEGMENT_ID = IDD.SEGMENT_ID AND ARTCODEE.SEGMENT_VALUE_DESC LIKE NVL('$article','%')                                            
                            WHERE IMM.ISSUE_DATE BETWEEN '$strtdte2' AND '$enddte2'";

                $result4 = oci_parse($conn,$sql4);
                oci_execute($result4);
                $row4 = oci_fetch_array($result4,  OCI_ASSOC+OCI_RETURN_NULLS);

                if($row3 == NULL){  
                    $actqty = 0;  $actrate = 0;  $actamt = 0; $prodqty = 0; $conspqty = 0;
                }
                else{
                    if($row3["QUANTITY"] != 0){ 
                        $rate3 = $row3["AMOUNT"]/$row3["QUANTITY"]; 
                    } 
                    else{  
                        $rate3 = 0; 
                    }
                    $actqty = $row3["QUANTITY"];  $actrate = $rate3;  $actamt = $row3["AMOUNT"];
                    $prodqty = number_format($row4["PROD_QTY"],2);
                    if($totaling != 0){  
                        $conspqty = $row4["PROD_QTY"]*($row->Quantity/$totaling); 
                    } 
                    else{ 
                        $conspqty = 0; 
                    }
                }
                $jobqty = number_format($totaling,2);
                if($totaling != 0){  
                    $rateperpair = number_format(($row->Quantity/$totaling),2);  
                } 
                else{  
                    $rateperpair = 0;  
                }

                $estamt = $actrate*$row->Quantity;
                $diffqty = $row->Quantity-$actqty;  $diffamt = $estamt-$actamt;
                $diffact = $actqty - $conspqty;

                $lineData[] = array(
                    'Job Order' => $row->Job_Id." ".$row->RTTIME,
                    'Customer' => $row->Cust_Name,
                    'Sale Order' => $row->So_No,
                    'Article' => $row->Onsole_Art_No,
                    'Delivery Date' => $row->Onsole_Art_No,
                    'Department' => $row->Department,
                    'Season' => $row->Season,
                    'Item Code' => $row->Rm_Code,
                    'Item Desc' => $row->Job_Desc,
                    'Job Order Qty' => $jobqty,
                    'Planned Qty' => number_format($row->Quantity,2),
                    'Planned Rate' => number_format($actrate,2),
                    'Planned Amount' => number_format($estamt,2),
                    'Actual Qty' => number_format($actqty,2),
                    'Actual Rate' => number_format($actrate,2),
                    'Actual Amount' => number_format($actamt,2),
                    'Production Qty' => $prodqty,
                    'Consumption Per Pair' => number_format($rateperpair,4),
                    'Est Qty' => number_format($conspqty,4),
                    'Diff P vs A' => number_format($diffqty,2),
                    'Diff A vs E' => number_format($diffact,2),
                    'Diff Amount' => number_format($diffamt,2),
                );                
            }
            return Excel::download(new Comparison($lineData), 'Consumption Comparison Report '.$date.'.xlsx');                    
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function ComparisonDisplay(Request $request)
    {       
        try{
            $Arraydata = array();
            $dataStore =  array();
            $articleno = $request->articleno;
            $sono = $request->salesorder;
            $daterange = $request->daterange;
            $Storedaterange = $request->daterange;
            $season = $request->season;
            $rawmaterial = $request->rawmaterial;
            $customer = $request->customer;
            $department = $request->department;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("d-m-Y", strtotime(substr($daterange, 0,10)));
            $enddte = date("d-m-Y", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);

            if(!empty($customer)){
                $customer = $customer;
            }else{
                $customer = "";
            }
            if(!empty($department)){
                $department = $department;
            }else{
                $department = "";
            }
            if(!empty($thedate)){
                $thedate = $thedate;
            }else{
                $thedate = "";
            }
            if(!empty($rmcodet)){
                $rmcoarrf = explode(" || ",mysqli_real_escape_string($link,$rmcodet));
                $rmcodet = $rmcoarrf[0];
            }else{
                $rmcodet = "";
            }
            if(!empty($article)){
                $article = $article;
            }else{
                $article = "";
            }
            if(!empty($sono)){
                $sono = $sono;
            }else{
                $sono = "";
            }
            if(!empty($season)){
                $season = $season;
            }else{
                $season = "";
            }
            if(empty($customer) && empty($department) && empty($season) && empty($sono) && empty($article) && empty($rmcodet)){
                $datecheck = "2025-01-01";
            }else{
                $datecheck = "";
            }
            if(!empty($strtdte2)){
                $strtdte = $strtdte2;
                $strtdte22 = $strtdte2;
            }else{
                $strtdte22 = "";
                $strtdte = "";
            }
            if(!empty($enddte2)){
                $enddte = $enddte2;
                $enddte22 = $enddte2;
            }else{
                $enddte22 = "";
                $enddte = "";
            }
         
            $Arraydata = DB::select(DB::raw("SELECT t.totals, jsom.Job_Id, jsom.Cust_Name, jsom.Onsole_Art_No, jsom.So_No, jsom.Season, jsom.Department, jsod.Rm_Code, jsod.Job_Desc, SUM(jsod.Qty) As Quantity, jsom.Delivery_Date, DATE_FORMAT(JSOM.Date_Created, '%d-%b-%Y') as RTTIME

            FROM job_sheet_order_mt jsom
     
            join job_sheet_order_det jsod on jsod.Job_Id = jsom.Job_Id
            join (select sbmt.Job_Id, SUM(sbmt.total) as totals from job_sheet_order_sbmt sbmt GROUP BY sbmt.Job_Id) t
            on t.Job_Id = jsom.Job_Id
     
            WHERE jsom.Department LIKE '".$department."%' and jsom.Cust_Name LIKE '".$customer."%' and jsom.Season LIKE '".$season."%' and jsom.So_No LIKE '".$sono."%' and jsom.Onsole_Art_No LIKE '".$article."%' and jsod.Rm_Code LIKE '".$rmcodet."%' and jsom.Date_Created like '".$datecheck."%'
     
            group by jsom.Job_Id, jsom.Cust_Name, jsom.Onsole_Art_No, jsom.So_No, jsom.Season, jsom.Department, jsod.Rm_Code, jsod.Job_Desc, jsom.Date_Created, jsom.Delivery_Date, t.totals
            order by jsom.Job_Id, jsod.Rm_Code"));

            $strtdte2 = date("m/d/Y", strtotime(substr($daterange, 0,10)));
            $strtdte3 = date("m/d/Y", strtotime(substr($daterange, 10)));
            $strtdte2a = date("m/d/Y", strtotime(substr($daterange, 0,10)));
            $strtdte3a = date("m/d/Y", strtotime(substr($daterange, 10)));

            $books1 = array();
            $locator1 = array();
            $department1 = array();
            $category1 = array();
            $subCategory1 = array();

            $daterangeVal = wordwrap($daterange , 10 , ' ' , true );
            $customerData = array(); $categoryData = array(); $seasonData = array();
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $result1 = DB::table('job_sheet_order_mt')->orderBy('Cust_Name', 'asc')->get()->unique('Cust_Name');
            foreach($result1 as $data){
                $customerData[] = $data->Cust_Name;
            }
            $sql4 = "SELECT ITEM_TYPE_DESC FROM WIZ_ITEM_TYPE_MT";
            $result4 = oci_parse($conn, $sql4);
            oci_execute($result4);
            while($row4 = oci_fetch_array($result4,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $categoryData[] = $row4["ITEM_TYPE_DESC"];
            }
            $result3 = DB::table('job_sheet_order_mt')->get('Season')->unique('Season');
            foreach($result3 as $data){
                $seasonData[] = $data->Season;
            }

            $sessionData = [
                'articleno' => $request->articleno,
                'salesorder' => $request->salesorder,
                'season' => $request->season,
                'rawmaterial' => $request->rawmaterial,
                'customer' => $request->customer,
                'department' => $request->department,
                'strtdte2a' => $strtdte2a,
                'strtdte3a' => $strtdte3a,
                'Storestart' => date("d/m/Y", strtotime(substr($Storedaterange, 0,10))),
                'Storeend' => date("d/m/Y", strtotime(substr($Storedaterange, -10))),
                'Storestart1' => date("d-M-Y", strtotime(substr($Storedaterange, 0,10))),
                'Storeend2' => date("d-M-Y", strtotime(substr($Storedaterange, -10))),
            ];

            return view('report.comparison')->with([
                "data" => $Arraydata, "Permission" => 1, "sessionData" => $sessionData, "i" => 1,
                "customer" => $customerData, "category" => $categoryData, "season" => $seasonData, 
                'articleno' => $request->articleno,
                'salesorder' => $request->salesorder,
                'rawmaterial' => $request->rawmaterial,
                'department' => $request->department,
                'strtdte2a' => $strtdte2a,
                'strtdte3a' => $strtdte3a,
                'sono' => $sono,
                'enddte' => $enddte,
                'strtdte' => $enddte,
                'strtdte22' => $strtdte22,
                'enddte22' => $enddte22
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

    public function PurchaseInvoice(Request $request)
    {
        try{
            $book = array(); $subCategory = array(); $category = array();
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql3 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_BOOK_DESC LIKE 'Purchase Inv%' ";
            $result3 = oci_parse($conn, $sql3);
            oci_execute($result3);
            while($row3 = oci_fetch_array($result3,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $book[] = $row3["INV_BOOK_DESC"];
            }
            $sql4 = "SELECT W1.SEGMENT_VALUE_DESC FROM WIZ_SEGMENT01 W1 ORDER BY W1.SEGMENT_VALUE_DESC";
            $result4 = oci_parse($conn, $sql4);
            oci_execute($result4);
            while($row4 = oci_fetch_array($result4,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $category[] = $row4["SEGMENT_VALUE_DESC"];
            }
            $sql5 = "SELECT W2.SEGMENT_VALUE_DESC FROM WIZ_SEGMENT02 W2 ORDER BY W2.SEGMENT_VALUE_DESC";
            $result5 = oci_parse($conn, $sql5);
            oci_execute($result5);
            while($row5 = oci_fetch_array($result5,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $subCategory[] = $row5["SEGMENT_VALUE_DESC"];
            }
            return view('report.purchaseinvoice')->with([
                "Permission" => 0,
                "book" => $book, 
                "category" => $category, 
                "subCategory" => $subCategory, 
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

    public function PurchaseInvoiceDownload(Request $request)
    {
        try{
            date_default_timezone_set("Asia/karachi");
            $date = date("d-m-Y");
            $rate2 = 0;
            $data = array();
            $bookss = array();
            $locator = array();
            $transfers = array();
            $sum_t_amount = $sum_qty = $total_amount = $rate = $sum_amount = 0;
            $bookData = array(); $subCategoryData = array(); $categoryData = array();
            $books = $request->book;
            $pinv = $request->pinv;
            $daterange = $request->daterange;
            $supplier = $request->supplier;
            $rmcode = $request->itemcode;
            $cat = $request->cat;
            $subcat = $request->subcat;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("d-m-Y", strtotime(substr($daterange, 0,10)));
            $enddte = date("d-m-Y", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $Storedaterange = $request->daterange;
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);
            if(!empty($books)){
                $book = $books;
            }else{
                $book = "";
            }
            if(!empty($pinv)){
                $pinv = $pinv;
            }else{
                $pinv = "";
            }
            if(!empty($strtdte2)){
                $strtdte = $strtdte2;
            }else{
                $strtdte = "";
            }
            if(!empty($enddte2)){
                $enddte = $enddte2;
            }else{
                $enddte = "";
            }
            if(!empty($supplier)){
                $supplier = $supplier;
            }else{
                $supplier = "";
            }
            if(!empty($subcat)){
                $subcat = $subcat;
            }else{
                $subcat = "";
            }
            if(!empty($cat)){
                $cat = $cat;
            }else{
                $cat = "";
            }
            if(!empty($pinv)){
                $pinvarr = explode(" || ", $pinv);
                $pinv = $pinvarr[0]; $pidate = $pinvarr[1];
            }else{
                $pinv = ""; $pidate = "";
            }
            if(!empty($rmcode)){
                $rmcoarr = explode(" || ", $rmcode);
                $rmcode = $rmcoarr[0];
            }else{
                $rmcode = "";
            }

            $wizerp  = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            if(!empty($pinv)){
                $sql = "SELECT PID.SR_NO, SCM.CATEGORY_DESC, SM.COMPANY_NAME, PTM.PAYMENT_TERM_DESC, PIM.DOCUMENT_NO, PIM.GL_DATE, GM.GRN_NO, GM.GRN_DATE, IM.ITEM_CODE, IM.ITEM_DESC, PID.PRIMARY_QTY, (PID.AMOUNT/PID.PRIMARY_QTY) AS RATE, IBM.INV_BOOK_DESC,
                        SGM.STAX_GROUP_DESC, PID.STAX_AMOUNT, PID.AMOUNT, (PID.STAX_AMOUNT+PID.AMOUNT) AS TAmount, PID.PRO_EXP_TC_AMOUNT, ((PID.PRO_EXP_TC_AMOUNT/(PID.TC_AMOUNT+PID.STAX_AMOUNT))*100) AS PRO_EXP,
                        (W1.SEGMENT_VALUE || '-' || W2.SEGMENT_VALUE || '-' || W3.SEGMENT_VALUE || '-' || W4.SEGMENT_VALUE || '-' || W5.SEGMENT_VALUE || '-' || W6.SEGMENT_VALUE || '-' || W7.SEGMENT_VALUE) AS CAT_CODE,
                        (W1.SEGMENT_VALUE_DESC || '-' || W2.SEGMENT_VALUE_DESC || '-' || W3.SEGMENT_VALUE_DESC || '-' || W4.SEGMENT_VALUE_DESC || '-' || W5.SEGMENT_VALUE_DESC || '-' || W6.SEGMENT_VALUE_DESC || '-' || W7.SEGMENT_VALUE_DESC) AS CAT_DESC              
                        FROM PURCHASE_INVOICE_MT PIM                        
                        JOIN PURCHASE_INVOICE_DETAIL PID ON PID.PURCH_INVOICE_ID = PIM.PURCH_INVOICE_ID
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = PIM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('$book','%')
                        JOIN SUPPLIER_MT SM ON SM.SUPPLIER_ID = PIM.SUPPPLIER_ID
                        JOIN SUPP_CATAGORY_MT SCM ON SCM.SUPP_CATAG_ID = SM.SUPP_CATAG_ID
                        JOIN PAYMENT_TERMS_MT PTM ON PTM.PAYMENT_TERM_ID = PIM.PAYMENT_TERM_ID
                        JOIN ITEMS_MT IM ON IM.ITEM_ID = PID.ITEM_ID AND IM.ITEM_CODE LIKE NVL('$rmcode','%')
                        LEFT JOIN STAX_GROUP_MT SGM ON SGM.STAX_GROUP_ID = PID.STAX_GROUP_ID
                        JOIN GRN_DETAIL GD ON GD.GRN_DET_ID = PID.MATCH_WITH_ID
                        JOIN GRN_MT GM ON GM.GRN_ID = GD.GRN_ID
                        JOIN ITEMS_CATEGORY IC ON IC.ITEM_ID = IM.ITEM_ID
                        JOIN CODE_COMBINATIONS CC ON CC.CODE_COMBINATION_ID = IC.CODE_COMBINATION_ID
                        JOIN WIZ_SEGMENT01 W1 ON W1.SEGMENT_ID = CC.SEGMENT_ID01 AND W1.STRUCTURE_ID = CC.STRUCTURE_ID AND W1.SEGMENT_VALUE_DESC LIKE NVL('$cat','%')
                        JOIN WIZ_SEGMENT02 W2 ON W2.SEGMENT_ID = CC.SEGMENT_ID02 AND W2.STRUCTURE_ID = CC.STRUCTURE_ID AND W2.SEGMENT_VALUE_DESC LIKE NVL('$subcat','%')
                        JOIN WIZ_SEGMENT03 W3 ON W3.SEGMENT_ID = CC.SEGMENT_ID03 AND W3.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT04 W4 ON W4.SEGMENT_ID = CC.SEGMENT_ID04 AND W4.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT05 W5 ON W5.SEGMENT_ID = CC.SEGMENT_ID05 AND W5.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT06 W6 ON W6.SEGMENT_ID = CC.SEGMENT_ID06 AND W6.STRUCTURE_ID = CC.STRUCTURE_ID
                        LEFT JOIN WIZ_SEGMENT07 W7 ON W7.SEGMENT_ID = CC.SEGMENT_ID07 AND W7.STRUCTURE_ID = CC.STRUCTURE_ID                        
                        WHERE PIM.DOCUMENT_NO = '$pinv' AND TO_CHAR(PIM.GL_DATE, 'dd-MON-yy') = '$pidate'                        
                        ORDER BY SM.COMPANY_NAME, PIM.DOCUMENT_NO, PIM.GL_DATE DESC";
            } 
            else{
                $sql = "SELECT PID.SR_NO, SCM.CATEGORY_DESC, SM.COMPANY_NAME, PTM.PAYMENT_TERM_DESC, PIM.DOCUMENT_NO, PIM.GL_DATE, GM.GRN_NO, GM.GRN_DATE, IM.ITEM_CODE, IM.ITEM_DESC, PID.PRIMARY_QTY, (PID.AMOUNT/PID.PRIMARY_QTY) AS RATE, IBM.INV_BOOK_DESC,
                        SGM.STAX_GROUP_DESC, PID.STAX_AMOUNT, PID.AMOUNT, (PID.STAX_AMOUNT+PID.AMOUNT) AS TAmount, PID.PRO_EXP_TC_AMOUNT, ((PID.PRO_EXP_TC_AMOUNT/(PID.TC_AMOUNT+PID.STAX_AMOUNT))*100) AS PRO_EXP,
                        (W1.SEGMENT_VALUE || '-' || W2.SEGMENT_VALUE || '-' || W3.SEGMENT_VALUE || '-' || W4.SEGMENT_VALUE || '-' || W5.SEGMENT_VALUE || '-' || W6.SEGMENT_VALUE || '-' || W7.SEGMENT_VALUE) AS CAT_CODE,
                        (W1.SEGMENT_VALUE_DESC || '-' || W2.SEGMENT_VALUE_DESC || '-' || W3.SEGMENT_VALUE_DESC || '-' || W4.SEGMENT_VALUE_DESC || '-' || W5.SEGMENT_VALUE_DESC || '-' || W6.SEGMENT_VALUE_DESC || '-' || W7.SEGMENT_VALUE_DESC) AS CAT_DESC
                        FROM PURCHASE_INVOICE_MT PIM
                        JOIN PURCHASE_INVOICE_DETAIL PID ON PID.PURCH_INVOICE_ID = PIM.PURCH_INVOICE_ID
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = PIM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('$book','%')
                        JOIN SUPPLIER_MT SM ON SM.SUPPLIER_ID = PIM.SUPPPLIER_ID
                        JOIN SUPP_CATAGORY_MT SCM ON SCM.SUPP_CATAG_ID = SM.SUPP_CATAG_ID
                        JOIN PAYMENT_TERMS_MT PTM ON PTM.PAYMENT_TERM_ID = PIM.PAYMENT_TERM_ID
                        JOIN ITEMS_MT IM ON IM.ITEM_ID = PID.ITEM_ID AND IM.ITEM_CODE LIKE NVL('$rmcode','%')
                        LEFT JOIN STAX_GROUP_MT SGM ON SGM.STAX_GROUP_ID = PID.STAX_GROUP_ID
                        JOIN GRN_DETAIL GD ON GD.GRN_DET_ID = PID.MATCH_WITH_ID
                        JOIN GRN_MT GM ON GM.GRN_ID = GD.GRN_ID
                        JOIN ITEMS_CATEGORY IC ON IC.ITEM_ID = IM.ITEM_ID
                        JOIN CODE_COMBINATIONS CC ON CC.CODE_COMBINATION_ID = IC.CODE_COMBINATION_ID
                        JOIN WIZ_SEGMENT01 W1 ON W1.SEGMENT_ID = CC.SEGMENT_ID01 AND W1.STRUCTURE_ID = CC.STRUCTURE_ID AND W1.SEGMENT_VALUE_DESC LIKE NVL('$cat','%')
                        JOIN WIZ_SEGMENT02 W2 ON W2.SEGMENT_ID = CC.SEGMENT_ID02 AND W2.STRUCTURE_ID = CC.STRUCTURE_ID AND W2.SEGMENT_VALUE_DESC LIKE NVL('$subcat','%')
                        JOIN WIZ_SEGMENT03 W3 ON W3.SEGMENT_ID = CC.SEGMENT_ID03 AND W3.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT04 W4 ON W4.SEGMENT_ID = CC.SEGMENT_ID04 AND W4.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT05 W5 ON W5.SEGMENT_ID = CC.SEGMENT_ID05 AND W5.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT06 W6 ON W6.SEGMENT_ID = CC.SEGMENT_ID06 AND W6.STRUCTURE_ID = CC.STRUCTURE_ID
                        LEFT JOIN WIZ_SEGMENT07 W7 ON W7.SEGMENT_ID = CC.SEGMENT_ID07 AND W7.STRUCTURE_ID = CC.STRUCTURE_ID                        
                        WHERE PIM.PURCH_INVOICE_DATE BETWEEN '$strtdte2' AND '$enddte2'                        
                        ORDER BY SM.COMPANY_NAME, PIM.DOCUMENT_NO, PIM.GL_DATE DESC";
            }
            $result11 = oci_parse($conn,$sql);
            oci_execute($result11);
            while($row = oci_fetch_array($result11,  OCI_ASSOC+OCI_RETURN_NULLS)){
                if(!empty($row["STAX_TC_AMOUNT"])){
                    $total_amount = $row["STAX_TC_AMOUNT"] + $row["AMOUNT"];
                } 
                else{
                    $total_amount = $row["AMOUNT"];
                }
                $sum_qty = $sum_qty + $row["PRIMARY_QTY"];
                $sum_amount = $sum_amount + $row["AMOUNT"];
                $sum_t_amount = $sum_t_amount + $total_amount;
                
                if($row["PRIMARY_QTY"] != 0){
                    $rate = $total_amount / $row["PRIMARY_QTY"];
                } 
                else{
                    $rate = 0;
                }
                $lineData[] = array(
                    'Book' => $row["INV_BOOK_DESC"],
                    'P Inv No' => $row["DOCUMENT_NO"],
                    'P Inv Date' => $row["GL_DATE"],
                    'Supplier Category' => $row["CATEGORY_DESC"],
                    'Supplier' => $row["COMPANY_NAME"],
                    'Payment Term' => $row["PAYMENT_TERM_DESC"],
                    'GRN No' => $row["GRN_NO"],
                    'GRN Date' => $row["GRN_DATE"],
                    'SR. No' => $row["SR_NO"],
                    'Item Code' => $row["ITEM_CODE"],
                    'Item Desc' => $row["ITEM_DESC"],
                    'Qty' => number_format($row["PRIMARY_QTY"],2),
                    'Rate' => number_format($rate,2),
                    'Exl Tax Amount' => number_format($row["AMOUNT"],2),
                    'Sales Tax %' => $row["STAX_GROUP_DESC"],
                    'Sales Tax Amount' => number_format($row["STAX_AMOUNT"],2),
                    'Inc Tax Amount' => number_format($total_amount,2),
                    'Exp Prorate' => number_format($row["PRO_EXP_TC_AMOUNT"],2),
                    'Exp PR' => number_format($row["PRO_EXP"],2),
                    'Category Code' => $row["CAT_CODE"],
                    'Category Description' => $row["CAT_DESC"],
                );
            }
            return Excel::download(new PurchaseInvoice($lineData), 'Purchase Invoice Report '.$date.'.xlsx');
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function PurchaseInvoiceDisplay(Request $request)
    {       
        try{
            $rate2 = 0;
            $data = array();
            $bookss = array();
            $locator = array();
            $transfers = array();
            $sum_t_amount = $sum_qty = $total_amount = $rate = $sum_amount = 0;
            $bookData = array(); $subCategoryData = array(); $categoryData = array();
            $books = $request->book;
            $pinv = $request->pinv;
            $daterange = $request->daterange;
            $supplier = $request->supplier;
            $rmcode = $request->itemcode;
            $cat = $request->cat;
            $subcat = $request->subcat;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("d-m-Y", strtotime(substr($daterange, 0,10)));
            $enddte = date("d-m-Y", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $Storedaterange = $request->daterange;
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);
            if(!empty($books)){
                $book = $books;
            }else{
                $book = "";
            }
            if(!empty($pinv)){
                $pinv = $pinv;
            }else{
                $pinv = "";
            }
            if(!empty($strtdte2)){
                $strtdte = $strtdte2;
            }else{
                $strtdte = "";
            }
            if(!empty($enddte2)){
                $enddte = $enddte2;
            }else{
                $enddte = "";
            }
            if(!empty($supplier)){
                $supplier = $supplier;
            }else{
                $supplier = "";
            }
            if(!empty($subcat)){
                $subcat = $subcat;
            }else{
                $subcat = "";
            }
            if(!empty($cat)){
                $cat = $cat;
            }else{
                $cat = "";
            }
            if(!empty($pinv)){
                $pinvarr = explode(" || ", $pinv);
                $pinv = $pinvarr[0]; $pidate = $pinvarr[1];
            }else{
                $pinv = ""; $pidate = "";
            }
            if(!empty($rmcode)){
                $rmcoarr = explode(" || ", $rmcode);
                $rmcode = $rmcoarr[0];
            }else{
                $rmcode = "";
            }

            $wizerp  = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            if(!empty($pinv)){
                $sql = "SELECT PID.SR_NO, SCM.CATEGORY_DESC, SM.COMPANY_NAME, PTM.PAYMENT_TERM_DESC, PIM.DOCUMENT_NO, PIM.GL_DATE, GM.GRN_NO, GM.GRN_DATE, IM.ITEM_CODE, IM.ITEM_DESC, PID.PRIMARY_QTY, (PID.AMOUNT/PID.PRIMARY_QTY) AS RATE, IBM.INV_BOOK_DESC,
                        SGM.STAX_GROUP_DESC, PID.STAX_AMOUNT, PID.AMOUNT, (PID.STAX_AMOUNT+PID.AMOUNT) AS TAmount, PID.PRO_EXP_TC_AMOUNT, ((PID.PRO_EXP_TC_AMOUNT/(PID.TC_AMOUNT+PID.STAX_AMOUNT))*100) AS PRO_EXP,
                        (W1.SEGMENT_VALUE || '-' || W2.SEGMENT_VALUE || '-' || W3.SEGMENT_VALUE || '-' || W4.SEGMENT_VALUE || '-' || W5.SEGMENT_VALUE || '-' || W6.SEGMENT_VALUE || '-' || W7.SEGMENT_VALUE) AS CAT_CODE,
                        (W1.SEGMENT_VALUE_DESC || '-' || W2.SEGMENT_VALUE_DESC || '-' || W3.SEGMENT_VALUE_DESC || '-' || W4.SEGMENT_VALUE_DESC || '-' || W5.SEGMENT_VALUE_DESC || '-' || W6.SEGMENT_VALUE_DESC || '-' || W7.SEGMENT_VALUE_DESC) AS CAT_DESC              
                        FROM PURCHASE_INVOICE_MT PIM                        
                        JOIN PURCHASE_INVOICE_DETAIL PID ON PID.PURCH_INVOICE_ID = PIM.PURCH_INVOICE_ID
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = PIM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('$book','%')
                        JOIN SUPPLIER_MT SM ON SM.SUPPLIER_ID = PIM.SUPPPLIER_ID
                        JOIN SUPP_CATAGORY_MT SCM ON SCM.SUPP_CATAG_ID = SM.SUPP_CATAG_ID
                        JOIN PAYMENT_TERMS_MT PTM ON PTM.PAYMENT_TERM_ID = PIM.PAYMENT_TERM_ID
                        JOIN ITEMS_MT IM ON IM.ITEM_ID = PID.ITEM_ID AND IM.ITEM_CODE LIKE NVL('$rmcode','%')
                        LEFT JOIN STAX_GROUP_MT SGM ON SGM.STAX_GROUP_ID = PID.STAX_GROUP_ID
                        JOIN GRN_DETAIL GD ON GD.GRN_DET_ID = PID.MATCH_WITH_ID
                        JOIN GRN_MT GM ON GM.GRN_ID = GD.GRN_ID
                        JOIN ITEMS_CATEGORY IC ON IC.ITEM_ID = IM.ITEM_ID
                        JOIN CODE_COMBINATIONS CC ON CC.CODE_COMBINATION_ID = IC.CODE_COMBINATION_ID
                        JOIN WIZ_SEGMENT01 W1 ON W1.SEGMENT_ID = CC.SEGMENT_ID01 AND W1.STRUCTURE_ID = CC.STRUCTURE_ID AND W1.SEGMENT_VALUE_DESC LIKE NVL('$cat','%')
                        JOIN WIZ_SEGMENT02 W2 ON W2.SEGMENT_ID = CC.SEGMENT_ID02 AND W2.STRUCTURE_ID = CC.STRUCTURE_ID AND W2.SEGMENT_VALUE_DESC LIKE NVL('$subcat','%')
                        JOIN WIZ_SEGMENT03 W3 ON W3.SEGMENT_ID = CC.SEGMENT_ID03 AND W3.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT04 W4 ON W4.SEGMENT_ID = CC.SEGMENT_ID04 AND W4.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT05 W5 ON W5.SEGMENT_ID = CC.SEGMENT_ID05 AND W5.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT06 W6 ON W6.SEGMENT_ID = CC.SEGMENT_ID06 AND W6.STRUCTURE_ID = CC.STRUCTURE_ID
                        LEFT JOIN WIZ_SEGMENT07 W7 ON W7.SEGMENT_ID = CC.SEGMENT_ID07 AND W7.STRUCTURE_ID = CC.STRUCTURE_ID                        
                        WHERE PIM.DOCUMENT_NO = '$pinv' AND TO_CHAR(PIM.GL_DATE, 'dd-MON-yy') = '$pidate'                        
                        ORDER BY SM.COMPANY_NAME, PIM.DOCUMENT_NO, PIM.GL_DATE DESC";
            } 
            else{
                $sql = "SELECT PID.SR_NO, SCM.CATEGORY_DESC, SM.COMPANY_NAME, PTM.PAYMENT_TERM_DESC, PIM.DOCUMENT_NO, PIM.GL_DATE, GM.GRN_NO, GM.GRN_DATE, IM.ITEM_CODE, IM.ITEM_DESC, PID.PRIMARY_QTY, (PID.AMOUNT/PID.PRIMARY_QTY) AS RATE, IBM.INV_BOOK_DESC,
                        SGM.STAX_GROUP_DESC, PID.STAX_AMOUNT, PID.AMOUNT, (PID.STAX_AMOUNT+PID.AMOUNT) AS TAmount, PID.PRO_EXP_TC_AMOUNT, ((PID.PRO_EXP_TC_AMOUNT/(PID.TC_AMOUNT+PID.STAX_AMOUNT))*100) AS PRO_EXP,
                        (W1.SEGMENT_VALUE || '-' || W2.SEGMENT_VALUE || '-' || W3.SEGMENT_VALUE || '-' || W4.SEGMENT_VALUE || '-' || W5.SEGMENT_VALUE || '-' || W6.SEGMENT_VALUE || '-' || W7.SEGMENT_VALUE) AS CAT_CODE,
                        (W1.SEGMENT_VALUE_DESC || '-' || W2.SEGMENT_VALUE_DESC || '-' || W3.SEGMENT_VALUE_DESC || '-' || W4.SEGMENT_VALUE_DESC || '-' || W5.SEGMENT_VALUE_DESC || '-' || W6.SEGMENT_VALUE_DESC || '-' || W7.SEGMENT_VALUE_DESC) AS CAT_DESC
                        FROM PURCHASE_INVOICE_MT PIM
                        JOIN PURCHASE_INVOICE_DETAIL PID ON PID.PURCH_INVOICE_ID = PIM.PURCH_INVOICE_ID
                        JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = PIM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('$book','%')
                        JOIN SUPPLIER_MT SM ON SM.SUPPLIER_ID = PIM.SUPPPLIER_ID
                        JOIN SUPP_CATAGORY_MT SCM ON SCM.SUPP_CATAG_ID = SM.SUPP_CATAG_ID
                        JOIN PAYMENT_TERMS_MT PTM ON PTM.PAYMENT_TERM_ID = PIM.PAYMENT_TERM_ID
                        JOIN ITEMS_MT IM ON IM.ITEM_ID = PID.ITEM_ID AND IM.ITEM_CODE LIKE NVL('$rmcode','%')
                        LEFT JOIN STAX_GROUP_MT SGM ON SGM.STAX_GROUP_ID = PID.STAX_GROUP_ID
                        JOIN GRN_DETAIL GD ON GD.GRN_DET_ID = PID.MATCH_WITH_ID
                        JOIN GRN_MT GM ON GM.GRN_ID = GD.GRN_ID
                        JOIN ITEMS_CATEGORY IC ON IC.ITEM_ID = IM.ITEM_ID
                        JOIN CODE_COMBINATIONS CC ON CC.CODE_COMBINATION_ID = IC.CODE_COMBINATION_ID
                        JOIN WIZ_SEGMENT01 W1 ON W1.SEGMENT_ID = CC.SEGMENT_ID01 AND W1.STRUCTURE_ID = CC.STRUCTURE_ID AND W1.SEGMENT_VALUE_DESC LIKE NVL('$cat','%')
                        JOIN WIZ_SEGMENT02 W2 ON W2.SEGMENT_ID = CC.SEGMENT_ID02 AND W2.STRUCTURE_ID = CC.STRUCTURE_ID AND W2.SEGMENT_VALUE_DESC LIKE NVL('$subcat','%')
                        JOIN WIZ_SEGMENT03 W3 ON W3.SEGMENT_ID = CC.SEGMENT_ID03 AND W3.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT04 W4 ON W4.SEGMENT_ID = CC.SEGMENT_ID04 AND W4.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT05 W5 ON W5.SEGMENT_ID = CC.SEGMENT_ID05 AND W5.STRUCTURE_ID = CC.STRUCTURE_ID
                        JOIN WIZ_SEGMENT06 W6 ON W6.SEGMENT_ID = CC.SEGMENT_ID06 AND W6.STRUCTURE_ID = CC.STRUCTURE_ID
                        LEFT JOIN WIZ_SEGMENT07 W7 ON W7.SEGMENT_ID = CC.SEGMENT_ID07 AND W7.STRUCTURE_ID = CC.STRUCTURE_ID                        
                        WHERE PIM.PURCH_INVOICE_DATE BETWEEN '$strtdte2' AND '$enddte2'                        
                        ORDER BY SM.COMPANY_NAME, PIM.DOCUMENT_NO, PIM.GL_DATE DESC";
            }
            $result11 = oci_parse($conn,$sql);
            oci_execute($result11);
            while($row = oci_fetch_array($result11,  OCI_ASSOC+OCI_RETURN_NULLS)){
                if(!empty($row["STAX_TC_AMOUNT"])){
                    $total_amount = $row["STAX_TC_AMOUNT"] + $row["AMOUNT"];
                } 
                else{
                    $total_amount = $row["AMOUNT"];
                }
                $sum_qty = $sum_qty + $row["PRIMARY_QTY"];
                $sum_amount = $sum_amount + $row["AMOUNT"];
                $sum_t_amount = $sum_t_amount + $total_amount;
                
                if($row["PRIMARY_QTY"] != 0){
                    $rate = $total_amount / $row["PRIMARY_QTY"];
                } 
                else{
                    $rate = 0;
                }

                $data[] = array(
                    'data' => $row,
                    'rate' => $rate,
                    'sum_qty' => $sum_qty,
                    'total_amount' => $total_amount,
                    'sum_amount' => $sum_amount,
                    'sum_t_amount' => $sum_t_amount,
                );
            }

            $strtdte2 = date("m/d/Y", strtotime(substr($daterange, 0,10)));
            $strtdte3 = date("m/d/Y", strtotime(substr($daterange, 10)));
            $strtdte2a = date("m/d/Y", strtotime(substr($daterange, 0,10)));
            $strtdte3a = date("m/d/Y", strtotime(substr($daterange, 10)));

            $daterangeVal = wordwrap($daterange , 10 , ' ' , true );
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql3 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_BOOK_DESC LIKE 'Purchase Inv%' ";
            $result3 = oci_parse($conn, $sql3);
            oci_execute($result3);
            while($row3 = oci_fetch_array($result3,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $bookData[] = $row3["INV_BOOK_DESC"];
            }
            $sql4 = "SELECT W1.SEGMENT_VALUE_DESC FROM WIZ_SEGMENT01 W1 ORDER BY W1.SEGMENT_VALUE_DESC";
            $result4 = oci_parse($conn, $sql4);
            oci_execute($result4);
            while($row4 = oci_fetch_array($result4,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $categoryData[] = $row4["SEGMENT_VALUE_DESC"];
            }
            $sql5 = "SELECT W2.SEGMENT_VALUE_DESC FROM WIZ_SEGMENT02 W2 ORDER BY W2.SEGMENT_VALUE_DESC";
            $result5 = oci_parse($conn, $sql5);
            oci_execute($result5);
            while($row5 = oci_fetch_array($result5,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $subCategoryData[] = $row5["SEGMENT_VALUE_DESC"];
            }

            $sessionData = [
                'book' => $request->book,
                'supplier' => $request->supplier,
                'subCategory' => $request->subCategory,
                'category' => $request->category,
                'pinv' => $request->pinv,
                'itemcode' => $request->itemcode,
                'strtdte2a' => $strtdte2a,
                'strtdte3a' => $strtdte3a,
                'Storestart' => date("d/m/Y", strtotime(substr($Storedaterange, 0,10))),
                'Storeend' => date("d/m/Y", strtotime(substr($Storedaterange, -10))),
                'Storestart1' => date("d-M-Y", strtotime(substr($Storedaterange, 0,10))),
                'Storeend2' => date("d-M-Y", strtotime(substr($Storedaterange, -10))),
            ];

            return view('report.purchaseinvoice')->with([
                "data" => $data, "Permission" => 1, "sessionData" => $sessionData, "i" => 1,
                "book" => $bookData,
                "category" => $categoryData,
                "subCategory" => $subCategoryData,
                'sum_qty' => $sum_qty,
                'total_amount' => $total_amount,
                'sum_amount' => $sum_amount,
                'sum_t_amount' => $sum_t_amount,
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

    public function ItemPurchase(Request $request)
    {
        try{
            $book = array();
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql3 = "SELECT IBM.INV_BOOK_DESC FROM INV_BOOKS_MT IBM WHERE IBM.INV_DOC_TYPE_ID = 3";
            $result3 = oci_parse($conn, $sql3);
            oci_execute($result3);
            while($row3 = oci_fetch_array($result3,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $book[] = $row3["INV_BOOK_DESC"];
            }
            return view('report.itempurchase')->with([
                "Permission" => 0,
                "book" => $book, 
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

    public function ItemPurchaseDownload(Request $request)
    {
        try{
            date_default_timezone_set("Asia/karachi");
            $date = date("d-m-Y");
            $rate2 = 0;
            $tcheck = 0;
            $data = array();
            $bookData = array();
            $book = $request->book;
            $thedate = $request->thedate;
            $rmcodef = $request->rmcodef;
            $daterange = $request->daterange;
            $supplier = $request->supplier;
            $ostatus = $request->status;
            $purchaseorder = $request->purchaseorder;
            $rmcodet = $request->rmcodet;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("d-m-Y", strtotime(substr($daterange, 0,10)));
            $enddte = date("d-m-Y", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $Storedaterange = $request->daterange;
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);
            if(!empty($book)){
                $book = $book;
            }else{
                $book = "";
            }
            if(!empty($strtdte2)){
                $strtdte = $strtdte2;
            }else{
                $strtdte = "";
            }
            if(!empty($enddte2)){
                $enddte = $enddte2;
            }else{
                $enddte = "";
            }
            if(!empty($supplier)){
                $supplier = $supplier;
            }else{
                $supplier = "";
            }
            if(!empty($thedate)){
                $thedate = $thedate;
            }else{
                $thedate = "";
            }
            if(!empty($rmcodef)){
                $rmcoarrf = explode(" || ",mysqli_real_escape_string($link,$rmcodef));
                $rmcodef = $rmcoarrf[2];
            }else{
                $rmcodef = "";
            }
            if(!empty($rmcodet)){
                $rmcoarrt = explode(" || ",mysqli_real_escape_string($link,$rmcodet));
                $rmcodet = $rmcoarrt[2];
            }else{
                $rmcodef = "";
            }
            if(!empty($purchaseorder)){
                $purchaseorder = explode(" || ",mysqli_real_escape_string($link,$purchaseorder));
                $pino = $purchaseorder[0];
            }else{
                $pino = "";
            }
            if(!empty($purchaseorder)){
                $purchaseorder = explode(" || ",mysqli_real_escape_string($link,$purchaseorder));
                $pidate2 = explode('-', $purchaseorder[1]);
                $pidate = $pidate2[0]."-".$pidate2[1]."-20".$pidate2[2];
            }else{
                $pidate = "";
            }
            if(!empty($ostatus)){
                $ostatus = $ostatus;
            }else{
                $ostatus = "";
            }

            $wizerp  = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            if(!empty($purchaseorder)){
                $tcheck = 1;
                $sql = "SELECT DISTINCT IM.ITEM_CODE, IM.ITEM_DESC, UOM.UOM_DESC, GM.GRN_NO, GM.GRN_DATE, POM.ORDER_NO AS PO_NO, POM.ORDER_DATE AS PO_DATE, POD.PRIMARY_QTY AS PO_QTY,
                            GD.PRIMARY_QTY AS RECEIVED_QTY, GD.PRIMARY_ACCEPTED_QTY AS ACCEPTED_QTY, (GD.PRIMARY_QTY-GD.PRIMARY_ACCEPTED_QTY) AS REJECTED_QTY,
                            PID.AMOUNT, (PID.AMOUNT/PID.PRIMARY_QTY) AS UNIT_PRICE, PID.STAX_AMOUNT, (PID.STAX_AMOUNT+PID.AMOUNT) AS STAX_INCLU_AMOUNT, GD.REMARKS                            
                        FROM PURCHASE_ORDER_MT POM
                        LEFT JOIN PURCHASE_ORDER_DET POD ON POD.ORDER_ID = POM.ORDER_ID
                        LEFT JOIN GRN_DETAIL GD ON GD.MATCH_WITH_ID = POD.PO_DET_ID
                        LEFT JOIN GRN_MT GM ON GM.GRN_ID = GD.GRN_ID
                        LEFT JOIN ITEMS_MT IM ON POD.ITEM_ID = IM.ITEM_ID
                        LEFT JOIN WIZ_UOM_MT UOM ON UOM.UOM_ID = GD.UOM_ID
                        LEFT JOIN PURCHASE_INVOICE_DETAIL PID ON PID.MATCH_WITH_ID = GD.GRN_DET_ID
                        LEFT JOIN SUPPLIER_MT SM ON SM.SUPPLIER_ID = POM.SUPPLIER_ID
                        LEFT JOIN WIZ_PO_STATUS_MT WPSM ON WPSM.PO_STATUS_ID = POM.PO_STATUS_ID AND WPSM.PO_STATUS_DESC LIKE NVL('$postsid','%')
                            LEFT JOIN WIZ_PO_STATUS_MT WPSM ON WPSM.PO_STATUS_ID = POM.PO_STATUS_ID AND WPSM.PO_STATUS_DESC LIKE NVL('$postsid','%')                        
                        LEFT JOIN WIZ_PO_STATUS_MT WPSM ON WPSM.PO_STATUS_ID = POM.PO_STATUS_ID AND WPSM.PO_STATUS_DESC LIKE NVL('$postsid','%')
                        WHERE POM.ORDER_NO = '$pino' AND POM.ORDER_DATE = '$pidate'
                        ORDER BY IM.ITEM_CODE";
            } 
            else{
                if(empty($rmcodet)){
                    if($thedate == "po"){
                        $sql = "SELECT DISTINCT IM.ITEM_CODE, IM.ITEM_DESC, UOM.UOM_DESC, GM.GRN_NO, GM.GRN_DATE, POM.ORDER_NO AS PO_NO, POM.ORDER_DATE AS PO_DATE, SUM(POD.PRIMARY_QTY) AS PO_QTY,
                                    GD.PRIMARY_QTY AS RECEIVED_QTY, GD.PRIMARY_ACCEPTED_QTY AS ACCEPTED_QTY, (GD.PRIMARY_QTY-GD.PRIMARY_ACCEPTED_QTY) AS REJECTED_QTY,
                                    PID.AMOUNT, (PID.AMOUNT/PID.PRIMARY_QTY) AS UNIT_PRICE, PID.STAX_AMOUNT, (PID.STAX_AMOUNT+PID.AMOUNT) AS STAX_INCLU_AMOUNT, GD.REMARKS
                        
                                FROM PURCHASE_ORDER_MT POM
                            
                                JOIN PURCHASE_ORDER_DET POD ON POD.ORDER_ID = POM.ORDER_ID AND POM.ORDER_DATE BETWEEN '$strtdte2' AND '$enddte2'
                                JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = POM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('$book','%')
                                LEFT JOIN GRN_DETAIL GD ON GD.MATCH_WITH_ID = POD.PO_DET_ID
                                LEFT JOIN GRN_MT GM ON GM.GRN_ID = GD.GRN_ID
                                JOIN ITEMS_MT IM ON POD.ITEM_ID = IM.ITEM_ID AND IM.ITEM_ID  LIKE NVL('$rmcodef','%')
                                LEFT JOIN WIZ_UOM_MT UOM ON UOM.UOM_ID = GD.UOM_ID
                                LEFT JOIN PURCHASE_INVOICE_DETAIL PID ON PID.MATCH_WITH_ID = GD.GRN_DET_ID
                                JOIN SUPPLIER_MT SM ON SM.SUPPLIER_ID = POM.SUPPLIER_ID
                            
                                WHERE SM.COMPANY_NAME LIKE NVL('$supplier','%')
                            
                                GROUP BY IM.ITEM_CODE, IM.ITEM_DESC, UOM.UOM_DESC, GM.GRN_NO, GM.GRN_DATE, POM.ORDER_NO, POM.ORDER_DATE,
                                                GD.PRIMARY_QTY, GD.PRIMARY_ACCEPTED_QTY, (GD.PRIMARY_QTY-GD.PRIMARY_ACCEPTED_QTY),
                                                PID.AMOUNT, (PID.AMOUNT/PID.PRIMARY_QTY), PID.STAX_AMOUNT, PID.STAX_AMOUNT+PID.AMOUNT, GD.REMARKS
                                
                                ORDER BY POM.ORDER_NO";
                    } 
                    else{ 
                        $sql = "SELECT DISTINCT IM.ITEM_CODE, IM.ITEM_DESC, UOM.UOM_DESC, GM.GRN_NO, GM.GRN_DATE, POM.ORDER_NO AS PO_NO, POM.ORDER_DATE AS PO_DATE, POD.PRIMARY_QTY AS PO_QTY,
                                    GD.PRIMARY_QTY AS RECEIVED_QTY, GD.PRIMARY_ACCEPTED_QTY AS ACCEPTED_QTY, (GD.PRIMARY_QTY-GD.PRIMARY_ACCEPTED_QTY) AS REJECTED_QTY,
                                    PID.AMOUNT, (PID.AMOUNT/PID.PRIMARY_QTY) AS UNIT_PRICE, PID.STAX_AMOUNT, (PID.STAX_AMOUNT+PID.AMOUNT) AS STAX_INCLU_AMOUNT, GD.REMARKS
                                    
                                FROM PURCHASE_ORDER_MT POM

                                JOIN PURCHASE_ORDER_DET POD ON POD.ORDER_ID = POM.ORDER_ID
                                JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = POM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('$book','%')
                                LEFT JOIN GRN_DETAIL GD ON GD.MATCH_WITH_ID = POD.PO_DET_ID
                                JOIN GRN_MT GM ON GM.GRN_ID = GD.GRN_ID AND GM.GRN_DATE BETWEEN '$strtdte2' AND '$enddte2'
                                JOIN ITEMS_MT IM ON POD.ITEM_ID = IM.ITEM_ID AND IM.ITEM_ID  LIKE NVL('$rmcodef','%')
                                JOIN WIZ_UOM_MT UOM ON UOM.UOM_ID = GD.UOM_ID
                                LEFT JOIN PURCHASE_INVOICE_DETAIL PID ON PID.MATCH_WITH_ID = GD.GRN_DET_ID
                                JOIN SUPPLIER_MT SM ON SM.SUPPLIER_ID = POM.SUPPLIER_ID

                                WHERE SM.COMPANY_NAME LIKE NVL('$supplier','%')

                                ORDER BY IM.ITEM_CODE";
                    }
                } 
                else{
                    $sql = "SELECT DISTINCT IM.ITEM_CODE, IM.ITEM_DESC, UOM.UOM_DESC, GM.GRN_NO, GM.GRN_DATE, POM.ORDER_NO AS PO_NO, POM.ORDER_DATE AS PO_DATE, POD.PRIMARY_QTY AS PO_QTY,
                                GD.PRIMARY_QTY AS RECEIVED_QTY, GD.PRIMARY_ACCEPTED_QTY AS ACCEPTED_QTY, (GD.PRIMARY_QTY-GD.PRIMARY_ACCEPTED_QTY) AS REJECTED_QTY,
                                PID.AMOUNT, (PID.AMOUNT/PID.PRIMARY_QTY) AS UNIT_PRICE, PID.STAX_AMOUNT, (PID.STAX_AMOUNT+PID.AMOUNT) AS STAX_INCLU_AMOUNT, GD.REMARKS
                                
                            FROM PURCHASE_ORDER_MT POM
                        
                            JOIN PURCHASE_ORDER_DET POD ON POD.ORDER_ID = POM.ORDER_ID
                            JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = POM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('$book','%')
                            JOIN GRN_DETAIL GD ON GD.MATCH_WITH_ID = POD.PO_DET_ID
                            JOIN GRN_MT GM ON GM.GRN_ID = GD.GRN_ID AND GM.GRN_DATE BETWEEN '$strtdte2' AND '$enddte2'
                            JOIN ITEMS_MT IM ON POD.ITEM_ID = IM.ITEM_ID AND IM.ITEM_ID BETWEEN '$rmcodef' AND '$rmcodet'
                            JOIN WIZ_UOM_MT UOM ON UOM.UOM_ID = GD.UOM_ID
                            LEFT JOIN PURCHASE_INVOICE_DETAIL PID ON PID.MATCH_WITH_ID = GD.GRN_DET_ID
                            JOIN SUPPLIER_MT SM ON SM.SUPPLIER_ID = POM.SUPPLIER_ID
                        
                            WHERE SM.COMPANY_NAME LIKE NVL('$supplier','%')
                        
                            ORDER BY IM.ITEM_CODE";
                }
            }
            $result11 = oci_parse($conn,$sql);
            oci_execute($result11);
            while($row = oci_fetch_array($result11,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $data[] = $row;
                $lineData[] = array(
                    'Item Code' => $row["ITEM_CODE"],
                    'Item Desc' => $row["ITEM_DESC"],
                    'UOM' => $row["UOM_DESC"],
                    'PO No' => $row["PO_NO"]." ".$row["PO_DATE"],
                    'GRN No' => $row["GRN_NO"]." || ".$row["GRN_DATE"],
                    'PO Qty' => $row["PO_QTY"],
                    'Received' => $row["RECEIVED_QTY"],
                    'Rejected' => $row["REJECTED_QTY"],
                    'Accepted' => $row["ACCEPTED_QTY"],
                    'Pending' => $row["PO_QTY"] - $row["ACCEPTED_QTY"],
                    'Amount' => number_format($row["AMOUNT"],2),
                    'Unit Price' => number_format($row["UNIT_PRICE"],2),
                    'STAX Amount' => number_format($row["STAX_AMOUNT"],2),
                    'Amt Inclu STAX' => number_format($row["STAX_INCLU_AMOUNT"],2),
                );
            }
            return Excel::download(new ItemPurchase($lineData), 'Item Purchasing Movement Report '.$date.'.xlsx');
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function ItemPurchaseDisplay(Request $request)
    {       
        try{
            $rate2 = 0;
            $tcheck = 0;
            $data = array();
            $bookData = array();
            $book = $request->book;
            $thedate = $request->thedate;
            $rmcodef = $request->rmcodef;
            $daterange = $request->daterange;
            $supplier = $request->supplier;
            $ostatus = $request->status;
            $purchaseorder = $request->purchaseorder;
            $rmcodet = $request->rmcodet;
            $daterange = str_replace(" - ", "", $request['daterange']);
            $strtdte = date("d-m-Y", strtotime(substr($daterange, 0,10)));
            $enddte = date("d-m-Y", strtotime(substr($daterange, 10)));
            $month_name = (date("F",strtotime($strtdte)));
            $month_name2 = (date("F",strtotime($enddte)));  
            $Storedaterange = $request->daterange;
            $strtdte2 = substr($strtdte, 0, 3).''.$month_name.''.substr($strtdte, 5, 5);
            $enddte2 = substr($enddte, 0, 3).''.$month_name2.''.substr($enddte, 5, 5);
            if(!empty($book)){
                $book = $book;
            }else{
                $book = "";
            }
            if(!empty($strtdte2)){
                $strtdte = $strtdte2;
            }else{
                $strtdte = "";
            }
            if(!empty($enddte2)){
                $enddte = $enddte2;
            }else{
                $enddte = "";
            }
            if(!empty($supplier)){
                $supplier = $supplier;
            }else{
                $supplier = "";
            }
            if(!empty($thedate)){
                $thedate = $thedate;
            }else{
                $thedate = "";
            }
            if(!empty($rmcodef)){
                $rmcoarrf = explode(' || ', $rmcodef);
                $rmcodef = $rmcoarrf[2];
            }else{
                $rmcodef = "";
            }
            if(!empty($rmcodet)){
                $rmcoarrt = explode(' || ', $rmcodet);
                $rmcodet = $rmcoarrt[2];
            }else{
                $rmcodet = "";
            }
            if(!empty($purchaseorder)){
                $purchaseorder = explode(' || ', $purchaseorder);
                $pino = $purchaseorder[0];
            }else{
                $pino = "";
            }
            if(!empty($purchaseorder)){
                $purchaseorder1 = explode(' || ', $request->purchaseorder);
                $pidate2 = explode('-', $purchaseorder1[1]);
                $pidate = $pidate2[0]."-".$pidate2[1]."-20".$pidate2[2];
            }else{
                $pidate = "";
            }
            if(!empty($ostatus)){
                $postsid = $ostatus;
            }else{
                $postsid = "";
            }

            $wizerp  = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            if(!empty($purchaseorder)){
                $tcheck = 1;
                $sql = "SELECT DISTINCT IM.ITEM_CODE, IM.ITEM_DESC, UOM.UOM_DESC, GM.GRN_NO, GM.GRN_DATE, POM.ORDER_NO AS PO_NO, POM.ORDER_DATE AS PO_DATE, POD.PRIMARY_QTY AS PO_QTY,
                            GD.PRIMARY_QTY AS RECEIVED_QTY, GD.PRIMARY_ACCEPTED_QTY AS ACCEPTED_QTY, (GD.PRIMARY_QTY-GD.PRIMARY_ACCEPTED_QTY) AS REJECTED_QTY,
                            PID.AMOUNT, (PID.AMOUNT/PID.PRIMARY_QTY) AS UNIT_PRICE, PID.STAX_AMOUNT, (PID.STAX_AMOUNT+PID.AMOUNT) AS STAX_INCLU_AMOUNT, GD.REMARKS                            
                        FROM PURCHASE_ORDER_MT POM
                        LEFT JOIN PURCHASE_ORDER_DET POD ON POD.ORDER_ID = POM.ORDER_ID
                        LEFT JOIN GRN_DETAIL GD ON GD.MATCH_WITH_ID = POD.PO_DET_ID
                        LEFT JOIN GRN_MT GM ON GM.GRN_ID = GD.GRN_ID
                        LEFT JOIN ITEMS_MT IM ON POD.ITEM_ID = IM.ITEM_ID
                        LEFT JOIN WIZ_UOM_MT UOM ON UOM.UOM_ID = GD.UOM_ID
                        LEFT JOIN PURCHASE_INVOICE_DETAIL PID ON PID.MATCH_WITH_ID = GD.GRN_DET_ID
                        LEFT JOIN SUPPLIER_MT SM ON SM.SUPPLIER_ID = POM.SUPPLIER_ID
                        LEFT JOIN WIZ_PO_STATUS_MT WPSM ON WPSM.PO_STATUS_ID = POM.PO_STATUS_ID AND WPSM.PO_STATUS_DESC LIKE NVL('$postsid','%')
                            LEFT JOIN WIZ_PO_STATUS_MT WPSM ON WPSM.PO_STATUS_ID = POM.PO_STATUS_ID AND WPSM.PO_STATUS_DESC LIKE NVL('$postsid','%')                        
                        LEFT JOIN WIZ_PO_STATUS_MT WPSM ON WPSM.PO_STATUS_ID = POM.PO_STATUS_ID AND WPSM.PO_STATUS_DESC LIKE NVL('$postsid','%')
                        WHERE POM.ORDER_NO = '$pino' AND POM.ORDER_DATE = '$pidate'
                        ORDER BY IM.ITEM_CODE";
            } 
            else{
                if(empty($rmcodet)){
                    if($thedate == "po"){
                        $sql = "SELECT DISTINCT IM.ITEM_CODE, IM.ITEM_DESC, UOM.UOM_DESC, GM.GRN_NO, GM.GRN_DATE, POM.ORDER_NO AS PO_NO, POM.ORDER_DATE AS PO_DATE, SUM(POD.PRIMARY_QTY) AS PO_QTY,
                                    GD.PRIMARY_QTY AS RECEIVED_QTY, GD.PRIMARY_ACCEPTED_QTY AS ACCEPTED_QTY, (GD.PRIMARY_QTY-GD.PRIMARY_ACCEPTED_QTY) AS REJECTED_QTY,
                                    PID.AMOUNT, (PID.AMOUNT/PID.PRIMARY_QTY) AS UNIT_PRICE, PID.STAX_AMOUNT, (PID.STAX_AMOUNT+PID.AMOUNT) AS STAX_INCLU_AMOUNT, GD.REMARKS
                        
                                FROM PURCHASE_ORDER_MT POM
                            
                                JOIN PURCHASE_ORDER_DET POD ON POD.ORDER_ID = POM.ORDER_ID AND POM.ORDER_DATE BETWEEN '$strtdte2' AND '$enddte2'
                                JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = POM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('$book','%')
                                LEFT JOIN GRN_DETAIL GD ON GD.MATCH_WITH_ID = POD.PO_DET_ID
                                LEFT JOIN GRN_MT GM ON GM.GRN_ID = GD.GRN_ID
                                JOIN ITEMS_MT IM ON POD.ITEM_ID = IM.ITEM_ID AND IM.ITEM_ID  LIKE NVL('$rmcodef','%')
                                LEFT JOIN WIZ_UOM_MT UOM ON UOM.UOM_ID = GD.UOM_ID
                                LEFT JOIN PURCHASE_INVOICE_DETAIL PID ON PID.MATCH_WITH_ID = GD.GRN_DET_ID
                                JOIN SUPPLIER_MT SM ON SM.SUPPLIER_ID = POM.SUPPLIER_ID
                            
                                WHERE SM.COMPANY_NAME LIKE NVL('$supplier','%')
                            
                                GROUP BY IM.ITEM_CODE, IM.ITEM_DESC, UOM.UOM_DESC, GM.GRN_NO, GM.GRN_DATE, POM.ORDER_NO, POM.ORDER_DATE,
                                                GD.PRIMARY_QTY, GD.PRIMARY_ACCEPTED_QTY, (GD.PRIMARY_QTY-GD.PRIMARY_ACCEPTED_QTY),
                                                PID.AMOUNT, (PID.AMOUNT/PID.PRIMARY_QTY), PID.STAX_AMOUNT, PID.STAX_AMOUNT+PID.AMOUNT, GD.REMARKS
                                
                                ORDER BY POM.ORDER_NO";
                    } 
                    else{ 
                        $sql = "SELECT DISTINCT IM.ITEM_CODE, IM.ITEM_DESC, UOM.UOM_DESC, GM.GRN_NO, GM.GRN_DATE, POM.ORDER_NO AS PO_NO, POM.ORDER_DATE AS PO_DATE, POD.PRIMARY_QTY AS PO_QTY,
                                    GD.PRIMARY_QTY AS RECEIVED_QTY, GD.PRIMARY_ACCEPTED_QTY AS ACCEPTED_QTY, (GD.PRIMARY_QTY-GD.PRIMARY_ACCEPTED_QTY) AS REJECTED_QTY,
                                    PID.AMOUNT, (PID.AMOUNT/PID.PRIMARY_QTY) AS UNIT_PRICE, PID.STAX_AMOUNT, (PID.STAX_AMOUNT+PID.AMOUNT) AS STAX_INCLU_AMOUNT, GD.REMARKS
                                    
                                FROM PURCHASE_ORDER_MT POM

                                JOIN PURCHASE_ORDER_DET POD ON POD.ORDER_ID = POM.ORDER_ID
                                JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = POM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('$book','%')
                                LEFT JOIN GRN_DETAIL GD ON GD.MATCH_WITH_ID = POD.PO_DET_ID
                                JOIN GRN_MT GM ON GM.GRN_ID = GD.GRN_ID AND GM.GRN_DATE BETWEEN '$strtdte2' AND '$enddte2'
                                JOIN ITEMS_MT IM ON POD.ITEM_ID = IM.ITEM_ID AND IM.ITEM_ID  LIKE NVL('$rmcodef','%')
                                JOIN WIZ_UOM_MT UOM ON UOM.UOM_ID = GD.UOM_ID
                                LEFT JOIN PURCHASE_INVOICE_DETAIL PID ON PID.MATCH_WITH_ID = GD.GRN_DET_ID
                                JOIN SUPPLIER_MT SM ON SM.SUPPLIER_ID = POM.SUPPLIER_ID

                                WHERE SM.COMPANY_NAME LIKE NVL('$supplier','%')

                                ORDER BY IM.ITEM_CODE";
                    }
                } 
                else{
                    $sql = "SELECT DISTINCT IM.ITEM_CODE, IM.ITEM_DESC, UOM.UOM_DESC, GM.GRN_NO, GM.GRN_DATE, POM.ORDER_NO AS PO_NO, POM.ORDER_DATE AS PO_DATE, POD.PRIMARY_QTY AS PO_QTY,
                                GD.PRIMARY_QTY AS RECEIVED_QTY, GD.PRIMARY_ACCEPTED_QTY AS ACCEPTED_QTY, (GD.PRIMARY_QTY-GD.PRIMARY_ACCEPTED_QTY) AS REJECTED_QTY,
                                PID.AMOUNT, (PID.AMOUNT/PID.PRIMARY_QTY) AS UNIT_PRICE, PID.STAX_AMOUNT, (PID.STAX_AMOUNT+PID.AMOUNT) AS STAX_INCLU_AMOUNT, GD.REMARKS
                                
                            FROM PURCHASE_ORDER_MT POM
                        
                            JOIN PURCHASE_ORDER_DET POD ON POD.ORDER_ID = POM.ORDER_ID
                            JOIN INV_BOOKS_MT IBM ON IBM.INV_BOOK_ID = POM.INV_BOOK_ID AND IBM.INV_BOOK_DESC LIKE NVL('$book','%')
                            JOIN GRN_DETAIL GD ON GD.MATCH_WITH_ID = POD.PO_DET_ID
                            JOIN GRN_MT GM ON GM.GRN_ID = GD.GRN_ID AND GM.GRN_DATE BETWEEN '$strtdte2' AND '$enddte2'
                            JOIN ITEMS_MT IM ON POD.ITEM_ID = IM.ITEM_ID AND IM.ITEM_ID BETWEEN '$rmcodef' AND '$rmcodet'
                            JOIN WIZ_UOM_MT UOM ON UOM.UOM_ID = GD.UOM_ID
                            LEFT JOIN PURCHASE_INVOICE_DETAIL PID ON PID.MATCH_WITH_ID = GD.GRN_DET_ID
                            JOIN SUPPLIER_MT SM ON SM.SUPPLIER_ID = POM.SUPPLIER_ID
                        
                            WHERE SM.COMPANY_NAME LIKE NVL('$supplier','%')
                        
                            ORDER BY IM.ITEM_CODE";
                }
            }
            $result11 = oci_parse($conn,$sql);
            oci_execute($result11);
            while($row = oci_fetch_array($result11,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $data[] = $row;
            }

            $strtdte2 = date("m/d/Y", strtotime(substr($daterange, 0,10)));
            $strtdte3 = date("m/d/Y", strtotime(substr($daterange, 10)));
            $strtdte2a = date("m/d/Y", strtotime(substr($daterange, 0,10)));
            $strtdte3a = date("m/d/Y", strtotime(substr($daterange, 10)));

            $daterangeVal = wordwrap($daterange , 10 , ' ' , true );
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $conn = oci_connect("onsole","s",$wizerp);
            $sql3 = "SELECT IBM.INV_BOOK_DESC FROM INV_BOOKS_MT IBM WHERE IBM.INV_DOC_TYPE_ID = 3";
            $result3 = oci_parse($conn, $sql3);
            oci_execute($result3);
            while($row3 = oci_fetch_array($result3,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $bookData[] = $row3["INV_BOOK_DESC"];
            }

            $sessionData = [
                'book' => $request->book,
                'thedate' => $request->thedate,
                'rmcodef' => $request->rmcodef,
                'supplier' => $request->supplier,
                'rmcodet' => $request->rmcodet,
                'ostatus' => $request->status,
                'purchaseorder' => $request->purchaseorder,
                'strtdte2a' => $strtdte2a,
                'strtdte3a' => $strtdte3a,
                'Storestart' => date("d/m/Y", strtotime(substr($Storedaterange, 0,10))),
                'Storeend' => date("d/m/Y", strtotime(substr($Storedaterange, -10))),
                'Storestart1' => date("d-M-Y", strtotime(substr($Storedaterange, 0,10))),
                'Storeend2' => date("d-M-Y", strtotime(substr($Storedaterange, -10))),
            ];

            return view('report.itempurchase')->with([
                "data" => $data, "Permission" => 1, "sessionData" => $sessionData, "i" => 1,
                "book" => $bookData, "tcheck" => $tcheck,
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

    public function RmCode(Request $request)
    {
        $RmCode = array();
        $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
        $conn = oci_connect("onsole","s",$wizerp);
        $sql = "SELECT IM.ITEM_ID, IM.ITEM_CODE, IM.ITEM_DESC FROM ITEMS_MT IM JOIN ITEMS_CATEGORY IC ON IC.ITEM_ID = IM.ITEM_ID WHERE IM.ITEM_CODE LIKE :inputcode OR IM.ITEM_DESC LIKE :inputcode OFFSET 0 ROWS FETCH NEXT 7 ROWS ONLY";
        $result= oci_parse($conn, $sql);
        $inputcode = '%'.strtoupper($request->get('search')).'%';
        oci_bind_by_name($result, ":inputcode", $inputcode);
        oci_execute($result);
        while($row=oci_fetch_array($result,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $RmCode[] = $row["ITEM_CODE"]." || ".$row["ITEM_DESC"];
        }
        return response()->json($RmCode);
    }

    public function ItemCode(Request $request)
    {
        $ItemCode = array();
        $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
        $conn = oci_connect("onsole","s",$wizerp);
        $sql = "SELECT IM.ITEM_ID, IM.ITEM_CODE, IM.ITEM_DESC FROM ITEMS_MT IM, ITEMS_CATEGORY IC WHERE IM.ITEM_CODE LIKE :inputcode AND IC.ITEM_ID = IM.ITEM_ID OFFSET 0 ROWS FETCH NEXT 7 ROWS ONLY";
        $result= oci_parse($conn, $sql);
        $inputcode = '%'.strtoupper($request->get('search')).'%';
        oci_bind_by_name($result, ":inputcode", $inputcode);
        oci_execute($result);
        while($row = oci_fetch_array($result,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $ItemCode[] = $row["ITEM_CODE"]." || ".$row["ITEM_DESC"]." || ".$row["ITEM_ID"];
        }
        return response()->json($ItemCode);
    }

    public function ItemCode2(Request $request)
    {
        $ItemCode = array();
        $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
        $conn = oci_connect("onsole","s",$wizerp);
        $sql = "SELECT IM.ITEM_ID, IM.ITEM_CODE, IM.ITEM_DESC FROM ITEMS_MT IM, ITEMS_CATEGORY IC WHERE IM.ITEM_CODE LIKE :inputcode OR IM.ITEM_DESC LIKE :inputcode AND IC.ITEM_ID = IM.ITEM_ID OFFSET 0 ROWS FETCH NEXT 7 ROWS ONLY";
        $result= oci_parse($conn, $sql);
        $inputcode = '%'.strtoupper($request->get('search')).'%';
        oci_bind_by_name($result, ":inputcode", $inputcode);
        oci_execute($result);
        while($row = oci_fetch_array($result,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $ItemCode[] = $row["ITEM_CODE"]." || ".$row["ITEM_DESC"]." || ".$row["ITEM_ID"];
        }
        return response()->json($ItemCode);
    }

    public function Sono(Request $request)
    {
        $Sono = array();
        $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
        $conn = oci_connect("onsole","s",$wizerp);
        $sql = "SELECT SOM.SALES_ORDER_NO, SOM.ORDER_DATE, CM.COMPANY_NAME FROM SALES_ORDER_MT SOM JOIN CUSTOMER_MT CM ON CM.CUSTOMER_ID = SOM.CUSTOMER_ID
                WHERE SOM.SALES_ORDER_NO LIKE :inputcode OR CM.COMPANY_NAME LIKE :inputcode ORDER BY SOM.SALES_ORDER_NO, SOM.ORDER_DATE DESC OFFSET 0 ROWS FETCH NEXT 10 ROWS ONLY";
        $result= oci_parse($conn, $sql);
        $inputcode = '%'.strtoupper($request->get('search')).'%';
        oci_bind_by_name($result, ":inputcode", $inputcode);
        oci_execute($result);
        while($row=oci_fetch_array($result,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $Sono[] = $row["SALES_ORDER_NO"] . " || " . $row["ORDER_DATE"] . " || " . $row["COMPANY_NAME"];
        }
        return response()->json($Sono);
    }

    public function Pono(Request $request)
    {
        $Pono = array();
        $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
        $conn = oci_connect("onsole","s",$wizerp);
        $sql = "SELECT POM.ORDER_NO, POM.ORDER_DATE FROM PURCHASE_ORDER_MT POM WHERE POM.ORDER_NO LIKE :inputcode ORDER BY POM.ORDER_NO, POM.ORDER_DATE DESC OFFSET 0 ROWS FETCH NEXT 7 ROWS ONLY";
        $result= oci_parse($conn, $sql);
        $inputcode = '%'.strtoupper($request->get('search')).'%';
        oci_bind_by_name($result, ":inputcode", $inputcode);
        oci_execute($result);
        while($row=oci_fetch_array($result,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $Pono[] = $row["ORDER_NO"] . " || " . $row["ORDER_DATE"];
        }
        return response()->json($Pono);
    }

    public function Supplier(Request $request)
    {
        $Supplier = array();
        $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
        $conn = oci_connect("onsole","s",$wizerp);
        $sql = "SELECT SM.COMPANY_NAME FROM SUPPLIER_MT SM WHERE SM.COMPANY_NAME LIKE :inputcode ORDER BY SM.COMPANY_NAME OFFSET 0 ROWS FETCH NEXT 7 ROWS ONLY";
        $result = oci_parse($conn, $sql);
        $inputcode = '%'.strtoupper($request->get('search')).'%';
        oci_bind_by_name($result, ":inputcode", $inputcode);
        oci_execute($result);
        while($row = oci_fetch_array($result,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $Supplier[] = $row["COMPANY_NAME"];
        }
        return response()->json($Supplier);
    }

    public function JobOrderNum(Request $request)
    {
        $JobOrder = array();
        $search = $request->get('search');
        $result = DB::table('job_sheet_order_mt')->where('Job_Id', 'like', '%'.$search.'%')->skip(0)->take(5)->get()->unique('Job_Id');
        foreach($result as $data){
            $JobOrder[] = $data->Job_Id . " || " . $data->Onsole_Art_No . " || " . $data->Department;
        }
        return response()->json($JobOrder);
    } 

    public function JobOrderNo(Request $request)
    {
        $JobOrderNo = array();
        $search = $request->get('search');
        $result = DB::table('job_sheet_order_mt')->where('Unique_Id', 'like', '%'.$search.'%')->skip(0)->take(5)->get()->unique('Unique_Id');
        foreach($result as $data){
            $JobOrderNo[] = $data->Unique_Id;
        }
        return response()->json($JobOrderNo);
    }
    
    public function JobOrderNums(Request $request)
    {
        $JobOrder = array();
        $search = $request->get('search');
        $result = DB::table('job_sheet_order_mt')->where('Job_Id', 'like', '%'.$search.'%')->skip(0)->take(5)->get()->unique('Job_Id');
        foreach($result as $data){
            $JobOrder[] = $data->Unique_Id . " || " . $data->Department;
        }
        return response()->json($JobOrder);
    }

    public function PurchaseOrderNo(Request $request)
    {
        $PurchaseOrderNo = array();
        $search = $request->get('search');
        $result = DB::table('job_sheet_order_mt')->where('Po_No', 'like', '%'.$search.'%')->skip(0)->take(5)->get()->unique('Po_No');
        foreach($result as $data){
            $PurchaseOrderNo[] = $data->Po_No;
        }
        return response()->json($PurchaseOrderNo);
    } 

    public function SalesOrderNo(Request $request)
    {
        $SalesOrderNo = array();
        $search = $request->get('search');
        $result = DB::table('job_sheet_order_mt')->where('So_No', 'like', '%'.$search.'%')->skip(0)->take(5)->get()->unique('So_No');
        foreach($result as $data){
            $SalesOrderNo[] = $data->So_No;
        }
        return response()->json($SalesOrderNo);
    } 

    public function ArticleNo(Request $request)
    {
        $ArticleNo = array();
        $search = $request->get('search');
        $result = DB::table('job_sheet_order_mt')->where('Onsole_Art_No', 'like', $search.'%')->skip(0)->take(5)->get()->unique('Onsole_Art_No');
        foreach($result as $data){
            $ArticleNo[] = $data->Onsole_Art_No;
        }
        return response()->json($ArticleNo);
    } 

    public function Artcode(Request $request)
    {
        $ArticleCode = array();
        $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
        $conn = oci_connect("onsole","s",$wizerp);
        $sql = "SELECT ART.SEGMENT_VALUE_DESC FROM WIZ_SEGMENT03 ART WHERE ART.STRUCTURE_ID = 26 AND ART.SEGMENT_VALUE_DESC LIKE :inputcode OFFSET 0 ROWS FETCH NEXT 7 ROWS ONLY";
        $result= oci_parse($conn, $sql);
        $inputcode = '%'.strtoupper($request->get('search')).'%';
        oci_bind_by_name($result, ":inputcode", $inputcode);
        oci_execute($result);
        while($row=oci_fetch_array($result,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $ArticleCode[] = $row["SEGMENT_VALUE_DESC"];
        }
        return response()->json($ArticleCode);
    }

    public function Sinno(Request $request)
    {
        $Sono = array();
        $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
        $conn = oci_connect("onsole","s",$wizerp);
        $sql = "SELECT IM.ISSUE_NO, IM.ISSUE_DATE FROM ISSUE_MT IM WHERE IM.ISSUE_NO LIKE :inputcode ORDER BY IM.ISSUE_NO, IM.ISSUE_DATE DESC OFFSET 0 ROWS FETCH NEXT 15 ROWS ONLY";
        $result = oci_parse($conn, $sql);
        $inputcode = '%'.strtoupper($request->get('search')).'%';
        oci_bind_by_name($result, ":inputcode", $inputcode);
        oci_execute($result);
        while($row=oci_fetch_array($result,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $Sono[] = $row["ISSUE_NO"] . " || " . $row["ISSUE_DATE"];
        }
        return response()->json($Sono);
    }

    public function workorderNo(Request $request)
    {
        $Sono = array();
        $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
        $conn = oci_connect("onsole","s",$wizerp);
        $sql = "SELECT DISTINCT A.DOC_NO, A.DOC_DATE FROM OUT_SOURCE_JOB_CARD_MT A JOIN OUT_SOURCE_JOB_CARD_DET B ON B.JOB_CARD_ID = A.JOB_CARD_ID JOIN ITEMS_MT C ON C.ITEM_ID = B.ITEM_ID AND A.DOC_NO LIKE :inputcode
                ORDER BY A.DOC_NO OFFSET 0 ROWS FETCH NEXT 6 ROWS ONLY";
        $result = oci_parse($conn, $sql);
        $inputcode = '%'.strtoupper($request->get('search')).'%';
        oci_bind_by_name($result, ":inputcode", $inputcode);
        oci_execute($result);
        while($row=oci_fetch_array($result,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $Sono[] = $row["DOC_NO"] . " || " . $row["DOC_DATE"];
        }
        return response()->json($Sono);
    }

    public function purchaseInvNo(Request $request)
    {
        $Sono = array();
        $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
        $conn = oci_connect("onsole","s",$wizerp);
        $sql = "SELECT AA.DOCUMENT_NO, AA.GL_DATE FROM PURCHASE_INVOICE_MT AA WHERE AA.DOCUMENT_NO LIKE :inputcode ORDER BY AA.DOCUMENT_NO, AA.GL_DATE DESC OFFSET 0 ROWS FETCH NEXT 15 ROWS ONLY";
        $result = oci_parse($conn, $sql);
        $inputcode = '%'.strtoupper($request->get('search')).'%';
        oci_bind_by_name($result, ":inputcode", $inputcode);
        oci_execute($result);
        while($row=oci_fetch_array($result,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $Sono[] = $row["DOCUMENT_NO"] . " || " . $row["GL_DATE"];
        }
        return response()->json($Sono);
    }

    public function Customer(Request $request)
    {
        $Customer = array();
        $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
        $conn = oci_connect("onsole","s",$wizerp);
        $sql = "SELECT CM.COMPANY_NAME FROM CUSTOMER_MT CM WHERE CM.COMPANY_NAME LIKE :inputcode ORDER BY CM.COMPANY_NAME OFFSET 0 ROWS FETCH NEXT 7 ROWS ONLY";
        $result= oci_parse($conn, $sql);
        $inputcode = '%'.strtoupper($request->get('search')).'%';
        oci_bind_by_name($result, ":inputcode", $inputcode);
        oci_execute($result);
        while($row=oci_fetch_array($result,  OCI_ASSOC+OCI_RETURN_NULLS)){
            $Customer[] = $row["COMPANY_NAME"];
        }
        return response()->json($Customer);
    }

    public function Department($id)
    {
        try{
            $Support = User::orderBy('name','ASC')->where('department', $id)->get();
            foreach($Support as $data){
                $value[] = [
                    'id' => $data['id'],
                    'name' => $data['emp_name'],
                ]; 
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
}
