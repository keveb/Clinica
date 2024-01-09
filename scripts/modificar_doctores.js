$(document).ready(function() {
    cargarTabla(); // Cargar la tabla al cargar la página

    $("#form").submit(function(event) {
        event.preventDefault(); // Evita que se recargue la página
        var UPDATE = $(this).serialize(); // Obtiene los datos del formulario
        $.ajax({
            type: "POST",
            url: "php/modi_doctores.php",
            data: UPDATE,
            success: function(response) {
                if (response == "ok") {
                    Swal.fire({
                        title: "Modificación exitosa",
                        icon: "success",
                        text: "El doctor ha sido modificado correctamente."
                    });

                    cargarTabla(); // Actualizar la tabla después de la modificación
                } else if (response == "error") {
                    Swal.fire({
                        title: "Error",
                        icon: "error",
                        text: "No se pudo modificar al doctor. Inténtalo de nuevo más tarde."
                    });
                }
            }
        });
    });
});

// Función para cargar la tabla con los datos
function cargarTabla() {
    // Realizar una solicitud AJAX para obtener los datos de la tabla
    $.ajax({
        type: "POST",
        url: "php/obtener_datos_doctores.php",
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
        "<td>" + datos[i].CurpDoc + "</td>" +
        "<td>" + datos[i].nombresDoc + "</td>" +
        "<td>" + datos[i].apellidosDoc + "</td>" +
        "<td>" + datos[i].edadDoc + "</td>" +
        "<td>" + datos[i].correoDoc + "</td>" +
        "<td>" + datos[i].telefonoDoc + "</td>" +
        "<td>" + datos[i].direccionDoc + "</td>" +
        "<td>" + datos[i].especialidadDoc + "</td>" +
        "<td>" + datos[i].cedulaDoc + "</td>" +
        "<td>" + datos[i].fecha_registroDoc + "</td>" +
        "<td>";
        
      if (datos[i].estatusDoc === "activo") {
        fila += "<button class='btn btn-warning' data-id='" + datos[i].CurpDoc + "'>EDITAR</button>";
        fila += "<button class='btn btn-success estado-button' data-id='" + datos[i].CurpDoc + "' data-estado='activo'>Activo</button>";
      } else if (datos[i].estatusDoc === "inactivo") {
        fila += "<button class='btn btn-danger estado-button' data-id='" + datos[i].CurpDoc + "' data-estado='inactivo'>Inactivo</button>";
      }
        
      fila += "</td>" +
        "</tr>";
      $("tbody").append(fila);
    }
  }

// Evento de clic para los botones de ESTATUS
$(document).on("click", ".estado-button", function() {
    var curp = $(this).closest("tr").find("td:first").text(); // Obtener el CURP del registro
    var estado = $(this).data("estado");
    var nuevoEstado = (estado === "activo") ? "inactivo" : "activo";
  
    Swal.fire({
      title: "¿Estás seguro?",
      text: "El estado del registro será cambiado a " + nuevoEstado + ".",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Sí, cambiar",
      cancelButtonText: "Cancelar"
    }).then((result) => {
      if (result.isConfirmed) {
        // Realizar una solicitud AJAX para cambiar el estado del registro
        $.ajax({
          type: "POST",
          url: "php/estatus_doctor.php",
          data: { curp: curp, estado: nuevoEstado }, // Enviar el CURP y el nuevo estado
          success: function(response) {
            if (response == "ok") {
              Swal.fire({
                title: "Cambiado",
                icon: "success",
                text: "El estado del registro ha sido cambiado correctamente."
              });
  
              cargarTabla(); // Actualizar la tabla después del cambio de estado
            } else if (response == "error") {
              Swal.fire({
                title: "Error",
                icon: "error",
                text: "No se pudo cambiar el estado del registro. Inténtalo de nuevo más tarde."
              });
            }
          }
        });
      }
    });
  });


$(document).ready(function() {
    cargarTabla(); // Cargar la tabla al cargar la página

    $("#miFormulario").submit(function(e) {
        e.preventDefault(); // Evitar que el formulario se envíe automáticamente

        var busqueda = $("#busquedaInput").val();

        if (busqueda.trim() !== "") {
            // Realizar una solicitud AJAX para buscar pacientes
            $.ajax({
                type: "POST",
                url: "php/buscar_doctores.php",
                data: { busqueda: busqueda },
                success: function(data) {
                    var doctores = JSON.parse(data);

                    if (doctores.length > 0) {
                        // Actualizar la tabla con los resultados de la búsqueda
                        actualizarTabla(doctores);
                    } else {
                        mostrarRegistroNoEncontrado();
                    }
                },
                error: function() {
                    mostrarError();
                }
            });
        } else {
            cargarTabla();
        }
    });

    // Evento de cambio en el input de búsqueda
    $("#busquedaInput").on("input", function() {
        if ($(this).val().trim() === "") {
            cargarTabla();
        }
    });
});

// Función para mostrar el mensaje de "Registro no encontrado"
function mostrarRegistroNoEncontrado() {
    Swal.fire({
        title: "Registro no encontrado",
        icon: "info",
        text: "No se encontraron doctores que coincidan con la búsqueda."
    });
}

// Función para mostrar el mensaje de error
function mostrarError() {
    Swal.fire({
        title: "Error",
        icon: "error",
        text: "Error al realizar la búsqueda. Inténtalo de nuevo más tarde."
    });
}