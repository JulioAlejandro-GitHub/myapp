<?php
require_once './session.php';
require_once './BD.php';
require_once './utiles.php';

$CAT    = new Catalogo();


if ($_SESSION['VISITANTE_ID_VISITANTE']) {
    $nombre = $_SESSION['VISITANTE_NOMBRE'];
}else if ($_SESSION['VENDEDOR_ID_VENDEDOR']) {
    $nombre     = $_SESSION['VENDEDOR_NOMBRE'];
    $automotora = $_SESSION['AUTOMOTORA_ID_AUTOMOTORA'];
}
?>

<script type="text/javascript" src="include/js/menu.js"></script>


<div class="btns_view">
    <span onClick="_gaq.push(['_trackEvent', 'BLOCK','<?=$automotora?>','<?=$nombre?>']);" class="view_block" id="menu-search-view-block"></span>
    <span onClick="_gaq.push(['_trackEvent', 'LIST','<?=$automotora?>','<?=$nombre?>']);" class="view_list" id="menu-search-view-list"></span>
</div>


<ul>
    <? if ($_SESSION['USUARIO_TIPO'] == 'vendedor') { ?>
        
<!--        
        <li><a id="menu-search-view-block" class="menu-item" href="#" onClick="_gaq.push(['_trackEvent', 'BLOCK','<?=$automotora?>','<?=$nombre?>']);">BLOCK</a></li>
        <li><a id="menu-search-view-list"  class="menu-item" href="#" onClick="_gaq.push(['_trackEvent', 'LIST','<?=$automotora?>','<?=$nombre?>']);">LIST</a></li>
        -->
        
        <li><a id="menu-admin-automotora"  class="menu-item" href="#" onClick="_gaq.push(['_trackEvent', 'AUTOMOTORA','<?=$automotora?>','<?=$nombre?>']);">AUTOMOTORA</a></li>
        
        <!--        
        <li><a id="menu-admin-search-guestview-block" class="menu-item" href="#" onClick="_gaq.push(['_trackEvent', 'BLOCK VISITANTE','<?=$automotora?>','<?=$nombre?>']);">BLOCK VISITANTE</a></li>
        <li><a id="menu-admin-search-guestview-list" class="menu-item" href="#" onClick="_gaq.push(['_trackEvent', 'LIST VISITANTE','<?=$automotora?>','<?=$nombre?>']);">LIST VISITANTE</a></li>
        -->
        
    <? }?>
</ul>