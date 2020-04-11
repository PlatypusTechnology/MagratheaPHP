<?php

	$step = $_GET["step"];
	echo "<div class='tab-content tab_content_light'>";
	switch($step){
		case "create_dirs":
			createDirInApps("Models", false);
			createDirInApps("Views", false);
			createDirInApps("javascript");
			createDirInApps("style");
		break;
		case "create_admin":
			$admin_folder = $_GET["admin"];
			createDirInApps($admin_folder, false);
			echo "Copying admin files...<br/>";
//			shell_exec("cp -r layout/phoenix/ ../app/".$admin_folder."/");
			echo "<div class='alert'>I really hope all the files are there... But I recommend you to take a look ;D</div>";
		break;
		case "set_config":
			echo "Saving config files...<br/>";

			$magrathea_path = __DIR__;
			$magrathea_path = trim($magrathea_path);
			$this_path = explode("/", $magrathea_path);
			array_pop($this_path);
			$site_path = implode("/", $this_path)."/";

			$magrathea_path .= "/";
			require ($magrathea_path."Exceptions.class.php");
			require ($magrathea_path."Config.class.php");
			
			$mconfig = new MagratheaConfig();
			$mconfig->setFile("/configs/magrathea.conf");
			$configs = $mconfig->getConfig();

			date_default_timezone_set( $configs["general"]["time_zone"] );
			$env = $configs["general"]["use_environment"];
			$configs[$env]["site_path"] = $site_path;
			$configs[$env]["magrathea_path"] = $magrathea_path;

			$mconfig->setConfig($configs);
			if( !$mconfig->saveFile(true) ){ 
				?>
				<div class="alert alert-error">
					<button class="close" data-dismiss="alert" type="button">x</button>
					<strong>Shit... error creating coniguration file!</strong><br/>
					Could not create object config file. Please, be sure that PHP can write in the folder "Magrathea/configs/"...
				</div>
				<?
				die;
			}

			echo "<div class='alert alert-info'>I really hope all the files are there... But I recommend you to take a look ;D</div>";
		break;
		default:
			echo "Oh, shit! <br/> Magrathea Install had an error somewhere... <br/>";
	}
	echo "</div>";
	sleep(2);


	function createDirInApps($dir_name, $writable = true){
		echo "Creating '".$dir_name."':<br/>";
		$path = "../app/".$dir_name;
		if( is_dir($path) ){
			echo "<div class='alert alert-info'>Directory '".$dir_name."' already exists!</div>";
			if( !is_writable($path) && $writable){
				echo "<div class='alert'>Hey! Hey! Directory '".$dir_name."' should be writable!</div>";
			}
		} else {
			if( mkdir($path, 0777) ){
				echo "<div class='alert alert-success'>Directory '".$dir_name."' successfully created!</div>";
			} else {
				echo "<div class='alert alert-error'>Error creating directory '".$dir_name."'!</div>";
			}
		}
	}

?>