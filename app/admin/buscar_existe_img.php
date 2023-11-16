<?php
/*****************************************************************/
include_once('../comun/session.php');
require_once '../comun/BD.php';
require_once '../comun/utiles.php';
//require_once '../comun/Logger.php';
/*****************************************************************/
$CAT    = new Catalogo();
//$Logger = new Logger(LOG_NOMBRE);
/*****************************************************************/


// buscar si existe imagen o es recien subida.. la diferencia es "tmp__"



$id          = trim($_POST[id]);
$id_vehiculo = trim($_POST['id_vehiculo']);


list ($img_400, $img_80) = get_temo_or_img($_SESSION['ID_AUTOMOTORA'], $_SESSION['AUTOMOTORA_RUT'], $id, $id_vehiculo);

echo $img_400.'|'.$img_80;
?>