<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
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
                    'message' => 'Incorrect Username',
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
}
