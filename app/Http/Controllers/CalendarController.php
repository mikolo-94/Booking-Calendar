<?php

namespace App\Http\Controllers;

use App\Roomtype;
use App\Calendar;
use Illuminate\Http\Request;
use App\Http\Requests\CreateBulkRequest;
use App\Http\Requests\CreateEventRequest;

class CalendarController extends Controller
{
    public function bulkUpdate(CreateBulkRequest $request)
    {
        $calendar = new Calendar();
        $calendar->calendarBulkUpdate($request);
        return redirect('/');
    }

    public function eventUpdate(CreateEventRequest $request)
    {
        $calendar = new Calendar();
        $calendar->calendarEventUpdate($request);
        return redirect('/');
    }

    public function showEvents(Request $request)
    {
        if($request->wantsJson()) {
            return json_encode(Calendar::loadEvents());
        } else {
            return view('admin');
        }
    }
}

