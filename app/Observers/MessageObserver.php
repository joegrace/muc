<?php

namespace App\Observers;

use App\Message;
use App\Events\MessageEvent;

class MessageObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  User  $user
     * @return void
     */
    public function created(Message $message)
    {
        //
        event(new MessageEvent($message));
    }



}