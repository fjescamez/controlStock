<?php

    include "conexion.php";

 

    //$consulta = "SELECT * FROM productos";

    $consulta = "SELECT productos.*, categorias.nombre AS nombre_categoria FROM productos

             INNER JOIN categorias ON productos.id_categoria = categorias.id";

 

 

 

    $resultadoConsulta = mysqli_query($conn, $consulta);

 

    // Cerrar la conexión cuando hayas terminado

    $conn->close();

    if (isset($_POST['orden'])) { 
        
    }

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

                <a href="notificaciones.php">Notificaciones</a>

                <a href="seguimiento.php">Seguimiento</a>

                <a href="registro.php">Registro</a>

            </div>
        </nav>

 

        <!--Aqui va el contenido principal de la pagina -->

        <section>

            <div class="bloque-titulo_boton">

                <h2 class="titulo">Notificaciones</h2>

                <a href="nuevo-producto.php">

                    <div class="formulario-boton boton-titulo">Orden</div>

                </a>

            </div>

            <form action="orden" method="post">
            <table class="tabla-productos2">

                <thead>

                    <tr>
                        <th>Solicitar</th>

                        <th>Nombre</th>

                        <th>Categoría</th>

                        <th>Cantidad</th>

                    </tr>

                </thead>

                <tbody>

                    <?php while($productos = mysqli_fetch_assoc($resultadoConsulta)):?>
                            <td><input type="checkbox"></td>

                            <td><?php echo $productos['nombre']; ?></td>

                            <td><?php echo $productos['nombre_categoria']; ?></td>

                            <td><?php echo $productos['cantidad']; ?></td>

                        </tr>

                        

                    <?php endwhile;?>

                </tbody>

            </table>
            <input class="formulario-boton" type="submit" value="Orden" name="orden">
            </form>

        </section>

 

 

 

    </main>

 

    <!--Aqui va el pie de la pagina -->

    <footer class="footer">

        <p>www.disengraf.com</p>

    </footer>

    

</body>

</html>