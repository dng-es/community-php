# Community-php 
> Comunidad de usuarios php5 y mysql. Ver módulos en includes/modules (módulos con versión menor 1.0 no están completamente testeados o finalizados). Incluye soporte para idiomas, herramienta console para generación de módulos y otras tareas.

* [Instalación] (#instalación)
* [Estructura de archivos y directorios] (#estructura-de-archivos-y-directorios)
* [Herramienta console] (#herramienta-console)
* [Idiomas] (#idiomas)
* [Debug mode] (#debug-mode)
* [Referencia API] (#referencia-api)

## Instalación
- Establecer configuración principal en el fichero: includes/core/config.php (<b>IMPORTANTE</b>: desactivar debug mode en servidores de producción o establecer salida a fichero de log)
- Eliminar carpeta ./bin en servidores de produccción
- Eliminar carpeta ./documentacion en servidores de produccción
- Eliminar archivo README.md
- Permisos de escritura en los directorios: images/usuarios, images/foro, images/mailing, docs/
- Establecer configuración CKFinder: modificar $baseUrl y $baseDir en js/libs/CKFinder/config.php
- Establecer configuración de la comunidad desde el panel de administración->Datos generales


### Requisitos y dependencias
- PHP 5.3 o superior.
- FFMPEG para la conversión de videos. Librerias libx264 y libfaac necesarias.
- La hoja de estilos .CSS esta creada con SASS (styles.scss)
- Emplea Bootstrap v3.0.3 para la maquetación


### Librerias de terceros 
- jQuery: (js/jquery.php) Javascript.
- Bootstrap: (css/bootstrap.min.css - js/bootstrap.min.js)
- Bootstrap Datepicker: (js/bootstrap-datepicker.js) Javascript. Datapicker para formularios
- Bootstrap Dropdown: (js/bootstrap-dropdown.js) Javascript. Incluye efecto de despligue de los dropdowns de bootstrap al hacer over sobre el elemento
- Bootstrap FileInput: (js/bootstrap.file-input.js) Javascript. modifica aspecto de los input file
- CKEditor: (js/libs/ckeditor) Javascript. Editor WYSIWYG
- CKFinder: (js/libs/ckfinder) Javascript. Subida de archivos integrado en CKEditor
- amCharts: (js/libs/amcharts) Javascript. Generación de gráficos
- JWPlayer: (js/libs/jwplayer) Javascript. Reproductor de video
- SwiftMailer: (includes/core/Swift-5.1.0) php. Envío de emials
- Zipfile: (includes/core/class.zipfile.php) php. Clase para generación de ficheros ZIP
- resizeImage: (includes/core/class.resizeimage.php) php. Clase para generar miniaturas de imágenes


## Estructura de archivos y directorios
La estructura de archivos y directorios básica es la siguiente:

Estructura general


    ├── bin                     - herramienta de consola
    ├── css                     - Archivos CSS principales
    ├── docs                    - directorio de almacenamiento de documentos
    ├── documentacion           - documentación sobre la comunidad
    ├── images                  - directorio para imágenes
    ├── includes
    │   ├── core                - núcleo del sistema
    │   ├── languajes           - archivos generales de traducciones
    │   └── modules             - directorio que contiene todos los módulos
    │
    └── js                      - archivos javascript generales de la comunidad


Estructura de un módulo


    ├── my_module
    │   ├── controllers         - controladores del módulo
    │   ├── pages               - páginas del módulo
    │   ├── resources           - recursos del módulo   
    │   │   ├── css             - archivos CSS del módulo   
    │   │   ├── images          - imágenes del módulo   
    │   │   ├── js              - javascripts del módulo           
    │   │   └── languages       - ficheros de idiomas del módulo 
    │   │
    │   ├── templates           - plantillas del módulo       
    │   └── class.my_module.php - acceso a la base de datos desde el módulo
    │



## Herramienta console 
Aplicación de consola para crear módulos. Uso: 
```bash 
php bin/console options
```
Opciones de console:

* [createmodule] (#createmodule)
* [findpage] (#findpage)
* [showmodules] (#showmodules)

### createmodule
Crea nuevo módulo con su estructura de directorios y ficheros básicos. Uso: 
```bash 
php bin/console createmodule
```
Tras ejecutar el comando se preguntará por el nombre del nuevo modulo.

### findpage
Encuentra una pagina. Muestra en que módulo se encuentra. Uso: 
```bash 
php bin/console findpage
```
Tras ejecutar el comando se preguntará por la página a buscar. Si la página es encontrada mostrará su ruta.

### showmodules
Muestra todos los modulos con su información. Uso: 
```bash 
php bin/console showmodules
```
Tras ejecutar el comando se mostrarán todos los modulos instalados.

## Idiomas
Soporte para idiomas implementado. Establecer idioma en includes/core/config.php. Los ficheros de traducciones se encuentran en includes/languages. Cada módulo cuenta con sus propios ficheros de traducciones en includes/modules/module_name/resources/languages.

## Debug mode
Se puede activar desde includes/core/config.php con la variable debug_app. Opciones:
- 0: debug mode desactivado
- 1: debug mode activado, salida por pantalla.
- 2: debug mode activado, salida a fichero log (includes/core/errors.log). Sólo se registrarán los errores Php y sql, no se mostrarán las sentencias sql ejecutadas con éxito.

**IMPORTANTE: desactivar debug mode en servidores de producción (debug_app = 0) o establecer salida a fichero de log (debug_app = 2).**


## Referencia API

Core
* [addCss] (#addcss)
* [addJavascripts] (#addJavascripts)
* [getAsset] (#getasset)
* [getBrowser] (#getbrowser)
* [getListModules] (#getlistmodules)
* [getPlatform] (#getplatform)
* [messageProcess] (#messageprocess)
* [noCache] (#nocache)
* [redirectURL] (#redirecturl)
* [templateload] (#templateload)

Generación y procesamiento de archivos
* [exportCsv] (#exportcsv)
* [fileToZip] (#filetozip)
* [HTMLtoPDF] (#htmltopdf)
* [uploadFileToFolder] (#uploadfiletofolder)

Sesiones
* [session::AccessLevel] (#sessionaccesslevel)
* [session::createSession] (#sessioncreatesession)
* [session::destroySession] (#sessiondestroysession)
* [session::getFlashMessage] (#sessiongetflashmessage)
* [session::setFlashMessage] (#sessionsetflashmessage)
* [session::ValidateSessionAjax] (#sessionvalidatesessionajax)

Manejo de cadenas
* [createRandomPassword] (#createrandompassword)
* [dateLong] (#datelong)
* [dateMont] (#dateMonth)
* [NormalizeText] (#normalizetext)
* [strTranslate] (#strtranslate)
* [shortText] (#shorttext)

Validaciones
* [validateDate] (#validatedate)
* [validateEmail] (#validateemail)
* [validateNifCifNie] (#validatenifcifnie)


### addCss
Agrega los ficheros Css específicos de una paguna. Uso: 
```php 
//my_page.php
addCss("css/my_page.css");
```

### addJavascripts
Agrega los ficheros JS específicos de una paguna. Uso: 
```php 
//my_page.php
addJavascripts(array("js/bootstrap.file-input.js", getAsset("my_module")."js/my_page.js"));
```
Agrega los arvivos bootstrap.file-input.js y my_page.js (perteneciente al módulo my_module)

### createRandomPassword
Genera una cadena aleatoria. Por defecto la cadena generada es alfanumérica, aunque se puede pasar como segundo parámetro los carateres permitidos. Uso: 
```php 
createRandomPassword(7);

//especificando los caracteres aleatorios
createRandomPassword(7, "abcdefghijkmnopqrstuvwxyz023456789");
```
### dateLong
Devuelve una fecha formateada con el mes con texto. Uso: 
```php 
dateLong('2014-01-14');
//mostrará -> 14 de Enero 2014
```

### dateMonth
Devuelve el mes con texto de una fecha. Uso: 
```php 
dateMonth('2014-01-14');
//mostrará -> Enero
```

### exportCsv
Exporta a CSV un array, donde $regs sera el array de registros a exportar y $file_name el nombre del archivo a generar sin la extension. Uso: 
```php 
exportCsv($regs, $file_name);
```
**IMPORTANTE:** debe colacarse al comienzo de la página ya que se envía por las cabeceras HTTP y posterior a verificación de acceso en paginas de administración o con privilegios especiales.

### fileToZip
Comprime a zip el fichero especificado por $filename alojado en la ruta $path. Uso: 
```php 
fileToZip($filename, $path);
```
**IMPORTANTE:** debe colacarse al comienzo de la página ya que se envía por las cabeceras HTTP y posterior a verificación de acceso en paginas de administración o con privilegios especiales.

### getAsset
Obtiene la ruta de los assets del módulo especificado con $modulename. Uso: 
```php 
getAsset($modulename);
```

### getBrowser
Obtiene la versión del navegador según el UserAgent. Uso: 
```php 
getBrowser($_SERVER['HTTP_USER_AGENT']);
```

### getListModules
Devuelve un array con todos los módulos instalados. Uso: 
```php 
getListModules();
```

### getPlatform
Obtiene el Sistema Operativo según el UserAgent del navegador. Uso: 
```php 
getPlatform($_SERVER['HTTP_USER_AGENT']);
```

### HTMLtoPDF
Convierte a PDF la cadena de texto en formato HTML. Uso: 
```php 
HTMLtoPDF($content, [$size]);
```
Donde $content será la cadena de texto en formato HTML a convertir a PDF. El parámetro opcional $size indica el tamaño del documento, por defecto A4.

**IMPORTANTE:** debe colacarse al comienzo de la página ya que se envía por las cabeceras HTTP y posterior a verificación de acceso en paginas de administración o con privilegios especiales.

### messageProcess
Envia un email con Swift Mailer. Uso: 
```php 
messageProcess( $message_subject, 
				$message_from = array('john@doe.com' => 'John Doe'), 
				$message_to = array('receiver@domain.org', 'other@domain.org' => 'A name'), 
				$message_body, 
				$message_attachment = null,
				$message_protocol = "smtp");
```
$message_protocol puede ser Mail(valor por defecto), smtp o Sendmail. Si en $message_protocol se emplea smpt, se utilizá la configuración SMTP establecida en el fichero de configuraciópn general config.php. Para Sendmail la configuración se establecerá igualmente en config.php.

### noCache
Envia cabeceras para eliminar la cache del navegador. Uso: 
```php 
noCache();
```

### NormalizeText
Eliminada de una cadena de texto los carateres extraños (todo lo que no sean numeros, letras y algún caracter más). Uso: 
```php 
NormalizeText($text, $text_separator);
```

### redirectURL
Redirecciona a la url especificada. Uso: 
```php 
redirectURL($url);
```

### session::AccessLevel
Establece el nivel de acceso a una determinada página. Uso: 
```php 
$perfiles_autorizados = array("admin", "formador");
session::AccessLevel($perfiles_autorizados);
```
En el ejemplo anterior se restringe el acceso a usuarios con perfil admin y formador

### session::createSession
Crea una sesión si el usuario y contraseña es correcto. Tras el inicio de sesión si el usuario tiene sus datos pendientes de confirmar se redirige a la página "user-confirm" o a otra pagina establecida por el parámetro opcional $url. Uso: 
```php 
session::createSession($usuario, $password, [$url]);
```

### session::destroySession
Destruye la sesion actual y redirecciona a la url pasada por parámetro. Uso: 
```php 
session::destroySession();
```
Si no se pasa pámetro redirige a "login".

### session::getFlashMessage
Obtiene el mensaje pasado por parámetro. Uso: 
```php 
session::getFlashMessage( 'actions_message' );
```
Una vez mostrado el mensaje  'actions_message' será borrado de la memoria flash. Para crear un mensaje flash ver [session::setFlashMessage] (#session::setflashmessage).

### session::setFlashMessage
Crea un mensaje flash. Uso: 
```php 
session::setFlashMessage( 'actions_message', 'Registro insertado correctamente', 'alert alert-success');
```
En el ejemplo se crea el mensaje flash 'actions_message' con el texto 'Registro insertado correctamente' y se le aplica la clase css 'alert alert-success'. Para recuperar un mensaje flash ver [session::getFlashMessage] (#session::getflashmessage).

### session::ValidateSessionAjax
Comprueba si un usuario esta correctamente autentificado, en caso contrario redirige a "login" o en su defecto a la página indicada por el paámetro opcional $url. Uso: 
```php 
session::ValidateSessionAjax([$url]);
```

### strTranslate
Traduce la cadena de texto pasada por parámetro en el idioma establecido por defecto. Uso: 
```php 
strTranslate($str);
```

### shortText
Acorta un texto añadiendo puntos suspensivos. Uso: 
```php 
shortText($text_html,$num_car);
```
Donde $text_html será la cadena a cortar y $num_car el numero de caracteres máximo de la cadena

### templateload
Carga la plantilla especificada con $template situada en el módulo especificado con $modulename. Uso: 
```php 
templateload($template,$modulename);
```

### uploadFileToFolder
Sube un fichero a la ruta especificada. Uso: 
```php 
uploadFileToFolder($file, $destination);
```
Donde $file será $_FILES['nombre_input_file'] y $destination el directorio donde se ha de subir la imágen

### validateDate
Comprueba si una cadena es una fecha válida según el formato especificado. Uso: 
```php 
validateDate($date, 'Y-m-d H:i:s');
```

### validateEmail
Comprueba si un texto si es o no una cuenta de correo válida. Uso: 
```php 
validateEmail($email);
```

### validateNifCifNie
Comprueba si un NIF, CIF o NIE es correcto. Devolverá:
- 1 = NIF ok
- 2 = CIF ok
- 3 = NIE ok
- -1 = NIF bad
- -2 = CIF bad
- -3 = NIE bad
- 0 = ??? incorrecto.

Uso:
```php 
checkNifCifNie($cif);
```