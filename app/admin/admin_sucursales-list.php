<?php
include_once '../comun/session.php';
require_once '../comun/class.admin.php';
require_once '../comun/BD.php';

if ($_SESSION['USUARIO_TIPO'] != 'vendedor') {
    echo 'No autorizado';
    exit;
}


$id_region   = $_POST['id_region'];
$id_ciudad   = $_POST['id_ciudad'];
$id_automotora = $_SESSION['AUTOMOTORA_ID_AUTOMOTORA'];
?>
<table width="1170">
    <tr>
        <th width="100">Rut</th>
        <th width="200">Nombre</th>
        <th width="100">Ciudad</th>
        <th width="100">Región</th>
        <th width="150">Email</th>
        <th width="100">Fono</th>
        <th width="60">Acciones</th>
    </tr>
<? 
$Admin = new Admin();

$id_automotora = $_SESSION['AUTOMOTORA_ID_AUTOMOTORA'];
$id_vendedor   = $_SESSION['VENDEDOR_ID_VENDEDOR'];

$getSucursales = $Admin->getSucursales(array(
                    'AUTOMOTORA_SUCURSAL'  => $id_automotora,
                    'REGION_ID_REGION'     => $id_region,
                    'CIUDAD_ID_CIUDAD'     => $id_ciudad
               ));

$num_rows_Sucursales = $getSucursales->num_rows;

while($row = $getSucursales->fetch_assoc()) {
    $automotora_id_automotora       = trim($row['AUTOMOTORA_ID_AUTOMOTORA']);
    $automotora_id_matriz           = trim($row['AUTOMOTORA_ID_MATRIZ']);
    $automotora_id_ciudad           = trim($row['AUTOMOTORA_ID_CIUDAD']);
    $automotora_rut                 = trim($row['AUTOMOTORA_RUT']);
    $automotora_nombre              = trim($row['AUTOMOTORA_NOMBRE']);
    $automotora_fono                = trim($row['AUTOMOTORA_TELEFONO']);
    $automotora_email               = trim($row['AUTOMOTORA_EMAIL']);
    $automotora_fax                 = trim($row['AUTOMOTORA_FAX']);
    $automotora_razon               = trim($row['AUTOMOTORA_RAZON_SOCIAL']);
    $automotora_img                 = trim($row['AUTOMOTORA_IMG']);
    $automotora_url                 = trim($row['AUTOMOTORA_URL']);    
    $automotora_direccion           = trim($row['AUTOMOTORA_DIRECCION']);
    $automotora_numero              = trim($row['AUTOMOTORA_NUMERO']);
    $automotora_horario_lun_vie     = trim($row['AUTOMOTORA_HORARIO_LUN_VIE']);
    $automotora_horario_sab         = trim($row['AUTOMOTORA_HORARIO_SAB']);
    $automotora_horario_dom         = trim($row['AUTOMOTORA_HORARIO_DOM']);  
    $automotora_estado              = trim($row['AUTOMOTORA_ESTADO']);
    $automotora_fecha_ingreso       = trim($row['AUTOMOTORA_FECHA_INGRESO']);
    $automotora_fecha_modificacion  = trim($row['AUTOMOTORA_FECHA_MODIFICACION']);

    $ciudad_id_ciudad   = $row['CIUDAD_ID_CIUDAD'];
    $ciudad_nombre      = $row['CIUDAD_NOMBRE'];
    $region_id_region   = $row['REGION_ID_REGION'];
    $region_nombre      = $row['REGION_NOMBRE'];
    $region_orden       = $row['REGION_ORDEN'];
    $pais_nombre        = $row['PAIS_NOMBRE'];
    ?>
    <tr>
        <td><?=$automotora_rut?></td>
        <td><?=$automotora_nombre?></td>
        <td><?=$ciudad_nombre?></td>
        <td><?=$region_nombre?></td>
        <td><?=$automotora_email?></td>
        <td><?=$automotora_fono?></td>
        <td>
            <? if ($id_automotora != $automotora_id_automotora) { // no se elimine a sí mismo ?>
            <span style="cursor:pointer; float: right" onclick="admin.deleteSucursal({ id: '<?=$automotora_id_automotora?>', nombre: '<?=$automotora_nombre?>', rut: '<?=$automotora_rut?>'})" class="del_icn"></span>
            <? } ?>                
            <span style="cursor:pointer; float: right" onclick="admin.editSucursalForm({ id : '<?=$automotora_id_automotora?>'})" class="edit_icn"></span>
        </td>
    </tr>
    <? } ?>
</table>