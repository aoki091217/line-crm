<?php

namespace App\Services;

class SessionService
{
    public function setSession($event)
    {
        $line_id = $event->getEventSourceId();
        if (!session()->exists($line_id)) {
            session()->put($line_id, ['is_follow' => 1]);
        }
    }
}

?>
