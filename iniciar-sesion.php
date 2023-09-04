<?php
include "conexion.php";

$errores = [];
$nombre = '';
$descripcion = '';

if (isset($_POST['insertar'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    if (!$nombre) {
        $errores[] = "Debes añadir un nombre";
    }

    if (!$descripcion) {
        $errores[] = "Debes añadir una descripcion";
    }

    if (empty($errores)) {
        $consulta = "INSERT INTO categorias (nombre, descripcion) VALUES ('$nombre', '$descripcion')";
        $resultados = mysqli_query($conn, $consulta);

        if ($resultados) {
            header("Location: categorias.php");
            exit();
        } else {
            echo "Error al insertar la categoría: " . mysqli_error($conn);
        }
    }
}
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
    <header class="header">
        <div class="header-barra">
            <input type="text" placeholder="Buscar">
        </div>
    </header>
    <main class="main">
        <nav class="navegacion">
            <div class="navContenedor">
                <a href="categorias.php">Categorias</a>
                <a href="productos.php">Productos</a>
                <a href="seguimiento.html">Seguimiento</a>
                <a href="registro.html">Registro</a>
            </div>
        </nav>
        <section>
            <div class="bloque-titulo_boton">
                <h2 class="titulo">Nueva Categoría</h2>
                <a href="categorias.php">
                    <div class="formulario-boton boton-titulo">Volver</div>
                </a>
            </div>
            <?php foreach ($errores as $error): ?>
                <div class="alerta error">
                    <?php echo $error; ?>
                </div>
            <?php endforeach; ?>
            <div class="contenido-formulario">
                <form class="formulario" method="post">
                    <div>
                        <label class="formulario-label">Nombre:</label>
                        <input class="formulario-input" type="text" value="<?php echo $nombre ?>" placeholder="Nombre" name="nombre">
                    </div>
                    <div>
                        <label class="formulario-label">Descripcion:</label>
                        <input class="formulario-input" type="text" value="<?php echo $descripcion ?>" placeholder="Descripcion" name="descripcion">
                    </div>
                    <input class="formulario-boton" type="submit" value="Insertar" name="insertar">
                </form>
            </div>
        </section>
    </main>
    <footer class="footer">
        <p>www.disengraf.com</p>
    </footer>
</body>
</html>
