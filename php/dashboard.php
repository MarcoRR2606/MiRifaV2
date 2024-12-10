<?php
session_start();

// Verificar si el usuario está logueado y tiene el rol de "jefe"
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'jefe') {
    header("Location: login.php"); // Redirigir si no está logueado como jefe
    exit();
}

// Cerrar sesión si el botón es presionado
if (isset($_POST['logout'])) {
    session_unset(); // Elimina todas las variables de sesión
    session_destroy(); // Destruye la sesión
    header("Location: ../index.html"); // Redirige al index.html en el directorio raíz
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control del Jefe</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #ff7e5f, #feb47b); /* Fondo cálido */
            color: #fff;
            text-align: center;
        }
        header {
            background: #34495e;
            color: white;
            padding: 30px 0;
            margin-bottom: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        header h1 {
            margin: 0;
            font-size: 36px;
            font-weight: 700;
        }
        .container {
            margin: 20px auto;
            padding: 40px;
            background: #fff;
            border-radius: 15px;
            width: 80%;
            max-width: 650px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            color: #333;
        }
        .welcome-msg {
            font-size: 26px;
            margin-bottom: 20px;
            color: #34495e;
        }
        .btn {
            background-color: #3498db;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 18px;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #2980b9;
        }
        .logout-btn {
            background-color: #e74c3c;
            padding: 15px 30px;
        }
        .logout-btn:hover {
            background-color: #c0392b;
        }
        .button-container {
            margin-top: 30px;
        }
        footer {
            margin-top: 50px;
            font-size: 14px;
            color: #bbb;
        }
    </style>
</head>
<body>

<header>
    <h1>Panel de Control del Jefe</h1>
</header>

<div class="container">
    <h2 class="welcome-msg">Bienvenido, <?php echo $_SESSION['usuario']; ?>.</h2>

    <p>Como jefe, tienes acceso a la gestión de rifas y a la lista de compradores.</p>

    <!-- Botón para acceder a la lista de compradores -->
    <a href="lista_n.php">
        <button class="btn">Ver lista de compradores</button>
    </a>

    <!-- Botón de cerrar sesión -->
    <form method="post" class="button-container">
        <button type="submit" name="logout" class="logout-btn">Cerrar sesión</button>
    </form>
</div>

<footer>
    <p>&copy; 2024 MiRifa V2. Todos los derechos reservados.</p>
</footer>

</body>
</html>
