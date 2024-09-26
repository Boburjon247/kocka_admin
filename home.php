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
        <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=SUSE:wght@100..800&display=swap" rel="stylesheet">
        <!-- jquery -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="js/Jquery/owlCarusel/owl.carousel.min.css">
        <link rel="stylesheet" href="js/Jquery/owlCarusel/owl.theme.default.min.css">
        <link rel="stylesheet" href="js/Jquery/jquery-ui.min.css">
        <link rel="stylesheet" href="js/Jquery/jquery-ui.theme.min.css">


        <!-- media.css -->
        <link rel="stylesheet" href="css/media.css">
        <!-- style.css -->
        <link rel="stylesheet" href="css/style.css">
        <!-- font-awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
        <!-- bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <title>Koica System</title>
    </head>

    <body>

        <section class="container-fluid container-home">

            <div class="madal_main"></div>

            <div class="row container-home-row">
                <div class="col-2 container-home-row-colLeft">
                    <div class="home-logo">
                        <p>Koica System</p>
                        <img src="img/logo.png" alt="">
                    </div>
                    <div class="home-main">
                        <ul>
                            <li class="main-items active">
                                <i class="fa-solid fa-house"></i>
                                <span>Bosh sahifa</span>
                            </li>
                            <li class="main-items">
                                <i class="fa-solid fa-chart-simple"></i>
                                <span>Statistika</span>
                            </li>
                            <li class="main-items">
                                <i class="fa-solid fa-calendar-days"></i>
                                <span>O'quv Yil</span>
                            </li>
                            <li class="main-items">
                                <i class="fa-solid fa-layer-group"></i>
                                <span>Guruhlar</span>
                            </li>
                            <li class="main-items">
                                <i class="fa-solid fa-graduation-cap"></i>
                                <span>O'quvchilar</span>
                            </li>
                            <li class="main-items">
                                <i class="fa-solid fa-chalkboard-user"></i>
                                <span>O'qtuvchilar</span>
                            </li>
                            <li class="main-items">
                                <i class="fa-solid fa-user"></i>
                                <span>Prolfil</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-10 container-home-row-colRight">

                    <div class="main-right-blok-top">
                        <button><i class="fa-solid fa-gear"></i></button>
                        <div class="user_name">
                            <p>Admin</p>
                            <i class="fa-regular fa-user"></i>
                        </div>
                    </div>
                    <div class="main-right-blok">
                        <!-- Bosh sahifa -->
                        <div class="home-mine-blok-item">
                            <!-- <div class="loading">
                            <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"></div>
                        </div> -->
                            <div class="main">
                                <div class="box">
                                    <p class="topTitle">Koica Yo'qlama / <span>Bosh Sahifa</span></p>
                                </div>
                                <div class="main_box_items">
                                    <div class="main-techers-students">
                                        <div class="items_box">
                                            <i class="fa-solid fa-chalkboard-user"></i>
                                            <p>O'qtuvchilar 70</p>
                                        </div>
                                        <div class="items_box">
                                            <i class="fa-solid fa-graduation-cap"></i>
                                            <p>O'quvchilar 5</p>
                                        </div>
                                    </div>
                                    <div class="main-about">
                                        <div class="main-about-items">
                                            <i class="fa-solid fa-chart-simple"></i>
                                            <span>Statistika</span>
                                        </div>
                                        <div class="main-about-items">
                                            <i class="fa-solid fa-calendar-days"></i>
                                            <span>O'quv Yil</span>
                                        </div>
                                        <div class="main-about-items">
                                            <i class="fa-solid fa-layer-group"></i>
                                            <span>Guruhlar</span>
                                        </div>
                                        <div class="main-about-items">
                                            <i class="fa-solid fa-graduation-cap"></i>
                                            <span>O'quvchilar</span>
                                        </div>
                                        <div class="main-about-items">
                                            <i class="fa-solid fa-chalkboard-user"></i>
                                            <span>O'qtuvchilar</span>
                                        </div>
                                        <div class="main-about-items">
                                            <i class="fa-solid fa-user"></i>
                                            <span>Prolfil</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- statistika -->
                        <div class="home-mine-blok-item">
                            <div class="loading ">
                                <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"></div>
                            </div>

                            <div class="main">
                                <div class="box newYers-yaratish">
                                    <p class="topTitle">Koica Yo'qlama / <span>Statistika</span></p>
                                </div>

                                <div class="chat">
                                    <div class="topBarChatInput">
                                        <form action="" class="topBarChatInputForm" method="post">
                                            <div class="topBarChatInputFormItems">
                                                <select name="" id="">
                                                    <option value="">2024-2025 yili</option>
                                                </select>
                                                <select name="" id="">
                                                    <option value="">08 - guruh</option>
                                                </select>
                                                <input type="date" name="" id="">
                                            </div>
                                            <button type="submit">Saqlash</button>
                                        </form>
                                    </div>
                                    <div class="topBarChatInformation">
                                        <div class="madalChatInformatio ">
                                            <img src="img/vCIO-Consulting.png" alt="">
                                        </div>
                                        <div class="madalChatStudentInformation  active">
                                            <div class="madalChatStudentInformationBtn">
                                                <form action="" method="post">
                                                    <button type="submit">Saqlash</button>
                                                    <button type="submit">
                                                        <img src="img/326afb_b88705c4a11740c984b904c6b1b5a763_mv2_d_1600_1600_s_2.png"
                                                            alt="">
                                                        <span>Yuklab olish</span>
                                                    </button>
                                                </form>
                                                <ul>
                                                    <li class="firstUser">
                                                        <p>№</p>
                                                        <p>Fish</p>
                                                        <p>1-para <span>Bobur</span></p>
                                                        <p>2-para <span>Nodirbek</span></p>
                                                        <p>3-para <span>Shoxjaxon</span></p>
                                                        <p>4-para <span>Lazizbek</span></p>
                                                        <p>Ummumiy</p>
                                                    </li>
                                                    <li>
                                                        <p>1</p>
                                                        <p class="studentNmae">Abdunazarov Boburjon</p>
                                                        <p>
                                                            <input maxlength="1" type="text" value="0" name="" id="">
                                                        </p>
                                                        <p>
                                                            <input type="text" value="0" name="" id="">
                                                        </p>
                                                        <p>
                                                            <input type="text" value="0" name="" id="">
                                                        </p>
                                                        <p>
                                                            <input type="text" value="0" name="" id="">
                                                        </p>
                                                        <p>0</p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chatStatistic">
                                        <p class="chatStatisticTitle ">Kun davomida O'qtuvchilar activligi</p>
                                        <form action="" class="chatStatisticInformation">
                                            <div class="searchTeacher">
                                                <div class="">
                                                    <button class="btnTeacherChat" type="submit"><i
                                                            class="fa-solid fa-angle-left"></i></button>
                                                    <button class="btnTeacherChat" type="submit"><i
                                                            class="fa-solid fa-angle-right"></i></button>

                                                </div>
                                                <p>2024/09/12</p>
                                            </div>
                                            <ul>
                                                <li class="chatStatisticInformationItems">
                                                    <p>№</p>
                                                    <p>FISH</p>
                                                    <p>Activligi</p>
                                                </li>
                                                <li>
                                                    <p>1</p>
                                                    <p class="itemsChat">Lazizbek</p>
                                                    <p>0</p>
                                                </li>
                                                <li>
                                                    <p>2</p>
                                                    <p class="itemsChat">Shoxjahon</p>
                                                    <p>0</p>
                                                </li>
                                                <li>
                                                    <p>3</p>
                                                    <p class="itemsChat">Nodirbek</p>
                                                    <p>0</p>
                                                </li>
                                                <li>
                                                    <p>4</p>
                                                    <p class="itemsChat">Bobur</p>
                                                    <p>0</p>
                                                </li>

                                            </ul>
                                        </form>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!-- oquv yili -->
                        <div class="home-mine-blok-item">
                            <div class="loading ">
                                <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"></div>
                            </div>
                            <div class="main">
                                <!-- madal -->
                                <div class="madal-winndow-new-yer madal-winndow-new-yer1">
                                    <button class="exit-madal-window"><i class="fa-regular fa-circle-xmark"></i></button>
                                    <p class="madal-window-title">Yangi o'quv yili yaratish</p>
                                    <form action="" method="post" class="form-mada-new-yer">
                                        <label for="">Yangi o'quv yilini kiriting</label>
                                        <input type="text" id="yearsAddInput" placeholder="Yangi o'quv yilini kiriting...">
                                        <div class="btn_input_seve">
                                            <input type="submit" id="yearAddBtn" value="Saqlash">
                                        </div>
                                    </form>
                                </div>
                                <!-- edit -->
                                <div class="madal-winndow-edit-yer madal-winndow-new-yer">
                                    <button class="exit-madal-window-edit"><i
                                            class="fa-regular fa-circle-xmark"></i></button>
                                    <p class="madal-window-title">O'quv yilini tahrirlash</p>
                                    <form action="" method="post" class="form-mada-new-yer">
                                        <div class="input-tip" style="margin-bottom: 20px;">
                                            <label for="">O'quv yilini tahrirlash</label>
                                            <input type="text" id="inputEditDataYears">
                                        </div>
                                        <div class="btn_input_seve">
                                            <input id="btnUpdataYearsId" type="submit" value="Tahrirlash">
                                        </div>
                                    </form>
                                </div>

                                <div class="box newYers-yaratish">
                                    <p class="topTitle">Koica Yo'qlama / <span>O'quv yili</span></p>
                                    <button class="newyersbtnadd">
                                        Yangi O'quv yili yaratish
                                    </button>
                                </div>
                                <div class="newYers newYersid"></div>
                            </div>
                        </div>
                        <!-- guruhlar -->
                        <div class="home-mine-blok-item">
                            <!-- loading -->
                            <div class="loading ">
                                <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"></div>
                            </div>
                            <div class="main">
                                <!-- add -->
                                <div class="madal madalGuruh">
                                    <button class="exit-madal exitMadalGuruh"><i
                                            class="fa-regular fa-circle-xmark"></i></button>
                                    <p class="madal-title">Yangi guruh yaratish</p>
                                    <form class="medya-form" action="" method="post">
                                        <div class="medya-form-item">
                                            <label for="">Guruh nomi kiriting</label>
                                            <input type="text" placeholder="Yangi guruh nomini kiriting..." name="" id="classNameInput">
                                        </div>
                                        <div class="medya-form-item">
                                            <label for="">Guruhni o'quv yiliga briktring.</label>
                                            <select name="" id="addClassReady"></select>
                                        </div>
                                        <div class="medya-form-item">
                                            <button id="addClassDb" type="submit">
                                                Saqlash
                                            </button>
                                        </div>

                                    </form>
                                </div>
                                <!-- edit -->
                                <div class="madal madalGuruhEdit">
                                    <button class="exit-madal exitMadalGuruhedit"><i
                                            class="fa-regular fa-circle-xmark"></i></button>
                                    <p class="madal-title">Yangi guruh Yangilash</p>
                                    <form class="medya-form" action="" method="post">
                                        <div class="medya-form-item">
                                            <label for="">Guruh nomi Ynagilng</label>
                                            <input type="text" placeholder="Yangi guruh nomini yangilang..." name="" id="classNameEditInput">
                                        </div>
                                        <div class="medya-form-item">
                                            <label for="">Guruh nomi Ynagilng</label>
                                            <select name="" id="classNameEditSelect"></select>
                                        </div>
                                        <div class="medya-form-item">
                                            <button type="submit" id="editClassData">
                                                Saqlash
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <div class="box newYers-yaratish">
                                    <p class="topTitle">Koica Yo'qlama / <span>O'quv yili</span></p>
                                    <button class="guruhAdd addClassModalActiveJq">
                                        Yangi guruh yaratish
                                    </button>
                                </div>
                                <div class="newYers newClassBlock"></div>
                            </div>
                        </div>
                        <!-- o'quvchilar -->
                        <div class="home-mine-blok-item">
                            <div class="loading ">
                                <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"></div>
                            </div>
                            <div class="box newStudent-craete">
                                <p class="topTitle">Koica Yo'qlama / <span>O'quvchilar</span></p>
                            </div>
                            <div class="createStudentMain">
                                <!-- madal active -->
                                <div class="madal madalStudent">
                                    <button class="exit-madal madalStudentEditexit"><i
                                            class="fa-regular fa-circle-xmark"></i></button>
                                    <p class="madal-title">O'quvchi ma'lumotlarini yangilash</p>
                                    <form class="medya-form" action="" method="post">
                                        <div class="medya-form-item">
                                            <label for="">O'quvchi ism yangilash</label>
                                            <input type="text" name="" id="sIsm">
                                        </div>
                                        <div class="medya-form-item">
                                            <label for="">O'quvchi familyasini yangilash</label>
                                            <input type="text" name="" id="sFam">
                                        </div>
                                        <div class="medya-form-item">
                                            <label for="">O'quvchi Telefoni yangilash</label>
                                            <input type="text" name="" id="sTel">
                                        </div>
                                        <div class="medya-form-item">
                                            <label for="">O'quvchini Uy Telefoni yangilash</label>
                                            <input type="text" name="" id="sUyTel">
                                        </div>

                                        <div class="medya-form-item">
                                            <label for="">O'quvchi guruhni yangilash</label>
                                            <select name="" id="studentDataEditClass"></select>
                                        </div>
                                        <div class="medya-form-item">
                                            <button type="submit" id="studentDataEditDataDb">
                                                Saqlash
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="createItem">
                                    <p class="createItemTitle">O'quvchi qo'shish</p>
                                    <form action="" method="post" class="studentAddForm">
                                        <div class="formItemsStudentCreat">
                                            <label for="">Ism:</label>
                                            <input id="studentName" type="text" placeholder="Ism">
                                        </div>
                                        <div class="formItemsStudentCreat">
                                            <label for="">Familya:</label>
                                            <input id="studentFam" type="text" placeholder="Familya">
                                        </div>
                                        <div class="formItemsStudentCreat">
                                            <label for="">Telefon:</label>
                                            <input id="studentTel" type="text" placeholder="Telefon">
                                        </div>
                                        <div class="formItemsStudentCreat">
                                            <label for="">Uy Telefon:</label>
                                            <input id="studentTelUy" type="text" placeholder="Telefon">
                                        </div>
                                        <div class="formItemsStudentCreat">
                                            <label for="">Guruh:</label>
                                            <select name="" id="studentSelect"></select>
                                        </div>
                                        <div class="formItemsStudentCreat">
                                            <button id="addStudents" type="submit">
                                                Saqlash
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="createItem">
                                    <p class="createItemTitle">O'quvchi ro'yhati</p>
                                    <input type="search" class="searchStudent" placeholder="Qidirish...">
                                    <ul id="studentsIdItem" class="studentList"></ul>
                                </div>
                            </div>
                        </div>
                        <!-- oqtuvchilar -->
                        <div class="home-mine-blok-item">
                            <div class="loading ">
                                <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"></div>
                            </div>
                            <div class="box newStudent-craete">
                                <p class="topTitle">Koica Yo'qlama / <span>O'qtuvchilar</span></p>
                            </div>
                            <div class="createStudentMain">
                                <!-- madal active -->
                                <!-- <div class="madal madalTeacherEdit">
                                    <button class="exit-madal madalTeacherEditexit">
                                        <i class="fa-regular fa-circle-xmark"></i></button>
                                    <p class="madal-title">O'qtuvchi ma'lumotlarini yangilash</p>
                                    <form class="medya-form" action="" method="post">
                                        <div class="madal_from_teacher">
                                            <div class="medya-form-item">
                                                <label for="">O'qtuvchi ism yangilash</label>
                                                <input type="text" name="">
                                            </div>
                                            <div class="medya-form-item">
                                                <label for="">O'qtuvchi familyasini yangilash</label>
                                                <input type="text" name="">
                                            </div>
                                            <div class="medya-form-item">
                                                <label for="">O'qtuvchi telefoni yangilash</label>
                                                <input type="text" name="">
                                            </div>
                                            <div class="medya-form-item">
                                                <label for="">O'qtuvchi login yangilash</label>
                                                <input type="text" name="">
                                            </div>
                                            <div class="medya-form-item">
                                                <label for="">O'qtuvchi parol yangilash</label>
                                                <input type="password" name="">
                                            </div>
                                            <div class="medya-form-item">
                                                <label for="">O'qtuvchi guruhlarini yangilash</label>
                                                <select class="js-example-tokenizer1 form-control" multiple="multiple">
                                                    <option>2024-2025 o'quv yili 07-guruh</option>
                                                    <option>2024-2025 o'quv yili 07-guruh</option>
                                                </select>
                                            </div>
                                            <div class="medya-form-item">
                                                <button type="submit">
                                                    Saqlash
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div> -->
                                <div class="createItem">
                                    <p class="createItemTitle">O'qtuvchi qo'shish</p>
                                    <form action="" method="post" class="studentAddForm">
                                        <div class="formItemsStudentCreat">
                                            <label for="">Ism:</label>
                                            <input type="text" placeholder="Ism" id="teacherName">
                                        </div>
                                        <div class="formItemsStudentCreat">
                                            <label for="">Familya:</label>
                                            <input type="text" placeholder="Familya" id="teacherFam">
                                        </div>
                                        <div class="formItemsStudentCreat">
                                            <label for="">Telefon:</label>
                                            <input type="text" placeholder="Telefon" id="teacherTel">
                                        </div>
                                        <div class="formItemsStudentCreat">
                                            <label for="">Login:</label>
                                            <input type="text" placeholder="Login" id="login">
                                        </div>
                                        <div class="formItemsStudentCreat">
                                            <label for="">Parol:</label>
                                            <input type="password" placeholder="Parol" id="parol">
                                        </div>
                                        <div class="formItemsStudentCreat">
                                            <button type="submit" id="addTeacher">
                                                Saqlash
                                            </button>
                                        </div>
                                        <div class="formItemsStudentCreat">
                                            <label for="">Guruhni tanlang.:</label>
                                             <select name="" id="teachersClassAddId"></select>
                                        </div>
                                        <div class="formItemsStudentCreat">
                                            <label for="">O'qtuvchini tanlang.:</label>
                                             <select name="" id="teachersClassAddId2"></select>
                                        </div>
                                        <div class="formItemsStudentCreat">
                                            <button type="submit" id="classAddTeachers">
                                                Saqlash
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="createItem">
                                    <p class="createItemTitle">O'qtuvchilar ro'yhati</p>
                                    <input type="search" class="searchStudent" placeholder="Qidirish...">
                                    <ul id="teachersList" class="studentList"></ul>
                                </div>
                            </div>
                        </div>
                        <!-- profil -->
                        <div class="home-mine-blok-item">
                            <div class="loading ">
                                <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"></div>
                            </div>
                            <div class="main">
                                <div class="box newStudent-craete">
                                    <p class="topTitle">Koica Yo'qlama / <span>Shaxsiy profil</span></p>
                                </div>
                                <div class="profilAbout">
                                    <ul>
                                        <li>
                                            <label for="">Ism:</label>
                                            <input id="profileIsm" type="text">
                                        </li>
                                        <li>
                                            <label for="">Familya:</label>
                                            <input id="profileFam" type="text">
                                        </li>
                                        <li>
                                            <label for="">Telefon:</label>
                                            <input id="profileTel" type="text">
                                        </li>
                                        <li>
                                            <label for="">Login:</label>
                                            <input id="profileLogin" type="text">
                                        </li>
                                        <li>
                                            <label for="">Parol:</label>
                                            <input id="profileParol" type="text">
                                        </li>
                                        <li>
                                            <button id="profileEditBtn" type="submit"> Saqlash </button>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- jquery-3.6.4.min.js -->
        <script src="js/Jquery/jquery-3.6.4.min.js"></script>
        <script src="js/Jquery/owlCarusel/owl.carousel.min.js"></script>
        <script src="js/Jquery/jquery-ui.min.js"></script>
        <script src="js/javascript.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
            integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="js/jQuery.js"></script>
        <script src="js/ajax.js"></script>
        <!-- bootstrap@5.3.3 -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    </body>

    </html>

<?php
} else {
    reflesh(url, '');
}
?>