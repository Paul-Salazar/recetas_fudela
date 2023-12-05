</div>
<!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<!-- Main Footer -->
<footer class="main-footer">
  <center><strong>&copy; 2023 <a href="#">Estudiantes TecnoEcuatoriano</a>.</strong>
    Todos los Derechos Reservados.
    <div class="float-right d-none d-sm-inline-block">
        <b></b> </center>  
    </div>
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIERE SCRIPTS -->

<!-- jQuery -->
<script src="../assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="../assets/dist/js/adminlte.min.js"></script>

<script src="../assets/plugins/chart.js/Chart.min.js"></script>

<!-- SCRIPTS OPCIONALES -->
<script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

<script src="../assets/js/sweetalert2.all.min.js"></script>
<script src="../assets/js/funciones.js"></script>
</body>

<script>
    $(document).ready(function () {
        $("#recetasSearch").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $(".receta-item").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
<!-- búsqueda de ayuda y acerca-->
<script>
    function buscarInformacion() {
        // Obtener el término de búsqueda y quitar las tildes
        var searchTerm = removeAccents(document.getElementById("informacionSearch").value.toLowerCase());

        // Filtrar secciones según el término de búsqueda
        var sections = document.querySelectorAll(".contenido");

        sections.forEach(function(section) {
            var articleTitle = removeAccents(section.querySelector(".titulo").textContent.toLowerCase());
            var sectionContent = removeAccents(section.textContent.toLowerCase());

            if (searchTerm === "" || articleTitle.includes(searchTerm) || sectionContent.includes(searchTerm)) {
                section.style.display = "block";
            } else {
                section.style.display = "none";
            }
        });

        // Mostrar los resultados
        displayResults();
    }

    // Función para quitar tildes de una cadena
    function removeAccents(str) {
        return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
    }
</script>

</html>