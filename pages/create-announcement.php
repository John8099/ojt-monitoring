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
    <title>Create Announcements</title>
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
            <?php include_once("../components/coordinator-nav.php") ?>

            <!-- page content -->
            <div class="right_col" role="main" style="transition:.5s;">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel" style="box-shadow: 0 3px 10px rgb(0 0 0 / 50%)">
                            <div class="x_title">
                                <h2>Create Announcements</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <form method="POST" role="form" id="create-announcement" class="form-horizontal form-label-left">
                                    <div class="item form-group" id="divSelect">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" id="labelSelect">
                                            Announcement Type:
                                        </label>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <select style="text-transform: capitalize;" id="announce_type" name="announcement_type" class="form-control col-md-7 col-xs-12" required>
                                                <option value="">select type</option>
                                                <option value="manual">manually input announcement type</option>
                                                <option value="submission of report">submission of report</option>
                                                <option value="information">information</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="item form-group" id="divInput">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" id="announceLabel1">
                                            Announcement Type:
                                        </label>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <input type="text" class="form-control" name="manualInput" placeholder="Input announcement type" required>
                                        </div>
                                    </div>
                                    <div class="item form-group" id="submissionDates">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                            Submission Date:
                                        </label>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <input type="date" class="form-control" name="from">
                                        </div>
                                        <label class="control-label col-md-1 col-sm-1 col-xs-12">
                                            To:
                                        </label>
                                        <div class="col-md-3 col-sm-3 col-xs-12">
                                            <input type="date" class="form-control" name="to">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <textarea name="announcement" cols="40" rows="10" class="form-control col-md-7 col-xs-12" required></textarea>
                                    </div>

                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <center>
                                            <button type="submit" class="btn btn-primary">Create Announcement</button>
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $("#submissionDates").hide();
        $("#divInput").hide();
        $('#announce_type').on('change', function() {
            if (this.value == "submission of report") {

                $("#submissionDates :input").prop('required', true);
                $("#divInput :input").prop('required', false);
                $("#labelSelect").html("Announcement Type:");
                $("#divInput").hide();
                $("#submissionDates").show();

            } else if (this.value == "manual") {

                $("#submissionDates").hide();
                $("#submissionDates :input").prop('required', false);
                $("#submissionDates :input").val("");
                $("#divInput :input").prop('required', true);
                $("#labelSelect").html("");
                $("#divInput").show();

            } else {

                $("#submissionDates :input").prop('required', false);
                $("#submissionDates :input").val("");
                $("#divInput :input").prop('required', false);
                $("#divInput").hide();
                $("#labelSelect").html("Announcement Type:");
                $("#submissionDates").hide();
            }
        });
        $("#create-announcement").on("submit", function(e) {
            swal.showLoading();
            $.ajax({
                url: '../actions/create-announcement.php',
                data: $(this).serialize(),
                type: 'POST',
                success: function(data) {
                    swal.close();
                    const resp = JSON.parse(data);
                    if (resp.success) {
                        swal.fire({
                            text: "Announced successfully!",
                            icon: 'success',
                        })
                    } else {
                        swal.fire({
                            title: 'Error!',
                            text: resp.msg,
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