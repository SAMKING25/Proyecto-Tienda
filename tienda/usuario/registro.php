<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
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
    if($_SERVER["REQUEST_METHOD"] == "POST"){
            $tmp_usuario = depurar($_POST["usuario"]);
            $tmp_contrasena = $_POST["contrasena"];

            if($tmp_usuario == ""){
                $err_usuario = "El usuario es obligatorio";
            } else {
                if(strlen($tmp_usuario) > 15){
                    $err_usuario = "El usuario no puede tener mas de 15 caracteres";
                } else {
                    $usuario = $tmp_usuario;
                }
            }

            if($tmp_contrasena == ""){
                $err_contrasena = "La contraseña es obligatoria";
            } else {
                $contrasena = $tmp_contrasena;
                $contrasena_cifrada = password_hash($contrasena,PASSWORD_DEFAULT);
            }

            if(isset($usuario) && isset($contrasena_cifrada)){
                $sql = "INSERT INTO usuarios VALUES ('$usuario','$contrasena_cifrada')";
                $_conexion -> query($sql);
                header("location: iniciar_sesion.php");
                exit;
            }
            
        } 
    ?>
    <div class="container">
        <h1>Registro</h1>
        <form class="col-6" action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Usuario</label>
                <input class="form-control" type="text" name="usuario">
                <?php if(isset($err_usuario)) echo "<span class='error'>$err_usuario</span>"; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input class="form-control" type="password" name="contrasena">
                <?php if(isset($err_contrasena)) echo "<span class='error'>$err_contrasena</span>"; ?>
            </div>
            <div class="mb-3">
                <input class="btn btn-primary" type="submit" value="Registrarse">
            </div>
            <div class="mb-3">
                <p>Si ya tienes cuenta, inicia sesion</p>
                <a class="btn btn-secondary" href="iniciar_sesion.php">Iniciar sesion</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>