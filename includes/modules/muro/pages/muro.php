<?php
$base_dir = str_replace('modules/muro/pages', '', realpath(dirname(__FILE__))) ;
include_once($base_dir . "core/class.connection.php");
include_once($base_dir . "modules/configuration/class.configuration.php");
include_once($base_dir . "core/constants.php");
include_once($base_dir . "core/functions.php");
include_once($base_dir . "core/class.session.php");
include_once($base_dir . "modules/users/class.users.php");
include_once($base_dir . "modules/muro/class.muro.php");
include_once($base_dir . "modules/muro/templates/comment.php");

?>
<!DOCTYPE html>
  <html lang="es">
    <head>
    <meta charset="utf-8">
    <script type="text/javascript" src="js/jquery.js"></script>
    
    <!-- Bootstrap core -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>

    <LINK rel="stylesheet" type="text/css" href="css/styles.css" />
    <link href="css/font-awesome.min.css" rel="stylesheet">
    
    <script language="JavaScript" src="includes/modules/muro/resources/js/muro-respuestas-ajax.js"></script>
    <!-- tooltip -->
    <link rel="stylesheet" type="text/css" href="css/jquery.bettertip.css" />     
    <script type="text/javascript" src="js/jquery.bettertip.pack.js"></script> 
    <script type="text/javascript">
        $(function(){
            BT_setOptions({openWait:250, closeWait:0, cacheEnabled:true});
        })
    </script>
    <!-- fin tooltip --> 
    <script type="text/javascript">
      jQuery(document).ready(function(){
        var ahora = "<?php echo users::timeServer();?>";
        ahora = ahora.replace(" ","T") + "Z";
        $(".date-format-ago").each(function(){
             var date2 = $(this).attr("data-date").replace(" ","T") + "Z";
             var date = prettyDate(ahora,date2);
             if (date) {
                $(this).text(date);
             }
        });
      });
    </script>
     
</head>
<body>
<div id="responder-form" style="display: none"></div>
<?php

session::ValidateSessionAjax();
$muro=new muro(); 

$filtro="";
if ($_SESSION['user_canal']!='admin' and $_SESSION['user_canal']!='formador'){$filtro=" AND c.canal='".$_SESSION['user_canal']."' ";}
$filtro.=" AND tipo_muro='principal' AND estado=1 AND id_comentario_id=0 ORDER BY date_comentario DESC LIMIT 20";
$comentarios_muro = $muro->getComentarios($filtro);
  echo '<div class="" id="muro-home">'; 
  foreach($comentarios_muro as $comentario_muro):
	 commentMuro($comentario_muro);
  endforeach;					
  echo '</div>
  		  <div class="ver-mas">
          <a href="?page=muro-comentarios&c=principal">
          <span class="fa fa-search"></span> ver más comentarios</a>
        </div>';
?> 
</body>
</html>