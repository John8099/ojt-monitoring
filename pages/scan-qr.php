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
    <title>Scan QR</title>
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

    <style>
        #qr-reader {
            width: 500px;
        }

        @media only screen and (max-width: 600px) {
            #qr-reader {
                width: 100%;
                height: 500px;
            }

            #qr-reader__scan_region,
            #qr-canvas {
                width: 100% !important;
                height: 200px !important;
            }

            #qr-reader__dashboard {
                position: absolute;
                bottom: 0;
            }
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
                        <div class="x_panel" style="box-shadow: 0 3px 10px rgb(0 0 0 / 50%);">
                            <input type="text" name="supevisor_id" id="supevisor_id" value="<?php echo $user->id ?>" readonly hidden>
                            <div class="x_title">
                                <h2>Scan QR</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <center>
                                    <div id="qr-reader"></div>
                                </center>
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

    <script src="../vendors/QR/qrcode.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let lastResult = "";

        function onScanSuccess(decodedText, decodedResult) {
            if (decodedText !== lastResult) {
                lastResult = decodedText;
                swal.showLoading();
                let data = {
                    userId: decodedText,
                    supervisorId: $("#supevisor_id").val(),
                };
                $.ajax({
                    url: '../actions/timeInAndOut.php',
                    data: data,
                    type: 'POST',
                    success: function(data) {
                        swal.close();
                        const resp = JSON.parse(data);
                        if (resp.success) {
                            swal.fire({
                                text: `${resp.name} successfully ${resp.status}.`,
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
                });
                console.log(decodedResult)
            }
        }
        let html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", {
                fps: 10,
                qrbox: 200
            });
        html5QrcodeScanner.render(onScanSuccess);
        $("#qr-reader")[0].childNodes[0].childNodes[0].childNodes[0].href = "#"
        $("#qr-reader")[0].childNodes[0].childNodes[0].childNodes[0].text = "QR Scanner"
    </script>

</body>

</html>