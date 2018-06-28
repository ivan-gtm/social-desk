<?php
// +------------------------------------------------------------------------+
// | @author_email: chuyd23@gmail.com   
// +------------------------------------------------------------------------+
// | SharePlus - Download system of social media videos
// | Copyright (c) 2018 SharePlus. All rights reserved.
// +------------------------------------------------------------------------+
/*
Any doubt or failure in the system takes a capture and sends the creator in support
*/



//Incluyo la configuración
require ("config.php");


// created the connection

$con = @mysqli_connect($dbhost, $dbuser, $dbpassword);
// Check connection

// ...some PHP code for database "my_db"...

// check the connection
if (!$con){
		die(include ("./admin/install.php"));
	exit;
}

/* User datos */
// Change database to "test"
$bdselect = mysqli_select_db($con, $dbdatabase);

if (!$bdselect) { 
// this function is to know if the system is installed
	if (!file_exists('./admin/install.php')) {
		die("ERROR TO BE CONNECTED WITH THE SERVER");
	}else{
		die(include ("./admin/install.php"));
	}
	exit;
}

//-- userID 
/*
function user_ID($in, $to_num = false, $pad_up = false, $pass_key = null)
{
	$out   =   '';
	$index = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$base  = strlen($index);

	if ($pass_key !== null) {
		// Although this function's purpose is to just make the
		// ID short - and not so much secure,
		// with this patch by Simon Franz (http://blog.snaky.org/)
		// you can optionally supply a password to make it harder
		// to calculate the corresponding numeric ID

		for ($n = 0; $n < strlen($index); $n++) {
			$i[] = substr($index, $n, 1);
		}

		$pass_hash = hash('sha256',$pass_key);
		$pass_hash = (strlen($pass_hash) < strlen($index) ? hash('sha512', $pass_key) : $pass_hash);

		for ($n = 0; $n < strlen($index); $n++) {
			$p[] =  substr($pass_hash, $n, 1);
		}

		array_multisort($p, SORT_DESC, $i);
		$index = implode($i);
	}

	if ($to_num) {
		// Digital number  <<--  alphabet letter code
		$len = strlen($in) - 1;

		for ($t = $len; $t >= 0; $t--) {
			$bcp = bcpow($base, $len - $t);
			$out = $out + strpos($index, substr($in, $t, 1)) * $bcp;
		}

		if (is_numeric($pad_up)) {
			$pad_up--;

			if ($pad_up > 0) {
				$out -= pow($base, $pad_up);
			}
		}
	} else {
		// Digital number  -->>  alphabet letter code
		if (is_numeric($pad_up)) {
			$pad_up--;

			if ($pad_up > 0) {
				$in += pow($base, $pad_up);
			}
		}

		for ($t = ($in != 0 ? floor(log($in, $base)) : 0); $t >= 0; $t--) {
			$bcp = bcpow($base, $t);
			$a   = floor($in / $bcp) % $base;
			$out = $out . substr($index, $a, 1);
			$in  = $in - ($a * $bcp);
		}
	}

	return $out;
}
  */
// Function for user data
/*
function userdata($value,$redir){
	global $con;
	$data= array();
	@$user_id = user_ID($_COOKIE['cs_user'], true);
	@$session = $_COOKIE['acceder'];
	@$pass = $_COOKIE['cs_pass'];
	@$Uid = $user_id;
	if (@$session!='' and @$Uid!='') {
		$r = mysqli_query($con,"SELECT * from user WHERE session = '$session' AND userID = '$Uid'") or die ("error en la consulta". mysqli_connect_error()) ;
		if (mysqli_num_rows($r) > 0) {
			$data = mysqli_fetch_array($r, MYSQLI_ASSOC);
			if($pass==$data['pass']){
				echo '';
			}else{
				exit ('Error de seguridad');
			}
		} else {
			setcookie("cs_mail", trim(''), time() + $s, '/', null, null, true);
					setcookie("cs_pass", trim(''), time() + $s, '/', null, null, true);
					setcookie("cs_user", trim(''), time() + $s, '/', null, null, true);
					setcookie("acceder", trim(''), time() + $s, '/', null, null, true);
					session_destroy();
					@header("Location:./");
					exit('<meta http-equiv="Refresh" content="0;url=login">');
		}
		
		if ($data['banned']) {
			exit ('Error: Su cuenta se encuentra desactivada');
		}
	} elseif ($redir) {
		setcookie('cs_user', '', time()-1);
		@header("Location:login");
		exit('<meta http-equiv="Refresh" content="0;url=login">');
	}

	if (@$data['vip']) { 
		$restdays=dateDiff(date('d-m-Y'),$data['vipdate']);
		if ($restdays<=0) {
			$sql = "UPDATE user SET vip=0, vipdate='' WHERE userID='$Uid'";
			mysqli_query($con, $sql) or die ("error en la consulta ". mysqli_error());
		}
	}

	return @$data[$value];
}
*/
 
 
	 

	if (!file_exists('install.php')) {
		$install = '';
	}else{
		$install = '<div class="install_admin"><p class="delete_file_admin">once the installation was done you have to delete the file install.php<br><br> <a href=dashboard?action=install_delete class="style_a admin_a_wall_chats">click here to remove</a></p></div>';
	}



	/*
	this PHP function is for NOT NOTIFYING SYSTEM ERRORS SINCE THERE ARE SOME BUT ARE BECAUSE THE META TAGS DO NOT 
	EXIST EXAMPLE IF THEY SEEK A FACEBOOK VIDEO AS WAS DELETED FACEBOOK GIVES A 404 ERROR AND THE VIDEO TAGS ARE NOT
	--------------
	-----BUT EVERYTHING WORKS WELL
	*/
	//error_reporting (E_ALL);
	error_reporting(0);

	//-- THIS FUNCTIONS ARE TO ACTIVATE OR DEACTIVATE THE SITES TO DOWNLOAD VIDEOS
	//-- ACTIVATE = TRUE
	//-- DEACTIVATE = FALSE
	$settings = mysqli_query($con,"Select * From settings");
	while($data = mysqli_fetch_array($settings)){
	
		//-- Admin
		$admin = $data['admin'];
		$email = $data['email'];
		$cookies = $data['cookies'];
		$error = $data['error_system'];
		//-- Captcha
		$data_Captcha = $data['Captcha'];
		$Site_Key = $data['Site_Key'];
		$Hashes = $data['Hashes'];
		//-- advertising spot
		$ad_one = $data['ads_one'];
		$ad_two = $data['ads_two'];
		if ($error){
			error_reporting (E_ALL);
		}else{
			error_reporting(0);
		}	
		//== Titule of site
		$titule_site = $data['name'];
		$Description_site = $data['Description'];
		//== YouTube
		if ($data['echo_youtube']){
			@$youtube = TRUE;
		}else{
			@$youtube = FALSE;
		}
		//== FaceBook
		if ($data['echo_facebook']){
			@$facebook = TRUE;
		}else{
			@$facebook = FALSE;
		}
		//== Vimeo
		if ($data['echo_vimeo']){
			@$vimeo = TRUE;
		}else{
			@$vimeo = FALSE;
		}
		//== dailymotion
		if ($data['echo_dailymotion']){
			@$dailymotion = TRUE;
		}else{
			@$dailymotion = FALSE;
		}
		//== Instagram
		if ($data['echo_instagram']){
			@$instagram = TRUE;
		}else{
			@$instagram = FALSE;
		}
		//== flooxer
		if ($data['echo_flooxer']){
			@$flooxer = TRUE;
		}else{
			@$flooxer = FALSE;
		}
		//== liveleak
		if ($data['echo_liveleak']){
			@$liveleak = TRUE;
		}else{
			@$liveleak = FALSE;
		}
		//== imgur
		if ($data['echo_imgur']){
			@$imgur = TRUE;
		}else{
			@$imgur = FALSE;
		}
		//===============================>
		//== manual to change the language:  en/English - es/Spanish - fr/French - it/Italian - ru/Russian - tr/trick - zh/Chinese - pt/Portuguese - de/German
		$Languages_web = $data['language'];
		//===============================>
		
	}
?>