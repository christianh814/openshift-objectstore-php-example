<?php
include 'config.php';
include 'ufo.php';

echo "<p>";

/* If the file has been uploaded successfully then put it on UFO as well */

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
  echo "File has been successfully uploaded.\n";
  $putfile = $ufocontainer . '/' . basename($uploadfile);
  ob_start($uploadfile);
  $filelen = ob_get_length();
  shell_exec("curl -s -X PUT -H \"X-Auth-Token:$ufotoken\" $putfile -T $uploadfile > /dev/null 2>&1");
  echo '<br>';
  } else {
     echo "Upload failed";
     }

     echo "</p>";
     echo '<pre>';
     echo "<a href=http://" . $gohome . ">Home Page</a>";
     print "</pre>";

?> 
