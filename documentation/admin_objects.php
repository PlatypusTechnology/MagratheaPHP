<?php include("inc/header.php"); ?>

<div class="container main_container">
	<h1>Objects</h1>
	<p>
		Now that you have the objects, there is a lot of nice things that you can do with it.<br/>
		<br/>
		First, you can use this as a cheat sheet for all the default properties and Methods from the objects. Make good use of it!<br/>
		<h3>Relationships</h3>
		Here you can create a new relation for the object.<br/>
		On the opposite of programmers, tables and objects do have relations.<br/>
		If you don't know how objects and relations between them work, then I recommend you to study about it. =P <br/>
	</p>
	<p><div style="margin-left: 30px;">
		You can create relations:
		<h5>belongs to</h5>
			The object belongs to another. <br/>
			You will select the field from your object that will be equivalent to the id of the relational object.<br/>
			For this kind of relation, you can <i>Lazy Load</i> and <i>Auto Load</i> the object.<br/>
			This relation will also generate a new property with the name of the related object and method (for getting it automatically).<br/>
		<h5>has many</h5>
			The object will have multiple of the other objects.<br/>
			You will select the field from the other object that will be equivalent to the id of your object.<br/>
			For this kind of relation, you can <i>Lazy Load</i> and <i>Auto Load</i> the object.<br/>
			This relation will also generate a new property with the name of the related object and method (for getting it automatically).<br/>
		<h5>has and belongs to many</h5>
			The object will have multiple of the other objects.<br/>
			You will select the field from the other object that will be equivalent to the id of your object.<br/>
			For this kind of relation, you can <i>Lazy Load</i> and <i>Auto Load</i> the object.<br/>
			This relation will also generate a new property with the name of the related object and method (for getting it automatically).<br/>
	</div></p>
	<p><div style="margin-left: 50px;">
		<h4><i>Lazy load</i></h4>
		When an object has lazy load, it can be automatically loaded only when it is required.<br/>
		It's beautiful. It's the future.<br/>
		You load the object. Only it. Then you need an object that is related. You just call the object and Magrathea will get it from the database automatically and give it back to you.<br/>
		Easy as that.<br/>
		<h4><i>Auto load</i></h4>
		This is even better:<br/>
		Let's suppose you have an object that you only uses it with something relational to it.<br/>
		You can select the <i>Auto load</i> option and Magrathea will build a query with a join clause, that will always load everything together.<br/>
		This is magic.<br/>
	</div></p>
	<p>
		<h3>Code</h3>
		We are trying to be as transparent as possible here.<br/>
		That's why we show you the code that is generated for each object.<br/>
		Yes! That's right! Magrathea rights some codes to you.<br/>
		That's what you should see next: <a href="admin_code.php">Generate Code</a>.<br/>
	</p>
</div>


<?php include("inc/footer.php"); ?>