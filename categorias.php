<?php
include "conexion.php";

    $consulta = "SELECT * FROM categorias";

    $resultadoConsulta = mysqli_query($conn, $consulta);

    // Cerrar la conexión cuando hayas terminado
    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Control de stock</title>
</head>

<body>
    <!--Aqui va el header con el buscador-->
    <header class="header">
        <div class="header-barra">
            <input type="text" placeholder="Buscar:">
        </div>
    </header>



    <!--Aqui va el contenedor de la barra lateral y contenido principal -->
    <main class="main">

        <!--Aqui va el navegador de la pagina con las secciones que tiene-->
        <nav class="navegacion">
            <div class="navContenedor">
                <a href="categorias.php">Categorias</a>

                <a href="productos.php">Productos</a>

                <a href="seguimiento.php">Seguimiento</a>

                <a href="registro.php">Registro</a>
            </div>
        </nav>

        <!--Aqui va el contenido principal de la pagina -->
        <section>
            <div class="bloque-titulo_boton">
                <h2 class="titulo">Categorías</h2>
                <a href="nueva-categoria.php">
                    <div class="formulario-boton boton-titulo">Añadir</div>
                </a>
            </div>

            <ul class="lista">
                <?php while($categoria = mysqli_fetch_assoc($resultadoConsulta)):?>
                    <li class="lista-contenido">
                        <div class="lista-titulo-descrip">
                            <h3><?php echo $categoria['nombre']; ?></h3>
                            <p><?php echo $categoria['descripcion']; ?></p>
                        </div>
                        <a class="lista-logo" href="modificar-categoria.php?id=<?php echo $categoria['id'] ?>"></a>
                    </li>
                <?php endwhile; ?>
            </ul>
        </section>
    </main>
                    
    <!--Aqui va el pie de la pagina -->
    <footer class="footer">
        <p>www.disengraf.com</p>
    </footer>

</body>

</html>