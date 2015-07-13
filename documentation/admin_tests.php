<?php include("inc/header.php"); ?>

<div class="container main_container">
	<img src="http://www.simpletest.org/images/simpletest-logo.png" alt="SimpleTest" title="SimpleTest" class="image right"/>
	<h1>Tests</h1>
	<p>
		The framework used for tests is the <b>SimpleTest unit tester</b>.<br/>
		The documentation for tests is quite explained and available at <a href="http://www.simpletest.org/" title="simpletest">http://www.simpletest.org/</a>.<br/>
	</p>
	<h3>Tests Folder</h3>
	<p>
		Every test should be included inside <em><b>Tests</b></em> folder.<br/>
		The menu for test is automatically generated getting the name of the files inserted on it.<br/>
		If a file starts with <em>_</em>, it will not be listed. This way, you can include files without displaying them.<br/>
	</p>
	<h3>Example</h3>
	<p>
		Here is an example of test file:<br/>
		<pre class="prettyprint linenums">&lt;pre&gt;
&lt;?php
//	ini_set('display_errors', 1);
//	error_reporting(E_ALL);

	SimpleTest::prefer(new TextReporter());
	include("_MagratheaConfig.php");
?&gt;
&lt;/pre&gt;		
</pre>
		<em>_MagratheaConfig.php</em> file is:<br/>
		<pre class="prettyprint linenums">&lt;?php
class TestOfStaticConfig extends UnitTestCase{

	function setUp(){
	}
	function tearDown(){
	}

	// load a section in Static Config
	// I check if the section that it returns is an array:
	function testLoadSectionStaticConfig(){
		echo "testing magratheaConfig loading static config...";
		$thisSection = MagratheaConfig::Instance()->GetConfigSection("general");
		$this->assertIsA($thisSection, "array");
	}

	// config file must have a default environment option
	function testConfigShouldHaveADefaultEnvironment(){
		echo "testing magratheaConfig confirming we have a default...";
		$env = MagratheaConfig::Instance()->GetEnvironment();
		$this->assertNotNull($env);
	}

	// required fields
	function testConfigRequiredFields(){
		echo "testing magratheaConfig checking required fields...";
		$env = MagratheaConfig::Instance()->GetConfig("general/use_environment");
		$site_path = MagratheaConfig::Instance()->GetConfig($env."/site_path");
		$magrathea_path = MagratheaConfig::Instance()->GetConfig($env."/magrathea_path");
		$compress_js = MagratheaConfig::Instance()->GetConfig($env."/compress_js");
		$compress_css = MagratheaConfig::Instance()->GetConfig($env."/compress_css");
		$this->assertNotNull($site_path);
		$this->assertNotNull($magrathea_path);
		$this->assertNotNull($compress_js);
		$this->assertNotNull($compress_css);
	}

	function testReturnFalseWhenItemDoesNotExists(){
		echo "testing magratheaConfig should return false if item doesn't exists...";
		try {
			$thisIsFalse = MagratheaConfig::Instance()->GetFromDefault("idontexist");
			$this->fail("I should get an exception");
		} catch(Exception $e) {
			$this->assertEqual($e->getCode(), 704);
			$this->pass("exception ok!");
		}
	}

}
?&gt;</pre>
	</p>
	<h3>Keep testing...</h3>
	<p>
		It's a good programming practice to test your code.<br/>
		For more information about testing and TDD, you can study <i>Mauricio Aniche</i> work:<br/>
		<ul>
			<li><a href="http://www.aniche.com.br/tdd/">http://www.aniche.com.br/tdd/</a> - (blog, in portuguese)</li>
			<li><a href="http://www.codecrushing.com/products/book-tdd">Real World Test-Driven Development</a> - (book, in english)</li>
		</ul>
	</p>

</div>


<?php include("inc/footer.php"); ?>