<script type="text/javascript">

function loadCoder(){
	history.replaceState({}, "Magrathea Admin - Config", "admin.php?area=coder");
	$.ajax({
		url: "?page=load_coder.php",
		success: function(data){
			$("#main_content").html(data);
			$("#pageTitle").html("Let's code!");
			scrollToTop();
		}
	});
}

function loadTable(table_name){
	history.replaceState({}, "Magrathea Admin - Config", "admin.php?area=table"+table_name);
	$.ajax({
		url: "?page=load_table.php",
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
	history.replaceState({}, "Magrathea Admin - Config", "admin.php?area=tabledata"+table_name);
	$.ajax({
		url: "?page=load_tableData.php",
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
	history.replaceState({}, "Magrathea Admin - Config", "admin.php?area=obj"+obj_name);
	$.ajax({
		url: "?page=load_object.php",
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
	history.replaceState({}, "Magrathea Admin - Config", "admin.php?area=migration");
	$.ajax({
		url: "?page=load_migration.php",
		success: function(data){
			$("#main_content").html(data);
			$("#pageTitle").html("Database");
			scrollToTop();
		}
	});
}


function loadConfig(){
	history.replaceState({}, "Magrathea Admin - Config", "admin.php?area=config");
	$.ajax({
		url: "?page=load_configuration.php",
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
		url: "?page=load_configuration_section.php&section="+section,
		success: function(data){
			$("#LoadConfigSection").html(data);
			scrollToTop();
		}
	});
}

function loadPlugins(){
	history.replaceState({}, "Magrathea Admin - Config", "admin.php?area=plugins");
	$.ajax({
		url: "?page=load_plugins.php",
		success: function(data){
			$("#main_content").html(data);
			$("#pageTitle").html("Plugins");
			scrollToTop();
		}
	});
}


function loadTests(){
	history.replaceState({}, "Magrathea Admin - Testing...", "admin.php?area=tests");
	$.ajax({
		url: "?page=load_tests.php",
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
	history.replaceState({}, "Magrathea Admin - Test", "admin.php?area=tests&load="+test);
	$.ajax({
		url: "?page=load_tests.php&test="+test,
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
		url: "?page=load_phpinfo.php",
		success: function(data){
			$("#main_content").html(data);
			$("#pageTitle").html("PHP Info");
			scrollToTop();
		}
	});
}

function createFieldInTable(table_name){
	$.ajax({
		url: "?page=add_create_and_update.php",
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
	$.post("?page=create_object.php", 
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
	$.post("?page=save_object.php", 
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
		url: "?page=save_configuration.php",
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
		url: "?page=menu.php",
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