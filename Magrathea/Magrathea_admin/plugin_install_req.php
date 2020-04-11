<?php

require ("admin_load.php");

$plugin = $_GET["plugin"];

$magrathea_path = MagratheaConfig::Instance()->GetMagratheaPath()."/plugins/".$plugin;
$site_path = MagratheaConfig::Instance()->GetConfigFromDefault("site_path")."/plugins";

if(!is_dir($magrathea_path)){
  ?>
    Error installing plugin!<br/>
    It seems that source path is incorrect<br/>
    [path: <?=$magrathea_path?>]
  <?php
  die;
}

if(!is_writable($site_path)){
  ?>
    Error installing plugin!<br/>
    It seems that destination path is incorrect or you don't have permissions<br/>
    [path: <?=$site_path?>]

    <br/><br/>
    <hr/>
    <a href='?call=bootup'>[New setup?]</a>
    <hr/>
    <br/><br/><br/><br/>
  <?php
  die;
}

$site_path .= "/".$plugin;

function rrmdir($dir) {
  if (is_dir($dir)) {
    $files = scandir($dir);
    foreach ($files as $file)
    if ($file != "." && $file != "..") rrmdir("$dir/$file");
    rmdir($dir);
  }
  else if (file_exists($dir)) unlink($dir);
}

// copies files and non-empty directories
function rcopy($src, $dst) {
  if (file_exists($dst)) rrmdir($dst);
  if (is_dir($src)) {
    mkdir($dst);
    $files = scandir($src);
    foreach ($files as $file)
    if ($file != "." && $file != "..") rcopy("$src/$file", "$dst/$file");
  }
  else if (file_exists($src)) copy($src, $dst);
}

//echo "false";

try{
  $cmd = "copying: ".$magrathea_path." => ".$site_path;
  // echo "executing... ".$cmd;
  rcopy($magrathea_path, $site_path);
  // removes files and non-empty directories
} catch(Exception $ex) { 
  ?>
    Error installing plugin!<br/>
  <?php
    echo $ex->getMessage();
}

?>
