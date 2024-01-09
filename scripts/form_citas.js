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

// Función para cargar la tabla con los datos
function cargarTabla() {
    // Realizar una solicitud AJAX para obtener los datos de la tabla
    $.ajax({
        type: "POST",
        url: "php/obtener_citas_pac.php",
        data: { usuario: usuario },
        success: function (data) {
            // Actualizar la tabla HTML con los datos obtenidos
            var datos = JSON.parse(data);
            actualizarTabla(datos);
        }
    });
}

// Función para actualizar la tabla HTML con los datos
function actualizarTabla(datos) {
    $("tbody").empty();

    for (var i = 0; i < datos.length; i++) {
        var fila = "<tr>" +
            "<td>" + datos[i].IDcita + "</td>" +
            "<td>" + datos[i].CurpPac + "</td>" +
            "<td>" + datos[i].FechaCita + "</td>" +
            "<td>" + datos[i].Hora + "</td>" +
            "<td>" + datos[i].IDasignado + "</td>" +
            "<td>" + datos[i].EstatusCita + "</td>" +
            "<td>";

        if (datos[i].EstatusCita === "programada") {
            fila += "<button class='btn btn-warning cancelar-button' data-id='" + datos[i].IDcita + "'>Cancelar</button>";
        } else if (datos[i].EstatusCita === "cancelada") {
            // No mostrar ningún botón
        }

        fila += "</td>" +
            "</tr>";

        $("tbody").append(fila);
    }

    $(".cancelar-button").on("click", function () {
        event.preventDefault();
        var idcita = $(this).data("id");

        Swal.fire({
            title: "¿Estás seguro de cancelar la cita?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Sí, cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "php/cancelar_cita.php",
                    data: { idcita: idcita },
                    success: function (response) {
                        var resultado = JSON.parse(response);
                        if (resultado.success) {
                            console.log("Cita cancelada correctamente");

                            Swal.fire({
                                title: "Cita Cancelada",
                                text: "La cita se ha cancelado correctamente.",
                                icon: "success",
                                confirmButtonColor: "#3085d6",
                            });

                            cargarTabla(); // Actualizar la tabla después de la cancelación
                        } else {
                            console.error("Error al cancelar la cita: " + resultado.error);
                        }
                    },
                    error: function (error) {
                        console.error("Error al realizar la solicitud AJAX: " + error);
                    }
                });
            }
        });
    });
}

// Llamar a cargarTabla al cargar la página
cargarTabla();


