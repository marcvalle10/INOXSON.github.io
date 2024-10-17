<?php 
require_once "vistas/parte_superior.php";
require_once 'CRUD/s_crud.php'; // Asegúrate de que la ruta sea correcta


$db = new Database(); // Esto debería crear la conexión
$sesionesCrud = new SesionesCRUD($db); // Asegúrate de que $db tiene la propiedad $pdo correctamente inicializada


// Crear una instancia de Database
$database = new Database(); // Inicializa la conexión a la base de datos
$db = $database->getConnection(); // Obtener la conexión

// Crea una instancia de la clase SesionesCRUD 
$sSesion = new SesionesCRUD($database); // Pasamos la instancia de Database

// Manejo de la inserción
if (isset($_POST['crear'])) {
    $usuario_id = $_POST['usuario_id'];
    $token = $_POST['token'];

    if (!empty($usuario_id) && !empty($token)) {
        if ($sSesion->crearSesion($usuario_id, $token)) {
            echo "<p>Sesión agregada con éxito.</p>";
        } else {
            echo "<p>Error al agregar la sesión.</p>";
        }
    } else {
        echo "<p>Por favor, llena todos los campos obligatorios.</p>";
    }
}

// Manejo de la actualización
if (isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $fecha_fin = $_POST['fecha_fin'];

    if ($sSesion->actualizarSesion($id, $fecha_fin)) {
        echo "<p>Sesión actualizada con éxito.</p>";
    } else {
        echo "<p>Error al actualizar la sesión.</p>";
    }
}

// Manejo de la eliminación
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    if ($sSesion->eliminarSesion($id)) {
        echo "<p>Sesión eliminada con éxito.</p>";
    } else {
        echo "<p>Error al eliminar la sesión.</p>";
    }
}

// Obtener y mostrar sesiones
$sesiones = $sSesion->obtenerSesiones();

$sesion_a_editar = null; // Inicializar la variable aquí

// Manejo de edición
if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $sesion_a_editar = $sSesion->getSesionById($id); // Obtiene la sesión a editar
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Sesiones</title>
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
    <h1>Gestión de Sesiones</h1>

    <!-- Formulario para agregar sesión -->
    <form method="POST" action="">
        <input type="number" name="usuario_id" placeholder="ID del Usuario" required>
        <input type="text" name="token" placeholder="Token" required>
        <button type="submit" name="crear">Agregar Sesión</button>
    </form>

    <h2>Lista de Sesiones</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Usuario</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Token</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sesiones as $sesion): ?>
                <tr>
                    <td><?php echo $sesion['id']; ?></td>
                    <td><?php echo $sesion['usuario_id']; ?></td>
                    <td><?php echo $sesion['fecha_inicio']; ?></td>
                    <td><?php echo $sesion['fecha_fin']; ?></td>
                    <td><?php echo $sesion['token']; ?></td>
                    <td>
                        <a href="?eliminar=<?php echo $sesion['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar esta sesión?')">Eliminar</a>
                        <a href="?editar=<?php echo $sesion['id']; ?>">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($sesion_a_editar): // Solo muestra el formulario de edición si hay una sesión a editar ?>
        <h2>Editar Sesión</h2>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $sesion_a_editar['id']; ?>">
            <input type="datetime-local" name="fecha_fin" value="<?php echo date('Y-m-d\TH:i', strtotime($sesion_a_editar['fecha_fin'])); ?>" required>
            <button type="submit" name="actualizar">Actualizar Sesión</button>
        </form>
    <?php endif; ?>
</body>
</html>

<?php 
require_once "vistas/parte_inferior.php";
?>
