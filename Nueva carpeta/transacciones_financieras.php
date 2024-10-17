<?php 
require_once "vistas/parte_superior.php";
require_once 'CRUD/t_crud.php'; // Asegúrate de que la ruta sea correcta

$transaccion = new C_Transaccion();

// Manejo de la inserción
if (isset($_POST['crear'])) {
    $cliente_id = $_POST['cliente_id'];
    $usuario_id = $_POST['usuario_id'];
    $tipo_transaccion = $_POST['tipo_transaccion'];
    $monto = $_POST['monto'];
    $fecha = $_POST['fecha'];

    if (!empty($cliente_id) && !empty($usuario_id) && !empty($tipo_transaccion) && !empty($monto) && !empty($fecha)) {
        if ($transaccion->crearTransaccion($cliente_id, $usuario_id, $tipo_transaccion, $monto, $fecha)) {
            echo "<p>Transacción agregada con éxito.</p>";
        } else {
            echo "<p>Error al agregar la transacción.</p>";
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
    $tipo_transaccion = $_POST['tipo_transaccion'];
    $monto = $_POST['monto'];
    $fecha = $_POST['fecha'];

    if ($transaccion->actualizarTransaccion($id, $cliente_id, $usuario_id, $tipo_transaccion, $monto, $fecha)) {
        echo "<p>Transacción actualizada con éxito.</p>";
    } else {
        echo "<p>Error al actualizar la transacción.</p>";
    }
}

// Manejo de la eliminación
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    if ($transaccion->eliminarTransaccion($id)) {
        echo "<p>Transacción eliminada con éxito.</p>";
    } else {
        echo "<p>Error al eliminar la transacción.</p>";
    }
}

// Obtener y mostrar transacciones
$transacciones = $transaccion->obtenerTransacciones();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transacciones Financieras</title>
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
    <h1>Gestión de Transacciones Financieras</h1>

    <!-- Formulario para agregar transacción -->
    <form method="POST" action="">
        <input type="text" name="cliente_id" placeholder="ID Cliente" required>
        <input type="text" name="usuario_id" placeholder="ID Usuario" required>
        <input type="text" name="tipo_transaccion" placeholder="Tipo de Transacción" required>
        <input type="number" name="monto" placeholder="Monto" step="0.01" required>
        <input type="datetime-local" name="fecha" required>
        <button type="submit" name="crear">Agregar Transacción</button>
    </form>

    <h2>Lista de Transacciones Financieras</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Cliente</th>
                <th>ID Usuario</th>
                <th>Tipo de Transacción</th>
                <th>Monto</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transacciones as $trans): ?>
                <tr>
                    <td><?php echo $trans['id']; ?></td>
                    <td><?php echo $trans['cliente_id']; ?></td>
                    <td><?php echo $trans['usuario_id']; ?></td>
                    <td><?php echo $trans['tipo_transaccion']; ?></td>
                    <td><?php echo $trans['monto']; ?></td>
                    <td><?php echo $trans['fecha']; ?></td>
                    <td>
                        <a href="?eliminar=<?php echo $trans['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar esta transacción?')">Eliminar</a>
                        <a href="?editar=<?php echo $trans['id']; ?>">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
    // Manejo de edición
    if (isset($_GET['editar'])) {
        $id = $_GET['editar'];
        $transaccion_a_editar = $transaccion->obtenerTransaccionPorId($id);
    ?>
        <h2>Editar Transacción</h2>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $transaccion_a_editar['id']; ?>">
            <input type="text" name="cliente_id" value="<?php echo $transaccion_a_editar['cliente_id']; ?>" required>
            <input type="text" name="usuario_id" value="<?php echo $transaccion_a_editar['usuario_id']; ?>" required>
            <input type="text" name="tipo_transaccion" value="<?php echo $transaccion_a_editar['tipo_transaccion']; ?>" required>
            <input type="number" name="monto" value="<?php echo $transaccion_a_editar['monto']; ?>" step="0.01" required>
            <input type="datetime-local" name="fecha" value="<?php echo date('Y-m-d\TH:i', strtotime($transaccion_a_editar['fecha'])); ?>" required>
            <button type="submit" name="actualizar">Actualizar Transacción</button>
        </form>
    <?php } ?>
</body>
</html>

<?php 
require_once "vistas/parte_inferior.php";
?>
