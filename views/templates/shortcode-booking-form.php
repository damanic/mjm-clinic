<form method="post" class="mjm_clinic_booking_form">
    <input type="hidden" name="mjm-clinic-bf" value="1"/>
    <?
    $services = mjm_clinic_get_service_list();
    if($selected_service_id && $block_service_select) { ?>
        <input type="hidden" name="mjm_clinic_bf_service_select" value="<?=$selected_service_id?>"/>
        <h4 class="mjm_clinic_bf_service_title"><?= __( 'Booking for:', 'mjm-clinic' ) ?> <?=$services[$selected_service_id]?></h4>
    <?} else { ?>
    <label for="mjm_clinic_bf_service_select"><?= __( 'Service', 'mjm-clinic' ) ?></label>
    <select  class="mjm_clinic_bf_service_select mjm_clinic_input_select"
             name="mjm_clinic_bf_service_select"
             required/>
        <option value=""><?= __( 'Select Service', 'mjm-clinic' ) ?>...</option>
        <?
        foreach($services as $service_id => $service_title){
            $selected = ($selected_service_id == $service_id) ? 'selected="selected"' : null;
            echo '<option value="' . $service_id . '" '.$selected.'>' . $service_title . '</option>';
        }
        ?>
    </select>
    <? } ?>

    <?
    $locations = mjm_clinic_get_location_list();
    if($selected_location_id && $block_location_select) { ?>
        <h4 class="mjm_clinic_bf_location_title"><?= __( '@', 'mjm-clinic' ) ?> <?=$locations[$selected_location_id]?></h4>
        <input type="hidden" name="mjm_clinic_bf_location_select" value="<?=$selected_location_id?>"/>
    <?} else { ?>
        <label for="mjm_clinic_bf_location_select"><?= __( 'Location', 'mjm-clinic' ) ?></label>
        <select  class="mjm_clinic_bf_location_select mjm_clinic_input_select"
                 name="mjm_clinic_bf_location_select"
                 required/>
        <option value=""><?= __( 'Select Location', 'mjm-clinic' ) ?>...</option>
        <?
        foreach($locations as $location_id => $location_title){
            $selected = ($selected_location_id == $location_id) ? 'selected="selected"' : null;
            echo '<option value="' . $location_id . '" '.$selected.'>' . $location_title . '</option>';
        }
        ?>
        </select>
    <? } ?>

    <label for="mjm_clinic_bf_name"><?= __( 'Your Name', 'mjm-clinic' ) ?></label>
    <input class="mjm_clinic_bf_name mjm_clinic_input_text"
           name="mjm_clinic_bf_name"
           required/>

    <label for="mjm_clinic_bf_date_picker "><?= __( 'Preferred Date', 'mjm-clinic' ) ?></label>
    <input class="mjm_clinic_bf_date_picker mjm_clinic_input_text"
           type="text"
           name="mjm_clinic_bf_date_picker"
           required/>


    <label for="mjm_clinic_bf_preferred_time_select"><?= __( 'Preferred Time', 'mjm-clinic' ) ?></label>
    <select class="mjm_clinic_bf_preferred_time_select mjm_clinic_input_select"
           name="mjm_clinic_bf_preferred_time_select"
           required>
        <option value="morning"><?= __( 'Morning', 'mjm-clinic' ) ?></option>
        <option value="afternoon"><?= __( 'Afternoon', 'mjm-clinic' ) ?></option>
    </select>

    <label for="mjm_clinic_bf_contact_via_select"><?= __( 'Please confirm my booking via', 'mjm-clinic' ) ?></label>
    <select class="mjm_clinic_bf_contact_via_select mjm_clinic_input_select"
            name="mjm_clinic_bf_contact_via_select">
        <option value="email" SELECTED="SELECTED"><?= __( 'E-mail', 'mjm-clinic' ) ?></option>
        <option value="phone"><?= __( 'Phone', 'mjm-clinic' ) ?></option>
    </select>

    <div class="mjm_clinic_bf_email_toggle_contain">
        <label for="mjm_clinic_bf_email"><?= __( 'E-mail', 'mjm-clinic' ) ?></label>
        <input class="mjm_clinic_bf_email mjm_clinic_input_text"
               type="email"
               name="mjm_clinic_bf_email"
               required/>
    </div>


    <div class="mjm_clinic_bf_phone_toggle_contain" style="display: none;">
        <label for="mjm_clinic_bf_phone"><?= __( 'Phone', 'mjm-clinic' ) ?></label>
        <input class="mjm_clinic_bf_phone mjm_clinic_input_text"
               type="tel"
               name="mjm_clinic_bf_phone"
               required/>
    </div>

    <label for="mjm_clinic_bf_message"><?= __( 'Optional Message', 'mjm-clinic' ) ?></label>
    <textarea name="mjm_clinic_bf_message"
              class="mjm_clinic_input_textarea mjm_clinic_bf_message"></textarea>

    <input class="mjm_clinic_bf_submit_button" type="submit" value="<?= __( 'Send', 'mjm-clinic' ) ?>" />

</form>

<div class="mjm_clinic_bf_success_msg_contain" style="display: none;">
    <span class="mjm_clinic_bf_success_msg"><i class="mjm_clinic_bf_success_msg_icon fa fa-thumbs-up"></i>
            <?=__('Thank you.','mjm-clinic')?> <?=__('Your booking request has been received.','mjm-clinic')?> <?=__('We will contact you shortly to confirm your booking.','mjm-clinic')?>
    </span>
</div>