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
            opcionEspecialidad.val(especialidad.MatriculaDepto);
            
            // Mostrar solo el nombre de la especialidad en el texto
            opcionEspecialidad.text(especialidad.NombreDepto);
            
            selectEspecialidades.append(opcionEspecialidad);
        }
    },
    error: function(xhr, status, error) {
        console.log('Error al obtener las especialidades:', error);
    }
});

var inputIdAsignado = $('#idasignado');
var especialidadSeleccionadaAnterior = null;
var idAsignadoAnterior = null;

selectEspecialidades.on('change', function() {
    var especialidadSeleccionada = selectEspecialidades.val();

    // Verificar si es la primera vez que selecciona esta especialidad o si ya se ha seleccionado anteriormente
    if (especialidadSeleccionada !== especialidadSeleccionadaAnterior || !idAsignadoAnterior) {
        // Realizar una solicitud AJAX para obtener los IDasignado de la especialidad seleccionada
        $.ajax({
            url: 'php/obtener_idasignado.php',
            type: 'POST',
            dataType: 'json',
            data: { especialidad: especialidadSeleccionada },
            success: function(data) {
                // Si hay al menos un IDasignado disponible
                if (data.length > 0) {
                    // Verificar si ya hay un IDasignado anterior
                    if (idAsignadoAnterior) {
                        // Utilizar el mismo IDasignado que se utilizó anteriormente
                        inputIdAsignado.val(idAsignadoAnterior);
                    } else {
                        // Seleccionar aleatoriamente un IDasignado
                        var idAsignadoSeleccionado = data[Math.floor(Math.random() * data.length)].IDasignado;

                        // Almacena la especialidad actual y el IDasignado seleccionado para su uso futuro
                        especialidadSeleccionadaAnterior = especialidadSeleccionada;
                        idAsignadoAnterior = idAsignadoSeleccionado;

                        // Establece el valor del input con el IDasignado seleccionado
                        inputIdAsignado.val(idAsignadoSeleccionado);
                    }
                } else {
                    console.log('No hay IDasignado disponible para la especialidad seleccionada.');
                }
            },
            error: function(xhr, status, error) {
                console.log('Error al obtener los IDasignado:', error);
            }
        });
    } else {
        // Si ya se seleccionó esta especialidad anteriormente, utiliza el mismo IDasignado
        inputIdAsignado.val(idAsignadoAnterior);
    }
});

});