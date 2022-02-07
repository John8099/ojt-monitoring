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
                "UPDATE gen_reports set report_file='$target_dir/$uploadable' WHERE gen_report_id='$reportId'"
            );
            if ($q) {
                $arr["success"] = true;
            } else {
                $arr["msg"] = mysqli_error($conn);
            }
        } else {
            $arr["msg"] = "Error uploading file";
        }
    } else {
        $arr["msg"] = "Error uploading file";
    }
} catch (Exception $ex) {
    $arr["msg"] = $ex;
}
print_r(json_encode($arr));
