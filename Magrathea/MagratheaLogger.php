<?php

class MagratheaLogger {

	public static function Log($logThis){
		$path = MagratheaConfig::Instance()->GetConfigFromDefault("site_path")."../logs/";
		$logFile = "log_".@date("Ym").".txt";
		$date = @date("Y-m-d h:i:s");
		$line = "[".$date."] = ".$logThis."\n\n";
		$file = $path.$logFile;
		file_put_contents($file, $line, FILE_APPEND | LOCK_EX);
	}
	public static function LogError($error, $filename){
		$path = MagratheaConfig::Instance()->GetConfigFromDefault("site_path")."../logs/";
		if(empty($filename)) $filename = "log_error";
		$date = @date("Y-m-d_his");
		$filename .= $date.".txt";
		$file = $path.$filename;
		file_put_contents($file, print_r($error, true), FILE_APPEND | LOCK_EX);
	}

}

?>