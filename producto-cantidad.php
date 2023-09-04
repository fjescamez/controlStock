<?php

    include "conexion.php";

 

    $id = $_GET['id'];

 

    $consulta = "SELECT * FROM productos WHERE id = ${'id'}";

 

    $resultadoConsulta = mysqli_query($conn, $consulta);

 

    $producto = mysqli_fetch_assoc($resultadoConsulta);

 

    $state = 0;

 

    /*

    Aqui actulizamos el registro de la base de datos.

    Creamos unas variables universales para que al modificar, sin refrescar se modifiquen los valores del input

    */

    

    $nombre_producto=$producto['nombre'];

    $categoria_producto=$producto['id_categoria'];

    $cantidad_producto=$producto['cantidad'];

 

 

    if (isset($_POST['actualizar'])) { // Verifica si el formulario se ha enviado

        $id_modificar = $_POST['id'];

        //Recoger del post la cantidad a descontar

        $cantidad_descontar = $_POST['descontar'];

        if($cantidad_descontar > 0){

            if (($cantidad_producto - $cantidad_descontar) < 0) {

                $state = 1;
    
            } else {
    
                $cantidad_producto -= $cantidad_descontar;
    
                // Actualizar el valor del stock en la base de datos ya descontado
    
                $consulta_descontar = "UPDATE productos SET  cantidad ='$cantidad_producto' WHERE id = $id_modificar";
    
                $resultados_descontar = mysqli_query($conn, $consulta_descontar);
    
                $state = 2;
    
            }
        }else{
            $state = 3;
        }

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

                <h2 class="titulo">Actualizar Stock</h2>

                <a href="productos.php">

                    <div class="formulario-boton boton-titulo">Volver</div>

                </a>

            </div>

 

            <?php if(intVal($state )=== 1):  ?>

                    <div class="alerta error">

                        <?php echo "No se puede descontar"; ?>

                    </div>

            <?php elseif(intVal($state )=== 2):  ?>

                    <div class="alerta succes">

                        <?php echo "Cantidad descontada"; ?>

                    </div>

                
            <?php elseif(intVal($state )=== 3):  ?>

                    <div class="alerta error">

                        <?php echo "No se ha indicado ninguna cantidad"; ?>

                    </div>

            <?php endif; ?>

 

 

            <div class="contenido-formulario">

                <form class="formulario" method="post">

                    <div>

                        <label class="formulario-label">Descripcion:</label>

                        <input class="formulario-input" type="text"  value="<?php echo $nombre_producto ?>" placeholder="Descripcion"  disabled>

                    </div>

 

                    <div>

                        <label class="formulario-label">Categoria:</label>

                        <input class="formulario-input" type="text" value="<?php echo $categoria_producto ?>" placeholder="Categoria" disabled>

                    </div>

 

                    <div>

                        <label class="formulario-label">Stock Actual:</label>

                        <input class="formulario-input" type="number" value="<?php echo $cantidad_producto ?>" placeholder="5" disabled>

                        <!-- esta en tipo texto porque no consigo quitar las flechas de decoracion-->

                    </div>

 

                    <div>

                        <label class="formulario-label">Descontar:</label>

                        <input class="formulario-input" type="number" name ="descontar" placeholder="0" min="0">

                        <!-- esta en tipo texto porque no consigo quitar las flechas de decoracion-->

                    </div>

                    <input class="formulario-boton" type="submit" value="Actualizar" name="actualizar">

                    <input type="hidden" name="id" value="<?php echo $producto['id'] ?>">

                </form>

            </div>

        </section>

 

    </main>

 

    <!--Aqui va el pie de la pagina -->

    <footer class="footer">

        <p>www.disengraf.com</p>

    </footer>

 

</body>

 

</html>