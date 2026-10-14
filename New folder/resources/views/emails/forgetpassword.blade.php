<?php

$root = $_SERVER['DOCUMENT_ROOT'];
$file = file_get_contents($root . '/evolve_business/mailers/forgetPassword.html', 'r');
$file = str_replace('#Link', $data['Link'], $file);

echo $file;

?>

