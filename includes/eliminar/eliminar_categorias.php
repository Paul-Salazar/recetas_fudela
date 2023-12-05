<?php
session_start();
if ($_SESSION['rol'] != 1) {
    header('Location: permisos.php');
    exit;
}
require("../../conexion.php");
if (empty($_SESSION['idUser'])) {
    header('Location: ../');
}
if (!empty($_GET['id']) && !empty($_GET['accion'])) {
    $id = $_GET['id'];
    $table = $_GET['accion'];
    $id_user = $_SESSION['idUser'];
    $query = mysqli_query($conexion,"DELETE FROM categorias WHERE id = '$id'");
    mysqli_close($conexion);
    header("Location: ../../vistas/crear_categorias.php");
}
