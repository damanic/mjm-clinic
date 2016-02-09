<div id="mjm_clinic_shortcode_condition_list_contain_<?php echo $container_id ?>">

    <?php if($search){?>
    <input class="mjm_clinic_shortcode_condition_list_search" placeholder="Search" />
    <?php } ?>

    <ul class="mjm_clinic_shortcode_condition_list">
        <?php echo $entries ?>
    </ul>

</div>


<?php if($search){
//list options
    $value_names = '';
    $value_names .= $searchable_title ? "'mjm_clinic_shortcode_condition_list_name_".$container_id."'," : null;
    $value_names .= ($searchable_excerpt && $show_excerpt) ? "'mjm_clinic_shortcode_condition_list_excerpt_".$container_id."'," : null;
    $value_names .= ($searchable_tags && $show_indication_tags) ? "'mjm_clinic_shortcode_condition_list_tags_contain_".$container_id."'," : null;
    $value_names = empty($value_names) ? null : substr($value_names,0,-1);
?>

<script>
	jQuery(document).ready(function(){
		var options = {
			listClass: 'mjm_clinic_shortcode_condition_list',
			page: <?php echo $paginate?>,
			searchClass: 'mjm_clinic_shortcode_condition_list_search',
			valueNames: [ <?php echo $value_names?> ],
		};


		var userList_<?php echo $container_id ?> = new List('mjm_clinic_shortcode_condition_list_contain_<?php echo $container_id ?>', options);

	});




</script>

<?php }?>