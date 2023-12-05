<?php
if (empty($_SESSION['active'])) {
    header('Location: ../');
    
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de recetas</title>

    <!-- Fuentes de google -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Fuentes de Fontawesome -->
    <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
    <!-- Iconos IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Estilos -->
    <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="icon" href="../img/logoicono.ico">
    <link rel="stylesheet" href="../assets/css/estilos_index.css">
    <link rel="stylesheet" href="../assets/css/header_estilos.css">
    <script src="../js/jquery.min.js"></script>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!------------------------------ Navbar superior horizontal ----------------------------------->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Izquierda navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <form class=" d-sm-inline-block form-inline mr-5 ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div>
                    <img src="" alt="" width="" height="">
                        <a href="" class="h3">Bienvenidos al Sistema Fudela</a>
                    </div>
                        
                    </form>

           
            <!-- Derecha navbar links -->
            <ul class="navbar-nav ml-auto">

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
        

        <!---------------------- Navbar deslizable Container vertical ------------------------->
        <aside class="main-sidebar sidebar-dark-blue elevation-4">
            <!-- navbar Logo -->
            <a href="index.php" class="brand-link">
                <img src="../assets/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-1" style="opacity: .8">
                <span class="brand-text font-weight-white">Recetario Fudela</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- navusuario panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <i class="fas fa-user-astronaut fa-2x text-info"></i>
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Bienvenido <?php echo $_SESSION['nombre']; ?></a>
                    </div>
                </div>
                <!-- Divisor, o separador -->
            <hr class="sidebar-divider">

                <!-- Barra lateral Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Ver Recetas
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 || $_SESSION['rol'] == 3) {
                                    echo '<li class="nav-item">
                                        <a href="../vistas/index.php" class="nav-link">
                                            <i class="fa fa-list nav-icon"></i>
                                            <p>Lista de recetas</p>
                                        </a>
                                    </li>';
                                } if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
                                    echo '<li class="nav-item">
                                        <a href="../vistas/lista_ventas.php" class="nav-link">
                                            <i class="fa fa-list nav-icon"></i>
                                            <p>Historial recetas</p>
                                        </a>
                                    </li>';
                                } ?>
                            </ul>

                        </li>

                        <?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
                            echo '<li class="nav-item">
                                <a href="../vistas/crear_recetas.php" class="nav-link">
                                    <i class="nav-icon fas fa-coffee"></i>
                                    <p>
                                        Crear Recetas
                                    </p>
                                </a>
                            </li>';

                        } if ($_SESSION['rol'] == 1) {
                            echo ' <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-clipboard"></i>
                                <p>
                                    Categorías
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="../vistas/crear_categorias.php" class="nav-link">
                                        <i class="fa fa-list nav-icon"></i>
                                        <p>Lista Categorías</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../vistas/crear_subcategorias.php" class="nav-link">
                                        <i class="fa fa-list nav-icon"></i>
                                        <p>Lista Subcategoría</p>
                                    </a>
                                </li>
                            </ul>
                        </li>';
                        

                        }
                        if ($_SESSION['rol'] == 1) {
                            echo '<li class="nav-item">
                                <a href="../vistas/documento.php" class="nav-link">
                                    <i class="nav-icon fas fa-file-contract"></i>
                                    <p>
                                        Crear Documento
                                    </p>
                                </a>
                            </li>'; 
                        }if ($_SESSION['rol'] == 1) {
                            echo '
                            
                            <!-- Divisor, o separador -->
                            <hr class="sidebar-divider">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-user-cog"></i>
                                    <p>
                                        Ajustes
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="../vistas/usuarios.php" class="nav-link">
                                            <i class="fa fa-list nav-icon"></i>
                                            <p>Usuarios</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="../vistas/configuracion.php" class="nav-link">
                                            <i class="fa fa-list nav-icon"></i>
                                            <p>Configuración</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>';
                        } if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 || $_SESSION['rol'] == 3) {
                            echo '<li class="nav-item">
                                <a href="../vistas/ayuda.php" class="nav-link">
                                    <i class="fa fa-question nav-icon"></i>
                                    <p>Ayuda</p>
                                </a>
                            </li>'; 
                        } if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 || $_SESSION['rol'] == 3) {
                            echo '<li class="nav-item">
                                <a href="../vistas/acerca.php" class="nav-link">
                                    <i class="fa fa-info nav-icon"></i>
                                    <p>Acerca de</p>
                                </a>
                            </li>'; 
                        }?> 



                        <li class="nav-item">
                            
                            <a href="" class="nav-link" data-toggle="modal" data-target="#logoutModal" >
                                <i class="nav-icon fas fa-power-off"></i>
                                <p>
                                    Salir
                                </p>
                            </a>
                            
                        </li>

                    </ul>
                </nav>
                <!-- /.Barra lateral-menu -->
            </div>
            <!-- /.Barra lateral -->
        </aside>

        <!-- Contenedor. Contenedor de paáginas -->
        <div class="content-wrapper">
        
            <!-- Menú de contenido -->
            <div class="content">
            <?php  //cierre final;
                ?>

                <?php include "../vistas/cierre_sesion.php"; ?>
                <div class="container-fluid py-2">



                <script src="../js/reloj.js"></script>