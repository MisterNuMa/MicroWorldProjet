var mail=document.getElementById("email");
mail.addEventListener("blur", function (evt) {
    console.log("Perte de focus pour le mail");
});

var motDePasse=document.getElementById("mdp");
motDePasse.addEventListener("blur", function (evt) {
    validationMotDePasse();
});

(function() {
    "use strict"
    window.addEventListener("load", function() {
        var form = document.getElementById("formId")
        form.addEventListener("submit", function(event) {
            if (form.checkValidity() == false) {
                event.preventDefault()
                event.stopPropagation()
            }
        form.classList.add("was-validated")
        }, false)
    }, false)
}())

function Afficher() { 
    var input = document.getElementById("mdp"); 
    if (input.type === "password") { 
        input.type = "text";
    } else {
        input.type = "password";
    } 
}