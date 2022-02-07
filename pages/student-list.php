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
    <title>Student List</title>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.9/css/fixedHeader.bootstrap.min.css">
    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <style>
        .dataTables_wrapper>.row {
            overflow: hidden !important;
            width: 100% !important;
            margin: 0;
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
                    <div class="md-col-12 xs-col-1 xs-col-9">
                        <div class="x_panel" style="box-shadow: 0 3px 10px rgb(0 0 0 / 50%); height: 600px;">
                            <div class="x_title">
                                <h2>Student List</h2>
                                <div style="float: right;">
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                                        Add Student
                                    </button>
                                </div>
                                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <i class="fa fa-close"></i>
                                                </button>
                                            </div>
                                            <form method="POST" role="form" id="add-student">
                                                <div class="modal-body">
                                                    <input type="text" value="add" name="action" readonly hidden>
                                                    <div class="form-group">
                                                        <label>First name</label>
                                                        <input type="text" name="fname" class="form-control" required />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Middle name</label>
                                                        <input type="text" name="mname" class="form-control" required />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Last name</label>
                                                        <input type="text" name="lname" class="form-control" required />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Course</label>
                                                        <select name="course" class="form-control" style="margin-bottom: 12px;">
                                                            <?php
                                                            include_once('../actions/conn.php');
                                                            $q = mysqli_query($conn, "SELECT * FROM courses");
                                                            while ($row = mysqli_fetch_object($q)) :
                                                            ?>
                                                                <option value="<?php echo $row->id ?>"><?php echo $row->course_name ?></option>
                                                            <?php endwhile; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Section</label><br>
                                                        <small style="color: #286090" id="sectionIns">Please input your section letter only</small>
                                                        <input type="text" name="section" class="form-control" id="section" required maxlength="1" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Company</label>
                                                        <select name="company" class="form-control" style="margin-bottom: 12px;">
                                                            <option value="">No company yet</option>
                                                            <?php
                                                            include_once('../actions/conn.php');
                                                            $comp = mysqli_query($conn, "SELECT * FROM user WHERE company is not null and `role`='supervisor'");
                                                            while ($compData = mysqli_fetch_object($comp)) :
                                                            ?>
                                                                <option value="<?php echo $compData->id ?>"><?php echo ucwords($compData->company) ?></option>
                                                            <?php endwhile; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content" style="overflow-y:scroll; height: 500px;">
                                <table id="myTable" class="table table-striped table-bordered">

                                    <thead>
                                        <tr class="bg-primary">
                                            <th>Name</th>
                                            <th>Course</th>
                                            <th>Section</th>
                                            <th>Email</th>
                                            <th>Company</th>
                                            <th>Supervisor</th>
                                            <th>Rendered</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $q = mysqli_query(
                                            $conn,
                                            "SELECT * FROM user WHERE `role`='student'"
                                        );
                                        while ($employee = mysqli_fetch_object($q)) :
                                            $name = ucwords("$employee->fname $employee->mname $employee->lname")
                                        ?>
                                            <tr>
                                                <td style="text-transform: capitalize;">
                                                    <a href="checklist.php?id=<?php echo $employee->id ?>" target="_blank">
                                                        <?php echo $name ?>
                                                    </a>
                                                </td>
                                                <td style="text-transform: capitalize;">
                                                    <?php
                                                    echo mysqli_fetch_object(
                                                        mysqli_query($conn, "SELECT * FROM courses WHERE id = '$employee->course'")
                                                    )->course_name;
                                                    ?>
                                                </td>
                                                <td style="text-align: center;"><?php echo $employee->section ?></td>
                                                <td><?php echo $employee->email ?></td>
                                                <?php
                                                $supervisorQ = mysqli_query(
                                                    $conn,
                                                    "SELECT * FROM user WHERE `role` = 'supervisor'"
                                                );
                                                $supervisorData = mysqli_fetch_object(
                                                    mysqli_query(
                                                        $conn,
                                                        "SELECT * FROM user WHERE id='$employee->supervisor_id' and `role` = 'supervisor'"
                                                    )
                                                );
                                                ?>
                                                <td>
                                                    <label id="company<?php echo $employee->id ?>">
                                                        <?php echo empty($supervisorData->company) ? "" : $supervisorData->company ?>
                                                    </label>
                                                </td>
                                                <td>
                                                    <input type="text" id="studentId<?php echo $employee->id ?>" value="<?php echo $employee->id ?>" readonly hidden>
                                                    <select id="student<?php echo $employee->id ?>" class="form-control" style="text-transform: capitalize; width: 100%;">
                                                        <?php
                                                        if ($employee->supervisor_id == 0) :
                                                        ?>
                                                            <option value="">Select Supervisor</option>
                                                        <?php else : ?>
                                                            <option value="<?php echo $employee->supervisor_id ?>">
                                                                <?php echo "$supervisorData->fname $supervisorData->lname ($supervisorData->company)" ?>
                                                            </option>
                                                        <?php endif ?>
                                                        <?php
                                                        while ($supervisor = mysqli_fetch_object($supervisorQ)) :
                                                            if ($supervisor->id != $employee->supervisor_id) :
                                                        ?>
                                                                <option value="<?php echo $supervisor->id ?>">
                                                                    <?php echo "$supervisor->fname $supervisor->lname ($supervisor->company)" ?>
                                                                </option>
                                                        <?php endif;
                                                        endwhile; ?>
                                                    </select>
                                                    <script>
                                                        $('#student<?php echo $employee->id ?>').prop('selectedIndex', 0);
                                                        $("#student<?php echo $employee->id ?>").on('change', function() {
                                                            let confirm<?php echo $employee->id ?> = confirm("Are you you want to change this data?")
                                                            if (confirm<?php echo $employee->id ?> === true) {
                                                                $.ajax({
                                                                    url: '../actions/student-supervisor.php',
                                                                    data: {
                                                                        studentId: $("#studentId<?php echo $employee->id ?>").val(),
                                                                        supervisorId: $(this).val()
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
                                                                                $(this).val("")
                                                                            })
                                                                        }
                                                                        if (resp.supervisorCompany) {
                                                                            $("#company<?php echo $employee->id ?>").html(resp.supervisorCompany)
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
                                                            } else {
                                                                $(this).val("")
                                                            }
                                                        })
                                                    </script>
                                                </td>

                                                <td style="text-transform: capitalize;">
                                                    <?php
                                                    $dtr_q = mysqli_query(
                                                        $conn,
                                                        "SELECT * FROM attendance WHERE `user_id`=$employee->id and time_in != '' and time_out is NOT NULL"
                                                    );
                                                    // echo mysqli_num_rows($dtr_q);
                                                    $hours = 0;
                                                    $mins = 0;
                                                    $secs = 0;
                                                    while ($rows = mysqli_fetch_object($dtr_q)) {
                                                        $diff = dateDiff($rows->time_in, $rows->time_out);
                                                        // $rendered = "$diff[hours] hours $diff[minutes] mins $diff[seconds] seconds";
                                                        if ($diff['hours'] >= 8 && $diff['hours'] != 0) {
                                                            $hours += 7;
                                                            $mins += 59;
                                                            $secs += 60;
                                                        } else {
                                                            $timeDiff = getDiff((strtotime($rows->time_out) - strtotime($rows->time_in)));
                                                            $hours += $timeDiff['hours'];
                                                            $mins += $timeDiff['minutes'];
                                                            $secs += $timeDiff['seconds'];
                                                        }
                                                    }

                                                    if ($secs > 60) {
                                                        $divideSecs = $secs / 60;
                                                        if (strpos($divideSecs, ".")) {
                                                            $whole = floor($divideSecs);
                                                            $fraction = explode(".", $divideSecs);
                                                            $mins += $whole;
                                                            $secs = substr($fraction[1], 0, 1);
                                                        } else {
                                                            $whole = floor($divideSecs);
                                                            $mins += $whole;
                                                            $secs = 0;
                                                        }
                                                    }

                                                    if ($mins > 60) {
                                                        $divideMins = $mins / 60;
                                                        if (strpos($divideMins, ".")) {
                                                            $whole = floor($divideMins);
                                                            $fraction = explode(".", $divideMins);
                                                            $hours += $whole;
                                                            $mins = substr($fraction[1], 0, 1);
                                                        } else {
                                                            $whole = floor($divideMins);
                                                            $hours += $whole;
                                                            $mins = 0;
                                                        }
                                                    }
                                                    $rendered = "$hours hrs $mins mins $secs secs";

                                                    $getTotalHours = mysqli_fetch_object(
                                                        mysqli_query(
                                                            $conn,
                                                            "SELECT * FROM settings"
                                                        )
                                                    )->hours - 1;
                                                    $remainHours = $getTotalHours < 0 ? 0 : $getTotalHours;
                                                    $remainMin = 59;
                                                    $remainSec = 60;


                                                    if ($secs != 0) {
                                                        $remainSec -= $secs;
                                                    }

                                                    if ($mins != 0) {
                                                        $remainMin -= $mins;
                                                    }

                                                    if ($hours != 0) {
                                                        $remainHours -= $hours;
                                                    }

                                                    $remaining = "$remainHours hrs $remainMin mins $remainSec secs";
                                                    ?>
                                                    Total:
                                                    <label style="color:<?= $hours != 0 || $mins != 0 || $secs != 0 ? "darkgreen" : "darkred" ?>">
                                                        <?= $hours != 0 || $mins != 0 || $secs || 0 ? $rendered : "-------------" ?>
                                                    </label>
                                                    <br>
                                                    Remaining:
                                                    <label style="color:<?= $remainHours != 0 || $remainMin != 0 || $remainSec != 0 ? "darkred" : "darkgreen" ?>">
                                                        <?= $remainHours != 0 || $remainMin != 0 || $remainSec != 0 ? $remaining : "Done" ?>
                                                    </label>
                                                </td>
                                                <td>
                                                    <center>
                                                        <button type="button" class="btn btn-danger" id="delete<?php echo $employee->id ?>">
                                                            Remove
                                                        </button>
                                                        <input type="text" id="employeeId<?php echo $employee->id ?>" value="<?php echo $employee->id ?>" readonly hidden>
                                                    </center>
                                                    <script>
                                                        let employeeId<?php echo $employee->id ?> = $("#employeeId<?php echo $employee->id ?>").val()

                                                        $("#delete<?php echo $employee->id ?>").on('click', function() {
                                                            let confirm<?php echo $employee->id ?> = confirm("Are you sure you delete this account?")
                                                            if (confirm<?php echo $employee->id ?> == true) {
                                                                $.ajax({
                                                                    url: '../actions/delete-student.php',
                                                                    data: {
                                                                        employeeId: employeeId<?php echo $employee->id ?>
                                                                    },
                                                                    type: 'POST',
                                                                    success: function(data) {
                                                                        swal.close();
                                                                        const resp = JSON.parse(data);
                                                                        if (resp.success) {
                                                                            swal.fire({
                                                                                text: `Student successfully remove.`,
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
                                                </td>
                                            </tr>
                                        <?php endwhile ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
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

    <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.1.9/js/dataTables.fixedHeader.min.js"></script>
    <script>
        $('#myTable').DataTable({
            responsive: true
        });

        $("#add-student").on("submit", function(e) {
            swal.showLoading();
            $.ajax({
                url: '../actions/register.php',
                data: $(this).serialize(),
                type: 'POST',
                success: function(data) {
                    swal.close();
                    const resp = JSON.parse(data);
                    if (resp.success) {
                        swal.fire({
                            text: `Student successfully added.`,
                            icon: 'success',
                        }).then(() => {
                            location.reload();
                            $('#add-student').trigger("reset");
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