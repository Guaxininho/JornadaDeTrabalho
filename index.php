<?php
if (isset($_POST['submit'])){
  $entrada = $_POST['entrada'];
  $saida = $_POST['saida'];


  list($horaEntrada, $minutoEntrada) = explode(':', $entrada);
  list($horaSaida, $minutoSaida) = explode(':', $saida);

  // $entrada = DateTime::createFromFormat('H:i', $entrada);
  // $saida = DateTime::createFromFormat('H:i', $saida);

  // $intervalo = $entrada->diff($saida);
  // $intervalo = $intervalo->format('%H:%I');

  // $ValorEntrada = $_POST['entrada']; // pegando o valor da entrada inserida

  $horaEntrada = (int)$horaEntrada; // convertendo para inteiro (numero) porque é uma string (essa é a hora que ele começou a trabalhar)
  $minutoEntrada = (int)$minutoEntrada;

  $horaSaida = (int)$horaSaida; // convertendo para inteiro (numero) porque é uma string (essa é a hora que ele terminou de trabalhar)
  $minutoSaida = (int)$minutoSaida;


  // $somaDosMinutos = $minutoEntrada + $minutoSaida; // somando os minutos 
  // if($somaDosMinutos >= 60){ // se a soma dos minutos for maior ou igual a 60
  //   $horaSaida++; // adiciona uma hora
  //   $minutoSaida = $somaDosMinutos - 60; // subtrai 60 dos minutos
  // } else {
  //   $minutoFinal = $somaDosMinutos; // se não, os minutos serão a soma dos minutos que ele digitou
  // }

  $diurno = []; // array para armazenar os horarios diurnos
  $noturno = []; // array para armazenar os horarios noturnos

  // CENÁRIOS DE ENTRADA E SAÍDA

if($horaEntrada >= 5 && $horaEntrada <= 22 ){ // entrou de dia
  $minutoEntradaDiurno=  $minutoEntrada;
  $minutoEntradaNoturno = 0;
  // minutos da entrada aqui são diurnos
} else { // entrou de noite 
  $minutoEntradaNoturno = $minutoEntrada; 
  $minutoEntradaDiurno = 0;
} 

if($horaSaida >= 5 && $horaSaida <= 22 ){ // saiu de dia
  $minutoSaidaDiurno = $minutoSaida;
  $minutoSaidaNoturno = 0;
  // minutos da entrada aqui são diurnos
} else { // saiu de noite 
  $minutoSaidaNoturno = $minutoSaida;
  $minutoSaidaDiurno = 0;
} 

// minutos diurnos e noturnos não se somam, porque não pertencem ao mesmo pagamento
// mas diurnos com diurnos somam, e noturnos com noturnos também

  $somaDosMinutosDiurnos = $minutoEntradaDiurno + $minutoSaidaDiurno; // somando os minutos diurnos
  if($somaDosMinutosDiurnos >= 60){ // se a soma dos minutos diurnos for maior ou igual a 60
    $horaSaida++; // adiciona uma hora a saída
    $somaDosMinutosDiurnos = $somaDosMinutosDiurnos - 60; // subtrai 60 dos minutos diurnos
  } else {
    $somaDosMinutosDiurnos = $somaDosMinutosDiurnos; // se não, os minutos serão a soma dos minutos que ele digitou
  }

  $somaDosMinutosNoturnos = $minutoEntradaNoturno + $minutoSaidaNoturno; // somando os minutos noturnos
  if($somaDosMinutosNoturnos >= 60){ // se a soma dos minutos noturnos for maior ou igual a 60
    $horaSaida++; // adiciona uma hora a saída
    $somaDosMinutosNoturnos = $somaDosMinutosNoturnos - 60; // subtrai 60 dos minutos noturnos
  } else {
    $somaDosMinutosNoturnos = $somaDosMinutosNoturnos; // se não, os minutos serão a soma dos minutos que ele digitou
  }


  $i = $horaEntrada; // o índice será baseado na hora que ele entrou (prefiro usar o índice para facilitar a lógica)
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



  if($somaDosMinutosDiurnos == 0){
    $somaDosMinutosDiurnos = '00';
  }

  if($somaDosMinutosNoturnos == 0){
    $somaDosMinutosNoturnos = '00';
  }


  $DiurnoRenderizado = sizeof($diurno);
  $NoturnoRenderizado = sizeof($noturno);   

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


// na minha mente funciona assim: se a entrada é diurna e a saída é noturna, então os minutos da entrada são diurnos e os da saída noturnos e vice versa

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
