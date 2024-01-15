function validazioneForm() {
  var form = document.getElementById("formLibro");
  var elements = form.elements;
  var isValid = true;
  const regex = /^[^0-9\s]+$/;

  for (var i = 0; i < elements.length; i++) {
    var element = elements[i];

    if (element.type !== "submit" && element.type !== "button" && !element.getAttribute("optional")) {
      if ((element.id === "autore_nome" || element.id === "autore_cognome") && !regex.test(element.value)) {
        isValid = false;
        element.classList.add("error");
        alert("Il campo " + element.name + " deve contenere solo lettere.");
      } else {
        element.classList.remove("error");
      }

      if (element.id === "editore" && !regex.test(element.value)) {
        isValid = false;
        element.classList.add("error");
        alert("Il campo " + element.name + " deve contenere solo lettere.");
      } else {
        element.classList.remove("error");
      }

      if (element.id === "genere" && !regex.test(element.value)) {
        element.classList.add("error");
        isValid = false;
      } else {
        element.classList.remove("error");
      }

      if (element.id === "libro" && element.value===" ") {
        element.classList.add("error");
        isValid = false;
      } else {
        element.classList.remove("error");
      }

      if (element.type === "number" && (isNaN(element.value) || element.value < 0)) {
        element.classList.add("error");
        alert("Inserisci un valore numerico valido e non negativo per i campi numerici.");
        isValid = false;
      } else {
        element.classList.remove("error");
      }
    }
  }

  return isValid;
}
