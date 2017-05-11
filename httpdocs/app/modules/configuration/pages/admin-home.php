<?php
addCss(array(getAsset("configuration")."css/admin-home.css"));
addJavascripts(array(getAsset("configuration")."js/admin-home.js",
					"js/jquery-ui.min.js"));

session::getFlashMessage('actions_message');

global $ini_conf;
$temas = FileSystem::showDirFolders(__DIR__."/../../../../themes/");
$theme = (isset($_REQUEST['theme']) ? sanitizeInput($_REQUEST['theme']) : $_SESSION['user_theme']);
$configuration = new configuration();
//$configuration->updatePanels();
$elements_rows = $configuration->getPanelsRows(" AND page_name='home' AND panel_visible=1 AND page_theme='".$theme."' ORDER BY panel_row ");
$tot_panels = connection::countReg("config_panels"," AND page_name='home' AND page_theme='' ");
$ocultos = $configuration->getPanels(" AND page_name='home' AND page_theme='' AND panel_name NOT IN(SELECT panel_name FROM config_panels WHERE page_name='home' AND page_theme='".$theme."') ORDER BY panel_name");

$i = 1;
$j = 1;
?>
<div class="row row-top">
	<div class="app-main">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Configuration"), "ItemUrl"=>"#"),
			array("ItemLabel"=>strTranslate("Home"), "ItemClass"=>"active"),
		));?>

		<style type="text/css">
		/* show the move cursor as the user moves the mouse over the panel header.*/
		.draggableContainer .panel-heading {
		   cursor: move;
		}

		.draggableContainer .row {
			border: 1px dashed #ccc;
			display: block;
			margin-bottom: 15px;
			min-height: 100px;
			padding: 15px;
			border-bottom-left-radius: 4px;
			border-bottom-right-radius: 4px;
		}

		.draggablePanelList{
			background-color: rgba(255, 255, 255, 0.85);
		}

		.draggablePanelListHeader{
			background-color: rgba(249, 249, 249, 0.85);
			border-bottom: 0 !important;
			border-left: 1px dashed #ccc;
			border-right: 1px dashed #ccc;
			border-top: 1px dashed #ccc;
			border-top-left-radius: 4px;
			border-top-right-radius: 4px;
			color: #999;
			cursor: move;
			min-height: 45px !important;
			margin-bottom: 0 !important;
			padding: 5px 10px 5px 5px !important;
		}

		.panelsInfo{
			background-color: #f0f0f0;
		}
		</style>

		<div class="row panel">
			<div class="col-md-2 full-height panelsInfo">
				<h4 class="text-primary"><?php e_strTranslate("Theme");?></h4>
				<select name="chooseTheme" id="chooseTheme" class="form-control">
					<?php foreach($temas as $tema): ?>
						<option <?php echo ($tema == $theme ? ' selected="selected" ' : "");?> value="<?php echo $tema;?>"><?php echo $tema;?></option>
					<?php endforeach; ?>
				</select>
				<br />
				<h4 class="text-primary">Paneles disponibles</h4>
				<ul id="lista-invisibles" class="list-funny text-muted">
					<?php foreach($ocultos as $oculto): ?>
						<li class="ellipsis" id="oculto-<?php echo $oculto['panel_name'];?>"><?php echo $oculto['panel_name'];?>
					<?php endforeach; ?>
				</ul>
				<br />
			</div>		

			<br />
			<div id="" class="row">
				<div id="" class="col-md-8">
					<h2>Diseño Home</h2>
					<p class="text-muted">Agrega filas e incluye paneles en cada una de ellas, puedes agregar tantas como quieras. Puedes mover las filas y paneles arrastrándolos.</p>
					<div class="btn-group" role="group" aria-label="...">
						<button  type="button" class="btn btn-info" id="saveTemplate"><i class="fa fa-save"></i> Guardar cambios</button>
						<button  type="button" class="btn btn-warning" id="initTemplate" onClick="location.href='<?php echo $_SERVER['REQUEST_URI'];?>'"><i class="fa fa-refresh"></i> Reiniciar cambios</button>
						<button  type="button" class="btn btn-default" id="addRow"><i class="fa fa-long-arrow-right"></i> Agregar fila</button>
					</div>
				</div>
				<div id="" class="col-md-4" style="position: relative">
					<div style="position: absolute;width: 256px; height: 144px; top: 0px; left: 0px;z-index:2"></div>
					<div class="mini-preview-wrapper" style="width: 256px; height: 144px; top: 0px; left: 0px;z-index:1">
						<iframe id="homePreview" src="<?php echo $ini_conf['SiteUrl']."/home_new?theme=".$theme;?>" style="width: 400%; height: 400%; transform: scale(0.25); transform-origin: 0 0; background-color: rgb(255, 255, 255);"></iframe>
					</div>
				</div>
			</div>
			<div class="row inset draggableContainer">
				<?php foreach($elements_rows as $element_row):
					$elements = $configuration->getPanels(" AND panel_row=".$element_row['rows']." AND page_name='home' AND page_theme='".$theme."' ORDER BY panel_pos ");
					createFilaPage($elements, $j, true);
					$j++;
				endforeach; ?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu(); ?>
</div>


<div id="container-invisibles">
	<?php foreach($ocultos as $oculto): ?>
		<?php 
		createPanelPage($i, $oculto, false);
		$i++;?>
	<?php endforeach; ?>
</div>

<div id="container-rows-invisibles">
	<?php 
	//filas ocultas
	for ($k = (count($elements_rows) + 1); $k < $tot_panels; $k++){
		createFilaPage(array(), $k, false);
	}?>
</div>


<?php 

function createFilaPage($elements, $j, $visible = true){
	global $i;
	?>
	<div class="draggablePanelContainer <?php echo ($visible == true ? '' : 'hidden');?>">
		<div class="row draggablePanelListHeader">
			<div class="col-md-4">
				<select class="form-control panelsSelect">
					<option value=""></option>
				</select>
			</div>
			<div class="btn-group" role="group" aria-label="...">
				<button type="button" class="btn btn-success panelPlus pointer" data-row="<?php echo $j;?>"><i class="fa fa-plus-circle"></i> Agregar panel</button>
				<button type="button" class="btn btn-danger pull-right deleteRow"><i class="fa fa-long-arrow-left"></i> Eliminar fila</button>
			</div>
		</div>
		<div class="row draggablePanelList" data-row="<?php echo $j;?>">
		<?php if ($visible == true) :
			foreach($elements as $element): ?>
			<?php createPanelPage($i, $element, true);?>
			<?php $i++;?>
			<?php endforeach;
			endif;
			?>
		</div>	
	</div>		
<?php }

function createPanelPage($i, $element, $visible = true){ ?>	
	<div id="panel_<?php echo $i;?>" class="<?php echo $element['panel_name'];?> container-drop col-md-<?php echo $element['panel_cols'];?> <?php echo ($visible == true ? '' : 'hidden');?>" data-namepanel="<?php echo $element['panel_name'];?>" data-colsn="<?php echo $element['panel_cols'];?>">
		<div class="panel panel-info">
			<div class="panel-heading">

					<div class="btn-group" role="group" aria-label="...">
					<button type="button" class="btn btn-xs btn-default minus" data-dest="#panel_<?php echo $i;?>">-</button>
					<button type="button" class="btn btn-xs btn-default plus" data-dest="#panel_<?php echo $i;?>">+</button>
					</div>

				<span class="text-muted"><?php echo $element['panel_name'];?></span>
				<button type="button" class="pull-right btn btn-xs btn-default minus panelDelete pointer" data-dest="#panel_<?php echo $i;?>"><i class="fa fa-trash"></i></button>
			</div>
			<div class="panel-body">Content ...</div>
		</div>
	</div>		
<?php } ?>