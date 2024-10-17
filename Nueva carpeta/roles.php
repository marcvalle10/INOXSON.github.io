<?php 
require_once "vistas/parte_superior.php";
require_once 'CRUD/r_crud.php'; // Asegúrate de que la ruta sea correcta

// Crea una instancia de la clase R_Crud
$rol = new R_Crud();

// Manejo de la inserción
if (isset($_POST['crear'])) {
    $nombre = $_POST['nombre'];

    if (!empty($nombre)) {
        if ($rol->crearRol($nombre)) {
            echo "<p>Rol agregado con éxito.</p>";
        } else {
            echo "<p>Error al agregar el rol.</p>";
        }
    } else {
        echo "<p>Por favor, llena todos los campos obligatorios.</p>";
    }
}

// Manejo de la actualización
if (isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];

    if ($rol->actualizarRol($id, $nombre)) {
        echo "<p>Rol actualizado con éxito.</p>";
    } else {
        echo "<p>Error al actualizar el rol.</p>";
    }
}

// Manejo de la eliminación
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    if ($rol->eliminarRol($id)) {
        echo "<p>Rol eliminado con éxito.</p>";
    } else {
        echo "<p>Error al eliminar el rol.</p>";
    }
}

// Obtener y mostrar roles
$roles = $rol->obtenerRoles();

$rol_a_editar = null; // Inicializar la variable aquí

// Manejo de edición
if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $rol_a_editar = $rol->getRolById($id); // Obtiene el rol a editar
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Roles</title>
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
    <h1>Gestión de Roles</h1>

    <!-- Formulario para agregar rol -->
    <form method="POST" action="">
        <input type="text" name="nombre" placeholder="Nombre del Rol" required>
        <button type="submit" name="crear">Agregar Rol</button>
    </form>

    <h2>Lista de Roles</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($roles as $rol): ?>
                <tr>
                    <td><?php echo $rol['id']; ?></td>
                    <td><?php echo $rol['nombre']; ?></td>
                    <td>
                        <a href="?eliminar=<?php echo $rol['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este rol?')">Eliminar</a>
                        <a href="?editar=<?php echo $rol['id']; ?>">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($rol_a_editar): // Solo muestra el formulario de edición si hay un rol a editar ?>
        <h2>Editar Rol</h2>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $rol_a_editar['id']; ?>">
            <input type="text" name="nombre" value="<?php echo $rol_a_editar['nombre']; ?>" required>
            <button type="submit" name="actualizar">Actualizar Rol</button>
        </form>
    <?php endif; ?>
</body>
</html>

<?php 
require_once "vistas/parte_inferior.php";
?>
