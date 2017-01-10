/*
SQLyog Community v12.2.6 (32 bit)
MySQL - 5.5.53-0+deb8u1 : Database - comunidad
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`comunidad` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `comunidad`;

/*Table structure for table `accesscontrol` */

DROP TABLE IF EXISTS `accesscontrol`;

CREATE TABLE `accesscontrol` (
  `id` int(25) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `perfil_access` varchar(100) NOT NULL DEFAULT '',
  `empresa_access` varchar(100) NOT NULL DEFAULT '',
  `canal_access` varchar(100) NOT NULL DEFAULT '',
  `webpage` varchar(250) NOT NULL,
  `webpage_id` varchar(250) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(100) NOT NULL DEFAULT '',
  `agent` varchar(250) NOT NULL DEFAULT 'Desconocido',
  `browser` varchar(100) NOT NULL DEFAULT 'Otros',
  `platform` varchar(100) NOT NULL DEFAULT 'Otras',
  `seconds` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `webpage` (`webpage`),
  KEY `fecha` (`fecha`),
  KEY `browser` (`browser`),
  KEY `platform` (`platform`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `accesscontrol` */

/*Table structure for table `agenda` */

DROP TABLE IF EXISTS `agenda`;

CREATE TABLE `agenda` (
  `id_agenda` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `descripcion` longtext CHARACTER SET latin1 NOT NULL,
  `banner` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `date_ini` timestamp NULL DEFAULT NULL,
  `date_fin` timestamp NULL DEFAULT NULL,
  `archivo` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `tipo` int(2) NOT NULL,
  `canal` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `date_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_add` varchar(100) NOT NULL DEFAULT '',
  `etiquetas` text NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_agenda`),
  KEY `agenda` (`id_agenda`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

/*Data for the table `agenda` */

insert  into `agenda`(`id_agenda`,`titulo`,`descripcion`,`banner`,`date_ini`,`date_fin`,`archivo`,`tipo`,`canal`,`date_add`,`user_add`,`etiquetas`,`activo`) values 
(1,'Red Day','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse consectetur sem id dui tincidunt porta. Nunc porta sit amet erat eu convallis. Sed tempor lobortis hendrerit. Donec ante mi, convallis in condimentum nec, finibus eu ipsum. Ut viverra faucibus metus ac pretium. Donec in mauris faucibus, dignissim urna in, mollis libero. Suspendisse interdum tortor lacus, sed malesuada dolor scelerisque nec. Etiam convallis lacus vel porttitor facilisis.</p>\r\n','1479818779_1476963167_2016_12_14_red_day_navidad_3__1_.jpg','2016-10-01 00:00:00','2019-10-31 00:00:00','',1,'comercial','2016-10-04 16:21:21','admin','etiquetas',1),
(2,'Music Vodafone Yu: Melendi','<p>Cras vitae nisi scelerisque ante aliquet rutrum. Suspendisse mauris nulla, rhoncus non dictum non, aliquam vitae ligula. Nunc scelerisque semper ipsum, quis lacinia est aliquet vitae. In at massa fermentum, rhoncus ipsum sed, congue sem. Integer vulputate sit amet nunc interdum semper. Nulla vehicula ipsum vitae ligula ultrices, eu bibendum dolor mattis. Ut ut mauris nec ante tincidunt maximus. Nulla facilisi. Phasellus sed erat vulputate, imperdiet lectus nec, finibus velit. Sed tempor purus nisl, non dapibus urna aliquam vitae. Quisque sed laoreet lacus. Phasellus faucibus interdum iaculis. Nullam nibh quam, faucibus sed euismod quis, pretium at arcu. Ut vulputate odio ac metus volutpat, sit amet laoreet elit aliquet. Proin turpis leo, sagittis vel malesuada a, sodales et odio. Mauris facilisis nulla quis aliquam malesuada. Duis sed sem sed eros varius elementum semper id erat. Sed efficitur sapien ac ultricies ultrices. Mauris venenatis tempor massa. Fusce ultrices nunc non dolor semper aliquet. Pellentesque nec interdum ante. Etiam maximus eget nisl et rutrum.</p>\r\n','1479818751_1476962730_2016_10_17_melendi_3.jpg','2016-10-09 00:00:00','2019-10-31 00:00:00','',1,'gerente','2016-10-04 16:22:53','admin','etiquetas',1),
(25,'Los 40 music Awards','<p>algo de texto en la entrada</p>\r\n','1479818733_1479804804_los40musicawards-690x308.jpg','2016-11-02 00:00:00','2017-12-01 00:00:00','',1,'comercial,gerente,test','2016-11-16 12:18:50','admin','',0),
(30,'Una oferta para todos','<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum id ligula dignissim velit condimentum iaculis sed non dui. Ut eget nunc a augue dapibus imperdiet a in ex. Aliquam erat volutpat. In auctor, ex vel bibendum lacinia, nulla arcu vestibulum mi, a lacinia sapien nisi eget turpis. Praesent vitae risus non dui ullamcorper pellentesque quis quis turpis. Donec placerat varius ante, in hendrerit nulla venenatis vitae. Morbi elementum massa at bibendum euismod. Sed vitae consectetur purus. Integer nibh eros, pellentesque ut dictum eget, consequat cursus neque. Donec tristique libero finibus ligula molestie ultricies. Aliquam ut bibendum neque, nec semper diam. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean convallis justo sit amet diam finibus mattis. Suspendisse quis odio elit. Nulla eget est in eros mattis tincidunt. Phasellus quis turpis laoreet, lacinia velit ut, tincidunt nulla.</p>\r\n\r\n<p style=\"margin: 0px 0px 15px; padding: 0px; text-align: justify; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px;\">Donec pharetra et diam cursus dapibus. Duis egestas ipsum ac augue gravida, sed egestas ipsum sodales. Donec tincidunt mattis condimentum. Curabitur turpis orci, pellentesque tristique congue eu, congue et mi. Maecenas justo leo, porttitor nec convallis eget, consectetur vitae felis. Praesent a purus tempor neque placerat faucibus finibus malesuada velit. Cras ultrices gravida augue, id mattis tellus fermentum a.</p>\r\n','1482133279_1476858388.gif','2016-12-01 00:00:00','2017-08-11 00:00:00','1482133279_presupuesto5752a.pdf',2,'comercial,gerente,test','2016-12-19 08:41:19','admin','Animados',1);

/*Table structure for table `agenda_tipos` */

DROP TABLE IF EXISTS `agenda_tipos`;

CREATE TABLE `agenda_tipos` (
  `id_agenda_tipo` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_name` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT '',
  PRIMARY KEY (`id_agenda_tipo`),
  KEY `id_agenda_tipo` (`id_agenda_tipo`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `agenda_tipos` */

insert  into `agenda_tipos`(`id_agenda_tipo`,`tipo_name`) values 
(1,'Agenda'),
(2,'Oferta');

/*Table structure for table `alerts` */

DROP TABLE IF EXISTS `alerts`;

CREATE TABLE `alerts` (
  `id_alert` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `text_alert` text NOT NULL,
  `type_alert` varchar(100) NOT NULL DEFAULT 'user' COMMENT 'user; group',
  `destination_alert` varchar(100) NOT NULL DEFAULT '',
  `date_alert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_post` varchar(100) NOT NULL DEFAULT '',
  `priority` varchar(50) NOT NULL DEFAULT 'normal',
  `date_ini` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  `activa` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_alert`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `alerts` */

insert  into `alerts`(`id_alert`,`text_alert`,`type_alert`,`destination_alert`,`date_alert`,`user_post`,`priority`,`date_ini`,`date_fin`,`activa`) values 
(1,'Un mensaje con prioridad alta','user','david','2016-02-12 11:37:37','admin','hight','2016-02-26 00:00:00','2016-02-26 23:59:59',1),
(2,'Otro mensaje pero con prioridad media para el grupo 0002','group','0002','2016-02-12 11:38:09','admin','medium','2016-02-26 00:00:00','2016-02-26 23:59:59',1),
(3,'Otro mensaje pero sin prioridad','user','admin','2016-02-12 11:38:27','admin','low','2016-02-26 00:00:00','2016-02-26 23:59:59',1),
(4,'Mensaje recordatorio para todos: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin semper, nunc ut cursus sagittis','user','admin','2016-02-12 11:56:59','admin','hight','2016-02-26 00:00:00','2016-12-26 23:59:59',1),
(5,'Alerta para el grupo 0001','group','0001','2016-02-24 16:29:03','admin','low','2016-02-26 00:00:00','2016-12-26 23:59:59',1),
(6,'Ir al medico, esa tos no se acaba de ir','user','jgonzalez','2016-02-26 10:58:27','pedro','hight','2016-02-25 00:00:00','2016-02-25 23:59:59',1),
(7,'Todos a comer a las 14:00','group','0002','2016-02-26 11:14:10','pedro','medium','2016-02-26 00:00:00','2016-02-26 23:59:59',1),
(8,'Baja voluntaria','user','dcancho','2016-02-26 11:14:38','pedro','hight','2016-02-01 00:00:00','2016-02-01 23:59:59',1),
(9,'Una com prioridad baja','user','jgonzalez','2016-02-26 11:22:24','pedro','low','2016-02-26 00:00:00','2016-02-27 23:59:59',1),
(10,'Tareas e prioridad media para TIENDAS PROPIAS2','group','0004','2016-02-26 11:54:32','pedro','medium','2016-02-25 00:00:00','2016-03-12 23:59:59',1),
(11,'Hay que limpiar la tienda todos los días','group','0002','2016-03-14 10:13:46','admin','hight','2016-03-01 00:00:00','2016-06-30 23:59:59',1),
(12,'Encárgate de que limpien la tienda todos los días','user','pedro','2016-03-14 10:14:51','admin','hight','2016-03-01 00:00:00','2016-06-30 23:59:59',1);

/*Table structure for table `batallas` */

DROP TABLE IF EXISTS `batallas`;

CREATE TABLE `batallas` (
  `id_batalla` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_create` varchar(100) NOT NULL DEFAULT '',
  `user_retado` varchar(100) NOT NULL DEFAULT '',
  `date_batalla` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tipo_batalla` varchar(100) NOT NULL DEFAULT '',
  `finalizada` tinyint(1) NOT NULL DEFAULT '0',
  `ganador` varchar(100) NOT NULL DEFAULT '',
  `puntos` int(11) NOT NULL DEFAULT '0',
  `canal_batalla` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_batalla`)
) ENGINE=MyISAM AUTO_INCREMENT=748 DEFAULT CHARSET=latin1;

/*Data for the table `batallas` */

insert  into `batallas`(`id_batalla`,`user_create`,`user_retado`,`date_batalla`,`tipo_batalla`,`finalizada`,`ganador`,`puntos`,`canal_batalla`) values 
(732,'admin','senen','2016-02-26 12:27:04','General',1,'admin',5,'gerente'),
(734,'senen','david','2016-02-26 12:28:49','General',1,'david',5,'comercial'),
(736,'admin','borja','2016-03-11 10:16:49','General',1,'borja',15,'comercial');

/*Table structure for table `batallas_luchas` */

DROP TABLE IF EXISTS `batallas_luchas`;

CREATE TABLE `batallas_luchas` (
  `id_lucha` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_batalla` int(11) NOT NULL DEFAULT '0',
  `date_lucha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_lucha` varchar(100) NOT NULL DEFAULT '',
  `tiempo_lucha` double NOT NULL DEFAULT '0',
  `aciertos_lucha` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0: no acertada; 1: acertada',
  `origen` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1: web; 2: web movil; 3: app',
  PRIMARY KEY (`id_lucha`),
  KEY `id_batalla` (`id_batalla`),
  KEY `user_lucha` (`user_lucha`)
) ENGINE=MyISAM AUTO_INCREMENT=759 DEFAULT CHARSET=latin1;

/*Data for the table `batallas_luchas` */

insert  into `batallas_luchas`(`id_lucha`,`id_batalla`,`date_lucha`,`user_lucha`,`tiempo_lucha`,`aciertos_lucha`,`origen`) values 
(739,731,'2016-02-22 16:39:30','admin',10,2,1),
(740,732,'2016-02-26 12:27:05','admin',7,2,1),
(741,733,'2016-02-26 12:27:16','admin',6,1,1),
(742,732,'2016-02-26 12:28:28','senen',5,1,1),
(743,734,'2016-02-26 12:28:49','senen',5,0,1),
(744,734,'2016-02-26 12:30:32','david',5,2,1),
(745,735,'2016-02-26 12:37:51','admin',9,1,1),
(746,736,'2016-03-11 10:16:49','admin',7,1,1),
(747,736,'2016-03-11 10:32:07','borja',8,2,1),
(748,737,'2016-03-11 10:32:56','borja',6,1,1),
(749,738,'2016-03-11 11:30:57','admin',0,0,1),
(750,739,'2016-03-11 11:30:57','admin',6,0,1),
(751,740,'2016-03-11 11:31:18','admin',5,2,1),
(752,741,'2016-03-17 10:57:22','admin',98,3,1),
(753,742,'2016-08-23 09:48:58','admin',13,1,1),
(754,743,'2016-08-23 09:49:42','admin',0,0,1),
(755,744,'2016-08-23 09:50:10','admin',0,0,1),
(756,745,'2016-08-23 09:50:10','admin',0,0,1),
(757,746,'2016-08-23 10:01:38','admin',0,0,1),
(758,747,'2016-08-29 14:14:30','admin',5,0,1);

/*Table structure for table `batallas_preguntas` */

DROP TABLE IF EXISTS `batallas_preguntas`;

CREATE TABLE `batallas_preguntas` (
  `id_pregunta` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pregunta_tipo` varchar(100) NOT NULL DEFAULT '',
  `pregunta` longtext,
  `respuesta1` longtext,
  `respuesta2` longtext,
  `respuesta3` longtext,
  `valida` tinyint(4) NOT NULL DEFAULT '0',
  `activa` tinyint(1) NOT NULL DEFAULT '1',
  `canal_pregunta` varchar(100) NOT NULL DEFAULT 'comercial',
  PRIMARY KEY (`id_pregunta`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=latin1;

/*Data for the table `batallas_preguntas` */

insert  into `batallas_preguntas`(`id_pregunta`,`pregunta_tipo`,`pregunta`,`respuesta1`,`respuesta2`,`respuesta3`,`valida`,`activa`,`canal_pregunta`) values 
(2,'General','En las redes fijas de datos, ¿qué es la red de acceso?','Segmento de red que se extiende entre la central telefónica del operador y la vivienda del usuario','Segmento de red que se extiende entre la central telefónica del operador y el nodo de agregación de tráfico más cercano','Ninguna de las anteriores',1,1,'comercial'),
(3,'General','¿Cuáles son las tres principales tecnologías de acceso cableado fijo que existen actualmente en Vodafone?','Fibra (FTTH), 4G y WiFi','Fibra (FTTH), Cable (HFC) y 4G','Fibra (FTTH), Cable (HFC) y xDSL (ADSL/VDSL)',3,1,'comercial'),
(4,'General','La velocidad de navegación de los usuarios que tienen una conexión ADSL se puede ver afectada por los siguientes motivos:','Distancia entre la central y el domicilio del usuario e interferencias con conexiones de otros usuarios','Distancia entre la central y el domicilio del usuario, interferencias con conexiones de otros usuarios y estado del cableado','Interferencias con conexiones de otros usuarios y estado del cableado',2,1,'comercial'),
(5,'General','¿Con qué siglas se conoce la red de fibra óptica desplegada por Vodafone?','FTTB (Fiber To The Building)','FTTH (Fiber To The Home)','FTTC (Fiber To The Curve)',2,1,'gerente'),
(6,'General','Las redes de cable son redes híbridas compuestas por:','Fibra óptica y cable coaxial (HFC)','Par de cobre y cable coaxial','Fibra óptica y par de cobre ',1,1,'gerente'),
(7,'General','¿Qué datos de la dirección de un cliente se consideran necesarios para comprobar con certeza si está en ‘huella’ de cobertura de fibra?','Piso y puerta','Escalera, piso y puerta','No es necesario tanto nivel de detalle para comprobar la cobertura de fibra de un cliente',2,1,'comercial'),
(8,'General','De los 3 equipos que componen una instalación de fibra óptica, ¿cuál es el encargado de transformar la señal óptica en eléctrica?','Router','Roseta óptica','ONT',3,1,'comercial'),
(9,'General','¿Cuáles son las velocidades de los productos banda ancha comercializados por Vodafone?','hasta 20Mbps/1,5Mbps, 60Mbps/6Mbps, 120Mbps/12Mbps y 200Mbps/20Mbps','hasta 35Mbps/3,5Mbps, 60Mbps/12Mbps, 120Mbps/20Mbps y 200Mbps/20Mbps','hasta 35Mbps/3,5Mbps, 60Mbps/12Mbps, 120Mbps/12Mbps y 200Mbps/20Mbps',2,1,'comercial'),
(10,'General','Telefonía SIP integrada:','Permite al cliente usar un teléfono tradicional o dispositivo analógico conectado directamente al puerto ‘Phone’ del router','Permite al cliente usar un teléfono tradicional o dispositivo analógico conectado directamente al puerto ‘LAN’ del router','Ambas respuestas son correctas',1,1,'gerente'),
(11,'General','¿Qué numeración presenta un terminal de Oficina Vodafone IP cuando realiza una llamada saliente?','Número geográfico','Número geográfico o extensión asociada en función de si la llamada es off net u on net','Número móvil',2,1,'comercial'),
(12,'General','Los accesos banda ancha de Vodafone disponen de direcciones ip públicas:','No, solo ip privada.','No usa direcciones ip, solo MAC.','Sí, pueden llevar dinámicas y fijas.',3,1,'gerente'),
(13,'General','4G es la última generación en el estándar de comunicaciones móviles y las principales ventajas que aporta respecto a la anterior generación son:','Mayor velocidad de descarga y envío de datos y menor tiempo de latencia ','Mayor velocidad de envío de datos','Menor tiempo de latencia',1,1,'comercial'),
(14,'General','Vodafone ofrece a sus clientes el servicio de Voz 4G que permite recibir y realizar llamadas a través de una conexión de datos  4G. ¿Sabes con qué nombre se conoce este servicio?:','VoLTA','VoLTE','Voz HD',2,1,'gerente'),
(15,'General','Las tecnologías de banda ancha móvil como 3G y 4G proporcionan velocidades de conexión elevadas que sin embargo se pueden ver afectadas por los siguientes motivos:','Condiciones radioeléctricas del medio','Número de usuarios conectados de forma concurrente a la misma antena','Ambas respuestas son correctas',3,1,'gerente'),
(16,'General','¿Qué necesita un cliente para poder disfrutar de la tecnología 4G?','Estar en cobertura 4G','Estar en cobertura 4G, tener un terminal compatible con esta tecnología y disponer de una tarjeta U-SIM','Estar en cobertura 4G y tener un terminal compatible con esta tecnología',2,1,'comercial'),
(17,'General','Oficina 4G se trata de una solución de conectividad destinada especialmente para clientes que necesitan tener una ‘Oficina en movilidad’. ¿Con qué dispositivos es compatible?','Routers y MiFi','Routers y módems USB','Ninguna de las anteriores es correcta',1,1,'comercial'),
(18,'General','La solución de Centralita Vodafone en Red permite al usuario disfrutar de servicios y funcionalidades de una centralita convencional con la ventaja de que:','No es necesario realizar inversión en hardware','No es necesario realizar inversión en hardware ni mantenimiento','No es necesario realizar inversión en hardware pero si se cobrará una cuota mensual por el mantenimiento',2,1,'comercial'),
(19,'General','Otra de las ventajas de la solución de Centralita Vodafone en Red es la flexibilidad que ofrece al cliente que se traduce en:','Facilidad para crecer y decrecer en número de usuarios de forma sencilla','Despliegue de la solución rápido y sencillo','Ambas respuestas son correctas',3,1,'gerente'),
(20,'General','Centralita Vodafone en Red permite realizar una gestión de las funcionalidades de forma segura, flexible y sencilla desde Internet, pero, ¿quién se encargará de realizarla?','El cliente podrá realizar la gestión con un usuario y password que Vodafone le proporcionará','El cliente podrá realizar la gestión con un usuario y password que Vodafone le proporcionará o podrá delegar esta gestión directamente en Vodafone','Vodafone realizará esta gestión de forma exclusiva, es un riesgo dar acceso al cliente para realizar esta función.',2,1,'comercial'),
(21,'General','El nombre de la web desde donde se podrá realizar la gestión de las funcionalidades de la solución de Centralita Vodafone en Red es:','Gestor Red Empresas','Gestor Centralita Vodafone','Ninguna de las anteriores',1,1,'comercial'),
(22,'General','La funcionalidad de Operadora Oficina Vodafone permite:','Distribuir de forma inteligente las llamadas entrantes a los números de cabecera de la empresa desde una aplicación en el PC optimizada para ello','Distribuir de forma inteligente las llamadas entrantes a los números de cabecera de la empresa mediante un algoritmo de distribución establecido previamente','Ninguna de las anteriores',1,1,'gerente'),
(23,'General','El servicio Presentación de Número de Cabecera le ofrece la posibilidad de','Poder presentar varios números de cabecera que tengan asignados diferentes Grupos de distribución inteligente de llamadas de la empresa en llamadas a números de fuera de la empresa','Poder presentar un número único en las llamadas salientes en lugar de los números móviles de empleados o colaboradores dados de alta en el servicio.','Ambas respuestas son correctas',2,1,'comercial'),
(24,'General','El servicio de Fax Oficina Vodafone, proporciona capacidad para enviar y recibir faxes desde cualquier cuenta de correo electrónico asociada a este servicio. En el envío, el número fax de destino puede ser:','Un número fijo largo','Un número fijo largo o un número corto','Un número fijo largo o un número corto o un número móvil',3,1,'comercial'),
(25,'General','El servicio de Fax Oficina Vodafone proporciona capacidad para enviar y recibir faxes desde:','Cualquier cliente de correo con conexión a Internet','Cualquier cliente de correo sin necesidad de conexión a Internet','Una máquina de fax física situada en la empresa del cliente',1,1,'comercial'),
(26,'General','Comunicador Oficina Vodafone es una nueva generación de softphone que te permite asociar tu teléfono móvil al ordenador y elegir así desde qué dispositivo quieres gestionar tus llamadas, por lo tanto:','Es necesario que el teléfono móvil que va asociado se encuentre encendido para el correcto funcionamiento del servicio','Es necesario que el teléfono móvil que va asociado se encuentre encendido para el correcto funcionamiento del servicio y que éste se encuentre en zona de cobertura','Se podrá utilizar como dispositivo adicional al móvil independientemente de si éste se encuentra encendido y en zona de cobertura',3,1,'comercial'),
(27,'General','M2M es la abreviatura de la tecnología:','Machine to Machine','Marketing to Machine','Machine to Market',1,1,'comercial'),
(28,'General','Vodafone ofrece dos soluciones de gestión de flotas con M2M, Micronav y Locatel, ¿sabes cuáles son sus principales diferencias?','Micronav tiene un coste de instalación de 60€ y Locatel es autoinstalable. Además Micronav solamente se puede instalar en vehículos con puerto OBD2 y Locatel es apto para todo tipo de vehículos.','Locatel tiene un coste de instalación de 60€ y Micronav es autoinstalable. Además Micronav solamente se puede instalar en vehículos con puerto OBD2 y Locatel es apto para todo tipo de vehículos.','No existen diferencias entre ellos, son la misma solución pero de diferentes proveedores.',2,1,'comercial'),
(29,'General','M2M solo se puede ofrecer:','Sin VPN y con 24meses de permanencia.','Con VPN y con 24 meses de permanencia','Sin VPN y sin permanencia',1,1,'comercial'),
(30,'General','En las redes fijas de datos, ¿qué es la red de acceso?','Segmento de red que se extiende entre la central telefónica del operador y la vivienda del usuario','Segmento de red que se extiende entre la central telefónica del operador y el nodo de agregación de tráfico más cercano','Ninguna de las anteriores',1,1,'comercial'),
(31,'General','¿Cuáles son las tres principales tecnologías de acceso cableado fijo que existen actualmente en Vodafone?','Fibra (FTTH), 4G y WiFi','Fibra (FTTH), Cable (HFC) y 4G','c. Fibra (FTTH), Cable (HFC) y xDSL (ADSL/VDSL)',3,1,'comercial'),
(32,'General','La velocidad de navegación de los usuarios que tienen una conexión ADSL se puede ver afectada por los siguientes motivos:','Distancia entre la central y el domicilio del usuario e interferencias con conexiones de otros usuarios','Distancia entre la central y el domicilio del usuario, interferencias con conexiones de otros usuarios y estado del cableado','Interferencias con conexiones de otros usuarios y estado del cableado',2,1,'comercial'),
(33,'General','¿Con qué siglas se conoce la red de fibra óptica desplegada por Vodafone?','FTTB (Fiber To The Building)','FTTH (Fiber To The Home)','FTTC (Fiber To The Curve)',2,1,'comercial'),
(34,'General','Las redes de cable son redes híbridas compuestas por:','Fibra óptica y cable coaxial (HFC)','Par de cobre y cable coaxial','Fibra óptica y par de cobre ',1,1,'comercial'),
(35,'General','¿Qué datos de la dirección de un cliente se consideran necesarios para comprobar con certeza si está en ‘huella’ de cobertura de fibra?','Piso y puerta','Escalera, piso y puerta','No es necesario tanto nivel de detalle para comprobar la cobertura de fibra de un cliente',2,1,'comercial'),
(36,'General','De los 3 equipos que componen una instalación de fibra óptica, ¿cuál es el encargado de transformar la señal óptica en eléctrica?','Router','Roseta óptica','ONT',3,1,'comercial'),
(37,'General','¿Cuáles son las velocidades de los productos banda ancha comercializados por Vodafone?','hasta 20Mbps/1,5Mbps, 60Mbps/6Mbps, 120Mbps/12Mbps y 200Mbps/20Mbps','hasta 35Mbps/3,5Mbps, 60Mbps/12Mbps, 120Mbps/20Mbps y 200Mbps/20Mbps','hasta 35Mbps/3,5Mbps, 60Mbps/12Mbps, 120Mbps/12Mbps y 200Mbps/20Mbps',2,1,'comercial'),
(38,'General','Telefonía SIP integrada:','Permite al cliente usar un teléfono tradicional o dispositivo analógico conectado directamente al puerto ‘Phone’ del router','Permite al cliente usar un teléfono tradicional o dispositivo analógico conectado directamente al puerto ‘LAN’ del router','Ambas respuestas son correctas',1,1,'comercial'),
(39,'General','¿Qué numeración presenta un terminal de Oficina Vodafone IP cuando realiza una llamada saliente?','Número geográfico','Número geográfico o extensión asociada en función de si la llamada es off net u on net','Número móvil',2,1,'comercial'),
(40,'General','Los accesos banda ancha de Vodafone disponen de direcciones ip públicas:','No, solo ip privada.','No usa direcciones ip, solo MAC.','Sí, pueden llevar dinámicas y fijas.',3,1,'comercial'),
(41,'General','4G es la última generación en el estándar de comunicaciones móviles y las principales ventajas que aporta respecto a la anterior generación son:','Mayor velocidad de descarga y envío de datos y menor tiempo de latencia ','Mayor velocidad de envío de datos','Menor tiempo de latencia',1,1,'comercial'),
(42,'General','Vodafone ofrece a sus clientes el servicio de Voz 4G que permite recibir y realizar llamadas a través de una conexión de datos  4G. ¿Sabes con qué nombre se conoce este servicio?:','VoLTA','VoLTE','Voz HD',2,1,'comercial'),
(43,'General','Las tecnologías de banda ancha móvil como 3G y 4G proporcionan velocidades de conexión elevadas que sin embargo se pueden ver afectadas por los siguientes motivos:','Condiciones radioeléctricas del medio','Número de usuarios conectados de forma concurrente a la misma antena','Ambas respuestas son correctas',3,1,'comercial'),
(44,'General','¿Qué necesita un cliente para poder disfrutar de la tecnología 4G?','Estar en cobertura 4G','Estar en cobertura 4G, tener un terminal compatible con esta tecnología y disponer de una tarjeta U-SIM','Estar en cobertura 4G y tener un terminal compatible con esta tecnología',2,1,'comercial'),
(45,'General','Oficina 4G se trata de una solución de conectividad destinada especialmente para clientes que necesitan tener una ‘Oficina en movilidad’. ¿Con qué dispositivos es compatible?','Routers y MiFi','Routers y módems USB','Ninguna de las anteriores es correcta',1,1,'comercial'),
(46,'General','La solución de Centralita Vodafone en Red permite al usuario disfrutar de servicios y funcionalidades de una centralita convencional con la ventaja de que:','No es necesario realizar inversión en hardware','No es necesario realizar inversión en hardware ni mantenimiento','No es necesario realizar inversión en hardware pero si se cobrará una cuota mensual por el mantenimiento',2,1,'comercial'),
(47,'General','Otra de las ventajas de la solución de Centralita Vodafone en Red es la flexibilidad que ofrece al cliente que se traduce en:','Facilidad para crecer y decrecer en número de usuarios de forma sencilla','Despliegue de la solución rápido y sencillo','Ambas respuestas son correctas',3,1,'comercial'),
(48,'General','Centralita Vodafone en Red permite realizar una gestión de las funcionalidades de forma segura, flexible y sencilla desde Internet, pero, ¿quién se encargará de realizarla?','El cliente podrá realizar la gestión con un usuario y password que Vodafone le proporcionará','El cliente podrá realizar la gestión con un usuario y password que Vodafone le proporcionará o podrá delegar esta gestión directamente en Vodafone','Vodafone realizará esta gestión de forma exclusiva, es un riesgo dar acceso al cliente para realizar esta función.',2,1,'comercial'),
(49,'General','El nombre de la web desde donde se podrá realizar la gestión de las funcionalidades de la solución de Centralita Vodafone en Red es:','Gestor Red Empresas','Gestor Centralita Vodafone','Ninguna de las anteriores',1,1,'comercial'),
(50,'General','La funcionalidad de Operadora Oficina Vodafone permite:','Distribuir de forma inteligente las llamadas entrantes a los números de cabecera de la empresa desde una aplicación en el PC optimizada para ello','Distribuir de forma inteligente las llamadas entrantes a los números de cabecera de la empresa mediante un algoritmo de distribución establecido previamente','Ninguna de las anteriores',1,1,'comercial'),
(51,'General','El servicio Presentación de Número de Cabecera le ofrece la posibilidad de','Poder presentar varios números de cabecera que tengan asignados diferentes Grupos de distribución inteligente de llamadas de la empresa en llamadas a números de fuera de la empresa','Poder presentar un número único en las llamadas salientes en lugar de los números móviles de empleados o colaboradores dados de alta en el servicio.','Ambas respuestas son correctas',2,1,'comercial'),
(52,'General','El servicio de Fax Oficina Vodafone, proporciona capacidad para enviar y recibir faxes desde cualquier cuenta de correo electrónico asociada a este servicio. En el envío, el número fax de destino puede ser:','Un número fijo largo','Un número fijo largo o un número corto','Un número fijo largo o un número corto o un número móvil',3,1,'comercial'),
(53,'General','El servicio de Fax Oficina Vodafone proporciona capacidad para enviar y recibir faxes desde:','Cualquier cliente de correo con conexión a Internet','Cualquier cliente de correo sin necesidad de conexión a Internet','Una máquina de fax física situada en la empresa del cliente',1,1,'comercial'),
(54,'General','Comunicador Oficina Vodafone es una nueva generación de softphone que te permite asociar tu teléfono móvil al ordenador y elegir así desde qué dispositivo quieres gestionar tus llamadas, por lo tanto:','Es necesario que el teléfono móvil que va asociado se encuentre encendido para el correcto funcionamiento del servicio','Es necesario que el teléfono móvil que va asociado se encuentre encendido para el correcto funcionamiento del servicio y que éste se encuentre en zona de cobertura','Se podrá utilizar como dispositivo adicional al móvil independientemente de si éste se encuentra encendido y en zona de cobertura',3,1,'comercial'),
(55,'General','M2M es la abreviatura de la tecnología:','Machine to Machine','Marketing to Machine','Machine to Market',1,1,'comercial'),
(56,'General','Vodafone ofrece dos soluciones de gestión de flotas con M2M, Micronav y Locatel, ¿sabes cuáles son sus principales diferencias?','Micronav tiene un coste de instalación de 60€ y Locatel es autoinstalable. Además Micronav solamente se puede instalar en vehículos con puerto OBD2 y Locatel es apto para todo tipo de vehículos.','Locatel tiene un coste de instalación de 60€ y Micronav es autoinstalable. Además Micronav solamente se puede instalar en vehículos con puerto OBD2 y Locatel es apto para todo tipo de vehículos.','No existen diferencias entre ellos, son la misma solución pero de diferentes proveedores.',2,1,'comercial'),
(57,'General','M2M solo se puede ofrecer:','Sin VPN y con 24meses de permanencia.','Con VPN y con 24 meses de permanencia','Sin VPN y sin permanencia',1,1,'comercial'),
(58,'General','¿Qué significan las siglas ADSL?','Línea de abonado digital simétrica','Línea de abonado digital asimétrica','Línea digital de banda ancha',2,1,'comercial'),
(59,'General','La tecnología ADSL, es asimétrica. Esto se debe a que las velocidades de transmisión de datos en sentido red-usuario (velocidad de bajada) y usuario-red (velocidad de subida) son:','Distintas y la velocidad de bajada es inferior a la velocidad de subida','Prácticamente iguales',' Distintas y la velocidad de bajada es superior a la velocidad de subida',3,1,'comercial'),
(60,'General','¿Cuáles son los sistemas operativos móviles que mayor cuota de mercado tienen actualmente?','Android, iOS y Windows Phone','Android, iOS y Symbian','Android, iOS y Blackberry OS',1,1,'comercial'),
(61,'General','Google Apps for Work es un completo conjunto de aplicaciones, ¿sabes cuál es el nombre de la app que permite mantener reuniones en línea con voz y video integrados?','Lync','Hangouts','WhatsApp',2,1,'comercial'),
(62,'General','Además de Vodafone, ¿qué otros operadores en España tienen un acuerdo marco con Google para comercializar sus productos y servicios?','Movistar y Orange','Movistar, Orange y Jazztel','Solamente Vodafone puede vender actualmente los productos y servicios de Google',3,1,'comercial'),
(63,'General','Vodafone apuesta por la convergencia, pero, ¿sabes qué beneficios aporta a nuestros clientes de empresa?','Reducción de costes','Única factura y único punto de contacto para soporte','Ambas respuestas son correctas',3,1,'comercial'),
(64,'General','VSDM es una solución de seguridad que permite gestionar de forma sencilla los dispositivos de los empleados de una empresa. ¿Sabes cuál es el número máximo de dispositivos qué se pueden gestionar?','Ilimitados y se pueden asociar múltiples dispositivos a un mismo empleado','Ilimitados y únicamente se puede asociar un dispositivo por empleado','Ninguna de las respuestas anteriores es correcta',1,1,'comercial'),
(65,'General','VSDM permite gestionar dispositivos móviles con diferentes sistemas operativos, ¿es correcto?','No, solamente se pueden gestionar dispositivos Android','Sí, se pueden gestionar diferentes sistemas operativos, pero existen distintas funcionalidades disponibles para cada uno de ellos','Sí, se pueden gestionar diferentes sistemas operativos y las funcionalidades disponibles son las mismas para todos',2,1,'comercial'),
(66,'General','VSDM está basado en la solución MDM líder del mercado, ¿cuál es su nombre?','Mobile Iron','Symantec','AirWatch',3,1,'comercial'),
(67,'General','La solución de cobertura móvil en interior de edificios, Booster Nextivity, es capaz de mejorar la cobertura:','3G','4G','Ambas',1,1,'comercial'),
(68,'General','El Programa de Asociaciones para PYMES con oferta Red Empresas, solamente se podrá aplicar a Asociaciones con:','Más de 50 asociados','Más de 100 asociados','Más de 150 asociados',2,1,'comercial'),
(69,'General','NPS es un indicador que mide la lealtad de los clientes de una empresa. ¿Qué significan estas siglas?','Next Possible Service','Net Passive Score','Net Promoter Score',3,1,'comercial'),
(70,'General','El NPS se basa en una única pregunta cuya respuesta es una escala de 0 a 10. En base a esto se establecen 3 grupos: Promotores, Pasivos y Detractores. ¿Sabes cuál es la escala que corresponde a los Promotores?:','De 7 a 10','De 9 a 10','Solamente si se vota con un 10',2,1,'comercial'),
(71,'General','¿Qué es Vodafone Business Place?','Un portal de desarrollo de negocio','Un portal de aplicaciones para empresas','Un portal de configuración de ofertas',2,1,'comercial'),
(72,'General','El softphone Comunicador Oficina Vodafone está disponible para:','PC y Tablet','Solamente PC','Solamente Tablet',1,1,'comercial'),
(73,'General','Secure Net permite a los clientes navegar o descargar aplicaciones de manera segura cuando estén conectados a:','La red de datos móvil de Vodafone','Un acceso de datos de banda ancha fija','Ambas respuestas con correctas',1,1,'comercial'),
(74,'General','¿Es necesario instalar Secure Net en el dispositivo móvil para comenzar a disfrutar del servicio?','Sí, el cliente tendrá que descargarse y configurar manualmente la app Secure Net','Sí, el cliente tendrá que descargarse la app Secure Net y la configuración se realizará de forma automática','No, es un servicio desarrollado en la red de Vodafone, disponible de manera online y no es necesario instalar nada en el dispositivo',3,1,'comercial'),
(75,'General','¿Cuál es el nombre del organismo que garantiza la libre competencia y regula el mercado de las telecomunicaciones en España?','CMT','CNMC','CNT',2,1,'comercial'),
(76,'General','Vodafone España lidera el mercado 4G desde su lanzamiento en Mayo de 2013. Actualmente y con el objetivo de seguir liderando este mercado, ya ha comenzado el despliegue en la banda de 800 MHz. ¿Cuál es la principal ventaja que aporta esta banda?','Mejor cobertura en espacios interiores','Mayor velocidad de subida de datos','Tarifas de datos más económicas',1,1,'comercial'),
(77,'General','El servicio de Fax Oficina Vodafone permite el envío de documentos:','Solamente en formato texto','En múltiples formatos (Word, Excel, PDF, jpg…)','Solamente en formato imagen',2,1,'comercial');

/*Table structure for table `batallas_respuestas` */

DROP TABLE IF EXISTS `batallas_respuestas`;

CREATE TABLE `batallas_respuestas` (
  `id_respuesta` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_batalla` int(11) NOT NULL DEFAULT '0',
  `username_batalla` varchar(100) NOT NULL DEFAULT '',
  `batalla_pregunta` int(11) NOT NULL,
  `batalla_respuesta` longtext NOT NULL,
  PRIMARY KEY (`id_respuesta`),
  KEY `id_batalla` (`id_batalla`),
  KEY `username_batalla` (`username_batalla`),
  KEY `batalla_pregunta` (`batalla_pregunta`)
) ENGINE=MyISAM AUTO_INCREMENT=4465 DEFAULT CHARSET=latin1;

/*Data for the table `batallas_respuestas` */

insert  into `batallas_respuestas`(`id_respuesta`,`id_batalla`,`username_batalla`,`batalla_pregunta`,`batalla_respuesta`) values 
(4381,731,'admin',50,'1'),
(4382,731,'david',50,''),
(4383,731,'admin',65,'2'),
(4384,731,'david',65,''),
(4385,731,'admin',34,'2'),
(4386,731,'david',34,''),
(4387,732,'admin',14,'2'),
(4388,732,'senen',14,'2'),
(4389,732,'admin',17,'3'),
(4390,732,'senen',17,'2'),
(4391,732,'admin',27,'1'),
(4392,732,'senen',27,'2'),
(4393,733,'admin',20,'2'),
(4394,733,'david',20,''),
(4395,733,'admin',25,'2'),
(4396,733,'david',25,''),
(4397,733,'admin',10,'2'),
(4398,733,'david',10,''),
(4399,734,'senen',77,'1'),
(4400,734,'david',77,'3'),
(4401,734,'senen',65,'3'),
(4402,734,'david',65,'2'),
(4403,734,'senen',55,'3'),
(4404,734,'david',55,'1'),
(4405,735,'admin',49,'3'),
(4406,735,'pedro',49,''),
(4407,735,'admin',27,'1'),
(4408,735,'pedro',27,''),
(4409,735,'admin',70,'3'),
(4410,735,'pedro',70,''),
(4411,736,'admin',44,'1'),
(4412,736,'borja',44,'2'),
(4413,736,'admin',75,'2'),
(4414,736,'borja',75,'2'),
(4415,736,'admin',37,'1'),
(4416,736,'borja',37,'3'),
(4417,737,'borja',28,'3'),
(4418,737,'dcancho',28,''),
(4419,737,'borja',7,'2'),
(4420,737,'dcancho',7,''),
(4421,737,'borja',21,'3'),
(4422,737,'dcancho',21,''),
(4423,738,'admin',55,''),
(4424,738,'david',55,''),
(4425,738,'admin',2,''),
(4426,738,'david',2,''),
(4427,738,'admin',40,''),
(4428,738,'david',40,''),
(4429,739,'admin',55,'2'),
(4430,739,'david',55,''),
(4431,739,'admin',2,'2'),
(4432,739,'david',2,''),
(4433,739,'admin',40,'2'),
(4434,739,'david',40,''),
(4435,740,'admin',70,'2'),
(4436,740,'Redbull',70,''),
(4437,740,'admin',13,'1'),
(4438,740,'Redbull',13,''),
(4439,740,'admin',36,'2'),
(4440,740,'Redbull',36,''),
(4441,741,'admin',49,'1'),
(4442,741,'david',49,''),
(4443,741,'admin',18,'2'),
(4444,741,'david',18,''),
(4445,741,'admin',66,'3'),
(4446,741,'david',66,''),
(4447,742,'admin',9,'3'),
(4448,742,'odelgado',9,''),
(4449,742,'admin',44,'2'),
(4450,742,'odelgado',44,''),
(4451,742,'admin',49,'2'),
(4452,742,'odelgado',49,''),
(4453,746,'admin',12,''),
(4454,746,'claudio',12,''),
(4455,746,'admin',14,''),
(4456,746,'claudio',14,''),
(4457,746,'admin',10,''),
(4458,746,'claudio',10,''),
(4459,747,'admin',63,'2'),
(4460,747,'Redbull',63,''),
(4461,747,'admin',50,'2'),
(4462,747,'Redbull',50,''),
(4463,747,'admin',56,'1'),
(4464,747,'Redbull',56,'');

/*Table structure for table `blog_alerts` */

DROP TABLE IF EXISTS `blog_alerts`;

CREATE TABLE `blog_alerts` (
  `id_tema` int(11) NOT NULL DEFAULT '0',
  `username_alert` varchar(100) NOT NULL DEFAULT '',
  `date_alert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_tema`,`username_alert`),
  KEY `id_tema` (`id_tema`),
  KEY `username_alert` (`username_alert`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `blog_alerts` */

insert  into `blog_alerts`(`id_tema`,`username_alert`,`date_alert`) values 
(50,'admin','2015-03-13 18:57:36'),
(51,'admin','2015-03-13 18:57:36'),
(52,'admin','2015-03-13 18:57:36'),
(53,'admin','2015-03-13 18:57:36'),
(54,'admin','2015-03-13 18:57:36'),
(59,'admin','2015-03-13 18:57:36'),
(61,'admin','2015-03-13 18:57:36'),
(60,'admin','2015-03-13 18:57:36'),
(68,'admin','2015-03-13 18:57:36'),
(69,'admin','2015-03-13 18:57:36'),
(50,'claudio','2015-03-18 10:46:03'),
(51,'claudio','2015-03-18 10:46:03'),
(52,'claudio','2015-03-18 10:46:03'),
(53,'claudio','2015-03-18 10:46:03'),
(54,'claudio','2015-03-18 10:46:03'),
(59,'claudio','2015-03-18 10:46:03'),
(61,'claudio','2015-03-18 10:46:03'),
(60,'claudio','2015-03-18 10:46:03'),
(68,'claudio','2015-03-18 10:46:03'),
(69,'claudio','2015-03-18 10:46:03'),
(50,'pedro','2015-08-14 10:46:21'),
(51,'pedro','2015-08-14 10:46:21'),
(52,'pedro','2015-08-14 10:46:21'),
(53,'pedro','2015-08-14 10:46:21'),
(54,'pedro','2015-08-14 10:46:21'),
(59,'pedro','2015-08-14 10:46:21'),
(61,'pedro','2015-08-14 10:46:21'),
(60,'pedro','2015-08-14 10:46:21'),
(68,'pedro','2015-08-14 10:46:21'),
(69,'pedro','2015-08-14 10:46:21'),
(50,'senen','2015-10-27 13:18:04'),
(51,'senen','2015-10-27 13:18:04'),
(52,'senen','2015-10-27 13:18:04'),
(53,'senen','2015-10-27 13:18:04'),
(54,'senen','2015-10-27 13:18:04'),
(59,'senen','2015-10-27 13:18:04'),
(61,'senen','2015-10-27 13:18:04'),
(60,'senen','2015-10-27 13:18:04'),
(68,'senen','2015-10-27 13:18:04'),
(69,'senen','2015-10-27 13:18:04'),
(50,'borja','2016-04-28 09:27:52'),
(51,'borja','2016-04-28 09:27:52'),
(52,'borja','2016-04-28 09:27:52'),
(53,'borja','2016-04-28 09:27:52'),
(54,'borja','2016-04-28 09:27:52'),
(59,'borja','2016-04-28 09:27:52'),
(61,'borja','2016-04-28 09:27:52'),
(60,'borja','2016-04-28 09:27:52'),
(68,'borja','2016-04-28 09:27:52'),
(69,'borja','2016-04-28 09:27:52'),
(50,'jgonzalez','2016-10-14 09:42:31'),
(51,'jgonzalez','2016-10-14 09:42:31'),
(52,'jgonzalez','2016-10-14 09:42:31'),
(53,'jgonzalez','2016-10-14 09:42:31'),
(54,'jgonzalez','2016-10-14 09:42:31'),
(59,'jgonzalez','2016-10-14 09:42:31'),
(61,'jgonzalez','2016-10-14 09:42:31'),
(60,'jgonzalez','2016-10-14 09:42:31'),
(68,'jgonzalez','2016-10-14 09:42:31'),
(69,'jgonzalez','2016-10-14 09:42:31'),
(50,'dramos','2016-10-14 09:49:35'),
(51,'dramos','2016-10-14 09:49:35'),
(52,'dramos','2016-10-14 09:49:35'),
(53,'dramos','2016-10-14 09:49:35'),
(54,'dramos','2016-10-14 09:49:35'),
(59,'dramos','2016-10-14 09:49:35'),
(61,'dramos','2016-10-14 09:49:35'),
(60,'dramos','2016-10-14 09:49:35'),
(68,'dramos','2016-10-14 09:49:35'),
(69,'dramos','2016-10-14 09:49:35');

/*Table structure for table `campaigns` */

DROP TABLE IF EXISTS `campaigns`;

CREATE TABLE `campaigns` (
  `id_campaign` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name_campaign` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `desc_campaign` text CHARACTER SET latin1 NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `imagen_mini` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `imagen_big` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `id_campaign_type` int(11) NOT NULL DEFAULT '0',
  `novedad` tinyint(1) NOT NULL DEFAULT '0',
  `canal_campaign` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_campaign`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `campaigns` */

insert  into `campaigns`(`id_campaign`,`name_campaign`,`desc_campaign`,`active`,`imagen_mini`,`imagen_big`,`id_campaign_type`,`novedad`,`canal_campaign`) values 
(1,'Gafas de sol - verano 2014','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam vitae turpis augue. Nam in sem quis quam malesuada condimentum. Nullam imperdiet nulla sapien, id consectetur lorem rhoncus eu. Duis eget risus sit amet augue facilisis volutpat. Integer pretium ultricies odio vitae ultricies.',1,'1399909815_5.aprendo_q.jpg','',2,1,'comercial,gerente'),
(2,'Monturas colección 2014','In in sem a ipsum ultricies semper rutrum ut est. Sed nec enim mattis, dictum turpis in, cursus ipsum. Donec fermentum mollis risus, vel congue sem semper eu. Vivamus accumsan auctor rutrum. Morbi a congue diam.',1,'1399989568_5.aprendo_q.jpg','',2,0,'comercial,gerente'),
(3,'Otras campañas','In semper sapien ac metus euismod, ut mollis elit ultrices. Nulla commodo tellus sit amet interdum rutrum. Pellentesque eget erat metus. Nam eget erat sit amet nisi pulvinar pharetra. Proin id est ultricies, facilisis ipsum id, dignissim purus. ',1,'1399989624_3.ranking.jpg','',3,0,'comercial'),
(4,'Nueva campaña','sf sdfsdfsdf sdf',0,'','',2,0,''),
(5,'Campaña nueva','En un lugar de la Mancha, de cuyo nombre no quiero acordarme, no ha mucho tiempo que vivía un hidalgo de los de lanza en astillero, adarga antigua, rocín flaco y galgo corredor. Una olla de algo más vaca que carnero, salpicón las más noches, duelos y quebrantos los sábados, lantejas los viernes, algún palomino de añadidura los domingos, consumían las tres partes de su hacienda.',0,'1399907395_8.oveja_ovejao.jpg','1399907353_1.home.jpg',2,1,''),
(6,'sdfsdfsdf','dfs',0,'','',3,1,''),
(7,'Reparación de lentes','Con estas razones perdía el pobre caballero el juicio, y desvelábase por entenderlas y desentrañarles el sentido, que no se lo sacara ni las entendiera el mesmo Aristóteles, si resucitara para sólo ello. ',1,'1399989816_8.oveja_ovejao.jpg','',1,0,'gerente'),
(8,'test canales','Una campaña para varios canales',1,'','',1,0,'comercial,gerente');

/*Table structure for table `campaigns_types` */

DROP TABLE IF EXISTS `campaigns_types`;

CREATE TABLE `campaigns_types` (
  `id_campaign_type` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `campaign_type_name` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `campaign_type_desc` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id_campaign_type`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `campaigns_types` */

insert  into `campaigns_types`(`id_campaign_type`,`campaign_type_name`,`campaign_type_desc`) values 
(1,'Servicios','En un lugar de la Mancha, de cuyo nombre no quiero acordarme, no ha mucho tiempo que vivía un hidalgo de los de lanza en astillero, adarga antigua, rocín flaco y galgo corredor'),
(2,'Productos','Una olla de algo más vaca que carnero, salpicón las más noches, duelos y quebrantos los sábados, lantejas los viernes, algún palomino de añadidura los domingos, consumían las tres partes de su hacienda. El resto della concluían sayo de velarte, calzas de velludo para las fiestas, con sus pantuflos de lo mesmo, y los días de entresemana se honraba con su vellorí de lo más fino. '),
(3,'Otro tipo','Es, pues, de saber que este sobredicho hidalgo, los ratos que estaba ocioso, que eran los más del año, se daba a leer libros de caballerías, con tanta afición y gusto, que olvidó casi de todo punto el ejercicio de la caza, y aun la administración de su hacienda. ');

/*Table structure for table `canales` */

DROP TABLE IF EXISTS `canales`;

CREATE TABLE `canales` (
  `canal` varchar(100) CHARACTER SET latin1 NOT NULL,
  `canal_name` longtext CHARACTER SET latin1 NOT NULL,
  `canal_lan` varchar(5) NOT NULL DEFAULT 'es',
  `theme` varchar(100) NOT NULL DEFAULT 'default',
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`canal`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `canales` */

insert  into `canales`(`canal`,`canal_name`,`canal_lan`,`theme`,`visible`) values 
('admin','Canal administradores','es','default',0),
('comercial','Canal comercial','es','blue',1),
('gerente','Canal gerentes','en','green',1),
('test','Canal de prueba','gl','default',1);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `config` */

insert  into `config`(`telefono`,`telefono2`,`fax`,`direccion`,`ContactEmail`,`SiteName`,`SiteTitle`,`SiteDesc`,`SiteSubject`,`SiteKeywords`,`SiteUrl`,`MailingEmail`) values 
('+34','+34 2','+34 3','C/','dnoguera@imagar.com','Community-Php','Community-Php','Comunidad de usuarios Community-Php','Community-Php','Community-Php','https://comunidad.local.com','dnoguera2@imagar.com');

/*Table structure for table `config_panels` */

DROP TABLE IF EXISTS `config_panels`;

CREATE TABLE `config_panels` (
  `page_name` varchar(100) NOT NULL,
  `panel_name` varchar(100) NOT NULL,
  `panel_cols` int(2) NOT NULL DEFAULT '6',
  `panel_row` int(1) DEFAULT '1',
  `panel_pos` int(2) NOT NULL DEFAULT '1',
  `panel_visible` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`page_name`,`panel_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `config_panels` */

insert  into `config_panels`(`page_name`,`panel_name`,`panel_cols`,`panel_row`,`panel_pos`,`panel_visible`) values 
('home','panelUser',3,1,8,1),
('home','panelForos',3,1,2,1),
('home','panelMuro',3,1,1,1),
('home','panelNovedades',5,1,2,0),
('home','panelBlog',3,1,3,1),
('home','panelAlerts',6,2,9,0),
('home','panelFotos',3,1,4,1),
('home','panelVideos',3,1,5,1),
('home','panelDestacado',3,1,6,1),
('home','panelAreas',3,2,7,0),
('home','panelConnected',3,1,7,1),
('home','panelBlog2',4,3,10,0);

/*Table structure for table `cuestionarios` */

DROP TABLE IF EXISTS `cuestionarios`;

CREATE TABLE `cuestionarios` (
  `id_cuestionario` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `descripcion` longtext CHARACTER SET latin1,
  `date_tarea` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activo` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '0 inactivo; 1 activo; 2 eliminado',
  PRIMARY KEY (`id_cuestionario`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

/*Data for the table `cuestionarios` */

insert  into `cuestionarios`(`id_cuestionario`,`nombre`,`descripcion`,`date_tarea`,`activo`) values 
(12,'Primer cuestionario','La descripci&oacute;n del primer cuestionario ampliado2','2014-10-13 13:56:44',1),
(13,'Segundo cuestionario','<p>\r\n	Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula.</p>\r\n<p>\r\n	Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec ullamcorper nulla non metus auctor fringilla. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec ullamcorper nulla non metus auctor fringilla.</p>\r\n','2014-10-13 17:54:36',1),
(14,'prueba','jdskbslkd fsdjkfhsdjkfhsdjhfsdljfh sdmnf&nbsp;','2014-11-07 11:00:31',0),
(15,'Primer cuestionario - Clon','La descripci&oacute;n del primer cuestionario ampliado2','2014-11-07 11:38:29',2),
(16,'Primer cuestionario - Clon','La descripci&oacute;n del primer cuestionario ampliado2','2016-05-09 12:37:03',1),
(17,'Cuestionario autocorregible','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc a volutpat neque, non aliquet velit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec luctus velit vitae porttitor egestas. Etiam et leo interdum, viverra metus eu, pellentesque ligula. Nullam rhoncus iaculis neque, eu sollicitudin augue venenatis sed. Nulla facilisi. Aliquam erat volutpat. Phasellus vel justo ut diam eleifend fermentum. Vivamus odio justo, luctus eu erat ut, venenatis interdum massa. Integer id malesuada libero. Integer purus eros, dapibus non accumsan at, mollis vitae elit. Vivamus eu aliquet est, id vestibulum nibh. Cras gravida justo id enim imperdiet auctor. Maecenas hendrerit in turpis ac congue. Nunc nibh lorem, hendrerit pulvinar urna vitae, rhoncus malesuada tellus.</p>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer sit amet mauris ultrices, malesuada sapien sed, auctor felis. Maecenas ornare nibh ante, quis pharetra est ullamcorper non. Integer nulla urna, venenatis vel arcu sed, rutrum condimentum leo. Praesent feugiat metus ut sodales vehicula. Maecenas cursus eu purus eget vestibulum. Quisque finibus in erat quis pellentesque. Etiam at quam risus. Aenean consectetur tortor sapien, sit amet auctor risus dapibus at. Ut imperdiet nibh arcu, non eleifend arcu imperdiet nec. Donec gravida dignissim ipsum, sit amet feugiat massa tincidunt sit amet. Aenean semper turpis justo, quis cursus lorem sollicitudin nec. Phasellus hendrerit ipsum est, eu ultrices massa interdum ut. Donec justo lacus, molestie ac mollis in, dignissim at elit.</p>\r\n','2016-12-21 16:36:10',1);

/*Table structure for table `cuestionarios_finalizados` */

DROP TABLE IF EXISTS `cuestionarios_finalizados`;

CREATE TABLE `cuestionarios_finalizados` (
  `id_cuestionario` int(11) NOT NULL,
  `user_tarea` varchar(100) NOT NULL,
  `date_finalizacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `revision` tinyint(1) NOT NULL DEFAULT '0',
  `puntos` int(3) NOT NULL DEFAULT '0',
  `user_revision` varchar(100) NOT NULL DEFAULT '',
  `date_revision` datetime DEFAULT NULL,
  PRIMARY KEY (`id_cuestionario`,`user_tarea`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `cuestionarios_finalizados` */

insert  into `cuestionarios_finalizados`(`id_cuestionario`,`user_tarea`,`date_finalizacion`,`revision`,`puntos`,`user_revision`,`date_revision`) values 
(13,'admin','2014-10-13 18:03:10',0,0,'',NULL),
(17,'admin','2016-12-21 17:17:55',1,6,'admin','2016-12-21 17:17:55'),
(17,'borja','2016-12-21 17:19:53',1,10,'admin','2016-12-21 17:19:53');

/*Table structure for table `cuestionarios_preguntas` */

DROP TABLE IF EXISTS `cuestionarios_preguntas`;

CREATE TABLE `cuestionarios_preguntas` (
  `id_pregunta` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_cuestionario` int(11) unsigned NOT NULL DEFAULT '0',
  `pregunta_texto` longtext NOT NULL,
  `pregunta_tipo` varchar(100) NOT NULL DEFAULT 'texto' COMMENT 'texto;unica;multiple',
  PRIMARY KEY (`id_pregunta`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

/*Data for the table `cuestionarios_preguntas` */

insert  into `cuestionarios_preguntas`(`id_pregunta`,`id_cuestionario`,`pregunta_texto`,`pregunta_tipo`) values 
(37,12,'Color favorito','unica'),
(38,12,'¿Que comida te gusta?','multiple'),
(39,12,'Sexo','unica'),
(40,13,'¿Desayunas por la mañanas?','unica'),
(41,13,'¿Que haces espues de comer?','multiple'),
(42,15,'Color favorito','unica'),
(43,15,'¿Que comida te gusta?','multiple'),
(44,15,'Sexo','unica'),
(45,16,'Color favorito','unica'),
(46,16,'¿Que comida te gusta?','multiple'),
(47,16,'Sexo','unica'),
(48,17,'Pregunta de resp unica','unica'),
(49,17,'Pregunta multiple','multiple'),
(50,17,'Otra única','unica');

/*Table structure for table `cuestionarios_respuestas` */

DROP TABLE IF EXISTS `cuestionarios_respuestas`;

CREATE TABLE `cuestionarios_respuestas` (
  `id_respuesta` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_pregunta` int(11) unsigned NOT NULL DEFAULT '0',
  `respuesta_texto` longtext NOT NULL,
  `correcta` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_respuesta`)
) ENGINE=MyISAM AUTO_INCREMENT=163 DEFAULT CHARSET=utf8;

/*Data for the table `cuestionarios_respuestas` */

insert  into `cuestionarios_respuestas`(`id_respuesta`,`id_pregunta`,`respuesta_texto`,`correcta`) values 
(142,40,'Sí',0),
(143,40,'No',0),
(144,41,'Echar una siesta',0),
(145,41,'Tomar un café',0),
(146,41,'Fumar un cigarro',0),
(147,42,'azul',0),
(148,42,'rojo',0),
(149,42,'amarillo',0),
(150,43,'Carne',0),
(151,43,'Pescado',0),
(152,43,'Verdura',0),
(153,44,'Hombre',0),
(154,44,'Mujer',0),
(155,48,'OPT1 ok',1),
(156,48,'OPT2',0),
(157,49,'OPT1 ok',1),
(158,49,'OPT2',0),
(159,49,'OPT3 ok',1),
(160,50,'OPT1',0),
(161,50,'OPT2 ok',1),
(162,50,'OPT3',0);

/*Table structure for table `cuestionarios_respuestas_user` */

DROP TABLE IF EXISTS `cuestionarios_respuestas_user`;

CREATE TABLE `cuestionarios_respuestas_user` (
  `id_respuesta_user` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_pregunta` int(11) unsigned NOT NULL DEFAULT '0',
  `respuesta_user` varchar(100) NOT NULL DEFAULT '',
  `respuesta_valor` longtext NOT NULL,
  PRIMARY KEY (`id_respuesta_user`)
) ENGINE=MyISAM AUTO_INCREMENT=4810 DEFAULT CHARSET=utf8;

/*Data for the table `cuestionarios_respuestas_user` */

insert  into `cuestionarios_respuestas_user`(`id_respuesta_user`,`id_pregunta`,`respuesta_user`,`respuesta_valor`) values 
(4796,37,'admin','azul'),
(4797,38,'admin','Carne|Pescado'),
(4798,39,'admin','Hombre'),
(4799,40,'admin','No'),
(4800,41,'admin','Tomar un café|Fumar un cigarro'),
(4801,37,'david','azul'),
(4802,38,'david','Carne|Pescado|Verdura'),
(4803,39,'david','Mujer'),
(4804,48,'admin','OPT1 ok'),
(4805,49,'admin','OPT1 ok|OPT3 ok'),
(4806,50,'admin','OPT1'),
(4807,48,'borja','OPT1 ok'),
(4808,49,'borja','OPT1 ok|OPT3 ok'),
(4809,50,'borja','OPT2 ok');

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `destacados` */

insert  into `destacados`(`id_destacado`,`destacado_fecha`,`destacado_tipo`,`destacado_id_file`,`destacado_texto`,`activo`,`canal_destacado`) values 
(1,'2014-10-20 13:26:39','foto',56,'Una de las mejores fotos de la comunidad. Disfrutarla!!!',0,'comercial'),
(2,'2015-10-26 16:43:49','video',4,'Un gran vídeo apto para todos los públicos',0,'comercial'),
(3,'2015-10-26 16:45:08','foto',46,'You asked, Font Awesome delivers with 66 shiny new icons in version ',0,'comercial'),
(4,'2015-10-26 16:45:42','video',2,'You asked, Font Awesome delivers with 66 shiny new icons in version ',0,'comercial'),
(5,'2016-03-17 10:33:55','video',6,'You asked, Font Awesome delivers with 66 shiny new icons in version ',0,'comercial'),
(6,'2016-03-10 16:44:34','foto',37,'Un gran plato para rematar',1,'gerente'),
(7,'2016-03-17 10:33:55','foto',63,'me encanta la foto',1,'comercial');

/*Table structure for table `emociones` */

DROP TABLE IF EXISTS `emociones`;

CREATE TABLE `emociones` (
  `id_emocion` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name_emocion` varchar(100) NOT NULL DEFAULT '',
  `desc_emocion` text,
  `active` int(1) NOT NULL DEFAULT '1',
  `image_emocion` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_emocion`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `emociones` */

insert  into `emociones`(`id_emocion`,`name_emocion`,`desc_emocion`,`active`,`image_emocion`) values 
(1,'entusiasmad@','Hoy estoy contento',1,'1409224579_cara1.png'),
(2,'nervios@','Hoy estoy enfadado',1,'1409224850_cara2.png'),
(3,'triste',NULL,1,'1409224678_cara3.png'),
(4,'enfadad@',NULL,1,'1409224920_cara4.png'),
(5,'alegre',NULL,1,'1409224972_cara5.png'),
(6,'angustiad@',NULL,1,'1412262680_cara10.png'),
(7,'euforic@',NULL,1,'1409225072_cara7.png'),
(8,'desganad@',NULL,1,'1409225108_cara8.png'),
(9,'enfurecid@',NULL,1,'1412262740_cara11.png');

/*Table structure for table `emociones_consejos` */

DROP TABLE IF EXISTS `emociones_consejos`;

CREATE TABLE `emociones_consejos` (
  `id_consejo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_emocion` int(11) unsigned NOT NULL DEFAULT '0',
  `emocion_consejo` text NOT NULL,
  PRIMARY KEY (`id_consejo`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

/*Data for the table `emociones_consejos` */

insert  into `emociones_consejos`(`id_consejo`,`id_emocion`,`emocion_consejo`) values 
(1,2,'Cuando estamos nerviosos suele ser porque desconocemos el resultado de lo que se nos viene encima. Puede ser positivo o negativo. Un truco muy bueno es visualizarte teniendo éxito en eso que te hace estar nervios@.'),
(2,2,'Como viste en el Taller, el estado nervioso altera tu respiración, tu ritmo cardíaco, tu temperatura corporal…y eso hace que tu cabeza no pueda responder con la claridad necesaria. El respirar con el diafragma o el abdomen durante un minuto, te ayudará a conseguir la calma y claridad necesarias. '),
(3,2,'En la mayoría de ocasiones en las que estamos nervios@s tenemos sensaciones propias del miedo: ¿sientes frío en las extremidades? ¿calor y mariposas en el estómago?¿te dan ganas de desaparecer? Si tus nervios te hacen sentir así, actúa para transformar tu estado: respira con el diafragma, visualízate en alguna situación en la que te sientes bien y háblate de forma positiva. De todos modos, en muchas ocasiones, los nervios nos ponen en alerta y nos hacen actuar mejor.'),
(4,3,'La tristeza nos apaga, provoca que dejemos de hacer cosas y hace que entremos en un bucle de difícil salida. Así que, como viste en el curso ¡Muévete! Como primer paso para salir de ese estado.'),
(5,3,'La tristeza se alimenta de los pensamientos. Está bien sentirse triste porque la mayor parte de las veces hay una causa, pero no es saludable anclarse en esos pensamientos. Para ello, una buena solución es pensar en cosas que te hagan sentir bien (amig@s, compañer@s, familia, lugares...) y, sobre todo, buscar compañía (de la buena).'),
(6,3,'Para salir de un estado de tristeza tenemos que \"reactivarnos\" ¿Cómo? Depende de lo que te guste: andar, hacer ejercicio, charlar con los amigos, bailar !sal¡ Verás como poco a poco tu cabeza y tu cuerpo estarán mejor.'),
(7,5,'¡Felicidades! ¡Disfruta el momento!'),
(8,5,'Aprovecha para contagiar tu estado a las personas que tienes alrededor.'),
(9,5,'Guarda este estado en tu memoria para utilizarlo como medicina en aquellos momentos en que lo necesites.'),
(10,1,'¡Contagialo! Sácalo a relucir, seguro que puedes ayudar a alguien.'),
(11,1,'Es un gran momento para hacer pequeñas cosas que tienes pendientes, ¿a qué esperas para empezar?'),
(12,1,'Cuenta por qué estás así a la gente de tu alrededor. Te servirá para reforzar tu estado y además harás sentir bien a quien se lo transmitas.'),
(13,4,'Cuando estamos enfadados, nuestro cuerpo se activa muy rápido y provoca reacciones que nos pueden pasar factura: tensión muscular, respiración acelerada, calor... Si actuamos a tiempo, evitaremos las consecuencias finales de este estado, que no son otras que la agresión, el desgaste y la sensación de \"estar hecho polvo\". Para actuar, te será muy útil respirar con el diafragma durante unos segundos.'),
(14,4,'Si la causa de tu enfado está delante de ti y estás a punto de hacer o decir algo de lo que te vas a arrepentir, el mejor consejo es eliminar ese estímulo de tu campo de visión y acción. Por tanto, ¡huye o bien cierra los ojos y cuenta hasta 10!'),
(15,4,'El enfado, si no se gestiona a tiempo, acaba en tristeza y en desgana o cansancio. Si te sientes triste o cansado, reflexiona cuál ha sido la causa inicial y, para la próxima, trata de gestionarlo cuanto antes.'),
(16,6,'La angustia nos provoca una sensación de \"me falta el aire\". El cuerpo es sabio y una de las mejores acciones que podemos llevar a cabo para salir de este estado es darle aire al cuerpo de una forma controlada. Respira unos minutos con el diafragma y verás las cosas de otro modo. '),
(17,6,'Cuando estamos angustiados buscamos huir. En este caso, haz todo lo contrario: afronta la situación, teniendo en cuenta las consecuencias que va a haber y acéptalas. Visualizarte afrontando la situación te ayudará cuando lo hagas en la realidad.'),
(18,6,'¿Qué tal darle a la angustia un antídoto? La risa y el buen humor te ayudan a contrarrestar las sensaciones derivadas de ese estado. Como viste en el Taller puede ser tan sencillo como decir tu nombre sin vocales cuando te presentes a alguien.'),
(19,9,'Si estás a punto de \"cargarte\" a alguien, un buen truco es aguantar la respiración hasta que no puedas más. Notarás como el cerebro se preocupará únicamente de hacer que respires y conseguirás relativizar todo lo demás.'),
(20,9,'Cuando estás en este estado, es importante \"sacar\" las causas. Cuéntaselo a alguien que te escuche. Pero antes, baja de revoluciones con un poco de respiración diafragmática.'),
(21,9,'Si llevas mucho tiempo así, haz algo para calmar tu cuerpo y mente. Un buen truco es hacer algo que te agote (ejercicio físico, por ejemplo). Notarás como tu cuerpo y tu mente se desactivarán, pudiendo ver las cosas con una perspectiva diferente.'),
(22,8,'La desgana es un estado peligroso, ya que es la llave de entrada a otros estados como la tristeza o el enfado. Si te encuentras así, es necesario \"despertar\" de nuevo, activarte. Por ejemplo, haciendo o priorizando alguna actividad que te guste.'),
(23,8,'La desgana se relaciona con el cansancio, físico o mental.  Cuando es físico, puedes ayudar a tu cuerpo mediante alimentación y descanso o desconexión. Cuando es mental, podemos cambiar a una tarea que nos motive o nos distraiga y, por tanto, nos ayude a cambiar al paso.'),
(24,8,'Cuando estamos desganados, baja nuestra actividad y nuestro rendimiento. Prueba a \"reactivarte\" utilizando cosas que te motiven (música que te active, pensar en momentos positivos, relacionarte con gente activa, que te contagie…)'),
(25,7,'¡Enhorabuena!¡Disfruta el momento!'),
(26,7,'¡Estás de suerte! ¡Eres un privilegiado porque estás mejor que el 95% de las personas en este momento!. Analiza por qué estás así y guárdalo en tu caja de los recuerdos para los momentos en que necesites motivación.'),
(27,7,'¡ lo mereces! Aun así, cuidado, porque este estado te puede llevar a tomar decisiones equivocadas.');

/*Table structure for table `emociones_user` */

DROP TABLE IF EXISTS `emociones_user`;

CREATE TABLE `emociones_user` (
  `id_emocion_user` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_emocion` int(11) unsigned NOT NULL DEFAULT '0',
  `user_emocion` varchar(100) NOT NULL DEFAULT '',
  `date_emocion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `desc_emocion_user` text NOT NULL,
  PRIMARY KEY (`id_emocion_user`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=latin1;

/*Data for the table `emociones_user` */

insert  into `emociones_user`(`id_emocion_user`,`id_emocion`,`user_emocion`,`date_emocion`,`desc_emocion_user`) values 
(1,1,'admin','2014-08-22 12:53:26','Lorem ipsum'),
(2,2,'admin','2014-08-22 14:06:52','sss'),
(3,2,'david','2014-08-22 14:06:52','sss'),
(4,7,'admin','2014-08-22 14:07:19','aaaaaaaaa'),
(5,2,'admin','2014-08-22 14:07:20','aaaaaaaaa'),
(6,2,'admin','2014-08-22 14:08:24','12121212'),
(7,4,'admin','2014-08-22 14:08:24','12121212'),
(8,5,'admin','2014-08-22 14:08:45','ddddddddddd'),
(9,3,'david','2014-08-22 14:08:45','ddddddddddd'),
(10,2,'admin','2014-08-22 14:09:46','eeeeeeeeeeee'),
(11,6,'admin','2014-08-22 14:09:46','eeeeeeeeeeee'),
(12,2,'admin','2014-08-22 14:10:21','444'),
(13,8,'david','2014-08-22 14:10:21','444'),
(14,1,'admin','2014-08-22 14:11:08','22222'),
(15,1,'admin','2014-08-22 14:11:08','22222'),
(16,2,'admin','2014-08-22 14:11:24','11'),
(17,2,'david','2014-08-22 14:11:24','11'),
(18,9,'admin','2014-08-22 14:12:02','yyyy'),
(19,9,'admin','2014-08-22 14:12:02','yyyy'),
(20,2,'admin','2014-08-22 14:12:49','zzzzzz'),
(21,7,'admin','2014-08-22 14:12:49','zzzzzz'),
(22,4,'admin','2014-08-22 14:13:21','yhyhyhyhyhyhyhyhy'),
(23,2,'admin','2014-08-25 10:09:19','hoy estoy entusiasmado'),
(24,1,'admin','2014-08-25 10:09:37','hoy estoy entusiasmado'),
(25,1,'david','2014-08-25 11:38:14','ahora estoy entusiasmado'),
(26,1,'david','2014-08-25 12:32:15','porque sí'),
(27,2,'david','2014-08-25 13:42:10','hoy estoy enfadado'),
(28,1,'admin','2014-08-25 14:40:12','bla bla bla'),
(29,1,'admin','2014-08-25 14:40:40','werwerwer'),
(30,5,'admin','2014-08-25 14:41:56','asustadisimo'),
(31,2,'david','2014-08-20 14:49:39','estoy enfadado'),
(32,1,'david','2014-08-27 14:49:31','bla bla'),
(33,1,'david','2014-08-21 14:50:31','le le le le'),
(34,8,'admin','2014-08-21 14:56:15','hoy estoy cansado'),
(35,5,'admin','2014-08-19 15:01:58',''),
(36,5,'admin','2014-08-27 15:02:35',''),
(37,8,'admin','2014-08-27 15:03:55',''),
(38,8,'admin','2014-08-27 15:04:59','hoy estoy cansado....'),
(39,5,'admin','2014-08-27 15:13:33','porque sí'),
(40,3,'admin','2014-08-28 10:41:33','cambios en el diseño'),
(41,8,'admin','2014-08-28 10:43:04','he madrugado mucho'),
(42,5,'admin','2014-08-28 10:43:36','Ya es jueves!!!!'),
(43,4,'david','2014-08-28 15:09:25','estoy asi!!!!'),
(44,5,'david','2014-08-28 15:09:47','Estoy alegre!!!!'),
(45,3,'david','2014-08-18 15:13:22','hoy estoy triste :('),
(46,6,'david','2014-08-28 15:14:09','estoy avergonzado'),
(47,7,'david','2014-08-28 15:14:19','estoy euforico'),
(48,8,'david','2014-08-28 15:14:35','muy cansado de madrugar...'),
(49,9,'david','2014-08-28 15:14:43','hoy me siento bien'),
(50,9,'admin','2014-08-28 15:15:16','casi he terminado la Web'),
(51,8,'david','2014-08-29 08:53:17','porque he madrugado'),
(52,8,'david','2014-08-29 09:05:43','porque sali'),
(53,2,'david','2014-08-29 10:40:13','toi miedoso'),
(54,5,'david','2014-08-29 10:41:28','alegrisimo'),
(55,5,'david','2014-08-29 10:42:01','alegrisimo'),
(56,5,'david','2014-08-29 10:42:53','alegrisimo'),
(57,4,'david','2014-08-29 10:43:53','estoy muy enfafado'),
(58,4,'david','2014-08-29 10:44:06','estoy muy enfafado 2'),
(59,4,'david','2014-08-29 10:44:33','sigo enfadado'),
(60,5,'admin','2014-08-29 11:42:15','hoy estoy alegre porque es viernes'),
(61,4,'admin','2014-08-29 13:44:42','xcvxcvxcvxc'),
(62,8,'admin','2014-08-29 13:45:37','erterter'),
(63,5,'admin','2014-10-14 12:48:00','aaaa'),
(64,7,'admin','2014-11-17 10:49:19','yujuuuuu'),
(65,8,'admin','2014-11-17 10:51:09','fghfgh'),
(66,7,'admin','2014-11-17 10:52:37','hfghfg'),
(67,7,'admin','2014-11-17 10:54:25','ertert'),
(68,4,'admin','2014-11-17 10:55:38','gfdhghd'),
(69,5,'admin','2014-11-17 10:57:52','dfgdfd'),
(70,5,'admin','2014-11-17 10:58:24','dsfsd');

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
) ENGINE=MyISAM AUTO_INCREMENT=178 DEFAULT CHARSET=utf8;

/*Data for the table `foro_comentarios` */

insert  into `foro_comentarios`(`id_comentario`,`id_tema`,`canal`,`comentario`,`user_comentario`,`date_comentario`,`votaciones`,`estado`,`id_comentario_id`) values 
(68,36,'','¿para que es este foro?','admin','2014-07-24 13:59:45',0,2,0),
(69,36,'','A ver si alguien me lo explica....','admin','2014-07-24 14:00:10',1,1,0),
(70,36,'','Nuevo comentario para el foro de comerciales','admin','2014-09-10 14:10:13',1,1,0),
(71,36,'','pues sí','admin','2014-09-26 12:38:16',0,1,70),
(72,36,'','Pues no','admin','2014-09-26 12:38:34',0,1,71),
(73,36,'','Pue sí otra vez','admin','2014-09-26 12:38:45',0,1,72),
(74,38,'','El primer comentario para este foro','admin','2014-09-29 13:50:51',0,1,0),
(75,38,'','otro comentario pal foro','admin','2014-09-29 13:51:12',0,1,0),
(76,39,'','Primer comentario pal foro','admin','2014-09-30 10:33:54',0,1,0),
(77,40,'','Primer comentario en el segundo foro de gerentes','admin','2014-09-30 10:34:17',0,1,0),
(78,36,'','otro comentario','admin','2014-09-30 10:35:04',0,1,0),
(79,42,'','¿Que nuevas secciones os gustaria tener?','admin','2014-09-30 10:37:20',0,1,0),
(80,42,'','Esperamos respuestas','admin','2014-09-30 10:40:52',0,1,0),
(81,42,'','Seguimos esperando','admin','2014-10-03 10:40:18',0,1,0),
(82,42,'','Otro comentario más pal foro','admin','2014-10-03 10:42:31',0,1,0),
(83,42,'','dfsdsds','admin','2014-10-09 11:51:16',0,1,82),
(84,42,'','gdfgd','admin','2014-10-09 11:51:26',0,1,83),
(85,42,'','dsfds','admin','2014-10-09 11:51:35',0,1,84),
(86,37,'','un comentario en el foro','admin','2014-10-09 16:44:03',0,1,0),
(87,45,'','un comentario en un foro del área principal','admin','2014-10-09 18:19:07',0,1,0),
(88,51,'','Me gusta la entrada en el blog','admin','2014-10-10 12:19:59',0,1,0),
(89,51,'','Pon algo más!!!!','admin','2014-10-10 12:28:39',0,1,0),
(90,51,'','Queremos mas!!!','admin','2014-10-10 15:07:12',0,1,0),
(91,54,'','Pues sí, pues sí, ....','david','2014-10-11 18:14:19',1,1,0),
(92,38,'','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ut sapien dui.','admin','2014-10-15 12:27:11',0,1,0),
(93,41,'','¿como recupero la contraseña?','admin','2014-10-22 17:49:41',0,1,0),
(94,57,'','primer comentario','admin','2014-10-23 13:44:35',0,1,0),
(95,38,'','El usuario actual es el usuario bajo el que se ejecuta PHP. Probablemente no sea el mismo usuario que se utilize para el intérprete de comandos normal o el acceso FTP. EL modo puede ser cambiado sólo por el usuario al que pertenece el fichero en la mayoría de sistemas. ','admin','2014-10-24 11:39:22',0,1,0),
(96,38,'','PHP verifica si los ficheros o directorios sobre los que se va a operar tienen el mismo UID (propietario) que el del script que está siendo ejecutado. Además, no se pueden establecer los bits SUID, SGID y sticky. ','admin','2014-10-24 11:39:35',0,1,0),
(97,38,'','jhlkjhlkjhlkjh','admin','2014-11-07 12:16:15',0,1,0),
(98,38,'','Mas comentarios en el foro de la comunidad','admin','2014-11-28 13:09:42',0,1,0),
(99,38,'','mas comentarios. Me gustan los foros','admin','2014-11-28 13:10:34',0,1,0),
(100,38,'','A mi tambien me gustan','admin','2014-11-28 13:11:23',0,1,0),
(101,38,'','ggggggggggggg','admin','2014-11-28 13:11:34',0,1,0),
(102,38,'','ghfghfghfhf','admin','2014-11-28 13:11:59',0,1,0),
(103,38,'','dfdgdfgdg','admin','2014-11-28 13:14:44',0,1,0),
(104,38,'','45454','admin','2014-11-28 13:16:18',0,1,0),
(105,41,'','En recodar contraseña del login','david','2014-11-28 13:17:29',0,1,0),
(106,38,'','fdgdfg','admin','2014-11-28 13:19:17',0,1,0),
(107,38,'','ttttttttttttttttt ttttttttttt','admin','2014-11-28 13:20:58',0,1,0),
(108,64,'','Podeis proponer temas y dar consejos a otros compañeros','david','2014-11-28 14:09:56',0,1,0),
(109,64,'','Alguna propuesta','david','2014-11-28 18:02:25',0,1,0),
(110,61,'','buena noticia!','admin','2014-11-28 18:20:19',0,1,0),
(111,61,'','Puedes explicarlo un poco mejor','admin','2014-11-28 18:21:22',0,1,0),
(112,61,'','hala!!!!!!','admin','2014-11-28 18:22:18',0,1,0),
(113,64,'','pues no...','admin','2014-11-28 18:23:54',0,1,0),
(114,64,'','Using these validation styles to denote the state of a form control only provides a visual indication, which will not be conveyed to users of assistive technologies ','admin','2014-11-28 20:06:41',0,1,0),
(115,64,'','hola','admin','2014-12-03 13:30:06',0,1,0),
(116,64,'','','admin','2014-12-04 13:11:20',0,1,0),
(117,64,'','muy ´bien','admin','2014-12-04 13:12:36',0,1,0),
(118,64,'','ffff','admin','2014-12-04 13:12:45',0,1,0),
(119,64,'','muy bien´','admin','2014-12-04 13:13:05',0,1,0),
(120,64,'','genial\'','admin','2014-12-04 13:13:50',0,1,0),
(121,64,'','pos sí\'','admin','2014-12-04 13:22:46',0,2,0),
(122,72,'','I was stumped for a long time by the fact that even when using addslashes and stripslashes explicitly on the field values double quotes (\") still didn´t seem to show up in strings read from a database. Until I looked at the source, and realised that the field value is just truncated at the first occurrence of a double quote. the remainder of the string is there (in the source), but is ignored when the form is displayed and submitted.','dcancho','2015-02-17 10:07:16',0,1,0),
(123,61,'','No se....','admin','2015-02-19 10:05:07',0,1,111),
(124,54,'','noooo','admin','2015-02-27 12:14:43',0,1,91),
(125,69,'','Me gusta','admin','2015-02-28 00:29:03',0,2,0),
(126,60,'','Haz otra prueba más','dcancho','2015-02-28 00:31:09',0,1,0),
(127,50,'','Estoy totalmente de acuerdo ','dcancho','2015-02-28 00:31:54',0,1,0),
(128,40,'','En un lugar de la Mancha, de cuyo nombre no quiero acordarme, no ha mucho tiempo que vivía un hidalgo de los de lanza en astillero','claudio','2015-02-28 00:39:36',0,1,0),
(129,69,'','El resto della concluían sayo de velarte, calzas de velludo para las fiestas, con sus pantuflos de lo mesmo','claudio','2015-02-28 00:42:14',1,1,0),
(130,73,'','Alguien fue al curso?','claudio','2015-02-28 00:44:20',0,1,0),
(131,64,'','Hola soy cancho','dcancho','2015-02-28 00:59:12',0,1,0),
(132,69,'','Más comentarios','admin','2015-03-02 10:46:27',0,2,0),
(133,74,'','El resto della concluían sayo de velarte, calzas de velludo para las fiestas, con sus pantuflos de lo mesmo, y los días de entresemana se honraba con su vellorí de lo más fino.','admin','2015-03-15 03:03:04',0,1,0),
(134,60,'',' Lorem ipsum dolor sit amet, consectetur adipiscing elit','admin','2015-03-20 19:31:58',0,1,0),
(135,41,'','Fácil, donde siempre','borja','2015-06-13 01:51:35',0,1,0),
(136,74,'','Bootstrap 3 comes with over a dozen reusable glyphicons components which can be used for different purposes. However there is no clear statement about this as of the moment.','admin','2015-09-09 17:43:41',0,1,0),
(137,74,'','It’s been a lot of headache for developers when it comes to trying to make sites work perfectly on old browsers, so this a big move. If you need IE8 support, then keep using Bootstrap 3.','admin','2015-09-09 17:43:51',0,1,0),
(138,74,'','Bootstrap 4 alpha is drops Internet Explorer 8 support. One of the biggest problems with IE8 is that it doesn’t support CSS media queries, which play an important role in implementing responsive design within the framework.','admin','2015-09-09 17:43:59',0,1,0),
(139,74,'','Bootstrap 4 alpha is drops Internet Explorer 8 support. One of the biggest problems with IE8 is that it doesn’t support CSS media queries, which play an important role in implementing responsive design within the framework.','admin','2015-09-09 17:44:03',0,1,0),
(140,74,'','Bootstrap 4 alpha is drops Internet Explorer 8 support. One of the biggest problems with IE8 is that it doesn’t support CSS media queries, which play an important role in implementing responsive design within the framework.','admin','2015-09-09 17:44:07',0,1,0),
(141,74,'','Bootstrap 4 alpha is drops Internet Explorer 8 support. One of the biggest problems with IE8 is that it doesn’t support CSS media queries, which play an important role in implementing responsive design within the framework.','admin','2015-09-09 17:44:11',0,1,0),
(142,74,'','Bootstrap 4 alpha is drops Internet Explorer 8 support. One of the biggest problems with IE8 is that it doesn’t support CSS media queries, which play an important role in implementing responsive design within the framework.','admin','2015-09-09 17:44:15',0,1,0),
(143,74,'','Bootstrap 3 comes with over a dozen reusable glyphicons components which can be used for different purposes. However there is no clear statement about this as of the moment.','admin','2015-09-09 17:44:25',0,1,0),
(144,74,'','Bootstrap 3 comes with over a dozen reusable glyphicons components which can be used for different purposes. However there is no clear statement about this as of the moment.','admin','2015-09-09 17:44:43',0,1,0),
(145,74,'','Bootstrap 3 comes with over a dozen reusable glyphicons components which can be used for different purposes. However there is no clear statement about this as of the moment.','admin','2015-09-09 17:44:57',0,1,0),
(146,69,'','“This month is the independence of my country and I thought what a better way to celebrate it than showcase the world the beauty of my country,” — Designed by Maria Keller from Mexico.','admin','2015-09-11 13:46:59',0,1,0),
(147,69,'','“Summer seems to be over… but the weather is still warm and we definitely can enjoy the sea for a little longer. So… lets go and ride the waves! Are you coming?” — Designed by WebOlution from Greece.','admin','2015-09-11 13:47:13',0,1,0),
(148,69,'','“While September’s Autumnal Equinox (on September 23, 2015) technically signifies the end of the summer season, this wallpaper is for all those summer lovers, like me, who don’t want the sunshine, warm weather and lazy days to end.” — Designed by Vicki Grunewald from Washington.','admin','2015-09-11 13:47:22',0,1,0),
(149,69,'','“As summer winds down, September is the perfect month to steal away on one last vacation before the holiday hustle begins. Take the vacation, it’s a good plan.” — Designed by Chelsea Larsson from the United States.','admin','2015-09-11 13:47:33',0,1,0),
(150,78,'','jsjsjsjsjs','admin','2015-09-28 09:46:56',0,1,0),
(151,74,'','como me gusta bootstrap!!!!','admin','2015-10-03 02:25:38',0,1,145),
(152,79,'','primer comentario en el foro del curso','admin','2015-10-05 11:25:31',0,1,0),
(153,69,'','Pues sí pues sí','admin','2015-10-16 11:07:10',0,2,0),
(154,69,'','Pues no pues no','admin','2015-10-16 11:39:57',0,2,0),
(155,61,'','ja aja aja','admin','2015-10-16 11:40:08',0,1,0),
(156,61,'','bla bla bla','admin','2015-10-16 11:40:17',0,1,155),
(157,65,'','Apparently, Adblock Plus can remove Font Awesome brand icons with their \"Remove Social Media Buttons\" setting','pedro','2015-10-22 16:30:45',0,1,0),
(158,64,'','otf to ttf converter converts otf format font files to ttf files. This is an online font conversion utility that works through your browser. No additional software is ...','pedro','2015-10-22 16:34:52',0,1,0),
(159,64,'','This little tool converts any .ttf (TrueType Font) or .otf (OpenType Font) file to .ttf, .otf, .eot, .woff and .svg files. It also creates a CSS file and a demo HTML file to ...','pedro','2015-10-22 16:35:29',0,1,131),
(160,40,'','Muy bien !!!','senen','2015-10-27 13:20:58',0,1,128),
(161,68,'','Se el primero en comentarla!!!','admin','2015-10-28 12:57:24',0,1,0),
(162,74,'','algo de texto','admin','2015-11-12 17:16:05',0,1,138),
(163,74,'','haciendo focus()','admin','2015-11-12 17:16:23',0,1,151),
(164,40,'','Probando temas','claudio','2016-03-09 13:29:24',1,1,0),
(165,65,'','test img','pedro','2016-03-10 15:52:16',0,1,0),
(166,69,'','jksdkjfskjdfsdfsf','admin','2016-03-17 10:02:08',0,1,148),
(167,69,'','kjdfhsdkjfsh','admin','2016-03-17 10:02:19',0,1,166),
(168,78,'','rte rterter 111111111111111111','admin','2016-05-26 10:47:49',0,1,0),
(169,65,'','hola','admin','2016-08-29 14:44:17',0,1,0),
(170,78,'','hhhhh','admin','2016-10-14 09:20:27',0,1,150),
(171,78,'','hola @david','admin','2016-10-20 10:47:16',0,1,0),
(172,78,'','hola https://google.es','admin','2016-10-20 10:50:46',0,1,0),
(173,77,'','Un comentario para el foro','admin','2016-11-16 10:36:16',0,1,0),
(174,77,'','je je eje','admin','2016-11-16 10:36:30',0,1,173),
(175,69,'','comentario en gerentes','admin','2016-11-23 16:19:15',0,1,0),
(176,69,'','un comentario','borja','2016-12-19 11:43:53',0,1,0),
(177,69,'','te respondo','borja','2016-12-19 11:44:11',0,1,129);

/*Table structure for table `foro_comentarios_votaciones` */

DROP TABLE IF EXISTS `foro_comentarios_votaciones`;

CREATE TABLE `foro_comentarios_votaciones` (
  `id_votacion` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_comentario` int(11) NOT NULL DEFAULT '0',
  `user_votacion` varchar(100) NOT NULL DEFAULT '',
  `date_votacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_votacion`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `foro_comentarios_votaciones` */

insert  into `foro_comentarios_votaciones`(`id_votacion`,`id_comentario`,`user_votacion`,`date_votacion`) values 
(10,70,'david','2014-09-23 09:50:48'),
(11,69,'david','2014-09-23 09:51:34'),
(12,91,'admin','2015-02-27 12:13:15'),
(13,129,'admin','2015-03-02 10:46:38'),
(14,164,'admin','2016-03-17 10:20:36');

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
  `destacado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_tema`)
) ENGINE=MyISAM AUTO_INCREMENT=83 DEFAULT CHARSET=utf8;

/*Data for the table `foro_temas` */

insert  into `foro_temas`(`id_tema`,`id_tema_parent`,`tipo_tema`,`nombre`,`descripcion`,`imagen_tema`,`date_tema`,`user`,`canal`,`responsables`,`itinerario`,`activo`,`id_area`,`ocio`,`destacado`) values 
(1,0,'','Foro principal','','','2014-07-24 13:55:21','admin','comercial',0,'',1,0,0,0),
(2,0,'','Foro principal gerentes','','','2014-07-24 13:57:44','admin','gerente',0,'',1,0,0,0),
(36,1,'','un temas en comerciales','Primer tema en el canal comercial para pruebas.','','2014-07-24 13:59:20','admin','comercial',0,'',1,0,0,0),
(37,0,'','Área de prueba inicial','El primer curso de formación para el canal comerciales','','2014-08-01 09:06:32','admin','comercial',0,'',1,9,0,0),
(38,1,'','Nuevo tema en los foros','¿Te gustan los foros de la comunidad? cuéntanos....','','2014-08-04 12:07:33','admin','comercial',0,'',0,0,0,0),
(39,2,'','Un foro en canal gerentes','Foro de prueba para canal gerentes','','2014-09-30 10:30:50','admin','gerente',0,'',1,0,0,0),
(40,2,'','Otro foro más en gerentes','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ligula sapien, cursus non aliquet sed, molestie eget augue. In lacus lacus, accumsan non tortor vel, lobortis porta eros.','','2014-09-30 10:33:02','admin','gerente',0,'',1,0,0,0),
(41,1,'','FAQ comerciales','Foro para consultas frecuentes de comerciales','','2014-09-30 10:35:57','admin','comercial',0,'',1,0,0,0),
(42,1,'','Nuevas secciones comerciales','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ligula sapien, cursus non aliquet sed, molestie eget augue. In lacus lacus, accumsan non tortor vel, lobortis porta eros.','','2014-09-30 10:36:45','admin','comercial',0,'',1,0,0,0),
(43,0,'','Curso 2 de prueba de formación inicial para comerciales','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam dolor nulla, sodales et pretium quis, iaculis id ex. Quisque pharetra in ex in hendrerit','','2014-10-02 11:33:19','admin','comercial',0,'',1,10,0,0),
(44,1,'','Otro tema más','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam dolor nulla, sodales et pretium quis, iaculis id ex. Quisque pharetra in ex in hendrerit. Nulla bibendum mollis pulvinar. Nullam felis leo, mattis quis lacus a, mattis dictum tortor. Mauris ac feugiat turpis. ','','2014-10-02 15:31:55','admin','comercial',0,'',1,0,0,0),
(45,37,'','Otro curso en el área de trabajo PRUEBA INICIAL','HTML5 offers some new elements, primarily for semantic purposes. The elements include: section, article, aside, header, footer, nav, figure, figcaption, time, mark, main.','','2014-10-09 16:40:46','admin','comercial',0,'',1,9,0,0),
(46,37,'','Otro foro en el área inicial','Partial support refers to missing the default styling. This is easily taken care of by using display:block for all new elements (except time and mark, these should be display:inline anyway). IE11 and older versions of other browsers do not support the <main> element.','','2014-10-09 16:45:46','admin','comercial',0,'',1,9,0,0),
(47,37,'','Un foro en el areaa inicial','durante una semana, desde el 16 al 20 de junio tendrás que contestar a 3 preguntas diarias sobre la información que subimos en tu \"info\" siempre más. Una a las 10:00, otra a las 15:00 y otra a las 18:00. El viernes día 20 activaremos todas las preguntas a modo respesca para darte la última oportunidad para conseguir una camiseta del 2º aniversario.* *máximo 20 unidades','','2014-10-09 16:59:48','admin','comercial',0,'',1,9,0,0),
(48,37,'','Más foros para el áreas INICIAL','Yes, you can enable accessible colors from this link or from the option under Settings. This color scheme will be used again on revisit. ','','2014-10-09 17:02:53','admin','comercial',0,'',1,9,0,0),
(49,37,'','Más para el áre de trabajo INICIAL','Adding features takes quite some time and there are many requests for additions. Because of this I use Google Moderator to manage requests. Feel free to add/vote for your feature there.','','2014-10-09 17:03:37','admin','comercial',0,'',1,9,0,0),
(50,0,'Maquetación, Diseño','¿Que diantres es Quijotipsum?','<p><img alt=\"\" src=\"https://comunidad.local.com/images/mailing/images/1412935026_postal5_quijote.jpeg\" style=\"float:left; height:150px; margin:15px; width:200px\" />En un lugar de la Mancha, de cuyo nombre no quiero acordarme, no ha mucho tiempo que viv&iacute;a un hidalgo de los de lanza en astillero, adarga antigua, roc&iacute;n flaco y galgo corredor. Una olla de algo m&aacute;s vaca que carnero, salpic&oacute;n las m&aacute;s noches, duelos y quebrantos los s&aacute;bados, lantejas los viernes, alg&uacute;n palomino de a&ntilde;adidura los domingos, consum&iacute;an las tres partes de su hacienda. El resto della conclu&iacute;an sayo de velarte, calzas de velludo para las fiestas, con sus pantuflos de lo mesmo, y los d&iacute;as de entresemana se honraba con su vellor&iacute; de lo m&aacute;s fino.<!--more--><br />\r\n<br />\r\nTen&iacute;a en su casa una ama que pasaba de los cuarenta, y una sobrina que no llegaba a los veinte, y un mozo de campo y plaza, que as&iacute; ensillaba el roc&iacute;n como tomaba la podadera. Frisaba la edad de nuestro hidalgo con los cincuenta a&ntilde;os; era de complexi&oacute;n recia, seco de carnes, enjuto de rostro, gran madrugador y amigo de la caza.<br />\r\n<br />\r\nQuieren decir que ten&iacute;a el sobrenombre de Quijada, o Quesada, que en esto hay alguna diferencia en los autores que deste caso escriben; aunque, por conjeturas veros&iacute;miles, se deja entender que se llamaba Quejana. Pero esto importa poco a nuestro cuento; basta que en la narraci&oacute;n d&eacute;l no se salga un punto de la verdad.<br />\r\n<br />\r\nPara mas informaci&oacute;n <a href=\"http://www.quijotipsum.com/\">http://www.quijotipsum.com/</a></p>\r\n','1412935026_postal5_quijote.jpeg','2014-09-19 11:57:06','admin','comercial',0,'',1,0,1,0),
(51,0,'Maquetación, Diseño','Lorem ipsum dolor sit amet','<p><img alt=\"\" src=\"https://comunidad.local.com/images/mailing/images/lorem-ipsum.jpg\" style=\"float:left; height:139px; margin:15px; width:200px\" /></p>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque nec interdum elit, sit amet porttitor est. Nulla malesuada molestie scelerisque. <strong>Nam convallis auctor sapien</strong>, a dapibus sem ornare et. Aenean eu orci vel tortor tempus sodales a eu elit. Aenean aliquam sodales massa, vel sodales turpis facilisis nec. Morbi euismod commodo rhoncus. Sed rutrum pretium quam semper dignissim. Maecenas vel augue sapien.</p>\r\n\r\n<p><!--more-->Nullam rhoncus ac felis ut aliquam. Integer elementum, leo vitae convallis convallis, nisl tortor gravida sapien, bibendum suscipit ex quam sit amet massa. Proin sed purus fringilla, eleifend libero ut, imperdiet velit. Nullam eleifend aliquam mauris non posuere. Maecenas viverra felis enim. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Integer tristique pellentesque enim at lobortis.</p>\r\n\r\n<p>Curabitur dignissim mi sed venenatis scelerisque. <strong>Quisque</strong> eu risus fringilla, rutrum leo feugiat, tincidunt nibh. Nunc viverra porta erat. In tincidunt, nisi luctus vestibulum interdum, lectus odio imperdiet tellus, rhoncus tempus velit purus non ex. Fusce pretium ligula vitae sodales pulvinar. Nunc a mi pretium, semper nisi quis, hendrerit tellus. Sed tristique lectus non finibus pellentesque.</p>\r\n\r\n<p>Proin at dolor cursus, ullamcorper eros id, ornare tellus. Vivamus bibendum accumsan sem at cursus. Suspendisse molestie lorem molestie, volutpat mauris eget, bibendum quam. Aliquam faucibus rhoncus mauris, eu tempor leo porttitor a. Cras at tempor dui, nec lacinia magna. Nam blandit hendrerit risus, quis lobortis elit mattis ac. Nulla quis eleifend tortor, eget aliquam leo. Phasellus a quam vel turpis pretium eleifend facilisis ac diam. Suspendisse dapibus vitae metus ut scelerisque. Proin sodales sagittis tellus a pretium.</p>\r\n','1412935528_lorem-ipsum.jpg','2014-10-10 12:05:28','admin','comercial',0,'',1,0,1,0),
(66,0,'','foro test alerts','desc trext alerts','','2014-12-24 02:54:02','admin','comercial',0,'',1,13,0,0),
(52,0,'Maquetación, Diseño','Flat design concept','<p><br />\r\n<img alt=\"\" src=\"https://comunidad.local.com/images/mailing/images/flatinspiration04.jpg\" style=\"float:left; height:225px; margin:15px; width:300px\" />Flat design is a minimalistic design approach that emphasizes usability. It features clean, open space, crisp edges, bright colours and two-dimensional/flat illustrations.</p>\r\n\r\n<p><br />\r\nMicrosoft was one of the first to apply this design style to its interface, seen by some as a backlash against the popular skeuomorphic design that Apple kicked off with its iOS interface. Instead of converting a real-life object, such as a calendar, into a tiny realistic illustration, advocates of flat design identify apps with simple, icon-like images.</p>\r\n\r\n<p><br />\r\nRather than bringing aspects of real life to an interface, this illustrates a clear separation between technology and tactile objects.</p>\r\n\r\n<h2>Minimalist doesn&#39;t mean boring</h2>\r\n\r\n<p>In flat design, ornamental elements are viewed as unnecessary clutter. If an aspect serves no functional purpose, it&#39;s a distraction from user experience. This is the reason for the minimalistic nature of flat design.</p>\r\n\r\n<p><br />\r\nHowever, just because it lacks any flashy design doesn&#39;t mean this style is boring. Bright, contrasting colours make illustrations and buttons pop from backgrounds, easily grab attention, and guide the user&#39;s eye. The purpose of minimalistic imagery also contributes to flat design&#39;s functional character.</p>\r\n','1412947247_flatinspiration04.jpg','2014-10-10 15:20:47','admin','comercial',0,'',1,0,1,0),
(53,0,'Diseño, Fotografía','The value of photography in web design','<div>\r\n	No matter the images you have in your library they will rarely be suitable for the task. Sorry, but that is most often the case. You need photography that has been taken for purpose, by a professional and with a brief from both client and designer.</div>\r\n<div>\r\n	&nbsp;</div>\r\n<div>\r\n	Consider the responsive nature of web design, different areas of the photo will be visible depending on the device size. The exact same web page is then rendered differently on different devices but we still keep control.</div>\r\n','1412947945_squiders1.jpg','2014-10-10 15:32:25','admin','comercial',0,'',1,0,1,0),
(67,0,'','foro test alerts','desc trext alerts','','2014-12-24 02:54:49','admin','comercial',0,'',1,14,0,0),
(54,0,'Maquetación, Diseño','10 design mistakes that will bust your budget','<p>Not all projects are smooth sailing. Sometimes things go wrong, clients aren&#39;t happy and the time and resources you originally planned to spend on the project expands exponentially. Your expected profit becomes dramatically scaled down and you may even end up making a loss...</p>\r\n\r\n<p><br />\r\nHead some of the major problems off at the start by recognising these 10 common design project pitfalls and sidestepping them before they come back to bite you on your creative ass...</p>\r\n\r\n<h3>01. You said &#39;yes&#39; but should have said &#39;no&#39;</h3>\r\n\r\n<p><img alt=\"\" src=\"https://comunidad.local.com/images/mailing/images/design-busting-mistakes.jpg\" style=\"width:100%\" /><br />\r\n<br />\r\nWe&acute;ve all done it. The lure of a big job can make you accept a commission without really thinking it through. Especially if you don&acute;t have any other work on. But ask yourself: are you really right for the job? Does it excite you? Sometimes it&acute;s better to say &acute;no&acute; to avoid problems further down the line.</p>\r\n','1412948542_flat-web-design-9.jpg','2014-10-10 15:42:22','admin','comercial',0,'',1,0,1,0),
(55,0,'','Curso de inscripcion 12','Curso en el que los usuarios se pueden inscribir con un límite máximo de usuarios inscritos. 2','','2014-10-13 10:43:16','admin','comercial',0,'',1,11,0,0),
(56,43,'','foro para el curso 2','La descripción del foro para el curso2','','2014-10-23 13:36:32','admin','comercial',0,'',1,10,0,0),
(57,43,'','otro foro pal curso','Después de 10 días entrenando en el simulador, ha llegado la hora de demostrar el piloto que llevas dentro','','2014-10-23 13:40:44','admin','comercial',0,'',1,10,0,0),
(58,43,'','Uno nuevo en el curso 2','As it currently stands, this question is not a good fit for our Q&A format. We expect answers to be supported by facts, references, or expertise, but this question will likely solicit debate, arguments, polling, or extended discussion. ','','2014-10-23 13:43:58','admin','comercial',0,'',1,10,0,0),
(59,0,'','Story Theme','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla laoreet venenatis libero, ac accumsan erat pretium nec. Nam porttitor pretium ultricies. Aenean id faucibus ligula, id imperdiet enim. Sed hendrerit vulputate mattis. Proin at est bibendum, porttitor nulla ac, mollis diam.<br />\r\n<br />\r\nPraesent tristique viverra ex ullamcorper rhoncus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nam justo sem, iaculis sed orci sollicitudin, facilisis posuere dui. Sed quis fermentum dolor, eu vestibulum orci. Aenean sodales sem eu magna consectetur feugiat. In hac habitasse platea dictumst. Donec interdum sagittis quam placerat pulvinar. Aliquam erat volutpat. Maecenas ac arcu vitae erat venenatis pharetra. Praesent vitae aliquam orci. Vestibulum condimentum mattis maximus. ','1415898580_230902-1405453869.png','2014-10-31 09:33:40','admin','comercial',0,'',1,0,1,0),
(61,0,'Diseño','Nuevo iPhone6','<p><img alt=\"\" src=\"https://comunidad.local.com/images/mailing/images/premio01594.jpg\" style=\"float:left; height:222px; margin:15px; width:222px\" /></p>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque nec interdum elit, sit amet porttitor est. Nulla malesuada molestie scelerisque. <strong>Nam convallis auctor sapien</strong>, a dapibus sem ornare et. Aenean eu orci vel tortor tempus sodales a eu elit. Aenean aliquam sodales massa, vel sodales turpis facilisis nec. Morbi euismod commodo rhoncus. Sed rutrum pretium quam semper dignissim. Maecenas vel augue sapien.<br />\r\n<br />\r\nIn hac habitasse platea dictumst. Donec interdum sagittis quam placerat pulvinar. Aliquam erat volutpat. Maecenas ac arcu vitae erat venenatis pharetra. Praesent vitae aliquam orci. Vestibulum condimentum mattis maximus.<br />\r\n<!--more--><br />\r\nNulla laoreet venenatis libero, ac accumsan erat pretium nec. Nam porttitor pretium ultricies.<br />\r\n<br />\r\nNullam rhoncus ac felis ut aliquam. <strong>Integer elementum</strong>, leo vitae convallis convallis, nisl tortor gravida sapien,<br />\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla laoreet venenatis libero, ac accumsan erat pretium nec. Nam porttitor pretium ultricies. Aenean id faucibus ligula, id imperdiet enim. Sed hendrerit vulputate mattis. Proin at est bibendum, porttitor nulla ac, mollis diam.<br />\r\n<br />\r\nPraesent tristique viverra ex ullamcorper rhoncus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nam justo sem, iaculis sed orci sollicitudin, facilisis posuere dui. Sed quis fermentum dolor, eu vestibulum orci. Aenean sodales sem eu magna consectetur feugiat. In hac habitasse platea dictumst. Donec interdum sagittis quam placerat pulvinar. Aliquam erat volutpat. Maecenas ac arcu vitae erat venenatis pharetra. Praesent vitae aliquam orci. Vestibulum condimentum mattis maximus.</p>\r\n','1415898644_premio01594.jpg','2014-11-13 18:01:10','admin','gerente',0,'',1,0,1,0),
(60,0,'','Prueba de saltos de linea','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non laoreet orci. Nullam non convallis diam. Nulla ac magna aliquam, egestas lectus id, gravida libero. Fusce aliquam augue at elementum placerat. Curabitur vel iaculis leo. In eros metus, viverra ac congue id, congue eget urna. Ut commodo volutpat nulla, a dictum diam consectetur id. Donec eget velit lorem. Interdum et malesuada fames ac ante ipsum primis in faucibus. Mauris semper nibh et egestas elementum. Ut ac convallis sem. Donec facilisis luctus placerat. Vestibulum nec iaculis tellus, at vestibulum ante. Fusce ut libero posuere, euismod leo dictum, volutpat velit. Donec sit amet est id quam scelerisque accumsan.</p>\r\n\r\n<p>Nam varius quis ligula sed sodales. Etiam viverra, neque sit amet mollis dictum, turpis leo cursus sapien, vel vulputate ligula justo vel lectus. Sed vehicula ornare ornare. Nulla maximus sit amet eros ut efficitur. Mauris rhoncus tempus vulputate. Aliquam ultricies nulla sit amet augue auctor euismod. Donec ut accumsan nibh, ut venenatis quam.</p>\r\n','1415008210_tumblr_n8psyhbag61slhhf0o1_1280.jpg','2014-10-31 09:34:47','admin','gerente,test',0,'',1,0,1,0),
(62,1,'','¿Porque se estropean con tan poco tiempo?','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vel quam nibh. Donec at eros in mi porta sagittis vitae at eros. Duis fringilla nunc commodo leo laoreet porta. ','','2014-11-19 14:02:39','admin','comercial',0,'',1,0,0,0),
(63,0,'','foro Prueba de curso sin tareas','I was stumped for a long time by the fact that even when using addslashes and stripslashes explicitly on the field values double quotes (\") still didn´t seem to show up in strings read from a database. Until I looked at the source, and realised that the field value is just truncated at the first occurrence of a double quote. the remainder of the string is there (in the source), but is ignored when the form is displayed and submitted.','','2014-11-24 11:36:46','admin','comercial',0,'',1,12,0,0),
(64,1,'','Foro para responsables de área','Foro para consultas de responsables de área','','2014-11-28 14:08:35','david','comercial',0,'',1,0,0,0),
(65,1,'','Consultas Android','Foro de consultas para Android','','2014-11-29 00:29:49','admin','comercial',0,'',1,0,0,0),
(68,0,'Gerentes','Noticia en gerentes','<p>Elements with angled horizontal edges can create a unique visual flow while progressing through a page. Though not commonly seen on the web, we decided to use the treatment on the new website for <a href=\"https://savingplaces.org/\">The National Trust for Historic Preservation</a>. We applied angled edges to several elements in different ways: some were applied to the bottom edge of a large full width images, while others were applied to the top and/or bottom edge of blocks with solid color backgrounds.</p>\r\n\r\n<p>CSS transforms are commonly used to achieve angled edges by skewing a parent element and then unskewing a child element, but this technique is limited to parallel edges. What if you need to apply the effect in different ways &ndash; only to one edge, to both top and bottom edges but with reversed angles, or to an image element? Fortunately, there are a few other options.</p>\r\n\r\n<h2>CSS clip-path</h2>\r\n\r\n<p>The first, and easiest option, is to use CSS clip-path. We chose to use this technique on large hero images. This assigns a clipping region to the image and essentially hides the bottom edge at a slight angle.</p>\r\n\r\n<p>We also used CSS clip-path on blocks with background images. Unlike the hero image above, the height of this block is variable across breakpoints. In order to maintain the correct angle (not too steep) across viewports, pixel values had to be used for any x coordinates.</p>\r\n\r\n<h2>CSS Generated Content</h2>\r\n\r\n<p>The second option is to use skewed generated content. This technique works great on blocks with solid color backgrounds.</p>\r\n\r\n<p>This adds a pseudo element at the bottom of the block, changes its point of rotation to the bottom right corner, and rotates it -1.5 degrees, simulating the effect of an angled edge.</p>\r\n\r\n<p>To implement another angled edge on the top of the element, it&rsquo;s as easy as adding another pseudo element with :before, changing its point of rotation to the top right corner, and rotating it 1.5 degrees.</p>\r\n','1421845750_gerentes.jpg','2015-01-21 13:43:36','admin','gerente',0,'',1,0,1,0),
(69,0,'','Entrada en canal gerentes con titular un poco largo','<p><img alt=\"\" src=\"https://comunidad.local.com/images/mailing/images/1412935026_postal5_quijote.jpeg\" style=\"width:50%\" /></p>\r\n\r\n<p>If you&#39;ve ever written to the DOM from JavaScript or jQuery you will know how quickly your code can begin to look messy, especially if you are using several variables. Angular allows for data to be used right in the markup, leading to clean, easy to read and understand code.<!--more-->There are also some great visualization libraries out there, but they come with a lot of default styling right out of the box. By using Angular, the visualizations are completely unopinionated, and will pick up your style right off the bat.</p>\r\n\r\n<p>I&#39;m not saying this is the best way of creating data visualizations, but it certainly appeals to me!</p>\r\n\r\n<p>I&#39;m rotating the SVG as by default it processes values from the top, and we need this to flipped to take values from the bottom.</p>\r\n\r\n<p>Firstly, we need to create an SVG that spans the full area of our graph, and then inside that use our <code>ng-repeat</code> on a <code>line</code> element.</p>\r\n\r\n<p>Each <code>line</code> element requires a start and end point on both the X (x1, x2) and Y (y1, y2) axis.</p>\r\n\r\n<p>The X axis is pretty simple - we follow the same system as before, so that each line is spaced out evenly across the chart, starting at 0 using <code>$index</code>, and ending where the next line starts, using <code>$index + 1</code>.</p>\r\n\r\n<p>For the Y axis this is where the <code>$index</code> variable comes in to its own, as it allows us to select values from previous or next entries in our array.</p>\r\n\r\n<p>The initial Y point of each line gets the value from the previous data entry using <code>data[$index - 1].value</code> before we then apply similar maths as before. For the second Y point we can just call the straight value from the entry.</p>\r\n\r\n<p>This may sound complicated (and I can assure you that working it out was a bit of a head shrinker!) but hopefully this explanation coupled with the code below should help you make sense of it!</p>\r\n','1426254994_post01.jpg','2015-01-21 13:51:49','admin','comercial,gerente,test',0,'',1,0,1,1),
(70,0,'','Foro El nuevo canal','','','2015-01-22 09:56:15','admin','canal_test',0,'',1,0,0,0),
(71,70,'','Primer foro en el canal de test','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec iaculis quam et risus ullamcorper, id scelerisque mauris cursus. Vestibulum in dapibus massa.','','2015-01-22 09:58:18','pedro','canal_test',0,'',1,0,0,0),
(72,63,'','Primer foro en el área de prueba sin tareas','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque facilisis leo justo, gravida gravida massa sagittis vitae. Aliquam vitae maximus purus.','','2015-02-17 10:06:59','dcancho','comercial',0,'',1,12,0,0),
(73,43,'','Curso HCV','Foro para consultas del curso HCV','','2015-02-28 00:43:56','claudio','gerente',0,'',1,10,0,0),
(74,70,'','Segundo tema en los foros','Es, pues, de saber que este sobredicho hidalgo, los ratos que estaba ocioso, que eran los más del año, se daba a leer libros de caballerías, con tanta afición y gusto, que olvidó casi de todo punto el ejercicio de la caza, y aun la administración de su hacienda.','','2015-03-02 10:48:31','admin','canal_test',0,'',1,0,0,0),
(75,70,'','¿A qué huelen las nubes?','Si alguien sabe la respuesta que nos lo cuente a todos. Es un gran misterio....','','2015-08-18 11:57:42','admin','canal_test',0,'',1,0,0,0),
(76,70,'','Support for Opt-in Flexbox','On Aug. 19, Bootstrap 4 alpha was released with the removal of support for IE8. Of course, there are still going to be a couple of alphas before they move to the beta phase, but this gives us a glimpse on what to expect on the next versions. By the way, Bootstrap 4 alpha will be in SCSS … sounds cool right?','','2015-09-09 17:36:08','admin','canal_test',0,'',1,0,0,0),
(77,70,'','Dropped Support for IE8','Bootstrap 4 alpha is drops Internet Explorer 8 support. One of the biggest problems with IE8 is that it doesn’t support CSS media queries, which play an important role in implementing responsive design within the framework.','','2015-09-09 17:36:22','admin','canal_test',0,'',1,0,0,0),
(78,70,'','Glyphicons Font Dropped','Bootstrap 3 comes with over a dozen reusable glyphicons components which can be used for different purposes. However there is no clear statement about this as of the moment.','','2015-09-09 17:36:44','admin','canal_test',0,'',1,0,0,0),
(79,55,'Formacion','Pimero foro en el curso','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ullamcorper volutpat scelerisque. Proin et tempus ex. Sed ut neque in tellus hendrerit accumsan. Integer aliquam, leo ac dictum dictum, lorem nulla faucibus nibh, sed placerat leo elit in justo. Integer id sapien urna. Proin vel volutpat odio. Aenean ac massa turpis. In et turpis fringilla, imperdiet orci eu, sollicitudin lectus. Maecenas mollis dolor in nisi lacinia posuere. Sed pellentesque dapibus ligula at sagittis. Integer fringilla auctor enim, at placerat nisl fringilla eu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam interdum est quis accumsan eleifend.','','2015-10-05 11:24:39','admin','comercial',0,'',1,11,0,0),
(80,0,'','Tarea nueva de prueba22','Working on web performance is a combination of obvious best practices (optimize assets), very tricky decisions (what can I defer loading on and what can´t I?), and nuanced choices (which animation technique is the most appropriate?).','','2015-10-05 13:55:56','admin','comercial',0,'',1,15,0,0),
(81,0,'','Foro canal de idiomas','','','2016-12-19 12:19:12','admin','test_lan',0,'',1,0,0,0),
(82,0,'','prueba canales','prueba de canales para un canal','','2016-12-21 09:45:26','admin','comercial,gerente',0,'',1,16,0,0);

/*Table structure for table `foro_visitas` */

DROP TABLE IF EXISTS `foro_visitas`;

CREATE TABLE `foro_visitas` (
  `id_visita` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(250) NOT NULL DEFAULT '',
  `id_tema` int(11) NOT NULL DEFAULT '0',
  `fecha_visita` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `movil` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_visita`)
) ENGINE=MyISAM AUTO_INCREMENT=2196 DEFAULT CHARSET=utf8;

/*Data for the table `foro_visitas` */

insert  into `foro_visitas`(`id_visita`,`username`,`id_tema`,`fecha_visita`,`movil`) values 
(477,'admin',36,'2014-07-24 13:59:32',0),
(478,'admin',36,'2014-07-24 13:59:46',0),
(479,'admin',36,'2014-07-24 14:00:10',0),
(480,'admin',36,'2014-07-24 14:01:09',0),
(481,'admin',36,'2014-07-24 14:01:58',0),
(482,'admin',36,'2014-07-24 14:03:43',0),
(483,'admin',36,'2014-07-24 14:03:48',0),
(484,'admin',36,'2014-07-24 14:04:39',0),
(485,'admin',36,'2014-07-24 14:06:22',0),
(486,'admin',36,'2014-07-24 14:06:36',0),
(487,'admin',36,'2014-07-24 14:07:54',0),
(488,'admin',36,'2014-07-24 14:08:30',0),
(489,'admin',36,'2014-07-24 14:08:41',0),
(490,'admin',36,'2014-07-24 14:10:50',0),
(491,'admin',36,'2014-07-24 14:10:56',0),
(492,'admin',36,'2014-07-24 14:11:53',0),
(493,'admin',36,'2014-07-24 14:12:14',0),
(494,'admin',36,'2014-07-24 14:12:52',0),
(495,'admin',36,'2014-07-24 15:02:37',0),
(496,'admin',36,'2014-07-25 13:41:40',0),
(497,'admin',36,'2014-07-25 13:42:11',0),
(498,'admin',36,'2014-07-29 11:20:48',0),
(499,'admin',36,'2014-07-29 11:27:50',0),
(500,'admin',36,'2014-08-01 11:36:26',0),
(501,'admin',36,'2014-08-04 12:06:56',0),
(502,'admin',38,'2014-08-04 12:07:36',0),
(503,'admin',36,'2014-08-11 12:03:08',0),
(504,'admin',36,'2014-08-11 12:06:08',0),
(505,'admin',36,'2014-08-11 12:06:52',0),
(506,'admin',36,'2014-08-11 12:07:49',0),
(507,'admin',36,'2014-08-11 12:09:35',0),
(508,'admin',36,'2014-08-11 12:09:36',0),
(509,'admin',36,'2014-08-11 12:10:20',0),
(510,'admin',36,'2014-08-11 12:10:30',0),
(511,'admin',36,'2014-08-11 12:10:30',0),
(512,'admin',36,'2014-08-11 12:10:42',0),
(513,'admin',36,'2014-08-11 12:11:54',0),
(514,'admin',36,'2014-08-11 12:12:14',0),
(515,'admin',36,'2014-08-11 12:12:29',0),
(516,'admin',36,'2014-08-11 12:14:04',0),
(517,'admin',36,'2014-08-11 12:14:05',0),
(518,'admin',36,'2014-08-11 12:14:33',0),
(519,'admin',36,'2014-08-11 12:14:33',0),
(520,'admin',36,'2014-08-11 12:14:45',0),
(521,'admin',36,'2014-08-11 12:14:46',0),
(522,'admin',36,'2014-09-10 10:58:59',0),
(523,'admin',36,'2014-09-10 10:59:13',0),
(524,'admin',36,'2014-09-10 10:59:41',0),
(525,'admin',36,'2014-09-10 14:09:51',0),
(526,'admin',36,'2014-09-10 14:10:13',0),
(527,'admin',36,'2014-09-10 14:10:23',0),
(528,'admin',36,'2014-09-15 16:36:55',0),
(529,'admin',36,'2014-09-15 16:37:46',0),
(530,'admin',36,'2014-09-17 16:11:58',0),
(531,'admin',36,'2014-09-18 16:27:30',0),
(532,'admin',36,'2014-09-19 11:35:39',0),
(533,'admin',36,'2014-09-19 11:36:43',0),
(534,'admin',36,'2014-09-19 11:47:18',0),
(535,'admin',36,'2014-09-19 11:49:12',0),
(536,'admin',36,'2014-09-19 12:14:25',0),
(537,'admin',36,'2014-09-19 12:14:42',0),
(538,'admin',36,'2014-09-19 12:23:29',0),
(539,'admin',36,'2014-09-19 12:47:42',0),
(540,'admin',36,'2014-09-19 13:47:49',0),
(541,'admin',36,'2014-09-19 15:43:01',0),
(542,'admin',36,'2014-09-19 15:45:44',0),
(543,'admin',36,'2014-09-19 17:29:44',0),
(544,'admin',36,'2014-09-19 17:39:05',0),
(545,'admin',36,'2014-09-19 17:40:01',0),
(546,'admin',36,'2014-09-19 17:41:44',0),
(547,'admin',36,'2014-09-19 18:16:23',0),
(548,'admin',36,'2014-09-19 19:19:30',0),
(549,'admin',36,'2014-09-20 08:23:11',0),
(550,'admin',36,'2014-09-20 08:24:48',0),
(551,'admin',36,'2014-09-20 10:18:20',0),
(552,'admin',36,'2014-09-20 10:18:39',0),
(553,'admin',36,'2014-09-20 10:20:06',0),
(554,'admin',36,'2014-09-23 09:35:07',0),
(555,'david',36,'2014-09-23 09:47:03',0),
(556,'david',36,'2014-09-23 09:49:30',0),
(557,'david',36,'2014-09-23 09:50:44',0),
(558,'david',36,'2014-09-23 09:50:48',0),
(559,'david',36,'2014-09-23 09:50:48',0),
(560,'david',36,'2014-09-23 09:51:26',0),
(561,'david',36,'2014-09-23 09:51:34',0),
(562,'david',36,'2014-09-23 09:51:34',0),
(563,'david',36,'2014-09-23 09:51:37',0),
(564,'david',36,'2014-09-23 09:51:38',0),
(565,'david',36,'2014-09-23 09:51:39',0),
(566,'david',36,'2014-09-23 09:51:40',0),
(567,'david',36,'2014-09-23 09:53:54',0),
(568,'david',36,'2014-09-23 09:55:01',0),
(569,'david',36,'2014-09-23 09:55:11',0),
(570,'david',36,'2014-09-23 09:55:11',0),
(571,'david',36,'2014-09-23 09:55:16',0),
(572,'david',36,'2014-09-23 09:55:16',0),
(573,'david',36,'2014-09-23 09:56:07',0),
(574,'david',36,'2014-09-23 09:57:22',0),
(575,'admin',36,'2014-09-23 09:57:31',0),
(576,'admin',36,'2014-09-26 12:37:45',0),
(577,'admin',36,'2014-09-26 12:38:16',0),
(578,'admin',36,'2014-09-26 12:38:17',0),
(579,'admin',36,'2014-09-26 12:38:34',0),
(580,'admin',36,'2014-09-26 12:38:35',0),
(581,'admin',36,'2014-09-26 12:38:45',0),
(582,'admin',36,'2014-09-26 12:38:46',0),
(583,'admin',36,'2014-09-29 13:50:31',0),
(584,'admin',38,'2014-09-29 13:50:39',0),
(585,'admin',38,'2014-09-29 13:50:51',0),
(586,'admin',38,'2014-09-29 13:50:55',0),
(587,'admin',38,'2014-09-29 13:51:12',0),
(588,'admin',36,'2014-09-29 13:52:15',0),
(589,'admin',36,'2014-09-29 13:52:21',0),
(590,'admin',38,'2014-09-29 13:52:25',0),
(591,'admin',38,'2014-09-29 15:18:07',0),
(592,'admin',38,'2014-09-29 15:19:01',0),
(593,'admin',38,'2014-09-29 15:25:46',0),
(594,'admin',38,'2014-09-29 15:29:10',0),
(595,'admin',36,'2014-09-29 15:30:17',0),
(596,'admin',38,'2014-09-29 15:38:59',0),
(597,'admin',38,'2014-09-29 15:39:44',0),
(598,'admin',38,'2014-09-29 15:40:13',0),
(599,'admin',38,'2014-09-29 15:40:53',0),
(600,'admin',39,'2014-09-30 10:33:43',0),
(601,'admin',39,'2014-09-30 10:33:54',0),
(602,'admin',39,'2014-09-30 10:33:57',0),
(603,'admin',40,'2014-09-30 10:34:03',0),
(604,'admin',40,'2014-09-30 10:34:18',0),
(605,'admin',36,'2014-09-30 10:34:55',0),
(606,'admin',36,'2014-09-30 10:35:04',0),
(607,'admin',42,'2014-09-30 10:37:00',0),
(608,'admin',42,'2014-09-30 10:37:21',0),
(609,'admin',42,'2014-09-30 10:40:41',0),
(610,'admin',42,'2014-09-30 10:40:53',0),
(611,'admin',42,'2014-09-30 11:13:51',0),
(612,'admin',39,'2014-09-30 11:16:55',0),
(613,'admin',42,'2014-09-30 11:30:19',0),
(614,'admin',42,'2014-09-30 16:05:30',0),
(615,'admin',42,'2014-09-30 16:06:00',0),
(616,'admin',42,'2014-09-30 16:06:18',0),
(617,'admin',38,'2014-09-30 16:06:27',0),
(618,'admin',42,'2014-09-30 16:09:22',0),
(619,'admin',42,'2014-09-30 16:15:58',0),
(620,'admin',42,'2014-10-02 14:05:09',0),
(621,'admin',42,'2014-10-03 10:39:47',0),
(622,'admin',42,'2014-10-03 10:40:18',0),
(623,'admin',42,'2014-10-03 10:42:08',0),
(624,'admin',42,'2014-10-03 10:42:31',0),
(625,'admin',42,'2014-10-03 13:32:03',0),
(626,'admin',42,'2014-10-08 13:05:31',0),
(627,'admin',42,'2014-10-09 09:03:44',0),
(628,'admin',42,'2014-10-09 09:04:53',0),
(629,'admin',42,'2014-10-09 09:05:32',0),
(630,'admin',42,'2014-10-09 09:05:53',0),
(631,'admin',42,'2014-10-09 09:06:25',0),
(632,'admin',42,'2014-10-09 11:41:14',0),
(633,'admin',42,'2014-10-09 11:51:00',0),
(634,'admin',42,'2014-10-09 11:51:16',0),
(635,'admin',42,'2014-10-09 11:51:16',0),
(636,'admin',42,'2014-10-09 11:51:26',0),
(637,'admin',42,'2014-10-09 11:51:26',0),
(638,'admin',42,'2014-10-09 11:51:35',0),
(639,'admin',42,'2014-10-09 11:51:35',0),
(640,'admin',37,'2014-10-09 16:43:53',0),
(641,'admin',37,'2014-10-09 16:44:03',0),
(642,'admin',37,'2014-10-09 16:44:08',0),
(643,'admin',37,'2014-10-09 16:46:29',0),
(644,'admin',45,'2014-10-09 18:18:46',0),
(645,'admin',45,'2014-10-09 18:19:07',0),
(646,'admin',51,'2014-10-10 12:19:19',0),
(647,'admin',51,'2014-10-10 12:19:59',0),
(648,'admin',51,'2014-10-10 12:19:59',0),
(649,'admin',51,'2014-10-10 12:20:43',0),
(650,'admin',51,'2014-10-10 12:23:00',0),
(651,'admin',51,'2014-10-10 12:23:17',0),
(652,'admin',51,'2014-10-10 12:24:52',0),
(653,'admin',51,'2014-10-10 12:24:54',0),
(654,'admin',51,'2014-10-10 12:26:13',0),
(655,'admin',51,'2014-10-10 12:26:40',0),
(656,'admin',51,'2014-10-10 12:27:10',0),
(657,'admin',51,'2014-10-10 12:27:39',0),
(658,'admin',51,'2014-10-10 12:27:50',0),
(659,'admin',51,'2014-10-10 12:27:58',0),
(660,'admin',51,'2014-10-10 12:28:39',0),
(661,'admin',51,'2014-10-10 12:28:39',0),
(662,'admin',51,'2014-10-10 12:29:10',0),
(663,'admin',51,'2014-10-10 12:30:22',0),
(664,'admin',51,'2014-10-10 12:31:27',0),
(665,'admin',51,'2014-10-10 12:33:11',0),
(666,'admin',51,'2014-10-10 12:33:32',0),
(667,'admin',51,'2014-10-10 13:34:25',0),
(668,'admin',51,'2014-10-10 13:54:22',0),
(669,'admin',51,'2014-10-10 14:07:31',0),
(670,'admin',51,'2014-10-10 14:07:38',0),
(671,'admin',51,'2014-10-10 14:07:46',0),
(672,'admin',50,'2014-10-10 14:07:48',0),
(673,'admin',51,'2014-10-10 14:53:15',0),
(674,'admin',51,'2014-10-10 14:56:01',0),
(675,'admin',51,'2014-10-10 14:56:45',0),
(676,'admin',51,'2014-10-10 14:57:46',0),
(677,'admin',51,'2014-10-10 14:58:44',0),
(678,'admin',50,'2014-10-10 14:59:02',0),
(679,'admin',50,'2014-10-10 15:06:35',0),
(680,'admin',51,'2014-10-10 15:06:46',0),
(681,'admin',51,'2014-10-10 15:07:12',0),
(682,'admin',51,'2014-10-10 15:07:13',0),
(683,'admin',51,'2014-10-10 15:07:49',0),
(684,'admin',51,'2014-10-10 15:08:19',0),
(685,'admin',50,'2014-10-10 15:09:11',0),
(686,'admin',50,'2014-10-10 15:09:54',0),
(687,'admin',51,'2014-10-10 15:10:01',0),
(688,'admin',51,'2014-10-10 15:11:36',0),
(689,'admin',51,'2014-10-10 15:12:44',0),
(690,'admin',51,'2014-10-10 15:13:52',0),
(691,'admin',51,'2014-10-10 15:13:57',0),
(692,'admin',51,'2014-10-10 15:14:48',0),
(693,'admin',52,'2014-10-10 15:21:10',0),
(694,'admin',52,'2014-10-10 15:23:20',0),
(695,'admin',52,'2014-10-10 15:24:20',0),
(696,'admin',51,'2014-10-10 15:24:30',0),
(697,'admin',50,'2014-10-10 15:24:42',0),
(698,'admin',52,'2014-10-10 15:25:22',0),
(699,'admin',51,'2014-10-10 15:26:18',0),
(700,'admin',51,'2014-10-10 15:33:13',0),
(701,'admin',53,'2014-10-10 15:33:17',0),
(702,'admin',53,'2014-10-10 15:34:19',0),
(703,'admin',51,'2014-10-10 15:35:26',0),
(704,'admin',53,'2014-10-10 15:36:19',0),
(705,'admin',53,'2014-10-10 15:36:52',0),
(706,'admin',53,'2014-10-10 15:37:25',0),
(707,'admin',54,'2014-10-10 15:42:25',0),
(708,'admin',53,'2014-10-10 15:43:01',0),
(709,'admin',54,'2014-10-10 15:43:07',0),
(710,'admin',54,'2014-10-10 15:44:35',0),
(711,'admin',54,'2014-10-10 15:44:57',0),
(712,'admin',53,'2014-10-10 17:05:43',0),
(713,'admin',53,'2014-10-10 17:06:58',0),
(714,'admin',53,'2014-10-10 17:08:14',0),
(715,'admin',50,'2014-10-10 17:31:23',0),
(716,'admin',54,'2014-10-10 18:09:34',0),
(717,'admin',54,'2014-10-10 18:10:44',0),
(718,'admin',54,'2014-10-10 18:13:03',0),
(719,'admin',50,'2014-10-10 18:15:01',0),
(720,'admin',51,'2014-10-10 18:15:07',0),
(721,'admin',54,'2014-10-10 18:16:19',0),
(722,'admin',54,'2014-10-10 18:16:23',0),
(723,'admin',54,'2014-10-10 18:16:35',0),
(724,'admin',54,'2014-10-10 18:19:14',0),
(725,'admin',54,'2014-10-10 18:24:51',0),
(726,'admin',54,'2014-10-10 18:26:37',0),
(727,'admin',54,'2014-10-10 18:27:13',0),
(728,'admin',54,'2014-10-10 18:36:16',0),
(729,'admin',54,'2014-10-10 18:37:32',0),
(730,'admin',54,'2014-10-10 19:14:19',0),
(731,'admin',54,'2014-10-10 19:14:19',0),
(732,'admin',51,'2014-10-10 19:22:29',0),
(733,'admin',51,'2014-10-10 19:26:52',0),
(734,'admin',51,'2014-10-10 19:28:12',0),
(735,'admin',51,'2014-10-10 19:33:10',0),
(736,'admin',54,'2014-10-10 19:36:56',0),
(737,'admin',53,'2014-10-10 19:37:29',0),
(738,'admin',54,'2014-10-10 19:37:46',0),
(739,'admin',42,'2014-10-10 19:38:40',0),
(740,'admin',54,'2014-10-10 20:23:12',0),
(741,'admin',54,'2014-10-10 20:24:25',0),
(742,'admin',54,'2014-10-10 20:24:33',0),
(743,'admin',51,'2014-10-10 20:34:14',0),
(744,'admin',54,'2014-10-10 20:53:40',0),
(745,'admin',50,'2014-10-10 20:54:14',0),
(746,'admin',50,'2014-10-10 20:57:36',0),
(747,'admin',50,'2014-10-10 20:58:08',0),
(748,'admin',51,'2014-10-10 20:58:27',0),
(749,'admin',54,'2014-10-10 20:58:30',0),
(750,'admin',53,'2014-10-10 20:58:33',0),
(751,'admin',54,'2014-10-10 20:58:36',0),
(752,'admin',53,'2014-10-10 20:58:40',0),
(753,'admin',52,'2014-10-10 20:58:41',0),
(754,'admin',54,'2014-10-10 20:58:57',0),
(755,'admin',53,'2014-10-10 20:59:03',0),
(756,'admin',54,'2014-10-10 20:59:32',0),
(757,'admin',54,'2014-10-10 21:00:02',0),
(758,'admin',54,'2014-10-11 17:18:21',0),
(759,'admin',52,'2014-10-11 17:19:50',0),
(760,'admin',53,'2014-10-11 17:19:58',0),
(761,'admin',54,'2014-10-11 17:20:19',0),
(762,'admin',42,'2014-10-11 17:27:14',0),
(763,'admin',42,'2014-10-11 17:34:43',0),
(764,'admin',54,'2014-10-11 17:51:09',0),
(765,'admin',51,'2014-10-11 17:52:23',0),
(766,'admin',51,'2014-10-11 17:54:22',0),
(767,'admin',38,'2014-10-11 17:54:52',0),
(768,'david',54,'2014-10-11 18:06:08',0),
(769,'david',54,'2014-10-11 18:13:53',0),
(770,'david',54,'2014-10-11 18:14:19',0),
(771,'david',54,'2014-10-11 18:14:19',0),
(772,'david',54,'2014-10-11 18:15:20',0),
(773,'admin',42,'2014-10-14 18:09:09',0),
(774,'admin',42,'2014-10-14 18:09:36',0),
(775,'admin',42,'2014-10-14 18:09:37',0),
(776,'admin',42,'2014-10-14 18:09:40',0),
(777,'admin',42,'2014-10-14 18:09:52',0),
(778,'admin',42,'2014-10-14 18:10:08',0),
(779,'admin',51,'2014-10-15 08:53:17',0),
(780,'admin',54,'2014-10-15 12:20:28',0),
(781,'admin',54,'2014-10-15 12:22:50',0),
(782,'admin',42,'2014-10-15 12:23:15',0),
(783,'admin',42,'2014-10-15 12:23:45',0),
(784,'admin',42,'2014-10-15 12:24:46',0),
(785,'admin',42,'2014-10-15 12:24:49',0),
(786,'admin',42,'2014-10-15 12:24:53',0),
(787,'admin',42,'2014-10-15 12:25:13',0),
(788,'admin',36,'2014-10-15 12:25:24',0),
(789,'admin',41,'2014-10-15 12:25:34',0),
(790,'admin',44,'2014-10-15 12:25:49',0),
(791,'admin',38,'2014-10-15 12:25:58',0),
(792,'admin',42,'2014-10-15 12:26:12',0),
(793,'admin',38,'2014-10-15 12:26:19',0),
(794,'admin',38,'2014-10-15 12:26:19',0),
(795,'admin',38,'2014-10-15 12:27:11',0),
(796,'admin',42,'2014-10-15 12:30:03',0),
(797,'admin',38,'2014-10-15 12:30:21',0),
(798,'admin',38,'2014-10-15 12:30:27',0),
(799,'admin',42,'2014-10-15 12:30:37',0),
(800,'admin',42,'2014-10-15 12:32:52',0),
(801,'admin',42,'2014-10-15 12:33:11',0),
(802,'admin',42,'2014-10-15 12:33:16',0),
(803,'admin',42,'2014-10-15 12:33:20',0),
(804,'admin',42,'2014-10-15 12:33:25',0),
(805,'admin',38,'2014-10-15 12:33:33',0),
(806,'admin',38,'2014-10-15 12:33:39',0),
(807,'admin',42,'2014-10-15 12:34:58',0),
(808,'admin',42,'2014-10-15 12:35:00',0),
(809,'admin',42,'2014-10-15 12:35:27',0),
(810,'admin',38,'2014-10-15 12:35:38',0),
(811,'admin',54,'2014-10-15 12:38:18',0),
(812,'admin',54,'2014-10-15 17:15:20',0),
(813,'admin',51,'2014-10-15 17:18:31',0),
(814,'admin',51,'2014-10-15 17:18:35',0),
(815,'admin',51,'2014-10-15 17:18:36',0),
(816,'admin',54,'2014-10-15 17:19:17',0),
(817,'admin',54,'2014-10-15 17:19:36',0),
(818,'admin',52,'2014-10-15 17:22:12',0),
(819,'admin',53,'2014-10-15 17:22:13',0),
(820,'admin',54,'2014-10-15 17:22:16',0),
(821,'admin',54,'2014-10-15 17:22:38',0),
(822,'admin',54,'2014-10-15 17:23:21',0),
(823,'admin',38,'2014-10-15 18:03:54',0),
(824,'admin',38,'2014-10-15 18:06:00',0),
(825,'admin',38,'2014-10-15 18:07:03',0),
(826,'admin',38,'2014-10-15 18:07:06',0),
(827,'admin',38,'2014-10-15 18:07:51',0),
(828,'admin',38,'2014-10-15 18:08:10',0),
(829,'admin',38,'2014-10-15 18:08:12',0),
(830,'admin',38,'2014-10-15 18:14:48',0),
(831,'admin',42,'2014-10-15 18:14:52',0),
(832,'admin',42,'2014-10-15 18:15:48',0),
(833,'admin',42,'2014-10-15 18:16:03',0),
(834,'admin',42,'2014-10-15 18:17:02',0),
(835,'admin',42,'2014-10-15 18:18:46',0),
(836,'admin',42,'2014-10-15 18:18:50',0),
(837,'admin',42,'2014-10-15 18:19:14',0),
(838,'admin',42,'2014-10-15 18:19:30',0),
(839,'admin',42,'2014-10-15 18:19:32',0),
(840,'admin',51,'2014-10-16 09:59:36',0),
(841,'admin',51,'2014-10-16 09:59:50',0),
(842,'admin',38,'2014-10-16 13:33:07',0),
(843,'admin',38,'2014-10-16 13:33:23',0),
(844,'admin',54,'2014-10-16 13:36:12',0),
(845,'admin',42,'2014-10-17 13:23:53',0),
(846,'admin',36,'2014-10-17 13:24:14',0),
(847,'admin',38,'2014-10-17 13:24:19',0),
(848,'admin',54,'2014-10-17 13:25:42',0),
(849,'admin',38,'2014-10-17 13:28:52',0),
(850,'admin',38,'2014-10-17 13:29:33',0),
(851,'admin',38,'2014-10-17 13:30:00',0),
(852,'admin',38,'2014-10-17 13:30:34',0),
(853,'admin',38,'2014-10-17 13:30:45',0),
(854,'admin',38,'2014-10-17 13:36:54',0),
(855,'admin',38,'2014-10-17 13:38:52',0),
(856,'admin',38,'2014-10-17 13:40:07',0),
(857,'admin',38,'2014-10-17 13:41:03',0),
(858,'david',38,'2014-10-17 13:42:48',0),
(859,'david',38,'2014-10-17 13:43:01',0),
(860,'david',38,'2014-10-17 13:43:42',0),
(861,'david',38,'2014-10-17 13:44:06',0),
(862,'admin',38,'2014-10-17 13:44:27',0),
(863,'admin',38,'2014-10-17 13:44:56',0),
(864,'admin',42,'2014-10-17 13:45:13',0),
(865,'admin',38,'2014-10-17 13:45:23',0),
(866,'admin',38,'2014-10-17 13:46:28',0),
(867,'admin',38,'2014-10-17 13:47:20',0),
(868,'admin',54,'2014-10-17 13:47:41',0),
(869,'admin',52,'2014-10-17 13:47:49',0),
(870,'admin',51,'2014-10-17 13:47:52',0),
(871,'admin',51,'2014-10-17 13:48:40',0),
(872,'david',38,'2014-10-17 13:48:50',0),
(873,'admin',51,'2014-10-17 13:49:13',0),
(874,'admin',51,'2014-10-17 13:49:30',0),
(875,'admin',51,'2014-10-17 13:49:58',0),
(876,'admin',51,'2014-10-17 13:50:17',0),
(877,'admin',51,'2014-10-17 13:52:25',0),
(878,'admin',51,'2014-10-17 13:52:46',0),
(879,'admin',51,'2014-10-17 13:53:18',0),
(880,'admin',51,'2014-10-17 13:54:11',0),
(881,'admin',51,'2014-10-17 13:54:57',0),
(882,'admin',51,'2014-10-17 13:56:10',0),
(883,'admin',51,'2014-10-17 13:56:33',0),
(884,'admin',51,'2014-10-17 13:56:48',0),
(885,'admin',51,'2014-10-17 13:57:09',0),
(886,'admin',51,'2014-10-17 13:57:40',0),
(887,'admin',51,'2014-10-17 13:58:21',0),
(888,'admin',51,'2014-10-17 13:58:54',0),
(889,'admin',51,'2014-10-17 14:02:13',0),
(890,'admin',51,'2014-10-17 14:02:34',0),
(891,'admin',51,'2014-10-17 14:02:51',0),
(892,'admin',51,'2014-10-17 14:03:12',0),
(893,'admin',51,'2014-10-17 14:03:21',0),
(894,'admin',51,'2014-10-17 14:03:40',0),
(895,'admin',51,'2014-10-17 14:03:51',0),
(896,'admin',54,'2014-10-17 16:54:56',0),
(897,'admin',54,'2014-10-17 17:08:43',0),
(898,'admin',38,'2014-10-17 17:12:46',0),
(899,'admin',54,'2014-10-18 01:07:33',0),
(900,'admin',54,'2014-10-18 01:11:30',0),
(901,'admin',54,'2014-10-18 01:11:34',0),
(902,'admin',54,'2014-10-18 01:11:43',0),
(903,'admin',54,'2014-10-18 01:14:13',0),
(904,'admin',54,'2014-10-18 01:15:09',0),
(905,'admin',54,'2014-10-18 01:15:17',0),
(906,'admin',54,'2014-10-18 01:15:21',0),
(907,'admin',54,'2014-10-18 01:16:01',0),
(908,'admin',54,'2014-10-18 01:16:05',0),
(909,'admin',54,'2014-10-18 01:16:16',0),
(910,'admin',54,'2014-10-18 01:16:20',0),
(911,'admin',54,'2014-10-18 01:16:21',0),
(912,'admin',54,'2014-10-18 01:16:23',0),
(913,'admin',54,'2014-10-18 01:16:58',0),
(914,'admin',54,'2014-10-18 01:17:03',0),
(915,'admin',54,'2014-10-18 01:17:05',0),
(916,'admin',51,'2014-10-20 08:53:33',0),
(917,'admin',38,'2014-10-20 17:54:41',0),
(918,'admin',38,'2014-10-20 17:55:37',0),
(919,'admin',38,'2014-10-20 17:55:45',0),
(920,'admin',54,'2014-10-21 08:56:32',0),
(921,'admin',54,'2014-10-21 08:57:43',0),
(922,'admin',54,'2014-10-21 09:23:07',0),
(923,'admin',54,'2014-10-21 09:35:02',0),
(924,'admin',54,'2014-10-21 09:36:07',0),
(925,'admin',38,'2014-10-21 09:57:59',0),
(926,'admin',38,'2014-10-21 11:38:22',0),
(927,'admin',36,'2014-10-21 11:38:31',0),
(928,'admin',41,'2014-10-21 11:38:35',0),
(929,'admin',44,'2014-10-21 11:38:41',0),
(930,'admin',42,'2014-10-21 11:38:48',0),
(931,'admin',42,'2014-10-21 11:39:10',0),
(932,'admin',54,'2014-10-21 11:39:14',0),
(933,'admin',38,'2014-10-21 11:42:19',0),
(934,'admin',38,'2014-10-21 13:26:16',0),
(935,'admin',38,'2014-10-21 13:26:21',0),
(936,'admin',38,'2014-10-21 13:26:31',0),
(937,'admin',38,'2014-10-21 13:26:38',0),
(938,'admin',38,'2014-10-21 13:26:46',0),
(939,'admin',38,'2014-10-21 14:53:37',0),
(940,'admin',38,'2014-10-21 14:56:13',0),
(941,'admin',54,'2014-10-21 18:02:49',0),
(942,'admin',54,'2014-10-21 18:06:01',0),
(943,'admin',54,'2014-10-21 18:06:02',0),
(944,'admin',54,'2014-10-21 18:06:12',0),
(945,'admin',54,'2014-10-21 18:06:12',0),
(946,'admin',38,'2014-10-21 18:06:15',0),
(947,'admin',54,'2014-10-21 18:06:38',0),
(948,'admin',54,'2014-10-22 11:13:36',0),
(949,'admin',54,'2014-10-22 12:54:57',0),
(950,'admin',54,'2014-10-22 12:56:23',0),
(951,'admin',54,'2014-10-22 12:57:37',0),
(952,'admin',54,'2014-10-22 13:13:43',0),
(953,'admin',54,'2014-10-22 13:14:14',0),
(954,'admin',54,'2014-10-22 13:16:28',0),
(955,'admin',54,'2014-10-22 13:17:12',0),
(956,'admin',54,'2014-10-22 13:17:14',0),
(957,'admin',54,'2014-10-22 13:17:28',0),
(958,'admin',54,'2014-10-22 13:18:42',0),
(959,'admin',54,'2014-10-22 13:19:37',0),
(960,'admin',54,'2014-10-22 13:20:02',0),
(961,'admin',54,'2014-10-22 13:20:22',0),
(962,'admin',54,'2014-10-22 13:22:54',0),
(963,'admin',54,'2014-10-22 13:22:57',0),
(964,'admin',54,'2014-10-22 13:25:16',0),
(965,'admin',54,'2014-10-22 13:25:54',0),
(966,'admin',54,'2014-10-22 13:26:24',0),
(967,'admin',54,'2014-10-22 13:26:52',0),
(968,'admin',54,'2014-10-22 13:27:16',0),
(969,'admin',54,'2014-10-22 13:27:36',0),
(970,'admin',54,'2014-10-22 15:45:36',0),
(971,'admin',54,'2014-10-22 16:54:32',0),
(972,'admin',52,'2014-10-22 16:54:38',0),
(973,'admin',54,'2014-10-22 16:54:41',0),
(974,'admin',54,'2014-10-22 17:00:24',0),
(975,'admin',54,'2014-10-22 17:34:01',0),
(976,'admin',54,'2014-10-22 17:37:45',0),
(977,'admin',54,'2014-10-22 17:40:39',0),
(978,'admin',38,'2014-10-22 17:48:02',0),
(979,'admin',42,'2014-10-22 17:48:07',0),
(980,'admin',42,'2014-10-22 17:49:08',0),
(981,'admin',41,'2014-10-22 17:49:24',0),
(982,'admin',41,'2014-10-22 17:49:41',0),
(983,'admin',51,'2014-10-23 08:35:18',0),
(984,'admin',51,'2014-10-23 11:28:22',0),
(985,'admin',51,'2014-10-23 11:29:07',0),
(986,'admin',51,'2014-10-23 11:30:52',0),
(987,'admin',51,'2014-10-23 11:33:31',0),
(988,'admin',51,'2014-10-23 11:36:10',0),
(989,'admin',51,'2014-10-23 11:36:57',0),
(990,'admin',51,'2014-10-23 11:43:45',0),
(991,'admin',51,'2014-10-23 11:44:03',0),
(992,'admin',51,'2014-10-23 11:44:04',0),
(993,'admin',51,'2014-10-23 11:46:12',0),
(994,'admin',51,'2014-10-23 11:47:01',0),
(995,'admin',51,'2014-10-23 11:47:01',0),
(996,'admin',51,'2014-10-23 11:47:16',0),
(997,'admin',51,'2014-10-23 11:51:56',0),
(998,'admin',51,'2014-10-23 12:25:33',0),
(999,'admin',57,'2014-10-23 13:44:27',0),
(1000,'admin',57,'2014-10-23 13:44:35',0),
(1001,'admin',51,'2014-10-23 16:44:26',0),
(1002,'admin',51,'2014-10-24 08:41:04',0),
(1003,'admin',51,'2014-10-24 11:03:57',0),
(1004,'admin',41,'2014-10-24 11:38:16',0),
(1005,'admin',42,'2014-10-24 11:38:25',0),
(1006,'admin',42,'2014-10-24 11:38:34',0),
(1007,'admin',36,'2014-10-24 11:38:48',0),
(1008,'admin',38,'2014-10-24 11:39:01',0),
(1009,'admin',38,'2014-10-24 11:39:22',0),
(1010,'admin',38,'2014-10-24 11:39:35',0),
(1011,'admin',38,'2014-10-24 11:39:46',0),
(1012,'admin',38,'2014-10-24 11:39:48',0),
(1013,'admin',38,'2014-10-24 11:39:49',0),
(1014,'admin',38,'2014-10-24 11:40:12',0),
(1015,'admin',38,'2014-10-24 11:40:25',0),
(1016,'admin',38,'2014-10-24 11:40:27',0),
(1017,'admin',54,'2014-10-27 12:36:36',0),
(1018,'admin',54,'2014-10-30 08:47:27',0),
(1019,'admin',54,'2014-10-30 08:48:20',0),
(1020,'admin',54,'2014-10-30 08:48:42',0),
(1021,'admin',54,'2014-10-30 08:48:51',0),
(1022,'admin',54,'2014-10-30 10:26:54',0),
(1023,'admin',54,'2014-10-30 10:27:22',0),
(1024,'admin',54,'2014-10-30 10:28:09',0),
(1025,'admin',54,'2014-10-30 10:28:22',0),
(1026,'admin',54,'2014-10-30 10:28:34',0),
(1027,'admin',54,'2014-10-30 11:17:15',0),
(1028,'admin',54,'2014-10-30 11:18:10',0),
(1029,'admin',54,'2014-10-30 11:18:55',0),
(1030,'admin',54,'2014-10-30 11:19:08',0),
(1031,'admin',54,'2014-10-30 11:19:26',0),
(1032,'admin',54,'2014-10-30 11:19:39',0),
(1033,'admin',54,'2014-10-30 11:39:08',0),
(1034,'admin',54,'2014-10-30 11:39:16',0),
(1035,'admin',54,'2014-10-30 11:39:27',0),
(1036,'admin',54,'2014-10-30 11:39:35',0),
(1037,'admin',38,'2014-10-30 16:57:38',0),
(1038,'admin',38,'2014-10-31 14:03:48',0),
(1039,'admin',60,'2014-10-31 14:04:00',0),
(1040,'admin',60,'2014-11-03 10:49:44',0),
(1041,'admin',60,'2014-11-03 10:50:15',0),
(1042,'admin',60,'2014-11-03 10:50:55',0),
(1043,'admin',59,'2014-11-03 10:51:00',0),
(1044,'admin',60,'2014-11-03 10:51:23',0),
(1045,'admin',60,'2014-11-03 10:51:59',0),
(1046,'admin',60,'2014-11-07 10:20:50',0),
(1047,'admin',60,'2014-11-07 10:21:13',0),
(1048,'admin',60,'2014-11-07 10:21:22',0),
(1049,'admin',60,'2014-11-07 10:22:32',0),
(1050,'admin',60,'2014-11-07 10:34:57',0),
(1051,'admin',38,'2014-11-07 10:39:34',0),
(1052,'admin',38,'2014-11-07 11:35:03',0),
(1053,'admin',60,'2014-11-07 12:16:06',0),
(1054,'admin',38,'2014-11-07 12:16:11',0),
(1055,'admin',38,'2014-11-07 12:16:16',0),
(1056,'admin',38,'2014-11-07 12:16:17',0),
(1057,'admin',38,'2014-11-11 14:46:54',0),
(1058,'admin',60,'2014-11-11 14:47:43',0),
(1059,'admin',54,'2014-11-11 14:47:50',0),
(1060,'admin',60,'2014-11-11 14:47:53',0),
(1061,'admin',60,'2014-11-11 14:48:47',0),
(1062,'admin',60,'2014-11-11 14:48:49',0),
(1063,'admin',60,'2014-11-11 14:48:51',0),
(1064,'admin',60,'2014-11-11 14:49:21',0),
(1065,'admin',60,'2014-11-11 14:50:49',0),
(1066,'admin',60,'2014-11-11 14:52:19',0),
(1067,'admin',60,'2014-11-11 14:52:21',0),
(1068,'admin',60,'2014-11-11 14:52:22',0),
(1069,'admin',60,'2014-11-11 14:52:27',0),
(1070,'admin',60,'2014-11-11 14:52:49',0),
(1071,'admin',56,'2014-11-12 10:03:10',0),
(1072,'admin',57,'2014-11-12 10:03:17',0),
(1073,'admin',42,'2014-11-12 10:03:30',0),
(1074,'admin',42,'2014-11-12 10:04:17',0),
(1075,'admin',60,'2014-11-12 10:08:36',0),
(1076,'admin',60,'2014-11-13 17:24:43',0),
(1077,'admin',60,'2014-11-13 17:24:50',0),
(1078,'admin',60,'2014-11-13 17:26:47',0),
(1079,'admin',61,'2014-11-13 18:08:49',0),
(1080,'admin',61,'2014-11-13 18:09:15',0),
(1081,'admin',61,'2014-11-13 18:10:50',0),
(1082,'admin',38,'2014-11-14 17:51:00',0),
(1083,'admin',38,'2014-11-14 17:51:56',0),
(1084,'admin',38,'2014-11-14 17:53:59',0),
(1085,'admin',38,'2014-11-14 17:55:13',0),
(1086,'admin',38,'2014-11-14 17:56:47',0),
(1087,'admin',38,'2014-11-14 17:56:48',0),
(1088,'admin',38,'2014-11-14 17:57:26',0),
(1089,'admin',38,'2014-11-14 17:57:28',0),
(1090,'admin',38,'2014-11-14 17:57:29',0),
(1091,'admin',38,'2014-11-14 17:57:35',0),
(1092,'admin',38,'2014-11-14 19:54:12',0),
(1093,'admin',61,'2014-11-14 19:58:09',0),
(1094,'admin',61,'2014-11-14 20:17:32',0),
(1095,'admin',61,'2014-11-14 20:20:15',0),
(1096,'admin',38,'2014-11-14 20:51:46',0),
(1097,'david',61,'2014-11-18 13:50:49',0),
(1098,'admin',61,'2014-11-18 17:20:15',0),
(1099,'20266370N',61,'2014-11-19 11:14:51',0),
(1100,'david',61,'2014-11-20 08:53:16',0),
(1101,'david',61,'2014-11-20 08:55:23',0),
(1102,'admin',61,'2014-11-20 10:17:43',0),
(1103,'admin',61,'2014-11-20 10:37:22',0),
(1104,'david',61,'2014-11-20 14:33:49',0),
(1105,'david',61,'2014-11-20 14:34:07',0),
(1106,'david',61,'2014-11-20 14:34:41',0),
(1107,'david',38,'2014-11-20 14:35:12',0),
(1108,'david',38,'2014-11-20 14:35:20',0),
(1109,'david',61,'2014-11-20 15:49:02',0),
(1110,'admin',61,'2014-11-20 16:15:27',0),
(1111,'admin',61,'2014-11-20 16:16:55',0),
(1112,'admin',61,'2014-11-20 16:20:33',0),
(1113,'admin',38,'2014-11-20 16:23:00',0),
(1114,'admin',38,'2014-11-20 16:25:06',0),
(1115,'admin',38,'2014-11-20 16:25:51',0),
(1116,'admin',61,'2014-11-20 16:45:32',0),
(1117,'admin',61,'2014-11-20 17:14:37',0),
(1118,'admin',61,'2014-11-21 12:27:54',0),
(1119,'admin',61,'2014-11-21 13:08:19',0),
(1120,'admin',61,'2014-11-21 13:08:54',0),
(1121,'admin',61,'2014-11-21 13:09:28',0),
(1122,'admin',38,'2014-11-28 13:09:29',0),
(1123,'admin',38,'2014-11-28 13:09:42',0),
(1124,'admin',38,'2014-11-28 13:10:01',0),
(1125,'admin',38,'2014-11-28 13:10:10',0),
(1126,'admin',38,'2014-11-28 13:10:13',0),
(1127,'admin',38,'2014-11-28 13:10:34',0),
(1128,'admin',38,'2014-11-28 13:11:10',0),
(1129,'admin',38,'2014-11-28 13:11:13',0),
(1130,'admin',38,'2014-11-28 13:11:24',0),
(1131,'admin',38,'2014-11-28 13:11:34',0),
(1132,'admin',38,'2014-11-28 13:11:59',0),
(1133,'admin',38,'2014-11-28 13:14:44',0),
(1134,'admin',38,'2014-11-28 13:16:18',0),
(1135,'david',41,'2014-11-28 13:17:09',0),
(1136,'david',41,'2014-11-28 13:17:29',0),
(1137,'admin',38,'2014-11-28 13:19:17',0),
(1138,'admin',38,'2014-11-28 13:20:52',0),
(1139,'admin',38,'2014-11-28 13:20:59',0),
(1140,'david',64,'2014-11-28 14:09:16',0),
(1141,'david',64,'2014-11-28 14:09:56',0),
(1142,'david',61,'2014-11-28 17:03:57',0),
(1143,'david',64,'2014-11-28 18:02:12',0),
(1144,'david',64,'2014-11-28 18:02:25',0),
(1145,'admin',61,'2014-11-28 18:19:58',0),
(1146,'admin',61,'2014-11-28 18:20:19',0),
(1147,'admin',61,'2014-11-28 18:20:19',0),
(1148,'admin',61,'2014-11-28 18:21:22',0),
(1149,'admin',61,'2014-11-28 18:21:22',0),
(1150,'admin',61,'2014-11-28 18:22:03',0),
(1151,'admin',61,'2014-11-28 18:22:18',0),
(1152,'admin',61,'2014-11-28 18:22:18',0),
(1153,'admin',61,'2014-11-28 18:22:26',0),
(1154,'admin',64,'2014-11-28 18:23:13',0),
(1155,'admin',64,'2014-11-28 18:23:55',0),
(1156,'admin',64,'2014-11-28 19:31:32',0),
(1157,'admin',64,'2014-11-28 19:32:09',0),
(1158,'admin',64,'2014-11-28 19:47:44',0),
(1159,'admin',64,'2014-11-28 19:48:18',0),
(1160,'admin',64,'2014-11-28 19:49:20',0),
(1161,'admin',64,'2014-11-28 19:50:11',0),
(1162,'admin',64,'2014-11-28 19:50:28',0),
(1163,'admin',64,'2014-11-28 19:51:02',0),
(1164,'admin',64,'2014-11-28 19:52:10',0),
(1165,'admin',64,'2014-11-28 19:56:36',0),
(1166,'admin',64,'2014-11-28 19:57:52',0),
(1167,'admin',64,'2014-11-28 20:00:13',0),
(1168,'admin',64,'2014-11-28 20:00:45',0),
(1169,'admin',64,'2014-11-28 20:01:30',0),
(1170,'admin',64,'2014-11-28 20:02:01',0),
(1171,'admin',64,'2014-11-28 20:06:15',0),
(1172,'admin',64,'2014-11-28 20:06:42',0),
(1173,'admin',64,'2014-11-29 00:39:28',0),
(1174,'admin',61,'2014-11-29 00:40:51',0),
(1175,'admin',61,'2014-11-29 00:43:32',0),
(1176,'admin',61,'2014-11-29 00:43:50',0),
(1177,'admin',61,'2014-11-29 00:44:00',0),
(1178,'admin',61,'2014-11-29 00:44:56',0),
(1179,'admin',61,'2014-11-29 00:45:23',0),
(1180,'admin',61,'2014-11-29 00:45:59',0),
(1181,'admin',61,'2014-11-29 00:46:02',0),
(1182,'admin',61,'2014-11-29 00:46:03',0),
(1183,'admin',61,'2014-11-29 00:46:17',0),
(1184,'admin',61,'2014-11-29 00:48:52',0),
(1185,'admin',61,'2014-11-29 00:49:16',0),
(1186,'admin',61,'2014-11-29 00:49:46',0),
(1187,'admin',61,'2014-11-29 00:49:56',0),
(1188,'admin',64,'2014-12-03 13:30:02',0),
(1189,'admin',64,'2014-12-03 13:30:07',0),
(1190,'admin',64,'2014-12-04 13:06:20',0),
(1191,'admin',64,'2014-12-04 13:11:09',0),
(1192,'admin',64,'2014-12-04 13:11:50',0),
(1193,'admin',64,'2014-12-04 13:12:27',0),
(1194,'admin',64,'2014-12-04 13:12:54',0),
(1195,'admin',64,'2014-12-04 13:13:05',0),
(1196,'admin',64,'2014-12-04 13:13:42',0),
(1197,'admin',64,'2014-12-04 13:13:50',0),
(1198,'admin',64,'2014-12-04 13:22:38',0),
(1199,'admin',64,'2014-12-04 13:22:46',0),
(1200,'admin',61,'2014-12-04 17:43:47',0),
(1201,'admin',61,'2014-12-05 13:46:17',0),
(1202,'admin',61,'2014-12-16 17:15:55',0),
(1203,'admin',61,'2014-12-18 09:47:03',0),
(1204,'admin',61,'2014-12-18 09:47:11',0),
(1205,'admin',61,'2014-12-18 09:48:45',0),
(1206,'admin',61,'2014-12-18 09:48:59',0),
(1207,'admin',61,'2014-12-18 09:49:42',0),
(1208,'admin',61,'2014-12-18 09:49:48',0),
(1209,'admin',61,'2014-12-18 09:51:39',0),
(1210,'admin',61,'2014-12-18 09:51:59',0),
(1211,'admin',61,'2014-12-18 09:52:05',0),
(1212,'admin',61,'2014-12-18 09:53:21',0),
(1213,'admin',61,'2014-12-18 09:53:32',0),
(1214,'admin',61,'2014-12-18 09:53:48',0),
(1215,'admin',61,'2014-12-18 09:56:02',0),
(1216,'admin',61,'2014-12-18 09:56:43',0),
(1217,'admin',61,'2014-12-18 10:01:07',0),
(1218,'admin',61,'2014-12-18 10:03:01',0),
(1219,'admin',61,'2014-12-18 10:03:03',0),
(1220,'admin',61,'2014-12-18 10:03:05',0),
(1221,'admin',61,'2014-12-18 10:03:16',0),
(1222,'admin',61,'2014-12-18 10:04:07',0),
(1223,'admin',61,'2014-12-18 10:06:41',0),
(1224,'admin',61,'2014-12-18 10:06:52',0),
(1225,'admin',61,'2014-12-18 10:07:48',0),
(1226,'admin',61,'2014-12-18 10:08:37',0),
(1227,'admin',61,'2014-12-18 10:08:41',0),
(1228,'admin',61,'2014-12-18 10:09:25',0),
(1229,'admin',61,'2014-12-18 10:10:59',0),
(1230,'admin',61,'2014-12-18 10:11:26',0),
(1231,'admin',61,'2014-12-18 10:12:44',0),
(1232,'admin',61,'2014-12-18 10:13:01',0),
(1233,'admin',61,'2014-12-18 10:13:21',0),
(1234,'admin',61,'2014-12-18 10:13:58',0),
(1235,'admin',61,'2014-12-18 10:14:14',0),
(1236,'admin',61,'2014-12-18 10:14:17',0),
(1237,'admin',61,'2014-12-18 10:15:49',0),
(1238,'admin',61,'2014-12-18 10:16:13',0),
(1239,'admin',61,'2014-12-18 10:16:17',0),
(1240,'admin',61,'2014-12-18 10:16:27',0),
(1241,'admin',61,'2014-12-18 10:17:22',0),
(1242,'admin',61,'2014-12-18 10:18:10',0),
(1243,'admin',61,'2014-12-18 10:18:14',0),
(1244,'admin',61,'2014-12-18 10:19:23',0),
(1245,'admin',61,'2014-12-18 10:19:41',0),
(1246,'admin',61,'2014-12-18 10:19:42',0),
(1247,'admin',61,'2014-12-18 10:20:07',0),
(1248,'admin',61,'2014-12-18 10:20:24',0),
(1249,'admin',61,'2014-12-18 10:20:36',0),
(1250,'admin',61,'2014-12-18 10:23:53',0),
(1251,'admin',61,'2014-12-18 10:24:05',0),
(1252,'admin',61,'2014-12-18 10:24:07',0),
(1253,'admin',61,'2014-12-18 10:24:24',0),
(1254,'admin',61,'2014-12-18 10:24:26',0),
(1255,'admin',61,'2014-12-18 10:24:44',0),
(1256,'admin',61,'2014-12-18 10:25:10',0),
(1257,'admin',61,'2014-12-18 10:26:10',0),
(1258,'admin',61,'2014-12-18 10:26:15',0),
(1259,'admin',61,'2014-12-18 10:26:17',0),
(1260,'admin',61,'2014-12-18 10:26:44',0),
(1261,'admin',61,'2014-12-18 10:26:47',0),
(1262,'admin',61,'2014-12-18 10:27:14',0),
(1263,'admin',61,'2014-12-18 10:27:31',0),
(1264,'admin',61,'2014-12-18 10:27:42',0),
(1265,'admin',61,'2014-12-18 10:51:13',0),
(1266,'admin',60,'2014-12-18 10:52:02',0),
(1267,'admin',61,'2014-12-18 10:52:06',0),
(1268,'admin',59,'2014-12-18 10:52:08',0),
(1269,'admin',60,'2014-12-18 11:17:11',0),
(1270,'admin',53,'2014-12-18 12:28:43',0),
(1271,'admin',52,'2014-12-18 12:28:47',0),
(1272,'admin',54,'2014-12-18 12:28:51',0),
(1273,'admin',54,'2014-12-18 12:36:49',0),
(1274,'admin',54,'2014-12-18 12:37:07',0),
(1275,'admin',54,'2014-12-18 12:37:31',0),
(1276,'admin',54,'2014-12-18 12:38:05',0),
(1277,'admin',61,'2014-12-18 12:41:12',0),
(1278,'admin',61,'2014-12-18 12:42:56',0),
(1279,'admin',61,'2014-12-18 12:44:31',0),
(1280,'admin',61,'2014-12-18 12:45:09',0),
(1281,'admin',61,'2014-12-18 12:46:26',0),
(1282,'admin',61,'2014-12-18 12:48:29',0),
(1283,'admin',51,'2014-12-18 12:49:39',0),
(1284,'admin',51,'2014-12-18 12:50:11',0),
(1285,'admin',51,'2014-12-18 12:50:22',0),
(1286,'admin',51,'2014-12-18 12:51:39',0),
(1287,'admin',51,'2014-12-18 12:52:02',0),
(1288,'admin',51,'2014-12-18 12:52:20',0),
(1289,'admin',61,'2014-12-18 12:52:56',0),
(1290,'admin',61,'2014-12-18 12:53:13',0),
(1291,'admin',64,'2014-12-22 08:52:53',0),
(1292,'admin',61,'2014-12-22 08:53:00',0),
(1293,'admin',61,'2014-12-22 08:53:35',0),
(1294,'admin',61,'2014-12-22 08:53:50',0),
(1295,'admin',41,'2014-12-22 08:55:30',0),
(1296,'admin',36,'2014-12-22 08:55:37',0),
(1297,'admin',45,'2014-12-22 08:55:53',0),
(1298,'admin',61,'2014-12-22 08:56:22',0),
(1299,'admin',61,'2014-12-22 13:03:33',0),
(1300,'admin',61,'2014-12-23 19:35:24',0),
(1301,'admin',61,'2014-12-23 19:35:38',0),
(1302,'admin',61,'2014-12-23 20:07:50',0),
(1303,'admin',61,'2014-12-23 20:08:30',0),
(1304,'admin',61,'2014-12-23 20:21:34',0),
(1305,'admin',61,'2014-12-23 20:22:30',0),
(1306,'admin',61,'2014-12-23 20:22:32',0),
(1307,'admin',61,'2014-12-23 20:25:11',0),
(1308,'admin',61,'2014-12-23 20:25:38',0),
(1309,'admin',61,'2014-12-23 20:25:54',0),
(1310,'admin',61,'2014-12-23 20:26:32',0),
(1311,'admin',61,'2014-12-23 20:26:56',0),
(1312,'admin',61,'2014-12-24 00:01:32',0),
(1313,'admin',61,'2014-12-24 00:03:28',0),
(1314,'admin',61,'2014-12-24 00:04:13',0),
(1315,'admin',54,'2014-12-24 00:04:50',0),
(1316,'admin',51,'2014-12-24 00:10:45',0),
(1317,'admin',50,'2014-12-24 00:13:52',0),
(1318,'admin',61,'2014-12-24 00:24:48',0),
(1319,'admin',61,'2014-12-24 01:38:05',0),
(1320,'admin',61,'2014-12-24 02:08:40',0),
(1321,'dgarcia',61,'2014-12-31 08:29:59',0),
(1322,'pedro',60,'2015-01-21 13:59:30',0),
(1323,'admin',69,'2015-01-21 14:01:43',0),
(1324,'pedro',60,'2015-01-21 14:01:53',0),
(1325,'admin',69,'2015-01-21 14:03:57',0),
(1326,'admin',69,'2015-01-21 14:04:46',0),
(1327,'pedro',60,'2015-01-21 14:05:02',0),
(1328,'pedro',60,'2015-01-21 14:05:56',0),
(1329,'pedro',60,'2015-01-21 14:06:25',0),
(1330,'pedro',60,'2015-01-21 14:06:53',0),
(1331,'admin',69,'2015-01-21 14:06:58',0),
(1332,'admin',69,'2015-01-21 14:07:00',0),
(1333,'pedro',60,'2015-01-21 14:07:05',0),
(1334,'pedro',60,'2015-01-21 14:07:07',0),
(1335,'pedro',60,'2015-01-21 14:07:08',0),
(1336,'admin',69,'2015-01-21 14:10:08',0),
(1337,'admin',69,'2015-01-21 14:10:15',0),
(1338,'admin',69,'2015-01-21 14:12:19',0),
(1339,'pedro',60,'2015-01-21 14:13:55',0),
(1340,'admin',69,'2015-01-21 14:14:07',0),
(1341,'admin',69,'2015-01-28 16:08:36',0),
(1342,'dcancho',72,'2015-02-17 10:07:02',0),
(1343,'dcancho',72,'2015-02-17 10:07:13',0),
(1344,'dcancho',72,'2015-02-17 10:07:16',0),
(1345,'dcancho',38,'2015-02-17 10:07:31',0),
(1346,'dcancho',38,'2015-02-17 10:08:04',0),
(1347,'admin',69,'2015-02-18 13:35:59',0),
(1348,'admin',69,'2015-02-18 13:37:09',0),
(1349,'admin',54,'2015-02-18 13:37:20',0),
(1350,'admin',54,'2015-02-18 13:40:19',0),
(1351,'admin',69,'2015-02-19 10:04:51',0),
(1352,'admin',61,'2015-02-19 10:04:56',0),
(1353,'admin',61,'2015-02-19 10:05:07',0),
(1354,'admin',61,'2015-02-19 10:05:07',0),
(1355,'admin',69,'2015-02-27 10:00:02',0),
(1356,'admin',69,'2015-02-27 10:28:26',0),
(1357,'admin',69,'2015-02-27 11:07:26',0),
(1358,'admin',69,'2015-02-27 11:07:47',0),
(1359,'admin',69,'2015-02-27 11:07:53',0),
(1360,'admin',69,'2015-02-27 11:09:56',0),
(1361,'admin',69,'2015-02-27 11:15:13',0),
(1362,'admin',69,'2015-02-27 11:19:58',0),
(1363,'admin',69,'2015-02-27 12:08:20',0),
(1364,'admin',68,'2015-02-27 12:08:29',0),
(1365,'admin',61,'2015-02-27 12:08:31',0),
(1366,'admin',68,'2015-02-27 12:08:35',0),
(1367,'admin',69,'2015-02-27 12:12:18',0),
(1368,'admin',68,'2015-02-27 12:12:20',0),
(1369,'admin',61,'2015-02-27 12:12:22',0),
(1370,'admin',68,'2015-02-27 12:12:27',0),
(1371,'admin',61,'2015-02-27 12:12:31',0),
(1372,'admin',61,'2015-02-27 12:12:39',0),
(1373,'admin',61,'2015-02-27 12:12:40',0),
(1374,'admin',60,'2015-02-27 12:12:44',0),
(1375,'admin',61,'2015-02-27 12:12:48',0),
(1376,'admin',61,'2015-02-27 12:12:51',0),
(1377,'admin',61,'2015-02-27 12:12:52',0),
(1378,'admin',60,'2015-02-27 12:13:03',0),
(1379,'admin',59,'2015-02-27 12:13:08',0),
(1380,'admin',54,'2015-02-27 12:13:10',0),
(1381,'admin',54,'2015-02-27 12:13:15',0),
(1382,'admin',54,'2015-02-27 12:13:16',0),
(1383,'admin',53,'2015-02-27 12:13:32',0),
(1384,'admin',52,'2015-02-27 12:13:37',0),
(1385,'admin',53,'2015-02-27 12:13:41',0),
(1386,'admin',54,'2015-02-27 12:13:42',0),
(1387,'admin',54,'2015-02-27 12:13:48',0),
(1388,'admin',54,'2015-02-27 12:13:49',0),
(1389,'admin',54,'2015-02-27 12:14:19',0),
(1390,'admin',53,'2015-02-27 12:14:24',0),
(1391,'admin',54,'2015-02-27 12:14:27',0),
(1392,'admin',54,'2015-02-27 12:14:43',0),
(1393,'admin',54,'2015-02-27 12:14:43',0),
(1394,'admin',54,'2015-02-27 12:14:51',0),
(1395,'admin',54,'2015-02-27 12:14:51',0),
(1396,'admin',59,'2015-02-27 12:17:05',0),
(1397,'admin',54,'2015-02-27 12:17:08',0),
(1398,'admin',54,'2015-02-27 12:19:04',0),
(1399,'admin',54,'2015-02-27 12:19:19',0),
(1400,'admin',54,'2015-02-27 12:19:26',0),
(1401,'admin',54,'2015-02-27 12:19:27',0),
(1402,'admin',59,'2015-02-27 12:21:15',0),
(1403,'admin',54,'2015-02-27 12:21:16',0),
(1404,'admin',54,'2015-02-27 12:21:25',0),
(1405,'admin',54,'2015-02-27 12:21:25',0),
(1406,'admin',54,'2015-02-27 12:21:43',0),
(1407,'admin',54,'2015-02-27 12:23:00',0),
(1408,'admin',54,'2015-02-27 12:23:13',0),
(1409,'admin',54,'2015-02-27 12:23:14',0),
(1410,'admin',59,'2015-02-27 12:24:35',0),
(1411,'admin',54,'2015-02-27 12:24:37',0),
(1412,'admin',54,'2015-02-27 12:25:42',0),
(1413,'admin',54,'2015-02-27 12:25:43',0),
(1414,'admin',54,'2015-02-27 12:26:10',0),
(1415,'admin',54,'2015-02-27 12:26:14',0),
(1416,'admin',54,'2015-02-27 12:26:15',0),
(1417,'admin',54,'2015-02-27 12:27:48',0),
(1418,'admin',54,'2015-02-27 12:27:54',0),
(1419,'admin',54,'2015-02-27 12:27:55',0),
(1420,'admin',69,'2015-02-27 12:29:54',0),
(1421,'admin',61,'2015-02-27 12:29:57',0),
(1422,'admin',69,'2015-02-27 14:07:38',0),
(1423,'admin',64,'2015-02-27 14:12:47',0),
(1424,'admin',69,'2015-02-27 14:13:14',0),
(1425,'admin',68,'2015-02-27 14:13:20',0),
(1426,'admin',61,'2015-02-27 14:13:23',0),
(1427,'admin',60,'2015-02-27 14:13:26',0),
(1428,'admin',56,'2015-02-27 14:14:28',0),
(1429,'claudio',69,'2015-02-28 00:24:23',0),
(1430,'admin',69,'2015-02-28 00:25:25',0),
(1431,'admin',69,'2015-02-28 00:28:38',0),
(1432,'admin',69,'2015-02-28 00:28:38',0),
(1433,'admin',69,'2015-02-28 00:29:03',0),
(1434,'admin',69,'2015-02-28 00:29:04',0),
(1435,'admin',69,'2015-02-28 00:29:12',0),
(1436,'admin',69,'2015-02-28 00:29:13',0),
(1437,'dcancho',60,'2015-02-28 00:30:48',0),
(1438,'dcancho',60,'2015-02-28 00:31:09',0),
(1439,'dcancho',60,'2015-02-28 00:31:09',0),
(1440,'dcancho',50,'2015-02-28 00:31:22',0),
(1441,'dcancho',50,'2015-02-28 00:31:54',0),
(1442,'dcancho',50,'2015-02-28 00:31:54',0),
(1443,'claudio',40,'2015-02-28 00:38:31',0),
(1444,'claudio',40,'2015-02-28 00:39:36',0),
(1445,'claudio',69,'2015-02-28 00:41:35',0),
(1446,'claudio',69,'2015-02-28 00:42:14',0),
(1447,'claudio',69,'2015-02-28 00:42:14',0),
(1448,'claudio',73,'2015-02-28 00:44:04',0),
(1449,'claudio',73,'2015-02-28 00:44:20',0),
(1450,'dcancho',64,'2015-02-28 00:58:49',0),
(1451,'dcancho',64,'2015-02-28 00:59:13',0),
(1452,'admin',69,'2015-03-02 10:38:40',0),
(1453,'admin',68,'2015-03-02 10:38:44',0),
(1454,'admin',69,'2015-03-02 10:38:47',0),
(1455,'admin',69,'2015-03-02 10:38:53',0),
(1456,'admin',69,'2015-03-02 10:43:49',0),
(1457,'admin',69,'2015-03-02 10:46:14',0),
(1458,'admin',69,'2015-03-02 10:46:27',0),
(1459,'admin',69,'2015-03-02 10:46:27',0),
(1460,'admin',69,'2015-03-02 10:46:33',0),
(1461,'admin',69,'2015-03-02 10:46:34',0),
(1462,'admin',69,'2015-03-02 10:46:38',0),
(1463,'admin',69,'2015-03-02 10:46:39',0),
(1464,'admin',69,'2015-03-02 10:46:43',0),
(1465,'admin',69,'2015-03-02 10:46:43',0),
(1466,'admin',71,'2015-03-02 10:47:02',0),
(1467,'admin',69,'2015-03-02 10:51:37',0),
(1468,'admin',69,'2015-03-02 11:45:17',0),
(1469,'admin',68,'2015-03-02 11:45:22',0),
(1470,'admin',69,'2015-03-02 11:47:02',0),
(1471,'admin',71,'2015-03-02 11:48:48',0),
(1472,'admin',69,'2015-03-02 11:48:54',0),
(1473,'admin',74,'2015-03-05 17:55:48',0),
(1474,'admin',74,'2015-03-05 17:56:31',0),
(1475,'admin',74,'2015-03-05 17:56:59',0),
(1476,'admin',74,'2015-03-05 17:57:20',0),
(1477,'admin',69,'2015-03-13 18:33:17',0),
(1478,'admin',69,'2015-03-13 18:57:36',0),
(1479,'admin',69,'2015-03-13 19:00:17',0),
(1480,'admin',69,'2015-03-14 00:20:46',0),
(1481,'admin',69,'2015-03-14 00:21:16',0),
(1482,'admin',69,'2015-03-14 00:41:51',0),
(1483,'admin',69,'2015-03-14 00:45:27',0),
(1484,'admin',69,'2015-03-14 00:45:55',0),
(1485,'admin',69,'2015-03-14 00:45:57',0),
(1486,'admin',69,'2015-03-14 23:34:52',0),
(1487,'admin',74,'2015-03-15 03:02:58',0),
(1488,'admin',74,'2015-03-15 03:03:04',0),
(1489,'admin',69,'2015-03-15 03:05:13',0),
(1490,'admin',69,'2015-03-15 03:15:05',0),
(1491,'admin',69,'2015-03-16 12:30:56',0),
(1492,'admin',69,'2015-03-18 08:43:55',0),
(1493,'claudio',40,'2015-03-18 10:31:38',0),
(1494,'claudio',69,'2015-03-18 10:46:03',0),
(1495,'admin',69,'2015-03-20 13:21:13',0),
(1496,'admin',69,'2015-03-20 17:58:06',0),
(1497,'admin',69,'2015-03-20 17:59:58',0),
(1498,'admin',69,'2015-03-20 18:02:22',0),
(1499,'admin',69,'2015-03-20 18:02:47',0),
(1500,'admin',69,'2015-03-20 18:03:06',0),
(1501,'admin',69,'2015-03-20 18:07:20',0),
(1502,'admin',69,'2015-03-20 18:08:34',0),
(1503,'admin',69,'2015-03-20 18:10:43',0),
(1504,'admin',69,'2015-03-20 18:10:45',0),
(1505,'admin',50,'2015-03-20 18:12:06',0),
(1506,'admin',50,'2015-03-20 18:13:46',0),
(1507,'admin',51,'2015-03-20 18:21:25',0),
(1508,'admin',69,'2015-03-20 18:31:38',0),
(1509,'admin',69,'2015-03-20 18:31:57',0),
(1510,'admin',68,'2015-03-20 18:32:01',0),
(1511,'admin',61,'2015-03-20 18:32:04',0),
(1512,'admin',61,'2015-03-20 18:32:48',0),
(1513,'admin',60,'2015-03-20 18:32:57',0),
(1514,'admin',59,'2015-03-20 18:32:58',0),
(1515,'admin',54,'2015-03-20 18:32:59',0),
(1516,'admin',53,'2015-03-20 18:33:01',0),
(1517,'admin',54,'2015-03-20 18:33:05',0),
(1518,'admin',53,'2015-03-20 18:33:10',0),
(1519,'admin',53,'2015-03-20 18:33:50',0),
(1520,'admin',54,'2015-03-20 18:33:54',0),
(1521,'admin',53,'2015-03-20 18:34:02',0),
(1522,'admin',52,'2015-03-20 18:34:04',0),
(1523,'admin',52,'2015-03-20 18:35:59',0),
(1524,'admin',52,'2015-03-20 18:36:37',0),
(1525,'admin',52,'2015-03-20 18:37:27',0),
(1526,'admin',54,'2015-03-20 18:38:01',0),
(1527,'admin',54,'2015-03-20 18:39:07',0),
(1528,'admin',52,'2015-03-20 18:42:36',0),
(1529,'admin',52,'2015-03-20 18:43:11',0),
(1530,'admin',52,'2015-03-20 18:55:24',0),
(1531,'admin',52,'2015-03-20 18:55:42',0),
(1532,'admin',52,'2015-03-20 18:57:07',0),
(1533,'admin',50,'2015-03-20 18:57:35',0),
(1534,'admin',50,'2015-03-20 19:01:50',0),
(1535,'admin',50,'2015-03-20 19:07:35',0),
(1536,'admin',50,'2015-03-20 19:08:20',0),
(1537,'admin',50,'2015-03-20 19:08:39',0),
(1538,'admin',50,'2015-03-20 19:08:57',0),
(1539,'admin',50,'2015-03-20 19:28:15',0),
(1540,'admin',51,'2015-03-20 19:28:20',0),
(1541,'admin',50,'2015-03-20 19:28:25',0),
(1542,'admin',51,'2015-03-20 19:28:31',0),
(1543,'admin',52,'2015-03-20 19:28:35',0),
(1544,'admin',69,'2015-03-20 19:29:28',0),
(1545,'admin',61,'2015-03-20 19:29:38',0),
(1546,'admin',61,'2015-03-20 19:30:34',0),
(1547,'admin',61,'2015-03-20 19:30:54',0),
(1548,'admin',61,'2015-03-20 19:31:02',0),
(1549,'admin',61,'2015-03-20 19:31:16',0),
(1550,'admin',60,'2015-03-20 19:31:26',0),
(1551,'admin',60,'2015-03-20 19:31:37',0),
(1552,'admin',60,'2015-03-20 19:31:58',0),
(1553,'admin',60,'2015-03-20 19:31:59',0),
(1554,'admin',74,'2015-03-20 19:32:18',0),
(1555,'admin',69,'2015-03-20 19:33:08',0),
(1556,'admin',69,'2015-03-20 19:33:22',0),
(1557,'admin',69,'2015-04-06 17:11:28',0),
(1558,'admin',69,'2015-04-06 17:11:29',0),
(1559,'admin',69,'2015-04-06 17:11:32',0),
(1560,'admin',74,'2015-05-17 12:16:46',0),
(1561,'admin',69,'2015-06-13 01:06:33',0),
(1562,'borja',41,'2015-06-13 01:51:14',0),
(1563,'borja',41,'2015-06-13 01:51:36',0),
(1564,'admin',74,'2015-06-13 16:21:07',0),
(1565,'admin',74,'2015-06-13 16:22:00',0),
(1566,'admin',74,'2015-06-13 16:22:40',0),
(1567,'admin',69,'2015-08-04 09:22:22',0),
(1568,'admin',74,'2015-08-04 09:31:05',0),
(1569,'admin',74,'2015-08-04 10:25:52',0),
(1570,'admin',69,'2015-08-04 10:59:57',0),
(1571,'admin',74,'2015-08-04 11:05:12',0),
(1572,'pedro',60,'2015-08-14 10:46:21',0),
(1573,'pedro',54,'2015-08-14 10:46:27',0),
(1574,'senen',40,'2015-08-14 13:17:57',0),
(1575,'admin',69,'2015-08-18 12:04:46',0),
(1576,'admin',69,'2015-08-18 12:05:01',0),
(1577,'admin',74,'2015-08-18 12:06:35',0),
(1578,'admin',74,'2015-08-18 12:08:05',0),
(1579,'admin',75,'2015-08-18 12:08:12',0),
(1580,'admin',75,'2015-08-18 12:08:15',0),
(1581,'admin',71,'2015-08-18 12:08:37',0),
(1582,'admin',69,'2015-08-18 12:10:31',0),
(1583,'admin',69,'2015-08-18 12:11:08',0),
(1584,'admin',75,'2015-09-09 17:35:24',0),
(1585,'admin',74,'2015-09-09 17:43:33',0),
(1586,'admin',74,'2015-09-09 17:43:41',0),
(1587,'admin',74,'2015-09-09 17:43:51',0),
(1588,'admin',74,'2015-09-09 17:44:00',0),
(1589,'admin',74,'2015-09-09 17:44:03',0),
(1590,'admin',74,'2015-09-09 17:44:07',0),
(1591,'admin',74,'2015-09-09 17:44:11',0),
(1592,'admin',74,'2015-09-09 17:44:15',0),
(1593,'admin',74,'2015-09-09 17:44:26',0),
(1594,'admin',74,'2015-09-09 17:44:39',0),
(1595,'admin',74,'2015-09-09 17:44:44',0),
(1596,'admin',74,'2015-09-09 17:44:49',0),
(1597,'admin',74,'2015-09-09 17:44:57',0),
(1598,'admin',74,'2015-09-09 17:45:02',0),
(1599,'admin',74,'2015-09-09 17:45:07',0),
(1600,'admin',69,'2015-09-09 17:52:00',0),
(1601,'admin',69,'2015-09-11 13:46:37',0),
(1602,'admin',69,'2015-09-11 13:46:59',0),
(1603,'admin',69,'2015-09-11 13:46:59',0),
(1604,'admin',69,'2015-09-11 13:47:13',0),
(1605,'admin',69,'2015-09-11 13:47:13',0),
(1606,'admin',69,'2015-09-11 13:47:22',0),
(1607,'admin',69,'2015-09-11 13:47:22',0),
(1608,'admin',69,'2015-09-11 13:47:33',0),
(1609,'admin',69,'2015-09-11 13:47:33',0),
(1610,'admin',69,'2015-09-28 09:01:25',0),
(1611,'admin',78,'2015-09-28 09:46:07',0),
(1612,'admin',78,'2015-09-28 09:46:56',0),
(1613,'admin',69,'2015-10-01 10:29:48',0),
(1614,'admin',69,'2015-10-01 10:30:12',0),
(1615,'admin',69,'2015-10-01 10:31:01',0),
(1616,'admin',69,'2015-10-01 10:31:03',0),
(1617,'admin',69,'2015-10-01 10:31:07',0),
(1618,'admin',69,'2015-10-01 10:31:14',0),
(1619,'admin',69,'2015-10-01 10:31:19',0),
(1620,'admin',69,'2015-10-01 10:31:26',0),
(1621,'admin',69,'2015-10-01 10:45:19',0),
(1622,'admin',69,'2015-10-02 11:26:35',0),
(1623,'admin',78,'2015-10-03 01:05:12',0),
(1624,'admin',74,'2015-10-03 01:05:22',0),
(1625,'admin',69,'2015-10-03 01:06:20',0),
(1626,'admin',74,'2015-10-03 01:08:06',0),
(1627,'admin',74,'2015-10-03 01:08:44',0),
(1628,'admin',74,'2015-10-03 01:09:28',0),
(1629,'admin',74,'2015-10-03 01:09:30',0),
(1630,'admin',74,'2015-10-03 01:10:04',0),
(1631,'admin',74,'2015-10-03 01:18:23',0),
(1632,'admin',74,'2015-10-03 01:49:40',0),
(1633,'admin',74,'2015-10-03 02:25:13',0),
(1634,'admin',74,'2015-10-03 02:25:38',0),
(1635,'admin',74,'2015-10-03 02:25:39',0),
(1636,'admin',74,'2015-10-03 02:25:49',0),
(1637,'admin',74,'2015-10-03 02:25:49',0),
(1638,'admin',74,'2015-10-03 02:57:20',0),
(1639,'admin',74,'2015-10-03 02:57:32',0),
(1640,'admin',74,'2015-10-03 02:57:32',0),
(1641,'admin',74,'2015-10-03 02:57:35',0),
(1642,'admin',79,'2015-10-05 11:25:19',0),
(1643,'admin',79,'2015-10-05 11:25:32',0),
(1644,'admin',78,'2015-10-06 13:01:54',0),
(1645,'admin',69,'2015-10-13 16:03:31',0),
(1646,'admin',69,'2015-10-16 11:06:57',0),
(1647,'admin',69,'2015-10-16 11:07:10',0),
(1648,'admin',69,'2015-10-16 11:07:11',0),
(1649,'admin',69,'2015-10-16 11:12:05',0),
(1650,'admin',69,'2015-10-16 11:12:08',0),
(1651,'admin',69,'2015-10-16 11:12:10',0),
(1652,'admin',69,'2015-10-16 11:12:14',0),
(1653,'admin',69,'2015-10-16 11:21:53',0),
(1654,'admin',68,'2015-10-16 11:21:55',0),
(1655,'admin',61,'2015-10-16 11:22:06',0),
(1656,'admin',60,'2015-10-16 11:22:08',0),
(1657,'admin',61,'2015-10-16 11:22:12',0),
(1658,'admin',60,'2015-10-16 11:22:15',0),
(1659,'admin',61,'2015-10-16 11:22:16',0),
(1660,'admin',60,'2015-10-16 11:22:18',0),
(1661,'admin',60,'2015-10-16 11:23:52',0),
(1662,'admin',61,'2015-10-16 11:23:54',0),
(1663,'admin',60,'2015-10-16 11:23:56',0),
(1664,'admin',61,'2015-10-16 11:23:58',0),
(1665,'admin',69,'2015-10-16 11:24:01',0),
(1666,'admin',69,'2015-10-16 11:24:05',0),
(1667,'admin',68,'2015-10-16 11:24:09',0),
(1668,'admin',69,'2015-10-16 11:24:12',0),
(1669,'admin',68,'2015-10-16 11:24:16',0),
(1670,'admin',61,'2015-10-16 11:24:17',0),
(1671,'admin',68,'2015-10-16 11:24:18',0),
(1672,'admin',61,'2015-10-16 11:24:19',0),
(1673,'admin',60,'2015-10-16 11:24:21',0),
(1674,'admin',61,'2015-10-16 11:24:22',0),
(1675,'admin',69,'2015-10-16 11:39:48',0),
(1676,'admin',69,'2015-10-16 11:39:57',0),
(1677,'admin',69,'2015-10-16 11:39:57',0),
(1678,'admin',68,'2015-10-16 11:40:00',0),
(1679,'admin',61,'2015-10-16 11:40:03',0),
(1680,'admin',61,'2015-10-16 11:40:08',0),
(1681,'admin',61,'2015-10-16 11:40:08',0),
(1682,'admin',61,'2015-10-16 11:40:17',0),
(1683,'admin',61,'2015-10-16 11:40:17',0),
(1684,'admin',61,'2015-10-16 13:28:22',0),
(1685,'admin',60,'2015-10-16 13:28:27',0),
(1686,'admin',59,'2015-10-16 13:28:28',0),
(1687,'admin',69,'2015-10-16 13:28:30',0),
(1688,'admin',69,'2015-10-16 13:34:03',0),
(1689,'admin',69,'2015-10-16 13:34:22',0),
(1690,'admin',69,'2015-10-16 13:34:24',0),
(1691,'admin',74,'2015-10-22 16:29:44',0),
(1692,'pedro',65,'2015-10-22 16:30:31',0),
(1693,'pedro',65,'2015-10-22 16:30:46',0),
(1694,'pedro',64,'2015-10-22 16:34:35',0),
(1695,'pedro',64,'2015-10-22 16:34:53',0),
(1696,'pedro',64,'2015-10-22 16:35:29',0),
(1697,'pedro',64,'2015-10-22 16:35:29',0),
(1698,'pedro',64,'2015-10-22 16:36:14',0),
(1699,'admin',78,'2015-10-26 15:55:34',0),
(1700,'admin',78,'2015-10-26 16:19:09',0),
(1701,'admin',74,'2015-10-26 16:19:21',0),
(1702,'admin',74,'2015-10-26 16:20:47',0),
(1703,'admin',74,'2015-10-26 16:21:37',0),
(1704,'admin',74,'2015-10-26 16:21:40',0),
(1705,'admin',74,'2015-10-26 16:22:20',0),
(1706,'admin',74,'2015-10-26 16:23:42',0),
(1707,'admin',64,'2015-10-26 17:50:49',0),
(1708,'admin',78,'2015-10-26 17:52:21',0),
(1709,'admin',69,'2015-10-27 08:58:39',0),
(1710,'admin',69,'2015-10-27 10:42:29',0),
(1711,'admin',69,'2015-10-27 10:43:59',0),
(1712,'admin',69,'2015-10-27 10:44:36',0),
(1713,'admin',69,'2015-10-27 10:48:28',0),
(1714,'admin',69,'2015-10-27 10:50:40',0),
(1715,'admin',69,'2015-10-27 10:51:05',0),
(1716,'admin',69,'2015-10-27 10:51:07',0),
(1717,'admin',69,'2015-10-27 10:53:40',0),
(1718,'admin',69,'2015-10-27 10:54:01',0),
(1719,'admin',69,'2015-10-27 12:42:06',0),
(1720,'admin',69,'2015-10-27 12:43:14',0),
(1721,'senen',69,'2015-10-27 13:18:04',0),
(1722,'senen',40,'2015-10-27 13:20:48',0),
(1723,'senen',40,'2015-10-27 13:20:59',0),
(1724,'senen',40,'2015-10-27 13:20:59',0),
(1725,'admin',69,'2015-10-27 16:20:18',0),
(1726,'admin',69,'2015-10-27 16:20:28',0),
(1727,'admin',69,'2015-10-28 08:40:03',0),
(1728,'admin',69,'2015-10-28 08:42:28',0),
(1729,'admin',69,'2015-10-28 12:51:26',0),
(1730,'admin',69,'2015-10-28 12:51:39',0),
(1731,'admin',78,'2015-10-28 12:52:30',0),
(1732,'admin',74,'2015-10-28 12:53:10',0),
(1733,'admin',69,'2015-10-28 12:56:55',0),
(1734,'admin',68,'2015-10-28 12:57:07',0),
(1735,'admin',68,'2015-10-28 12:57:24',0),
(1736,'admin',68,'2015-10-28 12:57:24',0),
(1737,'admin',68,'2015-10-28 12:59:37',0),
(1738,'admin',68,'2015-10-28 13:02:16',0),
(1739,'admin',69,'2015-10-28 13:06:07',0),
(1740,'admin',69,'2015-10-28 13:15:13',0),
(1741,'admin',69,'2015-10-28 13:16:12',0),
(1742,'admin',69,'2015-10-28 13:18:02',0),
(1743,'admin',69,'2015-10-28 13:18:28',0),
(1744,'admin',69,'2015-10-28 13:19:14',0),
(1745,'admin',69,'2015-10-28 13:19:56',0),
(1746,'admin',69,'2015-10-28 13:20:57',0),
(1747,'admin',69,'2015-10-28 13:22:51',0),
(1748,'admin',69,'2015-10-28 13:25:53',0),
(1749,'admin',69,'2015-10-28 13:25:55',0),
(1750,'admin',69,'2015-10-28 13:26:33',0),
(1751,'admin',69,'2015-10-28 13:26:35',0),
(1752,'admin',69,'2015-10-28 13:26:36',0),
(1753,'admin',69,'2015-10-28 13:26:38',0),
(1754,'admin',69,'2015-10-28 13:27:57',0),
(1755,'admin',69,'2015-10-28 13:29:02',0),
(1756,'admin',69,'2015-10-28 13:29:04',0),
(1757,'admin',69,'2015-10-28 13:30:36',0),
(1758,'admin',69,'2015-10-28 13:30:56',0),
(1759,'admin',69,'2015-10-28 13:31:28',0),
(1760,'admin',69,'2015-10-28 13:31:51',0),
(1761,'admin',69,'2015-10-28 13:31:54',0),
(1762,'admin',69,'2015-10-28 13:31:58',0),
(1763,'admin',68,'2015-10-28 13:32:13',0),
(1764,'admin',68,'2015-10-28 13:33:20',0),
(1765,'admin',68,'2015-10-28 13:33:22',0),
(1766,'admin',68,'2015-10-28 13:34:16',0),
(1767,'admin',68,'2015-10-28 13:34:19',0),
(1768,'admin',69,'2015-10-28 13:34:28',0),
(1769,'admin',68,'2015-10-28 13:34:32',0),
(1770,'admin',61,'2015-10-28 13:34:36',0),
(1771,'admin',69,'2015-10-28 13:35:22',0),
(1772,'admin',69,'2015-10-28 13:36:28',0),
(1773,'admin',68,'2015-10-28 13:37:08',0),
(1774,'admin',61,'2015-10-28 15:21:04',0),
(1775,'admin',60,'2015-10-28 15:21:09',0),
(1776,'admin',59,'2015-10-28 15:21:14',0),
(1777,'admin',54,'2015-10-28 15:21:31',0),
(1778,'admin',54,'2015-10-28 15:25:32',0),
(1779,'admin',54,'2015-10-28 15:26:50',0),
(1780,'admin',69,'2015-10-28 16:20:55',0),
(1781,'admin',69,'2015-10-28 16:23:21',0),
(1782,'admin',69,'2015-10-28 16:24:12',0),
(1783,'admin',69,'2015-10-28 16:25:17',0),
(1784,'admin',69,'2015-10-28 16:25:20',0),
(1785,'admin',69,'2015-10-28 16:25:25',0),
(1786,'admin',78,'2015-10-30 10:41:20',0),
(1787,'admin',74,'2015-11-12 17:00:25',0),
(1788,'admin',74,'2015-11-12 17:02:40',0),
(1789,'admin',74,'2015-11-12 17:03:06',0),
(1790,'admin',74,'2015-11-12 17:03:07',0),
(1791,'admin',74,'2015-11-12 17:05:22',0),
(1792,'admin',74,'2015-11-12 17:05:29',0),
(1793,'admin',74,'2015-11-12 17:05:39',0),
(1794,'admin',74,'2015-11-12 17:05:40',0),
(1795,'admin',74,'2015-11-12 17:08:04',0),
(1796,'admin',74,'2015-11-12 17:09:05',0),
(1797,'admin',74,'2015-11-12 17:09:11',0),
(1798,'admin',74,'2015-11-12 17:09:29',0),
(1799,'admin',74,'2015-11-12 17:09:33',0),
(1800,'admin',74,'2015-11-12 17:09:58',0),
(1801,'admin',74,'2015-11-12 17:15:05',0),
(1802,'admin',74,'2015-11-12 17:15:31',0),
(1803,'admin',74,'2015-11-12 17:16:06',0),
(1804,'admin',74,'2015-11-12 17:16:06',0),
(1805,'admin',74,'2015-11-12 17:16:24',0),
(1806,'admin',74,'2015-11-12 17:16:24',0),
(1807,'admin',69,'2015-11-12 17:16:46',0),
(1808,'admin',69,'2015-11-12 17:18:02',0),
(1809,'admin',61,'2015-11-12 17:18:52',0),
(1810,'admin',69,'2015-11-12 17:21:16',0),
(1811,'admin',69,'2015-11-12 17:21:42',0),
(1812,'admin',69,'2015-11-12 17:22:50',0),
(1813,'admin',69,'2015-11-12 17:23:35',0),
(1814,'admin',69,'2015-11-12 17:23:45',0),
(1815,'admin',69,'2015-11-12 17:25:15',0),
(1816,'admin',69,'2015-11-12 17:27:11',0),
(1817,'admin',69,'2015-11-12 17:38:17',0),
(1818,'admin',69,'2015-11-13 09:46:39',0),
(1819,'admin',69,'2015-11-13 09:49:54',0),
(1820,'admin',69,'2015-11-13 09:52:19',0),
(1821,'admin',69,'2015-11-13 09:53:55',0),
(1822,'admin',69,'2015-11-13 09:55:57',0),
(1823,'admin',69,'2015-11-13 09:59:01',0),
(1824,'admin',69,'2015-11-13 10:00:05',0),
(1825,'admin',69,'2015-11-13 10:01:12',0),
(1826,'admin',69,'2015-11-13 10:01:30',0),
(1827,'admin',69,'2015-11-13 10:03:40',0),
(1828,'admin',69,'2015-11-13 10:06:23',0),
(1829,'admin',69,'2015-11-13 10:07:14',0),
(1830,'admin',69,'2015-11-13 10:07:45',0),
(1831,'admin',69,'2015-11-13 10:07:53',0),
(1832,'admin',69,'2015-11-13 10:16:30',0),
(1833,'admin',69,'2015-11-13 10:16:55',0),
(1834,'admin',69,'2015-11-13 10:17:01',0),
(1835,'admin',69,'2015-11-13 10:18:04',0),
(1836,'admin',69,'2015-11-13 10:18:33',0),
(1837,'admin',69,'2015-11-13 10:19:51',0),
(1838,'admin',69,'2015-11-13 10:20:31',0),
(1839,'admin',69,'2015-11-13 10:21:51',0),
(1840,'admin',69,'2015-11-13 10:25:57',0),
(1841,'admin',69,'2015-11-13 10:26:58',0),
(1842,'admin',69,'2015-11-13 10:28:00',0),
(1843,'admin',69,'2015-12-15 09:12:53',0),
(1844,'admin',78,'2015-12-18 10:09:48',0),
(1845,'admin',69,'2016-01-19 16:47:33',0),
(1846,'admin',69,'2016-02-01 15:41:38',0),
(1847,'admin',69,'2016-02-01 15:42:33',0),
(1848,'admin',69,'2016-02-01 15:44:35',0),
(1849,'admin',69,'2016-02-01 15:45:44',0),
(1850,'admin',69,'2016-02-01 15:45:58',0),
(1851,'admin',69,'2016-02-02 17:41:19',0),
(1852,'admin',69,'2016-02-02 17:41:53',0),
(1853,'admin',69,'2016-02-02 17:48:58',0),
(1854,'admin',69,'2016-02-12 10:55:37',0),
(1855,'admin',78,'2016-02-12 14:05:39',0),
(1856,'admin',69,'2016-02-24 13:34:37',0),
(1857,'admin',69,'2016-02-24 13:35:20',0),
(1858,'admin',69,'2016-02-24 13:56:24',0),
(1859,'admin',69,'2016-02-24 13:56:39',0),
(1860,'admin',69,'2016-02-24 13:59:29',0),
(1861,'admin',69,'2016-02-24 14:00:39',0),
(1862,'admin',69,'2016-02-24 14:01:52',0),
(1863,'admin',69,'2016-02-24 14:01:57',0),
(1864,'admin',69,'2016-02-24 14:04:09',0),
(1865,'admin',69,'2016-02-24 14:04:20',0),
(1866,'admin',69,'2016-02-24 14:05:11',0),
(1867,'admin',69,'2016-02-24 14:06:02',0),
(1868,'admin',69,'2016-02-24 14:07:22',0),
(1869,'admin',69,'2016-02-24 14:09:40',0),
(1870,'admin',69,'2016-02-24 14:10:55',0),
(1871,'admin',69,'2016-02-24 14:12:39',0),
(1872,'admin',69,'2016-02-24 14:13:01',0),
(1873,'admin',69,'2016-02-24 14:15:02',0),
(1874,'admin',69,'2016-02-24 14:15:07',0),
(1875,'admin',69,'2016-02-24 14:15:57',0),
(1876,'admin',69,'2016-02-24 14:16:01',0),
(1877,'admin',69,'2016-02-24 14:18:14',0),
(1878,'admin',69,'2016-02-24 14:18:17',0),
(1879,'admin',69,'2016-02-24 14:23:08',0),
(1880,'admin',69,'2016-02-24 14:23:26',0),
(1881,'admin',69,'2016-02-24 14:23:53',0),
(1882,'admin',69,'2016-02-24 14:23:56',0),
(1883,'admin',69,'2016-02-24 14:24:54',0),
(1884,'admin',69,'2016-02-24 14:25:06',0),
(1885,'admin',69,'2016-02-24 14:25:12',0),
(1886,'admin',69,'2016-02-24 14:33:45',0),
(1887,'admin',69,'2016-02-24 14:34:17',0),
(1888,'pedro',60,'2016-03-09 13:26:24',0),
(1889,'claudio',40,'2016-03-09 13:29:07',0),
(1890,'claudio',40,'2016-03-09 13:29:25',0),
(1891,'claudio',69,'2016-03-09 14:52:20',0),
(1892,'admin',60,'2016-03-10 10:48:48',0),
(1893,'admin',65,'2016-03-10 10:51:24',0),
(1894,'admin',64,'2016-03-10 13:33:17',0),
(1895,'admin',60,'2016-03-10 13:37:39',0),
(1896,'admin',60,'2016-03-10 13:39:14',0),
(1897,'admin',60,'2016-03-10 13:39:17',0),
(1898,'admin',60,'2016-03-10 13:40:22',0),
(1899,'admin',69,'2016-03-10 13:40:27',0),
(1900,'admin',60,'2016-03-10 13:40:32',0),
(1901,'admin',69,'2016-03-10 13:41:10',0),
(1902,'admin',69,'2016-03-10 13:42:45',0),
(1903,'admin',60,'2016-03-10 13:42:51',0),
(1904,'admin',60,'2016-03-10 13:42:59',0),
(1905,'admin',60,'2016-03-10 13:45:03',0),
(1906,'admin',69,'2016-03-10 13:45:13',0),
(1907,'admin',69,'2016-03-10 13:46:06',0),
(1908,'admin',60,'2016-03-10 13:46:21',0),
(1909,'admin',65,'2016-03-10 13:51:11',0),
(1910,'admin',60,'2016-03-10 14:14:23',0),
(1911,'admin',60,'2016-03-10 14:15:38',0),
(1912,'admin',60,'2016-03-10 14:16:47',0),
(1913,'admin',60,'2016-03-10 14:16:52',0),
(1914,'admin',60,'2016-03-10 14:17:54',0),
(1915,'admin',60,'2016-03-10 14:18:20',0),
(1916,'admin',60,'2016-03-10 14:20:33',0),
(1917,'admin',60,'2016-03-10 14:23:11',0),
(1918,'admin',60,'2016-03-10 14:24:47',0),
(1919,'admin',60,'2016-03-10 14:25:17',0),
(1920,'admin',60,'2016-03-10 14:25:20',0),
(1921,'admin',60,'2016-03-10 14:25:33',0),
(1922,'admin',60,'2016-03-10 14:25:53',0),
(1923,'admin',60,'2016-03-10 14:25:56',0),
(1924,'admin',60,'2016-03-10 14:26:44',0),
(1925,'admin',60,'2016-03-10 14:26:48',0),
(1926,'admin',60,'2016-03-10 14:27:01',0),
(1927,'admin',60,'2016-03-10 14:27:10',0),
(1928,'admin',60,'2016-03-10 14:28:05',0),
(1929,'admin',60,'2016-03-10 14:29:40',0),
(1930,'admin',60,'2016-03-10 14:31:00',0),
(1931,'admin',60,'2016-03-10 14:33:12',0),
(1932,'admin',60,'2016-03-10 14:33:40',0),
(1933,'admin',60,'2016-03-10 14:34:02',0),
(1934,'admin',60,'2016-03-10 14:34:36',0),
(1935,'admin',60,'2016-03-10 14:35:03',0),
(1936,'admin',60,'2016-03-10 14:35:06',0),
(1937,'admin',60,'2016-03-10 14:35:09',0),
(1938,'admin',60,'2016-03-10 14:35:10',0),
(1939,'admin',60,'2016-03-10 14:35:10',0),
(1940,'admin',60,'2016-03-10 14:35:12',0),
(1941,'admin',60,'2016-03-10 14:37:44',0),
(1942,'admin',69,'2016-03-10 14:37:48',0),
(1943,'admin',74,'2016-03-10 15:41:21',0),
(1944,'admin',74,'2016-03-10 15:45:42',0),
(1945,'pedro',65,'2016-03-10 15:52:07',0),
(1946,'pedro',65,'2016-03-10 15:52:17',0),
(1947,'pedro',65,'2016-03-10 15:56:01',0),
(1948,'admin',69,'2016-03-10 16:54:29',0),
(1949,'admin',60,'2016-03-11 13:08:27',0),
(1950,'admin',64,'2016-03-11 13:10:35',0),
(1951,'admin',64,'2016-03-14 09:12:32',0),
(1952,'admin',65,'2016-03-14 09:12:37',0),
(1953,'admin',42,'2016-03-14 09:12:40',0),
(1954,'admin',65,'2016-03-14 09:15:29',0),
(1955,'admin',64,'2016-03-14 09:15:33',0),
(1956,'admin',42,'2016-03-14 09:15:37',0),
(1957,'admin',69,'2016-03-17 10:01:41',0),
(1958,'admin',69,'2016-03-17 10:01:55',0),
(1959,'admin',69,'2016-03-17 10:01:56',0),
(1960,'admin',69,'2016-03-17 10:02:08',0),
(1961,'admin',69,'2016-03-17 10:02:09',0),
(1962,'admin',69,'2016-03-17 10:02:19',0),
(1963,'admin',69,'2016-03-17 10:02:20',0),
(1964,'admin',69,'2016-03-17 10:04:22',0),
(1965,'admin',40,'2016-03-17 10:19:44',0),
(1966,'admin',40,'2016-03-17 10:20:07',0),
(1967,'admin',40,'2016-03-17 10:20:36',0),
(1968,'admin',40,'2016-03-17 10:20:37',0),
(1969,'admin',77,'2016-03-17 17:08:46',0),
(1970,'admin',69,'2016-03-17 17:09:01',0),
(1971,'admin',69,'2016-03-17 17:09:04',0),
(1972,'admin',69,'2016-04-05 17:22:54',0),
(1973,'admin',69,'2016-04-05 17:27:14',0),
(1974,'admin',69,'2016-04-05 17:31:11',0),
(1975,'admin',78,'2016-04-06 15:44:55',0),
(1976,'borja',60,'2016-04-28 09:27:52',0),
(1977,'borja',60,'2016-04-28 09:28:08',0),
(1978,'borja',60,'2016-04-28 09:28:30',0),
(1979,'borja',65,'2016-04-28 09:29:06',0),
(1980,'borja',64,'2016-04-28 09:29:26',0),
(1981,'borja',64,'2016-04-28 09:29:35',0),
(1982,'admin',69,'2016-05-12 13:02:35',0),
(1983,'admin',69,'2016-05-12 13:02:50',0),
(1984,'admin',78,'2016-05-26 10:02:56',0),
(1985,'admin',78,'2016-05-26 10:14:12',0),
(1986,'admin',78,'2016-05-26 10:14:20',0),
(1987,'admin',78,'2016-05-26 10:15:00',0),
(1988,'admin',78,'2016-05-26 10:15:04',0),
(1989,'admin',78,'2016-05-26 10:15:38',0),
(1990,'admin',78,'2016-05-26 10:15:40',0),
(1991,'admin',78,'2016-05-26 10:16:05',0),
(1992,'admin',78,'2016-05-26 10:16:17',0),
(1993,'admin',78,'2016-05-26 10:16:57',0),
(1994,'admin',78,'2016-05-26 10:47:21',0),
(1995,'admin',78,'2016-05-26 10:47:49',0),
(1996,'admin',78,'2016-05-26 10:48:53',0),
(1997,'admin',78,'2016-05-26 11:45:51',0),
(1998,'admin',69,'2016-06-30 12:41:22',0),
(1999,'admin',69,'2016-06-30 12:43:52',0),
(2000,'admin',77,'2016-07-28 09:04:37',0),
(2001,'admin',56,'2016-07-28 09:04:41',0),
(2002,'admin',69,'2016-07-29 09:02:27',0),
(2003,'admin',65,'2016-08-29 14:37:24',0),
(2004,'admin',65,'2016-08-29 14:37:32',0),
(2005,'admin',65,'2016-08-29 14:38:19',0),
(2006,'admin',65,'2016-08-29 14:38:34',0),
(2007,'admin',65,'2016-08-29 14:39:17',0),
(2008,'admin',65,'2016-08-29 14:39:44',0),
(2009,'admin',65,'2016-08-29 14:40:38',0),
(2010,'admin',65,'2016-08-29 14:41:00',0),
(2011,'admin',65,'2016-08-29 14:41:50',0),
(2012,'admin',65,'2016-08-29 14:42:24',0),
(2013,'admin',65,'2016-08-29 14:43:02',0),
(2014,'admin',65,'2016-08-29 14:43:20',0),
(2015,'admin',65,'2016-08-29 14:43:39',0),
(2016,'admin',65,'2016-08-29 14:43:55',0),
(2017,'admin',65,'2016-08-29 14:44:06',0),
(2018,'admin',65,'2016-08-29 14:44:17',0),
(2019,'admin',65,'2016-08-29 14:45:02',0),
(2020,'admin',65,'2016-08-29 14:45:18',0),
(2021,'admin',65,'2016-08-29 14:45:41',0),
(2022,'admin',65,'2016-08-29 14:46:16',0),
(2023,'admin',65,'2016-08-29 14:47:03',0),
(2024,'admin',65,'2016-08-29 15:00:08',0),
(2025,'admin',65,'2016-08-29 15:00:17',0),
(2026,'admin',65,'2016-08-29 15:00:38',0),
(2027,'admin',69,'2016-10-14 09:16:47',0),
(2028,'admin',78,'2016-10-14 09:20:20',0),
(2029,'admin',78,'2016-10-14 09:20:27',0),
(2030,'admin',78,'2016-10-14 09:20:28',0),
(2031,'borja',65,'2016-10-14 09:40:48',0),
(2032,'borja',60,'2016-10-14 09:41:02',0),
(2033,'borja',60,'2016-10-14 09:41:37',0),
(2034,'jgonzalez',60,'2016-10-14 09:42:31',0),
(2035,'jgonzalez',60,'2016-10-14 09:42:41',0),
(2036,'jgonzalez',65,'2016-10-14 09:43:29',0),
(2037,'jgonzalez',42,'2016-10-14 09:43:34',0),
(2038,'jgonzalez',62,'2016-10-14 09:43:41',0),
(2039,'jgonzalez',60,'2016-10-14 09:43:49',0),
(2040,'dramos',62,'2016-10-14 09:49:22',0),
(2041,'dramos',42,'2016-10-14 09:49:27',0),
(2042,'dramos',65,'2016-10-14 09:49:33',0),
(2043,'dramos',60,'2016-10-14 09:49:35',0),
(2044,'dramos',60,'2016-10-14 09:49:38',0),
(2045,'dramos',59,'2016-10-14 09:49:41',0),
(2046,'dramos',60,'2016-10-14 09:49:55',0),
(2047,'admin',69,'2016-10-14 11:07:45',0),
(2048,'admin',78,'2016-10-20 10:47:07',0),
(2049,'admin',78,'2016-10-20 10:47:17',0),
(2050,'admin',78,'2016-10-20 10:50:42',0),
(2051,'admin',78,'2016-10-20 10:50:47',0),
(2052,'admin',77,'2016-11-16 10:36:05',0),
(2053,'admin',77,'2016-11-16 10:36:16',0),
(2054,'admin',77,'2016-11-16 10:36:20',0),
(2055,'admin',77,'2016-11-16 10:36:30',0),
(2056,'admin',77,'2016-11-16 10:36:30',0),
(2057,'admin',77,'2016-11-16 10:36:34',0),
(2058,'admin',69,'2016-11-21 10:17:10',0),
(2059,'admin',69,'2016-11-22 14:34:31',0),
(2060,'admin',69,'2016-11-23 14:24:02',0),
(2061,'admin',69,'2016-11-23 14:31:27',0),
(2062,'admin',69,'2016-11-23 14:31:49',0),
(2063,'admin',60,'2016-11-23 14:31:52',0),
(2064,'admin',60,'2016-11-23 14:32:33',0),
(2065,'admin',69,'2016-11-23 14:32:38',0),
(2066,'admin',69,'2016-11-23 14:33:08',0),
(2067,'admin',60,'2016-11-23 14:33:13',0),
(2068,'admin',60,'2016-11-23 14:35:18',0),
(2069,'admin',60,'2016-11-23 14:35:25',0),
(2070,'admin',69,'2016-11-23 14:35:29',0),
(2071,'admin',69,'2016-11-23 14:35:31',0),
(2072,'admin',60,'2016-11-23 14:42:02',0),
(2073,'admin',60,'2016-11-23 14:42:12',0),
(2074,'admin',60,'2016-11-23 14:42:25',0),
(2075,'admin',69,'2016-11-23 14:51:05',0),
(2076,'admin',60,'2016-11-23 14:51:54',0),
(2077,'admin',69,'2016-11-23 14:52:03',0),
(2078,'admin',69,'2016-11-23 15:42:51',0),
(2079,'admin',60,'2016-11-23 15:42:59',0),
(2080,'admin',69,'2016-11-23 16:08:25',0),
(2081,'admin',69,'2016-11-23 16:08:44',0),
(2082,'admin',69,'2016-11-23 16:14:00',0),
(2083,'admin',60,'2016-11-23 16:14:36',0),
(2084,'admin',60,'2016-11-23 16:15:02',0),
(2085,'admin',60,'2016-11-23 16:16:06',0),
(2086,'admin',69,'2016-11-23 16:18:49',0),
(2087,'admin',69,'2016-11-23 16:18:57',0),
(2088,'admin',69,'2016-11-23 16:19:04',0),
(2089,'admin',69,'2016-11-23 16:19:15',0),
(2090,'admin',69,'2016-11-23 16:19:15',0),
(2091,'admin',69,'2016-11-23 16:19:42',0),
(2092,'admin',78,'2016-11-24 11:00:37',0),
(2093,'admin',78,'2016-11-24 11:00:45',0),
(2094,'admin',78,'2016-11-24 11:01:02',0),
(2095,'admin',78,'2016-11-24 11:01:13',0),
(2096,'admin',78,'2016-11-24 11:01:35',0),
(2097,'admin',78,'2016-11-24 11:02:16',0),
(2098,'admin',78,'2016-11-24 11:02:47',0),
(2099,'admin',78,'2016-11-24 11:05:06',0),
(2100,'admin',78,'2016-11-24 11:10:35',0),
(2101,'admin',78,'2016-11-24 11:30:51',0),
(2102,'admin',78,'2016-11-24 11:35:47',0),
(2103,'admin',78,'2016-11-24 11:36:50',0),
(2104,'admin',78,'2016-11-24 11:37:22',0),
(2105,'admin',78,'2016-11-24 11:40:20',0),
(2106,'admin',78,'2016-11-24 11:40:52',0),
(2107,'admin',78,'2016-11-24 12:02:33',0),
(2108,'admin',78,'2016-11-24 12:03:26',0),
(2109,'admin',78,'2016-11-24 12:03:53',0),
(2110,'admin',78,'2016-11-24 12:06:43',0),
(2111,'admin',78,'2016-11-24 12:07:43',0),
(2112,'admin',78,'2016-11-24 13:13:12',0),
(2113,'admin',78,'2016-11-24 13:14:06',0),
(2114,'admin',78,'2016-11-24 13:18:40',0),
(2115,'admin',78,'2016-11-24 13:21:00',0),
(2116,'admin',78,'2016-11-24 13:21:05',0),
(2117,'admin',78,'2016-11-24 13:42:04',0),
(2118,'admin',78,'2016-11-24 13:42:41',0),
(2119,'admin',78,'2016-11-24 13:43:49',0),
(2120,'admin',78,'2016-11-24 13:44:17',0),
(2121,'admin',78,'2016-11-24 13:45:17',0),
(2122,'admin',78,'2016-11-24 13:45:23',0),
(2123,'admin',78,'2016-11-24 13:45:42',0),
(2124,'admin',78,'2016-11-24 13:46:04',0),
(2125,'admin',78,'2016-11-24 13:46:20',0),
(2126,'admin',78,'2016-11-24 13:46:38',0),
(2127,'admin',78,'2016-11-24 13:46:59',0),
(2128,'admin',78,'2016-11-24 13:47:08',0),
(2129,'admin',78,'2016-11-24 13:48:27',0),
(2130,'admin',78,'2016-11-24 13:49:02',0),
(2131,'admin',78,'2016-11-24 13:49:35',0),
(2132,'admin',78,'2016-11-24 13:57:53',0),
(2133,'admin',78,'2016-11-24 14:07:58',0),
(2134,'admin',78,'2016-11-24 14:10:35',0),
(2135,'admin',78,'2016-11-24 14:10:53',0),
(2136,'admin',78,'2016-11-24 14:12:12',0),
(2137,'admin',78,'2016-11-24 14:12:51',0),
(2138,'admin',78,'2016-11-24 14:13:51',0),
(2139,'admin',78,'2016-11-24 14:13:52',0),
(2140,'admin',78,'2016-11-24 14:14:56',0),
(2141,'admin',78,'2016-11-24 14:15:13',0),
(2142,'admin',78,'2016-11-24 14:15:18',0),
(2143,'admin',78,'2016-11-24 14:15:33',0),
(2144,'admin',78,'2016-11-24 14:19:43',0),
(2145,'admin',78,'2016-11-24 14:23:26',0),
(2146,'admin',78,'2016-11-24 14:23:54',0),
(2147,'admin',78,'2016-11-24 14:24:23',0),
(2148,'admin',78,'2016-11-24 14:24:37',0),
(2149,'admin',78,'2016-11-24 14:31:27',0),
(2150,'admin',78,'2016-11-24 14:31:31',0),
(2151,'admin',78,'2016-11-24 14:32:37',0),
(2152,'admin',78,'2016-11-24 14:32:56',0),
(2153,'admin',78,'2016-11-24 14:33:35',0),
(2154,'admin',78,'2016-11-24 14:35:06',0),
(2155,'admin',78,'2016-11-24 14:35:31',0),
(2156,'admin',78,'2016-11-24 14:39:40',0),
(2157,'admin',78,'2016-11-24 14:40:42',0),
(2158,'admin',78,'2016-11-24 14:40:49',0),
(2159,'admin',78,'2016-11-24 14:42:52',0),
(2160,'admin',78,'2016-11-24 14:43:26',0),
(2161,'admin',78,'2016-11-24 14:43:57',0),
(2162,'admin',78,'2016-11-24 14:45:47',0),
(2163,'admin',78,'2016-11-24 14:46:01',0),
(2164,'admin',78,'2016-11-24 14:46:46',0),
(2165,'admin',78,'2016-11-24 14:46:52',0),
(2166,'admin',78,'2016-11-24 16:31:22',0),
(2167,'admin',78,'2016-11-24 16:31:46',0),
(2168,'admin',78,'2016-11-24 16:31:57',0),
(2169,'admin',78,'2016-11-24 16:34:27',0),
(2170,'admin',78,'2016-11-24 16:34:33',0),
(2171,'admin',78,'2016-11-24 16:36:17',0),
(2172,'admin',78,'2016-11-24 16:36:30',0),
(2173,'admin',78,'2016-11-24 16:36:54',0),
(2174,'admin',78,'2016-11-24 16:37:39',0),
(2175,'admin',78,'2016-11-24 16:38:01',0),
(2176,'admin',78,'2016-11-24 16:39:54',0),
(2177,'admin',78,'2016-11-24 16:40:08',0),
(2178,'admin',78,'2016-11-24 16:40:18',0),
(2179,'admin',69,'2016-11-28 15:47:01',0),
(2180,'admin',69,'2016-11-28 15:47:12',0),
(2181,'admin',78,'2016-11-28 15:48:46',0),
(2182,'admin',78,'2016-11-28 15:50:12',0),
(2183,'admin',78,'2016-11-28 15:51:03',0),
(2184,'admin',78,'2016-11-28 15:51:22',0),
(2185,'admin',69,'2016-11-28 15:51:27',0),
(2186,'admin',69,'2016-11-28 15:51:31',0),
(2187,'admin',78,'2016-11-28 16:29:38',0),
(2188,'admin',69,'2016-12-01 09:17:39',0),
(2189,'borja',60,'2016-12-19 11:39:22',0),
(2190,'borja',69,'2016-12-19 11:42:54',0),
(2191,'borja',69,'2016-12-19 11:43:38',0),
(2192,'borja',69,'2016-12-19 11:43:53',0),
(2193,'borja',69,'2016-12-19 11:43:53',0),
(2194,'borja',69,'2016-12-19 11:44:11',0),
(2195,'borja',69,'2016-12-19 11:44:12',0);

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
  PRIMARY KEY (`id_file`),
  KEY `user_add` (`user_add`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;

/*Data for the table `galeria_fotos` */

insert  into `galeria_fotos`(`id_file`,`id_promocion`,`tipo_foto`,`titulo`,`name_file`,`user_add`,`date_foto`,`canal`,`estado`,`fotos_puntos`,`seleccion_reto`,`formacion`,`id_album`) values 
(1,0,'','Calendario abril','1410340463_apr-14-relax-cal-1600x1050.png','admin','2014-09-10 11:14:23','comercial',1,145,0,0,1),
(2,0,'','Una pa generentes','1410780922_apr-14-april-cosmos-cal-1920x1080.jpg','admin','2014-09-15 13:35:22','gerente',1,0,0,0,1),
(3,0,'Calendarios','Calendario septiembre','1411482621_sept-14-dream-it-cal-1920x1080.png','pedro','2014-09-23 16:30:21','comercial',1,23,0,0,1),
(4,0,'Calendarios','Calendario Julio','1411482736_july-14-sweet-season-cal-1400x1050.png','senen','2014-09-23 16:32:16','comercial',1,0,0,0,1),
(5,0,'','sss','1411483841_captura_de_pantalla_de_2014-06-10_12_46_24.png','admin','2014-09-23 16:50:41','comercial',2,0,0,0,0),
(6,0,'','Calendario junio','1411484095png','admin','2014-09-23 16:54:55','comercial',1,1,0,0,1),
(7,0,'','Impresión liquidaciones','1411484211JPG','senen','2014-09-23 16:56:51','comercial',1,15,0,0,2),
(8,0,'','Comunidad particulares','1411484234png','pedro','2014-09-23 16:57:14','comercial',1,0,0,0,2),
(9,0,'','Comunidad particulares 2012','1411484281png','admin','2014-09-23 16:58:01','comercial',1,45,0,0,2),
(10,0,'','Comunidad empresas','1411484304png','admin','2014-09-23 16:58:24','comercial',1,0,0,0,2),
(11,0,'','Foto vertical','1411546388.jpg','pedro','2014-09-24 10:13:08','comercial',1,0,0,0,2),
(12,0,'','prueba','1411546578.JPG','senen','2014-09-24 10:16:18','comercial',1,5,0,0,2),
(13,0,'','Corazón','1411546841.jpg','admin','2014-09-24 10:20:41','comercial',1,0,0,0,5),
(14,0,'','Joda','1411546944.png','pedro','2014-09-24 10:22:24','gerente',1,0,0,0,3),
(15,0,'','El malo...','1411546963.jpg','admin','2014-09-24 10:22:43','gerente',2,0,0,0,3),
(16,0,'','Banner tira','1411547073.jpg','senen','2014-09-24 10:24:33','comercial',2,0,0,0,2),
(17,0,'','Simpsons...','1411547097.jpg','admin','2014-09-24 10:24:57','comercial',1,0,0,0,3),
(18,0,'','Captura e un video','1411549318.png','admin','2014-09-24 11:01:58','comercial',1,33,0,0,4),
(19,0,'','Ensalada rica','1411549430.jpg','admin','2014-09-24 11:03:50','comercial',1,0,0,0,4),
(20,0,'','Tienda Orange','1411549443.jpg','admin','2014-09-24 11:04:03','comercial',1,7,0,0,5),
(21,0,'','Dulces','1411549459.jpg','admin','2014-09-24 11:04:19','comercial',1,2,0,0,4),
(22,0,'','¿cuales me compro?','1411549492.jpg','admin','2014-09-24 11:04:52','comercial',1,49,0,0,5),
(23,0,'','Con mi abanico','1411566184.jpg','admin','2014-09-24 15:43:04','comercial',1,0,0,0,5),
(24,0,'','Una boca brillante','1411566205.jpg','admin','2014-09-24 15:43:25','gerente',1,0,0,0,3),
(25,0,'','Cartel','1411566227.jpg','admin','2014-09-24 15:43:47','gerente',1,0,0,0,2),
(26,0,'','Aporreando con el martillo','1411566257.jpg','admin','2014-09-24 15:44:17','gerente',1,0,0,0,5),
(27,0,'','Pantallazo de iPhone','1411566298.jpg','admin','2014-09-24 15:44:58','gerente',1,0,0,0,2),
(28,0,'','Haciendo el cabra','1411566318.jpg','admin','2014-09-24 15:45:18','comercial',1,0,0,0,5),
(29,0,'','Flores que se comen','1411566341.jpg','admin','2014-09-24 15:45:41','comercial',1,0,0,0,4),
(30,0,'','Web movistar','1411566984.jpg','admin','2014-09-24 15:56:24','comercial',1,0,0,0,2),
(31,0,'','Mi pueblo con nieve','1411567007.jpg','admin','2014-09-24 15:56:47','gerente',1,0,0,0,5),
(32,0,'','Perros durmiendo','1411567051.jpg','admin','2014-09-24 15:57:31','comercial',1,0,0,0,6),
(33,0,'','Pero que cerdos!!!, pero que bien viven...','1411567098.jpg','admin','2014-09-24 15:58:18','comercial',1,0,0,0,6),
(34,0,'','Mi perro Juanfran','1411567123.jpg','admin','2014-09-24 15:58:43','comercial',1,0,0,0,6),
(35,0,'','Perro sonriendo','1411567205.jpg','admin','2014-09-24 16:00:05','comercial',1,0,0,0,6),
(36,0,'felicitaciones','Felicidades','1411567346.jpg','admin','2014-09-24 16:02:26','comercial',1,1,0,0,5),
(37,0,'','Algo con arroz','1411567365.jpg','admin','2014-09-24 16:02:45','gerente',1,0,0,0,4),
(38,0,'','Hamburguesa','1411567385.jpg','admin','2014-09-24 16:03:05','gerente',1,0,0,0,4),
(39,0,'','Verduritas','1411567405.jpg','admin','2014-09-24 16:03:25','gerente',1,0,0,0,4),
(40,0,'','Esquema de arboles','1411567434.jpg','admin','2014-09-24 16:03:54','comercial',1,0,0,0,5),
(41,0,'','La oveja negra','1411567477.jpg','admin','2014-09-24 16:04:37','comercial',1,0,0,0,6),
(42,0,'','Felices Fiestas','1411567494.jpg','admin','2014-09-24 16:04:54','comercial',1,1,0,0,5),
(43,0,'','Mi rana','1411567515.jpg','admin','2014-09-24 16:05:15','comercial',1,1,0,0,6),
(44,0,'','Lata Amena','1411567537.jpg','admin','2014-09-24 16:05:37','comercial',1,0,0,0,5),
(45,0,'','La niña maru','1411568077.jpg','admin','2014-09-24 16:14:37','comercial',2,0,0,0,5),
(46,0,'','Felicitación cumpleaños','1411568101.jpg','admin','2014-09-24 16:15:01','comercial',1,0,0,0,5),
(47,0,'','Mi gato','1411568120.jpg','admin','2014-09-24 16:15:20','comercial',1,0,0,0,6),
(48,0,'','Tarta de chocolate','1411568140.jpg','borja','2014-09-24 16:15:40','comercial',1,1,0,0,4),
(49,0,'','Cagarruta ed algo','1411568191.jpg','david','2014-09-24 16:16:31','comercial',1,2,0,0,5),
(50,0,'','Corriendo bajo la nieve','1411568211.jpg','admin','2014-09-24 16:16:51','comercial',1,0,0,0,5),
(51,0,'','Koala','1411568227.jpg','borja','2014-09-24 16:17:07','comercial',1,1,0,0,6),
(52,0,'','Corazon naranja','1411568249.jpg','david','2014-09-24 16:17:29','comercial',1,1,0,0,5),
(53,0,'','Monitos sonrientes','1411568276.jpg','admin','2014-09-24 16:17:56','comercial',1,1,0,0,6),
(54,0,'','El inspector Gadget','1411568294.jpg','david','2014-09-24 16:18:14','comercial',1,1,0,0,3),
(55,0,'','Logo whatsapp','1411568326.jpg','admin','2014-09-24 16:18:46','comercial',1,0,0,0,5),
(56,0,'','Escalera','1411733326.jpg','borja','2014-09-26 14:08:46','comercial',1,1,0,0,5),
(57,0,'','All Blacks','1411733362.jpg','david','2014-09-26 14:09:22','comercial',1,1,0,0,5),
(58,0,'','Pasarela Kiabi','1415181923.png','admin','2014-11-05 11:05:23','comercial',1,0,0,0,5),
(59,0,'','Prueba','1417176379.jpg','admin','2014-11-28 13:06:19','comercial',0,0,0,0,0),
(60,0,'','Calendario Febrero 2015','1425078187.png','admin','2015-02-28 00:03:07','comercial',1,0,0,0,1),
(61,48,'','Un mapa del mundo','1425079989.png','dcancho','2015-02-28 00:33:09','comercial',1,2,0,0,5),
(62,0,'','Calendario marzo 2015','1426293468.jpg','borja','2015-03-14 01:37:48','comercial',1,1,0,0,1),
(63,48,'','Prueba reto','1453205356.png','pedro','2016-01-19 13:09:16','comercial',1,1,0,0,6),
(64,0,'','Por la carretera','1458206720.jpg','admin','2016-03-17 10:25:20','comercial',1,0,0,0,5),
(65,0,'','Lineas adicionales','1467287918.jpg','admin','2016-06-30 13:58:38','comercial',1,0,0,0,5),
(69,0,'banners','Un banner','1480600721.jpg','admin','2016-12-01 14:58:41','',1,0,0,0,39),
(68,0,'animados','Redeption2','1480600552.gif','admin','2016-12-01 14:55:52','comercial',1,0,0,0,2),
(70,0,'musica','Melendi','1480602406.jpg','admin','2016-12-01 15:26:46','',1,0,0,0,5);

/*Table structure for table `galeria_fotos_albumes` */

DROP TABLE IF EXISTS `galeria_fotos_albumes`;

CREATE TABLE `galeria_fotos_albumes` (
  `id_album` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_album` varchar(250) NOT NULL DEFAULT '',
  `date_album` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username_album` varchar(100) NOT NULL DEFAULT '',
  `canal_album` varchar(100) NOT NULL DEFAULT '',
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_album`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

/*Data for the table `galeria_fotos_albumes` */

insert  into `galeria_fotos_albumes`(`id_album`,`nombre_album`,`date_album`,`username_album`,`canal_album`,`activo`) values 
(1,'Meses del año - Calendario','2014-09-10 11:15:15','admin','',1),
(2,'Capturas de pantalla','2014-09-23 17:00:07','admin','',1),
(3,'Avatars','2014-09-24 10:23:04','admin','comercial,gerente,test',1),
(4,'Comida','2014-09-24 11:05:03','admin','',1),
(5,'Miscelania','2014-09-24 11:05:16','admin','gerente',1),
(6,'Animales','2014-09-24 15:58:56','admin','',1),
(36,'test','2016-05-09 12:53:13','admin','',0),
(35,'','2015-02-28 01:04:33','admin','',0),
(34,'aaaaaa11111','2014-10-01 13:19:45','admin','',0),
(33,'A1- test333','2014-10-01 13:18:29','admin','',0),
(37,'test','2016-12-01 11:22:04','admin','test',1),
(38,'prueba','2016-12-01 14:26:45','admin','admin',1),
(39,'album en comercial','2016-12-01 14:29:11','pedro','comercial',1);

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
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

/*Data for the table `galeria_fotos_comentarios` */

insert  into `galeria_fotos_comentarios`(`id_comentario`,`id_file`,`comentario`,`user_comentario`,`date_comentario`,`votaciones`,`estado`) values 
(1,2,'un comentario en la foto','admin','2014-09-23 17:16:56',0,1),
(2,2,'Otro comentario mas!!!!','admin','2014-09-23 17:21:57',0,1),
(3,18,'gggggggg','admin','2014-09-24 13:34:10',0,1),
(4,24,'Una boca muy sonriente','admin','2014-09-25 17:04:41',0,1),
(5,53,'un comentario','admin','2014-09-25 17:05:12',0,1),
(6,52,'mas comentariosssss','admin','2014-09-25 17:05:41',0,1),
(7,2,'Un comentario mas pa la foto','admin','2014-09-25 17:06:30',0,1),
(8,51,'asdfasdf','admin','2014-09-25 17:08:11',0,1),
(9,51,'asdfasdfasdf','admin','2014-09-25 17:08:14',0,1),
(10,51,'asdfasdf','admin','2014-09-25 17:08:17',0,1),
(11,40,'sdfgdsfg','admin','2014-09-25 17:08:43',0,1),
(12,40,'asdfasdf','admin','2014-09-25 17:08:46',0,1),
(13,40,'sdfg','admin','2014-09-25 17:08:58',0,1),
(14,51,'sdfgdsfg','admin','2014-09-25 17:09:34',0,1),
(15,51,'sdfg','admin','2014-09-25 17:09:46',0,1),
(16,42,'Felices fiestas','admin','2014-09-25 17:28:16',0,1),
(17,53,'Como se ríen los monos','admin','2014-09-25 17:37:14',0,1),
(18,2,'ptptptpt','admin','2014-09-25 17:51:28',0,1),
(19,2,'otro comentario','admin','2014-09-25 17:54:16',0,1),
(20,42,'Hola!!!!!','david','2014-09-25 17:55:12',0,1),
(21,43,'Mi ranita verde!!!!','david','2014-09-25 17:57:12',0,1),
(22,36,'fdfgdfg dfgdf','david','2014-09-26 09:17:18',0,1),
(23,36,'fgh fghf gh','david','2014-09-26 09:17:21',0,1),
(24,38,'Pedazo hamgurguesa!!','admin','2014-09-26 11:29:39',0,1),
(25,55,'Me gusta el logo','admin','2014-09-26 11:53:37',0,1),
(26,2,'Otro comentario','admin','2014-09-26 12:10:29',0,1),
(27,38,'Me gusta','admin','2014-09-26 14:06:37',0,1),
(28,19,'Con zanahorias????','admin','2014-09-26 14:13:26',0,1),
(29,39,'Esta esta repetida','admin','2014-09-26 14:15:33',0,1),
(30,21,'Turrón? o gomas de borrar?','admin','2014-09-29 10:40:04',0,1),
(31,40,'Bonito grafico','admin','2014-09-29 10:41:01',0,1),
(32,43,'esta bien!!','admin','2014-09-29 10:43:21',0,1),
(33,49,'¿Que es, quien lo adivina?','admin','2014-09-29 10:44:17',0,1),
(34,43,'La rana verde esta de vuelta','admin','2014-09-29 15:57:15',0,1),
(35,55,'Pues a mi no me gusta nada, creo que es una caca !!!','david','2014-09-29 18:00:35',0,1),
(36,3,'Por fin Septiembre!!!!','admin','2014-10-03 10:38:16',0,1),
(37,2,'otrooooooo','admin','2014-10-09 09:07:57',0,1),
(38,2,'otro comentario','admin','2014-10-09 09:12:00',0,1),
(39,2,'ddddd','admin','2014-10-09 11:42:40',0,1),
(40,57,'Menudos bichos!!!!','admin','2014-10-15 12:36:15',0,1),
(41,57,'Esta muy bien','admin','2014-10-21 15:07:15',0,1),
(42,49,'Un mojón?','admin','2014-10-21 15:07:41',0,1),
(43,57,'No esta mal','david','2014-12-02 13:52:55',0,1),
(52,60,'EL nuevo calendario del mes de Febrero. Dos días pal saco','admin','2015-02-28 00:05:06',0,1),
(51,54,'sdfsd','admin','2015-02-27 13:10:17',0,1),
(50,56,'algo','admin','2015-02-27 13:10:06',0,1),
(49,57,'otro','admin','2015-02-27 12:50:13',0,1),
(53,56,'¿algún comentario más?','admin','2015-03-17 14:34:01',0,1),
(54,62,'Marzo lluvioso','admin','2015-03-17 14:39:13',0,1),
(55,61,'dddddd','admin','2016-01-19 12:55:58',0,1),
(56,58,'test img','pedro','2016-03-10 15:56:52',0,1),
(57,37,'canal gerentes!!!!!!!!!!','admin','2016-03-10 16:05:44',0,1),
(58,64,'Muy.....','admin','2016-03-17 10:26:58',0,1),
(59,64,'pos si','admin','2016-09-27 17:00:07',0,1),
(60,69,'me gusta','pedro','2016-12-01 15:01:06',0,1),
(61,69,'me encanta','admin','2016-12-01 15:01:34',0,1),
(62,14,'dsfsdf ','admin','2016-12-14 11:51:28',0,1);

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
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

/*Data for the table `galeria_fotos_votaciones` */

insert  into `galeria_fotos_votaciones`(`id_votacion`,`id_file`,`user_votacion`,`date_votacion`) values 
(1,6,'david','2014-09-23 17:33:56'),
(2,42,'david','2014-09-25 17:54:58'),
(3,43,'david','2014-09-25 17:57:16'),
(4,36,'david','2014-09-26 09:17:23'),
(5,53,'david','2014-09-29 17:57:17'),
(6,49,'david','2014-09-29 17:58:23'),
(7,49,'admin','2014-10-21 15:07:44'),
(8,57,'admin','2014-10-30 14:13:25'),
(9,52,'admin','2015-02-27 12:51:43'),
(10,56,'admin','2015-02-27 12:53:56'),
(11,54,'admin','2015-02-27 13:10:13'),
(12,62,'admin','2015-03-17 14:38:52'),
(13,61,'admin','2016-01-19 12:56:02'),
(14,61,'pedro','2016-01-19 13:06:20'),
(15,51,'admin','2016-02-12 14:10:37'),
(16,63,'admin','2016-11-16 10:17:19'),
(17,48,'admin','2016-11-16 10:22:43');

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
  `views` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_file`),
  KEY `user_add` (`user_add`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `galeria_videos` */

insert  into `galeria_videos`(`id_file`,`id_promocion`,`tipo_video`,`titulo`,`name_file`,`user_add`,`date_video`,`canal`,`estado`,`videos_puntos`,`seleccion_reto`,`formacion`,`views`) values 
(1,0,'','Bolitas de colores','1341398825_animacion_bolitas_de_colores.mp4.mp4','admin','2014-07-15 14:18:19','comercial',1,0,0,0,5),
(3,0,'Formación','Trabajo en equipo','1350573259_trabajo_en_equipo-hormigas.wmv.mp4','david','2014-07-16 09:39:25','comercial',1,1,0,0,1),
(4,48,'Animación','Aventura juntos I','1347869224_video_2_inicio_de_la_aventura_juntos_reducido.avi.mp4','admin','2014-07-19 10:04:43','comercial',1,1,0,0,1),
(5,0,'Animación','Aventura juntos II','1348036284_video_2_inicio_de_la_aventura_juntos_reducido__2.avi.mp4','david','2014-08-01 10:04:49','comercial',1,1,0,0,1),
(6,48,'Animación','Cataratas','1348744180_cataratas.mp4.mp4','admin','2014-08-23 10:05:32','comercial',1,1,0,0,3),
(7,0,'Animales, Animación','Peces de colores','1325060467_peces.wmv.mp4','admin','2014-09-24 17:33:46','gerente',1,0,0,0,2),
(8,48,'Animales','Caracol','1328275644_wmv-06_empresas_caracol.wmv.mp4','borja','2014-09-29 17:35:02','comercial',1,1,0,0,12),
(9,47,'Retos','video reto1','1453190138.mp4','admin','2016-01-19 08:55:38','test',0,0,0,0,0),
(10,48,'Formación','Otro video de apoyo','1453200650.mp4','admin','2016-01-19 11:50:50','test',0,0,0,0,0);

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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

/*Data for the table `galeria_videos_comentarios` */

insert  into `galeria_videos_comentarios`(`id_comentario`,`id_file`,`comentario`,`user_comentario`,`date_comentario`,`votaciones`,`estado`) values 
(1,1,'Me gusta el video','admin','2014-07-16 15:34:44',0,1),
(2,1,'Aunque se puede mejorar','admin','2014-07-16 15:35:37',0,1),
(3,1,'otro comentario más para el video','admin','2014-07-17 12:55:03',1,1),
(4,1,'me gustan los videos','admin','2014-07-17 12:55:15',0,1),
(5,1,'Otro comentario par el video 1','david','2014-07-17 14:04:06',1,1),
(6,6,'comentario pal abuelo','david','2014-07-17 14:05:49',1,1),
(7,6,'Esta gracioso el vídeo!!!!','admin','2014-09-19 13:28:29',0,1),
(8,6,'A ver si subís más viídeos','admin','2014-09-19 13:36:58',0,1),
(9,6,'otro comentario pal video','admin','2014-09-29 13:19:41',1,1),
(10,8,'Carreara de caracoles','admin','2014-09-29 17:46:17',0,1),
(11,6,'Pues más comentarios para el vídeo del abuelo','david','2014-09-29 17:59:44',0,1),
(12,8,'Las fotos se ven un poco borrosas','admin','2014-10-03 10:37:41',0,1),
(13,8,'Curioso video \'Ozu','admin','2014-12-04 13:27:01',0,1),
(14,7,'Un comentario para el video del pez','admin','2015-02-27 14:00:44',0,1),
(15,8,'otro comentario','admin','2015-03-02 10:33:12',0,1);

/*Table structure for table `galeria_videos_comentarios_votaciones` */

DROP TABLE IF EXISTS `galeria_videos_comentarios_votaciones`;

CREATE TABLE `galeria_videos_comentarios_votaciones` (
  `id_votacion` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_comentario` int(11) NOT NULL DEFAULT '0',
  `user_votacion` varchar(100) NOT NULL DEFAULT '',
  `date_votacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_votacion`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `galeria_videos_comentarios_votaciones` */

insert  into `galeria_videos_comentarios_votaciones`(`id_votacion`,`id_comentario`,`user_votacion`,`date_votacion`) values 
(1,5,'admin','2014-07-17 14:04:59'),
(2,3,'david','2014-07-17 14:05:13'),
(3,6,'admin','2014-09-29 13:20:39'),
(4,9,'david','2014-09-29 17:59:16');

/*Table structure for table `galeria_videos_views` */

DROP TABLE IF EXISTS `galeria_videos_views`;

CREATE TABLE `galeria_videos_views` (
  `id_view` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_file` int(11) unsigned NOT NULL DEFAULT '0',
  `username` varchar(100) CHARACTER SET latin1 DEFAULT '',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_view`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

/*Data for the table `galeria_videos_views` */

insert  into `galeria_videos_views`(`id_view`,`id_file`,`username`,`date`) values 
(1,1,'admin','2014-09-29 17:01:32'),
(2,6,'admin','2014-09-29 17:01:46'),
(3,3,'admin','2014-09-29 17:01:58'),
(4,7,'admin','2014-09-29 17:34:01'),
(5,8,'admin','2014-09-29 17:35:24'),
(6,8,'admin','2014-09-29 17:36:05'),
(7,6,'admin','2014-09-29 17:36:17'),
(8,5,'admin','2014-09-29 17:36:25'),
(9,8,'david','2014-09-29 17:58:41'),
(10,4,'david','2014-09-29 17:59:00'),
(11,8,'david','2014-10-11 18:16:32'),
(12,8,'david','2014-10-11 18:16:32'),
(13,8,'david','2014-10-11 18:16:49'),
(14,8,'david','2014-10-11 18:16:49'),
(15,8,'david','2014-10-11 18:17:08'),
(16,8,'david','2014-10-11 18:17:08'),
(17,8,'admin','2014-10-22 11:22:00'),
(18,8,'admin','2014-11-21 11:59:33'),
(19,7,'admin','2015-11-12 17:42:17'),
(20,8,'admin','2016-09-12 10:24:31');

/*Table structure for table `galeria_videos_votaciones` */

DROP TABLE IF EXISTS `galeria_videos_votaciones`;

CREATE TABLE `galeria_videos_votaciones` (
  `id_votacion` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_file` int(11) NOT NULL DEFAULT '0',
  `user_votacion` varchar(100) NOT NULL DEFAULT '',
  `date_votacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_votacion`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `galeria_videos_votaciones` */

insert  into `galeria_videos_votaciones`(`id_votacion`,`id_file`,`user_votacion`,`date_votacion`) values 
(1,3,'admin','2014-07-16 09:52:55'),
(2,6,'admin','2014-07-16 11:03:55'),
(3,4,'admin','2014-07-16 12:35:49'),
(4,5,'admin','2014-07-16 12:36:09'),
(5,8,'admin','2015-02-27 11:56:58');

/*Table structure for table `incentives_fabricantes` */

DROP TABLE IF EXISTS `incentives_fabricantes`;

CREATE TABLE `incentives_fabricantes` (
  `id_fabricante` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_fabricante` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `activo_fabricante` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_fabricante`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `incentives_fabricantes` */

insert  into `incentives_fabricantes`(`id_fabricante`,`nombre_fabricante`,`activo_fabricante`) values 
(1,'Samsung',1),
(2,'Huawei',1),
(3,'Apple',1);

/*Table structure for table `incentives_objetivos` */

DROP TABLE IF EXISTS `incentives_objetivos`;

CREATE TABLE `incentives_objetivos` (
  `id_objetivo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_objetivo` varchar(250) NOT NULL DEFAULT '',
  `tipo_objetivo` varchar(100) NOT NULL DEFAULT '',
  `date_ini_objetivo` date NOT NULL,
  `date_fin_objetivo` date NOT NULL,
  `activo_objetivo` tinyint(1) NOT NULL DEFAULT '1',
  `ranking_objetivo` tinyint(1) NOT NULL DEFAULT '0',
  `perfil_objetivo` varchar(100) NOT NULL DEFAULT '',
  `canal_objetivo` varchar(100) NOT NULL DEFAULT 'coches',
  PRIMARY KEY (`id_objetivo`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Data for the table `incentives_objetivos` */

insert  into `incentives_objetivos`(`id_objetivo`,`nombre_objetivo`,`tipo_objetivo`,`date_ini_objetivo`,`date_fin_objetivo`,`activo_objetivo`,`ranking_objetivo`,`perfil_objetivo`,`canal_objetivo`) values 
(1,'Ranking de usuarios anual','Usuario','2015-01-01','2016-12-31',1,1,'','comercial'),
(17,'Prueba','Usuario','2016-07-05','2016-07-20',0,1,'usuario','comercial'),
(18,'Dos canales','Usuario','2016-12-14','2017-02-17',1,1,'usuario','comercial,test');

/*Table structure for table `incentives_objetivos_detalle` */

DROP TABLE IF EXISTS `incentives_objetivos_detalle`;

CREATE TABLE `incentives_objetivos_detalle` (
  `id_detalle` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_objetivo` int(11) NOT NULL DEFAULT '0',
  `destino_objetivo` varchar(100) NOT NULL DEFAULT '' COMMENT 'username o cod_tienda dependiendo si es un objetivo de tienda o de usuario',
  `id_producto` int(11) NOT NULL DEFAULT '0',
  `valor_objetivo` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_detalle`),
  KEY `id_objetivo` (`id_objetivo`),
  KEY `id_producto` (`id_producto`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

/*Data for the table `incentives_objetivos_detalle` */

insert  into `incentives_objetivos_detalle`(`id_detalle`,`id_objetivo`,`destino_objetivo`,`id_producto`,`valor_objetivo`) values 
(1,1,'',3,15);

/*Table structure for table `incentives_productos` */

DROP TABLE IF EXISTS `incentives_productos`;

CREATE TABLE `incentives_productos` (
  `id_producto` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `referencia_producto` varchar(100) CHARACTER SET latin1 NOT NULL,
  `nombre_producto` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `id_fabricante` int(11) NOT NULL DEFAULT '0',
  `activo_producto` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_producto`,`id_fabricante`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `incentives_productos` */

insert  into `incentives_productos`(`id_producto`,`referencia_producto`,`nombre_producto`,`id_fabricante`,`activo_producto`) values 
(3,'ERE-5654123','Note 4',1,1),
(4,'IP-54122','Iphone 6',3,1),
(5,'IP-78969','Ipad 2',3,1),
(6,'H-89984','Ascend P7',2,1),
(7,'H-85213','Ascend Mate7',2,1),
(8,'H-2356564','Ascend G7',2,1),
(9,'SX11212','Samsung S5',1,1),
(12,'A1','Canal test',3,1);

/*Table structure for table `incentives_productos_aceleradores` */

DROP TABLE IF EXISTS `incentives_productos_aceleradores`;

CREATE TABLE `incentives_productos_aceleradores` (
  `id_acelerador` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL DEFAULT '0',
  `valor_acelerador` double NOT NULL DEFAULT '0',
  `date_ini` date NOT NULL,
  `date_fin` date NOT NULL,
  PRIMARY KEY (`id_acelerador`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `incentives_productos_aceleradores` */

insert  into `incentives_productos_aceleradores`(`id_acelerador`,`id_producto`,`valor_acelerador`,`date_ini`,`date_fin`) values 
(3,3,2,'2015-01-31','2015-02-28'),
(4,6,24,'2015-03-04','2015-03-11'),
(8,3,15,'2015-03-18','2015-03-26'),
(9,3,5,'2015-03-05','2015-03-11'),
(10,8,3,'2015-06-15','2015-06-15'),
(11,9,10,'2015-12-01','2015-12-31');

/*Table structure for table `incentives_productos_puntos` */

DROP TABLE IF EXISTS `incentives_productos_puntos`;

CREATE TABLE `incentives_productos_puntos` (
  `id_puntos` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL DEFAULT '0',
  `puntos` double NOT NULL DEFAULT '0',
  `date_ini` date NOT NULL,
  `date_fin` date NOT NULL,
  `canal_puntos` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_puntos`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `incentives_productos_puntos` */

insert  into `incentives_productos_puntos`(`id_puntos`,`id_producto`,`puntos`,`date_ini`,`date_fin`,`canal_puntos`) values 
(5,5,5,'2015-03-22','2017-03-09','comercial'),
(6,3,4,'2015-01-31','2017-03-09','comercial'),
(7,7,50,'2015-03-01','2017-03-09','comercial'),
(9,8,5,'2015-06-01','2017-03-09','comercial'),
(10,9,15,'2015-12-18','2017-03-09','comercial'),
(11,9,10,'2015-12-01','2017-03-09','comercial'),
(14,8,7,'2016-12-05','2016-12-30','gerente,test');

/*Table structure for table `incentives_ventas` */

DROP TABLE IF EXISTS `incentives_ventas`;

CREATE TABLE `incentives_ventas` (
  `id_venta` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL DEFAULT '0',
  `cantidad_venta` double NOT NULL DEFAULT '0',
  `username_venta` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `fecha_venta` date NOT NULL,
  `fecha_venta_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `detalle_venta` varchar(250) NOT NULL DEFAULT '',
  `tendencia_venta` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_venta`),
  KEY `id_producto` (`id_producto`),
  KEY `username_venta` (`username_venta`),
  KEY `fecha_venta` (`fecha_venta`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

/*Data for the table `incentives_ventas` */

insert  into `incentives_ventas`(`id_venta`,`id_producto`,`cantidad_venta`,`username_venta`,`fecha_venta`,`fecha_venta_add`,`detalle_venta`,`tendencia_venta`) values 
(1,3,10,'dgarcia','2015-03-01','2015-03-05 13:46:08','',''),
(2,3,15,'dramos','2015-03-04','2015-03-05 13:46:08','',''),
(3,3,10,'dgarcia','2015-03-02','2015-03-05 13:47:19','',''),
(4,3,15,'pedro','2015-03-02','2015-03-05 13:47:19','',''),
(5,3,20,'dgarcia','2015-03-03','2015-03-05 13:47:55','',''),
(6,3,15,'pedro','2015-03-02','2015-03-05 13:47:55','',''),
(7,3,5,'senen','2015-03-04','2015-03-05 13:59:08','',''),
(8,3,5,'pedro','2015-03-02','2015-03-05 13:59:08','',''),
(9,5,8,'odelgado','2015-03-10','2015-03-10 11:42:34','',''),
(10,8,2,'david','2016-12-12','2016-12-14 12:39:47','',''),
(11,8,1,'borja','2016-12-12','2016-12-14 12:39:47','',''),
(12,8,3,'pedro','2016-12-12','2016-12-14 12:39:47','',''),
(13,8,1,'claudio','2016-12-12','2016-12-14 12:39:47','',''),
(14,8,2,'20266370N','2016-12-12','2016-12-14 12:39:47','',''),
(15,8,1,'dmarchante','2016-12-12','2016-12-14 12:39:47','','');

/*Table structure for table `incentives_ventas_puntos` */

DROP TABLE IF EXISTS `incentives_ventas_puntos`;

CREATE TABLE `incentives_ventas_puntos` (
  `id_puntos_venta` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username_puntuacion` varchar(100) NOT NULL DEFAULT '',
  `puntuacion_venta` double NOT NULL DEFAULT '0',
  `id_producto_venta` int(11) NOT NULL DEFAULT '0',
  `date_venta` date NOT NULL,
  `date_venta_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `puntuacion_detalle` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_puntos_venta`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `incentives_ventas_puntos` */

insert  into `incentives_ventas_puntos`(`id_puntos_venta`,`username_puntuacion`,`puntuacion_venta`,`id_producto_venta`,`date_venta`,`date_venta_add`,`puntuacion_detalle`) values 
(1,'dgarcia',4,3,'2015-03-01','2015-03-05 13:47:19',''),
(2,'pedro',0,3,'2015-02-02','2015-03-05 13:47:19',''),
(3,'dgarcia',8,3,'2015-03-02','2015-03-05 13:47:55',''),
(4,'pedro',0,3,'2015-02-02','2015-03-05 13:47:55',''),
(5,'admin',8,3,'2015-03-03','2015-03-05 13:59:08',''),
(6,'pedro',2,3,'2015-02-02','2015-03-05 13:59:08',''),
(7,'senen',1,3,'2015-03-04','2015-03-09 12:53:38',''),
(8,'david',10,8,'2016-12-12','2016-12-14 12:39:47',''),
(9,'borja',5,8,'2016-12-12','2016-12-14 12:39:47',''),
(10,'pedro',21,8,'2016-12-12','2016-12-14 12:39:47',''),
(11,'claudio',7,8,'2016-12-12','2016-12-14 12:39:47',''),
(12,'20266370N',10,8,'2016-12-12','2016-12-14 12:39:47',''),
(13,'dmarchante',5,8,'2016-12-12','2016-12-14 12:39:47','');

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
  `download` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_info`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `info` */

insert  into `info`(`id_info`,`titulo_info`,`file_info`,`tipo_info`,`canal_info`,`date_info`,`id_campaign`,`download`) values 
(1,'Fichero excel modelo mailing','1399279474_model_mailing.xls',8,'todos','2014-05-05 10:44:34',1,1),
(2,'Otro ducumento en la sección','1399281294_259-phoenix-aristotelian.mp3',6,'todos','2014-05-05 11:14:54',2,1),
(3,'Un vídeo en servicios','1399542344_1338542451_ve.1338542185521.mp4.mp4',5,'todos','2014-05-08 11:45:44',2,1),
(4,'Fichero de audio de descarga1','1399556768_model_mailing.xls',7,'todos','2014-05-08 15:46:08',2,1),
(5,'Un documento de imagen','1415024994_flatinspiration04.jpg',8,'todos','2014-11-03 15:29:54',1,1),
(6,'Prueba enlaces','http://google.es',9,'todos','2014-11-11 09:54:58',1,0),
(7,'Mapamundi2','1425296310_map.png',8,'todos','2015-03-02 12:18:56',3,1),
(8,'Logo Cualtis','1425296730_cualtis_vertical.png',8,'todos','2015-03-02 12:45:30',3,1),
(9,'file test canales','1480611559_bg.jpg',5,'comercial,gerente','2016-12-01 17:44:09',8,1),
(10,'test22','1480611631_image_facebook.png',5,'comercial,gerente,test','2016-12-01 18:00:31',8,1),
(11,'test3','1480611907_bg.jpg',5,'gerente,test','2016-12-01 18:05:07',1,1),
(12,'test doc','1480668662_4gencasa.xls',8,'comercial,gerente,test','2016-12-02 09:51:02',1,1);

/*Table structure for table `info_alerts` */

DROP TABLE IF EXISTS `info_alerts`;

CREATE TABLE `info_alerts` (
  `id_info` int(11) NOT NULL DEFAULT '0',
  `username_alert` varchar(100) NOT NULL DEFAULT '',
  `date_alert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_info`,`username_alert`),
  KEY `id_info` (`id_info`),
  KEY `username_alert` (`username_alert`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `info_alerts` */

insert  into `info_alerts`(`id_info`,`username_alert`,`date_alert`) values 
(1,'admin','2015-03-13 18:34:31'),
(2,'admin','2015-03-13 18:34:31'),
(4,'admin','2015-03-13 18:38:48'),
(6,'admin','2015-03-13 18:36:54'),
(7,'admin','2015-03-13 18:34:31'),
(8,'admin','2015-03-13 18:56:28'),
(3,'admin','2015-03-13 18:56:28'),
(5,'borja','2015-03-13 18:38:40'),
(5,'admin','2015-03-13 18:36:54'),
(4,'borja','2015-03-13 18:36:12'),
(2,'borja','2015-03-13 18:38:40'),
(6,'borja','2015-03-13 18:35:48'),
(7,'borja','2015-03-13 18:35:48'),
(8,'borja','2015-03-13 18:35:48'),
(1,'pedro','2015-08-14 10:18:38'),
(2,'pedro','2015-08-14 10:18:38'),
(3,'pedro','2015-08-14 10:18:38'),
(4,'pedro','2015-08-14 10:18:38'),
(5,'pedro','2015-08-14 10:18:38'),
(6,'pedro','2015-08-14 10:18:38'),
(7,'pedro','2015-08-14 10:18:38'),
(8,'pedro','2015-08-14 10:18:38'),
(1,'senen','2015-10-27 13:17:58'),
(2,'senen','2015-10-27 13:17:58'),
(3,'senen','2015-10-27 13:17:58'),
(4,'senen','2015-10-27 13:17:58'),
(5,'senen','2015-10-27 13:17:58'),
(6,'senen','2015-10-27 13:17:58'),
(7,'senen','2015-10-27 13:17:58'),
(8,'senen','2015-10-27 13:17:58'),
(1,'claudio','2016-03-14 10:21:35'),
(2,'claudio','2016-03-14 10:21:35'),
(3,'claudio','2016-03-14 10:21:35'),
(4,'claudio','2016-03-14 10:21:35'),
(5,'claudio','2016-03-14 10:21:35'),
(6,'claudio','2016-03-14 10:21:35'),
(7,'claudio','2016-03-14 10:21:35'),
(8,'claudio','2016-03-14 10:21:35'),
(1,'jgonzalez','2016-10-14 09:42:49'),
(2,'jgonzalez','2016-10-14 09:42:49'),
(3,'jgonzalez','2016-10-14 09:42:49'),
(4,'jgonzalez','2016-10-14 09:42:49'),
(5,'jgonzalez','2016-10-14 09:42:49'),
(6,'jgonzalez','2016-10-14 09:42:49'),
(7,'jgonzalez','2016-10-14 09:42:49'),
(8,'jgonzalez','2016-10-14 09:42:49'),
(9,'admin','2016-12-01 18:07:05'),
(10,'admin','2016-12-01 18:07:05'),
(11,'admin','2016-12-01 18:07:05'),
(9,'pedro','2016-12-02 09:08:02'),
(10,'pedro','2016-12-02 09:08:02'),
(11,'pedro','2016-12-02 09:08:02'),
(12,'admin','2016-12-02 09:51:07'),
(12,'pedro','2016-12-22 09:33:47');

/*Table structure for table `info_tipo` */

DROP TABLE IF EXISTS `info_tipo`;

CREATE TABLE `info_tipo` (
  `id_tipo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_info` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `foto_info` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT '',
  PRIMARY KEY (`id_tipo`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `info_tipo` */

insert  into `info_tipo`(`id_tipo`,`nombre_info`,`foto_info`) values 
(5,'Video','productos.jpg'),
(6,'SMS','servicios.jpg'),
(7,'Audio','audio.jpg'),
(8,'Fichero','fichero.jpg'),
(9,'Enlace','');

/*Table structure for table `info_views` */

DROP TABLE IF EXISTS `info_views`;

CREATE TABLE `info_views` (
  `id_view` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_file` int(11) NOT NULL DEFAULT '0',
  `username_view` varchar(100) NOT NULL DEFAULT '',
  `date_view` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_view`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `info_views` */

insert  into `info_views`(`id_view`,`id_file`,`username_view`,`date_view`) values 
(1,11,'admin','2016-12-22 09:22:48'),
(2,11,'admin','2016-12-22 09:23:19'),
(3,8,'admin','2016-12-22 09:26:05'),
(4,8,'admin','2016-12-22 09:27:10'),
(5,8,'admin','2016-12-22 09:27:12'),
(6,12,'pedro','2016-12-22 09:34:14'),
(7,11,'pedro','2016-12-22 09:34:35'),
(8,11,'pedro','2016-12-22 09:34:38');

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `infotopdf` */

insert  into `infotopdf`(`id_info`,`titulo_info`,`file_info`,`tipo_info`,`canal_info`,`date_info`,`id_campaign`,`cuerpo_info`) values 
(4,'Documento producto','1398851418_1398779046_bg.jpg',5,'todos','2014-04-25 20:15:09',1,NULL),
(5,'Otro en productos','1398851402_1398778978_bg01.jpg',5,'todos','2014-04-25 20:15:32',2,NULL),
(6,'Caso practico 4.1','1398851346_1398778935_bg01.jpeg\r\n',5,'todos','2014-04-28 16:48:17',2,'<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width: 500px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td colspan=\"2\">\r\n				<img alt=\"\" src=\"http://localhost/community-php/images/mailing/images/1398327405_bg01.jpg\" style=\"width: 1200px; height: 294px;\" /></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://192.168.0.8/community-php/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td>\r\n				<span>En un lugar de la Mancha, de cuyo nombre no quiero acordarme, no ha mucho tiempo que viv&iacute;a un hidalgo de los de lanza en astillero, adarga antigua, roc&iacute;n flaco y galgo corredor. Una olla de algo m&aacute;s vaca que carnero, salpic&oacute;n las m&aacute;s noches, duelos y quebrantos los s&aacute;bados, lantejas los viernes, alg&uacute;n palomino de a&ntilde;adidura los domingos, consum&iacute;an las tres partes de su hacienda</span></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				[USER_LOGO]</td>\r\n			<td>\r\n				<br />\r\n				[CLAIM_PROMOCION]. Con un descuento de <span style=\"font-size: 14px;\"><strong>[DESCUENTO_PROMOCION]%</strong></span><br />\r\n				<br />\r\n				<span style=\"color: rgb(197, 71, 71);\">oferta v&aacute;lida hasta [DATE_PROMOCION]</span><br />\r\n				<br />\r\n				<br />\r\n				Hasta la pr&oacute;xima [USER_EMPRESA]</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				&nbsp;</td>\r\n			<td>\r\n				[USER_DIRECCION]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n'),
(7,'Lorem ipsum dolor sit','1398851346_1398778935_bg01.jpg',7,'todos','2014-04-28 16:48:42',1,'<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width: 500px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://media.imagar.com/essilor/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td>\r\n				En un lugar de la Mancha, de cuyo nombre no quiero acordarme, no ha mucho tiempo que viv&iacute;a un hidalgo de los de lanza en astillero, adarga antigua, roc&iacute;n flaco y galgo corredor. Una olla de algo m&aacute;s vaca que carnero, salpic&oacute;n las m&aacute;s noches, duelos y quebrantos los s&aacute;bados, lantejas los viernes, alg&uacute;n palomino de a&ntilde;adidura los domingos, consum&iacute;an las tres partes de su hacienda</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				[USER_LOGO]</td>\r\n			<td>\r\n				<br />\r\n				[CLAIM_PROMOCION]. Con un descuento de <span style=\"font-size: 14px;\"><strong>[DESCUENTO_PROMOCION]%</strong></span><br />\r\n				<br />\r\n				<span style=\"color: rgb(197, 71, 71);\">oferta v&aacute;lida hasta [DATE_PROMOCION]</span><br />\r\n				<br />\r\n				<br />\r\n				Hasta la pr&oacute;xima [USER_EMPRESA]</td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				&nbsp;</td>\r\n			<td>\r\n				[USER_DIRECCION]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n');

/*Table structure for table `infotopdf_tipo` */

DROP TABLE IF EXISTS `infotopdf_tipo`;

CREATE TABLE `infotopdf_tipo` (
  `id_tipo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_info` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `foto_info` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `size_info` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT '',
  PRIMARY KEY (`id_tipo`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `infotopdf_tipo` */

insert  into `infotopdf_tipo`(`id_tipo`,`nombre_info`,`foto_info`,`size_info`) values 
(5,'Díptico DIN A5','btn-0007.png','A5'),
(6,'DIN A4','btn-0006.png','A4'),
(7,'Carta','btn-0004.png','LETTER'),
(8,'Postales','btn-0003.png','LETTER'),
(9,'Tarjetones','btn-0005.png','EXECUTIVE');

/*Table structure for table `mailing_blacklist` */

DROP TABLE IF EXISTS `mailing_blacklist`;

CREATE TABLE `mailing_blacklist` (
  `email_black` varchar(250) CHARACTER SET latin1 NOT NULL,
  `date_black` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`email_black`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `mailing_blacklist` */

/*Table structure for table `mailing_lists` */

DROP TABLE IF EXISTS `mailing_lists`;

CREATE TABLE `mailing_lists` (
  `id_list` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name_list` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `user_list` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `date_list` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_list`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `mailing_lists` */

insert  into `mailing_lists`(`id_list`,`name_list`,`user_list`,`date_list`,`activo`) values 
(1,'Clientes VIP','admin','2014-05-06 12:31:33',1),
(2,'Segunda lista de envío','20266370N','2014-05-06 13:42:39',1),
(3,'Lista de cumpleaños12','admin','2014-05-06 13:44:45',0),
(4,'111111111','admin','2014-05-06 13:45:18',0),
(5,'ttttttttttt','admin','2014-05-06 13:51:06',0),
(6,'ttttttttttt +1','admin','2014-05-06 13:51:42',0),
(7,'Segunda lista de envío','admin','2014-05-06 15:10:29',0),
(8,'Segunda lista de envío','admin','2014-05-06 15:11:53',0),
(9,'Todos los clientes','admin','2014-05-06 15:14:06',1),
(10,'Clientes potenciales','admin','2014-05-06 15:28:44',1),
(11,'Massss','admin','2014-05-06 15:29:48',0),
(12,'ssssssssss','admin','2014-05-06 15:30:52',0),
(13,'KAKAKAKA','admin','2014-05-06 15:31:30',0),
(14,'lalala','admin','2014-05-06 15:33:59',0),
(15,'Lista de prueba','admin','2014-05-07 09:32:43',1),
(16,'yo solo','admin','2014-09-11 15:47:07',1);

/*Table structure for table `mailing_lists_users` */

DROP TABLE IF EXISTS `mailing_lists_users`;

CREATE TABLE `mailing_lists_users` (
  `id_list` int(11) NOT NULL DEFAULT '0',
  `email` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT '',
  PRIMARY KEY (`id_list`,`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `mailing_lists_users` */

insert  into `mailing_lists_users`(`id_list`,`email`) values 
(1,'cgonzalez@imagar.com'),
(1,'dmarchante@imagar.com'),
(1,'dnoguera@imagar.com'),
(1,'odelgado@imagar.com'),
(1,'pramos@imagar.com'),
(1,'shermida@imagar.com'),
(3,'dmarchante@imagar.com'),
(3,'dnoguera@imagar.com'),
(3,'odelgado@imagar.com'),
(3,'pramos@imagar.com'),
(3,'shermida@imagar.com'),
(8,'DMARCHANTE@IMAGAR.COM'),
(8,'DNOGUERA@IMAGAR.COM'),
(8,'ODELGADO@IMAGAR.COM'),
(8,'PRAMOS@IMAGAR.COM'),
(8,'SHERMIDA@IMAGAR.COM'),
(9,'dmarchante@imagar.com'),
(9,'dnoguera@imagar.com'),
(9,'odelgado@imagar.com'),
(9,'pramos@imagar.com'),
(9,'shermida@imagar.com'),
(10,'cgonzalez@imagar.com'),
(10,'dmarchante@imagar.com'),
(10,'dnoguera@imagar.com'),
(10,'odelgado@imagar.com'),
(10,'pramos@imagar.com'),
(10,'shermida@imagar.com'),
(12,'dmarchante@imagar.com'),
(12,'dnoguera@imagar.com'),
(12,'odelgado@imagar.com'),
(12,'pramos@imagar.com'),
(12,'shermida@imagar.com'),
(13,'dmarchante@imagar.com'),
(13,'dnoguera@imagar.com'),
(13,'odelgado@imagar.com'),
(13,'pramos@imagar.com'),
(13,'shermida@imagar.com'),
(15,'cgonzalez@imagar.com'),
(15,'dmarchante@imagar.com'),
(15,'dnoguera@imagar.com'),
(15,'odelgado@imagar.com'),
(15,'pramos@imagar.com'),
(15,'shermida@imagar.com'),
(16,'dnoguera@imagar.com'),
(16,'nogueradavid@hotmail.com');

/*Table structure for table `mailing_lists_users_data` */

DROP TABLE IF EXISTS `mailing_lists_users_data`;

CREATE TABLE `mailing_lists_users_data` (
  `email` varchar(250) CHARACTER SET latin1 NOT NULL,
  `birthday` date NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `mailing_lists_users_data` */

insert  into `mailing_lists_users_data`(`email`,`birthday`) values 
('dnoguera@imagar.com','1975-05-09'),
('shermida@imagar.com','1985-05-09');

/*Table structure for table `mailing_messages` */

DROP TABLE IF EXISTS `mailing_messages`;

CREATE TABLE `mailing_messages` (
  `id_message` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_template` int(11) DEFAULT '0',
  `message_from_email` text CHARACTER SET latin1,
  `message_from_name` text CHARACTER SET latin1,
  `message_subject` text CHARACTER SET latin1,
  `message_body` text CHARACTER SET latin1,
  `message_body2` text CHARACTER SET latin1,
  `message_status` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT 'pending',
  `message_lista` text CHARACTER SET latin1,
  `message_attachment` text CHARACTER SET latin1 NOT NULL,
  `date_scheduled` date DEFAULT NULL,
  `date_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username_add` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `total_messages` int(11) NOT NULL DEFAULT '0',
  `total_send` int(11) NOT NULL DEFAULT '0',
  `total_pending` int(11) NOT NULL DEFAULT '0',
  `total_failed` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_message`)
) ENGINE=MyISAM AUTO_INCREMENT=164 DEFAULT CHARSET=utf8;

/*Data for the table `mailing_messages` */

insert  into `mailing_messages`(`id_message`,`id_template`,`message_from_email`,`message_from_name`,`message_subject`,`message_body`,`message_body2`,`message_status`,`message_lista`,`message_attachment`,`date_scheduled`,`date_add`,`username_add`,`total_messages`,`total_send`,`total_pending`,`total_failed`) values 
(1,1,'dnoguera@imagar.com',NULL,'Mensaje de prueba',NULL,'','completed',NULL,'',NULL,'2014-03-18 17:20:47','admin',0,0,0,0),
(2,2,'dnoguera@imagar.com',NULL,'Mensaje 2 de prueba',NULL,'','pending',NULL,'',NULL,'2014-03-18 17:22:19','admin',0,0,0,0),
(3,1,'dnoguera@imagar.com','Alain Affelou','El asunto del mensaje','cuerpo del mensaje','','pending','lista todos','',NULL,'2014-03-20 16:03:11','admin',0,0,0,0),
(4,2,'dnoguera@imagar.com','Alain Affelou','Mensaje a todos los usuarios','el cupero del mensaje','','pending','lista todos','',NULL,'2014-03-20 16:24:05','admin',0,0,0,0),
(5,2,'dnoguera@imagar.com','Alain Affelou','Mensaje a todos los usuarios2','sdfsdfsd','','pending','lista todos','',NULL,'2014-03-20 16:24:38','admin',0,0,0,0),
(6,2,'dnoguera@imagar.com','Alain Affelou','Mensaje a todos los usuarios3','asdasdasd','','pending','lista todos','',NULL,'2014-03-20 16:25:37','admin',0,0,0,0),
(7,2,'dnoguera@imagar.com','Alain Affelou','Mensaje a todos los usuarios4','el cuerpo del mensaje','','pending','lista todos','',NULL,'2014-03-20 16:27:20','admin',0,0,0,0),
(8,2,'dnoguera@imagar.com','Alain Affelou','Prueba efinitiva','Aquí va el cuerpo del mensaje','','completed','lista todos','',NULL,'2014-03-21 10:48:41','admin',12,0,0,12),
(9,2,'dnoguera@imagar.com','Alain Affelou','El asunto de la prueba','el mensaje','','pending','lista todos','',NULL,'2014-03-21 12:02:27','admin',12,0,12,0),
(10,2,'dnoguera@imagar.com','Alain Affelou','dfsf','sdfdfsd','','completed','lista todos','',NULL,'2014-03-23 16:01:15','admin',12,0,0,12),
(11,1,'dnoguera@imagar.com','Alain Affelou','llllllll','ññ','','completed','lista todos','',NULL,'2014-03-23 16:05:20','admin',12,0,0,12),
(12,2,'dnoguera@imagar.com','Alain Affelou','asds','asda','','completed','lista todos','',NULL,'2014-03-23 16:13:41','admin',12,0,0,12),
(13,2,'dnoguera@imagar.com','Alain Affelou','pk','ikoijoi','','completed','lista todos','',NULL,'2014-03-23 16:25:49','admin',12,0,0,12),
(14,2,'dnoguera@imagar.com','Alain Affelou','lñññññññññññññ','ñññ','','completed','lista todos','',NULL,'2014-03-23 16:27:04','admin',12,0,0,12),
(15,2,'dnoguera@imagar.com','Alain Affelou',',','k','','completed','lista todos','',NULL,'2014-03-23 16:28:18','admin',12,0,0,12),
(16,2,'dnoguera@imagar.com','Alain Affelou','llñ','lll','','completed','lista todos','',NULL,'2014-03-23 16:29:43','admin',12,0,0,12),
(17,2,'dnoguera@imagar.com','Alain Affelou','ñl','l','','completed','lista todos','',NULL,'2014-03-23 16:30:47','admin',12,0,0,12),
(18,1,'dnoguera@imagar.com','Alain Affelou','ll','ññ','','completed','lista todos','',NULL,'2014-03-23 16:32:50','admin',12,0,0,12),
(19,1,'dnoguera@imagar.com','Alain Affelou','ññ','ñl,','','completed','lista todos','',NULL,'2014-03-23 16:41:33','admin',12,0,0,12),
(20,2,'dnoguera@imagar.com','Alain Affelou','jkk','jjj','','completed','lista todos','',NULL,'2014-03-23 16:45:55','admin',12,0,0,12),
(21,2,'dnoguera@imagar.com','Alain Affelou',',,','lm-,mn','','completed','lista todos','',NULL,'2014-03-23 16:53:32','admin',12,0,0,12),
(22,1,'dnoguera@imagar.com','Alain Affelou','jnkjk','kkkk','','pending','lista todos','',NULL,'2014-03-23 17:11:07','admin',12,0,0,12),
(23,2,'dnoguera@imagar.com','Alain Affelou','klnln','ñ?nlkn','','pending','lista todos','',NULL,'2014-03-23 17:18:44','admin',12,0,4,8),
(24,2,'dnoguera@imagar.com','Alain Affelou','knl',' .nl','','pending','lista todos','',NULL,'2014-03-23 17:20:14','admin',12,0,4,8),
(25,1,'dnoguera@imagar.com','Alain Affelou','aaaaaaaaaaaa','eeeeeeeeee','','pending','lista todos','',NULL,'2014-03-23 23:08:17','admin',0,0,0,0),
(26,1,'dnoguera@imagar.com','Alain Affelou','aaaaaaaaaaaa','eeeeeeeeee','','completed','lista todos','',NULL,'2014-03-23 23:09:56','admin',12,0,0,12),
(27,1,'dnoguera@imagar.com','Alain Affelou','kkkkkkkkk','ooooooooooo','','completed','lista todos','',NULL,'2014-03-23 23:19:04','admin',12,0,0,12),
(40,1,'dnoguera@imagar.com','Alain Affelou','asdasd','asdasdasd','','pending','lista responsables','',NULL,'2014-03-24 16:28:50','admin',2,0,2,0),
(41,1,'dnoguera@imagar.com','Alain Affelou','ssssssss','ssssssssssssss','','completed','lista regionales','',NULL,'2014-03-24 16:29:40','admin',1,0,0,1),
(42,1,'dnoguera@imagar.com','Alain Affelou','asdassd','asdasd','','completed','lista comerciales','',NULL,'2014-03-24 16:31:51','admin',8,0,0,8),
(43,1,'dnoguera@imagar.com','Alain Affelou','otro mensaje','el cuerpo del mensaje','','completed','lista curso : 1','',NULL,'2014-03-24 16:39:43','admin',2,0,0,2),
(44,1,'dnoguera@imagar.com','Alain Affelou','Prueba','Prubsssss','','completed','lista todos','',NULL,'2014-03-25 09:23:02','admin',12,0,0,12),
(45,1,'dnoguera@imagar.com','Alain Affelou','33333333333','234234234234\r\n234444444444444444444444444','','pending','lista todos','',NULL,'2014-03-25 10:34:50','admin',12,0,12,0),
(46,1,'dnoguera@imagar.com','Alain Affelou','El asunto del mensaje','el cuerpo del mensaje','','completed','lista todos','',NULL,'2014-03-26 11:54:24','admin',15,0,0,15),
(47,1,'dnoguera@imagar.com','Alain Affelou','asdasd','sadasd','','pending','lista comerciales','',NULL,'2014-03-27 08:54:52','admin',9,0,9,0),
(48,1,'dnoguera@imagar.com','Alain Affelou','tatatatatatat','tetetetetetetet','','pending','lista curso','',NULL,'2014-03-27 09:04:04','admin',2,0,2,0),
(49,2,'dnoguera@imagar.com','Alain Affelou','888888888888','000000000','','pending','lista curso','',NULL,'2014-03-27 09:07:50','admin',2,0,2,0),
(50,2,'dnoguera@imagar.com','Alain Affelou','dfdfdfd','fdfdfdf','','pending','lista curso','',NULL,'2014-03-27 09:08:44','admin',2,0,2,0),
(51,1,'dnoguera@imagar.com','Alain Affelou','ddddddddddddd','fffffffffffffffff','','pending','lista curso : 1','',NULL,'2014-03-27 09:09:29','admin',2,0,2,0),
(52,1,'dnoguera@imagar.com','Alain Affelou','test tienda 1','sdasda','','pending','lista tienda : 1111','',NULL,'2014-03-27 09:56:34','admin',0,0,0,0),
(53,1,'dnoguera@imagar.com','Alain Affelou','test tienda 1','sdasda','','pending','lista tienda : 1111','',NULL,'2014-03-27 09:57:04','admin',0,0,0,0),
(54,1,'dnoguera@imagar.com','Alain Affelou','s','s','','pending','lista tienda : 1111','',NULL,'2014-03-27 09:58:10','admin',0,0,0,0),
(55,1,'dnoguera@imagar.com','Alain Affelou','s','s','','pending','lista tienda : 1111','',NULL,'2014-03-27 09:58:42','admin',0,0,0,0),
(56,2,'dnoguera@imagar.com','Alain Affelou','asasas','asasas','','pending','lista tienda : 1111','',NULL,'2014-03-27 10:00:00','admin',0,0,0,0),
(57,1,'dnoguera@imagar.com','Alain Affelou','fgh','zx','','pending','lista todos','',NULL,'2014-03-27 10:06:17','admin',15,0,15,0),
(58,1,'dnoguera@imagar.com','Alain Affelou','rgdfs','dfgdf','','pending','lista tienda : 1111','',NULL,'2014-03-27 10:08:41','admin',0,0,0,0),
(59,1,'dnoguera@imagar.com','Alain Affelou','rgdfs','dfgdf','','pending','lista tienda : 1111','',NULL,'2014-03-27 10:13:02','admin',0,0,0,0),
(60,2,'dnoguera@imagar.com','Alain Affelou','gdfgdfg','dfgdfg','','pending','lista tienda : 1111','',NULL,'2014-03-27 10:13:26','admin',0,0,0,0),
(61,1,'dnoguera@imagar.com','Alain Affelou','el asunto','asdasd','','pending','lista todos','',NULL,'2014-03-27 10:19:21','admin',15,0,15,0),
(62,1,'dnoguera@imagar.com','Alain Affelou','asdas','asdasd','','pending','lista curso : 1','',NULL,'2014-03-27 10:19:46','admin',0,0,0,0),
(63,1,'dnoguera@imagar.com','Alain Affelou','sadasd','asdasd','','pending','lista curso : 1','',NULL,'2014-03-27 10:20:56','admin',0,0,0,0),
(64,2,'dnoguera@imagar.com','Alain Affelou','xcvx','xcv','','pending','lista tienda : 2222','',NULL,'2014-03-27 10:22:43','admin',0,0,0,0),
(65,2,'dnoguera@imagar.com','Alain Affelou','xcvx','xcv','','pending','lista tienda : 2222','',NULL,'2014-03-27 10:25:29','admin',0,0,0,0),
(66,1,'dnoguera@imagar.com','Alain Affelou','zxc','zxc','','pending','lista tienda : 1111','',NULL,'2014-03-27 10:26:01','admin',0,0,0,0),
(67,1,'dnoguera@imagar.com','Alain Affelou','aaaaa','aaaaaaaa','','pending','','',NULL,'2014-03-27 10:31:20','admin',0,0,0,0),
(68,1,'dnoguera@imagar.com','Alain Affelou','dfgdfgdf','dfgdfg','','pending','lista todos','',NULL,'2014-03-27 10:35:38','admin',15,0,15,0),
(69,1,'dnoguera@imagar.com','Alain Affelou','aaaaaaaaaaaaaaaaa','dddddddddddddddddd','','pending','lista tienda : 1111','',NULL,'2014-03-27 10:35:55','admin',4,0,4,0),
(70,1,'dnoguera@imagar.com','Alain Affelou','ttttttttt','yyyyyyyyyyyyyy','','pending','lista curso : 1','1395913210_1307480807_maf.jpg',NULL,'2014-03-27 10:40:10','admin',2,0,2,0),
(71,1,'dnoguera@imagar.com','Alain Affelou','asdasd','asdasd','','pending','lista curso : 1','',NULL,'2014-03-27 10:45:16','admin',2,0,2,0),
(72,1,'dnoguera@imagar.com','Alain Affelou','xxxxxxx','xxxxxxx','','pending','lista todos','',NULL,'2014-03-27 10:46:36','admin',15,0,15,0),
(73,1,'dnoguera@imagar.com','Alain Affelou','xasadd','asdasd','','pending','lista todos','',NULL,'2014-03-27 10:49:56','admin',15,0,15,0),
(74,1,'dnoguera@imagar.com','Alain Affelou','sdfsdf','sdfsdf','','pending','lista todos','',NULL,'2014-03-27 10:51:56','admin',15,0,15,0),
(75,1,'dnoguera@imagar.com','Alain Affelou','aaaaaaaaaaa','ssssssssssss','','pending','lista tienda : 1111','',NULL,'2014-03-27 10:52:31','admin',4,0,4,0),
(76,1,'dnoguera@imagar.com','Alain Affelou','retert','ertert','','pending','lista todos','',NULL,'2014-03-27 13:01:14','admin',15,0,15,0),
(77,1,'dnoguera@imagar.com','Alain Affelou','tttttttttt','tyyyyyyyyyyyyyyyyyyy','','pending','admin, creativo','',NULL,'2014-03-27 13:03:57','admin',0,0,0,0),
(78,1,'dnoguera@imagar.com','Alain Affelou','rrrrrrrrrr','tttttttttttt','','pending','admin, creativo','',NULL,'2014-03-27 13:05:29','admin',1,0,1,0),
(79,1,'dnoguera@imagar.com','Alain Affelou','ddddddd','ddddddddd','','pending','admin, creativo','',NULL,'2014-03-27 13:06:55','admin',1,0,1,0),
(80,1,'dnoguera@imagar.com','Alain Affelou','asasasas','asasasas as as<br />\r\nas asdasasd','','pending','admin, creativo','',NULL,'2014-03-27 13:09:36','admin',2,0,2,0),
(81,2,'dnoguera@imagar.com','Alain Affelou','dd','sddsd','','pending','admin, ','',NULL,'2014-03-27 16:08:52','admin',1,0,1,0),
(82,2,'dnoguera@imagar.com','Alain Affelou','sede','sede','','pending','lista sede','',NULL,'2014-03-27 17:45:19','admin',1,0,1,0),
(83,1,'dnoguera@imagar.com','Alain Affelou','mensaje a tiendas propias','Hola [USER_NAME],<br />\r\nPrueba a tiendas propias','','completed','lista tienda tipo : tiendas propias','',NULL,'2014-03-28 09:30:07','admin',0,0,0,0),
(84,2,'dnoguera@imagar.com','Alain Affelou','mensaje a tiendas propias 2','Hola [USER_NAME],<br />\r\nBienvenido!!','','pending','lista tienda tipo : tiendas propias','',NULL,'2014-03-28 09:33:58','admin',5,0,5,0),
(85,1,'dnoguera@imagar.com','Alain Affelou','prueba tiendas','Holaaaa','','pending','lista tienda : 2ACB','',NULL,'2014-04-03 15:29:56','admin',0,0,0,0),
(86,1,'dnoguera@imagar.com','Alain Affelou','test tiendas','sssssssssssssss','','pending','lista tienda : 2ACB','',NULL,'2014-04-03 15:33:34','admin',0,0,0,0),
(87,1,'dnoguera@imagar.com','Alain Affelou','dddddddd','d','','pending','lista tienda : 2ACB','',NULL,'2014-04-03 15:34:13','admin',0,0,0,0),
(88,1,'dnoguera@imagar.com','Alain Affelou','test tiendas2','zxcz','','pending','lista tienda : 2ACB','',NULL,'2014-04-03 15:35:18','admin',0,0,0,0),
(89,1,'dnoguera@imagar.com','Alain Affelou','ddddddd','d','','pending','lista tienda : 2ACB','',NULL,'2014-04-03 15:41:04','admin',1,0,1,0),
(90,2,'dnoguera@imagar.com','Alain Affelou','77777777777777','777777777','','pending','lista tienda : 2ACB','',NULL,'2014-04-03 15:42:50','admin',1,0,1,0),
(91,2,'dnoguera@imagar.com','Alain Affelou','77777777777777','777777777','','pending','lista tienda : 2ACB','',NULL,'2014-04-03 15:43:06','admin',1,0,1,0),
(92,2,'dnoguera@imagar.com','Alain Affelou','77777777777777','777777777','','pending','lista tienda : 2ACB','',NULL,'2014-04-03 15:43:53','admin',1,0,1,0),
(93,2,'dnoguera@imagar.com','Alain Affelou','77777777777777','777777777','','pending','lista tienda : 2ACB','',NULL,'2014-04-03 15:44:28','admin',2,0,2,0),
(94,1,'dnoguera@imagar.com','Alain Affelou','test tiendas def','Definitivo','','pending','lista tienda : 2ACB','',NULL,'2014-04-03 15:45:44','admin',2,0,2,0),
(95,1,'dnoguera@imagar.com','Alain Affelou','hhhhhh','ggg','','completed','lista todos','',NULL,'2014-04-04 22:42:45','admin',4,4,0,0),
(96,2,'dnoguera@imagar.com','Alain Affelou','uuuuuuuuuuuuu','bbb','','pending','lista todos','',NULL,'2014-04-04 22:43:28','admin',4,0,4,0),
(97,1,'dnoguera@imagar.com','Alain Affelou','iiiiiiiiiiiiiiiiiiiiiiii','kkkkkkkkkkkkk','','pending','lista todos','',NULL,'2014-04-04 23:00:18','admin',4,0,4,0),
(98,1,'dnoguera@imagar.com','Alain Affelou','0000000000','mmm<br />\r\n','','completed','lista todos','',NULL,'2014-04-04 23:58:57','admin',0,0,0,0),
(99,1,'dnoguera@imagar.com','Alain Affelou','0000000000','mmm<br />\r\n','','completed','lista todos','',NULL,'2014-04-04 23:59:37','admin',4,0,0,4),
(100,1,'dnoguera2@imagar.com','Alain Affelou','prueba con saltos de linea','Una linea.<br />\r\nOtra<br />\r\nadsasdasda<br />\r\nasdasdasd<br />\r\nasdasdasd','','completed','lista todos','',NULL,'2014-04-15 14:09:24','admin',4,4,0,0),
(101,1,'dnoguera2@imagar.com','Comunidad Essilor','prueba','Hola [USER_NAME],<br />\r\nsdfsdfsdf','','completed','admin','',NULL,'2014-04-23 09:10:15','admin',1,1,0,0),
(102,1,'dnoguera2@imagar.com','Comunidad Essilor','test black','sdfsd','','completed','admin','',NULL,'2014-04-23 13:19:52','admin',0,0,0,0),
(103,1,'dnoguera2@imagar.com','Comunidad Essilor','Black list 2','asdasd','','completed','admin','',NULL,'2014-04-23 13:21:25','admin',1,1,0,0),
(104,1,'dnoguera2@imagar.com','Comunidad Essilor','rrr','erterter','','completed','admin','',NULL,'2014-04-23 16:04:02','admin',1,1,0,0),
(105,11,'dnoguera2@imagar.com','Tu ayudaadmin','Un mensaje','asdasdasd','','pending','model_mailing.xls','1398332862_model_mailing.xls',NULL,'2014-04-24 11:47:42','admin',4,0,4,0),
(106,11,'dnoguera2@imagar.com','Tu ayudaadmin','Plantilla cuarta','sdfsdfsd','','pending','model_mailing.xls','',NULL,'2014-04-24 11:51:31','admin',0,0,0,0),
(107,11,'dnoguera2@imagar.com','Tu ayudaadmin','Plantilla cuarta','sdfsdfsd','','pending','model_mailing.xls','',NULL,'2014-04-24 11:52:13','admin',0,0,0,0),
(108,11,'dnoguera2@imagar.com','Tu ayudaadmin','Plantilla cuarta','sdfsdfsd','','pending','model_mailing.xls','',NULL,'2014-04-24 11:52:38','admin',3,0,3,0),
(109,3,'dnoguera2@imagar.com','Tu ayudaadmin','sdfs','sdfsdf','','pending','model_mailing.xls','',NULL,'2014-04-24 12:00:51','admin',4,0,4,0),
(110,1,'dnoguera2@imagar.com','Tu ayudaadmin','','','','pending','','',NULL,'2014-04-29 17:20:44','admin',0,0,0,0),
(111,1,'dnoguera2@imagar.com','Tu ayudaadmin','','','','pending','','',NULL,'2014-04-29 17:22:20','admin',0,0,0,0),
(112,1,'dnoguera2@imagar.com','Tu ayudaadmin','eeeeeeeeeeeee','rrrrrrrrrrrrrrrrr','','pending','model_mailing.xls','',NULL,'2014-04-29 17:38:47','admin',4,0,4,0),
(113,1,'dnoguera2@imagar.com','Tu ayudaadmin','ggggggggggggg','ghghfghfghf','','pending','model_mailing.xls','',NULL,'2014-04-29 17:40:10','admin',4,0,4,0),
(114,2,'dnoguera2@imagar.com','Tu ayudaadmin','45645645','6456456456','','pending','model_mailing.xls','',NULL,'2014-04-29 17:44:13','admin',4,0,4,0),
(115,1,'dnoguera2@imagar.com','Tu ayudaadmin','7777777777','777777777777','','pending','model_mailing.xls','',NULL,'2014-04-29 17:45:15','admin',4,0,4,0),
(116,1,'dnoguera2@imagar.com','Tu ayudaadmin','rrrrrr','rrrrrrrrrrrrrrrrrr','','pending','model_mailing.xls','',NULL,'2014-04-29 17:47:35','admin',4,0,4,0),
(117,1,'dnoguera2@imagar.com','Tu ayudaadmin','uu','uuuuuuuuuuuuu','','pending','model_mailing.xls','',NULL,'2014-04-29 17:48:12','admin',4,0,4,0),
(118,1,'dnoguera2@imagar.com','Tu ayudaadmin','ggggg','ggggdfgdfg','','completed','model_mailing.xls','','2014-04-24','2014-04-29 18:04:51','admin',4,4,0,0),
(119,1,'dnoguera2@imagar.com','Tu ayudaadmin','dddddddddddd','dfdsfsdf','','completed','model_mailing.xls','','2014-05-09','2014-04-29 18:07:00','admin',4,4,0,0),
(120,1,'dnoguera2@imagar.com','Tu ayudaadmin','eeeeeeeeee','ererer','','pending','model_mailing.xls','',NULL,'2014-04-29 18:07:44','admin',4,0,4,0),
(121,1,'dnoguera2@imagar.com','DavidNoguera Gutierrez','Mensaje 1','Mensaje de prueba','','completed','model_mailing.xls','',NULL,'2014-05-05 17:05:39','20266370N',4,4,0,0),
(122,1,'dnoguera2@imagar.com','Tu ayudaadmin','','','','pending','','',NULL,'2014-05-06 16:48:53','admin',0,0,0,0),
(123,1,'dnoguera2@imagar.com','Tu ayudaadmin','asdasd final','asdasd','','pending','','',NULL,'2014-05-06 17:52:19','admin',2,0,2,0),
(124,1,'dnoguera2@imagar.com','Tu ayudaadmin','222222222222','3333333333333333333333333','','pending','model_mailing.xls','',NULL,'2014-05-06 17:53:07','admin',5,0,5,0),
(125,1,'dnoguera2@imagar.com','Tu ayudaadmin','test11','jajajajajaj','','pending','','',NULL,'2014-05-07 09:40:33','admin',5,0,5,0),
(126,2,'dnoguera2@imagar.com','Tu ayudaadmin','Prueba de certificación','desc del mensaje','','pending','1','','2014-05-23','2014-05-07 09:44:26','admin',2,0,2,0),
(127,12,'dnoguera@imagar.com','Tu ayudaadmin','prueba dos textos','texto1','texto2','pending','1','',NULL,'2014-05-14 12:48:06','admin',6,0,6,0),
(128,12,'dnoguera@imagar.com','Tu ayudaadmin','el asunto del mensaje','<meta content=\"texthtml; charset=UTF-8\" http-equiv=\"Content-Type\" >\r\n<title><title>\r\n<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http:localhostalainimagesmailingimageslogo.png\" style=\"width: 100px; height: 75px;\" ><br >\r\n					<br >\r\n					<img src=\"images/usuarios/1400146900_1396955321_1392898485_1391208999_imag0493.jpeg\" /><td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						Reclamo<h2>\r\n					2ACC te felicita!!<br >\r\n					mi personalizacion<br >\r\n					<br >\r\n					<br >\r\n					Consigue un descuento de 4 %<br >\r\n					<br >\r\n					fecha l&iacute;mite de la promoci&oacute;n 18/06/2014<br >\r\n					<br >\r\n					C/Álamo 9 - 28921 - Alcorcón - Madrid<br />Tlf.:  91 666 66 66<br />www.imagar.com<br />dnoguera@imagar.com<td>\r\n			<tr>\r\n		<tbody>\r\n	<table>\r\n<div>\r\n','','pending','9','',NULL,'2014-06-10 15:35:40','admin',5,0,5,0),
(129,2,'dnoguera@imagar.com','Administrador Community','Mi mensaje de prueba','','','pending','15','',NULL,'2014-07-28 11:29:25','admin',6,0,6,0),
(130,2,'dnoguera@imagar.com','Administrador Community','Mi mensaje de prueba','','','pending','15','',NULL,'2014-07-28 11:31:04','admin',6,0,6,0),
(131,2,'dnoguera@imagar.com','Administrador Community','Mi mensaje de prueba','<meta content=\"text/html; charset=UTF-8\" http-equiv=\"Content-Type\" />\r\n<title></title>\r\n<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					<br />\r\n					<img src=\"/images/usuarios/\" /></td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						Convocatoria</h2>\r\n					<br />\r\n					<br />\r\n					01/07/2014<br />\r\n					<br />\r\n					Consigue un descuento de <strong>12</strong><br />\r\n					<br />\r\n					[CLAIM PROMOCION]</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					C/Alamo 9 1º derecha - 28921 - Alcorcón - Madrid<br />Tlf.:  666666666<br />dnoguera@imagar.com<br />www.imagar.com</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','','pending','15','',NULL,'2014-07-28 11:33:07','admin',6,0,6,0),
(132,2,'dnoguera@imagar.com','Administrador Community','Mi mensaje de prueba','<meta content=\"text/html; charset=UTF-8\" http-equiv=\"Content-Type\" />\r\n<title></title>\r\n<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					<br />\r\n					<img src=\"http://192.168.0.8/community/images/usuarios/\" /></td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						Convocatoria</h2>\r\n					<br />\r\n					<br />\r\n					01/07/2014<br />\r\n					<br />\r\n					Consigue un descuento de <strong>12</strong><br />\r\n					<br />\r\n					[CLAIM PROMOCION]</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					C/Alamo 9 1º derecha - 28921 - Alcorcón - Madrid<br />Tlf.:  666666666<br />dnoguera@imagar.com<br />www.imagar.com</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','','pending','15','',NULL,'2014-07-28 11:33:42','admin',6,0,6,0),
(133,2,'dnoguera@imagar.com','Administrador Community','Mi mensaje de prueba','<meta content=\"text/html; charset=UTF-8\" http-equiv=\"Content-Type\" />\r\n<title></title>\r\n<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					<br />\r\n					<img src=\"http://192.168.0.8/community/images/usuarios/\" /></td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						Convocatoria</h2>\r\n					<br />\r\n					<br />\r\n					01/07/2014<br />\r\n					<br />\r\n					Consigue un descuento de <strong>12</strong><br />\r\n					<br />\r\n					[CLAIM PROMOCION]</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					C/Alamo 9 1º derecha - 28921 - Alcorcón - Madrid<br />Tlf.:  666666666<br />dnoguera@imagar.com<br />www.imagar.com</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','','pending','15','',NULL,'2014-07-28 11:34:18','admin',6,0,6,0),
(134,2,'dnoguera@imagar.com','Administrador Community','Mi mensaje de prueba','<meta content=\"text/html; charset=UTF-8\" http-equiv=\"Content-Type\" />\r\n<title></title>\r\n<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					<br />\r\n					<img src=\"http://192.168.0.8/community/images/usuarios/\" /></td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						Convocatoria</h2>\r\n					<br />\r\n					<br />\r\n					01/07/2014<br />\r\n					<br />\r\n					Consigue un descuento de <strong>12</strong><br />\r\n					<br />\r\n					mi mensaje de claimmmmmm</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					C/Alamo 9 1º derecha - 28921 - Alcorcón - Madrid<br />Tlf.:  666666666<br />dnoguera@imagar.com<br />www.imagar.com</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','','pending','15','',NULL,'2014-07-28 11:35:49','admin',6,0,6,0),
(135,2,'dnoguera@imagar.com','Administrador Community','Mi mensaje de prueba2','<meta content=\"text/html; charset=UTF-8\" http-equiv=\"Content-Type\" />\r\n<title></title>\r\n<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					<br />\r\n					<img src=\"http://192.168.0.8/community/images/usuarios/\" /></td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						Convocatoria</h2>\r\n					<br />\r\n					<br />\r\n					01/07/2014<br />\r\n					<br />\r\n					Consigue un descuento de <strong>11</strong><br />\r\n					<br />\r\n					Mi CLAIMMMMMMM</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					C/Alamo 9 1º derecha - 28921 - Alcorcón - Madrid<br />Tlf.:  666666666<br />dnoguera@imagar.com<br />www.imagar.com</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','','pending','15','',NULL,'2014-07-28 11:36:52','admin',6,0,6,0),
(136,3,'dnoguera@imagar.com','Administrador Community','prueba1','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://www.css-tricks.com\">http://www.css-tricks.com</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:01:34','admin',0,0,0,0),
(137,3,'dnoguera@imagar.com','Administrador Community','prueba1','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://www.css-tricks.com\">http://www.css-tricks.com</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:02:58','admin',6,0,6,0),
(138,3,'dnoguera@imagar.com','Administrador Community','asdasd final','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://www.css-tricks.com\">http://www.css-tricks.com</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:07:32','admin',6,0,6,0),
(139,3,'dnoguera@imagar.com','Administrador Community','dddddddddddddd','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://www.css-tricks.com\">http://www.css-tricks.com</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:07:59','admin',6,0,6,0),
(140,3,'dnoguera@imagar.com','Administrador Community','zxczxczxc','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://www.css-tricks.com\">http://www.css-tricks.com</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:08:25','admin',6,0,6,0),
(141,3,'dnoguera@imagar.com','Administrador Community','ffffffffff','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://www.css-tricks.com\">http://www.css-tricks.com</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:09:46','admin',6,0,6,0),
(142,3,'dnoguera@imagar.com','Administrador Community','ffffffffff','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://www.css-tricks.com\">http://www.css-tricks.com</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:10:56','admin',6,0,6,0),
(143,3,'dnoguera@imagar.com','Administrador Community','ffffffffff','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://www.css-tricks.com\">http://www.css-tricks.com</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:11:12','admin',6,0,6,0),
(144,3,'dnoguera@imagar.com','Administrador Community','oooooo','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://www.css-tricks.com\">http://www.css-tricks.com</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:12:30','admin',6,0,6,0),
(145,3,'dnoguera@imagar.com','Administrador Community','oooooo','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\":///lt.php?id=EDNjXFAPWQ%3D%3D\" >http://www.css-tricks.com</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:13:29','admin',6,0,6,0),
(146,3,'dnoguera@imagar.com','Administrador Community','oooooo','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://http://192.168.0.8/community-php/includes/modules/mailing/pages/lt.php?id=EDNjXFAPWQ%3D%3D\" >http://www.css-tricks.com</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:18:35','admin',6,0,6,0),
(147,3,'dnoguera@imagar.com','Administrador Community','oooooo','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://192.168.0.8/community-php/includes/modules/mailing/pages/lt.php?id=EDNjXFAPWQ%3D%3D\" >http://www.css-tricks.com</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:19:39','admin',6,0,6,0),
(148,3,'dnoguera@imagar.com','Administrador Community','oooooo','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://www.css-tricks.com\">http://www.css-tricks.com</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:22:52','admin',0,0,0,0),
(149,3,'dnoguera@imagar.com','Administrador Community','oooooo','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://192.168.0.8/community-php/includes/modules/mailing/pages/lt.php?id=EDNjXFAPWQ%3D%3D\" >http://www.css-tricks.com</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:23:40','admin',6,0,6,0),
(150,3,'dnoguera@imagar.com','Administrador Community','oooooo','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://192.168.0.8/community-php/includes/modules/mailing/pages/lt.php?id=EDNjXFAPWQ%3D%3D\" >http://www.css-tricks.com</a><br />\r\n				<br />\r\n				<a href=\"http://192.168.0.8/community-php/includes/modules/mailing/pages/lt.php?id=EDNjXFAPWQ%3D%3D\" >Ir a la comunidad</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','cancelled','15','',NULL,'2014-09-11 13:26:06','admin',6,0,6,0),
(151,3,'dnoguera@imagar.com','Administrador Community','oooooo','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://192.168.0.8/community-php/includes/modules/mailing/pages/lt.php?id=EDNjXFAPWQ%3D%3D\" >http://www.css-tricks.com</a><br />\r\n				<br />\r\n				<a href=\"http://192.168.0.8/community-php/includes/modules/mailing/pages/lt.php?id=EDNjXFAPWQ%3D%3D\" >Ir a la comunidad</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','pending','15','',NULL,'2014-09-11 13:28:05','admin',6,0,6,0),
(152,3,'dnoguera@imagar.com','Administrador Community','oooooo','','','completed','15','',NULL,'2014-09-11 13:47:12','admin',6,6,0,0),
(153,3,'dnoguera@imagar.com','Administrador Community','prueba','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://www.css-tricks.com\">http://www.css-tricks.com</a><br />\r\n				<br />\r\n				<a href=\"http://localhost/community-php/?page=admin-template&amp;id=3\">Ir a la comunidad</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','completed','15','',NULL,'2014-09-11 15:34:18','admin',6,6,0,0),
(154,3,'dnoguera@imagar.com','Administrador Community','prueba2','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del nuevo mensaje principal.</h2>\r\n				<br />\r\n				<a href=\"http://www.css-tricks.com\">http://www.css-tricks.com</a><br />\r\n				<br />\r\n				<a href=\"http://localhost/community-php/?page=admin-template&amp;id=3\">Ir a la comunidad</a><br />\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','','cancelled','16','',NULL,'2014-09-11 15:48:47','admin',2,0,2,0),
(155,3,'dnoguera@imagar.com','Administrador Community','mensaje de prueba','<h2>\r\n	El cuerpo del nuevo mensaje principal.</h2>\r\n<br />\r\n<a href=\"http://www.css-tricks.com\">http://www.css-tricks.com</a><br />\r\n<br />\r\n<a href=\"http://localhost/community-php/?page=admin-template&amp;id=3\">Ir a la comunidad</a><br />\r\n<br />\r\nel mensaje de claim','','completed','16','',NULL,'2014-09-11 15:59:31','admin',2,2,0,0),
(156,3,'dnoguera@imagar.com','Administrador Community','Nuevo asunto del mensaje','<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://192.168.0.8/community-php/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					&nbsp;</td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						P. Simple</h2>\r\n					Esto es un mensaje de plantilla simple<br />\r\n					<br />\r\n					<a href=\"http://google.es\">Ir a google</a><br />\r\n					<a href=\"http://imagar.com\">http://imagar.com</a><br />\r\n					<br />\r\n					&nbsp;</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					El mensaje de claim de la promoción</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','','completed','16','',NULL,'2014-09-11 16:13:44','admin',2,2,0,0),
(157,3,'dnoguera@imagar.com','Administrador Community','prueba de links','<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://192.168.0.8/community-php/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					&nbsp;</td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						P. Simple</h2>\r\n					Esto es un mensaje de plantilla simple<br />\r\n					<br />\r\n					<a href=\"http://google.es\">Ir a google</a><br />\r\n					<a href=\"http://imagar.com\">http://imagar.com</a><br />\r\n					<br />\r\n					&nbsp;</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					Este es el pie del mensaje</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','','completed','16','',NULL,'2014-09-11 17:39:02','admin',2,2,0,0),
(158,3,'dnoguera@imagar.com','Administrador Community','Prueba email masivo','<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://192.168.0.8/community-php/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					&nbsp;</td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						P. Simple</h2>\r\n					Esto es un mensaje de plantilla simple<br />\r\n					<br />\r\n					<a href=\"http://google.es\">Ir a google</a><br />\r\n					<a href=\"http://imagar.com\">http://imagar.com</a><br />\r\n					<br />\r\n					&nbsp;</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					El pie del mensaje</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','','completed','15','',NULL,'2014-09-11 17:45:38','admin',6,6,0,0),
(159,3,'dnoguera@imagar.com','Administrador Community','Mensaje de prueba','<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://192.168.0.8/community-php/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					&nbsp;</td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						P. Simple</h2>\r\n					Esto es un mensaje de plantilla simple<br />\r\n					<br />\r\n					<a href=\"http://google.es\">Ir a google</a><br />\r\n					<a href=\"http://imagar.com\">http://imagar.com</a><br />\r\n					<br />\r\n					&nbsp;</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					el pie del mensaje</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','','completed','16','',NULL,'2014-09-12 09:49:57','admin',2,2,0,0),
(160,3,'dnoguera@imagar.com','Administrador Community','una prueba de blacklist','<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://192.168.0.8/community-php/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					&nbsp;</td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						P. Simple</h2>\r\n					Esto es un mensaje de plantilla simple<br />\r\n					<br />\r\n					<a href=\"http://google.es\">Ir a google</a><br />\r\n					<a href=\"http://imagar.com\">http://imagar.com</a><br />\r\n					<br />\r\n					&nbsp;</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					El pie del mensaje</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','','completed','16','',NULL,'2014-09-12 10:12:55','admin',2,2,0,0),
(161,3,'dnoguera@imagar.com','Administrador Community','una prueba de blacklist2','<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://192.168.0.8/community-php/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					&nbsp;</td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						P. Simple</h2>\r\n					Esto es un mensaje de plantilla simple<br />\r\n					<br />\r\n					<a href=\"http://google.es\">Ir a google</a><br />\r\n					<a href=\"http://imagar.com\">http://imagar.com</a><br />\r\n					<br />\r\n					&nbsp;</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					peeeeeeeeeeeeee</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','','completed','16','',NULL,'2014-09-12 10:30:45','admin',2,2,0,0),
(162,3,'dnoguera@imagar.com','Administrador Community','una prueba de blacklist3','<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://192.168.0.8/community-php/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					&nbsp;</td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						P. Simple</h2>\r\n					Esto es un mensaje de plantilla simple<br />\r\n					<br />\r\n					<a href=\"http://google.es\">Ir a google</a><br />\r\n					<a href=\"http://imagar.com\">http://imagar.com</a><br />\r\n					<br />\r\n					&nbsp;</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					peeeeeeeeeeeeee</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','','completed','16','',NULL,'2014-09-12 10:35:14','admin',1,1,0,0),
(163,3,'dnoguera@imagar.com','Administrador Community','El asunto del mensaje','<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"10px\" style=\"background-color:#f0f0f0;\" width=\"600\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://192.168.0.8/community-php/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					&nbsp;</td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						P. Simple</h2>\r\n					Esto es un mensaje de plantilla simple<br />\r\n					<br />\r\n					<a href=\"http://google.es\">Ir a google</a><br />\r\n					<a href=\"http://imagar.com\">http://imagar.com</a><br />\r\n					<br />\r\n					Ahora tienes un descuento de <span style=\"font-size: 26px;\"><strong>10%</strong></span>, aprovechalo<br />\r\n					<br />\r\n					&nbsp;</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					<span style=\"color: rgb(0, 153, 204);\">Te mantendremos informado de las promociones</span></td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','','completed','16','',NULL,'2014-09-12 12:28:06','admin',2,2,0,0);

/*Table structure for table `mailing_messages_files` */

DROP TABLE IF EXISTS `mailing_messages_files`;

CREATE TABLE `mailing_messages_files` (
  `id_file` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_message` int(11) unsigned NOT NULL DEFAULT '0',
  `file_name` text CHARACTER SET latin1,
  PRIMARY KEY (`id_file`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `mailing_messages_files` */

/*Table structure for table `mailing_messages_links` */

DROP TABLE IF EXISTS `mailing_messages_links`;

CREATE TABLE `mailing_messages_links` (
  `id_link` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_message` int(11) NOT NULL DEFAULT '0',
  `link_name` text CHARACTER SET latin1 NOT NULL,
  `url` text CHARACTER SET latin1 NOT NULL,
  `clicks` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_link`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

/*Data for the table `mailing_messages_links` */

insert  into `mailing_messages_links`(`id_link`,`id_message`,`link_name`,`url`,`clicks`) values 
(1,138,'','http://css-tricks.com/',3),
(2,149,'','http://www.css-tricks.com',0),
(3,150,'','http://www.css-tricks.com',0),
(4,150,'','Ir a la comunidad',0),
(5,151,'','http://www.css-tricks.com',0),
(6,151,'','http://localhost/community-php/?page=admin-template&id=3',0),
(7,152,'','http://www.css-tricks.com',0),
(8,152,'','http://localhost/community-php/?page=admin-template&id=3',0),
(9,152,'','http://www.css-tricks.com',0),
(10,152,'','http://localhost/community-php/?page=admin-template&id=3',0),
(11,152,'','http://192.168.0.8/community-php/?page=unsuscribe&u=cgonzalez@imagar.com&ua=822478ef4949846cbc9088b45ced6d9d78a1c453',0),
(12,152,'','http://www.css-tricks.com',0),
(13,152,'','http://localhost/community-php/?page=admin-template&id=3',0),
(14,152,'','http://www.css-tricks.com',0),
(15,152,'','http://localhost/community-php/?page=admin-template&id=3',0),
(16,152,'','http://192.168.0.8/community-php/?page=unsuscribe&u=dmarchante@imagar.com&ua=3fbb456567f6ae20c4302936940907cb17b8b648',0),
(17,152,'','http://www.css-tricks.com',0),
(18,152,'','http://localhost/community-php/?page=admin-template&id=3',0),
(19,152,'','http://www.css-tricks.com',0),
(20,152,'','http://localhost/community-php/?page=admin-template&id=3',0),
(21,152,'','http://192.168.0.8/community-php/?page=unsuscribe&u=dnoguera@imagar.com&ua=98009c00b8450c056dde18db1ea59a13afd34af0',0),
(22,152,'','http://www.css-tricks.com',0),
(23,152,'','http://localhost/community-php/?page=admin-template&id=3',0),
(24,152,'','http://www.css-tricks.com',0),
(25,152,'','http://localhost/community-php/?page=admin-template&id=3',0),
(26,152,'','http://192.168.0.8/community-php/?page=unsuscribe&u=odelgado@imagar.com&ua=1c391ec5c877caf727ec5f4e9f914e2d8b58012b',0),
(27,152,'','http://www.css-tricks.com',0),
(28,152,'','http://localhost/community-php/?page=admin-template&id=3',0),
(29,152,'','http://www.css-tricks.com',0),
(30,152,'','http://localhost/community-php/?page=admin-template&id=3',0),
(31,152,'','http://192.168.0.8/community-php/?page=unsuscribe&u=pramos@imagar.com&ua=6ee442b8c3c3ec7a44e08afa4daf2700915b9fca',0),
(32,152,'','http://www.css-tricks.com',0),
(33,152,'','http://localhost/community-php/?page=admin-template&id=3',0),
(34,152,'','http://www.css-tricks.com',0),
(35,152,'','http://localhost/community-php/?page=admin-template&id=3',0),
(36,152,'','http://192.168.0.8/community-php/?page=unsuscribe&u=shermida@imagar.com&ua=9db4fc9c2b1e9821708c9293382b9befc8ce7124',0),
(37,153,'','http://www.css-tricks.com',0),
(38,153,'','http://localhost/community-php/?page=admin-template&id=3',0),
(39,154,'','http://www.css-tricks.com',0),
(40,154,'','http://localhost/community-php/?page=admin-template&id=3',0),
(41,155,'','http://www.css-tricks.com',0),
(42,155,'','http://localhost/community-php/?page=admin-template&id=3',0),
(43,156,'Ir a google','http://google.es',4),
(44,156,'http://imagar.com','http://imagar.com',3),
(45,157,'Ir a google','http://google.es',1),
(46,157,'http://imagar.com','http://imagar.com',1),
(47,158,'Ir a google','http://google.es',4),
(48,158,'http://imagar.com','http://imagar.com',6),
(49,159,'Ir a google','http://google.es',1),
(50,159,'http://imagar.com','http://imagar.com',0),
(51,160,'Ir a google','http://google.es',1),
(52,160,'http://imagar.com','http://imagar.com',0),
(53,161,'Ir a google','http://google.es',2),
(54,161,'http://imagar.com','http://imagar.com',1),
(55,162,'Ir a google','http://google.es',0),
(56,162,'http://imagar.com','http://imagar.com',0),
(57,163,'Ir a google','http://google.es',0),
(58,163,'http://imagar.com','http://imagar.com',0);

/*Table structure for table `mailing_messages_links_users` */

DROP TABLE IF EXISTS `mailing_messages_links_users`;

CREATE TABLE `mailing_messages_links_users` (
  `id_link_user` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_link` int(11) NOT NULL,
  `id_message` int(11) NOT NULL,
  `username` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `username_email` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `date_link` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_link_user`)
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;

/*Data for the table `mailing_messages_links_users` */

insert  into `mailing_messages_links_users`(`id_link_user`,`id_link`,`id_message`,`username`,`username_email`,`date_link`) values 
(1,1,0,'','pramos@imagar.com','2014-09-11 11:07:49'),
(2,1,0,'','odelgado@imagar.com','2014-09-11 11:08:20'),
(3,1,0,'','pramos@imagar.com','2014-09-11 11:08:38'),
(4,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:32'),
(5,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:32'),
(6,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),
(7,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),
(8,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),
(9,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),
(10,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),
(11,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),
(12,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),
(13,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),
(14,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),
(15,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),
(16,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),
(17,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),
(18,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),
(19,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),
(20,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),
(21,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),
(22,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),
(23,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),
(24,834,0,'8943573','algo@imagar.com','2014-09-11 14:08:33'),
(25,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:18'),
(26,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),
(27,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),
(28,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),
(29,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),
(30,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),
(31,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),
(32,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),
(33,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),
(34,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),
(35,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),
(36,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),
(37,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),
(38,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),
(39,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),
(40,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),
(41,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),
(42,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),
(43,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),
(44,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),
(45,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:19'),
(46,834,0,'8943573','algo@imagar.com','2014-09-11 14:09:52'),
(47,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:33'),
(48,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:33'),
(49,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:33'),
(50,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:33'),
(51,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:33'),
(52,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:33'),
(53,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),
(54,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),
(55,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),
(56,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),
(57,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),
(58,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),
(59,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),
(60,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),
(61,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),
(62,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),
(63,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),
(64,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),
(65,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),
(66,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),
(67,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:34'),
(68,834,0,'8943573','algo@imagar.com','2014-09-11 14:12:47'),
(69,43,156,'','dnoguera@imagar.com','2014-09-11 16:31:23'),
(70,44,156,'','dnoguera@imagar.com','2014-09-11 16:31:37'),
(71,43,156,'','dnoguera@imagar.com','2014-09-11 16:31:40'),
(72,44,156,'','dnoguera@imagar.com','2014-09-11 16:31:44'),
(73,43,156,'','dnoguera@imagar.com','2014-09-11 16:31:46'),
(74,44,156,'','dnoguera@imagar.com','2014-09-11 16:31:48'),
(75,43,156,'','dnoguera@imagar.com','2014-09-11 16:32:12'),
(76,45,157,'','dnoguera@imagar.com','2014-09-11 17:43:08'),
(77,46,157,'','dnoguera@imagar.com','2014-09-11 17:43:27'),
(78,47,158,'','dmarchante@imagar.com','2014-09-11 17:54:42'),
(79,48,158,'','dmarchante@imagar.com','2014-09-11 17:54:48'),
(80,48,158,'','pramos@imagar.com','2014-09-11 17:59:36'),
(81,47,158,'','pramos@imagar.com','2014-09-11 18:00:03'),
(82,48,158,'','dnoguera@imagar.com','2014-09-11 18:00:41'),
(83,48,158,'','pramos@imagar.com','2014-09-11 18:00:56'),
(84,47,158,'','shermida@imagar.com','2014-09-11 18:01:26'),
(85,48,158,'','shermida@imagar.com','2014-09-11 18:01:30'),
(86,48,158,'','odelgado@imagar.com','2014-09-12 08:36:53'),
(87,47,158,'','odelgado@imagar.com','2014-09-12 08:37:15'),
(88,49,159,'','dnoguera@imagar.com','2014-09-12 09:59:25'),
(89,51,160,'','dnoguera@imagar.com','2014-09-12 10:15:44'),
(90,53,161,'','dnoguera@imagar.com','2014-09-12 10:33:47'),
(91,54,161,'','dnoguera@imagar.com','2014-09-12 10:33:54'),
(92,53,161,'','dnoguera@imagar.com','2014-09-12 10:36:18');

/*Table structure for table `mailing_messages_users` */

DROP TABLE IF EXISTS `mailing_messages_users`;

CREATE TABLE `mailing_messages_users` (
  `id_message_user` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_message` int(11) NOT NULL DEFAULT '0',
  `username_message` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `email_message` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `date_send` datetime DEFAULT NULL,
  `message_status` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT 'pending',
  `views` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_message_user`),
  KEY `id_message` (`id_message`),
  KEY `message_status` (`message_status`),
  KEY `username_message` (`username_message`)
) ENGINE=MyISAM AUTO_INCREMENT=867 DEFAULT CHARSET=utf8;

/*Data for the table `mailing_messages_users` */

insert  into `mailing_messages_users`(`id_message_user`,`id_message`,`username_message`,`email_message`,`date_send`,`message_status`,`views`) values 
(1,1,'admin','','2014-03-18 17:23:33','completed',0),
(2,1,'creativo','','2014-03-18 17:23:28','completed',0),
(3,2,'admin','',NULL,'pending',0),
(4,2,'creativo','',NULL,'pending',0),
(5,7,'admin','dnoguera@imagar.com',NULL,'black_list',4),
(6,7,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(7,7,'8943573','algo@imagar.com',NULL,'pending',11),
(8,7,'34534555','dnoguera@kk.com',NULL,'pending',0),
(9,7,'4455554','admin@kk.com',NULL,'pending',0),
(10,7,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),
(11,7,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),
(12,7,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),
(13,7,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),
(14,7,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),
(15,7,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),
(16,7,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(17,6,'20266370N','dnoguera@imagar.com','2014-03-21 09:51:44','failed',0),
(18,8,'admin','dnoguera@imagar2.com','2014-03-23 13:00:31','failed',0),
(19,8,'creativo','dnoguera@imagar3.com','2014-03-23 13:00:31','failed',0),
(20,8,'8943573','algo@imagar1.com','2014-03-23 13:00:31','failed',0),
(21,8,'34534555','dnoguera@kk.com','2014-03-23 13:00:31','failed',0),
(22,8,'4455554','admin@kk.com','2014-03-23 13:01:12','failed',0),
(23,8,'20266370S','dgarcia@imagar.com','2014-03-23 13:01:12','failed',0),
(24,8,'20266370R','shermida@imagar.com','2014-03-23 13:01:12','failed',0),
(25,8,'20266370V','pramos@imagar.com','2014-03-23 13:01:12','failed',0),
(26,8,'20266370X','dnoguera@gmail2.com','2014-03-23 13:01:46','failed',0),
(27,8,'20266370Q','nogueradavid@hotmail3.com','2014-03-23 13:01:46','failed',0),
(28,8,'20266370A','nogueradavid@hotmail2.com','2014-03-23 13:01:46','failed',0),
(29,8,'20266370N','dnoguera@imagar.com','2014-03-23 13:01:46','failed',0),
(30,9,'admin','dnoguera@imagar.com','2014-03-21 12:59:35','black_list',0),
(31,9,'creativo','dnoguera@imagar.com','2014-03-21 12:59:35','black_list',0),
(32,9,'8943573','algo@imagar.com','2014-03-21 12:59:35','pending',0),
(33,9,'34534555','dnoguera@kk.com','2014-03-21 12:59:35','pending',0),
(34,9,'4455554','admin@kk.com','2014-03-21 12:59:40','pending',0),
(35,9,'20266370S','dnoguera1@imagar1.com','2014-03-21 12:59:40','pending',0),
(36,9,'20266370R','dnoguera@imagar1.com','2014-03-21 12:59:40','pending',0),
(37,9,'20266370V','dnoguera@hotmail1.com','2014-03-21 12:59:40','pending',0),
(38,9,'20266370X','dnoguera@gmail2.com','2014-03-21 12:59:45','pending',0),
(39,9,'20266370Q','nogueradavid@hotmail3.com','2014-03-21 12:59:45','pending',0),
(40,9,'20266370A','nogueradavid@hotmail2.com','2014-03-21 12:59:45','pending',0),
(41,9,'20266370N','dnoguera@imagar.com','2014-03-21 12:59:46','black_list',0),
(42,10,'admin','dnoguera@imagar.com','2014-03-24 12:55:48','failed',0),
(43,10,'creativo','dnoguera@imagar.com','2014-03-24 12:55:48','failed',0),
(44,10,'8943573','algo@imagar.com','2014-03-24 12:55:48','failed',0),
(45,10,'34534555','dnoguera@kk.com','2014-03-24 12:55:48','failed',0),
(46,10,'4455554','admin@kk.com','2014-03-24 12:55:52','failed',0),
(47,10,'20266370S','dnoguera1@imagar1.com','2014-03-24 12:55:52','failed',0),
(48,10,'20266370R','dnoguera@imagar1.com','2014-03-24 12:55:52','failed',0),
(49,10,'20266370V','dnoguera@hotmail1.com','2014-03-24 12:55:52','failed',0),
(50,10,'20266370X','dnoguera@gmail2.com','2014-03-24 12:57:46','failed',0),
(51,10,'20266370Q','nogueradavid@hotmail3.com','2014-03-24 12:57:46','failed',0),
(52,10,'20266370A','nogueradavid@hotmail2.com','2014-03-24 12:57:46','failed',0),
(53,10,'20266370N','dnoguera@imagar.com','2014-03-24 12:57:46','failed',0),
(54,11,'admin','dnoguera@imagar.com','2014-03-23 16:13:20','failed',0),
(55,11,'creativo','dnoguera@imagar.com','2014-03-23 16:13:20','failed',0),
(56,11,'8943573','algo@imagar.com','2014-03-23 16:13:20','failed',0),
(57,11,'34534555','dnoguera@kk.com','2014-03-23 16:13:20','failed',0),
(58,11,'4455554','admin@kk.com','2014-03-23 16:08:47','failed',0),
(59,11,'20266370S','dnoguera1@imagar1.com','2014-03-23 16:08:47','failed',0),
(60,11,'20266370R','dnoguera@imagar1.com','2014-03-23 16:08:47','failed',0),
(61,11,'20266370V','dnoguera@hotmail1.com','2014-03-23 16:08:47','failed',0),
(62,11,'20266370X','dnoguera@gmail2.com','2014-03-23 16:09:08','failed',0),
(63,11,'20266370Q','nogueradavid@hotmail3.com','2014-03-23 16:09:08','failed',0),
(64,11,'20266370A','nogueradavid@hotmail2.com','2014-03-23 16:09:08','failed',0),
(65,11,'20266370N','dnoguera@imagar.com','2014-03-23 16:09:08','failed',0),
(66,12,'admin','dnoguera@imagar.com','2014-03-23 16:25:27','failed',0),
(67,12,'creativo','dnoguera@imagar.com','2014-03-23 16:25:27','failed',0),
(68,12,'8943573','algo@imagar.com','2014-03-23 16:25:27','failed',0),
(69,12,'34534555','dnoguera@kk.com','2014-03-23 16:25:27','failed',0),
(70,12,'4455554','admin@kk.com','2014-03-23 16:24:38','failed',0),
(71,12,'20266370S','dnoguera1@imagar1.com','2014-03-23 16:24:38','failed',0),
(72,12,'20266370R','dnoguera@imagar1.com','2014-03-23 16:24:38','failed',0),
(73,12,'20266370V','dnoguera@hotmail1.com','2014-03-23 16:24:38','failed',0),
(74,12,'20266370X','dnoguera@gmail2.com','2014-03-23 16:25:24','failed',0),
(75,12,'20266370Q','nogueradavid@hotmail3.com','2014-03-23 16:25:24','failed',0),
(76,12,'20266370A','nogueradavid@hotmail2.com','2014-03-23 16:25:24','failed',0),
(77,12,'20266370N','dnoguera@imagar.com','2014-03-23 16:25:24','failed',0),
(78,13,'admin','dnoguera@imagar.com','2014-03-23 16:26:48','failed',0),
(79,13,'creativo','dnoguera@imagar.com','2014-03-23 16:26:48','failed',0),
(80,13,'8943573','algo@imagar.com','2014-03-23 16:26:48','failed',0),
(81,13,'34534555','dnoguera@kk.com','2014-03-23 16:26:48','failed',0),
(82,13,'4455554','admin@kk.com','2014-03-23 16:26:06','failed',0),
(83,13,'20266370S','dnoguera1@imagar1.com','2014-03-23 16:26:06','failed',0),
(84,13,'20266370R','dnoguera@imagar1.com','2014-03-23 16:26:06','failed',0),
(85,13,'20266370V','dnoguera@hotmail1.com','2014-03-23 16:26:06','failed',0),
(86,13,'20266370X','dnoguera@gmail2.com','2014-03-23 16:26:11','failed',0),
(87,13,'20266370Q','nogueradavid@hotmail3.com','2014-03-23 16:26:11','failed',0),
(88,13,'20266370A','nogueradavid@hotmail2.com','2014-03-23 16:26:11','failed',0),
(89,13,'20266370N','dnoguera@imagar.com','2014-03-23 16:26:11','failed',0),
(90,14,'admin','dnoguera@imagar.com','2014-03-23 16:27:07','failed',0),
(91,14,'creativo','dnoguera@imagar.com','2014-03-23 16:27:07','failed',0),
(92,14,'8943573','algo@imagar.com','2014-03-23 16:27:07','failed',0),
(93,14,'34534555','dnoguera@kk.com','2014-03-23 16:27:07','failed',0),
(94,14,'4455554','admin@kk.com','2014-03-23 16:27:17','failed',0),
(95,14,'20266370S','dnoguera1@imagar1.com','2014-03-23 16:27:17','failed',0),
(96,14,'20266370R','dnoguera@imagar1.com','2014-03-23 16:27:17','failed',0),
(97,14,'20266370V','dnoguera@hotmail1.com','2014-03-23 16:27:17','failed',0),
(98,14,'20266370X','dnoguera@gmail2.com','2014-03-23 16:27:22','failed',0),
(99,14,'20266370Q','nogueradavid@hotmail3.com','2014-03-23 16:27:22','failed',0),
(100,14,'20266370A','nogueradavid@hotmail2.com','2014-03-23 16:27:22','failed',0),
(101,14,'20266370N','dnoguera@imagar.com','2014-03-23 16:27:22','failed',0),
(102,15,'admin','dnoguera@imagar.com','2014-03-23 16:28:20','failed',0),
(103,15,'creativo','dnoguera@imagar.com','2014-03-23 16:28:20','failed',0),
(104,15,'8943573','algo@imagar.com','2014-03-23 16:28:20','failed',0),
(105,15,'34534555','dnoguera@kk.com','2014-03-23 16:28:20','failed',0),
(106,15,'4455554','admin@kk.com','2014-03-23 16:28:30','failed',0),
(107,15,'20266370S','dnoguera1@imagar1.com','2014-03-23 16:28:30','failed',0),
(108,15,'20266370R','dnoguera@imagar1.com','2014-03-23 16:28:30','failed',0),
(109,15,'20266370V','dnoguera@hotmail1.com','2014-03-23 16:28:30','failed',0),
(110,15,'20266370X','dnoguera@gmail2.com','2014-03-23 16:28:35','failed',0),
(111,15,'20266370Q','nogueradavid@hotmail3.com','2014-03-23 16:28:35','failed',0),
(112,15,'20266370A','nogueradavid@hotmail2.com','2014-03-23 16:28:35','failed',0),
(113,15,'20266370N','dnoguera@imagar.com','2014-03-23 16:28:35','failed',0),
(114,16,'admin','dnoguera@imagar.com','2014-03-23 16:29:46','failed',0),
(115,16,'creativo','dnoguera@imagar.com','2014-03-23 16:29:46','failed',0),
(116,16,'8943573','algo@imagar.com','2014-03-23 16:29:46','failed',0),
(117,16,'34534555','dnoguera@kk.com','2014-03-23 16:29:46','failed',0),
(118,16,'4455554','admin@kk.com','2014-03-23 16:29:56','failed',0),
(119,16,'20266370S','dnoguera1@imagar1.com','2014-03-23 16:29:56','failed',0),
(120,16,'20266370R','dnoguera@imagar1.com','2014-03-23 16:29:56','failed',0),
(121,16,'20266370V','dnoguera@hotmail1.com','2014-03-23 16:29:56','failed',0),
(122,16,'20266370X','dnoguera@gmail2.com','2014-03-23 16:30:01','failed',0),
(123,16,'20266370Q','nogueradavid@hotmail3.com','2014-03-23 16:30:01','failed',0),
(124,16,'20266370A','nogueradavid@hotmail2.com','2014-03-23 16:30:01','failed',0),
(125,16,'20266370N','dnoguera@imagar.com','2014-03-23 16:30:01','failed',0),
(126,17,'admin','dnoguera@imagar.com','2014-03-23 16:30:50','failed',0),
(127,17,'creativo','dnoguera@imagar.com','2014-03-23 16:30:50','failed',0),
(128,17,'8943573','algo@imagar.com','2014-03-23 16:30:50','failed',0),
(129,17,'34534555','dnoguera@kk.com','2014-03-23 16:30:50','failed',0),
(130,17,'4455554','admin@kk.com','2014-03-23 16:31:00','failed',0),
(131,17,'20266370S','dnoguera1@imagar1.com','2014-03-23 16:31:00','failed',0),
(132,17,'20266370R','dnoguera@imagar1.com','2014-03-23 16:31:00','failed',0),
(133,17,'20266370V','dnoguera@hotmail1.com','2014-03-23 16:31:00','failed',0),
(134,17,'20266370X','dnoguera@gmail2.com','2014-03-23 16:31:05','failed',0),
(135,17,'20266370Q','nogueradavid@hotmail3.com','2014-03-23 16:31:05','failed',0),
(136,17,'20266370A','nogueradavid@hotmail2.com','2014-03-23 16:31:05','failed',0),
(137,17,'20266370N','dnoguera@imagar.com','2014-03-23 16:31:05','failed',0),
(138,18,'admin','dnoguera@imagar.com','2014-03-23 16:41:16','failed',0),
(139,18,'creativo','dnoguera@imagar.com','2014-03-23 16:41:16','failed',0),
(140,18,'8943573','algo@imagar.com','2014-03-23 16:41:16','failed',0),
(141,18,'34534555','dnoguera@kk.com','2014-03-23 16:41:16','failed',0),
(142,18,'4455554','admin@kk.com','2014-03-23 16:33:02','failed',0),
(143,18,'20266370S','dnoguera1@imagar1.com','2014-03-23 16:33:03','failed',0),
(144,18,'20266370R','dnoguera@imagar1.com','2014-03-23 16:33:03','failed',0),
(145,18,'20266370V','dnoguera@hotmail1.com','2014-03-23 16:33:03','failed',0),
(146,18,'20266370X','dnoguera@gmail2.com','2014-03-23 16:33:07','failed',0),
(147,18,'20266370Q','nogueradavid@hotmail3.com','2014-03-23 16:33:08','failed',0),
(148,18,'20266370A','nogueradavid@hotmail2.com','2014-03-23 16:33:08','failed',0),
(149,18,'20266370N','dnoguera@imagar.com','2014-03-23 16:33:08','failed',0),
(150,19,'admin','dnoguera@imagar.com','2014-03-23 16:41:35','failed',0),
(151,19,'creativo','dnoguera@imagar.com','2014-03-23 16:41:35','failed',0),
(152,19,'8943573','algo@imagar.com','2014-03-23 16:41:35','failed',0),
(153,19,'34534555','dnoguera@kk.com','2014-03-23 16:41:35','failed',0),
(154,19,'4455554','admin@kk.com','2014-03-23 16:41:45','failed',0),
(155,19,'20266370S','dnoguera1@imagar1.com','2014-03-23 16:41:45','failed',0),
(156,19,'20266370R','dnoguera@imagar1.com','2014-03-23 16:41:45','failed',0),
(157,19,'20266370V','dnoguera@hotmail1.com','2014-03-23 16:41:45','failed',0),
(158,19,'20266370X','dnoguera@gmail2.com','2014-03-23 16:41:50','failed',0),
(159,19,'20266370Q','nogueradavid@hotmail3.com','2014-03-23 16:41:50','failed',0),
(160,19,'20266370A','nogueradavid@hotmail2.com','2014-03-23 16:41:50','failed',0),
(161,19,'20266370N','dnoguera@imagar.com','2014-03-23 16:41:50','failed',0),
(162,20,'admin','dnoguera@imagar.com','2014-03-23 16:45:58','failed',0),
(163,20,'creativo','dnoguera@imagar.com','2014-03-23 16:45:58','failed',0),
(164,20,'8943573','algo@imagar.com','2014-03-23 16:45:58','failed',0),
(165,20,'34534555','dnoguera@kk.com','2014-03-23 16:45:58','failed',0),
(166,20,'4455554','admin@kk.com','2014-03-23 16:46:08','failed',0),
(167,20,'20266370S','dnoguera1@imagar1.com','2014-03-23 16:46:08','failed',0),
(168,20,'20266370R','dnoguera@imagar1.com','2014-03-23 16:46:08','failed',0),
(169,20,'20266370V','dnoguera@hotmail1.com','2014-03-23 16:46:08','failed',0),
(170,20,'20266370X','dnoguera@gmail2.com','2014-03-23 16:46:13','failed',0),
(171,20,'20266370Q','nogueradavid@hotmail3.com','2014-03-23 16:46:13','failed',0),
(172,20,'20266370A','nogueradavid@hotmail2.com','2014-03-23 16:46:13','failed',0),
(173,20,'20266370N','dnoguera@imagar.com','2014-03-23 16:46:13','failed',0),
(174,21,'admin','dnoguera@imagar.com','2014-03-23 17:02:28','failed',0),
(175,21,'creativo','dnoguera@imagar.com','2014-03-23 17:02:28','failed',0),
(176,21,'8943573','algo@imagar.com','2014-03-23 17:02:28','failed',0),
(177,21,'34534555','dnoguera@kk.com','2014-03-23 17:02:28','failed',0),
(178,21,'4455554','admin@kk.com','2014-03-23 17:10:40','failed',0),
(179,21,'20266370S','dnoguera1@imagar1.com','2014-03-23 17:10:40','failed',0),
(180,21,'20266370R','dnoguera@imagar1.com','2014-03-23 17:10:40','failed',0),
(181,21,'20266370V','dnoguera@hotmail1.com','2014-03-23 17:10:40','failed',0),
(182,21,'20266370X','dnoguera@gmail2.com','2014-03-23 16:53:50','failed',0),
(183,21,'20266370Q','nogueradavid@hotmail3.com','2014-03-23 16:53:50','failed',0),
(184,21,'20266370A','nogueradavid@hotmail2.com','2014-03-23 16:53:50','failed',0),
(185,21,'20266370N','dnoguera@imagar.com','2014-03-23 16:53:50','failed',0),
(186,22,'admin','dnoguera@imagar.com','2014-03-23 17:32:36','black_list',0),
(187,22,'creativo','dnoguera@imagar.com','2014-03-23 17:32:36','black_list',0),
(188,22,'8943573','algo@imagar.com','2014-03-23 17:32:37','pending',0),
(189,22,'34534555','dnoguera@kk.com','2014-03-23 17:32:37','pending',0),
(190,22,'4455554','admin@kk.com','2014-03-23 17:30:37','pending',0),
(191,22,'20266370S','dnoguera1@imagar1.com','2014-03-23 17:30:37','pending',0),
(192,22,'20266370R','dnoguera@imagar1.com','2014-03-23 17:30:37','pending',0),
(193,22,'20266370V','dnoguera@hotmail1.com','2014-03-23 17:30:37','pending',0),
(194,22,'20266370X','dnoguera@gmail2.com','2014-03-23 17:31:21','pending',0),
(195,22,'20266370Q','nogueradavid@hotmail3.com','2014-03-23 17:31:21','pending',0),
(196,22,'20266370A','nogueradavid@hotmail2.com','2014-03-23 17:31:21','pending',0),
(197,22,'20266370N','dnoguera@imagar.com','2014-03-23 17:31:21','black_list',0),
(198,23,'admin','dnoguera@imagar.com','2014-03-23 17:18:51','failed',0),
(199,23,'creativo','dnoguera@imagar.com','2014-03-23 17:18:51','failed',0),
(200,23,'8943573','algo@imagar.com','2014-03-23 17:18:51','failed',0),
(201,23,'34534555','dnoguera@kk.com','2014-03-23 17:18:51','failed',0),
(202,23,'4455554','admin@kk.com','2014-03-23 17:18:56','failed',0),
(203,23,'20266370S','dnoguera1@imagar1.com','2014-03-23 17:18:56','failed',0),
(204,23,'20266370R','dnoguera@imagar1.com','2014-03-23 17:18:56','failed',0),
(205,23,'20266370V','dnoguera@hotmail1.com','2014-03-23 17:18:56','failed',0),
(206,23,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),
(207,23,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),
(208,23,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),
(209,23,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(210,24,'admin','dnoguera@imagar.com','2014-03-23 17:20:24','failed',0),
(211,24,'creativo','dnoguera@imagar.com','2014-03-23 17:20:24','failed',0),
(212,24,'8943573','algo@imagar.com','2014-03-23 17:20:24','failed',0),
(213,24,'34534555','dnoguera@kk.com','2014-03-23 17:20:24','failed',0),
(214,24,'4455554','admin@kk.com','2014-03-23 17:20:29','failed',0),
(215,24,'20266370S','dnoguera1@imagar1.com','2014-03-23 17:20:29','failed',0),
(216,24,'20266370R','dnoguera@imagar1.com','2014-03-23 17:20:29','failed',0),
(217,24,'20266370V','dnoguera@hotmail1.com','2014-03-23 17:20:29','failed',0),
(218,24,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),
(219,24,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),
(220,24,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),
(221,24,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(222,25,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(223,25,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(224,25,'8943573','algo@imagar.com',NULL,'pending',0),
(225,25,'34534555','dnoguera@kk.com',NULL,'pending',0),
(226,25,'4455554','admin@kk.com',NULL,'pending',0),
(227,25,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),
(228,25,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),
(229,25,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),
(230,25,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),
(231,25,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),
(232,25,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),
(233,25,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(234,26,'admin','dnoguera@imagar.com','2014-03-24 17:36:09','failed',0),
(235,26,'creativo','dnoguera@imagar.com','2014-03-24 17:36:09','failed',0),
(236,26,'8943573','algo@imagar.com','2014-03-24 17:36:09','failed',0),
(237,26,'34534555','dnoguera@kk.com','2014-03-24 17:36:09','failed',0),
(238,26,'4455554','admin@kk.com','2014-03-24 17:36:16','failed',0),
(239,26,'20266370S','dnoguera1@imagar1.com','2014-03-24 17:36:16','failed',0),
(240,26,'20266370R','dnoguera@imagar1.com','2014-03-24 17:36:16','failed',0),
(241,26,'20266370V','dnoguera@hotmail1.com','2014-03-24 17:36:16','failed',0),
(242,26,'20266370X','dnoguera@gmail2.com','2014-03-24 17:33:52','failed',0),
(243,26,'20266370Q','nogueradavid@hotmail3.com','2014-03-24 17:33:52','failed',0),
(244,26,'20266370A','nogueradavid@hotmail2.com','2014-03-24 17:33:53','failed',0),
(245,26,'20266370N','dnoguera@imagar.com','2014-03-24 17:33:53','failed',0),
(246,27,'admin','dnoguera@imagar.com','2014-03-24 17:33:14','failed',0),
(247,27,'creativo','dnoguera@imagar.com','2014-03-24 17:33:14','failed',0),
(248,27,'8943573','algo@imagar.com','2014-03-24 17:33:14','failed',0),
(249,27,'34534555','dnoguera@kk.com','2014-03-24 17:33:14','failed',0),
(250,27,'4455554','admin@kk.com','2014-03-24 17:33:00','failed',0),
(251,27,'20266370S','dnoguera1@imagar1.com','2014-03-24 17:33:01','failed',0),
(252,27,'20266370R','dnoguera@imagar1.com','2014-03-24 17:33:01','failed',0),
(253,27,'20266370V','dnoguera@hotmail1.com','2014-03-24 17:33:01','failed',0),
(254,27,'20266370X','dnoguera@gmail2.com','2014-03-24 17:33:05','failed',0),
(255,27,'20266370Q','nogueradavid@hotmail3.com','2014-03-24 17:33:06','failed',0),
(256,27,'20266370A','nogueradavid@hotmail2.com','2014-03-24 17:33:06','failed',0),
(257,27,'20266370N','dnoguera@imagar.com','2014-03-24 17:33:06','failed',0),
(258,28,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(259,28,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(260,28,'8943573','algo@imagar.com',NULL,'pending',0),
(261,28,'34534555','dnoguera@kk.com',NULL,'pending',0),
(262,28,'4455554','admin@kk.com',NULL,'pending',0),
(263,28,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),
(264,28,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),
(265,28,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),
(266,28,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),
(267,28,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),
(268,28,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),
(269,28,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(270,29,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(271,29,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(272,29,'8943573','algo@imagar.com',NULL,'pending',0),
(273,29,'34534555','dnoguera@kk.com',NULL,'pending',0),
(274,29,'4455554','admin@kk.com',NULL,'pending',0),
(275,29,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),
(276,29,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),
(277,29,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),
(278,29,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),
(279,29,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),
(280,29,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),
(281,29,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(282,30,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(283,30,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(284,30,'8943573','algo@imagar.com',NULL,'pending',0),
(285,30,'34534555','dnoguera@kk.com',NULL,'pending',0),
(286,30,'4455554','admin@kk.com',NULL,'pending',0),
(287,30,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),
(288,30,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),
(289,30,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),
(290,30,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),
(291,30,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),
(292,30,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),
(293,30,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(294,31,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(295,31,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(296,31,'8943573','algo@imagar.com',NULL,'pending',0),
(297,31,'34534555','dnoguera@kk.com',NULL,'pending',0),
(298,31,'4455554','admin@kk.com',NULL,'pending',0),
(299,31,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),
(300,31,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),
(301,31,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),
(302,31,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),
(303,31,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),
(304,31,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),
(305,31,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(306,32,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(307,32,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(308,32,'8943573','algo@imagar.com',NULL,'pending',0),
(309,32,'34534555','dnoguera@kk.com',NULL,'pending',0),
(310,32,'4455554','admin@kk.com',NULL,'pending',0),
(311,32,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),
(312,32,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),
(313,32,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),
(314,32,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),
(315,32,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),
(316,32,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),
(317,32,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(318,33,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(319,33,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(320,33,'8943573','algo@imagar.com',NULL,'pending',0),
(321,33,'34534555','dnoguera@kk.com',NULL,'pending',0),
(322,33,'4455554','admin@kk.com',NULL,'pending',0),
(323,33,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),
(324,33,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),
(325,33,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),
(326,33,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),
(327,33,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),
(328,33,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),
(329,33,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(330,34,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(331,34,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(332,34,'8943573','algo@imagar.com',NULL,'pending',0),
(333,34,'34534555','dnoguera@kk.com',NULL,'pending',0),
(334,34,'4455554','admin@kk.com',NULL,'pending',0),
(335,34,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),
(336,34,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),
(337,34,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),
(338,34,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),
(339,34,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),
(340,34,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),
(341,34,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(342,35,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(343,35,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(344,35,'8943573','algo@imagar.com',NULL,'pending',0),
(345,35,'34534555','dnoguera@kk.com',NULL,'pending',0),
(346,35,'4455554','admin@kk.com',NULL,'pending',0),
(347,35,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),
(348,35,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),
(349,35,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),
(350,35,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),
(351,35,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),
(352,35,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),
(353,35,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(354,36,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(355,36,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(356,36,'8943573','algo@imagar.com',NULL,'pending',0),
(357,36,'34534555','dnoguera@kk.com',NULL,'pending',0),
(358,36,'4455554','admin@kk.com',NULL,'pending',0),
(359,36,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),
(360,36,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),
(361,36,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),
(362,36,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),
(363,36,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),
(364,36,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),
(365,36,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(366,37,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(367,37,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(368,37,'8943573','algo@imagar.com',NULL,'pending',0),
(369,37,'34534555','dnoguera@kk.com',NULL,'pending',0),
(370,37,'4455554','admin@kk.com',NULL,'pending',0),
(371,37,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),
(372,37,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),
(373,37,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),
(374,37,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),
(375,37,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),
(376,37,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),
(377,37,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(378,38,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(379,38,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(380,38,'8943573','algo@imagar.com',NULL,'pending',0),
(381,38,'34534555','dnoguera@kk.com',NULL,'pending',0),
(382,38,'4455554','admin@kk.com',NULL,'pending',0),
(383,38,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),
(384,38,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),
(385,38,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),
(386,38,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),
(387,38,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),
(388,38,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),
(389,38,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(390,39,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(391,39,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(392,39,'8943573','algo@imagar.com',NULL,'pending',0),
(393,39,'34534555','dnoguera@kk.com',NULL,'pending',0),
(394,39,'4455554','admin@kk.com',NULL,'pending',0),
(395,39,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),
(396,39,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),
(397,39,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),
(398,39,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),
(399,39,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),
(400,39,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),
(401,39,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(402,40,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),
(403,40,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),
(404,41,'20266370X','dnoguera@gmail2.com','2014-03-25 09:22:34','failed',0),
(405,42,'creativo','dnoguera@imagar.com','2014-03-24 16:37:00','failed',0),
(406,42,'8943573','algo@imagar.com','2014-03-24 16:37:00','failed',0),
(407,42,'34534555','dnoguera@kk.com','2014-03-24 16:37:00','failed',0),
(408,42,'4455554','admin@kk.com','2014-03-24 16:37:00','failed',0),
(409,42,'20266370S','dnoguera1@imagar1.com','2014-03-24 16:37:10','failed',0),
(410,42,'20266370R','dnoguera@imagar1.com','2014-03-24 16:37:10','failed',0),
(411,42,'20266370Q','nogueradavid@hotmail3.com','2014-03-24 16:37:10','failed',0),
(412,42,'20266370N','dnoguera@imagar.com','2014-03-24 16:37:10','failed',0),
(413,43,'admin','dnoguera@imagar.com','2014-03-24 17:29:02','failed',0),
(414,43,'creativo','dnoguera@imagar.com','2014-03-24 17:29:02','failed',0),
(415,44,'admin','dnoguera@imagar.com','2014-03-25 09:23:11','failed',0),
(416,44,'creativo','dnoguera@imagar.com','2014-03-25 09:23:11','failed',0),
(417,44,'8943573','algo@imagar.com','2014-03-25 09:23:11','failed',0),
(418,44,'34534555','dnoguera@kk.com','2014-03-25 09:23:11','failed',0),
(419,44,'4455554','admin@kk.com','2014-03-25 09:23:16','failed',0),
(420,44,'20266370S','dnoguera1@imagar1.com','2014-03-25 09:23:16','failed',0),
(421,44,'20266370R','dnoguera@imagar1.com','2014-03-25 09:23:16','failed',0),
(422,44,'20266370V','dnoguera@hotmail1.com','2014-03-25 09:23:16','failed',0),
(423,44,'20266370X','dnoguera@gmail2.com','2014-03-25 09:23:21','failed',0),
(424,44,'20266370Q','nogueradavid@hotmail3.com','2014-03-25 09:23:21','failed',0),
(425,44,'20266370A','nogueradavid@hotmail2.com','2014-03-25 09:23:21','failed',0),
(426,44,'20266370N','dnoguera@imagar.com','2014-03-25 09:23:21','failed',0),
(427,45,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(428,45,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(429,45,'8943573','algo@imagar.com',NULL,'pending',0),
(430,45,'34534555','dnoguera@kk.com',NULL,'pending',0),
(431,45,'4455554','admin@kk.com',NULL,'pending',0),
(432,45,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),
(433,45,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),
(434,45,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),
(435,45,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),
(436,45,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),
(437,45,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),
(438,45,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(439,46,'admin','dnoguera@imagar.com','2014-03-26 11:54:40','failed',0),
(440,46,'creativo','dnoguera@imagar.com','2014-03-26 11:54:40','failed',0),
(441,46,'8943573','algo@imagar.com','2014-03-26 11:54:40','failed',0),
(442,46,'34534555','dnoguera@kk.com','2014-03-26 11:54:40','failed',0),
(443,46,'4455554','admin@kk.com','2014-03-26 11:54:45','failed',0),
(444,46,'20266370S','dnoguera1@imagar1.com','2014-03-26 11:54:45','failed',0),
(445,46,'20266370R','dnoguera@imagar1.com','2014-03-26 11:54:45','failed',0),
(446,46,'20266370V','dnoguera@hotmail1.com','2014-03-26 11:54:45','failed',0),
(447,46,'20266370X','dnoguera@gmail2.com','2014-03-26 11:54:50','failed',0),
(448,46,'20266370Q','nogueradavid@hotmail3.com','2014-03-26 11:54:50','failed',0),
(449,46,'20266370A','nogueradavid@hotmail2.com','2014-03-26 11:54:50','failed',0),
(450,46,'20266370I','dnoguera@imagar.com','2014-03-26 11:54:50','failed',0),
(451,46,'20266370N','dnoguera@imagar.com','2014-03-26 11:54:55','failed',0),
(452,46,'responsable1','dnoguera@imagar.com','2014-03-26 11:54:55','failed',0),
(453,46,'responsable2','dnoguera@imagar.com','2014-03-26 11:54:55','failed',0),
(454,47,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(455,47,'8943573','algo@imagar.com',NULL,'pending',0),
(456,47,'34534555','dnoguera@kk.com',NULL,'pending',0),
(457,47,'4455554','admin@kk.com',NULL,'pending',0),
(458,47,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),
(459,47,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),
(460,47,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),
(461,47,'20266370I','dnoguera@imagar.com',NULL,'black_list',0),
(462,47,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(463,48,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(464,48,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(465,49,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(466,49,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(467,50,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(468,50,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(469,51,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(470,51,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(471,57,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(472,57,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(473,57,'8943573','algo@imagar.com',NULL,'pending',0),
(474,57,'34534555','dnoguera@kk.com',NULL,'pending',0),
(475,57,'4455554','admin@kk.com',NULL,'pending',0),
(476,57,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),
(477,57,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),
(478,57,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),
(479,57,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),
(480,57,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),
(481,57,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),
(482,57,'20266370I','dnoguera@imagar.com',NULL,'black_list',0),
(483,57,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(484,57,'responsable1','dnoguera@imagar.com',NULL,'black_list',0),
(485,57,'responsable2','dnoguera@imagar.com',NULL,'black_list',0),
(486,61,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(487,61,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(488,61,'8943573','algo@imagar.com',NULL,'pending',0),
(489,61,'34534555','dnoguera@kk.com',NULL,'pending',0),
(490,61,'4455554','admin@kk.com',NULL,'pending',0),
(491,61,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),
(492,61,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),
(493,61,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),
(494,61,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),
(495,61,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),
(496,61,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),
(497,61,'20266370I','dnoguera@imagar.com',NULL,'black_list',0),
(498,61,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(499,61,'responsable1','dnoguera@imagar.com',NULL,'black_list',0),
(500,61,'responsable2','dnoguera@imagar.com',NULL,'black_list',0),
(501,68,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(502,68,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(503,68,'8943573','algo@imagar.com',NULL,'pending',0),
(504,68,'34534555','dnoguera@kk.com',NULL,'pending',0),
(505,68,'4455554','admin@kk.com',NULL,'pending',0),
(506,68,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),
(507,68,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),
(508,68,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),
(509,68,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),
(510,68,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),
(511,68,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),
(512,68,'20266370I','dnoguera@imagar.com',NULL,'black_list',0),
(513,68,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(514,68,'responsable1','dnoguera@imagar.com',NULL,'black_list',0),
(515,68,'responsable2','dnoguera@imagar.com',NULL,'black_list',0),
(516,69,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(517,69,'34534555','dnoguera@kk.com',NULL,'pending',0),
(518,69,'20266370I','dnoguera@imagar.com',NULL,'black_list',0),
(519,69,'responsable1','dnoguera@imagar.com',NULL,'black_list',0),
(520,70,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(521,70,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(522,71,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(523,71,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(524,72,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(525,72,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(526,72,'8943573','algo@imagar.com',NULL,'pending',0),
(527,72,'34534555','dnoguera@kk.com',NULL,'pending',0),
(528,72,'4455554','admin@kk.com',NULL,'pending',0),
(529,72,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),
(530,72,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),
(531,72,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),
(532,72,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),
(533,72,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),
(534,72,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),
(535,72,'20266370I','dnoguera@imagar.com',NULL,'black_list',0),
(536,72,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(537,72,'responsable1','dnoguera@imagar.com',NULL,'black_list',0),
(538,72,'responsable2','dnoguera@imagar.com',NULL,'black_list',0),
(539,73,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(540,73,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(541,73,'8943573','algo@imagar.com',NULL,'pending',0),
(542,73,'34534555','dnoguera@kk.com',NULL,'pending',0),
(543,73,'4455554','admin@kk.com',NULL,'pending',0),
(544,73,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),
(545,73,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),
(546,73,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),
(547,73,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),
(548,73,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),
(549,73,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),
(550,73,'20266370I','dnoguera@imagar.com',NULL,'black_list',0),
(551,73,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(552,73,'responsable1','dnoguera@imagar.com',NULL,'black_list',0),
(553,73,'responsable2','dnoguera@imagar.com',NULL,'black_list',0),
(554,74,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(555,74,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(556,74,'8943573','algo@imagar.com',NULL,'pending',0),
(557,74,'34534555','dnoguera@kk.com',NULL,'pending',0),
(558,74,'4455554','admin@kk.com',NULL,'pending',0),
(559,74,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),
(560,74,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),
(561,74,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),
(562,74,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),
(563,74,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),
(564,74,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),
(565,74,'20266370I','dnoguera@imagar.com',NULL,'black_list',0),
(566,74,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(567,74,'responsable1','dnoguera@imagar.com',NULL,'black_list',0),
(568,74,'responsable2','dnoguera@imagar.com',NULL,'black_list',0),
(569,75,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(570,75,'34534555','dnoguera@kk.com',NULL,'pending',0),
(571,75,'20266370I','dnoguera@imagar.com',NULL,'black_list',0),
(572,75,'responsable1','dnoguera@imagar.com',NULL,'black_list',0),
(573,76,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(574,76,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(575,76,'8943573','algo@imagar.com',NULL,'pending',0),
(576,76,'34534555','dnoguera@kk.com',NULL,'pending',0),
(577,76,'4455554','admin@kk.com',NULL,'pending',0),
(578,76,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),
(579,76,'20266370R','dnoguera@imagar1.com',NULL,'pending',0),
(580,76,'20266370V','dnoguera@hotmail1.com',NULL,'pending',0),
(581,76,'20266370X','dnoguera@gmail2.com',NULL,'pending',0),
(582,76,'20266370Q','nogueradavid@hotmail3.com',NULL,'pending',0),
(583,76,'20266370A','nogueradavid@hotmail2.com',NULL,'pending',0),
(584,76,'20266370I','dnoguera@imagar.com',NULL,'black_list',0),
(585,76,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(586,76,'responsable1','dnoguera@imagar.com',NULL,'black_list',0),
(587,76,'responsable2','dnoguera@imagar.com',NULL,'black_list',0),
(588,78,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(589,79,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(590,80,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(591,80,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(592,81,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(593,82,'20266370I','dnoguera@imagar.com',NULL,'black_list',0),
(594,84,'creativo','dnoguera@imagar.com',NULL,'black_list',0),
(595,84,'8943573','algo@imagar.com',NULL,'pending',0),
(596,84,'4455554','admin@kk.com',NULL,'pending',0),
(597,84,'20266370S','dnoguera1@imagar1.com',NULL,'pending',0),
(598,84,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(599,89,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(600,90,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(601,91,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(602,92,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(603,93,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(604,93,'X6821471Q','dnoguera@imagar.com',NULL,'black_list',0),
(605,94,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(606,94,'X6821471Q','dnoguera@imagar.com',NULL,'black_list',0),
(607,95,'admin','dnoguera@imagar.com','2014-04-08 13:59:08','send',0),
(608,95,'18050671H','dnoguera@imagar.com','2014-04-08 14:02:17','send',0),
(609,95,'X6821471Q','dnoguera@imagar.com','2014-04-08 14:04:17','send',0),
(610,95,'20266370N','dnoguera@imagar.com','2014-04-08 14:06:18','send',0),
(611,96,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(612,96,'18050671H','dnoguera@imagar.com',NULL,'black_list',0),
(613,96,'X6821471Q','dnoguera@imagar.com',NULL,'black_list',0),
(614,96,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(615,97,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(616,97,'18050671H','dnoguera@imagar.com',NULL,'black_list',0),
(617,97,'X6821471Q','dnoguera@imagar.com',NULL,'black_list',0),
(618,97,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(619,99,'admin','dnoguera@imagar.com','2014-04-08 13:51:07','failed',0),
(620,99,'18050671H','dnoguera@imagar.com','2014-04-08 13:51:07','failed',0),
(621,99,'X6821471Q','dnoguera@imagar.com','2014-04-08 13:51:07','failed',0),
(622,99,'20266370N','dnoguera@imagar.com','2014-04-08 13:51:07','failed',0),
(623,100,'admin','dnoguera@imagar.com','2014-04-23 10:27:38','send',0),
(624,100,'18050671H','dnoguera@imagar.com','2014-04-23 10:35:29','send',0),
(625,100,'X6821471Q','dnoguera@imagar.com','2014-04-23 10:37:29','send',0),
(626,100,'20266370N','dnoguera@imagar.com','2014-04-23 10:22:00','send',0),
(627,101,'admin','dnoguera@imagar.com','2014-04-23 09:18:20','send',0),
(628,103,'admin','dnoguera@imagar.com','2014-04-23 13:24:46','send',0),
(629,104,'admin','dnoguera@imagar.com','2014-04-23 16:07:20','send',0),
(630,105,'admin','dnoguera@imagar.com',NULL,'black_list',0),
(631,105,'18050671H','dnoguera@imagar.com',NULL,'black_list',0),
(632,105,'X6821471Q','dnoguera@imagar.com',NULL,'black_list',0),
(633,105,'20266370N','dnoguera@imagar.com',NULL,'black_list',0),
(634,108,'','dnoguera@imagar.com',NULL,'black_list',0),
(635,108,'','2dnoguera@imagar.com',NULL,'pending',0),
(636,108,'','david.noguera@grg.com',NULL,'pending',0),
(637,109,'','dnoguera@imagar.com',NULL,'black_list',0),
(638,109,'','2dnoguera@imagar.com',NULL,'pending',0),
(639,109,'','david.noguera@grg.com',NULL,'pending',0),
(640,109,'','pramos@imagar.com',NULL,'pending',0),
(641,112,'','dnoguera@imagar.com',NULL,'black_list',0),
(642,112,'','2dnoguera@imagar.com',NULL,'pending',0),
(643,112,'','david.noguera@grg.com',NULL,'pending',0),
(644,112,'','pramos@imagar.com',NULL,'pending',0),
(645,113,'','dnoguera@imagar.com',NULL,'black_list',0),
(646,113,'','2dnoguera@imagar.com',NULL,'pending',0),
(647,113,'','david.noguera@grg.com',NULL,'pending',0),
(648,113,'','pramos@imagar.com',NULL,'pending',0),
(649,114,'','dnoguera@imagar.com',NULL,'black_list',0),
(650,114,'','2dnoguera@imagar.com',NULL,'pending',0),
(651,114,'','david.noguera@grg.com',NULL,'pending',0),
(652,114,'','pramos@imagar.com',NULL,'pending',0),
(653,115,'','dnoguera@imagar.com',NULL,'black_list',0),
(654,115,'','2dnoguera@imagar.com',NULL,'pending',0),
(655,115,'','david.noguera@grg.com',NULL,'pending',0),
(656,115,'','pramos@imagar.com',NULL,'pending',0),
(657,116,'','dnoguera@imagar.com',NULL,'black_list',0),
(658,116,'','2dnoguera@imagar.com',NULL,'pending',0),
(659,116,'','david.noguera@grg.com',NULL,'pending',0),
(660,116,'','pramos@imagar.com',NULL,'pending',0),
(661,117,'','dnoguera@imagar.com',NULL,'black_list',0),
(662,117,'','2dnoguera@imagar.com',NULL,'pending',0),
(663,117,'','david.noguera@grg.com',NULL,'pending',0),
(664,117,'','pramos@imagar.com',NULL,'pending',0),
(665,118,'','dnoguera@imagar.com','2014-04-30 10:36:24','send',0),
(666,118,'','2dnoguera@imagar.com','2014-04-30 10:38:24','send',0),
(667,118,'','david.noguera@grg.com','2014-04-30 10:40:38','send',0),
(668,118,'','pramos@imagar.com','2014-04-30 10:42:38','send',0),
(669,119,'','dnoguera@imagar.com','2014-04-30 10:45:29','send',0),
(670,119,'','2dnoguera@imagar.com','2014-04-30 10:47:29','send',0),
(671,119,'','david.noguera@grg.com','2014-04-30 10:49:29','send',0),
(672,119,'','pramos@imagar.com','2014-04-30 10:51:30','send',0),
(673,120,'','dnoguera@imagar.com',NULL,'black_list',0),
(674,120,'','2dnoguera@imagar.com',NULL,'pending',0),
(675,120,'','david.noguera@grg.com',NULL,'pending',0),
(676,120,'','pramos@imagar.com',NULL,'pending',0),
(677,121,'','dnoguera@imagar.com','2014-05-05 17:07:43','send',1),
(678,121,'','pramos@imagar.com','2014-05-05 17:09:43','send',0),
(679,121,'','odelgado@imagar.com','2014-05-05 17:11:44','send',0),
(680,121,'','dmarchante@imagar.com','2014-05-05 17:13:44','send',0),
(681,123,'','dnoguera@imagar.com',NULL,'black_list',0),
(682,123,'','shermida@imagar.com',NULL,'pending',0),
(683,124,'','dnoguera@imagar.com',NULL,'black_list',0),
(684,124,'','pramos@imagar.com',NULL,'pending',0),
(685,124,'','odelgado@imagar.com',NULL,'pending',0),
(686,124,'','dmarchante@imagar.com',NULL,'pending',0),
(687,124,'','shermida@imagar.com',NULL,'pending',0),
(688,125,'','dmarchante@imagar.com',NULL,'pending',0),
(689,125,'','dnoguera@imagar.com',NULL,'black_list',0),
(690,125,'','odelgado@imagar.com',NULL,'pending',0),
(691,125,'','pramos@imagar.com',NULL,'pending',0),
(692,125,'','shermida@imagar.com',NULL,'pending',0),
(693,126,'','dnoguera@imagar.com',NULL,'black_list',0),
(694,126,'','shermida@imagar.com',NULL,'pending',0),
(695,127,'','cgonzalez@imagar.com',NULL,'pending',0),
(696,127,'','dmarchante@imagar.com',NULL,'pending',0),
(697,127,'','dnoguera@imagar.com',NULL,'black_list',0),
(698,127,'','odelgado@imagar.com',NULL,'pending',0),
(699,127,'','pramos@imagar.com',NULL,'pending',0),
(700,127,'','shermida@imagar.com',NULL,'pending',0),
(701,128,'','dmarchante@imagar.com',NULL,'pending',0),
(702,128,'','dnoguera@imagar.com',NULL,'black_list',0),
(703,128,'','odelgado@imagar.com',NULL,'pending',0),
(704,128,'','pramos@imagar.com',NULL,'pending',0),
(705,128,'','shermida@imagar.com',NULL,'pending',0),
(706,129,'','cgonzalez@imagar.com',NULL,'pending',0),
(707,129,'','dmarchante@imagar.com',NULL,'pending',0),
(708,129,'','dnoguera@imagar.com',NULL,'black_list',0),
(709,129,'','odelgado@imagar.com',NULL,'pending',0),
(710,129,'','pramos@imagar.com',NULL,'pending',0),
(711,129,'','shermida@imagar.com',NULL,'pending',0),
(712,130,'','cgonzalez@imagar.com',NULL,'pending',0),
(713,130,'','dmarchante@imagar.com',NULL,'pending',0),
(714,130,'','dnoguera@imagar.com',NULL,'black_list',0),
(715,130,'','odelgado@imagar.com',NULL,'pending',0),
(716,130,'','pramos@imagar.com',NULL,'pending',0),
(717,130,'','shermida@imagar.com',NULL,'pending',0),
(718,131,'','cgonzalez@imagar.com',NULL,'pending',0),
(719,131,'','dmarchante@imagar.com',NULL,'pending',0),
(720,131,'','dnoguera@imagar.com',NULL,'black_list',0),
(721,131,'','odelgado@imagar.com',NULL,'pending',0),
(722,131,'','pramos@imagar.com',NULL,'pending',0),
(723,131,'','shermida@imagar.com',NULL,'pending',0),
(724,132,'','cgonzalez@imagar.com',NULL,'pending',0),
(725,132,'','dmarchante@imagar.com',NULL,'pending',0),
(726,132,'','dnoguera@imagar.com',NULL,'black_list',0),
(727,132,'','odelgado@imagar.com',NULL,'pending',0),
(728,132,'','pramos@imagar.com',NULL,'pending',0),
(729,132,'','shermida@imagar.com',NULL,'pending',0),
(730,133,'','cgonzalez@imagar.com',NULL,'pending',0),
(731,133,'','dmarchante@imagar.com',NULL,'pending',0),
(732,133,'','dnoguera@imagar.com',NULL,'black_list',0),
(733,133,'','odelgado@imagar.com',NULL,'pending',0),
(734,133,'','pramos@imagar.com',NULL,'pending',0),
(735,133,'','shermida@imagar.com',NULL,'pending',0),
(736,134,'','cgonzalez@imagar.com',NULL,'pending',0),
(737,134,'','dmarchante@imagar.com',NULL,'pending',0),
(738,134,'','dnoguera@imagar.com',NULL,'black_list',0),
(739,134,'','odelgado@imagar.com',NULL,'pending',0),
(740,134,'','pramos@imagar.com',NULL,'pending',0),
(741,134,'','shermida@imagar.com',NULL,'pending',0),
(742,135,'','cgonzalez@imagar.com',NULL,'pending',0),
(743,135,'','dmarchante@imagar.com',NULL,'pending',0),
(744,135,'','dnoguera@imagar.com',NULL,'black_list',0),
(745,135,'','odelgado@imagar.com',NULL,'pending',0),
(746,135,'','pramos@imagar.com',NULL,'pending',0),
(747,135,'','shermida@imagar.com',NULL,'pending',0),
(748,137,'','cgonzalez@imagar.com',NULL,'pending',0),
(749,137,'','dmarchante@imagar.com',NULL,'pending',0),
(750,137,'','dnoguera@imagar.com',NULL,'black_list',0),
(751,137,'','odelgado@imagar.com',NULL,'pending',0),
(752,137,'','pramos@imagar.com',NULL,'pending',0),
(753,137,'','shermida@imagar.com',NULL,'pending',0),
(754,138,'','cgonzalez@imagar.com',NULL,'pending',0),
(755,138,'','dmarchante@imagar.com',NULL,'pending',0),
(756,138,'','dnoguera@imagar.com',NULL,'black_list',0),
(757,138,'','odelgado@imagar.com',NULL,'pending',0),
(758,138,'','pramos@imagar.com',NULL,'pending',0),
(759,138,'','shermida@imagar.com',NULL,'pending',0),
(760,139,'','cgonzalez@imagar.com',NULL,'pending',0),
(761,139,'','dmarchante@imagar.com',NULL,'pending',0),
(762,139,'','dnoguera@imagar.com',NULL,'black_list',0),
(763,139,'','odelgado@imagar.com',NULL,'pending',0),
(764,139,'','pramos@imagar.com',NULL,'pending',0),
(765,139,'','shermida@imagar.com',NULL,'pending',0),
(766,140,'','cgonzalez@imagar.com',NULL,'pending',0),
(767,140,'','dmarchante@imagar.com',NULL,'pending',0),
(768,140,'','dnoguera@imagar.com',NULL,'black_list',0),
(769,140,'','odelgado@imagar.com',NULL,'pending',0),
(770,140,'','pramos@imagar.com',NULL,'pending',0),
(771,140,'','shermida@imagar.com',NULL,'pending',0),
(772,141,'','cgonzalez@imagar.com',NULL,'pending',0),
(773,141,'','dmarchante@imagar.com',NULL,'pending',0),
(774,141,'','dnoguera@imagar.com',NULL,'black_list',0),
(775,141,'','odelgado@imagar.com',NULL,'pending',0),
(776,141,'','pramos@imagar.com',NULL,'pending',0),
(777,141,'','shermida@imagar.com',NULL,'pending',0),
(778,142,'','cgonzalez@imagar.com',NULL,'pending',0),
(779,142,'','dmarchante@imagar.com',NULL,'pending',0),
(780,142,'','dnoguera@imagar.com',NULL,'black_list',0),
(781,142,'','odelgado@imagar.com',NULL,'pending',0),
(782,142,'','pramos@imagar.com',NULL,'pending',0),
(783,142,'','shermida@imagar.com',NULL,'pending',0),
(784,143,'','cgonzalez@imagar.com',NULL,'pending',0),
(785,143,'','dmarchante@imagar.com',NULL,'pending',0),
(786,143,'','dnoguera@imagar.com',NULL,'black_list',0),
(787,143,'','odelgado@imagar.com',NULL,'pending',0),
(788,143,'','pramos@imagar.com',NULL,'pending',0),
(789,143,'','shermida@imagar.com',NULL,'pending',0),
(790,144,'','cgonzalez@imagar.com',NULL,'pending',0),
(791,144,'','dmarchante@imagar.com',NULL,'pending',0),
(792,144,'','dnoguera@imagar.com',NULL,'black_list',0),
(793,144,'','odelgado@imagar.com',NULL,'pending',0),
(794,144,'','pramos@imagar.com',NULL,'pending',0),
(795,144,'','shermida@imagar.com',NULL,'pending',0),
(796,145,'','cgonzalez@imagar.com',NULL,'pending',0),
(797,145,'','dmarchante@imagar.com',NULL,'pending',0),
(798,145,'','dnoguera@imagar.com',NULL,'black_list',0),
(799,145,'','odelgado@imagar.com',NULL,'pending',0),
(800,145,'','pramos@imagar.com',NULL,'pending',0),
(801,145,'','shermida@imagar.com',NULL,'pending',0),
(802,146,'','cgonzalez@imagar.com',NULL,'pending',0),
(803,146,'','dmarchante@imagar.com',NULL,'pending',0),
(804,146,'','dnoguera@imagar.com',NULL,'black_list',0),
(805,146,'','odelgado@imagar.com',NULL,'pending',0),
(806,146,'','pramos@imagar.com',NULL,'pending',0),
(807,146,'','shermida@imagar.com',NULL,'pending',0),
(808,147,'','cgonzalez@imagar.com',NULL,'pending',0),
(809,147,'','dmarchante@imagar.com',NULL,'pending',0),
(810,147,'','dnoguera@imagar.com',NULL,'black_list',0),
(811,147,'','odelgado@imagar.com',NULL,'pending',0),
(812,147,'','pramos@imagar.com',NULL,'pending',0),
(813,147,'','shermida@imagar.com',NULL,'pending',0),
(814,149,'','cgonzalez@imagar.com',NULL,'pending',0),
(815,149,'','dmarchante@imagar.com',NULL,'pending',0),
(816,149,'','dnoguera@imagar.com',NULL,'black_list',0),
(817,149,'','odelgado@imagar.com',NULL,'pending',0),
(818,149,'','pramos@imagar.com',NULL,'pending',0),
(819,149,'','shermida@imagar.com',NULL,'pending',0),
(820,150,'','cgonzalez@imagar.com',NULL,'pending',0),
(821,150,'','dmarchante@imagar.com',NULL,'pending',0),
(822,150,'','dnoguera@imagar.com',NULL,'black_list',0),
(823,150,'','odelgado@imagar.com',NULL,'pending',0),
(824,150,'','pramos@imagar.com',NULL,'pending',0),
(825,150,'','shermida@imagar.com',NULL,'pending',0),
(826,151,'','cgonzalez@imagar.com',NULL,'pending',0),
(827,151,'','dmarchante@imagar.com',NULL,'pending',0),
(828,151,'','dnoguera@imagar.com',NULL,'black_list',0),
(829,151,'','odelgado@imagar.com',NULL,'pending',0),
(830,151,'','pramos@imagar.com',NULL,'pending',0),
(831,151,'','shermida@imagar.com',NULL,'pending',0),
(832,152,'','cgonzalez@imagar.com','2014-09-11 13:49:23','send',0),
(833,152,'','dmarchante@imagar.com','2014-09-11 13:51:24','send',1),
(834,152,'','dnoguera@imagar.com','2014-09-11 13:53:24','send',1),
(835,152,'','odelgado@imagar.com','2014-09-11 13:55:25','send',1),
(836,152,'','pramos@imagar.com','2014-09-11 13:57:26','send',1),
(837,152,'','shermida@imagar.com','2014-09-11 13:59:27','send',1),
(838,153,'','cgonzalez@imagar.com','2014-09-11 15:38:06','send',0),
(839,153,'','dmarchante@imagar.com','2014-09-11 15:40:06','send',1),
(840,153,'','dnoguera@imagar.com','2014-09-11 15:42:06','send',1),
(841,153,'','odelgado@imagar.com','2014-09-11 15:44:07','send',1),
(842,153,'','pramos@imagar.com','2014-09-11 15:46:07','send',0),
(843,153,'','shermida@imagar.com','2014-09-11 15:48:08','send',1),
(844,154,'','dnoguera@imagar.com',NULL,'black_list',0),
(845,154,'','nogueradavid@hotmail.com',NULL,'pending',0),
(846,155,'','dnoguera@imagar.com','2014-09-11 16:06:08','send',1),
(847,155,'','nogueradavid@hotmail.com','2014-09-11 16:08:08','send',0),
(848,156,'','dnoguera@imagar.com','2014-09-11 16:21:39','send',1),
(849,156,'','nogueradavid@hotmail.com','2014-09-11 16:23:39','send',0),
(850,157,'','dnoguera@imagar.com','2014-09-11 17:41:06','send',1),
(851,157,'','nogueradavid@hotmail.com','2014-09-11 17:43:06','send',0),
(852,158,'','cgonzalez@imagar.com','2014-09-11 17:47:42','send',0),
(853,158,'','dmarchante@imagar.com','2014-09-11 17:49:42','send',1),
(854,158,'','dnoguera@imagar.com','2014-09-11 17:51:43','send',1),
(855,158,'','odelgado@imagar.com','2014-09-11 17:53:43','send',1),
(856,158,'','pramos@imagar.com','2014-09-11 17:55:43','send',1),
(857,158,'','shermida@imagar.com','2014-09-11 17:57:44','send',1),
(858,159,'','dnoguera@imagar.com','2014-09-12 09:51:59','send',1),
(859,159,'','nogueradavid@hotmail.com','2014-09-12 09:54:00','send',0),
(860,160,'','dnoguera@imagar.com','2014-09-12 10:14:57','send',1),
(861,160,'','nogueradavid@hotmail.com','2014-09-12 10:16:57','send',0),
(862,161,'','dnoguera@imagar.com','2014-09-12 10:32:49','send',1),
(863,161,'','nogueradavid@hotmail.com','2014-09-12 10:34:49','send',0),
(864,162,'','nogueradavid@hotmail.com','2014-09-12 10:37:20','send',0),
(865,163,'','dnoguera@imagar.com','2014-09-12 12:30:14','send',0),
(866,163,'','nogueradavid@hotmail.com','2014-09-12 12:32:15','send',0);

/*Table structure for table `mailing_templates` */

DROP TABLE IF EXISTS `mailing_templates`;

CREATE TABLE `mailing_templates` (
  `id_template` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `template_name` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `template_body` text CHARACTER SET latin1,
  `template_mini` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `activo` int(1) NOT NULL DEFAULT '1',
  `id_type` int(11) NOT NULL DEFAULT '0',
  `id_campaign` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_template`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `mailing_templates` */

insert  into `mailing_templates`(`id_template`,`template_name`,`template_body`,`template_mini`,`activo`,`id_type`,`id_campaign`) values 
(1,'Plantilla Convocatoria Descuentos','<meta content=\"text/html; charset=UTF-8\" http-equiv=\"Content-Type\" />\r\n<title></title>\r\n<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						Convocatoria</h2>\r\n					[CONTENT]</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					[FOOTER]</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','1398327405_bg01.jpg',1,1,2),
(2,'Plantilla Descuento + Reclamo','<meta content=\"text/html; charset=UTF-8\" http-equiv=\"Content-Type\" />\r\n<title></title>\r\n<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://192.168.0.8/community-php/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					<br />\r\n					[USER_LOGO]</td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						Convocatoria</h2>\r\n					[USER_EMPRESA]<br />\r\n					<br />\r\n					[DATE_PROMOCION]<br />\r\n					<br />\r\n					Consigue un descuento de <strong>[DESCUENTO_PROMOCION]</strong><br />\r\n					<br />\r\n					[CLAIM_PROMOCION]</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					[USER_DIRECCION]</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','1398328115_bg01.jpg',1,3,2),
(3,'Plantilla simple','<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"10px\" style=\"background-color:#f0f0f0;\" width=\"600\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://192.168.0.8/community-php/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					&nbsp;</td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						P. Simple</h2>\r\n					Esto es un mensaje de plantilla simple<br />\r\n					<br />\r\n					<a href=\"http://google.es\">Ir a google</a><br />\r\n					<a href=\"http://imagar.com\">http://imagar.com</a><br />\r\n					<br />\r\n					Ahora tienes un descuento de <span style=\"font-size: 26px;\"><strong>[DESCUENTO_PROMOCION]%</strong></span>, aprovechalo<br />\r\n					<br />\r\n					&nbsp;</td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					<span style=\"color: rgb(0, 153, 204);\">[CLAIM_PROMOCION]</span></td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','1398328167_bg_globos.jpg',1,2,1),
(8,'gg','ggg','',2,2,2),
(9,'dfgdfgd f','d fdfgdfgdfgdfgdf','',0,1,1),
(10,'fffffffffffffffffff','5555555555<br />\r\n[CONTENT]','',2,1,2),
(11,'La cuarta plantilla de comunicación','<table align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"10\" style=\"width: 600px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /></td>\r\n			<td style=\"vertical-align: top; width: 100%;\">\r\n				<h2>\r\n					El cuerpo del Cuarto mensaje.</h2>\r\n				<br />\r\n				[CONTENT]</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n','1398328335_1347877359_mexico3.jpg',1,2,1),
(12,'Plantilla de reclamo ','<meta content=\"text/html; charset=UTF-8\" http-equiv=\"Content-Type\" />\r\n<title></title>\r\n<div align=\"center\">\r\n	<table border=\"0\" cellpadding=\"10px\" cellspacing=\"0\" width=\"400\">\r\n		<tbody>\r\n			<tr valign=\"top\">\r\n				<td rowspan=\"2\" width=\"194\">\r\n					<img alt=\"\" src=\"http://localhost/alain/images/mailing/images/logo.png\" style=\"width: 100px; height: 75px;\" /><br />\r\n					<br />\r\n					[USER_LOGO]</td>\r\n				<td style=\"vertical-align: top; width: 100%;\">\r\n					<h2>\r\n						Reclamo</h2>\r\n					[USER_EMPRESA] te felicita!!<br />\r\n					[CLAIM_PROMOCION]<br />\r\n					<br />\r\n					<br />\r\n					Consigue un descuento de [DESCUENTO_PROMOCION] %<br />\r\n					<br />\r\n					fecha l&iacute;mite de la promoci&oacute;n [DATE_PROMOCION]<br />\r\n					<br />\r\n					[USER_DIRECCION]</td>\r\n			</tr>\r\n		</tbody>\r\n	</table>\r\n</div>\r\n','1399549926_bg.jpg',1,2,3);

/*Table structure for table `mailing_templates_types` */

DROP TABLE IF EXISTS `mailing_templates_types`;

CREATE TABLE `mailing_templates_types` (
  `id_type` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name_type` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT '',
  PRIMARY KEY (`id_type`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `mailing_templates_types` */

insert  into `mailing_templates_types`(`id_type`,`name_type`) values 
(1,'Descuentos'),
(2,'Reclamo'),
(3,'Descuentos+Reclamo');

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
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

/*Data for the table `mensajes` */

insert  into `mensajes`(`id_mensaje`,`user_remitente`,`user_destinatario`,`date_mensaje`,`asunto_mensaje`,`mensaje_cuerpo`,`estado`,`estado_remitente`) values 
(1,'admin','david','2014-09-19 18:40:49','mensaje de prueba','el primer mensaje de prueba',1,0),
(2,'admin','david','2014-09-19 18:43:18','Segundo mensaje','bla bla bla',1,0),
(3,'admin','david','2014-09-21 03:05:46','test3','hshshshshhsbhsbdhs shdsg d',0,1),
(4,'admin','david','2014-09-21 03:40:23','test5','aaaaaaaaaaaaa',1,0),
(5,'admin','david','2014-09-21 03:40:53','tst5','kkkkkkkkkkk',1,1),
(6,'admin','david','2014-09-22 09:15:16','gdfg','dfgdf',1,0),
(7,'admin','david','2014-09-22 09:36:24','fghfg','hfghf',1,0),
(8,'david','admin','2014-09-22 11:21:55','Prueba de mensaje','Este es un mensaje de prueba para el administrador de la comunidad',2,0),
(9,'david','admin','2014-09-22 11:22:48','Prueba 2','Otro mensaje de prueba para el administrador',1,0),
(10,'david','admin','2014-09-22 11:25:32','prueba envío','El mensaje de prueba de envíos',1,0),
(11,'admin','david','2014-09-22 15:31:32','prueba de comillas','Me \"gusta\" un montón',1,0),
(12,'admin','david','2014-09-22 16:53:26','Comilla en \"asunto\" y cuerpo','Este mensaje \"tambien\" tiene comilllas',1,0),
(13,'admin','david','2014-10-03 11:08:14','Que hay de nuevo','Mándame un mensaje de prueba',0,0),
(14,'admin','david','2014-10-21 11:03:59','Mensaje desde perfil','Un mensaje desde el perfil de usuario',0,0),
(15,'dcancho','admin','2015-02-28 01:01:38','Hola!!','Tenía en su casa una ama que pasaba de los cuarenta, y una sobrina que no llegaba a los veinte, y un mozo de campo y plaza',1,0),
(16,'admin','dcancho','2015-02-28 16:39:27','Re: Hola!!','Que tal!!!\r\n\r\nCancho : \r\n-------------------------------\r\n<small><em class=\"text-muted\">Tenía en su casa una ama que pasaba de los cuarenta, y una sobrina que no llegaba a los veinte, y un mozo de campo y plaza</em></small>',0,0),
(17,'borja','david','2015-03-15 03:39:12','Soy nuevo','El resto della concluían sayo de velarte, calzas de velludo para las fiestas, con sus pantuflos de lo mesmo, y los días de entresemana se honraba con su vellorí de lo más fino.',0,1),
(18,'admin','senen','2015-10-27 13:22:16','prueba','bla bla bla',1,0),
(19,'admin','borja','2016-03-17 11:09:53','hola borja','nbjbkjb',2,0),
(20,'admin','dcancho','2016-05-09 17:53:00','Re: Hola!!','Cancho : asdasdasddddddddddddddddd\r\n-------------------------------\r\nTenía en su casa una ama que pasaba de los cuarenta, y una sobrina que no llegaba a los veinte, y un mozo de campo y plaza',0,0),
(21,'pedro','borja','2016-12-19 09:50:34','Test canales','el mensaje del test de canales',1,0),
(22,'borja','pedro','2016-12-19 09:51:56','respuesta canales','mi respuesta a ',0,0),
(23,'pedro','borja','2016-12-19 09:54:46','otro test','ssss',2,0),
(24,'borja','pedro','2016-12-19 09:56:42','Re: Test canales','Pedro : me encanta\r\n-------------------------------\r\nel mensaje del test de canales',1,0),
(25,'pedro','borja','2016-12-19 09:59:31','hoal perfil','ddddd',0,0),
(26,'admin','pedro','2016-12-20 16:17:34','prueba','mensaje de prueba',1,1);

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
  PRIMARY KEY (`id_comentario`),
  KEY `user_comentario` (`user_comentario`)
) ENGINE=MyISAM AUTO_INCREMENT=87 DEFAULT CHARSET=utf8;

/*Data for the table `muro_comentarios` */

insert  into `muro_comentarios`(`id_comentario`,`tipo_muro`,`seccion_comentario`,`id_comentario_id`,`canal`,`comentario`,`user_comentario`,`date_comentario`,`votaciones`,`estado`,`seleccion_reto`) values 
(1,'principal','',0,'comercial','un comentariio','admin','2014-07-29 14:46:12',0,1,0),
(2,'principal','',0,'comercial','segundo comentario','admin','2014-07-29 14:46:57',0,1,0),
(3,'principal','',0,'comercial','ffds gsdfgsdfg','admin','2014-07-30 10:44:49',0,1,0),
(4,'principal','',0,'comercial','sd fgsdfgsdfgsdfg','admin','2014-07-30 10:44:52',0,1,0),
(5,'principal','',0,'comercial','sd fgsdfgsdfgsdfgsdfg','admin','2014-07-30 10:44:55',0,1,0),
(6,'principal','',0,'comercial','111111111111111','admin','2014-07-30 10:44:59',0,1,0),
(7,'principal','',6,'comercial','te respondo','admin','2014-09-10 10:10:08',0,1,0),
(8,'principal','',6,'comercial','otra respuesra','admin','2014-09-10 12:39:37',0,1,0),
(9,'principal','',3,'comercial','dfs sdfsdf','admin','2014-09-10 12:42:26',0,1,0),
(10,'principal','',0,'gerente','un comentario en gerentes','admin','2014-09-18 10:31:00',0,1,0),
(11,'principal','',0,'comercial','Hola a todos!!  La nueva comunidad','david','2014-09-18 16:21:26',0,1,0),
(12,'principal','',6,'comercial','Yo también te respondo','david','2014-09-23 09:46:43',0,1,0),
(13,'principal','',0,'comercial','Buenos días a todos!!!','david','2014-09-23 12:47:45',0,1,0),
(14,'principal','',0,'comercial','Que hay de nuevo hoy?','david','2014-09-23 12:47:50',1,1,0),
(15,'principal','',0,'comercial','Buenos días!!!','admin','2014-09-23 12:48:19',0,1,0),
(16,'principal','',0,'comercial','Buenos días a todos!!! hoy he votado unos videos','david','2014-09-29 18:01:26',1,1,0),
(17,'principal','',16,'comercial','un respuesta al comentario','admin','2014-10-03 13:12:03',0,1,0),
(18,'principal','',0,'comercial','Han añadido las ultimas noticias. A ver si añaden cosas interesantes por fin y que nos gusten a todos!!!!','david','2014-10-12 01:33:45',0,1,0),
(19,'principal','',0,'comercial','La primera noticia no esta mal. A ver si siguen asi','david','2014-10-12 01:35:53',0,1,0),
(20,'principal','',0,'comercial','Hola a todos','admin','2014-10-17 17:04:53',0,1,0),
(21,'principal','',0,'comercial','Buenas tardes','david','2014-11-28 13:16:59',0,1,0),
(22,'principal','',0,'comercial','hola!!!','admin','2014-11-28 18:18:53',0,1,0),
(23,'principal','',0,'comercial','Hola camión','admin','2014-12-04 12:02:23',0,1,0),
(24,'principal','',0,'comercial','Adios camión','admin','2014-12-04 12:03:28',0,1,0),
(25,'principal','',0,'comercial','¿Como estas camión?','admin','2014-12-04 12:04:22',0,1,0),
(26,'principal','',0,'comercial','Y este año...','admin','2014-12-04 12:05:44',0,1,0),
(27,'principal','',0,'comercial','','admin','2014-12-04 12:16:18',0,1,0),
(28,'principal','',0,'comercial','&iquest;Qu&eacute; tal?','admin','2014-12-04 12:45:28',0,1,0),
(29,'principal','',0,'comercial','','admin','2014-12-04 13:01:03',0,2,0),
(30,'principal','',0,'comercial','','admin','2014-12-04 13:02:23',0,2,0),
(31,'principal','',0,'comercial','','admin','2014-12-04 13:05:51',0,2,0),
(32,'principal','',0,'comercial','ok\'\'\'\'\'','admin','2014-12-04 14:14:00',0,1,0),
(33,'principal','',0,'gerente','mas ok\'\'\'','admin','2014-12-04 14:14:14',0,1,0),
(34,'principal','',33,'gerente','pues sí','admin','2014-12-04 14:18:39',0,1,0),
(35,'principal','',33,'gerente','nooo','admin','2014-12-04 14:19:45',0,1,0),
(36,'principal','',33,'gerente','ok\'','admin','2014-12-04 14:24:50',0,1,0),
(37,'principal','',33,'gerente','ción\'','admin','2014-12-04 14:25:00',0,1,0),
(38,'principal','',33,'gerente','ok\' camión','admin','2014-12-04 14:25:24',0,1,0),
(39,'principal','',0,'comercial','电视机/電視機','admin','2014-12-18 09:34:32',1,1,0),
(40,'principal','',0,'gerente','Ánimo a todos los gerentes!!','claudio','2015-02-28 00:23:43',0,1,0),
(41,'principal','',0,'comercial','Hola a todos','dcancho','2015-02-28 00:30:40',1,1,0),
(42,'principal','',33,'gerente','ja ja ja','claudio','2015-02-28 00:36:28',0,1,0),
(43,'principal','',41,'comercial','Que tal Cancho','admin','2015-02-28 00:37:49',0,1,0),
(44,'principal','',0,'comercial','Buenas noches a todos','borja','2015-03-14 01:04:29',0,1,0),
(45,'principal','',0,'gerente','Buenos días a todos','claudio','2015-03-18 10:32:19',1,1,0),
(46,'principal','',0,'gerente','  ','claudio','2015-03-18 10:34:49',0,2,0),
(47,'principal','',0,'gerente','    ','claudio','2015-03-18 10:36:05',0,2,0),
(48,'principal','',0,'gerente','Cono estais??','claudio','2015-03-18 10:37:38',0,1,0),
(49,'principal','',0,'canal_test','holas','admin','2015-05-06 17:39:49',0,1,0),
(50,'principal','',0,'comercial','Buen fin de semana a todos','borja','2015-06-13 01:50:14',1,1,0),
(51,'principal','',0,'comercial','que tal','pedro','2015-08-14 10:18:32',1,1,0),
(52,'principal','',0,'canal_test','Hola','admin','2015-09-28 09:02:00',0,1,0),
(53,'principal','',51,'comercial','wdqadads','admin','2015-09-28 09:02:23',0,1,0),
(54,'principal','',0,'canal_test','sdfsdf','admin','2015-09-28 10:35:55',0,1,0),
(55,'principal','',48,'gerente','buu','senen','2015-10-03 03:57:40',0,1,0),
(56,'principal','',0,'comercial','You asked, Font Awesome delivers with 66 shiny new icons in version 4.4. Want to request new icons? Here\'s how. Need vectors or want to use on the desktop? Chec','admin','2015-10-19 15:37:56',0,1,0),
(57,'principal','',56,'comercial','Control padding and rounded corners with two optional modifier classes.','admin','2015-10-19 15:38:15',0,1,0),
(58,'principal','',0,'comercial','Apparently, Adblock Plus can remove Font Awesome brand icons with their \"Remove Social Media Buttons\" setting','pedro','2015-10-22 16:30:55',1,1,0),
(59,'principal','',56,'comercial','Me gussta mucho','admin','2015-10-26 16:15:52',0,1,0),
(60,'principal','',0,'canal_test','Buenas tardes','admin','2015-10-27 16:42:55',0,1,0),
(61,'principal','',56,'comercial','kiko','admin','2015-11-12 16:24:56',0,1,0),
(62,'principal','',0,'gerente','otro en el canal gerentes','admin','2016-01-19 08:44:53',0,1,0),
(63,'principal','',0,'canal_test','otro','admin','2016-01-19 08:48:28',0,1,0),
(64,'principal','',0,'canal_test','otro444','admin','2016-01-19 08:48:36',0,1,0),
(65,'principal','',64,'canal_test','dddd','admin','2016-01-19 08:48:49',0,1,0),
(66,'47','',0,'admin','algo','admin','2016-01-19 09:30:43',2,1,0),
(67,'47','',0,'admin','massss','admin','2016-01-19 09:31:03',0,1,0),
(68,'47','',0,'comercial','me ha encantado','borja','2016-01-19 11:17:58',1,1,0),
(69,'47','',0,'comercial','Otro mas','dgarcia','2016-01-19 11:25:22',0,1,0),
(70,'48','',0,'admin','me gusta el reto','admin','2016-01-19 11:27:14',1,1,0),
(71,'48','',0,'comercial','ja ja aja','borja','2016-01-19 11:27:39',0,1,0),
(72,'principal','',0,'canal_test','Bootstrap provides custom events for most plugins\' unique actions. Generally, these come in an infinitive and past participle form - where the infinitive (ex. s','admin','2016-01-20 15:56:08',0,1,0),
(73,'principal','',56,'comercial','test img','pedro','2016-03-10 15:56:33',0,1,0),
(74,'principal','',0,'comercial','Un panel pal muro','admin','2016-03-14 09:19:14',0,1,0),
(75,'principal','',74,'comercial','me respondo yo solo','admin','2016-03-14 09:19:30',0,1,0),
(76,'principal','',0,'comercial','Hola a todos comerciales','dcancho','2016-03-14 10:17:47',0,1,0),
(77,'principal','',0,'comercial','hola cancho!!','admin','2016-03-14 10:18:15',0,1,0),
(78,'principal','',0,'gerente','Buenos días responsables','claudio','2016-03-14 10:18:57',1,1,0),
(79,'principal','',0,'gerente','Que tal Claudio?, cuanto tiempo!!!','admin','2016-03-14 10:19:35',0,1,0),
(80,'principal','',0,'comercial','hola #javi','admin','2016-10-20 10:44:45',0,1,0),
(81,'principal','',0,'comercial','hola @javi','admin','2016-10-20 10:45:19',0,1,0),
(82,'principal','',79,'gerente','xzxxz','admin','2016-11-23 10:39:08',0,1,0),
(83,'principal','',0,'comercial','Hola pedro','borja','2016-12-20 09:22:39',0,1,0),
(84,'principal','',0,'gerente','Hola Borja','pedro','2016-12-20 09:23:27',0,1,0),
(85,'principal','',0,'gerente','Buenos días Borja!!!!!!!!!!','pedro','2016-12-20 09:25:04',0,1,0),
(86,'principal','',85,'gerente','buenas Pedro!!','borja','2016-12-20 09:26:01',0,1,0);

/*Table structure for table `muro_comentarios_votaciones` */

DROP TABLE IF EXISTS `muro_comentarios_votaciones`;

CREATE TABLE `muro_comentarios_votaciones` (
  `id_votacion` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_comentario` int(11) NOT NULL DEFAULT '0',
  `user_votacion` varchar(100) NOT NULL DEFAULT '',
  `date_votacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_votacion`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `muro_comentarios_votaciones` */

insert  into `muro_comentarios_votaciones`(`id_votacion`,`id_comentario`,`user_votacion`,`date_votacion`) values 
(1,16,'admin','2014-10-11 17:48:15'),
(2,14,'admin','2014-10-11 17:48:24'),
(3,39,'dcancho','2015-02-28 00:34:35'),
(4,41,'admin','2015-02-28 00:36:59'),
(5,45,'admin','2015-03-18 10:33:37'),
(6,51,'admin','2015-09-16 10:09:23'),
(7,50,'admin','2015-09-28 09:02:11'),
(8,58,'admin','2015-11-12 16:21:31'),
(9,68,'admin','2016-01-19 11:24:30'),
(10,66,'borja','2016-01-19 11:25:03'),
(11,66,'dgarcia','2016-01-19 11:26:20'),
(12,70,'borja','2016-01-19 11:27:31'),
(13,78,'admin','2016-03-17 09:59:46');

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
  `registro` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_area`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `na_areas` */

insert  into `na_areas`(`id_area`,`area_nombre`,`area_descripcion`,`area_canal`,`estado`,`puntos`,`limite_users`,`area_fecha`,`registro`) values 
(9,'Área de prueba inicial','El primer curso de formación para el canal comerciales','comercial',0,10,50,'2014-08-01 09:06:32',0),
(10,'Curso 2 de prueba de formación inicial para comerciales','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam dolor nulla, sodales et pretium quis, iaculis id ex. Quisque pharetra in ex in hendrerit','comercial',2,8,50,'2014-10-02 11:33:19',1),
(11,'Curso de inscripcion 12','Curso en el que los usuarios se pueden inscribir con un límite máximo de usuarios inscritos. 2','comercial',1,2012,122,'2014-10-13 10:43:16',1),
(12,'Prueba de curso sin tareas','I was stumped for a long time by the fact that even when using addslashes and stripslashes explicitly on the field values double quotes (\") still didn´t seem to show up in strings read from a database. Until I looked at the source, and realised that the field value is just truncated at the first occurrence of a double quote. the remainder of the string is there (in the source), but is ignored when the form is displayed and submitted.','comercial',1,50,10,'2014-11-24 11:36:46',1),
(13,'test alerts','desc trext alerts','comercial',2,0,9999,'2014-12-24 02:54:02',0),
(14,'test alerts','desc trext alerts','comercial',0,0,9999,'2014-12-24 02:54:49',0),
(15,'Tarea nueva de prueba22','Working on web performance is a combination of obvious best practices (optimize assets), very tricky decisions (what can I defer loading on and what can´t I?), and nuanced choices (which animation technique is the most appropriate?).','comercial',1,4,100,'2015-10-05 13:55:56',1),
(16,'prueba canales','prueba de canales para un canal','comercial,gerente',1,1,99999,'2016-12-21 09:45:11',1);

/*Table structure for table `na_areas_grupos` */

DROP TABLE IF EXISTS `na_areas_grupos`;

CREATE TABLE `na_areas_grupos` (
  `id_grupo` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_area` int(11) unsigned NOT NULL DEFAULT '0',
  `grupo_nombre` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_grupo`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `na_areas_grupos` */

insert  into `na_areas_grupos`(`id_grupo`,`id_area`,`grupo_nombre`) values 
(1,9,'Grupo1'),
(2,9,'Grupo2'),
(3,14,'grupo test'),
(4,11,'Grupo 1'),
(5,14,'Otro grupo'),
(6,15,'test');

/*Table structure for table `na_areas_grupos_users` */

DROP TABLE IF EXISTS `na_areas_grupos_users`;

CREATE TABLE `na_areas_grupos_users` (
  `id_grupo` int(11) unsigned NOT NULL DEFAULT '0',
  `grupo_username` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_grupo`,`grupo_username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `na_areas_grupos_users` */

insert  into `na_areas_grupos_users`(`id_grupo`,`grupo_username`) values 
(1,'admin'),
(6,'claudio');

/*Table structure for table `na_areas_users` */

DROP TABLE IF EXISTS `na_areas_users`;

CREATE TABLE `na_areas_users` (
  `id_area` int(11) NOT NULL DEFAULT '0',
  `username_area` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_area`,`username_area`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `na_areas_users` */

insert  into `na_areas_users`(`id_area`,`username_area`) values 
(9,'admin'),
(9,'david'),
(10,'admin'),
(10,'claudio'),
(10,'dcancho'),
(11,'borja'),
(11,'claudio'),
(11,'david'),
(12,'admin'),
(12,'claudio'),
(12,'dcancho'),
(15,'admin'),
(15,'borja'),
(15,'claudio'),
(15,'pedro'),
(16,'borja'),
(16,'pedro');

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
  `id_recompensa` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_tarea`),
  KEY `id_area` (`id_area`),
  KEY `activa` (`activa`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

/*Data for the table `na_tareas` */

insert  into `na_tareas`(`id_tarea`,`id_area`,`tarea_titulo`,`tarea_descripcion`,`tipo`,`tarea_grupo`,`user_add`,`activa`,`tarea_archivo`,`activa_links`,`id_recompensa`) values 
(8,9,'Tarea de formulario para el primer curso de formación','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu gravida ante, vel elementum neque. Suspendisse in aliquam diam.','formulario',0,'admin',1,'',1,0),
(9,10,'Formulario curso 2','Nulla bibendum mollis pulvinar. Nullam felis leo, mattis quis lacus a, mattis dictum tortor. Mauris ac feugiat turpis.','formulario',0,'admin',1,'',1,0),
(10,9,'Una tarea de fichero','La desc de una tarea de fichero','fichero',1,'admin',1,'1413272430_lorem-ipsum.jpg',1,0),
(11,9,'Tarea de grupos','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla elementum condimentum purus, ut ultrices tortor vestibulum ac. Nunc varius dapibus massa et sollicitudin.','fichero',1,'admin',1,'1414684191_model_puntos.xls',1,0),
(12,11,'Planificación proyecto Redmen','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ullamcorper volutpat scelerisque. Proin et tempus ex. Sed ut neque in tellus hendrerit accumsan. Integer aliquam, leo ac dictum dictum, lorem nulla faucibus nibh, sed placerat leo elit in justo. Integer id sapien urna.','formulario',1,'admin',1,'1444035098_planficaci__n_proyecto_redmen.pdf',1,0),
(13,11,'Documentacion proyecto','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ullamcorper volutpat scelerisque. Proin et tempus ex. Sed ut neque in tellus hendrerit accumsan. Integer aliquam, leo ac dictum dictum, lorem nulla faucibus nibh, sed placerat leo elit in justo. Integer id sapien urna.','fichero',1,'admin',1,'1444035162_planficaci__n_proyecto_redmen.pdf',1,0),
(14,11,'Test tarea','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ullamcorper volutpat scelerisque. Proin et tempus ex. Sed ut neque in tellus hendrerit accumsan. Integer aliquam, leo ac dictum dictum, lorem nulla faucibus nibh, sed placerat leo elit in justo. Integer id sapien urna.','fichero',0,'admin',1,'1444036737_cumplimiento_bono_mayo_2015.pdf',1,0),
(15,11,'Cuestionario 1','redirectURL($_SERVER[´REQUEST_URI´].\"&t=3\");','formulario',0,'admin',0,'',1,0),
(16,15,'Cuestionario con recompensa','Un cuestionario con Recompensa e participativo','formulario',0,'admin',1,'',1,1),
(17,15,'Otra tarea pa Asiduos','La descripciond e la tarea de formulario para asiduos','formulario',0,'admin',1,'',1,3),
(18,14,'Otra','La descripcion de otra tarea de fichero','fichero',0,'admin',1,'1454418539_entrevista_desarrollo_kiabi_lider_tienda.docx',1,0),
(19,15,'Ptra tarea de fichero el un área','La descripción de la tarea sin recompensa','fichero',0,'admin',1,'1454418918_entrevista_desarrollo_kiabi_vendedores.docx',1,0),
(20,14,'Vuestionario de grupos','klsdlskjd sdkjfsld','formulario',1,'admin',1,'',1,3),
(21,16,'Formulario autocorregible','Un formulario autocorregible. Solo valido para preguntas de opción única','formulario',0,'admin',1,'',1,0);

/*Table structure for table `na_tareas_documentos` */

DROP TABLE IF EXISTS `na_tareas_documentos`;

CREATE TABLE `na_tareas_documentos` (
  `id_documento` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_tarea` int(11) unsigned NOT NULL DEFAULT '0',
  `documento_tipo` varchar(100) NOT NULL DEFAULT 'fichero' COMMENT 'fichero;video;podcast;enlace',
  `documento_nombre` varchar(250) NOT NULL DEFAULT '',
  `documento_file` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_documento`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

/*Data for the table `na_tareas_documentos` */

insert  into `na_tareas_documentos`(`id_documento`,`id_tarea`,`documento_tipo`,`documento_nombre`,`documento_file`) values 
(18,10,'enlace','Un enlace a google','http://google.es'),
(19,10,'fichero','Una imagen, tipo fichero','1413272511_tumblr_n8psyhbag61slhhf0o1_1280.jpg'),
(20,10,'enlace','Enlace a imagar.com','http://imagar.com'),
(22,10,'video','Un video de prueba','1348036284_video_2_inicio_de_la_aventura_juntos_reducido__2.avi.mp4');

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

insert  into `na_tareas_formularios_finalizados`(`id_tarea`,`user_tarea`,`date_finalizacion`,`revision`,`puntos`,`user_revision`,`date_revision`) values 
(8,'admin','2014-10-14 17:10:32',1,7,'admin','2014-12-10 09:55:43'),
(9,'admin','2014-10-03 10:23:02',1,7,'admin','2014-12-16 12:46:39'),
(9,'dcancho','2015-02-28 00:58:32',0,0,'',NULL),
(16,'admin','2016-09-30 12:53:32',1,8,'admin','2016-09-30 12:54:08'),
(17,'admin','2016-05-06 12:11:20',0,0,'',NULL),
(20,'admin','2016-03-17 10:44:06',1,3,'admin','2016-03-17 10:45:37'),
(21,'admin','2016-12-21 16:22:06',1,5,'admin','2016-12-21 16:22:06'),
(21,'pedro','2016-12-21 16:33:25',1,10,'admin','2016-12-21 16:33:25'),
(21,'borja','2016-12-21 16:35:08',1,0,'admin','2016-12-21 16:35:08');

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
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

/*Data for the table `na_tareas_formularios_finalizados_history` */

insert  into `na_tareas_formularios_finalizados_history`(`id_history`,`id_tarea`,`user_tarea`,`date_finalizacion`,`revision`,`puntos`,`user_revision`,`date_revision`,`date_history`,`user_history`) values 
(23,17,'admin','2016-02-02 17:08:23',1,7,'admin','2016-02-02 17:08:46','2016-05-06 12:10:40','admin'),
(24,16,'admin','2016-02-02 15:55:51',1,3,'admin','2016-02-02 17:07:19','2016-09-30 12:52:46','admin');

/*Table structure for table `na_tareas_grupos` */

DROP TABLE IF EXISTS `na_tareas_grupos`;

CREATE TABLE `na_tareas_grupos` (
  `id_tarea` int(11) unsigned NOT NULL DEFAULT '0',
  `id_grupo` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_tarea`,`id_grupo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `na_tareas_grupos` */

insert  into `na_tareas_grupos`(`id_tarea`,`id_grupo`) values 
(11,1),
(20,5);

/*Table structure for table `na_tareas_grupos_history` */

DROP TABLE IF EXISTS `na_tareas_grupos_history`;

CREATE TABLE `na_tareas_grupos_history` (
  `id_history` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_tarea` int(11) unsigned NOT NULL DEFAULT '0',
  `id_grupo` int(11) unsigned NOT NULL DEFAULT '0',
  `date_history` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_history` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_history`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `na_tareas_grupos_history` */

insert  into `na_tareas_grupos_history`(`id_history`,`id_tarea`,`id_grupo`,`date_history`,`user_history`) values 
(1,11,1,'2014-10-30 17:06:57','admin'),
(2,11,2,'2014-10-30 17:07:54','admin');

/*Table structure for table `na_tareas_preguntas` */

DROP TABLE IF EXISTS `na_tareas_preguntas`;

CREATE TABLE `na_tareas_preguntas` (
  `id_pregunta` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_tarea` int(11) unsigned NOT NULL DEFAULT '0',
  `pregunta_texto` longtext NOT NULL,
  `pregunta_tipo` varchar(100) NOT NULL DEFAULT 'texto' COMMENT 'texto;unica;multiple',
  PRIMARY KEY (`id_pregunta`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

/*Data for the table `na_tareas_preguntas` */

insert  into `na_tareas_preguntas`(`id_pregunta`,`id_tarea`,`pregunta_texto`,`pregunta_tipo`) values 
(13,8,'¿De que color es el caballo blanco de Santiago?','texto'),
(14,8,'¿Cuantas patas tiene un pero?','unica'),
(15,9,'¿Cuantas patas tiene un pero?','unica'),
(17,9,'¿De que color es el caballo blanco de Santiago?','unica'),
(18,15,'Pregunta 1','texto'),
(21,16,'Pimera pregunta','texto'),
(20,15,'Preg 3','unica'),
(22,17,'pregunta 1','texto'),
(23,20,'Texto libre','texto'),
(24,20,'Opciones1','unica'),
(25,17,'Con opciones','unica'),
(26,17,'Con varias opciones','multiple'),
(27,21,'Una pregunta de test con correcta (OPT)','unica'),
(28,21,'Otra de check','multiple');

/*Table structure for table `na_tareas_respuestas` */

DROP TABLE IF EXISTS `na_tareas_respuestas`;

CREATE TABLE `na_tareas_respuestas` (
  `id_respuesta` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_pregunta` int(11) unsigned NOT NULL DEFAULT '0',
  `respuesta_texto` longtext NOT NULL,
  `correcta` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_respuesta`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

/*Data for the table `na_tareas_respuestas` */

insert  into `na_tareas_respuestas`(`id_respuesta`,`id_pregunta`,`respuesta_texto`,`correcta`) values 
(14,14,'Una',0),
(15,14,'Dos',0),
(16,14,'Tres',0),
(17,15,'2',0),
(18,15,'3',0),
(19,15,'4',0),
(21,17,'Azul',0),
(22,17,'Blanco',0),
(23,17,'Rojo',0),
(24,17,'Verde',0),
(25,20,'1',0),
(26,20,'2',0),
(27,20,'3',0),
(28,24,'rojo',0),
(29,24,'vwerde',0),
(30,24,'azul',0),
(31,25,'si',0),
(32,25,'no',0),
(33,26,'a lo mejor',0),
(34,26,'si',0),
(35,26,'no',0),
(36,27,'opt1',0),
(37,27,'opt2_ok',1),
(38,27,'opt3',0),
(39,28,'1_ok',1),
(40,28,'2_ok',1),
(41,28,'3_no_ok',0);

/*Table structure for table `na_tareas_respuestas_user` */

DROP TABLE IF EXISTS `na_tareas_respuestas_user`;

CREATE TABLE `na_tareas_respuestas_user` (
  `id_respuesta_user` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_pregunta` int(11) unsigned NOT NULL DEFAULT '0',
  `respuesta_user` varchar(100) NOT NULL DEFAULT '',
  `respuesta_valor` longtext NOT NULL,
  PRIMARY KEY (`id_respuesta_user`),
  KEY `id_pregunta` (`id_pregunta`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

/*Data for the table `na_tareas_respuestas_user` */

insert  into `na_tareas_respuestas_user`(`id_respuesta_user`,`id_pregunta`,`respuesta_user`,`respuesta_valor`) values 
(15,13,'admin','blanco'),
(16,14,'admin','Dos'),
(17,15,'admin','2'),
(18,17,'admin','Azul'),
(19,15,'dcancho','4'),
(20,17,'dcancho','Blanco'),
(21,21,'admin','sdasdasda sdasd222 33333'),
(22,22,'admin','sdfsdfsdf'),
(23,23,'admin','kdfnlndknvd nbjbk '),
(24,24,'admin','rojo'),
(25,25,'admin','si'),
(26,26,'admin','a lo mejor|si|no'),
(27,27,'admin','opt2_ok'),
(28,28,'admin','2_ok|3_no_ok'),
(29,27,'pedro','opt2_ok'),
(30,28,'pedro','1_ok|2_ok'),
(31,27,'borja','opt1'),
(32,28,'borja','1_ok');

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `na_tareas_users` */

insert  into `na_tareas_users`(`id_tarea_user`,`id_area`,`id_tarea`,`user_tarea`,`file_tarea`,`fecha_tarea`,`revision`,`user_revision`,`date_revision`) values 
(1,9,10,'admin','1413273083_postal5_quijote.jpeg','2014-10-14 09:51:23',0,'',NULL),
(2,9,10,'admin','1418728595_logotipo_dia.jpg','2014-12-16 12:16:35',0,'',NULL);

/*Table structure for table `novedades` */

DROP TABLE IF EXISTS `novedades`;

CREATE TABLE `novedades` (
  `id_novedad` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(250) NOT NULL DEFAULT '',
  `cuerpo` longtext NOT NULL,
  `activo` int(1) unsigned NOT NULL DEFAULT '1',
  `canal` varchar(100) NOT NULL DEFAULT '',
  `date_novedad` datetime NOT NULL,
  `perfil` varchar(100) NOT NULL DEFAULT '',
  `tipo` varchar(50) NOT NULL DEFAULT 'slider' COMMENT 'posibles valores: slider; popup; banner',
  `orden` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_novedad`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `novedades` */

insert  into `novedades`(`id_novedad`,`titulo`,`cuerpo`,`activo`,`canal`,`date_novedad`,`perfil`,`tipo`,`orden`) values 
(1,'Entra en level Up!','<p class=\"inset\"><img alt=\"\" src=\"https://comunidad.local.com/images/mailing/images/tema2.png\" style=\"float:left; height:90px; margin:10px; width:120px\" />Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin semper, nunc ut cursus sagittis, urna sem venenatis odio, sit amet congue lorem augue feugiat lacus. Aenean ac blandit orci, eget vestibulum odio. Phasellus velit ipsum, ultricies quis semper in, luctus ut magna. Maecenas ultricies malesuada ipsum, eget tincidunt ante semper a.</p>\r\n\r\n<p class=\"inset\">Haz click <a href=\"https://comunidad.local.com/pagename?id=reto\">aqu&iacute;</a> para entrar <a href=\"https://comunidad.local.com/pagename?id=nueva\">fdgdfg</a>xxx xxx</p>\r\n',0,'comercial','2016-06-14 15:15:07','','slider',0),
(2,'iPhone de regalo','<img alt=\"\" src=\"https://comunidad.local.com/images/mailing/images/1401100614_0002_mp4_mp4.jpg\" style=\"width: 100%;\" />\r\n',1,'gerente','2016-05-11 11:26:40','','slider',0),
(4,'Bienvenida','<p><img alt=\"\" src=\"https://comunidad.local.com/images/mailing/images/1446307533_20151031_170306.jpg\" style=\"width: 100%;\" /></p>\r\n',1,'comercial,gerente,test','2016-12-19 09:44:47','','popup',0),
(5,'Banner 01','<img alt=\"\" src=\"https://comunidad.local.com/images/mailing/images/design-busting-mistakes.jpg\" style=\"width: 100%;\" />\r\n',1,'gerente','2016-05-11 11:25:38','','slider',0),
(6,'Un banner para todos','<img alt=\"\" src=\"https://comunidad.local.com/images/mailing/images/tema2.png\" style=\"width: 100%;\" />',1,'comercial,gerente,test','2016-12-19 09:20:50','','banner',1),
(7,'Otro banner','<img alt=\"\" src=\"https://comunidad.local.com/images/mailing/images/289793-1442342151(1).png\" style=\"width: 100%;\" />\r\n',1,'comercial','2016-12-19 09:20:28','responsable','banner',2);

/*Table structure for table `pages` */

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `page_name` varchar(100) NOT NULL,
  `page_title` varchar(250) NOT NULL DEFAULT '',
  `page_content` longtext,
  `page_menu` tinyint(1) NOT NULL DEFAULT '0',
  `page_order` tinyint(2) NOT NULL DEFAULT '0',
  `page_canal` varchar(100) NOT NULL DEFAULT '',
  `page_user_menu` tinyint(1) NOT NULL DEFAULT '0',
  `page_user_menu_order` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`page_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `pages` */

insert  into `pages`(`page_name`,`page_title`,`page_content`,`page_menu`,`page_order`,`page_canal`,`page_user_menu`,`page_user_menu_order`) values 
('declaracion','','<h2>Declaraci&oacute;n de derechos y responsabilidades</h2>\r\n	Esta Declaraci&oacute;n de derechos y responsabilidades rige nuestra relaci&oacute;n con los usuarios y con todos aquellos que interact&uacute;an en www.actytukiabi.com. Al utilizar o acceder a www.actytukiabi.com muestras tu conformidad con la presente Declaraci&oacute;n.<br />\r\n	<br />\r\n	1. Privacidad<br />\r\n	Tu privacidad es muy importante para nosotros. Hemos dise&ntilde;ado nuestra Pol&iacute;tica de Privacidad para ayudarte a comprender c&oacute;mo puedes usar comunidadsiempremas.com para compartir informaci&oacute;n con otras personas y c&oacute;mo recopilamos y usamos tu informaci&oacute;n. Te animamos a que leas nuestra Pol&iacute;tica de privacidad y a que la utilices para poder tomar decisiones fundamentadas.<br />\r\n	<br />\r\n	2. Compartir el contenido y la informaci&oacute;n<br />\r\n	Eres el propietario de todo el contenido y la informaci&oacute;n que publicas en www.actitukiabi.com. Adem&aacute;s:<br />\r\n	<br />\r\n	1. Para el contenido protegido por derechos de propiedad intelectual, como fotograf&iacute;as y v&iacute;deos (en adelante, &quot;contenido de PI&quot;), nos concedes espec&iacute;ficamente el siguiente permiso: nos concedes una licencia no exclusiva, transferible, con posibilidad de ser sub-otorgada, sin royalties, aplicable globalmente, para utilizar cualquier contenido de PI que publiques en www.actitukiabi.com<br />\r\n	<br />\r\n	2. Cuando eliminas contenido de PI, &eacute;ste es borrado de forma similar a cuando vac&iacute;as la papelera o papelera de reciclaje de tu equipo inform&aacute;tico. No obstante, entiendes que es posible que el contenido eliminado permanezca en copias de seguridad durante un plazo de tiempo razonable (si bien no estar&aacute; disponible para terceros).<br />\r\n	<br />\r\n	3. Siempre valoramos tus comentarios o sugerencias acerca de www.actitukiabi.com, pero debes entender que podr&iacute;amos utilizarlos sin obligaci&oacute;n de compensarte por ello (del mismo modo que t&uacute; no tienes obligaci&oacute;n de ofrecerlos).<br />\r\n	<br />\r\n	3. Seguridad<br />\r\n	Hacemos todo lo posible para hacer que www.actitukiabi.comsea un sitio seguro, pero no podemos garantizarlo. Necesitamos tu ayuda para lograrlo, lo que implica los siguientes compromisos:<br />\r\n	<br />\r\n	1. No enviar&aacute;s ni publicar&aacute;s de ning&uacute;n otro modo comunicaciones comerciales no autorizadas (como correo no deseado) en www.actitukiabi.com<br />\r\n	<br />\r\n	2. No participar&aacute;s en marketing multinivel ilegal, como el de tipo piramidal, en www.actitukiabi.com.<br />\r\n	<br />\r\n	3. No cargar&aacute;s virus ni c&oacute;digo malintencionado de ning&uacute;n tipo.<br />\r\n	<br />\r\n	4. No solicitar&aacute;s informaci&oacute;n de inicio de sesi&oacute;n ni acceder&aacute;s a una cuenta perteneciente a otro usuario.<br />\r\n	<br />\r\n	5. No molestar&aacute;s, intimidar&aacute;s ni acosar&aacute;s a ning&uacute;n usuario.<br />\r\n	<br />\r\n	6. No publicar&aacute;s contenido que resulte hiriente, intimidatorio o pornogr&aacute;fico, que incite a la violencia o que contenga desnudos o violencia gr&aacute;fica o injustificada.<br />\r\n	<br />\r\n	7. No ofrecer&aacute;s ning&uacute;n concurso, regalo ni apuesta (colectivamente, &quot;promoci&oacute;n&quot;) sin nuestro consentimiento previo por escrito. Si damos nuestro consentimiento, tendr&aacute;s completa responsabilidad de la promoci&oacute;n y seguir&aacute;s nuestras normas de las promociones y cumplir&aacute;s todas las leyes aplicables.<br />\r\n	<br />\r\n	8. No utilizar&aacute;s www.actitukiabi.compara actos il&iacute;citos, enga&ntilde;osos, malintencionados o discriminatorios.<br />\r\n	<br />\r\n	9. No realizar&aacute;s ninguna acci&oacute;n que pudiera inhabilitar, sobrecargar o afectar al funcionamiento correcto de www.actytukiabi.com, como, por ejemplo, un ataque de denegaci&oacute;n de servicio.<br />\r\n	<br />\r\n	10. No facilitar&aacute;s ni fomentar&aacute;s la violaci&oacute;n de esta Declaraci&oacute;n.<br />\r\n	<br />\r\n	11. No compartir&aacute;s la contrase&ntilde;a, no dejar&aacute;s que otra persona acceda a tu cuenta, ni har&aacute;s cualquier cosa que pueda poner en peligro la seguridad de tu cuenta.<br />\r\n	<br />\r\n	12. No transferir&aacute;s la cuenta (incluida cualquier p&aacute;gina o aplicaci&oacute;n que administres) a nadie sin nuestro consentimiento previo por escrito.<br />\r\n	<br />\r\n	13. Si seleccionas un nombre de usuario para tu cuenta, nos reservamos el derecho a eliminarlo o reclamarlo si lo consideramos oportuno.<br />\r\n	<br />\r\n	4. Protecci&oacute;n de los derechos de otras personas<br />\r\n	Respetamos los derechos de otras personas y esperamos que t&uacute; hagas lo mismo.<br />\r\n	<br />\r\n	1. No publicar&aacute;s contenido ni realizar&aacute;s ninguna acci&oacute;n en www.actytukiabi.com que infrinja o viole los derechos de otros o que viole la ley de alg&uacute;n modo.<br />\r\n	<br />\r\n	2. Podemos retirar cualquier contenido o informaci&oacute;n que publiques en www.actytukiabi.com si consideramos que viola esta Declaraci&oacute;n.<br />\r\n	<br />\r\n	3. Si infringes repetidamente los derechos de propiedad intelectual de otra persona, desactivaremos tu cuenta si es oportuno.<br />\r\n	<br />\r\n	4. No utilizar&aacute;s nuestros copyrights o marcas registradas (incluidos Kiabi, los logotipos de Kiabi) ni ninguna marca que se parezca a las nuestras sin nuestro permiso por escrito.<br />\r\n	<br />\r\n	5. No publicar&aacute;s los documentos de identificaci&oacute;n ni informaci&oacute;n financiera de nadie en www.actytukiabi.com<br />\r\n	<br />\r\n	Si seleccionas un nombre de usuario para tu cuenta, nos reservamos el derecho a eliminarlo o reclamarlo si lo consideramos oportuno (por ejemplo, si el propietario de una marca comercial se queja por un nombre de usuario que no est&aacute; relacionado estrechamente con el nombre real del usuario).<br />\r\n	<br />\r\n	5. Definiciones<br />\r\n	1. El t&eacute;rmino &quot;actytu&quot; se refiere a las funciones y servicios que proporcionamos, incluidos los que se ofrecen a trav&eacute;s de (a) nuestro sitio web en www.actytukiabi.com y versiones m&oacute;viles; (b) nuestra Plataforma; (c) plugins sociales, como el bot&oacute;n &quot;Me gusta&quot;,.<br />\r\n	<br />\r\n	2. El t&eacute;rmino &quot;Plataforma&quot; se refiere al conjunto de API y servicios que permiten que otras personas, incluidos los desarrolladores de aplicaciones y los operadores de sitios web, recuperen datos de actytu o nos los proporcionen a nosotros.<br />\r\n	<br />\r\n	3. El t&eacute;rmino &quot;informaci&oacute;n&quot; se refiere a los hechos y otra informaci&oacute;n sobre ti, incluidas las acciones que realizas.<br />\r\n	<br />\r\n	4. El t&eacute;rmino &quot;contenido&quot; se refiere a todo lo que publicas en www.actytukiabi.com que no se incluye en la definici&oacute;n de &quot;informaci&oacute;n&quot;.<br />\r\n	<br />\r\n	5. El t&eacute;rmino &quot;datos&quot; se refiere al contenido y la informaci&oacute;n que pueden recuperar terceros de www.actytukiabi.com o proporcionan a actytu a trav&eacute;s de la plataforma.<br />\r\n	<br />\r\n	6. El t&eacute;rmino &quot;publicar&quot; significa publicar en www.actytukiabi.com.<br />\r\n	<br />\r\n	7. Por &quot;usar&quot; se entiende utilizar, copiar, reproducir o mostrar p&uacute;blicamente, distribuir, modificar, traducir y crear obras derivadas.\r\n',0,0,'',0,0),
('manifest','','<h2>\r\n	T&eacute;rminos y condiciones</h2>\r\nEsta Declaraci&oacute;n de derechos y responsabilidades rige nuestra relaci&oacute;n con los usuarios y con todos aquellos que interact&uacute;an en www.actytukiabi.com. Al utilizar o acceder a www.actytukiabi.com muestras tu conformidad con la presente Declaraci&oacute;n.<br />\r\n<br />\r\n1. Privacidad<br />\r\nTu privacidad es muy importante para nosotros. Hemos dise&ntilde;ado nuestra Pol&iacute;tica de Privacidad para ayudarte a comprender c&oacute;mo puedes usar comunidadsiempremas.com para compartir informaci&oacute;n con otras personas y c&oacute;mo recopilamos y usamos tu informaci&oacute;n. Te animamos a que leas nuestra Pol&iacute;tica de privacidad y a que la utilices para poder tomar decisiones fundamentadas.<br />\r\n<br />\r\n2. Compartir el contenido y la informaci&oacute;n<br />\r\nEres el propietario de todo el contenido y la informaci&oacute;n que publicas en www.actitukiabi.com. Adem&aacute;s:<br />\r\n<br />\r\n1. Para el contenido protegido por derechos de propiedad intelectual, como fotograf&iacute;as y v&iacute;deos (en adelante, &quot;contenido de PI&quot;), nos concedes espec&iacute;ficamente el siguiente permiso: nos concedes una licencia no exclusiva, transferible, con posibilidad de ser sub-otorgada, sin royalties, aplicable globalmente, para utilizar cualquier contenido de PI que publiques en www.actitukiabi.com<br />\r\n<br />\r\n2. Cuando eliminas contenido de PI, &eacute;ste es borrado de forma similar a cuando vac&iacute;as la papelera o papelera de reciclaje de tu equipo inform&aacute;tico. No obstante, entiendes que es posible que el contenido eliminado permanezca en copias de seguridad durante un plazo de tiempo razonable (si bien no estar&aacute; disponible para terceros).<br />\r\n<br />\r\n3. Siempre valoramos tus comentarios o sugerencias acerca de www.actitukiabi.com, pero debes entender que podr&iacute;amos utilizarlos sin obligaci&oacute;n de compensarte por ello (del mismo modo que t&uacute; no tienes obligaci&oacute;n de ofrecerlos).<br />\r\n<br />\r\n3. Seguridad<br />\r\nHacemos todo lo posible para hacer que www.actitukiabi.comsea un sitio seguro, pero no podemos garantizarlo. Necesitamos tu ayuda para lograrlo, lo que implica los siguientes compromisos:<br />\r\n<br />\r\n1. No enviar&aacute;s ni publicar&aacute;s de ning&uacute;n otro modo comunicaciones comerciales no autorizadas (como correo no deseado) en www.actitukiabi.com<br />\r\n<br />\r\n2. No participar&aacute;s en marketing multinivel ilegal, como el de tipo piramidal, en www.actitukiabi.com.<br />\r\n<br />\r\n3. No cargar&aacute;s virus ni c&oacute;digo malintencionado de ning&uacute;n tipo.<br />\r\n<br />\r\n4. No solicitar&aacute;s informaci&oacute;n de inicio de sesi&oacute;n ni acceder&aacute;s a una cuenta perteneciente a otro usuario.<br />\r\n<br />\r\n5. No molestar&aacute;s, intimidar&aacute;s ni acosar&aacute;s a ning&uacute;n usuario.<br />\r\n<br />\r\n6. No publicar&aacute;s contenido que resulte hiriente, intimidatorio o pornogr&aacute;fico, que incite a la violencia o que contenga desnudos o violencia gr&aacute;fica o injustificada.<br />\r\n<br />\r\n7. No ofrecer&aacute;s ning&uacute;n concurso, regalo ni apuesta (colectivamente, &quot;promoci&oacute;n&quot;) sin nuestro consentimiento previo por escrito. Si damos nuestro consentimiento, tendr&aacute;s completa responsabilidad de la promoci&oacute;n y seguir&aacute;s nuestras normas de las promociones y cumplir&aacute;s todas las leyes aplicables.<br />\r\n<br />\r\n8. No utilizar&aacute;s www.actitukiabi.compara actos il&iacute;citos, enga&ntilde;osos, malintencionados o discriminatorios.<br />\r\n<br />\r\n9. No realizar&aacute;s ninguna acci&oacute;n que pudiera inhabilitar, sobrecargar o afectar al funcionamiento correcto de www.actytukiabi.com, como, por ejemplo, un ataque de denegaci&oacute;n de servicio.<br />\r\n<br />\r\n10. No facilitar&aacute;s ni fomentar&aacute;s la violaci&oacute;n de esta Declaraci&oacute;n.<br />\r\n<br />\r\n11. No compartir&aacute;s la contrase&ntilde;a, no dejar&aacute;s que otra persona acceda a tu cuenta, ni har&aacute;s cualquier cosa que pueda poner en peligro la seguridad de tu cuenta.<br />\r\n<br />\r\n12. No transferir&aacute;s la cuenta (incluida cualquier p&aacute;gina o aplicaci&oacute;n que administres) a nadie sin nuestro consentimiento previo por escrito.<br />\r\n<br />\r\n13. Si seleccionas un nombre de usuario para tu cuenta, nos reservamos el derecho a eliminarlo o reclamarlo si lo consideramos oportuno.<br />\r\n<br />\r\n4. Protecci&oacute;n de los derechos de otras personas<br />\r\nRespetamos los derechos de otras personas y esperamos que t&uacute; hagas lo mismo.<br />\r\n<br />\r\n1. No publicar&aacute;s contenido ni realizar&aacute;s ninguna acci&oacute;n en www.actytukiabi.com que infrinja o viole los derechos de otros o que viole la ley de alg&uacute;n modo.<br />\r\n<br />\r\n2. Podemos retirar cualquier contenido o informaci&oacute;n que publiques en www.actytukiabi.com si consideramos que viola esta Declaraci&oacute;n.<br />\r\n<br />\r\n3. Si infringes repetidamente los derechos de propiedad intelectual de otra persona, desactivaremos tu cuenta si es oportuno.<br />\r\n<br />\r\n4. No utilizar&aacute;s nuestros copyrights o marcas registradas (incluidos Kiabi, los logotipos de Kiabi) ni ninguna marca que se parezca a las nuestras sin nuestro permiso por escrito.<br />\r\n<br />\r\n5. No publicar&aacute;s los documentos de identificaci&oacute;n ni informaci&oacute;n financiera de nadie en www.actytukiabi.com<br />\r\n<br />\r\nSi seleccionas un nombre de usuario para tu cuenta, nos reservamos el derecho a eliminarlo o reclamarlo si lo consideramos oportuno (por ejemplo, si el propietario de una marca comercial se queja por un nombre de usuario que no est&aacute; relacionado estrechamente con el nombre real del usuario).<br />\r\n<br />\r\n5. Definiciones<br />\r\n1. El t&eacute;rmino &quot;actytu&quot; se refiere a las funciones y servicios que proporcionamos, incluidos los que se ofrecen a trav&eacute;s de (a) nuestro sitio web en www.actytukiabi.com y versiones m&oacute;viles; (b) nuestra Plataforma; (c) plugins sociales, como el bot&oacute;n &quot;Me gusta&quot;,.<br />\r\n<br />\r\n2. El t&eacute;rmino &quot;Plataforma&quot; se refiere al conjunto de API y servicios que permiten que otras personas, incluidos los desarrolladores de aplicaciones y los operadores de sitios web, recuperen datos de actytu o nos los proporcionen a nosotros.<br />\r\n<br />\r\n3. El t&eacute;rmino &quot;informaci&oacute;n&quot; se refiere a los hechos y otra informaci&oacute;n sobre ti, incluidas las acciones que realizas.<br />\r\n<br />\r\n4. El t&eacute;rmino &quot;contenido&quot; se refiere a todo lo que publicas en www.actytukiabi.com que no se incluye en la definici&oacute;n de &quot;informaci&oacute;n&quot;.<br />\r\n<br />\r\n5. El t&eacute;rmino &quot;datos&quot; se refiere al contenido y la informaci&oacute;n que pueden recuperar terceros de www.actytukiabi.com o proporcionan a actytu a trav&eacute;s de la plataforma.<br />\r\n<br />\r\n6. El t&eacute;rmino &quot;publicar&quot; significa publicar en www.actytukiabi.com.<br />\r\n<br />\r\n7. Por &quot;usar&quot; se entiende utilizar, copiar, reproducir o mostrar p&uacute;blicamente, distribuir, modificar, traducir y crear obras derivadas. ',0,0,'',0,0),
('policy','','<h2>\r\n	Pol&iacute;tica de privacidad</h2>\r\n1. Introducci&oacute;n<br />\r\nPreguntas. Si tienes alguna pregunta o duda sobre nuestra pol&iacute;tica de privacidad, ponte en contacto con nuestro equipo de privacidad enviando un mail a Info@actytukiabi.com<br />\r\n<br />\r\n&Aacute;mbito. La presente pol&iacute;tica de privacidad incluye el portal www.actytukiabi.com al completo.<br />\r\n<br />\r\n2. Informaci&oacute;n que recibimos<br />\r\nInformaci&oacute;n que nos env&iacute;as:<br />\r\n<br />\r\nInformaci&oacute;n sobre ti. Cuando te registras en la comunidad de Kiabi, nos facilitas tu nombre, correo electr&oacute;nico y fecha de nacimiento. Tambi&eacute;n podr&aacute;s a&ntilde;adir una foto.<br />\r\n<br />\r\nLos datos personales recabados en el presente formulario ser&aacute;n objeto de tratamiento en un fichero responsabilidad de Espa&ntilde;a KSCE, S.A. cuya finalidad ser&aacute; la gesti&oacute;n de cursos de formaci&oacute;n y eventos que puedan resultar de su inter&eacute;s y el intercambio de informaci&oacute;n de car&aacute;cter profesional. La entrega de todos los datos requeridos en el presente formulario es obligatoria, puesto que dichos datos son imprescindibles para cumplir con las finalidades indicadas anteriormente.<br />\r\n<br />\r\nUsted podr&aacute; ejercitar sus derechos de acceso, rectificaci&oacute;n, cancelaci&oacute;n y/u oposici&oacute;n, dirigiendo una comunicaci&oacute;n firmada por el titular de los datos a la direcci&oacute;n de correo electr&oacute;nico info@actytukiabi.com, ref. &quot;Actytu&quot;, adjuntando copia legible de su DNI e indicando la petici&oacute;n en que se concreta su solicitud y la direcci&oacute;n a la que Espa&ntilde;a KSCE, S.A pueda remitirle la confirmaci&oacute;n de haber cumplido con su solicitud, o en su caso, los motivos que le impiden llevarla a cabo plenamente.<br />\r\n<br />\r\nContenido. Una de las finalidades principales del uso de la comunidad actytu es compartir contenido referente al cambio de actitud ante el cliente, con los dem&aacute;s comerciales.<br />\r\n<br />\r\nInformaci&oacute;n que recopilamos cuando interact&uacute;as en actytu:<br />\r\n<br />\r\nInformaci&oacute;n sobre la actividad en el sitio web. Realizamos un seguimiento de las acciones que llevas a cabo en actytu como indicar que &quot;te gusta&quot; una publicaci&oacute;n, o cuando compartes videos, fotos o comentarios en cada una de las secciones del portal.<br />\r\n<br />\r\n3. Compartir informaci&oacute;n en actytu<br />\r\nNombre y foto del perfil. Ha sido dise&ntilde;ado para que te resulte sencillo encontrar y modificar los campos de nick, foto o estado. Si no quieres compartir la foto de tu perfil, debes eliminarla (o no a&ntilde;adir ninguna).<br />\r\n<br />\r\n4. C&oacute;mo utilizamos tu informaci&oacute;n<br />\r\nUtilizamos la informaci&oacute;n que recopilamos para tratar de ofrecerte una experiencia segura, eficaz y personalizada. A continuaci&oacute;n, incluimos algunos datos sobre c&oacute;mo lo hacemos:<br />\r\n<br />\r\nPara gestionar el servicio. Utilizamos la informaci&oacute;n que recopilamos para ofrecerte nuestros servicios y funciones, evaluarlos y mejorarlos y prestarte servicio t&eacute;cnico. Empleamos la informaci&oacute;n para impedir actividades que podr&iacute;an ser ilegales y para aplicar nuestra Declaraci&oacute;n de Derechos y Responsabilidades. Estos esfuerzos pueden provocar, en ocasiones, el fin o la suspensi&oacute;n temporal o permanente de algunas funciones para algunos usuarios.<br />\r\n<br />\r\nPara ponernos en contacto contigo. Ocasionalmente, podemos ponernos en contacto contigo para informarte de anuncios relativos a servicios.<br />\r\n<br />\r\n6. C&oacute;mo puedes cambiar eliminar informaci&oacute;n<br />\r\nEdici&oacute;n de tu perfil. Puedes cambiar o eliminar la informaci&oacute;n de tu perfil en cualquier momento yendo a tu perfil y haciendo clic en &quot;Editar mi perfil&quot;. La informaci&oacute;n se actualizar&aacute; de inmediato.<br />\r\n<br />\r\n7. C&oacute;mo protegemos la informaci&oacute;n<br />\r\nHacemos todo lo posible para mantener a salvo tu informaci&oacute;n, pero necesitamos tu ayuda.<br />\r\n<br />\r\nMedidas que tomamos para mantener a salvo su informaci&oacute;n. Mantenemos la informaci&oacute;n de tu cuenta en un servidor protegido con un firewall. Cuando introduces informaci&oacute;n confidencial (por ejemplo, contrase&ntilde;as). Tambi&eacute;n utilizamos medidas sociales y automatizadas para aumentar la seguridad (como el an&aacute;lisis de la actividad de la cuenta), podemos limitar el uso de funciones del sitio web en respuesta a posibles signos de abuso, podemos eliminar contenido inadecuado o enlaces a contenido ilegal, y podemos suspender o desactivar cuentas por si hubiera violaciones de nuestra Declaraci&oacute;n de Derechos y Responsabilidades.<br />\r\n<br />\r\nRiesgos inherentes a compartir informaci&oacute;n. Aunque te permitimos definir opciones de privacidad que limiten el acceso a tu informaci&oacute;n, ten en cuenta que ninguna medida de seguridad es perfecta ni impenetrable. No podemos controlar las acciones de otros usuarios con los que compartas informaci&oacute;n. No podemos garantizar que s&oacute;lo vean tu informaci&oacute;n personas autorizadas. No podemos garantizar que la informaci&oacute;n que compartas en comunidadsiempremas.com no pase a estar disponible p&uacute;blicamente. No somos responsables de que ning&uacute;n tercero burle cualquier configuraci&oacute;n de la privacidad o medidas de seguridad en www.actytukiabi.com. Puedes reducir estos riesgos utilizando h&aacute;bitos de seguridad de sentido com&uacute;n como elegir una contrase&ntilde;a segura, utilizar contrase&ntilde;as diferentes para servicios diferentes y emplear software antivirus actualizado.<br />\r\n<br />\r\nInformar de incumplimientos. Deber&iacute;as informarnos de cualquier incumplimiento de la seguridad escribi&eacute;ndonos a info@actytukiabi.com<br />\r\n<br />\r\n9. Otras condiciones<br />\r\nCambios. Podemos cambiar esta Pol&iacute;tica de privacidad conforme a los procedimientos se&ntilde;alados en la Declaraci&oacute;n de Derechos y Responsabilidades. Salvo indicaci&oacute;n en contrario, nuestra pol&iacute;tica de privacidad en vigor se aplica a toda la informaci&oacute;n que tenemos sobre ti y tu cuenta. Si realizamos cambios en esta Pol&iacute;tica de privacidad, te lo notificaremos public&aacute;ndolo aqu&iacute; y en la p&aacute;gina www.actytukiabi.com. Si los cambios son sustanciales, mostraremos un aviso prominente si las circunstancias lo requieren. ',0,0,'',0,0),
('nueva','+INFO','<h2>T&iacute;tulo de la nueva p&aacute;gina</h2>\r\n\r\n<p>la nueva p&aacute;gina 2 y con un poco m&aacute;s de texto de relleno.<br />\r\n&nbsp;</p>\r\n\r\n<ul>\r\n	<li>Opci&oacute;n 1 de la lista</li>\r\n	<li>La opci&oacute;n 2 de la lista</li>\r\n	<li>Una tercera opci&oacute;n para la lista de la p&aacute;gina</li>\r\n</ul>\r\n\r\n<p>Un poco m&aacute;s de texto para continuar un nuevo parrafo en la p&aacute;gina.</p>\r\n',1,0,'',1,0),
('reto','','<p style=\"text-align: justify; margin: 0px 0px 14px; padding: 0px; color: rgb(0, 0, 0); font-family: Arial, Helvetica, sans;\">\r\n	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam tempus ultrices auctor. Nunc a arcu nisl. Sed ullamcorper varius mi facilisis facilisis. Duis porta venenatis erat, eu malesuada lorem ultrices quis. Duis quam mi, vulputate sit amet ultrices eget, aliquam in felis. Nulla ut efficitur urna. Donec posuere, libero sed fermentum volutpat, nisl ante egestas sapien, non commodo metus felis sed libero.</p>\r\n<p style=\"text-align: justify; margin: 0px 0px 14px; padding: 0px; color: rgb(0, 0, 0); font-family: Arial, Helvetica, sans;\">\r\n	Vivamus ac metus eget nisi posuere ullamcorper. Proin laoreet elit vel arcu placerat gravida. Curabitur facilisis dui tortor, finibus tincidunt erat ullamcorper in. Maecenas vehicula enim a mattis vulputate. Nulla vel urna metus. Pellentesque vitae velit ipsum. Aenean nec erat velit. Aliquam sed turpis metus. Nullam a nisl sit amet felis aliquam interdum ut eu magna. Morbi condimentum ut felis aliquam faucibus. Nulla ac mi lectus. Mauris ut hendrerit massa. Donec laoreet sit amet sapien quis luctus. Sed fringilla sem non efficitur facilisis. Suspendisse mollis dui eu urna varius, et semper quam imperdiet. In interdum feugiat nisl, in ullamcorper lectus porta imperdiet.<br />\r\n	<br />\r\n	<a href=\"http://google.com\">http://google.com</a></p>\r\n',0,0,'',0,0);

/*Table structure for table `promociones` */

DROP TABLE IF EXISTS `promociones`;

CREATE TABLE `promociones` (
  `id_promocion` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre_promocion` varchar(250) NOT NULL DEFAULT '',
  `texto_promocion` longtext NOT NULL,
  `imagen_promocion` varchar(250) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `galeria_videos` tinyint(1) NOT NULL DEFAULT '0',
  `galeria_fotos` tinyint(1) NOT NULL DEFAULT '0',
  `galeria_comentarios` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_promocion`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

/*Data for the table `promociones` */

insert  into `promociones`(`id_promocion`,`nombre_promocion`,`texto_promocion`,`imagen_promocion`,`active`,`galeria_videos`,`galeria_fotos`,`galeria_comentarios`) values 
(47,'Nombre 1','desc1','',0,0,0,1),
(48,'Nombre 2rrr','<p>desc2 ert ertertert 333</p>\r\n','',1,0,1,0);

/*Table structure for table `recompensas` */

DROP TABLE IF EXISTS `recompensas`;

CREATE TABLE `recompensas` (
  `id_recompensa` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `recompensa_name` varchar(250) NOT NULL DEFAULT '',
  `recompensa_image` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_recompensa`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `recompensas` */

insert  into `recompensas`(`id_recompensa`,`recompensa_name`,`recompensa_image`) values 
(1,'Participativo','1454419938_medalla_01.png'),
(2,'Resolutivo','1454420160_medalla_03.png'),
(3,'Asiduo','1454420050_medalla_02.png'),
(4,'Positivo','1454420149_medalla_04.png');

/*Table structure for table `recompensas_user` */

DROP TABLE IF EXISTS `recompensas_user`;

CREATE TABLE `recompensas_user` (
  `id_recompensas_user` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_recompensa` int(11) unsigned NOT NULL,
  `recompensa_user` varchar(250) NOT NULL DEFAULT '' COMMENT 'usuario al que le dan la recompensa',
  `recompensa_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `recompensa_assign` varchar(250) NOT NULL COMMENT 'usuario que da la recompensa',
  `recompensa_comment` text NOT NULL,
  PRIMARY KEY (`id_recompensas_user`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

/*Data for the table `recompensas_user` */

insert  into `recompensas_user`(`id_recompensas_user`,`id_recompensa`,`recompensa_user`,`recompensa_date`,`recompensa_assign`,`recompensa_comment`) values 
(13,2,'borja','2015-11-16 16:25:06','admin',''),
(11,3,'borja','2015-11-16 16:23:25','admin',''),
(4,1,'pedro','2015-11-16 12:50:46','admin',''),
(5,3,'claudio','2015-11-16 12:50:56','admin',''),
(6,2,'admin','2015-11-16 13:19:09','admin',''),
(17,3,'20266370N','2016-02-02 13:20:30','admin',''),
(8,3,'admin','2015-11-16 13:45:48','admin',''),
(14,2,'borja','2015-11-16 16:25:32','admin',''),
(15,1,'borja','2015-11-17 08:48:28','admin',''),
(18,1,'20266370N','2016-02-02 13:20:39','admin',''),
(19,1,'borja','2016-02-02 14:54:30','admin',''),
(20,4,'borja','2016-02-02 14:54:42','admin',''),
(21,1,'claudio','2016-02-02 16:12:16','admin','Por participar mucho'),
(22,1,'admin','2016-02-02 17:06:01','admin','Finalizacion tarea ID: 16'),
(23,3,'admin','2016-02-02 17:08:46','admin','Finalizacion tarea ID: 17'),
(24,1,'admin','2016-09-30 12:54:08','admin','Finalizacion tarea ID: 16');

/*Table structure for table `shop_manufacturers` */

DROP TABLE IF EXISTS `shop_manufacturers`;

CREATE TABLE `shop_manufacturers` (
  `id_manufacturer` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name_manufacturer` varchar(250) NOT NULL DEFAULT '',
  `notes_manufacturer` text NOT NULL,
  `active_manufacturer` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1: activo; 2: inactivo',
  PRIMARY KEY (`id_manufacturer`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `shop_manufacturers` */

insert  into `shop_manufacturers`(`id_manufacturer`,`name_manufacturer`,`notes_manufacturer`,`active_manufacturer`) values 
(1,'Apple','Notas de fabs',1),
(2,'Cinesa','',1),
(3,'Samsung','',1),
(4,'Crocs','',1),
(5,'Adidas','',1);

/*Table structure for table `shop_orders` */

DROP TABLE IF EXISTS `shop_orders`;

CREATE TABLE `shop_orders` (
  `id_order` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username_order` varchar(100) NOT NULL DEFAULT '',
  `date_order` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name_order` varchar(250) NOT NULL DEFAULT '',
  `surname_order` varchar(250) NOT NULL DEFAULT '',
  `address_order` varchar(250) NOT NULL DEFAULT '',
  `address2_order` varchar(250) NOT NULL DEFAULT '',
  `city_order` varchar(100) NOT NULL DEFAULT '',
  `state_order` varchar(100) NOT NULL DEFAULT '',
  `postal_order` varchar(50) NOT NULL DEFAULT '',
  `telephone_order` varchar(15) NOT NULL DEFAULT '',
  `status_order` varchar(50) NOT NULL DEFAULT 'pendiente',
  `notes_order` text NOT NULL,
  PRIMARY KEY (`id_order`),
  KEY `username_order` (`username_order`),
  KEY `status_order` (`status_order`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

/*Data for the table `shop_orders` */

insert  into `shop_orders`(`id_order`,`username_order`,`date_order`,`name_order`,`surname_order`,`address_order`,`address2_order`,`city_order`,`state_order`,`postal_order`,`telephone_order`,`status_order`,`notes_order`) values 
(27,'admin','2016-04-11 12:22:01','Administrador','Community','CENTRAL','Av. Los Arces 234','Madrid','Madrid','28003','444','cancelado',''),
(28,'admin','2016-12-15 17:30:28','Administrador','Community','CENTRAL','Av. Los Arces 234','Madrid','Madrid','28003','666666666','pendiente','pruebaaaa');

/*Table structure for table `shop_orders_details` */

DROP TABLE IF EXISTS `shop_orders_details`;

CREATE TABLE `shop_orders_details` (
  `id_order_detail` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_order` int(11) NOT NULL DEFAULT '0',
  `id_product` int(11) NOT NULL DEFAULT '0',
  `amount_product` int(11) NOT NULL DEFAULT '0',
  `price_product` double NOT NULL DEFAULT '0',
  `date_detail` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_order_detail`),
  KEY `id_order` (`id_order`),
  KEY `id_product` (`id_product`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

/*Data for the table `shop_orders_details` */

insert  into `shop_orders_details`(`id_order_detail`,`id_order`,`id_product`,`amount_product`,`price_product`,`date_detail`) values 
(26,27,6,1,180,'2016-04-11 12:22:01'),
(27,28,6,1,180,'2016-12-15 17:30:28');

/*Table structure for table `shop_orders_status` */

DROP TABLE IF EXISTS `shop_orders_status`;

CREATE TABLE `shop_orders_status` (
  `id_order_status` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_order` int(11) NOT NULL DEFAULT '0',
  `order_status` varchar(50) NOT NULL DEFAULT '',
  `date_status` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username_status` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_order_status`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

/*Data for the table `shop_orders_status` */

insert  into `shop_orders_status`(`id_order_status`,`id_order`,`order_status`,`date_status`,`username_status`) values 
(5,27,'pendiente','2016-04-11 12:22:01','admin'),
(6,27,'finalizado','2016-08-12 08:44:08','admin'),
(7,27,'pendiente','2016-08-12 08:44:19','admin'),
(8,27,'finalizado','2016-08-12 08:50:22','admin'),
(9,27,'cancelado','2016-08-12 08:51:16','admin'),
(10,27,'finalizado','2016-08-12 08:52:51','admin'),
(11,27,'pendiente','2016-08-12 08:56:35','admin'),
(12,27,'finalizado','2016-08-12 08:57:51','admin'),
(13,27,'pendiente','2016-08-12 08:59:30','admin'),
(14,27,'cancelado','2016-08-12 08:59:37','admin'),
(15,28,'pendiente','2016-12-15 17:30:28','admin');

/*Table structure for table `shop_products` */

DROP TABLE IF EXISTS `shop_products`;

CREATE TABLE `shop_products` (
  `id_product` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name_product` varchar(250) NOT NULL DEFAULT '',
  `description_product` text NOT NULL,
  `image_product` varchar(250) NOT NULL DEFAULT '',
  `price_product` double NOT NULL DEFAULT '0',
  `stock_product` int(11) NOT NULL DEFAULT '0',
  `important_product` tinyint(1) NOT NULL DEFAULT '0',
  `id_manufacturer` int(11) NOT NULL DEFAULT '0',
  `active_product` tinyint(1) NOT NULL DEFAULT '1',
  `ref_product` varchar(100) NOT NULL DEFAULT '',
  `category_product` varchar(100) NOT NULL DEFAULT '',
  `subcategory_product` varchar(100) NOT NULL DEFAULT '',
  `canal_product` varchar(100) NOT NULL DEFAULT '',
  `date_product` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_ini_product` date NOT NULL,
  `date_fin_product` date NOT NULL,
  PRIMARY KEY (`id_product`),
  KEY `active_producto` (`active_product`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `shop_products` */

insert  into `shop_products`(`id_product`,`name_product`,`description_product`,`image_product`,`price_product`,`stock_product`,`important_product`,`id_manufacturer`,`active_product`,`ref_product`,`category_product`,`subcategory_product`,`canal_product`,`date_product`,`date_ini_product`,`date_fin_product`) values 
(1,'La alargada sombra del amor','<p>La alargada sombra del amor de Mathias Malzieu</p>\r\n','1458643092_tapa-la-alargada.jpg',101,50,0,2,1,'','','','comercial,gerente','0000-00-00 00:00:00','2016-12-01','2016-12-14'),
(2,'Premio sorpresa','<p>Descubre que tiene este&nbsp;regalo sorpresa!!!!</p>\r\n','1458643199_premio_dic_2.jpg',50,33,1,0,0,'','','','comercial','0000-00-00 00:00:00','0000-00-00','0000-00-00'),
(3,'Zapatillas','<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n','1458643454_1411549492.jpg',20,41,0,0,0,'','','','comercial,gerente','0000-00-00 00:00:00','0000-00-00','0000-00-00'),
(4,'Viaje por Suecia','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur at arcu et dui vulputate fermentum. Vestibulum quis felis auctor, porta sem a, iaculis mi. Proin non lorem erat. Nulla pretium orci vel dui tempus sodales. Nunc eget tellus et sem vehicula lacinia. Aenean quam purus, maximus at dolor in, sollicitudin posuere felis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Aenean finibus viverra lorem et commodo. Duis luctus enim in ultricies sagittis. Fusce ut risus vel elit luctus laoreet et at nisl. Proin nisi sapien, eleifend at sapien et, euismod placerat arcu. Etiam non tellus non mi facilisis dictum quis in nisi. Sed varius mauris id libero euismod auctor. Duis aliquam est at elementum condimentum.</p>\r\n\r\n<p>Nulla tempus, urna a tincidunt varius, risus ex pretium orci, elementum fermentum sapien augue non ex. Nunc dui arcu, semper at eros sit amet, dignissim suscipit ante. Nullam in aliquet ligula. Fusce posuere fermentum quam, a sollicitudin justo facilisis sit amet. Pellentesque ut eros in odio sagittis finibus. Proin eu turpis a eros molestie laoreet. Mauris blandit vehicula porttitor. Ut at mollis augue. Morbi mauris risus, semper non risus eget, accumsan mollis urna. Donec hendrerit mi eu diam tempor, a malesuada nisi laoreet. Aenean commodo massa quis fermentum gravida. Pellentesque sit amet ultricies odio. Vestibulum ullamcorper diam vitae tempor cursus. Ut eu augue vitae sem tincidunt lobortis nec et nisl. Integer ut metus semper, imperdiet diam vitae, vulputate neque.</p>\r\n','1458725914_1458206720.jpg',90,56,0,0,0,'','Viajes','','comercial,gerente','0000-00-00 00:00:00','0000-00-00','0000-00-00'),
(5,'4 entradas de cine','<p>4 entradas de cine v&aacute;lidas para cualquier d&iacute;a de la semana, con 3 meses de caducidad desde la fecha de env&iacute;o</p>\r\n','1459507812_tickets.jpg',152,49,0,2,1,'','Ocio','','comercial','0000-00-00 00:00:00','0000-00-00','0000-00-00'),
(6,'Dron Follower','\nDron Follower para uso en exteriores con tecnología giroscópica de 6 ejes que permite un control más fácil y preciso. Ideal para volar en el exterior, gracias a su pequeño tamaño posee una gran estabilidad. \n','1459509195_drone_follower2.jpg',180,98,0,3,1,'56431MX','Electrónica','','comercial','0000-00-00 00:00:00','2016-12-01','2016-12-31'),
(7,'Camiseta y balón oficial de la Eurocopa 2016','<p>Camiseta y bal&oacute;n oficial de la primera equipaci&oacute;n de la Selecci&oacute;n Espa&ntilde;ola para la Eurocopa 2016</p>\r\n','1459508024_camiseta_eurocopa_2016.jpg',417,0,0,5,1,'','Moda','Deportes','comercial','0000-00-00 00:00:00','2016-11-27','2017-04-08'),
(8,'Smart TV Samsung 32¨¨','','',0,0,0,0,0,'','','','comercial','0000-00-00 00:00:00','0000-00-00','0000-00-00'),
(9,'Smart TV Samsung 32´´','<p>Smart TV calidad HD. Multi-Touch retroiluminada por LED de 9.7 pulgadas. 2048x1536 retina display (264 pixels por pulgada). Wi-Fi integrado.</p>\r\n','1459508758_tv.jpg',1196,0,1,3,1,'','Electrónica','TV','comercial','0000-00-00 00:00:00','0000-00-00','0000-00-00'),
(10,'Apple iPad Air 2 64 GB WiFi Plata','<p>Multi-Touch retroiluminada por LED de 9.7 pulgadas. 2048x1536 retina display (264 pixels por pulgada).&nbsp;</p>\r\n','1459508996_apple_ipad_air_2_wifi_16gb_silver-30379190-4.jpg',2356,5,0,1,1,'','Electrónica','Móviles','comercial','0000-00-00 00:00:00','2016-11-27','2017-05-06'),
(11,'www','<p>www</p>\r\n','1473334359_logopentaho.png',20,0,0,1,1,'','','','comercial,gerente','2016-09-08 13:32:39','2016-12-01','2017-01-07');

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
  `creditos` double NOT NULL DEFAULT '0',
  `participaciones` int(11) NOT NULL DEFAULT '0',
  `user_comentarios` longtext NOT NULL,
  `user_date` date DEFAULT NULL,
  `telefono` varchar(100) NOT NULL DEFAULT '',
  `last_access` datetime DEFAULT NULL,
  `user_lan` varchar(5) NOT NULL DEFAULT 'es',
  `direccion_user` varchar(250) NOT NULL DEFAULT '',
  `ciudad_user` varchar(100) NOT NULL DEFAULT '',
  `provincia_user` varchar(100) NOT NULL DEFAULT '',
  `cpostal_user` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`username`),
  KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `users` */

insert  into `users`(`username`,`nick`,`user_password`,`email`,`name`,`surname`,`date_add`,`registered`,`confirmed`,`disabled`,`date_disabled`,`canal`,`empresa`,`perfil`,`foto`,`puntos`,`creditos`,`participaciones`,`user_comentarios`,`user_date`,`telefono`,`last_access`,`user_lan`,`direccion_user`,`ciudad_user`,`provincia_user`,`cpostal_user`) values 
('admin','adm','123456','dnoguera@imagar.com','Administrador','Community','2014-07-16 14:43:05',1,1,0,'1970-01-01 00:00:00','admin','0001','admin','1471434333.jpeg',520,9140,186,'',NULL,'','2016-12-22 10:23:35','es','dirección','localidad','Provincia','28001'),
('david','DNG','123456','dnoguera@imagar.com','David','Noguera','2014-07-16 14:43:08',1,1,0,'1970-01-01 00:00:00','comercial','0003','responsable','',42,0,121,'Hoy me siento bien',NULL,'','2016-02-26 12:29:26','es','','','',''),
('borja','Borja','123456','bvilaplana@imagar.com','Borja','Vilaplana','2014-09-16 17:38:00',1,1,0,'2016-05-09 12:09:38','comercial','0001','regional','',53,0,11,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin semper, nunc ut cursus sagittis,',NULL,'','2016-12-21 16:34:43','es','','','',''),
('pedro','Pedro','123456','pramos@imagar.com','Pedro','Ramos','2014-09-16 17:38:57',1,1,0,'1970-01-01 00:00:00','gerente','0002','responsable','',54,0,16,'',NULL,'','2016-12-22 09:33:42','es','','','',''),
('claudio','Claudio','123456','cgonzalez@imagar.com','Claudio','Gonzalez','2014-09-16 17:40:12',1,1,0,'1970-01-01 00:00:00','gerente','0003','usuario','1425079297.jpeg',26,0,9,'A por ellos!!!',NULL,'','2016-11-28 16:37:57','es','','','',''),
('20266370N','DavidN','123456','dnoguera@imagar.com','David','Noguera Gutierrez','2014-11-03 16:49:56',1,1,1,'2016-05-09 12:05:26','comercial','0001','usuario','',210,0,1,'',NULL,'91','2014-12-27 00:36:36','es','calle','locss','pro','3444'),
('dmarchante','DavidM','123456','dmarchante@imagar.com','David','Marchante','2014-09-17 09:32:54',1,1,1,'2015-08-18 00:00:00','comercial','0002','usuario','',305,0,1,'',NULL,'',NULL,'es','','','',''),
('senen','Senén','123456','shermida@imagar.com','Senén','Hermida','2014-09-17 09:33:27',1,1,0,'1970-01-01 00:00:00','gerente','1235','responsable','',101,0,-1,'',NULL,'','2016-12-19 11:14:03','es','','','',''),
('dgarcia','Dsan','123456','dgarcia@imagar.com','Daniel','García','2014-09-17 09:34:47',1,1,0,'1970-01-01 00:00:00','comercial','0003','usuario','',10,0,1,'',NULL,'','2016-01-19 11:21:44','es','','','',''),
('dramos','Flores','123456','dramos@imagar.com','David','Ramos','2014-10-09 08:54:15',1,1,0,'1970-01-01 00:00:00','comercial','1235','usuario','',11,0,0,'',NULL,'','2016-10-14 09:49:03','es','','','',''),
('jgonzalez','Javi','123456','jgonzalez','Javier','Gonzalez','2014-10-09 08:55:16',1,1,0,'1970-01-01 00:00:00','comercial','0002','usuario','',301,0,0,'',NULL,'','2016-10-14 09:42:25','es','','','',''),
('cgomez','Carlos','123456','cgomez@imagar.com','Carlos','Gómez','2014-10-09 08:56:09',1,1,0,'1970-01-01 00:00:00','comercial','0003','usuario','',20,0,0,'',NULL,'','2015-12-18 09:42:43','es','','','',''),
('dcancho','Cancho','123456','ccancho@imagar.com','Daniel','Cancho','2014-10-09 08:57:53',1,1,0,'1970-01-01 00:00:00','comercial','0002','usuario','1425079823.jpeg',19,0,7,'Estoy muy loco!!',NULL,'','2016-05-10 14:08:17','es','','','',''),
('odelgado','Oscar','123456','odelgado@imagar.com','Oscar','Delgado','2015-03-14 19:40:34',1,1,0,'1970-01-01 00:00:00','comercial','1235','usuario','',56,0,0,'',NULL,'',NULL,'es','','','',''),
('prueba','Prueba','123456','dnoguera@imagar.com','Usuario','Prueba','2015-08-07 10:50:49',1,0,0,'1970-01-01 00:00:00','comercial','0001','usuario','',85,0,0,'',NULL,'','2015-08-07 10:51:09','es','','','',''),
('Redbull','RedBull','123456','dnoguera@imagar.com','RedBull','Demo','2015-08-10 08:37:05',1,1,0,'1970-01-01 00:00:00','comercial','0004','usuario','',46,0,0,'',NULL,'','2016-10-14 09:57:36','es','','','',''),
('Juanito','','123456','juanito@gmail.com','Juan','Gómez','2016-02-11 17:50:47',0,0,0,'1970-01-01 00:00:00','comercial','0003','usuario','',89,0,0,'',NULL,'915554444',NULL,'es','','','',''),
('regional','Regional2','123456','regional@email.com','Pepe','Castro','2016-02-26 11:53:46',1,1,0,'1970-01-01 00:00:00','comercial','0001','regional','',77,0,0,'',NULL,'',NULL,'es','','','',''),
('PentahoBI','','123456','dnoguera@imagar.com','Pedro','','2016-11-07 09:04:03',1,1,0,'1970-01-01 00:00:00','admin','0001','admin','',0,0,0,'',NULL,'',NULL,'es','','','','');

/*Table structure for table `users_connected` */

DROP TABLE IF EXISTS `users_connected`;

CREATE TABLE `users_connected` (
  `username` varchar(100) NOT NULL,
  `connection_canal` varchar(100) NOT NULL DEFAULT '',
  `connection_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `users_connected` */

insert  into `users_connected`(`username`,`connection_canal`,`connection_time`) values 
('prueba','comercial','2015-08-07 10:51:24'),
('08932984Z','comercial','2014-10-17 11:50:19'),
('claudio','gerente','2016-11-28 16:38:05'),
('david','comercial','2016-02-26 12:33:28'),
('dgarcia','comercial','2016-01-19 11:31:15'),
('borja','comercial','2016-12-21 17:19:53'),
('dcancho','comercial','2016-05-10 14:08:20'),
('pedro','gerente','2016-12-22 09:33:46'),
('Redbull','comercial','2016-10-14 09:57:53'),
('admin','admin','2016-12-22 10:27:05');

/*Table structure for table `users_creditos` */

DROP TABLE IF EXISTS `users_creditos`;

CREATE TABLE `users_creditos` (
  `id_credito` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `credito_username` varchar(100) NOT NULL DEFAULT '',
  `credito_puntos` double NOT NULL DEFAULT '0',
  `credito_motivo` varchar(250) NOT NULL DEFAULT '',
  `credito_detalle` text NOT NULL,
  `credito_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_credito`)
) ENGINE=MyISAM AUTO_INCREMENT=274 DEFAULT CHARSET=utf8;

/*Data for the table `users_creditos` */

insert  into `users_creditos`(`id_credito`,`credito_username`,`credito_puntos`,`credito_motivo`,`credito_detalle`,`credito_date`) values 
(271,'admin',500,'Test','detalle test','2016-04-11 12:21:37'),
(272,'admin',-180,'Compras premios','Producto ID.6','2016-04-11 12:22:01'),
(273,'admin',-180,'Compras premios','Producto ID.6','2016-12-15 17:30:28');

/*Table structure for table `users_login` */

DROP TABLE IF EXISTS `users_login`;

CREATE TABLE `users_login` (
  `ses_id` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `ses_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ses_id`,`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `users_login` */

insert  into `users_login`(`ses_id`,`username`,`ses_time`) values 
('lhefuhselm8i8id923b3','admin','2016-03-17 13:33:44'),
('7hhvabwd855up6ec5vo','admin','2016-03-17 13:40:53'),
('pyt3silfy2bkm65py9','admin','2016-03-17 13:53:24'),
('dwyj5o50ujlvkqkem2n','admin','2016-03-17 13:54:00'),
('5dmr2powz31ps2yyun1k','admin','2016-03-17 13:54:03'),
('fshb52qvhz2brme5nsec','admin','2016-03-17 16:00:17');

/*Table structure for table `users_participaciones` */

DROP TABLE IF EXISTS `users_participaciones`;

CREATE TABLE `users_participaciones` (
  `id_participacion` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `participacion_username` varchar(100) NOT NULL DEFAULT '',
  `participacion_motivo` varchar(250) NOT NULL DEFAULT '',
  `participacion_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `valor` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_participacion`)
) ENGINE=MyISAM AUTO_INCREMENT=345 DEFAULT CHARSET=utf8;

/*Data for the table `users_participaciones` */

insert  into `users_participaciones`(`id_participacion`,`participacion_username`,`participacion_motivo`,`participacion_date`,`valor`) values 
(1,'admin','Comentario en el foro','2014-02-21 20:07:21',1),
(2,'admin','Comentario en el foro','2014-02-21 20:36:50',1),
(3,'admin','Comentario en el foro','2014-02-27 12:07:35',1),
(4,'admin','Comentario en el foro','2014-03-24 15:58:35',1),
(5,'admin','Comentario en el foro','2014-03-25 08:56:05',1),
(6,'admin','Comentario en el foro','2014-03-25 08:56:44',1),
(7,'admin','Comentario en el foro','2014-03-25 09:02:09',1),
(8,'admin','Comentario en el foro','2014-03-25 09:03:34',1),
(9,'admin','Comentario en el foro','2014-03-25 09:04:19',1),
(10,'admin','Comentario en el foro','2014-03-25 09:04:42',1),
(11,'admin','Comentario en el foro','2014-03-25 09:06:38',1),
(12,'admin','test','2014-03-26 13:02:34',1),
(13,'admin','Comentario en el foro','2014-03-28 10:10:35',1),
(14,'admin','Comentario en el foro','2014-04-02 09:40:40',1),
(15,'admin','Comentario en el foro','2014-04-02 09:50:24',1),
(16,'admin','Comentario en el foro','2014-04-02 09:56:51',1),
(17,'admin','Comentario en el foro','2014-04-02 09:57:00',1),
(18,'admin','Comentario en el foro','2014-04-02 09:57:47',1),
(19,'admin','Comentario en el foro','2014-04-02 10:04:50',1),
(20,'admin','Comentario en el foro','2014-04-02 10:05:13',1),
(21,'admin','Comentario en el foro','2014-04-02 10:05:23',1),
(22,'admin','Comentario en el foro','2014-04-02 10:39:20',1),
(23,'admin','Comentario en el foro','2014-04-05 00:14:03',1),
(24,'admin','Comentario en el foro','2014-04-08 10:48:55',1),
(25,'admin','Comentario en el foro','2014-04-08 10:50:06',1),
(26,'20266370N','Comentario en el foro','2014-04-09 15:39:48',1),
(27,'admin','Comentario en el foro','2014-05-01 17:42:37',1),
(28,'admin','Comentario en el foro','2014-05-01 17:42:37',1),
(29,'admin','Comentario en el foro','2014-05-01 17:42:37',1),
(30,'admin','Comentario en el foro','2014-05-01 17:44:27',1),
(31,'admin','Comentario en el foro','2014-05-01 17:44:27',1),
(32,'admin','Comentario en el foro','2014-05-01 17:44:27',1),
(33,'admin','Comentario en el foro','2014-05-01 17:44:53',1),
(34,'admin','Comentario en el foro','2014-05-01 17:45:01',1),
(35,'admin','Comentario en el foro','2014-05-01 17:45:01',1),
(36,'admin','Comentario en el foro','2014-05-01 17:45:01',1),
(37,'admin','Comentario en el foro','2014-05-01 17:45:01',1),
(38,'admin','Comentario en el foro','2014-05-01 17:58:58',1),
(39,'admin','Comentario en el foro','2014-05-01 18:19:26',1),
(40,'admin','Comentario en el foro','2014-05-01 18:20:07',1),
(41,'admin','Comentario en el foro','2014-05-02 11:38:44',1),
(42,'admin','Comentario en el foro','2014-05-02 11:40:43',1),
(43,'admin','Comentario en el foro','2014-05-02 11:40:48',1),
(44,'admin','Comentario en el foro','2014-05-02 11:40:54',1),
(45,'admin','Comentario en el foro','2014-05-02 11:41:02',1),
(46,'admin','Comentario en el foro','2014-05-02 11:41:16',1),
(47,'admin','Comentario en el foro','2014-05-02 11:42:10',1),
(48,'admin','Comentario en el foro','2014-05-02 11:42:23',1),
(49,'admin','Comentario en el foro','2014-05-02 11:42:37',1),
(50,'admin','Comentario en el foro','2014-05-02 11:43:30',1),
(51,'admin','Comentario en el foro','2014-05-02 11:56:16',1),
(52,'admin','Comentario en el foro','2014-05-02 12:09:40',1),
(53,'admin','Comentario en el foro','2014-05-02 12:09:51',1),
(54,'admin','Comentario en el foro','2014-05-02 12:10:04',1),
(55,'admin','Comentario en el foro','2014-05-02 12:10:18',1),
(56,'admin','Comentario en el foro','2014-05-02 12:10:28',1),
(57,'admin','Comentario en el foro','2014-05-02 12:11:39',1),
(58,'admin','Comentario en el foro','2014-05-02 12:11:52',1),
(59,'admin','Comentario en el foro','2014-05-02 12:11:59',1),
(60,'admin','Comentario en el foro','2014-05-02 12:12:16',1),
(61,'admin','Comentario en el foro','2014-05-02 12:12:27',1),
(62,'admin','Comentario en el foro','2014-05-02 12:12:36',1),
(63,'admin','Comentario en el foro','2014-05-02 12:12:43',1),
(64,'20266370N','Comentario en el foro','2014-05-02 17:13:29',1),
(65,'20266370N','Comentario en el foro','2014-05-02 23:32:55',1),
(66,'20266370N','Comentario en el foro','2014-05-02 23:35:06',1),
(67,'20266370N','Comentario en el foro','2014-05-02 23:36:26',1),
(68,'admin','Comentario en el foro','2014-05-05 15:47:23',1),
(69,'admin','Comentario en el foro','2014-07-24 13:59:45',1),
(70,'admin','Comentario en el foro','2014-07-24 14:00:10',1),
(71,'admin','Comentario en el muro','2014-07-29 14:46:12',1),
(72,'admin','Comentario en el muro','2014-07-29 14:46:57',1),
(73,'admin','Comentario en el muro','2014-07-30 10:44:49',1),
(74,'admin','Comentario en el muro','2014-07-30 10:44:52',1),
(75,'admin','Comentario en el muro','2014-07-30 10:44:55',1),
(76,'admin','Comentario en el muro','2014-07-30 10:44:59',1),
(77,'admin','Comentario en el muro','2014-07-30 11:57:02',-1),
(78,'admin','Subida de foto','2014-09-10 11:15:27',1),
(79,'admin','Comentario en el foro','2014-09-10 14:10:13',1),
(80,'admin','Subida de foto','2014-09-15 13:35:46',1),
(81,'admin','Comentario en el muro','2014-09-18 10:31:00',1),
(82,'david','Comentario en el muro','2014-09-18 16:21:26',1),
(83,'david','Comentario en el muro','2014-09-23 12:47:45',1),
(84,'david','Comentario en el muro','2014-09-23 12:47:50',1),
(85,'admin','Comentario en el muro','2014-09-23 12:48:19',1),
(86,'admin','Subida de foto','2014-09-23 16:30:54',1),
(87,'admin','Subida de foto','2014-09-23 16:32:32',1),
(88,'admin','Subida de foto','2014-09-23 16:55:19',1),
(89,'admin','Subida de foto','2014-09-23 17:02:14',1),
(90,'admin','Subida de foto','2014-09-23 17:02:17',1),
(91,'admin','Subida de foto','2014-09-23 17:02:21',1),
(92,'admin','Subida de foto','2014-09-23 17:02:25',1),
(93,'admin','Subida de foto','2014-09-24 10:13:25',1),
(94,'admin','Subida de foto','2014-09-24 10:16:37',1),
(95,'admin','Subida de foto','2014-09-24 10:20:55',1),
(96,'admin','Subida de foto','2014-09-24 10:23:18',1),
(97,'admin','Subida de foto','2014-09-24 10:23:22',1),
(98,'admin','Subida de foto','2014-09-24 10:25:13',1),
(99,'admin','Subida de foto','2014-09-24 10:25:16',1),
(100,'admin','Subida de foto','2014-09-24 11:02:16',1),
(101,'admin','Subida de foto','2014-09-24 11:05:26',1),
(102,'admin','Subida de foto','2014-09-24 11:05:34',1),
(103,'admin','Subida de foto','2014-09-24 11:05:38',1),
(104,'admin','Subida de foto','2014-09-24 11:05:44',1),
(105,'admin','Subida de foto','2014-09-24 15:46:01',1),
(106,'admin','Subida de foto','2014-09-24 15:46:06',1),
(107,'admin','Subida de foto','2014-09-24 15:46:12',1),
(108,'admin','Subida de foto','2014-09-24 15:46:18',1),
(109,'admin','Subida de foto','2014-09-24 15:46:23',1),
(110,'admin','Subida de foto','2014-09-24 15:46:31',1),
(111,'admin','Subida de foto','2014-09-24 15:46:38',1),
(112,'admin','Subida de foto','2014-09-24 15:59:07',1),
(113,'admin','Subida de foto','2014-09-24 15:59:13',1),
(114,'admin','Subida de foto','2014-09-24 15:59:23',1),
(115,'admin','Subida de foto','2014-09-24 15:59:30',1),
(116,'admin','Subida de foto','2014-09-24 15:59:36',1),
(117,'admin','Subida de foto','2014-09-24 16:05:46',1),
(118,'admin','Subida de foto','2014-09-24 16:05:52',1),
(119,'admin','Subida de foto','2014-09-24 16:06:02',1),
(120,'admin','Subida de foto','2014-09-24 16:06:11',1),
(121,'admin','Subida de foto','2014-09-24 16:06:18',1),
(122,'admin','Subida de foto','2014-09-24 16:06:22',1),
(123,'admin','Subida de foto','2014-09-24 16:06:29',1),
(124,'admin','Subida de foto','2014-09-24 16:08:32',1),
(125,'admin','Subida de foto','2014-09-24 16:08:43',1),
(126,'admin','Subida de foto','2014-09-24 16:08:49',1),
(127,'admin','Subida de foto','2014-09-24 16:18:56',1),
(128,'admin','Subida de foto','2014-09-24 16:19:03',1),
(129,'admin','Subida de foto','2014-09-24 16:19:09',1),
(130,'admin','Subida de foto','2014-09-24 16:19:15',1),
(131,'admin','Subida de foto','2014-09-24 16:19:21',1),
(132,'admin','Subida de foto','2014-09-24 16:19:27',1),
(133,'admin','Subida de foto','2014-09-24 16:19:32',1),
(134,'admin','Subida de foto','2014-09-24 16:19:37',1),
(135,'admin','Subida de foto','2014-09-24 16:19:42',1),
(136,'admin','Subida de foto','2014-09-24 16:19:48',1),
(137,'admin','Subida de foto','2014-09-24 16:19:54',1),
(138,'admin','Comentario en el foro','2014-09-26 12:38:16',1),
(139,'admin','Comentario en el foro','2014-09-26 12:38:34',1),
(140,'admin','Comentario en el foro','2014-09-26 12:38:45',1),
(141,'admin','Subida de foto','2014-09-26 14:09:42',1),
(142,'admin','Subida de foto','2014-09-26 14:09:52',1),
(143,'admin','Comentario en el foro','2014-09-29 13:50:51',1),
(144,'admin','Comentario en el foro','2014-09-29 13:51:12',1),
(145,'david','Comentario en el muro','2014-09-29 18:01:26',1),
(146,'admin','Comentario en el foro','2014-09-30 10:33:54',1),
(147,'admin','Comentario en el foro','2014-09-30 10:34:17',1),
(148,'admin','Comentario en el foro','2014-09-30 10:35:04',1),
(149,'admin','Comentario en el foro','2014-09-30 10:37:20',1),
(150,'admin','Comentario en el foro','2014-09-30 10:40:52',1),
(151,'admin','Comentario en el foro','2014-10-03 10:40:18',1),
(152,'admin','Comentario en el foro','2014-10-03 10:42:31',1),
(153,'admin','Comentario en el foro','2014-10-09 11:51:16',1),
(154,'admin','Comentario en el foro','2014-10-09 11:51:26',1),
(155,'admin','Comentario en el foro','2014-10-09 11:51:35',1),
(156,'admin','Comentario en el foro','2014-10-09 16:44:03',1),
(157,'admin','Comentario en el foro','2014-10-09 18:19:07',1),
(158,'admin','Comentario en el foro','2014-10-10 12:19:59',1),
(159,'admin','Comentario en el foro','2014-10-10 12:28:39',1),
(160,'admin','Comentario en el foro','2014-10-10 15:07:12',1),
(161,'david','Comentario en el foro','2014-10-11 18:14:19',1),
(162,'david','Comentario en el muro','2014-10-12 01:33:45',1),
(163,'david','Comentario en el muro','2014-10-12 01:35:53',1),
(164,'pedro','Finalización del curso','2014-10-14 14:01:16',1),
(165,'ADMIN','Porque s','2014-10-14 14:13:00',-1),
(166,'PEDRO','Finalizaci','2014-10-14 14:13:00',1),
(167,'ADMIN','Porque s','2014-10-14 14:13:51',-1),
(168,'PEDRO','Finalizaci','2014-10-14 14:13:51',1),
(169,'admin','Comentario en el foro','2014-10-15 12:27:11',1),
(170,'admin','Comentario en el muro','2014-10-17 17:04:53',1),
(171,'admin','Comentario en el foro','2014-10-22 17:49:41',1),
(172,'admin','Comentario en el foro','2014-10-23 13:44:35',1),
(173,'admin','Comentario en el foro','2014-10-24 11:39:22',1),
(174,'admin','Comentario en el foro','2014-10-24 11:39:35',1),
(175,'admin','Comentario en el foro','2014-11-07 12:16:15',1),
(176,'admin','Comentario en el foro','2014-11-28 13:09:42',1),
(177,'admin','Comentario en el foro','2014-11-28 13:10:34',1),
(178,'admin','Comentario en el foro','2014-11-28 13:11:23',1),
(179,'admin','Comentario en el foro','2014-11-28 13:11:34',1),
(180,'admin','Comentario en el foro','2014-11-28 13:11:59',1),
(181,'admin','Comentario en el foro','2014-11-28 13:14:44',1),
(182,'admin','Comentario en el foro','2014-11-28 13:16:18',1),
(183,'david','Comentario en el muro','2014-11-28 13:16:59',1),
(184,'david','Comentario en el foro','2014-11-28 13:17:29',1),
(185,'admin','Comentario en el foro','2014-11-28 13:19:17',1),
(186,'admin','Comentario en el foro','2014-11-28 13:20:58',1),
(187,'david','Comentario en el foro','2014-11-28 14:09:56',1),
(188,'david','Comentario en el foro','2014-11-28 18:02:25',1),
(189,'admin','Comentario en el muro','2014-11-28 18:18:53',1),
(190,'admin','Comentario en el foro','2014-11-28 18:20:19',1),
(191,'admin','Comentario en el foro','2014-11-28 18:21:22',1),
(192,'admin','Comentario en el foro','2014-11-28 18:22:18',1),
(193,'admin','Comentario en el foro','2014-11-28 18:23:54',1),
(194,'admin','Comentario en el foro','2014-11-28 20:06:41',1),
(195,'admin','Comentario en el foro','2014-12-03 13:30:06',1),
(196,'admin','Comentario en el muro','2014-12-04 12:02:23',1),
(197,'admin','Comentario en el muro','2014-12-04 12:03:28',1),
(198,'admin','Comentario en el muro','2014-12-04 12:04:22',1),
(199,'admin','Comentario en el muro','2014-12-04 12:05:44',1),
(200,'admin','Comentario en el muro','2014-12-04 12:16:18',1),
(201,'admin','Comentario en el muro','2014-12-04 12:45:28',1),
(202,'admin','Comentario en el muro','2014-12-04 13:01:03',1),
(203,'admin','Comentario en el muro','2014-12-04 13:02:23',1),
(204,'admin','Comentario en el muro','2014-12-04 13:05:51',1),
(205,'admin','Comentario en el foro','2014-12-04 13:11:20',1),
(206,'admin','Comentario en el foro','2014-12-04 13:12:36',1),
(207,'admin','Comentario en el foro','2014-12-04 13:12:45',1),
(208,'admin','Comentario en el foro','2014-12-04 13:13:05',1),
(209,'admin','Comentario en el foro','2014-12-04 13:13:50',1),
(210,'admin','Comentario en el foro','2014-12-04 13:22:46',1),
(211,'admin','Comentario en el muro','2014-12-04 14:14:00',1),
(212,'admin','Comentario en el muro','2014-12-04 14:14:14',1),
(213,'admin','Superación curso ID: 9','2014-12-10 09:55:43',1),
(214,'admin','Superación curso ID: 10','2014-12-16 12:46:39',1),
(215,'admin','Comentario en el muro','2014-12-18 09:34:32',1),
(216,'dcancho','Comentario en el foro','2015-02-17 10:07:16',1),
(217,'admin','Comentario en el foro','2015-02-19 10:05:07',1),
(218,'admin','Comentario en el muro','2015-02-27 09:10:53',-1),
(219,'admin','Comentario en el foro','2015-02-27 12:14:43',1),
(220,'admin','Subida de foto','2015-02-28 00:03:56',1),
(221,'claudio','Comentario en el muro','2015-02-28 00:23:43',1),
(222,'admin','Comentario en el foro','2015-02-28 00:29:03',1),
(223,'dcancho','Comentario en el muro','2015-02-28 00:30:40',1),
(224,'dcancho','Comentario en el foro','2015-02-28 00:31:09',1),
(225,'dcancho','Comentario en el foro','2015-02-28 00:31:54',1),
(226,'dcancho','Subida de foto','2015-02-28 00:33:48',1),
(227,'claudio','Comentario en el foro','2015-02-28 00:39:36',1),
(228,'claudio','Comentario en el foro','2015-02-28 00:42:14',1),
(229,'claudio','Comentario en el foro','2015-02-28 00:44:20',1),
(230,'dcancho','Comentario en el foro','2015-02-28 00:59:12',1),
(231,'admin','Comentario en el foro','2015-03-02 10:46:27',1),
(232,'borja','Comentario en el muro','2015-03-14 01:04:29',1),
(233,'borja','Subida de foto','2015-03-14 01:38:18',1),
(234,'admin','Comentario en el foro','2015-03-15 03:03:04',1),
(235,'claudio','Comentario en el muro','2015-03-18 10:32:19',1),
(236,'claudio','Comentario en el muro','2015-03-18 10:34:49',1),
(237,'claudio','Comentario en el muro','2015-03-18 10:36:05',1),
(238,'claudio','Comentario en el muro','2015-03-18 10:37:38',1),
(239,'claudio','Comentario en el muro','2015-03-18 10:39:08',-1),
(240,'claudio','Comentario en el muro','2015-03-18 10:39:12',-1),
(241,'admin','Comentario en el muro','2015-03-18 10:39:24',-1),
(242,'admin','Comentario en el muro','2015-03-18 10:39:28',-1),
(243,'admin','Comentario en el muro','2015-03-18 10:39:32',-1),
(244,'admin','Comentario en el foro','2015-03-20 19:31:58',1),
(245,'admin','Comentario en el muro','2015-06-02 17:39:49',1),
(246,'borja','Comentario en el muro','2015-06-13 01:50:14',1),
(247,'borja','Comentario en el foro','2015-06-13 01:51:35',1),
(248,'pedro','Comentario en el muro','2015-08-14 10:18:32',1),
(249,'admin','Comentario en el foro','2015-09-09 17:43:41',1),
(250,'admin','Comentario en el foro','2015-09-09 17:43:51',1),
(251,'admin','Comentario en el foro','2015-09-09 17:43:59',1),
(252,'admin','Comentario en el foro','2015-09-09 17:44:03',1),
(253,'admin','Comentario en el foro','2015-09-09 17:44:07',1),
(254,'admin','Comentario en el foro','2015-09-09 17:44:11',1),
(255,'admin','Comentario en el foro','2015-09-09 17:44:15',1),
(256,'admin','Comentario en el foro','2015-09-09 17:44:25',1),
(257,'admin','Comentario en el foro','2015-09-09 17:44:43',1),
(258,'admin','Comentario en el foro','2015-09-09 17:44:57',1),
(259,'admin','Comentario en el foro','2015-09-11 13:46:59',1),
(260,'admin','Comentario en el foro','2015-09-11 13:47:13',1),
(261,'admin','Comentario en el foro','2015-09-11 13:47:22',1),
(262,'admin','Comentario en el foro','2015-09-11 13:47:33',1),
(263,'admin','Comentario en el muro','2015-09-28 09:02:00',1),
(264,'admin','Subida de foto','2015-09-28 09:39:43',1),
(265,'admin','Comentario en el foro','2015-09-28 09:46:56',1),
(266,'admin','Comentario en el muro','2015-09-28 10:35:55',1),
(267,'admin','Comentario en el foro','2015-10-03 02:25:38',1),
(268,'admin','Comentario en el foro','2015-10-05 11:25:31',1),
(269,'admin','Comentario en el foro','2015-10-16 11:07:10',1),
(270,'admin','Comentario en el foro','2015-10-16 11:39:57',1),
(271,'admin','Comentario en el foro','2015-10-16 11:40:08',1),
(272,'admin','Comentario en el foro','2015-10-16 11:40:17',1),
(273,'admin','Comentario en el muro','2015-10-19 15:37:56',1),
(274,'pedro','Comentario en el foro','2015-10-22 16:30:45',1),
(275,'pedro','Comentario en el muro','2015-10-22 16:30:55',1),
(276,'pedro','Comentario en el foro','2015-10-22 16:34:52',1),
(277,'pedro','Comentario en el foro','2015-10-22 16:35:29',1),
(278,'senen','Comentario en el foro','2015-10-27 13:20:59',1),
(279,'admin','Comentario en el muro','2015-10-27 16:42:55',1),
(280,'admin','Comentario en el muro','2015-10-28 08:37:07',-1),
(281,'admin','Comentario en el muro','2015-10-28 08:37:11',-1),
(282,'admin','Comentario en el muro','2015-10-28 08:48:35',-1),
(283,'admin','Comentario en el muro','2015-10-28 08:54:26',-1),
(284,'admin','Comentario en el foro','2015-10-28 12:57:24',1),
(285,'admin','Comentario en el foro','2015-11-12 17:16:05',1),
(286,'admin','Comentario en el foro','2015-11-12 17:16:23',1),
(287,'admin','Comentario en el muro','2016-01-19 08:44:53',1),
(288,'admin','Comentario en el muro','2016-01-19 08:48:28',1),
(289,'admin','Comentario en el muro','2016-01-19 08:48:36',1),
(290,'admin','Comentario en el muro','2016-01-19 09:30:43',1),
(291,'admin','Comentario en el muro','2016-01-19 09:31:03',1),
(292,'borja','Comentario en el muro','2016-01-19 11:17:58',1),
(293,'dgarcia','Comentario en el muro','2016-01-19 11:25:22',1),
(294,'admin','Comentario en el muro','2016-01-19 11:27:14',1),
(295,'borja','Comentario en el muro','2016-01-19 11:27:39',1),
(296,'pedro','Subida de foto','2016-01-19 13:10:51',1),
(297,'admin','Comentario en el muro','2016-01-20 15:56:08',1),
(298,'admin','Superación curso ID: 15','2016-02-02 17:06:00',1),
(299,'admin','Superación curso ID: 15','2016-02-02 17:08:46',1),
(300,'admin','ganador reto gamificacion','2016-02-26 12:28:33',1),
(301,'senen','perdedor reto gamificacion','2016-02-26 12:28:33',-1),
(302,'david','ganador reto gamificacion','2016-02-26 12:30:37',1),
(303,'senen','perdedor reto gamificacion','2016-02-26 12:30:37',-1),
(304,'claudio','Comentario en el foro','2016-03-09 13:29:24',1),
(305,'pedro','Comentario en el foro','2016-03-10 15:52:16',1),
(306,'borja','ganador reto gamificacion','2016-03-11 10:32:15',1),
(307,'admin','perdedor reto gamificacion','2016-03-11 10:32:15',-1),
(308,'admin','Comentario en el muro','2016-03-14 09:19:14',1),
(309,'dcancho','Comentario en el muro','2016-03-14 10:17:47',1),
(310,'admin','Comentario en el muro','2016-03-14 10:18:15',1),
(311,'claudio','Comentario en el muro','2016-03-14 10:18:57',1),
(312,'admin','Comentario en el muro','2016-03-14 10:19:35',1),
(313,'admin','Comentario en el foro','2016-03-17 10:02:08',1),
(314,'admin','Comentario en el foro','2016-03-17 10:02:19',1),
(315,'admin','Subida de foto','2016-03-17 10:25:53',1),
(316,'admin','Comentario en el foro','2016-05-26 10:47:49',1),
(317,'admin','Subida de foto','2016-06-30 13:58:52',1),
(318,'admin','Comentario en el foro','2016-08-29 14:44:17',1),
(319,'admin','Superación curso ID: 15','2016-09-30 12:54:08',1),
(320,'admin','Comentario en el foro','2016-10-14 09:20:27',1),
(321,'admin','Comentario en el muro','2016-10-20 10:44:45',1),
(322,'admin','Comentario en el muro','2016-10-20 10:45:19',1),
(323,'admin','Comentario en el foro','2016-10-20 10:47:16',1),
(324,'admin','Comentario en el foro','2016-10-20 10:50:46',1),
(325,'admin','Comentario en el foro','2016-11-16 10:36:16',1),
(326,'admin','Comentario en el foro','2016-11-16 10:36:30',1),
(327,'admin','Comentario en el foro','2016-11-23 16:19:15',1),
(328,'admin','Subida de foto','2016-12-01 15:27:09',1),
(329,'david','','2016-12-14 12:39:47',1),
(330,'borja','','2016-12-14 12:39:47',1),
(331,'pedro','','2016-12-14 12:39:47',1),
(332,'claudio','','2016-12-14 12:39:47',1),
(333,'20266370N','','2016-12-14 12:39:47',1),
(334,'dmarchante','','2016-12-14 12:39:47',1),
(335,'borja','Comentario en el foro','2016-12-19 11:43:53',1),
(336,'borja','Comentario en el foro','2016-12-19 11:44:11',1),
(337,'borja','Comentario en el muro','2016-12-20 09:22:39',1),
(338,'pedro','Comentario en el muro','2016-12-20 09:23:27',1),
(339,'pedro','Comentario en el muro','2016-12-20 09:25:04',1),
(340,'pedro','Superación curso ID: 16','2016-12-21 16:33:25',1),
(341,'admin','Primer acceso a documento ID: 11','2016-12-22 09:22:48',1),
(342,'admin','Primer acceso a documento ID: 8','2016-12-22 09:26:05',1),
(343,'pedro','Primer acceso a documento ID: 12','2016-12-22 09:34:14',1),
(344,'pedro','Primer acceso a documento ID: 11','2016-12-22 09:34:35',1);

/*Table structure for table `users_permissions` */

DROP TABLE IF EXISTS `users_permissions`;

CREATE TABLE `users_permissions` (
  `username` varchar(100) CHARACTER SET latin1 NOT NULL,
  `pagename` varchar(255) CHARACTER SET latin1 NOT NULL,
  `permission_type` varchar(20) CHARACTER SET latin1 NOT NULL,
  `permission_type_value` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`username`,`pagename`,`permission_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `users_permissions` */

insert  into `users_permissions`(`username`,`pagename`,`permission_type`,`permission_type_value`) values 
('20266370N','admin-albumes','edit',0),
('20266370N','admin-albumes','view',0),
('20266370N','admin-albumes-new','edit',0),
('20266370N','admin-albumes-new','view',0),
('20266370N','admin-blog','edit',0),
('20266370N','admin-blog','view',0),
('20266370N','admin-blog-foro','edit',0),
('20266370N','admin-blog-foro','view',0),
('20266370N','admin-blog-new','edit',0),
('20266370N','admin-blog-new','view',0),
('20266370N','admin-campaign','edit',0),
('20266370N','admin-campaign','view',0),
('20266370N','admin-campaigns','edit',0),
('20266370N','admin-campaigns','view',0),
('20266370N','admin-campaigns-type','edit',0),
('20266370N','admin-campaigns-type','view',0),
('20266370N','admin-campaigns-types','edit',0),
('20266370N','admin-campaigns-types','view',0),
('20266370N','admin-fotos-comentarios','edit',0),
('20266370N','admin-fotos-comentarios','view',0),
('20266370N','admin-validacion-fotos','edit',0),
('20266370N','admin-validacion-fotos','view',0),
('20266370N','blog','edit',1),
('20266370N','blog','view',1),
('20266370N','blog-list','edit',1),
('20266370N','blog-list','view',1),
('20266370N','fotos','edit',1),
('20266370N','fotos','view',1),
('20266370N','user-campaign','edit',1),
('20266370N','user-campaign','view',1),
('20266370N','user-campaigns','edit',1),
('20266370N','user-campaigns','view',1),
('admin','blog','edit',1),
('david','admin','view',1),
('david','admin-albumes','edit',0),
('david','admin-albumes','view',0),
('david','admin-albumes-new','edit',0),
('david','admin-albumes-new','view',1),
('david','admin-area','edit',0),
('david','admin-area','view',0),
('david','admin-area-docs','edit',0),
('david','admin-area-docs','view',0),
('david','admin-area-form','edit',0),
('david','admin-area-form','view',0),
('david','admin-area-grupo','edit',0),
('david','admin-area-grupo','view',0),
('david','admin-area-revs','edit',0),
('david','admin-area-revs','view',0),
('david','admin-area-revs-form','edit',0),
('david','admin-area-revs-form','view',0),
('david','admin-area-tarea-grupo','edit',0),
('david','admin-area-tarea-grupo','view',0),
('david','admin-areas','edit',0),
('david','admin-areas','view',0),
('david','admin-blog','edit',0),
('david','admin-blog','view',0),
('david','admin-blog-foro','edit',0),
('david','admin-blog-foro','view',0),
('david','admin-blog-new','edit',0),
('david','admin-blog-new','view',0),
('david','admin-campaign','edit',0),
('david','admin-campaign','view',0),
('david','admin-campaigns','edit',0),
('david','admin-campaigns','view',0),
('david','admin-campaigns-type','edit',0),
('david','admin-campaigns-type','view',0),
('david','admin-campaigns-types','edit',0),
('david','admin-campaigns-types','view',0),
('david','admin-cargas-users','edit',0),
('david','admin-cargas-users','view',0),
('david','admin-config','edit',0),
('david','admin-config','view',0),
('david','admin-cuestionario','edit',0),
('david','admin-cuestionario','view',0),
('david','admin-cuestionario-revs','edit',0),
('david','admin-cuestionario-revs','view',0),
('david','admin-cuestionarios','edit',0),
('david','admin-cuestionarios','view',0),
('david','admin-destacados','edit',1),
('david','admin-destacados','view',0),
('david','admin-fotos-comentarios','edit',0),
('david','admin-fotos-comentarios','view',0),
('david','admin-info','edit',0),
('david','admin-info','view',0),
('david','admin-info-doc','edit',0),
('david','admin-info-doc','view',0),
('david','admin-informe-accesos','edit',0),
('david','admin-informe-accesos','view',0),
('david','admin-informe-participaciones','edit',0),
('david','admin-informe-participaciones','view',0),
('david','admin-informe-puntuaciones','edit',0),
('david','admin-informe-puntuaciones','view',0),
('david','admin-infotopdf','edit',0),
('david','admin-infotopdf','view',0),
('david','admin-infotopdf-doc','edit',0),
('david','admin-infotopdf-doc','view',0),
('david','admin-message','edit',0),
('david','admin-message','view',0),
('david','admin-messages','edit',0),
('david','admin-messages','view',0),
('david','admin-modules','edit',0),
('david','admin-modules','view',0),
('david','admin-novedades','edit',0),
('david','admin-novedades','view',0),
('david','admin-page','edit',0),
('david','admin-page','view',0),
('david','admin-pages','edit',0),
('david','admin-pages','view',0),
('david','admin-puntos','edit',0),
('david','admin-puntos','view',0),
('david','admin-template','edit',0),
('david','admin-template','view',0),
('david','admin-templates','edit',0),
('david','admin-templates','view',0),
('david','admin-user','edit',0),
('david','admin-user','view',0),
('david','admin-users','edit',0),
('david','admin-users','view',0),
('david','admin-users-tiendas','edit',0),
('david','admin-users-tiendas','view',0),
('david','admin-validacion-foro-comentarios','edit',0),
('david','admin-validacion-foro-comentarios','view',0),
('david','admin-validacion-foro-temas','edit',0),
('david','admin-validacion-foro-temas','view',0),
('david','admin-validacion-fotos','edit',0),
('david','admin-validacion-fotos','view',0),
('david','admin-validacion-muro','edit',0),
('david','admin-validacion-muro','view',0),
('david','admin-validacion-videos','edit',0),
('david','admin-validacion-videos','view',0),
('david','admin-videos','edit',0),
('david','admin-videos','view',0),
('david','admin-videos-comentarios','edit',0),
('david','admin-videos-comentarios','view',0),
('david','areas','edit',1),
('david','areas','view',1),
('david','areas_det','edit',1),
('david','areas_det','view',1),
('david','areas_form','edit',1),
('david','areas_form','view',1),
('david','blog','edit',1),
('david','blog','view',1),
('david','blog-list','edit',1),
('david','blog-list','view',1),
('david','cuestionario','edit',1),
('david','cuestionario','view',1),
('david','foro-comentarios','edit',1),
('david','foro-comentarios','view',1),
('david','foro-subtemas','edit',1),
('david','foro-subtemas','view',1),
('david','fotos','edit',1),
('david','fotos','view',1),
('david','home','view',1),
('david','info','edit',1),
('david','info','view',1),
('david','info-det','edit',1),
('david','info-det','view',1),
('david','infotopdf','edit',1),
('david','infotopdf','view',1),
('david','infotopdf-det','edit',1),
('david','infotopdf-det','view',1),
('david','muro','edit',1),
('david','muro','view',1),
('david','muro-comentarios','edit',1),
('david','muro-comentarios','view',1),
('david','muro-comentarios-respuestas','edit',1),
('david','muro-comentarios-respuestas','view',1),
('david','pagename','edit',1),
('david','pagename','view',1),
('david','profile_ok','edit',1),
('david','profile_ok','view',1),
('david','ranking','edit',1),
('david','ranking','view',1),
('david','ranking-empresas','edit',1),
('david','ranking-empresas','view',1),
('david','user-campaign','edit',1),
('david','user-campaign','view',1),
('david','user-campaigns','edit',1),
('david','user-campaigns','view',1),
('david','user-info','edit',1),
('david','user-info','view',1),
('david','user-info-all','edit',1),
('david','user-info-all','view',1),
('david','user-infotopdf','edit',1),
('david','user-infotopdf','view',1),
('david','user-infotopdf-all','edit',1),
('david','user-infotopdf-all','view',1),
('david','user-list','edit',1),
('david','user-list','view',1),
('david','user-lists','edit',1),
('david','user-lists','view',1),
('david','user-message','edit',1),
('david','user-message','view',1),
('david','user-message-preview','edit',1),
('david','user-message-preview','view',1),
('david','user-messages','edit',1),
('david','user-messages','view',1),
('david','user-perfil','edit',1),
('david','user-perfil','view',1),
('david','user-templates','edit',1),
('david','user-templates','view',1),
('david','users-conn','edit',1),
('david','users-conn','view',1),
('david','video','edit',1),
('david','video','view',1),
('borja','admin-blog-foro','view',0),
('borja','admin-blog-foro','edit',0),
('borja','admin-blog-new','view',0),
('borja','admin-blog-new','edit',0),
('borja','admin-blog','view',0),
('borja','admin-blog','edit',0),
('borja','blog-list','view',1),
('borja','blog-list','edit',1),
('borja','blog','view',1),
('borja','blog','edit',1),
('borja','admin-validacion-foro-comentarios','view',0),
('borja','admin-validacion-foro-comentarios','edit',0),
('borja','admin-validacion-foro-temas','view',0),
('borja','admin-validacion-foro-temas','edit',0),
('borja','foro-comentarios','view',1),
('borja','foro-comentarios','edit',1),
('borja','foro-subtemas','view',1),
('borja','foro-subtemas','edit',1);

/*Table structure for table `users_puntuaciones` */

DROP TABLE IF EXISTS `users_puntuaciones`;

CREATE TABLE `users_puntuaciones` (
  `id_puntuacion` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `puntuacion_username` varchar(100) NOT NULL DEFAULT '',
  `puntuacion_puntos` int(11) NOT NULL DEFAULT '0',
  `puntuacion_motivo` varchar(250) NOT NULL DEFAULT '',
  `puntuacion_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_puntuacion`)
) ENGINE=MyISAM AUTO_INCREMENT=607 DEFAULT CHARSET=utf8;

/*Data for the table `users_puntuaciones` */

insert  into `users_puntuaciones`(`id_puntuacion`,`puntuacion_username`,`puntuacion_puntos`,`puntuacion_motivo`,`puntuacion_date`) values 
(116,'david',1,'Acceso semanal','2014-07-17 14:03:28'),
(117,'admin',1,'Acceso semanal','2014-07-23 10:16:49'),
(118,'admin',5,'Comentario en el foro semanal','2014-07-24 13:59:45'),
(119,'admin',0,'Comentario en el foro','2014-07-24 13:59:45'),
(120,'admin',0,'Comentario en el foro','2014-07-24 14:00:10'),
(121,'admin',1,'Acceso semanal','2014-07-28 10:23:33'),
(122,'admin',0,'Comentario en el muro','2014-07-29 14:46:12'),
(123,'admin',0,'Comentario en el muro','2014-07-29 14:46:57'),
(124,'admin',0,'Comentario en el muro','2014-07-30 10:44:49'),
(125,'admin',0,'Comentario en el muro','2014-07-30 10:44:52'),
(126,'admin',0,'Comentario en el muro','2014-07-30 10:44:55'),
(127,'admin',0,'Comentario en el muro','2014-07-30 10:44:59'),
(128,'admin',0,'Comentario en el muro','2014-07-30 11:57:02'),
(129,'admin',1,'Acceso semanal','2014-08-04 10:34:30'),
(130,'admin',1,'Acceso semanal','2014-08-11 09:02:47'),
(131,'david',1,'Acceso semanal','2014-08-11 13:01:24'),
(132,'admin',1,'Acceso semanal','2014-08-19 09:56:28'),
(133,'admin',1,'Acceso semanal','2014-08-27 13:23:13'),
(134,'david',1,'Acceso semanal','2014-08-29 08:40:26'),
(135,'admin',1,'Acceso semanal','2014-09-08 18:07:54'),
(136,'admin',0,'Subida de foto','2014-09-10 11:15:27'),
(137,'admin',5,'Comentario en el foro semanal','2014-09-10 14:10:13'),
(138,'admin',0,'Comentario en el foro','2014-09-10 14:10:13'),
(139,'david',1,'Acceso semanal','2014-09-11 12:56:49'),
(140,'admin',1,'Acceso semanal','2014-09-15 08:32:22'),
(141,'admin',0,'Subida de foto','2014-09-15 13:35:46'),
(142,'admin',0,'Comentario en el muro','2014-09-18 10:31:00'),
(143,'david',1,'Acceso semanal','2014-09-18 16:20:54'),
(144,'david',0,'Comentario en el muro','2014-09-18 16:21:26'),
(145,'admin',1,'Acceso semanal','2014-09-21 01:25:59'),
(146,'david',1,'Acceso semanal','2014-09-22 11:21:03'),
(147,'david',0,'Comentario en el muro','2014-09-23 12:47:45'),
(148,'david',0,'Comentario en el muro','2014-09-23 12:47:50'),
(149,'admin',0,'Comentario en el muro','2014-09-23 12:48:19'),
(150,'admin',5,'Subida de foto','2014-09-23 16:30:54'),
(151,'admin',5,'Subida de foto','2014-09-23 16:32:32'),
(152,'admin',5,'Subida de foto','2014-09-23 16:55:19'),
(153,'admin',5,'Subida de foto','2014-09-23 17:02:14'),
(154,'admin',5,'Subida de foto','2014-09-23 17:02:17'),
(155,'admin',5,'Subida de foto','2014-09-23 17:02:21'),
(156,'admin',5,'Subida de foto','2014-09-23 17:02:25'),
(157,'admin',5,'Subida de foto','2014-09-24 10:13:25'),
(158,'admin',5,'Subida de foto','2014-09-24 10:16:37'),
(159,'admin',5,'Subida de foto','2014-09-24 10:20:55'),
(160,'admin',5,'Subida de foto','2014-09-24 10:23:18'),
(161,'admin',5,'Subida de foto','2014-09-24 10:23:22'),
(162,'admin',5,'Subida de foto','2014-09-24 10:25:13'),
(163,'admin',5,'Subida de foto','2014-09-24 10:25:16'),
(164,'admin',5,'Subida de foto','2014-09-24 11:02:16'),
(165,'admin',5,'Subida de foto','2014-09-24 11:05:26'),
(166,'admin',5,'Subida de foto','2014-09-24 11:05:34'),
(167,'admin',5,'Subida de foto','2014-09-24 11:05:38'),
(168,'admin',5,'Subida de foto','2014-09-24 11:05:44'),
(169,'admin',5,'Subida de foto','2014-09-24 15:46:01'),
(170,'admin',5,'Subida de foto','2014-09-24 15:46:06'),
(171,'admin',5,'Subida de foto','2014-09-24 15:46:12'),
(172,'admin',5,'Subida de foto','2014-09-24 15:46:18'),
(173,'admin',5,'Subida de foto','2014-09-24 15:46:23'),
(174,'admin',5,'Subida de foto','2014-09-24 15:46:31'),
(175,'admin',5,'Subida de foto','2014-09-24 15:46:38'),
(176,'admin',5,'Subida de foto','2014-09-24 15:59:07'),
(177,'admin',5,'Subida de foto','2014-09-24 15:59:13'),
(178,'admin',5,'Subida de foto','2014-09-24 15:59:23'),
(179,'admin',5,'Subida de foto','2014-09-24 15:59:30'),
(180,'admin',5,'Subida de foto','2014-09-24 15:59:36'),
(181,'admin',5,'Subida de foto','2014-09-24 16:05:46'),
(182,'admin',5,'Subida de foto','2014-09-24 16:05:52'),
(183,'admin',5,'Subida de foto','2014-09-24 16:06:02'),
(184,'admin',5,'Subida de foto','2014-09-24 16:06:11'),
(185,'admin',5,'Subida de foto','2014-09-24 16:06:18'),
(186,'admin',5,'Subida de foto','2014-09-24 16:06:22'),
(187,'admin',5,'Subida de foto','2014-09-24 16:06:29'),
(188,'admin',5,'Subida de foto','2014-09-24 16:08:32'),
(189,'admin',5,'Subida de foto','2014-09-24 16:08:43'),
(190,'admin',5,'Subida de foto','2014-09-24 16:08:49'),
(191,'admin',5,'Subida de foto','2014-09-24 16:18:56'),
(192,'admin',5,'Subida de foto','2014-09-24 16:19:03'),
(193,'admin',5,'Subida de foto','2014-09-24 16:19:09'),
(194,'admin',5,'Subida de foto','2014-09-24 16:19:15'),
(195,'admin',5,'Subida de foto','2014-09-24 16:19:21'),
(196,'admin',5,'Subida de foto','2014-09-24 16:19:27'),
(197,'admin',5,'Subida de foto','2014-09-24 16:19:32'),
(198,'admin',5,'Subida de foto','2014-09-24 16:19:37'),
(199,'admin',5,'Subida de foto','2014-09-24 16:19:42'),
(200,'admin',5,'Subida de foto','2014-09-24 16:19:48'),
(201,'admin',5,'Subida de foto','2014-09-24 16:19:54'),
(202,'admin',5,'Comentario en el foro semanal','2014-09-26 12:38:16'),
(203,'admin',0,'Comentario en el foro','2014-09-26 12:38:16'),
(204,'admin',0,'Comentario en el foro','2014-09-26 12:38:34'),
(205,'admin',0,'Comentario en el foro','2014-09-26 12:38:45'),
(206,'admin',5,'Subida de foto','2014-09-26 14:09:42'),
(207,'admin',5,'Subida de foto','2014-09-26 14:09:52'),
(208,'admin',1,'Acceso semanal','2014-09-29 08:43:11'),
(209,'admin',5,'Comentario en el foro semanal','2014-09-29 13:50:51'),
(210,'admin',0,'Comentario en el foro','2014-09-29 13:50:51'),
(211,'admin',0,'Comentario en el foro','2014-09-29 13:51:12'),
(212,'david',1,'Acceso semanal','2014-09-29 17:49:15'),
(213,'david',0,'Comentario en el muro','2014-09-29 18:01:26'),
(214,'admin',0,'Comentario en el foro','2014-09-30 10:33:54'),
(215,'admin',0,'Comentario en el foro','2014-09-30 10:34:17'),
(216,'admin',0,'Comentario en el foro','2014-09-30 10:35:04'),
(217,'admin',0,'Comentario en el foro','2014-09-30 10:37:20'),
(218,'admin',0,'Comentario en el foro','2014-09-30 10:40:52'),
(219,'admin',0,'Comentario en el foro','2014-10-03 10:40:18'),
(220,'admin',0,'Comentario en el foro','2014-10-03 10:42:31'),
(221,'admin',1,'Acceso semanal','2014-10-08 13:03:51'),
(222,'admin',5,'Comentario en el foro semanal','2014-10-09 11:51:16'),
(223,'admin',0,'Comentario en el foro','2014-10-09 11:51:16'),
(224,'admin',0,'Comentario en el foro','2014-10-09 11:51:26'),
(225,'admin',0,'Comentario en el foro','2014-10-09 11:51:35'),
(226,'admin',0,'Comentario en el foro','2014-10-09 16:44:03'),
(227,'admin',0,'Comentario en el foro','2014-10-09 18:19:07'),
(228,'admin',0,'Comentario en el foro','2014-10-10 12:19:59'),
(229,'admin',0,'Comentario en el foro','2014-10-10 12:28:39'),
(230,'admin',0,'Comentario en el foro','2014-10-10 15:07:12'),
(231,'david',1,'Acceso semanal','2014-10-11 18:05:44'),
(232,'david',5,'Comentario en el foro semanal','2014-10-11 18:14:19'),
(233,'david',0,'Comentario en el foro','2014-10-11 18:14:19'),
(234,'david',1,'Acceso semanal','2014-10-12 01:19:06'),
(235,'david',0,'Comentario en el muro','2014-10-12 01:33:45'),
(236,'david',0,'Comentario en el muro','2014-10-12 01:35:53'),
(237,'admin',1,'Acceso semanal','2014-10-13 09:21:49'),
(238,'pedro',5,'Finalización del curso','2014-10-14 14:01:16'),
(239,'ADMIN',-3,'Porque s','2014-10-14 14:13:00'),
(240,'PEDRO',2,'Finalizaci','2014-10-14 14:13:00'),
(241,'ADMIN',-3,'Porque s','2014-10-14 14:13:51'),
(242,'PEDRO',2,'Finalizaci','2014-10-14 14:13:51'),
(243,'admin',5,'Comentario en el foro semanal','2014-10-15 12:27:11'),
(244,'admin',0,'Comentario en el foro','2014-10-15 12:27:11'),
(245,'08932984Z',1,'Acceso semanal','2014-10-17 11:50:19'),
(246,'admin',0,'Comentario en el muro','2014-10-17 17:04:53'),
(247,'admin',1,'Acceso semanal','2014-10-20 08:53:33'),
(248,'david',1,'Acceso semanal','2014-10-20 13:56:29'),
(249,'admin',5,'Comentario en el foro semanal','2014-10-22 17:49:41'),
(250,'admin',0,'Comentario en el foro','2014-10-22 17:49:41'),
(251,'admin',0,'Comentario en el foro','2014-10-23 13:44:35'),
(252,'admin',0,'Comentario en el foro','2014-10-24 11:39:22'),
(253,'admin',0,'Comentario en el foro','2014-10-24 11:39:35'),
(254,'admin',1,'Acceso semanal','2014-10-27 08:51:33'),
(255,'david',1,'Acceso semanal','2014-10-27 09:43:58'),
(256,'admin',1,'Acceso semanal','2014-11-03 10:38:50'),
(257,'admin',5,'Comentario en el foro semanal','2014-11-07 12:16:15'),
(258,'admin',0,'Comentario en el foro','2014-11-07 12:16:15'),
(259,'david',1,'Acceso semanal','2014-11-07 17:07:27'),
(260,'admin',1,'Acceso semanal','2014-11-10 10:39:46'),
(261,'admin',1,'Acceso semanal','2014-11-17 15:51:14'),
(262,'david',1,'Acceso semanal','2014-11-18 12:28:22'),
(263,'20266370N',1,'Acceso semanal','2014-11-19 11:12:12'),
(264,'admin',1,'Acceso semanal','2014-11-24 10:09:11'),
(265,'admin',5,'Comentario en el foro semanal','2014-11-28 13:09:42'),
(266,'admin',0,'Comentario en el foro','2014-11-28 13:09:42'),
(267,'admin',0,'Comentario en el foro','2014-11-28 13:10:34'),
(268,'admin',0,'Comentario en el foro','2014-11-28 13:11:23'),
(269,'admin',0,'Comentario en el foro','2014-11-28 13:11:34'),
(270,'admin',0,'Comentario en el foro','2014-11-28 13:11:59'),
(271,'admin',0,'Comentario en el foro','2014-11-28 13:14:44'),
(272,'admin',0,'Comentario en el foro','2014-11-28 13:16:18'),
(273,'david',1,'Acceso semanal','2014-11-28 13:16:49'),
(274,'david',0,'Comentario en el muro','2014-11-28 13:16:59'),
(275,'david',5,'Comentario en el foro semanal','2014-11-28 13:17:29'),
(276,'david',0,'Comentario en el foro','2014-11-28 13:17:29'),
(277,'admin',0,'Comentario en el foro','2014-11-28 13:19:17'),
(278,'admin',0,'Comentario en el foro','2014-11-28 13:20:58'),
(279,'david',0,'Comentario en el foro','2014-11-28 14:09:56'),
(280,'david',0,'Comentario en el foro','2014-11-28 18:02:25'),
(281,'admin',0,'Comentario en el muro','2014-11-28 18:18:53'),
(282,'admin',0,'Comentario en el foro','2014-11-28 18:20:19'),
(283,'admin',0,'Comentario en el foro','2014-11-28 18:21:22'),
(284,'admin',0,'Comentario en el foro','2014-11-28 18:22:18'),
(285,'admin',0,'Comentario en el foro','2014-11-28 18:23:54'),
(286,'admin',0,'Comentario en el foro','2014-11-28 20:06:41'),
(287,'admin',1,'Acceso semanal','2014-12-01 13:32:58'),
(288,'david',1,'Acceso semanal','2014-12-02 13:52:39'),
(289,'borja',1,'Acceso semanal','2014-12-03 13:28:37'),
(290,'admin',5,'Comentario en el foro semanal','2014-12-03 13:30:06'),
(291,'admin',0,'Comentario en el foro','2014-12-03 13:30:06'),
(292,'admin',0,'Comentario en el muro','2014-12-04 12:02:23'),
(293,'admin',0,'Comentario en el muro','2014-12-04 12:03:28'),
(294,'admin',0,'Comentario en el muro','2014-12-04 12:04:22'),
(295,'admin',0,'Comentario en el muro','2014-12-04 12:05:44'),
(296,'admin',0,'Comentario en el muro','2014-12-04 12:16:18'),
(297,'admin',0,'Comentario en el muro','2014-12-04 12:45:28'),
(298,'admin',0,'Comentario en el muro','2014-12-04 13:01:03'),
(299,'admin',0,'Comentario en el muro','2014-12-04 13:02:23'),
(300,'admin',0,'Comentario en el muro','2014-12-04 13:05:51'),
(301,'admin',0,'Comentario en el foro','2014-12-04 13:11:20'),
(302,'admin',0,'Comentario en el foro','2014-12-04 13:12:36'),
(303,'admin',0,'Comentario en el foro','2014-12-04 13:12:45'),
(304,'admin',0,'Comentario en el foro','2014-12-04 13:13:05'),
(305,'admin',0,'Comentario en el foro','2014-12-04 13:13:50'),
(306,'admin',0,'Comentario en el foro','2014-12-04 13:22:46'),
(307,'admin',0,'Comentario en el muro','2014-12-04 14:14:00'),
(308,'admin',0,'Comentario en el muro','2014-12-04 14:14:14'),
(309,'admin',1,'Acceso semanal','2014-12-09 13:28:55'),
(310,'admin',10,'Superación curso ID: 9','2014-12-10 09:55:43'),
(311,'admin',1,'Acceso semanal','2014-12-15 09:52:54'),
(312,'admin',8,'Superación curso ID: 10','2014-12-16 12:46:39'),
(313,'admin',0,'Comentario en el muro','2014-12-18 09:34:32'),
(314,'admin',1,'Acceso semanal','2014-12-22 08:37:55'),
(315,'20266370N',1,'Acceso semanal','2014-12-27 00:32:13'),
(316,'david',1,'Acceso semanal','2014-12-27 00:37:24'),
(317,'dgarcia',1,'Acceso semanal','2014-12-27 00:43:39'),
(318,'admin',1,'Acceso semanal','2014-12-29 16:29:28'),
(319,'dgarcia',1,'Acceso semanal','2014-12-31 08:29:31'),
(320,'admin',1,'Acceso semanal','2014-12-31 10:37:05'),
(321,'admin',1,'Acceso semanal','2015-01-07 17:03:21'),
(322,'admin',1,'Acceso semanal','2015-01-15 09:01:25'),
(323,'admin',1,'Acceso semanal','2015-01-20 10:18:34'),
(324,'david',1,'Acceso semanal','2015-01-21 13:52:27'),
(325,'pedro',1,'Acceso semanal','2015-01-21 13:55:48'),
(326,'admin',1,'Acceso semanal','2015-01-27 16:01:09'),
(327,'admin',1,'Acceso semanal','2015-02-02 09:40:05'),
(328,'dcancho',1,'Acceso semanal','2015-02-17 10:06:07'),
(329,'dcancho',5,'Comentario en el foro semanal','2015-02-17 10:07:16'),
(330,'dcancho',0,'Comentario en el foro','2015-02-17 10:07:16'),
(331,'admin',1,'Acceso semanal','2015-02-18 13:35:50'),
(332,'admin',5,'Comentario en el foro semanal','2015-02-19 10:05:07'),
(333,'admin',0,'Comentario en el foro','2015-02-19 10:05:07'),
(334,'admin',1,'Acceso semanal','2015-02-26 08:50:27'),
(335,'dcancho',1,'Acceso semanal','2015-02-27 08:50:18'),
(336,'admin',0,'Comentario en el muro','2015-02-27 09:10:53'),
(337,'admin',5,'Comentario en el foro semanal','2015-02-27 12:14:43'),
(338,'admin',0,'Comentario en el foro','2015-02-27 12:14:43'),
(339,'cgomez',1,'Acceso semanal','2015-02-27 14:12:36'),
(340,'admin',5,'Subida de foto','2015-02-28 00:03:56'),
(341,'claudio',1,'Acceso semanal','2015-02-28 00:19:27'),
(342,'claudio',0,'Comentario en el muro','2015-02-28 00:23:43'),
(343,'admin',0,'Comentario en el foro','2015-02-28 00:29:03'),
(344,'dcancho',0,'Comentario en el muro','2015-02-28 00:30:40'),
(345,'dcancho',5,'Comentario en el foro semanal','2015-02-28 00:31:09'),
(346,'dcancho',0,'Comentario en el foro','2015-02-28 00:31:09'),
(347,'dcancho',0,'Comentario en el foro','2015-02-28 00:31:54'),
(348,'dcancho',5,'Subida de foto','2015-02-28 00:33:48'),
(349,'claudio',5,'Comentario en el foro semanal','2015-02-28 00:39:36'),
(350,'claudio',0,'Comentario en el foro','2015-02-28 00:39:36'),
(351,'claudio',0,'Comentario en el foro','2015-02-28 00:42:14'),
(352,'claudio',0,'Comentario en el foro','2015-02-28 00:44:20'),
(353,'dcancho',0,'Comentario en el foro','2015-02-28 00:59:12'),
(354,'admin',1,'Acceso semanal','2015-03-02 09:47:22'),
(355,'admin',5,'Comentario en el foro semanal','2015-03-02 10:46:27'),
(356,'admin',0,'Comentario en el foro','2015-03-02 10:46:27'),
(357,'admin',1,'Acceso semanal','2015-03-09 10:55:47'),
(358,'pedro',1,'Acceso semanal','2015-03-11 09:31:38'),
(359,'borja',1,'Acceso semanal','2015-03-11 10:35:33'),
(360,'borja',0,'Comentario en el muro','2015-03-14 01:04:29'),
(361,'borja',5,'Subida de foto','2015-03-14 01:38:18'),
(362,'admin',1,'Acceso semanal','2015-03-15 00:25:39'),
(363,'borja',1,'Acceso semanal','2015-03-15 01:53:46'),
(364,'admin',5,'Comentario en el foro semanal','2015-03-15 03:03:04'),
(365,'admin',0,'Comentario en el foro','2015-03-15 03:03:04'),
(366,'claudio',1,'Acceso semanal','2015-03-18 10:25:20'),
(367,'claudio',0,'Comentario en el muro','2015-03-18 10:32:19'),
(368,'claudio',0,'Comentario en el muro','2015-03-18 10:34:49'),
(369,'claudio',0,'Comentario en el muro','2015-03-18 10:36:05'),
(370,'claudio',0,'Comentario en el muro','2015-03-18 10:37:38'),
(371,'claudio',0,'Comentario en el muro','2015-03-18 10:39:08'),
(372,'claudio',0,'Comentario en el muro','2015-03-18 10:39:12'),
(373,'admin',0,'Comentario en el muro','2015-03-18 10:39:24'),
(374,'admin',0,'Comentario en el muro','2015-03-18 10:39:28'),
(375,'admin',0,'Comentario en el muro','2015-03-18 10:39:32'),
(376,'admin',0,'Comentario en el foro','2015-03-20 19:31:58'),
(377,'admin',1,'Acceso semanal','2015-03-24 15:36:12'),
(378,'admin',1,'Acceso semanal','2015-04-06 14:20:43'),
(379,'admin',1,'Acceso semanal','2015-04-13 17:53:40'),
(380,'admin',1,'Acceso semanal','2015-04-24 09:21:20'),
(381,'admin',1,'Acceso semanal','2015-05-05 15:43:51'),
(382,'admin',1,'Acceso semanal','2015-05-17 12:15:32'),
(383,'admin',1,'Acceso semanal','2015-05-29 13:52:29'),
(384,'admin',1,'Acceso semanal','2015-06-01 08:58:41'),
(385,'admin',0,'Comentario en el muro','2015-06-02 17:39:49'),
(386,'admin',1,'Acceso semanal','2015-06-11 09:51:46'),
(387,'borja',1,'Acceso semanal','2015-06-13 01:48:46'),
(388,'borja',0,'Comentario en el muro','2015-06-13 01:50:14'),
(389,'borja',5,'Comentario en el foro semanal','2015-06-13 01:51:35'),
(390,'borja',0,'Comentario en el foro','2015-06-13 01:51:35'),
(391,'admin',1,'Acceso semanal','2015-06-14 00:49:19'),
(392,'admin',1,'Acceso semanal','2015-08-03 08:57:18'),
(393,'borja',1,'Acceso semanal','2015-08-03 13:09:31'),
(394,'admin',1,'Acceso semanal','2015-08-04 09:20:55'),
(395,'',1,'Acceso semanal','2015-08-04 09:33:18'),
(396,'',1,'Acceso semanal','2015-08-04 10:25:27'),
(397,'',1,'Acceso semanal','2015-08-07 10:51:09'),
(398,'',1,'Acceso semanal','2015-08-10 08:38:50'),
(399,'',1,'Acceso semanal','2015-08-10 08:39:06'),
(400,'',1,'Acceso semanal','2015-08-14 10:18:11'),
(401,'pedro',0,'Comentario en el muro','2015-08-14 10:18:32'),
(402,'',1,'Acceso semanal','2015-08-14 13:17:24'),
(403,'',1,'Acceso semanal','2015-08-14 13:20:16'),
(404,'',1,'Acceso semanal','2015-08-17 08:28:52'),
(405,'',1,'Acceso semanal','2015-09-09 09:58:03'),
(406,'admin',5,'Comentario en el foro semanal','2015-09-09 17:43:41'),
(407,'admin',0,'Comentario en el foro','2015-09-09 17:43:41'),
(408,'admin',0,'Comentario en el foro','2015-09-09 17:43:51'),
(409,'admin',0,'Comentario en el foro','2015-09-09 17:43:59'),
(410,'admin',0,'Comentario en el foro','2015-09-09 17:44:03'),
(411,'admin',0,'Comentario en el foro','2015-09-09 17:44:07'),
(412,'admin',0,'Comentario en el foro','2015-09-09 17:44:11'),
(413,'admin',0,'Comentario en el foro','2015-09-09 17:44:15'),
(414,'admin',0,'Comentario en el foro','2015-09-09 17:44:25'),
(415,'admin',0,'Comentario en el foro','2015-09-09 17:44:43'),
(416,'admin',0,'Comentario en el foro','2015-09-09 17:44:57'),
(417,'admin',0,'Comentario en el foro','2015-09-11 13:46:59'),
(418,'admin',0,'Comentario en el foro','2015-09-11 13:47:13'),
(419,'admin',0,'Comentario en el foro','2015-09-11 13:47:22'),
(420,'admin',0,'Comentario en el foro','2015-09-11 13:47:33'),
(421,'',1,'Acceso semanal','2015-09-16 10:03:11'),
(422,'',1,'Acceso semanal','2015-09-16 10:03:39'),
(423,'',1,'Acceso semanal','2015-09-22 11:49:08'),
(424,'',1,'Acceso semanal','2015-09-28 08:59:46'),
(425,'admin',0,'Comentario en el muro','2015-09-28 09:02:00'),
(426,'',1,'Acceso semanal','2015-09-28 09:24:42'),
(427,'admin',5,'Subida de foto','2015-09-28 09:39:43'),
(428,'admin',5,'Comentario en el foro semanal','2015-09-28 09:46:56'),
(429,'admin',0,'Comentario en el foro','2015-09-28 09:46:56'),
(430,'admin',0,'Comentario en el muro','2015-09-28 10:35:55'),
(431,'admin',0,'Comentario en el foro','2015-10-03 02:25:38'),
(432,'',1,'Acceso semanal','2015-10-03 03:54:24'),
(433,'',1,'Acceso semanal','2015-10-05 10:12:41'),
(434,'admin',5,'Comentario en el foro semanal','2015-10-05 11:25:31'),
(435,'admin',0,'Comentario en el foro','2015-10-05 11:25:31'),
(436,'',1,'Acceso semanal','2015-10-13 15:58:40'),
(437,'admin',5,'Comentario en el foro semanal','2015-10-16 11:07:10'),
(438,'admin',0,'Comentario en el foro','2015-10-16 11:07:10'),
(439,'admin',0,'Comentario en el foro','2015-10-16 11:39:57'),
(440,'admin',0,'Comentario en el foro','2015-10-16 11:40:08'),
(441,'admin',0,'Comentario en el foro','2015-10-16 11:40:17'),
(442,'',1,'Acceso semanal','2015-10-19 15:24:24'),
(443,'admin',0,'Comentario en el muro','2015-10-19 15:37:56'),
(444,'',1,'Acceso semanal','2015-10-22 16:30:19'),
(445,'pedro',5,'Comentario en el foro semanal','2015-10-22 16:30:45'),
(446,'pedro',0,'Comentario en el foro','2015-10-22 16:30:46'),
(447,'pedro',0,'Comentario en el muro','2015-10-22 16:30:55'),
(448,'pedro',0,'Comentario en el foro','2015-10-22 16:34:52'),
(449,'pedro',0,'Comentario en el foro','2015-10-22 16:35:29'),
(450,'',1,'Acceso semanal','2015-10-26 15:51:40'),
(451,'',1,'Acceso semanal','2015-10-27 12:58:01'),
(452,'senen',5,'Comentario en el foro semanal','2015-10-27 13:20:59'),
(453,'senen',0,'Comentario en el foro','2015-10-27 13:20:59'),
(454,'admin',0,'Comentario en el muro','2015-10-27 16:42:55'),
(455,'admin',0,'Comentario en el muro','2015-10-28 08:37:07'),
(456,'admin',0,'Comentario en el muro','2015-10-28 08:37:11'),
(457,'admin',0,'Comentario en el muro','2015-10-28 08:48:35'),
(458,'admin',0,'Comentario en el muro','2015-10-28 08:54:26'),
(459,'admin',5,'Comentario en el foro semanal','2015-10-28 12:57:24'),
(460,'admin',0,'Comentario en el foro','2015-10-28 12:57:24'),
(461,'',1,'Acceso semanal','2015-11-03 12:43:18'),
(462,'',1,'Acceso semanal','2015-11-12 12:17:16'),
(463,'admin',5,'Comentario en el foro semanal','2015-11-12 17:16:05'),
(464,'admin',0,'Comentario en el foro','2015-11-12 17:16:06'),
(465,'admin',0,'Comentario en el foro','2015-11-12 17:16:23'),
(466,'',1,'Acceso semanal','2015-11-16 12:59:55'),
(467,'',1,'Acceso semanal','2015-11-24 08:59:15'),
(468,'',1,'Acceso semanal','2015-12-10 12:13:09'),
(469,'',1,'Acceso semanal','2015-12-15 09:12:43'),
(470,'',1,'Acceso semanal','2015-12-18 09:42:43'),
(471,'',1,'Acceso semanal','2015-12-30 10:31:48'),
(472,'',1,'Acceso semanal','2016-01-18 16:26:12'),
(473,'admin',0,'Comentario en el muro','2016-01-19 08:44:53'),
(474,'admin',0,'Comentario en el muro','2016-01-19 08:48:28'),
(475,'admin',0,'Comentario en el muro','2016-01-19 08:48:36'),
(476,'admin',0,'Comentario en el muro','2016-01-19 09:30:43'),
(477,'admin',0,'Comentario en el muro','2016-01-19 09:31:03'),
(478,'',1,'Acceso semanal','2016-01-19 11:17:48'),
(479,'borja',0,'Comentario en el muro','2016-01-19 11:17:58'),
(480,'',1,'Acceso semanal','2016-01-19 11:21:44'),
(481,'dgarcia',0,'Comentario en el muro','2016-01-19 11:25:22'),
(482,'admin',0,'Comentario en el muro','2016-01-19 11:27:14'),
(483,'borja',0,'Comentario en el muro','2016-01-19 11:27:39'),
(484,'',1,'Acceso semanal','2016-01-19 12:52:15'),
(485,'pedro',5,'Subida de foto','2016-01-19 13:10:51'),
(486,'admin',0,'Comentario en el muro','2016-01-20 15:56:08'),
(487,'',1,'Acceso semanal','2016-02-01 15:41:25'),
(488,'admin',2,'Superación curso ID: 15','2016-02-02 17:06:01'),
(489,'admin',4,'Superación curso ID: 15','2016-02-02 17:08:46'),
(490,'',1,'Acceso semanal','2016-02-09 18:22:08'),
(491,'',1,'Acceso semanal','2016-02-22 16:23:58'),
(492,'',1,'Acceso semanal','2016-02-26 10:45:15'),
(493,'',1,'Acceso semanal','2016-02-26 10:59:12'),
(494,'',1,'Acceso semanal','2016-02-26 11:56:37'),
(495,'',1,'Acceso semanal','2016-02-26 12:28:03'),
(496,'admin',5,'ganador reto gamificacion','2016-02-26 12:28:33'),
(497,'senen',-5,'perdedor reto gamificacion','2016-02-26 12:28:33'),
(498,'',1,'Acceso semanal','2016-02-26 12:29:26'),
(499,'david',5,'ganador reto gamificacion','2016-02-26 12:30:37'),
(500,'senen',-5,'perdedor reto gamificacion','2016-02-26 12:30:37'),
(501,'',1,'Acceso semanal','2016-03-01 15:06:57'),
(502,'',1,'Acceso semanal','2016-03-08 17:59:09'),
(503,'',1,'Acceso semanal','2016-03-09 10:09:58'),
(504,'',1,'Acceso semanal','2016-03-09 11:30:02'),
(505,'',1,'Acceso semanal','2016-03-09 12:34:59'),
(506,'claudio',5,'Comentario en el foro semanal','2016-03-09 13:29:24'),
(507,'claudio',0,'Comentario en el foro','2016-03-09 13:29:25'),
(508,'pedro',5,'Comentario en el foro semanal','2016-03-10 15:52:16'),
(509,'pedro',0,'Comentario en el foro','2016-03-10 15:52:16'),
(510,'',1,'Acceso semanal','2016-03-11 10:17:44'),
(511,'borja',15,'ganador reto gamificacion','2016-03-11 10:32:15'),
(512,'admin',-15,'perdedor reto gamificacion','2016-03-11 10:32:15'),
(513,'',1,'Acceso semanal','2016-03-14 08:44:00'),
(514,'admin',0,'Comentario en el muro','2016-03-14 09:19:14'),
(515,'',1,'Acceso semanal','2016-03-14 09:38:24'),
(516,'',1,'Acceso semanal','2016-03-14 10:16:48'),
(517,'dcancho',0,'Comentario en el muro','2016-03-14 10:17:47'),
(518,'admin',0,'Comentario en el muro','2016-03-14 10:18:15'),
(519,'',1,'Acceso semanal','2016-03-14 10:18:47'),
(520,'claudio',0,'Comentario en el muro','2016-03-14 10:18:57'),
(521,'admin',0,'Comentario en el muro','2016-03-14 10:19:35'),
(522,'admin',5,'Comentario en el foro semanal','2016-03-17 10:02:08'),
(523,'admin',0,'Comentario en el foro','2016-03-17 10:02:08'),
(524,'admin',0,'Comentario en el foro','2016-03-17 10:02:19'),
(525,'admin',5,'Subida de foto','2016-03-17 10:25:53'),
(526,'',1,'Acceso semanal','2016-03-21 17:08:10'),
(527,'',1,'Acceso semanal','2016-04-05 17:22:43'),
(528,'',1,'Acceso semanal','2016-04-11 11:41:37'),
(529,'admin',1,'Acceso semanal','2016-04-18 10:49:01'),
(530,'admin',1,'Acceso semanal','2016-04-25 13:25:46'),
(531,'borja',1,'Acceso semanal','2016-04-28 09:27:16'),
(532,'admin',1,'Acceso semanal','2016-05-05 09:56:57'),
(533,'admin',1,'Acceso semanal','2016-05-09 12:04:10'),
(534,'dcancho',1,'Acceso semanal','2016-05-10 14:08:17'),
(535,'borja',1,'Acceso semanal','2016-05-12 15:54:32'),
(536,'admin',1,'Acceso semanal','2016-05-17 13:34:46'),
(537,'admin',1,'Acceso semanal','2016-05-24 09:56:38'),
(538,'admin',5,'Comentario en el foro semanal','2016-05-26 10:47:49'),
(539,'admin',0,'Comentario en el foro','2016-05-26 10:47:49'),
(540,'admin',1,'Acceso semanal','2016-05-30 14:53:43'),
(541,'admin',1,'Acceso semanal','2016-06-14 09:43:27'),
(542,'admin',1,'Acceso semanal','2016-06-21 12:26:36'),
(543,'admin',1,'Acceso semanal','2016-06-28 17:43:12'),
(544,'admin',5,'Subida de foto','2016-06-30 13:58:52'),
(545,'admin',1,'Acceso semanal','2016-07-26 10:55:26'),
(546,'admin',1,'Acceso semanal','2016-08-03 09:58:04'),
(547,'admin',1,'Acceso semanal','2016-08-08 10:45:05'),
(548,'admin',1,'Acceso semanal','2016-08-17 13:26:57'),
(549,'admin',1,'Acceso semanal','2016-08-23 09:48:42'),
(550,'admin',1,'Acceso semanal','2016-08-29 12:17:32'),
(551,'admin',5,'Comentario en el foro semanal','2016-08-29 14:44:17'),
(552,'admin',0,'Comentario en el foro','2016-08-29 14:44:17'),
(553,'admin',1,'Acceso semanal','2016-09-08 13:31:57'),
(554,'admin',1,'Acceso semanal','2016-09-12 10:18:42'),
(555,'admin',1,'Acceso semanal','2016-09-26 17:15:26'),
(556,'admin',4,'Superación curso ID: 15','2016-09-30 12:54:08'),
(557,'admin',1,'Acceso semanal','2016-10-03 12:58:49'),
(558,'admin',1,'Acceso semanal','2016-10-14 08:35:32'),
(559,'admin',5,'Comentario en el foro semanal','2016-10-14 09:20:27'),
(560,'admin',0,'Comentario en el foro','2016-10-14 09:20:27'),
(561,'borja',1,'Acceso semanal','2016-10-14 09:40:37'),
(562,'jgonzalez',1,'Acceso semanal','2016-10-14 09:42:25'),
(563,'dramos',1,'Acceso semanal','2016-10-14 09:49:03'),
(564,'Redbull',1,'Acceso semanal','2016-10-14 09:57:36'),
(565,'admin',1,'Acceso semanal','2016-10-19 17:08:09'),
(566,'admin',0,'Comentario en el muro','2016-10-20 10:44:45'),
(567,'admin',0,'Comentario en el muro','2016-10-20 10:45:19'),
(568,'admin',5,'Comentario en el foro semanal','2016-10-20 10:47:16'),
(569,'admin',0,'Comentario en el foro','2016-10-20 10:47:16'),
(570,'admin',0,'Comentario en el foro','2016-10-20 10:50:46'),
(571,'admin',1,'Acceso semanal','2016-11-02 11:59:06'),
(572,'admin',1,'Acceso semanal','2016-11-07 09:03:02'),
(573,'admin',1,'Acceso semanal','2016-11-14 11:59:56'),
(574,'admin',5,'Comentario en el foro semanal','2016-11-16 10:36:16'),
(575,'admin',0,'Comentario en el foro','2016-11-16 10:36:16'),
(576,'admin',0,'Comentario en el foro','2016-11-16 10:36:30'),
(577,'admin',1,'Acceso semanal','2016-11-21 10:17:03'),
(578,'admin',5,'Comentario en el foro semanal','2016-11-23 16:19:15'),
(579,'admin',0,'Comentario en el foro','2016-11-23 16:19:15'),
(580,'admin',1,'Acceso semanal','2016-11-28 12:29:04'),
(581,'pedro',1,'Acceso semanal','2016-11-28 16:37:18'),
(582,'claudio',1,'Acceso semanal','2016-11-28 16:37:57'),
(583,'admin',5,'Subida de foto','2016-12-01 15:27:09'),
(584,'admin',1,'Acceso semanal','2016-12-07 17:37:14'),
(585,'admin',1,'Acceso semanal','2016-12-14 09:01:57'),
(586,'david',10,'','2016-12-14 12:39:47'),
(587,'borja',5,'','2016-12-14 12:39:47'),
(588,'pedro',21,'','2016-12-14 12:39:47'),
(589,'claudio',7,'','2016-12-14 12:39:47'),
(590,'20266370N',10,'','2016-12-14 12:39:47'),
(591,'dmarchante',5,'','2016-12-14 12:39:47'),
(592,'admin',1,'Acceso semanal','2016-12-19 08:18:18'),
(593,'pedro',1,'Acceso semanal','2016-12-19 09:49:19'),
(594,'borja',1,'Acceso semanal','2016-12-19 09:51:11'),
(595,'senen',1,'Acceso semanal','2016-12-19 11:12:36'),
(596,'borja',5,'Comentario en el foro semanal','2016-12-19 11:43:53'),
(597,'borja',0,'Comentario en el foro','2016-12-19 11:43:53'),
(598,'borja',0,'Comentario en el foro','2016-12-19 11:44:11'),
(599,'borja',0,'Comentario en el muro','2016-12-20 09:22:39'),
(600,'pedro',0,'Comentario en el muro','2016-12-20 09:23:27'),
(601,'pedro',0,'Comentario en el muro','2016-12-20 09:25:04'),
(602,'pedro',1,'Superación curso ID: 16','2016-12-21 16:33:25'),
(603,'admin',1,'Primer acceso a documento ID: 11','2016-12-22 09:22:48'),
(604,'admin',1,'Primer acceso a documento ID: 8','2016-12-22 09:26:05'),
(605,'pedro',1,'Primer acceso a documento ID: 12','2016-12-22 09:34:14'),
(606,'pedro',1,'Primer acceso a documento ID: 11','2016-12-22 09:34:35');

/*Table structure for table `users_tiendas` */

DROP TABLE IF EXISTS `users_tiendas`;

CREATE TABLE `users_tiendas` (
  `cod_tienda` varchar(100) CHARACTER SET latin1 NOT NULL,
  `nombre_tienda` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `regional_tienda` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `responsable_tienda` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `tipo_tienda` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT 'Franquicia',
  `direccion_tienda` varchar(250) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `cpostal_tienda` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `ciudad_tienda` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `provincia_tienda` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `telefono_tienda` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `email_tienda` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `activa` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cod_tienda`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `users_tiendas` */

insert  into `users_tiendas`(`cod_tienda`,`nombre_tienda`,`regional_tienda`,`responsable_tienda`,`tipo_tienda`,`direccion_tienda`,`cpostal_tienda`,`ciudad_tienda`,`provincia_tienda`,`telefono_tienda`,`email_tienda`,`activa`) values 
('0001','CENTRAL','','','Tienda propia','Av. Los Arces 234','28003','Madrid','Madrid','666 666 666','software@imagar.com',1),
('0002','TIENDAS PROPIAS','borja','pedro','Tienda propia','Paseo Redondo 45','28005','Madrid','Madrid','666 666 666','software@imagar.com',1),
('0003','FRANQUICIAS','borja','david','Franquicia','C/Recesbinto 89','28007','Madrid','Madrid','666 666 666','sistemas@imagar.com',1),
('1235','C.C. TRES AGUAS','borja','','Franquicia','C/Atenea 56 - Local 23','28921','Alcorcón','Madrid','666 666 666','software@imagar.com',1),
('1452','C.C. LA VAGUADA','regional','','Franquicia','Av. Los altos 51 - Local 11','28089','Madrid','Madrid','666 666 666','software@imagar.com',1),
('0004','TIENDASPROPIAS 2','regional','pedro','Franquicia','','','','','','',1);

/*Table structure for table `users_tiendas_ranking_category` */

DROP TABLE IF EXISTS `users_tiendas_ranking_category`;

CREATE TABLE `users_tiendas_ranking_category` (
  `id_ranking_category` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ranking_category_name` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id_ranking_category`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `users_tiendas_ranking_category` */

insert  into `users_tiendas_ranking_category`(`id_ranking_category`,`ranking_category_name`) values 
(3,'Top ventas'),
(4,'Top altas SW');

/*Table structure for table `users_tiendas_rankings` */

DROP TABLE IF EXISTS `users_tiendas_rankings`;

CREATE TABLE `users_tiendas_rankings` (
  `id_ranking` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_ranking_category` int(11) NOT NULL DEFAULT '0',
  `nombre_ranking` longtext CHARACTER SET latin1 NOT NULL,
  `descripcion_ranking` longtext CHARACTER SET latin1 NOT NULL,
  `activo` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '0 Inactivo; 1 activo; 2 eliminado',
  PRIMARY KEY (`id_ranking`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `users_tiendas_rankings` */

insert  into `users_tiendas_rankings`(`id_ranking`,`id_ranking_category`,`nombre_ranking`,`descripcion_ranking`,`activo`) values 
(1,4,'Mejor vendedor de ADSL','<p>En este ranking estar&aacute;n solo los mejores vendedores del mes.&nbsp;</p>\r\n',1),
(2,4,'Mejor vendedor de Canguro','<p>&iquest;Cu&aacute;ntas tarifas Canguro puedes llegar a vender? Compite, demu&eacute;stralo con tus compa&ntilde;eros. No te quedes atr&aacute;s&nbsp;</p>\r\n',1),
(3,3,'Orange Cash','<p>Si tu tienda est&aacute; en este ranking, es l&iacute;der en la venta de Orange Cash. Enhorabuena!!</p>\r\n',1),
(4,3,'Ranking de prueba','<p>Este es un ranking de prueba</p>\r\n',1),
(6,3,'Ranking de ventas','<p>En t&eacute;cnica de ventas</p>\r\n',1);

/*Table structure for table `users_tiendas_rankings_data` */

DROP TABLE IF EXISTS `users_tiendas_rankings_data`;

CREATE TABLE `users_tiendas_rankings_data` (
  `id_data` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_ranking` int(11) unsigned NOT NULL DEFAULT '0',
  `cod_tienda` varchar(100) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `value_ranking` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_data`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

/*Data for the table `users_tiendas_rankings_data` */

insert  into `users_tiendas_rankings_data`(`id_data`,`id_ranking`,`cod_tienda`,`value_ranking`) values 
(9,1,'UFARTE',7),
(8,1,'LOPEZ',1),
(7,1,'JUAN',0),
(6,1,'PILI',9),
(10,1,'BILABO',9),
(11,3,'27000002',25000),
(12,3,'27000026',1253),
(13,3,'27000002',1000),
(14,3,'27000024',200),
(24,4,'17000020',1),
(23,4,'27000002',12),
(22,4,'27000025',230),
(21,4,'47000011',3214),
(20,4,'77000007',12500);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
