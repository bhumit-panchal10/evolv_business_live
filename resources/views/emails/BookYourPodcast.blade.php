<?php

$root = $_SERVER['DOCUMENT_ROOT'];
$file = file_get_contents($root . '/evolve_business/mailers/adminpodcast.html', 'r');
$file = str_replace('#Book_Your_Podcast', $data['Book_Your_Podcast'], $file);
$file = str_replace('#membername', $data['membername'], $file);
$file = str_replace('#memberemail', $data['memberemail'], $file);
$file = str_replace('#memberphonenumber', $data['memberphonenumber'], $file);

echo $file;
?>