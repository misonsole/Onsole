<?php

namespace App\Http\Controllers;

use Auth;
use Exception;
use App\Models\Books;
use App\Models\Allbook;
use App\Models\RoleName;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function Index(Request $request)
    {
        try{
            $role = RoleName::orderBy('name','ASC')->get();
            $book = Allbook::orderBy('book','ASC')->get();
            return view('book.create')->with([
                "role" => $role, 
                "book" => $book
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
    
    public function Store(Request $request)
    {
        $books = str_replace('"', '', json_encode($request->books));
        try{
            $data = array(
                'book_name' => $books,
                'role' => $request->role,
            );
            $store = Books::create($data);
            if($store){
                $notification = array(
                    'message' => 'Books Assigned Successfully',
                    'alert-type' => 'success'
                );
            }
            else{
                $notification = array(
                    'message' => 'Operation Failed',
                    'alert-type' => 'error'
                );
            }
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

    public function Updateorcreate()
    {
        try{
            date_default_timezone_set("Asia/karachi");
            $time = date("hiA");
            $date = gettimeofday()['usec'];
            $book = array();
            $wizerp = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.70.250)(PORT = 1521)) (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = WIZERP)))";
            $connPRL = oci_connect("onsole","s",$wizerp);
            $sql1 = "SELECT * FROM WIZ_INV_DOC_TYPE_MT AA ORDER BY AA.INV_DOC_TYPE_DESC";
            $userdata = oci_parse($connPRL, $sql1);
            oci_execute($userdata);
            while($row1 = oci_fetch_array($userdata,  OCI_ASSOC+OCI_RETURN_NULLS)){
                $book[] = array(
                    "book" => $row1['INV_DOC_TYPE_DESC'],
                    "id" => $row1['INV_DOC_TYPE_ID']
                );
            }
            $count = 1; 
            foreach($book as $val){
                $count++;
                $key = rand(10,100)."".$date."".$count;
                Allbook::updateOrCreate(
                    ['book_id' => $val['id']],
                    ['book' => $val['book'], 'key_id' => $key]
                );
            }
            $notification = array(
                'message' => 'Updated',
                'alert-type' => 'info'
            );
            return response()->json($notification);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return response()->json($notification);
        }
    }
 
    public function Manage(Request $request)
    {
        try{
            $bookData = array();
            $str_arr = array();
            $book = Books::orderBy('id','DESC')->with('Role')->get();           
            return view('book.manage-book')->with([
                "book" => $book, "i" => 1,
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

    public function Check($id)
    {
        try{            
            $count = Books::orderBy('id','ASC')->where('role', $id)->count();
            if($count > 0){
                $value = 1;
            }
            else{
                $value = 2;
            }
            return response()->json($value);
        }
        catch(Exception $e){
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return response()->json($notification);
        }
    }

    public function Delete($id)
    {
        try{
            $del = Books::destroy($id);
            if($del){
                return response()->json($del);
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

    public function Edit()
    {
        try{
            dd("In Progress");
            $books = array();
            $result = array();
            $id = $_GET['id'];
           
            $book = Allbook::orderBy('book','ASC')->get();

            $bookData = Books::where('id', $id)->pluck('book_name');
            $value = str_replace('[', '', $bookData);
            $value = str_replace(']', '', $value);
            $str_arr = explode (",", $value);

            foreach($str_arr as $dat){
                $value = str_replace('"', "'", $dat);
                $books[] = $value;
            }

            dd($books);

            // $val = str_replace('[', '', $books);
            // $val = str_replace(']', '', $val);
            // preg_match_all('!\d+!', $val, $matches);
            // $result = "'" . implode ( "', '", $matches[0] ) . "'";
            // dd($result);

            foreach($books as $datt){
                preg_match_all('!\d+!', $datt, $matches);
                $result = "'" . implode ( "', '", $matches[0] ) . "'";
                $result = array($result);
            }

            dd($result,$books);

            $data = Books::where('id', $id)->with('Role')->get();
            $role = RoleName::orderBy('name','ASC')->get();
            if($data){
                return view('book.edit-book')->with([
                    "Userbook" => $data[0]->Role['name'], 
                    "role" => $role, 
                    "book" => $book, 
                    "result" => $result, 
                    "str_arr" => $str_arr, 
                ]);
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

    public function Update(Request $request)
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
}