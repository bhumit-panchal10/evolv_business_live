<?php
ob_start();
$filename = 'Fianced List' . date('d-m-Y H:i:s') . '.xls';

ob_end_clean();

echo 'No' . "\t" . 'Model Code' . "\t" . 'Serial No' . "\t" . 'Dealer Code' . "\t" . 'Invoice No' . "\t" . 'Finance Date' . "\n";

$i = 1;
foreach ($Product as $row) {
    $Date = '';
    if ($row->financedate) {
        $Date = date('d-m-Y', strtotime($row->financedate));
    } else {
        $Date = '-';
    }

    echo $i . "\t" . $row->model_code . "\t" . $row->serial_no . "\t" . $row->dealer_code . "\t" . $row->invoice_no . "\t" . $Date . "\n";
    $i++;
}

header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=\"$filename\"");
exit();
