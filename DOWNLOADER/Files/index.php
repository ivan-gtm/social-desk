<?php 
	require ("admin/ConectarDtata.php");
	require ("graphic.php");
	
	$lang = $Languages_web;
	
	if (isset($_GET['url'])) {
		$lang = $_GET['url'];
	}
	
	if (file_exists("./languages/$lang.php")) {
		include("./languages/$lang.php");
		setcookie('languages', $lang);
	}else{
		include("./languages/$Languages_web.php");
		setcookie('languages', $Languages_web);
	}
	
	require ("functions.php");
?> 
<!DOCTYPE html>
<html lang="en">
	<head>
		<link href="./assets/css/main.css" rel="stylesheet" type="text/css">
		<!--  this css file is only for Home.php  -->
		<link href="./assets/css/home.css" rel="stylesheet" type="text/css">
		<!-- this CSS file is for mobile phones and tablets -->
		<link href="./assets/css/main_m.css" rel="stylesheet" type="text/css">
		<!-- this CSS file is for mobile phones rotation -->
		<link href="./assets/css/main_rotation.css" rel="stylesheet" type="text/css">
		<!-- Ajax jquery -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<!-- bootstrap Latest compiled and minified CSS -->
		<script src="./assets/extensions/bootstrap.min.js"></script>
		<script src="./assets/extensions/jquery-3.2.1.min.js"></script>
		<link rel="icon" type="image/png" size="16x16" href="assets/img/favicon.png">
		<title><?php echo $titule_site; ?><?php echo $Description_site; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta property="og:title" content="<?php echo $titule_site; ?>"/>
		<meta property="og:type" content="website"/>
        <meta property="og:url" content="<?php echo 'https://'.$_SERVER['HTTP_HOST'].''; ?>"/>
        <meta property="og:image" content="<?php echo realpath(dirname(__FILE__)); ?>/assets/img/favicon.png" />
		<meta charset="UTF-8">
	</head>
	<body onload="checkCookie()">
	<script>
		////** Loading Image While Page Loads  
		function onReady(callback) {
			var intervalID = window.setInterval(checkReady, 4000);
			function checkReady() {
				if (document.getElementsByTagName('body')[0] !== undefined) {
					window.clearInterval(intervalID);
					callback.call(this);
				}
			}
		}

		function show(id, value) {
 			$( ".loader" ).animate({
			opacity: 0,
			height: "1%",
		  }, 1000 );
		}

		onReady(function () {
			show('page', true);
			show('loader', false);
		});
	</script>
	<!--Display Loading Image While Page Loads using jQuery and CSS-->	
	<div id="loader" class="loader"></div>	
	<div id="page" class="page">
	<!-- these are the files to generate the manners to download the videos -->
<?php 
	//-- youtube modal
	if($youtube) {
		require_once ("".realpath(dirname(__FILE__))."/inc/modal_watch_youtube.php");
	}else{
		echo '';
	}
	//-- facebook modal	
	if($facebook) {
		require_once ("".realpath(dirname(__FILE__))."/inc/modal_watch_facebook.php");
	}else{
		echo '';
	}	
	//-- vimeo modal	
	if($vimeo) {
		require_once ("".realpath(dirname(__FILE__))."/inc/modal_watch_vimeo.php");
	}else{
		echo '';
	}
	//-- dailymotion modal	
	if($dailymotion) {
		require_once ("".realpath(dirname(__FILE__))."/inc/modal_watch_dailymotion.php");
	}else{
		echo '';
	}
	//-- instagram modal	
	if($instagram) {	
		require_once ("".realpath(dirname(__FILE__))."/inc/modal_watch_instagram.php");
	}else{
		echo '';
	}
	//-- flooxer modal	
	if($flooxer) {	
		require_once ("".realpath(dirname(__FILE__))."/inc/modal_watch_flooxer.php");
	}else{
		echo '';
	}	
	//-- liveleak modal	
	if($liveleak) {	
		require_once ("".realpath(dirname(__FILE__))."/inc/modal_watch_liveleak.php");
	}else{
		echo '';
	}	
	//-- imgur modal	
	if($imgur) {	
		require_once ("".realpath(dirname(__FILE__))."/inc/modal_watch_imgur.php");
	}else{
		echo '';
	}	
?> 	
<?php 
	//--- captcha
	if ($data_Captcha){
		require_once ("captcha.php");
	}else{
		echo '';
	}
?> 
	<!-- header -->	
		<header>
			<a class="link_logo" href="./"><img class="header__logo" src="./assets/img/logo.png"></img></a>
			<div class="dropdown_lags">
					<img src="./languages/img/<?php echo $lang;?>.png" class="dropdown_lags_icon"></img>
				<div class="dropdown-content_lags">
					<div class="class_display_drop">
						<?php echo displayLangSelect('');?>
					</div>
				</div>
			</div>
		</header>
	<!-- END OF THE  header -->	
	<!-- section -->
	<section class="section_home">
	<!---->
		<div id="rotation_m"></div>
		<div class="wall_seach_home">
			<center>
				<br>
				<h2><?php echo $lang1;?></h2>
				<h5><?php echo $lang2;?></h5>
			</center>
	<!-- input of the search engine of videos and urls -->	
			<form id="liveSearch" method="POST">
				<input class="input_seach_home" type="text" placeholder="<?php echo $lang5;?> - URL's YouTube,Facebook,Vimeo" name="search" id="search">
				<button id="searchbtn" type="submit">
				</button>
				
				<br>
				<br>
			</form>
		</div>
		
		<div class="content_video">
		<div class="wall_one_div">
			<center class="advertising">
				<?php echo $ad_one; ?>
			</center>	
			<div id="searcherror"></div>
			<div id="resultados"></div>
			<center>
		<?php
			$text_home = '<p class="text_home">'.$lang3.'</p>
			<img class="img_home_m" src="./assets/img/banner1.png"></img>'; 
		 
			echo $text_home;
		?>
			</center>
		</div>
	<!-- in the id="resultados" is to show in the content of the search engine -->	
		<div class="wall_two_div">
			<h2 class="h2_home"><?php echo $lang4;?></h2>			
<?php			
	include ("home.php");
?>
			<center class="advertising">
				<?php echo $ad_two; ?>
				<br>
			</center>	
		</div>
		</div>
	</section>
	<!-- END OF THE section -->
	<!-- footer -->
	<footer id="footer">
		<center>
			<img src="./assets/img/logo_128.png"></img>
		</center>
		<p class="text_home_footer">Shareplus © 2018 <a href="#">Posted by GanjaParker</a></p>
	</footer>
	</div>
	<!-- js.js file with ajax system functions -->
		<script src="./assets/js/js.js"></script>
		<script>
		//-- search of index


			$(document).ready(function () {
			  
				$('body').on('submit', '#liveSearch', function (e) {


					e.preventDefault();

					var DataString = new FormData($(this)[0]);
					var search = $("#search").val();
				  
					if (search == "") {

						$("#searcherror").html('<center><img src="assets/img/search.png"/><br><br><?php echo $lang8;?></center>');
						$("#content_video").show();
						$("#resultados").hide();
					
					} else {

						$('#resultados').html('<center><div class="loading_data"><img src="./assets/img/loading_data.gif" style="text-align: center; width:2rem;"  alt="" /><br><br><?php echo $lang9;?></div><center>');
						$("#searcherror").html("");
						$.ajax({
							url: 'search.php',
							// url: 'lib/module/search_MYSQL.php', only for mysql or mysqlite connection
							type: 'POST',
							data: DataString,
							cache: false,
							contentType: false,
							processData: false,
							beforeSend: function () {

								$('#searcbtn').attr('disabled', 'disabled');
							},
							success: function (data) {

								$("#content_video").hide();
								$("#resultados").html(data).show();
								
								$('#searcbtn').removeAttr('disabled', 'disabled');
							},
							error: function(){
							   $("#searcherror").html('<center><br><br><img src="./assets/img/wifi_off.png"/><br><br><?php echo $lang10?></center>');
							   $("#resultados").hide();
						 
							}
						});
					}

				});
			   
			});

			
		</script>
	</body>
</html>	