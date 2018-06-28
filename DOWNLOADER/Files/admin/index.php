<?php
	require ("ConectarDtata.php");
	require_once ("languages/$Languages_web.php");
	require ("header.php");
if (@$_COOKIE["auser"]!='') {		
	require ("includes/menu.php");
	require ("includes/aside.php");

		@$action = $_GET['action'];

	switch ($action) {
		case 'actions':
				require ("sources/actions.php");
			break;
		case 'ads':
				require ("sources/advertisements.php");
			break;
		case 'captcha':
				require ("sources/captcha.php");
			break;
		case 'settings':
				require ("sources/settings.php");
			break;
		case 'password':
				require ("sources/password.php");
			break;
		case 'system':
				require ("sources/system.php");
			break;
		default:
				require ("sources/dashboard.php");
			break;
	}
	//require ("includes/footer.php");
}else{
	require ("sources/login.php");	
}		
?>
