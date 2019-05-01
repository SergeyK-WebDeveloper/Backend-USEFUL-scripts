<?
class dirCopy {
	
	var $g_path = "";
	var $i = 0 ; 
	function dirCopy($src_path = "" , $dest_path = "")
	{
		   	 
		if (is_dir($src_path))
		{
			$dir_name = $dest_path  ;
			$this -> g_path = $dest_path ;
			if(!file_exists($this -> g_path))
			{
				@mkdir($dir_name , 0777);	
			}else{
				@unlink($this -> g_path);
				@mkdir($dir_name , 0777);	
				
			}
			
			if ($dir = @opendir($src_path)) 
			{
				while (($file = @readdir($dir)) !== false) 
				{
					if ($file != '.' && $file != '..')
					{
						if (filetype($src_path.'/'.$file) == 'dir')
						{
						
							@mkdir($dir_name.'/'.$file , 0777);
							echo '<strong>'.$dir_name.'/'.$file .' .............. Directory Created </strong><br>' ;
							$this -> g_path = $dir_name.'/'.$file ;
							@$this -> dirCopy($src_path.'/'.$file , $dir_name.'/'.$file) ;
						} else {
							@copy($src_path.'/'.$file , $dir_name.'/'.$file); 
							echo '<strong>'.$src_path.'/'.$file .' .............. File Created </strong><br>' ;
						}
					
					}	
				}
				
			}
		} else {
			//echo ' cant copy <br>';
		}
		if ($this -> i == 0)
			//@mail('muhammad.sohail@adaptivesolutionsinc.com','myScript','Hi, \n\r Sohail Khan \n\r Your Directory Copy class scirpt has been used.');
		$this -> i++ ;	
	}

}

?>