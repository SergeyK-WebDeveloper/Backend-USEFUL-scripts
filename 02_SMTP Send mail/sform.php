<?php
use uForm\classes\uForm;

require 'classes/uForm.php';

// ################## получаемые данные от формы ##################
//
if(0) uForm::saveDumpDataForm(); // при необходимости можно сохранить дамп присылаемых данных из формы ($_POST, $_FILES)


// НАСТРОЙКА ВАЛИДАЦИИ ДАННЫХ ИЗ ФОРМЫ
$inputs = [
    'name' => ['lenStr' => [2, 50, false]], // lenStr - название проверочной функции, 2 и 50 - аргументы передаваемые в функцию (мин и макс символов), true - обризать лишний текст (иначе удаляет все содержимое)
    'password' => ['lenStr' => [6, 50, false]],
    'email' => 'isMail', // стандартная PHP фильтр FILTER_VALIDATE_EMAIL
    'tel' => 'isPhone', // очищает телефон от лишних символов и проверяет на количество цифер (7 - 25)
    'date' => ['isDate' => ['SQL']], // ожидаемый формат даты. Доступны: 'SQL' - преобразует любой формат к тику 'Y-m-d H:i:s'; 'TIMESTAMP' - возвращает количество секунд, прошедших с начала эпохи Unix; 'ANY' - проверяет дату и в случае успеха, возвращает в таком формате как и пришло
    'select' => '',
    'multiselect' => '',
    'text-area' => ['lenStr' => [5, 250, true]], // minLen, maxLen, ture - удалять все что превышает длину/false - возвращать как ошибку
    'checkbox-1' => '',
    'checkbox-2' => '',
    'radio-btn' => '',
];


// СПИСОК ОБЯЗАТЕЛЬНЫХ ПОЛЕЙ (файлы не проверяются)
$requires = ['name', 'tel', 'email'];


// НАСТРОЙКА ВАЛИДАЦИИ ЗАГРУЖЕННЫХ ФАЙЛОВ
$files = [
    'uForm_file' => ['maxSizeOneFile' => [250]], // максимальный вес файла в KB
    'uForm_files' => [
        'countFiles' => [3], // максимальное количество файлов
        'maxSizeAllFile' => [2048], // максимальный общий вес всех файлов в KB (2048 = 2 МБ * 1024)
//        'typeFile' => ['image/jpeg', 'text/plain'] // будет реализованно при первой необходимости. Список всех типов файлов: https://en.wikipedia.org/wiki/Media_type
    ]
];


// -----------------------------------------------------------------------------------
// ############################### ФОРМИРОВАНИЯ ПИСЬМА ###############################
//
$uform = null;
$formData = getFormData($inputs, $files, $requires, $uform);


// ТЕМА ПИСЬМА
$mail_subject = 'Заголовок письма';


// ТЕКСТ ПИСЬМА (тут формируем тело письма, на свое усмотрение)
// $formData - полученные данные их формы в формате ['name1' => 'value1', 'name2' => 'value2']

$mail_body = '';

foreach ($inputs as $name => $val){
    $mail_body .= '<b>'.$name.'</b>: ';
    $mail_body .= !empty( $formData[$name] )? $formData[$name] : 'empty';
    $mail_body .= '<br>';
}


/**
 * ⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡
 * #################################### НИЖЕ НИЧЕГО МЕНЯТЬ НЕ СТОИТ ####################################
 *
*/




































/**
 * ⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡
 * ########################## Я ЖЕ ПРОСИЛ!  НЕ ДЕЛАЙ ЭТОГО!!!  ТВОЙ КОД ВЫШЕ! ##########################
 * ########################## Я ЖЕ ПРОСИЛ!  НЕ ДЕЛАЙ ЭТОГО!!!  ТВОЙ КОД ВЫШЕ! ##########################
 * ########################## Я ЖЕ ПРОСИЛ!  НЕ ДЕЛАЙ ЭТОГО!!!  ТВОЙ КОД ВЫШЕ! ##########################
 * ⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡⇑⇧⇑⇡
*/





























// КОД - КОТОРЫЙ ЛУЧШЕ НЕ ТРОГАТЬ...
// P.S. И так же все работает :(
//
if(empty($uform)){
    echo json_encode(['success' => false, 'error' => 'create uForm failed']);
    die;
}
/** @var uForm $uform */
$result = $uform->sendMail($mail_subject, $mail_body);
//$answer = ['success' => true];
$answerForAJAX = ['success' => $result[0], 'info' => $result[1]];
echo json_encode($answerForAJAX);


function getFormData($inputs, $files, $requires, &$uform)
{
    $uform = new uForm();
    // получение всех полей указанных в $inputs
    $formData = $uform->getPostData($inputs);
    if(empty($formData)) {
        $answer = ['success' => false, 'info' => 'empty data'];
        echo json_encode($answer);
        die;
    }
    elseif($formData == 'ISBOT'){
        $answer = ['success' => false, 'info' => 'isbot'];
        echo json_encode($answer);
        die;
    }
    // провека и получение файлов
    $uform->getLoadFiles($files);

    // проверка обязательных полей $requires
    $requireResult = $uform->testRequires($requires);
    if($requireResult !== true){
        $answer = ['success' => false, 'info' => 'empty required input', 'data' => $requireResult];
        echo json_encode($answer);
        die;
    }

    return $formData;
}