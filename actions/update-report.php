<?php
include_once("conn.php");
$arr = [
    "success" => false,
    "role" => "",
    "msg" => ""
];

try {
    $reportId = $_POST["reportId"];
    $userId = $_POST["userId"];
    // $report = nl2br($_POST["report"]);
    $task = json_encode($_POST["task"]);
    $file = $_FILES["inputFile"];

    if ($file["name"] != "") {
        $uniqueId = generateUniqueId();
        $target_dir = "../media/$userId";
        $uploadable = "$uniqueId" . "_" . basename($file['name']);
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        if (move_uploaded_file($file['tmp_name'], "$target_dir/$uploadable")) {
            $q = mysqli_query(
                $conn,
                "UPDATE reports set task='$task', report_file_name='$target_dir/$uploadable' WHERE report_id='$reportId'"
            ) or die(mysqli_error($conn));
            if ($q) {
                $arr["success"] = true;
            } else {
                $arr["msg"] = mysqli_error($conn);
            }
        } else {
            $arr["msg"] = "Error uploading file";
        }
    } else {
        $q = mysqli_query(
            $conn,
            "UPDATE reports set task='$task' WHERE report_id='$reportId'"
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
