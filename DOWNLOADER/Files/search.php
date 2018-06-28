<?php
/*
Any doubt or failure in the system takes a capture and sends the creator in support
*/
	$IDdata = $_POST['search'];
	if(isset($IDdata) && $IDdata != '') 
	{	
			include ("functions.php");
		//-- this function is to know the urls of pages
		//-->> www.youtube.com/watch?v=5zNO0lGKUXs
		if ($preview == preg_match("/(.+)([^&]+).(com|net|ogr|co|mx|com.mx)/", $IDdata)){
				echo '';
			} else {
				echo External_links($IDdata,$_COOKIE["languages"]);
			}	
//>>>> text HTML function to search videos on youtube <<<<<<<<<///
		//-- plugin simple_html_dom.inc.php
		if ($preview == preg_match("/(.+)([^&]+).(com|net|ogr|co|mx|com.mx|be)/", $IDdata)){
			include_once("simple_html_dom.inc.php");
			$search = str_replace(" ", "+", $_POST['search']);
		//-- address to search videos on youtube
			$html = file_get_html("https://www.youtube.com/results?search_query=".$search);
		// with this function we extract the information that is in the youtube id="content" 
			$ret = $html->find("div[id=content]", 0);
			$content = $ret->innertext;
		//-- then we pass that information so that the function preg_match_all
		//-- look for the data with the atrigth aria-hidden = "true" so have the videos
			$count = preg_match_all('/<a[^>]*aria-hidden="true"[^>]*href="([^"]+)"/',$content,$matches);
			if ($count > 0) {
				for($i = 0; $i < $count; $i++) {
		//-- this function is to eliminate the urls of channels and users to only have the videos			
					echo get_url_video_search($matches[1][$i]).'<br>';
				}
			} else {
				echo('There was a problem loading this information');
			}
		} else {
			for ($n=1;$n<=5;$n++){
				echo'<img class="img_search_m" src="./assets/img/video_background.png"></img>';
			}
		}	
			
	}else{ 	
		//-- homepage
			include ("home.php");
	}
?> 