<?php
include_once ("functions.core.php");

//Get requested page. If not requested page get default page
$page = (isset($_REQUEST['page']) && $_REQUEST['page'] != "") ? $_REQUEST['page'] : APP_DEF_PAGE;

//Logut session
if ($page == 'logout') session::destroySession();

//Login session
$session = new session();
$session->validateUserSession();
$user_permissions = $session->user_permissions;

//Underconstruction
if ($ini_conf['underconstruction'] == true && ($page != "underconstruction" && $page != "login") && $_SESSION['user_perfil'] != 'admin') session::destroySession("underconstruction");

//Load modules
$array_usermenu = array();
$array_adminmenu = array();
$hook_sidebar_rigth = "";
$modules_data = array();
$modules = getListModules();
foreach($modules as $module):	
	if (file_exists(__DIR__."/../modules/".$module['folder']."/".$module['folder'].".php")):
		include_once (__DIR__."/../modules/".$module['folder']."/".$module['folder'].".php");
		$moduleClass = $module['folder']."Core";
		if (isset($_SESSION['user_logged']) and $_SESSION['user_logged'] == true):
			$instance = new $moduleClass();

			if (file_exists(__DIR__."/../modules/".$module['folder']."/config.yaml")):
				$module_config = getModuleConfig($module['folder']);
				if (isset($module_config['options']['show_user_menu']) && $module_config['options']['show_user_menu'] == true):
					if (method_exists($instance, "userMenu")):
						$menu_order = (isset($module_config['options']['user_menu_position']) ? $module_config['options']['user_menu_position'] : 1);
						$array_usermenu = array_merge($array_usermenu, $instance->userMenu($menu_order));
					endif;
				endif;
				
				if (isset($module_config['options']['show_user_points'])) $_SESSION['show_user_points'] = $module_config['options']['show_user_points'];
			
			endif;

			if (method_exists($instance, "adminMenu")) 
				$array_adminmenu = array_merge($array_adminmenu, $instance->adminMenu());

			//sidebar-right hooks
			if (method_exists($instance, "moduleHooks")){
				$instance->moduleHooks();
			}
		endif;
		array_push($modules_data, array("name" => $module['folder']));
	endif;	
endforeach;
?>