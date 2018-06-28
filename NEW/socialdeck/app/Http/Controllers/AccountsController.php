<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Account;

class AccountsController extends Controller
{
    /**
     * Process
     */
    public function index(Request $request)
    {
        // $AuthUser = $this->getVariable("AuthUser");
        $AuthUser = User::where('id', '=', 1)->first();
        $AuthUser->settings = json_decode($AuthUser->settings);
        $AuthUser->preferences = json_decode($AuthUser->preferences);

        // $EmailSettings = \Controller::model("GeneralData", "email-settings");

        // Auth
        // if (!$AuthUser){
        //     header("Location: ".APPURL."/login");
        //     exit;
        // } else if (
        //     !$AuthUser->isAdmin() && 
        //     !$AuthUser->isEmailVerified() 
        //     // && $EmailSettings->get("data.email_verification")
        //     ) 
        // {
        //     header("Location: ".APPURL."/profile?a=true");
        //     exit;
        // } else if ($AuthUser->isExpired()) {
        //     header("Location: ".APPURL."/expired");
        //     exit;
        // }

        // Get accounts
        $Accounts = Account::where("user_id", "=", $AuthUser->id)
                     // setPageSize(8)
                     // ->setPage(Input::get("page"))
                     ->orderBy("id","DESC")->get();
                     // ->fetchData();

        // $this->setVariable("Accounts", $Accounts);
        
        if( $request->input("action") == "remove" ) {
            // $this->remove();
        }

        // echo "<pre>";
        // print_r($Accounts);
        // echo "</pre>";
        // exit;
        // 

        return view("accounts", compact('Accounts','AuthUser'));
    }



    /**
     * Remove Account
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

        $Account = Controller::model("Account", Input::post("id"));

        if (!$Account->isAvailable() ||
            $Account->get("user_id") != $AuthUser->get("id")) 
        {
            $this->resp->msg = __("Invalid ID");
            $this->jsonecho();
        }

        // Delete instagram session data
        delete(APPPATH . "/sessions/" 
                       . $AuthUser->get("id") 
                       . "/" 
                       . $Account->get("username"));

        $Account->delete();
        
        $this->resp->result = 1;
        $this->jsonecho();
    }
}
