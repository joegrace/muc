<?php
namespace App\Repositories;

use App\Message;

class MessageRepository 
{
    
    public function create($userId, $text)
    {
        $newMsg = new Message();
        $newMsg->user_id = $userId;
        $newMsg->text = $text;
        
        $newMsg->save();
        
        // Return the new message
        return $newMsg;
    }
    
    public function getLastNMessages($howMany)
    {
        $messages = Message::orderBy('id', 'desc')->limit($howMany)->get();
        return $messages;
    }
    
    
    
    
}