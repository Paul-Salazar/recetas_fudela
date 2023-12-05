<?php
session_start();
if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 || $_SESSION['rol'] == 3) {
    include "../includes/header.php";
?>
    <div>
        <div class="card">
            <div class="card-header text-center h3 text-success">
                Acerca de
            </div>
            <label for="informacionSearch">Buscar:
                <input id="informacionSearch" type="text" placeholder="Buscar en acerca de..." oninput="buscarInformacion()">
            </label>
            <div class="card-body">
                <div class="row" width="100%">
                    <section class="contenido">
                        <h1 class="titulo">Acerca del Sistema De Recetas "Recetario Fudela" Version 1.0</h1>
                        <br>
                        <p> Recatario Fudela es un sistema administrativo de solicitudes de receta web, su funcion principal
                            es llevar una mejor gestion sobre las solicitudes de la FUNDACIÓN DE LAS AMERICAS que se tiene su sede en Quito, de esta manera se lleva un mejor control de la gestión recetas a travez de este sistema .
                        </p>
                    </section>
                    <section class="contenido">
                        <h2 class="titulo">Sobre el Desarrollador</h2>
                        <br>
                        <p>Desarrollado y mantenido por <a href="" target="_blank">Paul Salazar y Diego Castillo </a>.
                            Este sistema puede modificarlo segun a sus necesidades.

                            ¿Quiere tener un sistema con mejor funcionalidades? <a href="" target="_blank">Comuniquese con nosotros</a>.
                        </p>
                    </section>
                    <section class="contenido">
                        <h2 class="titulo">Colaboradores</h2>
                        <br>
                        <p><a href="">Mikaela Típan, Noemi </a>.
                            Este sistema puede modificarlo segun a sus necesidades.

                            ¿Quiere tener un sistema con mejor funcionalidades? <a href="" target="_blank">Comuniquese con nosotros</a>.
                        </p>
                    </section>
                    <section class="contenido">
                        <p><b class="titulo">NOTA:</b> Si tienes alguna duda del funcionamiento del sistema solo respondemos por <b>email</b> o <b>comentarios</b>Si mandas mensaje
                            a nuestro numero de <b>contacto</b> no respondemos dudas de instalacion, configuracion, etc, a menos que sean <b>propuestas de trabajo y cotizaciones.</b>
                    </section>
                </div>
            </div>

            <!-- Agregar la paginación -->
            <div class="col-12 mt-3">

            </div>
        </div>
    </div>

<?php include "../includes/footer.php";
} else {
    header('Location: permisos.php');
}
?>