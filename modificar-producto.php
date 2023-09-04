<?php
    include "conexion.php";

    /*
    Recogemos el id pasado por la url.
    */
    $id = $_GET['id'];

    $consulta = "SELECT * FROM productos WHERE id = ${'id'}";

    $resultadoConsulta = mysqli_query($conn, $consulta);

    $producto = mysqli_fetch_assoc($resultadoConsulta);

    $state = 0;

    /*
    Aqui borramos el registro de la base de datos indicando su id.
    */ 
    if (isset($_POST['borrar'])) { // Verifica si el formulario se ha enviado
        $id_borrar = $_POST['id'];
        $consulta = "DELETE FROM productos WHERE id = $id_borrar";
        $resultados = mysqli_query($conn, $consulta);
    
        if ($resultados) {
            // Redirigir a la página de categorías después de la eliminación
            header("Location: productos.php");
            exit(); // Asegurarse de que el script se detenga aquí
        } else {
            echo "Error al eliminar la categoría: " . mysqli_error($conn);
        }
    
    }

    /*
    Aqui modificamos el registro de la base de datos.
    Creamos unas variables universales para que al modificar, sin refrescar se modifiquen los valores del input
    */ 
    
    $nombre_producto=$producto['nombre'];
    $categoria_producto=$producto['id_categoria'];
    $stock_producto=$producto['stock_min'];
    $cantidad_producto=$producto['cantidad'];

    /*
    declarar variables de value
    $errorres = [];
    $nombre = '';
    $id_categoria = '';
    $cantidad = '';
    $stock_min = '';
    */

    if (isset($_POST['modificar'])) { // Verifica si el formulario se ha enviado
        $id_modificar = $_POST['id'];
        $nombre_producto = $_POST['nombre'];
        $categoria_producto = $_POST['id_categoria'];
        $stock_producto = $_POST['stock_min'];
        $cantidad_producto = $_POST['cantidad'];

        // Verificacion de formulario
        if(!$nombre_producto){
            $errores[] = "Debes añadir un nombre";
        }

        if(!$categoria_producto){
            $errores[] = "Debes añadir una categoria";
        }

        if(!$cantidad_producto){
            $errores[] = "Debes añadir una cantidad";
        }

        if(!$stock_producto){
            $errores[] = "Debes añadir una cantidad de stock minimo";
        }

        // revisar el array de errores y si esta vacio lo guarda en la base de datos
        if(empty($errores)){
            $consulta = "UPDATE productos SET nombre = '$nombre_producto', id_categoria = '$categoria_producto', stock_min ='$stock_producto', cantidad ='$cantidad_producto' WHERE id = $id_modificar";
    
            $resultados = mysqli_query($conn, $consulta);
            
            $state = 2;
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

                <a href="seguimiento.php">Seguimiento</a>

                <a href="registro.php">Registro</a>
            </div>
        </nav>

        <!--Aqui va el contenido principal de la pagina -->
        <section>
            <div class="bloque-titulo_boton">
                <h2 class="titulo">Modificar Producto</h2>
                <a href="productos.php">
                    <div class="formulario-boton boton-titulo">Volver</div>
                </a>
            </div>

            <?php if (intval($state) === 2) :  ?>
                <div class="alerta succes">
                    <?php echo "Producto modificado correctamente"; ?>
                </div>
            <?php endif; ?>

            <!-- mostrar los errores si existen -->
            <?php foreach($errores as $error): ?>
                <div class="alerta error">
                    <?php echo $error; ?>
                </div>
            <?php endforeach; ?>

            <div class="contenido-formulario">
            <form class="formulario" method="post">
                <div>
                    <label class="formulario-label">Nombre:</label>
                    <input class="formulario-input" type="text" name="nombre" value="<?php echo $nombre_producto ?>">
                </div>

                <div>
                    <label class="formulario-label">Categoria:</label>
                    <input class="formulario-input" type="number" name="id_categoria" value="<?php echo $categoria_producto ?>">
                </div>

                <div>
                    <label class="formulario-label">Stock Min:</label>
                    <input class="formulario-input" type="number" name="stock_min" value="<?php echo $stock_producto ?>">
                </div>

                <div>
                    <label class="formulario-label">Cantidad:</label>
                    <input class="formulario-input" type="number" name="cantidad" value="<?php echo $cantidad_producto ?>">
                </div>
                <input class="formulario-boton boton-eliminar" type="submit" value="Borrar" name="borrar">
                <input class="formulario-boton" type="submit" value="Modificar" name="modificar">
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