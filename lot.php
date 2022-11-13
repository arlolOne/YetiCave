<?php
require_once('helpers.php');
session_start();

$lotId = 1;
$invalidCost = false;
$missingRates = false;

$conToYeti = getConn();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (invalidPage($_GET['id'])) {
        $page_content = include_template('404.php');
    } else {
        $lotId = $_GET['id'];
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lotId = $_POST['id'];
    $cost = $_POST['cost'];
    $minRate = $_POST['minRate'];

    if (inValidCost($cost, $minRate)) {
        $invalidCost = true;
    } else {
        $rate['userId'] = $_SESSION['id'];
        $rate['cost'] = $cost;
        $rate['lotId'] = $lotId;
        
        $sqlInsert = "INSERT INTO rates (userId, dateCreating, valueRate, lotId) "
        . "VALUES (?, NOW(), ?, ?)";
        $stmt = db_get_prepare_stmt($conToYeti, $sqlInsert, $rate);
        $res = mysqli_stmt_execute($stmt);
    }
}

$sqlForLot = "SELECT l.title, l.description, l.img, c.name AS 'category', l.dateClosing, "
. "l.initialPrice, l.step, l.createrId, u.id, u.name, r.dateCreating, r.valueRate FROM rates r "
. "RIGHT JOIN lots l ON r.lotId = l.id "
. "JOIN categories c ON l.categoryId = c.id "
. "LEFT JOIN users u ON r.userId = u.id "
. "WHERE l.id = " . $lotId;

$resOfLot = mysqli_query($conToYeti, $sqlForLot);
$lot = mysqli_fetch_all($resOfLot, MYSQLI_ASSOC);

if (count($lot) != 0) {

    $title = $currentPrice = $lot[0]['title'];
    $description = $lot[0]['description'];
    $category = $lot[0]['category'];
    $dateClosing = $lot[0]['dateClosing'];
    $img = $lot[0]['img'];
    $createrId = $lot[0]['createrId'];

    usort($lot, fn($a, $b) => $b['valueRate'] <=> $a['valueRate']);

    if (is_numeric($lot[0]['valueRate'])) {
        $currentPrice = $lot[0]['valueRate'];
    } else {
        $currentPrice = $lot[0]['initialPrice'];
        $missingRates = true;
    }

    $minRate = $currentPrice + $lot[0]['step'];
        
    $page_content = include_template('getlot.php', ['lotId' => $lotId, 'title' => $title,
    'description' => $description, 'category' => $category, 'dateClosing' => $dateClosing,
    'currentPrice' => $currentPrice, 'minRate' => $minRate, 'img' => $img,
    'dateClosing' => $dateClosing, 'invalidCost' => $invalidCost, 'lot' => $lot,
    'missingRates' => $missingRates, 'createrId' => $createrId]);
} else {
    $page_content = include_template('404.php');
}

$layout_content = include_template('layout.php', ['mainContent' => $page_content]);
print($layout_content);

function inValidCost($cost, $minRate) 
{
    if (strlen($cost) == 0 || !is_numeric($cost) || $cost < $minRate) {
        return true; 
    }
}