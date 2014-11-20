<?php
/**
 * Sets up the options for admin.php
 *
 * @package   MJM_Clinic
 * @author    Matt Manning <spam2014@mjman.net>
 * @license   GPL-3.0
 * @link      http://mjman.net
 * @copyright 2014 Matt Manning
 */


/**
 * Related product option
 * The HTML for Related product
 *
 * @since 	1.0.0
 */
function mjm_clinic_related_product() {
	include_once(CLINIC_SERVICES_FUNC);
	$defaults = mjm_clinic_option_defaults();
	$options = get_option( 'mjm_clinic_settings', $defaults );
	?>
	<tr valign="top"><th scope="row"><?php _e( 'Related Product', 'mjm-clinic' ); ?></th>
		<td>
			<select name="mjm_clinic_settings[mjm_clinic_related_product]" id="mjm_clinic_related_product">
			<?php
				$selected = $options['mjm_clinic_related_product'];
				foreach ( mjm_clinic_true_false() as $option ) {
					$label = $option['label'];
					$value = $option['value'];
					echo '<option value="' . $value . '" ' . selected( $selected, $value ) . '>' . $label . '</option>';
				} ?>
			</select><br />
			<label class="description" for="mjm_clinic_settings[mjm_clinic_related_product]"><?php _e( 'Enable this to display the related product for the service.', 'mjm-clinic' ); ?></label>
		</td>
	</tr>
	<?php
}

/**
 * indication option
 * The HTML for indication
 *
 * @since 	1.0.0
 */
function mjm_clinic_indication() {
	include_once(CLINIC_SERVICES_FUNC);
	$defaults = mjm_clinic_option_defaults();
	$options = get_option( 'mjm_clinic_settings', $defaults );
	?>
	<tr valign="top"><th scope="row"><?php _e( 'Indication', 'mjm-clinic' ); ?></th>
		<td>
			<select name="mjm_clinic_settings[mjm_clinic_indication]" id="mjm_clinic_indication">
			<?php
				$selected = $options['mjm_clinic_indication'];
				foreach ( mjm_clinic_true_false() as $option ) {
					$label = $option['label'];
					$value = $option['value'];
					echo '<option value="' . $value . '" ' . selected( $selected, $value ) . '>' . $label . '</option>';
				} ?>
			</select><br />
			<label class="description" for="mjm_clinic_settings[mjm_clinic_indication]"><?php _e( 'Enable this to tag the service with different indications (unique from categories).', 'mjm-clinic' ); ?></label>
		</td>
	</tr>
	<?php
}


/**
 * Contraindications option
 * The HTML for Contraindications
 *
 * @since 	1.0.0
 */
function mjm_clinic_contraindications() {
	include_once(CLINIC_SERVICES_FUNC);
	$defaults = mjm_clinic_option_defaults();
	$options = get_option( 'mjm_clinic_settings', $defaults );
	?>
	<tr valign="top"><th scope="row"><?php _e( 'Contraindications', 'mjm-clinic' ); ?></th>
		<td>
			<select name="mjm_clinic_settings[mjm_clinic_contraindication]" id="mjm_clinic_contraindication">
			<?php
				$selected = $options['mjm_clinic_contraindication'];
				foreach ( mjm_clinic_true_false() as $option ) {
					$label = $option['label'];
					$value = $option['value'];
					echo '<option value="' . $value . '" ' . selected( $selected, $value ) . '>' . $label . '</option>';
				} ?>
			</select><br />
			<label class="description" for="mjm_clinic_settings[mjm_clinic_contraindication]"><?php _e( 'Enable this to add contraindications the service has received.', 'mjm-clinic' ); ?></label>
		</td>
	</tr>
	<?php
}

/**
 * Location option
 * The HTML for Location
 *
 * @since 	1.0.0
 */
function mjm_clinic_clinic_location() {
	include_once(CLINIC_SERVICES_FUNC);
	$defaults = mjm_clinic_option_defaults();
	$options = get_option( 'mjm_clinic_settings', $defaults );
	?>
	<tr valign="top"><th scope="row"><?php _e( 'Location', 'mjm-clinic' ); ?></th>
		<td>
			<select name="mjm_clinic_settings[mjm_clinic_location]" id="mjm_clinic_location">
			<?php
				$selected = $options['mjm_clinic_location'];
				foreach ( mjm_clinic_true_false() as $option ) {
					$label = $option['label'];
					$value = $option['value'];
					echo '<option value="' . $value . '" ' . selected( $selected, $value ) . '>' . $label . '</option>';
				} ?>
			</select><br />
			<label class="description" for="mjm_clinic_settings[mjm_clinic_location]"><?php _e( 'Enable this to group services by clinic location.', 'mjm-clinic' ); ?></label>
		</td>
	</tr>
	<?php
}

/**
 * Price option
 * The HTML for Price
 *
 * @since 	1.0.0
 */
function mjm_clinic_price() {
	include_once(CLINIC_SERVICES_FUNC);
	$defaults = mjm_clinic_option_defaults();
	$options = get_option( 'mjm_clinic_settings', $defaults );
	?>
	<tr valign="top"><th scope="row"><?php _e( 'Price', 'mjm-clinic' ); ?></th>
		<td>
			<select name="mjm_clinic_settings[mjm_clinic_price]" id="mjm_clinic_price">
			<?php
				$selected = $options['mjm_clinic_price'];
				foreach ( mjm_clinic_true_false() as $option ) {
					$label = $option['label'];
					$value = $option['value'];
					echo '<option value="' . $value . '" ' . selected( $selected, $value ) . '>' . $label . '</option>';
				} ?>
			</select><br />
			<label class="description" for="mjm_clinic_settings[mjm_clinic_price]"><?php _e( 'Enable this to display prices on service listings.', 'mjm-clinic' ); ?></label>
		</td>
	</tr>
	<?php
}


/**
 * Comments option
 * enables/disables comments on service listing posts
 *
 * @since 1.2.0
 */
function mjm_clinic_comments() {
	include_once(CLINIC_SERVICES_FUNC);
	$defaults = mjm_clinic_option_defaults();
	$options = get_option( 'mjm_clinic_settings', $defaults );
	?>
	<tr valign="top"><th scope="row"><?php _e( 'Comments on service listings', 'mjm-clinic' ); ?></th>
		<td>
			<select name="mjm_clinic_settings[comments]" id="comments">
			<?php
				$selected = $options['comments'];
				foreach ( mjm_clinic_true_false() as $option ) {
					$label = $option['label'];
					$value = $option['value'];
					echo '<option value="' . $value . '" ' . selected( $selected, $value ) . '>' . $label . '</option>';
				} ?>
			</select><br />
			<label class="description" for="mjm_clinic_settings[comments]"><?php _e( 'If enabled, allows visitors to comment on service listings.', 'mjm-clinic' ); ?></label>
		</td>
	</tr>
	<?php
}

/**
 * Service Disclaimer Options
 * The HTML for Service Disclaimer
 *
 * @since 	1.0.0
 */
function mjm_clinic_disclaimer() {
    include_once(CLINIC_SERVICES_FUNC);
    $defaults = mjm_clinic_option_defaults();
    $options = get_option( 'mjm_clinic_settings', $defaults );
    $selected = $options['mjm_clinic_disclaimer_toggle'];
    $style = null;
   // if($selected){$style='style="background-color: #00acee; padding:5px;"';}
    ?>

    <tr valign="top" <?=$style?>><th scope="row"><?php _e( 'Show Service Disclaimer', 'mjm-clinic' ); ?></th>
        <td>
            <select name="mjm_clinic_settings[mjm_clinic_disclaimer_toggle]" id="mjm_clinic_disclaimer_toggle">
                <?php
                foreach ( mjm_clinic_true_false() as $option ) {
                    $label = $option['label'];
                    $value = $option['value'];
                    echo '<option value="' . $value . '" ' . selected( $selected, $value ) . '>' . $label . '</option>';
                } ?>
            </select><br />
            <label class="description" for="mjm_clinic_settings[mjm_clinic_disclaimer_toggle]"><?php _e( 'Enable this to set a disclaimer for service and health advice pages.', 'mjm-clinic' ); ?></label>
        </td>
    </tr>

    <? if($selected){?>
    <tr valign="top" <?=$style?>><th scope="row"><?php _e( 'Disclaimer Text', 'mjm-clinic' ); ?></th>
        <td>
            <textarea cols="40" rows="6" name="mjm_clinic_settings[mjm_clinic_disclaimer_text]" id="mjm_clinic_disclaimer_text"><?= $options['mjm_clinic_disclaimer_text'];?></textarea>
        </td>
    </tr>

        <?}?>
<?php
}


/**
 * DO EM!
 *
 * @since 	1.0.0
 */
function mjm_clinic_do_options() {
	$options_before = '<table class="form-table">';
	$options_after = '</table>';

	// do stuff
	echo $options_before;
	mjm_clinic_related_product();
	mjm_clinic_indication();
	mjm_clinic_contraindications();
	mjm_clinic_clinic_location();
	mjm_clinic_price();
	mjm_clinic_comments();
    mjm_clinic_disclaimer();
	echo $options_after;
}