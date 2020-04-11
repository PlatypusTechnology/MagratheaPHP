<?php

	@$actualTest = $_GET["test"];

	$sitePath = MagratheaConfig::Instance()->GetFromDefault("site_path");
	$sPath = explode("/", $sitePath);
	array_pop($sPath);
	$sitePath = implode("/", $sPath);
	$testFolder = $sitePath."/Tests";

	if(empty($actualTest)){
		echo '<ul class="nav nav-list menu_sublist">';
		if($handle = @opendir($testFolder)){
			$testFiles = array();
			while (false !== ($file = readdir($handle))) {
				if($file[0] == "_") continue;
				$filename = explode('.', $file);
				$ext = array_pop($filename);
				if(empty($ext)) continue;
				$ext = strtolower($ext);
				if($ext == "php"){
					array_push($testFiles, $file);
				}
			}
			sort($testFiles);
			closedir($handle);
			if(count($testFiles) == 0){
				echo '<li><a><i class="fa fa-exclamation-triangle"></i> No tests found</a></li>';
			}
			foreach ($testFiles as $file) {
				echo '<li><a href="'.$file.'"><i class="fa fa-chevron-right icon_light"></i> '.$file.'</a></li>';
			}
		} else {
			echo '<li><a><i class="fa fa-exclamation-triangle"></i> ERROR! <br/>Tests folder setup missed! <br/>'.
				'test folder: <br/>[...'.substr($sitePath, -18).'/<b>Tests</b>]</a></li>';
		}
		echo '</ul>';
	} else {
		require_once(MagratheaConfig::Instance()->GetMagratheaPath()."/libs/simpletest/autorun.php");
		require_once(MagratheaConfig::Instance()->GetMagratheaPath()."/libs/simpletest/web_tester.php");
		SimpleTest::prefer(new TextReporter());
		include $testFolder."/".$actualTest;
	}

?>