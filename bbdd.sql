/*
SQLyog Community v11.31 (64 bit)
MySQL - 5.5.38-0ubuntu0.14.04.1 : Database - comunidad
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `accesscontrol` */

DROP TABLE IF EXISTS `accesscontrol`;

CREATE TABLE `accesscontrol` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `username` varchar(250) NOT NULL,
  `webpage` varchar(250) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `movil` tinyint(1) NOT NULL DEFAULT '0',
  `ip` varchar(100) NOT NULL DEFAULT '',
  `agent` varchar(255) NOT NULL DEFAULT 'Desconocido',
  `browser` varchar(100) NOT NULL DEFAULT 'Otros',
  `platform` varchar(100) NOT NULL DEFAULT 'Otras',
  PRIMARY KEY (`id`),
  KEY `webpage` (`webpage`),
  KEY `fecha` (`fecha`),
  KEY `browser` (`browser`),
  KEY `platform` (`platform`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `accesscontrol` */

/*Table structure for table `campaigns` */

DROP TABLE IF EXISTS `campaigns`;

CREATE TABLE `campaigns` (
  `id_campaign` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name_campaign` varchar(250) NOT NULL DEFAULT '',
  `desc_campaign` text NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `imagen_mini` varchar(250) NOT NULL DEFAULT '',
  `imagen_big` varchar(250) NOT NULL DEFAULT '',
  `id_campaign_type` int(11) NOT NULL DEFAULT '0',
  `novedad` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_campaign`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `campaigns` */

insert  into `campaigns`(`id_campaign`,`name_campaign`,`desc_campaign`,`active`,`imagen_mini`,`imagen_big`,`id_campaign_type`,`novedad`) values (1,'Gafas de sol - verano 2014','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam vitae turpis augue. Nam in sem quis quam malesuada condimentum. Nullam imperdiet nulla sapien, id consectetur lorem rhoncus eu. Duis eget risus sit amet augue facilisis volutpat. Integer pretium ultricies odio vitae ultricies.',1,'1399909815_5.aprendo_q.jpg','',2,1),(2,'Monturas colección 2014','In in sem a ipsum ultricies semper rutrum ut est. Sed nec enim mattis, dictum turpis in, cursus ipsum. Donec fermentum mollis risus, vel congue sem semper eu. Vivamus accumsan auctor rutrum. Morbi a congue diam.',1,'1399989568_5.aprendo_q.jpg','',2,0),(3,'Otras campañas','In semper sapien ac metus euismod, ut mollis elit ultrices. Nulla commodo tellus sit amet interdum rutrum. Pellentesque eget erat metus. Nam eget erat sit amet nisi pulvinar pharetra. Proin id est ultricies, facilisis ipsum id, dignissim purus. ',1,'1399989624_3.ranking.jpg','',3,0),(4,'Nueva campaña','sf sdfsdfsdf sdf',0,'','',2,0),(5,'Campaña nueva','En un lugar de la Mancha, de cuyo nombre no quiero acordarme, no ha mucho tiempo que vivía un hidalgo de los de lanza en astillero, adarga antigua, rocín flaco y galgo corredor. Una olla de algo más vaca que carnero, salpicón las más noches, duelos y quebrantos los sábados, lantejas los viernes, algún palomino de añadidura los domingos, consumían las tres partes de su hacienda.',1,'1399907395_8.oveja_ovejao.jpg','1399907353_1.home.jpg',2,1),(6,'sdfsdfsdf','dfs',0,'','',3,1),(7,'Reparación de lentes','Con estas razones perdía el pobre caballero el juicio, y desvelábase por entenderlas y desentrañarles el sentido, que no se lo sacara ni las entendiera el mesmo Aristóteles, si resucitara para sólo ello. ',1,'1399989816_8.oveja_ovejao.jpg','',1,0);

/*Table structure for table `campaigns_types` */

DROP TABLE IF EXISTS `campaigns_types`;

CREATE TABLE `campaigns_types` (
  `id_campaign_type` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `campaign_type_name` varchar(250) NOT NULL DEFAULT '',
  `campaign_type_desc` text NOT NULL,
  PRIMARY KEY (`id_campaign_type`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `campaigns_types` */

insert  into `campaigns_types`(`id_campaign_type`,`campaign_type_name`,`campaign_type_desc`) values (1,'Servicios','En un lugar de la Mancha, de cuyo nombre no quiero acordarme, no ha mucho tiempo que vivía un hidalgo de los de lanza en astillero, adarga antigua, rocín flaco y galgo corredor'),(2,'Productos','Una olla de algo más vaca que carnero, salpicón las más noches, duelos y quebrantos los sábados, lantejas los viernes, algún palomino de añadidura los domingos, consumían las tres partes de su hacienda. El resto della concluían sayo de velarte, calzas de velludo para las fiestas, con sus pantuflos de lo mesmo, y los días de entresemana se honraba con su vellorí de lo más fino. '),(3,'Otro tipo','Es, pues, de saber que este sobredicho hidalgo, los ratos que estaba ocioso, que eran los más del año, se daba a leer libros de caballerías, con tanta afición y gusto, que olvidó casi de todo punto el ejercicio de la caza, y aun la administración de su hacienda. ');

/*Table structure for table `config` */

DROP TABLE IF EXISTS `config`;

CREATE TABLE `config` (
  `telefono` varchar(250) NOT NULL DEFAULT '',
  `telefono2` varchar(250) DEFAULT '',
  `fax` varchar(250) NOT NULL DEFAULT '',
  `direccion` longtext NOT NULL,
  `ContactEmail` varchar(250) NOT NULL DEFAULT '',
  `SiteName` varchar(250) NOT NULL DEFAULT '',
  `SiteTitle` varchar(250) NOT NULL DEFAULT '',
  `SiteDesc` varchar(250) NOT NULL DEFAULT '',
  `SiteSubject` varchar(250) NOT NULL DEFAULT '',
  `SiteKeywords` longtext NOT NULL,
  `SiteUrl` varchar(250) NOT NULL DEFAULT '',
  `MailingEmail` varchar(250) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `config` */

insert  into `config`(`telefono`,`telefono2`,`fax`,`direccion`,`ContactEmail`,`SiteName`,`SiteTitle`,`SiteDesc`,`SiteSubject`,`SiteKeywords`,`SiteUrl`,`MailingEmail`) values ('+34','+34 2','+34 3','C/','dnoguera@imagar.com','Community-Php','Community-Php','Comunidad de usuarios Community-Php','Community-Php','Community-Php','http://192.168.0.8/community-php','dnoguera2@imagar.com');

/*Table structure for table `destacados` */

DROP TABLE IF EXISTS `destacados`;

CREATE TABLE `destacados` (
  `id_destacado` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `destacado_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `destacado_tipo` varchar(20) DEFAULT 'foto',
  `destacado_id_file` int(11) DEFAULT '0',
  `destacado_texto` longtext,
  `activo` tinyint(1) DEFAULT '0',
  `canal_destacado` varchar(100) NOT NULL,
  PRIMARY KEY (`id_destacado`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `destacados` */

/*Table structure for table `foro_comentarios` */

DROP TABLE IF EXISTS `foro_comentarios`;

CREATE TABLE `foro_comentarios` (
  `id_comentario` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_tema` int(11) NOT NULL DEFAULT '0',
  `canal` varchar(100) NOT NULL DEFAULT '',
  `comentario` longtext,
  `user_comentario` varchar(100) NOT NULL DEFAULT '',
  `date_comentario` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `votaciones` int(11) NOT NULL DEFAULT '0',
  `estado` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=pendiente; 1=validado;2=rechazado',
  `id_comentario_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_comentario`),
  KEY `id_tema` (`id_tema`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;

/*Data for the table `foro_comentarios` */

insert  into `foro_comentarios`(`id_comentario`,`id_tema`,`canal`,`comentario`,`user_comentario`,`date_comentario`,`votaciones`,`estado`,`id_comentario_id`) values (68,36,'','¿para que es este foro?','admin','2014-07-24 13:59:45',0,2,0),(69,36,'','A ver si alguien me lo explica....','admin','2014-07-24 14:00:10',0,1,0),(70,36,'','Nuevo comentario para el foro de comerciales','admin','2014-09-10 14:10:13',0,1,0);

/*Table structure for table `foro_comentarios_votaciones` */

DROP TABLE IF EXISTS `foro_comentarios_votaciones`;

CREATE TABLE `foro_comentarios_votaciones` (
  `id_votacion` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_comentario` int(11) NOT NULL DEFAULT '0',
  `user_votacion` varchar(100) NOT NULL DEFAULT '',
  `date_votacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_votacion`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `foro_comentarios_votaciones` */

/*Table structure for table `foro_temas` */

DROP TABLE IF EXISTS `foro_temas`;

CREATE TABLE `foro_temas` (
  `id_tema` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_tema_parent` int(11) NOT NULL DEFAULT '0',
  `tipo_tema` varchar(100) NOT NULL DEFAULT '',
  `nombre` varchar(250) NOT NULL DEFAULT '',
  `descripcion` longtext,
  `imagen_tema` varchar(250) NOT NULL DEFAULT '',
  `date_tema` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` varchar(100) NOT NULL DEFAULT '',
  `canal` varchar(100) NOT NULL DEFAULT '',
  `responsables` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `itinerario` varchar(250) NOT NULL DEFAULT '',
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `id_area` int(11) NOT NULL DEFAULT '0',
  `ocio` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_tema`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

/*Data for the table `foro_temas` */

insert  into `foro_temas`(`id_tema`,`id_tema_parent`,`tipo_tema`,`nombre`,`descripcion`,`imagen_tema`,`date_tema`,`user`,`canal`,`responsables`,`itinerario`,`activo`,`id_area`,`ocio`) values (1,0,'','Foro principal','','','2014-07-24 13:55:21','admin','comercial',0,'',1,0,0),(2,0,'','Foro principal gerentes',NULL,'','2014-07-24 13:57:44','admin','gerente',0,'',1,0,0),(36,1,'','un temas en comerciales','Primer tema en el canal comercial para pruebas.','','2014-07-24 13:59:20','admin','comercial',0,'',1,0,0),(37,0,'','Área de prueba inicial','El primer curso de formación para el canal comerciales','','2014-08-01 09:06:32','admin','comercial',0,'',1,9,0),(38,1,'','Nuevo tema en los foros','¿Te gustan los foros de la comunidad? cuéntanos....','','2014-08-04 12:07:33','admin','comercial',0,'',1,0,0);

/*Table structure for table `foro_visitas` */

DROP TABLE IF EXISTS `foro_visitas`;

CREATE TABLE `foro_visitas` (
  `id_visita` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(250) NOT NULL DEFAULT '',
  `id_tema` int(11) NOT NULL DEFAULT '0',
  `fecha_visita` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `movil` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_visita`)
) ENGINE=MyISAM AUTO_INCREMENT=532 DEFAULT CHARSET=utf8;

/*Data for the table `foro_visitas` */

insert  into `foro_visitas`(`id_visita`,`username`,`id_tema`,`fecha_visita`,`movil`) values (477,'admin',36,'2014-07-24 13:59:32',0),(478,'admin',36,'2014-07-24 13:59:46',0),(479,'admin',36,'2014-07-24 14:00:10',0),(480,'admin',36,'2014-07-24 14:01:09',0),(481,'admin',36,'2014-07-24 14:01:58',0),(482,'admin',36,'2014-07-24 14:03:43',0),(483,'admin',36,'2014-07-24 14:03:48',0),(484,'admin',36,'2014-07-24 14:04:39',0),(485,'admin',36,'2014-07-24 14:06:22',0),(486,'admin',36,'2014-07-24 14:06:36',0),(487,'admin',36,'2014-07-24 14:07:54',0),(488,'admin',36,'2014-07-24 14:08:30',0),(489,'admin',36,'2014-07-24 14:08:41',0),(490,'admin',36,'2014-07-24 14:10:50',0),(491,'admin',36,'2014-07-24 14:10:56',0),(492,'admin',36,'2014-07-24 14:11:53',0),(493,'admin',36,'2014-07-24 14:12:14',0),(494,'admin',36,'2014-07-24 14:12:52',0),(495,'admin',36,'2014-07-24 15:02:37',0),(496,'admin',36,'2014-07-25 13:41:40',0),(497,'admin',36,'2014-07-25 13:42:11',0),(498,'admin',36,'2014-07-29 11:20:48',0),(499,'admin',36,'2014-07-29 11:27:50',0),(500,'admin',36,'2014-08-01 11:36:26',0),(501,'admin',36,'2014-08-04 12:06:56',0),(502,'admin',38,'2014-08-04 12:07:36',0),(503,'admin',36,'2014-08-11 12:03:08',0),(504,'admin',36,'2014-08-11 12:06:08',0),(505,'admin',36,'2014-08-11 12:06:52',0),(506,'admin',36,'2014-08-11 12:07:49',0),(507,'admin',36,'2014-08-11 12:09:35',0),(508,'admin',36,'2014-08-11 12:09:36',0),(509,'admin',36,'2014-08-11 12:10:20',0),(510,'admin',36,'2014-08-11 12:10:30',0),(511,'admin',36,'2014-08-11 12:10:30',0),(512,'admin',36,'2014-08-11 12:10:42',0),(513,'admin',36,'2014-08-11 12:11:54',0),(514,'admin',36,'2014-08-11 12:12:14',0),(515,'admin',36,'2014-08-11 12:12:29',0),(516,'admin',36,'2014-08-11 12:14:04',0),(517,'admin',36,'2014-08-11 12:14:05',0),(518,'admin',36,'2014-08-11 12:14:33',0),(519,'admin',36,'2014-08-11 12:14:33',0),(520,'admin',36,'2014-08-11 12:14:45',0),(521,'admin',36,'2014-08-11 12:14:46',0),(522,'admin',36,'2014-09-10 10:58:59',0),(523,'admin',36,'2014-09-10 10:59:13',0),(524,'admin',36,'2014-09-10 10:59:41',0),(525,'admin',36,'2014-09-10 14:09:51',0),(526,'admin',36,'2014-09-10 14:10:13',0),(527,'admin',36,'2014-09-10 14:10:23',0),(528,'admin',36,'2014-09-15 16:36:55',0),(529,'admin',36,'2014-09-15 16:37:46',0),(530,'admin',36,'2014-09-17 16:11:58',0),(531,'admin',36,'2014-09-18 16:27:30',0);

/*Table structure for table `galeria_fotos` */

DROP TABLE IF EXISTS `galeria_fotos`;

CREATE TABLE `galeria_fotos` (
  `id_file` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_promocion` int(11) NOT NULL DEFAULT '0',
  `tipo_foto` varchar(250) NOT NULL DEFAULT '',
  `titulo` varchar(100) NOT NULL DEFAULT '',
  `name_file` varchar(250) NOT NULL DEFAULT '',
  `user_add` varchar(100) NOT NULL DEFAULT '',
  `date_foto` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `canal` varchar(100) NOT NULL DEFAULT '',
  `estado` tinyint(1) NOT NULL DEFAULT '0',
  `fotos_puntos` int(11) NOT NULL DEFAULT '0',
  `seleccion_reto` tinyint(1) NOT NULL DEFAULT '0',
  `formacion` tinyint(1) NOT NULL DEFAULT '0',
  `id_album` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_file`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `galeria_fotos` */

insert  into `galeria_fotos`(`id_file`,`id_promocion`,`tipo_foto`,`titulo`,`name_file`,`user_add`,`date_foto`,`canal`,`estado`,`fotos_puntos`,`seleccion_reto`,`formacion`,`id_album`) values (1,0,'','test1','1410340463_apr-14-relax-cal-1600x1050.png','admin','2014-09-10 11:14:23','comercial',1,0,0,0,1),(2,0,'','Una pa generentes','1410780922_apr-14-april-cosmos-cal-1920x1080.jpg','admin','2014-09-15 13:35:22','gerente',1,0,0,0,1);

/*Table structure for table `galeria_fotos_albumes` */

DROP TABLE IF EXISTS `galeria_fotos_albumes`;

CREATE TABLE `galeria_fotos_albumes` (
  `id_album` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_album` varchar(250) NOT NULL DEFAULT '',
  `date_album` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username_album` varchar(100) NOT NULL DEFAULT '',
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_album`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `galeria_fotos_albumes` */

insert  into `galeria_fotos_albumes`(`id_album`,`nombre_album`,`date_album`,`username_album`,`activo`) values (1,'Album de pruebas','2014-09-10 11:15:15','admin',1);

/*Table structure for table `galeria_fotos_comentarios` */

DROP TABLE IF EXISTS `galeria_fotos_comentarios`;

CREATE TABLE `galeria_fotos_comentarios` (
  `id_comentario` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_file` int(11) NOT NULL DEFAULT '0',
  `comentario` longtext,
  `user_comentario` varchar(100) NOT NULL DEFAULT '',
  `date_comentario` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `votaciones` int(11) NOT NULL DEFAULT '0',
  `estado` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=pendiente; 1=validado;2=rechazado',
  PRIMARY KEY (`id_comentario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `galeria_fotos_comentarios` */

/*Table structure for table `galeria_fotos_comentarios_votaciones` */

DROP TABLE IF EXISTS `galeria_fotos_comentarios_votaciones`;

CREATE TABLE `galeria_fotos_comentarios_votaciones` (
  `id_votacion` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_comentario` int(11) NOT NULL DEFAULT '0',
  `user_votacion` varchar(100) NOT NULL DEFAULT '',
  `date_votacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_votacion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `galeria_fotos_comentarios_votaciones` */

/*Table structure for table `galeria_fotos_votaciones` */

DROP TABLE IF EXISTS `galeria_fotos_votaciones`;

CREATE TABLE `galeria_fotos_votaciones` (
  `id_votacion` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_file` int(11) NOT NULL DEFAULT '0',
  `user_votacion` varchar(100) NOT NULL DEFAULT '',
  `date_votacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_votacion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `galeria_fotos_votaciones` */

/*Table structure for table `galeria_videos` */

DROP TABLE IF EXISTS `galeria_videos`;

CREATE TABLE `galeria_videos` (
  `id_file` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_promocion` int(11) NOT NULL DEFAULT '0',
  `tipo_video` varchar(250) NOT NULL DEFAULT '',
  `titulo` varchar(100) NOT NULL DEFAULT '',
  `name_file` varchar(250) NOT NULL DEFAULT '',
  `user_add` varchar(100) NOT NULL DEFAULT '',
  `date_video` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `canal` varchar(100) NOT NULL DEFAULT '',
  `estado` tinyint(1) NOT NULL DEFAULT '0',
  `videos_puntos` int(11) NOT NULL DEFAULT '0',
  `seleccion_reto` tinyint(1) NOT NULL DEFAULT '0',
  `formacion` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_file`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `galeria_videos` */

insert  into `galeria_videos`(`id_file`,`id_promocion`,`tipo_video`,`titulo`,`name_file`,`user_add`,`date_video`,`canal`,`estado`,`videos_puntos`,`seleccion_reto`,`formacion`) values (1,0,'','Bolitas de colores','1341398825_animacion_bolitas_de_colores.mp4.mp4','admin','2014-07-15 14:18:19','comercial',1,0,0,0),(3,0,'','Trabajo en equipo','1350573259_trabajo_en_equipo-hormigas.wmv.mp4','david','2014-07-16 09:39:25','comercial',1,1,0,0),(4,0,'','Aventura juntos I','1347869224_video_2_inicio_de_la_aventura_juntos_reducido.avi.mp4','david','2014-07-16 10:04:43','comercial',1,1,0,0),(5,0,'','Aventura juntos II','1348036284_video_2_inicio_de_la_aventura_juntos_reducido__2.avi.mp4','david','2014-07-16 10:04:49','comercial',1,1,0,0),(6,0,'','Cataratas','1348744180_cataratas.mp4.mp4','david','2014-07-16 10:05:32','comercial',1,1,0,0);

/*Table structure for table `galeria_videos_comentarios` */

DROP TABLE IF EXISTS `galeria_videos_comentarios`;

CREATE TABLE `galeria_videos_comentarios` (
  `id_comentario` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_file` int(11) NOT NULL DEFAULT '0',
  `comentario` longtext,
  `user_comentario` varchar(100) NOT NULL DEFAULT '',
  `date_comentario` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `votaciones` int(11) NOT NULL DEFAULT '0',
  `estado` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=pendiente; 1=validado;2=rechazado',
  PRIMARY KEY (`id_comentario`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `galeria_videos_comentarios` */

insert  into `galeria_videos_comentarios`(`id_comentario`,`id_file`,`comentario`,`user_comentario`,`date_comentario`,`votaciones`,`estado`) values (1,1,'Me gusta el video','admin','2014-07-16 15:34:44',0,1),(2,1,'Aunque se puede mejorar','admin','2014-07-16 15:35:37',0,1),(3,1,'otro comentario más para el video','admin','2014-07-17 12:55:03',1,1),(4,1,'me gustan los videos','admin','2014-07-17 12:55:15',0,1),(5,1,'Otro comentario par el video 1','david','2014-07-17 14:04:06',1,1),(6,6,'comentario pal abuelo','david','2014-07-17 14:05:49',0,1);

/*Table structure for table `galeria_videos_comentarios_votaciones` */

DROP TABLE IF EXISTS `galeria_videos_comentarios_votaciones`;

CREATE TABLE `galeria_videos_comentarios_votaciones` (
  `id_votacion` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_comentario` int(11) NOT NULL DEFAULT '0',
  `user_votacion` varchar(100) NOT NULL DEFAULT '',
  `date_votacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_votacion`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `galeria_videos_comentarios_votaciones` */

insert  into `galeria_videos_comentarios_votaciones`(`id_votacion`,`id_comentario`,`user_votacion`,`date_votacion`) values (1,5,'admin','2014-07-17 14:04:59'),(2,3,'david','2014-07-17 14:05:13');

/*Table structure for table `galeria_videos_votaciones` */

DROP TABLE IF EXISTS `galeria_videos_votaciones`;

CREATE TABLE `galeria_videos_votaciones` (
  `id_votacion` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_file` int(11) NOT NULL DEFAULT '0',
  `user_votacion` varchar(100) NOT NULL DEFAULT '',
  `date_votacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_votacion`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `galeria_videos_votaciones` */

insert  into `galeria_videos_votaciones`(`id_votacion`,`id_file`,`user_votacion`,`date_votacion`) values (1,3,'admin','2014-07-16 09:52:55'),(2,6,'admin','2014-07-16 11:03:55'),(3,4,'admin','2014-07-16 12:35:49'),(4,5,'admin','2014-07-16 12:36:09');

/*Table structure for table `info` */

DROP TABLE IF EXISTS `info`;

CREATE TABLE `info` (
  `id_info` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `titulo_info` varchar(250) NOT NULL DEFAULT '',
  `file_info` varchar(250) NOT NULL DEFAULT '',
  `tipo_info` int(11) NOT NULL DEFAULT '0',
  `canal_info` varchar(100) NOT NULL DEFAULT '',
  `date_info` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_campaign` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_info`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `info` */

insert  into `info`(`id_info`,`titulo_info`,`file_info`,`tipo_info`,`canal_info`,`date_info`,`id_campaign`) values (1,'Fichero excel modelo mailing','1399279474_model_mailing.xls',8,'todos','2014-05-05 10:44:34',1),(2,'Otro ducumento en la sección','1399281294_259-phoenix-aristotelian.mp3',6,'todos','2014-05-05 11:14:54',2),(3,'Un vídeo en servicios','1399542344_1338542451_ve.1338542185521.mp4.mp4',5,'todos','2014-05-08 11:45:44',2),(4,'Fichero de audio de descarga','1399556768_model_mailing.xls',7,'todos','2014-05-08 15:46:08',2);

/*Table structure for table `info_tipo` */

DROP TABLE IF EXISTS `info_tipo`;

CREATE TABLE `info_tipo` (
  `id_tipo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_info` varchar(250) NOT NULL DEFAULT '',
  `foto_info` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_tipo`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `info_tipo` */

insert  into `info_tipo`(`id_tipo`,`nombre_info`,`foto_info`) values (5,'Video','productos.jpg'),(6,'SMS','servicios.jpg'),(7,'Audio','audio.jpg'),(8,'Fichero','fichero.jpg');

/*Table structure for table `infotopdf` */

DROP TABLE IF EXISTS `infotopdf`;

CREATE TABLE `infotopdf` (
  `id_info` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `titulo_info` varchar(250) NOT NULL DEFAULT '',
  `file_info` text,
  `tipo_info` int(11) NOT NULL DEFAULT '0',
  `canal_info` varchar(100) NOT NULL DEFAULT '',
  `date_info` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_campaign` int(11) NOT NULL DEFAULT '0',
  `cuerpo_info` text,
  PRIMARY KEY (`id_info`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `infotopdf` */

insert  into `infotopdf`(`id_info`,`titulo_info`,`file_info`,`tipo_info`,`canal_info`,`date_info`,`id_campaign`,`cuerpo_info`) values (4,'Documento producto','1398851418_1398779046_bg.jpg',5,'todos','2014-04-25 20:15:09',1,NULL),(5,'Otro en productos','1398851402_1398778978_bg01.jpg',5,'todos','2014-04-25 20:15:32',2,NULL),(6,'Caso practico 4','1398851346_1398778935_bg01.jpeg\r\n',5,'todos','2014-04-28 16:48:17',2,'<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width: 500px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td colspan=\"2\">\r\n				<img alt=\"\" src=\"http://localhost/community-php/images/mailing/images/1398327405_bg01.jpg\" style=\"width: 1200px; height: 294px;\" /></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://192.168.0.8/community-php/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td>\r\n				<span>En un lugar de la Mancha, de cuyo nombre no quiero acordarme, no ha mucho tiempo que viv&iacute;a un hidalgo de los de lanza en astillero, adarga antigua, roc&iacute;n flaco y galgo corredor. Una olla de algo m&aacute;s vaca que carnero, salpic&oacute;n las m&aacute;s noches, duelos y quebrantos los s&aacute;bados, lantejas los viernes, alg&uacute;n palomino de a&ntilde;adidura los domingos, consum&iacute;an las tres partes de su hacienda</span></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				[USER_LOGO]</td>\r\n			<td>\r\n				<br />\r\n				[CLAIM_PROMOCION]. Con un descuento de <span style=\"font-size: 14px;\"><strong>[DESCUENTO_PROMOCION]%</strong></span><br />\r\n				<br />\r\n				<span style=\"color: rgb(197, 71, 71);\">oferta v&aacute;lida hasta [DATE_PROMOCION]</span><br />\r\n				<br />\r\n				<br />\r\n				Hasta la pr&oacute;xima [USER_EMPRESA]</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				&nbsp;</td>\r\n			<td>\r\n				[USER_DIRECCION]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n'),(7,'Lorem ipsum dolor sit','1398851346_1398778935_bg01.jpg',7,'todos','2014-04-28 16:48:42',1,'<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width: 500px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://media.imagar.com/essilor/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td>\r\n				En un lugar de la Mancha, de cuyo nombre no quiero acordarme, no ha mucho tiempo que viv&iacute;a un hidalgo de los de lanza en astillero, adarga antigua, roc&iacute;n flaco y galgo corredor. Una olla de algo m&aacute;s vaca que carnero, salpic&oacute;n las m&aacute;s noches, duelos y quebrantos los s&aacute;bados, lantejas los viernes, alg&uacute;n palomino de a&ntilde;adidura los domingos, consum&iacute;an las tres partes de su hacienda</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				[USER_LOGO]</td>\r\n			<td>\r\n				<br />\r\n				[CLAIM_PROMOCION]. Con un descuento de <span style=\"font-size: 14px;\"><strong>[DESCUENTO_PROMOCION]%</strong></span><br />\r\n				<br />\r\n				<span style=\"color: rgb(197, 71, 71);\">oferta v&aacute;lida hasta [DATE_PROMOCION]</span><br />\r\n				<br />\r\n				<br />\r\n				Hasta la pr&oacute;xima [USER_EMPRESA]</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				&nbsp;</td>\r\n			<td>\r\n				[USER_DIRECCION]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n');

/*Table structure for table `infotopdf_tipo` */

DROP TABLE IF EXISTS `infotopdf_tipo`;

CREATE TABLE `infotopdf_tipo` (
  `id_tipo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_info` varchar(250) NOT NULL DEFAULT '',
  `foto_info` varchar(250) NOT NULL DEFAULT '',
  `size_info` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_tipo`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `infotopdf_tipo` */

insert  into `infotopdf_tipo`(`id_tipo`,`nombre_info`,`foto_info`,`size_info`) values (5,'Díptico DIN A5','btn-0007.png','A5'),(6,'DIN A4','btn-0006.png','A4'),(7,'Carta','btn-0004.png','LETTER'),(8,'Postales','btn-0003.png','LETTER'),(9,'Tarjetones','btn-0005.png','EXECUTIVE');

/*Table structure for table `mailing_blacklist` */

DROP TABLE IF EXISTS `mailing_blacklist`;

CREATE TABLE `mailing_blacklist` (
  `email_black` varchar(250) NOT NULL,
  `date_black` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`email_black`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mailing_blacklist` */

/*Table structure for table `mailing_lists` */

DROP TABLE IF EXISTS `mailing_lists`;

CREATE TABLE `mailing_lists` (
  `id_list` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name_list` varchar(250) NOT NULL DEFAULT '',
  `user_list` varchar(100) NOT NULL DEFAULT '',
  `date_list` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_list`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Data for the table `mailing_lists` */

insert  into `mailing_lists`(`id_list`,`name_list`,`user_list`,`date_list`,`activo`) values (1,'Clientes VIP','admin','2014-05-06 12:31:33',1),(2,'Segunda lista de envío','20266370N','2014-05-06 13:42:39',1),(3,'Lista de cumpleaños12','admin','2014-05-06 13:44:45',0),(4,'111111111','admin','2014-05-06 13:45:18',0),(5,'ttttttttttt','admin','2014-05-06 13:51:06',0),(6,'ttttttttttt +1','admin','2014-05-06 13:51:42',0),(7,'Segunda lista de envío','admin','2014-05-06 15:10:29',0),(8,'Segunda lista de envío','admin','2014-05-06 15:11:53',0),(9,'Todos los clientes','admin','2014-05-06 15:14:06',1),(10,'Clientes potenciales','admin','2014-05-06 15:28:44',1),(11,'Massss','admin','2014-05-06 15:29:48',0),(12,'ssssssssss','admin','2014-05-06 15:30:52',0),(13,'KAKAKAKA','admin','2014-05-06 15:31:30',0),(14,'lalala','admin','2014-05-06 15:33:59',0),(15,'Lista de prueba','admin','2014-05-07 09:32:43',1),(16,'yo solo','admin','2014-09-11 15:47:07',1);

/*Table structure for table `mailing_lists_users` */

DROP TABLE IF EXISTS `mailing_lists_users`;

CREATE TABLE `mailing_lists_users` (
  `id_list` int(11) NOT NULL DEFAULT '0',
  `email` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_list`,`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mailing_lists_users` */

insert  into `mailing_lists_users`(`id_list`,`email`) values (1,'cgonzalez@imagar.com'),(1,'dmarchante@imagar.com'),(1,'dnoguera@imagar.com'),(1,'odelgado@imagar.com'),(1,'pramos@imagar.com'),(1,'shermida@imagar.com'),(3,'dmarchante@imagar.com'),(3,'dnoguera@imagar.com'),(3,'odelgado@imagar.com'),(3,'pramos@imagar.com'),(3,'shermida@imagar.com'),(8,'DMARCHANTE@IMAGAR.COM'),(8,'DNOGUERA@IMAGAR.COM'),(8,'ODELGADO@IMAGAR.COM'),(8,'PRAMOS@IMAGAR.COM'),(8,'SHERMIDA@IMAGAR.COM'),(9,'dmarchante@imagar.com'),(9,'dnoguera@imagar.com'),(9,'odelgado@imagar.com'),(9,'pramos@imagar.com'),(9,'shermida@imagar.com'),(10,'cgonzalez@imagar.com'),(10,'dmarchante@imagar.com'),(10,'dnoguera@imagar.com'),(10,'odelgado@imagar.com'),(10,'pramos@imagar.com'),(10,'shermida@imagar.com'),(12,'dmarchante@imagar.com'),(12,'dnoguera@imagar.com'),(12,'odelgado@imagar.com'),(12,'pramos@imagar.com'),(12,'shermida@imagar.com'),(13,'dmarchante@imagar.com'),(13,'dnoguera@imagar.com'),(13,'odelgado@imagar.com'),(13,'pramos@imagar.com'),(13,'shermida@imagar.com'),(15,'cgonzalez@imagar.com'),(15,'dmarchante@imagar.com'),(15,'dnoguera@imagar.com'),(15,'odelgado@imagar.com'),(15,'pramos@imagar.com'),(15,'shermida@imagar.com'),(16,'dnoguera@imagar.com'),(16,'nogueradavid@hotmail.com');

/*Table structure for table `mailing_lists_users_data` */

DROP TABLE IF EXISTS `mailing_lists_users_data`;

CREATE TABLE `mailing_lists_users_data` (
  `email` varchar(250) NOT NULL,
  `birthday` date NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `mailing_lists_users_data` */

insert  into `mailing_lists_users_data`(`email`,`birthday`) values ('dnoguera@imagar.com','1975-05-09'),('shermida@imagar.com','1985-05-09');

/*Table structure for table `mailing_messages` */

DROP TABLE IF EXISTS `mailing_messages`;

CREATE TABLE `mailing_messages` (
  `id_message` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_template` int(11) DEFAULT '0',
  `message_from_email` text,
  `message_from_name` text,
  `message_subject` text,
  `message_body` text,
  `message_body2` text,
  `message_status` varchar(100) NOT NULL DEFAULT 'pending',
  `message_lista` text,
  `message_attachment` text NOT NULL,
  `date_scheduled` date DEFAULT NULL,
  `date_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username_add` varchar(100) NOT NULL DEFAULT '',
  `total_messages` int(11) NOT NULL DEFAULT '0',
  `total_send` int(11) NOT NULL DEFAULT '0',
  `total_pending` int(11) NOT NULL DEFAULT '0',
  `total_failed` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_message`)
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=latin1;

/*Data for the table `mailing_messages` */

insert  into `mailing_messages`(`id_message`,`id_template`,`message_from_email`,`message_from_name`,`message_subject`,`message_body`,`message_body2`,`message_status`,`message_lista`,`message_attachment`,`date_scheduled`,`date_add`,`username_add`,`total_messages`,`total_send`,`total_pending`,`total_failed`) values (1,1,'dnoguera@imagar.com',NULL,'Mensaje de prueba',NULL,'','completed',NULL,'',NULL,'2014-03-18 17:20:47','admin',0,0,0,0),(2,2,'dnoguera@imagar.com',NULL,'Mensaje 2 de prueba',NULL,'','pending',NULL,'',NULL,'2014-03-18 17:22:19','admin',0,0,0,0),(3,1,'dnoguera@imagar.com','Alain Affelou','El asunto del mensaje','cuerpo del mensaje','','pending','lista todos','',NULL,'2014-03-20 16:03:11','admin',0,0,0,0),(4,2,'dnoguera@imagar.com','Alain Affelou','Mensaje a todos los usuarios','el cupero del mensaje','','pending','lista todos','',NULL,'2014-03-20 16:24:05','admin',0,0,0,0),(5,2,'dnoguera@imagar.com','Alain Affelou','Mensaje a todos los usuarios2','sdfsdfsd','','pending','lista todos','',NULL,'2014-03-20 16:24:38','admin',0,0,0,0),(6,2,'dnoguera@imagar.com','Alain Affelou','Mensaje a todos los usuarios3','asdasdasd','','pending','lista todos','',NULL,'2014-03-20 16:25:37','admin',0,0,0,0),(7,2,'dnoguera@imagar.com','Alain Affelou','Mensaje a todos los usuarios4','el cuerpo del mensaje','','pending','lista todos','',NULL,'2014-03-20 16:27:20','admin',0,0,0,0),(8,2,'dnoguera@imagar.com','Alain Affelou','Prueba efinitiva','Aquí va el cuerpo del mensaje','','completed','lista todos','',NULL,'2014-03-21 10:48:41','admin',12,0,0,12),(9,2,'dnoguera@imagar.com','Alain Affelou','El asunto de la prueba','el mensaje','','pending','lista todos','',NULL,'2014-03-21 12:02:27','admin',12,0,12,0),(10,2,'dnoguera@imagar.com','Alain Affelou','dfsf','sdfdfsd','','completed','lista todos','',NULL,'2014-03-23 16:01:15','admin',12,0,0,12),(11,1,'dnoguera@imagar.com','Alain Affelou','llllllll','ññ','','completed','lista todos','',NULL,'2014-03-23 16:05:20','admin',12,0,0,12),(12,2,'dnoguera@imagar.com','Alain Affelou','asds','asda','','completed','lista todos','',NULL,'2014-03-23 16:13:41','admin',12,0,0,12),(13,2,'dnoguera@imagar.com','Alain Affelou','pk','ikoijoi','','completed','lista todos','',NULL,'2014-03-23 16:25:49','admin',12,0,0,12),(14,2,'dnoguera@imagar.com','Alain Affelou','lñññññññññññññ','ñññ','','completed','lista todos','',NULL,'2014-03-23 16:27:04','admin',12,0,0,12),(15,2,'dnoguera@imagar.com','Alain Affelou',',','k','','completed','lista todos','',NULL,'2014-03-23 16:28:18','admin',12,0,0,12),(16,2,'dnoguera@imagar.com','Alain Affelou','llñ','lll','','completed','lista todos','',NULL,'2014-03-23 16:29:43','admin',12,0,0,12),(17,2,'dnoguera@imagar.com','Alain Affelou','ñl','l','','completed','lista todos','',NULL,'2014-03-23 16:30:47','admin',12,0,0,12),(18,1,'dnoguera@imagar.com','Alain Affelou','ll','ññ','','completed','lista todos','',NULL,'2014-03-23 16:32:50','admin',12,0,0,12),(19,1,'dnoguera@imagar.com','Alain Affelou','ññ','ñl,','','completed','lista todos','',NULL,'2014-03-23 16:41:33','admin',12,0,0,12),(20,2,'dnoguera@imagar.com','Alain Affelou','jkk','jjj','','completed','lista todos','',NULL,'2014-03-23 16:45:55','admin',12,0,0,12),(21,2,'dnoguera@imagar.com','Alain Affelou',',,','lm-,mn','','completed','lista todos','',NULL,'2014-03-23 16:53:32','admin',12,0,0,12),(22,1,'dnoguera@imagar.com','Alain Affelou','jnkjk','kkkk','','pending','lista todos','',NULL,'2014-03-23 17:11:07','admin',12,0,0,12),(23,2,'dnoguera@imagar.com','Alain Affelou','klnln','ñ?nlkn','','pending','lista todos','',NULL,'2014-03-23 17:18:44','admin',12,0,4,8),(24,2,'dnoguera@imagar.com','Alain Affelou','knl',' .nl','','pending','lista todos','',NULL,'2014-03-23 17:20:14','admin',12,0,4,8),(25,1,'dnoguera@imagar.com','Alain Affelou','aaaaaaaaaaaa','eeeeeeeeee','','pending','lista todos','',NULL,'2014-03-23 23:08:17','admin',0,0,0,0),(26,1,'dnoguera@imagar.com','Alain Affelou','aaaaaaaaaaaa','eeeeeeeeee','','completed','lista todos','',NULL,'2014-03-23 23:09:56','admin',12,0,0,12),(27,1,'dnoguera@imagar.com','Alain Affelou','kkkkkkkkk','ooooooooooo','','completed','lista todos','',NULL,'2014-03-23 23:19:04','admin',12,0,0,12),(40,1,'dnoguera@imagar.com','Alain Affelou','asdasd','asdasdasd','','pending','lista responsables','',NULL,'2014-03-24 16:28:50','admin',2,0,2,0),(41,1,'dnoguera@imagar.com','Alain Affelou','ssssssss','ssssssssssssss','','completed','lista regionales','',NULL,'2014-03-24 16:29:40','admin',1,0,0,1),(42,1,'dnoguera@imagar.com','Alain Affelou','asdassd','asdasd','','completed','lista comerciales','',NULL,'2014-03-24 16:31:51','admin',8,0,0,8),(43,1,'dnoguera@imagar.com','Alain Affelou','otro mensaje','el cuerpo del mensaje','','completed','lista curso : 1','',NULL,'2014-03-24 16:39:43','admin',2,0,0,2),(44,1,'dnoguera@imagar.com','Alain Affelou','Prueba','Prubsssss','','completed','lista todos','',NULL,'2014-03-25 09:23:02','admin',12,0,0,12),(45,1,'dnoguera@imagar.com','Alain Affelou','33333333333','234234234234\r\n234444444444444444444444444','','pending','lista todos','',NULL,'2014-03-25 10:34:50','admin',12,0,12,0),(46,1,'dnoguera@imagar.com','Alain Affelou','El asunto del mensaje','el cuerpo del mensaje','','completed','lista todos','',NULL,'2014-03-26 11:54:24','admin',15,0,0,15),(47,1,'dnoguera@imagar.com','Alain Affelou','asdasd','sadasd','','pending','lista comerciales','',NULL,'2014-03-27 08:54:52','admin',9,0,9,0),(48,1,'dnoguera@imagar.com','Alain Affelou','tatatatatatat','tetetetetetetet','','pending','lista curso','',NULL,'2014-03-27 09:04:04','admin',2,0,2,0),(49,2,'dnoguera@imagar.com','Alain Affelou','888888888888','000000000','','pending','lista curso','',NULL,'2014-03-27 09:07:50','admin',2,0,2,0),(50,2,'dnoguera@imagar.com','Alain Affelou','dfdfdfd','fdfdfdf','','pending','lista curso','',NULL,'2014-03-27 09:08:44','admin',2,0,2,0),(51,1,'dnoguera@imagar.com','Alain Affelou','ddddddddddddd','fffffffffffffffff','','pending','lista curso : 1','',NULL,'2014-03-27 09:09:29','admin',2,0,2,0),(52,1,'dnoguera@imagar.com','Alain Affelou','test tienda 1','sdasda','','pending','lista tienda : 1111','',NULL,'2014-03-27 09:56:34','admin',0,0,0,0),(53,1,'dnoguera@imagar.com','Alain Affelou','test tienda 1','sdasda','','pending','lista tienda : 1111','',NULL,'2014-03-27 09:57:04','admin',0,0,0,0),(54,1,'dnoguera@imagar.com','Alain Affelou','s','s','','pending','lista tienda : 1111','',NULL,'2014-03-27 09:58:10','admin',0,0,0,0),(55,1,'dnoguera@imagar.com','Alain Affelou','s','s','','pending','lista tienda : 1111','',NULL,'2014-03-27 09:58:42','admin',0,0,0,0),(56,2,'dnoguera@imagar.com','Alain Affelou','asasas','asasas','','pending','lista tienda : 1111','',NULL,'2014-03-27 10:00:00','admin',0,0,0,0),(57,1,'dnoguera@imagar.com','Alain Affelou','fgh','zx','','pending','lista todos','',NULL,'2014-03-27 10:06:17','admin',15,0,15,0),(58,1,'dnoguera@imagar.com','Alain Affelou','rgdfs','dfgdf','','pending','lista tienda : 1111','',NULL,'2014-03-27 10:08:41','admin',0,0,0,0),(59,1,'dnoguera@imagar.com','Alain Affelou','rgdfs','dfgdf','','pending','lista tienda : 1111','',NULL,'2014-03-27 10:13:02','admin',0,0,0,0),(60,2,'dnoguera@imagar.com','Alain Affelou','gdfgdfg','dfgdfg','','pending','lista tienda : 1111','',NULL,'2014-03-27 10:13:26','admin',0,0,0,0),(61,1,'dnoguera@imagar.com','Alain Affelou','el asunto','asdasd','','pending','lista todos','',NULL,'2014-03-27 10:19:21','admin',15,0,15,0),(62,1,'dnoguera@imagar.com','Alain Affelou','asdas','asdasd','','pending','lista curso : 1','',NULL,'2014-03-27 10:19:46','admin',0,0,0,0),(63,1,'dnoguera@imagar.com','Alain Affelou','sadasd','asdasd','','pending','lista curso : 1','',NULL,'2014-03-27 10:20:56','admin',0,0,0,0),(64,2,'dnoguera@imagar.com','Alain Affelou','xcvx','xcv','','pending','lista tienda : 2222','',NULL,'2014-03-27 10:22:43','admin',0,0,0,0),(65,2,'dnoguera@imagar.com','Alain Affelou','xcvx','xcv','','pending','lista tienda : 2222','',NULL,'2014-03-27 10:25:29','admin',0,0,0,0),(66,1,'dnoguera@imagar.com','Alain Affelou','zxc','zxc','','pending','lista tienda : 1111','',NULL,'2014-03-27 10:26:01','admin',0,0,0,0),(67,1,'dnoguera@imagar.com','Alain Affelou','aaaaa','aaaaaaaa','','pending','','',NULL,'2014-03-27 10:31:20','admin',0,0,0,0),(68,1,'dnoguera@imagar.com','Alain Affelou','dfgdfgdf','dfgdfg','','pending','lista todos','',NULL,'2014-03-27 10:35:38','admin',15,0,15,0),(69,1,'dnoguera@imagar.com','Alain Affelou','aaaaaaaaaaaaaaaaa','dddddddddddddddddd','','pending','lista tienda : 1111','',NULL,'2014-03-27 10:35:55','admin',4,0,4,0),(70,1,'dnoguera@imagar.com','Alain Affelou','ttttttttt','yyyyyyyyyyyyyy','','pending','lista curso : 1','1395913210_1307480807_maf.jpg',NULL,'2014-03-27 10:40:10','admin',2,0,2,0),(71,1,'dnoguera@imagar.com','Alain Affelou','asdasd','asdasd','','pending','lista curso : 1','',NULL,'2014-03-27 10:45:16','admin',2,0,2,0),(72,1,'dnoguera@imagar.com','Alain Affelou','xxxxxxx','xxxxxxx','','pending','lista todos','',NULL,'2014-03-27 10:46:36','admin',15,0,15,0),(73,1,'dnoguera@imagar.com','Alain Affelou','xasadd','asdasd','','pending','lista todos','',NULL,'2014-03-27 10:49:56','admin',15,0,15,0),(74,1,'dnoguera@imagar.com','Alain Affelou','sdfsdf','sdfsdf','','pending','lista todos','',NULL,'2014-03-27 10:51:56','admin',15,0,15,0),(75,1,'dnoguera@imagar.com','Alain Affelou','aaaaaaaaaaa','ssssssssssss','','pending','lista tienda : 1111','',NULL,'2014-03-27 10:52:31','admin',4,0,4,0),(76,1,'dnoguera@imagar.com','Alain Affelou','retert','ertert','','pending','lista todos','',NULL,'2014-03-27 13:01:14','admin',15,0,15,0),(77,1,'dnoguera@imagar.com','Alain Affelou','tttttttttt','tyyyyyyyyyyyyyyyyyyy','','pending','admin, creativo','',NULL,'2014-03-27 13:03:57','admin',0,0,0,0),(78,1,'dnoguera@imagar.com','Alain Affelou','rrrrrrrrrr','tttttttttttt','','pending','admin, creativo','',NULL,'2014-03-27 13:05:29','admin',1,0,1,0),(79,1,'dnoguera@imagar.com','Alain Affelou','ddddddd','ddddddddd','','pending','admin, creativo','',NULL,'2014-03-27 13:06:55','admin',1,0,1,0),(80,1,'dnoguera@imagar.com','Alain Affelou','asasasas','asasasas as as<br />\r\nas asdasasd','','pending','admin, creativo','',NULL,'2014-03-27 13:09:36','admin',2,0,2,0),(81,2,'dnoguera@imagar.com','Alain Affelou','dd','sddsd','','pending','admin, ','',NULL,'2014-03-27 16:08:52','admin',1,0,1,0),(82,2,'dnoguera@imagar.com','Alain Affelou','sede','sede','','pending','lista sede','',NULL,'2014-03-27 17:45:19','admin',1,0,1,0),(83,1,'dnoguera@imagar.com','Alain Affelou','mensaje a tiendas propias','Hola [USER_NAME],<br />\r\nPrueba a tiendas propias','','completed','lista tienda tipo : tiendas propias','',NULL,'2014-03-28 09:30:07','admin',0,0,0,0),(84,2,'dnoguera@imagar.com','Alain Affelou','mensaje a tiendas propias 2','Hola [USER_NAME],<br />\r\nBienvenido!!','','pending','lista tienda tipo : tiendas propias','',NULL,'2014-03-28 09:33:58','admin',5,0,5,0),(85,1,'dnoguera@imagar.com','Alain Affelou','prueba tiendas','Holaaaa','','pending','lista tienda : 2ACB','',NULL,'2014-04-03 15:29:56','admin',0,0,0,0),(86,1,'dnoguera@imagar.com','Alain Affelou','test tiendas','sssssssssssssss','','pending','lista tienda : 2ACB','',NULL,'2014-04-03 15:33:34','admin',0,0,0,0),(87,1,'dnoguera@imagar.com','Alain Affelou','dddddddd','d','','pending','lista tienda : 2ACB','',NULL,'2014-04-03 15:34:13','admin',0,0,0,0),(88,1,'dnoguera@imagar.com','Alain Affelou','test tiendas2','zxcz','','pending','lista tienda : 2ACB','',NULL,'2014-04-03 15:35:18','admin',0,0,0,0),(89,1,'dnoguera@imagar.com','Alain Affelou','ddddddd','d','','pending','lista tienda : 2ACB','',NULL,'2014-04-03 15:41:04','admin',1,0,1,0),(90,2,'dnoguera@imagar.com','Alain Affelou','77777777777777','777777777','','pending','lista tienda : 2ACB','',NULL,'2014-04-03 15:42:50','admin',1,0,1,0),(91,2,'dnoguera@imagar.com','Alain Affelou','77777777777777','777777777','','pending','lista tienda : 2ACB','',NULL,'2014-04-03 15:43:06','admin',1,0,1,0),(92,2,'dnoguera@imagar.com','Alain Affelou','77777777777777','777777777','','pending','lista tienda : 2ACB','',NULL,'2014-04-03 15:43:53','admin',1,0,1,0),(93,2,'dnoguera@imagar.com','Alain Affelou','77777777777777','777777777','','pending','lista tienda : 2ACB','',NULL,'2014-04-03 15:44:28','admin',2,0,2,0),(94,1,'dnoguera@imagar.com','Alain Affelou','test tiendas def','Definitivo','','pending','lista tienda : 2ACB','',NULL,'2014-04-03 15:45:44','admin',2,0,2,0),(95,1,'dnoguera@imagar.com','Alain Affelou','hhhhhh','ggg','','completed','lista todos','',NULL,'2014-04-04 22:42:45','admin',4,4,0,0),(96,2,'dnoguera@imagar.com','Alain Affelou','uuuuuuuuuuuuu','bbb','','pending','lista todos','',NULL,'2014-04-04 22:43:28','admin',4,0,4,0),(97,1,'dnoguera@imagar.com','Alain Affelou','iiiiiiiiiiiiiiiiiiiiiiii','kkkkkkkkkkkkk','','pending','lista todos','',NULL,'2014-04-04 23:00:18','admin',4,0,4,0),(98,1,'dnoguera@imagar.com','Alain Affelou','0000000000','mmm<br />\r\n','','completed','lista todos','',NULL,'2014-04-04 23:58:57','admin',0,0,0,0),(99,1,'dnoguera@imagar.com','Alain Affelou','0000000000','mmm<br />\r\n','','completed','lista todos','',NULL,'2014-04-04 23:59:37','admin',4,0,0,4),(100,1,'dnoguera2@imagar.com','Alain Affelou','prueba con saltos de linea','Una linea.<br />\r\nOtra<br />\r\nadsasdasda<br />\r\nasdasdasd<br />\r\nasdasdasd','','completed','lista todos','',NULL,'2014-04-15 14:09:24','admin',4,4,0,0),(101,1,'dnoguera2@imagar.com','Comunidad Essilor','prueba','Hola [USER_NAME],<br />\r\nsdfsdfsdf','','completed','admin','',NULL,'2014-04-23 09:10:15','admin',1,1,0,0),(102,1,'dnoguera2@imagar.com','Comunidad Essilor','test black','sdfsd','','completed','admin','',NULL,'2014-04-23 13:19:52','admin',0,0,0,0),(103,1,'dnoguera2@imagar.com','Comunidad Essilor','Black list 2','asdasd','','completed','admin','',NULL,'2014-04-23 13:21:25','admin',1,1,0,0),(104,1,'dnoguera2@imagar.com','Comunidad Essilor','rrr','erterter','','completed','admin','',NULL,'2014-04-23 16:04:02','admin',1,1,0,0),(105,11,'dnoguera2@imagar.com','Tu ayudaadmin','Un mensaje','asdasdasd','','pending','model_mailing.xls','1398332862_model_mailing.xls',NULL,'2014-04-24 11:47:42','admin',4,0,4,0),(106,11,'dnoguera2@imagar.com','Tu ayudaadmin','Plantilla cuarta','sdfsdfsd','','pending','model_mailing.xls','',NULL,'2014-04-24 11:51:31','admin',0,0,0,0),(107,11,'dnoguera2@imagar.com','Tu ayudaadmin','Plantilla cuarta','sdfsdfsd','','pending','model_mailing.xls','',NULL,'2014-04-24 11:52:13','admin',0,0,0,0),(108,11,'dnoguera2@imagar.com','Tu ayudaadmin','Plantilla cuarta','sdfsdfsd','','pending','model_mailing.xls','',NULL,'2014-04-24 11:52:38','admin',3,0,3,0),(109,3,'dnoguera2@imagar.com','Tu ayudaadmin','sdfs','sdfsdf','','pending','model_mailing.xls','',NULL,'2014-04-24 12:00:51','admin',4,0,4,0),(110,1,'dnoguera2@imagar.com','Tu ayudaadmin','','','','pending','','',NULL,'2014-04-29 17:20:44','admin',0,0,0,0),(111,1,'dnoguera2@imagar.com','Tu ayudaadmin','','','','pending','','',NULL,'2014-04-29 17:22:20','admin',0,0,0,0),(112,1,'dnoguera2@imagar.com','Tu ayudaadmin','eeeeeeeeeeeee','rrrrrrrrrrrrrrrrr','','pending','model_mailing.xls','',NULL,'2014-04-29 17:38:47','admin',4,0,4,0),(113,1,'dnoguera2@imagar.com','Tu ayudaadmin','ggggggggggggg','ghghfghfghf','','pending','model_mailing.xls','',NULL,'2014-04-29 17:40:10','admin',4,0,4,0),(114,2,'dnoguera2@imagar.com','Tu ayudaadmin','45645645','6456456456','','pending','model_mailing.xls','',NULL,'2014-04-29 17:44:13','admin',4,0,4,0),(115,1,'dnoguera2@imagar.com','Tu ayudaadmin','7777777777','777777777777','','pending','model_mailing.xls','',NULL,'2014-04-29 17:45:15','admin',4,0,4,0),(116,1,'dnoguera2@imagar.com','Tu ayudaadmin','rrrrrr','rrrrrrrrrrrrrrrrrr','','pending','model_mailing.xls','',NULL,'2014-04-29 17:47:35','admin',4,0,4,0),(117,1,'dnoguera2@imagar.com','Tu ayudaadmin','uu','uuuuuuuuuuuuu','','pending','model_mailing.xls','',NULL,'2014-04-29 17:48:12','admin',4,0,4,0),(118,1,'dnoguera2@imagar.com','Tu ayudaadmin','ggggg','ggggdfgdfg','','completed','model_mailing.xls','','2014-04-24','2014-04-29 18:04:51','admin',4,4,0,0),(119,1,'dnoguera2@imagar.com','Tu ayudaadmin','dddddddddddd','dfdsfsdf','','completed','model_mailing.xls','','2014-05-09','2014-04-29 18:07:00','admin',4,4,0,0),(120,1,'dnoguera2@imagar.com','Tu ayudaadmin','eeeeeeeeee','ererer','','pending','model_mailing.xls','',NULL,'2014-04-29 18:07:44','admin',4,0,4,0),(121,1,'dnoguera2@imagar.com','DavidNoguera Gutierrez','Mensaje 1','Mensaje de prueba','','completed','model_mailing.xls','',NULL,'2014-05-05 17:05:39','20266370N',4,4,0,0),(122,1,'dnoguera2@imagar.com','Tu ayudaadmin','','','','pending','','',NULL,'2014-05-06 16:48:53','admin',0,0,0,0),(123,1,'dnoguera2@imagar.com','Tu ayudaadmin','asdasd final','asdasd','','pending','','',NULL,'2014-05-06 17:52:19','admin',2,0,2,0),(124,1,'dnoguera2@imagar.com','Tu ayudaadmin','222222222222','3333333333333333333333333','','pending','model_mailing.xls','',NULL,'2014-05-06 17:53:07','admin',5,0,5,0),(125,1,'dnoguera2@imagar.com','Tu ayudaadmin','test11','jajajajajaj','','pending','','',NULL,'2014-05-07 09:40:33','admin',5,0,5,0),(126,2,'dnoguera2@imagar.com','Tu ayudaadmin','Prueba de certificación','desc del mensaje','','pending','1','','2014-05-23','2014-05-07 09:44:26','admin',2,0,2,0),(127,12,'dnoguera@imagar.com','Tu ayudaadmin','prueba dos textos','texto1','texto2','pending','1','',NULL,'2014-05-14 12:48:06','admin',6,0,6,0),(128,12,'dnoguera@imagar.com','Tu ayudaadmin','el asunto del mensaje','<meta content=\"texthtml; charset=UTF-8\" http-equiv=\"Content-Type\" >\r\n<title><title>\r\n<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http:localhostalainimagesmailingimageslogo.png\" style=\"width: 100px; height: 75px;\" ><br >\r\n					<br >\r\n					<img src=\"images/usuarios/1400146900_1396955321_1392898485_1391208999_imag0493.jpeg\" /><td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						Reclamo<h2>\r\n					2ACC te felicita!!<br >\r\n					mi personalizacion<br >\r\n					<br >\r\n					<br >\r\n					Consigue un descuento de 4 %<br >\r\n					<br >\r\n					fecha l&iacute;mite de la promoci&oacute;n 18/06/2014<br >\r\n					<br >\r\n					C/Álamo 9 - 28921 - Alcorcón - Madrid<br />Tlf.:  91 666 66 66<br />www.imagar.com<br />dnoguera@imagar.com<td>\r\n			<tr>\r\n		<tbody>\r\n	<table>\r\n<div>\r\n','','pending','9','',NULL,'2014-06-10 15:35:40','admin',5,0,5,0),(129,2,'dnoguera@imagar.com','Administrador Community','Mi mensaje de prueba','','','pending','15','',NULL,'2014-07-28 11:29:25','admin',6,0,6,0),(130,2,'dnoguera@imagar.com','Administrador Community','Mi mensaje de prueba','','','pending','15','',NULL,'2014-07-28 11:31:04','admin',6,0,6,0),(131,2,'dnoguera@imagar.com','Administrador Community','Mi mensaje de prueba','<meta content=\"text/html; charset=UTF-8\" http-equiv=\"Content-Type\" />\r\n<title></title>\r\n<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					<br />\r\n					<img src=\"/images/usuarios/\" /></td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						Convocatoria</h2>\r\n					<br />\r\n					<br />\r\n					01/07/2014<br />\r\n					<br />\r\n					Consigue un descuento de <strong>12</strong><br />\r\n					<br />\r\n					[CLAIM PROMOCION]</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					C/Alamo 9 1º derecha - 28921 - Alcorcón - Madrid<br />Tlf.:  666666666<br />dnoguera@imagar.com<br />www.imagar.com</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','','pending','15','',NULL,'2014-07-28 11:33:07','admin',6,0,6,0),(132,2,'dnoguera@imagar.com','Administrador Community','Mi mensaje de prueba','<meta content=\"text/html; charset=UTF-8\" http-equiv=\"Content-Type\" />\r\n<title></title>\r\n<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					<br />\r\n					<img src=\"http://192.168.0.8/community/images/usuarios/\" /></td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						Convocatoria</h2>\r\n					<br />\r\n					<br />\r\n					01/07/2014<br />\r\n					<br />\r\n					Consigue un descuento de <strong>12</strong><br />\r\n					<br />\r\n					[CLAIM PROMOCION]</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					C/Alamo 9 1º derecha - 28921 - Alcorcón - Madrid<br />Tlf.:  666666666<br />dnoguera@imagar.com<br />www.imagar.com</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','','pending','15','',NULL,'2014-07-28 11:33:42','admin',6,0,6,0),(133,2,'dnoguera@imagar.com','Administrador Community','Mi mensaje de prueba','<meta content=\"text/html; charset=UTF-8\" http-equiv=\"Content-Type\" />\r\n<title></title>\r\n<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					<br />\r\n					<img src=\"http://192.168.0.8/community/images/usuarios/\" /></td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						Convocatoria</h2>\r\n					<br />\r\n					<br />\r\n					01/07/2014<br />\r\n					<br />\r\n					Consigue un descuento de <strong>12</strong><br />\r\n					<br />\r\n					[CLAIM PROMOCION]</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					C/Alamo 9 1º derecha - 28921 - Alcorcón - Madrid<br />Tlf.:  666666666<br />dnoguera@imagar.com<br />www.imagar.com</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','','pending','15','',NULL,'2014-07-28 11:34:18','admin',6,0,6,0),(134,2,'dnoguera@imagar.com','Administrador Community','Mi mensaje de prueba','<meta content=\"text/html; charset=UTF-8\" http-equiv=\"Content-Type\" />\r\n<title></title>\r\n<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					<br />\r\n					<img src=\"http://192.168.0.8/community/images/usuarios/\" /></td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						Convocatoria</h2>\r\n					<br />\r\n					<br />\r\n					01/07/2014<br />\r\n					<br />\r\n					Consigue un descuento de <strong>12</strong><br />\r\n					<br />\r\n					mi mensaje de claimmmmmm</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					C/Alamo 9 1º derecha - 28921 - Alcorcón - Madrid<br />Tlf.:  666666666<br />dnoguera@imagar.com<br />www.imagar.com</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','','pending','15','',NULL,'2014-07-28 11:35:49','admin',6,0,6,0),(135,2,'dnoguera@imagar.com','Administrador Community','Mi mensaje de prueba2','<meta content=\"text/html; charset=UTF-8\" http-equiv=\"Content-Type\" />\r\n<title></title>\r\n<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					<br />\r\n					<img src=\"http://192.168.0.8/community/images/usuarios/\" /></td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						Convocatoria</h2>\r\n					<br />\r\n					<br />\r\n					01/07/2014<br />\r\n					<br />\r\n					Consigue un descuento de <strong>11</strong><br />\r\n					<br />\r\n					Mi CLAIMMMMMMM</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					C/Alamo 9 1º derecha - 28921 - Alcorcón - Madrid<br />Tlf.:  666666666<br />dnoguera@imagar.com<br />www.imagar.com</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','','pending','15','',NULL,'2014-07-28 11:36:52','admin',6,0,6,0),(136,3,'dnoguera@imagar.com','Administrador Community','prueba1','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://www.css-tricks.com\">http://www.css-tricks.com</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:01:34','admin',0,0,0,0),(137,3,'dnoguera@imagar.com','Administrador Community','prueba1','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://www.css-tricks.com\">http://www.css-tricks.com</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:02:58','admin',6,0,6,0),(138,3,'dnoguera@imagar.com','Administrador Community','asdasd final','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://www.css-tricks.com\">http://www.css-tricks.com</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:07:32','admin',6,0,6,0),(139,3,'dnoguera@imagar.com','Administrador Community','dddddddddddddd','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://www.css-tricks.com\">http://www.css-tricks.com</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:07:59','admin',6,0,6,0),(140,3,'dnoguera@imagar.com','Administrador Community','zxczxczxc','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://www.css-tricks.com\">http://www.css-tricks.com</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:08:25','admin',6,0,6,0),(141,3,'dnoguera@imagar.com','Administrador Community','ffffffffff','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://www.css-tricks.com\">http://www.css-tricks.com</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:09:46','admin',6,0,6,0),(142,3,'dnoguera@imagar.com','Administrador Community','ffffffffff','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://www.css-tricks.com\">http://www.css-tricks.com</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:10:56','admin',6,0,6,0),(143,3,'dnoguera@imagar.com','Administrador Community','ffffffffff','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://www.css-tricks.com\">http://www.css-tricks.com</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:11:12','admin',6,0,6,0),(144,3,'dnoguera@imagar.com','Administrador Community','oooooo','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://www.css-tricks.com\">http://www.css-tricks.com</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:12:30','admin',6,0,6,0),(145,3,'dnoguera@imagar.com','Administrador Community','oooooo','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\":///lt.php?id=EDNjXFAPWQ%3D%3D\" >http://www.css-tricks.com</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:13:29','admin',6,0,6,0),(146,3,'dnoguera@imagar.com','Administrador Community','oooooo','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://http://192.168.0.8/community-php/includes/modules/mailing/pages/lt.php?id=EDNjXFAPWQ%3D%3D\" >http://www.css-tricks.com</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:18:35','admin',6,0,6,0),(147,3,'dnoguera@imagar.com','Administrador Community','oooooo','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://192.168.0.8/community-php/includes/modules/mailing/pages/lt.php?id=EDNjXFAPWQ%3D%3D\" >http://www.css-tricks.com</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:19:39','admin',6,0,6,0),(148,3,'dnoguera@imagar.com','Administrador Community','oooooo','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://www.css-tricks.com\">http://www.css-tricks.com</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:22:52','admin',0,0,0,0),(149,3,'dnoguera@imagar.com','Administrador Community','oooooo','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://192.168.0.8/community-php/includes/modules/mailing/pages/lt.php?id=EDNjXFAPWQ%3D%3D\" >http://www.css-tricks.com</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:23:40','admin',6,0,6,0),(150,3,'dnoguera@imagar.com','Administrador Community','oooooo','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://192.168.0.8/community-php/includes/modules/mailing/pages/lt.php?id=EDNjXFAPWQ%3D%3D\" >http://www.css-tricks.com</a><br />\r\n				<br />\r\n				<a href=\"http://192.168.0.8/community-php/includes/modules/mailing/pages/lt.php?id=EDNjXFAPWQ%3D%3D\" >Ir a la comunidad</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','cancelled','15','',NULL,'2014-09-11 13:26:06','admin',6,0,6,0),(151,3,'dnoguera@imagar.com','Administrador Community','oooooo','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://192.168.0.8/community-php/includes/modules/mailing/pages/lt.php?id=EDNjXFAPWQ%3D%3D\" >http://www.css-tricks.com</a><br />\r\n				<br />\r\n				<a href=\"http://192.168.0.8/community-php/includes/modules/mailing/pages/lt.php?id=EDNjXFAPWQ%3D%3D\" >Ir a la comunidad</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:28:05','admin',6,0,6,0),(152,3,'dnoguera@imagar.com','Administrador Community','oooooo','','','completed','15','',NULL,'2014-09-11 13:47:12','admin',6,6,0,0),(153,3,'dnoguera@imagar.com','Administrador Community','prueba','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://www.css-tricks.com\">http://www.css-tricks.com</a><br />\r\n				<br />\r\n				<a href=\"http://localhost/community-php/?page=admin-template&amp;id=3\">Ir a la comunidad</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','completed','15','',NULL,'2014-09-11 15:34:18','admin',6,6,0,0),(154,3,'dnoguera@imagar.com','Administrador Community','prueba2','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://www.css-tricks.com\">http://www.css-tricks.com</a><br />\r\n				<br />\r\n				<a href=\"http://localhost/community-php/?page=admin-template&amp;id=3\">Ir a la comunidad</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','cancelled','16','',NULL,'2014-09-11 15:48:47','admin',2,0,2,0),(155,3,'dnoguera@imagar.com','Administrador Community','mensaje de prueba','<h2>\r\n	El cuerpo del nuevo mensaje principal.</h2>\r\n<br />\r\n<a href=\"http://www.css-tricks.com\">http://www.css-tricks.com</a><br />\r\n<br />\r\n<a href=\"http://localhost/community-php/?page=admin-template&amp;id=3\">Ir a la comunidad</a><br />\r\n<br />\r\nel mensaje de claim','','completed','16','',NULL,'2014-09-11 15:59:31','admin',2,2,0,0),(156,3,'dnoguera@imagar.com','Administrador Community','Nuevo asunto del mensaje','<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://192.168.0.8/community-php/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					&nbsp;</td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						P. Simple</h2>\r\n					Esto es un mensaje de plantilla simple<br />\r\n					<br />\r\n					<a href=\"http://google.es\">Ir a google</a><br />\r\n					<a href=\"http://imagar.com\">http://imagar.com</a><br />\r\n					<br />\r\n					&nbsp;</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					El mensaje de claim de la promoción</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','','completed','16','',NULL,'2014-09-11 16:13:44','admin',2,2,0,0),(157,3,'dnoguera@imagar.com','Administrador Community','prueba de links','<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://192.168.0.8/community-php/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					&nbsp;</td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						P. Simple</h2>\r\n					Esto es un mensaje de plantilla simple<br />\r\n					<br />\r\n					<a href=\"http://google.es\">Ir a google</a><br />\r\n					<a href=\"http://imagar.com\">http://imagar.com</a><br />\r\n					<br />\r\n					&nbsp;</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					Este es el pie del mensaje</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','','completed','16','',NULL,'2014-09-11 17:39:02','admin',2,2,0,0),(158,3,'dnoguera@imagar.com','Administrador Community','Prueba email masivo','<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://192.168.0.8/community-php/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					&nbsp;</td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						P. Simple</h2>\r\n					Esto es un mensaje de plantilla simple<br />\r\n					<br />\r\n					<a href=\"http://google.es\">Ir a google</a><br />\r\n					<a href=\"http://imagar.com\">http://imagar.com</a><br />\r\n					<br />\r\n					&nbsp;</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					El pie del mensaje</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','','completed','15','',NULL,'2014-09-11 17:45:38','admin',6,6,0,0),(159,3,'dnoguera@imagar.com','Administrador Community','Mensaje de prueba','<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://192.168.0.8/community-php/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					&nbsp;</td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						P. Simple</h2>\r\n					Esto es un mensaje de plantilla simple<br />\r\n					<br />\r\n					<a href=\"http://google.es\">Ir a google</a><br />\r\n					<a href=\"http://imagar.com\">http://imagar.com</a><br />\r\n					<br />\r\n					&nbsp;</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					el pie del mensaje</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','','completed','16','',NULL,'2014-09-12 09:49:57','admin',2,2,0,0),(160,3,'dnoguera@imagar.com','Administrador Community','una prueba de blacklist','<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://192.168.0.8/community-php/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					&nbsp;</td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						P. Simple</h2>\r\n					Esto es un mensaje de plantilla simple<br />\r\n					<br />\r\n					<a href=\"http://google.es\">Ir a google</a><br />\r\n					<a href=\"http://imagar.com\">http://imagar.com</a><br />\r\n					<br />\r\n					&nbsp;</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					El pie del mensaje</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','','completed','16','',NULL,'2014-09-12 10:12:55','admin',2,2,0,0),(161,3,'dnoguera@imagar.com','Administrador Community','una prueba de blacklist2','<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://192.168.0.8/community-php/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					&nbsp;</td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						P. Simple</h2>\r\n					Esto es un mensaje de plantilla simple<br />\r\n					<br />\r\n					<a href=\"http://google.es\">Ir a google</a><br />\r\n					<a href=\"http://imagar.com\">http://imagar.com</a><br />\r\n					<br />\r\n					&nbsp;</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					peeeeeeeeeeeeee</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','','completed','16','',NULL,'2014-09-12 10:30:45','admin',2,2,0,0),(162,3,'dnoguera@imagar.com','Administrador Community','una prueba de blacklist3','<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://192.168.0.8/community-php/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					&nbsp;</td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						P. Simple</h2>\r\n					Esto es un mensaje de plantilla simple<br />\r\n					<br />\r\n					<a href=\"http://google.es\">Ir a google</a><br />\r\n					<a href=\"http://imagar.com\">http://imagar.com</a><br />\r\n					<br />\r\n					&nbsp;</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					peeeeeeeeeeeeee</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','','completed','16','',NULL,'2014-09-12 10:35:14','admin',1,1,0,0),(163,3,'dnoguera@imagar.com','Administrador Community','El asunto del mensaje','<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"10px\" style=\"background-color:#f0f0f0;\" width=\"600\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://192.168.0.8/community-php/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					&nbsp;</td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						P. Simple</h2>\r\n					Esto es un mensaje de plantilla simple<br />\r\n					<br />\r\n					<a href=\"http://google.es\">Ir a google</a><br />\r\n					<a href=\"http://imagar.com\">http://imagar.com</a><br />\r\n					<br />\r\n					Ahora tienes un descuento de <span style=\"font-size: 26px;\"><strong>10%</strong></span>, aprovechalo<br />\r\n					<br />\r\n					&nbsp;</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					<span style=\"color: rgb(0, 153, 204);\">Te mantendremos informado de las promociones</span></td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','','completed','16','',NULL,'2014-09-12 12:28:06','admin',2,2,0,0);

/*Table structure for table `mailing_messages_files` */

DROP TABLE IF EXISTS `mailing_messages_files`;

CREATE TABLE `mailing_messages_files` (
  `id_file` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_message` int(11) unsigned NOT NULL DEFAULT '0',
  `file_name` text,
  PRIMARY KEY (`id_file`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `mailing_messages_files` */

/*Table structure for table `mailing_messages_links` */

DROP TABLE IF EXISTS `mailing_messages_links`;

CREATE TABLE `mailing_messages_links` (
  `id_link` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_message` int(11) NOT NULL DEFAULT '0',
  `link_name` text NOT NULL,
  `url` text NOT NULL,
  `clicks` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_link`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

/*Data for the table `mailing_messages_links` */

insert  into `mailing_messages_links`(`id_link`,`id_message`,`link_name`,`url`,`clicks`) values (1,138,'','http://css-tricks.com/',3),(2,149,'','http://www.css-tricks.com',0),(3,150,'','http://www.css-tricks.com',0),(4,150,'','Ir a la comunidad',0),(5,151,'','http://www.css-tricks.com',0),(6,151,'','http://localhost/community-php/?page=admin-template&id=3',0),(7,152,'','http://www.css-tricks.com',0),(8,152,'','http://localhost/community-php/?page=admin-template&id=3',0),(9,152,'','http://www.css-tricks.com',0),(10,152,'','http://localhost/community-php/?page=admin-template&id=3',0),(11,152,'','http://192.168.0.8/community-php/?page=unsuscribe&u=cgonzalez@imagar.com&ua=822478ef4949846cbc9088b45ced6d9d78a1c453',0),(12,152,'','http://www.css-tricks.com',0),(13,152,'','http://localhost/community-php/?page=admin-template&id=3',0),(14,152,'','http://www.css-tricks.com',0),(15,152,'','http://localhost/community-php/?page=admin-template&id=3',0),(16,152,'','http://192.168.0.8/community-php/?page=unsuscribe&u=dmarchante@imagar.com&ua=3fbb456567f6ae20c4302936940907cb17b8b648',0),(17,152,'','http://www.css-tricks.com',0),(18,152,'','http://localhost/community-php/?page=admin-template&id=3',0),(19,152,'','http://www.css-tricks.com',0),(20,152,'','http://localhost/community-php/?page=admin-template&id=3',0),(21,152,'','http://192.168.0.8/community-php/?page=unsuscribe&u=dnoguera@imagar.com&ua=98009c00b8450c056dde18db1ea59a13afd34af0',0),(22,152,'','http://www.css-tricks.com',0),(23,152,'','http://localhost/community-php/?page=admin-template&id=3',0),(24,152,'','http://www.css-tricks.com',0),(25,152,'','http://localhost/community-php/?page=admin-template&id=3',0),(26,152,'','http://192.168.0.8/community-php/?page=unsuscribe&u=odelgado@imagar.com&ua=1c391ec5c877caf727ec5f4e9f914e2d8b58012b',0),(27,152,'','http://www.css-tricks.com',0),(28,152,'','http://localhost/community-php/?page=admin-template&id=3',0),(29,152,'','http://www.css-tricks.com',0),(30,152,'','http://localhost/community-php/?page=admin-template&id=3',0),(31,152,'','http://192.168.0.8/community-php/?page=unsuscribe&u=pramos@imagar.com&ua=6ee442b8c3c3ec7a44e08afa4daf2700915b9fca',0),(32,152,'','http://www.css-tricks.com',0),(33,152,'','http://localhost/community-php/?page=admin-template&id=3',0),(34,152,'','http://www.css-tricks.com',0),(35,152,'','http://localhost/community-php/?page=admin-template&id=3',0),(36,152,'','http://192.168.0.8/community-php/?page=unsuscribe&u=shermida@imagar.com&ua=9db4fc9c2b1e9821708c9293382b9befc8ce7124',0),(37,153,'','http://www.css-tricks.com',0),(38,153,'','http://localhost/community-php/?page=admin-template&id=3',0),(39,154,'','http://www.css-tricks.com',0),(40,154,'','http://localhost/community-php/?page=admin-template&id=3',0),(41,155,'','http://www.css-tricks.com',0),(42,155,'','http://localhost/community-php/?page=admin-template&id=3',0),(43,156,'Ir a google','http://google.es',4),(44,156,'http://imagar.com','http://imagar.com',3),(45,157,'Ir a google','http://google.es',1),(46,157,'http://imagar.com','http://imagar.com',1),(47,158,'Ir a google','http://google.es',4),(48,158,'http://imagar.com','http://imagar.com',6),(49,159,'Ir a google','http://google.es',1),(50,159,'http://imagar.com','http://imagar.com',0),(51,160,'Ir a google','http://google.es',1),(52,160,'http://imagar.com','http://imagar.com',0),(53,161,'Ir a google','http://google.es',2),(54,161,'http://imagar.com','http://imagar.com',1),(55,162,'Ir a google','http://google.es',0),(56,162,'http://imagar.com','http://imagar.com',0),(57,163,'Ir a google','http://google.es',0),(58,163,'http://imagar.com','http://imagar.com',0);

/*Table structure for table `mailing_messages_links_users` */

DROP TABLE IF EXISTS `mailing_messages_links_users`;

CREATE TABLE `mailing_messages_links_users` (
  `id_link_user` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_link` int(11) NOT NULL,
  `id_message` int(11) NOT NULL,
  `username` varchar(100) NOT NULL DEFAULT '',
  `username_email` varchar(250) NOT NULL DEFAULT '',
  `date_link` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_link_user`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=latin1;

/*Data for the table `mailing_messages_links_users` */

insert  into `mailing_messages_links_users`(`id_link_user`,`id_link`,`id_message`,`username`,`username_email`,`date_link`) values (1,1,0,'','pramos@imagar.com','2014-09-11 11:07:49'),(2,1,0,'','odelgado@imagar.com','2014-09-11 11:08:20'),(3,1,0,'','pramos@imagar.com','2014-09-11 11:08:38'),(4,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:32'),(5,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:32'),(6,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),(7,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),(8,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),(9,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),(10,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),(11,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),(12,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),(13,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),(14,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),(15,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),(16,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),(17,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),(18,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),(19,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),(20,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),(21,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),(22,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),(23,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),(24,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),(25,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:18'),(26,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),(27,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),(28,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),(29,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),(30,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),(31,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),(32,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),(33,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),(34,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),(35,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),(36,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),(37,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),(38,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),(39,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),(40,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),(41,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),(42,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),(43,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),(44,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),(45,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),(46,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:52'),(47,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:33'),(48,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:33'),(49,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:33'),(50,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:33'),(51,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:33'),(52,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:33'),(53,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),(54,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),(55,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),(56,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),(57,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),(58,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),(59,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),(60,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),(61,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),(62,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),(63,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),(64,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),(65,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),(66,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),(67,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),(68,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:47'),(69,43,156,'','dnoguera@imagar.com','2014-09-11 16:31:23'),(70,44,156,'','dnoguera@imagar.com','2014-09-11 16:31:37'),(71,43,156,'','dnoguera@imagar.com','2014-09-11 16:31:40'),(72,44,156,'','dnoguera@imagar.com','2014-09-11 16:31:44'),(73,43,156,'','dnoguera@imagar.com','2014-09-11 16:31:46'),(74,44,156,'','dnoguera@imagar.com','2014-09-11 16:31:48'),(75,43,156,'','dnoguera@imagar.com','2014-09-11 16:32:12'),(76,45,157,'','dnoguera@imagar.com','2014-09-11 17:43:08'),(77,46,157,'','dnoguera@imagar.com','2014-09-11 17:43:27'),(78,47,158,'','dmarchante@imagar.com','2014-09-11 17:54:42'),(79,48,158,'','dmarchante@imagar.com','2014-09-11 17:54:48'),(80,48,158,'','pramos@imagar.com','2014-09-11 17:59:36'),(81,47,158,'','pramos@imagar.com','2014-09-11 18:00:03'),(82,48,158,'','dnoguera@imagar.com','2014-09-11 18:00:41'),(83,48,158,'','pramos@imagar.com','2014-09-11 18:00:56'),(84,47,158,'','shermida@imagar.com','2014-09-11 18:01:26'),(85,48,158,'','shermida@imagar.com','2014-09-11 18:01:30'),(86,48,158,'','odelgado@imagar.com','2014-09-12 08:36:53'),(87,47,158,'','odelgado@imagar.com','2014-09-12 08:37:15'),(88,49,159,'','dnoguera@imagar.com','2014-09-12 09:59:25'),(89,51,160,'','dnoguera@imagar.com','2014-09-12 10:15:44'),(90,53,161,'','dnoguera@imagar.com','2014-09-12 10:33:47'),(91,54,161,'','dnoguera@imagar.com','2014-09-12 10:33:54'),(92,53,161,'','dnoguera@imagar.com','2014-09-12 10:36:18');

/*Table structure for table `mailing_messages_users` */

DROP TABLE IF EXISTS `mailing_messages_users`;

CREATE TABLE `mailing_messages_users` (
  `id_message_user` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_message` int(11) NOT NULL DEFAULT '0',
  `username_message` varchar(100) NOT NULL DEFAULT '',
  `email_message` varchar(250) NOT NULL DEFAULT '',
  `date_send` datetime DEFAULT NULL,
  `message_status` varchar(100) NOT NULL DEFAULT 'pending',
  `views` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_message_user`),
  KEY `id_message` (`id_message`),
  KEY `message_status` (`message_status`),
  KEY `username_message` (`username_message`)
) ENGINE=InnoDB AUTO_INCREMENT=867 DEFAULT CHARSET=latin1;

/*Data for the table `mailing_messages_users` */

insert  into `mailing_messages_users`(`id_message_user`,`id_message`,`username_message`,`email_message`,`date_send`,`message_status`,`views`) values (1,1,'admin','','2014-03-18 17:23:33','completed',0),(2,1,'creativo','','2014-03-18 17:23:28','completed',0),(3,2,'admin','',NULL,'pending',0),(4,2,'creativo','',NULL,'pending',0),(5,7,'admin','dnoguera@imagar.com',NULL,'black_list',4),(6,7,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(7,7,'8943573','algo@imagar.com',NULL,'pending',11),(8,7,'34534555','dnoguera@kk.com',NULL,'pending',0),(9,7,'4455554','admin@kk.com',NULL,'pending',0),(10,7,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),(11,7,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),(12,7,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),(13,7,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),(14,7,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),(15,7,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),(16,7,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(17,6,'20266370N','dnoguera@imagar.com','2014-03-21 09:51:44','failed',0),(18,8,'admin','dnoguera@imagar2.com','2014-03-23 13:00:31','failed',0),(19,8,'creativo','dnoguera@imagar3.com','2014-03-23 13:00:31','failed',0),(20,8,'8943573','algo@imagar1.com','2014-03-23 13:00:31','failed',0),(21,8,'34534555','dnoguera@kk.com','2014-03-23 13:00:31','failed',0),(22,8,'4455554','admin@kk.com','2014-03-23 13:01:12','failed',0),(23,8,'20266370S','dgarcia@imagar.com','2014-03-23 13:01:12','failed',0),(24,8,'20266370R','shermida@imagar.com','2014-03-23 13:01:12','failed',0),(25,8,'20266370V','pramos@imagar.com','2014-03-23 13:01:12','failed',0),(26,8,'20266370X','dnoguera@gmail2.com','2014-03-23 13:01:46','failed',0),(27,8,'20266370Q','nogueradavid@hotmail3.com','2014-03-23 13:01:46','failed',0),(28,8,'20266370A','nogueradavid@hotmail2.com','2014-03-23 13:01:46','failed',0),(29,8,'20266370N','dnoguera@imagar.com','2014-03-23 13:01:46','failed',0),(30,9,'admin','dnoguera@imagar.com','2014-03-21 12:59:35','black_list',0),(31,9,'creativo','dnoguera@imagar.com','2014-03-21 12:59:35','black_list',0),(32,9,'8943573','algo@imagar.com','2014-03-21 12:59:35','pending',0),(33,9,'34534555','dnoguera@kk.com','2014-03-21 12:59:35','pending',0),(34,9,'4455554','admin@kk.com','2014-03-21 12:59:40','pending',0),(35,9,'20266370S','dnoguera1@imagar1.com','2014-03-21 12:59:40','pending',0),(36,9,'20266370R','dnoguera@imagar1.com','2014-03-21 12:59:40','pending',0),(37,9,'20266370V','dnoguera@hotmail1.com','2014-03-21 12:59:40','pending',0),(38,9,'20266370X','dnoguera@gmail2.com','2014-03-21 12:59:45','pending',0),(39,9,'20266370Q','nogueradavid@hotmail3.com','2014-03-21 12:59:45','pending',0),(40,9,'20266370A','nogueradavid@hotmail2.com','2014-03-21 12:59:45','pending',0),(41,9,'20266370N','dnoguera@imagar.com','2014-03-21 12:59:46','black_list',0),(42,10,'admin','dnoguera@imagar.com','2014-03-24 12:55:48','failed',0),(43,10,'creativo','dnoguera@imagar.com','2014-03-24 12:55:48','failed',0),(44,10,'8943573','algo@imagar.com','2014-03-24 12:55:48','failed',0),(45,10,'34534555','dnoguera@kk.com','2014-03-24 12:55:48','failed',0),(46,10,'4455554','admin@kk.com','2014-03-24 12:55:52','failed',0),(47,10,'20266370S','dnoguera1@imagar1.com','2014-03-24 12:55:52','failed',0),(48,10,'20266370R','dnoguera@imagar1.com','2014-03-24 12:55:52','failed',0),(49,10,'20266370V','dnoguera@hotmail1.com','2014-03-24 12:55:52','failed',0),(50,10,'20266370X','dnoguera@gmail2.com','2014-03-24 12:57:46','failed',0),(51,10,'20266370Q','nogueradavid@hotmail3.com','2014-03-24 12:57:46','failed',0),(52,10,'20266370A','nogueradavid@hotmail2.com','2014-03-24 12:57:46','failed',0),(53,10,'20266370N','dnoguera@imagar.com','2014-03-24 12:57:46','failed',0),(54,11,'admin','dnoguera@imagar.com','2014-03-23 16:13:20','failed',0),(55,11,'creativo','dnoguera@imagar.com','2014-03-23 16:13:20','failed',0),(56,11,'8943573','algo@imagar.com','2014-03-23 16:13:20','failed',0),(57,11,'34534555','dnoguera@kk.com','2014-03-23 16:13:20','failed',0),(58,11,'4455554','admin@kk.com','2014-03-23 16:08:47','failed',0),(59,11,'20266370S','dnoguera1@imagar1.com','2014-03-23 16:08:47','failed',0),(60,11,'20266370R','dnoguera@imagar1.com','2014-03-23 16:08:47','failed',0),(61,11,'20266370V','dnoguera@hotmail1.com','2014-03-23 16:08:47','failed',0),(62,11,'20266370X','dnoguera@gmail2.com','2014-03-23 16:09:08','failed',0),(63,11,'20266370Q','nogueradavid@hotmail3.com','2014-03-23 16:09:08','failed',0),(64,11,'20266370A','nogueradavid@hotmail2.com','2014-03-23 16:09:08','failed',0),(65,11,'20266370N','dnoguera@imagar.com','2014-03-23 16:09:08','failed',0),(66,12,'admin','dnoguera@imagar.com','2014-03-23 16:25:27','failed',0),(67,12,'creativo','dnoguera@imagar.com','2014-03-23 16:25:27','failed',0),(68,12,'8943573','algo@imagar.com','2014-03-23 16:25:27','failed',0),(69,12,'34534555','dnoguera@kk.com','2014-03-23 16:25:27','failed',0),(70,12,'4455554','admin@kk.com','2014-03-23 16:24:38','failed',0),(71,12,'20266370S','dnoguera1@imagar1.com','2014-03-23 16:24:38','failed',0),(72,12,'20266370R','dnoguera@imagar1.com','2014-03-23 16:24:38','failed',0),(73,12,'20266370V','dnoguera@hotmail1.com','2014-03-23 16:24:38','failed',0),(74,12,'20266370X','dnoguera@gmail2.com','2014-03-23 16:25:24','failed',0),(75,12,'20266370Q','nogueradavid@hotmail3.com','2014-03-23 16:25:24','failed',0),(76,12,'20266370A','nogueradavid@hotmail2.com','2014-03-23 16:25:24','failed',0),(77,12,'20266370N','dnoguera@imagar.com','2014-03-23 16:25:24','failed',0),(78,13,'admin','dnoguera@imagar.com','2014-03-23 16:26:48','failed',0),(79,13,'creativo','dnoguera@imagar.com','2014-03-23 16:26:48','failed',0),(80,13,'8943573','algo@imagar.com','2014-03-23 16:26:48','failed',0),(81,13,'34534555','dnoguera@kk.com','2014-03-23 16:26:48','failed',0),(82,13,'4455554','admin@kk.com','2014-03-23 16:26:06','failed',0),(83,13,'20266370S','dnoguera1@imagar1.com','2014-03-23 16:26:06','failed',0),(84,13,'20266370R','dnoguera@imagar1.com','2014-03-23 16:26:06','failed',0),(85,13,'20266370V','dnoguera@hotmail1.com','2014-03-23 16:26:06','failed',0),(86,13,'20266370X','dnoguera@gmail2.com','2014-03-23 16:26:11','failed',0),(87,13,'20266370Q','nogueradavid@hotmail3.com','2014-03-23 16:26:11','failed',0),(88,13,'20266370A','nogueradavid@hotmail2.com','2014-03-23 16:26:11','failed',0),(89,13,'20266370N','dnoguera@imagar.com','2014-03-23 16:26:11','failed',0),(90,14,'admin','dnoguera@imagar.com','2014-03-23 16:27:07','failed',0),(91,14,'creativo','dnoguera@imagar.com','2014-03-23 16:27:07','failed',0),(92,14,'8943573','algo@imagar.com','2014-03-23 16:27:07','failed',0),(93,14,'34534555','dnoguera@kk.com','2014-03-23 16:27:07','failed',0),(94,14,'4455554','admin@kk.com','2014-03-23 16:27:17','failed',0),(95,14,'20266370S','dnoguera1@imagar1.com','2014-03-23 16:27:17','failed',0),(96,14,'20266370R','dnoguera@imagar1.com','2014-03-23 16:27:17','failed',0),(97,14,'20266370V','dnoguera@hotmail1.com','2014-03-23 16:27:17','failed',0),(98,14,'20266370X','dnoguera@gmail2.com','2014-03-23 16:27:22','failed',0),(99,14,'20266370Q','nogueradavid@hotmail3.com','2014-03-23 16:27:22','failed',0),(100,14,'20266370A','nogueradavid@hotmail2.com','2014-03-23 16:27:22','failed',0),(101,14,'20266370N','dnoguera@imagar.com','2014-03-23 16:27:22','failed',0),(102,15,'admin','dnoguera@imagar.com','2014-03-23 16:28:20','failed',0),(103,15,'creativo','dnoguera@imagar.com','2014-03-23 16:28:20','failed',0),(104,15,'8943573','algo@imagar.com','2014-03-23 16:28:20','failed',0),(105,15,'34534555','dnoguera@kk.com','2014-03-23 16:28:20','failed',0),(106,15,'4455554','admin@kk.com','2014-03-23 16:28:30','failed',0),(107,15,'20266370S','dnoguera1@imagar1.com','2014-03-23 16:28:30','failed',0),(108,15,'20266370R','dnoguera@imagar1.com','2014-03-23 16:28:30','failed',0),(109,15,'20266370V','dnoguera@hotmail1.com','2014-03-23 16:28:30','failed',0),(110,15,'20266370X','dnoguera@gmail2.com','2014-03-23 16:28:35','failed',0),(111,15,'20266370Q','nogueradavid@hotmail3.com','2014-03-23 16:28:35','failed',0),(112,15,'20266370A','nogueradavid@hotmail2.com','2014-03-23 16:28:35','failed',0),(113,15,'20266370N','dnoguera@imagar.com','2014-03-23 16:28:35','failed',0),(114,16,'admin','dnoguera@imagar.com','2014-03-23 16:29:46','failed',0),(115,16,'creativo','dnoguera@imagar.com','2014-03-23 16:29:46','failed',0),(116,16,'8943573','algo@imagar.com','2014-03-23 16:29:46','failed',0),(117,16,'34534555','dnoguera@kk.com','2014-03-23 16:29:46','failed',0),(118,16,'4455554','admin@kk.com','2014-03-23 16:29:56','failed',0),(119,16,'20266370S','dnoguera1@imagar1.com','2014-03-23 16:29:56','failed',0),(120,16,'20266370R','dnoguera@imagar1.com','2014-03-23 16:29:56','failed',0),(121,16,'20266370V','dnoguera@hotmail1.com','2014-03-23 16:29:56','failed',0),(122,16,'20266370X','dnoguera@gmail2.com','2014-03-23 16:30:01','failed',0),(123,16,'20266370Q','nogueradavid@hotmail3.com','2014-03-23 16:30:01','failed',0),(124,16,'20266370A','nogueradavid@hotmail2.com','2014-03-23 16:30:01','failed',0),(125,16,'20266370N','dnoguera@imagar.com','2014-03-23 16:30:01','failed',0),(126,17,'admin','dnoguera@imagar.com','2014-03-23 16:30:50','failed',0),(127,17,'creativo','dnoguera@imagar.com','2014-03-23 16:30:50','failed',0),(128,17,'8943573','algo@imagar.com','2014-03-23 16:30:50','failed',0),(129,17,'34534555','dnoguera@kk.com','2014-03-23 16:30:50','failed',0),(130,17,'4455554','admin@kk.com','2014-03-23 16:31:00','failed',0),(131,17,'20266370S','dnoguera1@imagar1.com','2014-03-23 16:31:00','failed',0),(132,17,'20266370R','dnoguera@imagar1.com','2014-03-23 16:31:00','failed',0),(133,17,'20266370V','dnoguera@hotmail1.com','2014-03-23 16:31:00','failed',0),(134,17,'20266370X','dnoguera@gmail2.com','2014-03-23 16:31:05','failed',0),(135,17,'20266370Q','nogueradavid@hotmail3.com','2014-03-23 16:31:05','failed',0),(136,17,'20266370A','nogueradavid@hotmail2.com','2014-03-23 16:31:05','failed',0),(137,17,'20266370N','dnoguera@imagar.com','2014-03-23 16:31:05','failed',0),(138,18,'admin','dnoguera@imagar.com','2014-03-23 16:41:16','failed',0),(139,18,'creativo','dnoguera@imagar.com','2014-03-23 16:41:16','failed',0),(140,18,'8943573','algo@imagar.com','2014-03-23 16:41:16','failed',0),(141,18,'34534555','dnoguera@kk.com','2014-03-23 16:41:16','failed',0),(142,18,'4455554','admin@kk.com','2014-03-23 16:33:02','failed',0),(143,18,'20266370S','dnoguera1@imagar1.com','2014-03-23 16:33:03','failed',0),(144,18,'20266370R','dnoguera@imagar1.com','2014-03-23 16:33:03','failed',0),(145,18,'20266370V','dnoguera@hotmail1.com','2014-03-23 16:33:03','failed',0),(146,18,'20266370X','dnoguera@gmail2.com','2014-03-23 16:33:07','failed',0),(147,18,'20266370Q','nogueradavid@hotmail3.com','2014-03-23 16:33:08','failed',0),(148,18,'20266370A','nogueradavid@hotmail2.com','2014-03-23 16:33:08','failed',0),(149,18,'20266370N','dnoguera@imagar.com','2014-03-23 16:33:08','failed',0),(150,19,'admin','dnoguera@imagar.com','2014-03-23 16:41:35','failed',0),(151,19,'creativo','dnoguera@imagar.com','2014-03-23 16:41:35','failed',0),(152,19,'8943573','algo@imagar.com','2014-03-23 16:41:35','failed',0),(153,19,'34534555','dnoguera@kk.com','2014-03-23 16:41:35','failed',0),(154,19,'4455554','admin@kk.com','2014-03-23 16:41:45','failed',0),(155,19,'20266370S','dnoguera1@imagar1.com','2014-03-23 16:41:45','failed',0),(156,19,'20266370R','dnoguera@imagar1.com','2014-03-23 16:41:45','failed',0),(157,19,'20266370V','dnoguera@hotmail1.com','2014-03-23 16:41:45','failed',0),(158,19,'20266370X','dnoguera@gmail2.com','2014-03-23 16:41:50','failed',0),(159,19,'20266370Q','nogueradavid@hotmail3.com','2014-03-23 16:41:50','failed',0),(160,19,'20266370A','nogueradavid@hotmail2.com','2014-03-23 16:41:50','failed',0),(161,19,'20266370N','dnoguera@imagar.com','2014-03-23 16:41:50','failed',0),(162,20,'admin','dnoguera@imagar.com','2014-03-23 16:45:58','failed',0),(163,20,'creativo','dnoguera@imagar.com','2014-03-23 16:45:58','failed',0),(164,20,'8943573','algo@imagar.com','2014-03-23 16:45:58','failed',0),(165,20,'34534555','dnoguera@kk.com','2014-03-23 16:45:58','failed',0),(166,20,'4455554','admin@kk.com','2014-03-23 16:46:08','failed',0),(167,20,'20266370S','dnoguera1@imagar1.com','2014-03-23 16:46:08','failed',0),(168,20,'20266370R','dnoguera@imagar1.com','2014-03-23 16:46:08','failed',0),(169,20,'20266370V','dnoguera@hotmail1.com','2014-03-23 16:46:08','failed',0),(170,20,'20266370X','dnoguera@gmail2.com','2014-03-23 16:46:13','failed',0),(171,20,'20266370Q','nogueradavid@hotmail3.com','2014-03-23 16:46:13','failed',0),(172,20,'20266370A','nogueradavid@hotmail2.com','2014-03-23 16:46:13','failed',0),(173,20,'20266370N','dnoguera@imagar.com','2014-03-23 16:46:13','failed',0),(174,21,'admin','dnoguera@imagar.com','2014-03-23 17:02:28','failed',0),(175,21,'creativo','dnoguera@imagar.com','2014-03-23 17:02:28','failed',0),(176,21,'8943573','algo@imagar.com','2014-03-23 17:02:28','failed',0),(177,21,'34534555','dnoguera@kk.com','2014-03-23 17:02:28','failed',0),(178,21,'4455554','admin@kk.com','2014-03-23 17:10:40','failed',0),(179,21,'20266370S','dnoguera1@imagar1.com','2014-03-23 17:10:40','failed',0),(180,21,'20266370R','dnoguera@imagar1.com','2014-03-23 17:10:40','failed',0),(181,21,'20266370V','dnoguera@hotmail1.com','2014-03-23 17:10:40','failed',0),(182,21,'20266370X','dnoguera@gmail2.com','2014-03-23 16:53:50','failed',0),(183,21,'20266370Q','nogueradavid@hotmail3.com','2014-03-23 16:53:50','failed',0),(184,21,'20266370A','nogueradavid@hotmail2.com','2014-03-23 16:53:50','failed',0),(185,21,'20266370N','dnoguera@imagar.com','2014-03-23 16:53:50','failed',0),(186,22,'admin','dnoguera@imagar.com','2014-03-23 17:32:36','black_list',0),(187,22,'creativo','dnoguera@imagar.com','2014-03-23 17:32:36','black_list',0),(188,22,'8943573','algo@imagar.com','2014-03-23 17:32:37','pending',0),(189,22,'34534555','dnoguera@kk.com','2014-03-23 17:32:37','pending',0),(190,22,'4455554','admin@kk.com','2014-03-23 17:30:37','pending',0),(191,22,'20266370S','dnoguera1@imagar1.com','2014-03-23 17:30:37','pending',0),(192,22,'20266370R','dnoguera@imagar1.com','2014-03-23 17:30:37','pending',0),(193,22,'20266370V','dnoguera@hotmail1.com','2014-03-23 17:30:37','pending',0),(194,22,'20266370X','dnoguera@gmail2.com','2014-03-23 17:31:21','pending',0),(195,22,'20266370Q','nogueradavid@hotmail3.com','2014-03-23 17:31:21','pending',0),(196,22,'20266370A','nogueradavid@hotmail2.com','2014-03-23 17:31:21','pending',0),(197,22,'20266370N','dnoguera@imagar.com','2014-03-23 17:31:21','black_list',0),(198,23,'admin','dnoguera@imagar.com','2014-03-23 17:18:51','failed',0),(199,23,'creativo','dnoguera@imagar.com','2014-03-23 17:18:51','failed',0),(200,23,'8943573','algo@imagar.com','2014-03-23 17:18:51','failed',0),(201,23,'34534555','dnoguera@kk.com','2014-03-23 17:18:51','failed',0),(202,23,'4455554','admin@kk.com','2014-03-23 17:18:56','failed',0),(203,23,'20266370S','dnoguera1@imagar1.com','2014-03-23 17:18:56','failed',0),(204,23,'20266370R','dnoguera@imagar1.com','2014-03-23 17:18:56','failed',0),(205,23,'20266370V','dnoguera@hotmail1.com','2014-03-23 17:18:56','failed',0),(206,23,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),(207,23,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),(208,23,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),(209,23,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(210,24,'admin','dnoguera@imagar.com','2014-03-23 17:20:24','failed',0),(211,24,'creativo','dnoguera@imagar.com','2014-03-23 17:20:24','failed',0),(212,24,'8943573','algo@imagar.com','2014-03-23 17:20:24','failed',0),(213,24,'34534555','dnoguera@kk.com','2014-03-23 17:20:24','failed',0),(214,24,'4455554','admin@kk.com','2014-03-23 17:20:29','failed',0),(215,24,'20266370S','dnoguera1@imagar1.com','2014-03-23 17:20:29','failed',0),(216,24,'20266370R','dnoguera@imagar1.com','2014-03-23 17:20:29','failed',0),(217,24,'20266370V','dnoguera@hotmail1.com','2014-03-23 17:20:29','failed',0),(218,24,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),(219,24,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),(220,24,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),(221,24,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(222,25,'admin','dnoguera@imagar.com',NULL,'black_list',0),(223,25,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(224,25,'8943573','algo@imagar.com',NULL,'pending',0),(225,25,'34534555','dnoguera@kk.com',NULL,'pending',0),(226,25,'4455554','admin@kk.com',NULL,'pending',0),(227,25,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),(228,25,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),(229,25,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),(230,25,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),(231,25,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),(232,25,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),(233,25,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(234,26,'admin','dnoguera@imagar.com','2014-03-24 17:36:09','failed',0),(235,26,'creativo','dnoguera@imagar.com','2014-03-24 17:36:09','failed',0),(236,26,'8943573','algo@imagar.com','2014-03-24 17:36:09','failed',0),(237,26,'34534555','dnoguera@kk.com','2014-03-24 17:36:09','failed',0),(238,26,'4455554','admin@kk.com','2014-03-24 17:36:16','failed',0),(239,26,'20266370S','dnoguera1@imagar1.com','2014-03-24 17:36:16','failed',0),(240,26,'20266370R','dnoguera@imagar1.com','2014-03-24 17:36:16','failed',0),(241,26,'20266370V','dnoguera@hotmail1.com','2014-03-24 17:36:16','failed',0),(242,26,'20266370X','dnoguera@gmail2.com','2014-03-24 17:33:52','failed',0),(243,26,'20266370Q','nogueradavid@hotmail3.com','2014-03-24 17:33:52','failed',0),(244,26,'20266370A','nogueradavid@hotmail2.com','2014-03-24 17:33:53','failed',0),(245,26,'20266370N','dnoguera@imagar.com','2014-03-24 17:33:53','failed',0),(246,27,'admin','dnoguera@imagar.com','2014-03-24 17:33:14','failed',0),(247,27,'creativo','dnoguera@imagar.com','2014-03-24 17:33:14','failed',0),(248,27,'8943573','algo@imagar.com','2014-03-24 17:33:14','failed',0),(249,27,'34534555','dnoguera@kk.com','2014-03-24 17:33:14','failed',0),(250,27,'4455554','admin@kk.com','2014-03-24 17:33:00','failed',0),(251,27,'20266370S','dnoguera1@imagar1.com','2014-03-24 17:33:01','failed',0),(252,27,'20266370R','dnoguera@imagar1.com','2014-03-24 17:33:01','failed',0),(253,27,'20266370V','dnoguera@hotmail1.com','2014-03-24 17:33:01','failed',0),(254,27,'20266370X','dnoguera@gmail2.com','2014-03-24 17:33:05','failed',0),(255,27,'20266370Q','nogueradavid@hotmail3.com','2014-03-24 17:33:06','failed',0),(256,27,'20266370A','nogueradavid@hotmail2.com','2014-03-24 17:33:06','failed',0),(257,27,'20266370N','dnoguera@imagar.com','2014-03-24 17:33:06','failed',0),(258,28,'admin','dnoguera@imagar.com',NULL,'black_list',0),(259,28,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(260,28,'8943573','algo@imagar.com',NULL,'pending',0),(261,28,'34534555','dnoguera@kk.com',NULL,'pending',0),(262,28,'4455554','admin@kk.com',NULL,'pending',0),(263,28,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),(264,28,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),(265,28,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),(266,28,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),(267,28,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),(268,28,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),(269,28,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(270,29,'admin','dnoguera@imagar.com',NULL,'black_list',0),(271,29,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(272,29,'8943573','algo@imagar.com',NULL,'pending',0),(273,29,'34534555','dnoguera@kk.com',NULL,'pending',0),(274,29,'4455554','admin@kk.com',NULL,'pending',0),(275,29,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),(276,29,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),(277,29,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),(278,29,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),(279,29,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),(280,29,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),(281,29,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(282,30,'admin','dnoguera@imagar.com',NULL,'black_list',0),(283,30,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(284,30,'8943573','algo@imagar.com',NULL,'pending',0),(285,30,'34534555','dnoguera@kk.com',NULL,'pending',0),(286,30,'4455554','admin@kk.com',NULL,'pending',0),(287,30,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),(288,30,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),(289,30,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),(290,30,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),(291,30,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),(292,30,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),(293,30,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(294,31,'admin','dnoguera@imagar.com',NULL,'black_list',0),(295,31,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(296,31,'8943573','algo@imagar.com',NULL,'pending',0),(297,31,'34534555','dnoguera@kk.com',NULL,'pending',0),(298,31,'4455554','admin@kk.com',NULL,'pending',0),(299,31,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),(300,31,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),(301,31,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),(302,31,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),(303,31,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),(304,31,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),(305,31,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(306,32,'admin','dnoguera@imagar.com',NULL,'black_list',0),(307,32,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(308,32,'8943573','algo@imagar.com',NULL,'pending',0),(309,32,'34534555','dnoguera@kk.com',NULL,'pending',0),(310,32,'4455554','admin@kk.com',NULL,'pending',0),(311,32,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),(312,32,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),(313,32,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),(314,32,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),(315,32,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),(316,32,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),(317,32,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(318,33,'admin','dnoguera@imagar.com',NULL,'black_list',0),(319,33,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(320,33,'8943573','algo@imagar.com',NULL,'pending',0),(321,33,'34534555','dnoguera@kk.com',NULL,'pending',0),(322,33,'4455554','admin@kk.com',NULL,'pending',0),(323,33,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),(324,33,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),(325,33,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),(326,33,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),(327,33,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),(328,33,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),(329,33,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(330,34,'admin','dnoguera@imagar.com',NULL,'black_list',0),(331,34,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(332,34,'8943573','algo@imagar.com',NULL,'pending',0),(333,34,'34534555','dnoguera@kk.com',NULL,'pending',0),(334,34,'4455554','admin@kk.com',NULL,'pending',0),(335,34,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),(336,34,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),(337,34,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),(338,34,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),(339,34,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),(340,34,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),(341,34,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(342,35,'admin','dnoguera@imagar.com',NULL,'black_list',0),(343,35,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(344,35,'8943573','algo@imagar.com',NULL,'pending',0),(345,35,'34534555','dnoguera@kk.com',NULL,'pending',0),(346,35,'4455554','admin@kk.com',NULL,'pending',0),(347,35,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),(348,35,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),(349,35,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),(350,35,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),(351,35,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),(352,35,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),(353,35,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(354,36,'admin','dnoguera@imagar.com',NULL,'black_list',0),(355,36,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(356,36,'8943573','algo@imagar.com',NULL,'pending',0),(357,36,'34534555','dnoguera@kk.com',NULL,'pending',0),(358,36,'4455554','admin@kk.com',NULL,'pending',0),(359,36,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),(360,36,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),(361,36,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),(362,36,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),(363,36,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),(364,36,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),(365,36,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(366,37,'admin','dnoguera@imagar.com',NULL,'black_list',0),(367,37,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(368,37,'8943573','algo@imagar.com',NULL,'pending',0),(369,37,'34534555','dnoguera@kk.com',NULL,'pending',0),(370,37,'4455554','admin@kk.com',NULL,'pending',0),(371,37,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),(372,37,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),(373,37,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),(374,37,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),(375,37,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),(376,37,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),(377,37,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(378,38,'admin','dnoguera@imagar.com',NULL,'black_list',0),(379,38,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(380,38,'8943573','algo@imagar.com',NULL,'pending',0),(381,38,'34534555','dnoguera@kk.com',NULL,'pending',0),(382,38,'4455554','admin@kk.com',NULL,'pending',0),(383,38,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),(384,38,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),(385,38,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),(386,38,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),(387,38,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),(388,38,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),(389,38,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(390,39,'admin','dnoguera@imagar.com',NULL,'black_list',0),(391,39,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(392,39,'8943573','algo@imagar.com',NULL,'pending',0),(393,39,'34534555','dnoguera@kk.com',NULL,'pending',0),(394,39,'4455554','admin@kk.com',NULL,'pending',0),(395,39,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),(396,39,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),(397,39,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),(398,39,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),(399,39,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),(400,39,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),(401,39,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(402,40,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),(403,40,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),(404,41,'20266370X','dnoguera@gmail2.com','2014-03-25 09:22:34','failed',0),(405,42,'creativo','dnoguera@imagar.com','2014-03-24 16:37:00','failed',0),(406,42,'8943573','algo@imagar.com','2014-03-24 16:37:00','failed',0),(407,42,'34534555','dnoguera@kk.com','2014-03-24 16:37:00','failed',0),(408,42,'4455554','admin@kk.com','2014-03-24 16:37:00','failed',0),(409,42,'20266370S','dnoguera1@imagar1.com','2014-03-24 16:37:10','failed',0),(410,42,'20266370R','dnoguera@imagar1.com','2014-03-24 16:37:10','failed',0),(411,42,'20266370Q','nogueradavid@hotmail3.com','2014-03-24 16:37:10','failed',0),(412,42,'20266370N','dnoguera@imagar.com','2014-03-24 16:37:10','failed',0),(413,43,'admin','dnoguera@imagar.com','2014-03-24 17:29:02','failed',0),(414,43,'creativo','dnoguera@imagar.com','2014-03-24 17:29:02','failed',0),(415,44,'admin','dnoguera@imagar.com','2014-03-25 09:23:11','failed',0),(416,44,'creativo','dnoguera@imagar.com','2014-03-25 09:23:11','failed',0),(417,44,'8943573','algo@imagar.com','2014-03-25 09:23:11','failed',0),(418,44,'34534555','dnoguera@kk.com','2014-03-25 09:23:11','failed',0),(419,44,'4455554','admin@kk.com','2014-03-25 09:23:16','failed',0),(420,44,'20266370S','dnoguera1@imagar1.com','2014-03-25 09:23:16','failed',0),(421,44,'20266370R','dnoguera@imagar1.com','2014-03-25 09:23:16','failed',0),(422,44,'20266370V','dnoguera@hotmail1.com','2014-03-25 09:23:16','failed',0),(423,44,'20266370X','dnoguera@gmail2.com','2014-03-25 09:23:21','failed',0),(424,44,'20266370Q','nogueradavid@hotmail3.com','2014-03-25 09:23:21','failed',0),(425,44,'20266370A','nogueradavid@hotmail2.com','2014-03-25 09:23:21','failed',0),(426,44,'20266370N','dnoguera@imagar.com','2014-03-25 09:23:21','failed',0),(427,45,'admin','dnoguera@imagar.com',NULL,'black_list',0),(428,45,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(429,45,'8943573','algo@imagar.com',NULL,'pending',0),(430,45,'34534555','dnoguera@kk.com',NULL,'pending',0),(431,45,'4455554','admin@kk.com',NULL,'pending',0),(432,45,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),(433,45,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),(434,45,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),(435,45,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),(436,45,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),(437,45,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),(438,45,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(439,46,'admin','dnoguera@imagar.com','2014-03-26 11:54:40','failed',0),(440,46,'creativo','dnoguera@imagar.com','2014-03-26 11:54:40','failed',0),(441,46,'8943573','algo@imagar.com','2014-03-26 11:54:40','failed',0),(442,46,'34534555','dnoguera@kk.com','2014-03-26 11:54:40','failed',0),(443,46,'4455554','admin@kk.com','2014-03-26 11:54:45','failed',0),(444,46,'20266370S','dnoguera1@imagar1.com','2014-03-26 11:54:45','failed',0),(445,46,'20266370R','dnoguera@imagar1.com','2014-03-26 11:54:45','failed',0),(446,46,'20266370V','dnoguera@hotmail1.com','2014-03-26 11:54:45','failed',0),(447,46,'20266370X','dnoguera@gmail2.com','2014-03-26 11:54:50','failed',0),(448,46,'20266370Q','nogueradavid@hotmail3.com','2014-03-26 11:54:50','failed',0),(449,46,'20266370A','nogueradavid@hotmail2.com','2014-03-26 11:54:50','failed',0),(450,46,'20266370I','dnoguera@imagar.com','2014-03-26 11:54:50','failed',0),(451,46,'20266370N','dnoguera@imagar.com','2014-03-26 11:54:55','failed',0),(452,46,'responsable1','dnoguera@imagar.com','2014-03-26 11:54:55','failed',0),(453,46,'responsable2','dnoguera@imagar.com','2014-03-26 11:54:55','failed',0),(454,47,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(455,47,'8943573','algo@imagar.com',NULL,'pending',0),(456,47,'34534555','dnoguera@kk.com',NULL,'pending',0),(457,47,'4455554','admin@kk.com',NULL,'pending',0),(458,47,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),(459,47,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),(460,47,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),(461,47,'20266370I','dnoguera@imagar.com',NULL,'black_list',0),(462,47,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(463,48,'admin','dnoguera@imagar.com',NULL,'black_list',0),(464,48,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(465,49,'admin','dnoguera@imagar.com',NULL,'black_list',0),(466,49,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(467,50,'admin','dnoguera@imagar.com',NULL,'black_list',0),(468,50,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(469,51,'admin','dnoguera@imagar.com',NULL,'black_list',0),(470,51,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(471,57,'admin','dnoguera@imagar.com',NULL,'black_list',0),(472,57,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(473,57,'8943573','algo@imagar.com',NULL,'pending',0),(474,57,'34534555','dnoguera@kk.com',NULL,'pending',0),(475,57,'4455554','admin@kk.com',NULL,'pending',0),(476,57,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),(477,57,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),(478,57,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),(479,57,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),(480,57,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),(481,57,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),(482,57,'20266370I','dnoguera@imagar.com',NULL,'black_list',0),(483,57,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(484,57,'responsable1','dnoguera@imagar.com',NULL,'black_list',0),(485,57,'responsable2','dnoguera@imagar.com',NULL,'black_list',0),(486,61,'admin','dnoguera@imagar.com',NULL,'black_list',0),(487,61,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(488,61,'8943573','algo@imagar.com',NULL,'pending',0),(489,61,'34534555','dnoguera@kk.com',NULL,'pending',0),(490,61,'4455554','admin@kk.com',NULL,'pending',0),(491,61,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),(492,61,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),(493,61,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),(494,61,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),(495,61,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),(496,61,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),(497,61,'20266370I','dnoguera@imagar.com',NULL,'black_list',0),(498,61,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(499,61,'responsable1','dnoguera@imagar.com',NULL,'black_list',0),(500,61,'responsable2','dnoguera@imagar.com',NULL,'black_list',0),(501,68,'admin','dnoguera@imagar.com',NULL,'black_list',0),(502,68,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(503,68,'8943573','algo@imagar.com',NULL,'pending',0),(504,68,'34534555','dnoguera@kk.com',NULL,'pending',0),(505,68,'4455554','admin@kk.com',NULL,'pending',0),(506,68,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),(507,68,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),(508,68,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),(509,68,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),(510,68,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),(511,68,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),(512,68,'20266370I','dnoguera@imagar.com',NULL,'black_list',0),(513,68,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(514,68,'responsable1','dnoguera@imagar.com',NULL,'black_list',0),(515,68,'responsable2','dnoguera@imagar.com',NULL,'black_list',0),(516,69,'admin','dnoguera@imagar.com',NULL,'black_list',0),(517,69,'34534555','dnoguera@kk.com',NULL,'pending',0),(518,69,'20266370I','dnoguera@imagar.com',NULL,'black_list',0),(519,69,'responsable1','dnoguera@imagar.com',NULL,'black_list',0),(520,70,'admin','dnoguera@imagar.com',NULL,'black_list',0),(521,70,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(522,71,'admin','dnoguera@imagar.com',NULL,'black_list',0),(523,71,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(524,72,'admin','dnoguera@imagar.com',NULL,'black_list',0),(525,72,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(526,72,'8943573','algo@imagar.com',NULL,'pending',0),(527,72,'34534555','dnoguera@kk.com',NULL,'pending',0),(528,72,'4455554','admin@kk.com',NULL,'pending',0),(529,72,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),(530,72,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),(531,72,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),(532,72,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),(533,72,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),(534,72,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),(535,72,'20266370I','dnoguera@imagar.com',NULL,'black_list',0),(536,72,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(537,72,'responsable1','dnoguera@imagar.com',NULL,'black_list',0),(538,72,'responsable2','dnoguera@imagar.com',NULL,'black_list',0),(539,73,'admin','dnoguera@imagar.com',NULL,'black_list',0),(540,73,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(541,73,'8943573','algo@imagar.com',NULL,'pending',0),(542,73,'34534555','dnoguera@kk.com',NULL,'pending',0),(543,73,'4455554','admin@kk.com',NULL,'pending',0),(544,73,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),(545,73,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),(546,73,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),(547,73,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),(548,73,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),(549,73,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),(550,73,'20266370I','dnoguera@imagar.com',NULL,'black_list',0),(551,73,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(552,73,'responsable1','dnoguera@imagar.com',NULL,'black_list',0),(553,73,'responsable2','dnoguera@imagar.com',NULL,'black_list',0),(554,74,'admin','dnoguera@imagar.com',NULL,'black_list',0),(555,74,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(556,74,'8943573','algo@imagar.com',NULL,'pending',0),(557,74,'34534555','dnoguera@kk.com',NULL,'pending',0),(558,74,'4455554','admin@kk.com',NULL,'pending',0),(559,74,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),(560,74,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),(561,74,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),(562,74,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),(563,74,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),(564,74,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),(565,74,'20266370I','dnoguera@imagar.com',NULL,'black_list',0),(566,74,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(567,74,'responsable1','dnoguera@imagar.com',NULL,'black_list',0),(568,74,'responsable2','dnoguera@imagar.com',NULL,'black_list',0),(569,75,'admin','dnoguera@imagar.com',NULL,'black_list',0),(570,75,'34534555','dnoguera@kk.com',NULL,'pending',0),(571,75,'20266370I','dnoguera@imagar.com',NULL,'black_list',0),(572,75,'responsable1','dnoguera@imagar.com',NULL,'black_list',0),(573,76,'admin','dnoguera@imagar.com',NULL,'black_list',0),(574,76,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(575,76,'8943573','algo@imagar.com',NULL,'pending',0),(576,76,'34534555','dnoguera@kk.com',NULL,'pending',0),(577,76,'4455554','admin@kk.com',NULL,'pending',0),(578,76,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),(579,76,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),(580,76,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),(581,76,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),(582,76,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),(583,76,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),(584,76,'20266370I','dnoguera@imagar.com',NULL,'black_list',0),(585,76,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(586,76,'responsable1','dnoguera@imagar.com',NULL,'black_list',0),(587,76,'responsable2','dnoguera@imagar.com',NULL,'black_list',0),(588,78,'admin','dnoguera@imagar.com',NULL,'black_list',0),(589,79,'admin','dnoguera@imagar.com',NULL,'black_list',0),(590,80,'admin','dnoguera@imagar.com',NULL,'black_list',0),(591,80,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(592,81,'admin','dnoguera@imagar.com',NULL,'black_list',0),(593,82,'20266370I','dnoguera@imagar.com',NULL,'black_list',0),(594,84,'creativo','dnoguera@imagar.com',NULL,'black_list',0),(595,84,'8943573','algo@imagar.com',NULL,'pending',0),(596,84,'4455554','admin@kk.com',NULL,'pending',0),(597,84,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),(598,84,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(599,89,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(600,90,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(601,91,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(602,92,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(603,93,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(604,93,'X6821471Q','dnoguera@imagar.com',NULL,'black_list',0),(605,94,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(606,94,'X6821471Q','dnoguera@imagar.com',NULL,'black_list',0),(607,95,'admin','dnoguera@imagar.com','2014-04-08 13:59:08','send',0),(608,95,'18050671H','dnoguera@imagar.com','2014-04-08 14:02:17','send',0),(609,95,'X6821471Q','dnoguera@imagar.com','2014-04-08 14:04:17','send',0),(610,95,'20266370N','dnoguera@imagar.com','2014-04-08 14:06:18','send',0),(611,96,'admin','dnoguera@imagar.com',NULL,'black_list',0),(612,96,'18050671H','dnoguera@imagar.com',NULL,'black_list',0),(613,96,'X6821471Q','dnoguera@imagar.com',NULL,'black_list',0),(614,96,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(615,97,'admin','dnoguera@imagar.com',NULL,'black_list',0),(616,97,'18050671H','dnoguera@imagar.com',NULL,'black_list',0),(617,97,'X6821471Q','dnoguera@imagar.com',NULL,'black_list',0),(618,97,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(619,99,'admin','dnoguera@imagar.com','2014-04-08 13:51:07','failed',0),(620,99,'18050671H','dnoguera@imagar.com','2014-04-08 13:51:07','failed',0),(621,99,'X6821471Q','dnoguera@imagar.com','2014-04-08 13:51:07','failed',0),(622,99,'20266370N','dnoguera@imagar.com','2014-04-08 13:51:07','failed',0),(623,100,'admin','dnoguera@imagar.com','2014-04-23 10:27:38','send',0),(624,100,'18050671H','dnoguera@imagar.com','2014-04-23 10:35:29','send',0),(625,100,'X6821471Q','dnoguera@imagar.com','2014-04-23 10:37:29','send',0),(626,100,'20266370N','dnoguera@imagar.com','2014-04-23 10:22:00','send',0),(627,101,'admin','dnoguera@imagar.com','2014-04-23 09:18:20','send',0),(628,103,'admin','dnoguera@imagar.com','2014-04-23 13:24:46','send',0),(629,104,'admin','dnoguera@imagar.com','2014-04-23 16:07:20','send',0),(630,105,'admin','dnoguera@imagar.com',NULL,'black_list',0),(631,105,'18050671H','dnoguera@imagar.com',NULL,'black_list',0),(632,105,'X6821471Q','dnoguera@imagar.com',NULL,'black_list',0),(633,105,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),(634,108,'','dnoguera@imagar.com',NULL,'black_list',0),(635,108,'','2dnoguera@imagar.com',NULL,'pending',0),(636,108,'','david.noguera@grg.com',NULL,'pending',0),(637,109,'','dnoguera@imagar.com',NULL,'black_list',0),(638,109,'','2dnoguera@imagar.com',NULL,'pending',0),(639,109,'','david.noguera@grg.com',NULL,'pending',0),(640,109,'','pramos@imagar.com',NULL,'pending',0),(641,112,'','dnoguera@imagar.com',NULL,'black_list',0),(642,112,'','2dnoguera@imagar.com',NULL,'pending',0),(643,112,'','david.noguera@grg.com',NULL,'pending',0),(644,112,'','pramos@imagar.com',NULL,'pending',0),(645,113,'','dnoguera@imagar.com',NULL,'black_list',0),(646,113,'','2dnoguera@imagar.com',NULL,'pending',0),(647,113,'','david.noguera@grg.com',NULL,'pending',0),(648,113,'','pramos@imagar.com',NULL,'pending',0),(649,114,'','dnoguera@imagar.com',NULL,'black_list',0),(650,114,'','2dnoguera@imagar.com',NULL,'pending',0),(651,114,'','david.noguera@grg.com',NULL,'pending',0),(652,114,'','pramos@imagar.com',NULL,'pending',0),(653,115,'','dnoguera@imagar.com',NULL,'black_list',0),(654,115,'','2dnoguera@imagar.com',NULL,'pending',0),(655,115,'','david.noguera@grg.com',NULL,'pending',0),(656,115,'','pramos@imagar.com',NULL,'pending',0),(657,116,'','dnoguera@imagar.com',NULL,'black_list',0),(658,116,'','2dnoguera@imagar.com',NULL,'pending',0),(659,116,'','david.noguera@grg.com',NULL,'pending',0),(660,116,'','pramos@imagar.com',NULL,'pending',0),(661,117,'','dnoguera@imagar.com',NULL,'black_list',0),(662,117,'','2dnoguera@imagar.com',NULL,'pending',0),(663,117,'','david.noguera@grg.com',NULL,'pending',0),(664,117,'','pramos@imagar.com',NULL,'pending',0),(665,118,'','dnoguera@imagar.com','2014-04-30 10:36:24','send',0),(666,118,'','2dnoguera@imagar.com','2014-04-30 10:38:24','send',0),(667,118,'','david.noguera@grg.com','2014-04-30 10:40:38','send',0),(668,118,'','pramos@imagar.com','2014-04-30 10:42:38','send',0),(669,119,'','dnoguera@imagar.com','2014-04-30 10:45:29','send',0),(670,119,'','2dnoguera@imagar.com','2014-04-30 10:47:29','send',0),(671,119,'','david.noguera@grg.com','2014-04-30 10:49:29','send',0),(672,119,'','pramos@imagar.com','2014-04-30 10:51:30','send',0),(673,120,'','dnoguera@imagar.com',NULL,'black_list',0),(674,120,'','2dnoguera@imagar.com',NULL,'pending',0),(675,120,'','david.noguera@grg.com',NULL,'pending',0),(676,120,'','pramos@imagar.com',NULL,'pending',0),(677,121,'','dnoguera@imagar.com','2014-05-05 17:07:43','send',1),(678,121,'','pramos@imagar.com','2014-05-05 17:09:43','send',0),(679,121,'','odelgado@imagar.com','2014-05-05 17:11:44','send',0),(680,121,'','dmarchante@imagar.com','2014-05-05 17:13:44','send',0),(681,123,'','dnoguera@imagar.com',NULL,'black_list',0),(682,123,'','shermida@imagar.com',NULL,'pending',0),(683,124,'','dnoguera@imagar.com',NULL,'black_list',0),(684,124,'','pramos@imagar.com',NULL,'pending',0),(685,124,'','odelgado@imagar.com',NULL,'pending',0),(686,124,'','dmarchante@imagar.com',NULL,'pending',0),(687,124,'','shermida@imagar.com',NULL,'pending',0),(688,125,'','dmarchante@imagar.com',NULL,'pending',0),(689,125,'','dnoguera@imagar.com',NULL,'black_list',0),(690,125,'','odelgado@imagar.com',NULL,'pending',0),(691,125,'','pramos@imagar.com',NULL,'pending',0),(692,125,'','shermida@imagar.com',NULL,'pending',0),(693,126,'','dnoguera@imagar.com',NULL,'black_list',0),(694,126,'','shermida@imagar.com',NULL,'pending',0),(695,127,'','cgonzalez@imagar.com',NULL,'pending',0),(696,127,'','dmarchante@imagar.com',NULL,'pending',0),(697,127,'','dnoguera@imagar.com',NULL,'black_list',0),(698,127,'','odelgado@imagar.com',NULL,'pending',0),(699,127,'','pramos@imagar.com',NULL,'pending',0),(700,127,'','shermida@imagar.com',NULL,'pending',0),(701,128,'','dmarchante@imagar.com',NULL,'pending',0),(702,128,'','dnoguera@imagar.com',NULL,'black_list',0),(703,128,'','odelgado@imagar.com',NULL,'pending',0),(704,128,'','pramos@imagar.com',NULL,'pending',0),(705,128,'','shermida@imagar.com',NULL,'pending',0),(706,129,'','cgonzalez@imagar.com',NULL,'pending',0),(707,129,'','dmarchante@imagar.com',NULL,'pending',0),(708,129,'','dnoguera@imagar.com',NULL,'black_list',0),(709,129,'','odelgado@imagar.com',NULL,'pending',0),(710,129,'','pramos@imagar.com',NULL,'pending',0),(711,129,'','shermida@imagar.com',NULL,'pending',0),(712,130,'','cgonzalez@imagar.com',NULL,'pending',0),(713,130,'','dmarchante@imagar.com',NULL,'pending',0),(714,130,'','dnoguera@imagar.com',NULL,'black_list',0),(715,130,'','odelgado@imagar.com',NULL,'pending',0),(716,130,'','pramos@imagar.com',NULL,'pending',0),(717,130,'','shermida@imagar.com',NULL,'pending',0),(718,131,'','cgonzalez@imagar.com',NULL,'pending',0),(719,131,'','dmarchante@imagar.com',NULL,'pending',0),(720,131,'','dnoguera@imagar.com',NULL,'black_list',0),(721,131,'','odelgado@imagar.com',NULL,'pending',0),(722,131,'','pramos@imagar.com',NULL,'pending',0),(723,131,'','shermida@imagar.com',NULL,'pending',0),(724,132,'','cgonzalez@imagar.com',NULL,'pending',0),(725,132,'','dmarchante@imagar.com',NULL,'pending',0),(726,132,'','dnoguera@imagar.com',NULL,'black_list',0),(727,132,'','odelgado@imagar.com',NULL,'pending',0),(728,132,'','pramos@imagar.com',NULL,'pending',0),(729,132,'','shermida@imagar.com',NULL,'pending',0),(730,133,'','cgonzalez@imagar.com',NULL,'pending',0),(731,133,'','dmarchante@imagar.com',NULL,'pending',0),(732,133,'','dnoguera@imagar.com',NULL,'black_list',0),(733,133,'','odelgado@imagar.com',NULL,'pending',0),(734,133,'','pramos@imagar.com',NULL,'pending',0),(735,133,'','shermida@imagar.com',NULL,'pending',0),(736,134,'','cgonzalez@imagar.com',NULL,'pending',0),(737,134,'','dmarchante@imagar.com',NULL,'pending',0),(738,134,'','dnoguera@imagar.com',NULL,'black_list',0),(739,134,'','odelgado@imagar.com',NULL,'pending',0),(740,134,'','pramos@imagar.com',NULL,'pending',0),(741,134,'','shermida@imagar.com',NULL,'pending',0),(742,135,'','cgonzalez@imagar.com',NULL,'pending',0),(743,135,'','dmarchante@imagar.com',NULL,'pending',0),(744,135,'','dnoguera@imagar.com',NULL,'black_list',0),(745,135,'','odelgado@imagar.com',NULL,'pending',0),(746,135,'','pramos@imagar.com',NULL,'pending',0),(747,135,'','shermida@imagar.com',NULL,'pending',0),(748,137,'','cgonzalez@imagar.com',NULL,'pending',0),(749,137,'','dmarchante@imagar.com',NULL,'pending',0),(750,137,'','dnoguera@imagar.com',NULL,'black_list',0),(751,137,'','odelgado@imagar.com',NULL,'pending',0),(752,137,'','pramos@imagar.com',NULL,'pending',0),(753,137,'','shermida@imagar.com',NULL,'pending',0),(754,138,'','cgonzalez@imagar.com',NULL,'pending',0),(755,138,'','dmarchante@imagar.com',NULL,'pending',0),(756,138,'','dnoguera@imagar.com',NULL,'black_list',0),(757,138,'','odelgado@imagar.com',NULL,'pending',0),(758,138,'','pramos@imagar.com',NULL,'pending',0),(759,138,'','shermida@imagar.com',NULL,'pending',0),(760,139,'','cgonzalez@imagar.com',NULL,'pending',0),(761,139,'','dmarchante@imagar.com',NULL,'pending',0),(762,139,'','dnoguera@imagar.com',NULL,'black_list',0),(763,139,'','odelgado@imagar.com',NULL,'pending',0),(764,139,'','pramos@imagar.com',NULL,'pending',0),(765,139,'','shermida@imagar.com',NULL,'pending',0),(766,140,'','cgonzalez@imagar.com',NULL,'pending',0),(767,140,'','dmarchante@imagar.com',NULL,'pending',0),(768,140,'','dnoguera@imagar.com',NULL,'black_list',0),(769,140,'','odelgado@imagar.com',NULL,'pending',0),(770,140,'','pramos@imagar.com',NULL,'pending',0),(771,140,'','shermida@imagar.com',NULL,'pending',0),(772,141,'','cgonzalez@imagar.com',NULL,'pending',0),(773,141,'','dmarchante@imagar.com',NULL,'pending',0),(774,141,'','dnoguera@imagar.com',NULL,'black_list',0),(775,141,'','odelgado@imagar.com',NULL,'pending',0),(776,141,'','pramos@imagar.com',NULL,'pending',0),(777,141,'','shermida@imagar.com',NULL,'pending',0),(778,142,'','cgonzalez@imagar.com',NULL,'pending',0),(779,142,'','dmarchante@imagar.com',NULL,'pending',0),(780,142,'','dnoguera@imagar.com',NULL,'black_list',0),(781,142,'','odelgado@imagar.com',NULL,'pending',0),(782,142,'','pramos@imagar.com',NULL,'pending',0),(783,142,'','shermida@imagar.com',NULL,'pending',0),(784,143,'','cgonzalez@imagar.com',NULL,'pending',0),(785,143,'','dmarchante@imagar.com',NULL,'pending',0),(786,143,'','dnoguera@imagar.com',NULL,'black_list',0),(787,143,'','odelgado@imagar.com',NULL,'pending',0),(788,143,'','pramos@imagar.com',NULL,'pending',0),(789,143,'','shermida@imagar.com',NULL,'pending',0),(790,144,'','cgonzalez@imagar.com',NULL,'pending',0),(791,144,'','dmarchante@imagar.com',NULL,'pending',0),(792,144,'','dnoguera@imagar.com',NULL,'black_list',0),(793,144,'','odelgado@imagar.com',NULL,'pending',0),(794,144,'','pramos@imagar.com',NULL,'pending',0),(795,144,'','shermida@imagar.com',NULL,'pending',0),(796,145,'','cgonzalez@imagar.com',NULL,'pending',0),(797,145,'','dmarchante@imagar.com',NULL,'pending',0),(798,145,'','dnoguera@imagar.com',NULL,'black_list',0),(799,145,'','odelgado@imagar.com',NULL,'pending',0),(800,145,'','pramos@imagar.com',NULL,'pending',0),(801,145,'','shermida@imagar.com',NULL,'pending',0),(802,146,'','cgonzalez@imagar.com',NULL,'pending',0),(803,146,'','dmarchante@imagar.com',NULL,'pending',0),(804,146,'','dnoguera@imagar.com',NULL,'black_list',0),(805,146,'','odelgado@imagar.com',NULL,'pending',0),(806,146,'','pramos@imagar.com',NULL,'pending',0),(807,146,'','shermida@imagar.com',NULL,'pending',0),(808,147,'','cgonzalez@imagar.com',NULL,'pending',0),(809,147,'','dmarchante@imagar.com',NULL,'pending',0),(810,147,'','dnoguera@imagar.com',NULL,'black_list',0),(811,147,'','odelgado@imagar.com',NULL,'pending',0),(812,147,'','pramos@imagar.com',NULL,'pending',0),(813,147,'','shermida@imagar.com',NULL,'pending',0),(814,149,'','cgonzalez@imagar.com',NULL,'pending',0),(815,149,'','dmarchante@imagar.com',NULL,'pending',0),(816,149,'','dnoguera@imagar.com',NULL,'black_list',0),(817,149,'','odelgado@imagar.com',NULL,'pending',0),(818,149,'','pramos@imagar.com',NULL,'pending',0),(819,149,'','shermida@imagar.com',NULL,'pending',0),(820,150,'','cgonzalez@imagar.com',NULL,'pending',0),(821,150,'','dmarchante@imagar.com',NULL,'pending',0),(822,150,'','dnoguera@imagar.com',NULL,'black_list',0),(823,150,'','odelgado@imagar.com',NULL,'pending',0),(824,150,'','pramos@imagar.com',NULL,'pending',0),(825,150,'','shermida@imagar.com',NULL,'pending',0),(826,151,'','cgonzalez@imagar.com',NULL,'pending',0),(827,151,'','dmarchante@imagar.com',NULL,'pending',0),(828,151,'','dnoguera@imagar.com',NULL,'black_list',0),(829,151,'','odelgado@imagar.com',NULL,'pending',0),(830,151,'','pramos@imagar.com',NULL,'pending',0),(831,151,'','shermida@imagar.com',NULL,'pending',0),(832,152,'','cgonzalez@imagar.com','2014-09-11 13:49:23','send',0),(833,152,'','dmarchante@imagar.com','2014-09-11 13:51:24','send',1),(834,152,'','dnoguera@imagar.com','2014-09-11 13:53:24','send',1),(835,152,'','odelgado@imagar.com','2014-09-11 13:55:25','send',1),(836,152,'','pramos@imagar.com','2014-09-11 13:57:26','send',1),(837,152,'','shermida@imagar.com','2014-09-11 13:59:27','send',1),(838,153,'','cgonzalez@imagar.com','2014-09-11 15:38:06','send',0),(839,153,'','dmarchante@imagar.com','2014-09-11 15:40:06','send',1),(840,153,'','dnoguera@imagar.com','2014-09-11 15:42:06','send',1),(841,153,'','odelgado@imagar.com','2014-09-11 15:44:07','send',1),(842,153,'','pramos@imagar.com','2014-09-11 15:46:07','send',0),(843,153,'','shermida@imagar.com','2014-09-11 15:48:08','send',1),(844,154,'','dnoguera@imagar.com',NULL,'black_list',0),(845,154,'','nogueradavid@hotmail.com',NULL,'pending',0),(846,155,'','dnoguera@imagar.com','2014-09-11 16:06:08','send',1),(847,155,'','nogueradavid@hotmail.com','2014-09-11 16:08:08','send',0),(848,156,'','dnoguera@imagar.com','2014-09-11 16:21:39','send',1),(849,156,'','nogueradavid@hotmail.com','2014-09-11 16:23:39','send',0),(850,157,'','dnoguera@imagar.com','2014-09-11 17:41:06','send',1),(851,157,'','nogueradavid@hotmail.com','2014-09-11 17:43:06','send',0),(852,158,'','cgonzalez@imagar.com','2014-09-11 17:47:42','send',0),(853,158,'','dmarchante@imagar.com','2014-09-11 17:49:42','send',1),(854,158,'','dnoguera@imagar.com','2014-09-11 17:51:43','send',1),(855,158,'','odelgado@imagar.com','2014-09-11 17:53:43','send',1),(856,158,'','pramos@imagar.com','2014-09-11 17:55:43','send',1),(857,158,'','shermida@imagar.com','2014-09-11 17:57:44','send',1),(858,159,'','dnoguera@imagar.com','2014-09-12 09:51:59','send',1),(859,159,'','nogueradavid@hotmail.com','2014-09-12 09:54:00','send',0),(860,160,'','dnoguera@imagar.com','2014-09-12 10:14:57','send',1),(861,160,'','nogueradavid@hotmail.com','2014-09-12 10:16:57','send',0),(862,161,'','dnoguera@imagar.com','2014-09-12 10:32:49','send',1),(863,161,'','nogueradavid@hotmail.com','2014-09-12 10:34:49','send',0),(864,162,'','nogueradavid@hotmail.com','2014-09-12 10:37:20','send',0),(865,163,'','dnoguera@imagar.com','2014-09-12 12:30:14','send',0),(866,163,'','nogueradavid@hotmail.com','2014-09-12 12:32:15','send',0);

/*Table structure for table `mailing_templates` */

DROP TABLE IF EXISTS `mailing_templates`;

CREATE TABLE `mailing_templates` (
  `id_template` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `template_name` varchar(250) NOT NULL DEFAULT '',
  `template_body` text,
  `template_mini` varchar(250) NOT NULL DEFAULT '',
  `activo` int(1) NOT NULL DEFAULT '1',
  `id_type` int(11) NOT NULL DEFAULT '0',
  `id_campaign` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_template`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `mailing_templates` */

insert  into `mailing_templates`(`id_template`,`template_name`,`template_body`,`template_mini`,`activo`,`id_type`,`id_campaign`) values (1,'Plantilla Convocatoria Descuentos','<meta content=\"text/html; charset=UTF-8\" http-equiv=\"Content-Type\" />\r\n<title></title>\r\n<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						Convocatoria</h2>\r\n					[CONTENT]</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					[FOOTER]</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','1398327405_bg01.jpg',1,1,2),(2,'Plantilla Descuento + Reclamo','<meta content=\"text/html; charset=UTF-8\" http-equiv=\"Content-Type\" />\r\n<title></title>\r\n<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://192.168.0.8/community-php/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					<br />\r\n					[USER_LOGO]</td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						Convocatoria</h2>\r\n					[USER_EMPRESA]<br />\r\n					<br />\r\n					[DATE_PROMOCION]<br />\r\n					<br />\r\n					Consigue un descuento de <strong>[DESCUENTO_PROMOCION]</strong><br />\r\n					<br />\r\n					[CLAIM_PROMOCION]</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					[USER_DIRECCION]</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','1398328115_bg01.jpg',1,3,2),(3,'Plantilla simple','<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"10px\" style=\"background-color:#f0f0f0;\" width=\"600\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://192.168.0.8/community-php/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					&nbsp;</td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						P. Simple</h2>\r\n					Esto es un mensaje de plantilla simple<br />\r\n					<br />\r\n					<a href=\"http://google.es\">Ir a google</a><br />\r\n					<a href=\"http://imagar.com\">http://imagar.com</a><br />\r\n					<br />\r\n					Ahora tienes un descuento de <span style=\"font-size: 26px;\"><strong>[DESCUENTO_PROMOCION]%</strong></span>, aprovechalo<br />\r\n					<br />\r\n					&nbsp;</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					<span style=\"color: rgb(0, 153, 204);\">[CLAIM_PROMOCION]</span></td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','1398328167_bg_globos.jpg',1,2,1),(8,'gg','ggg','',2,2,2),(9,'dfgdfgd f','d fdfgdfgdfgdfgdf','',0,1,1),(10,'fffffffffffffffffff','5555555555<br />\r\n[CONTENT]','',2,1,2),(11,'La cuarta plantilla de comunicación','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del Cuarto mensaje.</h2>\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','1398328335_1347877359_mexico3.jpg',1,2,1),(12,'Plantilla de reclamo ','<meta content=\"text/html; charset=UTF-8\" http-equiv=\"Content-Type\" />\r\n<title></title>\r\n<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					<br />\r\n					[USER_LOGO]</td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						Reclamo</h2>\r\n					[USER_EMPRESA] te felicita!!<br />\r\n					[CLAIM_PROMOCION]<br />\r\n					<br />\r\n					<br />\r\n					Consigue un descuento de [DESCUENTO_PROMOCION] %<br />\r\n					<br />\r\n					fecha l&iacute;mite de la promoci&oacute;n [DATE_PROMOCION]<br />\r\n					<br />\r\n					[USER_DIRECCION]</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','1399549926_bg.jpg',1,2,3);

/*Table structure for table `mailing_templates_types` */

DROP TABLE IF EXISTS `mailing_templates_types`;

CREATE TABLE `mailing_templates_types` (
  `id_type` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name_type` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_type`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `mailing_templates_types` */

insert  into `mailing_templates_types`(`id_type`,`name_type`) values (1,'Descuentos'),(2,'Reclamo'),(3,'Descuentos+Reclamo');

/*Table structure for table `mensajes` */

DROP TABLE IF EXISTS `mensajes`;

CREATE TABLE `mensajes` (
  `id_mensaje` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_remitente` varchar(100) NOT NULL DEFAULT '',
  `user_destinatario` varchar(100) NOT NULL DEFAULT '',
  `date_mensaje` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `asunto_mensaje` varchar(250) NOT NULL DEFAULT '',
  `mensaje_cuerpo` longtext NOT NULL COMMENT '0: no leido, 1: leido; 2:eliminado',
  `estado` tinyint(1) NOT NULL DEFAULT '0',
  `estado_remitente` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1: eliminado; 0: en bandeja de elementos enviados',
  PRIMARY KEY (`id_mensaje`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mensajes` */

/*Table structure for table `muro_comentarios` */

DROP TABLE IF EXISTS `muro_comentarios`;

CREATE TABLE `muro_comentarios` (
  `id_comentario` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_muro` varchar(100) NOT NULL DEFAULT 'principal',
  `seccion_comentario` varchar(250) NOT NULL DEFAULT '',
  `id_comentario_id` int(11) NOT NULL DEFAULT '0',
  `canal` varchar(100) NOT NULL DEFAULT '',
  `comentario` longtext,
  `user_comentario` varchar(100) NOT NULL DEFAULT '',
  `date_comentario` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `votaciones` int(11) NOT NULL DEFAULT '0',
  `estado` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=pendiente; 1=validado;2=rechazado',
  `seleccion_reto` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_comentario`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `muro_comentarios` */

insert  into `muro_comentarios`(`id_comentario`,`tipo_muro`,`seccion_comentario`,`id_comentario_id`,`canal`,`comentario`,`user_comentario`,`date_comentario`,`votaciones`,`estado`,`seleccion_reto`) values (1,'principal','',0,'comercial','un comentariio','admin','2014-07-29 14:46:12',0,1,0),(2,'principal','',0,'comercial','segundo comentario','admin','2014-07-29 14:46:57',0,1,0),(3,'principal','',0,'comercial','ffds gsdfgsdfg','admin','2014-07-30 10:44:49',0,1,0),(4,'principal','',0,'comercial','sd fgsdfgsdfgsdfg','admin','2014-07-30 10:44:52',0,1,0),(5,'principal','',0,'comercial','sd fgsdfgsdfgsdfgsdfg','admin','2014-07-30 10:44:55',0,1,0),(6,'principal','',0,'comercial','111111111111111','admin','2014-07-30 10:44:59',0,1,0),(7,'principal','',6,'comercial','te respondo','admin','2014-09-10 10:10:08',0,1,0),(8,'principal','',6,'comercial','otra respuesra','admin','2014-09-10 12:39:37',0,1,0),(9,'principal','',3,'comercial','dfs sdfsdf','admin','2014-09-10 12:42:26',0,1,0),(10,'principal','',0,'gerente','un comentario en gerentes','admin','2014-09-18 10:31:00',0,1,0),(11,'principal','',0,'comercial','Hola a todos!!  La nueva comunidad','david','2014-09-18 16:21:26',0,1,0);

/*Table structure for table `muro_comentarios_votaciones` */

DROP TABLE IF EXISTS `muro_comentarios_votaciones`;

CREATE TABLE `muro_comentarios_votaciones` (
  `id_votacion` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_comentario` int(11) NOT NULL DEFAULT '0',
  `user_votacion` varchar(100) NOT NULL DEFAULT '',
  `date_votacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_votacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `muro_comentarios_votaciones` */

/*Table structure for table `mystery_datos_sassie` */

DROP TABLE IF EXISTS `mystery_datos_sassie`;

CREATE TABLE `mystery_datos_sassie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod_tienda` varchar(255) DEFAULT NULL,
  `periodo` varchar(255) DEFAULT NULL,
  `enlace` varchar(255) DEFAULT NULL,
  `fecha_activacion` date DEFAULT NULL,
  `tipo_informe` varchar(255) DEFAULT 'tienda',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `mystery_datos_sassie` */

/*Table structure for table `na_areas` */

DROP TABLE IF EXISTS `na_areas`;

CREATE TABLE `na_areas` (
  `id_area` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `area_nombre` varchar(250) NOT NULL DEFAULT '',
  `area_descripcion` longtext NOT NULL,
  `area_canal` varchar(100) NOT NULL DEFAULT '',
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `puntos` int(5) NOT NULL DEFAULT '0',
  `limite_users` int(11) NOT NULL DEFAULT '0',
  `area_fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_area`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `na_areas` */

insert  into `na_areas`(`id_area`,`area_nombre`,`area_descripcion`,`area_canal`,`estado`,`puntos`,`limite_users`,`area_fecha`) values (9,'Área de prueba inicial','El primer curso de formación para el canal comerciales','comercial',1,10,50,'2014-08-01 09:06:32');

/*Table structure for table `na_areas_grupos` */

DROP TABLE IF EXISTS `na_areas_grupos`;

CREATE TABLE `na_areas_grupos` (
  `id_grupo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_area` int(11) unsigned NOT NULL DEFAULT '0',
  `grupo_nombre` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_grupo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `na_areas_grupos` */

/*Table structure for table `na_areas_grupos_users` */

DROP TABLE IF EXISTS `na_areas_grupos_users`;

CREATE TABLE `na_areas_grupos_users` (
  `id_grupo` int(11) unsigned NOT NULL DEFAULT '0',
  `grupo_username` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_grupo`,`grupo_username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `na_areas_grupos_users` */

/*Table structure for table `na_areas_users` */

DROP TABLE IF EXISTS `na_areas_users`;

CREATE TABLE `na_areas_users` (
  `id_area` int(11) NOT NULL DEFAULT '0',
  `username_area` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_area`,`username_area`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `na_areas_users` */

insert  into `na_areas_users`(`id_area`,`username_area`) values (9,'admin');

/*Table structure for table `na_tareas` */

DROP TABLE IF EXISTS `na_tareas`;

CREATE TABLE `na_tareas` (
  `id_tarea` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_area` int(11) NOT NULL DEFAULT '0',
  `tarea_titulo` longtext NOT NULL,
  `tarea_descripcion` longtext NOT NULL,
  `tipo` varchar(100) NOT NULL DEFAULT 'fichero' COMMENT 'fichero;formulario',
  `tarea_grupo` tinyint(1) NOT NULL DEFAULT '0',
  `user_add` varchar(100) NOT NULL DEFAULT '',
  `activa` tinyint(1) NOT NULL DEFAULT '1',
  `tarea_archivo` varchar(250) NOT NULL DEFAULT '',
  `activa_links` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_tarea`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `na_tareas` */

insert  into `na_tareas`(`id_tarea`,`id_area`,`tarea_titulo`,`tarea_descripcion`,`tipo`,`tarea_grupo`,`user_add`,`activa`,`tarea_archivo`,`activa_links`) values (8,9,'Tarea de formulario para el primer curso de formación','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu gravida ante, vel elementum neque. Suspendisse in aliquam diam.','formulario',0,'admin',1,'',1);

/*Table structure for table `na_tareas_documentos` */

DROP TABLE IF EXISTS `na_tareas_documentos`;

CREATE TABLE `na_tareas_documentos` (
  `id_documento` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_tarea` int(11) unsigned NOT NULL DEFAULT '0',
  `documento_tipo` varchar(100) NOT NULL DEFAULT 'fichero' COMMENT 'fichero;video;podcast;enlace',
  `documento_nombre` varchar(250) NOT NULL DEFAULT '',
  `documento_file` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_documento`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

/*Data for the table `na_tareas_documentos` */

/*Table structure for table `na_tareas_formularios_finalizados` */

DROP TABLE IF EXISTS `na_tareas_formularios_finalizados`;

CREATE TABLE `na_tareas_formularios_finalizados` (
  `id_tarea` int(11) NOT NULL,
  `user_tarea` varchar(100) NOT NULL,
  `date_finalizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `revision` tinyint(1) NOT NULL DEFAULT '0',
  `puntos` int(3) NOT NULL DEFAULT '0',
  `user_revision` varchar(100) NOT NULL DEFAULT '',
  `date_revision` datetime DEFAULT NULL,
  PRIMARY KEY (`id_tarea`,`user_tarea`),
  KEY `user_tarea` (`user_tarea`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `na_tareas_formularios_finalizados` */

insert  into `na_tareas_formularios_finalizados`(`id_tarea`,`user_tarea`,`date_finalizacion`,`revision`,`puntos`,`user_revision`,`date_revision`) values (8,'admin','2014-09-10 17:07:20',1,5,'admin','2014-09-10 17:07:36');

/*Table structure for table `na_tareas_formularios_finalizados_history` */

DROP TABLE IF EXISTS `na_tareas_formularios_finalizados_history`;

CREATE TABLE `na_tareas_formularios_finalizados_history` (
  `id_history` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_tarea` int(11) NOT NULL,
  `user_tarea` varchar(100) NOT NULL,
  `date_finalizacion` datetime NOT NULL,
  `revision` tinyint(1) NOT NULL DEFAULT '0',
  `puntos` int(3) NOT NULL DEFAULT '0',
  `user_revision` varchar(100) NOT NULL DEFAULT '',
  `date_revision` datetime DEFAULT NULL,
  `date_history` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_history` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_history`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

/*Data for the table `na_tareas_formularios_finalizados_history` */

/*Table structure for table `na_tareas_grupos` */

DROP TABLE IF EXISTS `na_tareas_grupos`;

CREATE TABLE `na_tareas_grupos` (
  `id_tarea` int(11) unsigned NOT NULL DEFAULT '0',
  `id_grupo` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_tarea`,`id_grupo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `na_tareas_grupos` */

/*Table structure for table `na_tareas_grupos_history` */

DROP TABLE IF EXISTS `na_tareas_grupos_history`;

CREATE TABLE `na_tareas_grupos_history` (
  `id_history` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_tarea` int(11) unsigned NOT NULL DEFAULT '0',
  `id_grupo` int(11) unsigned NOT NULL DEFAULT '0',
  `date_history` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_history` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_history`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `na_tareas_grupos_history` */

/*Table structure for table `na_tareas_preguntas` */

DROP TABLE IF EXISTS `na_tareas_preguntas`;

CREATE TABLE `na_tareas_preguntas` (
  `id_pregunta` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_tarea` int(11) unsigned NOT NULL DEFAULT '0',
  `pregunta_texto` longtext NOT NULL,
  `pregunta_tipo` varchar(100) NOT NULL DEFAULT 'texto' COMMENT 'texto;unica;multiple',
  PRIMARY KEY (`id_pregunta`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `na_tareas_preguntas` */

insert  into `na_tareas_preguntas`(`id_pregunta`,`id_tarea`,`pregunta_texto`,`pregunta_tipo`) values (13,8,'¿De que color es el caballo blanco de Santiago?','texto'),(14,8,'¿Cuantas patas tiene un pero?','unica');

/*Table structure for table `na_tareas_respuestas` */

DROP TABLE IF EXISTS `na_tareas_respuestas`;

CREATE TABLE `na_tareas_respuestas` (
  `id_respuesta` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_pregunta` int(11) unsigned NOT NULL DEFAULT '0',
  `respuesta_texto` longtext NOT NULL,
  PRIMARY KEY (`id_respuesta`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `na_tareas_respuestas` */

insert  into `na_tareas_respuestas`(`id_respuesta`,`id_pregunta`,`respuesta_texto`) values (14,14,'Una'),(15,14,'Dos'),(16,14,'Tres');

/*Table structure for table `na_tareas_respuestas_user` */

DROP TABLE IF EXISTS `na_tareas_respuestas_user`;

CREATE TABLE `na_tareas_respuestas_user` (
  `id_respuesta_user` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_pregunta` int(11) unsigned NOT NULL DEFAULT '0',
  `respuesta_user` varchar(100) NOT NULL DEFAULT '',
  `respuesta_valor` longtext NOT NULL,
  PRIMARY KEY (`id_respuesta_user`),
  KEY `id_pregunta` (`id_pregunta`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `na_tareas_respuestas_user` */

insert  into `na_tareas_respuestas_user`(`id_respuesta_user`,`id_pregunta`,`respuesta_user`,`respuesta_valor`) values (15,13,'admin','blanco'),(16,14,'admin','Dos');

/*Table structure for table `na_tareas_users` */

DROP TABLE IF EXISTS `na_tareas_users`;

CREATE TABLE `na_tareas_users` (
  `id_tarea_user` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_area` int(11) NOT NULL,
  `id_tarea` int(11) NOT NULL,
  `user_tarea` varchar(100) NOT NULL DEFAULT '',
  `file_tarea` varchar(255) NOT NULL DEFAULT '',
  `fecha_tarea` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `revision` tinyint(1) NOT NULL DEFAULT '0',
  `user_revision` varchar(100) NOT NULL DEFAULT '',
  `date_revision` datetime DEFAULT NULL,
  PRIMARY KEY (`id_tarea_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `na_tareas_users` */

/*Table structure for table `novedades` */

DROP TABLE IF EXISTS `novedades`;

CREATE TABLE `novedades` (
  `cuerpo` longtext NOT NULL,
  `activo` int(1) unsigned NOT NULL DEFAULT '1',
  `canal` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`canal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `novedades` */

insert  into `novedades`(`cuerpo`,`activo`,`canal`) values ('En un lugar de la Mancha, de cuyo nombre no quiero acordarme, no ha mucho tiempo que viv&iacute;a un hidalgo de los de lanza en astillero, adarga antigua, roc&iacute;n flaco y galgo corredor.',1,'comercial'),('Proin sed blandit ante. <strong>Vivamus</strong> et eros non urna sagittis tincidunt at a augue. <a href=\"http://www.google.com\">Aenean</a> eu pharetra ligula, congue hendrerit felis.<br />',1,'gerente');

/*Table structure for table `pages` */

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `page_name` varchar(100) NOT NULL,
  `page_content` longtext,
  PRIMARY KEY (`page_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `pages` */

insert  into `pages`(`page_name`,`page_content`) values ('declaracion','<h2>Declaraci&oacute;n de derechos y responsabilidades</h2>\r\n	Esta Declaraci&oacute;n de derechos y responsabilidades rige nuestra relaci&oacute;n con los usuarios y con todos aquellos que interact&uacute;an en www.actytukiabi.com. Al utilizar o acceder a www.actytukiabi.com muestras tu conformidad con la presente Declaraci&oacute;n.<br />\r\n	<br />\r\n	1. Privacidad<br />\r\n	Tu privacidad es muy importante para nosotros. Hemos dise&ntilde;ado nuestra Pol&iacute;tica de Privacidad para ayudarte a comprender c&oacute;mo puedes usar comunidadsiempremas.com para compartir informaci&oacute;n con otras personas y c&oacute;mo recopilamos y usamos tu informaci&oacute;n. Te animamos a que leas nuestra Pol&iacute;tica de privacidad y a que la utilices para poder tomar decisiones fundamentadas.<br />\r\n	<br />\r\n	2. Compartir el contenido y la informaci&oacute;n<br />\r\n	Eres el propietario de todo el contenido y la informaci&oacute;n que publicas en www.actitukiabi.com. Adem&aacute;s:<br />\r\n	<br />\r\n	1. Para el contenido protegido por derechos de propiedad intelectual, como fotograf&iacute;as y v&iacute;deos (en adelante, &quot;contenido de PI&quot;), nos concedes espec&iacute;ficamente el siguiente permiso: nos concedes una licencia no exclusiva, transferible, con posibilidad de ser sub-otorgada, sin royalties, aplicable globalmente, para utilizar cualquier contenido de PI que publiques en www.actitukiabi.com<br />\r\n	<br />\r\n	2. Cuando eliminas contenido de PI, &eacute;ste es borrado de forma similar a cuando vac&iacute;as la papelera o papelera de reciclaje de tu equipo inform&aacute;tico. No obstante, entiendes que es posible que el contenido eliminado permanezca en copias de seguridad durante un plazo de tiempo razonable (si bien no estar&aacute; disponible para terceros).<br />\r\n	<br />\r\n	3. Siempre valoramos tus comentarios o sugerencias acerca de www.actitukiabi.com, pero debes entender que podr&iacute;amos utilizarlos sin obligaci&oacute;n de compensarte por ello (del mismo modo que t&uacute; no tienes obligaci&oacute;n de ofrecerlos).<br />\r\n	<br />\r\n	3. Seguridad<br />\r\n	Hacemos todo lo posible para hacer que www.actitukiabi.comsea un sitio seguro, pero no podemos garantizarlo. Necesitamos tu ayuda para lograrlo, lo que implica los siguientes compromisos:<br />\r\n	<br />\r\n	1. No enviar&aacute;s ni publicar&aacute;s de ning&uacute;n otro modo comunicaciones comerciales no autorizadas (como correo no deseado) en www.actitukiabi.com<br />\r\n	<br />\r\n	2. No participar&aacute;s en marketing multinivel ilegal, como el de tipo piramidal, en www.actitukiabi.com.<br />\r\n	<br />\r\n	3. No cargar&aacute;s virus ni c&oacute;digo malintencionado de ning&uacute;n tipo.<br />\r\n	<br />\r\n	4. No solicitar&aacute;s informaci&oacute;n de inicio de sesi&oacute;n ni acceder&aacute;s a una cuenta perteneciente a otro usuario.<br />\r\n	<br />\r\n	5. No molestar&aacute;s, intimidar&aacute;s ni acosar&aacute;s a ning&uacute;n usuario.<br />\r\n	<br />\r\n	6. No publicar&aacute;s contenido que resulte hiriente, intimidatorio o pornogr&aacute;fico, que incite a la violencia o que contenga desnudos o violencia gr&aacute;fica o injustificada.<br />\r\n	<br />\r\n	7. No ofrecer&aacute;s ning&uacute;n concurso, regalo ni apuesta (colectivamente, &quot;promoci&oacute;n&quot;) sin nuestro consentimiento previo por escrito. Si damos nuestro consentimiento, tendr&aacute;s completa responsabilidad de la promoci&oacute;n y seguir&aacute;s nuestras normas de las promociones y cumplir&aacute;s todas las leyes aplicables.<br />\r\n	<br />\r\n	8. No utilizar&aacute;s www.actitukiabi.compara actos il&iacute;citos, enga&ntilde;osos, malintencionados o discriminatorios.<br />\r\n	<br />\r\n	9. No realizar&aacute;s ninguna acci&oacute;n que pudiera inhabilitar, sobrecargar o afectar al funcionamiento correcto de www.actytukiabi.com, como, por ejemplo, un ataque de denegaci&oacute;n de servicio.<br />\r\n	<br />\r\n	10. No facilitar&aacute;s ni fomentar&aacute;s la violaci&oacute;n de esta Declaraci&oacute;n.<br />\r\n	<br />\r\n	11. No compartir&aacute;s la contrase&ntilde;a, no dejar&aacute;s que otra persona acceda a tu cuenta, ni har&aacute;s cualquier cosa que pueda poner en peligro la seguridad de tu cuenta.<br />\r\n	<br />\r\n	12. No transferir&aacute;s la cuenta (incluida cualquier p&aacute;gina o aplicaci&oacute;n que administres) a nadie sin nuestro consentimiento previo por escrito.<br />\r\n	<br />\r\n	13. Si seleccionas un nombre de usuario para tu cuenta, nos reservamos el derecho a eliminarlo o reclamarlo si lo consideramos oportuno.<br />\r\n	<br />\r\n	4. Protecci&oacute;n de los derechos de otras personas<br />\r\n	Respetamos los derechos de otras personas y esperamos que t&uacute; hagas lo mismo.<br />\r\n	<br />\r\n	1. No publicar&aacute;s contenido ni realizar&aacute;s ninguna acci&oacute;n en www.actytukiabi.com que infrinja o viole los derechos de otros o que viole la ley de alg&uacute;n modo.<br />\r\n	<br />\r\n	2. Podemos retirar cualquier contenido o informaci&oacute;n que publiques en www.actytukiabi.com si consideramos que viola esta Declaraci&oacute;n.<br />\r\n	<br />\r\n	3. Si infringes repetidamente los derechos de propiedad intelectual de otra persona, desactivaremos tu cuenta si es oportuno.<br />\r\n	<br />\r\n	4. No utilizar&aacute;s nuestros copyrights o marcas registradas (incluidos Kiabi, los logotipos de Kiabi) ni ninguna marca que se parezca a las nuestras sin nuestro permiso por escrito.<br />\r\n	<br />\r\n	5. No publicar&aacute;s los documentos de identificaci&oacute;n ni informaci&oacute;n financiera de nadie en www.actytukiabi.com<br />\r\n	<br />\r\n	Si seleccionas un nombre de usuario para tu cuenta, nos reservamos el derecho a eliminarlo o reclamarlo si lo consideramos oportuno (por ejemplo, si el propietario de una marca comercial se queja por un nombre de usuario que no est&aacute; relacionado estrechamente con el nombre real del usuario).<br />\r\n	<br />\r\n	5. Definiciones<br />\r\n	1. El t&eacute;rmino &quot;actytu&quot; se refiere a las funciones y servicios que proporcionamos, incluidos los que se ofrecen a trav&eacute;s de (a) nuestro sitio web en www.actytukiabi.com y versiones m&oacute;viles; (b) nuestra Plataforma; (c) plugins sociales, como el bot&oacute;n &quot;Me gusta&quot;,.<br />\r\n	<br />\r\n	2. El t&eacute;rmino &quot;Plataforma&quot; se refiere al conjunto de API y servicios que permiten que otras personas, incluidos los desarrolladores de aplicaciones y los operadores de sitios web, recuperen datos de actytu o nos los proporcionen a nosotros.<br />\r\n	<br />\r\n	3. El t&eacute;rmino &quot;informaci&oacute;n&quot; se refiere a los hechos y otra informaci&oacute;n sobre ti, incluidas las acciones que realizas.<br />\r\n	<br />\r\n	4. El t&eacute;rmino &quot;contenido&quot; se refiere a todo lo que publicas en www.actytukiabi.com que no se incluye en la definici&oacute;n de &quot;informaci&oacute;n&quot;.<br />\r\n	<br />\r\n	5. El t&eacute;rmino &quot;datos&quot; se refiere al contenido y la informaci&oacute;n que pueden recuperar terceros de www.actytukiabi.com o proporcionan a actytu a trav&eacute;s de la plataforma.<br />\r\n	<br />\r\n	6. El t&eacute;rmino &quot;publicar&quot; significa publicar en www.actytukiabi.com.<br />\r\n	<br />\r\n	7. Por &quot;usar&quot; se entiende utilizar, copiar, reproducir o mostrar p&uacute;blicamente, distribuir, modificar, traducir y crear obras derivadas.\r\n'),('manifest','<h2>\r\n	T&eacute;rminos y condiciones</h2>\r\nEsta Declaraci&oacute;n de derechos y responsabilidades rige nuestra relaci&oacute;n con los usuarios y con todos aquellos que interact&uacute;an en www.actytukiabi.com. Al utilizar o acceder a www.actytukiabi.com muestras tu conformidad con la presente Declaraci&oacute;n.<br />\r\n<br />\r\n1. Privacidad<br />\r\nTu privacidad es muy importante para nosotros. Hemos dise&ntilde;ado nuestra Pol&iacute;tica de Privacidad para ayudarte a comprender c&oacute;mo puedes usar comunidadsiempremas.com para compartir informaci&oacute;n con otras personas y c&oacute;mo recopilamos y usamos tu informaci&oacute;n. Te animamos a que leas nuestra Pol&iacute;tica de privacidad y a que la utilices para poder tomar decisiones fundamentadas.<br />\r\n<br />\r\n2. Compartir el contenido y la informaci&oacute;n<br />\r\nEres el propietario de todo el contenido y la informaci&oacute;n que publicas en www.actitukiabi.com. Adem&aacute;s:<br />\r\n<br />\r\n1. Para el contenido protegido por derechos de propiedad intelectual, como fotograf&iacute;as y v&iacute;deos (en adelante, &quot;contenido de PI&quot;), nos concedes espec&iacute;ficamente el siguiente permiso: nos concedes una licencia no exclusiva, transferible, con posibilidad de ser sub-otorgada, sin royalties, aplicable globalmente, para utilizar cualquier contenido de PI que publiques en www.actitukiabi.com<br />\r\n<br />\r\n2. Cuando eliminas contenido de PI, &eacute;ste es borrado de forma similar a cuando vac&iacute;as la papelera o papelera de reciclaje de tu equipo inform&aacute;tico. No obstante, entiendes que es posible que el contenido eliminado permanezca en copias de seguridad durante un plazo de tiempo razonable (si bien no estar&aacute; disponible para terceros).<br />\r\n<br />\r\n3. Siempre valoramos tus comentarios o sugerencias acerca de www.actitukiabi.com, pero debes entender que podr&iacute;amos utilizarlos sin obligaci&oacute;n de compensarte por ello (del mismo modo que t&uacute; no tienes obligaci&oacute;n de ofrecerlos).<br />\r\n<br />\r\n3. Seguridad<br />\r\nHacemos todo lo posible para hacer que www.actitukiabi.comsea un sitio seguro, pero no podemos garantizarlo. Necesitamos tu ayuda para lograrlo, lo que implica los siguientes compromisos:<br />\r\n<br />\r\n1. No enviar&aacute;s ni publicar&aacute;s de ning&uacute;n otro modo comunicaciones comerciales no autorizadas (como correo no deseado) en www.actitukiabi.com<br />\r\n<br />\r\n2. No participar&aacute;s en marketing multinivel ilegal, como el de tipo piramidal, en www.actitukiabi.com.<br />\r\n<br />\r\n3. No cargar&aacute;s virus ni c&oacute;digo malintencionado de ning&uacute;n tipo.<br />\r\n<br />\r\n4. No solicitar&aacute;s informaci&oacute;n de inicio de sesi&oacute;n ni acceder&aacute;s a una cuenta perteneciente a otro usuario.<br />\r\n<br />\r\n5. No molestar&aacute;s, intimidar&aacute;s ni acosar&aacute;s a ning&uacute;n usuario.<br />\r\n<br />\r\n6. No publicar&aacute;s contenido que resulte hiriente, intimidatorio o pornogr&aacute;fico, que incite a la violencia o que contenga desnudos o violencia gr&aacute;fica o injustificada.<br />\r\n<br />\r\n7. No ofrecer&aacute;s ning&uacute;n concurso, regalo ni apuesta (colectivamente, &quot;promoci&oacute;n&quot;) sin nuestro consentimiento previo por escrito. Si damos nuestro consentimiento, tendr&aacute;s completa responsabilidad de la promoci&oacute;n y seguir&aacute;s nuestras normas de las promociones y cumplir&aacute;s todas las leyes aplicables.<br />\r\n<br />\r\n8. No utilizar&aacute;s www.actitukiabi.compara actos il&iacute;citos, enga&ntilde;osos, malintencionados o discriminatorios.<br />\r\n<br />\r\n9. No realizar&aacute;s ninguna acci&oacute;n que pudiera inhabilitar, sobrecargar o afectar al funcionamiento correcto de www.actytukiabi.com, como, por ejemplo, un ataque de denegaci&oacute;n de servicio.<br />\r\n<br />\r\n10. No facilitar&aacute;s ni fomentar&aacute;s la violaci&oacute;n de esta Declaraci&oacute;n.<br />\r\n<br />\r\n11. No compartir&aacute;s la contrase&ntilde;a, no dejar&aacute;s que otra persona acceda a tu cuenta, ni har&aacute;s cualquier cosa que pueda poner en peligro la seguridad de tu cuenta.<br />\r\n<br />\r\n12. No transferir&aacute;s la cuenta (incluida cualquier p&aacute;gina o aplicaci&oacute;n que administres) a nadie sin nuestro consentimiento previo por escrito.<br />\r\n<br />\r\n13. Si seleccionas un nombre de usuario para tu cuenta, nos reservamos el derecho a eliminarlo o reclamarlo si lo consideramos oportuno.<br />\r\n<br />\r\n4. Protecci&oacute;n de los derechos de otras personas<br />\r\nRespetamos los derechos de otras personas y esperamos que t&uacute; hagas lo mismo.<br />\r\n<br />\r\n1. No publicar&aacute;s contenido ni realizar&aacute;s ninguna acci&oacute;n en www.actytukiabi.com que infrinja o viole los derechos de otros o que viole la ley de alg&uacute;n modo.<br />\r\n<br />\r\n2. Podemos retirar cualquier contenido o informaci&oacute;n que publiques en www.actytukiabi.com si consideramos que viola esta Declaraci&oacute;n.<br />\r\n<br />\r\n3. Si infringes repetidamente los derechos de propiedad intelectual de otra persona, desactivaremos tu cuenta si es oportuno.<br />\r\n<br />\r\n4. No utilizar&aacute;s nuestros copyrights o marcas registradas (incluidos Kiabi, los logotipos de Kiabi) ni ninguna marca que se parezca a las nuestras sin nuestro permiso por escrito.<br />\r\n<br />\r\n5. No publicar&aacute;s los documentos de identificaci&oacute;n ni informaci&oacute;n financiera de nadie en www.actytukiabi.com<br />\r\n<br />\r\nSi seleccionas un nombre de usuario para tu cuenta, nos reservamos el derecho a eliminarlo o reclamarlo si lo consideramos oportuno (por ejemplo, si el propietario de una marca comercial se queja por un nombre de usuario que no est&aacute; relacionado estrechamente con el nombre real del usuario).<br />\r\n<br />\r\n5. Definiciones<br />\r\n1. El t&eacute;rmino &quot;actytu&quot; se refiere a las funciones y servicios que proporcionamos, incluidos los que se ofrecen a trav&eacute;s de (a) nuestro sitio web en www.actytukiabi.com y versiones m&oacute;viles; (b) nuestra Plataforma; (c) plugins sociales, como el bot&oacute;n &quot;Me gusta&quot;,.<br />\r\n<br />\r\n2. El t&eacute;rmino &quot;Plataforma&quot; se refiere al conjunto de API y servicios que permiten que otras personas, incluidos los desarrolladores de aplicaciones y los operadores de sitios web, recuperen datos de actytu o nos los proporcionen a nosotros.<br />\r\n<br />\r\n3. El t&eacute;rmino &quot;informaci&oacute;n&quot; se refiere a los hechos y otra informaci&oacute;n sobre ti, incluidas las acciones que realizas.<br />\r\n<br />\r\n4. El t&eacute;rmino &quot;contenido&quot; se refiere a todo lo que publicas en www.actytukiabi.com que no se incluye en la definici&oacute;n de &quot;informaci&oacute;n&quot;.<br />\r\n<br />\r\n5. El t&eacute;rmino &quot;datos&quot; se refiere al contenido y la informaci&oacute;n que pueden recuperar terceros de www.actytukiabi.com o proporcionan a actytu a trav&eacute;s de la plataforma.<br />\r\n<br />\r\n6. El t&eacute;rmino &quot;publicar&quot; significa publicar en www.actytukiabi.com.<br />\r\n<br />\r\n7. Por &quot;usar&quot; se entiende utilizar, copiar, reproducir o mostrar p&uacute;blicamente, distribuir, modificar, traducir y crear obras derivadas. '),('policy','<h2>\r\n	Pol&iacute;tica de privacidad</h2>\r\n1. Introducci&oacute;n<br />\r\nPreguntas. Si tienes alguna pregunta o duda sobre nuestra pol&iacute;tica de privacidad, ponte en contacto con nuestro equipo de privacidad enviando un mail a Info@actytukiabi.com<br />\r\n<br />\r\n&Aacute;mbito. La presente pol&iacute;tica de privacidad incluye el portal www.actytukiabi.com al completo.<br />\r\n<br />\r\n2. Informaci&oacute;n que recibimos<br />\r\nInformaci&oacute;n que nos env&iacute;as:<br />\r\n<br />\r\nInformaci&oacute;n sobre ti. Cuando te registras en la comunidad de Kiabi, nos facilitas tu nombre, correo electr&oacute;nico y fecha de nacimiento. Tambi&eacute;n podr&aacute;s a&ntilde;adir una foto.<br />\r\n<br />\r\nLos datos personales recabados en el presente formulario ser&aacute;n objeto de tratamiento en un fichero responsabilidad de Espa&ntilde;a KSCE, S.A. cuya finalidad ser&aacute; la gesti&oacute;n de cursos de formaci&oacute;n y eventos que puedan resultar de su inter&eacute;s y el intercambio de informaci&oacute;n de car&aacute;cter profesional. La entrega de todos los datos requeridos en el presente formulario es obligatoria, puesto que dichos datos son imprescindibles para cumplir con las finalidades indicadas anteriormente.<br />\r\n<br />\r\nUsted podr&aacute; ejercitar sus derechos de acceso, rectificaci&oacute;n, cancelaci&oacute;n y/u oposici&oacute;n, dirigiendo una comunicaci&oacute;n firmada por el titular de los datos a la direcci&oacute;n de correo electr&oacute;nico info@actytukiabi.com, ref. &quot;Actytu&quot;, adjuntando copia legible de su DNI e indicando la petici&oacute;n en que se concreta su solicitud y la direcci&oacute;n a la que Espa&ntilde;a KSCE, S.A pueda remitirle la confirmaci&oacute;n de haber cumplido con su solicitud, o en su caso, los motivos que le impiden llevarla a cabo plenamente.<br />\r\n<br />\r\nContenido. Una de las finalidades principales del uso de la comunidad actytu es compartir contenido referente al cambio de actitud ante el cliente, con los dem&aacute;s comerciales.<br />\r\n<br />\r\nInformaci&oacute;n que recopilamos cuando interact&uacute;as en actytu:<br />\r\n<br />\r\nInformaci&oacute;n sobre la actividad en el sitio web. Realizamos un seguimiento de las acciones que llevas a cabo en actytu como indicar que &quot;te gusta&quot; una publicaci&oacute;n, o cuando compartes videos, fotos o comentarios en cada una de las secciones del portal.<br />\r\n<br />\r\n3. Compartir informaci&oacute;n en actytu<br />\r\nNombre y foto del perfil. Ha sido dise&ntilde;ado para que te resulte sencillo encontrar y modificar los campos de nick, foto o estado. Si no quieres compartir la foto de tu perfil, debes eliminarla (o no a&ntilde;adir ninguna).<br />\r\n<br />\r\n4. C&oacute;mo utilizamos tu informaci&oacute;n<br />\r\nUtilizamos la informaci&oacute;n que recopilamos para tratar de ofrecerte una experiencia segura, eficaz y personalizada. A continuaci&oacute;n, incluimos algunos datos sobre c&oacute;mo lo hacemos:<br />\r\n<br />\r\nPara gestionar el servicio. Utilizamos la informaci&oacute;n que recopilamos para ofrecerte nuestros servicios y funciones, evaluarlos y mejorarlos y prestarte servicio t&eacute;cnico. Empleamos la informaci&oacute;n para impedir actividades que podr&iacute;an ser ilegales y para aplicar nuestra Declaraci&oacute;n de Derechos y Responsabilidades. Estos esfuerzos pueden provocar, en ocasiones, el fin o la suspensi&oacute;n temporal o permanente de algunas funciones para algunos usuarios.<br />\r\n<br />\r\nPara ponernos en contacto contigo. Ocasionalmente, podemos ponernos en contacto contigo para informarte de anuncios relativos a servicios.<br />\r\n<br />\r\n6. C&oacute;mo puedes cambiar eliminar informaci&oacute;n<br />\r\nEdici&oacute;n de tu perfil. Puedes cambiar o eliminar la informaci&oacute;n de tu perfil en cualquier momento yendo a tu perfil y haciendo clic en &quot;Editar mi perfil&quot;. La informaci&oacute;n se actualizar&aacute; de inmediato.<br />\r\n<br />\r\n7. C&oacute;mo protegemos la informaci&oacute;n<br />\r\nHacemos todo lo posible para mantener a salvo tu informaci&oacute;n, pero necesitamos tu ayuda.<br />\r\n<br />\r\nMedidas que tomamos para mantener a salvo su informaci&oacute;n. Mantenemos la informaci&oacute;n de tu cuenta en un servidor protegido con un firewall. Cuando introduces informaci&oacute;n confidencial (por ejemplo, contrase&ntilde;as). Tambi&eacute;n utilizamos medidas sociales y automatizadas para aumentar la seguridad (como el an&aacute;lisis de la actividad de la cuenta), podemos limitar el uso de funciones del sitio web en respuesta a posibles signos de abuso, podemos eliminar contenido inadecuado o enlaces a contenido ilegal, y podemos suspender o desactivar cuentas por si hubiera violaciones de nuestra Declaraci&oacute;n de Derechos y Responsabilidades.<br />\r\n<br />\r\nRiesgos inherentes a compartir informaci&oacute;n. Aunque te permitimos definir opciones de privacidad que limiten el acceso a tu informaci&oacute;n, ten en cuenta que ninguna medida de seguridad es perfecta ni impenetrable. No podemos controlar las acciones de otros usuarios con los que compartas informaci&oacute;n. No podemos garantizar que s&oacute;lo vean tu informaci&oacute;n personas autorizadas. No podemos garantizar que la informaci&oacute;n que compartas en comunidadsiempremas.com no pase a estar disponible p&uacute;blicamente. No somos responsables de que ning&uacute;n tercero burle cualquier configuraci&oacute;n de la privacidad o medidas de seguridad en www.actytukiabi.com. Puedes reducir estos riesgos utilizando h&aacute;bitos de seguridad de sentido com&uacute;n como elegir una contrase&ntilde;a segura, utilizar contrase&ntilde;as diferentes para servicios diferentes y emplear software antivirus actualizado.<br />\r\n<br />\r\nInformar de incumplimientos. Deber&iacute;as informarnos de cualquier incumplimiento de la seguridad escribi&eacute;ndonos a info@actytukiabi.com<br />\r\n<br />\r\n9. Otras condiciones<br />\r\nCambios. Podemos cambiar esta Pol&iacute;tica de privacidad conforme a los procedimientos se&ntilde;alados en la Declaraci&oacute;n de Derechos y Responsabilidades. Salvo indicaci&oacute;n en contrario, nuestra pol&iacute;tica de privacidad en vigor se aplica a toda la informaci&oacute;n que tenemos sobre ti y tu cuenta. Si realizamos cambios en esta Pol&iacute;tica de privacidad, te lo notificaremos public&aacute;ndolo aqu&iacute; y en la p&aacute;gina www.actytukiabi.com. Si los cambios son sustanciales, mostraremos un aviso prominente si las circunstancias lo requieren. '),('nueva','<h2>\r\n	T&iacute;tulo de la nueva p&aacute;gina</h2>\r\nla nueva p&aacute;gina 2 y con un poco m&aacute;s de texto de relleno.<br />\r\n<br />\r\n<ul>\r\n	<li>\r\n		Opci&oacute;n 1 de la lista</li>\r\n	<li>\r\n		La opci&oacute;n 2 de la lista</li>\r\n	<li>\r\n		Una tercera opci&oacute;n para la lista de la p&aacute;gina</li>\r\n</ul>\r\nUn poco m&aacute;s de texto para continuar un nuevo parrafo en la p&aacute;gina.');

/*Table structure for table `promociones` */

DROP TABLE IF EXISTS `promociones`;

CREATE TABLE `promociones` (
  `id_promocion` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_promocion` varchar(250) NOT NULL DEFAULT '',
  `cabecera_promocion` longtext NOT NULL,
  `texto_promocion` longtext NOT NULL,
  `imagen_promocion` varchar(250) NOT NULL DEFAULT '',
  `imagen_promocion2` varchar(250) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `date_comentarios` date DEFAULT NULL,
  `date_fin_comentarios` date DEFAULT NULL,
  `galeria_comentarios` int(2) NOT NULL DEFAULT '0',
  `galeria_videos` int(2) NOT NULL DEFAULT '0',
  `galeria_fotos` int(2) NOT NULL DEFAULT '0',
  `galeria_audios` int(2) NOT NULL DEFAULT '0',
  `oportunidades_comentarios` int(2) NOT NULL DEFAULT '0',
  `oportunidades_videos` int(2) NOT NULL DEFAULT '0',
  `oportunidades_fotos` int(2) NOT NULL DEFAULT '0',
  `oportunidades_audios` int(2) NOT NULL DEFAULT '0',
  `mostrar_comentarios` longtext,
  `mostrar_videos` longtext,
  `mostrar_fotos` longtext,
  `mostrar_audios` longtext,
  `subir_contenidos` tinyint(1) NOT NULL DEFAULT '1',
  `bloqueado` tinyint(1) NOT NULL DEFAULT '0',
  `instrucciones` varchar(250) NOT NULL DEFAULT '',
  `canal_promocion` varchar(100) NOT NULL DEFAULT 'exclusivo',
  `audio1` varchar(250) NOT NULL DEFAULT '',
  `imagen_premio` varchar(250) NOT NULL DEFAULT '',
  `tipo_reto` varchar(100) NOT NULL DEFAULT 'estandar',
  PRIMARY KEY (`id_promocion`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `promociones` */

insert  into `promociones`(`id_promocion`,`nombre_promocion`,`cabecera_promocion`,`texto_promocion`,`imagen_promocion`,`imagen_promocion2`,`active`,`date_comentarios`,`date_fin_comentarios`,`galeria_comentarios`,`galeria_videos`,`galeria_fotos`,`galeria_audios`,`oportunidades_comentarios`,`oportunidades_videos`,`oportunidades_fotos`,`oportunidades_audios`,`mostrar_comentarios`,`mostrar_videos`,`mostrar_fotos`,`mostrar_audios`,`subir_contenidos`,`bloqueado`,`instrucciones`,`canal_promocion`,`audio1`,`imagen_premio`,`tipo_reto`) values (1,'Reto de inicio de la comunidad','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu gravida ante, vel elementum neque. Suspendisse in aliquam diam.','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu gravida ante, vel elementum neque. Suspendisse in aliquam diam. Quisque eu neque accumsan, volutpat libero sit amet, dictum magna. Nunc tempor ipsum rhoncus lorem fringilla imperdiet. Fusce leo dui, euismod fringilla nulla eu, cursus laoreet elit. Vivamus aliquet leo sit amet orci ullamcorper, vel hendrerit diam varius. ','','',1,NULL,NULL,0,0,0,0,0,0,0,0,NULL,NULL,NULL,NULL,1,0,'','exclusivo','','','estandar');

/*Table structure for table `promociones_preguntas` */

DROP TABLE IF EXISTS `promociones_preguntas`;

CREATE TABLE `promociones_preguntas` (
  `id_pregunta` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_promocion` int(11) NOT NULL DEFAULT '0',
  `texto_pregunta` longtext,
  `tipo_pregunta` varchar(100) NOT NULL DEFAULT 'texto',
  `num_respuestas` int(2) NOT NULL DEFAULT '0',
  `puntos` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_pregunta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `promociones_preguntas` */

/*Table structure for table `promociones_videos` */

DROP TABLE IF EXISTS `promociones_videos`;

CREATE TABLE `promociones_videos` (
  `id_file` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_promocion` int(11) unsigned NOT NULL DEFAULT '0',
  `nombre_video` varchar(250) NOT NULL DEFAULT '',
  `texto_video` longtext NOT NULL,
  `ruta_video` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_file`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `promociones_videos` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `username` varchar(100) NOT NULL DEFAULT '',
  `nick` varchar(100) NOT NULL DEFAULT '',
  `user_password` varchar(200) NOT NULL DEFAULT '' COMMENT 'codificacion sha1',
  `email` varchar(200) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `surname` varchar(200) NOT NULL DEFAULT '',
  `date_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `registered` tinyint(1) NOT NULL DEFAULT '1',
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `date_disabled` datetime NOT NULL DEFAULT '1970-01-01 00:00:00',
  `canal` varchar(250) NOT NULL DEFAULT '',
  `empresa` varchar(100) NOT NULL DEFAULT '',
  `perfil` varchar(100) NOT NULL DEFAULT '',
  `foto` varchar(250) NOT NULL DEFAULT '',
  `puntos` int(11) NOT NULL DEFAULT '0',
  `participaciones` int(11) NOT NULL DEFAULT '0',
  `user_comentarios` longtext NOT NULL,
  `user_date` date DEFAULT NULL,
  `telefono` varchar(100) NOT NULL DEFAULT '',
  `last_access` datetime DEFAULT NULL,
  PRIMARY KEY (`username`),
  KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`username`,`nick`,`user_password`,`email`,`name`,`surname`,`date_add`,`registered`,`confirmed`,`disabled`,`date_disabled`,`canal`,`empresa`,`perfil`,`foto`,`puntos`,`participaciones`,`user_comentarios`,`user_date`,`telefono`,`last_access`) values ('admin','AdminII','1234','dnoguera@imagar.com','Administrador','Community','2014-07-16 14:43:05',1,1,0,'1970-01-01 00:00:00','admin','0001','admin','1410965720_mcbeth.jpeg',18,11,'C/algo3',NULL,'','2014-09-18 17:48:03'),('david','DNG','1234','dnoguera@imagar.com','David','Noguera','2014-07-16 14:43:08',1,1,0,'1970-01-01 00:00:00','comercial','0002','usuario','',5,1,'',NULL,'','2014-09-18 16:20:54'),('borja','Borja','1234','bvilaplana@imagar.com','Borja','Vilaplana','2014-09-16 17:38:00',1,1,0,'1970-01-01 00:00:00','comercial','0003','usuario','',9,0,'',NULL,'',NULL),('pedro','Pedro','1234','pramos@imagar.com','Pedro','Ramos','2014-09-16 17:38:57',1,1,0,'1970-01-01 00:00:00','comercial','0002','usuario','',2,0,'',NULL,'',NULL),('claudio','Claudio','1234','cgonzalez@imagar.com','Claudio','Gonzalez','2014-09-16 17:40:12',1,1,0,'1970-01-01 00:00:00','gerente','0003','usuario','',6,0,'',NULL,'',NULL),('dmarchante','DavidM','1234','dmarchante@imagar.com','David','Marchante','2014-09-17 09:32:54',1,1,0,'1970-01-01 00:00:00','comercial','0002','usuario','',3,0,'',NULL,'',NULL),('senen','Senén','12345','shermida@imagar.com','Senén','Hermida','2014-09-17 09:33:27',1,1,0,'1970-01-01 00:00:00','gerente','0002','usuario','',6,0,'',NULL,'',NULL),('dgarcia','Dsan','1234','dgarcia@imagar.com','Daniel','García','2014-09-17 09:34:47',1,1,0,'1970-01-01 00:00:00','comercial','0003','usuario','',8,0,'',NULL,'',NULL);

/*Table structure for table `users_connected` */

DROP TABLE IF EXISTS `users_connected`;

CREATE TABLE `users_connected` (
  `username` varchar(100) NOT NULL,
  `connection_canal` varchar(100) NOT NULL DEFAULT '',
  `connection_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `users_connected` */

insert  into `users_connected`(`username`,`connection_canal`,`connection_time`) values ('admin','admin','2014-09-18 17:51:44'),('david','comercial','2014-09-18 16:21:33');

/*Table structure for table `users_participaciones` */

DROP TABLE IF EXISTS `users_participaciones`;

CREATE TABLE `users_participaciones` (
  `id_participacion` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `participacion_username` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `participacion_motivo` varchar(250) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `participacion_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `valor` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_participacion`)
) ENGINE=MyISAM AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;

/*Data for the table `users_participaciones` */

insert  into `users_participaciones`(`id_participacion`,`participacion_username`,`participacion_motivo`,`participacion_date`,`valor`) values (1,'admin','Comentario en el foro','2014-02-21 20:07:21',1),(2,'admin','Comentario en el foro','2014-02-21 20:36:50',1),(3,'admin','Comentario en el foro','2014-02-27 12:07:35',1),(4,'admin','Comentario en el foro','2014-03-24 15:58:35',1),(5,'admin','Comentario en el foro','2014-03-25 08:56:05',1),(6,'admin','Comentario en el foro','2014-03-25 08:56:44',1),(7,'admin','Comentario en el foro','2014-03-25 09:02:09',1),(8,'admin','Comentario en el foro','2014-03-25 09:03:34',1),(9,'admin','Comentario en el foro','2014-03-25 09:04:19',1),(10,'admin','Comentario en el foro','2014-03-25 09:04:42',1),(11,'admin','Comentario en el foro','2014-03-25 09:06:38',1),(12,'admin','test','2014-03-26 13:02:34',1),(13,'admin','Comentario en el foro','2014-03-28 10:10:35',1),(14,'admin','Comentario en el foro','2014-04-02 09:40:40',1),(15,'admin','Comentario en el foro','2014-04-02 09:50:24',1),(16,'admin','Comentario en el foro','2014-04-02 09:56:51',1),(17,'admin','Comentario en el foro','2014-04-02 09:57:00',1),(18,'admin','Comentario en el foro','2014-04-02 09:57:47',1),(19,'admin','Comentario en el foro','2014-04-02 10:04:50',1),(20,'admin','Comentario en el foro','2014-04-02 10:05:13',1),(21,'admin','Comentario en el foro','2014-04-02 10:05:23',1),(22,'admin','Comentario en el foro','2014-04-02 10:39:20',1),(23,'admin','Comentario en el foro','2014-04-05 00:14:03',1),(24,'admin','Comentario en el foro','2014-04-08 10:48:55',1),(25,'admin','Comentario en el foro','2014-04-08 10:50:06',1),(26,'20266370N','Comentario en el foro','2014-04-09 15:39:48',1),(27,'admin','Comentario en el foro','2014-05-01 17:42:37',1),(28,'admin','Comentario en el foro','2014-05-01 17:42:37',1),(29,'admin','Comentario en el foro','2014-05-01 17:42:37',1),(30,'admin','Comentario en el foro','2014-05-01 17:44:27',1),(31,'admin','Comentario en el foro','2014-05-01 17:44:27',1),(32,'admin','Comentario en el foro','2014-05-01 17:44:27',1),(33,'admin','Comentario en el foro','2014-05-01 17:44:53',1),(34,'admin','Comentario en el foro','2014-05-01 17:45:01',1),(35,'admin','Comentario en el foro','2014-05-01 17:45:01',1),(36,'admin','Comentario en el foro','2014-05-01 17:45:01',1),(37,'admin','Comentario en el foro','2014-05-01 17:45:01',1),(38,'admin','Comentario en el foro','2014-05-01 17:58:58',1),(39,'admin','Comentario en el foro','2014-05-01 18:19:26',1),(40,'admin','Comentario en el foro','2014-05-01 18:20:07',1),(41,'admin','Comentario en el foro','2014-05-02 11:38:44',1),(42,'admin','Comentario en el foro','2014-05-02 11:40:43',1),(43,'admin','Comentario en el foro','2014-05-02 11:40:48',1),(44,'admin','Comentario en el foro','2014-05-02 11:40:54',1),(45,'admin','Comentario en el foro','2014-05-02 11:41:02',1),(46,'admin','Comentario en el foro','2014-05-02 11:41:16',1),(47,'admin','Comentario en el foro','2014-05-02 11:42:10',1),(48,'admin','Comentario en el foro','2014-05-02 11:42:23',1),(49,'admin','Comentario en el foro','2014-05-02 11:42:37',1),(50,'admin','Comentario en el foro','2014-05-02 11:43:30',1),(51,'admin','Comentario en el foro','2014-05-02 11:56:16',1),(52,'admin','Comentario en el foro','2014-05-02 12:09:40',1),(53,'admin','Comentario en el foro','2014-05-02 12:09:51',1),(54,'admin','Comentario en el foro','2014-05-02 12:10:04',1),(55,'admin','Comentario en el foro','2014-05-02 12:10:18',1),(56,'admin','Comentario en el foro','2014-05-02 12:10:28',1),(57,'admin','Comentario en el foro','2014-05-02 12:11:39',1),(58,'admin','Comentario en el foro','2014-05-02 12:11:52',1),(59,'admin','Comentario en el foro','2014-05-02 12:11:59',1),(60,'admin','Comentario en el foro','2014-05-02 12:12:16',1),(61,'admin','Comentario en el foro','2014-05-02 12:12:27',1),(62,'admin','Comentario en el foro','2014-05-02 12:12:36',1),(63,'admin','Comentario en el foro','2014-05-02 12:12:43',1),(64,'20266370N','Comentario en el foro','2014-05-02 17:13:29',1),(65,'20266370N','Comentario en el foro','2014-05-02 23:32:55',1),(66,'20266370N','Comentario en el foro','2014-05-02 23:35:06',1),(67,'20266370N','Comentario en el foro','2014-05-02 23:36:26',1),(68,'admin','Comentario en el foro','2014-05-05 15:47:23',1),(69,'admin','Comentario en el foro','2014-07-24 13:59:45',1),(70,'admin','Comentario en el foro','2014-07-24 14:00:10',1),(71,'admin','Comentario en el muro','2014-07-29 14:46:12',1),(72,'admin','Comentario en el muro','2014-07-29 14:46:57',1),(73,'admin','Comentario en el muro','2014-07-30 10:44:49',1),(74,'admin','Comentario en el muro','2014-07-30 10:44:52',1),(75,'admin','Comentario en el muro','2014-07-30 10:44:55',1),(76,'admin','Comentario en el muro','2014-07-30 10:44:59',1),(77,'admin','Comentario en el muro','2014-07-30 11:57:02',-1),(78,'admin','Subida de foto','2014-09-10 11:15:27',1),(79,'admin','Comentario en el foro','2014-09-10 14:10:13',1),(80,'admin','Subida de foto','2014-09-15 13:35:46',1),(81,'admin','Comentario en el muro','2014-09-18 10:31:00',1),(82,'david','Comentario en el muro','2014-09-18 16:21:26',1);

/*Table structure for table `users_puntuaciones` */

DROP TABLE IF EXISTS `users_puntuaciones`;

CREATE TABLE `users_puntuaciones` (
  `id_puntuacion` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `puntuacion_username` varchar(100) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `puntuacion_puntos` int(11) NOT NULL DEFAULT '0',
  `puntuacion_motivo` varchar(250) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `puntuacion_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_puntuacion`)
) ENGINE=MyISAM AUTO_INCREMENT=145 DEFAULT CHARSET=latin1;

/*Data for the table `users_puntuaciones` */

insert  into `users_puntuaciones`(`id_puntuacion`,`puntuacion_username`,`puntuacion_puntos`,`puntuacion_motivo`,`puntuacion_date`) values (116,'david',1,'Acceso semanal','2014-07-17 14:03:28'),(117,'admin',1,'Acceso semanal','2014-07-23 10:16:49'),(118,'admin',5,'Comentario en el foro semanal','2014-07-24 13:59:45'),(119,'admin',0,'Comentario en el foro','2014-07-24 13:59:45'),(120,'admin',0,'Comentario en el foro','2014-07-24 14:00:10'),(121,'admin',1,'Acceso semanal','2014-07-28 10:23:33'),(122,'admin',0,'Comentario en el muro','2014-07-29 14:46:12'),(123,'admin',0,'Comentario en el muro','2014-07-29 14:46:57'),(124,'admin',0,'Comentario en el muro','2014-07-30 10:44:49'),(125,'admin',0,'Comentario en el muro','2014-07-30 10:44:52'),(126,'admin',0,'Comentario en el muro','2014-07-30 10:44:55'),(127,'admin',0,'Comentario en el muro','2014-07-30 10:44:59'),(128,'admin',0,'Comentario en el muro','2014-07-30 11:57:02'),(129,'admin',1,'Acceso semanal','2014-08-04 10:34:30'),(130,'admin',1,'Acceso semanal','2014-08-11 09:02:47'),(131,'david',1,'Acceso semanal','2014-08-11 13:01:24'),(132,'admin',1,'Acceso semanal','2014-08-19 09:56:28'),(133,'admin',1,'Acceso semanal','2014-08-27 13:23:13'),(134,'david',1,'Acceso semanal','2014-08-29 08:40:26'),(135,'admin',1,'Acceso semanal','2014-09-08 18:07:54'),(136,'admin',0,'Subida de foto','2014-09-10 11:15:27'),(137,'admin',5,'Comentario en el foro semanal','2014-09-10 14:10:13'),(138,'admin',0,'Comentario en el foro','2014-09-10 14:10:13'),(139,'david',1,'Acceso semanal','2014-09-11 12:56:49'),(140,'admin',1,'Acceso semanal','2014-09-15 08:32:22'),(141,'admin',0,'Subida de foto','2014-09-15 13:35:46'),(142,'admin',0,'Comentario en el muro','2014-09-18 10:31:00'),(143,'david',1,'Acceso semanal','2014-09-18 16:20:54'),(144,'david',0,'Comentario en el muro','2014-09-18 16:21:26');

/*Table structure for table `users_sucursales` */

DROP TABLE IF EXISTS `users_sucursales`;

CREATE TABLE `users_sucursales` (
  `id_sucursal` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_sucursal` varchar(100) NOT NULL DEFAULT '',
  `name_sucursal` varchar(250) NOT NULL DEFAULT '',
  `address_sucursal` text NOT NULL,
  PRIMARY KEY (`id_sucursal`,`user_sucursal`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `users_sucursales` */

insert  into `users_sucursales`(`id_sucursal`,`user_sucursal`,`name_sucursal`,`address_sucursal`) values (1,'20266370N','Sucursal 1 DNG','direccion suc. 1'),(4,'20266370N','Sucursal 2 DNG','C/Vinagre 34, 28000 MADRID'),(7,'admin','CC. TRES AGUAS ','Av. Mollejas 34, Local 18. Alcorcón 28923 - Madrid'),(9,'admin','CC. XANADOO','Paseo de Extremadura 178. Local 29, 28936 MOSTOLES - MADRID'),(10,'admin','Global Vision','C/Medialuna 18. 28000 Madrid - Madrid');

/*Table structure for table `users_tiendas` */

DROP TABLE IF EXISTS `users_tiendas`;

CREATE TABLE `users_tiendas` (
  `cod_tienda` varchar(100) NOT NULL,
  `nombre_tienda` varchar(250) NOT NULL DEFAULT '',
  `regional_tienda` varchar(250) NOT NULL DEFAULT '',
  `responsable_tienda` varchar(250) NOT NULL DEFAULT '',
  `tipo_tienda` varchar(100) NOT NULL DEFAULT 'franquicia',
  PRIMARY KEY (`cod_tienda`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `users_tiendas` */

insert  into `users_tiendas`(`cod_tienda`,`nombre_tienda`,`regional_tienda`,`responsable_tienda`,`tipo_tienda`) values ('0001','CENTRAL','','','Tienda propia'),('0002','TIENDAS PROPIAS','','','Tienda propia'),('0003','FRANQUICIAS','','','Franquicia');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
