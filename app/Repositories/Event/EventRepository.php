<?php

namespace App\Repositories\Event;

use App\Http\Requests\EventRequest;

interface EventRepository {
    public function fetchEventBuilder();
    public function fetchEvents();
    public function insertEvent(EventRequest $request);
}
