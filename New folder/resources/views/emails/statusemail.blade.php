<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$file = file_get_contents($root . '/evolve_business/mailers/statusemail.html');

$file = str_replace('#business_type', $data['business_type'], $file);
$file = str_replace('#business_from', $data['business_from'], $file);
$file = str_replace('#business_to', $data['business_to'], $file);
$file = str_replace('#Business_amount', $data['Business_amount'], $file);
$file = str_replace('#business_Date', $data['business_Date'], $file);

$gu_id = $data['gu_id'] ?? '';
$statusUpdateLink = url('https://evolv.co.in/evolve_business/newstatus/' . $gu_id);
$approveLink = url('https://evolv.co.in/evolve_business/approve/' . $gu_id);
$rejectLink = url('https://evolv.co.in/evolve_business/reject/' . $gu_id);

$file = str_replace('#status_update_link', $statusUpdateLink, $file);
$file = str_replace('#approve_link', $approveLink, $file);
$file = str_replace('#reject_link', $rejectLink, $file);

echo $file;
?>
