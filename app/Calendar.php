<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Calendar extends Model
{
    //Fields that can be massassigned
    protected $fillable = [
        'roomtype_id',
        'date',
        'price',
        'availability'
    ];

    public function roomtype()
    {
        return $this->hasOne('App\Roomtype');
    }

    public function createDateRange($start_date, $end_date)
    {
        $start_date = strtotime($start_date);
        $end_date = strtotime($end_date);

        $dates = array();

        while ($start_date <= $end_date) {

            $dates[] = date('Y-m-d', $start_date);
            $start_date = strtotime('+1 day', $start_date);
        }
        return $dates;

    }

    public function calendarBulkUpdate($request)
    {

        $dates = $this->createDateRange($request->input('start_date'), $request->input('end_date'));

        foreach ($dates as $date) {

            //Get weekday number, 1 for monday 7 for sunday
            $dw = date("N", strtotime($date));

            if (in_array("mondays", $request->input('days')) && date($dw) == 1) {
                // attribute / attributes to check in the db . if available then update the attributes from second  array else create one from second array.
                Calendar::updateOrCreate(
                    ['date' => $date, 'roomtype_id' => $request->input('roomtype_id')],
                    ['price' => $request->input('price'), 'availability' => $request->input('availability')]);
            }

            if (in_array("tuesdays", $request->input('days')) && date($dw) == 2) {
                Calendar::updateOrCreate(
                    ['date' => $date, 'roomtype_id' => $request->input('roomtype_id')],
                    ['price' => $request->input('price'), 'availability' => $request->input('availability')]);
            }

            if (in_array("wednesdays", $request->input('days')) && date($dw) == 3) {
                Calendar::updateOrCreate(
                    ['date' => $date, 'roomtype_id' => $request->input('roomtype_id')],
                    ['price' => $request->input('price'), 'availability' => $request->input('availability')]);
            }

            if (in_array("thursdays", $request->input('days')) && date($dw) == 4) {
                Calendar::updateOrCreate(
                    ['date' => $date, 'roomtype_id' => $request->input('roomtype_id')],
                    ['price' => $request->input('price'), 'availability' => $request->input('availability')]);
            }

            if (in_array("fridays", $request->input('days')) && date($dw) == 5) {
                Calendar::updateOrCreate(
                    ['date' => $date, 'roomtype_id' => $request->input('roomtype_id')],
                    ['price' => $request->input('price'), 'availability' => $request->input('availability')]);
            }

            if (in_array("saturdays", $request->input('days')) && date($dw) == 6) {
                Calendar::updateOrCreate(
                    ['date' => $date, 'roomtype_id' => $request->input('roomtype_id')],
                    ['price' => $request->input('price'), 'availability' => $request->input('availability')]);
            }

            if (in_array("sundays", $request->input('days')) && date($dw) == 7) {
                Calendar::updateOrCreate(
                    ['date' => $date, 'roomtype_id' => $request->input('roomtype_id')],
                    ['price' => $request->input('price'), 'availability' => $request->input('availability')]);
            }

            if (in_array("allWeekDays", $request->input('days')) && date($dw) < 6) {
                Calendar::updateOrCreate(
                    ['date' => $date, 'roomtype_id' => $request->input('roomtype_id')],
                    ['price' => $request->input('price'), 'availability' => $request->input('availability')]);
            }

            if (in_array("allWeekEnds", $request->input('days')) && date($dw) >= 6) {
                Calendar::updateOrCreate(
                    ['date' => $date, 'roomtype_id' => $request->input('roomtype_id')],
                    ['price' => $request->input('price'), 'availability' => $request->input('availability')]);
            }

            if (in_array("allDays", $request->input('days'))) {
                Calendar::updateOrCreate(
                    ['date' => $date, 'roomtype_id' => $request->input('roomtype_id')],
                    ['price' => $request->input('price'), 'availability' => $request->input('availability')]);
            }

        }
    }

    public function calendarEventUpdate($request)
    {
        if ($request->input('type') == 'price') {
            Calendar::where('id', $request->input('eventid'))
                ->update(['price' => $request->input('title')]);
        }

        if ($request->input('type') == 'availability') {
            Calendar::where('id', $request->input('eventid'))
                ->update(['availability' => $request->input('title')]);
        }
    }

    public static function loadEvents()
    {

        $events = DB::table('calendars')->get();

        $eventsJson = array();

        foreach ($events as $event) {
            $eventsJson[] = array(
                'id' => $event->id,
                'resourceId' => 'price' . $event->roomtype_id,
                'start' => $event->date,
                'title' => $event->price,
                'allDay' => true,
                'type' => 'price'
            );

            $eventsJson[] = array(
                'id' => $event->id,
                'resourceId' => 'availability' . $event->roomtype_id,
                'start' => $event->date,
                'title' => $event->availability,
                'allDay' => true,
                'type' => 'availability'
            );

        }
        return $eventsJson;
    }
}
