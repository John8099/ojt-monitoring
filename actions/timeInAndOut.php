<?php
include_once("conn.php");
date_default_timezone_set("Asia/Manila");

$arr = [
    "success" => false,
    "name" => "",
    "status" => "",
    "msg" => ""
];

try {
    $userId = $_POST["userId"];
    $supervisorId = $_POST["supervisorId"];
    $studentDataQ = mysqli_query(
        $conn,
        "SELECT * FROM user WHERE id='$userId' and `role` = 'student'"
    );
    $dateNow = date("Y-m-d G:i:s");

    if (mysqli_num_rows($studentDataQ) > 0) {
        $studentData = mysqli_fetch_object($studentDataQ);
        $fname = strtoupper($studentData->fname[0]) . substr($studentData->fname, 1, strlen($studentData->fname));
        $mname = strtoupper($studentData->mname[0]) . ".";
        $lname = strtoupper($studentData->lname[0]) . substr($studentData->lname, 1, strlen($studentData->lname));

        $latestTimeInQ = mysqli_fetch_all(
            mysqli_query(
                $conn,
                "SELECT * FROM attendance WHERE `user_id`='$userId'"
            )
        );
        if (count($latestTimeInQ) > 0) {
            $timeIn = strtotime($latestTimeInQ[count($latestTimeInQ) - 1][3]);
            $hour = abs(strtotime($dateNow) - $timeIn) / (60 * 60);
            if ($hour > 12) {
                $q = mysqli_query(
                    $conn,
                    "INSERT INTO attendance(`user_id`, supervisor_id, time_in) VALUES('$userId', '$supervisorId', '$dateNow')"
                );

                if ($q) {
                    $arr["success"] = true;
                    $arr["name"] = "$fname $mname $lname";
                    $arr["status"] = "Time In";
                } else {
                    $arr["msg"] = mysqli_error($conn);
                }
            } else {
                $latestTimeInId = $latestTimeInQ[count($latestTimeInQ) - 1][0];
                $latestTimeInTimeOutDate = $latestTimeInQ[count($latestTimeInQ) - 1][4];
                if (empty($latestTimeInTimeOutDate)) {
                    $timeOut = date_format(date_create($dateNow), "Y-m-d G:i:s");
                    $q = mysqli_query(
                        $conn,
                        "UPDATE attendance set time_out='$timeOut' WHERE attendance_id='$latestTimeInId'"
                    );
                    if ($q) {
                        $arr["success"] = true;
                        $arr["name"] = "$fname $mname $lname";
                        $arr["status"] = "Time Out";
                    } else {
                        $arr["msg"] = mysqli_error($conn);
                    }
                } else {
                    $q = mysqli_query(
                        $conn,
                        "INSERT INTO attendance(`user_id`, supervisor_id, time_in) VALUES('$userId', '$supervisorId', '$dateNow')"
                    );
                    if ($q) {
                        $arr["success"] = true;
                        $arr["name"] = "$fname $mname $lname";
                        $arr["status"] = "Time In";
                    } else {
                        $arr["msg"] = mysqli_error($conn);
                    }
                }
            }
        } else {
            $q = mysqli_query(
                $conn,
                "INSERT INTO attendance(`user_id`, supervisor_id, time_in) VALUES('$userId', '$supervisorId', '$dateNow')"
            );
            if ($q) {
                $arr["success"] = true;
                $arr["name"] = "$fname $mname $lname";
                $arr["status"] = "Time In";
            } else {
                $arr["msg"] = mysqli_error($conn);
            }
        }
    } else {
        $arr["success"] = false;
        $arr["msg"] = "No data found.";
    }

    // print_r(mysqli_error($conn));
    // $attendanceId;
    // $timeIn = mysqli_query(
    //     $conn,
    //     "SELECT * FROM attendance WHERE `user_id`='$userId'"
    // );

    // while ($row = mysqli_fetch_object($timeIn)) {
    //     $dateNow = date_create(date("Y-m-d"));
    //     $in = date_create(explode(" ", $row->time_in)[0]);
    //     $dateTom = date_create(date('Y-m-d', strtotime(date_format($dateNow, "Y-m-d") . ' + 1 days')));

    //     if (($dateNow >= $in) && ($dateNow <= $dateTom)) {
    //         $attendanceId = $row->attendance_id;
    //     }
    // }
    // if (!isset($attendanceId)) {
    //     $q = mysqli_query(
    //         $conn,
    //         "INSERT INTO attendance(`user_id`) VALUES('$userId')"
    //     );
    //     if ($q) {
    //         $arr["success"] = true;
    //         $arr["name"] = "$fname $mname $lname";
    //         $arr["status"] = "Time In";
    //     } else {
    //         $arr["msg"] = mysqli_error($conn);
    //     }
    // } else {
    //     date_default_timezone_set("Asia/Manila");
    //     $currentDate = date_format(date_create(date("Y-m-d G:i:s")), "Y-m-d G:i:s");
    //     $q = mysqli_query(
    //         $conn,
    //         "UPDATE attendance set time_out='$currentDate' WHERE attendance_id='$attendanceId'"
    //     );
    //     if ($q) {
    //         $arr["success"] = true;
    //         $arr["name"] = "$fname $mname $lname";
    //         $arr["status"] = "Time Out";
    //     } else {
    //         $arr["msg"] = mysqli_error($conn);
    //     }
    // }
} catch (Exception $ex) {
    $arr["msg"] = $ex;
}


print_r(json_encode($arr));
