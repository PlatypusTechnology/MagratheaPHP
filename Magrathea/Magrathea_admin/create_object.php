<?php

require ("admin_load.php");

	$data = $_POST;

	$object_name = $data["object_name"];
	$table_name = $data["table_name"];

	// validate object name:
	$object_name_lower = strtolower($object_name);
	if( empty($object_name) ){ 
		echo "<!--false-->";
		?>
		<div class="alert alert-error">
			<button class="close" data-dismiss="alert" type="button">×</button>
			<strong>Oh, crap! =(</strong><br/>
			You forgot to tell us the name of the object, boy...
		</div>
		<?
		die;
	} else {
		if( !ctype_alpha ( $object_name ) ){
			echo "<!--false-->";
			?>
			<div class="alert alert-error">
				<button class="close" data-dismiss="alert" type="button">×</button>
				<strong>Ops, you did it wrong! =(</strong></br/>
				An object name must have only chars...
			</div>
			<?
			die;
		} else {
			$keywords = array('__halt_compiler', 'abstract', 'and', 'array', 'as', 'break', 'callable', 'case', 'catch', 'class', 'clone', 'const', 'continue', 'declare', 'default', 'die', 'do', 'echo', 'else', 'elseif', 'empty', 'enddeclare', 'endfor', 'endforeach', 'endif', 'endswitch', 'endwhile', 'eval', 'exit', 'extends', 'final', 'for', 'foreach', 'function', 'global', 'goto', 'if', 'implements', 'include', 'include_once', 'instanceof', 'insteadof', 'interface', 'isset', 'list', 'namespace', 'new', 'or', 'print', 'private', 'protected', 'public', 'require', 'require_once', 'return', 'static', 'switch', 'throw', 'trait', 'try', 'unset', 'use', 'var', 'while', 'xor');
			if( in_array($object_name_lower, $keywords)){
				echo "<!--false-->";
				?>
				<div class="alert alert-error">
					<button class="close" data-dismiss="alert" type="button">×</button>
					<strong>Fuck! Fuck! Fuck!</strong></br/>
					Oh, crap, look at this:<br/>
					"<?=$object_name?>" is a PHP reserved word. It can't be used as object name.<br/>
					Choose another one... =)
				</div>
				<?
				die;
			} else {
				$object_name = ucfirst($object_name);
			}
		}
	}

	$mconfig = new MagratheaConfigFile();
	$filePath = "/../configs/magrathea_objects.conf";
	$mconfig->setPath(MagratheaConfig::Instance()->GetConfigFromDefault("site_path"));
	$mconfig->setFile($filePath);
	if( !$mconfig->createFileIfNotExists() ){
		echo "<!--false-->";
		?>
		<div class="alert alert-error">
			<button class="close" data-dismiss="alert" type="button">×</button>
			<strong>Shit... error creating object!</strong><br/>
			Could not create object config file. Please, be sure that PHP can write in the folder "<?=__DIR__.$filePath?>"...
		</div>
		<?
		die;
	}
	$objdata = $mconfig->getConfig();

	$table_data = array();
	$table_data["table_name"] = $table_name;
	$table_data["db_pk"] = $data["db_pk"];
	$table_data["lazy_load"] = "true";
	
	$fields = $data["fields"];
	foreach( $fields as $f ){
		$f = strtolower($f);
		$table_data[$f."_alias"] = $data["alias_".$f];
		$table_data[$f."_type"] = $data["type_".$f];
	}

	$objdata[$object_name] = $table_data;
	$mconfig->setConfig($objdata);
	if( !$mconfig->Save(true) ){ 
		echo "<!--false-->";
		?>
		<div class="alert alert-error">
			<button class="close" data-dismiss="alert" type="button">×</button>
			<strong>Shit... error creating object!</strong><br/>
			Could not create object config file. Please, be sure that PHP can write in the folder "/configs/"...
		</div>
		<?
		die;
	}

	echo "<!--true--->";

?>
<div class="alert alert-success">
	<button class="close" data-dismiss="alert" type="button">×</button>
	<strong>Yeah, baby!</strong><br/>
	Object was <?=@($data["obj_exists"] ? "updated" : "created")?>.
</div>

