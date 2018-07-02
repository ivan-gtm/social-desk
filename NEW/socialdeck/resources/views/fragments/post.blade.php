        <?php 
            $media_ids = [];

            if ($post->media_ids) {
                $ids = explode(",", $post->media_ids);
                foreach ($ids as $id) {
                    $id = (int)$id;
                    if ($id > 0) {
                        $media_ids[] = $id;
                    }
                }
            }
        ?>

        <div class='skeleton' id="post">
            <form action="javascript:void(0)" 
                  data-url="<?= Config::get('constants.APPURL')."/post" ?>"
                  data-post-id="{{ $post->id }}"
                  autocomplete="off">

                <input type="hidden" name="media-ids" value="<?= implode(",", $media_ids) ?>">

                <div class="container-1200">
                    <div class="row">
                        @if ($post->status == "failed")
                            <div class="prev-fail-note">
                                <div class="title"><?= __("This post has been failed to publish previously because of the following reason:") ?></div>
                                <div class="error">{{ $post->data }}</div>
                            </div>
                        @endif

                        <div class="types clearfix">
                            <?php 
                                $allowed = [
                                    "timeline" => [],
                                    "story" => [],
                                    "album" => [],
                                ];

                                $types = $AuthUser->settings->post_types;
                                foreach ($types as $key => $val) {
                                    if ($val) {
                                        $p = explode("_", $key, 2);
                                        if (isset($allowed[$p[0]])) {
                                            if ($p[1] == "video") {
                                                if ($isVideoExtenstionsLoaded) {
                                                    $allowed[$p[0]][] = __("Video");
                                                }
                                            } else {
                                                $allowed[$p[0]][] = __("Photo");
                                            }
                                        }
                                    }
                                }

                                $type = $post != null ? $post->type : null; 
                            ?>

                            <label>
                                <input name="type" value="timeline" type="radio" 
                                       <?= $type=="timeline" ? "checked" : "" ?>
                                       <?= empty($allowed["timeline"]) ? "disabled" : "" ?>>
                                <div>
                                    <span class="sli sli-camera icon"></span>

                                    <div class="type">
                                        <div class="name">
                                            <span class="hide-on-small-only"><?= __("Add Post") ?></span>
                                            <span class="hide-on-medium-and-up"><?= __("Post") ?></span>
                                        </div>
                                        <div>
                                            <?= empty($allowed["timeline"]) ? 
                                                __("Photo") ." / ". __("Video") : 
                                                implode(" / ", $allowed["timeline"]) ?>    
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <label>
                                <input name="type" type="radio" value="story" 
                                       <?= $type=="story" ? "checked" : "" ?>
                                       <?= empty($allowed["story"]) ? "disabled" : "" ?>>
                                <div>
                                    <span class="sli sli-plus icon"></span>

                                    <div class="type">
                                        <div class="name">
                                            <span class="hide-on-small-only"><?= __("Add Story") ?></span>
                                            <span class="hide-on-medium-and-up"><?= __("Story") ?></span>    
                                        </div>
                                        <div>
                                            <?= empty($allowed["story"]) ? 
                                                __("Photo") ." / ". __("Video") : 
                                                implode(" / ", $allowed["story"]) ?>    
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <label>
                                <input name="type" type="radio" value="album" 
                                      <?= $type=="album" ? "checked" : "" ?>
                                      <?= empty($allowed["album"]) ? "disabled" : "" ?>>
                                <div>
                                    <span class="sli sli-layers icon"></span>

                                    <div class="type">
                                        <div class="name">
                                            <span class="hide-on-small-only"><?= __("Add Album") ?></span>
                                            <span class="hide-on-medium-and-up"><?= __("Album") ?></span>        
                                        </div>
                                        
                                        <div>
                                            <?= empty($allowed["album"]) ? 
                                                __("Photo") ." / ". __("Video") : 
                                                implode(" / ", $allowed["album"]) ?>    
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div class="clearfix">
                            <div class="col s12 m6 l4">
                                <div class="hide-on-medium-and-up mobile-uploader">
                                    <a href="javascript:void(0)" class="js-fm-filebrowser fluid button button--dark">
                                        <span class="sli sli-cloud-upload fz-18 mr-10" style="vertical-align: -3px"></span>
                                        <?= __("Pick a file from your device") ?>
                                    </a>

                                    <div class="result"></div>
                                </div>

                                <section class="section hide-on-small-only">
                                    <div class="section-header clearfix">
                                        <h2 class="section-title"><?= __("Media") ?></h2>

                                        <div class="section-actions clearfix">
                                            <a class="mdi mdi-laptop icon tippy js-fm-filebrowser" 
                                               data-size="small"
                                               href="javascript:void(0)"
                                               title="<?= __("Your PC") ?>"></a>

                                            <a class="mdi mdi-link-variant icon tippy js-fm-urlformtoggler" 
                                               data-size="small"
                                               href="javascript:void(0)"
                                               title="<?= __("URL") ?>"></a>

                                            @if( isset($Integrations->data->dropbox->api_key) 
                                                 && isset($AuthUser->settings->file_pickers->dropbox) )
                                                <a class="mdi mdi-dropbox icon cloud-picker tippy"
                                                   data-size="small"
                                                   data-service="dropbox"
                                                   href="javascript:void(0)"
                                                   title="<?= __("Dropbox") ?>"></a>
                                            @endif

                                            @if( Config::get('constants.SSL_ENABLED') 
                                                 && $Integrations->data->onedrive->client_id 
                                                 && $AuthUser->settings->file_pickers->onedrive )
                                                <a class="mdi mdi-onedrive icon cloud-picker tippy"
                                                   data-size="small"
                                                   data-service="onedrive" 
                                                   data-client-id="<?= htmlchars($Integrations->data->onedrive->client_id) ?>"
                                                   href="javascript:void(0)"
                                                   title="<?= __("OneDrive") ?>"></a>
                                            @endif

                                            @if (isset($Integrations) && $Integrations->data->google->api_key && $Integrations->data->google->client_id && $AuthUser->settings->file_pickers->google_drive)
                                                <a class="mdi mdi-google-drive icon cloud-picker tippy"
                                                   data-size="small"
                                                   data-service="google-drive"
                                                   data-api-key="<?= htmlchars($Integrations->data->google->api_key) ?>"
                                                   data-client-id="<?= htmlchars($Integrations->data->google->client_id) ?>"
                                                   href="javascript:void(0)"
                                                   title="<?= __("Google Drive") ?>"></a>
                                            @endif

                                            <div class="more clearfix">
                                                <a class="mdi mdi-delete icon tippy js-fm-delete-mode" 
                                                   data-size="small"
                                                   href="javascript:void(0)"
                                                   title="<?= __("Delete Mode") ?>"></a>

                                                <a class="mdi mdi-information-outline icon tippy js-fm-infobox" 
                                                   data-size="small"
                                                   href="javascript:void(0)"
                                                   title="<?= __("Info") ?>"></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <div id="filemanager" 
                                             data-connector-url="<?= Config::get('constants.APPURL')."/file-manager/connector" ?>"
                                             data-maxselect="10"
                                             data-selected-file-ids="[<?= implode(",", $media_ids) ?>]"
                                             data-img-assets-url="<?= Config::get('constants.APPURL')."/assets/img/" ?>"
                                             style="height: 538px"></div>
                                    </div>
                                </section>
                            </div>

                            <div class="col s12 m6 m-last l4">
                                <section class="section">
                                    <div class="section-header clearfix">
                                        <h2 class="section-title"><?= __($post != null ? 'Edit Post' : 'New Post') ?></h2>

                                        <div class="section-actions">
                                            @if (count($accounts) > 0)
                                                <div class="dropdown onprogress">
                                                    <span class="sli sli-social-instagram icon pe-none"></span>
                                                    <img class="loading pe-none" src="{{ asset('/img/round-loading.svg') }}" alt="loading">

                                                    <select name="account" disabled>
                                                        <?php 
                                                            $selected = 0;
                                                            if ($post != null) {
                                                                $selected = $post->account_id;
                                                            } else if ((int)Input::get("account") > 0) {
                                                                $selected = (int)Input::get("account");
                                                            }
                                                        ?>   
                                                        @foreach( $accounts as $a)
                                                            <option value="<?= $a->id ?>" <?= $a->id == $selected ? "selected" : "" ?>><?= $a->username ?></option>
                                                        @endforeach;
                                                    </select>
                                                    
                                                    <span class="mdi mdi-menu-down caret"></span>
                                                </div>
                                            @else
                                                <a href="{{ Config::get('constants.APPURL').'/accounts/new' }}" class="btn">
                                                    <span class="sli sli-user-follow fz-14 mr-5"></span>
                                                    Add Account
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="section-content controls" style="min-height: 429px;">
                                        <div class="form-result"></div>

                                        <div class="mini-preview droppable">
                                            <div class="items clearfix">
                                                <div class="item item--active" data-id="1199">
                                                    <a class="js-close mdi mdi-close-circle" href="javascript:void(0)"></a>
                                                <div>
                                                <div class="img" style="background-image: url();"></div>
                                                </div>
                                                </div>
                                            </div>

                                            <div class="drophere">
                                                <span class="none"><?= __("Drop here") ?></span>
                                                <span><?= __("Drag media here to post") ?></span>
                                            </div>
                                        </div>

                                        <div class="tabs mb-20 ">
                                            <div class="tabheads clearfix">
                                                <a class="active" href="javascript:void(0)" style="width: 50%; border-bottom: none;" data-tab="1"><?= __("Caption") ?></a>
                                                <a href="javascript:void(0)" style="width: 50%; border-bottom: none;" data-tab="2"><?= __("First Comment") ?></a>
                                            </div>

                                            <div class="tabcontents">
                                                <div class="active pos-r" data-tab="1">
                                                    <?php 
                                                        $caption = $post->caption;
                                                        if (!$post != null) {
                                                            $CaptionModel = Controller::model("Caption", Input::get("caption"));

                                                            if ($CaptionModel->isAvailable() && 
                                                                $CaptionModel->user_id == $AuthUser->id) {
                                                                $caption = $CaptionModel->caption;
                                                            }
                                                        }
                                                    ?>

                                                    <div class="caption input <?= get_option("np_search_in_caption") ? "js-search-enabled" : "" ?>" 
                                                         data-placeholder="<?= __("Write a caption") ?>"
                                                         contenteditable="true"><?= htmlchars($caption) ?></div>

                                                    <a class="sli sli-grid caption-picker js-open-popup" href="<?= Config::get('constants.APPURL')."/captions" ?>" data-popup="#captions-overlay"></a>
                                                </div>

                                                <div class="pos-r" data-tab="2">
                                                    <div class="first-comment input <?= get_option("np_search_in_caption") ? "js-search-enabled" : "" ?>" 
                                                         data-placeholder="<?= __("Write the first comment") ?>"
                                                         contenteditable="true"><?= htmlchars($post->first_comment) ?></div>

                                                    <a class="sli sli-grid caption-picker js-open-popup" href="<?= Config::get('constants.APPURL')."/captions" ?>" data-popup="#captions-overlay"></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="search-results none"></div>

                                        <div class="mb-20">
                                            <?php 
                                                $is_scheduled = (bool)$post->is_scheduled;

                                                $timezone = new DateTimeZone($AuthUser->preferences->timezone);

                                                $now = new DateTime();
                                                $now->setTimezone($timezone);

                                                // if ($post != null && 
                                                //     isValidDate(Input::get("date"), "Y-m-d") &&
                                                //     Input::get("date") >= $now->format("Y-m-d")) {
                                                //     $date = new DateTime(Input::get("date")." ".$now->format("H:i"), $timezone);
                                                //     $is_scheduled = true;
                                                // } else {
                                                    $date = new DateTime($is_scheduled ? $post->schedule_date : "now");
                                                    $date->setTimezone($timezone);
                                                // }
                                            ?>
                                            <label>
                                                <input type="checkbox" 
                                                       class="checkbox" 
                                                       name="schedule" 
                                                       value="1" 
                                                       <?= $is_scheduled ? "checked" : "" ?>>
                                                <span style="margin-left:14px;">
                                                    <span class="icon unchecked">
                                                        <span class="mdi mdi-check"></span>
                                                    </span>
                                                    <?= __('Schedule') ?>
                                                </span>
                                            </label>
                                        </div>

                                        <?php 
                                            $dateformat = $AuthUser->preferences->dateformat;
                                            $timeformat = $AuthUser->preferences->timeformat == "24" ? "H:i" : "h:i A";
                                            $format = $dateformat." ".$timeformat;
                                        ?>

                                        <div class="pos-r mb-20">
                                            <input class="input leftpad js-datepicker" 
                                                   name="schedule-date" 
                                                   data-position="top left"
                                                   data-date-format="<?= str_replace(["Y", "m", "d", "F"], ["yyyy", "mm", "dd", "MM"], $dateformat) ?>"
                                                   data-time-format="<?= str_replace(["h:i", "H:i", "A"], ["hh:ii", "hh:ii", "AA"], $timeformat) ?>"
                                                   data-min-date="<?= $now->format("c") ?>"
                                                   data-start-date="<?= $date->format("c") ?>"
                                                   data-user-datetime-format="<?= $format ?>"
                                                   type="text" 
                                                   value="<?= $date->format($format); ?>"
                                                   readonly>
                                            <span class="sli sli-calendar field-icon--left pe-none"></span>
                                        </div>

                                        <div class="mb-5">
                                            <a href="javascript:void(0)" class="advanced--toggler">
                                                <?= __("Advanced Settings") ?>
                                                <span class="mdi mdi-menu-down"></span>
                                            </a>
                                        </div>


                                        <div class="advanced-settings">
                                            <div class="mb-20">
                                                <div class="pos-r">
                                                    <input type="hidden" name="location" value="<?= htmlchars($post->locationobject) ?>">
                                                    <input class="input leftpad rightpad" 
                                                           name="location-search" 
                                                           type="text" 
                                                           placeholder="<?= __("Location") ?>"
                                                           value="<?= htmlchars($post->locationlabel); ?>">
                                                    <a href="javascript:void(0)" class="js-enable-location-search mdi mdi-close-circle field-icon--right none"></a>
                                                    <span class="sli sli-location-pin field-icon--left pe-none"></span>
                                                </div>
                                            </div>

                                            <div>
                                                <label>
                                                    <input type="checkbox" 
                                                           class="checkbox" 
                                                           name="remove-media" 
                                                           value="1" 
                                                           <?= $post->removemedia ? "checked" : "" ?>>
                                                    <span style="margin-left:14px;">
                                                        <span class="icon unchecked">
                                                            <span class="mdi mdi-check"></span>
                                                        </span>
                                                        <?= __('Auto remove media') ?>

                                                        <span class="tooltip tippy" 
                                                              data-position="top"
                                                              data-size="small"
                                                              title="<?= __('Remove media files after posting') ?>">
                                                              <span class="mdi mdi-help-circle"></span>    
                                                          </span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>

                                        <p class="account-error none"></p>
                                    </div>

                                    <div class="post-submit">
                                        <input class="fluid large button"
                                               data-value-now="<?= __("Post now") ?>"
                                               data-value-schedule="<?= __("Schedule the post") ?>"
                                               type="submit" 
                                               value="<?= __( $post->is_scheduled ? "Schedule the post" : "Post now") ?>"
                                               disabled>
                                    </div>
                                </section>
                            </div>

                            <div class="col s12 m6 l4 l-last hide-on-medium-and-down">
                                <section class="section">
                                    <div class="post-preview" data-type="timeline">
                                        <div class="preview-header">
                                            <img src="{{ asset('img/instagram-logo.png') }}" alt="Instagram">
                                        </div>

                                        <div class="preview-account clearfix">
                                            <span class="circle"></span>
                                            <span class="lines">
                                                <span class="line-placeholder" style="width: 47.76%"></span>
                                                <span class="line-placeholder" style="width: 29.85%"></span>
                                            </span>
                                        </div>

                                        <div class="preview-media--timeline">
                                            <!-- <div class="placeholder"></div> -->
                                            <?php
                                                $media_ids = explode(",", $post->media_ids);
                                                $File = App\PostMedias::where('id', $media_ids[0])->first();
                                                $fileurl = asset( 'images/' . $File->filename);
                                            ?>
                                            <div class="placeholder" style="background-image: url('{{ $fileurl  }}'); padding-top: 100%;"></div>
                                            <!-- <video src="#" playsinline autoplay muted loop></video> -->    
                                        </div>

                                        <div class="preview-media--story">
                                            <!-- <div class="img"></div> -->
                                            <!-- <video src="#" playsinline autoplay muted loop></video> -->    
                                        </div>
                                        <div class="story-placeholder"></div>

                                        <div class="preview-media--album">
                                            <!-- <div class="img"></div> -->
                                            <!-- <video src="http://demo.thepostcode.co/nextpost/assets/uploads/1/instagram/19026330_428324574201218_2358753720650432512_n.mp4" playsinline autoplay muted loop class="video-preview"></video> -->    
                                        </div>

                                        <div class="preview-caption-wrapper">
                                            <div class="preview-caption-placeholder" style="<?= $caption ? "display:none" : "" ?>">
                                                <span class="line-placeholder"></span>
                                                <span class="line-placeholder" style="width: 61.19%"></span>
                                            </div>

                                            <div class="preview-caption" style="<?= $caption ? "display:block" : "" ?>"><?= htmlchars($caption) ?></div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @if (count($captions) > 0)
            <div class="overlay none js-popup" id="captions-overlay">
                <a href="javascript:void(0)" class="close-btn mdi mdi-close js-close-popup"></a>
                <div class="content">
                    <h2 class="overlay-title"><?= __("Caption Templates") ?></h2>
                    <div class="simple-list js-loadmore-content" data-loadmore-id="1">
                        <?php $Emojione = new \Emojione\Client(new \Emojione\Ruleset()); ?>
                        @foreach($captions as $c)
                            <div class="simple-list-item">
                                <h3 class="title"><?= htmlchars($c->title) ?></h3>

                                <div class="info">
                                    <p>
                                        <?= $Emojione->shortnameToUnicode($c->caption); ?>
                                    </p>
                                </div>

                                <input type="hidden" name="capion-<?= $c->id ?>" 
                                value="<?= htmlchars($Emojione->shortnameToUnicode($c->caption)); ?>">

                                <a href="javascript:void(0)" class="full-link"></a>
                            </div>
                        @endforeach
                    </div>

                    {{ $captions->links() }}
                    
                    <div class="loadmore mt-40">
                        <a class="fluid button button--light-outline js-loadmore-btn" data-loadmore-id="1" href="">
                            <span class="icon sli sli-refresh"></span>
                            <?= __("Load More") ?>
                        </a>
                    </div>
                </div>
            </div>
        @endif