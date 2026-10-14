<?php
ob_start();
$filename = 'Non-Fianced List' . date('d-m-Y H:i:s') . '.xls';

ob_end_clean();

echo 'No' . "\t" . 'Model Code' . "\t" . 'Serial No' . "\t" . 'Dealer Code' . "\t" . 'Invoice No' . "\n";

$i = 1;
foreach ($Product as $row) {
    echo $i . "\t" . $row->model_code . "\t" . $row->serial_no . "\t" . $row->dealer_code . "\t" . $row->invoice_no . "\n";
    $i++;
}

header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=\"$filename\"");
exit();
