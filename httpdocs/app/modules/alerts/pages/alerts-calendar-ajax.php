<?php
$base_dir = str_replace(((strrpos( __DIR__ , "\\" ) === false) ? 'modules/alerts/pages' : 'modules\\alerts\\pages'), '', realpath(dirname(__FILE__)));
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/classes/class.configuration.php");
include_once($base_dir . "core/functions.core.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/alerts/classes/class.alerts.php");

session::ValidateSessionAjax();

$alerts = new alerts();
$filtro = " AND activa=1 AND ((type_alert='user' AND destination_alert LIKE '%".$_SESSION['user_name'].",%') OR (type_alert='group' AND destination_alert LIKE '%".$_SESSION['user_empresa'].",%')) ORDER BY priority, date_alert";
$elements = $alerts->getAlerts($filtro);

$result = array();

$i = 0;
foreach($elements as $element):

	$result[$i]['id'] = $element['id_alert'];
    $result[$i]['id_alert_type'] = $element['id_alert_type'];
    $tipoAlerta = $alerts->getAlertsTypes(" AND id_alert_type = ".$result[$i]['id_alert_type']." ");
    $result[$i]['tipo_alerta'] = $tipoAlerta[0]['name_type'];
    $result[$i]['title'] = $element['title_alert'];
    $result[$i]['text_alert'] = $element['text_alert'];
    $result[$i]['type_alert'] = $element['type_alert'];
    $result[$i]['destination_alert'] = $element['destination_alert'];
    $result[$i]['date_alert'] = $element['date_alert'];
    $result[$i]['user_post'] = $element['user_post'];
    $result[$i]['priority'] = $element['priority'];
    $result[$i]['date_ini'] = $element['date_ini'];
    $result[$i]['date_fin'] = $element['date_fin'];
    $result[$i]['time_ini'] = $element['time_ini'];
    $result[$i]['time_fin'] = $element['time_fin'];
    $result[$i]['nombre_archivo'] = $element['nombre_archivo'];
    $result[$i]['activa'] = $element['activa'];
	$result[$i]['name_type'] = $element['name_type'];
    $result[$i]['color'] = $element['color_type'];
  	$result[$i]['textColor'] = 'white';
	$result[$i]['imageurl'] = $element['icon_type'];
    $result[$i]['perfiles_type'] = $element['perfiles_type'];
    $result[$i]['estado_type'] = $element['estado_type'];
    $result[$i]['aprobacion'] = $element['aprobacion'];
    $result[$i]['registro'] = $element['registro'];
    $result[$i]['registro_limite'] = $element['registro_limite'];

	//$result[$i]['url'] = 'www.google.es';
 	$result[$i]['lang'] = 'es';
 	$result[$i]['start'] = $element['date_ini'] ."T". $element['time_ini'];
	$result[$i]['end'] = $element['date_fin'] ."T". $element['time_fin'];

	$i++;

endforeach;

echo json_encode($result);
?>
