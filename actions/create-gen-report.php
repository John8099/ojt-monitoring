<?php
include_once("conn.php");
$arr = [
    "success" => false,
    "msg" => ""
];

try {
    $userId = $_POST["userId"];
    $file = $_FILES["inputFile"];

    $uniqueId = generateUniqueId();
    $target_dir = "../media/$userId";
    $uploadable = "$uniqueId" . "_" . basename($file['name']);

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (move_uploaded_file($file['tmp_name'], "$target_dir/$uploadable")) {
        // $report = nl2br($_POST["report"]);
        $q = mysqli_query(
            $conn,
            "INSERT INTO gen_reports(submit_by, report_file) VALUES('$userId', '$target_dir/$uploadable')"
        );
        if ($q) {
            $arr["success"] = true;
        } else {
            $arr["msg"] = mysqli_error($conn);
        }
    } else {
        $arr["msg"] = "Error uploading file";
    }
} catch (Exception $ex) {
    $arr["msg"] = $ex;
}
print_r(json_encode($arr));
