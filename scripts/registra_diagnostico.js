function convertToUppercase(input) {
    // Función para convertir las letras de CURP a mayúsculas
    input.value = input.value.toUpperCase();
  }
  
  $(document).ready(function() {
    $("#form").submit(function(event) {
        event.preventDefault(); // Evita que se recargue la página

        var curp = $("input[name='curp']").val();
        var nombres = $("input[name='nombres']").val();
        var apellidos = $("input[name='apellidos']").val();
        var edad = $("input[name='edad']").val();
        var correo = $("input[name='correo']").val(); 
        var telefono = $("input[name='telefono']").val(); 
        var altura = $("input[name='altura']").val();
        var peso = $("input[name='peso']").val();
        var temp = $("input[name='temp']").val();
        var alergias = $("input[name='alergias']").val();
        var antecNoPato = $("input[name='antecNoPato']").val();
        var tratamientosAct = $("input[name='tratamientosAct']").val();
        var antecedentes = $("input[name='antecedentes']").val();
        var enfermedades = $("input[name='enfermedades']").val();
        var discapacidades = $("input[name='disc']").val();
        var sintomas = $("input[name='sintomas']").val();

        // Datos adicionales del doctor
        var nombresDoc = $("input[name='nombresDoc']").val();
        var apellidosDoc = $("input[name='apellidosDoc']").val();
        var cedulaDoc = $("input[name='cedulaDoc']").val();

        // Verifica si algún campo está vacío
        if (curp === '' || nombres === '' || apellidos === '' || edad === '' || correo === '' || telefono === '') {
            // Muestra un mensaje de error utilizando SweetAlert
            Swal.fire({
                title: "Error",
                icon: "error",
                text: "Falta llenar campos. Por favor, completa todos los campos."
            });
            return; // Detiene la ejecución del código
        }

        // Crear un objeto JSON con los datos
        var datosJSON = {
            curp: curp,
            nombres: nombres,
            apellidos: apellidos,
            edad: edad,
            correo: correo,
            telefono: telefono,
            altura: altura,
            peso: peso,
            temp: temp,
            alergias: alergias,
            antecNoPato : antecNoPato,
            tratamientosAct: tratamientosAct,
            antecedentes: antecedentes,
            enfermedades: enfermedades,
            discapacidades: discapacidades,
            sintomas: sintomas,
            nombresDoc: nombresDoc,
            apellidosDoc: apellidosDoc,
            cedulaDoc: cedulaDoc
        };

        $.ajax({
            type: "POST",
            url: "php/guardar_diagnostico.php",
            data: datosJSON,
            dataType: "json",  // Especifica el tipo de datos esperado del servidor
            success: function(response) {

                if (response.result === "ok") {
                    Swal.fire({
                        title: "Registro exitoso",
                        icon: "success",
                        text: response.message
                    });
                    $("#form")[0].reset(); // Limpia el formulario
                } else {
                    Swal.fire({
                        title: "Error",
                        icon: "error",
                        text: response.message
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                Swal.fire({
                    title: "Error",
                    icon: "error",
                    text: "Hubo un error en la solicitud. Inténtalo de nuevo más tarde."
                });
            }
        });
    });
});




