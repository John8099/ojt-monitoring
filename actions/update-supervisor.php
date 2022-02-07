<?php
include_once("conn.php");
$arr = [
    "success" => false,
    "msg" => ""
];
try {
    $userId = $_POST['userId'];
    $fname = $_POST["fname"];
    $mname = $_POST["mname"];
    $lname = $_POST["lname"];
    $company = $_POST["company"];
    $position = $_POST["position"];
    $cnum = $_POST["cnum"];
    $email = $_POST["email"];

    $q = mysqli_query($conn, "UPDATE user set fname='$fname', mname='$mname', lname='$lname', company='$company', position='$position', contact='$cnum', email='$email' WHERE id='$userId'");
    if ($q) {
        $arr["success"] = true;
    } else {
        $arr["msg"] = mysqli_error($conn);
    }
} catch (Exception $ex) {
    $arr["msg"] = $ex;
}
print_r(json_encode($arr));
