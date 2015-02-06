<?php
/* $datadir = getenv('OPENSHIFT_DATA_DIR'); */
$datadir = getenv('OPENSHIFT_REPO_DIR');
/* require_once($datadir . "OpenStack.php"); */
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
if ($handle = opendir($datadir)) {
   while (false !== ($file = readdir($handle))) {
          if ($file != "." && $file != ".." && $file != "index.php" && $file != "OpenStack.php" && $file != "upload.php" && $file != ".openshift" && $file != ".vimrc" && $file != ".bash_profile" && $file != ".bash_history") {
            $thelist .= '<li><a href="'.$file.'">'.$file.'</a></li>';
            /* $thelist .= '<li><a href="'. $datadir . $file . '">'.$file.'</a></li>'; */
          }
       }
  closedir($handle);
  }
echo "<h4>List of files:</h4>";
echo "<ul>" . $thelist . "</ul>";
/* My FAILED attempt to do UFO 
$ufoUrl = "http://gluster04.example.net:8080/v1/AUTH_ufo";
$ufoAuthURL = "http://gluster04.example.net:8080/auth/v1.0";
$ufoUsername = "test";
$ufoPassword = "test";

/* Generate Token
$ufoToken = curl_init();
curl_setopt($ufoToken, CURLOPT_HTTPHEADER, array(
	'X-Storage-User:'.$ufoUsername,
	'X-Storage-Pass:'.$ufoPassword,
));
curl_setopt($ufoToken, CURLOPT_URL, $ufoAuthURL);
curl_setopt($ufoToken, CURLOPT_HEADER, TRUE);
curl_setopt($ufoToken, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ufoToken, CURLOPT_TIMEOUT, 30);
$response = curl_exec($ufoToken);
echo $response;
curl_close($ufoToken);
$headers=http_parse_headers($response);
$token = $headers['X-Auth-Token'];
/* List containers
$containers = curl_init();
curl_setopt($containers, CURLOPT_HTTPHEADER, array(
	'X-Auth-Token'.$token,
	'Content-Length:0',
));
curl_setopt($containers, CURLOPT_URL, $ufoUrl);
curl_setopt($containers, CURLOPT_HEADER, TRUE);
curl_setopt($containers, CURLOPT_RETURNTRANSFER, true);
curl_setopt($containers, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ufoToken, CURLOPT_TIMEOUT, 30);
$response = curl_exec($containers);
echo $response;
$headers=http_parse_headers($response);
curl_close($containers);
*/
?> 
