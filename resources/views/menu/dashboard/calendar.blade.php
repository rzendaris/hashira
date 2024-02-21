@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Calendar')

@section('vendor-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('vendor-script')
<script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
@endsection

@section('content')

<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Calendar /</span> Calendar
</h4>

<!-- Basic Bootstrap Table -->
<div class="card">
    <div class="card-header">
        Calender
    </div>

    <div class="card-body">
        <form action="" method="GET">
        </form>

        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />

        <div id='calendar'></div>
    </div>
</div>
@endsection

@section('page-script')
<script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
<script>
    $(document).ready(function () {
            // page is now ready, initialize the calendar...
            events={!! json_encode($events) !!};
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                // put your options and callbacks here
                initialView: 'dayGridMonth', // dayGridMonth, multiMonthYear
                events: events,
                eventLimit: true, // for all non-agenda views
                views: {
                    agenda: {
                        eventLimit: 2
                    }
                }
            });
            calendar.render();
        });
</script>
@endsection