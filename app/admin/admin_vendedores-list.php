<?php
include_once '../comun/session.php';
require_once '../comun/class.admin.php';
require_once '../comun/BD.php';

if ($_SESSION['USUARIO_TIPO'] != 'vendedor') {
    echo 'No autorizado';
    exit;
}


$id_sucursal   = $_POST['id_sucursal'];
$id_automotora = $_SESSION['AUTOMOTORA_ID_AUTOMOTORA'];
$id_vendedor   = $_SESSION['VENDEDOR_ID_VENDEDOR'];
?>
<table width="1170">
    <tr>
        <th width="100">Rut</th>
        <th width="200">Nombre</th>
        <th width="100">Email</th>
        <th width="100">Dirección</th>
        <th width="100">Teléfono</th>
        <th width="100">Móvil</th>
        <th width="100">Acciones</th>
    </tr>
<? 
$Admin = new Admin();
$getVendedores = $Admin->getVendedores(array(
                    'AUTOMOTORA_ID_AUTOMOTORA'  => $id_sucursal,
                    'AUTOMOTORA_SUCURSAL'       => $id_automotora
               ));

$num_rows_Usuarios = $getVendedores->num_rows;
while($row = $getVendedores->fetch_assoc()) {
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

    $vendedor_id_vendedor       = $row['VENDEDOR_ID_VENDEDOR'];
    $vendedor_email             = $row['VENDEDOR_EMAIL'];
    $vendedor_nombre            = $row['VENDEDOR_NOMBRE'];
    $vendedor_apellido_paterno  = $row['VENDEDOR_APELLIDO_PATERNO'];
    $vendedor_apellido_materno  = $row['VENDEDOR_APELLIDO_MATERNO'];
    $vendedor_rut               = $row['VENDEDOR_RUT'];
    $vendedor_direccion         = $row['VENDEDOR_DIRECCION'];
    $vendedor_telefono          = $row['VENDEDOR_TELEFONO'];
    $vendedor_movil             = $row['VENDEDOR_MOVIL'];
    $vendedor_tipo              = $row['VENDEDOR_TIPO'];
    ?>
    <tr>
        <td><?=$vendedor_rut?></td>
        <td><?=$vendedor_nombre?></td>
        <td><?=$vendedor_email?></td>
        <td><?=$vendedor_direccion?></td>
        <td><?=$vendedor_telefono?></td>
        <td><?=$vendedor_movil?></td>
        <td>
            <? if ($id_vendedor != $vendedor_id_vendedor) { // no se elimine a sí mismo ?>
            <span style="cursor:pointer; float: right" onclick="admin.deleteVendedor({ id: '<?=$vendedor_id_vendedor?>', nombre: '<?=$vendedor_nombre?>', rut: '<?=$vendedor_rut?>'})" class="del_icn"></span>
            <? } ?>
            <span style="cursor:pointer; float: right" onclick="admin.editVendedorForm({ id: '<?=$vendedor_id_vendedor?>'})" class="edit_icn"></span>
        </td>
    </tr>
    <? } ?>
</table>