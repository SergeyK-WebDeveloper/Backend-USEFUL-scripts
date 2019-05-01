<?
/*
source path === your website path...like http://www.abc.com or http://www.abc.com/yourdirectory
Back Up Path: === where you want to store back up ..... like D:\myBackUp
Host Name: ==  like www.abc.com default 'localhost'
User Nam :  == user of database defualt 'root'
Password :  == password of ur database
Database Name:  == database name .. you want to take backup
SQL File Name: == sql file anme... like 'mydb_backup'

Author == Muhammad Sohail Khan
Country == Pakistan
City == Islamabad

I will waite for ur comments..

hotmail == silentvoilents@hotmail.com
yahoo == mr_sohail_khan@yahoo.com

*/

include("db_backup.php");
include("dirCopy.php");

if (isset($_POST['s_b']))
{
	$dirCopy = new dirCopy() ;
	
	$src_path = $_POST['src_path'] ;
	$dest_path = $_POST['dest_path'] ;
	
	$dirCopy -> dirCopy($src_path , $dest_path) ;
	
}
if (isset($_POST['b_b']))
{
	$dir_name = $_POST['dir_name'] ;
	$fileSQL = $_POST['filename'] ;
	$filename = $fileSQL.'.sql' ; 
	$mkBackup	= new db_backup($filename);
	$mkBackup->Backup($_POST['host'],"",$_POST['user'],$_POST['passwd'],$_POST['db_name']);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<p>&nbsp;</p>
<p>&nbsp;</p>

<table width="578" border="0" align="center">
<form id="siteBackUp" name="siteBackUp" method="post" action="">
	<tr>
		<td colspan="2"><div align="center"><strong>Web Site BackUp: </strong></div></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Source Path: </td>
		<td>
			<input name="src_path" type="text" id="src_path" placeholder="http://www.abc.com/yourdirectory"/>		</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Back Up Path: </td>
		<td><input name="dest_path" type="text" id="dest_path" placeholder="D:\myBackUp"/></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input name="s_b" type="submit" id="s_b" value="Site BackUp" /></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	</form>
	<form id="DataBaseBackUp" name="DataBaseBackUp" method="post" action="">
	<tr>
		<td colspan="2"><div align="center"><strong>Database BackUp: </strong></div></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Host Name: </td>
		<td><input name="host_name" type="text" id="host_name" placeholder="www.abc.com - default 'localhost'"/></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>User Name: </td>
		<td><input name="user_name" type="text" id="user_name" /></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Password : </td>
		<td><input name="passwd" type="password" id="passwd" /></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>Database Name: </td>
		<td><input name="db_name" type="text" id="db_name" /></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>SQL File Name: </td>
		<td><input name="filename" type="text" id="filename" /></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input name="b_b" type="submit" id="b_b" value="Database BackUp" /></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	</form>
</table>

</body>
</html>
