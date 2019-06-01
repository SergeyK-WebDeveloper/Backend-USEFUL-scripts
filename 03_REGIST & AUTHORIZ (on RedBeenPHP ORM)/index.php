<?php
session_start();
header("Content-Type:text/html;charset=utf8");

require ("config.php");
require ("functions.php");

$posts = get_statti();

?>
<? include "inc/header.php";?>
	<div id="content">
		<div id="main">
				<? foreach ($posts as $item) :?>
						<h1 id="title"><?=$item['title'];?></h1>
						<p><?=$item['date'];?></p>
						<p><img align="left" src="<?=$item['img_src'];?>"><?=$item['discription'];?></p>	
				<? endforeach; ?>		
		</div>
<? include "inc/sidebar.php";?>		
	
<? include "inc/footer.php";?>	


