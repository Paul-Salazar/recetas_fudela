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
if (isset($_FILES['ubicacion'])) {
    extract($_POST);
    $id = $_POST['iddocumento'];
    $nombre = $_POST['nombre'];
    $observaciones = $_POST['observaciones'];
    $fecha_creacion = date('Y-m-d');
    $estado = 1;
    

    // Definir la carpeta de destino
    $carpeta_destino = "../assets/docs/";

    // Obtener el nombre y la extensión del archivo
    $nombre_archivo = basename($_FILES["ubicacion"]["name"]);
    $extension = strtolower(pathinfo($nombre_archivo, PATHINFO_EXTENSION));

    // Validar la extensión del archivo
    if ($extension == "pdf" || $extension == "doc" || $extension == "docx") {
      

        // Mover el archivo a la carpeta de destino
        if (move_uploaded_file($_FILES["ubicacion"]["tmp_name"], $carpeta_destino . $nombre_archivo)) {
            // Insertar la información del archivo en la base de datos
            include "../conexion.php";
            $sql = "INSERT INTO documentos (nombre, observaciones, fecha_creacion, estado, ubicacion) VALUES ('$nombre', '$observaciones', '$fecha_creacion', '$estado', '$nombre_archivo')";
            $resultado = mysqli_query($conexion, $sql);
            if ($resultado) {
                echo "<script language='JavaScript'>
                location.assign('../vistas/documento.php');
                alert('Archivo Subido');
                
                </script>";
            } else {

                echo "<script language='JavaScript'>
                alert('Error al subir el archivo: ');
                location.assign('../vistas/documento.php');
                </script>";
            }
        } else {
            echo "<script language='JavaScript'>
            alert('Error al subir el archivo. ');
            location.assign('../vistas/documento.php');
            </script>";
        }
    } else {
        echo "<script language='JavaScript'>
        alert('Solo se permiten archivos PDF, DOC y DOCX.');
        location.assign('../vistas/documento.php');
        </script>";
    }
}

// llamado de la cabecera
include_once "../includes/header.php";
?>

<!-- Formulario de la Primera tabla -->
<div class="card">
    <div class="card-body">
        <h2>Agregar Documento</h2>
        <div class="card">
            <div class="card-body">
                <?php echo (isset($alert)) ? $alert : ''; ?>
                <form action="" method="post" autocomplete="off" id="formulario" enctype="multipart/form-data">
                    <input type="hidden" name="iddocumento" id="iddocumento">
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
                                <input type="text" placeholder="Breve Descripcion" name="observaciones"
                                    id="observaciones" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="ubicacion" class=" text-dark font-weight-bold">Agregar Documento</label>
                                <input type="file" class="form-control" name="ubicacion" id="ubicacion">
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
                <h2>Documentos</h2>
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
                                        <th>Fecha creación</th>
                                        <th>Estado</th>
                                        <th>Ubicación</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!--llamado a la base de datos y código php, cargado de vistas -->
                                    <?php
                                    include "../conexion.php";

                                    $query = mysqli_query($conexion, "SELECT * FROM documentos");
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
                                                <td><?php echo $data['iddocumento']; ?></td>
                                                <td><?php echo $data['nombre']; ?></td>
                                                <td><?php echo $data['observaciones']; ?></td>
                                                <td><?php echo $data['fecha_creacion']; ?></td>
                                                <td><?php echo $estado ?></td>
                                                <td><?php echo $data['ubicacion']; ?></td>
                                                
                                                <td>
                                                    <a class="btn btn-warning"
                                                        href="../includes/editar_documento.php?iddocumento=<?php echo $data['iddocumento'] ?>">
                                                        <i class="fa fa-edit "></i></a>

                                                    <form
                                                        action="../includes/eliminar/eliminar_documento.php?id=<?php echo $data['iddocumento']; ?>&accion=documento"
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