<!DOCTYPE html>
<html lang="zxx">

<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
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
/* if ($_SESSION['Onay'] == 0) {
    header("Location: index.php");
    exit();
} */

//$oyuncuCek = $db->prepare("SELECT * FROM oyuncu o JOIN uye u ON o.uyeID = u.ID");
//$oyuncuCek = $db->prepare("SELECT * FROM oyuncu o JOIN uye u ON o.uyeID = u.ID JOIN oyunrank r ON o.oyuncuRank = r.rankID " );


$uyeID = $_SESSION['UyeID'];

$oyuncuCek = $db->prepare("SELECT DISTINCT o.*, u.*, r.*, ol.oyunTag, ol.oyunIsmi, t.takimAdi, t.takimID 
                          FROM oyuncu o 
                          LEFT JOIN uye u ON o.uyeID = u.ID 
                          LEFT JOIN oyunrank r ON o.oyuncuRank = r.rankID 
                          LEFT JOIN oyunlar ol ON o.oyunID = ol.oyunID 
                          LEFT JOIN takimlar t ON o.takimID = t.takimID 
                          ORDER BY RAND() 
                          LIMIT 9");

$oyuncuCek->execute();
$oyuncular = $oyuncuCek->fetchAll(PDO::FETCH_ASSOC);





    if (isset($_POST['mesajGonder'])) {
        $alici = $_POST['uyeID'];
        $mesajKategoriID = $_POST['konuSec'];
        $icerik = $_POST['icerik'];
        $konu = $_POST['konu'];

        $mesajiGonder = $db2->prepare("INSERT INTO mesajlar (gonderen_id, alici_id, mesaj_kategori_id, mesaj_icerik, mesaj_konu) VALUES (:gonderen_id, :alici_id, :mesaj_kategori_id, :mesaj_icerik, :mesaj_konu)");
        $mesajiGonder->bindParam(':gonderen_id', $_SESSION['UyeID']);
        $mesajiGonder->bindParam(':alici_id', $alici);
        $mesajiGonder->bindParam(':mesaj_kategori_id', $mesajKategoriID);
        $mesajiGonder->bindParam(':mesaj_icerik', $icerik);
        $mesajiGonder->bindParam(':mesaj_konu', $konu);
        $mesajiGonder->execute();
        header("Location: kesfet.php");
    }
    ?>
<head>
    <title>Keşfet | ScoutGG</title>
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
        .nav-tabs {
            margin-right: 1em;
        }
        .nav-tabs .nav-link {
            color: white;
           
            padding: 1em; 
        }
        .nav-link.active {
            color: #007bff;
        }
        .tab-pane {
			display: none;
		}
		.tab-pane.active {
			display: block;
		}
        .sidebar {
        position: sticky;
        top: 10px; 
        left: 0;
        bottom: 0;
        z-index: 1;
        padding: 20px;
        background-color: #f5f5f5;
        overflow-x: hidden;
        color:white;
        }

        .sidebar h4 {
        margin-bottom: 20px;
        }

        .sidebar h6 {
        margin-top: 10px;
        margin-bottom: 5px;
        }

        .sidebar hr {
        margin-top: 5px;
        margin-bottom: 10px;
        border-top: 1px solid #ddd;
        }

        .sidebar .form-group {
        margin-bottom: 20px;
        }

        .sidebar .form-check {
        margin-bottom: 10px;
        }

        .sidebar .btn {
        margin-top: 20px;
        width: 100%;
        }
        .oyuncu-kart{
            height: 27em;
            border-radius: 2em;
            color: white;
            padding: 0 1em 1em 1em;
        }
        .oyuncu-kart p{
           margin-bottom:0px;
        }
        .modal input::placeholder {
            color: red;
        }
    </style>



</head>

<body>
<div class="sub-banner-section">
<?php 
include("assets/header.php");
?>
<!-- SOCIAL ICONS -->
    <div class="left_icons float-left d-table" data-aos="fade-down">
    <div class="icon_content d-table-cell align-middle">
            <ul class="list-unstyled p-0 m-0">
                <li>
                    <a href="https://www.facebook.com/mertyesilyurtt"><i class="fa-brands fa-facebook-f" aria-hidden="true"></i></a>
                </li>
                <li>
                    <a href="https://twitter.com/mertyesilyuurtt"><i class="fa-brands fa-twitter" aria-hidden="true"></i></a>
                </li>
                <li>
                    <a href="https://www.linkedin.com/in/mertyesilyurtt"><i class="fa-brands fa-linkedin-in" aria-hidden="true"></i></a>
                </li>
                <li class="p-0">
                    <a href="https://www.instagram.com/mertyesilyurtt"><i class="fa-brands fa-instagram" aria-hidden="true"></i></a>
                </li>
            </ul>
        </div>
    </div>
<!-- SUB BANNER SECTION -->
    <section class="banner-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 text-lg-left text-center">
                    <div class="banner-section-content">
                        <h1 data-aos="fade-up">Keşfet</h1>
                        <p data-aos="fade-right">Havuzumuzdaki oyuncuları ve takımları inceleyebilirsiniz. 
                        </p>
                        <div class="btn_wrapper">
                            <span>Ana Sayfa <i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i> Keşfet</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12"></div>
            </div>
        </div>
    </section>
</div>
<!-- GALLERY IMAGES SECTION -->
<div class="gallery_combo_background" >
    <div class="gallery_images_section">

            <div class="container" >
                <div class="container mb-5">

                <div class="tab-content">
                    <div id="divTum" class="tab-pane <?php if(empty($selectedId)) echo 'active'; ?>">
                        <p>Havuzumuzdaki oyuncuların birkaçı.</p>
                        <!-- Sidebar -->
                        <div class="container">
                            <div class="row">


                                <div class = "col-md-12">
                                    <div class="row">
                                        <?php foreach ($oyuncular as $oyuncu):
                                            $dgTarihi = new DateTime($oyuncu['Dogumtarihi']); //DateTime sınıfına dönüştürüyoruz
                                            $bugun = new DateTime(); //bugünün tarihi
                                            $fark = $bugun->diff($dgTarihi); // iki tarih arasındaki farkı hesapla
                                            $yas = $fark->y; // fark yıl ay gün değerlerini tuttuğu için sadece y ile yıl bilgisini getir 
                                            $takimAdi = $oyuncu['takimAdi'] ? $oyuncu['takimAdi'] : 'YOK';
                                            ?>
                                            
                                            <div class="col-md-4 oyuncu-kart mb-4">
                                                <div class="col-md-12 oyuncu-kart pt-2" style = "background-color:#741;">
                                                    <img src = "assets/images/profil/<?php echo  $oyuncu['ProfilResmi'];?>" style = "width: 8em; height: 8em; border-radius:5em;">
                                                    <p>Üye adı: <?php echo $oyuncu['KullaniciAdi']; ?></p>
                                                    <p>Yaş: <?php echo $yas; ?></p>
                                                    <p>Oyuncu adı: <a href = "oyuncu-profil.php?oyuncuID=<?php echo $oyuncu['oyuncuID']; ?>"><?php echo $oyuncu['oyuncuKullaniciAdi']; ?></a></p>
                                                    <p>Oyun: <?php echo $oyuncu['oyunTag']; ?></p>
                                                    <p>Takımı: <a  href = "takim-profil.php?takimID=<?php echo $oyuncu['takimID']; ?>"><?php echo  $takimAdi; ?></a></p>
                                                    <p>Sıralaması: <?php echo $oyuncu['oyuncuSiralama']; ?></p>
                                                    <p>Etiket: <?php echo $oyuncu['oyuncuEtiketi']; ?></p> 
                                                    <p>Rank: <?php echo $oyuncu['rankAd']; ?></p>    
                                                    <?php echo '<form method="post" action="">';
                                                      echo '<input type="hidden" name="uyeID" value="' . $oyuncu['uyeID'] . '">';

                                                    if($_SESSION['Rol'] >=2)
                                                    {
                                                    /* echo ' 
                                                    <form action="mesaj_gonder.php" method="post">
                                                        <input type="hidden" name="alici" value=" $oyuncu['KullaniciAdi']; ?>">
                                                        <input type="hidden" name="takimAdi" value="$_SESSION['takimAdi']; ?>">
                                                        <input type="hidden" name="oyuncuID" value="$oyuncu['oyuncuID']; ?>">
                                                        <input type="hidden" name="aliciID" value="$oyuncu['ID']; ?>">
                                                        <input type="hidden" name="takimID" value="$_SESSION['takimID']; ?>">
                                                        <input type="hidden" name="gorusmeTuru" value="1">
                                                        <input type="hidden" name="konu" value="Seni [$_SESSION['takimAdi'] ; ?>] Takımıma Davet Ediyorum.">
                                                        <button type="submit" name  = "mesajGonderSayfasi" class="btn btn-warning">İstek Gönder</button>
                                                     </form> '; */
                                                    }
                                                    
                                                   ?>
                                           
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>        
                            </div>
                        </div>
                    </div>      
                </div>
            </div>





            <!-- <div class="row" data-aos="fade-up">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <div class=" gallery_images_content padding_bottom">
                        <figure class="mb-0 img_width">
                            <img src="assets/images/gallery_images_1.jpg" alt="">
                        </figure>
                        <div class="hover_box_plus"><a href="#"><figure class="mb-0"><img src="./assets/images/box_hover_plus.png" alt=""></figure></a></div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class=" gallery_images_content padding_bottom">
                        <figure class="mb-0 img_width">
                            <img src="assets/images/gallery_images_2.png" alt="">
                        </figure>
                        <div class="hover_box_plus"><a href="#"><figure class="mb-0"><img src="./assets/images/box_hover_plus.png" alt=""></figure></a></div>
                    </div>
                </div>
            </div>  
            <div class="row" data-aos="fade-up">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class=" gallery_images_content padding_bottom">
                        <figure class="mb-0 img_width">
                            <img src="assets/images/gallery_images_3.jpg" alt="">
                        </figure>
                        <div class="hover_box_plus"><a href="#"><figure class="mb-0"><img src="./assets/images/box_hover_plus.png" alt=""></figure></a></div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class=" gallery_images_content padding_bottom">
                        <figure class="mb-0 img_width">
                            <img src="assets/images/gallery_images_4.jpg" alt="">
                        </figure>
                        <div class="hover_box_plus"><a href="#"><figure class="mb-0"><img src="./assets/images/box_hover_plus.png" alt=""></figure></a></div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class=" gallery_images_content padding_bottom">
                        <figure class="mb-0 img_width">
                            <img src="assets/images/gallery_images_5.jpg" alt="">
                        </figure>
                        <div class="hover_box_plus"><a href="#"><figure class="mb-0"><img src="./assets/images/box_hover_plus.png" alt=""></figure></a></div>
                    </div>
                </div>
            </div>
            <div class="row" data-aos="fade-up">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class=" gallery_images_content padding_bottom">
                        <figure class="mb-0 img_width">
                            <img src="assets/images/gallery_images_6.jpg" alt="">
                        </figure>
                        <div class="hover_box_plus"><a href="#"><figure class="mb-0"><img src="./assets/images/box_hover_plus.png" alt=""></figure></a></div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <div class=" gallery_images_content padding_bottom">
                        <figure class="mb-0 img_width">
                            <img src="assets/images/gallery_images_7.jpg" alt="">
                        </figure>
                        <div class="hover_box_plus"><a href="#"><figure class="mb-0"><img src="./assets/images/box_hover_plus.png" alt=""></figure></a></div>
                    </div>
                </div>
            </div>   -->
        </div>
    </div>
    <!-- CLIENTS REVIEWS SECTION -->
    <section class="client_review-section">
        <div class="container">
            <div class="row" data-aos="fade-up">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h2>Kullanıcı Yorumları</h2>
                    <figure class="mb-5">
                        <img src="./assets/images/clients_reviews_logo.png" alt="">
                    </figure>
                </div>
            </div>
            <div class="row">
                <div class="owl-carousel owl-theme">   
                    <div class="item">
                        <div class="client_review_content">
                            <p class="sub_p"><span>"</span>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni<span>"</span><br>
                                dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor 
                                sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore 
                                magnam aliquam quaerat voluptatem.</p>
                            <div class="client_wrapper">
                                <figure class="mb-0">
                                    <img src="./assets/images/client_review_image.png" alt="">
                                </figure>
                                <div class="client_span_wrapper">
                                    <span class="client_name d-block">Kevin Andrew</span>
                                    <span class="client_desc">Satisfied Client</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="client_review_content">
                            <p class="sub_p"><span>"</span>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni<span>"</span><br>
                                dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor 
                                sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore 
                                magnam aliquam quaerat voluptatem.</p>
                            <div class="client_wrapper">
                                <figure class="mb-0">
                                    <img src="./assets/images/client_review_image.png" alt="">
                                </figure>
                                <div class="client_span_wrapper">
                                    <span class="client_name d-block">Kevin Andrew</span>
                                    <span class="client_desc">Satisfied Client</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="client_review_content">
                            <p class="sub_p"><span>"</span>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni<span>"</span><br>
                                dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor 
                                sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore 
                                magnam aliquam quaerat voluptatem.</p>
                            <div class="client_wrapper">
                                <figure class="mb-0">
                                    <img src="./assets/images/client_review_image.png" alt="">
                                </figure>
                                <div class="client_span_wrapper">
                                    <span class="client_name d-block">Kevin Andrew</span>
                                    <span class="client_desc">Satisfied Client</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- SUBSCRIBE SECTION -->
<section class="subscribe_section">
    <div class="container">
        <div class="row" data-aos="fade-up">
            <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
                <figure class="robot mb-0">
                    <img src="./assets/images/subscribe_image.png" alt="">
                </figure>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12">
                <div class="subscribe_content">
                    <h2>Sitemize Kayıt Ol ve <span>Espor'u Takipte Kal</span></h2>
                    <form method="POST">
                        <div class="form-row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <input type="email" name="email" id="emailadd" class="form-control upper_layer" placeholder="Email Adresinizi Girin">
                                <div class="input-group-append form-button">
                                    <button class="btn subscribe_arrow" name="btnsubmit" id="submitbtn" type="submit"><i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
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
<script>
// Filtreleme butonuna tıklanınca çalışacak kodlar
$(document).ready(function() {
  $('.sidebar button').click(function() {
    var oyun = $('#oyunSelect').val();
    var siralama = $('input[name="siralamaRadio"]:checked').val();
    // Filtreleme işlemini yapmak için gerekli kodları buraya ekleyebilirsiniz
  });
});
</script>



</html>