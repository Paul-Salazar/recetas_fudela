<?php
session_start();

// Si ya existe una sesión activa, redirige al usuario a la carpeta 'vistas/'
if (!empty($_SESSION['active'])) {
    header('location: vistas/');
} else {
    // Si se ha enviado un formulario por método POST
    if (!empty($_POST)) {
        $alert = '';
        // Verifica que los campos de correo y contraseña no estén vacíos
        if (empty($_POST['correo']) || empty($_POST['pass'])) {
            $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Ingrese correo y contraseña
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        } else {
            // Incluye el archivo de conexión a la base de datos
            require_once "conexion.php";
            
            // Escapa los valores del formulario para prevenir inyección SQL
            $user = mysqli_real_escape_string($conexion, $_POST['correo']);
            $pass = md5(mysqli_real_escape_string($conexion, $_POST['pass']));

            // Expresión regular para validar el formato del correo electrónico
            if (!preg_match('/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{3,4}$/', $user)) {
                $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            El formato del correo electrónico no es válido.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
            } else {
                // Realiza la consulta en la base de datos
                $query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo = '$user' AND pass = '$pass'");
                mysqli_close($conexion);

                // Obtiene el número de filas afectadas por la consulta
                $resultado = mysqli_num_rows($query);

                // Si se encontró un usuario válido
                if ($resultado > 0) {
                    $dato = mysqli_fetch_array($query);
                    $_SESSION['active'] = true;
                    $_SESSION['idUser'] = $dato['id'];
                    $_SESSION['nombre'] = $dato['nombre'];
                    $_SESSION['rol'] = $dato['rol'];
                    header('Location: vistas/index.php');
                } else {
                    // Mensaje de error y destrucción de la sesión en caso de contraseña incorrecta
                    $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Contraseña incorrecta
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
                    session_destroy();
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="assets/css/login.css">

    <style>
       
        .login-box .login-logo img {
            width: 200px;
            height: 150px;
            border-radius: 20px;
            border: 2px solid purple; /* Cambiado a morado */
        }
    </style>

</head>
<body class="fondo hold-transition login-page" style="background-color: #D2B4DE ;">
    <div class="login-box">
        <div class="login-logo">                                 
            <marquee><h1>Fundación De Las Americas.</h1></marquee>           
            <hr>
            <img src="https://static.vecteezy.com/system/resources/previews/023/439/985/non_2x/single-continuous-line-drawing-handsome-husband-holding-pan-lid-and-his-beautiful-wife-tasting-food-using-cooking-spoon-cooking-together-in-kitchen-one-line-draw-graphic-design-illustration-vector.jpg">
            <hr>
            <a href="#"><h2><b>Sistema De Recetas.</b></h2></a>
            <hr>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg"><h5><center>Iniciar Sesión.</center></h5></p>
                <form action="" method="post" autocomplete="off">
                    <?php echo (isset($alert)) ? $alert : ''; ?>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="correo" placeholder="correo">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="pass" placeholder="Contraseña">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Iniciar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/dist/js/adminlte.min.js"></script>
</body>
</html>
