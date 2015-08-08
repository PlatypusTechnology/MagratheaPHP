<?php
	$basename = basename($_SERVER['SCRIPT_FILENAME']);
?>

<script type="text/javascript">

function loadCoder(){
	history.replaceState({}, "Magrathea Admin - Config", "<?=$basename?>?area=coder");
	$.ajax({
		url: "?magpage=load_coder.php",
		success: function(data){
			$("#main_content").html(data);
			$("#pageTitle").html("Let's code!");
			scrollToTop();
		}
	});
}

function loadTable(table_name){
	history.replaceState({}, "Magrathea Admin - Config", "<?=$basename?>?area=table"+table_name);
	$.ajax({
		url: "?magpage=load_table.php",
		type: "POST",
		data: { 
			table: table_name
		}, 
		success: function(data){
			$("#main_content").html(data);
			$("#pageTitle").html("Table: "+table_name);
			scrollToTop();
		}
	});
}

function loadTableData(table_name){
	history.replaceState({}, "Magrathea Admin - Config", "<?=$basename?>?area=tabledata"+table_name);
	$.ajax({
		url: "?magpage=load_tableData.php",
		type: "POST",
		data: { 
			table: table_name
		}, 
		success: function(data){
			$("#main_content").html(data);
			$("#pageTitle").html("Table: "+table_name);
			scrollToTop();
		}
	});
}


function loadObject(obj_name){
	history.replaceState({}, "Magrathea Admin - Config", "<?=$basename?>?area=obj"+obj_name);
	$.ajax({
		url: "?magpage=load_object.php",
		type: "POST",
		data: { 
			object: obj_name
		}, 
		success: function(data){
			$("#main_content").html(data);
			$("#pageTitle").html("Object: "+obj_name);
			scrollToTop();
		}
	});
}

function loadDatabaseManager(){
	history.replaceState({}, "Magrathea Admin - Config", "<?=$basename?>?area=migration");
	$.ajax({
		url: "?magpage=load_migration.php",
		success: function(data){
			$("#main_content").html(data);
			$("#pageTitle").html("Database");
			scrollToTop();
		}
	});
}


function loadConfig(){
	history.replaceState({}, "Magrathea Admin - Config", "<?=$basename?>?area=config");
	$.ajax({
		url: "?magpage=load_configuration.php",
		success: function(data){
			$("#main_content").html(data);
			$("#pageTitle").html("Magrathea Configuration");
			scrollToTop();
		}
	});
}
function loadConfigSection(){
	var section = $("#use_environment").val();
	$.ajax({
		url: "?magpage=load_configuration_section.php&section="+section,
		success: function(data){
			$("#LoadConfigSection").html(data);
			scrollToTop();
		}
	});
}

function loadPlugins(){
	history.replaceState({}, "Magrathea Admin - Config", "<?=$basename?>?area=plugins");
	$.ajax({
		url: "?magpage=load_plugins.php",
		success: function(data){
			$("#main_content").html(data);
			$("#pageTitle").html("Plugins");
			scrollToTop();
		}
	});
}

function loadLogs(){
	history.replaceState({}, "Magrathea Admin - Config", "<?=$basename?>?area=logs");
	$.ajax({
		url: "?magpage=load_logs.php",
		success: function(data){
			$("#main_content").html(data);
			$("#pageTitle").html("Logs");
			scrollToTop();
		}
	});
}

function loadValidate(){
	history.replaceState({}, "Magrathea Admin - Config", "<?=$basename?>?area=validate");
	$.ajax({
		url: "?magpage=load_validate.php",
		success: function(data){
			$("#main_content").html(data);
			$("#pageTitle").html("Logs");
			scrollToTop();
		}
	});
}
function loadTests(){
	history.replaceState({}, "Magrathea Admin - Testing...", "<?=$basename?>?area=tests");
	$.ajax({
		url: "?magpage=load_tests.php",
		success: function(data){
			$("#tests_response").html(data);
			$("#tests_response > ul").addClass("nav").addClass("nav-list").addClass("menu_sublist");
			$("#tests_response").find("a").each(function(){
				var url = $(this).attr("href");
				$(this).attr("href", "javascript: loadUnitTest('"+url+"');");
			});
			$("#pageTitle").html("Tests");
			$("#main_content").html("That's it! Keep testing...");
			scrollToTop();
		}
	});
}

function loadUnitTest(test){
	history.replaceState({}, "Magrathea Admin - Test", "<?=$basename?>?area=tests&load="+test);
	$.ajax({
		url: "?magpage=load_tests.php&test="+test,
		success: function(data){
			$("#main_content").html(data);
			$("#main_content h1").html(test);
			$("#pageTitle").html("Testing: " + test);
			scrollToTop();
		}
	});
}

function loadPhpInfo(){
	$.ajax({
		url: "?magpage=load_phpinfo.php",
		success: function(data){
			$("#main_content").html(data);
			$("#pageTitle").html("PHP Info");
			scrollToTop();
		}
	});
}

function createFieldInTable(table_name){
	$.ajax({
		url: "?magpage=add_create_and_update.php",
		type: "POST",
		data: { 
			table: table_name
		}, 
		success: function(data){
			loadTable(table_name);
			scrollToTop();
		}
	});
}

function createObject(){
	$.post("?magpage=create_object.php", 
		$("#form_object").serialize(),
		function (data){
			var success = data.substr(0, 12);
			$("#object_result").html(data);
			loadMenu(".tables");
			scrollToTop();
		}
	);
}

function saveObject(){
	$.post("?magpage=save_object.php", 
		$("#form_object").serialize(),
		function (data){
			var success = data.substr(0, 12);
			$("#object_result").html(data);
			scrollToTop();
		}
	);
}

function saveConfig(specific){
	var config_data = null;
	if(specific){
		config_data = $("#specific_config").serialize();
	} else {
		config_data = $("#general_config").serialize();
	}
	console.info(config_data);
	$.ajax({
		type: "POST",
		url: "?magpage=save_configuration.php",
		data: config_data,
		success: function(data){
			var success_var = data.substr(0, 12);
//			console.info(success_var);
			$("#config_result").html(data);
			scrollToTop();
		}
	});
}

function loadMenu(clickhere){
	$.ajax({
		url: "?magpage=menu.php",
		success: function(data){
			$("#main_menu_div").html(data);
			if( clickhere ){
				$(clickhere).click();
			}
			$("#warning_objexists_bt").click();
			scrollToTop();
		}
	});
}

</script>