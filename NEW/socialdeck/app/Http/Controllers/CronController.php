<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Controllers\InstagramController;

class CronController extends Controller
{
    /**
     * Process
     */
    public function send_scheduled_posts()
    {
        set_time_limit(0);

        self::get_scheduled_posts();

        // \Event::trigger("cron.add");

        echo "Cron task processed!";
    }


    /**
     * Process scheduled posts
     */
    private function get_scheduled_posts()
    {
        // Get scheduled posts
        $posts = Post::where('status','scheduled')
                      ->where('is_scheduled',  '1')
                      ->where('schedule_date', '<=', date('Y-m-d H:i').':59')
                      ->limit(1) // Limit posts to prevent server overload
                      ->get();
        
        if (sizeof($posts) < 1) {
            // There are no scheduled posts
            return -1;
        }

        foreach ($posts as $post) {
            // Update post status
            $post->status = 'publishing';
            $post->save();

            // try {
              InstagramController::publish($post);
            // } catch (\Exception $e) {
                // Do nothing here
                return 0;
            // }
        }

        return true;
    }
}
