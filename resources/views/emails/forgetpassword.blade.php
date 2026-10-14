<?php

$root = $_SERVER['DOCUMENT_ROOT'];
$file = file_get_contents($root . '/evolv_business/mailers/forgetPassword.html', 'r');
$file = str_replace('#Link', $data['Link'], $file);

echo $file;

?>

