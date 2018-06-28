<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\InstagramController;

use DB;

use App\AutoLikeSchedule;
use App\Account;
use App\AutoLikeLog;
use App\User;


class AutoLikeController extends Controller
{
    /**
	 * Add cron task to like new posts
	 */
    function runTask()
	{

		// DB::enableQueryLog();

		// Get auto like scheduled tasks
	    $Schedules = AutoLikeSchedule::where("is_active", "=", 1)
	              ->whereDate("schedule_date", "<=", \Carbon\Carbon::now() )
	              ->whereDate("end_date", ">=", \Carbon\Carbon::now() )
	              ->orderBy("last_action_date", "ASC")
	              ->limit(10) // required to prevent server overload
	              ->get();

	    // dd(DB::getQueryLog());

	    
	    // echo "<pre>";
	    // print_r($Schedules);
	    // echo "</pre>";
	    // exit;

	    if (!$Schedules || ( $Schedules && $Schedules->count() < 1 ) ) {
	        // There is not any active schedule
	        return "false";
	    }

	    // echo "<pre>";
	    // print_r($Schedules);
	    // echo "<pre>";
	    // exit;

	    // $settings = namespace\settings();

	    // // Random delays between actions
	    // $random_delay = 0;
	    // if ($settings->dataandom_delay")) {
	    //     $random_delay = rand(0, 300);
	    // }

	    // Speeds
	    $default_speeds = [
	        "very_slow" => 1,
	        "slow" => 2,
	        "medium" => 3,
	        "fast" => 4,
	        "very_fast" => 5,
	    ];
	    // $speeds = $settings->datapeeds");
	    $speeds = null;

	    if (empty($speeds)) {
	        $speeds = [];
	    } else {
	        $speeds = json_decode(json_encode($speeds), true);
	    }

	    $speeds = array_merge($default_speeds, $speeds);

	    foreach ($Schedules as $task) {
	        $Log = new AutoLikeLog;
	        
	        // Start data validation
	        $Account = Account::where("id",$task->account_id)->first();
			if (!$Account 
				|| ( $Account && $Account->count() < 1 ) 
				|| $Account->login_required ) {
	            // Account is either removed (unexected, external factors)
	            // Or login required for this account
	            // Deactivate schedule
	            $task->is_active = 0;
				$task->save();
	            continue;
	        }
	        
	        $User = User::where("id",$task->user_id)->first();
			if (!$User || ( $User && $User->count() < 1 ) || !$User->is_active || $User->isExpired() ) {
	            // User is not valid
	            // Deactivate schedule
	            $task->is_active = 0;
				$task->save();
	            continue;
	        }

	    	if ($User->id != $Account->user_id) {
	            // Unexpected, data modified by external factors
	            // Deactivate schedule
	            $task->is_active = 0;
				$task->save();
	            continue;
	        }

	        // Check user access to the module
	        // $user_modules = $User->settingsodules");
	        // if (!is_array($user_modules) || !in_array(IDNAME, $user_modules)) {
	        //     // Module is not accessible to this user
	        //     // Deactivate schedule
	        //     $task->set("is_active", 0)->save();

	        //     // Log data
	        //     $Log->set("data.error.msg", "Activity has been stopped")
	        //         ->set("data.error.details", "Module is not accessible to your account.")
	        //         ->save();
	        //     continue;
	        // }


	        // Define feed type
	        $feed_type = "target";
	        // if ($task->timeline_feed.nabled")) {
	        //     $tf_schedule = $task->schedule_date;
	        //     if (!$tf_schedule) {
	        //         $tf_schedule = date("Y-m-d H:i:s");
	        //     }

	        //     if ($tf_schedule <= date("Y-m-d H:i:s")) {
	        //         $feed_type = "timeline";

	        //         $refresh_interval = (int)$settings->dataimeline.refresh_interval");
	        //         if ($refresh_interval < 0) {
	        //             $refresh_interval = 1800;
	        //         }

	        //         $tf_schedule 
	        //             = date("Y-m-d H:i:s", time() + $refresh_interval + $random_delay);

	        //         $task->set("timeline_feed.schedule_date", $tf_schedule)
	        //            ->save();
	        //     }   
	        // }

	        // Calculate next schedule datetime...
	        if (isset($speeds[$task->speed]) && (int)$speeds[$task->speed] > 0) {
	            $speed = (int)$speeds[$task->speed];
	            $delta = round(3600/$speed) + $random_delay;
	        } else {
	            $delta = rand(720, 7200);
	        }


	        $next_schedule = date("Y-m-d H:i:s", time() + $delta);

	        if ($feed_type == "target" && !empty($tf_schedule) && $tf_schedule < $next_schedule) {
	            // Next schedule is for timeline feed
	            $next_schedule = $tf_schedule;
	        }

	        if ($task->daily_pause) {
	            $pause_from = date("Y-m-d")." ".$task->daily_pause_from;
	            $pause_to = date("Y-m-d")." ".$task->daily_pause_to;
	            if ($pause_to <= $pause_from) {
	                // next day
	                $pause_to = date("Y-m-d", time() + 86400)." ".$task->daily_pause_to;
	            }

	            if ($next_schedule > $pause_to) {
	                // Today's pause interval is over
	                $pause_from = date("Y-m-d H:i:s", strtotime($pause_from) + 86400);
	                $pause_to = date("Y-m-d H:i:s", strtotime($pause_to) + 86400);
	            }

	            if ($next_schedule >= $pause_from && $next_schedule <= $pause_to) {
	                $next_schedule = $pause_to;
	            }
	        }

			echo "\n";
			print_r(\Carbon\Carbon::now());
			print_r($next_schedule);
			echo "\n\n\n";
			exit;

	        $task->schedule_date = $next_schedule;
	        $task->last_action_date = \Carbon\Carbon::now();
	        $task->save();

	        // if ($feed_type == "timeline" && $tf_schedule <= $next_schedule) {
	        //     // Force next schedule for target
	        //     $tf_schedule = date("Y-m-d H:i:s", strtotime($next_schedule) + 59);
	        //     $task->set("timeline_feed.schedule_date", $tf_schedule)
	        //        ->save();
	        // }



	        if ($User->id != $Account->user_id) {
	            // Unexpected, data modified by external factors
	            // Deactivate schedule
	            $task->is_active = 0;
				$task->save();
	            continue;
	        }
			
			
			$Instagram = null;
			
	        // Login into the account
	        // try {
	            $Instagram = InstagramController::login($Account);
			// } catch (\Exception $e) {
			//     // Couldn't login into the account

			//     // Deactivate schedule
			//     $task->is_active = 0;
			// 	$task->save();

			//     // Log data
			//     $Log->set("data", $e->getMessage())
			//         ->save();

			//     continue;
			// }

			// Logged in successfully
	        // Now script will try to get feed and like new post
	        // And will log result

	        if ($feed_type == "target") {
	            self::_like_from_target($task, $Instagram, $User, $Account);
	        } else if ($feed_type == "timeline") {
	            self::_like_from_timeline($task, $Instagram, $User, $Account);
	        }
	    }
	}

	/**
	 * Like actions for the target feed
	 * @param  __NAMESPACE__\ScheduleModel $sc        Schedule Model
	 * @param  \InstagramController $Instagram Instagram Controller
	 * @return null            
	 */
	function _like_from_target($task, $Instagram, User $User, Account $Account)
	{
	    $Log = new AutoLikeLog;
	    // Create a action log (not save yet)
        $Log->user_id = $User->id;
		$Log->account_id = $Account->id;
		$Log->status = "error";


	    $targets = @json_decode(json_encode(array(
	        	array(
	        		'id' => 'streetstyle',
	        		'type' => 'hashtag'
	        	),
	        	array(
	        		'id' => 'instafashion',
	        		'type' => 'hashtag'
	        	),
	        	array(
	        		'id' => 'outfit',
	        		'type' => 'hashtag'
	        	),
	        	array(
	        		'id' => 'stylish',
	        		'type' => 'hashtag'
	        	),
	        	array(
	        		'id' => 'fashion',
	        		'type' => 'hashtag'
	        	)
	        )));
	        // $targets = @json_decode($task->target);
	    	// $targets = @json_decode($task->target);

	    if (!$targets) {
            // Unexpected, data modified by external factors
            // Deactivate schedule
            $task->is_active = 0;
			$task->save();
        }

	    // if (count($targets) < 1) {
	    //     // Couldn't find any target for the feed
	    //     // Log data
	    //     $Log->set("data.error.msg", "Couldn't find any target to search for the feed.")
	    //         ->save();
	    //     return false;
	    // }

	    // Select random target from the defined target collection
        $i = rand(0, count($targets) - 1);
        $target = $targets[$i];

		// echo "<pre>";
		// print_r($target);
		// exit;

	    if (empty($target->type) || empty($target->id) ||
	            !in_array($target->type, ["hashtag", "location", "people"])) 
        {
            // Unexpected invalid target, 
            // data modified by external factors
            $task->is_active = 0;
			$task->save();
            // continue;
        }


	    $Log->data = json_encode([
	    	'trigger' => $target
	    ]);


	    // Find media to like
	    $media_id = null;
	    $media_code = null;
	    $media_type = null;
	    $media_thumb = null;
	    $user_pk = null;
	    $user_username = null;
	    $user_full_name = null;

	    // Generate a random rank token.
	    $rank_token = \InstagramAPI\Signatures::generateUUID();
	    
	    $like_module = "feed_timeline";
	    $like_extra_data = [];
	    if ($target->type == "hashtag") {
	        $hashtag = str_replace("#", "", trim($target->id));
	        if (!$hashtag) {
	            return false;
	        }

	        $like_module = "feed_contextual_hashtag";
	        $like_extra_data["hashtag"] = $hashtag;

	        // try {
	            $feed = $Instagram->hashtag->getFeed(
	                $hashtag,
	                $rank_token);
			// } catch (\Exception $e) {
			//     // Couldn't get instagram feed related to the hashtag
			//     // Log data
			//     $msg = $e->getMessage();
			//     $msg = explode(":", $msg, 2);
			//     $msg = isset($msg[1]) ? $msg[1] : $msg[0];

			// 	$Log->data = json_encode([
			//     	'error' => [
			//     		'msg' => "Couldn't get the feed",
			//     		'details' => $msg
			//     	]
			//     ]);
			// 	$Log->save();
			//     return false;
			// }

	        $items = $feed->getItems();
	    } else if ($target->type == "location") {
	        $like_module = "feed_contextual_location";
	        $like_extra_data['location_id'] = $target->id;

	        try {
	            $feed = $Instagram->location->getFeed(
	                $target->id,
	                $rank_token);
	        } catch (\Exception $e) {
	            // Couldn't get instagram feed related to the hashtag
	            // Log data
	            $msg = $e->getMessage();
	            $msg = explode(":", $msg, 2);
	            $msg = isset($msg[1]) ? $msg[1] : $msg[0];

	            $Log->set("data.error.msg", "Couldn't get the feed")
	                ->set("data.error.details", $msg)
	                ->save();
	            return false;
	        }

	        $items = $feed->getItems();
	    } else if ($target->type == "people") {
	        $like_module = "profile";
	        $like_extra_data['username'] = $target->value;
	        $like_extra_data['user_id'] = $target->id;

	        try {
	            $feed = $Instagram->timeline->getUserFeed($target->id);
	        } catch (\Exception $e) {
	            // Couldn't get instagram feed related to the user 
	            // Log data
	            $msg = $e->getMessage();
	            $msg = explode(":", $msg, 2);
	            $msg = isset($msg[1]) ? $msg[1] : $msg[0];

	            $Log->set("data.error.msg", "Couldn't get the feed")
	                ->set("data.error.details", $msg)
	                ->save();
	            return false;
	        }

	        $items = $feed->getItems();
	        shuffle($items);
	    }

	    if (count($items) < 1) {
	        // Invalid
	        return false;
	    }

	    foreach ($items as $item) {
	        if ($item->getId() && !$item->getHasLiked())  {
	        	
	        	$Log = new AutoLikeLog;
			    $Log->user_id = $task->user_id;
				$Log->account_id = $task->account_id;
				$Log->liked_media_code = $item->getCode();
				$Log->status = 'success';
				$Log->data = ' ';
				$Log->save();
	            
	            if (!isset($_log)) {
	                // Found the media to like
	                $media_id = $item->getId();
	                $media_code = $item->getCode();
	                $media_type = $item->getMediaType();
	                $media_thumb = self::_get_media_thumb_igitem($item);
	                $user_pk = $item->getUser()->getPk();
	                $user_username = $item->getUser()->getUsername();
	                $user_full_name = $item->getUser()->getFullName();
	                break;
	            }
	        }
	    }

	    if (empty($media_id)) {
	    	$Log->data = json_encode([
		    	'error' => [
		    		'msg' => "Couldn't find the new media to like",
		    		'details' => null
		    	]
		    ]);
			$Log->save();

	        return false;
	    }


	    // New media found
	    // Like it!
	    try {
	        $resp = $Instagram->media->like(
	            $media_id,
	            $like_module,
	            $like_extra_data);
	    } catch (\Exception $e) {
	        $msg = $e->getMessage();
	        $msg = explode(":", $msg, 2);
	        $msg = isset($msg[1]) ? $msg[1] : $msg[0];

	        $Log->data = json_encode([
		    	'error' => [
		    		'msg' => "Something went wrong",
		    		'details' => $msg
		    	]
		    ]);
			$Log->save();

	        return false;
	    }

	    if (!$resp->isOk()) {
	    	$Log->data = json_encode([
		    	'error' => [
		    		'msg' => "Couldn't like the new media",
		    		'details' => "Something went wrong"
		    	]
		    ]);
			$Log->save();

	        return false;   
	    }


	    // Liked new media successfully
	    $Log->status = "success";
	    $Log->data = json_encode(
	    	[
		    	"liked", [
		            "media_id" => $media_id,
		            "media_code" => $media_code,
		            "media_type" => $media_type,
		            "media_thumb" => $media_thumb,
		            "user" => [
		                "pk" => $user_pk,
		                "username" => $user_username,
		                "full_name" => $user_full_name
		            ]
		        ]
		    ]
	    );
	    $Log->liked_media_code = $media_code;

	    $Log->save();

	    echo "exito";
	}




	/**
	 * Like actions for the target feed
	 * @param  __NAMESPACE__\ScheduleModel $sc        Schedule Model
	 * @param  \InstagramController $Instagram Instagram Controller
	 * @return null            
	 */
	function _like_from_timeline($sc, $Instagram)
	{
	    $Log = new LogModel;
	    $Log->set("user_id", $task->user_id)
	        ->set("account_id", $task->account_id)
	        ->set("status", "error");

	    $Log->set("data.trigger", ["type" => "timeline_feed"]);



	    $settings = namespace\settings();
	    $max = (int)$settings->get("data.timeline.max_like");
	    if ($max < 1) {
	        $max = 1;
	    }


	    $items = [];
	    $loop = true;
	    $round = 1;
	    $max_id = null;

	    while ($loop) {
	        try {
	            $feed = $Instagram->timeline->getTimelineFeed();
	        } catch (\Exception $e) {
	            // Couldn't get instagram feed related to the hashtag
	            $loop = false;

	            if ($round == 1) {
	                // Log data
	                $msg = $e->getMessage();
	                $msg = explode(":", $msg, 2);
	                $msg = isset($msg[1]) ? $msg[1] : $msg[0];

	                $Log->set("data.error.msg", "Couldn't get the timeline feed")
	                    ->set("data.error.details", $msg)
	                    ->save();
	                return false;
	            }
	        }

	        if (count($feed->getFeedItems()) < 1) {
	            // Invalid
	            $loop = false;
	        }

	        $items = array_merge($items, $feed->getFeedItems());
	        $round++;
	        $max_id = $feed->getNextMaxId();

	        if (!$max_id || count($items) >= $max || $round >= 5) {
	            $loop = false;
	        }
	    }


	    if (count($items) < 1) {
	        return false;
	    }
	    

	    $items = array_reverse($items);
	    $items = array_slice($items, 0, $max);

	    $like_count = 0;
	    foreach ($items as $item) {
	        $item = $item->getMediaOrAd();

	        if (!$item) {
	            continue;
	        }

	        if ($item->getId() && !$item->getHasLiked())  {
	            $_log = new LogModel([
	                "user_id" => $task->user_id,
	                "account_id" => $task->account_id,
	                "liked_media_code" => $item->getCode(),
	                "status" => "success"
	            ]);

	            if (!$_log->isAvailable()) {
	                // Found the media to like
	                try {
	                    $resp = $Instagram->media->like($item->getId());
	                } catch (\Exception $e) {
	                    continue;
	                }

	                if (!$resp->isOk()) {
	                    continue;   
	                }


	                $media_thumb = self::_get_media_thumb_igitem($item);


	                // Liked new media successfully
	                $_log->set("status", "success")
	                     ->set("account_id", $task->account_id)
	                     ->set("user_id", $task->user_id)
	                     ->set("data.trigger", ["type" => "timeline_feed"])
	                     ->set("data.liked", [
	                        "media_id" => $item->getId(),
	                        "media_code" => $item->getCode(),
	                        "media_type" => $item->getMediaType(),
	                        "media_thumb" => $media_thumb,
	                        "user" => [
	                            "pk" => $item->getUser()->getPk(),
	                            "username" => $item->getUser()->getUsername(),
	                            "full_name" => $item->getUser()->getFullName()
	                        ]])
	                     ->set("liked_media_code", $item->getCode())
	                     ->save();

	                $like_count++;
	            }
	        }
	    }

	    if ($like_count > 0) {
	        return true;
	    }

	    $Log->set("data.error.msg", "Couldn't find any new media to like in the timeline feed")
	        ->save();
	    return false; 
	}



	/**
	 * Get media thumb url from the Instagram feed item
	 * @param  stdObject $item Instagram feed item
	 * @return string|null       
	 */
	function _get_media_thumb_igitem($item)
	{
	    $media_thumb = null;

	    $media_type = empty($item->getMediaType()) ? null : $item->getMediaType();

	    if ($media_type == 1 || $media_type == 2) {
	        // Photo (1) OR Video (2)
	        $media_thumb = $item->getImageVersions2()->getCandidates()[0]->getUrl();
	    } else if ($media_type == 8) {
	        // ALbum
	        $media_thumb = $item->getCarouselMedia()[0]->getImageVersions2()->getCandidates()[0]->getUrl();
	    }    

	    return $media_thumb;
	}
}
