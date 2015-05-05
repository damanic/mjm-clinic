<tr class="form-field">
	<th scope="row" valign="top"><label for="term_meta[excerpt]"><?php _e('Excerpt', 'mjm-clinic'); ?></label>
	</th>
	<td>
		<input type="text" name="term_meta[excerpt]" id="term_meta[excerpt]"
			   value="<?php echo esc_attr($term_meta['excerpt']) ? esc_attr($term_meta['excerpt']) : ''; ?>">

		<p class="description"><?php _e('This short description is used in category list views', 'mjm-clinic'); ?></p>
	</td>
</tr>
<?php