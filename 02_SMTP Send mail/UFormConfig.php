<?php
namespace uForm;

class UFormConfig
{
    // ################## отправитель и получатели ##################
    public $fromMail = 'dima-test@sofona.info'; // Ваш Email, с которого отправляется письма (если используется SMTP, крайне желательно, чтоб совпадал с email-ом SMTP)
    public $receiverMails = 'dev2.sofona@gmail.com'; // Email получателей
    public $bccMails = 'sblazze@gmail.com'; // Email скрытых получателей (если нужно)
    //$techMails = 'info@sofona.com, dev2.sofona@gmail.com';
    public $techMails = 'dev2.sofona@gmail.com';

    // ################## Настройки SMTP ##################
    public $isSmtp = true; // если используется SMTP - true, иначе - false
    public $smtp = [
        'username' => 'dima-test@sofona.info',
        'password' => 'bTVK3_6V7f0',

        // this is the default for sofona smtp
        'host' => 'mail.smartmail.club',
        'SMTPAuth' => true,
        'SMTPSecure' => 'ssl',
        'port' => 465
    ];

    // ################## Настройки содержимого письма ##################
    public $isHtml = true; // текст письма оформлен при помощи HTML тегов - true | обычный текст - false
}
