
<?php
ob_start();
$filename = 'Reference Pending List' . date('d-m-Y H:i:s') . '.xls';
ob_end_clean();

echo 'No' . "\t" . 'Given By' . "\t" . 'Given To' . "\t" . 'Company Name' . "\t" . 'Contact person' . "\t" . 'Email' . "\t" . 'Phone Number' . "\t" . 'Reference Date' . "\t" . 'Reference For Message' . "\t" . 'Status' . "\n";

$i = 1;


foreach ($datas as $row) {

    echo $i . "\t" . $row->Reference_from . "\t" . $row->Reference_to . "\t" . $row->Company_Name . "\t" . $row->Reference_Name . "\t" . $row->Email . "\t" . $row->phonenumber . "\t" . Carbon\Carbon::parse($row->Reference_Date)->format('d-m-Y') . "\t" . $row->Refer_for_message . "\t" . ($row->isapproved_status == 0 ? 'Pending' : '') . "\n";
    $i++;
}

header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=\"$filename\"");
exit();
?>


