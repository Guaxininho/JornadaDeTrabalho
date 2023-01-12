// const diurno = [5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22];
// const noturno = [23,0,1,2,3,4];

const totaldehoras = [
  22, 23, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19,
  20, 21,
];
// 24 = 0
// ir de totaldehoras[comeco] até totaldehoras[fim]

// (fim = 24) entao fim igual a 0 (essa condição tem que existir dentro do loop)

// for (let i = 22; i <= fim) {
//   //ja ta explicado quais horas são diurnas e quais são noturnas, preciso agora fazer entender que 24 é igual a 0

//   if (i == 25) {
//     i = 0;
//   } else if (i > 5 && i < 22) {
//     diurno.push(i);
//   } else if (i == 5 || i == 22) {
//     diurno.push(i);
//     noturno.push(i);
//   } else {
//     noturno.push(i);
//   }

//   if (i == fim) {
//     break;
//   } else {
//     i++;
//   }
// }

// cheguei a sintaxe, preciso definir melhor a lógica agora

const diurno = []; // inicia uma lista vazia para as horas diurnas
const noturno = []; // inicia uma lista vazia para as horas noturnas

let comeco = 21; // a hora que ele comecou a trabalhar
let fim = 2; // a hora que ele terminou de trabalhar

let i = comeco; // o índice será baseado na hora que ele entrou
while (true) {
  // loop infinito
  if (i == 25) {
    // se o índice for 25, ele é igual a 0
    i = 0;
  } else if (i > 5 && i < 22) {
    // se o índice for maior que 5 e menor que 22, ele é uma hora diurna
    diurno.push(i); // adiciona o índice na lista de horas diurnas
  } else if (i == 5 || i == 22) {
    // se o índice for igual a 5 ou 22, ele é uma hora diurna e noturna
    diurno.push(i); // adiciona o índice na lista de horas diurnas
    noturno.push(i); // adiciona o índice na lista de horas noturnas
  } else {
    // se o índice for menor que 5 ou maior que 22, ele é uma hora noturna
    noturno.push(i); // adiciona o índice na lista de horas noturnas
  }

  if (i == fim) {
    // se o índice for igual a hora que ele terminou de trabalhar, ele para o loop
    break;
  } else {
    // se não, ele adiciona 1 ao índice e continua o loop
    i++;
  }
}

console.log(diurno.length - 1); // imprime a quantidade de intervalos de horas diurnas
console.log(noturno.length - 1); // imprime a quantidade de intervalos de horas noturnas

// sizeof($cars);
