<?php 
require 'db_connection.php';

class Auth {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function login($username, $password) {
        $sql = "SELECT id, password_hash, rol_id FROM usuarios WHERE username = :username";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->bindParam(':username', $username);   
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $row['password_hash'])) {
                return $row; // Devolver los datos del usuario si el login es exitoso
            } else {
                return false; // Contraseña incorrecta
            }
        } else {
            return false; // Usuario no encontrado
        }
    }

    public function __destruct() {
        $this->db->closeConnection();
    }
}


// Manejo del login
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $auth = new Auth();
    $user = $auth->login($username, $password);

    if ($user) {
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['rol_id'] = $user['rol_id']; // Guardar rol si es necesario
        
        // Redirigir según el rol
        if ($user['rol_id'] == 1) {
            header("Location: http://localhost/inoxson/dashboard/index.php");
        } elseif (in_array($user['rol_id'], [2, 3, 4])) {
            header("Location: http://localhost/inoxson/dashboard/Empleados/index.php");
        } else {
            header("Location: http://localhost/inoxson/login.php?error=1");
        }
        exit();
    } else {
        // En caso de error, redirigir al login con un mensaje
        header("Location: http://localhost/inoxson/login.php?error=1");
        exit();
    }
}
?>

<!doctype html>
<html>
    <head>
        <link rel="shortcut icon" href="#" />
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Login - INOXSON</title>

        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="estilos.css">
        <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">
        <link rel="stylesheet" type="text/css" href="fuentes/iconic/css/material-design-iconic-font.min.css">
    </head>
    
    <body>
        <div class="container-login">
            <div class="wrap-login">
                <form class="login-form validate-form" id="formLogin" action="" method="post">
                    <span class="login-form-title">Bienvenidos a INOXSON</span>

                    <div class="wrap-input100" data-validate="Usuario incorrecto">
                        <input class="input100" type="text" id="username" name="username" placeholder="Usuario">
                        <span class="focus-efecto"></span>
                    </div>

                    <div class="wrap-input100" data-validate="Password incorrecto">
                        <input class="input100" type="password" id="password" name="password" placeholder="Password">
                        <span class="focus-efecto"></span>
                    </div>

                    <div class="container-login-form-btn">
                        <div class="wrap-login-form-btn">
                            <div class="login-form-bgbtn"></div>
                            <button type="submit" name="submit" class="login-form-btn">CONECTAR</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <script src="jquery/jquery-3.3.1.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="popper/popper.min.js"></script>
        <script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
        
    </body>
</html>