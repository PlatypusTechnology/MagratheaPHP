<?php

require ("admin_load.php");

$site_path = realpath(MagratheaConfig::Instance()->GetFromDefault("site_path"));
$magrathea_path = realpath(MagratheaConfig::Instance()->GetFromDefault("magrathea_path"));

$magratheaConfig = realpath($site_path."/../configs");
$magratheaConfig_ok  = is_writeable($magratheaConfig);
$magratheaConfigFile = is_writable($magratheaConfig."/magrathea.conf");
$magratheaConfigObjectsFile = is_writable($magratheaConfig."/magrathea_objects.conf");
$magratheaModels = realpath($site_path."/Models");
$magratheaModels_ok  = is_writeable($magratheaModels);
$magratheaModelsBase = realpath($site_path."/Models/Base");
$magratheaModelsBase_ok  = is_writeable($magratheaModelsBase);
$magratheaControls = realpath($site_path."/Controls");

$css_compressed = realpath($site_path."/".MagratheaView::Instance()->GetCompressedPathCss());
$css_compressed_ok  = is_writeable($css_compressed);
$js_compressed = realpath($site_path."/".MagratheaView::Instance()->GetCompressedPathJs());
$js_compressed_ok  = is_writeable($js_compressed);

$plugins_path = realpath($site_path."/plugins");
$plugins_path_ok  = is_writeable($plugins_path);

$smarty = MagratheaController::GetSmarty();
//p_r($smarty);
$smarty_templatedir = realpath($smarty->joined_template_dir);
$smarty_configsdir = realpath($smarty->joined_config_dir);
$smarty_cachedir = realpath($smarty->cache_dir);
$smarty_cachedir_ok  = is_writeable($smarty_cachedir);
$smarty_compiledir = realpath($smarty->compile_dir);
$smarty_compiledir_ok  = is_writeable($smarty_compiledir);


function printError($url=null){
	$error = '<i class="fa fa-times-circle" title="url not found"></i>';
	if(!empty($url))
		$error .= " url not found: [".$url."]";
	return $error;
}
$writePerm = '<i class="fa fa-pencil-square perm" title="write permission required"></i>';
$developPerm = '<i class="fa fa-code perm" title="write permission is for development mode"></i>';

?>

<style>
.perm {
	color: blue;
}
.fa-check-circle {
	color: green;
}
.fa-times-circle {
	color: red;
}
</style>

<div class="row-fluid">
	<div class="span12 mag_section">
		<header>
			<span class="breadc">Validating...</span>
		</header>
		<content>
			<div class='row-fluid'><div class='span12 center'>
				<table class="table table-striped"><tbody>
					<thead>
						<th>&nbsp;</th>
						<th>Path</th>
						<th>Permissions</th>
					</thead>
					<tr>
						<td><b>Magrathea Path</b></td>
						<td><?=($magrathea_path ? $magrathea_path : printError())?></td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td><b>Site Path</b></td>
						<td><?=($site_path ? $site_path : printError(MagratheaConfig::Instance()->GetFromDefault("site_path")))?></td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td><b>Plugins Path</b></td>
						<td><?=($plugins_path ? $plugins_path : printError())?></td>
						<td>
							<?=$writePerm?> <?=$developPerm?>
							&nbsp;&nbsp;
							<i class="fa fa-<?=($plugins_path_ok ? "check" : "times")?>-circle"></i>
						</td>
					</tr>
					<tr>
						<td><b>Magrathea Configs</b></td>
						<td><?=($magratheaConfig ? $magratheaConfig : printError($site_path."/Configs"))?></td>
						<td>
							<?=$writePerm?> <?=$developPerm?>
							&nbsp;&nbsp;
							<i class="fa fa-<?=($magratheaConfig_ok ? "check" : "times")?>-circle"></i>
						</td>
					</tr>
					<tr>
						<td><b>Magrathea Configs File</b></td>
						<td><?=($magratheaConfigFile ? $site_path."/Configs/magrathea.conf file" : $site_path."/Configs/magrathea.conf file don't exist or not writable")?></td>
						<td>
							<?=$writePerm?> <?=$developPerm?>
							&nbsp;&nbsp;
							<i class="fa fa-<?=($magratheaConfigFile ? "check" : "times")?>-circle"></i>
						</td>
					</tr>
					<tr>
						<td><b>Magrathea Configs Object File</b></td>
						<td><?=($magratheaConfigObjectsFile ? $site_path."/Configs/magrathea_objects.conf file" : $site_path."/Configs/magrathea_objects.conf file don't exist or not writable")?></td>
						<td>
							<?=$writePerm?> <?=$developPerm?>
							&nbsp;&nbsp;
							<i class="fa fa-<?=($magratheaConfigObjectsFile ? "check" : "times")?>-circle"></i>
						</td>
					</tr>
					<tr>
						<td><b>Magrathea Models</b></td>
						<td><?=($magratheaModels ? $magratheaModels : printError($site_path."/Models"))?></td>
						<td>
							<?=$writePerm?> <?=$developPerm?>
							&nbsp;&nbsp;
							<i class="fa fa-<?=($magratheaModels_ok ? "check" : "times")?>-circle"></i>
						</td>
					</tr>
					<tr>
						<td><b>Magrathea Models (Base)</b></td>
						<td><?=($magratheaModelsBase ? $magratheaModelsBase : printError($site_path."/Models/Base"))?></td>
						<td>
							<?=$writePerm?> <?=$developPerm?>
							&nbsp;&nbsp;
							<i class="fa fa-<?=($magratheaModelsBase_ok ? "check" : "times")?>-circle"></i>
						</td>
					</tr>
					<tr>
						<td><b>Magrathea Controls</b></td>
						<td><?=($magratheaControls ? $magratheaControls : printError($site_path."/Controls"))?></td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td><b>Smarty: Templates Directory</b></td>
						<td><?=($smarty_templatedir ? $smarty_templatedir : printError())?></td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td><b>Smarty: Configs Directory</b></td>
						<td><?=($smarty_configsdir ? $smarty_configsdir : printError())?></td>
						<td>
							<?=$writePerm?> <?=$developPerm?>
							&nbsp;&nbsp;
							<i class="fa fa-<?=($magratheaConfig_ok ? "check" : "times")?>-circle"></i>
						</td>
					</tr>
					<tr>
						<td><b>Smarty: Cache Directory</b></td>
						<td><?=($smarty_cachedir ? $smarty_cachedir : printError())?></td>
						<td>
							<?=$writePerm?>
							&nbsp;&nbsp;
							<i class="fa fa-<?=($smarty_cachedir_ok ? "check" : "times")?>-circle"></i>
						</td>
					</tr>
					<tr>
						<td><b>Smarty: Compile Directory</b></td>
						<td><?=($smarty_compiledir ? $smarty_compiledir : printError())?></td>
						<td>
							<?=$writePerm?>
							&nbsp;&nbsp;
							<i class="fa fa-<?=($smarty_compiledir_ok ? "check" : "times")?>-circle"></i>
						</td>
					</tr>
					<tr>
						<td><b>CSS Compression Path</b></td>
						<td><?=($css_compressed ? $css_compressed : printError())?></td>
						<td>
							<?=$writePerm?>
							&nbsp;&nbsp;
							<i class="fa fa-<?=($css_compressed_ok ? "check" : "times")?>-circle"></i>
						</td>
					</tr>
					<tr>
						<td><b>JS Compression Path</b></td>
						<td><?=($js_compressed ? $js_compressed : printError())?></td>
						<td>
							<?=$writePerm?>
							&nbsp;&nbsp;
							<i class="fa fa-<?=($js_compressed_ok ? "check" : "times")?>-circle"></i>
						</td>
					</tr>
				</tbody></table>
			</div></div>
		</content>
	</div>
</div>
