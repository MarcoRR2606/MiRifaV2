<?php
session_start();
include('conexion.php'); // Conexión a la base de datos

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener las credenciales ingresadas
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Consultar la base de datos
    $sql = "SELECT * FROM usuarios WHERE usuario = ? AND contrasena = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $usuario, $contrasena);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Verificar si existe el usuario
    if ($resultado->num_rows > 0) {
        // Obtener los datos del usuario
        $usuario_db = $resultado->fetch_assoc();

        // Verificar si el rol es 'jefe'
        if ($usuario_db['rol'] == 'jefe') {
            $_SESSION['usuario'] = $usuario_db['usuario']; // Guardar el nombre de usuario en la sesión
            $_SESSION['rol'] = $usuario_db['rol']; // Guardar el rol en la sesión
            header("Location: dashboard.php"); // Redirigir a la página del jefe
            exit();
        } else {
            $error = "No tienes permisos para acceder.";
        }
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Jefe</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* Estilos Generales */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        header {
            text-align: center;
            margin-bottom: 30px;
        }

        h1 {
            color: #003366;
            font-size: 32px;
            font-weight: bold;
        }

        /* Formulario de login */
        .login-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        label {
            font-size: 16px;
            color: #333;
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 16px;
            color: #333;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #003366;
            outline: none;
        }

        button {
            background-color: #003366;
            color: #fff;
            border: none;
            padding: 12px;
            width: 100%;
            font-size: 18px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #ffcc00;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 15px;
        }

        .login-container a {
            color: #003366;
            text-decoration: none;
            font-size: 14px;
            display: block;
            text-align: center;
            margin-top: 15px;
        }

        .login-container a:hover {
            color: #ffcc00;
        }
    </style>
</head>
<body>

    <main>
        <div class="login-container">
            <form action="login.php" method="POST">
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario" required>

                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" required>

                <button type="submit">Iniciar sesión</button>
            </form>

            <?php
            // Mostrar errores si existen
            if (isset($error)) {
                echo "<p class='error'>$error</p>";
            }
            ?>
        </div>
    </main>

</body>
</html>
