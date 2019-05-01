<?php
  #######################################################
  # Server Side BackUp © Alessandro Marinuzzi [Alecos]  #
  # Server Side BackUp - Version 1.9 - 01/01/2019 - GPL #
  # Web: https://www.alecos.it - Mail: alecos@alecos.it #
  #######################################################
  @ini_set('default_charset', 'UTF-8');
  include("access.php");
  if (isset($_SERVER['REMOTE_USER'])) {
    $auth = $_SERVER['REMOTE_USER'];
  } elseif (isset($_SERVER['PHP_AUTH_USER'])) {
    $auth = $_SERVER['PHP_AUTH_USER'];
  } elseif (isset($_SERVER['REDIRECT_REMOTE_USER'])) {
    $auth = $_SERVER['REDIRECT_REMOTE_USER'];
  }
  function check_protocol() {
    $isSecure = false;
    if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') {
      $isSecure = true;
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && strtolower($_SERVER['HTTP_X_FORWARDED_SSL']) == 'on') {
      $isSecure = true;
    }
    return $isSecure;
  }
  if (!isset($auth)) {
    $protocol = check_protocol() ? 'https://' : 'http://';
    $absolute = $protocol . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    header("Location: $absolute/error.php");
    exit();
  } else {
    if (!defined('PHP_EOL')) {
      if (strtoupper(substr(PHP_OS,0,3) == 'WIN')) {
        define('PHP_EOL',"\r\n");
      } elseif (strtoupper(substr(PHP_OS,0,3) == 'MAC')) {
        define('PHP_EOL',"\r");
      } elseif (strtoupper(substr(PHP_OS,0,3) == 'DAR')) {
        define('PHP_EOL',"\n");
      } else {
        define('PHP_EOL',"\n");
      }
    }
    $url = $_SERVER['QUERY_STRING'];
    $out = array();
    parse_str($url, $out);
    if (isset($out['delete']) || (!empty($out['delete']))) {
      $delete = $out['delete'];
    }
    if ((isset($delete)) && (!empty($delete))) {
      $delete = htmlspecialchars($delete, ENT_QUOTES, 'UTF-8');
      $delete = str_replace("\0", "", $delete);
      $delete = basename($delete);
      if ((file_exists($delete)) && ($delete == "config.php")) {
        @unlink($delete);
        @unlink("dat/exclude.dat");
        $protocol = check_protocol() ? 'https://' : 'http://';
        $absolute = $protocol . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("Location: $absolute/exclude.php");
      }
    }
?>
<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Alessandro Marinuzzi [Alecos]">
  <meta name="generator" content="Notepad2">
  <meta name="pragma" content="no-cache">
  <meta name="robots" content="noindex, nofollow">
  <title>SSBackUp &bull; Server Side BackUp</title>
  <link rel="stylesheet" type="text/css" href="css/backup.css">
  <script>
  function SetAllCheckBoxes(FormName, FieldName, CheckValue) {
    if (!document.forms[FormName]) {
      return;
    }
    var objCheckBoxes = document.forms[FormName].elements[FieldName];
    if (!objCheckBoxes) {
      return;
    }
    var countCheckBoxes = objCheckBoxes.length;
    if (!countCheckBoxes) {
      objCheckBoxes.checked = CheckValue;
    } else {
      for (var i = 0; i < countCheckBoxes; i++) {
        objCheckBoxes[i].checked = CheckValue;
      }
    }
  }
  </script>
</head>

<body>

<div class="mainbox">
  <div class="box1">
    <a class="link tooltip" href="index.php"><span class="tip">Go here to perform backups</span>BackUp Section</a> :: <a class="link tooltip" href="test.php"><span class="tip">Go here to perform some tests</span>Test Section</a> :: <a class="link tooltip" href="format.php"><span class="tip">Go here to set the date format</span>Config Section</a> :: <a class="link tooltip" href="exclude.php"><span class="tip">Reload this page to see the changes</span>Reload Page</a>
  </div>
  <div class="cleardiv"></div>
  <div class="box1">
    <span class="title">Server Side BackUp - Exclude Folders</span>
  </div>
  <div class="cleardiv"></div>
  <div class="box6">
    <form action="exclude.php" method="post" name="checkbox_form">
<?php
      if (file_exists("dat/exclude.dat")) {
        $result_list = array();
        $result_list = explode(", ", file_get_contents("dat/exclude.dat"));
      } else {
        $result_list = array("Not Set");
      }
      foreach (glob($_SERVER['DOCUMENT_ROOT'] .'/*', GLOB_ONLYDIR) as $directory) {
        $directory = basename($directory);
        if (in_array($directory, $result_list)) {
          echo "      <input class=\"checkbox\" type=\"checkbox\" name=\"dir[]\" value=\"" . $directory . "\" checked><span class=\"checkbox_name\">" . $directory . "</span><br>" . PHP_EOL . "      <div class=\"cleardiv\"></div>" . PHP_EOL;
        } else {
          echo "      <input class=\"checkbox\" type=\"checkbox\" name=\"dir[]\" value=\"" . $directory . "\"><span class=\"checkbox_name\">" . $directory . "</span><br>" . PHP_EOL . "      <div class=\"cleardiv\"></div>" . PHP_EOL;
        }
      }
      ?>
      <br>
      <input class="select_dir" type="button" onclick="SetAllCheckBoxes('checkbox_form', 'dir[]', true);" value="Select All">
      <input class="select_dir" type="button" onclick="SetAllCheckBoxes('checkbox_form', 'dir[]', false);" value="Select None">
      <br>
      <input class="exclude" type="submit" name="save" value="Save Preferences">
    </form>
  </div>
  <div class="cleardiv"></div>
  <div class="box7">
    <?php
    $success = FALSE;
    if (!is_dir("dat")) {
      mkdir("dat");
      chmod("dat", 0755);
    }
    $exclude = isset($_POST['dir']) ? $_POST['dir'] : array();
    if (isset($_POST['save']) && !empty($_POST['dir'])) {
      $dirs_exclude = '';
      $list_exclude = '';
      $file_exclude = 'config.php';
      $save_exclude = 'dat/exclude.dat';
      foreach ($exclude as $excluded) {
        $dirs_exclude .= ' --exclude=\'$root/' . $excluded . '/*\'';
        $dirs_exclude .= ' --exclude=\'$root/' . $excluded . '\'';
        $list_exclude .= "$excluded, ";
      }
      file_put_contents($file_exclude, '<?php $root = realpath($_SERVER[\'DOCUMENT_ROOT\']); $exclude = "');
      file_put_contents($file_exclude, $dirs_exclude, FILE_APPEND);
      file_put_contents($file_exclude, ' ', FILE_APPEND);
      file_put_contents($file_exclude, '"; echo $exclude; ?>', FILE_APPEND);
      file_put_contents($save_exclude, rtrim($list_exclude, ', '));
      chmod($file_exclude, 0755);
      chmod($save_exclude, 0755);
      $success = TRUE;
    } elseif (file_exists(basename("config.php"))) {
      echo "<span class=\"check_done\">View this configuration: <a class=\"link tooltip\" href=\"config.php\" target=\"_blank\"><span class=\"tip\">You can view this configuration</span>config.php</a></span><br><br>" . PHP_EOL;
      echo "    <span class=\"check_done\">Delete this configuration: <a class=\"link tooltip\" href=\"exclude.php?delete=config.php\" onclick=\"return confirm('Delete config.php?');\"><span class=\"tip\">You can delete this configuration</span>config.php</a></span><br><br>" . PHP_EOL;
    } else {
      echo "<span class=\"check_wait\">Nothing selected! New preferences not saved yet!</span><br><br>" . PHP_EOL;
    }
    if ($success == TRUE) {
      echo "<span class=\"check_done\">Saved preferences to file with success!</span><br><br>" . PHP_EOL;
      echo "    <span class=\"check_done\">Excluded from BackUp the following folders:<br><br><span class=\"check_out\">" . rtrim($list_exclude, ', ') . "</span></span><br><br>" . PHP_EOL;
    }
  }
  ?>
  </div>
  <div class="cleardiv"></div>
</div>

</body>

</html>