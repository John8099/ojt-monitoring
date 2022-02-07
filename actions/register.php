<?php
session_start();
include_once("conn.php");
$arr = [
    "success" => false,
    "msg" => ""
];
try {
    if (isset($_POST['action']) && $_POST['action'] == "add") {
        $arr = array(
            "capstoneApproval" => "0",
            "ojtApp" => "0",
            "studentCopy" => "0",
            "appLetter" => "0",
            "endorseLetter" => "0",
            "resume" => "0",
            "photo" => "0",
            "parentConcent" => "0",
            "ojtAgreement" => "0",
            "feb" => "0",
            "mar" => "0",
            "apr" => "0",
            "may" => "0",
            "june" => "0"
        );
        $requirements = json_encode($arr);
        $fname = $_POST["fname"];
        $mname = $_POST["mname"];
        $lname = $_POST["lname"];
        $course = $_POST["course"];
        $superVisorId = $_POST["company"] == "" ? 0 : $_POST["company"];
        $companyName = NULL;
        if ($superVisorId > 0) {
            $query = mysqli_query($conn, "SELECT * FROM user WHERE id = $superVisorId");
            if (mysqli_num_rows($query) > 0) {
                $companyName = mysqli_fetch_object($query)->company;
            }
        }

        // $email = $_POST["email"];
        $section = strtoupper($_POST["section"]);
        // $password = md5($_POST["password"]);

        $q = mysqli_query($conn, "INSERT INTO user(fname, mname, lname, supervisor_id, course, section, company, requirements, `role`) VALUES('$fname','$mname','$lname', '$superVisorId', '$course', '4-$section','$companyName', '$requirements', 'student')");
        if ($q) {
            // $last_id = mysqli_insert_id($conn);
            // $_SESSION["id"] = $last_id;
            $arr["success"] = true;
        } else {
            $arr["msg"] = mysqli_error($conn);
        }
    }
} catch (Exception $ex) {
    $arr["msg"] = $ex;
}
print_r(json_encode($arr));
