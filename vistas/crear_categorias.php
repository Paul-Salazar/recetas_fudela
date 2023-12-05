<?php
// Inicio de Sesión más el rol de usuario
session_start();
if ($_SESSION['rol'] != 1) {
    header('Location: permisos.php');
    exit;
}

// conexión
include "../conexion.php";

// Alertas y condiciones para los campos de la primera tabla
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nombre']) || empty($_POST['observaciones']) || empty($_FILES['txtImagen']['name'])) {
        $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Todo los campos son obligatorios
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
    } else {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $observaciones = $_POST['observaciones'];
        $estado = 1;
        $fecha_creacion = date('Y-m-d');
        $imagen_temp = $_FILES['txtImagen']['tmp_name'];

        $result = 0;
        if (empty($id)) {
            $query = mysqli_query($conexion, "SELECT * FROM categorias WHERE nombre = '$nombre' AND estado = 1");
            $result = mysqli_fetch_array($query);
            if ($result > 0) {
                $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        La categoría ya existe
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            } else {
                $imagenReceta = "../assets/img/categorias/" . $_FILES['txtImagen']['name'];
                move_uploaded_file($imagen_temp, $imagenReceta);
                $query_insert = mysqli_query($conexion, "INSERT INTO categorias (nombre, observaciones, estado, imagen, fecha_creacion) VALUES ('$nombre', '$observaciones', '$estado', '$imagenReceta', '$fecha_creacion')");
                if ($query_insert) {
                    $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Categoría registrada
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                } else {
                    $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Error al registrar
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                }
            }
        } else {
            // Utilizar la consulta si quieres editar desde crear categorias
            $sql_update = mysqli_query($conexion, "UPDATE categorias SET nombre = '$nombre', observaciones = '$observaciones' WHERE id = $id");
            if ($sql_update) {
                $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Categoría modificada
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            } else {
                $alert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Error al modificar
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            }
        }
    }
    mysqli_close($conexion);
}

// llamado de la cabecera
include_once "../includes/header.php";
?>

<!-- Formulario de la Primera tabla -->
<div class="card">
    <div class="card-body">
        <h2>Agregar Categorías</h2>
        <div class="card">
            <div class="card-body">
                <?php echo (isset($alert)) ? $alert : ''; ?>
                <form action="" method="post" autocomplete="off" id="formulario" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <!-- Primera caja de texto -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nombre" class="text-dark font-weight-bold">Nombre</label>
                                <input type="text" placeholder="Ingrese Nombre" name="nombre" id="nombre"
                                    class="form-control">
                            </div>
                        </div>
                        <!-- Segunda caja de texto -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="observaciones" class="text-dark font-weight-bold">Descripción</label>
                                <input type="text" placeholder="Ingrese Descripcion" name="observaciones"
                                    id="observaciones" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="txtImagen" class=" text-dark font-weight-bold">Imagen</label>
                                <input type="file" class="form-control" name="txtImagen" id="txtImagen">
                            </div>
                        </div>
                        <!-- Botones de acción -->
                        <div class="col-md-3 text-center">
                            <label for="">Acciones</label> <br>
                            <input type="submit" value="Registrar" class="btn btn-primary" id="btnAccion">
                            <button class="btn btn-info" id="btnNuevo" onclick="limpiar()"><img src="https://cdn-icons-png.flaticon.com/512/838/838461.png" alt="icono" width="20" height="20"></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-------------Formulario de editar la Primera tabla----------------------->
        <div class="card">
            <div class="card-body">
                <h2>Categorías</h2>
                <!-- Formulario de la segunda tabla-->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="tbl">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Observaciones</th>
                                        <th>Estado</th>
                                        <th>Imagen</th>
                                        <th>Fecha de Creación</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!--llamado a la base de datos y código php, cargado de vistas -->
                                    <?php
                                    include "../conexion.php";

                                    $query = mysqli_query($conexion, "SELECT * FROM categorias");
                                    $result = mysqli_num_rows($query);
                                    if ($result > 0) {
                                        while ($data = mysqli_fetch_assoc($query)) { 
                                            if ($data['estado'] == 1) {
                                                $estado = '<span class="badge badge-success">Activada</span>';
                                            } else {
                                                $estado = '<span class="badge badge-info">Desactivada</span>';
                                            } 
                                            ?>             
                                            <tr>
                                                <td><?php echo $data['id']; ?></td>
                                                <td><?php echo $data['nombre']; ?></td>
                                                <td><?php echo $data['observaciones']; ?></td>
                                                <td><?php echo $estado ?></td>
                                                <td>
                                                    <?php
                                                    $imagenPath = $data['imagen'];
                                                    if (file_exists($imagenPath)) {
                                                        echo '<img src="' . $imagenPath . '" alt="Imagen de categoria" height="90px" width="120px">';
                                                    } else {
                                                        echo 'No Disponible';
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $data['fecha_creacion']; ?></td>
                                                <td>
                                                    <a class="btn btn-warning"
                                                        href="../includes/editar_categorias.php?id=<?php echo $data['id'] ?>">
                                                        <i class="fa fa-edit "></i></a>

                                                    <form
                                                        action="../includes/eliminar/eliminar_categorias.php?id=<?php echo $data['id']; ?>&accion=crear_categorias"
                                                        method="post" class="confirmar d-inline">
                                                        <button class="btn btn-danger" type="submit"><i
                                                                class='fas fa-trash-alt'></i> </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once "../includes/footer.php"; ?>