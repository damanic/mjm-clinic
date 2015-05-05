<div class="form-field">
	<label for="term_meta[excerpt]"><?php _e('Excerpt', 'mjm-clinic')?></label>
	<input type="text" name="term_meta[excerpt]" id="term_meta[excerpt]" value="">

	<p class="description"><?php _e('This short description is used in category list views')?> </p>
</div>

<script type="text/javascript">
	jQuery('document').ready(function () {
		jQuery("label[for='tag-description']").text("Long Description");
	});
</script>