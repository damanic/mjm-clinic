<?php
/**
 * Sets up the options for admin.php
 *
 * @package   MJM_Clinic
 * @author    Matt Manning <2015@mjman.net>
 * @license   GPL-3.0
 * @link      http://mjman.net
 * @copyright 2014, 2015 Matt Manning
 */





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
	<tr valign="top"><th scope="row"><?php _e( 'Indications', 'mjm-clinic' ); ?></th>
		<td>
			<select name="mjm_clinic_settings[mjm_clinic_option_indication]" id="mjm_clinic_option_indication">
			<?php
				$selected = $options['mjm_clinic_option_indication'];
				foreach ( mjm_clinic_true_false() as $option ) {
					$label = $option['label'];
					$value = $option['value'];
					echo '<option value="' . $value . '" ' . selected( $selected, $value ) . '>' . $label . '</option>';
				} ?>
			</select><br />
			<label class="description" for="mjm_clinic_settings[mjm_clinic_option_indication]"><?php _e( 'Enable this to link content with health symptom/indication tags.', 'mjm-clinic' ); ?></label>
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
function mjm_clinic_contraindications()
{
    include_once(CLINIC_SERVICES_FUNC);
    $defaults = mjm_clinic_option_defaults();
    $options = get_option('mjm_clinic_settings', $defaults);
    ?>
    <tr valign="top">
        <th scope="row"><?php _e('Contraindications', 'mjm-clinic'); ?></th>
        <td>
            <select name="mjm_clinic_settings[mjm_clinic_contraindication]" id="mjm_clinic_contraindication">
                <?php
                $selected = $options['mjm_clinic_option_contraindication'];
                foreach (mjm_clinic_true_false() as $option) {
                    $label = $option['label'];
                    $value = $option['value'];
                    echo '<option value="' . $value . '" ' . selected($selected, $value) . '>' . $label . '</option>';
                } ?>
            </select><br/>
            <label class="description"
                   for="mjm_clinic_settings[mjm_clinic_option_contraindication]"><?php _e('Enable this to flag/link content with contraindication tags.', 'mjm-clinic'); ?></label>
        </td>
    </tr>
<?
}

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
    <tr valign="top"><th scope="row"><?php _e( 'Related Products', 'mjm-clinic' ); ?></th>
        <td>
            <select name="mjm_clinic_settings[mjm_clinic_option_related_product]" id="mjm_clinic_option_related_product">
                <?php
                $selected = $options['mjm_clinic_option_related_product'];
                foreach ( mjm_clinic_true_false() as $option ) {
                    $label = $option['label'];
                    $value = $option['value'];
                    echo '<option value="' . $value . '" ' . selected( $selected, $value ) . '>' . $label . '</option>';
                } ?>
            </select><br />
            <label class="description" for="mjm_clinic_settings[mjm_clinic_option_related_product]"><?php _e( 'Enables you to create links to products.', 'mjm-clinic' ); ?></label>
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
	<tr valign="top"><th scope="row"><?php _e( 'Service Price', 'mjm-clinic' ); ?></th>
		<td>
			<select name="mjm_clinic_settings[mjm_clinic_option_price]" id="mjm_clinic_option_price">
			<?php
				$selected = $options['mjm_clinic_option_price'];
				foreach ( mjm_clinic_true_false() as $option ) {
					$label = $option['label'];
					$value = $option['value'];
					echo '<option value="' . $value . '" ' . selected( $selected, $value ) . '>' . $label . '</option>';
				} ?>
			</select><br />
			<label class="description" for="mjm_clinic_settings[mjm_clinic_option_price]"><?php _e( 'If you want a seperate field for price - enable this.', 'mjm-clinic' ); ?></label>
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

    <tr valign="top" <?php echo $style?>><th scope="row"><?php _e( 'Service Disclaimer', 'mjm-clinic' ); ?></th>
        <td>
            <select name="mjm_clinic_settings[mjm_clinic_disclaimer_toggle]" id="mjm_clinic_disclaimer_toggle">
                <?php
                foreach ( mjm_clinic_true_false() as $option ) {
                    $label = $option['label'];
                    $value = $option['value'];
                    echo '<option value="' . $value . '" ' . selected( $selected, $value ) . '>' . $label . '</option>';
                } ?>
            </select><br />
            <label class="description" for="mjm_clinic_settings[mjm_clinic_disclaimer_toggle]"><?php _e( 'Enable this to show a disclaimer on service and health advice pages.', 'mjm-clinic' ); ?></label>
        </td>
    </tr>

    <?php if($selected){?>
    <tr valign="top" <?php echo $style?>><th scope="row"><?php _e( 'Disclaimer Text', 'mjm-clinic' ); ?></th>
        <td>
            <textarea cols="40" rows="6" name="mjm_clinic_settings[mjm_clinic_disclaimer_text]" id="mjm_clinic_disclaimer_text"><?php echo $options['mjm_clinic_disclaimer_text'];?></textarea>
        </td>
    </tr>

        <?php }?>
<?php
}

/**
 * Case Study Option
 * enables/disables feedback content
 *
 * @since 1.0.1
 */
function mjm_clinic_feedback() {
    include_once(CLINIC_SERVICES_FUNC);
    $defaults = mjm_clinic_option_defaults();
    $options = get_option( 'mjm_clinic_settings', $defaults );
    ?>
    <tr valign="top"><th scope="row"><?php _e( 'Customer Feedback', 'mjm-clinic' ); ?></th>
        <td>
            <select name="mjm_clinic_settings[mjm_clinic_option_feedback]" id="mjm_clinic_option_feedback">
                <?php
                $selected = $options['mjm_clinic_option_feedback'];
                foreach ( mjm_clinic_true_false() as $option ) {
                    $label = $option['label'];
                    $value = $option['value'];
                    echo '<option value="' . $value . '" ' . selected( $selected, $value ) . '>' . $label . '</option>';
                } ?>
            </select><br />
            <label class="description" for="mjm_clinic_settings[mjm_clinic_option_feedback]"><?php _e( 'Allows you to add customer feedback and link it to services or conditions.', 'mjm-clinic' ); ?></label>
        </td>
    </tr>
<?php
}


/**
 * Case Study Option
 * enables/disables case study content
 *
 * @since 1.0.1
 */
function mjm_clinic_casestudy() {
    include_once(CLINIC_SERVICES_FUNC);
    $defaults = mjm_clinic_option_defaults();
    $options = get_option( 'mjm_clinic_settings', $defaults );
    ?>
    <tr valign="top"><th scope="row"><?php _e( 'Case Studies', 'mjm-clinic' ); ?></th>
        <td>
            <select name="mjm_clinic_settings[mjm_clinic_option_casestudy]" id="mjm_clinic_option_casestudy">
                <?php
                $selected = $options['mjm_clinic_option_casestudy'];
                foreach ( mjm_clinic_true_false() as $option ) {
                    $label = $option['label'];
                    $value = $option['value'];
                    echo '<option value="' . $value . '" ' . selected( $selected, $value ) . '>' . $label . '</option>';
                } ?>
            </select><br />
            <label class="description" for="mjm_clinic_settings[mjm_clinic_option_casestudy]"><?php _e( 'Allows you to add case studies.', 'mjm-clinic' ); ?></label>
        </td>
    </tr>
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

    mjm_clinic_indication();
	//mjm_clinic_contraindications();
    //mjm_clinic_price();
    mjm_clinic_disclaimer();
    //mjm_clinic_related_product();
    mjm_clinic_feedback();
    mjm_clinic_casestudy();
    mjm_clinic_comments();
	echo $options_after;
}
?>