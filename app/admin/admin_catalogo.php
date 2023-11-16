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


$busq_marca        = $_GET['busq_marca'];
$busq_modelo       = $_GET['busq_modelo'];
$busq_tipo         = $_GET['busq_tipo'];
$busq_annio_desde  = $_GET['busq_annio_desde'];
$busq_annio_hasta  = $_GET['busq_annio_hasta'];
$busq_precio_desde = $_GET['busq_precio_desde'];
$busq_precio_hasta = $_GET['busq_precio_hasta'];
$busq_region       = $_GET['busq_region'];
$busq_ciudad       = $_GET['busq_ciudad'];
$busq_automotora   = $_SESSION['AUTOMOTORA_ID_AUTOMOTORA'];
$busq_usado        = $_GET['usado'];
$busq_nuevo        = $_GET['nuevo'];

$view              = $_GET['view'];



$_SESSION['busq_marca']        = $_GET['busq_marca'];
$_SESSION['busq_modelo']       = $_GET['busq_modelo'];
$_SESSION['busq_tipo']         = $_GET['busq_tipo'];
$_SESSION['busq_annio_desde']  = $_GET['busq_annio_desde'];
$_SESSION['busq_annio_hasta']  = $_GET['busq_annio_hasta'];
$_SESSION['busq_precio_desde'] = $_GET['busq_precio_desde'];
$_SESSION['busq_precio_hasta'] = $_GET['busq_precio_hasta'];
$_SESSION['busq_region']       = $_GET['busq_region'];
$_SESSION['busq_ciudad']       = $_GET['busq_ciudad'];
$_SESSION['busq_automotora']   = $_SESSION['AUTOMOTORA_ID_AUTOMOTORA'];
$_SESSION['usado']             = $_GET['usado'];
$_SESSION['nuevo']             = $_GET['nuevo'];
$_SESSION['view']              = $_GET['view'];

$_SESSION['pagina'] = 0;
$_SESSION['fichas_pagina'] = 16;


$getAutomotora = $CAT->getAutomotoras(array(
    'AUTOMOTORA_ID_AUTOMOTORA' => $busq_automotora,
    //'AUTOMOTORA_SUCURSAL'      => $busq_automotora        
));

$row_auto = $getAutomotora->fetch_assoc();

$automotora_id_matriz        = trim($row_auto['AUTOMOTORA_ID_MATRIZ']);
$automotora_id_automotora    = trim($row_auto['AUTOMOTORA_ID_AUTOMOTORA']);
$automotora_id_ciudad        = trim($row_auto['AUTOMOTORA_ID_CIUDAD']);
$automotora_rut              = trim($row_auto['AUTOMOTORA_RUT']);
$automotora_nombre           = trim($row_auto['AUTOMOTORA_NOMBRE']);
$automotora_telefono         = trim($row_auto['AUTOMOTORA_TELEFONO']);
$automotora_email            = trim($row_auto['AUTOMOTORA_EMAIL']);
$automotora_fax              = trim($row_auto['AUTOMOTORA_FAX']);
$automotora_razon_social     = trim($row_auto['AUTOMOTORA_RAZON_SOCIAL']);
$automotora_img              = trim($row_auto['AUTOMOTORA_IMG']);
$automotora_url              = trim($row_auto['AUTOMOTORA_URL']);     
$automotora_direccion        = trim($row_auto['AUTOMOTORA_DIRECCION']);
$automotora_numero           = trim($row_auto['AUTOMOTORA_NUMERO']);
$automotora_horario_lun_vie  = trim($row_auto['AUTOMOTORA_HORARIO_LUN_VIE']);
$automotora_horario_sab      = trim($row_auto['AUTOMOTORA_HORARIO_SAB']); 
$automotora_horario_dom      = trim($row_auto['AUTOMOTORA_HORARIO_DOM']);   
$automotora_estado           = trim($row_auto['AUTOMOTORA_ESTADO']);
$automotora_fec_ingreso      = trim($row_auto['AUTOMOTORA_FECHA_INGRESO']);
$automotora_fec_modificacion = trim($row_auto['AUTOMOTORA_FECHA_MODIFICACION']);

$automotora_horario = "";
if ($automotora_horario_lun_vie){ 
    $automotora_horario .= "Lunes a Viernes (".$automotora_horario_lun_vie.")"; 
}
if ($automotora_horario_sab){ 
    $automotora_horario .= " / Sábado (".$automotora_horario_sab.")"; 
}
if ($automotora_horario_dom){ 
    $automotora_horario .= " / Domingo (".$automotora_horario_dom.")"; 
}

if ($automotora_direccion == '') { $automotora_direccion = '&nbsp;'; }
if ($automotora_telefono  == '') { $automotora_telefono  = '&nbsp;'; }
if ($automotora_email     == '') { $automotora_email     = '&nbsp;'; }
if ($automotora_url       == '') { $automotora_url       = '&nbsp;'; }
if ($automotora_horario   == '') { $automotora_horario   = '&nbsp;'; }

$ruta_400x300 = PATH_CATALOG_IMG.'img/catalog/'.$automotora_id_automotora.'/';
$ruta_80x60   = PATH_CATALOG_IMG.'img/catalog/'.$automotora_id_automotora.'/thumbnails/';
$ruta_215     = PATH_CATALOG_IMG.'img/catalog/'.$automotora_id_automotora.'/thumbnails/215/';
$ruta_125     = PATH_CATALOG_IMG.'img/catalog/'.$automotora_id_automotora.'/thumbnails/125/';

$automotora_logo = $automotora_img ? "include/img/logos/".$automotora_img.'?'.time() : "include/img/logo_150x150.png";
?>
<aside class="list lft cf" id="contenedor_admin_catalogo">
        <div class="dealerheader">
            <div class="logot"><img width="150" height="150" src="<?=$automotora_logo?>" class="sucursal-logo-big"></div>
            <h2><?=$automotora_nombre?></h2>
            <div class="dealer_info">
                <ul>
                    <li class="place"><a href="#"><?=$automotora_direccion?></a></li>
                    <li class="phone"><?=$automotora_telefono?></li>
                    <li class="mail"><a href="#"><?=$automotora_email?></a></li>
                    <li class="web"><a href="#"><?=$automotora_url?></a></li>
                    <li class="hour"><?=$automotora_horario?></li>
                </ul>
                <button class="fichabtn" style="position: relative; top: -55px; left: 620px" onclick="add_ficha();">Agregar vehículo</button>
            </div>
        </div>
    
    <div class="scroll">
    <?
    include 'admin_catalogo_min.php';
    ?>
    </div>
    
    
<script>
$('.scroll').jscroll({
    debug: true,
    loadingHtml: '<img src="include/img/ajax-loader.gif" alt="Loading" /> Loading...',
    padding: 0,
    autoTrigger : false
});
</script>
    
    <? if (!$num_rows_Listado) { ?>
        <p>No se han encontrado resultados para la búsqueda</p>
    <? } ?>
    
    
</aside>