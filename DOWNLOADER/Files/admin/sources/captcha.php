<section id="wall_section">
	<div class="name_session_t">
		<p class="name_session_text">Captcha coinhive<br><spam class="name_session_text_spam">Captcha coinhive Sites Keys</spam></p>
	</div>
	<form method="post" action="content_data.php?data=captcha" charset="UTF-8">
	<div class="div_statistics_panel">
		<div class="wall_class_settings">
			<p class="text_p">Site Key (public)</p>
			<input class="class_settings_input" type="text" value="<?php echo $Site_Key;?>" name="Site_Key"  placeholder="TMJsEmrrqvIOSMBy2kRkYH1eOBXBbeEV"/>
			<br><br>
			<p class="text_p"><?php echo $lags16; ?></p>
			<input class="mini_input class_settings_input"type="number" value="<?php echo $Hashes;?>" name="Hashes"  placeholder="1024"/>
			<br>
			<br>
				<div class="lis_class_system">
					<label class="switch">
					<?php
					
					
			
						echo '<select class="slider_select" name="Captcha" id="Captcha">';
						if ($data_Captcha){
							echo '
							<option value="1">'.$lags17.'</option>
							<option value="0">'.$lags18.'</option>';
						}else{
							echo '
							<option value="0">'.$lags18.'</option>
							<option value="1">'.$lags17.'</option>';
						}
						echo '</select>';
					 
					?>  
					  <span class="slider"></span>
					</label>
					<p class="lis_class_system_one_p"><?php echo $lags15; ?></p>
				</div>
				<br>
				<br>
				<br>
			<center>
				<input class="button_admin_more" type="submit" value="<?php echo $lags5; ?>"/> 
			</center>
		</div>
	</div>
	</form>
</section>