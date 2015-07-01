<?php

include(__DIR__."/libs/phpclosure.php");

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

  private $files = array();
  private $content = "";
  private $type = COMPRESS_JS;
  private $compressionMode = "advanced";

  function MagratheaCompressor($compress_type=null) { 
    if(!is_null($compress_type)){
      $this->type = $compress_type;
    }
  }

  function setCompressionMode($mode){
    $this->compressionMode = strtolower($mode);
  }

  /**
   * Adds a source file to the list of files to compile.  Files will be
   * concatenated in the order they are added.
   * @todo  improve and fix some issues. So far, recommended is to turn compression off
   */
  function add($file) {
    $this->files[] = $file;
    return $this;
  }

  function compress(){
    if( $this->type == self::COMPRESS_CSS ){ 
      $this->compressCSS();
    } else if ( $this->type == self::COMPRESS_JS ) {
      $this->compressJs();
    }
  }

  function compressCSS(){
    $allContent = "";
    foreach ($this->files as $f) {
      $allContent .= file_get_contents($f);
    }
    Debug("compressing CSS...");
    $this->content = 
      str_replace('; ',';',
        str_replace(' }','}',
          str_replace('{ ','{',
            str_replace(
              array("\r\n","\r","\n","\t",'  ','    ','    '),"",
              preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!','',
                $allContent)
            )
          )
        )
      );
  }

  function compressJs($advancedMode=false){
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
    Debug("compressing Javascript...");
    $this->content = $phpclosure->_compile();
    // removing console messages:
    $consoleRegex = "/({|}|\)|;|\s)console.(log|debug|info|warn|error|assert|dir|dirxml|trace|group|groupEnd|time|timeEnd|profile|profileEnd|count)\\(.*?\\);/i"; 
    $this->content = preg_replace($consoleRegex, "$1", $this->content);
  }

  function GetCompressedContent(){
    return $this->content;
  }
}

?>