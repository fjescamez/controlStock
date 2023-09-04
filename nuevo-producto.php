<?php
    include "conexion.php";

    // consultar todas las categorias
    $consulta_categorias = "SELECT * FROM Categorias";
    $resultados_categorias = mysqli_query($conn, $consulta_categorias);

    
    // declarar variables de value
    $errorres = [];
    $nombre = '';
    $id_categoria = '';
    $cantidad = '';
    $stock_min = '';

    if (isset($_POST['insertar'])) { // Verifica si el formulario se ha enviado
    
        // Recogemos los valores donde los almacenamos y sanitizamos
        $nombre = $_POST['nombre'];
        $id_categoria = $_POST['id_categoria'];
        $cantidad = $_POST['cantidad'];
        $stock_min = $_POST['stock_min'];

        // Verificacion de formulario
        if(!$nombre){
            $errores[] = "Debes añadir un nombre";
        }

        if(!$id_categoria){
            $errores[] = "Debes añadir una categoria";
        }

        if(!$cantidad){
            $errores[] = "Debes añadir una cantidad";
        }

        if(!$stock_min){
            $errores[] = "Debes añadir una cantidad de stock minimo";
        }

        // revisar el array de errores y si esta vacio lo guarda en la base de datos
        if(empty($errores)){
            $consulta = "INSERT INTO productos (cantidad,nombre,stock_min,id_categoria) values ('$cantidad','$nombre','$stock_min','$id_categoria')";
    
            $resultados = mysqli_query($conn, $consulta);
            
            if ($resultados) {
                // Redirigir a la página de categorías después de la eliminación
                header("Location: productos.php");
                exit(); // Asegurarse de que el script se detenga aquí
            } else {
                echo "Error al eliminar la categoría: " . mysqli_error($conn);
            }
        }

        // Cerrar la conexión cuando hayas terminado
        $conn->close();

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
                <h2 class="titulo">Nuevo Producto</h2>
                <a href="productos.php">
                    <div class="formulario-boton boton-titulo">Volver</div>
                </a>
            </div>


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
                        <input class="formulario-input" type="text" placeholder="Nombre Producto" name="nombre" value="<?php echo $nombre ?>">
                    </div>

                    <div>
                        <label class="formulario-label">Categoria:</label>
                        <select class="formulario-input formulario-select" name = "id_categoria">
                            <option value="">--Seleccionar--</option>
                            <?php while($categoria = mysqli_fetch_assoc($resultados_categorias)): ?>
                                <option <?php echo $id_categoria === $categoria['id'] ? 'selected' : '';?> value="<?php echo $categoria['id'];?>"><?php echo $categoria['nombre'];?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
    
                    <div>
                        <label class="formulario-label">Stock Min:</label>
                        <input class="formulario-input" type="number" placeholder="Stock minimo del Producto" name="stock_min" value="<?php echo $stock_min ?>">
                        <!-- esta en tipo texto porque no consigo quitar las flechas de decoracion-->
                    </div>

                    <div>
                        <label class="formulario-label">Cantidad:</label>
                        <input class="formulario-input" type="number" placeholder="Cantidad del Producto" name="cantidad" value="<?php echo $cantidad ?>">
                        <!-- esta en tipo texto porque no consigo quitar las flechas de decoracion-->
                    </div>
                    <input class="formulario-boton" type="submit" value="Insertar" name="insertar">
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