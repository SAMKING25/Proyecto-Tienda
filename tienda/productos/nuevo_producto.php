<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <?php
        error_reporting( E_ALL );
        ini_set("display_errors", 1 );  
        require('../util/conexion.php');
        require('../util/utilidades.php');
    ?>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $tmp_nombre = depurar($_POST["nombre"]);
        $tmp_precio = depurar($_POST["precio"]);
        if(isset($_POST["categoria"])) $tmp_categoria = depurar($_POST["categoria"]);
        else $tmp_categoria = "";
        $tmp_stock = depurar($_POST["stock"]);
        $tmp_descripcion = depurar($_POST["descripcion"]);

        $nombre_imagen = $_FILES["imagen"]["name"];
        $ubicacion_temporal = $_FILES["imagen"]["tmp_name"];
        $ubicacion_final = "../imagenes/$nombre_imagen";

        if($tmp_nombre == ''){
            $err_nombre = "El nombre es obligatorio";
        } else {
            if(strlen($tmp_nombre) > 50){
                $err_nombre = "El nombre no puede tener mas de 50 caracteres";
            } else{
                $nombre = $tmp_nombre;
            }
        }

        if($tmp_precio == ''){
            $err_precio = "El precio es obligatorio";
        } else {
            $patron = "/^[0-9]{1,4}(\.[0-9]{1,2})?$/";
            if(!preg_match($patron, $tmp_precio)){
                $err_precio = "El precio no tiene un formato valido o tamaño";
            } else{
                $precio = $tmp_precio;
            }
        }

        if($tmp_categoria == ''){
            $err_categoria = "La categoria es obligatoria";
        } else {
            if(strlen($tmp_categoria) > 30){
                $err_categoria = "La categoria no puede tener mas de 30 caracteres";
            } else{
                $sql = "SELECT * FROM categorias ORDER BY categoria";
                $resultado = $_conexion -> query($sql);
                $categorias = [];

                while($fila = $resultado -> fetch_assoc()) {
                    array_push($categorias, $fila["categoria"]);
                }

                if(!in_array($categorias,$tmp_categoria)){
                    $err_categoria = "La categoria no existe";
                } else {
                    $categoria = $tmp_categoria;
                }
            }
        }   

        if($tmp_stock == ''){
            $stock = 0;
        } else {
            $stock = $tmp_stock;
        }

        if($nombre_imagen == ""){
            $err_imagen = "La imagen es obligatoria";
        } else {
            if(strlen($ubicacion_final) > 60){
                $err_imagen = "La ruta de la imagen no puede tener mas de 30 caracteres";
            } else {
                move_uploaded_file($ubicacion_temporal, $ubicacion_final);
                $imagen = $nombre_imagen;
            }
        }
        

        if($tmp_descripcion == ''){
            $err_descripcion = "La descripcion es obligatoria";
        } else {
            if(strlen($tmp_descripcion) > 255){
                $err_descripcion = "La descripcion no puede tener mas de 255 caracteres";
            } else{
                $descripcion = $tmp_descripcion;
            }
        }

        if (isset($nombre) && isset($precio) && isset($categoria) && isset($imagen) && isset($descripcion)){
            // Inserta un nuevo producto
            $sql = "INSERT INTO productos (nombre, precio, categoria, stock, imagen, descripcion)
            VALUES ('$nombre', $precio, '$categoria', $stock, '$ubicacion_final', '$descripcion')";
            $_conexion -> query($sql);
        }
        
    }

    $sql = "SELECT * FROM categorias ORDER BY categoria";
    $resultado = $_conexion -> query($sql);
    $categorias = [];

    while($fila = $resultado -> fetch_assoc()) {
        array_push($categorias, $fila["categoria"]);
    }

    ?>
    <div class="container">
        <h1>Nuevo Producto</h1>
        <form class="col-5" action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input class="form-control" type="text" name="nombre">
                <?php if(isset($err_nombre)) echo "<span class='error'>$err_nombre</span>"; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Precio</label>
                <input class="form-control" type="text" name="precio">
                <?php if(isset($err_precio)) echo "<span class='error'>$err_precio</span>"; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Categorias</label>
                <select class="form-select" name="categoria">
                    <option selected disabled hidden>--- Elige una categoria ---</option>
                    <?php 
                    foreach($categorias as $categoria) { ?>
                        <option value="<?php echo $categoria ?>">
                            <?php echo $categoria ?>
                        </option>
                    <?php } ?>
                </select>
                <?php if(isset($err_categoria)) echo "<span class='error'>$err_categoria</span>"; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input class="form-control" type="text" name="stock">
                <?php if(isset($err_stock)) echo "<span class='error'>$err_stock</span>"; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Imagen</label>
                <input class="form-control" type="file" name="imagen">
                <?php if(isset($err_imagen)) echo "<span class='error'>$err_imagen</span>"; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripcion</label>
                <input type="text" class="form-control" name="descripcion">
                <?php if(isset($err_descripcion)) echo "<span class='error'>$err_descripcion</span>"; ?>
            </div>
            <div class="mb-3">
                <input class="btn btn-primary" type="submit" value="Insertar producto">
                <a class="btn btn-secondary" href="index.php">Volver</a>
            </div>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>