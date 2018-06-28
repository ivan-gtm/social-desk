<?php
	require ("ConectarDtata.php");
	@$action = $_GET['data'];
		switch ($action) {
			case 'captcha':
					$Captcha = $_POST['Captcha'];
					$Site_Key = $_POST['Site_Key'];
					$Hashes = $_POST['Hashes'];
					$sql = "UPDATE settings SET Site_Key='$Site_Key',Captcha='$Captcha',Hashes='$Hashes'";
					mysqli_query($con, $sql);
					@header("Location:./?action=captcha");
					exit('<meta http-equiv="Refresh" content="0;url=./?action=captcha">');
				break;
			case 'settings':
					$name = $_POST['name'];
					$Description = $_POST['Description'];
					$language = $_POST['language'];
					$sql = "UPDATE settings SET name='$name',Description='$Description',language='$language'";
					mysqli_query($con, $sql);
					@header("Location:./?action=settings");
					exit('<meta http-equiv="Refresh" content="0;url=./?action=settings">');
				break;
			case 'password':
					$admin = $_POST['admin'];
					$email = $_POST['email'];
					$password = md5($_POST['password']);
					$sql = "UPDATE settings SET admin='$admin',email='$email',password='$password'";
					mysqli_query($con, $sql);
					@header("Location:./?action=password");
					exit('<meta http-equiv="Refresh" content="0;url=./?action=password">');
				break;				
			case 'actions':
					$youtube = $_POST['youtube'];
					$vimeo = $_POST['vimeo'];
					$facebook = $_POST['facebook'];
					$dailymotion = $_POST['dailymotion'];
					$instagram = $_POST['instagram'];
					$flooxer = $_POST['flooxer'];
					$liveleak = $_POST['liveleak'];
					$imgur = $_POST['imgur'];
					$sql = "UPDATE settings SET echo_youtube='$youtube',echo_vimeo='$vimeo',echo_facebook='$facebook',echo_dailymotion='$dailymotion',echo_instagram='$instagram',echo_flooxer='$flooxer',echo_liveleak='$liveleak',echo_imgur='$imgur'";
					mysqli_query($con, $sql);
					@header("Location:./?action=actions");
					exit('<meta http-equiv="Refresh" content="0;url=./?action=actions">');
				break;
			case 'ads':
					$as_two = $_POST['as_two'];
					$as_one = $_POST['as_one'];
					$sql = "UPDATE settings SET ads_one='$as_one',ads_two='$as_two'";
					mysqli_query($con, $sql);
					@header("Location:./?action=ads");
					exit('<meta http-equiv="Refresh" content="0;url=./?action=ads">');;
				break;
			case 'system':
					$error = $_POST['error'];
					$cookies = $_POST['cookies'];
					$sql = "UPDATE settings SET error_system='$error',cookies='$cookies'";
					mysqli_query($con, $sql);
					@header("Location:./?action=system");
					exit('<meta http-equiv="Refresh" content="0;url=./?action=system">');;
				break;
			case 'logout':
					$s = 3600; // seconds in a year
					setcookie("cs_mail", trim(''), time() + $s, '/', null, null, true);
					setcookie("cs_pass", trim(''), time() + $s, '/', null, null, true);
					setcookie("cs_user", trim(''), time() + $s, '/', null, null, true);
					setcookie("auser", trim(''), time() + $s, '/', null, null, true);
					session_destroy();
					@header("Location:./");
					exit('<meta http-equiv="Refresh" content="0;url=./">');
				break;
			default:
					echo 'data';
				break;
		}		
?>