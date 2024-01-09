$(document).ready(function() {
    var selectEspecialidades = $('#especialidades');
  
    $.ajax({
      url: 'php/obtener_especialidad.php',
      type: 'POST',
      dataType: 'json',
      success: function(data) {
          for (var i = 0; i < data.length; i++) {
              var especialidad = data[i];
              var opcionEspecialidad = $('<option></option>');
              
              // Guardar la matrícula del departamento en un atributo personalizado
              opcionEspecialidad.attr('data-matricula', especialidad.MatriculaDepto);
              
              // Usar la matrícula del departamento como valor
              opcionEspecialidad.val(especialidad.NombreDepto);
              
              // Mostrar solo el nombre de la especialidad en el texto
              opcionEspecialidad.text(especialidad.NombreDepto);
              
              selectEspecialidades.append(opcionEspecialidad);
          }
      },
      error: function(xhr, status, error) {
          console.log('Error al obtener las especialidades:', error);
      }
  });
  
  });