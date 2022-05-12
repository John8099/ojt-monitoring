<?php
include_once("actions/conn.php"); 
include_once("removeFIles.php");
folderFiles("media", listOfFilesUploadedInDb($conn))
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Ojt Monitoring System - Sign in</title>
    <link rel="icon" href="images/CHSMSC.gif" type="image/x-icon">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="build/css/custom.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="login">
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <form method="POST" role="form" id="login-form">
                    <h1>Sign In</h1>
                    <!-- <?= md5("password") ?> -->
                    <div>
                        <input type="email" name="email" class="form-control" placeholder="Email" required="" />
                    </div>
                    <div class="password">
                        <input type="password" name="password" id="inputPass" class="form-control" placeholder="Password" required="" />
                        <img src="images/show.png" id="show">
                        <img src="images/hide.png" id="hide">
                    </div>
                    <div style="text-align: left;width: 100%;">
                        <a href="pages/sign-up.php" id="linkSignUp" style="color:#0096FF !important">Create account</a>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary submit">Log in</button>
                    </div>

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

        $("#login-form").on("submit", function(e) {
            swal.showLoading();
            $.ajax({
                url: 'actions/login.php',
                data: $(this).serialize(),
                type: 'POST',
                success: function(data) {
                    swal.close();
                    const resp = JSON.parse(data);
                    if (resp.success) {
                        let location = ""
                        if (resp.role === "student") {
                            location = "pages/student-profile.php"
                        } else if (resp.role === "coordinator") {
                            location = "pages/coordinator-profile.php"
                        } else if (resp.role === "supervisor") {
                            if (resp.isNew) {
                                location = "pages/update-password.php"
                            } else {
                                location = "pages/supervisor-profile.php"
                            }
                        } else if (resp.role === "admin") {
                            location = "pages/admin.php"
                        }
                        if (location) {
                            window.location.href = location
                        } else {
                            swal.fire({
                                title: 'Oops...',
                                text: 'Something went wrong.',
                                icon: 'error',
                            })
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
            e.preventDefault();
        });
    </script>

</body>

</html>