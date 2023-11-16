<?php
include_once '../comun/session.php';
require_once '../comun/class.admin.php';
require_once '../comun/BD.php';

if ($_SESSION['USUARIO_TIPO'] != 'vendedor') {
    echo 'No autorizado';
    exit;
}

$CAT    = new Catalogo();
$Admin  = new Admin();

$id_sucursal = $_GET['id_sucursal'];

$getSucursales = $Admin->getSucursales(array(
                    'AUTOMOTORA_ID_AUTOMOTORA'  => $id_sucursal
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
    $automotora_mapa                = trim($row['AUTOMOTORA_MAPA']);
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
}

$automotora_logo = $automotora_img ? "include/img/logos/".$automotora_img.'?'.time() : "include/img/logo_150x150.png";

$automotora_map_latlng = explode(',', $automotora_mapa);
$automotora_map_lat    = $automotora_mapa ? $automotora_map_latlng[0] : -33.4370047647916;
$automotora_map_lng    = $automotora_mapa ? $automotora_map_latlng[1] : -70.63440598547459;
$automotora_zoom       = $automotora_mapa ? 15 : 4;
$automotora_marker     = $automotora_mapa ? true : false;
?>
<script>
    var search_admin = new Search({
        path             : '',
        region           : $("#sucursal-region"),      
        ciudad           : $("#sucursal-ciudad")
    });
</script>

<script>
function googleMap(params) {
    var param_container   = params.container;
    var param_icon        = params.icon;
    var param_lat         = params.lat;
    var param_lng         = params.lng;

    var mapProp = {
        center    : new google.maps.LatLng(param_lat, param_lng),
        zoom      : <?=$automotora_zoom?>,
        mapTypeId : google.maps.MapTypeId.ROADMAP
    };

    var map = new google.maps.Map(document.getElementById($(param_container).attr("id")), mapProp);

    var marker = new google.maps.Marker({
        <? if ($automotora_marker) { ?>
        position : new google.maps.LatLng(param_lat, param_lng),
        <? } ?>
        map      : map,
        icon     : param_icon
    });

    google.maps.event.addListener(map, 'tilesloaded', function() {
        if (!tilesloaded) {
            tilesloaded++;
            google.maps.event.trigger(map, 'resize');
            map.setCenter(mapProp.center);
        }            
    });

    google.maps.event.addListener(map, 'zoom_changed', function() {
    });

    google.maps.event.addListener(map, 'click', function(event) {
        marker.setMap(null);    
        marker = new google.maps.Marker({
            map      : map,
            position : event.latLng,
            icon     : param_icon
        });           
        
        google.maps.event.addListener(marker, 'click', function() {
            marker.setMap(null);   
            $("#sucursal-map").val('');
        });         
        
        $("#sucursal-map").val(event.latLng.lat()+","+event.latLng.lng());
    }); 
    
    google.maps.event.addListener(marker, 'click', function() {
        marker.setMap(null);   
        $("#sucursal-map").val('');
    });             
}

var marker;

var tilesloaded = 0;

var googleMap = googleMap({
    container : $("#map_canvas"),
    lat       : '<?=$automotora_map_lat?>',
    lng       : '<?=$automotora_map_lng?>',
    icon      : 'include/img/map_icon.png'            
});    

google.maps.event.addDomListener(window, 'load', googleMap);
</script>

<style>
     #form-edit-sucursal {
        width: 500px;
    }
    
    .admin-edit-sucursal{
        font-family:Verdana;
        font-size:13px;
        width: 300px;
    }
</style>

<form id="form-edit-sucursal" action="app/admin/admin-request.php" enctype="multipart/form-data" method="POST">
<div class="admin-edit-sucursal">
    <p><b>Editar Sucursal</b></p><br/>

    <span>Rut</span>
    <p><input type="text" id="sucursal-rut" value="<?=$automotora_rut?>"><p/>
    <p><input type="hidden" id="sucursal-rut-antiguo" value="<?=$automotora_rut?>"><p/>

    <span>Nombre</span>
    <p><input type="text" id="sucursal-nombre" value="<?=$automotora_nombre?>"><p/>

    <span>Teléfono</span>
    <p><input type="text" id="sucursal-telefono" value="<?=$automotora_fono?>"><p/>

    <span>Email</span>
    <p><input type="text" id="sucursal-email" value="<?=$automotora_email?>"><p/>

    <span>Fax</span>
    <p><input type="text" id="sucursal-fax" value="<?=$automotora_fax?>"><p/>

    <span>Razón social</span>
    <p><input type="text" id="sucursal-razonsocial" value="<?=$automotora_razon?>"><p/>

    <span>Logo</span>
    <p><input type="file" id="sucursal-logo" name="logo" onchange="
        admin.createPreviewImage({ 
            input       : this, 
            preview     : $('#sucursal-logo-preview'), 
            cancel      : $('#sucursal-logo-cancel'),
            default_img : '<?=$automotora_logo?>' 
        });
    "><p/>
    <img id="sucursal-logo-preview" src="<?=$automotora_logo?>">
    <br/>
    <span id="sucursal-logo-cancel" style="display: none"><input type="checkbox" id="sucursal-logo-cancel-chk" name="logo_chk" onchange="
        admin.deletePreviewImage({
            input       : $('#sucursal-logo'), 
            preview     : $('#sucursal-logo-preview'), 
            cancel      : $('#sucursal-logo-cancel'), 
            cancel_chk  : $('#sucursal-logo-cancel-chk'), 
            default_img : '<?=$automotora_logo?>' 
        });
    "> Quitar imagen</span>
    <br/><br/>

    <span>Mapa</span>
    <div id="map">
        <div id="map_canvas" style="height:230px;width:400px;"></div>
    </div>    
    <p><input type="hidden" id="sucursal-map" value="<?=$automotora_mapa?>"><p/>
    
    <span>Sitio web</span>
    <p><input type="text" id="sucursal-url" value="<?=$automotora_url?>"><p/>

    <span>Dirección</span>
    <p><input type="text" id="sucursal-direccion" value="<?=$automotora_direccion?>"><p/>

    <span>
        <label>Región</label>
        <p>
        <select id="sucursal-region" onchange="search_admin.getCiudades()">
            <option value="">.:: TODAS ::.</option>
            <?
            $getRegiones = $CAT->getRegiones(
                                    array(
                                        'REGION_ID_PAIS' => 'CL'                    
                                    )
                                );

            while($row = $getRegiones->fetch_assoc()) { ?>
                <option value="<?=$row['REGION_ID_REGION']?>" <?=$row['REGION_ID_REGION'] == $region_id_region ? "selected" : ""?>><?=mb_strtoupper($row['REGION_NOMBRE'])?></option>
            <? } ?>
        </select>
        </p>
    </span>
    <br/>

    <span>
        <label>Ciudad</label>
        <p>
        <select id="sucursal-ciudad">
            <option value="">.:: TODAS ::.</option>
            <?
            $getCiudades = $CAT->getCiudades(
                                    array(
                                        'CIUDAD_ID_PAIS' => 'CL'                    
                                    )
                                );

            while($row = $getCiudades->fetch_assoc()) { ?>
                <option class="search-dynamic" value="<?=$row['CIUDAD_ID_CIUDAD']?>" <?=$row['CIUDAD_ID_CIUDAD'] == $ciudad_id_ciudad ? "selected" : ""?>><?=mb_strtoupper($row['CIUDAD_NOMBRE'])?></option>
            <? } ?>
        </select>
        </p>
    </span>
    <br/>

    <span>Horario Lunes a Viernes</span>
    <p><input type="text" id="sucursal-horario-lunvie" value="<?=$automotora_horario_lun_vie?>"><p/>

    <span>Horario Sábado</span>
    <p><input type="text" id="sucursal-horario-sab" value="<?=$automotora_horario_sab?>"><p/>

    <span>Horario Domingo</span>
    <p><input type="text" id="sucursal-horario-dom" value="<?=$automotora_horario_dom?>"><p/>
</div>

    
<div id="sucursal-submit-loader"></div>
<span class="btn rgt" onclick="admin.editSucursal({ id: <?=$id_sucursal?>})">Editar</span>
<span class="btn rgt" onclick="$.fancybox.close()">Cancelar</span>
</form>