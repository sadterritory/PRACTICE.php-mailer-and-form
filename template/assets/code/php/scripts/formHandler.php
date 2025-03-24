<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once $_SERVER["DOCUMENT_ROOT"].'/PHPMailer/src/Exception.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/PHPMailer/src/PHPMailer.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/PHPMailer/src/SMTP.php';

$counter = 1;

$str = "error" . $counter;

$errors = array();

if (empty($_POST["orgName"]) && empty($_POST["userData"]) && empty($_POST["email"]) && empty($_POST["phone"]) && empty($_POST["region"])) {
    $errors[$str] = "1";
    echo json_encode($errors);
    $_POST = array();
    exit;
}

//check orgName
if (!empty($_POST["orgName"])) {
    checkOrgName($errors);
} else {
    $errors[$str] = "2";
}
$counter++;
$str = "error" . $counter;

//check userData
if (!empty($_POST["userData"])) {
    checkUserName($errors);
} else {
    $errors[$str] = "3";
}
$counter++;
$str = "error" . $counter;

//check email
if (!empty($_POST["email"])) {
    checkMail($errors);
} else {
    $errors[$str] = "5";
}
$counter++;
$str = "error" . $counter;

//check phone
if (!empty($_POST["phone"])) {
    checkPhone($errors);
} else {
    $errors[$str] = "4";
}
$counter++;
$str = "error" . $counter;

//check region
if (!empty($_POST["region"])) {
    checkRegion($errors);
} else {
    $errors[$str] = "6";
}

if (empty($errors)) {

    $subject = 'Введенные вами данные в форму сайта Valvoline';

    $mail = new \PHPMailer\PHPMailer\PHPMailer();
    $mail->CharSet = 'UTF-8';

    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPDebug = 0;

    /* Configuration */
    $mail->Host = 'ssl://smtp.yandex.ru';
    $mail->Port = 465;
    $mail->Username = 'kuvandykovr@internet.ru';
    $mail->Password = '9628117193Rk**';

    $mail->setFrom('kuvandykovr@internet.ru', 'Ruslan Kuvandykov');
    $mail->addAddress('kuvandykov.ruslanchik@mail.ru', 'Ruslan Kuvandykov');
    $mail->Subject = $subject;

    $body = '<p>Название организации: ' . $_POST["orgName"] . '</p> <p>Фамилия, имя пользователя: ' . $_POST["userData"] .
        '</p> <p>Почта: ' . $_POST["email"] . '</p> <p>Телефон:' . $_POST["phone"] . '</p> Регион комм. деятельности: ' . $_POST["region"] . '</p>';
    $mail->msgHTML($body);

    $mail->send();

} else {
    echo json_encode($errors);
    $_POST = array();
}


function checkOrgName(&$arr)
{
    if (!(preg_match('/\w+/', $_POST["orgName"]))) $arr["orgName"] = "7";
}

function checkUserName(&$arr)
{
    if (!(preg_match('/[A-Z][a-z]+[ ]+[A-Z][a-z]+/', $_POST["userData"]))) $arr["userData"] = "8";
}

function checkPhone(&$arr)
{
    if (!(preg_match('/^((\+7|7|8)+([0-9]){10})$/', $_POST["phone"]))) $arr["phone"] = "9";
}

function checkMail(&$arr)
{
    if (!(preg_match('/^\w+@\w+\.\w{2,}$/', $_POST["email"]))) $arr["email"] = "10";
}

function checkRegion(&$arr)
{
    if (!(preg_match('/([А-Я][а-я]+[ ]+[-,]?[А-Я][а-я]+)|([А-Яа-я]+)+/', $_POST["region"]))) $arr["region"] = "11";
}

TODO:
/*подключить библиотеку для отправки писем: https://snipp.ru/php/class-mail */
/*собрать данные с формы и отправляем письмо на почту (InfantryManStart@mail.ru)*/

?>
