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

/* if(isset($_SESSION['Rol']) && $_SESSION['Rol'] < 1)
{
    header("Location: index.php");
    exit();
}
if(!isset($_POST['mesajGonderSayfasi']) && !isset($_POST['mesajGonder']) ){

    header("Location: index.php");
    exit();
} */
if(isset($_POST['mesajGonderSayfasi'])){
    $alici = $_POST['alici'];
    $gorusmeTuru = $_POST['gorusmeTuru']; // 0 takıma katılma isteği - 1 oyuncu davet isteği
    $aliciID = $_POST['aliciID'];
    $takimID = $_POST['takimID'];
    $konu = $_POST['konu'];
    $oyuncuID = $_POST['oyuncuID'];

}

else if (isset($_POST['mesajGonder'])) {

    $icerik = $_POST['icerik'];
    $gonderenDiscordHesap = $_POST['gonderenDiscordHesap'];
    $alici = $_POST['alici'];
    $gorusmeTuru = $_POST['gorusmeTuru']; // 0 takıma katılma isteği - 1 oyuncu davet isteği
    $aliciID = $_POST['aliciID'];
    $takimID = $_POST['takimID'];
    $konu = $_POST['konu'];
    $oyuncuKullaniciAdi = $_POST['oyuncuKullaniciAdi'];
    $oyuncuID = $_POST['oyuncuID'];

    $stmt = $db->prepare("SELECT yoneticiID FROM yonetici ORDER BY RAND() LIMIT 1");
    $stmt->execute();
    $yonetici = $stmt->fetch(PDO::FETCH_ASSOC);
    $yoneticiID = $yonetici['yoneticiID'];


    $mesajiGonder = $db2->prepare("INSERT INTO gorusme (gorusmeTuru, gonderenId, aliciID, gorusmeBasligi, gorusmeIcerik, gonderenDiscordHesap, sorumluAdmin, takimID, oyuncuID) 
                                     VALUES (:gorusmeTuru, :gonderenId, :aliciID, :gorusmeBasligi, :gorusmeIcerik, :gonderenDiscordHesap, :sorumluAdmin, :takimID, :oyuncuID)");
    $mesajiGonder->bindParam(':gorusmeTuru', $gorusmeTuru);
    $mesajiGonder->bindParam(':gonderenId', $_SESSION['UyeID']);
    $mesajiGonder->bindParam(':aliciID', $aliciID);
    $mesajiGonder->bindParam(':gorusmeBasligi', $konu);
    $mesajiGonder->bindParam(':gorusmeIcerik', $icerik);
    $mesajiGonder->bindParam(':gonderenDiscordHesap', $gonderenDiscordHesap);
    $mesajiGonder->bindParam(':sorumluAdmin', $yoneticiID);
    $mesajiGonder->bindParam(':takimID', $takimID);
    $mesajiGonder->bindParam(':oyuncuID', $oyuncuID);
    $mesajiGonder->execute();
    echo '<script>alert("İstek Gönderildi.");
         window.location.href = "gorusmeler.php";
    </script>';
}

else {
    header("Location: oyunlarin.php");
    exit();
}

$uyeID = $_SESSION['UyeID'];

$kategoricek = $db2->prepare("SELECT * FROM kategoriler");
$kategoricek->execute();
$kategoriler = $kategoricek->fetchAll(PDO::FETCH_ASSOC);

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
      .mesaj  h1, .mesaj p {
        color: black;
      }
    </style>
</head>
<body>
<div class="banner-section-outer" style = "color:black;">
<?php require_once "assets/header.php"; ?>


<div class = "container" style="height: 100vh; color: black; background-size: cover; background-position: center; padding: 20px; display: flex; flex-direction: column; align-items: center; height:50em;">

        <div  class = "container mesaj">
          
        <div class="jumbotron jumbotron-fluid"  style = "border-radius: 2em;">
              <div class="container" >
                <h1>İstek Gönder</h1>
                <p>İstek talebinin yanıt alması vakit alabilir.</p>
                <form action="mesaj_gonder.php" method="post">
                    <div class="form-group">
                        <label for="alici">Alıcı:</label>
                        <input type="text" class="form-control" readonly value = "<?php echo $alici?>" id="alici" name="alici">
                    </div>
                    <div class="form-group">
                        <label for="konu">Konu:</label>
                        <input type="text" class="form-control" id="konu"  readonly value = "<?php echo $konu; ?>" name="konu">
                    </div>
                    <div class="form-group">
                        <label for="konu">Discord:</label>
                        <input type="text" class="form-control" id="gonderenDiscordHesap" placeholder="Örnek: Myre#0000" name="gonderenDiscordHesap">

                    </div>
                    <div class="form-group">
                        <label for="mesaj">Mesaj: (Lütfen amacınızı yazın.)</label>
                        <textarea class="form-control" id="icerik" name="icerik" rows="5"></textarea>
                    </div>
                    <input type="hidden" name="alici" value="<?php echo $alici; ?>">
                    <input type="hidden" name="gorusmeTuru" value="<?php echo $gorusmeTuru; ?>">
                    <input type="hidden" name="aliciID" value="<?php echo $aliciID; ?>">
                    <input type="hidden" name="takimID" value="<?php echo $takimID; ?>">
                    <input type="hidden" name="konu" value="<?php echo $konu; ?>">
                    <input type="hidden" name="oyuncuKullaniciAdi" value="<?php echo $oyuncuKullaniciAdi; ?>">
                    <input type="hidden" name="oyuncuID" value="<?php echo $oyuncuID; ?>">
                    <button type="submit" name  = "mesajGonder" class="btn btn-primary">Gönder</button>
                </form>
              </div>
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