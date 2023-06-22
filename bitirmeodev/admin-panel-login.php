<!DOCTYPE html>

<html lang="tr">
<?php
include("assets/baglanti.php"); 
if (isset($_SESSION['YoneticiID'])) {
    header("Location: assets/admin/index.php");
    exit();
}

if ($_SESSION['YoneticiRolu'] < 3) {
    header("Location: index.php");
}

if(isset($_POST["giris"])){
       

    $sifre = $_POST["sifre"];

    try
    {
        $stmt = $db->prepare("SELECT * FROM yonetici WHERE uyeID = :uyeid AND yoneticiSifre=:sifre");
        $stmt->bindParam(':sifre', $sifre);
        $stmt->bindParam(':uyeid', $_SESSION['UyeID']);
        $stmt->execute();

        $count = $stmt->rowCount();

        if ($count == 1) 
        {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['YoneticiID'] = $row['YoneticiID'];
            $_SESSION['YoneticiRolu'] = $row['YoneticiRolu'];
            header("Location: ./assets/admin/");

        }
    }
    catch(PDOException $e)
    {
        echo'<div class="alert alert-danger" role="alert">
        Bir Sorun Oluştu! ' . $e->getMessage() .'
        </div>';  
              
    }
}

?>
<head>
    <title>Admin Giriş | Scout GG</title>
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
</head>

<body>
<!-- LOGIN FORM SECTION -->
<section class="login-form d-flex align-items-center">
    <div class="container">
        <div class="login-form-title text-center">
            <a href="index.html">
            <figure class="login-page-logo">
                <img src="./assets/images/crox_logo.png" alt="">
            </figure>
            </a>
            <h2 class="text-white">Hoşgeldin <?php echo $_SESSION['KullaniciAdi']; ?>!</h2>
        </div>
        <div class="login-form-box">
            <div class="login-card">
                <form action="" method = "POST">

                    <div class="form-group">
                        <input  class="input-field form-control" name = "sifre" type="password" id="exampleInputPassword1" placeholder="Yönetici Şifresini Girin" required>
                    </div>
                    <button type="submit" name="giris" class="btn btn-primary hover-effect">Yönetici Giriş</button>
                    <div>
                     <!--   <label class="text-white font-weight-normal mb-0" style="cursor: pointer;">
                        <input class="checkbox" type="checkbox" name="userRememberMe" >
                        Beni Hatırla
                        </label> -->
                        <a href="#" class="forgot-password float-right">Şifreni mi unuttun?</a>
                    </div>
                </form>
            </div>

        </div>   
    </div>
</section>
<!-- Latest compiled JavaScript -->
<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/custom.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="assets/js/owl.carousel.js"></script>
<script src="assets/js/carousel.js"></script>
<script src="assets/js/video-section.js"></script>
<script src="assets/js/animation.js"></script>
<script src="assets/js/counter.js"></script>
</body>
</html>