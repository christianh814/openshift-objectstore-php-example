<?php
/* define('uploaddir', getenv('OPENSHIFT_DATA_DIR')); */
/* $uploaddir = getenv('OPENSHIFT_DATA_DIR'); */
$uploaddir = getenv('OPENSHIFT_REPO_DIR');
$gohome = getenv('OPENSHIFT_APP_DNS');
/* $uploaddir = './uploads/'; */
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

/* CUSTOM VARIABLES - Enter your ObjStore info */

/* EXAMPLES
  $ufouser = "admin";
  $ufovol = "volume";
  $ufopass = "secret";
  $ufoAuthURL = "http://gluster.example.net:8080/auth/v1.0";
  // Note that the "AUTH_volume" part is the name of the volume you specified above with the AUTH_ prefix
  // ALSO note, the "/container" is an already existing container
  $ufocontainer = "http://gluster.example.net:8080/v1/AUTH_volume/container";
  

*/
$ufouser = "";
$ufovol = "";
$ufopass = "";
$ufoAuthURL = "";
$ufocontainer = "";
/* END CUSTOM VARIABLES*/
$ufotoken = shell_exec("curl -s -i -H X-Storage-User:$ufovol:$ufouser -H X-Storage-Pass:$ufopass -k $ufoAuthURL | grep X-Auth-Token | awk -F' ' '{print $2}' ");
$ufoobj = shell_exec("curl -s -X GET -H \"X-Auth-Token:$ufotoken\" $ufocontainer ");
$objects = preg_split('/\s+/', trim($ufoobj));


echo "<p>";

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
  echo "File has been successfully uploaded.\n";
  shell_exec("curl -s -X PUT -H \"X-Auth-Token:$ufotoken\" $ufocontainer/$uploadfile -T $uploadfile ");
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
     /*
     echo 'Here is some more debugging info:';
     print_r($_FILES);
     print $uploaddir;
     print $uploadfile;
     */
     echo "<a href=http://" . $gohome . ">Home Page</a>";
     print "</pre>";

?> 
