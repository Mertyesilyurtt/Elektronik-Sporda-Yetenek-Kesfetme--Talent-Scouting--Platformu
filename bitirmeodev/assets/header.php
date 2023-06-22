<?php
if (session_status() == PHP_SESSION_NONE) {
session_start();
}
include("assets/baglanti.php");
echo '
<header>
    <div class="container  d-flex justify-content-center">
        <nav class="navbar navbar-expand-lg navbar-light mx-auto">
            <a class="navbar-brand" href="./index.html"><figure class="mb-0"><img src="./assets/images/scouthano.png" alt=""></figure></a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item ">
                        <a class="nav-link" href="./index.php">Ana&nbsp;Sayfa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./about.php">Hakkımızda</a>
                    </li>
               
                    <li class="nav-item">
                        <a class="nav-link" href="./kesfet.php">Keşfet</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="./contact.php">İletişim</a>
                    </li>
                    <li class="m-0">
                        <a class="navbar-brand" href="./index.php"><figure class="mb-0"><img src="./assets/images/crox_logo.png" alt=""></figure></a>
                    </li>';
                    if (!isset($_SESSION['email'])) {
                        echo ' <li class="nav-item mr-1 ml-0">
                        <a class="nav-link login_btn" href="./login.php">Giriş</a>
                    </li>
                    <li class="nav-item ml-0">
                        <a class="nav-link signup_btn" href="./signup.php">Kayıt&nbsp;Ol</a>
                    </li>';

                    }

                    else { 

                        echo '<li class="nav-item mr-0">
                        <a class="nav-link" href="./profile.php">Profil</a> </li> 
						<li class="nav-item mr-2">
							<a class="nav-link" href="./mesajlar.php">Mesajlar</a>
						</li>
                        <li class="nav-item mr-2">
                            <a class="nav-link" href="./gorusmeler.php">Görüşmeler</a>
                        </li>
                        
                        <li class="nav-item ml-0">
                        <p>Hoşgeldin,  ' . $_SESSION['KullaniciAdi'] . '</p>
                        </li>';
                        echo ' <li class="nav-item ml-0">
                                <a class="nav-link signup_btn"  href="assets/logout.php">Çıkış&nbsp;Yap</a>
                         </li> ';
                         if($_SESSION['YoneticiRolu'] >=3)
                         {
                             echo ' <li class="nav-item mr-1 ml-0">
                             <a class="nav-link login_btn" href="./admin-panel-login.php">Admin Panel</a>
                         </li>';
                         }
                    }
                    echo'
                </ul>
            </div>
        </nav>
    </div>
</header>';

?>

