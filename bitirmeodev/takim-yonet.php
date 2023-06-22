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
}/*
if ($_SESSION['Onay'] !=2) {
    header("Location: index.php");
    exit();
} */

// takimID değeri session'a aktarılıyor.
if (isset($_POST['takimYonet'])) {
    $_SESSION['takimID'] = $_POST['takimID'];
} 

else if (isset($_POST['takimdanAt'])) {

    $oyuncuID = $_POST['oyuncuID'];
    $uyeID = $_POST['uyeID'];
    $oyuncuKullaniciAdi = $_POST['oyuncuKullaniciAdi'];
    $takimID = null;
    $oyuncuTakimDurumu = 0;
    $mesajKategoriID = 5;
    $icerik = $oyuncuKullaniciAdi." adlı oyuncu bulunduğu takımdan lider tarafından çıkarıldı.";
    $konu = $oyuncuKullaniciAdi. " adlı oyuncunun artık takımı bulunmuyor.";
  
  
    $takimdanAt = $db->prepare("UPDATE oyuncu SET oyuncuTakimDurumu=:oyuncuTakimDurumu, takimID = :takimID WHERE oyuncuID=:oyuncuID");
    $takimdanAt->bindParam(':oyuncuTakimDurumu', $oyuncuTakimDurumu);
    $takimdanAt->bindParam(':takimID', $takimID);
    $takimdanAt->bindParam(':oyuncuID', $oyuncuID);
    $takimdanAt->execute();


    $mesajiGonder = $db2->prepare("INSERT INTO mesajlar (gonderen_id, alici_id, mesaj_kategori_id, mesaj_icerik, mesaj_konu) VALUES (:gonderen_id, :alici_id, :mesaj_kategori_id, :mesaj_icerik, :mesaj_konu)");
    $mesajiGonder->bindParam(':gonderen_id', $_SESSION['UyeID']);
    $mesajiGonder->bindParam(':alici_id', $uyeID);
    $mesajiGonder->bindParam(':mesaj_kategori_id', $mesajKategoriID);
    $mesajiGonder->bindParam(':mesaj_icerik', $icerik);
    $mesajiGonder->bindParam(':mesaj_konu', $konu);
    $mesajiGonder->execute();




  
    echo '<script>alert("Oyuncu takımdan atıldı.");
          window.location.href = "takim-yonet.php";
    </script>';
  
  
  }
  else if (isset($_POST['takimYrd'])) {

    
    $uyeID = $_POST['uyeID'];
    $oyuncuID = $_POST['oyuncuID'];
    $takimID = $_POST['takimID'];
    $liderRolu = 2;

    $kontrol = $db->prepare("SELECT * FROM takimlideri WHERE oyuncuID = :oyuncuID AND takimID = :takimID");
    $kontrol->bindParam(':oyuncuID', $oyuncuID);
    $kontrol->bindParam(':takimID', $takimID);
    $kontrol->execute();
        
    $result = $kontrol->fetch(PDO::FETCH_ASSOC);
    
    if($result){
        $yrdYap = $db->prepare("UPDATE takimlideri SET liderRolu=:liderRolu WHERE takimID=:takimID AND oyuncuID=:oyuncuID ");
        $yrdYap->bindParam(':liderRolu', $liderRolu);
        $yrdYap->bindParam(':takimID', $takimID);
        $yrdYap->bindParam(':oyuncuID', $oyuncuID);
        $yrdYap->execute();
    } else {
        $yrdYap = $db->prepare("INSERT INTO takimlideri  (uyeID, takimID, oyuncuID, liderRolu) VALUES (:uyeID, :takimID, :oyuncuID, :liderRolu)");
        $yrdYap->bindParam(':uyeID', $uyeID);
        $yrdYap->bindParam(':takimID', $takimID);
        $yrdYap->bindParam(':oyuncuID', $oyuncuID);
        $yrdYap->bindParam(':liderRolu', $liderRolu);
        $yrdYap->execute();
    }
    
    
  
    echo '<script>alert("Oyuncu yardımcı yapıldı.");
          window.location.href = "takim-yonet.php";
    </script>';
 
  }

  else if (isset($_POST['takimYrdKov'])) {

    
    $LiderID = $_POST['LiderID'];
    $oyuncuID = $_POST['oyuncuID'];
    $takimID = $_POST['takimID'];
    $liderRolu = 0;

    $yrdKov = $db->prepare("UPDATE takimlideri SET liderRolu=:liderRolu WHERE takimID=:takimID AND oyuncuID=:oyuncuID ");
    $yrdKov->bindParam(':liderRolu', $liderRolu);
    $yrdKov->bindParam(':takimID', $takimID);
    $yrdKov->bindParam(':oyuncuID', $oyuncuID);
    $yrdKov->execute();

  
    echo '<script>alert("Oyuncu yardımcılıktan çıkarıldı.");
          window.location.href = "takim-yonet.php";
    </script>';
 
  }



  if (!isset($_SESSION['takimID'])) {
    header("Location: takimlarin.php");
    exit();
    }

// sayfa değeri kontrol ediliyor
if (isset($_GET['sayfa'])) {
    $sayfa = $_GET['sayfa'];
} else {
    $sayfa = 1;
}

$takimID = $_SESSION['takimID'];
$takimcek = $db->prepare("SELECT * FROM takimlar o JOIN takimlideri u ON o.takimID = u.takimID WHERE o.takimID = ?");
$takimcek->execute([$takimID]);
$takimin = $takimcek->fetch(PDO::FETCH_ASSOC);


$oyuncuCek = $db->prepare("SELECT  COUNT(*) as oyuncuSayisi FROM oyuncu WHERE takimID = ?");
$oyuncuCek->execute([$takimID]);
$oyuncu_count = $oyuncuCek->fetch(PDO::FETCH_ASSOC)['oyuncuSayisi'];


$limit = 10;
$sayfa_sayisi = ceil($oyuncu_count / $limit);
$sayfa = isset($_GET['sayfa']) ? (int)$_GET['sayfa'] : 1;
$sayfa = max(1, min($sayfa, $sayfa_sayisi));

$offset = ($sayfa - 1) * $limit;


$oyuncuCek = $db->prepare("SELECT DISTINCT o.*, u.*, y.ID, r.rankAd FROM oyuncu o
                            JOIN takimlar u ON o.takimID = u.takimID   
                            JOIN uye y ON o.uyeID = y.ID
                            JOIN oyunrank  r ON o.oyuncuRank = r.rankID
                            WHERE o.takimID = :takimID LIMIT :limit OFFSET :offset");
$oyuncuCek->bindParam(':takimID', $takimID, PDO::PARAM_INT);
$oyuncuCek->bindParam(':limit', $limit, PDO::PARAM_INT);
$oyuncuCek->bindParam(':offset', $offset, PDO::PARAM_INT);
$oyuncuCek->execute();
$oyuncular = $oyuncuCek->fetchAll(PDO::FETCH_ASSOC);




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
          /*  duyarlı tasarım stilleri */
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
<?php include("assets/header.php"); ?>


<div class = "container" style="height: 100vh; background-size: cover; background-position: center; padding: 20px; display: flex; flex-direction: column; align-items: center; height:50em;">

<div class="container" style="padding: 20px;">
              <h3 style="color: white;  font-weight: bold;">Takımın -> <?php echo $takimin['takimAdi']; ?> </h3>
              <label style="color: white; font-weight: bold;"><a href = "takimlarin.php">Takımlara geri dönmek için tıkla. </a> </label>
        </div>
       
        <div class= "row">
        <div class= "col-md-12">
        <div class="table-responsive">
            <table class="table">
                     <thead class="thead-dark">
                    <tr>
                    <th scope="col">Takım Logo</th>
                    <th scope="col">Takım Adı</th>
                    <th scope="col">Takım Etiketi</th>
                    <th scope="col">Takım Açıklama</th>
                    </tr>
                </thead>
                <tbody>    

                        <tr>
                            <th scope="row"><?php echo  '<img style = "width:50px; height: 50px;" src ="assets/images/takimLogo/' . $takimin["takimLogo"] . '" alt="Takım Logo ">'  ?></th>
                            <th scope="row"><?php echo  $takimin['takimAdi']; ?></th>
                            <th scope="row"><?php echo  $takimin['takimEtiket']; ?></th>
                            <th scope="row"><?php echo  $takimin['takimAciklama']; ?></th>
                        </tr>

                <</tbody>
                </table>
                </div>
            </div>
            
        </div>
        
    
            <div class= "col-md-12">
            <div class="table-responsive">
            <table class="table">
                     <thead class="thead-dark">
                    <tr>
                    <th scope="col">Kullanıcı Adı</th>
                    <th scope="col">Etiketi</th>
                    <th scope="col">Başarı Sıralaması</th>
                    <th scope="col">Rank</th>
                    <th scope="col">Rol</th>
                    <th scope="col">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                </div>

                <?php foreach ($oyuncular as $oyuncu): ?>
                    <form method="post" action="takim-yonet.php">
                        <input type="hidden" name="oyuncuID" value="<?php echo $oyuncu['oyuncuID']; ?>">
                        <input type="hidden" name="uyeID" value="<?php echo $oyuncu['ID']; ?>">
                        <input type="hidden" name="oyuncuKullaniciAdi" value="<?php echo $oyuncu['oyuncuKullaniciAdi']; ?>">
                        <input type="hidden" name="takimID" value="<?php echo $oyuncu['takimID']; ?>">
                        <tr>
                            <?php 

                            $liderCek = $db->prepare("SELECT DISTINCT liderRolu, LiderID FROM takimlideri
                            WHERE takimID = :takimID AND oyuncuID = :oyuncuID ");
                            $liderCek->bindParam(':takimID', $oyuncu['takimID'], PDO::PARAM_STR);
                            $liderCek->bindParam(':oyuncuID', $oyuncu['oyuncuID'], PDO::PARAM_STR);

                            $liderCek->execute();
                            $lider = $liderCek->fetch(PDO::FETCH_ASSOC);

                            
                            if ($lider) {
                                echo '<input type="hidden" name="LiderID" value="'. $lider['LiderID'].'">';
                                if($lider['liderRolu'] == 1){
                                    $liderRolu = "Koç";
                                    $rol = 1;
                                }
                                else if($lider['liderRolu'] == 2){
                                    $liderRolu = "Yardımcı"  ;
                                    $rol = 2;
                                }
                                else if($lider['liderRolu'] == 5){
                                    $liderRolu = "Kurucu";
                                    $rol = 5;
                                }
                                else if($lider['liderRolu'] == 0){
                                    $liderRolu = "Üye";
                                    $rol = 0;
                                }
                               else{
                                    $liderRolu = "Tanımsız";
                                }
                            } else {
                                $liderRolu = "Üye";
                                $rol = 0;
                            }

                            ?>
                            <th scope="row"> <a href = "oyuncu-profil.php?oyuncuID=<?php echo $oyuncu['oyuncuID']; ?>"><?php echo $oyuncu['oyuncuKullaniciAdi']; ?></a></th>
                            <td><?php echo $oyuncu['oyuncuEtiketi']; ?></td> 
                            <td><?php echo $oyuncu['oyuncuSiralama']; ?></td>
                            <td><?php echo $oyuncu['rankAd']; ?></td>
                            <td><?php echo $liderRolu; ?></td>
                            <td>
                            <?php 
                                   if($rol < 5)
                                   {  
                                    echo'<button type="submit" class="btn btn-warning mr-1" name="takimdanAt">At</button>';
                                    
                                   }
                                  if($rol == 0)
                                   {
                                       echo '<button type="submit" class="btn btn-info" name="takimYrd">Yardımcı Yap</button>';
                                   }
                                   else if($rol == 2)
                                   {
                                       echo '<button type="submit" class="btn btn-primary" name="takimYrdKov">Yardımcı Kov</button>';
                                   }
                                   else if($rol == 5)
                                   {
                                       echo '<strong>Kurucu</storung>';
                                   }
                            ?>
                            </td>
                        </tr>
                    </form>
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