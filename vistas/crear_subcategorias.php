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
    if (empty($_POST['idcategoria']) || empty($_POST['nombre']) || empty($_POST['estado']) || empty($_FILES['txtImagen']['name'])) {
        $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Todo los campos son obligatorios
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
    } else {
        $id = $_POST['id'];
        $idcategoria = $_POST['idcategoria'];
        $nombre = $_POST['nombre'];
        $observaciones = $_POST['observaciones'];
        $estado = $_POST['estado'];
        $imagen_temp = $_FILES['txtImagen']['tmp_name'];
        $fecha_creacion = date('Y-m-d');

        $result = 0;
        if (empty($id)) {
            $query = mysqli_query($conexion, "SELECT * FROM subcategorias WHERE nombre = '$nombre' AND estado = 1");
            $result = mysqli_fetch_array($query);
            if ($result > 0) {
                $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        La categoría ya existe
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
            } else {
                $imagenSubcategoria = "../assets/img/subcategorias/" . $_FILES['txtImagen']['name'];
                move_uploaded_file($imagen_temp, $imagenSubcategoria);
                $query_insert = mysqli_query($conexion, "INSERT INTO subcategorias (idcategoria, nombre, observaciones, estado, imagen, fecha_creacion) VALUES ('$idcategoria', '$nombre', '$observaciones', '$estado', '$imagenSubcategoria', '$fecha_creacion')");
                if ($query_insert) {
                    $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        SubCategoría registrada
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
        <h2>Agregar SubCategorías</h2>
        <div class="card">
            <div class="card-body">
                <?php echo (isset($alert)) ? $alert : ''; ?>
                <form action="" method="post" autocomplete="off" id="formulario" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <!-- Primera caja de texto -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nombre" class="text-dark font-weight-bold">Nombre Subcategoría</label>
                                <input type="text" placeholder="Ingrese Nombre Subcategoría" name="nombre" id="nombre" class="form-control">
                            </div>
                        </div>
                        <!-- Segunda caja de texto -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="observaciones" class="text-dark font-weight-bold">Observaciones</label>
                                <input type="text" placeholder="Breve Descripción" name="observaciones" id="observaciones" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group ">
                                <label for="idcategoria" class="text-dark font-weight-bold">Categoría principal</label>
                                <select class="form-control" id="idcategoria" name="idcategoria">
                                    <option value="">- Seleccionar -</option>
                                    <?php
                                    include "../conexion.php";
                                    $sql = "SELECT id, nombre FROM categorias WHERE estado = 1";
                                    $resultado = mysqli_query($conexion, $sql);
                                    while ($consulta = mysqli_fetch_array($resultado)) {
                                        echo '<option value="' . $consulta['id'] . '">' . $consulta['nombre'] . '</option>';
                                    }
                                    mysqli_close($conexion);
                                    ?>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="estado" class=" text-dark font-weight-bold">Estado</label>
                                <select class="form-control" name="estado" id="estado">
                                    <option value="1">Activada</option>
                                    <option value="0">Desactivada</option>
                                </select>
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
                <h2>SubCategorías</h2>
                <!-- Formulario de la segunda tabla-->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="tbl">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre Categoría</th>
                                        <th>Nombre</th>
                                        <th>observaciones</th>
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

                                    $query = mysqli_query($conexion, "SELECT subcategorias.*, categorias.nombre as nombrecategoria FROM subcategorias
                                    INNER JOIN categorias ON subcategorias.idcategoria = categorias.id");
                                    $result = mysqli_num_rows($query);
                                    if ($result > 0) {
                                        while ($data = mysqli_fetch_assoc($query)) { 
                                            if ($data['estado'] == 0) {
                                                $estado = '<span class="badge badge-danger">Desactivado</span>';
                                            } else if ($data['estado'] == 1) {
                                                $estado = '<span class="badge badge-info">Activado</span>';
                                            } ?>
                                            <tr>
                                                
                                                <td><?php echo $data['id']; ?></td>
                                                <td><?php echo $data['nombrecategoria']; ?></td>
                                                <td><?php echo $data['nombre']; ?></td>
                                                <td><?php echo $data['observaciones']; ?></td>
                                                <td><?php echo $estado; ?></td>
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
                                                    <a class="btn btn-warning" href="../includes/editar_subcategorias.php?id=<?php echo $data['id']; ?>">
                                                        <i class="fa fa-edit "></i></a>

                                                    <form action="../includes/eliminar/eliminar_subcategorias.php?id=<?php echo $data['id']; ?>&accion=crear_subcategorias" method="post" class="confirmar d-inline">
                                                        <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i> </button>
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