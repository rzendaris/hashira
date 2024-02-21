<?php

namespace App\Repositories\Event;

use Helper;
use Auth;
use Carbon\Carbon;
use App\Models\Event;
use App\Http\Requests\EventRequest;

class EloquentEventRepository implements EventRepository
{

    public function fetchEventBuilder()
    {
        $query_builder = Event::where('id', '!=', NULL);
        return $query_builder;
    }

    public function fetchEvents()
    {
        $events = $this->fetchEventBuilder()->get();
        return $events;
    }

    public function insertEvent(EventRequest $request)
    {
        $event = new Event;
        $event->name = $request->name;
        $event->description = $request->description;
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;
        $event->save();

        return $event;
    }
}