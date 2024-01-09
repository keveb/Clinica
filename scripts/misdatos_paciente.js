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

  // Obtener el valor de la cookie "usuario"
  var usuario = getCookie("usuario");
  // Función para realizar la solicitud AJAX
  function obtenerDatosUsuario() {
    $.ajax({
      url: 'php/obtener_misdatos_paciente.php', // URL de tu archivo PHP para obtener los datos
      type: 'POST',
      data: { usuario: usuario },
      dataType: 'json',
      success: function(datos) {
        // Actualizar los datos en las celdas correspondientes
        document.getElementById("curp").textContent = datos.curp;
        document.getElementById("nombre_usuario").textContent = datos.nombre;
        document.getElementById("apellidos").textContent = datos.apellidos;
        document.getElementById("edad").textContent = datos.edad;
        document.getElementById("correo_electronico").textContent = datos.correo_electronico;
        document.getElementById("telefono").textContent = datos.telefono;
        document.getElementById("direccion").textContent = datos.direccion;
        document.getElementById("fecha_registro").textContent = datos.fecha_registro;
      },
      error: function() {
        alert('Error al obtener los datos del usuario.');
      }
    });
  }

  // Llamar a la función para obtener y cargar los datos del usuario al cargar la página
  $(document).ready(function() {
    obtenerDatosUsuario();
  });