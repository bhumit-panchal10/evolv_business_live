<?php
ob_start();
$filename = 'Member_Detail_' . date('d-m-Y_H:i:s') . '.xls';
ob_end_clean();

// Headers
echo "<table border='1'>";
echo "<tr style='text-align:center; font-weight:bold;'>";
echo "<th>No</th>";
echo "<th>Member Name</th>";
echo "<th>Brand Name</th>";
echo "<th>Phone Number</th>";
echo "<th>Email</th>";
echo "<th>City</th>";
echo "<th>Group Name</th>";
echo "<th>Category Name</th>";
echo "<th>Subscription Expired Date</th>";
echo "<th>Facebook Link</th>";
echo "<th>Youtube Link</th>";
echo "<th>Instagram Link</th>";
echo "<th>LinkedIn Link</th>";
echo "<th>Google Link</th>";
echo "<th>Date of Birth</th>";
echo "<th>Work Anniversary Date</th>";
echo "</tr>";

// Data
$i = 1;
foreach ($datas as $row) {
    echo "<tr style='text-align:center;'>";
    echo "<td>" . $i . "</td>";
    echo "<td>" . (!empty($row->first_name) ? $row->first_name : 'N/A') . "</td>";
    echo "<td>" . (!empty($row->companyname) ? $row->companyname : 'N/A') . "</td>";
    echo "<td>" . (!empty($row->phonenumber) ? $row->phonenumber : 'N/A') . "</td>";
    echo "<td>" . (!empty($row->email) ? $row->email : 'N/A') . "</td>";
    echo "<td>" . (!empty($row->city_name) ? $row->city_name : 'N/A') . "</td>";
    echo "<td>" . (!empty($row->group_name) ? $row->group_name : 'N/A') . "</td>";
    echo "<td>" . (!empty($row->categoriesname) ? $row->categoriesname : 'N/A') . "</td>";

    // Formatting date fields as d-m-Y
    echo "<td>" . (!empty($row->SubscriptionExpiredDate) ? date('d-m-Y', strtotime($row->SubscriptionExpiredDate)) : 'N/A') . "</td>";
    echo "<td>" . (!empty($row->facebook_link) ? $row->facebook_link : 'N/A') . "</td>";
    echo "<td>" . (!empty($row->youtube_link) ? $row->youtube_link : 'N/A') . "</td>";
    echo "<td>" . (!empty($row->instagram_link) ? $row->instagram_link : 'N/A') . "</td>";
    echo "<td>" . (!empty($row->linkedin_link) ? $row->linkedin_link : 'N/A') . "</td>";
    echo "<td>" . (!empty($row->google_link) ? $row->google_link : 'N/A') . "</td>";
    echo "<td>" . (!empty($row->date_of_birth) ? date('d-m-Y', strtotime($row->date_of_birth)) : 'N/A') . "</td>";
    echo "<td>" . (!empty($row->work_anniversary_date) ? date('d-m-Y', strtotime($row->work_anniversary_date)) : 'N/A') . "</td>";
    echo "</tr>";
    $i++;
}

echo "</table>";

header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=\"$filename\"");
exit();
?>
