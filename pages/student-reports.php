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
    <title>My Reports</title>
    <link rel="icon" href="../images/CHSMSC.gif" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Muli" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet" />

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.css" rel="stylesheet">

</head>

<body class="nav-md" style="background:none;">
    <div class="container body">
        <div class="main_container">
            <?php include_once("../components/student-nav.php") ?>

            <!-- page content -->
            <div class="right_col" role="main" style="transition:.5s;">
                <div class="row">
                    <?php
                    $userReportQ = mysqli_query(
                        $conn,
                        "SELECT * FROM reports WHERE report_by=$user->id ORDER BY report_id DESC"
                    );
                    if (mysqli_num_rows($userReportQ) > 0) :
                        date_default_timezone_set("Asia/Manila");
                        $submissionQ = mysqli_fetch_all(
                            mysqli_query(
                                $conn,
                                "SELECT * FROM announcements WHERE announce_type='submission of report'"
                            )
                        );
                        if (count($submissionQ) > 0) {
                            $submissionDate = explode(":", $submissionQ[count($submissionQ) - 1][3]);
                            $date1 = date_create($submissionDate[0]);
                            $date2 = date_create($submissionDate[1]);
                        }
                        while ($userReport = mysqli_fetch_object($userReportQ)) :
                            $currentDate = date_create($userReport->submittedOn);
                            $canEdit = mysqli_fetch_object(
                                mysqli_query(
                                    $conn,
                                    "SELECT * FROM settings"
                                )
                            )->can_edit;
                    ?>
                            <div class="col-md-5 col-sm-4 col-xs-12" style="float:left">
                                <div class="x_panel tile" style="height:500px;box-shadow: 0 3px 10px rgb(0 0 0 / 50%);">
                                    <div class="x_title">
                                        <?php
                                        if (count($submissionQ) > 0) {
                                            if (($currentDate >= $date1) && ($currentDate <= $date2) && $canEdit == 1 && $userReport->isChecked == 0) :
                                        ?>
                                                <a href="student-edit-report.php?id=<?php echo $userReport->report_id ?>">
                                                    <i class="fa fa-edit" style="font-size: 20px; float:right"></i>
                                                </a>
                                        <?php
                                            endif;
                                        }
                                        ?>
                                        <h5><?php echo date_format(date_create($userReport->submittedOn), "M d, Y h:i:s a") ?></h5>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <div class="widget_summary" style="height:330px;">
                                            <div class="w_center w_55" style="width:100%;">
                                                <ul class="list-group list-group-flush">
                                                    <?php
                                                    foreach (json_decode($userReport->task) as $task) {
                                                        echo "<li class='list-group-item'>" .  $task . "</li>";
                                                    }
                                                    ?>
                                                </ul>

                                            </div>
                                        </div>
                                        <div class="widget_summary">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?php echo $userReport->report_id ?>">
                                                View
                                            </button>
                                            <div class="modal fade" id="exampleModal<?php echo $userReport->report_id ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document" style="width: 90%;">
                                                    <div class="modal-content" style=" height: 100%;">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <embed src="<?php echo $userReport->report_file_name ?>" style="width: 100%; height: 550px;" frameborder="0">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <?php
                                                            if (count($submissionQ) > 0) {
                                                                if (($currentDate >= $date1) && ($currentDate <= $date2) && $canEdit == 1 && $userReport->isChecked == 0) :
                                                            ?>
                                                                    <a href="student-edit-report.php?id=<?php echo $userReport->report_id ?>">
                                                                        <button type="button" class="btn btn-primary">
                                                                            Edit
                                                                        </button>
                                                                    </a>
                                                            <?php
                                                                endif;
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="widget_summary">
                                            <div class="w_center w_55" style="width:100%;">
                                                Is Check:
                                                <?php
                                                if ($userReport->isChecked == 0) :
                                                ?>
                                                    <label style="color:red !important">No</label>
                                                <?php else : ?>
                                                    <label style="color:green !important">Yes</label>
                                                <?php endif; ?>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <?php
                                        if ($userReport->isChecked == 1) {
                                        ?>
                                            <div class="widget_summary">
                                                <div class="w_center w_55" style="width:100%;">
                                                    Date check:
                                                    <?php echo date_format(date_create($userReport->isCheckedDate), "M d, Y H:i:s a") ?>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile;
                    else :
                        ?>
                        <div style="width: 100%;margin-top: 120px;text-align: center;color: black;">
                            <h3 style="text-transform: capitalize;">
                                no reports to show.
                            </h3>
                        </div>
                    <?php endif; ?>
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

</body>

</html>