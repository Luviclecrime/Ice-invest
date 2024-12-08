var numero = document.getElementById("number");
const max = 9;

if (numero) {
    numero.addEventListener("input", function() {
        // Limiter la longueur de la valeur à 'max' caractères
        if (numero.value.length > max) {
            numero.value = numero.value.substring(0, max);
        }
    });
}