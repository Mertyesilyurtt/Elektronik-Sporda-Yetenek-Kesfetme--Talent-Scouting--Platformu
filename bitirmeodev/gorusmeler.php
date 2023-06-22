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

// Görüşme sayısı bulunuyor
$sql = "SELECT COUNT(*) FROM gorusme WHERE aliciID = :aliciID OR gonderenID = :gonderenID";
$stmt = $db2->prepare($sql);
$stmt->bindParam(':aliciID', $uyeID, PDO::PARAM_INT);
$stmt->bindParam(':gonderenID', $uyeID, PDO::PARAM_INT);
$stmt->execute();
$mesaj_sayisi = $stmt->fetchColumn();

// Sayfa başına mesaj sayısı belirleniyor
$mesaj_limiti = 6;

// Toplam sayfa sayısı hesaplanıyor
$sayfa_sayisi = ceil($mesaj_sayisi / $mesaj_limiti);

// Görüşme başlıkları sorgulanıyor
$sql = "SELECT gorusmeID, gorusmeBasligi,  gorusmeOnayDurum, gonderenID FROM gorusme WHERE aliciID = :aliciID OR gonderenID = :gonderenID ORDER BY gorusmeTarih DESC LIMIT :baslangic, :limit";
$stmt = $db2->prepare($sql);
$stmt->bindParam(':aliciID', $uyeID, PDO::PARAM_INT);
$stmt->bindParam(':gonderenID', $uyeID, PDO::PARAM_INT);
$stmt->bindValue(':baslangic', ($sayfa - 1) * $mesaj_limiti, PDO::PARAM_INT);
$stmt->bindValue(':limit', $mesaj_limiti, PDO::PARAM_INT);
$stmt->execute();
$gorusmeler = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Görüşme ID alınıyor
if (isset($_GET['id'])) {
  $gorusmeID = $_GET['id'];
} else {
  // Görüşme ID yoksa ilk Görüşme seçiliyor
  if ($gorusmeler) {
    $gorusmeID = $gorusmeler[0]['gorusmeID'];
  } else {
    // Görüşme yoksa boş değer atanıyor
    $gorusmeID = '';
  }
}

// Görüşme içeriği sorgulanıyor
$sql = "SELECT g.gorusmeID, g.gorusmeBasligi, g.gorusmeOnayDurum, g.gorusmeTuru, g.adminMesaj, g.gorusmeIcerik, g.gorusmeOnayDurum, t.takimID, t.takimAdi, g.gorusmeTarih, g.gonderenID, g.aliciID, u1.KullaniciAdi AS gonderenKullaniciAdi, u2.KullaniciAdi AS aliciKullaniciAdi, o.oyuncuKullaniciAdi, o.oyuncuID
        FROM espor_mesajlar_db.gorusme g 
        JOIN espor_db.uye u1 ON g.gonderenID = u1.ID
        JOIN espor_db.uye u2 ON g.aliciID = u2.ID
        JOIN espor_db.oyuncu o ON g.oyuncuID = o.oyuncuID 
        JOIN espor_db.takimlar t ON g.takimID = t.takimID
        WHERE g.gorusmeID = :gorusmeID";

$stmt = $db2->prepare($sql);
$stmt->bindParam(':gorusmeID', $gorusmeID, PDO::PARAM_INT);
$stmt->execute();
$gorusmeCek = $stmt->fetch(PDO::FETCH_ASSOC);


if (isset($_POST['gorusmeBaslat'])){ // Başlat = 2 / Reddet(Bitir) = 1 / 3 = Onaylandı 

  $gorusmeID = $_POST['gorusmeID'];
  $aliciDiscord = $_POST['aliciDiscord'];
  $onayDurum = 2;

    if (empty($aliciDiscord)) {
      echo '<script>alert("Lütfen Discord hesabınızı giriniz.");
            window.location.href = "gorusmeler.php";
      </script>';
 
    }
    else {
      $gorusmeBaslat = $db2->prepare("UPDATE gorusme SET gorusmeOnayDurum=:gorusmeOnayDurum, aliciDiscordHesap = :aliciDiscordHesap WHERE gorusmeID=:gorusmeID");
      $gorusmeBaslat->bindParam(':gorusmeID', $gorusmeID);
      $gorusmeBaslat->bindParam(':gorusmeOnayDurum', $onayDurum);
      $gorusmeBaslat->bindParam(':aliciDiscordHesap', $aliciDiscord);
      $gorusmeBaslat->execute();
      echo '<script>alert("Görüşme Başlatıldı.");
            window.location.href = "gorusmeler.php";
      </script>';
 
    }
}
if (isset($_POST['gorusmeBitir'])){ // Başlat = 2 / Reddet(Bitir) = 1 / 3 = Onaylandı 
  
  $gorusmeID = $_POST['gorusmeID'];
  $onayDurum = 1;

  $gorusmeBaslat = $db2->prepare("UPDATE gorusme SET gorusmeOnayDurum=:gorusmeOnayDurum WHERE gorusmeID=:gorusmeID");
  $gorusmeBaslat->bindParam(':gorusmeID', $gorusmeID);
  $gorusmeBaslat->bindParam(':gorusmeOnayDurum', $onayDurum);
  $gorusmeBaslat->execute();
  echo '<script>alert("Görüşme olumsuz olarak bitirildi.");
        window.location.href = "gorusmeler.php";
  </script>';
 
}

?>


<head>
    <title>Görüşmeler | ScoutGG</title>
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
    .form-control::placeholder {
      color: blue;
    }
    </style>

</head>
<body>
<div class="banner-section-outer">
<?php require_once "assets/header.php"; ?>


<div class = "container" style="height: 100vh; background-size: cover; background-position: center; padding: 20px; display: flex; flex-direction: column; align-items: center; height:50em;">

<div class="container-fluid">
<h2>Görüşmeler</h2>
  <div class="row">
    <div class="col-3">     
      <div class="list-group">
        <?php foreach ($gorusmeler as $gorusme): 

        if($gorusme['gorusmeOnayDurum'] == 0){
              if($gorusme['gonderenID'] == $uyeID){
                $gorusmeRengi = "badge badge-success";
                $gorusmeMetni = "Giden Teklif";
              }
              else
              {
                $gorusmeRengi = "badge badge-danger";
                $gorusmeMetni = "Gelen Teklif";
              }
        }
        else if($gorusme['gorusmeOnayDurum'] == 2){
              $gorusmeRengi = "badge badge-warning";
              $gorusmeMetni = "İletildi";
        }
        else if($gorusme['gorusmeOnayDurum'] == 1){
          $gorusmeRengi = "badge badge-secondary";
          $gorusmeMetni = "Sonlandırıldı";
        }
        else if($gorusme['gorusmeOnayDurum'] == 3){
          $gorusmeRengi = "badge badge-info";
          $gorusmeMetni = "Aktif";
        }
        else if($gorusme['gorusmeOnayDurum'] == 4){
          $gorusmeRengi = "badge badge-info";
          $gorusmeMetni = "Başarılı";
        }
        ?>
          <a href="gorusmeler.php?sayfa=<?php echo $sayfa; ?>&id=<?php echo $gorusme['gorusmeID']; ?>" class="list-group-item list-group-item-action <?php echo ($gorusme['gorusmeID'] == $gorusmeID) ? 'active' : ''; ?>"><?php echo $gorusme['gorusmeBasligi'] ?> <?php echo '<span class="'.$gorusmeRengi.'"> '.$gorusmeMetni.'</span>'; ?> </a>
        <?php endforeach; ?>
      </div>
      <!-- Sayfalama linkleri oluşturuluyor -->
      <nav aria-label="Page navigation example" style = "margin-top:1em;">
        <ul class="pagination">
          <!-- Geri oku ekleniyor -->
          <li class="page-item <?php echo ($sayfa == 1) ? 'disabled' : ''; ?>">
            <a class="page-link" href="?sayfa=<?php echo ($sayfa - 1); ?>&id=<?php echo $gorusmeID; ?>" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
          <?php for ($i = 1; $i <= $sayfa_sayisi; $i++): ?>
            <li class="page-item <?php echo ($i == $sayfa) ? 'active' : ''; ?>"><a class="page-link" href="?sayfa=<?php echo $i; ?>&id=<?php echo $gorusmeID; ?>"><?php echo $i; ?></a></li>
          <?php endfor; ?>
          <!-- İleri oku ekleniyor -->
          <li class="page-item <?php echo ($sayfa == $sayfa_sayisi) ? 'disabled' : ''; ?>">
            <a class="page-link" href="?sayfa=<?php echo ($sayfa + 1); ?>&id=<?php echo $gorusmeID; ?>" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
        </ul>
      </nav>
    </div>
    <div class="col-9">
      <!-- Mesaj içeriği gösteriliyor -->
      <?php if ($gorusmeCek): 
        if($gorusmeCek['gorusmeTuru'] == 0){
          $gorusmeTuru = "Takıma katılma isteği";
        }  
        else if($gorusmeCek['gorusmeTuru'] == 1){
          $gorusmeTuru = "Takıma davet isteği";
        }  
        else{
          $gorusmeTuru = "Tanımlanamadı...";
        }  
        if($gorusmeCek['gorusmeOnayDurum'] == 0){
          $gorusmeOnayDurum = "<label class = 'text-warning'> Beklemede </label>";
        }  
        else if($gorusmeCek['gorusmeOnayDurum'] == 1){
          $gorusmeOnayDurum = "<label class = 'text-danger'> Görüşme başarısızlıkla sonlandırıldı. </label>";
            
        }  
        else if($gorusmeCek['gorusmeOnayDurum'] == 2){
          $gorusmeOnayDurum = "<label class = 'text-warning'> Talep iletildi </label>";

        }
        else if($gorusmeCek['gorusmeOnayDurum'] == 3){
          $gorusmeOnayDurum = "<label class = 'text-info'> Aktif (Site Admini sizinle iletişime geçecektir.) </label>";

        }    
        else if($gorusmeCek['gorusmeOnayDurum'] == 4){
          $gorusmeOnayDurum = "<label class = 'text-success'> Görüşme başarı ile sonlandırıldı. </label>";

        }  
        else {
          $gorusmeOnayDurum = "<label class = 'text-secondary'> Tanımlanmadı... </label>";
        }
      ?>
        <div class="card">
          <div class="card-header" >
              <strong style = "color:blue;" ><?php echo nl2br($gorusmeCek['gorusmeBasligi']) . ' [' . $gorusmeOnayDurum . ']'; ?></strong>
          </div>
          <div class="card-body">
              <strong>Görüşme ID:</strong> <?php echo $gorusmeCek['gorusmeID']; ?> <br/>
              <strong>Gönderen:</strong> <?php echo $gorusmeCek['gonderenKullaniciAdi']; ?> <br/>
              <strong>Alıcı:</strong> <?php echo $gorusmeCek['aliciKullaniciAdi']; ?> <br/>
              <strong>Görüşme Türü:</strong> <?php echo $gorusmeTuru; ?> <br/>
              <strong>İstek Tarihi:</strong> <?php echo $gorusmeCek['gorusmeTarih']; ?> <br/> 
              <strong>Oyuncu Kullanıcı Adı:</strong>  <a href = "oyuncu-profil.php?oyuncuID=<?php echo $gorusmeCek['oyuncuID']; ?>"><?php echo $gorusmeCek['oyuncuKullaniciAdi']; ?> </a> <br/>
              <strong>Takım:</strong> <a style = "color:purple;" href = "takim-profil.php?takimID=<?php echo $gorusmeCek['takimID']; ?>"><?php echo $gorusmeCek['takimAdi'];; ?></a><br/>
              <strong>Onay Durumu:</strong> <?php echo $gorusmeOnayDurum; ?> <br/>
              <strong>Mesaj: </strong><?php echo nl2br($gorusmeCek['gorusmeIcerik']); ?><br/>
              <strong>Admin İletisi: </strong><?php echo nl2br($gorusmeCek['adminMesaj']); ?>
          
              <?php 
                if($gorusmeCek['gonderenID'] != $uyeID  && $gorusmeCek['gorusmeOnayDurum'] == 0){
                  if($gorusmeCek['gorusmeOnayDurum'] == 0 ){ // Görüşme beklemedeyse
                      echo '<form action = "gorusmeler.php" method = "post">
                      <div class="form-group mt-5">
                        <strong for="textInput">Discord Adresini Girin:</strong>
                        <input type="text" class="form-control" name = "aliciDiscord" id="textInput"  placeholder="Örnek: Myre#1234">
                      </div>
                      <div class="text-center">
                        <input type="hidden" name="gorusmeID" value="'. $gorusmeCek['gorusmeID'] .'">
                        <button type="submit" name = "gorusmeBaslat" class="btn btn-success mr-2">Görüşmeyi Başlat</button>
                        <button type="submit" name = "gorusmeBitir" class="btn btn-danger ">Görüşmeyi Bitir</button>
                      </div>
                    </form>';
                  }
                  else if($gorusmeCek['gorusmeOnayDurum'] == 1){ // görüşme Bittiyse (Olumsuz anlamda / reddedildi)
                      
                      echo '
                      <div class="form-group mt-5">
                      <strong for="textInput">Görüşme Bitirildi</strong>
                      </div>
                      ';
                  }
                  
                  else if($gorusmeCek['gorusmeOnayDurum'] == 3){ // görüşme Bittiyse (Olumsuz anlamda / reddedildi)
                      
                    echo '
                    <div class="form-group mt-5">
                    <strong for="textInput">Görüşme Başlatıldı</strong>
                    </div>
                    ';
                  }
                  else{
                    echo '
                    <div class="form-group mt-5">
                    <strong for="textInput">Görüşme Bitirildi</strong>
                    </div>
                    ';
                  }
                }
                else if($gorusmeCek['gorusmeOnayDurum'] == 0 )
                {
                  echo '<form action = "gorusmeler.php" method = "post">
                  <div class="text-center">
                    <input type="hidden" name="gorusmeID" value="'. $gorusmeCek['gorusmeID'] .'">
                    <button type="submit" name = "gorusmeBitir" class="btn btn-warning ">İsteği Geri Çek</button>
                  </div>
                </form>';
                }
                else if($gorusmeCek['gorusmeOnayDurum'] == 2 ){ // görüşme başlatıldıysa
                  echo '<form action = "gorusmeler.php" method = "post">
                  <div class="text-center">
                    <input type="hidden" name="gorusmeID" value="'. $gorusmeCek['gorusmeID'] .'">
                    <button type="submit" name = "gorusmeBitir" class="btn btn-danger ">Görüşmeyi Bitir</button>
                  </div>
                </form>';
                }
                else if($gorusmeCek['gorusmeOnayDurum'] == 3){
                  echo '
                  <div class="form-group mt-5">
                  <strong for="textInput">Görüşme Devam Ediyor</strong>
                  </div>
                  ';
                }
                else {
                  echo '
                  <div class="form-group mt-5">
                  <strong for="textInput">Görüşme Bitirildi</strong>
                  </div>
                  ';
                }
              ?>


          </div>
        </div>
      <?php else: ?>
        <p>Görüşme bulunamadı.</p>
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