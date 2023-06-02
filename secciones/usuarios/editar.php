<?php
require_once "../../bd.php";

if (isset($_GET["txtID"])) {
    $txtID=(isset($_GET["txtID"]) ? $_GET["txtID"] : '');
    
    $sentencia=$conexion->prepare("SELECT * FROM `tbl_usuarios` WHERE id=:id");
    $sentencia -> bindValue(":id", $txtID);
    
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    $usuario = $registro['usuario'];
    $password = $registro['password'];
    $correo = $registro['correo'];
}

if ($_POST){
    $txtID=(isset($_POST["txtID"]) ? $_POST["txtID"] : '');
    $usuario=(isset($_POST["usuario"]) ? $_POST["usuario"] : '');
    $password=(isset($_POST["password"]) ? $_POST["password"] : '');
    $correo=(isset($_POST["correo"]) ? $_POST["correo"] : '');
    
    $sentencia=$conexion->prepare("UPDATE `tbl_usuarios`
                                    SET `usuario`=:usuario, `password`=:password, `correo`=:correo 
                                    WHERE id=:id");

    $sentencia->bindValue(":usuario",$usuario);
    $sentencia->bindValue(":password",$password);
    $sentencia->bindValue(":correo",$correo);
    $sentencia -> bindValue(":id", $txtID);
    $sentencia->execute();
    header("location:index.php");
    print_r($_POST);
}
?>


<?php require_once("../../templates/header.php")?>
<br>
<div class="card">
    <div class="card-header">
        Editar Usuario
    </div>
    <div class="card-body">
        <form action="" method="post">
            <div class="mb-3">
                
                <label for="txtID" class="form-label">ID:</label>
                <input type="text" class="form-control" name="txtID" id="txtID" 
                aria-describedby="helpId" value="<?php echo $txtID; ?>" placeholder="" readonly>
            
            
                <label for="usuario" class="form-label">Nombre del Usuario</label>
                <input type="text" class="form-control" name="usuario" id="usuario" 
                aria-describedby="helpId" value="<?php echo $usuario; ?>" placeholder="">
                
                <label for="password" class="form-label">Contraseña</label>
                <input type="text" class="form-control" name="password" id="password" 
                aria-describedby="helpId" value="<?php echo $password; ?>" placeholder="" >
            
            
                <label for="correo" class="form-label">Correo</label>
                <input type="text" class="form-control" name="correo" id="correo" 
                aria-describedby="helpId" value="<?php echo $correo; ?>" placeholder="">
                
            </div>
            <button type="submit" name="" id="" class="btn btn-primary" role="button">Modificar Registro</button>
            <a name="" id="" class="btn btn-danger" href="./index.php" role="button">Cancelar</a>
        </form>
    </div>
    
</div>



<?php  require_once("../../templates/footer.php")?>