<center>
<?php
/*
this file has the text and icons of the index.php
*/
	require ("admin/ConectarDtata.php");

///===== facebook
if($facebook) {
	$facebook = '<div class="flax_home_index">
	<div class="div_con_videos">
		<div class="">
			<p class="name_social">facebook</p>
			<div class="div_social">
				<img class="imgs_index_wall_home" src="assets/img/icon/facebook.png"></img>
				<p class="p_des_con"></p>
			</div>
		</div>
	</div>';
echo $facebook;
	}else{
		echo '';
	}		 
///===== youtube
if($youtube) {
	$youtube = '<div class="div_con_videos">
		<div class="">
			<p class="name_social">YouTube</p>
			<div class="div_social">
				<img class="imgs_index_wall_home" src="assets/img/icon/youtube.png"></img>
				<p class="p_des_con"></p>
			</div>
		</div>
	</div>';
echo $youtube;	
	}else{
		echo '';
	}	
///===== vimeo
if($vimeo) {
	$vimeo = '<div class="div_con_videos">
		<div class="">
			<p class="name_social">vimeo</p>
			<div class="div_social">
				<img class="imgs_index_wall_home" src="assets/img/icon/vimeo.png"></img>
				<p class="p_des_con"></p>
			</div>
		</div>
	</div>';
 echo $vimeo;
	}else{
		echo '';
	}	
///===== dailymotion
if($dailymotion) {
	$dailymotion = '<div class="div_con_videos">
		<div class="">
			<p class="name_social">dailymotion</p>
			<div class="div_social">
				<img class="imgs_index_wall_home" src="assets/img/icon/dailymotion.png"></img>
				<p class="p_des_con"></p>
			</div>
		</div>
	</div>';
 echo $dailymotion;
	}else{
		echo '';
	}	 
///===== instagram
if($instagram) {
	$instagram = '<div class="div_con_videos">
		<div class="">
			<p class="name_social">instagram</p>
			<div class="div_social">
				<img class="imgs_index_wall_home" src="assets/img/icon/instagram.png"></img>
				<p class="p_des_con"></p>
			</div>
		</div>
	</div>';
echo $instagram;
	}else{
		echo '';
	}
///===== flooxer
if($flooxer) {
	$flooxer = '<div class="div_con_videos">
		<div class="">
			<p class="name_social">flooxer</p>
			<div class="div_social">
				<img class="imgs_index_wall_home" src="assets/img/icon/flooxer.png"></img>
				<p class="p_des_con"></p>
			</div>
		</div>
	</div>';
echo $flooxer;
	}else{
		echo '';
	}
///===== liveleak
if($liveleak) {
	$liveleak = '<div class="div_con_videos">
		<div class="">
			<p class="name_social">liveleak</p>
			<div class="div_social">
				<img class="imgs_index_wall_home" src="assets/img/icon/liveleak.png"></img>
				<p class="p_des_con"></p>
			</div>
		</div>
	</div>';
echo $liveleak;
	}else{
		echo '';
	}
///===== imgur
if($imgur) {
	$imgur = '<div class="div_con_videos">
		<div class="">
			<p class="name_social">imgur</p>
			<div class="div_social">
				<img class="imgs_index_wall_home" src="assets/img/icon/imgur.png"></img>
				<p class="p_des_con"></p>
			</div>
		</div>
	</div>';
echo $imgur;
	}else{
		echo '';
	}		
?>
</center>