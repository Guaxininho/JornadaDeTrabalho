<?php
// RECEBENDO OS DADOS DO FRONT-END

if (isset($_POST['submit'])){ // Verifica se o botão foi clicado se não foi executa o else que define valores padrões para as variáveis renderizadas
  $entrada = $_POST['entrada']; // Recebe o valor do input com o name entrada (onde o usuário digita a hora de entrada) e salva em $entrada
  $saida = $_POST['saida']; // Recebe o valor do input com o name saida (onde o usuário digita a hora de saída) e salva em $saida

// DIVIDINDO ELES 4 EM VARIÁVEIS PARA PODER FAZER AS CONTAS

  list($horaEntrada, $minutoEntrada) = explode(':', $entrada); // Separa a string dentro de $entrada em duas variáveis, uma com a hora e outra com os minutos
  list($horaSaida, $minutoSaida) = explode(':', $saida); // Separa a string dentro de $saida em duas variáveis, uma com a hora e outra com os minutos


// CONVERTENDO AS VARIÁVEIS PARA INTEIRO (ELAS CHEGAM COMO STRING)

  $horaEntrada = (int)$horaEntrada; 
  $minutoEntrada = (int)$minutoEntrada;

  $horaSaida = (int)$horaSaida; 
  $minutoSaida = (int)$minutoSaida;


// CHECKANDO SE A HORA DE ENTRADA É DIURNA OU NOTURNA E SE A HORA DE SAÍDA É DIURNA OU NOTURNA
// A LÓGICA AQUI É: se a entrada é diurna e a saída é noturna, então os minutos da entrada são diurnos e os da saída noturnos, sendo assim mais tarde eu vou separar os minutos em dois grupos, minutos diurnos e minutos noturnos, diurnos com diurnos somam, e noturnos com noturnos também, mas diurno e noturno não, porque são pagos de forma diferente

if($horaEntrada >= 5 && $horaEntrada < 22 ){ // 
  $minutoEntradaDiurno=  $minutoEntrada;
  $minutoEntradaNoturno = 0;

} else { 
  $minutoEntradaNoturno = $minutoEntrada; 
  $minutoEntradaDiurno = 0;
} 

if($horaSaida >= 5 && $horaSaida < 22 ){ 
  $minutoSaidaDiurno = $minutoSaida;
  $minutoSaidaNoturno = 0;

} else { 
  $minutoSaidaNoturno = $minutoSaida;
  $minutoSaidaDiurno = 0;
} 

// AQUI CONFERE SE ENTRAR E SAIR NA MESMA HORA DO TRABALHO, NÃO PODE SOMAR OS MINUTOS, TEM QUE SUBTRAIR, CASO CONTRÁRIO OS MINUTOS DA MESMA CATEGORIA (DIURNO OU NOTURNO) SÃO SOMADOS, SE CHEGAM A 60, UMA HORA É ADICIONADA E 60 MINUTOS É REMOVIDO DOS MINUTOS

if($horaEntrada == $horaSaida){
$somaDosMinutosDiurnos =  $minutoSaidaDiurno - $minutoEntradaDiurno;
$somaDosMinutosNoturnos = $minutoSaidaNoturno - $minutoEntradaNoturno;
} else {
  $somaDosMinutosDiurnos = $minutoEntradaDiurno + $minutoSaidaDiurno;  // Lógica diurna
  if($somaDosMinutosDiurnos >= 60){ 
    $horaSaida++;
    $somaDosMinutosDiurnos = $somaDosMinutosDiurnos - 60; 
  } else {
    $somaDosMinutosDiurnos = $somaDosMinutosDiurnos; 
  }

  $somaDosMinutosNoturnos = $minutoEntradaNoturno + $minutoSaidaNoturno;  // Lógica noturna
  if($somaDosMinutosNoturnos >= 60){ 
    $horaSaida++; 
    $somaDosMinutosNoturnos = $somaDosMinutosNoturnos - 60; 
  } else {
    $somaDosMinutosNoturnos = $somaDosMinutosNoturnos; 
  }
}

// APÓS A SOMA SE ALGUM MINUTO ESTIVER ABAIXO DE 10 E ACIMA DE 0 VAI SER ADICIONADO UM 0 A FRENTE

if($somaDosMinutosDiurnos < 10 && $somaDosMinutosDiurnos > 0){
  $somaDosMinutosDiurnos = '0' . $somaDosMinutosDiurnos;
}

if($somaDosMinutosNoturnos < 10 && $somaDosMinutosNoturnos > 0){
  $somaDosMinutosNoturnos = '0' . $somaDosMinutosNoturnos;
}

// AQUI EU FAÇO UM TRATAMENTO, SE OS MINUTOS TERMINAREM EM 0 DEVIDO DEVIDO A UMA SOMA, EU FAÇO ELES SEREM IGUAIS A 00, PARA QUE NÃO APAREÇA 0 MINUTOS, APENAS UM DETALHE VISUAL

if($somaDosMinutosDiurnos == 0){
  $somaDosMinutosDiurnos = '00';
}

if($somaDosMinutosNoturnos == 0){
  $somaDosMinutosNoturnos = '00';
}


// AQUI COMEÇA O TRATAMENTO DAS HORAS, SEPARANDO 2 LISTAS DE HORAS (DIURNAS E NOTURNAS), ELAS INICIAM VAZIAS
$diurno = []; 
$noturno = [];

// EM SEGUIDA ATRAVÉS DE UM LOOP EU USO A HORA DE ENTRADA COMO ÍNDICE, SEMPRE QUE A HORA ÍNDICE FOR MENOR QUE 5 OU MAIOR QUE 22, ELA É ADICIONADA NA LISTA DE HORAS NOTURNAS, SE FOR ENTRE 5 E 22, ELA É ADICIONADA NA LISTA DE HORAS DIURNAS, SE FOR IGUAL A 5 OU 22, ELA É ADICIONADA NAS DUAS LISTAS, E POR ÚLTIMO, SE A HORA ÍNDICE FOR IGUAL A HORA DE SAÍDA, O LOOP É QUEBRADO E O CÁLCULO É FINALIZADO

  $i = $horaEntrada; 
  while(true){
    if($i == 25){
      $i = 0;
    } else if ($i > 5 && $i < 22){
      array_push($diurno, $i);
    } else if ($i == 5 || $i == 22){
      array_push($diurno, $i);
      array_push($noturno, $i);
    } else {
      array_push($noturno, $i);
    }

    if($i == $horaSaida){
      break;
    } else {
      $i++;
    }
  }

// AQUI CONTA QUANTAS HORAS TEM EM CADA LISTA

  $DiurnoRenderizado = sizeof($diurno);
  $NoturnoRenderizado = sizeof($noturno);   

// AQUI EU FAÇO UM TRATAMENTO, SE AS HORAS TERMINAREM EM 0 EU FAÇO ELAS SEREM IGUAIS A 00, PARA QUE NÃO APAREÇA 0 HORAS, SE NÃO FOR 0, REDUZO EM UM A HORA, PARA QUE APAREÇA O INTERVALO DE HORAS CORRETO, E POR ÚLTIMO EU CONCATENO OS MINUTOS COM AS HORAS, PARA QUE APAREÇA O RESULTADO FINAL

  if($DiurnoRenderizado == 0){
    $DiurnoRenderizado = '00' . ':' . $somaDosMinutosDiurnos;
  } else {
    $DiurnoRenderizado = $DiurnoRenderizado - 1;
    $DiurnoRenderizado = $DiurnoRenderizado . ':' . $somaDosMinutosDiurnos;
  }

  if($NoturnoRenderizado == 0){
    $NoturnoRenderizado = '00' . ':' . $somaDosMinutosNoturnos;
  } else {
    $NoturnoRenderizado = $NoturnoRenderizado - 1;
    $NoturnoRenderizado = $NoturnoRenderizado . ':' . $somaDosMinutosNoturnos;
  }


} else {
  $DiurnoRenderizado = '00:00';
  $NoturnoRenderizado = '00:00';
}




?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <link rel="shortcut icon" href="#" />
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Jornada de Trabalho</title>
    <link href="style.css" rel="stylesheet" />
  </head>
  <body>
    <main id="box">
      <h1>Jornada de trabalho</h1>
      <form id="box-form" method="post" action="./index.php">
        <div class="box-form-flex">
          <label for="box-form-flex-entrada">Digite o horário de entrada</label>
          <input id="box-form-flex-entrada" type="time" name="entrada" />
        </div>

        <div class="box-form-flex">
          <label for="box-form-flex-saida">Digite o horário de saída</label>
          <input id="box-form-flex-saida" type="time" name="saida" />
        </div>

        <button id="calcular" type="submit" name="submit">Calcular</button>
      </form>

      <div id="box-result">
        <div id="horasDia" class="horas"><?php echo $DiurnoRenderizado ?></div>
        <div id="horasNoite" class="horas"><?php echo $NoturnoRenderizado ?></div>
        <img id="sol" src="./img/sol.png" />
        <img id="lua" src="./img/lua.png" />
      </div>
    </main>
    <script src="index.js"></script>
  </body>
</html>
