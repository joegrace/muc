<?php

namespace App\Listeners;

use App\Events\MessageEvent;

class MessageListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderShipped  $event
     * @return void
     */
    public function handle(MessageEvent $event)
    {
        // Access the order using $event->order...
        error_log("here");
    }
}