$(document).ready(function() {
    $("#form").submit(function(event) {
        event.preventDefault(); // Evita que se recargue la página
        // Obtén los valores de los campos de entrada por el atributo "name"
        const nombre = $("input[name='Nombre']").val();
        const contra = $("input[name='password']").val();
  
        // Verifica si algún campo está vacío
        if (nombre === '' || contra === '') {
            console.log("Campos vacíos");
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
            url: "php/registro_admin.php",
            data: datos,
            success: function(response) {
                if (response == "ok") {
                    Swal.fire({
                        title: "Registro exitoso",
                        icon: "success",
                        text: "El Administrador ha sido registrado correctamente."
                    });
                    $("#form")[0].reset(); // Limpia el formulario
                } else if (response == "existe") {
                    Swal.fire({
                        title: "Registro duplicado",
                        icon: "warning",
                        text: "El Administradorr ya está registrado en la base de datos."
                    });
                }else if (response == "error") {
                    Swal.fire({
                        title: "Error",
                        icon: "error",
                        text: "No se pudo registrar al administrador. Inténtalo de nuevo más tarde."
                    });
                }
            }
        });
    });
});