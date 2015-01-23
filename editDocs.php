<?php

	echo "MAGRATHEA DOCUMENTATION PARSER\n\n";
	$docFolder = null;
	$outFolder = null;

	for($i=0; $i<count($argv)-1;$i++){
		switch($argv[$i]){
			case "-s":
				$i++;
				$docFolder = $argv[$i];
				break;
			case "-o":
				$i++;
				$outFolder = $argv[$i];
				break;
			default;
		}
	}

	if(empty($docFolder)){
		die("-s argument is invalid\n\n");
	}

	if(empty($outFolder)){
		die("-o argument is invalid\n\n");
	}

	$docFolder = __DIR__."/".$docFolder."/";
	$outFolder = __DIR__."/".$outFolder."/";
	echo "docFolder: ".$docFolder."\n";
	echo "outFolder: ".$outFolder."\n";
	echo "\n\n";

	$htmls = array();
	if( $handle = opendir($docFolder) ){
		while (false !== ($file = readdir($handle))) {
			$filename = explode('.', $file);
			$ext = array_pop($filename);
			if(empty($ext)) continue;
			$ext = strtolower($ext);
			if($ext == "html"){
				array_push($htmls, $file);
			}
		}
		closedir($handle);
	}

	foreach ($htmls as $html) {
		echo "opening and parsing ".$html."...\n";
		$htmlParts = explode(".", $html);
		$code = file_get_contents($docFolder.$html);
		$code = stripHTML($code);
		$code = changeUrls($code);
		file_put_contents($outFolder.implode(".", $htmlParts).".php", $code);
	}

	function stripHTML($code){
		$code = preg_replace("/<!DOCTYPE html>(.*?)<body>/is", "<?php include('inc/header.php'); ?>", $code);
		$code = preg_replace("/<div id=\"navigation\" class=\"navbar navbar-fixed-top\">(.*?)<div id=\"left\">/is", "<div id=\"left\">", $code);
		$code = preg_replace("/<div id=\"footer\">(.*?)<\/html>/is", "<?php include('inc/footer.php'); ?>", $code);
		$code = preg_replace("/<form id=\"search\" class=\"form-search\">(.*?)<\/form>/is", "", $code);
		return $code;
	}

	function changeUrls($code){
		$code = str_replace('.html"', '.html.php"', $code);
		$code = str_replace('.html#', '.html.php#', $code);
		return $code;
	}

?>
