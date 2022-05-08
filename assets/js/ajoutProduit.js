function actuPhoto(element) {
  var image=document.getElementById("nomImage");
  var fReader = new FileReader();
  fReader.readAsDataURL(image.files[0]);
  fReader.onloadend = function(event) {
      var img = document.getElementById("affiche");
      img.src = event.target.result;
  }
}

function actuPhoto1(element) {
  var image=document.getElementById("nomImage1");
  var fReader = new FileReader();
  fReader.readAsDataURL(image.files[0]);
  fReader.onloadend = function(event) {
      var img = document.getElementById("affiche1");
      img.src = event.target.result;
  }
}

function actuPhoto2(element) {
  var image=document.getElementById("nomImage2");
  var fReader = new FileReader();
  fReader.readAsDataURL(image.files[0]);
  fReader.onloadend = function(event) {
      var img = document.getElementById("affiche2");
      img.src = event.target.result;
  }
}

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