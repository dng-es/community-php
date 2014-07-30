<?php
class menu{
	/**
	* Print Main menu. User must be logged
	*
	*/
	static function PageMenu(){
		//MENU DE NAVAGACION
		if ($_SESSION['user_logged']==true){
			global $menu_sel;
		
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
			echo '			<li><a class="menu-item" href="?page=areas">Cursos</a></li>';
			echo '			<li><a class="menu-item" href="?page=foro-subtemas&id='.$id_foro.'">Foros</a></li>';
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

	/**
	* Print administration menu
	*
	*/
	static function adminMenu(){
		if ($_SESSION['user_logged']==true and $_SESSION['user_perfil']='admin'){ ?>
			<div class="col-md-3" id="admin-panel">
				<h3>Gestión de contenidos</h3>
				<ul>
					<li class="module-admin-header">Documentación a pdf</li>
					<ul class="module-admin-item">
						<li><a href="?page=admin-infotopdf">Listado de documentos</a></li>
						<li><a href="?page=admin-infotopdf-doc&act=new">Nuevo Documento</a></li>
					</ul>
					<li class="module-admin-header">Documentación</li>
					<ul class="module-admin-item">
						<li><a href="?page=admin-info">Listado de documentos</a></li>
						<li><a href="?page=admin-info-doc&act=new">Nuevo Documento</a></li>
					</ul>
					<li class="module-admin-header">Envío de comunicaciones</li>
					<ul class="module-admin-item">
						<li><a href="?page=admin-messages">Comunicaciones enviadas</a></li>
						<li><a href="?page=admin-templates">Plantillas de comunicaciones</a></li>
					</ul>						
					<li class="module-admin-header">Campañas</li>
					<ul class="module-admin-item">
						<li><a href="?page=admin-campaign&act=new">Nueva campaña</a></li>
						<li><a href="?page=admin-campaigns">Listado de campañas</a></li>
						<li><a href="?page=admin-campaigns-types">Tipos de campañas</a></li>
					</ul>						
					<li class="module-admin-header">Vídeos</li>
					<ul class="module-admin-item">
						<li><a href="?page=admin-videos">Listado de vídeos</a></li>
						<li><a href="?page=admin-validacion-videos">Validación de vídeos</a></li>
					</ul>						
					<li class="module-admin-header">Fotos</li>
					<ul class="module-admin-item">
						<li><a href="?page=admin-albumes">Álbumes de fotos</a></li>
						<li><a href="?page=admin-validacion-fotos">Validación de fotos</a></li>
					</ul>
					<li class="module-admin-header">Foros</li>
					<ul class="module-admin-item">
						<li><a href="?page=admin-validacion-foro-temas">Temas en los foros</a></li>
						<li><a href="?page=admin-validacion-foro-comentarios">Comentarios en los foros</a></li>
					</ul>
					<li class="module-admin-header">Blog</li>
					<ul class="module-admin-item">
						<li><a href="?page=admin-blog">Listado de entradas</a></li>
						<li><a href="?page=admin-blog-new&act=new">Nueva entrada</a></li>
					</ul>
					<li class="module-admin-header">Muro</li>
					<ul class="module-admin-item">
						<li><a href="?page=admin-validacion-muro">Comentarios en el muro</a></li>
					</ul>
				</ul>
				
				<h3>Herramientas</h3>
				<ul>
					<li class="module-admin-header">Configuración</li>
					<li class="module-admin-header">Usuarios</li>
					<li class="module-admin-header">Informes</li>
				</ul>
			</div>
			<?php
		}
	}	
}?>