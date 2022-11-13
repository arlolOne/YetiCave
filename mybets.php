<?php
require_once('helpers.php');
session_start();

if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];

    $conToYeti = getConn();
    
    $sqlForRates = "SELECT r.lotId, l.img, l.title, c.name, l.dateClosing, "
    . "r.id, r.valueRate, r.dateCreating, cr.contacts FROM rates r "
    . "JOIN lots l ON l.id = r.lotId "
    . "JOIN categories c ON c.id = l.categoryId "
    . "JOIN users u ON u.id = r.userId "
    . "JOIN users cr ON cr.id = l.createrId "
    . "WHERE r.userId = $userId "
    . "ORDER BY r.dateCreating DESC";
    
    $resOfRates = mysqli_query($conToYeti, $sqlForRates);
    $rates = mysqli_fetch_all($resOfRates, MYSQLI_ASSOC);
         
    $page_content = include_template('mybetsf.php', ['rates' => $rates]);
} else {
    $page_content = include_template('404.php');
}
$layout_content = include_template('layout.php', ['mainContent' => $page_content]);
print($layout_content);

function getState($lotId, $rateId, $dateClose) 
{
    $conToYeti = getConn();

    $sqlForUser = "SELECT id FROM rates "
    . "WHERE lotId = $lotId "
    . "ORDER BY dateCreating DESC "
    . "LIMIT 1 ";

    $resOfUser = mysqli_query($conToYeti, $sqlForUser);
    $user = mysqli_fetch_all($resOfUser, MYSQLI_ASSOC);
    $gotUserId = $user[0]['id'];

    $dateNow = strtotime('now');
    $dateClosing = strtotime($dateClose);
    
    if ($dateNow >= $dateClosing) {
        if ($gotUserId == $rateId) {
            return 'win';
        } else {
            return 'lose';
        }
    } 
    return 'continue';
}