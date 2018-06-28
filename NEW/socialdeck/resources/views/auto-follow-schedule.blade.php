@extends('layouts.backoffice')
{{-- __("Calendar") --}}

@section('content')
        <?php 
            $Nav = new stdClass;
            $Nav->activeMenu = "auto-follow";
        ?>
        @include('fragments.navigation');

        <?php 
            $TopBar = new stdClass;
            $TopBar->title = htmlchars($Account->username);
            $TopBar->btn = false;
        ?>
        @include('fragments.topbar');
        
        @include('fragments.auto-follow-schedule');

        <script type="text/javascript" src="{{ asset('/js/plugins.js?v='.Config::get('constants.options.VERSION') )}}"></script>
        @include('/fragments/js/js-locale-inc');
        <script type="text/javascript" src="{{ asset('/js/core.js?v='.Config::get('constants.options.VERSION') )}}"></script>
        <script type="text/javascript" charset="utf-8">
            $(function(){
                AutoFollow.Index();
                AutoFollow.ScheduleForm();
            })
        </script>

        <!-- GOOGLE ANALYTICS -->
        {{-- google-analytics.fragment.php');  --}}
@endsection('content')