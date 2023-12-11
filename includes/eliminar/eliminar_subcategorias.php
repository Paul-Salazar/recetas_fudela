<?php
session_start();
if ($_SESSION['rol'] != 1) {
    header('Location: permisos.php');
    exit;
}

require("../../conexion.php");

if (empty($_SESSION['idUser'])) {
    header('Location: ../');
    exit;
}

if (!empty($_GET['id']) && !empty($_GET['accion'])) {
    $id = $_GET['id'];
    $table = $_GET['accion'];
    $id_user = $_SESSION['idUser'];

    // Obtener la información de la imagen desde la base de datos
    $query_imagen = mysqli_query($conexion, "SELECT imagen FROM subcategorias WHERE id = '$id'");
    // Genera el arreglo de la fila en la tabla subcategorias
    $data_imagen = mysqli_fetch_assoc($query_imagen);
    // Agregamos otra capa al directorio raíz para que las imagenes se eliminen
    $imagenPath = "../" . $data_imagen['imagen'];
    // Utilizamos el método unlink para borrar la imagen de la carpeta de subcategorias
    unlink($imagenPath);
    // Se borra todo el registro pasando el id 
    $query_delete = mysqli_query($conexion, "DELETE FROM subcategorias WHERE id = '$id'");
    // Cerramos la conexión
    mysqli_close($conexion);
    // Ingresamos de nuevo a crear_subcategorias.php
    header("Location: ../../vistas/crear_subcategorias.php");
    // Finalizamos el documento eliminar_subcategorias.php
    exit;
    
}
