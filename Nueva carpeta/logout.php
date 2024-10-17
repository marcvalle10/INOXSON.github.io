<?php
// logout.php
session_start();
session_destroy(); // Destruye la sesión actual
header("Location: ../login.php"); // Redirige al login después de cerrar la sesión
exit();
?>
    