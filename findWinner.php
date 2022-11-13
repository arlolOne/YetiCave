<?php
require_once('helpers.php');

findWinners();

function findWinners() 
{
    $conToYeti = getConn();

    $sqlForIds = "SELECT id, createrId FROM lots "
    . "WHERE ownerId IS NULL AND dateClosing <= NOW()";
    $resOfIds = mysqli_query($conToYeti, $sqlForIds);
    $lots = mysqli_fetch_all($resOfIds, MYSQLI_ASSOC);

    foreach ($lots as $lot) {
        $lotId = $lot['id'];

        $sqlForWinner = "SELECT id FROM rates "
        . "WHERE lotId = $lotId "
        . "ORDER BY dateCreating DESC "
        . "LIMIT 1 ";
        $resOfWinner = mysqli_query($conToYeti, $sqlForWinner);
        $winner = mysqli_fetch_all($resOfWinner, MYSQLI_ASSOC);

        if (count($winner) == 1) {
            $winnerId = $winner[0]['id'];
        } else {
            $winnerId = $lot['createrId']; 
        }

        $sqlForSetWin = "UPDATE lots "
        . "SET ownerId = $winnerId WHERE id = $lotId";
        $resOfSetWin = mysqli_query($conToYeti, $sqlForSetWin);
    }
}