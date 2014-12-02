jQuery(document).ready(function($) {

    $('.mjm_clinic_service_locations_widget_output_map-link').on('click', function(){
        var map_contain = $(this).nextAll('.mjm_clinic_service_locations_widget_output_map-contain:first');
        map_contain.slideToggle();
        if(map_contain.is(':visible')) {
            var map_canvas = map_contain.find('.mjm_clinic_location_map_output_canvas:first').focus();
            var func = map_canvas.attr('id');
            eval(func+"()");
        }
    });

});