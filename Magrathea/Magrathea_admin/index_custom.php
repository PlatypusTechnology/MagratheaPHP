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
    <title>Magrathea</title>
    
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
				<div id="admin_response"></div>
      </div>
      <div class="span9" id="main_content"></div>
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
    <? include("resources/javascript.php") ?>
    <script type="text/javascript">
      loadCustom();
<? if (empty($_GET["custompage"])){ ?>
      loadCustomAdmin("index.php");
<? } ?>
    </script>

</html>