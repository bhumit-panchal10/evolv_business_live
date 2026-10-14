<?php

$root = $_SERVER['DOCUMENT_ROOT'];
$file = file_get_contents($root . '/evolve_business/mailers/adminpodcastweek.html', 'r');

$file = str_replace('#Bookweekstart', $data['Bookweekstart'], $file);
$file = str_replace('#Bookweekend', $data['Bookweekend'], $file);
$file = str_replace('#Book_week_time', $data['Book_week_time'], $file);
$file = str_replace('#membername', $data['membername'], $file);
$file = str_replace('#memberemail', $data['memberemail'], $file);
$file = str_replace('#memberphonenumber', $data['memberphonenumber'], $file);

echo $file;
?>