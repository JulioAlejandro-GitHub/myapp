<?php
include_once '../comun/session.php';
require_once '../comun/Logger.php';
require_once '../comun/BD.php';
require_once '../comun/utiles.php';

$CAT    = new Catalogo();
$Logger = new Logger(LOG_NOMBRE);

/*****************************************************************/
$ruta_include = "include/";

if ($_SESSION['USUARIO_TIPO'] != 'vendedor') {
    echo 'No autorizado';
    exit;
}


/*****************************************************************/
$id_vehiculo = trim($_GET[id]);

$Logger->write_log('***********************************');
$Logger->write_log('Editar Ficha --> ['.$id_vehiculo.']');
$Logger->write_log('***********************************');

/*****************************************************************/
$getFicha = $CAT->getListado(array(
                'VEHICULO_ID_VEHICULO' => $id_vehiculo
            ));
$row      = $getFicha->fetch_assoc();
$num_rows = $CAT->affected_rows;

$Logger->write_log('             <-- num_rows ['.$num_rows.']');



$automotora_id_automotora       = trim($row['AUTOMOTORA_ID_AUTOMOTORA']);
$automotora_id_matriz           = trim($row['AUTOMOTORA_ID_MATRIZ']);
$automotora_id_ciudad           = trim($row['AUTOMOTORA_ID_CIUDAD']);
$automotora_rut                 = trim($row['AUTOMOTORA_RUT']);
$automotora_nombre              = trim($row['AUTOMOTORA_NOMBRE']);
$automotora_telefono            = trim($row['AUTOMOTORA_TELEFONO']);
$automotora_email               = trim($row['AUTOMOTORA_EMAIL']);
$automotora_fax                 = trim($row['AUTOMOTORA_FAX']);
$automotora_razon_social        = trim($row['AUTOMOTORA_RAZON_SOCIAL']);
$automotora_img                 = trim($row['AUTOMOTORA_IMG']);
$automotora_url                 = trim($row['AUTOMOTORA_URL']);    
$automotora_direccion           = trim($row['AUTOMOTORA_DIRECCION']);
$automotora_numero              = trim($row['AUTOMOTORA_NUMERO']);
$automotora_horario_lun_vie     = trim($row['AUTOMOTORA_HORARIO_LUN_VIE']);
$automotora_horario_sab         = trim($row['AUTOMOTORA_HORARIO_SAB']);
$automotora_horario_dom         = trim($row['AUTOMOTORA_HORARIO_DOM']);  
$automotora_mapa                = trim($row['AUTOMOTORA_MAPA']);  
$automotora_mapa_array          = explode(",", $automotora_mapa);
$automotora_lat                 = $automotora_mapa_array[0];  
$automotora_lng                 = $automotora_mapa_array[1];  
$automotora_estado              = trim($row['AUTOMOTORA_ESTADO']);
$automotora_fecha_ingreso       = trim($row['AUTOMOTORA_FECHA_INGRESO']);
$automotora_fecha_modificacion  = trim($row['AUTOMOTORA_FECHA_MODIFICACION']);

$carroceria_id_carroceria  = $row['CARROCERIA_ID_CARROCERIA'];
$carroceria_nombre         = $row['CARROCERIA_NOMBRE'];

$vendedor_id_automotora         = trim($row['VENDEDOR_ID_AUTOMOTORA']);
$vendedor_id_vendedor           = trim($row['VENDEDOR_ID_VENDEDOR']);
$vendedor_nombres               = trim($row['VENDEDOR_NOMBRE']);
$vendedor_apellido_paterno      = trim($row['VENDEDOR_APELLIDO_PATERNO']);
$vendedor_apellido_materno      = trim($row['VENDEDOR_APELLIDO_MATERNO']);
$vendedor_rut                   = trim($row['VENDEDOR_RUT']);
$vendedor_email                 = trim($row['VENDEDOR_EMAIL']);
$vendedor_password              = trim($row['VENDEDOR_PASSWORD']);
$vendedor_telefono              = trim($row['VENDEDOR_TELEFONO']);
$vendedor_movil                 = trim($row['VENDEDOR_MOVIL']);
$vendedor_direccion             = trim($row['VENDEDOR_DIRECCION']);
$vendedor_fecha_ingreso         = trim($row['VENDEDOR_FECHA_INGRESO']);
$vendedor_fecha_modificacion    = trim($row['VENDEDOR_FECHA_MODIFICACION']);
$vendedor_tipo                  = trim($row['VENDEDOR_TIPO']);

$vehiculo_id_vehiculo           = trim($row['VEHICULO_ID_VEHICULO']);
$vehiculo_id_marca              = trim($row['VEHICULO_ID_MARCA']);
$vehiculo_id_vendedor           = trim($row['VEHICULO_ID_VENDEDOR']);
$vehiculo_id_ciudad             = trim($row['VEHICULO_ID_CIUDAD']);
$vehiculo_modelo                = trim($row['VEHICULO_MODELO']);
$vehiculo_patente               = trim($row['VEHICULO_PATENTE']);
$vehiculo_annio                 = trim($row['VEHICULO_ANNIO']);
$vehiculo_kilometros            = trim($row['VEHICULO_KILOMETROS']);
$vehiculo_precio                = trim($row['VEHICULO_PRECIO']);
$vehiculo_descripcion           = trim($row['VEHICULO_DESCRIPCION']);
$vehiculo_fecha_publicacion     = trim($row['VEHICULO_FECHA_PUBLICACION']);
$vehiculo_fecha_modificacion    = trim($row['VEHICULO_FECHA_MODIFICACION']);
$vehiculo_estado                = trim($row['VEHICULO_ESTADO']);

        $VEHICULO_IMG1             = trim($row['VEHICULO_IMG1']);
        $VEHICULO_IMG2             = trim($row['VEHICULO_IMG2']);
        $VEHICULO_IMG3             = trim($row['VEHICULO_IMG3']);
        $VEHICULO_IMG4             = trim($row['VEHICULO_IMG4']);
        $VEHICULO_IMG5             = trim($row['VEHICULO_IMG5']);

$id_carroceria              = trim($row['CARROCERIA_ID_CARROCERIA']);
$carroceria_nombre          = trim($row['CARROCERIA_NOMBRE']);
$carroceria_descripcion     = trim($row['CARROCERIA_DESCRIPCION']);

$marca_id_marca     = trim($row['MARCA_ID_MARCA']);
$marca_id_pais      = trim($row['MARCA_ID_PAIS']);
$marca_nombre       = trim($row['MARCA_NOMBRE']);
$modelo_nombre      = trim($row['MODELO_NOMBRE']);
$modelo_id_modelo   = trim($row['MODELO_ID_MODELO']);

        
$pais_id_pais        = trim($row['PAIS_ID_PAIS']);
$pais_nombre         = trim($row['PAIS_NOMBRE']);
$region_id_region    = trim($row['REGION_ID_REGION']);
$region_nombre       = trim($row['REGION_NOMBRE']);
$region_nregion      = trim($row['REGION_NREGION']);
$ciudad_id_ciudad    = trim($row['CIUDAD_ID_CIUDAD']);
$ciudad_nombre       = trim($row['CIUDAD_NOMBRE']);

if ($automotora_direccion == '') { $automotora_direccion = '&nbsp;'; }
if ($automotora_telefono  == '') { $automotora_telefono  = '&nbsp;'; }
if ($automotora_email     == '') { $automotora_email     = '&nbsp;'; }
if ($automotora_url       == '') { $automotora_url       = '&nbsp;'; }

$auto_horario = "";
if ($automotora_horario_lun_vie){ 
    $auto_horario .= "Lunes a Viernes (".$automotora_horario_lun_vie.")"; 
}
if ($automotora_horario_sab){ 
    $auto_horario .= " <br> Sábado (".$automotora_horario_sab.")"; 
}
if ($automotora_horario_dom){ 
    $auto_horario .= " <br> Domingo (".$automotora_horario_dom.")"; 
}

    $getAtributos = $CAT->getAtributos(array(
        'VEHICULO_ID_VEHICULO' => $vehiculo_id_vehiculo
    ));
    while($row_atrib = $getAtributos->fetch_assoc()) {
        $id_atributo      = trim($row_atrib['ATRIBUTO_ID_ATRIBUTO']);
        $nombre           = trim($row_atrib['ATRIBUTO_NOMBRE']);
        $descripcion      = trim($row_atrib['ATRIBUTO_DESCRIPCION']);
        $tipo             = trim($row_atrib['ATRIBUTO_TIPO']);
        $estado           = trim($row_atrib['ATRIBUTO_ESTADO']);
        $sector           = trim($row_atrib['ATRIBUTO_SECTOR']);
        $conjunto         = trim($row_atrib['ATRIBUTO_CONJUNTO']);
        $valor            = trim($row_atrib['ATRIBUTO_VEHICULO_VALOR']);
    
    if ($conjunto) {
        $veh_atrb[$conjunto]['id']  = $id_atributo;
        $veh_atrb[$conjunto]['nom'] = $nombre;
        $veh_atrb[$conjunto]['des'] = $descripcion;
        $veh_atrb[$conjunto]['tip'] = $tipo;
        $veh_atrb[$conjunto]['est'] = $estado;
        $veh_atrb[$conjunto]['val'] = $valor;
    }else{
        $veh_atrb[$nombre]['id']  = $id_atributo;
        $veh_atrb[$nombre]['nom'] = $nombre;
        $veh_atrb[$nombre]['des'] = $descripcion;
        $veh_atrb[$nombre]['tip'] = $tipo;
        $veh_atrb[$nombre]['est'] = $estado;
        $veh_atrb[$nombre]['val'] = $valor;        
    }
}
/*****************************************************************/
list ($img_400x300_1, $img_80x60_1, $nom_img_400_1, $nom_img_80_1) = get_2_img_udp($_SESSION['ID_AUTOMOTORA'], $VEHICULO_IMG1, 1);
list ($img_400x300_2, $img_80x60_2, $nom_img_400_2, $nom_img_80_2) = get_2_img_udp($_SESSION['ID_AUTOMOTORA'], $VEHICULO_IMG2, 2);
list ($img_400x300_3, $img_80x60_3, $nom_img_400_3, $nom_img_80_3) = get_2_img_udp($_SESSION['ID_AUTOMOTORA'], $VEHICULO_IMG3, 3);
list ($img_400x300_4, $img_80x60_4, $nom_img_400_4, $nom_img_80_4) = get_2_img_udp($_SESSION['ID_AUTOMOTORA'], $VEHICULO_IMG4, 4);
list ($img_400x300_5, $img_80x60_5, $nom_img_400_5, $nom_img_80_5) = get_2_img_udp($_SESSION['ID_AUTOMOTORA'], $VEHICULO_IMG5, 5);
?>
<script type="text/javascript">
    $(document).ready(function(){
        var ExpReg = /catalog/;
        if      (ExpReg.test('<?=$img_400x300_1?>')) { click_to_thumb('<?=$nom_img_400_1?>'); }
        else if (ExpReg.test('<?=$img_400x300_2?>')) { click_to_thumb('<?=$img_400x300_2?>'); }
        else if (ExpReg.test('<?=$img_400x300_3?>')) { click_to_thumb('<?=$img_400x300_3?>'); }
        else if (ExpReg.test('<?=$img_400x300_4?>')) { click_to_thumb('<?=$img_400x300_4?>'); }
        else if (ExpReg.test('<?=$img_400x300_5?>')) { click_to_thumb('<?=$img_400x300_5?>'); }
        
        if (ExpReg.test('<?=$img_80x60_1?>')) { img_thumb(1, '<?=$nom_img_80_1?>'); }
        if (ExpReg.test('<?=$img_80x60_2?>')) { img_thumb(2, '<?=$nom_img_80_2?>'); }
        if (ExpReg.test('<?=$img_80x60_3?>')) { img_thumb(3, '<?=$nom_img_80_3?>'); }
        if (ExpReg.test('<?=$img_80x60_4?>')) { img_thumb(4, '<?=$nom_img_80_4?>'); }
        if (ExpReg.test('<?=$img_80x60_5?>')) { img_thumb(5, '<?=$nom_img_80_5?>'); }
    });
    function change_to_file(id) {
         var mensaje = '<input type="file" class="file_browse" name="fileUpload'+ id +'" id="fileUpload'+ id +'" onchange="javascript:sendfile('+ id +')" />';
         document.getElementById('thumb' + id).innerHTML='';
         document.getElementById('thumb' + id).innerHTML=mensaje;
    }
    function click_to_thumb(img) {
        var img_400 = '<?=PATH_WEB_ABS_IMG?>img/catalog/<?=$_SESSION['ID_AUTOMOTORA']?>/' + img;
        var html_img = '<img width="400" height="300" src="'+img_400+'"/>';
        document.getElementById('g1').innerHTML='';
        document.getElementById('g1').innerHTML=html_img;
    }
    function img_thumb(id, img){
         var img_80 = '<?=PATH_WEB_ABS_IMG?>img/catalog/<?=$_SESSION['ID_AUTOMOTORA']?>/' + img;
         var mensaje = '<img onclick="click_to_thumb(\''+ img +'\')" onDblClick="change_to_file('+ id +')" width="80" height="60" src="'+img_80+'"/>';
         document.getElementById('thumb' + id).innerHTML='';
         document.getElementById('thumb' + id).innerHTML=mensaje;
    }
    /**************************************************************************************/
    function sendfile(id) {
        $("#Uploadfile").ajaxSubmit({
             data: {
                 id_img: id,
                 id_img_temp : id
             },
             beforeSubmit: function() { 
                 var mensaje = '<img width="400" height="300" src="<?=$ruta_include?>img/ajax-loader.gif"/>';
                 document.getElementById('g1').innerHTML=mensaje;
             },
             success: function(datos){
             datos = $.trim(datos);
             
             if (datos == '0') {
                 alert("error thumb");
             }else if (datos == '1') {
                 alert("no copy 400x300");
             }else if (datos == '2') {
                 alert("no es imagen");
             }else if (datos == '3') {
                 alert("no existe el nombre temporal");
             }else if (datos == '4') {
                 alert("no copy 80x60");
             }
                 
            var n=datos.split(".");

               var id_automotora  = '<?=$_SESSION['ID_AUTOMOTORA']?>';
               var automotora_rut = '<?=$_SESSION['AUTOMOTORA_RUT']?>';
               var ruta_include   = '<?=$ruta_include?>';
               var img = 'tmp___' + id_automotora + '_' + automotora_rut + '_' + id + '.' + n[n.length - 1];
               var mensaje = '<img width="400" height="300" src="' + ruta_include + 'img/catalog/' + id_automotora + '/' + img + '"/>';

               document.getElementById('g1').innerHTML='';
               document.getElementById('g1').innerHTML=mensaje;

               var mensaje = '<img onclick="click_to_thumb(\''+ img +'\')" onDblClick="change_to_file('+ id +')" width="80" height="60" src="' + ruta_include + 'img/catalog/' + id_automotora + '/thumbnails/' + img + '"/>';

               document.getElementById('thumb' + id).innerHTML='';
               document.getElementById('thumb' + id).innerHTML=mensaje;
             
             }
         });
    }
    /**************************************************************************************/
</script>

<input type="hidden" id="id_vehiculo" value="<?=id_vehiculo?>" />

<div class="ficha bx cf">
    <div class="slide_ficha cf">
        <div class="dealerhead">
            <? $automotora_logo = $automotora_img ? "include/img/logos/".$automotora_img.'?'.time() : "include/img/logo_post_auto.png"; ?>
            <h2><img src="<?=$automotora_logo?>" class="sucursal-logo-small" alt=""><?=mb_strtoupper($automotora_nombre)?></h2>
        </div>
        <?/***********************************************************************/?>
        <div>
            <div>
                <div id="g1">
                    <img id="img_activa" src="<?=$img_400x300_1?>" width="400" height="300" alt="Sin Foto">
                </div>
            </div>
            
            <form name="Uploadfile" id="Uploadfile" method="post" enctype="multipart/form-data" target="iframeUpload" action="app/admin/add_logo_img.php">
            <iframe name="iframeUpload" style="display:none"></iframe>
            <input type="hidden" id="tipo_logo"   name="tipo_logo"   value="crear" />
            <input type="hidden" id="id_img_temp" name="id_img_temp" value="" />
            <input type="hidden" id="id_img"      name="id_img"      value="" />
            
            <div id="menu">
            <ul>
                <li class="menuItem">
                    <div id='file_browse_wrapper_1' onClick="document.getElementById('fileUpload1').click();">
                        <div id="thumb1">
                            <input type="file" style="width:0px;height:0px;" class='file_browse' name="fileUpload1" id="fileUpload1" onchange="javascript:sendfile(1)" />    
                        </div>
                    </div>
                </li>
                <li class="menuItem">
                    <div id='file_browse_wrapper_2' onClick="document.getElementById('fileUpload2').click();">
                        <div id="thumb2">
                            <input type="file" style="width:0px;height:0px;" class='file_browse' name="fileUpload2" id="fileUpload2" onchange="javascript:sendfile(2)" />
                        </div>
                    </div>
                </li>
                <li class="menuItem">
                    <div id='file_browse_wrapper_3' onClick="document.getElementById('fileUpload3').click();">
                        <div id="thumb3">
                            <input type="file" style="width:0px;height:0px;" class='file_browse' name="fileUpload3" id="fileUpload3" onchange="javascript:sendfile(3)" />
                        </div>
                    </div>
                </li>
                <li class="menuItem">
                    <div id='file_browse_wrapper_4' onClick="document.getElementById('fileUpload4').click();">
                        <div id="thumb4">
                            <input type="file" style="width:0px;height:0px;" class='file_browse' name="fileUpload4" id="fileUpload4" onchange="javascript:sendfile(4)" />
                        </div>
                    </div>
                </li>
                <li class="menuItem">
                    <div id='file_browse_wrapper_5' onClick="document.getElementById('fileUpload5').click();">
                        <div id="thumb5">
                            <input type="file" style="width:0px;height:0px;" class='file_browse' name="fileUpload5" id="fileUpload5" onchange="javascript:sendfile(5)" />
                        </div>
                    </div>
                </li>
            </ul>
            </div>
            </form>
        </div>
        <?/***********************************************************************/?>
        <?/***********************************************************************/?>
        <div class="metadata altern split_top">
            <h3>Publicación</h3>
            <table>
            <tr>
                <td class="label">Destacado</td>
                <td>
                    <div class="hiddenchecks" style="display:block">
                        <label style="cursor:pointer"><input type="radio" name="edt_radio_publicacion_tipo" value="21" <?if($veh_atrb[destacado][id]==21){echo"checked";}?>> Gold</label>
                        <label style="cursor:pointer"><input type="radio" name="edt_radio_publicacion_tipo" value="23" <?if($veh_atrb[destacado][id]==23){echo"checked";}?>> Silver</label>
                        <label style="cursor:pointer"><input type="radio" name="edt_radio_publicacion_tipo" value="24" <?if($veh_atrb[destacado][id]==24){echo"checked";}?>> Bronce</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="label">Etiqueta especial</td>
                <td>
                    <p>
                        <select id="edt_sel_publicacion_etiqueta">
                            <option value="">.:: Seleccionar ::.</option>
                            <?
                            $getAtributos = $CAT->getAtributos(array(
                                'ATRIBUTO_SECTOR'   => 'publicacion',
                                'ATRIBUTO_CONJUNTO' => 'etiqueta'
                            ));
                            if ($getAtributos) {
                            while($row_atrib = $getAtributos->fetch_assoc()) {
                                $id_atributo      = trim($row_atrib['ATRIBUTO_ID_ATRIBUTO']);
                                $nombre           = trim($row_atrib['ATRIBUTO_NOMBRE']);
                                $descripcion      = trim($row_atrib['ATRIBUTO_DESCRIPCION']);
                                $tipo             = trim($row_atrib['ATRIBUTO_TIPO']);
                                $estado           = trim($row_atrib['ATRIBUTO_ESTADO']);
                                $sector           = trim($row_atrib['ATRIBUTO_SECTOR']);
                                $conjunto         = trim($row_atrib['ATRIBUTO_CONJUNTO']);
                                $valor            = trim($row_atrib['ATRIBUTO_VEHICULO_VALOR']); 

                                $selected = "";
                                if ($veh_atrb['etiqueta'][id] == $id_atributo) { $selected = "selected"; }
                            ?>
                                <option value="<?=$id_atributo?>" <?=$selected?>><?=$descripcion?></option>
                            <? }
                            }?>
                        </select>
                    </p>
                </td>
            </tr>
            </table>
            <?/****************************************************************************************/?>
            <?/****************************************************************************************/?>
            <?/****************************************************************************************/?>
            <p>
                <button class="fichabtn"     onclick="guardar_ficha(<?=$id_vehiculo?>);">Guardar</button>
                <button class="fichabtn pub" onclick="publicar_ficha(<?=$id_vehiculo?>);">Publicar Oferta</button>
            </p>
            <?/****************************************************************************************/?>
            <?/****************************************************************************************/?>
            <?/****************************************************************************************/?>
        </div>
    </div>
    <div class="metadata cf">
        <table width="440" border="0" cellspacing="0" cellpadding="0"  id="div_sector_general">
            <tr>
                <td class="label">Carrocería</td>
                <td>
                    <select id="edt_sel_carroceria" onchange="search_ficha.getMarcas()">
                      <option value="">.:: TODOS ::.</option>
                      <?
                      $getCarrocerias = $CAT->getCarroceria();
                      while($row = $getCarrocerias->fetch_assoc()) { ?>
                          <option value="<?=$row['CARROCERIA_ID_CARROCERIA']?>" <?=$row['CARROCERIA_ID_CARROCERIA'] == $carroceria_id_carroceria ? "selected" : ""?>><?=mb_strtoupper($row['CARROCERIA_NOMBRE'])?></option>
                      <? } ?>            
                  </select>
              </td>
            </tr>
            <tr>
                <td width="156" class="label">Marca</td>
                <td width="414">
                    <select id="edt_sel_marca" onchange="search_ficha.getModelos()">
                        <option value="" selected="selected">.:: TODAS ::.</option>
                        <?
                        $getMarcas = $CAT->getMarcas();
                        while($row = $getMarcas->fetch_assoc()) { ?>
                            <option class="search-dynamic" value="<?=$row['MARCA_ID_MARCA']?>" <?=$row['MARCA_ID_MARCA'] == $marca_id_marca ? "selected" : ""?>><?=mb_strtoupper($row['MARCA_NOMBRE'])?></option>
                        <? } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label">Modelo</td>
                <td id="div_sel_modelo">
                    <select id="edt_sel_modelo">
                        <option value="" selected="selected">.:: TODOS ::.</option>
                        <?
                        $getModelos = $CAT->getModelos();
                        while($row = $getModelos->fetch_assoc()) { ?>
                            <option class="search-dynamic" value="<?=$row['MODELO_ID_MODELO']?>" <?=$row['MODELO_ID_MODELO'] == $modelo_id_modelo ? "selected" : ""?>><?=mb_strtoupper($row['MODELO_NOMBRE'])?></option>
                        <? } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label">Patente</td>
                <td><input type="text" id="edt_txt_patente" value="<?=$vehiculo_parente?>"></td>
            </tr>
            <tr>
                <td class="label">Precio</td>
                <td><input type="text" id="edt_txt_precio" value="<?=$vehiculo_precio?>"></td>
            </tr>
            <tr>
                <td width="156" class="label">Año</td>
                <td><input id="edt_txt_ano"type="text" value="<?=$vehiculo_annio?>"></td>
            </tr>
            <tr>
                <td class="label">Kilometraje</td>
                <td><input type="text" id="edt_txt_kilometros" value="<?=$vehiculo_kilometros?>"></td>
            </tr>
            <tr>
                <td class="label">Motor CC</td>
                <td>
                    <input type="text" 
                           id="edt_txt_motor_cc" 
                           value="<?=$veh_atrb[cc][val]?>">
                </td>
            </tr>
            <tr>
                <td class="label">Transmisión</td>
                <td>
                    <select id="edt_sel_transmision">
                        <option value="">.:: Seleccionar ::.</option>
                        <?
                        $getAtributos = $CAT->getAtributos(array(
                            'ATRIBUTO_SECTOR'   => 'general',
                            'ATRIBUTO_CONJUNTO' => 'transmision'
                        ));
                        if ($getAtributos) {
                        while($row_atrib = $getAtributos->fetch_assoc()) {
                            $id_atributo      = trim($row_atrib['ATRIBUTO_ID_ATRIBUTO']);
                            $nombre           = trim($row_atrib['ATRIBUTO_NOMBRE']);
                            $descripcion      = trim($row_atrib['ATRIBUTO_DESCRIPCION']);
                            $tipo             = trim($row_atrib['ATRIBUTO_TIPO']);
                            $estado           = trim($row_atrib['ATRIBUTO_ESTADO']);
                            $sector           = trim($row_atrib['ATRIBUTO_SECTOR']);
                            $conjunto         = trim($row_atrib['ATRIBUTO_CONJUNTO']);
                            $valor            = trim($row_atrib['ATRIBUTO_VEHICULO_VALOR']); 
                            
                            $selected = "";
                            if ($veh_atrb['transmision'][id] == $id_atributo) { $selected = "selected"; }
                        ?>
                            <option value="<?=$id_atributo?>" <?=$selected?>><?=$descripcion?></option>
                        <? }
                        }?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label">Combustible</td>
                <td>
                    <select id="edt_sel_combustible">
                        <option value="">.:: Seleccionar ::.</option>
                        <?
                        $getAtributos = $CAT->getAtributos(array(
                            'ATRIBUTO_SECTOR'   => 'general',
                            'ATRIBUTO_CONJUNTO' => 'combustible'
                        ));
                        if ($getAtributos) {
                        while($row_atrib = $getAtributos->fetch_assoc()) {
                            $id_atributo      = trim($row_atrib['ATRIBUTO_ID_ATRIBUTO']);
                            $nombre           = trim($row_atrib['ATRIBUTO_NOMBRE']);
                            $descripcion      = trim($row_atrib['ATRIBUTO_DESCRIPCION']);
                            $tipo             = trim($row_atrib['ATRIBUTO_TIPO']);
                            $estado           = trim($row_atrib['ATRIBUTO_ESTADO']);
                            $sector           = trim($row_atrib['ATRIBUTO_SECTOR']);
                            $conjunto         = trim($row_atrib['ATRIBUTO_CONJUNTO']);
                            $valor            = trim($row_atrib['ATRIBUTO_VEHICULO_VALOR']); 
                            
                            $selected = "";
                            if ($veh_atrb['combustible'][id] == $id_atributo) { $selected = "selected"; }
                        ?>
                            <option value="<?=$id_atributo?>" <?=$selected?>><?=$descripcion?></option>
                        <? }
                        }?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label">Color</td>
                <td>
                    <input type="text" 
                           id="edt_txt_color" 
                           value="<?=$veh_atrb[color][val]?>">
                </td>
            </tr>
        </table>
        
        
        
        
        <div class="fichatec cf">
            <?/********************************************************************************/?>
            <?/*********************     Equipamiento      ************************************/?>
            <?/********************************************************************************/?>
            <div class="lft">
                <h3>Equipamiento</h3>
                <div class="equipament"  id="div_sector_equipo">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <?
                        $getAtributos = $CAT->getAtributos(array(
                            'ATRIBUTO_SECTOR'   => 'equipo'
                        ));
                        while($row_atrib = $getAtributos->fetch_assoc()) {
                            $id_atributo      = trim($row_atrib['ATRIBUTO_ID_ATRIBUTO']);
                            $nombre           = trim($row_atrib['ATRIBUTO_NOMBRE']);
                            $descripcion      = trim($row_atrib['ATRIBUTO_DESCRIPCION']);
                            $tipo             = trim($row_atrib['ATRIBUTO_TIPO']);
                            $estado           = trim($row_atrib['ATRIBUTO_ESTADO']);
                            $sector           = trim($row_atrib['ATRIBUTO_SECTOR']);
                            $conjunto         = trim($row_atrib['ATRIBUTO_CONJUNTO']);
                            $valor            = trim($row_atrib['ATRIBUTO_VEHICULO_VALOR']); 
                            
                            if ($descripcion == '') { continue; }
                        ?>
                        <tr>
                            <td width="150" class="label"><?=$descripcion?></td>
                            <td width="55">
                                <? echo $veh_atrb[$nombre][val] ?>
                                <input type="checkbox" id="edt_chk_<?=$id_atributo?>" 
                                   <? if ($veh_atrb[$nombre][nom]) { ?>
                                        checked
                                   <? } ?>
                                   />
                            </td>
                        </tr>
                        <? } ?>
                    </table>
                </div>
            </div>
            <?/********************************************************************************/?>
            <?/*********************     Equipamiento      ************************************/?>
            <?/********************************************************************************/?>
            
            
            
            
            <div class="rgt">
                <h3>Seguridad</h3>
                <div class="equipament" id="div_sector_seguridad">
                    <table width="200" border="0" cellspacing="0" cellpadding="0">
                        <?/***********************************************************************/?>
                        <?/*********************  SEGURIDAD CONJUNTO *****************************/?>
                        <?/******************  se llaman de uno en uno ***************************/?>
                        <?/***********************************************************************/?>
                        <tr>
                            <td width="150" class="label">Frenos</td>
                            <td width="55">
                                <select id="edt_sel_frenos"> <?/* CONJUNTO frenos */?>
                                    <option value="">.:: Seleccionar ::.</option>
                                    <?
                                    $getAtributos = $CAT->getAtributos(array(
                                        'ATRIBUTO_SECTOR'   => 'seguridad',
                                        'ATRIBUTO_CONJUNTO' => 'frenos'
                                    ));
                                    while($row_atrib = $getAtributos->fetch_assoc()) {
                                        $id_atributo      = trim($row_atrib['ATRIBUTO_ID_ATRIBUTO']);
                                        $nombre           = trim($row_atrib['ATRIBUTO_NOMBRE']);
                                        $descripcion      = trim($row_atrib['ATRIBUTO_DESCRIPCION']);
                                        $tipo             = trim($row_atrib['ATRIBUTO_TIPO']);
                                        $estado           = trim($row_atrib['ATRIBUTO_ESTADO']);
                                        $sector           = trim($row_atrib['ATRIBUTO_SECTOR']);
                                        $conjunto         = trim($row_atrib['ATRIBUTO_CONJUNTO']);
                                        $valor            = trim($row_atrib['ATRIBUTO_VEHICULO_VALOR']);
                                        if ($nombre == '') { continue; }
                                        
                                        $selected = "";
                                        if ($veh_atrb['frenos'][id] == $id_atributo) { $selected = "selected"; }
                                    ?>
                                    <option value="<?=$id_atributo?>" <?=$selected?> ><?=$descripcion?></option>
                                    <? } ?>
                                </select>
                            </td>
                        </tr>
                        <?/***********************************************************************/?>
                        <?/*********************  SEGURIDAD CONJUNTO *****************************/?>
                        <?/***********************************************************************/?>
                        
                        
                        <?/***********************************************************************/?>
                        <?/****************  SEGURIDAD 'num','txt','opt','chk' *******************/?>
                        <?/***********************************************************************/?>
                        <?
                        $hash_paso='';
                        $getAtributos = $CAT->getAtributos(array(
                            'ATRIBUTO_SECTOR'   => 'seguridad'
                        ));
                        while($row_atrib = $getAtributos->fetch_assoc()) {
                            $id_atributo      = trim($row_atrib['ATRIBUTO_ID_ATRIBUTO']);
                            $nombre           = trim($row_atrib['ATRIBUTO_NOMBRE']);
                            $descripcion      = trim($row_atrib['ATRIBUTO_DESCRIPCION']);
                            $tipo             = trim($row_atrib['ATRIBUTO_TIPO']);
                            $estado           = trim($row_atrib['ATRIBUTO_ESTADO']);
                            $sector           = trim($row_atrib['ATRIBUTO_SECTOR']);
                            $conjunto         = trim($row_atrib['ATRIBUTO_CONJUNTO']);
                            $valor            = trim($row_atrib['ATRIBUTO_VEHICULO_VALOR']);
                            
                            if ($conjunto) { continue; }
                            if ($nombre == '') { continue; }
                        ?>
                        <tr>
                            <td width="150" class="label"><?=$descripcion?></td>
                            <td width="55">
                                <? if ($tipo == 'num' || $tipo == 'txt') { ?>
                                    <input type="text" id="edt_txt_<?=$id_atributo?>" size="3" value="<?=$veh_atrb[$nombre][val]?>">
                                <? }else if ($tipo == 'opt') { ?>
                                    
                                <? }else if ($tipo == 'chk') { ?>
                                    <input type="checkbox" id="edt_chk_<?=$id_atributo?>" 
                                       <? if ($veh_atrb[$nombre][nom]) { ?>
                                            checked
                                       <? } ?>
                                     />
                                <? } ?>
                            </td>
                        </tr>
                        <? } ?>
                        <?/***********************************************************************/?>
                        <?/****************  SEGURIDAD 'num','txt','opt','chk' *******************/?>
                        <?/***********************************************************************/?>
                    </table>
                
                </div>
            </div>
        </div>
    </div>
</div>