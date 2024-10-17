<?php 
require_once "vistas/parte_superior.php";
require_once 'CRUD/co_crud.php'; // Asegúrate de que la ruta sea correcta

$cotizacion = new Cotizacion(); // Crear instancia de la clase Cotizacion

// Manejo de la inserción
if (isset($_POST['crear'])) {
    $cliente_id = $_POST['cliente_id'];
    $usuario_id = $_POST['usuario_id'];
    $descripcion = $_POST['descripcion'];
    $monto = $_POST['monto'];
    $fecha = $_POST['fecha'];

    if (!empty($cliente_id) && !empty($usuario_id) && !empty($descripcion) && !empty($monto) && !empty($fecha)) {
        if ($cotizacion->crearCotizacion($cliente_id, $usuario_id, $descripcion, $monto, $fecha)) {
            echo "<p>Cotización agregada con éxito.</p>";
        } else {
            echo "<p>Error al agregar la cotización.</p>";
        }
    } else {
        echo "<p>Por favor, llena todos los campos.</p>";
    }
}

// Manejo de la actualización
if (isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $cliente_id = $_POST['cliente_id'];
    $usuario_id = $_POST['usuario_id'];
    $descripcion = $_POST['descripcion'];
    $monto = $_POST['monto'];
    $fecha = $_POST['fecha']; // Este campo ahora no se utiliza en la actualización, se puede eliminar si no es necesario

    if ($cotizacion->actualizarCotizacion($id, $cliente_id, $descripcion, $monto)) {
        echo "<p>Cotización actualizada con éxito.</p>";
    } else {
        echo "<p>Error al actualizar la cotización.</p>";
    }
}

// Manejo de la eliminación
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    if ($cotizacion->eliminarCotizacion($id)) {
        echo "<p>Cotización eliminada con éxito.</p>";
    } else {
        echo "<p>Error al eliminar la cotización.</p>";
    }
}

// Obtener y mostrar cotizaciones
$cotizaciones = $cotizacion->getCotizaciones();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizaciones</title>
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
    </style>
</head>
<body>
    <h1>Gestión de Cotizaciones</h1>

    <!-- Formulario para agregar cotización -->
    <form method="POST" action="">
        <input type="text" name="cliente_id" placeholder="ID Cliente" required>
        <input type="text" name="usuario_id" placeholder="ID Usuario" required>
        <input type="text" name="descripcion" placeholder="Descripción" required>
        <input type="number" step="0.01" name="monto" placeholder="Monto" required>
        <input type="datetime-local" name="fecha" required>
        <button type="submit" name="crear">Agregar Cotización</button>
    </form>

    <h2>Lista de Cotizaciones</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Cliente</th>
                <th>ID Usuario</th>
                <th>Descripción</th>
                <th>Monto</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cotizaciones as $cot): ?>
                <tr>
                    <td><?php echo $cot['id']; ?></td>
                    <td><?php echo $cot['cliente_id']; ?></td>
                    <td><?php echo $cot['usuario_id']; ?></td>
                    <td><?php echo $cot['descripcion']; ?></td>
                    <td><?php echo $cot['monto']; ?></td>
                    <td><?php echo $cot['fecha']; ?></td>
                    <td>
                        <a href="?eliminar=<?php echo $cot['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar esta cotización?')">Eliminar</a>
                        <a href="?editar=<?php echo $cot['id']; ?>">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
    // Manejo de edición
    if (isset($_GET['editar'])) {
        $id = $_GET['editar'];
        $cotizacion_a_editar = $cotizacion->getCotizacionPorId($id); // Asegúrate de tener este método en tu clase
    ?>
        <h2>Editar Cotización</h2>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $cotizacion_a_editar['id']; ?>">
            <input type="text" name="cliente_id" value="<?php echo $cotizacion_a_editar['cliente_id']; ?>" required>
            <input type="text" name="usuario_id" value="<?php echo $cotizacion_a_editar['usuario_id']; ?>" required>
            <input type="text" name="descripcion" value="<?php echo $cotizacion_a_editar['descripcion']; ?>" required>
            <input type="number" name="monto" value="<?php echo $cotizacion_a_editar['monto']; ?>" step="0.01" required>
            <input type="datetime-local" name="fecha" value="<?php echo date('Y-m-d\TH:i', strtotime($cotizacion_a_editar['fecha'])); ?>" required>
            <button type="submit" name="actualizar">Actualizar Cotización</button>
        </form>
    <?php } ?>
</body>
</html>

<?php 
require_once "vistas/parte_inferior.php";
?>
