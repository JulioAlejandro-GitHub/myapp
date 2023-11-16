<?php
$aaa = explode(",", $_POST['pngData']);
file_put_contents("invoicedata.png", base64_decode($aaa[1]));
?>