<?php

include "conexion.php";


//Declaramos las variables vacias

$errores = [];

$nombre = '';

$descripcion = '';



if (isset($_POST['insertar'])) { // Verifica si el formulario se ha enviado



    // Recogemos los valores donde los almacenamos

    $nombre = $_POST['nombre'];

    $descripcion = $_POST['descripcion'];



    // Verificacion de formulario

    if (!$nombre) {

        $errores[] = "Debes añadir un nombre";

    }



    if (!$descripcion) {

        $errores[] = "Debes añadir una descripcion";

    }



    // revisar el array de errores y si esta vacio lo guarda en la base de datos

    if (empty($errores)) {

        $consulta = "INSERT INTO categorias (nombre,descripcion) values ('$nombre','$descripcion')";
        $resultados = mysqli_query($conn, $consulta);

        if ($resultados) {

            /*
            // recuperar id guardado
            $id = mysqli_insert_id($conn);

            // crear registro de nueva categoria
            $descripcion = 'Categoria Creada';
            $query = "INSERT INTO registro (descripcion,id_producto) values ('$descripcion','$id')";
            $resultado = mysqli_query($conn, $query);
            */
            // Redirigir a la página de categorías después de la eliminación
    

            header("Location: categorias.php");


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

                <h2 class="titulo">Nueva Categoría</h2>

                <a href="categorias.php">

                    <div class="formulario-boton boton-titulo">Volver</div>

                </a>

            </div>



            <!-- mostrar los errores si existen -->

            <?php foreach ($errores as $error): ?>

                <div class="alerta error">

                    <?php echo $error; ?>

                </div>

            <?php endforeach; ?>



            <div class="contenido-formulario">

                <form class="formulario" method="post">

                    <div>

                        <label class="formulario-label">Nombre:</label>

                        <input class="formulario-input" type="text" value="<?php echo $nombre ?>" placeholder="Nombre"
                            name="nombre">

                    </div>



                    <div>

                        <label class="formulario-label">Descripcion:</label>

                        <input class="formulario-input" type="text" value="<?php echo $descripcion ?>"
                            placeholder="Descripcion" name="descripcion">

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