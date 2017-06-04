<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="siimple-2.0.1/dist/siimple.min.css">
  	<link rel="stylesheet" href="screentracker.css">
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
    <!-- Header -->

    </head>
  </head>
  <body>




	<?php

		# Falta adicionar logica sobre como logar arquivo: usar data de modificacao ou ordem alfabetica

    # Realizar para cada tracker, pode ser otimizado
    $filesBT01 = glob("BT01*");
    $filesBT01 = array_combine($filesBT01, array_map("filemtime", $filesBT01));
    arsort($filesBT01);

    $latestfileBT01 = key($filesBT01);

		$data = file($latestfileBT01);
		$line = $data[count($data)-1];
		$pieces = explode("_", $line);

		$valor_latitude = floatval ($pieces[0]);
		$valor_longitude = floatval ($pieces[1]);

		#echo $pieces[0];
		#echo "\n";
		#echo $pieces[1];

   # Consertar formatação de saida

	?>
    <div class="siimple-h1" >  Boat Tracker</div>
    <div class="siimple-h3" >  Sistema de monitoramento Georeferenciado</div>
    <nav class="site-nav">
          <ul class="group">
            <li><a class="siimple-small" href="#">Home</a></li>
            <li><a class="siimple-small" href="#">Check your position</a></li>
            <li><a class="siimple-small" href="#">About</a></li>
            <li><a class="siimple-small" href="#">Contact Us</a></li>
          </ul>
        </nav>
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
