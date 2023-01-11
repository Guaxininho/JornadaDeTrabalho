<?php
if (isset($_POST['submit'])){
  $entrada = $_POST['entrada'];
  $saida = $_POST['saida'];
} else {
  $entrada = '00:00';
  $saida = '00:00';
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
        <div id="horasDia" class="horas"><?php echo $entrada ?></div>
        <div id="horasNoite" class="horas"><?php echo $saida ?></div>
        <img id="sol" src="./img/sol.png" />
        <img id="lua" src="./img/lua.png" />
      </div>
    </main>
    <script src="index.js"></script>
  </body>
</html>
