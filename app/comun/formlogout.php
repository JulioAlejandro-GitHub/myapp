<?php
require_once './session.php';
require_once './BD.php';
require_once './utiles.php';
require_once './class.user.php';
?>

<script type="text/javascript" src="include/js/session.js"></script>
<script type="text/javascript" src="include/js/user.js"></script>

<? if ($_SESSION['USUARIO_TIPO'] == 'vendedor') { ?>
    <h3></h3>
    <div class="lgninput">
        <label>Bienvenido, <b><?=$_SESSION['USUARIO_NOMBRE']?></b></label>
    </div>
    <div class="lgninput">
        <label>(<?=$_SESSION['USUARIO_TIPO']?>)</label>
    </div>

    <div class="lgninput butt"><button onclick="session.logout()">Cerrar sesión</button></div>
    <span id="login-message-error" class="error"></span>

<? }else if ($_SESSION['USUARIO_TIPO'] == 'visitante') { ?>
    
    <a href="javascript:user.toggleFavoritos()">Favoritos</a>
    <a href="javascript:user.editVisitanteForm()">Mis datos</a>
    
    
    
    
    
    
 <header>
    <div class="logo bx">
        <h1>Solo Automotoras</h1>
    </div>
    <div id="login-form" class="loginhead">
        <div class="userdata">
            <button onclick="user.toggleLoginUser()"><img src="include/img/user_mini.png" width="20" height="20"><?=$_SESSION['USUARIO_NOMBRE']?></button>
        </div>
        <div class="misfavoritos">
            <button onclick="user.toggleFavoritos()"><img src="include/img/fav.png" width="20" height="20">Mis Favoritos</button>
        </div>

        <!--cuenta y logout dropdown-->
        <ul class="dropdownhead user" id="login-user-container" style="display:none">
            <li class="cuentauser">
                <img src="include/img/user.png" width="45" height="45">
                <p>Usuario Registrado</p>
                <button onclick="user.editVisitanteForm()" class="misdatos">Mis datos</button>
            </li>
            <li class="logoutuser">
                <button onclick="session.logout()">Cerrar sesión</button>
            </li>
        </ul>
        
        
        
        <!--cuenta y logout dropdown-->
        <ul class="dropdownhead" id="user-favorites-container" style="display:none;">
        <div id="favoritescontainer" style="display:block;">
        <?
        $User   = new User();
        $CAT    = new Catalogo();

        $id_visitante  = $_SESSION['VISITANTE_ID_VISITANTE'];

        $getFavoritos = $User->getFavoritos(array(
                            'FAVORITO_ID_VISITANTE'  => $id_visitante
                       ));

        $num_rows_Favoritos = $getFavoritos->num_rows;

        while($rowFav = $getFavoritos->fetch_assoc()) {
            $favorito_id_favorito       = trim($rowFav['FAVORITO_ID_FAVORITO']);
            $favorito_id_vehiculo       = trim($rowFav['FAVORITO_ID_VEHICULO']);
            
            //Datos vehículo
            $getListado = $CAT->getListado(array(
                'VEHICULO_ID_VEHICULO'  => $favorito_id_vehiculo            
            ));    

            $num_rows_Listado = $getListado->num_rows;
            
            while($row = $getListado->fetch_assoc()) {
                $automotora_id_automotora       = trim($row['AUTOMOTORA_ID_AUTOMOTORA']);
                $automotora_id_matriz           = trim($row['AUTOMOTORA_ID_MATRIZ']);
                $automotora_id_ciudad           = trim($row['AUTOMOTORA_ID_CIUDAD']);
                $automotora_rut                 = trim($row['AUTOMOTORA_RUT']);
                $automotora_nombre              = trim($row['AUTOMOTORA_NOMBRE']);
                $automotora_fono                = trim($row['AUTOMOTORA_TELEFONO']);
                $automotora_email               = trim($row['AUTOMOTORA_EMAIL']);
                $automotora_fax                 = trim($row['AUTOMOTORA_FAX']);
                $automotora_razon               = trim($row['AUTOMOTORA_RAZON_SOCIAL']);
                $automotora_img                 = trim($row['AUTOMOTORA_IMG']);
                $automotora_url                 = trim($row['AUTOMOTORA_URL']);    
                $automotora_direccion           = trim($row['AUTOMOTORA_DIRECCION']);
                $automotora_numero              = trim($row['AUTOMOTORA_NUMERO']);
                $automotora_horario_lun_vie     = trim($row['AUTOMOTORA_HORARIO_LUN_VIE']);
                $automotora_horario_sab         = trim($row['AUTOMOTORA_HORARIO_SAB']);
                $automotora_horario_dom         = trim($row['AUTOMOTORA_HORARIO_DOM']);  
                $automotora_estado              = trim($row['AUTOMOTORA_ESTADO']);
                $automotora_fecha_ingreso       = trim($row['AUTOMOTORA_FECHA_INGRESO']);
                $automotora_fecha_modificacion  = trim($row['AUTOMOTORA_FECHA_MODIFICACION']);

                $vendedor_id_automotora    = trim($row['VENDEDOR_ID_AUTOMOTORA']);
                $vendedor_id_vendedor      = trim($row['VENDEDOR_ID_VENDEDOR']);
                $vendedor_nombres          = trim($row['VENDEDOR_NOMBRE']);
                $vendedor_app              = trim($row['VENDEDOR_APELLIDO_PATERNO']);
                $vendedor_apm              = trim($row['VENDEDOR_APELLIDO_MATERNO']);
                $vendedor_rut              = trim($row['VENDEDOR_RUT']);
                $vendedor_email            = trim($row['VENDEDOR_EMAIL']);
                $vendedor_pwd              = trim($row['VENDEDOR_PASSWORD']);
                $vendedor_telefono         = trim($row['VENDEDOR_TELEFONO']);
                $vendedor_movil            = trim($row['VENDEDOR_MOVIL']);
                $vendedor_direccion        = trim($row['VENDEDOR_DIRECCION']);
                $vendedor_fec_ingreso      = trim($row['VENDEDOR_FECHA_INGRESO']);
                $vendedor_fec_modificacion = trim($row['VENDEDOR_FECHA_MODIFICACION']);
                $vendedor_tipo             = trim($row['VENDEDOR_TIPO']);

                $vehiculo_id_vehiculo        = trim($row['VEHICULO_ID_VEHICULO']);
                $vehiculo_id_marca           = trim($row['VEHICULO_ID_MARCA']);
                $vehiculo_id_vendedor        = trim($row['VEHICULO_ID_VENDEDOR']);
                $vehiculo_id_ciudad          = trim($row['VEHICULO_ID_CIUDAD']);
                $vehiculo_modelo             = trim($row['MODELO_NOMBRE']);
                $modelo_id_modelo            = trim($row['MODELO_ID_MODELO']);

                $vehiculo_patente            = trim($row['VEHICULO_PATENTE']);
                $vehiculo_annio              = trim($row['VEHICULO_ANNIO']);
                $vehiculo_kilometros         = trim($row['VEHICULO_KILOMETROS']);
                $vehiculo_precio             = trim($row['VEHICULO_PRECIO']);
                $vehiculo_descripcion        = trim($row['VEHICULO_DESCRIPCION']);
                $vehiculo_fecha_publicacion  = trim($row['VEHICULO_FECHA_PUBLICACION']);
                $vehiculo_fecha_modificacion = trim($row['VEHICULO_FECHA_MODIFICACION']);
                $vehiculo_estado             = trim($row['VEHICULO_ESTADO']); 

                $VEHICULO_IMG1             = trim($row['VEHICULO_IMG1']);
                $VEHICULO_IMG2             = trim($row['VEHICULO_IMG2']);
                $VEHICULO_IMG3             = trim($row['VEHICULO_IMG3']);
                $VEHICULO_IMG4             = trim($row['VEHICULO_IMG4']);
                $VEHICULO_IMG5             = trim($row['VEHICULO_IMG5']);

                $annio = substr($vehiculo_fecha_publicacion, 0, 4);
                $mes   = substr($vehiculo_fecha_publicacion, 5, 2);
                $dia   = substr($vehiculo_fecha_publicacion, 8, 2);
                
                $ruta_125     = '../../'.PATH_CATALOG_IMG.$automotora_id_automotora.'/thumbnails/125/';
                $image = is_file($ruta_125.$VEHICULO_IMG1) ? PATH_CATALOG_IMG.$automotora_id_automotora.'/thumbnails/125/'.$VEHICULO_IMG1 : "include/img/sinfoto_125x93.png";
                ?>
                <div class="list_post_th">
                    <img style="cursor:pointer" src="<?=$image?>" onclick="ver_ficha(<?=$vehiculo_id_vehiculo?>);" height="93" width="125">
                    <div class="list_maindata">
                        <h3><?=mb_strtoupper($marca_nombre)?></h3>
                        <p><?=$vehiculo_annio?></p>
                        <p class="price"><?=fprecio($vehiculo_precio)?></p>
                    </div>
                    <a href="#" onclick="user.deleteFavorito({ id_favorito: '<?=$favorito_id_favorito?>', marca: '<?=$marca_nombre?>', modelo: '<?=$vehiculo_modelo?>', precio:'<?=fprecio($vehiculo_precio)?>'});">
                        <img src="include/img/quitarfav.png" width="20" height="20">
                    </a>
                </div>
        <? }
        }
        ?>

        <? if (!$num_rows_Favoritos) { ?>
           No ha agregado vehículos favoritos 
        <? } ?>
           </div>
        </ul>
    </div> 
</header>
<? } ?>