<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\User;
use App\Events\MessageEvent;
use Illuminate\Support\Facades\Hash;
use Auth;

class ApiUserController extends Controller
{
    public function addNewUser(Request $r)
    {
        // Create new user
        $res = User::create([
            'name' => $r->input('firstName'),
            'email' =>$r->input('email'),
            'password' => bcrypt($r->input('password')),
        ]);
        
        return;
    }
    
    public function changeUserPassword(Request $r) 
    {
        // Make sure the old password is valid
        if (!Hash::check($r->input('oldPassword'), Auth::user()->password)) {
            // Password not valid, return
            \Debugbar::error("Passwords do not match");
            
            return response()->json([
                'Status' => 'Fail',
                'StatusMessage' => 'Old password does not match' 
            ]);
        }
        
        // Now lets do the password change.
        // Get the user
        $loggedInUser = User::find(Auth::user()->id);
        $loggedInUser->password = Hash::make($r->input('newPassword'));
        $loggedInUser->save();
        
        return response()->json([
            'Status' => 'Success'
        ]);
    }
    
    public function toggleEnable(Request $r) 
    {
        $user = User::find($r->input('userId'));
        
        if ($user == null) 
        {
            throw new Exception("Invalid paramater");
        }
        
        $user->disabled = $user->disabled == 1 ? 0 : 1;
        $user->save();

        return response()->json([
            'Status' => 'Success'
        ]);
    }
}