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
    <title>Edit General Report</title>
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
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel" style="box-shadow: 0 3px 10px rgb(0 0 0 / 50%);">
                            <div class="x_title">
                                <h2>Edit General Report</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <?php
                                $userReport = mysqli_fetch_object(
                                    mysqli_query(
                                        $conn,
                                        "SELECT * FROM gen_reports WHERE gen_report_id=$_GET[id]"
                                    )
                                );
                                ?>
                                <form method="POST" role="form" id="update-gen-report" class="form-horizontal form-label-left" enctype="multipart/form-data">
                                    <input type="text" value="<?php echo $_GET['id'] ?>" name="reportId" readonly hidden>
                                    <input type="text" value="<?php echo $user->id ?>" name="userId" readonly hidden>

                                    <div class="item form-group">
                                        <!-- <textarea name="report" cols="40" rows="20" class="form-control col-md-7 col-xs-12" required></textarea> -->
                                        <input type="file" name="inputFile" id="file" class="form-control col-md-7 col-xs-12">
                                    </div>

                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <center>
                                            <button type="submit" class="btn btn-primary">Update Report</button>
                                            <button type="button" class="btn btn-danger" onclick="return window.history.back()">Cancel</button>
                                        </center>
                                    </div>
                                </form>
                            </div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $("#update-gen-report").on("submit", function(e) {
            swal.showLoading();
            $.ajax({
                url: '../actions/update-general-report.php',
                data: new FormData(this),
                type: 'POST',
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    swal.close();
                    if (data.success) {
                        swal.fire({
                            text: "Report successfully submitted to coordinator.",
                            icon: 'success',
                        }).then(() => {
                            $("#update-gen-report").get(0).reset()
                        })
                    } else {
                        swal.fire({
                            title: 'Error!',
                            text: data.msg,
                            icon: 'error',
                        })
                    }
                },
                error: function(err) {
                    swal.fire({
                        title: 'Oops...',
                        text: 'Something went wrong.',
                        icon: 'error',
                    })
                }
            });
            e.preventDefault();
        });
    </script>

</body>

</html>