<?php
	include ("functions.php");
 	include("./languages/".$_COOKIE["languages"].".php");
	$video_facebook_url = $_POST["id"];//-- id facebook video
 
  
	if(isset($video_facebook_url))  
	{  
		echo '<div id="content_video">';
		echo '	<div class="modal_video">';
	//-- video facebook	
		echo '		<video id="video_modal_w" src="'.sd_finallink(http($video_facebook_url)).'"></video>';
		echo '	</div>';
		echo '	<div class="modal_video_download">';
	//-- title of the video	
		echo getTitle_facebook(http($video_facebook_url));
		echo '		<div class="list_video_download">';
		echo '			<p class="text_modal">videos</p>';
	//-- with this function is to know if there is a version of the video in high quality	
		if (hd_finallink(http($video_facebook_url)) != "") {
	//-- high quality	
			echo '<a class="button_video_more" href="download.php?url_video='.base64_encode(sd_finallink(http($video_facebook_url))).'&title='.getTitle_facebook(http($video_facebook_url)).'" download="downloadfilename">'.$lang7.'';
			echo '<spam class="data_video_donw_spam">SD</spam></a>';
			echo '<a class="button_video_more" href="download.php?url_video='.base64_encode(hd_finallink(http($video_facebook_url))).'&title='.getTitle_facebook(http($video_facebook_url)).'" download="downloadfilename">'.$lang7.'';
			echo '<spam class="data_video_donw_spam">HD</spam></a>';
		} else { 
	//-- Low quality	
			echo '<a class="button_video_more" href="download.php?url_video='.base64_encode(sd_finallink(http($video_facebook_url))).'&title='.getTitle_facebook(http($video_facebook_url)).'" download="downloadfilename">'.$lang7.'';
			echo '<spam class="data_video_donw_spam">SD</spam></a>';
		}
		echo '		</div>';
		echo '		<br>';	
		echo '	</div>';
		echo '</div>';
	} 
?>