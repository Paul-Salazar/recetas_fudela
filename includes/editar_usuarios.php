<?php
session_start();
if ($_SESSION['rol'] != 1) {
    header('Location: permisos.php');
    exit;
}

$id = $_GET['id'];
require_once "../conexion.php";
if ($_POST) {
    $alert = '';
    if (empty($_POST['txtNombre']) || empty($_POST['txtCorreo']) || empty($_POST['txtRol']) || empty($_POST['txtPass'])) {
        $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Todo los campos son obligatorios
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';
    } else {
        $nombre = $_POST['txtNombre'];
        $correo = $_POST['txtCorreo'];
        $rol = $_POST['txtRol'];
        $pass = md5($_POST['txtPass']);
        $id = $_POST['txtId'];
        $update = mysqli_query($conexion, "UPDATE usuarios SET nombre = '$nombre', correo = '$correo', rol = '$rol', pass = '$pass'  WHERE id = $id");
        if ($update) {
            /*$alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Datos Actualizado
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>';*/
            header('Location: ../vistas/usuarios.php');
            exit;
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

$query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id = $id");
$data = mysqli_fetch_assoc($query);

include_once "../includes/header.php";
?>

<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Datos De Usuario</h4>
            </div>
            <div class="card-body">
                <?php echo isset($alert) ? $alert : ''; ?>
                <form action="" method="post" class="p-3">
                    <input type="hidden" name="txtId" class="form-control" value="<?php echo $data['id']; ?>" id="txtId" placeholder="Ingrese Nombre" class="form-control">
                    <div class="form-group">
                        <label>Nombre:</label>
                        <input type="text" name="txtNombre" class="form-control" value="<?php echo $data['nombre']; ?>" id="txtNombre" placeholder="Ingrese Nombre" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Correo:</label>
                        <input type="email" name="txtCorreo" class="form-control" value="<?php echo $data['correo']; ?>" id="txtCorreo" placeholder="Ingrese correo Electrónico" required>
                    </div>

                    <div class="form-group">
                        <label for="rol">Rol</label>
                        <select id="txtRol" class="form-control" name="txtRol" value="<?php echo $data['rol']; ?>">
                            <option>Seleccionar</option>
                            <option value="1">Administrador</option>
                            <option value="2">Emprendedor</option>
                            <option value="3">Invitado</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Contraseña:</label>
                        <input type="password" name="txtPass" class="form-control" value="<?php echo $data['pass']; ?>" id="txtPass" placeholder="Ingrese Contraseña" required>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>Editar Usuario</button>
                        <a href="../vistas/usuarios.php" class="btn btn-danger">Cancelar</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once "../includes/footer.php"; ?>