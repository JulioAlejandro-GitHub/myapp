<?php
require_once '../comun/config.php';
include_once '../comun/session.php';
require_once '../comun/BD.php';
require_once '../comun/utiles.php';

if ($_SESSION['USUARIO_TIPO'] != 'vendedor') {
    echo 'No autorizado';
    exit;
}

$CAT    = new Catalogo();

$id_vehiculo   = $_POST['id_vehiculo'];
$id_automotora = $_SESSION['AUTOMOTORA_ID_AUTOMOTORA'];

if ($id_vehiculo) {
    $updPublicar = $CAT->updDesPublicar($id_vehiculo, $id_automotora);
    if ($updPublicar) {
        echo "ok";
    }else{
        echo "error";
    }
}else{
    echo "error";
}
?>
