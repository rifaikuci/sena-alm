<?php

include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);


$profilId = $_POST['profilId'];
$cap = $_POST['cap'];
$kalipCins = $_POST['kalipCins'];
$firmaId = $_POST['firmaId'];
$parca1 = $_POST['parca1SenaNo'];
$parca2 = $_POST['parca2SenaNo'];
$profil = $_POST['profil'];
$kisaKod = firmaBul($firmaId, $db, 'kisaKod');
$sonEk = firmaTakimNoBul($db, "tbltakim", $firmaId,$profilId);
$takimNo = "SN-" . $kisaKod . $profil . "-";
$sonEk = sprintf('%03d', $sonEk);
$takimNo = $takimNo . $sonEk;
$sql = "INSERT INTO tbltakim (parca1, parca2, takimNo, firmaId, profilId, cap, kalipCins)
                            VALUES ('$parca1', '$parca2','$takimNo', '$firmaId','$profilId', '$cap', '$kalipCins')";

if (mysqli_query($db, $sql)) {
    $updateParca = "UPDATE tblkalipparcalar set 
                    takimNo = '$takimNo' WHERE senaNo='$parca1' OR senaNo='$parca2' ";
    mysqli_query($db, $updateParca);
    header("Location:../../takim/?durumekle=ok");
    exit();
} else {
    header("Location:../../takim/?durumekle=no");
    exit();
}


?>