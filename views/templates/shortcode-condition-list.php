<div id="mjm_clinic_shortcode_condition_list_contain_<?php echo esc_attr($container_id) ?>">

	<?php if($search){?>
		<input class="mjm_clinic_shortcode_condition_list_search" placeholder="Search" />
	<?php } ?>

	<ul class="mjm_clinic_shortcode_condition_list">
		<?php echo $entries // Ensure that $entries is properly sanitized or constructed to avoid XSS vulnerabilities ?>
	</ul>

</div>


<?php if($search){
//list options
	$value_names = '';
	$value_names .= $searchable_title ? "'mjm_clinic_shortcode_condition_list_name_".esc_js($container_id)."'," : '';
	$value_names .= ($searchable_excerpt && $show_excerpt) ? "'mjm_clinic_shortcode_condition_list_excerpt_".esc_js($container_id)."'," : '';
	$value_names .= ($searchable_tags && $show_indication_tags) ? "'mjm_clinic_shortcode_condition_list_tags_contain_".esc_js($container_id)."'," : '';
	$value_names = empty($value_names) ? '' : substr($value_names,0,-1);
	?>

	<script>
		jQuery(document).ready(function(){
			var options = {
				listClass: 'mjm_clinic_shortcode_condition_list',
				page: <?php echo esc_js($paginate)?>,
				searchClass: 'mjm_clinic_shortcode_condition_list_search',
				valueNames: [ <?php echo $value_names?> ],
			};


			var userList_<?php echo esc_js($container_id) ?> = new List('mjm_clinic_shortcode_condition_list_contain_<?php echo esc_attr($container_id) ?>', options);

		});
	</script>

<?php }?>
