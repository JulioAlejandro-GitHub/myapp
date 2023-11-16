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

$delFicha = $CAT->delFicha($id_vehiculo, $id_automotora);

if ($delFicha) {
    echo "ok";
}else{
    echo "error";
}
?>