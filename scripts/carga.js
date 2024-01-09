    // Función para cargar automaticamente una pagina
    $(document).ready(function() {
      // Mostrar el loader automáticamente
      $('#loader').show();
  
      setTimeout(function() {
        $("#automatico").click();
      }, 0);
    });
    
    function cargarPagina(url) {
      // Mostrar el loader mientras se carga la página
      $('#loader').show();
  
      // Limpiar el contenido anterior
      $('#main').empty();
  
      $.ajax({
        url: url,
        dataType: 'html',
        success: function(response) {
          // Ocultar el loader una vez que se carga la página
          $('#loader').hide();
          $('#main').html(response);
        },
        error: function() {
          // Manejar errores y ocultar el loader en caso de error
          $('#loader').hide();
          $('#main').html('<p>Error al cargar la página</p>');
        }
      });
    }