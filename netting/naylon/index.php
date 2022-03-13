<?php
include '../baglan.php';
include '../../include/helper.php';
include '../../include/sql.php';
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Istanbul');

if (isset($_POST['naylonbaslat'])) {

   $operatorId = isset($_POST['operatorId']) && $_POST['operatorId'] ? $_POST['operatorId'] : 0;
   $kullanilan1 = $_POST['naylon1Adet'] ? $_POST['naylon1Adet'] : 0;
   $kullanilan2 = $_POST['naylon2Adet'] ? $_POST['naylon2Adet'] : 0;
   $naylonId1 = $_POST['naylonId1'] ? $_POST['naylonId1'] : 0;
   $naylonId2 = $_POST['naylonId2'] ? $_POST['naylonId2'] : 0;
   $vardiya = tablogetir('tblayar', 'id', '1', $db)['vardiya'];
   $vardiya = vardiyaBul($vardiya, date("H:i"));
   $zaman = date("d.m.Y H:i");
   $item= $_POST['item'];
   $item = explode(";",$item);
   $baskiId = $item[0];
   $netAdet = $item[1];
   $tur = $item[3];
   $id = $item[4];

    $sql = "";
    if($tur == "B") {
        $sql = "UPDATE tblboyapaket set
                        isNaylon = '1'
                    where id = '$id'";

    } else {
        $sql = "UPDATE tblpaket set
                        isNaylon = '1'
                    where id = '$id'";
    }

    mysqli_query($db, $sql);

    if ($kullanilan1 > 0) {
        $naylonKalan1 = tablogetir('tblstokmalzeme', 'id', $naylonId1, $db)['kalan'];
        $kalan1 = $naylonKalan1 - $kullanilan1;

        $sqlstokmalzeme1 = "UPDATE tblstokmalzeme set
                        kalan = '$kalan1'
                    where id = '$naylonId1'";
        mysqli_query($db, $sqlstokmalzeme1);
    }

    if ($kullanilan2 > 0) {
        $naylonKalan2 = tablogetir('tblstokmalzeme', 'id', $naylonId2, $db)['kalan'];
        $kalan2 = $naylonKalan2 - $kullanilan2;

        $sqlstokmalzeme2 = "UPDATE tblstokmalzeme set
                        kalan = '$kalan2'
                    where id = '$naylonId2'";
        mysqli_query($db, $sqlstokmalzeme2);
    }


    $sqlnaylon = "INSERT INTO tblnaylon  (
                    baskiId,
                    naylonId1,
                    naylonId2,
                    kullanilan1,
                    kullanilan2,
                    operatorId,
                    adet,
                    zaman,
                    vardiya  )
                   VALUES  (
                        '$baskiId',
                        '$naylonId1',
                        '$naylonId2',
                        '$kullanilan1',
                        '$kullanilan2',
                        '$operatorId',
                        '$netAdet',
                        '$zaman',
                        '$vardiya' )";

    mysqli_query($db, $sqlnaylon);


    $id = mysqli_insert_id($db);
    $baski = tablogetir("tblbaski", 'id', $baskiId, $db);
    $naylonIds = $baski['naylonId'];

    if ($naylonIds != '0' && $naylonIds != '-1') {
        $naylonIds = $naylonIds . ";" . $id;
        $sqlBaski = "UPDATE tblbaski set
                        naylonId = '$naylonIds'
                    where id = '$baskiId'";
    } else {
        $naylonIds = $id;
        $sqlBaski = "UPDATE tblbaski set
                        naylonId = '$naylonIds'
                    where id = '$baskiId'";
    }


    $satirNo = $baski['satirNo'];

    $anbar = tablogetir("tblanbar", 'satirNo', $satirNo, $db);
        $anbar = $anbar ? $anbar : 0;

        if($anbar != 0) {
            $adet = $netAdet + $anbar['adet'];
            $kalanAdet = $netAdet + $anbar['kalanAdet'];

            $sqlAnbar = "UPDATE tblanbar set
                        kalanAdet = '$kalanAdet',
                        adet = '$adet'
                    where satirNo = '$satirNo'";
        }
        else {

            $sqlAnbar = "INSERT INTO tblanbar  (
                        baskiId,
                        satirNo,
                        adet,
                        kalanAdet)
                   VALUES  (
                        '$baskiId',
                        '$satirNo',
                        '$netAdet',
                        '$netAdet'
    
                   )";
        }

    mysqli_query($db, $sqlAnbar);
    $id = mysqli_insert_id($db);

    $baski = tablogetir("tblbaski", 'id', $baskiId, $db);
    $anbarIds = $baski['anbarId'];

    if ($anbarIds != '0' && $anbarIds != '-1') {
        $anbarIds = $anbarIds . ";" . $id;

        $sqlBaski2 = "UPDATE tblbaski set
                        anbarId = '$anbarIds'
                    where id = '$baskiId'";

    } else {

        $anbarIds = $id;

        $sqlBaski2 = "UPDATE tblbaski set
                        anbarId = '$anbarIds'
                    where id = '$baskiId'";
    }

    mysqli_query($db, $sqlBaski2);


    if (mysqli_query($db, $sqlBaski)) {
        header("Location:../../naylon/?durumekle=ok");
        exit();
    } else {
        header("Location:../../naylon/?durumekle=no");
        exit();
    }

}

if (isset($_GET['naylonsil'])) {

    $id = $_GET['naylonsil'];

    $naylon = tablogetir("tblnaylon", 'id', $id, $db);
    $satirNo = $naylon['satirNo'];
    $adet = $naylon['hurdaAdet'];
    $aciklama = $naylon['hurdaSebep'];
    $rutusAdet = $naylon['rutusAdet'];
    $rutusSebep = $naylon['rutusSebep'];
    $operatorId = $naylon['operatorId'];
    $boyaId = $naylon['boyaId'];
    $geciciAdet = -1 * $adet;

    /*
    $sqlprofil = "DELETE FROM tblstokprofil where toplamAdet = '$geciciAdet' AND gelisAmaci = 'naylon' AND siparis = '$satirNo'  ";
    mysqli_query($db, $sqlprofil);

    $sqlHurda = "DELETE FROM tblhurda where adet = '$adet' AND aciklama = '$aciklama'
                       AND  geldigiYer = 'naylon' AND operatorId = '$operatorId'  ";
    mysqli_query($db, $sqlHurda);


    $sqlRutus = "DELETE FROM tblrutusprofil where adet = '$rutusAdet' AND sebep = '$rutusSebep' ";
    mysqli_query($db, $sqlRutus);
*/
    $sqlboya = "UPDATE tblboya set
                     isPaket = '0'
                    where id = '$boyaId'";
    mysqli_query($db, $sqlboya);


    $sqlnaylon = "DELETE FROM tblnaylon where id = '$id' ";

    if (mysqli_query($db, $sqlnaylon)) {
        header("Location:../../naylon/?durumsil=ok");
        exit();
    } else {
        header("Location:../../naylon/?durumsil=no");
        exit();
    }

}