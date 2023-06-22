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



$oyuncuCek = $db->prepare("SELECT * FROM oyuncu o JOIN oyunlar u ON o.oyunID = u.oyunID WHERE uyeID = ?");
$oyuncuCek->execute([$uyeID]);
$oyuncular = $oyuncuCek->fetchAll(PDO::FETCH_ASSOC);

$oyuncuTalepleriCek = $db->prepare("SELECT * , o.oyunID FROM oyuncuonaytalep  t JOIN uye u ON t.uyeID = u.ID  JOIN oyunlar o ON o.oyunTag = t.oyun WHERE uyeID = ?  ORDER BY t.talepID DESC");
$oyuncuTalepleriCek->execute([$uyeID]);
$oyuncuTalepleri = $oyuncuTalepleriCek->fetchAll(PDO::FETCH_ASSOC);


?>


<head>
    <title>Oyuncu Profili | ScoutGG</title>
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
		.tab-pane {
			display: none;
		}
		.tab-pane.active {
			display: block;
		}
	</style>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!-- Bootstrap JS -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>

<body>
<div class="banner-section-outer">
<?php include("assets/header.php"); ?>
</div>

    <div style="background-image: url('./assets/images/home_banner_background.png'); height: 100vh; background-size: cover; background-position: center; padding: 20px; display: flex; flex-direction: column; align-items: center; height:80em;">
        <h1 style="color: #333; font-size: 60px; font-weight: bold;">Oyuncu Profili</h1>
        <p style="color: #fff; font-size: 35px; margin-bottom: 10px;">Hoşgeldin <?php echo $kullaniciAdi; ?></p>
        <div class="container mb-5" >
            <h2>Oyun Seç</h2>
            <ul class="nav nav-tabs">
            <?php foreach ($oyuncular as $i => $oyuncu): ?>
                <li class="nav-item">
                    <a class="nav-link <?php if($oyuncu['oyunID'] === ($selectedId ?? $oyuncular[0]['oyunID'])) echo 'active'; ?>" data-toggle="tab" href="#div<?php echo $oyuncu['oyunID']; ?>"><?php echo $oyuncu['oyunTag'] . " [" . $oyuncu['oyuncuKullaniciAdi'] . "]"; ?></a>
                </li>
            <?php endforeach; ?>
            </ul>

            <div class="tab-content">
            <?php foreach ($oyuncular as $oyuncu): ?>
                <div id="div<?php echo $oyuncu['oyunID']; ?>" class="tab-pane <?php if($oyuncu['oyunID'] === ($selectedId ?? $oyuncular[0]['oyunID'])) echo 'active'; ?>">
                    <?php 
                        echo "<p style = 'color:white;'> Oyun: " . $oyuncu['oyunTag'] . "</p>";
                        echo "<p style = 'color:white;'> Kullanıcı Adı: " . $oyuncu['oyuncuKullaniciAdi'] . "</p>";
                        echo "<p style = 'color:white;'> Oyuncu Etiket: " . $oyuncu['oyuncuEtiketi'] . "</p>";
                        echo "<p style = 'color:white;'> Oyuncu Takımı: " . $oyuncu['takimID'] . "</p>";
                        echo "<p style = 'color:white;'> Oyuncu Sıralaması: " . $oyuncu['oyuncuSiralama'] . "</p>";
                        echo "<p style = 'color:white;'> Oyuncu Rank: " . $oyuncu['oyuncuRank'] . "</p>";
                    ?>
                </div>
            <?php endforeach; ?>
            </div>
        </div>


        <div class="container mt-5">
            <h2>Taleplerin</h2>
            <ul class="nav nav-tabs">
            <?php foreach ($oyuncuTalepleri as $talepler): ?>
             <li class="nav-item">
                    <a class="nav-link <?php if($talepler['oyunID'] === $selectedId) echo 'active'; ?>" data-toggle="tab" href="#divt<?php echo $talepler['oyunID']; ?>"><?php echo $talepler['oyunTag'] . " [" . $talepler['kullaniciAdi'] . "]"; ?></a>
                </li>
            <?php endforeach; ?>
            </ul>

            <div class="tab-content">
            <?php foreach ($oyuncuTalepleri as $talepler): ?>
                <div id="divt<?php echo $talepler['oyunID']; ?>" class="tab-pane  <?php if($talepler['oyunID'] === $selectedId ) echo ' active'; ?>">
                    <?php 
                        if($talepler['onayDurum'] == 0){
                        $talepDurum = "Reddedildi.";
                        }
                        else if($talepler['onayDurum'] == 1){
                            $talepDurum = "İnceleniyor.";
                        }
                        else if($talepler['onayDurum'] == 2){
                            $talepDurum = "Onaylandı.";
                        }
                        else {
                            $talepDurum = "Belirsiz.";
                        }
                        echo "<p style = 'color:white;'> Oyun: " . $talepler['oyunTag'] . "</p>";
                        echo "<p style = 'color:white;'> Kullanıcı Adı: " . $talepler['kullaniciAdi'] . "</p>";
                        echo "<p style = 'color:white;'> Etiketi: " . $talepler['etiket'] . "</p>";
                        echo "<p style = 'color:white;'> Onayı: " . $talepDurum . "</p>";
                        echo '<p>Kanıt: </p><img style = "width:250px; height: 250px;" src ="assets/images/kanit/' . $talepler["kanit"] . '" alt="Profil Resmi ">';
                   
                    ?>
                </div>
            <?php endforeach; ?>
            </div>
        </div>

    </div>


   
	<script>
		$('.nav-tabs a').on('click', function (e) {
			e.preventDefault();
			$(this).tab('show');
		});
	</script>
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