<?php 
require_once "../../bd.php";
    
if ($_POST){
    
    $primernombre=(isset($_POST["primernombre"]) ? $_POST["primernombre"] : '');
    $segundonombre=(isset($_POST["segundonombre"]) ? $_POST["segundonombre"] : '');
    $primerapellido=(isset($_POST["primerapellido"]) ? $_POST["primerapellido"] : '');
    $segundoapellido=(isset($_POST["segundoapellido"]) ? $_POST["segundoapellido"] : '');
    
    $foto=(isset($_FILES["foto"]['name']) ? $_FILES["foto"]['name'] : '');
    $cv=(isset($_FILES["cv"]['name']) ? $_FILES["cv"]['name'] : '');
    
    $idpuesto=(isset($_POST["idpuesto"]) ? $_POST["idpuesto"] : '');
    $fechadeingreso=(isset($_POST["fechadeingreso"]) ? $_POST["fechadeingreso"] : '');

    $sentencia=$conexion->prepare("INSERT INTO `tbl_empleados`(`id`, `primernombre`, `segundonombre`, `primerapellido`, `segundoapellido`, `foto`, `cv`, `idpuesto`, `fechadeingreso`) 
                                    VALUES (null, :primernombre, :segundonombre, :primerapellido, :segundoapellido, :foto, :cv, :idpuesto, :fechadeingreso)");
    
    $sentencia->bindValue(":primernombre",$primernombre);
    $sentencia->bindValue(":segundonombre",$segundonombre);
    $sentencia->bindValue(":primerapellido",$primerapellido);
    $sentencia->bindValue(":segundoapellido",$segundoapellido);
    
    $fecha_ = new DateTime();
    $nombreArchivo_foto=($foto != '') ? $fecha_->getTimestamp() . "_" . $_FILES["foto"]['name'] : "";
    $tmp_foto = $_FILES["foto"]['tmp_name'];
    if($tmp_foto != ''){
        move_uploaded_file($tmp_foto, "../empleados/img_empleados" . $nombreArchivo_foto);
    }
    $sentencia->bindValue(":foto",$nombreArchivo_foto);
    
    $nombreArchivo_cv = ($cv != '') ? $fecha_->getTimestamp() . "_" . $_FILES["cv"]['name'] : "";
    $tmp_cv = $_FILES["cv"]['tmp_name'];
    if($tmp_cv != ''){
        move_uploaded_file($tmp_cv, "../empleados/cv_empleados" . $nombreArchivo_cv );
    }
    $sentencia->bindValue(":cv",$cv);
    
    $sentencia->bindValue(":idpuesto",$idpuesto);
    $sentencia->bindValue(":fechadeingreso",$fechadeingreso);
    
    $sentencia->execute();
    header("location:index.php");
}

    $sentencia=$conexion->prepare("SELECT * FROM `tbl_puestos`");
    $sentencia->execute();
    $lista_tbl_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);


require_once("../../templates/header.php")?>
<br>
<div class="card">
    <div class="card-header">
        Datos del empleado
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="primernombre" class="form-label">Primer Nombre</label>
                <input type="text" class="form-control" name="primernombre" id="primernombre" aria-describedby="helpId" placeholder="">
                
                <label for="segundonombre" class="form-label">segundo Nombre</label>
                <input type="text" class="form-control" name="segundonombre" id="segundonombre" aria-describedby="helpId" placeholder="">
                
                <label for="primerapellido" class="form-label">Primer Apellido</label>
                <input type="text" class="form-control" name="primerapellido" id="primerapellido" aria-describedby="helpId" placeholder="">
                
                <label for="segundoapellido" class="form-label">Segundo Apellido</label>
                <input type="text" class="form-control" name="segundoapellido" id="segundoapellido" aria-describedby="helpId" placeholder="">
                
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="">
                
                <label for="cv" class="form-label">CV</label>
                <input type="file" class="form-control" name="cv" id="cv" aria-describedby="helpId" placeholder="">
                
                <div class="mb-3">
                    <label for="idpuesto" class="form-label">Puesto</label>
                    <select class="form-select form-select-lg" name="idpuesto" id="idpuesto">
                        <option selected>Seleccione uno</option>
                        <?php foreach ($lista_tbl_puestos as $registro) { ?>
                        <option value="<?php echo $registro['id'] ?>"><?php echo $registro['nombredelpuesto'] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <label for="fechadeingreso" class="form-label">Fecha de Ingreso</label>
                <input type="date" class="form-control" name="fechadeingreso" id="fechadeingreso" aria-describedby="helpId" placeholder="">
                
            
            </div>
            <button type="submit" name="" id="" class="btn btn-primary" role="button">Agregar Registro</button>
            <a name="" id="" class="btn btn-danger" href="./index.php" role="button">Cancelar</a>
        </form>
    </div>
</div>




<?php  require_once("../../templates/footer.php")?>