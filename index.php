<?php
require_once('helpers.php');
require_once('findWinner.php');

if (invalidPage($_GET['page']) || invalidCat($_GET['cat'])) {
    header("Location: index.php?page=1&cat=all");
    exit();
}

$currentCategory = $_GET['cat'];
$condition = '';
if ($currentCategory != 'all') {
    $condition = "WHERE l.categoryId = $currentCategory ";
}

$currentPage = $_GET['page'];
$limitItems = 6;
$offset = ($_GET['page'] - 1) * $limitItems;

$conToYeti = getConn();

$sqlForCount = "SELECT count(*) FROM lots l " . $condition;
$resOfCount = mysqli_query($conToYeti, $sqlForCount);
$forCount = mysqli_fetch_all($resOfCount, MYSQLI_ASSOC);
$count = $forCount[0]['count(*)'];
$countPage = ceil($count / $limitItems);

$sqlForCats = "SELECT id, name, keyword FROM categories";
$sqlForLots = "SELECT l.id, title, description, img, c.name AS "
. "'category', dateClosing, initialPrice FROM lots l "
. "JOIN categories c ON l.categoryId = c.id "
. $condition
. "LIMIT $limitItems OFFSET $offset";

$resOfCats = mysqli_query($conToYeti, $sqlForCats);
$resOfLots = mysqli_query($conToYeti, $sqlForLots);

$categories = mysqli_fetch_all($resOfCats, MYSQLI_ASSOC);
$items = mysqli_fetch_all($resOfLots, MYSQLI_ASSOC);

$items = getPrice($items);

$page_content = include_template('main.php', ['items' => $items, 'categories' => $categories,
'countPage' => $countPage, 'currentPage' => $currentPage, 'currentCategory' => $currentCategory]);
$layout_content = include_template('layout.php', ['mainContent' => $page_content]);
print($layout_content);