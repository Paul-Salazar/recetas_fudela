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
    $idcategoria = $_POST['txtIdCategoria'];
    $nombre = $_POST['txtNombre'];
    $observaciones = $_POST['txtObservaciones'];
    $estado = $_POST['txtEstado'];
    $imagenActual = $_POST['txtImagenActual'];

    // Manejar la carga de la nueva imagen si se proporciona
    if ($_FILES['txtImagen']['error'] == UPLOAD_ERR_OK && !empty($_FILES['txtImagen']['name'])) {

        // Obtener la información de la imagen desde la base de datos
        $query_imagen = mysqli_query($conexion, "SELECT imagen FROM subcategorias WHERE id = '$id'");
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
        $imagen = "../assets/img/subcategorias/" . $_FILES['txtImagen']['name'];
        move_uploaded_file($imagen_temp, $imagen);
    } else {
        $imagen = $imagenActual;
    }

    // Validar y sanitizar los datos según sea necesario

    // Actualizar la base de datos con los valores obtenidos del formulario
    $query = "UPDATE subcategorias SET idcategoria = '$idcategoria', nombre = '$nombre', observaciones = '$observaciones', estado = '$estado', imagen = '$imagen' WHERE id = $id";

    if (mysqli_query($conexion, $query)) {
        // La actualización fue exitosa, puedes redirigir a una página de éxito o realizar otras acciones
        header('Location: ../vistas/crear_subcategorias.php');
        exit;
    } else {
        // Hubo un error en la actualización, puedes mostrar un mensaje de error o redirigir a una página de error
        $alert = "Error al actualizar la subcategoría: " . mysqli_error($conexion);
    }
}

$query = mysqli_query($conexion, "SELECT * FROM subcategorias WHERE id = $id");
$data = mysqli_fetch_assoc($query);

include_once "../includes/header.php";
?>

<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Editar subcategorias</h4>
            </div>
            <div class="card-body">
                <?php echo isset($alert) ? $alert : ''; ?>
                <form action="../includes/editar_subcategorias.php" method="POST" class="p-1" enctype="multipart/form-data">
                    <input type="hidden" name="txtId" value="<?php echo $data['id'] ?>">
                    <div class="form-group">
                        <label>Nombre:</label>
                        <input type="text" name="txtNombre" class="form-control" value="<?php echo $data['nombre']; ?>" id="txtNombre" placeholder="nombre" required>
                    </div>
                    <div class="form-group">
                        <label>Observaciones:</label>
                        <input type="text" name="txtObservaciones" class="form-control" value="<?php echo $data['observaciones']; ?>" id="txtObservaciones" placeholder="Observaciones">
                    </div>
                    <div class="form-group ">
                        <label for="txtIdCategoria" class="text-dark font-weight-bold">Categoría principal</label>
                        <select class="form-control" id="txtIdCategoria" name="txtIdCategoria">
                            <?php
                            $sql = "SELECT id, nombre FROM categorias WHERE estado = 1";
                            $resultado = mysqli_query($conexion, $sql);
                            while ($consulta = mysqli_fetch_array($resultado)) {
                                $selected = ($consulta['id'] == $data['id']) ? 'selected' : '';
                                echo '<option value="' . $consulta['id'] . '" ' . $selected . '>' . $consulta['nombre'] . '</option>';
                            }
                            ?>

                        </select>
                    </div>
                    <div class="form-group ">
                        <label for="txtEstado" class="text-dark font-weight-bold">Estado</label>
                        <select class="form-control" id="txtEstado" name="txtEstado">
                            <option value="1">Activada</option>
                            <option value="0">Desactivada</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Imagen:</label>
                        <?php
                        $imagenPath = $data['imagen'];
                        if (file_exists($imagenPath)) {
                            echo '<img src="' . $imagenPath . '" alt="Imagen de receta" height="210px" width="308px">';
                        } else {
                            echo 'No Disponible';
                        }
                        ?>
                        <!-- Se agrega este input oculto para obtener la imagen actual enlazada a la base de datos -->
                        <input type="hidden" name="txtImagenActual" id="txtImagenActual" value="<?php echo $data['imagen']; ?>">
                        <!--<input type="text" class="form-control" name="txtImagen" id="txtImagen" value="<?php // echo $data['imagen']; 
                                                                                                            ?>">-->
                        <input type="file" class="form-control" name="txtImagen" id="txtImagen">
                    </div>

                    <!-- Agregar la fecha con su hora -->

                    <div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>Editar</button>
                        <a href="../vistas/crear_subcategorias.php" class="btn btn-danger">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once "../includes/footer.php"; ?>