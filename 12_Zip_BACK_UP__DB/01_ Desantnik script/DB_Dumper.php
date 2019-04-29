<?php
include 'DBBackup.class.php';
date_default_timezone_set('Europe/Kiev');
//echo "Begin...<hr/>";

$db = new DBBackup(array(
	'driver' => 'mysql',
	'host' => 'localhost',
	'user' => 'root',      // ###
	'password' => '###',   // ###
	'database' => '###'    // ###
));
$backup = $db->backup();

$date = date( 'Y_m_d-H_i_s' );
if(!$backup['error']){
	// If there isn't errors, show the content
	// The backup will be at $var['msg']
	// You can do everything you want to. Like save in a file.
	// $fp = fopen('file.sql', 'a+');fwrite($fp, $backup['msg']);fclose($fp);
	//echo nl2br($backup['msg']);
	
	$file_name = 'db-dump-' . $date . '.sql';
	if( file_put_contents($file_name, $backup['msg']) ){
		//echo 'The file "'.$file_name.'" was successfully created!';
		
		//Подсистема компрессии дампов
		if(!file_exists($file_name.'.zip')){
            $file = fopen($file_name.'.zip','a+');
            fclose($file);
        }
        
        $zip = new ZipArchive;
        if ($zip->open($file_name . '.zip') === TRUE) {
            $file_path = __DIR__;
            //var_dump($file_path);
            $zip->addFile($file_path.'/'.$file_name, $file_name);
            $zip->close();
            unlink($file_name);
        } else {
            echo 'Failed zip';
        }
	}
	else{
		echo 'The file "'.$file_name.'" was not created...';
	}

//	$db -> compress( 'db-dump-' . $date . '.gz' );
} else {
	echo 'An error has ocurred!<br/>';
	echo $backup['msg'];
}

//Подсистема вращения дампов
$dumps = glob("db-dump-*.zip");
//var_dump($dumps);
// удаляем дампы, созданные более 3 суток назад 
foreach ($dumps as $dump) {
    if ( time()-filectime($dump) > 3 * 86400 ) {  
      unlink($dump);
    }
}


?>
