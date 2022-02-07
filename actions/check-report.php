<?php
include_once("conn.php");
include_once("send-email.php");
date_default_timezone_set("Asia/Manila");
$arr = [
    "success" => false,
    "msg" => ""
];

try {
    $reportId = $_POST["reportId"];
    $currentDate = date_format(date_create(date("Y-m-d G:i:s")), "Y-m-d G:i:s");
    $reportData = mysqli_fetch_object(
        mysqli_query(
            $conn,
            "SELECT * FROM reports WHERE report_id='$reportId'"
        )
    );

    $student = mysqli_fetch_object(
        mysqli_query(
            $conn,
            "SELECT * FROM user WHERE id='$reportData->report_by'"
        )
    );
    $studentName = strtoupper($student->fname[0]) . substr($student->fname, 1, strlen($student->fname)) . " " . strtoupper($student->lname[0]) . substr($student->lname, 1, strlen($student->lname));
    $coordinatorEmails = [];

    $coordinatorQ = mysqli_query(
        $conn,
        "SELECT * FROM user WHERE `role`='coordinator'"
    );

    while ($row = mysqli_fetch_object($coordinatorQ)) {
        array_push($coordinatorEmails, $row->email);
    }

    $isEmailSend = false;

    foreach ($coordinatorEmails as $coordinatorEmail) {
        $sendEmail = sendEmail($studentName, $coordinatorEmail, "");
        if ($sendEmail && !$isEmailSend) {
            $isEmailSend = true;
        }
    }

    if ($isEmailSend) {
        $q = mysqli_query(
            $conn,
            "UPDATE reports SET isChecked=1, isCheckedDate='$currentDate' WHERE report_id='$reportId'"
        );
        if ($q) {
            $arr["success"] = true;
        } else {
            $arr["msg"] = mysqli_error($conn);
        }
    } else {
        $arr["msg"] = "Something went wrong on email service please try again";
    }
} catch (Exception $ex) {
    $arr["msg"] = $ex;
}
print_r(json_encode($arr));
