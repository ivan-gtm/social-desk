<div class="skeleton skeleton--full" id="users">
    <div class="clearfix">
        <aside class="skeleton-aside">
            <?php 
                $form_action = url('/users');
                @include('aside-search-form'); 
            ?>

            <div class="js-search-results">
                @if (count($Users) > 0)
                    {{--
                        // $active_item_id = Input::get("aid"); 
                    --}}
                    <div class="aside-list js-loadmore-content" data-loadmore-id="1">
                        @foreach ($Users as $user)
                            <div class="aside-list-item js-list-item {{ isset($active_item_id) == $user->id ? "active" : "" }}">
                                <div class="clearfix">
                                    <?php $title = htmlchars($user->firstname." ".$user->lastname) ?>
                                    <span class="circle">
                                        <span>{{ textInitials($title, 2) }}</span>
                                    </span>

                                    <div class="inner">
                                        <div class="title">{{ $title }}</div>
                                        <?php 
                                            if ($user->id == $AuthUser->id) {
                                                $sub = __("Your account");
                                            } else if ($user->isAdmin()) {
                                                $sub = __("Admin");
                                            } else {
                                                $sub = __("Regular user");
                                            }
                                        ?>
                                        <div class="sub">{{ $sub }}</div>

                                        @if ($user->expire_date < "2050")
                                            <div class="meta">
                                                <span>
                                                    <?php
                                                        $expire_date = new \Carbon\Carbon($user->expire_date, date_default_timezone_get());
                                                        $expire_date->setTimezone($AuthUser->preferences->timezone);
                                                        $format = $AuthUser->preferences->dateformat;
                                                        if (!$format) {
                                                            $format = "Y-m-d";
                                                        }

                                                        // echo date_default_timezone_get();
                                                        // $expire_date = new \Carbon\Carbon($user->expire_date, date_default_timezone_get());
                                                        // echo "<pre>";
                                                        // print_r($expire_date);
                                                        // print_r('****************');
                                                        // print_r($expire_date->format($format));
                                                        // print_r($expire_date);
                                                        // echo "</pre>";
                                                        // \Carbon\Carbon::createFromFormat($format, $expire_date->date )->toDateTimeString();
                                                        // exit;
                                                    ?>
                                                    {{ __("Expire date:").$expire_date->format($format) }}
                                                </span>
                                            </div>
                                        @endif

                                        <div class="meta">
                                            @if ($user->isExpired())
                                                <span class="color-primary">
                                                    <span class="mdi mdi-history"></span> 
                                                    {{ __("Expired") }}
                                                </span>
                                            @elseif ($user->is_active)
                                                <span class="color-success">
                                                    <span class="mdi mdi-check-circle"></span> 
                                                    {{ __("Active") }}
                                                </span>
                                            @else
                                                <span class="color-danger">
                                                    <span class="mdi mdi-close-circle"></span> 
                                                    {{ __("Deactive") }}
                                                </span>
                                            @endif

                                            @if ($user->title)
                                                <span>
                                                    <span class="mdi mdi-package-variant"></span>
                                                    {{ htmlchars($user->title) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    @if ($AuthUser->canEdit($user))
                                        <div class="options context-menu-wrapper">
                                            <a href="javascript:void(0)" class="mdi mdi-dots-vertical"></a>

                                            <div class="context-menu">
                                                <ul>
                                                    <li>
                                                        <a href="javascript:void(0)" 
                                                           class="js-remove-list-item" 
                                                           data-id="{{ $user->id }}" 
                                                           data-url="{{ Config::get('constants.APPURL')."/users" }}">
                                                            {{ __("Delete") }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <a class="full-link js-ajaxload-content" href="{{ action('UserController@index', $user->id) }}"></a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <?php
                    /*
                    @if($Users->getPage() < $Users->getPageCount())
                        <div class="loadmore mt-20">
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
                            <a class="fluid button button--light-outline js-loadmore-btn" data-loadmore-id="1" href="{{ $url.($Users->getPage()+1) }}">
                                <span class="icon sli sli-refresh"></span>
                                {{ __("Load More") }}
                            </a>
                        </div>
                    @endif
                    */
                    ?>
                @else
                    @if($Users->searchPerformed())
                        <p class="search-no-result">
                            {{ __("Couldn't find any result for your search query.") }}
                        </p>
                    @endif
                @endif
            </div>
        </aside>

        <section class="skeleton-content hide-on-medium-and-down">
            <div class="no-data">
                <span class="no-data-icon sli sli-user"></span>
                <p>{{ __("Please select a user from left side list to view or modify it's details.") }}</p>
            </div>
        </section>
    </div>
</div>