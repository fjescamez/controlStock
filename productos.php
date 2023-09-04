<?php
    include "conexion.php";

    //$consulta = "SELECT * FROM productos";
    $consulta = "SELECT productos.*, categorias.nombre AS nombre_categoria FROM productos
    LEFT JOIN categorias ON productos.id_categoria = categorias.id";

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
                <h2 class="titulo">Productos</h2>
                <a href="nuevo-producto.php">
                    <div class="formulario-boton boton-titulo">Añadir</div>
                </a>
            </div>
            <table class="tabla-productos2">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Cantidad</th>
                        <th>Actualizar</th>
                        <th>Modificar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($productos = mysqli_fetch_assoc($resultadoConsulta)):?>
        
                            <td><?php echo $productos['nombre']; ?></td>
                            <td><?php echo $productos['nombre_categoria']; ?></td>
                            <td><?php echo $productos['cantidad']; ?></td>
                            <td><a id="agregarContador" class="lista-logo-caja2" href="producto-cantidad.php?id=<?php echo $productos['id'] ?>"></a></td>
                            <td><a class="lista-logo2" href="modificar-producto.php?id=<?php echo $productos['id'] ?>"></a></td>
                        </tr>
                        
                    <?php endwhile;?>
                </tbody>
            </table>
        </section>



    </main>

    <!--Aqui va el pie de la pagina -->
    <footer class="footer">
        <p>www.disengraf.com</p>
    </footer>
    
</body>
</html>
    

