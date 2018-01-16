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
		/*
		$line2 = $data[count($data)-2];
		$line3 = $data[count($data)-3];
		$line4 = $data[count($data)-4];
		$line5 = $data[count($data)-5];
		$line6 = $data[count($data)-6];
		$line7 = $data[count($data)-7];
		$line8 = $data[count($data)-8];
		$line9 = $data[count($data)-9];
		$line10 = $data[count($data)-10];
		*/
		$pieces = explode(",", $line); // splita todas as informações entre "_", que é um convenção adota no script que gera o logger

		/*
		$pieces2 = explode(",", $line2);
		$pieces3 = explode(",", $line3);
		$pieces4 = explode(",", $line4);
		$pieces5 = explode(",", $line5);
		$pieces6 = explode(",", $line6);
		$pieces7 = explode(",", $line7);
		$pieces8 = explode(",", $line8);
		$pieces9 = explode(",", $line9);
		$pieces10 = explode(",", $line10);
		*/






		$valor_latitude = floatval ($pieces[0]);// passa as informações de longitude e latitude para float, que é o formato aceito
		$valor_longitude = floatval ($pieces[1]);// pela API do Google Maps
		/*
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
        /*
         var myposition2 = {lat: <?=$valor_latitude2?>, lng: <?=$valor_longitude2?>};

         var myposition3 = {lat: <?=$valor_latitude3?>, lng: <?=$valor_longitude3?>};

         var myposition4 = {lat: <?=$valor_latitude4?>, lng: <?=$valor_longitude4?>};

         var myposition5 = {lat: <?=$valor_latitude5?>, lng: <?=$valor_longitude5?>};

         var myposition6 = {lat: <?=$valor_latitude6?>, lng: <?=$valor_longitude6?>};

         var myposition7 = {lat: <?=$valor_latitude7?>, lng: <?=$valor_longitude7?>};

         var myposition8 = {lat: <?=$valor_latitude8?>, lng: <?=$valor_longitude8?>};

          var myposition9 = {lat: <?=$valor_latitude9?>, lng: <?=$valor_longitude9?>};

           var myposition10 = {lat: <?=$valor_latitude10?>, lng: <?=$valor_longitude10?>};


        var killowatts = {lat: -22.8624072,lng: -43.2295826};

        var correios = {lat: -22.8604079,lng: -43.2306225};
*/
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 20,
          center: myposition,
          mapTypeId: 'hybrid'


        });
        var marker = new google.maps.Marker({
          position: myposition,
          map: map
        });
        /*
         var marker2 = new google.maps.Marker({
          position: myposition2,
          map: map
        });

         var marker3 = new google.maps.Marker({
          position: myposition3,
          map: map
        });

         var marker4 = new google.maps.Marker({
          position: myposition4,
          map: map
        });

         var marker5 = new google.maps.Marker({
          position: myposition5,
          map: map
        });

         var marker6 = new google.maps.Marker({
          position: myposition6,
          map: map
        });

         var marker7 = new google.maps.Marker({
          position: myposition7,
          map: map
        });

         var marker8 = new google.maps.Marker({
          position: myposition8,
          map: map
        });

         var marker9 = new google.maps.Marker({
          position: myposition9,
          map: map
        });

         var marker10 = new google.maps.Marker({
          position: myposition10,
          map: map
        });

*/
      }

    </script>
    <!-- Callback function para garantir que a api carregue só quando tiver passado pela lógica PHP -->
    <script src="https://maps.googleapis.com/maps/api/js?key=REMOVED&callback=initMap"
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
