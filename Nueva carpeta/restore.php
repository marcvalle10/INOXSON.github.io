<?php
$host = 'localhost';
$dbname = 'inoxson2';  // Nombre de la base de datos
$username = 'root';
$password = '';

$alertMessage = '';
$alertType = '';  // success o error

if (isset($_FILES['backup_file']) && $_FILES['backup_file']['error'] == 0) {
    // Ruta del archivo subido
    $backup_file = $_FILES['backup_file']['tmp_name'];

    // Comando para restaurar la base de datos
    $command = "mysql --user={$username} --password={$password} --host={$host} {$dbname} < {$backup_file}";

    // Ejecutar el comando
    system($command, $output);

    if ($output === 0) {
        $alertMessage = "Restauración completada con éxito.";
        $alertType = 'success';
    } else {
        $alertMessage = "Error al restaurar la base de datos.";
        $alertType = 'error';
    }
} else {
    $alertMessage = "Por favor, seleccione un archivo de respaldo válido.";
    $alertType = 'error';
}

// Redirigir con el mensaje
header("Location: index.php?alert_message={$alertMessage}&alert_type={$alertType}");
exit();
?>
