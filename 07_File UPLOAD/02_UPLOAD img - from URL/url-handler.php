<?php

/**
 * Загрузка изображения по ссылке
 * @see http://denisyuk.by/all/polnoe-rukovodstvo-po-zagruzke-izobrazheniy-na-php/
 */
 
 
// Каким-то образом получим ссылку
$url = 'https://storage.googleapis.com/imgfave/image_cache/1483572468343197.jpg';

// Проверим HTTP в адресе ссылки
if (!preg_match("/^https?:/i", $url) && filter_var($url, FILTER_VALIDATE_URL)) {
    die('Укажите корректную ссылку на удалённый файл.');
}

// Запустим cURL с нашей ссылкой
$ch = curl_init($url);

// Укажем настройки для cURL
curl_setopt_array($ch, [

    // Укажем максимальное время работы cURL
    CURLOPT_TIMEOUT => 60,

    // Разрешим следовать перенаправлениям
    CURLOPT_FOLLOWLOCATION => 1,

    // Разрешим результат писать в переменную
    CURLOPT_RETURNTRANSFER => 1,

    // Включим индикатор загрузки данных
    CURLOPT_NOPROGRESS => 0,

    // Укажем размер буфера 1 Кбайт
    CURLOPT_BUFFERSIZE => 1024,

    // Напишем функцию для подсчёта скачанных данных
    // Подробнее: http://stackoverflow.com/a/17642638
    CURLOPT_PROGRESSFUNCTION => function ($ch, $dwnldSize, $dwnld, $upldSize, $upld) {

        // Когда будет скачано больше 5 Мбайт, cURL прервёт работу
        if ($dwnld > 1024 * 1024 * 5) {
            return -1;
        }
    },

    // Включим проверку сертификата (по умолчанию)
    CURLOPT_SSL_VERIFYPEER => 1,

    // Проверим имя сертификата и его совпадение с указанным хостом (по умолчанию)
    CURLOPT_SSL_VERIFYHOST => 2,

    // Укажем сертификат проверки
    // Скачать: https://curl.haxx.se/docs/caextract.html
    CURLOPT_CAINFO => __DIR__ . '/cacert.pem',
]);

$raw   = curl_exec($ch);    // Скачаем данные в переменную
$info  = curl_getinfo($ch); // Получим информацию об операции
$error = curl_errno($ch);   // Запишем код последней ошибки

// Завершим сеанс cURL
curl_close($ch);

// Проверим ошибки cURL и доступность файла
if ($error === CURLE_OPERATION_TIMEDOUT)  die('Превышен лимит ожидания.');
if ($error === CURLE_ABORTED_BY_CALLBACK) die('Размер не должен превышать 5 Мбайт.');
if ($info['http_code'] !== 200)           die('Файл не доступен.');

// Создадим ресурс FileInfo
$fi = finfo_open(FILEINFO_MIME_TYPE);

// Получим MIME-тип используя содержимое $raw
$mime = (string) finfo_buffer($fi, $raw);

// Закроем ресурс FileInfo
finfo_close($fi);

// Проверим ключевое слово image (image/jpeg, image/png и т. д.)
if (strpos($mime, 'image') === false) die('Можно загружать только изображения.');

// Возьмём данные изображения из его содержимого
$image = getimagesizefromstring($raw);

// Зададим ограничения для картинок
$limitWidth  = 1280;
$limitHeight = 768;

// Проверим нужные параметры
if ($image[1] > $limitHeight) die('Высота изображения не должна превышать 768 точек.');
if ($image[0] > $limitWidth)  die('Ширина изображения не должна превышать 1280 точек.');

// Сгенерируем новое имя из MD5-хеша изображения
$name = md5($raw);

// Сгенерируем расширение файла на основе типа картинки
$extension = image_type_to_extension($image[2]);

// Сократим .jpeg до .jpg
$format = str_replace('jpeg', 'jpg', $extension);

// Сохраним картинку с новым именем и расширением в папку /pics
if (!file_put_contents(__DIR__ . '/pics/' . $name . $format, $raw)) {
    die('При сохранении изображения на диск произошла ошибка.');
}