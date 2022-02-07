<?php
session_start();
include_once("conn.php");
$arr = [
    "success" => false,
    "role" => "",
    "isNew" => false,
    "msg" => ""
];
try {
    $email = $_POST["email"];
    $password = md5($_POST["password"]);

    $q = mysqli_query($conn, "SELECT * FROM user WHERE email='$email' and pass = '$password'");
    if (mysqli_num_rows($q) > 0) {
        $user = mysqli_fetch_object($q);
        $_SESSION["id"] = $user->id;
        $arr["success"] = true;
        $arr["role"] = $user->role;
        if ($user->role == "supervisor" && $user->isNew == 1) {
            $arr["isNew"] = true;
        }
    } else {
        $arr["msg"] = "User not found.";
    }
} catch (Exception $ex) {
    $arr["msg"] = $ex;
}
print_r(json_encode($arr));
