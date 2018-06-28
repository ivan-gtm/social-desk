<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UsersController extends Controller
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

        // Auth
        // if (!$AuthUser){
        //     header("Location: ".APPURL."/login");
        //     exit;
        // } else if ($AuthUser->isExpired()) {
        //     header("Location: ".APPURL."/expired");
        //     exit;
        // } else if (!$AuthUser->isAdmin()) {
        //     header("Location: ".APPURL."/post");
        //     exit;
        // }

        // Get Users
        $Users = User::orderBy("id","DESC")
                    // ->where('email', $request->input('q'))
                    // ->orWhere('firstname', $request->input('q'))
                    // ->orWhere('lastname', $request->input('q'))
                    // ->orWhere('username', $request->input('q'))
                    ->paginate(20);
            // ->setPage(Input::get("page"))

        if ($request->input('action') == "remove") {
            // $Users->remove();
        }

        // echo "<pre>";
        // print_r($AuthUser->preferences);
        // echo "</pre>";
        // exit;

        return view("users", compact('AuthUser', 'Users'));
    }


    /**
     * Remove User
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

        $User = Controller::model("User", Input::post("id"));

        if (!$User->isAvailable()) {
            $this->resp->msg = __("User doesn't exist!");
            $this->jsonecho();
        }

        if (!$AuthUser->canEdit($User)) {
            $this->resp->msg = __("You don't have a privilage to modify this user's data!");
            $this->jsonecho();   
        }

        if ($AuthUser->get("id") == $User->get("id")) {
            $this->resp->msg = __("You can not delete your own account!");
            $this->jsonecho();
        }

        $User->delete();

        $this->resp->result = 1;
        $this->jsonecho();
    }
}
