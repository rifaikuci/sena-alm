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

function tarihsaat($tarih)
{
    $tarih = date_create($tarih);
    $tarih = date_format($tarih, "d.m.Y H:i");

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


function mGrBul($kilo, $adet, $boy)
{
    return sayiFormatla((($kilo / $adet) / $boy) * 1000000, 3);
}

function toleransBul($mgr, $profilId, $db)
{
    $agirlik = tablogetir('tblprofil', 'id', $profilId, $db)['gramaj'];
    return sayiFormatla((($mgr - $agirlik) / $mgr) * 100, 2);

}

function sayiFormatla($sayi, $digit= 2)
{
    return number_format($sayi, $digit, ',', '.');
}

function vardiyaBul($vardiya, $saat)
{
    $now = $saat ? $saat : date('H:i');
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

function takimDurumBul($konum)
{
    if ($konum == "P") {
        return "Pres";
    } else if ($konum == "R1") {
        return "Raf Dolu";
    } else if ($konum == "K1") {
        return "Kostik";
    } else if ($konum == "K2") {
        return "Kumlama";
    } else if ($konum == "K3") {
        return "Raf Boş";
    } else if ($konum == "T1") {
        return "Kostik";
    } else if ($konum == "T2") {
        return "Kumlama";
    } else if ($konum == "T3") {
        return "Tashihat - Sevk";
    } else if ($konum == "T4") {
        return "Sevkiyat Çıkış Yapıldı";
    } else if ($konum == "T5") {
        return "Sevkiyat Giriş Yapıldı";
    } else if ($konum == "T6") {
        return "Tashihat Yapıldı";
    } else if ($konum == "T7") {
        return "Raf Boş";
    } else if ($konum == "N1") {
        return "Kostik";
    } else if ($konum == "N2") {
        return "Kumlama";
    } else if ($konum == "N3") {
        return "Tenefer";
    } else if($konum == "N4"){
        return "Kumlama";
    } else if($konum == "N5") {
        return "Raf Boş";
    } else if($konum == "N6") {
        return "Raf Boş";
    }
}

function teneferBaskiSiraBul($type, $etKalinlik, $count) {
    //Type = 1-> Köprülü Type = 1 -> Solid

    if($type == 1){
        if($etKalinlik < 1 ) {
            if($count == 1 ) return  500;
            else if ($count == 2) return 1000;
            else if ($count == 3) return 1600;
            else if ($count == 4) return 2400;
            else return 4800;
        } else if ($etKalinlik >= 1 && $etKalinlik < 1.2) {
            if($count == 1 ) return  850;
            else if ($count == 2) return 2000;
            else if ($count == 3) return 2600;
            else if ($count == 4) return 4200;
            else return 8400;
        } else if ($etKalinlik >= 1.2 && $etKalinlik < 1.5) {
            if($count == 1 ) return  1400;
            else if ($count == 2) return 3000;
            else if ($count == 3) return 3500;
            else if ($count == 4) return 8400;
            else return 12700;
        } else if ($etKalinlik >= 1.5 && $etKalinlik < 1.8) {
            if($count == 1 ) return  1700;
            else if ($count == 2) return 3800;
            else if ($count == 3) return 4300;
            else if ($count == 4) return 9500;
            else return 14500;
        } else if ($etKalinlik >= 1.8 && $etKalinlik < 2.6) {
            if($count == 1 ) return  2100;
            else if ($count == 2) return 4500;
            else if ($count == 3) return 6500;
            else if ($count == 4) return 12000;
            else return 18000;
        } else if ($etKalinlik >= 2.6 && $etKalinlik < 3.5) {
            if($count == 1 ) return  2800;
            else if ($count == 2) return 7500;
            else if ($count == 3) return 10700;
            else if ($count == 4) return 18000;
            else return 24000;
        } else {
            if($count == 1 ) return  3500;
            else if ($count == 2) return 12000;
            else if ($count == 3) return 16000;
            else if ($count == 4) return 24000;
            else return 36000;
        }
    } else {
        if($etKalinlik < 1 ) {
            if($count == 1 ) return  700;
            else if ($count == 2) return 1300;
            else if ($count == 3) return 2000;
            else if ($count == 4) return 3000;
            else return 6000;
        } else if ($etKalinlik >= 1 && $etKalinlik < 1.2) {
            if($count == 1 ) return  1200;
            else if ($count == 2) return 2600;
            else if ($count == 3) return 3300;
            else if ($count == 4) return 5300;
            else return 10500;
        } else if ($etKalinlik >= 1.2 && $etKalinlik < 1.5) {
            if($count == 1 ) return  2000;
            else if ($count == 2) return 4000;
            else if ($count == 3) return 4500;
            else if ($count == 4) return 10600;
            else return 15800;
        } else if ($etKalinlik >= 1.5 && $etKalinlik < 1.8) {
            if($count == 1 ) return  2400;
            else if ($count == 2) return 5000;
            else if ($count == 3) return 5500;
            else if ($count == 4) return 12000;
            else return 18000;
        } else if ($etKalinlik >= 1.8 && $etKalinlik < 2.6) {
            if($count == 1 ) return  3000;
            else if ($count == 2) return 6000;
            else if ($count == 3) return 8200;
            else if ($count == 4) return 15000;
            else return 22500;
        } else if ($etKalinlik >= 2.6 && $etKalinlik < 3.5) {
            if($count == 1 ) return  4000;
            else if ($count == 2) return 10000;
            else if ($count == 3) return 13500;
            else if ($count == 4) return 22500;
            else return 30000;
        } else {
            if($count == 1 ) return  5000;
            else if ($count == 2) return 16000;
            else if ($count == 3) return 20000;
            else if ($count == 4) return 30000;
            else return 45000;
        }
    }

}

?>