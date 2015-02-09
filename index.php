<?php
include 'config.php';
include 'ufo.php';
$datadir = getenv('OPENSHIFT_REPO_DIR');
$uploadform = <<<END
<html>
<body>
<form enctype="multipart/form-data" action="upload.php" method="POST">
    <input type="hidden" name="MAX_FILE_SIZE" value="512000" />
    Upload: <input name="userfile" type="file" />
    <input type="submit" value="Upload File" />
</form>
</body>
</html>
END;
echo $uploadform;

/* If objects aren't present locally, download them */
foreach ($objects as $cachefile) {
  if (file_exists($cachefile)) {
    shell_exec("true");
  } else {
    shell_exec("curl -O -s -X GET -H \"X-Auth-Token:$ufotoken\" $ufocontainer/$cachefile ");
  }   
}

/* Display all file except core application files */
if ($handle = opendir($datadir)) {
   while (false !== ($file = readdir($handle))) {
          /* This is to exclude files from being shown on the screen - probably a better way of doing this */
          if ($file != "." && $file != ".." && $file != "index.php" && $file != "OpenStack.php" && $file != "README.md" && $file != "upload.php" && $file != ".openshift" && $file != ".vimrc" && $file != ".bash_profile" && $file != ".bash_history" && $file != "config.php" && $file != "ufo.php") {
            $thelist .= '<li><a href="'.$file.'">'.$file.'</a></li>';
            /* $thelist .= '<li><a href="'. $datadir . $file . '">'.$file.'</a></li>'; */
          }
       }
  closedir($handle);
  }
echo "<h4>List of files:</h4>";
echo "<ul>" . $thelist . "</ul>";
?> 
