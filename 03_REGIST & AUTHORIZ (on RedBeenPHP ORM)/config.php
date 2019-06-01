<?php

define("HOST","localhost");
define("USER","Viktor");
define("PASSWORD","1234");
define("DB","reg");



$db = mysql_connect(HOST,USER,PASSWORD);
if (!$db) {
	exit('WRONG CONNECTION');
}
if(!mysql_select_db(DB,$db)) {
	exit(DB);
}
mysql_query('SET NAMES utf8');

?>