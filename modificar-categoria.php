<?php
include "conexion.php";

/*
Recogemos el id pasado por la url.
*/
$id = $_GET['id'];

$consulta = "SELECT * FROM categorias WHERE id = ${'id'}";

$resultadoConsulta = mysqli_query($conn, $consulta);

$categoria = mysqli_fetch_assoc($resultadoConsulta);

$state = 0;
$errores = [];

$nombre_categoria = $categoria['nombre'];
$descripcion_categoria = $categoria['descripcion'];


/*
Aqui borramos el registro de la base de datos indicando su id.
*/
if (isset($_POST['borrar'])) { // Verifica si el formulario se ha enviado
    $id_borrar = $_POST['id'];
    $consulta = "DELETE FROM categorias WHERE id = $id_borrar";
    $resultados = mysqli_query($conn, $consulta);

    if ($resultados) {
        // Redirigir a la página de categorías después de la eliminación
        header("Location: categorias.php");
        exit(); // Asegurarse de que el script se detenga aquí
    } else {
        echo "Error al eliminar la categoría: " . mysqli_error($conn);
    }

}


/*
Aqui modificamos el registro de la base de datos.
Creamos unas variables universales para que al modificar, sin refrescar se modifiquen los valores del input
*/


if (isset($_POST['modificar'])) { // Verifica si el formulario se ha enviado
    $id_modificar = $_POST['id'];
    $nombre_categoria = $_POST['nombre'];
    $descripcion_categoria = $_POST['descripcion'];


    // Verificacion de formulario
    if (!$nombre_categoria) {
        $errores[] = "Debes añadir un nombre";
    }

    if (!$descripcion_categoria) {
        $errores[] = "Debes añadir una descripcion";
    }


    if (empty($errores)) {
        $consulta = "UPDATE categorias SET nombre = '$nombre_categoria', descripcion = '$descripcion_categoria' WHERE id = $id_modificar";
        $resultados = mysqli_query($conn, $consulta);
        $state = 1;
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
                <h2 class="titulo">Modificar Categoria</h2>
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

            <?php if (intVal($state) === 1): ?>

                <div class="alerta succes">

                    <?php echo "Categoria Modificada Correctamente"; ?>

                </div>

            <?php endif; ?>

            <div class="contenido-formulario">
                <form class="formulario" method="post">
                    <div>
                        <label class="formulario-label">Nombre:</label>
                        <input class="formulario-input" type="text" value="<?php echo $nombre_categoria ?>"
                            name="nombre">
                    </div>

                    <div>
                        <label class="formulario-label">Descripcion:</label>
                        <input class="formulario-input" type="text" value="<?php echo $descripcion_categoria ?>"
                            name="descripcion">
                    </div>

                    <input class="formulario-boton boton-eliminar" type="submit" value="Borrar" name="borrar">
                    <input class="formulario-boton" type="submit" value="Modificar" name="modificar">
                    <input type="hidden" name="id" value="<?php echo $categoria['id'] ?>">
                </form>
            </div>
        </section>
        <?php
        // Cerrar la conexión cuando hayas terminado
        $conn->close();
        ?>
    </main>

    <!--Aqui va el pie de la pagina -->
    <footer class="footer">
        <p>www.disengraf.com</p>
    </footer>

</body>

</html>