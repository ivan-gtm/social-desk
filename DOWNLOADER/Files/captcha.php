<div class="wall_modal_captcha">
	<div class="captcha_modal">
		<form method="post">
		<input type="hidden" name="sended" value="true"></input>
		<input type="hidden" name="captcha" value="1"></input>
			<!-- other form fields -->
			<img class="img_robot" src="./assets/img/robot.png"/>
			<br>
			<br>
			<p class="text_robot_p"><?php echo $lang11; ?></p>
			<script src="https://authedmine.com/lib/captcha.min.js" async></script>
			<script>
				//-- setCookie
				function setCookie(cname,cvalue,exdays) {
					var d = new Date();
					d.setTime(d.getTime() + (exdays*24*60*60*1000));
					var expires = "expires=" + d.toGMTString();
					document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
				}

				function getCookie(cname) {
					var name = cname + "=";
					var decodedCookie = decodeURIComponent(document.cookie);
					var ca = decodedCookie.split(';');
					for(var i = 0; i < ca.length; i++) {
						var c = ca[i];
						while (c.charAt(0) == ' ') {
							c = c.substring(1);
						}
						if (c.indexOf(name) == 0) {
							return c.substring(name.length, c.length);
						}
					}
					return "";
				}

				function checkCookie() {
					var user=getCookie("captcha");
					if (user != "") {
						$(".wall_modal_captcha").css("display", "none");
					} else {
						  
					}
				}
				//-- function captcha
				function myCaptchaCallback(token) {
					//alert('Hashes reached. Token is: ' + token);
					$(".submit_captcha").css("background-color", "#21b0f9");
					$(".wall_modal_captcha").css("display", "none");
					setCookie("captcha", "true", 1); // day one
				}

				 
			</script>
			<br>
			<div class="coinhive-captcha" 
				data-hashes="<?php echo $Hashes; ?>" 
				data-key="<?php echo $Site_Key;?>"
				data-whitelabel="false"
				data-disable-elements="input[type=submit]"
				data-callback="myCaptchaCallback"
			>
				<em>Loading Captcha...<br>
				If it doesn't load, please disable Adblock!</em>
			</div>

			<br>
			<!--input class="submit_captcha" type="submit" value="Submit"/-->
			<p></p>
		</form>
	</div>
</div>	
