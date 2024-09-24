<?php
include 'config.php';
include 'libs/libs.php';

$db = connection();


// royhatdan otish tekshirish
if ($_GET['action'] === 'login') {
    if (
        (isset($_GET['login']) && !empty($_GET['login'])) &&
        (isset($_GET['login']) && !empty($_GET['login']))
    ) {
        if (GetAllustun('admin', 'login', $_GET['login'], 'parol', $_GET['password'])) {
            $_SESSION['login'] = 'active';
            echo json_encode([
                'status' => 200,
                'message' => "http://localhost/bekend/kocka_admin/home.php"
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
fetchData('years', 'fetchDataClassReadyYearsName');




// qoshish o'quv yili

if ($_GET['action'] === 'insertYears') {
    if (isset($_GET['name']) && !empty($_GET['name'])) {
        $array = test_input([$_GET['name']]);
        if (getInsert('years', ['name'], $array)) {
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


// malumotni yangilash uchun
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
