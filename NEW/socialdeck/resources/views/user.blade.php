@extends('layouts.backoffice')

@section('title', $User->isAvailable() ? htmlchars( $User->firstname ." ". $User->lastname ) : __("New User"))

@section('content')
    <?php 
        $TopBar = new stdClass;
        $TopBar->title = __("Users");
        $TopBar->btn = array(
            "icon" => "sli sli-user-follow",
            "title" => __("Add new"),
            "link" => APPURL."/users/new"
        );
        require_once(APPPATH.'/views/fragments/topbar.fragment.php'); 
    ?>

    <?php require_once(APPPATH.'/views/fragments/user.fragment.php'); ?>
    
    <script type="text/javascript" src="<?= APPURL."/assets/js/plugins.js?v=".VERSION ?>"></script>
    <?php require_once(APPPATH.'/inc/js-locale.inc.php'); ?>
    <script type="text/javascript" src="<?= APPURL."/assets/js/core.js?v=".VERSION ?>"></script>
    <script type="text/javascript" charset="utf-8">
        $(function(){
            NextPost.UserForm();
        })
    </script>

    <?php require_once(APPPATH.'/views/fragments/google-analytics.fragment.php'); ?>
@endsection