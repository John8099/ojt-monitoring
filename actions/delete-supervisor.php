<?php
include_once("conn.php");
$arr = [
    "success" => false,
    "msg" => ""
];
try {
    $supervisorId = $_POST["supervisorId"];

    $q = mysqli_query(
        $conn,
        "DELETE FROM user WHERE id='$supervisorId'"
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
