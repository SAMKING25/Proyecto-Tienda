<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla categoria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <?php
        error_reporting( E_ALL );
        ini_set("display_errors", 1 );  

        require('../util/conexion.php');
    ?>
</head>
<body>
    <?php
        $sql = "SELECT * FROM categorias";
        $resultado = $_conexion -> query($sql);
    ?>

    <div class="container">
        <h1>Tabla animes</h1>
        <div class="mb-3">
                <a href="nueva_categoria.php" class="btn btn-primary">Insertar Catergoria</a>
        </div>
        <table class="table table-info table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Categoria</th>
                    <th>Descripcion</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while($fila = $resultado -> fetch_assoc()){
                        echo "<tr>";
                        echo "<td>" . $fila["categoria"] ."</td>";
                        echo "<td>" . $fila["descripcion"] ."</td>";
                        
                        ?>
                        <td>
                            <a class="btn btn-primary" href="editar_categoria.php?categoria=<?php echo $fila["categoria"] ?>">Editar</a>
                        </td>
                        </tr>
                    <?php } ?>
                
            </tbody>
        </table>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>