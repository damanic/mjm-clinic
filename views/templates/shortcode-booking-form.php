<form method="post" class="mjm_clinic_booking_form">
    <input type="hidden" name="mjm-clinic-bf" value="1"/>
    <?php
    $services = mjm_clinic_get_service_list();
    if($selected_service_id && $block_service_select) { ?>
        <input type="hidden" name="mjm_clinic_bf_service_select" value="<?php echo $selected_service_id?>"/>
        <h4 class="mjm_clinic_bf_service_title"><?php echo __( 'Booking for:', 'mjm-clinic' ) ?> <?php echo $services[$selected_service_id]?></h4>
    <?php } else { ?>
    <label for="mjm_clinic_bf_service_select"><?php echo __( 'Service', 'mjm-clinic' ) ?></label>
    <select  class="mjm_clinic_bf_service_select mjm_clinic_input_select"
             name="mjm_clinic_bf_service_select"
             required/>
        <option value=""><?php echo __( 'Select Service', 'mjm-clinic' ) ?>...</option>
        <?php
        foreach($services as $service_id => $service_title){
            $selected = ($selected_service_id == $service_id) ? 'selected="selected"' : null;
            echo '<option value="' . $service_id . '" '.$selected.'>' . $service_title . '</option>';
        }
        ?>
    </select>
    <?php } ?>

    <?php
    $locations = mjm_clinic_get_location_list();
    if($selected_location_id && $block_location_select) { ?>
        <h4 class="mjm_clinic_bf_location_title"><?php echo __( '@', 'mjm-clinic' ) ?> <?php echo $locations[$selected_location_id]?></h4>
        <input type="hidden" name="mjm_clinic_bf_location_select" value="<?php echo $selected_location_id?>"/>
    <?php } else { ?>
        <label for="mjm_clinic_bf_location_select"><?php echo __( 'Location', 'mjm-clinic' ) ?></label>
        <select  class="mjm_clinic_bf_location_select mjm_clinic_input_select"
                 name="mjm_clinic_bf_location_select"
                 required/>
        <option value=""><?php echo __( 'Select Location', 'mjm-clinic' ) ?>...</option>
        <?php
        foreach($locations as $location_id => $location_title){
            $selected = ($selected_location_id == $location_id) ? 'selected="selected"' : null;
            echo '<option value="' . $location_id . '" '.$selected.'>' . $location_title . '</option>';
        }
        ?>
        </select>
    <?php } ?>

    <label for="mjm_clinic_bf_name"><?php echo __( 'Your Name', 'mjm-clinic' ) ?></label>
    <input class="mjm_clinic_bf_name mjm_clinic_input_text"
           name="mjm_clinic_bf_name"
           required/>

    <label for="mjm_clinic_bf_date_picker "><?php echo __( 'Preferred Date', 'mjm-clinic' ) ?></label>
    <input class="mjm_clinic_bf_date_picker mjm_clinic_input_text"
           type="text"
           name="mjm_clinic_bf_date_picker"
           required/>


    <label for="mjm_clinic_bf_preferred_time_select"><?php echo __( 'Preferred Time', 'mjm-clinic' ) ?></label>
    <select class="mjm_clinic_bf_preferred_time_select mjm_clinic_input_select"
           name="mjm_clinic_bf_preferred_time_select"
           required>
        <option value="morning"><?php echo __( 'Morning', 'mjm-clinic' ) ?></option>
        <option value="afternoon"><?php echo __( 'Afternoon', 'mjm-clinic' ) ?></option>
    </select>

    <label for="mjm_clinic_bf_contact_via_select"><?php echo __( 'Please confirm my booking via', 'mjm-clinic' ) ?></label>
    <select class="mjm_clinic_bf_contact_via_select mjm_clinic_input_select"
            name="mjm_clinic_bf_contact_via_select">
        <option value="email" SELECTED="SELECTED"><?php echo __( 'E-mail', 'mjm-clinic' ) ?></option>
        <option value="phone"><?php echo __( 'Phone', 'mjm-clinic' ) ?></option>
    </select>

    <div class="mjm_clinic_bf_email_toggle_contain">
        <label for="mjm_clinic_bf_email"><?php echo __( 'E-mail', 'mjm-clinic' ) ?></label>
        <input class="mjm_clinic_bf_email mjm_clinic_input_text"
               type="email"
               name="mjm_clinic_bf_email"
               required/>
    </div>


    <div class="mjm_clinic_bf_phone_toggle_contain" style="display: none;">
        <label for="mjm_clinic_bf_phone"><?php echo __( 'Phone', 'mjm-clinic' ) ?></label>
        <input class="mjm_clinic_bf_phone mjm_clinic_input_text"
               type="tel"
               name="mjm_clinic_bf_phone"
               required/>
    </div>

    <label for="mjm_clinic_bf_message"><?php echo __( 'Optional Message', 'mjm-clinic' ) ?></label>
    <textarea name="mjm_clinic_bf_message"
              class="mjm_clinic_input_textarea mjm_clinic_bf_message"></textarea>

    <input class="mjm_clinic_bf_submit_button" type="submit" value="<?php echo __( 'Send', 'mjm-clinic' ) ?>" />

</form>
<a id="mjm_clinic_bg_success_top"></a>
<div class="mjm_clinic_bf_success_msg_contain" style="display: none;">
    <span class="mjm_clinic_bf_success_msg"><i class="mjm_clinic_bf_success_msg_icon fa fa-thumbs-up"></i>
            <?php echo __('Thank you.','mjm-clinic')?> <?php echo __('Your booking request has been received.','mjm-clinic')?> <?php echo __('We will contact you shortly to confirm your booking.','mjm-clinic')?>
    </span>
</div>