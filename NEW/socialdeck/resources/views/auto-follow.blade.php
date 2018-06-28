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
            
            $TopBar->btn = false;
        ?>
        @include('fragments.topbar');

        @include('fragments.auto-follow');
        
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