<?php
/**
 * Print HTML Foro link. Muestra el enlace para inscribirse o borrarse de las notificaciones de un comtenido
 * @param	Int 		$id 			Id del contenido
 * @return	String						HTML link
 */
function foroNotifications($id){ 
	$module_config = getModuleConfig('foro');
	if ($module_config['options']['show_alarms']):
		$num_notifications =  connection::countReg("notifications_inscriptions"," AND username_inscription='".$_SESSION['user_name']."' AND type_inscription='foro' AND id_content=".$id." ");
		if ($num_notifications > 0):
			$link_action = 0;
			$link_txt = '<i class="fa fa-bell-slash"></i> '.strTranslate("Notifications_noreceive");
		else:
			$link_action = 1;
			$link_txt = '<i class="fa fa-bell"></i> '.strTranslate("Notifications_receive");
		endif;
		?>
		<a href="foro-comentarios?id=<?php echo $id;?>&idn=<?php echo $link_action;?>"><?php echo $link_txt;?></a>
<?php endif;
}

/**
 * Print HTML Video link. Muestra el enlace para inscribirse o borrarse de las notificaciones de un comtenido
 * @param	Int 		$id 			Id del contenido
 * @return	String						HTML link
 */
function videoNotifications($id){ 
	$module_config = getModuleConfig('videos');
	if ($module_config['options']['show_alarms']):
		$num_notifications =  connection::countReg("notifications_inscriptions"," AND username_inscription='".$_SESSION['user_name']."' AND type_inscription='videos' AND id_content=".$id." ");
		if ($num_notifications > 0):
			$link_action = 0;
			$link_txt = '<i class="fa fa-bell-slash"></i> '.strTranslate("Notifications_noreceive");
		else:
			$link_action = 1;
			$link_txt = '<i class="fa fa-bell"></i> '.strTranslate("Notifications_receive");
		endif;
		?>
		<a href="videos?id=<?php echo $id;?>&idn=<?php echo $link_action;?>"><?php echo $link_txt;?></a>
<?php endif;
}

/**
 * Print HTML Photo link. Muestra el enlace para inscribirse o borrarse de las notificaciones de un comtenido
 * @param	Int 		$id 			Id del contenido
 * @return	String						HTML link
 */
function fotoNotifications($id){ 
	$module_config = getModuleConfig('fotos');
	if ($module_config['options']['show_alarms']):
		$num_notifications =  connection::countReg("notifications_inscriptions"," AND username_inscription='".$_SESSION['user_name']."' AND type_inscription='fotos' AND id_content=".$id." ");
		if ($num_notifications > 0):
			$link_action = 0;
			$link_txt = '<i class="fa fa-bell-slash"></i> '.strTranslate("Notifications_noreceive");
		else:
			$link_action = 1;
			$link_txt = '<i class="fa fa-bell"></i> '.strTranslate("Notifications_receive");
		endif;
		?>
		<a href="#" class="triger-notification"  data-msg-out="<?php e_strTranslate("Notifications_noreceive");?>" data-msg-in="<?php e_strTranslate("Notifications_receive");?>" data-idn="<?php echo $id;?>" data-opt="<?php echo $link_action;?>"><?php echo $link_txt;?></a>
<?php endif;
}

/**
 * Print HTML Notification. Muestra las notificaciones generadas en cada modulo
 * @return	String						HTML table
 */
function userNotifications(){ ?>
	<table class="table table-striped">
		<h3><?php e_strTranslate("Notifications");?></h3>
		<?php 
		//ALERTAS DEL MODULO DE FOROS
		if(getModuleExist("foro")):
			$module_config = getModuleConfig("foro");
			if ($module_config['options']['show_alarms']):
				$num_foros = connection::countReg("notifications", " AND username_notification='".$_SESSION['user_name']."' AND type_notification='foro' "); ?>
			<tr>
				<td>
					<a href="#" class="table-open"><i class="fa fa-link"></i> Comentarios en los foros</a>
					<?php if($num_foros > 0): 
					$elements = foroController::getListTemasAction(9999, " AND id_tema IN (SELECT id_content FROM notifications WHERE username_notification='".$_SESSION['user_name']."' AND type_notification='foro')"); ?>
					<div class="table-open-content">
						<ul class="list-funny">
						<?php foreach ($elements['items'] as $key => $element):?>
						<li><small><a class="text-muted" href="foro-comentarios?id=<?php echo $element['id_tema'];?>"><?php echo $element['nombre'];?></a></small></li>
						<?php endforeach; ?>
						</ul>
					</div>
					<?php endif; ?>
				</td>
				<td class="text-right"><span class="badge <?php echo $num_foros > 0 ? 'active' : '';?>"><?php echo $num_foros; ?></span></td>
			</tr>
			<?php endif;?>
		<?php endif;?>

		<?php 
		//ALERTAS DEL MODULO DE VIDEOS
		if(getModuleExist("videos")):
			$module_config = getModuleConfig("videos");
			if ($module_config['options']['show_alarms']):
				$num_videos = connection::countReg("notifications", " AND username_notification='".$_SESSION['user_name']."' AND type_notification='videos' "); ?>
				<tr>
					<td>
						<a href="#" class="table-open"><i class="fa fa-link"></i> Comentarios en los videos</a>
						<?php if($num_videos > 0):
						$elements = videosController::getListAction(9999, " AND id_file IN (SELECT id_content FROM notifications WHERE username_notification='".$_SESSION['user_name']."' AND type_notification='videos')"); ?>
						<div class="table-open-content">
							<ul class="list-funny">
							<?php foreach ($elements['items'] as $key => $element):?>
							<li><small><a class="text-muted" href="videos?id=<?php echo $element['id_file'];?>"><?php echo $element['titulo'];?></a></small></li>
							<?php endforeach; ?>
							</ul>
						</div>
						<?php endif; ?>
					</td>
					<td class="text-right"><span class="badge <?php echo $num_videos > 0 ? 'active' : '';?>"><?php echo $num_videos; ?></span></
				</tr>
			<?php endif;?>
		<?php endif;?>

		<?php 
		//ALERTAS DEL MODULO DE FOTOS
		if(getModuleExist("fotos")):
			$module_config = getModuleConfig("fotos");
			if ($module_config['options']['show_alarms']):
				$num_fotos = connection::countReg("notifications", " AND username_notification='".$_SESSION['user_name']."' AND type_notification='fotos' "); ?>
				<tr>
					<td>
						<a href="#" class="table-open"><i class="fa fa-link"></i> Comentarios en las fotos</a>
						<?php if($num_fotos > 0):
						$elements = fotosController::getListAction(9999, " AND id_file IN (SELECT id_content FROM notifications WHERE username_notification='".$_SESSION['user_name']."' AND type_notification='fotos')"); ?>
						<div class="table-open-content">
							<ul class="list-funny">
							<?php foreach ($elements['items'] as $key => $element):?>
							<li><small><a class="text-muted" href="fotos?id=<?php echo $element['id_album'];?>"><?php echo $element['titulo'];?></a></small></li>
							<?php endforeach; ?>
							</ul>
						</div>
						<?php endif; ?>
					</td>
					<td class="text-right"><span class="badge <?php echo $num_fotos > 0 ? 'active' : '';?>"><?php echo $num_fotos; ?></span></td>
				</tr>
			<?php endif;?>
		<?php endif;?>

		<?php 
		//ALERTAS DEL MODULO DE MENSAJERIA INTERNA
		if(getModuleExist("mensajes")):
			$num_mensajes = connection::countReg("mensajes", " AND user_destinatario='".$_SESSION['user_name']."' AND estado=0 ");?>
			<tr>
				<td><a href="inbox"><i class="fa fa-link"></i> <?php e_strTranslate("Mailing_messages");?></a></td>
				<td class="text-right"><span class="badge <?php echo $num_mensajes > 0 ? 'active' : '';?>"><?php echo $num_mensajes; ?></span></td>
			</tr>
		<?php endif;?>
				
		<?php 
		//ALERTAS DEL MODULO DE BATALLAS
		if(getModuleExist("batallas")):
			$module_config = getModuleConfig("batallas");
			if ($module_config['options']['show_alarms']):
				$batallas_pendientes = batallasController::getPendientes($_SESSION['user_name']);?>
				<tr>
					<td>
						<a href="batallas"><i class="fa fa-link"></i> <?php e_strTranslate("Battles");?></a>
					</td>
					<td class="text-right"><span class="badge <?php echo $batallas_pendientes > 0 ? 'active' : '';?>"><?php echo $batallas_pendientes; ?></span></td>
				</tr>
				<?php endif;?>
		<?php endif;?>

		<?php 
		//ALERTAS DEL MODULO DE INFO
		if(getModuleExist("info")):
			$module_config = getModuleConfig("info");
			if ($module_config['options']['show_alarms']):
				$num_info = infoController::getAlerts(); ?>
				<tr>
					<td>
						<a href="info-all"><i class="fa fa-link"></i> <?php e_strTranslate("Info_Documents");?></a>
					</td>
					<td class="text-right"><span class="badge <?php echo $num_info > 0 ? 'active' : '';?>"><?php echo $num_info; ?></span></td>
				</tr>
				<?php endif; ?>
		<?php endif;?>

		<?php 
		//ALERTAS DEL MODULO DE BLOG
		if(getModuleExist("blog")):
			$module_config = getModuleConfig("blog");
			if ($module_config['options']['show_alarms']):
				$num_blog = blogController::getAlerts();?>
				<tr>
					<td>
						<a href="blog"><i class="fa fa-link"></i> <?php e_strTranslate("Blog");?></a>
					</td>
					<td class="text-right"><span class="badge <?php echo $num_blog > 0 ? 'active' : '';?>"><?php echo $num_blog; ?></span></td>
				</tr>
				<?php endif; ?>
		<?php endif;?>
	</table>
<?php } ?>