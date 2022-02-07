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
    $course = $_POST["course"];
    $section = strtoupper($_POST["section"]);
    $email = $_POST["email"];

    $q = mysqli_query($conn, "UPDATE user set fname='$fname', mname='$mname', lname='$lname', course='$course', section='4-$section', email='$email' WHERE id='$userId'");
    if ($q) {
        $arr["success"] = true;
    } else {
        $arr["msg"] = mysqli_error($conn);
    }
} catch (Exception $ex) {
    $arr["msg"] = $ex;
}
print_r(json_encode($arr));
