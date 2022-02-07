<?php
session_start();
include_once("conn.php");
$arr = [
    "success" => false,
    "role" => "",
    "msg" => ""
];

try {
    $userId = $_POST['userId'];
    $password = md5($_POST["password"]);
    $role = mysqli_fetch_object(
        mysqli_query(
            $conn,
            "SELECT * FROM user WHERE id='$userId'"
        )
    );
    $q = mysqli_query(
        $conn,
        "UPDATE user set pass='$password', isNew=0 WHERE id='$userId'"
    );
    if ($q) {
        $arr["success"] = true;
        $role = mysqli_fetch_object(
            mysqli_query(
                $conn,
                "SELECT * FROM user WHERE id='$userId'"
            )
        )->role;
        $arr["role"] = $role;
    } else {
        $arr["msg"] = mysqli_error($conn);
    }
} catch (Exception $ex) {
    $arr["msg"] = $ex;
}
print_r(json_encode($arr));
