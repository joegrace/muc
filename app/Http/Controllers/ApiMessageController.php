<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\User;
use App\Events\MessageEvent;

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

    public function message(Request $r)
    {
        $m = new Message();
        $m->text = $r->input('Msg');
        $m->user_id = \Auth::user()->id;
        $m->save();
        
        event(new MessageEvent($m));
        
        return response()->json([
            'Status' => 'OK' 
        ]);
    }
    
    public function getMessagesInitial(Request $r) 
    {
        // Get the last 50 messages
        //$messages = Message::limit(30)->orderBy('id', 'desc');
        $messages = Message::orderBy('id', 'desc')->limit(50)->get();
        
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
    public function findAllUsers(Request $r) 
    {
        $allUsers = User::all();
    
        return response()->json($allUsers);
    }

}
