<?php
session_start();
include_once("conn.php");
$arr = [
    "success" => false,
    "msg" => ""
];

try {

    $studentName = $_POST['studentName'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $updateEmail_Q = mysqli_query(
        $conn,
        "UPDATE user SET email = '$email', pass = '$password' WHERE id = '$studentName'"
    );

    if ($updateEmail_Q) {
        $_SESSION['id'] = $studentName;
        $arr["success"] = true;
    } else {
        $arr['msg'] = mysqli_error($conn);
    }
} catch (Exception $e) {
    $arr['msg'] = $e->getMessage();
}

print_r(json_encode($arr));
