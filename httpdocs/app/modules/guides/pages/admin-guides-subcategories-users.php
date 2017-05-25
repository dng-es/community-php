<?php 
//EXPORT USERS DATA
guidesController::exportUsersListAction();
?>
<div class="row row-top">
	<div class="app-main">
		<?php 
		menu::breadcrumb(array(
			array("ItemLabel"=>strTranslate("Home"), "ItemUrl"=>"home"),
			array("ItemLabel"=>strTranslate("Administration"), "ItemUrl"=>"admin"),
			array("ItemLabel"=>strTranslate("Guides"), "ItemUrl"=>"admin-guides"),
			array("ItemLabel"=>strTranslate("Guides_subcategories_users"), "ItemClass"=>"active"),
		));

		session::getFlashMessage( 'actions_message' );
		$elements = guidesController::getListSubCategoriesUsersAction(10, "");
		?>
		<div class="panel panel-default">
			<div class="panel-body">
				<ul class="nav nav-pills navbar-default">
					<li class="disabled"><a href="#"><?php e_strTranslate("Total");?> <b><?php echo $elements['total_reg'];?></b> <?php echo strtolower(strTranslate("Items"));?></a></li>
					<li><a href="<?php echo $_REQUEST['page'].'?export=true';?>"><?php e_strTranslate("Export");?></a></li>
					<div class="pull-right">
						<?php echo SearchForm($elements['reg'],"admin-guides-subcategories-users","searchForm",strTranslate("Search"), strTranslate("Search"),"","navbar-form navbar-left");?>	
					</div>
				</ul>

				<div class="table-responsive">
					<table class="table table-striped table-hover">
					<tr>
					<th width="40px">&nbsp;</th>
					<th><?php e_strTranslate("User");?></th>
					<th><?php e_strTranslate("Guide");?></th>
					<th><?php e_strTranslate("Category");?></th>
					<th><?php e_strTranslate("Type");?></th>
					<th><?php e_strTranslate("Like");?></th>
					<th><?php e_strTranslate("Comment");?></th>
					</tr>
					<?php foreach($elements['items'] as $element): ?>
					<tr>
						<td nowrap="nowrap">


						</td>
						<td>
							<?php echo $element['user_guide'];?><br />
							<small class="text-muted"><?php echo getDateFormat($element['date_user_guide'], 'LONG');?></small>
						</td>
						<td><?php echo $element['name_guide'];?></td>
						<td><?php echo $element['name_guide_category'];?></td>
						<td><?php echo $element['name_guide_subcategory_type'];?></td>
						<td>
							<span class="label<?php echo ($element['user_guide_like'] == 1 ? " label-success" : " label-danger");?>"><?php echo ($element['user_guide_like'] == 0 ? strTranslate("App_No") : strTranslate("App_Yes"));?></span>
						</td>
						<td><?php echo $element['user_guide_comment'];?></td>
					</tr>
					<?php endforeach; ?>
					</table>
				</div>
				<?php Paginator($elements['pag'], $elements['reg'], $elements['total_reg'], $_REQUEST['page'], '', $elements['find_reg']);?>
			</div>
		</div>
	</div>
	<?php menu::adminMenu();?>
</div>