<?php
include  'config.php';
include 'libs/libs.php';
global $config;
?>
<?php
if ($_SESSION['login']  == 'active') { ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Teacher</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=SUSE:wght@100..800&display=swap" rel="stylesheet">
        <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/media.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>

    <body>

        <div class="container-fluid teachers">
            <div class="madal_main"></div>
            <div class="navbar">
                <?php foreach (GetAllRow2('teachers', 'login', $_SESSION['loginName'], 'parol', $_SESSION['loginParol']) as $key => $val) : ?>
                    <input type="hidden" id="teacherIdPage" value="<?= $val['id'] ?>">
                    <div class="logoNavbar">
                        <img src="img/logo.png" alt="">
                        <p class="logoNavbarText">O'qtuvchi</p>
                    </div>
                    <div class="navbarTitle">
                        <p><?= $val['ism'] ?></p>
                        <i class="fa-solid fa-user"></i>
                    </div>
                <?php endforeach; ?>
            </div>
                <div class="container">
                    <div class="control-form">
                        <form action="" class="control-form-add" method="post">
                            <div class="control-form-add-from">
                                <select name="" id="teacherPageYearsId"></select>
                                <select name="" id="teacherPageClassId"></select>
                                <select name="" id="teacherPageLessonId">
                                    <option value="1-dars-juftligi">1 - dars juftligi</option>
                                    <option value="2-dars-juftligi">2 - dars juftligi</option>
                                    <option value="3-dars-juftligi">3 - dars juftligi</option>
                                    <option value="4-dars-juftligi">4 - dars juftligi</option>
                                </select>
                                <input type="date" id="todayDateJs">
                            </div>
                            <button id="teacherTableAddData" type="submit" class="teacherControlButton teacherControlButton2">Saqlash</button>
                        </form>
                        <div class="teacher-madal active">
                            <img src="img/nodatafound.png" alt="">
                        </div>
                        <form class="information-students hide" action="">
                            <ul id="teacherPageDataStudentsItems"></ul>
                            <div class="studentSeve">
                                <button type="submit" id="addTeachersStudentsData">
                                    Saqlash
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
        </div>


        <!-- bootstrap@5.3.3 -->
        <script src="js/Jquery/jquery-3.6.4.min.js"></script>
        <script src="js/Jquery/owlCarusel/owl.carousel.min.js"></script>
        <script src="js/Jquery/jquery-ui.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
        <script src="js/teachers.js"></script>
    </body>

    </html>

<?php
} else {
    reflesh(url, '');
}
?>