<!DOCTYPE html>
<html>
  <head>
    <!-- Design -->
    <link rel="stylesheet" href="siimple-2.0.1/dist/siimple.min.css">
  	<link rel="stylesheet" href="screentracker.css">

    <!-- Titulo -->
    <title>Boat Tracker</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">

    <!-- Definiçoes de tamanho do mapa  -->
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 80%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 20px;
        padding: 20px;
      }
    </style>


    </head>
  </head>
  <body>


    <!-- =================== Início código PHP ===================== --->

	<?php

    /* Lógica para definir o ultimo arquivo modificado, logo o mais recente, é necessario que seja feito para cada Tracker.
    Dependendo do número é melhor um laço de repetição.*/
    $filesBT01 = glob("BT01*"); // seleciona apenas arquivos com o prefixo BT01
    $filesBT01 = array_combine($filesBT01, array_map("filemtime", $filesBT01)); // separa pela data de modificacao
    arsort($filesBT01); // ordena
    $latestfileBT01 = key($filesBT01); // define novo arquivo como o ultimo a ser modificado

    /* Logica que carrega as informações necessárias para interface no arquivo */
		$data = file($latestfileBT01); // abre o arquivo definido na lógica anterior

		$line = $data[count($data)-1]; // define a ultima linha do arquivo
		$line2 = $data[count($data)-2];
		$line3 = $data[count($data)-3];
		$line4 = $data[count($data)-4];
		$line5 = $data[count($data)-5];
		$line6 = $data[count($data)-6];
		$line7 = $data[count($data)-7];
		$line8 = $data[count($data)-8];
		$line9 = $data[count($data)-9];
		$line10 = $data[count($data)-10];
    $line11 = $data[count($data)-11];
		$line12 = $data[count($data)-12];
		$line13 = $data[count($data)-13];
		$line14 = $data[count($data)-14];
		$line15 = $data[count($data)-15];
		$line16 = $data[count($data)-16];
		$line17 = $data[count($data)-17];
		$line18 = $data[count($data)-18];
		$line19 = $data[count($data)-19];
    $line20 = $data[count($data)-20];

    $pieces = explode(",", $line); // splita todas as informações entre "_", que é um convenção adota no script que gera o logger
		$pieces2 = explode(",", $line2);
		$pieces3 = explode(",", $line3);
		$pieces4 = explode(",", $line4);
		$pieces5 = explode(",", $line5);
		$pieces6 = explode(",", $line6);
		$pieces7 = explode(",", $line7);
		$pieces8 = explode(",", $line8);
		$pieces9 = explode(",", $line9);
		$pieces10 = explode(",", $line10);
    $pieces11 = explode(",", $line11);
		$pieces12 = explode(",", $line12);
		$pieces13 = explode(",", $line13);
		$pieces14 = explode(",", $line14);
		$pieces15 = explode(",", $line15);
		$pieces16 = explode(",", $line16);
		$pieces17 = explode(",", $line17);
		$pieces18 = explode(",", $line18);
		$pieces19 = explode(",", $line19);
    $pieces20 = explode(",", $line20);

		$valor_latitude = floatval ($pieces[0]);// passa as informações de longitude e latitude para float, que é o formato aceito
		$valor_longitude = floatval ($pieces[1]);// pela API do Google Maps

		$valor_latitude2 = floatval ($pieces2[0]);
		$valor_longitude2 = floatval ($pieces2[1]);

		$valor_latitude3 = floatval ($pieces3[0]);
		$valor_longitude3 = floatval ($pieces3[1]);

		$valor_latitude4 = floatval ($pieces4[0]);
		$valor_longitude4 = floatval ($pieces4[1]);

		$valor_latitude5 = floatval ($pieces5[0]);
		$valor_longitude5 = floatval ($pieces5[1]);

		$valor_latitude6 = floatval ($pieces6[0]);
		$valor_longitude6 = floatval ($pieces6[1]);

		$valor_latitude7 = floatval ($pieces7[0]);
		$valor_longitude7 = floatval ($pieces7[1]);

		$valor_latitude8 = floatval ($pieces8[0]);
		$valor_longitude8 = floatval ($pieces8[1]);

		$valor_latitude9 = floatval ($pieces9[0]);
		$valor_longitude9 = floatval ($pieces9[1]);

		$valor_latitude10 = floatval ($pieces10[0]);
		$valor_longitude10 = floatval ($pieces10[1]);

    $valor_latitude11 = floatval ($pieces11[0]);
    $valor_longitude11 = floatval ($pieces11[1]);

    $valor_latitude12 = floatval ($pieces12[0]);
    $valor_longitude12 = floatval ($pieces12[1]);

    $valor_latitude13 = floatval ($pieces13[0]);
    $valor_longitude13 = floatval ($pieces13[1]);

    $valor_latitude14 = floatval ($pieces14[0]);
    $valor_longitude14 = floatval ($pieces14[1]);

    $valor_latitude15 = floatval ($pieces15[0]);
    $valor_longitude15 = floatval ($pieces15[1]);

    $valor_latitude16 = floatval ($pieces16[0]);
    $valor_longitude16 = floatval ($pieces16[1]);

    $valor_latitude17 = floatval ($pieces17[0]);
    $valor_longitude17 = floatval ($pieces17[1]);

    $valor_latitude18 = floatval ($pieces18[0]);
    $valor_longitude18 = floatval ($pieces18[1]);

    $valor_latitude19 = floatval ($pieces19[0]);
    $valor_longitude19 = floatval ($pieces19[1]);

    $valor_latitude20 = floatval ($pieces20[0]);
    $valor_longitude20 = floatval ($pieces20[1]);
/*
		echo "Latitude: ";
		echo $pieces[0];
		echo "<br />\n"  ;
		echo "Longitude: ";
		echo $pieces[1];
		echo "<br />\n";
		echo "Data YYYY/MM/DD: ";
		echo $pieces[2];
		echo "<br />\n" ;
		echo "Hora (-3 GMT): ";
		echo $pieces[3];
		echo "<br />\n" ;
		echo "Amostra válida? ";
			if ( $pieces[4] == "A"){
				echo "Sim! O sinal foi suficiente para garantir a posição.";}
			else  {
				echo "Não, problema na captura de satélites.";}
		echo "<br />\n" ;
		echo "Velocidade absoluta em nós: ";
		echo $pieces[5];
*/
	?>

  <!-- =================== Final código PHP ===================== --->

    <!-- Layout da Página -->
    <div class="siimple-h1" >  Boat Tracker</div>
    <div class="siimple-h3" >  Sistema de monitoramento de geolocalização de pequenas embarcações</div>
    <nav class="site-nav">
          <ul class="group">
            <li><a class="siimple-small" href="http://hoffmann/home.php">Home</a></li>
            <li><a class="siimple-small" href="http://hoffmann/trackermap.php">Posição atual</a></li>
            <li><a class="siimple-small" href="<?php echo $latestfileBT01 ?>">Último Log</a></li>
            <li><a class="siimple-small" href="http://hoffmann/trackermap10.php">Últimas dez posições</a></li>
            <li><a class="siimple-small" href="http://hoffmann/trackermap20.php">Últimas vinte posições</a></li>
            <li><a class="siimple-small" href="http://hoffmann/about.php">Sobre nós</a></li>
          </ul>
        </nav>

        <br>
    <div id="map"></div>


    <script>
      function initMap() {

        // Função que plotta o mapa recebendo os dados do código em php.
        /* Definição do mapa e do marker. Falta lógica para adicionar mais markers para cada tracker
        Center do mapa será definido como? Talvez na aplicação seja melhor definir um tal que abrangesse
        todo o range do circuito.
        Média das coordenadas?
        O zoom teria que ser dinâmico de alguma maneira
        Um valor fixo poderia ocultar um determinado marker. */


        var myposition = {lat: <?=$valor_latitude?>, lng: <?=$valor_longitude?>};
        var myposition2 = {lat: <?=$valor_latitude2?>, lng: <?=$valor_longitude2?>};
        var myposition3 = {lat: <?=$valor_latitude3?>, lng: <?=$valor_longitude3?>};
        var myposition4 = {lat: <?=$valor_latitude4?>, lng: <?=$valor_longitude4?>};
        var myposition5 = {lat: <?=$valor_latitude5?>, lng: <?=$valor_longitude5?>};
        var myposition6 = {lat: <?=$valor_latitude6?>, lng: <?=$valor_longitude6?>};
        var myposition7 = {lat: <?=$valor_latitude7?>, lng: <?=$valor_longitude7?>};
        var myposition8 = {lat: <?=$valor_latitude8?>, lng: <?=$valor_longitude8?>};
        var myposition9 = {lat: <?=$valor_latitude9?>, lng: <?=$valor_longitude9?>};
        var myposition10 = {lat: <?=$valor_latitude10?>, lng: <?=$valor_longitude10?>};
        var myposition11 = {lat: <?=$valor_latitude11?>, lng: <?=$valor_longitude11?>};
        var myposition12 = {lat: <?=$valor_latitude12?>, lng: <?=$valor_longitude12?>};
        var myposition13 = {lat: <?=$valor_latitude13?>, lng: <?=$valor_longitude13?>};
        var myposition14 = {lat: <?=$valor_latitude14?>, lng: <?=$valor_longitude14?>};
        var myposition15 = {lat: <?=$valor_latitude15?>, lng: <?=$valor_longitude15?>};
        var myposition16 = {lat: <?=$valor_latitude16?>, lng: <?=$valor_longitude16?>};
        var myposition17 = {lat: <?=$valor_latitude17?>, lng: <?=$valor_longitude17?>};
        var myposition18 = {lat: <?=$valor_latitude18?>, lng: <?=$valor_longitude18?>};
        var myposition19 = {lat: <?=$valor_latitude19?>, lng: <?=$valor_longitude19?>};
        var myposition20 = {lat: <?=$valor_latitude20?>, lng: <?=$valor_longitude20?>};


       var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 20,
          center: myposition,
          mapTypeId: 'hybrid'


        });
        var marker = new google.maps.Marker({
          position: myposition,
          map: map
        });

        var flightPlanCoordinates = [
          myposition,
          myposition2,
          myposition3,
          myposition4,
          myposition5,
          myposition6,
          myposition7,
          myposition8,
          myposition9,
          myposition10,
          myposition11,
          myposition12,
          myposition13,
          myposition14,
          myposition15,
          myposition16,
          myposition17,
          myposition18,
          myposition19,
          myposition20
        ];

        var flightPath = new google.maps.Polyline({
          path: flightPlanCoordinates,
          geodesic: true,
          strokeColor: '#FF0000',
          strokeOpacity: 1.0,
          strokeWeight: 1
        });

        flightPath.setMap(map);

      }

    </script>
    <!-- Callback function para garantir que a api carregue só quando tiver passado pela lógica PHP -->
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo htmlspecialchars(getenv("GOOGLE_MAPS_KEY") ?: "", ENT_QUOTES) ?>&callback=initMap"
    async defer></script>
  </body>
  <?php
  		echo "<div class=\"siimple-h3\" align=\"center\">---   Dados sobre a última aquisição   ---</div>";
  		echo "<div class=\"siimple-h5\"align=\"center\">";
  		echo "Latitude aproximada: ";
		echo $pieces[0];
		echo "<br />\n"  ;
		echo "Longitude aproximada: ";
		echo $pieces[1];
		echo "<br />\n";
		echo "Data YYYY/MM/DD: ";
		echo $pieces[2];
		echo "<br />\n" ;
		echo "Hora (-3 GMT): ";
		echo $pieces[3];
		echo "<br />\n" ;
		echo "Amostra válida? ";
			if ( $pieces[4] == "A"){
				echo "Sim! O sinal foi suficiente para garantir a posição.";}
			else  {
				echo "Não, problema na captura de satélites.";}
		echo "<br />\n" ;
		echo "Velocidade absoluta em nós: ";
		echo $pieces[5];
		echo "</div>";

	?>
</html>
