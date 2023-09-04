<?php
include "conexion.php";

$id = $_GET['id'];

$consulta = "SELECT * FROM categorias WHERE id = $id";

$resultadoConsulta = mysqli_query($conn, $consulta);

$categoria = mysqli_fetch_assoc($resultadoConsulta);

$state = 0;
$errores = [];

$nombre_categoria = $categoria['nombre'];
$descripcion_categoria = $categoria['descripcion'];

if (isset($_POST['borrar'])) {
    $id_borrar = $_POST['id'];
    $consulta = "DELETE FROM categorias WHERE id = $id_borrar";
    $resultados = mysqli_query($conn, $consulta);

    if ($resultados) {
        header("Location: categorias.php");
        exit();
    } else {
        echo "Error al eliminar la categoría: " . mysqli_error($conn);
    }
}

if (isset($_POST['modificar'])) {
    $id_modificar = $_POST['id'];
    $nombre_categoria = $_POST['nombre'];
    $descripcion_categoria = $_POST['descripcion'];

    if (!$nombre_categoria) {
        $errores[] = "Debes añadir un nombre";
    }

    if (!$descripcion_categoria) {
        $errores[] = "Debes añadir una descripción";
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
    <header class="header">
        <div class="header-barra">
            <input type="text" placeholder="Buscar:">
        </div>
    </header>

    <main class="main">
        <nav class="navegacion">
            <div class="navContenedor">
                <a href="categorias.php">Categorias</a>
                <a href="productos.php">Productos</a>
                <a href="seguimiento.php">Seguimiento</a>
                <a href="registro.php">Registro</a>
            </div>
        </nav>

        <section>
            <div class="bloque-titulo_boton">
                <h2 class="titulo">Modificar Categoría</h2>
                <a href="categorias.php">
                    <div class="formulario-boton boton-titulo">Volver</div>
                </a>
            </div>

            <?php foreach ($errores as $error): ?>
                <div class="alerta error">
                    <?php echo $error; ?>
                </div>
            <?php endforeach; ?>

            <?php if (intval($state) === 1): ?>
                <div class="alerta succes">
                    <?php echo "Categoría modificada correctamente"; ?>
                </div>
            <?php endif; ?>

            <div class="contenido-formulario">
                <form class="formulario" method="post">
                    <div>
                        <label class="formulario-label">Nombre:</label>
                        <input class="formulario-input" type="text" value="<?php echo $nombre_categoria ?>" name="nombre">
                    </div>

                    <div>
                        <label class="formulario-label">Descripción:</label>
                        <input class="formulario-input" type="text" value="<?php echo $descripcion_categoria ?>" name="descripcion">
                    </div>

                    <input class="formulario-boton boton-eliminar" type="submit" value="Borrar" name="borrar">
                    <input class="formulario-boton" type="submit" value="Modificar" name="modificar">
                    <input type="hidden" name="id" value="<?php echo $categoria['id'] ?>">
                </form>
            </div>
        </section>

        <?php
        $conn->close();
        ?>
    </main>

    <footer class="footer">
        <p>www.disengraf.com</p>
    </footer>
</body>
</html>
