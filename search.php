<?php
require_once('helpers.php');

$searchString = '';
if (isset($_GET['search'])) {
    $searchString = $_GET['search'];
}

if (invalidPage($_GET['page'])) {
    header("Location: search.php?page=1&search=$searchString");
}

$currentPage = $_GET['page'];
$limitItems = 6;
$offset = ($_GET['page'] - 1) * $limitItems;

$conToYeti = getConn();

$sqlForCount = "SELECT count(*) FROM lots WHERE MATCH (title, description) AGAINST('$searchString')";
$resOfCount = mysqli_query($conToYeti, $sqlForCount);
$forCount = mysqli_fetch_all($resOfCount, MYSQLI_ASSOC);
$count = $forCount[0]['count(*)'];
$countPage = ceil($count / $limitItems);

$sqlForSearch = "SELECT l.id, title, description, img, c.name AS "
. "'category', dateClosing, initialPrice FROM lots l "
. "JOIN categories c ON l.categoryId = c.id "
. "WHERE MATCH (title, description) AGAINST('$searchString') "
. "LIMIT $limitItems OFFSET $offset";
$resOfSearch = mysqli_query($conToYeti, $sqlForSearch);
$items = mysqli_fetch_all($resOfSearch, MYSQLI_ASSOC);

$items = getPrice($items);

$page_content = include_template('searchf.php', ['items' => $items, 'searchString' => $searchString,
'countPage' => $countPage, 'currentPage' => $currentPage, 'count' => $count]);
$layout_content = include_template('layout.php', ['mainContent' => $page_content]);
print($layout_content);