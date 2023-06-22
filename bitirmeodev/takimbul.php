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
if (isset($_POST['takimBul'])) {
    $_SESSION['oyuncuKullaniciAdi'] = $_POST['oyuncuKullaniciAdi'];
    $_SESSION['oyuncuID'] = $_POST['oyuncuID'];
    $_SESSION['oyunID'] = $_POST['oyunID'];
    $_SESSION['oyunTag'] = $_POST['oyunTag'];
} else if (!isset($_SESSION['takimID']) && !isset($_SESSION['oyunID'])) {
    header("Location: oyunlarin.php");
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





// Toplam oyuncu sayısını say
$countSorgusu = $db->prepare("SELECT COUNT(*) as takimSayisi FROM takimlar t JOIN  takimlideri l ON t.takimID = l.takimID JOIN uye u ON l.uyeID = u.ID  WHERE oyunID = :oyunID ");
$countSorgusu->bindParam(':oyunID', $oyunID, PDO::PARAM_INT);
$countSorgusu->execute();
$takimSayisi = $countSorgusu->fetch(PDO::FETCH_ASSOC)['takimSayisi'];

// Sayfa sayısını hesapla
$limit = 6;
$sayfa_sayisi = ceil($takimSayisi / $limit);

// Hangi sayfa numarasındayız?
$sayfa = isset($_GET['sayfa']) ? (int)$_GET['sayfa'] : 1;
$sayfa = max(1, min($sayfa, $sayfa_sayisi));

// LIMIT ve OFFSET değerlerini hesapla 
$offset = ($sayfa - 1) * $limit;

// Oyuncuları seç
//$oyuncuCek = $db->prepare("SELECT o.*, u.*, r.*, ol.oyunTag, ol.oyunIsmi FROM oyuncu o JOIN uye u ON o.uyeID = u.ID JOIN oyunrank r ON o.oyuncuRank = r.rankID JOIN oyunlar ol ON o.oyunID = ol.oyunID WHERE ol.oyunID = :oyunID AND TIMESTAMPDIFF(YEAR, u.Dogumtarihi, CURDATE()) BETWEEN :min_age AND :max_age LIMIT :limit OFFSET :offset");
$takimcek = $db->prepare("SELECT t.*, l.takimID, l.uyeID , u.KullaniciAdi
                          FROM takimlar t JOIN  takimlideri l ON t.takimID = l.takimID
                          JOIN uye u ON l.uyeID = u.ID 
                          WHERE oyunID = :oyunID 
                          LIMIT :limit OFFSET :offset");
$takimcek->bindParam(':oyunID', $oyunID, PDO::PARAM_INT);
$takimcek->bindParam(':limit', $limit, PDO::PARAM_INT);
$takimcek->bindParam(':offset', $offset, PDO::PARAM_INT);
$takimcek->execute();
$takimlar = $takimcek->fetchAll(PDO::FETCH_ASSOC);



if (isset($_POST['mesajGonder'])) {
    $alici = $_POST['uyeID'];
    $mesajKategoriID = $_POST['konuSec'];
    $icerik = $_POST['icerik'];
    $konu = $_POST['konu'];

    $mesajiGonder = $db2->prepare("INSERT INTO mesajlar (gonderen_id, alici_id, mesaj_kategori_id, mesaj_icerik, mesaj_konu) VALUES (:gonderen_id, :alici_id, :mesaj_kategori_id, :mesaj_icerik, :mesaj_konu)");
    $mesajiGonder->bindParam(':gonderen_id', $_SESSION['UyeID']);
    $mesajiGonder->bindParam(':alici_id', $alici);
    $mesajiGonder->bindParam(':mesaj_kategori_id', $mesajKategoriID);
    $mesajiGonder->bindParam(':mesaj_icerik', $icerik);
    $mesajiGonder->bindParam(':mesaj_konu', $konu);
    $mesajiGonder->execute();
    header("Location: kesfet.php");
}
?>
<head>
    <title>Takım Bul | ScoutGG</title>
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


       
    </style>

    </head>
<body>
<div class="banner-section-outer">
<?php include("assets/header.php"); ?>


    <div class = "container col-md-12 d-flex justify-content-center" style="height: 100em; background-size: cover; background-position: center; padding: 20px; ">

        <div  class = "container gallery_images_section">
            <div class = "row">
                <div class = "col-md-12">
                    <h4 style="color: white;  "><?php echo $_SESSION['oyunTag'] ; ?>'ın için uygun takımları bul.  </h4>
                    <label style="color: white; font-weight: bold;"><a href = "oyunlarin.php">Oyunlara geri dönmek için tıkla. </a> </label>
                </div>
                
                    
                <div class="col-md-12" >
                    <div class="container">
                        <div class="row">
                            <?php foreach ($takimlar as $takim):  
                            ?>
                                
                                <div class = "col-md-4 m-0 p-1">
                                    <div class="card  mt-4  col-md-12 bg-secondary text-white">
                                    <div class="card-header" >
                                    <strong> <a href = "takim-profil.php?takimID=<?php echo $takim['takimID']; ?>"><?php  echo $takim['takimAdi']; ?></a></strong> 
                                    </div>
                                    <div class = "d-flex justify-content-center mt-2">
                                        <img style = "border-radius:2em; width: 8em; height: 8em;" class="card-img-top" src="assets/images/takimLogo/<?= $takim['takimLogo'] ?>" alt="<?= $oyuncu['oyuncuKullaniciAdi'] ?> resmi">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title" style = "font-size:2em">Lider: <?php echo $takim['KullaniciAdi']; ?></h5>
                                        <p class="card-text">Etiket: <?php echo $takim['takimEtiket']; ?></p>
                                        <p class="card-text">Oyun: <?php echo $_SESSION['oyunTag'];?></p>
                                        <p class="card-text">Puan: <?php echo $takim['takimPuani']; ?></p>
                                        <p class="card-text">Açıklama: <?php echo $takim['takimAciklama']; ?></p>
                                        <form action="mesaj_gonder.php" method="post">
                                            <input type="hidden" name="alici" value="<?php echo $takim['KullaniciAdi']; ?>">
                                            <input type="hidden" name="oyuncuKullaniciAdi" value="<?php echo $_SESSION['oyuncuKullaniciAdi']; ?>">
                                            <input type="hidden" name="oyuncuID" value="<?php echo $_SESSION['oyuncuID']; ?>">
                                            <input type="hidden" name="aliciID" value="<?php echo $takim['uyeID']; ?>">
                                            <input type="hidden" name="takimID" value="<?php echo $takim['takimID']; ?>">
                                            <input type="hidden" name="gorusmeTuru" value="0">
                                            <input type="hidden" name="konu" value="[<?php echo $takim['takimAdi']; ?>] Takımınıza Katılmak İstiyorum">
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
       
 
<!-- FOOTER SECTION -->

 <!--<div class="footer-section">
    <div class="container">
        <div class="middle-portion">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <ul class="links mb-0 list-unstyled">
                        <li><a href="./index.php">Anasayfa</a></li>
                        <li><a href="./about.php">Hakkımızda</a></li>
                        <li><a href="./kesfet.php">Keşfet</a></li>
                        <li><a href="./games.php"></a></li>
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
                        <li class="links"><a href="./contact.php">İletişim</a></li>
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
            <p></p>
        </div>
    </div>
</div>-->



</body>
</html>