<?php
date_default_timezone_set('Europe/Istanbul');

function base_url()
{
    return "http://localhost/sena/";
}

function base_title()
{
    return "SENA ALM";
}

function seo($text)
{
    $find = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#');
    $replace = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp');
    $text = strtolower(str_replace($find, $replace, $text));
    $text = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $text);
    $text = trim(preg_replace('/\s+/', ' ', $text));
    $text = str_replace(' ', '-', $text);

    return $text;
}

function durumSuccess($content)
{
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Başarılı!</strong> $content
        <button type='button' class='close' data-dismiss='alert' aria-label='close'>
            <span aria-hidden='true'>&times;</span>
        </button>
    </div>";
}

function durumDanger($content)
{
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Hata!</strong> $content
        <button type='button' class='close' data-dismiss='alert' aria-label='close'>
            <span aria-hidden='true'>&times;</span>
        </button>
    </div>";
}

function kelimeAyirma($metin, $sayi)
{

    $uzunluk = count(explode(' ', $metin));
    if ($uzunluk > $sayi) {
        return implode(' ', array_slice(explode(' ', $metin), 0, $sayi)) . " ...";
    } else {
        return $metin;
    }

}

function tarih($tarih)
{
    $tarih = date("d.m.Y", strtotime(explode(" ", $tarih)[0]));

    return $tarih;
}

function imageUpload($image, $path)
{

    $img_name = $_FILES[$image]['name'];
    $img_size = $_FILES[$image]['size'];
    $tmp_name = $_FILES[$image]['tmp_name'];
    $error = $_FILES[$image]['error'];
    if ($error == 0) {
        if ($img_size > 300000) {
            return "hataboyimage";

        } else {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);
            $allowed_exs = array("jpg", "jpeg", "png");

            if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = uniqid() . '.' . $img_ex_lc;
                $img_upload_path = "../../" . $path . "/" . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
                return $path . "/" . $new_img_name;

            } else {
                return "gecersizturimage";
            }
        }

    } else {
        return "hataimage";
    }
}

function pdfUpload($pdf, $path)
{

    $img_name = $_FILES[$pdf]['name'];
    $img_size = $_FILES[$pdf]['size'];
    $tmp_name = $_FILES[$pdf]['tmp_name'];
    $error = $_FILES[$pdf]['error'];
    if ($error == 0) {
        if ($img_size > 5000000) {
            return "hataboypdf";

        } else {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);
            $allowed_exs = array("pdf");

            if (in_array($img_ex_lc, $allowed_exs)) {
                $new_img_name = uniqid() . '.' . $img_ex_lc;
                $img_upload_path = "../../" . $path . "/" . $new_img_name;
                move_uploaded_file($tmp_name, $img_upload_path);
                return $path . "/" . $new_img_name;

            } else {
                return "gecersizturpdf";
            }
        }

    } else {
        return "hatapdf";
    }
}


function biyetToplamKilo($alasimId, $adetBiyet, $cap, $boy, $db)
{
    $ozkutle = alasimBul($alasimId, $db, 'ozkutle');
    $toplamKilo = sayiFormatla(($adetBiyet * $ozkutle * M_PI * $boy * (pow($cap, 2)) / 4) / 1000000, 3);
    return $toplamKilo;
}

function biyetToplamBoy($adetBiyet, $boy)
{
    return sayiFormatla($adetBiyet * $boy / 10, 2);
}

function mGrBul($kilo, $adet, $boy)
{
    return sayiFormatla((($kilo / $adet) / $boy) * 1000000, 3);
}

function toleransBul($mgr, $profilId, $db)
{
    $agirlik = profilbul($profilId, $db, 'gramaj');
    return sayiFormatla((($mgr - $agirlik) / $mgr) * 100, 2);

}

function sayiFormatla($sayi, $digit)
{
    return number_format((float)$sayi, $digit, '.', ',');
}

function vardiyaBul($vardiya, $saat){
    $now = $saat ? $saat :  date('H:i');
    if ($vardiya == 3) {
        if ($now >= date("H:i", strtotime("00:00")) && $now < date("H:i", strtotime("07:59")))
            return "3A";
        else if ($now >= date("H:i", strtotime("08:00")) && $now < date("H:i", strtotime("15:59")))
            return "3B";
        else
            return "3C";

    } else if ($vardiya == 2) {
        if ($now >= date("H:i", strtotime("08:00")) && $now < date("H:i", strtotime("17:59")))
            return "2A";
        else if ($now >= date("H:i", strtotime("20:00")) && $now < date("H:i", strtotime("23:59")) ||
            $now >= date("H:i", strtotime("00:00")) && $now < date("H:i", strtotime("05:59")))
            return "2B";

    } else if ($vardiya == 1) {
        return "1A";
    }
}

?>