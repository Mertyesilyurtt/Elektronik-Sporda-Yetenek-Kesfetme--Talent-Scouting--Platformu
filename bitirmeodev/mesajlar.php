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



// Üye ID alınıyor
$uyeID = $_SESSION['UyeID'];

// Sayfa numarası alınıyor
if (isset($_GET['sayfa'])) {
  $sayfa = $_GET['sayfa'];
} else {
  $sayfa = 1;
}

// Mesaj sayısı bulunuyor
$sql = "SELECT COUNT(*) FROM mesajlar WHERE alici_id = :alici_id";
$stmt = $db2->prepare($sql);
$stmt->bindParam(':alici_id', $uyeID, PDO::PARAM_INT);
$stmt->execute();
$mesaj_sayisi = $stmt->fetchColumn();

// Sayfa başına mesaj sayısı belirleniyor
$mesaj_limiti = 6;

// Toplam sayfa sayısı hesaplanıyor
$sayfa_sayisi = ceil($mesaj_sayisi / $mesaj_limiti);

// Mesaj başlıkları sorgulanıyor
$sql = "SELECT mesaj_id, mesaj_konu FROM mesajlar WHERE alici_id = :alici_id ORDER BY mesaj_tarih DESC LIMIT :baslangic, :limit";
$stmt = $db2->prepare($sql);
$stmt->bindParam(':alici_id', $uyeID, PDO::PARAM_INT);
$stmt->bindValue(':baslangic', ($sayfa - 1) * $mesaj_limiti, PDO::PARAM_INT);
$stmt->bindValue(':limit', $mesaj_limiti, PDO::PARAM_INT);
$stmt->execute();
$mesajlar = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mesaj ID alınıyor
if (isset($_GET['id'])) {
  $mesaj_id = $_GET['id'];
} else {
  // Mesaj ID yoksa ilk mesaj seçiliyor
  if ($mesajlar) {
    $mesaj_id = $mesajlar[0]['mesaj_id'];
  } else {
    // Mesaj yoksa boş değer atanıyor
    $mesaj_id = '';
  }
}

// Mesaj içeriği sorgulanıyor
$sql = "SELECT mesaj_icerik FROM mesajlar WHERE mesaj_id = :mesaj_id";
$stmt = $db2->prepare($sql);
$stmt->bindParam(':mesaj_id', $mesaj_id, PDO::PARAM_INT);
$stmt->execute();
$mesaj_icerik = $stmt->fetchColumn();
?>


<head>
    <title>Mesajlar | ScoutGG</title>
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



</head>
<body>
<div class="banner-section-outer">
<?php require_once "assets/header.php"; ?>


<div class = "container" style="height: 100vh; background-size: cover; background-position: center; padding: 20px; display: flex; flex-direction: column; align-items: center; height:50em;">

<div class="container-fluid">
<h2>Mesajlar</h2>
  <div class="row">
    <div class="col-3">     
      <div class="list-group">
        <?php foreach ($mesajlar as $mesaj): ?>
          <a href="mesajlar.php?sayfa=<?php echo $sayfa; ?>&id=<?php echo $mesaj['mesaj_id']; ?>" class="list-group-item list-group-item-action <?php echo ($mesaj['mesaj_id'] == $mesaj_id) ? 'active' : ''; ?>"><?php echo $mesaj['mesaj_konu']; ?></a>
        <?php endforeach; ?>
      </div>
      <!-- Sayfalama linkleri oluşturuluyor -->
      <nav aria-label="Page navigation example" style = "margin-top:1em;">
        <ul class="pagination">
          <!-- Geri oku ekleniyor -->
          <li class="page-item <?php echo ($sayfa == 1) ? 'disabled' : ''; ?>">
            <a class="page-link" href="?sayfa=<?php echo ($sayfa - 1); ?>&id=<?php echo $mesaj_id; ?>" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
          <?php for ($i = 1; $i <= $sayfa_sayisi; $i++): ?>
            <li class="page-item <?php echo ($i == $sayfa) ? 'active' : ''; ?>"><a class="page-link" href="?sayfa=<?php echo $i; ?>&id=<?php echo $mesaj_id; ?>"><?php echo $i; ?></a></li>
          <?php endfor; ?>
          <!-- İleri oku ekleniyor -->
          <li class="page-item <?php echo ($sayfa == $sayfa_sayisi) ? 'disabled' : ''; ?>">
            <a class="page-link" href="?sayfa=<?php echo ($sayfa + 1); ?>&id=<?php echo $mesaj_id; ?>" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
        </ul>
      </nav>
    </div>
    <div class="col-9">
      <!-- Mesaj içeriği gösteriliyor -->
      <?php if ($mesaj_icerik): ?>
        <div class="card">
          <div class="card-body">
            <?php echo nl2br($mesaj_icerik); ?>
          </div>
        </div>
      <?php else: ?>
        <p>Mesaj bulunamadı.</p>
      <?php endif; ?>
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