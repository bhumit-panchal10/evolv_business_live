<?php

$root = $_SERVER['DOCUMENT_ROOT'];
$file = file_get_contents($root . '/evolve_business/mailers/bookpodcast.html', 'r');
$file = str_replace('#Book_Your_Podcast', $data['Book_Your_Podcast'], $file);

echo $file;
?>