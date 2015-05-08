<?php include("inc/header.php"); ?>

<div class="container main_container">
	<h1>Tables</h1>
	<p>
		This page will display information about the selected table.<br/>
		You can see all the fields and the type of them.<br/>
		<br/>
		Here you can also create an object from the table:<br/>
		First, create fields "<i>created_at</i>" and "<i>updated_at</i>", clicking in the button on the first part of the page.<br/>
		That will also create the triggers to fill up those fields automatically, so you don't even have to worry about that in the code. (Yes, yes. It's an idea that I got from Ruby...)<br/>
		<br/>
		Once everything is right, you will be able to create the object. Define the name of it, the types for the properties and, here, you can also add alias for each property.<br/>
		The alias is a different name for the same property.<br/>
		Because sometimes, you want a property with some MySQL reserved words and, as you can see, Magrathea uses the column name in it internal gear, so the alias will help you to make this transition.<br/>
		<br/>
		Once the object exists, you can work on it! =)<br/>
		<a href="admin_objects.php">Go there</a>!
	</p>
</div>


<?php include("inc/footer.php"); ?>