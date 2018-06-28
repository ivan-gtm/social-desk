<?php
/*
--- dailymotion features are very easy to download your videos
*/
	include ("functions.php");
	include("./languages/".$_COOKIE["languages"].".php");
	$video_dailymotion_url = $_POST["id"];  //-- id video dailymotion
	//-- this function generates the meta tags of vimeo
	$meta = get_tags($video_dailymotion_url);
	//-- DATA VIDEO Dailymotion
	function curlGet($URL) {
		$ch = curl_init();
		$timeout = 3;
		curl_setopt( $ch , CURLOPT_URL , $URL );
		curl_setopt( $ch , CURLOPT_RETURNTRANSFER , 1 );
		curl_setopt( $ch , CURLOPT_CONNECTTIMEOUT , $timeout );
		$tmp = curl_exec( $ch );
		curl_close( $ch );
		return $tmp;
	}
  
    $video144=$video240=$video380=$video480=$video720=$video1080='';
    $url= $_POST["id"];
    $video_info = curlGet($url);
    preg_match('/,"qualities":(.+),"reporting"/', $video_info, $match);
    $url_video=json_decode($match[1],1);
     
  
  
	if(isset($video_dailymotion_url))  
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
	//-- video 144
		if (@$video144=$url_video['144'][1]['url'] == NULL){
			
		}else{
			echo'<a class="button_video_more" href="download.php?url_video='.base64_encode($video144=$url_video['144'][1]['url']).'&title='.$meta['title'].'" download="downloadfilename">'.$lang7.'';
			echo '<spam class="data_video_donw_spam">'.Format_video(base64_encode($video144=$url_video['144'][1]['url'])).' 144</spam></a>';
		}
	//-- video 240
		if (@$video240=$url_video['240'][1]['url'] == NULL){
			
		}else{
			echo'<a class="button_video_more" href="download.php?url_video='.base64_encode($video240=$url_video['240'][1]['url']).'&title='.$meta['title'].'" download="downloadfilename">'.$lang7.'';
			echo '<spam class="data_video_donw_spam">'.Format_video(base64_encode($video240=$url_video['240'][1]['url'])).' 240</spam></a>';
		} 
	//-- video 380
		if (@$video380=$url_video['380'][1]['url'] == NULL){
			
		}else{
			echo'<a class="button_video_more" href="download.php?url_video='.base64_encode($video380=$url_video['380'][1]['url']).'&title='.$meta['title'].'" download="downloadfilename">'.$lang7.'';			
			echo '<spam class="data_video_donw_spam">'.Format_video(base64_encode($video380=$url_video['380'][1]['url'])).' 380</spam></a>';		
		} 
	//-- video 480
		if (@$video480=$url_video['480'][1]['url'] == NULL){
			
		}else{
			echo'<a class="button_video_more" href="download.php?url_video='.base64_encode($video480=$url_video['480'][1]['url']).'&title='.$meta['title'].'" download="downloadfilename">'.$lang7.'';			
			echo '<spam class="data_video_donw_spam">'.Format_video(base64_encode($video480=$url_video['480'][1]['url'])).' 480</spam></a>';
		} 
	//-- video 720	
		if (@$video720=$url_video['720'][1]['url'] == NULL){
			
		}else{
			echo'<a class="button_video_more" href="download.php?url_video='.base64_encode($video720=$url_video['720'][1]['url']).'&title='.$meta['title'].'" download="downloadfilename">'.$lang7.'';			
			echo '<spam class="data_video_donw_spam">'.Format_video(base64_encode($video720=$url_video['720'][1]['url'])).' 720</spam></a>';
		}  
	//-- video 1080
		if (@$video1080=$url_video['1080'][1]['url'] == NULL){
			
		}else{
			echo'<a class="button_video_more" href="download.php?url_video='.base64_encode($video1080=$url_video['1080'][1]['url']).'&title='.$meta['title'].'" download="downloadfilename">'.$lang7.'';			
			echo '<spam class="data_video_donw_spam">'.Format_video(base64_encode($video1080=$url_video['1080'][1]['url'])).' 1080</spam></a>';
		}
		echo '		</div>';
		echo '		<br>';
		echo '	</div>';
		echo '</div>';  
	} 
?>