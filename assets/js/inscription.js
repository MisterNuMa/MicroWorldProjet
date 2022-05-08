// function JavaScript qui permet d'afficher la photo directement dans le formulaire d'inscription.
function actuPhoto(element) {
    var image=document.getElementById("photoUtilisateur");
    var fReader = new FileReader();
    fReader.readAsDataURL(image.files[0]);
    fReader.onloadend = function(event) {
        var img = document.getElementById("photo");
        img.src = event.target.result;
    }
}

function validationMotDePasse() {
    $motDePasse1=document.getElementById("motdepasse1").value;
    console.log($motDePasse1);
    $motDePasse2=document.getElementById("motdepasse2").value;
    if ($motDePasse1 != $motDePasse2) {
        document.getElementById("erreurMotDePasse").value="Erreur";
    }
}

var mail=document.getElementById("email");
mail.addEventListener("blur", function (evt) {
    console.log("Perte de focus pour le mail");
});

var motDePasse=document.getElementById("motdepasse2");
motDePasse.addEventListener("blur", function (evt) {
    validationMotDePasse();
});

(function() {
    "use strict"
    window.addEventListener("load", function() {
        var form = document.getElementById("form")
        form.addEventListener("submit", function(event) {
            if (form.checkValidity() == false) {
                event.preventDefault()
                event.stopPropagation()
            }
        form.classList.add("was-validated")
        }, false)
    }, false)
}())

function Afficher1() { 
    var input = document.getElementById("motdepasse1"); 
    if (input.type === "password") { 
        input.type = "text"; 
    } else { 
        input.type = "password"; 
    } 
}

function Afficher2() { 
    var input = document.getElementById("motdepasse2"); 
    if (input.type === "password") { 
        input.type = "text"; 
    } else { 
        input.type = "password"; 
    } 
}