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
    <title>Profile</title>
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
    <!-- QR Code -->
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <style>
        #section {
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="40" height="30"><text x="7" y="21" style="font: bold 16px Arial;">4-</text></svg>') no-repeat;
            padding-left: 25px;
        }
    </style>
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
                                <h2>My Profile</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <form method="POST" role="form" id="update-student" class="form-horizontal form-label-left">
                                    <input type="text" value="<?php echo $user->id ?>" id="userId" name="userId" readonly hidden>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                                            First name:
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input value="<?php echo $user->fname ?>" type="text" name="fname" class="form-control col-md-7 col-xs-12" required>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                                            Middle name:
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input value="<?php echo $user->mname ?>" type="text" name="mname" class="form-control col-md-7 col-xs-12" required>
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                                            Last name:
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input value="<?php echo $user->lname ?>" type="text" name="lname" class="form-control col-md-7 col-xs-12" required>
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                                            Course:
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select name="course" class="form-control" required>
                                                <?php
                                                include_once('../actions/conn.php');
                                                $q = mysqli_query($conn, "SELECT * FROM courses WHERE id='$user->course'");
                                                while ($row = mysqli_fetch_object($q)) :
                                                ?>
                                                    <option value="<?php echo $row->id ?>"><?php echo $row->course_name ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                                            Section:
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input value="<?php echo $user->section[strlen($user->section) - 1] ?>" type="text" name="section" class="form-control" <?php echo empty($user->section) ? "" : "id='section'" ?> placeholder="Section" required maxlength="1" />
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                                            Email:
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input value="<?php echo $user->email ?>" type="text" name="email" class="form-control col-md-7 col-xs-12" required>
                                        </div>
                                    </div>
                                    <?php
                                    $supervisorInfo = mysqli_fetch_object(
                                        mysqli_query(
                                            $conn,
                                            "SELECT * FROM user WHERE id=$user->supervisor_id"
                                        )
                                    );
                                    ?>
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                                            Company:
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input value="<?php echo $user->supervisor_id != 0 ? $supervisorInfo->company : "" ?>" type="text" class="form-control col-md-7 col-xs-12" disabled>
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                                            Supervisor:
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input value="<?php echo $user->supervisor_id != 0 ? ucwords("$supervisorInfo->fname $supervisorInfo->lname") : "" ?>" type="text" class="form-control col-md-7 col-xs-12" disabled>
                                        </div>
                                    </div>

                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <center>
                                            <button type="submit" class="btn btn-primary">Update Profile</button>
                                            <button type="button" onclick="return window.location.href='update-password.php'" class="btn btn-warning">Change Password</button>
                                        </center>
                                    </div>
                                    <div class="form-group">
                                        <center>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#showQR">
                                                Show QR Code
                                            </button>
                                        </center>
                                    </div>
                                </form>
                                <div class="modal fade bd-example-modal-sm" id="showQR" tabindex="-1" role="dialog" aria-labelledby="showQR">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <center>
                                                    <div style="margin-bottom: 10px;">
                                                        <span id="qrcode"></span>
                                                    </div>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            text: $("#userId").val(),
            width: 350,
            height: 350,
            correctLevel: QRCode.CorrectLevel.H
        });

        $("#update-student").on("submit", function(e) {
            swal.showLoading();
            $.ajax({
                url: '../actions/update-student.php',
                data: $(this).serialize(),
                type: 'POST',
                success: function(data) {
                    swal.close();
                    const resp = JSON.parse(data);
                    if (resp.success) {
                        swal.fire({
                            text: 'Profile successfully updated!',
                            icon: 'success',
                        }).then(() => {
                            location.reload();
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