<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\User;
use App\Events\MessageEvent;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Repositories\UserRepository;
use Carbon\Carbon;

class ApiUserController extends Controller
{
    public function addNewUser(Request $r, UserRepository $userRepository)
    {
        $user = new User();
        $user->name = $r->input('firstName');
        $user->email = $r->input('email');
        $user->password = bcrypt($r->input('password'));
        $user->disabled = 0;
        
        $userRepository->addUser($user);    
        
        return;
    }
    
    public function changeUserPassword(Request $r, UserRepository $userRepository) 
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

        $userRepository->changeUserPassword(Auth::user()->id, $r->input('newPassword'));
        
        return response()->json([
            'Status' => 'Success'
        ]);
    }
    
    public function toggleEnable(Request $r, UserRepository $userRepository) 
    {
        if (!$userRepository->userExists($r->input('userId'))) 
        {
            throw new \Exception("Invalid paramater");
        }
     
        $user = $userRepository->getUser($r->input('userId'));
        
        if ($user->disabled == 0) 
        {
            $userRepository->disableUser($r->input('userId'));    
        }
        else 
        {
            $userRepository->enableUser($r->input('userId'));    
        }
     
        return response()->json([
            'Status' => 'Success'
        ]);
    }
    
    public function setAlive(UserRepository $userRepository)
    {
        $userRepository->setUserAlive(Auth::user()->id);
    }
    
    public function whosOnline(Request $r, UserRepository $userRepository)
    {
        $onlineUsers = $userRepository->getActiveUsers();
        
        return response()->json($onlineUsers);
    }
}