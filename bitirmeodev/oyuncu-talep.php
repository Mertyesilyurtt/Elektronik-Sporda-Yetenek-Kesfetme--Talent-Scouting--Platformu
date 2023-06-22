<!DOCTYPE html>

<?php 
    include("assets/baglanti.php");
    if (!isset($_SESSION['email'])) {
        header("Location: index.php");
        exit();
    }

    //$uyeID = $uyeBilgileriCek['ID'];
    $stmt1 = $db->prepare("SELECT * FROM oyuncuonaytalep WHERE uyeID = :uyeID");
    $stmt1->bindParam(':uyeID', $_SESSION['UyeID']);
    $stmt1->execute();
    $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);


    if(isset($_POST["olustur"])){

        $kadi = $_POST["kadi"];
        $etiket = $_POST["etiket"];
        $discord = $_POST["discord"];
        $oyunSec = $_POST["oyunSec"];
        $sozlesmeKontrol = isset($_POST["sozlesmeKontrol"]);


        $email = $_SESSION['email'];
        $stmt = $db->prepare("SELECT * FROM uye WHERE Email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $uyeID = $result['ID'];
        try 
        {
            if(!$sozlesmeKontrol)
            {
                echo "Lütfen sözleşmeyi kabul edin.";
            }
            else
            {
                $stmt = $db->prepare("SELECT * FROM oyuncu WHERE OyuncuKullaniciAdi = :kadi OR OyuncuEtiketi = :etiket");
                $stmt->execute([':kadi' => $kadi, ':etiket' => $etiket]); 
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if($result) 
                {
                  echo "Bu kullanıcı zaten mevcut.";
                } 
                else
                {
                                if(!preg_match("/^[0-9]+$/", $etiket))
                                {
                                    echo "Etiket sadece harflerden oluşmalıdır."; 
                                }
                                
                                    else
                                    { 
                                        if(!preg_match("/^[0-9]+$/", $etiket))
                                        {
                                            echo "Etiket sadece harflerden oluşmalıdır."; 
                                        }
                                        
                                        else
                                        {       
                                        
                                            if (isset($_POST['olustur'])) 
                                            {
                                                // Dosya yükleme işlemi
                                                $hedef_klasor = 'assets/images/kanit/';
                                                $izin_verilen_uzantilar = array('jpg', 'jpeg', 'png');
                                                $dosya_adi = $_FILES['kanitSec']['name'];
                                                $dosya_uzantisi = strtolower(pathinfo($dosya_adi, PATHINFO_EXTENSION));
                                            
                                                if (in_array($dosya_uzantisi, $izin_verilen_uzantilar)) {
                                                $rastgele_isim = uniqid() . '.' . $dosya_uzantisi;
                                                $hedef_yol = $hedef_klasor . $rastgele_isim;
                                                if (move_uploaded_file($_FILES['kanitSec']['tmp_name'], $hedef_yol)) {
                                                    // Dosya yükleme işlemi başarılı
                                                    $kaydet = $db->prepare("INSERT INTO oyuncuonaytalep (kullaniciAdi, uyeID ,etiket, kanit, oyun, discordHesap) VALUES (:kadi, :uyeID, :etiket, :kanit, :oyun, :discordHesap)");
                                                    $kaydet->bindParam(':kadi', $kadi, PDO::PARAM_STR);
                                                    $kaydet->bindParam(':uyeID', $uyeID, PDO::PARAM_STR);
                                                    $kaydet->bindParam(':etiket', $etiket, PDO::PARAM_STR);
                                                    $kaydet->bindParam(':kanit', $rastgele_isim, PDO::PARAM_STR);
                                                    $kaydet->bindParam(':oyun', $oyunSec, PDO::PARAM_STR);
                                                    $kaydet->bindParam(':discordHesap', $discord, PDO::PARAM_STR);
                                                    $kaydet->execute();
                                                    echo '<div class="alert alert-success" role="alert">
                                                        Kayıt Başarılı
                                                    </div>';
                                                    header("Location: oyuncu-talep.php");
                                                    // Veritabanı güncelleme işlemi tamamlandı
                                                } else {
                                                    // Dosya yükleme işlemi başarısız
                                                }
                                                } else {
                                                // Dosya uzantısı izin verilenler listesinde değil
                                                }
                                            }
                                                else
                                                {                                       

                                                }
                                            
                                         } 
                                    }
                    
                } 
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
<html lang="tr">

<head>
    <title>Oyuncu Ol | Scout GG</title>
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

<section class=" d-flex align-items-center">
    <div class="container"> 
</div>
</section>


<section class="login-form sign-up-form d-flex align-items-center">
    <div class="container">
        <div class="alert alert-primary" role="alert" data-toggle="collapse" data-target="#demo">
            <?php $talepAdet = $stmt1->rowCount(); 
            echo '<a href="#" class="text-dark text-decoration-none" ><strong>'. $talepAdet.'</strong> Adet kayıtlı talebiniz 
            bulunmaktadır. Talep durumlarını öğrenmek için tıklayınız.</a>';
            ?>
        </div>
        <div id="demo" class="login-form-title collapse text-center">
        <?php 
            if ($talepAdet == 0) {

                echo '<div class="alert alert-danger" role="alert">
                    Hİç oyuncu olma talebi göndermediniz!!!!!
                </div>';
            }
            else
            {              
               $incelenenSayisi = 0;
                foreach ($result1 as $row) {
                    if ($row['onayDurum'] == 0) {
                     $incelenenSayisi++;
                     $incelenenVeriler[] = $row;
                    }
                }
                if($incelenenSayisi > 0)
                {      
                echo '<div class="alert alert-warning" role="alert">
                Toplam <strong>' .$incelenenSayisi. ' </strong> adet talebiniz inceleniyor. <br/>';
                foreach ($incelenenVeriler as $row) {

                    echo "Talep ID:".$row['talepID'] ."<br/>";
                    echo "Kullanıcı Adı:".$row['kullaniciAdi'] ."<br/>";
                    echo "Etiket:".$row['etiket'] ."<br/>";
                    echo "Oyun:".$row['oyun'] ."<br/>";
                    echo "Discord Hesabı:".$row['discordHesap'] ."<br/>";
                    echo "Onay Durumu: İnceleniyor <br/> <hr>";

                  }
                echo '</div>';
                }

                $onaylananSayisi = 0;
                foreach ($result1 as $row) {
                    if ($row['onayDurum'] == 2) {
                     $onaylananSayisi++;
                     $onaylananVeriler[] = $row;
                    }
                }
                if($onaylananSayisi > 0)
                {      
                echo '<div class="alert alert-success" role="alert">
                TEBRİKLER!!!! Toplam <strong>' .$onaylananSayisi. ' </strong> adet talebiniz Onaylandı. <br/>';
                foreach ($onaylananVeriler as $row) {

                    echo "Talep ID: ".$row['talepID'] ."<br/>";
                    echo "Kullanıcı Adı: ".$row['kullaniciAdi'] ."<br/>";
                    echo "Etiket: ".$row['etiket'] ."<br/>";
                    echo "Oyun: ".$row['oyun'] ."<br/>";
                    echo "Discord Hesabı:".$row['discordHesap'] ."<br/>";
                    echo "Onay Durumu: ONAYLANDI <br/> <hr>";

                  }
                echo '</div>';
                }

                $redSayisi = 0;
                foreach ($result1 as $row) {
                    if ($row['onayDurum'] == 1) {
                     $redSayisi++;
                     $redVeriler[] = $row;
                    }
                }
                if($redSayisi > 0)
                {      
                echo '<div class="alert alert-danger" role="alert">
                Toplam <strong>' .$redSayisi. ' </strong> adet talebiniz reddedildi. <br/>';
                foreach ($redVeriler as $row) {

                    echo "Talep ID: ".$row['talepID'] ."<br/>";
                    echo "Kullanıcı Adı: ".$row['kullaniciAdi'] ."<br/>";
                    echo "Etiket: ".$row['etiket'] ."<br/>";
                    echo "Oyun: ".$row['oyun'] ."<br/>";
                    echo "Discord Hesabı:".$row['discordHesap'] ."<br/>";
                    echo "Onay Durumu: REDDEDİLDİ <br/> <hr>";

                  }
                echo '</div>';
                }

            }
        
        ?>
    </div>

        <div class="login-form-title text-center">
            <a href="index.php">
            <figure class="login-page-logo">
                <img src="./assets/images/crox_logo.png" alt="">
            </figure>
            </a>
            <h2 class="text-white">Oyuncu Profini OLUŞTUR</h2>
        </div>
        <div class="login-form-box">
            <div class="login-card">
                <form method="post" action="" enctype="multipart/form-data">
                     <div class="form-group">
                        <?php
                            $oyunlarSorgusu = "SELECT oyunTag FROM oyunlar";
                            $durum = $db->prepare($oyunlarSorgusu);
                            $durum->execute();
                        echo'
                        <select  name ="oyunSec" class="input-field form-control select-option">
                        <option disabled value="" selected>Oyun Seç</option>';
                        while ($row = $durum->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $row['oyunTag'] . "'>" . $row['oyunTag'] . "</option>";
                        }
                        
                        echo '</select>';
                        ?>
                    </div>
                    <div class="form-group">
                        <input  class="input-field form-control" type="text" name = "discord" id="kayitIsim" placeholder="Discord Hesabı Giriniz: (örn: Myre#0000)" required>
                    </div>
                    <div class="form-group">
                        <input  class="input-field form-control" type="text" name = "kadi" id="kayitIsim" placeholder="Kullanıcı Adı" required>
                    </div>
                    <div class="form-group">
                        <input  class="input-field form-control" type="text" name = "etiket" id="kayitIsim" placeholder="Oyundaki Etiketinizi Giriniz" required>
                    </div>
                    <div class="form-group ">
                        <label for="kanitSec" class="form-label text-danger" class="text-danger">Kanıt:</label>
                        <input class="form-control form-control-sm" id="kanitSec" style = "color:purple;" type="file" name="kanitSec">
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
                    <div>
                        <label class="text-white font-weight-normal mb-md-4 mb-3" style="cursor: pointer;">
                        <input class="checkbox" name = "hesapKontrol" type="checkbox" required>
                             Hesabın sahibi olduğumu kabul ediyorum.
                        </label>
                    </div>
                    <button type="submit" name = "olustur" class="hover-effect btn btn-primary mb-0">Kaydı Tamamla</button>
                </form>
            </div>
            <!-- <div class="join-now-outer text-center">
                <a class="text-white" href="login.html">Zaten bir hesabım var.</a>
            </div>  -->
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