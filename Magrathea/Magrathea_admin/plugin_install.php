<?php

require ("admin_load.php");

$plugin = $_POST["plugin_folder"];
$action = $_POST["action"];

$magrathea_path = MagratheaConfig::Instance()->GetConfigFromDefault("magrathea_path")."plugins/".$plugin;
$site_path = MagratheaConfig::Instance()->GetConfigFromDefault("site_path")."plugins/".$plugin;


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


try{

  if($action == "remove"){
  //  echo "deleting... ".$site_path;
    rrmdir($site_path);
  } else {
    $cmd = "copying: ".$magrathea_path." => ".$site_path;
  //  echo "executing... ".$cmd;
    rcopy($magrathea_path, $site_path);
  }
  // removes files and non-empty directories
} catch(Exception $ex) { 
  echo "false";
}

?>