<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Account;
use App\Caption;
use App\User;
use App\PostMedias;

class PostController extends Controller
{
    /**
     * Process
     */
    public function edit($post_id, Request $request){
        if(isset($post_id) && $post_id > 0){
            $post = Post::where('id', '=', $post_id)->first();
            // $media_ids = explode(",", $Post->media_ids);
            $media = PostMedias::where('post_id', $post->id)->first();
        }
        

        if($request->has('caption')){
            // echo "<pre>";
            // print_r($request->all());
            // exit;
            $post->caption = $request->caption;
            $post->schedule_date = $request->schedule_date;
            $post->save();
        }

        // print_r($media);
        // return view('welcome', compact('post', 'captions', 'isVideoExtenstionsLoaded', 'integrations', 'AuthUser', 'accounts'));
        return view('welcome', compact('post', 'media', 'post_id'));
    }

    public function index($post_id)
    {
        // QUITAR ESTO

        $AuthUser = User::where('id', '=', 1)->first();
        $AuthUser->settings = json_decode($AuthUser->settings);
        $AuthUser->preferences = json_decode($AuthUser->preferences);

        // echo "<pre>";
        // print_r($AuthUser->preferences);
        // echo "</pre>";
        // exit;

        // "timeline" => [],
        // "story" => [],
        // "album" => [],

        // $AuthUser = $this->getVariable("AuthUser");
        // $Route = $this->getVariable("Route");
        // $EmailSettings = \Controller::model("GeneralData", "email-settings");

        // // Auth
        // if (!$AuthUser){
        //     header("Location: ".APPURL."/login");
        //     exit;
        // } else if (
        //     !$AuthUser->isAdmin() && 
        //     !$AuthUser->isEmailVerified() && 
        //     $EmailSettings->get("data.email_verification")) 
        // {
        //     header("Location: ".APPURL."/profile?a=true");
        //     exit;
        // } else if ($AuthUser->isExpired()) {
        //     header("Location: ".APPURL."/expired");
        //     exit;
        // }

        // Identify post
        if (isset($post_id) && $post_id > 0) {
            // $Post = Controller::model("Post", $Route->params->id);
            $allowed_statuses = ["scheduled", "failed"];
            
            $post = Post::where('id', '=', $post_id)->first();
            
            // echo "<pre>";
            // print_r($post->publish_date);
            // echo "</pre>";
            // exit;

            // if ($user === null || // Post is not available
            //     !in_array($post->status, $allowed_statuses) ||  // Post is already published or processing now
            //     $post->user_id != $AuthUser->get("id")
            // ) {
            //     header("Location: ".APPURL."/post");
            //     exit;
            // }
        } else {
            $post = Post::where('id', '=', $post_id)->first();
        }

        // Get my accounts
        $accounts = Account::where("login_required", "=", 0)
                    // where("user_id", "=", $AuthUser->get("id"))
                     ->orderBy("id","DESC")
                     ->get();

        // Get Captions
        $captions = Caption::
                 // setPageSize(3)
                 where("user_id", $AuthUser->id)
                 // setPage(Input::get("cp"))
                 ->orderBy("id", "DESC")
                 ->paginate(3);
                 // ->get();
        
        // $this->setVariable("Post", $Post)
        //      ->setVariable("accounts", $accounts)
        //      ->setVariable("captions", $captions)
        //      ->setVariable("isVideoExtenstionsLoaded", isVideoExtenstionsLoaded())
        //      ->setVariable("Integrations", Controller::model("GeneralData", "integrations"));

        $isVideoExtenstionsLoaded = true;
        //      ->setVariable("Integrations", Controller::model("GeneralData", "integrations"));

        // echo "<pre>";
        // print_r(sizeof($accounts));
        // echo "</pre>";
        // exit;

        // if (Input::post("action") == "post") {
        //     $this->post();
        // } else if (Input::post("action") == "login") {
        //     $this->login();   
        // } else if (Input::post("action") == "search") {
        //     $this->search();   
        // }

        // $this->view("post");
        $integrations = null;

        // echo "<pre>";
        // print_r($post);
        // echo "<br>";
        // print_r($captions);
        // echo "<br>";
        // print_r($isVideoExtenstionsLoaded);
        // echo "<br>";
        // print_r($integrations);
        // echo "<br>";
        // print_r($AuthUser);
        // echo "<br>";
        // print_r($accounts);
        // echo "</pre>";
        // exit;
        return view('post', compact('post', 'captions', 'isVideoExtenstionsLoaded', 'integrations', 'AuthUser', 'accounts'));
    }


    /**
     * Publish or Schedule post
     * @return void 
     */
    private function post()
    {
        $this->resp->result = 0;

        $AuthUser = $this->getVariable("AuthUser");
        $Post = $this->getVariable("Post");
        $is_new = !$Post->isAvailable();
        $isVideoExtenstionsLoaded = $this->getVariable("isVideoExtenstionsLoaded");
        $Accounts = $this->getVariable("Accounts");

        // Create a new instance of Emojione Client
        $Emojione = new \Emojione\Client(new \Emojione\Ruleset());

        
        // Ckeck post type
        $type = Input::post("type");
        if (!in_array($type, ["timeline", "story", "album"])) {
            $type = "timeline";
        }
        

        // Check media ids
        $media_ids = explode(",", Input::post("media_ids"));
        foreach ($media_ids as $i => $id) {
            if ((int)$id < 1) {
                unset($media_ids[$i]);
            } else {
                $id = (int)$id;
            }
        }

        $query = DB::table(TABLE_PREFIX.TABLE_FILES)
               ->where("user_id", "=", $AuthUser->get("id"))
               ->whereIn("id", $media_ids);
        $res = $query->get();

        $valid_media_ids = [];
        $media_data = [];
        foreach ($res as $m) {
            $valid_media_ids[] = $m->id;
            $media_data[$m->id] = $m;
        }

        foreach ($media_ids as $i => $id) {
            if (!in_array($id, $valid_media_ids)) {
                unset($media_ids[$i]);
            }
        }

        if ($type == "album" && count($media_ids) < 2) {
            $this->resp->msg = __("Please select at least 2 media this album post.");
            $this->jsonecho();
        } else if ($type == "story" && count($media_ids) < 1) {
            $this->resp->msg = __("Please select one media for this story post.");
            $this->jsonecho();
        } else if ($type == "timeline" && count($media_ids) < 1) {
            $this->resp->msg = __("Please select one media for this post.");
            $this->jsonecho();
        }

        switch ($type) {
            case "timeline":
            case "story":
                $media_ids = array_slice($media_ids, 0, 1);
                break;

            case "album":
                $media_ids = array_slice($media_ids, 0, 10);
                break;
            
            default:
                $media_ids = array_slice($media_ids, 0, 1);
                break;
        }


        // Check media permissions 
        // These permissions are also being checked in the InstagramController.
        // The reason to check the permissions here is to ensure 
        // that the post data is valid before recording it to the database.
        $permission_errors = [
            "settings.post_types.timeline_video" => __("You don't have a permission for video posts."),
            "settings.post_types.story_video" => __("You don't have a permission for story videos."),
            "settings.post_types.album_video" => __("You don't have a permission for videos in album."),
            "settings.post_types.timeline_photo" => __("You don't have a permission for photo posts."),
            "settings.post_types.story_photo" => __("You don't have a permission for story photos."),
            "settings.post_types.album_photo" => __("You don't have a permission for photos in album.")
        ];

        foreach ($media_ids as $id) {
            $media = $media_data[$id];
            $ext = strtolower(pathinfo($media->filename, PATHINFO_EXTENSION));

            if (in_array($ext, ["mp4"])) {
                if (!$isVideoExtenstionsLoaded) {
                    $this->resp->msg = __("It's not possible to post video files right now!");
                    $this->jsonecho();    
                }

                $permission = "settings.post_types.".$type."_video";
            } else if (in_array($ext, ["jpg", "jpeg", "png"])) {
                $permission = "settings.post_types.".$type."_photo";
            } else {
                $this->resp->msg = __("Oops! An error occured. Please try again later!");
                $this->jsonecho();
            }

            if (!$AuthUser->get($permission)) {
                if (isset($permission_errors[$permission])) {
                    $msg = $permission_errors[$permission];
                } else {
                    $msg = __("You don't have a permission for this kind of post.");
                }

                $this->resp->msg = $msg;
                $this->jsonecho();
            }
        }


        // Check caption
        $caption = Input::post("caption");
        $caption = $Emojione->shortnameToUnicode($caption);
        $caption = mb_substr($caption, 0, 2200);
        $caption = $Emojione->toShort($caption);


        // Check first comment
        $first_comment = Input::post("first_comment");
        $first_comment = $Emojione->shortnameToUnicode($first_comment);
        $first_comment = mb_substr($first_comment, 0, 2200);
        $first_comment = $Emojione->toShort($first_comment);


        // Check account
        $account_id = Input::post("account");
        $Account = null;
        foreach ($Accounts->getDataAs("Account") as $a) {
            if ($a->get("id") == $account_id) {
                $Account = $a;
                break;
            }
        }

        if (!$Account) {
            $this->resp->msg = __("Please select an Instagram account to post.");
            $this->jsonecho();
        }


        // Check schedule
        $is_scheduled = (bool)Input::post("is_scheduled");
        $user_datetime_format = Input::post("user_datetime_format");
        if (!$user_datetime_format) {
            $user_datetime_format = $AuthUser->getDateTimeFormat();
        }

        $timezone = $AuthUser->get("preferences.timezone");
        $schedule_date = Input::post("schedule_date");
        if ($is_scheduled) {
            if (isValidDate($schedule_date, $user_datetime_format)) {
                $schedule_date = \DateTime::createFromFormat($user_datetime_format, $schedule_date, new DateTimeZone($timezone));
                $schedule_date->setTimezone(new DateTimeZone("UTC"));
            } else {
                $is_scheduled = false;
            }
        }


        // Location
        $location = null;
        if (Input::post("location_label") && Input::post("location_object")) {
            $location_object = @unserialize(Input::post("location_object"));
            if ($location_object instanceof \InstagramAPI\Response\Model\Location) {
                $location = [
                    "label" => Input::post("location_label"),
                    "object" => Input::post("location_object")
                ];
            }
        }

        // Define status
        $status = $is_scheduled ? "scheduled" : "publishing";

        // If post exists, get create date and remove it
        // It will be created again as a new post
        if ($is_new) {
            $create_date = date("Y-m-d H:i:s");
        } else {
            $create_date = $post->create_date;
            $old_post_id = $post->id;
            $Post->remove();
        }


        // Create new post
        $Post = Controller::model("Post");
        $Post->set("status", $status)
             ->set("user_id", $AuthUser->get("id"))
             ->set("type", $type)
             ->set("caption", $caption)
             ->set("first_comment", $first_comment)
             ->set("location", $location ? json_encode($location) : "")
             ->set("media_ids", implode(",", $media_ids))
             ->set("remove_media", (bool)Input::post("remove_media"))
             ->set("account_id", $Account->get("id"))
             ->set("is_scheduled", $is_scheduled);

        if ($is_scheduled) {
            $Post->set("schedule_date", $schedule_date->format("Y-m-d H:i:s"));
        } else {
            $Post->set("schedule_date", date("Y-m-d H:i:s"));
        }
        
        $Post->save();

        if ($status == "scheduled") {
            $date = new DateTime(
                $post->schedule_date, 
                new DateTimeZone(date_default_timezone_get())
            );
            $date->setTimezone(new DateTimeZone($AuthUser->get("preferences.timezone")));
            $format = $AuthUser->getDateTimeFormat();

            $this->resp->result = 1;
            if ($is_new) {
                $this->resp->msg = __("Post has been scheduled to %s", $date->format($format));
            } else {
                $this->resp->msg = __("Post has been re-scheduled to %s", $date->format($format));
            }
        } else {
            // Publish post to Instagram
            try {
                $ig_media_code = InstagramController::publish($Post);

                $this->resp->result = 1;
                $this->resp->msg = __(
                    "Post published successfully! <a href='%s'>View post</a>", 
                    "https://www.instagram.com/p/".$ig_media_code
                );
            } catch (\Exception $e) {
                $this->resp->msg = $e->getMessage();

                if ($is_new) {
                    // There is no need to keep failed post 
                    // as it's new post in post-now mode
                    $Post->remove();
                }
            }

            if ($post->remove_media) {
                // Remove post media
                $Post->removeMedia();
            }
        }

        $this->jsonecho();
    }


    /**
     * Check the login state of the account
     * @return void 
     */
    private function login()
    {
        $this->resp->result = 0;
        $AuthUser = $this->getVariable("AuthUser");

        $Account = Controller::model("Account", Input::post("account_id"));
        if ($Account->get("user_id") != $AuthUser->get("id")) {
            $this->resp->msg = __("Invalid account ID");
            $this->jsonecho();
        }

        try {
            \InstagramController::login($Account);
        } catch (\Exception $e) {
            $this->resp->msg = $e->getMessage();
            $this->jsonecho();
        }

        $this->resp->result = 1;
        $this->jsonecho();
    }

    private function search()
    {
        $this->resp->result = 0;
        $AuthUser = $this->getVariable("AuthUser");
        $IpInfo = $this->getVariable("IpInfo");
        $limit = 20;

        $query = Input::post("q");
        if (mb_strlen($query) < 1) {
            $this->resp->msg = "short_query";
            $this->jsonecho();
        } else if (($query[0] == "#" || $query[0] == "@") && mb_strlen($query) < 2) {
            $this->resp->msg = "short_query";
            $this->jsonecho();
        }

        $Account = Controller::model("Account", Input::post("account_id"));
        if ($Account->get("user_id") != $AuthUser->get("id")) {
            $this->resp->msg = __("Invalid account ID");
            $this->jsonecho();
        }

        if ($query[0] == "#") {
            $query = mb_substr($query, 1);
            $type = "hashtag";
        } else if ($query[0] == "@") {
            $query = mb_substr($query, 1);
            $type = "people";
        } else {
            $type = "location";
        }

        try {
            $Instagram = \InstagramController::login($Account);
        } catch (\Exception $e) {
            $this->resp->msg = $e->getMessage();
            $this->jsonecho();
        }

        $this->resp->items = [];

        // Get data
        try {
            if ($type == "hashtag") {
                $search_result = $Instagram->hashtag->search($query);
                if ($search_result->isOk()) {
                    foreach ($search_result->getResults() as $i => $r) {
                        $this->resp->items[] = [
                            "type" => "hashtag",
                            "value" => $r->getName(),
                            "data" => [
                                "sub" => n__("%s public post", "%s public posts", $r->getMediaCount(), $r->getMediaCount()),
                                "id" => str_replace("#", "", $r->getName())
                            ]
                        ];

                        if ($i+1 >= $limit) {
                            break;
                        }
                    }
                }
            } else if ($type == "location") {
                $search_result = $Instagram->location->search(
                    empty($IpInfo->latitude) ? "40.677541" : $IpInfo->latitude,
                    empty($IpInfo->latitude) ? "-73.935673" : $IpInfo->latitude,
                    $query
                );
                if ($search_result->isOk()) {
                    foreach ($search_result->getVenues() as $i => $r) {
                        $this->resp->items[] = [
                            "type" => "location",
                            "value" => $r->getName(),
                            "data" => [
                                "sub" => $r->getAddress(),
                                "location" => serialize($r)
                            ]
                        ];

                        if ($i+1 >= $limit) {
                            break;
                        }
                    }
                }
            } else if ($type == "people") {
                $search_result = $Instagram->people->search($query);
                if ($search_result->isOk()) {
                    foreach ($search_result->getUsers() as $i => $r) {
                        $this->resp->items[] = [
                            "type" => "people",
                            "value" => $r->getUsername(),
                            "data" => [
                                "sub" => $r->getFullName(),
                                "id" => $r->getPk()
                            ]
                        ];

                        if ($i+1 >= $limit) {
                            break;
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            $this->resp->msg = $e->getMessage();
            $this->jsonecho();   
        }

        $this->resp->result = 1;
        $this->jsonecho();
    }
}
