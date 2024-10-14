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

fetchData('guruh', 'fetchDataClassNameStatistik');



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

fetchDataColum('yearsReadyTeacherPage', 'years', 'active', 'true');


function fetchDataId($action)
{
    $db = connection();
    if ($_GET['action'] === $action) {
        $sql = "SELECT teachers.id, teachers.ism, teachers.fam,teachers.tel,teachers.login,teachers.parol, GROUP_CONCAT(guruh.name SEPARATOR ', ') AS groups, guruh.year_name FROM guruh_idtecher_id LEFT JOIN guruh on guruh_idtecher_id.guruh_id=guruh.id LEFT JOIN teachers on guruh_idtecher_id.teacher_id=teachers.id  GROUP BY teachers.id";
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
fetchDataId('fetchDataTeachersReady');


function fetchDataIdClass($action)
{
    $db = connection();
    if ($_GET['action'] === $action) {
        $id = $_GET['id'];
        $sql = "SELECT guruh.name,guruh.id FROM guruh_idtecher_id LEFT JOIN guruh on guruh_idtecher_id.guruh_id=guruh.id LEFT JOIN teachers on guruh_idtecher_id.teacher_id=teachers.id WHERE teacher_id='$id' GROUP BY guruh.id";
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
fetchDataIdClass('ClassReadyTeacherPage');



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

if ($_GET['action'] === 'studetsDataTeachers') {
    if (!empty($_GET['className_n1']) && isset($_GET['className_n1'])) {
        $nameClass = $_GET['className_n1'];
        $sql = "SELECT * FROM students WHERE  guruh_name = '$nameClass'  ORDER BY id desc";
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




if ($_GET['action'] === 'addTeachersStudentsData') {

    if (
        isset($_GET['teachersId']) && !empty($_GET['teachersId']) &&
        isset($_GET['classId']) && !empty($_GET['classId']) &&
        isset($_GET['todayDate']) && !empty($_GET['todayDate'])

    ) {
        $teachersId = $_GET['teachersId'];
        $classId = $_GET['classId'];
        $todayDate = $_GET['todayDate'];
        $yearsId = $_GET['yearsId'];
        $lesson = $_GET['lessonId'];

        $studentIdArray = explode(',', $_GET['studentIdString']);
        $studentGreatArray = explode(',', $_GET['studentGreatString']);

        $bool = 'active';

        foreach ($studentIdArray as $key => $value) {
            if (getInsert(
                'baho',
                ['years_id', 'oqtuvchi_id', 'guruh_id', 'student_id', 'date', 'title', 'lesson'],
                [$yearsId, $teachersId, $classId, $value, $todayDate, $studentGreatArray[$key], $lesson]
            )) {
                $bool = 'active';
            } else {
                $bool = 'error';
            }
        }

        if ($bool == 'active') {
            echo json_encode([
                'data' => 'active',
            ]);
        } else {
            echo json_encode([
                'data' => 'error',
            ]);
        }
    }
}


if ($_GET['action'] === 'teacherCheck') {
    $array = test_input(
        [
            $_GET['title'],
            $_GET['todayDate'],
            $_GET['className'],
            $_GET['teacherId'],
            $_GET['lessonId'],
        ]
    );
    if (GetAllustun3('teacherid_active', 'data', $_GET['todayDate'], 'guhur_name', $_GET['className'], 'lesson', $_GET['lessonId'])) {
        echo json_encode([
            "status" => 300,
            "message" => "Ma'lumot aloqachon saqlangan"
        ]);
    } else {
        if (getInsert('teacherid_active', ['title', 'data', 'guhur_name', 'teacher_id', 'lesson'], $array)) {
            echo json_encode([
                "status" => 200,
                "message" => "Guruh ma'lumotlari ochildi."
            ]);
        } else {
            echo json_encode([
                "status" => 400,
            ]);
        }
    }
}



// statistika

function fetchDataIdStatistik($action, $yearsName, $classId, $date) {}

if ($_GET['action'] === 'StatistikData') {

    $array = test_input(
        [
            $_GET['classId'],
            $_GET['date']
        ]
    );
    $db = connection();
    $sql = "SELECT students.id, guruh.name AS guruh_name, teachers.ism AS teacher_ism, students.ism AS talaba_ismi, students.fam AS talaba_fam, baho.lesson, baho.title, baho.date FROM baho LEFT JOIN students on baho.student_id=students.id LEFT JOIN guruh on baho.guruh_id=guruh.id LEFT JOIN teachers on baho.oqtuvchi_id=teachers.id WHERE baho.guruh_id = '$array[0]' AND baho.date='$array[1]'";
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


if ($_GET['action'] === 'fetchDataTeachersReadyActive') {

    $array = test_input(
        [
            $_GET['todayDate'],
        ]
    );
    $db = connection();
    $sql = "SELECT teachers.ism, teachers.fam, COUNT(title) AS title_count FROM teacherid_active JOIN teachers ON teacherid_active.teacher_id = teachers.id WHERE data = '$array[0]' GROUP BY teachers.id";
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
