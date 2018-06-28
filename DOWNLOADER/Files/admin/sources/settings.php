<section id="wall_section">
	<div class="name_session_t">
		<p class="name_session_text"><?php echo $lags25; ?><br><spam class="name_session_text_spam"><?php echo $lags24; ?></spam></p>
	</div>
	<div class="div_statistics_panel">
	<form method="post" action="content_data.php?data=settings" charset="UTF-8">
		<div class="wall_class_settings">
			<p class="text_p"><?php echo $lags26; ?></p>
			<input class="class_settings_input" type="text" name="name" value="<?php echo $titule_site; ?>"/>
			<p class="text_p"><?php echo $lags27; ?></p>
			<input class="class_settings_input" type="text" name="Description" value="<?php echo $Description_site; ?>"/>
			<p class="text_p"><?php echo $lags28; ?></p>
			<?php
			//== manual to change the language:  en/English - es/Spanish - fr/French - it/Italian - ru/Russian - tr/trick - zh/Chinese - pt/Portuguese - de/German
				echo '<select class="lags_slider_select" name="language" id="language">';
				echo '<option value="'.$Languages_web.'">'.$Languages[$Languages_web].'</option>';
				echo '<option value="en">'.$Languages['en'].'</option>';
				echo '<option value="es">'.$Languages['es'].'</option>';			
				echo '<option value="fr">'.$Languages['fr'].'</option>';			
				echo '<option value="it">'.$Languages['it'].'</option>';			
				echo '<option value="ru">'.$Languages['ru'].'</option>';			
				echo '<option value="tr">'.$Languages['tr'].'</option>';			
				echo '<option value="zh">'.$Languages['zh'].'</option>';			
				echo '<option value="pt">'.$Languages['pt'].'</option>';			
				echo '<option value="de">'.$Languages['de'].'</option>';			
				echo '</select>';		 
			?>
			<br>
			<!--p class="text_p">imagen logo</p>
			<img src="./assets/img/vimeo.png"></img-->
			<br>
			<center>
				<input class="button_admin_more" type="submit" value="<?php echo $lags5; ?>"/> 
			</center>
		</div>
	</form>	
	</div>
</section>