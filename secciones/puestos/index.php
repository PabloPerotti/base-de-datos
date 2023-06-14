<?php
require_once "../../bd.php";

if (isset($_GET["txtID"])) {
    $txtID = (isset($_GET["txtID"]) ? $_GET["txtID"] : '');
    $sentencia = $conexion->prepare("DELETE FROM `tbl_puestos` WHERE `id`=:id");
    $sentencia->bindValue(":id", $txtID);
    $sentencia->execute();
    header("location:index.php?mensaje='Puesto eliminado Correctamente'");
}
$sentencia = $conexion->prepare("SELECT * FROM `tbl_puestos`");
$sentencia->execute();
$lista_tbl_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

?>
<?php
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
<h1>Puestos</h1>
<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="./crear.php" role="button">Agregar Registro</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre del Puesto</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_tbl_puestos as $registro) { ?>
                        <tr class="">
                            <td scope="row"><?php echo $registro['id']; ?></td>
                            <td><?php echo $registro['nombredelpuesto']; ?></td>
                            <td>
                                <a name="" id="" class="btn btn-info" href="editar.php?txtID=<?php echo $registro['id']; ?>" role="button">Editar</a>
                                <a name="" id="" class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id']; ?>);" role="button">Eliminar</a>
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
    title: 'Desea borrar el puesto?',
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
        'El puesto ha sido borrado con exito.',
        'Correcto'
    )
    
    }
})}
</script>
<?php require_once("../../templates/footer.php") ?>