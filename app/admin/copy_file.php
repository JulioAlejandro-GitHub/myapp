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

$nom_img = 'tmp___1_111111111_1.jpeg';


//$ruta = $ruta_400x300.$nom_img;
//$ruta = 'http://soloautomotoras.cl/platform-default/include/img/catalog/'.$_SESSION['ID_AUTOMOTORA'].'/'.$nom_img;
$ruta = $ruta_include.'img/catalog/'.$_SESSION['ID_AUTOMOTORA'].'/'.$nom_img;

/******************************************/
$ruta_thumb = $ruta_80x60.$nom_img;

echo "copy --> [$ruta][$ruta_thumb]<br>";

if (copy($ruta, $ruta_thumb)) {
    echo"     <-- [ok]<br>";
}else{
    echo"     <-- [error]<br>";
}