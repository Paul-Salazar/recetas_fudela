<?php
session_start();
if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
    include "../conexion.php";
    if (!empty($_POST)) {
        $alert = "";
        $recetas = $_POST['txtRecetas'];
        $observaciones = $_POST['txtObservaciones'];
        $idsubcategoria = $_POST['txtidsubcategoria'];

        // Validar si se ha seleccionado una imagen
        if (!empty($_FILES['txtImagen']['name'])) {
            $imagen_temp = $_FILES['txtImagen']['tmp_name'];
            $imagenReceta = "../assets/img/recetas/" . $_FILES['txtImagen']['name'];

            // Obtener la extensión de la imagen
            $extension = pathinfo($imagenReceta, PATHINFO_EXTENSION);

            // Verificar si la extensión es jpg, jpeg o png
            if (!in_array(strtolower($extension), array("jpg", "jpeg", "png"))) {
                $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            Solo se permiten archivos con extensiones JPG, JPEG y PNG
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
            } else {
                // Mover el archivo solo si se ha seleccionado uno válido
                move_uploaded_file($imagen_temp, $imagenReceta);

                $fecha = date('Y-m-d H:i:s');
                // Revisa si todos los campos están llenos
                if (empty($recetas) || empty($observaciones) || $observaciones < 0 || empty($idsubcategoria)) {
                    $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            Todos los campos son obligatorios
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
                } else {
                    // Si se trata de recargar para forzar el ingreso de un id nuevo hace una consulta a la base de datos y envía un mensaje de error
                    if (empty($id)) {
                        $query = mysqli_query($conexion, "SELECT * FROM recetas WHERE nombre = '$recetas' AND estado = 1");
                        $result = mysqli_fetch_array($query);
                        if ($result > 0) {
                            $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            ¡La receta ya existe!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                        } else {
                            // Ingresa una nueva receta
                            $query_insert = mysqli_query($conexion, "INSERT INTO recetas (idsubcategoria,nombre,observaciones,imagen,fecha,estado) VALUES ('$idsubcategoria', '$recetas', '$observaciones', '$imagenReceta', '$fecha', '1')");
                            if ($query_insert) {
                                $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            Receta registrada con éxito
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>';
                            } else {
                            // Mostrar un mensaje de error
                                $alert = '<div class="alert alert-danger" role="alert">
                            Error al registrar la receta
                            </div>';
                            }
                        }
                    }
                }
            }
        } else {
            // Mostrar mensaje si no se selecciona una imagen
            $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        No has seleccionado una imagen
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
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
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="txtRecetas" class=" text-dark font-weight-bold">Recetas</label>
                                            <input type="text" placeholder="Nombre de la receta" name="txtRecetas" id="txtRecetas" class="form-control">
                                        </div>
                                    </div>
                                    <ul class="col-md-3">
                                        <div><label>Observaciones:</label>
                                            <textarea cols="auto" rows="1" placeholder="Ingrese Descripción" class="form-control" name="txtObservaciones" id="txtObservaciones"></textarea>
                                        </div>
                                    </ul>
                                    <div class="form-group col-md-3">
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
                                    <div class="form-group col-md-2">
                                        <label for="txtImagen" class="text-dark font-weight-bold">Agregar Imagen</label>
                                        <br>
                                        <!-- Previsualizar la imagen que se sube 
                                        <img src="../assets/img/vacio.jpg" alt="Foto de receta temporal" height="150px" class="btn-block" id="previewImagen">
                                        -->

                                        <!-- Cambia de enlace al input para abrir la imagen -->

                                        <!-- Cambiado a enlace -->

                                        <a href="#" class="btn btn-primary btn-block" onclick="abrirImagenAgregar()">Seleccionar</a>
                                        <!-- Se agrega un input de tipo archivo oculto con el atributo accept -->
                                        <input type="file" class="form-control" name="txtImagen" id="txtImagenInput" style="display: none" accept=".jpg, .jpeg, .png" onchange="mostrarPreview()">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="">Acciones</label> <br>
                                        <input type="submit" value="Registrar" class="btn btn-primary" id="btnAccion">
                                        <input type="button" value="Nuevo" onclick="limpiar()" class="btn btn-success" id="btnNuevo">
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h2>Recetas</h2>
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
                                                <td><?php echo $data['id']; ?></td>
                                                <td><?php echo $data['nombre_subcategoria']; ?></td>
                                                <td><?php echo $data['nombre']; ?></td>
                                                <td><?php echo $data['observaciones']; ?></td>
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
                                                <td><?php echo $data['fecha']; ?></td>
                                                <td><?php echo $estado; ?></td>
                                                <td>
                                                    <a class="btn btn-warning" href="../includes/editar_recetas.php?id=<?php echo $data['id']; ?>">
                                                        <i class="fa fa-edit "></i></a>
                                                    <form action="../includes/eliminar/eliminar_recetas.php?id=<?php echo $data['id']; ?>&accion=crear_recetas" method="post" class="confirmar d-inline">
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
    <script>
        function abrirImagenAgregar() {
            // Función para abrir el cuadro de diálogo de selección de archivo
            document.getElementById('txtImagenInput').click();
        }

        /* Código para cargar la previsualización de la imagen
        function mostrarPreview() {
            // Función para mostrar la previsualización de la imagen seleccionada
            var input = document.getElementById('txtImagenInput');
            var preview = document.getElementById('previewImagen');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        */
    </script>
<?php include_once "../includes/footer.php";
} else {
    header('Location: permisos.php');
}
?>