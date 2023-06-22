<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Ana Sayfa | ScoutGG</title>
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
<div class="banner-section-outer">
<?php 

    include("assets/header.php");

    if (isset($_POST['iletisimGonder'])) {

        $isim = $_POST['isim'];
        $email = $_POST['email'];
        $telefon = $_POST['telefon'];
        $mesaj = $_POST['mesaj'];

        $mesajiGonder = $db2->prepare("INSERT INTO iletisim (isim, email, telefon, mesaj) VALUES (:isim, :email, :telefon, :mesaj)");
        $mesajiGonder->bindParam(':isim', $isim);
        $mesajiGonder->bindParam(':email', $email);
        $mesajiGonder->bindParam(':telefon', $telefon);
        $mesajiGonder->bindParam(':mesaj', $mesaj);
        $mesajiGonder->execute();
        echo '<script>alert("Mesaj Gönderildi.");
        window.location.href = "index.php";
         </script>';
    }

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
<!-- BANNER SECTION -->
    <section class="banner-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 text-lg-left text-center">
                    <div class="banner-section-content">
                        <h1 data-aos="fade-up">Hayallerinize Giden Yolda Sizin Yanınızdayız</h1>
                        <p data-aos="fade-right">Espor camiasında takımlar ve oyuncular arasında köprü görevi görmek en büyük politikamızdır.</p>
                        <div class="btn_wrapper" data-aos="fade-down">
                        <a class="text-decoration-none readmore_btn" href="./about.php">Biz Kimiz</a>
                            <?php 
                            if (isset($_SESSION['Rol']) && $_SESSION['Rol'] > 0) {
                                echo ' <a class="text-decoration-none readmore_btn" href="./oyunlarin.php">Oyuncu Profil</a>';
                
                            }               
                            if (!isset($_SESSION['email'])) {
                                echo '  <a class="text-decoration-none joinus_btn" href="./signup.php">Kayıt Ol </a>';
        
                            }
                            if (isset($_SESSION['Rol']) && $_SESSION['Rol'] >= 0) {
                                echo ' <br/> <br/>  <a class="text-decoration-none joinus_btn" href="./oyuncu-talep.php">Oyuncu Ol</a> ';
        
                            }
                            if (isset($_SESSION['Rol']) && $_SESSION['Rol'] > 0) {
                                echo ' <a class="text-decoration-none joinus_btn" href="./takim-talep.php">Takım Kur</a>';
                
                            }
                            if (isset($_SESSION['Rol']) && $_SESSION['Rol'] >= 2) {
                                echo ' <a class="text-decoration-none joinus_btn" href="./takimlarin.php">Takım Yönet</a>';
                
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12"></div>
            </div>
        </div>
    </section>
</div> <!-- <div class="banner-section-outer"> bitiş -->
<!-- TRENDING GAMES SECTION -->
<section class="trending_games_section">
    <div class="container">
        <div class="row" data-aos="fade-up">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2>Hizmet Verdiğimiz Oyunlar</h2>
                <figure class="mb-5">
                    <img src="./assets/images/trending_games_logo.png" alt="">
                </figure>
            </div>
        </div>
        <div class="tabs-box tabs-options">
            <ul class="nav nav-tabs">
            <ul style="display: flex; list-style: none; justify-content: space-between;">
    <li><a class="active" data-toggle="tab" href="#all">Tümü</a></li>
    <li><a data-toggle="tab" href="#origin">Valorant</a></li>
    <li><a data-toggle="tab" href="#playstation">League of Legends</a></li>
    <li><a data-toggle="tab" href="#steam">CS:GO</a></li>
    <li><a data-toggle="tab" href="#uplay">Rocket League</a></li>
    <li><a data-toggle="tab" href="#xbox">Teamfight Tactics</a></li>
</ul>
            </ul>
            <div class="tab-content">
                <div id="all" class="tab-pane fade in active show">
                    <div class="row">
                        <div class="owl-carousel owl-theme">
                            <div class="item">
                                <div class="trending_content mb-0">
                                    <div class="trending_upper_portion">
                                        <figure class="mb-0 img_width"><img src="./assets/images/trending_games_1.png" alt=""></figure>
                                        <div class="hover_box_plus"><a href="#"><figure class="mb-0"><img src="./assets/images/box_hover_plus.png" alt=""></figure></a></div>
                                    </div>
                                    <div class="trending_lower_portion_wrapper">
                                        <div class="trending_lower_portion">
                                            <div class="trending_span_wrapper">
                                                <span>Valorant</span>
                                            </div>
                                            <ul class="list-unstyled mb-0">
                                                <li>
                                                    <i class="fa-solid fa-star"></i>
                                                </li>
                                                <li>
                                                    <i class="fa-solid fa-star"></i>
                                                </li>
                                                <li>
                                                    <i class="fa-solid fa-star"></i>
                                                </li>
                                                <li>
                                                    <i class="fa-solid fa-star"></i>
                                                </li>
                                                <li>
                                                    <i class="fa-solid fa-star"></i>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="trending_content mb-0">
                                    <div class="trending_upper_portion">
                                        <figure class="mb-0 img_width"><img src="./assets/images/trending_games_2.png" alt=""></figure>
                                        <div class="hover_box_plus"><a href="#"><figure class="mb-0"><img src="./assets/images/box_hover_plus.png" alt=""></figure></a></div>
                                    </div>
                                    <div class="trending_lower_portion_wrapper">
                                        <div class="trending_lower_portion">
                                            <div class="trending_span_wrapper">
                                                <span>League of Legends</span>
                                            </div>
                                            <ul class="list-unstyled mb-0">
                                                <li>
                                                    <i class="fa-solid fa-star"></i>
                                                </li>
                                                <li>
                                                    <i class="fa-solid fa-star"></i>
                                                </li>
                                                <li>
                                                    <i class="fa-solid fa-star"></i>
                                                </li>
                                                <li>
                                                    <i class="fa-solid fa-star"></i>
                                                </li>
                                                <li>
                                                    <i class="fa-solid fa-star"></i>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="trending_content mb-0">
                                    <div class="trending_upper_portion">
                                        <figure class="mb-0 img_width"><img src="./assets/images/trending_games_3.png" alt=""></figure>
                                        <div class="hover_box_plus"><a href="#"><figure class="mb-0"><img src="./assets/images/box_hover_plus.png" alt=""></figure></a></div>
                                    </div>
                                    <div class="trending_lower_portion_wrapper">
                                        <div class="trending_lower_portion">
                                            <div class="trending_span_wrapper">
                                                <span>Teamfight Tactics</span>
                                            </div>
                                            <ul class="list-unstyled mb-0">
                                                <li>
                                                    <i class="fa-solid fa-star"></i>
                                                </li>
                                                <li>
                                                    <i class="fa-solid fa-star"></i>
                                                </li>
                                                <li>
                                                    <i class="fa-solid fa-star"></i>
                                                </li>
                                                <li>
                                                    <i class="fa-solid fa-star"></i>
                                                </li>
                                                <li>
                                                    <i class="fa-solid fa-star"></i>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="trending_content mb-0">
                                    <div class="trending_upper_portion">
                                        <figure class="mb-0 img_width"><img src="./assets/images/trending_games_4.png" alt=""></figure>
                                        <div class="hover_box_plus"><a href="#"><figure class="mb-0"><img src="./assets/images/box_hover_plus.png" alt=""></figure></a></div>
                                    </div>
                                    <div class="trending_lower_portion_wrapper">
                                        <div class="trending_lower_portion">
                                            <div class="trending_span_wrapper">
                                                <span>Rocket League</span>
                                            </div>
                                            <ul class="list-unstyled mb-0">
                                                <li>
                                                    <i class="fa-solid fa-star"></i>
                                                </li>
                                                <li>
                                                    <i class="fa-solid fa-star"></i>
                                                </li>
                                                <li>
                                                    <i class="fa-solid fa-star"></i>
                                                </li>
                                                <li>
                                                    <i class="fa-solid fa-star"></i>
                                                </li>
                                                <li>
                                                    <i class="fa-solid fa-star"></i>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="origin" class="tab-pane fade">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="trending_content padding_bottom">
                                <div class="trending_upper_portion">
                                    <figure class="mb-0 img_width"><img src="./assets/images/trending_games_1.png" alt=""></figure>
                                    <div class="hover_box_plus"><a href="#"><figure class="mb-0"><img src="./assets/images/box_hover_plus.png" alt=""></figure></a></div>
                                </div>
                                <div class="trending_lower_portion_wrapper">
                                    <div class="trending_lower_portion">
                                        <div class="trending_span_wrapper">
                                            <span>Valorant</span>
                                        </div>
                                        <ul class="list-unstyled mb-0">
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                       <!--<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="trending_content padding_bottom">
                                <div class="trending_upper_portion">
                                    <figure class="mb-0 img_width"><img src="./assets/images/trending_games_2.jpg" alt=""></figure>
                                    <div class="hover_box_plus"><a href="#"><figure class="mb-0"><img src="./assets/images/box_hover_plus.png" alt=""></figure></a></div>
                                </div>
                                <div class="trending_lower_portion_wrapper">
                                    <div class="trending_lower_portion">
                                        <div class="trending_span_wrapper">
                                            <span>Call Of Duty</span>
                                        </div>
                                        <ul class="list-unstyled mb-0">
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div> -->
                <div id="playstation" class="tab-pane fade">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="trending_content padding_bottom">
                                <div class="trending_upper_portion">
                                    <figure class="mb-0 img_width"><img src="./assets/images/trending_games_3.jpg" alt=""></figure>
                                    <div class="hover_box_plus"><a href="#"><figure class="mb-0"><img src="./assets/images/box_hover_plus.png" alt=""></figure></a></div>
                                </div>
                                <div class="trending_lower_portion_wrapper">
                                    <div class="trending_lower_portion">
                                        <div class="trending_span_wrapper">
                                            <span>Fortnite</span>
                                        </div>
                                        <ul class="list-unstyled mb-0">
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="trending_content padding_bottom">
                                <div class="trending_upper_portion">
                                    <figure class="mb-0 img_width"><img src="./assets/images/trending_games_4.jpg" alt=""></figure>
                                    <div class="hover_box_plus"><a href="#"><figure class="mb-0"><img src="./assets/images/box_hover_plus.png" alt=""></figure></a></div>
                                </div>
                                <div class="trending_lower_portion_wrapper">
                                    <div class="trending_lower_portion">
                                        <div class="trending_span_wrapper">
                                            <span>Anthem</span>
                                        </div>
                                        <ul class="list-unstyled mb-0">
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>   
                </div>
                <div id="steam" class="tab-pane fade">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="trending_content padding_bottom">
                                <div class="trending_upper_portion">
                                    <figure class="mb-0 img_width"><img src="./assets/images/trending_games_1.jpg" alt=""></figure>
                                    <div class="hover_box_plus"><a href="#"><figure class="mb-0"><img src="./assets/images/box_hover_plus.png" alt=""></figure></a></div>
                                </div>
                                <div class="trending_lower_portion_wrapper">
                                    <div class="trending_lower_portion">
                                        <div class="trending_span_wrapper">
                                            <span>Valorant</span>
                                        </div>
                                        <ul class="list-unstyled mb-0">
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="trending_content padding_bottom">
                                <div class="trending_upper_portion">
                                    <figure class="mb-0 img_width"><img src="./assets/images/trending_games_3.jpg" alt=""></figure>
                                    <div class="hover_box_plus"><a href="#"><figure class="mb-0"><img src="./assets/images/box_hover_plus.png" alt=""></figure></a></div>
                                </div>
                                <div class="trending_lower_portion_wrapper">
                                    <div class="trending_lower_portion">
                                        <div class="trending_span_wrapper">
                                            <span>Fortnite</span>
                                        </div>
                                        <ul class="list-unstyled mb-0">
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
                <div id="uplay" class="tab-pane fade">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="trending_content padding_bottom">
                                <div class="trending_upper_portion">
                                    <figure class="mb-0 img_width"><img src="./assets/images/trending_games_2.jpg" alt=""></figure>
                                    <div class="hover_box_plus"><a href="#"><figure class="mb-0"><img src="./assets/images/box_hover_plus.png" alt=""></figure></a></div>
                                </div>
                                <div class="trending_lower_portion_wrapper">
                                    <div class="trending_lower_portion">
                                        <div class="trending_span_wrapper">
                                            <span>Call Of Duty</span>
                                        </div>
                                        <ul class="list-unstyled mb-0">
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="trending_content padding_bottom">
                                <div class="trending_upper_portion">
                                    <figure class="mb-0 img_width"><img src="./assets/images/trending_games_4.jpg" alt=""></figure>
                                    <div class="hover_box_plus"><a href="#"><figure class="mb-0"><img src="./assets/images/box_hover_plus.png" alt=""></figure></a></div>
                                </div>
                                <div class="trending_lower_portion_wrapper">
                                    <div class="trending_lower_portion">
                                        <div class="trending_span_wrapper">
                                            <span>Anthem</span>
                                        </div>
                                        <ul class="list-unstyled mb-0">
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
                <div id="xbox" class="tab-pane fade">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="trending_content padding_bottom">
                                <div class="trending_upper_portion">
                                    <figure class="mb-0 img_width"><img src="./assets/images/trending_games_1.jpg" alt=""></figure>
                                    <div class="hover_box_plus"><a href="#"><figure class="mb-0"><img src="./assets/images/box_hover_plus.png" alt=""></figure></a></div>
                                </div>
                                <div class="trending_lower_portion_wrapper">
                                    <div class="trending_lower_portion">
                                        <div class="trending_span_wrapper">
                                            <span>Valorant</span>
                                        </div>
                                        <ul class="list-unstyled mb-0">
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                            <div class="trending_content padding_bottom">
                                <div class="trending_upper_portion">
                                    <figure class="mb-0 img_width"><img src="./assets/images/trending_games_4.jpg" alt=""></figure>
                                    <div class="hover_box_plus"><a href="#"><figure class="mb-0"><img src="./assets/images/box_hover_plus.png" alt=""></figure></a></div>
                                </div>
                                <div class="trending_lower_portion_wrapper">
                                    <div class="trending_lower_portion">
                                        <div class="trending_span_wrapper">
                                            <span>Anthem</span>
                                        </div>
                                        <ul class="list-unstyled mb-0">
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                            <li>
                                                <i class="fa-solid fa-star"></i>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div> 
    </div>
</section>
<!-- GAMING TOURNAMENTS SECTION -->
<section class="gaming_tournament-section">
    <div class="container">
        <div class="row" data-aos="fade-up">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pr-md-0 pr-sm-none">
                <div class="gaming_tournament_image">
                    <figure class="mb-0">
                        <img class="img-fluid" src="./assets/images/gaming_tournament_img.jpg" alt="">
                    </figure>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pl-md-0 pl-sm-none">
                <div class="gaming_tournament_content">
                    <h2 class="text-left mb-0">NELER YAPIYORUZ?</h2>
                    <figure class="mb-0">
                        <img class="img-fluid" src="./assets/images/gaming_tournament_logo.png" alt="">
                    </figure>
                    <p class="sub_p mb-0">
                    Temel amacımız web tabanlı yazılım ile espor sektörünün önemli bir parçası olan oyuncular ile kulüpler arasında köprü kurarak yürütülecek olan ilişkinin sağlıklı bir şekilde ilerlemesini sağlamak, oyuncuların maruz kaldıkları zorbalıklara karşı yanlarında olmak ve kulüpler içinde nitelikli oyunculara erişimin kolaylaştırılmasıdır. Bu doğrultuda geliştirilecek olan sistemde:


                    </p>
                    <p class="sub_p mb-4 d-lg-block d-none">
                    <p>  • Espor oyuncularının kulüplere dahil olmasında ihtiyaç duyacakları referansın sağlanması. </p>

                    <p> • Espor kulüplerinin aradıkları nitelikli oyuncuları bulmalarının sağlanması.</p>
    

                    <p> • Oyuncu ve kulüpler arasında yetersiz hazırlanan sözleşmeler sebebiyle yaşanan mağduriyetlerin azaltılması.</p>

                    <p> • Bu sistemden yer alan oyuncu ve kulüplerin deneyimleri, başarıları paylaşılarak oluşturulacak olan kitlenin büyütülmesi hedeflenmektedir.</p>
                    </p>
                    <div class="btn_wrapper">
                        <a class="text-decoration-none readmore_btn" href="./about.php">Devamını Oku</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- UPCOMING MATCHES SECTION 
<section class="upcoming_matches_section">
    <div class="container">
        <div class="row" data-aos="fade-up">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2>Upcoming Matches</h2>
                <figure class="mb-5">
                    <img src="./assets/images/upcoming_matches_logo.png" alt="">
                </figure>
            </div>
        </div>
        <div class="row" data-aos="fade-up">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 d-table align-item-center">
                <div class="upcoming_matches_content padding_bottom">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="first_portion">
                                <figure class="mb-0">
                                    <img src="./assets/images/upcoming_matches_1.png" alt="">
                                </figure>
                                <div class="vs_wrapper">
                                    <span>VS</span>
                                </div>
                                <figure class="mb-0">
                                    <img src="./assets/images/upcoming_matches_2.png" alt="">
                                </figure>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="center_portion">
                                <p class="mb-0">Call Of Duty Tournament</p>
                                <div class="center_span_wrapper">
                                    <i class="fa-solid fa-calendar-days mr-1" aria-hidden="true"></i><span class="mr-3">March 29,2021</span>
                                    <i class="fa-regular fa-clock mr-1"></i><span>4:00 Pm</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="last_portion">
                                <div class="last_span_wrapper">
                                    <span class="groups">2 Groups</span>
                                    <span class="players">32 Players</span>
                                </div>
                                <div class="last_span_wrapper2">
                                    <span class="groups">Prize Pool</span>
                                    <span class="players">$5000</span>
                                </div>
                                <a href="#"><i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 d-table align-item-center">
                <div class="upcoming_matches_content mb-4 padding_bottom">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="first_portion">
                                <figure class="mb-0">
                                    <img src="./assets/images/upcoming_matches_1.png" alt="">
                                </figure>
                                <div class="vs_wrapper">
                                    <span>VS</span>
                                </div>
                                <figure class="mb-0">
                                    <img src="./assets/images/upcoming_matches_2.png" alt="">
                                </figure>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="center_portion">
                                <p class="mb-0">Battlefield-4 Tournament</p>
                                <div class="center_span_wrapper">
                                    <i class="fa-solid fa-calendar-days mr-1" aria-hidden="true"></i><span class="mr-3">March 29,2021</span>
                                    <i class="fa-regular fa-clock mr-1"></i><span>4:00 Pm</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="last_portion">
                                <div class="last_span_wrapper">
                                    <span class="groups">2 Groups</span>
                                    <span class="players">32 Players</span>
                                </div>
                                <div class="last_span_wrapper2">
                                    <span class="groups">Prize Pool</span>
                                    <span class="players">$5000</span>
                                </div>
                                <a href="#"><i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 d-table align-item-center">
                <div class="upcoming_matches_content mb-4 padding_bottom">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="first_portion">
                                <figure class="mb-0">
                                    <img src="./assets/images/upcoming_matches_1.png" alt="">
                                </figure>
                                <div class="vs_wrapper">
                                    <span>VS</span>
                                </div>
                                <figure class="mb-0">
                                    <img src="./assets/images/upcoming_matches_2.png" alt="">
                                </figure>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="center_portion">
                                <p class="mb-0">Anthem Tournament</p>
                                <div class="center_span_wrapper">
                                    <i class="fa-solid fa-calendar-days mr-1" aria-hidden="true"></i><span class="mr-3">March 29,2021</span>
                                    <i class="fa-regular fa-clock mr-1"></i><span>4:00 Pm</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="last_portion">
                                <div class="last_span_wrapper">
                                    <span class="groups">2 Groups</span>
                                    <span class="players">32 Players</span>
                                </div>
                                <div class="last_span_wrapper2">
                                    <span class="groups">Prize Pool</span>
                                    <span class="players">$5000</span>
                                </div>
                                <a href="#"><i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 d-table align-item-center">
                <div class="upcoming_matches_content mb-2 padding_bottom">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="first_portion">
                                <figure class="mb-0">
                                    <img src="./assets/images/upcoming_matches_1.png" alt="">
                                </figure>
                                <div class="vs_wrapper">
                                    <span>VS</span>
                                </div>
                                <figure class="mb-0">
                                    <img src="./assets/images/upcoming_matches_2.png" alt="">
                                </figure>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="center_portion">
                                <p class="mb-0">Pubg Classic Tournament</p>
                                <div class="center_span_wrapper">
                                    <i class="fa-solid fa-calendar-days mr-1" aria-hidden="true"></i><span class="mr-3">March 29,2021</span>
                                    <i class="fa-regular fa-clock mr-1"></i><span>4:00 Pm</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="last_portion">
                                <div class="last_span_wrapper">
                                    <span class="groups">2 Groups</span>
                                    <span class="players">32 Players</span>
                                </div>
                                <div class="last_span_wrapper2">
                                    <span class="groups">Prize Pool</span>
                                    <span class="players">$5000</span>
                                </div>
                                <a href="#"><i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="btn_wrapper">
            <a class="text-decoration-none viewall_btn" href="./match_detail.html">View All</a>
        </div>  
    </div>
</section>-->
<!-- LIVE STREAMING SECTION -->
<style>
    /* Mesafe eklemek için uygun seçicileri kullanarak stil kurallarını tanımlayın */
    .thumb {
        margin-bottom: 20px; /* Video ve kapak fotoğrafları arasındaki alt boşluğu ayarlayın */
    }

    .thumb:first-child {
        margin-top: 20px; /* İlk video veya kapak fotoğrafı ile üst boşluğu ayarlayın */
    }

    .position-relative {
        margin-bottom: 40px; /* Video veya kapak fotoğrafı blokları arasındaki dikey boşluğu ayarlayın */
    }
</style>

<section class="live_stream_section">
    <div class="container">
        <div class="row" data-aos="fade-up">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2>REHBER</h2>
                <figure class="mb-5">
                    <img src="./assets/images/live_stream_logo.png" alt="">
                </figure>
            </div>
        </div>
        <div class="row first_row" data-aos="fade-up">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="position-relative">
                    <a class="popup-vimeo" href="https://www.youtube.com/watch?v=flRChTxHZo8">
                        <figure class="mb-0">
                            <img class="thumb" style="cursor: pointer" src="./assets/images/1280px-Valorant_logo_-_pink_color_version.svg.png" alt="">
                        </figure>
                    </a>
                    <div class="match_span_wrapper">
                        <span>Match</span>
                    </div>
                    <h4>Immortal Eloda Cypher'ı Severiz</h4>
                </div>
            </div>
        </div>
        <div class="row second_row" data-aos="fade-up">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="position-relative margin_left">
                    <a class="popup-vimeo" href="https://www.youtube.com/watch?v=EHrPC54inPk">
                        <figure class="mb-0">
                            <img class="thumb" style="cursor: pointer" src="./assets/images/agents-group-31d7ce5a3637e45d8b25d2fd03159e6c.png" alt="">
                        </figure>
                    </a>
                    <div class="match_span_wrapper">
                        <span>Match</span>
                    </div>
                    <h4>4K Valorant Montage</h4>
                </div>
            </div> 
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="position-relative padding_left">
                    <a class="popup-vimeo" href="https://www.youtube.com/watch?v=OhT2q6n76ek">
                        <figure class="mb-0">
                            <img class="thumb" style="cursor: pointer" src="./assets/images/live_stream_3.png" alt="">
                        </figure>
                    </a>
                    <div class="match_span_wrapper">
                        <span>Match</span>
                    </div>
                    <h4>SCU Esports x HU Esports</h4>
                </div>
            </div> 
        </div>
    </div>
</section>

<!-- EXPLORE OUR PRODUCTS SECTION 
<section class="products_section">
    <div class="container">
        <div class="row" data-aos="fade-up">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2>Explore Our Products</h2>
                <figure class="mb-5">
                    <img src="./assets/images/products_logo.png" alt="">
                </figure>
            </div>
        </div>
        <div class="row" data-aos="fade-up">
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 d-table align-item-center">
                <div class="products_content padding_bottom">
                    <div class="upper_portion">
                        <figure class="mb-0"><img src="./assets/images/products_1.png" alt=""></figure>
                    </div>
                    <div class="lower_portion_wrapper">
                        <div class="lower_portion">
                            <h3>$44</h3>
                            <h6>Gaming Handle</h6>
                            <div class="socialmedia_icons_wrapper">
                                <a href="./gallery.html"><i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 d-table align-item-center">
                <div class="products_content padding_bottom">
                    <div class="upper_portion">
                        <figure class="mb-0"><img src="./assets/images/products_2.png" alt=""></figure>
                    </div>
                    <div class="lower_portion_wrapper">
                        <div class="lower_portion">
                            <h3>$50</h3>
                            <h6>Headphones</h6>
                            <div class="socialmedia_icons_wrapper">
                                <a href="./gallery.html"><i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 d-table align-item-center">
                <div class="products_content padding_bottom">
                    <div class="upper_portion">
                        <figure class="mb-0"><img src="./assets/images/products_3.png" alt=""></figure>
                    </div>
                    <div class="lower_portion_wrapper">
                        <div class="lower_portion">
                            <h3>$90</h3>
                            <h6>T-Shirts</h6>
                            <div class="socialmedia_icons_wrapper">
                                <a href="./gallery.html"><i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>-->
<!-- GET ALL THE BENEFITS SECTION -->

<div class="benefits_section">
    <div class="container">
        <div class="row" data-aos="fade-up">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="benefits-content">
                    <p class="join_benefit"><span>İş Ortaklarımıza</span> Katılmak İster Misiniz?</p>
                    <p class="benefit_span">Takım Arayan Oyuncuları ve Oyuncu Arayan Takımları Bekliyoruz </p>
                    <figure>
                        <img src="./assets/images/benefits_logo.png" alt="">
                    </figure>
                    <p class="pp">
                   
                    </p>
                </div> 
                <div class="btn_wrapper">
                <?php   
                    if (!isset($_SESSION['email'])) {

                        echo '<a class="text-decoration-none joinus_btn" href="./signup.php">Şimdi Kayıt Ol</a>';
                    } 
                    else { 

                        echo '<a class="text-decoration-none joinus_btn" href="./kesfet.php">Keşfet</a>'; 
                    }

                ?>
                   
                </div>  
            </div>
        </div>
    </div>
</div>


<!-- BLOG POSTS SECTION -->
<section class="blog_posts_section">
    <div class="container">
        <div class="row" data-aos="fade-up">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2>HABERLER</h2>
                <figure class="mb-5">
                    <img src="./assets/images/blog_post_logo.png" alt="">
                </figure>
            </div>
        </div>
        <div class="row" data-aos="fade-up">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="blog_posts_content  padding_bottom">
                    <div class="upper_portion">
                        <figure class="mb-0"><img src="./assets/images/blog_post_1.png" alt=""></figure>
                    </div>
                    <div class="lower_portion_wrapper">
                        <div class="lower_portion">
                            <div class="span_wrapper">
                                <i class="fa-solid fa-calendar-days" aria-hidden="true"></i><span> 20 Kasım, 2022  |  stephano</span>
                            </div>
                            <a href="#" class="text-decoration-none" data-toggle="modal" data-target="#blog-model-1"><p class="mb-0">RIOT PARTNER  PROGRAMINA DAHİL OLAN TAKIMLAR BELLİ OLDU</p></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="blog_posts_content padding_bottom">
                    <div class="upper_portion">
                        <figure class="mb-0"><img src="./assets/images/blog_post_5.png" alt=""></figure>
                    </div>
                    <div class="lower_portion_wrapper">
                        <div class="lower_portion">
                            <div class="span_wrapper">
                                <i class="fa-solid fa-calendar-days" aria-hidden="true"></i><span> 24 Aralık, 2022  |  stephano</span>
                            </div>
                            <a href="#" class="text-decoration-none" data-toggle="modal" data-target="#blog-model-2"><p class="mb-0">VALORANT CHALLENGERS TÜRKİYE BİRLİK LİGİ NEDİR</p></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="blog_posts_content padding_bottom">
                    <div class="upper_portion">
                        <figure class="mb-0"><img src="./assets/images/blog_post_3.png" alt=""></figure>
                    </div>
                    <div class="lower_portion_wrapper">
                        <div class="lower_portion">
                            <div class="span_wrapper">
                                <i class="fa-solid fa-calendar-days" aria-hidden="true"></i><span> 14 Ocak, 2023 |  stephano</span>
                            </div>
                            <a href="#" class="text-decoration-none" data-toggle="modal" data-target="#blog-model-3"><p class="mb-0">AVRUPADAKİ GURURLARIMIZI DAHA YAKINDAN TANIYALIM</p></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="blog_posts_content padding_bottom">
                    <div class="upper_portion">
                        <figure class="mb-0"><img src="./assets/images/blog_post_2.png" alt=""></figure>
                    </div>
                    <div class="lower_portion_wrapper">
                        <div class="lower_portion">
                            <div class="span_wrapper">
                                <i class="fa-solid fa-calendar-days" aria-hidden="true"></i><span> 21 Ocak, 2023  |  stephano</span>
                            </div>
                            <a href="#" class="text-decoration-none" data-toggle="modal" data-target="#blog-model-4"><p class="mb-0">RIOT KAMPÜS ELÇİLİĞİ PROGRAMI NEDİR</p></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="blog_posts_content padding_bottom">
                    <div class="upper_portion">
                        <figure class="mb-0"><img src="./assets/images/blog_post_4.png" alt=""></figure>
                    </div>
                    <div class="lower_portion_wrapper">
                        <div class="lower_portion">
                            <div class="span_wrapper">
                                <i class="fa-solid fa-calendar-days" aria-hidden="true"></i><span> 11 Şubat, 2023 |  stephano</span>
                            </div>
                            <a href="#" class="text-decoration-none" data-toggle="modal" data-target="#blog-model-5"><p class="mb-0">VALORANT 101</p></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="blog_posts_content padding_bottom">
                    <div class="upper_portion">
                        <figure class="mb-0"><img src="./assets/images/blog_post_6.png" alt=""></figure>
                    </div>
                    <div class="lower_portion_wrapper">
                        <div class="lower_portion">
                            <div class="span_wrapper">
                                <i class="fa-solid fa-calendar-days" aria-hidden="true"></i><span> 07 Mart, 2023 |  stephano</span>
                            </div>
                            <a href="#" class="text-decoration-none" data-toggle="modal" data-target="#blog-model-6"><p class="mb-0">CS:GO'da Eternal Fire Aman Vermiyor</p></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- GET IN TOUCH SECTION -->
<section class="get_in_touch_section">
    <div class="container">
        <div class="row" data-aos="fade-up">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2>Bizimle İletişime Geç</h2>
                <figure class="mb-5">
                    <img src="./assets/images/in_touch_logo.png" alt="">
                </figure>
            </div>
        </div>
        <div class="get_in_touch_content" data-aos="fade-up">
            <form  method = "post" action = "">
                <div class="form-row pb-3">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <input type="text" name="isim" id="fullname" class="form-control upper_layer_name margin_bottom" placeholder="İsim" >
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <input type="email" name="email" id="emailaddress" class="form-control upper_layer margin_bottom" placeholder="Email">
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <input type="tel" name="telefon" id="phoneno" class="form-control upper_layer margin_bottom" placeholder="Telefon">
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <input type="text" name="mesaj" id="message" class="form-control lower_message margin_bottom" placeholder="Mesaj">
                    </div>
                </div>

                <div class="form_button_wrapper text-center">
                    <button type="submit" name="iletisimGonder" id="submitbutton" class="button_style">Şimdi Gönder</button>
                </div>
            </form>
        </div>
    </div>
</section>
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
<!-- BLOG SECTION POPUP -->
<div id="blog-model-1" class="modal fade blog-model-con" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
       <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" ><i class="fa-solid fa-x"></i></span></button>
            </div>
            <div class="modal-body">
                <div class="blog-box-item mb-0">
                    <div class="blog-img">
                        <figure class="mb-0">
                            <img src="./assets/images/blog_post_1.png" alt="blog-img" class="img-fluid">
                        </figure>
                    </div>
                    <div class="blog-content pl-0 pr-0">
                        <div class="blog-auteher-title">
                            <span></span>
                            <span class="float-lg-right">20 Kasım, 2022</span>
                        </div>
                        <div class="span_wrapper">
                            <i class="fa-solid fa-calendar-days" aria-hidden="true"></i><span> 20 Kasım, 2022 |  stephano</span>
                        </div>
                        <p class="blog_p mb-0">RIOT PARTNER  PROGRAMINA DAHİL OLAN TAKIMLAR BELLİ OLDU</p>
                        <p class="pp">
                        Riot Games, yeni bir sistemi bizimle buluşturdu. Ekosistemine partner takımları dahil etti. Uluslararası ekipler tarafından seçilen toplam 30 takım (EMEA, Pasifik ve Amerika kıtası dahil olmak üzere her kıtadan 10 takım), kendi bölgelerin uluslararası liginde boy gösterecek ve lig kazananları Masters turnuvasında oynama hakkı kazanacak. Bunun yanı sıra partner olma hakkı kazanan takımlar minimum 600 bin dolar, maksimum 1.5 milyon dolarlık ödeneğe sahip olabilecekler.
Peki neden partnerlik sistemi?  “Valorant için uzun vadeli partnerlik programımızı, takımlar hem kendi içlerinde hem de valorant esporu adına büyüyebilsin diye tasarladık.” –Whalen Rozelle, Riot Küresel Espor Operasyonları Lideri
Başvurulan takımları üç kriter üzerinden değerlendirilerek dünyada 30 takım partner seçildi:
<p>-Taraftarları her şeyin önüne koyan prensibimizi paylaşan, kapsayıcı topluluğumuzun arkasında olan ve profesyonelleri kararlı bir şekilde destekleyen kulüpler,</p>
<p>-Ürettikleri ilgi çekici içerikler, markalarının gücü ve heyecan uyandıran kadroları ile taraftarlarıyla güçlü bir bağ kuran kulüpler,</p>
<p>-Uzun vadeli düşünen, sürdürülebilirleğe odaklanan kulüpler.</p>
<p>EMEA Bölgesinde ülkemizden 2 takımımız partner olma şansını yakaladı. FUT Esports ve BBL Esports takımlarımızı tebrik eder, başarılar dileriz.</p>

                        </p>
                        <h2>Bizimle İletişime Geçin</h2>
                        <form class="contact-form blog-model-form">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group mb-0">    
                                    <input type="text" class="form_style" placeholder="İsim" name="name"> 
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group mb-0">
                                    <input type="email" class="form_style" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group mb-0">    
                                    <input type="tel" class="form_style" placeholder="Telefon"> 
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group mb-0">    
                                    <input type="text" class="form_style" placeholder="Konu"> 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class=" form-group mb-0">    
                                    <textarea class="form_style" placeholder="Mesaj" rows="3" name="comments"></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="appointment-btn">Gönder</button>
                        </form>
                    </div>
                </div>
            </div>
       </div>
    </div>
</div>
<div id="blog-model-2" class="modal fade blog-model-con" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
       <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" ><i class="fa-solid fa-x"></i></span></button>
            </div>
            <div class="modal-body">
                <div class="blog-box-item mb-0">
                    <div class="blog-img">
                        <figure class="mb-0">
                            <img src="./assets/images/blog_post_5.png" alt="blog-img" class="img-fluid">
                        </figure>
                    </div>
                    <div class="blog-content pl-0 pr-0">
                        <div class="blog-auteher-title">
                            <span></span>
                            <span class="float-lg-right">24 Aralık, 2022</span>
                        </div>
                        <div class="span_wrapper">
                            <i class="fa-solid fa-calendar-days" aria-hidden="true"></i><span> 24 Aralık, 2022 |  stephano</span>
                        </div>
                        <p class="blog_p mb-0">VALORANT CHALLENGERS TÜRKİYE BİRLİK LİGİ NEDİR</p>
                        <p class="pp">
                        Riot Games’in, Avrupa, Orta Doğu ve Afrika bölgesinde Valorant Oyunu’nun profesyonel liglerini espor organizatörü iş ortakları üzerinden yapma kararı alması üzerine Türkiye için ESA Esports & Media  Riot’un münhasır VALORANT Espor İş Ortağı olarak seçildi. Dünyanın en büyük VALORANT topluluklarından birine sahip olan ülkemizin tek başına bir bölge sayıldığı bu sistem içinde, ülkemizdeki lig adının Türkçe olmasına karar verildi ve lige tüm ülkeyi ortak bir paydada birleştirecek “Birlik” ismi koyuldu.
2023 yılında ligimizde Fire Flux, Parla Esports, Papara Supermassive, S2G Esports, İstanbul Wildcats, Fenerbahçe Esports, Galatasaray Esports, Digital Athletics, Thunderbolts Gaming ve Galakticos olmak üzere toplamda 10 takım bulunuyor.
</p>
<h2>Bizimle İletişime Geçin</h2>
                        <form class="contact-form blog-model-form">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group mb-0">    
                                    <input type="text" class="form_style" placeholder="İsim" name="name"> 
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group mb-0">
                                    <input type="email" class="form_style" placeholder="Email" name = "email">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group mb-0">    
                                    <input type="tel" class="form_style" placeholder="Telefon" name = "telefon"> 
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group mb-0">    
                                    <input type="text" class="form_style" placeholder="Konu" name = "konu"> 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class=" form-group mb-0">    
                                    <textarea class="form_style" placeholder="Mesaj" rows="3" name="comments"></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name = "gonder" class="appointment-btn">Gönder</button>
                        </form>
                    </div>
                </div>
            </div>
       </div>
    </div>
</div>
<div id="blog-model-3" class="modal fade blog-model-con" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
       <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" ><i class="fa-solid fa-x"></i></span></button>
            </div>
            <div class="modal-body">
                <div class="blog-box-item mb-0">
                    <div class="blog-img">
                        <figure class="mb-0">
                            <img src="./assets/images/blog_post_3.png" alt="blog-img" class="img-fluid">
                        </figure>
                    </div>
                    <div class="blog-content pl-0 pr-0">
                        <div class="blog-auteher-title">
                            <span></span>
                            <span class="float-lg-right">14 Ocak, 2023</span>
                        </div>
                        <div class="span_wrapper">
                            <i class="fa-solid fa-calendar-days" aria-hidden="true"></i><span> 14 Ocak, 2023  |  stephano</span>
                        </div>
                        <p class="blog_p mb-0">AVRUPADAKİ GURURLARIMIZI DAHA YAKINDAN TANIYALIM</p>
                        <p class="pp">
                        <p>Natus Vincere (NAVI) ve Fnatic (FNC) takımlarında bayrağımızı dalgalandıran cNed ve Alfajer nickli oyuncularımızı daha yakından tanıyalım.</p>
                        <p>Natus Vincere (NAVI) forması giyen Mehmet Yağız ‘cNed’ İpek 18 Ocak 2002 doğumludur. Valorant’a geçmeden Zula oyununda da profesyonel kariyere sahip olan Mehmet Valorant kariyerine dillere destan bir biçimde devam ediyor. Daha öncesinde ülkemizin takımlarında olan BBL Esports forması giyen Mehmet sonrasında Acend kulübüne transfer oldu. Orada dünyanın en iyi turnuvasında şampiyon olduktan sonra Natus Vincere takımının yolunu tuttu.</p>
                        <p>Fnatic (FNC) forması giyen Emir Ali ‘Alfajer’ Bedel  10 Haziran 2005 doğumludur. Ülkemizin takımlarından Surreal Esports da forma giyen Emir orada gösterdiği performanstan sonra Avrupanın önde gelen kulüplerinin radarına girdi. Eninde sonunda Fnatic’in yolunu tutan Emir takımını sırtlayan oyuncuların başından gelmekte.
Mehmet ve Ali’yi tüm içtenliğimizle destekliyoruz.</p>
                        </p>
                        <h2>Bizimle İletişime Geçin</h2>
                        <form class="contact-form blog-model-form">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group mb-0">    
                                    <input type="text" class="form_style" placeholder="İsim" name="name"> 
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group mb-0">
                                    <input type="email" class="form_style" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group mb-0">    
                                    <input type="tel" class="form_style" placeholder="Telefon"> 
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group mb-0">    
                                    <input type="text" class="form_style" placeholder="Konu"> 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class=" form-group mb-0">    
                                    <textarea class="form_style" placeholder="Mesaj" rows="3" name="comments"></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="appointment-btn">Gönder</button>
                        </form>
                    </div>
                </div>
            </div>
       </div>
    </div>
</div>
<div id="blog-model-4" class="modal fade blog-model-con" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
       <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" ><i class="fa-solid fa-x"></i></span></button>
            </div>
            <div class="modal-body">
                <div class="blog-box-item mb-0">
                    <div class="blog-img">
                        <figure class="mb-0">
                            <img src="./assets/images/blog_post_2.png" alt="blog-img" class="img-fluid">
                        </figure>
                    </div>
                    <div class="blog-content pl-0 pr-0">
                        <div class="blog-auteher-title">
                            <span></span>
                            <span class="float-lg-right">21 Ocak, 2023</span>
                        </div>
                        <div class="span_wrapper">
                            <i class="fa-solid fa-calendar-days" aria-hidden="true"></i><span> 21 Ocak, 2023  |  stephano</span>
                        </div>
                        <p class="blog_p mb-0">RIOT KAMPÜS ELÇİLİĞİ PROGRAMI NEDİR</p>
                        <p class="pp">
                        <p>Üniversite öğrencileri, geniş topluluğunun en önemli parçalarından. Bu kapsamda üniversitelerde oyunlarla ve espor ile ilgilenen oyunculara destek olarak oyun deneyimini geliştirmek de  aynı oranda önem taşıyor. Kampüs Elçileri Programı, üniversitelerde belirlenmiş elçiler ile birlikte çalışarak bunu yapmaya olanak sağlayan bir program. İşbirliği yaparak espora ve okuduğu üniversitenin oyunlarına yönelik topluluklarına katkıda bulunacak, bu heyecan verici deneyimi okulunun Riot ile birlikte çalışan temsilcileri olarak yaşayacak elçiler neler mi yapacak?</p>
                        <p>Riot Games ile iletişim kurarak üniversitelerinin sesi olacaklar: Bizimle birlikte, üniversitelerinde oyunlarımızın ve esporun bilinirliğini arttıracaklar. Okullarındaki oyuncuların şikayetlerini, önerilerini dinleyecek ve Riot Games’e aktaracaklar. Farklıüniversitelerdeki oyunlarımızı oynayan oyuncuların sesini daha iyi duyabilmemiz ve onları daha doğru anlayabilmemiz için bize yardımcı olacaklar.</p>
                        <p>Turnuva organize edecekler: Kampüs Elçileri Programıyla birlikte kendi okullarında turnuvalar düzenleyecekler, okullarının üniversiteler arası turnuvalara katılımından sorumlu olacaklar.</p>
                        <p>Etkinlikler düzenleyecekler: Elçilerimizle birçok farklı etkinlikte birlikte çalışmak istiyoruz. Dünya Şampiyonası maçlarını üniversite arkadaşlarınla toplanıp birlikte seyretmek ya da ŞL maçlarına topluca gelip lig heyecanını yerinde yaşamak fena mı olurdu?</p>
</p>
<h2>Bizimle İletişime Geçin</h2>
                        <form class="contact-form blog-model-form">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group mb-0">    
                                    <input type="text" class="form_style" placeholder="İsim" name="name"> 
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group mb-0">
                                    <input type="email" class="form_style" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group mb-0">    
                                    <input type="tel" class="form_style" placeholder="Telefon"> 
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group mb-0">    
                                    <input type="text" class="form_style" placeholder="Konu"> 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class=" form-group mb-0">    
                                    <textarea class="form_style" placeholder="Mesaj" rows="3" name="comments"></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="appointment-btn">Gönder</button>
                        </form>
                    </div>
                </div>
            </div>
       </div>
    </div>
</div>
<div id="blog-model-5" class="modal fade blog-model-con" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
       <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" ><i class="fa-solid fa-x"></i></span></button>
            </div>
            <div class="modal-body">
                <div class="blog-box-item mb-0">
                    <div class="blog-img">
                        <figure class="mb-0">
                            <img src="./assets/images/blog_post_4.png" alt="blog-img" class="img-fluid">
                        </figure>
                    </div>
                    <div class="blog-content pl-0 pr-0">
                        <div class="blog-auteher-title">
                            <span></span>
                            <span class="float-lg-right">11 Şubat, 2023</span>
                        </div>
                        <div class="span_wrapper">
                            <i class="fa-solid fa-calendar-days" aria-hidden="true"></i><span> 11 Subat, 2023  |  stephano</span>
                        </div>
                        <p class="blog_p mb-0">VALORANT 101</p>
                        <p class="pp">
                        <p>Valorant kısaca spike’i yerleştirmenin farklı yollarını keşfetmemiz gereken ve her türden kavgacıları, stratejistleri ve avcıları kullanarak rakiplerimizi alt ederek galibiyete uzanacağımız bir oyundur.</p>
                        <p>Valorant da jett, raze, breach,omen, brimstone, phoenix, sage, sova, viper, cypher, reyna, killjoy, skye, yoru, astra, kay/o, chamber, neon, fade ve  harbor olmak üzere toplamda 20 ajan vardır. Bu ajanlar zafer yolunda bizlere eşlik ediyorlar. </p>
                        <p>Ajanlar 5 farklı kategoriye ayrılıyor,</p>
                        <p>Düellocu: Takımın birincil ateş gücünü oluştururlar. Agresif ve doğrudan rakibe yönelik yetenekleri ile düellocular son derece saldırgan bir sınıf.</p>
                        <p>Öncü:  Büyük çatışmalardan önce ortamı ısıtan öncülerimiz savunmayı kırmak konusunda oldukça başarılı bir sınıftır.</p>
                        <p>Kontrol Uzmanı: Kontrol sağlamayı amaçlar ve rakibin görüş gibi önemli yeteneklerini kısıtlayarak onları çaresiz bırakır.</p>
                        <p>Gözcü:  Diğer sınıflara kıyasla biraz daha geri planda oynamaları daha akıllıca olan gözcüler hem saldırıda hem de savunmada hayati önem taşırlar. Sahip oldukları yetenek setleriyle birden fazla alanı kontrolleri altına alabilirler.</p>
</p>
</p>
<h2>Bizimle İletişime Geçin</h2>
                        <form class="contact-form blog-model-form">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group mb-0">    
                                    <input type="text" class="form_style" placeholder="İsim" name="name"> 
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group mb-0">
                                    <input type="email" class="form_style" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group mb-0">    
                                    <input type="tel" class="form_style" placeholder="Telefon"> 
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group mb-0">    
                                    <input type="text" class="form_style" placeholder="Konu"> 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class=" form-group mb-0">    
                                    <textarea class="form_style" placeholder="Mesaj" rows="3" name="comments"></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="appointment-btn">Gönder</button>
                        </form>
                    </div>
                </div>
            </div>
       </div>
    </div>
</div>
<div id="blog-model-6" class="modal fade blog-model-con" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
       <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" ><i class="fa-solid fa-x"></i></span></button>
            </div>
            <div class="modal-body">
                <div class="blog-box-item mb-0">
                    <div class="blog-img">
                        <figure class="mb-0">
                            <img src="./assets/images/blog_post_6.png" alt="blog-img" class="img-fluid">
                        </figure>
                    </div>
                    <div class="blog-content pl-0 pr-0">
                        <div class="blog-auteher-title">
                            <span></span>
                            <span class="float-lg-right">07 Mart, 2023</span>
                        </div>
                        <div class="span_wrapper">
                            <i class="fa-solid fa-calendar-days" aria-hidden="true"></i><span> 07 Mart, 2023 |  stephano</span>
                        </div>
                        <p class="blog_p mb-0">CS:GO'da Eternal Fire Aman Vermiyor</p>
                        <p class="pp">
                        <p> Herkesin merakla beklediği ESL CS:GO Türkiye Şampiyonası gerçekleşen final ile şampiyonunu belirledi. Eternal Fire CS:GO takımı The Chosen Few takımı karşısında 2-0’lık skor ile kazanarak ESL Türkiye şampiyonu oldu.</p>

                        <p>İki yıldır üst üste ESL Türkiye Şampiyonu olan Eternal Fire, ESL Pro League Season 17 Conference turnuvasına özel davet almış oldu. Bunun yanı sıra Eternal Fire 50.000 TL para ödülünün sahibi olurken turnuvayı ikinci olarak tamamlayan The Chosen Few takımı ise 30.000 TL para ödülü kazandı. Movistar Riders, Falcons, Outsiders, Imperial ve Heet gibi takımların mücadele edeceği ESL Pro League Season 17 Conference turnuvası, ESL Pro League Season 17 turnuvasına açılan bir kapı. Temsilcimize Malta’da düzenlenecek turnuvada şimdiden başarılar dileriz.</p> 

<h2>Bizimle İletişime Geçin</h2>
                        <form class="contact-form blog-model-form">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group mb-0">    
                                    <input type="text" class="form_style" placeholder="İsim" name="name"> 
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group mb-0">
                                    <input type="email" class="form_style" placeholder="Email" name = "email">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group mb-0">    
                                    <input type="tel" class="form_style" placeholder="Telefon" name = "telefon"> 
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group mb-0">    
                                    <input type="text" class="form_style" placeholder="Konu" name = "konu"> 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class=" form-group mb-0">    
                                    <textarea class="form_style" placeholder="Mesaj" rows="3" name="comments"></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="appointment-btn">Gönder</button>
                        </form>
                    </div>
                </div>
            </div>
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
</body>
</html>