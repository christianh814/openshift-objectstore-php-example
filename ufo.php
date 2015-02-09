<?php
/* Variables for UFO connection */
$uploaddir = getenv('OPENSHIFT_REPO_DIR');
$gohome = getenv('OPENSHIFT_APP_DNS');
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
$token = shell_exec("curl -s -i -H X-Storage-User:$ufovol:$ufouser -H X-Storage-Pass:$ufopass -k $ufoAuthURL | grep X-Auth-Token | awk -F':' '{print $2}' | tr -d '
' | tr -d ' '");
$ufotoken = str_replace(array('.', ' ', "\n", "\t", "\r"), '', $token);
$ufoobj = shell_exec("curl -s -X GET -H \"X-Auth-Token:$ufotoken\" $ufocontainer");
$objects = preg_split('/\s+/', trim($ufoobj));

?>
