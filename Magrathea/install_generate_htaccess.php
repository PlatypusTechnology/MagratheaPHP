<?php
# generates the htaccess passwd

$user = $_POST["user"];
$pass = $_POST["pass"];
$hash = base64_encode(sha1($pass, true));
$encoded = '{SHA}'.$hash;
echo "<pre>".$user.":".$encoded."</pre>";

?>