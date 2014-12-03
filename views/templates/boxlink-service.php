<div class="mjm_clinic_service_boxlink_container">
    <a class="mjm_clinic_service_boxlink_a" href="<?=get_the_permalink($post)?>">
        <div class="mjm_clinic_service_boxlink_image_contain">
        <?if( $image ){ ?>
            <img class="mjm_clinic_service_boxlink_image" src="<?=$image_url?>" />
        <?} else { ?>
            <i class="fa fa-plus-square fa-5x mjm_clinic_service_boxlink_icon"></i>
        <?}?>
        </div>
        <h3 class="mjm_clinic_service_boxlink_title"><?= $post->post_title ?></h3>
        <p class="mjm_clinic_service_boxlink_excerpt"><?= $post->post_excerpt ?></p>
    </a>
</div>