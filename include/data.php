<?php

$vardiyalar = [1,2,3];

$takimSonDurum = ["R1"=> "Raf", "P" => "Pres", "K1" => "Kostik", "T1"=>"Tashihat"];
$takimDurumlar = ["R1"=> "Raf Dolu",
    "P" => "Pres",
    "R1" => "Raf Dolu",
    "K1" => "Kostik",
    'K2'=>"Kumlama",
    "K3"=> "Raf Boş",
    "T1"=>"Kostik",
   "T2" =>"Kumlama",
    "T3" => " Tashihat Çıkış-Sevk",
    "T4" =>"Çıkış -> Giriş",
    "T5" => "Yapıldı",
    "T6"=>"Tashihat Yapıldı",
    "N1"=>"Kostik",
    "N2"=>"Kumlama",
    "N3"=>"Tenefer",
    "N4"=>"Kumlama",
    "N5"=>"Raf Boş",
    "N6"=>"Raf Boş",
    ];

$baskiBitirilmeNeden = ["Kalıp Kırıldı", "Kalıp Dinlenme", "Kalıp Boy Farkı"];

$askilar = [10,20,30];

$firinSicaklik = [180, 200];

$altSebep = ["Vakit Yetmedi", "Statik Almadı" , "Askılar Değdi" ];

$hurdaSebep = ["Ezik Var", "Boy Kurtarmadı", "Delik Var"];

$rutusSebep = ["R1", "R2", "R3"];

$kaliteler = ["2344", "2716", "Dievar"];

$caplar = [127];

$boyaCins = ["Mat", "Parlak", "Yarı Mat"];

$profilTur = ["Ham", "Boyalı", "Eloksal"];

$gelisTur = ["Boya", "Kesim", "Termik", "Paketleme"];

$termikDurum = ["Termiksiz", "Yarı Termikli", "Termikli"];

$konumlar = ["Baskı", "Kesim", "Termik"];

$birimler = ["Kg", "Lt", "Adet"];

$kullanildigiAlanlar = ["Kalıphane", "Boyahane", "Kromat"];


// tbl stok proilf de sipariş-> üretimden gelen satırnoya denk gelmekte siparisNo ise sevkiyattan gelirken ki geldiği yer
// sepetler artık kesimId ile değil baskiId ile dolacak
// tblsepet tablosunda bulunan durum eğer 0 ise sepet müsait 1 ise termiği devam ediyor 2 ise termiği bitmiş

// geldigi yer gelis amacı gibi yerler kucuk harflerle yazılacak türkçe karakter kullanılmnayacak
?>