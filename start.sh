#!/bin/bash
clear

echo -e "MAGRATHEA STARTER \n"
echo -e "by Paulo Henrique Martins - Platypus Technology \n\n"
echo -e "Creating base structure data for a Magrathea Application\n"
echo -e "Let's go!\n\n"
sleep 1

echo -e "Structure ********\n"
mkdir configs
chmod 777 configs
touch configs/.gitkeep
touch configs/index.html
echo -e "\tconfig = ok\n"

mkdir logs
chmod 777 logs
touch logs/.gitkeep
echo -e "\tlogs = ok\n"

mkdir Tests
touch Tests/.gitkeep
echo -e "\ttests = ok\n"

mkdir db
echo -e "\tdb = ok\n"

mkdir app
cd app
echo -e "\tapp = ok\n"

mkdir inc
echo -e "\tinc = ok\n"

mkdir Models
chmod 777 Models
mkdir Models/Base
chmod 777 Models/Base
touch Models/Base/.gitkeep
echo -e "\tModels = ok\n"

mkdir Controls
echo -e "\tControls = ok\n"

mkdir Static
echo -e "\tStatic = ok\n"

mkdir javascript
mkdir javascript/_compressed
chmod 777 javascript/_compressed
touch javascript/_compressed/.gitkeep
echo -e "\tjavascript = ok\n"

mkdir css
mkdir css/_compressed
chmod 777 css/_compressed
touch css/_compressed/.gitkeep
echo -e "\tcss = ok\n"

mkdir plugins
chmod 777 plugins
touch plugins/.gitkeep
echo -e "\tplugins = ok\n"

mkdir Views
mkdir Views/_cache
chmod 777 Views/_cache
touch Views/_cache/.gitkeep
mkdir Views/_compiled
chmod 777 Views/_compiled
touch Views/_compiled/.gitkeep
mkdir Views/_configs
touch Views/_configs/site.conf
echo -e "\tViews = ok\n"

mkdir images
mkdir images/medias
mkdir images/medias/_generated
chmod 777 images/medias/_generated
chmod 777 images/medias
touch chmod 777 images/medias/_generated/.gitkeep
echo -e "\tImages = ok\n"

cd ..
echo -e "\nWriting files ********\n"
sleep 1

echo -e "\tConfig ==="
cat <<EOF >configs/magrathea.conf.sample
[general]
  use_environment = "default"
  time_zone = "America/Sao_Paulo"
 
[default]
  db_host = "127.0.0.1"
  db_name = "teste"
  db_user = "test_user"
  db_pass = "test_pass"
  site_path = "/Users/Sites/mywebsite/app"
  magrathea_path = "/Users/Sites/mywebsite/Magrathea"
  compress_js = "false"
  compress_css = "false"
  time_zone = "America/Sao_Paulo"
  testThis = "test_ok"
 
[another_config]
  db_host = "127.0.0.2"
  db_name = "production"
  db_user = "production_user"
  db_pass = "production_pass"
  site_path = "/etc/mywebsite/app"
  magrathea_path = "/etc/mywebsite/Magrathea"
  compress_js = "true"
  compress_css = "true"
  time_zone = "America/Sao_Paulo"
  testThis = "test_not_ok"
      
EOF
echo -e "\tconfigs/magrathea.conf.sample\n"

echo -e "\t.htaccess ==="
cat <<EOF >app/.htaccess
RewriteEngine On
 
<IfModule mod_rewrite.c>
  RewriteEngine On
  RewriteBase /
 
  # Do not do anything for already existing files and folders
  RewriteCond %{REQUEST_FILENAME} -f [OR]
  RewriteCond %{REQUEST_FILENAME} -d
  RewriteRule .+ - [L]
 
  #Respect this rules for redirecting:
  RewriteRule ^([a-zA-Z0-9_-]+)/([a-zA-Z0-9_-]+)/(.*)\$ index.php?magrathea_control=\$1&magrathea_action=\$2&magrathea_params=\$3 [QSA,L]
  RewriteRule ^([a-zA-Z0-9_-]+)/(.*)\$ index.php?magrathea_control=\$1&magrathea_action=\$2 [QSA,L]
  RewriteRule ^(.*)\$ index.php?magrathea_control=\$1 [QSA,L]
 
</IfModule>
EOF
echo -e "\tapp/.htaccess\n"

echo -e "\tPHP config ==="
cat <<EOF >app/inc/config.php.sample
<?php

  // set the path of magrathea framework (this way is possible to have only one instance of the framework for multiple projects)
  \$magrathea_path = "/Users/username/Sites/Magrathea";
  // set the path of your site (you can set this manually as well)
  \$site_path = __DIR__."/../..";

?>
EOF
echo -e "\tapp/inc/config.php.sample\n"

echo -e "\tPHP global ==="
cat <<EOF >app/inc/global.php
<?php

  session_start();
//  error_reporting(1);

  \$path = realpath(__DIR__.'/../../lib');
  set_include_path(get_include_path().PATH_SEPARATOR.\$path);

  include("config.php");
 
  // looooooaaaadddiiiiiinnnnnnggggg.....
  include(\$magrathea_path."/LOAD.php");

  // debugging settings:
  // options: dev; debug; log; none;
  MagratheaDebugger::Instance()->SetType(MagratheaDebugger::LOG)->LogQueries(false);

  \$Smarty = new Smarty();
  \$Smarty->template_dir = \$site_path."/app/Views/";
  \$Smarty->compile_dir  = \$site_path."/app/Views/_compiled";
  \$Smarty->config_dir   = \$site_path."/app/Views/_configs";
  \$Smarty->cache_dir    = \$site_path."/app/Views/_cache";
  \$Smarty->configLoad("site.conf");
  
  // initialize the MagratheaView and sets it to Smarty 
  \$Smarty->assign("View", MagratheaView::Instance());
 
  // for printing the paths of your css and javascript (that will be included in the index.php)
  MagratheaView::Instance()->IsRelativePath(false);

?>
EOF
echo -e "\tapp/inc/global.php\n"

echo -e "\tBase Controller ==="
cat <<EOF >app/Controls/_Controller.php
<?php

class BaseControl extends MagratheaController {

  public static function Go404(){
    global \$Smarty;
    \$Smarty->display("404.html");
    return;
  }

  public static function Kill(){
    global \$Smarty;
    \$Smarty->display("error.html");
    return;
  }

}
?>
EOF
echo -e "\tapp/Controls/_Controller.php\n"

echo -e "\tindex ==="
cat <<EOF >app/index.php
<?php
 
  include("inc/global.php"); 
  MagratheaController::IncludeAllControllers();
  MagratheaModel::IncludeAllModels();
 
 
  // let's include some of Magrathea's awesome plugins:
  // include("plugins/bootstrap/load.php");
 
  try {
    MagratheaView::Instance()
    ->IncludeCSS("css/style.css")
    ->IncludeJavascript("javascript/script.js");
  } catch(Exception \$ex){
    // probably the file does not exists. What to do now?
  }

  // Magrathea Route will get the path to the correct method in the right class:
  MagratheaRoute::Instance()
    ->Route(\$control, \$action, \$params);

  try{
    MagratheaController::Load(\$control, \$action, \$params);
  } catch (Exception \$ex) {
    Debug(\$ex);
    BaseControl::Go404();
  }
 
?>
EOF
echo -e "\tapp/index.php\n"

echo -e "\tindex ==="
cat <<EOF >app/admin.php
<?php
  include("inc/global.php");
  include(\$magrathea_path."/MagratheaAdmin.php"); // \$magrathea_path should already be declared
 
  \$admin = new MagratheaAdmin(); // adds the admin file
  \$admin->Load(); // load!
?>
EOF
echo -e "\tapp/admin.php\n"

echo -e "\ttest-base ==="
cat <<EOF >Tests/app.php
<?php

  SimpleTest::prefer(new TextReporter());
//  include("_MagratheaConfig.php");

?>
EOF
echo -e "\tTests/app.php\n"

echo -e "\t.gitignore ==="
cat <<EOF >.gitignore
configs/magrathea.conf
logs
app/inc/config.php
app/images/medias
app/Views/_cache
app/Views/_compiled
app/javascript/_compressed
app/css/_compressed
app/plugins
*_compressed.js
*_compressed.css
*.magratheaDB
EOF
echo -e "\t.gitignore\n"

echo -e "\nDONE!"
echo -e "\nThanks for using Magrathea!"


