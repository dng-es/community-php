<?php
/**
* @Modulo de emociones
* @author Imagar Informatica SL
* @copyright 2010 Grass Roots Spain
* @version  1.0.2
*
*/
class emocionesCore{
	/**
	 * Elementos para el menu de usuarios
	 * @return 	array           			Array con los elementos del menu
	 */
	public static function userMenu($menu_order){
		global $session;
		$array_final = array();
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("emociones", $_SESSION['user_name']));
		if ($session->checkPageViewPermission("emociones", $_SESSION['user_perfil'], $user_permissions)){
			array_push($array_final, array(
				"LabelIcon" => "fa fa-smile-o",
				"LabelItem" => strTranslate("Emotions"),
				"LabelUrl" => 'emociones',
				"LabelTarget" => '_self',
				"LabelPos" => $menu_order));
		}

		return $array_final;
	}

	/**
	 * Elementos para el menu de administración
	 * @return 	array           			Array con datos
	 */
	public static function adminMenu(){
		$elems = array();

		array_push($elems, menu::addAdminMenu(array(
			"PageName" => "admin-emociones",
			"LabelHeader" => "Modules",
			"LabelSection" => strTranslate("Emotions"),
			"LabelItem" => strTranslate("Emotions_list"),
			"LabelUrl" => "admin-emociones",
			"LabelPos" => 1,
		)));

		array_push($elems, menu::addAdminMenu(array(
			"PageName" => "admin-emociones-users",
			"LabelHeader" => "Modules",
			"LabelSection" => strTranslate("Emotions"),
			"LabelItem" => "Emociones de los usuarios",
			"LabelUrl" => "admin-emociones-users",
			"LabelPos" => 2,
		)));

		return $elems;
	}

	public static function addMenuItem(){
		//mostrar alerta si no ha metido emociones hoy
		if (connection::countReg("emociones_user"," AND user_emocion='".$_SESSION['user_name']."' AND DATE(date_emocion)=DATE(NOW())") == 0):
		?>
		<script>
		jQuery(document).ready(function(){
			showEmitionQuestion();

			$(window).resize(function(){
				showEmitionQuestion();
			});

			function showEmitionQuestion(){
				var anchoVentana = $(document).width();
				if (anchoVentana > 991) $('#emociones-btn').popover('show');
				else $('#emociones-btn').popover('destroy');
			}
		});
		</script>
		<?php endif;?>
		<a href="emociones-home" id="emociones-btn" data-container="body" data-placement="bottom" data-toggle="popover" data-content="<?php e_strTranslate("Emotions_question");?>"><img src="images/emociones/default.png" class="user-info-icon faa-tada animated-hover"></a>
	<?php }

	public static function moduleHooks(){
		add_hook('', 'header', 'emocionesCore::addMenuItem', 1);
	}
}
?>