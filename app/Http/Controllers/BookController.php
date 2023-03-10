<?php

namespace App\Http\Controllers;

use Auth;
use Exception;
use App\Models\User;
use App\Models\Books;
use App\Models\RoleName;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function manageBook(Request $request)
    {
        try{
            $book = array();
            $Allbook = array();
            $PurchaseReturns = array(); $PurchaseInvoice = array(); $PurchaseOrder = array(); $PurchaseInvoice = array(); $SalesOrder = array(); $SalesReturns = array();
            $SalesInvoice = array(); $StoreIssueNote = array(); $StoreIssueNoteOnsole = array(); $StoreIssueNoteOutSource = array(); $GoodsReceiptNote = array(); $IssueReturns = array();
            $ItemAdjustments = array(); $OtherPayment = array(); $OtherReceipt = array(); $Payments = array(); $RMAOutwards = array(); $RMAInwards = array();
            $Receipts = array(); $TransferIssues = array(); $TransferReceipts = array(); $OutSourceJobCard = array(); $WorkInProcess = array();        
            $SelectedBook = array();
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $connPRL = oci_connect("onsole","s",$wizerp);
            $sql1 = "SELECT * FROM WIZ_INV_DOC_TYPE_MT";
            $userdata = oci_parse($connPRL, $sql1);
            oci_execute($userdata);
            while($row1=oci_fetch_array($userdata,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $book[] = array([
                        "book" => strtolower($row1['INV_DOC_TYPE_DESC']),
                        "id" => $row1['INV_DOC_TYPE_ID']
                    ]);
            }
            $SelectedBook[] = array(
                ["book" => "Purchase Returns",
                "id" => 16],
                ["book" => "Purchase Invoice",
                "id" => 7],
                ["book" => "Purchase Order",
                "id" => 3],
                ["book" => "Sales Order",
                "id" => 9],
                ["book" => "Sales Returns",
                "id" => 15],
                ["book" => "Sales Invoice",
                "id" => 6],
                ["book" => "Store Issue Note",
                "id" => 5],
                ["book" => "Store Issue Note Onsole",
                "id" => 310],
                ["book" => "Store Issue Note OutSource",
                "id" => 312],
                ["book" => "Goods Receipt Note",
                "id" => 4],
                ["book" => "Issue Returns",
                "id" => 11],
                ["book" => "Item Adjustments",
                "id" => 23],
                ["book" => "Other Payment",
                "id" => 57],
                ["book" => "Other Receipt",
                "id" => 58],
                ["book" => "Payments",
                "id" => 17],
                ["book" => "RMA Outwards",
                "id" => 12],
                ["book" => "RMA Inwards",
                "id" => 19],
                ["book" => "Receipts",
                "id" => 18],
                ["book" => "Transfer Issues",
                "id" => 21],
                ["book" => "Transfer Receipts",
                "id" => 22],
                ["book" => "Out Source Job Card",
                "id" => 311],
                ["book" => "Work In Process",
                "id" => 45],
            );
            $SelectedBook1[] = array(
                [16, 7, 9, 15, 6, 5, 310, 312, 4, 11, 23, 57,58, 17, 12, 19, 18, 21, 22, 311, 45]
            );
            foreach($SelectedBook1[0][0] as $value){
                $sql1 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_DOC_TYPE_ID = '$value'";
                $userdata = oci_parse($connPRL, $sql1);
                oci_execute($userdata);
                while($row1=oci_fetch_array($userdata,  OCI_ASSOC+OCI_RETURN_NULLS)){
                    $Allbook[] = array([
                            "book" => $row1['INV_BOOK_DESC'],
                            "id" => $value,
                        ]);
                }
            }
            foreach($Allbook as $data[0]){
                if($data[0][0]['id'] == 16){
                    $PurchaseReturns[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 7){
                    $PurchaseInvoice[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 3){
                    $PurchaseOrder[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 9){
                    $SalesOrder[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 15){
                    $SalesReturns[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 6){
                    $SalesInvoice[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 5){
                    $StoreIssueNote[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 310){
                    $StoreIssueNoteOnsole[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 312){
                    $StoreIssueNoteOutSource[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 4){
                    $GoodsReceiptNote[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 11){
                    $IssueReturns[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 23){
                    $ItemAdjustments[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 57){
                    $OtherPayment[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 58){
                    $OtherReceipt[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 17){
                    $Payments[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 12){
                    $RMAOutwards[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 19){
                    $RMAInwards[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 18){
                    $Receipts[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 21){
                    $TransferIssues[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 22){
                    $TransferReceipts[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 311){
                    $OutSourceJobCard[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 45){
                    $WorkInProcess[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
            }
            $user = RoleName::orderBy('name','ASC')->get();
            return view('book.master-data-4')->with([
                "book" => $book, "data" => $user, 
                "SelectedBook" => $SelectedBook[0],
                "PurchaseReturns" => $PurchaseReturns, "PurchaseInvoice" => $PurchaseInvoice, "PurchaseOrder" => $PurchaseOrder, "SalesOrder" => $SalesOrder, 
                "SalesReturns" => $SalesReturns, "SalesInvoice" => $SalesInvoice, "StoreIssueNote" => $StoreIssueNote, "StoreIssueNoteOnsole" => $StoreIssueNoteOnsole, 
                "StoreIssueNoteOutSource" => $StoreIssueNoteOutSource, "GoodsReceiptNote" => $GoodsReceiptNote, "IssueReturns" => $IssueReturns, "ItemAdjustments" => $ItemAdjustments,             
                "OtherPayment"=> $OtherPayment, "OtherReceipt"=> $OtherReceipt, "Payments" => $Payments, "RMAOutwards" => $RMAOutwards, 
                "RMAInwards" => $RMAInwards, "Receipts"=> $Receipts, "TransferIssues"=> $TransferIssues, "TransferReceipts" => $TransferReceipts, "OutSourceJobCard" => $OutSourceJobCard, 
                "WorkInProcess" => $WorkInProcess, 
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

    public function books($id)
    {
        try{
            $books = array();
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $connPRL = oci_connect("onsole","s",$wizerp);
            $sql1 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_DOC_TYPE_ID = '$id'";
            $userdata = oci_parse($connPRL, $sql1);
            oci_execute($userdata);
            while($row1=oci_fetch_array($userdata,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $books[] = array([
                        "book" => $row1['INV_BOOK_DESC'],
                    ]);
            }
            return response()->json($books);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function Assign(Request $request)
    {
        try{
            $id = $request->username;
            $book = $request->bookname;
            for($i=0; $i<count($request->books); $i++){ 
                $Roledata[] = [
                    'role' => $id,
                    'book_type' => $book,
                    'book_name' => $request->books[$i],
                ];
            }
            Books::insert($Roledata);
            $notification = array(
                'message' => 'Books Assigned!',
                'alert-type' => 'success'
            );
            return redirect()->route('manage-book')->with($notification); 
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function AssignUpdate(Request $request)
    {
        try{
            dd($request->all());
            //Delete Prvioud Book same like job order rows
            $id = $request->username;
            $book = $request->bookname;
            for($i=0; $i<count($request->books); $i++){ 
                $Roledata[] = [
                    'userId' => $id,
                    'book_type' => $book,
                    'book_name' => $request->books[$i],
                ];
            }
            Books::insert($Roledata);
            $notification = array(
                'message' => 'Books Assigned!',
                'alert-type' => 'success'
            );
            return redirect()->route('manage-book')->with($notification); 
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function GetBooks(Request $request)
    {
        try{
            $check = 0;
            $currentuser = 0;
            if($request->iddd){
                $check = "Yes";
                $currentuser = User::orderBy('id','DESC')->where('id', $request->iddd)->pluck('firstname');
                $currentuser = $currentuser[0];
                $PurchaseReturnsVal = array(); $PurchaseInvoiceVal = array(); $PurchaseOrderVal = array(); $PurchaseInvoiceVal = array(); $SalesOrderVal = array(); $SalesReturnsVal = array();
                $SalesInvoiceVal = array(); $StoreIssueNoteVal = array(); $StoreIssueNoteOnsoleVal = array(); $StoreIssueNoteOutSourceVal = array(); $GoodsReceiptNoteVal = array(); $IssueReturnsVal = array();
                $ItemAdjustmentsVal = array(); $OtherPaymentVal = array(); $OtherReceiptVal = array(); $PaymentsVal = array(); $RMAOutwardsVal = array(); $RMAInwardsVal = array();
                $ReceiptsVal = array(); $TransferIssuesVal = array(); $TransferReceiptsVal = array(); $OutSourceJobCardVal = array(); $WorkInProcessVal = array(); 
        
                $id = $request->iddd;
                $user = Books::orderBy('id','DESC')->where('userId', $id)->get()->unique('book_type')->pluck('book_type');
                foreach($user as $dataT){
                    if($dataT == 17){
                        $user = Books::orderBy('id','DESC')->where('book_type', $dataT)->where('userId', $id)->get()->pluck('book_name');
                        $PaymentsVal[] = $user;
                        $PaymentsVal = $PaymentsVal[0];
                    }
                    elseif($dataT == 16){
                        $user = Books::orderBy('id','DESC')->where('book_type', $dataT)->where('userId', $id)->get()->pluck('book_name');
                        $PurchaseReturnsVal[] = $user;
                        $PurchaseReturnsVal = $PurchaseReturnsVal[0];
                    }
                    elseif($dataT == 7){
                        $user = Books::orderBy('id','DESC')->where('book_type', $dataT)->get()->pluck('book_name');
                        $PurchaseInvoiceVal[] = $user;
                        $PurchaseInvoiceVal = $PurchaseInvoiceVal[0];
                    }
                    elseif($dataT == 3){
                        $user = Books::orderBy('id','DESC')->where('book_type', $dataT)->get()->pluck('book_name');
                        $PurchaseOrderVal[] = $user;
                        $PurchaseOrderVal = $PurchaseOrderVal[0];
                    }
                    elseif($dataT == 9){
                        $user = Books::orderBy('id','DESC')->where('book_type', $dataT)->get()->pluck('book_name');
                        $SalesOrderVal[] = $user;
                        $SalesOrderVal = $SalesOrderVal[0];
                    }
                    elseif($dataT == 15){
                        $user = Books::orderBy('id','DESC')->where('book_type', $dataT)->get()->pluck('book_name');
                        $SalesReturnsVal[] = $user;
                        $SalesReturnsVal = $SalesReturnsVal[0];
                    }
                    elseif($dataT == 6){
                        $user = Books::orderBy('id','DESC')->where('book_type', $dataT)->get()->pluck('book_name');
                        $SalesInvoiceVal[] = $user;
                        $SalesInvoiceVal = $SalesInvoiceVal[0];
                    }
                    elseif($dataT == 5){
                        $user = Books::orderBy('id','DESC')->where('book_type', $dataT)->get()->pluck('book_name');
                        $StoreIssueNoteVal[] = $user;
                        $StoreIssueNoteVal = $StoreIssueNoteVal[0];
                    }
                    elseif($dataT == 310){
                        $user = Books::orderBy('id','DESC')->where('book_type', $dataT)->get()->pluck('book_name');
                        $StoreIssueNoteOnsoleVal[] = $user;
                        $StoreIssueNoteOnsoleVal = $StoreIssueNoteOnsoleVal[0];
                    }
                    elseif($dataT == 312){
                        $user = Books::orderBy('id','DESC')->where('book_type', $dataT)->get()->pluck('book_name');
                        $StoreIssueNoteOutSourceVal[] = $user;
                        $StoreIssueNoteOutSourceVal = $StoreIssueNoteOutSourceVal[0];
                    }
                    elseif($dataT == 4){
                        $user = Books::orderBy('id','DESC')->where('book_type', $dataT)->get()->pluck('book_name');
                        $GoodsReceiptNoteVal[] = $user;
                        $GoodsReceiptNoteVal = $GoodsReceiptNoteVal[0];
                    }
                    elseif($dataT == 11){
                        $user = Books::orderBy('id','DESC')->where('book_type', $dataT)->get()->pluck('book_name');
                        $IssueReturnsVal[] = $user;
                        $IssueReturnsVal = $IssueReturnsVal[0];
                    }
                    elseif($dataT == 23){
                        $user = Books::orderBy('id','DESC')->where('book_type', $dataT)->get()->pluck('book_name');
                        $ItemAdjustmentsVal[] = $user;
                        $ItemAdjustmentsVal = $ItemAdjustmentsVal[0];
                    }
                    elseif($dataT == 57){
                        $user = Books::orderBy('id','DESC')->where('book_type', $dataT)->get()->pluck('book_name');
                        $OtherPaymentVal[] = $user;
                        $OtherPaymentVal = $OtherPaymentVal[0];
                    }
                    elseif($dataT == 58){
                        $user = Books::orderBy('id','DESC')->where('book_type', $dataT)->get()->pluck('book_name');
                        $OtherReceiptVal[] = $user;
                        $OtherReceiptVal = $OtherReceiptVal[0];
                    }
                    elseif($dataT == 12){
                        $user = Books::orderBy('id','DESC')->where('book_type', $dataT)->get()->pluck('book_name');
                        $RMAOutwardsVal[] = $user;
                        $RMAOutwardsVal = $RMAOutwardsVal[0];
                    }
                    elseif($dataT == 19){
                        $user = Books::orderBy('id','DESC')->where('book_type', $dataT)->get()->pluck('book_name');
                        $RMAInwardsVal[] = $user;
                        $RMAInwardsVal = $RMAInwardsVal[0];
                    }
                    elseif($dataT == 18){
                        $user = Books::orderBy('id','DESC')->where('book_type', $dataT)->get()->pluck('book_name');
                        $ReceiptsVal[] = $user;
                        $ReceiptsVal = $ReceiptsVal[0];
                    }
                    elseif($dataT == 21){
                        $user = Books::orderBy('id','DESC')->where('book_type', $dataT)->get()->pluck('book_name');
                        $TransferIssuesVal[] = $user;
                        $TransferIssuesVal = $TransferIssuesVal[0];
                    }
                    elseif($dataT == 22){
                        $user = Books::orderBy('id','DESC')->where('book_type', $dataT)->get()->pluck('book_name');
                        $TransferReceiptsVal[] = $user;
                        $TransferReceiptsVal = $TransferReceiptsVal[0];
                    }
                    elseif($dataT == 311){
                        $user = Books::orderBy('id','DESC')->where('book_type', $dataT)->get()->pluck('book_name');
                        $OutSourceJobCardVal[] = $user;
                        $OutSourceJobCardVal = $OutSourceJobCardVal[0];
                    }
                    elseif($dataT == 45){
                        $user = Books::orderBy('id','DESC')->where('book_type', $dataT)->get()->pluck('book_name');
                        $WorkInProcessVal[] = $user;
                        $WorkInProcessVal = $WorkInProcessVal[0];
                    }
                }
            }
    
            $book = array();
            $Allbook = array();
            $PurchaseReturns = array(); $PurchaseInvoice = array(); $PurchaseOrder = array(); $PurchaseInvoice = array(); $SalesOrder = array(); $SalesReturns = array();
            $SalesInvoice = array(); $StoreIssueNote = array(); $StoreIssueNoteOnsole = array(); $StoreIssueNoteOutSource = array(); $GoodsReceiptNote = array(); $IssueReturns = array();
            $ItemAdjustments = array(); $OtherPayment = array(); $OtherReceipt = array(); $Payments = array(); $RMAOutwards = array(); $RMAInwards = array();
            $Receipts = array(); $TransferIssues = array(); $TransferReceipts = array(); $OutSourceJobCard = array(); $WorkInProcess = array();        
            $SelectedBook = array();
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $connPRL = oci_connect("onsole","s",$wizerp);
            $sql1 = "SELECT * FROM WIZ_INV_DOC_TYPE_MT";
            $userdata = oci_parse($connPRL, $sql1);
            oci_execute($userdata);
            while($row1=oci_fetch_array($userdata,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $book[] = array([
                        "book" => strtolower($row1['INV_DOC_TYPE_DESC']),
                        "id" => $row1['INV_DOC_TYPE_ID']
                    ]);
            }
            $SelectedBook[] = array(
                ["book" => "Purchase Returns",
                "id" => 16],
                ["book" => "Purchase Invoice",
                "id" => 7],
                ["book" => "Purchase Order",
                "id" => 3],
                ["book" => "Sales Order",
                "id" => 9],
                ["book" => "Sales Returns",
                "id" => 15],
                ["book" => "Sales Invoice",
                "id" => 6],
                ["book" => "Store Issue Note",
                "id" => 5],
                ["book" => "Store Issue Note Onsole",
                "id" => 310],
                ["book" => "Store Issue Note OutSource",
                "id" => 312],
                ["book" => "Goods Receipt Note",
                "id" => 4],
                ["book" => "Issue Returns",
                "id" => 11],
                ["book" => "Item Adjustments",
                "id" => 23],
                ["book" => "Other Payment",
                "id" => 57],
                ["book" => "Other Receipt",
                "id" => 58],
                ["book" => "Payments",
                "id" => 17],
                ["book" => "RMA Outwards",
                "id" => 12],
                ["book" => "RMA Inwards",
                "id" => 19],
                ["book" => "Receipts",
                "id" => 18],
                ["book" => "Transfer Issues",
                "id" => 21],
                ["book" => "Transfer Receipts",
                "id" => 22],
                ["book" => "Out Source Job Card",
                "id" => 311],
                ["book" => "Work In Process",
                "id" => 45],
            );
            $SelectedBook1[] = array(
                [16, 7, 9, 15, 6, 5, 310, 312, 4, 11, 23, 57,58, 17, 12, 19, 18, 21, 22, 311, 45]
            );
            foreach($SelectedBook1[0][0] as $value){
                $sql1 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_DOC_TYPE_ID = '$value'";
                $userdata = oci_parse($connPRL, $sql1);
                oci_execute($userdata);
                while($row1=oci_fetch_array($userdata,  OCI_ASSOC+OCI_RETURN_NULLS)){
                    $Allbook[] = array([
                            "book" => $row1['INV_BOOK_DESC'],
                            "id" => $value,
                        ]);
                }
            }
            foreach($Allbook as $data[0]){
                if($data[0][0]['id'] == 16){
                    $PurchaseReturns[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 7){
                    $PurchaseInvoice[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 3){
                    $PurchaseOrder[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 9){
                    $SalesOrder[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 15){
                    $SalesReturns[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 6){
                    $SalesInvoice[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 5){
                    $StoreIssueNote[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 310){
                    $StoreIssueNoteOnsole[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 312){
                    $StoreIssueNoteOutSource[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 4){
                    $GoodsReceiptNote[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 11){
                    $IssueReturns[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 23){
                    $ItemAdjustments[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 57){
                    $OtherPayment[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 58){
                    $OtherReceipt[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 17){
                    $Payments[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 12){
                    $RMAOutwards[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 19){
                    $RMAInwards[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 18){
                    $Receipts[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 21){
                    $TransferIssues[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 22){
                    $TransferReceipts[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 311){
                    $OutSourceJobCard[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 45){
                    $WorkInProcess[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
            }
            $user = Books::orderBy('id','DESC')->get()->unique('userId')->pluck('userId');
            foreach($user as $data){
                $res = User::orderBy('id','DESC')->where('id',$data)->pluck('id');
                $res1 = User::orderBy('id','DESC')->where('id',$data)->pluck('firstname');
                $res2 = User::orderBy('id','DESC')->where('id',$data)->pluck('lastname');
                $Data[] = array(
                    'id' => $res[0], 
                    'firstname' => $res1[0],
                    'lastname' => $res2[0],
                );
            }
    
            // dd($PurchaseReturns,$PurchaseReturnsVal);
            // $count = count($PurchaseReturnsVal);
            // foreach($PurchaseReturns as $val1){
            //     for($i=0; $i<$count; $i++){
            //         if($val1[0]['book'] == $PurchaseReturnsVal[$i]){
            //             echo "Yes";
            //         }
            //     }
            //     echo "No";
            // }
            // dd("Stop");
    
            return view('book.manage')->with([
                "book" => $book, "data" => $Data,  "check" => $check, 
                "SelectedBook"=> $SelectedBook[0], "currentuser"=> $currentuser,
                "PurchaseReturns"=> $PurchaseReturns, "PurchaseInvoice"=> $PurchaseInvoice, "PurchaseOrder"=> $PurchaseOrder, "SalesOrder"=> $SalesOrder, 
                "SalesReturns"=> $SalesReturns, "SalesInvoice"=> $SalesInvoice, "StoreIssueNote"=> $StoreIssueNote, "StoreIssueNoteOnsole"=> $StoreIssueNoteOnsole, 
                "StoreIssueNoteOutSource"=> $StoreIssueNoteOutSource, "GoodsReceiptNote"=> $GoodsReceiptNote, "IssueReturns"=> $IssueReturns, "ItemAdjustments"=> $ItemAdjustments,             
                "OtherPayment"=> $OtherPayment, "OtherReceipt"=> $OtherReceipt, "Payments"=> $Payments, "RMAOutwards"=> $RMAOutwards, 
                "RMAInwards"=> $RMAInwards, "Receipts"=> $Receipts, "TransferIssues"=> $TransferIssues, "TransferReceipts"=> $TransferReceipts, "OutSourceJobCard"=> $OutSourceJobCard, 
                "WorkInProcess"=> $WorkInProcess, "PaymentsVal"=> $PaymentsVal,
                "PurchaseReturnsVal"=> $PurchaseReturnsVal, "PurchaseInvoiceVal"=> $PurchaseInvoiceVal, "PurchaseOrderVal"=> $PurchaseOrderVal, "SalesOrderVal"=> $SalesOrderVal, 
                "SalesReturnsVal"=> $SalesReturnsVal, "SalesInvoiceVal"=> $SalesInvoiceVal, "StoreIssueNoteVal"=> $StoreIssueNoteVal, "StoreIssueNoteOnsoleVal"=> $StoreIssueNoteOnsoleVal, 
                "StoreIssueNoteOutSourceVal"=> $StoreIssueNoteOutSourceVal, "GoodsReceiptNoteVal"=> $GoodsReceiptNoteVal, "IssueReturnsVal"=> $IssueReturnsVal, "ItemAdjustmentsVal"=> $ItemAdjustmentsVal,             
                "OtherPaymentVal"=> $OtherPaymentVal, "OtherReceiptVal"=> $OtherReceiptVal, "RMAOutwardsVal"=> $RMAOutwardsVal, 
                "RMAInwardsVal"=> $RMAInwardsVal, "ReceiptsVal"=> $ReceiptsVal, "TransferIssuesVal"=> $TransferIssuesVal, "TransferReceiptsVal"=> $TransferReceiptsVal, "OutSourceJobCardVal"=> $OutSourceJobCardVal, 
                "WorkInProcessVal"=> $WorkInProcessVal, 
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

    public function UserBook(Request $request)
    {
        try{
            $Data = array();
            $book = array();
            $Allbook = array();
            $PurchaseReturns = array(); $PurchaseInvoice = array(); $PurchaseOrder = array(); $PurchaseInvoice = array(); $SalesOrder = array(); $SalesReturns = array();
            $SalesInvoice = array(); $StoreIssueNote = array(); $StoreIssueNoteOnsole = array(); $StoreIssueNoteOutSource = array(); $GoodsReceiptNote = array(); $IssueReturns = array();
            $ItemAdjustments = array(); $OtherPayment = array(); $OtherReceipt = array(); $Payments = array(); $RMAOutwards = array(); $RMAInwards = array();
            $Receipts = array(); $TransferIssues = array(); $TransferReceipts = array(); $OutSourceJobCard = array(); $WorkInProcess = array();        
            $SelectedBook = array();
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $connPRL = oci_connect("onsole","s",$wizerp);
            $sql1 = "SELECT * FROM WIZ_INV_DOC_TYPE_MT";
            $userdata = oci_parse($connPRL, $sql1);
            oci_execute($userdata);
            while($row1=oci_fetch_array($userdata,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $book[] = array([
                        "book" => strtolower($row1['INV_DOC_TYPE_DESC']),
                        "id" => $row1['INV_DOC_TYPE_ID']
                    ]);
            }
            $SelectedBook[] = array(
                ["book" => "Purchase Returns",
                "id" => 16],
                ["book" => "Purchase Invoice",
                "id" => 7],
                ["book" => "Purchase Order",
                "id" => 3],
                ["book" => "Sales Order",
                "id" => 9],
                ["book" => "Sales Returns",
                "id" => 15],
                ["book" => "Sales Invoice",
                "id" => 6],
                ["book" => "Store Issue Note",
                "id" => 5],
                ["book" => "Store Issue Note Onsole",
                "id" => 310],
                ["book" => "Store Issue Note OutSource",
                "id" => 312],
                ["book" => "Goods Receipt Note",
                "id" => 4],
                ["book" => "Issue Returns",
                "id" => 11],
                ["book" => "Item Adjustments",
                "id" => 23],
                ["book" => "Other Payment",
                "id" => 57],
                ["book" => "Other Receipt",
                "id" => 58],
                ["book" => "Payments",
                "id" => 17],
                ["book" => "RMA Outwards",
                "id" => 12],
                ["book" => "RMA Inwards",
                "id" => 19],
                ["book" => "Receipts",
                "id" => 18],
                ["book" => "Transfer Issues",
                "id" => 21],
                ["book" => "Transfer Receipts",
                "id" => 22],
                ["book" => "Out Source Job Card",
                "id" => 311],
                ["book" => "Work In Process",
                "id" => 45],
            );
            $SelectedBook1[] = array(
                [16, 7, 9, 15, 6, 5, 310, 312, 4, 11, 23, 57,58, 17, 12, 19, 18, 21, 22, 311, 45]
            );
            foreach($SelectedBook1[0][0] as $value){
                $sql1 = "SELECT INV_BOOK_DESC FROM INV_BOOKS_MT WHERE INV_DOC_TYPE_ID = '$value'";
                $userdata = oci_parse($connPRL, $sql1);
                oci_execute($userdata);
                while($row1=oci_fetch_array($userdata,  OCI_ASSOC+OCI_RETURN_NULLS)){
                    $Allbook[] = array([
                            "book" => $row1['INV_BOOK_DESC'],
                            "id" => $value,
                        ]);
                }
            }
            foreach($Allbook as $data[0]){
                if($data[0][0]['id'] == 16){
                    $PurchaseReturns[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 7){
                    $PurchaseInvoice[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 3){
                    $PurchaseOrder[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 9){
                    $SalesOrder[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 15){
                    $SalesReturns[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 6){
                    $SalesInvoice[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 5){
                    $StoreIssueNote[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 310){
                    $StoreIssueNoteOnsole[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 312){
                    $StoreIssueNoteOutSource[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 4){
                    $GoodsReceiptNote[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 11){
                    $IssueReturns[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 23){
                    $ItemAdjustments[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 57){
                    $OtherPayment[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 58){
                    $OtherReceipt[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 17){
                    $Payments[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 12){
                    $RMAOutwards[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 19){
                    $RMAInwards[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 18){
                    $Receipts[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 21){
                    $TransferIssues[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 22){
                    $TransferReceipts[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 311){
                    $OutSourceJobCard[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
                elseif($data[0][0]['id'] == 45){
                    $WorkInProcess[] = array([
                        "book" => $data[0][0]['book'],
                        "id" => $value,
                    ]);
                }
            }
            $user = Books::orderBy('id','DESC')->get()->unique('role')->pluck('role');
            foreach($user as $data){
                // $res = User::orderBy('id','DESC')->where('id',$data)->pluck('id');
                // $res1 = User::orderBy('id','DESC')->where('id',$data)->pluck('firstname');
                // $res2 = User::orderBy('id','DESC')->where('id',$data)->pluck('lastname');
    
                $Data[] = array(
                    'id' => $data, 
                    'firstname' => $data,
                    'lastname' => $data,
                );
            }
            return view('book.manage')->with([
                "book" => $book,  "data" => $Data, "SelectedBook" => $SelectedBook[0],
                "PurchaseReturns"=> $PurchaseReturns, "PurchaseInvoice"=> $PurchaseInvoice, "PurchaseOrder"=> $PurchaseOrder, "SalesOrder"=> $SalesOrder, 
                "SalesReturns"=> $SalesReturns, "SalesInvoice"=> $SalesInvoice, "StoreIssueNote"=> $StoreIssueNote, "StoreIssueNoteOnsole"=> $StoreIssueNoteOnsole, 
                "StoreIssueNoteOutSource"=> $StoreIssueNoteOutSource, "GoodsReceiptNote"=> $GoodsReceiptNote, "IssueReturns"=> $IssueReturns, "ItemAdjustments"=> $ItemAdjustments,             
                "OtherPayment"=> $OtherPayment, "OtherReceipt"=> $OtherReceipt, "Payments"=> $Payments, "RMAOutwards"=> $RMAOutwards, 
                "RMAInwards"=> $RMAInwards, "Receipts"=> $Receipts, "TransferIssues"=> $TransferIssues, "TransferReceipts"=> $TransferReceipts, "OutSourceJobCard"=> $OutSourceJobCard, 
                "WorkInProcess"=> $WorkInProcess, 
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

    public function bookss(Request $request)
    {
        try{
            dd($request->all());
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
            dd($request->all());
            $id = $request->name;
            $Book = array();
            $bookNamee = array();
            $Roledata = array();
            for($i=0; $i<count($request->book); $i++){ 
                $Book[$i] = $request->book[$i];
            }
            for($i=0; $i<count($request->bookname); $i++){ 
                $bookNamee[$i] = $request->bookname[$i];
            }
            for($i=0; $i<count($request->bookname); $i++){ 
                $Roledata[] = [
                    'userId' => $id,
                    'book_type' => $bookNamee[$i],
                    'book_name' => $Book[$i],
                ];
            }
            Books::insert($Roledata);
    
            $notification = array(
                'message' => 'Books Assigned Successfully!',
                'alert-type' => 'success'
            );
            return redirect()->route('manage-books')->with($notification); 
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
