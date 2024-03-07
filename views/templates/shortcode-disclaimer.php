<small>
	<i>
		<?php
		$clinic_settings = get_option("mjm_clinic_settings");
		if(isset($clinic_settings['mjm_clinic_disclaimer_toggle']) && $clinic_settings['mjm_clinic_disclaimer_toggle']){
			echo wpautop(wp_kses_post($clinic_settings['mjm_clinic_disclaimer_text']));
		}
		?>
	</i>
</small>