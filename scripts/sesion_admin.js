 // Obtener el valor de la cookie "usuario"
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

 $.ajax({
   url: "php/obtener_nombre_admin.php",
   type: "POST",
   data: { usuario: usuario },
   success: function(response) {
     // Actualizar el contenido del elemento HTML con el nombre completo
     $(".profile_name").text(response);
   },
   error: function() {
     console.error("Error al obtener el nombre completo del usuario");
   }
 });

function deleteCookie(name) {
 document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
}

function cerrarSesion() {
 deleteCookie("usuario");
 // Redirigir al archivo de cierre de sesión
 window.location.href = "index.html";
}