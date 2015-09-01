<small>
	<i>
		<?php
			$clinic_settings = get_option("mjm_clinic_settings");
			if($clinic_settings['mjm_clinic_disclaimer_toggle']){
				echo wpautop($clinic_settings['mjm_clinic_disclaimer_text']);
			}
		?>
	</i>
</small>