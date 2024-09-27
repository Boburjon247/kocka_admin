<?php
include 'config.php';
include 'libs/libs.php';

$db = connection();


// royhatdan otish tekshirish
if ($_GET['action'] === 'login') {
    if (
        (isset($_GET['login']) && !empty($_GET['login'])) &&
        (isset($_GET['password']) && !empty($_GET['password']))
    ) {
        if (GetAllustun('admin', 'login', $_GET['login'], 'parol', $_GET['password'])) {
            $_SESSION['login'] = 'active';
            echo json_encode([
                'status' => 200,
                'message' => "http://localhost/bekend/kocka_admin/home.php"
            ]);
        } else if (GetAllustun('teachers', 'login', $_GET['login'], 'parol', $_GET['password'])) {
            $_SESSION['login'] = 'active';
            $_SESSION['loginName'] = $_GET['login'];
            $_SESSION['loginParol'] = $_GET['password'];
            echo json_encode([
                'status' => 200,
                'message' => "http://localhost/bekend/kocka_admin/teachers.php"
            ]);
        } else {
            echo json_encode([
                'status' => 404,
                'message' => "Login yoki parol xato qaytadan urunib ko'ring..."
            ]);
        }
    } else {
        echo json_encode([
            'status' => 500,
            'message' => "Ma'lumotlarni to'ldiring..."
        ]);
    }
}

if ($_GET['action'] === 'UpdateYearsTarget') {
    if (isset($_GET['name']) && !empty($_GET['name'])) {
        $id = $_GET['id'];
        $name = mysqli_real_escape_string($db, $_GET['name']);
        $sql = "UPDATE years SET active = '$name' WHERE id = '$id'";
        if (mysqli_query($db, $sql)) {
            echo json_encode([
                "status" => 200,
                "message" => "O'quv yili ma'lumotlari o'zgartirildi 😁"
            ]);
        } else {
            echo json_encode([
                "status" => 500,
                "message" => "Ma'lumotlarda xatolik 🚫"
            ]);
        }
        mysqli_close($db);
    } else {
        echo json_encode([
            "status" => 400,
            "message" => "Ma'lumotlarda xatolik ⛔"
        ]);
    }
}

// fetchData o'qib oolish
function fetchData($tableName, $action)
{
    $db = connection();

    if ($_GET['action'] === $action) {
        $sql = "SELECT * FROM $tableName ORDER BY id desc";
        $result = mysqli_query($db, $sql);
        $data = [];
        ksort($data);
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        mysqli_close($db);

        header("Content-Type: application/json");
        echo json_encode([
            'data' => $data,
        ]);
    }
}

fetchData('years', 'fetchDataYearsReady');
fetchData('guruh', 'fetchDataClassReady');
fetchData('guruh', 'fetchDataClassName');
fetchData('teachers', 'fetchDataClassName2');
fetchData('guruh', 'fetchDataTeachersName');
fetchData('students', 'fetchDataStudentsReady');
fetchData('guruh', 'fetchDataStudentClassReadyName');

// malumotni aytni bir qatir boyicha oqib olish
function fetchDataColum($action, $tableName, $col, $val)
{
    $db = connection();

    if ($_GET['action'] === $action) {
        $sql = "SELECT * FROM $tableName WHERE  $col = '$val' ORDER BY id desc";
        $result = mysqli_query($db, $sql);
        $data = [];
        ksort($data);
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        mysqli_close($db);

        header("Content-Type: application/json");
        echo json_encode([
            'data' => $data,
        ]);
    }
}
fetchDataColum('fetchDataClassReadyYearsName', 'years', 'active', 'true');




function fetchDataId($yearsName)
{
    $db = connection();
    if ($_GET['action'] === 'fetchDataTeachersReady') {
        $sql = "SELECT teachers.id, teachers.ism, teachers.fam,teachers.tel,teachers.login,teachers.parol, GROUP_CONCAT(guruh.name SEPARATOR ', ') AS groups, guruh.year_name FROM guruh_idtecher_id LEFT JOIN guruh on guruh_idtecher_id.guruh_id=guruh.id LEFT JOIN teachers on guruh_idtecher_id.teacher_id=teachers.id WHERE guruh.year_name = '$yearsName' GROUP BY teachers.id";
        $result = mysqli_query($db, $sql);
        $data = [];
        ksort($data);
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        mysqli_close($db);

        header("Content-Type: application/json");
        echo json_encode([
            'data' => $data,
        ]);
    }
}
fetchDataId(trim(addslashes("2024-2025 o'quv yili (kuzgi)")));


// qoshish o'quv yili

if ($_GET['action'] === 'insertYears') {
    if (isset($_GET['name']) && !empty($_GET['name'])) {
        $array = test_input([$_GET['name'], $_GET['active']]);
        if (getInsert('years', ['name', 'active'], $array)) {
            echo json_encode([
                "status" => 200,
                "message" => "Yangi o'quv yili qo'shildi 😁"
            ]);
        } else {
            echo json_encode([
                "status" => 500,
                "message" => "Ma'lumotlarda xatolik yoki tarmoqga ulanmaga 😒"
            ]);
        }
    } else {
        echo json_encode([
            "status" => 400,
            "message" => "Iltimos ma'lumotlarni to'ldiring 😒"
        ]);
    }
}

// ochirish
function deleteData($action, $tableName)
{
    $db = connection();
    if ($_GET['action'] === $action) {
        $id = $_GET['id'];
        $sql = "DELETE FROM $tableName WHERE `id` = '$id'";
        if (mysqli_query($db, $sql)) {
            echo json_encode([
                'status' => 200,
                'message' => "Ma'lumot o'chirildi 😢"
            ]);
        } else {
            echo json_encode([
                'status' => 500,
                'message' => "Ma'lumot o'chirilmadi 🙂"
            ]);
        }
    }
}

deleteData('delateYears', 'years');
deleteData('delateClass', 'guruh');
deleteData('delateStudents', 'students');
deleteData('delateTeachers', 'teachers');


// malumotni yangilashdan oldin oqib olish uchun
function editReadyData($tableName, $action)
{
    $db = connection();
    if ($_GET['action'] === $action) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM $tableName WHERE `id` = $id";
        $result = mysqli_query($db, $sql);
        if (mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);
            echo json_encode([
                'status' => 200,
                'data' =>   $data
            ]);
        } else {
            echo json_encode([
                'status' => 404,
                'messege' => "Bu id da ma'lumot topilmadi ⛔"
            ]);
        }
        mysqli_close($db);
    };
}

editReadyData('years', 'editReadyYears');
editReadyData('guruh', 'editReadyClass');
editReadyData('students', 'editReadyStudents');
editReadyData('admin', 'profileEdit');


// malumotni yil yangilash uchun
if ($_GET['action'] === 'UpdateYears') {
    if (isset($_GET['name']) && !empty($_GET['name'])) {
        $id = $_GET['id'];
        $name = mysqli_real_escape_string($db, $_GET['name']);
        $sql = "UPDATE years SET name = '$name' WHERE id = '$id'";
        if (mysqli_query($db, $sql)) {
            echo json_encode([
                "status" => 200,
                "message" => "Ma'lumot yangilandi 😁"
            ]);
        } else {
            echo json_encode([
                "status" => 500,
                "message" => "Ma'lumotlarda xatolik 🚫"
            ]);
        }
        mysqli_close($db);
    } else {
        echo json_encode([
            "status" => 400,
            "message" => "Ma'lumotlarda xatolik ⛔"
        ]);
    }
}


// yangi guruh qoshish uchun

if ($_GET['action'] === 'insertClassName') {
    if (
        (isset($_GET['className']) && !empty($_GET['className'])) &&
        (isset($_GET['yearsName']) && !empty($_GET['yearsName']))
    ) {
        $array = test_input([$_GET['className'], $_GET['yearsName']]);
        if (getInsert('guruh', ['name', 'year_name'], $array)) {
            echo json_encode([
                "status" => 200,
                "message" => "Yangi guruh qo'shildi 😁"
            ]);
        } else {
            echo json_encode([
                "status" => 500,
                "message" => "Ma'lumotlarda xatolik yoki tarmoqga ulanmaga 😒",
            ]);
        }
    } else {
        echo json_encode([
            "status" => 400,
            "message" => "Iltimos ma'lumotlarni to'ldiring 😒"
        ]);
    }
}

// malumotlarni oqib olish uchun
if ($_GET['action'] === 'UpdateClass') {
    if (
        (isset($_GET['name']) && !empty($_GET['name'])) &&
        (isset($_GET['nameYear']) && !empty($_GET['nameYear']))
    ) {
        $id = $_GET['id'];
        $name = mysqli_real_escape_string($db, $_GET['name']);
        $nameYear = mysqli_real_escape_string($db, $_GET['nameYear']);
        $sql = "UPDATE guruh SET name = '$name' , year_name = '$nameYear' WHERE id = '$id'";
        if (mysqli_query($db, $sql)) {
            echo json_encode([
                "status" => 200,
                "message" => "Ma'lumot yangilandi 😁"
            ]);
        } else {
            echo json_encode([
                "status" => 500,
                "message" => "Ma'lumotlarda xatolik 🚫"
            ]);
        }
        mysqli_close($db);
    } else {
        echo json_encode([
            "status" => 400,
            "message" => "Ma'lumotlarda xatolik ⛔"
        ]);
    }
}

// new students add for
if ($_GET['action'] === 'studentsClassName') {
    if (
        (isset($_GET['ism']) && !empty($_GET['ism'])) &&
        (isset($_GET['fam']) && !empty($_GET['fam'])) &&
        (isset($_GET['tel']) && !empty($_GET['tel'])) &&
        (isset($_GET['uy_tel']) && !empty($_GET['uy_tel'])) &&
        (isset($_GET['guruh_name']) && !empty($_GET['guruh_name']))
    ) {
        $array = test_input(
            [
                $_GET['ism'],
                $_GET['fam'],
                $_GET['tel'],
                $_GET['uy_tel'],
                $_GET['guruh_name']
            ]
        );
        if (getInsert('students', ['ism', 'fam', 'tel', 'uy_tel', 'guruh_name'], $array)) {
            echo json_encode([
                "status" => 200,
                "message" => "Yangi talaba qo'shildi 😁"
            ]);
        } else {
            echo json_encode([
                "status" => 500,
                "message" => "Ma'lumotlarda xatolik yoki tarmoqga ulanmaga 😒",
            ]);
        }
    } else {
        echo json_encode([
            "status" => 400,
            "message" => "Iltimos ma'lumotlarni to'ldiring 😒"
        ]);
    }
}
// malumotni oquvchi yangilash uchun
if ($_GET['action'] === 'UpdateStudents') {
    if (
        (isset($_GET['ism']) && !empty($_GET['ism'])) &&
        (isset($_GET['fam']) && !empty($_GET['fam'])) &&
        (isset($_GET['tel']) && !empty($_GET['tel'])) &&
        (isset($_GET['uy_tel']) && !empty($_GET['uy_tel'])) &&
        (isset($_GET['guruh_name']) && !empty($_GET['guruh_name']))
    ) {
        $id = $_GET['id'];
        $name = mysqli_real_escape_string($db, $_GET['ism']);
        $fam = mysqli_real_escape_string($db, $_GET['fam']);
        $tel = mysqli_real_escape_string($db, $_GET['tel']);
        $uTel = mysqli_real_escape_string($db, $_GET['uy_tel']);
        $guruh_name = mysqli_real_escape_string($db, $_GET['guruh_name']);
        $sql = "UPDATE students SET ism = '$name', fam = '$fam', tel = '$tel', uy_tel = '$uTel', guruh_name = '$guruh_name'  WHERE id = '$id'";
        if (mysqli_query($db, $sql)) {
            echo json_encode([
                "status" => 200,
                "message" => "Ma'lumot yangilandi 😁"
            ]);
        } else {
            echo json_encode([
                "status" => 500,
                "message" => "Ma'lumotlarda xatolik 🚫"
            ]);
        }
        mysqli_close($db);
    } else {
        echo json_encode([
            "status" => 400,
            "message" => "Ma'lumotlarda xatolik ⛔"
        ]);
    }
}


// admin profile edit
// yangilash
if ($_GET['action'] === 'UpdateProfile') {
    if (
        (isset($_GET['ism']) && !empty($_GET['ism'])) &&
        (isset($_GET['fam']) && !empty($_GET['fam'])) &&
        (isset($_GET['tel']) && !empty($_GET['tel'])) &&
        (isset($_GET['login']) && !empty($_GET['login'])) &&
        (isset($_GET['parol']) && !empty($_GET['parol']))
    ) {
        $id = $_GET['id'];
        $name = mysqli_real_escape_string($db, $_GET['ism']);
        $fam = mysqli_real_escape_string($db, $_GET['fam']);
        $tel = mysqli_real_escape_string($db, $_GET['tel']);
        $login = mysqli_real_escape_string($db, $_GET['login']);
        $parol = mysqli_real_escape_string($db, $_GET['parol']);
        $sql = "UPDATE admin SET ism = '$name', fam = '$fam', tel = '$tel', login = '$login', parol = '$parol'  WHERE id = '$id'";
        if (mysqli_query($db, $sql)) {
            echo json_encode([
                "status" => 200,
                "message" => "Ma'lumot yangilandi 😁"
            ]);
        } else {
            echo json_encode([
                "status" => 500,
                "message" => "Ma'lumotlarda xatolik 🚫"
            ]);
        }
        mysqli_close($db);
    } else {
        echo json_encode([
            "status" => 400,
            "message" => "Ma'lumotlarda xatolik ⛔"
        ]);
    }
}

// oqtuvchi qoshish uchun
if ($_GET['action'] === 'teachersAdd') {
    if (
        (isset($_GET['ism']) && !empty($_GET['ism'])) &&
        (isset($_GET['fam']) && !empty($_GET['fam'])) &&
        (isset($_GET['tel']) && !empty($_GET['tel'])) &&
        (isset($_GET['login']) && !empty($_GET['login'])) &&
        (isset($_GET['parol']) && !empty($_GET['parol']))
    ) {
        $array = test_input(
            [
                $_GET['ism'],
                $_GET['fam'],
                $_GET['tel'],
                $_GET['login'],
                $_GET['parol']
            ]
        );
        if (getInsert('teachers', ['ism', 'fam', 'tel', 'login', 'parol'], $array)) {
            echo json_encode([
                "status" => 200,
                "message" => "Yangi O'qtuvchi qo'shildi 😁"
            ]);
        } else {
            echo json_encode([
                "status" => 500,
                "message" => "Ma'lumotlarda xatolik yoki tarmoqga ulanmaga 😒",
            ]);
        }
    } else {
        echo json_encode([
            "status" => 400,
            "message" => "Iltimos ma'lumotlarni to'ldiring 😒"
        ]);
    }
}

// guruhni teacherga biriktrish
if ($_GET['action'] === 'teachersAddClass') {
    if (
        (isset($_GET['guruhId']) && !empty($_GET['guruhId'])) &&
        (isset($_GET['teachersId']) && !empty($_GET['teachersId']))
    ) {
        $array = test_input(
            [
                $_GET['teachersId'],
                $_GET['guruhId']
            ]
        );
        if (getInsert('guruh_idtecher_id', ['teacher_id', 'guruh_id'], $array)) {
            echo json_encode([
                "status" => 200,
                "message" => "O'qtuvchi Guruhga Biriktrildi 😁"
            ]);
        } else {
            echo json_encode([
                "status" => 500,
                "message" => "Ma'lumotlarda xatolik yoki tarmoqga ulanmaga 😒",
            ]);
        }
    } else {
        echo json_encode([
            "status" => 400,
            "message" => "Iltimos ma'lumotlarni to'ldiring 😒"
        ]);
    }
}
