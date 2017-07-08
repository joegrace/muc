<?php

namespace App\Events;

use App\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;



class MessageEvent implements ShouldBroadcast
{
    use SerializesModels;
    
    public $msg;
    
    public function __construct(Message $m)
    {
        $this->msg = $m;
    }
    
    public function broadcastOn() 
    {
        return new Channel('message');
    }
    
    
}