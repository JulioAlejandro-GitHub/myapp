<?php
function fprecio($num) {
    return  '$ '.number_format($num, 0, '', '.');
}


$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
//echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ;
//Salida: Viernes 24 de Febrero del 2012
//
//Salida: 24 Febrero 2012
//DATE_FORMAT(vehiculo.FEC_PUBLICACION, '%d %M %Y')


function get_2_img_udp($id_automotora, $img, $num){
    $ruta_include  = PATH_WEB_ABS_IMG;
    
    $nombre_img_400 = '';
    $nombre_img_80 = '';
    $aux_img = 'fotoupload_'.$num.'.png';
    
    
    $nom_fin   =  $img; // nombre final
    
    $ruta_400 = '../../include/img/catalog/'.$id_automotora.'/'.$nom_fin;
    $ruta_80  = '../../include/img/catalog/'.$id_automotora.'/thumbnails/'.$nom_fin;
    
    if (trim($img) !='') {
        if (file_exists($ruta_400)) {
            $img_400 = $ruta_include.'img/catalog/'.$id_automotora.'/'.$nom_fin;
            $nombre_img_400 = $nom_fin;
        }else{
            $img_400 = $ruta_include.'img/sinfoto_400x300.png';
            $nombre_img_400 = 'sinfoto_400x300.png';
        }
        if (file_exists($ruta_80)) {
            $img_80 = $ruta_include.'img/catalog/'.$id_automotora.'/thumbnails/'.$nom_fin;
            $nombre_img_80 = $nom_fin;
        }else{
            $img_80 = $ruta_include.'img/'.$aux_img;
            $nombre_img_80 = $aux_img;
        }
    }else{
        $img_80 = $ruta_include.'img/'.$aux_img;
        $img_400 = $ruta_include.'img/sinfoto_400x300.png';
        
        $nombre_img_80 = $aux_img;
        $nombre_img_400 = 'sinfoto_400x300.png';
        
    }
    return array ($img_400, $img_80, $nombre_img_400, $nombre_img_80);
}
function get_img_udp($id_automotora, $automotora_rut, $num, $id_vehiculo){
    $ruta_include  = PATH_WEB_ABS_IMG;
    
    $aux_img = 'fotoupload_'.$num.'.png';
    
    $extension = 'jpg';
    $nom_fin   =  $id_automotora.'_'.$automotora_rut.'_'.$num.'_'.$id_vehiculo.'.'.strtolower($extension); // nombre final
    
    $ruta_400 = '../../include/img/catalog/'.$id_automotora.'/'.$nom_fin;
    $ruta_80  = '../../include/img/catalog/'.$id_automotora.'/thumbnails/'.$nom_fin;
    
    if (file_exists($ruta_400)) {
        $img_400 = $ruta_include.'img/catalog/'.$id_automotora.'/'.$nom_fin;
    }else{
        $img_400 = $ruta_include.'img/sinfoto_400x300.png';
    }
    if (file_exists($ruta_80)) {
        $img_80 = $ruta_include.'img/catalog/'.$id_automotora.'/thumbnails/'.$nom_fin;
    }else{
        $img_80 = $ruta_include.'img/'.$aux_img;
    }
    
    return array ($img_400, $img_80); 
}

function get_2_img($id_automotora, $img, $num){
    $ruta_include  = PATH_WEB_ABS_IMG;
    
    $aux_img = 'fotoupload_'.$num.'.png';
    
    $nom_fin   =  $img; // nombre final
    
    if (trim($nom_fin) != '') {
        $ruta_400 = PATH_CATALOG_IMG.$id_automotora.'/'.$nom_fin;
        $ruta_80  = PATH_CATALOG_IMG.$id_automotora.'/thumbnails/'.$nom_fin;

        if (file_exists($ruta_400)) {
            $img_400 = $ruta_include.'img/catalog/'.$id_automotora.'/'.$nom_fin;
        }else{
            $img_400 = $ruta_include.'img/sinfoto_400x300.png';
        }
        if (file_exists($ruta_80)) {
            $img_80 = $ruta_include.'img/catalog/'.$id_automotora.'/thumbnails/'.$nom_fin;
        }else{
            $img_80 = $ruta_include.'img/'.$aux_img;
        }
    }else{
        $img_80 = $ruta_include.'img/'.$aux_img;
        $img_400 = $ruta_include.'img/sinfoto_400x300.png';
    }
    
    return array ($img_400, $img_80); 
}
function get_img($id_automotora, $automotora_rut, $num, $id_vehiculo){
    $ruta_include  = PATH_WEB_ABS_IMG;
    
    $aux_img = 'fotoupload_'.$num.'.png';
    
    $extension = 'jpg';
    $nom_fin   =  $id_automotora.'_'.$automotora_rut.'_'.$num.'_'.$id_vehiculo.'.'.strtolower($extension); // nombre final
    
    $ruta_400 = PATH_CATALOG_IMG.$id_automotora.'/'.$nom_fin;
    $ruta_80  = PATH_CATALOG_IMG.$id_automotora.'/thumbnails/'.$nom_fin;
    
    if (file_exists($ruta_400)) {
        $img_400 = $ruta_include.'img/catalog/'.$id_automotora.'/'.$nom_fin;
    }else{
        $img_400 = $ruta_include.'img/sinfoto_400x300.png';
    }
    if (file_exists($ruta_80)) {
        $img_80 = $ruta_include.'img/catalog/'.$id_automotora.'/thumbnails/'.$nom_fin;
    }else{
        $img_80 = $ruta_include.'img/'.$aux_img;
    }
    
    return array ($img_400, $img_80); 
}

function get_temo_or_img($id_automotora, $automotora_rut, $num, $id_vehiculo){
    get_img_udp($id_automotora, $automotora_rut, $num, $id_vehiculo);
    
    
//    $ruta_absoluta = 'C:/AppServ/www/ACH/';
//    $ruta_include  = 'http://127.0.0.1/ACH/include/';
//    
//    
//    if ($num == 1) { $aux_img = 'fotoupload_1.png'; }
//    if ($num == 2) { $aux_img = 'fotoupload_2.png'; }
//    if ($num == 3) { $aux_img = 'fotoupload_3.png'; }
//    if ($num == 4) { $aux_img = 'fotoupload_4.png'; }
//    if ($num == 5) { $aux_img = 'fotoupload_5.png'; }
//    
//    
//    $ruta_400 = $ruta_absoluta.'include/img/catalog/'.$id_automotora.'/';
//    $ruta_80   = $ruta_absoluta.'include/img/catalog/'.$id_automotora.'/thumbnails/';
//    
//
//    $extension = 'jpg';
//    $nom_fin   =  $id_automotora.'_'.$automotora_rut.'_'.$num.'_'.$id_vehiculo.'.'.strtolower($extension); // nombre temporal
//    
//    if (file_exists($ruta_400.$nom_fin)) {
//        $img_400 = $ruta_400.$nom_fin;
//        $img_400 = $ruta_include.'img/catalog/'.$id_automotora.'/'.$nom_fin;
//    }else{
//        $nom_fin   =  "tmp___".$id_automotora.'_'.$automotora_rut.'_'.$num.".".strtolower($extension); // nombre temporal
//        if (file_exists($ruta_400.$nom_fin)) {
//            $img_400 = $ruta_include.'img/catalog/'.$id_automotora.'/'.$nom_fin;
//        }else{
//            $img_400 = $ruta_include.'img/sinfoto_400x300.png';
//        }
//    }
//    if (file_exists($ruta_80.$nom_fin)) {
//        $img_80 = $ruta_80.$nom_fin;
//        $img_80 = $ruta_include.'img/catalog/'.$id_automotora.'/thumbnails/'.$nom_fin;
//    }else{
//        $nom_fin   =  "tmp___".$id_automotora.'_'.$automotora_rut.'_'.$num.".".strtolower($extension); // nombre temporal
//        if (file_exists($ruta_80.$nom_fin)) {
//            $img_400 = $ruta_include.'img/catalog/'.$id_automotora.'/thumbnails/'.$nom_fin;
//        }else{
//            $img_400 = $ruta_include.'img/sinfoto_400x300.png';
//        }
//    }
//    return array ($img_400, $img_80); 
}

function getExtension($file) {
    $partes    = explode(".", $file);
    return strtolower(end($partes));
}

?>
