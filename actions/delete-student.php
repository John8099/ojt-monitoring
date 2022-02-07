<?php
include_once("conn.php");
$arr = [
    "success" => false,
    "msg" => ""
];
try {
    $employeeId = $_POST["employeeId"];

    $q = mysqli_query(
        $conn,
        "DELETE FROM user WHERE id='$employeeId'"
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
