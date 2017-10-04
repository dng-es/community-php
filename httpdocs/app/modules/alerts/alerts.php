<?php
/**
* @Manage alerts
* @author Imagar Informatica SL
* @copyright 2010 Grass Roots Spain
* @version 0.9
*
*/
class alertsCore {
	/**
	 * Elementos para el menu de administración
	 * @return 	array           			Array con datos
	 */
	public static function adminMenu(){
		return array(
			menu::addAdminMenu(array(
				"PageName" => "admin-alerts",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("MOD_Alerts"),
				"LabelItem" => strTranslate("MOD_Alert_list"),
				"LabelUrl" => "admin-alerts",
				"LabelPos" => 1,
			)),
			menu::addAdminMenu(array(
				"PageName" => "admin-alerts-types",
				"LabelHeader" => "Modules",
				"LabelSection" => strTranslate("MOD_Alerts"),
				"LabelItem" => strTranslate("MOD_Alert_types"),
				"LabelUrl" => "admin-alerts-types",
				"LabelPos" => 2,
			))
		);
	}

	public static function userAlerts(){
		addJavascript(getAsset("alerts")."js/alerts.js");
		templateload("panels", "alerts");
		panelAlerts();
	}

	public static function moduleHooks(){
		add_hook('home', 'sidebar', 'alertsCore::userAlerts', 2);
		add_hook('group', 'sidebar', 'alertsCore::userAlerts', 2);
		add_hook('profile', 'sidebar', 'alertsCore::userAlerts', 2);
	}

	public static function searchMain($string){
		$result = array();
		$alerts = new alerts();
		//buscar en alertas
		$filtro = " AND activa=1 AND ((type_alert='user' AND destination_alert LIKE '%".$_SESSION['user_name'].",%') OR (type_alert='group' AND destination_alert LIKE '%".$_SESSION['user_empresa'].",%')) ORDER BY priority, date_alert";
		$request = $alerts->getAlerts(" AND (MATCH(title_alert) AGAINST ('".$string."') OR MATCH(text_alert) AGAINST ('".$string."')) ".$filtro);
		foreach ($request as $req):
			$year_ini = getDateFormat($req['date_ini'], 'YEAR');
			$month_ini = getDateFormat($req['date_ini'], 'MONTH');
			$day_ini = getDateFormat($req['date_ini'], 'DAY');
			array_push($result, array(
				"title"=>$req['title_alert'], 
				"description"=>$req['text_alert'], 
				"url"=>"alerts-calendar?search=".$string."&y=".$year_ini."&m=".$month_ini."&d=".$day_ini,
				"type" => strTranslate("MOD_Alerts"),
				"order" => 7
			));
		endforeach;

		if (strtolower($string) == strtolower(strTranslate("MOD_Alerts"))){
			array_push($result, array(
				"title"=>'<i class="fa fa-list"></i> '.strTranslate("MOD_Alerts"), 
				"description"=>strTranslate("Info_Documents_Text"), 
				"url"=>"alerts-calendar",
				"type" => strTranslate("MOD_Alerts"),
				"order" => 6
			));
		}

		return $result;
	}
}
?>