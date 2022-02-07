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

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.9/css/fixedHeader.bootstrap.min.css">

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                        <div class="x_panel" style="overflow-y:scroll;box-shadow: 0 3px 10px rgb(0 0 0 / 50%); height: 600px;">
                            <div class="x_title">
                                <h2>Supervisor List</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content" style="overflow-y:scroll; height: 500px;">
                                <table id="myTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr class="bg-primary">
                                            <th>First name</th>
                                            <th>Middle name</th>
                                            <th>Last name</th>
                                            <th>Email</th>
                                            <th>Position</th>
                                            <th>Contact</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $q = mysqli_query(
                                            $conn,
                                            "SELECT * FROM user WHERE `role`='supervisor'"
                                        );
                                        while ($supervisor = mysqli_fetch_object($q)) :
                                        ?>
                                            <tr>
                                                <input type="text" id="supervisorId<?php echo $supervisor->id ?>" value="<?php echo $supervisor->id ?>" readonly hidden>
                                                <td style="text-transform: capitalize;"><?php echo $supervisor->fname ?></td>
                                                <td style="text-transform: capitalize;"><?php echo $supervisor->mname ?></td>
                                                <td style="text-transform: capitalize;"><?php echo $supervisor->lname ?></td>
                                                <td><?php echo $supervisor->email ?></td>
                                                <td><?php echo $supervisor->position ?></td>
                                                <td><?php echo $supervisor->contact ?></td>
                                                <td>
                                                    <center>
                                                        <button type="button" class="btn btn-danger" id="delete<?php echo $supervisor->id ?>">
                                                            Remove
                                                        </button>
                                                    </center>
                                                </td>
                                            </tr>
                                            <script>
                                                let supervisorId<?php echo $supervisor->id ?> = $("#supervisorId<?php echo $supervisor->id ?>").val()

                                                $("#delete<?php echo $supervisor->id ?>").on('click', function() {
                                                    let confirm<?php echo $supervisor->id ?> = confirm("Are you sure you delete this account?")
                                                    if (confirm<?php echo $supervisor->id ?> == true) {
                                                        $.ajax({
                                                            url: '../actions/delete-supervisor.php',
                                                            data: {
                                                                supervisorId: supervisorId<?php echo $supervisor->id ?>
                                                            },
                                                            type: 'POST',
                                                            success: function(data) {
                                                                swal.close();
                                                                const resp = JSON.parse(data);
                                                                if (resp.success) {
                                                                    swal.fire({
                                                                        text: `Supervisor successfully deleted.`,
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
    </script>

</body>

</html>