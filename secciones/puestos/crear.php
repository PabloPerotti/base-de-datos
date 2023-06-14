<?php
require_once "../../bd.php";

if ($_POST){
    
    $nombredelpuesto=(isset($_POST["nombredelpuesto"]) ? $_POST["nombredelpuesto"] : '');
    $sentencia=$conexion->prepare("INSERT INTO `tbl_puestos`(`id`, `nombredelpuesto`) 
                VALUES (null,:nombredelpuesto)");
    $sentencia->bindValue(":nombredelpuesto",$nombredelpuesto);
    
    $sentencia->execute();
    header("location:index.php?mensaje='Puesto creado correctamente'");
}

?>

<?php require_once("../../templates/header.php");
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
        Puestos
    </div>
    <div class="card-body">
        <form action="" method="post">
            <div class="mb-3">
                <label for="nombredelpuesto" class="form-label">Nombre del Puesto</label>
                <input type="text" class="form-control" name="nombredelpuesto" id="nombredelpuesto" aria-describedby="helpId" placeholder="">
                
            </div>
            <button type="submit" name="" id="" class="btn btn-primary" role="button">Agregar Registro</button>
            <a name="" id="" class="btn btn-danger" href="./index.php" role="button">Cancelar</a>
        </form>
    </div>
    
</div>
<?php  require_once("../../templates/footer.php")?>