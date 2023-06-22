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

// oyuncuID değeri session'a aktarılıyor.
if (isset($_POST['profileGit'])) {
    $oyuncuID = $_POST['oyuncuID'];
} else if (isset($_GET['oyuncuID'])) {
    $oyuncuID = $_GET['oyuncuID'];

} else {
    header("Location: oyunlarin.php");
    exit();   
}

/* if (!isset($_SESSION['oyuncuID'])) {
    header("Location: oyunlarin.php");
    exit();
} */

if (isset($_SERVER['HTTP_REFERER'])) {
    $_SESSION['previous_page'] = $_SERVER['HTTP_REFERER'];
}

if (isset($_SESSION['previous_page'])) {
    $oncekiSayfa = basename($_SESSION['previous_page']);
   
}
$oyuncuCek = $db->prepare("SELECT *, t.takimAdi FROM oyuncu o JOIN oyunlar u ON o.oyunID = u.oyunID LEFT JOIN takimlar t ON o.takimID = t.takimID WHERE o.oyuncuID = ?");
$oyuncuCek->execute([$oyuncuID]);
$oyuncu = $oyuncuCek->fetch(PDO::FETCH_ASSOC);

?>
<head>
    <title>  <?php echo $oyuncu['oyuncuKullaniciAdi']; ?> | ScoutGG</title>
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
        
    </style>

    </head>
<body>
<div class="banner-section-outer">
<?php include("assets/header.php"); ?>


    <div class = "container" style="height: 100vh; background-size: cover; background-position: center; padding: 20px; display: flex; flex-direction: column; align-items: center; height:50em;">

        <div  class = "container">
                         <?php   
                            if ($oyuncu)
                            {
                            ?>    
                            <h3 style="color: white;  font-weight: bold;">Oyuncu Profili -> <?php echo $oyuncu['oyuncuKullaniciAdi']; ?> </h3>
                            <?php 
                            }
                            else
                            {
                                echo '<strong style = "color:white;">Oyuncu Bulunamadı</strong><br/>';
                            }
                            ?>
              <label style="color: white; font-weight: bold;"><a href="<?php echo $_SESSION['previous_page']; ?>">Geldiğin sayfaya geri dönmek için tıkla. </a> </label>
        </div>
       
        <div class= "row">
        <div class= "col-md-12">
            <table class="table">
                     <thead class="thead-dark">
                    <tr>
                    <th scope="col">Oyun</th>
                    <th scope="col">Kullanıcı Adı</th>
                    <th scope="col">Takım</th>
                    <th scope="col">Etiket</th>
                    <th scope="col">Sıralama</th>
                    <th scope="col">Rank</th>
                    </tr>
                </thead>
                <tbody>    
             
                        <tr> 
                            <?php 
                            
                            if ($oyuncu)
                            {
                            ?>              
                             <th scope="row"><?php echo   $oyuncu['oyunTag']; ?></th>
                            <th scope="row"><?php echo  $oyuncu['oyuncuKullaniciAdi']; ?></th>
                            <th scope="row"><a href = "takim-profil.php?takimID=<?php echo $oyuncu['takimID']; ?>"><?php echo  $oyuncu['takimAdi']; ?></a></th>
                            <th scope="row"><?php echo  $oyuncu['oyuncuEtiketi']; ?></th>
                            <th scope="row"><?php echo   $oyuncu['oyuncuSiralama']; ?></th>
                            <th scope="row"><?php echo   $oyuncu['oyuncuRank']; ?></th>
                            <?php 
                            }
                            else
                            {
                                echo '<strong>Oyuncu Bulunamadı</strong>';
                            }
                            ?>
                        </tr>
            
                </tbody>
                </table>
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