<?php

function isPhone($item){
    echo 'isPhone ' . $item;

    return $item;
}

function isMail($item){
    echo 'isMail' . $item;

    return $item;

    //saveLog();
    //return null;
}

function lenStr($item, $min, $max, $cut = true){
    echo 'lenStr' . $item . $min . $max;

    return $item;
}

function saveLog($str)
{
    $str = date('Y-m-d H:i:s') . ': ' . $str . PHP_EOL;
    file_put_contents($str, 'error.log', FILE_APPEND|LOCK_EX);
}

function PHPMailerInit($customConfig = null)
{
    /**
     * @var bool $isHtml
     * @var string $fromMail
     * @var string $receiverMails
     * @var string $bccMails
     * @var bool $isSmtp
     * @var array $smtp_config
     */

    require dirname(__DIR__).'/config.php';

    if($customConfig != null){
        if($customConfig == 'tech'){
            $receiverMails = $techMails;
            $bccMails = '';
        }
        else{
            $fromMail = isset($customConfig['fromMail'])? $customConfig['fromMail'] : $fromMail;
            $receiverMails = isset($customConfig['receiverMails'])? $customConfig['receiverMails'] : $receiverMails;
            $bccMails = isset($customConfig['bccMails'])? $customConfig['bccMails'] : $bccMails;
            $isHtml = isset($customConfig['isHtml'])? $customConfig['isHtml'] : $isHtml;
        }
    }


    $mail = new \PHPMailer\customPHPMailer\PHPMailer;

    //################## Настройки SMTP ##################
    if($isSmtp){
        $mail->isSMTP();
        $mail->Host = $smtp_config['host'];
        $mail->Username = $smtp_config['username'];
        $mail->Password = $smtp_config['password'];
    }

    //################## отправитель и получатели ##################
    $mail->setFrom($fromMail); // Email, с которого отправляется письма (крайне желательно, чтоб совпадал с email-ом SMTP (если используется)

    // Email получателей. Все emails видны в получателях
    $receiverMailsArr = explode(',', $receiverMails);
    foreach ($receiverMailsArr as $mailAddr) {
        $mail->addAddress(trim($mailAddr));
    }

    // Email скрытых получателей
    $bccMailsArr = explode(',', $bccMails);
    foreach ($bccMailsArr as $mailAddr) {
        $mail->addBCC(trim($mailAddr));
    }

    $mail->isHTML($isHtml); // формат письма HTML

    return $mail;
}

function getFormData($inputs)
{
    foreach ($inputs as $name => $valid){

        $val = htmlspecialchars(trim($_POST[$name]));
        if(empty($val)){
            $inputs[$name] = null;
            continue;
        }

        if(is_array($valid)){
            switch(count($valid)){
                case '1':
                    $result = $valid[0]($val);
                    break;
                case '2':
                    $result = $valid[0]($val, $valid[1]);
                    break;
                case '3':
                    $result = $valid[0]($val, $valid[1], $valid[2]);
                    break;
                case '4':
                    $result = $valid[0]($val, $valid[1], $valid[2], $valid[3]);
                    break;
                case '5':
                    $result = $valid[0]($val, $valid[1], $valid[2], $valid[3], $valid[4]);
                    break;
                default:
                    $result = false;
            }
            $inputs[$name] = $result;
        }
        else {
            $inputs[$name] = $valid($val);
        }
    }

    return $inputs;
}

function testRequires($data, $requires)
{
    if(empty($data)){
        $str = date('Y-m-d H:i:s') . ': Empty data!' . PHP_EOL;
        file_put_contents('errors.log', $str, FILE_APPEND|LOCK_EX);
        sendTechInfo($str);
        return $str;
    }

    $fieldsFail = [];
    foreach ($requires as $require){
        if(!isset($data[$require]) || empty($data[$require])){
            $fieldsFail[] = $require;
        }
    }

    if(!empty($fieldsFail)){

        $str = date('Y-m-d H:i:s') . ': Empty required fields: ' . implode(',', $fieldsFail) . PHP_EOL;
        file_put_contents('errors.log', $str, FILE_APPEND|LOCK_EX);
        sendTechInfo($str);
        return $str;
    }

    return true;
}

function sendTechInfo($msg){
    $subj = 'Error sending a message: ' . $_SERVER['SERVER_NAME'];
    sendMail($subj, $msg, 'tech');
}

function sendMail($mail_subject, $mail_body, $customConfig = null)
{
    $mail = PHPMailerInit($customConfig);

    $msg = '';
    //################## Прикрепление файлов ##################
    for ($ct = 0; $ct < count($_FILES['userfile']['tmp_name']); $ct++) {

        $uploadfile = tempnam(sys_get_temp_dir(), sha1($_FILES['userfile']['name'][$ct]));
        $filename = $_FILES['userfile']['name'][$ct];

        if (move_uploaded_file($_FILES['userfile']['tmp_name'][$ct], $uploadfile)) {
            $mail->addAttachment($uploadfile, $filename);
        } else {
            $msg .= 'Failed to move file to ' . $uploadfile;
        }
    }


    //################## Заголовок письма ##################
    $mail->Subject = $mail_subject;

    //################## Текст письма ##################
    $mail->Body = $mail_body;

    //################## Результат отправки письма ##################
    if(!$mail->send()) {
        $result = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    } else {
        $result = 'Message sended';
    }

    return $result;
}
