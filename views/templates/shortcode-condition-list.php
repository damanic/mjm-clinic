<div id="mjm_clinic_shortcode_condition_list_contain">

    <?php if($search){?>
    <input class="mjm_clinic_shortcode_condition_list_search" placeholder="Search" />
    <?}?>

    <ul class="mjm_clinic_shortcode_condition_list">
        <?= $entries ?>
    </ul>

</div>

<script src="<?=  plugins_url('../../js/list.min.js', __FILE__) ?>"></script>
<?
//list options
    $value_names = '';
    $value_names .= $searchable_title ? "'mjm_clinic_shortcode_condition_list_name'," : null;
    $value_names .= ($searchable_excerpt && $show_excerpt) ? "'mjm_clinic_shortcode_condition_list_excerpt'," : null;
    $value_names .= ($searchable_tags && $show_indication_tags) ? "'mjm_clinic_shortcode_condition_list_tags_contain'," : null;
    $value_names = empty($value_names) ? null : substr($value_names,0,-1);
?>
<script>
    var options = {
        listClass: 'mjm_clinic_shortcode_condition_list',
        page: <?=$paginate?>,
        indexAsync: false,
        searchClass: 'mjm_clinic_shortcode_condition_list_search',
        valueNames: [ <?=$value_names?> ]
    };

    var userList = new List('mjm_clinic_shortcode_condition_list_contain', options);
</script>