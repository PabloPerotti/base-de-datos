<?php

if ($_POST){
    require_once "../../bd.php";
    $usuario=(isset($_POST["usuario"]) ? $_POST["usuario"] : '');
    $password=(isset($_POST["password"]) ? $_POST["password"] : '');
    $correo=(isset($_POST["correo"]) ? $_POST["correo"] : '');
    $sentencia=$conexion->prepare("INSERT INTO `tbl_usuarios`(`id`, `usuario`, `password`, `correo`)
                                    VALUES (null,:usuario,:password,:correo)");
    $sentencia->bindValue(":usuario",$usuario);
    $sentencia->bindValue(":password",$password);
    $sentencia->bindValue(":correo",$correo);
    
    $sentencia->execute();
    header("location:index.php?mensaje='Usuario creado correctamente'");
}

require_once("../../templates/header.php");
if (isset($_GET['mensaje'])) { ?>

    <script>
        swal.fire({
            icon:"success", 
            title:"<?php echo $_GET['mensaje']; ?>"
            });
    </script>
    <?php } ?>
<br>
<div class="card">
    <div class="card-header">
        Usuarios
    </div>
    <div class="card-body">
        <form action="" method="post">
            <div class="mb-3">
                <label for="usuario" class="form-label">Nombre del usuario</label>
                <input type="text" class="form-control" name="usuario" id="usuario" aria-describedby="helpId" placeholder="">
                
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="">
                </div>

                <div class="mb-3">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="email" class="form-control" name="correo" id="correo" aria-describedby="emailHelpId" placeholder="abc@mail.com">
                </div>

            </div>
            <button type="submit" name="" id="" class="btn btn-primary" role="button">Agregar Registro</button>
            <a name="" id="" class="btn btn-danger" href="./index.php" role="button">Cancelar</a>
        </form>
    </div>
    
</div>
<?php require_once("../../templates/footer.php") ?>