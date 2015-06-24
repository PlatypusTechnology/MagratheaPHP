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

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Magrathea - <?=$this->title?></title>
    
    <!-- ===================== CSS ===================== -->
    <? include("resources/css.php") ?>
    <?=MagratheaView::Instance()->InlineCSS()?>

  </head>
  <body> 

    <? include("header.php"); ?>              

	<div class="container main_container">

    <!-- Docs nav
    ================================================== -->
    <div class="row">
      <div class="span3 bs-docs-sidebar" id="main_menu_div">
				<? include("menu.php"); ?>
      </div>
      <div class="span9" id="main_content">
    	</div>
    </div>

  </div>

	<footer class="footer">
		<div class="container">
			<p>Magrathea - Platypus Technology</p>
		</div>
	</footer>


</body>

    <!-- ===================== JS ===================== -->
    <?=MagratheaView::Instance()->InlineJavascript()?>
    <? include("resources/javascript_admin.php") ?>
    <? include("resources/javascript.php") ?>

</html>