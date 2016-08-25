<?php

require ("admin_load.php");

$plugin = $_POST["plugin_folder"];
$action = $_POST["action"];

$magrathea_path = MagratheaConfig::Instance()->GetConfigFromDefault("magrathea_path")."/plugins/".$plugin;
$site_path = realpath(MagratheaConfig::Instance()->GetConfigFromDefault("site_path")."/../plugins");

if(!is_dir($magrathea_path)){
  echo "<!--false-->";
  ?>
  <div class="alert alert-error">
    <button class="close" data-dismiss="alert" type="button">×</button>
    <strong>Oh noes =(</strong></br/>
    Error installing plugin!<br/>
    It seems that source path is incorrect<br/>
    [path: <?=$magrathea_path?>]
  </div>
  <?php
}

if(!is_writable($site_path)){
  echo "<!--false-->";
  ?>
  <div class="alert alert-error">
    <button class="close" data-dismiss="alert" type="button">×</button>
    <strong>Oh noes =(</strong></br/>
    Error installing plugin!<br/>
    It seems that destination path is incorrect or you don't have permissions<br/>
    [path: <?=$site_path?>]
  </div>
  <?php
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

  if($action == "remove"){
  //  echo "deleting... ".$site_path;
    rrmdir($site_path);
  } else {
    $cmd = "copying: ".$magrathea_path." => ".$site_path;
    // echo "executing... ".$cmd;
    rcopy($magrathea_path, $site_path);
  }
  // removes files and non-empty directories
} catch(Exception $ex) { 
  echo "<!--false-->";
}

?>