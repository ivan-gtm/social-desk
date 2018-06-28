<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Account;
use App\Post;
use App\PostMedias;
use App\User;

class InstagramController extends Controller
{
    /**
     * Login to the Instagram
     * 
     * @param  AccountModel $Account 
     * @return mixed    
     */
    public static function login($Account)
    {
        // Check availability
        if (!$Account->isAvailable()) {
            throw new \Exception(__("Account is not available."));
        }

        // Check is re-login required
        if ($Account->login_required) {
            throw new \Exception(__("Re-login required for %s", $Account->username));
        }
        
        // Decrypt pass.
        try {
            $password = \Defuse\Crypto\Crypto::decrypt($Account->password, 
                        \Defuse\Crypto\Key::loadFromAsciiSafeString( \Config::get('constants.options.CRYPTO_KEY') ));
        } catch (Exception $e) {
            throw new \Exception(__("Encryption error"));
        }
        
        // Temporary directory for image and video processing
        $temp_dir = 'public'.\Config::get('constants.options.TEMP_PATH');

        
        if (!Storage::exists($temp_dir)) {
            Storage::makeDirectory($temp_dir);
        } 
        
        // Setup Instagram Client
        // Allow web usage
        // Since mentioned risks has been consider internally by Nextpost,
        // setting this property value to the true is not risky as it's name
        \InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
            
        // Set location for the temporary files 
        // which are being created during processing the post media files
        \InstagramAPI\Media\InstagramMedia::$defaultTmpPath = Storage::path($temp_dir);
        \InstagramAPI\Utils::$defaultTmpPath = Storage::path($temp_dir);

        
        // Instagram Client
        $storage_config = [
            "storage" => "file",
            "basefolder" => Storage::path(\Config::get('constants.options.SESSIONS_PATH')."/".$Account->user_id."/"),
        ];
        $Instagram = new \InstagramAPI\Instagram(false, false, $storage_config);
        $Instagram->setVerifySSL(\Config::get('constants.options.SSL_ENABLED'));

        // Check is valid proxy is available for the account
        if ($Account->proxy && isValidProxy($Account->proxy)) {
            $Instagram->setProxy($Account->proxy);
        }
        // print_r(Storage::path(\Config::get('constants.options.SESSIONS_PATH')."/".$Account->user_id."/"));

        // Login to instagram
        // try {
            $last_login_timestamp = strtotime($Account->last_login);
            
            // if ($last_login_timestamp && $last_login_timestamp + 15 * 60 > time()) {
            //     // Recent login, there is no need to re-send login flow
            //     \InstagramAPI\Instagram::$sendLoginFlow = false;
            // }

            $Instagram->login($Account->username, $password);
        // } catch (InstagramAPI\Exception\InstagramException $e) {
        //     // Couldn't login to Instagram account
        //     $msg = $e->getMessage();
        //     $msg = explode(":", $msg, 2);
        //     $msg = isset($msg[1]) ? $msg[1] : $msg[0];
            
        //     $Account->login_required = 1;
        //     $Account->save();

        //     throw new \Exception($msg);
        // } catch (\Exception $e) {
        //     throw $e;
        // }

        // print_r(Storage::path($temp_dir));
        // exit;
        // Logged in successfully
        $Account->last_login = date("Y-m-d H:i:s");
        $Account->save();

        return $Instagram;
    }
    
    /**
     * Publish the $Post to the Instagram
     * @param  PostModel $Post 
     * @return string          Post media code
     */
    public static function publish(Post $Post)
    {
        // Create a new instance of Emojione Client
        $Emojione = new \Emojione\Client(new \Emojione\Ruleset());
        // Check availability
        // if ($Post == null) {
        //     // Probably post has been removed manually
        //     throw new \Exception(__("Post is not available!"));
        // }

        // Check status
        if ($Post->status != "publishing") {
            // Setting post status to "publishing" before passing it 
            // to this controller is in responsibility of
            // PostController or CronController
            // 
            // Data has been modified by external factors
            throw new \Exception(__("Post status is not valid!"));
        }


        // Update defaults data for the post (not save yet)
        $Post->status = 'failed'; // Status will be updated to the published on success
        $Post->publish_date = date("Y-m-d H:i:s"); // Means last update time


        // Check type
        $type = $Post->type;
        if (!in_array($type, ["timeline", "story", "album"])) {
            // Validating post type before passing it 
            // to this controller is in responsibility of PostController
            // 
            // Data has been modified by external factors
            $msg = __("Post type is not valid!");
            $Post->data = $msg;
            $Post->save();
            throw new \Exception($msg);
        }

        
        // Check user
        $User = User::where('id',$Post->user_id)->first();
        if ($User == null || $User->is_active == 0 || $User->isExpired()) {
            $msg = __("Your access to the script has been disabled!");
            $Post->data = $msg;
            $Post->save();
            throw new \Exception($msg);
        }
        

        // Check account
        $Account = Account::where('id', $Post->account_id)->first();
        
        if (!$Account->isAvailable()) {
            $msg = __("Account is not available.");
            $Post->data = $msg;
            $Post->save();
            throw new \Exception($msg);
        }
        
        if (isset($Account->login_required) && $Account->login_required) {
            $msg = __("Re-login required for %s", $Account->username);
            $Post->data = $msg;
            $Post->save();
            throw new \Exception($msg);
        }


        // Check media ids
        

        $media_ids = explode(",", $Post->media_ids);
        foreach ($media_ids as $i => $id) {
            if ((int)$id < 1) {
                unset($media_ids[$i]);
            } else {
                $id = (int)$id;
            }
        }

        $query = PostMedias::where("user_id", "=", $User->id)
                       ->whereIn("id", $media_ids);
        

        $res = $query->get();

        $valid_media_ids = [];
        $media_data = [];
        $user_files_dir = storage_path("app/public/" . $User->id );
        
        echo "<pre>";
        foreach ($res as $m) {
            $ext = strtolower(pathinfo($m->filename, PATHINFO_EXTENSION));
            
            // print_r( Storage::get( $m->filename) );
            // print_r( $user_files_dir );
            // print_r( $user_files_dir."/".$m->filename );
            // print_r(pathinfo($m->filename, PATHINFO_EXTENSION));

            if (file_exists($user_files_dir."/".$m->filename) &&
                in_array($ext, ["jpeg", "jpg", "png", "mp4"])) {
                $valid_media_ids[] = $m->id;
                $media_data[$m->id] = $m;
            }
        }
        

        foreach ($media_ids as $i => $id) {
            if (!in_array($id, $valid_media_ids)) {
                unset($media_ids[$i]);
            }
        }
        
        if ($type == "album" && count($media_ids) < 2) {
            $msg = __("At least 2 media file is required for the album post.");
            $Post->data = $msg;
            $Post->save();
            throw new \Exception($msg);
        } else if ($type == "story" && count($media_ids) < 1) {
            $msg = __("Couldn't find selected media for the story");
            $Post->data = $msg;
            $Post->save();
            throw new \Exception($msg);
        } else if ($type == "timeline" && count($media_ids) < 1) {
            $msg = __("Couldn't find selected media for the post");
            $Post->data = $msg;
            $Post->save();
            throw new \Exception($msg);
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



        // Check user permissions
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
                if (!isVideoExtenstionsLoaded()) {
                    $msg = __("It's not possible to post video files right now!");
                    $Post->data = $msg;
                    $Post->save();
                    throw new \Exception($msg);
                }

                $permission = "settings.post_types.".$type."_video";
            } else if (in_array($ext, ["jpg", "jpeg", "png"])) {
                $permission = "settings.post_types.".$type."_photo";
            } else {
                $msg = __("Oops! An error occured. Please try again later!");
                $Post->data = $msg;
                $Post->save();
                throw new \Exception($msg);
            }
            
            $user_permissions = json_decode($User->settings);

            if (isset($user_permissions->post_types->timeline_photo) && $user_permissions->post_types->timeline_photo == 0) {
                if (isset($permission_errors[$permission])) {
                    $msg = $permission_errors[$permission];
                } else {
                    $msg = __("You don't have a permission for this kind of post.");
                }

                $Post->data = $msg;
                $Post->save();
                throw new \Exception($msg);
            }
        }

        
        // Login
        // try {
            $Instagram = self::login($Account);
        // } catch (Exception $e) {
        //     $msg = $e->getMessage();
        //     $Post->data = $msg;
        //     $Post->save();
        //     throw new \Exception($msg);
        // }


        // Caption & First comment
        $caption = $Emojione->shortnameToUnicode($Post->caption);
        $caption = mb_substr($caption, 0, 2200);

        $first_comment = $Emojione->shortnameToUnicode($Post->first_comment);
        $first_comment = mb_substr($first_comment, 0, 2200);


        // Check spintax permission
        if ($User->settingspintax) {
            $caption = Spintax::process($caption);
            $first_comment = Spintax::process($first_comment);
        }
        
        // Location
        $location = null;
        // if ($Post->locationbject) {
        //     $location = @unserialize($Post->locationbject);
        //     if (!$location || !($location instanceof \InstagramAPI\Response\Model\Location)) {
        //         $location = null;
        //     }
        // }


        // try {
            if ($type == "timeline") {
                $media = $media_data[$media_ids[0]];
                $ext = strtolower(pathinfo($media->filename, PATHINFO_EXTENSION));
                $file_path = $user_files_dir."/".$m->filename;

                $metadata = [];
                if ($caption) {
                    $metadata["caption"] = $caption;
                }

                if ($location) {
                    $metadata["location"] = $location;
                }


                
                if (in_array($ext, ["mp4"])) {
                    $resp = $Instagram->timeline->uploadVideo($file_path, $metadata);
                } else {
                    $img = new \InstagramAPI\Media\Photo\InstagramPhoto($file_path, [
                        "targetFeed" => \InstagramAPI\Constants::FEED_TIMELINE,
                        "operation" => \InstagramAPI\Media\InstagramMedia::CROP
                    ]);
                    
                    $resp = $Instagram->timeline->uploadPhoto($img->getFile(), $metadata);
                }
            } else if ($type == "story") {
                $media = $media_data[$media_ids[0]];
                $ext = strtolower(pathinfo($media->filename, PATHINFO_EXTENSION));
                $file_path = $user_files_dir."/".$m->filename;

                if (in_array($ext, ["mp4"])) {
                    $resp = $Instagram->story->uploadVideo($file_path);
                } else {
                    $img = new \InstagramAPI\Media\Photo\InstagramPhoto($file_path, [
                        "targetFeed" => \InstagramAPI\Constants::FEED_STORY,
                        "operation" => \InstagramAPI\Media\InstagramMedia::CROP
                    ]);
                    $resp = $Instagram->story->uploadPhoto($img->getFile());
                }
            } else if ($type == "album") {
                $album_media = [];
                $temp_files_handlers = [];

                foreach ($media_ids as $id) {
                    $media = $media_data[$id];
                    $ext = strtolower(pathinfo($media->filename, PATHINFO_EXTENSION));
                    $file_path = $user_files_dir."/".$media->filename;

                    if (in_array($ext, ["mp4"])) {
                        $media_type = "video";
                    } else {
                        $media_type = "photo";

                        $temp_files_handlers[] = new \InstagramAPI\Media\Photo\InstagramPhoto($file_path, [
                            "targetFeed" => \InstagramAPI\Constants::FEED_TIMELINE_ALBUM,
                            "operation" => \InstagramAPI\Media\InstagramMedia::CROP,
                            "minAspectRatio" => 1.0,
                            "maxAspectRatio" => 1.0
                        ]);
                        $file_path = $temp_files_handlers[count($temp_files_handlers) - 1]->getFile();
                    }

                    $album_media[] = [
                        "type" => $media_type,
                        "file" => $file_path
                    ];
                }

                $metadata = [];
                if ($caption) {
                    $metadata["caption"] = $caption;
                }

                if ($location) {
                    $metadata["location"] = $location;
                }

                $resp = $Instagram->timeline->uploadAlbum($album_media, $metadata);
            }
        // } catch (Exception $e) {
        //     $msg = $e->getMessage();
        //     $msg = explode(":", $msg, 2);
        //     $msg = isset($msg[1]) ? $msg[1] : $msg[0];
        //     $Post->set("data", $msg)
        //          ->update();

        //     throw new \Exception($msg);
        // }

        if (!$resp->isOk()) {
            $msg = __("Something went wrong! Couldn't publish the post.");
            $Post->data = $msg;
            $Post->save();
            throw new \Exception($msg);
        }


        $ig_media_code = $resp->getMedia()->getCode();
        $data = [
            "upload_id" => $resp->getUploadId(),
            "pk" => $resp->getMedia()->getPk(),
            "id" => $resp->getMedia()->getId(),
            "code" => $ig_media_code
        ];


        // Post first comment
        if ($first_comment && in_array($type, ["timeline", "album"])) {
            // try {
                $first_comment_resp = $Instagram->media->comment(
                    $resp->getMedia()->getId(),
                    $first_comment
                );
            // } catch (\Exception $e) {
                // $data["first_comment_fail"] = $e->getMessage();
            // }
        }

        $Post->status = 'published';
        $Post->data = json_encode($data);
        $Post->publish_date = date("Y-m-d H:i:s");
        $Post->save();

        return $ig_media_code;   
    }
}
