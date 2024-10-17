<?php 
require_once "vistas/parte_superior.php";
require_once 'CRUD/f_crud.php'; // Asegúrate de que la ruta sea correcta

$factura = new Factura(); // Asegúrate de que estás utilizando la clase correcta

// Manejo de la inserción
if (isset($_POST['crear'])) {
    $cliente_id = $_POST['cliente_id'];
    $fecha_emision = $_POST['fecha_emision'];
    $monto = $_POST['monto'];
    $metodo_pago = $_POST['metodo_pago'];

    if (!empty($cliente_id) && !empty($fecha_emision) && !empty($monto) && !empty($metodo_pago)) {
        if ($factura->crearFactura($cliente_id, $fecha_emision, $monto, $metodo_pago)) {
            echo "<p>Factura agregada con éxito.</p>";
        } else {
            echo "<p>Error al agregar la factura.</p>";
        }
    } else {
        echo "<p>Por favor, llena todos los campos.</p>";
    }
}

// Manejo de la actualización
if (isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $cliente_id = $_POST['cliente_id'];
    $fecha_emision = $_POST['fecha_emision'];
    $monto = $_POST['monto'];
    $metodo_pago = $_POST['metodo_pago'];

    if ($factura->actualizarFacturaPorId($id, $cliente_id, $fecha_emision, $monto, $metodo_pago)) {
        echo "<p>Factura actualizada con éxito.</p>";
    } else {
        echo "<p>Error al actualizar la factura.</p>";
    }
}

// Manejo de la eliminación
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    if ($factura->eliminarFacturaPorId($id)) {
        echo "<p>Factura eliminada con éxito.</p>";
    } else {
        echo "<p>Error al eliminar la factura.</p>";
    }
}

// Obtener y mostrar facturas
$facturas = $factura->getFacturas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Facturas</title>
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
    <h1>Gestión de Facturas</h1>

    <!-- Formulario para agregar factura -->
    <form method="POST" action="">
        <input type="text" name="cliente_id" placeholder="ID Cliente" required>
        <input type="datetime-local" name="fecha_emision" required>
        <input type="number" name="monto" placeholder="Monto" step="0.01" required>
        <input type="text" name="metodo_pago" placeholder="Método de Pago" required>
        <button type="submit" name="crear">Agregar Factura</button>
    </form>

    <h2>Lista de Facturas</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Cliente</th>
                <th>Fecha de Emisión</th>
                <th>Monto</th>
                <th>Método de Pago</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($facturas as $fact): ?>
                <tr>
                    <td><?php echo $fact['id']; ?></td>
                    <td><?php echo $fact['cliente_id']; ?></td>
                    <td><?php echo $fact['fecha_emision']; ?></td>
                    <td><?php echo $fact['monto']; ?></td>
                    <td><?php echo $fact['metodo_pago']; ?></td>
                    <td>
                        <a href="?eliminar=<?php echo $fact['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar esta factura?')">Eliminar</a>
                        <a href="?editar=<?php echo $fact['id']; ?>">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
    // Manejo de edición
    if (isset($_GET['editar'])) {
        $id = $_GET['editar'];
        $factura_a_editar = $factura->obtenerFacturaPorId($id);
    ?>
        <h2>Editar Factura</h2>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $factura_a_editar['id']; ?>">
            <input type="text" name="cliente_id" value="<?php echo $factura_a_editar['cliente_id']; ?>" required>
            <input type="datetime-local" name="fecha_emision" value="<?php echo date('Y-m-d\TH:i', strtotime($factura_a_editar['fecha_emision'])); ?>" required>
            <input type="number" name="monto" value="<?php echo $factura_a_editar['monto']; ?>" step="0.01" required>
            <input type="text" name="metodo_pago" value="<?php echo $factura_a_editar['metodo_pago']; ?>" required>
            <button type="submit" name="actualizar">Actualizar Factura</button>
        </form>
    <?php } ?>
</body>
</html>

<?php 
require_once "vistas/parte_inferior.php";
?>
