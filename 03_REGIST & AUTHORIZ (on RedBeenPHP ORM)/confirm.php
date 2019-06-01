<?php
 session_start();
header("Content-Type:text/html;charset=utf8");

require "config.php";
require "functions.php";

if($_GET['hash']) {
	
	$confirm = confirm();
	
	if($confirm === TRUE) {
		$confirm = "Ваша учетная запись активирована. Можете авторизироваться нга сайте.";
	}
}
else {
	$error = "Неверная ссылка";
}


?>
<? include "inc/header.php";?>
	<div id="content">
		<div id="main">
			<?=$error;?>
			<?=$confirm;?>	
		</div>
<? include "inc/sidebar.php";?>		
	
<? include "inc/footer.php";?>