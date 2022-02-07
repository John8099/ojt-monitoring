<?php
session_start();
include '../actions/conn.php';
if (!$_SESSION['id']) {
    header('Location: ../');
}
$user = mysqli_fetch_object(mysqli_query($conn, "SELECT * FROM user WHERE id = '$_SESSION[id]'"));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employees</title>
    <link rel="icon" href="../images/CHSMSC.gif" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Muli" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet" />
    <!-- Custom Theme Style -->
    <link href="../build/css/custom.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.9/css/fixedHeader.bootstrap.min.css">
    <style>
        .dataTables_wrapper>.row {
            overflow: hidden !important;
            width: 100% !important;
            margin: 0;
        }
    </style>
</head>

<body class="nav-md" style="background:none;">
    <div class="container body">
        <div class="main_container">
            <?php include_once("../components/supervisor-nav.php") ?>
            <!-- page content -->
            <div class="right_col" role="main" style="transition:.5s;">
                <div class="row">
                    <div class="md-col-12 xs-col-1 xs-col-9">
                        <div class="x_panel" style="overflow-y:scroll;box-shadow: 0 3px 10px rgb(0 0 0 / 50%); height: 600px;">
                            <div class="x_title">
                                <h2>Employees</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content" style="overflow-y:scroll; height: 500px;">
                                <table id="myTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr class="bg-primary">
                                            <th>First name</th>
                                            <th>Middle name</th>
                                            <th>Last name</th>
                                            <th>Course</th>
                                            <th>Section</th>
                                            <th>Email</th>
                                            <th>Rendered</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $q = mysqli_query(
                                            $conn,
                                            "SELECT * FROM user WHERE supervisor_id='$user->id' and `role`='student'"
                                        );
                                        while ($employee = mysqli_fetch_object($q)) :
                                        ?>
                                            <tr>
                                                <td style="text-transform: capitalize;"><?php echo $employee->fname ?></td>
                                                <td style="text-transform: capitalize;"><?php echo $employee->mname ?></td>
                                                <td style="text-transform: capitalize;"><?php echo $employee->lname ?></td>
                                                <td style="text-transform: capitalize;">
                                                    <?php
                                                    echo mysqli_fetch_object(
                                                        mysqli_query($conn, "SELECT * FROM courses WHERE id = '$employee->course'")
                                                    )->course_name;
                                                    ?>
                                                </td>
                                                <td style="text-align: center;"><?php echo $employee->section ?></td>
                                                <td><?php echo $employee->email ?></td>
                                                <td style="text-transform: capitalize;">
                                                    <?php
                                                    $dtr_q = mysqli_query(
                                                        $conn,
                                                        "SELECT * FROM attendance WHERE `user_id`=$employee->id and time_in <> '' and time_out is NOT NULL"
                                                    );
                                                    $hours = 0;
                                                    $mins = 0;
                                                    $secs = 0;
                                                    while ($rows = mysqli_fetch_object($dtr_q)) {
                                                        $diff = dateDiff($rows->time_in, $rows->time_out);
                                                        // $rendered = "$diff[hours] hours $diff[minutes] mins $diff[seconds] seconds";
                                                        if ($diff['hours'] >= 8 && $diff['hours'] != 0) {
                                                            $hours += 7;
                                                            $mins += 59;
                                                            $secs += 60;
                                                        } else {
                                                            $timeDiff = getDiff((strtotime($rows->time_out) - strtotime($rows->time_in)));
                                                            $hours += $timeDiff['hours'];
                                                            $mins += $timeDiff['minutes'];
                                                            $secs += $timeDiff['seconds'];
                                                        }
                                                    }

                                                    if ($secs > 60) {
                                                        $divideSecs = $secs / 60;
                                                        if (strpos($divideSecs, ".")) {
                                                            $whole = floor($divideSecs);
                                                            $fraction = explode(".", $divideSecs);
                                                            $mins += $whole;
                                                            $secs = substr($fraction[1], 0, 1);
                                                        } else {
                                                            $whole = floor($divideSecs);
                                                            $mins += $whole;
                                                            $secs = 0;
                                                        }
                                                    }

                                                    if ($mins > 60) {
                                                        $divideMins = $mins / 60;
                                                        if (strpos($divideMins, ".")) {
                                                            $whole = floor($divideMins);
                                                            $fraction = explode(".", $divideMins);
                                                            $hours += $whole;
                                                            $mins = substr($fraction[1], 0, 1);
                                                        } else {
                                                            $whole = floor($divideMins);
                                                            $hours += $whole;
                                                            $mins = 0;
                                                        }
                                                    }
                                                    $rendered = "$hours hrs $mins mins $secs secs";

                                                    $getTotalHours = mysqli_fetch_object(
                                                        mysqli_query(
                                                            $conn,
                                                            "SELECT * FROM settings"
                                                        )
                                                    )->hours - 1;
                                                    $remainHours = $getTotalHours < 0 ? 0 : $getTotalHours;
                                                    $remainMin = 59;
                                                    $remainSec = 60;


                                                    if ($secs != 0) {
                                                        $remainSec -= $secs;
                                                    }

                                                    if ($mins != 0) {
                                                        $remainMin -= $mins;
                                                    }

                                                    if ($hours != 0) {
                                                        $remainHours -= $hours;
                                                    }

                                                    $remaining = "$remainHours hrs $remainMin mins $remainSec secs";
                                                    ?>
                                                    Total:
                                                    <label style="color:<?= $hours != 0 || $mins != 0 || $secs != 0 ? "darkgreen" : "darkred" ?>">
                                                        <?= $hours != 0 || $mins != 0 || $secs || 0 ? $rendered : "-------------" ?>
                                                    </label>
                                                    <br>
                                                    Remaining:
                                                    <label style="color:<?= $remainHours != 0 || $remainMin != 0 || $remainSec != 0 ? "darkred" : "darkgreen" ?>">
                                                        <?= $remainHours != 0 || $remainMin != 0 || $remainSec != 0 ? $remaining : "Done" ?>
                                                    </label>
                                                </td>
                                            </tr>
                                        <?php endwhile ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->
    </div>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- jQuery custom content scroller -->
    <script src="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>

    <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.1.9/js/dataTables.fixedHeader.min.js"></script>
    <script>
        $('#myTable').DataTable({
            responsive: true
        });
    </script>

</body>

</html>