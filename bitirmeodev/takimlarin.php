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

if(isset($_SESSION['Rol']) && $_SESSION['Rol'] < 2)
{
    header("Location: index.php");
    exit();
}


$uyeID = $_SESSION['UyeID'];


// Toplam takım sayısını say
$countSorgusu = $db->prepare("SELECT COUNT(*) as takimSayisi FROM takimlar o JOIN takimlideri u ON o.takimID = u.takimID WHERE u.uyeID = ?");
$countSorgusu->execute([$uyeID]);
$takimSayisi = $countSorgusu->fetch(PDO::FETCH_ASSOC)['takimSayisi'];

// Sayfa sayısını hesapla
$limit = 10;
$sayfa_sayisi = ceil($takimSayisi / $limit);

// Hangi sayfa numarasındayız?
$sayfa = isset($_GET['sayfa']) ? (int)$_GET['sayfa'] : 1;
$sayfa = max(1, min($sayfa, $sayfa_sayisi));

// LIMIT ve OFFSET değerlerini hesapla
$offset = ($sayfa - 1) * $limit;

// Takımları seç
$takimSorgusu = $db->prepare("SELECT o.takimID, o.takimAdi, o.takimEtiket, o.takimAciklama, o.oyunID FROM takimlar o  JOIN takimlideri u ON o.takimID = u.takimID WHERE u.uyeID = :uyeID LIMIT :limit OFFSET :offset");
$takimSorgusu->bindParam(':uyeID', $uyeID, PDO::PARAM_INT);
$takimSorgusu->bindParam(':limit', $limit, PDO::PARAM_INT);
$takimSorgusu->bindParam(':offset', $offset, PDO::PARAM_INT);
$takimSorgusu->execute();
$takimlar = $takimSorgusu->fetchAll(PDO::FETCH_ASSOC);



// Tablo kodu burada


?>
<head>
    <title>Takımların | ScoutGG</title>
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
   <!--   Latest compiled and minified CSS-->
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
    <!--  Latest compiled and minified CSS -->

    <style>
            /* Burada duyarlı tasarım stillerini ekleyin */
            @media screen and (max-width: 768px) {
            h1 {
                font-size: 32px;
            }
            table {
                font-size: 14px;
            }
        }
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
<?php require_once "assets/header.php"; ?>


<<div class = "container" style="height: 100vh; background-size: cover; background-position: center; padding: 20px; display: flex; flex-direction: column; align-items: center; height:50em;">

<div class="container" style="padding: 20px;">
<h1 style="color: white; font-size: 60px; font-weight: bold; text-align: center;">Takımların</h1>
            <div class="table-responsive">
                <table class="table">
                     <thead class="thead-dark">
                    <tr>
                    <th scope="col">ID</th>
                    <th scope="col">İsim</th>
                    <th scope="col">Etiket</th>
                    <th scope="col">Açıklama</th>
                    <th scope="col">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($takimlar as $takim): ?>
                    <form method="post" action="takim-yonet.php">
                        <input type="hidden" name="takimID" value="<?php echo $takim['takimID']; ?>">
                        <tr>
                            <th scope="row"><?php echo $takim['takimID']; ?></th>
                            <td><?php echo $takim['takimAdi']; ?></td>
                            <td><?php echo $takim['takimEtiket']; ?></td>
                            <td><?php echo $takim['takimAciklama']; ?></td>
                            <td style = " display: flex; gap: 10px;">
                                <button type="submit" class="btn btn-success" name="takimYonet">Takımı Yönet</button>
                                
                    </form>
                    <form method="post" action="oyuncubul.php">

                                 <input type="hidden" name="takimID" value="<?php echo $takim['takimID']; ?>">        
                                 <input type="hidden" name="oyunID" value="<?php echo $takim['oyunID']; ?>">
                                 <input type="hidden" name="takimAdi" value="<?php echo $takim['takimAdi']; ?>">            
                                <button type="submit" class="btn btn-info" name="oyuncuBul">Oyuncu Bul</button>
                                
                    </form>
                            </td>
                        </tr>
                   
                <?php endforeach; ?>
                </tbody>
                </table>
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
<!-- FOOTER SECTION -->
<div class="footer-section">
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
</div>
</body>
</html>