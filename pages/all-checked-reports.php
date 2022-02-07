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
    <title>Student Checked Report</title>
    <link rel="icon" href="../images/CHSMSC.gif" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Muli" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet" />

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Custom Theme Style -->
    <link href="../build/css/custom.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="nav-md" style="background:none;">
    <div class="container body">
        <div class="main_container">
            <?php include_once("../components/coordinator-nav.php") ?>

            <!-- page content -->
            <div class="right_col" role="main" style="transition:.5s;">
                <div class="row">
                    <?php
                    $studentReportQ = mysqli_query(
                        $conn,
                        "SELECT * FROM reports WHERE isChecked=1 ORDER BY report_id DESC"
                    );
                    while ($studentReport = mysqli_fetch_object($studentReportQ)) :
                        $student = mysqli_fetch_object(
                            mysqli_query(
                                $conn,
                                "SELECT * FROM user WHERE id='$studentReport->report_by'"
                            )
                        );
                        $supervisor = mysqli_fetch_object(
                            mysqli_query(
                                $conn,
                                "SELECT * FROM user WHERE id='$studentReport->supervisor_id'"
                            )
                        );
                    ?>
                        <div class="col-md-5 col-sm-4 col-xs-12" style="float:left">
                            <div class="x_panel tile" style="height: 530px;box-shadow: 0 3px 10px rgb(0 0 0 / 50%);">
                                <div class="x_title">
                                    <h4>
                                        Report by:
                                        <label style="text-transform: capitalize;font-weight: bold;"><?php echo "$student->fname $student->lname" ?></label>
                                    </h4>
                                    <h5><?php echo date_format(date_create($studentReport->submittedOn), "M d, Y h:i:s a") ?></h5>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="widget_summary" style="height:330px;">
                                        <div class="w_center w_55" style="width:100%;">
                                            <ul class="list-group list-group-flush">
                                                <?php
                                                foreach (json_decode($studentReport->task) as $task) {
                                                    echo "<li class='list-group-item'>" .  $task . "</li>";
                                                }
                                                ?>
                                            </ul>

                                        </div>
                                    </div>

                                    <div class="widget_summary">
                                        Checked on: <?php echo date_format(date_create($studentReport->isCheckedDate), "M d, Y h:i:s a") ?><br>
                                        Checked by: <?php echo strtoupper($supervisor->fname[0]) . substr($supervisor->fname, 1, strlen($supervisor->fname)) . " " . strtoupper($supervisor->lname[0]) . substr($supervisor->lname, 1, strlen($supervisor->lname)) ?>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="widget_summary">
                                        <div class="w_center w_55" style="display: block;width:100%;">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?php echo $studentReport->report_id ?>" style="float: right;">
                                                View
                                            </button>
                                        </div>
                                        <div class="modal fade" id="exampleModal<?php echo $studentReport->report_id ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document" style="width: 90%;">
                                                <div class="modal-content" style=" height: 100%;">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        <h3 class="modal-title" style="text-align: center;">
                                                            Report of
                                                            <strong>
                                                                <?php echo ucwords("$student->fname " . $student->mname[0] . ". $student->lname"); ?>
                                                            </strong>
                                                        </h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <embed src="<?php echo $studentReport->report_file_name ?>" style="width: 100%; height: 550px;" frameborder="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            <?php endwhile;
                    if (mysqli_num_rows($studentReportQ) == 0) : ?>
                <div style="width: 100%;margin-top: 120px;text-align: center;color: black;">
                    <h3 style="text-transform: capitalize;">
                        no reports to show.
                    </h3>
                </div>
            <?php endif ?>
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