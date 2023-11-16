<?php
include_once '../comun/session.php';
require_once '../comun/class.admin.php';
require_once '../comun/BD.php';

if ($_SESSION['USUARIO_TIPO'] != 'vendedor') {
    echo 'No autorizado';
    exit;
}


$CAT    = new Catalogo();


$id_automotora = $_SESSION['AUTOMOTORA_ID_AUTOMOTORA'];
?>
<script type="text/javascript" src="include/js/admin.js"></script>
    
<div class="wrap bx cf">
    <div class="namegrid">
        <p><b>Sucursales</b></p><br/>
        <label>Región</label>
        <select id="admin-sucursal-region" onchange="admin.getCiudades();">
            <option value="" selected="selected">.:: TODAS ::.</option>
            <?
            $getRegiones = $CAT->getRegiones(
                                    array(
                                        'REGION_ID_PAIS' => 'CL'                    
                                    )
                                );
            while($row = $getRegiones->fetch_assoc()) { ?>
                <option value="<?=$row['REGION_ID_REGION']?>"><?=mb_strtoupper($row['REGION_NOMBRE'])?></option>
            <? } ?>
        </select>

        <label>Ciudad</label>
        <select id="admin-sucursal-ciudad" onchange="admin.getViewSucursales()">
            <option value="" selected="selected">.:: TODAS ::.</option>
            <?
            $getCiudades = $CAT->getCiudades(
                                    array(
                                        'CIUDAD_ID_PAIS' => 'CL'                    
                                    )
                                );
            while($row = $getCiudades->fetch_assoc()) { ?>
                <option class="search-dynamic" value="<?=$row['CIUDAD_ID_CIUDAD']?>"><?=mb_strtoupper($row['CIUDAD_NOMBRE'])?></option>
            <? } ?>
        </select>

        <span class="btn rgt" onclick="admin.addSucursalForm()">Agregar Sucursal</span>
    </div>
    <div class="grid_adm cf">

        <div id="admin-sucursales-container"></div>
    </div>

    <!--grid usuarios-->
        <div class="namegrid">
            <p><b>Vendedores</b></p><br/>
            <label>Sucursal</label>
            <?
            $CAT    = new Catalogo();
            ?>
            <select id="admin-automotora" onchange="admin.getViewVendedores()">
                <?
                $getAutomotoras = $CAT->getAutomotoras(
                                            array(
                                                'AUTOMOTORA_SUCURSAL'  => $id_automotora
                                            )
                                        );
                $num_rows_Automotoras = $getAutomotoras->num_rows;
                while($row = $getAutomotoras->fetch_assoc()) { 
                    ?>
                    <option class="search-dynamic" value="<?=$row['AUTOMOTORA_ID_AUTOMOTORA']?>" <?=$row['AUTOMOTORA_ID_AUTOMOTORA'] == $id_automotora ? "selected" : ""?>><?=mb_strtoupper($row['AUTOMOTORA_NOMBRE'])?></option>
                <? } ?>
            </select>            
            <span class="btn rgt" onclick="admin.addVendedorForm()">Agregar Vendedor</span>
        </div>
    <div class="grid_adm cf">
        <div id="admin-vendedores-container"></div>
    </div>
</div>