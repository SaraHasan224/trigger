<?php

namespace App\Listeners;

use App\Events\NotifyEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyEvent
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
     * @param  NotifyEvent  $event
     * @return void
     */
    public function handle(NotifyEvent $event)
    {
        //
    }
}
