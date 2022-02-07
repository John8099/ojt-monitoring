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
    <title>Settings</title>
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
    <style>
        .onoffswitch {
            position: relative;
            width: 90px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }

        .onoffswitch-checkbox {
            display: none;
        }

        .onoffswitch-label {
            display: block;
            overflow: hidden;
            cursor: pointer;
            border: 2px solid #999999;
            border-radius: 20px;
        }

        .onoffswitch-inner {
            display: block;
            width: 200%;
            margin-left: -100%;
            -moz-transition: margin 0.3s ease-in 0s;
            -webkit-transition: margin 0.3s ease-in 0s;
            -o-transition: margin 0.3s ease-in 0s;
            transition: margin 0.3s ease-in 0s;
        }

        .onoffswitch-inner:before,
        .onoffswitch-inner:after {
            display: block;
            float: left;
            width: 50%;
            height: 30px;
            padding: 0;
            line-height: 30px;
            font-size: 14px;
            color: white;
            font-family: Trebuchet, Arial, sans-serif;
            font-weight: bold;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        .onoffswitch-inner:before {
            content: "YES";
            background-color: #1ABB9C;
            color: #FFFFFF;
        }

        .onoffswitch-inner:after {
            content: "NO";
            padding-right: 25px;
            background-color: #EEEEEE;
            color: #999999;
            text-align: right;
        }

        .onoffswitch-switch {
            display: block;
            width: 18px;
            margin: 6px;
            background: #FFFFFF;
            border: 2px solid #999999;
            border-radius: 20px;
            position: absolute;
            top: 0;
            bottom: 0;
            right: 56px;
            -moz-transition: all 0.3s ease-in 0s;
            -webkit-transition: all 0.3s ease-in 0s;
            -o-transition: all 0.3s ease-in 0s;
            transition: all 0.3s ease-in 0s;
        }

        .onoffswitch-checkbox:checked+.onoffswitch-label .onoffswitch-inner {
            margin-left: 0;
        }

        .onoffswitch-checkbox:checked+.onoffswitch-label .onoffswitch-switch {
            right: 0px;
        }
    </style>
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
                                <h2>Submission and Edit Report Settings</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <center>
                                    <h4>Can Submit Report</h4>
                                    <div class="onoffswitch">
                                        <input type="checkbox" class="onoffswitch-checkbox" id="submitReport">
                                        <label class="onoffswitch-label" for="submitReport">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>

                                    <div class="clearfix" style="margin: 15px"></div>

                                    <h4>Can Edit Report</h4>
                                    <div class="onoffswitch">
                                        <input type="checkbox" class="onoffswitch-checkbox" id="editReport">
                                        <label class="onoffswitch-label" for="editReport">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>

                                    <h4>Max Rendered Hours</h4>
                                    <form class="form-inline" id="change-rendered">
                                        <div class="form-group mx-sm-3 mb-2">
                                            <input type="text" name="hours" class="form-control" id="inputTime">
                                        </div>
                                        <button type="submit" class="btn btn-primary mb-2">Change</button>
                                    </form>
                                </center>
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
        $(document).ready(function() {
            $("#change-rendered").on("submit", function(e) {
                swal.showLoading();
                $.ajax({
                    url: '../actions/change-rendered.php',
                    data: $(this).serialize(),
                    type: 'POST',
                    success: function(data) {
                        swal.close();
                        const resp = JSON.parse(data);
                        if (resp.success) {
                            swal.fire({
                                text: `Hours successfully changed.`,
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
                    error: function(data) {
                        swal.fire({
                            title: 'Oops...',
                            text: 'Something went wrong.',
                            icon: 'error',
                        })
                    }
                });
                e.preventDefault();
            });
            $.ajax({
                url: '../actions/get-settings.php',
                type: 'GET',
                success: function(data) {
                    const resp = JSON.parse(data);
                    if (resp.success) {
                        if (resp.canEdit) {
                            $("#editReport").prop("checked", true);
                        } else {
                            $("#editReport").prop("checked", false);
                        }
                        if (resp.canSubmit) {
                            $("#submitReport").prop("checked", true);
                        } else {
                            $("#submitReport").prop("checked", false);
                        }
                        $("#inputTime").val(resp.time);
                    } else {
                        swal.fire({
                            title: 'Error!',
                            text: resp.msg,
                            icon: 'error',
                        }).then(() => {
                            location.reload()
                        })
                    }
                },
                error: function(data) {
                    swal.fire({
                        title: 'Oops...',
                        text: 'Something went wrong.',
                        icon: 'error',
                    }).then(() => {
                        location.reload()
                    })
                }
            });
        });
        $("#submitReport").on("change", function() {
            if ($("#submitReport").get(0).checked) {
                $.ajax({
                    url: '../actions/settings.php?submit',
                    data: {
                        canSubmit: 1
                    },
                    type: 'POST',
                    success: function(data) {
                        const resp = JSON.parse(data);
                        if (!resp.success) {
                            swal.fire({
                                title: 'Error!',
                                text: resp.msg,
                                icon: 'error',
                            }).then(() => {
                                location.reload()
                            })
                        }
                    },
                    error: function(data) {
                        swal.fire({
                            title: 'Oops...',
                            text: 'Something went wrong.',
                            icon: 'error',
                        }).then(() => {
                            location.reload()
                        })
                    }
                });
            } else {
                $.ajax({
                    url: '../actions/settings.php?submit',
                    data: {
                        canSubmit: 0
                    },
                    type: 'POST',
                    success: function(data) {
                        const resp = JSON.parse(data);
                        if (!resp.success) {
                            swal.fire({
                                title: 'Error!',
                                text: resp.msg,
                                icon: 'error',
                            }).then(() => {
                                location.reload()
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
            }
        })
        $("#editReport").on("change", function() {
            if ($("#editReport").get(0).checked) {
                $.ajax({
                    url: '../actions/settings.php?edit',
                    data: {
                        canEdit: 1
                    },
                    type: 'POST',
                    success: function(data) {
                        const resp = JSON.parse(data);
                        if (!resp.success) {
                            swal.fire({
                                title: 'Error!',
                                text: resp.msg,
                                icon: 'error',
                            }).then(() => {
                                location.reload()
                            })
                        }
                    },
                    error: function(data) {
                        swal.fire({
                            title: 'Oops...',
                            text: 'Something went wrong.',
                            icon: 'error',
                        }).then(() => {
                            location.reload()
                        })
                    }
                });
            } else {
                $.ajax({
                    url: '../actions/settings.php?edit',
                    data: {
                        canEdit: 0
                    },
                    type: 'POST',
                    success: function(data) {
                        const resp = JSON.parse(data);
                        if (!resp.success) {
                            swal.fire({
                                title: 'Error!',
                                text: resp.msg,
                                icon: 'error',
                            }).then(() => {
                                location.reload()
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
            }
        })
    </script>

</body>

</html>