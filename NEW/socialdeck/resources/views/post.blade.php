@extends('layouts.backoffice')
{{-- __("Calendar") --}}

@section('content')
        <?php 
            $Nav = new stdClass;
            $Nav->activeMenu = "post";
        ?>
        @include('fragments.navigation');

        <?php 
            $TopBar = new stdClass;
            $TopBar->title = __("Dashboard");
        ?>
        @include('fragments.topbar'); 
        
        @include('fragments.post');
        
        <?php if ($integrations["data.dropbox.api_key"] && $AuthUser["settings.file_pickers.dropbox"] ): ?>
            <script id="dropboxjs" 
                    data-app-key="<?= htmlchars(Config::get("data.dropbox.api_key")) ?>"
                    type="text/javascript" 
                    src="https://www.dropbox.com/static/api/2/dropins.js"></script>
        <?php endif; ?>

        <?php if (Config::get('constants.SSL_ENABLED') && Config::get("data.onedrive.client_id") && $AuthUser->get("settings.file_pickers.onedrive")): ?>
            <script type="text/javascript" src="https://js.live.net/v7.0/OneDrive.js"></script>
        <?php endif; ?>


        <!-- <link rel="stylesheet" href="{{ asset('emojionearea/assets/css/emojionearea.css') }}"> -->
        
        <!-- <script type="text/javascript" src="{{ asset('/js/dist/jquery-3.1.1.min.js') }}"></script> -->
        <!-- <script type="text/javascript" src="{{ asset('/js/dist/emojionearea.js') }}"></script> -->
    
        <script type="text/javascript" src="{{ asset('/js/plugins.js?v='.Config::get('constants.options.VERSION') )}}"></script>

        <script type="text/javascript" src="{{ asset('/js/filemanager.js?v='.Config::get('constants.options.VERSION') )}}"></script>
        @include('/fragments/js/js-locale-inc');
        <script type="text/javascript" src="{{ asset('/js/core.js?v='.Config::get('constants.options.VERSION') )}}"></script>
        <script type="text/javascript" src="{{ asset('/js/post.js?v='.Config::get('constants.options.VERSION') )}}"></script>
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function() {
                // $("#example1").emojioneArea();
                
                NextPost.Post();
            });
        </script>
        @if(Config::get("data.google.api_key") && Config::get("data.google.client_id") && $AuthUser->get("settings.file_pickers.google_drive"))
            <script src="https://www.google.com/jsapi?key=<?= htmlchars(Config::get("data.google.api_key")) ?>"></script>
            <script src="https://apis.google.com/js/client.js?onload=GoogleDrivePickerInitializer"></script>
        @endif

        {{-- @include('fragments.google-analytics.php'); --}}
@endsection('content')