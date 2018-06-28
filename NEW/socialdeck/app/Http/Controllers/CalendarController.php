<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Account;
use App\Post;
use App\User;

class CalendarController extends Controller
{
    /**
     * Process
     */
    public function index(Request $request)
    {
        $AuthUser = User::where('id', '=', 1)->first();
        $AuthUser->settings = json_decode($AuthUser->settings);
        $AuthUser->preferences = json_decode($AuthUser->preferences);


        // $EmailSettings = \Controller::model("GeneralData", "email-settings");
        // if (!$AuthUser){
        //     header("Location: ".APPURL."/login");
        //     exit;
        // } else if (
        //     !$AuthUser->isAdmin() && 
        //     !$AuthUser->isEmailVerified() &&
        //     $EmailSettings->data-mail_verification")) 
        // {
        //     header("Location: ".APPURL."/profile?a=true");
        //     exit;
        // } else if ($AuthUser->isExpired()) {
        //     header("Location: ".APPURL."/expired");
        //     exit;
        // }


        // Get accounts
        $Accounts = Account::where("user_id", $AuthUser->id )
                             ->orderBy("id","DESC")
                             ->first();

        // Identify active account
        $ActiveAccount = null;
        // $ActiveAccount = Controller::model("Account", Input::get("account"));
        // if ($ActiveAccount->isAvailable() &&
        //     $ActiveAccount->user_id != $AuthUser->id) {
        //     // Account doesn't belong to the authorized user
        //     $ActiveAccount = Controller::model("Account");
        // }

        // Pending
        if( $request->input("action") == "remove") {
            // self::remove();
        }


        if ( $request->has("action") ) {
            self::dayView();
        } else {
            self::monthView($request, $AuthUser, $Accounts, $ActiveAccount);
        }
    }


    /**
     * Generate month view
     * @return null 
     */
    public function monthView(Request $request, $year, $month)
    {
        $AuthUser = User::where('id', '=', 1)->first();
        $AuthUser->settings = json_decode($AuthUser->settings);
        $AuthUser->preferences = json_decode($AuthUser->preferences);

        // Get accounts
        $Accounts = Account::where("user_id", $AuthUser->id )
                             ->orderBy("id","DESC")
                             ->first();
        
        // echo "<pre>";
        // print_r($Accounts);
        // echo "</pre>";
        // exit;

        // Identify active account
        $ActiveAccount = Account::where('id', $Accounts->id)->first();
        // if ($ActiveAccount != null &&
        //     $ActiveAccount->user_id != $AuthUser->id) {
        //     // Account doesn't belong to the authorized user
        //     $ActiveAccount = Account;
        // }

        // Check and validate date
        // $year = $request->has("year") ? $request->input("year") : 0;
        // $month = $request->has("month") ? $request->input("month") : 0;


        if (!isValidDate($year."-".$month."-01", "Y-m-d")) {
            $now = \Carbon\Carbon::now(date_default_timezone_get());
            $now->setTimezone($AuthUser->preferences->timezone);

            $year = $now->format("Y");
            $month = $now->format("m");

            return redirect( 
                action(
                    'CalendarController@monthView', 
                        [
                            'year' => $year, 
                            'month' => $month
                        ]
                )
            );
        }
        

        if (count($Accounts) > 0) {

            // Define start and end dates
            $start = \Carbon\Carbon::now($AuthUser->preferences->timezone)->setTimezone(date_default_timezone_get())->startOfMonth();
            $end = \Carbon\Carbon::now($AuthUser->preferences->timezone)->setTimezone(date_default_timezone_get())->endOfMonth();


            // Get scheduled
            $ScheduledPosts = Post::where("user_id", "=", $AuthUser->id)
                               ->where("is_scheduled", "=", 1)
                               ->whereIn("status", ["scheduled", "processing"])
                               ->where("schedule_date", ">=", $start->format("Y-m-d H:i:s"))
                               ->where("schedule_date", "<", $end->format("Y-m-d H:i:s"))->get();


            // if ($ActiveAccount->isAvailable()) {
            //     $ScheduledPosts->where("account_id", "=", $ActiveAccount->id);
            // }
            

            // Completed (failed and published) posts
            $CompletedPosts = Post::where("user_id", "=", $AuthUser->id)
                           ->whereIn("status", ["published", "failed"])
                           ->where("publish_date", ">=", $start->format("Y-m-d H:i:s"))
                           ->where("publish_date", "<", $end->format("Y-m-d H:i:s"))->get();
            

            // if ($ActiveAccount->isAvailable()) {
            //     $CompletedPosts->where("account_id", "=", $ActiveAccount->id);
            // }
            // $CompletedPosts->fetchData();

            
            // post counts
            $postcounts = [];
            foreach ($ScheduledPosts as $post) {
                $d = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->schedule_date, date_default_timezone_get())
                     ->setTimezone($AuthUser->preferences->timezone);


                $daynumber = $d->format("d");

                if (empty($postcounts[$daynumber])) {
                    $postcounts[$daynumber] = [
                        "scheduled" => 0,
                        "published" => 0,
                        "failed" => 0
                    ];
                }

                $postcounts[$daynumber]["scheduled"]++;
            }


            foreach ($CompletedPosts as $post) {
                $d = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->publish_date, date_default_timezone_get())
                     ->setTimezone($AuthUser->preferences->timezone);

                $daynumber = $d->format("d");

                if (empty($postcounts[$daynumber])) {
                    $postcounts[$daynumber] = [
                        "scheduled" => 0,
                        "published" => 0,
                        "failed" => 0
                    ];
                }

                if ($post->status == "published") {
                    $postcounts[$daynumber]["published"]++;
                } else {
                    $postcounts[$daynumber]["failed"]++;
                }
            }

            // Set variables
            // $this->setVariable("postcounts", $postcounts);
        }

        // echo "<pre>";
        // print_r($postcounts);
        // echo "</pre>";
        // exit;

        // // Set variables
        // $this->setVariable("month", $month)
        //      ->setVariable("year", $year)
        //      ->setVariable("viewtype", "month");
        $viewtype = 'month';
        
        return view("calendar", compact('viewtype', 'AuthUser','Accounts', 'ActiveAccount', 'year', 'month', 'postcounts'));
    }


    /**
     * Generate day view
     * @return null 
     */
    public function dayView($year, $month, $day)
    {
        // $Route = $this->getVariable("Route");
        
        $AuthUser = User::where('id', '=', 1)->first();
        $AuthUser->settings = json_decode($AuthUser->settings);
        $AuthUser->preferences = json_decode($AuthUser->preferences);
        
        // $Accounts = $this->getVariable("Accounts");
        // $ActiveAccount = $this->getVariable("ActiveAccount");

        // Get accounts
        $Accounts = Account::where("user_id", $AuthUser->id )
                             ->orderBy("id","DESC")
                             ->get();


        // Identify active account
        // $ActiveAccount = AccountInput::get("account"));
        // if ($ActiveAccount->isAvailable() &&
            $ActiveAccount = Account::where('user_id', $AuthUser->id)->first();
            // Account doesn't belong to the authorized user
            // $ActiveAccount = Controller::model("Account");
        // }


        
        // Check validate date
        if (!isValidDate($year."-".$month."-".$day, "Y-m-d")) {
            if (isValidDate($year."-".$month."-01", "Y-m-d")) {
                return redirect( action('CalendarController@dayView', array('year' => $year,'month' => $month,'day' => '01',)) );
            } else {
                return redirect( action('CalendarController@index') );
            }
        }
        
        if (count($Accounts) > 0) {
            // Define start and end dates
            $timestamp = $year . '-' . $month . '-' . $day . ' 00:00:00';
            $start = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $timestamp, $AuthUser->preferences->timezone)->setTimezone(date_default_timezone_get());
            
            $timestamp = $year . '-' . $month . '-' . $day . ' 23:59:59';
            $end = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $timestamp, $AuthUser->preferences->timezone)->setTimezone(date_default_timezone_get());

            // Get scheduled posts
            $ScheduledPosts = Post::where( 'user_id', $AuthUser->id )
                                   ->where("is_scheduled", 1)
                                   ->whereIn('status', ['scheduled', 'processing'])
                                   ->where("schedule_date", ">=", $start->format("Y-m-d H:i:s"))
                                   ->where("schedule_date", "<", $end->format("Y-m-d H:i:s"))
                                   ->where("account_id", $ActiveAccount->id)
                                   ->orderBy("schedule_date", "ASC")->get();

            // if ($ActiveAccount->isAvailable()) {
            //     $ScheduledPosts->where("account_id", "=", $ActiveAccount->id);
            // }
            
            // $ScheduledPosts->fetchData();

            
            // Get published posts
            // $PublishedPosts = Controller::model("Posts");
            $PublishedPosts = Post::where( 'user_id', $AuthUser->id )
                           ->whereIn("status", ["published"])
                           ->where("publish_date", ">=", $start->format("Y-m-d H:i:s"))
                           ->where("publish_date", "<", $end->format("Y-m-d H:i:s"))
                           ->where("account_id", $ActiveAccount->id)
                           ->orderBy("publish_date", "DESC");


            // if ($ActiveAccount->isAvailable()) {
            //     $PublishedPosts->where("account_id", "=", $ActiveAccount->id);
            // }

            // $PublishedPosts->fetchData();

            // Get failed posts
            $FailedPosts = Post::where( 'user_id', $AuthUser->id )
                           ->whereIn("status", ["failed"])
                           ->where("publish_date", ">=", $start->format("Y-m-d H:i:s"))
                           ->where("publish_date", "<", $end->format("Y-m-d H:i:s"))
                           ->orderBy("publish_date", "DESC");
            

            // if ($ActiveAccount->isAvailable()) {
            //     $FailedPosts->where("account_id", "=", $ActiveAccount->id);
            // }

            // $FailedPosts->fetchData();

            // Set variables
            // $this->setVariable("ScheduledPosts", $ScheduledPosts)
            //      ->setVariable("PublishedPosts", $PublishedPosts)
            //      ->setVariable("FailedPosts", $FailedPosts);
        }

        // echo "<pre>";
        // print_r($end);
        // print_r($ScheduledPosts);
        // echo "</pre>";
        // exit;

        // $this->setVariable("year", $year)
        //      ->setVariable("month", $month)
        //      ->setVariable("day", $day)
        //      ->setVariable("viewtype", "day");

        $viewtype = 'day';

        return view("calendar", compact('Accounts','ActiveAccount','AuthUser','year','month','day','FailedPosts','PublishedPosts','ScheduledPosts','viewtype'));   
    }


    /**
     * Remove Post
     * @return void
     */
    private function remove()
    {
        $this->resp->result = 0;
        $AuthUser = $this->getVariable("AuthUser");

        if (!Input::post("id")) {
            $this->resp->msg = __("ID is requred!");
            $this->jsonecho();
        }

        $Post = Controller::model("Post", Input::post("id"));

        if (!$Post->isAvailable() || 
            $Post->user_id != $AuthUser->id ||
            in_array($Post->status, ["published", "publishing"])) 
        {
            $this->resp->msg = __("Invalid ID");
            $this->jsonecho();
        }

        $Post->delete();

        $this->resp->result = 1;
        $this->jsonecho();
    }
}
