<!DOCTYPE html>

<?php 
    include("assets/baglanti.php");
    
    if (isset($_SESSION['email'])) {
        header("Location: index.php");
        exit();
    }

    if(isset($_POST["olustur"])){
        $isim = $_POST["isim"];
        $soyIsim = $_POST["soyIsim"];
        $kadi = $_POST["kullaniciAdi"];
        $email = $_POST["email"];
        $sifre = $_POST["sifre"];
        $sifreTekrar = $_POST["sifreTekrar"];
        $dogumGun = $_POST["dogumGun"];
        $dogumAy = $_POST["dogumAy"]; 
        $dogumYil = $_POST["dogumYil"];
        $sozlesmeKontrol = isset($_POST["sozlesmeKontrol"]);

        try 
        {
            if(!$sozlesmeKontrol)
            {
                echo '<div class="alert alert-danger d-flex align-items-center mb-0" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <div class="col-12">Lütfen sözleşmeyi kabul edin.</div>
            </div>';;
            }
            else
            {
                $stmt = $db->prepare("SELECT * FROM uye WHERE KullaniciAdi = :kadi"); // kullanıcı adı sütununda bulunan değerleri çekiyoruz
                $stmt->execute([':kadi' => $kadi]); // değişken ile gelen verileri karşılaştırıyoruz ve sorgu çalıştırıyor (yukardaki where sorgusuna parametre gönderiyor)
                $result = $stmt->fetch(PDO::FETCH_ASSOC); // sonuçları result değişkenine aktarıyoruz
                if($result) 
                {
                  echo '<div class="alert alert-danger d-flex align-items-center mb-0" role="alert">
                  <i class="fas fa-exclamation-circle me-2"></i>
                  <div class="col-12">Bu kullanıcı adı zaten kullanılıyor.</div>
              </div>';
                } 
                else
                {

                    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) 
                    {
                        echo "Lütfen geçerli bir e-posta adresi girin.";
                    }
                    else{
                        $stmt = $db->prepare("SELECT * FROM uye WHERE Email = :email");
                        $stmt->execute([':email' => $email]);
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                        if($result)
                        {
                            echo '<div class="alert alert-danger d-flex align-items-center mb-0" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <div class="col-12">Bu e-posta adresi zaten kullanılıyor.</div>
                        </div>';
                        }                     
                        else 
                        {
                            if(!preg_match("/^[a-zA-ZŞşçÇÖöĞğÜüİı]+$/", $isim)){
                                echo '<div class="alert alert-danger d-flex align-items-center mb-0" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <div class="col-12">İsim sadece harflerden oluşmalıdır.</div>
                            </div>';    
                            }
                            else
                            {
                                if(!preg_match("/^[a-zA-ZŞşçÇÖöĞğÜüİı]+$/", $soyIsim))
                                {
                                    echo '<div class="alert alert-danger d-flex align-items-center mb-0" role="alert">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    <div class="col-12">Soyisim sadece harflerden oluşmalıdır.</div>
                                </div>';
                                }
                                else
                                {       
                                    if(strlen($sifre) < 8) {
                                        echo '<div class="alert alert-danger d-flex align-items-center mb-0" role="alert">
                                        <i class="fas fa-exclamation-circle me-2"></i>
                                        <div class="col-12">Şifre en az 8 karakter olmalıdır.</div>
                                    </div>';
                                    } elseif(!preg_match("/[A-Z]/", $sifre)) { // Büyük harf kontrolü preg_match() fonksiyonu verdiğimiz değeri değişken içerisinde ilk eşleşeni döndürür
                                        echo '<div class="alert alert-danger d-flex align-items-center mb-0" role="alert">
                                        <i class="fas fa-exclamation-circle me-2"></i>
                                        <div class="col-12">Şifre en az 1 harf içermelidir.</div>
                                    </div>';
                                    } 
                                    else if(!preg_match("/[0-9]/", $sifre)) { 
                                        echo '<div class="alert alert-danger d-flex align-items-center mb-0" role="alert">
                                        <i class="fas fa-exclamation-circle me-2"></i>
                                        <div class="col-12">Şifre en az bir rakam içermelidir.</div>
                                    </div>';
                                    }else if(!preg_match("/[.~!@#$%^&*()_+]/", $sifre)) {
                                        echo '<div class="alert alert-danger d-flex align-items-center mb-0" role="alert">
                                        <i class="fas fa-exclamation-circle me-2"></i>
                                        <div class="col-12">Şifre en az 1 özel karakter içermelidir.</div>
                                    </div>';
                                    }  
                                    else 
                                    {
                                        if($sifre != $sifreTekrar)
                                        {
                                            echo '<div class="alert alert-danger d-flex align-items-center mb-0" role="alert">
                                            <i class="fas fa-exclamation-circle me-2"></i>
                                            <div class="col-12">Şifreler eşleşmiyor.</div>
                                        </div>';   
                                        }
                                        else
                                        {                                       
                                            $hashed_sifre = password_hash($sifre, PASSWORD_DEFAULT);
                                            $kaydet = $db->prepare("INSERT INTO uye (KullaniciAdi, Sifre, Email, Ismi, Soyismi, DogumTarihi) VALUES (:kadi, :sifre, :email, :isim, :soyIsim, :dogumTarihi)");
                                            $kaydet->bindParam(':kadi', $kadi, PDO::PARAM_STR);
                                            $kaydet->bindParam(':sifre', $hashed_sifre, PDO::PARAM_STR);
                                            $kaydet->bindParam(':email', $email, PDO::PARAM_STR);
                                            $kaydet->bindParam(':isim', $isim, PDO::PARAM_STR);
                                            $kaydet->bindParam(':soyIsim', $soyIsim, PDO::PARAM_STR);
                                            $dogumTarihi = $dogumYil.'-'.$dogumAy.'-'.$dogumGun;
                                            $kaydet->bindParam(':dogumTarihi', $dogumTarihi, PDO::PARAM_STR);
                                            $kaydet->execute();
                                            echo '<div class="alert alert-success d-flex align-items-center mb-0" role="alert">
                                                <i class="fas fa-check-circle me-2"></i>
                                                <div class="col-12">Kayıt Başarılı</div>
                                            </div> ';

                                        }
                                    }
                                }    
                            }    
                        } 
                    }
                } 
            }    

        } 
        catch(PDOException $e)
        {
            echo'<div class="alert alert-danger d-flex align-items-center mb-0" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <div class="col-12">Bir sorun oluştu</div>
        </div>';
        }
        $db = null;   
    }            


    
?>
<html lang="tr">

<head>
    <title>Kayıt Ol | Scout GG</title>
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
<!-- SIGN UP FORM SECTION -->
<section class="login-form sign-up-form d-flex align-items-center">
    <div class="container">
        <div class="login-form-title text-center">
            <a href="index.php">
            <figure class="login-page-logo">
                <img src="./assets/images/crox_logo.png" alt="">
            </figure>
            </a>
            <h2 class="text-white">ÜCRETSİZ ÜYELİK OLUŞTUR</h2>
        </div>
        <div class="login-form-box">
            <div class="login-card">
                <form action="signup.php" method = "POST">
                    <div class="form-group">
                        <input  class="input-field form-control" type="text" name = "isim" id="kayitIsim" placeholder="İsim" required>
                    </div>
                    <div class="form-group">
                        <input  class="input-field form-control" type="text" name = "soyIsim" id="kayitSoyIsimsim" placeholder="Soy İsim" required>
                    </div>
                    <div class="form-group">
                        <input  class="input-field form-control" type="text" name = "kullaniciAdi" id="kayitKullaniciADi" placeholder="Kullanıcı Adı" required>
                    </div>
                    <div class="form-group">
                        <input  class="input-field form-control" type="email" name = "email" id="exampleInputEmail1" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <input  class="input-field form-control" type="password" name = "sifre"  id="exampleInputPassword1" placeholder="Şifre" required>
                    </div>
                    <div class="form-group">
                        <input  class="input-field form-control" type="password" name = "sifreTekrar"  id="exampleInputPassword1" placeholder="Şifreyi Tekrar Giriniz" required>
                    </div>
                    <div class="form-group  flex-wrap d-flex flex-row">
                   
                    <label class="col-md-12 text-danger" for="exampleInputEmail1">Doğum Tarihi</label>

                        <select id="inputNoncorehub" name ="dogumGun" class="input-field col-md-4 form-control select-option">
                        <option selected>Gün</option>
                        <script>
                            for (var i = 1; i <= 31; i++) {
                            document.write('<option value="' + i + '">' + i + '</option>');
                            }
                        </script>
                        </select>

                        <select id="inputNoncorehub" name ="dogumAy" class="input-field col-md-4  form-control select-option">
                        <option selected>Ay</option>
                          <option value="1">Ocak</option>
                          <option value="2">Şubat</option>
                          <option value="3">Mart</option>
                          <option value="4">Nisan</option>
                          <option value="5">Mayıs</option>
                          <option value="6">Haziran</option>
                          <option value="7">Temmuz</option>
                          <option value="8">Ağustos</option>
                          <option value="9">Eylül</option>
                          <option value="10">Ekim</option>
                          <option value="11">Kasım</option>
                          <option value="12">Aralık</option>
                        </select>

                        <select id="inputNoncorehub" name ="dogumYil" class="input-field col-md-4  form-control select-option">
                        <option selected>Yıl</option>
                         <script>
                              var year = new Date().getFullYear();
                             for (var i = year; i >= year - 100; i--) {
                             document.write('<option value="' + i + '">' + i + '</option>');
                             }
                         </script>
                        </select>
                    </div>

                    <div>
                    <label class="text-white font-weight-normal mb-md-4 mb-3" style="cursor: pointer;">
    <input class="checkbox" name="sozlesmeKontrol" type="checkbox" required>
    <a href="#" onclick="downloadDoc()">Sözleşmeyi okudum kabul ediyorum.</a>
</label>

<script>
    function downloadDoc() {
        // .docx dosyasının indirme işlemi için bir link oluşturulur
        var link = document.createElement('a');
        link.href = "./assets/images/kvkk.docx"; // .docx dosyasının doğru yolunu buraya ekleyin
        link.download = 'kvkk.docx'; // İndirilen dosyanın adı
        link.click();
    }
</script>


                    </div>
                    <button type="submit" name = "olustur" class="hover-effect btn btn-primary mb-0">Kaydı Tamamla</button>
                </form>
            </div>
            <div class="join-now-outer text-center">
                <a class="text-white" href="login.php">Zaten bir hesabım var.</a>
            </div>
        </div>   
    </div>
</section>
<!-- Latest compiled JavaScript -->
<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js"></script>
<script src="assets/js/bootstrap.min.js"> </script>
<script src="assets/js/custom.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="assets/js/owl.carousel.js"></script>
<script src="assets/js/carousel.js"></script>
<script src="assets/js/video-section.js"></script>
<script src="assets/js/animation.js"></script>
<script src="assets/js/counter.js"></script>
</body>
</html>