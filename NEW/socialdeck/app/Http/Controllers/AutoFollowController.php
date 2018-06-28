<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Account;

use App\AutoFollowLog;
use App\AutoFollowSchedules;
use App\Http\Controllers\InstagramController;

class AutoFollowController extends Controller
{
    const IDNAME = 'auto-follow';

    public function index(Request $request){
    	$AuthUser = User::where('id', '=', 1)->first();
        $AuthUser->settings = json_decode($AuthUser->settings);
        $AuthUser->preferences = json_decode($AuthUser->preferences);

		// $AuthUser = $this->getVariable("AuthUser");
		$idname = self::IDNAME;

		// // Auth
		// if (!$AuthUser){
		//     header("Location: ".APPURL."/login");
		//     exit;
		// } else if ($AuthUser->isExpired()) {
		//     header("Location: ".APPURL."/expired");
		//     exit;
		// }

		$user_modules = $AuthUser->settings->modules;

		// if (!is_array($user_modules) || !in_array(self::IDNAME, $user_modules)) {
		//     // Module is not accessible to this user
		//     header("Location: ".APPURL."/post");
		//     exit;
		// }


		// Get accounts
		$Accounts = Account::where("user_id", "=", $AuthUser->id)
					->orderBy("id","DESC")
					->get();
					// ->setPageSize(20)
		         	// ->setPage(\Input::get("page"))

		// $this->view(PLUGINS_PATH."/".self::IDNAME."/views/index.php", null);

		// $Accounts = Account::where("user_id", "=", $AuthUser->id)

		$req = array(
			'aid' => null,	
			'ref' => null
		);

    	return view("auto-follow", compact('AuthUser', 'idname', 'Accounts', 'req'));
    }

    public function log(Request $request,$account_id){}
    
    public function schedule(Request $request,$account_id){
    	
        $AuthUser = User::where('id', '=', 1)->first();
        $AuthUser->settings = json_decode($AuthUser->settings);
        $AuthUser->preferences = json_decode($AuthUser->preferences);

        $idname = self::IDNAME;

        // $Route = $this->getVariable("Route");
        

        // Auth
        // if (!$AuthUser){
        //     header("Location: ".APPURL."/login");
        //     exit;
        // } else if ($AuthUser->isExpired()) {
        //     header("Location: ".APPURL."/expired");
        //     exit;
        // }

        $user_modules = $AuthUser->settings->modules;
        
        // if (!is_array($user_modules) || !in_array($this->getVariable("idname"), $user_modules)) {
        //     // Module is not accessible to this user
        //     header("Location: ".APPURL."/post");
        //     exit;
        // }


        // Get account
        $Account = Account::where('id', $account_id)->first();
        

        // Si no es su cuenta lo redirige a su cuenta
        // if( $Account == null || 
        //     $Account->user_id != $AuthUser->id ) 
        // {
        //     header("Location: ".APPURL."/e/".$this->getVariable("idname"));
        //     exit;
        // }
        

        // Get Schedule
        
        $Schedule = new AutoFollowSchedules();

        // echo "<pre>";
        // print_r($request->all());
        // exit;
  //       (
		//     [_token] => NQQcRckggwdxsUbnnD23AfjNYIXQXqZxOchWo6hV
		//     [action] => save
		//     [type] => hashtag
		//     [search] => https://www.instagram.com/explore/tags/streetfashion/
		//     [speed] => auto
		//     [is_active] => 1
		//     [daily-pause-from] => 02:00
		//     [daily-pause-to] => 02:00
		// )

        if ($request->input("action") == "search") {
	        // self::search($request, $AuthUser, $Account);
        } else if ($request->input("action") == "save") {
	        self::save($request, $AuthUser, $Account);
		}
        
        

        // $this->setVariable("idname", "auto-comment");
        // $this->setVariable("Account", $Account);
        // $this->setVariable("Schedule", $Schedule);

        // $this->view(PLUGINS_PATH."/".$this->getVariable("idname")."/views/schedule.php", null);
        return view('auto-follow-schedule', compact('AuthUser','idname','Account','Schedule'));
    }


    /**
     * Search hashtags, people, locations
     * @return mixed 
     */
    // private function search()
    // {
    //     $this->resp->result = 0;
    //     $AuthUser = $this->getVariable("AuthUser");
    //     $Account = $this->getVariable("Account");

    //     $query = \Input::request("q");
    //     if (!$query) {
    //         $this->resp->msg = __("Missing some of required data.");
    //         $this->jsonecho();
    //     }

    //     $type = \Input::request("type");
    //     if (!in_array($type, ["hashtag", "location", "people"])) {
    //         $this->resp->msg = __("Invalid parameter");
    //         $this->jsonecho();   
    //     }

    //     // Login
    //     try {
    //         $Instagram = \InstagramController::login($Account);
    //     } catch (\Exception $e) {
    //         $this->resp->msg = $e->getMessage();
    //         $this->jsonecho();   
    //     }



    //     $this->resp->items = [];

    //     // Get data
    //     try {
    //         if ($type == "hashtag") {
    //             $search_result = $Instagram->hashtag->search($query);
    //             if (isset($search_result->results)) {
    //                 foreach ($search_result->results as $r) {
    //                     $this->resp->items[] = [
    //                         "value" => $r->name,
    //                         "data" => [
    //                             "sub" => n__("%s public post", "%s public posts", $r->media_count, $r->media_count),
    //                             "id" => str_replace("#", "", $r->name)
    //                         ]
    //                     ];
    //                 }
    //             }
    //         } else if ($type == "location") {
    //             $search_result = $Instagram->location->searchFacebook($query);
    //             if (isset($search_result->items)) {
    //                 foreach ($search_result->items as $r) {
    //                     $this->resp->items[] = [
    //                         "value" => $r->location->name,
    //                         "data" => [
    //                             "sub" => false,
    //                             "id" => $r->location->facebook_places_id
    //                         ]
    //                     ];
    //                 }
    //             }
    //         } else if ($type == "people") {
    //             $search_result = $Instagram->people->search($query);
    //             if (isset($search_result->users)) {
    //                 foreach ($search_result->users as $r) {
    //                     $this->resp->items[] = [
    //                         "value" => $r->username,
    //                         "data" => [
    //                             "sub" => $r->full_name,
    //                             "id" => $r->pk
    //                         ]
    //                     ];
    //                 }
    //             }
    //         }
    //     } catch (\Exception $e) {
    //         $this->resp->msg = $e->getMessage();
    //         $this->jsonecho();   
    //     }


    //     $this->resp->result = 1;
    //     $this->jsonecho();
    // }


    /**
     * Save schedule
     * @return mixed 
     */
    private function save(Request $request, $AuthUser, $Account)
    {
        $resp = new \stdClass;
        $resp->result = 0;
        // $AuthUser = $this->getVariable("AuthUser");
        // $Account = $this->getVariable("Account");
        // $Schedule = $this->getVariable("Schedule");

        // Targets
        $targets = @json_decode($request->input('target'));
        if (!$targets) {
            $targets = [];
        }

        $valid_targets = [];
        foreach ($targets as $t) {
            if (isset($t->type, $t->value, $t->id) && 
                in_array($t->type, ["hashtag", "location", "people"])) 
            {
                $valid_targets[] = [
                    "type" => $t->type,
                    "id" => $t->id,
                    "value" => $t->value
                ];
            }
        }
        $target = json_encode($valid_targets);

        // Emojione Client
        $Emojione = new \Emojione\Client(new \Emojione\Ruleset());
        // Comments
        $raw_comments = @json_decode($request->input('comments'));
        $valid_comments = [];
        if ($raw_comments) {
            foreach ($raw_comments as $c) {
                $valid_comments[] = $Emojione->toShort($c);
            }
        }
        $comments = json_encode($valid_comments);

        // Speed
        $speed = (int)$request->input('speed');
        if ($speed < 0 || $speed > 5) {
            $speed = 0;
        }
        
        $is_active = $request->input('is_active') ? 1 : 0;
        $end_date = count($valid_targets) && count($valid_comments) > 0 
                  ? "2030-12-12 23:59:59" : date("Y-m-d H:i:s");

        // $Schedule->set("user_id", $AuthUser->get("id"))
        //          ->set("target", $target)
        //          ->set("account_id", $Account->id)
        //          ->set("end_date", $end_date)
                  
        //          ->set("comments", $comments)
        //          ->set("speed", $speed)
        //          ->set("is_active", $is_active)
        //          ->set("schedule_date", date("Y-m-d H:i:s"))
        //          ->set("last_action_date", date("Y-m-d H:i:s"))
        //          ->save();
        $Schedule = new AutoFollowSchedules();
		$Schedule->daily_pause = 0;
		$Schedule->schedule_date = date("Y-m-d H:i:s");
		$Schedule->last_action_date = date("Y-m-d H:i:s");
		$Schedule->end_date = $end_date;
		$Schedule->data = $request->input('search');
		// $Schedule->target = $request->input('type');
		$Schedule->target = $target;

		$Schedule->account_id = $Account->id;
		$Schedule->user_id = $Account->user_id;

		$Schedule->speed = $speed;
		$Schedule->is_active = $is_active;
		$Schedule->daily_pause_from = $request->input('daily-pause-from');
		$Schedule->daily_pause_to = $request->input('daily-pause-to');

		$Schedule->save();

        $resp->msg = __("Changes saved!");
        $resp->result = 1;
        return json_encode($resp);
        return json_encode($resp);
    }

    function cronJob() {
	    
	    
	    // Get auto follow schedules
	    $Schedules = AutoFollowSchedules::where("is_active", "=", 1)
	              // ->whereDate("schedule_date", "<=", date("Y-m-d H:i:s"))
	              // ->whereDate("end_date", ">=", date("Y-m-d H:i:s"))
	              ->orderBy("last_action_date", "ASC")
	              ->limit(10) // required to prevent server overload
	              // ->setPage(1)
	              ->get();

	 // 	\DB::listen(function($Schedules) {
		//     print_r($Schedules);
		// });

        
	    if (count($Schedules) < 1) {
	    	return false;
	    }


	    // $settings = self::getGeneralSettings();
	    $settings = null;
	    $default_speeds = [
	        "very_slow" => 1,
	        "slow" => 2,
	        "medium" => 3,
	        "fast" => 4,
	        "very_fast" => 5,
	    ];
	    // $speeds = $settings->data->speeds;
	    if (empty($speeds)) {
	        $speeds = [];
	    } else {
	        $speeds = json_decode(json_encode($speeds), true);
	    }
	    

	    $speeds = array_merge($default_speeds, $speeds);


	    foreach ($Schedules as $task) {
		    

	        $Log = new AutoFollowLog;
	        
	        $Account = Account::where('id', $task->account_id)->first();
	        $User = User::where('id', $task->user_id)->first();
		    
		    

	        // Calculate next schedule datetime...
	        if (isset($speeds[$task->speed]) && (int)$speeds[$task->speed] > 0) {
	            $speed = (int)$speeds[$task->speed];
	            $delta = round(3600/$speed);

	            if ($settings->data->random_delay) {
	                $delay = rand(0, 300);
	                $delta += $delay;
	            }
	        } else {
	            $delta = rand(720, 7200);
	        }
	        $next_schedule = date("Y-m-d H:i:s", time() + $delta);
		    

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
		    
		    
	        $task->schedule_date = $next_schedule;
	        $task->last_action_date = date("Y-m-d H:i:s");
	        $task->save();


	    

	        // Set default values for the log...
			$Log->user_id = $User->id;
			$Log->account_id = $Account->id;
			$Log->status = "error";

	        


	        // Check account
	        if ($Account == null || $Account->login_required) {
	            // Account is either removed (unexected, external factors)
	            // Or login required for this account
	            // Deactivate schedule
	            $task->is_active = 0;
	            $task->save();

	            continue;
	        }


	        // Check user account
	        if ($User == null || !$User->is_active 
	        	// || $User->isExpired()
	        ) {
	            // User is not valid
	            // Deactivate schedule
	            $task->is_active = 0;
	            $task->save();

	            // Log data
				$Log->data = json_encode(['error' => 
					[
						'msg' => "Activity has been stopped",
						'details' => "Re-login is required for the account."
					]
				]);
				$Log->save();

	            continue;
	        }
		    
		    

	        if ($User->id != $Account->user_id) {
	            // Unexpected, data modified by external factors
	            // Deactivate schedule
	            $task->is_active = 0;
	            $task->save();
	            continue;
	        }


	        
	        // Check targets
	        // $targets = @json_decode($task->target);
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
	        // $targets = ;
		    

	        if (!$targets) {
	            // Unexpected, data modified by external factors
	            // Deactivate schedule
	            $task->is_active = 0;
	            $task->save();
	            continue;
	        }

	        
		    
	        // Select random target
	        $i = rand(0, count($targets) - 1);
	        $target = $targets[$i];


	        // Check selected target
	        if (empty($target->type) ||
	            empty($target->id) ||
	            !in_array($target->type, ["hashtag", "location", "people"])) 
	        {
	            // Unexpected, data modified by external factors
	            continue;   
	        }
		    

	        // try {
	            $Instagram = InstagramController::login($Account);
	        // } catch (\Exception $e) {
	            // Couldn't login into the account
	        //     $Account->refresh();

	        //     // Log data
	        //     if ($Account->login_required) {
	        //         $task->set("is_active", 0)->save();
	        //         $Log->set("data.error.msg", "Activity has been stopped");
	        //     } else {
	        //         $Log->set("data.error.msg", "Action re-scheduled");
	        //     }
	        //     $Log->set("data.error.details", $e->getMessage())
	        //         ->save();

	        //     continue;
	        // }


	        // Logged in successfully
	        // Now script will try to get feed and follow new user
	        // And will log result
	        // $Log->set("data.trigger", $target);


	        // Find username to follow
	        $follow_pk = null;
	        $follow_username = null;
	        $follow_full_name = null;
	        $follow_profile_pic_url = null;

	        // Generate a random rank token.
	        $rank_token = \InstagramAPI\Signatures::generateUUID();

		    // echo "<pre>";
	     //    print_r($next_schedule);
	     //    print_r($target);
	     //    exit;

	        if ($target->type == "hashtag") {


	            // try {
	                $feed = $Instagram->hashtag->getFeed(
	                    str_replace("#", "", trim($target->id)),
	                    $rank_token);
	            // } catch (\Exception $e) {
	            //     // Couldn't get instagram feed related to the hashtag
	            //     // Log data
	            //     $msg = $e->getMessage();
	            //     $msg = explode(":", $msg, 2);
	            //     $msg = isset($msg[1]) ? $msg[1] : $msg[0];

	            //     $Log->set("data.error.msg", "Couldn't get the feed")
	            //         ->set("data.error.details", $msg)
	            //         ->save();
	            //     continue;
	            // }

	            if (count($feed->getItems()) < 1) {
	                // Invalid
	                continue;
	            }


	            foreach ($feed->getItems() as $item) {
	                if (empty($item->getUser()->getFriendshipStatus()->getFollowing()) && 
	                    empty($item->getUser()->getFriendshipStatus()->getOutgoingRequest()) &&
	                    $item->getUser()->getPk() != $Account->instagram_id) 
	                {
	                    // $_log = new LogModel([
	                    //     "user_id" => $User->get("id"),
	                    //     "account_id" => $Account->id,
	                    //     "followed_user_pk" => $item->getUser()->getPk(),
	                    //     "status" => "success"
	                    // ]);

	                    // if (!$_log->isAvailable()) {
	                        // Found new user
	                        $follow_pk = $item->getUser()->getPk();
	                        $follow_username = $item->getUser()->getUsername();
	                        $follow_full_name = $item->getUser()->getFullName();
	                        $follow_profile_pic_url = $item->getUser()->getProfilePicUrl();

	                    //     break;
	                    // }
	                }
	            }
	        } else if ($target->type == "location") {
	            try {
	                $feed = $Instagram->location->getFeed(
	                    $target->id, 
	                    $rank_token);
	            } catch (\Exception $e) {
	                // Couldn't get instagram feed related to the location id
	                // Log data
	                $msg = $e->getMessage();
	                $msg = explode(":", $msg, 2);
	                $msg = isset($msg[1]) ? $msg[1] : $msg[0];

	                $Log->set("data.error.msg", "Couldn't get the feed")
	                    ->set("data.error.details", $msg)
	                    ->save();
	                continue;
	            }

	            if (count($feed->getItems()) < 1) {
	                // Invalid
	                continue;
	            }

	            foreach ($feed->getItems() as $item) {
	                if (empty($item->getUser()->getFriendshipStatus()->getFollowing()) && 
	                    empty($item->getUser()->getFriendshipStatus()->getOutgoingRequest()) &&
	                    $item->getUser()->getPk() != $Account->instagram_id) 
	                {
	                    $_log = new LogModel([
	                        "user_id" => $User->get("id"),
	                        "account_id" => $Account->id,
	                        "followed_user_pk" => $item->getUser()->getPk(),
	                        "status" => "success"
	                    ]);

	                    if (!$_log->isAvailable()) {
	                        // Found new user
	                        $follow_pk = $item->getUser()->getPk();
	                        $follow_username = $item->getUser()->getUsername();
	                        $follow_full_name = $item->getUser()->getFullName();
	                        $follow_profile_pic_url = $item->getUser()->getProfilePicUrl();

	                        break;
	                    }
	                }
	            }
	        } else if ($target->type == "people") {
	            $round = 1;
	            $loop = true;
	            $next_max_id = null;

	            while ($loop) {
	                try {
	                    $feed = $Instagram->people->getFollowers(
	                        $target->id,
	                        $rank_token, 
	                        null, 
	                        $next_max_id);
	                } catch (\Exception $e) {
	                    // Couldn't get instagram feed related to the user id
	                    $loop = false;

	                    if ($round == 1) {
	                        // Log data
	                        $msg = $e->getMessage();
	                        $msg = explode(":", $msg, 2);
	                        $msg = isset($msg[1]) ? $msg[1] : $msg[0];

	                        $Log->set("data.error.msg", "Couldn't get the feed")
	                            ->set("data.error.details", $msg)
	                            ->save();
	                    }

	                    continue 2;
	                }

	                if (count($feed->getUsers()) < 1) {
	                    // Invalid
	                    $loop = false;
	                    continue 2;
	                }

	                // Get friendship statuses
	                $user_ids = [];
	                foreach ($feed->getUsers() as $user) {
	                    $user_ids[] = $user->getPk();
	                }

	                try {
	                    $friendships = $Instagram->people->getFriendships($user_ids);
	                } catch (\Exception $e) {
	                    // Couldn't get instagram friendship statuses
	                    $loop = false;

	                    if ($round == 1) {
	                        // Log data
	                        $Log->set("data.error.msg", "Couldn't get the friendship statuses")
	                            ->set("data.error.details", $e->getMessage())
	                            ->save();
	                    }

	                    continue 2;
	                }

	                $followings = [];
	                foreach ($friendships->getFriendshipStatuses()->getData() as $pk => $fs) {
	                    if ($fs->getOutgoingRequest() || $fs->getFollowing()) {
	                        $followings[] = $pk;
	                    }
	                }


	                foreach ($feed->getUsers() as $user) {
	                    if (!in_array($user->getPk(), $followings) &&
	                        $user->getPk() != $Account->instagram_id) 
	                    {
	                        $_log = new LogModel([
	                            "user_id" => $User->get("id"),
	                            "account_id" => $Account->id,
	                            "followed_user_pk" => $user->getPk(),
	                            "status" => "success"
	                        ]);

	                        if (!$_log->isAvailable()) {
	                            // Found new user
	                            $follow_pk = $user->getPk();
	                            $follow_username = $user->getUsername();
	                            $follow_full_name = $user->getFullName();
	                            $follow_profile_pic_url = $user->getProfilePicUrl();

	                            break 2;
	                        }
	                    }
	                }
	                
	                $round++;
	                $next_max_id = $feed->getNextMaxId();
	                if ($round >= 5 || !empty($follow_pk) || $next_max_id === null) {
	                    $loop = false;
	                }
	            }
	        }

	        if (empty($follow_pk)) {
	        	$Log->data = json_encode(['error' => 
					[
						'msg' => "Couldn't find new user to follow",
						'details' => "-"
					]
				]);
	            $Log->save();
	            continue;
	        }


	        // New user found to follow
	        // try {
	            $resp = $Instagram->people->follow($follow_pk);
	        // } catch (\Exception $e) {
	        //     $msg = $e->getMessage();
	        //     $msg = explode(":", $msg, 2);
	        //     $msg = isset($msg[1]) ? $msg[1] : $msg[0];

	        //     $Log->set("data.error.msg", "Couldn't follow the user")
	        //         ->set("data.error.details", $msg)
	        //         ->save();
	        //     continue;
	        // }


	        // if (!$resp->isOk()) {
	        //     $Log->set("data.error.msg", "Couldn't follow the user")
	        //         ->set("data.error.details", "Something went wrong")
	        //         ->save();
	        //     continue;   
	        // }


	        // Followed new user successfully
	        $Log->status = "success";
	        $Log->followed_user_pk = $follow_pk;
	        $Log->data = json_encode(['followed' => 
					[
		                "pk" => $follow_pk,
		                "username" => $follow_username,
		                "full_name" => $follow_full_name,
		                "profile_pic_url" => $follow_profile_pic_url
		            ]
			]);
	        $Log->save();

	    }
	}
}
