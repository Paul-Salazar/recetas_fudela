<?php
session_start();
if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 || $_SESSION['rol'] == 3) {
include "../includes/header.php";

$idsubcategoria = $_GET['id'];
?>

<div class="card">
    <div class="card-header text-center h3 text-success">
        Listas De Recetas
    </div>
    <label for="recetasSearch">Buscar:
    <input id="recetasSearch" type="text" placeholder="Buscar recetas">
    </label>
    <div class="card-body">
        <div class="row" width="100%">
            <?php
            include "../conexion.php";

            // Número de registros por página
            $registros_por_pagina = 4;

            // Página actual (por defecto es la primera página)
            $pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

            // Calcular el offset (inicio del conjunto de resultados para la página actual)
            $offset = ($pagina_actual - 1) * $registros_por_pagina;

            $query = mysqli_query($conexion, "SELECT * FROM recetas WHERE idsubcategoria = $idsubcategoria LIMIT $offset, $registros_por_pagina");
            $result = mysqli_num_rows($query);

            if ($result > 0) {
                while ($data = mysqli_fetch_assoc($query)) { ?>
                    <div class="col-md-3 shadow-lg receta-item">
                        <div class="col-12">
                        <!--<h6 class="my-3 text-center"><span class="badge badge-info"><php echo $data['imagen']; ?></span></h6>-->
                        <span class="badge badge-info"><?php
                                                    $imagenPath = $data['imagen'];
                                                    if (file_exists($imagenPath)) {
                                                        echo '<img src="' . $imagenPath . '" alt="Imagen de categoria" class="product-image" alt="Product Image" height="100px" width="240px">';
                                                    } else {
                                                        echo 'No Disponible';
                                                    }
                                                    ?></span></h6>
                        </div>
                        <!-- variable data más el nombre de la tabla categoría -->
                        <h6 class="my-3 text-center"><span class="badge badge-info"><?php echo $data['nombre']; ?></span></h6>

                        <div class="mt-4">
                            <!--se direcciona a ver lista llamado de la variable data id categorias  y cantidad de recetas llamando a la variable y a la conexion de la base de datos-->
                            <a class="btn btn-primary btn-block btn-flat" href="recetas_porciones.php?id=<?php echo $data['id']; ?>">
                                <i class="far fa-eye mr-2"></i>
                                Ver Recetas
                            </a>
                        </div>
                    </div>
                <?php }
            } ?>
        </div>

        <!-- Agregar la paginación -->
        <div class="col-12 mt-3">
            <?php
            $total_paginas = ceil($result / $registros_por_pagina);

            // Mostrar enlaces de paginación
            for ($i = 1; $i <= $total_paginas; $i++) {
                echo "<a href='index.php?pagina=$i' class='btn btn-info'>$i</a> ";
            }
            ?>
        </div>
    </div>
</div>

<?php include "../includes/footer.php";
} else {
    header('Location: permisos.php');
}
?>