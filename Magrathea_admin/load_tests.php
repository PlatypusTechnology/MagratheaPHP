<?php

	@$actualTest = $_GET["test"];
	if(empty($actualTest)){
		include "../Tests/_frame_menu.html";
	} else {
		include "../Tests/".$actualTest;
	}

?>