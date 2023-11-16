<?php
require_once '../comun/session.php';
require_once '../comun/class.user.php';
require_once '../comun/class.session.php';

if ($_SESSION['USUARIO_TIPO'] != 'visitante') {
    echo 'No autorizado';
    exit;
}

$User    = new User();
$Session = new Session();

switch ($_POST['target']) {
    
    case 'favorito' :
        switch ($_POST['action']) {
            case 'add':
                $result = $User->addFavorito (
                    array(
                        'FAVORITO_ID_VISITANTE'          => $_SESSION['VISITANTE_ID_VISITANTE'],
                        'FAVORITO_ID_VEHICULO'           => $_POST['id_vehiculo'],
                    )
                );
                    
                $result = $result ? 'ADD_OK' : 'ADD_ERROR';

                break;

            
            case 'delete':
                $result = $User->deleteFavorito (
                    array(
                        'FAVORITO_ID_VISITANTE'          => $_SESSION['VISITANTE_ID_VISITANTE'],
                        'FAVORITO_ID_FAVORITO'           => $_POST['id_favorito']
                    )
                );
                    
                $result = $result ? 'DELETE_OK' : 'DELETE_ERROR';

                break;
        }
        
        break;
    
            case 'visitante':
                
                switch ($_POST['action']) {
                    case 'edit':
                        $email_exists = $Session->email_exists($_POST['email']);

                        if($email_exists && ($_POST['email'] != $_SESSION['VISITANTE_EMAIL']) ) {
                            $result = 'EDIT_EXISTS';
                        }
                        else {                        
                            $result = $User->editVisitante (
                                array(
                                    'VISITANTE_ID_VISITANTE'       => $_SESSION['VISITANTE_ID_VISITANTE'],
                                    'VISITANTE_EMAIL'              => $_POST['email'],
                                    'VISITANTE_PASSWORD'           => $_POST['password'],
                                    'VISITANTE_NOMBRE'             => $_POST['nombre'],
                                    'VISITANTE_APELLIDO_PATERNO'   => $_POST['apellidopaterno'],
                                    'VISITANTE_APELLIDO_MATERNO'   => $_POST['apellidomaterno'],
                                    'VISITANTE_RUT'                => $_POST['rut']
                                )
                            );

                            if($result) {
                                $result = 'EDIT_OK';
                                $_SESSION['USUARIO_NOMBRE'] = $_POST['nombre'];
                            }
                            else {
                                $result = 'EDIT_ERROR';
                            }
                        }
                        break;
                }
                
                break;
        
}

echo $result;
?>