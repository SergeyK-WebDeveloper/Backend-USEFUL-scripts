<?php
session_start();
header("Content-Type:text/html;charset=utf8");

require ("config.php");
require ("functions.php");
//var_dump(check_user());
//exit();
//unset($_SESSION['sess']);
if(!check_user()) {
	header("Location:login.php");
	exit();
}
?>
<? include "inc/header.php";?>
	<div id="content">
		<div id="main">
				Какой то контент	
		</div>
<? include "inc/sidebar.php";?>		
	
<? include "inc/footer.php";?>


