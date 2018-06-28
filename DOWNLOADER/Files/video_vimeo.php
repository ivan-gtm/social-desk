<?php
	include ("functions.php");
	include("./languages/".$_COOKIE["languages"].".php");
	$video_vimeo_url = $_POST["id"]; // -- id video vimeo
	//-- this function generates the meta tags of vimeo
	$meta = get_tags($video_vimeo_url);
	//-- this function search the url of vimeo to take the direction of the videos
	function get_url_vimeo($url) {
			$data = file_get_contents("".$url."");
			$data = stristr($data, 'config_url":"');
			$start = substr($data, strlen('config_url":"'));
			$stop = stripos($start, ',');
			$str = substr($start, 0, $stop);
		return rtrim(str_replace("\\", "", $str), '"');
	}
//==	
	$link = get_url_vimeo($video_vimeo_url);//-- get_url_vimeo()
	$json = file_get_contents($link);
	//-- here we generate the information of the url and we review it with the function --> json_decode()
	$info = json_decode($json, true);
	$videos = $info['request']['files']['progressive'];
	//-- videos url
	if(isset($video_vimeo_url))  
	{  
		echo '<div id="content_video">';
		echo '	<div class="modal_video">';
	//-- image vimeo of video	
		echo '		<img id="video_modal_w" src="'.$meta['image'].'" frameborder="0"></img>';
		echo '	</div>';
		echo '	<div class="modal_video_download">';
	//-- titule video	
		echo $meta['title'];
		echo '		<div class="list_video_download">';
		echo '			<p class="text_modal">videos</p>';
	//-- information to download the videos		
	foreach ($videos as $video) {
	//-- here is the button to download the videos and a function to know the size of the video	--> getSize() 	
		echo '<a class="button_video_more" href="download.php?url_video='.base64_encode($video['url']).'&title='.$meta['title'].'" download="downloadfilename">'.$lang7.'';
	//-- exploit information from the formats of the videos	--> $video['quality'] of vimeo   	
		echo '<spam class="data_video_donw_spam">'.Format_video(base64_encode($video['url'])).' '.$video['quality'].'</spam></a>';
	} 				
		echo '		</div>';
		echo '		<br>';	
		echo '	</div>';
		echo '</div>'; 
	} 
?>