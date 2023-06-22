<!DOCTYPE html>
<html lang="zxx">


<?php 

session_start();
include("assets/baglanti.php");
if (isset($_SESSION['email'])) {
    $_SESSION['isLoggedIn'] = true;
} else {
    $_SESSION['isLoggedIn'] = false;
}   
if (!isset($_SESSION['isLoggedIn']) || !$_SESSION['isLoggedIn']) {
    header('Location: index.php');
    exit;
}
if ($_SESSION['Onay'] !=2) {
    header("Location: index.php");
    exit();
}

// takimID değeri session'a aktarılıyor.
if (isset($_POST['oyuncuBul'])) {
    $_SESSION['takimID'] = $_POST['takimID'];
    $_SESSION['oyunID'] = $_POST['oyunID'];
    $_SESSION['takimAdi'] = $_POST['takimAdi'];
} elseif (!isset($_SESSION['takimID']) && !isset($_SESSION['oyunID'])) {
    header("Location: takimlarin.php");
    exit();
}

// sayfa değeri kontrol ediliyor
if (isset($_GET['sayfa'])) {
    $sayfa = $_GET['sayfa'];
} else {
    $sayfa = 1;
}

$kategoricek = $db2->prepare("SELECT * FROM kategoriler");
$kategoricek->execute();
$kategoriler = $kategoricek->fetchAll(PDO::FETCH_ASSOC);


$oyunID = $_SESSION['oyunID'];
if (!isset($_SESSION['min_age']) && !isset($_SESSION['max_age'])){
    $min_age =  0;
    $max_age =  150;
}
else{
    $min_age =  $_SESSION['min_age'];
    $max_age =  $_SESSION['max_age'];
}
if (!isset($_SESSION['min_siralama']) && !isset($_SESSION['max_siralama'])){
    $min_siralama =  0;
    $max_siralama =  1500000;
}
else{
    $min_siralama =  $_SESSION['min_siralama'];
    $max_siralama =  $_SESSION['max_siralama'];
}

if (!isset($_SESSION['takimDurum'])){
    $takimDurum =  2;
}
else{
    $takimDurum =  $_SESSION['takimDurum'];
}

if (!isset($_SESSION['yas_secimi'])) {
    $_SESSION['yas_secimi'] = 'tum_yaslar';  
}

if (isset($_POST['yas_secimi'])) {
    $_SESSION['yas_secimi'] = $_POST['yas_secimi'];
}

if (!isset($_SESSION['siralama'])) {
    $_SESSION['siralama'] = 'tum_siralama';  
}

if (isset($_POST['siralama'])) {
    $_SESSION['siralama'] = $_POST['siralama'];
}

if (!isset($_SESSION['takimDurumu'])) {
    $_SESSION['takimDurumu'] = 'takimVar';  
}

if (isset($_POST['takimDurumu'])) {
    $_SESSION['takimDurumu'] = $_POST['takimDurumu'];
}

// Toplam oyuncu sayısını say
$countSorgusu = $db->prepare("SELECT COUNT(*) as oyuncuSayisi FROM oyuncu o JOIN uye u ON o.uyeID = u.ID JOIN oyunrank r ON o.oyuncuRank = r.rankID JOIN oyunlar ol ON o.oyunID = ol.oyunID WHERE ol.oyunID = :oyunID  AND o.oyuncuTakimDurumu = :oyuncuTakimDurumu AND TIMESTAMPDIFF(YEAR, u.Dogumtarihi, CURDATE()) BETWEEN :min_age AND :max_age AND o.oyuncuSiralama BETWEEN :min_siralama AND :max_siralama ");
$countSorgusu->bindParam(':min_age', $min_age, PDO::PARAM_INT);
$countSorgusu->bindParam(':max_age', $max_age, PDO::PARAM_INT);
$countSorgusu->bindParam(':min_siralama', $min_siralama, PDO::PARAM_INT);
$countSorgusu->bindParam(':max_siralama', $max_siralama, PDO::PARAM_INT);
$countSorgusu->bindParam(':oyuncuTakimDurumu', $takimDurum, PDO::PARAM_INT);
$countSorgusu->bindParam(':oyunID', $oyunID, PDO::PARAM_INT);
$countSorgusu->execute();
$oyuncuSayisi = $countSorgusu->fetch(PDO::FETCH_ASSOC)['oyuncuSayisi'];

// Sayfa sayısını hesapla
$limit = 6;
$sayfa_sayisi = ceil($oyuncuSayisi / $limit);

// Hangi sayfa numarasındayız?
$sayfa = isset($_GET['sayfa']) ? (int)$_GET['sayfa'] : 1;
$sayfa = max(1, min($sayfa, $sayfa_sayisi));

// LIMIT ve OFFSET değerlerini hesapla
$offset = ($sayfa - 1) * $limit;

// Oyuncuları seç
//$oyuncuCek = $db->prepare("SELECT o.*, u.*, r.*, ol.oyunTag, ol.oyunIsmi FROM oyuncu o JOIN uye u ON o.uyeID = u.ID JOIN oyunrank r ON o.oyuncuRank = r.rankID JOIN oyunlar ol ON o.oyunID = ol.oyunID WHERE ol.oyunID = :oyunID AND TIMESTAMPDIFF(YEAR, u.Dogumtarihi, CURDATE()) BETWEEN :min_age AND :max_age LIMIT :limit OFFSET :offset");
$oyuncuCek = $db->prepare("SELECT o.*, u.*, r.*, ol.oyunTag, ol.oyunIsmi, t.takimAdi, t.takimID 
                          FROM oyuncu o 
                          JOIN uye u ON o.uyeID = u.ID 
                          JOIN oyunrank r ON o.oyuncuRank = r.rankID 
                          JOIN oyunlar ol ON o.oyunID = ol.oyunID 
                          JOIN takimlar t ON o.takimID = t.takimID 
                          WHERE ol.oyunID = :oyunID AND o.oyuncuTakimDurumu = :oyuncuTakimDurumu
                            AND TIMESTAMPDIFF(YEAR, u.Dogumtarihi, CURDATE()) BETWEEN :min_age AND :max_age 
                            AND o.oyuncuSiralama BETWEEN :min_siralama AND :max_siralama 
                          LIMIT :limit OFFSET :offset");
$oyuncuCek->bindParam(':min_age', $min_age, PDO::PARAM_INT);
$oyuncuCek->bindParam(':max_age', $max_age, PDO::PARAM_INT);
$oyuncuCek->bindParam(':min_siralama', $min_siralama, PDO::PARAM_INT);
$oyuncuCek->bindParam(':max_siralama', $max_siralama, PDO::PARAM_INT);
$oyuncuCek->bindParam(':oyuncuTakimDurumu', $takimDurum, PDO::PARAM_INT);
$oyuncuCek->bindParam(':oyunID', $oyunID, PDO::PARAM_INT);
$oyuncuCek->bindParam(':limit', $limit, PDO::PARAM_INT);
$oyuncuCek->bindParam(':offset', $offset, PDO::PARAM_INT);
$oyuncuCek->execute();
$oyuncular = $oyuncuCek->fetchAll(PDO::FETCH_ASSOC);


if (isset($_POST["filtrele"])) {
    $min_yas = isset($_POST['min_yas']) ? trim($_POST['min_yas']) : '';
    $max_yas = isset($_POST['max_yas']) ? trim($_POST['max_yas']) : '';
    $min_siralama = isset($_POST['min_siralama']) ? trim($_POST['min_siralama']) : '';
    $max_siralama = isset($_POST['max_siralama']) ? trim($_POST['max_siralama']) : '';
    $age_range = $_POST['yas_secimi'];
    $rank_range = $_POST['siralama'];
    $takimDurum = $_POST['takimDurumu'];
    //$oyuncuCek = $db->prepare("SELECT o.*, u.*, r.*, ol.oyunTag, ol.oyunIsmi FROM oyuncu o JOIN uye u ON o.uyeID = u.ID JOIN oyunrank r ON o.oyuncuRank = r.rankID JOIN oyunlar ol ON o.oyunID = ol.oyunID WHERE ol.oyunID = :oyunID AND TIMESTAMPDIFF(YEAR, u.Dogumtarihi, CURDATE()) BETWEEN :min_age AND :max_age LIMIT :limit OFFSET :offset");
    

        switch ($takimDurum) {
            case 'takimVar':
                $_SESSION['takimDurum'] = 2;
                break;
            case 'takimYok':
                $_SESSION['takimDurum'] = 0;
                break;
        }
 



    if (!empty($min_yas) && !empty($max_yas)) {
        $_SESSION['min_age'] = (int)$min_yas;
        $_SESSION['max_age'] = (int)$max_yas;
 
    }
    else {
        if ($age_range != 'tum_yaslar') {
            switch ($age_range) {
                case '13_15':

                    $_SESSION['min_age'] = 13;
                    $_SESSION['max_age'] = 15;
                    break;
                case '16_19':

                    $_SESSION['min_age'] = 16;
                    $_SESSION['max_age'] = 19;
                    break;
                case '20_23':

                    $_SESSION['min_age'] = 20;
                    $_SESSION['max_age'] = 23;
                    break;
                case '24':

                    $_SESSION['min_age'] = 24;
                    $_SESSION['max_age'] = 120;
                    break;
            }
        }
        else if ($age_range == 'tum_yaslar') {
            $_SESSION['min_age'] = 0;
            $_SESSION['max_age']  = 150;
        }

    }


    if (!empty($min_siralama) && !empty($max_siralama)) {
        $_SESSION['min_siralama'] = (int)$min_siralama;
        $_SESSION['max_siralama'] = (int)$max_siralama;
 
    }
    else {
        if ($rank_range != 'tum_siralama') {
            switch ($rank_range) {
                case '0_500':

                    $_SESSION['min_siralama'] = 0;
                    $_SESSION['max_siralama'] = 500;
                    break;
                case '501_1500':

                    $_SESSION['min_siralama'] = 501;
                    $_SESSION['max_siralama'] = 1500;
                    break;
                case '1501_3500':

                    $_SESSION['min_siralama'] = 1501;
                    $_SESSION['max_siralama'] = 3500;
                    break;
                case '3501_7000':

                    $_SESSION['min_siralama'] = 3501;
                    $_SESSION['max_siralama'] = 7000;
                    break;
                case '7001_15000':

                    $_SESSION['min_siralama'] = 7001;
                    $_SESSION['max_siralama'] = 15000;
                    break;
                case '15000+':

                    $_SESSION['min_siralama'] = 15000;
                    $_SESSION['max_siralama'] = 1500000;
                    break;
            }
        }
        else if ($rank_range == 'tum_siralama') {
            $_SESSION['min_siralama'] = 0;
            $_SESSION['max_siralama']  = 1500000;
        }

    }
   header("Location: oyuncubul.php");
    exit();

}

if (isset($_POST["sifirla"])) {
    $min_siralama =  0;
    $max_siralama =  1500000;
    $min_age =  0;
    $max_age =  150;
    $takimDurum =  2;
    $_SESSION['min_age'] = 0;
    $_SESSION['max_age'] = 150;
    $_SESSION['min_siralama'] = 0;
    $_SESSION['max_siralama'] = 1500000;
    $_SESSION['takimDurum'] = 2;
    header("Location: oyuncubul.php");
    exit();
}

?>
<head>
    <title>Oyuncu Bul | ScoutGG</title>
    <!-- /SEO Ultimate -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <meta charset="utf-8">
    <link rel="apple-touch-icon" sizes="57x57" href="./assets/images/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="./assets/images/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="./assets/images/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/images/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="./assets/images/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="./assets/images/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="./assets/images/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="./assets/images/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/images/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="./assets/images/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="./assets/images/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="./assets/images/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Latest compiled and minified CSS -->
    <link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/js/bootstrap.min.js">
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- StyleSheet link CSS -->
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/special_classes.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/mediaqueries.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/owl.carousel.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/css/owl.theme.default.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css"/>
    <style>
        tr {
            background-color: #f2f2f2;
        }
         .pagination a {
            color: #444;
            text-decoration: none;
            display: inline-block;
            padding: 6px 12px;
            border-radius: 2px;
            border: 1px solid #ddd;
            margin-right: 5px;
            font-size: 14px;
            background: gray;
        }

        .pagination a:hover {
            background: #f5f5f5;
        }

        .pagination .active {
            background: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        .pagination .prev, .pagination .next {
            background: #f5f5f5;
            border-color: #ddd;
            font-size: 18px;
            padding: 4px 10px;
            border-radius: 4px;
            line-height: 1.4;
        }

        .pagination .prev:hover, .pagination .next:hover {
            background: #ddd;
            color: #444;
        }


        .sidebar {
            background-color: #f7f7f7;
            padding: 20px;
            margin-top: 20px;
            border-radius: 10px;
            }

            .sidebar h3 {
            font-size: 18px;
            font-weight: bold;
            margin-top: 0;
            color:black;
            }

            .sidebar hr {
            border-top: 2px solid #ddd;
            margin: 10px 0;
            }

            .sidebar .form-check {
            margin-bottom: 10px;
            }

            .sidebar .form-check-label {
            margin-left: 5px;
            font-size: 16px;
            }

            .sidebar .form-group {
            margin-bottom: 10px;
            }

            .sidebar label {
            font-size: 16px;
            font-weight: bold;
            }

            .sidebar input[type="number"] {
            width: 100%;
            padding: 6px 12px;
            font-size: 16px;
            line-height: 1.5;
            color: #555;
            background-color: #fff;
            background-image: none;
            border: 1px solid #ccc;
            border-radius: 4px;
            -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
            }

            .sidebar button[type="submit"] {
            width: 100%;
            border-color: #007bff;
            color: #fff;
            padding: 6px 12px;
            font-size: 16px;
            font-weight: bold;
            line-height: 1.5;
            border-radius: .25rem;
            -webkit-transition: all .15s ease-in-out;
            transition: all .15s ease-in-out;
            }

    </style>

    </head>
<body>
<div class="banner-section-outer">
<?php include("assets/header.php"); ?>


    <div class = "container col-md-12 d-flex justify-content-center" style="height: 100em; background-size: cover; background-position: center; padding: 20px; ">

        <div  class = "container gallery_images_section">
            <div class = "row">
                <div class = "col-md-12">
                    <h4 style="color: white;  "><?php echo $_SESSION['takimAdi']; ?>'ın için uygun oyuncuları bul. </h4>
                    <label style="color: white; font-weight: bold;"><a href = "takimlarin.php">Takımlara geri dönmek için tıkla. </a> </label>
                </div>
                <div class = "col-md-3">
                    <div class="sidebar">
                        <div class="form-check">
                            <?php 
                            if($takimDurum == 2){
                               $takimDurumu = "Takım Var";     
                            }
                            else if($takimDurum == 0){
                                $takimDurumu = "Takım Yok";     
                             }
                            ?>
                            <label class="form-check-label"><?php echo 'Şuan görüntülenen yaş aralığınız = [' . $min_age . ' - ' . $max_age . ']'  ; ?></label><br/><br/>
                            <label class="form-check-label"><?php echo 'Şuan görüntülenen sıralama aralığınız = [' . $min_siralama . ' - ' . $max_siralama . ']'  ; ?></label><br/><br/>
                            <label class="form-check-label"><?php echo 'Şuan görüntülenen Takım Durumu = [' . $takimDurumu . ']'  ; ?></label>
                        </div>
                        <form action="" method="post">
                            <h3>Takım Durumu</h3>
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="takimDurumu" id="takimVar" value="takimVar" <?php echo ($_SESSION['takimDurumu'] == 'takimVar' ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="takimVar">Takımı Var</label>
                            </div>
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="takimDurumu" id="takimYok" value="takimYok" <?php echo ($_SESSION['takimDurumu'] == 'takimYok' ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="takimYok">Takımı Yok</label>
                            </div>
                            <hr>
                            <h3>Yaş Seçimi</h3>
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="yas_secimi" id="tum_yaslar" value="tum_yaslar" <?php echo ($_SESSION['yas_secimi'] == 'tum_yaslar' ? 'checked' : '');?>>
                            <label class="form-check-label" for="tum_yaslar">Tüm Yaşlar</label>
                            </div>
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="yas_secimi" id="yas_13_15" value="13_15" <?php echo ($_SESSION['yas_secimi'] == '13_15' ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="yas_13_15">13-15 Yaş</label>
                            </div>
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="yas_secimi" id="yas_16_19" value="16_19" <?php echo ($_SESSION['yas_secimi'] == '16_19' ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="yas_16_19">16-19 Yaş</label>
                            </div>
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="yas_secimi" id="yas_20_23" value="20_23" <?php echo ($_SESSION['yas_secimi'] == '20_23' ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="yas_20_23">20-23 Yaş</label>
                            </div>
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="yas_secimi" id="yas_24" value="24" <?php echo ($_SESSION['yas_secimi'] == '24' ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="yas_24">24+ Yaş</label>
                            </div>
                            <br>
                            <hr>
                            <h3>Yaş Aralığı</h3>
                            <div class="form-group">
                            <label for="min_yas">Minimum Yaş:</label>
                            <input type="number" class="form-control"  min="13" max="120" id="min_yas" name="min_yas">
                            </div>
                            <div class="form-group">
                            <label for="max_yas">Maksimum Yaş:</label>
                            <input type="number" class="form-control"  min="14" max="121" id="max_yas" name="max_yas">
                            </div>
                            <br>
                            <hr>
                            <h3>Sıralama</h3>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="rank_all" name="siralama" value="tum_siralama" <?php echo ($_SESSION['siralama'] == 'tum_siralama' ? 'checked' : '');?>>
                                <label class="form-check-label" for="rank_all">Tüm Sıralamalar</label><br>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="rank_0_500" name="siralama" value="0_500" <?php echo ($_SESSION['siralama'] == '0_500' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="rank_0_500">0-500 Sıralama</label><br>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="rank_501_1500" name="siralama" value="501_1500" <?php echo ($_SESSION['siralama'] == '501_1500' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="rank_501_1500">501-1500 Sıralama</label><br>
                            </div>
                                <div class="form-check">
                                <input class="form-check-input" type="radio" id="rank_1501_3500" name="siralama" value="1501_3500" <?php echo ($_SESSION['siralama'] == '1501_3500' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="rank_1501_3500">1501-3500 Sıralama</label><br>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="rank_3501_7000" name="siralama" value="3501_7000" <?php echo ($_SESSION['siralama'] == '3501_7000' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="rank_3501_7000">3501-7000 Sıralama</label><br>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="rank_7001_15000" name="siralama" value="7001_15000" <?php echo ($_SESSION['siralama'] == '7001_15000' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="rank_7001_15000">7001-15000 Sıralama</label><br>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="rank_15000_plus" name="siralama" value="15000+" <?php echo ($_SESSION['siralama'] == '15000+' ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="rank_15000_plus">15000+ Sıralama</label><br><br>
                            </div>
                            <div class="form-group">
                                <label for="min_yas">Minimum Sıralama:</label>
                                <input type="number" class="form-control"  min="1" max="20000" id="min_siralama" name="min_siralama">
                            </div>
                            <div class="form-group">
                                <label for="max_yas">Maksimum Sıralama:</label>
                                <input type="number" class="form-control"  min="2" max="20001" id="max_siralama" name="max_siralama">
                            </div>
                            <div class="form-group">
                                <button type="submit" name = "filtrele" class="btn btn-primary">Filtrele</button>
                            </div>
                            <div class="form-group">
                                <button type="submit" name = "sifirla" class="btn btn-danger">Sıfırla</button>
                            </div>
                        </form>
                    </div>
                </div>
                    
                <div class="col-md-8" >
                    <div class="container">
                        <div class="row">
                            <?php foreach ($oyuncular as $oyuncu):  
                                 $dgTarihi = new DateTime($oyuncu['Dogumtarihi']); //DateTime sınıfına dönüştürüyoruz
                                 $bugun = new DateTime(); //bugünün tarihi
                                 $fark = $bugun->diff($dgTarihi); // iki tarih arasındaki farkı hesapla
                                 $yas = $fark->y; // fark yıl ay gün değerlerini tuttuğu için sadece y ile yıl bilgisini getir 
                                 $takimAdi = $oyuncu['takimAdi'] ? $oyuncu['takimAdi'] : 'yok';
                            ?>
                                
                                <div class = "col-md-4 m-0 p-1">
                                    <div class="card  mt-4  col-md-12 bg-secondary text-white">
                                    <div class="card-header" >
                                        <strong><?php  echo $oyuncu['KullaniciAdi']; ?></strong>
                                    </div>
                                    <div class = "d-flex justify-content-center mt-2">
                                    <a href = "oyuncu-profil.php?oyuncuID=<?php echo $oyuncu['oyuncuID']; ?>"> <img style = "border-radius:2em; width: 8em; height: 8em;" class="card-img-top" src="assets/images/profil/<?= $oyuncu['ProfilResmi'] ?>" alt="<?= $oyuncu['oyuncuKullaniciAdi'] ?> resmi"></a>
                                    </div>
                                    <div class="card-body">
                                    <a style = "color:purple;" href = "oyuncu-profil.php?oyuncuID=<?php echo $oyuncu['oyuncuID']; ?>"><h5 class="card-title" style = "color:purple; font-size:2em;"><?php echo $oyuncu['oyuncuKullaniciAdi']; ?></h5></a>
                                        <p class="card-text">Etiket: <?php echo $oyuncu['oyuncuEtiketi']; ?></p>
                                        <p class="card-text">Oyun: <?php echo $oyuncu['oyunTag'];?></p>
                                        <p class="card-text" >Takımı: <a style = "color:purple;" href = "takim-profil.php?takimID=<?php echo $oyuncu['takimID']; ?>"><?php echo $takimAdi; ?></a></p>
                                        <p class="card-text">Rank: <?php echo $oyuncu['rankAd']; ?></p>
                                        <p class="card-text">Yaş: <?php echo $yas; ?></p>
                                        <p class="card-text">Sıralama: <?php echo $oyuncu['oyuncuSiralama']; ?></p>
                                        <form action="mesaj_gonder.php" method="post">
                                            <input type="hidden" name="alici" value="<?php echo $oyuncu['KullaniciAdi']; ?>">
                                            <input type="hidden" name="takimAdi" value="<?php echo $_SESSION['takimAdi']; ?>">
                                            <input type="hidden" name="oyuncuID" value="<?php echo $oyuncu['oyuncuID']; ?>">
                                            <input type="hidden" name="aliciID" value="<?php echo $oyuncu['ID']; ?>">
                                            <input type="hidden" name="takimID" value="<?php echo $_SESSION['takimID']; ?>">
                                            <input type="hidden" name="gorusmeTuru" value="1">
                                            <input type="hidden" name="konu" value="Seni [<?php echo $_SESSION['takimAdi'] ; ?>] Takımıma Davet Ediyorum.">
                                            <button type="submit" name  = "mesajGonderSayfasi" class="btn btn-warning">İstek Gönder</button>
                                         </form>
                                    </div>
                                    </div>
                            </div>
                            <?php endforeach; ?>
                            
                        </div>
                    </div>
                    <div class="pagination">
                    <?php if ($sayfa > 1): ?>
                        <a href="?sayfa=<?php echo $sayfa - 1; ?>" class="prev">&laquo;</a>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $sayfa_sayisi; $i++): ?>
                        <?php if ($i == $sayfa): ?>
                            <a href="#" class="active"><?php echo $i; ?></a>
                        <?php else: ?>
                            <a href="?sayfa=<?php echo $i; ?>"><?php echo $i; ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    
                    <?php if ($sayfa < $sayfa_sayisi): ?>
                        <a href="?sayfa=<?php echo $sayfa + 1; ?>" class="next">&raquo;</a>
                    <?php endif;  ?>
                </div>
                
                </div>
            </div>
        </div>
    </div>
       
 
<!--<div class="footer-section">
    <div class="container">
        <div class="middle-portion">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <ul class="links mb-0 list-unstyled">
                        <li><a href="./index.php">Anasayfa</a></li>
                        <li><a href="./about.php">Hakkımızda</a></li>
                        <li><a href="./kesfet.php">Keşfet</a></li>
                        <li><a href="./games.php">Yetenek Keşfi</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <ul class="mb-2 list-unstyled">
                        <li><a href="./index.php"><figure class="mb-0"><img src="./assets/images/footer_logo.png" alt=""></figure></a></li>
                    </ul>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <ul class="mb-0 list-unstyled neg_margin">
                        <li class="links"><a href="./profile.php">Profil</a></li>
                        <li class="links"><a href="./contact.php">İletişin</a></li>
                        <li class="icons"><a href="#"><i class="fa-brands fa-facebook-f" aria-hidden="true"></i></a></li>
                        <li class="icons"><a href="#"><i class="fa-brands fa-twitter" aria-hidden="true"></i></a></li>
                        <li class="icons"><a href="#"><i class="fa-brands fa-linkedin-in" aria-hidden="true"></i></a></li>
                        <li class="icons"><a href="#"><i class="fa-brands fa-instagram" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-portion">
        <div class="copyright col-xl-12"> 
            <p>Copyright 2021, Crox Esports. All Rights Reserved.</p>
        </div>
    </div>
</div>-->



</body>
</html>