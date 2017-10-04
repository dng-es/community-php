<?php
$base_dir = str_replace(((strrpos( __DIR__ , "\\" ) === false) ? 'modules/core/pages' : 'modules\\core\\pages'), '', realpath(dirname(__FILE__)));
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/class.session.php");

session::ValidateSessionAjax();
		

$result = array();
$string = sanitizeInput($_REQUEST['search']);
$mod = ((isset($_REQUEST['mod']) && $_REQUEST['mod'] != "") ? trim(sanitizeInput($_REQUEST['mod'])) : "");
$mod_array = explode("-", $mod);
$modules = getListModules();
// echo "M: ".$mod."<br />";
// var_dump($mod_array);
//var_dump($modules);
foreach($modules as $module):
	if ($mod == "" || $mod == "null" || in_array($module['folder'], $mod_array)):
		if (file_exists(__DIR__."/../../".$module['folder']."/".$module['folder'].".php")):
			include_once (__DIR__."/../../".$module['folder']."/".$module['folder'].".php");
			$moduleClass = $module['folder']."Core";
			$instance = new $moduleClass();
			if (method_exists($instance, "searchMain")) $result = array_merge($result, $instance->searchMain($string));
		endif;
	endif;
endforeach;
$result = arraySort($result, 'order', SORT_ASC);
$num_results = count($result);
?>

<?php if($num_results == 0):?>
<h2 class="text-center text-danger">
	<?php e_strTranslate("No se han encontrado resultados");?>
</h2>
<?php else:?>
<p class="text-right">
	<?php e_strTranslate("Search_results");?>: <b><?php echo $num_results;?></b> <?php echo strtolower(strTranslate("Items"));?>
</p>
<?php endif;?>


<?php foreach($result as $res):?>
	<div class="panel panel-default">
		<div class="panel-body">
			<small class="pull-right text-muted"><i class="fa fa-list"></i> <?php echo $res['type'];?></small>
			<h4>
				<a href="<?php echo $res['url'];?>"><?php echo $res['title'];?></a> 
			</h4>
			<p><?php echo strip_tags(get_resume($res['description']));?></p>
		</div>
	</div>
<?php endforeach;?>