$(document).ready(function() {
    $("#form").submit(function(event) {
      event.preventDefault(); // Evita que se recargue la página
  
      // Obtén los valores de los campos de entrada por el atributo "name"
      const departamento = $("input[name='Departamento']").val();
      const matricula = $("input[name='Matricula']").val();
      
  
      // Verifica si algún campo está vacío
      if (departamento === '' || matricula === '') {
        // Muestra un mensaje de error utilizando SweetAlert
        Swal.fire({
          title: "Error",
          icon: "error",
          text: "Falta llenar campos. Por favor, completa todos los campos."
        });
        return; // Detiene la ejecución del código
      }
  
      var datos = $(this).serialize(); // Obtiene los datos del formulario
  
      $.ajax({
        type: "POST",
        url: "php/registro_especialidad.php",
        data: datos,
        success: function(response) {
          if (response == "ok") {
            Swal.fire({
              title: "Registro exitoso",
              icon: "success",
              text: "La especialidad ha sido registrado correctamente."
            });
            $("#form")[0].reset(); // Limpia el formulario
            cargarTabla();
          } else if (response == "existe") {
            Swal.fire({
              title: "Registro duplicado",
              icon: "warning",
              text: "La especialidad ya está registrado en la base de datos."
            });
          } else if (response == "error") {
            Swal.fire({
              title: "Error",
              icon: "error",
              text: "No se pudo registrar la especialidad. Inténtalo de nuevo más tarde."
            });
          }
        }
      });
    });
  });

  $(document).ready(function() {
    cargarTabla(); // Cargar la tabla al cargar la página


});

// Función para cargar la tabla con los datos
function cargarTabla() {
    // Realizar una solicitud AJAX para obtener los datos de la tabla
    $.ajax({
        type: "POST",
        url: "php/tabla_especialidad.php",
        success: function(data) {
            // Actualizar la tabla HTML con los datos obtenidos
            var datos = JSON.parse(data); // Suponiendo que los datos se devuelven en formato JSON
            actualizarTabla(datos);
        }
    });
}

// Función para actualizar la tabla HTML con los datos
function actualizarTabla(datos) {
    // Eliminar las filas existentes en la tabla
    $("tbody").empty();

    // Agregar las nuevas filas con los datos
    for (var i = 0; i < datos.length; i++) {
        var fila = "<tr>" +
            "<td>" + datos[i].MatriculaDepto + "</td>" +
            "<td>" + datos[i].NombreDepto + "</td>" +
            "</tr>";
        $("tbody").append(fila);
    }
}