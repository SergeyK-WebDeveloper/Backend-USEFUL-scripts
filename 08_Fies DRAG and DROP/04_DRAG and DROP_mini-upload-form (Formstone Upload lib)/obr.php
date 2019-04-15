<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if(!empty($_FILES['newfile'])) {
		if(move_uploaded_file($_FILES['newfile']['tmp_name'],'uploads/'.$_FILES['newfile']['name'])){
			echo 'OK';
		}
		else {
			echo 'ERROR';
		}
	}
}
?>