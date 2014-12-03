<div class="mjm_clinic_location_map_output_container">
    <div class="mjm_clinic_location_map_output_canvas" id="mjm_clinic_location_map_<?=$map_id?>">
    </div>

    <script type="text/javascript">
        function mjm_clinic_location_map_<?=$map_id?>(){
            var mapCanvas = document.getElementById('mjm_clinic_location_map_<?=$map_id?>');
            var myLatlng = new google.maps.LatLng(<?=$lat?>, <?=$lng?>);
            var mapOptions = {
                center: myLatlng,
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            var map = new google.maps.Map(mapCanvas, mapOptions)

            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                title: '<?=$location->name?>'
            });
        }
        window.addEventListener('load', mjm_clinic_location_map_<?=$map_id?>);
    </script>

    <style>
        #mjm_clinic_location_map_<?=$map_id?> {
            width: <?=$width?>;
            height: <?=$height?>;
        }
    </style>
</div>