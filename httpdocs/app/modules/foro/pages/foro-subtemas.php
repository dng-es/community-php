<?php
templateload("list","foro");
templateload("paginator","foro");
templateload("addforo","foro");
templateload("search","foro");

$foro = new foro();
$id_tema_parent = "";
$canal = "";
?>
<div class="row row-top">
	<div class="app-main">
		<?php menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Forums"), "ItemClass"=>"active"),
		));?>
		<p><?php e_strTranslate("Forums_title");?></p>
		
		<?php
		session::getFlashMessage( 'actions_message' );
		$module_config = getModuleConfig("foro");
		$reg = $module_config['options']['forums_per_page'];

		$elements = foroController::getListSubTemasAction($reg, " AND activo=1 AND ocio=0 AND id_area=0 ", $module_config);
		foreach($elements['items'] as $element):
			ForoList($element);
		endforeach;
		ForoPaginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], 'temas', $elements['find_reg'], $elements['find_tipo'], $elements['marca']);
		?>

	</div>
	<div class="app-sidebar">
		<div class="panel-interior">
			<?php
			get_hooks('sidebar');

			//BUSCADOR
			ForoSearch($reg, $_REQUEST['page'], $elements['find_reg'], $elements['marca'], $elements['find_tipo']);

			//BANNER CREAR TEMA
			if ($module_config['options']['allow_new'] == true || $_SESSION['user_perfil'] == 'admin') PanelSubirTemaForo($_SESSION['user_canal'] == 'admin');
			?>
		</div>
	</div>
</div>