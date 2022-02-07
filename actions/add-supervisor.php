<?php
include_once("conn.php");
$arr = [
    "success" => false,
    "name" => "",
    "msg" => ""
];
try {
    $fname = $_POST["fname"];
    $mname = $_POST["mname"];
    $lname = $_POST["lname"];
    $company = $_POST["company"];
    $email = $_POST["email"];
    $position = $_POST["position"];
    $cnum = $_POST["cnum"];
    $pass = md5($_POST["email"]);
    $q = mysqli_query(
        $conn,
        "INSERT INTO user(fname, mname, lname, company, email, position, contact, pass, `role`, isNew) VALUES('$fname','$mname','$lname','$company','$email', '$position', '$cnum', '$pass','supervisor', 1)"
    );
    if ($q) {
        $arr["success"] = true;
        $arr["name"] = "$fname $lname";
    } else {
        $arr["msg"] = mysqli_error($conn);
    }
} catch (Exception $ex) {
    $arr["msg"] = $ex;
}
print_r(json_encode($arr));
