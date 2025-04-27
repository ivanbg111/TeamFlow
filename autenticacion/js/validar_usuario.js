$(document).ready(function() {
  // Prevenimos el comportamiento por defecto del formulario
  $('#register-form').submit(function(event) {
    event.preventDefault(); // Evita que el formulario se envíe de la manera tradicional

    // Ocultar los mensajes de error antes de hacer la nueva validación
    $('#usuario-error').hide();
    $('#email-error').hide();

    // Obtenemos los valores del formulario
    const nombre = $('#nombre').val();
    const email = $('#email').val();
    const usuario = $('#usuario').val();
    const password = $('#password').val();

    console.log("Datos enviados:", {nombre, email, usuario, password}); // Verificar que los datos son correctos

    // Realizamos la solicitud AJAX
    $.ajax({
      url: 'php/validar_usuario.php', // El archivo PHP que validará los datos
      type: 'POST',
      data: {
        nombre: nombre,
        email: email,
        usuario: usuario,
        password: password
      },
      success: function(response) {
        console.log("Respuesta del servidor:", response); // Ver la respuesta del servidor

        // Convertir la respuesta en un objeto JSON
        let responseData = JSON.parse(response); // Convertir la respuesta JSON en un objeto de JavaScript

        if (responseData.status === 'error') {
          // Mostrar los errores según la respuesta
          if (responseData.errors.includes('usuario_existente')) {
            $('#usuario-error').show();
          }
          if (responseData.errors.includes('email_existente')) {
            $('#email-error').show();
          }
        } else if (responseData.status === 'success') {
          // Si el registro fue exitoso, redirigir al login o al panel de control
          window.location.href = 'login.html';
        }
      },
      error: function(xhr, status, error) {
        console.log("Error en la solicitud AJAX:", error); // Ver detalles del error
        alert('Hubo un error al procesar la solicitud.');
      }
    });
  });
});
