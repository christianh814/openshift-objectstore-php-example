<?php
/* define('uploaddir', getenv('OPENSHIFT_DATA_DIR')); */
/* $uploaddir = getenv('OPENSHIFT_DATA_DIR'); */
$uploaddir = getenv('OPENSHIFT_REPO_DIR');
$gohome = getenv('OPENSHIFT_APP_DNS');
/* $uploaddir = './uploads/'; */
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

echo "<p>";

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
  echo "File has been successfully uploaded.\n";
  } else {
     echo "Upload failed";
     }

     echo "</p>";
     echo '<pre>';
     /*
     echo 'Here is some more debugging info:';
     print_r($_FILES);
     print $uploaddir;
     print $uploadfile;
     */
     echo "<a href=http://" . $gohome . ">Home Page</a>";
     print "</pre>";

?> 
