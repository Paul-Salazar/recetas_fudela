<?php
// Inicio de Sesión más el rol de usuario
session_start();
if ($_SESSION['rol'] != 1) {
    header('Location: permisos.php');
    exit;
}

$idreceta = $_GET['id'];
// conexión
include "../conexion.php";

// Alertas y condiciones para los campos de la primera tabla
if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nombre']) || empty($_POST['cantidad_recetas']) || empty($_FILES['txtImagen']['name'])) {
        $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Todo los campos son obligatorios
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
    } else {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $cantidad_recetas = $_POST['cantidad_recetas'];
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
                $query_insert = mysqli_query($conexion, "INSERT INTO categorias (nombre, cantidad_recetas, imagen) VALUES ('$nombre', '$cantidad_recetas', '$imagenReceta')");
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
            // Corregir la consulta para actualizar la categoría en lugar de la tabla de salas
            $sql_update = mysqli_query($conexion, "UPDATE categorias SET nombre = '$nombre', cantidad_recetas = '$cantidad_recetas' WHERE id = $id");
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
        <h2>Porciones y cantidades</h2>
        <div class="card">
            <div class="card-body">
                <?php echo (isset($alert)) ? $alert : '';

                include "../conexion.php";

                $query = mysqli_query($conexion, "SELECT * FROM recetas WHERE id = $idreceta");
                $result = mysqli_num_rows($query);

                ?>
                <form action="" method="post" autocomplete="off" id="formulario" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <!-- Primera caja de texto -->
                        <input type="hidden" value=''>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nombre" class="text-dark font-weight-bold">Nombre</label>
                                <input type="text" placeholder="Ingrese Nombre" name="nombre" id="nombre" class="form-control">
                            </div>
                        </div>
                        <!-- Segunda caja de texto -->
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="nombre" class="text-dark font-weight-bold">Descripción</label>
                                <input type="text" placeholder="Ingrese Descripcion" name="cantidad_recetas" id="cantidad_recetas" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="nombre" class="text-dark font-weight-bold">Ingredientes</label>
                                <div id="ingredientesContainer">
                                    <div class="row ingredientes">
                                        <strong class="numIngrediente">#1</strong>
                                        <!-- Campo de Cantidad -->
                                        <div class="col-md-3">
                                            <label for="cantidad">Cantidad</label>
                                            <input type="number" name="cantidad" class="form-control">
                                        </div>

                                        <!-- Campo de Unidad de Medida -->
                                        <div class="col-md-3">
                                            <label for="unidad_medida">Unidad medida</label>
                                            <select name="unidad_medida" class="form-control">
                                                <option value="gramos">Gramos</option>
                                                <option value="mililitros">Mililitros</option>
                                                <!-- Agrega más opciones según tus necesidades -->
                                            </select>
                                        </div>

                                        <!-- Campo de Ingrediente -->
                                        <div class="col-md-4">
                                            <label for="ingrediente">Ingrediente</label>
                                            <input type="text" name="ingrediente" class="form-control">
                                        </div>

                                        <!-- Botones de Acciones -->
                                        <div class="col-md-2">
                                            <label for="">Acciones</label>
                                            <div class="row">
                                                <button class="btn btn-primary mr-2" type="button" onclick="agregarIngrediente()"><i class="fa fa-plus"></i></button>
                                                <button class="btn btn-danger" type="button" style="display:none;" onclick="eliminarIngrediente(this)"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="text-dark font-weight-bold">Pasos</label>
                                <div id="pasosContainer">
                                    <div class="input-group">
                                        <input type="text" name="paso" class="form-control">
                                        <div class="input-group-append">
                                            <!-- Agrega pasos a la opción, llamando al script -->
                                            <button class="btn btn-primary" type="button" onclick="agregarPaso()"><i class="fa fa-plus"></i></button>
                                            <!-- Elimina pasos a la opción, llamando al script -->
                                            <button class="btn btn-danger" type="button" style="display:none;" onclick="eliminarPaso(this)"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </div>
                                    <div class="mt-3"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <div class="form-group">
                                <label for="txtImagen" class="text-dark font-weight-bold">Imagen</label>
                                <div class="col-md-12 text-center">
                                    <img src="../assets/img/recetas/ceviche.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <!-- Botones de acción -->
                        <div class="col-md-12 text-center">
                            <label for="">Acciones</label> <br>
                            <input type="submit" value="Guardar receta" class="btn btn-primary" id="btnAccion">
                        </div>
                    </div>
                </form>
                <?php

                mysqli_close($conexion);
                ?>
            </div>
        </div>
        <!-------------Formulario de editar la Primera tabla----------------------->
        <div class="card">
            <div class="card-body">
                <h2>Ver porciones y cantidades por receta</h2>
                <!-- Formulario de la segunda tabla-->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="tbl">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Descripcion</th>
                                        <th>Imagen</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!--llamado a la base de datos y código php, cargado de vistas -->
                                    <?php
                                    include "../conexion.php";

                                    $query = mysqli_query($conexion, "SELECT * FROM categorias WHERE estado = 1");
                                    $result = mysqli_num_rows($query);
                                    if ($result > 0) {
                                        while ($data = mysqli_fetch_assoc($query)) { ?>
                                            <tr>
                                                <td>
                                                    <?php echo $data['id']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $data['nombre']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $data['cantidad_recetas']; ?>
                                                </td>
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
                                                <td>
                                                    <a class="btn btn-warning" href="../includes/editar_categorias.php?id=<?php echo $data['id'] ?>">
                                                        <i class="fa fa-edit "></i></a>

                                                    <form action="../includes/eliminar/eliminar_categorias.php?id=<?php echo $data['id']; ?>&accion=crear_categorias" method="post" class="confirmar d-inline">
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