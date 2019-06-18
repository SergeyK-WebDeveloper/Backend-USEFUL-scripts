<?php
// ################## отправитель и получатели ##################
$fromMail = 'denis-test@sofona.info'; // Ваш Email, с которого отправляется письма (если используется SMTP, крайне желательно, чтоб совпадал с email-ом SMTP)
$receiverMails = 'dev2.sofona@gmail.com'; // Email получателей
$bccMails = 'sblazze@gmail.com'; // Email скрытых получателей (если нужно)


// ################## Настройки SMTP ##################
$isSmtp = true; // если используется SMTP - true, иначе - false
$smtp_config = [
    'host' => 'mail.smartmail.club',
    'username' => 'denis-test@sofona.info',
    'password' => 'pi1BPPHS-rI',
];

// ################## Настройки содержимого письма ##################
$isHtml = false; // текст письма оформлен при помощи HTML тегов - true | обычный текст - false
