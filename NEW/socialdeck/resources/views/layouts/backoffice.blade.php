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

        <title>@yield('title')</title>
    </head>
    <body>
        @section('sidebar')
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
        @show

        <div class="container">
            @yield('content')
        </div>
    </body>
</html>