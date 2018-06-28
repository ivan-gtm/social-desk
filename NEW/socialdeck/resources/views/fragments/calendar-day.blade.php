<div class='skeleton' id="calendar-day">
    <div class="container-1200">
        <div class="row pos-r">
            <?php if (count($Accounts) > 0): ?>
                <?php 
                    $Emojione = new \Emojione\Client(new \Emojione\Ruleset());

                    $dateformat = $AuthUser->preferences->dateformat;
                    $timeformat = $AuthUser->preferences->timeformat == "24" ? "H:i" : "h:i A";
                    $format = $dateformat." ".$timeformat;
                    // exit;
                ?>

                <form class="account-selector clearfix" action="{{ url('/calendar/'.$year.'/'.$month.'/'.$day) }}" method="GET">
                    <span class="label"><?= __("Select Account") ?></span>

                    <select class="input input--small" name="account">
                        <option value=""><?= __("All accounts") ?></option>
                        <?php foreach ($Accounts as $a): ?>
                            <option value="<?= $a->id ?>" <?= $ActiveAccount->id == $a->id ? "selected" : "" ?>>
                                <?= htmlchars($a->username); ?>
                            </option>
                        <?php endforeach ?>
                    </select>

                    <input class="none" type="submit" value="<?= __("Submit") ?>">
                </form>

                <div class="list-wrapper">
                    <h2 class="page-secondary-title">
                        <?= __("In Progress") ?>

                        @if (count($ScheduledPosts) > 0)
                            <span class="badge"><?= count($ScheduledPosts) ?></span>
                        @endif
                    </h2>

                    <?php if (count($ScheduledPosts) > 0): ?>
                        <div class="post-list clearfix">
                            <?php foreach ($ScheduledPosts as $Post): ?>
                                <?php
                                    $date = new \Carbon\Carbon($Post->schedule_date, date_default_timezone_get());
                                    $date->setTimezone($AuthUser->preferences->timezone);
                                    
                                    // $date = new \Moment\Moment(
                                    //     $Post->schedule_date, 
                                    //     date_default_timezone_get());
                                    // $date->setTimezone($AuthUser->preferences->timezone);
                                ?>
                                <div class="post-list-item <?= $Post->status == "publishing" ? "" : "haslink" ?> js-list-item">
                                    <div>
                                        <?php if ($Post->status != "publishing"): ?>
                                            <div class="options context-menu-wrapper">
                                                <a href="javascript:void(0)" class="mdi mdi-dots-vertical"></a>

                                                <div class="context-menu">
                                                    <ul>
                                                        <li>
                                                            <a href="{{ url('/post/'.$Post->id) }}">
                                                                <?= __("Edit") ?>
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="javascript:void(0)" 
                                                               class="js-remove-list-item" 
                                                               data-id="<?= $Post->id ?>" 
                                                               data-url="{{ url('/calendar') }}">
                                                                <?= __("Delete") ?>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        <?php endif ?>

                                        <div class="quick-info">
                                            <?php if ($Post->status == "publishing"): ?>
                                                <span class="color-dark">
                                                    <span class="icon sli sli-energy"></span>
                                                    <?= __("Processing now...") ?>
                                                </span>
                                            <?php else: ?>
                                                <?php 
                                                    // $diff = $date->fromNow(); 

                                                    // if ($diff->getDirection() == "future") {
                                                    //     echo $diff->getRelative();
                                                    // } else if (abs($diff->getSeconds()) < 60*10) {
                                                    //     echo __("In a few moments");
                                                    // } else {
                                                        echo __("System task error");
                                                    // }
                                                ?>
                                            <?php endif ?>
                                        </div>

                                        <div class="cover">
                                            <?php 
                                                $media_ids = explode(",", $Post->media_ids);
                                                $File = App\PostMedias::where('id', $media_ids[0])->first();
                                            ?>
                                            @if ($File != null)
                                                <?php 
                                                    $extension = strtolower(pathinfo($File->filename, PATHINFO_EXTENSION));

                                                    if (in_array($extension, ['mp4'])) {
                                                        $type = 'video';                                                                
                                                    } else if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                                                        $type = 'image';
                                                    }
                                                    

                                                    $fileurl = asset( 'storage/'.$AuthUser->id. '/' . $File->filename);
                                                    $filepath = Storage::path('public/' . $AuthUser->id. '/' . $File->filename);

                                                ?>
                                                @if (file_exists($filepath))
                                                    
                                                    @if ($type == "image")
                                                        <div class="img" style="background-image: url('{{ $fileurl }}')"></div>
                                                    @else
                                                        <video src='{{ $fileurl }}' playsinline autoplay muted loop></video>
                                                    @endif
                                                @endif
                                            @endif
                                        </div>

                                        <div class="caption">
                                            <?= truncate_string($Emojione->shortnameToUnicode($Post->caption), 50); ?>
                                        </div>

                                        <?php if (!$ActiveAccount->isAvailable()): ?>
                                            <div class="quick-info mb-10">
                                                <span class="icon sli sli-social-instagram"></span>
                                                <?= htmlchars($Post->username) ?>
                                            </div>
                                        <?php endif ?>

                                        <div class="quick-info mb-10">
                                            <?php if ($Post->type == "album"): ?>
                                                <span class="icon sli sli-layers"></span>
                                                <?= __("Album") ?>
                                            <?php elseif ($Post->type == "story"): ?>
                                                <span class="icon sli sli-plus"></span>
                                                <?= __("Story") ?>
                                            <?php else: ?>
                                                <span class="icon sli sli-camera"></span>
                                                <?= __("Regular Post") ?>
                                            <?php endif ?>
                                        </div>

                                        <div class="quick-info">
                                            <span class="icon sli sli-calendar"></span>
                                            <?= $date->format($format); ?>
                                        </div>

                                        <?php if ($Post->status == "scheduled"): ?>
                                            <a class="full-link" href="<?= Config::get('constants.APPURL')."/post/".$Post->id ?>"></a>
                                        <?php endif ?>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    <?php else: ?>
                        <p class="nopost">
                            <?php 
                                if ($ActiveAccount->isAvailable()) {
                                    echo __("There is not any scheduled post for {account} on this date.", [
                                        "{account}" => "<strong>".htmlchars($ActiveAccount->username)."</strong>"
                                    ]);
                                } else {
                                    echo __("There is not any scheduled post on this date.");
                                }
                            ?>
                        </p>
                    <?php endif ?>
                </div>

                <div class="list-wrapper">
                    <h2 class="page-secondary-title">
                        <?= __("Published") ?>

                        <?php if(count($PublishedPosts) > 0): ?>
                            <span class="badge"><?= count($PublishedPosts) ?></span>
                        <?php endif ?>
                    </h2>

                    <?php if (count($PublishedPosts) > 0): ?>
                        <div class="post-list clearfix">
                            <?php foreach ($PublishedPosts as $Post): ?>
                                <?php 
                                    $date = new \Moment\Moment(
                                        $Post->schedule_date, 
                                        date_default_timezone_get());
                                    $date->setTimezone($AuthUser->preferences->timezone);
                                ?>
                                <div class="post-list-item haslink js-list-item">
                                    <div>
                                        <div class="options context-menu-wrapper">
                                            <a href="javascript:void(0)" class="mdi mdi-dots-vertical"></a>

                                            <div class="context-menu">
                                                <ul>
                                                    <li>
                                                        <a href="<?= "https://www.instagram.com/p/".$Post->data.code ?>" target="_blank">
                                                            <?= __("View on Instagram") ?>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="quick-info">
                                            <span class="color-success">
                                                <span class="icon sli sli-check"></span>
                                                <?= __("Published") ?>
                                            </span>
                                        </div>

                                        <div class="cover">
                                            <?php 
                                                $media_ids = explode(",", $Post->media_ids);
                                                $File = Controller::model("File", $media_ids[0]);
                                            ?>

                                            <?php if ($File->isAvailable()): ?>
                                                <?php 
                                                    $extension = strtolower(pathinfo($File->filename, PATHINFO_EXTENSION));

                                                    if (in_array($extension, ["mp4"])) {
                                                        $type = "video";                                                                
                                                    } else if (in_array($extension, ["jpg", "jpeg", "png"])) {
                                                        $type = "image";
                                                    }

                                                    $fileurl = Config::get('constants.APPURL')
                                                             . "/assets/uploads/" 
                                                             . $AuthUser->id
                                                             . "/" . $File->filename;

                                                    $filepath = ROOTPATH
                                                              . "/assets/uploads/" 
                                                              . $AuthUser->id 
                                                              . "/" . $File->filename;
                                                ?>
                                                <?php if (file_exists($filepath)): ?>
                                                    <?php if ($type == "image"): ?>
                                                        <div class="img" style="background-image: url('<?= $fileurl ?>')"></div>
                                                    <?php else: ?>
                                                        <video src='<?= $fileurl ?>' playsinline autoplay muted loop></video>
                                                    <?php endif ?>
                                                <?php endif ?>
                                            <?php endif ?>
                                        </div>

                                        <div class="caption">
                                            <?= truncate_string($Emojione->shortnameToUnicode($Post->caption), 50); ?>
                                        </div>

                                        <?php if (!$ActiveAccount->isAvailable()): ?>
                                            <div class="quick-info mb-10">
                                                <span class="icon sli sli-social-instagram"></span>
                                                <?= htmlchars($Post->username) ?>
                                            </div>
                                        <?php endif ?>

                                        <div class="quick-info mb-10">
                                            <?php if ($Post->type == "album"): ?>
                                                <span class="icon sli sli-layers"></span>
                                                <?= __("Album") ?>
                                            <?php elseif ($Post->type == "story"): ?>
                                                <span class="icon sli sli-plus"></span>
                                                <?= __("Story") ?>
                                            <?php else: ?>
                                                <span class="icon sli sli-camera"></span>
                                                <?= __("Regular Post") ?>
                                            <?php endif ?>
                                        </div>

                                        <div class="quick-info">
                                            <span class="icon sli sli-calendar"></span>
                                            <?= $date->format($format); ?>
                                        </div>

                                        <a class="full-link" href="<?= "https://www.instagram.com/p/".$Post->data->code ?>" target="_blank"></a>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    <?php else: ?>
                        <p class="nopost">
                            <?php 
                                if ($ActiveAccount->isAvailable()) {
                                    echo __("There is not any published post for {account} on this date yet.", [
                                        "{account}" => "<strong>".htmlchars($ActiveAccount->username)."</strong>"
                                    ]);
                                } else {
                                    echo __("There is not any published post on this date yet.");
                                }
                            ?>
                        </p>
                    <?php endif ?>
                </div>

                <div class="list-wrapper">
                    <h2 class="page-secondary-title">
                        <?= __("Failed") ?>

                        <?php if (count($FailedPosts) > 0): ?>
                            <span class="badge"><?= count($FailedPosts) ?></span>
                        <?php endif ?>
                    </h2>

                    <?php if (count($FailedPosts) > 0): ?>
                        <div class="post-list clearfix">
                            <?php foreach ($FailedPosts as $Post): ?>
                                <?php 
                                    $date = new \Moment\Moment(
                                        $Post->schedule_date, 
                                        date_default_timezone_get());
                                    $date->setTimezone($AuthUser->preferences->timezone);
                                ?>
                                <div class="post-list-item haslink js-list-item">
                                    <div>
                                        <div class="options context-menu-wrapper">
                                            <a href="javascript:void(0)" class="mdi mdi-dots-vertical"></a>

                                            <div class="context-menu">
                                                <ul>
                                                    <li>
                                                        <a href="{{ url("/post/".$Post->id) }}">
                                                            <?= __("Edit") ?>
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="javascript:void(0)" 
                                                           class="js-remove-list-item" 
                                                           data-id="<?= $Post->id ?>" 
                                                           data-url="<?= Config::get('constants.APPURL')."/calendar" ?>">
                                                            <?= __("Delete") ?>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="quick-info">
                                            <span class="color-danger">
                                                <span class="icon sli sli-close"></span>
                                                <?= __("Failed") ?>
                                            </span>
                                        </div>

                                        <div class="cover">
                                            <?php 
                                                $media_ids = explode(",", $Post->media_ids);
                                                $File = Controller::model("File", $media_ids[0]);
                                            ?>

                                            <?php if ($File->isAvailable()): ?>
                                                <?php 
                                                    $extension = strtolower(pathinfo($File->filename, PATHINFO_EXTENSION));

                                                    if (in_array($extension, ["mp4"])) {
                                                        $type = "video";                                                                
                                                    } else if (in_array($extension, ["jpg", "jpeg", "png"])) {
                                                        $type = "image";
                                                    }

                                                    $fileurl = Config::get('constants.APPURL')
                                                             . "/assets/uploads/" 
                                                             . $AuthUser->id 
                                                             . "/" . $File->filename;

                                                    $filepath = ROOTPATH
                                                              . "/assets/uploads/" 
                                                              . $AuthUser->id 
                                                              . "/" . $File->filename;
                                                ?>
                                                <?php if (file_exists($filepath)): ?>
                                                    <?php if ($type == "image"): ?>
                                                        <div class="img" style="background-image: url('<?= $fileurl ?>')"></div>
                                                    <?php else: ?>
                                                        <video src='<?= $fileurl ?>' playsinline autoplay muted loop></video>
                                                    <?php endif ?>
                                                <?php endif ?>
                                            <?php endif ?>
                                        </div>

                                        <div class="caption">
                                            <?= truncate_string($Emojione->shortnameToUnicode($Post->caption), 50); ?>
                                        </div>

                                        <?php if (!$ActiveAccount->isAvailable()): ?>
                                            <div class="quick-info mb-10">
                                                <span class="icon sli sli-social-instagram"></span>
                                                <?= htmlchars($Post->username) ?>
                                            </div>
                                        <?php endif ?>

                                        <div class="quick-info mb-10">
                                            <?php if ($Post->type == "album"): ?>
                                                <span class="icon sli sli-layers"></span>
                                                <?= __("Album") ?>
                                            <?php elseif ($Post->type == "story"): ?>
                                                <span class="icon sli sli-plus"></span>
                                                <?= __("Story") ?>
                                            <?php else: ?>
                                                <span class="icon sli sli-camera"></span>
                                                <?= __("Regular Post") ?>
                                            <?php endif ?>
                                        </div>

                                        <div class="quick-info">
                                            <span class="icon sli sli-calendar"></span>
                                            <?= $date->format($format); ?>
                                        </div>

                                        <a class="full-link" href="<?= Config::get('constants.APPURL')."/post/".$Post->id ?>"></a>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    <?php else: ?>
                        <p class="nopost">
                            <?php 
                                if ($ActiveAccount->isAvailable()) {
                                    echo __("There is not any failed post for {account} on this date yet.", [
                                        "{account}" => "<strong>".htmlchars($ActiveAccount->username)."</strong>"
                                    ]);
                                } else {
                                    echo __("There is not any failed post on this date yet.");
                                }
                            ?>
                        </p>
                    <?php endif ?>
                </div>
            <?php else: ?>
                <?php include APPPATH.'/views/fragments/noaccount.fragment.php' ?>
            <?php endif ?>
        </div>
    </div>
</div>