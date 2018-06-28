@extends('layouts.backoffice')
{{-- __("Saved Accounts") --}}

@section('content')
    <?php 
        $Nav = new stdClass;
        $Nav->activeMenu = "accounts";
    ?>
    @include('fragments.navigation');

    <?php 
        $TopBar = new stdClass;
        $TopBar->title = __("Saved Accounts");
        if ($AuthUser->settings->max_accounts == -1 || 
            $AuthUser->settings->max_accounts > count($Accounts)) {
        
            $TopBar->btn = array(
                "icon" => "sli sli-user-follow",
                "title" => __("New Account"),
                "link" => url("/accounts/new")
            );

        }
    ?>
    @include('fragments.topbar');

    @include('fragments.accounts');

    <script type="text/javascript" src="{{ asset('/js/plugins.js?v='.Config::get('constants.options.VERSION') )}}"></script>
    
    @include('/fragments/js/js-locale-inc');

    <script type="text/javascript" src="{{ asset('/js/core.js?v='.Config::get('constants.options.VERSION') )}}"></script>
    
    <script type="text/javascript" charset="utf-8">
        $(function(){
        })
    </script>

    <?php 
    // require_once(APPPATH.'/views/fragments/google-analytics.fragment.php'); 
    ?>
@endsection('content')