<?php
/*
--- Instagram features are very easy to download your videos
*/
	include ("functions.php");
	include("./languages/".$_COOKIE["languages"].".php");
	$video_instagram_url = $_POST["id"];  //-- id video instagram
	//-- this function generates the meta tags of vimeo
	$meta = get_tags($video_instagram_url);
  
	if(isset($video_instagram_url))  
	{  
		echo '<div id="content_video">';
		echo '	<div class="modal_video">';
		echo '		<img id="video_modal_w" src="'.$meta['image'].'"></img>';
		echo '	</div>';
		echo '	<div class="modal_video_download">';
	//-- titule video		
		echo utf8_decode($meta['title']);
		echo '		<div class="list_video_download">';
		echo '			<p class="text_modal">videos</p>';
	//-- url video		
		echo'<a class="button_video_more" href="download.php?url_video='.base64_encode($meta['video']).'&title='.$meta['title'].'" download="downloadfilename">'.$lang7.'<spam class="data_video_donw_spam">'.Format_video(base64_encode($meta['video'])).'</spam></a>';
		echo '		</div>';
		echo '		<br>';
		echo '	</div>';
		echo '</div>';  
	} 
?>