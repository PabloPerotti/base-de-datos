<?php require_once("../../templates/header.php") ?>
<?php
require_once "../../bd.php";

if (isset($_GET["txtID"])) {
    $txtID = (isset($_GET["txtID"]) ? $_GET["txtID"] : '');

    $sentencia = $conexion->prepare("SELECT * FROM `tbl_empleados` WHERE id=:id ");
    $sentencia->bindValue(":id", $txtID);

    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    $primernombre = $registro['primernombre'];
    $segundonombre = $registro['segundonombre'];
    $primerapellidoido = $registro['primerapellido'];
    $segundoapellido = $registro['segundoapellido'];
    $foto = $registro['foto'];
    $cv = $registro['cv'];
    $puesto = $registro['puesto'];
    $fechadeingreso = $registro['fechadeingreso'];
}

if ($_POST) {
    $txtID = (isset($_POST["txtID"]) ? $_POST["txtID"] : '');
    $primernombre = (isset($_POST["primernombre"]) ? $_POST["primernombre"] : '');
    $segundonombre = (isset($_POST["segundonombre"]) ? $_POST["segundonombre"] : '');
    $primerapellido = (isset($_POST["primerapellido"]) ? $_POST["primerapellido"] : '');
    $segundoapellido = (isset($_POST["segundoapellido"]) ? $_POST["segundoapellido"] : '');
    $foto = (isset($_POST["foto"]) ? $_POST["foto"] : '');
    $cv = (isset($_POST["cv"]) ? $_POST["cv"] : '');
    $puesto = (isset($_POST["puesto"]) ? $_POST["puesto"] : '');
    $fechadeingreso = (isset($_POST["fechadeingreso"]) ? $_POST["fechadeingreso"] : '');

    $sentencia = $conexion->prepare("UPDATE `tbl_empleados`
                                    SET `primernombre`=:primernombre, `segundonombre`=:segundonombre, `primerapellido`=:primerapellido,`segundoapellido`=:segundoapellido,
                                    `foto`=:foto, `cv`=:cv, `puesto`=:puesto, `fechadeingreso`=:fechadeingreso
                                    WHERE id=:id");

    $sentencia->bindValue(":primerapellido", $primerapellido);
    $sentencia->bindValue(":segundoapellido", $segundoapellido);
    $sentencia->bindValue(":primerapellido", $primerapellido);
    $sentencia->bindValue(":segundoapellido", $segundoapellido);
    $sentencia->bindValue(":foto", $foto);
    $sentencia->bindValue(":cv", $cv);
    $sentencia->bindValue(":puesto", $puesto);
    $sentencia->bindValue(":fechadeingreso", $fechadeingreso);
    $sentencia->execute();
    header("location:index.php");
}
?>
<br>
<div class="card">
    <div class="card-header">
        Modificar Registro del empleado
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
                            <option value="<?php echo $registro['id'] ?>"><?php echo $registro['nombredelpuesto'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <label for="fechadeingreso" class="form-label">Fecha de Ingreso</label>
                <input type="date" class="form-control" name="fechadeingreso" id="fechadeingreso" aria-describedby="helpId" placeholder="">


            </div>
            <button type="submit" name="" id="" class="btn btn-primary" role="button">Modificar Registro</button>
            <a name="" id="" class="btn btn-danger" href="./index.php" role="button">Cancelar</a>
        </form>
    </div>
</div>
<?php require_once("../../templates/footer.php") ?>