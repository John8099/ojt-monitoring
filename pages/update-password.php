<?php
session_start();
include '../actions/conn.php';
if (!$_SESSION['id']) {
    header('Location: ../');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Ojt Monitoring System - Update Password</title>
    <link rel="icon" href="../images/CHSMSC.gif" type="image/x-icon">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="../build/css/custom.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="login">
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <form method="POST" role="form" id="update-pass">
                    <h1>Update Password</h1>
                    <div class="password">
                        <input type="password" name="password" id="inputPass" class="form-control" placeholder="New Password" required />
                        <input type="text" name="userId" id="userId" value="<?php echo $_SESSION['id'] ?>" hidden readonly />
                        <img src="../images/show.png" id="show">
                        <img src="../images/hide.png" id="hide">
                    </div>

                    <center>
                        <button type="submit" class="btn btn-primary">Update Password</button>
                        <button type="button" class="btn btn-danger" onclick="return window.history.back()">Cancel</button>
                    </center>

                    <div class="clearfix"></div>
                </form>
            </section>
        </div>
    </div>
    <script type="text/javascript">
        let inputPass = document.getElementById('inputPass');
        let show = document.getElementById('show');
        let hide = document.getElementById('hide');

        show.onclick = () => {
            inputPass.type = 'text'
            show.style.display = 'none'
            hide.style.display = 'block'
        }

        hide.onclick = () => {
            inputPass.type = 'password'
            hide.style.display = 'none'
            show.style.display = 'block'
        }

        $("#update-pass").on("submit", function(e) {
            swal.showLoading();
            $.ajax({
                url: '../actions/update-pass.php',
                data: $(this).serialize(),
                type: 'POST',
                success: function(data) {
                    swal.close();
                    const resp = JSON.parse(data);
                    if (resp.success) {
                        swal.fire({
                            text: "Password updated successfully!",
                            icon: 'success',
                        }).then(() => {
                            if (resp.role === "student") {
                                window.location.href = "student-profile.php"
                            } else if (resp.role == "supervisor") {
                                window.location.href = "supervisor-profile.php"
                            } else {
                                window.location.href = "coordinator-profile.php"
                            }
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
    </script>

</body>

</html>