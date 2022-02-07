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
    <title>Announcements</title>
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

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <div class="right_col" role="main" style="transition:.5s;">
                <div class="row">
                    <?php
                    $q = mysqli_query(
                        $conn,
                        "SELECT * FROM announcements ORDER BY announce_id DESC"
                    );
                    while ($row = mysqli_fetch_object($q)) :
                    ?>
                        <div class="col-md-4 col-sm-4 col-xs-12" style="float:left">
                            <div class="x_panel tile" style="height:350px;box-shadow: 0 3px 10px rgb(0 0 0 / 50%);">
                                <div class="x_title">
                                    <h5 style="text-transform: capitalize;">
                                        <?php echo $row->announce_type ?>
                                    </h5>
                                    <?php
                                    if ($user->role == "coordinator") {
                                    ?>
                                        <ul class="nav navbar-right panel_toolbox" style="position: absolute; right: 10px; top: 5px;min-width: 0;">
                                            <input type="text" id="announceId<?php echo $row->announce_id ?>" value="<?php echo $row->announce_id ?>" readonly hidden>
                                            <li>
                                                <a id="edit<?php echo $row->announce_id ?>">
                                                    <i class="fa fa-edit" style="font-size: 20px; color:green"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a id="delete<?php echo $row->announce_id ?>">
                                                    <i class="fa fa-close" style="font-size: 20px; color:red"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    <?php
                                    }
                                    ?>
                                    <script>
                                        let announceId<?php echo $row->announce_id ?> = $("#announceId<?php echo $row->announce_id ?>").val()
                                        $("#edit<?php echo $row->announce_id ?>").on('click', function() {
                                            window.location.href = 'edit-announcement.php?announceId=<?php echo $row->announce_id ?>'
                                        })

                                        $("#delete<?php echo $row->announce_id ?>").on('click', function() {
                                            let confirm<?php echo $row->announce_id ?> = confirm("Are you sure you delete this announcement?")
                                            if (confirm<?php echo $row->announce_id ?> == true) {
                                                $.ajax({
                                                    url: '../actions/delete-announcement.php',
                                                    data: {
                                                        announceId: announceId<?php echo $row->announce_id ?>
                                                    },
                                                    type: 'POST',
                                                    success: function(data) {
                                                        swal.close();
                                                        const resp = JSON.parse(data);
                                                        if (resp.success) {
                                                            swal.fire({
                                                                text: `Announcement successfully deleted.`,
                                                                icon: 'success',
                                                            }).then(() => {
                                                                location.reload();
                                                            })
                                                        } else {
                                                            swal.fire({
                                                                title: 'Error!',
                                                                text: resp.msg,
                                                                icon: 'error',
                                                            }).then(() => {
                                                                location.reload();
                                                            })
                                                        }
                                                    },
                                                    error: function(err) {
                                                        swal.fire({
                                                            title: 'Oops...',
                                                            text: 'Something went wrong.',
                                                            icon: 'error',
                                                        }).then(() => {
                                                            location.reload();
                                                        })
                                                    }
                                                })
                                            }
                                        })
                                    </script>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="widget_summary" style="height:180px;overflow-y:scroll">
                                        <div class="w_center w_55" style="width:100%;">
                                            <?php
                                            echo $row->announcement
                                            ?>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <hr style="margin:15px 0px 15px 0px">
                                    <div class="widget_summary">
                                        <div class="w_center w_55" style="width:100%;">
                                            Date Posted: <strong><?php echo date_format(date_create($row->createdAt), "M d, Y"); ?></strong>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <?php
                                    if ($row->announce_type == "submission of report") {
                                    ?>
                                        <div class="widget_summary">
                                            <div class="w_center w_55" style="width:100%;">
                                                Submission Date: <br>
                                                <?php
                                                $submissionDate = explode(":", $row->submission_date);
                                                $date1 = date_format(date_create($submissionDate[0]), "M d, Y");
                                                $date2 = date_format(date_create($submissionDate[1]), "M d, Y");
                                                echo "<strong>$date1</strong> to <strong>$date2</strong>";
                                                ?>
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
                    if (mysqli_num_rows($q) == 0) :
                    ?>
                        <div style="width: 100%;margin-top: 120px;text-align: center; color: black;">
                            <h3 style="text-transform: capitalize;">
                                no announcements to show.
                            </h3>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->
    </div>

    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- jQuery custom content scroller -->
    <script src="../vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>

</body>

</html>