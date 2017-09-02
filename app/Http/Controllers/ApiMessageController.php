<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\User;
use App\Events\MessageEvent;
use App\Repositories\UserRepository;
use App\Repositories\MessageRepository;

class ApiMessageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function message(Request $r, MessageRepository $messageRepository)
    {
        $newMessage = $messageRepository->
            create(\Auth::user()->id, $r->input('Msg'));
        
        return response()->json([
            'Status' => 'OK' 
        ]);
    }
    
    public function getMessagesInitial(Request $r, 
        MessageRepository $messageRepository) 
    {
        // Get the last 50 messages
        $messages = $messageRepository->getLastNMessages(50);
        
        return response()->json($messages);
    }
    
    /*
    *
    * This method is to keep a record of who is online
    * 
    */
    public function setAlive(Request $r) 
    {
        
        
    }
    
    /*
    *
    * This method is for returning all the users
    *
    */
    public function findAllUsers(Request $r, UserRepository $userRepo) 
    {
        $users = $userRepo->getAllUsers();
        
        sleep(2);
        return response()->json($users);
    }

}
