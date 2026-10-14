<?php
ob_start();
$filename = 'Cluster_fest_export_' . date('d-m-Y H:i:s') . '.xls';
ob_end_clean();

echo 'No' . "\t" . 'Name' . "\t" . 'Brand Name' . "\t" . 'City' . "\t" . 'Phone number' . "\t" . 'Business Category' . "\t" . 'Business Profile in Brief' . "\t" . 'Business Model' . "\t" . 'Referred By' . "\t" . 'Reference name' . "\t" . 'Payment Date' . "\t" . 'Payment Status' . "\n";

$i = 1;
foreach ($Clusterfish as $row) {
    $paymentDate = $row->created_at ? date('d-m-Y', strtotime($row->created_at)) : 'null';
    $paymentStatus = $row->Payment_Status == 1 ? 'success' : ($row->Payment_Status == 0 ? 'pending' : 'null');

    echo $i . "\t" . ($row->name ?? 'null') . "\t" . ($row->Brand_name ?? 'null') . "\t" . ($row->City ?? 'null') . "\t" . ($row->Phonenumber ?? 'null') . "\t" . ($row->Buisness_Category ?? 'null') . "\t" . ($row->Buisness_Profile_in_Brief_ ?? 'null') . "\t" . ($row->Buisness_Model ?? 'null') . "\t" . ($row->Referred_By ?? 'null') . "\t" . ($row->reference_name ?? 'null') . "\t" . $paymentDate . "\t" . $paymentStatus . "\n";
    $i++;
}

header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=\"$filename\"");
exit();
?>
