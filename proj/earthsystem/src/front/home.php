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
  		echo "    O projeto Boat Tracker consiste n'uma plataforma de monitoramento de posição para embarcações marítimas pequenas. A plataforma
é composta por dois sistemas: Embarcado e de Terra. O sistema embarcado é composto por um microcontrolador, produzido pela Texas
Instruments, MSP432 atuando sobre um sensor GPS - Sistema de Posicionamento Global - e um módulo GSM - Sistema Global para Comu-
nicações Móveis . O sistema de Terra recebe as mensagens do sistema embarcado, via e-mail, com as coordenadas geográcas e a situação da
embarcação e armazena em um Data Logger . No nal, o sistema de Terra agirá como Host Server e disponibilizará um endereço Web em
que os usuários podem fazer requisição do último dado armazenado e então a página exibe um mapa com essas coordenadas e a situação
da embarcação. A principal motivação do desenvolvimento deste projeto é a necessidade do monitoramento de embarcações ao longo de competições de pequeno porte.
Um problema recorrente no ambiente competitivo marítmo é que tanto os espectadores quanto as equipes em terra não conseguem avaliar, sem ajuda
de instrumentos de medição, o ranqueamento das embarcações no momento atual do evento. A primeira aplicação para o projeto tem como inspiração
o projeto da Federação Brasiliense de Vela Adaptada, oferecendo às pessoascom deciência a possibilidade de praticar um esporte, resgatar a autoestima
e melhorar a qualidade de vida. A idéia é trazer esse projeto para o Rio de Janeiro e usar o protótipo do projeto. O Laboratório de Instrumentação Oceanográca da COPPE/UFRJ é apoiador deste projeto, e também dásuporte para a realização deste projeto integrado. Seus autores são bolsistas
de iniciação cientíca do referido laboratório. ";
      echo "<div class=\"siimple-h3\"align=\"left\"> Resumo do Funcionamento </div>";
      echo "<div class=\"siimple-h5\"align=\"left\">O Sistema embarcado é composto por duas partes (placas) principais.A primeira é o módulo que contém o chip SIM808.
Este chip integra diversas de função de comunicações móveis (2G - GPRS/GSM), geolocalização (GPS/GNSS) e comunicações locais (Bluetooth).
Para a nossa aplicação, utilizaremos suas funções de comunicação móvel e geolocalização. Sua escolha foi motivada após pesquisa de diversos chips, que aliassem os
seguintes fatores: baixo custo, facilidade de programação, documentação vasta e rápido tempo de aquisição (compra em território nacional).
A segunda parte é a placa controladora, o cérebro do sistema, o microcontrolador MSP432P401R, fabricado pela renomada Texas Instruments.
Sua escolha foi motivada principalmente pelo uso constante dos microcontroladores da 2família MSP430/MSP432 pelos alunos desenvolvedores e pesquisadores do
LIOc. Suas principais características são: extremo baixo consumo, disponibilidade de interfaces de comunicação (SPI/I2C/UART) e programação em
C. Diversas outras características fazem o LIOc ter adotado tal placa como referência em diversos de seus projetos e de seus integrantes (projetos nais
de graduação e dissertações de mestrado), porém não são do escopo deste projeto integrado. A placa controladora se comunica com o módulo através do protocolo
serial UART (assíncrono), e utilizando do protocolo AT, de comunicações móveis. São enviados comandos básicos, como: ligue o seu módulo GPRS,
ligue o seu módulo GPS e transmita informação de GPS para sua saída. A string com a localização GPS é obtida pelo microcontrolador, que \"parsea\"
esta informação, e envia de volta para o módulo, solicitando que um e-mail seja enviado para o servidor (sistema web). O consumo médio deste módulo é de 100mA, com picos de 250mA nas
transmissões para a ERB da rede celular. O consumo da placa controladora reside na faixa de 5mA, porém com otimizações, este valor pode cair para a
região das centenas de microAmperes.";
      echo "</div>";

	?>
</html>
