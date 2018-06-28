<section id="wall_section">
	<div class="name_session_t">
		<p class="name_session_text"><?php echo $lags19; ?><br><spam class="name_session_text_spam"><?php echo $lags20; ?></spam></p>
	</div>
	<div class="div_statistics_panel">
		<div class="wall_class_actions">
		<form method="post" action="content_data.php?data=actions" charset="UTF-8">
			<!-- action -->
			<!--youtube-->
			<div class="background_wall_don">
				<div class="class_actions_display">
					<img class="wall_div_statistics_panel_img" src="./assets/img/youtube.png"></img>
					<p class="text_action">YouTube</p>
					<div class="action_plugis_div">
						<div class="lis_class_system">
							<label class="switch">
					<?php
						echo '<select class="slider_select" name="youtube" id="youtube">';
						if ($youtube){
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
						</div>
						<p class="action_plugis_div_p"></p>
					</div>
				</div>	
			</div>
			<!--vimeo-->
			<div class="background_wall_don">
				<div class="class_actions_display">
					<img class="wall_div_statistics_panel_img" src="./assets/img/vimeo.png"></img>
					<p class="text_action">Vimeo</p>
					<div class="action_plugis_div">
						<div class="lis_class_system">
							<label class="switch">
					<?php
						echo '<select class="slider_select" name="vimeo" id="vimeo">';
						if ($vimeo){
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
						</div>
						<p class="action_plugis_div_p"></p>
					</div>
				</div>	
			</div>
			<!--facebook-->
			<div class="background_wall_don">
				<div class="class_actions_display">
					<img class="wall_div_statistics_panel_img" src="./assets/img/facebook.png"></img>
					<p class="text_action">facebook</p>
					<div class="action_plugis_div">
						<div class="lis_class_system">
							<label class="switch">
					<?php
						echo '<select class="slider_select" name="facebook" id="facebook">';
						if ($facebook){
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
						</div>
						<p class="action_plugis_div_p"></p>
					</div>
				</div>	
			</div>
			<!--dailymotion-->
			<div class="background_wall_don">
				<div class="class_actions_display">
					<img class="wall_div_statistics_panel_img" src="./assets/img/dailymotion.png"></img>
					<p class="text_action">Dailymotion</p>
					<div class="action_plugis_div">
						<div class="lis_class_system">
							<label class="switch">
					<?php
						echo '<select class="slider_select" name="dailymotion" id="dailymotion">';
						if ($dailymotion){
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
						</div>
						<p class="action_plugis_div_p"></p>
					</div>
				</div>	
			</div>
			<!--instagram-->
			<div class="background_wall_don">
				<div class="class_actions_display">
					<img class="wall_div_statistics_panel_img" src="./assets/img/instagram.png"></img>
					<p class="text_action">instagram</p>
					<div class="action_plugis_div">
						<div class="lis_class_system">
							<label class="switch">
					<?php
						echo '<select class="slider_select" name="instagram" id="instagram">';
						if ($instagram){
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
						</div>
						<p class="action_plugis_div_p"></p>
					</div>
				</div>	
			</div>
			<!--flooxer-->
			<div class="background_wall_don">
				<div class="class_actions_display">
					<img class="wall_div_statistics_panel_img" src="./assets/img/flooxer.png"></img>
					<p class="text_action">flooxer</p>
					<div class="action_plugis_div">
						<div class="lis_class_system">
							<label class="switch">
					<?php
						echo '<select class="slider_select" name="flooxer" id="flooxer">';
						if ($flooxer){
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
						</div>
						<p class="action_plugis_div_p"></p>
					</div>
				</div>	
			</div>
			<!--liveleak-->
			<div class="background_wall_don">
				<div class="class_actions_display">
					<img class="wall_div_statistics_panel_img" src="./assets/img/liveleak.png"></img>
					<p class="text_action">Liveleak</p>
					<div class="action_plugis_div">
						<div class="lis_class_system">
							<label class="switch">
					<?php
						echo '<select class="slider_select" name="liveleak" id="liveleak">';
						if ($liveleak){
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
						</div>
						<p class="action_plugis_div_p"></p>
					</div>
				</div>	
			</div>
			<!--imgur-->
			<div class="background_wall_don">
				<div class="class_actions_display">
					<img class="wall_div_statistics_panel_img" src="./assets/img/imgur.png"></img>
					<p class="text_action">imgur</p>
					<div class="action_plugis_div">
						<div class="lis_class_system">
							<label class="switch">
					<?php
						echo '<select class="slider_select" name="imgur" id="imgur">';
						if ($imgur){
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
						</div>
						<p class="action_plugis_div_p"></p>
					</div>
				</div>	
			</div>						
				<br>
				<br>
			<center>
				<input class="button_admin_more" type="submit" value="<?php echo $lags5; ?>"/> 
			</center>
		</form>	
		</div>		
	</div>
</section>