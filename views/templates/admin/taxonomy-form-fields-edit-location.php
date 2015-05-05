<tr class="form-field">
	<th scope="row" valign="top"><label for="term_meta[tel]"><?php _e('Phone', 'mjm-clinic'); ?></label></th>
	<td>
		<input type="text" name="term_meta[tel]" id="term_meta[tel]"
			   value="<?php echo esc_attr($term_meta['tel']) ? esc_attr($term_meta['tel']) : ''; ?>">

		<p class="description"><?php _e('Booking Phone', 'mjm-clinic'); ?></p>
	</td>
</tr>
<tr class="form-field">
	<th scope="row" valign="top"><label for="term_meta[email]"><?php _e('Email', 'mjm-clinic'); ?></label></th>
	<td>
		<input type="text" name="term_meta[email]" id="term_meta[email]"
			   value="<?php echo esc_attr($term_meta['email']) ? esc_attr($term_meta['email']) : ''; ?>">

		<p class="description"><?php _e('Booking Email', 'mjm-clinic'); ?></p>
	</td>
</tr>
<tr class="form-field">
	<th scope="row" valign="top"><label
			for="term_meta[contact_link]"><?php _e('Contact Link', 'mjm-clinic'); ?></label></th>
	<td>
		<input type="text" name="term_meta[contact_link]" id="term_meta[contact_link]"
			   value="<?php echo esc_attr($term_meta['contact_link']) ? esc_attr($term_meta['contact_link']) : ''; ?>">

		<p class="description"><?php _e('URL Link to a booking/contact form.
                                              You can use {service_id} and or {service_name} placeholders in your URL
                                              if you want to pass this information to your contact form.
                                              An entry in this field will over-ride the built in form handlers.', 'mjm-clinic'); ?></p>
	</td>
</tr>
<tr class="form-field">
	<th scope="row" valign="top"><label
			for="term_meta[open_hours]"><?php _e('Open Hours', 'mjm-clinic'); ?></label></th>
	<td>
                <textarea cols="40" rows="6" name="term_meta[open_hours]"
						  id="term_meta[open_hours]"><?php echo esc_attr($term_meta['open_hours']) ? esc_attr($term_meta['open_hours']) : ''; ?></textarea>

		<p class="description"><?php _e('Operational hours for this location', 'mjm-clinic'); ?></p>
	</td>
</tr>
<tr class="form-field">
	<th scope="row" valign="top"><label
			for="term_meta[map_link]"><?php _e('Map Location', 'mjm-clinic'); ?></label></th>
	<td>
		<input type="text" name="term_meta[map_link]" id="term_meta[map_link]"
			   value="<?php echo esc_attr($term_meta['map_link']) ? esc_attr($term_meta['map_link']) : ''; ?>">

		<p class="description"><?php _e('Enter the Latitude and Longitude values for this location separated with a comma. Eg. 38.897676, -77.036530', 'mjm-clinic')?></p>

		<p class="description"><?php _e('You can find these values @ http://www.latlong.net/convert-address-to-lat-long.html', 'mjm-clinic')?></p>

	</td>
</tr>
<script type="text/javascript">
	jQuery('document').ready(function () {
		jQuery("label[for='description']").text('<?php _e( 'Address','mjm-clinic')?>');
	});
</script>