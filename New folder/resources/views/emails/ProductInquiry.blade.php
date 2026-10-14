<?php

$root = $_SERVER['DOCUMENT_ROOT'];
$file = file_get_contents($root . '/evolve_business/mailers/ProductInquiry.html', 'r');
$file = str_replace('#Name', $data['Name'], $file);
$file = str_replace('#email', $data['email'], $file);
$file = str_replace('#phone', $data['phone'], $file);
$file = str_replace('#Comment', $data['Comment'], $file);
$file = str_replace('#product_name', $data['product_name'], $file);

echo $file;
?>