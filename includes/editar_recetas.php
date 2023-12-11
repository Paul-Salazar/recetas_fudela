<?php
session_start();
if ($_SESSION['rol'] != 1) {
    header('Location: permisos.php');
    exit;
}

$id = $_GET['id'];
require_once "../conexion.php";
// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $id = $_POST['txtId'];
    $idsubcategoria = $_POST['txtidsubcategoria'];
    $nombre = $_POST['txtNombre'];
    $Observaciones = $_POST['txtObservaciones'];
    $fecha = $_POST['txtFecha'];
    $estado = $_POST['txtEstado'];
    $imagenActual = $_POST['txtImagenActual'];

    // Manejar la carga de la nueva imagen si se proporciona
    if ($_FILES['txtImagen']['error'] == UPLOAD_ERR_OK && !empty($_FILES['txtImagen']['name'])) {

        // Obtener la información de la imagen desde la base de datos
        $query_imagen = mysqli_query($conexion, "SELECT imagen FROM recetas WHERE id = '$id'");
        // Genera el arreglo de la fila en la tabla platos
        $data_imagen = mysqli_fetch_assoc($query_imagen);
        // Agregamos otra capa al directorio raíz para que las imagenes se eliminen
        // MODIFICAAMOS CUANDO SE CREE LA CARPETA EDITAR DENTRO DE INCLUDES
        // $imagenPath = "../" . $data_imagen['imagen'];
        $imagenPath = $data_imagen['imagen'];
        // Utilizamos el método unlink para borrar la imagen de la carpeta de recetas
        unlink($imagenPath);

        // Mover la nueva imagen
        $imagen_temp = $_FILES['txtImagen']['tmp_name'];
        $imagen = "../assets/img/recetas/" . $_FILES['txtImagen']['name'];
        move_uploaded_file($imagen_temp, $imagen);
    } else {
        $imagen = $imagenActual;
    }

    // Validar y sanitizar los datos según sea necesario
    // Actualizar la base de datos con los valores obtenidos del formulario
    $query = "UPDATE recetas SET nombre = '$nombre', idsubcategoria = '$idsubcategoria', observaciones = '$Observaciones', imagen = '$imagen', fecha = '$fecha', estado = '$estado' WHERE id = $id";

    if (mysqli_query($conexion, $query)) {
        // La actualización fue exitosa, puedes redirigir a una página de éxito o realizar otras acciones
        header('Location: ../vistas/crear_recetas.php');
        exit;
    } else {
        // Hubo un error en la actualización, puedes mostrar un mensaje de error o redirigir a una página de error
        $alert = "Error al actualizar la categoría: " . mysqli_error($conexion);
    }
}

$query = mysqli_query($conexion, "SELECT * FROM recetas WHERE id = $id");
$data = mysqli_fetch_assoc($query);

include_once "../includes/header.php";
?>

<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Editar recetas</h4>
            </div>
            <div class="card-body">
                <?php echo isset($alert) ? $alert : ''; ?>
                <form action="../includes/editar_recetas.php" method="POST" class="p-1" enctype="multipart/form-data">
                    <input type="hidden" name="txtId" value="<?php echo $data['id'] ?>">
                    <!-- Editar la subcategoría, hace una consulta para traer las subcategorias de la tabla -->
                    <div class="form-group ">
                        <label for="txtidsubcategoria" class="text-dark font-weight-bold">SubCategoría</label>
                        <select class="form-control" id="txtidsubcategoria" name="txtidsubcategoria">
                            <?php
                            $sql = "SELECT id, nombre FROM subcategorias WHERE estado = 1";
                            $resultado = mysqli_query($conexion, $sql);
                            while ($consulta = mysqli_fetch_array($resultado)) {
                                $selected = ($consulta['id'] == $data['id']) ? 'selected' : '';
                                echo '<option value="' . $consulta['id'] . '" ' . $selected . '>' . $consulta['nombre'] . '</option>';
                            }
                            ?>

                        </select>
                    </div>
                    <!-- Editar el nombre de la receta -->
                    <div class="form-group">
                        <label>Nombre:</label>
                        <input type="text" name="txtNombre" class="form-control" value="<?php echo $data['nombre']; ?>" id="txtNombre" placeholder="nombre" required>
                    </div>
                    <!-- Editar las observaciones -->
                    <div class="form-group">
                        <label>Observaciones:</label>
                        <input type="text" name="txtObservaciones" class="form-control" value="<?php echo $data['observaciones']; ?>" id="txtObservaciones" placeholder="Observaciones" required>
                    </div>
                    <!-- Editar la imagen, que se muestre la imagen anterior -->
                    <div class="form-group">
                        <label>Imagen:</label>
                        <br>
                        <?php
                        $imagenPath = $data['imagen'];
                        if (file_exists($imagenPath)) {
                            echo '<img src="' . $imagenPath . '" alt="Imagen de receta" height="250px" class="btn-block" id="previewImagen">';
                        } else {
                            echo '<img src="../assets/img/vacio.jpg" alt="Imagen de receta" height="250px" class="btn-block" id="previewImagen">';
                            echo 'Imagen no disponible';
                        }
                        ?>
                        <!-- Se agrega este input oculto para obtener la imagen actual enlazada a la base de datos -->
                        <input type="hidden" name="txtImagenActual" id="txtImagenActual" value="<?php echo $data['imagen']; ?>">
                        <!-- Cambia de enlace al input para abrir la imagen -->
                        <a href="#" class="btn btn-primary btn-block" onclick="abrirImagenAgregar()">Modificar</a>
                        <!-- Se agrega un input de tipo archivo oculto con el atributo accept -->
                        <input type="file" class="form-control" name="txtImagen" id="txtImagenInput" style="display: none" accept=".jpg, .jpeg, .png" onchange="mostrarPreview()">
                    </div>
                    <!-- Agregar la fecha con su hora -->
                    <div class="form-group">
                        <label for="txtFecha" class="control-label">Fecha:</label>
                        <input type="datetime-local" class="form-control" name="txtFecha" value="<?php echo isset($data['fecha']) ? date("Y-m-d\TH:i", strtotime($data['fecha'])) : "" ?>" required>
                    </div>
                    <!-- Modificar el estado -->
                    <div class="form-group">
                        <label for="estado" class=" text-dark font-weight-bold">Estado</label>
                        <select class="form-control" name="txtEstado" id="txtEstado">
                            <option value="1">Activada</option>
                            <option value="0">Desactivada</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>Editar</button>
                        <a href="../vistas/crear_recetas.php" class="btn btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function abrirImagenAgregar() {
        // Función para abrir el cuadro de diálogo de selección de archivo
        document.getElementById('txtImagenInput').click();
    }
    /* Código para cargar la previsualización de la imagen */
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

</script>
<?php include_once "../includes/footer.php"; ?>