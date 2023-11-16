<?php
include_once '../comun/session.php';
require_once '../comun/BD.php';
require_once '../comun/utiles.php';

if ($_SESSION['USUARIO_TIPO'] != 'vendedor') {
    echo 'No autorizado';
    exit;
}
?>
<script>
    var search_ficha = new Search({
        path               : '',

        tipo             : $("#edt_sel_carroceria"),      
        marca            : $("#edt_sel_marca"),       
        modelo           : $("#edt_sel_modelo"),
        
        file_adminRequest    : "app/admin/admin-request.php",
        modelo_add_title     : $("#edt_sel-modelo-add-title"),
        modelo_add_container : $("#edt_sel-modelo-add-container"),
        modelo_add_nombre    : $("#edt_sel-modelo-add-nombre"),
    });
</script>
<?
/*****************************************************************/
$ruta_include = "include/";
/*****************************************************************/
$CAT    = new Catalogo();

$id_usuario        = $_SESSION['VENDEDOR_ID_VENDEDOR'];
$id_automotora     = $_SESSION['AUTOMOTORA_ID_AUTOMOTORA'];

$getAutomotora = $CAT->getAutomotoras(array(
    'AUTOMOTORA_ID_AUTOMOTORA' => $id_automotora
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

$getAtributos = $CAT->getAtributos();
while($row_atrib = $getAtributos->fetch_assoc()) {
    $id_atributo      = trim($row_atrib['ID_ATRIBUTO']);
    $nombre           = trim($row_atrib['NOMBRE']);
    $descripcion      = trim($row_atrib['DESCRIPCION']);
    $tipo             = trim($row_atrib['TIPO']);  //enum('num','txt','sel','opt')
    $estado           = trim($row_atrib['ESTADO']); //enum('activo','inactivo') 
    $sector           = trim($row_atrib['SECTOR']); //enum('equipo','seguridad','publicacion','general')
    $valor            = trim($row_atrib['VALOR']);
    $conjunto         = trim($row_atrib['CONJUNTO']); //enum('combustible','transmision')
    
    if ($conjunto) {
        $atrb[$conjunto][id]  = $id_atributo;
        $atrb[$conjunto][nom] = $nombre;
        $atrb[$conjunto][des] = $descripcion;
        $atrb[$conjunto][tip] = $tipo;
        $atrb[$conjunto][est] = $estado;
        $atrb[$conjunto][val] = $valor;        
    }else{
        $atrb[$nombre][id]  = $id_atributo;
        $atrb[$nombre][nom] = $nombre;
        $atrb[$nombre][des] = $descripcion;
        $atrb[$nombre][tip] = $tipo;
        $atrb[$nombre][est] = $estado;
        $atrb[$nombre][val] = $valor;        
    }
}
/*****************************************************************/
?>
<script type="text/javascript">
    _gaq.push(['_trackEvent', 'add_ficha', '<?=$_SESSION['AUTOMOTORA_ID_AUTOMOTORA']?>', '<?=$_SESSION['VENDEDOR_ID_VENDEDOR']?>']);
</script>

<script type="text/javascript">
function change_to_file(id) {
     var mensaje = '<input type="file" class="file_browse" name="fileUpload'+ id +'" id="fileUpload'+ id +'" onchange="javascript:sendfile('+ id +')" />';
     document.getElementById('thumb' + id).innerHTML='';
     document.getElementById('thumb' + id).innerHTML=mensaje;
}
function click_to_thumb(img) {
    var id_automotora  = '<?=$_SESSION['ID_AUTOMOTORA']?>';
    var automotora_rut = '<?=$_SESSION['AUTOMOTORA_RUT']?>';
    var ruta_include   = '<?=$ruta_include?>';
    
    var mensaje = '<img width="400" height="300" src="' + ruta_include + 'img/catalog/' + id_automotora + '/' + img + '"/>';
    document.getElementById('g1').innerHTML='';
    document.getElementById('g1').innerHTML=mensaje;
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
                 alert("Ha ocurrido un error al crear imagen.");
             }else if (datos == '1') {
                 alert("Ha ocurrido un error, al copiar imagen 400x300.");
             }else if (datos == '2') {
                 alert("Ha ocurrido un error.\n\nEl archivo no es una imagen.");
             }else if (datos == '3') {
                 alert("Ha ocurrido un error.\n\nEl archivo no es una imagen.");
             }else if (datos == '4') {
                 alert("Ha ocurrido un error, al copiar imagen 80x60.");
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

<input type="hidden" name="id_automotora" value="<?=$id_automotora?>" />

<div class="ficha bx cf">
    <div class="slide_ficha cf">
        <?/***********************************************************************/?>
        <div class="dealerhead">
            <? $automotora_logo = $automotora_img ? "include/img/logos/".$automotora_img.'?'.time() : "include/img/logo_post_auto.png"; ?>
            <h2><img src="<?=$automotora_logo?>" class="sucursal-logo-small" alt=""><?=mb_strtoupper($automotora_nombre)?></h2>
        </div>
        <?/***********************************************************************/?>
        <div>
            <div>
                <div id="g1">
                    <img id="img_activa" src="<?=$ruta_include?>img/sinfoto_400x300.png" width="400" height="300" alt="Sin Foto">
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
                <button class="fichabtn"     onclick="fadd_ficha();">Guardar</button>
                <button class="fichabtn pub" onclick="publicar_ficha();">Publicar Oferta</button>
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
                    <select id="edt_sel_carroceria">
                      <option value="">.:: TODOS ::.</option>
                      <?
                      $getCarrocerias = $CAT->getCarroceria();
                      while($row = $getCarrocerias->fetch_assoc()) { ?>
                          <option value="<?=$row['CARROCERIA_ID_CARROCERIA']?>"><?=mb_strtoupper($row['CARROCERIA_NOMBRE'])?></option>
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
                            <option class="search-dynamic" value="<?=$row['MARCA_ID_MARCA']?>"><?=mb_strtoupper($row['MARCA_NOMBRE'])?></option>
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
                            <option class="search-dynamic" value="<?=$row['MODELO_ID_MODELO']?>"><?=mb_strtoupper($row['MODELO_NOMBRE'])?></option>
                        <? } ?>
                    </select>
                    <a id="edt_sel-modelo-add-title" href="#" onclick="search_ficha.toggleAddModelo(this)"><img class="add-icon" src="include/img/add-icon.png"></a>
                    <div id="edt_sel-modelo-add-container" style="display:none">
                        Nombre
                        <input id="edt_sel-modelo-add-nombre" value="">
                        <a id="edt_sel-modelo-add-button-ok" href="#" onclick="search_ficha.addModelo()">Agregar</a>
                    </div>
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
                <td width="156" class="label">A&ntilde;o</td>
                <td><input id="edt_txt_ano"type="text" value="<?=$vehiculo_ano?>"></td>
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