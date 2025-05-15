$(document).ready(function() {
  $('#register-form').submit(function(event) {
    event.preventDefault();

    $('#usuario-error').hide();
    $('#email-error').hide();

    const nombre = $('#nombre').val();
    const usuario = $('#usuario').val();
    const email = $('#email').val();
    const password = $('#password').val();

    $.ajax({
      url: 'php/auth.php',
      type: 'POST',
      data: {
        accion: 'registro',
        nombre: nombre,
        usuario: usuario,
        email: email,
        password: password
      },
      success: function(response) {
        let res = JSON.parse(response);
        if (res.status === 'error') {
          if (res.errors.includes('usuario_existente')) {
            $('#usuario-error').show();
          }
          if (res.errors.includes('email_existente')) {
            $('#email-error').show();
          }
        } else if (res.status === 'success') {
          window.location.href = 'login.html';
        }
      },
      error: function() {
        alert('Error al conectar con el servidor. Registro');
      }
    });
  });

  $('#login-form').submit(function(event) {
    event.preventDefault();
  
    $('#login-usuario-error').hide();
    $('#login-password-error').hide();
  
    const identificador = $('#login-identificador').val();
    const password = $('#login-password').val();
  
    $.ajax({
      url: 'php/auth.php',
      type: 'POST',
      data: {
        accion: 'login',
        identificador: identificador,
        password: password
      },
      success: function(response) {
        let res = JSON.parse(response);
        if (res.status === 'error') {
          if (res.errors.includes('usuario_no_encontrado')) {
            $('#login-usuario-error').show();
          }
          if (res.errors.includes('contraseña_incorrecta')) {
            $('#login-password-error').show();
          }
        } else if (res.status === 'success') {
          window.location.href = '../panel/panel.php'; // o tu panel principal
        }
      },
      error: function() {
        alert('Error al conectar con el servidor. Login');
      }
    });
  });
  
});
