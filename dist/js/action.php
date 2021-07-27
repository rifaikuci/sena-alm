<?php

include '../../netting/baglan.php';
include '../../include/helper.php';

$received_data = json_decode(file_get_contents("php://input"));
$data = array();


if($received_data->action == 'profilId')
{

    $sql = "SELECT * FROM tblprofil WHERE profilAdi = '$received_data->id'";

    $result = mysqli_query($db, $sql);
    $row = $result->fetch_assoc();

    foreach($result as $row)
    {
        $data['id'] = $row['id'];
        $data['resim'] = base_url() . $row['resim'];
    }

    echo json_encode($data);
}
?>