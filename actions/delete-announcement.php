<?php
include_once("conn.php");
$arr = [
    "success" => false,
    "msg" => ""
];
try {
    $announceId = $_POST["announceId"];

    $q = mysqli_query(
        $conn,
        "DELETE FROM announcements WHERE announce_id='$announceId'"
    );
    if ($q) {
        $arr["success"] = true;
    } else {
        $arr["msg"] = mysqli_error($conn);
    }
} catch (Exception $ex) {
    $arr["msg"] = $ex;
}
print_r(json_encode($arr));
