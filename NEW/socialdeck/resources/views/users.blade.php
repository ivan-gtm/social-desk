@extends('layouts.backoffice')

@section('title', __("Users") )

@section('content')
        <?php 
            // $TopBar = new stdClass;
            // $TopBar->title = __("Users");
            // $TopBar->btn = array(
            //     "icon" => "sli sli-user-follow",
            //     "title" => __("Add new"),
            //     "link" => url("/users/new")
            // );
        ?>
       @include('fragments.users');

        <script type="text/javascript" src="{{ asset('/js/plugins.js?v='.Config::get('constants.options.VERSION') )}}"></script>

        <script type="text/javascript" src="{{ asset('/js/filemanager.js?v='.Config::get('constants.options.VERSION') )}}"></script>
        @include('/fragments/js/js-locale-inc');
        <script type="text/javascript" src="{{ asset('/js/core.js?v='.Config::get('constants.options.VERSION') )}}"></script>
        
        <script type="text/javascript" charset="utf-8">
            $(function(){
                NextPost.UserForm();
            })
        </script>

        <!-- GOOGLE ANALYTICS -->
        {{-- @include('fragments.google-analytics.php'); --}}
@endsection('content')