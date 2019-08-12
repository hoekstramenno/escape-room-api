<?php

namespace App\Listeners;

use App\Events\UnlockTaskEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UnlockTaskListener
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
     * @param  UnlockTaskEvent  $event
     * @return void
     */
    public function handle(UnlockTaskEvent $event)
    {
        //
    }
}
