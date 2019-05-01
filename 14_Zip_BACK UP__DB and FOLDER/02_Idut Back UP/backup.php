<?php
/* Idut Backup v1.0
 * (c) 2006-2008 Idut - www.idut.co.uk
 * backup.php
 */

//PUT IN THE FILE LOCATION OF THE CONFIG FILE
$configFile = "backupconfig.php";


include($configFile);
if($conf == null){
        echo "The config file was not found for Idut Backup.";
        echo "<hr>";
        echo '<a href="http://www.idut.co.uk">Idut Backup</a> v1.0';
        exit;
}

//Make sure people log in to use this
login();

main();

if(isset($_POST['c'])){
        $c = $_POST['c'];
}elseif(isset($_GET['c'])){
        $c = $_GET['c'];
}else{
        $c = null;
}

if($c == "backup"){
        backupMain();
}elseif($c == "backupdefault"){
        backupDefault();
}elseif($c == "backupclear"){
        backupClear();
}elseif($c == "backupemail"){
        backupEmailMain();
}elseif($c == "backupemaildefault"){
        backupEmailDefault();
}elseif($c == "viewbackup"){
        viewBackupMain();
}elseif($c == "viewbackupdetails"){
        viewBackupDetails($_GET['file']);
}elseif($c == "viewbackupsub"){
        viewBackupSub($_GET['file'],$_GET['sub']);
}elseif($c == "viewrestore"){
        viewRestore();
}elseif($c == "restorebackup"){
        doRestore($_GET['file']);
}elseif($c == "settings"){
        settingsMain();
}elseif($c == "settingschange"){
        settingsChange($_POST['backupname'],$_POST['login'],$_POST['password'],$_POST['backupdir'],$_POST['backuptype'],$_POST['backupfile'],$_POST['afterbackup'],$_POST['backupfilepre'],$_POST['backupfileext'],$_POST['files'],$_POST['email'],$_POST['doDatabaseBackup'],$_POST['dbUser'],$_POST['dbPassword'],$_POST['dbHost'],$_POST['dbDatabase'],$_POST['dbTables']);
}else{
        echo "Welcome to Idut Backup.<br/>Please choose an option from above to get started.";
}

function login(){
        global $conf, $PHP_AUTH_USER, $PHP_AUTH_PW;
        if ( (!isset($PHP_AUTH_USER)) || ! (($PHP_AUTH_USER == $conf['login']) && ($PHP_AUTH_PW == $conf['password'])) ) {
                        header("WWW-Authenticate: Basic realm=\"Idut Backup\"");
                        header("HTTP/1.0 401 Unauthorized");
                        echo "Unauthorized access to Idut Backup.";
                        echo "<hr>";
                        echo '<a href="http://www.idut.co.uk">Idut Backup</a> v1.0';
                        exit;
        }
}//login

function main(){
        global $conf;
        ?>
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Idut Backup</title>
        <style>
        body {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 10px;
}
    </style>
        </head>
        
        <body>
        <b><font size="3">Idut Backup</font></b><br />
        <br />
        <img src="idutbackupbuttons.jpg" width="501" height="74" border="0" usemap="#Map" />
    <map name="Map" id="Map">
      <area shape="rect" coords="2,3,90,65" href="?c=backup" alt="backup" />
          <area shape="rect" coords="101,3,190,65" href="?c=backupemail" alt="backup &amp; email" />
      <area shape="rect" coords="202,3,290,65" href="?c=viewbackup" alt="view backup" />
      <area shape="rect" coords="302,3,391,65" href="?c=viewrestore" alt="restore backup" />
      <area shape="rect" coords="402,3,490,65" href="?c=settings" alt="settings" />
    </map><br/><br/>
        <?php
}

function backupMain(){
?>
    <a href="?c=backupdefault">Backup default files</a>
    <?php
}//backupMain

function backupDefault(){
        global $conf;
        require("Tar.php");
        $savefile = null;
        if($conf['backuptype'] == 1){
                $savefile = $conf['backupdir'].$conf['backupfile'];
        }else{
                $savefile = $conf['backupdir'].$conf['backupfilepre'].date("Y-m-d H-i-s").$conf['backupfileext'];
        }
        $tar = new Archive_Tar($savefile, "gz");
        $tar->create($conf['files']) or die("Could not create archive!");
        if($conf['doDatabaseBackup']){
                $tar->addString("dbBackup.sql", doSQLBackup());
        }
        
        echo 'Backup saved to <a href="'.$savefile.'">'.$savefile.'</a>';
        
        if($conf['backuptype'] == 1){
                if($conf['afterbackup'] == 1){
                        echo '<br/><br/><a href="?c=backupclear">Clear Backup file</a>';
                }
        }
}//backupDefault

function backupClear(){
        global $conf;
        $savefile = null;
        
        if($conf['backuptype'] == 1){
                $savefile = $conf['backupdir'].$conf['backupfile'];
        }else{
                $savefile = $conf['backupdir'].$conf['backupfilepre'].date("Y-m-d H-i-s").$conf['backupfileext'];
        }
        
        $handle = fopen($savefile, 'w');
        if (fwrite($handle, "") === FALSE) {
                echo "Cannot write to file ($savefile)";
        }else{
                echo "Backup file cleared";
        }
}//backupClear

function backupEmailMain(){
        global $conf;
?>
    <a href="?c=backupemaildefault">Backup default files and email them to <?php echo $conf['email'];?></a>
    <?php
}//backupEmailMain

function backupEmailDefault(){
        global $conf;
        require('Tar.php');
        $savefile = null;
        if($conf['backuptype'] == 1){
                $savefile = $conf['backupdir'].$conf['backupfile'];
        }else{
                $savefile = $conf['backupdir'].$conf['backupfilepre'].date("Y-m-d H-i-s").$conf['backupfileext'];
        }
        
        $tar = new Archive_Tar($savefile, "gz");
        $tar->create($conf['files']) or die("Could not create archive!");
        if($conf['doDatabaseBackup']){
                $tar->addString("dbBackup.sql", doSQLBackup());
        }
        
        echo 'Backup saved.<br/><br/>';
        
        $headers = "From: ".$conf['email'];
        $email_subject = 'Idut Backup for '.$conf['backupname'].' ('.date("Y-m-d H:i:s").')';
        $email_message = 'Attached is the backup created by Idut Backup from the service '.$conf['backupname'].' as taken on '.date("Y-m-d H:i:s").'.';



$semi_rand = md5(time());
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

$headers .= "\nMIME-Version: 1.0\n" .
            "Content-Type: multipart/mixed;\n" .
            " boundary=\"{$mime_boundary}\"";

$email_message .= "This is a multi-part message in MIME format.\n\n" .
                "--{$mime_boundary}\n" .
                "Content-Type:text/html; charset=\"iso-8859-1\"\n" .
               "Content-Transfer-Encoding: 7bit\n\n" .
$email_message . "\n\n";


/********************************************** First File ********************************************/

$fileatt = $savefile; // Path to the file
$fileatt_type = "application/octet-stream"; // File Type
$fileatt_name = "backup.tar.gz"; // Filename that will be used for the file as the attachment

$file = fopen($fileatt,'rb');
$data = fread($file,filesize($fileatt));
fclose($file);


$data = chunk_split(base64_encode($data));

$email_message .= "--{$mime_boundary}\n" .
                  "Content-Type: {$fileatt_type};\n" .
                  " name=\"{$fileatt_name}\"\n" .
                  //"Content-Disposition: attachment;\n" .
                  //" filename=\"{$fileatt_name}\"\n" .
                  "Content-Transfer-Encoding: base64\n\n" .
                 $data . "\n\n" .
                  "--{$mime_boundary}\n";

$email_message .= "--";

$ok = @mail($conf['email'], $email_subject, $email_message, $headers);

if($ok) {
        echo "Backup has been emailed!";
}else{
        echo "Backup email could NOT be send";
}

        if($conf['backuptype'] == 1){
                if($conf['afterbackup'] == 1){
                        echo '<br/><br/><a href="?c=backupclear">Clear Backup file</a>';
                }
        }

}//backupEmailDefault

function viewBackupMain(){
        global $conf;
        if($conf['backuptype'] == 1 AND $conf['afterbackup'] == 0){
                viewBackupDetails($conf['backupfile']);
        }elseif($conf['afterbackup'] > 0){
                echo 'Can\'t view backup. Your backup files are cleared after use.';
        }else{
                $dh  = opendir($conf['backupdir']);
                while (false !== ($value = readdir($dh))){
                        if($value != "." AND $value != ".."){
                                   echo 'View details for <a href="?c=viewbackupdetails&file='.$value.'">'.$value.'</a> ';
                           echo '(<a href="'.$conf['backupdir'].$value.'">Download</a>)<br/>';
                        }
                }
        }
}//viewBackupMain

function viewBackupDetails($file){
        global $conf;
        $fileo = $file;
        $file = $conf['backupdir'].$file;
        echo 'Backup file: <b>'.$file.'</b> (<a href="'.$file.'">Download</a>)<br/><br/>';
        require("Tar.php");
        $tar = new Archive_Tar($file);
        if (($arr = $tar->listContent()) != 0){
                foreach ($arr as $a){
                        if($a['size'] > 0){
                                echo $a['filename'].', '.$a['size'].' bytes, last modified on '.date("Y-m-d H:i:s", $a['mtime']).' (<a href="?c=viewbackupsub&file='.$fileo.'&sub='.$a['filename'].'">View</a>)<br/>';
                        }
                }
        }
}//viewBackupDetails

function viewBackupSub($file,$sub){
        global $conf;
        $fileo = $file;
        $file = $conf['backupdir'].$file;
        echo 'Viewing <b>'.$sub.'</b> within backup file <b>'.$file.'</b><br/><br/>';
        require("Tar.php");
        $tar = new Archive_Tar($file);
        echo '<pre style="font-size:12px; border: 1px solid #336699;background-color:#DFEAF4;">';
        echo $tar->extractInString($sub);
        echo '</pre>';
}//viewBackupDetails

function settingsMain(){
        global $conf;
        ?>
        <form method="post" action="">
        <table border="0" cellpadding="4" cellspacing="1" bgcolor="#336699">
      <!--<tr bgcolor="#336699">
        <td><b><font color="#FFFFFF">Setting Name</font></b></td>
        <td><b><font color="#FFFFFF">Setting Value</font></b></td>
        <td><b><font color="#FFFFFF">Example/Default</font></b></td>
      </tr>
            <tr bgcolor="#FFFFFF">
        <td colspan="3">&nbsp;</td>
      </tr>-->
            <tr bgcolor="#336699">
        <td colspan="3"><big><font color="#FFFFFF">Service Settings</font></big></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>Service name </td>
        <td><input name="backupname" type="text" value="<?php echo $conf['backupname']; ?>" size="20" /></td>
        <td>Idut Backup </td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>Username</td>
        <td><input name="login" type="text" value="<?php echo $conf['login']; ?>" size="20" /></td>
        <td>admin</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>Password</td>
        <td><input name="password" type="password" value="<?php echo $conf['password']; ?>" size="20" /></td>
        <td>admin</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>Email address </td>
        <td><input name="email" type="text" value="<?php echo $conf['email']; ?>" size="20" /></td>
        <td>demo@demo.com (for backups being sent via email)</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td colspan="3">&nbsp;</td>
      </tr>
        <tr bgcolor="#336699">
        <td colspan="3"><big><font color="#FFFFFF">Backup Settings</font></big></td>
      </tr>

              <tr bgcolor="#FFFFFF">
        <td>Backup directory</td>
        <td><input name="backupdir" type="text" value="<?php echo $conf['backupdir']; ?>" size="20" /></td>
        <td>backups/ <i>(Make this folder writeable. CHMOD 0777)</i></td>
      </tr>
            <tr bgcolor="#FFFFFF">
        <td>Backup type </td>
        <td><select name="backuptype" id="backuptype">
          <option value="1"<?php if($conf['backuptype'] == 1) echo ' selected="selected"'; ?>>1. Single Backup</option>
          <option value="2"<?php if($conf['backuptype'] == 2) echo ' selected="selected"'; ?>>2. Archive Backup</option>
                                </select></td>
        <td><i>Single Backup has one backup file and overwrites it each time.<br/>
        Archive backup saves backups in a folder under a new file name each time</i></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>&nbsp;&nbsp;1. Backup file <br/><i>Single Backup only</i></td>
        <td>&nbsp;&nbsp;<input name="backupfile" type="text" value="<?php echo $conf['backupfile']; ?>" size="20" /></td>
        <td>backup.tar.gz <i>(Make this file writeable. CHMOD 0777)</i></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>&nbsp;&nbsp;1. After backup  <br/><i>Single Backup only</i></td>
        <td>&nbsp;&nbsp;<select name="afterbackup" id="afterbackup">
          <option value="0"<?php if($conf['afterbackup'] == 0) echo ' selected="selected"'; ?>>Do Nothing</option>
          <option value="1"<?php if($conf['afterbackup'] == 1) echo ' selected="selected"'; ?>>Remove backup file (if emailing)</option>
        </select></td>
        <td>Do Nothing </td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>&nbsp;&nbsp;2. File prefix <br/><i>Archive Backup only</i></td>
        <td>&nbsp;&nbsp;<input name="backupfilepre" type="text" value="<?php echo $conf['backupfilepre']; ?>" size="20" /></td>
        <td>backup-</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>&nbsp;&nbsp;2. File extension <br/><i>Archive Backup only</i></td>
        <td>&nbsp;&nbsp;<input name="backupfileext" type="text" value="<?php echo $conf['backupfileext']; ?>" size="20" /></td>
        <td>.tar.gz</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td colspan="3">&nbsp;</td>
      </tr>
      <tr bgcolor="#336699">
        <td colspan="3"><big><font color="#FFFFFF">Files to Backup</font></big></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>Files/Directories to backup</td>
        <td><textarea name="files" cols="30" rows="5" id="backupname"><?php
$files = null;
foreach($conf['files'] as $value){
$files = $files.'
'.$value.'';
}
echo $files; ?></textarea></td>

        <td>data/<br />
          <i>(New line per file/directory relative to backup.php script. Include trailing slashes for folders)</i> </td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td colspan="3">&nbsp;</td>
      </tr>
      <tr bgcolor="#336699">
        <td colspan="3"><big><font color="#FFFFFF">Database Tables to Backup</font></big></td>
      </tr>
        <tr bgcolor="#FFFFFF">
        <td>Create database backup?</td>
        <td><select name="doDatabaseBackup" id="doDatabaseBackup">
          <option value="0"<?php if($conf['doDatabaseBackup'] == 0) echo ' selected="selected"'; ?>>No</option>
          <option value="1"<?php if($conf['doDatabaseBackup'] == 1) echo ' selected="selected"'; ?>>Yes</option>
        </select></td>
        <td>No</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>&nbsp;&nbsp;Database username</td>
        <td>&nbsp;&nbsp;<input name="dbUser" type="text" value="<?php echo $conf['dbUser']; ?>" size="20" /></td>
        <td>username</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>&nbsp;&nbsp;Database password</td>
        <td>&nbsp;&nbsp;<input name="dbPassword" type="password" value="<?php echo $conf['dbPassword']; ?>" size="20" /></td>
        <td>password</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>&nbsp;&nbsp;Database host</td>
        <td>&nbsp;&nbsp;<input name="dbHost" type="text" value="<?php echo $conf['dbHost']; ?>" size="20" /></td>
        <td>localhost</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>&nbsp;&nbsp;Database name</td>
        <td>&nbsp;&nbsp;<input name="dbDatabase" type="text" value="<?php echo $conf['dbDatabase']; ?>" size="20" /></td>
        <td>mydatabase</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td>Tables to backup</td>
        <td><textarea name="dbTables" cols="30" rows="5"><?php
$files = null;
foreach($conf['dbTables'] as $value){
$files = $files.'
'.$value.'';
}
echo $files; ?></textarea></td>
                
        <td>table1<br />
          <i>(New line per table)</i> </td>
      </tr>
    </table>
    <br />
    <input name="c" type="hidden" id="c" value="settingschange" />
    <input type="submit" value="Save Settings" />
        </form>
        <?php
}//settingsMain

function settingsChange($backupname,$login,$password,$backupdir,$backuptype,$backupfile,$afterbackup,$backupfilepre,$backupfileext,$files,$email,$doDatabaseBackup,$dbUser,$dbPassword,$dbHost,$dbDatabase,$dbTables){
        global $conf,$configFile;
        if(strlen($login) < 2){
                nogo("Login name must be greater than 2 characters.");
        }elseif(strlen($password) < 2){
                nogo("Password must be greater than 2 characters.");
        }elseif($backuptype < 1 OR $backuptype > 2){
                nogo("Backup type is invalid.");
        }elseif($backuptype == 1 AND strlen($backupfile) < 3){
                nogo("Backup file does not appear to be valid (must be longer than 3 characters).");
        }elseif($afterbackup < 0 OR $afterbackup > 1){
                nogo("After backup option is invalid.");
        }elseif($backuptype == 2 AND strlen($backupfileext) < 2){
                nogo("You need to have a file extension of backup file specified.");
        }elseif(strlen($email) > 0 AND strlen($email) < 5){
                nogo("Your email address either needs to be blank or valid.");
        }else{
                $files = str_replace("\r", "", $files);
                $files = str_replace("\n", "',
                '", $files);
                $files = '\''.$files.'\'';
                
                $dbTables = str_replace("\r", "", $dbTables);
                $dbTables = str_replace("\n", "',
                '", $dbTables);
                $dbTables = '\''.$dbTables.'\'';
                
                $login = stripslashes($login);
                $password = stripslashes($password);
                $backupname = stripslashes($backupname);
                $configdata = '<?php
                                                /* Idut Backup v1.0
                                                 * (c) 2006-2008 Idut - www.idut.co.uk
                                                 * backupconfig.php
                                                 */
                                                 
                                                //Name of this backup service - used for emailing you if you use this for more than one website
                                                $conf[\'backupname\'] = "'.$backupname.'";
                                                
                                                //Username
                                                $conf[\'login\'] = "'.$login.'";
                                                
                                                //Password
                                                $conf[\'password\'] = "'.$password.'";
                                                
                                                //Directory of backup files REMEMBER TRAILING SLASH (e.g. "backups/")
                                                $conf[\'backupdir\'] = "'.$backupdir.'";
                                                
                                                //Backup type
                                                        // 1 = Single file backup
                                                        // 2 = Archive backup files in directory
                                                $conf[\'backuptype\'] = '.$backuptype.';
                                                
                                                //BACKUP TYPE 1 CONFIG...
                                                        //Backup file location
                                                        $conf[\'backupfile\'] = "'.$backupfile.'";
                                                        
                                                        //What to do after the backup is complete
                                                                // 0 = Do Nothing
                                                                // 1 = Clear backup file
                                                        $conf[\'afterbackup\'] = '.$afterbackup.';
                                                        
                                                //BACKUP TYPE 2 CONFIG...
                                                        //Archive Backup file (by date)
                                                        $conf[\'backupfilepre\'] = "'.$backupfilepre.'";
                                                        $conf[\'backupfileext\'] = "'.$backupfileext.'";
                                                
                                                //Default files or directories to backup
                                                $conf[\'files\'] = array(        '.$files.'
                                                                                        );
                                                
                                                //Email address if you use the email option
                                                $conf[\'email\'] = "'.$email.'";
                                                
                                                //SQL options
                                                $conf[\'doDatabaseBackup\'] = '.$doDatabaseBackup.'; //Backup a MySQL database?
                                                $conf[\'dbUser\'] = "'.$dbUser.'";
                                                $conf[\'dbPassword\'] = "'.$dbPassword.'";
                                                $conf[\'dbHost\'] = "'.$dbHost.'";
                                                $conf[\'dbDatabase\'] = "'.$dbDatabase.'";
                                                $conf[\'dbTables\'] = array('.$dbTables.');
                                                ?>';
                if(is_writable($configFile)){
                        if (!$handle = fopen($configFile, 'w')) {
                                echo "Cannot open file ($configFile)";
                                exit;
                        }

                        if (fwrite($handle, $configdata) === FALSE) {
                                echo "Cannot write to file ($configFile)";
                                exit;
                        }
                        fclose($handle);

                        echo 'Config file saved';
                }else{
                        echo "Your config file is not writeable, you can manually copy and paste the following into your config file:";
                        echo '<pre style="font-size:12px; border: 1px solid #336699;background-color:#DFEAF4;">';
                        echo $configdata;
                        echo '</pre>';
                }
        
        }
}//settingsChange


function nogo($string){
        echo $string.'<br>';
}//nogo

function viewRestore(){
        global $conf;
        if($conf['backuptype'] == 1 AND $conf['afterbackup'] == 0){
                echo '<a href="?c=restorebackup&file='.$conf['backupdir'].$conf['backupfile'].'">Click to restore the backup.</a>';
        }elseif($conf['afterbackup'] > 0){
                echo 'Can\'t restore backup. Your backup files are cleared after use in the settings.';
        }else{
                $dh  = opendir($conf['backupdir']);
                while (false !== ($value = readdir($dh))){
                        if($value != "." AND $value != ".."){
                                   echo 'Restore backup <a href="?c=restorebackup&file='.$conf['backupdir'].$value.'">'.$value.'</a> ';
                           echo '(<a href="'.$conf['backupdir'].$value.'">Download</a>)<br/>';
                        }
                }
        }
}//viewRestore

function doRestore($restorefile){
        global $conf;
        require("Tar.php");

        $tar = new Archive_Tar($restorefile);
        $arr = $tar->listContent();
        for($i = 0; $i <count($arr); $i++){
                if($arr[$i]['filename'] == "dbBackup.sql"){
                        unset($arr[$i]);
                }
        }
        
        $tar->extractList($arr) or die ("Could not extract files!");
        if($conf['doDatabaseBackup']){
                $link = mysql_connect($conf['dbHost'], $conf['dbUser'], $conf['dbPassword']) or die('Could not connect: ' . mysql_error());
                mysql_select_db($conf['dbDatabase']) or die('Could not select database');
                $query = $tar->extractInString("doBackup.sql");
                if($query){
                        $result = mysql_query($query) or die('Query failed: ' . mysql_error());
                }
        }
        echo "Restore complete!";
}//doRestore

function doSQLBackup(){
        global $conf,$link;
        $link = mysql_connect($conf['dbHost'], $conf['dbUser'], $conf['dbPassword']) or die('Could not connect: ' . mysql_error());
        mysql_select_db($conf['dbDatabase']) or die('Could not select database');
        $output = null;
        foreach($conf['dbTables'] as $table){
                $output .= doSQLBackupTable($table);
        }
        return $output;
}//doSQLBackup

function doSQLBackupTable($table){
        global $conf,$link;
        $result .= "# Idut Backup\n";
        $result .= "# Backup of $table \n";
        $result .= "# Backup Date: " . date("d-M-Y") ."\n\n";

        $query = mysql_query("select * from $table");
        $num_fields = @mysql_num_fields($query);

        while($line = mysql_fetch_array($query, MYSQL_ASSOC)){
                $result .= "INSERT INTO ".$table." VALUES(";
                $count = 0;
                foreach ($line as $j => $val) {
                        $val = addslashes($val);
                        $val = ereg_replace("\n","\\n",$val);
                        if (isset($val)){
                                $result .= "'$val'" ;
                        }else{
                                $result .= "''";
                        }
                        $count++;
                        if ($count<($num_fields)) $result .= ",";
                }
                $result .= ");\n";
        }
        return $result . "\n\n\n";
}//doSQLBackupTable

echo '<br/><br/>Powered by <a href="http://www.idut.co.uk">Idut Backup</a> v1.0';
?>
        
