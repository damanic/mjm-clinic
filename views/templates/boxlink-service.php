<div class="mjm_clinic_service_boxlink_container">
    <a class="mjm_clinic_service_boxlink_a" href="<?=get_the_permalink()?>">
        <div class="mjm_clinic_service_boxlink_image_contain">
        <?if( $image ){ ?>
            <img class="mjm_clinic_service_boxlink_image" src="<?=$image_url?>" />
        <?} else { ?>
            <i class="fa fa-plus-square fa-5x mjm_clinic_service_boxlink_icon"></i>
        <?}?>
        </div>
        <h3 class="mjm_clinic_service_boxlink_title"><?= get_the_title() ?></h3>
        <p class="mjm_clinic_service_boxlink_excerpt"><?= get_the_excerpt() ?></p>
    </a>
</div>