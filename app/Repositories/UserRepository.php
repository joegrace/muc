<?php
namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\Hash;

class UserRepository {
    
    public function getUser($id)
    {
        $user = User::find($id);
        
        return $user;
    }
    
    public function getAllUsers() 
    {
        $users = User::all();
        
        return $users;
    }
    
    public function addUser(User $user) 
    {
        $user->save();
        
        return true;
    }
    
    public function changeUserPassword($id, $password) 
    {
        // Get the user
        $user = User::find($id);
        
        // Change the user password
        $user->password = Hash::make($password);

        $user->save();
        return true;
    }
    
    public function disableUser($id)
    {
        $user = User::find($id);
        $user->disabled = 1;
        $user->save();
    }
    
    public function enableUser($id)
    {
        $user = User::find($id);
        $user->disabled = 0;
        $user->save();
    }
    
    public function userExists($id)
    {
        $user = User::find($id);
        
        if ($user != null)
        {
            return true;
        }
        
        return false;
    }
}