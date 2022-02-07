<?php
include_once('conn.php');

$arr = [
    "success" => false,
    "supervisorCompany" => "",
    "msg" => ""
];
try {
    $studentId = $_POST["studentId"];
    $supervisorId = $_POST["supervisorId"];

    $q = mysqli_query(
        $conn,
        "UPDATE user set supervisor_id='$supervisorId' WHERE id='$studentId'"
    );
    if ($q) {
        $arr["success"] = true;
        $arr["supervisorCompany"] = mysqli_fetch_object(
            mysqli_query(
                $conn,
                "SELECT * FROM user WHERE id = $supervisorId"
            )
        )->company;
    } else {
        $arr["msg"] = mysqli_error($conn);
    }
} catch (Exception $ex) {
    $arr["msg"] = $ex;
}
print_r(json_encode($arr));
