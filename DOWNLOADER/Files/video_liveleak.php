<?php
/*
--- metacafe features are very easy to download your videos
*/
	include ("functions.php");
	include("./languages/".$_COOKIE["languages"].".php");
	include_once("simple_html_dom.inc.php");
	$video_metacafe_url = $_POST["id"];  //-- id video metacafe
	//-- this function generates the meta tags of vimeo
	$html = file_get_html($video_metacafe_url);
			foreach($html->find('source') as $meta){
				if($meta->getAttribute('label') && $meta->getAttribute('label') == 'HD'){
					$VIDEO_HD = $meta->getAttribute('src');
				}
			}
			//VIDEO SD
			foreach($html->find('source') as $meta){
				if($meta->getAttribute('label') && $meta->getAttribute('label') == 'SD'){
					$VIDEO_SD = $meta->getAttribute('src');
				}
			}
			//here the title is generated	
			foreach($html->find('meta') as $meta){
				if($meta->getAttribute('property') && $meta->getAttribute('property') == 'og:title'){
					$page_title = $meta->getAttribute('content');
				}
			}			
			//here the image is generated
			foreach($html->find('meta') as $meta){
				if($meta->getAttribute('property') && $meta->getAttribute('property') == 'og:image'){
					$page_image = $meta->getAttribute('content');
				}
			}
			

  
		echo '<div id="content_video">';
		echo '	<div class="modal_video">';
		echo '		<img id="video_modal_w" src="'.$page_image.'"></img>';
		echo '	</div>';
		echo '	<div class="modal_video_download">';
	//-- titule video		
		echo utf8_decode($page_title);
		echo '		<div class="list_video_download">';
		echo '			<p class="text_modal">videos</p>';
	//-- url video		
		echo'<a class="button_video_more" href="download.php?url_video='.base64_encode($VIDEO_HD).'&title='.$page_title.'" download="downloadfilename">'.$lang7.'';
		echo '<spam class="data_video_donw_spam">HD</spam></a>';
		echo '<a class="button_video_more" href="download.php?url_video='.base64_encode($VIDEO_SD).'&title='.$page_title.'" download="downloadfilename">'.$lang7.'';
		echo '<spam class="data_video_donw_spam">SD</spam></a>';
		echo '		</div>';
		echo '		<br>';
		echo '	</div>';
		echo '</div>';  
	 
?>