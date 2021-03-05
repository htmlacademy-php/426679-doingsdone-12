<?php
/**
*Почтовая рассылка с напоминанием
*
*/

require_once('templates/functions.php');
require('vendor/autoload.php');
$link = conect();

//Конфигурациятранспорта
$transport = new Swift_SmtpTransport('phpdemo.ru', 25);
$transport->setUsername("keks@phpdemo.ru");
$transport->setPassword("htmlacademy");

$sql = "SELECT id, username, email FROM users";
$result = mysqli_query($link, $sql);
$result = mysqli_fetch_all($result, MYSQLI_ASSOC);

$sql = "SELECT * FROM tasks";
$res_date = mysqli_query($link, $sql);
$res_date = mysqli_fetch_all($res_date, MYSQLI_ASSOC);

if ($result && $res_date) {
    $message_smtp = [];
    foreach ($result as $res) {
        foreach ($res_date as $value) {
            if ($res['id'] == $value['user_id'] && $value['dt_end'] == date('Y-m-d') && $value['st_check']==0) {
                $message_smtp[] = $value;
                foreach ($message_smtp as $mess) {
                    $message = new Swift_Message("Уведомление от сервиса «Дела в порядке»");
                    $message->setTo(['keks@phpdemo.ru' => 'Дела в порядке']);
                    $message->setBody("Уважаемый " . $$res['user_name'] . " У вас запланирована задача " .
                    $mess['title_task'] . " на ". $mess['dt_end']);
                    $message->setFrom($res['email'], "Дела в порядке");
                    $mailer = new Swift_Mailer($transport);
                    $mailer->send($message);
                }
            }
        }
    }
}

//Формирование сообщения

?>

