<?php

class MagratheaLogger {

	public static function Log($logThis, $logFile){
		$path = MagratheaConfig::Instance()->GetConfigFromDefault("site_path")."../logs/";
		if(empty($logFile)) $logFile = "log_".@date("Ym").".txt";
		$date = @date("Y-m-d h:i:s");
		$line = "[".$date."] = ".$logThis."\n\n";
		$file = $path.$logFile;
		if(!is_writable($path)){
			throw new MagratheaException("error trying to save file at ".$path." - confirm permission for writing");
			return;
		}
		file_put_contents($file, $line, FILE_APPEND | LOCK_EX);
	}
	public static function LogError($error, $filename){
		$path = MagratheaConfig::Instance()->GetConfigFromDefault("site_path")."../logs/";
		if(empty($filename)) $filename = "log_error";
		$date = @date("Y-m-d_his");
		$filename .= $date.".txt";
		$file = $path.$filename;
		if(!is_writable($path)){
			throw new MagratheaException("error trying to save file at ".$path." - confirm permission for writing");
			return;
		}
		throw new MagratheaException("error trying to save file at ".$path." - confirm permission for writing");
	}

}

?>