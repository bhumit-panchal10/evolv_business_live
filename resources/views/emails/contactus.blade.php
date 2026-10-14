<?php

$root = $_SERVER['DOCUMENT_ROOT'];
$file = file_get_contents($root . '/evolve_business/mailers/contact.html', 'r');
$file = str_replace('#name', $data['name'], $file);
$file = str_replace('#email', $data['email'], $file);
$file = str_replace('#mobile', $data['mobile'], $file);
$file = str_replace('#message', $data['message'], $file);

echo $file;
?>