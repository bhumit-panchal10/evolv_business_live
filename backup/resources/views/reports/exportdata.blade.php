
<?php
ob_start();
$filename = 'Payment Report' . date('d-m-Y H:i:s') . '.xls';
ob_end_clean();

echo 'No' . "\t" . 'Member Name' . "\t" . 'Group Name' . "\t" . 'Categories' . "\t" . 'Renewal Date' . "\t" . 'Amount' . "\n";

$i = 1;
$totalAmount = 0; 

foreach ($datas as $row) {
    // Add the current amount to the total
    $totalAmount += $row->amount;

    echo $i . "\t" . $row->first_name . "\t" . $row->group_name . "\t" . $row->category_name . "\t" . Carbon\Carbon::parse($row->renewal_date)->format('d-m-Y') . "\t" . $row->amount . "\n";
    $i++;
}

// Output the total amount row
echo "Total: \t \t \t \t \t $totalAmount \n";

header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=\"$filename\"");
exit();
?>

