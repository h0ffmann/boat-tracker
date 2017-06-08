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
        margin: 0;
        padding: 0;
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
		$pieces = explode("_", $line); // splita todas as informações entre "_", que é um convenção adota no script que gera o logger

		$valor_latitude = floatval ($pieces[0]);// passa as informações de longitude e latitude para float, que é o formato aceito
		$valor_longitude = floatval ($pieces[1]);// pela API do Google Maps
		echo "\n";
		echo $valor_latitude;
		echo "\n";
		echo $valor_longitude;
		echo "\n";
		echo $pieces[0]; 
		echo "\n";
		echo $pieces[1];
		echo "\n";

	?>

  <!-- =================== Final código PHP ===================== --->

    <!-- Layout da Página -->
    <div class="siimple-h1" >  Boat Tracker</div>
    <div class="siimple-h3" >  Sistema de monitoramento Georreferenciado</div>
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

        // Função que plotta o mapa recebendo os dados do código em php.
        /* Definição do mapa e do marker. Falta lógica para adicionar mais markers para cada tracker
        Center do mapa será definido como? Talvez na aplicação seja melhor definir um tal que abrangesse
        todo o range do circuito.
        Média das coordenadas?
        O zoom teria que ser dinâmico de alguma maneira
        Um valor fixo poderia ocultar um determinado marker. */

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
    <!-- Callback function para garantir que a api carregue só quando tiver passado pela lógica PHP -->
    <script src="https://maps.googleapis.com/maps/api/js?key=REMOVED&callback=initMap"
    async defer></script>
  </body>
</html>
