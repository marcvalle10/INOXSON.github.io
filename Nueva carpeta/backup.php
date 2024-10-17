<?php
// backup.php

$host = 'localhost';
$dbname = 'inoxson2';  // Nombre de la base de datos
$username = 'root';  // Usuario de la base de datos
$password = '';  // Contraseña del usuario de la base de datos

// Carpeta donde se almacenará el respaldo
$backup_dir = __DIR__ . '/backups/'; // Crea una carpeta 'backups' en el mismo directorio
if (!is_dir($backup_dir)) {
    mkdir($backup_dir, 0755, true); // Crear la carpeta si no existe
}

// Nombre del archivo de respaldo
$backup_file = $backup_dir . 'respaldodb_' . date('Y-m-d_H-i-s') . '.sql';

// Comando mysqldump para generar el respaldo
$command = "mysqldump --opt --user={$username} --password={$password} --host={$host} {$dbname} > {$backup_file}";

// Ejecutar el comando
$output = null;
$retval = null;
exec($command, $output, $retval);

// Verificar si se creó el archivo
if ($retval === 0 && file_exists($backup_file)) {
    // Configurar los encabezados para forzar la descarga
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($backup_file));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($backup_file));
    
    // Enviar el archivo al navegador
    flush(); // Limpia el búfer del sistema
    readfile($backup_file); // Lee el archivo y lo envía al navegador

    // Eliminar el archivo temporal después de la descarga
    unlink($backup_file);
    exit;
} else {
    echo "Error al crear el respaldo. Código de salida: $retval";
    // Si quieres ver la salida del comando para debug:
    echo "<pre>" . print_r($output, true) . "</pre>";
}
?>
