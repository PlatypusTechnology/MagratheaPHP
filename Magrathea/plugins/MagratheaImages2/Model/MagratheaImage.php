<?php

/*
 * 	MAGRATHEA IMAGE
 * 	version: 0.1 beta
 * 		last modified: 2013-07-29 by Paulo

	Using lib Wide image:
	http://wideimage.sourceforge.net
*/

include(__DIR__."/MagratheaImageBase.php");

class MagratheaImage extends MagratheaImageBase {

	public $imagesPath;
	public $generatedPath;
	public $webImagesFolder;
	public $webImagesGenerated;
	public $thumbSize = array('width' => 200, 'height' => 200);

	private $error = "";
	private $isError = false;

	private $image;
	private $otherAttr = "";
	private $style = "";
	private $imgSize = array();
	private $imgName = "";

	public function __construct( $id=0 ){
		parent::__construct($id);
	}

	/**
	 * load image options
	 */
	public function SilentLoad(){
		$this->LoadConfig();
		try{
			/*
			if(!$this->checkValidGd()){
				throw new Exception("Image Format invalid");
			}
			*/
			$this->image = WideImage::loadFromFile($this->imagesPath.$this->filename);
		} catch(Exception $ex){
			$this->error = $this->error."\n".$ex->getMessage();
			$this->isError = true;
			throw new MagratheaException($ex);
			return;
		}
		$this->imgSize = array('width' => $this->width, 'height' => $this->height);
		return $this;
	}
	/**
	 * Load image options and return object itself
	 * @return itself
	 */
	public function Load(){
		$this->SilentLoad();
		return $this;
	}
	private function checkValidGd(){
		switch($this->extension){
			case "png":
				return function_exists("imagecreatefrompng");
			case "jpg":
			case "jpeg":
				return function_exists("imagecreatefromjpeg");
			case "gif":
				return function_exists("imagecreatefromgif");
			case "bmp":
			case "tga":
				return true;
			default:
				return false;
		}
	}


	/**
	 * Builds thumb image with the predefined thumb size
	 * @return itself
	 */
	public function Thumb(){
		$this->ResizeToAndCrop($this->thumbSize);
		return $this;
	}
	/**
	 * Sets a fixed size for the image
	 * In case of portrait image:
	 * 		image will be sliced in the bottom, keeping the top
	 * In case of landscape:
	 * 		image will be sliced in the sides, keeping the center
	 * @param 	int 	$w 		width
	 * @param 	int 	$h 		height
	 * @return itself
	 */	
	public function FixedSize($w, $h){
		$this->ResizeToAndCrop(array('width' => $w, 'height' => $h));
		return $this;
	}
	/**
	 * Sets a fixed width for the image
	 * The height will differ, respecting the dimensions
	 * @param 	int 	$w 		width
	 * @return itself
	 */
	public function FixedWidth($w){
		$this->ResizeTo(array('width' => $w, 'height' => null));
		return $this;
	}
	/**
	 * Sets a fixed height for the image
	 * The width will differ, respecting the dimensions
	 * @param 	int 	$h 		height
	 * @return itself
	 */
	public function FixedHeight($h){
		$this->ResizeTo(array('width' => null, 'height' => $h));
		return $this;
	}
	/**
	 * Sets a maximum size for the image.
	 * 	If one of the sides exceeds expected dimension, image will be sliced
	 * @param 	int 	$w 		max width
	 * @param 	int 	$h 		max height
	 * @return itself
	 */
	public function MaxSize($w, $h){
		return $this->MaxWidth($w)->MaxHeight($h);
	}
	/**
	 * Sets a maximum width for the image.
	 * 	Height can be of any size, once width does not exceed this one
	 * @param 	int 	$w 		maximum width
	 * @return itself
	 */
	public function MaxWidth($w){
		if($this->imgSize['width'] > $w){
			return $this->FixedWidth($w);
		} else {
			return $this;
		}
	}
	/**
	 * Sets a maximum height for the image.
	 * 	Width can be of any size, once height does not exceed this one
	 * @param 	int 	$h 		maximum height
	 * @return itself
	 */
	public function MaxHeight($h){
		if($this->imgSize['height'] > $h){
			return $this->FixedHeight($h);
		} else {
			return $this;
		}
	}
	/**
	 * Creates image following required parameters and returns url
	 * @return 	string 		image url
	 */
	public function Url(){
		if( $this->isError ){
			return "#?error=".$this->error;
		}
		$this->SaveFile();
		return $this->webImagesGenerated.$this->imgName;
	}
	/**
	 * generates a HTML code for the image and returns it
	 * @param 	string 		$title    		Title and Alt for the image
	 * @param 	string 		$moreAttr 		other attributes for the &lt;img html tag
	 * @return 	string 		HTML code for image
	 */
	public function Code($title="", $moreAttr=null){
		if( $this->isError ){
			return "error = ".$this->error;
		}
		if($moreAttr) {
			$this->otherAttr($moreAttr);
		}
		$attr = "";
		if(!empty($this->otherAttr)){
			$attr .= $this->otherAttr;
		}
		if(!empty($this->style)){
			$attr .= ' style="'.$this->style.'"';
		}
		$this->SaveFile();
		$code = '<img src="'.$this->webImagesGenerated.$this->imgName.'" alt="'.$title.'" title="'.$title.'" '.$attr.' />';
		return $code;
	}
	/**
	 * set other attributes for the &lt;img html tag
	 * @param  string 	$moreAttr 	attributes
	 * @return itself
	 */
	public function otherAttr($moreAttr){
		$this->otherAttr .= " ".$moreAttr;
		return $this;
	}
	/**
	 * sets style for the img code
	 * @param 	string 		$style 		string with css style
	 * @return itself
	 */
	public function Style($st){
		$this->style .= $st;
		return $this;
	}
	/**
	 * sets class for the img code
	 * @param 	string 		$class 		string with css class
	 * @return itself
	 */
	public function SetClass($cl){
		$this->otherAttr("class='".$cl."'");
		return $this;
	}


	/**
	 * private function: resize and rop image in the sent height
	 * @param 	array 	$thisSize 	size, in format: ("width" => width, "height" => "height")
	 */	
	private function ResizeToAndCrop($thisSize){
		if( $this->isError ) return;
		$proportion = 1;
		$new_height = $new_width = 0;
		if($this->imgSize['width'] > $this->imgSize['height']){
			// resize in height and crop the sides
			$proportion = $this->imgSize['height'] / $thisSize["height"];
			$new_height = $thisSize["height"];
			$new_width = ceil($this->imgSize['width'] * $proportion);
			$this->image = $this->image->resize($new_width, $new_height);
			// crop the center:
			$this->image = $this->image->crop("center", "top", $thisSize['width'], $thisSize['height']);
		} else {
			// resize in width and crop the bottom
			$proportion = $this->imgSize['width'] / $thisSize["width"];
			$new_width = $thisSize["width"];
			$new_height = ceil($this->imgSize['height'] * $proportion);
			$this->image = $this->image->resize($new_width, $new_height);
			// crop from top:
			$this->image = $this->image->crop(0, 0, $thisSize['width'], $thisSize['height']);
		}
		$this->imgSize = $thisSize;
	}
	/**
	 * Resizes image to
	 * @param 	array 	$thisSize 	size, in format: ("width" => width, "height" => "height")
	 * @return itself
	 */
	private function ResizeTo($thisSize){
		$this->image = $this->image->resize($thisSize['width'], $thisSize['height'], 'fill', 'any');
		$this->imgSize["width"] = $this->image->getWidth();
		$this->imgSize["height"] = $this->image->getHeight();
		return $this;
	}

	/**
	 * Saves image file
	 * @return itself
	 */
	private function SaveFile(){
		$this->imgName = $this->GetFileNameWithoutExtension()."_".implode("x", $this->imgSize).".".$this->extension;
		$fname = $this->generatedPath.$this->imgName;
		if(!file_exists($fname))
			$this->image->saveToFile($fname);
		return $this;
	}

	/**
	 * Load general configurations for image
	 * @return itself
	 */
	public function LoadConfig(){
		$environment = MagratheaConfig::Instance()->GetEnvironment();
		$confFile = new MagratheaConfigFile();
		$confFile->setPath( realpath(MagratheaConfig::Instance()->GetConfigFromDefault("site_path")."/../configs/") );
		$confFile->setFile( "magrathea_images.conf" );

		$this->imagesPath = $confFile->GetConfig($environment."/images_path")."/";
		$this->generatedPath = $confFile->GetConfig($environment."/generated_path")."/";
		$this->webImagesFolder = $confFile->GetConfig($environment."/web_images_folder")."/";
		$this->webImagesGenerated = $confFile->GetConfig($environment."/web_images_generated")."/";
		return $this;
	}
	/**
	 * Gets image url
	 * @return 	string 		image url, in web format
	 */
	public function GetUrl(){
		return $this->webImagesFolder.$this->filename;
	}
	/**
	 * Get Images Path
	 * @return 	string 		images path, absolut
	 */
	public function GetImagePath(){
		return $this->imagesPath.$this->filename;
	}
	/**
	 * Sets the width and height from the image
	 * @return 	array 		width and height in format: array("width" => width, "height" => height)
	 */
	public function GetWidthHeight(){
		list($width, $height) = getimagesize($this->imagesPath.$this->filename);
		$this->width = $width;
		$this->height = $height;
		return array('width' => $width, 'height' => $height);
	}
	/**
	 * Sets filename for image
	 * @param 	string 		$name 		file name
	 * @return  itself
	 */
	public function SetFilename($name){
		$nextId = $this->GetNextID();
		$this->filename = $nextId."_".$name;
		return $this;
	}
	/**
	 * Inserts image (calls parent insert)
	 * @return  	int 		image inserted id
	 */
	public function Insert(){
		$this->getWidthHeight();
		parent::Insert();
	}
	/**
	 * Gets filename without extension
	 * 		(whatever, man... may be useful for you)
	 * 	@return 	string 		filename without extension
	 */
	public function GetFileNameWithoutExtension(){
		$fname = explode('.', $this->filename);
		array_pop($fname);
		return implode('.', $fname);
	}

	/**
	 * 	Deletes the image - from the database and also deletes the file from server
	 */
	public function Delete(){
		$file = $this->imagesPath.$this->filename; 
		if(file_exists($file))
			unlink($file);
		parent::Delete();
	}


}

class MagratheaImageControl extends MagratheaImageControlBase {
	/**
	 * Get n last added images
	 * @param 	integer 	$mostRecent 	amount of images to be returned (default: 20)
	 * @param 	integer 	$page       	page to pagination (default: 0)
	 * @return  array<images> 		result of images
	 */
	public static function GetXMostRecent($mostRecent = 20, $page=0){
		$query = new MagratheaQuery();
		$query->Obj("MagratheaImage")->Order("id DESC")->Limit($mostRecent)->Page($page);
		return self::Run($query);
	}
}

?>