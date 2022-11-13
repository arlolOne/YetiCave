<?php
require_once('helpers.php');
session_start();

$conToYeti = getConn();
$sqlForCats = "SELECT id, name, keyword FROM categories";
$resOfCats = mysqli_query($conToYeti, $sqlForCats);
$categories = mysqli_fetch_all($resOfCats, MYSQLI_ASSOC);

$invalids = [];
$values = [
    'name' => '',
    'category' => '',
    'description' => '',
    'initPrice' => '',
    'step' => '',
    'dateClosing' => ''
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mappingValid = [
        'name' => function($no) { return false; },
        'category' => function($no) { return false; },
        'description' => function($no) { return false; },
        'initPrice' => function($num) { return invalidPrice($num); },
        'step' => function($num) { return invalidPrice($num); },
        'dateClosing' => function($date) { return invalidDate($date); }
    ];
    
    foreach ($_POST as $key => $value) {
        $values[$key] = $value;
        if (strlen($value) == 0 || $mappingValid[$key]($value)) {
            array_push($invalids, $key);
        }
    }

    if (invalidFile()) { 
        array_push($invalids, 'img'); 
    }

    $tempPath = $_FILES['img']['tmp_name'];
    $fileName = $_FILES['img']['name'];
    $values['img'] = '/uploads/' . $fileName;

    $values['userId'] = $_SESSION['id'];

    if (count($invalids) == 0) {
        move_uploaded_file($tempPath, __DIR__ . $values['img']);

        $sqlInsert = "INSERT INTO lots (title, categoryId, description, "
        . "initialPrice, step, dateCreating, dateClosing, img, createrId) "
        . "VALUES(?, ?, ?, ?, ?, NOW(), ?, ?, ?)";

        $stmt = db_get_prepare_stmt($conToYeti, $sqlInsert, $values);
        $res = mysqli_stmt_execute($stmt);
        $id = mysqli_insert_id($conToYeti);

        header('Location: lot.php?id=' . $id);
        exit();
    } 
}

if (isset($_SESSION['id'])) {
    $page_content = include_template('addlot.php', ['categories' => $categories, 'invalids' => $invalids,
    'values' => $values]);
} else {
    $page_content = include_template('404.php', []);
}

$layout_content = include_template('layout.php', ['mainContent' => $page_content]);
print($layout_content);


function invalidPrice($number) 
{
    if (!is_numeric($number) || $number <= 0) { 
        return true; 
    }
}

function invalidDate($date) 
{
    $targetDate = strtotime($date);
    $now = strtotime("now");
    $oneDay = strtotime("+1 day", $now);

    if ($targetDate < $oneDay) { 
        return true; 
    }
}

function invalidFile() 
{
    if (!isset($_FILES['img'])) { 
        return true; 
    }
    
    if ($_FILES['img']['type'] != 'image/png' && $_FILES['img']['type'] != 'image/jpeg') {
        return true;
    }
}