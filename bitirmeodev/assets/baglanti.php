<?php 

    $host = "localhost";
    $kullanici = "root";
    $sifre = "";
    $dbname = "espor_db";
    $dbname2 = "espor_mesajlar_db";

    try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $kullanici, $sifre);
    $db2 = new PDO("mysql:host=$host;dbname=$dbname2;charset=utf8", $kullanici, $sifre);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //  echo "Bağlantı başarılı"; 
    }
    catch(PDOException $e)
    {
    echo "Bağlantı hatası: " . $e->getMessage();
    die();
    }



    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    /* if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
        $uyeBilgileri = $db->prepare("SELECT * FROM uye WHERE Email = :email");
        $uyeBilgileri->bindParam(':email', $email);
        $uyeBilgileri->execute();
        $uyeBilgileriCek = $uyeBilgileri->fetch(PDO::FETCH_ASSOC);
        $kullaniciAdi = $uyeBilgileriCek['KullaniciAdi'];
        $uyeRol = $uyeBilgileriCek['rol'];

        $dgTarihi = new DateTime($uyeBilgileriCek['Dogumtarihi']); //DateTime sınıfına dönüştürüyoruz
        $bugun = new DateTime(); //bugünün tarihi
        $fark = $bugun->diff($dgTarihi); // iki tarih arasındaki farkı hesapla
        $yas = $fark->y; // fark yıl ay gün değerlerini tuttuğu için sadece y ile yıl bilgisini getir
        
    } */

?>