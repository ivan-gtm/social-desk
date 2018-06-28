@extends('layouts.backoffice')
{{-- __("Calendar") --}}

@section('content')
        <?php 
            $Nav = new stdClass;
            $Nav->activeMenu = "calendar";
        ?>
        @include('fragments.navigation');

        <?php 
            $TopBar = new stdClass;
            $TopBar->title = __("Calendar");
            if ($viewtype == "day") {
                // $date = new DateTime(
                //     $year . "-" . $month . "-" . $day . " 00:00:00", 
                //     new DateTimeZone($AuthUser->get("preferences.timezone")));
                // $TopBar->subtitle = $date;
                
                $timestamp = $year . '-' . $month . '-' . $day . ' 00:00:00';
                $TopBar->subtitle = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $timestamp, $AuthUser->preferences->timezone)->format($AuthUser->preferences->dateformat );
            }
            $TopBar->btn = false;
            // require_once(APPPATH.'/views/fragments/topbar.fragment.php'); 
        ?>
        @include('fragments.topbar');

        @include('fragments.'.'calendar-'.($viewtype == "day" ? "day" : "month"));
        
        <script type="text/javascript" src="{{ asset('/js/plugins.js?v='.Config::get('constants.options.VERSION') )}}"></script>
        @include('/fragments/js/js-locale-inc');
        <script type="text/javascript" src="{{ asset('/js/core.js?v='.Config::get('constants.options.VERSION') )}}"></script>
        <script type="text/javascript" charset="utf-8">
            $(function(){
                NextPost.Calendar();
            })
        </script>

        {{-- google-analytics.fragment.php');  --}}
@endsection('content')