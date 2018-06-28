@extends('layouts.backoffice')
{{-- __("Calendar") --}}

@section('content')
        <?php 
            $Nav = new stdClass;
            $Nav->activeMenu = $idname;
        ?>
        @include('fragments.navigation');

        <?php 
            $TopBar = new stdClass;
            $TopBar->title = __("Auto Follow");
            $TopBar->btn = false;
        ?>
        @include('fragments.topbar');

<div class="skeleton skeleton--full">
    <div class="clearfix">
        <aside class="skeleton-aside">
            <?php if (count($Accounts) > 0): ?>
                <?php 
                // $active_item_id = $req['aid']; 
                $active_item_id = null; 
                ?>
                <div class="aside-list js-loadmore-content" data-loadmore-id="1">
                    <?php foreach ($Accounts as $a): ?>
                        <div class="aside-list-item js-list-item <?= $active_item_id == $a->id ? "active" : "" ?>">
                            <div class="clearfix">
                                <?php $title = htmlchars($a->username); ?>
                                <span class="circle">
                                    <span><?= textInitials($title, 2); ?></span>
                                </span>

                                <div class="inner">
                                    <div class="title"><?= $title ?></div>
                                    <div class="sub">
                                        <?= __("Instagram user") ?>
                                        <?php if ($a->login_required): ?>
                                            <span class="color-danger ml-5">
                                                <span class="mdi mdi-information"></span>    
                                                <?= __("Re-login required!") ?>
                                            </span>
                                        <?php endif ?>
                                    </div>
                                </div>

                                <?php 
                                    $url = action('AutoFollowController@schedule', $a->id);
                                    switch ( $req['ref']) {
                                        case "log":
                                            $url .= "/log";
                                            break;
                                        
                                        default:
                                            break;
                                    }
                                ?>
                                <a class="full-link js-ajaxload-content" href="<?= $url ?>"></a>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>

                <?php 
                    /*
                    if($Accounts->getPage() < $Accounts->getPageCount()): ?>
                    <div class="loadmore mt-20 mb-20">
                        <?php 
                            $url = parse_url($_SERVER["REQUEST_URI"]);
                            $path = $url["path"];
                            if(isset($url["query"])){
                                $qs = parse_str($url["query"], $qsarray);
                                unset($qsarray["page"]);

                                $url = $path."?".(count($qsarray) > 0 ? http_build_query($qsarray)."&" : "")."page=";
                            }else{
                                $url = $path."?page=";
                            }
                        ?>
                        <a class="fluid button button--light-outline js-loadmore-btn" data-loadmore-id="1" href="<?= $url.($Accounts->getPage()+1) ?>">
                            <span class="icon sli sli-refresh"></span>
                            <?= __("Load More") ?>
                        </a>
                    </div>
                endif; 
                    */
                ?>
            <?php else: ?>
                <div class="no-data">
                    <?php if ($AuthUser->get("settings.max_accounts") == -1 || $AuthUser->get("settings.max_accounts") > 0): ?>
                        <p><?= __("You haven't add any Instagram account yet. Click the button below to add your first account.") ?></p>
                        <a class="small button" href="<?= APPURL."/accounts/new" ?>">
                            <span class="sli sli-user-follow"></span>
                            <?= __("New Account") ?>
                        </a>
                    <?php else: ?>
                        <p><?= __("You don't have a permission to add any Instagram account.") ?></p>
                    <?php endif; ?>
                </div>
            <?php endif ?>
        </aside>

        <section class="skeleton-content hide-on-medium-and-down">
            <div class="no-data">
                <span class="no-data-icon sli sli-social-instagram"></span>
                <p><?= __("Please select an account from left side list.") ?></p>
            </div>
        </section>
    </div>
</div>
        
        <script type="text/javascript" src="{{ asset('/js/plugins.js?v='.Config::get('constants.options.VERSION') )}}"></script>
        <!-- include('/fragments/js/js-locale-inc'); -->
        <script type="text/javascript" src="{{ asset('/js/core.js?v='.Config::get('constants.options.VERSION') )}}"></script>
        <script type="text/javascript" charset="utf-8">
            // $(function(){
            //     AutoFollow.Index();
            // })
        </script>

        {{-- google-analytics.fragment.php');  --}}
@endsection('content')