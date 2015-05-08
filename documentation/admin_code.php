<?php include("inc/header.php"); ?>

<div class="container main_container">
	<h1>Generating code</h1>
	<p>
		Click in "<i>Generate Code</i>". See? That easy.<br/>
		The main code will be generated in <em>app/Models/Base</em>. 
		It will be one file for each object.<br/>
		The main created files should not be changed, once they work just as a base for your real code.<br/>
		Here is a sample of a Base-Object generated code:
<pre class="prettyprint linenums">&lt;?php

## FILE GENERATED BY MAGRATHEA.
## SHOULD NOT BE CHANGED MANUALLY

class ObjectBase extends MagratheaModel implements iMagratheaModel {

	public $id, $name, $value, $related_id;
	public $created_at, $updated_at;
	protected $autoload = null;

	public function __construct(  $id=0  ){ 
		$this->Start();
		if( !empty($id) ){
			$pk = $this->dbPk;
			$this->$pk = $id;
			$this->GetById($id);
		}
	}
	public function Start(){
		$this->dbTable = "tab_arquivos";
		$this->dbPk = "id";
		$this->dbValues["id"] = "int";
		$this->dbValues["name"] = "string";
		$this->dbValues["value"] = "int";
		$this->dbValues["related_id"] = "int";

		$this->relations["properties"]["Related"] = null;
		$this->relations["methods"]["Related"] = "GetRelated";
		$this->relations["lazyload"]["Related"] = "true";

		$this->dbAlias["created_at"] =  "datetime";
		$this->dbAlias["updated_at"] =  "datetime";
	}

	// >>> relations:
	public function GetRelated(){
		$this->relations["properties"]["Related"] = new Related($this->related_id);
		return $this->relations["properties"]["Related"];
	}
}

class ObjectControlBase extends MagratheaModelControl {
	protected static $modelName = "Object";
	protected static $dbTable = "tab_object";
}
&gt;</pre><br/>
	The code for each object should go into the files located at <em>app/Models/</em>.<br/>
	Basically, the classes into that files will inherits the base object and leave the job easier to you.<br/>
	Here's a sample of how a model file should look like:<br/>
<pre class="prettyprint linenums">&lt;?php
include(__DIR__."/Base/ObjectBase.php");

class Object extends ObjectBase {
	// your code goes here!
}

class ObjectControl extends ObjectControlBase {
	// and here!
}
&gt;</pre><br/>
	The object file and class can (and should) be changed.<br/>
	</p>
</div>


<?php include("inc/footer.php"); ?>