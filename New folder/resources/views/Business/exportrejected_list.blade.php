<?php
ob_start();
$filename = 'Business Rejected List' . date('d-m-Y H:i:s') . '.xls';
ob_end_clean();

echo 'No' . "\t" . 'Business Type' . "\t" . 'Given By' . "\t" . 'Given To' . "\t" . 'Amount' . "\t" . 'Business date' . "\t" . 'Status' . "\n";

$i = 1;
$totalAmount = 0; // Initialize total amount

foreach ($datas as $row) {
    // Add the current amount to the total
    $totalAmount += $row->Business_amount;

    echo $i . "\t" . ($row->business_type == 1 ? 'Direct' : 'Reference') . "\t" . $row->business_from . "\t" . $row->business_to . "\t" . $row->Business_amount . "\t" . Carbon\Carbon::parse($row->business_Date)->format('d-m-Y') . "\t" . ($row->isapproved_status == 2 ? 'Rejected' : '') . "\n";
    $i++;
}

// Output the total amount row
echo "Total: \t \t \t \t $totalAmount \t \t \n";

header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=\"$filename\"");
exit();
?>
