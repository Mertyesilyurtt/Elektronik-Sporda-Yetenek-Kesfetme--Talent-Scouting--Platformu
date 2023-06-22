<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>İletişim | ScoutGG</title>
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
<div class="sub-banner-section">
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
<!-- SUB BANNER SECTION -->
    <section class="banner-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 text-lg-left text-center">
                    <div class="banner-section-content">
                        <h1 data-aos="fade-up">Bizimle İletişime Geç</h1>
                        <div class="btn_wrapper">
                            <span>Ana Sayfa<i class="fa-solid fa-arrow-right-long" aria-hidden="true"></i> İletişim</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12"></div>
            </div>
        </div>
    </section>
</div>
<!-- CONTACT FORM SECTION -->
<div class="contact_combo_background">
    <section class="contact_form_section">
        <div class="container">
            <div class="contact_form_box">
                <div class="row" data-aos="fade-up">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h2>Bizimle Temas Kur</h2>
                        <figure class="mb-5">
                            <img src="./assets/images/contact_form_logo.png" alt="">
                        </figure>
                    </div>
                </div>
                <div class="contact_form_content" data-aos="fade-up">
                    <form id= "contactpage" method="POST" action = "">
                        <div class="form-row pb-3">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <input type="text" name="isim" id="fullname" class="form-control upper_layer_name margin_bottom" placeholder="İsim">
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
        </div>
    </section>
    <!-- CONTACT INFO SECTION -->
    <div class="contact_info-section">
        <div class="container">
            <div class="row" data-aos="fade-up">
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="contact_info_box_content">
                        <figure>
                            <img src="./assets/images/contact_info_location.png" alt="">
                        </figure>
                        <p class="contact_p">Konum</p>
                        <p class="sub_p mb-0">Cumhuriyet Üniversitesi, Mühendislik Fakültesi</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="contact_info_box_content">
                        <figure>
                            <img src="./assets/images/contact_info_phone.png" alt="">
                        </figure>
                        <p class="contact_p">Telefon</p>
                        <p class="sub_p mb-0"><a href="tel:0-589-96369-95823" class="text-decoration-none">(0346) 487 00 00 </a></p>
                        <p class="sub_p mb-0"><a href="tel:0-825-63596-471254" class="text-decoration-none">(0346) 487 00 01</a></p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="contact_info_box_content">
                        <figure>
                            <img src="./assets/images/contact_info_mail.png" alt="">
                        </figure>
                        <p class="contact_p">Email</p>
                        <p class="sub_p mb-0"><a href="mailto:Croxesports@gmail.com" class="text-decoration-none">scoutgg@gmail.com</a></p>
                        <p class="sub_p mb-0"><a href="mailto:info@croxesports.com" class="text-decoration-none">info@scoutgg.com</a></p>
                    </div>
                </div>
            </div>
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
                    <h2>Sitemize Kayıt Ol ve  <span>Espor'u Takipte Kal</span></h2>
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