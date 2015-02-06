<?php
include 'config.php';

/* Variables - I did this using "shell_exec" since my php skills are subpar */
$uploaddir = getenv('OPENSHIFT_REPO_DIR');
$gohome = getenv('OPENSHIFT_APP_DNS');
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
$token = shell_exec("curl -s -i -H X-Storage-User:$ufovol:$ufouser -H X-Storage-Pass:$ufopass -k $ufoAuthURL | grep X-Auth-Token | awk -F':' '{print $2}' | tr -d '' | tr -d ' '");
$ufotoken = str_replace(array('.', ' ', "\n", "\t", "\r"), '', $token);
$ufoobj = shell_exec("curl -s -X GET -H \"X-Auth-Token:$ufotoken\" $ufocontainer");
$objects = preg_split('/\s+/', trim($ufoobj));

echo "<p>";

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
  echo "File has been successfully uploaded.\n";
  $putfile = $ufocontainer . '/' . basename($uploadfile);
  ob_start($uploadfile);
  $filelen = ob_get_length();
  shell_exec("curl -s -X PUT -H \"X-Auth-Token:$ufotoken\" $putfile -T $uploadfile > /dev/null 2>&1");
  /* I added this for debugging. Leaving it here Just in case
    echo "curl -s -X PUT -H \"X-Auth-Token:$ufotoken\" $putfile -T $uploadfile";
  */
  echo '<br>';
  foreach ($objects as $cachefile) {
    if (file_exists($cachefile)) {
      shell_exec("true");
    } else {
      shell_exec("curl -O -s -X GET -H \"X-Auth-Token:$ufotoken\" $ufocontainer/$cachefile ");
    }
  }
  } else {
     echo "Upload failed";
     }

     echo "</p>";
     echo '<pre>';
     */
     echo "<a href=http://" . $gohome . ">Home Page</a>";
     print "</pre>";
?> 
