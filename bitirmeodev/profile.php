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


$stmt = $db->prepare("SELECT KullaniciAdi, Email, Ismi, Soyismi, Dogumtarihi, Kayittarihi, Puani, ProfilResmi FROM uye WHERE Email = :email");
$stmt->bindParam(':email', $_SESSION['email']);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$kullaniciAdi = $result['KullaniciAdi'];
$Email = $result['Email'];
$isim = $result['Ismi'];
$soyisim = $result['Soyismi'];

$dgTarihi = new DateTime($result['Dogumtarihi']); //DateTime sınıfına dönüştürüyoruz
$bugun = new DateTime(); //bugünün tarihi
$fark = $bugun->diff($dgTarihi); // iki tarih arasındaki farkı hesapla
$yas = $fark->y; // fark yıl ay gün değerlerini tuttuğu için sadece y ile yıl bilgisini getir

$kayitTarihi = $result['Kayittarihi'];
$puan = $result['Puani'];
$pp = $result['ProfilResmi'];

if (isset($_POST["email_guncelle"])) {
    // Yeni email adresi
    $yeniEmail = $_POST["email"];

    // Veritabanında email adresini güncelle
    $emailgncl = $db->prepare("UPDATE uye SET Email = :email WHERE Email = :eski_email");
    $emailgncl->bindParam(":email", $yeniEmail);
    $emailgncl->bindParam(":eski_email", $Email);
    $emailgncl->execute();

    // Kullanıcının oturum bilgilerini güncelle
    $_SESSION["email"] = $yeniEmail;

    // Sayfayı yenilemek için yönlendirme
    header("Location: profile.php");
    exit;
}

if (isset($_POST['resim_guncelle'])) {
    // Dosya yükleme işlemi
    $hedef_klasor = 'assets/images/profil/';
    $izin_verilen_uzantilar = array('jpg', 'jpeg', 'png');
    $dosya_adi = $_FILES['resim']['name'];
    $dosya_uzantisi = strtolower(pathinfo($dosya_adi, PATHINFO_EXTENSION));
  
    if (in_array($dosya_uzantisi, $izin_verilen_uzantilar)) {
      $rastgele_isim = uniqid() . '.' . $dosya_uzantisi;
      $hedef_yol = $hedef_klasor . $rastgele_isim;
      if (move_uploaded_file($_FILES['resim']['tmp_name'], $hedef_yol)) {
        // Dosya yükleme işlemi başarılı
        $ppgncl = $db->prepare("UPDATE uye SET ProfilResmi = :profil_resmi WHERE Email = :email");
        $ppgncl->bindParam(':profil_resmi', $rastgele_isim);
        $ppgncl->bindParam(':email', $Email);
        $ppgncl->execute();
        header("Location: profile.php");
        exit;
        // Veritabanı güncelleme işlemi tamamlandı
      } else {
        // Dosya yükleme işlemi başarısız
      }
    } else {
      // Dosya uzantısı izin verilenler listesinde değil
    }
  }
  if (isset($_POST["sifre_guncelle"])) {
    // Eski ve yeni şifreleri al
    $eskiSifre = $_POST["eski_sifre"];
    $yeniSifre = $_POST["yeni_sifre"];
    
    // Kullanıcının veritabanındaki şifresini kontrol et
    $sorgu = $db->prepare("SELECT Sifre FROM uye WHERE Email = :email");
    $sorgu->bindParam(':email', $_SESSION['email']);
    $sorgu->execute();
    $result = $sorgu->fetch(PDO::FETCH_ASSOC);
    $dbSifre = $result['Sifre'];
    
    // Eğer eski şifre doğruysa, yeni şifreyi veritabanına kaydet
    if (password_verify($eskiSifre, $dbSifre)) {
        $yeniHash = password_hash($yeniSifre, PASSWORD_DEFAULT);
        $sifreGuncelle = $db->prepare("UPDATE uye SET Sifre = :sifre WHERE Email = :email");
        $sifreGuncelle->bindParam(':sifre', $yeniHash);
        $sifreGuncelle->bindParam(':email', $_SESSION['email']);
        $sifreGuncelle->execute();
        
        // Başarılı güncelleme mesajı
        $sifreGuncellendi = true;
    } else {
        // Hatalı eski şifre mesajı
        $eskiSifreHatali = true;
    }
}


?>


<!DOCTYPE html>
<html lang="tr">
<head>
<style>
 @media (max-width: 768px) {
    .main-content {
        padding: 20px 10px;
        display: block;
    }
}
  </style>
    
<title>Ana Sayfa | ScoutGG</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
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
    <link href="assets/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    <link href="assets/css/special_classes.css" rel="stylesheet" type="text/css">
    <link href="assets/css/mediaqueries.css" rel="stylesheet" type="text/css">
    <link href="assets/css/owl.carousel.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/owl.theme.default.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2.11.5/dist/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.min.js"></script>
</head>

<body>
<div class="sub-banner-section">
<?php 
include("assets/header.php");
?>
</div>

<div class="main-content" style="background-image: url('./assets/images/home_banner_background.png'); background-size: cover; background-position: center; padding: 20px; display: flex; flex-direction: column; align-items: center;">
    <h1 class="heading-primary" style="color: #333; font-size: 3.75rem; font-weight: bold; text-align: center; margin-top: 1rem;">Profil Sayfası</h1>

    <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: center; text-align: center; margin-top: 20px;">
        <img style="width: 400px; height: 400px; border-radius: 25%; margin-right: 20px;" src="./assets/images/profil/<?php echo $pp; ?>" alt="Profil Resmi">

        <div>
            <p style="color: #fff; font-size: 35px; margin-bottom: 10px; text-align: center;">Hoşgeldin <?php echo $kullaniciAdi; ?></p>

            <form method="post" action="" enctype="multipart/form-data" style="text-align: center;">
                <label style="font-size: 22px; color: #fff; margin-bottom: 10px;" for="resim">Profil Resmi:</label>
                <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">
                    <input type="file" name="resim" style="margin-right: 10px;">
                    <button style="background-color: #4CAF50; color: #fff; border: none; padding: 8px 16px; font-size: 16px; border-radius: 4px;" type="submit" name="resim_guncelle">Güncelle</button>
                </div>
            </form>

            <p style="color: #fff; font-size: 18px; margin-top: 22px; margin-bottom: 5px;">Email: <?php echo $Email; ?></p>

            <form method="post" action="" style="text-align: center;">
                <label style="font-size: 22px; color: #fff; margin-bottom: 10px;" for="email">Yeni Email Adresi:</label>
                <input type="email" name="email" id="email" style="padding: 6px 10px; font-size: 16px; border-radius: 4px; border: 1px solid #ccc; margin-right: 10px;">
                <input style="background-color: #4CAF50; color: #fff; border: none; padding: 8px 16px; font-size: 16px; border-radius: 4px;" type="submit" name="email_guncelle" value="Güncelle">
            </form>

            <p style="color: #fff; font-size: 22px; margin-top: 25px; text-align: center;">Kişisel Bilgiler:</p>
            <p style="color: #fff; font-size: 22px; margin-bottom: 5px;">İsim: <?php echo $isim; ?></p>
            <p style="color: #fff; font-size: 22px; margin-bottom: 5px;">Soyisim: <?php echo $soyisim; ?></p>
            <p style="color: #fff; font-size: 22px; margin-bottom: 5px;">Yaşı: <?php echo $yas; ?></p>
            <p style="color: #fff; font-size: 22px; margin-bottom: 5px;">Kayıt Tarihi: <?php echo $kayitTarihi; ?></p>
            <p style="color: #fff; font-size: 22px;">Puan: <?php echo $puan; ?></p> 

            <h2 style="text-align: center;">Şifre Değiştir</h2>
            <form method="POST" style="text-align: center;">
                <div class="form-group" style="margin-bottom: 10px; display: flex; align-items: center; justify-content: center;">
                    <label style="font-size: 16px; margin-right: 10px;">Eski Şifre</label>
                    <input type="password" name="eski_sifre" class="form-control" style="width: 200px;" required>
                </div>
                <div class="form-group" style="margin-bottom: 10px; display: flex; align-items: center; justify-content: center;">
                    <label style="font-size: 16px; margin-right: 10px;">Yeni Şifre</label>
                    <input type="password" name="yeni_sifre" class="form-control" style="width: 200px;" required>
                </div>
                <button style="background-color: #4CAF50; color: #fff; border: none; padding: 8px 16px; font-size: 16px; border-radius: 4px;" type="submit" name="sifre_guncelle" class="btn btn-primary">Şifreyi Güncelle</button>
            </form>
            <?php 
            if (isset($sifreGuncellendi)) {
                echo '<div class="alert alert-success">Şifreniz başarıyla güncellendi.</div>';
            } else if (isset($eskiSifreHatali)) {
                echo '<div class="alert alert-danger">Hatalı eski şifre.</div>';
            }
            ?>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>