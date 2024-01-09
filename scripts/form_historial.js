// Obtener cookie
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

// Obtener CURP de la cookie
var curpUsuario = getCookie("usuario");

if (!curpUsuario) {
    // Redirigir a la página de inicio de sesión si no se encuentra el CURP en la cookie
    window.location.href = "index.html";
}

// Llamada a la función para cargar la tabla con los historiales del paciente
cargarTabla(curpUsuario);

function cargarTabla(curpUsuario) {
    // Realizar una solicitud AJAX para obtener los datos de la tabla
    $.ajax({
        type: "POST",
        url: "php/obtener_historiales_pac.php",
        data: { curpUsuario: curpUsuario },
        success: function (data) {
            // Actualizar la tabla HTML con los datos obtenidos
            var datos = JSON.parse(data);
            actualizarTabla(datos);
        }
    });
}

function actualizarTabla(datos) {
  $("tbody").empty();

  for (var i = 0; i < datos.length; i++) {
      var fila = "<tr>" +
          "<td>" + datos[i].IDexpediente + "</td>" +
          "<td>" + datos[i].FechaHistorial + "</td>" +
          "<td>" +
          "<button class='btn btn-primary imprimir-button' data-id='" + datos[i].IDexpediente + "'>Mostrar</button>" +
          "</td>" +
          "</tr>";

      $("tbody").append(fila);
  }

  // Agregar evento de clic al botón "Imprimir" para generar el PDF
  $(".imprimir-button").click(function () {
      var idExpediente = $(this).data("id");
      console.log("Clic en Imprimir, ID Expediente:", idExpediente);
      mostrarDetallesHistorial(idExpediente);
  });
}
function mostrarDetallesHistorial(idExpediente) {
  $.ajax({
      type: "POST",
      url: "php/obtener_detalle_historial.php",
      data: { idExpediente: idExpediente },
      success: function (data) {
          try {
              var detalleHistorial = JSON.parse(data);

              if (detalleHistorial.error) {
                  console.error("Error del servidor:", detalleHistorial.error);
                  return;
              }

              // Guarda los detalles del historial en sessionStorage
              sessionStorage.setItem('detalleHistorial', JSON.stringify(detalleHistorial));

              // Abre una nueva ventana o pestaña con la nueva página
              var nuevaVentana = window.open('detalle_historial.html', '_blank');
              if (nuevaVentana) {
                  nuevaVentana.focus();
              } else {
                  console.error('No se pudo abrir una nueva ventana.');
              }
          } catch (error) {
              console.error("Error al obtener los detalles del historial:", error);
          }
      },
      error: function (xhr, status, error) {
          console.error("Error en la solicitud AJAX:", status, error);
      }
  });
}














