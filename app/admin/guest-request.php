<?php
require_once '../comun/config.php';
require_once '../comun/class.guest.php';
require_once '../comun/class.session.php';
require_once '../comun/phpmailer/class.phpmailer.php';

$Guest   = new Guest();
$Session = new Session();

switch ($_POST['target']) {
    /*******************************************************************************/
    case 'visitante' :
        switch ($_POST['action']) {
            case 'add':
                $email_exists = $Session->email_exists($_POST['email']);
                
                if($email_exists) {
                    $result = 'ADD_EXISTS';
                }
                else {
                    $result = $Guest->addVisitante (
                        array(
                            'VISITANTE_EMAIL'              => $_POST['email'],
                            'VISITANTE_PASSWORD'           => $_POST['password'],
                            'VISITANTE_NOMBRE'             => $_POST['nombre'],
                            'VISITANTE_APELLIDO_PATERNO'   => $_POST['apellidopaterno'],
                            'VISITANTE_APELLIDO_MATERNO'   => $_POST['apellidomaterno'],
                            'VISITANTE_RUT'                => $_POST['rut']
                        )
                    );

                    //envía correo de registro nuevo
                    $desde_nombre = PHPMAILER_FromName;
                    $desde_email  = PHPMAILER_FromEmail;

                    $responder_a_nombre = PHPMAILER_ReplyToName;
                    $responder_a_email  = PHPMAILER_ReplyToEmail;

                    $asunto = 'Bienvenido '.$_POST['nombre'].'!';

                    $html  = '
                             Bienvenido a AutomotoraChile <br/>
                             ';

                    $no_html = PHPMAILER_noHTML;

                    $mail = new PHPMailer(PHPMAILER_DEBUG); // Declaramos un nuevo correo, el parámetro true significa que mostrará excepciones y errores.
                    $mail->SetLanguage('es');

                    $mail->IsSMTP(); // Se especifica a la clase que se utilizará SMTP

                    try {
                        $mail->SMTPDebug  = PHPMAILER_SMTPDebug;       // Habilita información SMTP (opcional para pruebas)
                                                                       // 1 = errores y mensajes
                                                                       // 2 = solo mensajes
                        $mail->SMTPAuth   = PHPMAILER_SMTPAuth;        // Habilita la autenticación SMTP

                        $mail->SMTPSecure = PHPMAILER_SMTPSecure; 
                        $mail->Host       = PHPMAILER_Host;      
                        $mail->Port       = PHPMAILER_Port;
                        $mail->Username   = PHPMAILER_Username;
                        $mail->Password   = PHPMAILER_Password;
                        $mail->CharSet    = "UTF-8";

                        //A que dirección se puede responder el correo
                        $mail->AddReplyTo($responder_a_email, $responder_a_nombre);

                        //La dirección a dónde mandamos el correo
                        $mail->AddAddress($_POST['email'], $_POST['nombre']);

                        //De parte de quien es el correo
                        $mail->SetFrom($desde_email, $desde_nombre);

                        //Asunto del correo
                        $mail->Subject = $asunto;

                        //Mensaje alternativo en caso que el destinatario no pueda abrir correos HTML
                        $mail->AltBody = $no_html;

                        //El cuerpo del mensaje, puede ser con etiquetas HTML
                        $mail->MsgHTML($html);

                        //Archivos adjuntos
                        //$mail->AddAttachment('archivo.txt');      // Archivos Adjuntos

                        //Enviamos el correo
                        $mail->Send();
                    }
                    catch (phpmailerException $e) {
                        //echo $e->errorMessage(); //Errores de PhpMailer
                    } 
                    catch (Exception $e) {
                        //echo $e->getMessage(); //Errores de cualquier otro tipo
                    }                
                
                $result = $result ? 'ADD_OK' : 'ADD_ERROR';
                }
                
                break;
        }
        
        break;
        
}

echo $result;
?>
