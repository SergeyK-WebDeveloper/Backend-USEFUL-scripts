<?php
session_start();
header("Content-Type:text/html;charset=utf8");

require "config.php";
require "functions.php";

if(isset($_POST['login']) && isset($_POST['password'])) {

	$msg = login($_POST);
	
	if($msg === TRUE) {
		header("Location:admin.php");
	}
	else {
		$_SESSION['msg'] = $msg;
		header("Location:".$_SERVER['PHP_SELF']);
	}
	exit();
	
}
if(isset($_POST['loguot'])) {
	$msg = logout();
	
	if($msg === TRUE) {
		$_SESSION['msg'] = "Вы вышли из системы";
		header("Location:".$_SERVER['PHP_SELF']);
		exit();
	}
}	
?>
<? include "inc/header.php";?>
	<div id="content">
		<div id="main">
			<h1>Авторизируйтесь</h1>
			<?=$_SESSION['msg'];?>
			<? unset($_SESSION['msg'])?>
				<form method='POST'>
				<label>
				login<br>
					<input type='text' name='login'>
				</label><br>
				Password<br>
				<label>
					<input type='password' name='password'>
				</label><br>
				<label>Member
					<input type="checkbox" name='member' value="1">
				</label><br>
				<input style="float:left" type='submit' value='Вход'>
			</form>
			
			<form  method='POST'>
				<input style="margin-top:-16px;" type='submit' name="loguot" value='Выход'>
			</form>
			<p>
				<a href="registration.php">Регистрация</a> | <a href="returnpas.php">Забыли пароль?</a>
			</p>		
		</div>
	<? include "inc/sidebar.php";?>		
	
<? include "inc/footer.php";?>	
