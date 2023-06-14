<?php
require_once("../../bd.php");
if (isset($_GET["txtID"])) {
    // Recolectar los datos del metodo GET
    $txtID = (isset($_GET["txtID"]) ? $_GET["txtID"] : "");
    // Preparar la edición de los datos
    $sentencia = $conexion->prepare("SELECT * FROM `tbl_empleados` WHERE id=:id");
    $sentencia->bindValue(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    $primernombre = $registro['primernombre'];
    $segundonombre = $registro['segundonombre'];
    $primerapellido = $registro['primerapellido'];
    $segundoapellido = $registro['segundoapellido'];
    $foto = $registro['foto'];
    $cv = $registro['cv'];
    $idpuesto = $registro['idpuesto'];
    $fechadeingreso = $registro['fechadeingreso'];
}
if ($_POST) {
    // Recolectar los datos del metodo POST
    $txtID = (isset($_POST["txtID"]) ? $_POST["txtID"] : "");
    $primernombre = (isset($_POST["primernombre"]) ? $_POST["primernombre"] : "");
    $segundonombre = (isset($_POST["segundonombre"]) ? $_POST["segundonombre"] : "");
    $primerapellido = (isset($_POST["primerapellido"]) ? $_POST["primerapellido"] : "");
    $segundoapellido = (isset($_POST["segundoapellido"]) ? $_POST["segundoapellido"] : "");

    $foto = (isset($_FILES["foto"]['name']) ? $_FILES["foto"]['name'] : "");
    $cv = (isset($_FILES["cv"]['name']) ? $_FILES["cv"]['name'] : "");
    if ($foto != "" || $cv != "") {
        // Preparar la eliminación de la foto y el CV
        $sentencia = $conexion->prepare("SELECT foto,cv FROM `tbl_empleados` WHERE `id`=:id");
        $sentencia->bindValue(":id", $txtID);
        $sentencia->execute();
        $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);
        if (isset($registro_recuperado["foto"]) && $registro_recuperado["foto"] != "") {
            if (file_exists("../empleados/fotos/" . $registro_recuperado["foto"])) {
                unlink("../empleados/fotos/" . $registro_recuperado["foto"]);
            }
        }
        if (isset($registro_recuperado["cv"]) && $registro_recuperado["cv"] != "") {
            if (file_exists("../empleados/cv" . $registro_recuperado["cv"])) {
                unlink("../empleados/cv" . $registro_recuperado["cv"]);
            }
        }
    }



    $idpuesto = (isset($_POST["idpuesto"]) ? $_POST["idpuesto"] : "");
    $txtID = (isset($_POST["txtID"]) ? $_POST["txtID"] : "");
    $fechadeingreso = (isset($_POST["fechadeingreso"]) ? $_POST["fechadeingreso"] : "");
    // Preparar la inserción de los datos
    $sentencia = $conexion->prepare("UPDATE `tbl_empleados` 
    SET primernombre=:primernombre, 
    segundonombre=:segundonombre, 
    primerapellido=:primerapellido,
    segundoapellido=:segundoapellido,
    foto=:foto,
    cv=:cv,
    idpuesto=:idpuesto,
    fechadeingreso=:fechadeingreso
    WHERE id=:id");
    // Asignamos los valores que vienen del metodo POST a la consulta
    $sentencia->bindValue(":primernombre", $primernombre);
    $sentencia->bindValue(":segundonombre", $segundonombre);
    $sentencia->bindValue(":primerapellido", $primerapellido);
    $sentencia->bindValue(":segundoapellido", $segundoapellido);

    $fecha_ = new DateTime();
    $nombreArchivo_foto = ($foto != '') ? $fecha_->getTimestamp() . "_" . $_FILES["foto"]['name'] : "";
    $tmp_foto = $_FILES["foto"]['tmp_name'];
    if ($tmp_foto != '') {
        move_uploaded_file($tmp_foto, "../empleados/fotos/" . $nombreArchivo_foto);
    }
    $sentencia->bindValue(":foto", $nombreArchivo_foto);

    $nombreArchivo_cv = ($cv != '') ? $fecha_->getTimestamp() . "_" . $_FILES["cv"]['name'] : "";
    $tmp_cv = $_FILES["cv"]['tmp_name'];
    if ($tmp_cv != '') {
        move_uploaded_file($tmp_cv, "../empleados/cv/" . $nombreArchivo_cv);
    }
    $sentencia->bindValue(":cv", $nombreArchivo_cv);

    $sentencia->bindValue(":idpuesto", $idpuesto);
    $sentencia->bindValue(":fechadeingreso", $fechadeingreso);
    $sentencia->bindValue(":id", $txtID);
    $sentencia->execute();
    header("Location:index.php?mensaje='Empleado editado correctamente'");
}
$sentencia = $conexion->prepare("SELECT * FROM `tbl_puestos`");
$sentencia->execute();
$lista_tbl_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
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
        Datos del empleado
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="txtID" class="form-label">ID:</label>
                <input type="text" class="form-control" name="txtID" id="txtID" aria-describedby="helpId"
                    value="<?php echo $txtID; ?>" placeholder="" readonly>

                <label for="primernombre" class="form-label">Primer Nombre</label>
                <input type="text" class="form-control" name="primernombre" id="primernombre" aria-describedby="helpId"
                    value="<?php echo $primernombre; ?>">

                <label for="segundonombre" class="form-label">Segundo Nombre</label>
                <input type="text" class="form-control" name="segundonombre" id="segundonombre"
                    aria-describedby="helpId" value="<?php echo $segundonombre; ?>">

                <label for="primerapellido" class="form-label">Primer Apellido</label>
                <input type="text" class="form-control" name="primerapellido" id="primerapellido"
                    aria-describedby="helpId" value="<?php echo $primerapellido; ?>">

                <label for="segundoapellido" class="form-label">Segundo Apellido</label>
                <input type="text" class="form-control" name="segundoapellido" id="segundoapellido"
                    aria-describedby="helpId" value="<?php echo $segundoapellido; ?>">
                <br>
                <label for="foto" class="form-label">Foto: </label>
                <img width="50" class="img-fluid rounded" src="../empleados/fotos/<?php echo $registro['foto']; ?>" />
                <input type="file" class="form-control" name="foto" id="foto" aria-describedby="helpId" value="">
                
                <label for="cv" class="form-label">CV</label>
                <a href="../empleados/cv/<?php echo $registro['cv']; ?>">CV</a>
                <input type="file" class="form-control" name="cv" id="cv" aria-describedby="helpId" value="">

                <div class="mb-3">
                    <label for="idpuesto" class="form-label">Puesto</label>
                    <select class="form-select form-select-lg" name="idpuesto" id="idpuesto">
                        <option selected>
                            <?php $idpuesto ?>
                        </option>
                        <?php foreach ($lista_tbl_puestos as $registro) {
                            if ($registro['id'] == $idpuesto) { ?>
                        <option selected value="<?php echo $registro['id'] ?>">
                            <?php echo $registro['nombredelpuesto'] ?>
                        </option>
                        <?php } else { ?>
                        <option value="<?php echo $registro['id'] ?>">
                            <?php echo $registro['nombredelpuesto'] ?>
                        </option>
                        <?php }
                        } ?>
                    </select>
                </div>

                <label for=" fechadeingreso" class="form-label">Fecha de ingreso</label>
                <input type="date" class="form-control" name="fechadeingreso" id="fechadeingreso"
                    aria-describedby="helpId" value="<?php echo $fechadeingreso; ?>">
            </div>

            <button type="submit" name="" id="" class="btn btn-primary" role="button">Modificar registro</button>
            <a name="" id="" class="btn btn-danger" href="./index.php" role="button">Cancelar</a>
        </form>
    </div>
</div>

<?php require_once("../../templates/footer.php") ?>