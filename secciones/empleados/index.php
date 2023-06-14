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
        if (file_exists("../empleados/fotos/" . $registro_recuperado["foto"])) {
            unlink("../empleados/fotos/" . $registro_recuperado["foto"]);
        }
    }
    if (isset($registro_recuperado["cv"]) && $registro_recuperado["cv"] != "") {
        if (file_exists("../empleados/cv/" . $registro_recuperado["cv"])) {
            unlink("../empleados/cv/" . $registro_recuperado["cv"]);
        }
    }

    $sentencia = $conexion->prepare("DELETE FROM `tbl_empleados` WHERE `id`=:id");
    // Asignamos los valores que vienen del metodo GET a la consulta
    $sentencia->bindValue(":id", $txtID);
    $sentencia->execute();
    header("Location:index.php?mensaje='Registro eliminado'");
}

$sentencia = $conexion->prepare("SELECT *,
    (SELECT nombredelpuesto 
    FROM `tbl_puestos`
    WHERE tbl_puestos.id=tbl_empleados.idpuesto
    LIMIT 1)  AS puesto
FROM `tbl_empleados`");
$sentencia->execute();
$lista_tbl_empleados = $sentencia->fetchAll(PDO::FETCH_ASSOC);

require_once("../../templates/header.php"); 
if (isset($_GET['mensaje'])) { ?>

<script>
    swal.fire({
        icon:"success", 
        title:"<?php echo $_GET['mensaje']; ?>"
        });
</script>
<?php } ?>
<h1>Empleados</h1>
<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="./crear.php" role="button">Agregar registro</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="tabla_id"><!--le pongo datatables-->
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
                            <img width="50" class="img-fluid rounded" src="../empleados/fotos/<?php echo $registro['foto'];?>" />
                        </td>
                        <td>
                            <a href="../empleados/cv/ <?php echo $registro['cv']; ?>">CV</a>

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
                                href="javascript:borrar(<?php echo $registro['id']; ?>);" role="button">Eliminar</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

</div>
<script>
    function borrar(id){
        Swal.fire({
    title: 'Desea borrar el empleado?',
    text: "No vas a poder recuperarlo si lo borras!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, Borralo!'
}).then((result) => {
    if (result.isConfirmed) {
        window.location="index.php?txtID=" + id;
        Swal.fire(
        'Borrado!',
        'El empleado ha sido borrado con exito.',
        'Correcto'
    )
    
    }
})}
</script>
<?php require_once("../../templates/footer.php") ?>