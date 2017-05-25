<?php
$base_dir = str_replace(((strrpos( __DIR__ , "\\" ) === false) ? 'modules/guides/pages' : 'modules\\guides\\pages'), '', realpath(dirname(__FILE__)));
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/guides/classes/class.guides.php");
session::ValidateSessionAjax();

if(isset($_POST['id_guide_users']) && $_POST['id_guide_users']>0){
	echo guidesController::updateSubCategoryUserAction();
} else {
	echo guidesController::createSubCategoryUserAction();
}

if (isset($_REQUEST['tipo_guia'])):
	$usuario_tipo_guia = $_REQUEST['tipo_guia'];
	$filtro = " AND type_guide='".$usuario_tipo_guia."' ";
	$elements = guidesController::getListAction(15, $filtro);
	?>
	<div class="row">
		<h4 class="">
			<span class="fa-stack fa-lg text-muted">
				<i class="fa fa-circle fa-stack-2x"></i>
				<i class="fa fa-comments fa-stack-1x fa-inverse"></i>
			</span>
			<?php e_strTranslate("Contact_habits"); ?>
		</h4>
		<?php foreach($elements['items'] as $element): ?>
			<div class="col-md-4 col-sm-12 col-xs-12 m-t-30">
				<button data-guide="<?php echo $element['id_guide']; ?>" id="guide_<?php echo $element['type_guide']; ?>_<?php echo $element['id_guide']; ?>" class="btn btn-block btn-primary category "><h4><?php echo $element['name_guide']; ?></h4></button>
				<div class="angle col-md-12 h-d invisible"></div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif;

if (isset($_POST['guide']) && $_POST['guide'] != ""):
	$guides = new guides();
	$filter_guide = " AND c.id_guide='".$_POST['guide']."' ";
	$categories = $guides->getGuidesCategories($filter_guide);
	?>
	<div class="row">
		<?php foreach($categories as $category): ?>
			<div class="col-md-4 col-sm-12 col-xs-12 m-t-30">
				<button data-guide="<?php echo $category['id_guide']; ?>" data-category="<?php echo $category['id_guide_category']; ?>" class="btn btn-block btn-info category2 " id="category_<?php echo $category['id_guide']; ?>_<?php echo $category['id_guide_category']; ?>"><h4><?php echo $category['name_guide_category']; ?></h4></button>
				<div class="angle-2 col-md-12 h-d-2 invisible"></div>
			</div>
		<?php endforeach; ?>
	</div>

	<?php
endif;

if (isset($_POST['category']) && $_POST['category'] != ""):
	$guides = new guides();
	$filter_category = " AND s.id_guide_category='".$_POST['category']."' ";
	$subcategories = $guides->getGuidesSubCategories($filter_category);
	$module_config = getModuleConfig("guides");
	$user_can_modify = $module_config['options']['user_can_modify'];
	?>
	<div class="row">
	<?php foreach($subcategories as $subcategory): ?>
		<div class="col-md-4 col-sm-12 col-xs-12 m-t-30">
			<h4 class="inset subcategory-type"><i class="fa fa-<?php echo $subcategory['icon_guide_subcategory_type']; ?>"></i> <?php echo $subcategory['name_guide_subcategory_type']; ?></h4>

			<?php echo $subcategory['desc_guide_subcategory']; ?>
		</div>
	<?php endforeach; ?>
	</div>

	<div class="row">
	<?php foreach($subcategories as $subcategory): ?>
		<?php
		$filter_subcategory_user = " AND ug.id_guide_subcategory='".$subcategory['id_guide_subcategory']."' AND ug.user_guide='".$_SESSION['user_name']."' ";
		$subcategory_user = $guides->getGuidesSubCategoriesUsers($filter_subcategory_user);
		?>
		<div class="col-md-4 col-sm-12 col-xs-12">
			<hr>
			<h5 class="">
				<span class="fa-stack text-muted">
					<i class="fa fa-circle fa-stack-2x"></i>
					<i class="fa fa-comment fa-stack-1x fa-inverse"></i>
				</span>
				<?php e_strTranslate("Do_like"); ?>
				&bull;
				<small class="text-muted">
					<?php echo $subcategory['name_guide_subcategory_type']; ?>
				</small>
			</h5>
			<p class="text-muted m-b-10">
				<em><?php e_strTranslate("Guide_Comments"); ?></em>
			</p>
			<form action="" id="subcategory_<?php echo $subcategory['id_guide_subcategory']; ?>" role="form" class="form_subcategory">
				<input type="hidden" name="id_guide_users" value="<?php echo count($subcategory_user)==0 ? 0 : $subcategory_user[0]['id_guide_users']; ?>">
				<input type="hidden" name="id_guide_subcategory" value="<?php echo $subcategory['id_guide_subcategory']; ?>">
				<input type="hidden" class="user_can_modify" name="user_can_modify" value="<?php echo $user_can_modify; ?>">
				<div class="radio radio-inline radio-danger">
					<input type="radio" name="user_guide_like" value="0" <?php echo (isset($subcategory_user[0]['id_guide_users']) && $subcategory_user[0]['user_guide_like']==0) ?' checked="checked"' : '' ?> id="no_subcategory_<?php echo $subcategory['id_guide_subcategory']; ?>"><label class="text-color"><?php e_strTranslate("App_No"); ?></label>
				</div>
				<div class="radio radio-inline radio-success">
					<input type="radio" name="user_guide_like" value="1" <?php echo (isset($subcategory_user[0]['id_guide_users']) && $subcategory_user[0]['user_guide_like']==1) ?' checked="checked"' : '' ?> id="yes_subcategory_<?php echo $subcategory['id_guide_subcategory']; ?>"><label class="text-color"><?php e_strTranslate("App_Yes"); ?></label>
				</div>
				<div class="alert alert-danger m-t-10" id="asubcategory_<?php echo $subcategory['id_guide_subcategory']; ?>"><?php echo e_strTranslate("Select_an_option"); ?></div>
				<div class="form-group m-t-10">
					<textarea class="form-control guia_comentario" rows="5" name="user_guide_comment"><?php echo $subcategory_user[0]['user_guide_comment']; ?></textarea>
				</div>
				<?php if(!isset($subcategory_user[0]['id_guide_users']) || $user_can_modify == true): ?>
				<button data-guide="<?php echo $subcategory['id_guide']; ?>" data-category="<?php echo $subcategory['id_guide_category']; ?>" data-subcategory="<?php echo $subcategory['id_guide_subcategory']; ?>" class="btn btn-block btn-info subcategory " id="bsubcategory_<?php echo $subcategory['id_guide_subcategory'];?>"><?php echo e_strTranslate("Save"); ?></button>
				<?php endif; ?>
			</form>
		</div>
	<?php endforeach; ?>
	</div>
<?php
endif;
?>