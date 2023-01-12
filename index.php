<?php

if (isset($_POST['submit'])){ // Se o botão do formulário foi apertado
  $entradaInput = $_POST['entrada']; // Recebe o valor do input com o name entrada (onde o usuário digita a hora de entrada) e salva dentro de $entradaInput
  $saidaInput = $_POST['saida']; // Recebe o valor do input com o name saida (onde o usuário digita a hora de saída) e salva dentro de $saidaInput

  function jornadaDeTrabalho($inicio, $fim) { // Função que recebe o horário de entrada ($inicio) e o horário de saída ($fim)
    $horasDiurnas = 0; // inicia a variável que armazena a quantidade de horas trabalhadas no período diurno
    $horasNoturnas = 0; // inicia a variável que armazena a quantidade de horas trabalhadas no período noturno
    $tempoAtual = new DateTime("1970-01-01T" . $inicio . ":00"); // Cria uma instância DateTime com o horário de entrada $inicio
    $tempoFinal = new DateTime("1970-01-01T" . $fim . ":00"); // Cria uma instância DateTime com o horário de saída $fim


    $tempoAtual = intval($tempoAtual->format('H')) * 60 + intval($tempoAtual->format('i')); // Converte o horário de entrada ($inicio) para minutos
    $tempoFinal = intval($tempoFinal->format('H')) * 60 + intval($tempoFinal->format('i')); // Converte o horário de saída ($fim) para minutos



  
    if ($tempoAtual < $tempoFinal) { // Se o horário de entrada em minutos for menor que o horário de saída em minutos entra aqui
        while ($tempoAtual < $tempoFinal) { // Enquanto o horário de entrada em minutos for menor que o horário de saída em minutos o loop roda
            if ($tempoAtual >= 5 * 60 && $tempoAtual < 22 * 60) { // Se o horário de entrada for maior ou igual a 5:00 e menor que 22:00
                $horasDiurnas += 1; // Adiciona 1 minuto na variável $horasDiurnas
            } else { // Se não
                $horasNoturnas += 1; // Adiciona 1 minuto na variável $horasNoturnas
            }
            $tempoAtual += 1; // De qualquer forma adiciona 1 minuto no horário de entrada só de ter entrado aqui, assim o loop não fica infinito
        }

        $horasDiurnas = date("H:i",mktime(0, $horasDiurnas)); // Converte a variável $horasDiurnas que esta apenas em minutos para o formato Hora:Minuto
        $horasNoturnas = date("H:i",mktime(0, $horasNoturnas)); // Converte a variável $horasNoturnas que esta apenas em minutos para o formato Hora:Minuto
        return array("horadiurna" => $horasDiurnas, "horanoturna" => $horasNoturnas); // Retorna uma lista associativa com a variável $horasDiurnas ligada a chave horadiurna e a variável $horasNoturnas ligada a chave horanoturna


    } else { // Se o horário de entrada for maior que o horário de saída em minutos entra aqui
        while ($tempoAtual < 24 * 60) { // Enquanto o horário de entrada for menor que 24:00 o loop roda
            if ($tempoAtual >= 5 * 60 && $tempoAtual < 22 * 60) { // Se o horário de entrada for maior ou igual a 5:00 e menor que 22:00
                $horasDiurnas += 1; // Adiciona 1 minuto na variável $horasDiurnas
            } else { // Se não
                $horasNoturnas += 1; // Adiciona 1 minuto na variável $horasNoturnas
            }
            $tempoAtual += 1; // De qualquer forma adiciona 1 minuto no horário de entrada só de ter entrado aqui, assim o loop não fica infinito
        }
  
        $tempoAtual = 0; // Zera a variável $tempoAtual (ou o que era o $inicio)
        while ($tempoAtual < $tempoFinal) { // Enquanto o horário de entrada for menor que o horário de saída o loop roda
            if ($tempoAtual >= 5 * 60 && $tempoAtual < 22 * 60) { // Se o horário de entrada for maior ou igual a 5:00 e menor que 22:00
                $horasDiurnas += 1; // Adiciona 1 minuto na variável $horasDiurnas
            } else { // Se não
                $horasNoturnas += 1; // Adiciona 1 minuto na variável $horasNoturnas
            } 
            $tempoAtual += 1; // De qualquer forma adiciona 1 minuto no horário de entrada só de ter entrado aqui, assim o loop não fica infinito
        }

        $horasDiurnas = date("H:i",mktime(0, $horasDiurnas)); // Converte a variável $horasDiurnas para o formato Hora:Minuto
        $horasNoturnas = date("H:i",mktime(0, $horasNoturnas)); // Converte a variável $horasNoturnas para o formato Hora:Minuto
        return array("horadiurna" => $horasDiurnas, "horanoturna" => $horasNoturnas); // Retorna uma lista associativa com a variável $horasDiurnas ligada a chave horadiurna e a variável $horasNoturnas ligada a chave horanoturna
    }
  }

  $inicio = $entradaInput; // A variável $inicio recebe o valor da variável $entradaInput que estava recebendo o valor do input 
  $fim = $saidaInput; // A variável $fim recebe o valor da variável $saidaInput que estava recebendo o valor do input
  
  $resultado = jornadaDeTrabalho($inicio, $fim); // A variável $resultado recebe o retorno da chamada da função jornadaDeTrabalho, que é um array, dentro dela tem as variáveis $horasDiurnas e $horasNoturnas que serão renderizadas no front no horário diurno e horário noturno respectivamente. Os parâmetros para ela são o horário de entrada e o horário de saída que são passados pelo front
} 

  else{
    $resultado = ["horadiurna" => "00:00", "horanoturna" => "00:00"]; // Quando a aplicação inicia tem que existir um valor para $horasDiurnas e $horasNoturnas para que o front não retorne erro, já que ele tenta renderizar o valor de $horasDiurnas e $horasNoturnas antes de o usuário clicar no botão calcular
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
      <form id="box-form" method="post">
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
        <div id="horasDia" class="horas">Horas diurnas <?php echo $resultado["horadiurna"]; ?></div>
        <div id="horasNoite" class="horas">Horas noturnas <?php echo $resultado["horanoturna"]; ?></div>
        <img id="sol" src="./img/sol.png" />
        <img id="lua" src="./img/lua.png" />
      </div>
    </main>
    <script src="index.js"></script>
  </body>
</html>
