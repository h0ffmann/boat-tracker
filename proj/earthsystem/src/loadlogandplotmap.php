<!DOCTYPE html>
<html>
  <head>
    <title>Boat Tracker</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 80%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
	<h5> Boat Tracker &#174 </h5>
	<h6> Sistema de monitoramento Georreferenciado</h6>

		
	<?php
		
		# falta adicionar logica sobre como logar arquivo: usar data de modificacao ou ordem alfabetica

		$file = "firstread";
		$data = file($file);
		$line = $data[count($data)-1];
		$pieces = explode("_", $line);
		
		$valor_latitude = floatval ($pieces[0]);
		$valor_longitude = floatval ($pieces[1]);
		
		echo $valor_latitude;
		echo "\n";
		echo $valor_longitude;

		
			/* import re
			def dm_to_sd(dm):
    		'''
    		Converts a geographic coordiante given in "degres/minutes" dddmm.mmmm
    		format (ie, "12319.943281" = 123 degrees, 19.953281 minutes) to a signed
    		decimal (python float) format
    		'''
    		# '12319.943281'
    		if not dm or dm == '0':
        		return 0.
    		d, m = re.match(r'^(\d+)(\d\d\.\d+)$', dm).groups()
		return float(d) + float(m) / 60 */
		
	?>	

    <div id="map"></div>

	
    <script>
      function initMap() {
       	       
        var myposition = {lat: <?=$valor_latitude?>, lng: <?=$valor_longitude?>};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 18,
          center: myposition
        });
        var marker = new google.maps.Marker({
          position: myposition,
          map: map
        });
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=REMOVED&callback=initMap"
    async defer></script>
  </body>
</html>
