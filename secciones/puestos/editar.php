<?php
require_once "../../bd.php";

if (isset($_GET["txtID"])) {
    $txtID=(isset($_GET["txtID"]) ? $_GET["txtID"] : '');
    $sentencia=$conexion->prepare("SELECT * FROM `tbl_puestos` WHERE id=:id");
    $sentencia -> bindValue(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    $nombredelpuesto = $registro['nombredelpuesto'];
}

if ($_POST){
    $txtID=(isset($_POST["txtID"]) ? $_POST["txtID"] : '');
    $nombredelpuesto=(isset($_POST["nombredelpuesto"]) ? $_POST["nombredelpuesto"] : '');
    $sentencia=$conexion->prepare("UPDATE `tbl_puestos` SET `nombredelpuesto`=:nombredelpuesto WHERE id=:id");
    $sentencia->bindValue(":nombredelpuesto",$nombredelpuesto);
    $sentencia -> bindValue(":id", $txtID);
    $sentencia->execute();
    header("location:index.php");
}
?>

<?php require_once("../../templates/header.php");?>
<br>
<div class="card">
    <div class="card-header">
        Editar Puestos
    </div>
    <div class="card-body">
        <form action="" method="post">
            <div class="mb-3">
                <label for="txtID" class="form-label">ID:</label>
                <input type="text" class="form-control" name="txtID" id="txtID" 
                aria-describedby="helpId" value="<?php echo $txtID; ?>" placeholder="" readonly>
            
            
                <label for="nombredelpuesto" class="form-label">Nombre del Puesto</label>
                <input type="text" class="form-control" name="nombredelpuesto" id="nombredelpuesto" 
                aria-describedby="helpId" value="<?php echo $nombredelpuesto; ?>" placeholder="">
                
            </div>
            <button type="submit" name="" id="" class="btn btn-primary" role="button">Modificar Registro</button>
            <a name="" id="" class="btn btn-danger" href="./index.php" role="button">Cancelar</a>
        </form>
    </div>
    
</div>
<?php  require_once("../../templates/footer.php")?>