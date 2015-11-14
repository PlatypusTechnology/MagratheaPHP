<?php

require ("admin_load.php");

//error_reporting(E_ALL);

$query = $_POST["sql"];
$queryArr = explode(";", $query);

foreach ($queryArr as $sql_query) {
	$query = trim($sql_query);
	if(empty($query)) continue;
	try{
		$result = MagratheaDatabase::Instance()->QueryAll($sql_query);
		?>
<div class="row-fluid">
	<div class="span12 mag_section">
		<header class="hide_opt">
			<h3><?=$query?></h3>
			<span class="arrow toggle" style="display: none;"><a href="#"><i class="fa fa-chevron-down"></i></a></span>
		</header>
		<content>
			<div class='row-fluid'><div class="span12">
				<div class="alert alert-success">
					<button class="close" data-dismiss="alert" type="button">×</button>
					<strong>Query executed!</strong><br/>
					Extended Result: <br/>
					<textarea class="textarea_large"><?=print_r($result)?></textarea><br/>
				</div>
		<?php
		if(is_array($result)){
			if(count($result) == 0){
				echo "empty table";
			} else {
			$fields = $result[0];
			?>
			<table class="table table-striped table-bordered">
				<tbody>
					<thead>
						<?php
						foreach ($fields as $key => $value) {
							echo "<th>".$key."</th>";
						}
						?>
					</thead>
					<?php
					$even = false;
					foreach($result as $row){
						?>
						<tr <?=($even ? "class='even'" : "")?>>
							<?php
							foreach ($row as $value) {
								echo "<td>".$value."</td>";
							}
							?>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>
			<?php
			}
		}
	} catch(Exception $ex){
		?>
		<div class="alert alert-error">
			<button class="close" data-dismiss="alert" type="button">×</button>
			<strong>Error!</strong><br/>
			<?=$ex->getMessage()?>
		</div>
		<?php
	}
	?>
			</div></div>
		</content>
	</div>
</div>
	<?php
}


?>
