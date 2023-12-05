<?php
session_start();
if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
    include "../conexion.php";
    if (!empty($_POST)) {
        $alert = "";
        $recetas = $_POST['txtRecetas'];
        $observaciones = $_POST['txtObservaciones'];
        $idsubcategoria = $_POST['txtidsubcategoria'];
        $imagen_temp = $_FILES['txtImagen']['tmp_name'];
        $imagenReceta = "../assets/img/recetas/" . $_FILES['txtImagen']['name'];
        move_uploaded_file($imagen_temp, $imagenReceta);

        $fecha = date('Y-m-d H:i:s');
        if (empty($recetas) || empty($observaciones) || $observaciones < 0) {
            $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Todo los campos son obligatorios
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
        } else {
            if (empty($id)) {
                $query = mysqli_query($conexion, "SELECT * FROM recetas WHERE nombre = '$recetas' AND estado = 1");
                $result = mysqli_fetch_array($query);
                if ($result > 0) {
                    $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        la receta ya existe
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                } else {
                    $query_insert = mysqli_query($conexion, "INSERT INTO recetas (idsubcategoria,nombre,observaciones,imagen,fecha,estado) VALUES ('$idsubcategoria', '$recetas', '$observaciones', '$imagenReceta', '$fecha', '1')");
                    if ($query_insert) {


                        $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        recetas registrada
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
                    } else {
                        $alert = '<div class="alert alert-danger" role="alert">
                    Error al registrar la receta
                  </div>';
                    }
                }
            }

        }
    }
    include_once "../includes/header.php";
    ?>
    <div class="card shadow-lg">
        <div class="card-body">
            <h2>Agregar Recetas</h2>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post" autocomplete="off" id="formulario" enctype="multipart/form-data">
                                <?php echo isset($alert) ? $alert : ''; ?>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="txtRecetas" class=" text-dark font-weight-bold">Recetas</label>
                                            <input type="text" placeholder="Nombre de la receta" name="txtRecetas"
                                                id="txtRecetas" class="form-control">
                                        </div>
                                    </div>
                                    <ul class="col-md-5">
                                        <div><label>Observaciones:</label>
                                            <textarea cols="auto" rows="1" placeholder="Ingrese Descripción"
                                                class="form-control" name="txtObservaciones"
                                                id="txtObservaciones"></textarea>
                                        </div>
                                    </ul>
                                    <div class="form-group ">
                                        <label>Subcategoria</label>
                                        <select class="form-control" id="txtidsubcategoria" name="txtidsubcategoria">
                                            <option value="">--Selecciona una opcion--</option>
                                            <?php

                                            include("conexion.php");
                                            //Codigo para mostrar categorias desde otra tabla
                                        
                                            $sql = "SELECT * FROM subcategorias";
                                            $resultado = mysqli_query($conexion, $sql);
                                            while ($consulta = mysqli_fetch_array($resultado)) {
                                                echo '<option value="' . $consulta['id'] . '">' . $consulta['nombre'] . '</option>';
                                            }

                                            ?>


                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="txtImagen" class=" text-dark font-weight-bold"> Agregar
                                                Imagen</label>
                                            <input type="file" class="form-control" name="txtImagen" id="txtImagen">
                                        </div>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="">Acciones</label> <br>
                                        <input type="submit" value="Registrar" class="btn btn-primary" id="btnAccion">
                                        <input type="button" value="Nuevo" onclick="limpiar()" class="btn btn-success"
                                            id="btnNuevo">
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="tbl">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre Subategoría</th>
                                        <th>Nombre</th>
                                        <th>observaciones</th>
                                        <th>Imagen</th>
                                        <th>Fecha de Creación</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include "../conexion.php";
                                    $query = mysqli_query($conexion, "SELECT recetas.*, subcategorias.nombre as nombre_subcategoria FROM recetas
                                    INNER JOIN subcategorias ON recetas.idsubcategoria = subcategorias.id");
                                    $result = mysqli_num_rows($query);
                                    if ($result > 0) {
                                        while ($data = mysqli_fetch_assoc($query)) {
                                            if ($data['estado'] == 0) {
                                                $estado = '<span class="badge badge-success">Desactivado</span>';
                                            } else if ($data['estado'] == 1) {
                                                $estado = '<span class="badge badge-info">Activado</span>';
                                            }
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $data['id']; ?>
                                                </td>
                                                <td>
                                                <?php echo $data['nombre_subcategoria']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $data['nombre']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $data['observaciones']; ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $imagenPath = $data['imagen'];
                                                    if (file_exists($imagenPath)) {
                                                        echo '<img src="' . $imagenPath . '" alt="Imagen de receta" height="90px" width="120px">';
                                                    } else {
                                                        echo 'No Disponible';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php echo $data['fecha']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $estado; ?>
                                                </td>
                                                <td>
                                                    <a class="btn btn-warning"
                                                        href="../includes/editar_recetas.php?id=<?php echo $data['id']; ?>">
                                                        <i class="fa fa-edit "></i></a>

                                                    <form
                                                        action="../includes/eliminar/eliminar_recetas.php?id=<?php echo $data['id']; ?>&accion=crear_recetas"
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
    <?php include_once "../includes/footer.php";
} else {
    header('Location: permisos.php');
}
?>