<div class="mjm_clinic_select_service-meta">
    <label for="mjm_clinic_related_service_id">
        <strong><?php echo __( 'Relates to Service:', 'mjm-clinic' ) ?></strong>
    </label>

    <br />

    <select id="mjm_clinic_related_service_id" name="mjm_clinic_related_service_id">
        <option>Select Service...</option>
        <?php
        $services = mjm_clinic_get_service_list();
            foreach($services as $service_id => $service_title){
                $selected = NULL;
                if($service_id == $post->mjm_clinic_related_service_id) {
                    $selected = 'selected="selected"';
                }
                    echo '<option value="' . esc_attr($service_id) . '" '.$selected.'>' . esc_html($service_title) . '</option>';
            }
        ?>
    </select>
</div>

