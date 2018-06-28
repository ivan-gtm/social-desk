<?php
	error_reporting(0);
	
	$headers_url = $_GET["url_video"];//-- id with the video link
	$headers_title = $_GET["title"];//-- id with the name of the video
	
	//-- with the base64() function we use it to avoid errors of special carat
	$url = base64_decode($headers_url);
	$title = $headers_title;
	$title_none = "video_none";
	//-- with this function is to know the format of the video
	preg_match("/.(3gp|3GP|mp4|MP4|flv|FLV|avi|AVI|webm|WebM|wmv|WMV|mov|MOV|h264|H264|mkc|MKV|3gpp|3GPP|mpegps|MPEGPS|mpeg4|MPEG4|gifv|GIFV)/", $url, $check);
	if ($check[1]=='H264'&&'h264'){
		$Formats = 'mp4';
	}else{
		$Formats = $check[1];
	}
	
	//-- here ends the name of the video with the format
	$fileName = ''.utf8_encode($title).'.'.$Formats.'';
	if(!empty($url)){
		//-- Define headers
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=".utf8_decode($fileName)."");//-- fileName
		header("Content-Type: video/$Formats charset=utf-8");
		header("Content-Transfer-Encoding: binary");
		//-- Read the file
		readfile($url);
		exit;
	}else{
		@header("Location:./");
		exit('<meta http-equiv="Refresh" content="0;url=./">');
		echo 'error';
	}
?>
