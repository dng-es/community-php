Community-php
================================
Comunidad de usuarios php5 y mysql. Ver módulos en includes/modules (módulos con versión menor 1.0 no están completamente testeados o finalizados). Incluye soporte para idiomas, herramienta console para generación de módulos y otras tareas.

Instalación
================================
- Establecer configuración principal en el fichero: includes/core/config.php (<b>IMPORTANTE</b>: desactivar debug mode en servidores de producción)
- Eliminar carpeta ./bin en servidores de produccción
- Eliminar carpeta ./documentacion en servidores de produccción
- Eliminar archivo README.md
- Permisos de escritura en los directorios: images/usuarios, images/foro, images/mailing, docs/
- Establecer configuración CKFinder: modificar $baseUrl y $baseDir en js/CKFinder/config.php
- Establecer configuración de la comunidad desde el panel de administración->Datos generales


Requisitos y dependencias
================================
- PHP 5.3 o superior (TODO: para versiones 5.4 o superior modificar ereg_replace).
- FFMPEG para la conversión de videos. Librerias libx264 y libfaac necesarias.
- La hoja de estilos .CSS esta creada con SASS (styles.scss)
- Emplea Bootstrap v3.0.3 para la maquetación


Librerias de terceros
================================
- jQuery: (js/jquery.php) Javascript.
- Bootstrap: (css/bootstrap.min.css - js/bootstrap.min.js)
- Bootstrap Datepicker: (js/bootstrap-datepicker.js) Javascript. Datapicker para formularios
- Bootstrap Dropdown: (js/bootstrap-dropdown.js) Javascript. Incluye efecto de despligue de los dropdowns de bootstrap al hacer over sobre el elemento
- Bootstrap FileInput: (js/bootstrap.file-input.js) Javascript. modifica aspecto de los input file
- CKEditor: (js/ckeditor) Javascript. Editor WYSIWYG
- CKFinder: (js/ckfinder) Javascript. Subida de archivos integrado en CKEditor
- amCharts: (js/amcharts) Javascript. Generación de gráficos
- JWPlayer: (js/jwplayer) Javascript. Reproductor de video
- SwiftMailer: (includes/core/Swift-5.1.0) php. Envío de emials
- Zipfile: (includes/core/class.zipfile.php) php. Clase para generación de ficheros ZIP
- resizeImage: (includes/core/class.resizeimage.php) php. Clase para generar miniaturas de imágenes

Herramienta console
================================
- Descripción: Aplicación de consola para crear módulos. 
- Uso: "php bin/console parameters". Opciones de parameters:
	- createmodule: crea nuevo módulo con su estructura de directorios y ficheros básicos
	- showmodules: muestra todos los modulos con su información
	- findpage: encuentra una pagina. Muestra en que módulo se encuentra


Idiomas
================================
Soporte para idiomas implementado. Establecer idioma en includes/core/config.php. Los ficheros de traducciones se encuentran en includes/languages. Cada módulo cuenta con sus propios ficheros de traducciones en includes/modules/module_name/resources/languages

Debug mode
================================
Se puede activar desde includes/core/config.php con la variable debug_app. Si se activa se mostraran errores  de Php y Sql.

<b>IMPORTANTE</b>: desactivar debug mode en servidores de producción (debug_app = 0)


Estructura de archivos y directorios
================================
La estructura de archivos y directorios básica es la siguiente:

- <b>bin/</b> directorio donde se encuentra la herramienta de consola<br />
- <b>css/</b> archivos de estilos generales de la comunidad<br />
- <b>docs/</b> directorio de almacenamiento de documentos para los módulos<br />
- <b>documentacion/</b> documentación sobre la comunidad<br />
- <b>images/</b> imagenes generales de la comunidad<br />
- <b>includes/</b> archivos y directorios principales de la comunidad<br />
	- <b>core/</b> archivos que componen el núcleo del sistema<br />
	- <b>languages/</b> archivos generales de traducciones <br />
	- <b>modules/</b> directorio que contiene todos los módulos<br />
		- <b>my_module/</b> modulo de usuario
			- <b>controllers/</b> controladores del módulo<br />
			- <b>pages/</b> páginas del módulo<br />
			- <b>resources/</b> recursos del módulo (imagenes, javascript y traducciones específicas)<br />
				- <b>images/</b>
				- <b>js/</b>
				- <b>languages/</b>
			- <b>templates/</b> plantillas del módulo<br />
			- <b>class.my_module.php</b> acceso a la base de datos desde el módulo<br /> 
- <b>js/</b> archivos javascript generales de la comunidad