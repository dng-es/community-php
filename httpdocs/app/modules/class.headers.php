<?php
class headers{
	/**
	* Print HTML page header. Goes from the begining </head>
	*
	*/
	public static function PageHeader(){
		global $ini_conf, $scripts_js, $scripts_css, $KEYWORDS_META_PAGE, $SUBJECT_META_PAGE, $TITLE_META_PAGE;

		$Key_Words = (isset( $KEYWORDS_META_PAGE ) ? $KEYWORDS_META_PAGE : $ini_conf['SiteKeywords']);
		$Subject = (isset( $SUBJECT_META_PAGE ) ? $SUBJECT_META_PAGE : $ini_conf['SiteSubject']);
		$Title = (isset( $TITLE_META_PAGE ) ? $ini_conf['SiteTitle']." - ".$TITLE_META_PAGE : $ini_conf['SiteTitle']);


		?>

		<!DOCTYPE html>
		<html lang="<?php echo $_SESSION['language'];?>" xml:lang="<?php echo $_SESSION['language'];?>">
			<head>
				<base href="<?php echo $ini_conf['SiteUrl'];?>/">
				<meta charset="utf-8">
		    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
		    	<meta name="viewport" content="width=device-width, initial-scale=1">
				<meta name="description" content="<?php echo $ini_conf['SiteDesc'];?>" />
				<meta NAME="Subject" CONTENT="<?php echo $Subject;?>" />
				<meta NAME="Keywords" CONTENT="<?php echo $Key_Words;?>" />
				<meta name="copyright" CONTENT="Copyright(c) 2014 by Grass Roots Spain" />
				<meta name="robots" content="noarchive" />
				<title><?php echo $Title;?></title>
				<link rel="shortcut icon" href="favicon.ico">
				<link rel="icon" type="image/ico"  href="favicon.ico" >		
				<link href="<?php echo $ini_conf['SiteUrl'];?>/css/styles.css" rel="stylesheet">
				<script type="text/javascript" src="<?php echo $ini_conf['SiteUrl'];?>/js/main.min.js"></script>
				<!-- <script type="text/javascript" src="js/notifications.js"></script> -->
				

			<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
			<!--[if lt IE 9]>
			  <script type="text/javascript" src="js/css3-mediaqueries.js"></script> 
			  <script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
			  <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
			<![endif]-->
	<?php
		//incluir css de la página actual
		if (isset($scripts_css)){
			foreach($scripts_css as $script_css):
				echo '<link href="'.$script_css.'" rel="stylesheet"> ';
			endforeach;
		}

		//incluir js de la página actual
		if (isset($scripts_js)){
			foreach($scripts_js as $script_js):
				echo '<script type="text/javascript" src="'.$script_js.'"></script>';
			endforeach;
		}
	}

	/**
	* Print HTML ini page. Goes from </head> to page_content
	*
	* @param 	array 		$ini_conf 		Configuration values
	* @param 	string 		$page 			Current page
	*/
	public static function PageBody($ini_conf,$page = ""){
		global $paginas_free; ?>
		</head>
			<body id="page-<?php echo $page;?>">
			<img alt="fondo" id="bg" src="images/bg01.jpg" class="hidden-print" />
		<?php if ( isset($_SESSION['user_logged']) and $_SESSION['user_logged']==true and (isset($_REQUEST['page']) and !in_array($_REQUEST['page'], $paginas_free))): ?>

				<?php if (class_exists('globaloptionsController')):
					globaloptionsController::gettoken( $_SESSION['user_name'], $_SESSION['user_pass']);
				?>
					<form name="formGlobalOptions" id="formGlobalOptions"  method="post" target="_blank" action="https://www.myglobaloptions.com/store/control/login">
						<input type="hidden" name="USERNAME" value="<?php echo $_SESSION['user_name'];?>">
						<input type="hidden" name="PASSWORD" value="<?php echo $_SESSION['user_pass'];?>">
					</form>
				<?php endif; ?>
				<div class="container" id="container-main">
				<!-- Page content -->
					<div id="header-container" class="hidden-print">
						<?php menu::UserInfoMenu();?>
						<?php menu::PageMenu();?>
					</div>
					<div id="container-content">
					<!-- Mantener todo el contenido de la página dentro del div page-content -->
		<?php endif; ?>
<?php
	}
}?>