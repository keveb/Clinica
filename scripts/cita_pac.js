$(document).ready(function() {
  // Controlador de eventos para el botón de cita
  $("#submitBtn").click(function(event) {
    event.preventDefault();

    var curp = $("input[name='CURP']").val();
    var idasignado = $("input[name='idasignado']").val();
    var hora = $("input[name='Hora']").val();
    var fecha = $("input[name='Fecha']").val();

    if (hora === '' || fecha === '') {
      Swal.fire({
        title: "Error",
        icon: "error",
        text: "Falta llenar campos. Por favor, completa todos los campos.",
        target: "#myModal" // ID del contenedor del modal
      });
      return;
    }

    // Datos a enviar al servidor
    var datosCita = {
      curp: curp,
      idasignado: idasignado,
      hora: hora,
      fecha: fecha
    };

    // Realizar la solicitud AJAX
    $.ajax({
      url: 'php/generar_cita.php',
      type: 'POST',
      data: datosCita,
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          // Cita agendada correctamente
          Swal.fire({
            title: "Cita exitosa",
            icon: "success",
            text: response.message,
            target: "#myModal"
          });
        } else {
          // Error al agendar la cita
          if (response.message.includes("no está disponible")) {
            Swal.fire({
              title: "Lo sentimos...",
              icon: "error",
              text: response.message,
              target: "#myModal"
            });
          } else {
            Swal.fire({
              title: "Error",
              icon: "error",
              text: response.message,
              target: "#myModal"
            });
          }
        }

        // Restablecer el formulario
        $("#form")[0].reset();
        $("#especialidades").val("");
      },
      error: function() {
        console.error("Error al realizar la solicitud AJAX");
      }
    });
  });

});

