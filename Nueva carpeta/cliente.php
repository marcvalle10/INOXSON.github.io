<?php 
require_once "vistas/parte_superior.php";
require_once 'CRUD/c_crud.php'; // Asegúrate de que la ruta sea correcta

// Crea una instancia de la clase Cliente
$cliente = new Cliente(); // Esta variable debe ser un objeto de la clase Cliente

// Manejo de la inserción
if (isset($_POST['crear'])) {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $requisitos_especificos = $_POST['requisitos_especificos']; // Campo opcional
    $usuario_id = $_POST['usuario_id'];

    if (!empty($nombre) && !empty($direccion) && !empty($usuario_id)) {
        if ($cliente->crearCliente($nombre, $direccion, $requisitos_especificos, $usuario_id)) {
            echo "<p>Cliente agregado con éxito.</p>";
        } else {
            echo "<p>Error al agregar el cliente.</p>";
        }
    } else {
        echo "<p>Por favor, llena todos los campos obligatorios.</p>";
    }
}

// Manejo de la actualización
if (isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $requisitos_especificos = $_POST['requisitos_especificos'];
    $usuario_id = $_POST['usuario_id'];

    if ($cliente->actualizarCliente($id, $nombre, $direccion, $requisitos_especificos, $usuario_id)) {
        echo "<p>Cliente actualizado con éxito.</p>";
    } else {
        echo "<p>Error al actualizar el cliente.</p>";
    }
}

// Manejo de la eliminación
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    if ($cliente->eliminarCliente($id)) {
        echo "<p>Cliente eliminado con éxito.</p>";
    } else {
        echo "<p>Error al eliminar el cliente.</p>";
    }
}

// Obtener y mostrar clientes
$clientes = $cliente->obtenerClientes();

$cliente_a_editar = null; // Inicializar la variable aquí

// Manejo de edición
if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $cliente_a_editar = $cliente->getClienteById($id); // Obtiene el cliente a editar
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes</title>
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
    <h1>Gestión de Clientes</h1>

    <!-- Formulario para agregar cliente -->
    <form method="POST" action="">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="direccion" placeholder="Dirección" required>
        <input type="text" name="requisitos_especificos" placeholder="Requisitos Específicos"> <!-- Campo opcional -->
        <input type="text" name="usuario_id" placeholder="ID Usuario" required>
        <button type="submit" name="crear">Agregar Cliente</button>
    </form>

    <h2>Lista de Clientes</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Requisitos Específicos</th>
                <th>ID Usuario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><?php echo $cliente['id']; ?></td>
                    <td><?php echo $cliente['nombre']; ?></td>
                    <td><?php echo $cliente['direccion']; ?></td>
                    <td><?php echo !empty($cliente['requisitos_especificos']) ? $cliente['requisitos_especificos'] : '-'; ?></td>
                    <td><?php echo $cliente['usuario_id']; ?></td>
                    <td>
                        <a href="?eliminar=<?php echo $cliente['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este cliente?')">Eliminar</a>
                        <a href="?editar=<?php echo $cliente['id']; ?>">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($cliente_a_editar): // Solo muestra el formulario de edición si hay un cliente a editar ?>
        <h2>Editar Cliente</h2>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $cliente_a_editar['id']; ?>">
            <input type="text" name="nombre" value="<?php echo $cliente_a_editar['nombre']; ?>" required>
            <input type="text" name="direccion" value="<?php echo $cliente_a_editar['direccion']; ?>" required>
            <input type="text" name="requisitos_especificos" value="<?php echo $cliente_a_editar['requisitos_especificos']; ?>"> <!-- Campo opcional -->
            <input type="text" name="usuario_id" value="<?php echo $cliente_a_editar['usuario_id']; ?>" required>
            <button type="submit" name="actualizar">Actualizar Cliente</button>
        </form>
    <?php endif; ?>
</body>
</html>

<?php 
require_once "vistas/parte_inferior.php";
?>
