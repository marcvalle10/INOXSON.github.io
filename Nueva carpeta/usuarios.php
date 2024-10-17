<?php 
require_once "vistas/parte_superior.php";
require_once 'CRUD/u_crud.php'; // Asegúrate de que la ruta sea correcta

// Crea una instancia de la clase U_Crud
$usuario = new U_Crud();

// Manejo de la inserción
if (isset($_POST['crear'])) {
    $rol_id = $_POST['rol_id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if (!empty($rol_id) && !empty($username) && !empty($password) && !empty($email)) {
        if ($usuario->crearUsuario($rol_id, $username, $password, $email)) {
            echo "<p>Usuario agregado con éxito.</p>";
        } else {
            echo "<p>Error al agregar el usuario.</p>";
        }
    } else {
        echo "<p>Por favor, llena todos los campos obligatorios.</p>";
    }
}

// Manejo de la actualización
if (isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $rol_id = $_POST['rol_id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if ($usuario->actualizarUsuario($id, $rol_id, $username, $password, $email)) {
        echo "<p>Usuario actualizado con éxito.</p>";
    } else {
        echo "<p>Error al actualizar el usuario.</p>";
    }
}

// Manejo de la eliminación
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    if ($usuario->eliminarUsuario($id)) {
        echo "<p>Usuario eliminado con éxito.</p>";
    } else {
        echo "<p>Error al eliminar el usuario.</p>";
    }
}

// Obtener y mostrar usuarios
$usuarios = $usuario->obtenerUsuarios();

$usuario_a_editar = null; // Inicializar la variable aquí

// Manejo de edición
if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $usuario_a_editar = $usuario->getUsuarioById($id); // Obtiene el usuario a editar
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            margin-bottom: 20px;
        }
        .edit-form {
            display: inline-block;
        }
    </style>
</head>
<body>
    <h1>Gestión de Usuarios</h1>

    <!-- Formulario para agregar usuario -->
    <form method="POST" action="">
        <input type="number" name="rol_id" placeholder="ID Rol" required>
        <input type="text" name="username" placeholder="Nombre de Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <input type="email" name="email" placeholder="Email" required>
        <button type="submit" name="crear">Agregar Usuario</button>
    </form>

    <h2>Lista de Usuarios</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Rol ID</th>
                <th>Nombre de Usuario</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo $usuario['id']; ?></td>
                    <td><?php echo $usuario['rol_id']; ?></td>
                    <td><?php echo $usuario['username']; ?></td>
                    <td><?php echo $usuario['email']; ?></td>
                    <td>
                        <a href="?eliminar=<?php echo $usuario['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
                        <a href="?editar=<?php echo $usuario['id']; ?>">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($usuario_a_editar): // Solo muestra el formulario de edición si hay un usuario a editar ?>
        <h2>Editar Usuario</h2>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $usuario_a_editar['id']; ?>">
            <input type="number" name="rol_id" value="<?php echo $usuario_a_editar['rol_id']; ?>" required>
            <input type="text" name="username" value="<?php echo $usuario_a_editar['username']; ?>" required>
            <input type="password" name="password" placeholder="Nueva Contraseña (opcional)">
            <input type="email" name="email" value="<?php echo $usuario_a_editar['email']; ?>" required>
            <button type="submit" name="actualizar">Actualizar Usuario</button>
        </form>
    <?php endif; ?>
</body>
</html>

<?php 
require_once "vistas/parte_inferior.php";
?>
