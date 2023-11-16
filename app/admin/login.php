<?php
include_once '../comun/session.php';
require_once '../comun/class.session.php';
require_once '../comun/utiles.php';

$Login = new Session();

$username = $_POST['username'];
$password = sha1($_POST['password']);

if (!$username || !$password) {
    die('Usuario contraseña requerido');
}

//busca si es admin
$resultLogin = $Login->loginVendedor(array(
    'VENDEDOR_EMAIL'    => $username,
    'VENDEDOR_PASSWORD' => $password
));

if($resultLogin->num_rows) {
    $row_login = $resultLogin->fetch_assoc();
    
    $_SESSION['ID_AUTOMOTORA'] = $row_login['AUTOMOTORA_ID_AUTOMOTORA'];
    $_SESSION['AUTOMOTORA_ID_AUTOMOTORA'] = $row_login['AUTOMOTORA_ID_AUTOMOTORA'];
    $_SESSION['AUTOMOTORA_ID_MATRIZ']     = $row_login['AUTOMOTORA_ID_MATRIZ'];
    $_SESSION['AUTOMOTORA_ID_CIUDAD']     = $row_login['AUTOMOTORA_ID_CIUDAD'];
    $_SESSION['AUTOMOTORA_RUT']           = $row_login['AUTOMOTORA_RUT'];
    $_SESSION['AUTOMOTORA_NOMBRE']        = $row_login['AUTOMOTORA_NOMBRE'];
    $_SESSION['AUTOMOTORA_FONO']          = $row_login['AUTOMOTORA_TELEFONO'];
    $_SESSION['AUTOMOTORA_EMAIL']         = $row_login['AUTOMOTORA_EMAIL'];
    $_SESSION['AUTOMOTORA_IMG']           = $row_login['AUTOMOTORA_IMG'];
    $_SESSION['AUTOMOTORA_URL']           = $row_login['AUTOMOTORA_URL'];
    $_SESSION['AUTOMOTORA_DIRECCION']     = $row_login['AUTOMOTORA_DIRECCION'];
    
    $automotora_horario_lun_vie  = $row_login['AUTOMOTORA_HORARIO_LUN_VIE'];
    $automotora_horario_sab      = $row_login['AUTOMOTORA_HORARIO_SAB'];
    $automotora_horario_dom      = $row_login['AUTOMOTORA_HORARIO_DOM'];
    
    $auto_horario = "";
    if ($auto_horario_lun_vie){ 
        $auto_horario .= "Lunes a Viernes (".$auto_horario_lun_vie.")"; 
    }
    if ($auto_horario_sab){ 
        $auto_horario .= " / Sábado (".$auto_horario_sab.")"; 
    }
    if ($auto_horario_dom){ 
        $auto_horario .= " / Domingo (".$auto_horario_dom.")"; 
    }
        
    $_SESSION['AUTOMOTORA_HORARIO'] = $auto_horario;
    
    $_SESSION['ID_VENDEDOR'] = $row_login['VENDEDOR_ID_VENDEDOR'];
    $_SESSION['VENDEDOR_ID_VENDEDOR'] = $row_login['VENDEDOR_ID_VENDEDOR'];
    $_SESSION['VENDEDOR_EMAIL']       = $row_login['VENDEDOR_EMAIL'];
    $_SESSION['VENDEDOR_NOMBRE']      = $row_login['VENDEDOR_NOMBRE'];
    $_SESSION['VENDEDOR_APP']         = $row_login['VENDEDOR_APELLIDO_PATERNO'];
    $_SESSION['VENDEDOR_APM']         = $row_login['VENDEDOR_APELLIDO_MATERNO'];
    $_SESSION['VENDEDOR_RUT']         = $row_login['VENDEDOR_RUT'];
    $_SESSION['VENDEDOR_TELEFONO']    = $row_login['VENDEDOR_TELEFONO'];
    $_SESSION['VENDEDOR_MOVIL']       = $row_login['VENDEDOR_MOVIL'];
    $_SESSION['VENDEDOR_TIPO']        = $row_login['VENDEDOR_TIPO'];
    
    $_SESSION['USUARIO_NOMBRE'] = $_SESSION['VENDEDOR_NOMBRE'];
    $_SESSION['USUARIO_TIPO']   = 'vendedor';
    $_SESSION['SESSION_AUTENTIFICADA'] = 1;
    
    $login_message = 'LOGIN_ADMIN_OK';
}
else {
    //busca si es usuario
    $resultLogin = $Login->loginVisitante(array(
        'VISITANTE_EMAIL'    => $username,
        'VISITANTE_PASSWORD' => $password
    ));

    if($resultLogin->num_rows) {
        $row_login = $resultLogin->fetch_assoc();

        $_SESSION['VISITANTE_ID_VISITANTE'] = $row_login['VISITANTE_ID_VISITANTE'];
        $_SESSION['VISITANTE_EMAIL']        = $row_login['VISITANTE_EMAIL'];
        $_SESSION['VISITANTE_NOMBRE']       = $row_login['VISITANTE_NOMBRE'];
        $_SESSION['VISITANTE_APP']          = $row_login['VISITANTE_APELLIDO_PATERNO'];
        $_SESSION['VISITANTE_APM']          = $row_login['VISITANTE_APELLIDO_MATERNO'];
        $_SESSION['VISITANTE_RUT']          = $row_login['VISITANTE_RUT'];
        
        $_SESSION['USUARIO_NOMBRE'] = $_SESSION['VISITANTE_NOMBRE'];
        $_SESSION['USUARIO_TIPO']   = 'visitante';
        $_SESSION['SESSION_AUTENTIFICADA'] = 1;
        
        $login_message = 'LOGIN_USER_OK';
    }    
    else {
        //no es admin o usuario
        $login_message = 'LOGIN_ERROR';
    }
}

echo $login_message;
?>