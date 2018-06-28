<?php
return [
    'options' => [
        'ACTIVE_LANG' => 'en-US',
        'APPURL' => '14',
        'VERSION' => '040004',
        'APPPATH' => '16',
        'site_description' => 'instagram automation tool',
        'site_keywords' => '',
        'logomark' => '',
        'SSL_ENABLED' => false,
        'CRYPTO_KEY' =>"def000009675535b337a2df827eb13e9d51514ddd3bdbe9d8e0ae1f4254932ec7c2b6fb70b0458c4f54aee88e274b64fb11495f2a80348e75cb1df181e45553bff79f6c6",

        // General purpose salt
        'NP_SALT' =>"0YAlJwissGXz1hg1",


        // Path to instagram sessions directory
        'SESSIONS_PATH' => "sessions",
        // Path to temporary files directory
        'TEMP_PATH' => "/assets/uploads/temp",


        // Path to themes directory
        'THEMES_PATH' =>  "/inc/themes",
        // URI of themes directory
        'THEMES_URL' => "/inc/themes",


        // Path to plugins directory
        'PLUGINS_PATH' => "/inc/plugins",
        // URI of plugins directory
        'PLUGINS_URL' => "/inc/plugins",

        // Path to ffmpeg binary executable
        // NULL means it's been installed on global path
        // If you set the value other than null, then it will only be 
        // validated during posting the videos
        'FFMPEGBIN' =>NULL,

        // Path to ffprobe binary executable
        // NULL means it's been installed on global path
        // If you set the value other than null, then it will only be 
        // validated during posting the videos
        'FFPROBEBIN' =>NULL,
    ],
];

