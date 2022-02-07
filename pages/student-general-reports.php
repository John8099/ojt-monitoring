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
    <title>Student General Reports</title>
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.9/css/fixedHeader.bootstrap.min.css">
</head>

<body class="nav-md" style="background:none;">
    <div class="container body">
        <div class="main_container">
            <?php
            if ($user->role == "student") {
                include_once("../components/student-nav.php");
            } else {
                include_once("../components/coordinator-nav.php");
            }
            ?>

            <!-- page content -->
            <?php
            if ($user->role == "student") :
            ?>
                <div class="right_col" role="main" style="transition:.5s;">
                    <div class="row">
                        <?php
                        $genReportQ = mysqli_query(
                            $conn,
                            "SELECT * FROM gen_reports WHERE submit_by='$user->id' ORDER BY gen_report_id DESC"
                        );
                        while ($genReport = mysqli_fetch_object($genReportQ)) :
                            $student = mysqli_fetch_object(
                                mysqli_query(
                                    $conn,
                                    "SELECT * FROM user WHERE id='$genReport->submit_by'"
                                )
                            );
                        ?>
                            <div class="col-md-5 col-sm-4 col-xs-12" style="float:left">
                                <div class="x_panel tile" style="height:300px;box-shadow: 0 3px 10px rgb(0 0 0 / 50%);">
                                    <div class="x_title">
                                        <h5><?php echo date_format(date_create($genReport->submitted_on), "M d, Y H:i:s a") ?></h5>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <div class="w_center w_55" style="width:100%;">
                                            <embed src="<?php echo $genReport->report_file ?>" style="width: 100%; height: 180px;" frameborder="0">
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?php echo $genReport->gen_report_id ?>">
                                        View
                                    </button>
                                    <div class="modal fade" id="exampleModal<?php echo $genReport->gen_report_id ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document" style="width: 90%;">
                                            <div class="modal-content" style=" height: 100%;">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <embed src="<?php echo $genReport->report_file ?>" style="width: 100%; height: 550px;" frameborder="0">
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="student-edit-gen-report.php?id=<?php echo $genReport->gen_report_id ?>">
                                                        <button type="button" class="btn btn-primary">
                                                            Change
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile;
                        if (mysqli_num_rows($genReportQ) == 0) : ?>
                            <div style="width: 100%;margin-top: 120px;text-align: center;color: black;">
                                <h3 style="text-transform: capitalize;">
                                    no general reports to show.
                                </h3>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            <?php
            else :
            ?>
                <div class="right_col" role="main" style="transition:.5s;">
                    <div class="row">
                        <div class="md-col-12 xs-col-1 xs-col-9">
                            <div class="x_panel" style="overflow-y:scroll;box-shadow: 0 3px 10px rgb(0 0 0 / 50%); height: 600px;">
                                <div class="x_title">
                                    <h2>Student General Report</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content" style="overflow-y:scroll; height: 500px;">
                                    <table id="myTable" class="table table-striped table-bordered">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th>First name</th>
                                                <th>Middle name</th>
                                                <th>Last name</th>
                                                <th>Submitted on</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $q = mysqli_query(
                                                $conn,
                                                "SELECT * FROM gen_reports"
                                            );
                                            while ($genReports = mysqli_fetch_object($q)) :
                                                $student = mysqli_fetch_object(
                                                    mysqli_query(
                                                        $conn,
                                                        "SELECT fname, mname, lname, id FROM user WHERE id = $genReports->submit_by"
                                                    )
                                                );
                                            ?>
                                                <tr>
                                                    <td style="text-transform: capitalize;"><?php echo $student->fname ?></td>
                                                    <td style="text-transform: capitalize;"><?php echo $student->mname ?></td>
                                                    <td style="text-transform: capitalize;"><?php echo $student->lname ?></td>
                                                    <td>
                                                        <h5><?php echo date_format(date_create($genReports->submitted_on), "M d, Y h:i:s a") ?></h5>
                                                    </td>
                                                    <td>
                                                        <center>
                                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal<?php echo $genReports->gen_report_id ?>">
                                                                View
                                                            </button>
                                                        </center>
                                                        <div class="modal fade" id="exampleModal<?php echo $genReports->gen_report_id ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog" role="document" style="width: 90%;">
                                                                <div class="modal-content" style=" height: 100%;">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                        <h3 class="modal-title" style="text-align: center;">
                                                                            General Report of
                                                                            <strong>
                                                                                <?php echo ucwords("$student->fname " . $student->mname[0] . ". $student->lname"); ?>
                                                                            </strong>
                                                                        </h3>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <embed src="<?php echo $genReports->report_file ?>" style="width: 100%; height: 550px;" frameborder="0">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
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
            <?php
            endif;
            ?>
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