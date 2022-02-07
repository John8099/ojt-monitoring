<?php
include_once('../actions/conn.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ojt Monitoring System - Sign up</title>
    <link rel="icon" href="../images/CHSMSC.gif" type="image/x-icon">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="../build/css/custom.css" rel="stylesheet">

    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body class="login">
    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <form method="POST" role="form" id="signup-form">
                    <h1>Sign Up</h1>
                    <!-- <div>
                        <input type="text" name="fname" class="form-control" placeholder="First name" required="" />
                    </div>
                    <div>
                        <input type="text" name="mname" class="form-control" placeholder="Middle name" required="" />
                    </div>
                    <div>
                        <input type="text" name="lname" class="form-control" placeholder="Last name" required="" />
                    </div>
                    <div>
                        <select name="course" class="form-control" style="margin-bottom: 12px;">
                            <?php

                            $q = mysqli_query($conn, "SELECT * FROM courses");
                            while ($row = mysqli_fetch_object($q)) :
                            ?>
                                <option value="<?php echo $row->id ?>"><?php echo $row->course_name ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div style="text-align: left;">
                        <small style="color: #6f0" id="sectionIns">Please input your section letter only</small>
                        <input type="text" name="section" class="form-control" id="section" placeholder="Section" required maxlength="1" />
                    </div> -->
                    <div>
                        <select name="studentName" class="form-control" required style="margin-bottom: 20px;">
                            <option value="">-- Select your name --</option>
                            <?php
                            $students_q = mysqli_query(
                                $conn,
                                "SELECT * FROM user WHERE `role`='student' and email is NULL and pass is NULL"
                            );
                            while ($student = mysqli_fetch_object($students_q)) :
                                // if ($student->email == null && $student->pass == null) :
                            ?>
                                    <option value="<?php echo $student->id ?>"> <?php echo ucwords("$student->fname " . $student->mname[0] . ". $student->lname") ?> </option>
                            <?php #endif;
                            endwhile; ?>
                        </select>
                    </div>
                    <div>
                        <input type="email" name="email" class="form-control" placeholder="Email" required="" />
                    </div>
                    <div class="password">
                        <input type="password" name="password" id="inputPass" class="form-control" placeholder="Password" required="" />
                        <img src="../images/show.png" id="show">
                        <img src="../images/hide.png" id="hide">
                    </div>
                    <div style="text-align: left;width: 100%; margin-top: 10px">
                        <a href="../" id="linkSignUp" style="color:#0096FF !important">Sign in here</a>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary submit">Register</button>
                    </div>

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

        $("#signup-form").on("submit", function(e) {
            swal.showLoading();
            $.ajax({
                url: '../actions/update-email-password.php',
                data: $(this).serialize(),
                type: 'POST',
                success: function(data) {
                    swal.close();
                    const resp = JSON.parse(data);
                    if (resp.success) {
                        swal.fire({
                                title: 'Congratulations!',
                                text: 'You are now registered!',
                                icon: 'success',
                            })
                            .then(() => {
                                window.location.href = "student-profile.php"
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