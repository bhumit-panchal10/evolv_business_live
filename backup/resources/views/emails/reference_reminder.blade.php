<?php

$root = $_SERVER['DOCUMENT_ROOT'];
$file = file_get_contents($root . '/evolve_business/mailers/reference_reminder_email.html');
 
// Replace placeholders with actual data
$file = str_replace('#Reference_Name', $data['reference_name'], $file);
$file = str_replace('#Reference_from', $data['reference_from'], $file);
$file = str_replace('#Reference_to', $data['reference_to'], $file);
$file = str_replace('#Company_Name', $data['company_name'], $file);
$file = str_replace('#phonenumber', $data['phonenumber'], $file);
$file = str_replace('#Reference_Date', $data['reference_date'], $file);
 
// Add status/approve/reject links if required
$gu_id = $data['gu_id'] ?? '';
$statusUpdateLink = url('https://groath.in/newstatus/' . $gu_id);
$approveLink = 'https://groath.in/reference_approve/' . $gu_id;
$rejectLink = 'https://groath.in/reference_reject/' . $gu_id;

$file = str_replace('#status_update_link', $statusUpdateLink, $file);
$file = str_replace('#approve_link', $approveLink, $file);
$file = str_replace('#reject_link', $rejectLink, $file);

 
echo $file;
?>
 