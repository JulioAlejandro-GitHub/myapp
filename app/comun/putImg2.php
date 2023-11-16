<?php


// get the q parameter from URL
$url = $_POST["url"];

$nameOfDownload = 'my-image.jpg';

file_put_contents($nameOfDownload, file_get_contents($url));

echo "File downloaded!"

?>