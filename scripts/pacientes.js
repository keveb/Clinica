function convertToUppercase(input) {
    // Función para convertir las letras de CURP a mayúsculas
    input.value = input.value.toUpperCase();
  }
  
  $(document).ready(function() {
    $("#form").submit(function(event) {
      event.preventDefault(); // Evita que se recargue la página
  
      // Obtén los valores de los campos de entrada por el atributo "name"
      const curp = $("input[name='CURP']").val();
      const nombre = $("input[name='Nombre']").val();
      const apellido = $("input[name='Apellidos']").val();
      const edad = $("input[name='Edad']").val();
      const correo = $("input[name='Email']").val();
      const telefono = $("input[name='Telefono']").val();
      const direccion = $("input[name='Direccion']").val();
      
  
      // Verifica si algún campo está vacío
      if (curp === '' || nombre === '' || apellido === '' || edad === '' || correo === '' || telefono === '' || direccion === '') {
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
        url: "php/registro_pacientes.php",
        data: datos,
        success: function(response) {
          if (response == "ok") {
            Swal.fire({
              title: "Registro exitoso",
              icon: "success",
              text: "El paciente ha sido registrado correctamente."
            });
            $("#form")[0].reset(); // Limpia el formulario
          } else if (response == "existe") {
            Swal.fire({
              title: "Registro duplicado",
              icon: "warning",
              text: "El paciente ya está registrado en la base de datos."
            });
          } else if (response == "error") {
            Swal.fire({
              title: "Error",
              icon: "error",
              text: "No se pudo registrar al paciente. Inténtalo de nuevo más tarde."
            });
          }
        }
      });
    });
  });