<?php
include "conexion.php";

$id = $_GET['id'];

$consulta = "SELECT * FROM productos WHERE id = $id";

$resultadoConsulta = mysqli_query($conn, $consulta);

$producto = mysqli_fetch_assoc($resultadoConsulta);

$state = 0;

$nombre_producto = $producto['nombre'];
$categoria_producto = $producto['id_categoria'];
$cantidad_producto = $producto['cantidad'];

if (isset($_POST['actualizar'])) {
    $id_modificar = $_POST['id'];
    $cantidad_descontar = $_POST['descontar'];

    if ($cantidad_descontar > 0) {
        if (($cantidad_producto - $cantidad_descontar) < 0) {
            $state = 1;
        } else {
            $cantidad_producto -= $cantidad_descontar;
            $consulta_descontar = "UPDATE productos SET cantidad ='$cantidad_producto' WHERE id = $id_modificar";
            $resultados_descontar = mysqli_query($conn, $consulta_descontar);
            $state = 2;
        }
    } else {
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
                <h2 class="titulo">Actualizar Stock</h2>
                <a href="productos.php">
                    <div class="formulario-boton boton-titulo">Volver</div>
                </a>
            </div>

            <?php if (intval($state) === 1) :  ?>
                <div class="alerta error">
                    <?php echo "No se puede descontar"; ?>
                </div>
            <?php elseif (intval($state) === 2) :  ?>
                <div class="alerta succes">
                    <?php echo "Cantidad descontada"; ?>
                </div>
            <?php elseif (intval($state) === 3) :  ?>
                <div class="alerta error">
                    <?php echo "No se ha indicado ninguna cantidad"; ?>
                </div>
            <?php endif; ?>

            <div class="contenido-formulario">
                <form class="formulario" method="post">
                    <div>
                        <label class="formulario-label">Descripcion:</label>
                        <input class="formulario-input" type="text" value="<?php echo $nombre_producto ?>" placeholder="Descripcion" disabled>
                    </div>
                    <div>
                        <label class="formulario-label">Categoria:</label>
                        <input class="formulario-input" type="text" value="<?php echo $categoria_producto ?>" placeholder="Categoria" disabled>
                    </div>
                    <div>
                        <label class="formulario-label">Stock Actual:</label>
                        <input class="formulario-input" type="number" value="<?php echo $cantidad_producto ?>" placeholder="5" disabled>
                    </div>
                    <div>
                        <label class="formulario-label">Descontar:</label>
                        <input class="formulario-input" type="number" name="descontar" placeholder="0" min="0">
                    </div>
                    <input class="formulario-boton" type="submit" value="Actualizar" name="actualizar">
                    <input type="hidden" name="id" value="<?php echo $producto['id'] ?>">
                </form>
            </div>
        </section>
    </main>

    <footer class="footer">
        <p>www.disengraf.com</p>
    </footer>
</body>
</html>