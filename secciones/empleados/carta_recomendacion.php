<?php

require_once('../../bd.php');

if (isset($_GET["txtID"])) {
    // Recolectar los datos del metodo GET
    $txtID = (isset($_GET["txtID"]) ? $_GET["txtID"] : "");
    // Preparar la edición de los datos
    $sentencia = $conexion->prepare("SELECT *,
    (SELECT nombredelpuesto 
    FROM `tbl_puestos`
    WHERE tbl_puestos.id=tbl_empleados.idpuesto
    LIMIT 1)  AS puesto FROM `tbl_empleados` WHERE id=:id");
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
    $puesto = $registro['puesto'];
    $fechadeingreso = $registro['fechadeingreso'];
    $NombreCompleto = "$primernombre $segundonombre, $primerapellido $segundoapellido";
}
$fechaInicio = new DateTime($fechadeingreso);
$fechaActual = new DateTime(date('Y-m-d'));
$diferencia = date_diff($fechaInicio, $fechaActual);
ob_start();
?>
<!doctype html>
<html lang="en">

<head>
    <title>Carta de recomendacion</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<body>
    <h1>Carta de recomendacion laboral</h1>
    <br><br>
    <p>Buenos Aires, Argentina a los <strong>
            <?php echo date('d M Y') ?>
        </strong>
    </p>
    <br><br>
    <p>A quien pueda interesar:</p>
    <br><br>
    <p>Reciba un cordial y respetuoso saludo</p>
    <br><br>
    <p>A traves de estas lineas deseo hacer de su conocimiento que el Sr/a
        <strong>
            <?php echo $NombreCompleto ?>
        </strong>
        quien trabajo en mi organización durante <strong>
            <?php echo $diferencia->y ?> años
        </strong> es un ciudadano con una
        conducta intachable. Ha
        demostrado ser un gran trabajador, comprometido, responsable y fiel cumplidor de tareas.
    </p>
    <p>
        Durante estos años se ha desempeñado como: <strong>
            <?php echo $puesto ?>
        </strong>Es por ello que le sugiero considere esta
        recomendación con la confianza de que estará siempre a la altura de los desafios
    </p>
    <p> Sin mas nada a que referirme, dejo mi numero de contacto: 3883104925</p>
    <br><br>
    <p>atentamente,</p>
    <br><br>
    <p>Ing. Fabio D. Argañaraz</p>
</body>

</html>
<?php
$HTML = ob_get_clean();
require_once('../../libs/autoload.inc.php');
use Dompdf\Dompdf;

$dompdf = new Dompdf();

$opciones = $dompdf->getOptions();
$opciones->set(array("isRemoteEnabled" => true));
$dompdf->setOptions($opciones);
$dompdf->loadHTML($HTML);
$dompdf->setPaper('letter');
$dompdf->render();
$dompdf->stream("CartaRecomendación", array("Attachment" => false));
?>