<div class="mjm_clinic_select_condition-meta">
    <label for="mjm_clinic_related_condition_id">
        <strong><?php echo __( 'Relates to Health Condition:', 'mjm-clinic' ) ?></strong>
    </label>

    <br />

    <select id="mjm_clinic_related_condition_id" name="mjm_clinic_related_condition_id">
        <option>Select Service...</option>
        <?php
        $conditions = mjm_clinic_get_condition_list();
            foreach($conditions as $condition_id => $condition_title){
                $selected = NULL;
                if($condition_id == $post->mjm_clinic_related_condition_id) {
                    $selected = 'selected="selected"';
                }
                    echo '<option value="' . $condition_id . '" '.$selected.'>' . $condition_title . '</option>';
            }
        ?>
    </select>
</div>

