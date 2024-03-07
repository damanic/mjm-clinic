<div class="mjm_clinic_location_map_output_container">
	<div class="mjm_clinic_location_map_output_canvas" id="mjm_clinic_location_map_<?php echo esc_attr($map_id)?>">
	</div>

	<script type="text/javascript">
		function mjm_clinic_location_map_<?php echo esc_js($map_id)?>(){
			var mapCanvas = document.getElementById('mjm_clinic_location_map_<?php echo esc_js($map_id)?>');
			var myLatlng = new google.maps.LatLng(<?php echo esc_js($lat)?>, <?php echo esc_js($lng)?>);
			var mapOptions = {
				center: myLatlng,
				zoom: 15,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			var map = new google.maps.Map(mapCanvas, mapOptions);

			var marker = new google.maps.Marker({
				position: myLatlng,
				map: map,
				title: '<?php echo esc_js($location->name)?>'
			});
		}
		window.addEventListener('load', mjm_clinic_location_map_<?php echo esc_js($map_id)?>);
	</script>

	<style>
		#mjm_clinic_location_map_<?php echo esc_attr($map_id)?> {
			width: <?php echo esc_attr($width)?>;
			height: <?php echo esc_attr($height)?>;
		}
	</style>
</div>
