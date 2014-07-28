<?php

//GET CONFIGURATON VARIABLES
$base_dir_config = realpath(dirname(__FILE__)) ;
$ini_conf = parse_ini_file($base_dir_config."/config.php");

$configuration = new configuration();

$site_config=$configuration->getConfigIni("");
$ini_conf = array_merge($ini_conf, $site_config);


//PAGINAS EN LAS QUE EL USUARIO NO ES NECESARIO QUE ESTE LOGUEADO
$paginas_free = array("login","user-confirm","logout","contact-free","declaracion","policy","404","registration","registration-confirm","unsuscribe");
//TIPOS DE ARCHIVOS PERMITIDOS
$videos_types = array("MP4","MOV","AVI","3GP","WMV");
$fotos_types = array("GIF","JPG","JPEG","PNG");
//PUNTOS A OTORGAR POR ACCION REALIZADA POR USUARIO Y TEXTOS DE MOTIVOS
define('PUNTOS_VIDEO',0);
define('PUNTOS_FOTO',0);
define('PUNTOS_MURO',0);
define('PUNTOS_FORO',0);
define('PUNTOS_FORO_SEMANA',5);
define('PUNTOS_ACCESO_SEMANA',1);
define('PUNTOS_RETO',0);
define('PUNTOS_RETO2',0);
define('PUNTOS_RETO_SELECCION',30);
define('PUNTOS_MAS_VOTADO',50);
define('PUNTOS_RETO_GANADOR',100);

define('PUNTOS_RETO_FILE',25);
define('PUNTOS_RETO2_FILE',6);
define('PUNTOS_RETO_SELECCION_FILE',60);
define('PUNTOS_MAS_VOTADO_FILE',50);

define('USUARIOS_REGALO',100);

define('PUNTOS_VIDEO_MOTIVO','Subida de video');
define('PUNTOS_FOTO_MOTIVO','Subida de foto');
define('PUNTOS_MURO_MOTIVO','Comentario en el muro');
define('PUNTOS_FORO_MOTIVO','Comentario en el foro');
define('PUNTOS_FORO_SEMANA_MOTIVO',"Comentario en el foro semanal");
define('PUNTOS_ACCESO_SEMANA_MOTIVO',"Acceso semanal");
define('PUNTOS_RETO_MOTIVO',"Contenido en el reto");
define('PUNTOS_RETO_GANADOR_MOTIVO','Ganador en el reto');
define('PUNTOS_RETO_SELECCION_MOTIVO',"Contenido en el reto seleccionado");
define('PUNTOS_MAS_VOTADO_MOTIVO','Contenido mas votado');
//VALORACION APORTACIONES
define('APORTACIONES_VALORACION',50);
//TAMANOS MAXIMOS DE LOS ARCHIVOS A SUBIR POR LOS USUARIOS Y RUTAS
define('MAX_SIZE_VIDEOS',10000000);
define('MAX_SIZE_FOTOS',1000000);
define('MAX_SIZE_VIDEOS_KB',MAX_SIZE_VIDEOS/1000);
define('MAX_SIZE_FOTOS_KB',MAX_SIZE_FOTOS/1000);

define('PATH_VIDEOS',"docs/videos/");
define('PATH_VIDEOS_TEMP',"docs/videos/temp/");
define('PATH_VIDEOS_CONVERT',"docs/videos/convert/");
define('PATH_FOTOS',"docs/fotos/");
define('PATH_USERS_FOTO',"images/usuarios/");
define('PATH_OCIO',"docs/ocio/");
define('PATH_DESCARGAS',"docs/descargas/");
define('PATH_TAREAS',"docs/tareas/");
define('PATH_APPS_IMG',"images/apps/");
define('PATH_BANCO_IMAGENES_IMG',"images/banco/");
define('PATH_DOCUMENTOS_IMG',"docs/territorial/");
define('PATH_INFO',"docs/info/");
define('PATH_INCENTIVOS_IMG',"images/incentivos/");
define('PATH_PUBLICIDAD_IMG',"images/publicidad/");
define('PATH_MAILING',"images/mailing/");

//ESTADOS POR DEFECTO DE LOS CONTENIDOS ENVIADOS
define('ESTADO_COMENTARIOS_MURO',1);
define('ESTADO_COMENTARIOS_FORO',1);
///////////////////////////////////////////////////////////////////////////////////
// LOCALE, DATE AND TIME DEFINITIONS
///////////////////////////////////////////////////////////////////////////////////
@setlocale(LC_TIME, 'es_ES.ISO_8859-1');
setlocale(LC_TIME, 'spanish');
date_default_timezone_set('Europe/Madrid');
define('DATE_MONTH', '%m');  // this is used for strftime()
define('DATE_DAY', '%d');  // this is used for strftime()
define('DATE_YEAR', '%Y');  // this is used for strftime()
define('DATE_FORMAT_SHORT', '%d/%m/%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A %d %B, %Y'); // this is used for strftime()
define('DATE_FORMAT', 'd/m/Y');  // this is used for date()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');
define('TIME_FORMAT', ' %H:%M:%S');

//CANALES DE LA COMUNIDAD
define('CANAL1','comercial');
define('CANAL1_LABEL','Canal comercial');
define('CANAL2','gerente');
define('CANAL2_LABEL','Canal gerentes');
define('DEFAULT_IMG_PROFILE', "user.jpg")
?>