<?php

require ("admin_load.php");

//error_reporting(E_ALL);

$query = $_POST["sql"];
$table = $_POST["table"];
$queryArr = explode(";", $query);
$queryIndex = 0;

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
	if( strtolower( substr($sql_query, 0, 6) ) == "select" ) {
		$archive_table_name = "_".$table."_".date("Ym");
		?>
	<div class="row-fluid">
		<div class="span12 mag_section">
			<header class="hide_opt">
					<h3>Archive Query</h3>
					<span class="arrow toggle" style="display: none;"><a href="#"><i class="fa fa-chevron-down"></i></a></span>
			</header>
			<content style="display: none;">
				<div class="row-fluid">
					<div class="span7">
						This will create a table with this content and remove this data from this current table.
						<hr/>
						Query:<br/>
						<pre id="query<?=$queryIndex?>"><?=$sql_query?></pre>
					</div>
					<div class="span5 right">
						<br/><br/><br/>
						<label for="arcive-table-name">
							Archive Table name:
						</label>
						<input type="text" name="archive-name" id="archive-name<?=$queryIndex?>" value="<?=$archive_table_name?>"><br/>
						<button class="btn btn-success" onClick="archiveData(<?=$queryIndex?>);"><i class="fa fa-arrow-right"></i><i class="fa fa-database"></i>&nbsp;Archive Data</button>
					</div>
				</div>
			</content>
		</div>
	</div>

	<?php
	}
	$queryIndex++;
}

?>
