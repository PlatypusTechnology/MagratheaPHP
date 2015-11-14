<?php

	require ("admin_load.php");

	$host = $_POST["host"];
	$name = $_POST["name"];
	$user = $_POST["user"];
	$pass = $_POST["pass"];

	$success = false;
	try {
		$db = MagratheaDatabase::Instance();
		$magdb->SetConnection($host, $name, $user, $pass);
		$success = $magdb->OpenConnectionPlease();
		$magdb->CloseConnectionThanks();
	} catch(Exception $ex){
		$success = $ex->getMessage();
	}

	if($success === true){
		?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert" type="button">×</button>
				<strong>There and back again</strong><br/>
				Yeap... we tried to connect at <?=$host?> using the configuration above and... success!
			</div>
		<?php
	} else {
		?>
			<div class="alert alert-error">
				<button class="close" data-dismiss="alert" type="button">×</button>
				<strong>What have you done!?</strong></br/>
				No! No!<br/>
				"<?=$success?>"...<br/>
				Fix the connection above, man, otherwise nothing will ever work!
			</div>
		<?php
	}


?>