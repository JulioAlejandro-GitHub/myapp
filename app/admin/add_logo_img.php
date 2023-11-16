<?
include_once '../comun/session.php';
require_once '../comun/utiles.php';
require_once '../comun/Logger.php';

$Logger = new Logger(LOG_NOMBRE);

$ruta_include = "../../include/";

$ruta_400x300 = $ruta_include.'img/catalog/'.$_SESSION['ID_AUTOMOTORA'].'/';
$ruta_80x60   = $ruta_include.'img/catalog/'.$_SESSION['ID_AUTOMOTORA'].'/thumbnails/';
$ruta_215     = $ruta_include.'img/catalog/'.$_SESSION['ID_AUTOMOTORA'].'/thumbnails/215/';
$ruta_125     = $ruta_include.'img/catalog/'.$_SESSION['ID_AUTOMOTORA'].'/thumbnails/125/';


$Logger->write_log("****************");
$Logger->write_log("Add IMG --> tipo        [{$_POST['tipo_logo']}]");
$Logger->write_log("        --> id_img      [{$_POST['id_img']}]");
$Logger->write_log("        --> id_img_temp [{$_POST['id_img_temp']}]");


if ($_POST['tipo_logo'] == 'crear') {
    
    $fileUpload = 'fileUpload'.$_POST['id_img'];
    
//    $partes    = explode(".", $_FILES[$fileUpload][name]); 
//    $extension = end($partes);
    $extension = getExtension($_FILES[$fileUpload][name]);
    
    $nom_img   =  "tmp___".$_SESSION['ID_AUTOMOTORA'].'_'.$_SESSION['AUTOMOTORA_RUT'].'_'.$_POST['id_img_temp'].".".$extension; // nombre temporal
    
    $Logger->write_log("        --> fileUpload [$fileUpload]");
    $Logger->write_log("        --> extension  [$extension]");
    $Logger->write_log("        --> nom_img    [$nom_img]");
    
    
}else{ // editar
    $extension = getExtension($_FILES[$fileUpload][name]);
    $nom_img   =  "img_".$_SESSION['rut_emp_usr'].".".strtolower($extension); // nombre final
}

$_SESSION['IMG'][$_POST['id_img_temp']] = $nom_img;


$Logger->write_log("        --> SESSION['IMG'][{$_SESSION['IMG'][$_POST['id_img_temp']]}]");


/**********************************************************************************************/
$tipo = substr($_FILES[$fileUpload]['type'], 0, 5); // obtiene type img

$Logger->write_log("        --> tipo [$tipo]");

// Intentamos Subir Archivo

$Logger->write_log("Subir Archivo --> [{$_FILES[$fileUpload]['tmp_name']}]");

if (isset($_FILES[$fileUpload]['tmp_name'])) { // (1) Comprovamos que existe el nombre temporal del archivo
    
    $Logger->write_log("              <-- [ok]");
    
    
    $Logger->write_log("archivo de imagen --> [$tipo]");
    
    if ($tipo == 'image') { // (2) - Comprovamos que se trata de un archivo de imagen
        
        $Logger->write_log("                  <-- [ok]");
        
        
        
        $Logger->write_log("copy FILES --> [$ruta_400x300$nom_img]");
        
        if (!copy($_FILES[$fileUpload]['tmp_name'], $ruta_400x300.$nom_img)) { // (3) copiar el archivo al servidor.
            
            $Logger->write_log("           <-- [error 1]");
            $estado=1;
        } else {
            $Logger->write_log("           <-- [ok]");
            
            include_once('thumb.php');
            $estado=0;
            
            //$ruta = $ruta_400x300.$nom_img;
            //$ruta = 'http://soloautomotoras.cl/platform-default/include/img/catalog/'.$_SESSION['ID_AUTOMOTORA'].'/'.$nom_img;
            //$ruta = PATH_WEB_ABS_IMG.'img/catalog/'.$_SESSION['ID_AUTOMOTORA'].'/'.$nom_img;
            $ruta = $ruta_include.'img/catalog/'.$_SESSION['ID_AUTOMOTORA'].'/'.$nom_img;
            
            /******************************************/
            $mythumb = new thumb();
            $mythumb->loadImage($ruta);
            $mythumb->resize(400, 'width');
            $mythumb->save($ruta_400x300.$nom_img, 100);
            /******************************************/
            
            /******************************************/
            $ruta_thumb = $ruta_80x60.$nom_img;
            
            $Logger->write_log("copy --> [$ruta][$ruta_thumb]");
            
            if (copy($ruta, $ruta_thumb)) {
                $Logger->write_log("     <-- [ok]");
                /******************************************/
                $thumb = new thumb();
                $thumb->loadImage($ruta_thumb);
                $thumb->resize(80, 'width');
                $thumb->save($ruta_thumb, 100);
                /******************************************/
                $estado = $nom_img;
            }else{
                $Logger->write_log("     <-- [error 4]");
                $estado=4;
            }
            /******************************************/
            
//            $mythumb = new thumb();
//            $mythumb->loadImage($ruta);
//            $mythumb->resize(215, 'width');
//            $mythumb->save($ruta_215.$nom_img, 100);
            
            /******************************************/
            $ruta_thumb = $ruta_215.$nom_img;
            $Logger->write_log("copy --> [$ruta][$ruta_thumb]");
            if (copy($ruta, $ruta_thumb)) {
                $Logger->write_log("     <-- [ok]");
                /******************************************/
                $thumb = new thumb();
                $thumb->loadImage($ruta_thumb);
                $thumb->resize(215, 'width');
                $thumb->save($ruta_thumb, 100);
                /******************************************/
                $estado = $nom_img;
            }else{
                $Logger->write_log("     <-- [error 4]");
                $estado=4;
            }
            /******************************************/
            
            
            
            
            
//            $mythumb = new thumb();
//            $mythumb->loadImage($ruta);
//            $mythumb->resize(125, 'width');
//            $mythumb->save($ruta_125.$nom_img, 100);
            
            /******************************************/
            $ruta_thumb = $ruta_125.$nom_img;
            $Logger->write_log("copy --> [$ruta][$ruta_thumb]");
            if (copy($ruta, $ruta_thumb)) {
                $Logger->write_log("     <-- [ok]");
                /******************************************/
                $thumb = new thumb();
                $thumb->loadImage($ruta_thumb);
                $thumb->resize(125, 'width');
                $thumb->save($ruta_thumb, 100);
                /******************************************/
                $estado = $nom_img;
            }else{
                $Logger->write_log("     <-- [error 4]");
                $estado=4;
            }
            /******************************************/
            
            
        }
    } else {
        $Logger->write_log("                  <-- [error 2]");
        $estado=2;
    }
} else {
    $Logger->write_log("              <-- [error 3][NO existe temporal del archivo]");
    $estado=3;
}
/**********************************************************************************************/
echo $estado;
?>