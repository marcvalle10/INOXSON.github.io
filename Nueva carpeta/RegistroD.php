<?php 
require_once "vistas/parte_superior.php";
require_once 'CRUD/rd_crud.php'; // Asegúrate de que la ruta sea correcta

// Crea una instancia de la clase RD_Crud
$disparador = new RD_Crud();

// Manejo de la inserción
if (isset($_POST['crear'])) {
    $nombre_disparador = $_POST['nombre_disparador'];
    $accion = $_POST['accion'];

    if (!empty($nombre_disparador) && !empty($accion)) {
        if ($disparador->crearDisparador($nombre_disparador, $accion)) {
            echo "<p>Disparador agregado con éxito.</p>";
        } else {
            echo "<p>Error al agregar el disparador.</p>";
        }
    } else {
        echo "<p>Por favor, llena todos los campos obligatorios.</p>";
    }
}

// Manejo de la actualización
if (isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $nombre_disparador = $_POST['nombre_disparador'];
    $accion = $_POST['accion'];

    if ($disparador->actualizarDisparador($id, $nombre_disparador, $accion)) {
        echo "<p>Disparador actualizado con éxito.</p>";
    } else {
        echo "<p>Error al actualizar el disparador.</p>";
    }
}

// Manejo de la eliminación
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    if ($disparador->eliminarDisparador($id)) {
        echo "<p>Disparador eliminado con éxito.</p>";
    } else {
        echo "<p>Error al eliminar el disparador.</p>";
    }
}

// Obtener y mostrar disparadores
$disparadores = $disparador->obtenerDisparadores();

$disparador_a_editar = null; // Inicializar la variable aquí

// Manejo de edición
if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $disparador_a_editar = $disparador->getDisparadorById($id); // Obtiene el disparador a editar
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Registro de Disparadores</title>
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
    <h1>Gestión de Registro de Disparadores</h1>

    <!-- Formulario para agregar disparador -->
    <form method="POST" action="">
        <input type="text" name="nombre_disparador" placeholder="Nombre del Disparador" required>
        <input type="text" name="accion" placeholder="Acción" required>
        <button type="submit" name="crear">Agregar Disparador</button>
    </form>

    <h2>Lista de Disparadores</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Disparador</th>
                <th>Acción</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($disparadores as $disparador): ?>
                <tr>
                    <td><?php echo $disparador['id']; ?></td>
                    <td><?php echo $disparador['nombre_disparador']; ?></td>
                    <td><?php echo $disparador['accion']; ?></td>
                    <td><?php echo $disparador['fecha']; ?></td>
                    <td>
                        <a href="?eliminar=<?php echo $disparador['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este disparador?')">Eliminar</a>
                        <a href="?editar=<?php echo $disparador['id']; ?>">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($disparador_a_editar): // Solo muestra el formulario de edición si hay un disparador a editar ?>
        <h2>Editar Disparador</h2>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $disparador_a_editar['id']; ?>">
            <input type="text" name="nombre_disparador" value="<?php echo $disparador_a_editar['nombre_disparador']; ?>" required>
            <input type="text" name="accion" value="<?php echo $disparador_a_editar['accion']; ?>" required>
            <button type="submit" name="actualizar">Actualizar Disparador</button>
        </form>
    <?php endif; ?>
</body>
</html>

<?php 
require_once "vistas/parte_inferior.php";
?>
