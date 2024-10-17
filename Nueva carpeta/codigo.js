/*$('#formLogin').submit(function(e) {
    e.preventDefault();

    var username = $.trim($("#username").val());
    var password = $.trim($("#password").val());

    if (username.length == "" || password.length == "") {
        Swal.fire({
            icon: 'warning', // Cambié "type" por "icon", ya que "type" está obsoleto en SweetAlert2
            title: 'Debe ingresar un usuario y/o password',
        });
        return false;
    } else {
        $.ajax({
            url: "login.php",
            type: "POST",
            datatype: "json", // Esto debe estar correctamente como "dataType" (sensible a mayúsculas)
            data: { username: username, password: password },
            success: function(data) {
                try {
                    var response = JSON.parse(data); // Asegúrate de que el servidor devuelva un JSON válido
                    if (response.status == "success") {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Conexión exitosa!',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ingresar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "dashboard.php"; // Redirigir al dashboard
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Usuario y/o contraseña incorrecta',
                        });
                    }
                } catch (e) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en el servidor. Intenta nuevamente.',
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión. Intenta nuevamente.',
                });
            }
        });
    }
});*/