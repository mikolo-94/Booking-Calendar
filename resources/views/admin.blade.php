<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- To be able to send ajax -->
    <meta name="csrf_token" content="{{ csrf_token() }}"/>

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- FullCalendar -->
    <link href="{{asset('fullcalendar.min.css') }}" rel='stylesheet'/>
    <link href='/lib/fullcalendar.print.min.css' rel='stylesheet' media='print'/>
    <link href='/scheduler.min.css' rel='stylesheet'/>
    <script src='/lib/moment.min.js'></script>
    <script src='/lib/jquery.min.js'></script>
    <script src='/lib/fullcalendar.min.js'></script>
    <script src='/scheduler.min.js'></script>
    <script>

        $(function () { // document ready

            $('#calendar').fullCalendar({

                editable: false,
                aspectRatio: 1.8,
                scrollTime: '00:00',
                contentHeight: 300,

                header: {
                    left: 'today prev,next',
                    center: 'title'
                },
                defaultView: 'timelineThreeDays',
                views: {
                    timelineThreeDays: {
                        type: 'timeline',
                        duration: {weeks: 4},
                        slotDuration: {days: 1}
                    }
                },
                resourceGroupField: 'roomtype',
                resources: [
                    {id: 'availability1', roomtype: 'Single Room', title: 'Rooms Available'},
                    {id: 'price1', roomtype: 'Single Room', title: 'Price'},
                    {id: 'availability2', roomtype: 'Double Room', title: 'Rooms Available'},
                    {id: 'price2', roomtype: 'Double Room', title: 'Price'}
                ],
                events: { // receving events from database with json
                    type: 'GET',
                    url: '/',
                    dataType: 'json'
                },
                eventClick: function (event, jsEvent, view, resource) {
                    var title = prompt('New Value:', event.title, {buttons: {Ok: true, Cancel: false}});
                    if (title) {
                        event.title = title;


                        $.ajax({
                            url: '/eventupdate',
                            beforeSend: function (xhr) {
                                var token = $('meta[name="csrf_token"]').attr('content');

                                if (token) {
                                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                                }
                            },
                            data: 'type=changetitle&title=' + title + '&eventid=' + event.id + '&type=' + event.type,
                            type: 'POST',
                            dataType: 'json',
                            success: function (response) {
                                if (response.status == 'success')
                                    $("#calendar").fullCalendar('removeEvents'); //Remove the current event
                                $("#calendar").fullCalendar('addEventSource', JSON); //Reload JSON

                            },
                            error: function (e) {
                                alert('Error processing your request: ' + e.responseText);
                            }

                        });
                    }
                }
            });
        });


    </script>
    <style>

        body {
            margin: 0;
            padding: 0;
            font-family: "Lucida Grande", Helvetica, Arial, Verdana, sans-serif;
            font-size: 14px;
        }

        #calendar {
            max-width: 100%;
            margin: 50px auto;
        }

    </style>
</head>
<body>
<div class="col-md-10 ">


    <div class="panel panel-default">
        <div class="panel-heading">Bulk Operations</div>
        <div class="panel-body">
            <form action="{{ route('bulkupdate') }}" method="post">
                <div class="row">

                    <div class="col-md-2 ">
                        <strong>Select Room:</strong>
                    </div>
                    <div class="col-md-2">
                        <select name="roomtype_id" class="form-control">
                            <option value="1">Single Room</option>
                            //Get from DB
                            <option value="2">Double Room</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <strong>Select Days:</strong>
                    </div>
                    <div class="col-md-3">

                        <div class="form-group">
                            <label for="from" class="col-sm-2 control-label">From:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="start_date" id="start_date"
                                       placeholder="YYYY-MM-DD">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="to" class="col-sm-2 control-label">To:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="end_date" id="end_date"
                                       placeholder="YYYY-MM-DD">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-sm-3">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="allDays" name="days[]" value="allDays"> All Days
                                </label>
                            </div>
                            <div class="col-sm-3">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="mondays" name="days[]" value="mondays"> Mondays
                                </label>
                            </div>
                            <div class="col-sm-3">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="thursdays" name="days[]" value="thursdays"> Thursdays
                                </label>
                            </div>
                            <div class="col-sm-3">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="sundays" name="days[]" value="sundays"> Sundays
                                </label>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-3">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="allWeekDays" name="days[]" value="allWeekDays"> All
                                    Weekdays
                                </label>
                            </div>
                            <div class="col-sm-3">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="tuesdays" name="days[]" value="tuesdays"> Tuesdays
                                </label>
                            </div>
                            <div class="col-sm-3">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="fridays" name="days[]" value="fridays"> Fridays
                                </label>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-3">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="allWeekEnds" name="days[]" value="allWeekEnds"> All
                                    Weekends
                                </label>
                            </div>
                            <div class="col-sm-3">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="wednesdays" name="days[]" value="wednesdays"> Wednesdays
                                </label>
                            </div>
                            <div class="col-sm-3">
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="saturdays" name="days[]" value="saturdays"> Saturdays
                                </label>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="newPrice" class="col-sm-2 control-label">Change Price To:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="price" id="newPrice"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <label for="newAvailability" class="col-sm-2 control-label">Change Availability To:</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" name="availability" id="newAvailability">
                        </div>
                    </div>

                </div>


                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <button type="reset" class="btn btn-default">Cancel</button>
                <button type="submit" class="btn btn-success">Update</button>
            </form>

        </div>
    </div>

    <!-- If errors occurs, print them out -->
    @if (count($errors) > 0)
        <p class="alert alert-danger"> @foreach ($errors->all() as $error){{ $error }}<br>
            @endforeach
        </p>
    @endif

            <!-- Fullcalendar -->
    <div id='calendar'></div>

</div>
</body>
</html>
