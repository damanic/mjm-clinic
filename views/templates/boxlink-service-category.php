<div class="mjm_clinic_service_boxlink_category_container">
    <a class="mjm_clinic_service_boxlink_a" href="<?= get_term_link($category)?>">
        <div class="mjm_clinic_service_boxlink_image_contain">
        <? if($image){ ?>
            <img class="mjm_clinic_service_boxlink_image" src="<?=$image?>" />
       <? } else { ?>
            <i class="fa fa-plus-square fa-5x mjm_clinic_service_boxlink_icon"></i>
        <?}?>
            </div>
        <h3 class="mjm_clinic_service_boxlink_title"><?= $category->name ?></h3>
        <p class="mjm_clinic_service_boxlink_excerpt"><?=$category_meta['excerpt']?></p>
    </a>
</div>