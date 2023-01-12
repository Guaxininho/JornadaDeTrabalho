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
  $horaSaida = (int)$horaSaida; // convertendo para inteiro (numero) porque é uma string (essa é a hora que ele terminou de trabalhar)

  $diurno = []; // array para armazenar os horarios diurnos
  $noturno = []; // array para armazenar os horarios noturnos

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

  $DiurnoRenderizado = sizeof($diurno);
  $NoturnoRenderizado = sizeof($noturno);   

  if($DiurnoRenderizado == 0){
    $DiurnoRenderizado = '00:00';
  } else {
    $DiurnoRenderizado = sizeof($diurno) - 1;
  }

  if($NoturnoRenderizado == 0){
    $NoturnoRenderizado = '00:00';
  } else {
    $NoturnoRenderizado = sizeof($noturno) - 1;
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
