<?php
ob_start();
$filename = 'Event_List_' . date('d-m-Y_H-i-s') . '.xls';
ob_end_clean();

header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=\"$filename\"");

echo "Sr No\tEvent Name\tEvent Date\tStart Time\tEnd Time\tType\tAssigned Members\n";

$i = 1;

foreach ($datas as $row) {
    // ===== TYPE =====
    $type = $row->event_type == 1 ? 'ESP' : 'Training';

    // ===== MEMBERS =====
    $memberNames = '';

    if (!empty($row->assign_member_id)) {
        $ids = json_decode($row->assign_member_id, true);

        if (!empty($ids)) {
            $members = DB::table('members')->whereIn('id', $ids)->pluck('Contact_person')->toArray();

            // CLEAN EACH NAME
            $members = array_map(function ($name) {
                return trim(str_replace(["\t", "\n", "\r"], ' ', $name));
            }, $members);

            // FINAL STRING
            $memberNames = implode(', ', $members);

            // EXTRA SAFETY
            $memberNames = str_replace(["\t", "\n", "\r"], ' ', $memberNames);
        }
    }

    echo $i . "\t" . $row->name . "\t" . date('d-m-Y', strtotime($row->eventstart_date)) . "\t" . $row->eventstart_time . "\t" . $row->eventend_time . "\t" . $type . "\t" . '"' . $memberNames . '"' . "\n";

    $i++;
}

exit();
?>
