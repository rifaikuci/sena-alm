<?php
include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Istanbul');

$received_data = json_decode(file_get_contents("php://input"));
$data = array();


if (isset($_POST['takimId']) && isset($_POST['oldProcess']) && isset($_POST['newProcess'])) {
    $oldProcess = $_POST['oldProcess'];
    $takimId = $_POST['takimId'];
    $newProcess = $_POST['newProcess'];
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $operatorId = isset($_POST['operatorId']) ? $_POST['operatorId'] : '';
    $kostikHavuzId = 0;
    $kumlamaHavuzId = 0;
    $teneferHavuzId = 0;

    if ($oldProcess == "K1" || $oldProcess == "T1") {
        $kostikHavuzId = tablogetir("tblhavuz", "tur", "kostik", $db)['logHavuzId'];
    } else if ($oldProcess == "T1" || $oldProcess == "T2") {
        $kumlamaHavuzId = tablogetir("tblhavuz", "tur", "kum", $db)['logHavuzId'];

    }


    $sqlTakim = "UPDATE tbltakim SET konum = '$newProcess' WHERE id = $takimId";
    mysqli_query($db, $sqlTakim);

    $sql = "INSERT INTO tblkaliphane (takimId, oldProcess, newProcess, description, operatorId, kumlamaHavuzId, kostikHavuzId, teneferHavuzId) 
VALUES ('$takimId', '$oldProcess', '$newProcess', '$description', '$operatorId', '$kumlamaHavuzId', '$kostikHavuzId', '$teneferHavuzId')";


    echo json_encode(mysqli_query($db, $sql));

}


?>