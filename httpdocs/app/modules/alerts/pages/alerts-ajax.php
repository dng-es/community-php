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
$filtro = " AND activa=1 AND ('".date("Y-m-d")."' BETWEEN date_ini AND date_fin) AND ((type_alert='user' AND destination_alert LIKE '%".$_SESSION['user_name'].",%') OR (type_alert='group' AND destination_alert LIKE '%".$_SESSION['user_empresa'].",%')) ORDER BY priority, date_alert";

$messages_group = $alerts->getAlerts($filtro);
?>
<div id="messagesGroup"> 
<a class="pull-right text-danger" href="alerts-calendar" style="margin-top: 10px"><i class="fa fa-2x fa-calendar"></i></a>
	<h5><?php e_strTranslate("MOD_Alert_today");?></h5>
	<?php if (count($messages_group) > 0):?>
	<ul class="list-unstyled">
		<?php foreach($messages_group as $message_group):?>
		<li>
			<span class="<?php echo $message_group['priority'];?>"></span>
			<a class="text-muted" href="alerts-calendar?y=<?php echo getDateFormat($message_group['date_ini'], 'YEAR');?>&m=<?php echo getDateFormat($message_group['date_ini'], 'MONTH');?>&d=<?php echo getDateFormat($message_group['date_ini'], 'DAY');?>"><?php echo $message_group['title_alert'];?></a>
		</li>
		<?php endforeach;?>
	</ul>
	<?php else:?>
		<?php e_strTranslate("MOD_Alert_today_no");?>
	<?php endif;?>
</div>