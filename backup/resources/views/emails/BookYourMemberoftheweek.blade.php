<?php

$root = $_SERVER['DOCUMENT_ROOT'];
$file = file_get_contents($root . '/evolve_business/mailers/bookweek.html', 'r');

$file = str_replace('#Book_Your_Member_of_the_week', $data['Book_Your_Member_of_the_week'], $file);
$file = str_replace('#Member_of_the_week_end', $data['Member_of_the_week_end'], $file);

echo $file;
?>