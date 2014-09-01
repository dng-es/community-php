<?php
class headers{
	/**
	* Print HTML page header. Goes from the begining </head>
	*
	* @param 	string 		$Subject 		Metatag subject
	* @param 	string 		$Key_Words 		Metatag Keywords
	*/
	public static function PageHeader($Subject,$Key_Words){
		global $ini_conf;
		?>


		<!DOCTYPE html>
		<html lang="es">
			<head>
			<meta charset="utf-8">
	    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	    	<meta name="viewport" content="width=device-width, initial-scale=1">
			<meta name="description" content="<?php echo $ini_conf['SiteDesc'];?>" />
			<meta NAME="Subject" CONTENT="<?php echo $Subject;?>" />
			<meta NAME="Keywords" CONTENT="<?php echo $Key_Words;?>" />
			<meta name="copyright" CONTENT="Copyright(c) 2014 by Grass Roots Spain" />
			<meta name="robots" content="noarchive" />
			<title><?php echo $ini_conf['SiteTitle'];?></title>
			<link rel="shortcut icon" href="favicon.ico">
			<link rel="icon" type="image/ico"  href="favicon.ico" >		

			<link href="css/styles.css" rel="stylesheet"> 
			
			<script type="text/javascript" src="js/main.min.js"></script>

			<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
			<!--[if lt IE 9]>
			  <script type="text/javascript" src="js/css3-mediaqueries.js"></script> 
			  <script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
			  <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
			<![endif]-->
	<?php
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
			<?php if ( isset($_SESSION['user_logged']) and $_SESSION['user_logged']==true and (isset($_REQUEST['page']) and !in_array($_REQUEST['page'], $paginas_free))): ?>

				<div id="wrapper">
				<!-- Page content -->
				<div id="page-content-wrapper">
					<?php menu::UserInfoMenu();?>
					<?php menu::PageMenu();?>
					<div id="container-content">
					<!-- Mantener todo el contenido de la página dentro del div page-content -->
		<?php else: ?>
		<img id="bg" src="images/bg01.jpg" />
		<?php endif; ?>
<?php
	}
}?>