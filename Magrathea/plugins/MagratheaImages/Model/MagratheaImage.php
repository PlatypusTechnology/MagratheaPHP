<?php

/*
 * 	MAGRATHEA IMAGE
 * 	version: 0.1 beta
 * 		last modified: 2013-07-29 by Paulo

	Using lib Wide image:
	http://wideimage.sourceforge.net
*/

include(__DIR__."/MagratheaImageBase.php");
include 'WideImage/WideImage.php';


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
	private $imgSize = array();
	private $imgName = "";

	public function __construct( $id=0 ){
		parent::__construct($id);
	}

	// image manager functions:
	public function SilentLoad(){
		$this->LoadConfig();
		try{
			$this->image = WideImage::load($this->imagesPath.$this->filename);
		} catch(Exception $ex){
			$this->error = $this->error."\n".$ex->getMessage();
			$this->isError = true;
			return;
		}
		$this->imgSize = array('width' => $this->width, 'height' => $this->height);
	}
	public function Load(){
		$this->SilentLoad();
		return $this;
	}
	// returns a thumb with the predefined thumb size:
	public function Thumb(){
		$this->ResizeToAndCrop($this->thumbSize);
		return $this;
	}
	public function FixedSize($w, $h){
		$this->ResizeToAndCrop(array('width' => $w, 'height' => $h));
		return $this;
	}
	public function FixedWidth($w){
/*
		$proportion = $this->imgSize['width'] / $w;
		$new_width = $w;
		$new_height = ceil($this->imgSize['height'] * $proportion);
*/
		$this->ResizeTo(array('width' => $w, 'height' => null));
		return $this;
	}
	public function FixedHeight($h){
/*
		$proportion = $this->imgSize['height'] / $h;
		$new_height = $h;
		$new_width = ceil($this->imgSize['width'] * $proportion);
*/
		$this->ResizeTo(array('width' => null, 'height' => $h));
		return $this;
	}
	public function MaxSize($w, $h){
		return $this->MaxWidth($w)->MaxHeight($h);
	}
	public function MaxWidth($w){
		if($this->imgSize['width'] > $w){
			return $this->FixedWidth($w);
		} else {
			return $this;
		}
	}
	public function MaxHeight($h){
		if($this->imgSize['height'] > $h){
			return $this->FixedHeight($h);
		} else {
			return $this;
		}
	}
	public function Url(){
		if( $this->isError ){
			return "#?error=".$this->error;
		}
		$this->SaveFile();
		return $this->webImagesGenerated.$this->imgName;
	}
	public function Code($title=""){
		if( $this->isError ){
			return "error = ".$this->error;
		}
		$this->SaveFile();
		$code = '<img src="'.$this->webImagesGenerated.$this->imgName.'" alt="'.$title.'" title="'.$title.'" '.$this->otherAttr.' />';
		return $code;
	}
	public function otherAttr($moreAttr){
		$this->otherAttr = $moreAttr;
		return $this;
	}

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
	private function ResizeTo($thisSize){
		$this->image = $this->image->resize($thisSize['width'], $thisSize['height'], 'fill', 'any');
		$this->imgSize["width"] = $this->image->getWidth();
		$this->imgSize["height"] = $this->image->getHeight();
	}

	private function SaveFile(){
		$this->imgName = $this->GetFileNameWithoutExtension()."_".implode("x", $this->imgSize).".".$this->extension;
		$fname = $this->generatedPath.$this->imgName;
		if(!file_exists($fname))
			$this->image->saveToFile($fname);
	}

	/* configuration functions: */
	// load the general image config:
	public function LoadConfig(){
		$environment = MagratheaConfigStatic::GetEnvironment();
		$config = new MagratheaConfig();
		$config->setPath(__DIR__."/../config/");
		$config->setFile("MagratheaImages.conf");
		$this->imagesPath = $config->GetConfig($environment."/images_path");
		$this->generatedPath = $config->GetConfig($environment."/generated_path");
		$this->webImagesFolder = $config->GetConfig($environment."/web_images_folder");
		$this->webImagesGenerated = $config->GetConfig($environment."/web_images_generated");
	}
	public function getUrl(){
		return $this->webImagesFolder.$this->filename;
	}
	public function getImagePath(){
		return $this->imagesPath.$this->filename;
	}
	public function getWidthHeight(){
		$arraySizes = array();
		list($width, $height) = getimagesize($this->imagesPath.$this->filename);
		$this->width = $width;
		$this->height = $height;
		return $arraySizes;
	}
	public function SetFilename($name){
		$nextId = $this->GetNextID();
		$this->filename = $nextId."_".$name;
	}
	public function Insert(){
		$this->getWidthHeight();
		parent::Insert();
	}

	public function GetFileNameWithoutExtension(){
		$fname = explode('.', $this->filename);
		array_pop($fname);
		return implode('.', $fname);
	}


}

class MagratheaImageControl extends MagratheaImageControlBase {
	// and here!
	public function GetXMostRecent($mostRecent = 20, $page=0){
		$query = new MagratheaQuery();
		$query->Obj("MagratheaImage")->Order("id DESC")->Limit($mostRecent)->Page($page);
		return self::Run($query);

	}
}

?>