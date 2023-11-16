<?php
require_once '../comun/session.php';

if (session_destroy()) {
    $logout_message = "LOGOUT_OK";
}
else {
    $logout_message = "LOGOUT_ERROR";    
}

echo $logout_message;
?>