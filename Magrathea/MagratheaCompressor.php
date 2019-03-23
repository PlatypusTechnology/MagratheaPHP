<?php

include(__DIR__."/libs/phpclosure.php");
use Leafo\ScssPhp\Compiler;

#######################################################################################
####
####  MAGRATHEA PHP
####  v. 1.0
####
####  Magrathea by Paulo Henrique Martins
####  Platypus technology
####
#######################################################################################
####
####  CSS Compressor
####  Compress CSS files
####  
####  created: 2013-01 by Paulo Martins
####
#######################################################################################

/**
 * Compressor: Magrathea function that works with *MagratheaView* to generate compressed files for CSS and Javascript
 */
class MagratheaCompressor {

  const COMPRESS_JS = 1;
  const COMPRESS_CSS = 2;
  const COMPILE_SCSS = 3;

  private $files = array();
  private $rawContent = "";
  private $content = "";
  private $type = self::COMPRESS_JS;
  private $compressionMode = "advanced";

  /**
   * Magrathea Compressor constructor
   * @param   const   $compress_type  compress type (MagratheaCompressor::COMPRESS_JS || MagratheaCompressor::COMPRESS_CSS)
   */
  function __construct($compress_type=null) { 
    if(!is_null($compress_type)){
      $this->type = $compress_type;
    }
  }

  /**
   * Set compression mode
   * @param   string    $mode     DEFAULT or ADVANCED
   * @return  itself
   */
  function setCompressionMode($mode) {
    $this->compressionMode = strtolower($mode);
    return $this;
  }

  /**
   * Adds a source file to the list of files to compile.  Files will be
   * concatenated in the order they are added.
   * @param   string    $file     include a file
   * @return  itself
   */
  function add($file) {
    $this->files[] = $file;
    return $this;
  }

  /**
   * Adds content to be compressed (as string)
   * @param   string    $content     adding content
   * @return  itself
   */
  function addContent($content) {
    $this->rawContent .= $content;
    return $this;
  }

  /**
   * yeah... yeah... do your magic. compres
   * @return  itself
   */
  function compress() {
    switch ($this->type) {
      case self::COMPRESS_CSS:
        $this->compressCSS();
        break;
      case self::COMPRESS_JS:
        $this->compressJs();
        break;
      case self::COMPILE_SCSS:
        $this->compileSCSS();
        break;
    }
    return $this;
  }

  /**
   * compress the CSS
   * @return  itself
   */
  function compressCSS() {
    $allContent = "";
    foreach ($this->files as $f) {
      $allContent .= file_get_contents($f);
    }
    $this->content = $allContent;
    $this->content .= $this->rawContent;
    $this->content = $this->cleanCSSCode($this->content);
    return $this;
  }
  /**
   * removes spaces, new lines and everything else for our CSS to be lighter
   * @return  string    clean CSS code
   */
  function cleanCSSCode($code) {
    return
      str_replace('; ',';',
        str_replace(' }','}',
          str_replace('{ ','{',
            str_replace(
              array("\r\n","\r","\n","\t",'  ','    ','    '),"",
              preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!','',
                $code)
            )
          )
        )
      );
  }
  /**
   * compile SCSS
   * @return  itself
   */
  function compileSCSS() {
    $allContent = "";
    foreach ($this->files as $f) {
      $allContent .= file_get_contents($f);
    }
    $scss = new Compiler();
    $this->content .= $scss->compile($allContent);
    return $this;
  }

  /**
   * compress Javascript
   * @return  itself
   */
  function compressJs($advancedMode=false) {
    $phpclosure = new PhpClosure();
    foreach($this->files as $f){
      $phpclosure->add($f);
    }
    if($this->compressionMode == "advanced"){
      $phpclosure->advancedMode()->useClosureLibrary();
    }
    if( MagratheaDebugger::Instance()->GetType() == MagratheaDebugger::NONE ){
      $phpclosure->hideDebugInfo();
    }
    $this->content = $phpclosure->_compile();
    // removing console messages:
    $consoleRegex = "/({|}|\)|;|\s)console.(log|debug|info|warn|error|assert|dir|dirxml|trace|group|groupEnd|time|timeEnd|profile|profileEnd|count)\\(.*?\\);/i"; 
    $this->content = preg_replace($consoleRegex, "$1", $this->content);
    return $this;
  }

  /**
   * gets content 
   * @return  string    compressed/compiled content (javascript or css)
   */
  function GetCompressedContent(){
    return $this->content;
  }
}

?>