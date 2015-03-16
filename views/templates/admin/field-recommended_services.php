<div class="mjm_clinic_recommended_services-meta">
    <label for="mjm_clinic_recommended_service_selector">
        <strong><?php echo __( 'Recommended Services:', 'mjm-clinic' ) ?></strong>
    </label>

    <br />

    <select id="mjm_clinic_recommended_service_selector">
        <option>Add a service...</option>
        <?php $services = mjm_clinic_get_service_list();
            foreach($services as $service_id => $service_title){
                echo '<option value="'.$service_id.'">'.$service_title.'</option>';
            }
        ?>
    </select>
    <input class="button mjm-clinic-tagsadd"
           type="button"
           value="Add"
           data-mjm-clinic-ntdelbutton-prefix="mjm_clinic_recommended_service">

    <input type="hidden"
           id="mjm_clinic_recommended_service_selected_ids"
           name="mjm_clinic_recommended_service_selected_ids"
           value="<?php echo get_post_meta( $post->ID, 'mjm_clinic_recommended_service_selected_ids', true )?>"/>

        <p>Assignments:</p>
        <div id="mjm_clinic_recommended_service_selections_area"
             class="tagchecklist mjm-clinic-tagchecklist">
            <?php
            if(is_array($service_posts)) {
                foreach ($service_posts as $service_post) {
                ?>
                    <span id="mjm_clinic_recommended_service_entry_<?php echo $service_post->ID?>">
                        <a id="mjm_clinic_recommended_service_remove_<?php echo $service_post->ID?>"
                           class="ntdelbutton mjm-clinic-ntdelbutton"
                           data-mjm-clinic-ntdelbutton-prefix="mjm_clinic_recommended_service">X</a>
                        <?php echo $service_post->post_title?>
                    </span>
                <?php
                }
            }
            ?>
            <!-- List entries -->
        </div>
</div>

