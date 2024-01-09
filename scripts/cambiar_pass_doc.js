$(document).ready(function() {
    $("#form_pass").submit(function(event) {
      event.preventDefault(); // Evita que se recargue la página
      
      // Obtén los valores de los campos de entrada por el atributo "name"
      const nuevaContrasena = $("input[name='nueva-pass']").val();
      const confirmarContrasena = $("input[name='confirmar-pass']").val();
    
      // Verificar restricciones
      var regexMayuscula = /^(?=.*[A-Z]).*$/;
      var regexNumero = /^(?=.*\d).*$/;
      var regexSigno = /^(?=.*[!@#$%^&*()\-_=+{};:,<.>]).*$/;
      
      var mensajeError = "";
    
      if (!regexMayuscula.test(nuevaContrasena)) {
        mensajeError += " una letra mayúscula,\n";
      }
    
      if (!regexNumero.test(nuevaContrasena)) {
        mensajeError += " un número,\n";
      }
    
      if (!regexSigno.test(nuevaContrasena)) {
        mensajeError += " un signo de puntuación o carácter especial.\n";
      }
    
      if (mensajeError !== "") {
        Swal.fire({
          title: "Error",
          icon: "error",
          text: "La contraseña debe incluir al menos"+mensajeError
        });
        return;
      }
    
      // Verificar coincidencia
      if (nuevaContrasena !== confirmarContrasena) {
        Swal.fire({
          title: "Error",
          icon: "error",
          text: "Las contraseñas no coinciden."
        });
        return;
      }
    
      // Combina los datos del formulario y la cookie en un objeto
      var datos = {
        nuevaPass: nuevaContrasena,
        usuario: getCookie("usuario")
      };
    
      // Enviar la solicitud AJAX para cambiar la contraseña
      $.ajax({
        type: "POST",
        url: "php/cambiar_pass_doc.php",
        data: datos,
        success: function(response) {
          if (response.trim() === "ok") {
            Swal.fire({
              title: "Éxito",
              icon: "success",
              text: "Contraseña cambiada exitosamente."
            });
            $("#form_pass")[0].reset();
          } else {
            Swal.fire({
              title: "Error",
              icon: "error",
              text: "Hubo un error al cambiar la contraseña. Por favor, intenta nuevamente más tarde."
            });
          }
        },
        error: function() {
          Swal.fire({
            title: "Error",
            icon: "error",
            text: "Hubo un error al procesar la solicitud. Por favor, intenta nuevamente más tarde."
          });
        }
      });
    });
    
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
  });