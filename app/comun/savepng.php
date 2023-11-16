<?php

$imgData = explode(",", $_POST['imgData']);
$imgName = explode(",", $_POST['imgName']);
file_put_contents($_POST['imgName'], base64_decode($imgData[1]));



echo($_POST['imgName']);
/*
$aaa = $_POST['imgData'];
$imgName = $_POST['imgName'];
file_put_contents($imgName , base64_decode($aaa[1]));
*/
?>