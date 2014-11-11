<?php
class menu{
	/**
	* Print Main menu. User must be logged
	*
	*/
	static function PageMenu(){
		//MENU DE NAVAGACION
		if ($_SESSION['user_logged']==true){
		
			//SELECCION DEL FORO
			$id_foro = ($_SESSION['user_canal']== CANAL2) ? 2 : 1;

			//SELECCION ULTIMO VIDEO
			$filter_videos = ($_SESSION['user_canal']!='admin' ? " AND canal='".$_SESSION['user_canal']."' " : "");			
			$id_video = connection::SelectMaxReg("id_file", "galeria_videos", $filter_videos." AND estado=1 ");

			//SELECCION ULTIMO ID BLOG
			$id_blog = connection::SelectMaxReg("id_tema", "foro_temas", " AND ocio=1 AND id_tema_parent=0 AND activo=1 ");
			?>

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
					<li><a href="?page=video&id=<?php echo $id_video;?>"><i class="fa fa-video-camera visible-xs-inline-block text-primary"></i> <?php echo strTranslate("Videos")?></a></li>
					<li><a href="?page=fotos"><i class="fa fa-picture-o visible-xs-inline-block text-primary"></i> <?php echo strTranslate("Photos")?></a></li>
					<li><a href="?page=user-infotopdf-all"><i class="fa fa-file-pdf-o visible-xs-inline-block text-primary"></i> <?php echo strTranslate("Infotopdf_Documents")?></a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="600" data-close-others="false"><i class="fa fa-envelope-o visible-xs-inline-block text-primary"></i> <?php echo strTranslate("Massive_Mailing")?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="?page=user-templates">Ver todas las comunicaciones</a></li>
							<li><a href="?page=user-lists"><?php echo strTranslate("Mailing_lists")?></a></li>
							<li><a href="?page=user-messages">Mis comunicaciones enviadas</a></li>
						</ul>
					</li>
					<li><a href="?page=blog&id=<?php echo $id_blog?>"><i class="fa fa-globe visible-xs-inline-block text-primary"></i> <?php echo strTranslate("Blog")?></a></li>
					<li><a href="?page=areas"><i class="fa fa-bookmark visible-xs-inline-block text-primary"></i> <?php echo strTranslate("Na_areas")?></a></li>
					<li><a href="?page=foro-subtemas&id=<?php echo $id_foro;?>"><i class="fa fa-comment visible-xs-inline-block text-primary"></i> <?php echo strTranslate("Forums")?></a></li>
					<li><a href="?page=user-info-all"><i class="fa fa-file visible-xs-inline-block text-primary"></i> <?php echo strTranslate("Info_Documents")?></a></li>
					<li><a href="?page=ranking"><i class="fa fa-trophy visible-xs-inline-block text-primary"></i> Ranking</a></li>

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

	static function getMenuSection($section, $array_final){
		$header_name = "";
		foreach($array_final as $elem):				
			if ($elem['LabelHeader']==$section) {
				$main_url = explode("&", $elem['LabelUrl']);
				$active = (($_GET['page']==$main_url[0] or $_GET['page']==$elem['LabelUrl']) ? " class=\"active\" " : "");
				if($header_name!="" and $header_name!=$elem['LabelSection']){
					echo '</ul>';
				}

				if ($header_name!=$elem['LabelSection']){
					$header_name = $elem['LabelSection'];
					echo '<li class="module-admin-header">'.$elem['LabelSection'].'</li>
					<ul class="module-admin-item">';
					echo '<li><a '.$active.' href="?page='.$elem['LabelUrl'].'">'.$elem['LabelItem'].'</a></li>';
				}
				elseif($header_name=$elem['LabelSection']){
					echo '<li><a '.$active.' href="?page='.$elem['LabelUrl'].'">'.$elem['LabelItem'].'</a></li>';
				}				
			}
		endforeach;
		echo '</ul>';
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
				echo '<a href="'.$destination.'&lan='.$folder.'" title="'.$folder.'"><img src="includes/languages/'.$folder.'/images/flag.png" /></a>';
			endforeach;
			echo '</div>';
		}
	}	


	/**
	* Print administration menu
	*
	*/
	static function adminMenu(){
		if ($_SESSION['user_logged']==true and $_SESSION['user_perfil']='admin'){ 

			$array_final = array();
			$modules = getListModules();		
			foreach($modules as $module):
				$moduleClass = $module['folder']."Controller";
				$instance = new $moduleClass();
				if (method_exists($instance, "adminMenu")) {
			        $array_final = array_merge($array_final, $instance->adminMenu());
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
				<h3><?php echo strTranslate("Content_manager");?></h3>
				<ul>
					<?php self::getMenuSection("Modules", $array_final);?>
				</ul>
				<h3><?php echo strTranslate("Tools");?></h3>
				<ul>
					<?php self::getMenuSection("Tools", $array_final);?>
				</ul>
				<br />
			</div>
			<?php
		}
	}	

	/**
	* Print administration menu
	*
	*/
	static function adminPanels(){
		if ($_SESSION['user_logged']==true and $_SESSION['user_perfil']='admin'){ 
			$array_final = array();
			$modules = getListModules();		
			foreach($modules as $module):
				$moduleClass = $module['folder']."Controller";
				$instance = new $moduleClass();
				if (method_exists($instance, "adminPanels")) {
			        $array_final = array_merge($array_final, $instance->adminPanels());
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

	
}?>