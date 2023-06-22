<!doctype html>

<?php
include("../../baglanti.php"); 
if (!isset($_SESSION['YoneticiID'])) {
    
    header("Location: ../../index.php");
}

$uyeID = $_SESSION['UyeID'];

$gorusmeOnaylanmamisDurum = 2;
$gorusmeBaslatildiDurum = 3;

  $gorusmeleriCek = $db2->prepare("SELECT COUNT(*) as gorusmeSayisi FROM espor_mesajlar_db.gorusme g JOIN  espor_db.yonetici y ON g.sorumluAdmin = y.yoneticiID WHERE gorusmeOnayDurum = :gorusmeOnayDurum  OR gorusmeOnayDurum = :gorusmeBaslatildiDurum  AND y.UyeID = :UyeID");
  $gorusmeleriCek->bindParam(':gorusmeOnayDurum', $gorusmeOnaylanmamisDurum);
  $gorusmeleriCek->bindParam(':gorusmeBaslatildiDurum', $gorusmeBaslatildiDurum);
  $gorusmeleriCek->bindParam(':UyeID', $uyeID);
  $gorusmeleriCek->execute();
  $gorusmeSayisi = $gorusmeleriCek->fetch(PDO::FETCH_ASSOC)['gorusmeSayisi'];
  
  // Sayfa sayısını hesapla
  $limit = 10;
  $sayfa_sayisi = ceil($gorusmeSayisi / $limit);
  
  // Hangi sayfadayız
  $sayfa = isset($_GET['sayfa']) ? (int)$_GET['sayfa'] : 1;
  $sayfa = max(1, min($sayfa, $sayfa_sayisi));
  
  // LIMIT ve OFFSET değerlerini hesapla
  $offset = ($sayfa - 1) * $limit;
  

  $gorusmeSorgusu = $db2->prepare("SELECT g.* , t.takimAdi , u1.KullaniciAdi AS gonderenKullaniciAdi, u2.KullaniciAdi AS aliciKullaniciAdi FROM espor_mesajlar_db.gorusme g
  JOIN espor_db.uye u1 ON g.gonderenID = u1.ID
  JOIN espor_db.uye u2 ON g.aliciID = u2.ID 
  JOIN espor_db.takimlar t ON g.takimID = t.takimID
  JOIN  espor_db.yonetici y ON g.sorumluAdmin = y.yoneticiID WHERE (y.UyeID = :UyeID AND (g.gorusmeOnayDurum = :gorusmeOnayDurum  OR g.gorusmeOnayDurum = :gorusmeBaslatildiDurum)) ORDER BY g.gorusmeOnayDurum = 3 DESC LIMIT :limit OFFSET :offset");
  $gorusmeSorgusu->bindParam(':gorusmeOnayDurum', $gorusmeOnaylanmamisDurum);
  $gorusmeSorgusu->bindParam(':gorusmeBaslatildiDurum', $gorusmeBaslatildiDurum);
  $gorusmeSorgusu->bindParam(':UyeID', $uyeID);
  $gorusmeSorgusu->bindParam(':limit', $limit, PDO::PARAM_INT);
  $gorusmeSorgusu->bindParam(':offset', $offset, PDO::PARAM_INT);
  $gorusmeSorgusu->execute();
  $gorusmeler = $gorusmeSorgusu->fetchAll(PDO::FETCH_ASSOC);



  if (isset($_POST['gorusmeReddet'])) {

    $gorusmeID = $_POST['gorusmeID'];
    $adminMesaj = $_POST['adminMesaj'];
    $onayDurum = 1;
  
    $gorusmeReddet = $db2->prepare("UPDATE gorusme SET gorusmeOnayDurum=:gorusmeOnayDurum, adminMesaj = :adminMesaj WHERE gorusmeID=:gorusmeID");
    $gorusmeReddet->bindParam(':gorusmeID', $gorusmeID);
    $gorusmeReddet->bindParam(':adminMesaj', $adminMesaj);
    $gorusmeReddet->bindParam(':gorusmeOnayDurum', $onayDurum);
    $gorusmeReddet->execute();
    echo '<script>alert("Görüşme olumsuz olarak bitirildi.");
          window.location.href = "gorusmetalepleri.php";
    </script>';
}

if (isset($_POST['gorusmeBaslat'])) {

  $gorusmeID = $_POST['gorusmeID'];
  $adminMesaj = $_POST['adminMesaj'];
  $onayDurum = 3;

  $gorusmeReddet = $db2->prepare("UPDATE gorusme SET gorusmeOnayDurum=:gorusmeOnayDurum, adminMesaj = :adminMesaj WHERE gorusmeID=:gorusmeID");
  $gorusmeReddet->bindParam(':gorusmeID', $gorusmeID);
  $gorusmeReddet->bindParam(':adminMesaj', $adminMesaj);
  $gorusmeReddet->bindParam(':gorusmeOnayDurum', $onayDurum);
  $gorusmeReddet->execute();
  echo '<script>alert("Görüşme Başlatıldı.");
        window.location.href = "gorusmetalepleri.php";
  </script>';
}

if (isset($_POST['gorusmeOnayla'])) {

  $gorusmeID = $_POST['gorusmeID'];
  $oyuncuID = $_POST['oyuncuID'];
  $takimID = $_POST['takimID'];
  $adminMesaj = $_POST['adminMesaj'];
  $onayDurum = 4;
  $oyuncuTakimDurumu = 2;

  $gorusmeOnayla = $db2->prepare("UPDATE gorusme SET gorusmeOnayDurum=:gorusmeOnayDurum, adminMesaj = :adminMesaj WHERE gorusmeID=:gorusmeID");
  $gorusmeOnayla->bindParam(':gorusmeID', $gorusmeID);
  $gorusmeOnayla->bindParam(':adminMesaj', $adminMesaj);
  $gorusmeOnayla->bindParam(':gorusmeOnayDurum', $onayDurum);
  $gorusmeOnayla->execute();

  $takimaEkle = $db->prepare("UPDATE oyuncu SET oyuncuTakimDurumu=:oyuncuTakimDurumu, takimID = :takimID WHERE oyuncuID=:oyuncuID");
  $takimaEkle->bindParam(':oyuncuTakimDurumu', $oyuncuTakimDurumu);
  $takimaEkle->bindParam(':takimID', $takimID);
  $takimaEkle->bindParam(':oyuncuID', $oyuncuID);
  $takimaEkle->execute();

  echo '<script>alert("Oyuncu takıma eklendi.");
        window.location.href = "gorusmetalepleri.php";
  </script>';


}

if(isset($_GET['talepID'])) {
  $talepID = $_GET['talepID'];
  $gorusmeOnaylanmamisDurum = 2;
  $gorusmeBaslatildiDurum = 3;
  $gorusmeSorgusu = $db->prepare("SELECT g.* , t.takimAdi , u1.KullaniciAdi AS gonderenKullaniciAdi, u2.KullaniciAdi AS aliciKullaniciAdi FROM espor_mesajlar_db.gorusme g
  JOIN espor_db.uye u1 ON g.gonderenID = u1.ID
  JOIN espor_db.uye u2 ON g.aliciID = u2.ID 
  JOIN espor_db.takimlar t ON g.takimID = t.takimID
  JOIN  espor_db.yonetici y ON g.sorumluAdmin = y.yoneticiID WHERE (talepID = :talepID AND (y.UyeID = :UyeID AND (g.gorusmeOnayDurum = :gorusmeOnayDurum  OR g.gorusmeOnayDurum = :gorusmeBaslatildiDurum)))");
  $gorusmeSorgusu->bindParam(':talepID', $talepID, PDO::PARAM_INT);
  $gorusmeSorgusu->bindParam(':gorusmeOnayDurum', $gorusmeOnaylanmamisDurum);
  $gorusmeSorgusu->bindParam(':gorusmeBaslatildiDurum', $gorusmeBaslatildiDurum);
  $gorusmeSorgusu->execute();
  $gorusmeler = $gorusmeSorgusu->fetchAll(PDO::FETCH_ASSOC);

}
  

?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Yönetim Paneli · ScoutGG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sidebars/">
    <script src="https://kit.fontawesome.com/d530c4dc6c.js" crossorigin="anonymous"></script>
    

    <!-- Bootstrap core CSS -->
<link href="../bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
      tr {
       background-color: #330033;
       color:white;
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

    .nav a:hover {
      background: #051414;
    }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="../sidebars.css" rel="stylesheet">
  </head>

<body>


<nav class="navbar navbar-expand-sm navbar-dark bg-dark col-sm-12  ">
    
  <div class="container-fluid">
  <a href="../../../index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
    <i class="fa-solid fa-gear fa-2xl m-2"></i>
      <span class="fs-4"> Yönetici Paneli</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse offset-sm-1" id="mynavbar">
    <ul class="navbar-nav me-auto">
        <!--   <li class="nav-item">
          <a class="nav-link" href="javascript:void(0)">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="javascript:void(0)">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="javascript:void(0)">Link</a>
        </li>-->
      </ul>
      <form class="d-flex" action="" method="GET">
        <input class="form-control me-2" name="talepID" type="text" placeholder="Talep ID girin">
        <input type="submit" value="Ara" class="btn btn-primary">
        
      </form>
      <button class="btn btn-danger m-2" onclick="yenile()">Sıfırla</button>
       <script>
          function yenile() {
            var url = window.location.href;
            var cleanURL = url.replace(/[?&]talepID=\d+/, ''); // oyuncuID parametresini temizler

            window.location.href = cleanURL;
          }
        </script>
    </div>
  </div>
</nav>

    <main class = "row" style = "background-color:#000d1a;">

    <div class="d-flex flex-column flex-shrink-0 p-3 pt-0 text-white bg-dark  col-sm-3 col-md-2  " >

    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item">
        <a href="../index.php" class="nav-link text-white " aria-current="page">
        <i class="fa-solid fa-igloo me-2"></i>
          Ana sayfa
        </a>
      </li>
      <li>
        <a href="uyelistesi.php" class="nav-link  text-white ">
        <i class="fa-solid fa-users me-2"></i>
            Üye Listesi
        </a>
      </li>
      <li>
        <a href="oyuncutalepleri.php" class="nav-link text-white">
        <i class="fa-solid fa-clipboard-user me-2"></i>
          Oyuncu Olma Talepleri
        </a>
      </li>
      <li>
        <a href="takimtalepleri.php" class="nav-link text-white">
        <i class="fa-solid fa-people-group me-2"></i>
          Takım Kurma Talepleri
        </a>
      </li>
      <li>
        <a href="oyunculistesi.php" class="nav-link text-white">
        <i class="fa-solid fa-gamepad me-2"></i>
          Oyuncu Listesi
        </a>
      </li>
      <li>
        <a href="takimlistesi.php" class="nav-link text-white ">
        <i class="fa-solid fa-arrows-down-to-people me-2"></i>
          Takım Listesi
        </a>
      </li>
      <li>
        <a href="gorusmetalepleri.php" class="nav-link active ">
        <i class="fa-solid fa-comments me-2"></i>
          Görüşme Talepleri
        </a>
      </li>
      <li>
        <a href="gelenmesajlar.php" class="nav-link text-white ">
        <i class="fa-solid fa-envelope-open-text  me-2"></i>
          Gelen Mesajlar
        </a>
      </li>
    </ul>
    <ul class="nav flex-column">
        <li class="mt-auto">
            <a href="../../../index.php" class="nav-link text-white">
            <i class="fa-solid fa-circle-arrow-left me-2"></i>
                Siteye Dön
            </a>
        </li>
    </ul>
    <hr>
    <div class="dropdown">
      <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
        <strong><?php echo $_SESSION["KullaniciAdi"]?></strong>
      </a>
      <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
        <li><a class="dropdown-item" href="#">İtem1</a></li>
        <li><a class="dropdown-item" href="#">İtem2</a></li>
        <li><a class="dropdown-item" href="#">İtem3</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="#">İtem4</a></li>
      </ul>
    </div>
  </div>

  <div class="b-example-divider"> </div>

  <div class="col-sm-8 col-md-9 row m-2 mt-4" style="height: 10em;">



  <div  class = "container">
                <h1 style="color: white; font-size: 60px; font-weight: bold;">Görüşme Talepleri</h1>
                <table class="table">
                     <thead class="thead-dark">
                    <tr>
                    <th scope="col">Görüşme ID</th>
                    <th scope="col">Görüşme Türü</th>
                    <th scope="col">Görüşme Onayı</th>
                    <th scope="col">Gönderen </th>
                    <th scope="col">Alıcı </th>
                    <th scope="col">Detaylar </th>
                    <th scope="col">Tarih </th>
                    <th scope="col">İşlemler </th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($gorusmeler as $gorusme): 
                  
                  if($gorusme['gorusmeTuru'] == 0){
                    $gorusmeTuru = "Takıma katılma isteği";
                  }  
                  else if($gorusme['gorusmeTuru'] == 1){
                    $gorusmeTuru = "Takıma davet isteği";
                  }  
                  else{
                    $gorusmeTuru = "Tanımlanamadı...";
                  }
                  if($gorusme['gorusmeOnayDurum'] == 0){
                    $gorusmeOnayDurum = "<label class = 'text-primary'> Beklemede </label>";
                  }  
                  else if($gorusme['gorusmeOnayDurum'] == 1){
                    $gorusmeOnayDurum = "<label class = 'text-danger'> Görüşme başarısızlıkla sonlandırıldı. </label>";
                      
                  }  
                  else if($gorusme['gorusmeOnayDurum'] == 2){
                    $gorusmeOnayDurum = "<label class = 'text-warning'> Görüşme talebi </label>";
          
                  } 
                  else if($gorusme['gorusmeOnayDurum'] == 3){
                    $gorusmeOnayDurum = "<label class = 'text-info'> Görüşme Başladı </label>";
          
                  }  
                  else if($gorusme['gorusmeOnayDurum'] == 4){
                    $gorusmeOnayDurum = "<label class = 'text-success'> Görüşme başarı ile sonlandırıldı. </label>";
          
                  }  
                  else {
                    $gorusmeOnayDurum = "<label class = 'text-secondary'> Tanımlanmadı... </label>";
                  }
                  
                  ?>
                        <tr>
                            <th scope="row"><?php echo $gorusme['gorusmeID'];  ?></th>
                            <td><?php echo $gorusmeTuru; ?></td>
                            <td><?php echo $gorusmeOnayDurum; ?></td>
                            <td><?php echo $gorusme['gonderenKullaniciAdi']; ?></td>
                            <td><?php echo $gorusme['aliciKullaniciAdi']; ?></td>
                            <td><?php echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#g'.$gorusme['gorusmeID'].'">Göster</button>'; ?></td>
                            <td><?php echo $gorusme['gorusmeTarih']; ?></td>
                            <td>    
                              <?php if($gorusme['gorusmeOnayDurum'] == 2){
                                  echo '<button type="button" class="btn btn-info m-2" data-bs-toggle="modal" data-bs-target="#b'.$gorusme['gorusmeID'].'">Başlat</button>';
                                  echo '<button type="button" class="btn btn-danger m-2" data-bs-toggle="modal" data-bs-target="#x'.$gorusme['gorusmeID'].'">Reddet</button>';
                                } 
                                if($gorusme['gorusmeOnayDurum'] == 3){
                                  echo '<button type="button" class="btn btn-success m-2" data-bs-toggle="modal" data-bs-target="#o'.$gorusme['gorusmeID'].'">Onayla</button>';
                                  echo '<button type="button" class="btn btn-danger m-2" data-bs-toggle="modal" data-bs-target="#x'.$gorusme['gorusmeID'].'">Reddet</button>';
                                } 
                              ?>
                            </td>

                        </tr>
                <?php 
                            echo '<div class="modal fade " id="g'.$gorusme['gorusmeID'].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <h5 class="modal-title text-danger" id="exampleModalLabel"> ' .$gorusme['gorusmeBasligi'].'</h5>
                                             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                           </div>
                                          <div class="modal-body">
                                            <div><strong>Mesaj: </strong><label> ' . $gorusme["gorusmeIcerik"] . '</label> </div>
                                            <div><strong>Gönderen Discord: </strong><label> ' . $gorusme["gonderenDiscordHesap"] . '</label> </div>
                                            <div> <strong>Alıcı Discord: </strong><label> ' . $gorusme["aliciDiscordHesap"] . '</label> </div>
                                            <div> <strong>Takım: </strong><label> ' . $gorusme["takimAdi"] . '</label> </div>
                                          </div>
                                        </div>
                                    </div>
                                   </div>'; 
                          
                                   echo '<div class="modal fade " id="b'.$gorusme['gorusmeID'].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                   <div class="modal-dialog">
                                     <div class="modal-content">
                                       <div class="modal-header">
                                         <h5 class="modal-title text-info" id="exampleModalLabel"> ' .$gorusme['gorusmeBasligi'].'  Başlıklı Görüşmeyi Başlat</h5>
                                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                       </div>
                                       <div class="modal-body">
                                       <label style="font-size: 22px; color: #000; margin-bottom: 10px;" for="rankSec">Mesajınız:</label>
                                    
                                        <form action = "" method = "post">
                                        <input type="hidden" name="gorusmeID" value="' . $gorusme['gorusmeID'] . '">
                                          <div class="mb-3">
                                            <textarea class="form-control" name = "adminMesaj" id="adminMesaj" rows="5"></textarea>
                                          </div>
                                          <button type="submit" name = "gorusmeBaslat" class="btn btn-info">Başlat</button>
                                        </form>
                                      </div>
                                     </div>
                                   </div>
                                 </div>'; 

                                 echo '<div class="modal fade " id="x'.$gorusme['gorusmeID'].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                 <div class="modal-dialog">
                                   <div class="modal-content">
                                     <div class="modal-header">
                                       <h5 class="modal-title text-danger" id="exampleModalLabel"> ' .$gorusme['gorusmeBasligi'].'  Başlıklı Görüşmeyi Reddet</h5>
                                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                     </div>
                                     <div class="modal-body">
                                     <label style="font-size: 22px; color: #000; margin-bottom: 10px;" for="rankSec">Mesajınız:</label>
                                  
                                      <form action = "" method = "post">
                                      <input type="hidden" name="gorusmeID" value="' . $gorusme['gorusmeID'] . '">
                                        <div class="mb-3">
                                          <textarea class="form-control" name = "adminMesaj" id="adminMesaj" rows="5"></textarea>
                                        </div>
                                        <button type="submit" name = "gorusmeReddet" class="btn btn-danger">Reddet</button>
                                      </form>
                                    </div>
                                   </div>
                                 </div>
                               </div>'; 


                               echo '<div class="modal fade " id="o'.$gorusme['gorusmeID'].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                               <div class="modal-dialog">
                                 <div class="modal-content">
                                   <div class="modal-header">
                                     <h5 class="modal-title text-success" id="exampleModalLabel"> ' .$gorusme['gorusmeBasligi'].'  Başlıklı Görüşmeyi Onayla</h5>
                                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                   </div>
                                   <div class="modal-body">
                                   <label style="font-size: 22px; color: #000; margin-bottom: 10px;" for="rankSec">Mesajınız:</label>
                                
                                    <form action = "" method = "post">
                                    <input type="hidden" name="gorusmeID" value="' . $gorusme['gorusmeID'] . '">
                                    <input type="hidden" name="gorusmeTuru" value="' . $gorusme['gorusmeTuru'] . '">
                                    <input type="hidden" name="oyuncuID" value="' . $gorusme['oyuncuID'] . '">
                                    <input type="hidden" name="takimID" value="' . $gorusme['takimID'] . '">
                                    <input type="hidden" name="gonderenID" value="' . $gorusme['gonderenID'] . '">
                                    <input type="hidden" name="aliciID" value="' . $gorusme['aliciID'] . '">
                                      <div class="mb-3">
                                        <textarea class="form-control" name = "adminMesaj" id="adminMesaj" rows="5"></textarea>
                                      </div>
                                      <button type="submit" name = "gorusmeOnayla" class="btn btn-success">Onayla</button>
                                    </form>
                                  </div>
                                 </div>
                               </div>
                             </div>'; 
              
              endforeach; ?>
                </tbody>
                </table>
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

 </main>


    <script src="../bootstrap.bundle.min.js"></script>

      <script src="../sidebars.js"></script>
  </body>