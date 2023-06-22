<!doctype html>

<?php
include("../../baglanti.php"); 
if (!isset($_SESSION['YoneticiID'])) {
    
    header("Location: ../../index.php");
}

//$uyeID = $_SESSION['UyeID'];


  $talepleriCek = $db->prepare("SELECT COUNT(*) as talepSayisi FROM takimonaytalep");
  $talepleriCek->execute();
  $talepSayisi = $talepleriCek->fetch(PDO::FETCH_ASSOC)['talepSayisi'];
  
  // Sayfa sayısını hesapla
  $limit = 10;
  $sayfa_sayisi = ceil($talepSayisi / $limit);
  
  // Hangi sayfa numarasındayız?
  $sayfa = isset($_GET['sayfa']) ? (int)$_GET['sayfa'] : 1;
  $sayfa = max(1, min($sayfa, $sayfa_sayisi));
  
  // LIMIT ve OFFSET değerlerini hesapla
  $offset = ($sayfa - 1) * $limit;

  $talepSorgusu = $db->prepare("SELECT * FROM takimonaytalep t 
  JOIN uye u ON t.uyeID = u.ID 
  JOIN oyunlar o ON o.oyunID = t.oyunID  ORDER BY t.takimOnayDurum ASC LIMIT :limit OFFSET :offset");
  $talepSorgusu->bindParam(':limit', $limit, PDO::PARAM_INT);
  $talepSorgusu->bindParam(':offset', $offset, PDO::PARAM_INT);
  $talepSorgusu->execute();
  $talepler = $talepSorgusu->fetchAll(PDO::FETCH_ASSOC);
  
  $kategoricek = $db2->prepare("SELECT * FROM kategoriler");
  $kategoricek->execute();
  $kategoriler = $kategoricek->fetchAll(PDO::FETCH_ASSOC);

  if (isset($_POST['takimOnayla'])) {          

      $talepID = $_POST['talepID'];
      $uyeID = $_POST['uyeID'];
      $oyuncuID = $_POST['oyuncuID'];
      $oyunID = $_POST['oyunID'];
      $takimAdi = $_POST['takimAdi'];
      $takimLogo = $_POST['takimLogo'];
      $takimEtiket = $_POST['takimEtiket'];
      $takimAciklama = $_POST['takimAciklama'];


      $onayDurum = 2;
      $onaylaTalep = $db->prepare("UPDATE takimonaytalep SET takimOnayDurum=:onayDurum WHERE talepID=:talepID");
      $onaylaTalep->bindParam(':talepID', $talepID);
      $onaylaTalep->bindParam(':onayDurum', $onayDurum);
      $onaylaTalep->execute();



      $takimlariCek = $db->prepare("SELECT * FROM takimlar WHERE takimAdi = :takimAdi");
      $takimlariCek->bindParam(':takimAdi', $takimAdi);
      $takimlariCek->execute();
      $takimlar = $takimlariCek->fetch(PDO::FETCH_ASSOC);

      
      if (!$takimlar)
      {
          $onayDurum = 1;
          $takimKur = $db->prepare("INSERT INTO takimlar (oyunID, takimAdi, takimLogo, takimEtiket, takimAciklama, takimOnayDurumu) VALUES (:oyunID, :takimAdi, :takimLogo, :takimEtiket, :takimAciklama, :takimOnayDurumu)");
          $takimKur->bindParam(':oyunID', $oyunID);
          $takimKur->bindParam(':takimAdi', $takimAdi);
          $takimKur->bindParam(':takimLogo', $takimLogo);
          $takimKur->bindParam(':takimEtiket', $takimEtiket);
          $takimKur->bindParam(':takimAciklama', $takimAciklama);
          $takimKur->bindParam(':takimOnayDurumu', $onayDurum);
          $takimKur->execute(); 

          $takimID = $db->lastInsertId();

          $liderRolu = 5;

          $liderYap = $db->prepare("INSERT INTO takimlideri  (uyeID, oyuncuID, takimID, liderRolu) VALUES (:uyeID, :oyuncuID, :takimID, :liderRolu)");
          $liderYap->bindParam(':uyeID', $uyeID);
          $liderYap->bindParam(':oyuncuID', $oyuncuID);
          $liderYap->bindParam(':takimID', $takimID);
          $liderYap->bindParam(':liderRolu', $liderRolu);
          $liderYap->execute(); 

          $onayDurum = 2;
          $takimaEkle = $db->prepare("UPDATE oyuncu SET oyuncuTakimDurumu=:oyuncuTakimDurumu, takimID = :takimID WHERE oyuncuID=:oyuncuID");
          $takimaEkle->bindParam(':oyuncuTakimDurumu', $onayDurum);
          $takimaEkle->bindParam(':takimID', $takimID);
          $takimaEkle->bindParam(':oyuncuID', $oyuncuID);
          $takimaEkle->execute();


          $rolGuncele = $db->prepare("UPDATE uye SET rol=:rol WHERE ID=:uyeID");
          $rolGuncele->bindParam(':rol', $onayDurum);
          $rolGuncele->bindParam(':uyeID', $uyeID);
          $rolGuncele->execute();
        
      }

      echo '<script>alert("Talep Onaylandı.");
      window.location.href = "takimtalepleri.php";
       </script>';
    }

    if (isset($_POST['takimReddet'])) {
        $talepID = $_POST['talepID'];
        $onayDurum = 0;
        $reddetTalep = $db->prepare("UPDATE takimonaytalep SET takimOnayDurum=:onayDurum WHERE talepID=:talepID");
        $reddetTalep->bindParam(':talepID', $talepID);
        $reddetTalep->bindParam(':onayDurum', $onayDurum);
        $reddetTalep->execute();
        echo '<script>alert("Talep Reddedildi.");
        window.location.href = "takimtalepleri.php";
         </script>';
    }

    if (isset($_POST['takimIncele'])) {
        $talepID = $_POST['talepID'];
        $onayDurum = 1;
        $inceleTalep = $db->prepare("UPDATE takimonaytalep SET takimOnayDurum=:onayDurum WHERE talepID=:talepID");
        $inceleTalep->bindParam(':talepID', $talepID);
        $inceleTalep->bindParam(':onayDurum', $onayDurum);
        $inceleTalep->execute();
        echo '<script>alert("Talep İncelenmeye Alındı.");
        window.location.href = "takimtalepleri.php";
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
        window.location.href = "takimtalepleri.php";
         </script>';

    }



    
    if(isset($_GET['talepID'])) {
      $talepID = $_GET['talepID'];
   
      $talepSorgusu = $db->prepare("SELECT * FROM takimonaytalep t 
      JOIN uye u ON t.uyeID = u.ID 
      JOIN oyunlar o ON o.oyunID = t.oyunID
      WHERE talepID = :talepID");
      $talepSorgusu->bindParam(':talepID', $talepID, PDO::PARAM_INT);
      $talepSorgusu->execute();
      $talepler = $talepSorgusu->fetchAll(PDO::FETCH_ASSOC);
  
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
            var cleanURL = url.replace(/[?&]talepID=\d+/, ''); // talepID parametresini temizler

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
        <a href="takimtalepleri.php" class="nav-link active ">
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
                <h1 style="color: white; font-size: 60px; font-weight: bold;">Takım Kurma Talepleri</h1>
                <table class="table">
                     <thead class="thead-dark">
                    <tr>
                    <th scope="col">Talep ID</th>
                    <th scope="col">Üye ID</th>
                    <th scope="col">Üye Kullanıcı Adı</th>
                    <th scope="col">Lider Kullanıcı Adı</th>
                    <th scope="col">Takım Etiketi</th>
                    <th scope="col">Oyun</th>
                    <th scope="col">Onay Durum</th>
                    <th scope="col">Takım Logo</th>
                    <th scope="col" class = "text-center">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($talepler as $talep): ?>
                <input type="hidden" name="oyuncuID" value="<?php echo $uye['ID']; ?>">
                        <tr>
                          <?php 

                           if($talep['takimOnayDurum'] == 1){
                            $talepDurum = "<strong class='text-danger'>Reddedildi.</strong>";
                            }
                            else if($talep['takimOnayDurum'] == 0){
                                $talepDurum = "<strong class='text-warning'>İnceleniyor.</strong>";
                            }
                            else if($talep['takimOnayDurum'] == 2){
                                $talepDurum = "<strong class='text-success'>Onaylandı.</strong>";
                            }
                            else {
                                $talepDurum = "<strong class='text-secondary'>Belirsiz.</strong>";
                            }
                          
                          ?>
                            <th scope="row"><?php echo $talep['talepID'];  ?></th>
                            <td><?php echo $talep['ID']; ?></td>
                            <td><?php echo $talep['KullaniciAdi']; ?></td>
                            <td><?php echo $talep['kullaniciAdi']; ?></td>
                            <td><?php echo $talep['takimEtiket']; ?></td>
                            <td><?php echo $talep['oyunTag']; ?></td>
                            <td><?php echo $talepDurum; ?></td>
                            <td><?php echo '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#g'.$talep['talepID'].'">Göster</button>'; ?></td>
                            <td>
                            <?php 
                               echo '<form method="post" action="">';
                               echo '<input type="hidden" name="talepID" value="' . $talep['talepID'] . '">';
                               echo '<input type="hidden" name="oyunID" value="' . $talep['oyunID'] . '">';
                               echo '<input type="hidden" name="oyuncuID" value="' . $talep['oyuncuID'] . '">';
                               echo '<input type="hidden" name="uyeID" value="' . $talep['uyeID'] . '">';
                               echo '<input type="hidden" name="takimAdi" value="' . $talep['takimAdi'] . '">';
                               echo '<input type="hidden" name="takimLogo" value="' . $talep['takimLogo'] . '">';
                               echo '<input type="hidden" name="takimAciklama" value="' . $talep['takimAciklama'] . '">';
                               echo '<input type="hidden" name="takimEtiket" value="' . $talep['takimEtiket'] . '">';
                           
                              if($talep['takimOnayDurum'] == 0){
                                  echo '<button type="submit" class="btn btn-success m-2" name="takimOnayla">Onayla</button>';
                                  echo '<button type="submit" class="btn btn-danger m-2" name="takimReddet">Reddet</button>';
                              } 
                              else if($talep['takimOnayDurum'] == 1 || $talep['takimOnayDurum'] == 2 ){
                                echo '<button type="submit" class="btn btn-info m-2" name="takimIncele">İnceleniyor</button>';
                              }
                              else if($talep['takimOnayDurum'] == 0 || $talep['takimOnayDurum'] == 2 ){
                                echo '<button type="submit" class="btn btn-danger m-2" name="takimReddet">Reddet</button>';
                              }  
                              else{
                                echo 'Tanımsız';
                              }   
                              echo '<button type="button" class="btn btn-warning m-2" data-bs-toggle="modal" data-bs-target="#w'.$talep['talepID'].'">Mesaj Gönder</button>';
                              
                     


                              echo '<div class="modal fade " id="g'.$talep['talepID'].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title text-danger" id="exampleModalLabel"> ' .$talep['takimAdi'].' Takım Logosu</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body text-primary">
                                    <img src="../../images/takimLogo/' . $talep["takimLogo"] . '" style="max-width: 100%; max-height: 100%;" alt="Resim" class = "mb-2"><br>
                                    <strong>Takım Açıklama: </strong><label> ' . $talep["takimAciklama"] . '</label>
                                  </div>
                                </div>
                              </div>
                            </div>'; 
                            ?>
                            
                            <div class="modal fade text-danger " id="w<?php echo $talep['talepID']; ?>" tabindex="-1" role="dialog" aria-labelledby="mesajGonderModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="mesajGonderModalLabel">Mesaj Gönder</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  <div class="mb-3">
                                    <label for="to" class="form-label">Alıcı:</label>
                                    <input type="text" class="form-control" id="to" name="alici" readonly placeholder="<?php echo $talep['KullaniciAdi']; ?>">
                                  </div>
                                  <div class="mb-3">
                                    <label for="konuSec" class="form-label">Kategori Seç:</label>
                                    <select id="konuSec" name="konuSec" class="form-select input-field">
                                      <?php foreach ($kategoriler as $kategori) {
                                        if ($kategori['kategoriIsmi'] == 'Takım Kurma Talebi Yanıtı') {
                                          echo "<option value='" . $kategori['kategoriID'] . "' selected>" . $kategori['kategoriIsmi'] . "</option>";
                                        } else {
                                          echo "<option value='" . $kategori['kategoriID'] . "' disabled>" . $kategori['kategoriIsmi'] . "</option>";
                                        }
                                      } ?>
                                    </select>
                                  </div>
                                  <div class="mb-3">
                                    <label for="talepID" class="form-label">Talep ID:</label>
                                    <input type="text" class="form-control" id="talepID" readonly placeholder="<?php echo $talep['talepID']; ?>">
                                  </div>
                                  <div class="mb-3">
                                    <label for="subject" class="form-label">Konu:</label>
                                    <input type="text" name="konu" class="form-control" id="subject" placeholder="<?php echo $talep['talepID']; ?> Numaralı Talebiniz ... (Devamını yazınız.)">
                                  </div>
                                  <div class="mb-3">
                                    <label for="message" class="form-label">Mesaj:</label>
                                    <textarea class="form-control" name="icerik" id="message" rows="5"></textarea>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                                  <button type="submit" name="mesajGonder" class="btn btn-warning">Gönder</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          
                            </td>
                        </tr>


                <?php 
                   echo '</form>';
                  endforeach; 
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