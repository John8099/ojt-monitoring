<?php
// Local
$host = "localhost";
$user = "root";
$password = "";
$db = "ojt_monitoring";

// Hosting Epizy
// $host = "sql201.epizy.com";
// $user = "epiz_29772179";
// $password = "c2mpPg2ZLXd";
// $db = "epiz_29772179_ojt_monitoring";

//Hosting 000webhost
// $host = "localhost";
// $user = "id17613430_lykamayguinabo";
// $password = "&/)e4o>|wL%1s|yq";
// $db = "id17613430_ojtmonitoring";


$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function dateDiff($start, $end)
{
    $date1 = strtotime($start);
    $date2 = strtotime($end);

    $diff = abs($date2 - $date1);


    $years = floor($diff / (365 * 60 * 60 * 24));


    $months = floor(($diff - $years * 365 * 60 * 60 * 24)
        / (30 * 60 * 60 * 24));


    $days = floor(($diff - $years * 365 * 60 * 60 * 24 -
        $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));


    $hours = floor(($diff - $years * 365 * 60 * 60 * 24
        - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24)
        / (60 * 60));


    $minutes = floor(($diff - $years * 365 * 60 * 60 * 24
        - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
        - $hours * 60 * 60) / 60);


    $seconds = floor(($diff - $years * 365 * 60 * 60 * 24
        - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
        - $hours * 60 * 60 - $minutes * 60));

    return (array(
        "year" => $years,
        "months" => $months,
        "days" => $days,
        "hours" => $hours,
        "minutes" => $minutes,
        "seconds" => $seconds
    ));
}

function getDiff($dateTime)
{
    $diff = abs($dateTime);
    $years = floor($diff / (365 * 60 * 60 * 24));


    $months = floor(($diff - $years * 365 * 60 * 60 * 24)
        / (30 * 60 * 60 * 24));


    $days = floor(($diff - $years * 365 * 60 * 60 * 24 -
        $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));


    $hours = floor(($diff - $years * 365 * 60 * 60 * 24
        - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24)
        / (60 * 60));


    $minutes = floor(($diff - $years * 365 * 60 * 60 * 24
        - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
        - $hours * 60 * 60) / 60);


    $seconds = floor(($diff - $years * 365 * 60 * 60 * 24
        - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
        - $hours * 60 * 60 - $minutes * 60));

    return (array(
        "year" => $years,
        "months" => $months,
        "days" => $days,
        "hours" => $hours,
        "minutes" => $minutes,
        "seconds" => $seconds
    ));
}

function getIcon($stat, $id)
{
    if ($stat == 1) {
        return '<i class="fa fa-check-square" id="' . $id . '" style="color: green; font-size: 50px"></i>';
    } else {
        return '<i class="fa fa-times" id="' . $id . '"  style="color: red; font-size: 50px"></i>';
    }
}

function generateUniqueId()
{
    date_default_timezone_set("Asia/Manila");
    return date("mdY-his");
}