var mjmClinicListField;
(function($){
    mjmClinicListField = {
        remove: function( selection_field, entry_id ) {
            //remove the list entry from array
            selection_string = selection_field.val();
            selection_array = selection_string.split(',');
            selection_array = $.grep(selection_array, function(value){
                return ((value != entry_id) && $.isNumeric(value) && (value > 0));
            });

            selection_field.val(selection_array.join());
        },

        add : function(selection_field, entry_id) {
            this.remove(selection_field,entry_id);
            selection_string = selection_field.val();
            selection_array = selection_string.split(',');
            selection_array.push(entry_id);
            selection_field.val(selection_array.join());
        }

    };

})(jQuery);

jQuery(document).ready(function($){

    $('.mjm-clinic-tagsadd').on("click", function(){
        var prefix =  $(this).data("mjm-clinic-ntdelbutton-prefix");
        var dropdown = $('#'+prefix+'_selector');
        var selected_name =  dropdown.children(':selected').text();
        var selected_id = dropdown.val();
        var entry_element = $('#'+prefix+'_entry_'+selected_id);
        var list_area =  $('#'+prefix+'_selections_area');
        var selected_ids_storage_field =  $('#'+prefix+'_selected_ids');

            //remove the element
            if(!entry_element.length){
                list_area.append(
                    '<span id="'+prefix+'_entry_'+selected_id+'">' +
                        '<a id="'+prefix+'_remove_'+selected_id+'"' +
                        'class="ntdelbutton mjm-clinic-ntdelbutton"' +
                        'data-mjm-clinic-ntdelbutton-prefix="'+prefix+'">X</a> ' +
                        selected_name +
                    '</span>'
                );
            }

            //update the storage field
            mjmClinicListField.add(selected_ids_storage_field,selected_id);

        return false;

    });

    $('.mjm-clinic-tagchecklist').on("click", '.mjm-clinic-ntdelbutton', function(){
        var el = $(this);
        var prefix = el.data("mjm-clinic-ntdelbutton-prefix");
        var entry_id = el.attr('id').replace(prefix+'_remove_', '');
        var entry_element = $('#'+prefix+'_entry_'+entry_id);
        var selected_ids_storage_field =  $('#'+prefix+'_selected_ids');


        //remove the list entry
        mjmClinicListField.remove(selected_ids_storage_field,entry_id);
        entry_element.remove();

        return false;
    });
});