<?php
include_once("conn.php");
$arr = [
    "success" => false,
    "canEdit" => false,
    "canSubmit" => false,
    "time" => ""
];
try {
    $q = mysqli_query($conn, "SELECT * FROM settings");
    if ($q) {
        $settings = mysqli_fetch_object($q);
        if ($settings->can_edit == 1) {
            $arr["canEdit"] = true;
        }
        if ($settings->can_submit == 1) {
            $arr["canSubmit"] = true;
        }
        $arr["time"] = $settings->hours;
        $arr["success"] = true;
    } else {
        $arr["msg"] = mysqli_error($conn);
    }
} catch (Exception $ex) {
    $arr["msg"] = $ex;
}
print_r(json_encode($arr));
