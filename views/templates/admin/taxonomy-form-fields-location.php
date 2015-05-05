<div class="form-field">
	<label for="term_meta[tel]"><?php _e('Phone', 'mjm-clinic')?></label>
	<input type="text" name="term_meta[tel]" id=" term_meta[tel]" value="">

	<p class="description"><?php _e('Booking Phone', 'mjm-clinic')?></p>
</div>

<div class="form-field">
	<label for="term_meta[email]"><?php _e('Email', 'mjm-clinic')?></label>
	<input type="text" name="term_meta[email]" id="term_meta[email]" value="">

	<p class="description"><?php _e('Booking Email', 'mjm-clinic')?></p>
</div>

<div class="form-field">
	<label for="term_meta[contact_link]"><?php _e('Contact Link', 'mjm-clinic')?></label>
	<input type="text" name="term_meta[contact_link]" id="term_meta[contact_link]" value="">

	<p class="description"><?php _e('URL Link to a booking/contact form.
                                              You can use {service_id} and or {service_name} placeholders in your URL
                                              if you want to pass this information to your contact form.
                                              An entry in this field will over-ride the built in form handlers.', 'mjm-clinic')?></p>
</div>

<div class="form-field">
	<label for="term_meta[open_hours]"><?php _e('Open Hours', 'mjm-clinic')?></label>
	<textarea cols="40" rows="6" name="term_meta[open_hours]" id="term_meta[open_hours]"></textarea>

	<p class="description"><?php _e('Operational hours, for this location.', 'mjm-clinic')?></p>
</div>

<div class="form-field">
	<label for="term_meta[map_link]"><?php _e('Map Location', 'mjm-clinic')?></label>
	<input type="text" name="term_meta[map_link]" id="term_meta[map_link]" value="">

	<p class="description"><?php _e('Enter the Latitude and Longitude values for this location separated with a comma. Eg. 38.897676, -77.036530', 'mjm-clinic')?></p>

	<p class="description"><?php _e('You can find these values @ http://www.latlong.net/convert-address-to-lat-long.html', 'mjm-clinic')?></p>

</div>

<script type="text/javascript">
	jQuery('document').ready(function () {
		jQuery("label[for='description']").text('<?php _e( 'Address','mjm-clinic')?>');
	});
</script>