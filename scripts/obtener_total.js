$(document).ready(function () {
    obtenerTotales();
  });

  function obtenerTotales() {
    $.ajax({
      url: "php/obtener_total.php",
      type: "Post",
      success: function (data) {
        var totales = JSON.parse(data);
        $("#total-administradores").text(
          "Total administradores: " + totales.administradores
        );
        $("#total-pacientes").text("Total pacientes: " + totales.pacientes);
        $("#total-doctores").text("Total doctores: " + totales.doctores);
        $("#total-especialidades").text(
          "Total especialidades: " + totales.especialidades
        );
      },
      error: function () {
        $("#total-administradores").text(
          "Error al obtener el total de administradores."
        );
        $("#total-pacientes").text("Error al obtener el total de pacientes.");
        $("#total-doctores").text("Error al obtener el total de doctores.");
        $("#total-especialidades").text(
          "Error al obtener el total de especialidades."
        );
      },
    });
  }