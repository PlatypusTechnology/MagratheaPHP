<?php

/**
 * Magrathea class for logging anything
 * The log will be created in *logs* folder in the root of the project (same dir level as *app*)
 * By default, the message is written with a timestamp before it.
 * 		- For *Log* function, the default file is saved with a timestamp in the name
 * 		- For *LogError* function, by default, all the data is saved in a same file called *log_error.txt*
 */
class MagratheaLogger {

	/**
	 * Logs a message - any message
	 * @param 	string 		$logThis 	message to be logged
	 * @param 	string 		$logFile 	file name that should be written
	 * @throws  Exception If path is not writablle
	 */
	public static function Log($logThis, $logFile=null){
		if( is_a($logThis, "MagratheaConfigException") )
			die("config not properly set!");
		$path = MagratheaConfig::Instance()->GetConfigFromDefault("site_path")."/../logs/";
		if(empty($logFile)) $logFile = "log_".@date("Ym").".txt";
		$date = @date("Y-m-d h:i:s");
		$line = "[".$date."] = ".$logThis."\n\n";
		$file = $path.$logFile;
		if(!is_writable($path)){
			$message = "error trying to save file at [".$path."] - confirm permission for writing";
			throw new Exception($message);
			return;
		}
		file_put_contents($file, $line, FILE_APPEND | LOCK_EX);
	}
	/**
	 * Logs an error
	 * @param 	string	 	$logThis 	error to be logged
	 * @param 	string 		$logFile 	file name that should be written
	 * @throws  Exception If path is not writablle
	 */
	public static function LogError($error, $filename=null){
		$path = MagratheaConfig::Instance()->GetConfigFromDefault("site_path")."/../logs/";
		if(empty($filename)) $filename = "log_error";
		$date = @date("Y-m-d_his");
		$filename .= $date.".txt";
		$line = "[".$date."] = ".$logThis."\n\n";
		$file = $path.$filename;
		if(!is_writable($path)){
			throw new Exception("error trying to save file at [".$path."] - confirm permission for writing");
			return;
		}
		file_put_contents($file, $line, FILE_APPEND | LOCK_EX);
	}
}

?>