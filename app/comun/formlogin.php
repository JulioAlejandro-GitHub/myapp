<?php
require_once './session.php';
require_once './BD.php';
require_once './utiles.php';

if ($_SESSION['SESSION_AUTENTIFICADA'] == 1) {
    header("Location: formlogout.php");
}
?>

<script type="text/javascript" src="include/js/session.js"></script>
<script type="text/javascript" src="include/js/guest.js"></script>
<!--    
<h3>Ingreso</h3>
<div class="lgninput">
    <label>Usuario</label>
    <input type="text" name="usr" id="login-username" />
</div>
<div class="lgninput">
    <label>Clave</label>
    <input type="password" name="pwd" id="login-password" />
</div>
<div class="lgninput butt"><button onclick="session.login()">Ingresar</button></div>
<a href="#" onclick="guest.addVisitanteForm()" style="float:right">Registrarse</a>
<span id="login-message-error" class="error"></span>-->


            <h3>Ingreso</h3>
            <div class="lgninput">
                <label>Usuario</label>
                <input name="usr" id="login-username" type="text">
            </div>
            <div class="lgninput">
                <label>Clave</label>
                <input name="pwd" id="login-password" type="password">
            </div>
            <div class="lgninput butt"><button onclick="session.login()">Ingresar</button></div>
            <span id="login-message-error" class="error"></span>
            <!--registrate aqui-->
            <div class="regishere">
                <span class="btn" onclick="guest.addVisitanteForm()">REGISTRATE</span>
            </div>
            <span id="login-message-error" class="error"></span>