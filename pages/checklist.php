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
    <title>Check List</title>
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

        .green {
            color: green;
            font-size: 50px;
        }

        .red {
            color: red;
            font-size: 50px
        }
        #myTable_length, #myTable_filter, #myTable_info, #myTable_paginate {
            display: none
        }
    </style>
</head>

<body style="background:none;">
    <!-- page content -->
    <?php
    $info = mysqli_fetch_object(
        mysqli_query(
            $conn,
            "SELECT * FROM user WHERE id='$_GET[id]' and `role`='student'"
        )
    );
    ?>
    <div class="container-fluid">
        <h2 style="text-align: center;">
            Requirements Checklist of
            <strong>
                <?php echo ucwords("$info->fname " . $info->mname[0] . ". $info->lname"); ?>
            </strong>
        </h2>
        <div class="clearfix"></div>

        <table id="myTable" class="table table-striped table-bordered">
            <thead>
                <tr class="bg-primary">
                    <th>Capstone Approval</th>
                    <th>OJT APP</th>
                    <th>Student Copy</th>
                    <th>App Letter</th>
                    <th>Endorse Letter</th>
                    <th>Resume</th>
                    <th>2x2 Photo</th>
                    <th>Parent Concent</th>
                    <th>OJT Agreement</th>
                    <th>TP Month (Feb)</th>
                    <th>TP Month (Mar)</th>
                    <th>TP Month (Apr)</th>
                    <th>TP Month (May)</th>
                    <th>TP Month (Jun)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $q = mysqli_query(
                    $conn,
                    "SELECT * FROM user WHERE id='$_GET[id]' and `role`='student'"
                );
                while ($student = mysqli_fetch_object($q)) :
                    $requirements = json_decode($student->requirements, true);
                ?>

                    <tr style="text-align: center;">
                        <td>
                            <?php echo getIcon($requirements["capstoneApproval"], "capstoneApproval"); ?>
                            <div style="text-align: left;">
                                <input type="radio" name="capstoneApproval" value="1" id="capstoneApproval1"> Passed <br>
                                <input type="radio" name="capstoneApproval" value="0" id="capstoneApproval2"> Not Passed<br>
                            </div>
                        </td>
                        <td>
                            <?php echo getIcon($requirements["ojtApp"], "ojtApp"); ?>
                            <div style="text-align: left;">
                                <input type="radio" name="ojtApp" value="1" id="ojtApp1"> Passed <br>
                                <input type="radio" name="ojtApp" value="0" id="ojtApp2"> Not Passed<br>
                            </div>
                        </td>
                        <td>
                            <?php echo getIcon($requirements["studentCopy"], "studentCopy"); ?>
                            <div style="text-align: left;">
                                <input type="radio" name="studentCopy" value="1" id="studentCopy1"> Passed <br>
                                <input type="radio" name="studentCopy" value="0" id="studentCopy2"> Not Passed<br>
                            </div>
                        </td>
                        <td>
                            <?php echo getIcon($requirements["appLetter"], "appLetter"); ?>
                            <div style="text-align: left;">
                                <input type="radio" name="appLetter" value="1" id="appLetter1"> Passed <br>
                                <input type="radio" name="appLetter" value="0" id="appLetter2"> Not Passed<br>
                            </div>
                        </td>
                        <td>
                            <?php echo getIcon($requirements["endorseLetter"], "endorseLetter"); ?>
                            <div style="text-align: left;">
                                <input type="radio" name="endorseLetter" value="1" id="endorseLetter1"> Passed <br>
                                <input type="radio" name="endorseLetter" value="0" id="endorseLetter2"> Not Passed<br>
                            </div>
                        </td>
                        <td>
                            <?php echo getIcon($requirements["resume"], "resume"); ?>
                            <div style="text-align: left;">
                                <input type="radio" name="resume" value="1" id="resume1"> Passed <br>
                                <input type="radio" name="resume" value="0" id="resume2"> Not Passed<br>
                            </div>
                        </td>
                        <td>
                            <?php echo getIcon($requirements["photo"], "photo"); ?>
                            <div style="text-align: left;">
                                <input type="radio" name="photo" value="1" id="photo1"> Passed <br>
                                <input type="radio" name="photo" value="0" id="photo2"> Not Passed<br>
                            </div>
                        </td>
                        <td>
                            <?php echo getIcon($requirements["parentConcent"], "parentConcent"); ?>
                            <div style="text-align: left;">
                                <input type="radio" name="parentConcent" value="1" id="parentConcent1"> Passed <br>
                                <input type="radio" name="parentConcent" value="0" id="parentConcent2"> Not Passed<br>
                            </div>
                        </td>
                        <td>
                            <?php echo getIcon($requirements["ojtAgreement"], "ojtAgreement"); ?>
                            <div style="text-align: left;">
                                <input type="radio" name="ojtAgreement" value="1" id="ojtAgreement1"> Passed <br>
                                <input type="radio" name="ojtAgreement" value="0" id="ojtAgreement2"> Not Passed<br>
                            </div>
                        </td>
                        <td>
                            <?php echo getIcon($requirements["feb"], "feb"); ?>
                            <div style="text-align: left;">
                                <input type="radio" name="feb" value="1" id="feb1"> Passed <br>
                                <input type="radio" name="feb" value="0" id="feb2"> Not Passed<br>
                            </div>
                        </td>
                        <td>
                            <?php echo getIcon($requirements["mar"], "mar"); ?>
                            <div style="text-align: left;">
                                <input type="radio" name="mar" value="1" id="mar1"> Passed <br>
                                <input type="radio" name="mar" value="0" id="mar2"> Not Passed<br>
                            </div>
                        </td>
                        <td>
                            <?php echo getIcon($requirements["apr"], "apr"); ?>
                            <div style="text-align: left;">
                                <input type="radio" name="apr" value="1" id="apr1"> Passed <br>
                                <input type="radio" name="apr" value="0" id="apr2"> Not Passed<br>
                            </div>
                        </td>
                        <td>
                            <?php echo getIcon($requirements["may"], "may"); ?>
                            <div style="text-align: left;">
                                <input type="radio" name="may" value="1" id="may1"> Passed <br>
                                <input type="radio" name="may" value="0" id="may2"> Not Passed<br>
                            </div>
                        </td>
                        <td>
                            <?php echo getIcon($requirements["june"], "june"); ?>
                            <div style="text-align: left;">
                                <input type="radio" name="june" value="1" id="june1"> Passed <br>
                                <input type="radio" name="june" value="0" id="june2"> Not Passed<br>
                            </div>
                        </td>
                    </tr>
                    <textarea id="requirementsData" readonly hidden><?php echo $student->requirements ?></textarea>
                    <input type="text" id="studentId" value="<?php echo $_GET['id'] ?>" readonly hidden>
                <?php endwhile ?>
            </tbody>
        </table>
        <!-- /page content -->
        <div style="float: right;margin: 10px">
            <button class="btn btn-primary" type="button" id="saveChanges">
                Save Changes
            </button>
            <button type="button" class="btn btn-danger" onclick="return(window.top.close())">
                Close
            </button>
        </div>
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

        const data = JSON.parse($("#requirementsData").val());
        onloadData(data)

        const capstoneApproval = $("input[name='capstoneApproval']");
        const ojtApp = $("input[name='ojtApp']");
        const studentCopy = $("input[name='studentCopy']");
        const appLetter = $("input[name='appLetter']");
        const endorseLetter = $("input[name='endorseLetter']");
        const resume = $("input[name='resume']");
        const photo = $("input[name='photo']");
        const parentConcent = $("input[name='parentConcent']");
        const ojtAgreement = $("input[name='ojtAgreement']");
        const feb = $("input[name='feb']");
        const mar = $("input[name='mar']");
        const apr = $("input[name='apr']");
        const may = $("input[name='may']");
        const june = $("input[name='june']");

        const newData = JSON.parse($("#requirementsData").val());

        capstoneApproval.on("change", function() {
            newData.capstoneApproval = $(this).val()
            changeIcon("capstoneApproval", $(this).val())
            console.log(newData)
        })

        ojtApp.on("change", function() {
            newData.ojtApp = $(this).val()
            changeIcon("ojtApp", $(this).val())
            console.log(newData)
        })

        studentCopy.on("change", function() {
            newData.studentCopy = $(this).val()
            changeIcon("studentCopy", $(this).val())
            console.log(newData)
        })

        appLetter.on("change", function() {
            newData.appLetter = $(this).val()
            changeIcon("appLetter", $(this).val())
            console.log(newData)
        })

        endorseLetter.on("change", function() {
            newData.endorseLetter = $(this).val()
            changeIcon("endorseLetter", $(this).val())
            console.log(newData)
        })

        resume.on("change", function() {
            newData.resume = $(this).val()
            changeIcon("resume", $(this).val())
            console.log(newData)
        })

        photo.on("change", function() {
            newData.photo = $(this).val()
            changeIcon("photo", $(this).val())
            console.log(newData)
        })

        parentConcent.on("change", function() {
            newData.parentConcent = $(this).val()
            changeIcon("parentConcent", $(this).val())
            console.log(newData)
        })

        ojtAgreement.on("change", function() {
            newData.ojtAgreement = $(this).val()
            changeIcon("ojtAgreement", $(this).val())
            console.log(newData)
        })

        feb.on("change", function() {
            newData.feb = $(this).val()
            changeIcon("feb", $(this).val())
            console.log(newData)
        })

        mar.on("change", function() {
            newData.mar = $(this).val()
            changeIcon("mar", $(this).val())
            console.log(newData)
        })

        apr.on("change", function() {
            newData.apr = $(this).val()
            changeIcon("apr", $(this).val())
            console.log(newData)
        })

        may.on("change", function() {
            newData.may = $(this).val()
            changeIcon("may", $(this).val())
            console.log(newData)
        })

        june.on("change", function() {
            newData.june = $(this).val()
            changeIcon("june", $(this).val())
            console.log(newData)
        })

        $("#saveChanges").on("click", function() {
            $.ajax({
                url: '../actions/update-checklist.php',
                data: {
                    student_id: $("#studentId").val(),
                    requirements: JSON.stringify(newData)
                },
                type: 'POST',
                success: function(data) {
                    swal.close();
                    const resp = JSON.parse(data);
                    if (resp.success) {
                        swal.fire({
                            text: `Checklist successfully updated.`,
                            icon: 'success',
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
        })

        function changeIcon(domId, val) {
            $(`#${domId}`).css('color', '');
            if (val === "1") {
                $(`#${domId}`).attr('class', 'fa fa-check-square green');
            } else {
                $(`#${domId}`).attr('class', 'fa fa-times red');
            }
        }

        function onloadData(data) {

            if (data.capstoneApproval == "1") {
                $("#capstoneApproval1").prop("checked", true);
            } else {
                $("#capstoneApproval2").prop("checked", true);
            }

            if (data.ojtApp == "1") {
                $("#ojtApp1").prop("checked", true);
            } else {
                $("#ojtApp2").prop("checked", true);
            }

            if (data.studentCopy == "1") {
                $("#studentCopy1").prop("checked", true);
            } else {
                $("#studentCopy2").prop("checked", true);
            }

            if (data.appLetter == "1") {
                $("#appLetter1").prop("checked", true);
            } else {
                $("#appLetter2").prop("checked", true);
            }

            if (data.endorseLetter == "1") {
                $("#endorseLetter1").prop("checked", true);
            } else {
                $("#endorseLetter2").prop("checked", true);
            }

            if (data.resume == "1") {
                $("#resume1").prop("checked", true);
            } else {
                $("#resume2").prop("checked", true);
            }

            if (data.photo == "1") {
                $("#photo1").prop("checked", true);
            } else {
                $("#photo2").prop("checked", true);
            }

            if (data.parentConcent == "1") {
                $("#parentConcent1").prop("checked", true);
            } else {
                $("#parentConcent2").prop("checked", true);
            }

            if (data.ojtAgreement == "1") {
                $("#ojtAgreement1").prop("checked", true);
            } else {
                $("#ojtAgreement2").prop("checked", true);
            }

            if (data.feb == "1") {
                $("#feb1").prop("checked", true);
            } else {
                $("#feb2").prop("checked", true);
            }

            if (data.mar == "1") {
                $("#mar1").prop("checked", true);
            } else {
                $("#mar2").prop("checked", true);
            }

            if (data.apr == "1") {
                $("#apr1").prop("checked", true);
            } else {
                $("#apr2").prop("checked", true);
            }

            if (data.may == "1") {
                $("#may1").prop("checked", true);
            } else {
                $("#may2").prop("checked", true);
            }

            if (data.june == "1") {
                $("#june1").prop("checked", true);
            } else {
                $("#june2").prop("checked", true);
            }
        }
    </script>

</body>

</html>