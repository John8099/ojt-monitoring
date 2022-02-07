<?php
include_once("conn.php");
date_default_timezone_set("Asia/Manila");

$arr = [
    "success" => false,
    "msg" => ""
];

try {
    $announcement_type = $_POST["announcement_type"] == "manual" ? $_POST["manualInput"] : $_POST["announcement_type"];
    $announcement = nl2br($_POST["announcement"]);

    if (!isset($_POST['from']) && !isset($_POST['to']) || $_POST['from'] == "" && $_POST['to'] == "") {
        $q = mysqli_query(
            $conn,
            "INSERT INTO announcements(announce_type, announcement) VALUES('$announcement_type','$announcement')"
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
        $submissionDate = $date_arr[0] . ":" . $date_arr[count($date_arr) - 1];

        $submissionQ = mysqli_fetch_all(
            mysqli_query(
                $conn,
                "SELECT * FROM announcements WHERE announce_type='submission of report'"
            )
        );
        $date1 = date_create($date_arr[0]);
        $date2 = date_create($date_arr[count($date_arr) - 1]);
        $currentDate = date_create(date("Y-m-d"));

        if (($currentDate >= $date1) && ($currentDate <= $date2)) {
            mysqli_query(
                $conn,
                "UPDATE settings set can_submit=1, can_edit=1"
            );
        }

        $q = mysqli_query(
            $conn,
            "INSERT INTO announcements(announce_type, announcement, submission_date) VALUES('$announcement_type','$announcement','$submissionDate')"
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
