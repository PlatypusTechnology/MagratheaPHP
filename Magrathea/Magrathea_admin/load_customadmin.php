<?php

	MagratheaModel::IncludeAllModels();

	@$adminPage = $_GET["custom"];

	$adminFolder = MagratheaConfig::Instance()->GetFromDefault("admin_path");
	if(!$adminFolder) {
		$sitePath = MagratheaConfig::Instance()->GetFromDefault("site_path");
		$sPath = explode("/", $sitePath);
		array_pop($sPath);
		$sitePath = implode("/", $sPath);
		$adminFolder = $sitePath."/Admin";
	}

	if(empty($adminPage)){
		if($handle = @opendir($adminFolder)){
			if(file_exists($adminFolder."/menu.php")){
				include($adminFolder."/menu.php");
			} else {
				echo '<ul><li><a><i class="fa fa-exclamation-triangle"></i> menu.php inside Admin not found</a></li></li>';
			}
			closedir($handle);
		} else {
			echo '<ul><li><a><i class="fa fa-exclamation-triangle"></i> ERROR! <br/>Admin folder setup missed! <br/>'.
				'admin folder: <br/>[...'.substr($sitePath, -18).'/<b>Admin</b>]</a></li></ul>';
		}
	} else {
		include $adminFolder."/".$adminPage;
	}

?>