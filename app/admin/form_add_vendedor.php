<?php
include_once '../comun/session.php';
require_once '../comun/class.admin.php';
require_once '../comun/BD.php';

if ($_SESSION['USUARIO_TIPO'] != 'vendedor') {
    echo 'No autorizado';
    exit;
}

$CAT    = new Catalogo();
?>

<style>
    .admin-add-usuario{
        font-family:Verdana;
        font-size:13px;
        width: 300px;
    }
</style>

<div class="admin-add-usuario">
    <p><b>Agregar Vendedor</b></p><br/>

    <span>Email</span>
    <p><input type="text" id="vendedor-email"><p/>
    
    <span>Contraseña</span>
    <p><input type="password" id="vendedor-password"><p/>
    
    <span>Repetir Contraseña</span>
    <p><input type="password" id="vendedor-password-rep"><p/>
    
    <span>Rut</span>
    <p><input type="text" id="vendedor-rut"><p/>
    
    <span>Nombre</span>
    <p><input type="text" id="vendedor-nombre"><p/>
    
    <span>Apellido Paterno</span>
    <p><input type="text" id="vendedor-apellidopaterno"><p/>
    
    <span>Apellido Materno</span>
    <p><input type="text" id="vendedor-apellidomaterno"><p/>
    
    <span>Dirección</span>
    <p><input type="text" id="vendedor-direccion"><p/>
    
    <span>Teléfono</span>
    <p><input type="text" id="vendedor-telefono"><p/>
    
    <span>Móvil</span>
    <p><input type="text" id="vendedor-movil"><p/>
</div>

<div id="vendedor-submit-loader"></div>
<span class="btn rgt" onclick="admin.addVendedor()">Agregar</span>
<span class="btn rgt" onclick="$.fancybox.close()">Cancelar</span>
