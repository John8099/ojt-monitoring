<?php
include_once("conn.php");
$arr = [
    "success" => false,
    "msg" => ""
];
try {

    $student_id = $_POST['student_id'];
    $requirements = substr(json_encode($_POST['requirements']), 1, -1);
    $q = mysqli_query($conn, "UPDATE user set requirements='$requirements' WHERE id='$student_id'");
    if ($q) {
        $arr["success"] = true;
    } else {
        $arr["msg"] = mysqli_error($conn);
    }
} catch (Exception $ex) {
    $arr["msg"] = $ex;
}
print_r(json_encode($arr));
