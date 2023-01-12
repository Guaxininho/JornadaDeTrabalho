// DEFININDO VARIÁVEIS

const inputHorarioEntrada = document.querySelector("#box-form-flex-entrada");
const inputHorarioSaida = document.querySelector("#box-form-flex-entrada");
const ListaDeInput = document.querySelectorAll("input");
const botaoSubmit = document.querySelector("#calcular");

// AUTENTICAÇÃO DE FORMULÁRIO
botaoSubmit.addEventListener("click", (event) => {
  if (inputHorarioEntrada.value == "" || inputHorarioSaida.value == "") {
    event.preventDefault();
    alert("Por favor não deixe os campos em branco, preencha-os corretamente.");
  }
});

// MUDA A COR DA BORDA INFERIOR INPUT QUANDO ESTIVER FOCADO

ListaDeInput.forEach((input) => {
  input.addEventListener("focus", () => {
    input.style.borderBottom = "0.2rem solid #f8f9fa";
  });
});

// MUDA A COR DA BORDA INFERIOR QUANDO NÃO ESTIVER FOCADO

ListaDeInput.forEach((input) => {
  input.addEventListener("blur", () => {
    input.style.borderBottom = "0.2rem solid #00000000";
  });
});
