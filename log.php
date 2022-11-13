<?php
/*
1. session_start(); должна вызываться не только на странице логина, но и на всех страницах,
где предполагается работа в рамках этой сессии (здесь в layout.php, getlot.php и т.д.),
поскольку только после такого рестарта сессии мы получим доступ к $_SESSION;
2. session_start(); должна вызываться до любого вывода информации пользователю.
*/
require_once('helpers.php');

$invalids = [];
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST as $key => $value) {
        if (strlen($value) == 0) { 
            array_push($invalids, $key); 
        }
    }

    if (count($invalids) == 0) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        if (existEmail($email)) {
            $conToYeti = getConn();
            $sqlForUser = "SELECT id, name, userPassword FROM users WHERE email = '$email'";
            $resOfUser = mysqli_query($conToYeti, $sqlForUser);
            $user = mysqli_fetch_all($resOfUser, MYSQLI_ASSOC);

            if (password_verify($password, $user[0]['userPassword'])) {
                session_start();

                $_SESSION['id'] = $user[0]['id'];
                $_SESSION['name'] = $user[0]['name'];
                $_SESSION['email'] = $email;

                header('Location: /');
                exit();
            }
            else { 
                $errorMessage = 'Введён неверный пароль'; 
            }
        }
        else { 
            $errorMessage = 'Указаный адрес не существует'; 
        }
    }
    else { 
        $errorMessage = 'Заполните все поля!'; 
    }
}

$page_content = include_template('logf.php', ['invalids' => $invalids,
'errorMessage' => $errorMessage]);
$layout_content = include_template('layout.php', ['mainContent' => $page_content]);
print($layout_content);

function existEmail($email) 
{
    $conToYeti = getConn();
    $sqlForEmails = "SELECT email FROM users";
    $resOfEmails = mysqli_query($conToYeti, $sqlForEmails);
    $emails = mysqli_fetch_all($resOfEmails, MYSQLI_ASSOC);

    foreach ($emails as $value) {
        if ($value['email'] == $email) {
            return true;
        }
    }
}