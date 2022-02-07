<?php
include_once("conn.php");

if (isset($_GET['submit'])) {
    $arr = [
        "success" => false,
        "canSubmit" => false
    ];
    $canSubmit = $_POST["canSubmit"];
    try {
        $q = mysqli_query($conn, "UPDATE settings set can_submit='$canSubmit'");
        if ($q) {
            $arr["canSubmit"] = $canSubmit == 1 ? true : false;
            $arr["success"] = true;
        } else {
            $arr["msg"] = mysqli_error($conn);
        }
    } catch (Exception $ex) {
        $arr["msg"] = $ex;
    }
    print_r(json_encode($arr));
}

if (isset($_GET['edit'])) {
    $arr = [
        "success" => false,
        "canEdit" => false
    ];
    $canEdit = $_POST["canEdit"];
    try {
        $q = mysqli_query($conn, "UPDATE settings set can_edit='$canEdit'");
        if ($q) {
            $arr["canEdit"] = $canEdit == 1 ? true : false;
            $arr["success"] = true;
        } else {
            $arr["msg"] = mysqli_error($conn);
        }
    } catch (Exception $ex) {
        $arr["msg"] = $ex;
    }
    print_r(json_encode($arr));
}
