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

			echo '<!-- Sidebar -->
					<div id="sidebar-wrapper">
						<ul class="sidebar-nav" role="navigation"> 
							<li><a class="menu-item" href="?page=home">'.strTranslate("Home").'</a></li>
							<li><a class="menu-item" href="?page=videos">'.strTranslate("Videos").'</a></li>
							<li><a class="menu-item" href="?page=fotos">'.strTranslate("Photos").'</a></li>';
			echo '			<li><a class="menu-item" href="?page=user-infotopdf-all">Impresos PDF</a></li>';
			echo '			<li class="dropdown"><a href="#" class="dropdown-toggle menu-item" data-toggle="dropdown" data-hover="dropdown" data-delay="600" data-close-others="false">Envío emails <b class="caret"></b></a>
					          <ul class="dropdown-menu">
					            <li><a href="?page=user-templates">Ver todas las comunicaciones</a></li>
					            <li><a href="?page=user-lists">Mis listas de envío</a></li>
					            <li><a href="?page=user-messages">Mis comunicaciones enviadas</a></li>
					          </ul>
					        </li>';
			echo '			<li><a class="menu-item" href="?page=areas">'.strTranslate("Na_areas").'</a></li>';
			echo '			<li><a class="menu-item" href="?page=foro-subtemas&id='.$id_foro.'">'.strTranslate("Forums").'</a></li>';
			echo '			<li><a class="menu-item" href="?page=user-info-all">Documentación</a></li>';
			//echo 				'<li><a class="menu-item" href="?page=mystery">Mystery</a></li>';
			echo' 		</ul>
					</div>';
		}	
	}

	/**
	* Print user info. User must be logged
	*
	*/
	static function UserInfoMenu(){
		if ($_SESSION['user_logged']==true){
			$users = new users();
			$huellas_user = $users->getUsers("AND username='".$_SESSION['user_name']."' ");
			?>
			<div class="row header-info">
				<a href="?page=home"><img src="images/logo.png" id="header-info-logo" class="img-responsive" /></a>
				<div id="user-info">
					<div class="pull-right" style="width:75%">
					<?php 
					echo '<img class="comment-mini-img" src="images/usuarios/'.$_SESSION['user_foto'].'" style="width:50px !important;height:55px !important;float:right;margin-left:10px" />';
					echo '<p><i class="fa fa-comment"></i> '.strTranslate("Hello").' '.$_SESSION['user_nick'].'<br />';
					if ($_SESSION['user_perfil']=='admin'){ echo '<a href="?page=admin"><i class="fa fa-gear"></i> '.strTranslate("Administration").'</a> | ';}
					echo '<a href="?page=user-perfil" id="perfil-btn"><i class="fa fa-user"></i> '.strTranslate("My_profile").'</a> | ';	
					echo '<a href="?page=logout" id="logout-btn"><i class="fa fa-lock"></i> '.strTranslate("Logout").'</a></p>';	
					//echo '<p><span>Horas de vuelo</span> <span style="font-size:32px;font-weight:bolder;color:#fff">'.$huellas_user[0]['horas_vuelo'].'</span></p>';
					//echo '<span>Puntos</span> '.$huellas_user[0]['puntos'].' </p>';
					?>
					</div>		
				</div>
			</div>
			<?php
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
			<h2><a href="?page=admin">Ir al Panel Principal</a></h2>
			<h3>Gestión de contenidos</h3>
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
}?>