<?php
// $listOfFiles = listOfFilesUploadedInDb();

function folderFiles($dir, $arrFilesInDb)
{
    $folder = scandir($dir);

    unset($folder[array_search('.', $folder, true)]);
    unset($folder[array_search('..', $folder, true)]);

    if (count($folder) < 1)
        return;

    foreach ($folder as $ff) {
        if (is_dir($dir . '/' . $ff)) {
            folderFiles($dir . '/' . $ff, $arrFilesInDb);
        }
        if (!in_array($ff, $arrFilesInDb) && !is_dir($dir . '/' . $ff)) {
            unlink(__DIR__ . "/" . $dir . "/" . $ff);
        }
    }
    return "true";
}

function listOfFilesUploadedInDb($conn)
{
    include_once("actions/conn.php");
    $listOfFiles = [];
    $gen_reports_q = mysqli_query($conn, "SELECT * FROM gen_reports");
    while ($a = mysqli_fetch_object($gen_reports_q)) {
        $exploded = explode("/", $a->report_file);
        array_push($listOfFiles, $exploded[count($exploded) - 1]);
    }
    $reports_q = mysqli_query($conn, "SELECT * FROM reports");
    while ($b = mysqli_fetch_object($reports_q)) {
        $exploded = explode("/", $b->report_file_name);
        array_push($listOfFiles, $exploded[count($exploded) - 1]);
    }
    return $listOfFiles;
}

// echo "
// <script>
// console.log('" . $result . "')
// </script>
// ";
