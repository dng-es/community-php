<?php
class menu{
	/**
	* Print Main menu. User must be logged
	*/
	static function PageMenu(){
		global $session;
		//MENU DE NAVAGACION
		if ($_SESSION['user_logged']==true){ ?>
			<nav class="navbar navbar-default" id="menu-main" role="navigation">
				<div class="container-fluid">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu-main-container">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="home"><i class="fa fa-home"></i></a>
					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="menu-main-container">
						<ul class="nav navbar-nav">
							<?php self::userMainMenu();?>				
							
							<li class="hidden-md hidden-lg"><a href="profile"><i class="fa fa-user visible-xs-inline-block text-primary"></i> <?php echo strTranslate("My_profile")?></a></li>
							<?php if ($_SESSION['user_perfil']=='admin'){
							echo '<li class="hidden-md hidden-lg"><a href="admin"><i class="fa fa-gear visible-xs-inline-block text-primary"></i> '.strTranslate("Administration").'</a></li>';
							}
							?>
							<li class="hidden-md hidden-lg"><a href="inbox"><i class="fa fa-envelope visible-xs-inline-block text-primary"></i> <?php echo strTranslate("Mailing_messages")?></a></li>
							<li class="hidden-md hidden-lg"><a href="logout"><i class="fa fa-power-off visible-xs-inline-block text-primary"></i> <?php echo strTranslate("Logout")?></a></li>
						</ul>
					</div><!-- /.navbar-collapse -->
				</div><!-- /.container-fluid -->
			</nav>
			<?php
		}	
	}

	/**
	 * Print elements of users main menu
	 */
	public static function userMainMenu(){
		global $array_usermenu;
		$array_final = $array_usermenu;
		$array_final = arraySort($array_final, 'LabelPos', SORT_ASC);

		foreach ($array_final as  $fila) {
			$labelId = (isset($fila['LabelId']) ? 'id="'.$fila['LabelId'].'"' : '');
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
				echo '<li><a '.$labelId.' target="'.$fila['LabelTarget'].'" href="'.$fila['LabelUrl'].'"><i class="'.$fila['LabelIcon'].' visible-xs-inline-block text-primary"></i> '.$fila['LabelItem'].'</a></li>';
			}
		}
	}

	/**
	* Print user info. User must be logged
	*
	*/
	static function UserInfoMenu(){
		global $ini_conf;
		if ($_SESSION['user_logged']==true){
			$users = new users();
			$puntos_user = $users->getUsers("AND username='".$_SESSION['user_name']."' ");
			$_SESSION['user_puntos'] = $puntos_user[0]['puntos'];
			//MENSAJE NO LEIDOS
			$contador_no_leidos=connection::countReg("mensajes"," AND user_destinatario='".$_SESSION['user_name']."' AND estado=0 ");

			?>
			<div class="row header-info">
				<a href="home"><img src="images/logo.png" alt="<?php echo prepareString($ini_conf['SiteName']);?>" id="header-info-logo" /></a>
				<div id="user-info">
					<div class="pull-right" style="width:75%">
					<?php 
					echo '<a href="profile"><img alt="'.prepareString($_SESSION['user_nick']).'" src="images/usuarios/'.$_SESSION['user_foto'].'" /></a>';
					
					echo '<p>';
					echo '<a href="profile">'.$_SESSION['user_nick'].'</a><br />';
					echo '<a href="logout" id="logout-btn" title="'.strTranslate("Logout").'"><i class="fa fa-power-off"></i></a>';
					if ($_SESSION['user_perfil']=='admin'){ echo '<a href="admin" title="'.strTranslate("Administration").'"><i class="fa fa-gear"></i></a>';}
					echo '<a href="profile" id="perfil-btn" title="'.strTranslate("My_profile").'"><i class="fa fa-user"></i></a>';
					echo '<a href="inbox" id="perfil-btn" title="'.strTranslate("Mailing_messages").'"><i class="fa fa-envelope"></i> <span id="contador-leidos-header">'.$contador_no_leidos.'</span></a>';	
					echo '<span class="points"><big>'.$puntos_user[0]['puntos']."</big> ".strTranslate("APP_points").'</span>';
					echo ' </p>';
					?>
					</div>		
				</div>
			</div>
			<?php

			//Print language selector
			self::languageSelector();
		}
	}

	/**
	 * Print each section of Admin main menu
	 * @param  string 	$section     	Nombre de la sección
	 * @param  string 	$icon        	Icono de la sección
	 * @param  array 	$elems 			Elementos de cada sección
	 */
	static function getMenuSection($section, $icon, $elems){			
		$header_name = "";
		$content = "";
		foreach($elems as $elem):				
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
					$content .= '<li><a '.$active.' href="'.$elem['LabelUrl'].'">'.$elem['LabelItem'].'</a></li>';
				}
				elseif($header_name=$elem['LabelSection']){
					$content .= '<li><a '.$active.' href="'.$elem['LabelUrl'].'">'.$elem['LabelItem'].'</a></li>';
				}				
			}
		endforeach;
		if ($content != ""){
			echo '<h3><i class="'.$icon.'"></i> '.strTranslate($section).'</h3>
				<ul>'.$content.'</ul></ul>';
		}
	}

	/**
	 * Print Admin panels. Used admin main page
	 * @param  array 	$elems 		Paneles a mostrar
	 */
	static function getAdminPanels($elems){
		$header_name = "";
		foreach($elems as $elem):	
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
				<dd><a href="'.$elem['LabelUrl'].'">'.$elem['LabelUrlText'].'</a></dd>';
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
			$destination = str_replace("?lan=", "?lano=", $_SERVER['REQUEST_URI']);
			$separator = (strpos($_SERVER['REQUEST_URI'], "?")==0  ? "?" : "&");
			echo '<div id="language-selector">';
			foreach($folders as $folder):
				echo '<a href="'.$destination.$separator.'lan='.$folder.'" title="'.$folder.'"><img alt="<?php echo $folder;?>" src="app/languages/'.$folder.'/images/flag.png" /></a>';
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
			global $array_adminmenu;
			$array_final = $array_adminmenu;
						
			foreach ($array_final as $clave => $fila) {
				$principal[$clave] = $fila['LabelHeader'];
				$seccion[$clave] = $fila['LabelSection'];
				$posicion[$clave] = $fila['LabelPos'];
			}

			array_multisort($principal, SORT_ASC, $seccion, SORT_ASC, $posicion, SORT_ASC, $array_final);

			?>
			<div class="app-sidebar-admin hidden-print" id="admin-panel">
				<h2><a href="admin"><?php echo strTranslate("Go_to_main_panel");?></a></h2>
				<?php self::getMenuSection("Modules", "fa fa-puzzle-piece", $array_final);?>
				<?php self::getMenuSection("Tools", "fa fa-gears", $array_final);?>
				<div class="text-right"><h3><small>v. <?php echo APP_VERSION;?></small></h3></div>
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

	/**
	 * Print breadcrumb
	 * @param  array 	$elems 		Elementos a mostrar en el breadcrub
	 */
	public static function breadcrumb($elems){
		echo '<ol class="breadcrumb hidden-print">';
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