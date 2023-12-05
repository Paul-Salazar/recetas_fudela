<?php
session_start();
if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2 || $_SESSION['rol'] == 3) {
    include "../includes/header.php";
?>

    <div class="card">
        <div class="card-header text-center h3 text-success">
            Ayuda
        </div>
        <label for="informacionSearch">Buscar:
            <input id="informacionSearch" type="text" placeholder="Buscar en ayuda..." oninput="buscarInformacion()">
        </label>
        <div class="card-body">

            <!-- Secciones de los artículos -->
            <section class="contenido">
                <h2 class="titulo">¿Cómo utilizar el sistema?</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sit perspiciatis expedita reprehenderit mollitia corporis recusandae eveniet, iste tenetur accusantium, porro similique, asperiores numquam tempora corrupti nostrum? Unde voluptates eaque pariatur reprehenderit magnam ex similique veniam, consequatur, ullam perferendis, blanditiis earum quo aperiam eligendi accusamus in impedit libero voluptatibus? Neque, accusantium officia veniam magnam perspiciatis in adipisci fugit. Impedit earum sed quis sint veniam ea eum error ab exercitationem fugiat. Est modi et odio earum rerum facere voluptatum! Voluptates harum maxime porro nobis, incidunt hic voluptatum obcaecati quia animi dignissimos, ratione facere, nihil odio ut ipsum id consequatur quisquam iusto repellat.</p>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/xcJtL7QggTI?si=AuyuUL2NgLS6kRJR" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </section>

            <section class="contenido">
                <h2 class="titulo">Interface de cada Rol</h2>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Vitae quas veritatis doloremque et recusandae placeat animi explicabo perferendis iste delectus laborum, eos nobis? Nihil soluta perspiciatis omnis iusto non quis, magni molestiae adipisci vel voluptates! Eaque at dolores, excepturi quia, similique ea nam ut illum beatae iste nihil dolor, nesciunt repudiandae quasi aspernatur iure dignissimos? Perferendis iusto, possimus quibusdam, cumque nemo eos ad odio sed quidem doloremque dolore vitae illo iste iure placeat. Quaerat dolor maxime a eaque quo fugit dolorum ipsum et, commodi placeat velit eum hic doloremque unde modi cumque eius non similique. Quas placeat ullam id repudiandae.</p>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/mkggXE5e2yk?si=f4oOVaRs5Lxhu70j" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </section>

            <section class="contenido">
                <h2 class="titulo">Agregar, modificar y eliminar receta</h2>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Iste, atque. Repudiandae maiores totam quidem, quia tenetur explicabo modi perferendis doloribus, maxime quos quisquam illo ut est quaerat omnis expedita sint harum ratione ullam ipsum ad ducimus! Nulla sit, sed pariatur fugiat soluta iste, esse quis temporibus aliquam nesciunt suscipit accusamus repudiandae dolorem quibusdam nam enim odio commodi odit! Dolore, fugiat! Aliquid quo perspiciatis modi odit hic, odio molestiae dolores ratione amet, sed quos? Numquam in animi iure velit labore dignissimos rerum ut pariatur esse fuga ex molestiae quia eum, asperiores corrupti itaque, adipisci quam magni amet! Eaque et numquam adipisci!</p>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/xcJtL7QggTI?si=AuyuUL2NgLS6kRJR" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </section>

            <section class="contenido">
                <h2 class="titulo">Agregar, modificar y eliminar categoría</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe delectus nihil quia molestias in, optio, sunt facilis nulla neque molestiae consequuntur! In velit ex impedit aliquid, voluptates harum reiciendis nobis provident, doloremque repellendus eius. Expedita quidem natus labore commodi, at facilis maxime ipsam repudiandae consequatur porro explicabo deleniti possimus necessitatibus cum numquam, sapiente adipisci facere molestiae. Esse corrupti odit beatae in rerum maiores reprehenderit asperiores, aspernatur culpa ipsum nobis. Mollitia laboriosam molestias, repellendus, consequuntur veritatis, recusandae ullam ipsa sit quae cum odit? Ad distinctio iure eum eaque aperiam quaerat doloremque accusamus porro, dolorum quia, reprehenderit perferendis nobis aliquid voluptas deserunt.</p>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/mkggXE5e2yk?si=f4oOVaRs5Lxhu70j" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </section>

            <section class="contenido">
                <h2 class="titulo">Visualizar documentación</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia sequi magnam totam quibusdam minima non quae porro suscipit, officiis blanditiis natus sapiente sit autem odio sunt odit. Explicabo et aspernatur, nisi vero non molestiae facilis ut in ab eum rerum repellat a labore necessitatibus eaque dicta saepe deserunt quasi libero aperiam porro! Iure repellat veniam ullam modi error officiis accusamus rem laudantium dolore. Ipsa, quis. Dolorum dolores, dolor adipisci in, rerum officiis distinctio optio at porro libero exercitationem itaque nulla asperiores magni facere autem impedit provident pariatur perferendis amet qui ab. Neque eos quas fugiat cupiditate deserunt. Omnis, repudiandae illum!</p>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/xcJtL7QggTI?si=AuyuUL2NgLS6kRJR" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </section>

            <section class="contenido">
                <h2 class="titulo">Agenda</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima deserunt est in voluptatem. Minima assumenda quaerat id asperiores quisquam officiis, nulla ipsum quos nesciunt reprehenderit fugiat ad praesentium modi sed ducimus accusantium corporis nostrum temporibus aut non pariatur nam? Atque, cupiditate? Vero ipsam ratione odio voluptatum, natus perspiciatis nostrum aperiam. Earum, placeat aspernatur. Ullam sed facere eius pariatur illum aspernatur numquam quasi totam a autem repellat quae architecto illo minima, quos similique error neque molestias esse, praesentium tenetur magni ad fuga. Ullam sit qui architecto laboriosam obcaecati fuga veniam voluptatem voluptas facilis alias, eius tenetur sint laudantium autem sequi! Voluptate.</p>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/mkggXE5e2yk?si=f4oOVaRs5Lxhu70j" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </section>

        </div>

        <!-- Agregar la paginación <div class="col-12 mt-3"></div> -->
    </div>

<?php include "../includes/footer.php";
} else {
    header('Location: permisos.php');
}
?>