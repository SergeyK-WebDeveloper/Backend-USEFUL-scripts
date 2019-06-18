<?php
require 'phpmailer/helperPHPMailer.php';

ob_start();
var_dump($_POST);
var_dump($_FILES);
$str = ob_get_clean();
file_put_contents('dump.log', $str);

die;

// ################## получаемые данные от формы ##################
//
// настройка валидации данных из формы
$inputs = [
    'name' => ['lenStr', 5, 50, false], // lenStr - название проверочной функции, 2 и 50 - аргументы передаваемые в функцию (мин и макс кол символов), true - обризать лишний текст (иначе удаляет все содержимое)
    'password' => ['lenStr', 6, 125, false],
    'email' => 'isMail',
    'tel' => 'isPhone',
    'date' => ['isDate', 'Y-m-d H:i:s'],
    'select' => '',
    'multiselect' => '',
    'text-area' => ['lenStr', 5, 250, true],
    'checkbox-1' => '',
    'checkbox-2' => '',
    'radio-btn' => '',
];

$requires = ['name', 'number', 'email'];




// получение всех полей указанных в $inputs
$formData = getFormData($inputs);
// проверка обязательных полей $requires
$requireResult = testRequires($formData, $requires);

//if(!$requireResult){
//    echo 'error - required';
//    die;
//}


echo "<pre>";
var_dump($formData);
echo "</pre>";
//var_dump($formData);








$name = 'ASD4';
$number = '11123123';
$email = 'asd@asd.asd';


// ################## формирования письма ##################
//
// тема письма
$mail_subject = 'Заголовок письма';

// текст письма
$mail_body =  "<b>Имя $name . Телефон $number . Почта $email </b>";




$result = sendMail($mail_subject, $mail_body);



// если необходимо задать особые настройки для отправки. Все поля не обязательны. Можно переопределить любое из значений в примере ниже
//$customConfig = [
//    'fromMail' => 'denis-test@sofona.info', // Ваш Email, с которого отправляется письма (если используется SMTP, крайне желательно, чтоб совпадал с email-ом SMTP)
//    'receiverMails' => 'dev2.sofona@gmail.com', // Email получателей
//    'bccMails' => 'sblazze@gmail.com', // Email скрытых получателей (если нужно)
//    'isHtml' => true // текст письма оформлен при помощи HTML тегов - true | обычный текст - false
//];
//$result = sendMail($mail_subject, $mail_body, $customConfig);
