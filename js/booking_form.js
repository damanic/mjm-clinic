/**
 * Created by Matt on 27/11/2014.
 */
jQuery(document).ready(function($) {
    //look for date fields


    $('.mjm_clinic_bf_date_picker').each( function() {
        var input = $(this);
        input.datepicker({
            inline: true,
            dateFormat: 'dd/mm/yy'
        });
    });



    $('.mjm_clinic_bf_contact_via_select').on('change', function(){
        var elements = {
            phone:  $(this).nextAll('.mjm_clinic_bf_phone_toggle_contain:first'),
            email:  $(this).nextAll('.mjm_clinic_bf_email_toggle_contain:first')
        };
        elements['email'].hide();
        elements['phone'].hide();
        elements[$(this).val()].show();

    });
    $( ".mjm_clinic_bf_contact_via_select" ).trigger( "change" );

    $('.mjm_clinic_service_locations_widget_output_booking-link').on('click', function(){
        form_widget_contain = $(this).nextAll('.mjm_clinic_service_locations_widget_output_booking-form:first');
        form_widget_contain.slideToggle();
        if(form_widget_contain.is(':visible')) {
            form =  form_widget_contain.find('.mjm_clinic_booking_form:first');
            form.show();
            form.nextAll('.mjm_clinic_bf_success_msg_contain:first').hide();
            form.find('.mjm_clinic_bf_name:first').focus();
        }
    });


    $('.mjm_clinic_booking_form').on('submit', function(event){
        event.preventDefault();

    });

    $('.mjm_clinic_booking_form').each( function(){
       var form = $(this);
        form.validate({
            submitHandler: function(form) {
                var thatform = $(form);
                $.ajax({
                    type: "POST",
                    url: '/',
                    data: thatform.serialize() , // serializes the form's elements.
                    success: function (response) {
                        thatform.nextAll('.mjm_clinic_bf_success_msg_contain:first').show();
                        thatform.hide();
                        $(document).scrollTop( $("#mjm_clinic_bg_success_top").offset().top );
                    },
                    error: function (xhr, status, error) {
                        alert(error);
                    }
                });
                return false; // avoid to execute the actual submit of the form.}
            }
        });
    });

    $('.mjm_clinic_bf_success_msg_contain').on('click', function(){
        form = $(this).prevAll('.mjm_clinic_booking_form:first');
        form.show();
        form.trigger("reset");
        $(this).hide();
    });



});