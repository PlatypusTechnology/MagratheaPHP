function loadCoder(){
	$.ajax({
		url: "?page=load_coder.php",
		success: function(data){
			$("#main_content").html(data);
			$("#pageTitle").html("Let's code!");

		}
	});

}

function loadTable(table_name){
	$.ajax({
		url: "?page=load_table.php",
		type: "POST",
		data: { 
			table: table_name
		}, 
		success: function(data){
			$("#main_content").html(data);
			$("#pageTitle").html("Table: "+obj_name);
		}
	});
}

function loadObject(obj_name){
	$.ajax({
		url: "?page=load_object.php",
		type: "POST",
		data: { 
			object: obj_name
		}, 
		success: function(data){
			$("#main_content").html(data);
			$("#pageTitle").html("Object: "+obj_name);
		}
	});
}

function loadConfig(){
	$.ajax({
		url: "?page=load_configuration.php",
		success: function(data){
			$("#main_content").html(data);
			$("#pageTitle").html("Magrathea Configuration");
		}
	});
}

function loadPlugins(){
	$.ajax({
		url: "?page=load_plugins.php",
		success: function(data){
			$("#main_content").html(data);
			$("#pageTitle").html("Plugins");
		}
	});
}


function loadTests(){
	$.ajax({
		url: "?page=load_tests.php",
		success: function(data){
			$("#tests_response").html(data);
			$("#tests_response > ul").addClass("nav").addClass("nav-list").addClass("menu_sublist");
			$("#tests_response").find("a").each(function(){
				var url = $(this).attr("href");
				$(this).attr("href", "javascript: loadUnitTest('"+url+"');");
			});
		}
	});
}
function loadUnitTest(test){
	$.ajax({
		url: "?page=load_tests.php&test="+test,
		success: function(data){
			$("#main_content").html(data);
		}
	});
}

function loadPhpInfo(){
	$.ajax({
		url: "?page=load_phpinfo.php",
		success: function(data){
			$("#main_content").html(data);
			$("#pageTitle").html("PHP Info");
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
		}
	);
}

function saveObject(){
	$.post("?page=save_object.php", 
		$("#form_object").serialize(),
		function (data){
			var success = data.substr(0, 12);
			$("#object_result").html(data);
			$("html, body").animate({ scrollTop: 0 }, "slow");
		}
	);
}

function saveConfig(){
	$.ajax({
		type: "POST",
		url: "?page=save_configuration.php",
		data: $("#general_config").serialize(),
		success: function(data){
			var success_var = data.substr(0, 12);
			console.info(success_var);
			$("#config_result").html(data);
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
			$("html, body").animate({ scrollTop: 0 }, "slow");
		}
	});
}
