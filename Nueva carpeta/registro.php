<?php 
require_once "vistas/parte_superior.php";

?>



<?php


// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $rol_id = $_POST['rol_id'];
    $email = $_POST['email'];

    // Verificar que el rol_id esté en el rango permitido
    if ($rol_id < 1 || $rol_id > 4) {
        echo "El rol de usuario debe estar entre 1 y 4.";
        exit;
    }

    // Verificar que las contraseñas coincidan
    if ($password !== $confirm_password) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    // Hash de la contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Crear una instancia de la clase Database
        $db = new Database();
        $conn = $db->conn;

        // Preparar la consulta
        $sql = "INSERT INTO usuarios (username, password_hash, rol_id, email) VALUES (:username, :password_hash, :rol_id, :email)";
        $stmt = $conn->prepare($sql);

        // Verificar si la preparación fue exitosa
        if ($stmt === false) {
            die("Error en la preparación de la consulta.");
        }

        // Vincular los parámetros
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password_hash', $password_hash);
        $stmt->bindParam(':rol_id', $rol_id, PDO::PARAM_INT);
        $stmt->bindParam(':email', $email);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Registro exitoso.";
        } else {
            echo "Error en el registro: " . implode(" ", $stmt->errorInfo());
        }
    } catch (PDOException $e) {
        echo "Error en la conexión: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Empleados</title>
    <style>
        
        .container {
            background: #fff;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
            width:  500px;
        }
        h1 {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="password"], input[type="email"], select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #007BFF;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registro de Empleados</h1>
        <form method="post" action="registro.php">
            <label for="username">Nombre de usuario:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <label for="confirm_password">Confirmar Contraseña:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <br>
            <label for="rol_id">Rol:</label>
            <select id="rol_id" name="rol_id" required>
                <option value="1">Administrador</option>
                <option value="2">Vendedor</option>
                <option value="3">Diseñador</option>
                <option value="4">Contador</option>
            </select>
            <br>
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>
            <br>
            <button type="submit">Registrar</button>
        </form>
        <div class="footer">
            <p>INOXSON</p>
        </div>
    </div>
</body>
</html>
<?php 
require_once "vistas/parte_inferior.php";

?>