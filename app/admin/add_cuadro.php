<?
/***************************************/
//require_once '../comun/config.php';
/***************************************/
include_once '../comun/session.php';
require_once '../comun/BD.php';
require_once '../comun/utiles.php';
/***************************************/
$CAT    = new Catalogo();
/***************************************/
$ruta_include = "../../include/";
/***************************************/

$ruta_400x300 = $ruta_include.'img/catalog/'.$_SESSION['ID_AUTOMOTORA'].'/';
$ruta_80x60   = $ruta_include.'img/catalog/'.$_SESSION['ID_AUTOMOTORA'].'/thumbnails/';
$ruta_215     = $ruta_include.'img/catalog/'.$_SESSION['ID_AUTOMOTORA'].'/thumbnails/215/';
$ruta_125     = $ruta_include.'img/catalog/'.$_SESSION['ID_AUTOMOTORA'].'/thumbnails/125/';

/***************************************/
$view              = trim($_GET[view]);
if ($view) { $view = $view;}
else       { $view = $_SESSION[view];}
$_SESSION[view]    = $view;
/***************************************/

/****************************************************************/
$id_vehiculo       = trim($_POST[id_vehiculo]);
/****************************************************************/

/****************************************************************/
//$getFicha = $CAT->getFicha( $id_vehiculo );
//$num_rows_Listado = $getFicha->num_rows;

$getFicha = $CAT->getListado(array(
        'VEHICULO_ID_VEHICULO'   => $id_vehiculo
));    

$num_rows_Listado = $getFicha->num_rows;
/****************************************************************/


/****************************************************************/
$row = $getFicha->fetch_assoc();
        $id_automotora           = trim($row['AUTOMOTORA_ID_AUTOMOTORA']);
        $automotora_id_matriz    = trim($row['AUTOMOTORA_ID_MATRIZ']);
        $automotora_id_ciudad    = trim($row['AUTOMOTORA_ID_CIUDAD']);
        $automotora_rut          = trim($row['AUTOMOTORA_RUT']);
        $automotora_nombre       = trim($row['AUTOMOTORA_NOMBRE']);
        $automotora_fono         = trim($row['AUTOMOTORA_TELEFONO']);
        $automotora_email        = trim($row['AUTOMOTORA_EMAIL']);
        $automotora_fax          = trim($row['AUTOMOTORA_FAX']);
        $automotora_razon        = trim($row['AUTOMOTORA_RAZON_SOCIAL']);
        $automotora_img          = trim($row['AUTOMOTORA_IMG']);
        $automotora_url          = trim($row['AUTOMOTORA_URL']);    
        $automotora_direccion    = trim($row['AUTOMOTORA_DIRECCION']);
        $automotora_numero       = trim($row['AUTOMOTORA_NUMERO']);
        $automotora_horario_lun_vie   = trim($row['AUTOMOTORA_HORARIO_LUN_VIE']);
        $automotora_horario_sab  = trim($row['AUTOMOTORA_HORARIO_SAB']);
        $automotora_horario_dom  = trim($row['AUTOMOTORA_HORARIO_DOM']);  
        $automotora_estado       = trim($row['AUTOMOTORA_ESTADO']);
        $automotora_fecha_ingreso      = trim($row['AUTOMOTORA_FECHA_INGRESO']);
        $automotora_fecha_modificacion = trim($row['AUTOMOTORA_FECHA_MODIFICACION']);

        $vendedor_id_automotora    = trim($row['VENDEDOR_ID_AUTOMOTORA']);
        $vendedor_id_vendedor      = trim($row['VENDEDOR_ID_VENDEDOR']);
        $vendedor_nombre          = trim($row['VENDEDOR_NOMBRE']);
        $vendedor_app              = trim($row['VENDEDOR_APELLIDO_PATERNO']);
        $vendedor_apm              = trim($row['VENDEDOR_APELLIDO_MATERNO']);
        $vendedor_rut              = trim($row['VENDEDOR_RUT']);
        $vendedor_email            = trim($row['VENDEDOR_EMAIL']);
        $vendedor_pwd              = trim($row['VENDEDOR_PASSWORD']);
        $vendedor_telefono         = trim($row['VENDEDOR_TELEFONO']);
        $vendedor_movil            = trim($row['VENDEDOR_MOVIL']);
        $vendedor_direccion        = trim($row['VENDEDOR_DIRECCION']);
        $vendedor_fec_ingreso      = trim($row['VENDEDOR_FECHA_INGRESO']);
        $vendedor_fec_modificacion = trim($row['VENDEDOR_FECHA_MODIFICACION']);
        $vendedor_tipo             = trim($row['VENDEDOR_TIPO']);

        $vehiculo_id_vehiculo        = trim($row['VEHICULO_ID_VEHICULO']);
        $vehiculo_id_marca           = trim($row['VEHICULO_ID_MARCA']);
        $vehiculo_id_vendedor        = trim($row['VEHICULO_ID_VENDEDOR']);
        $vehiculo_id_ciudad          = trim($row['VEHICULO_ID_CIUDAD']);
        $vehiculo_modelo             = trim($row['MODELO_NOMBRE']);
        $vehiculo_patente            = trim($row['VEHICULO_PATENTE']);
        $vehiculo_annio              = trim($row['VEHICULO_ANNIO']);
        $vehiculo_kilometros         = trim($row['VEHICULO_KILOMETROS']);
        $vehiculo_precio             = trim($row['VEHICULO_PRECIO']);
        $vehiculo_descripcion        = trim($row['VEHICULO_DESCRIPCION']);
        $vehiculo_fecha_publicacion  = trim($row['VEHICULO_FECHA_PUBLICACION']);
        $vehiculo_fecha_modificacion = trim($row['VEHICULO_FECHA_MODIFICACION']);
        $vehiculo_estado             = trim($row['VEHICULO_ESTADO']); 
        
        $VEHICULO_IMG1             = trim($row['VEHICULO_IMG1']);
        $VEHICULO_IMG2             = trim($row['VEHICULO_IMG2']);
        $VEHICULO_IMG3             = trim($row['VEHICULO_IMG3']);
        $VEHICULO_IMG4             = trim($row['VEHICULO_IMG4']);
        $VEHICULO_IMG5             = trim($row['VEHICULO_IMG5']);
        
        $ano = substr($vehiculo_fecha_publicacion, 0, 4);
        $mes = substr($vehiculo_fecha_publicacion, 5, 2);
        $dia = substr($vehiculo_fecha_publicacion, 8, 2);
        
        $vehiculo_fecha_publicacion = $dia.' '.$meses[$mes].' '.$ano;

        $marca_id_marca  = trim($row['MARCA_ID_MARCA']);
        $marca_id_pais   = trim($row['MARCA_ID_PAIS']);
        $marca_nombre    = trim($row['MARCA_NOMBRE']);
        
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
                $veh_atrb[$conjunto][id]  = $id_atributo;
                $veh_atrb[$conjunto][nom] = $nombre;
                $veh_atrb[$conjunto][des] = $descripcion;
                $veh_atrb[$conjunto][tip] = $tipo;
                $veh_atrb[$conjunto][est] = $estado;
                $veh_atrb[$conjunto][val] = $valor;
            }else{
                $veh_atrb[$nombre][id]  = $id_atributo;
                $veh_atrb[$nombre][nom] = $nombre;
                $veh_atrb[$nombre][des] = $descripcion;
                $veh_atrb[$nombre][tip] = $tipo;
                $veh_atrb[$nombre][est] = $estado;
                $veh_atrb[$nombre][val] = $valor;        
            }
        }
?>
        <? if ($_SESSION['view'] == 'list') { ?>
            <div class="list_post_th" id="cuadro<?=$vehiculo_id_vehiculo?>">
                <?
                $ruta_125     = '../../'.PATH_CATALOG_IMG.$id_automotora.'/thumbnails/125/';
                $image = is_file($ruta_125.$VEHICULO_IMG1) ? PATH_CATALOG_IMG.$id_automotora.'/thumbnails/125/'.$VEHICULO_IMG1 : "include/img/sinfoto_125x93.png";
                ?>
                <img onclick="admin_ver_ficha(<?=$vehiculo_id_vehiculo?>);" width="125" height="93" src="<?=$image?>">
                <? if ($colorCartel && $txtCartel) { ?>
                    <div style="cursor:pointer" onclick="ver_ficha(<?=$vehiculo_id_vehiculo?>);" class="list_label <?=$colorCartel?>"><?=$txtCartel?></div>
                <? } ?>
                <div class="list_maindata">
                    <h3><?=mb_strtoupper($marca_nombre)?> <?=mb_strtoupper($vehiculo_modelo)?></h3>
                    <!--<p>2012<img src="img/cerok.png" alt="0 km" class="cerok"></p>-->
                    
                    <p><?=$vehiculo_annio?> 
                        <? if ($vehiculo_kilometros == 0) { ?>
                            <img src="include/img/cerok.png" alt="0 km" class="cerok">
                        <? } ?>
                    </p>
                    
                    <p class="price"><?=fprecio($vehiculo_precio)?></p>
                </div>
                <div class="list_metadata">
                    <p><strong>Motor:</strong> 2.5</p>
                    <p><strong>Transmisión:</strong> Mecánica</p>
                    <p><strong>Tracción:</strong> 2x2</p>
                    <p><strong>Combustible:</strong> Petróleo</p>
                    <p><strong>Airbags:</strong>2</p>
                </div>
                <div class="dealerlink listview">
                    <p class="date_post_th"><?=$vehiculo_fecha_publicacion?></p>
                    <p>
                        <? if ($vehiculo_estado == 'alta') { /*'alta','baja','eliminado'*/ ?>
                            <span href="#" id="img_estado<?=$vehiculo_id_vehiculo?>" onclick="fdespublicar(<?=$vehiculo_id_vehiculo?>);" title="Despublicar" class="pub_icn publicado"></span>
                        <? } else{ ?>
                            <span href="#" id="img_estado<?=$vehiculo_id_vehiculo?>" onclick="fpublicar(<?=$vehiculo_id_vehiculo?>);" title="Publicar" class="pub_icn"></span>
                        <? } ?>
                        <span style="cursor:pointer" onclick="elimina_ficha(<?=$vehiculo_id_vehiculo?>);" class="del_icn"></span>
                        <span style="cursor:pointer" onclick="editar_ficha(<?=$vehiculo_id_vehiculo?>);" class="edit_icn"></span>
                    </p>
                </div>
            </div>
        <? }else{ ?>
            <div class="block_post_th" id="cuadro<?=$vehiculo_id_vehiculo?>">
                <?
                $ruta_215     = '../../'.PATH_CATALOG_IMG.$id_automotora.'/thumbnails/215/';
                $image = is_file($ruta_215.$VEHICULO_IMG1) ? PATH_CATALOG_IMG.$id_automotora.'/thumbnails/215/'.$VEHICULO_IMG1 : "include/img/sinfoto_215x161.png";
                ?>
                <img onclick="admin_ver_ficha(<?=$vehiculo_id_vehiculo?>);" src="<?=$image?>" width="215" height="161" alt="">
                <h3><?=mb_strtoupper($marca_nombre)?> <?=mb_strtoupper($vehiculo_modelo)?></h3>
                <p><?=$vehiculo_annio?> 
                    <? if ($vehiculo_kilometros == 0) { ?>
                        <img src="include/img/cerok.png" alt="0 km" class="cerok">
                    <? } ?>
                </p>
                <p class="price"><?=fprecio($vehiculo_precio)?></p>
                <div class="dealerlink">
                    <div class="rgt">
                        <? if ($vehiculo_estado == 'alta') { /*'alta','baja','eliminado'*/ ?>
                            <span href="#" id="img_estado<?=$vehiculo_id_vehiculo?>" onclick="fdespublicar(<?=$vehiculo_id_vehiculo?>);" title="Despublicar" class="pub_icn publicado"></span>
                        <? } else{ ?>
                            <span href="#" id="img_estado<?=$vehiculo_id_vehiculo?>" onclick="fpublicar(<?=$vehiculo_id_vehiculo?>);" title="Publicar" class="pub_icn"></span>
                        <? } ?>
                        <span href="#" onclick="elimina_ficha(<?=$vehiculo_id_vehiculo?>);" class="del_icn"></span>
                        <span href="#" class="edit_icn" onclick="editar_ficha(<?=$vehiculo_id_vehiculo?>);"></span>
                    </div>
                    <div class="date_post_th"><?=$vehiculo_fecha_publicacion?></div>
                </div>
                <?
                $colorCartel = '';
                if ($veh_atrb[etiqueta][nom] == 'bono') {
                    $colorCartel = 'red';
                }else if ($veh_atrb[etiqueta][nom] == 'ultimo') {
                    $colorCartel = 'orange';
                }else if ($veh_atrb[etiqueta][nom] == 'nuevo') {
                    $colorCartel = 'green';
                }else if ($veh_atrb[etiqueta][nom] == 'oferta') {
                    $colorCartel = 'green';
                }else{
                    //$colorCartel = 'red';
                }
                $txtCartel = $veh_atrb[etiqueta][des];
                ?>
                <div class="label_th <?=$colorCartel?>"><?=$txtCartel?></div>
            </div>
        <? } ?>