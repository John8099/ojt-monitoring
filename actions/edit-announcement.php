<?php
include_once("conn.php");
$arr = [
    "success" => false,
    "msg" => ""
];

try {
    $announceId = $_POST["announceId"];
    $announcement_type = $_POST["announcement_type"];
    $announcement = nl2br($_POST["announcement"]);
    if (!isset($_POST['from']) && !isset($_POST['to']) || $_POST['from'] == "" && $_POST['to'] == "") {
        $q = mysqli_query(
            $conn,
            "UPDATE announcements set announce_type='$announcement_type', announcement='$announcement', submission_date=NULL WHERE announce_id='$announceId'"
        );
        if ($q) {
            $arr["success"] = true;
        } else {
            $arr["msg"] = mysqli_error($conn);
        }
    } else {
        $from = $_POST["from"];
        $to = $_POST["to"];
        $date_arr = [
            0 => $from,
            1 => $to
        ];
        usort($date_arr, function ($a, $b) {
            $dateTimestamp1 = strtotime($a);
            $dateTimestamp2 = strtotime($b);

            return $dateTimestamp1 < $dateTimestamp2 ? -1 : 1;
        });
        $date1 = date_create($date_arr[0]);
        $date2 = date_create($date_arr[count($date_arr) - 1]);
        $currentDate = date_create(date("Y-m-d"));

        if (($currentDate >= $date1) && ($currentDate <= $date2)) {
            mysqli_query(
                $conn,
                "UPDATE settings set can_submit=1, can_edit=1"
            );
            // print_r(mysqli_error($conn));
        }
        $submissionDate = $date_arr[0] . ":" . $date_arr[count($date_arr) - 1];
        $q = mysqli_query(
            $conn,
            "UPDATE announcements set announce_type='$announcement_type', announcement='$announcement', submission_date='$submissionDate'  WHERE announce_id='$announceId'"
        );
        if ($q) {
            $arr["success"] = true;
        } else {
            $arr["msg"] = mysqli_error($conn);
        }
    }
} catch (Exception $ex) {
    $arr["msg"] = $ex;
}
print_r(json_encode($arr));
