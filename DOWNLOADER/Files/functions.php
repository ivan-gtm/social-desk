<?php
/*

this functions.php file has all the functions of the system if something fails here are functions

*/
	require ("admin/ConectarDtata.php");
	
///====================================================================>
///===== this function is to review the data of the URL site
		function http($linkinfo){
			$context = [
				'http' => [
					'method' => 'GET',
					'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.47 Safari/537.36",
				],
			];
			$context = stream_context_create($context);
			$data = file_get_contents($linkinfo, false, $context);
			
			return $data;
		}
		
///====================================================================>		
///===== this function is to check if there are special characters	
		function cleanStr($str)
		{
			return html_entity_decode(strip_tags($str), ENT_QUOTES, 'UTF-8');
		}
///===== with these functions are to read the data of facebook videos
///-----facebook HD videos link
		function hd_finallink($curl_content)
		{

			$regex = '/hd_src_no_ratelimit:"([^"]+)"/';
			if (preg_match($regex, $curl_content, $match)) {
				return $match[1];

			} else {return;}
		}
///----- facebook SD videos link
		function sd_finallink($curl_content)
		{
			$regex = '/sd_src_no_ratelimit:"([^"]+)"/';
			if (preg_match($regex, $curl_content, $match1)) {
				return $match1[1];

			} else {return;}
		}
///----- title of the facebook video
		function getTitle_facebook($curl_content)
		{
			$title = null;
			if (preg_match('/h2 class="uiHeaderTitle"?[^>]+>(.+?)<\/h2>/', $curl_content, $matches)) {
				$title = $matches[1];
			} elseif (preg_match('/title id="pageTitle">(.+?)<\/title>/', $curl_content, $matches)) {
				$title = $matches[1];
			}
			return cleanStr($title);
		}
///====================================================================>	
///===== this function search the meta tags of the sites		
		function get_tags($url) {
		 
			$html = file_get_contents($url);
		 
			@libxml_use_internal_errors(true);
			$dom = new DomDocument();
			$dom->loadHTML($html);
			$xpath = new DOMXPath($dom);
			$query = '//*/meta[starts-with(@property, \'og:\')]';
			$result = $xpath->query($query);
		 
			foreach ($result as $meta) {
				$property = $meta->getAttribute('property');
				$content = $meta->getAttribute('content');
		 
				// replace og
				$property = str_replace('og:', '', $property);
				$list[$property] = $content;
			}
			
			return $list;
		}		
///====================================================================>	
///===== title of the YouTube video
		function getTitle_YouTube($video_id)
		{
		   $data = file_get_contents("https://www.youtube.com/get_video_info?video_id=$video_id");
			parse_str($data);
			
			$arr = explode(",", $url_encoded_fmt_stream_map);
			
			foreach ($arr as $item) {
				parse_str($item);
					return $title; 
			}
		}
	
///====================================================================>
///===== this function is to know the format of the video

	function Format_video($Format){
		$url = base64_decode($Format);
		//-- with this function is to know the format of the video
		preg_match("/.(3gp|3GP|mp4|MP4|flv|FLV|avi|AVI|webm|WebM|wmv|WMV|mov|MOV|h264|H264|mkc|MKV|3gpp|3GPP|mpegps|MPEGPS|mpeg4|MPEG4|gifv|GIFV)/", $url, $check);
		if ($check[1]=='H264'&&'h264'){
			$Formats = 'mp4';
		}else{
			$Formats = $check[1];
		}
		return $Formats ;
	}	
///====================================================================>
///===== this function is to know the format of the YouTube videos
		$ftmd = array(
			'5' => 'Very Low Definition FLV',
			'17' => '3GP',
			'18' => 'Low WebM',
			'22' => 'High MP4',
			'34' => 'Low FLV',
			'35' => 'Standard Definition FLV',
			'36' => 'Low Definition 3GP',
			'37' => 'Full High Definition MP4',
			'38' => 'Ultra High Definition MP4',
			'43' => 'Low Definition MP4',
			'44' => 'Standard Definition WebM',
			'45' => 'High Definition WebM',
			'46' => 'Full High Definition WebM',
			'82' => 'Low Definition 3D MP4',
			'83' => 'Standard Definition 3D MP4',
			'84' => 'High Definition 3D MP4',
			'85' => 'Full High Definition 3D MP4',
			'100' => 'Low Definition 3D WebM',
			'101' => 'Standard Definition 3D WebM',
			'102' => 'High Definition 3D WebM'
		); 
///====================================================================>
///===== this cURL function is to know the file size
		function getSize($url)
		{

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_HEADER, true);
			curl_setopt($ch, CURLOPT_NOBODY, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$r = curl_exec($ch);

			foreach (explode("\n", $r) as $header) {
				if (strpos($header, 'Content-Length:') === 0) {
					return intval(intval(trim(substr($header, 16)))/ (1024*1024)) . " MB";
				}
			}
		}
  
///====================================================================>
///===== this mega function is to read the urls of the site and to know your data in the search engine
	function External_links($Link_info,$lang_file)
	{
		

			include("./languages/$lang_file.php");
		$search = '<center><img src="assets/img/search.png"/><br><br>'.$lang8.'</center>';
		$DEACTIVATE_search = '<center><br><img src="assets/img/false.png"/ style="width: 5rem;"><br><br>'.$lang6.'</center>';
		
	if(isset($Link_info)) :
	 $url = $Link_info;
	if(preg_match("/youtu.be\/[a-z1-9.-_]+/", $url)) {
//=== youtube information generator	
	require ("admin/ConectarDtata.php");
		if(@$youtube){			
		$meta = get_tags($url);		
			if($meta['title'] == ''){
				echo $search;
			}else{	
				preg_match("/v=([^&]+)/", $url, $check);
				if(isset($check[1])) {
					$link = $check[1];
					echo '<div id="link_video_data">';
					echo '<iframe class="img_embed" width="460" height="215"  src="http://www.youtube.com/embed/'.$link.'" frameborder="0" allowfullscreen></iframe>';
					echo '<div class="youtube_img wall_video_seach_link">';
					echo '<p class="text_video_seach_link">'.getTitle_YouTube($link).'</p>';
					echo '<a class="button_video_more_btn_donw button_video_more_search" data-toggle="modal" data-target="#view-modal-media" data-id="'.$link.'" id="getMedia" href="#">Download</a>';
					echo '</div>';
					echo '</div>';
				}
			}
		}else{
			echo $DEACTIVATE_search;
		}
	}
	else if(preg_match("/youtube.com(.+)v=([^&]+)/", $url)) {
//=== youtube information generator
	require ("admin/ConectarDtata.php");
		if(@$youtube){	
		$meta = get_tags($url);
			if($meta['title'] == ''){
				echo $search;
			}else{	
				preg_match("/v=([^&]+)/", $url, $check);
				if(isset($check[1])) {
					$link = $check[1];
					echo '<div id="link_video_data">';
					echo '<iframe class="img_embed" width="460" height="215"  src="http://www.youtube.com/embed/'.$link.'" frameborder="0" allowfullscreen></iframe>';
					echo '<div class="youtube_img wall_video_seach_link">';
					echo '<p class="text_video_seach_link">'.getTitle_YouTube($link).'</p>';
					echo '<a class="button_video_more_btn_donw button_video_more_search" data-toggle="modal" data-target="#view-modal-media" data-id="'.$link.'" id="getMedia" href="#">'.$lang7.'</a>';
					echo '</div>';
					echo '</div>';
				}
			}
		}else{	
			echo $DEACTIVATE_search;
		}	
	}
	else if(preg_match("/facebook.com\/[a-z1-9.-_]+/", $url)) {
//=== facebook information generator
	require ("admin/ConectarDtata.php");
		if(@$facebook){	
			if(sd_finallink(http($url)) == ''){
				echo $search;
			}else{			
				preg_match("/facebook.com\/([a-z1-9.-_]+)/", $url, $check);
				if(isset($check[1])) {
					$link = $check[1];
					echo '<div id="link_video_data">';
					echo '<video class="img_embed" src="'.sd_finallink(http($url)).'" width="460" height="215"></video>';
					echo '<div class="facebook_img wall_video_seach_link">';
					echo '<p class="text_video_seach_link">'.getTitle_facebook(http($url)).'</p>';
					echo '<a class="button_video_more_btn_donw button_video_more_search" data-toggle="modal" data-target="#view-modal-facebook" data-id="'.$url.'" id="facebook" href="#">'.$lang7.'</a>';
					echo '</div>';
					echo '</div>';
				}
			}
		}else{
			echo $DEACTIVATE_search;
		}	
	}
	else if(preg_match("/vimeo.com\/([a-z1-9.-_]+)/", $url)) {
//=== vimeo information generator
	require ("admin/ConectarDtata.php");
		if(@$vimeo){	
		$meta = get_tags($url);	
			if($meta['title'] == ''){
				echo $search;
			}else{
				preg_match("/vimeo.com\/([a-z1-9.-_]+)/", $url, $check);
				if(isset($check[1])) {
					$link = $check[1];
					echo '<div id="link_video_data">';
					echo '<img class="img_embed" src="'.$meta['image'].'" width="460" height="215"></img>';
					echo '<div class="vimeo_img wall_video_seach_link">';
					echo '<p class="text_video_seach_link">'.$meta['title'].'</p>';
					echo '<a class="button_video_more_btn_donw button_video_more_search" data-toggle="modal" data-target="#view-modal-vimeo" data-id="'.$url.'" id="vimeo" href="#">'.$lang7.'</a>';
					echo '</div>';
					echo '</div>';
				}
			}
		}else{
			echo $DEACTIVATE_search;
		}
	}	
	else if(preg_match("/flooxer.com\/([a-z1-9.-_]+)/", $url)) {	
//=== flooxer information generator
	require ("admin/ConectarDtata.php");
		if(@$flooxer){	
		$meta = get_tags($url);
			if($meta['title'] == ''){
				echo $search;
			}else{		
				preg_match("/flooxer.com\/([a-z1-9.-_]+)/", $url, $check);
				if(isset($check[1])) {
					$link = $check[1];
					echo '<div id="link_video_data">';
					echo '<img class="img_embed" src="'.$meta['image'].'" width="460" height="215"></img>';
					echo '<div class="flooxer_img wall_video_seach_link">';
					echo '<p class="text_video_seach_link">'.utf8_decode($meta['title']).'</p>';
					echo '<a class="button_video_more_btn_donw button_video_more_search" data-toggle="modal" data-target="#view-modal-flooxer" data-id="'.$url.'" id="flooxer" href="#">'.$lang7.'</a>';
					echo '</div>';
					echo '</div>';
				}
			}
		}else{
			echo $DEACTIVATE_search;
		}	
	}
	else if(preg_match("/imgur.com\/gallery\/([a-z1-9.-_]+)/", $url)) {	
//=== imgur information generator
	require ("admin/ConectarDtata.php");
		if(@$imgur){	
		$meta = get_tags($url);
			if($meta['video'] == ''){
				echo $search;
			}else{		
				preg_match("/imgur.com\/gallery\/([a-z1-9.-_]+)/", $url, $check);
				if(isset($check[1])) {
					$link = $check[1];
					echo '<div id="link_video_data">';
					echo '<img class="img_embed" src="'.$meta['image'].'" width="460" height="215"></img>';
					echo '<div class="imgur_img wall_video_seach_link">';
					echo '<p class="text_video_seach_link">'.utf8_decode($meta['title']).'</p>';
					echo '<a class="button_video_more_btn_donw button_video_more_search" data-toggle="modal" data-target="#view-modal-imgur" data-id="'.$url.'" id="imgur" href="#">'.$lang7.'</a>';
					echo '</div>';
					echo '</div>';
				}
			}
		}else{
			echo $DEACTIVATE_search;
		}	
	}
	else if(preg_match("/liveleak.com\/([a-z1-9.-_]+)/", $url)) {	
//=== liveleak information generator
	require ("admin/ConectarDtata.php");
		if(@$liveleak){	
		$meta = get_tags($url);
			if($meta['title'] == ''){
				echo $search;
			}else{		
				preg_match("/liveleak.com\/([a-z1-9.-_]+)/", $url, $check);
				if(isset($check[1])) {
					$link = $check[1];
					echo '<div id="link_video_data">';
					echo '<img class="img_embed" src="'.$meta['image'].'" width="460" height="215"></img>';
					echo '<div class="liveleak_img wall_video_seach_link">';
					echo '<p class="text_video_seach_link">'.utf8_decode($meta['title']).'</p>';
					echo '<a class="button_video_more_btn_donw button_video_more_search" data-toggle="modal" data-target="#view-modal-liveleak" data-id="'.$url.'" id="liveleak" href="#">'.$lang7.'</a>';
					echo '</div>';
					echo '</div>';
				}
			}
		}else{
			echo $DEACTIVATE_search;
		}	
	}
	else if(preg_match("/dailymotion.com\/video\/([a-z1-9.-_]+)/", $url)) {	
//=== dailymotion information generator
	require ("admin/ConectarDtata.php");
		if(@$dailymotion){	
		$meta = get_tags($url);
			if($meta['title'] == ''){
				echo $search;
			}else{		
				preg_match("/dailymotion.com\/video\/([a-z1-9.-_]+)/", $url, $check);
				if(isset($check[1])) {
					$link = $check[1];
					echo '<div id="link_video_data">';
					echo '<img class="img_embed" src="'.$meta['image'].'" width="460" height="215"></img>';
					echo '<div class="dailymotion_img wall_video_seach_link">';
					echo '<p class="text_video_seach_link">'.utf8_decode($meta['title']).'</p>';
					echo '<a class="button_video_more_btn_donw button_video_more_search" data-toggle="modal" data-target="#view-modal-dailymotion" data-id="'.$url.'" id="dailymotion" href="#">'.$lang7.'</a>';
					echo '</div>';
					echo '</div>';
				}
			}
		}else{
			echo $DEACTIVATE_search;
		}	
	}		
	else if(preg_match("/instagram.com\/([a-z1-9.-_]+)/", $url)) {	
//=== instagram information generator
	require ("admin/ConectarDtata.php");
		if(@$instagram){	
		$meta = get_tags($url);
			if($meta['video'] == ''){
				echo $search;
			}else{		
				preg_match("/instagram.com\/([a-z1-9.-_]+)/", $url, $check);
				if(isset($check[1])) {
					$link = $check[1];
					echo '<div id="link_video_data">';
					echo '<img class="img_embed" src="'.$meta['image'].'" width="460" height="215"></img>';
					echo '<div class="instagram_img wall_video_seach_link">';
					echo '<p class="text_video_seach_link">'.utf8_decode($meta['title']).'</p>';
					echo '<a class="button_video_more_btn_donw button_video_more_search" data-toggle="modal" data-target="#view-modal-instagram" data-id="'.$url.'" id="instagram" href="#">'.$lang7.'</a>';
					echo '</div>';
					echo '</div>';
				}
			}
		}else{
			echo $DEACTIVATE_search;
		}	
	}
	else
	{
		//-- Error 404
		echo $search;
	} 
		endif;///
	}

//=== this function is to generate the data from the youtube video search engine
	function get_url_video_search($url) {
//-- the system to search for videos on YouTube does not use the API, it only uses the plugin --> simple_html_dom.inc.php		
		$count = preg_match_all('/v=([^&]+)/',$url,$matches);
		if ($count > 0) {
			for($i = 0; $i < $count; $i++) {
				$meta = get_tags('https://www.youtube.com/watch?v='.$matches[1][$i]);	
				$output = '		
					<div class="video_info_content">
					<img class="img_thumbnails" src="'.$meta['image'].'" alt=""></img>
						<div class="video_description">
							<p class="text_video_titule_search">'.utf8_decode($meta['title']).'</p>
							<p class="text_video_description">'.utf8_decode($meta['description']).'</p>
							<a class="button_video_more" data-toggle="modal" data-target="#view-modal-media" data-id="'.$matches[1][$i].'" id="getMedia" href="#">Download</a>
						</div>
					</div>';	
				return $output;	
			}
		} else {
			//return 'There was a problem loading this information';
		}
	}	
////-- function for language files	
	function displayLangSelect($lang) {
		
		$languages_dir = "languages"; //-- languages  folder 
		$lang_found = 0;
		
		if (is_dir($languages_dir)) {
			
			if ($dh = opendir($languages_dir)) {
				
				$i = 0;
				while (($file = readdir($dh)) !== false) {
					
					if (substr($file,-1) != "." && pathinfo($file, PATHINFO_EXTENSION) == "php") {
						
						$i++;
						
						$file_name = $file;
						
						// Open file to get language name
						include($languages_dir . "/" . $file_name);
						
						$lang_found = 1;
						
						// Strip extension
						$file_name = preg_replace("/\..*$/", "", $file_name);

							$line = "<a href=".$Languages_option."";
						if ($file_name == $lang)
							$line .= "";
							$line .= ">";
							$line .= "<img src='".$Languages_img."'/>";
							$line .= "</a>";
							
						$langsAr[] = $line;
						
						include($languages_dir . "/" . $lang .".php");

					}
				}
				closedir($dh);
				
				if ($lang_found == 0) {
					
					echo "Error: <strong>languages</strong> folder empty!";
					
				} else {
					
					if ($i > 1) {
						
						sort($langsAr);
						
						echo "";
						echo "<div>";
						foreach ($langsAr AS $lang) {
							echo $lang;
						}
						echo "</div>";
						
					} else {
						echo "<input type=\"hidden\" name=\"lang\" value=\"" . $file_name . "\">";
					}
				}

			} else {
				
				echo "Error: <strong>languages</strong> folder locked!";
			}
			
		} else {
			echo "Error: <strong>languages</strong> folder missing!";
		}
	}	
?>