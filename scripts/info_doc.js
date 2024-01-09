// Obtener el valor de la cookie "usuario"
var usuario = getCookie("usuario");
if (!usuario) {
  // Redirigir a la página de inicio de sesión
  window.location.href = "index.html";
}

function getCookie(name) {
  var cookies = document.cookie.split(';');
  for (var i = 0; i < cookies.length; i++) {
    var cookie = cookies[i].trim();
    if (cookie.startsWith(name + '=')) {
      return cookie.substring(name.length + 1);
    }
  }
  return '';
}
// Realizar la solicitud AJAX para obtener la información del doctor
$.ajax({
    url: "php/obtener_info_doctor.php",
    type: "POST",
    data: { usuario: usuario },
    success: function(response) {
      // Parsea la respuesta JSON
      var infoDoctor = JSON.parse(response);
  
      // Llena automáticamente los campos del formulario con los datos del doctor
      document.getElementById("nombresDoc").value = infoDoctor.nombresDoc;
      document.getElementById("apellidosDoc").value = infoDoctor.apellidosDoc;
      document.getElementById("cedulaDoc").value = infoDoctor.cedulaDoc;
    },
    error: function() {
      console.error("Error al obtener la información del doctor");
    }
  });