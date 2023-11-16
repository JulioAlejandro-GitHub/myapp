<?php
/*****************************************************************/
include_once '../comun/session.php';
require_once '../comun/BD.php';
require_once '../comun/utiles.php';
require_once '../comun/Logger.php';
/*****************************************************************/


/*****************************************************************/
$CAT    = new Catalogo();
$Logger = new Logger(LOG_NOMBRE);
/*****************************************************************/

/********************************************************/
$id_automotora = $_SESSION['ID_AUTOMOTORA'];
$id_vendedor   = $_SESSION['ID_VENDEDOR'];
/********************************************************/
$id_vehiculo   = trim($_POST['id_vehiculo']);
/********************************************************/

/********************* DATOS   **************************/
$edt_sel_marca       = trim($_POST['edt_sel_marca']);
$edt_sel_modelo      = trim($_POST['edt_sel_modelo']);
$edt_txt_patente     = trim($_POST['edt_txt_patente']);

$edt_txt_precio      = trim($_POST['edt_txt_precio']);
$edt_txt_ano         = trim($_POST['edt_txt_ano']);
$edt_sel_carroceria  = trim($_POST['edt_sel_carroceria']);
$edt_txt_kilometros  = trim($_POST['edt_txt_kilometros']);
$edt_txt_motor_cc    = trim($_POST['edt_txt_motor_cc']);
$edt_sel_transmision = trim($_POST['edt_sel_transmision']);
$edt_sel_combustible = trim($_POST['edt_sel_combustible']);
$edt_txt_airbags     = trim($_POST['edt_txt_airbags']);
$edt_txt_color       = trim($_POST['edt_txt_color']);
/********************************************************/

/*****************  EQUIPAMENT **************************/
$edt_equipament = trim($_POST['edt_equipament']);
/********************************************************/

/************* SEGURIDAD  *******************************/
$edt_seguridad = trim($_POST['edt_seguridad']);
/********************************************************/

$atributo = $edt_equipament.';'.$edt_seguridad;

/********************* PUBLICACION **********************/
$edt_radio_publicacion_tipo   = trim($_POST['edt_radio_publicacion_tipo']);
$edt_sel_publicacion_etiqueta = trim($_POST['edt_sel_publicacion_etiqueta']);
/********************************************************/

if ($id_vehiculo) { // UPD
    
    $Logger->write_log('***********************************');
    $Logger->write_log("updFicha --> id_vehiculo [$id_vehiculo]");
    $Logger->write_log("         --> edt_sel_marca [$edt_sel_marca]");
    $Logger->write_log("         --> edt_sel_modelo [$edt_sel_modelo]");
    $Logger->write_log("         --> edt_txt_patente [$edt_txt_patente]");
    $Logger->write_log("         --> edt_txt_precio [$edt_txt_precio]");
    $Logger->write_log("         --> edt_txt_ano [$edt_txt_ano]");
    $Logger->write_log("         --> edt_sel_carroceria [$edt_sel_carroceria]");
    $Logger->write_log("         --> edt_txt_kilometros [$edt_txt_kilometros]");
    $Logger->write_log("         --> edt_radio_publicacion_tipo [$edt_radio_publicacion_tipo]");
    $Logger->write_log("         --> edt_sel_publicacion_etiqueta [$edt_sel_publicacion_etiqueta]");
    $Logger->write_log('***********************************');
    
    $res_updFicha = $CAT->updFicha( /********************************************************/
                                    $id_vehiculo,
                                    /********************************************************/

                                    /********************* DATOS   **************************/
                                    $edt_sel_marca,
                                    $edt_sel_modelo,
                                    $edt_txt_patente,
                                    
                                    $edt_txt_precio,
                                    $edt_txt_ano,
                                    $edt_sel_carroceria,
                                    $edt_txt_kilometros,
                                    /********************************************************/
                                    
                                    /********************* PUBLICACION **********************/
                                    $edt_radio_publicacion_tipo,
                                    $edt_sel_publicacion_etiqueta
                                    /********************************************************/
                                );
    
    $affected        = $CAT->affected_rows;
    //echo "updFicha[$res_updFicha]***";
    if ($res_updFicha) {
        $res_dalAllAtributo = $CAT->dalAllAtributo($id_vehiculo);
        if ($res_updFicha) {
            if ($edt_sel_publicacion_etiqueta) {$atributo .= $edt_sel_publicacion_etiqueta.';';}
            if ($edt_radio_publicacion_tipo  ) {$atributo .= $edt_radio_publicacion_tipo.';';}
            if ($edt_txt_motor_cc            ) {$atributo .= '8|'.$edt_txt_motor_cc.';';}
            if ($edt_sel_transmision         ) {$atributo .= $edt_sel_transmision.';';}
            if ($edt_sel_combustible         ) {$atributo .= $edt_sel_combustible.';';}
            if ($edt_txt_color               ) {$atributo .= '3|'.$edt_txt_color.';';}
            //echo "$atributo";
            $array_atrib = explode(";", $atributo);
            foreach($array_atrib as $dato) {
                $val = explode("|", $dato);
                $id  = $val[0];
                $txt = $val[1];

                if ($id) {
                    $res_updAtributo = $CAT->AddAtributo($id_vehiculo, $id, $txt);
                }
            }
        }else{
            echo "error del upd";
            exit;
        }
        
        
        
        $Logger->write_log('***********************************');
        $Logger->write_log('renombrar las imagenes....................');
        $Logger->write_log('***********************************');
        
        file_rename($id_vehiculo);
        
        if ($_SESSION['IMG'][1]) {
            $extension = getExtension($_SESSION['IMG'][1]);
            $nom_fin1   =  $_SESSION['ID_AUTOMOTORA'].'_'.$_SESSION['AUTOMOTORA_RUT']."_1_".$id_vehiculo.'.'.$extension; // nombre final            
        }
        if ($_SESSION['IMG'][2]) {
            $extension = getExtension($_SESSION['IMG'][2]);
            $nom_fin2   =  $_SESSION['ID_AUTOMOTORA'].'_'.$_SESSION['AUTOMOTORA_RUT']."_2_".$id_vehiculo.'.'.$extension; // nombre final
        }
        if ($_SESSION['IMG'][3]) {
            $extension = getExtension($_SESSION['IMG'][3]);
            $nom_fin3   =  $_SESSION['ID_AUTOMOTORA'].'_'.$_SESSION['AUTOMOTORA_RUT']."_3_".$id_vehiculo.'.'.$extension; // nombre final
        }
        if ($_SESSION['IMG'][4]) {
            $extension = getExtension($_SESSION['IMG'][4]);
            $nom_fin4   =  $_SESSION['ID_AUTOMOTORA'].'_'.$_SESSION['AUTOMOTORA_RUT']."_4_".$id_vehiculo.'.'.$extension; // nombre final
        }
        if ($_SESSION['IMG'][5]) {
            $extension = getExtension($_SESSION['IMG'][5]);
            $nom_fin5   =  $_SESSION['ID_AUTOMOTORA'].'_'.$_SESSION['AUTOMOTORA_RUT']."_5_".$id_vehiculo.'.'.$extension; // nombre final
        }
        $CAT->updImgFicha($id_vehiculo,$nom_fin1,$nom_fin2,$nom_fin3,$nom_fin4,$nom_fin5);
        
        
        echo "ok";
    }else {
        echo "error upd";
    }
    
}else{ // INSERT
    
    $Logger->write_log('***********************************');
    $Logger->write_log("addFicha --> id_automotora [$id_automotora]");
    $Logger->write_log("         --> id_vendedor [$id_vendedor]");
    $Logger->write_log("         --> edt_sel_marca [$edt_sel_marca]");
    $Logger->write_log("         --> edt_sel_modelo [$edt_sel_modelo]");
    $Logger->write_log("         --> edt_txt_patente [$edt_txt_patente]");
    $Logger->write_log("         --> edt_txt_precio [$edt_txt_precio]");
    $Logger->write_log("         --> edt_txt_ano [$edt_txt_ano]");
    $Logger->write_log("         --> edt_sel_carroceria [$edt_sel_carroceria]");
    $Logger->write_log("         --> edt_txt_kilometros [$edt_txt_kilometros]");
    $Logger->write_log("         --> edt_radio_publicacion_tipo [$edt_radio_publicacion_tipo]");
    $Logger->write_log("         --> edt_sel_publicacion_etiqueta [$edt_sel_publicacion_etiqueta]");
    $Logger->write_log('***********************************');
    
    $res_updFicha = $CAT->addFicha( /********************************************************/
                                    $id_automotora,
                                    $id_vendedor,
                                    /********************************************************/

                                    /********************* DATOS   **************************/
                                    $edt_sel_marca,
                                    $edt_sel_modelo,
                                    $edt_txt_patente,
                                    
                                    $edt_txt_precio,
                                    $edt_txt_ano,
                                    $edt_sel_carroceria,
                                    $edt_txt_kilometros,
                                    /********************************************************/
                                    
                                    /********************* PUBLICACION **********************/
                                    $edt_radio_publicacion_tipo,
                                    $edt_sel_publicacion_etiqueta,
                                    'alta'
                                    /********************************************************/
                                );
    //return "[$res_updFicha]";
    
    $affected        = $CAT->affected_rows;
    $insert_id       = $CAT->insert_id;
    
    //echo "[".$CAT->error."]";
    
    $Logger->write_log("         <-- res_updFicha [$res_updFicha]");
    $Logger->write_log("         <-- affected     [$affected]");
    $Logger->write_log("         <-- insert_id    [$insert_id]");
    $Logger->write_log('***********************************');
    
    
    if ($res_updFicha) {
        $id_vehiculo = $res_updFicha;
        
        $Logger->write_log('***********************************');
        $Logger->write_log('renombrar las imagenes....................');
        $Logger->write_log('***********************************');
        
        file_rename($id_vehiculo);
        
        if ($_SESSION['IMG'][1]) {
            $extension = getExtension($_SESSION['IMG'][1]);
            $nom_fin1   =  $_SESSION['ID_AUTOMOTORA'].'_'.$_SESSION['AUTOMOTORA_RUT']."_1_".$id_vehiculo.'.'.$extension; // nombre final            
        }
        if ($_SESSION['IMG'][2]) {
            $extension = getExtension($_SESSION['IMG'][2]);
            $nom_fin2   =  $_SESSION['ID_AUTOMOTORA'].'_'.$_SESSION['AUTOMOTORA_RUT']."_2_".$id_vehiculo.'.'.$extension; // nombre final
        }
        if ($_SESSION['IMG'][3]) {
            $extension = getExtension($_SESSION['IMG'][3]);
            $nom_fin3   =  $_SESSION['ID_AUTOMOTORA'].'_'.$_SESSION['AUTOMOTORA_RUT']."_3_".$id_vehiculo.'.'.$extension; // nombre final
        }
        if ($_SESSION['IMG'][4]) {
            $extension = getExtension($_SESSION['IMG'][4]);
            $nom_fin4   =  $_SESSION['ID_AUTOMOTORA'].'_'.$_SESSION['AUTOMOTORA_RUT']."_4_".$id_vehiculo.'.'.$extension; // nombre final
        }
        if ($_SESSION['IMG'][5]) {
            $extension = getExtension($_SESSION['IMG'][5]);
            $nom_fin5   =  $_SESSION['ID_AUTOMOTORA'].'_'.$_SESSION['AUTOMOTORA_RUT']."_5_".$id_vehiculo.'.'.$extension; // nombre final
        }
        $CAT->updImgFicha($id_vehiculo,$nom_fin1,$nom_fin2,$nom_fin3,$nom_fin4,$nom_fin5);
        //$CAT->updImgFicha($id_vehiculo,'1','2','3','4','5');
        
        $res_dalAllAtributo = $CAT->dalAllAtributo($id_vehiculo);
        if ($res_updFicha) {
            if ($edt_sel_publicacion_etiqueta) {$atributo .= $edt_sel_publicacion_etiqueta.';';}
            if ($edt_radio_publicacion_tipo  ) {$atributo .= $edt_radio_publicacion_tipo.';';}
            if ($edt_txt_motor_cc            ) {$atributo .= '8|'.$edt_txt_motor_cc.';';}
            if ($edt_sel_transmision         ) {$atributo .= $edt_sel_transmision.';';}
            if ($edt_sel_combustible         ) {$atributo .= $edt_sel_combustible.';';}
            if ($edt_txt_color               ) {$atributo .= '3|'.$edt_txt_color.';';}
            //echo "$atributo";
            $array_atrib = explode(";", $atributo);
            foreach($array_atrib as $dato) {
                $val = explode("|", $dato);
                $id  = $val[0];
                $txt = $val[1];
                
                if ($id) {
                    $res_updAtributo = $CAT->AddAtributo($id_vehiculo, $id, $txt);
                }
            }
        }else{
            echo "error del add";
            exit;
        }
        
        echo $id_vehiculo;
    }else {
        echo "error add";
    }
}


function file_rename($id_vehiculo) {
    $Logger = new Logger(LOG_NOMBRE);
    /************************************************************************************************/
    /************************************************************************************************/
    $ruta_400x300 = '../../include/img/catalog/'.$_SESSION['ID_AUTOMOTORA'].'/';
    $ruta_80x60   = '../../include/img/catalog/'.$_SESSION['ID_AUTOMOTORA'].'/thumbnails/';
    $ruta_215     = '../../include/img/catalog/'.$_SESSION['ID_AUTOMOTORA'].'/thumbnails/215/';
    $ruta_125     = '../../include/img/catalog/'.$_SESSION['ID_AUTOMOTORA'].'/thumbnails/125/';
    /************************************************************************************************/
    for ($i = 1; $i <= 5; $i++) {
        $Logger->write_log('*******************************');
        $Logger->write_log("img   [$i/5]  ");
        $Logger->write_log('*******************************');
        /************************************************************************************************/
        
        $Logger->write_log('getExtension --> ['.$_SESSION['IMG'][$i].']');
        $extension = getExtension($_SESSION['IMG'][$i]);
        $Logger->write_log('            <-- ['.$extension.']');
        
        $nom_img   =  "tmp___".$_SESSION['ID_AUTOMOTORA'].'_'.$_SESSION['AUTOMOTORA_RUT']."_$i.".$extension; // nombre temporal
        $nom_fin   =  $_SESSION['ID_AUTOMOTORA'].'_'.$_SESSION['AUTOMOTORA_RUT']."_".$i."_".$id_vehiculo.'.'.$extension; // nombre final
        /************************************************************************************************/
        $Logger->write_log("nom_img[$nom_img]");
        $Logger->write_log("nom_fin[$nom_fin]");
        /************************************************************************************************/
        $Logger->write_log('file_exists --> ['.$ruta_400x300.$nom_img.']');
        if (file_exists($ruta_400x300.$nom_img)) {
            $Logger->write_log('            <-- [ok]');
            
//            if (rename($ruta_400x300.$nom_img, $ruta_400x300.$nom_fin)) {
//                $Logger->write_log('     <-- [ok]');
//            }else{
//                $Logger->write_log('     <-- [error]');
//            }
            //rename("/tmp/archivo_tmp.txt", "/home/user/login/docs/mi_archivo.txt");
            
            $Logger->write_log('copy --> ['.$ruta_400x300.$nom_img.']');
            if (!copy($ruta_400x300.$nom_img, $ruta_400x300.$nom_fin)) {
                $Logger->write_log('     <-- [error]');
            }else{
                $Logger->write_log('     <-- [ok]');
                unlink($ruta_400x300.$nom_img);
            }
        }else{
            $Logger->write_log('            <-- [error]');
        }
        /************************************************************************************************/
        $Logger->write_log('file_exists --> ['.$ruta_80x60.$nom_img.']');
        if (file_exists($ruta_80x60.$nom_img)) {
            $Logger->write_log('            <-- [ok]');
            
            $Logger->write_log('copy --> ['.$ruta_80x60.$nom_img.']');
            if (!copy($ruta_80x60.$nom_img, $ruta_80x60.$nom_fin)) {
                $Logger->write_log('     <-- [error]');
            }else{
                $Logger->write_log('     <-- [ok]');
                unlink($ruta_80x60.$nom_img);
            }
        }else{
            $Logger->write_log('            <-- [error]');
        }
        /************************************************************************************************/
        $Logger->write_log('file_exists --> ['.$ruta_215.$nom_img.']');
        if (file_exists($ruta_215.$nom_img)) {
            $Logger->write_log('            <-- [ok]');
            
            $Logger->write_log('copy --> ['.$ruta_215.$nom_img.']');
            if (!copy($ruta_215.$nom_img, $ruta_215.$nom_fin)) {
                $Logger->write_log('     <-- [error]');
            }else{
                $Logger->write_log('     <-- [ok]');
                unlink($ruta_215.$nom_img);
            }
        }else{
            $Logger->write_log('            <-- [error]');
        }
        /************************************************************************************************/
        $Logger->write_log('file_exists --> ['.$ruta_125.$nom_img.']');
        if (file_exists($ruta_125.$nom_img)) {
            $Logger->write_log('            <-- [ok]');
            
            $Logger->write_log('copy --> ['.$ruta_125.$nom_img.']');
            if (!copy($ruta_125.$nom_img, $ruta_125.$nom_fin)) {
                $Logger->write_log('     <-- [error]');
            }else{
                $Logger->write_log('     <-- [ok]');
                unlink($ruta_125.$nom_img);
            }
        }else{
            $Logger->write_log('            <-- [error]');
        }
        /************************************************************************************************/
    }
}
?>