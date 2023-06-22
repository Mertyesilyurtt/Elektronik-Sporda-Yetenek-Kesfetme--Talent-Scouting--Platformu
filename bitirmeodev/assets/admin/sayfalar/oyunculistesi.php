<!doctype html>

<?php
include("../../baglanti.php"); 
if (!isset($_SESSION['YoneticiID'])) {
    
    header("Location: ../../index.php");
}

$uyeID = $_SESSION['UyeID'];


  $oyuncuCek = $db->prepare("SELECT COUNT(*) as oyuncuSayisi FROM oyuncu ");
  $oyuncuCek->execute();
  $oyuncuSayisi = $oyuncuCek->fetch(PDO::FETCH_ASSOC)['oyuncuSayisi'];
  
  // Sayfa sayısını hesapla
  $limit = 10;
  $sayfa_sayisi = ceil($oyuncuSayisi / $limit);
  
  // Hangi sayfa numarasındayız?
  $sayfa = isset($_GET['sayfa']) ? (int)$_GET['sayfa'] : 1;
  $sayfa = max(1, min($sayfa, $sayfa_sayisi));
  
  // LIMIT ve OFFSET değerlerini hesapla
  $offset = ($sayfa - 1) * $limit;
  
  // Oyuncuları seç 
  $oyuncuSorgusu = $db->prepare("SELECT o.* , u.KullaniciAdi , u.Dogumtarihi, r.rankAd, n.oyunTag FROM oyuncu o LEFT  JOIN uye u ON o.uyeID = u.ID  
  LEFT  JOIN oyunrank r ON o.oyuncuRank = r.rankID LEFT  JOIN oyunlar n ON  o.oyunID = n.oyunID  ORDER BY o.oyuncuID DESC LIMIT :limit OFFSET :offset");
  $oyuncuSorgusu->bindParam(':limit', $limit, PDO::PARAM_INT);
  $oyuncuSorgusu->bindParam(':offset', $offset, PDO::PARAM_INT);
  $oyuncuSorgusu->execute();
  $oyuncular = $oyuncuSorgusu->fetchAll(PDO::FETCH_ASSOC);
  
  $kategoricek = $db2->prepare("SELECT * FROM kategoriler");
  $kategoricek->execute();
  $kategoriler = $kategoricek->fetchAll(PDO::FETCH_ASSOC);

  if (isset($_POST['siralamaGuncelle'])) {

    $yeniSiralama = $_POST['yeniSiralama'];
    $uyeID = $_POST['uyeID'];


    $siralamaGuncelle = $db->prepare("UPDATE oyuncu SET oyuncuSiralama=:yeniSiralama WHERE uyeID=:uyeID");
    $siralamaGuncelle->bindParam(':uyeID', $uyeID);
    $siralamaGuncelle->bindParam(':yeniSiralama', $yeniSiralama);
    $siralamaGuncelle->execute();

    echo '<script>alert("Sıralama Güncellendi.");
    window.location.href = "oyunculistesi.php";
     </script>';
}
if (isset($_POST['rankGuncelle'])) {

    $oyuncuRank = $_POST['rankSec'];
    $uyeID = $_POST['uyeID'];


    $rankGuncelle = $db->prepare("UPDATE oyuncu SET oyuncuRank=:oyuncuRank WHERE uyeID=:uyeID");
    $rankGuncelle->bindParam(':uyeID', $uyeID);
    $rankGuncelle->bindParam(':oyuncuRank', $oyuncuRank);
    $rankGuncelle->execute();

    echo '<script>alert("Rank Güncellendi.");
    window.location.href = "oyunculistesi.php";
     </script>';
}

    if (isset($_POST['mesajGonder'])) {
        $talepID = $_POST['talepID'];
        $alici = $_POST['uyeID'];
        $mesajKategoriID = $_POST['konuSec'];
        $icerik = $_POST['icerik'];
        $konu = $talepID. " Numaralı Talebiniz " . $_POST['konu'];

        $mesajiGonder = $db2->prepare("INSERT INTO mesajlar (gonderen_id, alici_id, mesaj_kategori_id, mesaj_icerik, mesaj_konu) VALUES (:gonderen_id, :alici_id, :mesaj_kategori_id, :mesaj_icerik, :mesaj_konu)");
        $mesajiGonder->bindParam(':gonderen_id', $_SESSION['UyeID']);
        $mesajiGonder->bindParam(':alici_id', $alici);
        $mesajiGonder->bindParam(':mesaj_kategori_id', $mesajKategoriID);
        $mesajiGonder->bindParam(':mesaj_icerik', $icerik);
        $mesajiGonder->bindParam(':mesaj_konu', $konu);
        $mesajiGonder->execute();
        echo '<script>alert("Mesaj Gönderildi.");
        window.location.href = "oyuncutalepleri.php";
         </script>';

    }


    if(isset($_GET['oyuncuID'])) {
      $oyuncuID = $_GET['oyuncuID'];
  
      $oyuncuSorgusu = $db->prepare("SELECT o.* , u.KullaniciAdi , u.Dogumtarihi, r.rankAd, n.oyunTag 
      FROM oyuncu o 
      LEFT JOIN uye u ON o.uyeID = u.ID  
      LEFT JOIN oyunrank r ON o.oyuncuRank = r.rankID 
      LEFT JOIN oyunlar n ON  o.oyunID = n.oyunID 
      WHERE o.oyuncuID = :oyuncuID");
    
      $oyuncuSorgusu->bindParam(':oyuncuID', $oyuncuID, PDO::PARAM_INT);
      $oyuncuSorgusu->execute();
    
      $oyuncular = $oyuncuSorgusu->fetchAll(PDO::FETCH_ASSOC);
  


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
        <input class="form-control me-2" name="oyuncuID" type="text" placeholder="Oyuncu ID girin">
        <input type="submit" value="Ara" class="btn btn-primary">
        
      </form>
      <button class="btn btn-danger m-2" onclick="yenile()">Sıfırla</button>
       <script>
          function yenile() {
            var url = window.location.href;
            var cleanURL = url.replace(/[?&]oyuncuID=\d+/, ''); // oyuncuID parametresini temizler

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
        <a href="uyelistesi.php" class="nav-link text-white">
        <i class="fa-solid fa-users me-2"></i>
            Üye Listesi
        </a>
      </li>
      <li>
        <a href="oyuncutalepleri.php" class="nav-link text-white ">
        <i class="fa-solid fa-clipboard-user me-2"></i>
          Oyuncu Olma Talepleri
        </a>
      </li>
      <li>
        <a href="takimtalepleri.php" class="nav-link text-white ">
        <i class="fa-solid fa-people-group me-2"></i>
          Takım Kurma Talepleri
        </a>
      </li>
      <li>
        <a href="oyunculistesi.php" class="nav-link active ">
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
        <a href="gorusmetalepleri.php" class="nav-link text-white ">
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
                <h1 style="color: white; font-size: 60px; font-weight: bold;">Oyuncu Listesi</h1>
                <table class="table">
                     <thead class="thead-dark">
                    <tr>
                    <th scope="col">Üye Kullanıcı Adı:</th>
                    <th scope="col">Yaş</th>
                    <th scope="col">ID</th>
                    <th scope="col">Oyun</th>
                    <th scope="col">Kullanıcı Adı</th>
                    <th scope="col">Takım Durumu</th>
                    <th scope="col">Sıralama</th>
                    <th scope="col">Etiket</th>
                    <th scope="col">Rank</th>
                    <th scope="col" class = "text-center">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                
                if ($oyuncular) {
                
                foreach ($oyuncular as $oyuncu): ?>
                <input type="hidden" name="oyuncuID" value="<?php echo $uye['ID']; ?>">
                        <tr>
                          <?php 
                          $dgTarihi = new DateTime($oyuncu['Dogumtarihi']); 
                          $bugun = new DateTime();
                          $fark = $bugun->diff($dgTarihi); 
                          $yas = $fark->y; 
                          
                          
                          ?>
                            <th scope="row"><?php echo $oyuncu['KullaniciAdi'];  ?></th>
                            <td><?php echo $yas; ?></td>
                            <td><?php echo $oyuncu['oyuncuID']; ?></td>
                            <td><?php echo $oyuncu['oyunTag']; ?></td>
                            <td><?php echo $oyuncu['oyuncuKullaniciAdi']; ?></td>
                            <td><?php echo $oyuncu['oyuncuTakimDurumu']; ?></td>
                            <td><?php echo $oyuncu['oyuncuSiralama']; ?></td>
                            <td><?php echo $oyuncu['oyuncuEtiketi']; ?></td>
                            <td><?php echo $oyuncu['rankAd']; ?></td> 
                            <td class = "text-center">
                            <?php 
                               echo '<form method="post" action="">';
                               echo' <input type="hidden" name="uyeID" value="' . $oyuncu['uyeID'] . '">';
                               echo '<button type="button" class="m-2 btn btn-primary" data-bs-toggle="modal" data-bs-target="#r'.$oyuncu['oyuncuID'].'">Rank</button>'; 
                               echo '<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#s'.$oyuncu['oyuncuID'].'">Sıralama</button>';            


                               echo '<div class="modal fade " id="r'.$oyuncu['oyuncuID'].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                               <div class="modal-dialog">
                                 <div class="modal-content">
                                   <div class="modal-header">
                                     <h5 class="modal-title text-danger" id="exampleModalLabel"> ' .$oyuncu['oyuncuKullaniciAdi'].' Adlı Oyuncunun Rankını Düzenle</h5>
                                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                   </div>
                                   <div class="modal-body">';
                                   $rankCek = "SELECT rankAd, rankID FROM oyunrank WHERE oyunID = :oyunID " ;
                                   $durum = $db->prepare($rankCek);
                                   $durum->bindParam(':oyunID', $oyuncu['oyunID']);     
                                   $durum->execute();
                                   echo'
                                   <form method="post" action="">
                                   <label style="font-size: 22px; color: #000; margin-bottom: 10px;" for="rankSec">Yeni Rank:</label>
                                   <input type="hidden" name="uyeID" value="' . $oyuncu['uyeID'] . '">
                                   <select  name ="rankSec" class="input-field form-control mb-2 select-option col-md-2">
                                   <option disabled value="" selected>Güncel Rank Seç</option>';
                                   while ($row = $durum->fetch(PDO::FETCH_ASSOC)) {
                                       echo "<option value='" . $row['rankID'] . "'>" . $row['rankAd'] ."</option>";
                                   }
                                           
                                   echo '</select>
                                   <input style="background-color: #4CAF50; color: #fff; border: none; padding: 8px 16px; font-size: 16px; border-radius: 4px;" type="submit"  name="rankGuncelle" value="Güncelle">';
                                  
                                  echo'  </form>
                                  </div>
                                 </div>
                               </div>
                             </div>'; 


                             echo '<div class="modal fade " id="s'.$oyuncu['oyuncuID'].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                             <div class="modal-dialog">
                               <div class="modal-content">
                                 <div class="modal-header">
                                   <h5 class="modal-title text-danger" id="exampleModalLabel"> ' .$oyuncu['oyuncuKullaniciAdi'].' Adlı Oyuncunun Sıralamasını Düzenle</h5>
                                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                 </div>
                                 <div class="modal-body">
                                 <label style="font-size: 22px; color: #000; margin-bottom: 10px;" for="rankSec">Yeni Sıralama:</label>
                                 <input type="hidden" name="uyeID" value="' . $oyuncu['uyeID'] . '">
                                 <form method="post" action="">
                                    <input type="hidden" name="uyeID" value="' . $oyuncu['uyeID'] . '">
                                    <input type="text" value = "'.$oyuncu['oyuncuSiralama'].'" name="yeniSiralama"  id="yeniSiralama" style="padding: 6px 10px; font-size: 16px; border-radius: 4px; border: 1px solid #ccc; margin-right: 10px;">
                                    <input style="background-color: #4CAF50; color: #fff; border: none; padding: 8px 16px; font-size: 16px; border-radius: 4px;" type="submit"  name="siralamaGuncelle" value="Güncelle">
                                  </form>
                                
                                </div>
                               </div>
                             </div>
                           </div>'; 





                            ?>
                            </td>
                        </tr>


                <?php 
                   echo '</form>';
                  endforeach; 
                } else {
                  echo '<strong class = "text-danger m-2">Oyuncu bulunamadı</strong>';
                  
              }
                ?>
 
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