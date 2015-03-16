<div class="mjm_clinic_location_map_output_container">
    <div class="mjm_clinic_location_map_output_canvas" id="mjm_clinic_location_map_<?php echo $map_id?>">
    </div>

    <script type="text/javascript">
        function mjm_clinic_location_map_<?php echo $map_id?>(){
            var mapCanvas = document.getElementById('mjm_clinic_location_map_<?php echo $map_id?>');
            var myLatlng = new google.maps.LatLng(<?php echo $lat?>, <?php echo $lng?>);
            var mapOptions = {
                center: myLatlng,
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            var map = new google.maps.Map(mapCanvas, mapOptions)

            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                title: '<?php echo $location->name?>'
            });
        }
        window.addEventListener('load', mjm_clinic_location_map_<?php echo $map_id?>);
    </script>

    <style>
        #mjm_clinic_location_map_<?php echo $map_id?> {
            width: <?php echo $width?>;
            height: <?php echo $height?>;
        }
    </style>
</div>