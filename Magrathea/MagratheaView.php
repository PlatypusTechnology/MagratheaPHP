<?php

#######################################################################################
####
####	MAGRATHEA PHP
####	v. 1.0
####
####	Magrathea by Paulo Henrique Martins
####	Platypus technology
####
#######################################################################################
####
####	View Class
####	All information for the front-end of the system
####	
####	created: 2013-01 by Paulo Martins
####
#######################################################################################

/**
 * Some functions that will help you control the view layer of the project
 */
class MagratheaView{

	private $javascript_files = array();
	private $javascript_lastmodified_arr = array();
	private $css_files = array();
	private $scss_files = array();
	private $css_lastmodified_arr = array();
	private $site_path = "";
	private $compressionMode = "default";
	private $relativePath = false;
	private $urlForAssets = "";

	protected $compressed_path_js = "javascript/_compressed";
	protected $compressed_path_css = "css/_compressed";

	protected static $inst = null;

	public static function Instance(){
		if(!isset(self::$inst)){
			self::$inst = new MagratheaView();
		}
		return self::$inst;
	}
	private function __construct(){
		$this->site_path = MagratheaConfig::Instance()->GetConfigFromDefault("site_path");
	}

	/**
	 * Set compression mode
	 * @param 	string 		$mode 		DEFAULT or ADVANCED
	 * @return 	itself
	 */
	public function SetCompressionMode($mode){
		$this->compressionMode = strtolower($mode);
		return $this;
	}
	/**
	 * If path from files should be relative for main file
	 * @param 	boolean 	$it_is 		yes, it is relative from where we are!
	 * @return 	itself
	 */
	public function IsRelativePath($it_is){
		$this->relativePath = $it_is;
		return $this;
	}
	/**
	 * tell me if we are compressing Javascript
	 * @return  boolean 	javascript will be compressed?
	 */
	public function ShouldCompressJavascript(){
		return MagratheaConfig::Instance()->GetConfigFromDefault("compress_js");
	}
	/**
	 * tell me if we are compressing css
	 * @return  boolean 	css will be compressed?
	 */
	public function ShouldCompressCss(){
		return MagratheaConfig::Instance()->GetConfigFromDefault("compress_css");
	}
	/**
	 * Set URL for css and js files
	 * 		If we want the files to be included from a specific URL
	 * @param 	string 		$url 		url to be used in the include of files
	 * @return 	itself
	 */
	public function SetUrlForAssets($url){
		$this->urlForAssets = $url;
		return $this;
	}

	/**
	 * Set compressed path for js
	 * @param 	string 		$path 		path for compressed
	 * @return 	itself
	 */
	public function SetCompressedPathJs($path){
		$this->compressed_path_js = $path;
		return $this;
	}
	/**
	 * Set compressed path for css
	 * @param 	string 		$path 		path for compressed
	 * @return 	itself
	 */
	public function SetCompressedPathCss($path){
		$this->compressed_path_css = $path;
		return $this;
	}
	/**
	 * Gets compressed path for js
	 * @return  string 		Path where JS files are saved
	 */
	public function GetCompressedPathJs(){
		return $this->compressed_path_js;
	}
	/**
	 * Gets compressed path for css
	 * @return  string 		Path where CSS files are saved
	 */
	public function GetCompressedPathCss(){
		return $this->compressed_path_css;
	}

	/**
	 * Include JS file
	 * @param 	string 		$js_file 	file to be included
	 * @return 	itself
	 */
	public function IncludeJavascript($js_file){
		array_push($this->javascript_files, $js_file);
		$file_full = $this->site_path."/".$js_file;
		if(file_exists($file_full)){
			$lastm = filemtime($file_full);
		} else {
			throw new MagratheaViewException("File ".$file_full." could not be reached!");
		}
		array_push($this->javascript_lastmodified_arr, $lastm);
		return $this;
	}
	/**
	 * Include CSS file
	 * @param 	string 		$css_file 	file to be included
	 * @return 	itself
	 */
	public function IncludeCSS($css_file){
		array_push($this->css_files, $css_file);
		$file_full = $this->site_path."/".$css_file;
		if(file_exists($file_full)){
			$lastm = filemtime($file_full);
		} else {
			throw new MagratheaViewException("File ".$file_full." could not be reached!");
		}
		array_push($this->css_lastmodified_arr, $lastm);
		return $this;
	}
	/**
	 * Include CSS file
	 * @param 	string 		$css_file 	file to be included
	 * @return 	itself
	 */
	public function IncludeSCSS($scss_file){
		array_push($this->scss_files, $scss_file);
		$file_full = $this->site_path."/".$scss_file;
		if(file_exists($file_full)){
			$lastm = filemtime($file_full);
		} else {
			throw new MagratheaViewException("File ".$file_full." could not be reached!");
		}
		array_push($this->css_lastmodified_arr, $lastm);
		return $this;
	}
	
	/**
	 * Alias for Javascript
	 * @deprecated Use Javascript instead
	 */
	public function Javascripts(){
		return $this->Javascript(false);
	}
	/**
	 * Prints all the javascripts files on page
	 * @param 		boolean 	$compression 		should the code be compressed?
	 * @return  	string 		Include of Javascripts
	 */
	public function Javascript($print=false, $compression=null){
		$compression = ($compression===null ? $this->ShouldCompressJavascript() : $compression );
		$array_files = array_unique($this->javascript_files);
		$jsContent = "<!--JS FILES MANAGED BY MAGRATHEA [compression: ".$compression."] -->\n";
		if($compression){
			sort($this->javascript_lastmodified_arr);
			$js_lmod = implode("_", $this->javascript_lastmodified_arr);
			$js_lmod_hash = md5($js_lmod);
			$compressedFileName = $this->compressed_path_js."/".$js_lmod_hash."_compressed.js";
			if(!file_exists($compressedFileName)){
				if (!$handle = @fopen($compressedFileName, 'w')) { 
					$jsContent .= "<!--error compressing javascript! could not create file-->";
					$jsContent .= $this->Javascript(false, false);
					return $jsContent;
				} 
				$jsCompressor = new MagratheaCompressor(@MagratheaCompressor::COMPRESS_JS);
				$jsCompressor->setCompressionMode($this->compressionMode);
				foreach($array_files as $file){
					$jsCompressor->add($file);
				}
				$compressed_js = $jsCompressor->compress()->GetCompressedContent();
				if (!fwrite($handle, $compressed_js)) { 
					$jsContent .= "<!--error compressing javascript! could not write file-->";
					$jsContent .= $this->Javascript(false, false);
					return $jsContent;
				}
				fclose($handle); 
			}
			$jsContent .= "<script type='text/javascript' src='".$this->urlForAssets.($this->relativePath ? "" : "/").$compressedFileName."'></script>\n"; 
  		} else {
			foreach($array_files as $file){
				$jsContent .= "<script type='text/javascript' src='".$this->urlForAssets.($this->relativePath ? "" : "/").$file."'></script>\n"; 
			}
		}
		if($print) echo $jsContent; 
		return $jsContent;
	}

	/**
	 * Prints JS inline in page
	 * @param 	boolean 	$compression 		should we compress JS? (always false, so far)
	 * @return  string 		JS from all files printed in page
	 * @todo 	compression must work, eventually
	 */
	public function InlineJavascript(){
		$html = "<script type=\"text/javascript\">";
		$html .= "/* GENERATED by MAGRATHEA at ".now()." */";
		$array_files = array_unique($this->javascript_files);
		foreach ($array_files as $file) {
			$html .= file_get_contents($file);
		}
		$html .= "</script>";
		return $html;
	}

	/**
	 * Alias for CSS
	 * @deprecated 		Use "CSS" instead
	 */
	public function CSSs(){
		echo "<!--CSS FILES MANAGED BY MAGRATHEA-->\n";
		echo $this->CSS();
	}
	/**
	 * Prints all the css files on page
	 * @param 		boolean 	$compression 		should the code be compressed?
	 * @return  	string 		Include of CSSs
	 */
	public function CSS($compression=null){
		$compression = ($compression===null ? $this->ShouldCompressCss() : $compression );
		$array_files = array_unique($this->css_files);
		$cssContent = "";
		if($compression){
			sort($this->css_lastmodified_arr);
			$css_lmod = implode("_", $this->css_lastmodified_arr);
			$css_lmod_hash = md5($css_lmod);
			$compressedFileName = $this->compressed_path_css."/".$css_lmod_hash."_compressed.css";
			if(!file_exists($compressedFileName)){
				if (!$handle = @fopen($compressedFileName, 'w')) { 
					$cssContent .= "<!--error compressing css! could not create file-->\n";
					$cssContent .= $this->CSS(false);
					return $cssContent;
				} 
				$cssCompressor = new MagratheaCompressor(@MagratheaCompressor::COMPRESS_CSS);
				foreach($array_files as $file){
					$cssCompressor->add($file);
				}
				if($this->ShouldCompileSCSS()) {
					$cssCompressor->addContent($this->compileSCSS());
				}
				$compressed_css = $cssCompressor->compress()->GetCompressedContent();
				if (!fwrite($handle, $compressed_css)) { 
					$cssContent .= "<!--error compressing css! could not write file-->\n";
					$cssContent .= $this->CSS(false);
					return $cssContent;
				} 
				fclose($handle); 
			}
			$cssContent .= "<link href='".$this->urlForAssets.($this->relativePath ? "" : "/").$compressedFileName."' rel='stylesheet'>\n";
  	} else {
			foreach($array_files as $file){
				$cssContent .= "<link href='".$this->urlForAssets.($this->relativePath ? "" : "/").$file."' rel='stylesheet'>\n";
			}
			if($this->ShouldCompileSCSS()) {
				$cssContent .= $this->SCSS();
			}
		}
		return $cssContent;
	}
	/**
	 * Prints all the scss files on page
	 * @return  	string 		file with compiled SCSS
	 */
	public function SCSS() {
		sort($this->css_lastmodified_arr);
		$css_lmod = implode("_", $this->css_lastmodified_arr);
		$css_lmod_hash = md5($css_lmod);
		$compiledFileName = $this->compressed_path_css."/".$css_lmod_hash."_scss_compiled.css";
		$cssContent = "";
		if(!file_exists($compiledFileName)){
			if (!$handle = @fopen($compiledFileName, 'w')) { 
				$cssContent .= "<!--error compiling scss! could not create file-->\n";
				return $cssContent;
			}
			$cssContent = $this->compileSCSS();
			if (!fwrite($handle, $cssContent)) { 
				$cssContent .= "<!--error compiling scss! could not write file-->\n";
				return $cssContent;
			} 
			fclose($handle); 
		}
		return "<link href='".$this->urlForAssets.($this->relativePath ? "" : "/").$compiledFileName."' rel='stylesheet'>\n";
	}
	/**
	 * Compiles SCSS and returns content
	 * @return  	string 		compiled SCSS content in CSS
	 */
	public function compileSCSS() {
		$array_files = array_unique($this->scss_files);
		$cssCompressor = new MagratheaCompressor(@MagratheaCompressor::COMPILE_SCSS);
		foreach($array_files as $file){
			$cssCompressor->add($file);
		}
		return $cssCompressor->compileSCSS()->GetCompressedContent();
	}
	/**
	 * Do I have SCSS files to compile?
	 * @return  	boolean 		Do I?
	 */
	public function ShouldCompileSCSS() {
		return ( count($this->scss_files) > 0 );
	}


	/**
	 * Prints CSS inline in page
	 * @param 	boolean 	$compression 		should we compress CSS? (always false, so far)
	 * @return  string 		CSS from all files printed in page
	 * @todo 	compression must work, eventually
	 */
	public function InlineCSS($compression=false){
		$html = "<style>";
		$html .= "/* GENERATED by MAGRATHEA at ".now()." */";
		$array_files = array_unique($this->css_files);
		foreach ($array_files as $file) {
			$html .= file_get_contents($this->site_path."/".$file);
		}
		$html .= "</style>";
		return $html;
	}


}



