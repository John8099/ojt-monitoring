<?php
include_once("conn.php");
include_once("send-email.php");
$arr = [
    "success" => false,
    "role" => "",
    "msg" => ""
];

try {
    $userId = $_POST["userId"];
    $other = $_POST['other'];
    if (!empty($other)) {
        $_POST["task"][count($_POST["task"]) - 1] =  ucwords($_POST['other']);
    }

    $task = json_encode($_POST["task"]);
    $file = $_FILES["inputFile"];

    $uniqueId = generateUniqueId();
    $target_dir = "../media/$userId";
    $uploadable = "$uniqueId" . "_" . basename($file['name']);

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (move_uploaded_file($file['tmp_name'], "$target_dir/$uploadable")) {
        // $report = nl2br($_POST["report"]);
        $student = mysqli_fetch_object(
            mysqli_query(
                $conn,
                "SELECT * FROM user WHERE id='$userId'"
            )
        );
        $supervisor = mysqli_fetch_object(
            mysqli_query(
                $conn,
                "SELECT * FROM user WHERE id='$student->supervisor_id'"
            )
        );
        $studentName = strtoupper($student->fname[0]) . substr($student->fname, 1, strlen($student->fname)) . " " . strtoupper($student->lname[0]) . substr($student->lname, 1, strlen($student->lname));

        $sendEmail = sendEmail($studentName, $supervisor->email, $supervisor->role);

        if ($sendEmail) {
            $q = mysqli_query(
                $conn,
                "INSERT INTO reports(task, report_file_name, report_by, supervisor_id) VALUES('$task', '$target_dir/$uploadable', '$userId', '$student->supervisor_id')"
            );
            if ($q) {
                $arr["success"] = true;
            } else {
                $arr["msg"] = mysqli_error($conn);
            }
        } else {
            $arr["msg"] = "Something went wrong on email service please try again";
        }
    } else {
        $arr["msg"] = "Error uploading file";
    }
} catch (Exception $ex) {
    $arr["msg"] = $ex;
}
print_r(json_encode($arr));
