
<?php
ob_start();
$filename = 'Business Analysis' . date('d-m-Y H:i:s') . '.xls';
ob_end_clean();

echo 'No' . "\t" . 'Member Name' . "\t" . 'Company Name' . "\t" . 'Phone Number' . "\t" . 'DirectBuinessGiven' . "\t" . 'DirectBusinessReceived' . "\t" . 'RefBuinessGiven' . "\t" . 'RefBusinessReceived' . "\t" . 'RefGiven' . "\t" . 'RefReceived' . "\n";


$i = 1;
$DirectBuinessGiven=0;
$DirectBusinessReceived=0;
$RefBuinessGiven=0;
$RefBusinessReceived=0;
$RefGiven=0;
$RefReceived=0;

foreach ($datas as $row) {
    // Add the current amount to the total
    $DirectBuinessGiven += $row->DirectBuinessGiven;
    $DirectBusinessReceived += $row->DirectBusinessReceived;
    $RefBuinessGiven += $row->RefBuinessGiven;
    $RefBusinessReceived += $row->RefBusinessReceived;
    $RefGiven += $row->RefGiven;
    $RefReceived += $row->RefReceived;

    echo $i . "\t" . $row->Contact_person . "\t" . $row->companyname . "\t" . $row->phonenumber . "\t" . $row->DirectBuinessGiven. "\t" . $row->DirectBusinessReceived . "\t" . $row->RefBuinessGiven . "\t" . $row->RefBusinessReceived . "\t" . $row->RefGiven . "\t" . $row->RefReceived . "\n";
    $i++;
}

// Output the total amount row
echo "DirectBuinessGiven: \t \t \t \t $DirectBuinessGiven \n";
echo "DirectBusinessReceived: \t \t \t \t \t $DirectBusinessReceived \n";
echo "RefBuinessGiven: \t \t \t \t \t \t $RefBuinessGiven \n";
echo "RefBusinessReceived: \t \t \t \t \t \t \t $RefBusinessReceived \n";
echo "RefGiven: \t \t \t \t \t \t \t \t $RefGiven \n";
echo "RefReceived: \t \t \t \t \t \t \t \t \t $RefReceived \n";


header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=\"$filename\"");
exit();
?>

