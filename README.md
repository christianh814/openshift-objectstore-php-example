# Object Store Uploader

This is a sample OpenShift app that uses an Object Store (GlusterFS Object Store in this case) as storage for files uploaded.

*  I am assuming you have GlusterFS Object Store already set up somewhere
*  You have the AuthURL, Container name, Username, Password

## Installation

Create a (scaled) PHP 5.4 app on openshift
```
rhc create-app -s -a <app name> -t php-5.4  --from-code https://github.com/christianh814/openshift-objectstore-php-example.git
```

## Configuration

Edit the `<app name>/upload.php` file and set the following values

```
$ufouser = ""; 
$ufovol = ""; 
$ufopass = ""; 
$ufoAuthURL = ""; 
$ufocontainer = "";
```

The `<app name>/upload.php` file is commented with examples

After you added this information deploy the changes

```
cd <app name>
git add -A .
git commit -am "added object storage config"
git push
```
