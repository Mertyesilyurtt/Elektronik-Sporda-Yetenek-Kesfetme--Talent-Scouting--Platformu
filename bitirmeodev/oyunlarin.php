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



$uyeID = $_SESSION['UyeID'];


// Toplam takım sayısını say
$countSorgusu = $db->prepare("SELECT COUNT(*) as oyuncuSayisi FROM oyuncu o JOIN oyunlar u ON o.oyunID = u.oyunID WHERE o.uyeID = ?");
$countSorgusu->execute([$uyeID]);
$oyuncuSayisi = $countSorgusu->fetch(PDO::FETCH_ASSOC)['oyuncuSayisi'];

// Sayfa sayısını hesapla
$limit = 10;
$sayfa_sayisi = ceil($oyuncuSayisi / $limit);

// Hangi sayfa numarasındayız?
$sayfa = isset($_GET['sayfa']) ? (int)$_GET['sayfa'] : 1;
$sayfa = max(1, min($sayfa, $sayfa_sayisi));

// LIMIT ve OFFSET değerlerini hesapla
$offset = ($sayfa - 1) * $limit;

// Oyuncuları seç
$oyuncuSorgusu = $db->prepare("SELECT o.* , oy.* , t.takimAdi, t.takimID, u.ID  FROM oyuncu o JOIN oyunlar oy ON o.oyunID = oy.oyunID JOIN uye u ON o.uyeID = u.ID LEFT JOIN takimlar t ON o.takimID = t.takimID WHERE o.uyeID = :uyeID LIMIT :limit OFFSET :offset");
$oyuncuSorgusu->bindParam(':uyeID', $uyeID, PDO::PARAM_INT);
$oyuncuSorgusu->bindParam(':limit', $limit, PDO::PARAM_INT);
$oyuncuSorgusu->bindParam(':offset', $offset, PDO::PARAM_INT);
$oyuncuSorgusu->execute();
$oyuncular = $oyuncuSorgusu->fetchAll(PDO::FETCH_ASSOC);



if (isset($_POST['takimAyril'])) {

    $oyuncuID = $_POST['oyuncuID'];
    $takimID = null;
    $oyuncuTakimDurumu = 0;

    


    $takimdanCik = $db->prepare("UPDATE oyuncu SET oyuncuTakimDurumu=:oyuncuTakimDurumu, takimID = :takimID WHERE oyuncuID=:oyuncuID");
    $takimdanCik->bindParam(':oyuncuTakimDurumu', $oyuncuTakimDurumu);
    $takimdanCik->bindParam(':takimID', $takimID);
    $takimdanCik->bindParam(':oyuncuID', $oyuncuID);
    $takimdanCik->execute();
  
    echo '<script>alert("Takımdan Ayrıldınız.");
          window.location.href = "oyunlarin.php";
    </script>'; 

}


?>
<head>
    <title>Oyuncu Profillerin | ScoutGG</title>
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
    color: black;
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


<div class = "container" style="height: 100vh; background-size: cover; background-position: center; padding: 20px; display: flex; flex-direction: column; align-items: center; height:50em;">

<div class="container" style="padding: 20px;">
<h1 style="color: white; font-size: 60px; font-weight: bold; text-align: center;">Oyuncu Profilleri</h1>
<div class="table-responsive">
                <table class="table">
                     <thead class="thead-dark">
                    <tr>
                    <th scope="col">Oyun</th>
                    <th scope="col">Kullanıcı Adı</th>
                    <th scope="col">Etiket</th>
                    <th scope="col">Takımın</th>
                    <th scope="col">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($oyuncular as $oyuncu): 
                     $takimAdi = $oyuncu['takimAdi'] ? $oyuncu['takimAdi'] : 'YOK';
                     ?> 
                    
                    <form method="post" action="oyuncu-yonet.php">
                        <input type="hidden" name="oyuncuID" value="<?php echo $oyuncu['oyuncuID']; ?>">
                        <tr>
                            <th scope="row"><?php echo $oyuncu['oyunTag'];  ?></th>
                            <td><?php echo $oyuncu['oyuncuKullaniciAdi']; ?></td>
                            <td><?php echo $oyuncu['oyuncuEtiketi']; ?></td>
                            <td><a style = "color:purple;" href = "takim-profil.php?takimID=<?php echo $oyuncu['takimID']; ?>"><?php echo $takimAdi; ?></a></td>
                            <td style = " display: flex; gap: 10px;"><button type="submit" class="btn btn-success" name="profileGit">Profile Git</button>
                    </form>
                    <?php    
                                        if($oyuncu['oyuncuTakimDurumu'] == 0){
                                            echo '
                                        <form method="post" action="takimbul.php">
                                            <input type="hidden" name="oyuncuKullaniciAdi" value=" '. $oyuncu['oyuncuKullaniciAdi'] .' ">        
                                            <input type="hidden" name="oyuncuID" value=" '. $oyuncu['oyuncuID']. ' ">      
                                            <input type="hidden" name="oyunID" value=" '. $oyuncu['oyunID'] .' ">
                                            <input type="hidden" name="oyunTag" value=" '. $oyuncu['oyunTag'] .' "> 
                                            <button type="submit" class="btn btn-info" name="takimBul">Takım Bul</button> 
                                        </form>
                                        <form method="post" action="takim-talep.php">
                                            <input type="hidden" name="oyuncuKullaniciAdi" value=" '. $oyuncu['oyuncuKullaniciAdi'] .' ">        
                                            <input type="hidden" name="oyuncuID" value=" '. $oyuncu['oyuncuID']. ' ">      
                                            <input type="hidden" name="oyunID" value=" '. $oyuncu['oyunID'] .' ">
                                            <input type="hidden" name="oyunTag" value=" '. $oyuncu['oyunTag'] .' "> 
                                            <button type="submit" class="btn btn-warning" name="takimKur">Takım Kur</button> 
                                        </form>';
                                        }
                                        else if($oyuncu['oyuncuTakimDurumu'] == 1){
                                            echo '<strong>Talep İnceleniyor</strong>';
                                        }
                                        else if($oyuncu['oyuncuTakimDurumu'] == 2)
                                        {
                                            $liderCek = $db->prepare("SELECT DISTINCT liderRolu FROM takimlideri
                                            WHERE takimID = :takimID AND oyuncuID = :oyuncuID ");
                                            $liderCek->bindParam(':takimID', $oyuncu['takimID'], PDO::PARAM_STR);
                                            $liderCek->bindParam(':oyuncuID', $oyuncu['oyuncuID'], PDO::PARAM_STR);
                
                                            $liderCek->execute();
                                            $lider = $liderCek->fetch(PDO::FETCH_ASSOC);
                                            
                                            if ($lider) {
                                                echo '<strong>Ayrılamazsın</strong>';
                                            }
                                            else {
                                                echo '
                                                <form method="post" action="">
                                                     <input type="hidden" name="oyuncuID" value=" '. $oyuncu['oyuncuID']. ' "> 
                                                    <button type="submit" class="btn btn-danger" name="takimAyril">Takımdan Ayrıl</button> 
                                                </form>';
                                            }
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