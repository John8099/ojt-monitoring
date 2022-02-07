<?php
include_once("conn.php");
$arr = [
    "success" => false,
    "msg" => ""
];
try {
    $q = mysqli_query($conn, "UPDATE settings SET `hours` = '$_POST[hours]'");
    if ($q) {
        $arr["success"] = true;
    } else {
        $arr["msg"] = mysqli_error($conn);
    }
} catch (Exception $ex) {
    $arr["msg"] = $ex;
}
print_r(json_encode($arr));
