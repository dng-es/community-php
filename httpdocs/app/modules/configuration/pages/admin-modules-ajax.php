<?php
$base_dir = str_replace(((strrpos( __DIR__ , "\\" ) === false) ? 'modules/configuration/pages' : 'modules\\configuration\\pages'), '', realpath(dirname(__FILE__)));
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/classes/class.users.php");
session::ValidateSessionAjax();
$users = new users();
$canales = $users->getCanales(" AND canal<>'admin' AND visible=1 ");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<link rel="stylesheet" type="text/css" href="<?php echo $ini_conf['SiteUrl'];?>/themes/<?php echo $_SESSION['user_theme'];?>/css/styles.css" />
		<script type="text/javascript" src="js/main.min.js"></script>
		<script type="text/javascript" src="js/jquery.numeric.js"></script>
		<script src="<?php echo getAsset("configuration");?>js/admin-modules-ajax.js"></script>
	</head>
	<body>

	<?php
	if (isset($_REQUEST['module']) && $_REQUEST['module'] != ""){
		$module_config = getModuleConfig($_REQUEST['module']);?>
		<form method="post" action="" role="form" class="form-horizontal" name="configForm" id="configForm">
		<?php if (isset($module_config['options']) || isset($module_config['channels'])): ?>
			<input type="hidden" name="modulename" id="modulename" value="<?php echo $_REQUEST['module'];?>" />
			<?php if (isset($module_config['options'])): ?>
			<?php foreach(array_keys($module_config['options']) as $element): ?>
			<div class="form-group">
				<input type="hidden" name="<?php echo $element;?>_typeof" id="<?php echo $element;?>_typeof" value="<?php echo gettype($module_config['options'][$element]);?>" />
				<?php
				$element_name = strTranslate(strtolower($element));
				switch (gettype($module_config['options'][$element])) {
					case 'boolean':
						?>
						<div class="col-sm-offset-4 col-sm-8">
							<div class="checkbox checkbox-primary">>
								<input class="styled" id="<?php echo $element;?>" name="<?php echo $element;?>" type="checkbox" <?php echo ($module_config['options'][$element] === true ? ' checked="checked" ' : ' data-d="no" ');?> /> 
								<label for="<?php echo $element;?>"><?php echo $element_name;?></label>
							</div>
						</div>

						<?php
						break;
					
					case 'integer':
						?>
						<label for="<?php echo $element;?>" class="col-sm-4 control-label"><?php echo $element_name;?></label>
						<div class="col-sm-3">
							<input class="form-control numeric" type="text" name="<?php echo $element;?>" id="<?php echo $element;?>" required value="<?php echo $module_config['options'][$element];?>">
						</div>
						<?php
						break;
					case 'double':
						?>
						<label for="<?php echo $element;?>" class="col-sm-4 control-label"><?php echo $element_name;?></label>
						<div class="col-sm-3">
							<input class="form-control double" type="text" name="<?php echo $element;?>" id="<?php echo $element;?>" required value="<?php echo $module_config['options'][$element];?>">
						</div>
						<?php
						break;
					default:
						?>
						<label for="<?php echo $element;?>" class="col-sm-4 control-label"><?php echo $element_name;?></label>
						<div class="col-sm-8">
							<input class="form-control" type="text" name="<?php echo $element;?>" id="<?php echo $element;?>" required value="<?php echo $module_config['options'][$element];?>">
						</div>
						<?php
						break;
				}
				?>
			</div>
			<?php endforeach;?>
			<?php endif;?>
				
		<?php endif;?>

		<?php if (isset($module_config['channels'])):
		$k = 1;
		?>
		<hr />
		<h3 class="text-center"><?php e_strTranslate("Channels");?></h3>
		<p class="text-center text-muted">Canales activos 
		<?php foreach($canales as $canal):?>
		- <span class="text-primary"><?php echo $canal['canal'];?></span>
		<?php endforeach;?>
		<br />Introduce los canales en cada grupo separados por coma.</p>
		<?php foreach($canales as $canal):?>
		<div class="form-group">
			<label for="group<?php echo $k;?>" class="col-sm-4 control-label"><?php e_strTranslate("Group").$k;?></label>
			<div class="col-sm-5">
				<input class="form-control" type="text" name="group<?php echo $k;?>_channel" id="group<?php echo $k;?>_channel" value="<?php echo isset($module_config['channels']['group'.$k]) ? $module_config['channels']['group'.$k] : '';?>">
			</div>
		</div>
		<?php $k++;?>
		<?php endforeach;?>

		<?php endif;?>
			<div class="modal-footer">
				<div id="configForm-result" class="pull-left"></div>
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php e_strTranslate("Close");?></button>
				<button type="submit" class="btn btn-primary pull-right"><?php e_strTranslate("Save");?></button>
			</div>
		</form>
	<?php }?>
	</body>
</html>