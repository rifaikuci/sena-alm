<?php

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

?>