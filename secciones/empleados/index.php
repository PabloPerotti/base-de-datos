<?php
require_once("../../bd.php");

if (isset($_GET["txtID"])) { // lógica para eliminar un empleado
    // Recolectar los datos del metodo GET
    $txtID = (isset($_GET["txtID"]) ? $_GET["txtID"] : "");
    // Preparar la eliminación de la foto y el CV
    $sentencia = $conexion->prepare("SELECT foto,cv FROM `tbl_empleados` WHERE `id`=:id");
    $sentencia->bindValue(":id", $txtID);
    $sentencia->execute();
    $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);
    if (isset($registro_recuperado["foto"]) && $registro_recuperado["foto"] != "") {
        if (file_exists("./img/" . $registro_recuperado["foto"])) {
            unlink("./img/" . $registro_recuperado["foto"]);
        }
    }
    if (isset($registro_recuperado["cv"]) && $registro_recuperado["cv"] != "") {
        if (file_exists("./cv/" . $registro_recuperado["cv"])) {
            unlink("./cv/" . $registro_recuperado["cv"]);
        }
    }

    $sentencia = $conexion->prepare("DELETE FROM `tbl_empleados` WHERE `id`=:id");
    // Asignamos los valores que vienen del metodo GET a la consulta
    $sentencia->bindValue(":id", $txtID);
    $sentencia->execute();
    header("Location:index.php");
}

$sentencia = $conexion->prepare("SELECT *,
    (SELECT nombredelpuesto 
    FROM `tbl_puestos`
    WHERE tbl_puestos.id=tbl_empleados.idpuesto
    LIMIT 1)  AS puesto
FROM `tbl_empleados`");
$sentencia->execute();
$lista_tbl_empleados = $sentencia->fetchAll(PDO::FETCH_ASSOC);

require_once("../../templates/header.php") ?>
<h1>Empleados</h1>
<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="./crear.php" role="button">Agregar registro</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th><!-- 1er y 2do nombre y 1er y 2do apellido -->
                        <th scope="col">Foto</th>
                        <th scope="col">CV</th>
                        <th scope="col">Puesto</th>
                        <th scope="col">Fecha de Ingreso</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_tbl_empleados as $registro) { ?>
                    <tr class="">
                        <td scope="row">
                            <?php echo $registro['id']; ?>
                        </td>
                        <td>
                            <?php echo $registro['primernombre']; ?>
                            <?php echo $registro['segundonombre']; ?>
                            <?php echo $registro['primerapellido']; ?>
                            <?php echo $registro['segundoapellido']; ?>
                        </td>
                        <td>
                            <img width="50" class="img-fluid rounded" src="./img/<?php echo $registro['foto']; ?>" />
                        </td>
                        <td>
                            <a href="./cv/<?php echo $registro['cv']; ?>">CV</a>

                        </td>
                        <td>
                            <?php echo $registro['puesto']; ?>
                        </td>
                        <td>
                            <?php echo $registro['fechadeingreso']; ?>
                        </td>
                        <td>
                            <a name="" id="" class=" btn btn-primary" href="carta_recomendacion.php?txtID=<?php echo $registro['id']; ?>" 
                                role="button">Carta</a>
                            <a name="" id="" class="btn btn-info" href="editar.php?txtID=<?php echo $registro['id']; ?>"
                                role="button">Editar</a>
                            <a name="" id="" class="btn btn-danger"
                                href="index.php?txtID=<?php echo $registro['id']; ?>" role="button">Eliminar</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

</div>
<?php require_once("../../templates/footer.php") ?>