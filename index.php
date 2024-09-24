<!-- B.R.R -->
<?php
include  'config.php';
include 'libs/libs.php';
global $config;

$_SESSION['login'] = ' ';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=SUSE:wght@100..800&display=swap" rel="stylesheet">
    <!-- media.css -->
    <link rel="stylesheet" href="css/media.css">
    <link rel="stylesheet" href="js/Jquery/owlCarusel/owl.carousel.min.css">
    <link rel="stylesheet" href="js/Jquery/owlCarusel/owl.theme.default.min.css">
    <link rel="stylesheet" href="js/Jquery/jquery-ui.min.css">
    <link rel="stylesheet" href="js/Jquery/jquery-ui.theme.min.css">
    <!-- style.css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Koica System Login</title>
</head>

<body>
    <div class="container-fluid containerLogin">
         <div class="madalLogin">
            <p></p>
        </div>
        <div class="login">
            <p class="loginTitle_top">KOIKA SYSTEM</p>
            <div class="loginImg">
                <img src="img/04. KOICA logo original.png" alt="">
            </div>
            <form action="" method="post">
                <div class="form-group">
                    <label for="">Login</label>
                    <input type="text" class="login-input-php" name="login" placeholder="Login...">
                    <span class="hide">Login xato 🤨</span>
                </div>
                <div class="form-group">
                    <label for="">Paro'l</label>
                    <input type="password" class="login-input-php login-input-php-password" name="parol" placeholder="Paro'l...">
                    <span class="hide">Paro'l xato 🤨</span>
                </div>
                <span class="hide error-login">Login yoki paro'l xato 🚫</span>
                <div class="form-group form-group-btn">
                    <button type="submit" class="loginAdd" name="loginbtn">
                        Login in
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- bootstrap@5.3.3 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <!-- jquery-3.6.4.min.js -->
    <script src="js/Jquery/jquery-3.6.4.min.js"></script>
    <script src="js/Jquery/owlCarusel/owl.carousel.min.js"></script>
    <script src="js/Jquery/jquery-ui.min.js"></script>
    <script src="js/login.js"></script>

</body>

</html>
<?php
if (isset($_POST['loginbtn'])) {
    if (
        (isset($_POST['login']) && !empty($_POST['login'])) &&
        (isset($_POST['parol']) && !empty($_POST['parol']))
    ) {
        $login = $_POST['login'];
        $password = $_POST['parol'];
        if (getHasId('admin', ['login', 'parol'], [$login, $password], "AND id=1")) {
            reflesh(url_home, '');
        } else {
            reflesh(url, '');
        }
    }
}
?>