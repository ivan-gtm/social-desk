<!DOCTYPE html>
<html lang="{{ Config::get('constants.ACTIVE_LANG') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
        <meta name="theme-color" content="#fff">

        <meta name="description" content="<?= Config::get('constants.options.site_description') ?>">
        <meta name="keywords" content="<?= Config::get('constants.options.site_keywords') ?>">

        <link rel="icon" href="<?= Config::get('constants.logomark') ? Config::get('constants.logomark') : Config::get('constants.APPURL')."/img/logomark.png" ?>" type="image/x-icon">
        <link rel="shortcut icon" href="<?= Config::get('constants.logomark') ? Config::get('constants.logomark') : Config::get('constants.APPURL')."/img/logomark.png" ?>" type="image/x-icon">

        <link rel="stylesheet" type="text/css" href="{{ asset('/css/plugins.css?v='.Config::get('constants.VERSION') ) }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/filemanager.css?v='.Config::get('constants.VERSION') ) }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/core.css?v='.Config::get('constants.VERSION') ) }}">

        <title><?= $post != null ? __("Edit Post") : __("New Post") ?></title>
    </head>

    <body>
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
    </body>
</html>