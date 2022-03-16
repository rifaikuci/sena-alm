<?php

include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';

if (isset($_POST['balyalamaekle'])) {

    $vardiya = tablogetir('tblayar', 'id', '1', $db)['vardiya'];
    $baslaVardiya = vardiyaBul($vardiya, date("H:i"));
    $baslaTarih = date("d.m.Y H:i");
    $operatorId = isset($_POST['operatorId']) ? $_POST['operatorId'] : 0;

    $baskiId = isset($_POST['baskiIds']) ? $_POST['baskiIds'] : 0;
    $netAdet = isset($_POST['netAdets']) ? $_POST['netAdets'] : 0;
    $netKilo = isset($_POST['netKilos']) ? $_POST['netKilos'] : 0;
    $mtGr = isset($_POST['mtGrs']) ? $_POST['mtGrs'] : 0;
    $paketDetay = isset($_POST['paketDetays']) ? $_POST['paketDetays'] : 0;
    $realTolerans = isset($_POST['realToleranss']) ? $_POST['realToleranss'] : 0;
    $teorikTolerans = isset($_POST['teorikToleranss']) ? $_POST['teorikToleranss'] : 0;
    $satirNo = isset($_POST['satirNos']) ? $_POST['satirNos'] : 0;
    $anbarId = isset($_POST['balyalamaIds']) ? $_POST['balyalamaIds'] : 0;
    $musteriId = isset($_POST['musteriId']) ? $_POST['musteriId'] : 0;
    $siparisNo = isset($_POST['siparisNos']) ? $_POST['siparisNos'] : 0;
    $balyaKilo = isset($_POST['toplamKilo']) ? $_POST['toplamKilo'] : 0;
    $balyaBoy = isset($_POST['balyaBoy']) ? $_POST['balyaBoy'] : 0;
    $rand = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
    $balyaNo = "SS-" . $rand;


    $sqlbalyalama = "INSERT INTO tblbalyalama (operatorId,baskiId, netAdet, netKilo, mtGr, paketDetay, realTolerans,
                          teorikTolerans, satirNo, siparisNo, balyaNo, balyaBoy, balyaKilo, musteriId) 
                        VALUES 
                    ( '$operatorId', '$baskiId','$netAdet', '$netKilo', '$mtGr', '$paketDetay', '$realTolerans',
                        '$teorikTolerans', '$satirNo', '$siparisNo', '$balyaNo', '$balyaBoy', '$balyaKilo', '$musteriId')";

    mysqli_query($db, $sqlbalyalama);
    $id = mysqli_insert_id($db);

    $netAdets = explode(";", $netAdet);
    $satirNos = explode(";", $satirNo);
    $baskiIds = explode(";", $baskiId);

    for ($i = 0; $i < count($netAdets); $i++) {
        $satir = $satirNos[$i];
        $temp = tablogetir("tblanbar", 'satirNo', $satir, $db);
        $tempKalanAdet = $temp['kalanAdet'] - $netAdets[$i];

        $sqlAnbar = "UPDATE tblanbar set
                    kalanAdet = '$tempKalanAdet'
                    where satirNo = '$satir'";

        mysqli_query($db, $sqlAnbar);

        $baski = tablogetir("tblbaski", 'id', $baskiIds[$i], $db);
        $balyalamaIds = $baski['balyalamaId'];
        $baskiId = $baski['id'];

        if ($balyalamaIds != '0' && $balyalamaIds != '-1') {
            $balyalamaIds = $balyalamaIds . ";" . $id;

            $sqlBaski2 = "UPDATE tblbaski set
                        balyalamaId = '$balyalamaIds'
                    where id = '$baskiId'";

        } else {

            $balyalamaIds = $id;
            $sqlBaski2 = "UPDATE tblbaski set
                        balyalamaId = '$balyalamaIds'
                    where id = '$baskiId'";
        }

        mysqli_query($db, $sqlBaski2);
    }

    if ($id > 0) {
        header("Location:../../balyalama/?durumekle=ok");
        exit();
    } else {
        header("Location:../../balyalama/?durumekle=no");
        exit();
    }


}

?>