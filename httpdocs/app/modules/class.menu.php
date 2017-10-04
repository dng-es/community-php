<?php
templateload("cmbCanales", "users");
templateload("search", "core");

class menu{
	static function menuContainer($slider = false){
		self::userInfoMenu($slider);
		self::pageMenu($slider);
	}

	/**
	* Print user info. User must be logged
	*
	*/
	static function userInfoMenu($slider = false){
		global $ini_conf, $session, $page;
		$theme = ((isset($_REQUEST['theme']) && $page == 'home_new') ? sanitizeInput($_REQUEST['theme']) : $_SESSION['user_theme']);
		if ($_SESSION['user_logged'] == true){
			$users = new users();
			$puntos_user = $users->getUsers("AND username='".$_SESSION['user_name']."' ");
			
			//actualizar datos de sesion por si han cambiado
			$_SESSION['user_puntos'] = $puntos_user[0]['puntos'];
			$_SESSION['user_perfil'] = $puntos_user[0]['perfil'];
			$_SESSION['user_empresa'] = $puntos_user[0]['empresa'];
			?>
			<div class="row header-info">
				<?php if($slider == true): ?>
				<div class="col-md-1 col-sm-1 col-xs-2 menu-hidden text-center" data-container="close">
					<i class="fa fa-bars fa-2x"></i>
				</div>
				<?php endif; ?>
				<div class="<?php echo ($slider == true ? 'col-md-3 col-sm-3 col-xs-10' : 'col-md-3 col-sm-3 hidden-xs' ) ?>">
					<a href="home"><img src="themes/<?php echo $theme;?>/images/logo.png" alt="<?php echo prepareString($ini_conf['SiteName']);?>" id="header-info-logo" class="img-responsive"/></a>
				</div>
				<div class="<?php echo ($slider == true ? 'col-md-8 col-sm-8 col-xs-12 menu-opt1-slider' : 'col-md-9 col-sm-9 col-xs-12' ) ?>">
					<div id="user-info">
						<a href="profile" title="<?php e_strTranslate("My_profile");?>"><img alt="<?php echo prepareString($_SESSION['user_nick']);?>" src="<?php echo usersController::getUserFoto($puntos_user[0]['foto']);?>" /></a>
						
						<p><a href="profile"><?php echo $_SESSION['user_nick'];?></a></p>
						<div class="icons-container">							
							<a href="#" class="pointer" id="search-btn" title="<?php e_strTranslate("Search");?>"><i class="fa fa-search faa-bounce animated-hover text-muted"></i></a>
							<div style="width: 0px; display: none;margin-top: -10px" id="main-search-container">
							<?php mainSearch("search-results", "", "");?>
							</div>
							

							<a href="logout" id="logout-btn" title="<?php e_strTranslate("Logout");?>"><i class="fa fa-power-off faa-pulse animated-hover"></i></a>
							<?php
							$user_permissions = $session->checkPageTypePermission("view", $session->checkPagePermission("admin", $_SESSION['user_name']));
							
							//se muestra el acceso a admin si tiene el permiso
							if ($session->checkPageViewPermission("admin", $_SESSION['user_perfil'], $user_permissions)){
								if ($_SESSION['user_perfil'] == 'admin'){ echo '<a href="admin" title="'.strTranslate("Administration").'"><i class="fa fa-gear faa-spin animated-hover"></i></a>';}
							}

							if ($_SESSION['user_perfil'] == 'admin' || $_SESSION['user_perfil'] == 'responsable'){
								echo '<a href="mygroup" title="'.strTranslate("My_team").'"><i class="fa fa-users faa-tada animated-hover"></i></a>';
							}
							echo '<a href="profile" id="perfil-btn" title="'.strTranslate("My_profile").'"><i class="fa fa-user faa-tada animated-hover"></i></a>';
							
							get_hooks('header');
							
							if ($_SESSION['show_user_points']){
								echo '<span class="points"><big>'.$puntos_user[0]['puntos']."</big> ".strTranslate("APP_points").'</span>';
							}?>
						</div>
					</div>
				</div>
			</div>
			<?php self::menuClassic($slider);
		}
	}	

	/**
	* Print Main menu. User must be logged
	*/
	static function pageMenu($slider){
		//MENU DE NAVAGACION
		if ($_SESSION['user_logged'] == true){?>
			<?php if($slider == false):?>
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
						<ul class="nav navbar-nav nav-menu">
							<?php self::userMainMenu($slider);?>
						</ul>
					</div><!-- /.navbar-collapse -->
				</div><!-- /.container-fluid -->
			</nav>
			<?php endif;
		}
	}

	/**
	 * Print clasic main menu
	 */
	public static function menuClassic($slider = true){
		if($slider == false):?>
		<div id="menu-selector">
			<?php self::languageSelector();?>
			<?php self::channelSelector();?>
		</div>
		<?php endif;
	}

	/**
	 * Print slider main menu
	 */
	public static function menuSlider($slider = true){
		if($slider == true):?>
		<div class="menu-hidden-container">
			<ul class="nav-menu-hidden">
				<?php self::languageSelector();?>
				<?php self::channelSelector();?>
				<li><a href="home"><i class="fa fa-home visible-xs-inline-block text-primary"></i> <?php e_strTranslate("Home")?></a></li>
				<?php self::userMainMenu($slider);?>
			</ul>
		</div>
		<?php endif;
	}

	/**
	 * Print elements of users main menu
	 */
	public static function userMainMenu($slider = false){
		global $array_usermenu;
		$array_final = $array_usermenu;
		$array_final = arraySort($array_final, 'LabelPos', SORT_ASC);
		foreach ($array_final as  $fila) {
			self::userMainMenuItem($fila);
		}
	}

	/**
	 * Print one single item main menu
	 */
	public static function userMainMenuItem($fila){
		$labelId = (isset($fila['LabelId']) ? 'id="'.$fila['LabelId'].'"' : '');
		$labelClass= (isset($fila['LabelClass']) ? 'class="'.$fila['LabelClass'].'"' : '');

		if (isset($fila['SubItems']) && count($fila['SubItems']) > 0){
			echo '<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="600" data-close-others="false"><i class="'.$fila['LabelIcon'].' visible-xs-inline-block text-primary"></i> '.$fila['LabelItem'].' <b class="caret"></b></a>
					<ul class="dropdown-menu">';
						foreach ($fila['SubItems'] as $elem):
						echo '<li><a target="'.$elem['LabelTarget'].'" href="'.$elem['LabelUrl'].'">'.$elem['LabelItem'].'</a></li>';
						endforeach;
			echo '	</ul>
				</li>';
		}
		else 
			echo '<li '.$labelClass.'><a '.$labelId.' target="'.$fila['LabelTarget'].'" href="'.$fila['LabelUrl'].'"><i class="'.$fila['LabelIcon'].' visible-xs-inline-block text-primary"></i> '.$fila['LabelItem'].'</a></li>';
		
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
			if ($elem['LabelHeader'] == $section){
				$main_url = explode("&", $elem['LabelUrl']);
				$active = (($_GET['page'] == $main_url[0] || $_GET['page'] == $elem['LabelUrl']) ? " class=\"active\" " : "");
				if($header_name != "" && $header_name != $elem['LabelSection']) $content .= '</ul>';

				if ($header_name != $elem['LabelSection']){
					$header_name = $elem['LabelSection'];
					$content .= '<li class="module-admin-header">'.$elem['LabelSection'].'</li>
					<ul class="module-admin-item">';
					$content .= '<li><a '.$active.' href="'.$elem['LabelUrl'].'">'.$elem['LabelItem'].'</a></li>';
				}
				elseif($header_name == $elem['LabelSection']) $content .= '<li><a '.$active.' href="'.$elem['LabelUrl'].'">'.$elem['LabelItem'].'</a></li>';
			}
		endforeach;
		if ($content != "")
			echo '<h3><i class="'.$icon.'"></i> '.strTranslate($section).'</h3>
				<ul>'.$content.'</ul></ul>';
	}

	/**
	 * Print Admin panels. Used admin main page
	 * @param  array 	$elems 		Paneles a mostrar
	 */
	static function getAdminPanels($elems){
		$header_name = "";
		foreach($elems as $elem):
			if($header_name != "" && $header_name != $elem['LabelSection']){
				echo '		</dl>
						</div>
					</div>
				</div>';
			}

			if ($header_name != $elem['LabelSection']){
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
				echo '		</dl>
						</div>
					</div>
				</div>';
	}

	/**
	* Print channel selector
	*
	*/
	static function channelSelector(){
		if ($_SESSION['user_perfil'] == 'admin' || trim($_SESSION['user_canal']) == ''): ?>
		<form role="form" name="chooseForm" id="chooseForm" action="" method="post" class="form-inline">
			<select name="chooseFormValue" id="chooseFormValue" class="form-control input-xs chooseFormValue">
				<?php ComboCanales($_SESSION['user_canal'], ($_SESSION['user_perfil'] == 'admin' ? "": " AND visible=1 "));?>
			</select>
		</form>
		<?php endif;
	}

	/**
	* Print language selector
	*
	*/
	static function languageSelector(){
		global $ini_conf;
		if ($ini_conf['language_selector'] == true){
			$folders = FileSystem::showDirFolders(__DIR__."/../languages/");
			$destination = str_replace("&lan=", "&lano=", $_SERVER['REQUEST_URI']);
			$destination = str_replace("?lan=", "?lano=", $_SERVER['REQUEST_URI']);
			$separator = (strpos($_SERVER['REQUEST_URI'], "?") == 0  ? "?" : "&");
			foreach($folders as $folder):
				echo '<a href="'.$destination.$separator.'lan='.$folder.'" title="'.$folder.'"><img alt="<?php echo $folder;?>" src="app/languages/'.$folder.'/images/flag.png" class="lang-img" /></a>';
			endforeach;
		}
	}

	/**
	* Print administration menu
	*
	*/
	static function adminMenu(){
		if ($_SESSION['user_logged'] == true && $_SESSION['user_perfil'] == 'admin'){
			global $array_adminmenu;
			$array_final = $array_adminmenu;

			foreach ($array_final as $clave => $fila){
				$principal[$clave] = $fila['LabelHeader'];
				$seccion[$clave] = $fila['LabelSection'];
				$posicion[$clave] = $fila['LabelPos'];
			}

			array_multisort($principal, SORT_ASC, $seccion, SORT_ASC, $posicion, SORT_ASC, $array_final);

			?>
			<div class="app-sidebar-admin hidden-print" id="admin-panel">
				<h2><a href="admin"><?php e_strTranslate("Go_to_main_panel");?></a></h2>
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
		if (isset($_SESSION['user_logged'])){
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
	}

	/**
	* Print administration menu
	*
	*/
	static function adminPanels(){
		if ($_SESSION['user_logged'] == true && $_SESSION['user_perfil'] == 'admin'){
			$array_final = array();
			global $modules;
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
			
			foreach ($array_final as $clave => $fila){
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
		global $TITLE_META_PAGE, $ini_conf;
		if ( $ini_conf['breadcrumb'] == true){
			echo '<ol class="breadcrumb hidden-print">';
			foreach($elems as $elem):
				echo '<li'.(isset($elem["ItemClass"]) ? ' class="'.$elem["ItemClass"].'" ': '').'>
						'.(isset($elem["ItemUrl"]) ? '<a href="'.$elem["ItemUrl"].'">' : '').'
						'.$elem["ItemLabel"].'
						'.(isset($elem["ItemUrl"]) ? '</a>' : '').'
					</li>';
			endforeach;
			$TITLE_META_PAGE = ((isset( $TITLE_META_PAGE ) && $TITLE_META_PAGE != '') ? $TITLE_META_PAGE : $elem['ItemLabel']);
			echo '</ol>';
		}
	}
}?>