<?php
	include ("functions.php");
 	include("./languages/".$_COOKIE["languages"].".php");
	$video_youtube_url = $_POST["id"];// id of video youtube
//== this address is to have the data of youtube videos
   parse_str(file_get_contents('http://www.youtube.com/get_video_info?video_id='.$video_youtube_url.''), $video_data);
   $streams = $video_data['url_encoded_fmt_stream_map'];
 
	if(isset($video_youtube_url))  
	{  
		echo '<div id="content_video">';
		echo '	<div class="modal_video">';
	//-- videos embed	
		echo '		<iframe id="video_modal_w" src="https://www.youtube.com/embed/'.$video_youtube_url.'" frameborder="0" allowfullscreen></iframe>';
		echo '	</div>';
		echo '	<div class="modal_video_download">';
		//-- this function is to know the title of the video
		echo getTitle_YouTube($video_youtube_url);
		echo '		<div class="list_video_download">';
		echo '			<p class="text_modal">videos</p>';
	//-- exploit youtube information to download the videos	
   $streams = explode(',',$streams);
    foreach ($streams as $streamdata) {	  
	  parse_str($streamdata,$streamdata);
	  
	  foreach ($streamdata as $key => $value) {
	//-- url video	  		
			if ($key == "url") {
			  $value = urldecode($value);
		//-- here is the button to download the videos and a function to know the size of the video	--> getSize()   
				   echo'<a class="button_video_more" href="download.php?url_video='.base64_encode($value).'&title='.getTitle_YouTube($video_youtube_url).'" download="downloadfilename">'.$lang7.'';
			  } else {
		//-- exploit information from the formats of the videos	--> $ftmd[]	  
				if ($key == "itag"){
					echo '<spam class="data_video_donw_spam">'.$ftmd[$value].'</spam></a>';
					echo '';
				} 
			}
	  }
	}
		echo '		</div>';
		echo '		<br>';
	//-- NOTE: do not touch this	
		echo '		<!--div class="list_audio_download">';
		echo '			<p class="text_modal">audio</p>';
		echo '			<a class="button_video_more" href="">mp3 128k</a>';
		echo '		</div-->	';		
		echo '	</div>';
		echo '</div>';
	} 
?>