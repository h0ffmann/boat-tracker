<!DOCTYPE html>
<?php

  /* Lógica para definir o ultimo arquivo modificado, logo o mais recente, é necessario que seja feito para cada Tracker.
  Dependendo do número é melhor um laço de repetição.*/
  $filesBT01 = glob("BT01*"); // seleciona apenas arquivos com o prefixo BT01
  $filesBT01 = array_combine($filesBT01, array_map("filemtime", $filesBT01)); // separa pela data de modificacao
  arsort($filesBT01); // ordena
  $latestfileBT01 = key($filesBT01); // define novo arquivo como o ultimo a ser modificado

  /* Logica que carrega as informações necessárias para interface no arquivo */
  $data = file($latestfileBT01); // abre o arquivo definido na lógica anterior
  ?>
<html>
  <head>
    <!-- Design -->
    <link rel="stylesheet" href="siimple-2.0.1/dist/siimple.min.css">
  	<link rel="stylesheet" href="screentracker.css">

    <!-- Titulo -->
    <title>Boat Tracker</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">



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


  <?php
  		echo "<div class=\"siimple-h5\"align=\"left\">";
  		echo "    O projeto foi desenvolvido pelos alunos de Iniciação Científica do LIOc - Laboratório de Instrumentação Oceanográfica.";
      echo "<div class=\"siimple-h3\"align=\"left\"> Desenvolvedores </div>";
      echo "<div class=\"siimple-h5\"align=\"left\">Matheus Hoffmann Fernandes Santos email: hoffmann[AT]poli.ufrj.br";
      echo "<div class=\"siimple-h5\"align=\"left\">William Barbosa de Macedo email: william.macedo[AT]poli.ufrj.br";
      echo "</div>";

	?>
</html>
