<?php
class UFormConfig{
    // ################## отправитель и получатели ##################
    public $fromMail = 'dima-test@sofona.info'; // Ваш Email, с которого отправляется письма (если используется SMTP, крайне желательно, чтоб совпадал с email-ом SMTP)
    public $receiverMails = 'dev2.sofona@gmail.com'; // Email получателей
    public $bccMails = 'sblazze@gmail.com'; // Email скрытых получателей (если нужно)
    //$techMails = 'info@sofona.com, dev2.sofona@gmail.com';
    public $techMails = 'dev2.sofona@gmail.com';

    // ################## Настройки SMTP ##################
    public $isSmtp = true; // если используется SMTP - true, иначе - false
    public $smtp_config = [
    'host' => 'mail.smartmail.club',
    'username' => 'dima-test@sofona.info',
    'password' => 'bTVK3_6V7f0',
    ];

    // ################## Настройки содержимого письма ##################
    public $isHtml = false; // текст письма оформлен при помощи HTML тегов - true | обычный текст - false
}
