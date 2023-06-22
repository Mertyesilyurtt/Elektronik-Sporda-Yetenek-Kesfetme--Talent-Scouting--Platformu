<!doctype html>

<?php
include("../baglanti.php"); 
if (!isset($_SESSION['YoneticiID'])) {
    
    header("Location: ../../index.php");
}

$uyeID = $_SESSION['UyeID'];

$uyeleriCek = $db->prepare("SELECT COUNT(*) as toplam FROM uye");
$uyeleriCek->execute();
$sonuc = $uyeleriCek->fetch(PDO::FETCH_ASSOC);
$toplamUyeSayisi = $sonuc['toplam'];

$oyuncuOnaylanmamisDurum = 0;
$oyuncuTalepCek = $db->prepare("SELECT COUNT(*) as toplam FROM oyuncuonaytalep WHERE onayDurum = :onayDurum");
$oyuncuTalepCek->bindParam(':onayDurum', $oyuncuOnaylanmamisDurum);
$oyuncuTalepCek->execute();
$sonuc = $oyuncuTalepCek->fetch(PDO::FETCH_ASSOC);
$toplamOnaylanmamisOyuncuTalep = $sonuc['toplam'];

$takimOnaylanmamisDurum = 0;
$takimTalepCek = $db->prepare("SELECT COUNT(*) as toplam FROM takimonaytalep WHERE takimOnayDurum = :takimOnayDurum");
$takimTalepCek->bindParam(':takimOnayDurum', $takimOnaylanmamisDurum);
$takimTalepCek->execute();
$sonuc = $takimTalepCek->fetch(PDO::FETCH_ASSOC);
$toplamOnaylanmamistakimTalep = $sonuc['toplam'];


$gorusmeOnaylanmamisDurum = 2;
$gorusmeTalepCek = $db2->prepare("SELECT COUNT(*) as toplam FROM espor_mesajlar_db.gorusme g JOIN  espor_db.yonetici y ON g.sorumluAdmin = y.yoneticiID WHERE  ((y.UyeID = :UyeID) AND gorusmeOnayDurum = :gorusmeOnayDurum) ");
$gorusmeTalepCek->bindParam(':gorusmeOnayDurum', $gorusmeOnaylanmamisDurum);
$gorusmeTalepCek->bindParam(':UyeID', $uyeID);
$gorusmeTalepCek->execute();
$sonuc = $gorusmeTalepCek->fetch(PDO::FETCH_ASSOC);
$toplamOnaylanmamisgorusmeTalep = $sonuc['toplam'];

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
<link href="bootstrap.min.css" rel="stylesheet">

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

      .nav a:hover {
      background: #051414;
    }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="sidebars.css" rel="stylesheet">
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

    </div>
  </div>
</nav>

    <main class = "row" style = "background-color:#000d1a; ">

    <div class="d-flex flex-column flex-shrink-0 p-3 pt-0 text-white bg-dark  col-sm-3 col-md-2 col-12 "  >

    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item">
        <a href="#" class="nav-link active" aria-current="page">
        <i class="fa-solid fa-igloo me-2"></i>
          Ana sayfa
        </a>
      </li>
      <li>
        <a href="sayfalar/uyelistesi.php" class="nav-link text-white">
        <i class="fa-solid fa-users me-2"></i>
            Üye Listesi
        </a>
      </li>
      <li>
        <a href="sayfalar/oyuncutalepleri.php" class="nav-link text-white">
        <i class="fa-solid fa-clipboard-user me-2"></i>
          Oyuncu Olma Talepleri
        </a>
      </li>
      <li>
        <a href="sayfalar/takimtalepleri.php" class="nav-link text-white">
        <i class="fa-solid fa-people-group me-2"></i>
          Takım Kurma Talepleri
        </a>
      </li>
      <li>
        <a href="sayfalar/oyunculistesi.php" class="nav-link text-white">
        <i class="fa-solid fa-gamepad me-2"></i>
          Oyuncu Listesi
        </a>
      </li>
      <li>
        <a href="sayfalar/takimlistesi.php" class="nav-link text-white ">
        <i class="fa-solid fa-arrows-down-to-people me-2"></i>
          Takım Listesi
        </a>
      </li>
      <li>
        <a href="sayfalar/gorusmetalepleri.php" class="nav-link text-white ">
        <i class="fa-solid fa-comments me-2"></i>
          Görüşme Talepleri
        </a>
      </li>
      <li>
        <a href="sayfalar/gelenmesajlar.php" class="nav-link  text-white">
        <i class="fa-solid fa-envelope-open-text  me-2"></i>
          Gelen Mesajlar
        </a>
      </li>
    </ul>
    <ul class="nav flex-column">
        <li class="mt-auto">
            <a href="../../index.php" class="nav-link text-white">
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
        <li><a class="dropdown-item" href="#">İtem</a></li>
        <li><a class="dropdown-item" href="#">İtem3</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="#">İtem4</a></li> 
      </ul>
    </div>
  </div>

  <div class="b-example-divider d-none d-sm-block"> </div>

  <div class="col-sm-8 col-md-9 col-12 row m-2 mt-4" style="height: 10em;">


    <div class="col-md-6 col-lg-4  mt-3 col-12 col-sm-12" style="height: 10em; display: flex; align-items: center;">
        <div class="card bg-primary col-md-12 text-white" style="height: 10em;">
            <a href="sayfalar/uyelistesi.php" class="nav-link text-white">
                <div class="card-body" style="display: flex; align-items: center;">
                    <img src="images/user.png" alt="User" style="width: 8em; height: 8em;" class="img-fluid">
                    <div style="margin-left: 1em;">
                    <?php echo 'Siteye kayıtlı toplam <strong>'.$toplamUyeSayisi.'</strong> üye var.'; ?>
                    </div>
                </div>
            </a>
        </div>
    </div>



    <div class="col-md-6 col-lg-4  mt-3 col-sm-12" style="height: 10em; display: flex; align-items: center;">
        <div class="card bg-info text-white col-md-12" style="height: 10em;">
        <a href="sayfalar/oyuncutalepleri.php" class="nav-link text-white">
            <div class="card-body" style="display: flex; align-items: center;">
                <img src="images/gamer.png" alt="Gamer" style="width: 8em; height: 8em;" class="img-fluid">
                <div style="margin-left: 1em;">
                    <?php echo 'Toplam <strong>'.$toplamOnaylanmamisOyuncuTalep.'</strong> adet oyuncu olma talebi bekliyor.'; ?>
                </div>
            </div>
          </a> 
        </div>
    </div>



    <div class="col-md-12 col-lg-4  mt-3 col-sm-12" style="height: 10em; display: flex; align-items: center;">
        <div class="card bg-success text-white col-md-12" style="height: 10em;">
          <a href="sayfalar/takimtalepleri.php" class="nav-link text-white">
            <div class="card-body" style="display: flex; align-items: center;">
                <img src="images/team.png" alt="Team" style="width: 8em; height: 8em;" class="img-fluid">
                <div style="margin-left: 1em;">
                    <?php echo 'Toplam <strong>'.$toplamOnaylanmamistakimTalep.'</strong> adet takım kurma talebi bekliyor.'; ?>
                </div>
            </div>
          </a>
        </div>
    </div>

    <div class="col-md-12 mt-3 col-sm-12" style="height: 10em; display: flex; align-items: center;">
        <div class="card bg-danger  text-white col-md-12" style="height: 10em;">
          <a href="sayfalar/gorusmetalepleri.php" class="nav-link text-white">
            <div class="card-body" style="display: flex; align-items: center;">
                <img src="images/gorusme.png" alt="Team" style="width: 8em; height: 8em;" class="img-fluid">
                <div style="margin-left: 1em;">
                    <?php echo 'Toplam <strong>'.$toplamOnaylanmamisgorusmeTalep.'</strong> adet görüşme talebi bekliyor.'; ?>
                </div>
            </div>
          </a> 
        </div>
    </div>


  </div>

 </main>


    <script src="bootstrap.bundle.min.js"></script>

      <script src="sidebars.js"></script>
  </body>