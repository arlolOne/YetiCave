<?php
require_once('helpers.php');

$invalids = [];
$values = [
    'email' => '',
    'password' => '',
    'login' => '',
    'contact' => ''
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mappingValid = [
        'email' => function($email) { return checkEmail($email); },
        'password' => function($no) { return false; },
        'login' => function($no) { return false; },
        'contact' => function($no) { return false; }
    ];

    foreach ($_POST as $key => $value) {
        $values[$key] = $value;
        if (strlen($value) == 0 || $mappingValid[$key]($value)) {
            array_push($invalids, $key);
        }
    }

    if (count($invalids) == 0) {
        $hashPass = password_hash($values['password'], PASSWORD_DEFAULT);
        $values['password'] = $hashPass;

        $conToYeti = getConn();
        $sqlInsert = "INSERT INTO users (email, userPassword, name, contacts) "
        . "VALUES(?, ?, ?, ?)";

        $stmt = db_get_prepare_stmt($conToYeti, $sqlInsert, $values);
        $res = mysqli_stmt_execute($stmt);
        $id = mysqli_insert_id($conToYeti);

        header('Location: log.php');
        exit();
    }
}
session_start();

if (!isset($_SESSION['name'])) {
    $page_content = include_template('regf.php', ['invalids' => $invalids, 'values' => $values]);
} else {
    $page_content = include_template('404.php');
}

$layout_content = include_template('layout.php', ['mainContent' => $page_content]);
print($layout_content);


function checkEmail($email) 
{
    $conToYeti = getConn();
    $sqlForEmails = "SELECT email FROM users";
    $resOfEmails = mysqli_query($conToYeti, $sqlForEmails);
    $emails = mysqli_fetch_all($resOfEmails, MYSQLI_ASSOC);

    $resEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
    $isFound = false;

    foreach ($emails as $value) {
        if ($value['email'] == $email) {
            $isFound = true;
        }
    }
    
    if (strlen($resEmail) == 0 || $isFound) {
        return true; 
    }
}