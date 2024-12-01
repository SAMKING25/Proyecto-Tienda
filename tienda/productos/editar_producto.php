<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar categoria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <?php
        error_reporting( E_ALL );
        ini_set("display_errors", 1 );    

        require('../util/conexion.php');
        require('../util/utilidades.php');

        session_start();
        if (!isset($_SESSION["usuario"])) { 
            header("location: ../usuario/iniciar_sesion.php");
            exit;
        }
    ?>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar producto</h1>
        <?php
        $id_producto = $_GET["id_producto"];
        $sql = "SELECT * FROM productos WHERE id_producto = '$id_producto'";
        $resultado = $_conexion -> query($sql);
        
        while($datos_actuales = $resultado -> fetch_assoc()) {
            $nombre_actual = $datos_actuales["nombre"];
            $precio_actual = $datos_actuales["precio"];
            $categoria_actual = $datos_actuales["categoria"];
            $stock_actual = $datos_actuales["stock"];
            $descripcion_actual = $datos_actuales["descripcion"];
        }

        $sql = "SELECT * FROM categorias ORDER BY categoria";
        $resultado = $_conexion -> query($sql);
        $categorias = [];

        while($fila = $resultado -> fetch_assoc()) {
            array_push($categorias, $fila["categoria"]);
        }

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $nuevo_nombre = depurar($_POST["nuevo_nombre"]);
            $nuevo_precio = depurar($_POST["nuevo_precio"]);
            if(isset($_POST["nueva_categoria"])) $nueva_categoria = depurar($_POST["nueva_categoria"]);
            else $nueva_categoria = "";
            $nuevo_stock = depurar($_POST["nuevo_stock"]);
            $nueva_descripcion = depurar($_POST["nueva_descripcion"]);

            if($nuevo_nombre == ''){
                $err_nombre = "El nombre es obligatorio";
            } else {
                if(strlen($nuevo_nombre) > 50 || strlen($nuevo_nombre) < 3){
                    $err_nombre = "El nombre es de 50 caracteres maximo y 3 minimo";
                } else {
                    $patron = "/^[0-9a-zA-Z áéíóúÁÉÍÓÚ]+$/";
                    if(!preg_match($patron, $nuevo_nombre)){
                        $err_nombre = "El nombre solo puede tener letras, numeros y espacios";
                    } else {
                        // Modifica el nombre
                        $sql = "UPDATE productos SET nombre = '$nuevo_nombre' WHERE id_producto = '$id_producto'";
                        $_conexion -> query($sql);
                        $nombre_actual = $nuevo_nombre;
                    }
                }
            }

            if($nuevo_precio == ''){
                $err_precio = "El precio es obligatorio";
            } else {
                if(!filter_var($nuevo_precio,FILTER_VALIDATE_FLOAT)){
                    $err_precio = "El precio tiene que ser un numero";
                } else {
                    $patron = "/^[0-9]{1,4}(\.[0-9]{1,2})?$/";
                    if(!preg_match($patron, $nuevo_precio)){
                        $err_precio = "El precio solo puede tener 6 de los cuales 2 decimales";
                    } else{
                        // Modifica el precio
                        $sql = "UPDATE productos SET precio = '$nuevo_precio' WHERE id_producto = '$id_producto'";
                        $_conexion -> query($sql);
                        $precio_actual = $nuevo_precio;
                    }
                }
            }

            if($nueva_categoria == ''){
                $err_categoria = "La categoria es obligatoria";
            } else {
                if(strlen($nueva_categoria) > 30){
                    $err_categoria = "La categoria no puede tener mas de 30 caracteres";
                } else{
                    // Modifica la categoria
                    $sql = "UPDATE productos SET categoria = '$nueva_categoria' WHERE id_producto = '$id_producto'";
                    $_conexion -> query($sql);
                    $categoria_actual = $nueva_categoria;
                }
            }  

            if($nuevo_stock == '' || $nuevo_stock == 0){
                $stock_actual = 0;
            } else {
                if(!filter_var($nuevo_stock,FILTER_VALIDATE_INT)){
                    $err_stock = "El stock tiene que ser un numero entero";
                } else {
                    // Modifica el stock
                    $sql = "UPDATE productos SET stock = $nuevo_stock WHERE id_producto = '$id_producto'";
                    $_conexion -> query($sql);
                    $stock_actual = $nuevo_stock;
                }
            }

            if($nueva_descripcion == ""){
                $err_descripcion = "La descripcion es obligatoria";
            } else {
                if(strlen($nueva_descripcion) > 255){
                    $err_descripcion = "La descripcion no puede tener mas de 255 caracteres";
                } else{
                    // Modifica la descripcion
                    $sql = "UPDATE productos SET descripcion = '$nueva_descripcion' WHERE id_producto = '$id_producto'";
                    $_conexion -> query($sql);
                    $descripcion_actual = $nueva_descripcion;
                }
            }
            
        }

        ?>
        <form class="col-6" action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input class="form-control" type="text" name="nuevo_nombre" value="<?php echo $nombre_actual ?>">
                <?php if(isset($err_nombre)) echo "<span class='error'>$err_nombre</span>"; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Precio</label>
                <input class="form-control" type="text" name="nuevo_precio" value="<?php echo $precio_actual ?>">
                <?php if(isset($err_precio)) echo "<span class='error'>$err_precio</span>"; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Categorias</label>
                <select class="form-select" name="nueva_categoria">
                    <option value="<?php echo $categoria_actual ?>" selected><?php echo $categoria_actual ?></option>
                    <?php 
                    foreach($categorias as $categoria) { ?>
                        <?php if($categoria != $categoria_actual){ ?>
                            <option value="<?php echo $categoria ?>">
                                <?php echo $categoria; ?>
                            </option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if(isset($err_categoria)) echo "<span class='error'>$err_categoria</span>"; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input class="form-control" type="text" name="nuevo_stock" value="<?php echo $stock_actual ?>">
                <?php if(isset($err_stock)) echo "<span class='error'>$err_stock</span>"; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripcion</label>
                <textarea class="form-control" name="nueva_descripcion"><?php echo $descripcion_actual ?></textarea>
                <?php if(isset($err_descripcion)) echo "<span class='error'>$err_descripcion</span>"; ?>
            </div>
            <div class="mb-3">
                <input type="hidden" name="id_producto" value="<?php echo $id_producto ?>">
                <input class="btn btn-primary" type="submit" value="Confirmar">
                <a class="btn btn-secondary" href="index.php">Volver</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>