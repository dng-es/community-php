<?php
class menu{
	/**
	* Print Main menu. User must be logged
	*
	*/
	static function PageMenu(){
		global $session;
		//MENU DE NAVAGACION
		if ($_SESSION['user_logged']==true){ ?>
			<nav class="navbar navbar-default" id="menu-main" role="navigation">
				<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="?page=home"><i class="fa fa-home"></i></a>
				</div>

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<?php self::userMainMenu();?>
					
					
					<li class="hidden-md hidden-lg"><a href="?page=user-perfil"><i class="fa fa-user visible-xs-inline-block text-primary"></i> <?php echo strTranslate("My_profile")?></a></li>
					<?php if ($_SESSION['user_perfil']=='admin'){
					echo '<li class="hidden-md hidden-lg"><a href="?page=admin"><i class="fa fa-gear visible-xs-inline-block text-primary"></i> '.strTranslate("Administration").'</a></li>';
					}
					?>
					<li class="hidden-md hidden-lg"><a href="?page=mensajes"><i class="fa fa-envelope visible-xs-inline-block text-primary"></i> <?php echo strTranslate("Mailing_messages")?></a></li>
					<li class="hidden-md hidden-lg"><a href="?page=logout"><i class="fa fa-lock visible-xs-inline-block text-primary"></i> <?php echo strTranslate("Logout")?></a></li>
				</ul>
				</div><!-- /.navbar-collapse -->
				</div><!-- /.container-fluid -->
			</nav>
			<?php
		}	
	}

	public static function userMainMenu(){
		$array_final = array();
		$modules = getListModules();		
		foreach($modules as $module):
			if (file_exists(__DIR__."/".$module['folder']."/".$module['folder'].".php")){
				include_once (__DIR__."/".$module['folder']."/".$module['folder'].".php");
				$moduleClass = $module['folder']."Core";
				$instance = new $moduleClass();
				if (method_exists($instance, "userMenu")) {
				$array_final = array_merge($array_final, $instance->userMenu());
			}
		}
		endforeach;

		foreach ($array_final as $clave => $fila) {
			$posicion[$clave] = $fila['LabelPos'];
		}

		array_multisort($posicion, SORT_ASC, $array_final);

		foreach ($array_final as  $fila) {
			if (isset($fila['SubItems']) and count($fila['SubItems'])>0){
				echo '<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="600" data-close-others="false"><i class="'.$fila['LabelIcon'].' visible-xs-inline-block text-primary"></i> '.$fila['LabelItem'].' <b class="caret"></b></a>
								<ul class="dropdown-menu">';
									foreach ($fila['SubItems'] as $elem):
									echo '<li><a target="'.$elem['LabelTarget'].'" href="'.$elem['LabelUrl'].'">'.$elem['LabelItem'].'</a></li>';
									endforeach;
				echo '
								</ul>
							</li>';
			}
			else{
				echo '<li><a target="'.$fila['LabelTarget'].'" href="'.$fila['LabelUrl'].'"><i class="'.$fila['LabelIcon'].' visible-xs-inline-block text-primary"></i> '.$fila['LabelItem'].'</a></li>';
			}
		}
	}

	/**
	* Print user info. User must be logged
	*
	*/
	static function UserInfoMenu(){
		if ($_SESSION['user_logged']==true){
			$users = new users();
			$puntos_user = $users->getUsers("AND username='".$_SESSION['user_name']."' ");

			//MENSAJE NO LEIDOS
			$contador_no_leidos=connection::countReg("mensajes"," AND user_destinatario='".$_SESSION['user_name']."' AND estado=0 ");

			?>
			<div class="row header-info">
				<a href="?page=home"><img src="images/logo.png" id="header-info-logo" /></a>
				<div id="user-info">
					<div class="pull-right" style="width:75%">
					<?php 
					echo '<img class="comment-mini-img" src="images/usuarios/'.$_SESSION['user_foto'].'" style="width:50px !important;height:55px !important;float:right;margin-left:10px" />';
					
					echo '<p>';
					echo ' <i class="fa fa-comment"></i> '.strTranslate("Hello").' '.$_SESSION['user_nick'].'<br />';
					if ($_SESSION['user_perfil']=='admin'){ echo '<a href="?page=admin"><i class="fa fa-gear"></i> '.strTranslate("Administration").'</a> | ';}
					echo '<a href="?page=user-perfil" id="perfil-btn"><i class="fa fa-user"></i> '.strTranslate("My_profile").'</a> | ';
					echo '<a href="?page=mensajes" id="perfil-btn"><i class="fa fa-envelope"></i> '.strTranslate("Mailing_messages").' <span id="contador-leidos-header">'.$contador_no_leidos.'</span></a> | ';	
					echo '<a href="?page=logout" id="logout-btn"><i class="fa fa-lock"></i> '.strTranslate("Logout").'</a> | ';
					echo ucfirst(strTranslate("APP_points")).': '.$puntos_user[0]['puntos'];
					echo ' </p>';
					?>
					</div>		
				</div>
			</div>
			<?php

			//SELECTOR DE IDIOMAS
			self::languageSelector();
		}
	}

	static function getMenuSection($section, $icon, $array_final){			
		$header_name = "";
		$content = "";
		foreach($array_final as $elem):				
			if ($elem['LabelHeader']==$section) {
				$main_url = explode("&", $elem['LabelUrl']);
				$active = (($_GET['page']==$main_url[0] or $_GET['page']==$elem['LabelUrl']) ? " class=\"active\" " : "");
				if($header_name!="" and $header_name!=$elem['LabelSection']){
					$content .= '</ul>';
				}

				if ($header_name!=$elem['LabelSection']){
					$header_name = $elem['LabelSection'];
					$content .= '<li class="module-admin-header">'.$elem['LabelSection'].'</li>
					<ul class="module-admin-item">';
					$content .= '<li><a '.$active.' href="?page='.$elem['LabelUrl'].'">'.$elem['LabelItem'].'</a></li>';
				}
				elseif($header_name=$elem['LabelSection']){
					$content .= '<li><a '.$active.' href="?page='.$elem['LabelUrl'].'">'.$elem['LabelItem'].'</a></li>';
				}				
			}
		endforeach;
		if ($content != ""){
			echo '<h3><i class="'.$icon.'"></i> '.strTranslate($section).'</h3>
				<ul>'.$content.'</ul></ul>';
		}
	}

	static function getAdminPanels($array_final){

					$header_name = "";
					foreach($array_final as $elem):	
						if($header_name!="" and $header_name!=$elem['LabelSection']){
							echo '</dl></div>
								</div>
							</div>';
						}

						if ($header_name!=$elem['LabelSection']){
							$header_name = $elem['LabelSection'];
							echo '<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading"><h3 class="panel-title">'.$header_name.'<small><i class="fa fa-file pull-right text-muted"></i></small></h3></div>
				<div class="panel-body">
					<dl class="dl-horizontal">';
						}
						echo '<dt>'.$elem['LabelItem'].'</dt>
							<dd><a href="?page='.$elem['LabelUrl'].'">'.$elem['LabelUrlText'].'</a></dd>';
					endforeach;
							echo '</dl></div>
								</div>
							</div>';
	
	}

	/**
	* Print language selector
	*
	*/
	static function languageSelector(){
		global $ini_conf;
		if ($ini_conf['language_selector']==true){
			$folders = FileSystem::showDirFolders(__DIR__."/../languages/");
			$destination = str_replace("&lan=", "&lano=", $_SERVER['REQUEST_URI']);
			echo '<div id="language-selector">';
			foreach($folders as $folder):
				echo '<a href="'.$destination.'&lan='.$folder.'" title="'.$folder.'"><img src="app/languages/'.$folder.'/images/flag.png" /></a>';
			endforeach;
			echo '</div>';
		}
	}	


	/**
	* Print administration menu
	*
	*/
	static function adminMenu(){
		if ($_SESSION['user_logged']==true and $_SESSION['user_perfil']=='admin'){ 
			$array_final = array();
			$modules = getListModules();		
			foreach($modules as $module):
				if (file_exists(__DIR__."/".$module['folder']."/".$module['folder'].".php")){
					include_once (__DIR__."/".$module['folder']."/".$module['folder'].".php");
					$moduleClass = $module['folder']."Core";
					$instance = new $moduleClass();
					if (method_exists($instance, "adminMenu")) {
				    	$array_final = array_merge($array_final, $instance->adminMenu());
					}
				}
			endforeach;
			
			foreach ($array_final as $clave => $fila) {
				$principal[$clave] = $fila['LabelHeader'];
				$seccion[$clave] = $fila['LabelSection'];
				$posicion[$clave] = $fila['LabelPos'];
			}

			array_multisort($principal, SORT_ASC, $seccion, SORT_ASC, $posicion, SORT_ASC, $array_final);

			?>
			<div class="col-md-3" id="admin-panel">
				<h2><a href="?page=admin"><?php echo strTranslate("Go_to_main_panel");?></a></h2>
				<?php self::getMenuSection("Modules", "fa fa-puzzle-piece", $array_final);?>
				<?php self::getMenuSection("Tools", "fa fa-gears", $array_final);?>
				<br />
			</div>
			<?php
		}
	}	

	/**
	 * Elementos para el menu de administración
	 * @param 	array 		$elem 			Propiedades del elemento menu
	 * @return 	array           			Array con datos
	 */	
	public static function addAdminMenu($elem){
		global $session;	
		$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission($elem['PageName'], $_SESSION['user_name']));
		if ($session->checkPageViewPermission($elem['PageName'], $_SESSION['user_perfil'], $user_permissions)){
			$elem = array("LabelHeader" => $elem['LabelHeader'],
							"LabelSection" => $elem['LabelSection'],
							"LabelItem" => $elem['LabelItem'],
							"LabelUrl" => $elem['LabelUrl'],
							"LabelPos" => $elem['LabelPos']);
			return $elem;
		}
	}	

	/**
	* Print administration menu
	*
	*/
	static function adminPanels(){
		if ($_SESSION['user_logged']==true and $_SESSION['user_perfil']=='admin'){ 
			$array_final = array();
			$modules = getListModules();		
			foreach($modules as $module):
				if (file_exists(__DIR__."/".$module['folder']."/".$module['folder'].".php")){
					include_once (__DIR__."/".$module['folder']."/".$module['folder'].".php");
					$moduleClass = $module['folder']."Core";
					$instance = new $moduleClass();
					if (method_exists($instance, "adminPanels")) {
						$array_final = array_merge($array_final, $instance->adminPanels());
					}
				}
			endforeach;
			
			foreach ($array_final as $clave => $fila) {
				$seccion[$clave] = $fila['LabelSection'];
				$posicion[$clave] = $fila['LabelPos'];
			}

			array_multisort($seccion, SORT_ASC, $posicion, SORT_ASC, $array_final);
			self::getAdminPanels($array_final);
		}
	}

	public static function breadcrumb($elems){
		echo '<ol class="breadcrumb">';
		foreach($elems as $elem):		
			echo '<li'.(isset($elem["ItemClass"]) ? ' class="'.$elem["ItemClass"].'" ': '').'>
					'.(isset($elem["ItemUrl"]) ? '<a href="'.$elem["ItemUrl"].'">' : '').'
					'.$elem["ItemLabel"].'
					'.(isset($elem["ItemUrl"]) ? '</a>' : '').'
				</li>';
		endforeach;
		echo '</ol>';
	}
	
}?>