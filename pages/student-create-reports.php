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
    <title>Create Report</title>
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
                        <div class="x_panel" style="box-shadow: 0 3px 10px rgb(0 0 0 / 50%)">
                            <div class="x_title">
                                <h2>Create Report</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <form method="POST" role="form" id="create-report" class="form-horizontal form-label-left" enctype="multipart/form-data">
                                    <input type="text" value="<?php echo $user->id ?>" id="userId" name="userId" readonly hidden>

                                    <div class="item form-group">
                                        <h5>
                                            <strong>Tasks:</strong>
                                        </h5>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Data Encoding" name="task[]">
                                            <label class="form-check-label">
                                                Data Encoding
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Imaging" name="task[]">
                                            <label class="form-check-label">
                                                Imaging
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Web Development" name="task[]">
                                            <label class="form-check-label">
                                                Web Development
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Computer Repair" name="task[]">
                                            <label class="form-check-label">
                                                Computer Repair
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="System Programming" name="task[]">
                                            <label class="form-check-label">
                                                System Programming
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Troubleshooting" name="task[]">
                                            <label class="form-check-label">
                                                Troubleshooting
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Database Management" name="task[]">
                                            <label class="form-check-label">
                                                Database Management
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Networking" name="task[]">
                                            <label class="form-check-label">
                                                Networking
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="Others" name="task[]" id="inputCheckOthers">
                                            <label class="form-check-label">
                                                Others
                                            </label>
                                        </div>
                                    </div>

                                    <div class="item form-group" id="divOthers" style="display: none;">
                                        <input type="text" name="other" id="inputOther" class="form-control col-md-7 col-xs-12">
                                    </div>

                                    <div class="item form-group">
                                        <!-- <textarea name="report" cols="40" rows="20" class="form-control col-md-7 col-xs-12" required></textarea> -->
                                        <input type="file" name="inputFile" id="file" class="form-control col-md-7 col-xs-12">
                                    </div>

                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <?php
                                        date_default_timezone_set("Asia/Manila");
                                        $submissionQ = mysqli_fetch_all(
                                            mysqli_query(
                                                $conn,
                                                "SELECT * FROM announcements WHERE announce_type='submission of report'"
                                            )
                                        );
                                        $setting;
                                        if (count($submissionQ) > 0) {
                                            $submissionDate = explode(":", $submissionQ[count($submissionQ) - 1][3]);
                                            $date1 = date_create($submissionDate[0]);
                                            $date2 = date_create($submissionDate[1]);
                                            $currentDate = date_create(date("Y-m-d"));
                                            if (($currentDate >= $date1) && ($currentDate <= $date2)) {
                                                $setting = "disabled";
                                            }
                                        }

                                        ?>
                                        <input type="text" value="<?php echo !isset($setting) ? "" : $setting ?>" id="inputBtnSetting" readonly hidden>
                                        <center>
                                            <button type="submit" class="btn btn-primary" id="btnSubmit" disabled>Submit Report</button>
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
        $(document).ready(function() {
            const btnVal = $("#inputBtnSetting").val()
            $("#create-report").get(0).reset()
            $.ajax({
                url: '../actions/get-settings.php',
                type: 'GET',
                success: function(data) {
                    const resp = JSON.parse(data);
                    if (resp.success) {
                        if (resp.canSubmit && btnVal !== "") {
                            $("#btnSubmit").prop("disabled", false);
                        } else {
                            $("#btnSubmit").prop("disabled", true);
                        }
                    } else {
                        swal.fire({
                            title: 'Error!',
                            text: resp.msg,
                            icon: 'error',
                        })
                    }
                },
                error: function(data) {
                    swal.fire({
                        title: 'Oops...',
                        text: 'Something went wrong.',
                        icon: 'error',
                    })
                }
            });
        });

        $("#inputCheckOthers").on("change", function() {
            // console.log($(this))
            if ($(this).prop("checked")) {
                $("#divOthers").show()
                $("#inputOther").attr("required", true)
            } else {
                $("#divOthers").hide()
                $("#inputOther").attr('required', false)
            }
        })

        $("#create-report").on("submit", function(e) {
            swal.showLoading();

            let checkCount = 0;
            $("input[name='task[]']").each(function() {
                if ($(this).prop("checked")) {
                    checkCount++
                }
            })
            const fileData = $("#file").prop("files")[0];

            if (checkCount === 0) {
                swal.fire({
                    title: 'Oops...',
                    text: 'Please select at least one of the task fields.',
                    icon: 'error',
                })
            } else if (!fileData) {
                swal.fire({
                    title: 'Error',
                    text: "There's no attached file.",
                    icon: 'error',
                })
            } else if (!fileData.type.includes('pdf')) {
                swal.fire({
                    title: 'Error',
                    text: 'Please upload PDF file.',
                    icon: 'error',
                })
            } else {
                $.ajax({
                    url: '../actions/create-report.php',
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
                                text: "Report successfully submitted and to be check by your supervisor.",
                                icon: 'success',
                            }).then(() => {
                                $("#create-report").get(0).reset()
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
            }
            e.preventDefault();
        });
    </script>

</body>

</html>