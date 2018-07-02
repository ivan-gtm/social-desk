<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ url('css/app.css') }}">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <link rel="stylesheet" type="text/css" href="{{ asset('/css/plugins.css?v='.Config::get('constants.VERSION') ) }}">
    </head>
    <body>
        <!-- <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
          <a class="navbar-brand" href="#">Fixed navbar</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" href="#">Disabled</a>
              </li>
            </ul>
            <form class="form-inline mt-2 mt-md-0">
              <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
          </div>
        </nav>
        <ul class="sd-menu">
            <li><a href="#" class="icon-logo">Logo</a></li>
            <li><a href="#" class="icon-archive">Calendar</a></li>
            <li><a href="#" class="icon-search">Media Library</a></li>
            <li class="cbp-vicurrent"><a href="#" class="icon-pencil">Conversations</a></li>
            <li><a href="#" class="icon-location">Analytics</a></li>
            <li><a href="#" class="icon-images">Search & Repost</a></li>
            <li><a href="#" class="icon-download">Linkin.bio</a></li>
        </ul> -->
        <div class="row">
          <div class="col-3">
              <!-- <input type="text" name="caption" value=""> -->
              <form action="{{ action('PostController@edit',$post_id) }}" method="post">
                {{ csrf_field() }}
                <img src="{{ asset( 'images/' . $media->filename) }}" class="img-fluid">
                <textarea class="form-control" rows="4" name="caption" id="caption">{{ $post->caption }}</textarea>
                <input class="form-control" type="text" id="schedule_date" name="schedule_date" data-language='en' value="{{ $post->schedule_date }}"
                style="
                display: block;
                width: 100%;
                height: 50px;
                padding: 15px 12px;
                font-size: 14px;
                line-height: 18px;
                color: #9b9b9b;
                border: 1px solid #eeeeee;
                outline: none;
                background-color: #fff;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
                -webkit-transition: border-color ease 0.2s;
                -moz-transition: border-color ease 0.2s;
                transition: border-color ease 0.2s;
                " 
                >
                
                <button type="submit" 
                style="
                    font-size: 12px;
                    font-weight: bold;
                    line-height: 18px;
                    cursor: pointer;
                    text-align: center;
                    text-decoration: none;
                    text-transform: uppercase;
                    color: #fff;
                    border: 1px solid #3b7cff;
                    border-radius: 0;
                    outline: none;
                    padding: 20px;
                    background-color: #3b7cff;
                    -webkit-box-sizing: border-box;
                    -moz-box-sizing: border-box;
                    box-sizing: border-box;
                    -webkit-transition: all ease 0.2s;
                    -moz-transition: all ease 0.2s;
                    transition: all ease 0.2s;
                " 
                class="btn btn-lg btn-block">POST NOW</button>
              </form>
          </div>
        </div>


        <script type="text/javascript" src="{{ asset('/js/plugins.js?v='.Config::get('constants.options.VERSION') )}}"></script>
        <script type="text/javascript">
          $(document).ready(function() {
            $('#schedule_date').datepicker({
                language: 'en',
                dateFormat: "yyyy-mm-dd",
                timeFormat: "hh:ii",
                autoClose: true,
                timepicker: true,
                toggleSelected: false
            });

            $("#caption").emojioneArea({
                // inline: true,
                search: true
            });
            // $("#caption").emojioneArea({
            //     standalone: true
            // });
          });
        </script>
    </body>
</html>
